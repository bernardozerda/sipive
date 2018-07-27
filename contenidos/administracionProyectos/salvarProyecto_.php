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
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoProyectos.class.php" );


/**
 * Validacion del formulario de oferentes
 */
$arrErrores = array();

/**
 * Salvar o editar Proyectos si no hay errores
 */
if (empty($arrErrores)) {
    $arrOferentesProy = array();
    $claProyecto = new Proyecto;
    $claRegistro = new RegistroActividades;
    $claDatosProy = new DatosGeneralesProyectos();
    $arrTipoEsquema = $claDatosProy->obtenerlistaEsquema();
    $arrPryTipoModalidad = $claDatosProy->obtenerlistamodalidad();
    $arrOpv = $claDatosProy->obtenerlistaOpv();
    $arrTipoProyecto = $claDatosProy->obtenerlistaTipoProyectos();
    $arrTipoUrbanizacion = $claDatosProy->obtenerlistaTipoUrbanizacion();
    $arrConstructor = $claDatosProy->obtenerlistaConstructores();
    $arrTipoSolucion = $claDatosProy->obtenerlistaTipoSolucion();
    $arrTipoDocumento = $claDatosProy->obtenerlistaTipoDoc();
    $arrLocalidad = $claDatosProy->obtenerlistaLocalidad();
    $arrEstadosProceso = $claDatosProy->obtenerlistaEstadoProcesoProy();
    $arrTipoModalidadDesembolso = $claDatosProy->obtenerlistaModalidadDesembolso();
    $arrFiduciaria = $claDatosProy->obtenerlistaFiduciaria();
    $arrTipoCuenta = $claDatosProy->obtenerlistaTipoCuenta();
    $arrTutorProyecto = $claDatosProy->obtenerlistaTutor();
    $arrBarrio = $claDatosProy->obtenerListaBarrios();
    $arrOferente = $claDatosProy->obtenerDatosOferente(0);
    $arrConstructor = $claDatosProy->obtenerDatosConstructor(0);
    // Verifica si es para crear o editar la Oferente
    $seqProyecto = 0;

    if (isset($_POST['seqProyecto']) and is_numeric($_POST['seqProyecto']) and $_POST['seqProyecto'] > 0) {

        $seqProyecto = $_POST['seqProyecto'];
        $arrErrores = $claProyecto->editarProyecto($_POST);
        //$claRegistro->registrarActividad("Edicion", 0, $_SESSION['seqUsuario'], "Edicion de Oferente: [" . $_POST['seqEditar'] . "] " . trim($_POST['nombre']) . " Mensaje: " . implode(",", $arrErrores));
    } else {
        $seqProyecto = $claProyecto->almacenarProyecto($_POST);
        //$claRegistro->registrarActividad("Creacion", 0, $_SESSION['seqUsuario'], "Creacion de Oferente: " . trim($_POST['nombre']) . " Mensaje: " . implode(",", $arrErrores));
    }
    $txtPlantilla = "proyectos/vistas/inscripcionProyecto.tpl";
    $arrProyecto = $claProyecto->obtenerDatosProyectos($seqProyecto);
    $arrOferentesProy = $claDatosProy->obtenerDatosOferenteProy($seqProyecto);
}

/**
 * Impresion de resultados
 */
if (empty($arrErrores)) {
    //pr ($arrErrores);
    $arrMensajes[] = "El Proyecto <b>" . $_POST['txtNombreProyecto'] . "</b> se ha guardado";
    imprimirMensajes(array(), $arrMensajes, "salvarOferente");
    $arrGrupoGestion = $claDatosProy->obtenerDatosGestion();
    $claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
    $claSmarty->assign("arrProyectos", $arrProyecto);
    $seqUsuario = $_SESSION['seqUsuario'];
    $claSmarty->assign("valSalarioMinimo", $arrConfiguracion['constantes']['salarioMinimo']);
    $claSmarty->assign("numSubsidios", 26);
    $claSmarty->assign("arrTipoEsquema", $arrTipoEsquema);
    $claSmarty->assign("arrPryTipoModalidad", $arrPryTipoModalidad);
    $claSmarty->assign("arrOpv", $arrOpv);
    $claSmarty->assign("arrTipoProyecto", $arrTipoProyecto);
    $claSmarty->assign("arrTipoUrbanizacion", $arrTipoUrbanizacion);
    $claSmarty->assign("arrConstructor", $arrConstructor);
    $claSmarty->assign("arrTipoSolucion", $arrTipoSolucion);
    $claSmarty->assign("arrTipoDocumento", $arrTipoDocumento);
    $claSmarty->assign("arrLocalidad", $arrLocalidad);
    $claSmarty->assign("arrEstadosProceso", $arrEstadosProceso);
    $claSmarty->assign("arrTipoModalidadDesembolso", $arrTipoModalidadDesembolso);
    $claSmarty->assign("arrFiduciaria", $arrFiduciaria);
    $claSmarty->assign("arrTipoCuenta", $arrTipoCuenta);
    $claSmarty->assign("arrTutorProyecto", $arrTutorProyecto);
    $claSmarty->assign("arrOferente", $arrOferente);
    $claSmarty->assign("arrConstructor", $arrConstructor);
    $claSmarty->assign("arrBarrio", $arrBarrio);
    $claSmarty->assign("arrOferentesProy", $arrOferentesProy);



    $claSmarty->display($txtPlantilla);
} else {
    imprimirMensajes($arrErrores, array());
}

// Desconecta la base de datos
$aptBd->close();
