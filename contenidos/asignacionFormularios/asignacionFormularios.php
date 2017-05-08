<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "AsignacionFormularios.class.php" );
	
	$claAsignacionFormulario = new AsignacionFormularios;
	$claSmarty->assign( "claAsignacionFormulario", $claAsignacionFormulario );
	
//	$claSmarty->assign( "txtTutoresNoAsignadosJS", 		$clsAsignacionFormulario->txtTutoresNoAsignadosJS );
//	$claSmarty->assign( "txtTutoresXCoordinadoresJS", 	$clsAsignacionFormulario->txtTutoresXCoordinadoresJS );
//	$claSmarty->assign( "txtTutoresInformacionJS", 		$clsAsignacionFormulario->txtTutoresInformacionJS );
//	$claSmarty->assign( "txtDataTableJS", 				$clsAsignacionFormulario->txtHogaresSinAsignarJS );
	$claSmarty->display( "asignacionFormularios/asignacionFormularios.tpl" );
    
?>