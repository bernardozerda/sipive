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
$arrTitulos[] = "FUENTE";
$arrTitulos[] = "JUSTIFICACION";
$arrTitulos[] = "REPORTAR";
$arrTitulos[] = "DETALLE";

$sql = "
    select 
        a.seqArchivoMcy,
        a.numNIT,
        a.txtEntidad,
        a.seqTipoDocumento,
        a.numDocumento,
        a.txtNombre,
        a.fchAsignacion,
        a.valAsignado,
        f.txtFuente,
        a.txtJustificacion,
        a.bolReportarLinea,
        a.txtExclusion
    from t_fnv_archivo_mcy a
    inner join t_fnv_archivo_mcy_fuente f on a.seqFuente = f.seqFuente
    order by a.numDocumento
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