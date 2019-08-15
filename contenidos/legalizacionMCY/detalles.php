<?php

ob_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "LegalizacionMCY.class.php" );

$claLegalizacionMcy = new LegalizacionMCY();
$claReporte = new Reportes();
$fecha = $_REQUEST['fchCreacion'];
$objRes = $claLegalizacionMcy->datosDetalles($fecha);
//var_dump($objRes); die();
$claReporte->obtenerReportesGeneral($objRes, 'reporteMCY_');
ob_end_flush();
