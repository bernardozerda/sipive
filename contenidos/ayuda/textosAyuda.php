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

$seqProyecto = (intval($_POST['seqProyecto']) == 0)? $_SESSION['seqProyecto'] : intval($_POST['seqProyecto']);

$claProyectos = new Proyecto();
$claMenu = new Menu();

$arrProyectos = $claProyectos->cargarProyecto();
$arrMenu      = $claMenu->arbolMenu($seqProyecto);

$claSmarty->assign("arrProyectos" , $arrProyectos);
$claSmarty->assign("seqProyecto" , $seqProyecto);
$claSmarty->assign("arrMenu" , $arrMenu);
$claSmarty->assign("claMenu" , $claMenu);
$claSmarty->display( "ayuda/textosAyuda.tpl" );

?>