<?php

/**
 * CUANDO SE CAMBIA EL PADRE DE UN MENU SE RECALCULA EL
 * SELECT DE ORDEN PARA SABER CUALES SON LAS POSICIONES VALIDAS
 * @author Bernardo Zerda
 * @version 1,0 Abril 2009
 * @version 1.1 Junio 2018
 */

// Posicion relativa de los archivos a incluir
$txtPrefijoRuta = "../../";

// Autenticacion (si esta logueado no no)
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

// Inclusiones necesarias
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Menu.class.php" );

$claMenu = new Menu;
$arrArbolMenu = $claMenu->arbolMenu($_POST['proyecto']);
$numOpciones = $claMenu->obtenerCantidadOpciones($arrArbolMenu, $_POST['padre']);

// Asignacion a la plantilla
$claSmarty->assign( "numOpciones" , ($numOpciones + 2) );

// plantilla a mostrar
$claSmarty->display( "administracion/recalcularOrden.tpl" );

// Desconecta la base de datos
$aptBd->close();

?>
