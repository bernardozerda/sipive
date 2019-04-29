<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$txtPrefijoRuta = "../../librerias/";
require_once '../../librerias/phpExcel/Classes/PHPExcel.php';
require_once '../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php';
include( $txtPrefijoRuta. "clases/calificacion.class.php" );
$objPHPExcel = new PHPExcel();
$claCalificacion = new calificacion();

$conexion = mysql_connect("localhost", "sdht_usuario", "Ochochar*1");
mysql_set_charset('utf8', $conexion);
mysql_select_db("sipive", $conexion);

$fecha = $_GET['fchCal'];
$sql = $claCalificacion->obtenerResumenCalificacion($fecha);
//echo $sql;


$resultdl = mysql_query($sql, $conexion) or die(mysql_error());
$registros = mysql_num_rows($resultdl);
print_r($registros);
die();
$tituloReporte = Array();
$tituloReporte[] = "ID Hogar";
$tituloReporte[] = "Documento";
$tituloReporte[] = "Postulante Principal";
$tituloReporte[] = "Telefono 1";
$tituloReporte[] = "Telefono 2";
$tituloReporte[] = "Celular";
$tituloReporte[] = "Tipo\nVictima";
$tituloReporte[] = "Modalidad";
$tituloReporte[] = "Integrantes";
$tituloReporte[] = "miembros > 15";
$tituloReporte[] = "Años\nAprobados";
$tituloReporte[] = "Calculo\nEducacion";
$tituloReporte[] = "Dicotomia\nEducacion";
$tituloReporte[] = "Total\nEducacion";
$tituloReporte[] = "Miembros\nRegimen\nSubsidiado";
$tituloReporte[] = "Calculo Miembros\nRegimen\nSubsidiado";
$tituloReporte[] = "Total Miembros\nRegimen\nSubsidiado";
$tituloReporte[] = "Cohabitacion";
$tituloReporte[] = "Dicotomia\ncohabitación";
$tituloReporte[] = "Total\nCohabitación";
$tituloReporte[] = "Dormitorios";
$tituloReporte[] = "Calculo\nHacinamiento";
$tituloReporte[] = "Total\nHacinamiento";
$tituloReporte[] = "Ingresos\nHogar";
$tituloReporte[] = "Calculo\nIngresos";
$tituloReporte[] = "Total\nIngresos";
$tituloReporte[] = "Miembros\nOcupados";
$tituloReporte[] = "Calculo\nDependencia\nEconomica";
$tituloReporte[] = "Años Aprobados\nJefe Hogar";
$tituloReporte[] = "Dicotomia\nDependencia\nEconomica";
$tituloReporte[] = "Total\nDependencia\nEconomica";
$tituloReporte[] = "Cantidad\n<= 12 años";
$tituloReporte[] = "Calculo\nMenores";
$tituloReporte[] = "Total\nMenores";
$tituloReporte[] = "Cantidad\nHijos";
$tituloReporte[] = "Mujer\nCabeza\nHogar";
$tituloReporte[] = "Persona\nConyugue";
$tituloReporte[] = "Dicotomia\nMujer\nCabeza Hogar";
$tituloReporte[] = "Total\nMujer\nCabeza Hogar";
$tituloReporte[] = "Cantidad\n >=60 Años";
$tituloReporte[] = "Calculo\nHogar con\nAdulto";
$tituloReporte[] = "Total\nHogar con\nAdulto";
$tituloReporte[] = "Cantidad\n Cond. Especial";
$tituloReporte[] = "Calculo\nCond Especial";
$tituloReporte[] = "Total\nCond Especial";
$tituloReporte[] = "Cantidad\nGrupo Etnico";
$tituloReporte[] = "Calculo\nGrupo Etnico";
$tituloReporte[] = "Total\nGrupo Etnico";
$tituloReporte[] = "Cantidad\nAdolecentes";
$tituloReporte[] = "Calculo\nAdolecentes";
$tituloReporte[] = "Total\nAdolecentes";
$tituloReporte[] = "Hombre\nCabeza\nHogar";
$tituloReporte[] = "Persona\nConyugue";
$tituloReporte[] = "Dicotomia\nHombre\nCabeza Hogar";
$tituloReporte[] = "Total\nHombre\nCabeza Hogar";
$tituloReporte[] = "Cantidad\nLGTBI";
$tituloReporte[] = "Calculo\nLGTBI";
$tituloReporte[] = "Total\nLGTBI";
$tituloReporte[] = "Dicotomia\nPrograma";
$tituloReporte[] = "Total\nPrograma";
$tituloReporte[] = "Total";

$arrNomCol = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC",
    "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ", "BA", "BB", "BC",
    "BD", "BE", "BF", "BG", "BH", "BI", "BJ");

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
    $titulos = 61;
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
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowcount . ':BI' . $rowcount)->applyFromArray($styleArrayBody);
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
