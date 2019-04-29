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
                    $tamano = filesize($nextpath);
                    $medidasimagen = getimagesize($nextpath);
                    $info = new SplFileInfo($nextpath);
                    $tipo = $info->getExtension();
                    // var_dump($info->getBasename());                    die();
                    //Si las imagenes tienen una resolución y un peso aceptable se suben tal cual
                    if ($medidasimagen[0] > 1280 && $tamano > 200000) {
                        $nombrearchivo = $info->getBasename();
                        //Redimensionar
                        $rtOriginal = $nextpath;
                        $original = "";
                        if ($tipo == 'jpeg') {
                            $original = imagecreatefromjpeg($rtOriginal);
                        } else if ($tipo == 'png') {
                            $original = imagecreatefrompng($rtOriginal);
                        } else if ($tipo == 'gif') {
                            $original = imagecreatefromgif($rtOriginal);
                        } else if ($tipo == 'jpg' || $tipo == 'JPG') {
                            $original = imagecreatefromjpeg($rtOriginal);
                        }

                        list($ancho, $alto) = getimagesize($rtOriginal);

                        $x_ratio = $max_ancho / $ancho;
                        $y_ratio = $max_alto / $alto;

                        if (($ancho <= $max_ancho) && ($alto <= $max_alto)) {
                            $ancho_final = $ancho;
                            $alto_final = $alto;
                        } elseif (($x_ratio * $alto) < $max_alto) {
                            $alto_final = ceil($x_ratio * $alto);
                            $ancho_final = $max_ancho;
                        } else {
                            $ancho_final = ceil($y_ratio * $ancho);
                            $alto_final = $max_alto;
                        }

                        $lienzo = imagecreatetruecolor($ancho_final, $alto_final);

                        imagecopyresampled($lienzo, $original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);

                        imagedestroy($original);

                        $cal = 8;

                        if ($tipo == 'jpeg' || $tipo == 'jpg' || $tipo == 'JPG') {
                            imagejpeg($lienzo, $patch . "/" . $nombrearchivo);
                        } else if ($tipo == 'png') {
                            imagepng($lienzo, $patch . "/" . $nombrearchivo);
                        } else if ($tipo == 'gif') {
                            imagegif($lienzo, $patch . "/" . $nombrearchivo);
                        }

                        fwrite($archivo, $cont . "\t" . $nombrearchivo . "\r\n");
                        echo "\n*** " . $nombrearchivo . " posicion " . $cont;
                        $cont++;
                    }
                    $totalsize += $tamano;
                    $totalcount++;
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
$path = 'D:\ImagenesBosa601';
$ar = getDirectorySize($path);


echo "Details for the path : $path";
echo "Total size : " . sizeFormat($ar['size']) . "\n";
echo "No. of files : " . $ar['count'] . "\n";
echo "No. of file modify : " . $ar['cant'] . "\n";
fclose($archivo);
