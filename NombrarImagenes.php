<?php

$txtPrefijoRuta = "./";

include( "./recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

//$ruta = 'D:\modificacionesPorvenir\mz22AB';
//$ruta = 'D:\modificacionesPorvenir\mz6527marzo';
//listar($ruta);
//crearCarpetas();

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
                            // rename($directorio . '/' . $file . "/" . $one, $directorio . '/' . $file . "/" . $file . "(" . $int . ")." . $var[1]);
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

    //$sql = "select seqUnidadProyecto from t_pry_unidad_proyecto WHERE seqProyecto =221";
    $sql = "select * from t_pry_unidad_proyecto 
 left join t_pry_tecnico using(seqUnidadProyecto)
where seqProyecto = 224 and seqTecnicoUnidad is null";
    $objRes = $aptBd->execute($sql);
    $txtArchivo = "Archivo;Existe\n";
    while ($objRes->fields) {
        echo "<br>D:\modificacionesPorvenir\mz6527marzo\\" . $objRes->fields['seqUnidadProyecto'];
        mkdir("D:\modificacionesPorvenir\mz6527marzo\\" . $objRes->fields['seqUnidadProyecto'], 0777);

        $objRes->MoveNext();
    }

//    foreach ($array as $key => $value) {
//        
//        echo "<br>D:\imagenesPorvenir2\Manzana65\\".$value;
//        mkdir("D:\imagenesPorvenir2\Manzana65\\".$value, 0777);
//        
//    }
}
