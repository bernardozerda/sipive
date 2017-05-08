<?php

	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']. "ReportesProyectos.class.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
	
	$claReporte = new Reportes;
	$reporte = $_GET['reporte'];
	// pr($reporte); 
	
	$claReporte->cargarSecuencialesFormulario(  );
	
	switch($reporte){
		
      case "CartasMovilizacion";
			$claReporte->exportableCartasMovilizacion( );
			break;
      
		case "ReporteFormsEliminados";
			$claReporte->exportableReporteFormsEliminados( );
			break;
		
		case "ReporetResumenPrograma";
			$claReporte->exportableResumenPrograma( );
			break;
			
		case "ReporteCartasAsignacion";
			$claReporte->exportableCartasAsignacion( );
			break;
			
		case "ReporteInscritosNoCC";
			$claReporte->exportableReporteInscritosNoCC( );
			break;
		
		case "ReporteEstadoCorte";
			$claReporte->exportableEstadoCorte();
			break;
		
		case "ReporteIdRepetido";
			$claReporte->exportableReporteIdRepetido();
			break;
			
		case "ReporteCruzarEdadTodFchPos";
			$claReporte->exportableReporteCruzarEdadTodFchPos();
			break;
			
		case "ReporteTipoDocPasExt";
			$claReporte->exportableReporteTipoDocPasExt();
			break;
			
		case "ReporteCondicionMayorEdad";
			$claReporte->exportableReporteCondicionMayorEdad();
			break;
			
		case "ReporteIngresosVsReglamento";
			$claReporte->exportableReporteIngresosVsReglamento();
			break;
			
		case "ReporteSoacha";
			$claReporte->exportableReporteSoacha();
			break;
			
		case "ReporteBeneficiariosSubsidio";
			$claReporte->exportableReporteBeneficiariosSubsidio();
			break;
			
		case "ReporteBeneficiariosCajaCompensacion";
			$claReporte->exportableReporteBeneficiariosCajaCompensacion();
			break;
			
		case "ReporteCierreFinancieroConPromesa";
			$claReporte->exportableReporteCierreFinancieroConPromesa();
			break;
			
		case "ReporteVRSubsidioMejoramiento";
			$claReporte->exportableReporteVRSubsidioMejoramiento();
			break;
			
		case "ReporteVerificaModalidadSolucion";
			$claReporte->exportableReporteVerificaModalidadSolucion();
			break;
			
		case "ReporteAhorroCreditoSoporte";
			$claReporte->exportableReporteAhorroCreditoSoporte();
			break;
			
		case "ReporteMiembrosHogar";
			$claReporte->exportableReporteMiembrosHogar();
			break;
			
		case "ReporteTodosConEstado";
			$claReporte->exportableReporteTodosConEstado();
			break;
			
		case "ReporteGeneral";
			$claReporte->exportableReporteGeneral();
			break;
			
		case "ReporteAnalisisPoblacion";
			$claReporte->exportableReporteAnalisisPoblacion();
			break;
			
		case "ReporteDatosDeContacto";
			$claReporte->exportableReporteDatosDeContacto();
			break;
		
		case "PasivosExigibles":
			$claReporte->pasivosExigibles( $_POST['fchInicio'] , $_POST['fchFin'] );
			break;
      case "seguimientoDesembolsos":
         if( $_FILES['fileSecuenciales']['error'] == 0 ){
            $arrDocumentos = mb_split( "\n" , file_get_contents( $_FILES['fileSecuenciales']['tmp_name'] ) );
            foreach( $arrDocumentos as $numLinea => $numDocumento ){
               if( intval( $numDocumento ) != 0 ){
                  $arrDocumentos[ $numLinea ] = $numDocumento;
               }else{
                  unset( $arrDocumentos[ $numLinea ] );
               }
            }
         }
         $claReporte->seguimientoDesembolsos( $arrDocumentos );
         break;
	}
	
?>