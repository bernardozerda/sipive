<?php

/*
 * Creado por Liliana Basto
 * Archivo para cargar la información para la inscripsión de los proyectos
 * 20-06-2017.
 */
$txtPrefijoRuta = "../../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );

include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "DatosGeneralesProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Proyecto.class.php" );

$arrProyectos = array();
$arrayDatosInterventoria[0] = 0;
$arrayTextos[0] = 0;


$claDatosProy = new DatosGeneralesProyectos();
$claProyecto = new Proyecto();
$txtPlantilla = "proyectos/vistas/listaProyectos.tpl";
$idProyecto = 0;
$arrGrupoGestion = $claDatosProy->obtenerDatosGestion();
$arrRegistros = array();
$arrayDocumentos = array();
$id = $_REQUEST['id'];
$seqInformeInterventoria = 0;
if (isset($_REQUEST['seqProyecto'])) {
    $idProyecto = $_REQUEST['seqProyecto'];
    $seqInformeInterventoria = $_REQUEST['seqInformeInterventoria'];
    $txtPlantilla = "proyectos/vistas/inscripcionInterventoria.tpl";
    $arrProyectos = $claDatosProy->obtenerlistaProyectos($idProyecto, $id);
    if ($seqInformeInterventoria > 0) {
        $arrayDatosInterventoria = $claDatosProy->obtenerDatosInterventoria($idProyecto, $seqInformeInterventoria);
        $arrayTextos = $claDatosProy->obtenerlistaTextosInterventoria($seqInformeInterventoria);
    }
}
//print_r($arrProyectos);
$seqUsuario = $_SESSION['seqUsuario'];
$claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
$claSmarty->assign("arrProyectos", $arrProyectos);

$claSmarty->assign("id", $id);
$claSmarty->assign("onload", "activarEditorTiny('comentarios', 1)");
$claSmarty->assign("NombreUsuario", $_SESSION['txtNombre'] . "" . $_SESSION['txtApellido']);
$claSmarty->assign("seqUsuario", $_SESSION['seqUsuario']);
$claSmarty->assign("seqProyecto", $idProyecto);
$claSmarty->assign("arrayDatosInterventoria", $arrayDatosInterventoria);
$claSmarty->assign("arrayTextos", $arrayTextos);
$claSmarty->assign("prefijo", "./");
$claSmarty->assign("pages", "datosSeguimientoFicha.php?tipo=1&id=" . $id);


if ($txtPlantilla != "") {
    $claSmarty->display($txtPlantilla);
}