<?php

	/**
	 * MOSTRANDO EL REPORTE DEL FNA
	 * SEGUN PARAMETROS DEL FORMULARIO
	 * @author Bernardo Zerda
	 * @version 1.0 Agosto 2010
	 */

	$txtPrefijoRuta = "../../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

	// arreglo de errores
	$arrErrores = array();

	// limita los hogares por etapas
	$txtCondicion = "";
	$arrCondicion = array( );
	$arrCondicion[] = "(
						frm.seqBancoCredito = 34
						OR frm.seqBancoCuentaAhorro = 34
						OR frm.seqBancoCuentaAhorro2 = 34
						)";
	$bolBuscarEtapa = false;
	if( $_POST['seqEtapa'] != 0 ){
		$txtCondicion = "AND eta.seqEtapa = " . $_POST['seqEtapa'] . " ";	
		$arrCondicion[] = "eta.seqEtapa = " . $_POST['seqEtapa'];
		$bolBuscarEtapa = true;
	}

	// Obtiene los documentos de la consulta
	$arrDocumentos = array();
	if( $_POST['numDocumento'] != "" ){
		$arrDocumentos[] = $_POST['numDocumento']; 
	}else{
		
		// verifica errores en el archivo
		switch( $_FILES['documentos']['error'] ){
			case UPLOAD_ERR_INI_SIZE:
			  $arrErrores[] = "El archivo Excede el tamaño permitido";
			break;  
			case UPLOAD_ERR_FORM_SIZE:
			    $arrErrores[] = "El archivo Excede el tamaño permitido";
			break; 
			case UPLOAD_ERR_PARTIAL:
			  $arrErrores[] = "El archivo no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
			break; 
//			case UPLOAD_ERR_NO_FILE:
//			  $arrErrores[] = "Debe especificar un archivo para cargar";
//			break; 
		}
		
		// si no hay errores continua
		if( empty( $arrErrores ) ){
			if( $_FILES['documentos']['tmp_name'] != "" ){
				$arrArchivo = file( $_FILES['documentos']['tmp_name'] );
				unset( $arrArchivo[0] );
				foreach( $arrArchivo as $numLinea => $txtDocumento ){
					$arrLinea = split( "\t" , $txtDocumento );
					if( is_numeric( trim( $arrLinea[ 0 ] ) ) ){
						$arrDocumentos[] = trim( $arrLinea[ 0 ] );
					}else{
						$arrErrores[] = "Error Linea " . $numLinea . ": '" . trim( $arrLinea[ 0 ] ) . "' no es un numero válido";
					}
				}
				
				// si hay mas de 1000 registros no permite la consulta
				if( count( $arrDocumentos ) > 1000 ){
					$arrErrores[] = "No puede consultar mas de 1000 registros cada vez";
				}
			}
		}
		
	}
	
	if( $_FILES['documentos']['tmp_name'] == "" and $_POST['numDocumento'] == "" and $_POST['seqEtapa'] == 0 ){
		$arrErrores[] = "No se permite ejecutar una consulta tan amplia, debera restringir su rango de busqueda";
	}
	
	
	// si no hay errores continua
	if( empty( $arrErrores ) ){
		
		// si hay limitacion de documentos
		if( ! empty( $arrDocumentos ) ){
			$sql = "
				SELECT hog.seqFormulario
				FROM T_FRM_HOGAR hog
				INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
				WHERE ciu.numDocumento IN ( " . implode( "," , $arrDocumentos ) . " )
				  AND ciu.seqTipoDocumento IN (1,2)
			";
			$objRes = $aptBd->execute( $sql );
			$arrFormularios = array();
			while( $objRes->fields ){
				$arrFormularios[] = $objRes->fields['seqFormulario'];
				$objRes->MoveNext();
			}
			if( !empty( $arrFormularios ) ){
				$txtCondicion .= "AND frm.seqFormulario IN (" . implode( "," , $arrFormularios ) . ") ";
				$arrCondicion[] = "frm.seqFormulario IN (" . implode( "," , $arrFormularios ) . ")";
			}
		}
		
		$sql = "
			SELECT frm.seqFormulario
			FROM T_FRM_FORMULARIO frm 
			";
		if( $bolBuscarEtapa ){
			$sql .= " INNER JOIN T_FRM_ESTADO_PROCESO epr on epr.seqEstadoProceso = frm.seqEstadoProceso 
					INNER JOIN T_FRM_ETAPA eta on eta.seqEtapa = epr.seqEtapa ";
		}
		$sql .= " WHERE ". implode( " AND " , $arrCondicion );
		$objRes = $aptBd->execute( $sql );
		$arrFormularios = array();
		while( $objRes->fields ){
			$arrFormularios[] = $objRes->fields['seqFormulario'];
			$objRes->MoveNext();
		}
		$txtSeqFormularios = ( !empty( $arrFormularios ) )?implode( "," , $arrFormularios ):"null";
		
		$sql = "
			SELECT 
			  ( SELECT tdo1.txtTipoDocumento
			    FROM T_CIU_TIPO_DOCUMENTO tdo1
			    INNER JOIN T_CIU_CIUDADANO ciu1 ON ciu1.seqTipoDocumento = tdo1.seqTipoDocumento
				INNER JOIN T_FRM_HOGAR hog1 ON hog1.seqCiudadano = ciu1.seqCiudadano
			    WHERE hog1.seqParentesco = 1 
			      AND hog1.seqFormulario = hog.seqFormulario
			  ) as TipoDocumentoPrincipal,
			  ( SELECT ciu1.numDocumento
			    FROM T_CIU_CIUDADANO ciu1
			    INNER JOIN T_FRM_HOGAR hog1 ON hog1.seqCiudadano = ciu1.seqCiudadano
			    WHERE hog1.seqParentesco = 1 
			      AND hog1.seqFormulario = hog.seqFormulario
			  ) as DocumentoPrincipal,
			  ( SELECT UPPER( CONCAT( ciu1.txtNombre1 , ' ' , ciu1.txtNombre2 , ' ' , ciu1.txtApellido1 , ' ' , ciu1.txtApellido2 ) )
			    FROM T_CIU_CIUDADANO ciu1
			    INNER JOIN T_FRM_HOGAR hog1 ON hog1.seqCiudadano = ciu1.seqCiudadano
			    WHERE hog1.seqParentesco = 1 
			      AND hog1.seqFormulario = hog.seqFormulario
			  ) as NombrePrincipal,
			  tdo.txtTipoDocumento as TipoDocumento,
			  ciu.numDocumento as Documento,
			  UPPER( CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 ) ) as Nombre,
			  eci.txtEstadoCivil as EstadoCivil,
			  par.txtParentesco as Parentesco,
			  moa.txtModalidad as Modalidad,
			  CONCAT( sol.txtDescripcion , ' (' , sol.txtSolucion , ')' ) as Solucion,
			  frm.valAspiraSubsidio as ValorSubsidio,
			  CONCAT( eta.txtEtapa , ' - ' , epr.txtEstadoProceso ) as Estado,
				IF(frm.bolCerrado = 1, 'SI', 'NO') as Cerrado,
			  IF( hvi.numActo IS NULL , 'No Disponible' , CONCAT( 
				(	SELECT 
						DISTINCT tac.txtNombreTipoActo
					FROM T_AAD_ACTO_ADMINISTRATIVO aad, T_AAD_TIPO_ACTO tac
					WHERE aad.numActo = hvi.numActo 
						AND aad.fchActo = hvi.fchActo
						AND aad.seqTipoActo = tac.seqTipoActo
				) , ' número ' , hvi.numActo , ' del ' , hvi.fchActo ) ) as ActoAdministrativo
			FROM
			  T_FRM_FORMULARIO frm
			  INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
			  INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
			  INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON ciu.seqtipoDocumento = tdo.seqTipoDocumento
			  INNER JOIN T_CIU_ESTADO_CIVIL eci ON ciu.seqEstadoCivil = eci.seqEstadoCivil
			  INNER JOIN T_CIU_PARENTESCO par ON hog.seqParentesco = par.seqParentesco
			  INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
			  INNER JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
			  INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
			  INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
			  LEFT JOIN T_AAD_FORMULARIO_ACTO fac ON fac.seqFormulario = frm.seqFormulario
			  LEFT JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
			  
			WHERE  ";
		
		$sql .= "frm.seqFormulario in ($txtSeqFormularios)";
		
		try {		

			$numInicio = time();
			$objRes = $aptBd->execute( $sql );
			
			if( is_array( $objRes->fields ) ){
				$txtArchivo = implode( "\t" , array_keys( $objRes->fields ) ) . "\r\n";
				$arrTabla[] = array_keys( $objRes->fields );
			}
			
			while( $objRes->fields ){
				$txtArchivo .= implode( "\t" , $objRes->fields ) . "\r\n";
				$arrTabla[] = $objRes->fields;
				$objRes->MoveNext();
			}
			
			$txtNombreArchivo =  "recursos/descargas/reporteFNA" . date( "Ymd_His" ) . ".xls";
			$aptArchivo = fopen( $txtPrefijoRuta . $txtNombreArchivo , "w+" );
			if( $aptArchivo ){
				fwrite( $aptArchivo , utf8_decode( $txtArchivo ) );
				fclose( $aptArchivo );
			}
			
			if( empty( $arrErrores ) ){
			
				$numFinal = time();
				$txtContador = $objRes->RecordCount() . " Registros en " . ( $numFinal - $numInicio ) . " segundos<br>";
				
				$claSmarty->assign( "txtArchivo" , $txtNombreArchivo );
				$claSmarty->assign( "txtContador" , $txtContador );
				$claSmarty->assign( "arrTabla" , $arrTabla );
				$claSmarty->assign( "txtNombreArchivo" , $txtNombreArchivo );
				$claSmarty->display( "fna/consultas/mostrarConsulta.tpl" );  
				
			} else {
				imprimirMensajes( $arrErrores , array() );
			}
			
		} catch ( Exception $objError ){
			$arrErrores[] = "Hubo un error al consultar la base de datos, verifique que solo hayan datos numericos dentro del archivo";
		}
		
	} else {
		imprimirMensajes( $arrErrores , array() );
	}
?>
