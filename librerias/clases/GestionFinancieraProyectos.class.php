<?php

class GestionFinancieraProyectos
{

    public $arrProyectos;
    public $arrResoluciones;
    public $arrErrores;
    public $arrMensajes;

    public function __construct()
    {
        $this->arrProyectos = array();
        $this->arrResoluciones = array();
        $this->arrErrores = array();
        $this->arrMensajes = array();
    }

    /**
     * obtiene el listado de proyectos
     * @author Bernardo Zerda
     * @version 1.0 Abril 2018
     */
    public function proyectos(){
        global $aptBd;

        $sql = "
            select 
                seqProyecto, 
                txtNombreProyecto
            from t_pry_proyecto
            where bolActivo = 1 
              and seqProyectoPadre is null
            order by txtNombreProyecto
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){
            $seqProyecto = $objRes->fields['seqProyecto'];
            $this->arrProyectos[$seqProyecto] = $objRes->fields['txtNombreProyecto'];
            $objRes->MoveNext();
        }
    }

    public function informacionProyecto($seqProyecto){

        $this->arrResoluciones = array();

        $this->datosBasicos($seqProyecto);

        $this->liberaciones($seqProyecto);

        $this->giros($seqProyecto);

    }

    private function datosBasicos($seqProyecto){
        global $aptBd;

        $sql = "
            select
                uac.seqUnidadActo,
                tac.txtTipoActoUnidad,
                uac.numActo,
                uac.fchActo,
                rpr.seqRegistroPresupuestal,
                rpr.numNumeroCDP, 
                rpr.fchFechaCDP, 
                rpr.valValorCDP, 
                rpr.numVigenciaCDP, 
                rpr.numProyectoInversionCDP, 
                rpr.numNumeroRP, 
                rpr.fchFechaRP, 
                rpr.valValorRP, 
                rpr.numVigenciaRP,
                if(pry.seqProyecto is null, con.seqProyecto, pry.seqProyecto) as seqProyecto,
                if(pry.seqProyecto is null, con.txtNombreProyecto, pry.txtNombreProyecto) as txtNombreProyecto,
                if(pry.seqProyecto is null, null, con.seqProyecto) as seqConjunto,
                if(pry.seqProyecto is null, null, con.txtNombreProyecto) as txtNombreConjunto,
                upr.seqUnidadProyecto,
                upr.txtNombreUnidad,
                upr.valSDVEActual,
                uvi.valIndexado
            from t_pry_aad_unidades_vinculadas uvi 
            left join t_pry_unidad_proyecto upr on upr.seqUnidadProyecto = uvi.seqUnidadProyecto
            left join t_pry_proyecto con on upr.seqProyecto = con.seqProyecto
            left join t_pry_proyecto pry on pry.seqProyecto = con.seqProyectoPadre
            inner join t_pry_aad_unidad_acto uac on uac.seqUnidadActo = uvi.seqUnidadActo
            inner join t_pry_aad_unidad_tipo_acto tac on uac.seqTipoActoUnidad = tac.seqTipoActoUnidad
            left join t_pry_aad_registro_presupuestal rpr on uvi.seqRegistroPresupuestal = rpr.seqRegistroPresupuestal
            where uvi.seqProyecto in (
                select seqProyecto
                from t_pry_proyecto
                where seqProyecto = $seqProyecto
                or seqProyectoPadre = $seqProyecto
            ) and (pry.bolActivo = 1 or pry.bolActivo is null)
            and (con.bolActivo = 1 or con.bolActivo is null)
            order by 
                uac.fchActo,
                upr.seqUnidadProyecto
        ";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {

            $seqUnidadActo = $objRes->fields['seqUnidadActo'];
            $seqRegistroPresupuestal = $objRes->fields['seqRegistroPresupuestal'];

            $this->arrResoluciones[$seqUnidadActo]['tipo'] = $objRes->fields['txtTipoActoUnidad'];
            $this->arrResoluciones[$seqUnidadActo]['numero'] = $objRes->fields['numActo'];
            $this->arrResoluciones[$seqUnidadActo]['fecha'] = new DateTime($objRes->fields['fchActo']);
            $this->arrResoluciones[$seqUnidadActo]['total'] += doubleval($objRes->fields['valIndexado']);
            if(intval($seqRegistroPresupuestal)) {
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['proyectoInversion'] = $objRes->fields['numProyectoInversionCDP'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['numeroCDP'] = $objRes->fields['numNumeroCDP'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['fechaCDP'] = new DateTime($objRes->fields['fchFechaCDP']);
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['valorCDP'] = $objRes->fields['numValorCDP'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['valorCDP'] = $objRes->fields['valValorCDP'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['vigenciaCDP'] = $objRes->fields['numVigenciaCDP'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['numeroRP'] = $objRes->fields['numNumeroRP'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['fechaRP'] = new DateTime($objRes->fields['fchFechaRP']);
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['valorRP'] = $objRes->fields['numValorRP'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['valorRP'] = $objRes->fields['valValorRP'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['vigenciaRP'] = $objRes->fields['numVigenciaRP'];
            }

            $objRes->MoveNext();
        }

    }

    private function liberaciones($seqProyecto){
        global $aptBd;

        $sql = "
            select distinct
                lib.seqLiberacion, 
                uvi.seqProyecto,
                lib.seqUnidadActo,
                lib.seqRegistroPresupuestal,
                lib.valLiberado,
                lib.fchLiberacion,
                concat(usu.txtNombre, ' ',usu.txtApellido) as txtUsuario
            from t_pry_aad_liberacion lib
            inner join t_cor_usuario usu on lib.seqUsuario = usu.seqUsuario
            inner join t_pry_aad_unidades_vinculadas uvi on lib.seqRegistroPresupuestal = uvi.seqRegistroPresupuestal
            where uvi.seqProyecto = $seqProyecto
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){

            $seqLiberacion = $objRes->fields['seqLiberacion'];
            $seqUnidadActo = $objRes->fields['seqUnidadActo'];
            $seqRegistroPresupuestal = $objRes->fields['seqRegistroPresupuestal'];

            $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['total'] += $objRes->fields['valLiberado'];
            $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['detalle'][$seqLiberacion]['valor'] = $objRes->fields['valLiberado'];
            $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['detalle'][$seqLiberacion]['fecha'] = new DateTime($objRes->fields['fchLiberacion']);
            $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['detalle'][$seqLiberacion]['usuario'] = $objRes->fields['txtUsuario'];

            foreach($this->arrResoluciones as $seqUnidadActoResolucion => $arrResoluciones){
                foreach($arrResoluciones['cdp'] as $seqRegistroPresupuestalResolucion => $arrCDP){
                    if($seqRegistroPresupuestalResolucion == $seqRegistroPresupuestal and $seqUnidadActo != $seqUnidadActoResolucion){

                        $this->arrResoluciones[$seqUnidadActoResolucion]['liberaciones'] += $objRes->fields['valLiberado'];
                        $this->arrResoluciones[$seqUnidadActoResolucion]['saldo'] =
                            $this->arrResoluciones[$seqUnidadActoResolucion]['total'] +
                            $this->arrResoluciones[$seqUnidadActoResolucion]['liberaciones'];

                        $this->arrResoluciones[$seqUnidadActo]['liberaciones'] += $objRes->fields['valLiberado'];
                        $this->arrResoluciones[$seqUnidadActo]['saldo'] =
                            $this->arrResoluciones[$seqUnidadActo]['total'] -
                            $this->arrResoluciones[$seqUnidadActo]['liberaciones'];

                        $this->arrResoluciones[$seqUnidadActoResolucion]['cdp'][$seqRegistroPresupuestalResolucion]['liberaciones'] += $objRes->fields['valLiberado'];
                        $this->arrResoluciones[$seqUnidadActoResolucion]['cdp'][$seqRegistroPresupuestalResolucion]['saldo'] =
                            $this->arrResoluciones[$seqUnidadActoResolucion]['cdp'][$seqRegistroPresupuestalResolucion]['valorRP'] +
                            $this->arrResoluciones[$seqUnidadActoResolucion]['cdp'][$seqRegistroPresupuestalResolucion]['liberaciones'];
                    }
                }
            }

            $objRes->MoveNext();
        }

    }

    private function giros($seqProyecto){

    }

    public function salvarLiberacion($arrPost){
        global $aptBd;

        // carga la infomacion previa para hacer las validaciones
        $this->informacionProyecto($arrPost['seqProyecto']);

        // datos necesarios
        $valLiberado = doubleval(mb_ereg_replace("[^0-9]","", $arrPost['valor']));
        $seqUnidadActoPrimario = $arrPost['seqUnidadActoPrimario'];
        $seqUnidadActo = $arrPost['seqUnidadActo'];
        $seqRegistroPresupuestal = $arrPost['seqRegistroPresupuestal'];

        // validacion del valor
        if($valLiberado == 0){
            $this->arrErrores[] = "No debe dejar vacío el valor a liberar";
        }

        // validacion para liberacion del CDP
        if(isset($this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['saldo'])){
            if($valLiberado > $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['saldo']){
                $this->arrErrores[] = "No hay suficientes recursos para liberar del RP " .
                    $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['numeroRP'] . " del " .
                    $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['fechaRP']->format("Y");
            }
        }else{
            if($valLiberado > $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['valorRP']){
                $this->arrErrores[] = "No hay suficientes recursos para liberar del RP " .
                    $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['numeroRP'] . " del " .
                    $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['fechaRP']->format("Y");
            }
        }

        // validacion contra la resolucion de liberacion
        if(isset($this->arrResoluciones[$seqUnidadActoPrimario]['saldo'])){
            if($valLiberado > abs($this->arrResoluciones[$seqUnidadActoPrimario]['saldo'])){
                $this->arrErrores[] = "No hay suficientes recursos para liberar de la resolución " .
                    $this->arrResoluciones[$seqUnidadActoPrimario]['numero'] . " del " .
                    $this->arrResoluciones[$seqUnidadActoPrimario]['fecha']->format("Y");
            }
        }else{
            if($valLiberado > abs($this->arrResoluciones[$seqUnidadActoPrimario]['total'])){
                $this->arrErrores[] = "No hay suficientes recursos para liberar de la resolución " .
                    $this->arrResoluciones[$seqUnidadActoPrimario]['numero'] . " del " .
                    $this->arrResoluciones[$seqUnidadActoPrimario]['fecha']->format("Y");
            }
        }

        // salva registro
        if(empty($this->arrErrores)){

            try{
                $aptBd->BeginTrans();

                $sql = "
                    insert into t_pry_aad_liberacion(
                        seqUnidadActo,
                        seqRegistroPresupuestal,
                        valLiberado,
                        fchLiberacion,
                        seqUsuario
                    ) values (
                        $seqUnidadActoPrimario,
                        $seqRegistroPresupuestal,
                        " . ($valLiberado * -1) . ",
                        now(),
                        " . $_SESSION['seqUsuario'] . "  
                    )
                ";
                $aptBd->execute($sql);

                $this->arrMensajes[] = "Registro de liberación de recursos ha sido salvado";

                // carga la informacion posterior a la salvada del registro
                $this->informacionProyecto($arrPost['seqProyecto']);

                $aptBd->CommitTrans();
            } catch ( Exception $objError ){
                $aptBd->RollbackTrans();
                $this->arrErrores[] = $objError->getMessage();
                $this->Mensajes[] = array();
            }

        }

    }

    public function eliminarLiberacion($arrPost){
        global $aptBd;

        try{
            $aptBd->BeginTrans();

            $sql = "
                delete 
                from t_pry_aad_liberacion
                where seqLiberacion = " . $arrPost['seqLiberacion'] . "
            ";
            $aptBd->execute($sql);

            $this->arrMensajes[] = "Registro de liberación de recursos eliminado";

            // carga la informacion posterior a la salvada del registro
            $this->informacionProyecto($arrPost['seqProyecto']);

            $aptBd->CommitTrans();
        } catch ( Exception $objError ){
            $aptBd->RollbackTrans();
            $this->arrErrores[] = $objError->getMessage();
            $this->Mensajes[] = array();
        }

    }

}


?>