<?php

/**
 * Created by PhpStorm.
 * User: bzerdar
 * Date: 15/08/2017
 * Time: 05:57 PM
 */
class InformeVeedurias
{

    public $arrErrores;
    public $seqCorte;
    public $txtCorte;
    public $fchCorte;
    public $txtNombre;
    private $arrEstadosVinculado;
    private $arrEstadosLegalizado;
    private $arrFuentesExcel;

    function __construct()
    {
        $this->arrErrores = array();
        $this->seqCorte = 0;
        $this->txtCorte = "";
        $this->fchCorte = null;
        $this->txtNombre = "";
        $this->arrEstadosVinculado = array( 15, 62, 17, 19, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 40 );
        $this->arrEstadosLegalizado = array( 40 );
        $this->arrFuentesExcel = array();
    }

    public function obtenerCortes($seqCorte = 0)
    {
        global $aptBd;
        $txtCondicion = ( $seqCorte == 0 )? "" : "WHERE seqCorte = " . $seqCorte;
        $sql = "
            SELECT 
              seqCorte,
              txtCorte,
              fchCorte,
              concat(usu.txtNombre, ' ', usu.txtApellido) as txtNombre
            FROM t_vee_corte cor
            inner join t_cor_usuario usu on cor.seqUsuario = usu.seqUsuario
            $txtCondicion
        ";
        return $aptBd->GetAll($sql);
    }

    public function reporteProyectos($seqCorte)
    {
        global $aptBd;



        $sql = "
            select
                frm.seqFormularioVeeduria,
                pry1.txtNombreProyecto as txtNombreProyectoPadre, 
                pry1.numNitProyecto as txtNitProyectoPadre, 
                loc1.txtLocalidad as txtLocalidadPadre,
                bar1.txtBarrio as txtBarrioPadre, 
                -- eof11.txtNombreOferente as txtNombreOferentePadre1,
                (
                  SELECT group_concat(txtNombreOferente separator ', ')  
                  FROM  t_pry_proyecto_oferente pOf 
                  LEFT JOIN t_pry_entidad_oferente entO using(seqOferente) 
                  where pry.seqProyecto = pOf.seqProyecto
                ) as txtNombreOferentePadre1,
                -- eof11.numNitOferente as numNitOferentePadre1,
                (
                  SELECT group_concat(numNitOferente separator ', ')  
                  FROM  t_pry_proyecto_oferente pOf 
                  LEFT JOIN t_pry_entidad_oferente entO using(seqOferente) 
                  where pry.seqProyecto = pOf.seqProyecto
                ) as numNitOferente, 
                -- eof12.txtNombreOferente as txtNombreOferentePadre2,
                -- eof12.numNitOferente as numNitOferentePadre2, 
                -- eof13.txtNombreOferente as txtNombreOferentePadre3,
                -- eof13.numNitOferente as numNitOferentePadre3, 
                con1.txtNombreConstructor as txtNombreConstructorPadre,
                con1.numDocumentoConstructor as numDocumentoConstructorPadre,
                pry1.txtNombreVendedor as txtNombreVendedorPadre, 
                pry1.numNitVendedor as txtNitVendedorPadre,
                pry.txtNombreProyecto as txtNombreProyectoHijo,
                pry.numNitProyecto as numNitProyectoHijo, 
                loc2.txtLocalidad as txtLocalidadHijo,
                bar2.txtBarrio as txtBarrioHijo,
                -- eof.txtNombreOferente as txtNombreOferenteHijo1,
                (
                  SELECT group_concat(txtNombreOferente separator ', ')  
                  FROM  t_pry_proyecto_oferente pOf 
                  LEFT JOIN t_pry_entidad_oferente entO using(seqOferente) 
                  where pry1.seqProyecto = pOf.seqProyecto
                ) as txtNombreOferenteHijo1,
                -- eof.numNitOferente as numNitOferenteHijo1, 
                (
                  SELECT group_concat(txtNombreOferente separator ', ')  
                  FROM  t_pry_proyecto_oferente pOf 
                  LEFT JOIN t_pry_entidad_oferente entO using(seqOferente) 
                  where pry1.seqProyecto = pOf.seqProyecto
                ) as numNitOferente,
                -- eof2.txtNombreOferente as txtNombreOferenteHijo2,
                -- eof2.numNitOferente as numNitOferenteHijo2, 
                -- eof3.txtNombreOferente as txtNombreOferenteHijo3,
                -- eof3.numNitOferente as numNitOferenteHijo3, 
                con2.txtNombreConstructor as txtNombreConstructorHijo,
                con2.numDocumentoConstructor as numDocumentoConstructorHijo,
                pry.txtNombreVendedor as txtNombreVendedorHijo, 
                pry.numNitVendedor as numNitVendedorHijo,
                upr.seqUnidadProyecto,
                upr.txtNombreUnidad, 
                UPPER(upr.txtMatriculaInmobiliaria) as txtMatriculaInmobiliaria, 
                upr.txtChipLote, 
                upr.valSDVEAprobado, 
                upr.valSDVEActual, 
                upr.valSDVEComplementario, 
                upr.fchLegalizado,  
                if(upr.bolLegalizado = 1,'SI','NO') as bolLegalizado,
                pgo.txtPlanGobierno,
                upr.seqModalidad, 
                moa.txtModalidad,
                upr.seqTipoEsquema,
                tes.txtTipoEsquema,
                uac.numActo as numActoProyecto, 
                uac.fchActo as fchActoProyecto, 
                if(upr.bolActivo = 1,'SI','NO') as bolActivo,
                uac.seqTipoActoUnidad,
                tac.txtTipoActoUnidad,
                uvi.valIndexado,
                frm.seqFormulario,
                frm.seqEstadoProceso,
                frm.bolCerrado,
                IF(frm.bolDesplazado = 1,'Desplazado','Vulnerable') as bolDesplazado,
                aad.numActo as numActoHogar, 
                aad.fchActo as fchActoHogar,
                esc.numDocumentoVendedor,
                UPPER(esc.txtCompraVivienda) as txtCompraVivienda,
                UPPER(esc.txtDireccionInmueble) as txtDireccionInmueble,
                ciu1.txtCiudad as txtCiudad,
                UPPER(loc1.txtLocalidad) as txtLocalidad,
                UPPER(esc.txtBarrio) as txtBarrio,
                UPPER(IF(esc.txtPropiedad is null,'Ninguno',esc.txtPropiedad)) as txtPropiedad,
                esc.txtEscritura as txtEscritura,
                IF(esc.fchEscritura < '2000-01-01',NULL,esc.fchEscritura) as fchEscritura,
                esc.numNotaria as numNotaria,
                UPPER(esc.txtCiudad) as txtCiudadEscritura,
                IF(esc.fchSentencia < '2000-01-01',NULL,esc.fchSentencia) as fchSentencia,
                esc.numJuzgado as numJuzgado,
                UPPER(esc.txtCiudadSentencia) as txtCiudadSentencia,
                esc.numResolucion as numResolucion,
                IF(esc.fchResolucion < '2000-01-01',NULL,esc.fchResolucion) as fchResolucion,
                UPPER(esc.txtEntidad) as txtEntidad,
                UPPER(esc.txtCiudadResolucion) as txtCiudadResolucion,
                UPPER(esc.txtMatriculaInmobiliaria) as txtMatriculaInmobiliariaEscriturada,
                UPPER(esc.txtChip) as txtChip,
                UPPER(esc.txtTipoPredio) as txtTipoPredio,
                upr.seqFormulario as seqFormularioUnidad
            from t_vee_proyecto pry
            left join t_pry_proyecto pry1 on pry.seqProyectoPadre = pry1.seqProyecto and pry.seqCorte
            inner join t_vee_unidad_proyecto upr on pry.seqProyectoVeeduria = upr.seqProyectoVeeduria
            inner join t_vee_unidades_vinculadas uvi on upr.seqUnidadProyectoVeeduria = uvi.seqUnidadProyectoVeeduria
            inner join t_vee_unidad_acto uac on uvi.seqUnidadActoVeeduria = uac.seqUnidadActoVeeduria
            inner join t_pry_aad_unidad_tipo_acto tac on uac.seqTipoActoUnidad = tac.seqTipoActoUnidad
            left join t_vee_formulario frm on upr.seqFormulario = frm.seqFormulario and frm.seqCorte = $seqCorte
            left join (
              select
              frm.seqFormulario, 
              hvi.numActo, 
              hvi.fchActo
              from t_aad_hogares_vinculados hvi
              inner join (
                select 
                fac.seqFormulario,
                max(fac.seqFormularioActo) as seqFormularioActo
                from t_aad_hogares_vinculados hvi 
                inner join t_aad_formulario_acto fac on hvi.seqFormularioActo = fac.seqFormularioActo
                where hvi.seqTipoActo = 1
                group by fac.seqFormulario
              ) frm on hvi.seqFormularioActo = frm.seqFormularioActo
            ) aad on frm.seqFormulario = aad.seqFormulario
            inner join t_frm_plan_gobierno pgo on upr.seqPlanGobierno = pgo.seqPlanGobierno
            inner join t_frm_modalidad moa on moa.seqModalidad = upr.seqModalidad
            inner join t_pry_tipo_esquema tes on upr.seqTipoEsquema = tes.seqTipoEsquema
            left  join t_frm_localidad loc1 on pry1.seqLocalidad = loc1.seqLocalidad
            left  join t_frm_barrio bar1 on pry1.seqBarrio = bar1.seqBarrio
            
            -- left  join t_pry_proyecto_oferente pofe1 on pry1.seqProyecto = pofe1.seqProyecto
            -- left  join t_pry_entidad_oferente eof11 on pofe1.seqOferente = eof11.seqOferente
            
            -- left  join t_pry_entidad_oferente eof11 on pry1.seqProyecto = eof11.seqProyecto
            -- left  join t_pry_entidad_oferente eof12 on pry1.seqProyecto = eof12.seqProyecto
            -- left  join t_pry_entidad_oferente eof13 on pry1.seqProyecto = eof13.seqProyecto
            
            -- left  join t_pry_proyecto_oferente pofe2 on pry.seqProyecto = pofe2.seqProyecto
            -- left  join t_pry_entidad_oferente eof on pofe2.seqOferente = eof.seqOferente
            
            -- left  join t_pry_entidad_oferente eof on pry.seqProyecto = eof.seqProyecto
            -- left  join t_pry_entidad_oferente eof2 on pry.seqProyecto = eof2.seqProyecto
            -- left  join t_pry_entidad_oferente eof3 on pry.seqProyecto = eof3.seqProyecto
            
            left  join t_pry_constructor con1 on pry1.seqConstructor = con1.seqConstructor
            left  join t_pry_constructor con2 on pry.seqConstructor = con2.seqConstructor
            left  join t_frm_localidad loc2 on pry.seqLocalidad = loc2.seqLocalidad
            left  join t_frm_barrio bar2 on pry.seqBarrio = bar2.seqBarrio 
            left  join t_vee_desembolso des on frm.seqFormularioVeeduria = des.seqFormularioVeeduria
            left  join t_vee_escrituracion esc on des.seqDesembolsoVeeduria = esc.seqDesembolsoVeeduria
            left  join v_frm_ciudad ciu1 on des.seqCiudad = ciu1.seqCiudad
            left  join t_frm_localidad loc on des.seqLocalidad = loc.seqLocalidad
            where pry.seqCorte = $seqCorte
            and pry.bolActivo = 1
            order by pry.txtNombreProyecto, uac.seqTipoActoUnidad    
        ";

        $objRes = $aptBd->execute($sql);
        $arrReporte = array();
        $arrFormularios = array();
        while ($objRes->fields) {

            /***************************************************************************
             * PROCESAMIENTO DE LA HOJA DE REPORTE
             ***************************************************************************/

            $seqUnidadProyecto = $objRes->fields['seqUnidadProyecto'];
            $bolDesplazado = $objRes->fields['bolDesplazado'];
            $seqFormulario = $objRes->fields['seqFormularioVeeduria'];

            unset($objRes->fields['seqFormularioVeeduria']);

            // debe acumular sobre proyecto padre cuando aplique
            $txtProyecto = ( trim( $objRes->fields['txtNombreProyectoPadre'] ) != "" )? $objRes->fields['txtNombreProyectoPadre'] : $objRes->fields['txtNombreProyectoHijo'];

            // Determina el año menor y mayor para imprimir el numero de columnas correcto en el excel (XML)
            $numAnioResolucionProyecto = date("Y", strtotime($objRes->fields['fchActoProyecto']));

            $arrReporte['Conteo Consolidado']['limites']['generados']['minimo'] = (
                ($arrReporte['Conteo Consolidado']['limites']['generados']['minimo'] == 0) or
                ($arrReporte['Conteo Consolidado']['limites']['generados']['minimo'] >= $numAnioResolucionProyecto)
            ) ?
                $numAnioResolucionProyecto :
                $arrReporte['Conteo Consolidado']['limites']['generados']['minimo'];

            $arrReporte['Conteo Consolidado']['limites']['generados']['maximo'] = (
                ($arrReporte['Conteo Consolidado']['limites']['generados']['maximo'] == 0) or
                ($arrReporte['Conteo Consolidado']['limites']['generados']['maximo'] <= $numAnioResolucionProyecto)
            ) ?
                $numAnioResolucionProyecto :
                $arrReporte['Conteo Consolidado']['limites']['generados']['maximo'];

            $arrReporte['Dinero Consolidado']['limites']['generados']['minimo'] = (
                ($arrReporte['Dinero Consolidado']['limites']['generados']['minimo'] == 0) or
                ($arrReporte['Dinero Consolidado']['limites']['generados']['minimo'] >= $numAnioResolucionProyecto)
            ) ?
                $numAnioResolucionProyecto :
                $arrReporte['Dinero Consolidado']['limites']['generados']['minimo'];

            $arrReporte['Dinero Consolidado']['limites']['generados']['maximo'] = (
                ($arrReporte['Dinero Consolidado']['limites']['generados']['maximo'] == 0) or
                ($arrReporte['Dinero Consolidado']['limites']['generados']['maximo'] <= $numAnioResolucionProyecto)
            ) ?
                $numAnioResolucionProyecto :
                $arrReporte['Dinero Consolidado']['limites']['generados']['maximo'];

            if( $objRes->fields['seqTipoActoUnidad'] == 1 ){
                $txtNombreResolucion = $objRes->fields['numActoProyecto'] . " de " . date("Y", strtotime($objRes->fields['fchActoProyecto']));
            }

            // de acuerdo al tipo de aad de proyecto suma o resta
            // para las indexaciones va calculando el valor de la unidad
            switch( $objRes->fields['seqTipoActoUnidad'] ){
                case 1: // Asignacion de unidades

                    $arrReporte['Conteo Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['generados'][$numAnioResolucionProyecto]++;
                    $arrReporte['Conteo Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['generados']['total']++;

                    $arrReporte['Dinero Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['generados'][$numAnioResolucionProyecto] += $objRes->fields['valIndexado'];
                    $arrReporte['Dinero Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['generados']['total'] += $objRes->fields['valIndexado'];

                    $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'valIndexado' ] += $objRes->fields['valIndexado'];

                    break;
                case 2: // Indexacion de unidades

                    $arrReporte['Dinero Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['generados'][$numAnioResolucionProyecto] += $objRes->fields['valIndexado'];
                    $arrReporte['Dinero Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['generados']['total'] += $objRes->fields['valIndexado'];

                    // calcular el valor definitivo de la unidad
                    $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'valIndexado' ] += $objRes->fields['valIndexado'];

                    break;
                case 3: // modificatoria (valor positivo incluye unidades // valor negativo excluye unidades)

                    if( $objRes->fields['valIndexado'] > 0 ){
                        $arrReporte['Conteo Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['generados'][$numAnioResolucionProyecto]++;
                        $arrReporte['Conteo Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['generados']['total']++;
                    }else{
                        $arrReporte['Conteo Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['generados'][$numAnioResolucionProyecto] =
                            intval($arrReporte['Conteo Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['generados'][$numAnioResolucionProyecto]) -
                            1;

                        $arrReporte['Conteo Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['generados']['total']--;
                    }

                    $arrReporte['Dinero Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['generados'][$numAnioResolucionProyecto] += $objRes->fields['valIndexado'];
                    $arrReporte['Dinero Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['generados']['total'] += $objRes->fields['valIndexado'];

                    $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'valIndexado' ] += $objRes->fields['valIndexado'];

                    break;
            }

            // conteo para las columnas de vinculados segun el estado del proceso
            if( $objRes->fields['bolCerrado'] == 1 and in_array( $objRes->fields['seqEstadoProceso'] , $this->arrEstadosVinculado ) ) {

                $numAnioResolucionHogar = date("Y", strtotime($objRes->fields['fchActoHogar']));

                // limites para vinculados
                $arrReporte['Conteo Consolidado']['limites']['vinculados']['minimo'] = (
                    ($arrReporte['Conteo Consolidado']['limites']['vinculados']['minimo'] == 0) or
                    ($arrReporte['Conteo Consolidado']['limites']['vinculados']['minimo'] >= $numAnioResolucionHogar)
                )?
                    $numAnioResolucionHogar :
                    $arrReporte['Conteo Consolidado']['limites']['vinculados']['minimo'];

                $arrReporte['Conteo Consolidado']['limites']['vinculados']['maximo'] = (
                    ($arrReporte['Conteo Consolidado']['limites']['vinculados']['maximo'] == 0) or
                    ($arrReporte['Conteo Consolidado']['limites']['vinculados']['maximo'] <= $numAnioResolucionHogar)
                )?
                    $numAnioResolucionHogar :
                    $arrReporte['Conteo Consolidado']['limites']['vinculados']['maximo'];

                // limites para vidulados desplazados y vulnerables
                $arrReporte[$bolDesplazado]['limites']['vinculados']['minimo'] = (
                    ($arrReporte[$bolDesplazado]['limites']['vinculados']['minimo'] == 0) or
                    ($arrReporte[$bolDesplazado]['limites']['vinculados']['minimo'] >= $numAnioResolucionHogar)
                )?
                    $numAnioResolucionHogar :
                    $arrReporte[$bolDesplazado]['limites']['vinculados']['minimo'];

                $arrReporte[$bolDesplazado]['limites']['vinculados']['maximo'] = (
                    ($arrReporte[$bolDesplazado]['limites']['vinculados']['maximo'] == 0) or
                    ($arrReporte[$bolDesplazado]['limites']['vinculados']['maximo'] <= $numAnioResolucionHogar)
                )?
                    $numAnioResolucionHogar :
                    $arrReporte[$bolDesplazado]['limites']['vinculados']['maximo'];

                // limites para los vinculados en dinero
                $arrReporte['Dinero Consolidado']['limites']['vinculados']['minimo'] = (
                    ($arrReporte['Dinero Consolidado']['limites']['vinculados']['minimo'] == 0) or
                    ($arrReporte['Dinero Consolidado']['limites']['vinculados']['minimo'] >= $numAnioResolucionHogar)
                )?
                    $numAnioResolucionHogar :
                    $arrReporte['Dinero Consolidado']['limites']['vinculados']['minimo'];

                $arrReporte['Dinero Consolidado']['limites']['vinculados']['maximo'] = (
                    ($arrReporte['Dinero Consolidado']['limites']['vinculados']['maximo'] == 0) or
                    ($arrReporte['Dinero Consolidado']['limites']['vinculados']['maximo'] <= $numAnioResolucionHogar)
                )?
                    $numAnioResolucionHogar :
                    $arrReporte['Dinero Consolidado']['limites']['vinculados']['maximo'];

                // limites para desplazados o vulnerables dinero
                $arrReporte['Dinero ' . $bolDesplazado]['limites']['vinculados']['minimo'] = (
                    ($arrReporte['Dinero ' . $bolDesplazado]['limites']['vinculados']['minimo'] == 0) or
                    ($arrReporte['Dinero ' . $bolDesplazado]['limites']['vinculados']['minimo'] >= $numAnioResolucionHogar)
                )?
                    $numAnioResolucionHogar :
                    $arrReporte['Dinero ' . $bolDesplazado]['limites']['vinculados']['minimo'];

                $arrReporte['Dinero ' . $bolDesplazado]['limites']['vinculados']['maximo'] = (
                    ($arrReporte['Dinero ' . $bolDesplazado]['limites']['vinculados']['maximo'] == 0) or
                    ($arrReporte['Dinero ' . $bolDesplazado]['limites']['vinculados']['maximo'] <= $numAnioResolucionHogar)
                )?
                    $numAnioResolucionHogar :
                    $arrReporte['Dinero ' . $bolDesplazado]['limites']['vinculados']['maximo'];

                // conteos
                if( ! isset( $arrFormularios[$seqFormulario] ) ) {

                    $arrReporte['Conteo Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['vinculados'][$numAnioResolucionHogar]++;
                    $arrReporte['Conteo Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['vinculados']['total']++;

                    $arrReporte[$bolDesplazado]['datos'][$txtProyecto][$txtNombreResolucion]['vinculados'][$numAnioResolucionHogar]++;
                    $arrReporte[$bolDesplazado]['datos'][$txtProyecto][$txtNombreResolucion]['vinculados']['total']++;

                }

                $arrReporte['Dinero Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['vinculados'][$numAnioResolucionHogar] += $objRes->fields['valIndexado'];
                $arrReporte['Dinero Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['vinculados']['total'] += $objRes->fields['valIndexado'];

                $arrReporte['Dinero ' . $bolDesplazado]['datos'][$txtProyecto][$txtNombreResolucion]['vinculados'][$numAnioResolucionHogar] += $objRes->fields['valIndexado'];
                $arrReporte['Dinero ' . $bolDesplazado]['datos'][$txtProyecto][$txtNombreResolucion]['vinculados']['total'] += $objRes->fields['valIndexado'];

            }

            // conteo para las columnas de legalizados segun el estado del proceso
            if( $objRes->fields['bolCerrado'] == 1 and in_array( $objRes->fields['seqEstadoProceso'] , $this->arrEstadosLegalizado ) ){

                $numAnioLegalizado = date("Y", strtotime($objRes->fields['fchLegalizado']));

                // limites para legalizados
                $arrReporte['Conteo Consolidado']['limites']['legalizados']['minimo'] = (
                    ($arrReporte['Conteo Consolidado']['limites']['legalizados']['minimo'] == 0) or
                    ($arrReporte['Conteo Consolidado']['limites']['legalizados']['minimo'] >= $numAnioLegalizado)
                )?
                    $numAnioLegalizado :
                    $arrReporte['Conteo Consolidado']['limites']['legalizados']['minimo'];

                $arrReporte['Conteo Consolidado']['limites']['legalizados']['maximo'] = (
                    ($arrReporte['Conteo Consolidado']['limites']['legalizados']['maximo'] == 0) or
                    ($arrReporte['Conteo Consolidado']['limites']['legalizados']['maximo'] <= $numAnioLegalizado)
                )?
                    $numAnioLegalizado :
                    $arrReporte['Conteo Consolidado']['limites']['legalizados']['maximo'];

                // limites para desplazados y vulnerables legalizados
                $arrReporte[$bolDesplazado]['limites']['legalizados']['minimo'] = (
                    ($arrReporte[$bolDesplazado]['limites']['legalizados']['minimo'] == 0) or
                    ($arrReporte[$bolDesplazado]['limites']['legalizados']['minimo'] >= $numAnioLegalizado)
                )?
                    $numAnioLegalizado :
                    $arrReporte[$bolDesplazado]['limites']['legalizados']['minimo'];

                $arrReporte[$bolDesplazado]['limites']['legalizados']['maximo'] = (
                    ($arrReporte[$bolDesplazado]['limites']['legalizados']['maximo'] == 0) or
                    ($arrReporte[$bolDesplazado]['limites']['legalizados']['maximo'] <= $numAnioLegalizado)
                )?
                    $numAnioLegalizado :
                    $arrReporte[$bolDesplazado]['limites']['legalizados']['maximo'];

                // limites para dinero legalizados
                $arrReporte['Dinero Consolidado']['limites']['legalizados']['minimo'] = (
                    ($arrReporte['Dinero Consolidado']['limites']['legalizados']['minimo'] == 0) or
                    ($arrReporte['Dinero Consolidado']['limites']['legalizados']['minimo'] >= $numAnioLegalizado)
                )?
                    $numAnioLegalizado :
                    $arrReporte['Dinero Consolidado']['limites']['legalizados']['minimo'];

                $arrReporte['Dinero Consolidado']['limites']['legalizados']['maximo'] = (
                    ($arrReporte['Dinero Consolidado']['limites']['legalizados']['maximo'] == 0) or
                    ($arrReporte['Dinero Consolidado']['limites']['legalizados']['maximo'] <= $numAnioLegalizado)
                )?
                    $numAnioLegalizado :
                    $arrReporte['Dinero Consolidado']['limites']['legalizados']['maximo'];

                // limites para dinero legalizados
                $arrReporte['Dinero ' . $bolDesplazado]['limites']['legalizados']['minimo'] = (
                    ($arrReporte['Dinero ' . $bolDesplazado]['limites']['legalizados']['minimo'] == 0) or
                    ($arrReporte['Dinero ' . $bolDesplazado]['limites']['legalizados']['minimo'] >= $numAnioLegalizado)
                )?
                    $numAnioLegalizado :
                    $arrReporte['Dinero ' . $bolDesplazado]['limites']['legalizados']['minimo'];

                $arrReporte['Dinero ' . $bolDesplazado]['limites']['legalizados']['maximo'] = (
                    ($arrReporte['Dinero ' . $bolDesplazado]['limites']['legalizados']['maximo'] == 0) or
                    ($arrReporte['Dinero ' . $bolDesplazado]['limites']['legalizados']['maximo'] <= $numAnioLegalizado)
                )?
                    $numAnioLegalizado :
                    $arrReporte['Dinero ' . $bolDesplazado]['limites']['legalizados']['maximo'];

                // conteos
                if( ! isset( $arrFormularios[$seqFormulario] ) ) {
                    $arrReporte['Conteo Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['legalizados'][$numAnioLegalizado]++;
                    $arrReporte['Conteo Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['legalizados']['total']++;

                    $arrReporte[$bolDesplazado]['datos'][$txtProyecto][$txtNombreResolucion]['legalizados'][$numAnioLegalizado]++;
                    $arrReporte[$bolDesplazado]['datos'][$txtProyecto][$txtNombreResolucion]['legalizados']['total']++;
                }

                $arrReporte['Dinero Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['legalizados'][$numAnioLegalizado] += $objRes->fields['valIndexado'];
                $arrReporte['Dinero Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['legalizados']['total'] += $objRes->fields['valIndexado'];

                $arrReporte['Dinero ' . $bolDesplazado]['datos'][$txtProyecto][$txtNombreResolucion]['legalizados'][$numAnioLegalizado] += $objRes->fields['valIndexado'];
                $arrReporte['Dinero ' . $bolDesplazado]['datos'][$txtProyecto][$txtNombreResolucion]['legalizados']['total'] += $objRes->fields['valIndexado'];

            }

            // se usa mas adelante para completar la informacion de la hoja de hogares
            if( intval( $seqFormulario ) != 0 ) {
                $arrFormularios[$seqFormulario]['numResolucion'] = $objRes->fields['numActoHogar'];
                $arrFormularios[$seqFormulario]['fchResolucion'] = $objRes->fields['fchActoHogar'];
            }

            // Prepara los datos para la hoja de proyectos
            $txtNombreProyectoPadre = (trim($objRes->fields['txtNombreProyectoPadre']) != "")? trim($objRes->fields['txtNombreProyectoPadre']) : trim($objRes->fields['txtNombreProyectoHijo']);
            $txtNombreProyectoHijo  = (trim($objRes->fields['txtNombreProyectoHijo']) != "")? trim($objRes->fields['txtNombreProyectoHijo']) : "No Aplica";
            $txtNitProyecto         = (trim($objRes->fields['txtNitProyectoPadre']) != "")? trim( $objRes->fields['txtNitProyectoPadre'] ) : trim( $objRes->fields['txtNitProyectoHijo'] );
            $txtLocalidad           = (trim($objRes->fields['txtLocalidadPadre']) != "")?  trim($objRes->fields['txtLocalidadPadre']) : trim($objRes->fields['txtLocalidadHijo']);
            $txtBarrio              = (trim($objRes->fields['txtBarrioPadre']) != "")? trim($objRes->fields['txtBarrioPadre']) : trim($objRes->fields['txtBarrioHijo']);
            $txtNombreOferente1     = (trim($objRes->fields['txtNombreOferentePadre1']) != "")? trim($objRes->fields['txtNombreOferentePadre1']) : trim($objRes->fields['txtNombreOferenteHijo1']);
            $numNitOferente1        = (trim($objRes->fields['numNitOferentePadre1']) != "")? trim($objRes->fields['numNitOferentePadre1']) : trim($objRes->fields['numNitOferenteHijo1']);
            $txtNombreOferente2     = (trim($objRes->fields['txtNombreOferentePadre2']) != "")? trim($objRes->fields['txtNombreOferentePadre2']) : trim($objRes->fields['txtNombreOferenteHijo2']);
            $numNitOferente2        = (trim($objRes->fields['numNitOferentePadre2']) != "")? trim($objRes->fields['numNitOferentePadre2']) : trim($objRes->fields['numNitOferenteHijo2']);
            $txtNombreOferente3     = (trim($objRes->fields['txtNombreOferentePadre3']) != "")? trim($objRes->fields['txtNombreOferentePadre3']) : trim($objRes->fields['txtNombreOferenteHijo3']);
            $numNitOferente3        = (trim($objRes->fields['numNitOferentePadre3']) != "")? trim($objRes->fields['numNitOferentePadre3']) : trim($objRes->fields['numNitOferenteHijo3']);
            $txtNombreConstructor   = (trim($objRes->fields['txtNombreConstructorPadre']) != "")? trim($objRes->fields['txtNombreConstructorPadre']) : trim($objRes->fields['txtNombreConstructorHijo']);
            $txtNombreVendedor      = (trim($objRes->fields['txtNombreVendedorPadre']) != "")? trim($objRes->fields['txtNombreVendedorPadre']) : trim($objRes->fields['txtNombreVendedorHijo']);
            $numNitVendedor         = (trim($objRes->fields['txtNitVendedorPadre']) != "")? trim($objRes->fields['txtNitVendedorPadre']) : trim($objRes->fields['txtNitVendedorHijo']);

            /***************************************************************************
             * PROCESAMIENTO DE LA HOJA DE PROYECTOS
             ***************************************************************************/

            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'seqUnidadProyecto' ]  = $seqUnidadProyecto;
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'seqFormulario' ]      = $objRes->fields['seqFormularioUnidad'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Proyecto Padre' ]     = $txtNombreProyectoPadre;
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Proyecto Hijo' ]      = $txtNombreProyectoHijo;
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Nit Proyecto' ]       = $txtNitProyecto;
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Localidad Proyecto' ] = $txtLocalidad;
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Barrio Proyecto' ]    = $txtBarrio;
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Oferente 1' ]         = $txtNombreOferente1;
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Nit Oferente 1' ]     = $numNitOferente1;
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Oferente 2' ]         = $txtNombreOferente2;
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Nit Oferente 2' ]     = $numNitOferente2;
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Oferente 3' ]         = $txtNombreOferente3;
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Nit Oferente 3' ]     = $numNitOferente3;
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Constructor' ]        = $txtNombreConstructor;
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Vendedor' ]           = $txtNombreVendedor;
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Nit Vendedor' ]       = $numNitVendedor;
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Unidad' ]                 = $objRes->fields['txtNombreUnidad'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Matricula Inmobiliaria' ] = $objRes->fields['txtMatriculaInmobiliaria'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'CHIP' ]                   = $objRes->fields['txtChipLote'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'SDVE Aprobado' ]          = $objRes->fields['valSDVEAprobado'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'SDVE Actual' ]            = $objRes->fields['valSDVEActual'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'SDVE Complementario' ]    = $objRes->fields['valSDVEComplementario'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Valor Indexado' ]         = $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'valIndexado' ];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Legalizado' ]             = $objRes->fields['bolLegalizado'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Fecha de Legalización' ]  = $objRes->fields['fchLegalizado'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Plan de Gobierno' ]       = $objRes->fields['txtPlanGobierno'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Modalidad' ]              = $objRes->fields['txtModalidad'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Unidad Activa' ]          = $objRes->fields['bolActivo'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Vendedor Escriturado' ]               = $objRes->fields['numDocumentoVendedor'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Tipo de Vivienda' ]                   = $objRes->fields['txtCompraVivienda'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Dirección Escriturada' ]              = $objRes->fields['txtDireccionInmueble'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Ciudad Escriturada' ]                 = $objRes->fields['txtCiudad'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Localidad Escriturada' ]              = $objRes->fields['txtLocalidad'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Barrio Escriturado' ]                 = $objRes->fields['txtBarrio'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Propiedad' ]                          = $objRes->fields['txtPropiedad'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Escritura' ]                          = $objRes->fields['txtEscritura'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Fecha Escritura' ]                    = $objRes->fields['fchEscritura'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Notaria Escritura' ]                  = $objRes->fields['numNotaria'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Ciudad Escritura' ]                   = $objRes->fields['txtCiudadEscritura'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Fecha de Sentencia' ]                 = $objRes->fields['fchSentencia'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Juzgado Sentencia' ]                  = $objRes->fields['numJuzgado'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Ciudad Sentencia' ]                   = $objRes->fields['txtCiudadSentencia'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Resolución' ]                         = $objRes->fields['numResolucion'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Fecha de Resolución' ]                = $objRes->fields['fchResolucion'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Entidad de Reslolución' ]             = $objRes->fields['txtEntidad'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Ciudad Resolución' ]                  = $objRes->fields['txtCiudadResolucion'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Matricula Inmoviliaria Escriturada' ] = $objRes->fields['txtMatriculaInmobiliariaEscriturada'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'CHIP Escriturado' ]                   = $objRes->fields['txtChip'];
            $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'Tipo de Predio' ]                     = $objRes->fields['txtTipoPredio'];

            /***************************************************************************
             * PROCESAMIENTO DE LA HOJA DE RESOLUCIONES
             ***************************************************************************/

            $numPosicion = count( $arrReporte['resoluciones'] );
            $arrReporte['resoluciones'][ $numPosicion ]['seqUnidadProyecto'] = $seqUnidadProyecto;
            $arrReporte['resoluciones'][ $numPosicion ]['Proyecto Padre'] = $txtNombreProyectoPadre;
            $arrReporte['resoluciones'][ $numPosicion ]['Proyecto Hijo'] = $txtNombreProyectoHijo;
            $arrReporte['resoluciones'][ $numPosicion ]['Nombre Unidad'] = $objRes->fields['txtNombreUnidad'];
            $arrReporte['resoluciones'][ $numPosicion ]['Tipo Resolución'] = $objRes->fields['txtTipoActoUnidad'];
            $arrReporte['resoluciones'][ $numPosicion ]['Numero Resolución'] = $objRes->fields['numActoProyecto'];
            $arrReporte['resoluciones'][ $numPosicion ]['Fecha Resolución'] = $objRes->fields['fchActoProyecto'];
            $arrReporte['resoluciones'][ $numPosicion ]['Año Resolución'] = (esFechaValida($objRes->fields['fchActoProyecto']))?
                date("Y" , strtotime($objRes->fields['fchActoProyecto'])) :
                "";
            $arrReporte['resoluciones'][$numPosicion]['Valor Indexación'] = $objRes->fields['valIndexado'];
            switch($objRes->fields['seqTipoActoUnidad']){
                case 1:
                    $arrReporte['resoluciones'][$numPosicion]['Observación'] = "Generacion";
                    break;
                case 2:
                    $arrReporte['resoluciones'][$numPosicion]['Observación'] = ($objRes->fields['valIndexado'] > 0)? "Indexación Positiva" : "Indexación Negativa";
                    break;
                case 3:
                    $arrReporte['resoluciones'][$numPosicion]['Observación'] = ($objRes->fields['valIndexado'] > 0)? "Adiciona Unidad" : "Retira Unidades";
                    break;
            }

            $objRes->MoveNext();
        }

        ksort($arrReporte['Conteo Consolidado']['datos']);
        ksort($arrReporte['Desplazado']['datos']);
        ksort($arrReporte['Vulnerable']['datos']);
        ksort($arrReporte['Dinero Consolidado']['datos']);
        ksort($arrReporte['Dinero Desplazado']['datos']);
        ksort($arrReporte['Dinero Vulnerable']['datos']);

        // obtiene los datos del hogar
        $arrReporte['hogares'] = $this->obtenerHogares($arrFormularios,$seqCorte);

        // adiciona el dato del aad del hogar
        foreach( $arrReporte['hogares'] as $numLinea => $arrDatos ){
            $seqFormulario = $arrDatos['seqFormularioVeeduria'];
            unset($arrReporte['hogares'][$numLinea]['seqFormularioVeeduria']);
            if( isset( $arrFormularios[$seqFormulario] ) ){
                $arrReporte['hogares'][$numLinea]['Resolución'] = $arrFormularios[$seqFormulario]['numResolucion'];
                $arrReporte['hogares'][$numLinea]['Fecha'] = $arrFormularios[$seqFormulario]['fchResolucion'];
                $arrReporte['hogares'][$numLinea]['Año'] = (esFechaValida($arrFormularios[$seqFormulario]['fchResolucion']))?
                    date( "Y" , strtotime( $arrFormularios[$seqFormulario]['fchResolucion'] )) :
                    "";
            }
        }

        // quita la variable de paso de calculo del valor indexado de proyectos
        foreach( $arrReporte['Proyectos'] as $seqUnidadProyecto => $arrDatos ){
            unset( $arrReporte['Proyectos'][ $seqUnidadProyecto ][ 'valIndexado' ] );
        }

        return $arrReporte;
    }

    public function reporteNoProyectos($seqCorte)
    {
        global $aptBd, $arrConfiguracion;

        $sql = "
            SELECT
                frm.seqFormularioVeeduria,
                frm.seqFormulario as 'Formulario',
                pgo.txtPlanGobierno as 'Plan de Gobierno',
                IF(moa.txtModalidad is null,'No Disponible',moa.txtModalidad) as 'Modalidad',
                IF(tes.txtTipoEsquema is null,'No Disponible',tes.txtTipoEsquema) as 'Esquema', 
                eta.txtEtapa as 'Etapa', 
                epr.txtEstadoProceso as 'Estado', 
                IF(frm.fchVigencia < '2000-01-01',NULL,frm.fchVigencia) as 'Vigencia',
                valAspiraSubsidio as 'Valor Aporte / Subsidio',
                IF(frm.valComplementario is null,0,frm.valComplementario) as 'Valor Complementario Hogar',
                aad.numActo as 'Resolución',
                aad.fchActo as 'Fecha',              
                UPPER(des.txtMatriculaInmobiliaria) as 'Matrícula Inmoviliaria-ME',
                UPPER(des.txtChip) as 'CHIP-ME',
                UPPER(des.txtCedulaCatastral) as 'Cédula Catastral-ME',
                UPPER(des.txtTipoPredio) as 'Tipo de Predio-ME',
                UPPER(esc.txtNombreVendedor) as 'Vendedor',
                tdo1.txtTipoDocumento as 'Tipo de Documento del Vendedor', 
                esc.numDocumentoVendedor as 'Documento del Vendedor',
                UPPER(esc.txtCompraVivienda) as 'Tipo de Vivienda',
                UPPER(esc.txtDireccionInmueble) as 'Dirección',
                ciu1.txtCiudad as 'Ciudad',
                UPPER(loc1.txtLocalidad) as 'Localidad',
                UPPER(esc.txtBarrio) as 'Barrio',
                UPPER(IF(esc.txtPropiedad is null,'Ninguno',esc.txtPropiedad)) as 'Propiedad',
                esc.txtEscritura as 'Escritura',
                IF(esc.fchEscritura < '2000-01-01',NULL,esc.fchEscritura) as 'Fecha de Escritura',
                esc.numNotaria as 'Notaria de Escritura',
                UPPER(esc.txtCiudad) as 'Ciudad de Escritura',
                IF(esc.fchSentencia < '2000-01-01',NULL,esc.fchSentencia) as 'Fecha de Sentencia',
                esc.numJuzgado as 'Juzgado de Sentencia',
                UPPER(esc.txtCiudadSentencia) as 'Ciudad de Sentencia',
                esc.numResolucion as 'Numero de Resolución',
                IF(esc.fchResolucion < '2000-01-01',NULL,esc.fchResolucion) as 'Fecha de Resolución',
                UPPER(esc.txtEntidad) as 'Entidad Resolución',
                UPPER(esc.txtCiudadResolucion) as 'Ciudad Resolución',
                UPPER(esc.txtMatriculaInmobiliaria) as 'Matrícula Inmobiliaria',
                UPPER(esc.txtChip) as 'CHIP',
                UPPER(esc.txtTipoPredio) as 'Tipo de Predio',
                tit.numEscrituraTitulo as 'Número Escritura Titulo',
                IF(tit.fchEscrituraTitulo < '2000-01-01',NULL,tit.fchEscrituraTitulo) as 'Fecha Escritura Titulo',
                tit.numNotariaTitulo as 'Notaría Titulo',
                tit.numFolioMatricula as 'Folio Matrícula',
                tit.txtZonaMatricula as 'Zona Matricula',
                tit.txtCiudadMatricula as 'Ciudad Matricula',
                IF(tit.fchMatricula < '2000-01-01',NULL,tit.fchMatricula) as 'Fecha Matricula'
            FROM t_vee_formulario frm
            LEFT JOIN t_frm_plan_gobierno pgo on frm.seqPlanGobierno = pgo.seqPlanGobierno
            LEFT JOIN t_frm_modalidad moa on frm.seqModalidad = moa.seqModalidad
            LEFT JOIN t_pry_tipo_esquema tes on frm.seqTipoEsquema = tes.seqTipoEsquema
            LEFT JOIN t_frm_estado_proceso epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
            LEFT JOIN t_frm_etapa eta on epr.seqEtapa = eta.seqEtapa
            LEFT JOIN t_vee_desembolso des ON frm.seqFormularioVeeduria = des.seqFormularioVeeduria
            LEFT JOIN t_vee_escrituracion esc ON des.seqDesembolsoVeeduria = esc.seqDesembolsoVeeduria
            LEFT JOIN t_vee_estudio_titulos tit ON des.seqDesembolsoVeeduria = tit.seqDesembolsoVeeduria
            LEFT JOIN t_ciu_tipo_documento tdo on des.seqTipoDocumento = tdo.seqTipoDocumento
            LEFT JOIN t_ciu_tipo_documento tdo1 on des.seqTipoDocumento = tdo1.seqTipoDocumento
            LEFT JOIN v_frm_ciudad ciu on des.seqCiudad = ciu.seqCiudad
            LEFT JOIN v_frm_ciudad ciu1 on des.seqCiudad = ciu1.seqCiudad
            LEFT JOIN t_frm_localidad loc on des.seqLocalidad = loc.seqLocalidad
            LEFT JOIN t_frm_localidad loc1 on des.seqLocalidad = loc1.seqLocalidad
            INNER JOIN
            (
                SELECT 
                    seqFormulario, 
                    hvi.numActo, 
                    hvi.fchActo
                FROM t_aad_hogares_vinculados hvi
                INNER JOIN (
                    SELECT 
                        fac.seqFormulario, 
                        max(fac.seqFormularioActo) AS seqFormularioActo
                    FROM t_aad_hogares_vinculados hvi
                    INNER JOIN t_aad_formulario_acto fac ON hvi.seqFormularioActo = fac.seqFormularioActo
                    WHERE hvi.seqTipoActo = 1
                    GROUP BY fac.seqFormulario
                ) frm ON hvi.seqFormularioActo = frm.seqFormularioActo
            ) aad ON frm.seqFormulario = aad.seqFormulario
            WHERE ( 
                 frm.seqUnidadProyecto = 0
              OR frm.seqUnidadProyecto IS NULL
              OR frm.seqUnidadProyecto = 1
            ) AND frm.seqCorte = $seqCorte
        ";
        $objRes = $aptBd->execute($sql);
        $arrFormularios = array();

        while ($objRes->fields){
            $seqFormularioVeeduria = $objRes->fields['seqFormularioVeeduria'];
            unset($objRes->fields['seqFormularioVeeduria']);
            $arrReporte['asignados'][] = $objRes->fields;
            $arrFormularios[$seqFormularioVeeduria]['Resolución'] = $objRes->fields['Resolución'];
            $arrFormularios[$seqFormularioVeeduria]['Fecha'] = $objRes->fields['Fecha'];
            $objRes->MoveNext();
        }

        // obtiene las solicitudes de desembolso
        $sql = "
            select
                frm.seqFormulario,
                sol.seqSolicitud,
                sol.numOrden,
                sol.fchOrden,
                sol.valOrden
            from t_vee_formulario frm
            inner join t_vee_desembolso des on frm.seqFormularioVeeduria = des.seqFormularioVeeduria
            inner join t_vee_solicitud sol on des.seqDesembolsoVeeduria = sol.seqDesembolsoVeeduria
            where frm.seqFormularioVeeduria in ( " . implode("," , array_keys( $arrFormularios ) ) . " )
              and frm.seqCorte = $seqCorte
              and (sol.numOrden <> 0)
        ";
        $objRes = $aptBd->execute($sql);
        $numMaximo = 1;
        $arrSolicitudes = array();
        while($objRes->fields){
            $seqFormulario = $objRes->fields['seqFormulario'];
            $seqSolicitud = $objRes->fields['seqSolicitud'];
            $arrSolicitudes[$seqFormulario][$seqSolicitud]['numOrden'] = $objRes->fields['numOrden'];
            $arrSolicitudes[$seqFormulario][$seqSolicitud]['fchOrden'] = $objRes->fields['fchOrden'];
            $arrSolicitudes[$seqFormulario][$seqSolicitud]['valOrden'] = $objRes->fields['valOrden'];
            if(count($arrSolicitudes[$seqFormulario]) > $numMaximo){
                $numMaximo = count($arrSolicitudes[$seqFormulario]);
            }
            $objRes->MoveNext();
        }

        // ordena las solicitudes dentro del arreglo
        foreach($arrReporte['asignados'] as $numLinea => $arrRegistro ){
            $seqFormulario = $arrRegistro['Formulario'];
            $i = 1;
            foreach($arrSolicitudes[$seqFormulario] as $seqSolicitud => $arrDatos){
                $arrRegistro['Orden ' . $i] = $arrDatos['numOrden'];
                $arrRegistro['Fecha ' . $i] = $arrDatos['fchOrden'];
                $arrRegistro['Valor ' . $i] = $arrDatos['valOrden'];
                $i++;
            }
            for($i = $i; $i <= $numMaximo; $i++){
                $arrRegistro['Orden ' . $i] = "";
                $arrRegistro['Fecha ' . $i] = "";
                $arrRegistro['Valor ' . $i] = "";
            }
            $arrReporte['asignados'][$numLinea] = $arrRegistro;
        }

        $arrReporte['hogares'] = $this->obtenerHogares($arrFormularios,$seqCorte);

        // adiciona el dato del aad del hogar
        foreach( $arrReporte['hogares'] as $numLinea => $arrDatos ){
            $seqFormulario = $arrDatos['seqFormularioVeeduria'];
            unset($arrReporte['hogares'][$numLinea]['seqFormularioVeeduria']);
            if( isset( $arrFormularios[$seqFormulario] ) ){
                $arrReporte['hogares'][$numLinea]['Resolución'] = $arrFormularios[$seqFormulario]['Resolución'];
                $arrReporte['hogares'][$numLinea]['Fecha'] = $arrFormularios[$seqFormulario]['Fecha'];
                $arrReporte['hogares'][$numLinea]['Año'] = (esFechaValida($arrFormularios[$seqFormulario]['Fecha']))?
                    date( "Y" , strtotime( $arrFormularios[$seqFormulario]['Fecha'] )) :
                    "";
            }
        }

        return $arrReporte;
    }

    private function obtenerHogares($arrFormularios , $seqCorte)
    {
        global $aptBd;

        $arrHogares = array();
        $arrEstado = estadosProceso();
        $arrPlanGobierno = obtenerDatosTabla( "T_FRM_PLAN_GOBIERNO" , array( "seqPlanGobierno" , "txtPlanGobierno" ) , "seqPlanGobierno" , "" , "txtPlanGobierno" );
        $arrModalidad = obtenerDatosTabla("T_FRM_MODALIDAD", array("seqModalidad", "txtModalidad"), "seqModalidad");
        $arrTipoEsquema = obtenerDatosTabla("T_PRY_TIPO_ESQUEMA", array("seqTipoEsquema", "txtTipoEsquema"), "seqTipoEsquema");
        $arrSolucion = obtenerDatosTabla("T_FRM_SOLUCION", array("seqSolucion", "txtSolucion", "txtDescripcion"), "seqSolucion");
        $arrSisben = obtenerDatosTabla("T_FRM_SISBEN", array("seqSisben", "txtSisben"), "seqSisben");
        $arrProyecto = obtenerDatosTabla("T_PRY_PROYECTO", array("seqProyecto", "txtNombreProyecto"), "seqProyecto");
        $arrUnidad = obtenerDatosTabla("t_pry_unidad_proyecto", array("seqUnidadProyecto", "txtNombreUnidad"), "seqUnidadProyecto");
        $arrLocalidad = obtenerDatosTabla("T_FRM_LOCALIDAD", array("seqLocalidad", "txtLocalidad"), "seqLocalidad");
        $arrBarrio = obtenerDatosTabla("T_FRM_BARRIO", array("seqBarrio", "txtBarrio"), "seqBarrio");
        $arrTipoDocumento = obtenerDatosTabla("T_CIU_TIPO_DOCUMENTO", array("seqTipoDocumento", "txtTipoDocumento"), "seqTipoDocumento");
        $arrParentesco = obtenerDatosTabla("T_CIU_PARENTESCO", array("seqParentesco", "txtParentesco"), "seqParentesco");
        $arrOcupacion = obtenerDatosTabla("T_CIU_OCUPACION", array("seqOcupacion", "txtOcupacion"), "seqOcupacion");
        $arrEstadoCivil = obtenerDatosTabla("T_CIU_ESTADO_CIVIL", array("seqEstadoCivil", "txtEstadoCivil"), "seqEstadoCivil");
        $arrSexo = obtenerDatosTabla("T_CIU_SEXO", array("seqSexo", "txtSexo"), "seqSexo", "", "txtSexo");
        $arrNivelEducativo = obtenerDatosTabla("T_CIU_NIVEL_EDUCATIVO", array("seqNivelEducativo", "txtNivelEducativo"), "seqNivelEducativo");
        $arrCondicionEtnica = obtenerDatosTabla("T_CIU_ETNIA", array("seqEtnia", "txtEtnia"), "seqEtnia");
        $arrSalud = obtenerDatosTabla("T_CIU_SALUD", array("seqSalud", "txtSalud"), "seqSalud");
        $arrGrupoLgtbi = obtenerDatosTabla("T_FRM_GRUPO_LGTBI", array("seqGrupoLgtbi", "txtGrupoLgtbi"), "seqGrupoLgtbi");
        $arrTipoVictima = obtenerDatosTabla("T_FRM_TIPOVICTIMA", array("seqTipoVictima", "txtTipoVictima"), "seqTipoVictima");

        $sql = "
            SELECT
                frm1.seqFormularioVeeduria,
                upper(concat( ciu1.txtNombre1,' ', ciu1.txtNombre2,' ', ciu1.txtApellido1,' ', ciu1.txtApellido2 )) as txtNombre,
                ciu1.numDocumento,
                tdo1.txtTipoDocumento
            FROM t_vee_formulario frm1
            INNER JOIN t_vee_hogar hog1 ON frm1.seqFormularioVeeduria = hog1.seqFormularioVeeduria and hog1.seqParentesco = 1
            INNER JOIN t_vee_ciudadano ciu1 ON hog1.seqCiudadanoVeeduria = ciu1.seqCiudadanoVeeduria and ciu1.seqCorte = $seqCorte
            INNER JOIN t_ciu_tipo_documento tdo1 on ciu1.seqTipoDocumento = tdo1.seqTipoDocumento
            WHERE frm1.seqCorte = $seqCorte     
              AND frm1.seqFormularioVeeduria IN ( " . implode("," , array_keys( $arrFormularios ) ) . " )  
        ";
        $objRes = $aptBd->execute($sql);
        $arrPostulantePrincipal = array();
        while($objRes->fields){
            $seqFormularioVeeduria = $objRes->fields['seqFormularioVeeduria'];
            $arrPostulantePrincipal[$seqFormularioVeeduria]['txtNombre'] = $objRes->fields['txtNombre'];
            $arrPostulantePrincipal[$seqFormularioVeeduria]['txtTipoDocumento'] = $objRes->fields['txtTipoDocumento'];
            $arrPostulantePrincipal[$seqFormularioVeeduria]['numDocumento'] = $objRes->fields['numDocumento'];
            $objRes->MoveNext();
        }

        $sql = "
            select
                frm.seqFormularioVeeduria,
                frm.seqFormulario,
                frm.seqEstadoProceso,
                frm.seqPlanGobierno,
                frm.seqModalidad,
                frm.seqTipoEsquema,
                frm.seqSolucion,
                frm.txtFormulario,
                frm.fchInscripcion,
                frm.fchPostulacion,
                frm.fchUltimaActualizacion,
                frm.fchVencimiento,
                frm.fchVigencia,
                frm.bolCerrado,
                frm.bolSancion,
                frm.seqSisben,
                frm.seqProyecto,
                frm.seqProyectoHijo,
                frm.seqUnidadProyecto,
                frm.seqLocalidad,
                frm.seqBarrio,
                frm.numHabitaciones,
                frm.numHacinamiento,
                upper(concat( ciu.txtNombre1,' ', ciu.txtNombre2,' ', ciu.txtApellido1,' ', ciu.txtApellido2 )) as txtNombre,
                ciu.seqTipoDocumento,
                ciu.numDocumento,
                hog.seqParentesco,
                ciu.seqOcupacion,
                ciu.seqEstadoCivil,
                ciu.seqSexo,
                FLOOR((DATEDIFF(NOW(), ciu.fchNacimiento) / 365)) AS Edad,
                rangoEdad(FLOOR((DATEDIFF(NOW(), ciu.fchNacimiento) / 365))) AS 'Rango Edad',
                ciu.seqNivelEducativo,
                ciu.numAnosAprobados,
                ciu.seqEtnia,
                ciu.seqSalud,
                ciu.seqCondicionEspecial ,
                ciu.seqCondicionEspecial2 ,
                ciu.seqCondicionEspecial3,
                ciu.bolLgtb,
                ciu.seqGrupoLgtbi,
                frm.bolDesplazado,
                ciu.seqTipoVictima
            from t_vee_formulario frm
            inner join t_vee_hogar hog ON frm.seqFormularioVeeduria = hog.seqFormularioVeeduria
            inner join t_vee_ciudadano ciu ON hog.seqCiudadanoVeeduria = ciu.seqCiudadanoVeeduria and ciu.seqCorte = $seqCorte
              and frm.seqCorte = $seqCorte
              and frm.seqFormularioVeeduria IN ( " . implode("," , array_keys( $arrFormularios ) ) . " )     
        ";
        $objRes = $aptBd->execute($sql);

        while($objRes->fields){

            foreach($objRes->fields as $txtCampo => $txtValor){
                $$txtCampo = $txtValor;
            }

            $numPosicion = count($arrHogares);

            $arrHogares[$numPosicion]['seqFormularioVeeduria'] = $objRes->fields['seqFormularioVeeduria'];
            $arrHogares[$numPosicion]['Formulario'] = $objRes->fields['seqFormulario'];
            $arrHogares[$numPosicion]['Estado'] = ($seqEstadoProceso != null)? $arrEstado[$seqEstadoProceso] : "No Disponible";
            $arrHogares[$numPosicion]['Plan de Gobierno'] = ($seqPlanGobierno != null)? $arrPlanGobierno[$seqPlanGobierno] : "No Disponible";
            $arrHogares[$numPosicion]['Modalidad'] = $arrModalidad[$seqModalidad];
            $arrHogares[$numPosicion]['Esquema'] = ($seqTipoEsquema != null)? $arrTipoEsquema[$seqTipoEsquema] : "No Disponible";
            $arrHogares[$numPosicion]['Solución'] = ($seqSolucion != null)? $arrSolucion[$seqSolucion]['txtSolucion'] : "No Disponible";
            $arrHogares[$numPosicion]['Descripción'] = ($seqSolucion != null)? $arrSolucion[$seqSolucion]['txtDescripcion'] : "No Disponible";
            $arrHogares[$numPosicion]['Inscripción'] = (esFechaValida($objRes->fields['fchInscripcion']))? $objRes->fields['fchInscripcion'] : "No Disponible";
            $arrHogares[$numPosicion]['Postulación'] = (esFechaValida($objRes->fields['fchPostulacion']))? $objRes->fields['fchPostulacion'] : "No Disponible";
            $arrHogares[$numPosicion]['Actualización'] = (esFechaValida($objRes->fields['fchUltimaActualizacion']))? $objRes->fields['fchUltimaActualizacion'] : "No Disponible";
            $arrHogares[$numPosicion]['Vencimiento'] = (esFechaValida($objRes->fields['fchVencimiento']))? $objRes->fields['fchVencimiento'] : "No Disponible";
            $arrHogares[$numPosicion]['Vigencia'] = (esFechaValida($objRes->fields['fchVigencia']))? $objRes->fields['fchVigencia'] : "No Disponible";
            $arrHogares[$numPosicion]['Cerrado'] = ($objRes->fields['bolCerrado'] == 1)? "Si" : "No";
            $arrHogares[$numPosicion]['# Formulario'] = ($objRes->fields['txtFormulario'] != "")? $objRes->fields['txtFormulario'] : "No Disponible";
            $arrHogares[$numPosicion]['Sanción'] = ($objRes->fields['bolSancion'] == 1)? "Si" : "No";
            $arrHogares[$numPosicion]['Sisben'] = ($seqSisben != null)? $arrSisben[$seqSisben] : "No Disponible";
            $arrHogares[$numPosicion]['Proyecto'] = ($seqProyecto != null and $seqProyecto != 0)? $arrProyecto[$seqProyecto] : "No Disponible";
            $arrHogares[$numPosicion]['Conjunto'] = ($seqProyectoHijo != null and $seqProyectoHijo != 0)? $arrProyecto[$seqProyectoHijo] : "No Disponible";
            $arrHogares[$numPosicion]['# Unidad'] = ($seqUnidadProyecto != null)? $seqUnidadProyecto : "No Disponible";
            $arrHogares[$numPosicion]['Unidad'] = ($seqUnidadProyecto != null)? $arrUnidad[$seqUnidadProyecto] : "No Disponible";
            $arrHogares[$numPosicion]['Localidad'] = ($seqLocalidad != null)? $arrLocalidad[$seqLocalidad] : "No Disponible";
            $arrHogares[$numPosicion]['Barrio'] = ($seqBarrio != null)? $arrBarrio[$seqBarrio] : "No Disponible";
            $arrHogares[$numPosicion]['Dormitorios'] = intval($objRes->fields['numHabitaciones']);
            $arrHogares[$numPosicion]['Hacinamiento'] = intval($objRes->fields['numHacinamiento']);
            $arrHogares[$numPosicion]['Postulante Principal'] = $arrPostulantePrincipal[$seqFormularioVeeduria]['txtNombre'];
            $arrHogares[$numPosicion]['Tipo de Documento Principal'] = $arrPostulantePrincipal[$seqFormularioVeeduria]['txtTipoDocumento'];
            $arrHogares[$numPosicion]['Documento Principal'] = $arrPostulantePrincipal[$seqFormularioVeeduria]['numDocumento'];
            $arrHogares[$numPosicion]['Nombre'] = $objRes->fields['txtNombre'];
            $arrHogares[$numPosicion]['Tipo de Documento'] = ($seqTipoDocumento != null)? $arrTipoDocumento[$seqTipoDocumento] : "No Disponible";
            $arrHogares[$numPosicion]['Documento'] = $objRes->fields['numDocumento'];
            $arrHogares[$numPosicion]['Parentesco'] = ($seqParentesco != null)? $arrParentesco[$seqParentesco] : "No Disponible";
            $arrHogares[$numPosicion]['Ocupación'] = ($seqOcupacion != null)? $arrOcupacion[$seqOcupacion] : "No Disponible";
            $arrHogares[$numPosicion]['Estado Civil'] = ($seqEstadoCivil != null)? $arrEstadoCivil[$seqEstadoCivil] : "No Disponible";
            $arrHogares[$numPosicion]['Sexo'] = ($seqSexo != null)? $arrSexo[$seqSexo] : "No Disponible";
            $arrHogares[$numPosicion]['Edad'] = $objRes->fields['Edad'];
            $arrHogares[$numPosicion]['Rango Edad'] = $objRes->fields['Rango Edad'];
            $arrHogares[$numPosicion]['Nivel Educativo'] = ($seqNivelEducativo != null)? $arrNivelEducativo[$seqNivelEducativo] : "No Disponible";
            $arrHogares[$numPosicion]['Años Aprobados'] = $objRes->fields['numAnosAprobados'];
            $arrHogares[$numPosicion]['Etnia'] = ($seqEtnia != null)? $arrCondicionEtnica[$seqEtnia] : "No Disponible";
            $arrHogares[$numPosicion]['Salud'] = ($seqSalud != null)? $arrSalud[$seqSalud] : "No Disponible";

            $seqCondicionEspecial1 = $objRes->fields['seqCondicionEspecial'];
            $seqCondicionEspecial2 = $objRes->fields['seqCondicionEspecial2'];
            $seqCondicionEspecial3 = $objRes->fields['seqCondicionEspecial3'];

            unset($objRes->fields['seqCondicionEspecial']);
            unset($objRes->fields['seqCondicionEspecial2']);
            unset($objRes->fields['seqCondicionEspecial3']);

            $txtCabezaFamilia    = "No";
            $txtMayor65          = "No";
            $txtDiscapacitado    = "No";
            $txtNingunaCondicion = "No";

            if($seqCondicionEspecial1 == 1 or $seqCondicionEspecial2 == 1 or $seqCondicionEspecial3 == 1) {
                $txtCabezaFamilia = "Si";
            }

            if($seqCondicionEspecial1 == 2 or $seqCondicionEspecial2 == 2 or $seqCondicionEspecial3 == 2){
                $txtMayor65 = "Si";
            }

            if($seqCondicionEspecial1 == 3 or $seqCondicionEspecial2 == 3 or $seqCondicionEspecial3 == 3){
                $txtDiscapacitado = "Si";
            }

            if($seqCondicionEspecial1 == 6 and $seqCondicionEspecial2 == 6 and $seqCondicionEspecial3 == 6){
                $txtNingunaCondicion = "Si";
            }

            $arrHogares[$numPosicion]['Cabeza de Familia'] = $txtCabezaFamilia;
            $arrHogares[$numPosicion]['Mayor de 65'] = $txtMayor65;
            $arrHogares[$numPosicion]['Discapacitado'] = $txtDiscapacitado;
            $arrHogares[$numPosicion]['Ninguna Condición'] = $txtNingunaCondicion;

            $arrHogares[$numPosicion]['LGTBI'] = ($objRes->fields['bolLgtb'] == 1)? "SI" : "NO";
            $arrHogares[$numPosicion]['Grupo LGTBI'] = ($seqGrupoLgtbi != null)? $arrGrupoLgtbi[$seqGrupoLgtbi] : "No Disponible";

            $arrHogares[$numPosicion]['Desplazado'] = ($objRes->fields['bolDesplazado'] == 1)? "SI" : "NO";
            $arrHogares[$numPosicion]['Victima'] = ($seqTipoVictima != null)? $arrTipoVictima[$seqTipoVictima] : "No Disponible";

            $objRes->MoveNext();
        }

        return $arrHogares;
    }

    private function fuentesXML(){

        $xmlEstilos = "<Styles>";

        $xmlEstilos .= "<Style ss:ID='Default' ss:Name='Normal'>";
        $xmlEstilos .= "<Alignment/>";
        $xmlEstilos .= "<Borders/>";
        $xmlEstilos .= "<Font ss:FontName='Calibri' ss:Size='8'/>";
        $xmlEstilos .= "<Interior/>";
        $xmlEstilos .= "<NumberFormat/>";
        $xmlEstilos .= "<Protection/>";
        $xmlEstilos .= "</Style>";

        $xmlEstilos .= "<Style ss:ID='s1'>";
        $xmlEstilos .= "<Alignment ss:Vertical='Center' ss:Horizontal='Center'/>";
        $xmlEstilos .= "<Font ss:FontName='Calibri' ss:Size='8' ss:Bold='1'/>";
        $xmlEstilos .= "<Interior ss:Color='#D8D8D8' ss:Pattern='Solid'/>";
        $xmlEstilos .= "</Style>";

        $xmlEstilos .= "<Style ss:ID='s2'>";
        $xmlEstilos .= "<Alignment ss:Vertical='Center' ss:Horizontal='Right'/>";
        $xmlEstilos .= "<Font ss:FontName='Calibri' ss:Size='8' ss:Bold='1'/>";
        $xmlEstilos .= "<Interior ss:Color='#D8D8D8' ss:Pattern='Solid'/>";
        $xmlEstilos .= "</Style>";

        $xmlEstilos .= "<Style ss:ID='s3'>";
        $xmlEstilos .= "<Alignment ss:Vertical='Center' ss:Horizontal='Right'/>";
        $xmlEstilos .= "<Font ss:FontName='Calibri' ss:Size='8' ss:Bold='1'/>";
        $xmlEstilos .= "<Interior ss:Color='#D8D8D8' ss:Pattern='Solid'/>";
        $xmlEstilos .= "</Style>";

        $xmlEstilos .= "<Style ss:ID='s4'>";
        $xmlEstilos .= "<Borders>";
        $xmlEstilos .= "<Border ss:Position='Right' ss:LineStyle='Continuous' ss:Weight='1'/>";
        $xmlEstilos .= "</Borders>";
        $xmlEstilos .= "<Alignment ss:Vertical='Center' ss:Horizontal='Right'/>";
        $xmlEstilos .= "<Font ss:FontName='Calibri' ss:Size='8' ss:Bold='1'/>";
        $xmlEstilos .= "<Interior ss:Color='#F2F2F2' ss:Pattern='Solid'/>";
        $xmlEstilos .= "</Style>";

        $xmlEstilos .= "<Style ss:ID='s5'>";
        $xmlEstilos .= "<NumberFormat ss:Format='yyyy-mm-dd'/>";
        $xmlEstilos .= "</Style>";

        $xmlEstilos .= "<Style ss:ID='s6'>";
        $xmlEstilos .= "<Alignment ss:Vertical='Center' ss:Horizontal='Left'/>";
        $xmlEstilos .= "<Font ss:FontName='Calibri' ss:Size='8'/>";
        $xmlEstilos .= "<Interior ss:Color='#C5D9F1' ss:Pattern='Solid'/>";
        $xmlEstilos .= "</Style>";

        $xmlEstilos .= "<Style ss:ID='s7'>";
        $xmlEstilos .= "<Alignment ss:Vertical='Center' ss:Horizontal='Left'/>";
        $xmlEstilos .= "<Font ss:FontName='Calibri' ss:Size='8'/>";
        $xmlEstilos .= "<Interior ss:Color='#F2DDDC' ss:Pattern='Solid'/>";
        $xmlEstilos .= "</Style>";

        $xmlEstilos .= "<Style ss:ID='s8'>";
        $xmlEstilos .= "<Alignment ss:Vertical='Center' ss:Horizontal='Left'/>";
        $xmlEstilos .= "<Font ss:FontName='Calibri' ss:Size='8'/>";
        $xmlEstilos .= "<Interior ss:Color='#EAF1DD' ss:Pattern='Solid'/>";
        $xmlEstilos .= "</Style>";

        $xmlEstilos .= "<Style ss:ID='s9'>";
        $xmlEstilos .= "<Alignment ss:Vertical='Center' ss:Horizontal='Left'/>";
        $xmlEstilos .= "<Font ss:FontName='Calibri' ss:Size='8'/>";
        $xmlEstilos .= "<Interior ss:Color='#E5E0EC' ss:Pattern='Solid'/>";
        $xmlEstilos .= "</Style>";

        $xmlEstilos .= "<Style ss:ID='s10'>";
        $xmlEstilos .= "<Alignment ss:Vertical='Center' ss:Horizontal='Left'/>";
        $xmlEstilos .= "<Font ss:FontName='Calibri' ss:Size='8'/>";
        $xmlEstilos .= "<Interior ss:Color='#F2F2F2' ss:Pattern='Solid'/>";
        $xmlEstilos .= "</Style>";

        $xmlEstilos .= "<Style ss:ID='s11'>";
        $xmlEstilos .= "<Alignment ss:Vertical='Center' ss:Horizontal='Left'/>";
        $xmlEstilos .= "<Font ss:FontName='Calibri' ss:Size='8'/>";
        $xmlEstilos .= "<Interior ss:Color='#FDE9D9' ss:Pattern='Solid'/>";
        $xmlEstilos .= "</Style>";

        $xmlEstilos .= "</Styles>";

        return $xmlEstilos;

    }

    private function tipoDato($txtValor){
        switch(true){
            case (esFechaValida($txtValor)) and (strlen($txtValor) <= 10) and (strtotime( $txtValor ) !== false):
                $txtTipo = "DateTime";
                break;
            case is_numeric($txtValor):
                $txtTipo = "Number";
                break;
            default:
                $txtTipo = "String";
                break;
        }
        return $txtTipo;
    }

    private function obtenerXMLEncabezado(){
        $xmlArchivo  = "<?xml version='1.0'?> ";
        $xmlArchivo .= "<?mso-application progid='Excel.Sheet'?> ";
        $xmlArchivo .= "<Workbook xmlns='urn:schemas-microsoft-com:office:spreadsheet' ";
        $xmlArchivo .= "xmlns:o='urn:schemas-microsoft-com:office:office' ";
        $xmlArchivo .= "xmlns:x='urn:schemas-microsoft-com:office:excel' ";
        $xmlArchivo .= "xmlns:ss='urn:schemas-microsoft-com:office:spreadsheet' ";
        $xmlArchivo .= "xmlns:html='http://www.w3.org/TR/REC-html40'>";
        return $xmlArchivo;
    }

    private function obtenerXMLPie(){
        $xmlArchivo = "</ss:Workbook>";
        return $xmlArchivo;
    }

    private function obtenerXMLHojaPlana( $arrReporte , $txtNombreHoja, $arrColores = array() )
    {
        $xmlArchivo  = "<ss:Worksheet ss:Name='$txtNombreHoja'>";
        $xmlArchivo .= "<ss:Table>";

        // Para los colores de las columnas, de sobreescriben las celdas
        if( ! empty( $arrColores ) ){
            foreach ( $arrColores as $txtTitulo => $txtEstilo ){
                $xmlArchivo .= "<Column ss:AutoFitWidth='1' ss:StyleID='$txtEstilo'/>";
            }
        }

        // titulos
        $xmlArchivo .= "<ss:Row>";
        $arrTitulos = reset($arrReporte);

        foreach ($arrTitulos as $txtTitulo => $txtValor){
            $xmlArchivo .= "<ss:Cell ss:StyleID='s1'><ss:Data ss:Type='String'>$txtTitulo</ss:Data></ss:Cell>";
        }
        $xmlArchivo .= "</ss:Row>";

        // datos
        foreach ($arrReporte as $numLinea => $arrDatos){
            $xmlArchivo .= "<ss:Row>";
            foreach($arrDatos as $txtTitulo => $txtValor) {
                $txtTipo = $this->tipoDato( $txtValor );
                $txtEstilo = "";
                switch($txtTipo){
                    case "DateTime":
                        $txtValor = date( "Y-m-d" , strtotime( $txtValor ) );
                        $txtEstilo = "ss:StyleID='s5'";
                        break;
                    case "Number":
                        $txtValor = doubleval($txtValor);
                        break;
                    default:
                        $txtValor = trim($txtValor);
                        break;
                }
                $xmlArchivo .= "<ss:Cell $txtEstilo><ss:Data ss:Type='$txtTipo'>" . $txtValor . "</ss:Data></ss:Cell>";
            }
            $xmlArchivo .= "</ss:Row>";
        }
        $xmlArchivo .= "</ss:Table>";
        $xmlArchivo .= "</ss:Worksheet>";

        return $xmlArchivo;
    }

    private function exportarResultadosXML( $xmlArchivo , $txtNombreArchivo )
    {
        $txtNombre = mb_ereg_replace("[^0-9a-zA-Z_]","", $txtNombreArchivo) . "_" . date("YmdHis") . ".xls";
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-Disposition: inline; filename=\"" . $txtNombre . "\"");
        echo $xmlArchivo;
    }

    public function imprimirReporteProyectos($arrReporte, $seqCorte)
    {

        /***********************************************
         * ENCABEZADO
         ***********************************************/

        $xmlArchivo = $this->obtenerXMLEncabezado();

        /***********************************************
         * ESTILOS DE FUENTES
         ***********************************************/

        $xmlArchivo .= $this->fuentesXML();

        /***********************************************
         * HOJA REPORTE CONTEOS Y DINERO
         ***********************************************/

        // conteos
        $xmlArchivo .= $this->obtenerXMLHojaConteo($arrReporte['Conteo Consolidado'],'Conteo Consolidado');
        $xmlArchivo .= $this->obtenerXMLHojaConteo($arrReporte['Desplazado'],'Desplazado');
        $xmlArchivo .= $this->obtenerXMLHojaConteo($arrReporte['Vulnerable'],'Vulnerable');

        // dinero
        $xmlArchivo .= $this->obtenerXMLHojaConteo($arrReporte['Dinero Consolidado'],'Dinero Consolidado');
        $xmlArchivo .= $this->obtenerXMLHojaConteo($arrReporte['Dinero Desplazado'],'Dinero Desplazado');
        $xmlArchivo .= $this->obtenerXMLHojaConteo($arrReporte['Dinero Vulnerable'],'Dinero Vulnerable');

        /***********************************************
         * HOJA REPORTE DE HOGARES
         ***********************************************/

        $xmlArchivo .= $this->obtenerXMLHojaPlana( $arrReporte['hogares'] , "Hogares" );

        /***********************************************
         * HOJA PROYECTOS
         ***********************************************/

        $xmlArchivo .= $this->obtenerXMLHojaPlana( $arrReporte['Proyectos'] , "Proyectos" );

        /***********************************************
         * HOJA RESOLUCIONES
         ***********************************************/

        $xmlArchivo .= $this->obtenerXMLHojaPlana( $arrReporte['resoluciones'] , "Resoluciones" );

        $xmlArchivo .= $this->obtenerXMLPie();

        $arrCorte = array_shift($this->obtenerCortes($seqCorte));

        $this->exportarResultadosXML( $xmlArchivo , "IP_" . $arrCorte['txtCorte'] );


    }

    public function imprimirReporteNoProyectos($arrReporte,$seqCorte)
    {

        /***********************************************
         * ENCABEZADO
         ***********************************************/

        $xmlArchivo = $this->obtenerXMLEncabezado();

        /***********************************************
         * ESTILOS DE FUENTES
         ***********************************************/

        $xmlArchivo .= $this->fuentesXML();

        /***********************************************
         * HOJA REPORTE
         ***********************************************/

        $xmlArchivo .= $this->obtenerXMLHojaPlana( $arrReporte['asignados'] , "Asignados");

        /***********************************************
         * HOJA REPORTE DE HOGARES
         ***********************************************/

        $xmlArchivo .= $this->obtenerXMLHojaPlana( $arrReporte['hogares'] , "Hogares" );

        $xmlArchivo .= $this->obtenerXMLPie();

        $arrCorte = array_shift($this->obtenerCortes($seqCorte));

        $this->exportarResultadosXML( $xmlArchivo , "INP_" . $arrCorte['txtCorte']  );

    }

    private function obtenerXMLHojaConteo($arrReporte,$txtNombre)
    {
        $numAcrossGenerados   = intval($arrReporte['limites']['generados']['maximo'])   - intval($arrReporte['limites']['generados']['minimo']);
        $numAcrossVinculados  = intval($arrReporte['limites']['vinculados']['maximo'])  - intval($arrReporte['limites']['vinculados']['minimo']);
        $numAcrossLegalizados = intval($arrReporte['limites']['legalizados']['maximo']) - intval($arrReporte['limites']['legalizados']['minimo']);

        $xmlArchivo  = "<ss:Worksheet ss:Name='$txtNombre'>";
        $xmlArchivo .= "<ss:Table>";
        $xmlArchivo .= "<Column ss:AutoFitWidth='0' ss:Width='180'/>";

        /***********************************************
         * TITULOS 1 (CABECERA)
         ***********************************************/

        $xmlArchivo .= "<ss:Row>";
        $xmlArchivo .= "<ss:Cell ss:StyleID='s1' ss:MergeDown='1'><ss:Data ss:Type='String'>Proyecto</ss:Data></ss:Cell>";
        $xmlArchivo .= "<ss:Cell ss:StyleID='s1' ss:MergeDown='1'><ss:Data ss:Type='String'>Resoluciones</ss:Data></ss:Cell>";
        if($numAcrossGenerados > 0) {
            $xmlArchivo .= "<ss:Cell ss:StyleID='s1' ss:MergeAcross='" . ($numAcrossGenerados + 1) . "'><ss:Data ss:Type='String'>Subsidios Generados</ss:Data></ss:Cell>";
        }
        if($numAcrossVinculados > 0) {
            $xmlArchivo .= "<ss:Cell ss:StyleID='s1' ss:MergeAcross='" . ($numAcrossVinculados + 1) . "'><ss:Data ss:Type='String'>Vinculados</ss:Data></ss:Cell>";
        }
        if($numAcrossLegalizados > 0) {
            $xmlArchivo .= "<ss:Cell ss:StyleID='s1' ss:MergeAcross='" . ($numAcrossLegalizados + 1). "'><ss:Data ss:Type='String'>Legalizados</ss:Data></ss:Cell>";
        }
        $xmlArchivo .= "</ss:Row>";

        /***********************************************
         * TITULOS 2 (AÑOS)
         ***********************************************/

        $xmlArchivo .= "<ss:Row>";

        // titulos de anios para generados
        $bolIndex = false;
        if(intval($arrReporte['limites']['generados']['minimo']) > 0) {
            for ($numAnio = $arrReporte['limites']['generados']['minimo']; $numAnio <= $arrReporte['limites']['generados']['maximo']; $numAnio++) {
                if ($bolIndex == false and $numAnio == $arrReporte['limites']['generados']['minimo']) {
                    $bolIndex = true;
                    $xmlArchivo .= "<ss:Cell ss:StyleID='s2' ss:Index='3'><ss:Data ss:Type='Number'>$numAnio</ss:Data></ss:Cell>";
                }else{
                    $xmlArchivo .= "<ss:Cell ss:StyleID='s2'><ss:Data ss:Type='Number'>$numAnio</ss:Data></ss:Cell>";
                }
            }
            $xmlArchivo .= "<ss:Cell ss:StyleID='s3'><ss:Data ss:Type='String'>Total</ss:Data></ss:Cell>";
        }

        // titulos - anios para vinculados
        if(intval($arrReporte['limites']['vinculados']['minimo']) > 0) {
            for ($numAnio = $arrReporte['limites']['vinculados']['minimo']; $numAnio <= $arrReporte['limites']['vinculados']['maximo']; $numAnio++) {
                if ($bolIndex == false and $numAnio == $arrReporte['limites']['vinculados']['minimo']) {
                    $bolIndex = true;
                    $xmlArchivo .= "<ss:Cell ss:StyleID='s2' ss:Index='3'><ss:Data ss:Type='Number'>$numAnio</ss:Data></ss:Cell>";
                }else{
                    $xmlArchivo .= "<ss:Cell ss:StyleID='s2'><ss:Data ss:Type='Number'>$numAnio</ss:Data></ss:Cell>";
                }

            }
            $xmlArchivo .= "<ss:Cell ss:StyleID='s3'><ss:Data ss:Type='String'>Total</ss:Data></ss:Cell>";
        }

        // titulos - anios para legalizados
        if(intval($arrReporte['limites']['legalizados']['minimo'])) {
            for ($numAnio = $arrReporte['limites']['legalizados']['minimo']; $numAnio <= $arrReporte['limites']['legalizados']['maximo']; $numAnio++) {
                if ($bolIndex == false and $numAnio == $arrReporte['limites']['legalizados']['minimo']) {
                    $bolIndex = true;
                    $xmlArchivo .= "<ss:Cell ss:StyleID='s2' ss:Index='3'><ss:Data ss:Type='Number'>$numAnio</ss:Data></ss:Cell>";
                }else{
                    $xmlArchivo .= "<ss:Cell ss:StyleID='s2'><ss:Data ss:Type='Number'>$numAnio</ss:Data></ss:Cell>";
                }

            }
            $xmlArchivo .= "<ss:Cell ss:StyleID='s3'><ss:Data ss:Type='String'>Total</ss:Data></ss:Cell>";
        }

        $xmlArchivo .= "</ss:Row>";

        /***********************************************
         * LINEAS
         ***********************************************/

        // datos del reporte
        foreach ($arrReporte['datos'] as $txtProyecto => $arrResoluciones) {
            foreach ($arrResoluciones as $txtNombreResolucion => $arrDatos) {
                $xmlArchivo .= "<ss:Row>";

                // GENERADOS
                $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>$txtProyecto</ss:Data></ss:Cell>";
                $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>$txtNombreResolucion</ss:Data></ss:Cell>";

                if(isset($arrDatos['generados'])) {
                    for ($numAnio = $arrReporte['limites']['generados']['minimo']; $numAnio <= $arrReporte['limites']['generados']['maximo']; $numAnio++) {
                        if (isset($arrDatos['generados'][$numAnio])) {
                            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>" . $arrDatos['generados'][$numAnio] . "</ss:Data></ss:Cell>";
                        }else{
                            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>0</ss:Data></ss:Cell>";
                        }
                    }
                    $xmlArchivo .= "<ss:Cell ss:StyleID='s4'><ss:Data ss:Type='Number'>" . $arrDatos['generados']['total'] . "</ss:Data></ss:Cell>";
                }

                // VINCULADOS
                if(isset($arrDatos['vinculados'])) {
                    for ($numAnio = $arrReporte['limites']['vinculados']['minimo']; $numAnio <= $arrReporte['limites']['vinculados']['maximo']; $numAnio++) {
                        if (isset($arrDatos['vinculados'][$numAnio])) {
                            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>" . $arrDatos['vinculados'][$numAnio] . "</ss:Data></ss:Cell>";
                        }else{
                            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>0</ss:Data></ss:Cell>";
                        }
                    }
                    $xmlArchivo .= "<ss:Cell ss:StyleID='s4'><ss:Data ss:Type='Number'>" . $arrDatos['vinculados']['total'] . "</ss:Data></ss:Cell>";
                }else{
                    for ($numAnio = $arrReporte['limites']['vinculados']['minimo']; $numAnio <= $arrReporte['limites']['vinculados']['maximo']; $numAnio++) {
                        $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>0</ss:Data></ss:Cell>";
                    }
                    $xmlArchivo .= "<ss:Cell ss:StyleID='s4'><ss:Data ss:Type='Number'>0</ss:Data></ss:Cell>";
                }

                // LEGALIZADOS
                if(isset($arrDatos['legalizados'])) {
                    for ($numAnio = $arrReporte['limites']['legalizados']['minimo']; $numAnio <= $arrReporte['limites']['legalizados']['maximo']; $numAnio++) {
                        if (isset($arrDatos['legalizados'][$numAnio])) {
                            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>" . $arrDatos['legalizados'][$numAnio] . "</ss:Data></ss:Cell>";
                        }else{
                            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>0</ss:Data></ss:Cell>";
                        }
                    }
                    $xmlArchivo .= "<ss:Cell ss:StyleID='s4'><ss:Data ss:Type='Number'>" . $arrDatos['legalizados']['total'] . "</ss:Data></ss:Cell>";
                }else{
                    for ($numAnio = $arrReporte['limites']['legalizados']['minimo']; $numAnio <= $arrReporte['limites']['legalizados']['maximo']; $numAnio++) {
                        $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>0</ss:Data></ss:Cell>";
                    }
                    $xmlArchivo .= "<ss:Cell ss:StyleID='s4'><ss:Data ss:Type='Number'>0</ss:Data></ss:Cell>";
                }

                $xmlArchivo .= "</ss:Row>";
            }
        }

        $xmlArchivo .= "</ss:Table>";
        $xmlArchivo .= "</ss:Worksheet>";

        return $xmlArchivo;
    }

}