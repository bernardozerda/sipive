<?php

/**
 *
 * @author liliana.basto
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


$claDatosProy = new DatosGeneralesProyectos();
$claProyecto = new Proyecto();


$id = $_REQUEST['id'];
$tipo = $_REQUEST['tipo'];

if ($id == 4) {
    $txtPlantilla = "proyectos/vistas/inscripcionUnidades.tpl";
} else {
    $txtPlantilla = "proyectos/vistas/cambioEstadoUnidades.tpl";
    if ($tipo == 2) {

        $txtPlantilla = "proyectos/vistas/cambioDatosUnidades.tpl";
    }
}

$idProyecto = $_REQUEST['seqProyecto'];
$arrayProyectos = Array();
$seqPryEstadoProceso = 0;
$cantidadUnidades = 0;
$arrGrupoGestion = $claDatosProy->obtenerDatosGestion();
$arrayProyectos = $claDatosProy->obtenerlistaProyectos($idProyecto, $id);

$arrConjuntoResidencial = $claDatosProy->obtenerConjuntoResidencial($idProyecto);

if (count($arrConjuntoResidencial) > 0) {
    $arrayProyectos = $arrConjuntoResidencial;
}

$arrErrores = array();
$claSmarty->assign("seqPryEstadoProceso", $seqPryEstadoProceso);
$claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
$claSmarty->assign("arrayProyectos", $arrayProyectos);
$claSmarty->assign("idProyecto", $idProyecto);
$claSmarty->assign("id", $id);
$claSmarty->assign("tipo", $tipo);
$claSmarty->assign("onload", "listenerFile('fileAction', 'nameArchivo')");
$claSmarty->assign("page", "datosProyecto.php?id=" . $id);
if ($txtPlantilla != "") {
    $claSmarty->display($txtPlantilla);
}

