<?php
	
	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Encuestas.class.php" );
	
	$arrDisenos = array();
	$arrDisenos = Encuestas::obtenerDiseno();
	$arrCargues = Encuestas::obtenerCargue();
	
	$claSmarty->assign("arrDisenos",$arrDisenos);
	$claSmarty->assign("arrCargues",$arrCargues);
	$claSmarty->display("encuestasPive/encuestasPive.tpl");
	
?>