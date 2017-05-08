<?php

    /**
     * MUESTRA EL LISTADO DE LOS GRUPOS CREADOS
     * @author Bernardo Zerda
     * @version 1,0 Abril 2009
     */

    // posicion relativa de los archivos a incluirs
    $txtPrefijoRuta = "../../";

    // Autenticacion (si esta logueado no no)
    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    
    // Inclusiones necesarias
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Proyecto.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Menu.class.php" );
    
    // clases necesarias
    $claProyecto = new Proyecto;
    $claMenu    = new Menu;
    
    // las Proyectos son para mostrar las opciones que hay
    // para ver los menu
    $arrProyecto = $claProyecto->cargarProyecto();
    if( ! isset( $_POST['proyecto'] ) ){
        $seqProyecto = key( $arrProyecto ); // toma la primera por defecto para mostrar
    }else{
        $seqProyecto = $_POST['proyecto'];
    }
    
    // carga el menu de la Proyecto
    $arrMenu = $claMenu->cargarMenu( $seqProyecto );

    // Obtiene solo los datos que necesita para el listado
    $arrListado = array();
    foreach( $arrMenu as $seqMenu => $objMenu ){
        $seqMenuPadre = $objMenu->seqPadre;
        $numOrden     = $objMenu->numOrden;
        $arrListado[ $seqMenuPadre ][ $numOrden ] = $seqMenu;
    }
    
    // Asignaciones a la plantilla
    $claSmarty->assign( "txtTitulo"  , "&Aacute;rbol de Men&uacute;"  );
    $claSmarty->assign( "arrConfiguracion" , $arrConfiguracion );
    $claSmarty->assign( "seqProyectoPost" , $seqProyecto );
    $claSmarty->assign( "arrProyecto" , $arrProyecto );
    $claSmarty->assign( "arrMenu"    , $arrMenu );
    $claSmarty->assign( "arrListado" , $arrListado );

    // Plantilla que se despliega
    $claSmarty->display( "administracion/listadoMenu.tpl" );

    // Desconecta la base de datos
    $aptBd->close();  

?>
