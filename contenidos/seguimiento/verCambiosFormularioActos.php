<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );

$seqFormulario = intval($_POST['seqFormulario']);
$seqSeguimiento = intval($_POST['seqSeguimiento']);
$seqFormularioActo = intval($_POST['seqFormularioActo']);

if ($seqFormularioActo != 0) {
    $claSeguimiento = new Seguimiento;
    $claSeguimiento->seqSeguimiento = $seqSeguimiento;
    $claSeguimiento->seqFormulario = $seqFormulario;
    $claSeguimiento->seqFormularioActo = $seqFormularioActo;
    $arrRegistros = $claSeguimiento->obtenerRegistrosActos();
} else {
    $claSeguimiento->arrErrores[] = "No hay seguimientos registrados para este formulario";
}

if (empty($claSeguimiento->arrErrores)) {

    if (strpos($arrRegistros[$seqSeguimiento]['txtCambios'], "<br>") !== false) {
        $arrRegistros[$seqSeguimiento]['txtCambios'] = ereg_replace("<br>", "\n", $arrRegistros[$seqSeguimiento]['txtCambios']);
    }

    $arrLineas = $claSeguimiento->parserTextoCambios($arrRegistros[$seqSeguimiento]['txtCambios']);

    $claSmarty->assign("numAlto", ( $_POST['alto'] - 80));
    $claSmarty->assign("registroSeguimiento", $seqSeguimiento);
    $claSmarty->assign("arrLineas", $arrLineas);
    $claSmarty->display("seguimiento/verCambios.tpl");
} else {
    imprimirMensajes($claSeguimiento->arrErrores, array());
}
?>
