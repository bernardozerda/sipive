<?php

function informeProyectosActo() {

    $conexion = mysql_connect("localhost", "sdht_usuario", "Ochochar*1");
    mysql_set_charset('utf8', $conexion);
    mysql_select_db("sipive", $conexion);
    require_once '../../librerias/phpExcel/Classes/PHPExcel.php';
    require_once '../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php';

    PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
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

    $sql = "SELECT pry.seqProyecto, txtNombreProyecto, txtNombreOferente, numActo, YEAR( fchActo ) AS fecha, COUNT( seqTipoActoUnidad ) AS numeroUnidades, SUM( valIndexado ) AS valorAsignado
            FROM T_PRY_AAD_UNIDAD_ACTO
            LEFT JOIN T_PRY_AAD_UNIDADES_VINCULADAS ON ( T_PRY_AAD_UNIDAD_ACTO.seqUnidadActo = T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadActo ) 
            LEFT JOIN T_PRY_UNIDAD_PROYECTO uni ON ( T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadProyecto = uni.seqUnidadProyecto ) 
            LEFT JOIN T_PRY_PROYECTO pry ON ( uni.seqProyecto = pry.seqProyecto ) 
            LEFT JOIN t_pry_entidad_oferente tpeo ON ( tpeo.seqProyecto = pry.seqProyecto ) 
            WHERE seqTipoActoUnidad =1
            GROUP BY txtNombreProyecto";
    $resultd = mysql_query($sql, $conexion) or die(mysql_error());
    $registros = mysql_num_rows($resultd);
    $columnas = mysql_num_fields($resultd);
    $sqlYear = "SELECT YEAR(fchActo) AS fecha
  FROM T_PRY_AAD_UNIDAD_ACTO
       LEFT JOIN T_PRY_AAD_UNIDADES_VINCULADAS
          ON (T_PRY_AAD_UNIDAD_ACTO.seqUnidadActo =
                 T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadActo)
       LEFT JOIN T_PRY_UNIDAD_PROYECTO uni
          ON (T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadProyecto =
                 uni.seqUnidadProyecto)
       LEFT JOIN T_PRY_PROYECTO pry ON (uni.seqProyecto = pry.seqProyecto)
 WHERE seqTipoActoUnidad = 2
GROUP BY fecha, numActo
ORDER BY fchActo ASC";
    $objYear = mysql_query($sqlYear, $conexion) or die(mysql_error());
    //$objYear = $aptBd->execute($sqlYear);
    $registrosIndx = mysql_num_rows($objYear);
    $columnasIndex = mysql_num_fields($objYear);



    $arrNomCol = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC",
            "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ");

    $tituloReporte = Array();
    $tituloReporte[0] = "ID del Proyecto";
    $tituloReporte[1] = "Nombre del Proyecto";
    $tituloReporte[2] = "Entidad Oferente - Constructora";
    $tituloReporte[3] = "Resolucion Aprobacion del Comite de Elegibilidad";
    $tituloReporte[4] = "Año de resolución";
    $tituloReporte[5] = "Cantidad de VIP generadas";
    $tituloReporte[6] = "Valor inicial SDVE";
    $k = 0;
    for ($i = 0; $i < $registrosIndx; $i++) {
        $y = $i + 7;
        $j = $y + 1;
        $k = $j + 1;
        $tituloReporte[$y] = "Indexacion";
        $tituloReporte[$j] = "Año Indexacion";
        $tituloReporte[$k] = "Valor indexacion";
        $i +=3;
    }
    $tituloReporte[($k + 1)] = "Valor Total SDVE";


    $totalColumnas = $registrosIndx + 7;
    $field = 0;
    //$columnas = 6;
    $tiltle = 0;
    $rowcount = 2;
    $titulos = $columnas + $registrosIndx + 2;
    $valorTotal = 0;
   // echo count();    exit();
    while ($field !== $titulos) {
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . "1", $tituloReporte[$tiltle])->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension($arrNomCol[$field])->setAutoSize(true);
        $objPHPExcel->getProperties()->setCreator("HOO")->setLastModifiedBy("HOO");
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $arrNomCol[$field] . '1')->applyFromArray($style_header);


        $field++;
        $tiltle++;
    }
    try {
        $rowsTotal = $registrosIndx + $columnas;
        $rowcount = 2;
        while ($row = mysql_fetch_array($resultd)) {
            $field = 0;
            $valorTotal = $row['valorAsignado'];
            while ($field !== $columnas) {
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . $rowcount, $row[$field]);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $rowcount . ':G' . $rowcount)->applyFromArray($styleArrayBody);

                $sql2 = "SELECT numActo, YEAR(fchActo) AS fecha, SUM(valIndexado) AS valorIndexado
                            FROM T_PRY_AAD_UNIDAD_ACTO
                            LEFT JOIN T_PRY_AAD_UNIDADES_VINCULADAS ON (T_PRY_AAD_UNIDAD_ACTO.seqUnidadActo = T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadActo)
                            LEFT JOIN T_PRY_UNIDAD_PROYECTO uni ON (T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadProyecto = uni.seqUnidadProyecto)
                            LEFT JOIN T_PRY_PROYECTO pry ON (uni.seqProyecto = pry.seqProyecto)
                            WHERE seqTipoActoUnidad = 2
                            and uni.seqProyecto = " . $row[0] . "
                            GROUP BY txtNombreProyecto, numActo, fchActo 
                            ORDER BY fchActo ASC";
                $resultYear = mysql_query($sql2, $conexion) or die(mysql_error());
                $registrosYear = mysql_num_rows($resultYear);
                $columnasYear = mysql_num_fields($resultYear);
                $totalYear = $columnas;
                $columnasYear = $columnasYear + $columnasIndex;
                while ($rowYear = mysql_fetch_array($resultYear)) {
                    $fielYear = 0;

                    if (($field + 1) == $columnas) {
                        // echo "valor indexado = " .$rowYear['valorIndexado']."+";
                        $valorTotal += $rowYear['valorIndexado'];
                    }

                    while ($fielYear < $columnasYear) {
                        if ($totalYear > $rowsTotal)
                            $rowsTotal = $totalYear;
                        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$totalYear] . $rowcount, $rowYear[$fielYear]);
                        $objPHPExcel->getActiveSheet()->getColumnDimension($arrNomCol[$totalYear])->setAutoSize(true);


                        $fielYear++;
                        $totalYear++;
                    }
                }
                //echo "<br>";


                $field++;
            }
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[($totalColumnas+1)] . $rowcount, $valorTotal);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $rowcount . ':' . $arrNomCol[($totalColumnas+1)] . '' . $rowcount)->applyFromArray($styleArrayBody);
            //$objPHPExcel->getActiveSheet()->getStyle('H' . $rowcount . ':G' . $rowcount)->applyFromArray($styleArrayBody);
            $rowcount++;
        }

        // echo $rowsTotal;
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="InformeProyectosActos.xlsx"');
        $objWriter->save('php://output');
        exit;
    } catch (Exception $objError) {
        return $objError->msg;
    }
}
