<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos.class.php" );
	
	// 7 es notificacion
	// 4 es Repocision
	$seqTipoActo = 7;
	$seqTipoActoReposicion = 4;
	
	$claTipoActo = new TipoActoAdministrativo;
	$claTipoActo->cargarTipoActo( $seqTipoActo );
	unset( $claTipoActo->arrTipoActos[ $seqTipoActo ] );
	unset( $claTipoActo->arrTipoActos[ $seqTipoActoReposicion ] );
	
	// Obtiene un listado de los actos administrativos creados en el sistema
	$arrListadoActos = ActoAdministrativo::listarActosNumeroTipo( null , $seqTipoActo  );
	
	$claSmarty->assign( "arrListadoActos" , $arrListadoActos );
 	$claSmarty->assign( "claTipoActo"     , $claTipoActo     );
 	$claSmarty->assign( "seqNotificacion" , $seqTipoActo     );
 	$claSmarty->assign( "txtArchivoResoluciones" , "asignacion/listadoResoluciones.tpl" );	
	$claSmarty->display( "asignacion/notificacion.tpl" );
    
?>
