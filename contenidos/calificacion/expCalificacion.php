<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
require_once '../../librerias/phpExcel/Classes/PHPExcel.php';
require_once '../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php';
include( $txtPrefijoRuta . "/librerias/clases/calificacion.class.php" );
ini_set('memory_limit', '-1');
ini_set('max_execution_time', '86400');


$objPHPExcel = new PHPExcel();
$claCalificacion = new calificacion();

//$conexion = mysql_connect("localhost", "sdht_usuario", "Ochochar*1");
//mysql_set_charset('utf8', $conexion);
//mysql_select_db("sipive", $conexion);

$fecha = $_GET['fchCal'];
$resultdl = $claCalificacion->obtenerResumenCalificacion($fecha);
$registros = count($resultdl);
//var_dump($registros);
//echo $sql;
//$resultdl = mysql_query($sql, $conexion) or die(mysql_error());
//$registros = mysql_num_rows($resultdl);


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
$tituloReporte[] = "Total\nReconocimientoFP";
$tituloReporte[] = "Total";




$seqReporte = Array();
$seqReporte[] = "seqFormulario";
$seqReporte[] = "numDocumento";
$seqReporte[] = "postulante";
$seqReporte[] = "numTelefono1";
$seqReporte[] = "numTelefono2";
$seqReporte[] = "numCelular";
$seqReporte[] = "victima";
$seqReporte[] = "txtModalidad";
$seqReporte[] = "cantMiembrosHogar";
$seqReporte[] = "miembros15";
$seqReporte[] = "anosAprobados";
$seqReporte[] = "calculoEducacion";
$seqReporte[] = "dicotomiaEducacion";
$seqReporte[] = "totalEducacion";
$seqReporte[] = "miembroSubsidiados";
$seqReporte[] = "calculoSubsidiados";
$seqReporte[] = "totalSubsidiados";
$seqReporte[] = "cohabitacion";
$seqReporte[] = "dicotomiaCohabitacion";
$seqReporte[] = "totalCohabitacion";
$seqReporte[] = "dormitorios";
$seqReporte[] = "calculoHacinamiento";
$seqReporte[] = "totalHacinamiento";
$seqReporte[] = "ingresosHogar";
$seqReporte[] = "calculoIngresos";
$seqReporte[] = "totalIngresos";
$seqReporte[] = "miembroOcupados";
$seqReporte[] = "calculosDependencia";
$seqReporte[] = "aprobadosPostulante";
$seqReporte[] = "dicotomiaDependencia";
$seqReporte[] = "totalDependencia";
$seqReporte[] = "cantMenores";
$seqReporte[] = "calculosMenores";
$seqReporte[] = "totalMenores";
$seqReporte[] = "cantHijos";
$seqReporte[] = "mujerCabezaHogar";
$seqReporte[] = "PersonaConyugue";
$seqReporte[] = "dicotomiaMujeCab";
$seqReporte[] = "totalMujerCabHogar";
$seqReporte[] = "cantAdultoMayor";
$seqReporte[] = "calculoAdultoMayor";
$seqReporte[] = "totalAdultoMayor";
$seqReporte[] = "cantCondEspecial";
$seqReporte[] = "calculoCondEspecial";
$seqReporte[] = "totalCondEspecial";
$seqReporte[] = "cantGrupoEtnico";
$seqReporte[] = "calculoGrupoEtnico";
$seqReporte[] = "totalGrupoEtnico";
$seqReporte[] = "cantAdolencentes";
$seqReporte[] = "calculoAdolencentes";
$seqReporte[] = "totalAdolencentes";
$seqReporte[] = "hombreCabezaHogar";
$seqReporte[] = "PersonaConyugue";
$seqReporte[] = "dicotomiaHombreCab";
$seqReporte[] = "totalHombeCabHogar";
$seqReporte[] = "cantLGTBI";
$seqReporte[] = "calculoLGTBI";
$seqReporte[] = "totalLGTBI";
$seqReporte[] = "dicotomiaPrograma";
$seqReporte[] = "totalPrograma";
$seqReporte[] = "totalReconocimientoFP";
$seqReporte[] = "total";

$arrNomCol = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC",
    "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ", "BA", "BB", "BC",
    "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK");

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
    $titulos = 62;
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

    foreach ($resultdl as $key => $value) {
        //print_r($value);
        // echo "<br>";
        $field = 0;
        while ($field !== $titulos) {
            // echo " \t " . $value[$seqReporte[$field]];
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . $rowcount, utf8_encode($value[$seqReporte[$field]]));
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . $rowcount, str_replace('  ', '', $value[$seqReporte[$field]]));
//            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowcount . ':BI' . $rowcount)->applyFromArray($styleArrayBody);
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
