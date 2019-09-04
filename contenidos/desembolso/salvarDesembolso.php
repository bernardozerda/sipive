<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Grupo.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Desembolso.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos2.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );

unset($_POST['confirmacion']);

// zona horaria para las fechas que maneja el aplicativo
date_default_timezone_set("America/Bogota");

// datos que tiene en comun todas las fases
include( "./datosComunes.php" );

// Carga los Datos del hogar y postulacion
$claFormulario = new FormularioSubsidios;
$claFormulario->cargarFormulario($_POST['seqFormulario']);

// Datos de desembolso para este hogar
$claDesembolso = new Desembolso;
$claDesembolso->cargarDesembolso($_POST['seqFormulario']);

// Obtiene el codigo que debe proceder para salvar / actualizar el registro
$claFlujoDesembolso = new FlujoDesembolso($_POST['seqFormulario']);
$arrCodigo = $claFlujoDesembolso->obtenerCodigo($_POST['txtFlujo'], $claFormulario->seqEstadoProceso, $_POST['fase']);

// Detectar los errores
$arrErrores = array();

if ($_POST['seqGrupoGestion'] == 0) {
    $arrErrores[] = "Debe indicar un grupo de gesti&oacute;n";
}

if ($_POST['seqGestion'] == 0) {
    $arrErrores[] = "Debe indicar la gestion realizada";
}

if (trim($_POST['txtComentario']) == "") {
    $arrErrores[] = "Describa la gestion realizadada en los comentarios";
}

// Llama al codigo correspondiente	
if (empty($arrErrores)) {
    include( $arrCodigo['salvar'] );
} else {
    imprimirErrores($arrErrores);
}
?>
