<?php

/**
 * PRIMERA VERSION DE SALVAR ACTUALIZACION
*/
$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ProyectoVivienda.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoProyectos.class.php" );

//pr ($_POST);

$arrErrores = array(); // Todos los errores van aqui
$numFechaHoy = time();

/* * ********************************************************************************************************************
 * VALIDACIONES DEL FORMULARIO
 * ******************************************************************************************************************** */

// Grupo de Gestion
if ($_POST['seqGrupoGestion'] == 0) {
	$arrErrores[] = "Seleccione el grupo de la gestión realizada";
}

// Gestion
if ($_POST['seqGestion'] == 0) {
	$arrErrores[] = "Seleccione la gestión realizada";
}

// Comentarios
if ($_POST['txtComentario'] == "") {
	$arrErrores[] = "Por favor diligencie el campo de comentarios";
}

// ============================================ DATOS DE LA LICENCIA DE URBANISMO =================================================
/*
if (($_POST['txtLicenciaUrbanismo'] ) != ""){
	// Validacion de la Entidad que Expide la Licencia de Urbanismo
	if( ( ! isset( $_POST['txtExpideLicenciaUrbanismo'] ) ) or trim( $_POST['txtExpideLicenciaUrbanismo'] ) == "" ){
		$arrErrores[] = "Debe diligenciar la Entidad que Expide la Licencia de Urbanismo";
	}

	// Validacion de la Fecha de la Licencia de Urbanismo
	if( ( ! isset( $_POST['fchLicenciaUrbanismo1'] ) ) or (trim( $_POST['fchLicenciaUrbanismo1'] ) == "0000-00-00") ){
		$arrErrores[] = "Debe seleccionar la Fecha de la Licencia de Urbanismo";
	}

	// Validacion del Vigencia de la Licencia de Urbanismo
	if( ( ! isset( $_POST['fchVigenciaLicenciaUrbanismo'] ) ) or (trim( $_POST['fchVigenciaLicenciaUrbanismo'] ) == "0000-00-00") ){
		$arrErrores[] = "Debe seleccionar la Fecha de Vigencia de la Licencia de Urbanismo";
	}

	// Validacion de la Fecha Ejecutoria de la Licencia de Urbanismo
	if( ( ! isset( $_POST['fchEjecutoriaLicenciaUrbanismo'] ) ) or (trim( $_POST['fchEjecutoriaLicenciaUrbanismo'] ) == "0000-00-00") ){
		$arrErrores[] = "Debe seleccionar la Fecha ejecutoria de la Licencia de Urbanismo";
	}
}*/

// Carga el formulario anterior para validacion del tipo de documento
$seqProyecto = $_POST['seqProyectoEditar'];
$claProyectoAnterior = new proyectoVivienda;
$claProyectoAnterior->cargarProyectoVivienda($seqProyecto);

/* * ********************************************************************************************************************
 * SALVAR LOS CAMBIOS
 * ******************************************************************************************************************** */
//$arrErrores = array();
if (empty($arrErrores)) {

	// Carga el formulario anteior para validacion del numero de formulario
	$claProyectoCambios = new ProyectoVivienda;
	$claProyectoCambios->cargarProyectoVivienda($seqProyecto);
	//pr ($claProyectoCambios);

	// si no hay errores salva los datos del formulario
		$claProyecto = new ProyectoVivienda;
		/*$claProyecto->numNitProyecto = 					$_POST['numNitProyecto'];
		$claProyecto->txtNombreProyecto = 				strtoupper($_POST['txtNombreProyecto']);
		$claProyecto->txtNombrePlanParcial = 			strtoupper($_POST['txtNombrePlanParcial']);
		$claProyecto->seqTipoEsquema = 					$_POST['seqTipoEsquema'];
		$claProyecto->seqPryTipoModalidad = 			$_POST['seqPryTipoModalidad'];
		$claProyecto->txtNombreOperador = 				$_POST['txtNombreOperador'];
		$claProyecto->seqOpv = 							$_POST['seqOpv'];
		$claProyecto->seqTipoProyecto = 				$_POST['seqTipoProyecto'];
		$claProyecto->seqTipoUrbanizacion = 			$_POST['seqTipoUrbanizacion'];
		$claProyecto->seqTipoSolucion = 				$_POST['seqTipoSolucion'];
		$claProyecto->txtDescripcionProyecto = 			$_POST['txtDescripcionProyecto'];
		$claProyecto->bolDireccion =	 				$_POST['bolDireccion'];
		$claProyecto->txtDireccion =		 			$_POST['txtDireccion'];
		$claProyecto->seqLocalidad =		 			$_POST['seqLocalidad'];
		$claProyecto->seqBarrio =			 			$_POST['seqBarrio'];
		$claProyecto->valTorres =			 			$_POST['valTorres'];
		$claProyecto->valNumeroSoluciones = 			$_POST['valNumeroSoluciones'];
		$claProyecto->valAreaConstruida = 				$_POST['valAreaConstruida'];
		$claProyecto->valAreaLote = 					$_POST['valAreaLote'];
		$claProyecto->txtChipLote = 					$_POST['txtChipLote'];
		$claProyecto->txtMatriculaInmobiliariaLote = 	$_POST['txtMatriculaInmobiliariaLote'];
		$claProyecto->txtRegistroEnajenacion =			$_POST['txtRegistroEnajenacion'];
		$claProyecto->fchRegistroEnajenacion =			$_POST['fchRegistroEnajenacion'];
		$claProyecto->bolEquipamientoComunal = 			$_POST['bolEquipamientoComunal'];
		$claProyecto->txtDescEquipamientoComunal = 		$_POST['txtDescEquipamientoComunal'];
		$claProyecto->seqTipoModalidadDesembolso =		$_POST['seqTipoModalidadDesembolso'];
		$claProyecto->txtNombreOferente = 				$_POST['txtNombreOferente'];
		$claProyecto->numNitOferente = 					$_POST['numNitOferente'];
		$claProyecto->txtNombreContactoOferente =		$_POST['txtNombreContactoOferente'];
		$claProyecto->numTelefonoOferente = 			$_POST['numTelefonoOferente'];
		$claProyecto->numExtensionOferente = 			$_POST['numExtensionOferente'];
		$claProyecto->numCelularOferente = 				$_POST['numCelularOferente'];
		$claProyecto->txtCorreoOferente = 				$_POST['txtCorreoOferente'];
		$claProyecto->txtNombreOferente2 = 				$_POST['txtNombreOferente2'];
		$claProyecto->numNitOferente2 = 				$_POST['numNitOferente2'];
		$claProyecto->txtNombreContactoOferente2 =		$_POST['txtNombreContactoOferente2'];
		$claProyecto->numTelefonoOferente2 = 			$_POST['numTelefonoOferente2'];
		$claProyecto->numExtensionOferente2 = 			$_POST['numExtensionOferente2'];
		$claProyecto->numCelularOferente2 = 			$_POST['numCelularOferente2'];
		$claProyecto->txtCorreoOferente2 = 				$_POST['txtCorreoOferente2'];
		$claProyecto->txtNombreOferente3 = 				$_POST['txtNombreOferente3'];
		$claProyecto->numNitOferente3 = 				$_POST['numNitOferente3'];
		$claProyecto->txtNombreContactoOferente3 =		$_POST['txtNombreContactoOferente3'];
		$claProyecto->numTelefonoOferente3 = 			$_POST['numTelefonoOferente3'];
		$claProyecto->numExtensionOferente3 = 			$_POST['numExtensionOferente3'];
		$claProyecto->numCelularOferente3 = 			$_POST['numCelularOferente3'];
		$claProyecto->txtCorreoOferente3 = 				$_POST['txtCorreoOferente3'];
		$claProyecto->txtRepresentanteLegalOferente = 	$_POST['txtRepresentanteLegalOferente'];
		$claProyecto->numNitRepresentanteLegalOferente = $_POST['numNitRepresentanteLegalOferente'];
		$claProyecto->numTelefonoRepresentanteLegalOferente =	$_POST['numTelefonoRepresentanteLegalOferente'];
		$claProyecto->numExtensionRepresentanteLegalOferente =	$_POST['numExtensionRepresentanteLegalOferente'];
		$claProyecto->numCelularRepresentanteLegalOferente =	$_POST['numCelularRepresentanteLegalOferente'];
		$claProyecto->txtDireccionRepresentanteLegalOferente =	$_POST['txtDireccionRepresentanteLegalOferente'];
		$claProyecto->txtCorreoRepresentanteLegalOferente =	$_POST['txtCorreoRepresentanteLegalOferente'];
		$claProyecto->bolConstructor = 					$_POST['bolConstructor'];
		$claProyecto->seqConstructor = 					$_POST['seqConstructor'];
		$claProyecto->valCostosDirectos = 				$_POST['valCostosDirectos'];
		$claProyecto->valCostosIndirectos = 			$_POST['valCostosIndirectos'];
		$claProyecto->valTerreno = 						$_POST['valTerreno'];
		$claProyecto->valGastosFinancieros = 			$_POST['valGastosFinancieros'];
		$claProyecto->valGastosVentas = 				$_POST['valGastosVentas'];
		$claProyecto->valTotalCostos = 					$_POST['valTotalCostos'];
		$claProyecto->valTotalVentas = 					$_POST['valTotalVentas'];
		$claProyecto->valUtilidadProyecto = 			$_POST['valUtilidadProyecto'];
		$claProyecto->valRecursosPropios = 				$_POST['valRecursosPropios'];
		$claProyecto->valCreditoEntidadFinanciera = 	$_POST['valCreditoEntidadFinanciera'];
		$claProyecto->valCreditoParticulares = 			$_POST['valCreditoParticulares'];
		$claProyecto->valVentasProyecto = 				$_POST['valVentasProyecto'];
		$claProyecto->valSDVE = 						$_POST['valSDVE'];
		$claProyecto->valOtros = 						$_POST['valOtros'];
		$claProyecto->valDevolucionIVA = 				$_POST['valDevolucionIVA'];
		$claProyecto->valTotalRecursos = 				$_POST['valTotalRecursos'];
		$claProyecto->txtLicenciaUrbanismo = 			$_POST['txtLicenciaUrbanismo'];
		$claProyecto->txtExpideLicenciaUrbanismo =		$_POST['txtExpideLicenciaUrbanismo'];
		$claProyecto->fchLicenciaUrbanismo1 = 			$_POST['fchLicenciaUrbanismo1'];
		$claProyecto->fchLicenciaUrbanismo2 = 			$_POST['fchLicenciaUrbanismo2'];
		$claProyecto->fchLicenciaUrbanismo3 = 			$_POST['fchLicenciaUrbanismo3'];
		$claProyecto->fchVigenciaLicenciaUrbanismo =	$_POST['fchVigenciaLicenciaUrbanismo'];
		$claProyecto->fchEjecutoriaLicenciaUrbanismo =	$_POST['fchEjecutoriaLicenciaUrbanismo'];
		$claProyecto->txtResEjecutoriaLicenciaUrbanismo = $_POST['txtResEjecutoriaLicenciaUrbanismo'];*/

		// REVISION PRELIMINAR
		$claProyecto->seqProfesionalResponsable 			=	$_POST['seqProfesionalResponsable'];
		$claProyecto->optVoBoContratoInterventoria 			=	$_POST['optVoBoContratoInterventoria'];
		$claProyecto->txtObservacionesContratoInterventoria =	$_POST['txtObservacionesContratoInterventoria'];
		$claProyecto->fchRevisionContratoInterventoria 		=	$_POST['fchRevisionContratoInterventoria'];

		// DATOS PROYECTO - DATOS LICENCIA DE CONSTRUCCION
		$claProyecto->txtLicenciaConstruccion = 					$_POST['txtLicenciaConstruccion'];
		$claProyecto->txtObsLicConstruccion = 						$_POST['txtObsLicConstruccion'];
		$claProyecto->fchEjecutaLicConstruccion = 					$_POST['fchEjecutaLicConstruccion'];
		$claProyecto->fchVenceLicConstruccion = 					$_POST['fchVenceLicConstruccion'];
		$claProyecto->numResolProrrogaLicConstruccion = 			$_POST['numResolProrrogaLicConstruccion'];
		$claProyecto->txtObsNumResolProrrogaLicConstruccion = 		$_POST['txtObsNumResolProrrogaLicConstruccion'];
		$claProyecto->fchEjecutaProrrogaLicConstruccion = 			$_POST['fchEjecutaProrrogaLicConstruccion'];
		$claProyecto->fchVenceProrrogaLicConstruccion = 			$_POST['fchVenceProrrogaLicConstruccion'];
		$claProyecto->numResolRevalidacionLicConstruccion = 		$_POST['numResolRevalidacionLicConstruccion'];
		$claProyecto->txtObsNumResolRevalidacionLicConstruccion = 	$_POST['txtObsNumResolRevalidacionLicConstruccion'];
		$claProyecto->fchEjecutaRevalidacionLicConstruccion = 		$_POST['fchEjecutaRevalidacionLicConstruccion'];
		$claProyecto->fchVenceRevalidacionLicConstruccion = 		$_POST['fchVenceRevalidacionLicConstruccion'];

		// CRONOGRAMA OBRAS
		$claProyecto->fchInicialTerreno = $_POST['fchInicialTerreno'];
		$claProyecto->fchFinalTerreno = $_POST['fchFinalTerreno'];
		$claProyecto->porcIncTerreno = $_POST['porcIncTerreno'];
		$claProyecto->valActTerreno = $_POST['valActTerreno'];
		$claProyecto->fchInicialPreliminarConstruccion = $_POST['fchInicialPreliminarConstruccion'];
		$claProyecto->fchFinalPreliminarConstruccion = $_POST['fchFinalPreliminarConstruccion'];
		$claProyecto->porcIncPreliminarConstruccion = $_POST['porcIncPreliminarConstruccion'];
		$claProyecto->valActPreliminarConstruccion = $_POST['valActPreliminarConstruccion'];
		$claProyecto->fchInicialCimentacionConstruccion = $_POST['fchInicialCimentacionConstruccion'];
		$claProyecto->fchFinalCimentacionConstruccion = $_POST['fchFinalCimentacionConstruccion'];
		$claProyecto->porcIncCimentacionConstruccion = $_POST['porcIncCimentacionConstruccion'];
		$claProyecto->valActCimentacionConstruccion = $_POST['valActCimentacionConstruccion'];
		$claProyecto->fchInicialDesaguesConstruccion = $_POST['fchInicialDesaguesConstruccion'];
		$claProyecto->fchFinalDesaguesConstruccion = $_POST['fchFinalDesaguesConstruccion'];
		$claProyecto->porcIncDesaguesConstruccion = $_POST['porcIncDesaguesConstruccion'];
		$claProyecto->valActDesaguesConstruccion = $_POST['valActDesaguesConstruccion'];
		$claProyecto->fchInicialEstructuraConstruccion = $_POST['fchInicialEstructuraConstruccion'];
		$claProyecto->fchFinalEstructuraConstruccion = $_POST['fchFinalEstructuraConstruccion'];
		$claProyecto->porcIncEstructuraConstruccion = $_POST['porcIncEstructuraConstruccion'];
		$claProyecto->valActEstructuraConstruccion = $_POST['valActEstructuraConstruccion'];
		$claProyecto->fchInicialMamposteriaConstruccion = $_POST['fchInicialMamposteriaConstruccion'];
		$claProyecto->fchFinalMamposteriaConstruccion = $_POST['fchFinalMamposteriaConstruccion'];
		$claProyecto->porcIncMamposteriaConstruccion = $_POST['porcIncMamposteriaConstruccion'];
		$claProyecto->valActMamposteriaConstruccion = $_POST['valActMamposteriaConstruccion'];
		$claProyecto->fchInicialPanetesConstruccion = $_POST['fchInicialPanetesConstruccion'];
		$claProyecto->fchFinalPanetesConstruccion = $_POST['fchFinalPanetesConstruccion'];
		$claProyecto->porcIncPanetesConstruccion = $_POST['porcIncPanetesConstruccion'];
		$claProyecto->valActPanetesConstruccion = $_POST['valActPanetesConstruccion'];
		$claProyecto->fchInicialHidrosanitariasConstruccion = $_POST['fchInicialHidrosanitariasConstruccion'];
		$claProyecto->fchFinalHidrosanitariasConstruccion = $_POST['fchFinalHidrosanitariasConstruccion'];
		$claProyecto->porcIncHidrosanitariasConstruccion = $_POST['porcIncHidrosanitariasConstruccion'];
		$claProyecto->valActHidrosanitariasConstruccion = $_POST['valActHidrosanitariasConstruccion'];
		$claProyecto->fchInicialElectricasConstruccion = $_POST['fchInicialElectricasConstruccion'];
		$claProyecto->fchFinalElectricasConstruccion = $_POST['fchFinalElectricasConstruccion'];
		$claProyecto->porcIncElectricasConstruccion = $_POST['porcIncElectricasConstruccion'];
		$claProyecto->valActElectricasConstruccion = $_POST['valActElectricasConstruccion'];
		$claProyecto->fchInicialCubiertaConstruccion = $_POST['fchInicialCubiertaConstruccion'];
		$claProyecto->fchFinalCubiertaConstruccion = $_POST['fchFinalCubiertaConstruccion'];
		$claProyecto->porcIncCubiertaConstruccion = $_POST['porcIncCubiertaConstruccion'];
		$claProyecto->valActCubiertaConstruccion = $_POST['valActCubiertaConstruccion'];
		$claProyecto->fchInicialCarpinteriaConstruccion = $_POST['fchInicialCarpinteriaConstruccion'];
		$claProyecto->fchFinalCarpinteriaConstruccion = $_POST['fchFinalCarpinteriaConstruccion'];
		$claProyecto->porcIncCarpinteriaConstruccion = $_POST['porcIncCarpinteriaConstruccion'];
		$claProyecto->valActCarpinteriaConstruccion = $_POST['valActCarpinteriaConstruccion'];
		$claProyecto->fchInicialPisosConstruccion = $_POST['fchInicialPisosConstruccion'];
		$claProyecto->fchFinalPisosConstruccion = $_POST['fchFinalPisosConstruccion'];
		$claProyecto->porcIncPisosConstruccion = $_POST['porcIncPisosConstruccion'];
		$claProyecto->valActPisosConstruccion = $_POST['valActPisosConstruccion'];
		$claProyecto->fchInicialSanitariosConstruccion = $_POST['fchInicialSanitariosConstruccion'];
		$claProyecto->fchFinalSanitariosConstruccion = $_POST['fchFinalSanitariosConstruccion'];
		$claProyecto->porcIncSanitariosConstruccion = $_POST['porcIncSanitariosConstruccion'];
		$claProyecto->valActSanitariosConstruccion = $_POST['valActSanitariosConstruccion'];
		$claProyecto->fchInicialExterioresConstruccion = $_POST['fchInicialExterioresConstruccion'];
		$claProyecto->fchFinalExterioresConstruccion = $_POST['fchFinalExterioresConstruccion'];
		$claProyecto->porcIncExterioresConstruccion = $_POST['porcIncExterioresConstruccion'];
		$claProyecto->valActExterioresConstruccion = $_POST['valActExterioresConstruccion'];
		$claProyecto->fchInicialAseoConstruccion = $_POST['fchInicialAseoConstruccion'];
		$claProyecto->fchFinalAseoConstruccion = $_POST['fchFinalAseoConstruccion'];
		$claProyecto->porcIncAseoConstruccion = $_POST['porcIncAseoConstruccion'];
		$claProyecto->valActAseoConstruccion = $_POST['valActAseoConstruccion'];
		$claProyecto->fchInicialPreliminarUrbanismo = $_POST['fchInicialPreliminarUrbanismo'];
		$claProyecto->fchFinalPreliminarUrbanismo = $_POST['fchFinalPreliminarUrbanismo'];
		$claProyecto->porcIncPreliminarUrbanismo = $_POST['porcIncPreliminarUrbanismo'];
		$claProyecto->valActPreliminarUrbanismo = $_POST['valActPreliminarUrbanismo'];
		$claProyecto->fchInicialCimentacionUrbanismo = $_POST['fchInicialCimentacionUrbanismo'];
		$claProyecto->fchFinalCimentacionUrbanismo = $_POST['fchFinalCimentacionUrbanismo'];
		$claProyecto->porcIncCimentacionUrbanismo = $_POST['porcIncCimentacionUrbanismo'];
		$claProyecto->valActCimentacionUrbanismo = $_POST['valActCimentacionUrbanismo'];
		$claProyecto->fchInicialDesaguesUrbanismo = $_POST['fchInicialDesaguesUrbanismo'];
		$claProyecto->fchFinalDesaguesUrbanismo = $_POST['fchFinalDesaguesUrbanismo'];
		$claProyecto->porcIncDesaguesUrbanismo = $_POST['porcIncDesaguesUrbanismo'];
		$claProyecto->valActDesaguesUrbanismo = $_POST['valActDesaguesUrbanismo'];
		$claProyecto->fchInicialViasUrbanismo = $_POST['fchInicialViasUrbanismo'];
		$claProyecto->fchFinalViasUrbanismo = $_POST['fchFinalViasUrbanismo'];
		$claProyecto->porcIncViasUrbanismo = $_POST['porcIncViasUrbanismo'];
		$claProyecto->valActViasUrbanismo = $_POST['valActViasUrbanismo'];
		$claProyecto->fchInicialParquesUrbanismo = $_POST['fchInicialParquesUrbanismo'];
		$claProyecto->fchFinalParquesUrbanismo = $_POST['fchFinalParquesUrbanismo'];
		$claProyecto->porcIncParquesUrbanismo = $_POST['porcIncParquesUrbanismo'];
		$claProyecto->valActParquesUrbanismo = $_POST['valActParquesUrbanismo'];
		$claProyecto->fchInicialAseoUrbanismo = $_POST['fchInicialAseoUrbanismo'];
		$claProyecto->fchFinalAseoUrbanismo = $_POST['fchFinalAseoUrbanismo'];
		$claProyecto->porcIncAseoUrbanismo = $_POST['porcIncAseoUrbanismo'];
		$claProyecto->valActAseoUrbanismo = $_POST['valActAseoUrbanismo'];
		$claProyecto->fchInicialLicenciaUrbanismo = $_POST['fchInicialLicenciaUrbanismo'];
		$claProyecto->fchFinalLicenciaUrbanismo = $_POST['fchFinalLicenciaUrbanismo'];
		$claProyecto->fchInicialLicenciaConstruccion = $_POST['fchInicialLicenciaConstruccion'];
		$claProyecto->fchFinalLicenciaConstruccion = $_POST['fchFinalLicenciaConstruccion'];
		$claProyecto->fchInicialVentasProyecto = $_POST['fchInicialVentasProyecto'];
		$claProyecto->fchFinalVentasProyecto = $_POST['fchFinalVentasProyecto'];
		$claProyecto->numViviendaVentasProyecto = $_POST['numViviendaVentasProyecto'];
		$claProyecto->fchInicialEntregaEscrituracionVivienda = $_POST['fchInicialEntregaEscrituracionVivienda'];
		$claProyecto->fchFinalEntregaEscrituracionVivienda = $_POST['fchFinalEntregaEscrituracionVivienda'];
		$claProyecto->numViviendaEntregaEscrituracionVivienda = $_POST['numViviendaEntregaEscrituracionVivienda'];
		$claProyecto->txtDescripcionHitos = $_POST['txtDescripcionHitos'];

		//$claProyecto->ingresarTipoVivienda($seqProyecto, $_POST['txtNombreTipoVivienda']);
		//$claProyecto->ingresarCronogramaFecha($seqProyecto, $_POST['txtActaDescriptiva']);
		//$claProyecto->ingresarConjuntoResidencial($seqProyecto, $_POST['txtNombreProyectoHijo'], $_POST['txtMatriculaInmobiliariaLote'], $_POST['txtChipLote'], $_POST['seqTutorProyecto']);
		//$claProyecto->ingresarActividadCronograma($seqProyecto, $_POST['txtNombreActividad']);
		$claProyecto->ingresarSeguimientoCronograma($seqProyecto, $_POST['fchVisita']);
		$claProyecto->editarItemsCronogramaObras($seqProyecto);

		$claProyecto->seqTutorProyecto =	 			$_POST['seqTutorProyecto'];
		$claProyecto->seqPryEstadoProceso = 			$_POST['seqPryEstadoProceso'];
		$claProyecto->bolActivo = 						$_POST['bolActivo'];
		$claProyecto->fchUltimaActualizacion = 			$_POST['fchUltimaActualizacion'];

		$claProyecto->editarProyectoVivienda($seqProyecto);
		//$claProyecto->ingresarTiposModulosProyecto($seqProyecto, $seqTipoModulo);

	/*} else {
		$arrErrores = $claCiudadano->arrErrores;
	}*/

	/********************************************************************************************************************
	* CALCULO DE LOS CAMBIOS DEL FORMULARIO
	******************************************************************************************************************* */

	/*$claProyectoCambios->arrProyectoVivienda = $arrHogarAnterior;
	$claProyecto->arrProyectoVivienda = $arrHogarNuevo;*/

	$claSeguimientoProyectos = new SeguimientoProyectos;
	$txtCambios = $claSeguimientoProyectos->cambiosPostulacion($_POST['seqProyectoEditar'], $claProyectoCambios, $claProyecto);

	/*echo "seqProyectoEditar: " . $_POST['seqProyectoEditar'] . "<br>";
	pr ($claProyectoCambios);
	echo "<br>";
	pr ($claProyecto);
	echo "<br>";
	print_r ($txtcambios);*/

	$_POST['seqGestion'] = ( $_POST['seqGestion'] == "" ) ? 17 : $_POST['seqGestion'];

	$sql = "
			INSERT INTO T_SEG_SEGUIMIENTO_PROYECTOS (
				seqProyecto,
				fchMovimiento,
				seqUsuario,
				txtComentario,
				txtCambios,
				seqGestion,
				bolMostrar
			) VALUES (
				$seqProyecto,
				now(),
				" . $_SESSION['seqUsuario'] . ",
				\"" . ereg_replace("\n", "", $_POST['txtComentario']) . "\",
				\"" . ereg_replace("\"", "", $txtCambios) . "\",
				" . $_POST['seqGestion'] . ",
				1
			)
		";
		//echo "SEGUIMIENTO ACTUALIZACION: ". $sql;

	try {
		$aptBd->execute($sql);
		$seqSeguimiento = $aptBd->Insert_ID();
	} catch (Exception $objError) {
		$arrErrores[] = "El Proyecto se ha salvado pero no ha quedado registro de la actividad";
	}
} // fin if errores vacios

/* * *********************************************************************************************************************
 * IMPRESION DE LOS MENSAJES
 * ******************************************************************************************************************** */
if (empty($arrErrores)) {
	$arrMensajes[] = "El formulario se ha actualizado, Proyecto [ " . strtoupper($_POST['txtNombreProyecto']) . " ].<br>" . "El numero de registro es " . number_format($seqSeguimiento, 0, ".", ",") . ". Conserve este numero para referencia futura";

	$txtEstilo = "msgOk";
} else {
	$arrMensajes = $arrErrores;
	$txtEstilo = "msgError";
}

echo "<table cellpadding='0' cellspacing='0' border='0' width='100%' id='tablaMensajes' style='padding:5px'>";

if (!empty($arrNotificaciones)) {
	foreach ($arrNotificaciones as $txtMensaje) {
		echo "<tr><td class='msgAlerta'><li>$txtMensaje</li></td></tr>";
	}
}

foreach ($arrMensajes as $txtMensaje) {
	echo "<tr><td class='$txtEstilo'><li>$txtMensaje</li></td></tr>";
}
echo "</table>";
?>