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

// cuando hay proyecto seleccionado carga la informacion
$seqProyecto = intval($_POST['seqProyecto']);
if($seqProyecto != 0){
    $claGestion->informacionGiroConstructor($seqProyecto);
}

$seqGiroConstructor = $claGestion->salvarGiroConstuctor($_POST);

$arrProyectos = $claGestion->proyectosDisponibles();


$arrUnidades = $_POST['unidades'];
$numTotalGiro = 0;
$numTotalUnidades = 0;
foreach ($arrUnidades as $seqProyecto => $arrUnidad){
    foreach($arrUnidad as $seqUnidadProyecto => $valGiro){
        $numTotalGiro += $valGiro;
        $numTotalUnidades++;
    }
}

if(doubleval($claGestion->arrGiroConstructor['giros'] != 0)){
    $claGestion->arrGiroConstructor['giros'] -= $numTotalGiro;
}
$claGestion->arrGiroConstructor['saldo'] -= $numTotalGiro;

$bolImprimir = false;
if(! empty($claGestion->arrMensajes)){
    $bolImprimir = true;
}

$claSmarty->assign("claGestion", $claGestion);
$claSmarty->assign("arrProyectos", $arrProyectos);
$claSmarty->assign("arrPost", $_POST);
$claSmarty->assign("arrUnidades", $arrUnidades);
$claSmarty->assign("numTotalGiro", $numTotalGiro);
$claSmarty->assign("numTotalUnidades", $numTotalUnidades);
$claSmarty->assign("bolImprimir", $bolImprimir);
$claSmarty->display( "pryGestionFinanciera/giroConstructor.tpl" );

?>