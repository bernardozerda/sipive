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
    $titulos[0] = "Proyecto";
    $titulos[1] = "Conjunto";
    $titulos[2] = "Nombre de la unidad";
    $titulos[3] = "Estado";
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
        $excel->getSheet(1)->SetCellValue("D" . $int, $key . '-' . $value);
        $int++;
    }
    $excel->addNamedRange(
            new PHPExcel_NamedRange(
            'seleccion', $excel->getSheet(1), 'D2:E' . $int
            )
    );

    //for ($i = 0; $i < $unidadesReg; $i++) {
    $cols = 2;
    foreach ($arrayDatos as $key => $value) {
        //echo "<br>". $cols." ->".$value['txtNombreProyecto'];
        $sheet->setCellValue('A' . $cols, $value['txtNombreProyecto']);
        $sheet->setCellValue('B' . $cols, $value['txtNombreUnidad']);
        $sheet->setCellValue('C' . $cols, $value['txtNombreTipoVivienda']);
        $sheet->setCellValue('D' . $cols, $value['estado']);
        $cols++;
    }

//        
    //}
    //die();
//exportamos nuestro documento 
//    $writer = new PHPExcel_Writer_Excel5($excel);


    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment;filename='PlantillaUnidades.xlsx");
    header('Cache-Control: max-age=0');
    ob_end_clean();

    $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $objWriter->save('php://output');
}
//$writer->ou('prueba1.xls');
