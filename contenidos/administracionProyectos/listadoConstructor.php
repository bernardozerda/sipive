<?php
	/**
	* MUESTRA UN LISTADO DE CONSTRUCTORES
	* @author Jaison Ospina
	* @version 0.1 Noviembre 2013 
	*/

	// posicion relativa de los archivos a incluir
	$txtPrefijoRuta = "../../";

	// Autenticacion (si esta logueado o no)
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

	// Inclusiones necesarias
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Constructor.class.php" );
	//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "Proyecto.class.php" );

	$claConstructor = new Constructor;
	$arrConstructor = $claConstructor->cargarConstructor($seqConstructor);
	//$arrConstructor = $claConstructor->cargarConstructor();

	// Adecuacion del arreglo para el formato de listado estandar
	$arrListado = array();
	foreach( $arrConstructor as $seqConstructor => $objConstructor ){
		$arrListado[ $seqConstructor ][ 'nombre' ] = $objConstructor->txtNombreConstructor;
		$arrListado[ $seqConstructor ][ 'estado' ] = ( $objConstructor->bolActivo == 1 )? "activo" : "inactivo";
	}

	$claSmarty->assign( "txtEditar"   , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracionProyectos/formularioConstructor.php" ); // Archivo para editar las Constructor
	$claSmarty->assign( "txtBorrar"   , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracionProyectos/borrarConstructor.php" ); 	// archivo para borrar las Constructor
	$claSmarty->assign( "arrListado"  , $arrListado );
	$claSmarty->assign( "txtPregunta" , "Esta a punto de eliminar un Constructor, se requiere confirmacion para realizar esta accion.<br>&iquest;Desea Continuar?" );
	$claSmarty->assign( "txtTitulo"   , "Lista de Constructores" );

	// Despliegue de la plantilla
	$claSmarty->display( "administracionProyectos/listado.tpl" );

	// Desconecta la base de datos
	$aptBd->close();
?>