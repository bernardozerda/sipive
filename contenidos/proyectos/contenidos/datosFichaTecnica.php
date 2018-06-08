<?php

$txtPrefijoRuta = "../../../";
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Autenticacion (si esta logueado no no)
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

// Inclusiones necesarias
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Proyecto.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "DatosGeneralesProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "GestionFinancieraProyectos.class.php" );

$claProyecto = new Proyecto;
$claDatosProyecto = new DatosGeneralesProyectos();

$txtPlantilla = "proyectos/vistas/reportes/fichaTecnica.tpl";
$seqProyecto = $_GET['seqProyecto'];
$arrProyectos = $claProyecto->obtenerDatosProyectosFicha($seqProyecto);
$arrDatosVivienda = $claProyecto->obtenerDatosViviendaFicha($seqProyecto);

$directorio = '../../../recursos/proyectos/proyecto-' . $seqProyecto . '/imagenes';

$dir = @dir($directorio);
$arraImagenes = Array();
if ($dir) {
    while (($archivo = $dir->read()) !== false) {
        if ($archivo[0] != ".") {
            $arraImagenes[] = 'proyecto-' . $seqProyecto . '/imagenes/' . $archivo;
            continue;
        }
    }
}

$cantUnidades = $claDatosProyecto->totalUnidadesPorProyecto(1, $seqProyecto);
$cantUnidadesVinculadas = $claDatosProyecto->totalUnidadesPorProyecto(4, $seqProyecto);
$pendientesPorVincular = $claDatosProyecto->totalUnidadesPorProyecto(2, $seqProyecto);
$legalizadas = $claDatosProyecto->totalUnidadesPorProyecto(5, $seqProyecto);
$pendientesPorLegalizar = $cantUnidadesVinculadas - $legalizadas;
$cantOcupacion = $claProyecto->datosTecnicosOcupacion($seqProyecto);
$cantExistencia = $claProyecto->datosTecnicosExistencia($seqProyecto);

$arraPoliza = $claProyecto->obtenerDatosPoliza($seqProyecto);
$nombreAseguradora;
$vigEstabilidad;
$seqEstabilidad;
$vigCumplimiento;
$seqCumplimiento;
$vigAnticipo;
$seqAnticipo;

foreach ($arraPoliza as $key => $value) {
    $nombreAseguradora = $value['txtNombreAseguradora'];
    if ($value['seqTipoAmparo'] == 1) {
        $vigEstabilidad = $value['vigencia'];
        $seqEstabilidad = $value['seqAmparo'];
    }
    if ($value['seqTipoAmparo'] == 2) {
        $vigCumplimiento = $value['vigencia'];
        $seqCumplimiento = $value['seqAmparo'];
    }
    if ($value['seqTipoAmparo'] == 3) {
        $vigAnticipo = $value['vigencia'];
        $seqAnticipo = $value['seqAmparo'];
    }

    if ($value['seqTipoAmparo'] == 6 && $seqEstabilidad == $value['seqAmparoPadre']) {        
        $fecha = $vigEstabilidad;       
        if (strtotime($value['vigencia']) > strtotime($fecha)) {
            $vigEstabilidad = $value['vigencia'];
        }     
       
    }
    if ($value['seqTipoAmparo'] == 6 && $seqCumplimiento == $value['seqAmparoPadre']) {        
        $fecha = $vigCumplimiento;       
        if (strtotime($value['vigencia']) > strtotime($fecha)) {
            $vigCumplimiento = $value['vigencia'];
        }     
    }
    if ($value['seqTipoAmparo'] == 6 && $seqAnticipo == $value['seqAmparoPadre']) {        
        $fecha = $vigAnticipo;       
        if (strtotime($value['vigencia']) > strtotime($fecha)) {
            $vigAnticipo = $value['vigencia'];
        }       
    }
}

/*******************************************************************************************************************
 * DATOS FINANCIEROS DEL PROYECTO
 *******************************************************************************************************************/

$claGestion = new GestionFinancieraProyectos();
$arrFinanciera = $claGestion->reporteGeneral(true);
$claGestion->informacionResoluciones($seqProyecto);

$arrFinanciera[$seqProyecto]['porcentajeTotalConstructor'] = $arrFinanciera[$seqProyecto]['porcentajeTotalConstructor'] * 100;
$arrFinanciera[$seqProyecto]['saldoDesembolso'] = $arrFinanciera[$seqProyecto]['actual'] - $arrFinanciera[$seqProyecto]['constructor'];
$arrFinanciera[$seqProyecto]['porcentajeSaldoDesembolso'] = ($arrFinanciera[$seqProyecto]['saldoDesembolso'] / $arrFinanciera[$seqProyecto]['actual']) * 100;

// redefine la clave aprobado para ampliar informacion
unset($arrFinanciera[$seqProyecto]['aprobado']);
$arrFinanciera[$seqProyecto]['aprobado']['numero'] = 0;
$arrFinanciera[$seqProyecto]['aprobado']['fecha'] = null;
$arrFinanciera[$seqProyecto]['aprobado']['valor'] = 0;
$arrFinanciera[$seqProyecto]['aprobado']['unidades'] = array();

// redefine la clave indexado para ampliar la informacion
unset($arrFinanciera[$seqProyecto]['indexado']);
$arrFinanciera[$seqProyecto]['indexado'] = array();

// redefine la clave menor para ampliar la informacion
unset($arrFinanciera[$seqProyecto]['menor']);
$arrFinanciera[$seqProyecto]['menor'] = array();

// procesando el resumen de proyecto para ordenar los datos
foreach($claGestion->arrResoluciones as $seqUnidadActo => $arrResolucion){
    if($arrResolucion['idTipo'] == 1){
        $arrFinanciera[$seqProyecto]['aprobado']['numero'] = $arrResolucion['numero'];
        $arrFinanciera[$seqProyecto]['aprobado']['fecha']  = $arrResolucion['fecha']->format("Y");
        $arrFinanciera[$seqProyecto]['aprobado']['valor']  = $arrResolucion['total'];
        if(isset($arrResolucion['cdp'])) {
            foreach ($arrResolucion['cdp'] as $seqRegistroPresupuestal => $arrCDP) {
                foreach ($arrCDP['unidades'] as $seqUnidadProyecto => $arrUnidad) {
                    $arrFinanciera[$seqProyecto]['aprobado']['unidades'][$seqUnidadProyecto] = $seqUnidadProyecto;
                }
            }
        }
    }elseif($arrResolucion['idTipo'] == 2 and $arrResolucion['total'] > 0){
        $arrFinanciera[$seqProyecto]['indexado']['total'] += $arrResolucion['total'];
        $arrFinanciera[$seqProyecto]['indexado']['detalle'][$seqUnidadActo]['numero'] = $arrResolucion['numero'];
        $arrFinanciera[$seqProyecto]['indexado']['detalle'][$seqUnidadActo]['fecha'] = $arrResolucion['fecha']->format("Y");
        $arrFinanciera[$seqProyecto]['indexado']['detalle'][$seqUnidadActo]['valor'] = $arrResolucion['total'];
        if(isset($arrResolucion['cdp'] )) {
            foreach ($arrResolucion['cdp'] as $seqRegistroPresupuestal => $arrCDP) {
                foreach ($arrCDP['unidades'] as $seqUnidadProyecto => $arrUnidad) {
                    $arrFinanciera[$seqProyecto]['indexado']['detalle'][$seqUnidadActo]['unidades'][$seqUnidadProyecto] = $seqUnidadProyecto;
                }
            }
        }
    }elseif($arrResolucion['idTipo'] == 3 or ($arrResolucion['idTipo'] == 2 and $arrResolucion['total'] < 0)){

        $arrFinanciera[$seqProyecto]['menor']['total'] += abs($arrResolucion['total']);
        $arrFinanciera[$seqProyecto]['menor']['detalle'][$seqUnidadActo]['numero'] = $arrResolucion['numero'];
        $arrFinanciera[$seqProyecto]['menor']['detalle'][$seqUnidadActo]['fecha'] = $arrResolucion['fecha']->format("Y");
        $arrFinanciera[$seqProyecto]['menor']['detalle'][$seqUnidadActo]['valor'] = abs($arrResolucion['total']);

        $sql = "select count(seqUnidadVinculado) as cuenta from t_pry_aad_unidades_vinculadas where seqUnidadActo = $seqUnidadActo";
        $arrCantidad = $aptBd->GetAll($sql);
        $arrFinanciera[$seqProyecto]['menor']['detalle'][$seqUnidadActo]['unidades'] = $arrCantidad[0]['cuenta'];

    }
}

$arrListadoGirosConstructor = $claGestion->listadoGirosConstructor($seqProyecto);
foreach($arrListadoGirosConstructor as $i => $arrGiro){
    $arrListadoGirosConstructor[$i]['porcentajeGiro'] = ($arrListadoGirosConstructor[$i]['giro'] / $arrFinanciera[$seqProyecto]['actual']) * 100;
}

$arrFinanciera[$seqProyecto]['entidadFiducia'] = array_shift(obtenerDatosTabla(
    "t_pry_datos_fiducia",
    array("seqProyecto","txtRazonSocialFiducia","numNitFiducia"),
    "seqProyecto",
    "seqProyecto = " . $seqProyecto
));

//pr($arrFinanciera);

$claSmarty->assign("arrProyectos", $arrProyectos);
$claSmarty->assign("cantUnidades", $cantUnidades);
$claSmarty->assign("cantUnidadesVinculadas", $cantUnidadesVinculadas);
$claSmarty->assign("pendientesPorVincular", $pendientesPorVincular);
$claSmarty->assign("legalizadas", $legalizadas);
$claSmarty->assign("pendientesPorLegalizar", $pendientesPorLegalizar);
$claSmarty->assign("arrDatosVivienda", $arrDatosVivienda);
$claSmarty->assign("arrImagenes", $arraImagenes);
$claSmarty->assign("nombreAseguradora", $nombreAseguradora);
$claSmarty->assign("vigEstabilidad", $vigEstabilidad);
$claSmarty->assign("vigCumplimiento", $vigCumplimiento);
$claSmarty->assign("vigAnticipo", $vigAnticipo);
$claSmarty->assign("cantOcupacion", $cantOcupacion);
$claSmarty->assign("cantExistencia", $cantExistencia);
// variables para datos financieros
$claSmarty->assign("arrFinanciera", $arrFinanciera);
$claSmarty->assign("arrListadoGirosConstructor", $arrListadoGirosConstructor);
$claSmarty->assign("seqProyecto", $seqProyecto);

if ($txtPlantilla != "") {
    $claSmarty->display($txtPlantilla);
}

//pr($arrListadoGirosConstructor);