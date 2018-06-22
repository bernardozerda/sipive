<?php

$retorna = "";
$rutaDestino = "";
$rutaOrgigen = "";
if ($_REQUEST['nombre'] != "") {
    $idProyecto = $_REQUEST['idProyecto'];
    $url = str_replace('index.php', '', $_SERVER['HTTP_REFERER']);
    $rutaOrgigen = "../../recursos/proyectos/" . $_REQUEST['ruta'];
    if ($_REQUEST['tipo'] == 1) {

        $ruta = str_replace('imagenes', 'inactivas', $_REQUEST['ruta']);
        $rutaDestino = "../../recursos/proyectos/" . $ruta;
        $rutaDestino = str_replace("/" . $_REQUEST['nombre'], '', $rutaDestino);

        if (!file_exists($rutaDestino)) {
            mkdir($rutaDestino, 0777, true);
        }
        $rutaDestino = $rutaDestino . "/" . $_REQUEST['nombre'];
    } else {
        $rutaOrgigen = "../../recursos/proyectos/" . $_REQUEST['ruta'];
        $ruta = str_replace('inactivas', 'imagenes', $_REQUEST['ruta']);
        $rutaDestino = "../../recursos/proyectos/" . $ruta;
        $rutaDestino = str_replace("/" . $_REQUEST['nombre'], '', $rutaDestino);
        $rutaDestino = $rutaDestino . "/" . $_REQUEST['nombre'];
    }
    // move_uploaded_file($rutaOrgigen, $rutaDestino);
    rename($rutaOrgigen, $rutaDestino);


    $destino = '../../recursos/proyectos/proyecto-' . $idProyecto . '/imagenes/';
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
    foreach ($arraImagenes as $key => $value) {
        $nombreImg = explode("/", $value)[2];
        $retorna .= "<div class ='col-md-3'><label ><h5><b>" . $nombreImg . "</b><img src=\"recursos/imagenes/deleted.png\"  onclick=\"moverImagen('proyecto-$idProyecto/imagenes/$nombreImg',1,'$nombreImg',$idProyecto);\"/></h5></label><br>";
        $retorna .= "<img src=\"" . $url . "recursos/proyectos/$value\" class=\"img-circle\" alt=\"Card image cap\" height=\"100\" width=\"100\" /></div>";
    }

    $retorna .="***";
    $destinoInac = '../../recursos/proyectos/proyecto-' . $idProyecto . '/inactivas/';
    $dirInac = @dir($destinoInac);
    $arraImagenesInac = Array();
    if ($dir) {
        while (($archivoInac = $dirInac->read()) !== false) {
            if ($archivoInac[0] != ".") {
                $arraImagenesInac[] = 'proyecto-' . $idProyecto . '/inactivas/' . $archivoInac;
                continue;
            }
        }
    }
    //var_dump($arraImagenesInac);
    foreach ($arraImagenesInac as $keyInac => $valueInac) {
        $nombreImgInac = explode("/", $valueInac)[2];
        $retorna .= "<div class ='col-md-3'><label ><h5><b>" . $nombreImgInac . "</b><img src=\"recursos/imagenes/return.png\"  onclick=\"moverImagen('proyecto-$idProyecto/inactivas/$nombreImgInac',2,'$nombreImgInac',$idProyecto);\"/></h5></label><br>";
        $retorna .= "<img src=\"" . $url . "recursos/proyectos/$valueInac\" class=\"img-circle\" alt=\"Card image cap\" height=\"100\" width=\"100\" /></div>";
    }
}

echo $retorna;