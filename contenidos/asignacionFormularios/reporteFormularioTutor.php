<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "AsignacionFormularios.class.php" );
	
	
	$claAsignacionFormulario = new AsignacionFormularios;
	if( isset( $_GET["seqTutor"] ) ){
		$claAsignacionFormulario->generarReporteTutorHogar( $_GET["seqTutor"] );
	}else{
		$claAsignacionFormulario->generarReporteTotalHogar( );
	}
	

?>
