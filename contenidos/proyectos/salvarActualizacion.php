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
// =================================================== DATOS DEL PROYECTO =================================================================
// Validacion del Nombre de Proyecto
if( ( ! isset( $_POST['txtNombreProyecto'] ) ) or trim( $_POST['txtNombreProyecto'] ) == "" ){
	$arrErrores[] = "Debe diligenciar el campo Nombre del Proyecto";
}

// Validacion del Tipo de Esquema
if( ( ! isset( $_POST['seqTipoEsquema'] ) ) or trim( $_POST['seqTipoEsquema'] ) == 0 ){
	$arrErrores[] = "Debe seleccionar el Tipo de Esquema";
}

// Validacion de la OPV si el Tipo de Esquema es Colectivo OPV
if( $_POST['seqTipoEsquema'] == 2 ){
	if( ( ! isset( $_POST['seqOpv'] ) ) or trim( $_POST['seqOpv'] ) == 0 ){
		$arrErrores[] = "Debe seleccionar la OPV";
	}
}

// Validacion del Tipo de Modalidad
if( ( ! isset( $_POST['seqPryTipoModalidad'] ) ) or trim( $_POST['seqPryTipoModalidad'] ) == 0 ){
	$arrErrores[] = "Debe seleccionar el Tipo de Modalidad";
}

// Validacion si el Tipo de Esquema es Territorial Dirigido
if( $_POST['seqTipoEsquema'] == 4 ){
	// Validar Nombre del Operador
	if( ( ! isset( $_POST['txtNombreOperador'] ) ) or trim( $_POST['txtNombreOperador'] ) == "" ){
		$arrErrores[] = "Debe diligenciar el campo Nombre del Operador";
	}
	// Validar Objeto del Proyecto
	if( ( ! isset( $_POST['txtObjetoProyecto'] ) ) or trim( $_POST['txtObjetoProyecto'] ) == "" ){
		$arrErrores[] = "Debe diligenciar el objeto del proyecto";
	}
}

// SI EL ESQUEMA ES TERRITORIAL DIRIGIDO ESTOS CAMPOS NO SON OBLIGATORIOS
if($_POST['seqTipoEsquema'] != 4){
	// Validacion del Tipo de Proyecto
	if( ( ! isset( $_POST['seqTipoProyecto'] ) ) or trim( $_POST['seqTipoProyecto'] ) == 0 ){
		$arrErrores[] = "Debe seleccionar el Tipo de Proyecto";
	}

	// Validacion del Tipo de Urbanización
	if( ( ! isset( $_POST['seqTipoUrbanizacion'] ) ) or trim( $_POST['seqTipoUrbanizacion'] ) == 0 ){
		$arrErrores[] = "Debe seleccionar el Tipo de Urbanizaci&oacute;n";
	}

	// Validacion del Tipo de Solución
	if( ( ! isset( $_POST['seqTipoSolucion'] ) ) or trim( $_POST['seqTipoSolucion'] ) == 0 ){
		$arrErrores[] = "Debe seleccionar el Tipo de Soluci&oacute;n";
	}

	// Validacion del Area Construida
	if( ( ! isset( $_POST['valAreaConstruida'] ) ) or trim( $_POST['valAreaConstruida'] ) == "" ){
		$arrErrores[] = "Debe diligenciar el &Aacute;rea a construir";
	} else {
		if( $_POST['valAreaConstruida'] <= 0 ){
			$arrErrores[] = "El campo &Aacute;rea a construir debe ser mayor que cero";
		}
	}

	// Validacion del Chip del Lote
	if( ( ! isset( $_POST['txtChipLote'] ) ) or trim( $_POST['txtChipLote'] ) == "" ){
		$arrErrores[] = "Debe diligenciar el Chip del Lote";
	}

	// Validacion del Registro de Enajenación
	if( ( ! isset( $_POST['txtRegistroEnajenacion'] ) ) or trim( $_POST['txtRegistroEnajenacion'] ) == "" ){
		$arrErrores[] = "Debe diligenciar el Registro de Enajenaci&oacute;n";
	}

	// Validacion de Fecha de Registro de Enajenación
	if( ( ! isset( $_POST['fchRegistroEnajenacion'] ) ) or trim( $_POST['fchRegistroEnajenacion'] ) == "" ){
		$arrErrores[] = "Debe diligenciar la fecha del Registro de Enajenaci&oacute;n";
	}

	// Validacion de la Matricula Inmobiliaria del Lote
	if( ( ! isset( $_POST['txtMatriculaInmobiliariaLote'] ) ) or trim( $_POST['txtMatriculaInmobiliariaLote'] ) == "" ){
		$arrErrores[] = "Debe diligenciar la Matricula Inmobiliaria del Lote";
	}

	// Equipamiento Comunal
	if( $_POST['bolEquipamientoComunal'] == 1 ){
		if( ( ! isset( $_POST['txtDescEquipamientoComunal'] ) ) or trim( $_POST['txtDescEquipamientoComunal'] ) == "" ){
			$arrErrores[] = "Debe diligenciar la descripci&oacute;n del Equipamiento Comunal";
		}
	}
}

// Validacion de la Localidad
if( ( ! isset( $_POST['seqLocalidad'] ) ) or trim( $_POST['seqLocalidad'] ) == 0 ){
	$arrErrores[] = "Debe seleccionar la Localidad";
}

// Validacion de la Dirección
if ($_POST['bolDireccion'] == 1){
	if( ( ! isset( $_POST['txtDireccion'] ) ) or trim( $_POST['txtDireccion'] ) == "" ){
		$arrErrores[] = "Debe diligenciar el campo Direcci&oacute;n";
	}
}

// Validacion del Número de Soluciones
if( ( ! isset( $_POST['valNumeroSoluciones'] ) ) or trim( $_POST['valNumeroSoluciones'] ) == "" ){
	$arrErrores[] = "Debe diligenciar el N&uacute;mero de Soluciones";
}
if( $_POST['valNumeroSoluciones'] <= 0 ){
	$arrErrores[] = "El campo N&uacute;mero de Soluciones debe ser mayor que cero";
}

// =================================================== DATOS DEL OFERENTE =================================================================

// Validacion del Nombre del Oferente
if( ( ! isset( $_POST['txtNombreOferente'] ) ) or trim( $_POST['txtNombreOferente'] ) == "" ){
	$arrErrores[] = "Debe diligenciar el nombre del Oferente";
}

// Validacion del NIT del Oferente
if( ( ! isset( $_POST['numNitOferente'] ) ) or trim( $_POST['numNitOferente'] ) == "" ){
	$arrErrores[] = "Debe diligenciar el nit del Oferente";
}

// Validacion del NIT del Oferente
if( ( ! isset( $_POST['txtNombreContactoOferente'] ) ) or trim( $_POST['txtNombreContactoOferente'] ) == "" ){
	$arrErrores[] = "Debe diligenciar el nombre de contacto del Oferente";
}

$exregfijo = "/^[0-9]{7}$/";
$exregcel = "/^[3]{1}[0-9]{9}$/";
if ($_POST['numTelefonoOferente'] == "" and $_POST['numCelularOferente'] == "") {
	$arrErrores[] = "El Oferente debe tener un telefono de contacto";
} else {
	if ($_POST['numTelefonoOferente'] != "" && $_POST['numTelefonoOferente'] != 0) {
		if (!preg_match($exregfijo, $_POST['numTelefonoOferente'])) {
			$arrErrores[] = "El Numero Telefonico no puede ser menor ni mayor a 7 digitos";
		}
	}
	if ($_POST['numCelularOferente'] != "" && $_POST['numCelularOferente'] != 0) {
		if (!preg_match($exregcel, $_POST['numCelularOferente'])) {
			$arrErrores[] = "El Numero celular no puede ser menor ni mayor a 10 digitos y debe empezar por 3";
		}
	}
}

// Validacion del correo electronico del Oferente
if( trim( $_POST['txtCorreoOferente'] ) != "" ){
	if( ! ereg( "^[0-9a-zA-Z._\-]+\@[a-zA-Z0-9._\-]+\.([a-zA-z]{2,4})(([\.]{1})([a-zA-Z]{2}))?$" , trim( $_POST['txtCorreoOferente'] ) ) ){
		$arrErrores[] = "El correo electr&oacute;nico del oferente no es v&aacute;lido";
	}
}

// =========================================== DATOS DEL REPRESENTANTE LEGAL DEL OFERENTE =====================================================

// Validacion del correo electronico del representante legal del Oferente
if( trim( $_POST['txtCorreoRepresentanteLegalOferente'] ) != "" ){
	if( ! ereg( "^[0-9a-zA-Z._\-]+\@[a-zA-Z0-9._\-]+\.([a-zA-z]{2,4})(([\.]{1})([a-zA-Z]{2}))?$" , trim( $_POST['txtCorreoRepresentanteLegalOferente'] ) ) ){
		$arrErrores[] = "El correo electr&oacute;nico del Representante Legal del oferente no es v&aacute;lido";
	}
}

// Validacion del Constructor
/*if( $_POST['bolConstructor'] == 1 ){
	if( ( ! isset( $_POST['seqConstructor'] ) ) or trim( $_POST['seqConstructor'] ) == 0 ){
		$arrErrores[] = "Debe seleccionar el Constructor";
	}
}*/

// ============================================ DATOS DE LA LICENCIA DE URBANISMO =========================================================

// Validacion de la Licencia de Urbanismo
/*if( ( ! isset( $_POST['txtLicenciaUrbanismo'] ) ) or trim( $_POST['txtLicenciaUrbanismo'] ) == "" ){
	$arrErrores[] = "Debe diligenciar la Licencia de Urbanismo";
}*/

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
}

// Validacion del Tutor del Proyecto
if( ( ! isset( $_POST['seqTutorProyecto'] ) ) or trim( $_POST['seqTutorProyecto'] ) == 0 ){
	$arrErrores[] = "Debe seleccionar un tutor para el Proyecto";
}

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
		$claProyecto->numNitProyecto								= $_POST['numNitProyecto'];
		$claProyecto->txtNombreProyecto								= strtoupper($_POST['txtNombreProyecto']);
		$claProyecto->txtNombreComercial							= strtoupper($_POST['txtNombreComercial']);
		$claProyecto->txtNombrePlanParcial							= strtoupper($_POST['txtNombrePlanParcial']);
		$claProyecto->seqTipoEsquema								= $_POST['seqTipoEsquema'];
		$claProyecto->seqPryTipoModalidad							= $_POST['seqPryTipoModalidad'];
		$claProyecto->txtNombreOperador								= $_POST['txtNombreOperador'];
		$claProyecto->txtObjetoProyecto								= $_POST['txtObjetoProyecto'];
		$claProyecto->txtOtrosBarrios								= $_POST['txtOtrosBarrios'];
		$claProyecto->seqOpv										= $_POST['seqOpv'];
		$claProyecto->seqTipoProyecto								= $_POST['seqTipoProyecto'];
		$claProyecto->seqTipoUrbanizacion							= $_POST['seqTipoUrbanizacion'];
		$claProyecto->seqTipoSolucion								= $_POST['seqTipoSolucion'];
		$claProyecto->txtDescripcionProyecto						= $_POST['txtDescripcionProyecto'];
		$claProyecto->bolDireccion									= $_POST['bolDireccion'];
		$claProyecto->txtDireccion									= $_POST['txtDireccion'];
		$claProyecto->seqLocalidad									= $_POST['seqLocalidad'];
		$claProyecto->seqBarrio										= $_POST['seqBarrio'];
		$claProyecto->valTorres										= $_POST['valTorres'];
		$claProyecto->valNumeroSoluciones							= $_POST['valNumeroSoluciones'];
		$claProyecto->valAreaConstruida								= $_POST['valAreaConstruida'];
		$claProyecto->valAreaLote									= $_POST['valAreaLote'];
		$claProyecto->txtChipLote									= $_POST['txtChipLote'];
		$claProyecto->txtMatriculaInmobiliariaLote					= $_POST['txtMatriculaInmobiliariaLote'];
		$claProyecto->txtRegistroEnajenacion						= $_POST['txtRegistroEnajenacion'];
		$claProyecto->fchRegistroEnajenacion						= $_POST['fchRegistroEnajenacion'];
		$claProyecto->bolEquipamientoComunal						= $_POST['bolEquipamientoComunal'];
		$claProyecto->txtDescEquipamientoComunal					= $_POST['txtDescEquipamientoComunal'];
		$claProyecto->seqTipoModalidadDesembolso					= $_POST['seqTipoModalidadDesembolso'];
		$claProyecto->txtNombreOferente								= $_POST['txtNombreOferente'];
		$claProyecto->numNitOferente								= $_POST['numNitOferente'];
		$claProyecto->txtNombreContactoOferente						= $_POST['txtNombreContactoOferente'];
		$claProyecto->numTelefonoOferente							= $_POST['numTelefonoOferente'];
		$claProyecto->numExtensionOferente							= $_POST['numExtensionOferente'];
		$claProyecto->numCelularOferente							= $_POST['numCelularOferente'];
		$claProyecto->txtCorreoOferente								= $_POST['txtCorreoOferente'];
		$claProyecto->txtNombreOferente2							= $_POST['txtNombreOferente2'];
		$claProyecto->numNitOferente2								= $_POST['numNitOferente2'];
		$claProyecto->txtNombreContactoOferente2					= $_POST['txtNombreContactoOferente2'];
		$claProyecto->numTelefonoOferente2							= $_POST['numTelefonoOferente2'];
		$claProyecto->numExtensionOferente2							= $_POST['numExtensionOferente2'];
		$claProyecto->numCelularOferente2							= $_POST['numCelularOferente2'];
		$claProyecto->txtCorreoOferente2							= $_POST['txtCorreoOferente2'];
		$claProyecto->txtNombreOferente3							= $_POST['txtNombreOferente3'];
		$claProyecto->numNitOferente3								= $_POST['numNitOferente3'];
		$claProyecto->txtNombreContactoOferente3					= $_POST['txtNombreContactoOferente3'];
		$claProyecto->numTelefonoOferente3							= $_POST['numTelefonoOferente3'];
		$claProyecto->numExtensionOferente3							= $_POST['numExtensionOferente3'];
		$claProyecto->numCelularOferente3							= $_POST['numCelularOferente3'];
		$claProyecto->txtCorreoOferente3							= $_POST['txtCorreoOferente3'];
		$claProyecto->txtRepresentanteLegalOferente					= $_POST['txtRepresentanteLegalOferente'];
		$claProyecto->numNitRepresentanteLegalOferente				= $_POST['numNitRepresentanteLegalOferente'];
		$claProyecto->numTelefonoRepresentanteLegalOferente			= $_POST['numTelefonoRepresentanteLegalOferente'];
		$claProyecto->numExtensionRepresentanteLegalOferente		= $_POST['numExtensionRepresentanteLegalOferente'];
		$claProyecto->numCelularRepresentanteLegalOferente			= $_POST['numCelularRepresentanteLegalOferente'];
		$claProyecto->txtDireccionRepresentanteLegalOferente		= $_POST['txtDireccionRepresentanteLegalOferente'];
		$claProyecto->txtCorreoRepresentanteLegalOferente			= $_POST['txtCorreoRepresentanteLegalOferente'];
		$claProyecto->bolConstructor								= $_POST['bolConstructor'];
		$claProyecto->seqConstructor								= $_POST['seqConstructor'];
		$claProyecto->valCostosDirectos								= $_POST['valCostosDirectos'];
		$claProyecto->valCostosIndirectos							= $_POST['valCostosIndirectos'];
		$claProyecto->valTerreno									= $_POST['valTerreno'];
		$claProyecto->valGastosFinancieros							= $_POST['valGastosFinancieros'];
		$claProyecto->valGastosVentas								= $_POST['valGastosVentas'];
		$claProyecto->valTotalCostos								= $_POST['valTotalCostos'];
		$claProyecto->valTotalVentas								= $_POST['valTotalVentas'];
		$claProyecto->valUtilidadProyecto							= $_POST['valUtilidadProyecto'];
		$claProyecto->valRecursosPropios							= $_POST['valRecursosPropios'];
		$claProyecto->valCreditoEntidadFinanciera					= $_POST['valCreditoEntidadFinanciera'];
		$claProyecto->valCreditoParticulares						= $_POST['valCreditoParticulares'];
		$claProyecto->valVentasProyecto								= $_POST['valVentasProyecto'];
		$claProyecto->valSDVE										= $_POST['valSDVE'];
		$claProyecto->valOtros										= $_POST['valOtros'];
		$claProyecto->valDevolucionIVA								= $_POST['valDevolucionIVA'];
		$claProyecto->valTotalRecursos								= $_POST['valTotalRecursos'];
		$claProyecto->txtLicenciaUrbanismo							= $_POST['txtLicenciaUrbanismo'];
		$claProyecto->txtExpideLicenciaUrbanismo					= $_POST['txtExpideLicenciaUrbanismo'];
		$claProyecto->fchLicenciaUrbanismo1							= $_POST['fchLicenciaUrbanismo1'];
		$claProyecto->fchLicenciaUrbanismo2							= $_POST['fchLicenciaUrbanismo2'];
		$claProyecto->fchLicenciaUrbanismo3							= $_POST['fchLicenciaUrbanismo3'];
		$claProyecto->fchVigenciaLicenciaUrbanismo					= $_POST['fchVigenciaLicenciaUrbanismo'];
		$claProyecto->fchEjecutoriaLicenciaUrbanismo 				= $_POST['fchEjecutoriaLicenciaUrbanismo'];
		$claProyecto->txtResEjecutoriaLicenciaUrbanismo 			= $_POST['txtResEjecutoriaLicenciaUrbanismo'];
		$claProyecto->txtLicenciaConstruccion						= $_POST['txtLicenciaConstruccion'];
		$claProyecto->fchLicenciaConstruccion1						= $_POST['fchLicenciaConstruccion1'];
		$claProyecto->fchLicenciaConstruccion2						= $_POST['fchLicenciaConstruccion2'];
		$claProyecto->fchLicenciaConstruccion3						= $_POST['fchLicenciaConstruccion3'];
		$claProyecto->fchVigenciaLicenciaConstruccion				= $_POST['fchVigenciaLicenciaConstruccion'];
		$claProyecto->txtObsLicConstruccion							= $_POST['txtObsLicConstruccion'];
		$claProyecto->fchEjecutaLicConstruccion						= $_POST['fchEjecutaLicConstruccion'];
		$claProyecto->fchVenceLicConstruccion						= $_POST['fchVenceLicConstruccion'];
		$claProyecto->numResolProrrogaLicConstruccion				= $_POST['numResolProrrogaLicConstruccion'];
		$claProyecto->txtObsNumResolProrrogaLicConstruccion			= $_POST['txtObsNumResolProrrogaLicConstruccion'];
		$claProyecto->fchEjecutaProrrogaLicConstruccion				= $_POST['fchEjecutaProrrogaLicConstruccion'];
		$claProyecto->fchVenceProrrogaLicConstruccion				= $_POST['fchVenceProrrogaLicConstruccion'];
		$claProyecto->numResolRevalidacionLicConstruccion			= $_POST['numResolRevalidacionLicConstruccion'];
		$claProyecto->txtObsNumResolRevalidacionLicConstruccion		= $_POST['txtObsNumResolRevalidacionLicConstruccion'];
		$claProyecto->fchEjecutaRevalidacionLicConstruccion			= $_POST['fchEjecutaRevalidacionLicConstruccion'];
		$claProyecto->fchVenceRevalidacionLicConstruccion			= $_POST['fchVenceRevalidacionLicConstruccion'];
		$claProyecto->txtNombreVendedor								= $_POST['txtNombreVendedor'];
		$claProyecto->numNitVendedor								= $_POST['numNitVendedor'];
		$claProyecto->txtCedulaCatastral							= $_POST['txtCedulaCatastral'];
		$claProyecto->txtEscritura									= $_POST['txtEscritura'];
		$claProyecto->fchEscritura									= $_POST['fchEscritura'];
		$claProyecto->numNotaria									= $_POST['numNotaria'];
		$claProyecto->txtNombreInterventor							= $_POST['txtNombreInterventor'];
		$claProyecto->txtDireccionInterventor						= $_POST['txtDireccionInterventor'];
		$claProyecto->numTelefonoInterventor						= $_POST['numTelefonoInterventor'];
		$claProyecto->txtCorreoInterventor							= $_POST['txtCorreoInterventor'];
		$claProyecto->bolTipoPersonaInterventor						= $_POST['bolTipoPersonaInterventor'];
		$claProyecto->numCedulaInterventor							= $_POST['numCedulaInterventor'];
		$claProyecto->numTProfesionalInterventor					= $_POST['numTProfesionalInterventor'];
		$claProyecto->numNitInterventor								= $_POST['numNitInterventor'];
		$claProyecto->txtNombreRepLegalInterventor					= $_POST['txtNombreRepLegalInterventor'];
		$claProyecto->txtDireccionRepLegalInterventor				= $_POST['txtDireccionRepLegalInterventor'];
		$claProyecto->numTelefonoRepLegalInterventor				= $_POST['numTelefonoRepLegalInterventor'];
		$claProyecto->txtCorreoRepLegalInterventor					= $_POST['txtCorreoRepLegalInterventor'];

		$claProyecto->ingresarTipoVivienda($seqProyecto, $_POST['txtNombreTipoVivienda']);
		$claProyecto->ingresarCronogramaFecha($seqProyecto, $_POST['numActaDescriptiva']);
		$claProyecto->ingresarConjuntoResidencial($seqProyecto, $_POST['txtNombreProyectoHijo'], $_POST['seqTutorProyecto']);
		//$claProyecto->ingresarActividadCronograma($seqProyecto, $_POST['txtNombreActividad']);

		$claProyecto->seqTutorProyecto								= $_POST['seqTutorProyecto'];
		$claProyecto->seqPryEstadoProceso							= $_POST['seqPryEstadoProceso'];
		$claProyecto->bolActivo										= $_POST['bolActivo'];
		$claProyecto->fchUltimaActualizacion						= $_POST['fchUltimaActualizacion'];

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
	//echo $txtCambios;
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