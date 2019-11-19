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

foreach ($claInscripcion->arrHogares as $numHogar => $arrHogar) {
   
    if ($arrHogar['seqEstadoHogar'] >= 2 && $arrHogar['seqEstadoHogar'] < 4 && $claInscripcion->seqEstado < 6) {
        $bolProcesar = true;
    } else if ($arrHogar['seqEstadoHogar'] < 4 && $claInscripcion->seqEstado < 6) {
        $bolProcesarProy = true;
    }

    $arraProy[] = $arrHogar['txtDireccionSolucion'];
}
$arraProy = array_unique($arraProy);

$claSmarty->assign("bolProcesar", $bolProcesar);
$claSmarty->assign("bolProcesarProy", $bolProcesarProy);
$claSmarty->assign("claInscripcion", $claInscripcion);
$claSmarty->assign("arraProy", $arraProy);
$claSmarty->display("inscripcionFonvivienda/informacion.tpl");
?>