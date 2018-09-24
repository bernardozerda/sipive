<?php

$txtPrefijoRuta = "../../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Proyecto.class.php" );
$txtPlantilla = "proyectos/crm/viewProyectosEstado.tpl";

$seqPryEstadoProceso = $_REQUEST['seqPryEstadoProceso'];
$arrProyTableroPal = Proyecto::obtenerDatosProyectosEstados($seqPryEstadoProceso);
//var_dump($arrProyTableroPal);
$claSmarty->assign("arrProyTableroPal", $arrProyTableroPal);
$claSmarty->assign("seqPryEstadoProceso", $seqPryEstadoProceso);
$claSmarty->display($txtPlantilla);


