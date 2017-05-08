<?php

	/**
	 * DESEMBOLSO 2 
	 */

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    
	$claSmarty->assign( "txtFuncion" , "buscarCedula('desembolso/desembolso')" ); 
	$claSmarty->display( "subsidios/buscarCedula.tpl" );    

?>
