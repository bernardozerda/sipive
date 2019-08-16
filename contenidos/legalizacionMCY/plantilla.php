<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "aadTipo.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );

// numero de filas vacias a formatear

$numFilasFormatear = (isset($_GET['filas']) and $_GET['filas'] != "") ? $_GET['filas'] : 100;

//Se carga los titulos de la plantilla
$arrTitulos[0]['nombre'] = "No";
$arrTitulos[0]['tipo'] = "texto";
$arrTitulos[1]['nombre'] = "ID HOGAR";
$arrTitulos[1]['tipo'] = "texto";
$arrTitulos[2]['nombre'] = "TIPO DOC PPAL";
$arrTitulos[2]['tipo'] = "texto";
$arrTitulos[3]['nombre'] = "DOCUMENTO PPAL";
$arrTitulos[3]['tipo'] = "texto";
$arrTitulos[4]['nombre'] = "NOMBRES";
$arrTitulos[4]['tipo'] = "texto";
$arrTitulos[5]['nombre'] = "APELLIDOS";
$arrTitulos[5]['tipo'] = "texto";
$arrTitulos[6]['nombre'] = "TIPO DOC VENDEDOR";
$arrTitulos[6]['tipo'] = "texto";
$arrTitulos[7]['nombre'] = "No DOCUMENTO VENDEDOR";
$arrTitulos[7]['tipo'] = "texto";
$arrTitulos[8]['nombre'] = "NOMBRE VENDEDOR";
$arrTitulos[8]['tipo'] = "texto";
$arrTitulos[9]['nombre'] = "NOMBRE DEL PROYECTO";
$arrTitulos[9]['tipo'] = "texto";
$arrTitulos[10]['nombre'] = "DEPARTAMENTO";
$arrTitulos[10]['tipo'] = "texto";
$arrTitulos[11]['nombre'] = "MUNICIPIO";
$arrTitulos[11]['tipo'] = "texto";
$arrTitulos[12]['nombre'] = "TITULAR CUENTA";
$arrTitulos[12]['tipo'] = "texto";
$arrTitulos[13]['nombre'] = "TIPO DOC TITULAR";
$arrTitulos[13]['tipo'] = "texto";
$arrTitulos[14]['nombre'] = "DOCUMENTO TITULAR";
$arrTitulos[14]['tipo'] = "numero";
$arrTitulos[15]['nombre'] = "ENTIDAD FINANCIERA";
$arrTitulos[15]['tipo'] = "texto";
$arrTitulos[16]['nombre'] = "TIPO CUENTA";
$arrTitulos[16]['tipo'] = "texto";
$arrTitulos[17]['nombre'] = "No DE CUENTA";
$arrTitulos[17]['tipo'] = "texto";
$arrTitulos[18]['nombre'] = "No ACTO ADMON";
$arrTitulos[18]['tipo'] = "texto";
$arrTitulos[19]['nombre'] = "RANGO INGRESOS";
$arrTitulos[19]['tipo'] = "texto";
$arrTitulos[20]['nombre'] = "FECHA ACTO ADMON";
$arrTitulos[20]['tipo'] = "fecha";
$arrTitulos[21]['nombre'] = "VALOR SUBSIDIO";
$arrTitulos[21]['tipo'] = "texto";
$arrTitulos[22]['nombre'] = "CONSECUTIVO";
$arrTitulos[22]['tipo'] = "texto";
$arrTitulos[23]['nombre'] = "FECHA AUTORIZACION";
$arrTitulos[23]['tipo'] = "fecha";
$arrTitulos[24]['nombre'] = "DIRECCION VENDEDOR";
$arrTitulos[24]['tipo'] = "texto";
$arrTitulos[25]['nombre'] = "TELEFONO1 VENDEDOR";
$arrTitulos[25]['tipo'] = "numero";
$arrTitulos[26]['nombre'] = "TELEFONO2 VENDEDOR";
$arrTitulos[26]['tipo'] = "numero";
$arrTitulos[27]['nombre'] = "CORREO VENDEDOR";
$arrTitulos[27]['tipo'] = "texto";
$arrTitulos[28]['nombre'] = "DIRECCION INMUEBLE";
$arrTitulos[28]['tipo'] = "texto";
$arrTitulos[29]['nombre'] = "BARRIO INMUEBLE";
$arrTitulos[29]['tipo'] = "texto";
$arrTitulos[30]['nombre'] = "LOCALIDAD INMUEBLE";
$arrTitulos[30]['tipo'] = "texto";
$arrTitulos[30]['rango'][] = "1-Usaquén";
$arrTitulos[30]['rango'][] = "10-Engativá";
$arrTitulos[30]['rango'][] = "11-Suba";
$arrTitulos[30]['rango'][] = "12-Barrios Unidos";
$arrTitulos[30]['rango'][] = "14-Los Mártires";
$arrTitulos[30]['rango'][] = "15-Antonio Nariño";
$arrTitulos[30]['rango'][] = "16-Puente Aranda";
$arrTitulos[30]['rango'][] = "17-La Candelaria";
$arrTitulos[30]['rango'][] = "18-Rafael Uribe Uribe";
$arrTitulos[30]['rango'][] = "19-Ciudad Bolívar";
$arrTitulos[30]['rango'][] = "2-Chapinero";
$arrTitulos[30]['rango'][] = "3-Santa Fe";
$arrTitulos[30]['rango'][] = "4-San Cristóbal";
$arrTitulos[30]['rango'][] = "5-Usme";
$arrTitulos[30]['rango'][] = "6-Tunjuelito";
$arrTitulos[30]['rango'][] = "7-Bosa";
$arrTitulos[30]['rango'][] = "8-Kennedy";
$arrTitulos[30]['rango'][] = "9-Fontibón";
$arrTitulos[30]['rango'][] = "1-Desconocido";
$arrTitulos[31]['nombre'] = "OPCION LEASING";
$arrTitulos[31]['tipo'] = "texto";
$arrTitulos[31]['rango'][] = "SELECCIONE";
$arrTitulos[31]['rango'][] = "SI";
$arrTitulos[31]['rango'][] = "NO";
$arrTitulos[32]['nombre'] = "No DE ESCRITURA";
$arrTitulos[32]['tipo'] = "texto";
$arrTitulos[33]['nombre'] = "FECHA ESCRITURA";
$arrTitulos[33]['tipo'] = "fecha";
$arrTitulos[34]['nombre'] = "NOTARIA";
$arrTitulos[34]['tipo'] = "texto";
$arrTitulos[35]['nombre'] = "VALOR INMUEBLE";
$arrTitulos[35]['tipo'] = "texto";
$arrTitulos[36]['nombre'] = "MATRICULA INMOBILIARIA";
$arrTitulos[36]['tipo'] = "texto";
$arrTitulos[37]['nombre'] = "ZONA DE MATRICULA";
$arrTitulos[37]['tipo'] = "texto";
$arrTitulos[37]['rango'][] = "CENTRO";
$arrTitulos[37]['rango'][] = "NORTE";
$arrTitulos[37]['rango'][] = "SUR";
$arrTitulos[38]['nombre'] = "FECHA CTL";
$arrTitulos[38]['tipo'] = "fecha";
$arrTitulos[39]['nombre'] = "No CONTRATO LEASING";
$arrTitulos[39]['tipo'] = "texto";
$arrTitulos[40]['nombre'] = "FECHA CONTRATO LEASING";
$arrTitulos[40]['tipo'] = "fecha";
$arrTitulos[41]['nombre'] = "ELABORO";
$arrTitulos[41]['tipo'] = "texto";
$arrTitulos[42]['nombre'] = "REVISO";
$arrTitulos[42]['tipo'] = "texto";
$arrTitulos[43]['nombre'] = "APROBO";
$arrTitulos[43]['tipo'] = "texto";


// fuentes para el archivo
$arrFuentes['default']['font']['name'] = "Calibri";
$arrFuentes['default']['font']['size'] = 10;
$arrFuentes['titulo']['fill']['type'] = PHPExcel_Style_Fill::FILL_SOLID;
$arrFuentes['titulo']['font']['bold'] = true;
$arrFuentes['titulo']['font']['color'] = array('rgb' => 'FFFFFF');

// Creacion del libro de excel
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("SiPIVE - SDHT");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle(mb_substr(mb_ereg_replace("[^0-9A-Za-z\ ]", "", "Legalizacion"), 0, 30)); // titulo de excel limitado a 30 caracteres
$objPHPExcel->getDefaultStyle()->applyFromArray($arrFuentes['default']);

// Protege la hoja para que no se modifiquen celdas inecesarias
$objPHPExcel->getSecurity()->setLockWindows(false);
$objPHPExcel->getSecurity()->setLockStructure(false);
//$objPHPExcel->getSheet(0)->getProtection()->setSheet(true);
//$objPHPExcel->getActiveSheet()->getProtection()->setPassword($arrConfiguracion['baseDatos']['clave']);
/* $objPHPExcel->getActiveSheet()->getStyle("A2:" . PHPExcel_Cell::stringFromColumnIndex(count($claTipoActo->arrFormatoArchivo) - 1) . $numFilasFormatear)
  ->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED); */

// coloca los titulos
foreach ($arrTitulos as $numColumna => $arrTitulo) {
    $arrFuentes['titulo']['fill']['color'] = ($numColumna > 21 ) ? array('rgb' => '#004080') : array('rgb' => 'E4E4E4');
    $arrFuentes['titulo']['font']['color'] = ($numColumna > 21 ) ? array('rgb' => 'FFFFFF') : array('rgb' => '000000');
    // coloca el texto del titulo
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($numColumna, 1, $arrTitulo['nombre'], flase);

    // coloca la ayuda (si existe)
    if (isset($arrTitulo['ayuda'])) {
        $claFuente = new PHPExcel_Style_Font();
        $claFuente->setSize(8);
        $objPHPExcel->getActiveSheet()->getCommentByColumnAndRow($numColumna, 1)->getText()->createTextRun($arrTitulo['ayuda'])->setFont($claFuente);
        $objPHPExcel->getActiveSheet()->getCommentByColumnAndRow($numColumna, 1)->setHeight('80pt');
        $objPHPExcel->getActiveSheet()->getCommentByColumnAndRow($numColumna, 1)->setWidth('120pt');
    }

    // estilos
    $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($numColumna)->setAutoSize(true);

    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($numColumna, 1)->applyFromArray($arrFuentes['titulo']);
}

// da formato a las celdas de acuerdo con el formato de los titulos
// si la celda tiene un rango de valores coloca una lista desplegable
// para limitar los valores

for ($i = 2; $i <= $numFilasFormatear; $i++) {
    $bolImprimirRango = true;
    foreach ($arrTitulos as $numColumna => $arrTitulo) {
        $letra = chr(65 + ($numColumna + 23));

        switch ($arrTitulo['tipo']) {
            case "numero":
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($numColumna, $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                break;
            case "fecha":
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($numColumna, $i)->getNumberFormat()->setFormatCode("yyyy-mm-dd");
                break;
        }

        if (isset($arrTitulo['rango'])) {

            // pone un combo en la celda con los valores válidos y restringe la inclusion de valores difrentes
            $objValidacion = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($numColumna, $i)->getDataValidation();
            $objValidacion->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidacion->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
            $objValidacion->setAllowBlank(false);
            $objValidacion->setShowInputMessage(true);
            $objValidacion->setShowErrorMessage(true);
            $objValidacion->setShowDropDown(true);
            $objValidacion->setErrorTitle("Error de datos");
            $objValidacion->setError("El valor digitado no es válido");
            $objValidacion->setPromptTitle("Los valores válidos son:");

            if ($numColumna == 30) {
                $objValidacion->setFormula1('"' . implode(",", ["1-Usaquén", "3-Santa Fe", "4-San Cristóbal", "5-Usme", "6-Tunjuelito", "7-Bosa", "8-Kennedy", "9-Fontibón", "10-Engativá", "11-Suba", "12-Barrios Unidos", "14-Los Mártires", "15-Antonio Nariño", "17-La Candelaria", "18-Rafael Uribe Uribe", "19-Ciudad Bolívar"]) . '"');
            } else if ($numColumna == 37) {
                $objValidacion->setFormula1('"' . implode(",", ["CENTRO", "NORTE", "SUR"]) . '"');
            } else {
                $objValidacion->setFormula1('"' . implode(",", ["SI", "NO"]) . '"');
            }
        }

        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($numColumna)->setAutoSize(true);
    }
}

// *************************** EXPORTA LOS RESULTADOS *************************************************************** //

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=Plantilla_Legalizacion_MCY_" . date("ymdHis") . ".xlsx");
header('Cache-Control: max-age=0');
ob_end_clean();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>