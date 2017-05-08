<?php

	/**
 	 * SALVA LOS DATOS DE LA PREVIABILIZACION DEL BANCO DE VIVIEND
 	 * @author Bernardo Zerda
 	 * @version 1.0 Dec 15, 2010 
	 **/

	$txtPrefijoRuta = "../../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "BancoVivienda.class.php" );
	
	$claGenerales = new Generales;

	/** 
	 * VALIDACION DE DATOS
	 */
	
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
		case UPLOAD_ERR_NO_FILE:
		  $arrErrores[] = "Debe especificar un archivo para cargar";
		break; 
	} 
	
	if( empty( $arrErrores ) ){
		
		// valores posibles
		$arrValoresPosibles[ "BarrioLegalizado" ] 		 = array( "si" , "no" ); 
		$arrValoresPosibles[ "ReservaVial" ]      		 = array( "si" , "no" );
		$arrValoresPosibles[ "ZonaRiezgo" ]       		 = array( "alta" , "media" , "baja" , "no" );
		$arrValoresPosibles[ "ZonaProteccionAmbiental" ] = array( "si" , "no" );
		$arrValoresPosibles[ "RemocionMasa" ]       	 = array( "alta" , "media" , "baja" , "no" );
		
		$arrArchivo = array();
		$aptArchivo = fopen( $_FILES['archivo']['tmp_name'] , "r" );
		if( $aptArchivo ){
			$txtLinea = fgets( $aptArchivo );
			$numLinea = 0;
			while( $txtLinea = fgets( $aptArchivo ) ){
				$numLinea++;
				$arrLinea = split( "\t" , $txtLinea );
				foreach( $arrLinea as $numPosicion => $txtValor ){
					$arrLinea[ $numPosicion ] = strtolower( trim( $txtValor ) );
				}
				
				// id Vivienda
				if( ( $arrLinea[0] == "" ) or ( ! is_numeric( $arrLinea[0] ) ) ){
					$arrErrores[] = "Error Linea $numLinea: En la columna uno (idVivienda) debe coloar un valor numérico";
				}
				
				// Estado Proceso
				if( ( intval( $arrLinea[1] ) == 0 ) or ( ! isset( $claGenerales->arrEstadoProceso[ $arrLinea[1] ] ) ) ){
					$arrErrores[] = "Error Linea $numLinea: En la columna dos (Estado Proceso) debe colocar un valor numerico válido";
				}
				
				// Matricula Inmobiliaria
				if( $arrLinea[2] == "" ){
					$arrErrores[] = "Error Linea $numLinea: En la columna tres (Matricula Inmobiliaria) debe colocar un valor";
				}
				
				// chip
				if( ( $arrLinea[3] == "" ) or ( ! preg_match( "/^A{3}[0-9A-Z]+$/" , trim( strtoupper( $arrLinea[3] ) ) ) ) ){
					$arrErrores[] = "Error Linea $numLinea: En la columna cuatro (CHIP) debe colocar algun valor y el chip debe tener el formato correcto ";
				}
				
				// barrio legalizado
				if( $arrLinea[4] == "" or ( ! in_array( $arrLinea[4] , $arrValoresPosibles["BarrioLegalizado"] ) )  ){
					$arrErrores[] = "Error Linea $numLinea: En la columna cinco (Barrio Legalizado) debe colocar " . implode( " o " , $arrValoresPosibles["BarrioLegalizado"] );
				}
				
				// reserva vial
				if( trim( $arrLinea[5] ) != "" ){
					if( ! in_array( $arrLinea[5] , $arrValoresPosibles["ReservaVial"] ) ){
						$arrErrores[] = "Error Linea $numLinea: En la columna seis (Reserva Vial) debe colocar " . implode( " o " , $arrValoresPosibles["ReservaVial"] ) . " o la celda vacia";
					}
				}
				
				// Zona Riezgo
				if( $arrLinea[6] == "" or ( ! in_array( $arrLinea[6] , $arrValoresPosibles["ZonaRiezgo"] ) )  ){
					$arrErrores[] = "Error Linea $numLinea: En la columna siete (Zona Riesgo) debe colocar " . implode( " o " , $arrValoresPosibles["ZonaRiezgo"] );
				}
				
				// Zona Proteccion Ambiental
				if( $arrLinea[7] == "" or ( ! in_array( $arrLinea[7] , $arrValoresPosibles["ZonaProteccionAmbiental"] ) )  ){
					$arrErrores[] = "Error Linea $numLinea: En la columna ocho (Zona Proteccion Ambiental) debe colocar " . implode( " o " , $arrValoresPosibles["ZonaProteccionAmbiental"] );
				}
				
				// Remocion Masal
				if( $arrLinea[8] == "" or ( ! in_array( $arrLinea[8] , $arrValoresPosibles["RemocionMasa"] ) )  ){
					$arrErrores[] = "Error Linea $numLinea: En la columna nueve (Remocion Masa) debe colocar " . implode( " o " , $arrValoresPosibles["RemocionMasa"] );
				}
				
				if( empty( $arrErrores ) ){
					$arrArchivo[] = $arrLinea;
				}
				
			}
			
		}else{
			$arrErrores[] = "No se pudo abrir el archivo, contacte al administrador";
		}
	}
	
	$arrMensajes = array();
	if( empty( $arrErrores ) ){
		$claInmueble = new Inmueble;
		$claInmueble->salvarPreviabilizacion( $arrArchivo );
		if( empty( $claInmueble->arrErrores ) ){
			$arrMensajes = "Se han procesado " . count( $arrArchivo ) . " lineas satisfactoriamente";
		}else{
			$arrErrores = $claInmueble->arrErrores;
		}
	} 
	
	imprimirMensajes( $arrErrores , $arrMensajes );

?>
