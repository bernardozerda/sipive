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
	$claCrm->obtenerTutores( );
	
	$arrEstado = array( );
	
	$arrEstado[ "revisionOferta" ] 		= "Busqueda de la Oferta";
	$arrEstado[ "revisionJuridica" ] 	= "Revisión Jurídica";
	$arrEstado[ "revisionTecnica" ] 	= "Revisión Técnica";
	$arrEstado[ "escrituracion" ] 		= "Escrituración";
	$arrEstado[ "estudioTitulos" ] 		= "Estudio de Titulos";
	$arrEstado[ "solicitudDesembolso" ] = "Solicitud de Desembolso";
	
	$bolCoordinadorGrupo = 0;
	// Verifico si el usuario pertenece al grupo de Coordinador de grupo
	$arrGrupos = $_SESSION[ "arrGrupos" ][ 3 ];
	if( array_key_exists( 7 , $arrGrupos ) or array_key_exists( 18 , $arrGrupos ) ){
		$bolCoordinadorGrupo = 1;
	}
	
//	
	$claCrm->obtenerIdUsuarioIndicador( );
	$seqUsuario = $claCrm->seqUsuario;
	
	$claCrm->obtenerHogaresPromedioTutorDesembolso( );
	$claCrm->obtenerHogaresPorEstadoTutorDesembolso( );
	$claCrm->obtenerCuentaDesembolsoTotal( );
	
	$claSmarty->assign( "claCrm" 						, $claCrm );
	$claSmarty->assign( "arrTutores" 					, $claCrm->arrNombreTutorNoCuenta );
	$claSmarty->assign( "seqUsuario" 					, $seqUsuario );
	$claSmarty->assign( "arrEstado" 					, $arrEstado );
	$claSmarty->assign( "bolCoordinadorGrupo" 			, $bolCoordinadorGrupo );
	$claSmarty->assign( "txtArchivoIndicadorDesembolso" , "crm/indicadoresTutoresDesembolso.tpl" );
	$claSmarty->display( "crm/indicadoresTutoresDesembolsBase.tpl" );

?>
