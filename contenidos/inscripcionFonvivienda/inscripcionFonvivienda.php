<?php

/**
 * LISTADO DE CARGUES DE LOS ARCHIVOS DE FONVIVIENDA
 */

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "InscripcionFonvivienda.class.php" );

$claInscripcion = new InscripcionFonvivienda();

$claSmarty->assign("claInscripcion" , $claInscripcion);
$claSmarty->display("inscripcionFonvivienda/inscripcionFonvivienda.tpl")

?>