<?php

$txtPrefijoRuta = "../../../";
$txtTipoGiro = "giroFiducia";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( $txtPrefijoRuta . "librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );
include ( $txtPrefijoRuta . "contenidos/migracionesIndividual/legalizacionVipa/configuracion.php" );

// *************************** GIROS DEL ULTIMO AAD ***************************************************************** //

$sql = "
    select
        frm.seqformulario as 'Formulario',
        est.txtEstado as 'Estado',
        frm.valAspiraSubsidio as 'Valor subsidio',
        tdo.txtTipoDocumento as 'Tipo de documento',
        ciu.numDocumento as 'Documento',
        upper(concat(ciu.txtNombre1,' ',ciu.txtNombre2,' ',ciu.txtApellido1,' ',ciu.txtApellido2)) as 'Nombre',
        if(fid.valFiducia is null,0,fid.valFiducia) as 'Giros a fiducia',
        if(con.valConstructor is null,0,con.valConstructor) as 'Giros a constructor'
    from t_frm_formulario frm
    inner join t_frm_hogar hog on frm.seqFormulario = hog.seqFormulario and hog.seqParentesco = 1
    inner join t_ciu_ciudadano ciu on hog.seqCiudadano = ciu.seqCiudadano
    inner join t_ciu_tipo_documento tdo on ciu.seqTipoDocumento = tdo.seqTipoDocumento
    inner join v_frm_estado est on frm.seqEstadoProceso = est.seqEstadoProceso
    left join (
      select 
        frm.seqFormulario,  
        sum(sol.valSolicitado) as valFiducia
      from t_frm_formulario frm
      inner join (
        select 
        seqFormulario,
        max(seqDesembolso) as seqDesembolso
        from t_des_desembolso
        group by seqFormulario
      ) des on frm.seqFormulario = des.seqFormulario
      inner join t_des_solicitud sol on des.seqDesembolso = sol.seqDesembolso
      where frm.seqPlanGobierno in (" . implode("," , $arrVariables[$txtTipoGiro]['planGobierno']) . ")
        and frm.seqModalidad in (" . implode("," , $arrVariables[$txtTipoGiro]['modalidad']) . ")
        and frm.seqTipoEsquema in (" . implode("," , $arrVariables[$txtTipoGiro]['esquema']) . ")
        and sol.numOrden is not null
        and sol.numOrden <> 0
      group by  
        frm.seqFormulario,
        frm.valAspiraSubsidio
    ) fid on frm.seqFormulario = fid.seqFormulario
    left join (
      select 
        frm.seqFormulario,  
        sum(sol.valOrden) as valConstructor
      from t_frm_formulario frm
      inner join (
        select 
        seqFormulario,
        max(seqDesembolso) as seqDesembolso
        from t_des_desembolso
        group by seqFormulario
      ) des on frm.seqFormulario = des.seqFormulario
      inner join t_des_solicitud sol on des.seqDesembolso = sol.seqDesembolso
      where frm.seqPlanGobierno in (" . implode("," , $arrVariables[$txtTipoGiro]['planGobierno']) . ")
        and frm.seqModalidad in (" . implode("," , $arrVariables[$txtTipoGiro]['modalidad']) . ")
        and frm.seqTipoEsquema in (" . implode("," , $arrVariables[$txtTipoGiro]['esquema']) . ")
        and (sol.numOrden is null or sol.numOrden = 0)  
      group by  
        frm.seqFormulario,
        frm.valAspiraSubsidio
    ) con on frm.seqFormulario = con.seqFormulario
    where frm.seqPlanGobierno in (" . implode("," , $arrVariables[$txtTipoGiro]['planGobierno']) . ")
        and frm.seqModalidad in (" . implode("," , $arrVariables[$txtTipoGiro]['modalidad']) . ")
        and frm.seqTipoEsquema in (" . implode("," , $arrVariables[$txtTipoGiro]['esquema']) . ")
";

$arrPlantilla = $aptBd->GetAll($sql);
$arrTitulos = array_keys($arrPlantilla[0]);

// *************************** HISTORICO DE GIROS ******************************************************************* //

$sql = "
            select 
                fac.seqFormulario, 
                fac.seqFormularioActo,
                tdo.txtTipoDocumento,    
                cac.numDocumento,
                upper(concat(cac.txtNombre1,' ',cac.txtNombre2,' ',cac.txtApellido1,' ',cac.txtApellido2)) as txtNombre,
                est.txtEstado,
                hvi.numActo, 
                hvi.fchActo,
                fac.valAspiraSubsidio,
                if(gir.valSolicitado is null, 0, gir.valSolicitado) as valSolicitado,
                if(concat(gir.numRegistroPresupuestal1, ' de ', year(gir.fchRegistroPresupuestal1)) is null, 'No aplica',concat(gir.numRegistroPresupuestal1, ' de ', year(gir.fchRegistroPresupuestal1)))  as rp1,
                if(concat(gir.numRegistroPresupuestal2, ' de ', year(gir.numRegistroPresupuestal2)) is null, 'No aplica',concat(gir.numRegistroPresupuestal2, ' de ', year(gir.numRegistroPresupuestal2)))  as rp2
            from t_aad_formulario_acto fac
            inner join t_aad_hogar_acto hac on fac.seqFormularioActo = hac.seqFormularioActo and hac.seqParentesco = 1
            inner join t_aad_ciudadano_acto cac on hac.seqCiudadanoActo = cac.seqCiudadanoActo
            inner join t_ciu_tipo_documento tdo on cac.seqTipoDocumento = tdo.seqTipoDocumento
            inner join t_aad_hogares_vinculados hvi on fac.seqFormularioActo = hvi.seqFormularioActo
            inner join v_frm_estado est on fac.seqEstadoProceso = est.seqEstadoProceso
            left join t_aad_giro gir on fac.seqFormularioActo = gir.seqFormularioActo
            where fac.seqPlanGobierno in (" . implode("," , $arrVariables[$txtTipoGiro]['planGobierno']) . ")
            and fac.seqModalidad in (" . implode("," , $arrVariables[$txtTipoGiro]['modalidad']) . ")
            and fac.seqTipoEsquema in (" . implode("," , $arrVariables[$txtTipoGiro]['esquema']) . ")
            and hvi.seqTipoActo = 1    
            
            
             
            order by 
                fac.seqFormulario, 
                fac.seqFormularioActo   
        ";
$objRes = $aptBd->execute($sql);
$arrDatos = array();
while($objRes->fields){

    $seqFormulario = $objRes->fields['seqFormulario'];
    $fchResolucion = date("Y", strtotime($objRes->fields['fchActo']));
    $txtResolucion = "Res. " . $objRes->fields['numActo'] . " de " . $fchResolucion;

    $arrDatos[$seqFormulario]['hogar']['tipo'] = $objRes->fields['txtTipoDocumento'];
    $arrDatos[$seqFormulario]['hogar']['documento'] = $objRes->fields['numDocumento'];
    $arrDatos[$seqFormulario]['hogar']['nombre'] = $objRes->fields['txtNombre'];
    $arrDatos[$seqFormulario]['hogar']['subsidio'] = $objRes->fields['valAspiraSubsidio'];
    $arrDatos[$seqFormulario]['hogar'][$txtResolucion]['fac'] = $objRes->fields['seqFormularioActo'];
    $arrDatos[$seqFormulario]['hogar'][$txtResolucion]['rp1'] = $objRes->fields['rp1'];
    $arrDatos[$seqFormulario]['hogar'][$txtResolucion]['rp2'] = $objRes->fields['rp2'];
    $arrDatos[$seqFormulario]['hogar'][$txtResolucion]['estado'] = $objRes->fields['txtEstado'];
    $arrDatos[$seqFormulario]['detalle'][$txtResolucion] += $objRes->fields['valSolicitado'];
    $arrDatos[$seqFormulario]['acumulado'] += $objRes->fields['valSolicitado'];

    $objRes->MoveNext();
}

$arrReporte = array();
foreach($arrDatos as $seqFormulario => $arrInformacion){
    foreach($arrInformacion['detalle'] as $txtResolucion => $valGiro){

        $numPosicion = count($arrReporte);

        $arrReporte[$numPosicion]['Formulario'] = $seqFormulario;
        $arrReporte[$numPosicion]['Formulario Acto'] = $arrInformacion['hogar'][$txtResolucion]['fac'];
        $arrReporte[$numPosicion]['Tipo de documento'] = $arrInformacion['hogar']['tipo'];
        $arrReporte[$numPosicion]['Documento'] = $arrInformacion['hogar']['documento'];
        $arrReporte[$numPosicion]['Nombre'] = $arrInformacion['hogar']['nombre'];
        $arrReporte[$numPosicion]['Estado'] = $arrInformacion['hogar'][$txtResolucion]['estado'];
        $arrReporte[$numPosicion]['Resolucion'] = $txtResolucion;
        $arrReporte[$numPosicion]['Registro Presupuestal 1'] = $arrInformacion['hogar'][$txtResolucion]['rp1'];
        $arrReporte[$numPosicion]['Registro Presupuestal 2'] = $arrInformacion['hogar'][$txtResolucion]['rp2'];
        $arrReporte[$numPosicion]['Valor Subsidio'] = $arrInformacion['hogar']['subsidio'];
        $arrReporte[$numPosicion]['Valor Giro'] = $valGiro;
        $arrReporte[$numPosicion]['Valor Acumulado'] = $arrInformacion['acumulado'];

    }
}
$arrTitulos2 = array_keys($arrReporte[0]);

// *************************** CREA ARCHIVO DE EXCEL CON LOS DATOS ************************************************** //

$numColumnas = count($arrTitulos);
$numFilas = count($arrPlantilla);

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getProperties()->setCreator("SiPIVE - SDHT");
$objHoja = $objPHPExcel->getActiveSheet();
$objHoja->setTitle('Estado de Giros');

// titulos
for ($i = 0; $i < count($arrTitulos); $i++) {
    $objHoja->setCellValueByColumnAndRow($i, 1, $arrTitulos[$i], false);
}

// contenido
foreach($arrPlantilla as $numLinea => $arrLinea){
    $numColumna = 0;
    foreach($arrLinea as $txtTitulo => $txtValor){
        $objHoja->setCellValueByColumnAndRow($numColumna, ($numLinea + 2), $txtValor, false);
        $numColumna++;
    }
}

$numColumnas2 = count($arrTitulos2);
$numFilas2 = count($arrReporte);

$objHoja2 = $objPHPExcel->createSheet(1);
$objHoja2->setTitle('Historico Giros');

// titulos
for ($i = 0; $i < count($arrTitulos2); $i++) {
    $objHoja2->setCellValueByColumnAndRow($i, 1, $arrTitulos2[$i], false);
}

// contenido
foreach($arrReporte as $numLinea => $arrLinea){
    $numColumna = 0;
    foreach($arrLinea as $txtTitulo => $txtValor){
        $objHoja2->setCellValueByColumnAndRow($numColumna, ($numLinea + 2), $txtValor, false);
        $numColumna++;
    }
}

// *************************** ESTILOS POR DEFECTO DEL ARCHIVO DE EXCEL ********************************************* //

// fuentes para el archivo
$arrFuentes['default']['font']['name'] = "Calibri";
$arrFuentes['default']['font']['size'] = 8;

$arrFuentes['titulo']['fill']['type'] = PHPExcel_Style_Fill::FILL_SOLID;
$arrFuentes['titulo']['fill']['color'] = array('rgb' => 'E4E4E4');
$arrFuentes['titulo']['font']['bold'] = true;
$arrFuentes['titulo']['font']['color'] = array('rgb' => '000000');


// da formato a todas las columnas del libro
$objHoja->getStyle(PHPExcel_Cell::stringFromColumnIndex(0) . "1:" . PHPExcel_Cell::stringFromColumnIndex($numColumnas) . ($numFilas + 1))->applyFromArray($arrFuentes['default']);
$objHoja2->getStyle(PHPExcel_Cell::stringFromColumnIndex(0) . "1:" . PHPExcel_Cell::stringFromColumnIndex($numColumnas2) . ($numFilas2 + 1))->applyFromArray($arrFuentes['default']);

// da formato al titulo
$objHoja->getStyle(PHPExcel_Cell::stringFromColumnIndex(0) . "1:" . PHPExcel_Cell::stringFromColumnIndex($numColumnas - 1) . "1")->applyFromArray($arrFuentes['titulo']);
$objHoja2->getStyle(PHPExcel_Cell::stringFromColumnIndex(0) . "1:" . PHPExcel_Cell::stringFromColumnIndex($numColumnas2 - 1) . "1")->applyFromArray($arrFuentes['titulo']);

for ($i = 0; $i < $numColumnas; $i++) {
    $objHoja->getColumnDimensionByColumn($i)->setAutoSize(true);
    for ($j = 1; $j < ($numFilas + 2); $j++) {
        $objHoja->getRowDimension($j)->setRowHeight(12);
        if(strpos($arrTitulos[$i],"Fecha") !== false) {
            $objHoja->getStyleByColumnAndRow($i, $j)
                ->getNumberFormat()
                ->setFormatCode(
                    PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2
                );
        }elseif(strpos($arrTitulos[$i],"Número") !== false){
            $objHoja->getStyleByColumnAndRow($i, $j)
                ->getNumberFormat()
                ->setFormatCode(
                    PHPExcel_Style_NumberFormat::FORMAT_NUMBER
                );
        }elseif(strpos($arrTitulos[$i],"Valor") !== false){
            $objHoja->getStyleByColumnAndRow($i, $j)
                ->getNumberFormat()
                ->setFormatCode(
                    PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
                );
        }elseif(strpos($arrTitulos[$i],"Giro") !== false){
            $objHoja->getStyleByColumnAndRow($i, $j)
                ->getNumberFormat()
                ->setFormatCode(
                    PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
                );
        }
    }
}

for ($i = 0; $i < $numColumnas2; $i++) {
    $objHoja2->getColumnDimensionByColumn($i)->setAutoSize(true);
    for ($j = 1; $j < ($numFilas + 2); $j++) {
        $objHoja2->getRowDimension($j)->setRowHeight(12);
        if(strpos($arrTitulos2[$i],"Fecha") !== false) {
            $objHoja2->getStyleByColumnAndRow($i, $j)
                ->getNumberFormat()
                ->setFormatCode(
                    PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2
                );
        }elseif(strpos($arrTitulos2[$i],"Número") !== false){
            $objHoja2->getStyleByColumnAndRow($i, $j)
                ->getNumberFormat()
                ->setFormatCode(
                    PHPExcel_Style_NumberFormat::FORMAT_NUMBER
                );
        }elseif(strpos($arrTitulos2[$i],"Valor") !== false){
            $objHoja2->getStyleByColumnAndRow($i, $j)
                ->getNumberFormat()
                ->setFormatCode(
                    PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
                );
        }elseif(strpos($arrTitulos2[$i],"Giro") !== false){
            $objHoja2->getStyleByColumnAndRow($i, $j)
                ->getNumberFormat()
                ->setFormatCode(
                    PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
                );
        }
    }
}

// *************************** EXPORTA LOS RESULTADOS *************************************************************** //

$objPHPExcel->setActiveSheetIndex(0);

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename='EstadoGirosVIPA_" . date("YmdHis") . ".xlsx");
header('Cache-Control: max-age=0');
ob_end_clean();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>