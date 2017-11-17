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
    private $arrFormatoArchivo;

    function __construct()
    {
        $this->arrErrores = array();

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

            $this->validarReglasCrear($arrArchivo);




//            $this->arrErrores[] = "prueba";
            if (!empty($this->arrErrores)) {
                throw new Exception(array_shift($this->arrErrores));
            }

            $aptBd->CommitTrans();

        } catch (Exception $objError) {
            $aptBd->RollbackTrans();
            $this->arrErrores[] = $objError->getMessage();
        }


    }

    private function validarReglasCrear($arrArchivo){

        $arrFormularios = array();

        unset($arrArchivo[0]);
        foreach($arrArchivo as $numLinea => $arrLinea){

            $seqFormulario = $arrLinea[0];
            if(!isset($arrFormularios[$seqFormulario])){
                $claFormulario = new FormularioSubsidios();
                $claFormulario->cargarFormulario($arrLinea[0]);
            }

            $objCiudadano = $this->obtenerPrincipal($claFormulario);
            if($objCiudadano->numDocumento != $arrLinea[1]){
                $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El documento " . $arrLinea[1] . " no es el postulante principal";
            }

            if($claFormulario->seqModalidad != array_shift(array_keys($this->arrFormatoArchivo[2]['rango'],$arrLinea[2]))){
                $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": La modalidad " . $arrLinea[2] . " no corresponde con la registrada en el sistema";
            }

            if($claFormulario->seqEstadoProceso != array_shift(array_keys($this->arrFormatoArchivo[3]['rango'],$arrLinea[3]))){
                $this->arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El estado " . $arrLinea[3] . " no corresponde el estado registrado en el sistema";
            }

            // correspondencia de ciudadanos


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

}
