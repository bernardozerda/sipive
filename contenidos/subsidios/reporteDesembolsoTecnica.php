<?php

	/**
	 * REPORTE DE DESEMBOLSO TECNICO
	 * @author Diego Gaitan
	 * @version 1.0 Julio 2010
	 */
	
	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );	
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']  . "Reportes.class.php" );
	
	$fechaIni 			= $_POST['fchInicio'];
	$fechaFin 			= $_POST['fchFin'];
	$gestion 			= $_POST['seqGestion'];
	$seqGrupoGestion 	= $_POST['seqGrupo'];
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
	if( $seqGrupoGestion ){
		$arrCondicionSeqSeguimiento[] = "gge.seqGrupoGestion = $seqGrupoGestion";
	}
	
	if( !empty($arrCondicionSeqSeguimiento) ){
		$txtCondicionSeqGeguimiento = implode( " and ", $arrCondicionSeqSeguimiento );
		$sql = "select 
				distinct seg.seqFormulario
				from T_SEG_SEGUIMIENTO seg ";
		if( $seqGrupoGestion ){
			$sql .= "INNER JOIN T_SEG_GESTION ges ON seg.seqGestion = ges.seqGestion
					INNER JOIN T_SEG_GRUPO_GESTION gge ON ges.seqGrupoGestion = gge.seqGrupoGestion";
		}
		$sql .= " where $txtCondicionSeqGeguimiento";
				
		$objRes = $aptBd->execute( $sql );
		while( $objRes->fields){
			$arrSeqSeguimiento[] = 	$objRes->fields['seqFormulario'];
			$objRes->MoveNext();
		}		
		$txtSeqSeguimiento = ( empty( $arrSeqSeguimiento ) )?"null":implode( ',', $arrSeqSeguimiento );
		$arrCondiciones[] = "frm.seqFormulario in ($txtSeqSeguimiento)";
	}
	
	$arrCondiciones[] = "hog.seqParentesco = 1";
	
	$txtCondicion = implode( " and ", $arrCondiciones );
	
	$sql = "
		SELECT 
			des.txtChip AS Chip,
			des.txtDireccionInmueble AS DireccionSolucion,
			frm.txtBarrio AS Barrio,
			loc.txtLocalidad AS Localidad,
			upper(concat(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS NombreBeneficiario,
			ciu.numDocumento AS DocumentoBeneficiario,
			des.txtNombreVendedor AS NombreVendedor,
			des.numDocumentoVendedor AS DocumentoVendedor,
			frm.numTelefono1 AS Telefono1,
			frm.numTelefono2 AS Telefono2,
			frm.numCelular AS Celular,
			(
				SELECT 
				seg.txtComentario
				FROM T_SEG_SEGUIMIENTO seg
				WHERE seg.seqFormulario = frm.seqFormulario
				ORDER BY seg.fchMovimiento DESC
				LIMIT 1
			) AS UltimoSeguimiento
		FROM T_FRM_FORMULARIO frm
		INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
		INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
		INNER JOIN T_FRM_LOCALIDAD loc ON frm.seqLocalidad = loc.seqLocalidad
		LEFT JOIN T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario
		where $txtCondicion ";
	
	$objRes = $aptBd->execute( $sql );
	$nombreArchivo = "ReporteTecnico";
	$txtNombreArchivo = $nombreArchivo . date( "Ymd_His" ) . ".xls";
	
	$claReportes = new Reportes;
	$claReportes->obtenerReportesGeneral( $objRes, $txtNombreArchivo );
	
	
?>
