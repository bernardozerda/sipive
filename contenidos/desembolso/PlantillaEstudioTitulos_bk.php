<?php
 /**
* PLANTILLA ESTUDIO DE TITULOS
* @author Andres Martinez
* @version 1.0 Marzo 2016
*/

ini_set('memory_limit','128M');

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
       T_CIU_CIUDADANO.numDocumento AS 'CC Postulante principal' ,
        T_CIU_TIPO_DOCUMENTO.txtTipoDocumento
           AS 'Tipo de Documento',
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
        CONCAT('Res. ',
               T_AAD_ACTO_ADMINISTRATIVO.numActo,
               ' de ',
               MAX(YEAR(T_AAD_ACTO_ADMINISTRATIVO.fchacto)))
           AS 'Resolucion Vinculacion'
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
      INNER JOIN T_AAD_ACTO_ADMINISTRATIVO
         ON (    T_AAD_HOGARES_VINCULADOS.numActo =
                    T_AAD_ACTO_ADMINISTRATIVO.numActo
             AND T_AAD_HOGARES_VINCULADOS.fchActo =
                    T_AAD_ACTO_ADMINISTRATIVO.fchActo)          
       
      
      
 WHERE     T_FRM_HOGAR.seqParentesco = 1
       AND T_DES_ESCRITURACION.seqFormulario IN   (". $seqFormularios .")"
         . "GROUP BY T_DES_ESCRITURACION.seqFormulario";
 
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
        ->SetCellValue('Q1', 'RESOLUCIÓN VINCULACION')
        ->SetCellValue('R1', 'No. ESCRITURA')
        ->SetCellValue('S1', 'FECHA ESCRITURA (D/M/A)')
        ->SetCellValue('T1', 'NOTARIA')
        ->SetCellValue('U1', 'CIUDAD NOTARIA')
        ->SetCellValue('V1', 'FOLIO DE MATRICULA')
        ->SetCellValue('W1', 'ZONA OFICINA REGISTRO')
        ->SetCellValue('X1', 'CIUDAD OFICINA REGISTRO')
        ->SetCellValue('Y1', 'FECHA FOLIO (D/M/A)')
        ->SetCellValue('Z1', 'RESOLUCION DE VINCULACION COINCIDENTE')
        ->SetCellValue('AA1', 'BENEFICIARIOS DEL SDV COINCIDENTES')
        ->SetCellValue('AB1', 'NOMBRE Y CEDULA DE LOS PROPIETARIOS EN EL CTL INCIDENTES')
        ->SetCellValue('AC1', 'CONSTITUCION PATRIMONIO FAMILIA')
        ->SetCellValue('AD1', 'INDAGACION AFECTACION A VIVIENDA FAMILIAR')
        ->SetCellValue('AE1', 'RESTRICCIONES')
        ->SetCellValue('AF1', 'ESTADO CIVIL COINCIDENTE')
        ->SetCellValue('AG1', 'CARTA DE VINCULACION Y/O RESOLUCION PROTOCOLIZADA')
        ->SetCellValue('AH1', 'No. DE ANOTACION CTL COMPRAVENTA')
        ->SetCellValue('AI1', 'SE CANCELA HIPOTECA MAYOR EXTENSION (SI LA HUBIERE)')   
        ->SetCellValue('AJ1', 'PATRIMONIO DE FAMILIA REGISTRADO')
        ->SetCellValue('AK1', 'PROHIBICION DE TRANSFERENCIA Y DERECHO DE PREFERENCIA REGISTRADOS')
        ->SetCellValue('AL1', 'IMPRESION DE CONSULTA FONVIVIENDA (HOGARES VICTIMAS)')
        ->SetCellValue('AM1', 'ELABORO')
        ->SetCellValue('AN1', 'APROBO')
        ->SetCellValue('AO1', 'SE VIABILIZA JURIDICAMENTE')
        ->SetCellValue('AP1', 'OBSERVACION');
   
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
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('Q'.$rowcount, $row['Resolucion Vinculacion']);

               //escribe desplegables en las columnas correspondientes   

               $objValidationZ = $objPHPExcel->getActiveSheet()->getCell('Z'.$rowcount)->getDataValidation();
               $objValidationZ->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidationZ->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP );
               $objValidationZ->setAllowBlank(true);
               $objValidationZ->setShowInputMessage(true);
               $objValidationZ->setShowErrorMessage(true);
               $objValidationZ->setShowDropDown(true);
               $objValidationZ->setErrorTitle('Error');
               $objValidationZ->setError('Valor no esta en la lista');
               $objValidationZ->setPromptTitle('Seleccion');
               $objValidationZ->setPrompt('Seleccione un valor de la lista');
               $objValidationZ->setFormula1("=seleccion");

               $objValidationAA = $objPHPExcel->getActiveSheet()->getCell('AA'.$rowcount)->getDataValidation();
               $objValidationAA->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidationAA->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidationAA->setAllowBlank(true);
               $objValidationAA->setShowInputMessage(true);
               $objValidationAA->setShowErrorMessage(true);
               $objValidationAA->setShowDropDown(true);
               $objValidationAA->setErrorTitle('Error');
               $objValidationAA->setError('Valor no esta en la lista');
               $objValidationAA->setPromptTitle('Seleccion');
               $objValidationAA->setPrompt('Seleccione un valor de la lista');
               $objValidationAA->setFormula1("=seleccion");

               $objValidationAB = $objPHPExcel->getActiveSheet()->getCell('AB'.$rowcount)->getDataValidation();
               $objValidationAB->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidationAB->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidationAB->setAllowBlank(true);
               $objValidationAB->setShowInputMessage(true);
               $objValidationAB->setShowErrorMessage(true);
               $objValidationAB->setShowDropDown(true);
               $objValidationAB->setErrorTitle('Error');
               $objValidationAB->setError('Valor no esta en la lista');
               $objValidationAB->setPromptTitle('Seleccion');
               $objValidationAB->setPrompt('Seleccione un valor de la lista');
               $objValidationAB->setFormula1("=seleccion");

               $objValidationAC = $objPHPExcel->getActiveSheet()->getCell('AC'.$rowcount)->getDataValidation();
               $objValidationAC->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidationAC->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidationAC->setAllowBlank(true);
               $objValidationAC->setShowInputMessage(true);
               $objValidationAC->setShowErrorMessage(true);
               $objValidationAC->setShowDropDown(true);
               $objValidationAC->setErrorTitle('Error');
               $objValidationAC->setError('Valor no esta en la lista');
               $objValidationAC->setPromptTitle('Seleccion');
               $objValidationAC->setPrompt('Seleccione un valor de la lista');
               $objValidationAC->setFormula1("=seleccion");

               $objValidationAD = $objPHPExcel->getActiveSheet()->getCell('AD'.$rowcount)->getDataValidation();
               $objValidationAD->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidationAD->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidationAD->setAllowBlank(true);
               $objValidationAD->setShowInputMessage(true);
               $objValidationAD->setShowErrorMessage(true);
               $objValidationAD->setShowDropDown(true);
               $objValidationAD->setErrorTitle('Error');
               $objValidationAD->setError('Valor no esta en la lista');
               $objValidationAD->setPromptTitle('Seleccion');
               $objValidationAD->setPrompt('Seleccione un valor de la lista');
               $objValidationAD->setFormula1("=seleccion");

               $objValidationAE = $objPHPExcel->getActiveSheet()->getCell('AE'.$rowcount)->getDataValidation();
               $objValidationAE->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidationAE->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidationAE->setAllowBlank(true);
               $objValidationAE->setShowInputMessage(true);
               $objValidationAE->setShowErrorMessage(true);
               $objValidationAE->setShowDropDown(true);
               $objValidationAE->setErrorTitle('Error');
               $objValidationAE->setError('Valor no esta en la lista');
               $objValidationAE->setPromptTitle('Seleccion');
               $objValidationAE->setPrompt('Seleccione un valor de la lista');
               $objValidationAE->setFormula1("=seleccion");

               $objValidationAF = $objPHPExcel->getActiveSheet()->getCell('AF'.$rowcount)->getDataValidation();
               $objValidationAF->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidationAF->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidationAF->setAllowBlank(true);
               $objValidationAF->setShowInputMessage(true);
               $objValidationAF->setShowErrorMessage(true);
               $objValidationAF->setShowDropDown(true);
               $objValidationAF->setErrorTitle('Error');
               $objValidationAF->setError('Valor no esta en la lista');
               $objValidationAF->setPromptTitle('Seleccion');
               $objValidationAF->setPrompt('Seleccione un valor de la lista');
               $objValidationAF->setFormula1("=seleccion");

               $objValidationAG = $objPHPExcel->getActiveSheet()->getCell('AG'.$rowcount)->getDataValidation();
               $objValidationAG->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidationAG->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidationAG->setAllowBlank(true);
               $objValidationAG->setShowInputMessage(true);
               $objValidationAG->setShowErrorMessage(true);
               $objValidationAG->setShowDropDown(true);
               $objValidationAG->setErrorTitle('Error');
               $objValidationAG->setError('Valor no esta en la lista');
               $objValidationAG->setPromptTitle('Seleccion');
               $objValidationAG->setPrompt('Seleccione un valor de la lista');
               $objValidationAG->setFormula1("=seleccion");

               $objValidationAI = $objPHPExcel->getActiveSheet()->getCell('AI'.$rowcount)->getDataValidation();
               $objValidationAI->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidationAI->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidationAI->setAllowBlank(true);
               $objValidationAI->setShowInputMessage(true);
               $objValidationAI->setShowErrorMessage(true);
               $objValidationAI->setShowDropDown(true);
               $objValidationAI->setErrorTitle('Error');
               $objValidationAI->setError('Valor no esta en la lista');
               $objValidationAI->setPromptTitle('Seleccion');
               $objValidationAI->setPrompt('Seleccione un valor de la lista');
               $objValidationAI->setFormula1("=seleccion");

               $objValidationAJ = $objPHPExcel->getActiveSheet()->getCell('AJ'.$rowcount)->getDataValidation();
               $objValidationAJ->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidationAJ->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidationAJ->setAllowBlank(true);
               $objValidationAJ->setShowInputMessage(true);
               $objValidationAJ->setShowErrorMessage(true);
               $objValidationAJ->setShowDropDown(true);
               $objValidationAJ->setErrorTitle('Error');
               $objValidationAJ->setError('Valor no esta en la lista');
               $objValidationAJ->setPromptTitle('Seleccion');
               $objValidationAJ->setPrompt('Seleccione un valor de la lista');
               $objValidationAJ->setFormula1("=seleccion1");

               $objValidationAK = $objPHPExcel->getActiveSheet()->getCell('AK'.$rowcount)->getDataValidation();
               $objValidationAK->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidationAK->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidationAK->setAllowBlank(true);
               $objValidationAK->setShowInputMessage(true);
               $objValidationAK->setShowErrorMessage(true);
               $objValidationAK->setShowDropDown(true);
               $objValidationAK->setErrorTitle('Error');
               $objValidationAK->setError('Valor no esta en la lista');
               $objValidationAK->setPromptTitle('Seleccion');
               $objValidationAK->setPrompt('Seleccione un valor de la lista');
               $objValidationAK->setFormula1("=seleccion");

               $objValidationAL = $objPHPExcel->getActiveSheet()->getCell('AL'.$rowcount)->getDataValidation();
               $objValidationAL->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidationAL->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidationAL->setAllowBlank(true);
               $objValidationAL->setShowInputMessage(true);
               $objValidationAL->setShowErrorMessage(true);
               $objValidationAL->setShowDropDown(true);
               $objValidationAL->setErrorTitle('Error');
               $objValidationAL->setError('Valor no esta en la lista');
               $objValidationAL->setPromptTitle('Seleccion');
               $objValidationAL->setPrompt('Seleccione un valor de la lista');
               $objValidationAL->setFormula1("=seleccion1");

               $objValidationAO = $objPHPExcel->getActiveSheet()->getCell('AO'.$rowcount)->getDataValidation();
               $objValidationAO->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
               $objValidationAO->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
               $objValidationAO->setAllowBlank(true);
               $objValidationAO->setShowInputMessage(true);
               $objValidationAO->setShowErrorMessage(true);
               $objValidationAO->setShowDropDown(true);
               $objValidationAO->setErrorTitle('Error');
               $objValidationAO->setError('Valor no esta en la lista');
               $objValidationAO->setPromptTitle('Seleccion');
               $objValidationAO->setPrompt('Seleccione un valor de la lista');
               $objValidationAO->setFormula1("=seleccion");

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
      $objPHPExcel->getActiveSheet()->getStyle('R2:AP'.$registros)->getProtection()
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
$objPHPExcel->getActiveSheet()->getStyle('A1:AP1')->getAlignment()->setWrapText(true);

//cuerpo
$objPHPExcel->getActiveSheet()->getStyle('A1:AP'.($registros + 1))->applyFromArray($styleArrayBody);

//encabezado blanco
$objPHPExcel->getActiveSheet()->getStyle('A1:R1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:R1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

//gris
$objPHPExcel->getActiveSheet()->getStyle('R1:AP1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('R1:AP1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('R1:AP1')->getFill()->getStartColor()->setARGB('a9a9a9');
$objPHPExcel->getActiveSheet()->getStyle('R1:AP1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

//rojo
$objPHPExcel->getActiveSheet()->getStyle('Z1:AB1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('Z1:AB1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('Z1:AB1')->getFill()->getStartColor()->setARGB('FF0000');
$objPHPExcel->getActiveSheet()->getStyle('Z1:AB1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


//Alto Celdas Cabecera
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(70);
//Ancho Celdas 
$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(15);
//Alineacion Celdas Cabecera
$objPHPExcel->getActiveSheet()->getStyle('A1:AP1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:AP1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

//Autosize Columnas
for($col = 'C'; $col !== 'J'; $col++) {
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
}


//crea archivo
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Plantillaestudiotitulos.xlsx"');
$objWriter->save('php://output');
exit;
   }
else
    

{echo '<span style="color:#c10;text-align:center;"><b>No hay registros!</b></span>';}
mysql_close ();
}


?>