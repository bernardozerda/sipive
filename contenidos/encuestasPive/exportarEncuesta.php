<?php

	$txtPrefijoRuta = "../../";
	include ($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
	include ($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['librerias'] ['funciones'] . "funciones.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['carpetas'] ['recursos'] . "archivos/inclusionSmarty.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['carpetas'] ['recursos'] . "archivos/coneccionBaseDatos.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['librerias'] ['clases'] . "Encuestas.class.php");
	
	$claEncuesta = new Encuestas();	
	$claEncuesta->obtenerEncuesta( $_POST['seqAplicacion'] );

	header("Content-disposition: attachment; filename=".time().".doc");
	header("Content-Type: application/force-download");
	header("Content-Type: application/vnd.ms-word; charset=ansi;");
	header("Content-Transfer-Encoding: binary");
	header("Pragma: no-cache");
	header("Expires: 1");
	
	$claSmarty->assign("claEncuesta",$claEncuesta);
	$claSmarty->display("encuestasPive/exportarEncuestas.tpl");
	
?>