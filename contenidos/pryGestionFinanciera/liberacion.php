<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "GestionFinancieraProyectos.class.php" );

$claGestion = new GestionFinancieraProyectos();
$claGestion->proyectos();

if(intval($_POST['seqProyecto']) != 0){
    $claGestion->informacionProyecto($_POST['seqProyecto']);
}

$claSmarty->assign("claGestion", $claGestion);
$claSmarty->assign("arrPost", $_POST);
$claSmarty->display( "pryGestionFinanciera/liberacion.tpl" );

?>