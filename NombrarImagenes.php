<?php

$txtPrefijoRuta = "./";

include( "./recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );


//$ruta = 'D:\Reservas-2019\Senderos (47 VIP)';
//listar($ruta);
//crearCarpetas();
//girarImagen($ruta);
//eliminarReporteGral();

function listar($directorio) {

    $out = array();
    $dir = opendir($directorio);
    //echo "paso";
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_file($directorio . '/' . $file))
                $out [] = $file;
            elseif (is_dir($directorio . '/' . $file)) {
                $int = 1;
                echo"<br>" . $file;
                // echo "<br>".$var[1];
                foreach (listar($directorio . '/' . $file) as $one) {
                    $var = explode('.', $one);
                    if ($var[1] != "") {
                        // echo"<br>" . $file;
                        // echo "<br>   * " . $one;
                        // echo "<b> ***".$file."(".$int.").".$var[1]."</b>";
                        //  echo "<br>" . ($directorio . '/' . $file . "/" . $one . " ====> " . $directorio . '/' . $file . "/" . $file . "(" . $int . ")." . $var[1]);

                        try {
                            $one2 = str_replace(" ", "", $one);
                            //rename($directorio . '/' . $file . "/" . $one, $directorio . '/' . $file . "/".date('y-m-d_his').'-' .$one2);
                            rename($directorio . '/' . $file . "/" . $one, $directorio . '/' . $file . "/" . $file . "(" . $int . ")." . $var[1]);
                        } catch (Exception $ex) {
                            echo $ex->getMessage();
                        }

                        $int++;
                    }
                }
                //$out [] = $file . '/' . $one;
            }
        }
    }
    closedir($dir);
    // var_dump($out);
    return $out;
}

function crearCarpetas() {
    global $aptBd;

    /*  $sql = "select seqUnidadProyecto from t_pry_unidad_proyecto WHERE seqUnidadProyecto in (13885	,

      )"; */
    $sql = "select * from t_pry_unidad_proyecto 
 left join t_pry_tecnico using(seqUnidadProyecto)
where seqProyecto = 225 and seqTecnicoUnidad is null";
    $objRes = $aptBd->execute($sql);
    $txtArchivo = "Archivo;Existe\n";
    while ($objRes->fields) {
        echo "<br>C:\Users\liliana.basto\Documents\Reservas-2019\\" . $objRes->fields['seqUnidadProyecto'];
        mkdir("C:\Users\liliana.basto\Documents\MZ65\\" . $objRes->fields['seqUnidadProyecto'], 0777);
        $objRes->MoveNext();
    }

//    foreach ($array as $key => $value) {
//        
//        echo "<br>D:\imagenesPorvenir2\Manzana65\\".$value;
//        mkdir("D:\imagenesPorvenir2\Manzana65\\".$value, 0777);
//        
//    }
}

function girarImagen($directorio) {

    $out = array();
    $dir = opendir($directorio);
    //echo "paso";
    while (false !== ($file = readdir($dir))) {

        if (($file != '.') && ($file != '..')) {

            if (is_file($directorio . '/' . $file)) {
                echo "<br>" . $file;
                $imgDif = explode("(", $file);
                //var_dump($imgDif); die();
                if ($imgDif[1] != "1).JPG" AND $imgDif[1] != "1).jpg") {

                    $out [] = $file;
                    $nombre_fichero = $directorio . '/' . $file;
                    $image = $nombre_fichero;
//Destino de la nueva imagen vertical
                    $image_rotate = $nombre_fichero;

//Definimos los grados de rotacion
                    $degrees = -90;

//Creamos una nueva imagen a partir del fichero inicial
                    $source = imagecreatefromjpeg($image);

//Rotamos la imagen 90 grados
                    $rotate = imagerotate($source, $degrees, 0);

//Creamos el archivo jpg vertical
                    imagejpeg($rotate, $image_rotate);
                    echo "paso" . $file;
                }
            } elseif (is_dir($directorio . '/' . $file)) {
                $int = 1;
                echo"<br>" . $file;
                //die();
                // echo "<br>".$var[1];
                foreach (listar($directorio . '/' . $file) as $one) {

                    $var = explode('.', $one);
                    if ($var[1] != "") {

                        try {
                            $one2 = str_replace(" ", "", $one);
                            $imgDif = explode("(", $one2);
                            if ($imgDif[1] != "1).JPG" AND $imgDif[1] != "1).jpg") {
                                $nombre_fichero = $directorio . '/' . $file . "/" . $one;
                                echo"<br> ***" . $nombre_fichero;
                                $image = $nombre_fichero;
//Destino de la nueva imagen vertical
                                $image_rotate = $nombre_fichero;

//Definimos los grados de rotacion
                                $degrees = -90;

//Creamos una nueva imagen a partir del fichero inicial
                                $source = imagecreatefromjpeg($image);

//Rotamos la imagen 90 grados
                                $rotate = imagerotate($source, $degrees, 0);

//Creamos el archivo jpg vertical
                                imagejpeg($rotate, $image_rotate);
                            }
                        } catch (Exception $ex) {
                            echo $ex->getMessage();
                        }

                        $int++;
                    }
                }
                //$out [] = $file . '/' . $one;
            }
        }
    }
    closedir($dir);
    // var_dump($out);
    return $out;
}

function eliminarReporteGral() {
    global $aptBd;
   
   echo  $sql = "DELETE FROM t_frm_reporte_gral where txtNombreReporte = 'reporteGralHogar_20190601_064001'";
    $objRes = $aptBd->execute($sql);
}
