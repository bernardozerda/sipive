<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ArchivoMCY.class.php" );

$arrErrores = array();

$arrTipoDocumento = obtenerDatosTabla(
    "t_ciu_tipo_documento",
    array("seqTipoDocumento","txtTipoDocumento"),
    "seqTipoDocumento"
);

$claArchivoMcy = new ArchivoMCY();

$arrListado = array();
if(doubleval($_POST['numDocumento']) != 0 or doubleval($_POST['seqTipoDocumento']) != 0){
    $arrListado = $claArchivoMcy->listado($_POST['seqTipoDocumento'],$_POST['numDocumento']);
}

$claSmarty->assign("arrListado",$arrListado);
$claSmarty->assign("arrTipoDocumento",$arrTipoDocumento);
$claSmarty->display("archivoMcy/archivoMcy.tpl");


?>