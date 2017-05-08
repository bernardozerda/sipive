<?php

	/**
	 * AQUI SE REALIZA LA POSTULACION DE LOS 
	 * HOGARES INSCRITOS PARA  EL SUBSIDIO DE
	 * ARRENDAMIENTO
	 * @author Bernardo Zerda
	 * @version 1.0 Agosto de 2010
	 */
	
	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
	
	$arrErrores = array();
	
	$claFormulario = new FormularioSubsidios;
	$claFormularioNuevo = new FormularioSubsidios;
	$claSeguimiento = new Seguimiento;
	
	try{
		
		// obtiene los hogares inscritos para subsidio de arrendamiento
		$sql = "
			SELECT seqFormulario 
			FROM T_FRM_FORMULARIO 
			WHERE seqModalidad = 1
			  AND seqEstadoProceso = 1
		";
		$objRes = $aptBd->execute( $sql );
		$arrFormularios = array();
		while( $objRes->fields ){
			$arrFormularios[] = $objRes->fields[ "seqFormulario" ];
			$objRes->MoveNext();
		}
		
		// desordena el array para que no queden en orden de entrada y favorcer a ciertos hogares
		shuffle( $arrFormularios );
		
		// Verifica que haya hogares para el subsidio
		if( count( $arrFormularios ) == 0 ){
			$arrErrores[] = "No hay hogares en estado Inscrito - Inscrito para la modalidad de Adquisición de Vivienda";
		} else {
			
			// seleccionando la muestra de hogares
			if( is_numeric( $_POST[ "cantidad" ] ) and $_POST[ "cantidad" ] > 0 ){
				
				// formularios posutlados
				$arrPostulados = array();
				
				// Calcula la muestra que debe ser 1.5 la cantidad de subsidios para asignar
				$numMuestra = intval( ( $_POST[ "cantidad" ] * 1.5 ) );
				if( count( $arrFormularios ) < $numMuestra ){
					$numMuestra = count( $arrFormularios ); 
				}

				// Obtiene la muestra de formulario
				$arrMuestra = array_rand( $arrFormularios , $numMuestra );
				foreach( $arrMuestra as $numClave ){
					$arrPostulados[] = $arrFormularios[ $numClave ];
				}
				
			
				// obtiene la informacion de los hogares para construir la tabla
				$arrDatosPostulados = array();
				foreach( $arrPostulados as $seqFormulario ){
					
					$claFormulario->cargarFormulario( $seqFormulario );
					foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
						if( $objCiudadano->seqParentesco == 1 ){
							break;
						}
					}
					
					$sql = "
						UPDATE T_FRM_FORMULARIO SET
							seqModalidad = 5,
							seqEstadoProceso = 10
						WHERE seqFormulario = $seqFormulario
					";
					$aptBd->execute( $sql );
					
					$claFormularioNuevo->cargarFormulario( $seqFormulario );
					
					$txtCambios = $claSeguimiento->cambiosPostulacion( $seqFormulario, $claFormulario, $claFormularioNuevo );
					
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
						  $seqFormulario, 
						  NOW(), 
						  " . $_SESSION[ 'seqUsuario' ] . ", 
						  'Postulado por seleccion aleatoria', 
						  '$txtCambios', 
						  " . $objCiudadano->numDocumento . ", 
						  '" . $objCiudadano->txtNombre1 . " " . $objCiudadano->txtNombre2 . " " . $objCiudadano->txtApellido1 . " " . $objCiudadano->txtApellido2 . "', 
						  46
						)
					";
					$aptBd->execute( $sql );
					
					$arrDatosPostulados[ $seqFormulario ][ "TipoDocumento" ] = obtenerNombres( "T_CIU_TIPO_DOCUMENTO" , "seqTipoDocumento" , $objCiudadano->seqTipoDocumento );
					$arrDatosPostulados[ $seqFormulario ][ "Documento" ]     = $objCiudadano->numDocumento;
					$arrDatosPostulados[ $seqFormulario ][ "Nombre" ]        = $objCiudadano->txtNombre1 . " " . $objCiudadano->txtNombre2 . " " . $objCiudadano->txtApellido1 . " " . $objCiudadano->txtApellido2;
					$arrDatosPostulados[ $seqFormulario ][ "Direccion" ]     = $claFormulario->txtDireccion;
					$arrDatosPostulados[ $seqFormulario ][ "Telefono 1" ]    = $claFormulario->numTelefono1;
					$arrDatosPostulados[ $seqFormulario ][ "Telefono 2" ]    = $claFormulario->numTelefono2;
					$arrDatosPostulados[ $seqFormulario ][ "Celular" ]       = $claFormulario->numCelular;
					
				}
				
			}else{
				$arrErrores[] = "La cantidad de hogares para asignar debe ser mayor que cero";
			}

		}
	
	} catch ( Exception $objError ){
		$arrErrores[] = $objError->msg; 
	}
	
	// Si hay errores los imprime
	if( ! empty( $arrErrores ) ){
		imprimirMensajes( $arrErrores , array() );
	}
	
	$claSmarty->assign( "arrDatosPostulados" , $arrDatosPostulados );
	$claSmarty->display( "subsidios/seleccionarHogaresArriendo.tpl" );
	
?>
