<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "GestionFinancieraProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "SeguimientoProyectos.class.php" );

$claGestion = new GestionFinancieraProyectos();

$claGestion->eliminarReintegro($_POST['seqReintegro']);

$arrListado = $claGestion->listadoReintegros();

$claSmarty->assign("arrListado", $arrListado);
$claSmarty->assign("claGestion", $claGestion);
$claSmarty->display( "pryGestionFinanciera/listadoReintegros.tpl" );


?>