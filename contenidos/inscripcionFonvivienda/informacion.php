<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "InscripcionFonvivienda.class.php" );

$claInscripcion = new InscripcionFonvivienda();
$claInscripcion->cargar($_POST['seqCargue']);

$bolProcesar = false;
$bolProcesarProy = false;
$arraProy = Array();
$arrPryProcess = Array();

foreach ($claInscripcion->arrHogares as $numHogar => $arrHogar) {

    if ($arrHogar['seqEstadoHogar'] == 2) {
        $bolProcesar = true;
    } 
    if ($arrHogar['seqEstadoHogar'] < 3) {
        $bolProcesarProy = true;
    }

    $arraProy[] = trim($arrHogar['txtDireccionSolucion']);

    if ($arrHogar['txtEstadoHogar'] == 'No procesar') {
        $arrPryProcess[$arrHogar['txtDireccionSolucion']] = true;
    }
}

$arraProy = array_unique($arraProy);
//$arrPryProcess = array_unique($arrPryProcess);
//pr($arrPryProcess);
$claSmarty->assign("bolProcesar", $bolProcesar);
$claSmarty->assign("bolProcesarProy", $bolProcesarProy);
$claSmarty->assign("claInscripcion", $claInscripcion);
$claSmarty->assign("arraProy", $arraProy);
$claSmarty->assign("arrPryProcess", $arrPryProcess);
$claSmarty->display("inscripcionFonvivienda/informacion.tpl");
?>