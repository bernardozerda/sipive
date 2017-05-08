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

    $conexion = mysql_connect("localhost", "sdht_usuario", "Ochochar*1");
    mysql_set_charset('utf8', $conexion);
    mysql_select_db("sipive", $conexion);
    $arrayForm = Array();
    $docConsult = Array();
    $cont = 0;
    $sqlForm = "SELECT  seqFormulario, numDocumento FROM t_ciu_ciudadano ciu LEFT JOIN t_frm_hogar USING(seqCiudadano)WHERE numDocumento IN ( " . implode(",", $arrDocumentos) . " )";
    $resultForm = mysql_query($sqlForm, $conexion) or die(mysql_error());
    while ($row = mysql_fetch_array($resultForm)) {
        $arrayForm[$cont] = intval($row['seqFormulario']);
        $docConsult[$cont] = intval($row['numDocumento']);
        $cont++;
    }
    $noEncontrado = "<b> Los documentos que no se encontron son: ";
    $int = 0;
    $band = false;
    foreach ($arrDocumentos as $key => $value) {
		
        if (!in_array($value, $docConsult)) {
            //$noEncontrado[$int] = $value;
			$noEncontrado .= $value .", ";
            $band = true;
            $int++;
        }
		
    }
    $noEncontrado = substr_replace($noEncontrado, '.', -2, 1);
    if($band){
       echo $noEncontrado."</b>";
        die();
    }
    /* #(SELECT txtCondicionEspecial from t_ciu_condicion_especial where seqCondicionEspecial = ciu.seqCondicionEspecial ) as txtCondicionEspecial,
      #(SELECT txtCondicionEspecial from t_ciu_condicion_especial where seqCondicionEspecial = ciu.seqCondicionEspecial2 ) as txtCondicionEspecial2,
      #(SELECT txtCondicionEspecial from t_ciu_condicion_especial where seqCondicionEspecial = ciu.seqCondicionEspecial3 ) as txtCondicionEspecial3, */
    $sql = "SELECT  seqFormulario, UPPER(CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, '  ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre,
            CASE WHEN bolDesplazado =0 THEN 'NO' ELSE 'SI' END AS hogarVictima,  ciu.numDocumento, txtTipoDocumento, txtParentesco, txtSexo, txtEstadoCivil,
            
            ucwords( cabezaFamilia( ciu.seqCondicionEspecial , ciu.seqCondicionEspecial2 , ciu.seqCondicionEspecial3 ) ) as txtCabezaFamilia,
            ucwords( mayor65anos( ciu.seqCondicionEspecial , ciu.seqCondicionEspecial2 , ciu.seqCondicionEspecial3 ) ) as txtMayor65Anos,
            ucwords( discapacitado( ciu.seqCondicionEspecial , ciu.seqCondicionEspecial2 , ciu.seqCondicionEspecial3 ) ) as txtDiscapacitado,
            CONCAT(txtEtapa, ' - ', txtEstadoProceso ) AS estado, CASE WHEN bolCerrado = 0 THEN 'NO' ELSE 'SI' END AS cierre, 
            UPPER(TRIM(t_frm_formulario.txtDireccion)), txtLocalidad, t_frm_barrio.txtBarrio, txtModalidad, valIngresoHogar,                           
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
    //echo "<br><br>".$sql;
  //die();
    $resultdl = mysql_query($sql, $conexion) or die(mysql_error());
    $registros = mysql_num_rows($resultdl);


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
        //var_dump($arrDocumentos);
        $docConsult = Array();

        $tiltle = 0;
        $titulos = 25;
        $field = 0;
        while ($field !== $titulos) {
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . "1", $tituloReporte[$tiltle])->getRowDimension('1')->setRowHeight(80);
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrNomCol[$field])->setAutoSize(true);
            $objPHPExcel->getProperties()->setCreator("HOO")->setLastModifiedBy("HOO");
            $objPHPExcel->getActiveSheet()->getStyle('A1:' . $arrNomCol[$field] . '1')->applyFromArray($style_header);
            $field++;
            $tiltle++;
        }
        $int = 0;


        $rowcount = 2;
        while ($row = mysql_fetch_array($resultdl)) {
            $field = 0;
            while ($field !== $titulos) {
               // $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . $rowcount, utf8_encode($row[$field]));
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arrNomCol[$field] . $rowcount, str_replace('  ', '', $row[$field]));
                $objPHPExcel->getActiveSheet()->getStyle('A' . $rowcount . ':Y' . $rowcount)->applyFromArray($styleArrayBody);
                $field++;
            }
            $rowcount++;
        }
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
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="InformacionCVP.xlsx"');
        $objWriter->save('php://output');
        exit;
    } else {
        echo '<span style="color:#c10;text-align:center;"><b>No hay registros!</b></span>';
    }
    mysql_close();
}
