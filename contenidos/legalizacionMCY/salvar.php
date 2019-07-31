<?php

ini_set("memory_limit", "-1");

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "LegalizacionMCY.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "PHPExcel.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "PHPExcel/Writer/Excel2007.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "PHPExcel/IOFactory.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Desembolso.class.php" );



$arrErrores = array();

$claLegalizacionMcy = new LegalizacionMCY();
$claDesembolso = new Desembolso();

$arrArchivo = $claLegalizacionMcy->cargarArchivo();
if (empty($claLegalizacionMcy->arrErrores)) {
    $claLegalizacionMcy->validarTitulos($arrArchivo[0]);
    if (empty($claLegalizacionMcy->arrErrores)) {
        unset($arrArchivo[0]);
        $claLegalizacionMcy->validarformularios($arrArchivo);
        if (empty($claLegalizacionMcy->arrErrores)) {
            $claLegalizacionMcy->salvarDatosFaseI($arrArchivo, $claDesembolso);
           
        } else {
            $claLegalizacionMcy->mostrarErrores();
        }

        //$claArchivoMcy->salvar($arrArchivo);
    } else {
        $claLegalizacionMcy->mostrarErrores();
    }
} else {
    $claLegalizacionMcy->mostrarErrores();
}

$claSmarty->assign("arrMensajes", $claLegalizacionMcy->arrMensajes);
$claSmarty->assign("arrErrores", $claLegalizacionMcy->arrErrores);
$claSmarty->display("legalizacionMCY/legalizacion.tpl");
?>