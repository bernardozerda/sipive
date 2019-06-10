<?php
$txtPrefijoRuta = "../../../";
include($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
include($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "InformeVeedurias.class.php" );
echo "paso * ".$_REQUEST['seqCorte'];

ini_set("memory_limit","-1");
$claInforme = new InformeVeedurias();
$seqCorte = $_REQUEST['seqCorte'];
$claInforme->eliminarReportesVeeduria($seqCorte);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

