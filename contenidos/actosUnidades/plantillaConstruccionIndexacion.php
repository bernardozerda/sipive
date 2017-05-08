<?php
/**
* CONTENIDO DEL POPUP DE AYUDA DE LA PLANTILLA DE ACTOS DE INDEXACION
* @author Jaison Ospina
* @version 1.0 Septiembre de 2015
**/

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

$claSmarty->display( "actosUnidades/plantillaConstruccionIndexacion.tpl" );