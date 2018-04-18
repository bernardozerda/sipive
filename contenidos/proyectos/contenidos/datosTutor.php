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

$arrTutor[0] = array();
$claDatosProy = new DatosGeneralesProyectos();
$txtPlantilla = "proyectos/vistas/listaTutor.tpl";
$idTutor = 0;
$arrGrupoGestion = $claDatosProy->obtenerDatosGestion();
$arrTipoDoc = $claDatosProy->obtenerlistaTipoDoc();

if (isset($_REQUEST['seqTutor'])) {
    $idTutor = $_REQUEST['seqTutor'];
    $arrTutor = $claDatosProy->obtenerDatosTutor($idTutor);
    $txtPlantilla = "proyectos/vistas/inscripcionTutor.tpl";
} else {
    $arrTutor = $claDatosProy->obtenerDatosTutor($idTutor);
    if ($_REQUEST['tipo'] == '1') {
        $txtPlantilla = "proyectos/vistas/inscripcionTutor.tpl";
        $arrTutor = array();
        $arrTutor[0] = array();
        //$txtPlantilla = "proyectos/secDatosOferente.tpl";
    }
}
$seqUsuario = $_SESSION['seqUsuario'];
$claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
$claSmarty->assign("arrTutor", $arrTutor);
$claSmarty->assign("arrTipoDoc", $arrTipoDoc);
$claSmarty->assign("seqUsuario", $seqUsuario);
$claSmarty->assign("page", "datosTutor.php");

if ($txtPlantilla != "") {
    $claSmarty->display($txtPlantilla);
}
