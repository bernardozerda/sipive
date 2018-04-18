<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DatosGeneralesProyectos
 *
 * @author lbastoz
 */
class DatosGeneralesProyectos {

    public function DatosGeneralesProyectos() {
        
    }

    public function obtenerDatosOferente($seqOferente) {

        global $aptBd;

        $sql = "SELECT * FROM  t_pry_entidad_oferente  ";
        if ($seqOferente > 0) {
            $sql .= " where seqOferente = " . $seqOferente;
        }
        $sql . " ORDER BY seqOferente";

        $objRes = $aptBd->execute($sql);
        $datos = Array();
        while ($objRes->fields) {
            $datos[] = $objRes->fields;
            $objRes->MoveNext();
        }
        //var_dump($datos);
        return $datos;
    }

    public function obtenerDatosOferenteProy($seqProyecto) {

        global $aptBd;

        $sql = "SELECT * FROM  t_pry_entidad_oferente  entO"
                . " LEFT JOIN t_pry_proyecto_oferente proyOf USING(seqOferente)  ";
        if ($seqProyecto > 0) {
            $sql .= " where proyOf.seqProyecto = " . $seqProyecto;
        }
        $sql . " ORDER BY seqOferente";

        $objRes = $aptBd->execute($sql);
        $datos = Array();
        while ($objRes->fields) {
            $datos[] = $objRes->fields;
            $objRes->MoveNext();
        }
        return $datos;
    }

    public function obtenerDatosGestion() {

        global $aptBd;

        $arrGrupoGestionAdministrador[] = 15;
        $arrGrupoGestionAdministrador[] = 5;
        $arrGrupoGestionAdministrador[] = 10;
        $arrGrupoGestionAdministrador[] = 12;
        $arrGrupoGestionAdministrador[] = 17;
        $arrGrupoGestionAdministrador[] = 20;
        $arrGrupoGestionAdministrador[] = 14;

        $sql = "SELECT
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
        $arrGrupoGestion = Array();
        while ($objRes->fields) {
            $arrGrupoGestion[$objRes->fields['seqGrupoGestion']] = $objRes->fields['txtGrupoGestion'];
            $objRes->MoveNext();
        }
        return $arrGrupoGestion;
    }

    function obtenerlistaProyectos($seqProyecto) {
        global $aptBd;

        $sql = "SELECT pry.*, txtPlanGobierno,  
                case  when seqProyectoPadre IS NOT NULL 
                then (select ucwords(txtNombreProyecto) from t_pry_proyecto pry2 where pry2.seqProyecto = pry.seqProyectoPadre) else  '' end AS padre
                FROM t_pry_proyecto pry 
                LEFT JOIN t_frm_plan_gobierno USING(seqPlanGobierno) 
               ";
        if ($seqProyecto > 0) {
            $sql .= " where seqProyecto = " . $seqProyecto;
        } else {
            $sql .= " where seqProyectoPadre is null";
        }

        $sql . " ORDER BY seqProyecto asc";

        $objRes = $aptBd->execute($sql);
        $datos = Array();
        while ($objRes->fields) {
            $datos[] = $objRes->fields;
            $objRes->MoveNext();
        }
        return $datos;
    }

    function obtenerlistaEsquema() {
        global $aptBd;
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
        $arrTipoEsquema = Array();
        while ($objRes->fields) {
            $arrTipoEsquema[$objRes->fields['seqTipoEsquema']] = $objRes->fields['txtTipoEsquema'];
            $objRes->MoveNext();
        }
        return $arrTipoEsquema;
    }

    function obtenerlistamodalidad() {
        global $aptBd;
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
        $arrPryTipoModalidad = Array();
        while ($objRes->fields) {
            $arrPryTipoModalidad[$objRes->fields['seqPryTipoModalidad']] = $objRes->fields['txtPryTipoModalidad'];
            $objRes->MoveNext();
        }
        return $arrPryTipoModalidad;
    }

    function obtenerlistaOpv() {
        global $aptBd;
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
        $arrOpv = Array();
        while ($objRes->fields) {
            $arrOpv[$objRes->fields['seqOpv']] = $objRes->fields['txtNombreOpv'];
            $objRes->MoveNext();
        }
        return $arrOpv;
    }

    function obtenerListaBarrios() {
        global $aptBd;
        $sql = "
            SELECT
                    seqBarrio,
                    txtBarrio
            FROM
                    T_FRM_BARRIO
            ORDER BY
                    txtBarrio
		";

        $objRes = $aptBd->execute($sql);
        $arrBarrio = Array();
        while ($objRes->fields) {
            $arrBarrio[$objRes->fields['seqBarrio']] = $objRes->fields['txtBarrio'];
            $objRes->MoveNext();
        }
        return $arrBarrio;
    }

    function obtenerlistaTipoProyectos() {
        global $aptBd;
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
        $arrTipoProyecto = Array();
        while ($objRes->fields) {
            $arrTipoProyecto[$objRes->fields['seqTipoProyecto']] = $objRes->fields['txtTipoProyecto'];
            $objRes->MoveNext();
        }
        return $arrTipoProyecto;
    }

    function obtenerlistaTipoUrbanizacion() {
        global $aptBd;
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
        $arrTipoUrbanizacion = Array();
        while ($objRes->fields) {
            $arrTipoUrbanizacion[$objRes->fields['seqTipoUrbanizacion']] = $objRes->fields['txtTipoUrbanizacion'];
            $objRes->MoveNext();
        }
        return $arrTipoUrbanizacion;
    }

    function obtenerlistaConstructores() {
        global $aptBd;
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
        $arrConstructor = Array();
        while ($objRes->fields) {
            $arrConstructor[$objRes->fields['seqConstructor']] = $objRes->fields['txtNombreConstructor'];
            $objRes->MoveNext();
        }
        return $arrConstructor;
    }

    function obtenerlistaTipoSolucion() {
        global $aptBd;
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
        $arrTipoSolucion = Array();
        while ($objRes->fields) {
            $arrTipoSolucion[$objRes->fields['seqTipoSolucion']] = $objRes->fields['txtTipoSolucion'];
            $objRes->MoveNext();
        }
        return $arrTipoSolucion;
    }

    function obtenerlistaTipoDoc() {
        global $aptBd;
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
        $arrTipoDocumento = Array();
        while ($objRes->fields) {
            $arrTipoDocumento[$objRes->fields['seqTipoDocumento']] = $objRes->fields['txtTipoDocumento'];
            $objRes->MoveNext();
        }
        return $arrTipoDocumento;
    }

    function obtenerlistaLocalidad() {
        global $aptBd;
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
        $arrLocalidad = Array();
        while ($objRes->fields) {
            $arrLocalidad[$objRes->fields['seqLocalidad']] = $objRes->fields['txtLocalidad'];
            $objRes->MoveNext();
        }
        return $arrLocalidad;
    }

    function obtenerlistaEstadoProcesoProy() {
        global $aptBd;
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
        $arrEstadosProceso = Array();
        while ($objRes->fields) {
            $arrEstadosProceso[$objRes->fields['seqPryEstadoProceso']] = $objRes->fields['txtPryEstadoProceso'];
            $objRes->MoveNext();
        }
        return $arrEstadosProceso;
    }

    function obtenerlistaModalidadDesembolso() {
        global $aptBd;
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
        $arrTipoModalidadDesembolso = Array();
        while ($objRes->fields) {
            $arrTipoModalidadDesembolso[$objRes->fields['seqTipoModalidadDesembolso']] = $objRes->fields['txtTipoModalidadDesembolso'];
            $objRes->MoveNext();
        }
        return $arrTipoModalidadDesembolso;
    }

    function obtenerlistaFiduciaria() {
        global $aptBd;
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
        $arrFiduciaria = Array();
        while ($objRes->fields) {
            $arrFiduciaria[$objRes->fields['seqFiduciaria']] = $objRes->fields['txtNombreFiduciaria'];
            $objRes->MoveNext();
        }
        return $arrFiduciaria;
    }

    function obtenerlistaTipoCuenta() {
        global $aptBd;
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
        $arrTipoCuenta = Array();
        while ($objRes->fields) {
            $arrTipoCuenta[$objRes->fields['seqTipoCuenta']] = $objRes->fields['txtTipoCuenta'];
            $objRes->MoveNext();
        }
        return $arrTipoCuenta;
    }

    function obtenerlistaTutor() {
        global $aptBd;
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
        $arrTutorProyecto = Array();
        while ($objRes->fields) {
            $arrTutorProyecto[$objRes->fields['seqTutorProyecto']] = $objRes->fields['txtNombreTutor'];
            $objRes->MoveNext();
        }
        return $arrTutorProyecto;
    }

    public function obtenerDatosConstructor($seqConstructor) {

        global $aptBd;

        $sql = "SELECT * FROM  t_pry_constructor  ";
        if ($seqConstructor > 0) {
            $sql .= " where seqConstructor = " . $seqConstructor;
        }
        $sql . " ORDER BY seqConstructor";

        $objRes = $aptBd->execute($sql);
        $datos = Array();
        while ($objRes->fields) {
            $datos[] = $objRes->fields;
            $objRes->MoveNext();
        }
        return $datos;
    }

    public function obtenerDatosTutor($seqTutor) {
        global $aptBd;

        $sql = "SELECT * FROM  T_PRY_TUTOR_PROYECTO  ";
        if ($seqTutor > 0) {
            $sql .= " where seqTutorProyecto = " . $seqTutor;
        }
        $sql . " ORDER BY seqTutorProyecto";

        $objRes = $aptBd->execute($sql);
        $datos = Array();
        while ($objRes->fields) {
            $datos[] = $objRes->fields;
            $objRes->MoveNext();
        }
        return $datos;
    }

    public function editarTutor($post) {
        global $aptBd;
        foreach ($post as $nombre_campo => $valor) {
            //   echo $asignacion = "\$" . $nombre_campo . "='" . $valor . "';<br>";
            if ($valor == "") {
                $valor = 'null';
            }
            $$nombre_campo = $valor;
        }
        if (!isset($_POST['bolActivo']) || $_POST['bolActivo'] == NULL) {
            $bolActivo = 0;
        }
        $arrErrores = array();

        $sql = "
                    UPDATE T_PRY_TUTOR_PROYECTO SET
                            txtNombreTutor = \"" . ereg_replace('\"', "", $txtNombreTutor) . "\",                             
                            bolActivo = $bolActivo
                    WHERE seqTutorProyecto = $seqTutorProyecto
            ";
        //echo $sql;

        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido editar el Constructor <b>" . $arrConstructor[$seqConstructor]->txtNombreConstructor . "</b>. Reporte este error al administrador del sistema";
        }


        return $arrErrores;
    }

    public function guardarTutor($post) {

        global $aptBd;
        $bolActivo = 1;
        foreach ($post as $nombre_campo => $valor) {
            //   echo $asignacion = "\$" . $nombre_campo . "='" . $valor . "';<br>";
            if ($valor == "") {
                $valor = 'null';
            }
            $$nombre_campo = $valor;
        }
        $arrErrores = array();

        // Verifica si el Constructor existe
        // Instruccion para insertar el Constructor en la base de datos
        $sql = "INSERT INTO T_PRY_TUTOR_PROYECTO ( 
                    txtNombreTutor,						
                    bolActivo
                    ) VALUES (
                            \"" . ereg_replace('\"', "", $txtNombreTutor) . "\", 						
                            $bolActivo
                    ) ";

        try {
            $aptBd->execute($sql);
            return $aptBd->Insert_ID();
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido guardar el Constructor <b>$txtNombreConstructor</b>. Reporte este error al administrador del sistema";
        }

        return $arrErrores;
    }

    public function obtenerDocumentoProyecto($seqProyecto) {
        global $aptBd;
        $sqlIn = "select count(*) AS cant from t_pry_proyecto_documentos where seqProyecto = " . $seqProyecto;
        $objResIn = $aptBd->execute($sqlIn);
        $cant = 0;
        while ($objResIn->fields) {
            $cant = $objResIn->fields['cant'];
            $objResIn->MoveNext();
        }
        return $cant;
    }

    public function obtenerCantLicencias($seqProyecto) {
        global $aptBd;
        $sqlIn = "select count(*) AS cant from t_pry_proyecto_licencias where seqProyecto = " . $seqProyecto;
        $objResIn = $aptBd->execute($sqlIn);
        $cant = 0;
        while ($objResIn->fields) {
            $cant = $objResIn->fields['cant'];
            $objResIn->MoveNext();
        }
        return $cant;
    }

    public function obtenerCantCronogramas($seqProyecto) {
        global $aptBd;
        $sqlIn = "select count(*) AS cant from t_pry_cronograma_fechas where seqProyecto = " . $seqProyecto;
        $objResIn = $aptBd->execute($sqlIn);
        $cant = 0;
        while ($objResIn->fields) {
            $cant = $objResIn->fields['cant'];
            $objResIn->MoveNext();
        }
        return $cant;
    }

    public function obtenerTipoVivienda($seqProyecto) {

        global $aptBd;

        $sql = "SELECT *
            FROM
                    T_PRY_TIPO_VIVIENDA
            WHERE
                    seqProyecto = " . $seqProyecto . "
            ORDER BY
                    txtNombreTipoVivienda";
        //echo $sql;
        $arrTipoVivienda = Array();
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['seqTipoVivienda'] = $objRes->fields['seqTipoVivienda'];
            $arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['txtNombreTipoVivienda'] = $objRes->fields['txtNombreTipoVivienda'];
            $arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['numCantidad'] = $objRes->fields['numCantidad'];            
            $arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['numCantUdsDisc'] = $objRes->fields['numCantUdsDisc'];
            $arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['numTotalParq'] = $objRes->fields['numTotalParq'];
            $arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['numCantParqDisc'] = $objRes->fields['numCantParqDisc'];            
            $arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['numArea'] = $objRes->fields['numArea'];
            $arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['numAnoVenta'] = $objRes->fields['numAnoVenta'];
            $arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['valPrecioVenta'] = $objRes->fields['valPrecioVenta'];
            $arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['txtDescripcion'] = $objRes->fields['txtDescripcion'];
            $arrTipoVivienda[$objRes->fields['seqTipoVivienda']]['valCierre'] = $objRes->fields['valCierre'];
            $objRes->MoveNext();
        }
        return $arrTipoVivienda;
    }

    public function obtenerCantConjuntos($seqProyecto) {
        global $aptBd;
        $sqlIn = "select count(*) AS cant from t_pry_proyecto where seqProyectoPadre = " . $seqProyecto;
        $objResIn = $aptBd->execute($sqlIn);
        $cant = 0;
        while ($objResIn->fields) {
            $cant = $objResIn->fields['cant'];
            $objResIn->MoveNext();
        }
        return $cant;
    }

    public function obtenerCantTipoVivienda($seqProyecto) {
        global $aptBd;
        $sqlIn = "select count(*) AS cant from t_pry_tipo_vivienda where seqProyecto = " . $seqProyecto;
        $objResIn = $aptBd->execute($sqlIn);
        $cant = 0;
        while ($objResIn->fields) {
            $cant = $objResIn->fields['cant'];
            $objResIn->MoveNext();
        }
        return $cant;
    }

    public function obtenerConjuntoResidencial($seqProyecto) {

        global $aptBd;

        $arrConjuntoResidencial = Array();

        $sql = "SELECT
                seqProyecto,
                seqProyectoPadre,
                txtNombreProyecto,
                txtNombreComercial,
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
                seqProyectoPadre = " . $seqProyecto . "
        ORDER BY
                seqProyectoPadre";

        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['seqProyecto'] = $objRes->fields['seqProyecto'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['seqProyectoPadre'] = $objRes->fields['seqProyectoPadre'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtNombreProyecto'] = $objRes->fields['txtNombreProyecto'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtNombreComercial'] = $objRes->fields['txtNombreComercial'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtDireccion'] = $objRes->fields['txtDireccion'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['valNumeroSoluciones'] = $objRes->fields['valNumeroSoluciones'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtChipLote'] = $objRes->fields['txtChipLote'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtMatriculaInmobiliariaLote'] = $objRes->fields['txtMatriculaInmobiliariaLote'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtLicenciaUrbanismo'] = $objRes->fields['txtLicenciaUrbanismo'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['fchLicenciaUrbanismo1'] = $objRes->fields['fchLicenciaUrbanismo1'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['fchVigenciaLicenciaUrbanismo'] = $objRes->fields['fchVigenciaLicenciaUrbanismo'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtExpideLicenciaUrbanismo'] = $objRes->fields['txtExpideLicenciaUrbanismo'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtLicenciaConstruccion'] = $objRes->fields['txtLicenciaConstruccion'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['fchLicenciaConstruccion1'] = $objRes->fields['fchLicenciaConstruccion1'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['fchVigenciaLicenciaConstruccion'] = $objRes->fields['fchVigenciaLicenciaConstruccion'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtNombreVendedor'] = $objRes->fields['txtNombreVendedor'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['numNitVendedor'] = $objRes->fields['numNitVendedor'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtCedulaCatastral'] = $objRes->fields['txtCedulaCatastral'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['txtEscritura'] = $objRes->fields['txtEscritura'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['fchEscritura'] = $objRes->fields['fchEscritura'];
            $arrConjuntoResidencial[$objRes->fields['seqProyecto']]['numNotaria'] = $objRes->fields['numNotaria'];
            $objRes->MoveNext();
        }
        return $arrConjuntoResidencial;
    }

    public function obteneCronograma($seqProyecto) {
        global $aptBd;

        $arrCronogramaFecha = Array();
        $sql = "SELECT *
                        FROM
                                T_PRY_CRONOGRAMA_FECHAS
                        WHERE
                                seqProyecto = " . $seqProyecto . "
                        ORDER BY
                                fchInicialProyecto
                ";
        //echo $sql;
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['seqCronogramaFecha'] = $objRes->fields['seqCronogramaFecha'];
            $arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['numActaDescriptiva'] = $objRes->fields['numActaDescriptiva'];
            $arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['numAnoActaDescriptiva'] = $objRes->fields['numAnoActaDescriptiva'];
            $arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchInicialProyecto'] = $objRes->fields['fchInicialProyecto'];
            $arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchFinalProyecto'] = $objRes->fields['fchFinalProyecto'];
            $arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['valPlazoEjecucion'] = $objRes->fields['valPlazoEjecucion'];
            $arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchInicialEntrega'] = $objRes->fields['fchInicialEntrega'];
            $arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchFinalEntrega'] = $objRes->fields['fchFinalEntrega'];
            $arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchInicialEscrituracion'] = $objRes->fields['fchInicialEscrituracion'];
            $arrCronogramaFecha[$objRes->fields['seqCronogramaFecha']]['fchFinalEscrituracion'] = $objRes->fields['fchFinalEscrituracion'];
            $objRes->MoveNext();
        }
        return $arrCronogramaFecha;
    }

    public function obtenerDatosProyectosGrupo($seqProyectoGrupo) {

        global $aptBd;

        $sql = "SELECT * FROM  t_pry_proyecto_grupo where bolActivo = 1 ";
        if ($seqProyectoGrupo > 0) {
            $sql .= " and  seqProyectoGrupo = " . $seqProyectoGrupo;
        }
        $sql . " ORDER BY seqProyectoGrupo";

        $objRes = $aptBd->execute($sql);
        $datos = Array();
        while ($objRes->fields) {
            $datos[] = $objRes->fields;
            $objRes->MoveNext();
        }
        return $datos;
    }

}
