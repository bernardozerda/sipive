<?php
/**
 * AQUI SE REALIZA LA BUSQUEDA DEL PROYECTO
 * @author Jaison Ospina
 * @version 1.0 Septiembre de 2013
 */
$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoProyectos.class.php" );

if (!isset($_POST['nit'])) {
	$arrListaProyectos		= array();	// Lista de Proyectos (Buscar)

	// Lista de Proyectos (Buscar)
	$sql = "
			SELECT
				seqProyecto,
				txtNombreProyecto
			FROM
				T_PRY_PROYECTO
			WHERE
				bolActivo = 1
			ORDER BY
				txtNombreProyecto
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrListaProyectos[$objRes->fields['seqProyecto']] = $objRes->fields['txtNombreProyecto'];
		$objRes->MoveNext();
		//echo $objRes->fields['seqProyecto'];
	}
	$claSmarty->assign("txtFuncion", "buscarProyecto('proyectos/buscarProyectoConsulta');");
	$claSmarty->assign("arrListaProyectos", $arrListaProyectos);
	$claSmarty->display("proyectos/buscarProyectoConsulta.tpl");

} else {

	$arrGrupoGestion				= array();	// Tipos de Gestión
	// Arreglos de Proyecto
	$arrTipoEsquema 				= array();	// Tipos de Esquema
	$arrPryTipoModalidad 			= array();	// Tipos de Modalidad
	$arrOpv 						= array();	// Lista de Opv's
	$arrTipoOperador 				= array();	// Tipos de Operador
	$arrTipoProyecto 				= array();	// Tipos de Proyecto
	$arrTipoUrbanizacion 			= array();	// Tipos de Urbanizacion
	$arrConstructor 				= array();	// lista de Constructores
	$arrTipoSolucion 				= array();	// Tipos de Solucion
	$arrTipoDocumento 				= array();	// Tipos de Documento
	$arrLocalidad 					= array();	// Lista de Localidades
	$arrBarrio						= array();	// Lista de Barrios
	$arrEstadosProceso				= array();	// Lista de Estados del proceso
	$arrFiduciaria					= array();	// Lista de Fiduciarias
	$arrTutorProyecto				= array();	// Lista de Tutores
	$arrBancos						= array();	// Lista de Bancos
	$arrTipoModalidadDesembolso		= array();	// Lista de Estados del proceso

	// GRUPO GESTION ADMINISTRADOR
	$arrGrupoGestionAdministrador[] = 15;
	$arrGrupoGestionAdministrador[] = 5;
	$arrGrupoGestionAdministrador[] = 10;
	$arrGrupoGestionAdministrador[] = 12;
	$arrGrupoGestionAdministrador[] = 17;
	$arrGrupoGestionAdministrador[] = 20;
	$arrGrupoGestionAdministrador[] = 14;

	// Grupos de gestion
	$sql = "
			SELECT
				seqGrupoGestion,
				txtGrupoGestion
			FROM
				T_SEG_GRUPO_GESTION_PROYECTOS
			WHERE
				seqGrupoGestion NOT IN (" . implode(',', $arrGrupoGestionAdministrador) . ")
			ORDER BY
				txtGrupoGestion
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrGrupoGestion[$objRes->fields['seqGrupoGestion']] = $objRes->fields['txtGrupoGestion'];
		$objRes->MoveNext();
	}

	// Tipos de Esquema
	$sql = "SELECT
				seqTipoEsquema,
				txtTipoEsquema
			FROM
				T_PRY_TIPO_ESQUEMA
			WHERE
				estado = 1
			ORDER BY
				txtTipoEsquema
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrTipoEsquema[$objRes->fields['seqTipoEsquema']] = $objRes->fields['txtTipoEsquema'];
		$objRes->MoveNext();
	}

	// Tipos de Modalidad
	$sql = "SELECT
				seqPryTipoModalidad,
				txtPryTipoModalidad
			FROM
				T_PRY_TIPO_MODALIDAD
			WHERE
				estado = 1
			ORDER BY
				txtPryTipoModalidad
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrPryTipoModalidad[$objRes->fields['seqPryTipoModalidad']] = $objRes->fields['txtPryTipoModalidad'];
		$objRes->MoveNext();
	}

	// Lista de Opv's
	$sql = "SELECT
				seqOpv,
				txtNombreOpv
			FROM
				T_PRY_OPV
			WHERE
				bolActivo = 1
			ORDER BY
				txtNombreOpv
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrOpv[$objRes->fields['seqOpv']] = $objRes->fields['txtNombreOpv'];
		$objRes->MoveNext();
	}

	// Tipos de Proyecto
	$sql = "SELECT
				seqTipoProyecto,
				txtTipoProyecto
			FROM
				T_PRY_TIPO_PROYECTO
			WHERE
				estado = 1
			ORDER BY
				txtTipoProyecto
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrTipoProyecto[$objRes->fields['seqTipoProyecto']] = $objRes->fields['txtTipoProyecto'];
		$objRes->MoveNext();
	}

	// Tipos de Urbanizacion
	$sql = "SELECT
				seqTipoUrbanizacion,
				txtTipoUrbanizacion
			FROM
				T_PRY_TIPO_URBANIZACION
			WHERE
				estado = 1
			ORDER BY
				txtTipoUrbanizacion
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrTipoUrbanizacion[$objRes->fields['seqTipoUrbanizacion']] = $objRes->fields['txtTipoUrbanizacion'];
		$objRes->MoveNext();
	}

	// Lista de Constructores
	$sql = "SELECT
				seqConstructor,
				txtNombreConstructor
			FROM
				T_PRY_CONSTRUCTOR
			WHERE
				bolActivo = 1
			ORDER BY
				txtNombreConstructor
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrConstructor[$objRes->fields['seqConstructor']] = $objRes->fields['txtNombreConstructor'];
		$objRes->MoveNext();
	}

	// Tipos de Solucion
	$sql = "SELECT
				seqTipoSolucion,
				txtTipoSolucion
			FROM
				T_PRY_TIPO_SOLUCION
			WHERE
				estado = 1
			ORDER BY
				seqTipoSolucion
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrTipoSolucion[$objRes->fields['seqTipoSolucion']] = $objRes->fields['txtTipoSolucion'];
		$objRes->MoveNext();
	}

	// Tipos de documento
	$sql = "
			SELECT
				seqTipoDocumento,
				txtTipoDocumento
			FROM
				T_CIU_TIPO_DOCUMENTO
			ORDER BY
				txtTipoDocumento
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrTipoDocumento[$objRes->fields['seqTipoDocumento']] = $objRes->fields['txtTipoDocumento'];
		$objRes->MoveNext();
	}

	// Lista de Localidades
	$sql = "
			SELECT
				seqLocalidad,
				txtLocalidad
			FROM
				T_FRM_LOCALIDAD
			ORDER BY
				seqLocalidad
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrLocalidad[$objRes->fields['seqLocalidad']] = $objRes->fields['txtLocalidad'];
		$objRes->MoveNext();
	}

	//Barrio
	$sql = "
		SELECT
			seqBarrio,
			txtBarrio
		FROM
			T_FRM_BARRIO
		ORDER BY
			txtBarrio
	";

	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrBarrio[ $objRes->fields['seqBarrio'] ] = $objRes->fields['txtBarrio'];
		$objRes->MoveNext();
	}

	// Tipos de Estado de Proceso
	$sql = "
			SELECT
				seqPryEstadoProceso,
				txtPryEstadoProceso
			FROM
				T_PRY_ESTADO_PROCESO
			ORDER BY
				seqPryEstadoProceso
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrEstadosProceso[$objRes->fields['seqPryEstadoProceso']] = $objRes->fields['txtPryEstadoProceso'];
		$objRes->MoveNext();
	}

	// Tipos de Modalidad de Desembolso
	$sql = "SELECT
				seqTipoModalidadDesembolso,
				txtTipoModalidadDesembolso
			FROM
				T_PRY_TIPO_MODALIDAD_DESEMBOLSO
			WHERE
				bolActivo = 1
			ORDER BY
				seqTipoModalidadDesembolso
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrTipoModalidadDesembolso[$objRes->fields['seqTipoModalidadDesembolso']] = $objRes->fields['txtTipoModalidadDesembolso'];
		$objRes->MoveNext();
	}

	// Lista de Fiduciarias
	$sql = "SELECT
				seqFiduciaria,
				txtNombreFiduciaria
			FROM
				T_PRY_FIDUCIARIA
			WHERE
				bolActivo = 1
			ORDER BY
				txtNombreFiduciaria
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrFiduciaria[$objRes->fields['seqFiduciaria']] = $objRes->fields['txtNombreFiduciaria'];
		$objRes->MoveNext();
	}

	// Lista de Bancos
	$sql = "SELECT
				seqBanco,
				txtBanco
			FROM
				T_FRM_BANCO
			ORDER BY
				txtBanco
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrBanco[$objRes->fields['seqBanco']] = $objRes->fields['txtBanco'];
		$objRes->MoveNext();
	}

	// Tipos de Cuenta
	$sql = "SELECT
				seqTipoCuenta,
				txtTipoCuenta
			FROM
				T_PRY_TIPO_CUENTA
			WHERE
				bolActivo = 1
			ORDER BY
				seqTipoCuenta
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrTipoCuenta[$objRes->fields['seqTipoCuenta']] = $objRes->fields['txtTipoCuenta'];
		$objRes->MoveNext();
	}

	// Profesional Responsable del Proyecto
	$sql = "SELECT
				seqProfesionalResponsable,
				txtProfesionalResponsable
			FROM
				T_PRY_PROFESIONAL_RESPONSABLE
			WHERE
				bolActivo = 1
			ORDER BY
				txtProfesionalResponsable
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrProfesionalResponsable[$objRes->fields['seqProfesionalResponsable']] = $objRes->fields['txtProfesionalResponsable'];
		$objRes->MoveNext();
	}

	//////////////////////////////////// DESDE AQUI (ARREGLOS QUE DEPENDEN SI EXISTE EL PROYECTO)
	if ($_POST['nit']){
		// Resoluciones de Proyecto
		$sql = "SELECT
					*
				FROM
					T_PRY_RESOLUCION_PROYECTO
				WHERE
					seqProyecto = ".$_POST['nit']."
				ORDER BY
					fchResolucionProyecto DESC
			";
			//echo $sql;
		$objRes = $aptBd->execute($sql);
		while ($objRes->fields) {
			$arrResolucionProyecto[$objRes->fields['seqResolucionProyecto']]['seqResolucionProyecto']	= $objRes->fields['seqResolucionProyecto'];
			$arrResolucionProyecto[$objRes->fields['seqResolucionProyecto']]['numResolucionProyecto']	= $objRes->fields['numResolucionProyecto'];
			$arrResolucionProyecto[$objRes->fields['seqResolucionProyecto']]['fchResolucionProyecto']	= $objRes->fields['fchResolucionProyecto'];
			$arrResolucionProyecto[$objRes->fields['seqResolucionProyecto']]['txtResuelve']				= $objRes->fields['txtResuelve'];
		$objRes->MoveNext();
		}

		// Actividades del Cronograma de Obra
		$sql = "SELECT
					*
				FROM
					T_PRY_ACTIVIDAD_CRONOGRAMA
				WHERE
					seqProyecto = ".$_POST['nit']."
				ORDER BY
					fchInicialActividad ASC, fchFinalActividad ASC
			";
			//echo $sql;
		$objRes = $aptBd->execute($sql);
		while ($objRes->fields) {
			$arrCronogramaProyecto[$objRes->fields['seqActividadCronograma']]['seqActividadCronograma']		= $objRes->fields['seqActividadCronograma'];
			$arrCronogramaProyecto[$objRes->fields['seqActividadCronograma']]['txtNombreActividad']			= $objRes->fields['txtNombreActividad'];
			$arrCronogramaProyecto[$objRes->fields['seqActividadCronograma']]['fchInicialActividad']		= $objRes->fields['fchInicialActividad'];
			$arrCronogramaProyecto[$objRes->fields['seqActividadCronograma']]['fchFinalActividad']			= $objRes->fields['fchFinalActividad'];
			$arrCronogramaProyecto[$objRes->fields['seqActividadCronograma']]['txtDescripcionActividad']	= $objRes->fields['txtDescripcionActividad'];
			$arrCronogramaProyecto[$objRes->fields['seqActividadCronograma']]['txtResponsableActividad']	= $objRes->fields['txtResponsableActividad'];
		$objRes->MoveNext();
		}

		// Actas del Proyecto
		$sql = "SELECT
					*
				FROM
					T_PRY_ACTA_PROYECTO
				WHERE
					seqProyecto = ".$_POST['nit']."
				ORDER BY
					fchActaProyecto DESC
			";
			//echo $sql;
		$objRes = $aptBd->execute($sql);
		while ($objRes->fields) {
			$arrActaProyecto[$objRes->fields['seqActaProyecto']]['seqActaProyecto'] = $objRes->fields['seqActaProyecto'];
			$arrActaProyecto[$objRes->fields['seqActaProyecto']]['numActaProyecto'] = $objRes->fields['numActaProyecto'];
			$arrActaProyecto[$objRes->fields['seqActaProyecto']]['fchActaProyecto'] = $objRes->fields['fchActaProyecto'];
			$arrActaProyecto[$objRes->fields['seqActaProyecto']]['txtEpigrafe'] = $objRes->fields['txtEpigrafe'];
		$objRes->MoveNext();
		}

		// Tipos de Vivienda (Estructura del Proyecto)
		$sql = "SELECT
					*
				FROM
					T_PRY_TIPO_VIVIENDA
				WHERE
					seqProyecto = ".$_POST['nit']."
				ORDER BY
					txtNombreTipoVivienda
			";
			//echo $sql;
		$objRes = $aptBd->execute($sql);
		while ($objRes->fields) {
			$arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['seqTipoVivienda']			= $objRes->fields['seqTipoVivienda'];
			$arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['txtNombreTipoVivienda']	= $objRes->fields['txtNombreTipoVivienda'];
			$arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['numCantidad'] 			= $objRes->fields['numCantidad'];
			$arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['numArea'] 				= $objRes->fields['numArea'];
			$arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['numAnoVenta'] 			= $objRes->fields['numAnoVenta'];
			$arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['valPrecioVenta'] 			= $objRes->fields['valPrecioVenta'];
			$arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['txtDescripcion'] 			= $objRes->fields['txtDescripcion'];
			$arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['valCierre'] 				= $objRes->fields['valCierre'];
		$objRes->MoveNext();
		}

		// Conjuntos Residenciales del Proyecto (Proyectos Hijo)
		$sql = "SELECT
					seqProyecto,
					seqProyectoPadre,
					txtNombreProyecto,
					txtDireccion,
					valNumeroSoluciones,
					txtChipLote,
					txtMatriculaInmobiliariaLote,
					txtLicenciaUrbanismo,
					fchLicenciaUrbanismo1,
					fchVigenciaLicenciaUrbanismo,
					txtExpideLicenciaUrbanismo,
					txtLicenciaConstruccion,
					fchLicenciaConstruccion1,
					fchVigenciaLicenciaConstruccion,
					txtNombreVendedor,
					numNitVendedor,
					txtCedulaCatastral,
					txtEscritura,
					fchEscritura,
					numNotaria,
					seqTutorProyecto,
					fchUltimaActualizacion
				FROM
					T_PRY_PROYECTO
				WHERE
					seqProyectoPadre = ".$_POST['nit']."
				ORDER BY
					seqProyectoPadre
			";

		$objRes = $aptBd->execute($sql);
		while ($objRes->fields) {
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['seqProyecto']						= $objRes->fields['seqProyecto'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['seqProyectoPadre']					= $objRes->fields['seqProyectoPadre'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtNombreProyecto'] 				= $objRes->fields['txtNombreProyecto'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtDireccion'] 					= $objRes->fields['txtDireccion'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['valNumeroSoluciones'] 				= $objRes->fields['valNumeroSoluciones'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtChipLote'] 						= $objRes->fields['txtChipLote'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtMatriculaInmobiliariaLote']		= $objRes->fields['txtMatriculaInmobiliariaLote'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtLicenciaUrbanismo']				= $objRes->fields['txtLicenciaUrbanismo'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['fchLicenciaUrbanismo1'] 			= $objRes->fields['fchLicenciaUrbanismo1'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['fchVigenciaLicenciaUrbanismo'] 	= $objRes->fields['fchVigenciaLicenciaUrbanismo'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtExpideLicenciaUrbanismo'] 		= $objRes->fields['txtExpideLicenciaUrbanismo'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtLicenciaConstruccion'] 			= $objRes->fields['txtLicenciaConstruccion'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['fchLicenciaConstruccion1'] 		= $objRes->fields['fchLicenciaConstruccion1'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['fchVigenciaLicenciaConstruccion'] 	= $objRes->fields['fchVigenciaLicenciaConstruccion'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtNombreVendedor'] 				= $objRes->fields['txtNombreVendedor'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['numNitVendedor'] 					= $objRes->fields['numNitVendedor'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtCedulaCatastral'] 				= $objRes->fields['txtCedulaCatastral'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtEscritura'] 					= $objRes->fields['txtEscritura'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['fchEscritura'] 					= $objRes->fields['fchEscritura'];
			$arrConjuntoResidencial[$objRes->fields['seqProyecto']]['numNotaria'] 						= $objRes->fields['numNotaria'];
		$objRes->MoveNext();
		}

		// Cronograma (Fechas)
		$sql = "SELECT
					*
				FROM
					T_PRY_CRONOGRAMA_FECHAS
				WHERE
					seqProyecto = ".$_POST['nit']."
				ORDER BY
					fchInicialProyecto
			";
			//echo $sql;
		$objRes = $aptBd->execute($sql);
		while ($objRes->fields) {
			$arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['seqCronogramaFecha']		= $objRes->fields['seqCronogramaFecha'];
			$arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['numActaDescriptiva']		= $objRes->fields['numActaDescriptiva'];
			$arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['numAnoActaDescriptiva']		= $objRes->fields['numAnoActaDescriptiva'];
			$arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchInicialProyecto']		= $objRes->fields['fchInicialProyecto'];
			$arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchFinalProyecto']			= $objRes->fields['fchFinalProyecto'];
			$arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['valPlazoEjecucion']			= $objRes->fields['valPlazoEjecucion'];
			$arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchInicialEntrega']			= $objRes->fields['fchInicialEntrega'];
			$arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchFinalEntrega']			= $objRes->fields['fchFinalEntrega'];
			$arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchInicialEscrituracion']	= $objRes->fields['fchInicialEscrituracion'];
			$arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchFinalEscrituracion']		= $objRes->fields['fchFinalEscrituracion'];
		$objRes->MoveNext();
		}

		// Seguimientos a las Actividades del Cronograma de Obra
		$sql = "SELECT
					*
				FROM
					T_PRY_SEGUIMIENTO_ACTIVIDAD
				WHERE
					seqProyecto = ".$_POST['nit']."
				ORDER BY
					fchSeguimientoActividad ASC
			";
			//echo $sql;
		$objRes = $aptBd->execute($sql);
		while ($objRes->fields) {
			$arrSeguimientoActividad[$objRes->fields['seqSeguimientoActividad']]['seqSeguimientoActividad'] 	= $objRes->fields['seqSeguimientoActividad'];
			$arrSeguimientoActividad[$objRes->fields['seqSeguimientoActividad']]['seqActividadCronograma'] 		= $objRes->fields['seqActividadCronograma'];
			$arrSeguimientoActividad[$objRes->fields['seqSeguimientoActividad']]['txtDescripcionSeguimiento'] 	= $objRes->fields['txtDescripcionSeguimiento'];
			$arrSeguimientoActividad[$objRes->fields['seqSeguimientoActividad']]['fchSeguimientoActividad'] 	= $objRes->fields['fchSeguimientoActividad'];
			$arrSeguimientoActividad[$objRes->fields['seqSeguimientoActividad']]['seqEstadoActividad'] 			= $objRes->fields['seqEstadoActividad'];
			$arrSeguimientoActividad[$objRes->fields['seqSeguimientoActividad']]['seqUsuario'] 					= $objRes->fields['seqUsuario'];
		$objRes->MoveNext();
		}

		// Actividades de Seguimiento (Combo a javascript)
		$sql = "SELECT
					seqActividadCronograma,
					txtNombreActividad
				FROM
					T_PRY_ACTIVIDAD_CRONOGRAMA
				WHERE
					seqProyecto = ".$_POST['nit']."
				ORDER BY
					txtNombreActividad
			";

		$optActividadesCronograma = "";
		$ejecutaActividadesCronograma = mysql_query($sql);
		while ($rowActividadesCronograma = mysql_fetch_array($ejecutaActividadesCronograma)){
			$optActividadesCronograma .= "<option value=" . $rowActividadesCronograma['seqActividadCronograma'] . ">" . $rowActividadesCronograma['txtNombreActividad']."</option>";
		}

		// Tutores del Proyecto
		$sql = "SELECT
					seqTutorProyecto,
					txtNombreTutor
				FROM
					T_PRY_TUTOR_PROYECTO
				WHERE
					bolActivo = 1
				ORDER BY
					txtNombreTutor
			";
		$objRes = $aptBd->execute($sql);
		while ($objRes->fields) {
			$arrTutorProyecto[$objRes->fields['seqTutorProyecto']] = $objRes->fields['txtNombreTutor'];
			$objRes->MoveNext();
		}
	} //////////////////////////////////// HASTA AQUI (ARREGLOS QUE DEPENDEN SI EXISTE EL PROYECTO)

	// VERIFICA SI EXISTE EL NIT DEL PROYECTO

	if ($_POST['nit']) {
		$sql = "SELECT
					seqProyecto,
					txtNombreProyecto,
					numNitProyecto,
					seqPryEstadoProceso
				FROM
					T_PRY_PROYECTO pry
				WHERE
					pry.seqProyecto = ".$_POST['nit']."
				";

		$objRes = $aptBd->execute($sql);

		/*************************************************************************************/
		//echo "RecordCount: ".$objRes->RecordCount()."<BR>";
		if ($objRes->RecordCount() == 0) { // NUEVO PROYECTO
			$txtPlantilla = "proyectos/inscripcion.tpl";
			include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ProyectoVivienda.class.php" );
			//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoProyectos.class.php" );
		} else { // PROYECTO EXISTENTE
			$seqProyecto = $objRes->fields['seqProyecto'];
			include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ProyectoVivienda.class.php" );
			//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoProyectos.class.php" );
			$objFormularioProyecto = new ProyectoVivienda;
			$arrProyectos = $objFormularioProyecto->cargarProyectoVivienda( $seqProyecto );
			$objProyectoVivienda = new ProyectoVivienda;
			$txtPlantilla = "proyectos/consulta.tpl";
		}

		if ($seqProyecto != "") {
			$claSeguimientoProyectos = new SeguimientoProyectos;
			$claSeguimientoProyectos->seqProyecto = $seqProyecto;
			$arrRegistros = $claSeguimientoProyectos->obtenerRegistros(100);
		}
		//pr($arrRegistros);

		//$claFormulario = new FormularioSubsidios;
		//$txtActosAdministrativosJs = $claFormulario->obtenerActosAdministrativos();

		$claSmarty->assign("valSalarioMinimo", 				$arrConfiguracion['constantes']['salarioMinimo'] );
		$claSmarty->assign("numSubsidios", 					26);
		$claSmarty->assign("numNitProyecto", 				$_POST['nit']);
		$claSmarty->assign("objFormularioProyecto", 		$arrProyectos[$seqProyecto]);
		$claSmarty->assign("arrRegistros" , 				$arrRegistros ); // Registros de seguimiento
		$claSmarty->assign("arrTipoEsquema", 				$arrTipoEsquema);
		$claSmarty->assign("arrPryTipoModalidad",			$arrPryTipoModalidad);
		$claSmarty->assign("arrOpv", 						$arrOpv);
		$claSmarty->assign("arrTipoProyecto", 				$arrTipoProyecto);
		$claSmarty->assign("arrTipoUrbanizacion", 			$arrTipoUrbanizacion);
		$claSmarty->assign("arrConstructor", 				$arrConstructor);
		$claSmarty->assign("arrTipoSolucion", 				$arrTipoSolucion);
		$claSmarty->assign("arrTipoDocumento", 				$arrTipoDocumento);
		$claSmarty->assign("arrLocalidad", 					$arrLocalidad);
		$claSmarty->assign("arrBarrio", 					$arrBarrio );
		$claSmarty->assign("arrEstadosProceso", 			$arrEstadosProceso);
		$claSmarty->assign("arrTipoModalidadDesembolso", 	$arrTipoModalidadDesembolso);
		$claSmarty->assign("arrFiduciaria", 				$arrFiduciaria);
		$claSmarty->assign("arrBanco", 						$arrBanco);
		$claSmarty->assign("arrTipoCuenta", 				$arrTipoCuenta);
		$claSmarty->assign("arrActaProyecto",				$arrActaProyecto);
		$claSmarty->assign("arrResolucionProyecto",			$arrResolucionProyecto);
		$claSmarty->assign("arrCronogramaProyecto",			$arrCronogramaProyecto);
		$claSmarty->assign("arrConjuntoResidencial",		$arrConjuntoResidencial);
		$claSmarty->assign("arrTipoVivienda",				$arrTipoVivienda);
		$claSmarty->assign("arrCronogramaFecha",			$arrCronogramaFecha);
		$claSmarty->assign("arrProfesionalResponsable", 	$arrProfesionalResponsable);
		$claSmarty->assign("optActividadesCronograma",		$optActividadesCronograma);
		$claSmarty->assign("arrSeguimientoActividad",		$arrSeguimientoActividad);
		$claSmarty->assign("arrTutorProyecto", 				$arrTutorProyecto);
		// Otros Arreglos
		$claSmarty->assign("arrGrupos", 					$_SESSION['arrGrupos']);
		$claSmarty->assign("arrGrupoGestion", 				$arrGrupoGestion);
		$claSmarty->assign("arrPrivilegios", 				$_SESSION['privilegios']);

		if ($txtPlantilla != "") {
			$claSmarty->display($txtPlantilla);
		}
	} else {
		echo "<br><p class='msgError'>NO EXISTE EL PROYECTO</p>";
	}
}
?>