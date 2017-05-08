<?php

	/**
	 * REPORTE DE CIERRE
	 * @author Jaison Ospina
	 * @version 1.0 Enero 2015
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
		  tdo.txtTipoDocumento AS 'Tipo de Documento',
		  ciu.numDocumento AS 'Documento',
		  UPPER(CONCAT(ciu.txtNombre1,' ',ciu.txtNombre2,' ',ciu.txtApellido1,' ',ciu.txtApellido2)) AS 'Nombre',
		  UPPER(frm.txtFormulario) AS 'Numero Formulario',
		  CONCAT(eta.txtEtapa,' - ',epr.txtEstadoProceso) AS 'Estado del Proceso',
		  eta.txtEtapa AS 'Etapa',
		  if(frm.bolDesplazado = 1,'Víctima','Vulnerable') AS 'Hogar Victima',
		  frm.valAspiraSubsidio AS 'Valor Subsidio',
		  UPPER(frm.txtSoporteSubsidio) AS 'Soporte Cambio Valor Subsidio',
		  if(frm.bolCerrado = 1,'SI','NO') AS 'Formulario Cerrado',
		  if(frm.seqPlanGobierno = 1,'Bogotá Positiva','Bogotá Humana') AS 'Plan de Gobierno',
		  esq.txtTipoEsquema AS 'Tipo de Esquema',
		  moa.txtModalidad AS 'Modalidad',
		  sol.txtSolucion AS 'Solucion de Vivienda',
		  pro.txtNombreProyecto AS 'Proyecto',
		  prh.txtNombreProyecto AS 'Conjunto Residencial',
		  UPPER(frm.txtDireccionSolucion) AS 'Direcion de la Solucion',
		  und.txtNombreUnidad AS 'Unidad Proyecto',
		  UPPER(frm.txtMatriculaInmobiliaria) AS 'Matricula Inmobiliaria',
		  UPPER(frm.txtChip) AS 'CHIP',
		  if(frm.bolPromesaFirmada = 1,'SI','NO') AS 'Promesa Firmada',
		  frm.valIngresoHogar AS 'Ingresos del Hogar',
		  frm.valSaldoCuentaAhorro AS 'Saldo Cuenta Ahorro 1',
		  ba1.txtBanco AS 'Banco Cuenta Ahorro 1',
		  UPPER(frm.txtSoporteCuentaAhorro) AS 'Soporte Cuenta Ahorro 1',
		  if(frm.bolInmovilizadoCuentaAhorro = 1,'SI','NO') AS 'Cuenta Ahorro 1 Inmobilizada',
		  DATE_FORMAT(frm.fchAperturaCuentaAhorro,'%d-%m-%Y') AS 'Fecha Apertura Cuenta Ahorro 1',
		  frm.valSaldoCuentaAhorro2 AS 'Saldo Cuenta Ahorro 2',
		  ba2.txtBanco AS 'Banco Cuenta Ahorro 2',
		  UPPER(frm.txtSoporteCuentaAhorro2) AS 'Soporte Cuenta Ahorro 2',
		  if(frm.bolInmovilizadoCuentaAhorro2 = 1,'SI','NO') AS 'Cuenta Ahorro 2 Inmobilizada',
		  DATE_FORMAT(frm.fchAperturaCuentaAhorro2,'%d-%m-%Y') AS 'Fecha Apertura Cuenta Ahorro 2',
		  frm.valSubsidioNacional AS 'Valor Subsidio (AVC / FOVIS / SFV)',
		  UPPER(frm.txtSoporteSubsidioNacional) AS 'Soporte Subsidio (AVC / FOVIS / SFV)',
		  ccf.txtEntidadSubsidio AS 'Entidad Subsidio (AVC / FOVIS / SFV)',
		  frm.valAporteLote AS 'Valor Aporte Lote',
		  frm.valSaldoCesantias AS 'Valor Cesantias',
		  UPPER(frm.txtSoporteCesantias) AS 'Soporte Cesantias',
		  frm.valAporteAvanceObra AS 'Valor Aporte Avance Obra',
		  UPPER(frm.txtSoporteAvanceObra) AS 'Soporte Avance Obra',
		  frm.valCredito AS 'Valor Credito',
		  bcr.txtBanco AS 'Banco Credito',
		  UPPER(frm.txtSoporteCredito) AS 'Soporte Credito',
		  DATE_FORMAT(frm.fchAprobacionCredito,'%d-%m-%Y') AS 'Fecha Vencimiento del Credito',
		  frm.valAporteMateriales AS 'Valor Aporte Materiales',
		  UPPER(frm.txtSoporteAporteMateriales) AS 'Soporte Aporte Materiales',
		  frm.valDonacion AS 'Valor Donacion / V.U.R.',
		  edo.txtEmpresaDonante AS 'Empresa Donante / V.U.R.',
		  UPPER(frm.txtSoporteDonacion) AS 'Soporte Donacion / V.U.R.',
		  frm.valTotalRecursos AS 'Total Recursos Hogar',
		  frm.valAvaluo AS 'Avaluo',
		  par.txtParentesco AS 'Parentesco',
		  DATE_FORMAT(frm.fchVigencia,'%d-%m-%Y') AS 'Vigencia SDV'
		FROM T_FRM_FORMULARIO frm
		INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
		INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
		INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON ciu.seqTipoDocumento = tdo.seqTipoDocumento
		INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
		INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
		INNER JOIN T_CIU_PARENTESCO par ON hog.seqParentesco = par.seqParentesco
		INNER JOIN T_PRY_TIPO_ESQUEMA esq ON frm.seqTipoEsquema = esq.seqTipoEsquema
		INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
		INNER JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
		LEFT JOIN T_PRY_PROYECTO pro ON frm.seqProyecto = pro.seqProyecto
		LEFT JOIN T_PRY_PROYECTO prh ON frm.seqProyectoHijo = prh.seqProyecto
		LEFT JOIN T_PRY_UNIDAD_PROYECTO und ON frm.seqUnidadProyecto = und.seqUnidadProyecto
		INNER JOIN T_FRM_BANCO ba1 ON frm.seqBancoCuentaAhorro = ba1.seqBanco
		INNER JOIN T_FRM_BANCO ba2 ON frm.seqBancoCuentaAhorro2 = ba2.seqBanco
		INNER JOIN T_FRM_ENTIDAD_SUBSIDIO ccf ON frm.seqEntidadSubsidio = ccf.seqEntidadSubsidio
		INNER JOIN T_FRM_BANCO bcr ON frm.seqBancoCredito = bcr.seqBanco
		INNER JOIN T_FRM_EMPRESA_DONANTE edo ON frm.seqEmpresaDonante = edo.seqEmpresaDonante
		WHERE $txtCondicion
	";
	//echo $sql;die();
	$objRes = $aptBd->execute( $sql );
	//$txtNombreArchivo = $nombreArchivo . date( "Ymd_His" ) . ".xls";
	$txtNombreArchivo = "ReporteCierre" . date( "Ymd_His" ) . ".xls";
	
	$claReportes = new Reportes;
	$claReportes->obtenerReportesGeneral( $objRes, $txtNombreArchivo );
	
?>
