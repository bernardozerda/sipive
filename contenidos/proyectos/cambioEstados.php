<?php
	
	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Grupo.class.php" );
	
	//include( "../desembolso/datosComunes.php" );
	
	// Estados del proceso
	$sql = "
		SELECT
			epr.seqEstadoProceso,
			CONCAT(eta.txtEtapa, ' - ' , epr.txtEstadoProceso) as txtEstadoProceso
		FROM 
			T_FRM_ETAPA eta,
			T_FRM_ESTADO_PROCESO epr
		WHERE
			epr.seqEtapa = eta.seqEtapa
		AND
			epr.seqEstadoProceso NOT IN (1, 10, 11, 12, 13)
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrEstados[ $objRes->fields['seqEstadoProceso'] ] = $objRes->fields['txtEstadoProceso'];
		$objRes->MoveNext();
	}
	
	// Tipos de Documentos
	$sql = "SELECT
				seqTipoDocumento, txtTipoDocumento
			FROM
				T_CIU_TIPO_DOCUMENTO
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrTipoDocumentos[ $objRes->fields['seqTipoDocumento'] ] = $objRes->fields['txtTipoDocumento']; 
		$objRes->MoveNext();
	}
	
	$claSmarty->assign( "arrEstados" , $arrEstados );
	$claSmarty->assign( "arrTipoDocumentos" , $arrTipoDocumentos );
	$claSmarty->display( "subsidios/cambioEstados.tpl" );

?>
