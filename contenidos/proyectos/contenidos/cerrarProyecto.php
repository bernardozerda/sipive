<?php

$txtPrefijoRuta = "../../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ProyectoVivienda.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoProyectos.class.php" );


if (isset($_POST['seqProyecto'])) {

    $claProyectoViviendaActual = new ProyectoVivienda();
    $claSeguimiento = new SeguimientoProyectos();

    $seqProyecto = $_POST['seqProyecto'];
    $seqEstadoProcesoProyecto = 8;
    $seqEstadoProcesoProyectoAnt = $_POST['seqPryEstadoProcesoAnt'];
    $seqGestion = $_POST['seqGestion'];
    $txtComentarios = $_POST['txtComentario'];



    $error = $claProyectoViviendaActual->editarEstadoProyectoVivienda($seqProyecto, $seqEstadoProcesoProyecto);

    $arrayDatosProyNew = Array();
    $arrayDatosProyOld = Array();
    $arrayDatosProyOld[$seqProyecto]['seqPryEstadoProceso'] = "Se modifico el estado del proyecto de " . $seqEstadoProcesoProyectoAnt;
    $arrayDatosProyNew[$seqProyecto]['seqPryEstadoProceso'] = " A estado proceso cierre seqRstadoProceso " . $seqEstadoProcesoProyecto;
    $error .= $claSeguimiento->almacenarSeguimiento($seqProyecto, $txtComentarios, $seqGestion, $arrayDatosProyOld, $arrayDatosProyNew);
    if ($error != "") {
        echo 'true';
    } else {
        echo  $error;
    }
}

