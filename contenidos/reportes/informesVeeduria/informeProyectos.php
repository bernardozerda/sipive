<?php

$txtPrefijoRuta = "../../../";
include($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
include($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "InformeVeedurias.class.php" );

$claInforme = new InformeVeedurias();
$arrReporte = $claInforme->reporteProyectos($_POST['seqCorte']);

//pr($arrReporte);

$claInforme->imprimirReporteProyectos($arrReporte);

?>