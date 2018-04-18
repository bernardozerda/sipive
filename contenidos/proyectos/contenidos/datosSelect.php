<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$txtPrefijoRuta = "../../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );

//var_dump($_REQUEST);
if (isset($_POST['valor'])) {
 //echo "paso " .$_POST['valor'];
//    echo "paso2";
 $seqPlanGobierno = $_POST['valor'];
 $arrPryTipoModalidad = Array();
    $arrPryTipoModalidad = obtenerDatosTabla("T_FRM_MODALIDAD", array("seqModalidad", "txtModalidad"), "seqModalidad", "seqPlanGobierno = " . $seqPlanGobierno, "seqPlanGobierno DESC, txtModalidad");
   echo json_encode($arrPryTipoModalidad);   
// print_r($arrPryTipoModalidad);
//    die();
    
//    global $aptBd;
//
//        $sql = " SELECT seqModalidad, txtModalidad FROM T_FRM_MODALIDAD ORDER BY seqPlanGobierno DESC";
//
//        $objRes = $aptBd->execute($sql);
//        $datos = Array();
//        while ($objRes->fields) {
//
//            $datos[$objRes->fields['seqModalidad']] = $objRes->fields['txtModalidad'];
//            $objRes->MoveNext();
//        }
//        pr($datos) ;
}