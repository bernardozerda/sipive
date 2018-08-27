<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "InscripcionFonvivienda.class.php" );

$seqCargue        = intval($_POST['seqCargue']);
$numHogar         = intval($_POST['numHogar']);
$seqEstadoHogar   = intval($_POST['seqEstadoHogar']);
$txtObservaciones = trim($_POST['txtObservaciones']);
$numDocumento     = doubleval($_POST['numDocumento']);
$seqCiudadano     = intval($_POST['seqCiudadano']);

$claInscripcion = new InscripcionFonvivienda();
$claInscripcion->cargar($seqCargue,$numHogar);

$claInscripcion->arrHogares[$numHogar]['seqEstadoHogar']   = ($seqEstadoHogar != 0)? $seqEstadoHogar : $claInscripcion->arrHogares[$numHogar]['seqEstadoHogar'];
$claInscripcion->arrHogares[$numHogar]['txtObservaciones'] = ($txtObservaciones != "")? $txtObservaciones : $claInscripcion->arrHogares[$numHogar]['txtObservaciones'];
if(isset($_POST['seqFormulario'])){
    $claInscripcion->arrHogares[$numHogar]['seqFormulario'] = intval($_POST['seqFormulario']);
    foreach($claInscripcion->arrHogares[$numHogar]['ciudadanos'] as $idCiudadano => $arrCiudadano){
        $claInscripcion->arrHogares[$numHogar]['ciudadanos'][$idCiudadano]['seqCiudadanoCoincidencia'] = null;
        if($numDocumento == $arrCiudadano['numDocumento']){
            $claInscripcion->arrHogares[$numHogar]['ciudadanos'][$idCiudadano]['seqCiudadanoCoincidencia'] = $seqCiudadano;
        }
    }
}elseif(is_numeric($claInscripcion->arrHogares[$numHogar]['seqFormulario']) and intval($_POST['seqFormulario']) == 0){
    $_POST['seqFormulario'] = $claInscripcion->arrHogares[$numHogar]['seqFormulario'];
    $numDocumento = 0;
    $seqCiudadano = 0;
    foreach($claInscripcion->arrHogares[$numHogar]['ciudadanos'] as $idCiudadano => $arrCiudadano){
        if($arrCiudadano['bolPrincipal'] == 1){
            $numDocumento = $arrCiudadano['numDocumento'];
            $seqCiudadano = $arrCiudadano['seqCiudadanoCoincidencia'];
        }
    }
}

if(is_numeric($claInscripcion->arrHogares[$numHogar]['seqFormulario'])){
    $claInscripcion->procesarNovedades($_POST['seqFormulario'],$numHogar,$numDocumento);
}

$claSmarty->assign("seqCargue"      , $seqCargue);
$claSmarty->assign("numHogar"       , $numHogar);
$claSmarty->assign("numDocumento"   , $numDocumento);
$claSmarty->assign("seqCiudadano"   , $seqCiudadano);
$claSmarty->assign("claInscripcion" , $claInscripcion);
$claSmarty->display("inscripcionFonvivienda/detalles.tpl");

?>