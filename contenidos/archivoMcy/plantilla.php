<?php

ini_set("memory_limit","-1");

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );

$arrTitulos[] = "ID";
$arrTitulos[] = "NIT";
$arrTitulos[] = "ENTIDAD";
$arrTitulos[] = "TIPO DOCUMENTO";
$arrTitulos[] = "DOCUMENTO";
$arrTitulos[] = "NOMBRE";
$arrTitulos[] = "FECHA";
$arrTitulos[] = "VALOR";
$arrTitulos[] = "JUSTIFICACION";
$arrTitulos[] = "REPORTAR";
$arrTitulos[] = "DETALLE";

$sql = "
    select 
        seqArchivoMcy,
        numNIT,
        txtEntidad,
        seqTipoDocumento,
        numDocumento,
        txtNombre,
        fchAsignacion,
        valAsignado,
        txtJustificacion,
        bolReportarLinea,
        txtExclusion
    from t_fnv_archivo_mcy a
";
$arrDatos = $aptBd->GetAll($sql);

header("Content-type: text/csv");
header("Content-disposition: attachment; filename=plantilla_archivo_mcy_" . date("ymdHis") . ".csv");
header("Pragma: no-cache");
header("Expires: 0");

// coloca el texto del titulo
foreach ($arrTitulos as $numColumna => $txtTitulo) {
    echo utf8_decode($txtTitulo) . "\t";
}
echo "\r\n";

foreach($arrDatos as $numLinea => $arrLinea){
    foreach($arrLinea as $numColumna => $txtValor){
        echo utf8_decode($txtValor) . "\t";
    }
    echo "\r\n";
}

?>