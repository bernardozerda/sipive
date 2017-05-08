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
// ==================================================== DATOS DE LOS RADICADOS ==============================================================
/*
// Validacion del Número de Radicado Jurídico
if( ( ! isset( $_POST['numRadicadoJuridico'] ) ) or (trim( $_POST['numRadicadoJuridico'] ) == "") or (trim( $_POST['numRadicadoJuridico'] ) == 0 ) ){
	$arrErrores[] = "Debe diligenciar el campo N&uacute;mero de Radicado Jur&iacute;dico";
}

// Validacion del Número de Radicado Técnico
if( ( ! isset( $_POST['numRadicadoTecnico'] ) ) or (trim( $_POST['numRadicadoTecnico'] ) == "") or (trim( $_POST['numRadicadoTecnico'] ) == 0 ) ){
	$arrErrores[] = "Debe diligenciar el campo N&uacute;mero de Radicado T&eacute;cnico";
}

// Validacion del Número de Radicado Financiero
if( ( ! isset( $_POST['numRadicadoFinanciero'] ) ) or (trim( $_POST['numRadicadoFinanciero'] ) == "") or (trim( $_POST['numRadicadoFinanciero'] ) == 0 ) ){
	$arrErrores[] = "Debe diligenciar el campo N&uacute;mero de Radicado Financiero";
}*/

// =================================================== DATOS DEL DESEMBOLSO ================================================================

// Si hay correo electronico debe ser valido
	/*if( $_POST['txtCorreoVendedor'] != "" ){
		if( ! ereg( "^[0-9a-zA-Z._\-]+\@[a-zA-Z0-9._\-]+\.([a-zA-z]{2,4})(([\.]{1})([a-zA-Z]{2}))?$" , trim( $_POST['txtCorreoVendedor'] ) ) ){
			$arrErrores[] = "No es un correo electr&oacute;nico v&aacute;lido";
		}
	}*/

// Carga el formulario anteior para validacion del tipo de documento
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

	// si no hay errores salva los datos del formulario
	//if (empty($claCiudadano->arrErrores)) {
		$claProyecto = new ProyectoVivienda;

		$claProyecto->numNitProyecto = 					$_POST['numNitProyecto'];
		$claProyecto->txtNombreProyecto = 				strtoupper($_POST['txtNombreProyecto']);
		$claProyecto->txtNombrePlanParcial = 			strtoupper($_POST['txtNombrePlanParcial']);
		$claProyecto->seqTipoEsquema = 					$_POST['seqTipoEsquema'];
		$claProyecto->seqPryTipoModalidad = 			$_POST['seqPryTipoModalidad'];
		$claProyecto->txtNombreOperador = 				$_POST['txtNombreOperador'];
		$claProyecto->txtObjetoProyecto = 				$_POST['txtObjetoProyecto'];
		$claProyecto->txtOtrosBarrios = 				$_POST['txtOtrosBarrios'];
		$claProyecto->seqOpv = 							$_POST['seqOpv'];
		$claProyecto->seqTipoProyecto = 				$_POST['seqTipoProyecto'];
		$claProyecto->seqTipoUrbanizacion = 			$_POST['seqTipoUrbanizacion'];
		$claProyecto->seqTipoSolucion = 				$_POST['seqTipoSolucion'];
		$claProyecto->txtDescripcionProyecto = 			$_POST['txtDescripcionProyecto'];
		$claProyecto->bolDireccion =	 				$_POST['bolDireccion'];
		$claProyecto->txtDireccion =		 			$_POST['txtDireccion'];
		$claProyecto->seqLocalidad =		 			$_POST['seqLocalidad'];
		$claProyecto->valNumeroSoluciones = 			$_POST['valNumeroSoluciones'];
		$claProyecto->valAreaConstruida = 				$_POST['valAreaConstruida'];
		$claProyecto->valAreaLote = 					$_POST['valAreaLote'];
		$claProyecto->txtChipLote = 					$_POST['txtChipLote'];
		$claProyecto->txtRegistroEnajenacion =			$_POST['txtRegistroEnajenacion'];
		$claProyecto->bolEquipamientoComunal = 			$_POST['bolEquipamientoComunal'];
		$claProyecto->txtDescEquipamientoComunal = 		$_POST['txtDescEquipamientoComunal'];
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
		$claProyecto->txtCorreoRepresentanteLegalOferente =	$_POST['txtCorreoRepresentanteLegalOferente'];
		$claProyecto->bolConstructor = 					$_POST['bolConstructor'];
		$claProyecto->seqConstructor = 					$_POST['seqConstructor'];
		/*$claProyecto->valCostosDirectos = 			$_POST['valCostosDirectos'];
		$claProyecto->valCostosIndirectos = 			$_POST['valCostosIndirectos'];
		$claProyecto->valTerreno = 						$_POST['valTerreno'];
		$claProyecto->valGastosFinancieros = 			$_POST['valGastosFinancieros'];
		$claProyecto->valGastosVentas = 				$_POST['valGastosVentas'];
		$claProyecto->valTotalCostos = 					$_POST['valTotalCostos'];
		$claProyecto->valTotalVentas = 					$_POST['valTotalVentas'];
		$claProyecto->valCierreFinanciero = 			$_POST['valCierreFinanciero'];*/
		$claProyecto->txtLicenciaUrbanismo = 			$_POST['txtLicenciaUrbanismo'];
		$claProyecto->txtExpideLicenciaUrbanismo =		$_POST['txtExpideLicenciaUrbanismo'];
		$claProyecto->fchLicenciaUrbanismo1 = 			$_POST['fchLicenciaUrbanismo1'];
		$claProyecto->fchLicenciaUrbanismo2 = 			$_POST['fchLicenciaUrbanismo2'];
		$claProyecto->fchLicenciaUrbanismo3 = 			$_POST['fchLicenciaUrbanismo3'];
		$claProyecto->fchVigenciaLicenciaUrbanismo =	$_POST['fchVigenciaLicenciaUrbanismo'];
		$claProyecto->fchEjecutoriaLicenciaUrbanismo =	$_POST['fchEjecutoriaLicenciaUrbanismo'];
		$claProyecto->txtResEjecutoriaLicenciaUrbanismo = $_POST['txtResEjecutoriaLicenciaUrbanismo'];
		$claProyecto->txtLicenciaConstruccion = 		$_POST['txtLicenciaConstruccion'];
		$claProyecto->fchLicenciaConstruccion1 = 		$_POST['fchLicenciaConstruccion1'];
		$claProyecto->fchLicenciaConstruccion2 = 		$_POST['fchLicenciaConstruccion2'];
		$claProyecto->fchLicenciaConstruccion3 =		$_POST['fchLicenciaConstruccion3'];
		$claProyecto->fchVigenciaLicenciaConstruccion = $_POST['fchVigenciaLicenciaConstruccion'];
		$claProyecto->txtNombreVendedor =				$_POST['txtNombreVendedor'];
		$claProyecto->numNitVendedor = 					$_POST['numNitVendedor'];
		$claProyecto->txtCedulaCatastral =				$_POST['txtCedulaCatastral'];
		$claProyecto->txtEscritura = 					$_POST['txtEscritura'];
		$claProyecto->fchEscritura =					$_POST['fchEscritura'];
		$claProyecto->numNotaria =						$_POST['numNotaria'];
		$claProyecto->txtNombreInterventor = 			$_POST['txtNombreInterventor'];
		$claProyecto->bolTipoPersonaInterventor = 		$_POST['bolTipoPersonaInterventor'];
		$claProyecto->numCedulaInterventor = 			$_POST['numCedulaInterventor'];
		$claProyecto->numTProfesionalInterventor = 		$_POST['numTProfesionalInterventor'];
		$claProyecto->numNitInterventor =				$_POST['numNitInterventor'];

		$claProyecto->numRadicadoJuridico =				$_POST['numRadicadoJuridico'];
		$claProyecto->numRadicadoTecnico =				$_POST['numRadicadoTecnico'];
		$claProyecto->numRadicadoFinanciero =			$_POST['numRadicadoFinanciero'];
		$claProyecto->bolAprobacion =					$_POST['bolAprobacion'];
		$claProyecto->numActaAprobacion =				$_POST['numActaAprobacion'];
		$claProyecto->numResolucionAprobacion =			$_POST['numResolucionAprobacion'];
		$claProyecto->fchResolucionAprobacion =			$_POST['fchResolucionAprobacion'];
		$claProyecto->txtObservacionAprobacion =		$_POST['txtObservacionAprobacion'];

		$claProyecto->chkDocDesemConstructor1 =			$_POST['chkDocDesemConstructor1'];
		$claProyecto->txtDocDesemConstructor1 =			$_POST['txtDocDesemConstructor1'];
		$claProyecto->chkDocDesemConstructor2 =			$_POST['chkDocDesemConstructor2'];
		$claProyecto->txtDocDesemConstructor2 =			$_POST['txtDocDesemConstructor2'];
		$claProyecto->chkDocDesemConstructor3 =			$_POST['chkDocDesemConstructor3'];
		$claProyecto->txtDocDesemConstructor3 =			$_POST['txtDocDesemConstructor3'];
		$claProyecto->chkDocDesemConstructor4 =			$_POST['chkDocDesemConstructor4'];
		$claProyecto->txtDocDesemConstructor4 =			$_POST['txtDocDesemConstructor4'];
		$claProyecto->chkDocDesemConstructor5 =			$_POST['chkDocDesemConstructor5'];
		$claProyecto->txtDocDesemConstructor5 =			$_POST['txtDocDesemConstructor5'];
		$claProyecto->chkDocDesemEntidad1 =				$_POST['chkDocDesemEntidad1'];
		$claProyecto->txtDocDesemEntidad1 =				$_POST['txtDocDesemEntidad1'];
		$claProyecto->chkDocDesemEntidad2 =				$_POST['chkDocDesemEntidad2'];
		$claProyecto->txtDocDesemEntidad2 =				$_POST['txtDocDesemEntidad2'];
		$claProyecto->chkDocDesemEntidad3 =				$_POST['chkDocDesemEntidad3'];
		$claProyecto->txtDocDesemEntidad3 =				$_POST['txtDocDesemEntidad3'];
		$claProyecto->chkDocDesemEntidad4 =				$_POST['chkDocDesemEntidad4'];
		$claProyecto->txtDocDesemEntidad4 =				$_POST['txtDocDesemEntidad4'];
		$claProyecto->chkDocDesemEntidad5 =				$_POST['chkDocDesemEntidad5'];
		$claProyecto->txtDocDesemEntidad5 =				$_POST['txtDocDesemEntidad5'];
		$claProyecto->chkDocDesemEntidad6 =				$_POST['chkDocDesemEntidad6'];
		$claProyecto->txtDocDesemEntidad6 =				$_POST['txtDocDesemEntidad6'];
		$claProyecto->chkDocDesemEntidad7 =				$_POST['chkDocDesemEntidad7'];
		$claProyecto->txtDocDesemEntidad7 =				$_POST['txtDocDesemEntidad7'];
		$claProyecto->chkDocDesemEntidad8 =				$_POST['chkDocDesemEntidad8'];
		$claProyecto->txtDocDesemEntidad8 =				$_POST['txtDocDesemEntidad8'];
		$claProyecto->chkDocDesemEntidad9 =				$_POST['chkDocDesemEntidad9'];
		$claProyecto->txtDocDesemEntidad9 =				$_POST['txtDocDesemEntidad9'];
		$claProyecto->chkDocDesemProyecto1 =			$_POST['chkDocDesemProyecto1'];
		$claProyecto->txtDocDesemProyecto1 =			$_POST['txtDocDesemProyecto1'];
		$claProyecto->chkDocDesemProyecto2 =			$_POST['chkDocDesemProyecto2'];
		$claProyecto->txtDocDesemProyecto2 =			$_POST['txtDocDesemProyecto2'];
		$claProyecto->chkDocDesemProyecto3 =			$_POST['chkDocDesemProyecto3'];
		$claProyecto->txtDocDesemProyecto3 =			$_POST['txtDocDesemProyecto3'];
		$claProyecto->chkDocDesemProyecto4 =			$_POST['chkDocDesemProyecto4'];
		$claProyecto->txtDocDesemProyecto4 =			$_POST['txtDocDesemProyecto4'];
		$claProyecto->chkDocDesemProyecto5 =			$_POST['chkDocDesemProyecto5'];
		$claProyecto->txtDocDesemProyecto5 =			$_POST['txtDocDesemProyecto5'];
		$claProyecto->chkDocDesemProyecto6 =			$_POST['chkDocDesemProyecto6'];
		$claProyecto->txtDocDesemProyecto6 =			$_POST['txtDocDesemProyecto6'];
		$claProyecto->seqTipoModalidadDesembolso =		$_POST['seqTipoModalidadDesembolso'];

		//$claProyecto->ingresarActividadCronograma($seqProyecto, $_POST['txtNombreActividad']);
		//$claProyecto->ingresarSeguimientoActividad($seqProyecto, $_POST['unico']);
		$claProyecto->ingresarGiroDesembolsos($seqProyecto, $_POST['valNumeroPago']);
		
		$claProyecto->seqTutorProyecto =	 			$_POST['seqTutorProyecto'];
		$claProyecto->seqPryEstadoProceso = 			$_POST['seqPryEstadoProceso'];
		$claProyecto->bolActivo = 						$_POST['bolActivo'];
		$claProyecto->fchUltimaActualizacion = 			$_POST['fchUltimaActualizacion'];

		$claProyecto->editarProyectoVivienda($seqProyecto);
		$claProyecto->editarDocumentosDesembolsoProyecto($seqProyecto);

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