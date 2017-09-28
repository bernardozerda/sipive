<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "RegistroActividades.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos2.class.php" );

$claActosAdministrativos = new ActoAdministrativo();
$claActosAdministrativos->eliminarActoAdministrativo( $_POST['numActo'] , $_POST['fchActo'] , $_POST['txtMotivo'] );

if( empty( $claActosAdministrativos->arrErrores ) ){
   $arrMensajes[] = "Se ha eliminado el acto administrativo " . $_POST['numActo'] . " de " . $_POST['fchActo'];
}

imprimirMensajes($claActosAdministrativos->arrErrores,$arrMensajes);

?>