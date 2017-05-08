<?php
	/**
	* MUESTRA UN LISTADO DE OPVS
	* @author Jaison Ospina
	* @version 0.1 Noviembre 2013 
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
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Opv.class.php" );
	//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "Proyecto.class.php" );

	$claOpv = new Opv;
	$arrOpv = $claOpv->cargarOpv($seqOpv);
	//$arrOpv = $claOpv->cargarOpv();

	// Adecuacion del arreglo para el formato de listado estandar
	$arrListado = array();
	foreach( $arrOpv as $seqOpv => $objOpv ){
		$arrListado[ $seqOpv ][ 'nombre' ] = $objOpv->txtNombreOpv;
		$arrListado[ $seqOpv ][ 'estado' ] = ( $objOpv->bolActivo == 1 )? "activo" : "inactivo";
	}

	$claSmarty->assign( "txtEditar"   , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracionProyectos/formularioOpv.php" ); // Archivo para editar las Opv
	$claSmarty->assign( "txtBorrar"   , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracionProyectos/borrarOpv.php" ); 	// archivo para borrar las Opv
	$claSmarty->assign( "arrListado"  , $arrListado );
	$claSmarty->assign( "txtPregunta" , "Esta a punto de eliminar una Opv, se requiere confirmacion para realizar esta accion.<br>&iquest;Desea Continuar?" );
	$claSmarty->assign( "txtTitulo"   , "Lista de OPVs" );

	// Despliegue de la plantilla
	$claSmarty->display( "administracionProyectos/listado.tpl" );

	// Desconecta la base de datos
	$aptBd->close();
?>