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
    private $arrFormatoArchivo;
    private $arrEstadosPermitidos;
    private $arrHash;

    function __construct()
    {
        $this->arrErrores  = array();
        $this->arrMensajes = array();
        $this->arrIgnorados = array();
        $this->arrDatos    = array();

        $this->arrFormatoArchivo[0]['nombre'] = "seqFormulario";
        $this->arrFormatoArchivo[0]['tipo'] = "numero";
        $this->arrFormatoArchivo[1]['nombre'] = "Postulante Principal";
        $this->arrFormatoArchivo[1]['tipo'] = "numero";
        $this->arrFormatoArchivo[2]['nombre'] = "Modalidad";
        $this->arrFormatoArchivo[2]['tipo'] = "texto";
        $this->arrFormatoArchivo[2]['rango'] = obtenerDatosTabla("t_frm_modalidad",array("seqModalidad","txtModalidad"),"seqModalidad","seqPlanGobierno in (2,3)");
        $this->arrFormatoArchivo[3]['nombre'] = "Estado";
        $this->arrFormatoArchivo[3]['tipo'] = "texto";
        $this->arrFormatoArchivo[3]['rango'] = estadosProceso();
        $this->arrFormatoArchivo[4]['nombre'] = "Tipo_Documento";
        $this->arrFormatoArchivo[4]['tipo'] = "texto";
        $this->arrFormatoArchivo[4]['rango'] = obtenerDatosTabla("t_ciu_tipo_documento",array("seqTipoDocumento","txtTipoDocumento"),"seqTipoDocumento","seqTipoDocumento not in (6,8)");
        $this->arrFormatoArchivo[5]['nombre'] = "Documento";
        $this->arrFormatoArchivo[5]['tipo'] = "numero";
        $this->arrFormatoArchivo[6]['nombre'] = "Nombre";
        $this->arrFormatoArchivo[6]['tipo'] = "texto";
        $this->arrFormatoArchivo[7]['nombre'] = "Parentesco";
        $this->arrFormatoArchivo[7]['tipo'] = "texto";
        $this->arrFormatoArchivo[7]['rango'] = obtenerDatosTabla("t_ciu_parentesco",array("seqParentesco","txtParentesco"),"seqParentesco","bolActivo = 1");
        $this->arrFormatoArchivo[8]['nombre'] = "Entidad";
        $this->arrFormatoArchivo[8]['tipo'] = "texto";
        $this->arrFormatoArchivo[9]['nombre'] = "Causa";
        $this->arrFormatoArchivo[9]['tipo'] = "texto";
        $this->arrFormatoArchivo[10]['nombre'] = "Detalle";
        $this->arrFormatoArchivo[10]['tipo'] = "texto";
        $this->arrFormatoArchivo[11]['nombre'] = "Inhabilitar";
        $this->arrFormatoArchivo[11]['tipo'] = "texto";
        $this->arrFormatoArchivo[11]['rango'][] = "si";
        $this->arrFormatoArchivo[11]['rango'][] = "no";
        $this->arrFormatoArchivo[11]['rango'][] = "SI";
        $this->arrFormatoArchivo[11]['rango'][] = "NO";
        $this->arrFormatoArchivo[11]['rango'][] = "Si";
        $this->arrFormatoArchivo[11]['rango'][] = "No";
        $this->arrFormatoArchivo[12]['nombre'] = "Observaciones";
        $this->arrFormatoArchivo[12]['tipo'] = "texto";

        /**
         * Estados en los que se puede crear un cruce
         * - Primera Verificacion
         *      - [53] Calificado - EPI
         *      - [44] Primera Verificacion - CEM
         * - Segunda Verificacion
         *      - [47] Postulado EPI / CEM
         */
        $this->arrEstadosPermitidos['crear'] = array(53,44,47);

        /**
         * Estados en los que se puede levantar cruces
         * - Primera Verificacion
         *      - [45] Calificado - EPI / CEM
         * - Segunda Verificacion
         *      - [56] Postulado EPI / CEM
         */
        $this->arrEstadosPermitidos['editar'] = array(44,45,56); // CF - Proyectos gestionado por la SDHT

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
        $txtCondicionDocumento = (intval($arrPost['documento']) != 0)? " AND numDocumento = " . intval($arrPost['documento'])  : "";

        $arrCruces = array();
        $sql = "
            SELECT DISTINCT 
                cru.seqCruce,
                cru.txtNombre,
                cru.fchCruce,
                cru.fchCreacionCruce,
                cru.fchActualizacionCruce
            FROM t_cru_cruces cru
            INNER JOIN t_cru_resultado res ON cru.seqCruce = res.seqCruce AND res.seqParentesco = 1
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
            $arrCruces[$seqCruce]['txtNombre']             = $objRes->fields['txtNombre'];
            $arrCruces[$seqCruce]['fchCruce']              = new DateTime($objRes->fields['fchCruce']);
            $arrCruces[$seqCruce]['fchCreacionCruce']      = new DateTime($objRes->fields['fchCreacionCruce']);
            $arrCruces[$seqCruce]['fchActualizacionCruce'] = new DateTime($objRes->fields['fchActualizacionCruce']);
            $objRes->MoveNext();
        }
        return $arrCruces;
    }

    public function validarFormulario($arrPost){

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

    public function cargarArchivo(){
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
                        $arrArchivo[$numLinea] = explode("\t", utf8_encode(trim($txtLinea)));
                        foreach( $arrArchivo[$numLinea] as $numColumna => $txtCelda ){
                            if( $numColumna < count( $this->arrFormatoArchivo ) ) {
                                $arrArchivo[$numLinea][$numColumna] = trim($txtCelda);
                            }else{
                                unset( $arrArchivo[$numLinea][$numColumna] );
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

    public function validarArchivo($arrArchivo){
        foreach( $this->arrFormatoArchivo as $numColumna => $arrCelda ){
            for( $numFila = 1; $numFila < count($arrArchivo); $numFila++ ){
                if( $arrArchivo[$numFila][$numColumna] != "" ) {
                    $bolError = false;
                    switch ($arrCelda['tipo']) {
                        case "numero":
                            $bolError = ( is_numeric( $arrArchivo[$numFila][$numColumna] ) )? false : true;
                            break;
                        case "fecha":
                            $bolError = ( esFechaValida( $arrArchivo[$numFila][$numColumna] ) )? false : true;
                            break;
                    }
                    if( $bolError ){
                        $this->arrErrores[] = "Error Linea " . ($numFila + 1) . " columna " . $arrCelda['nombre'] . " el valor debe ser " . $arrCelda['tipo'];
                    }
                    if( isset( $arrCelda['rango'] ) ){
                        if( ! in_array( $arrArchivo[$numFila][$numColumna] , $arrCelda['rango'] ) ){
                            $this->arrErrores[] = "Error Linea " . ($numFila + 1) . " columna " . $arrCelda['nombre'] . " " . $arrArchivo[$numFila][$numColumna] . " no es un valor válido" ;
                        }
                    }
                }
            }
        }
    }

    public function salvar($arrPost,$arrArchivo){
        global $aptBd;
        try{
            $aptBd->BeginTrans();
            $this->validarReglasBasicas($arrArchivo,'crear');
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
                        fchActualizacionCruce
                    ) VALUES (
                        '" . $arrPost['txtNombre'] . "',
                        '" . $arrPost['fchCruce']  . "',
                        '" . $arrPost['txtCuerpo']  . "',
                        '" . $arrPost['txtPie']  . "',
                        '" . $arrPost['txtFirma']  . "',
                        '" . $arrPost['txtElaboro']  . "',
                        '" . $arrPost['txtReviso']  . "',
                        NOW(),
                        '" . $_SESSION['txtUsuario'] . "',
                        '" . $_FILES['archivo']['name'] . "',
                        " . $_SESSION['seqUsuario'] . ",
                        null,
                        null,
                        null,
                        null
                    )
                ";
                $aptBd->execute($sql);
                $seqCruce = $aptBd->Insert_ID();
                $arrInhabilitar = array();
                unset($arrArchivo[0]);
                foreach($arrArchivo as $numLinea => $arrLinea){
                    $bolInhabilitar = (strtolower($arrLinea[11]) == "no")? 0 : 1;
                    $seqFormulario = $arrLinea[0];
                    if((!isset($arrInhabilitar[$seqFormulario])) or $arrInhabilitar[$seqFormulario]['inhabilitar'] == 0) {
                        $arrInhabilitar[$seqFormulario]['inhabilitar'] = $bolInhabilitar;
                        $arrInhabilitar[$seqFormulario]['estado'] = array_shift(array_keys($this->arrFormatoArchivo[3]['rango'],$arrLinea[3]));
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
                            " . array_shift(array_keys($this->arrFormatoArchivo[2]['rango'],$arrLinea[2])) . ",
                            " . array_shift(array_keys($this->arrFormatoArchivo[3]['rango'],$arrLinea[3])) . ",
                            " . array_shift(array_keys($this->arrFormatoArchivo[4]['rango'],$arrLinea[4])) . ",
                            " . $arrLinea[5] . ",
                            '" . strtoupper($arrLinea[6]) . "',
                            " . array_shift(array_keys($this->arrFormatoArchivo[7]['rango'],$arrLinea[7])) . ",
                            '" . strtoupper($arrLinea[8]) . "',
                            '" . strtoupper($arrLinea[9]) . "',
                            '" . strtoupper($arrLinea[10]) . "',
                            " . $bolInhabilitar . ",
                            '" . strtoupper($arrLinea[12]) . "'
                        )
                    ";
                    $aptBd->execute($sql);
                }
                $this->cambioEstados($seqCruce,$arrPost['fchCruce'],$arrInhabilitar);
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

    private function validarReglasBasicas($arrArchivo,$txtModo){
        global $arrConfiguracion;
        $arrFormularios = array();
        unset($arrArchivo[0]);
        foreach($arrArchivo as $numLinea => $arrLinea) {

            // obtiene los datos del formulario
            $seqFormulario = $arrLinea[0];
            if (!isset($arrFormularios[$seqFormulario])) {
                $claFormulario = new FormularioSubsidios();
                $claFormulario->cargarFormulario($arrLinea[0]);
            } else {
                $claFormulario = $arrFormularios[$seqFormulario];
            }

            // validacion en otros cruces
            $this->crucesPendientes($numLinea , $seqFormulario);

            /**
             * validaciones de integridad de datos
             * aplica para la segunda validacion ( segundo cruce )
             */
            if($claFormulario->seqEstadoProceso == 47 || $claFormulario->seqEstadoProceso == 56 ) {

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
                }else{
                    if($claFormulario->bolDesplazado == 1){
                        $txtMensaje = "Error Formulario " . $seqFormulario . ": Es hogar victima con localidad dentro de bogotá";
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

                if($claFormulario->valIngresoHogar <= ($arrConfiguracion['constantes']['salarioMinimo'] * 2)){
                    $txtMensaje = "Error Formulario " . $seqFormulario . ": Hogar con ingresos superiores a 2 SMMLV";
                    if (!in_array($txtMensaje, $this->arrErrores)) {
                        $this->arrErrores[] = $txtMensaje;
                    }
                }

            }

            /**
             * validaciones generales
             */

            // verifica que corresponda el postulante principal
            $objCiudadano = $this->obtenerPrincipal($claFormulario);
            if($objCiudadano->numDocumento != $arrLinea[1]){
                $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El documento " . $arrLinea[1] . " no es el postulante principal";
            }

            // verifica que la modalidad sea la misma de la base de datos
            if($claFormulario->seqModalidad != array_shift(array_keys($this->arrFormatoArchivo[2]['rango'],$arrLinea[2]))){
                $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": La modalidad " . $arrLinea[2] . " no corresponde con la registrada en el sistema";
            }else{
                $arrModalidad[$claFormulario->seqModalidad] = 1;
            }

            // verifica que el estado del proceso sea el mismo de la base de datos
            // y verifica que este en estado Inscrito - Calificado
            if($claFormulario->seqEstadoProceso != array_shift(array_keys($this->arrFormatoArchivo[3]['rango'],$arrLinea[3]))){
                $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El estado " . $arrLinea[3] . " no corresponde el estado registrado en el sistema";
            }else{
                if($txtModo == 'crear') {
                    if (!in_array(array_shift(array_keys($this->arrFormatoArchivo[3]['rango'], $arrLinea[3])), $this->arrEstadosPermitidos[$txtModo])) {
                        $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El estado " . $arrLinea[3] . " no es permitido para el cargue de cruces";
                    }
                    if(in_array($claFormulario->seqTipoEsquema , array( 5 , 10 , 11 , 13 , 15 )) and $claFormulario->seqEstadoProceso == 53){
                        $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El estado " . $arrLinea[3] . " no es permitido para el cargue de cruces";
                    }
                }
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
                    $seqTipoDocumento = array_shift(array_keys($this->arrFormatoArchivo[4]['rango'], $arrLinea[4]));
                    if ($objCiudadano->seqTipoDocumento != $seqTipoDocumento) {
                        $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El tipo de documento no concuerda con el registrado en el sistema";
                    }
                    if ($this->obtenerNombre($objCiudadano) != strtolower(trim($arrLinea[6]))) {
                        $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El nombre no concuerda con el registrado en el sistema";
                    }
                    $seqParentesco = array_shift(array_keys($this->arrFormatoArchivo[7]['rango'], $arrLinea[7]));
                    if($objCiudadano->seqParentesco != $seqParentesco){
                        $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El parentesco no concuerda con el registrado en el sistema";
                    }
                }
            }

            // lineas del archivo que no corresponden al hogar
            if(!$bolCiudadanoEncontrado){
                $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El documento " . $arrLinea[5] . " no pertenece al hogar";
            }

            // si esta en inhabilitar si (1) debe tener Entidad - Causa - Detalle
            if(strtolower($arrLinea[11]) == "si"){
                if(trim($arrLinea[8]) == "" or trim($arrLinea[9]) == "" or trim($arrLinea[10]) == ""){
                    $this->arrErrores[] = "Error Linea " .  ($numLinea + 1) . ": Debe dar Entidad - Causa - Detalle para inhabilitar la linea";
                }
            }

        }

        // los que queden dentro de arrHogar son los que faltan dentro del archivo
        foreach($arrHogar as $seqFormulario => $arrCiudadanos){
            foreach ($arrCiudadanos as $numDocumento => $tmp){
                if(isset($arrHogarArchivo[$seqFormulario][$numDocumento])){
                    unset($arrHogar[$seqFormulario][$numDocumento]);
                }
            }
        }

        // verifica los miembros de hogar que faltan dentro del archivo
        if(!empty($arrHogar)){
            foreach($arrHogar as $seqFormulario => $arrCiudadano) {
                foreach($arrCiudadano as $numDocumento => $seqCiudadano) {
                    $this->arrErrores[] = "Error Formulario " . $seqFormulario . ": El documento " . $numDocumento . " no se encuentra dentro del archivo";
                }
            }
        }

        // verifica que el archivo tenga una sola modalidad
        if(count($arrModalidad) > 1){
            $this->arrErrores[] = "No puede tener mas de una modalidad dentro del archivo";
        }
    }

    private function obtenerPrincipal($claFormulario){
        $objCiudadano = null;
        foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano){
            if($objCiudadano->seqParentesco == 1){
                break;
            }
        }
        return $objCiudadano;
    }

    private function obtenerNombre($objCiudadano){
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

                if($seqEstadoProceso == 53 || $seqEstadoProceso == 45) {
                    $seqEstadoProceso = ($bolInhabilitar == 1) ? 45 : 46;
                    $arrSeguimiento['txtComentario'] = "Primera verificación realizada";
                }elseif($seqEstadoProceso == 47 || $seqEstadoProceso == 56){
                    $seqEstadoProceso = ($bolInhabilitar == 1) ? 56 : 16;
                    $arrSeguimiento['txtComentario'] = "Segunda verificación realizada";
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
                    where seqFormulario = " . $seqFormulario;
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
                $this->arrErrores = $claCasaMano->arrErrores;
            }

            $arrSeguimiento['seqGrupoGestion'] = 11; // revision interna
            $arrSeguimiento['seqGestion'] = 46;      // actualizacion de estado
            $arrSeguimiento['seqFormulario'] = $seqFormulario;
            $arrSeguimiento['seqEstadoProceso'] = $seqEstadoProceso;

            $objCiudadano = $this->obtenerPrincipal($claCasaMano->objPostulacion);
            $arrSeguimiento['cedula'] = $objCiudadano->numDocumento;
            $arrSeguimiento['nombre'] = $this->obtenerNombre($objCiudadano);

            $claSeguimiento = new Seguimiento();
            $claSeguimiento->salvarSeguimiento($arrSeguimiento,"cambiosCruces");

            if(!empty($claSeguimiento->arrErrores)) {
                foreach ($claSeguimiento->arrErrores as $txtError) {
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

    public function cargar($seqCruce){
        global $aptBd;

        $arrEstados = estadosProceso();

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
                cru.fchActualizacionCruce
            FROM t_cru_cruces cru
            inner join t_cor_usuario usu on cru.txtUsuario = usu.txtUsuario 
            left join t_cor_usuario usu1 on cru.txtUsuarioActualiza = usu1.txtUsuario 
            WHERE seqCruce = $seqCruce
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){

            $this->arrDatos['seqCruce'] = $objRes->fields['seqCruce'];
            $this->arrDatos['txtNombre'] = strtoupper($objRes->fields['txtNombre']);
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

            $objRes->MoveNext();
        }

        $sql = "
            select 
                res.seqResultado,
                res.seqCruce,
                res.seqFormulario,
                res.seqModalidad,
                res.seqEstadoProceso,
                res.seqTipoDocumento,
                res.numDocumento,
                res.txtNombre,
                res.seqParentesco,
                res.txtEntidad,
                res.txtTitulo,
                res.txtDetalle,
                res.bolInhabilitar,
                res.txtObservaciones
            from t_cru_resultado res
            where seqCruce = $seqCruce
            order by res.seqFormulario, res.numDocumento
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields) {
            $seqResultado = $objRes->fields['seqResultado'];
            $seqFormulario = $objRes->fields['seqFormulario'];
            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario($seqFormulario);
            $objCiudadano = $this->obtenerPrincipal($claFormulario);
            foreach ($objRes->fields as $txtCampo => $txtValor) {
                $this->arrDatos['arrResultado'][$seqResultado][$txtCampo] = $txtValor;
            }
            $this->arrDatos['arrResultado'][$seqResultado]['numDocumentoPrincipal'] = $objCiudadano->numDocumento;
            $this->arrDatos['arrResultado'][$seqResultado]['txtNombrePrincipal'] = mb_strtoupper($this->obtenerNombre($objCiudadano));
            $this->arrDatos['arrResultado'][$seqResultado]['txtEstado'] = $arrEstados[$objRes->fields['seqEstadoProceso']];
            $this->arrDatos['arrResultado'][$seqResultado]['txtEstadoFormulario'] = $arrEstados[$claFormulario->seqEstadoProceso];
            $this->arrDatos['arrResultado'][$seqResultado]['seqEstadoProceso'] = $claFormulario->seqEstadoProceso;

            $this->arrHash[
                $objCiudadano->numDocumento .
                $objRes->fields['numDocumento'] .
                mb_strtolower($objRes->fields['txtEntidad']) .
                mb_strtolower($objRes->fields['txtTitulo']) .
                mb_strtolower($objRes->fields['txtDetalle'])
            ] = $seqResultado;

            $objRes->MoveNext();
        }

    }

    public function editar($arrPost,$arrArchivo){
        global $aptBd;
        try{
            $aptBd->BeginTrans();
            $this->validarReglasBasicas($arrArchivo,'editar');
            $this->validarReglasEditar($arrArchivo);

            if(empty($this->arrErrores)){

                $sql = "
                    UPDATE t_cru_cruces SET
                        fchCruce = '" . $arrPost['fchCruce'] . "',
                        txtUsuarioActualiza = '" . $_SESSION['txtUsuario'] . "',
                        txtNombreArchivoActualiza = '" . $_FILES['archivo']['name'] . "',
                        seqUsuarioActualiza = " . $_SESSION['seqUsuario'] . ",
                        fchActualizacionCruce = NOW()
                    WHERE seqCruce = " . $arrPost['seqCruce'] . "
                ";
                $aptBd->execute($sql);

                $arrInhabilitar = array();
                unset($arrArchivo[0]);
                foreach($arrArchivo as $numLinea => $arrLinea){

                    if(! in_array(array_shift(array_keys($this->arrFormatoArchivo[3]['rango'],$arrLinea[3])),$this->arrEstadosPermitidos['editar'])){
                        $numDocumentoPrincipal = $arrLinea[1];
                        $this->arrIgnorados[$numDocumentoPrincipal] = $numDocumentoPrincipal;
                    }else{

                        $bolInhabilitar = (strtolower($arrLinea[11]) == "no")? 0 : 1;
                        $seqFormulario = $arrLinea[0];
                        if((!isset($arrInhabilitar[$seqFormulario])) or $arrInhabilitar[$seqFormulario]['inhabilitar'] == 0) {
                            $arrInhabilitar[$seqFormulario]['inhabilitar'] = $bolInhabilitar;
                            $arrInhabilitar[$seqFormulario]['estado'] = array_shift(array_keys($this->arrFormatoArchivo[3]['rango'],$arrLinea[3]));
                        }

                        $txtHash =
                            $arrLinea[1] .
                            $arrLinea[5] .
                            mb_strtolower($arrLinea[8]) .
                            mb_strtolower($arrLinea[9]) .
                            mb_strtolower($arrLinea[10]);

                        if(! isset( $this->arrHash[$txtHash] )) {
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
                                    " . $arrLinea[0] . ",
                                    " . array_shift(array_keys($this->arrFormatoArchivo[2]['rango'], $arrLinea[2])) . ",
                                    " . array_shift(array_keys($this->arrFormatoArchivo[3]['rango'], $arrLinea[3])) . ",
                                    " . array_shift(array_keys($this->arrFormatoArchivo[4]['rango'], $arrLinea[4])) . ",
                                    " . $arrLinea[5] . ",
                                    '" . strtoupper($arrLinea[6]) . "',
                                    " . array_shift(array_keys($this->arrFormatoArchivo[7]['rango'], $arrLinea[7])) . ",
                                    '" . strtoupper($arrLinea[8]) . "',
                                    '" . strtoupper($arrLinea[9]) . "',
                                    '" . strtoupper($arrLinea[10]) . "',
                                    " . $bolInhabilitar . ",
                                    '" . strtoupper($arrLinea[12]) . "'
                                )
                            ";
                        }else{
                            $sql = "
                                UPDATE t_cru_resultado SET
                                    bolInhabilitar = " . $bolInhabilitar . ",
                                    txtObservaciones = '" . strtoupper($arrLinea[12]) . "'
                                WHERE seqResultado = " . $this->arrHash[$txtHash] . "
                            ";
                        }
                        $aptBd->execute($sql);
                    }
                }
                $this->cambioEstados($arrPost['seqCruce'],$arrPost['fchCruce'],$arrInhabilitar);
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

    private function validarReglasEditar($arrArchivo){
        $arrHash = $this->arrHash;
        $numLineas = count($arrArchivo);
        $arrFormularios = array();
        unset($arrArchivo[0]);

        foreach($arrArchivo as $numLinea => $arrLinea){
            $seqFormulario = $arrLinea[0];
            $arrFormularios[$seqFormulario] = true;

            $txtHash =
                $arrLinea[1] .
                $arrLinea[5] .
                mb_strtolower($arrLinea[8]) .
                mb_strtolower($arrLinea[9]) .
                mb_strtolower($arrLinea[10]);

            unset($arrHash[$txtHash]);

        }

        if(! empty($arrHash)){
            $this->arrErrores[] = "No puede alterar las lineas originales del cruce";
        }

        $numFormularios = count($arrFormularios);

        if($numLineas < count($this->arrDatos['arrResultado'])){
            $this->arrErrores[] = "No puede incluir menos lineas de las que originalmente tiene el cruce";
        }

        $arrFormularios = array();
        foreach($this->arrDatos['arrResultado'] as $seqResultado => $arrDato){
            $seqFormulario = $arrDato['seqFormulario'];
            $arrFormularios[$seqFormulario] = true;
        }

        if($numFormularios != count($arrFormularios)){
            $this->arrErrores[] = "No puede alterar la cantidad de hogares del cruce";
        }

    }

    private function crucesPendientes($numLinea , $seqFormulario){
        global $aptBd;

        $claFormulario = new FormularioSubsidios();
        $claFormulario->cargarFormulario($seqFormulario);

        $objCiudadano = $this->obtenerPrincipal($claFormulario);

        $sql = "
            select distinct
              cru.txtNombre
            from t_cru_cruces cru
            inner join t_cru_resultado res on cru.seqCruce = res.seqCruce
            where seqFormulario = $seqFormulario 
            and res.bolInhabilitar = 1
        ";
        $arrPendientes = $aptBd->GetAll($sql);
        foreach ($arrPendientes as $arrCruce){
            $this->arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ": El Hogar de " . $objCiudadano->numDocumento . " tiene cruces pendientes en el cruce " . $arrCruce['txtNombre'];
        }

    }

}
