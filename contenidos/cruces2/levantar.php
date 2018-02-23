<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Cruces.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "RegistroActividades.class.php" );

$arrErrores = array();
$arrMensajes = array();
$claCruces = new Cruces();
$claCruces->cargar($_POST['seqCruce'],$_POST['seqFormulario']);

if(intval($_POST['levantar']) == 1){

    foreach($_POST['resultado'] as $seqResultado => $arrDatos){

        if($claCruces->arrDatos['arrResultado'][$seqResultado]['bolInhabilitar'] == 0 and $arrDatos['bolInhabilitar'] == 1){
            $arrErrores[] = "No puede generar inhabilidades por este medio, remitase a adicionar lineas del cruce";
        }

        if($claCruces->arrDatos['arrResultado'][$seqResultado]['bolInhabilitar'] == 1 and $arrDatos['bolInhabilitar'] == 0 and trim($arrDatos['txtObservaciones']) == ""){
            $arrErrores[] = "Para levantar la inhabilitar la linea debe digitar las observaciones";
        }

        if ($claCruces->arrDatos['arrResultado'][$seqResultado]['bolInhabilitar'] == $arrDatos['bolInhabilitar']
            and $claCruces->arrDatos['arrResultado'][$seqResultado]['txtObservaciones'] == $arrDatos['txtObservaciones']) {
            unset($_POST['resultado'][$seqResultado]);
        } else {
            $claCruces->arrDatos['arrResultado'][$seqResultado]['bolInhabilitar'] = $arrDatos['bolInhabilitar'];
            $claCruces->arrDatos['arrResultado'][$seqResultado]['txtObservaciones'] = $arrDatos['txtObservaciones'];
        }

    }

    if(empty($arrErrores)) {
        if(! empty($_POST['resultado'])) {
            $claCruces->levantar($_POST);
            $arrErrores = $claCruces->arrErrores;
            $arrMensajes = $claCruces->arrMensajes;
        }else{
            $arrMensajes[] = "No se hicieron cambios en los resultados de los cruces";
        }
    }

}

imprimirMensajes($arrErrores,$arrMensajes);

$claSmarty->assign( "claCruces", $claCruces );
$claSmarty->assign( "seqFormulario", $_POST['seqFormulario'] );
$claSmarty->display( "cruces2/levantar.tpl" );

?>
