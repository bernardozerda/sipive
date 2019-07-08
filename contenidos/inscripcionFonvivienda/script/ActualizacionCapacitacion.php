<?php

chdir( __DIR__ );
include ("./funciones.php");
$nombre_fichero = '../../../htdocs/sipive';
/*
 * Actualización semanal    de archivos en capacitación 
 *
 * 
 */
$source = '../../../htdocs/sipive';
$target = '../../../htdocs/capacitacionN';
mensajeLog("****Inicio de proceso de Actualizacion*****");
full_copy($source, $target);

function full_copy($source, $target) {
    $notFiles[0] = "lecturaConfiguracion";
    $notFiles[1] = "recursos/imagenes/desembolsos";
    $notFiles[3] = ".git/";
    if (is_dir($source)) {
        @mkdir($target);
        $d = dir($source);
        while (FALSE !== ( $entry = $d->read() )) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            $Entry = $source . '/' . $entry;
            if (is_dir($Entry)) {
                full_copy($Entry, $target . '/' . $entry);
                continue;
            }
            $band = TRUE;

            $directory = $source . '/' . $entry;
            foreach ($notFiles as $key => $value) {
                $conicidencia = strpos($directory, $value);
                if ($conicidencia !== FALSE) {
                    $band = FALSE;
                }
            }

            if ($band) {
                mensajeLog("Archivo copiado:\t" . $Entry);
                copy($Entry, $target . '/' . $entry);
            }
        }

        $d->close();
    } else {
        copy($source, $target);
    }
}

mensajeLog("****Fin de proceso de Actualizacion*****");
//$ruta_directorio = __DIR__ . "/fotos";
