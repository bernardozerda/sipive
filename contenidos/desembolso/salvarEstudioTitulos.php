<?php

	/**
	 * SALVA LOS DATOS DE DESEMBOLSO EN LA FASE DE 
	 * REVISION JURIDICA
	 * @author Bernardo Zerda
	 * @version 1.0 Dic 2009
	 * @version 2.0 Jun 2013
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
	
    $arrDato['aprobo'] = "txt";
    $arrDato['fecha1'] = "fch";
    $arrDato['notaria1'] = "num";
    $arrDato['fecha2'] = "fch";
    $arrDato['notaria2'] = "num";
    $arrDato['ciudadAdquisicion'] = "txt";
    $arrDato['ciudadIdentificacion'] = "txt";
    $arrDato['numerofolio'] = "num";
    $arrDato['zona'] = "txt";
    $arrDato['ciudadMatricula'] = "txt";
    $arrDato['fechaMatricula'] = "fch";
    $arrDato['resolucion'] = "num";
    $arrDato['ano'] = "num";
    $arrDato['escritura1'] = "num";
    $arrDato['escritura2'] = "num";
    $arrDato['txtPropiedad'] = "txt";
    
	//echo $_POST['escritura1'] .  " ==> " . $_POST['escritura2'] . "<br>";
	
    // reemplaza todos los caracteres que son de presentacion 
    // y que no deben ir a la base de datos
	foreach( $_POST as $txtClave => $txtValor ){
        if( ! is_array( $_POST[ $txtClave ] ) ){
            switch( $arrDato[ $txtClave ] ){
                case "txt":
                    $_POST[ $txtClave ] = preg_replace( "/[^áéíóúñÁÉÍÓÚÑA-Za-z0-9\ \.\-\/]/" , "" , $txtValor );
                    break;
                case "fch":
                    $_POST[ $txtClave ] = preg_replace( "/[^0-9\-\/]/" , "" , $txtValor );
                    break;
                case "num":
                    $_POST[ $txtClave ] = preg_replace( "/[^0-9]/" , "" , $txtValor );
                    break;
                default:
                    $_POST[ $txtClave ] = preg_replace( "/[^áéíóúñÁÉÍÓÚÑA-Za-z0-9\ \.\-\/]/" , "" , $txtValor );
                    break;
            }
        }
	}
    
    /**
     * VERIFICACION DE LOS CAMPOS OBLIGATORIOS
     */
    
	if( $_POST[ "seqModalidad" ] != 5 ){

		if( intval( $_POST['escritura1'] ) == 0 ){
			$arrErrores[] = "Indique el número de la escritura para el inmueble actual";
		}
	
		if( intval( $_POST['escritura2'] ) == 0 ){
			$arrErrores[] = "Indique el número de la escritura para el titulo de adquisicion";
		}
	
		if( ! esFechaValida( $_POST['fecha1'] ) ){
			$arrErrores[] = "Indique la fecha de la escritura para el inmueble actual";
		}
	
		if( ! esFechaValida( $_POST['fecha2'] ) ){
			$arrErrores[] = "Indique la fecha de la escritura para el titulo de adquisicion";
		}
		
		if( intval( $_POST['notaria1'] ) == 0 ){
			$arrErrores[] = "Indique la notaría de la escritura para el inmueble actual";
		}
	
		if( intval( $_POST['notaria2'] ) == 0 ){
			$arrErrores[] = "Indique la notaría de la escritura para el titulo de adquisicion";
		}	
		
		if( intval( $_POST['numerofolio'] ) == 0 ){
			$arrErrores[] = "Indique el número de folio para la Matricula Inmobilaria";
		}		
	
		if( trim( $_POST['zona'] ) == "" ){
			$arrErrores[] = "Indique la zona de la oficina de instrumentos públicos";
		}	
		
		if( ! esFechaValida( $_POST['fechaMatricula'] ) ){
			$arrErrores[] = "Indique la fecha de la matricula";
		}
		
		if( trim( $_POST['ciudadAdquisicion'] ) == "" ){
			$arrErrores[] = "Indique la ciudad del titulo de adquisición";
		}
		
		if( trim( $_POST['ciudadIdentificacion'] ) == "" ){
			$arrErrores[] = "Indique la ciudad del titulo de la identificacion actual del inmueble";
		}
		
	}
	
	if( isset( $_POST['subsidioFonvivienda'] ) ){
		if( ! isset( $_POST['resolucion'] ) or intval( $_POST['resolucion'] ) == 0 ){
			$arrErrores[] = "Si tiene subsidio de fonvivienda debe indicar el número de la resolución";
		}
		if( ! isset( $_POST['ano'] ) or intval( $_POST['ano'] ) == 0 ){
			$arrErrores[] = "Si tiene subsidio de fonvivienda debe indicar año de la resolución";
		}else{
            $_POST['ano'] = preg_replace( "/[^0-9]/" , "" , $_POST['ano'] );
        }
	}else{
		unset( $_POST['resolucion'] );
		unset( $_POST['ano'] );
	}
	
	if( trim( $_POST['aprobo'] ) == "" ){
		$arrErrores[] = "Indique quien aprueba este documento";
	}
	
    /**
     * PROCEDE A SALVAR EL REGISTRO
     */
    
	$arrMensajes = array( );
	if( empty( $arrErrores ) ){
	
		if( is_numeric( $claDesembolso->seqDesembolso )  and $claDesembolso->seqDesembolso != 0 ){
			
	 		$claSeguimiento = new Seguimiento;
	 		$_POST['txtCambios'] = $claSeguimiento->cambiosDesembolso( $arrCodigo['fase'] , $claDesembolso , $_POST );
			
            // obtiene el nombre de la persona que ha sido atendida
            foreach( $claFormulario->arrCiudadano as $objCiudadano ){
                if( str_replace( "." , "" , $objCiudadano->numDocumento ) == $_POST['cedula'] ){
                    $_POST['nombre'] = $objCiudadano->txtNombre1 . " " . $objCiudadano->txtNombre2 . " " . $objCiudadano->txtApellido1 . " " . $objCiudadano->txtApellido2;
                }
            }
            
			$arrErrores = $claDesembolso->salvarEstudioTitulos( $_POST );
			
			$claCrm = new CRM;
			$claCrm->asignarFormularioTutor( $_POST[ "seqFormulario" ] );
			
			if( empty( $arrErrores ) ){
				
				// cambio estado
				$sql = "
					UPDATE T_FRM_FORMULARIO SET
						seqEstadoProceso = " . $_POST['seqEstadoProceso'] . "
					WHERE seqFormulario = " . $_POST['seqFormulario'] . "
				";
				$aptBd->execute( $sql );
				
			}			
			
		}
		
	}
	
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
