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
	
	$gestion 			= 93;
	$seqGrupoGestion 	= 22;
	$arrSeqSeguimiento 	= array();
	$arrCondicionSeqSeguimiento = array();	
	
	if( $gestion ){
		$arrCondicionSeqSeguimiento[] = "seg.seqGestion = $gestion";
	}
	$arrCondicionSeqSeguimiento[] = "seg.bolMostrar = 1";
	
	if( !empty($arrCondicionSeqSeguimiento) ){
		if( !empty( $arrSeqFormularios ) ){
			$arrCondicionSeqSeguimiento[] = "seg.seqFormulario in ( ". implode( $arrSeqFormularios, "," ) ." )";
		}
		$txtCondicionSeqGeguimiento = implode( " and ", $arrCondicionSeqSeguimiento );
		$sql = "select 
				seg.seqSeguimiento
				from T_SEG_SEGUIMIENTO seg
				where ". $txtCondicionSeqGeguimiento
			;
		$objRes = $aptBd->execute( $sql );
		while( $objRes->fields){
			if( $objRes->fields['seqSeguimiento'] ){
				$arrSeqSeguimiento[] = 	$objRes->fields['seqSeguimiento'];
			}
			$objRes->MoveNext();
		}		
		$txtSeqSeguimiento = ( empty( $arrSeqSeguimiento ) )?"null":implode( ',', $arrSeqSeguimiento );
		$arrCondiciones[] = "seg.seqSeguimiento in ($txtSeqSeguimiento)";
	}
	
	if( !empty( $arrSeqFormularios ) ){
		$arrCondiciones[] = "frm.seqFormulario in ( ". implode( $arrSeqFormularios, " , " ) ." )";
	}
		
	$arrCondiciones[] = "hog.seqParentesco = 1";
	
	$txtCondicion = implode( " and ", $arrCondiciones );
	
	$sql = "
		SELECT
			frm.seqFormulario,
			frm.txtFormulario ,			
			ciu.numDocumento as Documento,
			CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 ) as Nombre,                        			
			seg.fchMovimiento as Fecha,
			upper( CONCAT( usu.txtNombre , ' ' , usu.txtApellido ) ) as Tutor
			
		FROM
			T_FRM_FORMULARIO frm
		INNER JOIN T_FRM_HOGAR hog on hog.seqFormulario = frm.seqFormulario
		INNER JOIN T_FRM_MODALIDAD moa on moa.seqModalidad = frm.seqModalidad
		INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
		INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
		INNER JOIN T_FRM_BANCO ban on frm.seqBancoCredito = ban.seqBanco
		INNER JOIN T_CIU_CIUDADANO ciu on hog.seqCiudadano = ciu.seqCiudadano
		INNER JOIN T_SEG_SEGUIMIENTO seg on seg.seqFormulario = frm.seqFormulario
		INNER JOIN T_SEG_GESTION ges on seg.seqGestion = ges.seqGestion
		INNER JOIN T_SEG_GRUPO_GESTION gge on ges.seqGrupoGestion = gge.seqGrupoGestion
		INNER JOIN T_COR_USUARIO usu on seg.seqUsuario = usu.seqUsuario
		LEFT JOIN T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario
		LEFT JOIN T_IND_FORMULARIO_USUARIOS_ASIGNADOS fus on fus.seqFormulario = frm.seqFormulario
		LEFT JOIN T_COR_USUARIO usu1 on fus.seqUsuario = usu1.seqUsuario
		WHERE $txtCondicion
		AND frm.txtFormulario <> ''
		GROUP BY frm.seqFormulario
	";
        //echo $sql;die();
	$objRes = $aptBd->execute( $sql );
	$txtNombreArchivo = $nombreArchivo . date( "Ymd_His" ) . ".xls";
	
	$claReportes = new Reportes;
	$claReportes->obtenerReportesGeneral( $objRes, $txtNombreArchivo );
	
?>
