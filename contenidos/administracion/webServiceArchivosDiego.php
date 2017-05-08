<?php

//	$txtPrefijoRuta = "./";
	$txtPrefijoRuta = "../../";
	include ( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include ( $txtPrefijoRuta . $arrConfiguracion['librerias']['nusoap'] . "nusoap.php" );
	include ( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	
	$objWebService = new soap_server();
	
	$objWebService->register(
		'subirArchivo'
	);
	
	$objWebService->register(
		'crearDirectorio'
	);
	
	function crearDirectorio( $arrDatosDirectorio ){
		
		return mkdir( $arrDatosDirectorio['txtRutaDirectorio'] . $arrDatosDirectorio['txtNombreDirectorio'] );
		
	}
		
	function subirArchivo( $arrDatosArchivo ){
		
		$txtNombreArchivo 	= $arrDatosArchivo['txtNombreArchivo']; 
		$txtDatosArchivo 	= $arrDatosArchivo['txtDatosArchivo'];
		$txtRutaDirectorio 	= $arrDatosArchivo['txtRutaDirectorio'];
		$txtArchivoExtencion = $arrDatosArchivo['txtArchivoExtencion'];
		
		$txtDatosArchivoNuevo = base64_decode($txtDatosArchivo);
		$fp = fopen($txtRutaDirectorio . $txtNombreArchivo .".". $txtArchivoExtencion, 'w');
		fwrite( $fp, $txtDatosArchivoNuevo );
		return;
	}
		
	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
	$objWebService->service($HTTP_RAW_POST_DATA);

?>
