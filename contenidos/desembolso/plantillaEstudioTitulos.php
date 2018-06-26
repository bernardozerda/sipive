<?php

/* * *********************************
 * PLANTILLA ESTUDIO DE TITULOS
 * @author Andres Martinez
 * @version 1.0 Marzo 2016
 * ********************************** */

//ini_set('memory_limit','256M');

function plantillaestudiotitulos($seqFormularios) {
    global $arrConfiguracion;

    require_once '../../librerias/clases/PHPExcel.php';
    require_once '../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php';
    //PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
    $objPHPExcel = new PHPExcel();
//conexion
    $conexion = mysql_connect($arrConfiguracion['baseDatos']['servidor'], $arrConfiguracion['baseDatos']['usuario'], $arrConfiguracion['baseDatos']['clave']);
    mysql_set_charset('utf8', $conexion);
    mysql_select_db($arrConfiguracion['baseDatos']['nombre'], $conexion);

    $sqlObtenerFormActo = "SELECT seqFormularioActo
    FROM  t_aad_formulario_acto tafa     where seqFormulario in(" . $seqFormularios . ") and tafa.seqFormularioActo in 
(select max(seqFormularioActo) from  t_aad_formulario_acto left join T_AAD_HOGARES_VINCULADOS using(seqFormularioActo) where seqFormulario in (" . $seqFormularios . ") and seqTipoActo = 1  group by seqFormulario)";
    $resultdObtenerFormActo = mysql_query($sqlObtenerFormActo, $conexion) or die(mysql_error());
    $seqFormularioActo = "";
    while($reqSeqFormularioActo = mysql_fetch_array($resultdObtenerFormActo)){
        $seqFormularioActo .= $reqSeqFormularioActo['seqFormularioActo'] . ",";
    }
    $seqFormularioActo = rtrim($seqFormularioActo,",");

    $sqlSeqEscrituracion = "select seqEscrituracion from t_des_escrituracion where seqFormulario in (" . $seqFormularios . ") and seqEscrituracion in 
(select max(seqEscrituracion) from  t_des_escrituracion where seqFormulario in (" . $seqFormularios . ") group by seqFormulario); ";
    $resultdSeqEscrituracion = mysql_query($sqlSeqEscrituracion, $conexion) or die(mysql_error());
    $seqEscrituracion = "";
    while($reqSeqEscrituracion = mysql_fetch_array($resultdSeqEscrituracion)){
        $seqEscrituracion .= $reqSeqEscrituracion['seqEscrituracion'] . ",";
    }
    $seqEscrituracion = rtrim($seqEscrituracion,",");

    $sql = "SELECT T_DES_ESCRITURACION.seqFormulario AS 'ID HOGAR', T_CIU_CIUDADANO.numDocumento AS 'CC POSTULANTE PRINCIPAL', T_CIU_TIPO_DOCUMENTO.txtTipoDocumento AS 'TIPO DE DOCUMENTO', UPPER(CONCAT(T_CIU_CIUDADANO.txtNombre1, ' ', T_CIU_CIUDADANO.txtNombre2, ' ', T_CIU_CIUDADANO.txtApellido1, ' ', T_CIU_CIUDADANO.txtApellido2)) AS 'NOMBRE POSTULANTE PRINCIPAL', T_PRY_PROYECTO.txtNombreProyecto AS 'PROYECTO', T_DES_ESCRITURACION.txtNombreVendedor AS 'PROPIETARIO', T_FRM_FORMULARIO.seqUnidadProyecto AS 'seqUnidadProyecto', T_PRY_UNIDAD_PROYECTO.txtNombreUnidad AS 'txtnombreunidad', T_DES_ESCRITURACION.txtDireccionInmueble AS 'DIRECCION INMUEBLE', T_PRY_TECNICO.txtexistencia AS 'CERTIFICADO DE EXISTENCIA Y HABITABILIDAD', T_DES_ESCRITURACION.txtEscritura AS 'ESCRITURA REGISTRADA', T_DES_ESCRITURACION.fchEscritura AS 'FECHA ESCRITURA', T_DES_ESCRITURACION.numNotaria AS 'NOTARIA', T_DES_ESCRITURACION.txtCiudad AS 'CIUDAD NOTARIA', T_DES_ESCRITURACION.txtMatriculaInmobiliaria AS 'FOLIO DE MATRICULA', T_DES_ESCRITURACION.numValorInmueble AS 'VALOR INMUEBLE', T_AAD_HOGARES_VINCULADOS.numActo AS 'NUMERO DEL ACTO', DATE_FORMAT(T_AAD_HOGARES_VINCULADOS.fchacto,'%d-%m-%Y') AS 'FECHA DEL ACTO', '' AS 'No. ESCRITURA', '' AS 'FECHA ESCRITURA (D/M/A)', '' AS 'NOTARIA', '' AS 'CIUDAD NOTARIA', '' AS 'FOLIO DE MATRICULA', '' AS 'ZONA OFICINA REGISTRO', '' AS 'CIUDAD OFICINA REGISTRO', '' AS 'FECHA FOLIO (D/M/A)', '' AS 'RESOLUCION DE VINCULACION COINCIDENTE', '' AS 'BENEFICIARIOS DEL SDV COINCIDENTES', '' AS 'NOMBRE Y CEDULA DE LOS PROPIETARIOS EN EL CTL INCIDENTES', '' AS 'CONSTITUCION PATRIMONIO FAMILIA', '' AS 'INDAGACION AFECTACION A VIVIENDA FAMILIAR', '' AS 'RESTRICCIONES', '' AS 'ESTADO CIVIL COINCIDENTE', '' AS 'CARTA DE VINCULACION Y/O RESOLUCION PROTOCOLIZADA', '' AS 'No. DE ANOTACION CTL COMPRAVENTA', '' AS 'SE CANCELA HIPOTECA MAYOR EXTENSION (SI LA HUBIERE)', '' AS 'PATRIMONIO DE FAMILIA REGISTRADO', '' AS 'PROHIBICION DE TRANSFERENCIA Y DERECHO DE PREFERENCIA REGISTRADOS', '' AS 'IMPRESION DE CONSULTA FONVIVIENDA (HOGARES VICTIMAS)', '' AS 'ELABORO', '' AS 'APROBO', '' AS 'SE VIABILIZA JURIDICAMENTE', '' AS 'OBSERVACION'
FROM T_DES_ESCRITURACION
INNER JOIN T_FRM_FORMULARIO ON (T_DES_ESCRITURACION.seqFormulario = T_FRM_FORMULARIO.seqFormulario)
INNER JOIN T_FRM_HOGAR ON (T_FRM_FORMULARIO.seqFormulario = T_FRM_HOGAR.seqFormulario)
INNER JOIN T_CIU_CIUDADANO ON (T_CIU_CIUDADANO.seqCiudadano = T_FRM_HOGAR.seqCiudadano)
INNER JOIN T_CIU_TIPO_DOCUMENTO ON (T_CIU_CIUDADANO.seqTipoDocumento = T_CIU_TIPO_DOCUMENTO.seqTipoDocumento)
LEFT JOIN T_PRY_UNIDAD_PROYECTO ON (T_FRM_FORMULARIO.seqFormulario = T_PRY_UNIDAD_PROYECTO.seqFormulario)
LEFT JOIN T_PRY_PROYECTO ON (T_PRY_PROYECTO.seqProyecto = T_PRY_UNIDAD_PROYECTO.seqProyecto)
LEFT JOIN T_PRY_TECNICO ON (T_FRM_FORMULARIO.seqUnidadProyecto = T_PRY_TECNICO.seqUnidadProyecto)
INNER JOIN T_AAD_FORMULARIO_ACTO ON (T_FRM_FORMULARIO.seqFormulario = T_AAD_FORMULARIO_ACTO.seqFormulario)
INNER JOIN T_AAD_HOGARES_VINCULADOS ON (T_AAD_FORMULARIO_ACTO.seqFormularioActo = T_AAD_HOGARES_VINCULADOS.seqFormularioActo)
WHERE T_FRM_HOGAR.seqParentesco = 1 AND T_DES_ESCRITURACION.seqFormulario IN (" . $seqFormularios . ")"
            . " AND seqTipoActo = 1 and T_AAD_FORMULARIO_ACTO.seqFormularioActo in(" . $seqFormularioActo . ") and  T_DES_ESCRITURACION.seqEscrituracion in (" . $seqEscrituracion . ")"
            . " order by  T_DES_ESCRITURACION.seqEscrituracion, T_AAD_FORMULARIO_ACTO.seqFormularioActo desc";

//echo $sql;
//       die();

    $resultdl = mysql_query($sql, $conexion) or die(mysql_error());
    //echo $resultdl; die();
    $registros = mysql_num_rows($resultdl);
    $columnas = mysql_num_fields($resultdl);
//echo $registros;
    if ($registros > 0) {


        $arrNomCol = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ");

        //Cabecera del Archivo   
        $field = 0;
        while ($field !== $columnas) {
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . "1", mysql_field_name($resultdl, $field));
            $field++;
        }

        //Llenado del archivo  
        $rowcount = 2;
        while ($row = mysql_fetch_array($resultdl)) {

            $field = 0;
            while ($field !== $columnas) {
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . $rowcount, $row[$field]);
                $field++;
            }
            $rowcount++;
        }

        //Protección de hoja 
        $objPHPExcel->getSecurity()->setLockWindows(false);
        $objPHPExcel->getSecurity()->setLockStructure(false);
        $objPHPExcel->getSheet(0)->getProtection()->setSheet(true);
        $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
        $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
        $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
        $objPHPExcel->getActiveSheet()->getProtection()->setPassword('SDHT');

        //desprotege las celdas editables
        $objPHPExcel->getActiveSheet()->getStyle('S2:AQ' . ($registros + 1))->getProtection()
                ->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

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
                ),
            ),
        );

        //Autofit text
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $arrNomCol[($columnas - 1)] . '1')->getAlignment()->setWrapText(true);

        //Aplica estilo por defecto al cuerpo de la tabla a partir del array
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $arrNomCol[($columnas - 1)] . ($registros + 1))->applyFromArray($styleArrayBody);

        //Alto Celdas solo Cabecera
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(70);
        //Ancho Celdas 
        $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(15);
        //Alineacion Celdas Cabecera
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $arrNomCol[($columnas - 1)] . '1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $arrNomCol[($columnas - 1)] . '1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //Creacion de rango de seleccion de desplegable (SI - NO)
        $objPHPExcel->createSheet(1);
        $objPHPExcel->getSheet(1)->SetCellValue("AZ2", "SI");
        $objPHPExcel->getSheet(1)->SetCellValue("AZ3", "NO");
        $objPHPExcel->getSheet(1)->SetCellValue("AZ4", "NO APLICA");
        $objPHPExcel->addNamedRange(
                new PHPExcel_NamedRange(
                'seleccion', $objPHPExcel->getSheet(1), 'AZ2:AZ4'
                )
        );
        //Creacion de rango de seleccion de desplegable (SI - NO Aplica)
        $objPHPExcel->getSheet(1)->SetCellValue("BA2", "SI");
        $objPHPExcel->getSheet(1)->SetCellValue("BA3", "NO APLICA");
        $objPHPExcel->addNamedRange(
                new PHPExcel_NamedRange(
                'seleccion1', $objPHPExcel->getSheet(1), 'BA2:BA3'
                )
        );
        //Autosize Columnas
        for ($col = 'C'; $col !== 'K'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }
        //estilo encabezado blanco
        $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);

        //estilo encabezado gris
        $objPHPExcel->getActiveSheet()->getStyle('S1:AQ1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('S1:AQ1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('S1:AQ1')->getFill()->getStartColor()->setARGB('a9a9a9');

        //estilo encabezado rojo
        $objPHPExcel->getActiveSheet()->getStyle('AA1:AC1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('AA1:AC1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('AA1:AC1')->getFill()->getStartColor()->setARGB('FF0000');

//configuracion de validacion de desplegables en las columnas correspondientes  AA - AP
        $rowcount = 2;
        while ($rowcount !== ($registros + 2)) {
            $field = 26;
            while ($field !== 42) {

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
                $objValidation->setFormula1("=seleccion");

                $field++;
            }
            $rowcount++;
        }

        //  Cambia la configuracion de celdas para las que no tienen formato de validacion y las que tienen validacion distinta  
        $rowcount = 2;
        while ($rowcount !== ($registros + 2)) {

            $objPHPExcel->getActiveSheet()->getCell('AI' . $rowcount)->getDataValidation()->setType(PHPExcel_Cell_DataValidation::TYPE_NONE);
            $objPHPExcel->getActiveSheet()->getCell('AI' . $rowcount)->getDataValidation()->setPrompt('');
            $objPHPExcel->getActiveSheet()->getCell('AK' . $rowcount)->getDataValidation()->setFormula1("=seleccion1");
            $objPHPExcel->getActiveSheet()->getCell('AM' . $rowcount)->getDataValidation()->setFormula1("=seleccion1");
            $objPHPExcel->getActiveSheet()->getCell('AN' . $rowcount)->getDataValidation()->setType(PHPExcel_Cell_DataValidation::TYPE_NONE);
            $objPHPExcel->getActiveSheet()->getCell('AN' . $rowcount)->getDataValidation()->setPrompt('');
            $objPHPExcel->getActiveSheet()->getCell('AO' . $rowcount)->getDataValidation()->setType(PHPExcel_Cell_DataValidation::TYPE_NONE);
            $objPHPExcel->getActiveSheet()->getCell('AO' . $rowcount)->getDataValidation()->setPrompt('');
            $objPHPExcel->getActiveSheet()->getCell('AQ' . $rowcount)->getDataValidation()->setType(PHPExcel_Cell_DataValidation::TYPE_NONE);
            $objPHPExcel->getActiveSheet()->getCell('AQ' . $rowcount)->getDataValidation()->setPrompt('');
            $rowcount++;
        }

        //crea archivo Excel para descarga
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Plantilla estudio titulos.xlsx"');
        $objWriter->save('php://output');
        exit;
    } else {
        echo '<span style="color:#c10;text-align:center;"><b>No hay registros!</b></span>';
    }
    mysql_close();
}

?>