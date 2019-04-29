<?php

//include './Reportes.class.php';

class OptimizacionFac {

    public $seqFormularios;

    public function OptimizacionFac() {

        $this->arrSeqFormularios = array();
    }

// fin constructor de la clase

    public function crearTablaFacAsig($estados, $tipo) {

        global $aptBd;
        $array = Array();

        $sqlEstados = "SELECT group_concat(seqEstadoProceso) as estados FROM t_frm_estado_proceso where seqEstadoProcesoActo in(" . $estados . ")";
        $objResEstados = $aptBd->execute($sqlEstados);

        $sql = "INSERT INTO t_fnv_optimizacion_fac
                (
                seqFormulario,
                numNit,
                txtEntidad,
                txtTipoDocumento,
                numDocumento,
                txtNombreCiudadano,
                fchActo,
                numActo,
                valAsignado,
                numTipo,
                numFormTipo,
                txtObservacion)
                SELECT 
                    seqFormulario,
                    '8999990619' AS numNit,
                    'SECRETARÍA DISTRITAL DE HÁBITAT' AS txtEntidad,
                    txtTipoDocumento,
                    numDocumento,
                    txtNombre,
                    fchActo,
                    numActo,
                    valAspira,
                    '" . $tipo . "',
                    tipoForm,
                    txtEstado
                FROM
                    ((SELECT 
                        fac.seqFormulario,
                            txtTipoDocumento,
                            UPPER(CONCAT(cac.txtNombre1, ' ', cac.txtNombre2, ' ', cac.txtApellido1, ' ', cac.txtApellido2)) AS txtNombre,
                            cac.numDocumento,
                            hvi.fchActo,
                            hvi.numActo,
                            (fac.valAspiraSubsidio + fac.valComplementario + fac.valCartaLeasing) AS valAspira,
                           CONCAT(txtEtapa, ' ',vEst.txtEstadoProceso) as txtEstado,
                            1 AS tipoForm,
                            cac.seqCiudadano
                    FROM
                        t_aad_formulario_acto fac
                    INNER JOIN t_aad_hogar_acto hac ON fac.seqFormularioActo = hac.seqFormularioActo
                    INNER JOIN t_aad_ciudadano_acto cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                    INNER JOIN t_ciu_ciudadano ciu ON cac.seqCiudadano = ciu.seqCiudadano
                    INNER JOIN t_aad_hogares_vinculados hvi ON fac.seqFormularioActo = hvi.seqFormularioActo
                    LEFT JOIN t_frm_estado_Proceso vEst ON fac.seqEstadoProceso = vEst.seqEstadoProceso
                    LEFT JOIN t_frm_etapa USING(seqEtapa)
                    LEFT JOIN t_ciu_tipo_documento tdoc ON cac.seqTipoDocumento = tdoc.seqTipoDocumento
                    WHERE
                        hvi.seqTipoActo in(1,3,5)
                            AND (cac.seqTipoDocumento IN (1 , 2)
                            OR (cac.seqTipoDocumento = 7
                            AND YEAR(CURDATE()) - YEAR(cac.fchNacimiento) + IF(DATE_FORMAT(CURDATE(), '%m-%d') >= DATE_FORMAT(cac.fchNacimiento, '%m-%d'), 0, - 1) >= 18)
                            OR (cac.seqTipoDocumento = 8
                            AND YEAR(CURDATE()) - YEAR(cac.fchNacimiento) + IF(DATE_FORMAT(CURDATE(), '%m-%d') >= DATE_FORMAT(cac.fchNacimiento, '%m-%d'), 0, - 1) >= 18))
                            AND fac.seqEstadoProceso IN (" . $estados . ")) 
                 UNION (SELECT 
                            frm.seqFormulario,
                            txtTipoDocumento,
                            UPPER(CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS txtNombre,
                            ciu.numDocumento,
                            hvi.fchActo,
                            hvi.numActo,
                            (frm.valAspiraSubsidio + frm.valComplementario + frm.valCartaLeasing) AS valAspira,
                            CONCAT(txtEtapa, ' ',vEst.txtEstadoProceso) as txtEstado,
                            1 AS tipoForm,
                            ciu.seqCiudadano
                    FROM
                        t_frm_formulario frm
                    INNER JOIN t_frm_hogar hog ON frm.seqFormulario = hog.seqFormulario
                    INNER JOIN t_ciu_ciudadano ciu ON hog.seqCiudadano = ciu.seqCiudadano
                    INNER JOIN t_aad_formulario_acto fac ON frm.seqFormulario = fac.seqFormulario
                    INNER JOIN t_aad_hogares_vinculados hvi ON fac.seqFormularioActo = hvi.seqFormularioActo
                    LEFT JOIN t_frm_estado_Proceso vEst ON fac.seqEstadoProceso = vEst.seqEstadoProceso
                    LEFT JOIN t_frm_etapa USING(seqEtapa)
                    LEFT JOIN t_ciu_tipo_documento tdoc ON ciu.seqTipoDocumento = tdoc.seqTipoDocumento
                    WHERE
                        hvi.seqTipoActo in(1,3,5) 
                            AND (ciu.seqTipoDocumento IN (1 , 2)
                            OR (ciu.seqTipoDocumento = 7
                            AND YEAR(CURDATE()) - YEAR(ciu.fchNacimiento) + IF(DATE_FORMAT(CURDATE(), '%m-%d') >= DATE_FORMAT(ciu.fchNacimiento, '%m-%d'), 0, - 1) >= 18)
                            OR (ciu.seqTipoDocumento = 8
                            AND YEAR(CURDATE()) - YEAR(ciu.fchNacimiento) + IF(DATE_FORMAT(CURDATE(), '%m-%d') >= DATE_FORMAT(ciu.fchNacimiento, '%m-%d'), 0, - 1) >= 18))
                            AND frm.seqEstadoProceso IN (" . $objResEstados->fields['estados'] . ")) ORDER BY numDocumento) frm
                GROUP BY seqFormulario , seqCiudadano , txtTipoDocumento , numDocumento , numActo , fchActo";
        //  echo "<br>" . $sql;        
        try {
            $objRes = $aptBd->execute($sql);
            return true;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    public function eliminarTablaFac($tipo) {

        global $aptBd;
        $array = Array();

        $sql = "DELETE FROM t_fnv_optimizacion_fac WHERE numTipo >= " . $tipo;
        try {
            $objRes = $aptBd->execute($sql);
            return true;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    public function SalvarInhabilitados($estados, $tipo) {

        global $aptBd;
        $array = Array();

        $sql = "INSERT INTO t_fnv_optimizacion_fac
                (
                seqFormulario,
                numNit,
                txtEntidad,
                txtTipoDocumento,
                numDocumento,
                txtNombreCiudadano,
                fchActo,
                numActo,
                valAsignado,
                numTipo,
                numFormTipo,
                txtObservacion)
                select 
                  frm.seqFormulario,
                    '8999990619' AS numNit,
                    'SECRETARÍA DISTRITAL DE HÁBITAT' AS txtEntidad,
                    txtTipoDocumento,
                    numDocumento,
                    UPPER(CONCAT(ciu.txtNombre1,
                                    ' ',
                                    ciu.txtNombre2,
                                    ' ',
                                    ciu.txtApellido1,
                                    ' ',
                                    ciu.txtApellido2)) AS txtNombre,
                    null as fchActo,
                    0 as numActo,
                    0 as valAsignado,
                    " . $tipo . " as numTipo,
                    null AS numFormTipo,
                    vEst.txtEstado as txtEstado                  
                    FROM
                        T_FRM_FORMULARIO frm
                            INNER JOIN
                        T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
                            INNER JOIN
                        T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
                            LEFT JOIN
                        T_CIU_PARENTESCO par ON hog.seqParentesco = par.seqParentesco
                            LEFT JOIN
                        v_frm_estado vEst ON frm.seqEstadoProceso = vEst.seqEstadoProceso
                         LEFT JOIN 
                         t_ciu_tipo_documento tdoc ON ciu.seqTipoDocumento = tdoc.seqTipoDocumento
                        where 
                        frm.seqEstadoProceso in (" . $estados . ")";
        try {
            $objRes = $aptBd->execute($sql);
            return true;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    function insertarFACFile($value) {

        global $aptBd;
        $array = Array();

        $sql = "INSERT INTO t_fnv_optimizacion_fac
                (
                seqFormulario,
                numNit,
                txtEntidad,
                txtTipoDocumento,
                numDocumento,
                txtNombreCiudadano,
                fchActo,
                numActo,
                valAsignado,
                numTipo,
                txtObservacion)
            VALUES";
        $sql .= $value;
        $sql = substr_replace($sql, ';', -1, 1);

        try {
            $objRes = $aptBd->execute($sql);
            return true;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    public function SalvarPostulados($estados, $tipo) {

        global $aptBd;
        $array = Array();

        $sql = "INSERT INTO t_fnv_optimizacion_fac
                (
                seqFormulario,
                numNit,
                txtEntidad,
                txtTipoDocumento,
                numDocumento,
                txtNombreCiudadano,
                fchActo,
                numActo,
                valAsignado,
                numTipo,
                numFormTipo,
                txtObservacion)
                select 
                  frm.seqFormulario,
                    '8999990619' AS numNit,
                    'SECRETARÍA DISTRITAL DE HÁBITAT' AS txtEntidad,
                    txtTipoDocumento,
                    numDocumento,
                    UPPER(CONCAT(ciu.txtNombre1,
                                    ' ',
                                    ciu.txtNombre2,
                                    ' ',
                                    ciu.txtApellido1,
                                    ' ',
                                    ciu.txtApellido2)) AS txtNombre,
                    null as fchActo,
                    0 as numActo,
                    0 as valAsignado,
                    " . $tipo . " as numTipo,
                    null AS numFormTipo,
                    vEst.txtEstado as txtEstado                  
                    FROM
                        T_FRM_FORMULARIO frm
                            INNER JOIN
                        T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
                            INNER JOIN
                        T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
                            LEFT JOIN
                        T_CIU_PARENTESCO par ON hog.seqParentesco = par.seqParentesco
                            LEFT JOIN
                        v_frm_estado vEst ON frm.seqEstadoProceso = vEst.seqEstadoProceso
                         LEFT JOIN 
                         t_ciu_tipo_documento tdoc ON ciu.seqTipoDocumento = tdoc.seqTipoDocumento
                        where 
                        frm.seqEstadoProceso in (" . $estados . ") and bolCerrado = 1";
        try {
            $objRes = $aptBd->execute($sql);
            return true;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    function GenerarReporte() {

        global $aptBd;

        $sql = "SELECT 
                    seqFormulario,
                    numNit,
                    txtEntidad,
                    txtTipoDocumento,
                    numDocumento,
                    txtNombreCiudadano AS txtNombre,
                    fchActo AS FCH_ASIGN,
                    valAsignado,
                    txtObservacion AS Justificacion,
                    CASE
                        WHEN numTipo = 1 THEN 'Hogares Asignados'
                        WHEN numTipo = 2 THEN 'Hogares Inhabilitados'
                        WHEN numTipo = 3 THEN 'Hogares Sancionados'
                        WHEN numTipo = 4 THEN 'Archivo Emberas'
                        WHEN numTipo = 5 THEN 'Archivo Molinos'
                        WHEN numTipo = 6 THEN 'Archivo Metrovivienda'
                        ELSE 'Hogare en Postulacion'		
                       END
                       AS tipoFormulario
                FROM
                     t_fnv_optimizacion_fac
                      ORDER BY seqFormulario DESC, numTipo, txtObservacion";
        $objRes = $aptBd->execute($sql);
        return $objRes;
    }

}

// fin clase reportes
?>
    