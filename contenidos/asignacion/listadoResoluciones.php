<?php
	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos.class.php" );
	
	$_POST['numActo']     = ( is_numeric( $_POST['numActo'] ) )?      $_POST['numActo']     : null ;
	$_POST['seqTipoActo'] = ( intval( $_POST['seqTipoActo'] ) != 0 )? $_POST['seqTipoActo'] : null ; 
	
	$claActo = new ActoAdministrativo;
	$arrListadoActos = $claActo->listarActosNumeroTipo( $_POST['numActo'], $_POST['seqTipoActo'] );
	
	$claSmarty->assign( "arrListadoActos" , $arrListadoActos );
	$claSmarty->display( "asignacion/listadoResoluciones.tpl" );
	
?>
