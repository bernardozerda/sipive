<?php

/*
  $directorio = opendir("./recursos/imagenes/desembolsos/"); //ruta actual
  while ($archivo = readdir($directorio)) { //obtenemos un archivo y luego otro sucesivamente
  if (is_dir($archivo)) {//verificamos si es o no un directorio
  echo "[" . $archivo . "] <br />"; //de ser un directorio lo envolvemos entre corchetes
  } else {
  $fecha = date("F d Y.", filemtime($archivo));
  echo $archivo . "<br />" . $fecha;
  }
  }
 */



header("content-type: text/xml");

//---Obtener variables pasadas por GET
$path = !isset($_GET['path']) ? './recursos/imagenes/desembolsos/' : $_GET['path'];
$files = !isset($_GET['files']) ? '\w{3,4}' : '(' . implode(')|(', explode('@', $_GET['files'])) . ')';
$order = !isset($_GET['order']) ? 'name' : $_GET['order'];

//---Arreglo donde se guardarán todos los archivos
$store = array();

//---Regular Expression
$reg = '/\w*+.+' . $files . '$/';

$sum = 0;

//---Si es un directorio
if (is_dir($path)) {

    //---Abrir el directorio
    if ($gd = opendir($path)) {

        //---Recorrer todos los archivos del directorio
        while (($archivo = readdir($gd)) !== false) {

            //---Si se cumple la expresión regular
            if (preg_match($reg, $archivo) && !is_dir($archivo)) {

                //---Guardar todos los datos en el arreglo tomando como index la fecha
                $date = filemtime((strpos($path, '/')) ? $path . $archivo : $path . '/' . $archivo);

                $store[$date . '_' . $sum] = $archivo;

                $sum++;
            }
        }
    }
}

//---Organizar el arreglo
if ($order == 'name') {

    natcasesort($store);
} else {

    ksort($store);
}

//---Crear el XML
$xml = new DomDocument('1.0', 'UTF-8');

//---Crear el nodo raiz
$root = $xml->createElement('folder');
$root = $xml->appendChild($root);

//---Ir creando los nodos
foreach ($store as $item => $value) {

    //---Crear los subnodos
    $subnode = $xml->createElement('file');
    $subnode = $root->appendChild($subnode);

    //---Insertar el texto del nombre en el nodo
    $text = $xml->createTextNode($value);
    $subnode->appendChild($text);
}

//---Output
echo $xml->saveXML();
?>