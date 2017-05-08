<?php

	/**
	 * MENU PARA REALIZAR LA GESTION 
	 * DE LOS DATOS QUE VIENEN DEL 
	 * BANCO. SON LAS CONSIGNACIONES
	 * DE LOS BENEFICIARIOS DE SCA
	 * EN LA CUENTA DE AHORRO PROGRAMADO
	 * @author Bernardo Zerda
	 * @version 1.0 Enero 2011
	 */

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

    // Para los meses locales
    setlocale(LC_TIME, 'spanish');
    
    $arrMeses = array();
    for( $i = -1 ; $i <= 6 ; $i++ ){
    	$arrMeses[ date( "Y-m-01" , strtotime( "$i months" ) ) ] = utf8_encode( ucwords( strftime("%B del %Y" , strtotime( "$i months" ) ) ) );
    }
    
    $claSmarty->assign( "arrMeses" , $arrMeses );
    $claSmarty->display( "desembolso/consignacionesCAP.tpl" );
    
?>