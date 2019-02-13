<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );
include( "./datosComunes.php" );

$claCRM = new CRM;
$faseIndicador = $_POST['faseIndicador'];
$seqUsuario = $_POST['seqUsuario'];

$claCRM->cargarIndicador($seqUsuario, $faseIndicador);

$claSmarty->assign("verde", $claCRM->arrIndicadorCuenta['verde']);
$claSmarty->assign("amarillo", $claCRM->arrIndicadorCuenta['amarillo']);
$claSmarty->assign("rojo", $claCRM->arrIndicadorCuenta['rojo']);
$claSmarty->assign("txtTipoReporte", $claCRM->txtTipoReporte);
$claSmarty->display("crm/indicadorTutorDesembolso/cuentaIndicador.tpl");
?>
