<?php
//var_dump($_REQUEST); die();
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );

$claReporte = new Reportes();
$objRes;
if ($_REQUEST['nombre']) {
   // echo "<br>paso ->".$_REQUEST['nombre'];
   $claReporte->reporteMensualActosAdmon();
}

