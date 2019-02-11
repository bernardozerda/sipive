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

$claMenu      = new Menu();
$objMenu      = new Menu();
$claProyectos = new Proyecto();

$arrProyectos = $claProyectos->cargarProyecto();
$arrMenu = $claMenu->arbolMenu($_POST['seqProyecto']);

if(intval($_POST['seqMenu']) != 0) {
    $claMenu->salvarTextoAyuda($_POST['seqMenu'], $_POST['texto'], $_POST['publicar']);
    $objMenu = array_shift($claMenu->cargarMenu($_POST['seqProyecto'], $_POST['seqMenu']));
} else {
    $claMenu->arrErrores[] = "Seleccione una opción de menú para salvar el registro";
}

$claSmarty->assign("arrProyectos" , $arrProyectos);
$claSmarty->assign("seqProyecto"  , $_POST['seqProyecto']);
$claSmarty->assign("seqMenu"      , $_POST['seqMenu']);
$claSmarty->assign("arrMenu"      , $arrMenu);
$claSmarty->assign("claMenu"      , $claMenu);
$claSmarty->assign("objMenu"      , $objMenu);
$claSmarty->display( "ayuda/textosAyuda.tpl" );





?>