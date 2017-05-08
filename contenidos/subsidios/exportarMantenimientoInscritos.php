<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    
    header("Content-disposition: attachment; filename=" . time() . ".csv");
	header("Content-Type: application/force-download");
	header("Content-Type: application/vnd.ms-excel; charset=utf-8;");
	header("Content-Transfer-Encoding: binary");
	header("Pragma: no-cache");
	header("Expires: 1"); 
	
	$txtArchivo = "";
	
	$sql = "
		SELECT
			frm.seqFormulario as Formulario,
			moa.txtModalidad as Modalidad,
			sol.txtSolucion as Solucion,
			ciu.numDocumento as Documento,
			UPPER( CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 ) )  as Nombre,
			frm.valTotalRecursos as Recursos,
			CONCAT( eta.txtEtapa , ' - ' , epr.txtEstadoProceso ) as Estado
		FROM T_FRM_FORMULARIO frm
		INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
		INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
		INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
		INNER JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
		INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
		INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
		WHERE frm.fchUltimaActualizacion >= '" . $_POST['fchHoy'] . "'
		AND eta.seqEtapa = 1
		AND epr.seqEstadoProceso <> 1
		AND hog.seqParentesco = 1
	";	
    $objRes = $aptBd->execute( $sql );
    while( $objRes->fields ){
    	if( $txtArchivo == "" ){
    		$txtArchivo .= utf8_decode( implode( "\t" , array_keys( $objRes->fields ) ) . "\r\n" );
    	}
    	$txtArchivo .= utf8_decode( implode( "\t" , $objRes->fields ) . "\r\n" );
    	$objRes->MoveNext();
    }
    
    echo $txtArchivo;
    
?>