<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Cruces.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "RegistroActividades.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/IOFactory.php" );

foreach($_POST as $txtClave => $txtValor){
    $_POST[$txtClave] = regularizarCampo($txtClave,$txtValor);
}

$claCruces = new Cruces();
$claCruces->salvar();

// si no hay errores imprime los mensajes
if(! empty($claCruces->arrErrores)) {

    imprimirMensajes($claCruces->arrErrores);

    $claSmarty->assign("arrPost", $_POST);
    $claSmarty->display("cruces2/formularioCruces.tpl");

}else{

    imprimirMensajes($claCruces->arrErrores, $claCruces->arrMensajes);

    $arrCruces = $claCruces->listado($_POST);
    $claSmarty->assign( "arrCruces", $arrCruces );
    $claSmarty->display( "cruces2/cruces.tpl" );

}

?>