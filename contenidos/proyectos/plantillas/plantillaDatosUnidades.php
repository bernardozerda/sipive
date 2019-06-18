<?php

/*
 *               Autora: LILIANA BASTO
 *  PLANTILLA PARA MODIFICACION DE DATOS DE LA UNIDADES
 * 
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


$arrUnidades = "";
$cantUnidades = 0;
if ($_FILES['archivo']['error'] == 0) {
    $arrayUnidades = mb_split("\n", file_get_contents($_FILES['archivo']['tmp_name']));
    $cantUnidades = count(mb_split("\n", file_get_contents($_FILES['archivo']['tmp_name'])));
    $arrUnidades = str_replace("\n", ",", file_get_contents($_FILES['archivo']['tmp_name']));
    $quitar = implode(',', $arrayUnidades);
    $quitar = preg_replace("/\s+/", " ", $quitar);
    $quitar = str_replace(" ,", ",", $quitar);
    $arrayUnidades = explode(",", $quitar);
}

$claDatosUnidades = new DatosUnidades();
//$arrPlanGobierno = obtenerDatosTabla("t_frm_plan_gobierno", array("seqPlanGobierno", "txtPlanGobierno"), "seqPlanGobierno", "", "seqPlanGobierno ASC, txtPlanGobierno");
$arrPryTipoModalidad = obtenerDatosTabla("T_FRM_MODALIDAD", array("seqModalidad", "txtModalidad", "seqPlanGobierno"), "seqModalidad", "", "seqPlanGobierno ASC, txtModalidad");
$arrPryEsquema = obtenerDatosTabla("t_pry_tipo_esquema", array("seqTipoEsquema", "txtTipoEsquema", "seqPlanGobierno"), "seqTipoEsquema", "", "seqPlanGobierno ASC, txtTipoEsquema");
$arrPlanGobierno = obtenerDatosTabla("t_frm_plan_gobierno", array("seqPlanGobierno", "txtPlanGobierno"), "seqPlanGobierno", "", "seqPlanGobierno ASC, txtPlanGobierno");
$arrPryTipoModalidad = obtenerDatosTabla("T_FRM_MODALIDAD", array("seqModalidad", "txtModalidad", "seqPlanGobierno"), "seqModalidad", "", "seqPlanGobierno ASC, txtModalidad");
$arrEstadoUnidad = obtenerDatosTabla("t_pry_estado_unidad", array("seqEstadoUnidad", "txtEstadoUnidad", "seqEstadoUnidad"), "seqEstadoUnidad", "", "seqEstadoUnidad ASC, seqEstadoUnidad");


if ($_REQUEST['seqProyectoPadre'] != "" && $_REQUEST['seqProyectoPadre'] != null) {

    $seqProyecto = $_REQUEST['seqProyectoPadre'];
    $infUnidades = $claDatosUnidades->obtenerDatosUnidades($seqProyecto, $arrUnidades);
    // $infUnidades = $claDatosUnidades->obtenerDatosUnidadesPorProy($seqProyecto, $arrUnidades);
    $cantUnidadesConsultadas = count($infUnidades);
    $datosObtConsultaU = Array();
    $arrModalidad = Array();
    $band = true;
    foreach ($infUnidades as $key => $value) {
        $datosObtConsultaU[] = $value['seqUnidadProyecto'];
    }
//      var_dump($arrModalidad);
//        var_dump($arrPlanGob);
//    var_dump($arrEsquema); die();

    if ($cantUnidadesConsultadas != $cantUnidades) {
        $resultado = array_diff($arrayUnidades, $datosObtConsultaU);
        echo "<div class='alert alert-danger'><strong>Atención!!! </strong>Los siguientes número(s) de unidades no se encuentran o no pertenecen a el proyecto <b>" . $infUnidades[0]['txtNombreProyecto'] . "</b>:<br>";
        foreach ($resultado as $key => $value) {
            echo "<br>* " . $value;
        }
        echo "</div>";
        die();
    }


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
    $titulos[2] = "Conjunto";
    $titulos[3] = "Nombre de la unidad";
    $titulos[4] = "Estado Actual";
    $titulos[5] = "Nuevo Estado";
    $titulos[6] = "Activo";
    $titulos[7] = "Modalidad";
    $titulos[8] = "Esquema";

    // plantila


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

    $intmod = 2;
    foreach ($arrPryTipoModalidad as $keyMod => $valueMod) {
        // var_dump($valueMod);
        $excel->getSheet(1)->SetCellValue("H" . $intmod, $keyMod . '-' . $valueMod['txtModalidad'] . '- (PG = ' . $valueMod['seqPlanGobierno'] . ')');
        $intmod++;
    }

    $intEsq = 2;
    foreach ($arrPryEsquema as $keyEsq => $valueEsq) {
        $excel->getSheet(1)->SetCellValue("I" . $intEsq, $keyEsq . '-' . $valueEsq['txtTipoEsquema'] . '- (PG = ' . $valueEsq['seqPlanGobierno'] . ')');
        $intEsq++;
    }
    $excel->addNamedRange(
            new PHPExcel_NamedRange(
            'seleccion', $excel->getSheet(1), 'F2:F' . $int
            )
    );

    $excel->getSheet(1)->SetCellValue("G2", "SI");
    $excel->getSheet(1)->SetCellValue("G3", "NO");
    $excel->addNamedRange(
            new PHPExcel_NamedRange(
            'seleccion1', $excel->getSheet(1), 'G2:G3'
            )
    );
    $excel->addNamedRange(
            new PHPExcel_NamedRange(
            'seleccionMod', $excel->getSheet(1), 'H2:H' . $intmod
            )
    );

    $excel->addNamedRange(
            new PHPExcel_NamedRange(
            'seleccionEsq', $excel->getSheet(1), 'I2:I' . $intEsq
            )
    );

    //for ($i = 0; $i < $unidadesReg; $i++) {
    $cols = 2;
    foreach ($infUnidades as $key => $value) {
        $estadoActual = ($value['estado'] == "") ? 'Ninguno' : $value['estado'];
        $estadoNuevo = ($value['estado'] == "") ? 'Seleccione' : $value['estado'];
        $datosModalidad = ($value['seqModalidad'] > 0) ? array_values($arrPryTipoModalidad[$value['seqModalidad']]) : 'Seleccione';
        $modActual = $value['seqModalidad'] . "-" . $datosModalidad[0];
        $datosEsquema = ($value['seqTipoEsquema'] > 0) ? array_values($arrPryEsquema[$value['seqTipoEsquema']]) : 'Seleccione';
        $esqActual = $value['seqTipoEsquema'] . "-" . $datosEsquema[0];
        $tipoVivienda = ($value['txtNombreConjunto'] == "") ? 'Ninguno' : strtoupper($value['txtNombreConjunto']);
        $validacion = ($value['bolActivo'] == 1) ? 'SI' : 'NO';
        //echo "<br>". $cols." ->".$value['txtNombreProyecto'];
        $sheet->setCellValue('A' . $cols, $value['seqUnidadProyecto']);
        $sheet->setCellValue('B' . $cols, $value['txtNombreProyecto']);
        $sheet->setCellValue('C' . $cols, $tipoVivienda);
        $sheet->setCellValue('D' . $cols, $value['txtNombreUnidad']);
        /* $sheet->setCellValue('E' . $cols, $value['txtNombreUnidadReal']);
          $sheet->setCellValue('F' . $cols, $value['txtNombreUnidadAux']); */
        $sheet->setCellValue('E' . $cols, $estadoActual);
        $sheet->setCellValue('F' . $cols, $estadoNuevo);
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
        $sheet->setCellValue('G' . $cols, $validacion);
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
        $objValidation->setFormula1("=seleccion1");
        $sheet->setCellValue('H' . $cols, $modActual);
        $objValidation = $excel->getActiveSheet()->getCell('H' . $cols)->getDataValidation();
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
        $sheet->setCellValue('I' . $cols, $esqActual);
        $objValidation = $excel->getActiveSheet()->getCell('I' . $cols)->getDataValidation();
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

        $cols++;
    }

    $excel->getSecurity()->setLockWindows(false);
    $excel->getSecurity()->setLockStructure(false);
    $excel->getSheet(0)->getProtection()->setSheet(true);
    $excel->getActiveSheet()->getProtection()->setSort(true);
    $excel->getActiveSheet()->getProtection()->setInsertRows(true);
    $excel->getActiveSheet()->getProtection()->setFormatCells(true);
    // $excel->getActiveSheet()->getProtection()->setPassword('SDHT');

    /*$excel->getActiveSheet()->getStyle('F2:I' . $cols)->getProtection()
            ->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);*/

    $excel->getActiveSheet()->getStyle('F2:I' . $cols)->getProtection()
            ->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment;filename=PlantillaEstadoUnidades.xlsx");
    header('Cache-Control: max-age=0');
    ob_end_clean();

    $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $objWriter->save('php://output');
}
//$writer->ou('prueba1.xls');
//$writer->ou('prueba1.xls');
