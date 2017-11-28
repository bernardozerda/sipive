<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Cruces.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "RegistroActividades.class.php" );

$claCruces = new Cruces();
$claCruces->cargar($_POST['seqCruce']);

$claCruces->eliminar($_POST['seqCruce']);

$claRegistroActividades = new RegistroActividades();
$claRegistroActividades->registrarActividad(
    'Borrado' ,
    228 ,
    $_SESSION['seqUsuario'] ,
    'Cruce Eliminado [' . $claCruces->arrDatos['seqCruce'] . '] ' . $claCruces->arrDatos['txtNombre']
);

imprimirMensajes($claCruces->arrErrores,$claCruces->arrMensajes);

?>