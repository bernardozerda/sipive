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
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Usuario.class.php" );

$claCruces = new Cruces();
$claCruces->cargar($_POST['seqCruce']);

$arrVer = array();
foreach($claCruces->arrDatos['arrResultado'] as $seqResultado => $arrDato) {
    $seqFormulario = $arrDato['seqFormulario'];
    $arrVer[$seqFormulario]['documento'] = $arrDato['numDocumentoPrincipal'];
    $arrVer[$seqFormulario]['nombre'] = $arrDato['txtNombrePrincipal'];
    $arrVer[$seqFormulario]['estado'] = $arrDato['txtEstadoFormulario'];
    if($arrVer[$seqFormulario]['inhabilitar'] != 1) {
        $arrVer[$seqFormulario]['inhabilitar'] = $arrDato['bolInhabilitar'];
    }
}

$claSmarty->assign( "claCruces", $claCruces );
$claSmarty->assign( "arrVer", $arrVer );
$claSmarty->display( "cruces2/ver.tpl" );

?>