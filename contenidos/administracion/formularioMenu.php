<?php

    /**
     * MUESTRA EL FORMULARIO QUE PERMITE
     * CREAR / EDITAR LAS OPCIONES DE MENU
     * @author Bernardo Zerda
     * @version 1,0 Abril 2009
     */

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

    // Verifica que el valor sea numerico
    if( ! ( is_numeric( $_POST[ 'seqEditar' ] ) and isset( $_POST['seqEditar'] ) ) ){
        $_POST[ 'seqEditar' ] = 0;
    }

    // Identificador de la opcion de menu
    $seqMenu = $_POST[ 'seqEditar' ];
 
    // Clases necesaias para esta implementacion
    $claProyecto = new Proyecto;
    $claGrupo   = new Grupo;
    $claMenu    = new Menu;
    
    // obtiene la relacion entre Proyectos y grupos
    $arrProyecto   = $claProyecto->cargarProyecto();
    $arrGrupo     = $claGrupo->cargarGrupo();
    
    // Si no viene Proyecto coge la primera de la lista
    if( ! ( isset( $_POST['proyecto'] ) and is_numeric( $_POST['proyecto'] ) and $_POST['proyecto'] > 0 ) ){
        $seqProyecto = key( $arrProyecto );
    } else {
        $seqProyecto = $_POST['proyecto'];
    }
 
     // obtiene la informacion del grupo
    $arrMenu = array();
    $arrMenuHermanos = array();
    if( $seqMenu != 0 ){
        $arrMenu = $claMenu->cargarMenu( $seqProyecto , $seqMenu );
        $arrMenuHermanos = $claMenu->obtenerHijos( $seqProyecto , $arrMenu[ $seqMenu ]->seqPadre );
    }
    
    // obtiene las opciones padre para llenar el select de escoger el padre
    $arrMenuPadre = $claMenu->obtenerHijos( $seqProyecto , 0 );
    
    // cuando es edicion el numero de opciones se obtiene con los hermanos
    if( isset( $arrMenu[ $seqMenu ]->seqPadre ) and $arrMenu[ $seqMenu ]->seqPadre != 0 ){
        $numOpciones = ( count( $arrMenuHermanos )  + 2 );
    }else{
        $numOpciones = ( count( $arrMenuPadre )  + 2 );	
    }
	
    // Asignaciones a la plantilla
    $claSmarty->assign( "seqEditar"        , $seqMenu              );
    $claSmarty->assign( "arrGrupo"         , $arrGrupo             );
    $claSmarty->assign( "arrProyecto"       , $arrProyecto           );
    $claSmarty->assign( "seqProyectoMenu"   , $seqProyecto           );
    $claSmarty->assign( "numOpciones"      , $numOpciones          );
    $claSmarty->assign( "arrMenuPadre"     , $arrMenuPadre         );
    $claSmarty->assign( "objMenu"          , $arrMenu[ $seqMenu ]  );
    $claSmarty->assign( "arrConfiguracion" , $arrConfiguracion     );
    $claSmarty->assign( "txtTitulo"        , "Formulario de Opcones de Menu" );
    
    // Muestra el formulario
    $claSmarty->display( "administracion/formularioMenu.tpl" );

    // Desconecta la base de datos
    $aptBd->close();

?>
