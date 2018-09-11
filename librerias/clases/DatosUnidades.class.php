<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DatosUnidades
 *
 * @author liliana.basto
 */
class DatosUnidades {

    //put your code here

    public $seqUnidadProyecto;
    public $seqProyecto;
    public $txtNombreUnidad;
    public $txtNombreUnidadReal;
    public $txtNombreUnidadAux;
    public $txtMatriculaInmobiliaria;
    public $txtChipLote;
    public $valSDVEAprobado;
    public $valSDVEActual;
    public $valSDVEComplementario;
    public $txtSMMLV;
    public $txtObservacionComplemento;
    public $valSDVEComercial;
    public $valCierreFinanciero;
    public $seqFormulario;
    public $bolLegalizado;
    public $fchLegalizado;
    public $fchRadicacion;
    public $txtRadicadoForest;
    public $fchInformacionSolucion;
    public $fchInformacionTitulos;
    public $fchDevolucionExpediente;
    public $bolActivo;
    public $seqPlanGobierno;
    public $seqModalidad;
    public $seqTipoEsquema;

    function DatosUnidades() {

        $this->seqUnidadProyecto = 0;
        $this->seqProyecto = 0;
        $this->txtNombreUnidad = "";
        $this->txtNombreUnidadReal = "";
        $this->txtNombreUnidadAux = "";
        $this->txtMatriculaInmobiliaria = "";
        $this->txtChipLote = "";
        $this->valSDVEAprobado = 0;
        $this->valSDVEActual = 0;
        $this->valSDVEComplementario = 0;
        $this->txtSMMLV = "";
        $this->txtObservacionComplemento = "";
        $this->valSDVEComercial = 0;
        $this->valCierreFinanciero = 0;
        $this->seqFormulario = 0;
        $this->bolLegalizado = 0;
        $this->fchLegalizado = "";
        $this->fchRadicacion = "";
        $this->txtRadicadoForest = "";
        $this->fchInformacionSolucion = "";
        $this->fchInformacionTitulos = "";
        $this->fchDevolucionExpediente = "";
        $this->bolActivo = 0;
        $this->seqPlanGobierno = 0;
        $this->seqModalidad = 0;
        $this->seqTipoEsquema = 0;
    }

    function ObtenerUnidadesProyecto($seqProyecto) {

        global $aptBd;
        $sql = "SELECT * FROM   t_pry_unidad_proyecto und";
        if ($seqProyecto > 0) {
            $sql .= " where  und.seqProyecto = " . $seqProyecto;
        }
        $sql .="  group by seqUnidadProyecto";
        //   echo "<p>".$sql."</p>";
        $objRes = $aptBd->execute($sql);
        $datos = Array();
        while ($objRes->fields) {
            $datos[] = $objRes->fields;
            $objRes->MoveNext();
        }
        return $datos;
    }

    function ObtenerCantUnidadesProyecto($seqProyecto) {

        global $aptBd;
        $sql = "SELECT count(*) As cantidad, valNumeroSoluciones
                FROM t_pry_proyecto  pry
                LEFT JOIN t_pry_unidad_proyecto und USING(seqProyecto)";
        if ($seqProyecto > 0) {
            $sql .= " where  und.seqProyecto = " . $seqProyecto;
        }
        // echo "<p>" . $sql . "</p>";
        $objRes = $aptBd->execute($sql);
        $datos = Array();
        while ($objRes->fields) {
            $datos['cantidad'] = $objRes->fields['cantidad'];
            $datos['valNumeroSoluciones'] = $objRes->fields['valNumeroSoluciones'];
            $objRes->MoveNext();
        }
        return $datos;
    }

    function AlmacenarUnidades($array, $seqProyecto) {

        global $aptBd;

        $arrErrores = array();
        $sql = "INSERT INTO t_pry_unidad_proyecto(
                seqProyecto,
                txtNombreUnidad,
                txtNombreUnidadReal,
                txtNombreUnidadAux,
                txtMatriculaInmobiliaria,
                txtChipLote,
                valSDVEAprobado,
                valSDVEActual,
                valSDVEComplementario,
                txtSMMLV,
                txtObservacionComplemento,
                valSDVEComercial,
                valCierreFinanciero,
                seqFormulario,
                bolLegalizado,
                fchLegalizado,
                fchRadicacion,
                txtRadicadoForest,
                fchInformacionSolucion,
                fchInformacionTitulos,
                fchDevolucionExpediente,
                bolActivo,
                seqPlanGobierno,
                seqModalidad,
                seqTipoEsquema)
                VALUES";
        foreach ($array as $key => $value) {
            //  echo "<p> RRRRR" . $value[4] . "</p>";
            $sql .= " (" . $seqProyecto . ",
                '" . $value[0] . "',
                '',
                '',
                '',
                '',
                0,
                0,
                0,
                '" . $value[1] . " SMML',
                '',
                " . $value[2] . ",
                " . $value[3] . ",
                'NULL',
                0,
                '',
                '',
                '',
                '',
                '',
                '',
                1,
                " . explode('-', $value[4])[0] . ",
                " . explode('-', $value[5])[0] . ",
                " . explode('-', $value[6])[0] . " ),";
        }
        $sql = substr_replace($sql, ';', -1, 1);
        // echo "<p>".$sql."</p>";die();
        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido cargar los archivos<b></b>";
            pr($objError->getMessage());
        }
        return $arrErrores;
    }

    function modificarEstadoUnidad($array, $seqProyecto) {

        global $aptBd;
        foreach ($array as $key => $value) {
            if ($value[5] != "Seleccione") {
                $estado = explode("-", $value[5])[0];
                if ($estado > 0) {
                    $sql = "UPDATE t_pry_unidad_proyecto
                SET
                seqEstadoUnidad = $estado 
                WHERE seqUnidadProyecto = $value[0];";
                    try {
                        $aptBd->execute($sql);
                    } catch (Exception $objError) {
                        $arrErrores[] = "No se ha podido modificar los estado de las unidades<b></b>";
                        pr($objError->getMessage());
                    }
                }
            }
        }
    }

    function obtenerDatosUnidades($seqProyecto) {
        global $aptBd;
        $sql = "SELECT txtNombreProyecto, txtNombreUnidad, txtNombreTipoVivienda, seqUnidadProyecto, concat(seqEstadoUnidad ,'-', txtEstadoUnidad) as estado
                FROM t_pry_proyecto pry 
                LEFT JOIN t_pry_unidad_proyecto und USING(seqProyecto) 
                LEFT JOIN t_pry_tipo_vivienda tip using(seqProyecto)
                LEFT JOIN t_pry_estado_unidad EST USING(seqEstadoUnidad)";
        if ($seqProyecto > 0) {
            $sql .= " where  und.seqProyecto = " . $seqProyecto;
        }
        $sql .= " GROUP BY seqUnidadProyecto";
        // echo "<p>" . $sql . "</p>"; die();
        $objRes = $aptBd->execute($sql);
        $datos = Array();
        while ($objRes->fields) {
            $datos[] = $objRes->fields;
            $objRes->MoveNext();
        }

        return $datos;
    }

    function ValidarUnidadesProyecto($seqProyecto, $seqUnidad) {

        global $aptBd;
        $sql = "SELECT * FROM   t_pry_unidad_proyecto und";
        if ($seqProyecto > 0) {
            $sql .= " where  und.seqProyecto = " . $seqProyecto;
        }
        if ($seqUnidad > 0 && $seqUnidad != "") {
            $sql .= " and  und.seqUnidadProyecto = " . $seqUnidad;
        }
        $sql .="  group by seqUnidadProyecto";
        //   echo "<p>".$sql."</p>";
        $objRes = $aptBd->execute($sql);
        $datos = false;
        if ($objRes->numRows() > 0) {
            $datos = true;
        }
        return $datos;
    }

    function ObtenerCantUnidadesLegalizadasProyecto($seqProyecto) {

        global $aptBd;
        $sql = "SELECT count(*) As cantidad, valNumeroSoluciones
                FROM t_pry_proyecto  pry
                LEFT JOIN t_pry_unidad_proyecto und USING(seqProyecto) 
                LEFT JOIN t_frm_formulario frm USING(seqFormulario)";
        if ($seqProyecto > 0) {
             $sql .= " where case  when seqProyectoPadre IS NOT NULL then  und.seqProyecto in (select concat(seqProyecto, ',') from  t_pry_proyecto where seqProyectoPadre = " . $seqProyecto . ") else  und.seqProyecto = " . $seqProyecto . " end";
}
        //echo "<p>" . $sql . "</p>";
        $objRes = $aptBd->execute($sql);
        $datos = 0;
        while ($objRes->fields) {
            $datos= $objRes->fields['cantidad'];
            //$datos['valNumeroSoluciones'] = $objRes->fields['valNumeroSoluciones'];
            $objRes->MoveNext();
        }
        return $datos;
    }
    
    public function datosTecnicosPermisoOcup($seqProyecto) {
        global $aptBd;
        $sql = "select count(*) as cant
                from  t_pry_tecnico
                LEFT JOIN t_pry_unidad_proyecto und  using(seqUnidadProyecto)
                LEFT JOIN t_pry_proyecto USING(seqProyecto)
                where  txtPermisoOcupacion like UPPER('SI')";
        if ($seqProyecto > 0) {
            $sql .= " and case  when seqProyectoPadre IS NOT NULL then  und.seqProyecto in (select concat(seqProyecto, ',') from  t_pry_proyecto where seqProyectoPadre = " . $seqProyecto . ") else  und.seqProyecto = " . $seqProyecto . " end";
        }
        //$sql .="  group by tamp.seqTipoAmparo, seqAmparoPadre";
        //   echo "<p>".$sql."</p>";
        $objRes = $aptBd->execute($sql);
        $datos = 0;

        while ($objRes->fields) {
            $datos = $objRes->fields['cant'];
            $objRes->MoveNext();
        }
        return $datos;
    }
    
    function ObtenerCantUnidadesLegalizadasUnd($seqProyecto) {

        global $aptBd;
        $sql = "SELECT count(*) As cantidad
                FROM t_pry_proyecto  pry
                LEFT JOIN t_pry_unidad_proyecto und USING(seqProyecto)";
        if ($seqProyecto > 0) {
             $sql .= " where  seqEstadoUnidad = 6 and case  when seqProyectoPadre IS NOT NULL then  und.seqProyecto in (select concat(seqProyecto, ',') from  t_pry_proyecto where seqProyectoPadre = " . $seqProyecto . ") else  und.seqProyecto = " . $seqProyecto . " end";
        }
        // echo "<p>" . $sql . "</p>";
        $objRes = $aptBd->execute($sql);
        $datos = 0;
        while ($objRes->fields) {
            $datos= $objRes->fields['cantidad'];
            //$datos['valNumeroSoluciones'] = $objRes->fields['valNumeroSoluciones'];
            $objRes->MoveNext();
        }
        return $datos;
    }

}
