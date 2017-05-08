<?php

// FORMATO DE FECHA PARA IMPRIMIR
$ano = substr($_GET[fchCal], 0, 4);
$mes = substr($_GET[fchCal], 5, 2);
$dia = substr($_GET[fchCal], 8, 2);
$formatFecha = $dia . "/" . $mes . "/" . $ano;
$filename = "Calificacion_" . $dia . "_" . $mes . "_" . $ano . ".xls";

$fecha = substr_replace($_GET[fchCal], ' ', -9, 1);

header("Content-disposition: attachment; filename=$filename");
header("Content-Type: application/force-download");
header("Content-Type: application/vnd.ms-excel; charset=utf-8;");
header("Content-Transfer-Encoding: binary");
header("Pragma: no-cache");
header("Expires: 1");


$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

$queCal = "SELECT T_FRM_CALIFICACION_PLAN2.seqFormulario,
       numDocumento,
       UPPER(CONCAT(txtNombre1,
                    ' ',
                    txtNombre2,
                    ' ',
                    txtApellido1,
                    ' ',
                    txtApellido2))
          AS nombreCompleto,
       CONCAT(numTelefono1,
              '-',
              numTelefono2,
              '-',
              numCelular)
          AS telefonos,
       ROUND(divB1, 4) AS divB1,
       ROUND(valB1, 4) AS valB1,
       ROUND(divB2, 4) AS divB2,
       ROUND(valB2, 4) AS valB2,
       ROUND(divB3, 4) AS divB3,
       ROUND(valB3, 4) AS valB3,
       ROUND(valB4) AS valB4,
       ROUND(divB5, 4) AS divB5,
       ROUND(valB5, 2) AS valB5,
       ROUND(divB6, 4) AS divB6,
       ROUND(valB6, 4) AS valB6,
       ROUND(divB7, 4) AS divB7,
       ROUND(valB7, 4) AS valB7,
       ROUND(divB8, 4) AS divB8,
       ROUND(valB8, 4) AS valB8,
       ROUND(divB9) AS divB9,
       ROUND(valB9) AS valB9,
       ROUND(valTotalCalificacion, 4) AS valTotalCalificacion,
       ROUND(valTransformado, 4) AS valTransformado
  FROM T_FRM_CALIFICACION_PLAN2
       INNER JOIN T_FRM_FORMULARIO
          ON (T_FRM_CALIFICACION_PLAN2.seqFormulario =
                 T_FRM_FORMULARIO.seqFormulario)
       INNER JOIN T_FRM_HOGAR
          ON (T_FRM_CALIFICACION_PLAN2.seqFormulario =
                 T_FRM_HOGAR.seqFormulario)
       INNER JOIN T_CIU_CIUDADANO
          ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano)
    WHERE fchCalificacion LIKE '%" . $fecha . "%'
    AND seqParentesco = 1
";

$resCal = mysql_query($queCal) or die(mysql_error());

// PREPARANDO ARREGLO CON LOS VALORES
$consecutivo = 0;


echo utf8_decode("No.") . "\t";
echo ("Formulario") . "\t";
echo utf8_decode("Cédula PPal") . "\t";
echo"Nombre Completo" . "\t";
echo "Telefono Fijo 1" . "\t";
echo"Telefono Fijo 2" . "\t";
echo"Celular" . "\t";
echo("Valor IH") . "\t";
echo ("Ingresos Hogar") . "\t";
echo ("Valor TDE") . "\t";
echo ("Tasa Dependencia Económica") . "\t";
echo ("Valor ANALF") . "\t";
echo ("Analfabetismo Bajo Nivel Educativo") . "\t";
echo utf8_decode("Tamaño Hogar") . "\t";
echo ("Valor HM") . "\t";
echo ("Hogar Monoparental") . "\t";
echo ("Valor M14") . "\t";
echo utf8_decode("Niñez") . "\t";
echo ("Valor My60") . "\t";
echo ("Adultez") . "\t";
echo ("Valor DISC") . "\t";
echo ("Discapacidad") . "\t";
echo ("Valor ME") . "\t";
echo utf8_decode("Minoría Etnica") . "\t";
echo ("Puntaje Hogar") . "\t";
echo ("Puntaje Transformado") . "\t";
echo "\r\n";
while ($rowCalifica = mysql_fetch_assoc($resCal)) {
    $consecutivo = $consecutivo + 1;
    $telefonos = explode("-", $rowCalifica['telefonos']);

    echo ($consecutivo) . "\t";
    echo ($rowCalifica['seqFormulario']) . "\t";
    echo ($rowCalifica['numDocumento']) . "\t";
    echo ($rowCalifica['nombreCompleto']) . "\t";
    echo ($telefonos[0]) . "\t";
    echo ($telefonos[1]) . "\t";
    echo ($telefonos[2]) . "\t";
    echo (round($rowCalifica['divB1'], 2)) . "\t";
    echo (round($rowCalifica['valB1'], 2)) . "\t";
    echo (round($rowCalifica['divB2'], 2)) . "\t";
    echo (round($rowCalifica['valB2'], 2)) . "\t";
    echo (round($rowCalifica['divB3'], 2)) . "\t";
    echo (round($rowCalifica['valB3'], 2)) . "\t";
    echo (round($rowCalifica['valB4'], 2)) . "\t";
    echo (round($rowCalifica['divB5'], 2)) . "\t";
    echo (round($rowCalifica['valB5'], 2)) . "\t";
    echo (round($rowCalifica['divB6'], 2)) . "\t";
    echo (round($rowCalifica['valB6'], 2)) . "\t";
    echo (round($rowCalifica['divB7'], 2)) . "\t";
    echo (round($rowCalifica['valB7'], 2)) . "\t";
    echo (round($rowCalifica['divB8'], 2)) . "\t";
    echo (round($rowCalifica['valB8'], 2)) . "\t";
    echo (round($rowCalifica['divB9'], 2)) . "\t";
    echo (round($rowCalifica['valB9'], 2)) . "\t";
    echo (round($rowCalifica['valTotalCalificacion'], 3)) . "\t";
    echo number_format($rowCalifica['valTransformado'], 2, '.', ',') . "\t";
    // echo(str_replace (",",".",$rowCalifica['valTransformado'])) . "\t";
    echo "\r\n";
}
?>