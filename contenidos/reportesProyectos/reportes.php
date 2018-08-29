<?php

$txtPrefijoRuta = "../../";

include($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
include($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ReportesProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include("../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php");
include("../../librerias/phpExcel/Classes/PHPExcel/IOFactory.php");

$arrReporte = array();

$arrReporte['general']['funcion'] = "reporteGeneral";
$arrReporte['general']['titulo'] = "Exportable General";
$arrReporte['general']['descripcion'] = "Información general de proyectos en dinero";
$arrReporte['general']['url'] = null;

$arrReporte['fichaTecnica']['funcion'] = "reporteFichaTecnica";
$arrReporte['fichaTecnica']['titulo'] = "Exportable Ficha Técnica";
$arrReporte['fichaTecnica']['descripcion'] = "Obtiene la información consignada en la ficha técnica de todos los proyectos";
$arrReporte['fichaTecnica']['url'] = null;

$arrReporte['unidadesAsignadas']['funcion'] = "analisisUnidadesAsignadas";
$arrReporte['unidadesAsignadas']['titulo'] = "Unidades Asignadas";
$arrReporte['unidadesAsignadas']['descripcion'] = "Información de las unidades por cada proyecto asignadas a los hogares";
$arrReporte['unidadesAsignadas']['url'] = "./contenidos/otros/analisisUnidadesAsignadas/analisisUnidadesAsignadas.php";

if($_GET['reporte'] != "") {
    $txtClave = $_GET['reporte'];
    $txtReporte = $arrReporte[$txtClave]['funcion'];
    $claGestion = new Reportes();
    $claGestion->$txtReporte();
}else{
    $claSmarty->assign("arrReporte", $arrReporte);
    $claSmarty->display( "reportesProyectos/reportes.tpl" );
}

?>