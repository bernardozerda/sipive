<?php

$txtPrefijoRuta = "../../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Proyecto.class.php" );
$txtPlantilla = "proyectos/crm/viewProyectosEstado.tpl";
$seqPryEstadoProceso = '';
$seqProyectoGrupo = $_REQUEST['seqProyGrupo'];
$cantHijos =0;

if (isset($_REQUEST['seqPryEstadoProceso'])) {
    $seqPryEstadoProceso = $_REQUEST['seqPryEstadoProceso'];
    $arrProyTableroPal = Proyecto::obtenerDatosProyectosEstados($seqPryEstadoProceso, $seqProyectoGrupo);
} else {
    $arrProyTableroPal = Proyecto::obtenerDatosProyectosTableroPal($seqProyectoGrupo);
    $txtPlantilla = "proyectos/crm/tablero.tpl";
}

$claSmarty->assign("seqProyectoGrupo", $seqProyectoGrupo);
$claSmarty->assign("arrProyTableroPal", $arrProyTableroPal);
$claSmarty->assign("seqPryEstadoProceso", $seqPryEstadoProceso);
$claSmarty->display($txtPlantilla);


