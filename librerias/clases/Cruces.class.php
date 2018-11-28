<?php

/*
 * Clase para reportes de cruces
 * y operaciones del modulo de
 * cruces para Bogota mejor para todos
 * @author lbastoz
 * @modified bzerdar (Nov 2017)
 */

class Cruces
{

    public $arrErrores;
    public $arrMensajes;
    public $arrIgnorados;
    public $arrDatos;
    public $arrAuditoria;
    private $arrFormatoArchivo;
    private $arrEstadosPermitidos;
    private $arrHash;

    function __construct()
    {
        $this->arrErrores   = array();
        $this->arrMensajes  = array();
        $this->arrIgnorados = array();
        $this->arrDatos     = array();
        $this->arrAuditoria = array();

        $arrEstados = estadosProceso();
        foreach($arrEstados as $i => $txtValor){
            $arrEstados[$i] = mb_strtoupper($txtValor);
        }

        $arrCausasTabla = obtenerDatosTabla("t_cru_causa",array("seqFuente","seqCausa","upper(txtCausa) as txtCausa"),"seqCausa");
        $arrCausas = array();
        foreach($arrCausasTabla as $seqCausa => $arrDatos){
            $seqFuente = $arrDatos['seqFuente'];
            $arrCausas[$seqFuente][$seqCausa] = $arrDatos['txtCausa'];
        }

        $this->arrFormatoArchivo[0]['nombre'] = "Resultado";
        $this->arrFormatoArchivo[0]['tipo'] = "numero";
        $this->arrFormatoArchivo[1]['nombre'] = "Formulario";
        $this->arrFormatoArchivo[1]['tipo'] = "numero";
        $this->arrFormatoArchivo[2]['nombre'] = "Postulante Principal";
        $this->arrFormatoArchivo[2]['tipo'] = "numero";
        $this->arrFormatoArchivo[3]['nombre'] = "Modalidad";
        $this->arrFormatoArchivo[3]['tipo'] = "texto";
        $this->arrFormatoArchivo[3]['rango'] = obtenerDatosTabla("t_frm_modalidad",array("seqModalidad","upper(txtModalidad) as txtModalidad"),"seqModalidad","seqPlanGobierno in (2,3)");
        $this->arrFormatoArchivo[4]['nombre'] = "Estado";
        $this->arrFormatoArchivo[4]['tipo'] = "texto";
        $this->arrFormatoArchivo[4]['rango'] = $arrEstados;
        $this->arrFormatoArchivo[5]['nombre'] = "Tipo_Documento";
        $this->arrFormatoArchivo[5]['tipo'] = "texto";
        $this->arrFormatoArchivo[5]['rango'] = obtenerDatosTabla("t_ciu_tipo_documento",array("seqTipoDocumento","upper(txtTipoDocumento) as txtTipoDocumento"),"seqTipoDocumento","seqTipoDocumento not in (6,8)");
        $this->arrFormatoArchivo[6]['nombre'] = "Documento";
        $this->arrFormatoArchivo[6]['tipo'] = "numero";
        $this->arrFormatoArchivo[7]['nombre'] = "Nombre";
        $this->arrFormatoArchivo[7]['tipo'] = "texto";
        $this->arrFormatoArchivo[8]['nombre'] = "Parentesco";
        $this->arrFormatoArchivo[8]['tipo'] = "texto";
        $this->arrFormatoArchivo[8]['rango'] = obtenerDatosTabla("t_ciu_parentesco",array("seqParentesco","upper(txtParentesco) as txtParentesco"),"seqParentesco","bolActivo = 1 or seqParentesco = 14");
        $this->arrFormatoArchivo[9]['nombre'] = "Entidad";
        $this->arrFormatoArchivo[9]['tipo'] = "texto";
        $this->arrFormatoArchivo[9]['rango'] = obtenerDatosTabla("t_cru_fuente",array("seqFuente","upper(txtFuente) as txtFuente"),"seqFuente");
        $this->arrFormatoArchivo[10]['nombre'] = "Causa";
        $this->arrFormatoArchivo[10]['tipo'] = "texto";
        $this->arrFormatoArchivo[10]['rango'] = $arrCausas;
        $this->arrFormatoArchivo[11]['nombre'] = "Detalle";
        $this->arrFormatoArchivo[11]['tipo'] = "texto";
        $this->arrFormatoArchivo[12]['nombre'] = "Inhabilitar";
        $this->arrFormatoArchivo[12]['tipo'] = "texto";
        $this->arrFormatoArchivo[12]['rango'][] = "si";
        $this->arrFormatoArchivo[12]['rango'][] = "no";
        $this->arrFormatoArchivo[12]['rango'][] = "SI";
        $this->arrFormatoArchivo[12]['rango'][] = "NO";
        $this->arrFormatoArchivo[12]['rango'][] = "Si";
        $this->arrFormatoArchivo[12]['rango'][] = "No";
        $this->arrFormatoArchivo[13]['nombre'] = "Observaciones";
        $this->arrFormatoArchivo[13]['tipo'] = "texto";

        /**
         * Estados en los que se puede crear un cruce
         * - Primera Verificacion
         *      - [53] Calificado - EPI
         *      - [44] Primera Verificacion - CEM
         * - Segunda Verificacion
         *      - [47] Postulado EPI / CEM
         */
        $this->arrEstadosPermitidos['crear']['Primera Verificacion'] = array(53,44);
        $this->arrEstadosPermitidos['crear']['Segunda Verificacion'] = array(47,56);

        /**
         * Estados en los que se puede levantar cruces
         * - Primera Verificacion
         *      - [44] Primera Verificacion           ==> Para los de casa en mano que no tiene completo estudio Juridico, Tecnico
         *      - [45] Primera Verificacion Pendiente ==> Para levatar cruces
         *      - [46] Primera Verificacion Aprobada  ==> Por si tiene nuevos cruces que no se validaron antes
         * - Segunda Verificacion
         *      - [16] Pendiente Acto Administrativo
         *      - [56] Segunda verificacion pendiente
         */
        $this->arrEstadosPermitidos['editar']['Primera Verificacion'] = array(44,45,46);
        $this->arrEstadosPermitidos['editar']['Segunda Verificacion'] = array(56,16);

        $this->arrHash = array();

    }

    /***************************************************************************************************************
     * METODOS PARA EL MODELO T_PRE_*
     ***************************************************************************************************************/

    function validarDocumentos($separado_por_comas)
    {
        global $aptBd;

        $band = true;
        $msg = "";
        // Está consulta válida que no exista un cruce igual
        $sql = "SELECT numdocumento FROM t_frm_formulario
                            INNER JOIN t_frm_hogar hog USING (seqFormulario)
                            INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)
                            WHERE seqParentesco NOT IN(1) 
                            and numDocumento IN(" . $separado_por_comas . ")";
        $objRes = $aptBd->execute($sql);


//
        if ($objRes->_numOfRows > 0) {
            $val = "<b>Los siguientes documentos no se encuentran registrados como postulante principal</b><br>";
            if ($aptBd->ErrorMsg() == "") {
                while ($objRes->fields) {
                    $val .= "<br>" . $objRes->fields['numdocumento'];
                    $objRes->MoveNext();
                }
            }
            $val .= " <br><br> Por favor verifique los datos del hogar ";
            $msg = "<p class='alert alert-danger'>" . ucfirst($val) . "</p>";
            $band = false;
            if (!$band) {
                echo $msg;
                die();
            }
        }
        return $band;
    }

    function validarCruceExiste($grupo, $fch)
    {
        global $aptBd;
        $grupo = strtoupper(trim($grupo));
        $band = true;
        $msg = "";
        $val = "";
        // Está consulta válida que los números de los documentos pertenezcan al postulante principal
        $sql = "SELECT * FROM t_pre_grupo WHERE UPPER(txtPreCruGrupo) = '" . $grupo . "'";
        $objRes = $aptBd->execute($sql);
//
        if ($objRes->_numOfRows > 0) {
            $val = "<b>Este cruce ya existe por favor Verifique el Nombre</b><br>";
            if ($aptBd->ErrorMsg() == "") {
                while ($objRes->fields) {
                    $val .= $objRes->fields['txtNombreGrupo'];
                    $objRes->MoveNext();
                }
            }
            $msg = "<p class='alert alert-danger'>" . ucfirst($val) . "</p>";
            $band = false;
            if (!$band) {
                echo $msg;
                die();
            }
        }
        return $band;
    }

    function obtenerFormularios($separado_por_comas)
    {

        global $aptBd;

        $val = "";
        $sql = "SELECT seqFormulario FROM t_frm_formulario
                            INNER JOIN t_frm_hogar hog USING (seqFormulario)
                            INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)
                            WHERE numDocumento IN(" . $separado_por_comas . ") group by seqFormulario";
        $objRes = $aptBd->execute($sql);

        if ($objRes->_numOfRows > 0) {

            if ($aptBd->ErrorMsg() == "") {
                while ($objRes->fields) {
                    $val .= $objRes->fields['seqFormulario'] . ",";
                    $objRes->MoveNext();
                }
            }
        }

        $val = substr($val, 0, -1);
        return $val;
    }

    function insertarReporteGrupo($grupo)
    {

        global $aptBd;
        $sql = "INSERT INTO t_pre_grupo (txtPreCruGrupo,fchPreCruGrupo) VALUES ('" . $grupo . "',NOW());";
        $objRes = $aptBd->execute($sql);
        return $aptBd->Insert_ID();
    }

    function insertarReporteGeneral($formularios, $fch, $grupo, $user)
    {

        global $aptBd;

        $sql = "insert into t_pre_cruces_general SELECT 
    frm.seqFormulario,
    frm.txtFormulario,
    frm.fchVigencia AS Vigencia_SDV,
    CONCAT(eta.txtEtapa, ' ', epr.txtEstadoProceso) AS EstadoProceso,
    IF(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado,
    moa.txtModalidad,
    sol.txtDescripcion AS DescripcionSolucion,
    sol.txtSolucion,
    IF(frm.bolCerrado = 1, 'Si', 'No') AS Cerrado,
    (SELECT 
            tdo.txtTipoDocumento
        FROM
            T_FRM_HOGAR hog1
                INNER JOIN
            T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
                INNER JOIN
            T_CIU_TIPO_DOCUMENTO tdo ON ciu1.seqTipoDocumento = tdo.seqTipoDocumento
        WHERE
            hog1.seqFormulario = hog.seqFormulario
                AND hog1.seqParentesco = 1) AS TipoDocumentoPPAL,
    (SELECT 
            ciu1.numDocumento
        FROM
            T_FRM_HOGAR hog1
                INNER JOIN
            T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
        WHERE
            hog1.seqFormulario = hog.seqFormulario
                AND hog1.seqParentesco = 1) AS DocumentoPPAL,
    (SELECT 
            UPPER(CONCAT(ciu1.txtNombre1,
                                ' ',
                                ciu1.txtNombre2,
                                ' ',
                                ciu1.txtApellido1,
                                ' ',
                                ciu1.txtApellido2))
        FROM
            T_FRM_HOGAR hog1
                INNER JOIN
            T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
        WHERE
            hog1.seqFormulario = hog.seqFormulario
                AND hog1.seqParentesco = 1) AS NombrePPAL,
    (SELECT 
            tdo.txtTipoDocumento
        FROM
            T_CIU_TIPO_DOCUMENTO tdo
        WHERE
            tdo.seqTipoDocumento = ciu.seqTipoDocumento) AS TipoDocumento,
    ciu.numDocumento,
    UPPER(CONCAT(ciu.txtNombre1,
                    ' ',
                    ciu.txtNombre2,
                    ' ',
                    ciu.txtApellido1,
                    ' ',
                    ciu.txtApellido2)) AS Nombre,
    par.txtParentesco,
    sex.txtSexo,
    etn.txtEtnia,
    (SELECT 
            ces.txtCondicionEspecial
        FROM
            T_CIU_CONDICION_ESPECIAL ces
        WHERE
            ciu.seqCondicionEspecial = ces.seqCondicionEspecial) AS CondicionEspecial1,
    (SELECT 
            ces.txtCondicionEspecial
        FROM
            T_CIU_CONDICION_ESPECIAL ces
        WHERE
            ciu.seqCondicionEspecial2 = ces.seqCondicionEspecial) AS CondicionEspecial2,
    (SELECT 
            ces.txtCondicionEspecial
        FROM
            T_CIU_CONDICION_ESPECIAL ces
        WHERE
            ciu.seqCondicionEspecial3 = ces.seqCondicionEspecial) AS CondicionEspecial3,
    ned.txtNivelEducativo,
    sis.txtSisben,
    frm.numAdultosNucleo,
    frm.numNinosNucleo,
    (frm.numAdultosNucleo + frm.numNinosNucleo) AS numMiembrosHogar,
    IF(ciu.bolLgtb = 1, 'Si', 'No') AS LGBT,
    ocu.txtOcupacion,
    eci.txtEstadoCivil,
    frm.fchInscripcion,
    frm.fchPostulacion,
    frm.fchUltimaActualizacion,
    frm.valAspiraSubsidio,
    pat.txtPuntoAtencion,
    viv.txtVivienda,
    frm.valIngresoHogar,
    frm.valSaldoCuentaAhorro,
    (SELECT 
            ban.txtBanco
        FROM
            T_FRM_BANCO ban
        WHERE
            ban.seqBanco = frm.seqBancoCuentaAhorro) AS EntidadAhorro1,
    frm.valSaldoCuentaAhorro2,
    (SELECT 
            ban.txtBanco
        FROM
            T_FRM_BANCO ban
        WHERE
            ban.seqBanco = frm.seqBancoCuentaAhorro2) AS EntidadAhorro2,
    frm.valCredito,
    (SELECT 
            ban.txtBanco
        FROM
            T_FRM_BANCO ban
        WHERE
            ban.seqBanco = frm.seqBancoCredito) AS EntidadCredito,
    frm.valDonacion,
    (SELECT 
            edo.txtEmpresaDonante
        FROM
            T_FRM_EMPRESA_DONANTE edo
        WHERE
            edo.seqEmpresaDonante = frm.seqEmpresaDonante) AS entidadDonante,
    (frm.valSaldoCuentaAhorro + frm.valSaldoCuentaAhorro2) AS SumaAhorro,
    (frm.valSaldoCuentaAhorro + frm.valSaldoCuentaAhorro2 + frm.valSubsidioNacional + frm.valAporteLote + frm.valSaldoCesantias + frm.valAporteAvanceObra + frm.valAporteMateriales + frm.valCredito + frm.valDonacion) AS SumaCierreFinanciero,
    frm.valArriendo,
    (SELECT 
            loc.txtLocalidad
        FROM
            T_FRM_LOCALIDAD loc
        WHERE
            loc.seqLocalidad = frm.seqLocalidad) AS localidad,
    frm.txtBarrio,
    IF(frm.bolIdentificada = 1, 'Si', 'No') AS IdetificadaSolSDHT,
    IF(frm.bolViabilizada = 1, 'Si', 'No') AS PerteneceViaSDHT,
    des.txtNombreVendedor,
    (SELECT 
            loc.txtLocalidad
        FROM
            T_FRM_LOCALIDAD loc
        WHERE
            loc.seqLocalidad = des.seqLocalidad) AS localidadSolucion,
    des.txtBarrio,
    IF((TRIM(des.txtCompraVivienda) = ''
            OR des.txtCompraVivienda IS NULL),
        'Ninguna',
        des.txtCompraVivienda) AS TipoViviendaComprar,
    (SELECT 
            SUM(dsol.valSolicitado)
        FROM
            T_DES_SOLICITUD dsol
        WHERE
            frm.seqFormulario = des.seqFormulario
                AND dsol.seqDesembolso = des.seqDesembolso) AS ValorSolicitado, '" . $fch . "', " . $grupo . ", " . $user . "
FROM
    T_FRM_FORMULARIO frm
        INNER JOIN
    T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
        INNER JOIN
    T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
        LEFT JOIN
    T_CIU_PARENTESCO par ON hog.seqParentesco = par.seqParentesco
        LEFT JOIN
    T_CIU_SEXO sex ON ciu.seqSexo = sex.seqSexo
        LEFT JOIN
    T_CIU_ETNIA etn ON ciu.seqEtnia = etn.seqEtnia
        LEFT JOIN
    T_CIU_NIVEL_EDUCATIVO ned ON ciu.seqNivelEducativo = ned.seqNivelEducativo
        LEFT JOIN
    T_FRM_SISBEN sis ON frm.seqSisben = sis.seqSisben
        LEFT JOIN
    T_CIU_OCUPACION ocu ON ciu.seqOcupacion = ocu.seqOcupacion
        LEFT JOIN
    T_CIU_ESTADO_CIVIL eci ON ciu.seqEstadoCivil = eci.seqEstadoCivil
        LEFT JOIN
    T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
        INNER JOIN
    T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
        LEFT JOIN
    T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
        LEFT JOIN
    T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
        LEFT JOIN
    T_FRM_PUNTO_ATENCION pat ON frm.seqPuntoAtencion = pat.seqPuntoAtencion
        LEFT JOIN
    T_FRM_VIVIENDA viv ON frm.seqVivienda = viv.seqVivienda
        LEFT JOIN
    T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario
WHERE
    frm.seqFormulario IN (" . $formularios . ")";

        $objRes = $aptBd->execute($sql);
        if ($aptBd->ErrorMsg() == "") {
            return $aptBd->Affected_Rows();
        } else {
            return $aptBd->Affected_Rows();
        }
    }

    function obtenerDatosGrupo()
    {
        global $aptBd;
        $grupo = strtoupper(trim($grupo));
        $band = true;
        $arrayData = Array();
        // Está consulta válida que los números de los documentos pertenezcan al postulante principal
        $sql = "SELECT seqPreCruGrupo, txtPreCruGrupo FROM t_pre_grupo ORDER BY seqPreCruGrupo desc limit 10";
        $objRes = $aptBd->execute($sql);
//
        if ($objRes->_numOfRows > 0) {
            if ($aptBd->ErrorMsg() == "") {
                while ($objRes->fields) {
                    $arrayData[] = $objRes->fields;
                    $objRes->MoveNext();
                }
            }
        }
        return $arrayData;
    }

    function validarDocumentosAfiliados($separado_por_comas, $grupo)
    {
        global $aptBd;

        $band = true;
        $datos = array();
        $val = "<b>Los siguientes documentos no se encuentran registrados el reporte generado</b><br>";
        // Está consulta válida que no exista un cruce igual
        $sql = "SELECT numdocumento FROM t_pre_cruces_general    
                            where   seqPreCruGrupo = " . $grupo . " ORDER BY numdocumento";
        $objRes = $aptBd->execute($sql);
//
        if ($objRes->_numOfRows > 0) {

            if ($aptBd->ErrorMsg() == "") {
                while ($objRes->fields) {
                    $datos[] = $objRes->fields['numdocumento'];
                    $objRes->MoveNext();
                }
            }
        }
        //$separado_por_comas = sort($separado_por_comas);

        foreach ($separado_por_comas as $key => $value) {
            if (!in_array($value, $datos)) {
                $val .= "<br>" . $value;
                $band = false;
            }
        }

        $val .= " <br><br> Por favor verifique los datos del hogar ";
        $msg = "<p class='alert alert-danger'>" . ucfirst($val) . "</p>";
        if (!$band) {
            echo $msg;
            die();
        }
        return $band;
    }

    function InsertarCruces($array, $grupo)
    {

        global $aptBd;
        $band = true;
        $separado_por_comas = implode(",", $array['Documento']);
        $sql = "SELECT seqFormulario,  txtModalidad, Desplazado, DocumentoPPAL, txtFormulario, numDocumento, Nombre, txtParentesco,   seqPreCruGrupo, estadoProceso, TipoDocumento FROM t_pre_cruces_general    
          where   seqPreCruGrupo = " . $grupo . " and numDocumento in ($separado_por_comas) ORDER BY numdocumento asc";
        $objRes = $aptBd->execute($sql);
        $insertCons = "INSERT INTO t_pre_cruces_consolidado
                      (
                        seqFormulario, txtInhabilitar, txtModalidad, txtDezplazado, numDocumentoPp, txtFormulario, numDocumento, txtNombreCompleto, txtParentesco,
                        txtCausa, txtEntidad, txtConcatenacion, txtTipo, seqPreCruGrupo, txtEstado, txtTipoDoc)
                        VALUES";
        $valueInsert = "";
        if ($objRes->_numOfRows > 0) {
            if ($aptBd->ErrorMsg() == "") {
                $cont = 1;
                while ($objRes->fields) {
                    foreach ($array['Documento'] as $key => $value) {
                        if ($value == $objRes->fields['numDocumento']) {
                            $valueInsert .= "(" . $objRes->fields['seqFormulario'] . ", 'SI','" . $objRes->fields['txtModalidad'] . "','" . $objRes->fields['Desplazado'] . "'," . $objRes->fields['DocumentoPPAL'] . ",'";
                            $valueInsert .= $objRes->fields['txtFormulario'] . "'," . $objRes->fields['numDocumento'] . ",'" . $objRes->fields['Nombre'] . "','" . $objRes->fields['txtParentesco'] . "','";
                            $valueInsert .= "Afiliación CCF', 'FONVIVIENDA','Entidad:" . $array['Entidad'][$key] . "', '', 1,'" . $objRes->fields['estadoProceso'] . "','" . $objRes->fields['TipoDocumento'] . "'),";
                            // echo "<br>" . $cont . " -> " . $value . " ==" . $objRes->fields['numDocumento'];
                            $cont++;
                        }
                    }
                    $objRes->MoveNext();
                }
                $valueInsert = substr_replace($valueInsert, ';', -1, 1);
                echo $insertCons . "" . $valueInsert;
                $aptBd->execute($insertCons . "" . $valueInsert);
            }

        }
    }

    /***************************************************************************************************************
     * METODOS PARA EL MODELO T_CRU_*
     ***************************************************************************************************************/

    public function listado($arrPost = array()){
        global $aptBd;

        $txtCondicionSecuencia = ($arrPost['seqCruce'] != null)? " AND cru.seqCruce = " . $arrPost['seqCruce'] : "";
        $txtCondicionCreacion = ($arrPost['creacionInicio'] != null)? " AND fchCreacionCruce >= '" . $arrPost['creacionInicio']->format('Y-m-d') . "' AND fchCreacionCruce <= '" . $arrPost['creacionFinal']->format('Y-m-d') . "'" : "";
        $txtCondicionActualizacion = ($arrPost['updateInicio'] != null)? " AND fchActualizacionCruce >= '" . $arrPost['updateInicio']->format('Y-m-d') . "' AND fchActualizacionCruce <= '" . $arrPost['updateFinal']->format('Y-m-d') . "'" : "";
        $txtCondicionFecha = ($arrPost['cruceInicio'] != null)? " AND fchCruce >= '" . $arrPost['cruceInicio']->format('Y-m-d') . "' AND fchCruce <= '" . $arrPost['cruceFinal']->format('Y-m-d') . "'" : "";
        $txtCondicionNombre = (trim($arrPost['nombre']) != "")? " AND cru.txtNombre LIKE '%" . $arrPost['nombre'] . "%'" : "";
        $txtCondicionDocumento = (intval($arrPost['documento']) != 0)? " AND res.numDocumento = " . intval($arrPost['documento'])  : "";

        $claCiudadano = new Ciudadano();
        $seqFormulario = $claCiudadano->formularioVinculado($arrPost['documento'], false, false);
        if(! empty($claCiudadano->arrErrores)){
            $seqFormulario = 0;
        }

        $arrCruces = array();
        $sql = "
            SELECT DISTINCT 
                cru.seqCruce,
                cru.txtNombre,
                cru.fchCruce,
                cru.fchCreacionCruce,
                cru.fchActualizacionCruce
            FROM t_cru_cruces cru
            INNER JOIN t_cru_resultado res ON cru.seqCruce = res.seqCruce
            WHERE 1 = 1
            $txtCondicionSecuencia
            $txtCondicionCreacion
            $txtCondicionActualizacion
            $txtCondicionFecha
            $txtCondicionNombre
            $txtCondicionDocumento            
            ORDER BY cru.fchCreacionCruce DESC
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){
            $seqCruce                                      = $objRes->fields['seqCruce'];
            $arrCruces[$seqCruce]['txtNombre']             = mb_strtoupper($objRes->fields['txtNombre']);
            $arrCruces[$seqCruce]['fchCruce']              = new DateTime($objRes->fields['fchCruce']);
            $arrCruces[$seqCruce]['fchCreacionCruce']      = new DateTime($objRes->fields['fchCreacionCruce']);
            $arrCruces[$seqCruce]['fchActualizacionCruce'] = new DateTime($objRes->fields['fchActualizacionCruce']);
            $arrCruces[$seqCruce]['bolInhabilitar'] = 0;
            if(intval($arrPost['documento']) != 0) {
                $sql = "
                    select sum(bolInhabilitar) as bolInhabilitar
                    from t_cru_resultado
                    where seqCruce = $seqCruce
                      and seqFormulario = $seqFormulario
                ";
                $objResCruce = $aptBd->execute($sql);
                $arrCruces[$seqCruce]['bolInhabilitar'] = (intval($objResCruce->fields['bolInhabilitar']) > 0) ? 1 : 0;
            }

            $objRes->MoveNext();
        }
        return $arrCruces;
    }

    private function validarFormulario($arrPost){

        if(intval($arrPost['numValidacion']) == 0){
            $this->arrErrores[] = "Indique si el cruce corresponde a la primera o la segunda validación";
        }

        if($arrPost['txtNombre'] == ""){
            $this->arrErrores[] = "Debe dar un nombre al cruce";
        }else{
            $seqCruce = array_shift(obtenerDatosTabla(
                "t_cru_cruces",
                array("txtNombre","seqCruce"),
                "txtNombre",
                "txtNombre = '" . $arrPost['txtNombre'] . "' and seqCruce <> " . intval($arrPost['seqCruce'])
            ));

            if($seqCruce != 0){
                $this->arrErrores[] = "El nombre del cruce ya está en uso";
            }

        }

        if(!esFechaValida($arrPost['fchCruce'])){
            $this->arrErrores[] = "Debe dar una fecha para el cruce";
        }

        if($arrPost['txtCuerpo'] != ""){
            if($arrPost['txtFirma'] == ""){
                $this->arrErrores[] = "Debe indicar el nombre de quien firma la carta";
            }
            if($arrPost['txtElaboro'] == ""){
                $this->arrErrores[] = "Debe indicar el nombre de quien elabora la carta";
            }
            if($arrPost['txtReviso'] == ""){
                $this->arrErrores[] = "Debe indicar el nombre de quien revisa la carta";
            }
        }

    }

    private function cargarArchivo(){
        $arrArchivo = array();

        // valida si el archivo fue cargado y si corresponde a las extensiones válidas
        switch ($_FILES['archivo']['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
                break;
            case UPLOAD_ERR_PARTIAL:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
                break;
            case UPLOAD_ERR_NO_FILE:
                $this->arrErrores[] = "Debe especificar un archivo para cargar";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no se pudo cargar por falta de carpeta temporal, contacte al administrador";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no se pudo guardar en el servidor, contacte al administrador";
                break;
            case UPLOAD_ERR_EXTENSION:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no se pudo guardar en el servidor por un problema de extensiones, contacte al administrador";
                break;
            default:
                $numPunto = strpos($_FILES['archivo']['name'], ".") + 1;
                $numRestar = ( strlen($_FILES['archivo']['name']) - $numPunto ) * -1;
                $txtExtension = substr($_FILES['archivo']['name'], $numRestar);
                if (!in_array(strtolower($txtExtension), array("xls","xlsx","txt"))) {
                    $this->arrErrores[] = "Tipo de Archivo no permitido $txtExtension ";
                }
                break;
        }

        if( empty( $this->arrErrores ) ){

            // si es un archivo de texto obtiene los datos
            if( $_FILES['archivo']['type'] == "text/plain" ){
                foreach( file( $_FILES['archivo']['tmp_name'] ) as $numLinea => $txtLinea ){
                    if( trim( $txtLinea ) != "" ) {
                        $arrArchivo[$numLinea] = explode("\t", utf8_encode($txtLinea));
                        foreach($this->arrFormatoArchivo as $numColumna => $arrDato){
                            if(! isset($arrArchivo[$numLinea][$numColumna])){
                                $arrArchivo[$numLinea][$numColumna] = "";
                            }else{
                                $arrArchivo[$numLinea][$numColumna] = trim($arrArchivo[$numLinea][$numColumna]);
                            }
                        }
                    }
                }
            }else{
                try{

                    // crea las clases para la obtencion de los datos
                    $txtTipoArchivo = PHPExcel_IOFactory::identify($_FILES['archivo']['tmp_name']);
                    $objReader = PHPExcel_IOFactory::createReader($txtTipoArchivo);
                    $objPHPExcel = $objReader->load($_FILES['archivo']['tmp_name']);
                    $objHoja = $objPHPExcel->getSheet(0);

                    // obtiene las dimensiones del archivo para la obtencion del contenido por rangos
                    $numFilas = $objHoja->getHighestRow();
                    $numColumnas = PHPExcel_Cell::columnIndexFromString( $objHoja->getHighestColumn() ) - 1;

                    // obtiene los datos del rango obtenido
                    for( $numFila = 1; $numFila <= $numFilas; $numFila++ ){
                        for( $numColumna = 0; $numColumna <= $numColumnas; $numColumna++ ){
                            $numFilaArreglo = $numFila - 1;
                            $arrArchivo[$numFilaArreglo][$numColumna] = $objHoja->getCellByColumnAndRow($numColumna,$numFila)->getValue();
                            if( $this->arrFormatoArchivo[$numColumna]['tipo'] == "fecha" and is_numeric( $arrArchivo[$numFilaArreglo][$numColumna] ) ) {
                                $claFecha = PHPExcel_Shared_Date::ExcelToPHPObject($arrArchivo[$numFilaArreglo][$numColumna]);
                                $arrArchivo[$numFilaArreglo][$numColumna] = $claFecha->format("Y-m-d");
                            }
                        }
                    }

                    // limpia las lineas vacias
                    foreach ($arrArchivo as $numLinea => $arrLinea) {
                        $bolLineaVacia = true;
                        foreach ($arrLinea as $numColumna => $txtCelda) {
                            if ($txtCelda != "") {
                                $bolLineaVacia = false;
                                $arrArchivo[$numLinea][$numColumna] = trim($txtCelda);
                            }
                        }
                        if ($bolLineaVacia == true) {
                            unset($arrArchivo[$numLinea]);
                        }
                    }

                } catch ( Exception $objError ){
                    $this->arrErrores[] = $objError->getMessage();
                }
            }
        }

        if(count($arrArchivo) == 1){
            $this->arrErrores[] = "Un archivo que contiene solo los titulos se considera vacío";
        }

        return $arrArchivo;
    }

    public function validarArchivo($arrArchivo, $txtModo){

//        if($txtModo == "crear"){
//            unset($this->arrFormatoArchivo[0]);
//        }

        // valida titulos
        foreach($this->arrFormatoArchivo as $numColumna => $arrCelda){
            //$numColumnaArchivo = ($txtModo == "crear")? $numColumna - 1 : $numColumna;
            if(mb_strtolower($arrCelda['nombre']) != mb_strtolower($arrArchivo[0][$numColumna])){
                $this->arrErrores[] = "Error Linea 1: La columna " . $arrCelda['nombre'] . " no está o no está en el lugar correcto";
            }
        }

        // valida las lineas del archivo
        if(empty($this->arrErrores)) {
            foreach ($this->arrFormatoArchivo as $numColumna => $arrCelda) {
//                $numColumnaArchivo = ($txtModo == "crear")? $numColumna - 1 : $numColumna;
                for ($numFila = 1; $numFila < count($arrArchivo); $numFila++) {
                    if ($arrArchivo[$numFila][$numColumna] != "") {
                        $bolError = false;
                        switch ($arrCelda['tipo']) {
                            case "numero":
                                $bolError = (is_numeric($arrArchivo[$numFila][$numColumna])) ? false : true;
                                break;
                            case "fecha":
                                $bolError = (esFechaValida($arrArchivo[$numFila][$numColumna])) ? false : true;
                                break;
                        }
                        if ($bolError) {
                            $this->arrErrores[] = "Error Linea " . ($numFila + 1) . ": columna " . $arrCelda['nombre'] . " el valor debe ser " . $arrCelda['tipo'];
                        }
                        if (isset($arrCelda['rango'])) {
                            if(!is_array($arrCelda['rango'])) {
                                if (!in_array(mb_strtoupper($arrArchivo[$numFila][$numColumna]), $arrCelda['rango'])) {
                                    $this->arrErrores[] = "Error Linea " . ($numFila + 1) . ": columna " . $arrCelda['nombre'] . " " . $arrArchivo[$numFila][$numColumna] . " no es un valor válido";
                                }
                            }
                        }
                    }
                }
            }
        }

    }

    public function salvar(){
        global $aptBd;

        // valida los campos del formulario en pantalla
        $this->validarFormulario($_POST);

        // carga el archivo txt, xls o xlsx
        array_shift($this->arrFormatoArchivo);
        $arrArchivo = $this->cargarArchivo();

        // valida que los datos sean coherentes con el formato del archivo
        // ver la clase $claCruces->arrFormatoArchivo
        $this->validarArchivo($arrArchivo,'crear');

        try{
            $aptBd->BeginTrans();
            $this->validarReglasCrear($arrArchivo,$_POST);

            if(empty($this->arrErrores)){
                $sql = "
                    INSERT INTO t_cru_cruces(
                        txtNombre,
                        fchCruce,
                        txtCuerpo,
                        txtPie,
                        txtFirma,
                        txtElaboro,
                        txtReviso,
                        fchCreacionCruce,
                        txtUsuario,
                        txtNombreArchivo,
                        seqUsuario,
                        txtUsuarioActualiza,
                        txtNombreArchivoActualiza,
                        seqUsuarioActualiza,
                        fchActualizacionCruce,
                        numVerificacion
                    ) VALUES (
                        '" . $_POST['txtNombre'] . "',
                        '" . $_POST['fchCruce']  . "',
                        '" . $_POST['txtCuerpo']  . "',
                        '" . $_POST['txtPie']  . "',
                        '" . $_POST['txtFirma']  . "',
                        '" . $_POST['txtElaboro']  . "',
                        '" . $_POST['txtReviso']  . "',
                        NOW(),
                        '" . $_SESSION['txtUsuario'] . "',
                        '" . $_FILES['archivo']['name'] . "',
                        " . $_SESSION['seqUsuario'] . ",
                        null,
                        null,
                        null,
                        null,
                        " . intval($_POST['numValidacion']) . "
                    )
                ";
                $aptBd->execute($sql);
                $seqCruce = $aptBd->Insert_ID();
                $arrInhabilitar = array();
                unset($arrArchivo[0]);
                foreach($arrArchivo as $numLinea => $arrLinea){
                    $bolInhabilitar = (mb_strtolower($arrLinea[11]) == "no")? 0 : 1;
                    $seqFormulario = $arrLinea[0];
                    if($seqFormulario != 0) {
                        if ((!isset($arrInhabilitar[$seqFormulario])) or $arrInhabilitar[$seqFormulario]['inhabilitar'] == 0) {
                            $arrInhabilitar[$seqFormulario]['inhabilitar'] = $bolInhabilitar;
                            $arrInhabilitar[$seqFormulario]['estado'] = array_shift(array_keys($this->arrFormatoArchivo[3]['rango'], mb_strtoupper($arrLinea[3])));
                        }
                    }

                    $sql = "
                        INSERT INTO t_cru_resultado(
                            seqCruce,
                            seqFormulario,
                            seqModalidad,
                            seqEstadoProceso,
                            seqTipoDocumento,
                            numDocumento,
                            txtNombre,
                            seqParentesco,
                            txtEntidad,
                            txtTitulo,
                            txtDetalle,
                            bolInhabilitar,
                            txtObservaciones
                        ) VALUES (
                            " . $seqCruce . ",
                            " . $arrLinea[0] . ",
                            " . array_shift(array_keys($this->arrFormatoArchivo[2]['rango'],mb_strtoupper($arrLinea[2]))) . ",
                            " . array_shift(array_keys($this->arrFormatoArchivo[3]['rango'],mb_strtoupper($arrLinea[3]))) . ",
                            " . array_shift(array_keys($this->arrFormatoArchivo[4]['rango'],mb_strtoupper($arrLinea[4]))) . ",
                            " . $arrLinea[5] . ",
                            '" . strtoupper($arrLinea[6]) . "',
                            " . array_shift(array_keys($this->arrFormatoArchivo[7]['rango'],mb_strtoupper($arrLinea[7]))) . ",
                            '" . mb_strtoupper($arrLinea[8]) . "',
                            '" . mb_strtoupper($arrLinea[9]) . "',
                            '" . mb_strtoupper($arrLinea[10]) . "',
                            " . $bolInhabilitar . ",
                            '" . mb_strtoupper($arrLinea[12]) . "'
                        )
                    ";
                    $aptBd->execute($sql);

                    $sql = "
                        INSERT INTO t_cru_auditoria(
                            fchMovimiento,
                            seqUsuario,
                            seqCruce,
                            seqFormulario,
                            seqModalidad,
                            seqEstadoProceso,
                            seqTipoDocumento,
                            numDocumento,
                            txtNombre,
                            seqParentesco,
                            txtEntidad,
                            txtTitulo,
                            txtDetalle,
                            bolInhabilitar,
                            txtObservaciones
                        ) VALUES (
                            now(),
                            " . $_SESSION['seqUsuario'] . ",
                            " . $seqCruce . ",
                            " . $arrLinea[0] . ",
                            " . array_shift(array_keys($this->arrFormatoArchivo[2]['rango'],mb_strtoupper($arrLinea[2]))) . ",
                            " . array_shift(array_keys($this->arrFormatoArchivo[3]['rango'],mb_strtoupper($arrLinea[3]))) . ",
                            " . array_shift(array_keys($this->arrFormatoArchivo[4]['rango'],mb_strtoupper($arrLinea[4]))) . ",
                            " . $arrLinea[5] . ",
                            '" . strtoupper($arrLinea[6]) . "',
                            " . array_shift(array_keys($this->arrFormatoArchivo[7]['rango'],mb_strtoupper($arrLinea[7]))) . ",
                            '" . mb_strtoupper($arrLinea[8]) . "',
                            '" . mb_strtoupper($arrLinea[9]) . "',
                            '" . mb_strtoupper($arrLinea[10]) . "',
                            " . $bolInhabilitar . ",
                            '" . mb_strtoupper($arrLinea[12]) . "'
                        )
                    ";
                    $aptBd->execute($sql);

                }

                // ejecuta el cambio de estados de los hogares inhabilitados
                $this->cambioEstados($seqCruce,$_POST['fchCruce'],$arrInhabilitar);

                // registro de las actividades realizadas
                $claRegistroActividades = new RegistroActividades();
                $arrErrores = $claRegistroActividades->registrarActividad( 'Creacion' , 227 , $_SESSION['seqUsuario'] , 'seqCruce = ' . $seqCruce );

                // errores para la clase
                foreach($arrErrores as $i => $txtError) {
                    $this->arrErrores[] = $txtError;
                }

            }

            if(!empty($this->arrErrores)){
                $aptBd->RollbackTrans();
            }else{
                $aptBd->CommitTrans();
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = $objError->getMessage();
            $aptBd->RollbackTrans();
        }
    }

    private function validarReglasCrear($arrArchivo,$arrPost,$seqCruce = null){
        global $arrConfiguracion;
        $arrFormularios = array();
        $arrHogar = array();
        $arrModalidadArchivo = array();
        unset($arrArchivo[0]);
        foreach($arrArchivo as $numLinea => $arrLinea) {

            // obtiene los datos del formulario
            $seqFormulario = intval($arrLinea[0]);

            // detecta si debe o no activar las validaciones
            $bolValidar = ($seqFormulario != 0)? true : false;

            // si proceden las validaciones entra
            if($bolValidar == true) {

                // obtiene los datos del formulario
                if (!isset($arrFormularios[$seqFormulario])) {
                    $claFormulario = new FormularioSubsidios();
                    $claFormulario->cargarFormulario($arrLinea[0]);
                    foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                        if ($claFormulario->seqPlanGobierno == 2 and (!in_array($objCiudadano->seqTipoDocumento, array(1, 2)))) {
                            unset($claFormulario->arrCiudadano[$seqCiudadano]);
                        }
                    }
                } else {
                    $claFormulario = $arrFormularios[$seqFormulario];
                }

                // validacion en otros cruces
                //$this->crucesPendientes($numLinea , $seqFormulario, $seqCruce);

                // verifica que el estado del proceso sea el mismo de la base de datos
                // y verifica que este en estado Inscrito - Calificado
                if($claFormulario->seqEstadoProceso != array_shift(array_keys($this->arrFormatoArchivo[3]['rango'],mb_strtoupper($arrLinea[3])))){
                    $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El estado " . $arrLinea[3] . " no corresponde el estado registrado en el sistema";
                }else{
                    $txtValidacion = (intval($arrPost['numValidacion']) == 1)? 'Primera Verificacion' : 'Segunda Verificacion';
                    if (!in_array(array_shift(array_keys($this->arrFormatoArchivo[3]['rango'], mb_strtoupper($arrLinea[3]))), $this->arrEstadosPermitidos['crear'][$txtValidacion])) {
                        $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El estado " . $arrLinea[3] . " no es permitido para el cargue de cruces de " . $txtValidacion;
                    }
                    if(in_array($claFormulario->seqTipoEsquema , array( 5 , 10 , 11 , 13 , 15 )) and $claFormulario->seqEstadoProceso == 53){
                        $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El estado " . $arrLinea[3] . " no es permitido para el cargue de cruces de " . $txtValidacion . " debido al esquema";
                    }
                }

                /**
                 * validaciones de integridad de datos
                 * aplica para la segunda validacion ( segundo cruce )
                 */
                if($claFormulario->seqEstadoProceso == 47) {

                    // verifica que tenga numero de formulario
                    if ($claFormulario->txtFormulario == "") {
                        $txtMensaje = "Error Formulario " . $seqFormulario . ": No tiene numero de formulario";
                        if (!in_array($txtMensaje, $this->arrErrores)) {
                            $this->arrErrores[] = $txtMensaje;
                        }
                    }

                    // verifica que tenga fecha de posutlaicon
                    if (!esFechaValida($claFormulario->fchPostulacion)) {
                        $txtMensaje = "Error Formulario " . $seqFormulario . ": No tiene fecha de postulacion";
                        if (!in_array($txtMensaje, $this->arrErrores)) {
                            $this->arrErrores[] = $txtMensaje;
                        }
                    }

                    // localidad fuera de bogota, debe tener seqEntidadDonante = CVP bolDesplazado = 0
                    if ($claFormulario->seqLocalidad == 22){
                        if($claFormulario->bolDesplazado == 0 and $claFormulario->seqEmpresaDonante != 10){
                            $txtMensaje = "Error Formulario " . $seqFormulario . ": Es hogar vulnerable sin VUR con localidad fuera de bogotá";
                            if (!in_array($txtMensaje, $this->arrErrores)) {
                                $this->arrErrores[] = $txtMensaje;
                            }
                        }
                    }

                    // verifica que no tenga fecha de vigencia
                    if (esFechaValida($claFormulario->fchVigencia)) {
                        $txtMensaje = "Error Formulario " . $seqFormulario . ": El formulario no puede tener fecha de vigencia";
                        if (!in_array($txtMensaje, $this->arrErrores)) {
                            $this->arrErrores[] = $txtMensaje;
                        }
                    }

                    // verifica que el formulario este cerrado
                    if ($claFormulario->bolCerrado == 0) {
                        $txtMensaje = "Error Formulario " . $seqFormulario . ": El formulario debe estar cerrado";
                        if (!in_array($txtMensaje, $this->arrErrores)) {
                            $this->arrErrores[] = $txtMensaje;
                        }
                    }

                    $arrModalidad = obtenerDatosTabla(
                        "T_FRM_MODALIDAD",
                        array("seqModalidad", "txtModalidad"),
                        "seqModalidad",
                        "seqPlanGobierno = " . $claFormulario->seqPlanGobierno
                    );
                    if(! isset($arrModalidad[$claFormulario->seqModalidad])){
                        $txtMensaje = "Error Formulario " . $seqFormulario . ": La modalidad no concuerda con el plan de gobierno";
                        if (!in_array($txtMensaje, $this->arrErrores)) {
                            $this->arrErrores[] = $txtMensaje;
                        }
                    }

                    $arrTipoEsquemas = obtenerTipoEsquema($claFormulario->seqModalidad, $claFormulario->seqPlanGobierno, $claFormulario->bolDesplazado);
                    if(! isset($arrTipoEsquemas[$claFormulario->seqTipoEsquema])){
                        $txtMensaje = "Error Formulario " . $seqFormulario . ": El esquema no concuerda con la modalidad y plan de gobierno";
                        if (!in_array($txtMensaje, $this->arrErrores)) {
                            $this->arrErrores[] = $txtMensaje;
                        }
                    }

                    $arrSolucion = obtenerSolucion($claFormulario->seqModalidad);
                    if(! isset($arrSolucion[$claFormulario->seqSolucion])){
                        $txtMensaje = "Error Formulario " . $seqFormulario . ": La solucion no concuera con la modalidad y plan de gobierno";
                        if (!in_array($txtMensaje, $this->arrErrores)) {
                            $this->arrErrores[] = $txtMensaje;
                        }
                    }

                    $numLimiteSalarios = ($claFormulario->seqPlanGobierno == 3)? 2 : 4;
                    if($claFormulario->valIngresoHogar > ($arrConfiguracion['constantes']['salarioMinimo'] * $numLimiteSalarios)){
                        $txtMensaje = "Error Formulario " . $seqFormulario . ": Hogar con ingresos superiores a $numLimiteSalarios SMMLV";
                        if (!in_array($txtMensaje, $this->arrErrores)) {
                            $this->arrErrores[] = $txtMensaje;
                        }
                    }

                }

                // verifica que corresponda el postulante principal
                $objCiudadano = $this->obtenerPrincipal($claFormulario);
                if($objCiudadano->numDocumento != $arrLinea[1]){
                    $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El documento " . $arrLinea[1] . " no es el postulante principal";
                }

                // verifica que la modalidad sea la misma de la base de datos
                if($claFormulario->seqModalidad != array_shift(array_keys($this->arrFormatoArchivo[2]['rango'],mb_strtoupper($arrLinea[2])))){
                    $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": La modalidad " . $arrLinea[2] . " no corresponde con la registrada en el sistema";
                }else{
                    $arrModalidadArchivo[$claFormulario->seqModalidad] = 1;
                }

                $numDocumento = $arrLinea[5];
                $arrHogarArchivo[$seqFormulario][$numDocumento] = 1;

                // verifica que los datos del ciudadano sean los mismos de la base de datos
                // y verifica que todos los miembros de hogar esten incluidos
                $bolCiudadanoEncontrado = false;
                foreach($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano){
                    $arrHogar[$seqFormulario][$objCiudadano->numDocumento] = $seqCiudadano;
                    if($arrLinea[5] == $objCiudadano->numDocumento) {
                        $bolCiudadanoEncontrado = true;
                        $seqTipoDocumento = array_shift(array_keys($this->arrFormatoArchivo[4]['rango'], mb_strtoupper($arrLinea[4])));
                        if ($objCiudadano->seqTipoDocumento != $seqTipoDocumento) {
                            $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El tipo de documento no concuerda con el registrado en el sistema";
                        }
                        if ($this->obtenerNombre($objCiudadano) != mb_strtolower(trim($arrLinea[6]))) {
                            $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El nombre no concuerda con el registrado en el sistema";
                        }
                        $seqParentesco = array_shift(array_keys($this->arrFormatoArchivo[7]['rango'], mb_strtoupper($arrLinea[7])));
                        if($objCiudadano->seqParentesco != $seqParentesco){
                            $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El parentesco no concuerda con el registrado en el sistema";
                        }
                    }
                }

                // lineas del archivo que no corresponden al hogar
                if(!$bolCiudadanoEncontrado){
                    $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El documento " . $arrLinea[5] . " no pertenece al hogar";
                }

            }

            // si esta en inhabilitar si (1) debe tener Entidad - Causa - Detalle
            if(strtolower($arrLinea[11]) == "si"){
                if(trim($arrLinea[8]) == "" or trim($arrLinea[9]) == "" or trim($arrLinea[10]) == ""){
                    $this->arrErrores[] = "Error Linea " .  ($numLinea + 1) . ": Debe dar Entidad - Causa - Detalle para inhabilitar la linea";
                }
            }

            // verifica que la fuente este en la base de datos
            if(trim($arrLinea[8]) != "") {
                $seqFuente = array_shift(array_keys($this->arrFormatoArchivo[8]['rango'], mb_strtoupper($arrLinea[8])));
                if (intval($seqFuente) == 0) {
                    $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": No tiene una fuente conocida";
                }
            }

            // Verifica que la causa sea conocida en la base de datos
            if(trim($arrLinea[9]) != "") {
                $seqCausa = array_shift(array_keys($this->arrFormatoArchivo[9]['rango'][$seqFuente], mb_strtoupper($arrLinea[9])));
                if (intval($seqCausa) == 0) {
                    $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": No tiene una causa conocida o no tiene relación con la fuente";
                }
            }

            // verifica que la fuente y la causa tengan relacion
            if(trim($arrLinea[8]) != "" or trim($arrLinea[9]) != "") {
                $seqCausaBaseDatos = array_shift(
                    obtenerDatosTabla(
                        "t_cru_causa",
                        array("seqFuente", "seqCausa"),
                        "seqFuente",
                        "seqFuente = " . $seqFuente . " and seqCausa = " . $seqCausa
                    )
                );

                if (intval($seqCausaBaseDatos) != intval($seqCausa)) {
                    $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": La fuente no tiene relación con la causa";
                }
            }

        }

        if(!empty($arrHogar)){

            // los que queden dentro de arrHogar son los que faltan dentro del archivo
            foreach($arrHogar as $seqFormulario => $arrCiudadanos){
                foreach ($arrCiudadanos as $numDocumento => $tmp){
                    if(isset($arrHogarArchivo[$seqFormulario][$numDocumento])){
                        unset($arrHogar[$seqFormulario][$numDocumento]);
                    }
                }
            }

            // verifica los miembros de hogar que faltan dentro del archivo
            foreach($arrHogar as $seqFormulario => $arrCiudadano) {
                foreach($arrCiudadano as $numDocumento => $seqCiudadano) {
                    $this->arrErrores[] = "Error Formulario " . $seqFormulario . ": El documento " . $numDocumento . " no se encuentra dentro del archivo";
                }
            }

        }

        // verifica que el archivo tenga una sola modalidad
        if(! empty($arrModalidadArchivo)) {
            if (count($arrModalidadArchivo) > 1) {
                $this->arrErrores[] = "No puede tener mas de una modalidad dentro del archivo";
            }
        }

    }

    public function obtenerPrincipal($claFormulario){
        $objCiudadanoPrincipal = null;
        foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano){
            if($objCiudadano->seqParentesco == 1){
                $objCiudadanoPrincipal = $objCiudadano;
            }
        }
        return $objCiudadanoPrincipal;
    }

    public function obtenerNombre($objCiudadano){
        $txtNombre  = $objCiudadano->txtNombre1 . " ";
        $txtNombre .= (trim($objCiudadano->txtNombre2) != "")? $objCiudadano->txtNombre2 . " " : "";
        $txtNombre .= $objCiudadano->txtApellido1 . " ";
        $txtNombre .= (trim($objCiudadano->txtApellido2) != "")? $objCiudadano->txtApellido2 . " " : "";
        return mb_strtolower(trim($txtNombre));
    }

    private function cambioEstados($seqCruce,$fchCruce,$arrInhabilitar){
        global $aptBd;

        foreach($arrInhabilitar as $seqFormulario => $arrDato){

            $bolInhabilitar = $arrDato['inhabilitar'];
            $seqEstadoProceso = $arrDato['estado'];

            $claCasaMano = new CasaMano();
            $claCasaMano = end($claCasaMano->cargar($seqFormulario));

            if(intval($claCasaMano->seqCasaMano) == 0 ){

                if($seqEstadoProceso == 53 || $seqEstadoProceso == 45 || $seqEstadoProceso == 46) {
                    $seqEstadoProceso = ($bolInhabilitar == 1) ? 45 : 46;
                    $arrSeguimiento['txtComentario'] = "Primera verificación realizada";
                }elseif($seqEstadoProceso == 47 || $seqEstadoProceso == 56 || $seqEstadoProceso == 16){
                    $seqEstadoProceso = ($bolInhabilitar == 1) ? 56 : 16;
                    $arrSeguimiento['txtComentario'] = "Segunda verificación realizada";
                }

                if($seqEstadoProceso == 46 and ( time() > strtotime($fchCruce) )){
                    $seqEstadoProceso = 37;
                }

                if($seqEstadoProceso == 16 and ( time() > strtotime($fchCruce) )){
                    $seqEstadoProceso = 47;
                }

                $sql = "
                    update t_frm_formulario set 
                        seqEstadoProceso = " . $seqEstadoProceso . ",
                        fchUltimaActualizacion = NOW()
                    where seqFormulario = " . $seqFormulario;
                $aptBd->execute($sql);

                $sql = "
                    update t_cru_resultado set 
                        seqEstadoProceso = " . $seqEstadoProceso . "
                    where seqFormulario = " . $seqFormulario . " 
                      and seqCruce = " . $seqCruce;
                $aptBd->execute($sql);

            }else{

                $arrCasaMano['txtFlujo']               = "cem";
                $arrCasaMano['seqFormulario']          = $seqFormulario;
                $arrCasaMano['seqCasaMano']            = $claCasaMano->seqCasaMano;

                if($seqEstadoProceso == 44 || $seqEstadoProceso == 45) {
                    $arrSeguimiento['txtComentario'] = "Primera verificación realizada";
                    $arrCasaMano['txtFase'] = "primeraVerificacion";
                }elseif($seqEstadoProceso == 47 || $seqEstadoProceso == 56 ){
                    $arrSeguimiento['txtComentario'] = "Segunda verificación realizada";
                    $arrCasaMano['txtFase'] = "segundaVerificacion";
                }

                $arrCasaMano['bolResultado'] = ($bolInhabilitar == 1)? 2 : 1;
                $arrCasaMano['fchCruce'] = $fchCruce;
                $arrCasaMano['seqCruce'] = $seqCruce;

                $claCasaMano->salvar($arrCasaMano);
                if(!empty($claCasaMano->arrErrores)) {
                    $this->arrErrores = $claCasaMano->arrErrores;
                }
            }

            $arrSeguimiento['seqGrupoGestion'] = 11; // revision interna
            $arrSeguimiento['seqGestion'] = 46;      // actualizacion de estado
            $arrSeguimiento['seqFormulario'] = $seqFormulario;
            $arrSeguimiento['seqEstadoProceso'] = $seqEstadoProceso;

            $objCiudadano = $this->obtenerPrincipal($claCasaMano->objPostulacion);
            $arrSeguimiento['cedula'] = $objCiudadano->numDocumento;
            $arrSeguimiento['nombre'] = $this->obtenerNombre($objCiudadano);

            if($arrSeguimiento['txtComentario'] != "") {
                $claSeguimiento = new Seguimiento();
                $claSeguimiento->salvarSeguimiento($arrSeguimiento, "cambiosCruces");
            }else{
                $this->arrErrores[] = "Verifique que el hogar " . $seqFormulario . " tenga un estado de proceso válido para las operaiones de cruces";
            }

            if(!empty($claSeguimiento->arrErrores)) {
                foreach ($claSeguimiento->arrErrores as $i => $txtError) {
                    $this->arrErrores[] = $txtError;
                }
            }else{
                $this->arrMensajes = $claSeguimiento->arrMensajes;
            }

        }

    }

    public function eliminar($seqCruce)
    {
        global $aptBd;
        try {
            $aptBd->BeginTrans();
            $arrCurce = $this->listado(array("seqCruce" => $seqCruce));
            $sql = "delete from t_cru_auditoria where seqCruce = " . $seqCruce;
            $aptBd->execute($sql);
            $sql = "delete from t_cru_resultado where seqCruce = " . $seqCruce;
            $aptBd->execute($sql);
            $sql = "delete from t_cru_cruces where seqCruce = " . $seqCruce;
            $aptBd->execute($sql);
            $this->arrMensajes[] = "Eliminado el cruce " . $arrCurce[$seqCruce]['txtNombre'];
            $aptBd->CommitTrans();
        }catch(Exception $objError){
            $this->arrErrores[] = $objError->getMessage();
            $aptBd->RollBackTrans();
        }
    }

    public function cargar($seqCruce,$seqFormulario = null){
        global $aptBd;

        $txtCondicionFrm = ($seqFormulario != null)? " AND frm.seqFormulario = $seqFormulario" : "";
        $txtCondicionRes = ($seqFormulario != null)? " AND res.seqFormulario = $seqFormulario" : "";
        $txtCondicionAud = ($seqFormulario != null)? " AND aud.seqFormulario = $seqFormulario" : "";

        $sql = "
            SELECT 
                cru.seqCruce,
                cru.txtNombre,
                cru.fchCruce,
                cru.txtCuerpo,
                cru.txtPie,
                cru.txtFirma,
                cru.txtElaboro,
                cru.txtReviso,
                cru.fchCreacionCruce,
                concat(usu.txtNombre,' ',usu.txtApellido) as txtUsuario,
                cru.txtNombreArchivo,
                concat(usu1.txtNombre,' ',usu1.txtApellido) as txtUsuarioActualiza,
                cru.txtNombreArchivoActualiza,
                cru.seqUsuarioActualiza,
                cru.fchActualizacionCruce,
                cru.numVerificacion
            FROM t_cru_cruces cru
            inner join t_cor_usuario usu on cru.txtUsuario = usu.txtUsuario 
            left join t_cor_usuario usu1 on cru.txtUsuarioActualiza = usu1.txtUsuario 
            WHERE seqCruce = $seqCruce
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){
            $this->arrDatos['seqCruce'] = $objRes->fields['seqCruce'];
            $this->arrDatos['txtNombre'] = mb_strtoupper($objRes->fields['txtNombre']);
            $this->arrDatos['fchCruce'] = new DateTime($objRes->fields['fchCruce']) ;
            $this->arrDatos['txtCuerpo'] = $objRes->fields['txtCuerpo'];
            $this->arrDatos['txtPie'] = $objRes->fields['txtPie'];
            $this->arrDatos['txtFirma'] = strtoupper($objRes->fields['txtFirma']);
            $this->arrDatos['txtElaboro'] = strtoupper($objRes->fields['txtElaboro']);
            $this->arrDatos['txtReviso'] = strtoupper($objRes->fields['txtReviso']);
            $this->arrDatos['fchCreacionCruce'] = new DateTime($objRes->fields['fchCreacionCruce']);
            $this->arrDatos['txtUsuario'] = strtoupper($objRes->fields['txtUsuario']);
            $this->arrDatos['txtNombreArchivo'] = $objRes->fields['txtNombreArchivo'];
            $this->arrDatos['seqUsuario'] = $objRes->fields['seqUsuario'];
            $this->arrDatos['txtUsuarioActualiza'] = strtoupper($objRes->fields['txtUsuarioActualiza']);;
            $this->arrDatos['txtNombreArchivoActualiza'] = $objRes->fields['txtNombreArchivoActualiza'];
            $this->arrDatos['fchActualizacionCruce'] = (esFechaValida($objRes->fields['fchActualizacionCruce']))? new DateTime($objRes->fields['fchActualizacionCruce']) : null;
            $this->arrDatos['numVerificacion'] = intval($objRes->fields['numVerificacion']);
            $objRes->MoveNext();
        }

        $sql = "
            SELECT
                res.seqResultado, 
                res.seqCruce, 
                res.seqFormulario, 
                res.seqModalidad, 
                res.seqEstadoProceso,
                concat(eta.txtEtapa, ' - ', epr.txtEstadoProceso) as txtEstado,
                res.seqTipoDocumento,
                res.numDocumento, 
                res.txtNombre, 
                res.seqParentesco, 
                res.txtEntidad, 
                res.txtTitulo, 
                res.txtDetalle,
                res.bolInhabilitar, 
                res.txtObservaciones,
                if(ppal.numDocumento is null,0,ppal.numDocumento) as numDocumentoPrincipal,
                if(ppal.txtNombre is null, 'HOGAR EN COMPLEMENTARIEDAD', ppal.txtNombre) as txtNombrePrincipal,
                if(ppal.seqEstadoProceso is null, res.seqEstadoProceso,ppal.seqEstadoProceso) as seqEstadoProceso,
                if(ppal.txtEstadoFormulario is null, (
                    select est.txtEstado 
                    from v_frm_estado est 
                    where est.seqEstadoProceso = res.seqEstadoProceso 
                ) , ppal.txtEstadoFormulario) as txtEstadoFormulario
            FROM t_cru_resultado res
            INNER JOIN t_frm_estado_proceso epr on res.seqEstadoProceso = epr.seqEstadoProceso
            inner join t_frm_etapa eta on epr.seqEtapa = eta.seqEtapa
            LEFT JOIN (
                select 
                    res.seqResultado,
                    frm.seqFormulario,
                    ciu.numDocumento,
                    concat(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2) as txtNombre,
                    frm.seqEstadoProceso,
                    concat(eta.txtEtapa, ' - ', epr.txtEstadoProceso) as txtEstadoFormulario
                from t_frm_formulario frm
                inner join t_frm_hogar hog on frm.seqFormulario = hog.seqFormulario and hog.seqParentesco = 1
                inner join t_ciu_ciudadano ciu on hog.seqCiudadano = ciu.seqCiudadano
                inner join t_frm_estado_proceso epr on frm.seqEstadoProceso = epr.seqEstadoProceso
                inner join t_frm_etapa eta on epr.seqEtapa = eta.seqEtapa
                inner join t_cru_resultado res on res.seqFormulario = frm.seqFormulario
                where res.seqCruce = $seqCruce
                $txtCondicionFrm
            ) ppal on res.seqResultado = ppal.seqResultado
            WHERE seqCruce = $seqCruce
            $txtCondicionRes
            ORDER BY res.seqFormulario, res.numDocumento        
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields) {
            $seqResultado = $objRes->fields['seqResultado'];
            $this->arrDatos['arrResultado'][$seqResultado] = $objRes->fields;
            $objRes->MoveNext();
        }

        $sql = "
            select
                aud.seqAuditoria,
                aud.fchMovimiento,
                usu.txtUsuario,
                aud.seqCruce,
                aud.seqFormulario,
                if(ppal.txtModalidad is null, (select moa.txtModalidad from t_frm_modalidad moa where aud.seqModalidad = moa.seqModalidad) , ppal.txtModalidad ) as txtModalidad,
                concat(eta.txtEtapa, ' - ', epr.txtEstadoProceso) AS txtEstado,
                if(ppal.numDocumento is null,aud.numDocumento,ppal.numDocumento) AS numDocumentoPrincipal,
                tdo.txtTipoDocumento,
                aud.numDocumento,
                aud.txtNombre,
                par.txtParentesco,
                aud.txtEntidad,
                aud.txtTitulo,
                aud.txtDetalle,
                IF(aud.bolInhabilitar = 1, 'SI', 'NO') AS bolInhabilitar,
                aud.txtObservaciones
            from t_cru_auditoria aud
            inner join t_cor_usuario usu on aud.seqUsuario = usu.seqUsuario
            inner join t_ciu_tipo_documento tdo on aud.seqTipoDocumento = tdo.seqTipoDocumento
            inner join t_ciu_parentesco par on par.seqParentesco = aud.seqParentesco
            inner join t_frm_estado_proceso epr on aud.seqEstadoProceso = epr.seqEstadoProceso
            inner join t_frm_etapa eta on epr.seqEtapa = eta.seqEtapa
            left join (
                select distinct
                    res.seqCruce,
                    frm.seqFormulario,
                    ciu.numDocumento,
                    concat(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2) as txtNombre,
                    frm.seqEstadoProceso,
                    concat(eta.txtEtapa, ' - ', epr.txtEstadoProceso) as txtEstadoFormulario,
                    moa.txtModalidad
                from t_frm_formulario frm
                inner join t_frm_hogar hog on frm.seqFormulario = hog.seqFormulario and hog.seqParentesco = 1
                inner join t_ciu_ciudadano ciu on hog.seqCiudadano = ciu.seqCiudadano
                inner join t_frm_estado_proceso epr on frm.seqEstadoProceso = epr.seqEstadoProceso
                inner join t_frm_etapa eta on epr.seqEtapa = eta.seqEtapa
                inner join t_frm_modalidad moa on frm.seqModalidad = moa.seqModalidad
                inner join t_cru_resultado res on res.seqFormulario = frm.seqFormulario
                where res.seqCruce = $seqCruce
                $txtCondicionFrm
            ) ppal on ppal.seqCruce = aud.seqCruce and ppal.seqFormulario = aud.seqFormulario
            where aud.seqCruce = $seqCruce
            $txtCondicionAud
            order by
              aud.fchMovimiento,
              aud.seqFormulario,
              aud.numDocumento,
              aud.txtTitulo,
              aud.txtEntidad,
              aud.txtDetalle
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields) {
            $seqAuditoria = $objRes->fields['seqAuditoria'];
            unset($objRes->fields['seqAuditoria']);
            $this->arrAuditoria[$seqAuditoria] = $objRes->fields;
            $objRes->MoveNext();
        }

    }

    public function editar(){
        global $aptBd;

        try {

            // validar permisos de usuario
            // juridica y admnistradores
            // otros grupos no pueden editar nada
            if((!isset($_SESSION['arrGrupos'][3][20])) and (!isset($_SESSION['arrGrupos'][3][13]))){
                throw new Exception("No tiene permisos para editar cruces");
            }

            $aptBd->BeginTrans();

            // valida el formulario
            if (!esFechaValida($_POST['fchCruce'])) {
                $this->arrErrores[] = "Debe dar una fecha de publicación para el cruce";
            }

            // si hay archivo lo valida
            if ($_FILES['archivo']['error'] != UPLOAD_ERR_NO_FILE) {

                // carga el archivo txt, xls o xlsx
                $arrArchivo = $this->cargarArchivo();

                // valida que los datos sean coherentes con el formato del archivo
                // ver la clase $claCruces->arrFormatoArchivo
                $this->validarArchivo($arrArchivo,'editar');

                // reglas de negocio para levantar cruces
                $this->validarReglasEditar($arrArchivo);

                // proceder con el salvado de registros
                if(empty($this->arrErrores)){

                    try{

                        $txtUsuario = array_shift(
                            obtenerDatosTabla(
                                "t_cor_usuario",
                                array("seqUsuario","txtNombre"),
                                "seqUsuario",
                                "seqUsuario = " . $_SESSION['seqUsuario']
                            )
                        );

                        $sql = "
                            update t_cru_cruces set
                                fchCruce = '" . $_POST['fchCruce'] . "',
                                seqUsuarioActualiza = " . $_SESSION['seqUsuario'] . ",
                                txtUsuarioActualiza = '" . $txtUsuario . "',
                                txtNombreArchivoActualiza = '" . $_FILES['archivo']['name'] . "',
                                txtFirma = '" . $_POST['txtFirma'] . "',
                                txtElaboro = '" . $_POST['txtElaboro'] . "',
                                txtReviso = '" . $_POST['txtReviso'] . "',
                                fchActualizacionCruce = now()
                             where seqCruce = " . $_POST['seqCruce'] . "
                        ";
                        $aptBd->execute($sql);

                        $arrInhabilitar = array();
                        unset($arrArchivo[0]);
                        foreach($arrArchivo as $numLinea => $arrLinea){
                            $seqResultado = intval($arrLinea[0]);
                            $seqFormulario = intval($arrLinea[1]);
                            $bolInhabilitar = (mb_strtolower($arrLinea[12]) == "no") ? 0 : 1;
                            if($seqFormulario != 0) {
                                if ((!isset($arrInhabilitar[$seqFormulario])) or $arrInhabilitar[$seqFormulario]['inhabilitar'] == 0) {
                                    $arrInhabilitar[$seqFormulario]['inhabilitar'] = $bolInhabilitar;
                                    $arrInhabilitar[$seqFormulario]['estado'] = array_shift(array_keys($this->arrFormatoArchivo[4]['rango'], mb_strtoupper($arrLinea[4])));
                                }
                            }

                            if($seqResultado != 0) {
                                if(isset($_SESSION['arrGrupos'][3][20])) {
                                    $sql = "
                                        update t_cru_resultado set
                                            txtEntidad = '" . mb_strtoupper($arrLinea[9]) . "',
                                            txtTitulo = '" . mb_strtoupper($arrLinea[10]) . "',
                                            txtDetalle = '" . mb_strtoupper(mb_ereg_replace("\"","",$arrLinea[11])) . "',
                                            bolInhabilitar = " . $bolInhabilitar . ",
                                            txtObservaciones = '" . mb_strtoupper($arrLinea[13]) . "'
                                        where seqCruce = " . $_POST['seqCruce'] . "  
                                          and seqResultado = " . $arrLinea[0] . "
                                    ";
                                }else{
                                    $sql = "
                                        update t_cru_resultado set
                                            bolInhabilitar = " . $bolInhabilitar . ",
                                            txtObservaciones = '" . $arrLinea[13] . "'
                                        where seqCruce = " . $_POST['seqCruce'] . " 
                                          and seqResultado = " . $arrLinea[0] . " 
                                    ";
                                }
                            }else{
                                $sql = "
                                    INSERT INTO t_cru_resultado(
                                        seqCruce,
                                        seqFormulario,
                                        seqModalidad,
                                        seqEstadoProceso,
                                        seqTipoDocumento,
                                        numDocumento,
                                        txtNombre,
                                        seqParentesco,
                                        txtEntidad,
                                        txtTitulo,
                                        txtDetalle,
                                        bolInhabilitar,
                                        txtObservaciones
                                    ) VALUES (
                                        " . $_POST['seqCruce'] . ",
                                        " . $seqFormulario . ",
                                        " . array_shift(array_keys($this->arrFormatoArchivo[3]['rango'], mb_strtoupper($arrLinea[3]))) . ",
                                        " . array_shift(array_keys($this->arrFormatoArchivo[4]['rango'], mb_strtoupper($arrLinea[4]))) . ",
                                        " . array_shift(array_keys($this->arrFormatoArchivo[5]['rango'], mb_strtoupper($arrLinea[5]))) . ",
                                        " . $arrLinea[6] . ",
                                        '" . mb_strtoupper($arrLinea[7]) . "',
                                        " . array_shift(array_keys($this->arrFormatoArchivo[8]['rango'], mb_strtoupper($arrLinea[8]))) . ",
                                        '" . mb_strtoupper($arrLinea[9]) . "',
                                        '" . mb_strtoupper($arrLinea[10]) . "',
                                        '" . mb_strtoupper($arrLinea[11]) . "',
                                        " . $bolInhabilitar . ",
                                        '" . mb_strtoupper($arrLinea[13]) . "'
                                    )
                                ";
                            }
                            $aptBd->execute($sql);

                            $sql = "
                                INSERT INTO t_cru_auditoria(
                                    fchMovimiento,
                                    seqUsuario,
                                    seqCruce,
                                    seqFormulario,
                                    seqModalidad,
                                    seqEstadoProceso,
                                    seqTipoDocumento,
                                    numDocumento,
                                    txtNombre,
                                    seqParentesco,
                                    txtEntidad,
                                    txtTitulo,
                                    txtDetalle,
                                    bolInhabilitar,
                                    txtObservaciones
                                ) VALUES (
                                    now(),
                                    " . $_SESSION['seqUsuario'] . ",
                                    " . $_POST['seqCruce'] . ",
                                    " . $arrLinea[1] . ",
                                    " . array_shift(array_keys($this->arrFormatoArchivo[3]['rango'],mb_strtoupper($arrLinea[3]))) . ",
                                    " . array_shift(array_keys($this->arrFormatoArchivo[4]['rango'],mb_strtoupper($arrLinea[4]))) . ",
                                    " . array_shift(array_keys($this->arrFormatoArchivo[5]['rango'],mb_strtoupper($arrLinea[5]))) . ",
                                    " . $arrLinea[6] . ",
                                    '" . mb_strtoupper($arrLinea[7]) . "',
                                    " . array_shift(array_keys($this->arrFormatoArchivo[8]['rango'],mb_strtoupper($arrLinea[8]))) . ",
                                    '" . mb_strtoupper($arrLinea[9]) . "',
                                    '" . mb_strtoupper($arrLinea[10]) . "',
                                    '" . mb_strtoupper($arrLinea[11]) . "',
                                    " . $bolInhabilitar . ",
                                    '" . mb_strtoupper($arrLinea[13]) . "'
                                )
                            ";
                            $aptBd->execute($sql);

                        }

                        $this->cambioEstados($_POST['seqCruce'],$_POST['fchCruce'],$arrInhabilitar);

                        $claRegistroActividades = new RegistroActividades();
                        $arrErrores = $claRegistroActividades->registrarActividad( 'Edicion' , 227 , $_SESSION['seqUsuario'] , 'seqCruce = ' . $_POST['seqCruce'] . " por archivo" );

                        foreach($arrErrores as $i => $txtError) {
                            $this->arrErrores[] = $txtError;
                        }


                    }catch(Exception $objError){
                        $this->arrErrores[] = $objError->getMessage();
                    }
                }
            } else {

                $fchPublicacion = new DateTime(
                    array_shift(
                        obtenerDatosTabla(
                          "T_CRU_CRUCES",
                          array("seqCruce","fchCruce"),
                          "seqCruce",
                          "seqCruce = " . $_POST['seqCruce']
                        )
                    )
                );

                $sql = "
                    UPDATE t_cru_cruces SET
                        fchCruce = '" . $_POST['fchCruce'] . "',
                        txtUsuarioActualiza = '" . $_SESSION['txtUsuario'] . "',
                        seqUsuarioActualiza = " . $_SESSION['seqUsuario'] . ",
                        txtFirma = '" . $_POST['txtFirma'] . "',
                        txtElaboro = '" . $_POST['txtElaboro'] . "',
                        txtReviso = '" . $_POST['txtReviso'] . "',
                        fchActualizacionCruce = NOW()
                    WHERE seqCruce = " . $_POST['seqCruce'] . "
                ";
                $aptBd->execute($sql);

                $claRegistroActividades = new RegistroActividades();
                $this->arrErrores = $claRegistroActividades->registrarActividad(
                    'Edicion' ,
                    227 ,
                    $_SESSION['seqUsuario'] ,
                    'seqCruce = ' . $_POST['seqCruce'] . " solo edicion de la fecha de publicación del " . $fchPublicacion->format("Y-m-d") . " al " . $_POST['fchCruce']
                );

                if(empty($this->arrErrores)){
                    $txtNombre = array_shift(
                        obtenerDatosTabla(
                            "T_CRU_CRUCES",
                            array("seqCruce","txtNombre"),
                            "seqCruce",
                            "seqCruce = " . $_POST['seqCruce']
                        )
                    );
                    $this->arrMensajes[] = "Se ha modificado la fecha de publicación y datos de firmas del cruce " . mb_strtoupper($txtNombre);
                }

            }

            if(!empty($this->arrErrores)){
                $aptBd->RollbackTrans();
            }else{
                if(empty($this->arrMensajes)){
                    $this->arrMensajes[] = "Cruce editado satisfactoriamente";
                }
                $aptBd->CommitTrans();
            }

        }catch (Exception $objError){
            $this->arrErrores[] = $objError->getMessage();
            $aptBd->RollbackTrans();
        }

    }

    private function validarReglasEditar($arrArchivo){

        // quita la fila de titulos
        unset($arrArchivo[0]);

        // hallar los formularios que estan en el archivo
        // y los secuenciales de los resultados
        $arrFormulariosArchivo = array();
        $arrResultado = array();
        $arrHashArchivo = array();
        for($i = 1 ; $i <= count($arrArchivo) ; $i++ ){
            $seqResultado = intval($arrArchivo[$i][0]);
            $seqFormulario = $arrArchivo[$i][1];
            //$this->crucesPendientes($i , $seqFormulario , $_POST['seqCruce']);
            if($seqResultado != 0) {
                $arrResultado[$seqFormulario][$seqResultado] = $arrArchivo[$i];
                $txtHashArchivo = "";
                if(isset($_SESSION['arrGrupos'][3][20])) {
                    $txtHashArchivo = mb_strtolower(
                        $arrArchivo[$i][0] .
                        $arrArchivo[$i][1] .
                        $arrArchivo[$i][2] .
                        $arrArchivo[$i][3] .
                        $arrArchivo[$i][4] .
                        $arrArchivo[$i][5] .
                        $arrArchivo[$i][6] .
                        $arrArchivo[$i][7] .
                        $arrArchivo[$i][8]);
                }else{
                    $txtHashArchivo = mb_strtolower(
                        $arrArchivo[$i][0] .
                        $arrArchivo[$i][1] .
                        $arrArchivo[$i][2] .
                        $arrArchivo[$i][3] .
                        $arrArchivo[$i][4] .
                        $arrArchivo[$i][5] .
                        $arrArchivo[$i][6] .
                        $arrArchivo[$i][7] .
                        $arrArchivo[$i][8] .
                        $arrArchivo[$i][9] .
                        $arrArchivo[$i][10] .
                        $arrArchivo[$i][11]);
                }
                $arrHashArchivo[$seqFormulario][$seqResultado] = $txtHashArchivo;
            }else{
                if(! isset($_SESSION['arrGrupos'][3][20])) {
                    $this->arrErrores[] = "Error Linea " . ($i + 1) . ": No puede adicionar lineas al cruce";
                }
            }
            if(! isset($arrFormulariosArchivo[$seqFormulario])) {
                if($seqFormulario != 0) {
                    $arrFormulariosArchivo[$seqFormulario] = new FormularioSubsidios();
                    $arrFormulariosArchivo[$seqFormulario]->cargarFormulario($seqFormulario);
                    foreach ($arrFormulariosArchivo[$seqFormulario]->arrCiudadano as $seqCiudadano => $objCiudadano) {
                        if ($arrFormulariosArchivo[$seqFormulario]->seqPlanGobierno == 2 and (!in_array($objCiudadano->seqTipoDocumento, array(1, 2)))) {
                            unset($arrFormulariosArchivo[$seqFormulario]->arrCiudadano[$seqCiudadano]);
                        }
                    }
                }else{

                    $arrFormulariosArchivo[$seqFormulario] = new stdClass();
                    $arrFormulariosArchivo[$seqFormulario]->seqEstadoProceso = array_shift(
                        obtenerDatosTabla(
                            "v_frm_estado",
                            array("seqEstadoProceso","txtEstado"),
                            "txtEstado",
                            "lower(txtEstado) = '" . mb_strtolower($arrArchivo[$i][4] . "'")
                        )
                    );
                    $arrFormulariosArchivo[$seqFormulario]->arrCiudadano = array();
                    foreach($this->arrDatos['arrResultado'] as $seqResultado => $arrResultado1){
                        $numDocumento = $arrResultado1['numDocumento'];
                        $objCiudadano = new stdClass();
                        $objCiudadano->seqTipoDocumento = $arrResultado1['seqTipoDocumento'];
                        $objCiudadano->numDocumento = $arrResultado1['numDocumento'];
                        $arrFormulariosArchivo[$seqFormulario]->arrCiudadano[$numDocumento] = $objCiudadano;
                    }

                }
            }
        }

        // limpia los resultados del cruce que no tienen relacion con el archivo
        $arrFormulariosCruce = array();
        $arrHashBaseDatos = array();
        foreach($this->arrDatos['arrResultado'] as $seqResultado => $arrRegistro){
            $seqFormulario = $arrRegistro['seqFormulario'];
            if(isset($arrFormulariosArchivo[$seqFormulario])){
                $arrFormulariosCruce[$seqFormulario][$seqResultado] = $arrRegistro;
                $seqModalidad = $arrRegistro['seqModalidad'];
                $seqTipoDocumento = $arrRegistro['seqTipoDocumento'];
                $seqParentesco = $arrRegistro['seqParentesco'];
                $txtHashResultado = "";
                if(isset($_SESSION['arrGrupos'][3][20])) {
                    $txtHashResultado = mb_strtolower(
                        $seqResultado .
                        $arrRegistro['seqFormulario'] .
                        $arrRegistro['numDocumentoPrincipal'] .
                        $this->arrFormatoArchivo[3]['rango'][$seqModalidad] .
                        $arrRegistro['txtEstadoFormulario'] .
                        $this->arrFormatoArchivo[5]['rango'][$seqTipoDocumento] .
                        $arrRegistro['numDocumento'] .
                        $arrRegistro['txtNombre'] .
                        $this->arrFormatoArchivo[8]['rango'][$seqParentesco]
                    );
                }else{
                    $txtHashResultado = mb_strtolower(
                        $seqResultado .
                        $arrRegistro['seqFormulario'] .
                        $arrRegistro['numDocumentoPrincipal'] .
                        $this->arrFormatoArchivo[3]['rango'][$seqModalidad] .
                        $arrRegistro['txtEstadoFormulario'] .
                        $this->arrFormatoArchivo[5]['rango'][$seqTipoDocumento] .
                        $arrRegistro['numDocumento'] .
                        $arrRegistro['txtNombre'] .
                        $this->arrFormatoArchivo[8]['rango'][$seqParentesco] .
                        $arrRegistro['txtEntidad'] .
                        $arrRegistro['txtTitulo'] .
                        $arrRegistro['txtDetalle']
                    );
                }
                $arrHashBaseDatos[$seqFormulario][$seqResultado] = $txtHashResultado;
            }
        }

        // formularios que no pertenecen al cruce original
        foreach( array_diff_key($arrFormulariosArchivo,$arrFormulariosCruce) as $seqFormulario => $claFormulario){
            $this->arrErrores[] = "Error: El Formulario " . $seqFormulario . " no pertenece al cruce";
        }

        // resultados que no pertenecen al cruce
        foreach($arrResultado as $seqFormulario => $arrResultadosCruce){
            foreach($arrResultadosCruce as $seqResultado => $arrLineaArchivo){
                if($seqResultado != 0) {
                    if (!isset($arrFormulariosCruce[$seqFormulario][$seqResultado])) {
                        $this->arrErrores[] = "Error: El resultado " . $seqResultado . " no pertenece al cruce o no esta relacionado con el formulario " . $seqFormulario;
                    }
                    unset($this->arrDatos['arrResultado'][$seqResultado]);
                }
            }
        }

        // verifica que las lineas no hayan sido modificadas
        foreach($arrHashBaseDatos as $seqFormulario => $arrResultadosCruces){
            foreach($arrResultadosCruces as $seqResultado => $txtHashRegistro){
                if(!isset($arrHashArchivo[$seqFormulario][$seqResultado]) or $arrHashArchivo[$seqFormulario][$seqResultado] != $txtHashRegistro){
                    $this->arrErrores[] = "Error: La linea identificada con el resultado " . $seqResultado . " fue modificada y no es permitido hacerlo";
                }
            }
        }

        // valida todos los datos de la linea sin tener en cuenta
        // el seqResultado para validar las lineas nuevas
        $txtVerificacion = ($this->arrDatos['numVerificacion'] == 1)? "Primera Verificacion" : "Segunda Verificacion";
        foreach($arrArchivo as $numLinea => $arrLinea) {

            $seqFormulario = intval($arrLinea[1]);
            if(intval($arrLinea[0]) != 0) {
                $seqResultado = intval($arrLinea[0]);
            }else{
                foreach($arrFormulariosCruce[$seqFormulario] as $seqResultado => $arrDatos){
                    break;
                }
            }

            // valida postulante principal que coincida con el del cruce
            if ($arrLinea[2] != $arrFormulariosCruce[$seqFormulario][$seqResultado]['numDocumentoPrincipal']) {
                $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El postulante principal no coincide con el postulante principal del cruce";
            }

            // valida modalidad que coincida con el del cruce
            if (array_shift(array_keys($this->arrFormatoArchivo[3]['rango'], mb_strtoupper($arrLinea[3]))) != $arrFormulariosCruce[$seqFormulario][$seqResultado]['seqModalidad']) {
                $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": La modalidad no corresponde con la modalidad del cruce";
            }

            // verifica que el estado del proceso sea el mismo de la base de datos
            if ($arrFormulariosArchivo[$seqFormulario]->seqEstadoProceso != array_shift(array_keys($this->arrFormatoArchivo[4]['rango'], mb_strtoupper($arrLinea[4])))) {
                $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El estado " . $arrLinea[4] . " no corresponde el estado registrado en el sistema";
            } else {
                if($seqFormulario == 0){
                    $this->arrEstadosPermitidos['editar'][$txtVerificacion][] = $arrFormulariosArchivo[$seqFormulario]->seqEstadoProceso;
                }
                if (!in_array(array_shift(array_keys($this->arrFormatoArchivo[4]['rango'], mb_strtoupper($arrLinea[4]))), $this->arrEstadosPermitidos['editar'][$txtVerificacion])) {
                    $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El estado " . $arrLinea[4] . " no es permitido para el cargue de cruces";
                }
                if (in_array($claFormulario->seqTipoEsquema, array(5, 10, 11, 13, 15)) and $claFormulario->seqEstadoProceso == 53) {
                    $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El estado " . $arrLinea[4] . " no es permitido para el cargue de cruces debido a su esquema";
                }
            }

            if(mb_strtoupper(trim($arrLinea[12])) == "SI"){
                if(trim($arrLinea[9]) == "" or trim($arrLinea[10]) == "" or trim($arrLinea[11]) == ""){
                    $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": Si tiene indicado que va a inhabilitar la linea debe dar la Fuente, Causa y Detalle de la información";
                }
            }

            if(trim($arrLinea[9]) != "") {
                $seqFuente = array_shift(array_keys($this->arrFormatoArchivo[9]['rango'], mb_strtoupper($arrLinea[9])));
                if (intval($seqFuente) == 0) {
                    $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": No tiene una fuente conocida";
                }
            }

            if(trim($arrLinea[10]) != "") {
                $seqCausa = array_shift(array_keys($this->arrFormatoArchivo[10]['rango'][$seqFuente], mb_strtoupper($arrLinea[10])));
                if (intval($seqCausa) == 0) {
                    $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": No tiene una causa conocida";
                }
            }

            if(trim($arrLinea[9]) != "" or trim($arrLinea[10]) != "") {
                $seqCausaBaseDatos = array_shift(
                    obtenerDatosTabla(
                        "t_cru_causa",
                        array("seqFuente", "seqCausa"),
                        "seqFuente",
                        "seqFuente = " . $seqFuente . " and seqCausa = " . $seqCausa
                    )
                );

                if (intval($seqCausaBaseDatos) != intval($seqCausa)) {
                    $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": La fuente no tiene relación con la causa";
                }
            }

            // descuenta el miembro de hogar para conocer faltantes
            foreach ($arrFormulariosArchivo[$seqFormulario]->arrCiudadano as $seqCiudadano => $objCiudadano) {
                if (
                    $objCiudadano->seqTipoDocumento == array_shift(array_keys($this->arrFormatoArchivo[5]['rango'], mb_strtoupper($arrLinea[5]))) and
                    $objCiudadano->numDocumento == $arrLinea[6]
                ) {
                    unset($arrFormulariosArchivo[$seqFormulario]->arrCiudadano[$seqCiudadano]);
                }
            }

        }

        // las lineas que queden son las que hacen falta
        foreach($this->arrDatos['arrResultado'] as $seqResultado => $arrResultado){
            $seqFormulario = $arrResultado['seqFormulario'];
            if(isset($arrFormulariosCruce[$seqFormulario])) {
                $this->arrErrores[] = "Error Resultados: Falta la linea original del cruce identificada con el número de resultado " . $seqResultado;
            }
        }

        // las lineas que queden son ciudadanos del formulario que faltan
        foreach($arrFormulariosArchivo as $seqFormulario => $claFormulario){
            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                $this->arrErrores[] = "Error Ciudadanos: Falta el ciudadano " . $objCiudadano->numDocumento . " en el archivo de cruces";
            }
        }

    }

//    private function crucesPendientes($numLinea , $seqFormulario, $seqCruce){
//        global $aptBd;
//
//        $claFormulario = new FormularioSubsidios();
//        $claFormulario->cargarFormulario($seqFormulario);
//
//        $objCiudadano = $this->obtenerPrincipal($claFormulario);
//
//        $seqCruce = ($seqCruce == null)? "null" : $seqCruce;
//
//        $sql = "
//            select distinct
//              cru.txtNombre
//            from t_cru_cruces cru
//            inner join t_cru_resultado res on cru.seqCruce = res.seqCruce
//            where seqFormulario = $seqFormulario
//              and res.bolInhabilitar = 1
//              and cru.seqCruce <> $seqCruce
//        ";
//        $arrPendientes = $aptBd->GetAll($sql);
//
//        foreach ($arrPendientes as $arrCruce){
//            $this->arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ": El Hogar de " . $objCiudadano->numDocumento . " tiene cruces pendientes en el cruce " . $arrCruce['txtNombre'];
//        }
//
//    }

    public function adicionar($arrPost){
        global $aptBd;

        try{

            if($arrPost['seqFormulario'] != 0) {
                $claFormulario = new FormularioSubsidios();
                $claFormulario->cargarFormulario($arrPost['seqFormulario']);
            }else{
                $claFormulario = new stdClass();
                foreach($this->arrDatos['arrResultado'] as $seqResultado => $arrRestulado ) {
                    if($arrRestulado['numDocumento'] == $arrPost['numDocumento']) {

                        $objCiudadano = new stdClass();
                        $objCiudadano->seqTipoDocumento = $arrRestulado['seqTipoDocumento'];
                        $objCiudadano->numDocumento = $arrRestulado['numDocumento'];
                        $objCiudadano->seqParentesco = $arrRestulado['seqParentesco'];
                        $objCiudadano->txtNombre1 = $arrRestulado['txtNombre'];
                        $objCiudadano->txtNombre2 = "";
                        $objCiudadano->txtApellido1 = "";
                        $objCiudadano->txtApellido2 = "";

                        $claFormulario->arrCiudadano = $objCiudadano;
                        $claFormulario->seqModalidad = $arrRestulado['seqModalidad'];
                        $claFormulario->seqEstadoProceso = $arrRestulado['seqEstadoProceso'];

                    }
                }
            }

            $aptBd->BeginTrans();

            $txtUsuario = array_shift(
                obtenerDatosTabla(
                    "t_cor_usuario",
                    array("seqUsuario","txtNombre"),
                    "seqUsuario",
                    "seqUsuario = " . $_SESSION['seqUsuario']
                )
            );

            $arrRegistro = array();
            foreach($this->arrDatos['arrResultado'] as $seqResultado => $arrDatos){
                if($arrDatos['numDocumento'] == $arrPost['numDocumento']){
                    $arrRegistro = $arrDatos;
                    break;
                }
            }

            if(empty($arrRegistro)){
                $arrRegistro['seqModalidad'] = $claFormulario->seqModalidad;
                foreach($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano){
                    if($objCiudadano->numDocumento == $_POST['numDocumento']){
                        $arrRegistro['numDocumento'] = $_POST['numDocumento'];
                        $arrRegistro['seqTipoDocumento'] = $objCiudadano->seqTipoDocumento;
                        $arrRegistro['seqParentesco'] = $objCiudadano->seqParentesco;
                        $arrRegistro['txtNombre']    = mb_strtoupper(
                            $objCiudadano->txtNombre1 . " " .
                            $objCiudadano->txtNombre2 . " " .
                            $objCiudadano->txtApellido1 . " " .
                            $objCiudadano->txtApellido2
                        );
                        break;
                    }
                }

            }

            $arrRegistro['seqEstadoProceso'] = $claFormulario->seqEstadoProceso;

            $sql = "
                update t_cru_cruces set
                    seqUsuarioActualiza = " . $_SESSION['seqUsuario'] . ",
                    txtUsuarioActualiza = '" . $txtUsuario . "',
                    fchActualizacionCruce = now()
                 where seqCruce = " . $arrPost['seqCruce'] . "
            ";
            $aptBd->execute($sql);

            $txtFuente = mb_strtoupper(array_shift(
                obtenerDatosTabla(
                    "t_cru_fuente",
                    array("seqFuente","txtFuente"),
                    "seqFuente",
                    "seqFuente = " . $arrPost['seqFuente'] . " and seqFuente <> 8"
                )
            ));

            $txtCausa = mb_strtoupper(array_shift(
                obtenerDatosTabla(
                    "t_cru_causa",
                    array("seqCausa","txtCausa"),
                    "seqCausa",
                    "seqFuente = " . $arrPost['seqFuente'] . " and seqFuente <> 8 and seqCausa = " . $arrPost['seqCausa']
                )
            ));

            $bolInhabilitar = ($arrPost['bolInhabilitar'] == 'si')? 1: 0;

            $sql = "
                INSERT INTO t_cru_resultado(
                    seqCruce,
                    seqFormulario,
                    seqModalidad,
                    seqEstadoProceso,
                    seqTipoDocumento,
                    numDocumento,
                    txtNombre,
                    seqParentesco,
                    txtEntidad,
                    txtTitulo,
                    txtDetalle,
                    bolInhabilitar,
                    txtObservaciones
                ) VALUES (
                    " . $arrPost['seqCruce'] . ",
                    " . $arrPost['seqFormulario'] . ",
                    " . $arrRegistro['seqModalidad'] . ",
                    " . $arrRegistro['seqEstadoProceso'] . ",
                    " . $arrRegistro['seqTipoDocumento'] . ",
                    " . $arrPost['numDocumento'] . ",
                    '" . mb_strtoupper($arrRegistro['txtNombre']) . "',
                    " . $arrRegistro['seqParentesco'] . ",
                    '" . $txtFuente . "',
                    '" . $txtCausa . "',
                    '" . mb_strtoupper($arrPost['txtDetalles']) . "',
                    " . $bolInhabilitar . ",
                    '" . mb_strtoupper($arrPost['txtObservaciones']) . "'
                )
            ";

            $aptBd->execute($sql);

            $sql = "
                INSERT INTO t_cru_auditoria(
                    fchMovimiento,
                    seqUsuario,
                    seqCruce,
                    seqFormulario,
                    seqModalidad,
                    seqEstadoProceso,
                    seqTipoDocumento,
                    numDocumento,
                    txtNombre,
                    seqParentesco,
                    txtEntidad,
                    txtTitulo,
                    txtDetalle,
                    bolInhabilitar,
                    txtObservaciones
                ) VALUES (
                    now(),
                    " . $_SESSION['seqUsuario'] . ",
                    " . $arrPost['seqCruce'] . ",
                    " . $arrPost['seqFormulario'] . ",
                    " . $arrRegistro['seqModalidad'] . ",
                    " . $arrRegistro['seqEstadoProceso'] . ",
                    " . $arrRegistro['seqTipoDocumento'] . ",
                    " . $arrPost['numDocumento'] . ",
                    '" . mb_strtoupper($arrRegistro['txtNombre']) . "',
                    " . $arrRegistro['seqParentesco'] . ",
                    '" . $txtFuente . "',
                    '" . $txtCausa . "',
                    '" . mb_strtoupper($arrPost['txtDetalles']) . "',
                    " . $bolInhabilitar . ",
                    '" . mb_strtoupper($arrPost['txtObservaciones']) . "'
                )
            ";

            $aptBd->execute($sql);

            $seqFormulario = $arrPost['seqFormulario'];

            $arrInhabilitar = array();
            if($seqFormulario != 0) {
                foreach ($this->arrDatos['arrResultado'] as $seqResultado => $arrDato) {
                    if ($arrDato['seqFormulario'] == $seqFormulario) {
                        if ((!isset($arrInhabilitar[$seqFormulario])) or $arrInhabilitar[$seqFormulario]['inhabilitar'] == 0) {
                            $arrInhabilitar[$seqFormulario]['inhabilitar'] = $bolInhabilitar;
                        }
                    }
                }

                if ($arrInhabilitar[$seqFormulario]['inhabilitar'] == 0) {
                    $arrInhabilitar[$seqFormulario]['inhabilitar'] = $bolInhabilitar;
                }

                $arrInhabilitar[$seqFormulario]['estado'] = $arrRegistro['seqEstadoProceso'];
            }

            $this->cambioEstados($arrPost['seqCruce'],$arrPost['fchCruce'],$arrInhabilitar);

            $claRegistroActividades = new RegistroActividades();
            $arrErrores = $claRegistroActividades->registrarActividad( 'Edicion' , 227 , $_SESSION['seqUsuario'] , 'seqCruce = ' . $_POST['seqCruce'] . " por archivo" );

            foreach($arrErrores as $i => $txtError) {
                $this->arrErrores[] = $txtError;
            }

            if(empty($this->arrErrores)){
                if($seqFormulario == 0){
                    $this->arrMensajes[] = "Ha adicionado un nuevo cruce satisfactoriamente";
                }
                $aptBd->CommitTrans();
            }else{
                $aptBd->RollbackTrans();
            }

        } catch ( Exception $objError ){
            $aptBd->RollbackTrans();
            $this->arrErrores[] = $objError->getMessage();
        }

    }

    public function levantar($arrPost){
        global $aptBd;

        try{

            $aptBd->BeginTrans();

            if($arrPost['seqFormulario'] != 0) {
                //$this->crucesPendientes(0, $arrPost['seqFormulario'], $arrPost['seqCruce']);

                $claFormulario = new FormularioSubsidios();
                $claFormulario->cargarFormulario($arrPost['seqFormulario']);
            }

            $txtUsuario = array_shift(
                obtenerDatosTabla(
                    "t_cor_usuario",
                    array("seqUsuario","txtNombre"),
                    "seqUsuario",
                    "seqUsuario = " . $_SESSION['seqUsuario']
                )
            );

            $sql = "
                update t_cru_cruces set
                    seqUsuarioActualiza = " . $_SESSION['seqUsuario'] . ",
                    txtUsuarioActualiza = '" . $txtUsuario . "',
                    fchActualizacionCruce = now()
                 where seqCruce = " . $arrPost['seqCruce'] . "
            ";
            $aptBd->execute($sql);

            foreach($arrPost['resultado'] as $seqResultado => $arrDatos){

                $sql = "
                    update t_cru_resultado set 
                      bolInhabilitar = " . $arrDatos['bolInhabilitar'] . ",
                      txtObservaciones = '" . $arrDatos['txtObservaciones'] . "'
                    where seqResultado = $seqResultado
                ";
                $aptBd->execute($sql);

                $sql = "
                    INSERT INTO t_cru_auditoria(
                        fchMovimiento,
                        seqUsuario,
                        seqCruce,
                        seqFormulario,
                        seqModalidad,
                        seqEstadoProceso,
                        seqTipoDocumento,
                        numDocumento,
                        txtNombre,
                        seqParentesco,
                        txtEntidad,
                        txtTitulo,
                        txtDetalle,
                        bolInhabilitar,
                        txtObservaciones
                    ) VALUES (
                        now(),
                        " . $_SESSION['seqUsuario'] . ",
                        " . $arrPost['seqCruce'] . ",
                        " . $arrPost['seqFormulario'] . ",
                        " . $this->arrDatos['arrResultado'][$seqResultado]['seqModalidad'] . ",
                        " . $this->arrDatos['arrResultado'][$seqResultado]['seqEstadoProceso'] . ",
                        " . $this->arrDatos['arrResultado'][$seqResultado]['seqTipoDocumento'] . ",
                        " . $this->arrDatos['arrResultado'][$seqResultado]['numDocumento'] . ",
                        '" . mb_strtoupper($this->arrDatos['arrResultado'][$seqResultado]['txtNombre']) . "',
                        " . $this->arrDatos['arrResultado'][$seqResultado]['seqParentesco'] . ",
                        '" . $this->arrDatos['arrResultado'][$seqResultado]['txtEntidad'] . "',
                        '" . $this->arrDatos['arrResultado'][$seqResultado]['txtTitulo'] . "',
                        '" . mb_strtoupper($this->arrDatos['arrResultado'][$seqResultado]['txtDetalles']) . "',
                        " . $arrDatos['bolInhabilitar'] . ",
                        '" . mb_strtoupper($arrDatos['txtObservaciones']) . "'
                    )
                ";

                $aptBd->execute($sql);

            }

            $arrInhabilitar = array();
            if($arrPost['seqFormulario'] != 0) {
                $seqFormulario = $arrPost['seqFormulario'];
                foreach ($this->arrDatos['arrResultado'] as $seqResultado => $arrDato) {
                    if ($arrDato['seqFormulario'] == $seqFormulario) {
                        if ((!isset($arrInhabilitar[$seqFormulario])) or $arrInhabilitar[$seqFormulario]['inhabilitar'] == 0) {
                            $arrInhabilitar[$seqFormulario]['inhabilitar'] = $arrDato['bolInhabilitar'];
                        }
                    }
                }

                $arrInhabilitar[$seqFormulario]['estado'] = $claFormulario->seqEstadoProceso;
                $this->cambioEstados($arrPost['seqCruce'], $this->arrDatos['fchCruce']->format("Y-m-d"), $arrInhabilitar);

            }

            $claRegistroActividades = new RegistroActividades();
            $arrErrores = $claRegistroActividades->registrarActividad( 'Edicion' , 227 , $_SESSION['seqUsuario'] , 'seqCruce = ' . $arrPost['seqCruce'] . " levantamiento de cruces" );

            foreach($arrErrores as $i => $txtError) {
                $this->arrErrores[] = $txtError;
            }

            if(empty($this->arrErrores)){
                if($arrPost['seqFormulario'] == 0){
                    $this->arrMensajes[] = "Ha levantado el cruce satisfactoriamente";
                }
                $aptBd->CommitTrans();
            }else{
                $aptBd->RollbackTrans();
            }


        }catch(Exception $objError){
            $this->arrErrores[] = "Hubo un problema al realizar los cambios en los resultados del cruce";
            $this->arrErrores[] = $objError->getMessage();
            $aptBd->RollbackTrans();
        }

    }

}
