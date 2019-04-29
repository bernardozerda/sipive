<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
require_once $txtPrefijoRuta . 'librerias/clases/optimizacionFac.class.php';
require_once $txtPrefijoRuta . 'librerias/clases/Reportes.class.php';
require_once '../../librerias/phpExcel/Classes/PHPExcel.php';
require_once '../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php';
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$claFac = new optimizacionFac();
$claReportes = new Reportes();

$tipo = $_REQUEST['tipo'];
if ($_REQUEST['volver'] == 1) {
    if ($tipo == 1) {
        $estados = implode(",", $_POST['estados']);       
        $response = $claFac->crearTablaFacAsig($estados, $tipo);
        if ($response)
            echo true;
    }else if ($tipo == 2 || $tipo == 3) {
        $estados = implode(",", $_POST['estados']);
        $response = $claFac->SalvarInhabilitados($estados, $tipo);
        if ($response)
            echo true;
    }else if ($tipo == 4 || $tipo == 5 || $tipo == 6) {
        if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
            $txtTipoArchivo = PHPExcel_IOFactory::identify($_FILES['archivo']['tmp_name']);
            $name = basename($_FILES['archivoEstado']['name']);
            $objReader = PHPExcel_IOFactory::createReader($txtTipoArchivo);
            $objPHPExcel = $objReader->load($_FILES['archivo']['tmp_name']);
            $objHoja = $objPHPExcel->getSheet(0);

            $numFilas = $objHoja->getHighestRow();
            $numColumnas = PHPExcel_Cell::columnIndexFromString($objHoja->getHighestColumn()) - 1;
            $value = "";
            for ($numFila = 1; $numFila <= $numFilas; $numFila++) {
                if ($numFila != 1) {
                    $numFilaArreglo = $numFila - 1;
                    $letra = chr(65 + ($numColumna));
                    $seqFormulario = ($objHoja->getCellByColumnAndRow(0, $numFila)->getValue() == '') ? 'NULL' : $objHoja->getCellByColumnAndRow(0, $numFila)->getValue();
                    $nit = $objHoja->getCellByColumnAndRow(1, $numFila)->getValue();
                    $entidad = $objHoja->getCellByColumnAndRow(2, $numFila)->getValue();
                    $txtTipoDocumento = $objHoja->getCellByColumnAndRow(3, $numFila)->getValue();
                    $numDocumento = $objHoja->getCellByColumnAndRow(4, $numFila)->getValue();
                    $txtNombreCiudadano = $objHoja->getCellByColumnAndRow(5, $numFila)->getValue();
                    $fchActo = ($objHoja->getCellByColumnAndRow(6, $numFila)->getValue() == '') ? 'NULL' : $objHoja->getCellByColumnAndRow(6, $numFila)->getValue();
                    if ($fchActo != 'NULL') {

                        $fchActo = "'" . PHPExcel_Style_NumberFormat::toFormattedString($fchActo, 'YYYY-MM-DD') . "'";
                    }


                    $txtObservacion = $objHoja->getCellByColumnAndRow(8, $numFila)->getValue();

                    $value .="($seqFormulario, $nit, '$entidad', '$txtTipoDocumento', $numDocumento,'$txtNombreCiudadano', $fchActo, 0, 0, $tipo, '$txtObservacion'),";
                    //$arrArchivo[$numFilaArreglo][$numColumna] = $objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue();
                }
            }
            //echo $value;
            $response = $claFac->insertarFACFile($value);
            if ($response)
                echo true;
            //var_dump($arrArchivo);
            // DIE();
        }
    }else if ($tipo == 7) {
        $estados = implode(",", $_POST['estados']);
        $response = $claFac->SalvarPostulados($estados, $tipo);
        if ($response)
            echo true;
    }else if ($tipo == 8) {

        //$estados = implode(",", $_POST['estados']);
        $response = $claFac->GenerarReporte();
        $txtNombreArchivo = $nombreArchivo . date("Ymd_His") . ".xls";
        $claReportes->obtenerReportesGeneral($response, "reporteINV..");

        /*$objPHPExcel1 = new PHPExcel();
        $tituloReporte = Array();
        $tituloReporte[0] = "ID Hogar";
        $tituloReporte[1] = "Nombre";
        $tituloReporte[2] = "Hogar Victima";
        $tituloReporte[3] = "Documento";
        $tituloReporte[4] = "Tipo Documento";
        $tituloReporte[5] = "Parentesco";
        $tituloReporte[6] = "Sexo";
        $tituloReporte[7] = "Estado Civil";
        $tiltle = 0;
        $titulos = 8;
        $arrNomCol = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC",
            "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ");

        while ($field !== $titulos) {
            $objPHPExcel1->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . 1, $tituloReporte[$tiltle]);
            
            $objPHPExcel1->getActiveSheet()->getColumnDimension($arrNomCol[$field])->setAutoSize(true);
            $objPHPExcel1->getProperties()->setCreator("HOO")->setLastModifiedBy("HOO");
          //  $objPHPExcel->getActiveSheet()->getStyle('A1:' . $arrNomCol[$field] . '1')->applyFromArray($style_header);
            $field++;
            $tiltle++;
        }
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel1);
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="InformacionCVP.xlsx"');
        $objWriter->save('php://output');
        exit;*/


        /* if ($response)
          echo true; */
    }
} else {
    
    $tipo = $tipo - 1;
    $response = $claFac->eliminarTablaFac($tipo);
    if ($response)
        echo true;
}


