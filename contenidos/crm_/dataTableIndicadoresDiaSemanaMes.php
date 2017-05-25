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
	
	$txtTipoReporte 	= $_POST[ 'txtTipoReporte' ];
	$txtEstado 			= $_POST[ 'txtEstado' ];
	$claCRM 			= new CRM;
	$claCRM->seqUsuario = $_POST[ 'seqUsuario' ];
	
	$claCRM->reporteIndicadoresDiaSemanaMes( $txtTipoReporte, $txtEstado );
	
	$claSmarty->assign( "claCrm" , $claCRM );	
	$claSmarty->display( "crm/indicadorTutorDesembolso/dataTableIndicadores.tpl" );

?>