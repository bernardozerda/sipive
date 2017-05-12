<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../librerias/phpExcel/Classes/PHPExcel.php';
require_once '../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php';

$objPHPExcel = new PHPExcel();

$conexion = mysql_connect("localhost", "sdht_usuario", "Ochochar*1");
mysql_set_charset('utf8', $conexion);
mysql_select_db("sdht_sipive", $conexion);


$sql = "select seqFormulario, numDocumento,
concat(txtNombre1,' ', txtNombre2, ' ', txtApellido1, ' ', txtApellido2) as postulante, 
cal.infHogar, cal.cantMiembrosHogar, cal.totalIngresos, sum(op.total)
from t_frm_calificacion_plan3  cal
left join t_frm_calificacion_operaciones op using(seqCalificacion)
left join t_frm_formulario using(seqFormulario)
left join t_frm_hogar hog using(seqFormulario)
left join t_ciu_ciudadano ciu using (seqCiudadano)
where fchCalificacion like '" . $_GET['fchCal'] . "'
and seqParentesco = 1
group by seqFormulario";

$resultdl = mysql_query($sql, $conexion) or die(mysql_error());
$registros = mysql_num_rows($resultdl);


$tituloReporte = Array();
$tituloReporte[0] = "ID Hogar";
$tituloReporte[1] = "Documento";
$tituloReporte[2] = "Postulante Principal";
$tituloReporte[3] = "Inf del Hogar";
$tituloReporte[4] = "Integrantes";
$tituloReporte[5] = "Ingresos";
$tituloReporte[6] = "Total";


$arrNomCol = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC",
    "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ");

$style_header = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'cfcfcf'),
    ),
    'font' => array(
        'bold' => true,
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
);
$style_Mod = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'FFFF00'),
    ),
    'font' => array(
        'bold' => true,
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
);

//seteo del estilo por defecto del cuerpo de la tabla
$styleArrayBody = array(
    'font' => array(
        'bold' => false,
        'size' => 10,
        'name' => 'Calibri'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
);

if ($registros > 0) {
    //var_dump($arrDocumentos);
    $docConsult = Array();

    $tiltle = 0;
    $titulos = 7;
    $field = 0;
    while ($field !== $titulos) {
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . "1", $tituloReporte[$tiltle])->getRowDimension('1')->setRowHeight(80);
        $objPHPExcel->getActiveSheet()->getColumnDimension($arrNomCol[$field])->setAutoSize(true);
        $objPHPExcel->getProperties()->setCreator("HOO")->setLastModifiedBy("HOO");
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $arrNomCol[$field] . '1')->applyFromArray($style_header);
        $field++;
        $tiltle++;
    }
    $int = 0;


    $rowcount = 2;
    while ($row = mysql_fetch_array($resultdl)) {
        $field = 0;
        while ($field !== $titulos) {
            // $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . $rowcount, utf8_encode($row[$field]));
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . $rowcount, str_replace('  ', '', $row[$field]));
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowcount . ':G' . $rowcount)->applyFromArray($styleArrayBody);
            $field++;
        }
        $rowcount++;
    }
    $rowcount = $rowcount + 1;

    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="Calificacion_' . $_GET['fchCal'] . '.xls"');
    $objWriter->save('php://output');
    exit;
} else {
    echo '<span style="color:#c10;text-align:center;"><b>No hay registros!</b></span>';
}
mysql_close();
