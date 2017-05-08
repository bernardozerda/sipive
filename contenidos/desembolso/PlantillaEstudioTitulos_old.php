<?php
 /**
* PLANTILLA ESTUDIO DE TITULOS
* @author Andres Martinez
* @version 1.0 Marzo 2016
*/

ini_set('memory_limit','128M');
//set_time_limit(300);

$txtPrefijoRuta = "../../";
/*
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" ); 
*/
function plantillaestudiotitulos($seqFormularios){
    
//conexion
 $conexion = mysql_connect ("localhost", "sdht_usuario", "Ochochar*1");
 mysql_set_charset('utf8',$conexion);
 mysql_select_db ("sipive", $conexion);    
 
 
 
 //sql
 $sql = "SELECT T_DES_ESCRITURACION.seqFormulario AS 'id Hogar',
       T_CIU_CIUDADANO.numDocumento AS 'CC Postulante principal',
       T_CIU_TIPO_DOCUMENTO.txtTipoDocumento AS 'Tipo de Documento',
       UPPER(CONCAT(T_CIU_CIUDADANO.txtNombre1,
                    ' ',
                    T_CIU_CIUDADANO.txtNombre2,
                    ' ',
                    T_CIU_CIUDADANO.txtApellido1,
                    ' ',
                    T_CIU_CIUDADANO.txtApellido2))
          AS 'Nombre Postulante principal',
       T_PRY_PROYECTO.txtNombreProyecto AS 'Proyecto',
       T_DES_ESCRITURACION.txtNombreVendedor AS 'Propietario',
       T_FRM_FORMULARIO.seqUnidadProyecto AS 'seqUnidadProyecto',
       T_PRY_UNIDAD_PROYECTO.txtNombreUnidad AS 'txtnombreunidad',
       T_DES_ESCRITURACION.txtDireccionInmueble AS 'Direccion Inmueble',
       T_PRY_TECNICO.txtexistencia
          AS 'Certificado de existencia y Habitabilidad',
       T_DES_ESCRITURACION.txtEscritura AS 'Escritura Registrada',
       T_DES_ESCRITURACION.fchEscritura AS 'Fecha Escritura',
       T_DES_ESCRITURACION.numNotaria AS 'Notaria',
       T_DES_ESCRITURACION.txtCiudad AS 'Ciudad',
       T_DES_ESCRITURACION.txtMatriculaInmobiliaria AS 'Folio de Matricula',
       T_DES_ESCRITURACION.numValorInmueble AS 'Valor Inmueble',
       T_AAD_ACTO_ADMINISTRATIVO.numActo AS 'Numero del Acto',
       DATE_FORMAT(T_AAD_ACTO_ADMINISTRATIVO.fchacto,'%d-%m-%Y') AS 'Fecha del Acto'
  FROM T_DES_ESCRITURACION
       INNER JOIN T_FRM_FORMULARIO
          ON (T_DES_ESCRITURACION.seqFormulario =
                 T_FRM_FORMULARIO.seqFormulario)
       INNER JOIN T_FRM_HOGAR
          ON (T_FRM_FORMULARIO.seqFormulario = T_FRM_HOGAR.seqFormulario)
       INNER JOIN T_CIU_CIUDADANO
          ON (T_CIU_CIUDADANO.seqCiudadano = T_FRM_HOGAR.seqCiudadano)
       INNER JOIN T_CIU_TIPO_DOCUMENTO
          ON (T_CIU_CIUDADANO.seqTipoDocumento =
                 T_CIU_TIPO_DOCUMENTO.seqTipoDocumento)
       INNER JOIN T_PRY_UNIDAD_PROYECTO
          ON (T_FRM_FORMULARIO.seqFormulario =
                 T_PRY_UNIDAD_PROYECTO.seqFormulario)
       INNER JOIN T_PRY_PROYECTO
          ON (T_PRY_PROYECTO.seqProyecto = T_PRY_UNIDAD_PROYECTO.seqProyecto)
       INNER JOIN T_PRY_TECNICO
          ON (T_FRM_FORMULARIO.seqUnidadProyecto =
                 T_PRY_TECNICO.seqUnidadProyecto)
       INNER JOIN T_AAD_FORMULARIO_ACTO
          ON (T_FRM_FORMULARIO.seqFormulario =
                 T_AAD_FORMULARIO_ACTO.seqFormulario)
       INNER JOIN T_AAD_HOGARES_VINCULADOS
          ON (T_AAD_FORMULARIO_ACTO.seqFormularioActo =
                 T_AAD_HOGARES_VINCULADOS.seqFormularioActo)
       INNER JOIN
       (SELECT *
          FROM T_AAD_ACTO_ADMINISTRATIVO
        ORDER BY T_AAD_ACTO_ADMINISTRATIVO.fchActo DESC)
       AS T_AAD_ACTO_ADMINISTRATIVO
          ON (    T_AAD_HOGARES_VINCULADOS.numActo =
                     T_AAD_ACTO_ADMINISTRATIVO.numActo
              AND T_AAD_HOGARES_VINCULADOS.fchActo =
                     T_AAD_ACTO_ADMINISTRATIVO.fchActo)

					 
 WHERE     T_FRM_HOGAR.seqParentesco = 1
       AND T_DES_ESCRITURACION.seqFormulario IN   (". $seqFormularios .")"
         . "GROUP BY T_DES_ESCRITURACION.seqFormulario ORDER BY T_AAD_ACTO_ADMINISTRATIVO.fchActo" ;
 
 //echo $sql;die();

 
 $resultdl = mysql_query ($sql, $conexion) or die (mysql_error ());
 $registros = mysql_num_rows ($resultdl);

 if ($registros > 0) {
   require_once '../../librerias/clases/PHPExcel.php' ;
   PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
   $objPHPExcel = new PHPExcel();
    
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("sifsv")
        ->setLastModifiedBy("sifsv")
        ->setTitle("Plantilla Estudios de Titulos"); 
   
    //Cabecera del Archivo   
   $objPHPExcel->setActiveSheetIndex(0)
        ->SetCellValue('A1', 'ID HOGAR')
        ->SetCellValue('B1', 'CC POSTULANTE PRINCIPAL')
        ->SetCellValue('C1', 'TIPO DE DOCUMENTO')
        ->SetCellValue('D1', 'NOMBRE POSTULANTE PRINCIPAL')
        ->SetCellValue('E1', 'PROYECTO')
        ->SetCellValue('F1', 'PROPIETARIO')
        ->SetCellValue('G1', 'seqUnidadProyecto')
        ->SetCellValue('H1', 'txtnombreunidad')
        ->SetCellValue('I1', 'DIRECCION INMUEBLE')
        ->SetCellValue('J1', 'CERTIFICADO DE EXISTENCIA Y HABITABILIDAD')
        ->SetCellValue('K1', 'ESCRITURA REGISTRADA')
        ->SetCellValue('L1', 'FECHA ESCRITURA')
        ->SetCellValue('M1', 'NOTARIA')
        ->SetCellValue('N1', 'CIUDAD NOTARIA')
        ->SetCellValue('O1', 'FOLIO DE MATRICULA')
        ->SetCellValue('P1', 'VALOR INMUEBLE')
        ->SetCellValue('Q1', 'NUMERO DEL ACTO')
        ->SetCellValue('R1', 'FECHA DEL ACTO')   
        ->SetCellValue('S1', 'No. ESCRITURA')
        ->SetCellValue('T1', 'FECHA ESCRITURA (D/M/A)')
        ->SetCellValue('U1', 'NOTARIA')
        ->SetCellValue('V1', 'CIUDAD NOTARIA')
        ->SetCellValue('W1', 'FOLIO DE MATRICULA')
        ->SetCellValue('X1', 'ZONA OFICINA REGISTRO')
        ->SetCellValue('Y1', 'CIUDAD OFICINA REGISTRO')
        ->SetCellValue('Z1', 'FECHA FOLIO (D/M/A)')
        ->SetCellValue('AA1', 'RESOLUCION DE VINCULACION COINCIDENTE')
        ->SetCellValue('AB1', 'BENEFICIARIOS DEL SDV COINCIDENTES')
        ->SetCellValue('AC1', 'NOMBRE Y CEDULA DE LOS PROPIETARIOS EN EL CTL INCIDENTES')
        ->SetCellValue('AD1', 'CONSTITUCION PATRIMONIO FAMILIA')
        ->SetCellValue('AE1', 'INDAGACION AFECTACION A VIVIENDA FAMILIAR')
        ->SetCellValue('AF1', 'RESTRICCIONES')
        ->SetCellValue('AG1', 'ESTADO CIVIL COINCIDENTE')
        ->SetCellValue('AH1', 'CARTA DE VINCULACION Y/O RESOLUCION PROTOCOLIZADA')
        ->SetCellValue('AI1', 'No. DE ANOTACION CTL COMPRAVENTA')
        ->SetCellValue('AJ1', 'SE CANCELA HIPOTECA MAYOR EXTENSION (SI LA HUBIERE)')   
        ->SetCellValue('AK1', 'PATRIMONIO DE FAMILIA REGISTRADO')
        ->SetCellValue('AL1', 'PROHIBICION DE TRANSFERENCIA Y DERECHO DE PREFERENCIA REGISTRADOS')
        ->SetCellValue('AM1', 'IMPRESION DE CONSULTA FONVIVIENDA (HOGARES VICTIMAS)')
        ->SetCellValue('AN1', 'ELABORO')
        ->SetCellValue('AO1', 'APROBO')
        ->SetCellValue('AP1', 'SE VIABILIZA JURIDICAMENTE')
        ->SetCellValue('AQ1', 'OBSERVACION');
   
   //Creacion de rango de seleccion de desplegable (SI - NO)
    $objPHPExcel->createSheet(1);
    $objPHPExcel->getSheet(1)->SetCellValue("AZ2", "SI");
    $objPHPExcel->getSheet(1)->SetCellValue("AZ3", "NO");

    $objPHPExcel->addNamedRange( 
        new PHPExcel_NamedRange(
            'seleccion', 
            $objPHPExcel->getSheet(1), 
            'AZ2:AZ3'
        ) 
    );
//Creacion de rango de seleccion de desplegable (SI - NO Aplica)
    $objPHPExcel->getSheet(1)->SetCellValue("BA2", "SI");
    $objPHPExcel->getSheet(1)->SetCellValue("BA3", "NO APLICA");

    $objPHPExcel->addNamedRange( 
        new PHPExcel_NamedRange(
            'seleccion1', 
            $objPHPExcel->getSheet(1), 
            'BA2:BA3'
        ) 
    );
 
   
   //ESCRIBE ARCHIVO
    $rowcount=2;
    while($row = mysql_fetch_array($resultdl)){
  
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowcount, $row['id Hogar']);
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowcount, $row['CC Postulante principal']); 
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowcount, $row['Tipo de Documento']);
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowcount, $row['Nombre Postulante principal']);
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowcount, $row['Proyecto']);
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowcount, $row['Propietario']);
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowcount, $row['seqUnidadProyecto']);
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowcount, $row['txtnombreunidad']);
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowcount, $row['Direccion Inmueble']);
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowcount, $row['Certificado de existencia y Habitabilidad']);
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K'.$rowcount, $row['Escritura Registrada']);
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L'.$rowcount, $row['Fecha Escritura']);
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('M'.$rowcount, $row['Notaria']);
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('N'.$rowcount, $row['Ciudad']);
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('O'.$rowcount, $row['Folio de Matricula']);
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('P'.$rowcount, $row['Valor Inmueble']);
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('Q'.$rowcount, $row['Numero del Acto']);
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('R'.$rowcount, $row['Fecha del Acto']);

               //escribe desplegables en las columnas correspondientes   

               $objValidation1 = $objPHPExcel->getActiveSheet()->getCell('AA'.$rowcount)->getDataValidation();
               $objValidation1->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidation1->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP );
               $objValidation1->setAllowBlank(true);
               $objValidation1->setShowInputMessage(true);
               $objValidation1->setShowErrorMessage(true);
               $objValidation1->setShowDropDown(true);
               $objValidation1->setErrorTitle('Error');
               $objValidation1->setError('Valor no esta en la lista');
               $objValidation1->setPromptTitle('Seleccion');
               $objValidation1->setPrompt('Seleccione un valor de la lista');
               $objValidation1->setFormula1("=seleccion");

               $objValidation2 = $objPHPExcel->getActiveSheet()->getCell('AB'.$rowcount)->getDataValidation();
               $objValidation2->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidation2->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidation2->setAllowBlank(true);
               $objValidation2->setShowInputMessage(true);
               $objValidation2->setShowErrorMessage(true);
               $objValidation2->setShowDropDown(true);
               $objValidation2->setErrorTitle('Error');
               $objValidation2->setError('Valor no esta en la lista');
               $objValidation2->setPromptTitle('Seleccion');
               $objValidation2->setPrompt('Seleccione un valor de la lista');
               $objValidation2->setFormula1("=seleccion");

               $objValidation3 = $objPHPExcel->getActiveSheet()->getCell('AC'.$rowcount)->getDataValidation();
               $objValidation3->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidation3->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidation3->setAllowBlank(true);
               $objValidation3->setShowInputMessage(true);
               $objValidation3->setShowErrorMessage(true);
               $objValidation3->setShowDropDown(true);
               $objValidation3->setErrorTitle('Error');
               $objValidation3->setError('Valor no esta en la lista');
               $objValidation3->setPromptTitle('Seleccion');
               $objValidation3->setPrompt('Seleccione un valor de la lista');
               $objValidation3->setFormula1("=seleccion");

               $objValidation4 = $objPHPExcel->getActiveSheet()->getCell('AD'.$rowcount)->getDataValidation();
               $objValidation4->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidation4->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidation4->setAllowBlank(true);
               $objValidation4->setShowInputMessage(true);
               $objValidation4->setShowErrorMessage(true);
               $objValidation4->setShowDropDown(true);
               $objValidation4->setErrorTitle('Error');
               $objValidation4->setError('Valor no esta en la lista');
               $objValidation4->setPromptTitle('Seleccion');
               $objValidation4->setPrompt('Seleccione un valor de la lista');
               $objValidation4->setFormula1("=seleccion");

               $objValidation5 = $objPHPExcel->getActiveSheet()->getCell('AE'.$rowcount)->getDataValidation();
               $objValidation5->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidation5->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidation5->setAllowBlank(true);
               $objValidation5->setShowInputMessage(true);
               $objValidation5->setShowErrorMessage(true);
               $objValidation5->setShowDropDown(true);
               $objValidation5->setErrorTitle('Error');
               $objValidation5->setError('Valor no esta en la lista');
               $objValidation5->setPromptTitle('Seleccion');
               $objValidation5->setPrompt('Seleccione un valor de la lista');
               $objValidation5->setFormula1("=seleccion");

               $objValidation6 = $objPHPExcel->getActiveSheet()->getCell('AF'.$rowcount)->getDataValidation();
               $objValidation6->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidation6->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidation6->setAllowBlank(true);
               $objValidation6->setShowInputMessage(true);
               $objValidation6->setShowErrorMessage(true);
               $objValidation6->setShowDropDown(true);
               $objValidation6->setErrorTitle('Error');
               $objValidation6->setError('Valor no esta en la lista');
               $objValidation6->setPromptTitle('Seleccion');
               $objValidation6->setPrompt('Seleccione un valor de la lista');
               $objValidation6->setFormula1("=seleccion");

               $objValidation7 = $objPHPExcel->getActiveSheet()->getCell('AG'.$rowcount)->getDataValidation();
               $objValidation7->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidation7->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidation7->setAllowBlank(true);
               $objValidation7->setShowInputMessage(true);
               $objValidation7->setShowErrorMessage(true);
               $objValidation7->setShowDropDown(true);
               $objValidation7->setErrorTitle('Error');
               $objValidation7->setError('Valor no esta en la lista');
               $objValidation7->setPromptTitle('Seleccion');
               $objValidation7->setPrompt('Seleccione un valor de la lista');
               $objValidation7->setFormula1("=seleccion");

               $objValidation8 = $objPHPExcel->getActiveSheet()->getCell('AH'.$rowcount)->getDataValidation();
               $objValidation8->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidation8->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidation8->setAllowBlank(true);
               $objValidation8->setShowInputMessage(true);
               $objValidation8->setShowErrorMessage(true);
               $objValidation8->setShowDropDown(true);
               $objValidation8->setErrorTitle('Error');
               $objValidation8->setError('Valor no esta en la lista');
               $objValidation8->setPromptTitle('Seleccion');
               $objValidation8->setPrompt('Seleccione un valor de la lista');
               $objValidation8->setFormula1("=seleccion");

               $objValidation9 = $objPHPExcel->getActiveSheet()->getCell('AJ'.$rowcount)->getDataValidation();
               $objValidation9->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidation9->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidation9->setAllowBlank(true);
               $objValidation9->setShowInputMessage(true);
               $objValidation9->setShowErrorMessage(true);
               $objValidation9->setShowDropDown(true);
               $objValidation9->setErrorTitle('Error');
               $objValidation9->setError('Valor no esta en la lista');
               $objValidation9->setPromptTitle('Seleccion');
               $objValidation9->setPrompt('Seleccione un valor de la lista');
               $objValidation9->setFormula1("=seleccion");

               $objValidation10 = $objPHPExcel->getActiveSheet()->getCell('AK'.$rowcount)->getDataValidation();
               $objValidation10->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidation10->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidation10->setAllowBlank(true);
               $objValidation10->setShowInputMessage(true);
               $objValidation10->setShowErrorMessage(true);
               $objValidation10->setShowDropDown(true);
               $objValidation10->setErrorTitle('Error');
               $objValidation10->setError('Valor no esta en la lista');
               $objValidation10->setPromptTitle('Seleccion');
               $objValidation10->setPrompt('Seleccione un valor de la lista');
               $objValidation10->setFormula1("=seleccion1");

               $objValidation11 = $objPHPExcel->getActiveSheet()->getCell('AL'.$rowcount)->getDataValidation();
               $objValidation11->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidation11->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidation11->setAllowBlank(true);
               $objValidation11->setShowInputMessage(true);
               $objValidation11->setShowErrorMessage(true);
               $objValidation11->setShowDropDown(true);
               $objValidation11->setErrorTitle('Error');
               $objValidation11->setError('Valor no esta en la lista');
               $objValidation11->setPromptTitle('Seleccion');
               $objValidation11->setPrompt('Seleccione un valor de la lista');
               $objValidation11->setFormula1("=seleccion");

               $objValidation12 = $objPHPExcel->getActiveSheet()->getCell('AM'.$rowcount)->getDataValidation();
               $objValidation12->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidation12->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidation12->setAllowBlank(true);
               $objValidation12->setShowInputMessage(true);
               $objValidation12->setShowErrorMessage(true);
               $objValidation12->setShowDropDown(true);
               $objValidation12->setErrorTitle('Error');
               $objValidation12->setError('Valor no esta en la lista');
               $objValidation12->setPromptTitle('Seleccion');
               $objValidation12->setPrompt('Seleccione un valor de la lista');
               $objValidation12->setFormula1("=seleccion1");

               $objValidation13 = $objPHPExcel->getActiveSheet()->getCell('AP'.$rowcount)->getDataValidation();
               $objValidation13->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidation13->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidation13->setAllowBlank(true);
               $objValidation13->setShowInputMessage(true);
               $objValidation13->setShowErrorMessage(true);
               $objValidation13->setShowDropDown(true);
               $objValidation13->setErrorTitle('Error');
               $objValidation13->setError('Valor no esta en la lista');
               $objValidation13->setPromptTitle('Seleccion');
               $objValidation13->setPrompt('Seleccione un valor de la lista');
               $objValidation13->setFormula1("=seleccion");

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
      $objPHPExcel->getActiveSheet()->getStyle('S2:AQ'.($registros + 1))->getProtection()
        ->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
     

//seteo del estilo del cuerpo de la tabla
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

//autofit text
$objPHPExcel->getActiveSheet()->getStyle('A1:AQ1')->getAlignment()->setWrapText(true);

//cuerpo
$objPHPExcel->getActiveSheet()->getStyle('A1:AQ'.($registros + 1))->applyFromArray($styleArrayBody);

//encabezado blanco
$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

//gris
$objPHPExcel->getActiveSheet()->getStyle('S1:AQ1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('S1:AQ1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('S1:AQ1')->getFill()->getStartColor()->setARGB('a9a9a9');
$objPHPExcel->getActiveSheet()->getStyle('S1:AQ1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

//rojo
$objPHPExcel->getActiveSheet()->getStyle('AA1:AC1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('AA1:AC1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('AA1:AC1')->getFill()->getStartColor()->setARGB('FF0000');
$objPHPExcel->getActiveSheet()->getStyle('AA1:AC1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


//Alto Celdas Cabecera
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(70);
//Ancho Celdas 
$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(15);
//Alineacion Celdas Cabecera
$objPHPExcel->getActiveSheet()->getStyle('A1:AQ1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:AQ1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

//Autosize Columnas
for($col = 'C'; $col !== 'K'; $col++) {
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
}


//crea archivo
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Plantilla estudio titulos.xlsx"');
$objWriter->save('php://output');
exit;
   }
else
    

{echo '<span style="color:#c10;text-align:center;"><b>No hay registros!</b></span>';}
mysql_close ();
}


?>