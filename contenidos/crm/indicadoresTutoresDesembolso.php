<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );
include( "./datosComunes.php" );

$claCrm = new CRM;
$arrEstado = array();

$arrEstado["revisionOferta"] = "Busqueda de la Oferta";
$arrEstado["revisionJuridica"] = "Revisión Jurídica";
$arrEstado["revisionTecnica"] = "Revisión Técnica";
$arrEstado["escrituracion"] = "Escrituración";
$arrEstado["estudioTitulos"] = "Estudio de Titulos";
$arrEstado["solicitudDesembolso"] = "Solicitud de Desembolso";

$claCrm->obtenerIdUsuarioIndicador();
$seqUsuario = $claCrm->seqUsuario;

$claCrm->obtenerHogaresPromedioTutorDesembolso();
$claCrm->obtenerHogaresPorEstadoTutorDesembolso();
$claCrm->obtenerCuentaDesembolsoTotal();

$claSmarty->assign("txtEstado", "todos");
$claSmarty->assign("arrEstado", $arrEstado);
$claSmarty->assign("seqUsuario", $seqUsuario);
$claSmarty->assign("claCrm", $claCrm);
$claSmarty->display("crm/indicadoresTutoresDesembolso.tpl");
?>
