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

$arrOferente[0] = array();
$txtPlantilla = "proyectos/vistas/listaOferente.tpl";
$claDatosProy = new DatosGeneralesProyectos();
$idOferente = 0;
$arrGrupoGestion = $claDatosProy->obtenerDatosGestion();

if (isset($_REQUEST['seqOferente'])) {
    $idOferente = $_REQUEST['seqOferente'];
    $txtPlantilla = "proyectos/vistas/inscripcionOferente.tpl";
    $arrOferente = $claDatosProy->obtenerDatosOferente($idOferente);
} else {
    $arrOferente = $claDatosProy->obtenerDatosOferente($idOferente);
    $txtPlantilla = "proyectos/vistas/listaOferente.tpl";
    if ($_REQUEST['tipo'] == '1') {
        $arrOferente = array();
        $arrOferente[0] = array();
        $txtPlantilla = "proyectos/vistas/inscripcionOferente.tpl";
    }
}
$seqUsuario = $_SESSION['seqUsuario'];
$claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
$claSmarty->assign("arrayOferentes", $arrOferente);
$claSmarty->assign("seqUsuario", $seqUsuario);
$claSmarty->assign("page", "datosOferente.php");

if ($txtPlantilla != "") {
    $claSmarty->display($txtPlantilla);
}


