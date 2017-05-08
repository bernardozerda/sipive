<?php

	$txtPrefijoRuta = "../../";

	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );
	include( "./datosComunes.php" );
	
	$txtTipoReporte = $_GET[ 'txtTipoReporte' ];
	$txtColor 		= $_GET[ 'txtColor' ];
	$seqUsuario 	= $_POST[ 'seqUsuario' ];
	
	$claCRM = new CRM;
	$claCRM->reporteIndicadores( $seqUsuario, $txtTipoReporte, $txtColor , array( ) , $txtConsultaReporte );
	$txtConsultaReporte = $_GET[ 'txtConsultaReporte' ];
	
	
	switch ( $txtConsultaReporte ){
			
		case "reporte":
			Reportes::obtenerReportesGeneral( $claCRM->arrTablaConsulta , $txtTipoReporte );
			break;
		
		case "consulta":
		default:
			$claSmarty->assign( "claCrm" , $claCRM );	
			$claSmarty->display( "crm/indicadorTutorDesembolso/dataTableIndicadores.tpl" );
			break;
	}
	
?>