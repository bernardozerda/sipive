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
    
    /**
     * SOLICITUDES SIN CONSIGNACIONES
     * 		El hogar no consigno en el mes, sancionar
     */
    
    try {
	    $sql = "
			SELECT 
				con.seqConsignacion,
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
	    $arrSolicitudesSinConsignacion = array();
    	$objRes = $aptBd->execute( $sql );
    	while( $objRes->fields ){
    		$seqConsignacion = $objRes->fields['seqConsignacion'];
    		unset( $objRes->fields['seqConsignacion'] ); 
    		if( is_null( $seqConsignacion ) ){
    			$arrSolicitudesSinConsignacion[] = $objRes->fields;
    		} else {
    			$arrFormatoPago[] = $objRes->fields;
    		}
    		$objRes->MoveNext();
    	}
    } catch ( Exception $objError ){
    	$arrErrores[] = "No se han podido consultar los datos de las consignaciones vs solicitudes";
    }

    /**
     * CONSIGNACIONES SIN SOLICITUD
     * 		Se deben crear las solicitudes
     */
    
    try {
    	$sql = " 
			SELECT
				ciu.numDocumento as Documento,
				UPPER( CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 ) ) as Nombre
			FROM T_FRM_FORMULARIO frm
			INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
			INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
			INNER JOIN T_DES_CONSIGNACIONES con on con.seqFormulario = frm.seqFormulario
			WHERE seqModalidad = 5
			AND con.fchConsignacion >= '" . $_POST['fchMes'] . " 00:00:00'
			AND con.fchConsignacion <= '" . date( "Y-m-t" , strtotime( $_POST['fchMes'] ) ) . " 23:59:59'
			AND hog.seqParentesco = 1
			AND (
			  SELECT count(sol.seqSolicitud)
			  FROM T_DES_DESEMBOLSO des
			  INNER JOIN T_DES_SOLICITUD sol ON sol.seqDesembolso = des.seqDesembolso
			  WHERE des.seqFormulario = frm.seqFormulario
			  AND sol.fchCreacion >= '" . $_POST['fchMes'] . " 00:00:00'
			  AND sol.fchCreacion <= '" . date( "Y-m-t" , strtotime( $_POST['fchMes'] ) ) . " 23:59:59'
			) = 0
    	"; 
    	$arrConsignacionesSinSolicitud = array();
    	$objRes = $aptBd->execute( $sql );
    	while( $objRes->fields ){
    		$arrConsignacionesSinSolicitud[] = $objRes->fields;
    		$objRes->MoveNext();
    	}
    } catch ( Exception $objError ){
    	$arrErrores[] = "No se ha podido consultar la informacion de consignaciones sin solicitud";
    }
    
    if( empty( $arrErrores ) ){

		$txtArchivo = "<table>";
		$txtArchivo.= "<tr><td colspan='3' bgcolor='#000000' style='color:white'>Hogares que tienen consignaciones pero que no tienen solicitudes</td></tr>";
		foreach( $arrConsignacionesSinSolicitud as $arrDatos ){
			$txtArchivo.= "<tr><td>" . $arrDatos['Documento'] . "</td><td>" . $arrDatos['Nombre'] . "</td></tr>";
		}
		$txtArchivo.= "<tr><td colspan='3' bgcolor='#000000' style='color:white'>Hogares que tienen solicitudes pero que no tienen consignaciones</td></tr>";
		foreach( $arrSolicitudesSinConsignacion as $arrDatos ){
			$txtArchivo.= "<tr><td>" . $arrDatos['Documento'] . "</td><td>" . $arrDatos['Nombre'] . "</td></tr>";	
		}
		$txtArchivo.= "</table>";    	
    	
		header("Content-disposition: attachment; filename=Eventos" . $_POST['fchMes'] . ".xls" );
		header("Content-Type: application/force-download");
		header("Content-Type: application/vnd.ms-excel; charset=ISO-8859-1;");
		header("Content-Transfer-Encoding: binary");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		echo $txtArchivo;    	
    	
    }else{
    	imprimirMensajes( $arrErrores, array() );
    }

?>