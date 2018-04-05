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
    // Verifica si es para crear o editar la Oferente
    $seqProyecto = 0;
    $seqProyecto = $_POST['seqProyecto'];
    $cantDoc = $claDatosProy->obtenerDocumentoProyecto($seqProyecto);
    $cantLicencias = $claDatosProy->obtenerCantLicencias($seqProyecto);

    if (isset($_POST['seqProyecto']) and is_numeric($_POST['seqProyecto']) and $_POST['seqProyecto'] > 0) {

        if ($cantDoc == 0) {
            $claProyecto->almacenarDocumentos($seqProyecto, $_POST["documentId_" . $seqProyecto], $_POST["document_" . $seqProyecto]);
        } else {
            $claProyecto->modificarDocumentos($seqProyecto, $_POST["documentId_" . $seqProyecto], $_POST["document_" . $seqProyecto], $cantDoc);
        }

        foreach ($_POST as $key => $value) {
            $arrayDatosProyNew[$key] = $value;
        }
        $arrayDatosProyOld = $claProyecto->obtenerDatosProyecto($seqProyecto);
        //var_dump($arrayDatosProyActual);
        $arrErrores = $claProyecto->editarProyecto($_POST);
        $claSeguimiento->almacenarSeguimiento($seqProyecto, $_POST['txtComentario'], $_POST['seqGestion'], $arrayDatosProyOld, $arrayDatosProyNew);
        $claSeguimientoProyectos = new SeguimientoProyectos;
        $claSeguimientoProyectos->seqProyecto = $seqProyecto;
        $arrRegistros = $claSeguimientoProyectos->obtenerRegistros(100);

        $arrCronogramaFecha = $claDatosProy->obteneCronograma($seqProyecto);
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
    $arrProyecto = $claProyecto->obtenerDatosProyectos($seqProyecto);
    $arrOferentesProy = $claDatosProy->obtenerDatosOferenteProy($seqProyecto);
    $cantConjuntos = $claDatosProy->obtenerCantConjuntos($seqProyecto);
    $cantTipoVivienda = $claDatosProy->obtenerCantTipoVivienda($seqProyecto);

    $arrayconjuntos[$seqProyecto]['seqProyectoHijo'] = $_POST["seqProyectoHijo"];
    $arrayconjuntos[$seqProyecto]['txtNombreProyectoHijo'] = $_POST["txtNombreProyectoHijo"];
    $arrayconjuntos[$seqProyecto]['txtNombreComercialHijo'] = $_POST["txtNombreComercialHijo"];
    $arrayconjuntos[$seqProyecto]['txtDireccionHijo'] = $_POST["txtDireccionHijo"];
    $arrayconjuntos[$seqProyecto]['valNumeroSolucionesHijo'] = $_POST["valNumeroSolucionesHijo"];
    $arrayconjuntos[$seqProyecto]['txtChipLoteHijo'] = $_POST["txtChipLoteHijo"];
    $arrayconjuntos[$seqProyecto]['txtMatriculaInmobiliariaLoteHijo'] = $_POST["txtMatriculaInmobiliariaLoteHijo"];
    $arrayconjuntos[$seqProyecto]['txtLicenciaUrbanismoHijo'] = $_POST["txtLicenciaUrbanismoHijo"];
    $arrayconjuntos[$seqProyecto]['fchLicenciaUrbanismo1Hijo'] = $_POST["fchLicenciaUrbanismo1Hijo"];
    $arrayconjuntos[$seqProyecto]['fchVigenciaLicenciaUrbanismoHijo'] = $_POST["fchVigenciaLicenciaUrbanismoHijo"];
    $arrayconjuntos[$seqProyecto]['txtExpideLicenciaUrbanismoHijo'] = $_POST["txtExpideLicenciaUrbanismoHijo"];
    $arrayconjuntos[$seqProyecto]['txtLicenciaConstruccionHijo'] = $_POST["txtLicenciaConstruccionHijo"];
    $arrayconjuntos[$seqProyecto]['fchLicenciaConstruccion1Hijo'] = $_POST["fchLicenciaConstruccion1Hijo"];
    $arrayconjuntos[$seqProyecto]['fchVigenciaLicenciaConstruccionHijo'] = $_POST["fchVigenciaLicenciaConstruccionHijo"];
    $arrayconjuntos[$seqProyecto]['txtNombreVendedorHijo'] = $_POST["txtNombreVendedorHijo"];
    $arrayconjuntos[$seqProyecto]['numNitVendedorHijo'] = $_POST["numNitVendedorHijo"];
    $arrayconjuntos[$seqProyecto]['txtCedulaCatastralHijo'] = $_POST["txtCedulaCatastralHijo"];
    $arrayconjuntos[$seqProyecto]['txtEscrituraHijo'] = $_POST["txtEscrituraHijo"];
    $arrayconjuntos[$seqProyecto]['fchEscrituraHijo'] = $_POST["fchEscrituraHijo"];
    $arrayconjuntos[$seqProyecto]['numNotariaHijo'] = $_POST["numNotariaHijo"];

    $arrayTipoViviendas[$seqProyecto]['seqTipoVivienda'] = $_POST["seqTipoVivienda"];
    $arrayTipoViviendas[$seqProyecto]['txtNombreTipoVivienda'] = $_POST["txtNombreTipoVivienda"];
    $arrayTipoViviendas[$seqProyecto]['numCantidad'] = $_POST["numCantidad"];
    $arrayTipoViviendas[$seqProyecto]['numArea'] = $_POST["numArea"];
    $arrayTipoViviendas[$seqProyecto]['numAnoVenta'] = $_POST["numAnoVenta"];
    $arrayTipoViviendas[$seqProyecto]['valPrecioVenta'] = $_POST["valPrecioVenta"];
    $arrayTipoViviendas[$seqProyecto]['valCierre'] = $_POST["valCierre"];
    $arrayTipoViviendas[$seqProyecto]['txtDescripcion'] = $_POST["txtDescripcion"];


    if (count($arrayLicencias) == 0) {
        $arrayLicencias[0] = 0;
    }

    if ($cantConjuntos == 0) {
        // echo "<br>**".count($_POST["txtNombreProyectoHijo"]);
        $claProyecto->almacenarConjuntos($seqProyecto, $arrayconjuntos, count($_POST["txtNombreProyectoHijo"]));
    } else {
        $claProyecto->modificarConjuntos($seqProyecto, $arrayconjuntos, count($_POST["txtNombreProyectoHijo"]));
    }
    if ($cantLicencias == 0) {
        $claProyecto->almacenarLicencias($seqProyecto, $_POST["txtLicencia"], $_POST["txtExpideLicencia"], $_POST["seqTipoLicencia"], $_POST["fchLicencia"], $_POST["fchVigenciaLicencia"], $_POST["fchEjecutoriaLicencia"], $_POST["txtResEjecutoria"], $_POST["fchLicenciaProrroga"], $_POST["fchLicenciaProrroga1"], $_POST["fchLicenciaProrroga2"]);
    } else {
        $claProyecto->modificarLicencias($seqProyecto, $_POST["seqProyectoLicencia"], $_POST["txtLicencia"], $_POST["txtExpideLicencia"], $_POST["seqTipoLicencia"], $_POST["fchLicencia"], $_POST["fchVigenciaLicencia"], $_POST["fchEjecutoriaLicencia"], $_POST["txtResEjecutoria"], $_POST["fchLicenciaProrroga"], $_POST["fchLicenciaProrroga1"], $_POST["fchLicenciaProrroga2"]);
    }

    if ($cantTipoVivienda == 0) {
        // echo "<br>**".count($_POST["txtNombreProyectoHijo"]);
        $claProyecto->almacenarTipoVivienda($seqProyecto, $arrayTipoViviendas, count($_POST["txtNombreTipoVivienda"]));
    } else {
        $claProyecto->modificarTipoVivienda($seqProyecto, $arrayTipoViviendas, count($_POST["txtNombreTipoVivienda"]));
    }
}/**
 * Impresion de resultados
 */
if (empty($arrErrores)) {

    $arrayDocumentos = $claProyecto->obtenerListaDocumentos($seqProyecto, $cantDoc);
    $arrayLicencias = $claProyecto->obtenerListaLicencias($seqProyecto);
    $arrConjuntoResidencial = $claDatosProy->obtenerConjuntoResidencial($seqProyecto);
    $arrTipoVivienda = $claDatosProy->obtenerTipoVivienda($seqProyecto);
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
    $claSmarty->assign("arrRegistros", $arrRegistros);
    $claSmarty->assign("arrOferentesProy", $arrOferentesProy);
    $claSmarty->assign("arrayDocumentos", $arrayDocumentos);
    $claSmarty->assign("arrayLicencias", $arrayLicencias);
    $claSmarty->assign("arrTipoVivienda", $arrTipoVivienda);
    $claSmarty->assign("arrConjuntoResidencial", $arrConjuntoResidencial);
    $claSmarty->assign("arrCronogramaFecha", $arrCronogramaFecha);
    $claSmarty->display($txtPlantilla);
} else {
    imprimirMensajes($arrErrores, array());
}

// Desconecta la base de datos
$aptBd->close();
