<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );
	
	$arrErrores 		= array( );
	$arrDatosConcepto 	= array( );
	$arrMensajeOk 		= array( );
	
	$bolExistefileConceptos = true;
	// CONFIRMA SI SE SUBIO UN ARCHIVO
	switch( $_FILES['fileConceptos']['error'] ){
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
			$bolExistefileConceptos = false;
		break; 
	}
	
	if( empty( $arrErrores ) ){
		// Se ingreso un archivo y se procede a Verificarlo
		if( $bolExistefileConceptos === true ){
			
			$aptArchivo = fopen( $_FILES['fileConceptos']['tmp_name'] , "r" );
			
			if( $aptArchivo ){
				
				$txtTitulos = fgets( $aptArchivo );
				$arrTitulos = split( "\t" , $txtTitulos );
				
				if( ! is_array( $arrTitulos ) ){
					$arrErrores[] = "Al parecer el archivo no esta separado por tabulaciones";
				}
				
				if( strtolower( trim( $arrTitulos[ 0 ] ) ) != "concepto" ){
					$arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Concepto\" ";
				}
				
				if( strtolower( trim( $arrTitulos[ 1 ] ) ) != "proyecto" ){
					$arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Proyecto\" ";
				}
				
				if( strtolower( trim( $arrTitulos[ 2 ] ) ) != "valor" ){
					$arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Valor\" ";
				}
				
				if( strtolower( trim( $arrTitulos[ 3 ] ) ) != "fecha" ){
					$arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Fecha\" ";
				}
				
				
			}
			
			$numLinea = 1;
			$arrArchivo = array(); 
			if( empty( $arrErrores ) ){
				while( $txtLinea = fgets( $aptArchivo ) ){
					if( trim( $txtLinea ) != "" ){
						$arrTemporal 	= &$arrDatosConcepto[];
						$arrLinea 		= split( "\t" , $txtLinea );
						$txtConcepto 	= trim( $arrLinea[ 0 ] );
						$numProyecto 	= trim( $arrLinea[ 1 ] );
						$valConcepto 	= trim( $arrLinea[ 2 ] );
						$fchConcepto 	= trim( $arrLinea[ 3 ] );
						$txtError 		= "Error en la linea $numLinea: ";
						
						if( !esSoloLetrasNumeros( $txtConcepto ) ){
							$arrErrores[] = $txtError ."El Nombre del Concepto no es válido";
						}
						
						if( !esNumero( $numProyecto ) ){
							$arrErrores[] = $txtError ."El Número del Proyecto no es válido";
						}
						
						if( !esNumero( $valConcepto ) ){
							$arrErrores[] = $txtError ."El Valor del Concepto no es válido";
						}
						
						if( !esFechaValida( $fchConcepto ) ){
							$arrErrores[] = $txtError ."La Fecha del Concepto es incorrecta";
						}
						
						
						$arrTemporal[ "txtConcepto" ] = $txtConcepto;
						$arrTemporal[ "numProyecto" ] = $numProyecto;
						$arrTemporal[ "valConcepto" ] = $valConcepto;
						$arrTemporal[ "fchConcepto" ] = $fchConcepto;
						
						$numLinea++;
					}
				}
			}
			
		}else{ // SE AGREGA SOLO 1 REGISTRO
			 
			 if( $_POST[ "txtConcepto" ] == "" ){
			 	$arrErrores[] = "Ingrese el Nombre del Concepto";
			 }
			 
			 if( $_POST[ "numProyecto" ] == "" ){
			 	$arrErrores[] = "Ingrese el Número del Proyecto";
			 }
			 
			 if( $_POST[ "valConcepto" ] == "" ){
			 	$arrErrores[] = "Ingrese el Valor del Concepto";
			 }
			 
			 if( $_POST[ "fchConcepto" ] == "" ){
			 	$arrErrores[] = "Ingrese la Fecha del Concepto";
			 }
			 
			 $arrDatosConcepto[] = $_POST;
		}
		
	}
	
	
	if( !empty( $arrErrores ) ){
		imprimirMensajes( $arrErrores );
	}else{
		$claCrm = new CRM;
		$arrErrores = $claCrm->salvarConcepto( $arrDatosConcepto );
		
		if( !empty( $arrErrores ) ){
			imprimirMensajes( $arrErrores );
		}else{
			$arrMensajeOk = "Los datos se agregaron correctamente";
			imprimirMensajes( "" , $arrMensajeOk );
		}
	}
	

?>
