<?php

// Archivos necesarios
include("./recursos/archivos/lecturaConfiguracion.php" );
include($txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Encuestas.class.php" );
include($txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

$documento = 51818861;

$encuesta = new Encuestas();
$variables = $encuesta->obtenerVariablesCalificacion($documento);

pr($variables);


?>