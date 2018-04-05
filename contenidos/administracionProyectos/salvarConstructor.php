<?php

/**
 * SALVA O EDITA LOS CONSTRUCTORES DE LA BASE DE DATOS
 * @author Jaison Ospina
 * @version 0.1 Noviembre 2013
 */
// Posicion relativa de los archivos a incluir
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

/**
 * Validacion del formulario de Constructores
 */
$arrErrores = array();
$claDatosProy = new DatosGeneralesProyectos();
//////////////////////////////////////////////// VALIDACION DATOS CONSTRUCTOR ////////////////////////////////////////////////////
/**
 * Salvar o editar Constructores si no hay errores
 */
$claConstructor = new Constructor;
$claRegistro = new RegistroActividades;
$idConstructor = 0;


// Verifica si es para crear o editar la Constructor
if (isset($_POST['seqConstructor']) and is_numeric($_POST['seqConstructor']) and $_POST['seqConstructor'] > 0) {
    $idConstructor = $_REQUEST['seqConstructor'];
    $arrErrores = $claConstructor->editarConstructor($_POST);

    //$claRegistro->registrarActividad( "Edicion" , 0 , $_SESSION['seqUsuario'] , "Edicion del Constructor: [" . $_POST['seqEditar'] . "] " . trim( $_POST['nombre'] ) . " Mensaje: " . implode( "," , $arrErrores ) );
} else {
    $idConstructor = $claConstructor->guardarConstructor($_POST);
    //$claRegistro->registrarActividad( "Creacion" , 0 , $_SESSION['seqUsuario'] , "Creacion del Constructor: " . trim( $_POST['nombre'] ) . " Mensaje: " . implode( "," , $arrErrores ) );	
}


$arrConstructor = $claDatosProy->obtenerDatosConstructor($idConstructor);
$arrGrupoGestion = $claDatosProy->obtenerDatosGestion();
$arrTipoDoc = $claDatosProy->obtenerlistaTipoDoc();
$txtPlantilla = "proyectos/vistas/inscripcionConstructor.tpl";
/**
 * Impresion de resultados
 */
if (empty($arrErrores)) {
    $arrMensajes[] = "El Constructor <b>" . $_POST['nombre'] . "</b> se ha guardado";
    imprimirMensajes(array(), $arrMensajes, "salvarConstructor");
    $seqUsuario = $_SESSION['seqUsuario'];
    $claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
    $claSmarty->assign("arrConstructor", $arrConstructor);
    $claSmarty->assign("arrTipoDoc", $arrTipoDoc);
    $claSmarty->assign("seqUsuario", $seqUsuario);

    if ($txtPlantilla != "") {
        $claSmarty->display($txtPlantilla);
    }
} else {
    imprimirMensajes($arrErrores, array());
}

// Desconecta la base de datos
$aptBd->close();
?>