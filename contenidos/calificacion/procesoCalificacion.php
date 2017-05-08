<?php

	/**
	 * SCRIPT QUE REALIZA LA CALIFICACION
	 * DE LOS HOGARES SEGUN LA MODALIDAD
	 * A LA QUE SE INSCRIBIERON
	 * @author bzerdar
	 * @version 2.0 Septiembre 2009
	 */

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );    	
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CalificacionSubsidios.class.php" );

	// Tipos de documento
	$sql = "
		SELECT 
			seqTipoDocumento,
			txtTipoDocumento
		FROM 
			T_CIU_TIPO_DOCUMENTO
		ORDER BY
			txtTipoDocumento
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrTipoDocumento[ $objRes->fields['seqTipoDocumento'] ] = strtoupper( $objRes->fields['txtTipoDocumento'] );
		$objRes->MoveNext();
	}
	
	// Carga los formularios listos para calificar ( solo identificadores )
	$claFormulario = new FormularioSubsidios;
	$arrPostulados = $claFormulario->listosCalificacion();	
	
	if( empty( $arrPostulados ) ){
		imprimirMensajes( array( "No se encontraron formularios en etapa de postualción en estado cosecha cerrados" ) , array() );
	}else{
		
		// Obtiene la informacion completa de todos los formularios listos
		$arrFormularios = array();
		foreach( $arrPostulados as $seqFormulario ){
			$objFormulario = new FormularioSubsidios;
			$objFormulario->cargarFormulario( $seqFormulario );
			$arrFormularios[ $seqFormulario ] = $objFormulario;
			unset( $objFormulario );
		}		
		
		/**
		 * CALIFICACION DE LOS FORMULARIOS
		 */

		$claCalificacion = new CalificacionSubsidios;
		foreach( $arrFormularios as $seqFormulario => $objFormulario ){
			
			// hala el nombre de la funcion que califica segun la modalidad
			$txtFuncion   = $claCalificacion->arrModalidad[ $objFormulario->seqModalidad ]['fnc'];
			$txtModalidad = $claCalificacion->arrModalidad[ $objFormulario->seqModalidad ]['nom'];

			// Busca el postulante principal de este formulario
			// para colocarlo en la informacion del archivo
			$bolCertificadoElectoral = false;
			foreach( $objFormulario->arrCiudadano as $objCiudadano ){
				if( $objCiudadano->seqParentesco == 1 ){
					$txtNombre = $objCiudadano->txtNombre1." ";
					$txtNombre.= $objCiudadano->txtNombre2." ";
					$txtNombre.= $objCiudadano->txtApellido1." ";
					$txtNombre.= $objCiudadano->txtApellido2;
					$txtTipoDocumento = $arrTipoDocumento[ $objCiudadano->seqTipoDocumento ];
					$numDocumento = $objCiudadano->numDocumento;
					break;
				}
				
				// si alguno de los miembros presento el certificado electoral
				if( $bolCertificadoElectoral == false and $objCiudadano->bolCertificadoElectoral == 1 ){
					$bolCertificadoElectoral = true;
				}
				
			}
			
			// Obtiene la calificacion del hogar
			$arrTotalFormulario = $claCalificacion->$txtFuncion( $objFormulario );
			
			// Datos del hogar calificado
			$arrCalificacion[ $seqFormulario ][ 'datos' ][ 'tpoDocumento' ]  = $txtTipoDocumento;
			$arrCalificacion[ $seqFormulario ][ 'datos' ][ 'numDocumento' ]  = $numDocumento;
			$arrCalificacion[ $seqFormulario ][ 'datos' ][ 'nomPostulante' ] = $txtNombre;
			$arrCalificacion[ $seqFormulario ][ 'datos' ][ 'txtModalidad' ]  = $txtModalidad;
			
			// Asigna la calificacion al hogar
			$arrCalificacion[ $seqFormulario ][ 'calificacion' ] = $arrTotalFormulario;

			// Obtiene los totales de calificacion para despues ordenarlos
			$arrTotales[ $seqFormulario ] =  $arrCalificacion[ $seqFormulario ][ 'calificacion' ][ 'total' ];

			// modalidad de desempate
			// sdv: para modalidad adquisiscion, construccion y mejoramiento
			// arr: para modalidad de arrendamiento
			$txtModalidadDesempate = ( $objFormulario->seqModalidad == 5 )? "arr" : "sdv" ; 

			// Obtiene los puntajes empatados y sus formularios
			$numCalificacion = (string) $arrCalificacion[ $seqFormulario ][ 'calificacion' ][ 'total' ]; 
			$arrEmpates[ $txtModalidadDesempate ][ $numCalificacion ][] = $seqFormulario;
			
			// Obtiene los criterios de desempate
			$arrCriteriosDesempate[ $seqFormulario ][ 'modalidad' ] = $objFormulario->seqModalidad;
			if( $objFormulario->seqModalidad != 5 ){
				$arrCriteriosDesempate[ $seqFormulario ][ 'sisben' ]      = intval( $objFormulario->seqSisben );
				$arrCriteriosDesempate[ $seqFormulario ][ 'condiciones' ] = intval( trim( $arrCalificacion[ $seqFormulario ][ 'calificacion' ][ 'variables' ][ 'b5' ][ 'formulario' ] , "Condiciones Especiales" ) );
				$arrCriteriosDesempate[ $seqFormulario ][ 'etnias' ]      = ( $arrCalificacion[ $seqFormulario ][ 'calificacion' ][ 'variables' ][ 'b3' ]['valor'] == 0 )? 0 : 1 ;
				$arrCriteriosDesempate[ $seqFormulario ][ 'socios' ]      = ( in_array( $objFormulario->seqBancoCuentaAhorro , $claCalificacion->arrSociosEstrategicos ) or in_array( $objFormulario->seqBancoCuentaAhorro2 , $claCalificacion->arrSociosEstrategicos ))? 1 : 0;
				$arrCriteriosDesempate[ $seqFormulario ][ 'certificado' ] = ( $bolCertificadoElectoral == true )? 1 : 0 ;
			}else{
				$arrCriteriosDesempate[ $seqFormulario ][ 'sisben' ]        = intval( $objFormulario->seqSisben );
				$arrCriteriosDesempate[ $seqFormulario ][ 'mesesArriendo' ] = $arrTotalFormulario['variables']['b7']['numero'];
				$arrCriteriosDesempate[ $seqFormulario ][ 'monoparental' ]  = $claCalificacion->hogarMonoparental( $objFormulario );
				$arrCriteriosDesempate[ $seqFormulario ][ 'condiciones' ]   = $arrTotalFormulario['variables']['b1']['numero'];
				$arrCriteriosDesempate[ $seqFormulario ][ 'menores' ]       = $arrTotalFormulario['variables']['b8']['numero'];
				$arrCriteriosDesempate[ $seqFormulario ][ 'terceraEdad' ]   = $arrTotalFormulario['extras']['terceraEdad']; 
				$arrCriteriosDesempate[ $seqFormulario ][ 'etnias' ]        = ( $arrTotalFormulario['variables']['b3']['valor'] == 0 )? false : true;
				$arrCriteriosDesempate[ $seqFormulario ][ 'desplazado' ]    = $objFormulario->bolDesplazado;
				$arrCriteriosDesempate[ $seqFormulario ][ 'asignado' ]      = $claCalificacion->hogarAsignado( $objFormulario ); 
				$arrCriteriosDesempate[ $seqFormulario ][ 'certificado' ]   = ( $bolCertificadoElectoral == true )? 1 : 0 ;
			}
			
		}

		/**
		 * PROCESO DE DESEMPATES
		 */
		
		if( empty( $arrErrores ) ){
			
			// Ordena por puntajes los empates  
			arsort( $arrTotales );
			foreach( $arrEmpates as $txtModalidadDesempate => $arrPuntajes ){
				krsort( $arrEmpates[ $txtModalidadDesempate ] );
			}
			
			// aplica el algoritmo de desempates
			do {
				$bolEmpates = false;
				foreach( $arrEmpates as $txtModalidadDesempate => $arrPuntajes ){
					foreach( $arrPuntajes as $numPuntaje => $arrFormulariosEmpatados ){
						unset( $arrEmpates[ $txtModalidadDesempate ][ $numPuntaje ] );
						if( count( $arrFormulariosEmpatados ) > 1 ){
							$bolEmpates = true;
							$arrPuntajesNuevos = $claCalificacion->desempatarFormularios( $txtModalidadDesempate, $numPuntaje , $arrFormulariosEmpatados , $arrCriteriosDesempate );
							foreach( $arrPuntajesNuevos as $seqFormulario => $numPuntajeNuevo ){
								$arrTotales[ $seqFormulario ] = $numPuntajeNuevo;
								$arrCalificacion[ $seqFormulario ][ 'calificacion' ][ 'total' ] = $numPuntajeNuevo;
								$arrEmpates[ $txtModalidadDesempate ][ (string) $numPuntajeNuevo ][] = $seqFormulario;
							} 
						}	
					}
				}
								
			} while( $bolEmpates == true );
			
			/**
			 * GUARDA LAS CALIFICACIONES EN UN ARCHIVO,
			 * EN UNA TABLA DE LA BASE DE DATOS Y
			 * CAMBIA LOS ESTADOS DE LOS FORULARIOS INVOLUCRADOS
			 */
			
			$txtNombreArchivo = "";
			$arrMensajes = $claCalificacion->guardarCalificaciones( $arrTotales , $arrCalificacion );	
			
			if( $arrMensajes['mensajes']['nombreArchivo'] != "" ){
				$txtNombreArchivo = $arrMensajes['mensajes']['nombreArchivo']; 
			}
			
			$claSmarty->assign( "txtArchivo" , $txtNombreArchivo );
			$claSmarty->assign( "arrTotales" , $arrTotales );
			$claSmarty->assign( "arrCalificacion" , $arrCalificacion );
			$claSmarty->display( "calificacion/procesoCalificacion.tpl" );		

			if( ! empty( $arrMensajes['error'] ) ){
				imprimirMensajes( $arrMensajes['error'] , array() );
			}
			
		}else{
			imprimirMensajes( $arrErrores , array() );
		}	

		
	}
	

?>
