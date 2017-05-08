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
	$claSmarty->assign("txtFuncion", "buscarProyecto('proyectos/buscarProyecto');");
	$claSmarty->assign("arrListaProyectos", $arrListaProyectos);
	$claSmarty->display("proyectos/buscarProyecto.tpl");

} else {

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
	// Tipos de Modalidad de Desembolso (Javascript)
	$optModalidadDesembolso = "";
	$ejecutaModalidadDesembolso = mysql_query($sql);
	while ($rowModalidadDesembolso = mysql_fetch_array($ejecutaModalidadDesembolso)){
		$optModalidadDesembolso .= "<option value=" . $rowModalidadDesembolso['seqTipoModalidadDesembolso'] . ">" . $rowModalidadDesembolso['txtTipoModalidadDesembolso']."</option>";
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
	// Bancos (Javascript)
	$optBanco = "";
	$ejecutaBanco = mysql_query($sql);
	while ($rowBanco = mysql_fetch_array($ejecutaBanco)){
		$optBanco .= "<option value=" . $rowBanco['seqBanco'] . ">" . $rowBanco['txtBanco']."</option>";
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
	// Tipos de Cuenta (Javascript)
	$optTipoCuenta = "";
	$ejecutaTipoCuenta = mysql_query($sql);
	while ($rowTipoCuenta = mysql_fetch_array($ejecutaTipoCuenta)){
		$optTipoCuenta .= "<option value=" . $rowTipoCuenta['seqTipoCuenta'] . ">" . $rowTipoCuenta['txtTipoCuenta']."</option>";
	}

	// ACTIVIDADES DE SEGUIMIENTO (TERRENO) (Combo a javascript)
	$sql = "SELECT
				seqActividadSeguimiento,
				txtActividadSeguimiento
			FROM
				T_PRY_ACTIVIDAD_SEGUIMIENTO
			WHERE
				seqGrupoActividadSeguimiento = 1
			AND
				bolActivo = 1
			ORDER BY
				seqActividadSeguimiento
		";
	// Combo para los que existen
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrActividadTerrenoExiste[$objRes->fields['seqActividadSeguimiento']] = $objRes->fields['txtActividadSeguimiento'];
		$objRes->MoveNext();
	}
	// Combo para llevar a javascript
	$optActividadSeguimientoTerreno = "";
	$ejecutaActividadSeguimientoTerreno = mysql_query($sql);
	while ($rowActividadSeguimientoTerreno = mysql_fetch_array($ejecutaActividadSeguimientoTerreno)){
		$optActividadSeguimientoTerreno .= "<option value=" . $rowActividadSeguimientoTerreno['seqActividadSeguimiento'] . ">" . $rowActividadSeguimientoTerreno['txtActividadSeguimiento']."</option>";
	}

	// ACTIVIDADES DE SEGUIMIENTO (Construccion) (Combo a javascript)
	$sql = "SELECT
				seqActividadSeguimiento,
				txtActividadSeguimiento
			FROM
				T_PRY_ACTIVIDAD_SEGUIMIENTO
			WHERE
				seqGrupoActividadSeguimiento = 2
			AND
				bolActivo = 1
			ORDER BY
				seqActividadSeguimiento
		";
	// Combo para los que existen
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrActividadConstruccionExiste[$objRes->fields['seqActividadSeguimiento']] = $objRes->fields['txtActividadSeguimiento'];
		$objRes->MoveNext();
	}
	// Combo para llevar a javascript
	$optActividadSeguimientoConstruccion = "";
	$ejecutaActividadSeguimientoConstruccion = mysql_query($sql);
	while ($rowActividadSeguimientoConstruccion = mysql_fetch_array($ejecutaActividadSeguimientoConstruccion)){
		$optActividadSeguimientoConstruccion .= "<option value=" . $rowActividadSeguimientoConstruccion['seqActividadSeguimiento'] . ">" . $rowActividadSeguimientoConstruccion['txtActividadSeguimiento']."</option>";
	}

	// ACTIVIDADES DE SEGUIMIENTO (Urbanizacion) (Combo a javascript)
	$sql = "SELECT
				seqActividadSeguimiento,
				txtActividadSeguimiento
			FROM
				T_PRY_ACTIVIDAD_SEGUIMIENTO
			WHERE
				seqGrupoActividadSeguimiento = 3
			AND
				bolActivo = 1
			ORDER BY
				seqActividadSeguimiento
		";
	// Combo para los que existen
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrActividadUrbanizacionExiste[$objRes->fields['seqActividadSeguimiento']] = $objRes->fields['txtActividadSeguimiento'];
		$objRes->MoveNext();
	}
	// Combo para llevar a javascript
	$optActividadSeguimientoUrbanizacion = "";
	$ejecutaActividadSeguimientoUrbanizacion = mysql_query($sql);
	while ($rowActividadSeguimientoUrbanizacion = mysql_fetch_array($ejecutaActividadSeguimientoUrbanizacion)){
		$optActividadSeguimientoUrbanizacion .= "<option value=" . $rowActividadSeguimientoUrbanizacion['seqActividadSeguimiento'] . ">" . $rowActividadSeguimientoUrbanizacion['txtActividadSeguimiento']."</option>";
	}

	// Estados de las Actividades de Seguimiento (Combo a javascript)
	$sql = "SELECT
				seqEstadoActividad,
				txtEstadoActividad
			FROM
				T_PRY_ESTADO_ACTIVIDAD
			WHERE
				bolActivo = 1
			ORDER BY
				seqEstadoActividad
		";

	$optEstadoActividades = "";
	$ejecutaEstadoActividades = mysql_query($sql);
	while ($rowEstadoActividades = mysql_fetch_array($ejecutaEstadoActividades)){
		$optEstadoActividades .= "<option value=" . $rowEstadoActividades['seqEstadoActividad'] . ">" . $rowEstadoActividades['txtEstadoActividad']."</option>";
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
		// Ultimo Cronograma de fechas
		$sql = "SELECT
					seqCronogramaFecha,
					numActaDescriptiva,
					numAnoActaDescriptiva,
					fchInicialProyecto,
					fchFinalProyecto,
					valPlazoEjecucion,
					fchInicialEntrega,
					fchFinalEntrega,
					fchInicialEscrituracion,
					fchFinalEscrituracion
				FROM
					T_PRY_CRONOGRAMA_FECHAS
				WHERE seqProyecto = ".$_POST['nit']."
				AND numActaDescriptiva = (SELECT MAX(numActaDescriptiva)
											FROM T_PRY_CRONOGRAMA_FECHAS
											WHERE seqProyecto = ".$_POST['nit']."
											AND numAnoActaDescriptiva = (SELECT MAX(numAnoActaDescriptiva)
																		FROM T_PRY_CRONOGRAMA_FECHAS
																		WHERE seqProyecto = ".$_POST['nit']."))
			";
		$objRes = $aptBd->execute($sql);
		while ($objRes->fields) {
			$arrUltimoCronogramaFechas['valPlazoEjecucion'] 	 	= $objRes->fields['valPlazoEjecucion'];
			$arrUltimoCronogramaFechas['fchInicialProyecto'] 		= $objRes->fields['fchInicialProyecto'];
			$arrUltimoCronogramaFechas['fchFinalProyecto'] 	 		= $objRes->fields['fchFinalProyecto'];
			$arrUltimoCronogramaFechas['fchInicialEntrega'] 		= $objRes->fields['fchInicialEntrega'];
			$arrUltimoCronogramaFechas['fchFinalEntrega'] 			= $objRes->fields['fchFinalEntrega'];
			$arrUltimoCronogramaFechas['fchInicialEscrituracion']	= $objRes->fields['fchInicialEscrituracion'];
			$arrUltimoCronogramaFechas['fchFinalEscrituracion'] 	= $objRes->fields['fchFinalEscrituracion'];
		$objRes->MoveNext();
		}

		// Resoluciones del Proyecto
		$sql = "SELECT
					*
				FROM
					T_PRY_RESOLUCION_PROYECTO
				WHERE
					seqProyecto = ".$_POST['nit']."
				ORDER BY
					fchResolucionProyecto DESC
			";
		$objRes = $aptBd->execute($sql);
		while ($objRes->fields) {
			$arrResolucionProyecto[$objRes->fields['seqResolucionProyecto']]['seqResolucionProyecto'] = $objRes->fields['seqResolucionProyecto'];
			$arrResolucionProyecto[$objRes->fields['seqResolucionProyecto']]['numResolucionProyecto'] = $objRes->fields['numResolucionProyecto'];
			$arrResolucionProyecto[$objRes->fields['seqResolucionProyecto']]['fchResolucionProyecto'] = $objRes->fields['fchResolucionProyecto'];
			$arrResolucionProyecto[$objRes->fields['seqResolucionProyecto']]['txtResuelve'] = $objRes->fields['txtResuelve'];
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

		// Desembolsos
		$sql = "SELECT
					T_PRY_DESEMBOLSO_PROYECTO.*,
					T_PRY_PROYECTO.valTotalCostos,
					T_PRY_PROYECTO.valNumeroSoluciones
				FROM
					T_PRY_DESEMBOLSO_PROYECTO INNER JOIN T_PRY_PROYECTO ON (T_PRY_DESEMBOLSO_PROYECTO.seqProyecto = T_PRY_PROYECTO.seqProyecto)
				WHERE
					T_PRY_DESEMBOLSO_PROYECTO.seqProyecto = ".$_POST['nit']."
				ORDER BY
					valNumeroPago
			";
			//echo $sql;
		$objRes = $aptBd->execute($sql);
		while ($objRes->fields) {
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['seqDesembolsoProyecto']		= $objRes->fields['seqDesembolsoProyecto'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['txtNombreVendedor']			= $objRes->fields['txtNombreVendedor'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['numNitVendedor']				= $objRes->fields['numNitVendedor'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['numTelefonoVendedor']			= $objRes->fields['numTelefonoVendedor'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['txtCorreoVendedor'] 			= $objRes->fields['txtCorreoVendedor'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['txtNombreBeneficiarioGiro'] 	= $objRes->fields['txtNombreBeneficiarioGiro'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['numNitBeneficiarioGiro'] 		= $objRes->fields['numNitBeneficiarioGiro'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['valTotalCostos'] 				= $objRes->fields['valTotalCostos'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['valNumeroSoluciones'] 		= $objRes->fields['valNumeroSoluciones'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['valDesembolso'] 				= $objRes->fields['valDesembolso'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['seqTipoModalidadDesembolso'] 	= $objRes->fields['seqTipoModalidadDesembolso'];
			//$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['seqFiduciaria'] 				= $objRes->fields['seqFiduciaria'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['numContratoSuscrito'] 		= $objRes->fields['numContratoSuscrito'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['fchContratoSuscrito'] 		= $objRes->fields['fchContratoSuscrito'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['txtNombreEntidadFinanciera'] 	= $objRes->fields['txtNombreEntidadFinanciera'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['numNitEntidadFinanciera'] 	= $objRes->fields['numNitEntidadFinanciera'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['numCuenta'] 					= $objRes->fields['numCuenta'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['seqTipoCuenta'] 				= $objRes->fields['seqTipoCuenta'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['seqBancoCuenta'] 				= $objRes->fields['seqBancoCuenta'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['valTotalGiroAnticipado'] 		= $objRes->fields['valTotalGiroAnticipado'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['valSaldoGiro'] 				= $objRes->fields['valSaldoGiro'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['valNumeroPago'] 				= $objRes->fields['valNumeroPago'];
			$arrDesembolsoProyecto[$objRes->fields['seqDesembolsoProyecto']]['txtObservacion'] 				= $objRes->fields['txtObservacion'];
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
			$arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchInicialProyecto'] 	 	= $objRes->fields['fchInicialProyecto'];
			$arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchFinalProyecto'] 	 		= $objRes->fields['fchFinalProyecto'];
			$arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['valPlazoEjecucion'] 	 	= $objRes->fields['valPlazoEjecucion'];
			$arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchInicialEntrega'] 		= $objRes->fields['fchInicialEntrega'];
			$arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchFinalEntrega'] 			= $objRes->fields['fchFinalEntrega'];
			$arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchInicialEscrituracion'] 	= $objRes->fields['fchInicialEscrituracion'];
			$arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchFinalEscrituracion'] 	= $objRes->fields['fchFinalEscrituracion'];
		$objRes->MoveNext();
		}

		// Seguimientos a las Actividades del Cronograma de Obra
		$sql = "SELECT
					seqSeguimientoActividad,
					txtNombreActividad,
					txtDescripcionSeguimiento,
					fchSeguimientoActividad,
					txtEstadoActividad,
					CONCAT(txtNombre,' ',txtApellido) AS txtNombreCompleto
				FROM
					T_PRY_SEGUIMIENTO_ACTIVIDAD
				INNER JOIN
					T_COR_USUARIO ON (T_PRY_SEGUIMIENTO_ACTIVIDAD.seqUsuario = T_COR_USUARIO.seqUsuario)
				INNER JOIN
					T_PRY_ACTIVIDAD_CRONOGRAMA ON (T_PRY_SEGUIMIENTO_ACTIVIDAD.seqActividadCronograma = T_PRY_ACTIVIDAD_CRONOGRAMA.seqActividadCronograma)
				INNER JOIN
					T_PRY_ESTADO_ACTIVIDAD ON (T_PRY_SEGUIMIENTO_ACTIVIDAD.seqEstadoActividad = T_PRY_ESTADO_ACTIVIDAD.seqEstadoActividad)
				WHERE
					T_PRY_SEGUIMIENTO_ACTIVIDAD.seqProyecto = ".$_POST['nit']."
				ORDER BY
					fchSeguimientoActividad ASC
				";
			//echo $sql;
		$objRes = $aptBd->execute($sql);
		while ($objRes->fields) {
			$arrSeguimientoActividad[$objRes->fields['seqSeguimientoActividad']]['seqSeguimientoActividad'] 	= $objRes->fields['seqSeguimientoActividad'];
			$arrSeguimientoActividad[$objRes->fields['seqSeguimientoActividad']]['txtNombreActividad'] 			= $objRes->fields['txtNombreActividad'];
			$arrSeguimientoActividad[$objRes->fields['seqSeguimientoActividad']]['txtDescripcionSeguimiento'] 	= $objRes->fields['txtDescripcionSeguimiento'];
			$arrSeguimientoActividad[$objRes->fields['seqSeguimientoActividad']]['fchSeguimientoActividad'] 	= $objRes->fields['fchSeguimientoActividad'];
			$arrSeguimientoActividad[$objRes->fields['seqSeguimientoActividad']]['txtEstadoActividad'] 			= $objRes->fields['txtEstadoActividad'];
			$arrSeguimientoActividad[$objRes->fields['seqSeguimientoActividad']]['txtNombreCompleto'] 			= $objRes->fields['txtNombreCompleto'];
		$objRes->MoveNext();
		}

		// Seguimientos a las Cronograma de Obra
		$sql = "SELECT
					*
				FROM
					T_PRY_CRONOGRAMA_OBRAS_SEGUIMIENTO
				WHERE
					seqProyecto = ".$_POST['nit']."
				ORDER BY
					fchVisita ASC
			";
			//echo $sql;
		$objRes = $aptBd->execute($sql);
		while ($objRes->fields) {
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['seqSeguimientoCronogramaObras'] = $objRes->fields['seqSeguimientoCronogramaObras'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['seqProyecto'] = $objRes->fields['seqProyecto'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchVisita'] = $objRes->fields['fchVisita'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialTerrenoPry'] = $objRes->fields['fchInicialTerrenoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialTerrenoSeg'] = $objRes->fields['fchInicialTerrenoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialTerreno'] = $objRes->fields['difFchInicialTerreno'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalTerrenoPry'] = $objRes->fields['fchFinalTerrenoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalTerrenoSeg'] = $objRes->fields['fchFinalTerrenoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalTerreno'] = $objRes->fields['difFchFinalTerreno'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncTerrenoPry'] = $objRes->fields['porcIncTerrenoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncTerrenoSeg'] = $objRes->fields['porcIncTerrenoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncTerreno'] = $objRes->fields['difPorcIncTerreno'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActTerrenoPry'] = $objRes->fields['valActTerrenoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActTerrenoSeg'] = $objRes->fields['valActTerrenoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActTerreno'] = $objRes->fields['difValActTerreno'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialPreliminarConstruccionPry'] = $objRes->fields['fchInicialPreliminarConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialPreliminarConstruccionSeg'] = $objRes->fields['fchInicialPreliminarConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialPreliminarConstruccion'] = $objRes->fields['difFchInicialPreliminarConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalPreliminarConstruccionPry'] = $objRes->fields['fchFinalPreliminarConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalPreliminarConstruccionSeg'] = $objRes->fields['fchFinalPreliminarConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalPreliminarConstruccion'] = $objRes->fields['difFchFinalPreliminarConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncPreliminarConstruccionPry'] = $objRes->fields['porcIncPreliminarConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncPreliminarConstruccionSeg'] = $objRes->fields['porcIncPreliminarConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncPreliminarConstruccion'] = $objRes->fields['difPorcIncPreliminarConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActPreliminarConstruccionPry'] = $objRes->fields['valActPreliminarConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActPreliminarConstruccionSeg'] = $objRes->fields['valActPreliminarConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActPreliminarConstruccion'] = $objRes->fields['difValActPreliminarConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialCimentacionConstruccionPry'] = $objRes->fields['fchInicialCimentacionConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialCimentacionConstruccionSeg'] = $objRes->fields['fchInicialCimentacionConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialCimentacionConstruccion'] = $objRes->fields['difFchInicialCimentacionConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalCimentacionConstruccionPry'] = $objRes->fields['fchFinalCimentacionConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalCimentacionConstruccionSeg'] = $objRes->fields['fchFinalCimentacionConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalCimentacionConstruccion'] = $objRes->fields['difFchFinalCimentacionConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncCimentacionConstruccionPry'] = $objRes->fields['porcIncCimentacionConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncCimentacionConstruccionSeg'] = $objRes->fields['porcIncCimentacionConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncCimentacionConstruccion'] = $objRes->fields['difPorcIncCimentacionConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActCimentacionConstruccionPry'] = $objRes->fields['valActCimentacionConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActCimentacionConstruccionSeg'] = $objRes->fields['valActCimentacionConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActCimentacionConstruccion'] = $objRes->fields['difValActCimentacionConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialDesaguesConstruccionPry'] = $objRes->fields['fchInicialDesaguesConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialDesaguesConstruccionSeg'] = $objRes->fields['fchInicialDesaguesConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialDesaguesConstruccion'] = $objRes->fields['difFchInicialDesaguesConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalDesaguesConstruccionPry'] = $objRes->fields['fchFinalDesaguesConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalDesaguesConstruccionSeg'] = $objRes->fields['fchFinalDesaguesConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalDesaguesConstruccion'] = $objRes->fields['difFchFinalDesaguesConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncDesaguesConstruccionPry'] = $objRes->fields['porcIncDesaguesConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncDesaguesConstruccionSeg'] = $objRes->fields['porcIncDesaguesConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncDesaguesConstruccion'] = $objRes->fields['difPorcIncDesaguesConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActDesaguesConstruccionPry'] = $objRes->fields['valActDesaguesConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActDesaguesConstruccionSeg'] = $objRes->fields['valActDesaguesConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActDesaguesConstruccion'] = $objRes->fields['difValActDesaguesConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialEstructuraConstruccionPry'] = $objRes->fields['fchInicialEstructuraConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialEstructuraConstruccionSeg'] = $objRes->fields['fchInicialEstructuraConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialEstructuraConstruccion'] = $objRes->fields['difFchInicialEstructuraConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalEstructuraConstruccionPry'] = $objRes->fields['fchFinalEstructuraConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalEstructuraConstruccionSeg'] = $objRes->fields['fchFinalEstructuraConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalEstructuraConstruccion'] = $objRes->fields['difFchFinalEstructuraConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncEstructuraConstruccionPry'] = $objRes->fields['porcIncEstructuraConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncEstructuraConstruccionSeg'] = $objRes->fields['porcIncEstructuraConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncEstructuraConstruccion'] = $objRes->fields['difPorcIncEstructuraConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActEstructuraConstruccionPry'] = $objRes->fields['valActEstructuraConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActEstructuraConstruccionSeg'] = $objRes->fields['valActEstructuraConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActEstructuraConstruccion'] = $objRes->fields['difValActEstructuraConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialMamposteriaConstruccionPry'] = $objRes->fields['fchInicialMamposteriaConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialMamposteriaConstruccionSeg'] = $objRes->fields['fchInicialMamposteriaConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialMamposteriaConstruccion'] = $objRes->fields['difFchInicialMamposteriaConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalMamposteriaConstruccionPry'] = $objRes->fields['fchFinalMamposteriaConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalMamposteriaConstruccionSeg'] = $objRes->fields['fchFinalMamposteriaConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalMamposteriaConstruccion'] = $objRes->fields['difFchFinalMamposteriaConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncMamposteriaConstruccionPry'] = $objRes->fields['porcIncMamposteriaConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncMamposteriaConstruccionSeg'] = $objRes->fields['porcIncMamposteriaConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncMamposteriaConstruccion'] = $objRes->fields['difPorcIncMamposteriaConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActMamposteriaConstruccionPry'] = $objRes->fields['valActMamposteriaConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActMamposteriaConstruccionSeg'] = $objRes->fields['valActMamposteriaConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActMamposteriaConstruccion'] = $objRes->fields['difValActMamposteriaConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialPanetesConstruccionPry'] = $objRes->fields['fchInicialPanetesConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialPanetesConstruccionSeg'] = $objRes->fields['fchInicialPanetesConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialPanetesConstruccion'] = $objRes->fields['difFchInicialPanetesConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalPanetesConstruccionPry'] = $objRes->fields['fchFinalPanetesConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalPanetesConstruccionSeg'] = $objRes->fields['fchFinalPanetesConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalPanetesConstruccion'] = $objRes->fields['difFchFinalPanetesConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncPanetesConstruccionPry'] = $objRes->fields['porcIncPanetesConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncPanetesConstruccionSeg'] = $objRes->fields['porcIncPanetesConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncPanetesConstruccion'] = $objRes->fields['difPorcIncPanetesConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActPanetesConstruccionPry'] = $objRes->fields['valActPanetesConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActPanetesConstruccionSeg'] = $objRes->fields['valActPanetesConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActPanetesConstruccion'] = $objRes->fields['difValActPanetesConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialHidrosanitariasConstruccionPry'] = $objRes->fields['fchInicialHidrosanitariasConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialHidrosanitariasConstruccionSeg'] = $objRes->fields['fchInicialHidrosanitariasConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialHidrosanitariasConstruccion'] = $objRes->fields['difFchInicialHidrosanitariasConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalHidrosanitariasConstruccionPry'] = $objRes->fields['fchFinalHidrosanitariasConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalHidrosanitariasConstruccionSeg'] = $objRes->fields['fchFinalHidrosanitariasConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalHidrosanitariasConstruccion'] = $objRes->fields['difFchFinalHidrosanitariasConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncHidrosanitariasConstruccionPry'] = $objRes->fields['porcIncHidrosanitariasConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncHidrosanitariasConstruccionSeg'] = $objRes->fields['porcIncHidrosanitariasConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncHidrosanitariasConstruccion'] = $objRes->fields['difPorcIncHidrosanitariasConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActHidrosanitariasConstruccionPry'] = $objRes->fields['valActHidrosanitariasConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActHidrosanitariasConstruccionSeg'] = $objRes->fields['valActHidrosanitariasConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActHidrosanitariasConstruccion'] = $objRes->fields['difValActHidrosanitariasConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialElectricasConstruccionPry'] = $objRes->fields['fchInicialElectricasConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialElectricasConstruccionSeg'] = $objRes->fields['fchInicialElectricasConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialElectricasConstruccion'] = $objRes->fields['difFchInicialElectricasConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalElectricasConstruccionPry'] = $objRes->fields['fchFinalElectricasConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalElectricasConstruccionSeg'] = $objRes->fields['fchFinalElectricasConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalElectricasConstruccion'] = $objRes->fields['difFchFinalElectricasConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncElectricasConstruccionPry'] = $objRes->fields['porcIncElectricasConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncElectricasConstruccionSeg'] = $objRes->fields['porcIncElectricasConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncElectricasConstruccion'] = $objRes->fields['difPorcIncElectricasConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActElectricasConstruccionPry'] = $objRes->fields['valActElectricasConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActElectricasConstruccionSeg'] = $objRes->fields['valActElectricasConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActElectricasConstruccion'] = $objRes->fields['difValActElectricasConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialCubiertaConstruccionPry'] = $objRes->fields['fchInicialCubiertaConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialCubiertaConstruccionSeg'] = $objRes->fields['fchInicialCubiertaConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialCubiertaConstruccion'] = $objRes->fields['difFchInicialCubiertaConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalCubiertaConstruccionPry'] = $objRes->fields['fchFinalCubiertaConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalCubiertaConstruccionSeg'] = $objRes->fields['fchFinalCubiertaConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalCubiertaConstruccion'] = $objRes->fields['difFchFinalCubiertaConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncCubiertaConstruccionPry'] = $objRes->fields['porcIncCubiertaConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncCubiertaConstruccionSeg'] = $objRes->fields['porcIncCubiertaConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncCubiertaConstruccion'] = $objRes->fields['difPorcIncCubiertaConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActCubiertaConstruccionPry'] = $objRes->fields['valActCubiertaConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActCubiertaConstruccionSeg'] = $objRes->fields['valActCubiertaConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActCubiertaConstruccion'] = $objRes->fields['difValActCubiertaConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialCarpinteriaConstruccionPry'] = $objRes->fields['fchInicialCarpinteriaConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialCarpinteriaConstruccionSeg'] = $objRes->fields['fchInicialCarpinteriaConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialCarpinteriaConstruccion'] = $objRes->fields['difFchInicialCarpinteriaConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalCarpinteriaConstruccionPry'] = $objRes->fields['fchFinalCarpinteriaConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalCarpinteriaConstruccionSeg'] = $objRes->fields['fchFinalCarpinteriaConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalCarpinteriaConstruccion'] = $objRes->fields['difFchFinalCarpinteriaConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncCarpinteriaConstruccionPry'] = $objRes->fields['porcIncCarpinteriaConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncCarpinteriaConstruccionSeg'] = $objRes->fields['porcIncCarpinteriaConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncCarpinteriaConstruccion'] = $objRes->fields['difPorcIncCarpinteriaConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActCarpinteriaConstruccionPry'] = $objRes->fields['valActCarpinteriaConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActCarpinteriaConstruccionSeg'] = $objRes->fields['valActCarpinteriaConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActCarpinteriaConstruccion'] = $objRes->fields['difValActCarpinteriaConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialPisosConstruccionPry'] = $objRes->fields['fchInicialPisosConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialPisosConstruccionSeg'] = $objRes->fields['fchInicialPisosConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialPisosConstruccion'] = $objRes->fields['difFchInicialPisosConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalPisosConstruccionPry'] = $objRes->fields['fchFinalPisosConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalPisosConstruccionSeg'] = $objRes->fields['fchFinalPisosConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalPisosConstruccion'] = $objRes->fields['difFchFinalPisosConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncPisosConstruccionPry'] = $objRes->fields['porcIncPisosConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncPisosConstruccionSeg'] = $objRes->fields['porcIncPisosConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncPisosConstruccion'] = $objRes->fields['difPorcIncPisosConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActPisosConstruccionPry'] = $objRes->fields['valActPisosConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActPisosConstruccionSeg'] = $objRes->fields['valActPisosConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActPisosConstruccion'] = $objRes->fields['difValActPisosConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialSanitariosConstruccionPry'] = $objRes->fields['fchInicialSanitariosConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialSanitariosConstruccionSeg'] = $objRes->fields['fchInicialSanitariosConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialSanitariosConstruccion'] = $objRes->fields['difFchInicialSanitariosConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalSanitariosConstruccionPry'] = $objRes->fields['fchFinalSanitariosConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalSanitariosConstruccionSeg'] = $objRes->fields['fchFinalSanitariosConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalSanitariosConstruccion'] = $objRes->fields['difFchFinalSanitariosConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncSanitariosConstruccionPry'] = $objRes->fields['porcIncSanitariosConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncSanitariosConstruccionSeg'] = $objRes->fields['porcIncSanitariosConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncSanitariosConstruccion'] = $objRes->fields['difPorcIncSanitariosConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActSanitariosConstruccionPry'] = $objRes->fields['valActSanitariosConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActSanitariosConstruccionSeg'] = $objRes->fields['valActSanitariosConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActSanitariosConstruccion'] = $objRes->fields['difValActSanitariosConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialExterioresConstruccionPry'] = $objRes->fields['fchInicialExterioresConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialExterioresConstruccionSeg'] = $objRes->fields['fchInicialExterioresConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialExterioresConstruccion'] = $objRes->fields['difFchInicialExterioresConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalExterioresConstruccionPry'] = $objRes->fields['fchFinalExterioresConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalExterioresConstruccionSeg'] = $objRes->fields['fchFinalExterioresConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalExterioresConstruccion'] = $objRes->fields['difFchFinalExterioresConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncExterioresConstruccionPry'] = $objRes->fields['porcIncExterioresConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncExterioresConstruccionSeg'] = $objRes->fields['porcIncExterioresConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncExterioresConstruccion'] = $objRes->fields['difPorcIncExterioresConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActExterioresConstruccionPry'] = $objRes->fields['valActExterioresConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActExterioresConstruccionSeg'] = $objRes->fields['valActExterioresConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActExterioresConstruccion'] = $objRes->fields['difValActExterioresConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialAseoConstruccionPry'] = $objRes->fields['fchInicialAseoConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialAseoConstruccionSeg'] = $objRes->fields['fchInicialAseoConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialAseoConstruccion'] = $objRes->fields['difFchInicialAseoConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalAseoConstruccionPry'] = $objRes->fields['fchFinalAseoConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalAseoConstruccionSeg'] = $objRes->fields['fchFinalAseoConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalAseoConstruccion'] = $objRes->fields['difFchFinalAseoConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncAseoConstruccionPry'] = $objRes->fields['porcIncAseoConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncAseoConstruccionSeg'] = $objRes->fields['porcIncAseoConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncAseoConstruccion'] = $objRes->fields['difPorcIncAseoConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActAseoConstruccionPry'] = $objRes->fields['valActAseoConstruccionPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActAseoConstruccionSeg'] = $objRes->fields['valActAseoConstruccionSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActAseoConstruccion'] = $objRes->fields['difValActAseoConstruccion'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialPreliminarUrbanismoPry'] = $objRes->fields['fchInicialPreliminarUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialPreliminarUrbanismoSeg'] = $objRes->fields['fchInicialPreliminarUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialPreliminarUrbanismo'] = $objRes->fields['difFchInicialPreliminarUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalPreliminarUrbanismoPry'] = $objRes->fields['fchFinalPreliminarUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalPreliminarUrbanismoSeg'] = $objRes->fields['fchFinalPreliminarUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalPreliminarUrbanismo'] = $objRes->fields['difFchFinalPreliminarUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncPreliminarUrbanismoPry'] = $objRes->fields['porcIncPreliminarUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncPreliminarUrbanismoSeg'] = $objRes->fields['porcIncPreliminarUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncPreliminarUrbanismo'] = $objRes->fields['difPorcIncPreliminarUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActPreliminarUrbanismoPry'] = $objRes->fields['valActPreliminarUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActPreliminarUrbanismoSeg'] = $objRes->fields['valActPreliminarUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActPreliminarUrbanismo'] = $objRes->fields['difValActPreliminarUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialCimentacionUrbanismoPry'] = $objRes->fields['fchInicialCimentacionUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialCimentacionUrbanismoSeg'] = $objRes->fields['fchInicialCimentacionUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialCimentacionUrbanismo'] = $objRes->fields['difFchInicialCimentacionUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalCimentacionUrbanismoPry'] = $objRes->fields['fchFinalCimentacionUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalCimentacionUrbanismoSeg'] = $objRes->fields['fchFinalCimentacionUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalCimentacionUrbanismo'] = $objRes->fields['difFchFinalCimentacionUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncCimentacionUrbanismoPry'] = $objRes->fields['porcIncCimentacionUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncCimentacionUrbanismoSeg'] = $objRes->fields['porcIncCimentacionUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncCimentacionUrbanismo'] = $objRes->fields['difPorcIncCimentacionUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActCimentacionUrbanismoPry'] = $objRes->fields['valActCimentacionUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActCimentacionUrbanismoSeg'] = $objRes->fields['valActCimentacionUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActCimentacionUrbanismo'] = $objRes->fields['difValActCimentacionUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialDesaguesUrbanismoPry'] = $objRes->fields['fchInicialDesaguesUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialDesaguesUrbanismoSeg'] = $objRes->fields['fchInicialDesaguesUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialDesaguesUrbanismo'] = $objRes->fields['difFchInicialDesaguesUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalDesaguesUrbanismoPry'] = $objRes->fields['fchFinalDesaguesUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalDesaguesUrbanismoSeg'] = $objRes->fields['fchFinalDesaguesUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalDesaguesUrbanismo'] = $objRes->fields['difFchFinalDesaguesUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncDesaguesUrbanismoPry'] = $objRes->fields['porcIncDesaguesUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncDesaguesUrbanismoSeg'] = $objRes->fields['porcIncDesaguesUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncDesaguesUrbanismo'] = $objRes->fields['difPorcIncDesaguesUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActDesaguesUrbanismoPry'] = $objRes->fields['valActDesaguesUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActDesaguesUrbanismoSeg'] = $objRes->fields['valActDesaguesUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActDesaguesUrbanismo'] = $objRes->fields['difValActDesaguesUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialViasUrbanismoPry'] = $objRes->fields['fchInicialViasUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialViasUrbanismoSeg'] = $objRes->fields['fchInicialViasUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialViasUrbanismo'] = $objRes->fields['difFchInicialViasUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalViasUrbanismoPry'] = $objRes->fields['fchFinalViasUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalViasUrbanismoSeg'] = $objRes->fields['fchFinalViasUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalViasUrbanismo'] = $objRes->fields['difFchFinalViasUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncViasUrbanismoPry'] = $objRes->fields['porcIncViasUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncViasUrbanismoSeg'] = $objRes->fields['porcIncViasUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncViasUrbanismo'] = $objRes->fields['difPorcIncViasUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActViasUrbanismoPry'] = $objRes->fields['valActViasUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActViasUrbanismoSeg'] = $objRes->fields['valActViasUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActViasUrbanismo'] = $objRes->fields['difValActViasUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialParquesUrbanismoPry'] = $objRes->fields['fchInicialParquesUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialParquesUrbanismoSeg'] = $objRes->fields['fchInicialParquesUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialParquesUrbanismo'] = $objRes->fields['difFchInicialParquesUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalParquesUrbanismoPry'] = $objRes->fields['fchFinalParquesUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalParquesUrbanismoSeg'] = $objRes->fields['fchFinalParquesUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalParquesUrbanismo'] = $objRes->fields['difFchFinalParquesUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncParquesUrbanismoPry'] = $objRes->fields['porcIncParquesUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncParquesUrbanismoSeg'] = $objRes->fields['porcIncParquesUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncParquesUrbanismo'] = $objRes->fields['difPorcIncParquesUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActParquesUrbanismoPry'] = $objRes->fields['valActParquesUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActParquesUrbanismoSeg'] = $objRes->fields['valActParquesUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActParquesUrbanismo'] = $objRes->fields['difValActParquesUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialAseoUrbanismoPry'] = $objRes->fields['fchInicialAseoUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchInicialAseoUrbanismoSeg'] = $objRes->fields['fchInicialAseoUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchInicialAseoUrbanismo'] = $objRes->fields['difFchInicialAseoUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalAseoUrbanismoPry'] = $objRes->fields['fchFinalAseoUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['fchFinalAseoUrbanismoSeg'] = $objRes->fields['fchFinalAseoUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difFchFinalAseoUrbanismo'] = $objRes->fields['difFchFinalAseoUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncAseoUrbanismoPry'] = $objRes->fields['porcIncAseoUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['porcIncAseoUrbanismoSeg'] = $objRes->fields['porcIncAseoUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difPorcIncAseoUrbanismo'] = $objRes->fields['difPorcIncAseoUrbanismo'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActAseoUrbanismoPry'] = $objRes->fields['valActAseoUrbanismoPry'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['valActAseoUrbanismoSeg'] = $objRes->fields['valActAseoUrbanismoSeg'];
			$arrSeguimientoCronogramaObras[$objRes->fields['seqSeguimientoCronogramaObras']]['difValActAseoUrbanismo'] = $objRes->fields['difValActAseoUrbanismo'];
		//pr($arrSeguimientoCronogramaObras);
		$objRes->MoveNext();
		}

		// Conjuntos Residenciales del Proyecto (Proyectos Hijo)
		$sql = "SELECT
					seqProyecto,
					seqProyectoPadre,
					txtNombreProyecto,
					txtDireccion,
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

		// Unidades del Proyecto (Unidades Residenciales)
		$sql = "SELECT
					seqUnidadProyecto,
					txtNombreUnidad
				FROM
					T_PRY_UNIDAD_PROYECTO
				WHERE
					seqProyecto = ".$_POST['nit']."
				ORDER BY
					txtNombreUnidad
			";

		$objRes = $aptBd->execute($sql);
		while ($objRes->fields) {
			$arrUnidadResidencial[$objRes->fields['seqUnidadProyecto']]['seqUnidadProyecto']	= $objRes->fields['seqUnidadProyecto'];
			$arrUnidadResidencial[$objRes->fields['seqUnidadProyecto']]['txtNombreUnidad']		= $objRes->fields['txtNombreUnidad'];
		$objRes->MoveNext();
		}

		// Actividades de Cronograma (Combo a javascript) ()
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
		// echo "RecordCount: ".$objRes->RecordCount()."<BR>";
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
			if ( $objRes->fields['seqPryEstadoProceso'] == "1" || $objRes->fields['seqPryEstadoProceso'] == "2" ) {
				$txtPlantilla = "proyectos/actualizacion.tpl";
			} else if ($objRes->fields['seqPryEstadoProceso'] == "3") {
				$txtPlantilla = "proyectos/postulacion.tpl";
			} else if ($objRes->fields['seqPryEstadoProceso'] == "4") {
				$txtPlantilla = "proyectos/elegibilidad.tpl";
			} else if ($objRes->fields['seqPryEstadoProceso'] == "5") {
				$txtPlantilla = "proyectos/desembolso.tpl";
			} else if ($objRes->fields['seqPryEstadoProceso'] == "6") {
				$txtPlantilla = "proyectos/seguimientoObras.tpl";
			}
		}

		if ($seqProyecto != "") {
			$claSeguimientoProyectos = new SeguimientoProyectos;
			$claSeguimientoProyectos->seqProyecto = $seqProyecto;
			$arrRegistros = $claSeguimientoProyectos->obtenerRegistros(100);
		}
		//pr($arrRegistros);

		//$claFormulario = new FormularioSubsidios;
		//$txtActosAdministrativosJs = $claFormulario->obtenerActosAdministrativos();

		$claSmarty->assign("valSalarioMinimo", 						$arrConfiguracion['constantes']['salarioMinimo'] );
		$claSmarty->assign("numSubsidios", 							26);
		$claSmarty->assign("numNitProyecto", 						$_POST['nit']);
		$claSmarty->assign("objFormularioProyecto", 				$arrProyectos[$seqProyecto]);
		$claSmarty->assign("arrRegistros" , 						$arrRegistros ); // Registros de seguimiento
		$claSmarty->assign("arrTipoEsquema", 						$arrTipoEsquema);
		$claSmarty->assign("arrPryTipoModalidad",					$arrPryTipoModalidad);
		$claSmarty->assign("arrOpv", 								$arrOpv);
		//$claSmarty->assign("arrTipoOrganizacion", 				$arrTipoOrganizacion);
		//$claSmarty->assign("arrOferente", 						$arrOferente);
		$claSmarty->assign("arrTipoProyecto", 						$arrTipoProyecto);
		$claSmarty->assign("arrTipoUrbanizacion", 					$arrTipoUrbanizacion);
		$claSmarty->assign("arrConstructor", 						$arrConstructor);
		$claSmarty->assign("arrTipoSolucion", 						$arrTipoSolucion);
		$claSmarty->assign("arrTipoDocumento", 						$arrTipoDocumento);
		$claSmarty->assign("arrLocalidad", 							$arrLocalidad);
		$claSmarty->assign("arrBarrio", 							$arrBarrio );
		$claSmarty->assign("arrEstadosProceso", 					$arrEstadosProceso);
		$claSmarty->assign("arrTipoModalidadDesembolso", 			$arrTipoModalidadDesembolso);
		$claSmarty->assign("optModalidadDesembolso",				$optModalidadDesembolso);
		$claSmarty->assign("arrFiduciaria", 						$arrFiduciaria);
		$claSmarty->assign("arrBanco", 								$arrBanco);
		$claSmarty->assign("optBanco", 								$optBanco);
		$claSmarty->assign("arrTipoCuenta", 						$arrTipoCuenta);
		$claSmarty->assign("optTipoCuenta", 						$optTipoCuenta);
		$claSmarty->assign("arrResolucionProyecto",					$arrResolucionProyecto);
		$claSmarty->assign("arrActaProyecto",						$arrActaProyecto);
		$claSmarty->assign("arrCronogramaProyecto",					$arrCronogramaProyecto);
		$claSmarty->assign("arrCronogramaFecha",					$arrCronogramaFecha);
		$claSmarty->assign("arrUltimoCronogramaFechas",				$arrUltimoCronogramaFechas);
		$claSmarty->assign("arrTipoVivienda",						$arrTipoVivienda);
		$claSmarty->assign("arrDesembolsoProyecto",					$arrDesembolsoProyecto);
		$claSmarty->assign("arrConjuntoResidencial",				$arrConjuntoResidencial);
		$claSmarty->assign("arrUnidadResidencial",					$arrUnidadResidencial);
		$claSmarty->assign("optActividadesCronograma",				$optActividadesCronograma);
		$claSmarty->assign("optEstadoActividades",					$optEstadoActividades);
		$claSmarty->assign("optActividadSeguimientoTerreno",		$optActividadSeguimientoTerreno);
		$claSmarty->assign("optActividadSeguimientoConstruccion",	$optActividadSeguimientoConstruccion);
		$claSmarty->assign("optActividadSeguimientoUrbanizacion",	$optActividadSeguimientoUrbanizacion);
		$claSmarty->assign("arrActividadTerrenoExiste",				$arrActividadTerrenoExiste);
		$claSmarty->assign("arrActividadConstruccionExiste",		$arrActividadConstruccionExiste);
		$claSmarty->assign("arrActividadUrbanizacionExiste",		$arrActividadUrbanizacionExiste);
		$claSmarty->assign("arrSeguimientoActividad",				$arrSeguimientoActividad);
		$claSmarty->assign("arrSeguimientoCronogramaObras",			$arrSeguimientoCronogramaObras);
		$claSmarty->assign("arrTutorProyecto", 						$arrTutorProyecto);
		$claSmarty->assign("arrProfesionalResponsable", 			$arrProfesionalResponsable);
		$claSmarty->assign("seqProyectoAux", 						$seqProyecto);

		// Otros Arreglos
		$claSmarty->assign("arrGrupos", 							$_SESSION['arrGrupos']);
		$claSmarty->assign("arrGrupoGestion", 						$arrGrupoGestion);
		$claSmarty->assign("arrPrivilegios", 						$_SESSION['privilegios']);

		if ($txtPlantilla != "") {
			$claSmarty->display($txtPlantilla);
		}
	} else {
		echo "<br><p class='msgError'>NO EXISTE EL PROYECTO</p>";
	}
}
?>