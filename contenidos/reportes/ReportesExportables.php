<?php

$txtPrefijoRuta = "../../";
include($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
include($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php");
include($txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php");
include($txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Encuestas.class.php");


$claReporte = new Reportes;
$reporte = $_GET['reporte'];
// pr($reporte); 
//if($reporte != 'reporteTotalCiudadano')
$claReporte->cargarSecuencialesFormulario();

switch ($reporte) {

    case "HogaresCalificados";
        $claReporte->exportableHogaresCalificados();
        break;

    case "CartasMovilizacion";
        $claReporte->exportableCartasMovilizacion();
        break;

    case "ReporteFormsEliminados";
        $claReporte->exportableReporteFormsEliminados();
        break;

    case "ReporetResumenPrograma";
        $claReporte->exportableResumenPrograma();
        break;

    case "ReporteCartasAsignacion";
        $claReporte->exportableCartasAsignacion();
        break;

    case "ReporteInscritosNoCC";
        $claReporte->exportableReporteInscritosNoCC();
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
        $claReporte->pasivosExigibles($_POST['fchInicio'], $_POST['fchFin']);
        break;
    case "reporteAsignadosAAD":
        $claReporte->exportableActosAdministrativosAsignacion();
        break;
    case "reporteAsignadosActual":
        $claReporte->exportableActosAdministrativosAsignacionActual();
        break;
    case "reporteAsignacionUnidades":
        $claReporte->exportableAsignacionUnidades();
        break;
    case "reporteAsignacionUnidadesMejoramiento":
        $claReporte->exportableAsignacionUnidadesMejoramiento();
        break;
    case "reporteEpigrafeAAD":
        $claReporte->exportableActosAdministrativosEpigrafe();
        break;
    case "reporteGeneralInscritos":
        $claReporte->reporteGeneralInscritos();
        break;
    case "Caracterizacion":
        $claReporte->Caracterizacion();
        break;
    case "reporteBasedeDatosPoblacional":
        $claReporte->reporteBasedeDatosPoblacional();
        break;
    case "InformacionSolucion":
        $claReporte->InformacionSolucion();
        break;
    case "plantillaestudiotitulos":
        $claReporte->plantillaestudiotitulos();
        break;

    case "seguimientoDesembolsos":
        if ($_FILES['fileSecuenciales']['error'] == 0) {
            $arrDocumentos = mb_split("\n", file_get_contents($_FILES['fileSecuenciales']['tmp_name']));
            foreach ($arrDocumentos as $numLinea => $numDocumento) {
                if (intval($numDocumento) != 0) {
                    $arrDocumentos[$numLinea] = $numDocumento;
                } else {
                    unset($arrDocumentos[$numLinea]);
                }
            }
        }
        $claReporte->seguimientoDesembolsos($arrDocumentos);
        break;

    case "plantillaEscrituracion":
        if ($_FILES['fileSecuenciales']['error'] == 0) {
            $arrDocumentos = mb_split("\n", file_get_contents($_FILES['fileSecuenciales']['tmp_name']));
            foreach ($arrDocumentos as $numLinea => $numDocumento) {
                if (intval($numDocumento) != 0) {
                    $arrDocumentos[$numLinea] = $numDocumento;
                } else {
                    unset($arrDocumentos[$numLinea]);
                }
            }
            $claReporte->obtenerEscrituracion($arrDocumentos);
        } else {
            echo '<span style="color:#c10;text-align:center;"><b>Selecione un archivo en filtros->Datos!</b></span>';
        }


        break;

    case "informeProyectos":
        $claReporte->informeProyectos();
        break;

    case "reporteInformacionCvp":

        if ($_FILES['fileSecuenciales']['error'] == 0) {
            $arrDocumentos = mb_split("\n", file_get_contents($_FILES['fileSecuenciales']['tmp_name']));
            foreach ($arrDocumentos as $numLinea => $numDocumento) {
                if (intval($numDocumento) != 0) {
                    $arrDocumentos[$numLinea] = intval($numDocumento);
                } else {
                    unset($arrDocumentos[$numLinea]);
                }
            }

            $claReporte->registrosCiudadano($arrDocumentos);
        } else {
            echo '<span style="color:#c10;text-align:center;"><b>Selecione un archivo en filtros->Datos!</b></span>';
        }
        break;

    case "encuestasPive":
//        $claReporte->encuestasPive();
        $claReporte->encuestasPiveCruces();
        break;

    case "estudioTitulosLeasing":
        $claReporte->estudioTitulosLeasing();
        break;

    case "soporteResolucionVinculacion":

        if ($_FILES['fileSecuenciales']['error'] == 0) {
            $arrDocumentos = mb_split("\n", file_get_contents($_FILES['fileSecuenciales']['tmp_name']));
            foreach ($arrDocumentos as $numLinea => $numDocumento) {
                if (intval($numDocumento) != 0) {
                    $arrDocumentos[$numLinea] = intval($numDocumento);
                } else {
                    unset($arrDocumentos[$numLinea]);
                }
            }

            $claReporte->soporteResVinculacion($arrDocumentos);
        } else {
            echo '<span style="color:#c10;text-align:center;"><b>Selecione un archivo en filtros->Datos!</b></span>';
        }
        break;

    case "girosVIPA":
        $claReporte->girosVIPA();
        break;

    case "reporteTotalCiudadano":
        $arrDocumentos = Array();
        if ($_FILES['fileSecuenciales']['error'] == 0) {
            $arrDocumentos = mb_split("\n", file_get_contents($_FILES['fileSecuenciales']['tmp_name']));
            //   pr($arrDocumentos);           
            foreach ($arrDocumentos as $numLinea => $numDocumento) {
                if (intval($numDocumento) != 0) {
                    $arrDocumentos[$numLinea] = (float) ($numDocumento);
                } else {
                    unset($arrDocumentos[$numLinea]);
                }
            }
        }
        $claReporte->reporteGralHogar($arrDocumentos);
        break;

    case "informeGralSubsidios":
        $claReporte->informeGralSubsidios();
        break;
}
?>