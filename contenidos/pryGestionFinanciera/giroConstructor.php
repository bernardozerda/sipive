<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "GestionFinancieraProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/IOFactory.php" );

$claGestion = new GestionFinancieraProyectos();
$arrProyectos = $claGestion->proyectosDisponibles();

$bolImprimir = false;
if(intval($_POST['seqGiroConstructor']) != 0){
    $_POST = $claGestion->verGiroConstructor($_POST['seqGiroConstructor']);
    $bolImprimir = true;
}

$seqProyecto = intval($_POST['seqProyecto']);

// cuando hay proyecto seleccionado carga la informacion
if($seqProyecto != 0){
    $claGestion->informacionGiroConstructor($seqProyecto);
}

$numTotalGiro = 0;
$numTotalUnidades = 0;

if($_FILES['archivo']['error'] === 0){

    $arrArchivo = $claGestion->cargarArchivo();
    $arrUnidades = $claGestion->validarArchivo($_POST, $arrArchivo, 'giroConstructor');

    foreach ($arrUnidades as $seqProyecto => $arrUnidad){
        foreach($arrUnidad as $seqUnidadProyecto => $valGiro){
            $numTotalGiro += $valGiro;
            $numTotalUnidades++;
        }
    }

    if(empty($claGestion->arrErrores)) {
        if (empty($arrUnidades)) {
            $claGestion->arrErrores[] = "Al menos debe indicar un valor a girar dentro del archivo, todas las celdas estan en cero";
        }
    }

}else{

    $arrUnidades = array();
    if( isset( $_POST['unidades'][$seqProyecto] )){
        $arrUnidades = $_POST['unidades'];
        foreach($_POST['unidades'][$seqProyecto] as $seqUnidadProyecto => $valGiro){
            $numTotalGiro += $valGiro;
            $numTotalUnidades++;
        }
    }

}

if(doubleval($claGestion->arrGiroConstructor['giros'] != 0)){
    $claGestion->arrGiroConstructor['giros'] -= $numTotalGiro;
}
$claGestion->arrGiroConstructor['saldo'] -= $numTotalGiro;

$bolImprimir = false;
if(intval($_POST['seqGiroConstructor']) != 0){
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