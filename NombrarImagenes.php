<?php

$ruta = 'D:\imagenesPorvenir2';

//$ruta = 'C:\Users\liliana.basto\Documents\Datos Tecnica\Adriana Faura\Primera Entrega\FOTOS\imagenes';
listar($ruta);

function listar($directorio) {
   
    $out = array();
    $dir = opendir($directorio); echo "paso";
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

                        echo "<br>" . ($directorio . '/' . $file . "/" . $one . " ====> " . $directorio . '/' . $file . "/" . $file . "(" . $int . ")." . $var[1]);

                        try {
                         $one2 =  str_replace(" ", "", $one);
                          // rename($directorio . '/' . $file . "/" . $one, $directorio . '/' . $file . "/" .$one2);
                            rename($directorio . '/' . $file."/".$one, $directorio . '/' . $file."/".$file."(".$int.").".$var[1]);
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
