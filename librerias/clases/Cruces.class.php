<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cruces
 *
 * @author lbastoz
 */
class Cruces {

    //put your code here

    function Cruces() {
        
    }

    function validarDocumentos($separado_por_comas) {
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

    function validarCruceExiste($grupo, $fch) {
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

    function obtenerFormularios($separado_por_comas) {

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

    function insertarReporteGrupo($grupo) {

        global $aptBd;
        $sql = "INSERT INTO t_pre_grupo (txtPreCruGrupo,fchPreCruGrupo) VALUES ('" . $grupo . "',NOW());";
        $objRes = $aptBd->execute($sql);
        return $aptBd->Insert_ID();
    }

    function insertarReporteGeneral($formularios, $fch, $grupo, $user) {

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

    function obtenerDatosGrupo() {
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

    function validarDocumentosAfiliados($separado_por_comas, $grupo) {
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

    function InsertarCruces($array, $grupo) {

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
        $valueInsert ="";
        if ($objRes->_numOfRows > 0) {
            if ($aptBd->ErrorMsg() == "") {
                $cont = 1;
                while ($objRes->fields) {
                    foreach ($array['Documento'] as $key => $value) {
                        if ($value == $objRes->fields['numDocumento']) {
                              $valueInsert .= "(".$objRes->fields['seqFormulario'].", 'SI','".$objRes->fields['txtModalidad']."','".$objRes->fields['Desplazado']."',".$objRes->fields['DocumentoPPAL'].",'";
                              $valueInsert .= $objRes->fields['txtFormulario']."',".$objRes->fields['numDocumento'].",'".$objRes->fields['Nombre']."','".$objRes->fields['txtParentesco']."','";
                              $valueInsert .= "Afiliación CCF', 'FONVIVIENDA','Entidad:".$array['Entidad'][$key]."', '', 1,'".$objRes->fields['estadoProceso']."','".$objRes->fields['TipoDocumento']."'),";
                           // echo "<br>" . $cont . " -> " . $value . " ==" . $objRes->fields['numDocumento'];
                            $cont++;
                        }
                    }
                    $objRes->MoveNext();
                }
                $valueInsert = substr_replace($valueInsert, ';', -1, 1);
                echo $insertCons."".$valueInsert;
                $aptBd->execute($insertCons."".$valueInsert);
            }
            
        }
    }

}
