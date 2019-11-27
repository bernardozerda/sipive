<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );

//pr($_POST);
// declaracion de variables necesarias
$bolCambios = false;
$arrErrores = array();

$claSeguimiento = new Seguimiento();

$claCasaMano = new CasaMano();
$arrCasaMano = $claCasaMano->cargar($_POST['seqFormulario'], $_POST['seqCasaMano']);
$claCasaMano = end($arrCasaMano);

// obtiene el nombre de la persona que ha sido atendida
foreach ($claCasaMano->objPostulacion->arrCiudadano as $objCiudadano) {
    if ($objCiudadano->numDocumento == $_POST['cedula']) {
        $_POST['nombre'] = ucwords(trim(strtolower(
                                $objCiudadano->txtNombre1 . " " .
                                $objCiudadano->txtNombre2 . " " .
                                $objCiudadano->txtApellido1 . " " .
                                $objCiudadano->txtApellido2
        )));
        break;
    }
}

// si el formulario esta abierto hay que colocar la variable porque no viene el el post solo para la fase de postulacion
if ($arrFlujoHogar['fase'] == "postulacion") {
    $_POST['bolCerrado'] = intval($_POST['bolCerrado']);
}

// detecta los cambios en el formulario
$bolCambios = $claCasaMano->cambios($_POST);

// EXISTE LA OPCION PARA EL GRUPO JURIDICO Y ADMINISTRADOR DEL SISTEMA
// FORZAR LA OPCION DE SALVAR EL SOLO SEGUIMIENTO A PESAR DE QUE
// HAYA CAMBIOS EN EL SISTEMA -- ESTO ESTA IMPLEMENTADO EN INSCRIPCION Y POSTULACION
if (intval($_POST['bolSoloSeguimiento']) == 1) {
    $bolCambios = false;
}

if ($bolCambios == true) {

    //pr($_POST);
    // Mensaje cuando hay cambios
    $txtMensaje = "<h2>Confirme que desea cambiar <br>los datos para el hogar de:</h2>";
    $txtMensaje.= "<h3>" . $_POST['nombre'] . " [ " . number_format($objCiudadano->numDocumento, 0, '.', '.') . " ]</h3>";

    $claSmarty->assign("txtMensaje", $txtMensaje);
    $claSmarty->assign("bolMostrarConfirmacion", $bolCambios);
    $claSmarty->assign("txtArchivo", $claCasaMano->arrFases[$_POST['txtFlujo']][$_POST['txtFase']]['salvar']);
    $claSmarty->assign("arrPost", $_POST);
    $claSmarty->display("desembolso/pedirConfirmacion.tpl");
} else {

    $arrIgnorarCampos[] = "txtDireccion";
    $arrIgnorarCampos[] = "txtDireccionSolucion";
    $arrIgnorarCampos[] = "numTelefono1";
    $arrIgnorarCampos[] = "numTelefono2";
    $arrIgnorarCampos[] = "numCelular";
    $arrIgnorarCampos[] = "seqCiudad";
    $arrIgnorarCampos[] = "seqUpz";
    $arrIgnorarCampos[] = "seqLocalidad";
    $arrIgnorarCampos[] = "seqBarrio";
    $arrIgnorarCampos[] = "txtCorreo";
    $arrIgnorarCampos[] = "bolDesplazado";
    
    // Se comenta campo  puesto que los cambios a estos se hacen mediante acto admon
    
//    $arrIgnorarCampos[] = "seqProyecto";
//    $arrIgnorarCampos[] = "seqProyectoHijo";
//    $arrIgnorarCampos[] = "seqUnidadProyecto";

//   $arrIgnorarCamposCiudadano[] = "seqTipoDocumento";
//   $arrIgnorarCamposCiudadano[] = "numDocumento";
    $arrIgnorarCamposCiudadano[] = "txtNombre1";
    $arrIgnorarCamposCiudadano[] = "txtNombre2";
    $arrIgnorarCamposCiudadano[] = "txtApellido1";
    $arrIgnorarCamposCiudadano[] = "txtApellido2";
    $arrIgnorarCamposCiudadano[] = "seqTipoVictima";
    
    $arrPostHogar = $_POST['hogar'];
    unset($_POST['hogar']);
    if ($_POST['txtFase'] == "postulacion") {
        foreach ($claCasaMano->objPostulacion as $txtClave => $txtValor) {
            if ($txtClave != "arrCiudadano") {
                if (!in_array($txtClave, $arrIgnorarCampos)) {
                    $_POST[$txtClave] = $txtValor;
                } else {
                    $_POST['anterior'][$txtClave] = $txtValor;
                }
            } else {
                foreach ($claCasaMano->objPostulacion->$txtClave as $seqCiudadano => $objCiudadano) {
                    $numDocumento = $objCiudadano->numDocumento;
                    if (isset($arrPostHogar[$numDocumento])) {
                        foreach ($objCiudadano as $txtCampo => $txtValue) {
                            if (!in_array($txtCampo, $arrIgnorarCamposCiudadano)) {
                                $_POST['hogar'][$numDocumento][$txtCampo] = $txtValue;
                                //unset($arrPostHogar[$numDocumento][$txtCampo]);
                            } else {
                                $_POST['anterior']['hogar'][$numDocumento][$txtCampo] = $txtValue;
                            }
                        }
                        // unset($arrPostHogar[$numDocumento]);
                    }
                }

                if (!empty($arrPostHogar)) {
                    foreach ($arrPostHogar as $numDocumento => $arrDatos) {
                        $_POST['hogar'][$numDocumento] = $arrDatos;
                    }
                }
            }
        }
    }


    try {
        $aptBd->BeginTrans();
        $claCasaMano->salvar($_POST);
        if (empty($claCasaMano->arrErrores)) {           
            $aptBd->CommitTrans();
        } else {
            $aptBd->RollbackTrans();
        }
    } catch (Exception $objErrores) {
        $aptBd->RollbackTrans();
    }

    imprimirMensajes($claCasaMano->arrErrores, $claCasaMano->arrMensajes);
}
?>
