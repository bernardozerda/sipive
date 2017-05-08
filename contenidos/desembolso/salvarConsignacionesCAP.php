<?php

	/**
	 * MENU PARA REALIZAR LA GESTION 
	 * DE LOS DATOS QUE VIENEN DEL 
	 * BANCO. SON LAS CONSIGNACIONES
	 * DE LOS BENEFICIARIOS DE SCA
	 * EN LA CUENTA DE AHORRO PROGRAMADO
	 * @author Bernardo Zerda
	 * @version 1.0 Enero 2011
	 */

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Desembolso.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );

    // Para los meses locales
    setlocale(LC_TIME, 'spanish');
    
    $arrErrores = array();
    $arrMensajes = array();
	
    $numValorSubsidioMensual = ( $arrConfiguracion['constantes']['salarioMinimo'] * 0.3 );
    $numDesviacionValores = 0; // Para calcular el valor de las consignaciones (- 4%) del valor a consignar actual
    
	/**
	 * VALIDACIONES
	 */
	
	if( trim( $_POST['fchMes'] ) == "" ){
    	$arrErrores[] = "Seleccione el periodo al que corresponde el archivo";
    }
	
    // si hay archivo valida
    if( $_FILES['archivo']['error'] != UPLOAD_ERR_NO_FILE ){    
		switch( $_FILES['archivo']['error'] ){
			case UPLOAD_ERR_INI_SIZE:
			  $arrErrores[] = "El archivo \"" . $_FILES['vivienda']['name'] . "\" Excede el tamaño permitido";
			break;  
			case UPLOAD_ERR_FORM_SIZE:
			  $arrErrores[] = "El archivo \"" . $_FILES['vivienda']['name'] . "\" Excede el tamaño permitido";
			break; 
			case UPLOAD_ERR_PARTIAL:
			  $arrErrores[] = "El archivo \"" . $_FILES['vivienda']['name'] . "\" no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
			break; 
//			case UPLOAD_ERR_NO_FILE:
//			  $arrErrores[] = "Debe especificar un archivo para cargar";
//			break; 
		} 
    
	    if( empty( $arrErrores ) ){
	    	
	    	$aptArchivo = @fopen( $_FILES['archivo']['tmp_name'] , "r" );
	    	if( $aptArchivo ){
	    		$txtLinea = fgets( $aptArchivo );
	    		$i = 2;
	    		while( $txtLinea = fgets( $aptArchivo ) ){
	    			$arrLinea = split( "\t" , $txtLinea );
	    			
	    			/**
	    			 * VALIDACIONES DEL DOCUMENTO
	    			 */
	    			
	    			if( is_numeric( $arrLinea[0] ) ){
	    				$seqFormulario = Ciudadano::formularioVinculado( $arrLinea[0] , false, true );
	    				if( $seqFormulario != 0 ){
	    					$arrDocumentos[ $i ] = $arrLinea[0];
	    					$arrFormularios[ $i ] = $seqFormulario;
	    				} else {
	    					$arrErrores[] = "Error en la linea $i: El documento " . $arrLinea[0] . " no esta vinculado a ningun formulario";
	    				}
	    			}else{
	    				$arrErrores[] = "Error en la linea $i: El valor de la columna Documento no es válido";
	    			}
	    			
	    			/**
	    			 * VALIDACIONES DE LA FECHA
	    			 */
	    			
	    			list( $ano , $mes , $dia ) = split( "-" , $arrLinea[1] );
	    			if( checkdate($mes, $dia, $ano) ){
	    				$mesPeriodo = intval( date( "m" , strtotime( $_POST['fchMes'] ) ) ); 
	    				$mesArchivo = intval( date( "m" , strtotime( $arrLinea[1] ) ) );
	    				if( $mesPeriodo != $mesArchivo ){
	    					$arrErrores[] = "Error en la linea $i: La fecha de consignación " . $arrLinea[1] . " no corresponde al periodo que se esta registrando";
	    				}
	    			} else {
	    				$arrErrores[] = "Error en la linea $i: El valor de fecha no tiene el formato requerido, el formato debe ser AAAA-MM-DD";
	    			}
	    			
	    			/**
	    			 * VALIDACIONES DEL VALOR
	    			 */
	    			
	    			if( is_numeric( $arrLinea[2] ) ){
	    				$numMinimo = intval( ( $numValorSubsidioMensual ) * ( 1 - $numDesviacionValores ) );
	    				if( $numMinimo > $arrLinea[2] ){
	    					$arrErrores[] = "Error en la linea $i: El valor de la consigancion esta por debajo del 30% del SMMLV";
	    				}
	    			} else {
	    				$arrErrores[] = "Error en la linea $i: El valor consignado debe ser un valor numérico";
	    			}
	    			
	    			/**
	    			 * VALIDACIONES DE LA CUENTA
	    			 */
	    			
	    			if( trim( $arrLinea[3] ) == "" ){
	    				$arrErrores[] = "Error en la linea $i: El número de cuenta debe estar diligenciado";
	    			}
	    			
	    			if( empty( $arrErrores ) ){
	    				$arrArchivo[ $arrFormularios[ $i ] ]['documento'] = $arrLinea[0]; 
	    				$arrArchivo[ $arrFormularios[ $i ] ]['fecha']     = $arrLinea[1];
	    				$arrArchivo[ $arrFormularios[ $i ] ]['valor']     = $arrLinea[2];
	    				$arrArchivo[ $arrFormularios[ $i ] ]['cuenta']    = $arrLinea[3];
	    			} 
	    			
	    			$i++;
	    		}
	    		
	    		// validacion de la modalidad de los documentos
	    		if( empty( $arrErrores ) ){
	    			try {
	    				$sql = " 
	    					SELECT ciu.numDocumento
							FROM T_FRM_FORMULARIO frm
							INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
							INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
							WHERE seqModalidad <> 5
							AND ciu.numDocumento IN ( " . implode( "," , $arrDocumentos ) . " )
						";
	    				$objRes = $aptBd->execute( $sql );
	    				while( $objRes->fields ){    					
	    					$numLinea = array_search ( $objRes->fields['numDocumento'] , $arrDocumentos );
	    					$arrErrores[] = "Error en la linea $numLinea: El documento " . $objRes->fields['numDocumento'] . " no esta vinculado a la modalidad de SCA";    					
	    					$objRes->MoveNext();
	    				}	
	    			} catch ( Exception $objError ){
	    				$arrErrores[] = "No se han podido verificar las modalidades de los documentos en el archivo";
	    			}
	    		}
	    		
	    	} else {
	    		$arrErrores[] = "No se pudo barir el archivo " . $_FILES['archivo']['name'];
	    	}	
	    }
    
	    /**
	     * PROCESAMIENTO DE LOS DATOS
	     */
    
	    if( empty( $arrErrores ) ){
	    	
	    	// Borra las consignaciones hechas en ese mes
	    	try {
	    		$sql = "
	    			DELETE 
	    			FROM T_DES_CONSIGNACIONES
	    			WHERE fchConsignacion >= '" . $_POST['fchMes'] . " 00:00:00'
	    			  AND fchConsignacion <= '" . date( "Y-m-t" , strtotime( $_POST['fchMes'] ) ) . " 23:59:59' 
	    		";
	    		$aptBd->execute( $sql );
	    	} catch (Exception $objError) {
	    		$arrErrores[] = "No se han podido borrar las consignaciones del mes";
	    	}
	    	
	    	// construye la sentencia que guarda la informacion de los hogares
			$sql = " 
				INSERT INTO T_DES_CONSIGNACIONES (
					seqFormulario, 
					txtNombreConsignacion, 
					fchConsignacion, 
					valConsignacion, 
					numCuenta, 
					seqBancoConsignacion
				) VALUES
			";
					
			foreach( $arrArchivo as $seqFormulario => $arrDatos ){
					
				$sql .= "(
					" . $seqFormulario . ", 
					\"" . $arrDatos['documento'] . "\", 
					\"" . $arrDatos['fecha'] . "\", 
					" . $arrDatos['valor'] . ", 
					\"" . $arrDatos['cuenta'] . "\", 
					8
				),";
			}
			$sql = trim( $sql , "," );
			
			try {	
				$aptBd->execute( $sql );
			} catch ( Exception $objError ){
				$arrErrores[] = "No se pudo realizar la consignacion para el hogar con el documento " . $arrDatos['documento'];
			}
	    
	    }
    
	    if( empty( $arrErrores ) ){
	    	$arrMensajes[] = "Se han procesado " . count( $arrArchivo ) . 
	    					 " registros de consignaciones para el mes de " . ucwords( strftime(" %B de %Y" , strtotime($_POST['fchMes'] ) ) ); 
	    }
	    
    } else {
    	$arrMensajes[] = "Consulta de consignaciones para el periodo " . ucwords( strftime(" %B de %Y" , strtotime($_POST['fchMes'] ) ) );
    }
    
	imprimirMensajes( $arrErrores, $arrMensajes );
	
	$claSmarty->assign( "fchMes" , $_POST['fchMes'] );
	$claSmarty->display( "desembolso/salvarConsignacionesCAP.tpl" );
	
?>














