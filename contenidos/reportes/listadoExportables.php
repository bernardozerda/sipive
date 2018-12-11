<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );

$arrGruposPertenece = array_keys($_SESSION["arrGrupos"][3]);

$arrExportables["resumenPrograma"] = 0; // Resumen Programa
$arrExportables["estadoDeCorte"] = 0; // Estado De Corte
$arrExportables["cartasAsignacion"] = 0; // Listado para Cartas de Asignacion
$arrExportables["formsEliminados"] = 0; // Formularios Eliminados
$arrExportables["numIdRepetido"] = 0; // Numero Id Repetido
$arrExportables["inscritosNoCC"] = 0; // Inscritos con PPAL con Tipo Documento diferente a C.C. o C.E.
$arrExportables["edadTDvsFP"] = 0; // Cruzar Edad Tipo Documento vs Fecha Postulacion
$arrExportables["TDPasaporteExtr"] = 0; // Tipo Documento Pasaporte o Extranjeria
$arrExportables["condicionME"] = 0; // Verificar Condicion Mayor de Edad
$arrExportables["ingresosReglamento"] = 0; // Verificar Ingresos vs Reglamento
$arrExportables["dirSoacha"] = 0; // Verificar Direccion o Barrio en Soacha
$arrExportables["beneficiarioSubsidio"] = 0; // Verificar si son realmente Beneficiarios del Subsidio
$arrExportables["beneficiariosCajaCompensacion"] = 0; // Verificar si son realmente Beneficiarios de Caja de Compensacion
$arrExportables["solCierreFinanciero"] = 0; // Cruce tipo Solucion con Cierre Financiero (Verifica Hogares con Promesa CompraVenta)
$arrExportables["VRSubsidioMejoramiento"] = 0; // VR Subsidio Mejoramiento
$arrExportables["ModSolvsSubsidio"] = 0; // Verificar Modalidad, Solucion vs Subsidio
$arrExportables["ahorroCreditoSubsidioSinSoporte"] = 0; // Ahorro, Credito y/o Subsidio Nacional sin Soporte
$arrExportables["nombresMiembrosHogar"] = 0; // Nombres Miembros de Hogar
$arrExportables["datosContacto"] = 0; // Datos de Contacto
$arrExportables["todosEstado"] = 0; // Todos con Estado
$arrExportables["reporteGeneral"] = 0; // Reporte General
$arrExportables["analisisPoblacion"] = 0; // Reporte Analisis Poblacion
$arrExportables["sdvMetroSDHT"] = 0; // Resumen SDV. Metrovivienda y SDHT
$arrExportables["sdvMarzo0910"] = 0; // Analisis programa SDV Marzo 2009-2010
$arrExportables["formsPostulados"] = 0; // Formularios Postulados
$arrExportables["listadoMayorEdad"] = 0; // Listado de Mayores de edad
$arrExportables["directiva013"] = 0; // Reporte Directiva 013 (Beta)
$arrExportables["reporteSeguimiento"] = 0; // Reporte de Seguimiento
$arrExportables["reporteEscrituracion"] = 0; // Reporte de Escrituración
$arrExportables["reporteEstudioTitulos"] = 0; // Reporte de Estudio de Titulos
$arrExportables["reporteCierre"] = 0; // Reporte de Cierre
$arrExportables["reporteCierreMejoramiento"] = 0; // Reporte de Cierre Mejoramiento
$arrExportables["reporteSeguimientoValores"] = 0; // Reporte de Seguimiento
$arrExportables["reporteInscritos"] = 0; // Reporte de Inscritos
$arrExportables["reporteInscritosSinActualizar"] = 0; // Reporte de Inscritos sin Actualizar
$arrExportables["reporteDesembolsos"] = 0; // Reporte Desembolsos. Tramites Administrativos
$arrExportables["reporteTecnico"] = 0; // Reporte Tecnico
$arrExportables["pasivosExigibles"] = 0; // Reporte de pasivos exigibles
$arrExportables["actaVisita"] = 1; // Reporte para generar constancia de visitas
$arrExportables["casaMano"] = 0; // Registros de casa en mano
$arrExportables["permisos"] = 0; // Registros de casa en mano
$arrExportables["seguimientoDesembolsos"] = 0; // Registros que tienen giros realizados en desembolso
$arrExportables["cartasMovilizacion"] = 0; // Para ver los codigos que se generan desde la pagina de servicios al ciudadano
$arrExportables["baseMetrovivienda"] = 0; // Base de metrovivienda
$arrExportables["archivoDesembolso"] = 0;
$arrExportables["reporteAsignadosAAD"] = 0; //Reporte AAD Asignacion
$arrExportables["reporteAsignacionUnidades"] = 0; //Reporte Asignacion Unidades
$arrExportables["reporteAsignacionUnidadesmejoramiento"] = 0; //Reporte Asignacion Unidades Mejoramiento
$arrExportables["reporteEpigrafeAAD"] = 0; //Reporte AAD Epigrafe
$arrExportables["reportePlantillaInformeSolucion"] = 0; //Reporte Proyectos
$arrExportables["consultaCruces"] = 0; // Consulta Cruces
$arrExportables["migracionCEMaDES"] = 0; // Migracion Casa en Mano a Desembolso
$arrExportables["legalizacionGerencial"] = 0; // Legalización Gerencial
$arrExportables["reporteGeneralInscritos"] = 0; // ReporteGeneralInscritos    
$arrExportables["Caracterizacion"] = 0; // Caracterizacion 
$arrExportables["reporteBasedeDatosPoblacional"] = 0; // reporteBasedeDatosPoblacional 
$arrExportables["InformacionSolucion"] = 0; // plantilla InformacionSolucion    
$arrExportables["plantillaestudiotitulos"] = 0; // Plantilla Estudio de Titulos
$arrExportables["plantillaEscrituracion"] = 0; // Plantilla Escrituración
$arrExportables["informeProyectos"] = 0;
$arrExportables["encuestasPive"] = 0; // Encuestas PIVE
$arrExportables["inconsistenciasInscripcion"] = 0; // Reporte de inconsistencias de inscripcion
$arrExportables["estudioTitulosLeasing"] = 0; // Plantilla Estudio de Titulos Leasing
$arrExportables["soporteResolucionVinculacion"] = 0;
$arrExportables["girosVIPA"] = 0; // GIROS VIPA
$arrExportables["reporteTotalCiudadano"] = 0; //Reporte Informacion hogar 
$arrExportables["informeGralSubsidios"] = 0;

foreach ($arrGruposPertenece as $seqGrupo) {

    switch ($seqGrupo) {

        case 5: // informadores
            //$arrExportables["reporteSeguimiento"] 	= 1;
            $arrExportables["reporteInscritos"] = 1;
            $arrExportables["reporteInscritosSinActualizar"] = 1;
            break;

        case 6: // tutores postulacion
            $arrExportables["formsPostulados"] = 1;
            $arrExportables["directiva013"] = 1;
            $arrExportables["reporteAsignadosAAD"] = 1;
            //$arrExportables["reporteSeguimiento"] 	= 1; 
            $arrExportables["casaMano"] = 1;
            break;

        case 7: // coordinacion grupo
            $arrExportables["resumenPrograma"] = 0;
            $arrExportables["estadoDeCorte"] = 1;
            $arrExportables["formsEliminados"] = 1;
            $arrExportables["numIdRepetido"] = 0;
            $arrExportables["inscritosNoCC"] = 1;
            $arrExportables["edadTDvsFP"] = 0;
            $arrExportables["TDPasaporteExtr"] = 1;
            $arrExportables["condicionME"] = 1;
            $arrExportables["ingresosReglamento"] = 0;
            $arrExportables["dirSoacha"] = 0;
            $arrExportables["beneficiarioSubsidio"] = 0;
            $arrExportables["beneficiariosCajaCompensacion"] = 0;
            $arrExportables["solCierreFinanciero"] = 1;
            $arrExportables["VRSubsidioMejoramiento"] = 1;
            $arrExportables["ModSolvsSubsidio"] = 1;
            $arrExportables["ahorroCreditoSubsidioSinSoporte"] = 1;
            $arrExportables["nombresMiembrosHogar"] = 1;
            $arrExportables["datosContacto"] = 1;
            $arrExportables["todosEstado"] = 1;
            $arrExportables["reporteGeneral"] = 1;
            $arrExportables["analisisPoblacion"] = 1;
            $arrExportables["sdvMetroSDHT"] = 1;
            $arrExportables["sdvMarzo0910"] = 1;
            $arrExportables["formsPostulados"] = 1;
            $arrExportables["listadoMayorEdad"] = 1;
            $arrExportables["directiva013"] = 1;
            $arrExportables["reporteSeguimiento"] = 1;
            $arrExportables["reporteEscrituracion"] = 1;
            $arrExportables["reporteCierre"] = 1;
            $arrExportables["reporteCierreMejoramiento"] = 1;
            $arrExportables["reporteSeguimientoValores"] = 1;
            $arrExportables["reporteInscritos"] = 1;
            $arrExportables["reporteInscritosSinActualizar"] = 1;
            $arrExportables["reporteDesembolsos"] = 1;
            $arrExportables["reporteTecnico"] = 1;
            $arrExportables["actaVisita"] = 1;
            $arrExportables["casaMano"] = 1;
            $arrExportables["seguimientoDesembolsos"] = 1;
            $arrExportables["cartasMovilizacion"] = 1;
            $arrExportables["consultaCruces"] = 1;
            $arrExportables["migracionCEMaDES"] = 1;
            $arrExportables["reporteAsignadosAAD"] = 1;
            $arrExportables["reporteAsignacionUnidades"] = 1;
            $arrExportables["reporteAsignacionUnidadesMejoramiento"] = 1;
            $arrExportables["reporteEpigrafeAAD"] = 1;
            $arrExportables["plantillaEscrituracion"] = 1;
            $arrExportables["informeProyectos"] = 1;
            $arrExportables["archivoDesembolso"] = 1;
            $arrExportables["soporteResolucionVinculacion"] = 1;
            break;

        case 8: // tutores desembolso
            //$arrExportables["reporteSeguimiento"] = 1;
            $arrExportables["seguimientoDesembolsos"] = 1;
            $arrExportables["reporteEscrituracion"] = 1;
            $arrExportables["InformacionSolucion"] = 1;
            $arrExportables["reportePlantillaInformeSolucion"] = 1;
            break;

        case 9: // solicitud de desembolso
            //$arrExportables["reporteSeguimiento"] 	= 1;
            $arrExportables["reporteDesembolsos"] = 1;
            $arrExportables["pasivosExigibles"] = 1;
            $arrExportables["reporteInscritos"] = 1;
            $arrExportables["cartasMovilizacion"] = 1;
            $arrExportables["reporteEpigrafeAAD"] = 1;
            $arrExportables["legalizacionGerencial"] = 1;
            $arrExportables["reporteEscrituracion"] = 1;
            $arrExportables["girosVIPA"] = 1;
            break;

        case 13: // juridica
            //$arrExportables["reporteSeguimiento"] = 1;
            $arrExportables["casaMano"] = 1;
            $arrExportables["cartasMovilizacion"] = 1;
            $arrExportables["baseMetrovivienda"] = 1;
            $arrExportables["reporteAsignacionUnidades"] = 1;
            $arrExportables["plantillaestudiotitulos"] = 1;
            $arrExportables["reporteEstudioTitulos"] = 1;
            $arrExportables["archivoDesembolso"] = 1;
            $arrExportables["estudioTitulosLeasing"] = 1;
            break;

        case 14: // tecnico
            //$arrExportables["reporteSeguimiento"]	= 1;
            $arrExportables["reporteTecnico"] = 1;
            $arrExportables["actaVisita"] = 1;
            $arrExportables["casaMano"] = 1;
            break;

        case 18: // directivas
            $arrExportables["sdvMetroSDHT"] = 1;
            $arrExportables["sdvMarzo0910"] = 1;
            $arrExportables["casaMano"] = 1;
            $arrExportables["consultaCruces"] = 1;
            $arrExportables["migracionCEMaDES"] = 1;
            break;

        case 20: // Administradores Sistema
            $arrExportables["plantillaestudiotitulos"] = 1;
            $arrExportables["InformacionSolucion"] = 1;
            $arrExportables["reporteBasedeDatosPoblacional"] = 1;
            $arrExportables["Caracterizacion"] = 1;
            $arrExportables["reporteGeneralInscritos"] = 1;
            $arrExportables["cartasAsignacion"] = 1;
            $arrExportables["casaMano"] = 1;
            $arrExportables["permisos"] = 1;
            $arrExportables["cartasMovilizacion"] = 1;
            $arrExportables["hogaresCalificados"] = 1;
            $arrExportables["reporteAsignadosAAD"] = 1;
            $arrExportables["reporteAsignacionUnidades"] = 1;
            $arrExportables["reporteAsignacionUnidadesMejoramiento"] = 1;
            $arrExportables["reporteEpigrafeAAD"] = 1;
            $arrExportables["reportePlantillaInformeSolucion"] = 1;
            $arrExportables["plantillaEscrituracion"] = 1;
            $arrExportables["informeProyectos"] = 1;
            $arrExportables["archivoDesembolso"] = 1;
            $arrExportables["encuestasPive"] = 1;
            $arrExportables["inconsistenciasInscripcion"] = 1;
            $arrExportables["estudioTitulosLeasing"] = 1;
            $arrExportables["soporteResolucionVinculacion"] = 1;
            $arrExportables["girosVIPA"] = 1;
            $arrExportables["reporteTotalCiudadano"] = 1;
            $arrExportables["informeGralSubsidios"] = 1;
            break;
        case 34: // Cruce Información Cvp
            $arrExportables["reporteInformacionCvp"] = 1;
            break;
        case 34: // Reportes
            $arrExportables["inconsistenciasInscripcion"] = 1;
            break;
        case 37: // Carga Encuestas
            $arrExportables["encuestasPive"] = 1;
            break;
        case 38: // Consulta encuestas
            $arrExportables["encuestasPive"] = 1;
            break;
    }
}

$arrGrupoGestionAdministrador[] = 15;
$arrGrupoGestionAdministrador[] = 5;
$arrGrupoGestionAdministrador[] = 10;
$arrGrupoGestionAdministrador[] = 12;

// Grupos de gestion
$sql = "
		SELECT 
			seqGrupoGestion,
			txtGrupoGestion
		FROM 
			T_SEG_GRUPO_GESTION
		WHERE 
			seqGrupoGestion not in (" . implode(',', $arrGrupoGestionAdministrador) . ")
		ORDER BY 
			txtGrupoGestion
	";
$objRes = $aptBd->execute($sql);
while ($objRes->fields) {
    $arrGrupoGestion[$objRes->fields['seqGrupoGestion']] = $objRes->fields['txtGrupoGestion'];
    $objRes->MoveNext();
}

$claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
$claSmarty->assign("arrExportables", $arrExportables);
$claSmarty->display("reportes/listadoExportables.tpl");
?>