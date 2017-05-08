<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
 	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoProyectos.class.php" );
 	
 	$seqProyecto = intval( $_POST['seqProyecto'] );
 	$seqSeguimiento = intval( $_POST['seqSeguimiento'] );
 	
 	if( $seqProyecto != 0 ){
	 	$claSeguimientoProyectos = new SeguimientoProyectos;
	 	$claSeguimientoProyectos->seqSeguimiento = $seqSeguimiento;
		$claSeguimientoProyectos->seqProyecto = $seqProyecto;
	 	$arrRegistros = $claSeguimientoProyectos->obtenerRegistros();
 	}else{
 		$claSeguimientoProyectos->arrErrores[] = "No hay seguimientos registrados para este proyecto"; 
 	}
 	
 	if( empty( $claSeguimientoProyectos->arrErrores ) ){
 		
 		if( strpos( $arrRegistros[ $seqSeguimiento ]['txtCambios'] , "<br>" ) !== false ){
 			$arrRegistros[ $seqSeguimiento ]['txtCambios'] = ereg_replace( "<br>" , "\n" , $arrRegistros[ $seqSeguimiento ]['txtCambios'] );
 		}
 		
		$arrLineas = $claSeguimientoProyectos->parserTextoCambios( $arrRegistros[ $seqSeguimiento ]['txtCambios'] );
		
		$claSmarty->assign( "numAlto" , ( $_POST['alto'] - 80 ) );
		$claSmarty->assign( "registroSeguimiento" , $seqSeguimiento );
		$claSmarty->assign( "arrLineas" , $arrLineas );
		$claSmarty->display( "seguimiento/verCambios.tpl" );
		
 	}else{
 		imprimirMensajes( $claSeguimientoProyectos->arrErrores , array() );	
 	}
?>
