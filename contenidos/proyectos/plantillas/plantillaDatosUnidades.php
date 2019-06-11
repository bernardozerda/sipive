<?php
echo "Holaaaaaaaaaaaaaaaa";
var_dump($_FILES["archivo"]);
die();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$txtPrefijoRuta = "../../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "DatosUnidades.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "PHPExcel.php" );
include( "../../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );


$claDatosUnidades = new DatosUnidades();
$arrPlanGobierno = obtenerDatosTabla("t_frm_plan_gobierno", array("seqPlanGobierno", "txtPlanGobierno"), "seqPlanGobierno", "", "seqPlanGobierno ASC, txtPlanGobierno");
$arrPryTipoModalidad = obtenerDatosTabla("T_FRM_MODALIDAD", array("seqModalidad", "txtModalidad", "seqPlanGobierno"), "seqModalidad", "", "seqPlanGobierno ASC, txtModalidad");
$arrPryEsquema = obtenerDatosTabla("t_pry_tipo_esquema", array("seqTipoEsquema", "txtTipoEsquema", "seqPlanGobierno"), "seqTipoEsquema", "", "seqPlanGobierno ASC, txtTipoEsquema");
//echo "55555" .$_REQUEST['seqProyecto']; die();

if ($_REQUEST['seqProyecto'] != "" && $_REQUEST['seqProyecto'] != null) {

    $seqProyecto = $_REQUEST['seqProyecto'];
    $infCantUnidades = $claDatosUnidades->ObtenerCantUnidadesProyecto($seqProyecto, 0);
    $unidadesReg = $infCantUnidades['cantidad'];
    $totalUnidades = $infCantUnidades['valNumeroSoluciones'];
    $cantUDisponible = $totalUnidades - $unidadesReg;


    $excel = new PHPExcel();
//Usamos el worsheet por defecto 
    $sheet = $excel->getActiveSheet();
//creamos nuestro array con los estilos para titulos 
    $arrayColor = array("#000080", "#00CED1", "#191970");

    $h1 = array(
        'font' => array(
            'bold' => true,
            'size' => 10,
            'name' => 'Tahoma'
        ),
        'borders' => array(
            'allborders' => array(
                'style' => 'thin'
            )
        ),
        'alignment' => array(
            'vertical' => 'center',
            'horizontal' => 'center'
        ),
        'color' => array(
            'rgb' => '#FFF'
        ),
    );

    $titulos = Array();
    $titulos[0] = "Nombre de la unidad";
    $titulos[1] = "Cant SMMLV";
    $titulos[2] = "Valor SDVE Comercial";
    $titulos[3] = "Valor Cierre";
    $titulos[4] = "Plan de Gobierno";
    $titulos[5] = "Modalidad";
    $titulos[6] = "Esquema";


    $letra = "";
    foreach ($titulos as $key => $value) {
        $letra = chr(65 + ($key));
        $sheet->setCellValue($letra . '1', $value);
        $sheet->getColumnDimension($letra . '1')
                ->setAutoSize(true);
    }



//Damos formato o estilo a nuestras celdas 
    $sheet->getStyle('A1:' . $letra . '1')->applyFromArray($h1);
    $sheet->getStyle('A1:' . $letra . '1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $sheet->getStyle('A1:' . $letra . '1')->getFill()->getStartColor()->setARGB('243F62');
    $sheet->getStyle('A1:' . $letra . '1')->getFont()->getColor()->setARGB("FFFFFF");
    $sheet->getRowDimension('1')->setRowHeight(20);
    $sheet->getDefaultColumnDimension()->setWidth(20);

    $excel->createSheet(1);
    $int = 2;
    foreach ($arrPlanGobierno as $key => $value) {
        $excel->getSheet(1)->SetCellValue("E" . $int, $key . '-' . $value);
        $int++;
    }
    $intmod = 2;
    foreach ($arrPryTipoModalidad as $keyMod => $valueMod) {
        // var_dump($valueMod);
        $excel->getSheet(1)->SetCellValue("F" . $intmod, $keyMod . '-' . $valueMod['txtModalidad'] . '- (PG = ' . $valueMod['seqPlanGobierno'] . ')');
        $intmod++;
    }

    $intEsq = 2;
    foreach ($arrPryEsquema as $keyEsq => $valueEsq) {
        $excel->getSheet(1)->SetCellValue("G" . $intEsq, $keyEsq . '-' . $valueEsq['txtTipoEsquema'] . '- (PG = ' . $valueEsq['seqPlanGobierno'] . ')');
        $intEsq++;
    }

    $excel->addNamedRange(
            new PHPExcel_NamedRange(
            'seleccion', $excel->getSheet(1), 'E2:E' . $int
            )
    );

    $excel->addNamedRange(
            new PHPExcel_NamedRange(
            'seleccionMod', $excel->getSheet(1), 'F2:F' . $intmod
            )
    );

    $excel->addNamedRange(
            new PHPExcel_NamedRange(
            'seleccionEsq', $excel->getSheet(1), 'G2:G' . $intEsq
            )
    );

    for ($i = 0; $i < $cantUDisponible; $i++) {
        $cols = $i + 2;
        $sheet->setCellValue('A' . $cols, '');
        $sheet->setCellValue('B' . $cols, '');
        $sheet->setCellValue('C' . $cols, 0);
        $sheet->setCellValue('D' . $cols, 0);
        $sheet->setCellValue('E' . $cols, 'Seleccione');
        $objValidation = $excel->getActiveSheet()->getCell('E' . $cols)->getDataValidation();
        $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
        $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
        $objValidation->setAllowBlank(true);
        $objValidation->setShowInputMessage(true);
        $objValidation->setShowErrorMessage(true);
        $objValidation->setShowDropDown(true);
        $objValidation->setErrorTitle('Error');
        $objValidation->setError('Valor no esta en la lista');
        $objValidation->setPromptTitle('Seleccion');
        $objValidation->setPrompt('Seleccione un valor de la lista');
        $objValidation->setFormula1("=seleccion");
        $sheet->setCellValue('F' . $cols, 'Seleccione');
        $objValidation = $excel->getActiveSheet()->getCell('F' . $cols)->getDataValidation();
        $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
        $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
        $objValidation->setAllowBlank(true);
        $objValidation->setShowInputMessage(true);
        $objValidation->setShowErrorMessage(true);
        $objValidation->setShowDropDown(true);
        $objValidation->setErrorTitle('Error');
        $objValidation->setError('Valor no esta en la lista');
        $objValidation->setPromptTitle('Seleccion');
        $objValidation->setPrompt('Seleccione un valor de la lista');
        $objValidation->setFormula1("=seleccionMod");
        $sheet->setCellValue('G' . $cols, 'Seleccione');
        $objValidation = $excel->getActiveSheet()->getCell('G' . $cols)->getDataValidation();
        $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
        $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
        $objValidation->setAllowBlank(true);
        $objValidation->setShowInputMessage(true);
        $objValidation->setShowErrorMessage(true);
        $objValidation->setShowDropDown(true);
        $objValidation->setErrorTitle('Error');
        $objValidation->setError('Valor no esta en la lista');
        $objValidation->setPromptTitle('Seleccion');
        $objValidation->setPrompt('Seleccione un valor de la lista');
        $objValidation->setFormula1("=seleccionEsq");
    }

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment;filename=PlantillaUnidades.xlsx");
    header('Cache-Control: max-age=0');
    ob_end_clean();

    $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $objWriter->save('php://output');
}
//$writer->ou('prueba1.xls');
