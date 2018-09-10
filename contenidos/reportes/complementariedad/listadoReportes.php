<?php

$txtPrefijoRuta = "../../../";
include($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
include($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );

$arrReporte = array();

$arrReporte['crucesFnv']['funcion'] = "crucesFnv";
$arrReporte['crucesFnv']['titulo'] = "Reporte Cruces Mi Casa Ya";
$arrReporte['crucesFnv']['descripcion'] = "Beneficiarios y cruces para el reporte de Mi casa ya, formato Transunion";
$arrReporte['crucesFnv']['url'] = null;

$arrReporte['excepcionesFnv']['funcion'] = "excepcionesFnv";
$arrReporte['excepcionesFnv']['titulo'] = "Reporte Excepciones Mi Casa Ya";
$arrReporte['excepcionesFnv']['descripcion'] = "Información de los hogares reportados en los cruces que han sido levantados, formato Transunion";
$arrReporte['excepcionesFnv']['url'] = null;

if($_GET['reporte'] == "") {
    $claSmarty->assign("arrReporte", $arrReporte);
    $claSmarty->display("reportes/complementariedad/listadoReportes.tpl");
}else{
    $txtReporte = $_GET['reporte'];
    $claReporte = new Reportes();
    if(method_exists($claReporte,$txtReporte)){
        $claReporte->$txtReporte();
    }
}

?>