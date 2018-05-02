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


// Obtiene los permisos del usuario ya registrado
$claMenu = new Menu;

// Proyecto en session
if (!isset($_POST['proyecto'])) {
    $seqProyectoPost = key($_SESSION['arrPermisos']);
} else {
    $seqProyectoPost = $_POST['proyecto'];
}
$_SESSION['seqProyecto'] = $seqProyectoPost;

$arrNietos = Array();
// Obtiene las opciones de menu para cada proyecto en sesion
$arrMenu = $claMenu->obtenerHijos($seqProyectoPost, 0); // los hijos del padre cero(0) son el menu principal

foreach ($arrMenu as $seqMenu => $objMenu) {
    //  echo "<br><menu ->" . $seqMenu;
    $arrMenu[$seqMenu]->hijos = $claMenu->obtenerHijos($seqProyectoPost, $seqMenu);
}


// Depurando menu segun los permisos del usuario
foreach ($arrMenu as $seqPadre => $objPadre) {
    if (!in_array($seqPadre, $_SESSION['arrPermisos'][$seqProyectoPost])) {
        unset($arrMenu[$seqPadre]);
    } else {
        foreach ($objPadre->hijos as $seqHijo => $objHijo) {    
            echo "<br> hijo ->".$seqHijo;
            $arrNietos = $claMenu->obtenerHijos($seqProyectoPost, $seqHijo);
            var_dump($arrNietos);
            if (!in_array($seqHijo, $_SESSION['arrPermisos'][$seqProyectoPost])) {               
                unset($arrMenu[$seqPadre]->hijos[$seqHijo]);
            }
        }
    }
}
foreach ($arrNietos as $seqNieto => $objNieto) {   
    if (!in_array($seqNieto, $_SESSION['arrPermisos'][$seqProyectoPost])) {
        unset($arrNietos[$seqNieto]->nietos[$seqNieto]);
    }
}
//var_dump($arrMenu);
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
    include( $txtPrefijoRuta . "contenidos/" . $arrMenuInicial[$seqMenuInicial]->txtCodigo . ".php" );
} else {
    $claSmarty->assign("txtArchivoInicio", "sinInicio.tpl");
}
// Asignacion de variables a la plantilla
$claSmarty->assign("arrMenu", $arrMenu);
$claSmarty->assign("arrNietos", $arrNietos);
$claSmarty->assign("seqProyectoPost", $seqProyectoPost);
$claSmarty->assign("arrProyectos", $arrProyectosA);
$claSmarty->assign("txtIdioma", $_SESSION['idioma']);
$claSmarty->assign("txtRutaImagenes", $arrConfiguracion['carpetas']['imagenes']);
$claSmarty->assign("txtNombreUsuario", $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido']);
$claSmarty->assign("arrGruposSesion", $_SESSION['arrGrupos']);

// Muestra la plantilla
//if ($seqProyectoPost == 6) {
//    var_dump($seqProyectoPost);
//$claSmarty->display("indexProyectos.tpl");
//} else {
$claSmarty->display("index.tpl");
//}
?>
