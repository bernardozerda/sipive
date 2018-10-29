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

$arrTitulos[] = "ID AUDITORIA";
$arrTitulos[] = "ID REGISTRO";
$arrTitulos[] = "NIT";
$arrTitulos[] = "ENTIDAD";
$arrTitulos[] = "TIPO DOCUMENTO";
$arrTitulos[] = "DOCUMENTO";
$arrTitulos[] = "NOMBRE";
$arrTitulos[] = "FECHA";
$arrTitulos[] = "VALOR";
$arrTitulos[] = "JUSTIFICACION";
$arrTitulos[] = "USUARIO";
$arrTitulos[] = "REPORTAR";
$arrTitulos[] = "EXCLUSION";
$arrTitulos[] = "MOVIMIENTO";

$sql = "
    SELECT aud.seqAuditoria,
           arc.seqArchivoMcy, 
           arc.numNIT, 
           arc.txtEntidad, 
           tdo.txtTipoDocumento, 
           arc.numDocumento, 
           arc.txtNombre, 
           arc.fchAsignacion, 
           arc.valAsignado, 
           arc.txtJustificacion, 
           upper(concat(usu.txtNombre,' ',usu.txtApellido)) as txtUsuario,
           aud.bolReportarLinea,
           aud.txtExclusion,
           aud.fchMovimiento
    FROM t_fnv_archivo_mcy_auditoria aud
    INNER JOIN t_cor_usuario usu on aud.seqUsuario = usu.seqUsuario
    INNER JOIN t_fnv_archivo_mcy arc on aud.seqArchivoMcy = arc.seqArchivoMcy
    INNER JOIN t_ciu_tipo_documento tdo on arc.seqTipoDocumento = tdo.seqTipoDocumento
    ORDER BY
      arc.seqArchivoMcy,
      aud.fchMovimiento asc
";
$arrDatos = $aptBd->GetAll($sql);

header("Content-type: text/csv");
header("Content-disposition: attachment; filename=plantilla_archivo_mcy_auditoria_" . date("ymdHis") . ".csv");
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