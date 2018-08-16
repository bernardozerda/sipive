<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "InscripcionFonvivienda.class.php" );

$seqCargue        = $_POST['seqCargue'];
$numHogar         = $_POST['numHogar'];
$seqEstadoHogar   = $_POST['seqEstadoHogar'];
$txtObservaciones = $_POST['txtObservaciones'];
$numDocumento     = $_POST['numDocumento'];
$seqCiudadano     = intval($_POST['seqCiudadano']);

$claInscripcion = new InscripcionFonvivienda();
$claInscripcion->cargar($seqCargue,$numHogar);
$claInscripcion->validarFormulario($_POST);
$claInscripcion->procesarNovedades($_POST['seqFormulario'], $numHogar, $numDocumento);

if(! empty($claInscripcion->arrErrores)){

    if(! empty($claInscripcion->arrErrores['ciudadano'])){
        $claInscripcion->arrErrores['general'][] = "No es posible salvar novedades por inconsistencias en la seleccion del formulario";
    }

    $claInscripcion->arrHogares[$numHogar]['seqEstadoHogar']   = ($seqEstadoHogar != 0)? $seqEstadoHogar : $claInscripcion->arrHogares[$numHogar]['seqEstadoHogar'];
    $claInscripcion->arrHogares[$numHogar]['txtObservaciones'] = ($txtObservaciones != "")? $txtObservaciones : $claInscripcion->arrHogares[$numHogar]['txtObservaciones'];
    if(isset($_POST['seqFormulario'])){
        $claInscripcion->arrHogares[$numHogar]['seqFormulario'] = intval($_POST['seqFormulario']);
    }

    $claSmarty->assign("seqCargue"      , $seqCargue);
    $claSmarty->assign("numHogar"       , $numHogar);
    $claSmarty->assign("numDocumento"   , $numDocumento);
    $claSmarty->assign("seqCiudadano"   , $seqCiudadano);
    $claSmarty->assign("claInscripcion" , $claInscripcion);
    $claSmarty->display("inscripcionFonvivienda/detalles.tpl");

}else{

    $claInscripcion->salvarSolucionNovedades($_POST);
    $claInscripcion->cargar($_POST['seqCargue']);

    $bolProcesar = false;
    foreach($claInscripcion->arrHogares as $numHogar => $arrHogar){
        if($arrHogar['seqEstadoHogar'] == 2){
            $bolProcesar = true;
        }
    }

    $claSmarty->assign("bolProcesar" , $bolProcesar);
    $claSmarty->assign("claInscripcion" , $claInscripcion);
    $claSmarty->display("inscripcionFonvivienda/informacion.tpl");

}

?>