<?php

$txtPrefijoRuta = "../../../";
include($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
include($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "InformeVeedurias.class.php" );

include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );

ini_set("memory_limit","-1");

$claInforme = new InformeVeedurias();

//$t1 = time();

$arrReporte = $claInforme->reporteNoProyectos($_GET['seqCorte']);

//$t2 = time();

$claInforme->imprimirReporteNoProyectos($arrReporte,$_GET['seqCorte']);

//$t3 = time();
//
//echo "T1 => " . ($t2 - $t1) . "<br>";
//echo "T2 => " . ($t3 - $t2) . "<br>";



?>