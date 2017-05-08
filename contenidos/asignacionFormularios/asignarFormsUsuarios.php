<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "AsignacionFormularios.class.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
	
	$arrSeqFormularios = array( );
	$claAsignacionFormularios = new AsignacionFormularios;
	
	$txtVincular 	= $_POST["txtVincular"] ;
	
	if( $_FILES['archivoCedulas']['error'] == UPLOAD_ERR_NO_FILE ){
		
		if( !intval( $_POST["numCedula"] ) ){
			$arrErrores[] = "No ingreso un numero de documento valido.";
		}else{
			$numDocumento = $_POST["numCedula"];
			if( is_numeric( $numDocumento ) ){
				$seqFormulario = Ciudadano::formularioVinculado( $numDocumento, true );
				if( !$seqFormulario ){
					$arrErrores[] = "El documento ingresado no pertenece a un Postulante Principal";
				}else{
					$arrSeqFormularios[] = $seqFormulario;
				}  
			}else{
				$arrErrores[] = "Ha ingresado un documento no valido";
			}
		}
		
	}else{
		
		switch( $_FILES['archivoCedulas']['error'] ){
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
			
			$aptArchivo = fopen( $_FILES['archivoCedulas']['tmp_name'] , "r" );
			$numLinea = 1;
			while( $numDocumento = fgets( $aptArchivo ) ){
				try {
					$numDocumento = trim( $numDocumento );
					if( is_numeric( $numDocumento ) ){
						
						//Busca que la cedula sea del PPAL
						$seqFormulario = Ciudadano::formularioVinculado( $numDocumento );
						if( $seqFormulario ){
							$arrSeqFormularios[] = $seqFormulario;
						}else{
							throw new Exception( "El documento de la linea $numLinea no pertenece a un Postulante Principal" );
						}
						
					}else if ($numDocumento != ""){
						throw new Exception( "La linea $numLinea del archivo no contiene un número de documento válido" );
					}
				}catch( Exception $objError ){
					$arrErrores[] = $objError->getMessage();
				}
				$numLinea++;
			}
			
		}

	}
	
	if( $txtVincular == "" ){
		$arrErrores[] = "Debe seleccionar si desea vincular o desvincular los hogares.";
	}
	
	if( !isset( $_POST["seqCoordinador"] ) and $txtVincular == "vincular" ){
		$arrErrores[] = "Debe seleccionar un coodinador.";
	}
	
	if( !isset( $_POST["arrTutores"] ) ){
		$arrErrores[] = "Debe seleccionar un tutor.";
	}
	if( empty( $arrErrores ) ){
		
		$seqCoordinador = $_POST["seqCoordinador"];
		
		foreach( $_POST["arrTutores"] as $key => $seqTutor ){
			if( $seqTutor != "undefined" ){
				break;
			}
		}
		
		if( $txtVincular == "vincular" ){
			$fchAsignado = date( "Y-m-d" );
			$arrSqlInsert = array( );
			
			$sql = "
				SELECT seqFormulario
				from T_FRM_FORMULARIO_USUARIOS_ASIGNADOS
				where seqFormulario in ( ". implode( ", ", $arrSeqFormularios) ." )
			";
			
			$objRes = $aptBd->execute( $sql );
			$arrFormulariosAsignados = array( );
			while( $objRes->fields ){
				$arrFormulariosAsignados[] = $objRes->fields['seqFormulario'];
				$objRes->MoveNext();
			}
			
			if( !empty( $arrFormulariosAsignados ) ){
				foreach( $arrFormulariosAsignados as $seqFormulario  ){
					$documento = Ciudadano::documentoVinculado( $seqFormulario );
					$sql = "
						SELECT 
							seqUsuario
						FROM T_FRM_FORMULARIO_USUARIOS_ASIGNADOS
						WHERE seqFormulario = $seqFormulario
					";
					$objRes = $aptBd->execute( $sql );
					$seqTutor = $objRes->fields["seqUsuario"];
					$txtTutor = $claAsignacionFormularios->arrNombreTutorNoCuenta[$seqTutor];
					$arrErrores[] = "El documento $documento esta asignado al tutor(a) $txtTutor";
				}
			}
			
			if( empty( $arrErrores ) ){
				foreach( $arrSeqFormularios as $seqFormulario ){
					$arrSqlInsert[] = "($seqFormulario, $seqTutor, $seqCoordinador, '$fchAsignado')";
				}
				
				$sql = "
					INSERT INTO T_FRM_FORMULARIO_USUARIOS_ASIGNADOS
					(seqFormulario, seqUsuario, seqUsuarioCoordinador, fchAsignado) 
					VALUES ". implode( ", ", $arrSqlInsert);
				$objRes = $aptBd->execute( $sql );
			}
		}else if( $txtVincular == "desvincular" ){
			
			$sql = "
					SELECT seqFormulario
					FROM T_FRM_FORMULARIO_USUARIOS_ASIGNADOS
					WHERE seqFormulario IN (". implode( ", ", $arrSeqFormularios) .") AND seqUsuario <> $seqTutor
				";
			$objRes = $aptBd->execute( $sql );
			$arrFormulariosAsignados = array( );
			while( $objRes->fields ){
				$arrFormulariosAsignados[] = $objRes->fields['seqFormulario'];
				$objRes->MoveNext();
			}
			
			if( !empty( $arrFormulariosAsignados ) ){
				foreach( $arrFormulariosAsignados as $seqFormulario  ){
					$documento = Ciudadano::documentoVinculado( $seqFormulario );
					$arrErrores[] = "El documento $documento esta asignado a un tutor diferente";
				}
			}else{
				
				$sql = "
					DELETE FROM T_FRM_FORMULARIO_USUARIOS_ASIGNADOS
					WHERE seqFormulario IN (". implode( ", ", $arrSeqFormularios ) .")
				";
				$objRes = $aptBd->execute( $sql );
				
			}
			
		}
		
	}
	
	if( empty( $arrErrores ) ){
        $arrMensajes[] = "Se han $txtVincular correctamente los hogares al tutor";
        imprimirMensajes( array() , $arrMensajes , "salvarProyecto" );
    }else{
        imprimirMensajes( $arrErrores , array() );
    }	

?>
