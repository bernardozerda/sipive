<?php
	/**
	* MUESTRA UN LISTADO DE OFERENTES
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
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Oferente.class.php" );
	//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "Proyecto.class.php" );

	$claOferente = new Oferente;
	$arrOferente = $claOferente->cargarOferente($seqOferente);
	//$arrOferente = $claOferente->cargarOferente();

	// Adecuacion del arreglo para el formato de listado estandar
	$arrListado = array();
	foreach( $arrOferente as $seqOferente => $objOferente ){
		$arrListado[ $seqOferente ][ 'nombre' ] = $objOferente->txtNombreOferente;
		$arrListado[ $seqOferente ][ 'estado' ] = ( $objOferente->bolActivo == 1 )? "activo" : "inactivo";
	}

	$claSmarty->assign( "txtEditar"   , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracionProyectos/formularioOferente.php" ); // Archivo para editar las Oferente
	$claSmarty->assign( "txtBorrar"   , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracionProyectos/borrarOferente.php" ); 	// archivo para borrar las Oferente
	$claSmarty->assign( "arrListado"  , $arrListado );
	$claSmarty->assign( "txtPregunta" , "Esta a punto de eliminar un Oferente, se requiere confirmacion para realizar esta accion.<br>&iquest;Desea Continuar?" );
	$claSmarty->assign( "txtTitulo"   , "Lista de Oferentes" );

	// Despliegue de la plantilla
	$claSmarty->display( "administracionProyectos/listado.tpl" );

	// Desconecta la base de datos
	$aptBd->close();
?>