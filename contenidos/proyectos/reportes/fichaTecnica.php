<?php

$txtPrefijoRuta = "../../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include $txtPrefijoRuta . 'librerias/clases/Proyecto.class.php';
$classProyecto = new Proyecto();
$listaProyectos = $classProyecto->listarProyectos();
$boolMostrar = 1;
setlocale(LC_ALL, "es_ES");
if ($_REQUEST['seqProyecto']) {
    $boolMostrar = 1;
    $datos = $classProyecto->obtenerDatosProyecto($_REQUEST['seqProyecto']);
    $listaEntidades =$classProyecto->obtenerEntidades($_REQUEST['seqProyecto']);
    $claSmarty->assign("arrDatosProy", $datos);
    $boolMostrar = 0;
}

var_dump($listaEntidades);
$claSmarty->assign("arrListaProyectos", $listaProyectos);
$claSmarty->assign("boolMostrar", $boolMostrar);
$claSmarty->assign("arrListaEntidades", $listaEntidades);
$claSmarty->display("proyectos/vistas/reportes/fichaTecnica.tpl");

//if($_REQUEST['seqProyecto']){
//    $datos = $classProyecto->obtenerDatosProyecto($_REQUEST['seqProyecto']);
//  }
//var_dump($datos);
?>






