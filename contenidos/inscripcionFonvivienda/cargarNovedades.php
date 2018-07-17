<?php

/**
 * LANZA EL SCRIPT EN SEGUNDO PLANO DEL CARGUE DE NOVEDADES DEL ARCHIVO DE FONVIVIENDA
 */

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "InscripcionFonvivienda.class.php" );

$txtComando = "/opt/lamp/bin/php " . __DIR__ . "/script/novedades.php &";

echo $txtComando . "<br>";

exec($txtComando,$salida);

echo "termina";






?>