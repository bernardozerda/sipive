<?php

	$txtPrefijoRuta = "../../../";
	
//	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

    $arrArchivo = file( $_FILES['archivo']['tmp_name'] , FILE_SKIP_EMPTY_LINES );
    
    unset( $arrArchivo[ 0 ] ); 
    
    /**
     * VALIDACIONES
     */
    
    foreach( $arrArchivo as $numLinea => $txtLinea ){
    	
		$arrLinea = split( "\t" , $txtLinea );
		
//  txtNombre1,	'" . $arrLinea[ 2 ] . "',	Texto

    	if( trim( $arrLinea[ 2 ] ) == "" ){
    		$arrErrores[] = "Error linea $numLinea: Digite el primer nombre del contacto";
    	} 
    	
//  txtApellido1,	  '" . $arrLinea[ 4 ] . "',	Texto

    	if( trim( $arrLinea[ 4 ] ) == "" ){
    		$arrErrores[] = "Error linea $numLinea: Digite el primer apellido del contacto";
    	}
    	
//  seqTipoDocumento,	  '" . $arrLinea[ 0 ] . "',	Numero

    	if( intval( $arrLinea[ 0 ] ) == 0 ){
    		$arrErrores[] = "Error linea $numLinea: El tipo de documento no es válido";
    	}
    	
//  numDocumento,	  '" . $arrLinea[ 1 ] . "',	Numero

    	if( ! is_numeric( $arrLinea[ 1 ] ) ){
    		$arrErrores[] = "Error linea $numLinea: El documento no es válido";
    	}
    	
//  numTelefono1,	  '" . $arrLinea[ 6 ] . "',	Numero

    	if( ! is_numeric( $arrLinea[ 6 ] ) ){
    		$arrErrores[] = "Error linea $numLinea: El telefono no es válido";
    	}
    	
//  seqTipoInmueble,	  '" . $arrLinea[ 21 ] . "',	Numero

    	if( ! is_numeric( $arrLinea[ 21 ] ) ){
    		$arrErrores[] = "Error linea $numLinea: El tipo de inmueble no es válido";
    	}
    	
//  seqLocalidad,	  '" . $arrLinea[ 20 ] . "',	Numero

    	if( ! is_numeric( $arrLinea[ 20 ] ) ){
    		$arrErrores[] = "Error linea $numLinea: La localidad no es válida";
    	}
    	
//  txtDireccionInmueble,	  '" . $arrLinea[ 28 ] . "',	Texto

    	if( trim( $arrLinea[ 28 ] ) == "" ){
    		$arrErrores[] = "Error linea $numLinea: Dirección del inmueble";
    	}
    	
//  numHabitaciones,	  '" . $arrLinea[ 17 ] . "',	Numero

    	if( ! is_numeric( $arrLinea[ 17 ] ) ){
    		$arrErrores[] = "Error linea $numLinea: El numero de habitaciones no es válido";
    	}
    	
//  numBanos,	  '" . $arrLinea[ 14 ] . "',	Numero

    	if( ! is_numeric( $arrLinea[ 14 ] ) ){
    		$arrErrores[] = "Error linea $numLinea: El numero de baños no es válido";
    	}
    	
//  numAreaConstruida,	  '" . $arrLinea[ 13 ] . "',	Numero
		$arrLinea[ 13 ] = ereg_replace( "," , "." , $arrLinea[ 13 ] );
    	if( ! is_numeric( $arrLinea[ 13 ] ) ){
    		$arrErrores[] = "Error linea $numLinea: El área construida no es válida";
    	}
    	
//  valOferta,	  '" . $arrLinea[ 43 ] . "',	Numero

    	if( ! is_numeric( $arrLinea[ 43 ] ) ){
	   		$arrErrores[] = "Error linea $numLinea: El valor de la oferta no es valido";
    	}else{
    		if( $arrLinea[ 43 ] < 10000000 ){
    			$arrErrores[] = "Error linea $numLinea: El valor de la oferta no es valido, debe ser mayor a 10 millones";
    		}
    	}
    	
//  txtEspacioMultiple,	  '" . $arrLinea[ 30 ] . "',	Texto

    	if( trim( strtolower( $arrLinea[ 30 ] ) ) == "" ){
    		$arrErrores[] = "Error linea $numLinea: El valor de espacio múltiple no puede ser vacio";
    	} else {
    		if( trim( strtolower( $arrLinea[ 30 ] ) ) != "si" and trim( strtolower( $arrLinea[ 30 ] ) ) != "no" ){
    			$arrErrores[] = "Error linea $numLinea: El valor de espacio múltiple debe ser si o no";	
    		}
    	}
    	
//  txtCocina,	  '" . $arrLinea[ 26 ] . "',	Texto

    	if( trim( strtolower( $arrLinea[ 26 ] ) ) == "" ){
    		$arrErrores[] = "Error linea $numLinea: El valor de cocina no puede ser vacio";
    	} else {
    		if( trim( strtolower( $arrLinea[ 26 ] ) ) != "si" and trim( strtolower( $arrLinea[ 26 ] ) ) != "no" ){
    			$arrErrores[] = "Error linea $numLinea: El valor de cocina debe ser si o no";	
    		}
    	}
    	
//  txtLavanderia,	  '" . $arrLinea[ 35 ] . "',	Texto

    	if( trim( strtolower( $arrLinea[ 35 ] ) ) == "" ){
    		$arrErrores[] = "Error linea $numLinea: El valor de lavandería no puede ser vacio";
    	} else {
    		if( trim( strtolower( $arrLinea[ 35 ] ) ) != "si" and trim( strtolower( $arrLinea[ 35 ] ) ) != "no" ){
    			$arrErrores[] = "Error linea $numLinea: El valor de lavandería debe ser si o no";	
    		}
    	}
    	
//  txtAgua,	  '" . $arrLinea[ 22 ] . "',	Texto

    	if( trim( strtolower( $arrLinea[ 22 ] ) ) == "" ){
    		$arrErrores[] = "Error linea $numLinea: El valor de servicio de agua no puede ser vacio";
    	} else {
    		if( trim( strtolower( $arrLinea[ 22 ] ) ) != "no existe" and trim( strtolower( $arrLinea[ 22 ] ) ) != "definitivo" and trim( strtolower( $arrLinea[ 22 ] ) ) != "provisional" ){
    			$arrErrores[] = "Error linea $numLinea: El valor de servicio de agua debe ser 'no existe', 'definitivo' o 'provisional' ";	
    		}
    	}
    	
//  txtEnergia,	  '" . $arrLinea[ 29 ] . "',	Texto
    	
    	if( trim( strtolower( $arrLinea[ 29 ] ) ) == "" ){
    		$arrErrores[] = "Error linea $numLinea: El valor de servicio de energía no puede ser vacio";
    	} else {
    		if( trim( strtolower( $arrLinea[ 29 ] ) ) != "no existe" and trim( strtolower( $arrLinea[ 29 ] ) ) != "definitivo" and trim( strtolower( $arrLinea[ 29 ] ) ) != "provisional" ){
    			$arrErrores[] = "Error linea $numLinea: El valor de servicio de energía debe ser 'no existe', 'definitivo' o 'provisional' ";	
    		}
    	}
    	
// fecha de creacion
    	list( $ano , $mes , $dia ) = split( "-" , $arrLinea[ 11 ] );
		if( @checkdate($mes, $dia, $ano) === false ){
			$arrErrores[] = "Error linea $numLinea: La fecha de creación no tiene el formato correcto (aaaa-mm-dd)";
		}
    	
// fecha de actualizacion
    	list( $ano , $mes , $dia ) = split( "-" , $arrLinea[ 12 ] );
		if( @checkdate($mes, $dia, $ano) === false ){
			$arrErrores[] = "Error linea $numLinea: La fecha de actualización no tiene el formato correcto (aaaa-mm-dd)";
		}
		
    }
    
    
	if( empty( $arrErrores ) ){
	
		foreach( $arrArchivo as $numLinea => $txtLinea ){
			
			$arrLinea = split( "\t" , $txtLinea );
			foreach( $arrLinea as $numPosicion => $txtTexto ){
				$arrLinea[ $numPosicion ] = ereg_replace( "\"" , "" , trim( $txtTexto ) );
			}
			
			/**
			 * VALIDACION DE LA DIRECCION
			 */
			$sql = "
				SELECT seqInmueble
				FROM T_BVU_INMUEBLE
				WHERE txtDireccionInmueble = \"" . $arrLinea[ 28 ] . "\"
			";
			$objRes = $aptBd->execute( $sql );
			if( ! $objRes->fields ){
			
				/**
				 * DATOS DEL CONTACTO
				 */
				
				$sql = "
					SELECT seqContacto
					FROM T_BVU_CONTACTO
					WHERE seqTipoDocumento = '" . $arrLinea[ 0 ] . "'
					AND numDocumento = '" . $arrLinea[ 1 ] . "'
				";
				$objRes = $aptBd->execute( $sql );
				if( $objRes->fields ){
					$seqContacto = $objRes->fields['seqContacto'];
				} else {
					
					$sql = "
						INSERT INTO T_BVU_CONTACTO (
						  txtNombre1,
						  txtNombre2,
						  txtApellido1,
						  txtApellido2,
						  seqTipoDocumento,
						  numDocumento,
						  numTelefono1,
						  numTelefono2,
						  numCelular,
						  txtCorreo
						) VALUES (
						  '" . $arrLinea[ 2 ] . "',
						  '" . $arrLinea[ 3 ] . "',
						  '" . $arrLinea[ 4 ] . "',
						  '" . $arrLinea[ 5 ] . "',
						  '" . $arrLinea[ 0 ] . "',
						  '" . $arrLinea[ 1 ] . "',
						  '" . $arrLinea[ 6 ] . "',
						  '" . $arrLinea[ 7 ] . "',
						  '" . $arrLinea[ 8 ] . "',
						  '" . $arrLinea[ 9 ] . "'
						)		 
					";
					
					try {
						$aptBd->execute( $sql );
						$seqContacto = $aptBd->Insert_ID();
						$arrContactos[ $arrLinea[ 0 ] . $arrLinea[ 1 ] ] = $seqContacto;
					} catch ( Exception $objError ){
						$arrErrores[] = "Error al salvar el contacto " . $arrLinea[ 0 ] . $arrLinea[ 1 ] . "<hr>" . $objError->getMessage();
						$seqContacto = 0;
					}
					
				}
		
				/**
				 * DATOS DEL INMUEBLE
				 */
		
				if( empty( $arrErrores ) ){
					
					$sql = "
						INSERT INTO T_BVU_INMUEBLE (
						  seqContacto,
						  seqEstadoProceso,
						  seqTipoInmueble,
						  seqLocalidad,
						  txtDireccionInmueble,
						  txtBarrio,
						  txtMatriculaInmobiliaria,
						  txtChip,
						  numPisos,
						  numPiso,
						  numHabitaciones,
						  numBanos,
						  numAreaConstruida,
						  numAreaLote,
						  numEstrato,
						  valOferta,
						  txtDescripcion,
						  txtEspacioMultiple,
						  txtCocina,
						  txtLavanderia,
						  txtAgua,
						  txtEnergia,
						  txtGas,
						  txtTelefono,
						  txtInstalacionCocina,
						  txtInstalacionCalentador,
						  numGarajes,
						  txtVista,
						  txtHabitacionServicio,
						  txtBanoServicio,
						  txtPisoCocina,
						  txtPisoHabitaciones,
						  txtPisoComedor,
						  txtPisoSala,
						  fchCreacion,
						  fchActualizacion
						) VALUES (
						  '$seqContacto',
						  '" . $arrLinea[ 10 ] . "',
						  '" . $arrLinea[ 21 ] . "',
						  '" . $arrLinea[ 20 ] . "',
						  '" . $arrLinea[ 28 ] . "',
						  '" . $arrLinea[ 24 ] . "',
						  '" . $arrLinea[ 36 ] . "',
						  '" . $arrLinea[ 25 ] . "',
						  '" . $arrLinea[ 19 ] . "',
						  '" . $arrLinea[ 18 ] . "',
						  '" . $arrLinea[ 17 ] . "',
						  '" . $arrLinea[ 14 ] . "',
						  '" . $arrLinea[ 13 ] . "',
						  '0',
						  '" . $arrLinea[ 15 ] . "',
						  '" . $arrLinea[ 43 ] . "',
						  '" . $arrLinea[ 27 ] . "',
						  '" . $arrLinea[ 30 ] . "',
						  '" . $arrLinea[ 26 ] . "',
						  '" . $arrLinea[ 35 ] . "',
						  '" . $arrLinea[ 22 ] . "',
						  '" . $arrLinea[ 29 ] . "',
						  '" . $arrLinea[ 31 ] . "',
						  '" . $arrLinea[ 41 ] . "',
						  '" . $arrLinea[ 34 ] . "',
						  '" . $arrLinea[ 33 ] . "',
						  '" . $arrLinea[ 16 ] . "',
						  '" . $arrLinea[ 42 ] . "',
						  '" . $arrLinea[ 32 ] . "',
						  '" . $arrLinea[ 23 ] . "',
						  '" . $arrLinea[ 37 ] . "',
						  '" . $arrLinea[ 39 ] . "',
						  '" . $arrLinea[ 38 ] . "',
						  '" . $arrLinea[ 40 ] . "',
						  '" . $arrLinea[ 11 ] . "',
						  '" . $arrLinea[ 12 ] . "'
						)			
					";	
					
					try {
						$aptBd->execute( $sql );
						$seqInmueble = $aptBd->Insert_ID();
						$arrInmuebles[ $seqInmueble ] = $arrLinea[ 28 ];
					} catch ( Exception $objError ){
						$arrErrores[] = "Error al salvar el inmueble " . $arrLinea[ 28 ] . "<hr>" . $objError->getMessage();
						$seqInmueble = 0;
					}
					
				}
				
				/**
				 * DATOS DE PREVIABILIZACION
				 */
				
				if( empty( $arrErrores ) ){
					
					$arrLinea[ 45 ] = date( "Y-m-d H:i:s" );
					$arrLinea[ 44 ] = date( "Y-m-d H:i:s" );
					
					$sql = "
						INSERT INTO T_BVU_PREVIABILIZADO (
						  seqInmueble,
						  txtBarrioLegalizado,
						  txtReservaVial,
						  txtZonaRiesgo,
						  txtZonaProteccionAmbiental,
						  txtRemocionMasa,
						  fchViabilizacion,
						  fchRevision
						) VALUES (
						  '$seqInmueble',
						  '" . $arrLinea[ 46 ] . "',
						  '" . $arrLinea[ 48 ] . "',
						  '" . $arrLinea[ 50 ] . "',
						  '" . $arrLinea[ 49 ] . "',
						  '" . $arrLinea[ 47 ] . "',
						  '" . $arrLinea[ 45 ] . "',
						  '" . $arrLinea[ 44 ] . "'
						)		
					";

					try {
						$aptBd->execute( $sql );
						$seqPreviabilizado = $aptBd->Insert_ID();
					} catch ( Exception $objError ){
						$arrErrores[] = "Error al previabilizar el inmueble " . $arrLinea[ 28 ] . "<hr>" . $objError->getMessage();
						$seqPreviabilizado = 0;
					}
								
				}
	
			}else{ 	
				$arrMensajes[] = "El inmueble con direccion " . $arrLinea[ 28 ] . " ya esta cargado";
			}
	
		}
		
	}
    
    if( is_array( $arrInmuebles ) and empty($arrErrores) ){
	   	echo "<table border=1>";
	   	echo "<tr><td>Inmueble</td><td>Direccion</td>";
	   	foreach( $arrInmuebles as $seqInmueble => $txtDireccion ){
	   		echo "<tr><td>$seqInmueble</td><td>$txtDireccion</td>";
	   	}
	   	echo "</table>";
    }
    
    imprimirMensajes($arrErrores, $arrMensajes );
    
?>

