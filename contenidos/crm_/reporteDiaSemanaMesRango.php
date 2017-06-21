<?php

	$txtPrefijoRuta = "../../";

	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );
	include( "../desembolso/datosComunes.php" );
	
	$claCRM 		= new CRM;
	$arrErrores 	= array( );
	$txtTipoReporte = $_GET[ 'txtTipoReporte' ];
	$faseIndicador 	= $_POST[ 'estadoDesembolso' ];
	$filtros 		= "";
	$seqUsuario 	= $_POST[ 'seqUsuario' ];
	
	$txtConsultaReporte = $_GET[ 'txtConsultaReporte' ];
		
	switch ( $txtTipoReporte ){
		
		case "diaSemanaMes":
			if( !isset( $_POST[ 'tipoDesembolsoRango'] ) ){
				$arrErrores[] = "Indique que rango quiere para el reporte.";
			}
			if( empty ( $arrErrores ) ){
				$tipoDesembolsoRango = $_POST[ 'tipoDesembolsoRango' ];
				
				$fchHoy = date( "Y-m-d" );
				switch( $tipoDesembolsoRango ){
					case "hoy";
						$fchRango = date( "Y-m-d" );
						break;
					case "semana":
						$fchRango = date( "Y-m-d" , mktime( 0 , 0,  0 , date( "m" ) , date( "d" ) - 7 , date( "Y" ) ) );
						break;
					case "mes":
						$fchRango = date( "Y-m-d" , mktime( 0 , 0,  0 , date( "m" ) - 1 , date( "d" ) , date( "Y" ) ) );
						break;
				}
				
				$arrQueries = $claCRM->obtenerQueriesRangosFecha( $_POST[ 'estadoDesembolso' ] );
				$arrQueries[ "rangos" ] = ( is_array( $arrQueries[ "rangos" ] ) )?implode( " OR ", $arrQueries[ "rangos" ] ):$arrQueries[ "rangos" ];trim( $arrQueries[ "rangos" ] );
				$arrQueries[ "rangos" ] = str_replace( "%fechaRango%" , $fchRango 	, $arrQueries[ "rangos" ] );
	    		$arrQueries[ "rangos" ] = str_replace( "%fechaHoy%"  , $fchHoy 	, $arrQueries[ "rangos" ] );
				
			}
			break;
		
		case "rangoFechas":
			if( !$_POST[ 'fchIni' ] ){
				$arrErrores[] = "Indique la fecha inicial para el reporte";
			}
			if( !$_POST[ 'fchFin' ] ){
				$arrErrores[] = "Indique la fecha final para el reporte";
			}
			if( empty ( $arrErrores ) ){
				
				$fchIni = $_POST[ 'fchIni' ];
				$fchFin = $_POST[ 'fchFin' ];
				
				$arrQueries = $claCRM->obtenerQueriesRangosFecha( $_POST[ 'estadoDesembolso' ] );
				$arrQueries[ "rangos" ] = ( is_array( $arrQueries[ "rangos" ] ) )?implode( " OR ", $arrQueries[ "rangos" ] ):$arrQueries[ "rangos" ];trim( $arrQueries[ "rangos" ] );
				$arrQueries[ "rangos" ] = str_replace( "%fechaRango%" , $fchIni , $arrQueries[ "rangos" ] );
	    		$arrQueries[ "rangos" ] = str_replace( "%fechaHoy%"  , $fchFin , $arrQueries[ "rangos" ] );
				
			}
			break;
	
		
		default:
			$arrErrores[] = "No se selecciono el tipo de reporte";
			break;
	}
	
	if( empty( $arrErrores ) ){
		$txtTipoReporte = $_POST[ 'estadoDesembolso' ];
		
		$claCRM->reporteIndicadores( $seqUsuario, $faseIndicador, "" , $arrQueries );
		switch ( $txtConsultaReporte ){
			
			case "reporte":
				Reportes::obtenerReportesGeneral( $claCRM->arrTablaConsulta, $txtTipoReporte );
				break;
			
			case "consulta":
			default:
				$claSmarty->assign( "claCrm" , $claCRM );	
				$claSmarty->display( "crm/indicadorTutorDesembolso/dataTableIndicadores.tpl" );
				break;
		}
	}else{
		imprimirErrores( $arrErrores );
	}

?>