<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aadProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );

$claActo = new aadProyectos();
$claActo->salvar($_POST,$_FILES);

imprimirMensajes($claActo->arrErrores, $claActo->arrMensajes);

if(! empty($claActo->arrErrores)){
    $arrTipos = $claActo->tiposActos();
    $claSmarty->assign("arrTipos",$arrTipos);
    $claSmarty->assign("arrPost",$_POST);
    $claSmarty->assign("txtMensaje","");
    $claSmarty->display( "aadProyectos/crear.tpl" );
}else {
    $claSmarty->assign("arrActos", $claActo->listar());
    $claSmarty->display("aadProyectos/aadProyectos.tpl");
}

?>