<?php


	/**
    * MUESTRA UN LISTADO DE PROYECTOS DE VIVIENDA
    * @author Jaison Ospina
    * @version 0.1 Agosto 2013 
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
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "ProyectoVivienda.class.php" );
    
	// Instancia de la clase
    $claProyectoVivienda = new ProyectoVivienda;
    $arrProyectosVivienda = $claProyectoVivienda->cargarProyectoVivienda(0);
    
    // Adecuacion del arreglo para el formato de listado estandar
    $arrListado = array();
    foreach( $arrProyectosVivienda as $seqProyecto => $objProyectoVivienda ){
        $arrListado[ $seqProyecto ][ 'nombre' ] = $objProyectoVivienda->txtNombreProyecto;
        $arrListado[ $seqProyecto ][ 'estado' ] = ( $objProyectoVivienda->bolActivo == 1 )? "activo" : "inactivo";
    }

    $claSmarty->assign( "txtEditar"   , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracion/formularioProyectosVivienda.php" ); // Archivo para editar los Proyectos de Vivienda
    $claSmarty->assign( "txtBorrar"   , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracion/borrarProyectosVivienda.php" ); // archivo para borrar los Proyectos de Vivienda
    $claSmarty->assign( "arrListado"  , $arrListado );
    $claSmarty->assign( "txtPregunta" , "Esta a punto de eliminar un Proyecto de Vivienda, se requiere confirmacion para realizar esta accion.<br>&iquest;Desea Continuar?" );
    $claSmarty->assign( "txtTitulo"   , "Proyectos de Vivienda" );
    
    // Despliegue de la plantilla
    $claSmarty->display( "administracion/listado.tpl" );
    
    // Desconecta la base de datos
    $aptBd->close();
?>
