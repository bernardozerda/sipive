<?php

ini_set("memory_limit","-1");
ini_set("max_execution_time","0");
chdir(__DIR__);

$bolMostrarMensajes = (isset($argv[1]) and intval($argv[1]) == 1)? true : false;

$txtPrefijoRuta = "../../../";

// si se intenta acceder por navegador redirecciona al index
if(isset($_SERVER['HTTP_HOST'])){
    header("Location: " . $txtPrefijoRuta . "index.php");
}else{

    mensaje("Inicia el procesamiento del script");

    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "InscripcionFonvivienda.class.php" );

    $claInscripcion = new InscripcionFonvivienda();

    // obtiene el cargue a procesar
    $seqCargue = $claInscripcion->carguePorProcesar();
    if($seqCargue != 0){

        // pone el cargue "en proceso"
        $claInscripcion->iniciarCargue($seqCargue, 2);
        if(empty($claInscripcion->arrErrores)){

            // obtiene el archivo
            $arrArchivo = $claInscripcion->cargarArchivo($seqCargue);
            if(empty($claInscripcion->arrErrores)) {

                // se deshace de todas las lineas que no se deben procesar
                $arrArchivo = $claInscripcion->limpiezaArchivo($arrArchivo);

                // arma los hogares como quedaran despues de procesar el archivo
                $claInscripcion->hogares($arrArchivo);

                // busca coincidencias para cada miembro de hogar
                if(empty($claInscripcion->arrErrores)) {

                    $claInscripcion->coincidencias($seqCargue);

                    if(empty($claInscripcion->arrErrores)){

                        // almacenar novedades
                        $claInscripcion->salvarNovedades($seqCargue);

                        if(! empty($claInscripcion->arrErrores)){
                            mensaje($claInscripcion->arrErrores);
                        }

                    }else{
                        mensaje($claInscripcion->arrErrores);
                    }

                }else{
                    mensaje($claInscripcion->arrErrores);
                }
            }else{
                mensaje($claInscripcion->arrErrores);
            }
        }else{
            mensaje($claInscripcion->arrErrores);
        }

        // al terminar el cargue cambia el estado
        if(! empty($claInscripcion->arrErrores)){
            $claInscripcion->finalizarCargue($seqCargue, 3);
        }else{
            $claInscripcion->finalizarCargue($seqCargue, 4);
        }

    }else{
        mensaje("No hay cargues pendientes para procesar");
    }

}

/**********************************************************************************************************************/

function mensaje($txtMensaje){
    global $bolMostrarMensajes;
    if($bolMostrarMensajes) {
        if(is_array($txtMensaje)){
            foreach($txtMensaje as $txtMostrar){
                echo date("Y-m-d H:i:s") . "\t| " . $txtMostrar . "\r\n";
            }
        }else{
            echo date("Y-m-d H:i:s") . "\t| " . $txtMensaje . "\r\n";
        }
    }
}



?>