<?php

/**
 * MODULO DE ACTOS ADMINISTRATIVOS
 * @author Bernardo Zerda
 * @version 3.0 Diciembre de 2013
 */

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aadTipo.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aad.class.php" );

$claTipoActo = new aadTipo();
$arrTipoActo = $claTipoActo->cargarTipoActo();

$claActosAdministrativos = new aad();
$arrActos = $claActosAdministrativos->listarActos();

$claSmarty->assign( "arrPost" , $_POST );
$claSmarty->assign( "arrTipoActo" , $arrTipoActo );
$claSmarty->assign( "arrActos"    , $arrActos    );
$claSmarty->display( "aad/aad.tpl" );

?>