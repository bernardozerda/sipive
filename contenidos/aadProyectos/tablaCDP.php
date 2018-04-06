<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aadProyectos.class.php" );

foreach($_POST as $txtCampo => $txtValor){
    $_POST[$txtCampo] = regularizarCampo($txtCampo,$txtValor);
}

$claActo = new aadProyectos();

if($_POST['salvar'] == 0){

    $arrCdp = $claActo->listarCDP(
        null,
        $_POST['numNumeroCDP'],
        $_POST['fchFechaCDP'],
        null,
        null,
        $_POST['numProyectoInversionCDP'],
        $_POST['numNumeroRP'],
        $_POST['fchFechaRP'],
        null,
        null
    );

    $claSmarty->assign("arrPost",$_POST);
    $claSmarty->assign("arrCdp",$arrCdp);
    $claSmarty->display( "aadProyectos/tablaCDP.tpl" );

}elseif($_POST['salvar'] == 1){

    $arrErrores = array();
    $txtMensaje = "";
    unset($_POST['eliminar']);
    foreach($_POST as $txtCampo => $txtValor){
        if($txtValor == 0 or $txtValor == null or $txtValor == ""){
            $arrErrores['generico'] = "Hay errores en los campos del formulario, por favor corriga los datos digitados";
            $arrErrores[$txtCampo] = true;
        }
    }

    if(empty($arrErrores)) {
        $arrCdp = $claActo->listarCDP(
            null,
            $_POST['numNumeroCDP'],
            $_POST['fchFechaCDP'],
            null,
            null,
            $_POST['numProyectoInversionCDP'],
            $_POST['numNumeroRP'],
            $_POST['fchFechaRP'],
            null,
            null
        );

        if(! empty($arrCdp)){
            $arrErrores['generico'] = "Ya existe un registro presupuestal con los datos digitados";
        }else{
            $claActo->salvarCDP($_POST);
            if(! empty($claActo->arrErrores)) {
                $arrErrores['generico'] = $claActo->arrErrores[0];
            }else{
                $txtMensaje = "Se ha salvado el registro presupuestal";
            }
        }

    }

    $claSmarty->assign("arrErrores",$arrErrores);
    $claSmarty->assign("txtMensaje",$txtMensaje);
    $claSmarty->assign("arrPost",$_POST);
    $claSmarty->assign("arrCdp",$claActo->listarCDP());
    $claSmarty->display( "aadProyectos/bodyCDP.tpl" );

}elseif($_POST['salvar'] == 2){

    $arrErrores = array();
    $txtMensaje = "";

    $arrCdp = $claActo->listarCDP(
        $_POST['eliminar']
    );

    $claActo->eliminarCDP($_POST['eliminar']);
    if(empty($claActo->arrErrores)){
        $txtMensaje = "Ha Eliminado el registro CDP " . $arrCdp[0]['numNumeroCDP'] . " del " . $arrCdp[0]['fchFechaCDP'] . " - RP " . $arrCdp[0]['numNumeroRP'] . " del " . $arrCdp[0]['fchFechaRP'];
    }else{
        $arrErrores['generico'] = $claActo->arrErrores[0];
    }

    $claSmarty->assign("arrErrores",$arrErrores);
    $claSmarty->assign("txtMensaje",$txtMensaje);
    $claSmarty->assign("arrPost",$_POST);
    $claSmarty->assign("arrCdp",$claActo->listarCDP());
    $claSmarty->display( "aadProyectos/bodyCDP.tpl" );


}



?>