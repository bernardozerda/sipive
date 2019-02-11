<?php

// posicion relativa de los archivos a incluir
$txtPrefijoRuta = "../../";

// Autenticacion (si esta logueado no no)
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

// Inclusiones necesarias
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Proyecto.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Grupo.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Menu.class.php" );

$claProyecto = new Proyecto();
$claMenu     = new Menu();

$objProyecto = array_shift($claProyecto->cargarProyecto($_SESSION['seqProyecto']));
$arrArbolMenu = $claMenu->arbolMenu($_SESSION['seqProyecto']);
$objMenu = array_shift($claMenu->cargarMenu($_SESSION['seqProyecto'],$_GET['menu']));

$claSmarty->assign("arrArbolMenu", $arrArbolMenu);
$claSmarty->assign("claMenu", $claMenu);
$claSmarty->assign("objMenu", $objMenu);
$claSmarty->assign("seqMenu", $_GET['menu']);
$claSmarty->assign("txtProyecto", $objProyecto->txtProyecto);
$claSmarty->display( "ayuda/verAyuda.tpl" );

?>