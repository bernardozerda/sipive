<?php

$txtPrefijoRuta = "../../../";
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Autenticacion (si esta logueado no no)
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

// Inclusiones necesarias
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Proyecto.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "DatosGeneralesProyectos.class.php" );


$claProyecto = new Proyecto;
$claDatosProyecto = new DatosGeneralesProyectos();


$txtPlantilla = "proyectos/vistas/reportes/fichaTecnica.tpl";
$seqProyecto = $_GET['seqProyecto'];
$arrProyectos = $claProyecto->obtenerDatosProyectosFicha($seqProyecto);
$arrDatosVivienda = $claProyecto->obtenerDatosViviendaFicha($seqProyecto);
$arraFinanciera = $claDatosProyecto->reporteGeneralFinaciera($seqProyecto);
var_dump($arraFinanciera);

$cantUnidades = $claDatosProyecto->totalUnidadesPorProyecto(1, $seqProyecto);
$cantUnidadesVinculadas = $claDatosProyecto->totalUnidadesPorProyecto(4, $seqProyecto);
$pendientesPorVincular = $claDatosProyecto->totalUnidadesPorProyecto(2, $seqProyecto);
$legalizadas = $claDatosProyecto->totalUnidadesPorProyecto(5, $seqProyecto);
$pendientesPorLegalizar = $cantUnidadesVinculadas-$legalizadas;


// var_dump($arrProyectos);
$claSmarty->assign("arrProyectos", $arrProyectos);
$claSmarty->assign("cantUnidades", $cantUnidades);
$claSmarty->assign("cantUnidadesVinculadas", $cantUnidadesVinculadas);
$claSmarty->assign("pendientesPorVincular", $pendientesPorVincular);
$claSmarty->assign("legalizadas", $legalizadas);
$claSmarty->assign("pendientesPorLegalizar", $pendientesPorLegalizar);
$claSmarty->assign("arrDatosVivienda", $arrDatosVivienda);
if ($txtPlantilla != "") {
    $claSmarty->display($txtPlantilla);
}
