<?php

	if(file_exists( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" )){
		include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );
		$claSmarty->assign( "txtArchivoInicio" , "reportes/baseReportes.tpl"  );
		$mostrarPlantilla = false;
	}else{
		
		$txtPrefijoRuta = "../../";
		include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
		include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']. "Reportes.class.php" );
		$mostrarPlantilla = true;	
	}


	
	$claReporte = new Reportes; 
	
	$claReporte->consolidadoPrograma();
	
	
	if( empty( $claReporte->arrErrores ) ) {
	
//		$claSmarty->assign( "txtIdFormulario" , "ReporetResumenPrograma" );
		$claSmarty->assign( "arrTablas" , $claReporte->arrTablas );
		$claSmarty->assign( "txtGraficas" , $claReporte->php2js() );
		
		if($mostrarPlantilla){
			$claSmarty->display( "reportes/baseReportes.tpl"  );
		}
		
	}else{
		
	}

?>
