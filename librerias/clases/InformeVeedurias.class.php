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
        $this->arrEstadosVinculado = array( 15, 62, 17, 19, 22, 23, 24, 25, 26, 27, 28, 29, 31 , 40 );
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
                pry.txtNombreProyecto, 
                upr.txtNombreUnidad,
                upr.fchLegalizado,
                uac.numActo as numActoProyecto, 
                uac.fchActo as fchActoProyecto, 
                uac.seqTipoActoUnidad,
                tac.txtTipoActoUnidad,
                uvi.valIndexado,
                frm.seqFormulario,
                frm.seqEstadoProceso,
                frm.bolCerrado,
                aad.numActo as numActoHogar, 
                aad.fchActo as fchActoHogar
            from t_vee_proyecto pry
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
            where pry.seqCorte = $seqCorte
            and pry.bolActivo = 1
            and upr.bolActivo = 1   
            and uac.seqTipoActoUnidad <> 2
            order by pry.txtNombreProyecto
        ";
        $objRes = $aptBd->execute($sql);
        $arrReporte = array();
        $numAnioMinimoGenerado = 0;
        $numAnioMaximoGenerado = 0;
        $numAnioMinimoVinculado = 0;
        $numAnioMaximoVinculado = 0;
        $numAnioMinimoLegalizado = 0;
        $numAnioMaximoLegalizado = 0;
        while ($objRes->fields) {

            $txtProyecto = $objRes->fields['txtNombreProyecto'];
            $txtUnidad = $objRes->fields['txtNombreUnidad'];
            $numActoProyecto = $objRes->fields['numActoProyecto'];
            $fchActoProyecto = $objRes->fields['fchActoProyecto'];
            $seqTipoActo = $objRes->fields['seqTipoActoUnidad'];
            $txtTipoActo = $objRes->fields['txtTipoActoUnidad'];
            $valIndexado = $objRes->fields['valIndexado'];
            $fchActoHogar = $objRes->fields['fchActoHogar'];
            $fchLegalizado = $objRes->fields['fchLegalizado'];
            $bolCerrado = $objRes->fields['bolCerrado'];
            $seqEstadoProceso = $objRes->fields['seqEstadoProceso'];

            $txtNombreResolucion = $numActoProyecto . " de " . date("Y", strtotime($fchActoProyecto));

            $numAnioResolucionProyecto = date("Y", strtotime($fchActoProyecto));
            $numAnioMinimoGenerado = (($numAnioMinimoGenerado == 0) or ($numAnioMinimoGenerado >= $numAnioResolucionProyecto)) ? $numAnioResolucionProyecto : $numAnioMinimoGenerado;
            $numAnioMaximoGenerado = (($numAnioMaximoGenerado == 0) or ($numAnioMaximoGenerado <= $numAnioResolucionProyecto)) ? $numAnioResolucionProyecto : $numAnioMaximoGenerado;

            $arrReporte['reporte']['generados']['minimo'] = $numAnioMinimoGenerado;
            $arrReporte['reporte']['generados']['maximo'] = $numAnioMaximoGenerado;

            if ($seqTipoActo == 1) {
                $arrReporte['reporte']['generados']['datos'][$txtProyecto][$txtNombreResolucion][$numAnioResolucionProyecto]++;
                $arrReporte['reporte']['generados']['datos'][$txtProyecto][$txtNombreResolucion]['total']++;
            }elseif( $seqTipoActo == 3 ){
                if( $valIndexado > 0 ){
                    $arrReporte['reporte']['generados']['datos'][$txtProyecto][$txtNombreResolucion][$numAnioResolucionProyecto]++;
                    $arrReporte['reporte']['generados']['datos'][$txtProyecto][$txtNombreResolucion]['total']++;
                }else{
                    $arrReporte['reporte']['generados']['datos'][$txtProyecto][$txtNombreResolucion][$numAnioResolucionProyecto]--;
                    $arrReporte['reporte']['generados']['datos'][$txtProyecto][$txtNombreResolucion]['total']--;
                }
            }

            if( $bolCerrado == 1 and in_array( $seqEstadoProceso , $this->arrEstadosVinculado ) ) {

                $numAnioResolucionHogar = date("Y", strtotime($fchActoHogar));
                $numAnioMinimoVinculado = (($numAnioMinimoVinculado == 0) or ($numAnioMinimoVinculado >= $numAnioResolucionHogar)) ? $numAnioResolucionHogar : $numAnioMinimoVinculado;
                $numAnioMaximoVinculado = (($numAnioMaximoVinculado == 0) or ($numAnioMaximoVinculado <= $numAnioResolucionHogar)) ? $numAnioResolucionHogar : $numAnioMaximoVinculado;

                $arrReporte['reporte']['vinculados']['minimo'] = $numAnioMinimoVinculado;
                $arrReporte['reporte']['vinculados']['maximo'] = $numAnioMaximoVinculado;
                $arrReporte['reporte']['vinculados']['datos'][$txtProyecto][$txtNombreResolucion][$numAnioResolucionHogar]++;
                $arrReporte['reporte']['vinculados']['datos'][$txtProyecto][$txtNombreResolucion]['total']++;

            }

            if( $bolCerrado == 1 and in_array( $seqEstadoProceso , $this->arrEstadosLegalizado ) ){

                $numAnioLegalizado = date("Y", strtotime($fchLegalizado));
                $numAnioMinimoLegalizado = (($numAnioMinimoLegalizado == 0) or ($numAnioMinimoLegalizado >= $numAnioLegalizado)) ? $numAnioLegalizado : $numAnioMinimoLegalizado;
                $numAnioMaximoLegalizado = (($numAnioMaximoLegalizado == 0) or ($numAnioMaximoLegalizado <= $numAnioLegalizado)) ? $numAnioLegalizado : $numAnioMaximoLegalizado;

                $arrReporte['reporte']['legalizados']['minimo'] = $numAnioMinimoLegalizado;
                $arrReporte['reporte']['legalizados']['maximo'] = $numAnioMaximoLegalizado;
                $arrReporte['reporte']['legalizados']['datos'][$txtProyecto][$txtNombreResolucion][$numAnioLegalizado]++;
                $arrReporte['reporte']['legalizados']['datos'][$txtProyecto][$txtNombreResolucion]['total']++;

            }


            $objRes->MoveNext();
        }

        return $arrReporte;
    }

    private function fuentesXML(){

        $xmlEstilos = "<Styles>";

        $xmlEstilos .= "<Style ss:ID='titulo'>";
        $xmlEstilos .= "<Alignment ss:Horizontal='Center' ss:Vertical='Center'/>";
        $xmlEstilos .= "<Interior ss:Color='#000000' ss:Pattern='Solid'/>";
        $xmlEstilos .= "<Font x:Family='Swiss' ss:Bold='1'/>";
        $xmlEstilos .= "</Style>";

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

        $xmlEstilos .= "</Styles>";

        return $xmlEstilos;

    }


    public function imprimirReporteProyectos($arrReporte)
    {

        $numAcrossGenerados   = ($arrReporte['reporte']['generados']['maximo']   - $arrReporte['reporte']['generados']['minimo']  ) + 1;
        $numAcrossVinculados  = ($arrReporte['reporte']['vinculados']['maximo']  - $arrReporte['reporte']['vinculados']['minimo'] ) + 1;
        $numAcrossLegalizados = ($arrReporte['reporte']['legalizados']['maximo'] - $arrReporte['reporte']['legalizados']['minimo']) + 1;

        /***********************************************
         * ENCABEZADO
         ***********************************************/

        $xmlArchivo  = "<?xml version='1.0'?> ";
        $xmlArchivo .= "<?mso-application progid='Excel.Sheet'?> ";
        $xmlArchivo .= "<Workbook xmlns='urn:schemas-microsoft-com:office:spreadsheet' ";
        $xmlArchivo .= "xmlns:o='urn:schemas-microsoft-com:office:office' ";
        $xmlArchivo .= "xmlns:x='urn:schemas-microsoft-com:office:excel' ";
        $xmlArchivo .= "xmlns:ss='urn:schemas-microsoft-com:office:spreadsheet' ";
        $xmlArchivo .= "xmlns:html='http://www.w3.org/TR/REC-html40'>";

        /***********************************************
         * ESTILOS DE FUENTES
         ***********************************************/

        $xmlArchivo .= $this->fuentesXML();

        /***********************************************
         * HOJA REPORTE DE PROYECTOS
         ***********************************************/

        $xmlArchivo .= "<ss:Worksheet ss:Name='Reporte Proyectos'>";
        $xmlArchivo .= "<ss:Table>";
        $xmlArchivo .= "<Column ss:AutoFitWidth='0' ss:Width='180'/>";

        /***********************************************
         * TITULOS DE LA HOJA DE PROYECTOS
         ***********************************************/

        $xmlArchivo .= "<ss:Row>";
        $xmlArchivo .= "<ss:Cell ss:StyleID='s1' ss:MergeDown='1'><ss:Data ss:Type='String'>Proyecto</ss:Data></ss:Cell>";
        $xmlArchivo .= "<ss:Cell ss:StyleID='s1' ss:MergeDown='1'><ss:Data ss:Type='String'>Resoluciones</ss:Data></ss:Cell>";
        $xmlArchivo .= "<ss:Cell ss:StyleID='s1' ss:MergeAcross='$numAcrossGenerados'><ss:Data ss:Type='String'>Subsidios Generados</ss:Data></ss:Cell>";
        $xmlArchivo .= "<ss:Cell ss:StyleID='s1' ss:MergeAcross='$numAcrossVinculados'><ss:Data ss:Type='String'>Vinculados</ss:Data></ss:Cell>";
        $xmlArchivo .= "<ss:Cell ss:StyleID='s1' ss:MergeAcross='$numAcrossLegalizados'><ss:Data ss:Type='String'>Legalizados</ss:Data></ss:Cell>";
        $xmlArchivo .= "</ss:Row>";

        // titulos - anios para generados
        $xmlArchivo .= "<ss:Row>";
        for( $numAnio = $arrReporte['reporte']['generados']['minimo'] ; $numAnio <= $arrReporte['reporte']['generados']['maximo']; $numAnio++ ){
            if( $numAnio == $arrReporte['reporte']['generados']['minimo'] ){
                $xmlArchivo .= "<ss:Cell ss:StyleID='s2' ss:Index='3'><ss:Data ss:Type='Number'>$numAnio</ss:Data></ss:Cell>";
            }else{
                $xmlArchivo .= "<ss:Cell ss:StyleID='s2'><ss:Data ss:Type='Number'>$numAnio</ss:Data></ss:Cell>";
            }
        }
        $xmlArchivo .= "<ss:Cell ss:StyleID='s3'><ss:Data ss:Type='String'>Total</ss:Data></ss:Cell>";

        // titulos - anios para vinculados
        for( $numAnio = $arrReporte['reporte']['vinculados']['minimo'] ; $numAnio <= $arrReporte['reporte']['vinculados']['maximo']; $numAnio++ ){
            $xmlArchivo .= "<ss:Cell ss:StyleID='s2'><ss:Data ss:Type='Number'>$numAnio</ss:Data></ss:Cell>";
        }
        $xmlArchivo .= "<ss:Cell ss:StyleID='s3'><ss:Data ss:Type='String'>Total</ss:Data></ss:Cell>";

        // titulos - anios para legalizados
        for( $numAnio = $arrReporte['reporte']['legalizados']['minimo'] ; $numAnio <= $arrReporte['reporte']['legalizados']['maximo']; $numAnio++ ){
            $xmlArchivo .= "<ss:Cell ss:StyleID='s2'><ss:Data ss:Type='Number'>$numAnio</ss:Data></ss:Cell>";
        }
        $xmlArchivo .= "<ss:Cell ss:StyleID='s3'><ss:Data ss:Type='String'>Total</ss:Data></ss:Cell>";

        $xmlArchivo .= "</ss:Row>";


        /**********************************************
         * DATOS DE LA HOJA DE PROYECTOS
         **********************************************/

        foreach( $arrReporte['reporte']['generados']['datos'] as $txtProyecto => $arrResoluciones ){
            foreach( $arrResoluciones as $txtNombreResolucion => $arrAnios ){
                $xmlArchivo .= "<ss:Row>";

                // GENERADOS
                $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>$txtProyecto</ss:Data></ss:Cell>";
                $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>$txtNombreResolucion</ss:Data></ss:Cell>";
                for ($numAnio = $arrReporte['reporte']['generados']['minimo']; $numAnio <= $arrReporte['reporte']['generados']['maximo']; $numAnio++) {
                    if ( isset( $arrAnios[ $numAnio ] ) ) {
                        $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>" . $arrAnios[ $numAnio ] . "</ss:Data></ss:Cell>";
                    } else {
                        $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>0</ss:Data></ss:Cell>";
                    }
                }
                $xmlArchivo .= "<ss:Cell ss:StyleID='s4'><ss:Data ss:Type='Number'>" . $arrAnios['total'] . "</ss:Data></ss:Cell>";

                // VINCULADOS
                if( isset( $arrReporte['reporte']['vinculados']['datos'][ $txtProyecto ][ $txtNombreResolucion ] ) ){
                    for ($numAnio = $arrReporte['reporte']['vinculados']['minimo']; $numAnio <= $arrReporte['reporte']['vinculados']['maximo']; $numAnio++) {
                        if ( isset( $arrReporte['reporte']['vinculados']['datos'][ $txtProyecto ][ $txtNombreResolucion ][ $numAnio ] ) ) {
                            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>" . $arrReporte['reporte']['vinculados']['datos'][ $txtProyecto ][ $txtNombreResolucion ][ $numAnio ] . "</ss:Data></ss:Cell>";
                        } else {
                            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>0</ss:Data></ss:Cell>";
                        }
                    }
                }else{
                    for ($numAnio = $arrReporte['reporte']['vinculados']['minimo']; $numAnio <= $arrReporte['reporte']['vinculados']['maximo']; $numAnio++) {
                        $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>0</ss:Data></ss:Cell>";
                    }
                }
                $xmlArchivo .= "<ss:Cell ss:StyleID='s4'><ss:Data ss:Type='Number'>" . $arrReporte['reporte']['vinculados']['datos'][ $txtProyecto ][ $txtNombreResolucion ]['total'] . "</ss:Data></ss:Cell>";

                // LEGALIZADOS
                if( isset( $arrReporte['reporte']['legalizados']['datos'][ $txtProyecto ][ $txtNombreResolucion ] ) ){
                    for ($numAnio = $arrReporte['reporte']['legalizados']['minimo']; $numAnio <= $arrReporte['reporte']['legalizados']['maximo']; $numAnio++) {
                        if ( isset( $arrReporte['reporte']['legalizados']['datos'][ $txtProyecto ][ $txtNombreResolucion ][ $numAnio ] ) ) {
                            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>" . $arrReporte['reporte']['legalizados']['datos'][ $txtProyecto ][ $txtNombreResolucion ][ $numAnio ] . "</ss:Data></ss:Cell>";
                        } else {
                            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>0</ss:Data></ss:Cell>";
                        }
                    }
                }else{
                    for ($numAnio = $arrReporte['reporte']['legalizados']['minimo']; $numAnio <= $arrReporte['reporte']['legalizados']['maximo']; $numAnio++) {
                        $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>0</ss:Data></ss:Cell>";
                    }
                }
                $xmlArchivo .= "<ss:Cell ss:StyleID='s4'><ss:Data ss:Type='Number'>" . $arrReporte['reporte']['legalizados']['datos'][ $txtProyecto ][ $txtNombreResolucion ]['total'] . "</ss:Data></ss:Cell>";

                $xmlArchivo .= "</ss:Row>";
            }
        }

        $xmlArchivo .= "</ss:Table>";
        $xmlArchivo .= "</ss:Worksheet>";
        $xmlArchivo .= "</ss:Workbook>";

        $txtNombre = "InformeProyectos" . date("YmdHis") . ".xls";
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-Disposition: inline; filename=\"" . $txtNombre . "\"");

        echo $xmlArchivo;

    }



}