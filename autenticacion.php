<?php


/**
 * ESTE ES EL INICIO DEL APLICATIVO, SI NO HAY SESION
 * ACTIVA, EL INDEX REDIRECCIONA AQUI.
 * AQUI SE REALIZAN LAS TAREAS DE AUTENTICACION
 * @author Bernardo Zerda
 * @version 1.0 Abril 2009
 */
session_start();


define("TIMEOUT", 1800); // Tiempo de valides de la sesion en segundos ( 30 minutos )
// Elimina la session y las cookies si estan activas

if (isset($_SESSION["sdhtsdv"]) or isset($_COOKIE['sdhtsdv'])) {
    unset($_SESSION["sdhtsdv"]);
    setcookie("sdhtsdv", 1, time() - TIMEOUT, "/", null, false, false);
    session_destroy();
    unset($_POST);
}

// verifica que este en https
$_SERVER['HTTPS'] = "on";

if (strtolower(trim($_SERVER['HTTPS'])) != "on") {
    header("Location: ./redireccionamiento.php");
}

// Ruta relativa 
$txtPrefijoRuta = "./";

// Archivos necesarios
include("./recursos/archivos/lecturaConfiguracion.php" );
include($txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Usuario.class.php" );
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Autenticacion.class.php" );
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "RegistroActividades.class.php" );
include($txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include($txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

// Arreglo de errores
$arrErrores = array();

$bolCambioClave = false;

// cuando viene esta variable es porque se ha intentado autenticarse
if (isset($_POST['btnSalvar']) and intval($_POST['btnSalvar']) == 1) {

    /**
     * INICIA EL PROCESO DE VALIDACION
     */
    // Valida el nombre de usuario
    if (!isset($_POST['usuario']) or $_POST['usuario'] == "") {
        $arrErrores['usuario'] = "El usuario es campo requerido";
    }

    // Valida la clave
    if (!isset($_POST['clave']) or $_POST['clave'] == "") {
        $arrErrores['clave'] = "La clave es campo requerido";
    }

    // Valida el punto de atencion
    if ($_POST['seqPuntoAtencion'] == 1) {
        $arrErrores['punto'] = "La ubicaci&oacute;n no es v&aacute;lida";
    }
    // $_SESSION['codigo']." !=". $_POST['codigo'];
    // Valida el codigo Captcha
    if (( $_SESSION['codigo'] != $_POST['codigo'] ) or empty($_SESSION['codigo'])) {


        $arrErrores['codigo'] = "El codigo no coincide";
        // INICIO GUARDA DIRECCION IP Y DIRECCION MAC DEL INTENTO DE AUTENTICACION (TEMPORAL)
        if ($_POST['usuario'] == 'obonillaq') {
            $hostName = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $REMOTE_ADDR = $hostname;
            $ip = $REMOTE_ADDR;
            $ipLocal = GetHostByName($ip);
            // Insert
            mysql_query("INSERT INTO T_COR_INTENTO (txtUsuario, txtClaveDigitada, txtDireccionIP, txtHostName, txtTipo, fchIntento) VALUES ('" . $_POST['usuario'] . "', '" . $_POST['clave'] . "', '" . $ipLocal . "', '" . $hostName . "', 'captcha', NOW())");
        }
    }

    /**
     * INICIA EL PROCESO DE AUTENTICACION 
     */
    // De no haber errores en la validacion inicia el proceso

    if (empty($arrErrores)) {

        // Clases necesarias
        $claAutenticacion = new Autenticacion;

        $claRegistro = new RegistroActividades;

        // Obtiene los datos del usuario
        $arrUsuario = $claAutenticacion->datosUsuario($_POST['usuario'], $_POST['clave']);
        $seqUsuario = intval(array_shift(array_keys($arrUsuario)));
        $objUsuario = $arrUsuario[$seqUsuario];

        // Si los datos no pueden ser obtenidos es porque el usuario no existe
        // o la clave digitada no es la correcta
        if (empty($arrUsuario)) {

            // Sumar intentos fallidos y si son mas de tres bloquear el usuario
            $_SESSION['intentoFallido'] ++;
            if ($_SESSION['intentoFallido'] > 3) {
                unset($_SESSION['intentoFallido']);
                $arrErrores = $claAutenticacion->bloquearUsuario($_POST['usuario']);
                if (empty($arrErrores)) {
                    $claRegistro->registrarActividad("Usuario Bloqueado", 0, 0, "Usuario: " . $_POST['usuario'] . " Mensaje: Usuario Bloqueado");
                } else {

                    $claRegistro->registrarActividad("Usuario Bloqueado", 0, 0, "Usuario: " . $_POST['usuario'] . " Mensaje: Fallo el bloqueo del usuario, posible error en la tabla ");
                }
            }

            // Registra el intento fallido
            $arrErrores['otros'] = $claAutenticacion->arrErrores;
            $claRegistro->registrarActividad("Autenticacion Fallida", 0, 0, "Usuario: " . $_POST['usuario'] . " Mensaje: " . implode(",", $arrErrores['otros']));
        } else {


            // Reinicia los intetntos fallidoss
            unset($_SESSION['intentoFallido']);

            // Verifica si es necesario cambiar la clave
            if (strtotime($objUsuario->fchVencimiento) < strtotime(date("Y-m-d"))) {

                // ver el codigo del popup al final del codigo
                // se puso alla para que cargue despues de la plantilla
                // porque cuando carga antes no cargan bien las css
                // y el formulario no se ve bien
                $bolCambioClave = true;
            } else {

                // Obtiene las Proyectos-grupos a los que esta vinculado el usuario
                $arrProyectoGrupos = array();
                if (!empty($objUsuario->arrGrupos)) {
                    foreach ($objUsuario->arrGrupos as $seqProyecto => $arrGrupos) {
                        foreach ($arrGrupos as $seqGrupo => $seqProyectoGrupo) {
                            $arrProyectoGrupos[] = $seqProyectoGrupo;
                        }
                    }
                }


                // Verifica que el usuario tenga perfiles habilitados
                // Puede que la Proyecto, o los grupos a los que el usuario pertenece
                // esten inactivos
                if (empty($arrProyectoGrupos)) {
                    $arrErrores['otros'][] = "El usuario no tiene relacion con ninguna Proyecto, reporte este error al administrador";
                } else {


                    // Verifica que tenga acceso a las opciones de menu (permisos)
                    $arrPermisos = $claAutenticacion->permisosUsuario($arrProyectoGrupos);

                    if (empty($arrPermisos)) {
                        $arrErrores['otros'][] = "No se le ha otorgado privilegios de acceso en este aplicativo, consulte al administrador del sistema";
                    } else {

                        // Registra algunos datos en la session
                        $_SESSION['seqUsuario'] = $seqUsuario;
                        $_SESSION['txtNombre'] = $objUsuario->txtNombre;
                        $_SESSION['txtApellido'] = $objUsuario->txtApellido;
                        $_SESSION['arrPermisos'] = $arrPermisos;
                        $_SESSION['seqPuntoAtencion'] = $_POST['seqPuntoAtencion'];
                        $_SESSION['idioma'] = "es";
                        $_SESSION['arrGrupos'] = $objUsuario->arrGrupos;
                        $_SESSION['txtUsuario'] = $objUsuario->txtUsuario;

                        // Privilegios sobre los datos
                        $_SESSION['privilegios']['crear'] = $objUsuario->bolCrear;
                        $_SESSION['privilegios']['editar'] = $objUsuario->bolEditar;
                        $_SESSION['privilegios']['borrar'] = $objUsuario->bolBorrar;
                        $_SESSION['privilegios']['cambiar'] = $objUsuario->bolCambiar;

                        // Registra el intento exitoso de autenticacion
                        $claRegistro->registrarActividad("Autenticacion Exitosa", 0, $seqUsuario, "Usuario: " . $_POST['usuario'] . " Nombre: " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido);
                    }
                }
            }
        }
    }


    // Registrar sesion
    if (empty($arrErrores) and isset($_SESSION['seqUsuario'])) {

        // Registra la cookie
        $bolCookie = setcookie(
                "sdhtsdv", 1, time() + TIMEOUT, "/", null, false, // true para produccion
                false              // true para produccion
        ); // Cookie Real

        setcookie(
                "validar", time() + TIMEOUT, time() + TIMEOUT, "/", null, false, // true para produccion
                false              // true para produccion
        ); // Cookie para validar el tiempo de vida de la sesion

        if ($bolCookie) {


            //session_register( "sdhtsdv" );
            $session['sdhtsdv'] = 'sdhtsdv';

            // si no es el super administrador lo envia al index.php
            // de lo contrario le muestra el panel de control

            if ($_SESSION['seqUsuario'] != 1) {

                header("Location:./index.php");
            } else {
                header("Location:./panelControl.php");
            }
        } else { // Error registrando la cookie
            $arrErrores['otros'][] = "No se ha podido registrar la sesion";
            //session_unregister( "sdhtsdv" );
            $session['sdhtsdv'] = 'sdhtsdv';
            setcookie(
                    "sdhtsdv", 1, time() - TIMEOUT, "/", null, false, // true para produccion
                    false              // true para produccion
            );
            session_destroy();
        }
    }
}

// Recogiendo los posibles sitios
$sql = "
		SELECT
			seqPuntoAtencion,
			txtPuntoAtencion
		FROM 
			T_FRM_PUNTO_ATENCION
		WHERE
			seqPuntoAtencion > 1 and bolMostrar = 1
                        
		ORDER BY
			txtPuntoAtencion ASC		
	";
$arrPuntos = array();
$arrPuntos[1] = "Ninguno";
$objRes = $aptBd->execute($sql);
while ($objRes->fields) {

    $arrPuntos[$objRes->fields['seqPuntoAtencion']] = $objRes->fields['txtPuntoAtencion'];
    $objRes->MoveNext();
}


// Datos para el tama�o de la imagen captcha
$numAncho = 200;
$numAlto = 50;
$numLetras = 4;

// Asignacion de variables a las plantillas
$claSmarty->assign("numAncho", $numAncho);
$claSmarty->assign("numAlto", $numAlto);
$claSmarty->assign("numLetras", $numLetras);
$claSmarty->assign("arrErrores", $arrErrores);
$claSmarty->assign("arrPost", $_POST);
$claSmarty->assign("txtRutaCaptcha", $txtPrefijoRuta . $arrConfiguracion['librerias']['captcha'] . "CaptchaSecurityImages.php");
$claSmarty->assign("txtRutaImagenes", $txtPrefijoRuta . $arrConfiguracion['carpetas']['imagenes']);
$claSmarty->assign("arrPuntos", $arrPuntos);

// Plantilla a mostrar
$claSmarty->display("autenticacion.tpl");

/**
 * ESTE ES EL POPUP DE CAMBIO DE CLAVE
 * SE CARGA DESPUES PARA QUE LA PLANTILLA
 * PONGA LAS CSS Y NO SE TIRE LA 
 * VISUALIZACION DEL FORMULARIO
 */
if ($bolCambioClave) {
    echo "
         <div id=\"cambioClave\" class=\"modal hide fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\" style=\"display: none;\">
            <form id=\"frmCambioClave\" class=\"form-horizontal\">
               <div class=\"modal-header\">
                   <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>
                   <h3 id=\"myModalLabel\">Debe Cambiar la Clave</h3>
               </div>
               <div class=\"modal-body\">
                  <p id=\"mensajeCambio\" class=\"text-center alert alert-info\">
                     La clave que actualmente tiene ha vencido y debe cambiarla
                  </p>
                  <div class=\"control-group\">
                     <label class=\"control-label\" for=\"usuarioCambio\">Usuario</label>
                     <div class=\"controls\">
                        <input type=\"text\" id=\"usuarioCambio\" name=\"usuarioCambio\" value=\"" . $objUsuario->txtUsuario . "\" readonly>
                     </div>
                  </div>
                  <div class=\"control-group\">
                     <label class=\"control-label\" for=\"actual\">Clave Actual</label>
                     <div class=\"controls\">
                        <input type=\"password\" id=\"actual\" name=\"actual\" onBlur=\"this.value = ( this.value != '' )? hex_sha1( this.value ) : '' ;\" required>
                     </div>
                  </div>
                  <div class=\"control-group\">
                     <label class=\"control-label\" for=\"nueva\">Clave Nueva</label>
                     <div class=\"controls\">
                        <input type=\"password\" id=\"nueva\" name=\"nueva\" onKeyUp=\"passwordChanged( this );\" required>
                        <span id='fortaleza' style='width:90px'></span>
                     </div>
                  </div>
                  <div class=\"control-group\">
                     <label class=\"control-label\" for=\"confirmacion\">Confirme la clave</label>
                     <div class=\"controls\">
                        <input type=\"password\" id=\"confirmacion\" name=\"confirmacion\" onKeyUp=\"encriptarCadena( 'nueva' , 'confirmacion' );\" required>
                        <span id='compararClaves' style='width:90px'></span>
                     </div>
                  </div>
               </div>
               <div class=\"modal-footer\">    
                  <button type=\"submit\" class=\"btn\">
                     Aceptar
                  </button>
                  <button class=\"btn btn-primary\" data-dismiss=\"modal\" aria-hidden=\"true\">
                     Cancelar
                  </button>
               </div>
            </form>
         </div>  
      ";
}
?>
