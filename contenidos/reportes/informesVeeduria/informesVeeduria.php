<?php

$txtPrefijoRuta = "../../../";
include($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
include($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "InformeVeedurias.class.php" );

$claInforme = new InformeVeedurias();
$arrCortes = $claInforme->obtenerCortes();

$claSmarty->assign( "arrPost"   , $_POST );
$claSmarty->assign( "arrCortes" , $arrCortes );
$claSmarty->display( "reportes/informesVeeduria/informesVeeduria.tpl" );

?>