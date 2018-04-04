<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CRMProyecto
 *
 * @author lbastoz
 */
class CRMProyecto {

    //put your code here
    public $txtProyecto;      // Nombre de la Proyecto
    public $numLimiteActivos; // Cantidad de activos que se pueden manejar
    public $fchVencimiento;   // Fecha en la que termina el proyecto
    public $bolActivo;        // si la Proyecto esta activa o no
    public $arrProyecto = array();

    public function CRMProyecto() {
        $this->txtProyecto = "";
        $this->fchVencimiento = NULL;
        $this->bolActivo = false;
        $this->arrProyecto = array();
    }

    //put your code here
    public function obtenerListaProyectos() {

        global $aptBd;

        $sql = "SELECT seqProyecto, txtNombreProyecto FROM t_pry_proyecto WHERE seqProyectoPadre IS NULL"
                . " AND seqTipoEsquema in (1,2)";
        //$rs = $aptBd->getAssoc($sql);
        $objRes = $aptBd->execute($sql);
        $datos = Array();

        while ($objRes->fields) {
            $datos[$objRes->fields['seqProyecto']] = $objRes->fields['txtNombreProyecto'];
            $objRes->MoveNext();
        }
        return $datos;
    }

    public function obtenerDatosProyectos($listEstados, $arrEstado) {

        global $aptBd;

        $sql = "SELECT * FROM t_pry_tablero_control";


        $objRes = $aptBd->Execute($sql);

        $datos = Array();
        $int = 0;
        while ($objRes->fields) {
            $datos[$int] = $objRes->fields;
            $int++;
            $objRes->MoveNext();
        }


        return $datos;
    }

// funcion que lista y suma todos los estados de todos los proyectos
    public function obtenerGroupProyectos($listEstados, $arrEstado) {

        global $aptBd;

        $sql = "SELECT ";
        foreach ($arrEstado as $key => $value) {
            $value = str_replace(" ", "", $value);
            $value = $this->quitarTildes($value);
            $sql .= "SUM(val" . $value . ") as val" . $value . ", ";
            $sql .= "SUM(v" . $value . ") as v" . $value . ", ";
            $sql .= "SUM(a" . $value . ") as a" . $value . ", ";
            $sql .= "SUM(r" . $value . ") as r" . $value . ", ";
        }
        $sql = substr_replace($sql, '', -2, 1);
        $sql .= " FROM t_pry_tablero_control";
//echo $sql;
        //die();
        $objRes = $aptBd->Execute($sql);

        $datos = Array();
        $int = 0;
        while ($objRes->fields) {
            $datos[$int] = $objRes->fields;
            $int++;
            $objRes->MoveNext();
        }


        return $datos;
    }

    public function quitarTildes($cadena) {

        $no_permitidas = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹");
        $permitidas = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E");
        $texto = str_replace($no_permitidas, $permitidas, $cadena);
        return ($texto);
    }

    public function totalUnidades($valor) {

        global $aptBd;
        $sql = "";
        if ($valor == 1) {
            //$sql = "SELECT count(*) as cant FROM T_PRY_UNIDAD_PROYECTO WHERE bolActivo =1 and seqProyecto >0";
            $sql = "SELECT count(*) as cant FROM T_PRY_UNIDAD_PROYECTO und
                    LEFT JOIN t_pry_proyecto pry USING(seqProyecto) 
                    WHERE und.bolActivo =1 and seqProyecto >0 and pry.seqTipoEsquema in(1,2)";
        } else if ($valor == 2) {
            $sql = "SELECT count(*) as cant FROM T_PRY_UNIDAD_PROYECTO und
                    LEFT JOIN t_frm_formulario frm USING(seqFormulario) 
                    WHERE frm.bolCerrado =0  OR (und.seqFormulario is null OR und.seqFormulario =0) and bolActivo =1 and und.seqProyecto >0";
        } else if ($valor == 3) {
            $sql = "SELECT count(*) as cant FROM T_PRY_UNIDAD_PROYECTO und
                    LEFT JOIN t_frm_formulario frm USING(seqFormulario) 
                    WHERE frm.bolCerrado =1  and und.seqFormulario is not null
                    and (seqEstadoProceso = 7 OR seqEstadoProceso = 54 OR seqEstadoProceso = 16 OR seqEstadoProceso = 47 ) and bolActivo =1 and und.seqProyecto >0";
        } else if ($valor == 4) {
            $sql = "SELECT count(*) as cant FROM T_PRY_UNIDAD_PROYECTO und
                    LEFT JOIN t_frm_formulario frm USING(seqFormulario) 
                    WHERE frm.bolCerrado =1  and und.seqFormulario is not null
                    and (seqEstadoProceso = 15 OR seqEstadoProceso = 62 OR seqEstadoProceso = 17 OR seqEstadoProceso = 19
                    OR seqEstadoProceso = 22 OR seqEstadoProceso = 23 OR seqEstadoProceso = 24 OR seqEstadoProceso = 25
                    OR seqEstadoProceso = 26 OR seqEstadoProceso = 27 OR seqEstadoProceso = 28 OR seqEstadoProceso = 31
                    OR seqEstadoProceso = 29 OR seqEstadoProceso = 40) and bolActivo =1 and und.seqProyecto >0";
        }

        //$rs = $aptBd->getAssoc($sql);
        $objRes = $aptBd->execute($sql);
        $datos = Array();

        while ($objRes->fields) {
            $datos = $objRes->fields['cant'];
            $objRes->MoveNext();
        }
        return $datos;
    }

    public function totalUnidadesPorProyecto($valor) {

        global $aptBd;
        $sql = "";
        if ($valor == 1) {
            $sql = "SELECT count(*) as cant, und.seqProyecto FROM T_PRY_UNIDAD_PROYECTO und WHERE bolActivo =1";
        } else if ($valor == 2) {
            $sql = "SELECT count(*) as cant, und.seqProyecto FROM T_PRY_UNIDAD_PROYECTO und
                    LEFT JOIN t_frm_formulario frm USING(seqFormulario) 
                    WHERE frm.bolCerrado =0  OR (und.seqFormulario IS NULL OR  und.seqFormulario = 0) and bolActivo =1";
        } else if ($valor == 3) {
            $sql = "SELECT count(*) as cant, und.seqProyecto FROM T_PRY_UNIDAD_PROYECTO und
                    LEFT JOIN t_frm_formulario frm USING(seqFormulario) 
                    WHERE frm.bolCerrado =1  and und.seqFormulario is not null
                    and (seqEstadoProceso = 7 OR seqEstadoProceso = 54 OR seqEstadoProceso = 16 OR seqEstadoProceso = 47) and bolActivo =1";
        } else if ($valor == 4) {
            $sql = "SELECT count(*) as cant, und.seqProyecto FROM T_PRY_UNIDAD_PROYECTO und
                    LEFT JOIN t_frm_formulario frm USING(seqFormulario) 
                    WHERE frm.bolCerrado =1  and und.seqFormulario is not null
                    and (seqEstadoProceso = 15 OR seqEstadoProceso = 62 OR seqEstadoProceso = 17 OR seqEstadoProceso = 19 
                    OR seqEstadoProceso = 22 OR seqEstadoProceso = 23 OR seqEstadoProceso = 24  OR seqEstadoProceso = 25
                    OR seqEstadoProceso = 26 OR seqEstadoProceso = 27 OR seqEstadoProceso = 28 OR seqEstadoProceso = 31
                    OR seqEstadoProceso = 29 OR seqEstadoProceso = 40) and bolActivo =1";
        } else if ($valor == 5) {
            $sql = "SELECT count(*) as cant, und.seqProyecto FROM t_pry_unidad_proyecto    und
                    INNER JOIN t_frm_formulario frm USING (seqFormulario)
                     WHERE seqEstadoProceso = 40 AND bolCerrado = 1";
        } else if ($valor == 6) {
            $sql = "SELECT count(*) as cant  FROM t_pry_unidad_proyecto    und
                    INNER JOIN t_frm_formulario frm USING (seqFormulario)
                     WHERE bolCerrado = 1 AND (seqEstadoProceso = 62 OR seqEstadoProceso = 17 OR seqEstadoProceso = 19 
                    OR seqEstadoProceso = 22 OR seqEstadoProceso = 23 OR seqEstadoProceso = 24 OR seqEstadoProceso = 25
                    OR seqEstadoProceso = 26 OR seqEstadoProceso = 27 OR seqEstadoProceso = 28 OR seqEstadoProceso = 31
                    OR seqEstadoProceso = 29 OR seqEstadoProceso = 24)";
        } else if ($valor == 7) {
            $sql = "SELECT count(*) as cant FROM t_pry_unidad_proyecto    und
                    INNER JOIN t_frm_formulario frm USING (seqFormulario)
                     WHERE fchDevolucionExpediente is not null and fchDevolucionExpediente != '0000-00-00 00:00:00' AND fchDevolucionExpediente != '' AND bolCerrado = 1 ";
        } else if ($valor == 8) {
            $sql = "SELECT count(*) as cant, und.seqProyecto FROM t_pry_unidad_proyecto und
                    INNER JOIN t_frm_formulario frm USING (seqFormulario)
                     WHERE fchDevolucionExpediente is not null and fchDevolucionExpediente != '0000-00-00 00:00:00' AND fchDevolucionExpediente != '' AND bolCerrado = 1 ";
        }
        $sql .= " and und.seqProyecto >0";
        if ($valor != 7 && $valor != 6) {
            $sql .= " GROUP BY und.seqProyecto";
        }


        //$rs = $aptBd->getAssoc($sql);
        $objRes = $aptBd->execute($sql);
        $datos = Array();

        $int = 0;
        while ($objRes->fields) {
            $datos[$int] = $objRes->fields;
            $int++;
            $objRes->MoveNext();
        }

        return $datos;
    }

    public function totalLegalizadas($valor) {

        global $aptBd;
        $sql = "SELECT count(*) AS cant
                FROM t_pry_unidad_proyecto    und
                     INNER JOIN t_frm_formulario frm USING (seqFormulario)
                WHERE seqEstadoProceso = 40 AND bolCerrado = 1";

        //echo $sql;
        //$rs = $aptBd->getAssoc($sql);
        $objRes = $aptBd->execute($sql);
        $datos = Array();

        $int = 0;
        while ($objRes->fields) {
            $datos[$int] = $objRes->fields;
            $int++;
            $objRes->MoveNext();
        }

        return $datos;
    }

}
