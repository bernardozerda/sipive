<?php

	/**
    * MUESTRA UN LISTADO DE ProyectoS
    * @author Bernardo Zerda
    * @version 0.1 Marzo 2009 
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
    
    $claProyecto = new Proyecto;
    $arrProyectos = $claProyecto->cargarProyecto();
    
    // Adecuacion del arreglo para el formato de listado estandar
    $arrListado = array();
    foreach( $arrProyectos as $seqProyecto => $objProyecto ){
        $arrListado[ $seqProyecto ][ 'nombre' ] = $objProyecto->txtProyecto;
        $arrListado[ $seqProyecto ][ 'estado' ] = ( $objProyecto->bolActivo == 1 )? "activo" : "inactivo";
    }
    
    $claSmarty->assign( "txtEditar"   , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracion/formularioProyectos.php" ); // Archivo para editar las Proyectos
    $claSmarty->assign( "txtBorrar"   , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracion/borrarProyectos.php" ); // archivo para borrar las Proyectos
    $claSmarty->assign( "arrListado"  , $arrListado );
    $claSmarty->assign( "txtPregunta" , "Esta a punto de eliminar una Proyecto, se requiere confirmacion para realizar esta accion.<br>&iquest;Desea Continuar?" );
    $claSmarty->assign( "txtTitulo"   , "Proyectos" );
    
    // Despliegue de la plantilla
    $claSmarty->display( "administracion/listado.tpl" );
    
    // Desconecta la base de datos
    $aptBd->close();
?>
