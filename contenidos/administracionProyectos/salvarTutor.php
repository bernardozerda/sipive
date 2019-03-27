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
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Constructor.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "DatosGeneralesProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "RegistroActividades.class.php" );

$arrErrores = array();
$claDatosProy = new DatosGeneralesProyectos();
$idTutor = 0;
if (isset($_POST['seqTutorProyecto']) and is_numeric($_POST['seqTutorProyecto']) and $_POST['seqTutorProyecto'] > 0) {
    $idTutor = $_REQUEST['seqTutorProyecto'];
    $arrErrores = $claDatosProy->editarTutor($_POST);

    //$claRegistro->registrarActividad( "Edicion" , 0 , $_SESSION['seqUsuario'] , "Edicion del Constructor: [" . $_POST['seqEditar'] . "] " . trim( $_POST['nombre'] ) . " Mensaje: " . implode( "," , $arrErrores ) );
} else {
    $idTutor = $claDatosProy->guardarTutor($_POST);
    //$claRegistro->registrarActividad( "Creacion" , 0 , $_SESSION['seqUsuario'] , "Creacion del Constructor: " . trim( $_POST['nombre'] ) . " Mensaje: " . implode( "," , $arrErrores ) );	
}

$arrTutor = $claDatosProy->obtenerDatosTutor($idTutor);
$arrGrupoGestion = $claDatosProy->obtenerDatosGestion();
$txtPlantilla = "proyectos/vistas/inscripcionTutor.tpl";

if (empty($arrErrores)) {
    $arrMensajes[] = "El Tutor <b>" . $_POST['txtNombreTutor'] . "</b> se ha guardado";
    imprimirMensajes(array(), $arrMensajes, "salvarConstructor");
    $seqUsuario = $_SESSION['seqUsuario'];
    $claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
    $claSmarty->assign("arrTutor", $arrTutor);
    $claSmarty->assign("seqUsuario", $seqUsuario);
    $claSmarty->assign("page", "datosTutor.php");

    if ($txtPlantilla != "") {
        $claSmarty->display($txtPlantilla);
    }
} else {
    imprimirMensajes($arrErrores, array());
}

// Desconecta la base de datos
$aptBd->close();
