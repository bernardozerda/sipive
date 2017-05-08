<?php

$txtPrefijoRuta = "../../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

$arrErrores = array();
$arrMensajes = array();

$claZip = new ZipArchive();
$claZip->open($_FILES['archivo']['tmp_name']);

if ($claZip->numFiles == 0) {
    $arrErrores[] = "No es un archivo zip o esta vacio";
} else {

    $txtRutaTemporal = $txtPrefijoRuta . "../bvu/recursos/imagenes/temporal";
    $txtRutaFinal = $txtPrefijoRuta . "../bvu/recursos/imagenes";

    if ($aptDirectorio = opendir($txtRutaTemporal)) {
        while (false !== ( $txtArchivo = readdir($aptDirectorio) )) {
            if ($txtArchivo != "." and $txtArchivo != "..") {
                unlink($txtArchivo);
            }
        }
    }

    $claZip->extractTo($txtRutaTemporal);
    $claZip->close;

    if ($aptDirectorio = opendir($txtRutaTemporal)) {

        while (false !== ( $txtArchivo = readdir($aptDirectorio) )) {
            if ($txtArchivo != "." and $txtArchivo != "..") {
                $numTamano = filesize($txtRutaTemporal . "/" . $txtArchivo);
                if ($numTamano < 200000) {
                    $arrContenido[] = $txtArchivo;
                } else {
                    $arrErrores[] = "El archivo $txtArchivo exede los 200K de tamaño límite";
                }
            }
        }
        closedir($aptDirectorio);

        if (in_array("tabla.txt", $arrContenido)) {

            if (file_exists($txtRutaTemporal . "/tabla.txt")) {

                $arrTabla = file($txtRutaTemporal . "/tabla.txt");
                foreach ($arrTabla as $numLinea => $txtImagen) {
                    $arrImagenes[$numLinea] = split("\t", trim($txtImagen));
                }
                unset($arrImagenes[0]);

                foreach ($arrImagenes as $numLinea => $arrImagen) {

                    $sql = "DELETE FROM T_BVU_IMAGENES WHERE seqInmueble = " . $arrImagen[0];
                    $aptBd->execute($sql);

                    if (is_dir($txtRutaFinal . "/" . $arrImagen[0])) {
                        if ($aptDirectorioFinal = opendir($txtRutaFinal . "/" . $arrImagen[0])) {
                            while (false !== ( $txtArchivo = readdir($aptDirectorioFinal) )) {
                                if ($txtArchivo != "." and $txtArchivo != "..") {
                                    unlink($txtRutaFinal . "/" . $arrImagen[0] . "/" . $txtArchivo);
                                }
                            }
                            closedir($aptDirectorioFinal);
                        } else {
                            $arrErrores[] = "No se pudo abrir el destino definitivo " . $arrImagen[0];
                        }
                    } else {
                        $txtComando = "mkdir \"" . $txtRutaFinal . "/" . $arrImagen[0] . "\"";
                        exec($txtComando);
                    }
                }

                if (empty($arrErrores)) {
                    foreach ($arrImagenes as $numLinea => $arrImagen) {
                        if (is_dir($txtRutaFinal . "/" . $arrImagen[0])) {
                            @copy($txtRutaTemporal . "/" . $arrImagen[1], $txtRutaFinal . "/" . $arrImagen[0] . "/" . $arrImagen[1]);
                            unlink($txtRutaTemporal . "/" . $arrImagen[1]);

                            try {
                                $sql = "
			    						INSERT INTO T_BVU_IMAGENES ( 
			    							seqInmueble, 
			    							txtNombre, 
			    							txtImagen 
			    						) VALUES ( 
			    							" . $arrImagen[0] . ", 
			    							'" . $arrImagen[1] . "', 
			    							'recursos/imagenes/" . $arrImagen[0] . "/" . $arrImagen[1] . "' 
			    						)
			    					";
                                $aptBd->execute($sql);
                            } catch (Exception $objError) {
                                $arrErrores[] = "Error al insertar las imagenes del inmueble " . $arrImagen[0] . ", el inmueble no existe";
                            }
                        } else {
                            $arrErrores[] = "El directorio " . $txtRutaFinal . "/" . $arrImagen[0] . " no existe para copiar las imagenes";
                        }
                    }
                }
                unlink($txtRutaTemporal . "/tabla.txt");
            } else {
                $arrErrores[] = "No existe el archivo tabla.txt en la carpeta temporal de imagenes";
            }
        } else {
            $arrErrores[] = "No existe el archivo tabla.txt dentro del zip";
        }
    } else {
        $arrErrores[] = "No se pudo abrir la carpeta temporal de imagenes";
    }
}

if (empty($arrErrores)) {
    $arrMensajes[] = "Se han cargado las imagenes satisfactoriamente";
}

imprimirMensajes($arrErrores, $arrMensajes);
?>
