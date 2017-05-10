<?php
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "calificacion.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );

$claCalificacion = new calificacion();

$fecha = $_GET['fecha'];

$datos = $claCalificacion->listarCalificacion($fecha);

$claSmarty->assign("datos", $datos);
$claSmarty->display("calificacion/listaCalificacion.tpl");
?>

