<?php

ini_set('memory_limit', '-1');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//$patch = '../sipive/recursos/imagenes/desembolsos';
$nombre_archivo = "logsImages.txt";

if (file_exists($nombre_archivo)) {
    $mensaje = "El Archivo $nombre_archivo se ha modificado";
} else {
    $mensaje = "El Archivo $nombre_archivo se ha creado";
}

$archivo = fopen($nombre_archivo, "w");

function getDirectorySize($path) {
    ini_set('memory_limit', '-1');
    global $archivo;
    $totalsize = 0;
    $totalcount = 0;
    $cont = 1;
    $dircount = 0;
    $max_ancho = 1280;
    $max_alto = 900;
    //$patch = 'D:\prueba2';
    $patch = $path;
    if ($handle = opendir($path)) {

        while (false !== ($file = readdir($handle))) {
            $nextpath = $path . '/' . $file;
            if ($file != '.' && $file != '..' && !is_link($nextpath)) {
                if (is_dir($nextpath)) {
                    $dircount++;
                    $result = getDirectorySize($nextpath);
                    $totalsize += $result['size'];
                    $totalcount += $result['count'];
                    $dircount += $result['dircount'];
                } elseif (is_file($nextpath)) {
                    echo "<br>" . $nextpath;
                    $imagen = $nextpath;
                    $ancho_nuevo = 0;
                    $alto_nuevo = 0;

                    $medidasimagen = getimagesize($nextpath);
                    if ($medidasimagen[0] > $medidasimagen[1]) {
                        $ancho_nuevo = 1280;
                        $alto_nuevo = 900;
                    } else {
                        $ancho_nuevo = 900;
                        $alto_nuevo = 1280;
                    }
                    # ruta de la imagen final, si se pone el mismo nombre que la imagen, esta se sobreescribe
                    //$imagen_final = 'imagen2.jpg';

                    redim($imagen, $imagen, $ancho_nuevo, $alto_nuevo);

                    $tamano = filesize($nextpath);
                }
            }
        }
    }
    closedir($handle);
    $total['size'] = $totalsize;
    $total['count'] = $totalcount;
    $total['cant'] = $cont;

    return $total;
}

function redim($ruta1, $ruta2, $ancho, $alto) {
    # se obtene la dimension y tipo de imagen
    $datos = getimagesize($ruta1);

    $ancho_orig = $datos[0]; # Anchura de la imagen original
    $alto_orig = $datos[1];    # Altura de la imagen original
    $tipo = $datos[2];

    if ($tipo == 1) { # GIF
        if (function_exists("imagecreatefromgif"))
            $img = imagecreatefromgif($ruta1);
        else
            return false;
    }
    else if ($tipo == 2) { # JPG
        if (function_exists("imagecreatefromjpeg"))
            $img = imagecreatefromjpeg($ruta1);
        else
            return false;
    }
    else if ($tipo == 3) { # PNG
        if (function_exists("imagecreatefrompng"))
            $img = imagecreatefrompng($ruta1);
        else
            return false;
    }

    # Se calculan las nuevas dimensiones de la imagen
    if ($ancho_orig > $alto_orig) {
        $ancho_dest = $ancho;
        $alto_dest = ($ancho_dest / $ancho_orig) * $alto_orig;
    } else {
        $alto_dest = $alto;
        $ancho_dest = ($alto_dest / $alto_orig) * $ancho_orig;
    }

    // imagecreatetruecolor, solo estan en G.D. 2.0.1 con PHP 4.0.6+
    $img2 = @imagecreatetruecolor($ancho_dest, $alto_dest) or $img2 = imagecreate($ancho_dest, $alto_dest);

    // Redimensionar
    // imagecopyresampled, solo estan en G.D. 2.0.1 con PHP 4.0.6+
    @imagecopyresampled($img2, $img, 0, 0, 0, 0, $ancho_dest, $alto_dest, $ancho_orig, $alto_orig) or imagecopyresized($img2, $img, 0, 0, 0, 0, $ancho_dest, $alto_dest, $ancho_orig, $alto_orig);

    // Crear fichero nuevo, según extensión.
    if ($tipo == 1) // GIF
        if (function_exists("imagegif"))
            imagegif($img2, $ruta2);
        else
            return false;

    if ($tipo == 2) // JPG
        if (function_exists("imagejpeg"))
            imagejpeg($img2, $ruta2);
        else
            return false;

    if ($tipo == 3)  // PNG
        if (function_exists("imagepng"))
            imagepng($img2, $ruta2);
        else
            return false;

    return true;
}

function sizeFormat($size) {
    if ($size < 1024) {
        return $size . " bytes";
    } else if ($size < (1024 * 1024)) {
        $size = round($size / 1024, 1);
        return $size . " KB";
    } else if ($size < (1024 * 1024 * 1024)) {
        $size = round($size / (1024 * 1024), 1);
        return $size . " MB";
    } else {
        $size = round($size / (1024 * 1024 * 1024), 1);
        return $size . " GB";
    }
}

//$nombre_fichero = '/recursos/imagenes/desembolsos';
//$path = "../sipive/recursos/imagenes/desembolsos";
//$path = "recursos/imagenes/14125";
$path = 'C:\Users\liliana.basto\Documents\2020\MAYO\TECNICA\LACOLMENA\imagenes';
$ar = getDirectorySize($path);


echo "Details for the path : $path";
echo "Total size : " . sizeFormat($ar['size']) . "\n";
echo "No. of files : " . $ar['count'] . "\n";
echo "No. of file modify : " . $ar['cant'] . "\n";
fclose($archivo);
