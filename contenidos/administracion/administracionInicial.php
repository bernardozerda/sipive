<?php

	/**
	 * ARCHIVO PRINCIPAL DE ADMINISTRACION (panel de control)
	 * DESDE AQUI SE ADMINISTRAN LAS ProyectoS, LOS GRUPOS
	 * LOS USUARIOS Y LAS OPCIONES DE MENU DEL APLICATIVO
	 * @author Bernardo Zerda
	 * @version 0.1 Marzo de 2009
	 */
    
  // posicion relativa de los archivos a incluir
	$txtPrefijoRuta = "../../";

    // Autenticacion (si esta logueado no no)
    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" ); 	
    
 	// Inclusiones necesarias
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']  . "Proyecto.class.php" );
	
	// Funciones
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	 
	// Por defecto se muestran las plantillas de Proyectos
	$txtListado    = "./administracion/listado.tpl";
	$txtFormulario = "./administracion/formularioProyectos.tpl";
	$txtMenu       = "./administracion/menuLateral.tpl";
	
	// Listado de Proyectos (que se muestra por defecto)
	$claProyecto = new Proyecto;
	$arrProyectos = $claProyecto->cargarProyecto();
	
  // Adecuacion del arreglo para el formato de listado estandar
  $arrListado = array();
  foreach( $arrProyectos as $seqProyecto => $objProyecto ){
  	$arrListado[ $seqProyecto ][ 'nombre' ] = $objProyecto->txtProyecto;
    $arrListado[ $seqProyecto ][ 'estado' ] = ( $objProyecto->bolActivo == 1 )? "Activo" : "Inactivo";
  }
  
  // Asignaciones a la plantilla
  $claSmarty->assign( "txtListado"       , $txtListado       );
  $claSmarty->assign( "txtFormulario"    , $txtFormulario    );
  $claSmarty->assign( "txtMenu"          , $txtMenu          );
  $claSmarty->assign( "arrListado"       , $arrListado       );
  $claSmarty->assign( "arrConfiguracion" , $arrConfiguracion );
  $claSmarty->assign( "txtEditar"        , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracion/formularioProyectos.php" ); // Archivo para editar las Proyectos
  $claSmarty->assign( "txtBorrar"        , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracion/borrarProyectos.php" ); // archivo para borrar las Proyectos
  $claSmarty->assign( "txtPregunta"      , "Esta a punto de eliminar una Proyecto, se requiere confirmacion para realizar esta accion.<br>&iquest;Desea Continuar?" );
  $claSmarty->assign( "txtTitulo"        , "Proyectos" );
  $claSmarty->assign( "txtRutaImagenes"  , $arrConfiguracion['carpetas']['imagenes'] );
  
	// Despliegue de la plantilla
	$claSmarty->display( "administracion/administracionInicial.tpl" );
	
	// Desconecta la base de datos
	$aptBd->close();

?>
