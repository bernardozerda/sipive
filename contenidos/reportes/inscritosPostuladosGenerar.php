<?php

	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']. "Reportes.class.php" );
	
	$arrErrores = array( );
		
	if( !isset( $_POST[ 'filtroEstadoProceso' ]  ) ){
		$arrErrores[] = "Ingrese el Estado del Proceso por el cual quiere generar el reporte.";
	}
	
	if( !isset( $_POST[ 'filtroUsuarioPunto' ]  ) ){
		$arrErrores[] = "Ingrese el si desea por usuario o punto de atencion por el cual quiere generar el reporte.";
	}
    
    if( empty ( $arrErrores ) ){
    	
    	$claReporte = new Reportes;
    	$claReporte->inscritosostuladosConsulta( );
    	
    	$claSmarty->assign( "arrTablas" 	, $claReporte->arrTablas );
    	$claSmarty->assign( "txtGraficas" 	, $claReporte->php2js() );
    	$claSmarty->display( "reportes/reporteInscritosGeneradoGenerado.tpl"  );
    	
    }else{
    	imprimirErrores( $arrErrores );	
    }
    
	

?>
