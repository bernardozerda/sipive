<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "aadProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );

// *************************** OBTIENE LOS DATOS ******************************************************************** //

$claActo = new aadProyectos();
$arrFormato = $claActo->plantilla($_GET['seqTipoActoUnidad']);

// contenido de la plantilla (cuando aplica)
$arrContenido = array();
switch ($_GET['seqTipoActoUnidad']) {
    case 1: // aprobación
        // las unidades que no tienen actos administrativos
        // UNION
        // las unidades que en la suma de actos administrativos es cero
        $sql = "
            (  
                select
                    pry.txtNombreProyecto,
                    upr.txtNombreUnidad,
                    upr.valSDVEActual,
                    upr.valSDVEComplementario,
                    '' as seqRegistroPresupuestal,
                    pgo.txtPlanGobierno,
                    moa.txtModalidad,
                    tes.txtTipoEsquema
                from t_pry_unidad_proyecto upr 
                left join t_pry_aad_unidades_vinculadas uvi on uvi.seqUnidadProyecto = upr.seqUnidadProyecto
                inner join t_pry_proyecto pry on upr.seqProyecto = pry.seqProyecto
                inner join t_frm_plan_gobierno pgo on upr.seqPlanGobierno = pgo.seqPlanGobierno
                inner join t_frm_modalidad moa on upr.seqModalidad = moa.seqModalidad
                inner join t_pry_tipo_esquema tes on upr.seqTipoEsquema = tes.seqTipoEsquema
                where uvi.seqUnidadProyecto is null
                  and upr.seqUnidadProyecto <> 1  
            )
            UNION
            (
                select
                    pry.txtNombreProyecto,
                    upr.txtNombreUnidad,
                    upr.valSDVEActual,
                    upr.valSDVEComplementario,
                    '' as seqRegistroPresupuestal,
                    pgo.txtPlanGobierno,
                    moa.txtModalidad,
                    tes.txtTipoEsquema
                from t_pry_unidad_proyecto upr 
                inner join (
                    select 
                        seqUnidadProyecto,
                        sum(valIndexado) as valIndexado
                    from t_pry_aad_unidades_vinculadas
                    where seqUnidadProyecto is not null
                    group by seqUnidadProyecto
                    having valIndexado = 0
                ) uvi on upr.seqUnidadProyecto = uvi.seqUnidadProyecto
                inner join t_pry_proyecto pry on upr.seqProyecto = pry.seqProyecto
                left join t_pry_proyecto pry1 on pry.seqProyectoPadre = pry1.seqProyecto
                inner join t_frm_plan_gobierno pgo on upr.seqPlanGobierno = pgo.seqPlanGobierno
                inner join t_frm_modalidad moa on upr.seqModalidad = moa.seqModalidad
                inner join t_pry_tipo_esquema tes on upr.seqTipoEsquema = tes.seqTipoEsquema
                where upr.seqUnidadProyecto <> 1 
            )
            UNION 
            (
                select 
                    pry.txtNombreProyecto,
                    '' as txtNombreUnidad,
                    if(pry.valMaximoSubsidio is null,0,pry.valMaximoSubsidio) as valSDVEActual,
                    '' as valSDVEComplementario,
                    '' as seqRegistroPresupuestal,
                    pgo.txtPlanGobierno,
                    '' as txtModalidad,
                    '' as txtTipoEsquema
                from t_pry_proyecto pry
                inner join t_frm_plan_gobierno pgo on pry.seqPlanGobierno = pgo.seqPlanGobierno
                where seqProyecto not in (
                  select distinct seqProyecto
                  from t_pry_unidad_proyecto
                ) and seqProyecto not in (
                  select seqProyectoPadre
                  from t_pry_proyecto
                  where seqProyectoPadre is not null
                )
            )
            order by
                txtNombreProyecto,
                txtNombreUnidad        
        ";
        $arrContenido = $aptBd->GetAll($sql);
        break;
    case 2: // indexacion
        break;
    case 3: // modificacion

        break;
}

// *************************** CREA ARCHIVO DE EXCEL CON LOS DATOS ************************************************** //

$numColumnas = count($arrFormato) - 1;

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getProperties()->setCreator($claActo->txtCreador);
$objHoja = $objPHPExcel->getActiveSheet();
$objHoja->setTitle($arrFormato[0]['nombreActo']);

// titulos
for ($i = 0; $i < count($arrFormato); $i++) {
    $objHoja->setCellValueByColumnAndRow($i, 1, $arrFormato[$i]['nombre'], false);
}

// contenido
foreach ($arrContenido as $numFila => $arrLinea) {
    $numColumna = 0;
    foreach ($arrLinea as $txtValor) {
        $objHoja->setCellValueByColumnAndRow($numColumna, ($numFila + 2), $txtValor, false);
        $numColumna++;
    }
}

// da formato a todas las columnas del libro
$numFilas = (count($arrContenido) == 0) ? 200 : (count($arrContenido) + 1);

// *************************** ESTILOS POR DEFECTO DEL ARCHIVO DE EXCEL ********************************************* //
// fuentes para el archivo
$arrFuentes['default']['font']['name'] = "Calibri";
$arrFuentes['default']['font']['size'] = 8;
$arrFuentes['default']['font']['bold'] = false;
$arrFuentes['default']['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
$arrFuentes['default']['borders']['allborders']['style'] = PHPExcel_Style_Border::BORDER_NONE;

$arrFuentes['titulo']['fill']['type'] = PHPExcel_Style_Fill::FILL_SOLID;
$arrFuentes['titulo']['fill']['color'] = array('rgb' => 'E4E4E4');
$arrFuentes['titulo']['font']['bold'] = true;
$arrFuentes['titulo']['font']['color'] = array('rgb' => '000000');
$arrFuentes['titulo']['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;

// coloca el tipo de dato de acuerdo con la plantilla
for ($i = 2; $i <= $numFilas; $i++) {
    foreach ($arrFormato as $numColumna => $arrTitulo) {
        switch ($arrTitulo['tipo']) {
            case "numero":
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($numColumna, $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                break;
            case "fecha":
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($numColumna, $i)->getNumberFormat()->setFormatCode("yyyy-mm-dd");
                break;
        }
    }
}

// estilos colores y otras cosas
$objHoja->getStyle(PHPExcel_Cell::stringFromColumnIndex(0) . "1:" . PHPExcel_Cell::stringFromColumnIndex($numColumnas) . $numFilas)->applyFromArray($arrFuentes['default']);
$objHoja->getStyle(PHPExcel_Cell::stringFromColumnIndex(0) . "1:" . PHPExcel_Cell::stringFromColumnIndex($numColumnas) . "1")->applyFromArray($arrFuentes['titulo']);

// ajusta el tamaño de las columans en ancho y alto
for ($i = 0; $i < count($arrFormato); $i++) {
    $objHoja->getColumnDimensionByColumn($i)->setAutoSize(true);
}
$objHoja->getRowDimension(1)->setRowHeight(12);

// *************************** EXPORTA LOS RESULTADOS *************************************************************** //

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename='AAD_" . $arrFormato[0]['nombreActo'] . ".xlsx");
header('Cache-Control: max-age=0');
ob_end_clean();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>