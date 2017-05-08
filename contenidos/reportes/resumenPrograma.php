<?php

	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']. "Reportes.class.php" );

	$claReporte = new Reportes; 
	$claReporte->resumenPrograma();
	
	$claSmarty->assign( "txtIdFormulario" , "ReporetResumenPrograma" );
	$claSmarty->assign( "arrTablas" , $claReporte->arrTablas );
	$claSmarty->assign( "txtGraficas" , $claReporte->php2js() );
	$claSmarty->display( "reportes/baseReportes.tpl"  );

?>
