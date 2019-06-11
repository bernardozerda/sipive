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
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Proyecto.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "DatosGeneralesProyectos.class.php" );
$txtPlantilla = "proyectos/crm/tableroProyDetalle.tpl";

$seqProyecto = $_REQUEST['seqProyecto'];
$nombrePadre = $_REQUEST['nombre'];
$seqProyectoGrupo = $_REQUEST['seqProyGrupo'];
$seqPryEstadoProceso = $_REQUEST['seqPryEstadoProceso'];
$arrDatosProy = Proyecto::obtenerDatosProyectosIndividual($seqProyecto);

//var_dump($arrDatosProy);
$claSmarty->assign("seqProyectoGrupo", $seqProyectoGrupo);
$claSmarty->assign("nombrePadre", $nombrePadre);
$claSmarty->assign("seqPryEstadoProceso", $seqPryEstadoProceso);
$claSmarty->assign("arrDatosProy", $arrDatosProy);
$claSmarty->display($txtPlantilla);

