<?php

	$txtPrefijoRuta = "../../";

	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );
	
	$claCrm = new CRM;
	$txtEstado = $_POST[ "txtEstado" ];
	$claCrm->seqUsuario = $_POST[ "seqUsuario" ];
	
	$claCrm->obtenerHogaresPorEstadoTutorDesembolso( $txtEstado );
	
	$claSmarty->assign( "txtEstado" , $txtEstado );
	$claSmarty->assign( "claCrm" 	, $claCrm );	
	$claSmarty->display( "crm/indicadorTutorDesembolso/rangoEstados.tpl" );

?>
