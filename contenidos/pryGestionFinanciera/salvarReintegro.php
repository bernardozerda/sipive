<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "GestionFinancieraProyectos.class.php" );

$claGestion = new GestionFinancieraProyectos();
$seqReintegro = $claGestion->salvarReintegros($_POST);

$claGestion->proyectos();

$arrBancos = obtenerDatosTabla(
    "t_frm_banco",
    array("seqBanco" , "txtBanco"),
    "seqBanco",
    "seqBanco not in (1,47,50,44)",
    "txtBanco"
);

$bolSalvado = false;
if(empty($claGestion->arrErrores)){
    $bolSalvado = true;
}

$claSmarty->assign("claGestion", $claGestion);
$claSmarty->assign("arrPost", $_POST);
$claSmarty->assign("arrBancos", $arrBancos);
$claSmarty->assign("bolSalvado", $bolSalvado);
$claSmarty->display( "pryGestionFinanciera/reintegros.tpl" );

?>