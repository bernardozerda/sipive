<?php
echo "paso";die();
$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoProyectos.class.php" );

$seqProyecto = intval($_POST['seqProyecto']);

if ($seqProyecto != 0) {
    $claSeguimientoProyectos = new SeguimientoProyectos;

    $claSeguimientoProyectos->seqSeguimiento = $_POST['referencia'];
    $claSeguimientoProyectos->seqGrupoGestion = $_POST['grupoGestion'];
    $claSeguimientoProyectos->seqGestion = $_POST['gestion'];
    $claSeguimientoProyectos->fchInicial = $_POST['desde'];
    $claSeguimientoProyectos->fchFinal = $_POST['hasta'];
    $claSeguimientoProyectos->txtComentario = $_POST['comentario'];
    $claSeguimientoProyectos->txtCambios = $_POST['cambios'];
    $claSeguimientoProyectos->txtCriterio = $_POST['criterio'];
    $claSeguimientoProyectos->seqProyecto = $_POST['seqProyecto'];

    $arrRegistros = $claSeguimientoProyectos->obtenerRegistros();
} else {
    //pr ($arrErrores);
    $claSeguimientoProyectos->arrErrores[] = "No hay seguimientos registrados para este proyecto";
}

if (empty($claSeguimientoProyectos->arrErrores)) {
    $claSmarty->assign("arrRegistros", $arrRegistros);
    $claSmarty->display("seguimientoProyectos/buscarSeguimiento.tpl");
} else {
    imprimirMensajes($claSeguimientoProyectos->arrErrores, array());
}

//pr( $_POST );
?>
