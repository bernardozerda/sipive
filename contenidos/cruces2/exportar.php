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

$seqCruce      = (intval($_GET['seqCruce']) != 0)? $_GET['seqCruce'] : null;
$seqFormulario = (intval($_GET['seqFormulario']) != 0)? $_GET['seqFormulario'] : null;

$claCruces = new Cruces();
$claCruces->cargar($seqCruce,$seqFormulario);

//pr($claCruces); die();

// *************************** CREA ARCHIVO DE EXCEL CON LOS DATOS ************************************************** //

// titulos del archivo
$arrTitulos[] = "RESULTADO";
$arrTitulos[] = "FORMULARIO";
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
    $objHoja->getRowDimension(1)->setRowHeight(12);
}

// contenido
$numFila = 0;
$arrFormularios = array();
foreach($claCruces->arrDatos['arrResultado'] as $seqResultado => $arrLinea ){

    $numColumna = 0;

    $objHoja->getRowDimension(($numFila + 2))->setRowHeight(12);

    $seqFormulario = $arrLinea['seqFormulario'];
    if( ! isset( $arrFormularios[$seqFormulario] ) ){
        $arrFormularios[$seqFormulario] = new FormularioSubsidios();
        $arrFormularios[$seqFormulario]->cargarFormulario($seqFormulario);
    }

    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $seqResultado, false);
    $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrLinea['seqFormulario'], false);
    $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrLinea['numDocumentoPrincipal'], false);
    $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

    $txtModalidad = array_shift(
        obtenerDatosTabla(
            "t_frm_modalidad",
            array("seqModalidad","txtModalidad"),
            "seqModalidad",
            "seqModalidad = " . $arrLinea['seqModalidad']
        )
    );
    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $txtModalidad, false);
    $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

    $seqEstadoProceso = $arrLinea['seqEstadoProceso'];
    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrEstados[$seqEstadoProceso], false);
    $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

    $txtTipoDocumento = array_shift(
        obtenerDatosTabla(
            "t_ciu_tipo_documento",
            array("seqTipoDocumento","txtTipoDocumento"),
            "seqTipoDocumento",
            "seqTipoDocumento = " . $arrLinea['seqTipoDocumento']
        )
    );
    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $txtTipoDocumento, false);
    $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrLinea['numDocumento'], false);
    $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

    // va quitando los ciudadanos que esten en el archivo, los que queden se adicionaran
    foreach ($arrFormularios[$seqFormulario]->arrCiudadano as $seqCiudadano => $objCiudadano){
        if(
            $objCiudadano->seqTipoDocumento == $arrLinea['seqTipoDocumento'] and
            $objCiudadano->numDocumento == $arrLinea['numDocumento']
        ){
            unset($arrFormularios[$seqFormulario]->arrCiudadano[$seqCiudadano]);
        }
    }

    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrLinea['txtNombre'], false);
    $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

    $txtParentesco = array_shift(
        obtenerDatosTabla(
            "t_ciu_parentesco",
            array("seqParentesco","txtParentesco"),
            "seqParentesco",
            "seqParentesco = " . $arrLinea['seqParentesco']
        )
    );
    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $txtParentesco, false);
    $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrLinea['txtEntidad'], false);
    $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrLinea['txtTitulo'], false);
    $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrLinea['txtDetalle'], false);
    $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

    $txtInhabilitar = ($arrLinea['bolInhabilitar'] == 1)? "SI" : "NO";
    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $txtInhabilitar, false);
    $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

    $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrLinea['txtObservaciones'], false);
    $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

    $numFila++;
}

// *************************** ADICIONA LOS MIEMBROS DE T_FRM_FORMULARIO ********************************************* //

foreach($arrFormularios as $seqFormulario => $claFormulario){
    foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano){

        $numColumna = 0;

        $objHoja->getRowDimension(($numFila + 2))->setRowHeight(12);

        $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), "", false);
        $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

        $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $seqFormulario, false);
        $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

        $claFormularioPrincipal = new FormularioSubsidios();
        $claFormularioPrincipal->cargarFormulario($seqFormulario);
        $objPrincipal = Cruces::obtenerPrincipal($claFormularioPrincipal);

        $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $objPrincipal->numDocumento, false);
        $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

        $txtModalidad = array_shift(
            obtenerDatosTabla(
                "t_frm_modalidad",
                array("seqModalidad","txtModalidad"),
                "seqModalidad",
                "seqModalidad = " . $claFormulario->seqModalidad
            )
        );
        $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $txtModalidad, false);
        $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

        $seqEstadoProceso = $claFormulario->seqEstadoProceso;
        $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $arrEstados[$seqEstadoProceso], false);
        $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

        $txtTipoDocumento = array_shift(
            obtenerDatosTabla(
                "t_ciu_tipo_documento",
                array("seqTipoDocumento","txtTipoDocumento"),
                "seqTipoDocumento",
                "seqTipoDocumento = " . $objCiudadano->seqTipoDocumento
            )
        );
        $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $txtTipoDocumento, false);
        $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

        $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $objCiudadano->numDocumento, false);
        $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

        $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), Cruces::obtenerNombre($objCiudadano), false);
        $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

        $txtParentesco = array_shift(
            obtenerDatosTabla(
                "t_ciu_parentesco",
                array("seqParentesco","txtParentesco"),
                "seqParentesco",
                "seqParentesco = " . $objCiudadano->seqParentesco
            )
        );
        $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), $txtParentesco, false);
        $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

        $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), 'Sin Cruce', false);
        $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

        $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), 'Sin Cruce', false);
        $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

        $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), 'Sin Cruce', false);
        $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

        $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), 'SI', false);
        $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

        $objHoja->setCellValueByColumnAndRow($numColumna++, ($numFila + 2), '', false);
        $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

        $numFila++;
        $numFilas++;

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
ob_end_clean();
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename='Detalles_" . $claCruces->arrDatos['txtNombre'] . "_" . date("YmdHis") . ".xlsx");
header('Cache-Control: max-age=0');
ob_end_clean();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');




?>