<?php

//	$txtPrefijoRuta = "./";
	$txtPrefijoRuta = "../../";
	include ( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include ( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Desembolso.class.php");
	include ( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php");
	include ( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php");
	include ( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php");
	include ( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include ( $txtPrefijoRuta . $arrConfiguracion['librerias']['nusoap'] . "nusoap.php" );
	include ( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	
	$objWebService = new soap_server();
	
	$objWebService->register(
		'recibirArchivo'
	);
	$objWebService->register(
		'obtenerClaseDesembolso'
	);
	$objWebService->register(
		'salvarBusquedaOferta'
	);
	$objWebService->register(
		'salvarConceptoTecnico'
	);	
	$objWebService->register(
		'generarTextoSeguimiento'
	);
	
	$objWebService->register(
		'obtenerClaseFormulario'
	);
	
	$objWebService->register(
		'salvarEstudioTitulos'
	);
	
	$objWebService->register(
		'cambioEstadoProceso'
	);
	
	$objWebService->register(
		'salvarRevisionOferta'
	);
	
	$objWebService->register(
		'formularioVinculado'
	);
	
	$objWebService->register(
		'salvarSolicitud'
	);
	
	function formularioVinculado( $arrPost ){
		
		$numDocumento = $arrPost['numDocumento'];
		$claCiudadano = new Ciudadano;
		$seqFormulario = $claCiudadano->formularioVinculado( $numDocumento );
		return $seqFormulario;
		
	}
	
	function generarTextoSeguimiento( $arrDatosSeguimiento ){
		
		$seqFormulario = $arrDatosSeguimiento['seqFormulario'];
 		
 		$claDesembolsoAnterior = new Desembolso;
 		$claDesembolsoAnterior->cargarDesembolso( $seqFormulario );
 		
 		$claSeguimiento = new Seguimiento;
 		$txtFase = $arrDatosSeguimiento['txtFase'];
 		
 		$txtCambios = $claSeguimiento->cambiosDesembolso( $txtFase , $claDesembolsoAnterior , $arrDatosSeguimiento );
		return $txtCambios;
	}
	
	function salvarEstudioTitulos( $arrPost ){
		$claDesembolso = new Desembolso;
		$arrRespuesta = $claDesembolso->salvarEstudioTitulos( $arrPost );
		return $arrRespuesta;
	}
	
	function salvarSolicitud( $arrPost ){
		$claDesembolso = new Desembolso;
		$arrRespuesta = $claDesembolso->salvarSolicitud( $arrPost, "" );
		return $arrRespuesta;
	}
	
	function salvarBusquedaOferta( $arrPost ){
		$claDesembolso = new Desembolso;
		$arrRespuesta = $claDesembolso->salvarBusquedaOferta( $arrPost );
		return $arrRespuesta;
	}
	
	function salvarConceptoTecnico( $arrPost ){
		$claDesembolso = new Desembolso;
		$arrRespuesta = $claDesembolso->salvarConceptoTecnico( $arrPost );
		return $arrRespuesta;
	}
	
	function salvarRevisionOferta( $arrPost ){
		$claDesembolso = new Desembolso;
		$arrRespuesta = $claDesembolso->salvarConceptoJuridico( $arrPost );
		return $arrRespuesta;
	}
		
	function recibirArchivo( $arrDatosArchivo ){
		$txtNombreArchivo = $arrDatosArchivo['txtNombreArchivo']; 
		$txtDatosArchivo  = $arrDatosArchivo['txtDatosArchivo'];
		$txtRutaImagenes  = $arrDatosArchivo['txtRutaImagenes'];
		$txtArchivoExtencion = $arrDatosArchivo['txtArchivoExtencion'];
		$txtDatosArchivoNuevo = base64_decode($txtDatosArchivo);
		$fp = fopen($txtRutaImagenes . $txtNombreArchivo .".". $txtArchivoExtencion, 'w');
		fwrite($fp, $txtDatosArchivoNuevo);
		fclose($fp);
		return;
	}
	
	function obtenerClaseDesembolso( $arrDatos ){
		$seqFormulario = $arrDatos['seqFormulario'];
		$claDesembolso = new Desembolso;
		$claDesembolso->cargarDesembolso( $seqFormulario );
		return $claDesembolso;
	}
	
	function obtenerClaseFormulario( $arrDatos ){
		$seqFormulario = $arrDatos['seqFormulario'];
		$claFormulario = new FormularioSubsidios;
		$claFormulario->cargarFormulario( $seqFormulario );
		return $claFormulario;
	}
	
	function cambioEstadoProceso( $arrDatos ){
		$seqFormulario 		= $arrDatos["seqFormulario"];
		$seqEstadoProceso 	= $arrDatos["seqEstadoProceso"];
		$claFormulario 		= new FormularioSubsidios;
		$claFormulario->cargarFormulario( $seqFormulario );
		$claFormulario->seqEstadoProceso = $seqEstadoProceso;
		$claFormulario->editarFormulario( $seqFormulario );
		return;
	}
	
	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
	$objWebService->service($HTTP_RAW_POST_DATA);

?>
