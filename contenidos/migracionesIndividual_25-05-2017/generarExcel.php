<?php

require_once '../../../librerias/clases/PHPExcel.php';
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Plantillaestudiotitulos.xlsx"');

function crearExcel() {

    $objPHPExcel = new PHPExcel();

// Establecer propiedades
    $objPHPExcel->getProperties()
            ->setCreator("Cattivo")
            ->setLastModifiedBy("Cattivo")
            ->setTitle("Documento Excel de Prueba")
            ->setSubject("Documento Excel de Prueba")
            ->setDescription("Demostracion sobre como crear archivos de Excel desde PHP.")
            ->setKeywords("Excel Office 2007 openxml php")
            ->setCategory("Pruebas de Excel");

// Agregar Informacion
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Valor 1')
            ->setCellValue('B1', 'Valor 2')
            ->setCellValue('C1', 'Total')
            ->setCellValue('A2', '10')
            ->setCellValue('C2', '=sum(A2:B2)');

// Renombrar Hoja
    $objPHPExcel->getActiveSheet()->setTitle('Tecnologia Simple');

// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
    $objPHPExcel->setActiveSheetIndex(0);

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
}
