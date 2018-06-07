<?php

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
$arrEstadoUnidad = obtenerDatosTabla("t_pry_estado_unidad", array("seqEstadoUnidad", "txtEstadoUnidad", "seqEstadoUnidad"), "seqEstadoUnidad", "", "seqEstadoUnidad ASC, seqEstadoUnidad");
//echo "55555" .$_REQUEST['seqProyecto']; die();

if ($_REQUEST['seqProyecto'] != "" && $_REQUEST['seqProyecto'] != null) {

    $seqProyecto = $_REQUEST['seqProyecto'];
    $arrayDatos = $claDatosUnidades->obtenerDatosUnidades($seqProyecto);
    $infCantUnidades = $claDatosUnidades->ObtenerCantUnidadesProyecto($seqProyecto);
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
    $titulos[0] = "ID Unidad";
    $titulos[1] = "Proyecto";
    $titulos[2] = "Nombre de la unidad";
    $titulos[3] = "Conjunto"; 
    $titulos[4] = "Estado Actual";
    $titulos[5] = "Nuevo Estado";
//    $titulos[4] = "Plan de Gobierno";
//    $titulos[5] = "Modalidad";
//    $titulos[6] = "Esquema";


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
    foreach ($arrEstadoUnidad as $key => $value) {
        $excel->getSheet(1)->SetCellValue("F" . $int, $key . '-' . $value);
        $int++;
    }
    $excel->addNamedRange(
            new PHPExcel_NamedRange(
            'seleccion', $excel->getSheet(1), 'F2:F' . $int
            )
    );

    //for ($i = 0; $i < $unidadesReg; $i++) {
    $cols = 2;
    foreach ($arrayDatos as $key => $value) {
        $estadoActual = ($value['estado'] == "") ? 'Ninguno' : $value['estado'];
        $tipoVivienda = ($value['estado'] == "") ? 'Ninguno' : strtoupper($value['txtNombreTipoVivienda']);
        //echo "<br>". $cols." ->".$value['txtNombreProyecto'];
        $sheet->setCellValue('A' . $cols, $value['seqUnidadProyecto']);
        $sheet->setCellValue('B' . $cols, $value['txtNombreProyecto']);
        $sheet->setCellValue('C' . $cols, $value['txtNombreUnidad']);
        $sheet->setCellValue('D' . $cols, $tipoVivienda);
        $sheet->setCellValue('E' . $cols, $estadoActual);
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
        $objValidation->setFormula1("=seleccion");
        $cols++;
    }

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment;filename='PlantillaEstadoUnidades.xlsx");
    header('Cache-Control: max-age=0');
    ob_end_clean();

    $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $objWriter->save('php://output');
}
//$writer->ou('prueba1.xls');
