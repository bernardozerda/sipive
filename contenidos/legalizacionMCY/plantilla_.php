<?php

ini_set("memory_limit", "-1");

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );

$arrTitulos[] = "No";
$arrTitulos[] = "ID HOGAR";
$arrTitulos[] = "TIPO DOC PPAL";
$arrTitulos[] = "DOCUMENTO PPAL";
$arrTitulos[] = "NOMBRES";
$arrTitulos[] = "APELLIDOS";
$arrTitulos[] = "TIPO DOC VENDEDOR";
$arrTitulos[] = "No DOCUMENTO VENDEDOR";
$arrTitulos[] = "NOMBRE VENDEDOR";
$arrTitulos[] = "NOMBRE DEL PROYECTO";
$arrTitulos[] = "DEPARTAMENTO";
$arrTitulos[] = "MUNICIPIO";
$arrTitulos[] = "TITULAR CUENTA";
$arrTitulos[] = "TIPO DOC TITULAR";
$arrTitulos[] = "DOCUMENTO TITULAR";
$arrTitulos[] = "ENTIDAD FINANCIERA";
$arrTitulos[] = "TIPO CUENTA";
$arrTitulos[] = "NUMERO CUENTA";
$arrTitulos[] = "No ACTO ADMON";
$arrTitulos[] = "RANGO INGRESOS";
$arrTitulos[] = "FECHA ACTO ADMON";
$arrTitulos[] = "VALOR SUBSIDIO";

header("Content-type: text/csv");
header("Content-disposition: attachment; filename=plantilla_legalizacion_MCY_" . date("ymdHis") . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

// coloca el texto del titulo
foreach ($arrTitulos as $numColumna => $txtTitulo) {
    echo utf8_decode($txtTitulo) . "\t";
}
echo "\r\n";
?>