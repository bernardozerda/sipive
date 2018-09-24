<?php

/**
 * ESTE ES EL ARCHIVO PRINCIPAL DEL APLICATIVO
 * SI ES UN USUARIO NORMAL, DESPUES DE AUTENTICARSE (ver autenticacion.php)
 * ES REDIRECCIONADO AQUI
 * @author Bernardo Zerda
 * @version 1.0 Abril 2009
 */
// Esta variable de usa para ubicar los archivos a incluir
$txtPrefijoRuta = "./";

include( "./recursos/archivos/verificarSesion.php" ); // Verifica si hay sesion    
include( "./recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Proyecto.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Menu.class.php" );

// Proyecto en session
if (!isset($_POST['proyecto'])) {
    $seqProyectoPost = key($_SESSION['arrPermisos']);
} else {
    $seqProyectoPost = $_POST['proyecto'];
}
$_SESSION['seqProyecto'] = $seqProyectoPost;

// Obtiene el arbol de menu de la aplicacion
$claMenu = new Menu;
$arrMenu = $claMenu->arbolMenu( $_SESSION['seqProyecto'] );

// Depurando menu segun los permisos del usuario
$arrMenu = $claMenu->depuracionPermisos($arrMenu);

// Obtiene las Proyectos autorizadas al usuario
$arrProyectosA = array();
foreach ($_SESSION['arrPermisos'] as $seqProyecto => $arrPrivilegios) {
    $arrProyecto = Proyecto::cargarProyecto($seqProyecto);
    $arrProyectosA[$seqProyecto] = $arrProyecto[$seqProyecto];
}
// carga el codigo por defecto
$seqMenuInicial = $arrProyectosA[$seqProyectoPost]->seqMenu;
if ($seqMenuInicial != 0) {
    $arrMenuInicial = $claMenu->cargarMenu($seqProyectoPost, $seqMenuInicial);

    $txtMenuInicial = $txtPrefijoRuta . "contenidos/" . $arrMenuInicial[$seqMenuInicial]->txtCodigo;
    if(strpos($txtMenuInicial,".php") !== false){
        $txtMenuInicial = str_replace(".php","",$txtMenuInicial);
    }

    include( $txtMenuInicial . ".php" );

} else {
    $claSmarty->assign("txtArchivoInicio", "sinInicio.tpl");
}

// Asignacion de variables a la plantilla
$claSmarty->assign("arrMenu", $arrMenu);
$claSmarty->assign("claMenu" , $claMenu);
$claSmarty->assign("seqProyectoPost", $seqProyectoPost);
$claSmarty->assign("arrProyectos", $arrProyectosA);
$claSmarty->assign("txtIdioma", $_SESSION['idioma']);
$claSmarty->assign("txtRutaImagenes", $arrConfiguracion['carpetas']['imagenes']);
$claSmarty->assign("txtNombreUsuario", $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido']);
$claSmarty->assign("arrGruposSesion", $_SESSION['arrGrupos']);

$claSmarty->display("index.tpl");

?>
