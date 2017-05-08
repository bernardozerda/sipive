<?php

/*
 * ARCHIVO PARA ELIMINAR FISICAMENTE LAS IMAGENES
 * DE DESEMBOLSOS QUE SEQUIEREN BORRAR
 */

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );

if (file_exists($txtPrefijoRuta . $arrConfiguracion['carpetas']['imagenes'] . "desembolsos/" . $_POST['ruta'])) {
    unlink($txtPrefijoRuta . $arrConfiguracion['carpetas']['imagenes'] . "desembolsos/" . $_POST['ruta']);
}
?>
