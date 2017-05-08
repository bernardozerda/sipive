<?php

	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']. "Reportes.class.php" );
	
	setlocale(LC_TIME, 'spanish');
	$txtFecha = utf8_encode( ucwords( strftime("%A %#d de %B del %Y") ) ) ." " . date( "H:i:s" );
	
	$claReporte = new Reportes; 
	$claReporte->estadoCorte( );
	
	$arrGraficas = &$claReporte->arrGraficas;
	
	$txtGrafica = $_GET["txtGrafica"];
	
	foreach( $arrGraficas as $txtLabel => $arrDatosGrafica){
		foreach( $arrDatosGrafica as $txtGraficaActual => $arrGraficaActual){
			if( $txtGraficaActual != $txtGrafica ){
				unset($arrGraficas[$txtLabel][$txtGraficaActual]);
			}
		}
	}
	$claSmarty->assign( "txtDivGraficas" , $txtGrafica );
	$claSmarty->assign( "txtGraficas" , $claReporte->php2js() );
	$claSmarty->display( "reportes/formatoResumenPrograma.tpl" );
	
?>