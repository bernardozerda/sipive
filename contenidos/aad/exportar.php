<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aadTipo.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aad.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );

// *************************** OBTIENE LOS DATOS ******************************************************************** //

$claActoAdministrativo = new aad();
$claActoAdministrativo->cargarActo($_GET['seqTipoActo'], $_GET['numActo'], $_GET['fchActo']);

if($_GET['exportar'] == 'detalles'){
   $arrExportable = $claActoAdministrativo->arrExportable;
}else{
   $claActoAdministrativo->obtenerHogares();
   $arrExportable = $claActoAdministrativo->arrHogares;
}

// *************************** CREA ARCHIVO DE EXCEL CON LOS DATOS ************************************************** //

$arrTitulos = array_keys($arrExportable[0]);
$numColumnas = count($arrTitulos);
$numFilas = count($arrExportable);

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$objHoja = $objPHPExcel->getActiveSheet();
$objHoja->setTitle( strtoupper($_GET['exportar']) );

// titulos
for( $i = 0 ; $i < count($arrTitulos) ; $i++ ) {
   $objHoja->setCellValueByColumnAndRow( $i , 1 , $arrTitulos[$i] , false );
   $objHoja->getColumnDimensionByColumn($i)->setAutoSize(true);
   $objHoja->getRowDimension(1)->setRowHeight(12);
}

// contenido
foreach($arrExportable as $numFila => $arrLinea ){
   foreach($arrTitulos as $numColumna => $txtTitulo){
      $objHoja->setCellValueByColumnAndRow($numColumna, ($numFila + 2), $arrLinea[$txtTitulo], false);
      $objHoja->getRowDimension(($numFila + 2))->setRowHeight(12);
   }
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

// *************************** EXPORTA LOS RESULTADOS *************************************************************** //

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename='Detalles_" . $_GET['numActo'] . "_" . $_GET['fchActo'] . "_" . strtoupper($_GET['exportar']) . ".xlsx");
header('Cache-Control: max-age=0');
ob_end_clean();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>