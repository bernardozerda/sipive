<?php

	/**
	 * REPORTE DE CIERRE
	 * @author Jaison Ospina
	 * @version 1.0 Abril 2015
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
    
	/*$fechaIni 			= $_POST['fchInicio'];
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
	}*/
	
	if( !empty( $arrSeqFormularios ) ){
		$arrCondiciones[] = "frm.seqFormulario in ( ". implode( $arrSeqFormularios, " , " ) ." )";
	}
		
	$arrCondiciones[] = "hog.seqParentesco = 1";
	
	$txtCondicion = implode( " and ", $arrCondiciones );
	
	$sql = "
		SELECT
		  frm.seqFormulario,
		  tdo.txtTipoDocumento AS 'Tipo Documento Ppal',
		  ciu.numDocumento AS 'Documento Ppal',
		  UPPER(CONCAT(ciu.txtNombre1,' ',ciu.txtNombre2,' ',ciu.txtApellido1,' ',ciu.txtApellido2)) AS 'Nombre PPal',
		  UPPER(frm.txtFormulario) AS 'Formulario',
		  CONCAT(eta.txtEtapa,' - ',epr.txtEstadoProceso) AS 'Estado Proceso',
		  if(frm.bolDesplazado = 1,'Víctima','Vulnerable') AS 'Desplazado',
		  moa.txtModalidad AS 'Modalidad',
		  sol.txtSolucion AS 'Solucion de Vivienda',
		  if(frm.bolCerrado = 1,'SI','NO') AS 'Formulario Cerrado',
		  frm.valAspiraSubsidio AS 'Valor Subsidio',
		  UPPER(frm.txtSoporteSubsidio) AS 'Soporte Cambio Valor Subsidio',
		  frm.valIngresoHogar AS 'Valor Ingreso Hogar',
		  UPPER(frm.txtDireccion) AS 'Direccion Residencia',
		  UPPER(loc.txtLocalidad) AS 'Localidad',
		  UPPER(frm.txtDireccionSolucion) AS 'Direcion de la Solucion',
		  pro.txtNombreProyecto AS 'Proyecto SDVE',
		  UPPER(frm.txtMatriculaInmobiliaria) AS 'Matricula Inmobiliaria',
		  UPPER(frm.txtChip) AS 'CHIP'
		FROM T_FRM_FORMULARIO frm
		LEFT JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
		LEFT JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
		LEFT JOIN T_CIU_TIPO_DOCUMENTO tdo ON ciu.seqTipoDocumento = tdo.seqTipoDocumento
		LEFT JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
		LEFT JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
		LEFT JOIN T_FRM_LOCALIDAD loc ON frm.seqLocalidad = loc.seqLocalidad
		LEFT JOIN T_CIU_PARENTESCO par ON hog.seqParentesco = par.seqParentesco
		LEFT JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
		LEFT JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
		LEFT JOIN T_PRY_PROYECTO pro ON frm.seqProyecto = pro.seqProyecto
		WHERE $txtCondicion
	";
	//echo $sql;die();
	$objRes = $aptBd->execute( $sql );
	//$txtNombreArchivo = $nombreArchivo . date( "Ymd_His" ) . ".xls";
	$txtNombreArchivo = "ReporteCierreMejoramiento" . date( "Ymd_His" ) . ".xls";
	
	$claReportes = new Reportes;
	$claReportes->obtenerReportesGeneral( $objRes, $txtNombreArchivo );
	
?>
