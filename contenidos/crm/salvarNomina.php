<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );
	
	include( "./datosComunes.php" );
	
	$arrErrores 	= array( );
	$arrDatosNomina = array( );
	$arrMensajeOk 	= array( );
	
	
	// NOMINA RESTANTE
	if( isset( $_POST["bolRestante"] )){
		
		$claCrm = new CRM;
		$arrErrores = $claCrm->ejecutarNominaRestante( );
		
		if( empty( $arrErrores ) ){
			$arrMensajeOk = "La nómina se agregaro correctamente";
		}
		
	} // PARA AGREGAR NOMINA 
	else if( $_POST["bolAgregarNomina"] == 1 ){
		
		$bolExistefileNomina = true;
		// CONFIRMA SI SE SUBIO UN ARCHIVO
		switch( $_FILES['fileNomina']['error'] ){
			case UPLOAD_ERR_INI_SIZE:
			  $arrErrores[] = "El archivo Excede el tamaño permitido, contacte al administrador del sistema";
			break;  
			case UPLOAD_ERR_FORM_SIZE:
			    $arrErrores[] = "El archivo Excede el tamaño permitido, contacte al administrador del sistema";
			break; 
			case UPLOAD_ERR_PARTIAL:
			  $arrErrores[] = "El archivo no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
			break; 
			case UPLOAD_ERR_NO_FILE:
				$bolExistefileNomina = false;
			break; 
		}
		
		if( empty( $arrErrores ) ){
			// Se ingreso un archivo y se procede a Verificarlo
			if( $bolExistefileNomina === true ){
				
				$aptArchivo = fopen( $_FILES['fileNomina']['tmp_name'] , "r" );
				
				if( $aptArchivo ){
					
					$txtTitulos = fgets( $aptArchivo );
					$arrTitulos = split( "\t" , $txtTitulos );
					
					if( ! is_array( $arrTitulos ) ){
						$arrErrores[] = "Al parecer el archivo no esta separado por tabulaciones";
					}
					
					if( strtolower( trim( $arrTitulos[0] ) ) != "nombre" ){
						$arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Nombre\" ";
					}
					
					if( strtolower( trim( $arrTitulos[1] ) ) != "documento" ){
						$arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Documento\" ";
					}
					
					if( strtolower( trim( $arrTitulos[2] ) ) != "fecha inicio" ){
						$arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Fecha Inicio\" ";
					}
					
					if( strtolower( trim( $arrTitulos[3] ) ) != "fecha final" ){
						$arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Fecha Final\" ";
					}
					
					if( strtolower( trim( $arrTitulos[4] ) ) != "valor contrato" ){
						$arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Valor Contrato\" ";
					}
					
					if( strtolower( trim( $arrTitulos[5] ) ) != "valor mensual" ){
						$arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Valor Mensual\" ";
					}
					
				}
				
				$numLinea = 1;
				$arrArchivo = array(); 
				if( empty( $arrErrores ) ){
					while( $txtLinea = fgets( $aptArchivo ) ){
						if( trim( $txtLinea ) != "" ){
							$arrTemporal 	= &$arrDatosNomina[];
							$arrLinea 		= split( "\t" , $txtLinea );
							$txtNombre 		= trim( $arrLinea[ 0 ] );
							$numDocumento 	= trim( $arrLinea[ 1 ] );
							$fchInicio 		= trim( $arrLinea[ 2 ] );
							$fchFinal 		= trim( $arrLinea[ 3 ] );
							$valContrato 	= trim( $arrLinea[ 4 ] );
							$valMensual 	= trim( $arrLinea[ 5 ] );
							$txtError 		= "Error en la linea $numLinea: ";
							
							if( !esSoloLetras( $txtNombre ) ){
								$arrErrores[] = $txtError ."El Nombre del Contratista no es válido";
							}
							
							if( !esNumero( $numDocumento ) ){
								$arrErrores[] = $txtError ."El Número de Documento no es válido";
							}
							
							if( !esFechaValida( $fchInicio ) ){
								$arrErrores[] = $txtError ."La Fecha Inicial del Contrato es incorrecta";
							}
							
							if( !esFechaValida( $fchFinal ) ){
								$arrErrores[] = $txtError ."La Fecha Final del Contrato es incorrecta";
							}
							
							if( !esNumero( $valContrato ) ){
								$arrErrores[] = $txtError ."El valor de Contrato no es numérico";
							}
							
							if( !esNumero( $valMensual ) ){
								$arrErrores[] = $txtError ."El valor Mensual del Contrato no es numérico";
							}
							
							if( $valContrato == "0" ){
								$arrErrores[] = $txtError ."El valor de Contrato no puede ser 0";
							}
							
							if( $valMensual == "0" ){
								$arrErrores[] = $txtError ."El valor Mensual del Contrato no puede ser 0";
							}
							
							$arrTemporal["txtNombreContratista"] 	= $txtNombre;
							$arrTemporal["numDocumento"] 			= $numDocumento;
							$arrTemporal["fchInicioContrato"] 		= $fchInicio;
							$arrTemporal["fchFinalContrato"] 		= $fchFinal;
							$arrTemporal["valTotalContrato"] 		= $valContrato;
							$arrTemporal["valMesContrato"] 			= $valMensual;
							
							$numLinea++;
						}
					}
				}
				
			}else{ // SE AGREGA SOLO 1 REGISTRO
				 
				 if( $_POST["txtNombreContratista"] == "" ){
				 	$arrErrores[] = "Ingrese el Nombre del Contratista";
				 }
				 
				 if( $_POST["numDocumento"] == "" ){
				 	$arrErrores[] = "Ingrese el Numero de Documento del Contratista";
				 }
				 
				 if( $_POST["fchInicioContrato"] == "" ){
				 	$arrErrores[] = "Ingrese la Fecha Inicial del Contrato";
				 }
				 
				 if( $_POST["fchFinalContrato"] == "" ){
				 	$arrErrores[] = "Ingrese la Fecha Final del Contrato";
				 }
				 
				 if( $_POST["valTotalContrato"] == "" || $_POST["valTotalContrato"] == "0" ){
				 	$arrErrores[] = "Ingrese el Valor Total del Contrato";
				 }
				 
				 if( $_POST["valMesContrato"] == "" ||  $_POST["valMesContrato"] == "0" ){
				 	$arrErrores[] = "Ingrese el Valor Mensual del Contrato";
				 }
				 
				 $arrDatosNomina[] = $_POST;
			}
			
		}
		
		if( !empty( $arrErrores ) ){
			imprimirMensajes( $arrErrores );
		}else{
			$claCrm = new CRM;
			$arrErrores = $claCrm->salvarNomina( $arrDatosNomina );
			
			if( empty( $arrErrores ) ){
				$arrMensajeOk = "Los datos se agregaron correctamente";
			}
		}
		
	}else if( $_POST["bolAgregarNomina"] == 0 ){ // EJECUTAR NOMINA
		
		$claCrm = new CRM;
		$arrErrores = $claCrm->ejecutarNomina( );
		
		if( empty( $arrErrores ) ){
			$arrMensajeOk = "La nómina se ejecuto correctamente.";
		}
		
	}
	
	if( !empty( $arrErrores ) ){
			imprimirMensajes( $arrErrores );
	}else{
		imprimirMensajes( "" , $arrMensajeOk );
	}

?>
