<?php

	$txtPrefijoRuta = "./";
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
	
	$objWebService->register(
		'obtenerSecuencialesDeDesembolso'
	);
	
	$objWebService->register(
		'obtenerSecuencialesDeDesembolsoSolicitud'
	);
	
	$objWebService->register(
		'obtenerSecuencialesDeDesembolsoEstudioTitulos'
	);
	
	$objWebService->register(
		'obtenerSecuencialesDeDesembolsoTecnica'
	);
	
	$objWebService->register(
		'obtenerSecuencialesDeDesembolsoJuridica'
	);
	
	$objWebService->register(
		'devolverEstadoProceso'
	);
	
	function obtenerSecuencialesDeDesembolsoJuridica( $arrSecuenciales ){
		global $aptBd;
		
		$arrSecuencialesTotal = $arrSecuenciales["arrSecuencialesTotal"];
		
		$sql = "select
				distinct des.seqFormulario
				from T_DES_DESEMBOLSO des
				inner join T_DES_JURIDICO jur on jur.seqDesembolso = des.seqDesembolso
				where jur.seqDesembolso in (". 
				implode(",", $arrSecuencialesTotal)
				.")";
		$objRes = $aptBd->execute( $sql );
		
		$arrSecuencialesDevolver = array();
		while( $objRes->fields ){
			$arrSecuencialesDevolver[] = $objRes->fields["seqFormulario"];
			$objRes->MoveNext();
		}
		
		return $arrSecuencialesDevolver;
	}
	
	function obtenerSecuencialesDeDesembolsoTecnica( $arrSecuenciales ){
		global $aptBd;
		
		$arrSecuencialesTotal = $arrSecuenciales["arrSecuencialesTotal"];
		
		$sql = "select
				distinct des.seqFormulario
				from T_DES_DESEMBOLSO des
				inner join T_DES_TECNICO tec on tec.seqDesembolso = des.seqDesembolso
				where tec.seqDesembolso in (". 
				implode(",", $arrSecuencialesTotal)
				.")";
		$objRes = $aptBd->execute( $sql );
		
		$arrSecuencialesDevolver = array();
		while( $objRes->fields ){
			$arrSecuencialesDevolver[] = $objRes->fields["seqFormulario"];
			$objRes->MoveNext();
		}
		
		return $arrSecuencialesDevolver;
	}
	
	function obtenerSecuencialesDeDesembolsoEstudioTitulos( $arrSecuenciales ){
		global $aptBd;
		
		$arrSecuencialesTotal = $arrSecuenciales["arrSecuencialesTotal"];
		
		$sql = "select
				distinct des.seqFormulario
				from T_DES_DESEMBOLSO des
				inner join T_DES_ESTUDIO_TITULOS est on est.seqDesembolso = des.seqDesembolso
				where est.seqDesembolso in (". 
				implode(",", $arrSecuencialesTotal)
				.")";
		$objRes = $aptBd->execute( $sql );
		
		$arrSecuencialesDevolver = array();
		while( $objRes->fields ){
			$arrSecuencialesDevolver[] = $objRes->fields["seqFormulario"];
			$objRes->MoveNext();
		}
		
		return $arrSecuencialesDevolver;
	}
	
	function obtenerSecuencialesDeDesembolsoSolicitud( $arrSecuenciales ){
		 global $aptBd;
		
		$arrSecuencialesTotal = $arrSecuenciales["arrSecuencialesTotal"];
		
		$sql = "select
				distinct des.seqFormulario
				from T_DES_DESEMBOLSO des
				inner join T_DES_SOLICITUD sol on sol.seqDesembolso = des.seqDesembolso
				where des.seqFormulario in (". 
				implode(",", $arrSecuencialesTotal)
				.")";
		return $sql;
		$objRes = $aptBd->execute( $sql );
		
		$arrSecuencialesDevolver = array();
		while( $objRes->fields ){
			$arrSecuencialesDevolver[] = $objRes->fields["seqFormulario"];
			$objRes->MoveNext();
		}
		
		return $arrSecuencialesDevolver;
		
	}
	
	function obtenerSecuencialesDeDesembolso( $arrVacio ){
		 global $aptBd;
		 
		 $sql = "select
				distinct seg.seqFormulario
				from T_SEG_SEGUIMIENTO seg
				where seg.seqUsuario = 126
				and seg.txtComentario like '%Migracion%'"
			;
		$objRes = $aptBd->execute( $sql );
		
		$arrSecuencialesFormulario = array();
		while( $objRes->fields ){
			$arrSecuencialesFormulario[] = $objRes->fields["seqFormulario"];
			$objRes->MoveNext();
		}
		
		$sql = "select
				des.seqDesembolso,
				des.seqFormulario
				from T_DES_DESEMBOLSO des
				where des.seqFormulario in (". implode(",", $arrSecuencialesFormulario) .")"
			;
		$objRes = $aptBd->execute( $sql );
		
		$arrSecuencialesDesembolso = array();
		while( $objRes->fields ){
			$arrSecuencialesDesembolso[] = array( 
											"seqFormulario" => $objRes->fields["seqFormulario"], 
											"seqDesembolso" => $objRes->fields["seqDesembolso"] 
										);
			$objRes->MoveNext();
		}
		
		return $arrSecuencialesDesembolso;
		
	}
	
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
	
	function devolverEstadoProceso( $arrDatos ){
		global $aptBd;
		$arrSecuenciales					  = $arrDatos["arrSecuenciales"];
		$arrSecuencialesEstadoProcesoOriginal = $arrDatos["arrSecuencialesEstadoProcesoOriginal"];
		
		foreach($arrSecuenciales as $seqFormulario){
			$claFormulario 		= new FormularioSubsidios;
			$claFormulario->cargarFormulario( $seqFormulario );
			$claFormulario->seqEstadoProceso = $arrSecuencialesEstadoProcesoOriginal[ $seqFormulario ];
			$claFormulario->editarFormulario( $seqFormulario );
		} 
		return;
		
	}
	
	function cambioEstadoProceso( $arrDatos ){
		global $aptBd;
		$arrSecuenciales	= $arrDatos["arrSecuenciales"];
		$seqEstadoProceso 	= $arrDatos["seqEstadoProceso"];
		
		foreach($arrSecuenciales as $seqFormulario){
			$claFormulario 		= new FormularioSubsidios;
			$claFormulario->cargarFormulario( $seqFormulario );
			
			$txtCambios = "Cambios en el formulario $seqFormulario\r\n";
			$txtCambios.= "seqEstadoProceso, Valor Anterior: " . $claFormulario->seqEstadoProceso .", Valor Nuevo: " . $seqEstadoProceso . "\n";
			
			$sql = "
				INSERT INTO T_SEG_SEGUIMIENTO ( 
					seqFormulario, 
					fchMovimiento, 
					seqUsuario, 
					txtComentario, 
					txtCambios, 
					numDocumento, 
					txtNombre, 
					seqGestion
				) VALUES (
					$seqFormulario,
					now(),
					126,
					\"Cambio de Estado desde el Migracion  De datos\",
					\"" . ereg_replace( "\"" , "" , $txtCambios ) . "\",
					'',
					'',
					40
						)					
					";
			$aptBd->execute( $sql );
			$claFormulario->seqEstadoProceso = $seqEstadoProceso;
			$claFormulario->editarFormulario( $seqFormulario );
		} 
		return;
	}
	
	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
	$objWebService->service($HTTP_RAW_POST_DATA);

?>
