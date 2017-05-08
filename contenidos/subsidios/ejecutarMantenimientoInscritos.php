<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
	
    $arrMensajes = array();
    
    // Todas las modalidades
    $sql = "
    	SELECT seqModalidad, txtModalidad
    	FROM T_FRM_MODALIDAD
    	ORDER BY txtModalidad
    ";
    $objRes = $aptBd->execute( $sql );
    while( $objRes->fields ){
    	$arrModalidad[ $objRes->fields['seqModalidad'] ]['nombre'] = $objRes->fields['txtModalidad'];
    	$objRes->MoveNext();
    }
    
    // Soluciones 
    $sql = " 
    	SELECT seqModalidad, seqSolucion, txtSolucion
    	FROM T_FRM_SOLUCION
    	ORDER BY seqSolucion
    ";
    $objRes = $aptBd->execute( $sql );
    while( $objRes->fields ){
    	$arrModalidad[ $objRes->fields['seqModalidad'] ]['soluciones'][ $objRes->fields['seqSolucion'] ]['nombre'] = $objRes->fields['txtSolucion'];
    	$objRes->MoveNext();
    }
    
    // Valores del subsidio
    $sql = " 
    	SELECT seqModalidad, seqSolucion, valSubsidio
    	FROM T_FRM_VALOR_SUBSIDIO
    ";
	$objRes = $aptBd->execute( $sql );
    while( $objRes->fields ){
    	$arrModalidad[ $objRes->fields['seqModalidad'] ]['soluciones'][ $objRes->fields['seqSolucion'] ]['valor'] = $objRes->fields['valSubsidio'];
    	$objRes->MoveNext();
    }   
    
    // Vaor del cierre financiero
    $claReportes = new Reportes();
    foreach( $arrModalidad as $seqModalidad => $arrSoluciones ){
    	foreach( $arrSoluciones['soluciones'] as $seqSolucion => $arrValores ){
    		$arrModalidad[ $seqModalidad ]['soluciones'][ $seqSolucion ]['cierre'] = $claReportes->valorCierreFinanciero( $seqModalidad , $seqSolucion );
    	}
    }
    
    $arrErrores = array();
    if( empty( $_POST ) ){
    	$arrErrores[] = "Seleccione por lo menos una modalidad";
    }
    
    if( empty( $arrErrores ) ){
    	
    	try {
    	
	    	$sql = "
					SELECT
						frm.seqFormulario,
						frm.seqModalidad,
						moa.txtModalidad,
						frm.seqSolucion,
						sol.txtSolucion,
						ciu.numDocumento,
						UPPER( CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 ) )  as nombre,
						frm.valTotalRecursos,
						frm.fchUltimaActualizacion,
						frm.seqEstadoProceso
					FROM T_FRM_FORMULARIO frm
					INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
					INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
					INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
					INNER JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
					WHERE frm.seqEstadoProceso = 1
					AND hog.seqParentesco = 1
					AND frm.seqModalidad in ( " . implode(",", array_keys( $_POST )) . " )   
	    	";
			$arrHogares = array();
	    	$objRes = $aptBd->execute( $sql );
	    	while( $objRes->fields ){
	    		$seqFormulario = $objRes->fields['seqFormulario'];
	    		unset( $objRes->fields['seqFormulario'] ); 
	    		$arrHogares[ $seqFormulario ] = $objRes->fields;
	    		$objRes->MoveNext();
	    	}
	    	
	    	$fchHoy = date( "Y-m-d H:m:s" );
	    	
	    	
	    	
	    	foreach( $arrHogares as $seqFormulario => $arrDatos ){
	    		if( isset( $arrModalidad[ $arrDatos['seqModalidad'] ] ) ){
	    			if( isset( $arrModalidad[ $arrDatos['seqModalidad'] ]['soluciones'][ $arrDatos['seqSolucion'] ] ) ){
	    				$valCierre = $arrModalidad[ $arrDatos['seqModalidad'] ]['soluciones'][ $arrDatos['seqSolucion'] ]['cierre'];
	    				$arrHogares[ $seqFormulario ]['cierre'] = $valCierre;
	    				
						$txtCambio  = "Cambios en el formulario $seqFormulario\r\n";
	    				if( $arrDatos['valTotalRecursos'] >= $valCierre ){
			    			// 10	Inscripcion - Call Center (Opción Cierre)
			    			$arrSql10[] = $seqFormulario;
			    			$txtCambio .= "seqEstadoProceso, Valor Anterior: " . $arrDatos['seqEstadoProceso'] .", Valor Nuevo: 10\n";
			    		}elseif( $arrDatos['valTotalRecursos'] > 0 and  $arrDatos['valTotalRecursos'] < $valCierre ){
			    			// 11	Inscripcion - Call Center (Sin Cierre)
			    			$arrSql11[] = $seqFormulario;
			    			$txtCambio .= "seqEstadoProceso, Valor Anterior: " . $arrDatos['seqEstadoProceso'] .", Valor Nuevo: 11\n";
			    		}else{
			    			// 12	Inscripcion - Call Center (Recursos Cero)
			    			$arrSql12[] = $seqFormulario;
			    			$txtCambio .= "seqEstadoProceso, Valor Anterior: " . $arrDatos['seqEstadoProceso'] .", Valor Nuevo: 12\n";
			    		}
			    		$txtCambio .= "fchUltimaActualizacion, ValorAnterior: " . $arrDatos['fchUltimaActualizacion'] . ", Valor Nuevo: $fchHoy\n";
			    		
			    		$arrSeguimiento[] = "(
							$seqFormulario, 
							'$fchHoy', 
							" . $_SESSION['seqUsuario'] . ", 
							'Cambio de estado desde el modulo de mantenimiento de inscritos', 
							'$txtCambio', 
							" . $arrDatos['numDocumento'] . ",  
							'" . $arrDatos['nombre'] . "', 
							46, 
							1
			    		),";
			    		
	    			} else {
	    				$arrErrores[] = "No se pudo determinar el cambio de estado porque no se conoce la solucion " . $arrDatos['seqSolucion'] . " de la modalidad " . $arrDatos['seqModalidad'] . " para el documento " . $arrDatos['numDocumento'];
	    			}
	    		}else{
	    			$arrErrores[] = "No se pudo determinar el cambio de estado porque no se conoce la modalidad " . $arrDatos['txtModalidad'] . " para el documento " . $arrDatos['numDocumento'];
	    		}	
	    	}
	    	
	    	if( empty( $arrErrores ) ){
	    		
	    		// actualizacion de estados
	    		try {
	    			
	    			if( ! empty( $arrSql10 ) ){
		    			$sql = "
		    				UPDATE T_FRM_FORMULARIO SET 
		    					seqEstadoProceso = 10,
		    					fchUltimaActualizacion = '$fchHoy'
		    				WHERE seqFormulario IN ( " . implode( "," , $arrSql10 ) . " )  
		    			";
		    			$aptBd->execute( $sql );
						unset( $sql );
						unset( $arrSql10 );
	    			}
	    			
	    			if( ! empty( $arrSql11 ) ){
		    			$sql = "
		    				UPDATE T_FRM_FORMULARIO SET 
		    					seqEstadoProceso = 11,
		    					fchUltimaActualizacion = '$fchHoy'
		    				WHERE seqFormulario IN ( " . implode( "," , $arrSql11 ) . " )  
		    			";
	    				$aptBd->execute( $sql );
						unset( $sql );
						unset( $arrSql11 );
	    			}
		    		
	    			if( ! empty( $arrSql12 ) ){
		    			$sql = "
		    				UPDATE T_FRM_FORMULARIO SET 
		    					seqEstadoProceso = 12,
		    					fchUltimaActualizacion = '$fchHoy'
		    				WHERE seqFormulario IN ( " . implode( "," , $arrSql12 ) . " )  
		    			";
		    			$aptBd->execute( $sql );
						unset( $sql );
						unset( $arrSql12 );
	    			}
	    			
//	    			$sqlSeguimiento = "
//						INSERT INTO T_SEG_SEGUIMIENTO (
//							seqFormulario, 
//							fchMovimiento, 
//							seqUsuario, 
//							txtComentario, 
//							txtCambios, 
//							numDocumento, 
//							txtNombre, 
//							seqGestion, 
//							bolMostrar
//						) VALUES     	
//					";
//	    			foreach( $arrSeguimiento as $numPosicion => $txtSeguimiento ){
//	    				$sqlSeguimiento .= $txtSeguimiento;
//	    			}
//	    			$sqlSeguimiento = trim( $sqlSeguimiento , "," );
//	    			$aptBd->execute( $sqlSeguimiento );	
	    			
	    		} catch ( Exception $objError ){
	    			$arrErrores[] = "No se ha podido actualizar el estado de los hogares";
	    		}
	    		
	    		$claSmarty->assign("fchHoy" , $fchHoy );
	    		$claSmarty->display("subsidios/tablaMantenimientoInscritos.tpl");
	    	}
	    	
	    	
    	} catch ( Exception $objError ){
    		$arrErrores[] = "No se han podido consultar los hogares de las modalidades seleccionadas";
    	}
    	
    }
    
    imprimirMensajes( $arrErrores, $arrMensajes );
    
?>