<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos.class.php" );
	
	$claActo 	 = new ActoAdministrativo;
	
	$arrListadoActos = $claActo->listarActosTipo( $_POST['seqTipoActo'] );
	
	$claSmarty->assign( "arrListadoActos" , $arrListadoActos  );
	$claSmarty->display( "asignacion/listadoActosNotificacion.tpl" );

?>
