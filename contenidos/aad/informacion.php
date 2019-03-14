<?php

/**
 * VER INFORMACION DE ACTOS ADMINISTRATIVOS
 * @author Bernardo Zerda
 * @version 4.0 Junio de 2018
 */

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aadTipo.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aad.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );

$claTipoActo = new aadTipo();
$arrTipoActo = $claTipoActo->cargarTipoActo();

$claActo = new aad();
$claActo->cargarActo($_POST['seqTipoActo'],mb_ereg_replace("[^0-9]","",$_POST['numActo']),$_POST['fchActo']);

$claSmarty->assign( "arrPost"     , $_POST       );
$claSmarty->assign( "claActo"     , $claActo     );
$claSmarty->assign( "arrTipoActo" , $arrTipoActo );

$claSmarty->display( "aad/informacion.tpl" );

?>