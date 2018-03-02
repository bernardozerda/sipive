<?php

/**
 * INICIO DE LA PANTALLA DE VALDACION Y RE-VALIDACION
 * @author Bernardo Zerda
 * @version 2.0 Nov 2017
 */

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Cruces.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );

$_POST['creacionInicio'] = (esFechaValida($_POST['creacionInicio']))? new DateTime($_POST['creacionInicio']) : null;
$_POST['creacionFinal']  = (esFechaValida($_POST['creacionFinal']))?  new DateTime($_POST['creacionFinal']) : null;
if($_POST['creacionFinal'] != null or $_POST['creacionInicio'] != null) {
    if($_POST['creacionFinal'] != null){
        if (($_POST['creacionFinal'] < $_POST['creacionInicio']) or $_POST['creacionInicio'] == null) {
            $arrErrores[] = "El intervalo de fechas del filtro de Creación está errado";
        }
    }else{
        $arrErrores[] = "No tiene fecha final del filtro de creación";
    }
}

$_POST['updateInicio'] = (esFechaValida($_POST['updateInicio']))? new DateTime($_POST['updateInicio']) : null;
$_POST['updateFinal']  = (esFechaValida($_POST['updateFinal']))?  new DateTime($_POST['updateFinal']) : null;
if($_POST['updateFinal'] != null or $_POST['updateInicio'] != null) {
    if($_POST['updateFinal'] != null) {
        if ($_POST['updateFinal'] < $_POST['updateInicio']) {
            $arrErrores[] = "El intervalo de fechas del filtro de Actualización está errado";
        }
    }else{
        $arrErrores[] = "No tiene fecha final del filtro de actualización";
    }
}

$_POST['cruceInicio'] = (esFechaValida($_POST['cruceInicio']))? new DateTime($_POST['cruceInicio']) : null;
$_POST['cruceFinal']  = (esFechaValida($_POST['cruceFinal']))?  new DateTime($_POST['cruceFinal']) : null;
if($_POST['cruceFinal'] != null or $_POST['cruceInicio'] != null) {
    if($_POST['cruceFinal'] != null) {
        if ($_POST['cruceFinal'] < $_POST['cruceInicio']) {
            $arrErrores[] = "El intervalo de fechas del filtro de Fecha está errado";
        }
    }else{
        $arrErrores[] = "No tiene fecha final del filtro de fecha";
    }
}

$seqFormulario = 0;
if(intval($_POST['documento']) != 0){
    try {
        $seqFormulario = Ciudadano::formularioVinculado($_POST['documento']);
    }catch(Exception $objError){
        $seqFormulario = 0;
    }
}

$claCruces = new Cruces();
if(! empty($arrErrores)){
    imprimirMensajes($arrErrores);
    $arrCruces = $claCruces->listado();
}else{
    $arrCruces = $claCruces->listado($_POST);
}

$claSmarty->assign( "arrPost"  , $_POST );
$claSmarty->assign( "arrCruces", $arrCruces );
$claSmarty->assign( "seqFormulario", $seqFormulario );
$claSmarty->display( "cruces2/cruces.tpl" );

?>