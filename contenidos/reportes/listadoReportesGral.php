<?php

ini_set('memory_limit', '-1');
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );
$claReporte = new Reportes();
$arrayReportes = $claReporte->obtenerlistaReportesGral('', NULL);

$claSmarty->assign("arrayReportes", $arrayReportes);
$claSmarty->display("reportes/listadoReportesGral.tpl");
//$claSmarty->assign("txtArchivoInicio", "reportes/listadoReportesGral.tpl");
?>




