<?php

//echo "paso"; exit();
/* * *********************************
 * PLANTILLA INFORMACIÓN CVP
 * @author LILIANA BASTO
 * @version 1.0 OCTUBRE 2016
 * ********************************** */

function obtenerRegistroCiudadano($arrDocumentos) {

    if (count($arrDocumentos) > 250) {
        echo '<span style="color:#c10;text-align:center;"><b>La cantidad de registros no puede ser superior a 250!</b></span>';
        die();
    }

    require_once '../../librerias/phpExcel/Classes/PHPExcel.php';
    require_once '../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php';

    //PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
    $objPHPExcel = new PHPExcel();


    global $aptBd;
    $arrayForm = Array();
    $docConsult = Array();
    $cont = 0;
    $sqlForm = "SELECT  seqFormulario, numDocumento FROM t_ciu_ciudadano ciu LEFT JOIN t_frm_hogar USING(seqCiudadano)WHERE numDocumento IN ( " . implode(",", $arrDocumentos) . " )";
    $objRes = $aptBd->execute($sqlForm);
    
    while ($objRes->fields) {
        $arrayForm[$cont] = intval($objRes->fields['seqFormulario']);
        $docConsult[$cont] = intval($objRes->fields['numDocumento']);
        $objRes->MoveNext();
        $cont++;
    }
    $noEncontrado = "<b> Los documentos que no se encontron son: ";
    $int = 0;
    $band = false;
    foreach ($arrDocumentos as $key => $value) {

        if (!in_array($value, $docConsult)) {
            //$noEncontrado[$int] = $value;
            $noEncontrado .= $value . ", ";
            $band = true;
            $int++;
        }
    }
    $noEncontrado = substr_replace($noEncontrado, '.', -2, 1);
    if ($band) {
        echo $noEncontrado . "</b>";
        die();
    }
    
    $sql = "SELECT  seqFormulario, UPPER(CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, '  ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre,
            CASE WHEN bolDesplazado =0 THEN 'NO' ELSE 'SI' END AS hogarVictima,  ciu.numDocumento, txtTipoDocumento, txtParentesco, txtSexo, txtEstadoCivil,
            
            ucwords( cabezaFamilia( ciu.seqCondicionEspecial , ciu.seqCondicionEspecial2 , ciu.seqCondicionEspecial3 ) ) as txtCabezaFamilia,
            ucwords( mayor65anos( ciu.seqCondicionEspecial , ciu.seqCondicionEspecial2 , ciu.seqCondicionEspecial3 ) ) as txtMayor65Anos,
            ucwords( discapacitado( ciu.seqCondicionEspecial , ciu.seqCondicionEspecial2 , ciu.seqCondicionEspecial3 ) ) as txtDiscapacitado,
            CONCAT(txtEtapa, ' - ', txtEstadoProceso ) AS estado, CASE WHEN bolCerrado = 0 THEN 'NO' ELSE 'SI' END AS cierre, 
            UPPER(TRIM(t_frm_formulario.txtDireccion)) As direccion, txtLocalidad, t_frm_barrio.txtBarrio, txtModalidad, valIngresoHogar,                           
            txtSoporteDonacion as SoporteDonacion, txtEmpresaDonante as entidadDonacion, 
            CASE WHEN txtNombreProyecto = 'null' THEN 'Ninguno' WHEN txtNombreProyecto = 'NULL' THEN 'Ninguno' WHEN txtNombreProyecto = '0' THEN 'Ninguno' 
            WHEN t_frm_formulario.seqProyecto = 37 THEN 'Ninguno' WHEN t_frm_formulario.seqProyecto = 'NULL' THEN 'Ninguno' 
            WHEN t_frm_formulario.seqProyecto = '' THEN 'Ninguno' WHEN txtNombreProyecto = '' THEN 'Ninguno'
            ELSE txtNombreProyecto  END AS  Proyecto, txtMatriculaInmobiliaria, txtChip, valAvaluo as avaluo,
            (SELECT GROUP_CONCAT('Res.', t_aad_hogares_vinculados.numActo, ' de ', YEAR(t_aad_hogares_vinculados.fchActo), ' Modalidad: ', CONVERT(txtModalidad USING utf8)  SEPARATOR ' ; ' )
                FROM t_aad_formulario_acto
                     LEFT JOIN t_aad_hogares_vinculados USING (seqFormularioActo)
                     LEFT JOIN t_frm_modalidad USING(seqModalidad)
               WHERE     seqTipoActo = 1
                     AND t_aad_formulario_acto.seqFormulario =
                            t_frm_formulario.seqFormulario)
            AS resolucionAsignacion            
            FROM t_ciu_ciudadano ciu LEFT JOIN t_frm_hogar USING(seqCiudadano)
            LEFT JOIN t_frm_formulario USING(seqFormulario)
            LEFT JOIN t_ciu_tipo_documento USING(seqTipoDocumento)
            LEFT JOIN t_ciu_parentesco USING(seqParentesco)
            LEFT JOIN t_ciu_sexo USING(seqSexo)
            LEFT JOIN t_ciu_estado_civil USING(seqEstadoCivil)
            LEFT JOIN t_frm_estado_proceso USING(seqEstadoProceso)
            LEFT JOIN t_frm_etapa USING(seqEtapa)
            LEFT JOIN t_frm_modalidad USING(seqModalidad)
            LEFT JOIN t_frm_localidad USING(seqLocalidad)
            LEFT JOIN t_frm_barrio USING(seqBarrio)
            LEFT JOIN t_pry_proyecto ON(t_frm_formulario.seqProyecto = t_pry_proyecto.seqProyecto)
            LEFT JOIN t_frm_empresa_donante USING(seqEmpresaDonante)
            WHERE t_frm_formulario.seqFormulario IN ( " . implode(",", $arrayForm) . " ) "
            . " ORDER BY t_frm_formulario.seqFormulario, seqParentesco";

    $objRes1 = $aptBd->execute($sql);
    $registros = $objRes1->numRows();


    $tituloReporte = Array();
    $tituloReporte[0] = "ID Hogar";
    $tituloReporte[1] = "Nombre";
    $tituloReporte[2] = "Hogar Victima";
    $tituloReporte[3] = "Documento";
    $tituloReporte[4] = "Tipo Documento";
    $tituloReporte[5] = "Parentesco";
    $tituloReporte[6] = "Sexo";
    $tituloReporte[7] = "Estado Civil";
    $tituloReporte[8] = "Cabeza de Hogar";
    $tituloReporte[9] = "Discapacidad";
    $tituloReporte[10] = "Mayor de 65 años";
    $tituloReporte[11] = "Estado Proceso";
    $tituloReporte[12] = "Formulario Cerrado";
    $tituloReporte[13] = "Dirección Residencia";
    $tituloReporte[14] = "Localidad Residencia";
    $tituloReporte[15] = "Barrio Residencia";
    $tituloReporte[16] = "Modalidad Subsidio";
    $tituloReporte[17] = "Total Ingresos Hogar";
    $tituloReporte[18] = "Soporte Donacion / VUR";
    $tituloReporte[19] = "Entidad Donacion / VUR";
    $tituloReporte[20] = "Proyecto";
    $tituloReporte[21] = "Matricula Inmobiliaria predio mejoramiento";
    $tituloReporte[22] = "Chip predio mejoramiento";
    $tituloReporte[23] = "Avaluo predio mejoramiento";
    $tituloReporte[24] = "Resolución Asignación / Vinculación";


    $title = Array();
    $title[0] = "seqFormulario";
    $title[1] = "Nombre";
    $title[2] = "hogarVictima";
    $title[3] = "numDocumento";
    $title[4] = "txtTipoDocumento";
    $title[5] = "txtParentesco";
    $title[6] = "txtSexo";
    $title[7] = "txtEstadoCivil";
    $title[8] = "txtCabezaFamilia";
    $title[9] = "txtDiscapacitado";
    $title[10] = "txtMayor65Anos";
    $title[11] = "estado";
    $title[12] = "cierre";
    $title[13] = "direccion";
    $title[14] = "txtLocalidad";
    $title[15] = "txtBarrio";
    $title[16] = "txtModalidad";
    $title[17] = "valIngresoHogar";
    $title[18] = "SoporteDonacion";
    $title[19] = "entidadDonacion";
    $title[20] = "Proyecto";
    $title[21] = "txtMatriculaInmobiliaria";
    $title[22] = "txtChip";
    $title[23] = "avaluo";
    $title[24] = "resolucionAsignacion";
    //$tituloReporte[22] = "Año Resolución Asignación / Vinculación";
    //$tituloReporte[25] = "Cedula Catastral predio mejoramiento";


    $arrNomCol = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC",
        "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ");

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
            'color' => array('rgb' => 'FFFF00'),
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

    if ($registros > 0) {
        // echo "<br> paso - 1";
        //var_dump($arrDocumentos);
        $docConsult = Array();

        $tiltle = 0;
        $titulos = 25;
        $field = 0;
        while ($field !== $titulos) {
            //  echo $arrNomCol[$field] . "1", $tituloReporte[$tiltle] ."<br>";
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . "1", $tituloReporte[$tiltle])->getRowDimension('1')->setRowHeight(80);
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrNomCol[$field])->setAutoSize(true);
            $objPHPExcel->getProperties()->setCreator("HOO")->setLastModifiedBy("HOO");
            $objPHPExcel->getActiveSheet()->getStyle('A1:' . $arrNomCol[$field] . '1')->applyFromArray($style_header);
            $field++;
            $tiltle++;
        }

        $int = 0;


        $rowcount = 2;
        //  echo "<br> paso - 2";
        while ($objRes1->fields) {
            $field = 0;
            //   echo "<br>";
            while ($field !== $titulos) {
             
                // $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . $rowcount, utf8_encode($row[$field]));
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . $rowcount, str_replace('  ', '', $objRes1->fields[$title[$field]]));
                $objPHPExcel->getActiveSheet()->getStyle('A' . $rowcount . ':Y' . $rowcount)->applyFromArray($styleArrayBody);
                $field++;
            }
            $rowcount++;
            $objRes1->MoveNext();
        }
        //die();

        $rowcount = $rowcount + 1;
        if ($band) {
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[0] . $rowcount, 'LOS SIGUIENTES SON LOS NUMEROS DE IDENTIFICACIÓN NO INSCRITOS EN EL SIFSV');
            $objPHPExcel->getActiveSheet()->getStyle($arrNomCol[0] . $rowcount)->applyFromArray($style_Mod);
            foreach ($noEncontrado as $key => $value) {
                $rowcount++;
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[0] . $rowcount, $value);
                //$objPHPExcel->getActiveSheet()->getStyle($arrNomCol[0] . $rowcount)->applyFromArray($style_header);
            }
        }
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=InformacionCVP" . date("YmdHis") . ".xlsx");
        header('Cache-Control: max-age=0');
        ob_end_clean();

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    } else {
        echo '<span style="color:#c10;text-align:center;"><b>No hay registros!</b></span>';
    }
}
