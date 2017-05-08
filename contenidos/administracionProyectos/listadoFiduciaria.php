<?php
	/**
	* MUESTRA UN LISTADO DE FIDUCIARIAS
	* @author Jaison Ospina
	* @version 0.1 Diciembre 2013 
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
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Fiduciaria.class.php" );
	//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "Proyecto.class.php" );

	$claFiduciaria = new Fiduciaria;
	$arrFiduciaria = $claFiduciaria->cargarFiduciaria($seqFiduciaria);
	//$arrFiduciaria = $claFiduciaria->cargarFiduciaria();

	// Adecuacion del arreglo para el formato de listado estandar
	$arrListado = array();
	foreach( $arrFiduciaria as $seqFiduciaria => $objFiduciaria ){
		$arrListado[ $seqFiduciaria ][ 'nombre' ] = $objFiduciaria->txtNombreFiduciaria;
		$arrListado[ $seqFiduciaria ][ 'estado' ] = ( $objFiduciaria->bolActivo == 1 )? "activo" : "inactivo";
	}

	$claSmarty->assign( "txtEditar"   , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracionProyectos/formularioFiduciaria.php" ); // Archivo para editar las Fiduciaria
	$claSmarty->assign( "txtBorrar"   , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracionProyectos/borrarFiduciaria.php" ); 	// archivo para borrar las Fiduciaria
	$claSmarty->assign( "arrListado"  , $arrListado );
	$claSmarty->assign( "txtPregunta" , "Esta a punto de eliminar una Fiduciaria, se requiere confirmacion para realizar esta accion.<br>&iquest;Desea Continuar?" );
	$claSmarty->assign( "txtTitulo"   , "Lista de Fiduciarias" );

	// Despliegue de la plantilla
	$claSmarty->display( "administracionProyectos/listado.tpl" );

	// Desconecta la base de datos
	$aptBd->close();
?>