<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Grupo.class.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );	
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );	
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Desembolso.class.php" );	
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );	

	include( "./datosComunes.php" );
	
   $txtFecha = utf8_encode( ucwords( strftime("%A %#d de %B del %Y") ) ) ." " . date( "H:i:s" ); 
    
	$seqFormulario = $_GET['seqFormulario'];
   $seqCasaMano = intval( $_GET['seqCasaMano'] );
   
	$claFormulario = new FormularioSubsidios;
	$claDesembolso = new Desembolso;
	
   $claFormulario->cargarFormulario( $seqFormulario );
   if( $seqCasaMano != 0 ){
      $claCasaMano = new CasaMano();
      $arrCasaMano = $claCasaMano->cargar( $seqFormulario , $seqCasaMano );
      $objCasaMano = array_shift( $arrCasaMano );
      $claDesembolso = $objCasaMano->objRegistroOferta;
      $claDesembolso->arrJuridico = $objCasaMano->objRevisionJuridica;
   } else {
      $claDesembolso->cargarDesembolso( $seqFormulario );
   }
   
	foreach( $claFormulario->arrCiudadano as $objCiudadano ){
		if( $objCiudadano->seqParentesco == 1 ){
			break;
		}
	}

	$claSeguimiento = new Seguimiento;
	$claSeguimiento->seqFormulario = $_GET['seqFormulario'];
	
	$numRegistros = array_shift( array_keys( $claSeguimiento->obtenerRegistros( 1 , 0 ) ) );
	
	$claSmarty->assign( "txtFuente12" , "font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 12px;" );
	$claSmarty->assign( "txtFuente10" , "font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px;" );
	$claSmarty->assign( "txtFecha" , $txtFecha );
	$claSmarty->assign( "claCiudadano" , $objCiudadano );
	$claSmarty->assign( "claDesembolso" , $claDesembolso );
	$claSmarty->assign( "txtUsuarioSesion"   , $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido'] );
	$claSmarty->assign( "claFormulario" , $claFormulario );
	$claSmarty->assign( "numRegistro" , $numRegistros );
	
	$claSmarty->display( "desembolso/formatoRevisionJuridica.tpl" );
	
?>
