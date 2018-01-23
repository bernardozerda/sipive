<?php

$txtPrefijoRuta = "../../../";
include($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
include($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "InformeVeedurias.class.php" );

ini_set("memory_limit","-1");

$claInforme = new InformeVeedurias();
$arrReporte = $claInforme->reporteProyectos($_GET['seqCorte']);
$claInforme->imprimirReporteProyectos($arrReporte, $_GET['seqCorte']);

?>