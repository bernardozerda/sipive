<?php

/*
 * MODULO DE LEGALIZACIÓN MI CASA YA!
 * @author Liliana Marcela Basto
 * version 1.0 Julio de 2019
 * and open the template in the editor.
 */

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

$claSmarty->display( "legalizacionMCY/legalizacion.tpl" );
