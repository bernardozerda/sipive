<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$txtPrefijoRuta = "../../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "DatosGeneralesProyectos.class.php" );

$arrConstructor[0] = array();
$claDatosProy = new DatosGeneralesProyectos();
$txtPlantilla = "proyectos/vistas/listaConstructor.tpl";
$idConstructor = 0;
$arrGrupoGestion = $claDatosProy->obtenerDatosGestion();
$arrTipoDoc = $claDatosProy->obtenerlistaTipoDoc();

if (isset($_REQUEST['seqConstructor'])) {
    $idConstructor = $_REQUEST['seqConstructor'];
    $arrConstructor = $claDatosProy->obtenerDatosConstructor($idConstructor);
    $txtPlantilla = "proyectos/vistas/inscripcionConstructor.tpl";
} else {
    $arrConstructor = $claDatosProy->obtenerDatosConstructor($idConstructor);    
    if ($_REQUEST['tipo'] == '1') {
       $txtPlantilla = "proyectos/vistas/inscripcionConstructor.tpl";
        $arrConstructor = array();
        $arrConstructor[0] = array();       
        //$txtPlantilla = "proyectos/secDatosOferente.tpl";
    }
}
$seqUsuario = $_SESSION['seqUsuario'];
$claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
$claSmarty->assign("arrConstructor", $arrConstructor);
$claSmarty->assign("arrTipoDoc", $arrTipoDoc);
$claSmarty->assign("seqUsuario", $seqUsuario);
$claSmarty->assign("page", "datosConstructor.php");

if ($txtPlantilla != "") {
    $claSmarty->display($txtPlantilla);
}