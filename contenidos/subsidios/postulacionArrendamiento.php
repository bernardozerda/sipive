<?php

	/**
 	 * POSTULACION DE ARRENDAMIENTO PASO A PASO
 	 * @author Bernardo Zerda
 	 * @version 1.0 7/09/2010 
	 **/

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
    
    // Captura los errores
	$arrErrores = array();
    
    // paso en el que vamos
    $numPaso = ( isset( $_POST['paso'] ) )? $_POST['paso'] : 1 ;

	// Hogares que se pueden postular para el subsidio de arrendamiento
    $sql = "
		SELECT 
		  frm.seqFormulario,
		  ( 
		    SELECT tdo.txtTipoDocumento
		    FROM T_CIU_TIPO_DOCUMENTO tdo
		    WHERE tdo.seqTipoDocumento = ciu.seqTipoDocumento
		  ) as TipoDocumento,
		  ciu.numDocumento as Documento,
		  UPPER( CONCAT( ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2 ) ) as Nombre,
		  UPPER( frm.txtDireccion ) as Direccion,
		  frm.numTelefono1 as Telefono1,
		  frm.numTelefono2 as Telefono2,
		  frm.numCelular as Celular
		FROM T_FRM_FORMULARIO frm
		INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
		INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
		WHERE frm.seqModalidad = 1
		  AND frm.seqEstadoProceso = 1
		  AND frm.valIngresoHogar < " . ( $arrConfiguracion['constantes']['salarioMinimo'] * 2 ) . "
		  AND frm.valSaldoCuentaAhorro = 0
		  AND frm.valSaldoCuentaAhorro2 = 0
		  AND ciu.seqCajaCompensacion = 1
		  AND frm.fchInscripcion <= '2010-06-30' 
		  AND hog.seqParentesco = 1
	";
	
    try {
    	$objRes = $aptBd->execute( $sql );
    	$numRegistros = $objRes->RecordCount();
    	$arrHogares = array();
    	while( $objRes->fields ){
    		$seqFormulario = $objRes->fields['seqFormulario'];    		
    		unset( $objRes->fields['seqFormulario'] );
    		$arrHogares[ $seqFormulario ] = $objRes->fields;
    		$arrHogares[ $seqFormulario ]['Ticket'] = $seqFormulario;
    		$arrFormularios[ $seqFormulario ] = $seqFormulario;
    		$objRes->MoveNext();
    	}
    	$numRegistros = count( $arrHogares );
    } catch ( Exception $objError ){
    	$arrErrores[] = "No se han podido seleccionar los hogares que pueden postularse";
    }

	// ruta para la colocacion de archivos
	$txtRutaArchivo = $txtPrefijoRuta . "recursos/descargas/"; 
	$txtHoraArchivo = date( "Ymd_H" ); 

	// procedimiento para cada paso
    switch( $numPaso ){
    	
    	// PASO 1: Construccion del archivo de PreSeleccion
    	case 1: 
			
			// nombre del archivo para este paso
			$txtNombreArchivo = "PreSeleccion" . $txtHoraArchivo . ".xls";
			
			// abre el archivo
			$aptArchivo = fopen( $txtRutaArchivo . $txtNombreArchivo , "w"  );
			
			// Escribe el archivo
			if( $aptArchivo ){
				$txtArchivo = "Ticket\tTipoDocumento\tDocumento\tNombre\tDireccion\tTelefono1\tTelefono2\tCelular\r\n";
				foreach( $arrHogares as $seqFormulario => $arrDatos ){
					$txtArchivo .= utf8_decode( $arrDatos['Ticket'] ) . "\t";
					$txtArchivo .= utf8_decode( $arrDatos['TipoDocumento'] ) . "\t";
					$txtArchivo .= utf8_decode( $arrDatos['Documento'] ) . "\t";
					$txtArchivo .= utf8_decode( $arrDatos['Nombre'] ) . "\t";
					$txtArchivo .= utf8_decode( $arrDatos['Direccion'] ) . "\t";
					$txtArchivo .= utf8_decode( $arrDatos['Telefono1'] ) . "\t";
					$txtArchivo .= utf8_decode( $arrDatos['Telefono2'] ) . "\t";
					$txtArchivo .= utf8_decode( $arrDatos['Celular'] ) . "\r\n";
				}
				
				fwrite( $aptArchivo , $txtArchivo );
				fclose( $aptArchivo );
			}
			
    	break;
    	
    	// PASO 2: Asignacion de tickets
    	case 2:
    		
    		// si no viene la cantidad es un error
    		if( intval( $_POST['cantidad'] ) == 0 ){
    			$numPaso = $numPaso - 1;
    			$claSmarty->assign( "txtError" , "Digite el numero de subdisios a asignar" );
    		}else{
				
				// determina el tamano de la muestra
    			$numMuestra = ceil( $_POST['cantidad'] * 1.5 );
    			$bolMuestraModificada = false;
    			if( $numMuestra > count( $arrFormularios ) ){
    				$numMuestra = count( $arrFormularios );
    				$bolMuestraModificada = true;
    			} 
				
				// seleccion aleatoria de la muestra
				$arrSorteo = array_rand( $arrFormularios , $numMuestra );
				
				// hogares seleccionados por los tickets
	    		foreach( $arrHogares as $seqFormulario => $arrDatos ){
	    			if( ! in_array( $seqFormulario , $arrSorteo )  ){
	    				unset( $arrHogares[ $seqFormulario ] );
	    			}  
	    		}
	    		
				// nombre del archivo para este paso
				$txtNombreArchivo = "Seleccion" . $txtHoraArchivo . ".xls";
				
				// abre el archivo
				$aptArchivo = fopen( $txtRutaArchivo . $txtNombreArchivo , "w"  );	    	
				
				// Escribe el archivo
				if( $aptArchivo ){
					$txtArchivo = "Ticket\tTipoDocumento\tDocumento\tNombre\tDireccion\tTelefono1\tTelefono2\tCelular\r\n";
					foreach( $arrHogares as $seqFormulario => $arrDatos ){
						$txtArchivo .= utf8_decode( $arrDatos['Ticket'] ) . "\t";
						$txtArchivo .= utf8_decode( $arrDatos['TipoDocumento'] ) . "\t";
						$txtArchivo .= utf8_decode( $arrDatos['Documento'] ) . "\t";
						$txtArchivo .= utf8_decode( $arrDatos['Nombre'] ) . "\t";
						$txtArchivo .= utf8_decode( $arrDatos['Direccion'] ) . "\t";
						$txtArchivo .= utf8_decode( $arrDatos['Telefono1'] ) . "\t";
						$txtArchivo .= utf8_decode( $arrDatos['Telefono2'] ) . "\t";
						$txtArchivo .= utf8_decode( $arrDatos['Celular'] ) . "\r\n";
					}
					
					fwrite( $aptArchivo , $txtArchivo );
					fclose( $aptArchivo );
				}
	    		
	    		// Conteo de registros
	    		$numRegistros = count( $arrHogares );
				
				// cambio en los estados del proceso mas seguimiento
	    		$claFormulario      = new FormularioSubsidios;
	    		$claFormularioNuevo = new FormularioSubsidios;
	    		$claSeguimiento     = new Seguimiento;
	    		if( false )
	    		foreach( $arrHogares as $seqFormulario => $arrDatos ){
	    			
	    			$claFormulario->cargarFormulario( $seqFormulario );
					foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
						if( $objCiudadano->seqParentesco == 1 ){
							break;
						}
					}
	    			
	    			
	    			$sql = "
						UPDATE T_FRM_FORMULARIO SET
							seqModalidad = 5,
							seqSolucion = 1,
							seqEstadoProceso = 10
						WHERE seqFormulario = $seqFormulario
					";
					
//					$aptBd->execute( $sql );
//	    			
//	    			$claFormularioNuevo->cargarFormulario( $seqFormulario );
//						
//					$txtCambios = $claSeguimiento->cambiosPostulacion( $seqFormulario, $claFormulario, $claFormularioNuevo );
//					
//					$sql = " 
//						INSERT INTO T_SEG_SEGUIMIENTO (
//						  seqFormulario, 
//						  fchMovimiento, 
//						  seqUsuario, 
//						  txtComentario, 
//						  txtCambios, 
//						  numDocumento, 
//						  txtNombre, 
//						  seqGestion
//						) VALUES (
//						  $seqFormulario, 
//						  NOW(), 
//						  " . $_SESSION[ 'seqUsuario' ] . ", 
//						  'Hogar seleccionado por el sistema para posible postulacion de subsidio de arrendamiento', 
//						  '$txtCambios', 
//						  " . $objCiudadano->numDocumento . ", 
//						  '" . $objCiudadano->txtNombre1 . " " . $objCiudadano->txtNombre2 . " " . $objCiudadano->txtApellido1 . " " . $objCiudadano->txtApellido2 . "', 
//						  46
//						)
//					";
					
//					$aptBd->execute( $sql );
	    			
	    		}    						
				
				// Mensaje para fin del proceso
   				$claSmarty->assign( "txtError" , "Fin del proceso" );				
				
    		}
    		
    	break;	
    	    	
    }
	
	if( empty( $arrErrores ) ){
		$claSmarty->assign( "txtNombreArchivo" , $txtNombreArchivo );
    	$claSmarty->assign( "numRegistros" , $numRegistros ); 
    	$claSmarty->assign( "arrHogares"   , $arrHogares   );
    	$claSmarty->assign( "numPaso"      , $numPaso      );
		$claSmarty->display( "subsidios/postulacionArrendamiento.tpl" );
    } else {
    	imprimirMensajes( $arrErrores , array() );
    }	
	

?>
