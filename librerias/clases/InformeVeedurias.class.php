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

    function __construct()
    {
        $this->arrErrores = array();
        $this->seqCorte = 0;
        $this->txtCorte = "";
        $this->fchCorte = null;
        $this->txtNombre = "";
        $this->arrEstadosVinculado = array( 15, 62, 17, 19, 22, 23, 24, 25, 26, 27, 28, 29, 31, 40 );
        $this->arrEstadosLegalizado = array( 40 );
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
                pry1.txtNombreProyecto as txtNombreProyectoPadre, 
                pry1.numNitProyecto as txtNitProyectoPadre, 
                loc1.txtLocalidad as txtLocalidadPadre,
                bar1.txtBarrio as txtBarrioPadre, 
                eof11.txtNombreOferente as txtNombreOferentePadre1,
                eof11.numNitOferente as numNitOferentePadre1, 
                eof12.txtNombreOferente2 as txtNombreOferentePadre2,
                eof12.numNitOferente2 as numNitOferentePadre2, 
                eof13.txtNombreOferente3 as txtNombreOferentePadre3,
                eof13.numNitOferente3 as numNitOferentePadre3, 
                con1.txtNombreConstructor as txtNombreConstructorPadre,
                con1.numDocumentoConstructor as numDocumentoConstructorPadre,
                pry1.txtNombreVendedor as txtNombreVendedorPadre, 
                pry1.numNitVendedor as txtNitVendedorPadre,
                pry.txtNombreProyecto as txtNombreProyectoHijo,
                pry.numNitProyecto as numNitProyectoHijo, 
                loc2.txtLocalidad as txtLocalidadHijo,
                bar2.txtBarrio as txtBarrioHijo,
                eof.txtNombreOferente as txtNombreOferenteHijo1,
                eof.numNitOferente as numNitOferenteHijo1, 
                eof2.txtNombreOferente2 as txtNombreOferenteHijo2,
                eof2.numNitOferente2 as numNitOferenteHijo2, 
                eof3.txtNombreOferente3 as txtNombreOferenteHijo3,
                eof3.numNitOferente3 as numNitOferenteHijo3, 
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
                UPPER(esc.txtTipoPredio) as txtTipoPredio
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
            left  join t_pry_entidad_oferente eof11 on pry1.seqProyecto = eof11.seqProyecto
            left  join t_pry_entidad_oferente eof12 on pry1.seqProyecto = eof12.seqProyecto
            left  join t_pry_entidad_oferente eof13 on pry1.seqProyecto = eof13.seqProyecto
            left  join t_pry_entidad_oferente eof on pry.seqProyecto = eof.seqProyecto
            left  join t_pry_entidad_oferente eof2 on pry.seqProyecto = eof2.seqProyecto
            left  join t_pry_entidad_oferente eof3 on pry.seqProyecto = eof3.seqProyecto
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
            -- and pry.seqProyecto in (149,30)
            order by pry.txtNombreProyecto, uac.seqTipoActoUnidad
        "; // and pry.seqProyecto = 30
        $objRes = $aptBd->execute($sql);
        $arrReporte = array();
        $arrFormularios = array();
        while ($objRes->fields) {

            /***************************************************************************
             * PROCESAMIENTO DE LA HOJA DE REPORTE
             ***************************************************************************/

            $seqUnidadProyecto = $objRes->fields['seqUnidadProyecto'];
            $bolDesplazado = $objRes->fields['bolDesplazado'];
            $seqFormulario = $objRes->fields['seqFormulario'];

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
            if( $objRes->fields['bolCerrado'] == 1 and in_array( $objRes->fields['seqEstadoProceso'] , $this->arrEstadosVinculado ) and ! isset( $arrFormularios[$seqFormulario] ) ) {

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
                $arrReporte['Conteo Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['vinculados'][$numAnioResolucionHogar]++;
                $arrReporte['Conteo Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['vinculados']['total']++;

                $arrReporte[$bolDesplazado]['datos'][$txtProyecto][$txtNombreResolucion]['vinculados'][$numAnioResolucionHogar]++;
                $arrReporte[$bolDesplazado]['datos'][$txtProyecto][$txtNombreResolucion]['vinculados']['total']++;

                $arrReporte['Dinero Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['vinculados'][$numAnioResolucionHogar] += $objRes->fields['valIndexado'];
                $arrReporte['Dinero Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['vinculados']['total'] += $objRes->fields['valIndexado'];

                $arrReporte['Dinero ' . $bolDesplazado]['datos'][$txtProyecto][$txtNombreResolucion]['vinculados'][$numAnioResolucionHogar] += $objRes->fields['valIndexado'];
                $arrReporte['Dinero ' . $bolDesplazado]['datos'][$txtProyecto][$txtNombreResolucion]['vinculados']['total'] += $objRes->fields['valIndexado'];

            }

            // conteo para las columnas de legalizados segun el estado del proceso
            if( $objRes->fields['bolCerrado'] == 1 and in_array( $objRes->fields['seqEstadoProceso'] , $this->arrEstadosLegalizado ) and ! isset( $arrFormularios[$seqFormulario] ) ){

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
                $arrReporte['Conteo Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['legalizados'][$numAnioLegalizado]++;
                $arrReporte['Conteo Consolidado']['datos'][$txtProyecto][$txtNombreResolucion]['legalizados']['total']++;

                $arrReporte[$bolDesplazado]['datos'][$txtProyecto][$txtNombreResolucion]['legalizados'][$numAnioLegalizado]++;
                $arrReporte[$bolDesplazado]['datos'][$txtProyecto][$txtNombreResolucion]['legalizados']['total']++;

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
            $seqFormulario = $arrDatos['Formulario'];
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
        global $aptBd;
        $sql = "
            SELECT DISTINCT 
              frm.seqFormulario as 'Formulario',
              pgo.txtPlanGobierno as 'Plan de Gobierno',
              IF(moa.txtModalidad is null,'No Disponible',moa.txtModalidad) as 'Modalidad',
              IF(tes.txtTipoEsquema is null,'No Disponible',tes.txtTipoEsquema) as 'Esquema', 
              eta.txtEtapa as 'Etapa', 
              epr.txtEstadoProceso as 'Estado', 
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
              UPPER(esc.txtTipoPredio) as 'Tipo de Predio'
            FROM t_vee_formulario frm
            LEFT JOIN t_frm_plan_gobierno pgo on frm.seqPlanGobierno = pgo.seqPlanGobierno
            LEFT JOIN t_frm_modalidad moa on frm.seqModalidad = moa.seqModalidad
            LEFT JOIN t_pry_tipo_esquema tes on frm.seqTipoEsquema = tes.seqTipoEsquema
            LEFT JOIN t_frm_estado_proceso epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
            LEFT JOIN t_frm_etapa eta on epr.seqEtapa = eta.seqEtapa
            LEFT JOIN t_vee_desembolso des ON frm.seqFormularioVeeduria = des.seqFormularioVeeduria
            LEFT JOIN t_vee_escrituracion esc ON des.seqDesembolsoVeeduria = esc.seqDesembolsoVeeduria
            LEFT JOIN t_ciu_tipo_documento tdo on des.seqTipoDocumento = tdo.seqTipoDocumento
            LEFT JOIN t_ciu_tipo_documento tdo1 on des.seqTipoDocumento = tdo1.seqTipoDocumento
            LEFT JOIN v_frm_ciudad ciu on des.seqCiudad = ciu.seqCiudad
            LEFT JOIN v_frm_ciudad ciu1 on des.seqCiudad = ciu1.seqCiudad
            LEFT JOIN t_frm_localidad loc on des.seqLocalidad = loc.seqLocalidad
            LEFT JOIN t_frm_localidad loc1 on des.seqLocalidad = loc1.seqLocalidad
            INNER JOIN
            (
              SELECT 
                frm.seqFormulario, 
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
            -- AND frm.seqFormulario = 25760
        "; //echo $sql . "<hr>"; die();
        $objRes = $aptBd->execute($sql);
        $arrFormularios = array();
        while ( $objRes->fields ){
            $seqFormulario = $objRes->fields['Formulario'];
            $arrReporte['reporte'][] = $objRes->fields;
            $arrFormularios[$seqFormulario]['Resolución'] = $objRes->fields['Resolución'];
            $arrFormularios[$seqFormulario]['Fecha'] = $objRes->fields['Fecha'];
            $objRes->MoveNext();
        }

        $arrReporte['hogares'] = $this->obtenerHogares($arrFormularios,$seqCorte);

        // adiciona el dato del aad del hogar
        foreach( $arrReporte['hogares'] as $numLinea => $arrDatos ){
            $seqFormulario = $arrDatos['Formulario'];
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

    private function obtenerHogares($arrFormularios , $seqCorte )
    {
        global $aptBd;
        $sql = "
            SELECT
              frm.seqFormulario as Formulario,
              eta.txtEtapa as Etapa,
              epr.txtEstadoProceso as Estado,
              pgo.txtPlanGobierno as 'Plan de Gobierno',
              IF(frm.seqModalidad <> 0, moa.txtModalidad,'No Disponible') as Modalidad,
              IF(frm.seqTipoEsquema is not null, tes.txtTipoEsquema,'No Disponible') as Esquema,
              sol.txtSolucion as Solucion, 
              sol.txtDescripcion as 'Descripcion de la Solucion',
              frm.fchInscripcion as 'Fecha de Inscripcion',
              frm.fchPostulacion as 'Fecha de Postulacion',
              frm.fchUltimaActualizacion as 'Ultima Actualizacion',
              frm.fchVencimiento as 'Fecha de Vencimiento',
              IF(frm.bolCerrado = 1, 'SI', 'NO') as Cerrado,
              frm.txtFormulario as 'Numero de Formulario',
              IF(frm.bolSancion = 1, 'SI', 'NO') as Sancionado,
              sis.txtSisben as Sisben,
              IF(frm.seqProyecto is null or frm.seqProyecto = 0,'No Disponible',pry.txtNombreProyecto) as Proyecto,
              IF(frm.seqProyectoHijo is null or frm.seqProyectoHijo = 0,'No Disponible',pry1.txtNombreProyecto) as Conjunto,
              IF(frm.seqUnidadProyecto is null or frm.seqUnidadProyecto = 1,'No Disponible',upr.txtNombreUnidad) as Unidad,
              upr.fchLegalizado as 'Fecha Legalización',
              loc.seqLocalidad as Localidad,
              if(bar.txtBarrio is null,'No Disponible',bar.txtBarrio) as Barrio,
              if(frm.numHabitaciones is null,0,frm.numHabitaciones) as Dormitorios,
              if(frm.numHacinamiento is null,0,frm.numHacinamiento) as Hacinamiento,
              ppal.txtNombre as 'Postulante Principal - Nombre',
              ppal.txtTipoDocumento as 'Postulante Principal - Tipo de Documento',
              ppal.numDocumento as 'Postulante Principal - Documento',
              upper(concat( ciu.txtNombre1,' ', ciu.txtNombre2,' ', ciu.txtApellido1,' ', ciu.txtApellido2 )) as Nombre,
              tdo.txtTipoDocumento as 'Tipo de Documento',
              ciu.numDocumento as Documento,
              par.txtParentesco as Parentesco,
              FLOOR((DATEDIFF(NOW(), ciu.fchNacimiento) / 365)) AS Edad,
              rangoEdad(FLOOR((DATEDIFF(NOW(), ciu.fchNacimiento) / 365))) AS 'Rango Edad',
              ned.txtNivelEducativo as 'Nivel Educativo', 
              ciu.numAnosAprobados as 'Años Aprobados',
              etn.txtEtnia as 'Condicion Etnica', 
              eci.txtEstadoCivil as 'Estado Civil', 
              ocu.txtOcupacion as 'Ocupacion',   
              sal.txtSalud as 'Afiliacion a Salud',
              ucwords( cabezaFamilia( ciu.seqCondicionEspecial , ciu.seqCondicionEspecial2 , ciu.seqCondicionEspecial3 ) ) as 'Cabeza de Familia',
              ucwords( mayor65anos( ciu.seqCondicionEspecial , ciu.seqCondicionEspecial2 , ciu.seqCondicionEspecial3 ) ) as 'Mayor de 65',
              ucwords( discapacitado( ciu.seqCondicionEspecial , ciu.seqCondicionEspecial2 , ciu.seqCondicionEspecial3 ) ) as 'Discapacitado',
              ucwords( ningunaCondicionEspecial( ciu.seqCondicionEspecial , ciu.seqCondicionEspecial2 , ciu.seqCondicionEspecial3 ) ) as 'Ninguna Condicion',    
              sex.txtSexo as Sexo, 
              if(ciu.bolLgtb=1,'Si','No') as LGTBI, 
              glg.txtGrupoLgtbi as 'Grupo LGTBI', 
              if(frm.bolDesplazado = 1, 'Si','No') as Desplazado,
              tvi.txtTipoVictima 'Hecho Victimizante'
            FROM t_vee_formulario frm
            INNER JOIN t_vee_hogar hog ON frm.seqFormularioVeeduria = hog.seqFormularioVeeduria
            INNER JOIN t_vee_ciudadano ciu ON hog.seqCiudadanoVeeduria = ciu.seqCiudadanoVeeduria and ciu.seqCorte = $seqCorte
            INNER JOIN t_frm_estado_proceso epr on frm.seqEstadoProceso = epr.seqEstadoProceso
            INNER JOIN t_frm_etapa eta on epr.seqEtapa = eta.seqEtapa
            INNER JOIN t_frm_plan_gobierno pgo on frm.seqPlanGobierno = pgo.seqPlanGobierno
            LEFT  JOIN t_frm_modalidad moa on frm.seqModalidad = moa.seqModalidad
            LEFT  JOIN t_pry_tipo_esquema tes on frm.seqTipoEsquema = tes.seqTipoEsquema
            INNER JOIN t_frm_solucion sol on frm.seqSolucion = sol.seqSolucion 
            INNER JOIN t_frm_sisben sis on frm.seqSisben = sis.seqSisben
            LEFT JOIN t_vee_proyecto pry ON frm.seqProyecto = pry.seqProyecto and pry.seqCorte = $seqCorte
            LEFT JOIN t_vee_proyecto pry1 ON frm.seqProyectoHijo = pry1.seqProyecto and pry1.seqCorte = $seqCorte
            LEFT JOIN t_vee_unidad_proyecto upr ON frm.seqUnidadProyecto = upr.seqUnidadProyecto and upr.seqProyectoVeeduria = pry.seqProyectoVeeduria
            INNER JOIN t_frm_localidad loc on frm.seqLocalidad = loc.seqLocalidad
            LEFT  JOIN t_frm_barrio bar on frm.seqBarrio = bar.seqBarrio
            INNER JOIN t_ciu_parentesco par on hog.seqParentesco = par.seqParentesco
            INNER JOIN (
              SELECT 
                frm1.seqFormularioVeeduria,
                upper(concat( ciu1.txtNombre1,' ', ciu1.txtNombre2,' ', ciu1.txtApellido1,' ', ciu1.txtApellido2 )) as txtNombre,
                ciu1.numDocumento,
                tdo1.txtTipoDocumento
              FROM t_vee_formulario frm1
              INNER JOIN t_vee_hogar hog1 ON frm1.seqFormularioVeeduria = hog1.seqFormularioVeeduria and hog1.seqParentesco = 1
              INNER JOIN t_vee_ciudadano ciu1 ON hog1.seqCiudadanoVeeduria = ciu1.seqCiudadanoVeeduria
              INNER JOIN t_ciu_tipo_documento tdo1 on ciu1.seqTipoDocumento = tdo1.seqTipoDocumento
            ) ppal on frm.seqFormularioVeeduria = ppal.seqFormularioVeeduria
            INNER JOIN t_ciu_tipo_documento tdo on ciu.seqTipoDocumento = tdo.seqTipoDocumento
            LEFT  JOIN t_ciu_nivel_educativo ned on ciu.seqNivelEducativo = ned.seqNivelEducativo
            INNER JOIN t_ciu_etnia etn on ciu.seqEtnia = etn.seqEtnia
            INNER JOIN t_ciu_estado_civil eci on ciu.seqEstadoCivil = eci.seqEstadoCivil
            INNER JOIN t_ciu_ocupacion ocu on ciu.seqOcupacion = ocu.seqOcupacion
            INNER JOIN t_ciu_sexo sex on ciu.seqSexo = sex.seqSexo
            LEFT  JOIN t_ciu_salud sal on ciu.seqSalud = sal.seqSalud
            LEFT  JOIN t_frm_tipovictima tvi on ciu.seqTipoVictima = tvi.seqTipoVictima
            LEFT  JOIN t_frm_grupo_lgtbi glg on ciu.seqGrupoLgtbi = glg.seqGrupoLgtbi
            WHERE frm.seqCorte = $seqCorte
            AND frm.seqFormulario IN ( " . implode("," , array_keys( $arrFormularios ) ) . " )
        ";
        $arrHogares = $aptBd->GetAll($sql);
        return $arrHogares;
    }

    private function fuentesXML(){

        $xmlEstilos = "<Styles>";

        $xmlEstilos .= "
            <Style ss:ID='Default' ss:Name='Normal'>
                <Alignment/>
                <Borders/>
                <Font ss:FontName='Calibri' ss:Size='8'/>
                <Interior/>
                <NumberFormat/>
                <Protection/>
            </Style>
        ";
        $xmlEstilos .= "
            <Style ss:ID='s1'>
                <Alignment ss:Vertical='Center' ss:Horizontal='Center'/>
                <Font ss:FontName='Calibri' ss:Size='8' ss:Bold='1'/>
                <Interior ss:Color='#D8D8D8' ss:Pattern='Solid'/>
            </Style>
        ";
        $xmlEstilos .= "
            <Style ss:ID='s2'>
                <Alignment ss:Vertical='Center' ss:Horizontal='Right'/>
                <Font ss:FontName='Calibri' ss:Size='8' ss:Bold='1'/>
                <Interior ss:Color='#D8D8D8' ss:Pattern='Solid'/>
            </Style>
        ";
        $xmlEstilos .= "
            <Style ss:ID='s3'>
                <Alignment ss:Vertical='Center' ss:Horizontal='Right'/>
                <Font ss:FontName='Calibri' ss:Size='8' ss:Bold='1'/>
                <Interior ss:Color='#D8D8D8' ss:Pattern='Solid'/>
            </Style>
        ";

        $xmlEstilos .= "
            <Style ss:ID='s4'>
                <Borders>
                    <Border ss:Position='Right' ss:LineStyle='Continuous' ss:Weight='1'/>
                </Borders>
                <Alignment ss:Vertical='Center' ss:Horizontal='Right'/>
                <Font ss:FontName='Calibri' ss:Size='8' ss:Bold='1'/>
                <Interior ss:Color='#F2F2F2' ss:Pattern='Solid'/>
            </Style>
        ";

        $xmlEstilos .= "
            <Style ss:ID='s5'>
                <NumberFormat ss:Format='yyyy-mm-dd'/>
            </Style>
        ";

        $xmlEstilos .= "
            <Style ss:ID='s6'>
                <Alignment ss:Vertical='Center' ss:Horizontal='Left'/>
                <Font ss:FontName='Calibri' ss:Size='8'/>
                <Interior ss:Color='#C5D9F1' ss:Pattern='Solid'/>
            </Style>
        ";

        $xmlEstilos .= "
            <Style ss:ID='s7'>
                <Alignment ss:Vertical='Center' ss:Horizontal='Left'/>
                <Font ss:FontName='Calibri' ss:Size='8'/>
                <Interior ss:Color='#F2DDDC' ss:Pattern='Solid'/>
            </Style>
        ";

        $xmlEstilos .= "
            <Style ss:ID='s8'>
                <Alignment ss:Vertical='Center' ss:Horizontal='Left'/>
                <Font ss:FontName='Calibri' ss:Size='8'/>
                <Interior ss:Color='#EAF1DD' ss:Pattern='Solid'/>
            </Style>
        ";

        $xmlEstilos .= "
            <Style ss:ID='s9'>
                <Alignment ss:Vertical='Center' ss:Horizontal='Left'/>
                <Font ss:FontName='Calibri' ss:Size='8'/>
                <Interior ss:Color='#E5E0EC' ss:Pattern='Solid'/>
            </Style>
        ";

        $xmlEstilos .= "
            <Style ss:ID='s10'>
                <Alignment ss:Vertical='Center' ss:Horizontal='Left'/>
                <Font ss:FontName='Calibri' ss:Size='8'/>
                <Interior ss:Color='#F2F2F2' ss:Pattern='Solid'/>
            </Style>
        ";

        $xmlEstilos .= "
            <Style ss:ID='s11'>
                <Alignment ss:Vertical='Center' ss:Horizontal='Left'/>
                <Font ss:FontName='Calibri' ss:Size='8'/>
                <Interior ss:Color='#FDE9D9' ss:Pattern='Solid'/>
            </Style>
        ";

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

        // Para los colores de las columnas, de sobreescriben las celdas?
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
            $xmlArchivo .= "<ss:Row>\r\n";
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
                $xmlArchivo .= "<ss:Cell $txtEstilo><ss:Data ss:Type='$txtTipo'>$txtValor</ss:Data></ss:Cell>\r\n";
            }
            $xmlArchivo .= "</ss:Row>\r\n";
        }

        $xmlArchivo .= "</ss:Table>";
        $xmlArchivo .= "</ss:Worksheet>";

        return $xmlArchivo;
    }

    private function exportarResultadosXML( $xmlArchivo , $txtNombreArchivo )
    {
        $txtNombre = mb_ereg_replace("[^0-9a-zA-Z]","", $txtNombreArchivo) . date("YmdHis") . ".xls";
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-Disposition: inline; filename=\"" . $txtNombre . "\"");
        echo $xmlArchivo;
    }

    public function imprimirReporteProyectos($arrReporte)
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

        $this->exportarResultadosXML( $xmlArchivo , "Informe Proyectos" );


    }

    public function imprimirReporteNoProyectos($arrReporte)
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

        $xmlArchivo .= $this->obtenerXMLHojaPlana( $arrReporte['reporte'] , "Asignados");

        /***********************************************
         * HOJA REPORTE DE HOGARES
         ***********************************************/

        $xmlArchivo .= $this->obtenerXMLHojaPlana( $arrReporte['hogares'] , "Hogares" );

        $xmlArchivo .= $this->obtenerXMLPie();

        $this->exportarResultadosXML( $xmlArchivo , "Informe No Proyectos" );

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