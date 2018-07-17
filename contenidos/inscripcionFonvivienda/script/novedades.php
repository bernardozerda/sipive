<?php

ini_set("memory_limit","-1");
ini_set("max_execution_time","0");
chdir(__DIR__);

$txtPrefijoRuta = "../../../";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "InscripcionFonvivienda.class.php" );

$txtLog = "./log/progreso.log";

$claInscripcion = new InscripcionFonvivienda();
$claInscripcion->ciudadanos();

foreach($claInscripcion->arrCiudadanos as $txtNombre) {
    $aptLog = fopen($txtLog,"a+");
    fwrite($aptLog, $txtNombre . "\r\n");
    fclose($aptLog);
}

?>