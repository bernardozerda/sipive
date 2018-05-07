<?php

/*
 * Creado por Liliana Basto
 * Archivo para cargar la información para la inscripsión de los proyectos
 * 20-06-2017.
 */
$txtPrefijoRuta = "../../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );


include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "DatosGeneralesProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Proyecto.class.php" );

$arrProyectos = array();
$arrOferentesProy = array();
$arrTipoVivienda = Array();
$arrConjuntoResidencial = Array();
$arraDatosPoliza = Array();
$arrCronogramaFecha = Array();
$claDatosProy = new DatosGeneralesProyectos();
$claProyecto = new Proyecto();
$txtPlantilla = "proyectos/vistas/listaProyectos.tpl";
$idProyecto = 0;
$arrGrupoGestion = $claDatosProy->obtenerDatosGestion();
$arrRegistros = array();
$arrayDocumentos = array();
$id = $_REQUEST['id'];
$seqPlanGobierno = $_REQUEST['seqPlanGobierno'];
$arrPryTipoModalidad = obtenerDatosTabla("T_FRM_MODALIDAD", array("seqModalidad", "txtModalidad"), "seqModalidad", "seqPlanGobierno = " . $seqPlanGobierno, "seqPlanGobierno DESC, txtModalidad");
$arrPlanGobierno = obtenerDatosTabla("t_frm_plan_gobierno", array("seqPlanGobierno", "txtPlanGobierno"), "seqPlanGobierno", "", "seqPlanGobierno DESC, txtPlanGobierno");
$arrAseguradoras = obtenerDatosTabla("t_pry_aseguradoras", array("seqAseguradora", "txtNombreAseguradora"), "seqAseguradora", "", "seqAseguradora DESC, txtNombreAseguradora");
$arrAmparos = obtenerDatosTabla("t_pry_tipo_amparo", array("seqTipoAmparo", "txtTipoAmparo"), "seqTipoAmparo", "", "seqTipoAmparo DESC, txtTipoAmparo");
//var_dump($arrPryTipoModalidad);

if (isset($_REQUEST['seqProyecto'])) {
    $idProyecto = $_REQUEST['seqProyecto'];

    $txtPlantilla = "proyectos/vistas/inscripcionProyecto.tpl";
    $arrProyectos = $claDatosProy->obtenerlistaProyectos($idProyecto);
    $arrOferentesProy = $claDatosProy->obtenerDatosOferenteProy($idProyecto);
    $claSeguimientoProyectos = new SeguimientoProyectos;
    $claSeguimientoProyectos->seqProyecto = $idProyecto;
    $arrRegistros = $claSeguimientoProyectos->obtenerRegistros(100);
    $arrTipoVivienda = $claDatosProy->obtenerTipoVivienda($idProyecto);
    $arrConjuntoResidencial = $claDatosProy->obtenerConjuntoResidencial($idProyecto);
    $arrCronogramaFecha = $claDatosProy->obteneCronograma($idProyecto);
    $arraDatosPoliza = $claDatosProy->obtenerDatosPoliza($idProyecto);

    $arraDatosPoliza = (count($arraDatosPoliza) > 0) ? $arraDatosPoliza : $arraDatosPoliza[0] = 0;
    if ($_REQUEST['tipo'] == '3') {
        $txtPlantilla = "proyectos/vistas/verProyecto.tpl";
    }
} else {
    $arrProyectos = $claDatosProy->obtenerlistaProyectos($idProyecto);
    // var_dump($arrProyectos);
    $txtPlantilla = "proyectos/vistas/listaProyectos.tpl";
    if ($_REQUEST['tipo'] == '1') {
        $arrProyectos = array();
        $arrProyectos[0] = 0;
        $arrOferentesProy[0] = 0;
        $txtPlantilla = "proyectos/vistas/inscripcionProyecto.tpl";
    }
}
//var_dump($arrPlanGobierno);
//$arrTipoEsquema = $claDatosProy->obtenerlistaEsquema();
//$arrPryTipoModalidad = $claDatosProy->obtenerlistamodalidad();

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
$arrOferente = $claDatosProy->obtenerDatosOferente(0);
$arrConstructor = $claDatosProy->obtenerDatosConstructor(0);
$arrProyectoGrupo = $claDatosProy->obtenerDatosProyectosGrupo(0);
$arrBarrio = $claDatosProy->obtenerListaBarrios();
$cantDoc = $claDatosProy->obtenerDocumentoProyecto($idProyecto);
$arrayDocumentos = $claProyecto->obtenerListaDocumentos($idProyecto, $cantDoc);
$arrayLicencias = $claProyecto->obtenerListaLicencias($idProyecto);
if (count($arrayLicencias) == 0) {
    $arrayLicencias[0] = 0;
}
//print_r($arrProyectos);
$seqUsuario = $_SESSION['seqUsuario'];
$claSmarty->assign("valSalarioMinimo", $arrConfiguracion['constantes']['salarioMinimo']);
$claSmarty->assign("numSubsidios", 26);
$claSmarty->assign("arrTipoEsquema", $arrTipoEsquema);
$claSmarty->assign("arrPryTipoModalidad", $arrPryTipoModalidad);
$claSmarty->assign("arrPlanGobierno", $arrPlanGobierno);
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
$claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
$claSmarty->assign("arrProyectos", $arrProyectos);
$claSmarty->assign("arrConstructor", $arrConstructor);
$claSmarty->assign("arrOferente", $arrOferente);
$claSmarty->assign("seqUsuario", $seqUsuario);
$claSmarty->assign("arrBarrio", $arrBarrio);
$claSmarty->assign("arrOferentesProy", $arrOferentesProy);
$claSmarty->assign("arrayDocumentos", $arrayDocumentos);
$claSmarty->assign("arrayLicencias", $arrayLicencias);
$claSmarty->assign("arrRegistros", $arrRegistros); // Registros de seguimiento
//var_dump($arrayDocumentos);
$claSmarty->assign("arrTipoVivienda", $arrTipoVivienda);
$claSmarty->assign("arrConjuntoResidencial", $arrConjuntoResidencial);
$claSmarty->assign("arrCronogramaFecha", $arrCronogramaFecha);
$claSmarty->assign("arrProyectoGrupo", $arrProyectoGrupo);
$claSmarty->assign("arraDatosPoliza", $arraDatosPoliza);
$claSmarty->assign("arrAseguradoras", $arrAseguradoras);
$claSmarty->assign("arrAmparos", $arrAmparos);
$claSmarty->assign("id", $id);
$claSmarty->assign("NombreUsuario", $_SESSION['txtNombre'] . "" . $_SESSION['txtApellido']);
$claSmarty->assign("seqUsuario", $_SESSION['seqUsuario']);
$claSmarty->assign("page", "datosProyecto.php?tipo=2");

//echo "prueba";

if ($txtPlantilla != "") {
    $claSmarty->display($txtPlantilla);
}