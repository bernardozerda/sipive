<?php

	/**
	 * SALVA LOS DATOS DE DESEMBOLSO EN LA FASE DE 
	 * REVISION JURIDICA
	 * @author Bernardo Zerda
	 * @version 1.0 Dic 2009
	 * @version 2.0 Jun 2013
    * @version 2.1 Ene 2014 // Cambio en los actos administrativos
	 */
     
	// Verifica los permisos de creacion / edicion
	if( intval( $claDesembolso->arrTitulos['seqEstudioTitulos'] ) == 0 ){
		if( $_SESSION[ "privilegios" ][ "crear" ] != 1 ){
			$arrErrores[] = "No tiene privilegios para salvar el registro";
		}
	}else{
		if( $_SESSION[ "privilegios" ][ "editar" ] != 1 ){
			$arrErrores[] = "No tiene privilegios para editar el registro";
		}
	}
    
    // reemplaza todos los caracteres que son de presentacion 
    // y que no deben ir a la base de datos
    foreach( $_POST as $txtClave => $txtValor ){
        if( ! is_array( $_POST[ $txtClave ] ) ){
            $txtPatron = "";
            switch( substr( $txtClave , 0 , 3 ) ){
                case "num":
                    $txtPatron = "[^0-9A-Za-z\ ]";
                break;
                case "seq":
                    $txtPatron = "[^0-9]";
                break;
                case "fch":
                    $txtPatron = "[^0-9A-Za-z\ \-\/]";
                break;
                case "txt":
                    $txtPatron = "[^áéíóúÁÉÍÓÚñÑA-Za-z0-9\ \.\-\/@\,\+\&]";
                break;
                default:
                    if( ! in_array( $txtClave , array("valor","registro1","registro2","numeroRadicado","numeroOrden","monto") ) ) {
                        $txtPatron = "[^áéíóúÁÉÍÓÚñÑA-Za-z0-9\ \.\-\/@\,]";
                    }else{
                        $txtPatron = "[^0-9A-Za-z\ ]";
                    }
                break;
            }
        }
        $_POST[$txtClave] = mb_ereg_replace($txtPatron,"",$txtValor);
    }

    if( $claFormulario->seqTipoEsquema != 1 ){
    
        /**
         * VALIDACIONES PARA LA SOLICITUD DE LOS DESEMBOLSOS
         */

        switch( true ){
            case $_POST['registro1'] == "" and $_POST['fecha1'] == "" :
                $arrErrores[] = "No puede solicitar un desembolso sin el registro presupuestal";	
            break; 
            case $_POST['registro1'] != "" and $_POST['fecha1'] == "" :
                $arrErrores[] = "Se requiere la fecha del registro presupuestal (1)";	
            break;	
            case $_POST['registro1'] == "" and $_POST['fecha1'] != "":
                $arrErrores[] = "Se requiere el número del registro presupuestal (1)";	
            break;
        }

        switch( true ){
            case $_POST['registro2'] != "" and $_POST['fecha2'] == "" :
                $arrErrores[] = "Se requiere la fecha del registro presupuestal (2)";	
            break;	
            case $_POST['registro2'] == "" and $_POST['fecha2'] != "":
                $arrErrores[] = "Se requiere el número del registro presupuestal (2)";	
            break;
        }

        if( ( ! isset( $_POST['valor'] ) ) or intval( $_POST['valor'] ) == 0 ){
            $arrErrores[] = "Por favor indique el valor solicitado para este desembolso";
        }

        if( ! isset( $_POST['bolCedulaBeneficiario'] ) ){
            $arrErrores[] = "Falta por adjuntar la copia de la cedula del beneficiario";
        }

        if( ! isset( $_POST['bolCartaAsignacion'] ) ){
            $arrErrores[] = "Falta por adjuntar la copia de la carta de asignacion";
        }

        // Cuando es por inmobiliaria o constructora
        if ( $claDesembolso->txtTipoDocumentos != "persona" && $claDesembolso->txtTipoDocumentos != "" ){

            if( ! isset( $_POST['bolRut'] ) ){
                $arrErrores[] = "Falta por adjuntar la copia del RUT del vendedor o arrendador";
            }

    //		if( ! isset( $_POST['bolNit'] ) ){
    //			$arrErrores[] = "Falta por adjuntar la copia del NIT del vendedor o arrendador";
    //		}

            if( ! isset( $_POST['bolCedulaRepresentante'] ) ){
                $arrErrores[] = "Falta por adjuntar la copia de la cedula del representante legal";
            }

            if( ! isset( $_POST['bolCamaraComercio'] ) ){
                $arrErrores[] = "Falta por adjuntar la copia de Camara y Comercio de la compañía";
            }

        } else{

            if( ! isset( $_POST['bolCedulaVendedor'] ) ){
                $arrErrores[] = "Falta por adjuntar la copia de la cedula del vendedor o arrendador";
            }

        }

        if( $claFormulario->seqModalidad != 5 ){ // Otras modalidades de subsidio (5 == arrendamiento)

            if( ! isset( $_POST['bolCertificacionBancaria'] ) ){
                $arrErrores[] = "Falta por adjuntar la copia de la carta de certificación bancaria";
            }

            if( ! isset( $_POST['bolAutorizacion'] ) ){
                $arrErrores[] = "Falta por adjuntar el original de la autorizacion de desembolso";
            }

            if( $claFormulario->seqModalidad == 3 or $claFormulario->seqModalidad == 4 ){

                if( ! isset( $_POST['bolActaEntregaFisica'] ) ){
                    $arrErrores[] = "Falta por adjuntar el original del Acta entrega física de la obra";
                }

                if( ! isset( $_POST['bolActaLiquidacion'] ) ){
                    $arrErrores[] = "Falta por adjuntar el original del Acta de liquidación";
                }

            }

        } else { // modalidad de arriendo

            if( $_POST['bolBancoArrendador'] != 1 ){
                $arrErrores[] = "Verifique si esta la certificación bancaria del arrendador";
            }

        }

//        if( trim( $_POST['txtSubsecretaria'] ) == "" ){
//            $arrErrores[] = "Debe indicar el nombre de quien forma por parte de la Subsecretaria de Gestión Financiera";
//        }

        if( isset( $_POST[ 'bolSubsecretariaEncargado' ] ) and trim( $_POST['txtSubsecretaria'] ) == "" ){
            $arrErrores[] = "Debe indicar el nombre de quien esta encargado en la Subsecretaria de Gestión Financiera";
        }

        if( trim( $_POST['txtRevisoSubsecretaria'] ) == "" ){
            $arrErrores[] = "Indique el nombre de quien revisa el documento";
        }

        switch( true ){ 
            case $_POST['numeroRadicado'] != "" and $_POST['fechaRadicado'] == "" :
                $arrErrores[] = "Se requiere la fecha del registro presupuestal (1)";	
            break;	
            case $_POST['numeroRadicado'] == "" and $_POST['fechaRadicado'] != "":
                $arrErrores[] = "Se requiere el número del registro presupuestal (1)";	
            break;
        }

        switch( true ){ 
            case $_POST['numeroOrden'] != "" and $_POST['fechaOrden'] == "" and $_POST['monto'] == "" :
                $arrErrores[] = "Se requiere la fecha y el valor de la orden de pago";	
            break;	
            case $_POST['numeroOrden'] != "" and $_POST['fechaOrden'] != "" and $_POST['monto'] == "" :

                $arrErrores[] = "Se requeire el monto de la orden de pago";	
            break;
            case $_POST['numeroOrden'] == "" and $_POST['fechaOrden'] != "" and $_POST['monto'] == "" :
                $arrErrores[] = "Se requiere el numero de la orden de pago";	
            break;	
            break;
            case $_POST['numeroOrden'] != "" and $_POST['fechaOrden'] == "" and $_POST['monto'] == "" :
                $arrErrores[] = "Se requiere la fecha de la orden de pago";
            break;
            case $_POST['numeroOrden'] == "" and $_POST['fechaOrden'] != "" and $_POST['monto'] == "" :
                $arrErrores[] = "Se requiere el numero y el monto de la orden de pago";
            break;
        }

        list( $ano , $mes , $dia ) = split( "-" , $_POST['fecha1'] );
        if( @checkdate( $mes , $dia , $ano ) === false ){
            $_POST['fecha1'] = textoFecha2Fecha( $_POST['fecha1'] );
        }

        list( $ano , $mes , $dia ) = split( "-" , $_POST['fecha2'] );
        if( @checkdate( $mes , $dia , $ano ) === false ){
            $_POST['fecha2'] = textoFecha2Fecha( $_POST['fecha2'] );
        }

        list( $ano , $mes , $dia ) = split( "-" , $_POST['fechaRadicado'] );
        if( @checkdate( $mes , $dia , $ano ) === false ){
            $_POST['fechaRadicado'] = textoFecha2Fecha( $_POST['fechaRadicado'] );
        }

        list( $ano , $mes , $dia ) = split( "-" , $_POST['fechaOrden'] );
        if( @checkdate( $mes , $dia , $ano ) === false ){
            $_POST['fechaOrden'] = textoFecha2Fecha( $_POST['fechaOrden'] );
        }


        // Numero del proyecto de inversion
        if( ( ! isset( $_POST['numProyectoInversion'] ) ) or intval( $_POST['numProyectoInversion'] ) == 0 ){
            $arrErrores[] = "Seleccione el proyecto de inversion"; 
        }

        // Nombre del beneficiario del giro
        if( trim( $_POST['txtNombreBeneficiarioGiro'] ) == "" ){
            $arrErrores[] = "Nombre a del beneficiario del giro";
        }

        if ($_POST['txtTipoCuentaGiro'] != 'depjudicial'){
			// Numero de cuenta del beneficiario del giro
			if( trim( $_POST['numDocumentoBeneficiarioGiro'] ) == "" ){
				$arrErrores[] = "Numero de documento del beneficiario del giro";
			}

			// Numero de cuenta del beneficiario del giro
			if( trim( $_POST['txtDireccionBeneficiarioGiro'] ) == "" ){
				$arrErrores[] = "Dirección del beneficiario del giro";
			}

			// Numero de cuenta del beneficiario del giro
			if( trim( $_POST['numTelefonoGiro'] ) == "" ){
				$arrErrores[] = "Numero Telefónico del beneficiario del giro";
			}
		}

        // Correo electronico del beneficiario del giro
    //    if( trim( $_POST['txtCorreoGiro'] ) != "" ){
    //        if ( ! preg_match('[0-9A-Za-z\.\-\_]*@[0-9A-Za-z\-\_]*\.[A-Za-z0-9]{2,3}[\.A-Za-z0-9]*',$_POST['txtCorreoGiro'])){
    //            $arrErrores[] = "El valor que digit&oacute; en el campo de correo electr&oacute;nico no es v&aacute;lido";
    //        } 
    //    }

        // Numero de cuenta del beneficiario del giro
        if( trim( $_POST['numCuentaGiro'] ) == "" ){
            $arrErrores[] = "Numero de cuenta del beneficiario del giro";
        }

        // Tipo de cuenta del beneficiario del giro
        if( trim( $_POST['txtTipoCuentaGiro'] ) == "" ){
            $arrErrores[] = "Seleccione el tipo de cuenta del beneficiario del giro";
        }

        // Banco del beneficiario del giro
        if( intval( $_POST['seqBancoGiro'] ) == 0 or intval( $_POST['seqBancoGiro'] ) == 1 ){
            $arrErrores[] = "Seleccione el banco del beneficiario del giro";
        }

        /**
         * validaciones para el monto del subsidio con relacion al saldo
         */

        if( intval( $_POST['monto'] ) != 0 and ( $_POST['monto'] > $_POST['valor'] ) ){
            $arrErrores[] = "No se puede registrar un valor pagado superior al valor solicitado";
        }

        /**
         * PROCESAMIENTO DE LOS DATOS
         */

        if( empty( $arrErrores ) ){


            $valDesembolsos =  $claFormulario->valAspiraSubsidio;
            if(
                ( $claFormulario->seqModalidad == 6  && $claFormulario->seqTipoEsquema == 7 )  ||
                ( $claFormulario->seqModalidad == 6  && $claFormulario->seqTipoEsquema == 13 ) ||
                ( $claFormulario->seqModalidad == 12 && $claFormulario->seqTipoEsquema == 14 ) ||
                ( $claFormulario->seqModalidad == 12 && $claFormulario->seqTipoEsquema == 15 )
            ){
                $valDesembolsos += $claFormulario->valComplementario;
            }

            if( isset( $_POST['seqSolicitudEditar'] ) and intval( $_POST['seqSolicitudEditar'] ) != 0 ){
                $seqSolicitudEditar = $_POST['seqSolicitudEditar']; 
                if( intval( $claDesembolso->arrSolicitud[ $seqSolicitudEditar ]['valOrden'] ) == 0 ){

                    $valSolicitudes = $claDesembolso->arrSolicitud['valSolicitudes'] - $claDesembolso->arrSolicitud[ $seqSolicitudEditar ]['valSolicitado'];
                    $valSolicitudes += $_POST['valor'];

                    if( $valSolicitudes > $valDesembolsos ){
                        $arrErrores[] = "No puede digitar un valor tan alto porque supera el valor del saldo (o el monto total) del subsidio";
                    }
                }else{
                    $arrErrores[] = "No puede editar esta solicitud si ya tiene un numero y orden de pago";
                }
            }else{
                $valSolicitudes = $claDesembolso->arrSolicitud['valSolicitudes'] + $_POST['valor'];
                if( $valSolicitudes > $valDesembolsos ){
                    $arrErrores[] = "No puede digitar un valor tan alto porque supera el valor del saldo (o el monto total) del subsidio";
                }
            }

            if( empty( $arrErrores ) ){

                $claActosAdministrativos = new ActoAdministrativo();

                $claSeguimiento = new Seguimiento;
                $_POST['txtCambios'] = $claSeguimiento->cambiosDesembolso( $arrCodigo['fase'] , $claDesembolso , $_POST );

                // obtiene el nombre de la persona que ha sido atendida
                foreach( $claFormulario->arrCiudadano as $objCiudadano ){
                    if( str_replace( "." , "" , $objCiudadano->numDocumento ) == $_POST['cedula'] ){
                        $_POST['nombre'] = $objCiudadano->txtNombre1 . " " . $objCiudadano->txtNombre2 . " " . $objCiudadano->txtApellido1 . " " . $objCiudadano->txtApellido2;
                    }
                }

                // Salvando el registro
                $arrErrores = $claDesembolso->salvarSolicitud( $_POST );

                // Si se solicita borrar los giros de desembolsos se hace
                if( empty( $arrErrores ) ){
                   if( intval( $_POST['bolBorrar'] ) == 1 ){
                      $arrSolicitudes = array_keys( $claDesembolso->arrSolicitud['detalles'] );
                      $arrSeguimiento['cedula'] = $_POST['cedula'];
                      $arrSeguimiento['nombre'] = $_POST['nombre'];
                      $arrSeguimiento['seqGestion'] = $_POST['seqGestion'];
                      $arrSeguimiento['txtCambios'] = "";
                      foreach( $arrSolicitudes as $seqSolicitud ){
                         $arrSeguimiento['txtComentario'] = "Fin del proceso para el hogar " . $_POST['cedula'] . " procesando el giro numero " . $seqSolicitud;
                         $claDesembolso->borrarSolicitud( $_POST['seqFormulario'] , $seqSolicitud , $arrSeguimiento );
                      }
                   }
                }

                if( empty( $arrErrores ) ){

                    $bolCambioEstado = true;
                    if( $_POST['seqEstadoProceso'] == $arrCodigo['final'] ){
                        $seqProyecto = $_SESSION['seqProyecto'];
                        if( ! isset( $_SESSION['arrGrupos'][$seqProyecto][9] ) ){
                            $bolCambioEstado = false;
                        }
                    }

                    // cambio estado
                    if( $bolCambioEstado ) {
                        $sql = "
                            UPDATE T_FRM_FORMULARIO SET
                                seqEstadoProceso = " . $_POST['seqEstadoProceso'] . "
                            WHERE seqFormulario = " . $_POST['seqFormulario'] . "
                        ";
                        //echo $sql;
                        $aptBd->execute( $sql );
                    }else{
                        $arrErrores[] = "No tiene permisos para finalizar el proceso";
                    }
                    
                }	

            }
        }
    
    } else {
        
        // cambio estado
        $sql = "
            UPDATE T_FRM_FORMULARIO SET
                seqEstadoProceso = " . $_POST['seqEstadoProceso'] . "
            WHERE seqFormulario = " . $_POST['seqFormulario'] . "
        ";
        //echo $sql;
        $aptBd->execute( $sql );
        
        foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
            if( $objCiudadano->numDocumento == $_POST['cedula'] ){
                $txtNombre  = trim( $objCiudadano->txtNombre1 ) . " ";
                $txtNombre .= ( trim( $objCiudadano->txtNombre2 ) != "" )? trim( $objCiudadano->txtNombre2 ) . " " : "";
                $txtNombre .= trim( $objCiudadano->txtApellido1 ) . " ";
                $txtNombre .= trim( $objCiudadano->txtApellido2 );
            }
        }
        
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
              " . $_POST['seqFormulario'] . ",
              '" . date( "Y-m-d H:i:s" ) . "',
              ". $_SESSION['seqUsuario'] .",
              '". $_POST['txtComentario'] ."',
              'Cambios en el formulario " . $_POST['seqFormulario'] . "\nseqEstadoProceso, Valor Anterior: " . $claFormulario->seqEstadoProceso . ", Valor Nuevo: " . $_POST['seqEstadoProceso'] . "',
              ". $_POST['cedula'] .",
              '". $txtNombre ."',
              ".$_POST['seqGestion']."
            )	
        ";	
         
        try{ //echo $sql . "<hr>";
            $aptBd->execute( $sql );
            $claDesembolso->seqSeguimiento = $aptBd->Insert_ID();
        } catch ( Exception $objError ){
            $arrErrores[] = "No se ha podido registrar el evento, contacte al administrador del sistema";
        }	
        
    }    
        
	$arrMensajes = array();
	if( empty( $arrErrores ) ){
		$arrMensajes[] = "La gestión se ha salvado, el numero de registro es " . number_format( $claDesembolso->seqSeguimiento , 0 , "." , "," ) . "<br>conserve este numero para referencia futura";
		$txtEstilo = "msgOk";
	}else{
		$arrMensajes = $arrErrores;
		$txtEstilo = "msgError";
	}

	echo "<table cellpadding='0' cellspacing='0' border='0' width='100%' id='tablaMensajes' style='padding:5px' class='$txtEstilo'>";
    foreach( $arrMensajes as $txtMensaje ){
    	echo "<tr><td class='$txtEstilo'><li>$txtMensaje</li></td></tr>";
    }
    echo "</table>";	

	

?>
