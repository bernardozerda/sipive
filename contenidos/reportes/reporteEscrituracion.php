<?php

/* * *********************************
 * PLANTILLA ESCRITURACION
 * @author LILIANA BASTO
 * @version 1.0 JULIO 2016
 * ********************************** */

function obtenerReporteEscrituracion($arrDocumentos) {
    require_once '../../librerias/phpExcel/Classes/PHPExcel.php';
    require_once '../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php';
    //PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
    $objPHPExcel = new PHPExcel();
//conexion

    $conexion = mysql_connect("localhost", "sdht_usuario", "Ochochar*1");
    mysql_set_charset('utf8', $conexion);
    mysql_select_db("sipive", $conexion);
    // mysql_select_db("sdth_subsidiosentrega", $conexion);

    $sql = "SELECT 
              ciu.numDocumento AS Documento,
              des.seqDesembolso AS desembolso, 
              frm.seqFormulario AS formulario, 
              des.txtNombreVendedor AS vendedor,
              des.numDocumentoVendedor AS docVendedor, 
              des.txtBarrio AS barrio,
              des.seqLocalidad AS localidad,
              des.bolViabilizoJuridico AS vJuridico,
              des.bolviabilizoTecnico AS vTecnico, 
             # des.bolPoseedor AS poseedor,
             # des.numActaEntrega AS numActa,
             # des.numCertificacionVendedor AS numCertVen, 
             # des.numAutorizacionDesembolso AS autorizaDes, 
              des.seqTipoDocumento AS seqTipoDoc,
              des.txtCompraVivienda AS compraVivienda, 
              des.txtTipoPredio AS tipoPredio,
              des.numTelefonoVendedor AS telVendedor,
              des.txtTipoDocumentos AS tipoDoc,
              des.numEstrato AS estrato,
              des.txtCiudad AS ciudad,              
             # des.fchCreacionBusquedaOferta AS fchCreacion,
             # des.fchActualizacionBusquedaOferta AS fchActualizacion,
              des.fchCreacionEscrituracion AS fchCreaEsc, 
              des.fchActualizacionEscrituracion As fchActEsc,
              des.numTelefonoVendedor2 AS telVen2,
              des.txtPropiedad AS propiedad,
             # des.fchSentencia AS fchSentencia,
             # des.numJuzgado AS juzgado,
             # des.numResolucion AS numResolucion,
             # des.fchResolucion AS fchResolucion,
              des.txtCorreoVendedor AS correoVen,
              des.seqCiudad AS seqCiudad,
              ciud.txtCiudad AS ciudad2,
              des.seqAplicacionSubsidio AS seqSubsidio,
              des.seqProyectosSoluciones AS seqProySol,
              des.txtDireccionInmueble AS direccion
            FROM T_FRM_FORMULARIO frm
            INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
            INNER JOIN T_CIU_CIUDADANO ciu ON ciu.seqCiudadano = hog.seqCiudadano           
            LEFT JOIN T_DES_FLUJO flu ON frm.seqFormulario = flu.seqFormulario
            LEFT JOIN T_DES_DESEMBOLSO des ON frm.seqFormulario = des.seqFormulario
            LEFT JOIN T_DES_SOLICITUD sol ON des.seqDesembolso = sol.seqDesembolso
            LEFT JOIN T_FRM_CIUDAD ciud ON des.seqCiudad = ciud.seqCiudad
            WHERE hog.seqParentesco = 1
            AND ciu.numDocumento IN ( " . implode(",", $arrDocumentos) . " )
         ";

    //echo $sql; die();
    $resultdl = mysql_query($sql, $conexion) or die(mysql_error());
    //echo $resultdl; die();
    $registros = mysql_num_rows($resultdl);
    $columnas = mysql_num_fields($resultdl);

    if ($registros > 0) {


        $arrNomCol = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC",
            "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ", "BA", "BB", "BC", "BD",
            "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM", "BN", "BO", "BP", "BQ", "BR", "BS", "BT", "BU", "BV", "BW", "BX", "BY", "BZ", "CA", "CB", "CC", "CD",
            "CE", "CF", "CG", "CH", "CI", "CJ", "CK", "CL", "CM", "CN", "CO", "CP", "CQ", "CR", "CS", "CT", "CU", "CV", "CW", "CX", "CY", "CZ", "DA", "DB", "DC", "DD",
            "DE", "DF", "DG", "DH", "DI", "DJ", "DK", "DL", "DM", "DN", "DO", "DP", "DQ", "DR", "DS", "DT", "DU", "DV", "DW", "DX", "DY", "DZ");

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
                'color' => array('rgb' => 'a9a9a9'),
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
        $tituloReporte = Array();
        $tituloReporte[1] = "Direccion del inmueble";
        $tituloReporte[2] = "Escritura";
        $tituloReporte[3] = "Fecha de la escritura";
        $tituloReporte[4] = "Notaria";
        $tituloReporte[5] = "Matricula Inmobiliaria";
        $tituloReporte[6] = "Chip";
        $tituloReporte[7] = "Cedula Catastral";
        $tituloReporte[8] = "Area(mts) Lote";
        $tituloReporte[9] = "Area(mts) Construida";
        $tituloReporte[10] = "Avaluo del inmueble";
        $tituloReporte[11] = "Valor inmueble";
        $tituloReporte[12] = "Tipo de predio";
        $tituloReporte[13] = "Estrato";
        $tituloReporte[14] = "Folio Escritura publica";
        $tituloReporte[15] = "Obs Escritura Publica";
        $tituloReporte[16] = "Folio de certificado de tradición";
        $tituloReporte[17] = "Obs Certificado de Tradicion";
        $tituloReporte[18] = "Folio carta asignación";
        $tituloReporte[19] = "Obs Carta de Asignacion";
        $tituloReporte[20] = "Folio Alto Riesgo";
        $tituloReporte[21] = "Obs Alto Riesgo";
        $tituloReporte[22] = "Folio Habitabilidad";
        $tituloReporte[23] = "Obs Habitabilidad";
        $tituloReporte[24] = "Folio Boletin Catastral.";
        $tituloReporte[25] = "Obs Boletin Catastral";
        $tituloReporte[26] = "Folio Licencia de Construcción";
        $tituloReporte[27] = "Obs Licencia de Construcción";
        $tituloReporte[28] = "Folio Ultimo predial";
        $tituloReporte[29] = "Obs Ultimo predial";
        $tituloReporte[30] = "Folio Ultimo Recibo de Agua";
        $tituloReporte[31] = "Obs Ultimo Recibo de Agua";
        $tituloReporte[32] = "Folio Ultimo Recibo de Energia";
        $tituloReporte[33] = "Obs Ultimo Recibo de Energia";
        $tituloReporte[34] = "Folio Acta Entrega";
        $tituloReporte[35] = "Obs Acta Entrega";
        $tituloReporte[36] = "Folio Certificado Vendedor";
        $tituloReporte[37] = "Obs Certificado Vendedor";
        $tituloReporte[38] = "Folio Autorizacion Desembolso";
        $tituloReporte[39] = "Obs Autorizacion Desembolso";
        $tituloReporte[40] = "Folio Fotocopia Vendedor";
        $tituloReporte[41] = "Obs Fotocopia Vendedor";
        $tituloReporte[42] = "Folio Rit";
        $tituloReporte[43] = "Obs Rit";
        $tituloReporte[44] = "Folio Rut";
        $tituloReporte[45] = "Obs Rut";
        $tituloReporte[46] = "Folio Nit";
        $tituloReporte[47] = "Obs Nit";
        $tituloReporte[48] = "Folio Otros";
        $tituloReporte[49] = "Obs Otros";
        $tituloReporte[50] = "Número Contrato Leasing";
        $tituloReporte[51] = "Fecha Contrato Leasing";
        $tituloReporte[52] = "Folios Contrato Leasing";
        $tituloReporte[53] = "Obs Contrato Leasing";


        //Cabecera del Archivo   
        $field = 0;
        while ($field !== $columnas) {
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . "1", mysql_field_name($resultdl, $field))->getRowDimension('1')->setRowHeight(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrNomCol[$field])->setAutoSize(true);
            $objPHPExcel->getProperties()->setCreator("HOO")->setLastModifiedBy("HOO");
            $objPHPExcel->getActiveSheet()->getStyle('A1:Y1')->applyFromArray($style_header);

            $field++;
        }
        $field = 25;
        $columnas30 = 78;
        $tiltle = 1;
        while ($field !== $columnas30) {
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . "1", $tituloReporte[$tiltle])->getRowDimension('1')->setRowHeight(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrNomCol[$field])->setAutoSize(true);
            $objPHPExcel->getProperties()->setCreator("HOO")->setLastModifiedBy("HOO");
            $objPHPExcel->getActiveSheet()->getStyle('Z1:BZ1')->applyFromArray($style_Mod);
            $field++;
            $tiltle++;
        }
        //Llenado del archivo  
        $rowcount = 2;
        while ($row = mysql_fetch_array($resultdl)) {

            $field = 0;
            while ($field !== $columnas) {
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . $rowcount, $row[$field]);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $rowcount . ':BZ' . $rowcount)->applyFromArray($styleArrayBody);
                $field++;
            }
            $rowcount++;
        }

        // formato de fechas
        $objPHPExcel->getActiveSheet()->getStyle("Q1:Q"   . $rowcount)->getNumberFormat()->setFormatCode("yyyy-mm-dd");
        $objPHPExcel->getActiveSheet()->getStyle("R1:R"   . $rowcount)->getNumberFormat()->setFormatCode("yyyy-mm-dd");
        $objPHPExcel->getActiveSheet()->getStyle("AB1:AB" . $rowcount)->getNumberFormat()->setFormatCode("yyyy-mm-dd");
        $objPHPExcel->getActiveSheet()->getStyle("BX1:BX" . $rowcount)->getNumberFormat()->setFormatCode("yyyy-mm-dd");

        //Protección de hoja
        $objPHPExcel->getSecurity()->setLockWindows(false);
        $objPHPExcel->getSecurity()->setLockStructure(false);
        $objPHPExcel->getSheet(0)->getProtection()->setSheet(true);
        $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
        $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
        $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);


        //desprotege las celdas editables
        $objPHPExcel->getActiveSheet()->getStyle('AA2:BZ' . ($registros + 1))->getProtection()
                ->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
        $objPHPExcel->getActiveSheet()->getStyle('AE2:AE' . ($registros + 1))->getProtection()
                ->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);



        //Autofit text
//       
        //Autosize Columnas
        for ($col = 'C'; $col !== 'K'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }


        $objPHPExcel->createSheet(1);
        $objPHPExcel->getSheet(1)->SetCellValue("AK2", "Urbano");
        $objPHPExcel->getSheet(1)->SetCellValue("AK3", "Rural");
        $objPHPExcel->addNamedRange(
                new PHPExcel_NamedRange(
                'seleccion', $objPHPExcel->getSheet(1), 'AK2:AK3'
                )
        );

        $objPHPExcel->getSheet(1)->SetCellValue("AL2", "Estrato 1");
        $objPHPExcel->getSheet(1)->SetCellValue("AL3", "Estrato 2");
//        $objPHPExcel->getSheet(1)->SetCellValue("AL4", "Estrato 3");
//        $objPHPExcel->getSheet(1)->SetCellValue("AL5", "Estrato 4");
//        $objPHPExcel->getSheet(1)->SetCellValue("AL6", "Estrato 5");
//        $objPHPExcel->getSheet(1)->SetCellValue("AL7", "Estrato 6");
        $objPHPExcel->addNamedRange(
                new PHPExcel_NamedRange(
                'seleccion1', $objPHPExcel->getSheet(1), 'AL2:AL3'
                )
        );

        $rowcount = 2;

        while ($rowcount !== ($registros + 2)) {
            $field = 36;
            while ($field == 36 || $field == 37) {

                $objValidation = $objPHPExcel->getActiveSheet()->getCell($arrNomCol[$field] . $rowcount)->getDataValidation();
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
                if ($field == 36) {
                    $objValidation->setFormula1("=seleccion");
                } else {
                    $objValidation->setFormula1("=seleccion1");
                }


                $field++;
            }
            $rowcount++;
        }

        //crea archivo Excel para descarga
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Plantilla escrituracion.xls"');
        //echo $objPHPExcel;
        $objWriter->save('php://output');
        exit;
    } else {
        echo '<span style="color:#c10;text-align:center;"><b>No hay registros!</b></span>';
    }
    mysql_close();
}

?>
