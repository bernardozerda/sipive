<?php
	
	/**
     * CONSULTA PARA SABER QUIENES TIENEN
     * CONSIGNACIONES SIN SOLICITUDES HECHAS
     * Y SOLICITUDES SIN CONSIGNACION
	 * @author Bernardo Zerda
	 * @version 1.0 Enero 2011
	 */

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Desembolso.class.php" );
    
    /**
     * SOLICITUDES SIN CONSIGNACIONES
     * 		El hogar no consigno en el mes, sancionar
     */
    
    try {
	    $sql = "
			SELECT 
				con.seqConsignacion,
				frm.seqFormulario,
				ciu.numDocumento as Documento,
				UPPER( CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 ) ) as Nombre,
				sol.numDocumentoBeneficiarioGiro as DocumentoGiro,
				sol.txtNombreBeneficiarioGiro as NombreGiro,
				sol.txtTipoCuentaGiro as TipoCuentaGiro,
				sol.numCuentaGiro as CuentaGiro,
				ban.txtBanco as Banco,
				'' as NumeroPago,
				frm.valAspiraSubsidio as ValorSubsidio,
				sol.valSolicitado as ValorSolicitado
			FROM T_DES_DESEMBOLSO des
			INNER JOIN T_DES_SOLICITUD sol ON sol.seqDesembolso = des.seqDesembolso
			LEFT JOIN T_DES_CONSIGNACIONES con ON des.seqFormulario = con.seqFormulario
			INNER JOIN T_FRM_FORMULARIO frm ON des.seqFormulario = frm.seqFormulario
			INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
			INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
			INNER JOIN T_FRM_BANCO ban ON sol.seqBancoGiro = ban.seqBanco
			WHERE sol.fchCreacion >= '" . $_POST['fchMes'] . " 00:00:00'
			AND sol.fchCreacion <= '" . date( "Y-m-t" , strtotime( $_POST['fchMes'] ) ) . " 23:59:59'
			AND frm.seqModalidad = 5
			AND hog.seqParentesco = 1
	    "; 
	    $arrFormatoPago = array();
    	$objRes = $aptBd->execute( $sql );
    	while( $objRes->fields ){
    		$seqConsignacion = $objRes->fields['seqConsignacion'];
    		$seqFormulario =  $objRes->fields['seqFormulario'];
    		unset( $objRes->fields['seqConsignacion'] );
    		unset( $objRes->fields['seqFormulario'] );  
    		if( ! is_null( $seqConsignacion ) ){
    			$claDesembolso = new Desembolso();
    			$claDesembolso->cargarDesembolso($seqFormulario);
    			$objRes->fields['NumeroPago'] = count( $claDesembolso->arrSolicitud['resumen']['fechas'] );
    			$objRes->fields['Nombre'] = utf8_encode( $objRes->fields['Nombre'] );
    			$arrFormatoPago[] = $objRes->fields;
    			unset( $claDesembolso );
    		}
    		$objRes->MoveNext();
    	}
    } catch ( Exception $objError ){
    	$arrErrores[] = "No se han podido consultar los datos de las consignaciones vs solicitudes";
    }

    if( empty( $arrErrores ) ){
		
    	setlocale(LC_TIME, 'spanish');
    	
		header("Content-disposition: attachment; filename=Eventos" . $_POST['fchMes'] . ".xls" );
		header("Content-Type: application/force-download");
		header("Content-Type: application/vnd.ms-excel; charset=ISO-8859-1;");
		header("Content-Transfer-Encoding: binary");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$txtFecha = utf8_encode( ucwords( strftime("%A %#d de %B del %Y") ) );
		
		$claSmarty->assign( "txtFecha" , $txtFecha );
		$claSmarty->assign( "arrFormatoPago" , $arrFormatoPago );
		$claSmarty->display( "desembolso/formatoPago.tpl" );
		
    }else{
    	imprimirMensajes( $arrErrores, array() );
    }

?>











