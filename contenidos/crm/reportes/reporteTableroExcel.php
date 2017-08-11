<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include './consultaTablero.php';
include '../../../recursos/archivos/lecturaConfiguracion.php';

informeProyectosActo();

//echo "<br>".calculaFecha("days",-1,$fec);

function informeProyectosActo() {
    global $arrConfiguracion;
    $seqEstado = $_GET['seqEstado'];
    $seqProyecto = $_GET['seqProyecto'];
    $tipo = $_GET['tipo'];
    $conexion = mysql_connect($arrConfiguracion['baseDatos']['servidor'], $arrConfiguracion['baseDatos']['usuario'], $arrConfiguracion['baseDatos']['clave']);
    mysql_set_charset('utf8', $conexion);
    mysql_select_db($arrConfiguracion['baseDatos']['nombre'], $conexion);
    require_once '../../../librerias/phpExcel/Classes/PHPExcel.php';
    require_once '../../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php';

    //PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
    $objPHPExcel = new PHPExcel();

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

    /* $sql = "SELECT pry.txtNombreProyecto, txtNombreUnidad, frm.seqFormulario, numDocumento, concat(txtNombre1, ' ', txtNombre1, ' ', txtApellido1, ' ', txtApellido2 ) AS postulante,
      txtEstadoProceso, fchRadicacion
      from t_pry_unidad_proyecto und
      INNER JOIN t_pry_proyecto pry ON(und.seqProyecto=pry.seqProyecto)
      INNER JOIN t_frm_formulario frm USING (seqFormulario)
      INNER JOIN t_frm_hogar hog USING(seqFormulario)
      INNER JOIN t_ciu_ciudadano USING(seqCiudadano)
      INNER JOIN t_frm_estado_proceso USING(seqEstadoProceso)
      where und.seqProyecto = 2  and seqEstadoProceso = 17 and seqParentesco = 1 "; */
    $sql = obtenerConsulta($seqEstado, $seqProyecto, $tipo);

    $resultdl = mysql_query($sql, $conexion) or die(mysql_error());
    $columnas = mysql_num_fields($resultdl);

    $arrNomCol = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC",
        "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ");

    $tituloReporte = Array();
    //$tituloReporte[0] = "ID del Proyecto";
    $tituloReporte[0] = "Nombre del Proyecto";
    $tituloReporte[1] = "Unidad";
    $tituloReporte[2] = "seqFormulario";
    $tituloReporte[3] = "CC Post ppal";
    $tituloReporte[4] = "Nombre post ppal";
    $tituloReporte[5] = "estado";
    $tituloReporte[6] = "fecha radicacion";
    $tituloReporte[7] = "Fecha indicador";



    $totalColumnas = count($tituloReporte);
    $field = 0;
    //$columnas = 6;
    $tiltle = 0;
    $titulos = 9;
    $valorTotal = 0;

    while ($field !== $titulos) {
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . "1", $tituloReporte[$tiltle])->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension($arrNomCol[$field])->setAutoSize(true);
        $objPHPExcel->getProperties()->setCreator("HOO")->setLastModifiedBy("HOO");
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $arrNomCol[$field] . '1')->applyFromArray($style_header);


        $field++;
        $tiltle++;
    }
    try {

        $rowcount = 2;
        while ($row = mysql_fetch_array($resultdl)) {

            $field = 0;
            while ($field !== $columnas) {
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . $rowcount, $row[$field]);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $rowcount . ':I' . $rowcount)->applyFromArray($styleArrayBody);
                $field++;
            }
            $rowcount++;
        }

        // echo $rowsTotal;
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="ReporteTablero.xlsx"');
        $objWriter->save('php://output');
        exit;
    } catch (Exception $objError) {
        return $objError->msg;
    }
}

//function obtenerDatosTablero() {
//    
//}
