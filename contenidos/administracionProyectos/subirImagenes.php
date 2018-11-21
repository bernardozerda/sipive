<?php

if (isset($_FILES["archivo"])) {
    $retorna = "";

    $idProyecto = $_REQUEST['idProyecto'];
    $destino = '../../recursos/proyectos/proyecto-' . $idProyecto . '/imagenes/';
    $url = str_replace('index.php', '', $_SERVER['HTTP_REFERER']);
    $tmax = 10000;

    if (!file_exists($destino)) {
        mkdir($destino, 0777, true);
    }
    chmod($destino, 0777);
    $dir = @dir($destino);
    $arraImagenes = Array();
    if ($dir) {
        while (($archivo = $dir->read()) !== false) {
            if ($archivo[0] != ".") {
                $arraImagenes[] = 'proyecto-' . $idProyecto . '/imagenes/' . $archivo;
                continue;
            }
        }
    }
    $countNombre = count($arraImagenes) + 1;
    foreach ($arraImagenes as $key => $value) {
        $nombreImg = explode("/", $value)[2];
        $retorna .=' <div class = "col-md-3">
        <label ><h5><b>' . $nombreImg . '</b></h5></label><br>
            <img src = "' . $url . 'recursos/proyectos/' . $value . '" class = "img-circle" alt = "Card image cap" height = "100" width = "100" />
            </div>';
    }


    $target_path = $destino;
    foreach ($_FILES['archivo']['tmp_name'] as $key => $value) {
        $target_path = $destino;
        if (is_uploaded_file($_FILES['archivo']['tmp_name'][$key])) {
            $origen = $_FILES['archivo']['tmp_name'][$key];
            $tamano = $_FILES['archivo']['size'][$key];
            $tipo = explode("/", $_FILES['archivo']['type'][$key])[1];
            // echo "<p>" . $tipo . "</p>";
            if ($tipo == "jpg" || $tipo == "JPG" || $tipo == "jpeg" || $tipo == "JPEG") {
                if ($tamano < $tmax) {
                    $target_path = $target_path . basename($_FILES['archivo']['name'][$key]);
                    $nameIni = basename($_FILES['archivo']['name'][$key]);

                    if (move_uploaded_file($_FILES['archivo']['tmp_name'][$key], $target_path)) {
                        rename($destino . "" . $nameIni, $destino . "" . $idProyecto . "_" . $countNombre . "." . $tipo);
                        $retorna .='<div class="col-md-3">
                                    <label ><h5><b>' . $idProyecto . '_' . $countNombre . "." . $tipo . ' </b></h5></label><br>
                                    <img src="' . $url . 'recursos/proyectos/proyecto-' . $idProyecto . '/imagenes/' . $idProyecto . '_' . $countNombre . '.' . $tipo . '" class="img-circle" alt="Card image cap" height="100" width="100" />        
                                    </div>';
                        $countNombre++;
                    } else {
                        $retorna .='<div class="col-md-3"><label>error al subir la imagen ' . basename($_FILES['archivo']['name'][$key]) . ' por favor intentelo nuevamente</label><br>'
                                . '<img src="' . $url . 'recursos/imagenes/errorImg.png" class="img-circle" alt="Card image cap" height="100" width="100" />'
                                . '</div>';
                    }
                } else {
                    $retorna .='<div class="col-md-3"><label>La imagen ' . basename($_FILES['archivo']['name'][$key]) . ' No cumple con el limite de tamaño estrablecido</label><br>'
                            . '<img src="' . $url . 'recursos/imagenes/errorImg.png" class="img-circle" alt="Card image cap" height="80" width="80" />'
                            . '</div>';
                }
            } else {
                $retorna .='<div class="col-md-3"><label>La extension  .' . $tipo . ' de la imagen ' . basename($_FILES['archivo']['name'][$key]) . '. No cumple con el formato .jpg</label><br>'
                        . '<img src="' . $url . 'recursos/imagenes/errorImg.png" class="img-circle" alt="Card image cap" height="100" width="100" />'
                        . '</div>';
            }
        }
    }
    echo $retorna;
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

