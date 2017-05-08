<?php

	/**
 	 * EXPORTA A UN ARCHIVO LA TABLA DE UN 
 	 * PASO SELECCIONADO EN EL PROCESO DE SELECCION
 	 * DE HOGARES PARA EL SUBSIDIO DE ARRENDAMIENTO
 	 * @author Bernardo Zerda
 	 * @version 1.0 9/09/2010 
	 **/

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    
	$_POST['paso'] -= 1;
	
	$txtNombreArchivo = "";
	switch( $_POST['paso'] ){
		case 1: $txtNombreArchivo = "PreSeleccion" . date( "Ymd_His" ) . ".xls"; break;
		case 2: $txtNombreArchivo = "Tickets" . date( "Ymd_His" ) . ".xls";      break;
		case 3: $txtNombreArchivo = "Sorteo" . date( "Ymd_His" ) . ".xls";       break;
		case 4: $txtNombreArchivo = "Seleccion" . date( "Ymd_His" ) . ".xls";    break;
	}
	
	if( $_POST['paso'] == 1 or $_POST['paso'] == 2 or $_POST['paso'] == 4 ){
		
		$txtCampo         = ( $_POST['paso'] == 1 )? "'' as Ticket" : "frm.seqFormulario as Ticket" ;
		$txtCondicion     = ( $_POST['paso'] == 4 )? "AND frm.seqFormulario IN ( " . implode( "," , $_POST['tickets'] ) . " )" : "" ;
		$seqModalidad     = ( $_POST['paso'] == 4 )? 5  : 1 ;
		$seqEstadoProceso = ( $_POST['paso'] == 4 )? 10 : 1 ;
		
		// Hogares que se pueden postular para el subsidio de arrendamiento
	    $sql = "
			SELECT 
				$txtCampo,
				(
					SELECT tdo.txtTipoDocumento
					FROM T_CIU_TIPO_DOCUMENTO tdo
					WHERE tdo.seqTipoDocumento = ciu.seqTipoDocumento
				) as TipoDocumento,
				ciu.numDocumento as Documento,
				UPPER( CONCAT( ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2 ) ) as Nombre,
				frm.fchInscripcion as FechaInscripcion,
				moa.txtModalidad as Modalidad,
				sol.txtDescripcion as Solucion,
				cco.txtCajaCompensacion as CajaCompensacion,
				ba1.txtBanco as BancoAhorro1,
				frm.valSaldoCuentaAhorro as ValorAhorro1,
				ba2.txtBanco as BancoAhorro2,
				frm.valSaldoCuentaAhorro2 as ValorAhorro2,
				frm.valIngresoHogar as IngresoHogar
			FROM T_FRM_FORMULARIO frm
				INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
				INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
				INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
				INNER JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
				INNER JOIN T_CIU_CAJA_COMPENSACION cco ON ciu.seqCajaCompensacion = cco.seqCajaCompensacion
				INNER JOIN T_FRM_BANCO ba1 ON frm.seqBancoCuentaAhorro = ba1.seqBanco
				INNER JOIN T_FRM_BANCO ba2 ON frm.seqBancoCuentaAhorro2 = ba2.seqBanco
			WHERE frm.seqModalidad = $seqModalidad
				AND frm.seqEstadoProceso = $seqEstadoProceso
				AND frm.valIngresoHogar < " . ( $arrConfiguracion['constantes']['salarioMinimo'] * 2 ) . "
				AND frm.valSaldoCuentaAhorro = 0
				AND frm.valSaldoCuentaAhorro2 = 0
				AND ciu.seqCajaCompensacion = 1
				AND frm.fchInscripcion <= '2010-06-30'
				$txtCondicion
		";
		
    	$objRes = $aptBd->execute( $sql );
		$txtArchivo = implode( "\t" , array_keys( $objRes->fields ) ) . "\r\n";
    	while( $objRes->fields ){
    		foreach( $objRes->fields as $txtClave => $txtValor ){
    			$objRes->fields[ $txtClave ] =  utf8_decode( $txtValor );
    		}
    		$txtArchivo .= implode( "\t" , $objRes->fields ) . "\r\n";
    		$objRes->MoveNext();
    	}
		
	}
	
	if( $_POST['paso'] == 3 ){
		$txtArchivo = "Tickets\r\n";
		foreach( $_POST['tickets'] as $numTicket ){
			$txtArchivo .= $numTicket . "\r\n";
		}
	}
	
	header("Content-disposition: attachment; filename=$txtNombreArchivo");
	header("Content-Type: application/force-download");
	header("Content-Transfer-Encoding: binary");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	echo $txtArchivo;
		
?>
