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
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/IOFactory.php" );

foreach($_POST as $txtClave => $txtValor){
    $_POST[$txtClave] = regularizarCampo($txtClave,$txtValor);
}

$claCruces = new Cruces();

// valida los campos del formulario en pantalla
$claCruces->validarFormulario($_POST);

// carga el archivo txt, xls o xlsx
$arrArchivo = $claCruces->cargarArchivo();

// valida que los datos sean coherentes con el formato del archivo
// ver la clase $claCruces->arrFormatoArchivo
$claCruces->validarArchivo($arrArchivo);

// si no hay errores procede a validar reglas de negocio y salvar
if(empty($claCruces->arrErrores)){
    $claCruces->salvar($_POST,$arrArchivo);
}

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