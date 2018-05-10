<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "GestionFinancieraProyectos.class.php" );

$claGestion = new GestionFinancieraProyectos();
$claGestion->proyectos();

$arrBancos = obtenerDatosTabla(
    "t_frm_banco",
    array("seqBanco" , "txtBanco"),
    "seqBanco",
    "seqBanco not in (1,47,50,44)",
    "txtBanco"
);

if(isset($_POST['salvar'])){
    $claGestion->validarFormularioReintegros($_POST);
    if(empty($claGestion->arrErrores)){
        $txtValidar = $_POST['salvar'];
        $numPosicion = count($_POST['registros']);
        $_POST['registros'][$numPosicion]['txtTipo']         = $_POST['salvar'];
        $_POST['registros'][$numPosicion]['seqBanco']        = $_POST[$txtValidar]['seqBanco'];
        $_POST['registros'][$numPosicion]['numCuenta']       = $_POST[$txtValidar]['numCuenta'];
        $_POST['registros'][$numPosicion]['fchConsignacion'] = $_POST[$txtValidar]['fchConsignacion'];
        $_POST['registros'][$numPosicion]['valConsignacion'] = mb_ereg_replace("[^0-9]","", $_POST[$txtValidar]['valConsignacion']);
        $_POST[$txtValidar] = array();
    }
}

if(isset($_POST['eliminar']) and ! isset($_POST['eliminar'])){
    $numPosicion = $_POST['eliminar'];
    $arrRegistros = $_POST['registros'];
    unset($arrRegistros[$numPosicion]);
    $_POST['registros'] = array();
    foreach ($arrRegistros as $arrRegistro) {
        $numPosicion = count($_POST['registros']);
        $_POST['registros'][$numPosicion] = $arrRegistro;
    }
}


$claSmarty->assign("claGestion", $claGestion);
$claSmarty->assign("arrPost", $_POST);
$claSmarty->assign("arrBancos", $arrBancos);
$claSmarty->display( "pryGestionFinanciera/reintegros.tpl" );

pr($_POST);

?>