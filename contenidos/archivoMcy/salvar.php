<?php

ini_set("memory_limit","-1");

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ArchivoMCY.class.php" );

$arrErrores = array();

$claArchivoMcy = new ArchivoMCY();

$arrArchivo = $claArchivoMcy->cargarArchivo();
$claArchivoMcy->validarTitulos($arrArchivo[0]);
if(empty($claArchivoMcy->arrErrores)){
    unset($arrArchivo[0]);
    $claArchivoMcy->salvar($arrArchivo);
}

$claSmarty->assign("arrMensajes",$claArchivoMcy->arrMensajes);
$claSmarty->assign("arrErrores",$claArchivoMcy->arrErrores);
$claSmarty->display("archivoMcy/archivoMcy.tpl");

?>