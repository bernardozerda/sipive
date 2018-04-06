<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aadProyectos.class.php" );

$claActo = new aadProyectos();
$arrTipos = $claActo->tiposActos();

$claSmarty->assign("arrTipos",$arrTipos);
$claSmarty->assign("arrCdp",$claActo->listarCDP());
$claSmarty->display( "aadProyectos/crear.tpl" );


?>