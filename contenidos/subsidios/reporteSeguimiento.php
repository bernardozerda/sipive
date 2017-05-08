<?php

	/**
	 * REPORTE DE SEGUIMIENTO A CIUDADANOS
	 * @author Bernardo Zerda
	 * @version 1.0 Agosto 2009
	 */
	
	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );	
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']  . "Reportes.class.php" );
        
    $arrSeqFormularios = array( );
    if( isset( $_FILES['fileSecuenciales'] ) and !$_FILES['fileSecuenciales']['error']  ){
    	try {
			$aptArchivo = fopen( $_FILES['fileSecuenciales']['tmp_name'] , "r" );
			$numLinea = 1;
			while( $txtLinea = fgets( $aptArchivo ) ){
				try {
					$txtLinea = trim( $txtLinea );
					if( is_numeric( $txtLinea ) ){
						
						$seqFormulario = Ciudadano::formularioVinculado($txtLinea);
						if( $seqFormulario ){
							$arrSeqFormularios[] = $seqFormulario;
						}
						
					}
				}catch( Exception $objError ){ }
				$numLinea++;
			}
		}catch( Exception $objError ){ }
    }
    
	$fechaIni 			= $_POST['fchInicio'];
	$fechaFin 			= $_POST['fchFin'];
	$gestion 			= $_POST['seqGestion'];
	$seqGrupoGestion 	= $_POST['seqGrupoGestion'];
	$arrSeqSeguimiento 	= array();
	$arrCondicionSeqSeguimiento = array();
	
	if( $fechaIni ){
		$arrCondicionSeqSeguimiento[] = "seg.fchMovimiento >= '$fechaIni'";
	}
	if( $fechaFin ){
		$arrCondicionSeqSeguimiento[] = "seg.fchMovimiento <= '$fechaFin'";
	}
	if( $gestion ){
		$arrCondicionSeqSeguimiento[] = "seg.seqGestion = $gestion";
	}
	$arrCondicionSeqSeguimiento[] = "seg.bolMostrar = 1";
	
	if( !empty($arrCondicionSeqSeguimiento) ){
		if( !empty( $arrSeqFormularios ) ){
			$arrCondicionSeqSeguimiento[] = "seg.seqFormulario IN ( ". implode( $arrSeqFormularios, "," ) ." )";
		}
		$txtCondicionSeqGeguimiento = implode( " AND ", $arrCondicionSeqSeguimiento );
		$sql = "SELECT 
				seg.seqSeguimiento
				FROM T_SEG_SEGUIMIENTO seg
				WHERE ". $txtCondicionSeqGeguimiento
			;
		$objRes = $aptBd->execute( $sql );
		while( $objRes->fields){
			if( $objRes->fields['seqSeguimiento'] ){
				$arrSeqSeguimiento[] = 	$objRes->fields['seqSeguimiento'];
			}
			$objRes->MoveNext();
		}		
		$txtSeqSeguimiento = ( empty( $arrSeqSeguimiento ) )?"null":implode( ',', $arrSeqSeguimiento );
		$arrCondiciones[] = "seg.seqSeguimiento IN ($txtSeqSeguimiento)";
	}
	
	if( !empty( $arrSeqFormularios ) ){
		$arrCondiciones[] = "frm.seqFormulario IN ( ". implode( $arrSeqFormularios, " , " ) ." )";
	}
		
	$arrCondiciones[] = "hog.seqParentesco = 1";
	
	$txtCondicion = implode( " AND ", $arrCondiciones );
	
	$sql = "
		SELECT
			frm.seqFormulario,
			frm.txtFormulario ,                        
			tdo.txtTipoDocumento AS Tipo_Documento, 
			ciu.numDocumento AS Documento,
			CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 ) AS Nombre,                        
			par.txtParentesco AS Parentesco, 
			moa.txtModalidad, 
			UPPER( CONCAT( eta.txtEtapa , ' - ' , epr.txtEstadoProceso ) ) AS EstadoProceso,
            IF(epr.seqEstadoProceso <= 14 OR epr.seqEstadoProceso = 16 OR epr.seqEstadoProceso = 18 OR epr.seqEstadoProceso = 21,'',frm.fchVigencia) AS Vigencia_SDV,                        
			ban.txtBanco AS BancoCredito, 
			seg.fchMovimiento AS Fecha,
			upper( CONCAT( usu.txtNombre , ' ' , usu.txtApellido ) ) AS Tutor,
			concat( usu1.txtNombre ,  ' ' , usu1.txtApellido ) AS tutorAsignado ,
			des.numDocumentoVendedor AS DocumentoVendedor,
			des.txtNombreVendedor AS NombreVendedor,
			gge.txtGrupoGestion as GrupoGestion,
			ges.txtGestion AS Gestion,
			seg.txtComentario AS Comentario,
			seg.numDocumento AS Documento_Atendido,
			seg.txtNombre AS Ciudadano_Atendido
		FROM
			T_FRM_FORMULARIO frm
		INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
		INNER JOIN T_FRM_MODALIDAD moa ON moa.seqModalidad = frm.seqModalidad
		INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
		INNER JOIN T_CIU_PARENTESCO par ON hog.seqParentesco = par.seqParentesco 
		INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
		INNER JOIN T_FRM_BANCO ban ON frm.seqBancoCredito = ban.seqBanco
		INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
		INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON ciu.seqTipoDocumento = tdo.seqTipoDocumento
		INNER JOIN T_SEG_SEGUIMIENTO seg ON seg.seqFormulario = frm.seqFormulario
		INNER JOIN T_SEG_GESTION ges ON seg.seqGestion = ges.seqGestion
		INNER JOIN T_SEG_GRUPO_GESTION gge ON ges.seqGrupoGestion = gge.seqGrupoGestion
		INNER JOIN T_COR_USUARIO usu ON seg.seqUsuario = usu.seqUsuario
		LEFT JOIN T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario
		LEFT JOIN T_IND_FORMULARIO_USUARIOS_ASIGNADOS fus ON fus.seqFormulario = frm.seqFormulario
		LEFT JOIN T_COR_USUARIO usu1 ON fus.seqUsuario = usu1.seqUsuario
		WHERE $txtCondicion
	";
	//echo $sql;die();
	$objRes = $aptBd->execute( $sql );
	$txtNombreArchivo = $nombreArchivo . date( "Ymd_His" ) . ".xls";
	
	$claReportes = new Reportes;
	$claReportes->obtenerReportesGeneral( $objRes, $txtNombreArchivo );
	
?>
