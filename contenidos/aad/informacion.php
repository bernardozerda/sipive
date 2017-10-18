<?php

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


$claActoAdministrativo = new aad();
if( intval($_POST['numActo']) != 0 ) {
   $claActoAdministrativo->cargarActo($_POST['seqTipoActo'], $_POST['numActo'], $_POST['fchActo']);
}

$claSmarty->assign( "arrPost" , $_POST);
$claSmarty->assign( "arrTipoActo" , $arrTipoActo );
$claSmarty->assign( "claActoAdministrativo" , $claActoAdministrativo );
$claSmarty->display( "aad/informacion.tpl" );

?>