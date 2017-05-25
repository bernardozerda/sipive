<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	
	$txtnombreGrafica 	= $_POST[ "nombre" ];
	$numSeries 			= $_POST[ "cuentaSeries" ];
	$arrNombreSeries 	= explode( "," , $_POST[ "nombreSeries" ] );
	
	$claSmarty->assign( "txtnombreGrafica" 	, $txtnombreGrafica );
	$claSmarty->assign( "numSeries" 		, $txtnombreGrafica );
	$claSmarty->assign( "arrNombreSeries" 	, $arrNombreSeries );
	$claSmarty->display( "crm/indicadorSolicitudDesembolso/mostrarSeriesGrafica.tpl" );	
	
?>
