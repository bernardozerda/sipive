<?php

	$txtPrefijoRuta = "../../";
	include ( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include ( $txtPrefijoRuta . $arrConfiguracion['librerias']['nusoap']. "nusoap.php" );
	
	$objRecibirArchivo = new soap_server();
	
	$objRecibirArchivo->register(
		'recibirArchivo'
	);
	
	function recibirArchivo( $arrDatosArchivo ){
		
		$txtNombreArchivo = $arrDatosArchivo['txtNombreArchivo']; 
		$txtDatosArchivo  = $arrDatosArchivo['txtDatosArchivo'];
		$txtDatosArchivoNuevo  = base64_decode($txtDatosArchivo);
		$fp = fopen($txtNombreArchivo, 'w');
		fwrite($fp, $txtDatosArchivoNuevo);
		fclose($fp);
		return $txtDatosArchivo;
		
	}
	
	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
	$objRecibirArchivo->service($HTTP_RAW_POST_DATA);

?>
