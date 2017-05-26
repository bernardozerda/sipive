<?php

	$txtPrefijoRuta = "../../";

	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos.class.php" );
	
	
	$claCrm = new CRM;
	$claActos = new ActoAdministrativo;
	$claCrm->obtenerTutores( );
	$claCrm->obtenerCoordinadores( );
	$claCrm->crearCRMCoordinador( );
	
	$claSmarty->assign( "claCrm", $claCrm );
	$claSmarty->display( "crm/asignacionFormularios.tpl" );
    
?>