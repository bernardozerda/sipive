<?php

//ini_set("display_errors", true); error_reporting(E_ALL);

	$txtPrefijoRuta = "../../";
	include ($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
	include ($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['librerias'] ['funciones'] . "funciones.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['carpetas'] ['recursos'] . "archivos/inclusionSmarty.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['carpetas'] ['recursos'] . "archivos/coneccionBaseDatos.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['librerias'] ['clases'] . "Encuestas.class.php");
	
	$_POST['bolConfirmado'] = ( isset($_POST['bolConfirmado']) )? 1 : 0;
	
	if( $_POST['bolConfirmado'] == 1 ){
		$claEncuestas = new Encuestas();
		$arrErrores = $claEncuestas->eliminarEncuestas($_POST['seqAplicacion']);
		$arrImprimir = (empty($arrErrores))? array("Aplicación eliminada satisfactoriamente") : $arrErrores;
		$txtEstilo = (empty($arrErrores))? "MsgOk" : "MsgError";
		
	}

	$claSmarty->assign( "arrPost" , $_POST);
	$claSmarty->assign( "estilo" , $txtEstilo);
	$claSmarty->assign( "arrImprimir" , $arrImprimir);
	$claSmarty->display( "encuestasPive/eliminarEncuestas.tpl" );
	
?>