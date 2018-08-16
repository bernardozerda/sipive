<?php

/**
 * DESCARGA EL ARCHIVO DE CARGUE
 */

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "InscripcionFonvivienda.class.php" );

$claInscripcion = new InscripcionFonvivienda();

$arrArchivo = $claInscripcion->obtenerArchivo($_GET['seqCargue']);

$txtArchivo = $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "inscripcionFonvivienda/" . $arrArchivo['fisico'];

if(file_exists($txtArchivo)){

    header("Content-Type:text/plain; charset=utf-8");
    header("Content-disposition: attachment; filename=" . $arrArchivo['nombre']);
    header("Content-Transfer-Encoding: binary");
    header("Pragma: no-cache");
    header("Expires: 0");

    echo utf8_decode(file_get_contents($txtArchivo));

}else{
    echo "No existe el archivo";
}




?>