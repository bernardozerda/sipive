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
$claCruces->cargar($_POST['seqCruce']);
$arrListadoVer = $claCruces->arrDatos['arrResultado'];

$claCruces->editar();

imprimirMensajes($claCruces->arrErrores, $claCruces->arrMensajes);
if(! empty($claCruces->arrErrores)) {

    $arrVer = array();
    foreach($arrListadoVer  as $seqResultado => $arrDato) {
        $seqFormulario = $arrDato['seqFormulario'];
        $arrVer[$seqFormulario]['documento'] = $arrDato['numDocumentoPrincipal'];
        $arrVer[$seqFormulario]['nombre'] = $arrDato['txtNombrePrincipal'];
        $arrVer[$seqFormulario]['estado'] = $arrDato['txtEstadoFormulario'];
        if( (!isset($arrVer[$seqFormulario]['inhabilitar'])) or intval($arrVer[$seqFormulario]['inhabilitar']) != 1) {
            $arrVer[$seqFormulario]['inhabilitar'] = intval($arrDato['bolInhabilitar']);
        }
    }

    $claSmarty->assign( "claCruces", $claCruces );
    $claSmarty->assign( "arrVer", $arrVer );
    $claSmarty->display("cruces2/ver.tpl");
}else{
    $arrCruces = $claCruces->listado();
    $claSmarty->assign( "arrCruces", $arrCruces );
    $claSmarty->display( "cruces2/cruces.tpl" );
}
