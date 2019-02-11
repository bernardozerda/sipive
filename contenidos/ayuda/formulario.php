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

$claMenu = new Menu();
$objMenu = array_shift($claMenu->cargarMenu($_POST['seqProyecto'],$_POST['seqMenu']));

$claSmarty->assign("objMenu" , $objMenu);
$claSmarty->assign("seqProyecto" , $_POST['seqProyecto']);
$claSmarty->assign("seqMenu" , $_POST['seqMenu']);
$claSmarty->display( "ayuda/formulario.tpl" );

?>