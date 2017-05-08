<?php

    /**
	 * SALVA LOS DATOS DE DESEMBOLSO EN LA FASE DE 
	 * REVISION JURIDICA
	 * @author Bernardo Zerda
	 * @version 1.0 Dic 2009
	 * @version 2.0 Jun 2013
	 */

	// Verifica los permisos de creacion / edicion
	if( intval( $claDesembolso->arrJuridico['seqJuridico'] ) == 0 ){
		if( $_SESSION[ "privilegios" ][ "crear" ] != 1 ){
			$arrErrores[] = "No tiene privilegios para salvar el registro";
		}
	}else{
		if( $_SESSION[ "privilegios" ][ "editar" ] != 1 ){
			$arrErrores[] = "No tiene privilegios para editar el registro";
		}
	}
	
	/*
	 * VALIDACION DE CAMPOS OBLIGATORIOS
	 */
	
	// validando el numero de la resolucion
	if( ! is_numeric( $_POST['numResolucion'] ) ){
		$arrErrores[] = "Debe dar el n&uacute;mero de la resoluci&oacute;n de asignaci&oacute;n";
	}
	
	// validando la fecha de la resolucion
	if( ! esFechaValida( $_POST['resolucion'] ) ){
		$arrErrores[] = "Indique una fecha v&aacute;lida para la resoluci&oacute;n de asignaci&oacute;n";
	}
	
	// validando observaciones
	if( $_POST['observaciones'] == "" ){
		$arrErrores[] = "El campo de observaciones no puede quedar vacio";
	}
	
	// validando libertad
	if( $_POST['libertad'] == "" ){
		$arrErrores[] = "El campo de libertad no puede quedar vacio";
	}
	
	// validando documentos analizados
	if( ! ( isset( $_POST['documento'] ) and is_array( $_POST ) ) ){
		$arrErrores[] = "Indique que documentos ha analizado";
	}
	
	// validando concepto
	if( $_POST['concepto'] == "" ){
		$arrErrores[] = "El campo de concepto no puede quedar vacio";
	}
	
	// validando preparo
	if( $_POST['aprobo'] == "" ){
		$arrErrores[] = "Indique el nombre de la persona que aprueba la elaboracion del documento";
	}
	
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
            
            //salva el registro de concepto juridico
			$arrErrores = $claDesembolso->salvarConceptoJuridico( $_POST );
			
            // asignacion del tutor si pertenece a los usuarios autorizados como tutores
			$claCrm = new CRM;
			$claCrm->asignarFormularioTutor( $_POST[ "seqFormulario" ] );
			
            // PONE EL ESTADO DEL PROCESO SEGUN ESTE EN EL FORMULARIO
			if( empty( $arrErrores ) ){
				$sql = "
					UPDATE T_FRM_FORMULARIO SET
						seqEstadoProceso = " . $_POST['seqEstadoProceso'] . "
					WHERE seqFormulario = " . $_POST['seqFormulario'] . "
				";
				$aptBd->execute( $sql );
				$arrMensajes[] = "La gestión se ha salvado, el numero de registro es " . number_format( $claDesembolso->seqSeguimiento , 0 , "." , "," ) . "<br>conserve este numero para referencia futura";
				$txtEstilo = "msgOk"; 
			}else{
				$arrMensajes = $arrErrores;
				$txtEstilo = "msgError";
			}
			
		}else{
			$arrErrores[] = "No hay registros de desembolsos asociados a este formulario";
			$arrMensajes = $arrErrores;
			$txtEstilo = "msgError";
		}

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
