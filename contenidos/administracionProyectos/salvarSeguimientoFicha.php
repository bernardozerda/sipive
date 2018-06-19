<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$txtPrefijoRuta = "../../";

// Autenticacion (si esta logueado no no)
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

// Inclusiones necesarias
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Oferente.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Proyecto.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "RegistroActividades.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "DatosGeneralesProyectos.class.php" );


/**
 * Validacion del formulario de oferentes
 */
$arrErrores = array();
$claProyecto = new Proyecto();
$claDatosProy = new DatosGeneralesProyectos();
$id = $_REQUEST['id'];
/**
 * Salvar o editar Proyectos si no hay errores
 */
if (empty($arrErrores)) {
    $idProyecto = 0;
    $seqSeguimientoFicha = 0;
    $idProyecto = $_REQUEST['seqProyecto'];



    if (isset($_POST['seqSeguimientoFicha']) and is_numeric($_POST['seqSeguimientoFicha']) and $_POST['seqSeguimientoFicha'] > 0) {
       
        $arrErrores = $claProyecto->editarSeguimientoFicha($_POST, count($_POST['txtFichaTexto']));
        $idProyecto = $_REQUEST['seqProyecto'];
        $seqSeguimientoFicha = $_REQUEST['seqSeguimientoFicha'];
        //$claRegistro->registrarActividad("Edicion", 0, $_SESSION['seqUsuario'], "Edicion de Oferente: [" . $_POST['seqEditar'] . "] " . trim($_POST['nombre']) . " Mensaje: " . implode(",", $arrErrores));
    } else {
        $arrErrores = $claProyecto->almacenarSeguimientoFicha($_POST);
        //$claRegistro->registrarActividad("Creacion", 0, $_SESSION['seqUsuario'], "Creacion de Oferente: " . trim($_POST['nombre']) . " Mensaje: " . implode(",", $arrErrores));
    }
    $txtPlantilla = "proyectos/vistas/inscripcionSeguimiento.tpl";
    // echo "<br> **** idProyecto ->".$idProyecto ." seguimiento Ficha ->".$seqSeguimientoFicha."***<br>";
    $arraSegFicha = $claDatosProy->obtenerSeguimientosFicha($idProyecto, $seqSeguimientoFicha);
    $arrProyectos = $claDatosProy->obtenerlistaProyectos($idProyecto, $id);
    $arrayTextos = $claDatosProy->obtenerlistaTextos($seqSeguimientoFicha);
    $arrGrupoGestion = $claDatosProy->obtenerDatosGestion();
}

/**
 * Impresion de resultados
 */
if (empty($arrErrores)) {
    //pr ($arrErrores);
    $arrMensajes[] = "El Seguimiento <b>" . $_POST['numSeguimientoFicha'] . "</b> se ha Alamcenado con Éxito!!!";
    imprimirMensajes(array(), $arrMensajes, "mensajes");
    $seqUsuario = $_SESSION['seqUsuario'];
    $claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
    $claSmarty->assign("seqProyecto", $_REQUEST['seqProyecto']);
    $claSmarty->assign("arraSegFicha", $arraSegFicha);
    $claSmarty->assign("arrayTextos", $arrayTextos);
    $claSmarty->assign("page", "datosSeguimientoFicha.php?tipo=1&id=" . $id);
    $claSmarty->display($txtPlantilla);
} else {
    imprimirMensajes($arrErrores, array());
}

// Desconecta la base de datos
$aptBd->close();
