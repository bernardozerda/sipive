<?php
set_time_limit(0);
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
require_once('../../librerias/pdf/class.ezpdf.php');
$pdf =& new Cezpdf('a4',$orientation='landscape');
$pdf->selectFont('../../librerias/pdf/fonts/TimesNewRoman.afm');
$pdf->ezSetCmMargins(1,1.5,2,2);

$queCal = "SELECT 
	seqFormulario, 
	ROUND(valB1,4) AS valB1, 
	ROUND(valB2,4) AS valB2, 
	ROUND(valB3,4) AS valB3, 
	ROUND(valB4) AS valB4, 
	ROUND(valB5,2) AS valB5, 
	ROUND(valB6,4) AS valB6, 
	ROUND(valB7,4) AS valB7, 
	ROUND(valB8,4) AS valB8, 
	ROUND(valB9) AS valB9, 
	ROUND(valTotalCalificacion,4) AS valTotalCalificacion, 
	ROUND(valTransformado,4) AS valTransformado 
	FROM t_frm_calificacion_plan2 
	WHERE fchCalificacion LIKE '%".$_GET[fchCal]."%'";
	
$resCal = mysql_query($queCal) or die(mysql_error());

// FORMATO DE FECHA PARA IMPRIMIR
$ano = substr($_GET[fchCal],0,4);
$mes = substr($_GET[fchCal],5,2);
$dia = substr($_GET[fchCal],8,2);
$formatFecha = $dia."/".$mes."/".$ano; 

// PREPARANDO ARREGLO CON LOS VALORES
$ixx = 0;
while($datatmp = mysql_fetch_assoc($resCal)) {
	$ixx = $ixx + 1;
	$data[] = array_merge($datatmp, array('num'=>$ixx));
}

// ARMANDO ARREGLO CON LOS TITULOS
$titles = array(
	'num'=>"<b>No.</b>",
	'seqFormulario'=>"<b>Formulario</b>",
	'valB1'=>"<b>Ingresos\nHogar</b>",
	'valB2'=>utf8_decode("<b>Tasa Dependencia Económica  </b>"),
	'valB3'=>"<b>Analfabetismo Bajo Nivel Educativo</b>",
	'valB4'=>utf8_decode("<b>Tamaño Hogar</b>"),
	'valB5'=>"<b>Hogar Monoparental</b>",
	'valB6'=>utf8_decode("<b>Niñez</b>"),
	'valB7'=>"<b>Adultez</b>",
	'valB8'=>"<b>Discapacidad</b>",
	'valB9'=>utf8_decode("<b>Minoría\nEtnica</b>"),
	'valTotalCalificacion'=>"<b>Puntaje\nHogar</b>",
	'valTransformado'=>"<b>Puntaje Transformado</b>"
);

// OPCIONES GENERALES DEL ARCHIVO
$options = array(
	'shadeCol'=>array(0.9,0.9,0.9),
	'xOrientation'=>'center',
	'fontSize' => '8',
	'cols'=>array('num'=>array('width'=>35,'justification'=>'left'), 
					'seqFormulario'=>array('width'=>55,'justification'=>'left'),
					'valB1'=>array('width'=>55,'justification'=>'right'), 
					'valB2'=>array('width'=>60,'justification'=>'right','spacing'=>1.5), 
					'valB3'=>array('width'=>66,'justification'=>'right'),
					'valB4'=>array('width'=>55,'justification'=>'right'),
					'valB5'=>array('width'=>63,'justification'=>'right'), 
					'valB6'=>array('width'=>55,'justification'=>'right'), 
					'valB7'=>array('width'=>55,'justification'=>'right'),
					'valB8'=>array('width'=>62,'justification'=>'right'), 
					'valB9'=>array('width'=>40,'justification'=>'center'), 
					'valTotalCalificacion'=>array('width'=>55,'justification'=>'right'), 
					'valTransformado'=>array('width'=>64,'justification'=>'right')),
	'width'=>720
);

// IMPRIMIENDO EL PDF
$txttit = "<b>SISFV - HOGARES CALIFICADOS EL DIA ".$formatFecha."</b> \n";
$pdf->ezText($txttit, 12, array('justification' => 'center'));
//$pdf->ezImage("../../recursos/imagenes/bta_positiva_carta.jpg", 0, 420, 'none', 'left');
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n", 8);
$pdf->ezText("<b>Reporte generado: ".date("d/m/Y H:i:s"), 8, array('justification' => 'right'));
$pdf->ezStream();
?>