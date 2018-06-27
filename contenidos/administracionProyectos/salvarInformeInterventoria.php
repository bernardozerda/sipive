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
$arrayDatosInterventoria = Array();
$url = str_replace('index.php', '', $_SERVER['HTTP_REFERER']);
/**
 * Salvar o editar Proyectos si no hay errores
 */
if (empty($arrErrores)) {
    $idProyecto = 0;
    $seqInformeInterventoria = 0;
    $idProyecto = $_REQUEST['seqProyecto'];

    if (isset($_POST['seqInformeInterventoria']) and is_numeric($_POST['seqInformeInterventoria']) and $_POST['seqInformeInterventoria'] > 0) {

        $arrErrores = $claProyecto->editarDatosInterventoria($_POST, count($_POST['txtObservaciones']));
        $idProyecto = $_REQUEST['seqProyecto'];
        $seqInformeInterventoria = $_REQUEST['seqInformeInterventoria'];
        //$claRegistro->registrarActividad("Edicion", 0, $_SESSION['seqUsuario'], "Edicion de Oferente: [" . $_POST['seqEditar'] . "] " . trim($_POST['nombre']) . " Mensaje: " . implode(",", $arrErrores));
    } else {
        if (isset($_FILES["txtNombreArchivo"]) && $_FILES["txtNombreArchivo"]["error"] == 0) {
            $url = str_replace('index.php', '', $_SERVER['HTTP_REFERER']);
            $directorio = '../../recursos/proyectos/proyecto-' . $idProyecto . '/informes';
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            if (is_uploaded_file($_FILES['txtNombreArchivo']['tmp_name'])) {
                $tipo = explode("/", $_FILES['txtNombreArchivo']['type'])[1];
                if ($tipo == "pdf" || $tipo == "PDF") {
                    $tmp_name = $_FILES["txtNombreArchivo"]["tmp_name"];
                    $name = basename($_FILES["txtNombreArchivo"]["name"]);
                    $validarNombreArchivo = $claDatosProy->obtenerNombreArchivo($idProyecto, $name);
                    if ($validarNombreArchivo) {
                        move_uploaded_file($tmp_name, "$directorio/$name");
                        $seqInformeInterventoria = $claProyecto->almacenarInformeInterventoria($_POST, $name);
                    } else {
                        $arrErrores[] = "El nombre del archivo ya se encuentra registrado ";
                    }
                } else {
                    $arrErrores[] = "Por favor verifique que el archivo este en formato PDF";
                }
            }
        }




        //$claRegistro->registrarActividad("Creacion", 0, $_SESSION['seqUsuario'], "Creacion de Oferente: " . trim($_POST['nombre']) . " Mensaje: " . implode(",", $arrErrores));
    }

    $txtPlantilla = "proyectos/vistas/inscripcionInterventoria.tpl";
    // echo "<br> **** idProyecto ->".$idProyecto ." seguimiento Ficha ->".$seqSeguimientoFicha."***<br>";
    $arrayDatosInterventoria = $claDatosProy->obtenerDatosInterventoria($idProyecto, $seqInformeInterventoria);


    //$arraSegFicha = $claDatosProy->obtenerSeguimientosFicha($idProyecto, $seqSeguimientoFicha);
    $arrayTextos = $claDatosProy->obtenerlistaTextosInterventoria($seqInformeInterventoria);
    $arrGrupoGestion = $claDatosProy->obtenerDatosGestion();
}

/**
 * Impresion de resultados
 */
if (empty($arrErrores)) {
    //pr ($arrErrores);
    $arrMensajes[] = "El Informe de interventoria <b>" . $seqInformeInterventoria . "</b> se ha Almacenado con Éxito!!!";
    imprimirMensajes(array(), $arrMensajes, "mensajes");
    $seqUsuario = $_SESSION['seqUsuario'];
    $claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
    $claSmarty->assign("seqProyecto", $_REQUEST['seqProyecto']);
    $claSmarty->assign("arrayDatosInterventoria", $arrayDatosInterventoria);
    $claSmarty->assign("onload", "activarEditorTiny('comentarios', 1)");
    $claSmarty->assign("arrayTextos", $arrayTextos);
    $claSmarty->assign("page", "datosSeguimientoFicha.php?tipo=1&id=4");
    $claSmarty->assign("prefijo", $url);
    $claSmarty->display($txtPlantilla);
} else {
      imprimirMensajes($arrErrores, $arrErrores, "mensajes");

}

// Desconecta la base de datos
$aptBd->close();
