<?php

/**
 * PIDE CONFIRMACION DE LOS CAMBIOS GENERADOS EN EL FORMULARIO
 * DE INSCRIPCION Y EL FORMULARIO DE ACTUALIACION
 * SI NO HAY CAMBIOS EN EL FORMULARIO SOLO GRABA EL SEGUIMIENTO
 * --  EL PEDIRCAMBIOS DE POSTULACION ESTA EN CASAMANO/PEDIRCONFIRMACION
 */
$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );

$bolConfirmacion = false;
$arrErrores = array();
$arrMensajes = array();

// regularizando campos
foreach( $_POST as $txtCampo => $txtValor ){
    $_POST[$txtCampo] = regularizarCampo($txtCampo,$txtValor);
}

// Nombre y cedula de quien fue atendido
$txtNombreAtendido = Ciudadano::obtenerNombre($_POST['numDocumento']);
if( $txtNombreAtendido == "" ){
    $txtNombreAtendido  = trim($_POST['txtNombre1']) . " ";
    $txtNombreAtendido .= ( trim( $_POST['txtNombre2'] == "" ) )? "" : trim( $_POST['txtNombre2'] ) . " ";
    $txtNombreAtendido .= trim($_POST['txtApellido1']) . " ";
    $txtNombreAtendido .= ( trim( $_POST['txtApellido2'] == "" ) )? "" : trim( $_POST['txtApellido2'] ) . " ";
}
$numDocumentoAtendido = $_POST['numDocumento'];

/************************************************************************************************************
 * NO HAY VERIFICACION DE CAMBIOS SOBRE EL FORMULARIO DE INSCRIPCION
 * POR DEFINICION ESTE FORMULARIO SE USA CUANDO EL HOGAR SE INSCRIBE POR PRIMERA VEZ
 * NO EXITE REGISTRO EN LA BASE DE DATOS CONTRA QUE SE PUEDA COMPARAR
 ************************************************************************************************************/

if (trim($_POST['txtArchivo']) == "./contenidos/subsidios/salvarInscripcion.php") {
    $bolConfirmacion = true;
}

/************************************************************************************************************
 * VERIFICACION DE CAMBIOS AL FORMULARIO DE ACTUALIZACION
 ************************************************************************************************************/

if (trim($_POST['txtArchivo']) == "./contenidos/subsidios/salvarActualizacion.php") {

    $claSeguimiento = new Seguimiento();

    // Campos que se pueden modificar sin restricciones
    $claSeguimiento->arrIgnorarCampos[] = "txtDireccion";
    $claSeguimiento->arrIgnorarCampos[] = "txtDireccionSolucion";
    $claSeguimiento->arrIgnorarCampos[] = "numTelefono1";
    $claSeguimiento->arrIgnorarCampos[] = "numTelefono2";
    $claSeguimiento->arrIgnorarCampos[] = "numCelular";
    $claSeguimiento->arrIgnorarCampos[] = "seqCiudad";
    $claSeguimiento->arrIgnorarCampos[] = "seqUpz";
    $claSeguimiento->arrIgnorarCampos[] = "seqLocalidad";
    $claSeguimiento->arrIgnorarCampos[] = "seqBarrio";
    $claSeguimiento->arrIgnorarCampos[] = "txtCorreo";

    $txtCambios = $claSeguimiento->cambiosPostulacion( $_POST );
    $bolConfirmacion = ( trim($txtCambios) == "" )? false : true;

    // LAS ORIENTACIONES REALIZADAS POR EL INFORMADOR
    // A LOS HOGARES QUE SE REGISTREN CON LA GESTIÓN
    // -- ORIENTACION PROGRAMA "MI CASA YA" --
    // NO SERAN OBJETO DE VALIDACION DEL FORMULARIO
    // PERO SI GUARDARAN LOS DATOS DE CONTACTO
    // SI REALIZAN CAMBIOS AL RESTO DE DATOS SERAN IGNORADOS
    if( $_POST['seqGestion'] == 107 ){
        $bolConfirmacion = false;
    }


}

/* * **********************************************************************************************************
 * MOSTRAR EL CUADRO DE CONFIRMACION DE DATOS
 * ********************************************************************************************************** */

//echo $txtCambios;
//var_dump($bolConfirmacion); die();

if ($bolConfirmacion == true) {

    // Mensaje cuando hay cambios
    $txtMensaje = "<h2>Confirme que desea salvar <br>los datos para el hogar de:</h2>";
    $txtMensaje.= "<h3>" . ucwords($txtNombreAtendido ) . " [ " . number_format($numDocumentoAtendido,0,'.','.') . " ]</h3>";

    $claSmarty->assign( "txtMensaje" , $txtMensaje );
    $claSmarty->assign( "bolMostrarConfirmacion" , $bolConfirmacion );
    $claSmarty->assign( "txtArchivo" , $_POST['txtArchivo'] );
    $claSmarty->assign( "arrPost" , $_POST );
    $claSmarty->display("subsidios/pedirConfirmacion.tpl");

} else {

    $claFormulario = new FormularioSubsidios();
    $claFormulario->cargarFormulario( $_POST['seqFormulario'] );

    $claFormulario->txtBarrio = array_shift(
        obtenerDatosTabla(
            "T_FRM_BARRIO",
            array("seqBarrio","txtBarrio"),
            "seqBarrio",
            "seqBarrio = " . $_POST['seqBarrio']
        )
    );

    foreach ($claFormulario as $txtClave => $txtValor) {
        if ($txtClave != "arrCiudadano") {
            if( array_key_exists( $txtClave , $_POST ) and in_array( $txtClave , $claSeguimiento->arrIgnorarCampos )  ) {
                $claFormulario->$txtClave = regularizarCampo($txtClave, $_POST[$txtClave]);
            }
        }
    }

    $claFormulario->fchUltimaActualizacion = date("Y-m-d H:i:s");
    $claFormulario->editarFormulario($_POST['seqFormulario']);
    if( ! empty( $claFormulario->arrErrores ) ) {
        $arrErrores = $claFormulario->arrErrores;
    }else{
        $_POST['nombre'] = $txtNombreAtendido;
        $_POST['cedula'] = $numDocumentoAtendido;
        $claSeguimiento->salvarSeguimiento($_POST, "cambiosPostulacion");
        if( empty( $claSeguimiento->arrErrores ) ){
            $arrMensajes = $claSeguimiento->arrMensajes;
        }else{
            $arrErrores = $claSeguimiento->arrErrores;
        }
    }

    imprimirMensajes( $arrErrores , $arrMensajes );

}
?>
