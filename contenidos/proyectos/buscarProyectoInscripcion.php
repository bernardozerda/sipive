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
//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoProyectos.class.php" );


	$arrGrupoGestion				= array();	// Tipos de Gestión
	// Arreglos de Proyecto
	$arrTipoEsquema 				= array();	// Tipos de Esquema
	$arrPryTipoModalidad 			= array();	// Tipos de Modalidad
	$arrOpv 						= array();	// Lista de Opv's
	//$arrTipoOrganizacion 			= array();	// Tipos de Organizacion
	$arrTipoOperador 				= array();	// Tipos de Operador
	//$arrOferente					= array();	// Lista de Oferentes
	$arrTipoProyecto 				= array();	// Tipos de Proyecto
	$arrTipoUrbanizacion 			= array();	// Tipos de Urbanizacion
	$arrConstructor 				= array();	// lista de Constructores
	$arrTipoSolucion 				= array();	// Tipos de Solucion
	$arrTipoDocumento 				= array();	// Tipos de Documento
	$arrLocalidad 					= array();	// Lista de Localidades
	$arrEstadosProceso				= array();	// Lista de Estados del proceso
	$arrFiducuaria					= array();	// Lista de Fiduciarias
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

	// Tipos de Organizacion
	/*$sql = "SELECT
				seqTipoOrganizacion,
				txtTipoOrganizacion
			FROM
				T_PRY_TIPO_ORGANIZACION
			WHERE
				estado = 1
			ORDER BY
				txtTipoOrganizacion
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrTipoOrganizacion[$objRes->fields['seqTipoOrganizacion']] = $objRes->fields['txtTipoOrganizacion'];
		$objRes->MoveNext();
	}*/

	// Lista de Oferentes
	/*$sql = "SELECT
				seqOferente,
				txtNombreOferente
			FROM
				T_PRY_OFERENTE
			WHERE
				bolActivo = 1
			ORDER BY
				txtNombreOferente
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrOferente[$objRes->fields['seqOferente']] = $objRes->fields['txtNombreOferente'];
		$objRes->MoveNext();
	}*/

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

	/*************************************************************************************/
	//echo "RecordCount: ".$objRes->RecordCount()."<BR>";
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ProyectoVivienda.class.php" );
	$txtPlantilla = "proyectos/inscripcion.tpl";
	/*if ($objRes->RecordCount() == 0) { // NUEVO PROYECTO
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
		if ( $objRes->fields['seqPryEstadoProceso'] == "1" || $objRes->fields['seqPryEstadoProceso'] == "2") {
			$txtPlantilla = "proyectos/actualizacion.tpl";
		} else if ($objRes->fields['seqPryEstadoProceso'] == "3") {
			$txtPlantilla = "proyectos/elegibilidad.tpl";
		} else if ($objRes->fields['seqPryEstadoProceso'] == "4") {
			$txtPlantilla = "proyectos/desembolso.tpl";
		}
	}*/

	if ($seqFormulario != "") {
		$claSeguimientoProyectos = new SeguimientoProyectos;
		$claSeguimientoProyectos->seqProyecto = $seqProyecto;
		$arrRegistros = $claSeguimientoProyectos->obtenerRegistros(100);
	}

	//$claFormulario = new FormularioSubsidios;
	//$txtActosAdministrativosJs = $claFormulario->obtenerActosAdministrativos();

	$claSmarty->assign("valSalarioMinimo", 				$arrConfiguracion['constantes']['salarioMinimo'] );
	$claSmarty->assign("numSubsidios", 					26);
	$claSmarty->assign("numNitProyecto", 				$_POST['nit']);
	$claSmarty->assign("objFormularioProyecto", 		$arrProyectos[$seqProyecto]);

	$claSmarty->assign("arrTipoEsquema", 				$arrTipoEsquema);
	$claSmarty->assign("arrPryTipoModalidad",			$arrPryTipoModalidad);
	$claSmarty->assign("arrOpv", 						$arrOpv);
	//$claSmarty->assign("arrTipoOrganizacion", 			$arrTipoOrganizacion);
	//$claSmarty->assign("arrOferente", 					$arrOferente);
	$claSmarty->assign("arrTipoProyecto", 				$arrTipoProyecto);
	$claSmarty->assign("arrTipoUrbanizacion", 			$arrTipoUrbanizacion);
	$claSmarty->assign("arrConstructor", 				$arrConstructor);
	$claSmarty->assign("arrTipoSolucion", 				$arrTipoSolucion);
	$claSmarty->assign("arrTipoDocumento", 				$arrTipoDocumento);
	$claSmarty->assign("arrLocalidad", 					$arrLocalidad);
	$claSmarty->assign("arrEstadosProceso", 			$arrEstadosProceso);
	$claSmarty->assign("arrTipoModalidadDesembolso", 	$arrTipoModalidadDesembolso);
	$claSmarty->assign("arrFiduciaria", 				$arrFiduciaria);
	$claSmarty->assign("arrTipoCuenta", 				$arrTipoCuenta);
	$claSmarty->assign("arrTutorProyecto", 				$arrTutorProyecto);
	// Otros Arreglos
	$claSmarty->assign("seqUsuario", 					$_SESSION['seqUsuario']);
	$claSmarty->assign("arrGrupos", 					$_SESSION['arrGrupos']);
	$claSmarty->assign("arrGrupoGestion", 				$arrGrupoGestion);
	$claSmarty->assign("arrPrivilegios", 				$_SESSION['privilegios']);

	if ($txtPlantilla != "") {
		$claSmarty->display($txtPlantilla);
	}

?>