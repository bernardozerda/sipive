<?php

/**
 * MUESTRA EL FORMULARIO QUE PERMITE
 * CREAR / EDITAR LAS OPCIONES DE MENU
 * @author Bernardo Zerda
 * @author Bernardo Zerda
 * @version 1,0 Abril 2009
 * @version 1,1 Junio 2018
 **/

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

// clases necesarias
$claProyecto = new Proyecto;
$claGrupo    = new Grupo;
$claMenu     = new Menu;

// listado de proyectos y de grupos
$arrProyecto = $claProyecto->cargarProyecto();
$arrGrupo     = $claGrupo->cargarGrupo();

// Identificador de la opcion de menu a editar y el proyecto al que pertenece
$seqMenu     = $_POST['seqEditar'];
$seqProyecto = (isset($_POST['proyecto']))? intval($_POST['proyecto']) : array_keys($arrProyecto)[0];

if( $seqMenu != 0 ){
    $arrMenu = $claMenu->cargarMenu( $seqProyecto , $seqMenu );
    $claMenu = $arrMenu[$seqMenu];
}

// obtiene el arbol de menu (obtiene N niveles)
$arrArbolMenu = $claMenu->arbolMenu($seqProyecto);
$numOpciones = $claMenu->obtenerCantidadOpciones($arrArbolMenu, intval($claMenu->seqPadre) );

// Variables del formulario
$claSmarty->assign( "seqProyecto" , $seqProyecto );
$claSmarty->assign( "seqEditar" , $seqMenu );
$claSmarty->assign( "claMenu" , $claMenu );
$claSmarty->assign( "numOpciones" , $numOpciones + 2 );
$claSmarty->assign( "arrProyecto" , $arrProyecto );
$claSmarty->assign( "arrGrupo" , $arrGrupo );

$claSmarty->display( "administracion/formularioMenu.tpl" );

// Desconecta la base de datos
$aptBd->close();

?>
