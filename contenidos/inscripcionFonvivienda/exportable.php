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

$seqCargue = $_GET['seqCargue'];

$claInscripcion = new InscripcionFonvivienda();
$claInscripcion->cargar($seqCargue);
$arrExportable = $claInscripcion->exportable();

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
$objPHPExcel->getActiveSheet()->setTitle("Estado Hogares"); // titulo de excel limitado a 30 caracteres

// titulos y contenido
$numFila = 1;
$numColumna = 0;
foreach ($arrExportable as $numHogar => $arrHogar) {

    if($numFila == 1) {
        foreach ($arrHogar as $txtTitulo => $txtValor) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($numColumna, $numFila, $txtTitulo, flase);
            $numColumna++;
        }
        $numFila++;
    }

    $numColumna = 0;
    foreach ($arrHogar as $txtTitulo => $txtValor) {
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($numColumna, $numFila, $txtValor, flase);
        $numColumna++;
    }

    $numFila++;
}

// da formato a todas las columnas del libro
$numColumnas = $numColumna;
$numFilas    = count($arrExportable);

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
header("Content-Disposition: attachment;filename='HogaresCargue_" . $seqCargue . "_" . date("YmdHis") . ".xlsx");
header('Cache-Control: max-age=0');
ob_end_clean();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>