<?php

ini_set("memory_limit","-1");

// Archivos necesarios
$txtPrefijoRuta = "./";

include( "./recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

$sql = "select * from t_ciu_ciudadano";
$objRes = $aptBd->execute($sql);

// cambiando headers
header("Content-disposition: attachment; filename=ciudadano.csv");
header("Content-Type: application/force-download");
header("Content-Type: application/vnd.ms-excel; charset=utf-8;");
header("Content-Transfer-Encoding: binary");
header("Pragma: no-cache");
header("Expires: 1");

foreach ($objRes->fields as $i => $titulo){
    echo $i . "\t";
}
echo "\r\n";

while($objRes->fields){
    foreach($objRes->fields as $j => $celda){
        echo $celda . "\t";
    }
    echo "\r\n";
    $objRes->MoveNext();
}




?>