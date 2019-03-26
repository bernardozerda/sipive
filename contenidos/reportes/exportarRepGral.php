<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );

$claReporte = new Reportes();
$objRes;
if ($_REQUEST['nombre']) {
    $txtNombreArchivo = explode('_', $_REQUEST['nombre']);
    $objRes = $claReporte->obtenerlistaReportesGral($_REQUEST['nombre']);   
    $claReporte->obtenerReportesGeneral($objRes, $txtNombreArchivo[0]."_");    
}

