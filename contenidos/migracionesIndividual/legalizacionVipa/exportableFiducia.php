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

$sql = "
    select
        frm.seqformulario as 'Formulario',
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

// da formato al titulo
$objHoja->getStyle(PHPExcel_Cell::stringFromColumnIndex(0) . "1:" . PHPExcel_Cell::stringFromColumnIndex($numColumnas - 1) . "1")->applyFromArray($arrFuentes['titulo']);

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
        }
    }
}

// *************************** EXPORTA LOS RESULTADOS *************************************************************** //

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename='EstadoGirosVIPA_" . date("YmdHis") . ".xlsx");
header('Cache-Control: max-age=0');
ob_end_clean();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>