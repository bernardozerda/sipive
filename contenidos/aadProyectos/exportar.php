<?php

ini_set("memory_limit","-1");

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aadProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );

// *************************** OBTIENE LOS DATOS ******************************************************************** //

$claActo = new aadProyectos();
$claActo->cargar($_GET['seqUnidadActo']);

// *************************** CREA ARCHIVO DE EXCEL CON LOS DATOS ************************************************** //

$arrTitulos[] = "Tipo";
$arrTitulos[] = "Número";
$arrTitulos[] = "Fecha";
$arrTitulos[] = "Descripción";
$arrTitulos[] = "Creación";
$arrTitulos[] = "Usuario";
$arrTitulos[] = "Proyecto";
$arrTitulos[] = "Conjunto";
$arrTitulos[] = "Unidad";
$arrTitulos[] = "Valor";
$arrTitulos[] = "Proyecto de Inversión";
$arrTitulos[] = "Número CDP";
$arrTitulos[] = "Fecha CDP";
$arrTitulos[] = "Valor CDP";
$arrTitulos[] = "Vigencia CDP";
$arrTitulos[] = "Número RP";
$arrTitulos[] = "Fecha RP";
$arrTitulos[] = "Valor RP";
$arrTitulos[] = "Vigencia RP";
$arrTitulos[] = "Número Referencia";
$arrTitulos[] = "Fecha Referencia";

$numColumnas = count($arrTitulos);
$numFilas = count($claActo->arrUnidades);

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$objHoja = $objPHPExcel->getActiveSheet();
$objHoja->setTitle( strtoupper($claActo->numActo . ' del ' . $claActo->fchActo) );

// titulos
for( $i = 0 ; $i < count($arrTitulos) ; $i++ ) {
    $objHoja->setCellValueByColumnAndRow( $i , 1 , $arrTitulos[$i] , false );

}

// contenido
$numFila = 2;
foreach($claActo->arrUnidades as $seqUnidadActo => $arrUnidad ){
    $numColumna = 0;
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $claActo->txtTipoActoUnidad, false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $claActo->numActo, false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $claActo->fchActo, false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $claActo->txtDescripcion, false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $claActo->fchCreacion, false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $claActo->txtNombre, false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $arrUnidad['txtNombreProyecto'], false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $arrUnidad['txtNombreConjunto'], false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $arrUnidad['txtNombreUnidad'], false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $arrUnidad['valIndexado'], false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $arrUnidad['numProyectoInversionCDP'], false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $arrUnidad['numNumeroCDP'], false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $arrUnidad['fchFechaCDP']->format("Y-m-d"), false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $arrUnidad['valValorCDP'], false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $arrUnidad['numVigenciaCDP'], false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $arrUnidad['numNumeroRP'], false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $arrUnidad['fchFechaRP']->format("Y-m-d"), false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $arrUnidad['valValorRP'], false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $arrUnidad['numVigenciaRP'], false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $arrUnidad['numActoReferencia'], false);
    $objHoja->setCellValueByColumnAndRow($numColumna++, $numFila, $arrUnidad['fchActoReferencia']->format("Y-m-d"), false);
    $numFila++;
}


// *************************** ESTILOS POR DEFECTO DEL ARCHIVO DE EXCEL ********************************************* //

// estilo por defecto
$arrEstilos = array(
    'font' => array(
        'bold' => false,
        'size' => 8,
        'name' => 'Calibri'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE,
        ),
    ),
);

// da formato a todas las columnas del libro
$objHoja->getStyle(  PHPExcel_Cell::stringFromColumnIndex(0) . "1:" . PHPExcel_Cell::stringFromColumnIndex($numColumnas) . ($numFilas + 1) )->applyFromArray($arrEstilos);

for( $i = 0 ; $i < count($arrTitulos) ; $i++ ) {
    $objHoja->getColumnDimensionByColumn($i)->setAutoSize(true);
    for($j = 1; $j < ($numFilas + 2); $j++) {
        $objHoja->getRowDimension($j)->setRowHeight(12);
    }
}

// *************************** EXPORTA LOS RESULTADOS *************************************************************** //

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename='AADPRY_" . $claActo->numActo . "_" . $claActo->fchActo . ".xlsx");
header('Cache-Control: max-age=0');
ob_end_clean();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');


?>