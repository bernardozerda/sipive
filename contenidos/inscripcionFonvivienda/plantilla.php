<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "InscripcionFonvivienda.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( $txtPrefijoRuta . "/librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );

// *************************** OBTIENE LOS DATOS DE LA PLANTILLA **************************************************** //

$seqTipo = intval($_GET['tipo']);
$claInscripcion = new InscripcionFonvivienda();
$arrTitulos = $claInscripcion->obtenerTitulos($seqTipo);
if(empty($arrTitulos)){
    $arrTitulos[] = "Seleccione el programa de complementariedad en el formulario";
}

// *************************** CREA ARCHIVO DE EXCEL CON LOS DATOS ************************************************** //

switch($seqTipo){
    case 1:
        $txtNombreHoja = "MCY";
        break;
    case 2:
        $txtNombreHoja = "VIPA";
        break;
    case 3:
        $txtNombreHoja = "EPI";
        break;
}

// fuentes para el archivo
$arrFuentes['default']['font']['name'] = "Calibri";
$arrFuentes['default']['font']['size'] = 8;
$arrFuentes['titulo']['fill']['type'] = PHPExcel_Style_Fill::FILL_SOLID;
$arrFuentes['titulo']['fill']['color'] = array('rgb' => 'E4E4E4');
$arrFuentes['titulo']['font']['bold'] = true;
$arrFuentes['titulo']['font']['color'] = array('rgb' => '000000');

// Creacion del libro de excel
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getDefaultStyle()->applyFromArray($arrFuentes['default']);

// creacion de la hoja por defecto
$objPHPExcel->getActiveSheet()->setTitle("Plantilla " . $txtNombreHoja); // titulo de excel limitado a 30 caracteres

// crea una hoja para cada lista
if(! empty($claInscripcion->arrPlantilla[$seqTipo])) {
    foreach ($claInscripcion->arrPlantilla[$seqTipo] as $txtCampo => $arrDato) {
        if ($arrDato != null) {
            $objHoja = $objPHPExcel->createSheet();
            $objHoja->setTitle(substr(mb_ereg_replace("[/\ ]", "", $txtCampo), 0, 30));
            $objHoja->setSheetState(PHPExcel_Worksheet::SHEETSTATE_VERYHIDDEN);
            $numFila = 1;
            foreach ($arrDato as $txtValor) {
                $objHoja->setCellValueByColumnAndRow(0, $numFila, $txtValor, flase);
                $numFila++;
            }
        }
    }
}

// titulos
foreach ($arrTitulos as $i => $txtTitulo) {
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, 1, $txtTitulo, flase);
}


// contenido
$numFilas = 100;
if(! empty($claInscripcion->arrPlantilla[$seqTipo])) {
    for ($i = 2; $i < $numFilas; $i++) {
        $j = 0;
        foreach ($claInscripcion->arrPlantilla[$seqTipo] as $txtCampo => $arrRango) {

            if ($arrRango == null) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j, $i, "", flase);
                switch (true) {
                    case strpos(mb_strtolower($txtCampo),"fecha") !== false:
                        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($j, $i)->getNumberFormat()->setFormatCode("yyyy-mm-dd");
                        break;
                }
            } else {

                // pone un combo en la celda con los valores válidos y restringe la inclusion de valores difrentes
                $objValidacion = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getDataValidation();
                $objValidacion->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidacion->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
                $objValidacion->setAllowBlank(false);
                $objValidacion->setShowInputMessage(true);
                $objValidacion->setShowErrorMessage(true);
                $objValidacion->setShowDropDown(true);
                $objValidacion->setErrorTitle("Error de datos");
                $objValidacion->setError("El valor digitado no es válido");
                $objValidacion->setFormula1(substr(mb_ereg_replace("[/\ ]", "", $txtCampo), 0, 30) . '!A1:A' . count($arrRango));

            }

            $j++;
        }
    }
}

// da formato a todas las columnas del libro
$numColumnas = count($arrTitulos);

$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0) . "1:" . PHPExcel_Cell::stringFromColumnIndex($numColumnas) . ($numFilas + 1))->applyFromArray($arrFuentes['default']);

// da formato al titulo
$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0) . "1:" . PHPExcel_Cell::stringFromColumnIndex($numColumnas - 1) . "1")->applyFromArray($arrFuentes['titulo']);

for ($i = 0; $i < $numColumnas; $i++) {
    $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
    for ($j = 1; $j < ($numFilas + 2); $j++) {
        $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(12);
    }
}

// *************************** EXPORTA LOS RESULTADOS *************************************************************** //

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename='Plantilla_" . $txtNombreHoja . "_" . date("YmdHis") . ".xlsx");
header('Cache-Control: max-age=0');
ob_end_clean();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>