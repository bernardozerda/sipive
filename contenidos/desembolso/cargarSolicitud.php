<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Desembolso.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    
    setlocale(LC_TIME, 'spanish');
    
    $seqFormulario = $_POST['formulario'];
    
    $claFormulario = new FormularioSubsidios;
    $claFormulario->cargarFormulario( $seqFormulario );
    
    $claDesembolso = new Desembolso;
    $claDesembolso->cargarDesembolso( $seqFormulario );
    
	foreach( $claDesembolso->arrSolicitud['detalles'] as $seqSolicitud => $arrSolicitud ){
		$claDesembolso->arrSolicitud['detalles'][ $seqSolicitud ]['fchRegistroPresupuestal1Texto'] = utf8_encode( ucwords( strftime("%d de %B del %Y" , strtotime( $claDesembolso->arrSolicitud['detalles'][ $seqSolicitud ]['fchRegistroPresupuestal1'] ) ) ) ); 		
		
		if( strtotime( $claDesembolso->arrSolicitud['detalles'][ $seqSolicitud ]['fchRegistroPresupuestal2'] ) >= strtotime( "2000-01-01 00:00:00" ) ){
			$claDesembolso->arrSolicitud['detalles'][ $seqSolicitud ]['fchRegistroPresupuestal2Texto'] = utf8_encode( ucwords( strftime("%d de %B del %Y" , strtotime( $claDesembolso->arrSolicitud['detalles'][ $seqSolicitud ]['fchRegistroPresupuestal2'] ) ) ) );
		}else{
			$claDesembolso->arrSolicitud['detalles'][ $seqSolicitud ]['fchRegistroPresupuestal2Texto'] = "";
		}
		
		$claDesembolso->arrSolicitud['detalles'][ $seqSolicitud ]['fchRadicacionTexto'] = utf8_encode( ucwords( strftime("%d de %B del %Y" , strtotime( $claDesembolso->arrSolicitud['detalles'][ $seqSolicitud ]['fchRadicacion'] ) ) ) );
		$claDesembolso->arrSolicitud['detalles'][ $seqSolicitud ]['fchOrdenTexto'] = utf8_encode( ucwords( strftime("%d de %B del %Y" , strtotime( $claDesembolso->arrSolicitud['detalles'][ $seqSolicitud ]['fchOrden'] ) ) ) );
		$claDesembolso->arrSolicitud['detalles'][ $seqSolicitud ]['fchSolicitudTexto'] =  utf8_encode( ucwords( strftime("%d de %B del %Y a las %I:%M:%S" , strtotime( $claDesembolso->arrSolicitud['detalles'][ $seqSolicitud ]['fchSolicitud'] ) ) ) );
		$claDesembolso->arrSolicitud['detalles'][ $seqSolicitud ]['fchActualizacionTexto'] =  utf8_encode( ucwords( strftime("%d de %B del %Y a las %I:%M:%S" , strtotime( $claDesembolso->arrSolicitud['detalles'][ $seqSolicitud ]['fchActualizacion'] ) ) ) );
	} 
    
    $seqSolicitud  = $_POST['solicitud'];
    
    $arrRespuesta = array();
    $txtRespuesta = "";
    if( isset( $claDesembolso->arrSolicitud['detalles'][ $seqSolicitud ] ) ){
    	
    	$arrRegistro = $claDesembolso->arrSolicitud['detalles'][ $seqSolicitud ];

        //pr($arrRegistro);

    	if( intval( $arrRegistro['numRegistroPresupuestal1'] ) == 0 ){
    		$arrRegistro['numRegistroPresupuestal1'] = "Número Registro";
    	}
    	
    	list( $ano , $mes , $dia ) = split( "-" , $arrRegistro['fchRegistroPresupuestal1'] );
    	if( @checkdate( $mes , $dia , $ano ) === false ){
    		$arrRegistro['fchRegistroPresupuestal1Texto'] = "Fecha Registro";
    	} 
    	
    	if( intval( $arrRegistro['numRegistroPresupuestal2'] ) == 0 ){
    		$arrRegistro['numRegistroPresupuestal2'] = "Número Registro";
    	}
    	
    	list( $ano , $mes , $dia ) = split( "-" , $arrRegistro['fchRegistroPresupuestal2'] );
    	if( @checkdate( $mes , $dia , $ano ) === false ){
    		$arrRegistro['fchRegistroPresupuestal2Texto'] = "Fecha Registro";
    	}
    	
    	if( intval( $arrRegistro['valSolicitado'] ) == 0 ){
    		$arrRegistro['valSolicitado'] = "Valor Solicitado";
    	}
    	
    	if( intval( $arrRegistro['numRadiacion'] ) == 0 ){
    		$arrRegistro['numRadiacion'] = "Número Radicación";
    	}
    	
    	list( $ano , $mes , $dia ) = split( "-" , $arrRegistro['fchRadicacion'] );
    	if( @checkdate( $mes , $dia , $ano ) === false ){
    		$arrRegistro['fchRadicacionTexto'] = "Fecha Registro";
    	}
    	
    	if( intval( $arrRegistro['numOrden'] ) == 0 ){
    		$arrRegistro['numOrden'] = "Número Pago";
    	}
    	
    	list( $ano , $mes , $dia ) = split( "-" , $arrRegistro['fchOrden'] );
    	if( @checkdate( $mes , $dia , $ano ) === false ){
    		$arrRegistro['fchOrdenTexto'] = "Fecha Pago";
    	}
    	
    	if( intval( $arrRegistro['valOrden'] ) == 0 ){
    		$arrRegistro['valOrden'] = "Valor Pagado";
    	}
    	
    	$arrRespuesta['registro1'] 					= $arrRegistro['numRegistroPresupuestal1'];
    	$arrRespuesta['fecha1']   					= $arrRegistro['fchRegistroPresupuestal1Texto'];
    	$arrRespuesta['registro2'] 					= $arrRegistro['numRegistroPresupuestal2'];
    	$arrRespuesta['fecha2']    					= $arrRegistro['fchRegistroPresupuestal2Texto'];
    	$arrRespuesta['valor']     					= $arrRegistro['valSolicitado'];
    	$arrRespuesta['bolCedulaBeneficiario']		= $arrRegistro['bolDocumentoBeneficiario'];
    	$arrRespuesta['txtCedulaBeneficiario']		= $arrRegistro['txtDocumentoBeneficiario'];
    	$arrRespuesta['bolCartaAsignacion']			= $arrRegistro['bolCartaAsignacion'];
    	$arrRespuesta['txtCartaAsignacion']			= $arrRegistro['txtCartaAsignacion'];
    	$arrRespuesta['bolSubsecretariaEncargado']	= $arrRegistro['bolSubsecretariaEncargado'];
	    $arrRespuesta['bolSubdireccionEncargado']	= $arrRegistro['bolSubdireccionEncargado'];
    	$arrRespuesta['bolGiroTercero']				= $arrRegistro['bolGiroTercero'];
	    $arrRespuesta['txtGiroTercero']				= $arrRegistro['txtGiroTercero'];
    	$arrRespuesta['txtSubsecretaria']			= $arrRegistro['txtSubsecretaria'];
    	$arrRespuesta['txtSubdireccion']			= $arrRegistro['txtSubdireccion'];
    	$arrRespuesta['txtRevisoSubsecretaria']		= $arrRegistro['txtRevisoSubsecretaria'];
    	
    	
    	if( $claDesembolso->txtTipoDocumentos == "persona" ){
    		$arrRespuesta['bolCedulaVendedor']	= $arrRegistro['bolDocumentoVendedor'];
    		$arrRespuesta['txtCedulaVendedor']	= $arrRegistro['txtDocumentoVendedor'];
    		$arrRespuesta['bolGiroTercero']		= $arrRegistro['bolGiroTercero'];
	    	$arrRespuesta['txtGiroTercero']		= $arrRegistro['txtGiroTercero'];
    	}else{
    		$arrRespuesta['bolRut']					= $arrRegistro['bolRut'];
	    	$arrRespuesta['txtRut']					= $arrRegistro['txtRut'];
	    	$arrRespuesta['bolNit']					= $arrRegistro['bolNit'];
	    	$arrRespuesta['txtNit']					= $arrRegistro['txtNit'];
	    	$arrRespuesta['bolCedulaRepresentante'] = $arrRegistro['bolCedulaRepresentante'];
	    	$arrRespuesta['txtCedulaRepresentante']	= $arrRegistro['txtCedulaRepresentante'];
	    	$arrRespuesta['bolCamaraComercio']		= $arrRegistro['bolCamaraComercio'];
	    	$arrRespuesta['txtCamaraComercio']		= $arrRegistro['txtCamaraComercio'];
    	}
    	
    	if( $claFormulario->seqModalidad != 5 ){    		
    		
    		$arrRespuesta['bolAutorizacion']	= $arrRegistro['bolAutorizacion'];
    		$arrRespuesta['txtAutorizacion']	= $arrRegistro['txtAutorizacion'];    		
	    	$arrRespuesta['bolCertificacionBancaria']	= $arrRegistro['bolCertificacionBancaria'];
	    	$arrRespuesta['txtCertificacionBancaria']	= $arrRegistro['txtCertificacionBancaria'];

	    	if( $claFormulario->seqModalidad == 3 or $claFormulario->seqModalidad == 4 ){	    		
	    		$arrRespuesta['bolActaEntregaFisica']     = $arrRegistro['bolActaEntregaFisica'];
				$arrRespuesta['txtActaEntregaFisica']     = $arrRegistro['txtActaEntregaFisica'];
				$arrRespuesta['bolActaLiquidacion']    	  = $arrRegistro['bolActaLiquidacion'];
				$arrRespuesta['txtActaLiquidacion']    	  = $arrRegistro['txtActaLiquidacion'];	
	    	}
	    	
    	} else {
			$arrRespuesta['bolBancoArrendador']       = $arrRegistro['bolBancoArrendador'];
			$arrRespuesta['txtBancoArrendador']       = $arrRegistro['txtBancoArrendador'];
    	}

		if( $arrRegistro['numProyectoInversion'] == 488 ){
    		$arrRespuesta['proyecto488']  = 1;
    		$arrRespuesta['proyecto644']  = 0;
			$arrRespuesta['proyecto435']  = 0;
			$arrRespuesta['proyecto801']  = 0;
			$arrRespuesta['proyecto1075'] = 0;
    	} else if ( $arrRegistro['numProyectoInversion'] == 644 ) {
    		$arrRespuesta['proyecto488']  = 0;
    		$arrRespuesta['proyecto644']  = 1;
			$arrRespuesta['proyecto435']  = 0;
			$arrRespuesta['proyecto801']  = 0;
            $arrRespuesta['proyecto1075'] = 0;
    	} else if ( $arrRegistro['numProyectoInversion'] == 435 ) {
    		$arrRespuesta['proyecto488']  = 0;
    		$arrRespuesta['proyecto644']  = 0;
			$arrRespuesta['proyecto435']  = 1;
			$arrRespuesta['proyecto801']  = 0;
            $arrRespuesta['proyecto1075'] = 0;
    	} else if ( $arrRegistro['numProyectoInversion'] == 801 ) {
    		$arrRespuesta['proyecto488']  = 0;
    		$arrRespuesta['proyecto644']  = 0;
			$arrRespuesta['proyecto435']  = 0;
			$arrRespuesta['proyecto801']  = 1;
            $arrRespuesta['proyecto1075'] = 0;
    	}  else if ( $arrRegistro['numProyectoInversion'] == 1075 ) {
            $arrRespuesta['proyecto488']  = 0;
            $arrRespuesta['proyecto644']  = 0;
            $arrRespuesta['proyecto435']  = 0;
            $arrRespuesta['proyecto801']  = 0;
            $arrRespuesta['proyecto1075'] = 1;
        }

    	$arrRespuesta['numeroRadicado']				= $arrRegistro['numRadiacion'];
    	$arrRespuesta['fechaRadicado']				= $arrRegistro['fchRadicacionTexto'];
    	$arrRespuesta['numeroOrden']				= $arrRegistro['numOrden'];
    	$arrRespuesta['fechaOrden']					= $arrRegistro['fchOrdenTexto'];
    	$arrRespuesta['monto']						= $arrRegistro['valOrden'];
    	
    	$arrRespuesta['txtNombreBeneficiarioGiro']	= $arrRegistro['txtNombreBeneficiarioGiro'];
    	$arrRespuesta['numDocumentoBeneficiarioGiro'] = $arrRegistro['numDocumentoBeneficiarioGiro'];
    	$arrRespuesta['txtDireccionBeneficiarioGiro'] = $arrRegistro['txtDireccionBeneficiarioGiro'];
    	$arrRespuesta['numTelefonoGiro']			= $arrRegistro['numTelefonoGiro'];
        $arrRespuesta['txtCorreoGiro']				= $arrRegistro['txtCorreoGiro'];
    	
    	$arrRespuesta['numCuentaGiro']				= $arrRegistro['numCuentaGiro'];
    	$arrRespuesta['txtTipoCuentaGiro']          = $arrRegistro['txtTipoCuentaGiro'];
    	$arrRespuesta['seqBancoGiro']               = $arrRegistro['seqBancoGiro'];

//    	pr( $arrRespuesta );

    	$txtSeparador = "";
    	
    	$txtRespuesta = "var objRespuesta = { " . $txtSeparador;
    	foreach( $arrRespuesta as  $txtCampo => $txtValor ){
    		$txtRespuesta .= $txtCampo . ":";
    		if( $txtCampo == "numCuentaGiro" ){
    			$txtRespuesta .= "'" . $txtValor ."',"  . $txtSeparador;
    		}else if( is_numeric( $txtValor ) == 1 ){
    			$txtRespuesta .=  $txtValor . ","  . $txtSeparador;
    		}else{
    			$txtRespuesta .= "'" . $txtValor ."',"  . $txtSeparador;
    		}
    	}
    	$txtRespuesta .= "seqSolicitudEditar: $seqSolicitud }";
    			
    }
    
    echo $txtRespuesta;
    
?>
