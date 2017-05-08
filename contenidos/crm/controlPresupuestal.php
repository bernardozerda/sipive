<?php


	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );
    
    include( "./datosComunes.php" );
    
    $claCrm = new CRM;
    $claCrm->obtenerNomina( );
    $claCrm->obtenerConcepto( );

	$claSmarty->assign( "claCrm" 	, $claCrm );  
	$claSmarty->assign( "arrMeses" 	, $arrMeses );
	$claSmarty->assign( "arrAnnos" 	, $arrAnnos );
	$claSmarty->assign( "numMes" 	, date( "m" ) );
	$claSmarty->assign( "numAnno" 	, date( "Y" ) );    
    $claSmarty->display( "crm/controlPresupuestal.tpl" );

?>
