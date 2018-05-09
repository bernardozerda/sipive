<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "GestionFinancieraProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );

$claGestion = new GestionFinancieraProyectos();
$arrPlantilla = $claGestion->plantillaGiroConstructor($_GET['seqProyecto']);

pr($arrPlantilla);

if(! empty($arrPlantilla)) {

    // *************************** CREA ARCHIVO DE EXCEL CON LOS DATOS ************************************************** //

    $numColumnas = count($arrPlantilla[0]);
    $numFilas = count($arrPlantilla);

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getProperties()->setCreator($claGestion->txtCreador);
    $objHoja = $objPHPExcel->getActiveSheet();
    $objHoja->setTitle('Unidades Disponibles');

    // titulos
    $arrTitulos = array_keys($arrPlantilla[0]);
    for ($i = 0; $i < count($arrTitulos); $i++) {
        $objHoja->setCellValueByColumnAndRow($i, 1, $arrTitulos[$i], false);
    }

    // contenido
    for($i = 0; $i < count($arrPlantilla); $i++){
        $j = 0;
        foreach($arrPlantilla[$i] as $txtValor){
            $objHoja->setCellValueByColumnAndRow($j,($i+2), $txtValor, false);
            $j++;
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
        }
    }

    // *************************** EXPORTA LOS RESULTADOS *************************************************************** //

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment;filename='UnidadesGiroConstructor_" . date("YmdHis") . ".xlsx");
    header('Cache-Control: max-age=0');
    ob_end_clean();

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');

}

?>