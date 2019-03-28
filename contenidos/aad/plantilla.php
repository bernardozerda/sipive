<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aadTipo.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );

// numero de filas vacias a formatear
$numFilasFormatear = 100;

// obtiene los datos
$claTipoActo = new aadTipo();
$claTipoActo = array_shift($claTipoActo->cargarTipoActo($_GET['seqTipoActo']));

// fuentes para el archivo
$arrFuentes['default']['font']['name'] = "Calibri";
$arrFuentes['default']['font']['size'] = 8;
$arrFuentes['titulo']['fill']['type'] = PHPExcel_Style_Fill::FILL_SOLID;
$arrFuentes['titulo']['fill']['color'] = array('rgb' => 'E4E4E4');
$arrFuentes['titulo']['font']['bold'] = true;
$arrFuentes['titulo']['font']['color'] = array('rgb' => '000000');

// Creacion del libro de excel
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator( $claTipoActo->txtCreador );
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle(mb_substr(mb_ereg_replace("[^0-9A-Za-z\ ]", "", $claTipoActo->txtTipoActo), 0, 30)); // titulo de excel limitado a 30 caracteres
$objPHPExcel->getDefaultStyle()->applyFromArray($arrFuentes['default']);

// Protege la hoja para que no se modifiquen celdas inecesarias
$objPHPExcel->getSecurity()->setLockWindows(false);
$objPHPExcel->getSecurity()->setLockStructure(false);
$objPHPExcel->getSheet(0)->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()->getProtection()->setPassword($arrConfiguracion['baseDatos']['clave']);
$objPHPExcel->getActiveSheet()->getStyle("A2:" . PHPExcel_Cell::stringFromColumnIndex(count($claTipoActo->arrFormatoArchivo) - 1) . $numFilasFormatear)
    ->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

// coloca los titulos
foreach ($claTipoActo->arrFormatoArchivo as $numColumna => $arrTitulo) {

    // coloca el texto del titulo
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($numColumna, 1, $arrTitulo['nombre'], flase);

    // coloca la ayuda (si existe)
    if (isset($arrTitulo['ayuda'])) {
        $claFuente = new PHPExcel_Style_Font();
        $claFuente->setSize(8);
        $objPHPExcel->getActiveSheet()->getCommentByColumnAndRow($numColumna, 1)->getText()->createTextRun($arrTitulo['ayuda'])->setFont($claFuente);
        $objPHPExcel->getActiveSheet()->getCommentByColumnAndRow($numColumna, 1)->setHeight('80pt');
        $objPHPExcel->getActiveSheet()->getCommentByColumnAndRow($numColumna, 1)->setWidth('120pt');
    }

    // estilos
    $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($numColumna)->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($numColumna, 1)->applyFromArray($arrFuentes['titulo']);
}

// da formato a las celdas de acuerdo con el formato de los titulos
// si la celda tiene un rango de valores coloca una lista desplegable
// para limitar los valores
for ($i = 2; $i <= $numFilasFormatear; $i++) {
    $bolImprimirRango = true;
    foreach ($claTipoActo->arrFormatoArchivo as $numColumna => $arrTitulo) {
        switch ($arrTitulo['tipo']) {
            case "numero":
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($numColumna, $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                break;
            case "fecha":
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($numColumna, $i)->getNumberFormat()->setFormatCode("yyyy-mm-dd");
                break;
        }

        if (isset($arrTitulo['rango'])) {

            if($bolImprimirRango) {
                foreach ($arrTitulo['rango'] as $numItemTitulo => $txtEstado) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25, $numItemTitulo, $txtEstado, flase);
                }
                $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setVisible(false);
                $bolImprimirRango = false;
            }

            // pone un combo en la celda con los valores válidos y restringe la inclusion de valores difrentes
            $objValidacion = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($numColumna, $i)->getDataValidation();
            $objValidacion->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidacion->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
            $objValidacion->setAllowBlank(false);
            $objValidacion->setShowInputMessage(true);
            $objValidacion->setShowErrorMessage(true);
            $objValidacion->setShowDropDown(true);
            $objValidacion->setErrorTitle("Error de datos");
            $objValidacion->setError("El valor digitado no es válido");
            $objValidacion->setPromptTitle("Los valores válidos son:");
            $objValidacion->setFormula1('$Z$1:$Z$' . $numItemTitulo );
        }

        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

    }
}

// *************************** EXPORTA LOS RESULTADOS *************************************************************** //

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=Plantilla_" . mb_ereg_replace( " " , "_" , $claTipoActo->txtTipoActo ) . ".xlsx");
header('Cache-Control: max-age=0');
ob_end_clean();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>