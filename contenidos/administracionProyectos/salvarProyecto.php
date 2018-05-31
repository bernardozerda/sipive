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
$arrayDatosProyNew = array();
/**
 * Salvar o editar Proyectos si no hay errores
 */
if (empty($arrErrores)) {
    $arrOferentesProy = array();
    $arrRegistros = array();
    $claProyecto = new Proyecto;
    $claRegistro = new RegistroActividades;
    $claDatosProy = new DatosGeneralesProyectos();
    $claSeguimiento = new SeguimientoProyectos();
    $arrayconjuntos = Array();
    $arrayTipoViviendas = Array();
    $arraycronograma = Array();
    $arrayAmparos = Array();
    $arrayInsLicencias = Array();
    $arraConjuntoLicencias = Array();

    // $arrTipoEsquema = $claDatosProy->obtenerlistaEsquema();
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
    $arrProyectoGrupo = $claDatosProy->obtenerDatosProyectosGrupo(0);
    $arrAseguradoras = obtenerDatosTabla("t_pry_aseguradoras", array("seqAseguradora", "txtNombreAseguradora"), "seqAseguradora", "", "seqAseguradora DESC, txtNombreAseguradora");
    $arrAmparos = obtenerDatosTabla("t_pry_tipo_amparo", array("seqTipoAmparo", "txtTipoAmparo"), "seqTipoAmparo", "", "seqTipoAmparo DESC, txtTipoAmparo");
    $arrayBanco = obtenerDatosTabla("t_frm_banco", array("seqBanco", "txtBanco"), "seqBanco", "", "seqBanco DESC, txtBanco");
    $arrayCity = obtenerDatosTabla("t_frm_ciudad", array("seqCiudad", "txtCiudad"), "seqCiudad", "", "seqCiudad DESC, txtCiudad");
// Verifica si es para crear o editar la Oferente
    $seqProyecto = 0;
    $seqProyecto = $_POST['seqProyecto'];


    if (isset($_POST['seqProyecto']) and is_numeric($_POST['seqProyecto']) and $_POST['seqProyecto'] > 0) {

//        if ($cantDoc == 0) {
//            $claProyecto->almacenarDocumentos($seqProyecto, $_POST["documentId_" . $seqProyecto], $_POST["document_" . $seqProyecto]);
//        } else {
//            $claProyecto->modificarDocumentos($seqProyecto, $_POST["documentId_" . $seqProyecto], $_POST["document_" . $seqProyecto], $cantDoc);
//        }

        foreach ($_POST as $nombre_campo => $valor) {
            if (count($valor) > 1) {
                foreach ($valor as $key => $value) {
                    $arrayDatosProyNew[$nombre_campo][$key] = $value;
                }
            } else {
                $arrayDatosProyNew[$nombre_campo] = $valor;
            }
        }


        $arrayDatosProyOld = $claProyecto->obtenerDatosProyecto($seqProyecto);

        // die();
        $arrErrores = $claProyecto->editarProyecto($_POST);
        $claSeguimiento->almacenarSeguimiento($seqProyecto, $_POST['txtComentario'], $_POST['seqGestion'], $arrayDatosProyOld, $arrayDatosProyNew);
        $claSeguimientoProyectos = new SeguimientoProyectos;
        $claSeguimientoProyectos->seqProyecto = $seqProyecto;
        $arrRegistros = $claSeguimientoProyectos->obtenerRegistros(100);

        //$claRegistro->registrarActividad("Edicion", 0, $_SESSION['seqUsuario'], "Edicion de Oferente: [" . $_POST['seqEditar'] . "] " . trim($_POST['nombre']) . " Mensaje: " . implode(",", $arrErrores));
    } else {

        $seqProyecto = $claProyecto->almacenarProyecto($_POST);
        if ($seqProyecto > 0) {
            $txtCambios = "";
            $claSeguimiento->almacenarSeguimiento($seqProyecto, $_POST['txtComentario'], $_POST['seqGestion'], '', '');
            //$claProyecto->almacenarConjuntos($seqProyecto, $arrayconjuntos, count($_POST["txtNombreProyectoHijo"]));
        }
    }

    $nombre_fichero = $txtPrefijoRuta . "recursos/proyectos/proyecto-" . $seqProyecto;
    if (!file_exists($nombre_fichero)) {
        mkdir($nombre_fichero, 0777, true);
    }
    $txtPlantilla = "proyectos/vistas/inscripcionProyecto.tpl";


    $arrOferentesProy = $claDatosProy->obtenerDatosOferenteProy($seqProyecto);
    $cantConjuntos = $claDatosProy->obtenerCantConjuntos($seqProyecto);
    $cantDoc = $claDatosProy->obtenerDocumentoProyecto($seqProyecto);
    $cantLicencias = $claDatosProy->obtenerCantLicencias($seqProyecto);
    $cantCronograma = $claDatosProy->obtenerCantCronogramas($seqProyecto);
    $cantPoliza = $claDatosProy->obtenerCantPoliza($seqProyecto);
    //echo "<br>conjuntos ->".$cantConjuntos;
    $cantTipoVivienda = $claDatosProy->obtenerCantTipoVivienda($seqProyecto);

    include_once './conjuntoArreglos.php';


    if (count($arrayLicencias) == 0) {
        $arrayLicencias[0] = 0;
    }

    if ($cantConjuntos == 0 && isset($_POST["txtNombreProyectoHijo"])) {
        // echo "<br>**".count($_POST["txtNombreProyectoHijo"]);
        $claProyecto->almacenarConjuntos($seqProyecto, $arrayconjuntos, count($_POST["txtNombreProyectoHijo"]));
    } else {
        $claProyecto->modificarConjuntos($seqProyecto, $arrayconjuntos, count($_POST["txtNombreProyectoHijo"]));
    }
    if ($cantLicencias == 0 && isset($_POST["txtLicencia"])) {
        $claProyecto->almacenarLicencias($seqProyecto, $arrayInsLicencias, count($_POST["txtLicencia"]));
    } else if (isset($_POST["txtLicencia"])) {
        $claProyecto->modificarLicencias($seqProyecto, $arrayInsLicencias, count($_POST["txtLicencia"]));
    }

    if ($cantTipoVivienda == 0 && isset($_POST["txtNombreTipoVivienda"])) {
//echo "paso" .$cantTipoVivienda;
        $claProyecto->almacenarTipoVivienda($seqProyecto, $arrayTipoViviendas, count($_POST["txtNombreTipoVivienda"]));
    } else {

        $claProyecto->modificarTipoVivienda($seqProyecto, $arrayTipoViviendas, count($_POST["txtNombreTipoVivienda"]));
    }

    if ($cantCronograma == 0 && isset($_POST["numActaDescriptiva"])) {

        $claProyecto->almacenarCronograma($seqProyecto, $arraycronograma, count($_POST["numActaDescriptiva"]));
    } else if (isset($_POST["numActaDescriptiva"])) {

        $claProyecto->modificarCronograma($seqProyecto, $arraycronograma, count($_POST["numActaDescriptiva"]));
    }

    if ($cantPoliza == 0 && $_POST["numPoliza"] != "") {
        $claProyecto->almacenarPoliza($seqProyecto, $_POST["seqAseguradora"], $_POST["numPoliza"], $_POST["fchExpedicion"], $_POST["seqUsuarioPol"], $_POST["bolAprobo"], $arrayAmparos);
    } else if ($_POST["numPoliza"] != "") {
        $claProyecto->modificarPoliza($seqProyecto, $_POST["seqPoliza"], $_POST["seqAseguradora"], $_POST["numPoliza"], $_POST["fchExpedicion"], $_POST["seqUsuarioPol"], $_POST["bolAprobo"], $arrayAmparos);
    }

    if ($_POST["numContratoFiducia"] != "" && $_POST["numContratoFiducia"] != 0 && $_POST["seqDatoFiducia"] == "") {
        $claProyecto->almacenarFiducia($seqProyecto, $arrayFiducia);
    } else if ($_POST["seqDatoFiducia"] != "" && $_POST["seqDatoFiducia"] > 0) {
        $claProyecto->modificarFiducia($seqProyecto, $arrayFiducia);
    }
}/**
 * Impresion de resultados
 */
if (empty($arrErrores)) {
    $arrProyecto = $claProyecto->obtenerDatosProyectos($seqProyecto);
    $arrayDocumentos = $claProyecto->obtenerListaDocumentos($seqProyecto, $cantDoc);
    $arrayLicencias = $claProyecto->obtenerListaLicencias($seqProyecto);
    $arrConjuntoResidencial = $claDatosProy->obtenerConjuntoResidencial($seqProyecto);
    $arrTipoVivienda = $claDatosProy->obtenerTipoVivienda($seqProyecto);
    $arrCronogramaFecha = $claDatosProy->obteneCronograma($seqProyecto);
    $arraDatosPoliza = $claDatosProy->obtenerDatosPoliza($seqProyecto);
    $arrayFideicomitente = $claDatosProy->obtenerDatosFideicomiso($seqProyecto);
    $arrPlanGobierno = obtenerDatosTabla("t_frm_plan_gobierno", array("seqPlanGobierno", "txtPlanGobierno"), "seqPlanGobierno", "", "seqPlanGobierno DESC, txtPlanGobierno");

    foreach ($arrConjuntoResidencial as $keyCon => $valueCon) {
        $arraConjuntoLicencias[] = $claProyecto->obtenerListaLicencias($valueCon['seqProyecto']);
    }
//pr ($arrErrores);
    $arrMensajes[] = "El Proyecto <b>" . $_POST['txtNombreProyecto'] . "</b> se ha guardado";
    imprimirMensajes(array(), $arrMensajes, "salvarOferente");
    $arrGrupoGestion = $claDatosProy->obtenerDatosGestion();
    $claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
    $claSmarty->assign("arrProyectos", $arrProyecto);
    $claSmarty->assign("valSalarioMinimo", $arrConfiguracion['constantes']['salarioMinimo']);
    $claSmarty->assign("numSubsidios", 26);
    $claSmarty->assign("arrTipoEsquema", $arrTipoEsquema);
    $claSmarty->assign("arrPlanGobierno", $arrPlanGobierno);
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
    $claSmarty->assign("arrRegistros", $arrRegistros);
    $claSmarty->assign("arrOferentesProy", $arrOferentesProy);
    $claSmarty->assign("arrayDocumentos", $arrayDocumentos);
    $claSmarty->assign("arrayLicencias", $arrayLicencias);
    $claSmarty->assign("arrTipoVivienda", $arrTipoVivienda);
    $claSmarty->assign("arrConjuntoResidencial", $arrConjuntoResidencial);
    $claSmarty->assign("arrCronogramaFecha", $arrCronogramaFecha);
    $claSmarty->assign("arrProyectoGrupo", $arrProyectoGrupo);
    $claSmarty->assign("arrAseguradoras", $arrAseguradoras);
    $claSmarty->assign("arrAmparos", $arrAmparos);
    $claSmarty->assign("arrayBanco", $arrayBanco);
    $claSmarty->assign("arraDatosPoliza", $arraDatosPoliza);
    $claSmarty->assign("arrayFideicomitente", $arrayFideicomitente);
    $claSmarty->assign("arrayCity", $arrayCity);
    $claSmarty->assign("arraConjuntoLicencias", $arraConjuntoLicencias);
    $claSmarty->assign("page", "datosProyecto.php?tipo=2");
    $claSmarty->display($txtPlantilla);
} else {
    imprimirMensajes($arrErrores, array());
}

// Desconecta la base de datos
$aptBd->close();
