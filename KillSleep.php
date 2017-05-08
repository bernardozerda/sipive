<?php

$txtPrefijoRuta = "";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

$result = mysql_query("SHOW processlist");
$myrow = mysql_fetch_array($result);
while ($myrow = mysql_fetch_assoc($result)) {
    if ($myrow['Command'] == "Sleep" && $myrow['Time'] >= 60) {
        mysql_query("KILL {$myrow['Id']}");
        echo "<br> KILL" . $myrow['Id'];
    }
}
?>
