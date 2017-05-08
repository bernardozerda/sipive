<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CiudadanoBp.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidiosBp.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoBp.class.php" );
	
	$bolMostrarConfirmacion = true;
	$arrErrores 			= array();
	
	$txtMensaje = "Es necesario que confirme la accion que esta apunto de realizar:";
	$txtMensaje.= "<div class='msgOk' style='font-size:12px;'>¿Desea crear la inscripción para el documento ".number_format($_POST['numDocumento'],0,'.',',')."?</div>";
	
	if( is_numeric( $_POST['seqFormularioEditar'] ) == true ){
		
		$claFormulario = new FormularioSubsidios;
		$claFormulario->cargarFormulario( $_POST['seqFormularioEditar'] );
		
		$bolCambiaDatos = false;
		
		// Campos que se pueden cambiar sin privilegios
		$arrCamposLibres[] = "txtDireccion";
		$arrCamposLibres[] = "numTelefono1";
		$arrCamposLibres[] = "numTelefono2";
		$arrCamposLibres[] = "numCelular";
		$arrCamposLibres[] = "seqLocalidad";
		$arrCamposLibres[] = "txtBarrio";
        $arrCamposLibres[] = "seqCajaCompensacion";
        $arrCamposLibres[] = "bolBeneficiario";
		
		$arrCamposCambiados = array();
		
		if( $_POST['txtArchivo'] == "./contenidos/subsidios/salvarInscripcion.php" ){
			
			// Cambios en los datos del ciudadano
			foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
                if( $objCiudadano->seqParentesco == 1 ){
                    foreach( $objCiudadano as $txtClave => $txtValor ){
                        if( isset( $_POST[ $txtClave ] ) ){
                            if( $objCiudadano->$txtClave != $_POST[ $txtClave ] ){
                                $arrCamposCambiados[] = $txtClave;
                                $bolCambiaDatos = true;
                            }
                        }
                    }
                }
			}
			
			// Cambios en los datos del formulario
			unset( $claFormulario->arrCiudadano );
			foreach( $claFormulario as $txtClave => $txtValor ){
				if( isset( $_POST[ $txtClave ] ) ){
					if( $txtValor != $_POST[ $txtClave ] ){
						$arrCamposCambiados[] = $txtClave;
						$bolCambiaDatos = true;
					}
				}
			}
			
			// si los campos son solo sobre los campos libres
			// se considera que no hay cambios y se realiza la modificacion
			$bolCambiosLibres = true; 
			
			foreach( $arrCamposCambiados as $txtCampoCambiado ){
				if( ! in_array( $txtCampoCambiado , $arrCamposLibres ) ){
					$bolCambiosLibres = false;
				}
			}
			
			// si los campos son solo sobre los campos libres UNICAMENTE
			// se considera que no hay cambios y se realiza la modificacion            
			if( $bolCambiosLibres and !$bolCambiaDatosMiembroHogar ){
				$bolCambiaDatos = false;
			}
			
			// si no hay cambios no muestra la ventana de confirmacion
			if( $bolCambiaDatos ){
				$txtMensaje = "Es necesario que confirme la accion que esta apunto de realizar:";
				$txtMensaje.= "<div class='msgError' style='font-size:12px;'>¿Desea modificar la inscripción para el documento ".number_format($_POST['numDocumento'],0,'.',',')."?</div>";
				$numDocumentoHogar = $_POST['numDocumento'];
			}else{
				$bolMostrarConfirmacion = false;
				$numDocumentoAtendido = $objCiudadano->numDocumento;
				$txtCiudadanoAtendido = $objCiudadano->txtNombre1   . " " . $objCiudadano->txtNombre2 . " " . 
										$objCiudadano->txtApellido1 . " " . $objCiudadano->txtApellido2;
			}
			
		}else{ // para postualcion
			
			// Si la variable de cerrado no viene hay que colocarla en cero
			if( ! isset( $_POST['bolCerrado'] ) ){
				$_POST['bolCerrado'] = 0;
			}
			
			// Cambios en el hogar
			$arrCedulasFormulario = array();
			foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
				$numDocumento = $objCiudadano->numDocumento;
				$arrCedulasFormulario[] = $numDocumento;
				if( isset( $_POST['hogar'][ $numDocumento ] ) ){
					foreach( $objCiudadano as $txtClave => $txtValor ){
						if( isset( $_POST['hogar'][ $numDocumento ][ $txtClave ] ) ){
							if( $txtValor != $_POST['hogar'][ $numDocumento ][ $txtClave ] ){
								$arrCamposCambiados[] = $txtClave;
								$bolCambiaDatos = true;
							}
						}
					}
				} else {
					$arrCamposCambiados[] = "objCiudadano";
					$bolCambiaDatos = true;
				}
			}
			
			$bolCambiaDatosMiembroHogar = false;
			foreach( $_POST['hogar'] as $numDocumento => $arrMiembro ){
				if( ! in_array( $numDocumento , $arrCedulasFormulario ) ){
					$bolCambiaDatosMiembroHogar = true;
					$bolCambiaDatos = true;
				}				
			}
			
			// Cambios en los datos del formulario
			unset( $claFormulario->arrCiudadano );
			$arraynombrecampos = array();
			foreach( $claFormulario as $txtClave => $txtValor ){
				if( isset( $_POST[ $txtClave ] ) ){
					
					$txtValor = ( $txtValor === "0000-00-00" )? "" : $txtValor ;
					$txtValor = ( $txtValor === null )? 0 : $txtValor ;
					if( $txtValor != $_POST[ $txtClave ] ){
						//echo $txtClave . 'txtValor: ' . $txtValor . '-->' . $valFormateado . '<br>';
						$arrCamposCambiados[] = $txtClave;
						$arraynombrecampos[] = $txtClave;
						$bolCambiaDatos = true;
					}
				}
			}
			 //var_dump($arraynombrecampos);
			 //var_dump($arrCamposCambiados);
			// si los campos son solo sobre los campos libres
			// se considera que no hay cambios y se realiza la modificacion
			$bolCambiosLibres = true; 
			foreach( $arrCamposCambiados as $txtCampoCambiado ){
				if( ! in_array( $txtCampoCambiado , $arrCamposLibres ) ){
					$bolCambiosLibres = false;
				}
			}
			
			// si los campos son solo sobre los campos libres UNICAMENTE
			// se considera que no hay cambios y se realiza la modificacion            
			if( $bolCambiosLibres and !$bolCambiaDatosMiembroHogar ){
				$bolCambiaDatos = false;
			}
			
			// si no hay cambios no muestra la ventana de confirmacion
			if( $bolCambiaDatos ){
				$txtMensaje = "Es necesario que confirme la accion que esta apunto de realizar:";
				$txtMensaje.= "<div class='msgError' style='font-size:12px;'>¿Desea modificar la postulacion del miembro de hogar ".$_POST['numDocumentoAtendido']."?</div>";
				$numDocumentoHogar = $_POST['numDocumentoAtendido'];
			}else{
				$bolMostrarConfirmacion = false;
				$numDocumentoAtendido = $_POST['numDocumentoAtendido'];
				$txtCiudadanoAtendido = $_POST['txtCiudadanoAtendido'];
			}
		}
	}
	
	
	// Si hubo cambios en el formulario muestra el pop up de confirmacion
	if( $bolMostrarConfirmacion ){
		if( $_POST[ "bolSancion" ] == 1 ){
			$numDocumentoHogar = number_format( $numDocumentoHogar , 0 , '.' , ',' );
			$arrErrores[] = "No se puede modificar la postulacion del miembro de hogar $numDocumentoHogar debido a que esta Sancionado.";
			imprimirMensajes( $arrErrores , array() );
		}else{
			$claSmarty->assign( "txtMensaje" , $txtMensaje );
			$claSmarty->assign( "bolMostrarConfirmacion" , $bolMostrarConfirmacion );
			$claSmarty->assign( "txtArchivo" , $_POST['txtArchivo'] );
			$claSmarty->assign( "arrPost" , $_POST );
			$claSmarty->display( "subsidios/pedirConfirmacion.tpl" );
		}
	}else{
		// Grupo de Gestion 
		if( $_POST['seqGrupoGestion'] == 0 ){
			$arrErrores[] = "Seleccione el grupo de la gestión realizada";
		}
		
		// Grstion
		if( $_POST['seqGestion'] == 0 ){
			$arrErrores[] = "Seleccione la gestión realizada";
		}
		
		// Comentarios
		if( $_POST['txtComentario'] == "" ){
			$arrErrores[] = "Por favor diligencie el campo de comentarios";
		} 

		// direccion de residencia
		if( $_POST['txtDireccion'] == "" ){
			$arrErrores[] = "Debe dar una direcci&oacute;n";
		}
		
		// numero de telefono
		if( $_POST['numTelefono1'] == "" ){
			$arrErrores[] = "El formulario debe tener por lo menos un tel&eacute;fono de contacto";
		}	
		
		// Campos opcionales
		$_POST['numTelefono2'] = ( $_POST['numTelefono2'] == "" )? 0 : $_POST['numTelefono2'];
		$_POST['numCelular']   = ( $_POST['numCelular'] == "" )? 0 : $_POST['numCelular'];
		
		
		// errores de validacion
		if( empty( $arrErrores ) ){
			
			// formulario original para ser comparado con los cambios libres
			$claFormulario = new FormularioSubsidios;
			$claFormulario->cargarFormulario( $_POST['seqFormularioEditar'] );
			
			// formulario que sera alterado con los cambios libres para salvar estas modificaciones
			$claFormularioCambio = new FormularioSubsidios;
			$claFormularioCambio->cargarFormulario( $_POST['seqFormularioEditar'] );
			
			// campos libres modificados
			$claFormularioCambio->txtDireccion = $_POST[ "txtDireccion" ];
			$claFormularioCambio->numTelefono1 = $_POST[ "numTelefono1" ];
			$claFormularioCambio->numTelefono2 = $_POST[ "numTelefono2" ];
			$claFormularioCambio->numCelular   = $_POST[ "numCelular" ];
			$claFormularioCambio->seqLocalidad = ( intval( $_POST[ "seqLocalidad" ] ) == 0 )? 1 : $_POST[ "seqLocalidad" ]; 
			$claFormularioCambio->txtBarrio    = $_POST[ "txtBarrio" ];
			$claFormularioCambio->fchUltimaActualizacion = date( "Y-m-d H:i:s" );
            $claFormularioCambio->seqCajaCompensacion = 0;
            $claFormularioCambio->bolBeneficiario = 0;
            
			// Cambios necesarios para la actualizacion
			$claFormularioCambio->seqProyecto = ( $_POST['seqProyecto'] == 0 )? "null" : $_POST['seqProyecto'];
			
			// Salvando los cambios modificados
			$claFormularioCambio->editarFormulario( $_POST['seqFormularioEditar'] );	
			
			if( empty( $claFormularioCambio->arrErrores ) ){
			
				// obtiene los cambios para dejar el registro
				$claSeguimiento = new Seguimiento;
				$txtCambios = $claSeguimiento->cambiosPostulacion( $_POST['seqFormularioEditar'] , $claFormulario , $claFormularioCambio );
				
				$numDocumentoAtendidoFormat = str_replace(".", "", $numDocumentoAtendido);
				
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
						" . $_POST['seqFormularioEditar'] . ",
						now(),
						". $_SESSION['seqUsuario'] .",
						\"" . ereg_replace( "\n", "" , $_POST['txtComentario'] ) . "\",
						\"$txtCambios\",
						". $numDocumentoAtendidoFormat .",
						\"". $txtCiudadanoAtendido ."\",
						" . $_POST['seqGestion'] . "
					)					
				";
				
				try { 
					$aptBd->execute( $sql );
					$seqSeguimiento = $aptBd->Insert_ID();
				} catch ( Exception $objError ){
					$arrErrores[] = "No se ha podido registrar la actividad del hogar, contacte al administradorrrrr";
				}
			
			}else{
				$arrErrores = $claFormularioCambio->arrErrores;
			} // fin errores en los cambios del formulario libres
			
		} // fin errores de validacion
			
		if( empty( $arrErrores ) ){
			$arrMensajes[] = "Ha salvado un registro de actividad, el numero del registro es " . number_format( $seqSeguimiento , 0 , "." , "," ) . 
							". Conserve este número para su referencia.";
			imprimirMensajes( array() ,  $arrMensajes );
		}else{
			imprimirMensajes( $arrErrores , array() );
		}
		
		
	}
	

?>
