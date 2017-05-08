<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
//	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
//	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
//	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
	
	include( "../desembolso/datosComunes.php" );
	
	$txtEnvio 		 = isset( $_POST[ "txtEnvio" ] );
	
	switch( $txtEnvio ){
		
		case true:
			
			$txtComentario = $_POST[ "txtComentario" ];
		
			// Grupo de Gestion 
			if( $_POST['seqGrupoGestion'] == 0 ){
				$arrErrores[] = "Seleccione el grupo de la gestión realizada";
			}
			
			// Gestion
			if( $_POST['seqGestion'] == 0 ){
				$arrErrores[] = "Seleccione la gestión realizada";
			}
			
			// Comentarios
//			if( $_POST['txtComentario'] == "" ){
//				$arrErrores[] = "Por favor diligencie el campo de comentarios";
//			}
			
			// Errores en la carga de archivos
			switch( $_FILES['archivo']['error'] ){
				case UPLOAD_ERR_INI_SIZE:
				  $arrErrores[] = "El archivo Excede el tamaño permitido, contacte al administrador del sistema";
				break;  
				case UPLOAD_ERR_FORM_SIZE:
				    $arrErrores[] = "El archivo Excede el tamaño permitido, contacte al administrador del sistema";
				break; 
				case UPLOAD_ERR_PARTIAL:
				  $arrErrores[] = "El archivo no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
				break; 
			}
			
			if( empty( $arrErrores ) ){
				
				$aptArchivo = fopen( $_FILES['archivo']['tmp_name'] , "r" );
				if( $aptArchivo ){
					
					$txtTitulos = fgets( $aptArchivo );
					$arrTitulos = split( "\t" , $txtTitulos );
					
					if( ! is_array( $arrTitulos ) ){
						$arrErrores[] = "Al parecer el archivo no esta separado por tabulaciones";
					}
					
					if( strtolower( trim( $arrTitulos[ 0 ] ) ) != "documento" ){
						$arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Documento\" ";
					}
					
					if( strtolower( trim( $arrTitulos[ 1 ] ) ) != "comentario" ){
						$arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Comentario\" ";
					}
					
					$numLinea 		= 1;
					$arrArchivo 	= array(); 
					$numRegistros 	= 1;
					while( $txtLinea = fgets( $aptArchivo ) ){
						
						$arrLinea = split( "\t" , $txtLinea );
					
						$numDocumento 	= trim( $arrLinea[ 0 ] );
						if( ! is_numeric( $numDocumento ) ){
							$arrErrores[] = "Error en la linea $numLinea: El documento debe ser un valor num&eacute;rico [ $numDocumento ]";
						}
						
						$arrArchivo[ $numDocumento ]['comentario'][ $numLinea ] = trim( utf8_encode( $arrLinea[ 1 ] ) );
						$arrDocumentos[ $numDocumento ] = $numLinea;
						
						$arrClaFormulario[ $numLinea ] = $claFormulario;
						$numLinea++;
						$numRegistros++;
						
					} // fin validaciones archivo
					
					if( empty( $arrErrores ) ){
						
						$txtNumDocumentos = ( empty( $arrDocumentos ) )?"null":implode( " , ", array_keys( $arrDocumentos ) );
						
						$sql = "
							SELECT
								hog.seqFormulario,
								ciu.numDocumento,
								upper( CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 ) ) as nombre
							FROM T_FRM_HOGAR hog 
							INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
							WHERE ciu.numDocumento in ( $txtNumDocumentos )
						";
						$objRes = $aptBd->execute( $sql );
						
						while( $objRes->fields ){
							
							$numDocumento = $objRes->fields['numDocumento'];
							if( isset( $arrDocumentos[ $numDocumento ] ) ){
								
								$arrSeqFormularios[ $numDocumento ] = $objRes->fields['seqFormulario'] ;
								$arrNombre[ $numDocumento ] 		= ereg_replace(  "\"" , "" , $objRes->fields['nombre'] );
								
								$arrDocumentosSql[]  = $objRes->fields['numDocumento'] ;
								
							}
							$objRes->MoveNext();
						}
						
						$arrDiffDocumentos = array_diff( array_keys( $arrDocumentos ), $arrDocumentosSql );
						
						
						if(  empty( $arrDiffDocumentos ) ){
							
							$arrInsertSql = array( );
							foreach( $arrDocumentos as $numDocumento => $numLinea ){
								
								$arrComentarioLinea = $arrArchivo[ $numDocumento ]['comentario'];
								$txtNombre 			= $arrNombre[ $numDocumento ];
								$seqFormulario 		= $arrSeqFormularios[ $numDocumento ];
								$txtComentario 		= ereg_replace(  "\"" , "" , $txtComentario );
								
								foreach( $arrComentarioLinea as $txtComentarioLinea ){
									$txtComentarioLinea = ereg_replace(  "\"" , "" , $txtComentarioLinea );
																	
									$arrInsert[ $numDocumento ][] = "INSERT INTO T_SEG_SEGUIMIENTO ( 
												seqFormulario, 
												fchMovimiento, 
												seqUsuario, 
												txtComentario, 
												txtCambios, 
												numDocumento, 
												txtNombre, 
												seqGestion
											) VALUES 
											(
												$seqFormulario,
												now(),
												". $_SESSION['seqUsuario'] .",
												\"Seguimiento Masivo: $txtComentario<br />$txtComentarioLinea\",
												\"\",
												$numDocumento,
												\"$txtNombre\",
												" . $_POST['seqGestion'] . "
											)
									";
								
								}
								
							}
														
						}else{
							foreach(  $arrDiffDocumentos as $numDocumento ){
								$numLinea = $arrDocumentos[ $numDocumento ]; 
								$arrErrores[] = "El documento $numDocumento en la linea $numLinea no esta atado a un formulario.";
							}					
						}
						
						if( empty( $arrErrores ) ){
							
							$numRegistros = 0;
							foreach( $arrInsert as $numDocumento => $arrSql ){
								foreach( $arrSql as $sql ){
									try { 
										$aptBd->execute( $sql );
									} catch ( Exception $objError ){
										$arrErrores[] = "No se pudo guardar el seguimiento del documento $numDocumento de la linea ". $arrDocumentos[ $numDocumento ];
									}
									$numRegistros++;
								}
							}
							
						}
					}
					
				}else{
					$arrErrores[] = "No se pudo acceder al archivo";
				}
				
			}
			
			if( empty( $arrErrores ) ){
				$arrMensajes[] = "Se guardaron los seguimientos en $numRegistros Registros";
				imprimirMensajes( array( ) , $arrMensajes , "salvarProyecto" );
			}else{
				imprimirMensajes( $arrErrores , array( ) );
			}	
			break;
		
		default:
			$claSmarty->display( "subsidios/seguimientoMasivo.tpl" );
			break;
	}
	
	

?>