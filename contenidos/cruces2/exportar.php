<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Cruces.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );

$arrEstados = estadosProceso();

$claCruces = new Cruces();
$claCruces->cargar($_GET['seqCruce']);

// *************************** CREA ARCHIVO DE EXCEL CON LOS DATOS ************************************************** //

// titulos del archivo
$arrTitulos[] = "seqFormulario";
$arrTitulos[] = "POSTULANTE PRINCIPAL";
$arrTitulos[] = "MODALIDAD";
$arrTitulos[] = "ESTADO";
$arrTitulos[] = "TIPO_DOCUMENTO";
$arrTitulos[] = "DOCUMENTO";
$arrTitulos[] = "NOMBRE";
$arrTitulos[] = "PARENTESCO";
$arrTitulos[] = "ENTIDAD";
$arrTitulos[] = "CAUSA";
$arrTitulos[] = "DETALLE";
$arrTitulos[] = "INHABILITAR";
$arrTitulos[] = "OBSERVACIONES";

$numColumnas = count($arrTitulos);
$numFilas = count($claCruces->arrDatos['arrResultado']);

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$objHoja = $objPHPExcel->getActiveSheet();
$objHoja->setTitle('Cruce');

// titulos
for( $i = 0 ; $i < count($arrTitulos) ; $i++ ) {
    $objHoja->setCellValueByColumnAndRow( $i , 1 , $arrTitulos[$i] , false );
    $objHoja->getColumnDimensionByColumn($i)->setAutoSize(true);
    $objHoja->getRowDimension(1)->setRowHeight(12);
}

// contenido
$numFila = 0;
foreach($claCruces->arrDatos['arrResultado'] as $seqResultado => $arrLinea ){

    $numColumna = 0;

    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrLinea['seqFormulario'], false);
    $objHoja->getRowDimension(($numFila + 2))->setRowHeight(12);

    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrLinea['numDocumentoPrincipal'], false);
    $objHoja->getRowDimension(($numFila + 2))->setRowHeight(12);

    $txtModalidad = mb_strtoupper(
        array_shift(
            obtenerDatosTabla(
                "t_frm_modalidad",
                array("seqModalidad","txtModalidad"),
                "seqModalidad",
                "seqModalidad = " . $arrLinea['seqModalidad']
            )
        )
    );
    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $txtModalidad, false);
    $objHoja->getRowDimension(($numFila + 2))->setRowHeight(12);

    $seqEstadoProceso = $arrLinea['seqEstadoProceso'];
    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrEstados[$seqEstadoProceso], false);
    $objHoja->getRowDimension(($numFila + 2))->setRowHeight(12);

    $txtTipoDocumento = mb_strtoupper(
        array_shift(
            obtenerDatosTabla(
                "t_ciu_tipo_documento",
                array("seqTipoDocumento","txtTipoDocumento"),
                "seqTipoDocumento",
                "seqTipoDocumento = " . $arrLinea['seqTipoDocumento']
            )
        )
    );
    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $txtTipoDocumento, false);
    $objHoja->getRowDimension(($numFila + 2))->setRowHeight(12);

    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrLinea['numDocumento'], false);
    $objHoja->getRowDimension(($numFila + 2))->setRowHeight(12);

    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrLinea['txtNombre'], false);
    $objHoja->getRowDimension(($numFila + 2))->setRowHeight(12);

    $txtParentesco = mb_strtoupper(
        array_shift(
            obtenerDatosTabla(
                "t_ciu_parentesco",
                array("seqParentesco","txtParentesco"),
                "seqParentesco",
                "seqParentesco = " . $arrLinea['seqParentesco']
            )
        )
    );
    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $txtParentesco, false);
    $objHoja->getRowDimension(($numFila + 2))->setRowHeight(12);

    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrLinea['txtEntidad'], false);
    $objHoja->getRowDimension(($numFila + 2))->setRowHeight(12);

    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrLinea['txtTitulo'], false);
    $objHoja->getRowDimension(($numFila + 2))->setRowHeight(12);

    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrLinea['txtDetalle'], false);
    $objHoja->getRowDimension(($numFila + 2))->setRowHeight(12);

    $txtInhabilitar = ($arrLinea['bolInhabilitar'] == 1)? "SI" : "NO";
    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $txtInhabilitar, false);
    $objHoja->getRowDimension(($numFila + 2))->setRowHeight(12);

    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrLinea['txtObservaciones'], false);
    $objHoja->getRowDimension(($numFila + 2))->setRowHeight(12);

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

// *************************** EXPORTA LOS RESULTADOS *************************************************************** //
ob_end_clean();
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename='Detalles_" . $claCruces->arrDatos['txtNombre'] . "_" . date("YmdHis") . ".xlsx");
header('Cache-Control: max-age=0');
ob_end_clean();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');




?>