<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
/*include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );*/
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ProyectoVivienda.class.php" );

$bolMostrarConfirmacion = true;
$arrErrores = array();

$txtMensaje = "Es necesario que confirme la accion que esta apunto de realizar:";
$txtMensaje.= "<div class='msgOk' style='font-size:12px;'>¿Desea actualizar el proyecto " . $_POST['txtNombreProyecto'] . "?</div>";

if (is_numeric($_POST['seqFormularioEditar']) == true) {

    $claProyecto = new ProyectoVivienda;
    $claProyecto->cargarProyectoVivienda($_POST['seqFormularioEditar']);

    $bolCambiaDatos = false;

    // Campos que se pueden cambiar sin privilegios
    /*$arrCamposLibres[] = "txtDireccion";
    $arrCamposLibres[] = "numTelefono1";
    $arrCamposLibres[] = "numTelefono2";
    $arrCamposLibres[] = "numCelular";
    $arrCamposLibres[] = "seqLocalidad";
    $arrCamposLibres[] = "txtBarrio";
    $arrCamposLibres[] = "txtCorreo";
	$arrCamposLibres[] = "seqLocalidad";
	$arrCamposLibres[] = "seqBarrio";
	$arrCamposLibres[] = "seqUpz";
	$arrCamposLibres[] = "seqTipoVictima";*/

    $arrCamposCambiados = array();

    if ($_POST['txtArchivo'] == "./contenidos/proyectos/salvarProyectoVivienda.php") {

        // Cambios en los datos del ciudadano
		/*$arraynombrecampos = array();
        foreach ($claProyecto->arrProyectoVivienda as $seqProyecto => $objProyectoVivienda) {
			//foreach ($objCiudadano as $txtClave => $txtValor) {
				//if ($txtClave == 'seqParentesco' && $txtValor == 1){
					if (isset($_POST[$txtClave])) {
						if ($objProyectoVivienda->$txtClave != $_POST[$txtClave]) {
							$arrCamposCambiados[] = $txtClave;
							$arraynombrecampos[] = $txtClave;
							$bolCambiaDatos = true;
						}
					}
				//}
			//}
        }*/
		//var_dump($arraynombrecampos);
        //var_dump($arrCamposCambiados);

        // Cambios en los datos del formulario
        unset($claFormulario->arrCiudadano);
        //$arraynombrecampos = array();
        foreach ($claFormulario as $txtClave => $txtValor) {
            if (isset($_POST[$txtClave])) {
				$valFormateado = str_replace(".", "", $_POST[$txtClave]);
                if ($txtValor != $valFormateado) {
					//echo $txtClave . 'txtValor: ' . $txtValor . '-->' . $valFormateado . '<br>';
                    //$arrCamposCambiados[] = $txtClave;
                    //$arraynombrecampos[] = $txtClave;
                    $bolCambiaDatos = true;
				}
			}
		}
        //var_dump($arraynombrecampos);
        //var_dump($arrCamposCambiados);

        // si los cambios son solo sobre los campos libres
        // se considera que no hay cambios y se realiza la modificacion
        $bolCambiosLibres = true;

        foreach ($arrCamposCambiados as $txtCampoCambiado) {
            if (!in_array($txtCampoCambiado, $arrCamposLibres)) {
                $bolCambiosLibres = false;
            }
        }

        // si los campos son solo sobre los campos libres UNICAMENTE
        // se considera que no hay cambios y se realiza la modificacion
        if ($bolCambiosLibres and !$bolCambiaDatosMiembroHogar) {
            $bolCambiaDatos = false;
        }

        // si no hay cambios no muestra la ventana de confirmacion
        if ($bolCambiaDatos) {
            $txtMensaje = "Es necesario que confirme la accion que esta apunto de realizar:";
            $txtMensaje.= "<div class='msgError' style='font-size:12px;'>¿Desea modificar la inscripción para el documento " . $_POST['numDocumento'] . "?</div>";
            $numDocumentoHogar = $_POST['numDocumento'];
        } else {
            $bolMostrarConfirmacion = false;
            $numDocumentoAtendido = $objCiudadano->numDocumento;
            $txtCiudadanoAtendido = $objCiudadano->txtNombre1 . " " . $objCiudadano->txtNombre2 . " " .
            $objCiudadano->txtApellido1 . " " . $objCiudadano->txtApellido2;
        }
    } else { // para postualcion

    }
}


// Si hubo cambios en el formulario muestra el pop up de confirmacion
if ($bolMostrarConfirmacion) {
	if ($_POST["bolSancion"] == 1) {
		$numDocumentoHogar = number_format($numDocumentoHogar, 0, '.', ',');
		$arrErrores[] = "No se puede modificar la postulacion del miembro de hogar $numDocumentoHogar debido a que esta Sancionado.";
		imprimirMensajes($arrErrores, array());
	} else {
		$claSmarty->assign("txtMensaje", $txtMensaje);
		$claSmarty->assign("bolMostrarConfirmacion", $bolMostrarConfirmacion);
		$claSmarty->assign("txtArchivo", $_POST['txtArchivo']);
		$claSmarty->assign("arrPost", $_POST);
		$claSmarty->display("proyectos/pedirConfirmacion.tpl");
	}
} else {
    // Grupo de Gestion 
    if ($_POST['seqGrupoGestion'] == 0) {
        $arrErrores[] = "Seleccione el grupo de la gestión realizada";
    }

    // Grstion
    if ($_POST['seqGestion'] == 0) {
        $arrErrores[] = "Seleccione la gestión realizada";
    }

    // Comentarios
    if ($_POST['txtComentario'] == "") {
        $arrErrores[] = "Por favor diligencie el campo de comentarios";
    }

    // direccion de residencia
    if ($_POST['txtDireccion'] == "") {
        $arrErrores[] = "Debe dar una direcci&oacute;n";
    }

	// Hecho victimizante obligatorio si el hogar es victima
	/*if( $_POST['bolDesplazado'] == 1 && $_POST['seqTipoVictima'] == 0){
	    $arrErrores[] = "Debe tener un hecho Victimizante";
	}*/

	// Si hay correo electronico debe ser valido
	if( $_POST['txtCorreo'] != "" ){
	    if( ! ereg( "^[0-9a-zA-Z._\-]+\@[a-zA-Z0-9._\-]+\.([a-zA-z]{2,4})(([\.]{1})([a-zA-Z]{2}))?$" , trim( $_POST['txtCorreo'] ) ) ){
	        $arrErrores[] = "No es un correo electr&oacute;nico v&aacute;lido";
	    }
	}

	// OBLIGA A CAMBIAR LA MODALIDAD SI ES PLAN GOBIERNO 2 Y TIENE MODALIDAD DEL PLAN GOBIERNO 1
	/*if( $_POST['seqModalidad'] == 1 && $_POST['seqPlanGobierno'] == 2){
		$arrErrores[] = "Debe cambiar la modalidad";
	}

	if( $_POST['seqModalidad'] == 2 && $_POST['seqPlanGobierno'] == 2){
		$arrErrores[] = "Debe cambiar la modalidad";
	}

	if( $_POST['seqModalidad'] == 3 && $_POST['seqPlanGobierno'] == 2){
		$arrErrores[] = "Debe cambiar la modalidad";
	}

	if( $_POST['seqModalidad'] == 4 && $_POST['seqPlanGobierno'] == 2){
		$arrErrores[] = "Debe cambiar la modalidad";
	}

	if( $_POST['seqModalidad'] == 5 && $_POST['seqPlanGobierno'] == 2){
		$arrErrores[] = "Debe cambiar la modalidad";
	}*/

	// SeqSolucion
	if( $_POST['seqSolucion'] == ""){
		$arrErrores[] = "Debe tener una Solución";
	}

	// Telefono o celular
	$exregfijo = "/^[0-9]{7}$/";
	$exregcel = "/^[3]{1}[0-9]{9}$/";
	if ($_POST['numTelefono1'] == "" and $_POST['numCelular'] == "") {
		$arrErrores[] = "El ciudadano debe tener un telefono de contacto";
	} else {
		if ($_POST['numTelefono1'] != "" && $_POST['numTelefono1'] != 0) {
			if (!preg_match($exregfijo, $_POST['numTelefono1'])) {
				$arrErrores[] = "El Numero Telefonico no puede ser menor ni mayor a 7 digitos";
			}
		}
		if ($_POST['numCelular'] != "" && $_POST['numCelular'] != 0) {
			if (!preg_match($exregcel, $_POST['numCelular'])) {
				$arrErrores[] = "El Numero celular no puede ser menor ni mayor a 10 digitos y debe empezar por 3";
			}
		}
	}

    // Campos opcionales
    $_POST['numTelefono2'] = ( $_POST['numTelefono2'] == "" ) ? 0 : $_POST['numTelefono2'];
    $_POST['numCelular'] = ( $_POST['numCelular'] == "" ) ? 0 : $_POST['numCelular'];

    // errores de validacion
    if (empty($arrErrores)) {

        // formulario original para ser comparado con los cambios libres
        $claFormulario = new ProyectoVivienda;
        $claFormulario->cargarFormulario($_POST['seqFormularioEditar']);

        // formulario que sera alterado con los cambios libres para salvar estas modificaciones
        $claFormularioCambio = new ProyectoVivienda;
        $claFormularioCambio->cargarFormulario($_POST['seqFormularioEditar']);

        // campos libres modificados
        $claFormularioCambio->txtDireccion = $_POST["txtDireccion"];
        $claFormularioCambio->numTelefono1 = $_POST["numTelefono1"];
        $claFormularioCambio->numTelefono2 = $_POST["numTelefono2"];
        $claFormularioCambio->numCelular = $_POST["numCelular"];
        $claFormularioCambio->seqLocalidad = ( intval($_POST["seqLocalidad"]) == 0 ) ? 1 : $_POST["seqLocalidad"];
        $claFormularioCambio->txtBarrio = $_POST["txtBarrio"];
        $claFormularioCambio->fchUltimaActualizacion = date("Y-m-d H:i:s");
        $claFormularioCambio->txtCorreo = $_POST["txtCorreo"];
		//$claFormularioCambio->bolDesplazado = $_POST["bolDesplazado"];
		//$claFormularioCambio->seqTipoVictima = $_POST["seqTipoVictima"];

        // Cambios necesarios para la actualizacion
        $claFormularioCambio->seqProyecto = ( $_POST['seqProyecto'] == 0 ) ? "null" : $_POST['seqProyecto'];

        // Salvando los cambios modificados
        $claFormularioCambio->editarFormulario($_POST['seqFormularioEditar']);

        if (empty($claFormularioCambio->arrErrores)) {

            // obtiene los cambios para dejar el registro
            $claSeguimiento = new Seguimiento;
            $txtCambios = $claSeguimiento->cambiosPostulacion($_POST['seqFormularioEditar'], $claFormulario, $claFormularioCambio);

            $numDocumentoAtendidoFormat = str_replace(".", "", $numDocumentoAtendido);

            $sql = "
					INSERT INTO T_SEG_SEGUIMIENTO ( 
						seqFormulario, 
						fchMovimiento, 
						seqUsuario, 
						txtComentario, 
						txtCambios, 
						numDocumento, 
						txtNombre, 
						seqGestion
					) VALUES (
						" . $_POST['seqFormularioEditar'] . ",
						now(),
						" . $_SESSION['seqUsuario'] . ",
						\"" . ereg_replace("\n", "", $_POST['txtComentario']) . "\",
						\"$txtCambios\",
						" . $numDocumentoAtendidoFormat . ",
						\"" . $txtCiudadanoAtendido . "\",
						" . $_POST['seqGestion'] . "
					)					
				";

            try {
                $aptBd->execute($sql);
                $seqSeguimiento = $aptBd->Insert_ID();
            } catch (Exception $objError) {
                $arrErrores[] = "No se ha podido registrar la actividad del hogar, contacte al administrador";
            }
        } else {
            $arrErrores = $claFormularioCambio->arrErrores;
        } // fin errores en los cambios del formulario libres
    } // fin errores de validacion

    if (empty($arrErrores)) {
        $arrMensajes[] = "Ha salvado un registro de actividad, el numero del registro es " . number_format($seqSeguimiento, 0, ".", ",") .
                ". Conserve este número para su referencia.";
        imprimirMensajes(array(), $arrMensajes);
    } else {
        imprimirMensajes($arrErrores, array());
    }
}
?>
