<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "LegalizacionMCY.class.php" );

$claLegalizacionMcy = new LegalizacionMCY();
$claReporte = new Reportes();
$fecha = $_REQUEST['fchCreacion'];
$objRes = $claLegalizacionMcy->datosDetalles($fecha);

$seqFormularios = Array();
foreach ($objRes as $key => $value) {
    foreach ($value as $keyF => $valueF) {
        if ($keyF == "ID HOGAR") {
            //echo "<br>" . $keyF . " = " . $valueF;
            $seqFormularios[] = $valueF;
        }
    }
}
$claLegalizacionMcy->eliminarCargue($seqFormularios);

$listaReportes = $claLegalizacionMcy->listaInformes();

//$claSmarty->assign("listaReportes", $listaReportes);
$claSmarty->display("legalizacionMCY/reporte.tpl");

