<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );

$seqFormulario = intval($_POST['seqFormulario']);

if ($seqFormulario != 0) {
    $claSeguimiento = new Seguimiento();
    $claSeguimiento->seqSeguimiento = $_POST['referencia'];
    $claSeguimiento->seqGrupoGestion = $_POST['grupoGestion'];
    $claSeguimiento->seqGestion = $_POST['gestion'];
    $claSeguimiento->fchInicial = $_POST['desde'];
    $claSeguimiento->fchFinal = $_POST['hasta'];
    $claSeguimiento->txtComentario = $_POST['comentario'];
    $claSeguimiento->txtCambios = $_POST['cambios'];
    $claSeguimiento->txtCriterio = $_POST['criterio'];
    $claSeguimiento->seqFormulario = $_POST['seqFormulario'];
    $claSeguimiento->seqFormularioActo = $_POST['seqFormularioActo'];
    
    $arrRegistros = $claSeguimiento->obtenerRegistrosActos();
} else {
    $claSeguimiento->arrErrores[] = "No hay seguimientos registrados para este proyecto";
}

if (empty($claSeguimiento->arrErrores)) {
    $claSmarty->assign("arrRegistros", $arrRegistros);
    $claSmarty->display("seguimientoProyectos/buscarSeguimiento.tpl");
} else {
    imprimirMensajes($claSeguimiento->arrErrores, array());
}
?>
