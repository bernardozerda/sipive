<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "RegistroActividades.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aadTipo.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aad.class.php" );

// clases necesarias
$claActo     = new aad();
$claTipoActo = new aadTipo();

// carga los tipos de actos a salvar
$arrTipoActo = $claTipoActo->cargarTipoActo();

// elimia el acto administrativo
$claActo->eliminar( $_POST['seqTipoActo'] , $_POST['numActo'] , $_POST['fchActo'] );

// si no hay errores manda el mensaje
if( empty( $claActo->arrErrores ) ){
    $arrMensajes[] = "Se ha eliminado el acto administrativo " . $_POST['numActo'] . " de " . $_POST['fchActo'];
}

$claSmarty->assign( "arrTipoActo" , $arrTipoActo            );
$claSmarty->assign( "arrMensajes" , $arrMensajes            );
$claSmarty->assign( "arrErrores"  , $claActo->arrErrores    );
$claSmarty->assign( "arrActos"    , $claActo->listarActos() );

$claSmarty->display( "aad/aad.tpl" );

?>