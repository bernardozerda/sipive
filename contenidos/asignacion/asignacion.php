<?php

	/**
	 * INICIO DE LA PANTALLA DE ASIGNACION
	 * @author Bernardo Zerda
	 * @version 1.0 Febrero de 2010
	 */

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos.class.php" );
	
 	
 	// Clase de actos administrativos ( para los tipos de actos)
 	$claTipoActo = new TipoActoAdministrativo;
 	$claActo     = new ActoAdministrativo;
 	
 	// Norificacion
 	unset( $claTipoActo->arrTipoActos[ 7 ] );
 	
 	// Obtiene las caracteristicas del tipo de acto resolucion de asignacion (del primero en la lista)
 	$seqTipoActo = array_shift( array_keys( $claTipoActo->arrTipoActos ) );
 	$claTipoActo->cargarTipoActo( $seqTipoActo );
 	
	// Obtiene un listado de los actos administrativos creados en el sistema
	$arrListadoActos = $claActo->listarActosNumeroTipo();

 	// Platillas y variables
 	$claSmarty->assign( "claTipoActo"     , $claTipoActo     );
 	$claSmarty->assign( "arrListadoActos" , $arrListadoActos );
 	$claSmarty->assign( "txtArchivoResoluciones" , "asignacion/listadoResoluciones.tpl" );
	$claSmarty->display( "asignacion/asignacion.tpl" );

?>
