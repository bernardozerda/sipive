<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );
    
    $claCrm = new CRM;
    $arrErrores = $claCrm->borrarConcepto(  );
    
    if( empty( $arrErrores ) ){
    	$arrMensaje = array( );
    	$arrMensaje[] = "El concepto ha sido borrado exitosamente";
    }

   	imprimirMensajes( $arrErrores, $arrMensaje );
    

?>
