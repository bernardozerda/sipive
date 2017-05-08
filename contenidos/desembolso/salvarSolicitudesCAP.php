<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Desembolso.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );

    /**
     * VALIDACIONES DEL ARCHIVO.... DESCRIPCION DE LAS POSICIONES
     ******************************************************************* 
      	0	Nùmero de documento del Postulante Principal
		1	Fecha de la solicitud
		2	Número del Proyecto de Inversion
		3	Número Registro Presupuesta 1
		4	Fecha Registro Presupuesta 1
		5	Número Registro Presupuesta 2 (opcional)
		6	Fecha Registro Presupuesta 2 (opcional)
		7	Nombre del Beneficiario del giro
		8	Documento del Beneficiario del giro
		9	Dirección del Beneficiario del giro
		10	Teléfono del Beneficiario del giro
		11	Número de Cuenta del Beneficiario del giro
		12	Tipo de Cuenta del Beneficiario del giro
		13	Banco de la Cuenta del Beneficiario del giro
		14	Valor de la solicitud (sin comas ni simbolos de moneda ni puntos "$")
		15	Nombre Firma Subsecretaría
		16	Subsecretaría Encargado (Si o No)
		17	Nombre Firma Subdireccion Recursos Publicos
		18	Subdireccion Encargado (Si o No)
		19	Nombre Elaboró
		20	Numero de Radicacion
		21	Fecha de Radicacion
		22	Numero de Orden de Pago
		23	Fecha de Orden de Pago
		24	Valor Pagado
     ******************************************************************* 
     */
    
    // arreglo de errores
    $arrErrores = array();
    $arrMensajes = array();
    
    // Proyectos de inversion
    $arrProyectoInversion[] = 488;
    $arrProyectoInversion[] = 644;
    
    // tipos de cuenta
    $arrTipoCuenta[] = "ahorros";
    $arrTipoCuenta[] = "corriente";
    $arrTipoCuenta[] = "cheque";
    
    $arrSiNo[1] = "si";
    $arrSiNo[0] = "no";
    
    $arrEstadosPermitidos[ 29 ] = 30; // Desembolso - Estudio de Titulos Aprobado
    $arrEstadosPermitidos[ 30 ] = 0;  // Desembolso - Solicitud de desembolso 
    $arrEstadosPermitidos[ 32 ] = 0;  // Desembolso - Desembolso Parcial
    
    // bancos validos
    try {
    	$sql = "
    		SELECT 
    			seqBanco,
    			txtBanco
    		FROM T_FRM_BANCO
    		WHERE seqBanco <> 1
    	";
    	$objRes = $aptBd->execute( $sql );
    	while( $objRes->fields ){
    		$arrBancos[ $objRes->fields['seqBanco'] ] = strtolower( trim( $objRes->fields['txtBanco'] ) );
    		$objRes->MoveNext();
    	}
    } catch ( Exception $objErrores ){
    	$arrErrores[] = "No se han podido obtener los bancos de la base de datos";
    }
    
	switch( $_FILES['archivo']['error'] ){
		case UPLOAD_ERR_INI_SIZE:
		  $arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
		break;  
		case UPLOAD_ERR_FORM_SIZE:
		  $arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
		break; 
		case UPLOAD_ERR_PARTIAL:
		  $arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
		break; 
		case UPLOAD_ERR_NO_FILE:
		  $arrErrores[] = "Debe especificar un archivo para cargar";
		break; 
	} 
    
    if( empty( $arrErrores ) ){
    	
    	/**
    	 * VALIDACIONES BASICAS DEL ARCHIVO
    	 * TIPO DE DATOS Y OTRAS VALIDACIONES SENCILLAS
    	 */
    	
	    try {
	    	$aptArchivo = fopen( $_FILES['archivo']['tmp_name'] , "r" );
	    	$arrTitulos = split( "\t" , fgets( $aptArchivo ) );
	    	$numLinea = 1;
	    	while( $txtLinea = fgets( $aptArchivo ) ){
	    		
	    		// Limpieza de la linea
	    		$arrLinea = split( "\t" , $txtLinea );
	    		foreach( $arrLinea as $numPosicion => $txtValor ){
	    			$arrLinea[ $numPosicion ] = trim( $txtValor );
	    		}
	    		
	    		// Numero documento postulante principal
	    		if( ! is_numeric( $arrLinea[ 0 ] ) ){
	    			$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 0 ] . ": El número de documento debe ser numérico";
	    		}else{
	    			$arrDocumentos[] = $arrLinea[ 0 ];
	    		}
	    		
	    		// fecha de la solicitud
	    		list( $ano , $mes , $dia ) = split( "-" , $arrLinea[ 1 ] );
	    		if( @checkdate($mes, $dia, $ano) != true ){
	    			$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 1 ] . ": La fecha no está en el formato correcto (aaaa-mm-dd)";
	    		}
	    		
		    	// Numero Proyecto de inversion
	    		if( ! ( is_numeric( $arrLinea[ 2 ] ) and in_array( $arrLinea[ 2 ] , $arrProyectoInversion ) ) ){
	    			$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 2 ] . ": El número de proyecto debe ser 488 o 644";
	    		}
	    		
	    		// Numero de registro presupuestal 1
    			if( ! is_numeric( $arrLinea[ 3 ] ) ){
    				$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 3 ] . ": Debe haber un numero de registro presupuestal 1";
    			}
	    		
	    		// fecha de la solicitud 1
	    		list( $ano , $mes , $dia ) = split( "-" , $arrLinea[ 4 ] );
	    		if( @checkdate($mes, $dia, $ano) != true ){
	    			$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 4 ] . ": La fecha del registro presupuestal no está en el formato correcto (aaaa-mm-dd)";
	    		}
	    		
		    	// Numero de registro presupuestal 2
    			if( trim( $arrLinea[ 5 ] ) != "" ){
	    			if( ! is_numeric( $arrLinea[ 5 ] ) ){
	    				$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 5 ] . ": El número de registro presupuestal 2 debe ser un numero";
	    			}	
    			} 
	    		
		    	// fecha de la solicitud 1
    			if( trim( $arrLinea[ 5 ] ) != "" ){
	    			list( $ano , $mes , $dia ) = split( "-" , $arrLinea[ 6 ] );
		    		if( @checkdate($mes, $dia, $ano) != true ){
		    			$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 6 ] . ": La fecha del registro presupuestal no está en el formato correcto (aaaa-mm-dd)";
		    		}
    			}
	    		
		    	// Nombre del beneficiario del giro
    			if( trim( $arrLinea[ 7 ] ) == "" ){
	    			$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 7 ] . ": Debe escribir el nombre del beneficiario del giro";
    			}
    			
	    		// Numero documento beneficiario del giro
	    		if( ! is_numeric( $arrLinea[ 8 ] ) ){
	    			$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 8 ] . ": El número de documento del beneficiario del giro debe ser numérico";
	    		}
    			
		    	// Direccion del beneficiario del giro
    			if( trim( $arrLinea[ 9 ] ) == "" ){
	    			$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 9 ] . ": Debe escribir la dirección del beneficiario del giro";
    			}
	    		
	    		// Numero telefono beneficiario del giro
	    		if( ! is_numeric( $arrLinea[ 10 ] ) ){
	    			$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 10 ] . ": El número de tléfono del beneficiario del giro debe ser numérico";
	    		}
	    		
	    		// Numero de cuenta del beneficiario del giro
    			if( trim( $arrLinea[ 11 ] ) == "" ){
	    			$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 11 ] . ": Debe escribir la cuenta del beneficiario del giro";
    			}
	    		
    			// Tipo de cuenta del beneficiario del giro
    			if( ! in_array( strtolower( trim( $arrLinea[ 12 ] ) ), $arrTipoCuenta ) ){
    				$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 12 ] . ": El tipo de cuenta debe ser Ahorros, Corriente o Cheque";
    			}
    			
		    	// Banco del beneficiario del giro
    			if( ! in_array( strtolower( trim( $arrLinea[ 13 ] ) ), $arrBancos ) ){
    				$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 13 ] . ": No se reconoce el banco " . $arrLinea[ 13 ];
    			}else{
    				$arrRetorno = array_keys( $arrBancos , strtolower( trim( $arrLinea[ 13 ] ) ) );
    				$arrLinea[ 13 ] = $arrRetorno[ 0 ];    				
    			}
    			
    			// Valor de la solicitud
    			if( ! is_numeric( $arrLinea[ 14 ] ) ){
    				$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 14 ] . ": El valor solicitado debe ser numérico";
    			}
    			
    			// Nombre firma subsecretaria
    			if( trim( $arrLinea[ 15 ] ) == "" ){
    				$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 15 ] . ": Indique el nombre de quien firma por parte de la subsecretaría";
    			}
    			
    			// Subsecretaría Encargado (Si o No)
    			if( ! in_array( strtolower( trim( $arrLinea[ 16 ] ) ) , $arrSiNo ) ){
    				$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 16 ] . ": El valor para encargado (subsecretaria) es Si o No";
    			} else {
    				$arrRetorno = array_keys( $arrSiNo , strtolower( trim( $arrLinea[ 16 ] ) ) );
    				$arrLinea[ 16 ] = $arrRetorno[ 0 ];    	
    			}
    			
	    		// Nombre firma subdireccion
    			if( trim( $arrLinea[ 17 ] ) == "" ){
    				$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 17 ] . ": Indique el nombre de quien firma por parte de la subdireccion";
    			}
    			
    			// Subdireccion Encargado (Si o No)
    			if( ! in_array( strtolower( trim( $arrLinea[ 18 ] ) ) , $arrSiNo ) ){
    				$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 18 ] . ": El valor para encargado (subdireccion) es Si o No";
    			} else {
    				$arrRetorno = array_keys( $arrSiNo , strtolower( trim( $arrLinea[ 18 ] ) ) );
    				$arrLinea[ 18 ] = $arrRetorno[ 0 ];
    			}
    			
	    		// Nombre firma elaboro
    			if( trim( $arrLinea[ 19 ] ) == "" ){
    				$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 19 ] . ": Indique el nombre de quien elabora el documento";
    			}
    			
    			// Numero de radicacion
    			if( trim( $arrLinea[ 20 ] ) != "" ){
    				if( ! is_numeric( $arrLinea[ 20 ] ) ){
    					$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 20 ] . ": El número de radicacion debe ser un numero";
    				}
    			}
    			
	    		// Fecha de radicacion
    			if( trim( $arrLinea[ 20 ] ) != "" ){
    				list( $ano , $mes , $dia ) = split( "-" , $arrLinea[ 21 ] );
		    		if( @checkdate($mes, $dia, $ano) != true ){
		    			$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 21 ] . ": La fecha de radicacion no está en el formato correcto (aaaa-mm-dd)";
		    		}
    			}
    			
    			
	    		// Numero de orden de pago
    			if( trim( $arrLinea[ 22 ] ) != "" ){
    				if( ! is_numeric( $arrLinea[ 22 ] ) ){
    					$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 22 ] . ": El número de orden de pago debe ser un número";
    				}
    			}
    			
	    		// Fecha de orden de pago
    			if( trim( $arrLinea[ 22 ] ) != "" ){
    				list( $ano , $mes , $dia ) = split( "-" , $arrLinea[ 23 ] );
		    		if( @checkdate($mes, $dia, $ano) != true ){
		    			$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 23 ] . ": La fecha de radicacion no está en el formato correcto (aaaa-mm-dd)";
		    		}
    			}
    			
		    	// valor pagado
    			if( trim( $arrLinea[ 22 ] ) != "" ){
    				if( ! is_numeric( $arrLinea[ 24 ] ) ){
    					$arrErrores[] = "Error Linea $numLinea, columna " . $arrTitulos[ 24 ] . ": El valor pagado debe ser un número ==> " . var_dump($arrLinea[24]);
    				}
    			}
    			
    			// asocia la linea con un arreglo
	    		if( empty( $arrErrores ) ){
	    			$arrArchivo[] = $arrLinea; 
	    		}
	    		$numLinea++;
	    	}
	    } catch ( Exception $objError ){
	    	$arrErrores[] = "No se pudo abrir el archivo";
	    }
    }
    
    /**
     * VALIDACIONES EXTENDIDAS
     * BASE DE DATOS
     */
    
    if( empty( $arrErrores ) ){
    	
    	$arrEstados = array();
    	
    	try {
    		// modalidades y estados del proceso de las cedulas
    		$sql = "
				SELECT
					frm.seqFormulario,
					ciu.numDocumento,
					frm.seqEstadoProceso,
					frm.seqModalidad,
					if( isnull( SUM( sol.valSolicitado ) ) = 1, frm.valAspiraSubsidio , frm.valAspiraSubsidio - SUM( sol.valSolicitado ) ) as valSaldo,
					(
					  SELECT 
					    hvi.numActo
					  FROM T_AAD_FORMULARIO_ACTO fac
					  INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON fac.seqFormularioActo = hvi.seqFormularioActo
					  WHERE fac.seqFormulario = frm.seqFormulario
					    AND hvi.seqTipoActo = 1
					  ORDER BY hvi.fchActo DESC
					  LIMIT 1
					) as numActo,
					(
					  SELECT 
					    hvi.fchActo
					  FROM T_AAD_FORMULARIO_ACTO fac
					  INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON fac.seqFormularioActo = hvi.seqFormularioActo
					  WHERE fac.seqFormulario = frm.seqFormulario
					    AND hvi.seqTipoActo = 1
					  ORDER BY hvi.fchActo DESC
					  LIMIT 1
					) as fchActo,
					(
					  SELECT 
					    fac.seqFormularioActo
					  FROM T_AAD_FORMULARIO_ACTO fac
					  INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON fac.seqFormularioActo = hvi.seqFormularioActo
					  WHERE fac.seqFormulario = frm.seqFormulario
					    AND hvi.seqTipoActo = 1
					  ORDER BY hvi.fchActo DESC
					  LIMIT 1
					) as seqFormularioActo,
					UPPER( CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 ) ) as txtNombre
				FROM T_FRM_FORMULARIO frm
				INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
				INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
				LEFT JOIN T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario
				LEFT JOIN T_DES_SOLICITUD sol ON sol.seqDesembolso = des.seqDesembolso
				WHERE hog.seqParentesco = 1 
				  AND ciu.seqTipoDocumento IN (1,2,3,4,5,6)
				  AND ciu.numDocumento IN ( " . implode( "," , $arrDocumentos ) . " )
				GROUP BY 
					frm.seqFormulario
    		";
			$objRes = $aptBd->execute( $sql );
			while( $objRes->fields ){
				$arrEstados[ $objRes->fields['numDocumento'] ] = $objRes->fields;
				$objRes->MoveNext();
			}
    	} catch ( Exception $objError ){
    		$arrErrores[] = "No se ha podido conocer el estado de los hogares";
    	}

//    	pr( $arrEstados );
//    	exit(0);
    	
    	if( empty( $arrErrores ) ){
	    	foreach( $arrArchivo as $numLinea => $arrDatos ){
	    		
	    		// existencua del numero de documento
	    		$numDocumento = $arrDatos[ 0 ];
	    		if( ! isset( $arrEstados[ $numDocumento ] ) ){
	    			$arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ", columna " . $arrTitulos[ 0 ] . ": El numero de documento no esta en la base de datos como postulante principal";
	    		}

	    		// Otros datos necesarios
	    		$arrArchivo[ $numLinea ]['seqFormulario'] = $arrEstados[ $numDocumento ]['seqFormulario'];
	    		$arrArchivo[ $numLinea ]['seqFormularioActo'] = $arrEstados[ $numDocumento ]['seqFormularioActo'];
	    		$arrArchivo[ $numLinea ]['txtNombre'] = $arrEstados[ $numDocumento ]['txtNombre'];
	    		
	    		// Numero de documento con estado de proceso
	    		$seqEstadoProceso = $arrEstados[ $numDocumento ]['seqEstadoProceso'];
	    		if( isset( $arrEstadosPermitidos[ $seqEstadoProceso ] ) ){
	    			$seqEstadoFuturo = $arrEstadosPermitidos[ $seqEstadoProceso ];
	    		} else {
	    			$arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ", columna " . $arrTitulos[ 0 ] . ": El estado del proceso " . $arrEstados[ $numDocumento ]['txtEstado'] . " no es un estado permitido para las solicitudes masivas";
	    		}
	    		
	    		// Numero de documento con estado de proceso
	    		if( isset( $arrEstadosPermitidos[ $seqEstadoProceso ] ) ){
	    			if( $arrEstados[ $numDocumento ]['seqModalidad'] != 5 ){
	    				$arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ", columna " . $arrTitulos[ 0 ] . ": La modalidad " . $arrEstados[ $numDocumento ]['txtModalidad'] . " no esta autorizada para generar solicitudes masivas";	
	    			}
	    		}
				
	    		// control del saldo del subsidio
	    		if( ( $arrEstados[ $numDocumento ]['valSaldo'] - $arrDatos[ 14 ] ) < 0 ){
	    			$arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ", columna " . $arrTitulos[ 0 ] . ": El valor de la solicitud supera el saldo del subsidio";
	    		}
	    		
	    		// verificar que tenga acto administrativo
	    		if( intval( $arrEstados[ $numDocumento ]['numActo'] ) != 0 ){
	    			list( $ano , $mes , $dia ) = split( "-" , $arrEstados[ $numDocumento ]['fchActo'] );
	    			if( @checkdate($mes, $dia, $ano) !== true ){
	    				$arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ", columna " . $arrTitulos[ 0 ] . ": El documento no parece estar asociado a un acto administrativo de asignacion";
	    			}
	    		} else {
	    			$arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ", columna " . $arrTitulos[ 0 ] . ": El documento no parece estar asociado a un acto administrativo de asignacion";
	    		}
	    		
	    	}
    	}
    }

    if( empty( $arrErrores ) ){
    	
    	foreach( $arrArchivo as $numLinea => $arrDatos ){
    		
    		$arrPost['creacion'] = $arrDatos[ 1 ];
 			$arrPost['registro1']  = $arrDatos[ 3 ];
			$arrPost['fecha1']  = $arrDatos[ 4 ];
			$arrPost['registro2']  = $arrDatos[ 5 ];
			$arrPost['fecha2']  = $arrDatos[ 6 ];
			$arrPost['valor']  = $arrDatos[ 14 ];
			$arrPost['bolCedulaBeneficiario']  = 1;
			$arrPost['bolCedulaVendedor']  = 1;
			$arrPost['bolCertificacionBancaria']  = 1;
			$arrPost['bolCartaAsignacion']  = 1;
			$arrPost['bolAutorizacion']  = 1;
			$arrPost['txtSubsecretaria']  = $arrDatos[ 15 ];
			$arrPost['bolSubsecretariaEncargado']  = $arrDatos[ 16 ];
			$arrPost['txtSubdireccion']  = $arrDatos[ 17 ];
			$arrPost['bolSubdireccionEncargado']  = $arrDatos[ 18 ];
			$arrPost['txtRevisoSubsecretaria']  = $arrDatos[ 19 ];
			$arrPost['usuario']  = $_SESSION['txtUsuario'];
			$arrPost['numeroRadicado']  = $arrDatos[ 20 ];
			$arrPost['fechaRadicado']  = $arrDatos[ 21 ];
			$arrPost['numeroOrden']  = $arrDatos[ 22 ];
			$arrPost['fechaOrden']  = $arrDatos[ 23 ];
			$arrPost['monto']  = $arrDatos[ 24 ];
			$arrPost['numProyectoInversion']  = $arrDatos[ 2 ];
			$arrPost['txtNombreBeneficiarioGiro']  = $arrDatos[ 7 ];
			$arrPost['numDocumentoBeneficiarioGiro'] = $arrDatos[ 8 ];
			$arrPost['txtDireccionBeneficiarioGiro'] = $arrDatos[ 9 ];
			$arrPost['numTelefonoGiro']  = $arrDatos[ 10 ];
			$arrPost['numCuentaGiro']  = $arrDatos[ 11 ];
			$arrPost['txtTipoCuentaGiro']  = $arrDatos[ 12 ];
			$arrPost['seqBancoGiro']  = $arrDatos[ 13 ];
			$arrPost['bolRut']  = 1;
			$arrPost['bolNit']  = 1;
			$arrPost['bolCedulaRepresentante']  = 1;
			$arrPost['bolCamaraComercio']  = 1;
			$arrPost['bolGiroTercero']  = 1;
			$arrPost['bolBancoArrendador']  = 1;
			$arrPost['bolActaEntregaFisica']  = 1;
			$arrPost['bolActaLiquidacion']  = 1;
	    	
			$arrPost['seqFormulario'] = $arrDatos['seqFormulario'];
		    $arrPost['txtComentario'] = "Cargue de solicitudes masivas";
			$arrPost['txtCambios']    = ""; 
		    $arrPost['cedula']		   = $arrDatos[ 0 ];
		    $arrPost['nombre']		   = $arrDatos['txtNombre'];
		    $arrPost['seqGestion']    = 46;
			
		    $sql = "
			    SELECT
				  sol.seqSolicitud
				FROM T_FRM_FORMULARIO frm
				INNER JOIN T_DES_DESEMBOLSO des on des.seqFormulario = frm.seqFormulario
				INNER JOIN T_DES_SOLICITUD sol on sol.seqDesembolso = des.seqDesembolso
				WHERE frm.seqFormulario = 8421
				  AND sol.fchCreacion >= '" . $arrDatos[ 1 ] . " 00:00:00'
				  AND sol.fchCreacion <= '" . $arrDatos[ 1 ] . " 23:59:59'
			";
		    $objRes = $aptBd->execute( $sql );
		    $arrPost['seqSolicitudEditar'] = 0;
		    if( $objRes->fields ){
		    	$arrPost['seqSolicitudEditar'] = $objRes->fields['seqSolicitud'];
		    }

			$claDesembolso = new Desembolso();
			$arrErrores = $claDesembolso->salvarSolicitud( $arrPost, $arrDatos['seqFormularioActo'] );
			
    	}
		
    } 
    
    if( empty( $arrErrores ) ){
    	$arrMensajes[] = "Ha salvado " . count( $arrArchivo ) . " solicitudes de desembolso";
    }
    
    imprimirMensajes( $arrErrores, $arrMensajes );

	/**
     * VALIDACIONES DEL ARCHIVO.... DESCRIPCION DE LAS POSICIONES
     ******************************************************************* 
      	0	Nùmero de documento del Postulante Principal
		1	Fecha de la solicitud
		2	Número del Proyecto de Inversion
		3	Número Registro Presupuesta 1
		4	Fecha Registro Presupuesta 1
		5	Número Registro Presupuesta 2 (opcional)
		6	Fecha Registro Presupuesta 2 (opcional)
		7	Nombre del Beneficiario del giro
		8	Documento del Beneficiario del giro
		9	Dirección del Beneficiario del giro
		10	Teléfono del Beneficiario del giro
		11	Número de Cuenta del Beneficiario del giro
		12	Tipo de Cuenta del Beneficiario del giro
		13	Banco de la Cuenta del Beneficiario del giro
		14	Valor de la solicitud (sin comas ni simbolos de moneda ni puntos "$")
		15	Nombre Firma Subsecretaría
		16	Subsecretaría Encargado (Si o No)
		17	Nombre Firma Subdireccion Recursos Publicos
		18	Subdireccion Encargado (Si o No)
		19	Nombre Elaboró
		20	Numero de Radicacion
		21	Fecha de Radicacion
		22	Numero de Orden de Pago
		23	Fecha de Orden de Pago
		24	Valor Pagado
     ******************************************************************* 
     */    
    
    
    
?>