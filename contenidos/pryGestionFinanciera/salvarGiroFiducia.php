<?php


$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "GestionFinancieraProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "SeguimientoProyectos.class.php" );

$_POST['unidades'] = json_decode($_POST['unidades'], true);

$claGestion = new GestionFinancieraProyectos();
$seqGiroFiducia = $claGestion->salvarGiroFiducia($_POST);

$seqProyecto = intval($_POST['seqProyecto']);
$seqUnidadActo = intval($_POST['seqUnidadActo']);
$seqRegistroPresupuestal = intval($_POST['seqRegistroPresupuestal']);
$arrArchivo = array();

$claGestion->proyectos();

// cuando hay proyecto seleccionado carga la informacion
if($seqProyecto != 0){
    $claGestion->informacionResoluciones($seqProyecto);
}

// al seleccionar RP define si se puede o no sacar la plantlla y cargar archivos de unidades
$bolHabilitar = false;
if($seqRegistroPresupuestal != 0 and isset($claGestion->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal])){
    $bolHabilitar = true;
}

$arrUnidades = array();
if( isset( $_POST['unidades'][$seqProyecto][$seqUnidadActo][$seqRegistroPresupuestal] )){
    $arrUnidades = $_POST['unidades'];
    foreach($_POST['unidades'][$seqProyecto][$seqUnidadActo][$seqRegistroPresupuestal] as $seqUnidadProyecto => $valGiro){
        $numTotalGiro += $valGiro;
        $numTotalUnidades++;
    }
}

// para la table de CDP y RP
$arrTablaCDP = array();
if(isset($claGestion->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal])) {
    $arrTablaCDP['numeroCDP'] = $claGestion->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['numeroCDP'];
    $arrTablaCDP['fechaCDP'] = $claGestion->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['fechaCDP'];
    $arrTablaCDP['numeroRP'] = $claGestion->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['numeroRP'];
    $arrTablaCDP['fechaRP'] = $claGestion->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['fechaRP'];
    $arrTablaCDP['valorRP'] = $claGestion->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['valorRP'];
    $arrTablaCDP['giros'] = doubleval($claGestion->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['giros']);
    $arrTablaCDP['liberaciones'] = doubleval($claGestion->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['liberaciones']);
    $arrTablaCDP['saldo'] = (doubleval($claGestion->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['saldo']) == 0)?
        $arrTablaCDP['valorRP'] :
        doubleval($claGestion->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['saldo']);

    $arrTablaCDP['giros'] = $arrTablaCDP['giros'] - $numTotalGiro;

}

// mira si hay actos administrativos de liberacion y si hay saldo
$bolPendientes = false;
foreach($claGestion->arrResoluciones as $seqUnidadActo => $arrResolucion){
    if($arrResolucion['total'] < 0){
        $valSaldo = (isset($arrResolucion['saldo']))? $arrResolucion['saldo'] : $arrResolucion['total'];
        if($valSaldo != 0){
            $bolPendientes = true;
        }
    }
}


$bolImprimir = false;
if(! empty($claGestion->arrMensajes)){
    $bolImprimir = true;
}

$claSmarty->assign("claGestion", $claGestion);
$claSmarty->assign("arrPost", $_POST);
$claSmarty->assign("bolHabilitar", $bolHabilitar);
$claSmarty->assign("arrUnidades", $arrUnidades);
$claSmarty->assign("numTotalGiro", $numTotalGiro);
$claSmarty->assign("numTotalUnidades", $numTotalUnidades);
$claSmarty->assign("arrTablaCDP", $arrTablaCDP);
$claSmarty->assign("bolPendientes", $bolPendientes);
$claSmarty->assign("seqGiroFiducia", $seqGiroFiducia);
$claSmarty->assign("bolImprimir", $bolImprimir);
$claSmarty->display("pryGestionFinanciera/giroFiducia.tpl");

?>
