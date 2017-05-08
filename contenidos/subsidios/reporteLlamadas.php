<?php

	/**
	 * REPORTE DE HOGARES PARA LLAMAR
	 * @author Bernardo Zerda
	 * @version 1.0 Agosto 2009
	 */
	
	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );	
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']  . "Reportes.class.php" );

	// Nombre del archivo exportable
	$txtNombreArchivo = "reporteLlamadas_" . date( "Ymd_His" ) . ".xls"; 

	$sql = "
		SELECT	
			pat.txtPuntoAtencion as PuntoAtencion,
			frm.seqFormulario as IdFormulario,
			frm.fchInscripcion as FechaInscripcion,
			moa.txtModalidad as Modalidad,
			ciu.numDocumento as Documento,
			upper( CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 )) as Nombre,
			frm.numTelefono1 as Telefono1,
			frm.numTelefono2 as Telefono2,
			frm.numCelular as Celular,
      		upper( frm.txtDireccion ) as Direccion,
			frm.valIngresoHogar as IngresoHogar,
			( frm.valSaldoCuentaAhorro + frm.valSaldoCuentaAhorro2 + frm.valSaldoCuentaAhorro2 + frm.valCredito ) as RecursosHogar,
			bcr.txtBanco as BancoCredito,
			frm.valCredito as ValorCredito,
			ba1.txtBanco as BancoAhorro1,
			frm.valSaldoCuentaAhorro as ValorAhorro1,
			ba2.txtBanco as BancoAhorro2,
			frm.valSaldoCuentaAhorro2 as ValorAhorro2,
			edo.txtEmpresaDonante as EmpresaDonante,
			frm.valDonacion as ValorDonacion,
      		concat( usu.txtUsuario , ' ' , usu.txtApellido ) as txtUsuario
		from 
			T_FRM_FORMULARIO frm,
			T_FRM_HOGAR hog, 
			T_CIU_CIUDADANO ciu,
			T_FRM_BANCO ba1,
			T_FRM_BANCO ba2,
			T_FRM_BANCO bcr,
			T_FRM_EMPRESA_DONANTE edo,
			T_FRM_PUNTO_ATENCION pat,
			T_FRM_MODALIDAD moa,
      		T_COR_USUARIO usu
		where hog.seqFormulario = frm.seqFormulario
			and hog.seqCiudadano = ciu.seqCiudadano
			and ba1.seqBanco = frm.seqBancoCuentaAhorro
			and ba2.seqBanco = frm.seqBancoCuentaAhorro2
			and bcr.seqBanco = frm.seqBancoCredito
			and frm.seqEmpresaDonante = edo.seqEmpresaDonante
			and frm.seqPuntoAtencion = pat.seqPuntoAtencion
			and frm.seqModalidad = moa.seqModalidad
     		and frm.seqUsuario = usu.seqUsuario
			and hog.seqParentesco = 1
			and frm.fchInscripcion >= '" . $_POST['fchInicio'] . " 00:00:00'
			and frm.fchInscripcion <= '" . $_POST['fchFin']   . " 23:59:59'
                            and frm.seqPlanGobierno = 3
	";

	// and frm.seqEstadoProceso in (1, 36) // No necesariamente están actualmente en estado Inscrito
	
	try {
		
		if( $_POST['fchInicio'] == "" ){
			$arrErrores[] = "Fecha Inicial Inválida";
		}
		if( $_POST['fchFin'] == "" ){
			$arrErrores[] = "Fecha Final Inválida";
		}
		
		if( empty( $arrErrores ) ){
			$objRes = $aptBd->execute( $sql );
			
			$claReportes = new Reportes;
			$claReportes->obtenerReportesGeneral( $objRes, $txtNombreArchivo );
			
		}else{
			throw new Exception( implode( "\r\n" , $arrErrores ) );
		}
		
	} catch ( Exception $objError ){ 
		echo "Hubo un error en la consulta y el reporte no se puede obtener, las sigueintes son las causas:\r\n";
		echo $objError->getMessage()."\r\n";
	} 
	
	
?>
