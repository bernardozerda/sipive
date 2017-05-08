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
			SELECT	frm.txtFormulario ,
				(
					  select
						tdo.txtTipoDocumento
					  from T_CIU_TIPO_DOCUMENTO tdo
					  where ciu.seqTipoDocumento = tdo.seqTipoDocumento
				) as Tipo_Documento,
				seg.fchMovimiento as Fecha,
				ciu.numDocumento as Documento,
				CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 ) as Nombre, upper( CONCAT( usu.txtNombre , ' ' , usu.txtApellido ) ) as Tutor,
				des.numDocumentoVendedor as DocumentoVendedor,
				des.txtNombreVendedor as NombreVendedor,
				des.txtChip AS Chip,
				des.txtDireccionInmueble AS DireccionSolucion,
				des.txtBarrio AS Barrio,
				loc1.txtLocalidad AS Localidad,
				gge.txtGrupoGestion as GrupoGestion,
				ges.txtGestion as Gestion,
				seg.txtComentario as Comentario
                FROM
                        T_FRM_FORMULARIO frm
                INNER JOIN T_FRM_HOGAR hog on hog.seqFormulario = frm.seqFormulario
                INNER JOIN T_CIU_CIUDADANO ciu on hog.seqCiudadano = ciu.seqCiudadano
                inner join T_FRM_LOCALIDAD loc ON frm.seqLocalidad = loc.seqLocalidad
                INNER JOIN T_SEG_SEGUIMIENTO seg on seg.seqFormulario = frm.seqFormulario
                INNER JOIN T_SEG_GESTION ges on seg.seqGestion = ges.seqGestion
                INNER JOIN T_SEG_GRUPO_GESTION gge on ges.seqGrupoGestion = gge.seqGrupoGestion
                INNER JOIN T_COR_USUARIO usu on seg.seqUsuario = usu.seqUsuario
                LEFT JOIN T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario
                LEFT JOIN T_IND_FORMULARIO_USUARIOS_ASIGNADOS fus on fus.seqFormulario = frm.seqFormulario
                LEFT JOIN T_COR_USUARIO usu1 on fus.seqUsuario = usu1.seqUsuario
				        inner join T_FRM_LOCALIDAD loc1 ON des.seqLocalidad = loc1.seqLocalidad
				where $txtCondicion ";
	$objRes = $aptBd->execute( $sql );
	$nombreArchivo = "ReporteConstanciaVisita";
	$txtNombreArchivo = $nombreArchivo . date( "Ymd_His" ) . ".xls";
	
	$claReportes = new Reportes;
	$claReportes->obtenerReportesGeneral( $objRes, $txtNombreArchivo );
	
	
?>
