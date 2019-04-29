<?php

$memoria_inicial = memory_get_usage(true);

ini_set("max_execution_time", "86400");
ini_set("memory_limit", "-1");

// Esta variable de usa para ubicar los archivos a incluir
$txtPrefijoRuta = "./";

include( "./recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
$sql = "
        SELECT txtNombreArchivo
        FROM T_DES_ADJUNTOS_TECNICOS
        where txtNombreArchivo != '' 
        group by txtNombreArchivo
    ";
$objRes = $aptBd->execute($sql);
$txtArchivo = "Archivo;Existe\n";
$arrayImagenes = Array();
$arrayImagenesNO = Array();
$contador = 0;
$contadorNO = 0;
while ($objRes->fields) {
    $txtArchivo.= $objRes->fields['txtNombreArchivo'] . ";";
    if (file_exists("./recursos/imagenes/desembolsos/" . $objRes->fields['txtNombreArchivo'])) {
        $contador++;
        $txtArchivo.= "si<br>";
        $arrayImagenes[] = $objRes->fields['txtNombreArchivo'];
    } else {
        $arrayImagenesNO[] = $objRes->fields['txtNombreArchivo'];
        $txtArchivo.= "no<br>";
        $contadorNO++;
    }
    $objRes->MoveNext();
}

$sql1 = "
        SELECT txtNombreArchivo
        FROM t_cem_adjuntos_tecnicos 
        where txtNombreArchivo != '' 
        group by txtNombreArchivo
    ";
$objRes1 = $aptBd->execute($sql1);
while ($objRes1->fields) {
    $txtArchivo.= $objRes1->fields['txtNombreArchivo'] . ";";
    if (file_exists("./recursos/imagenes/desembolsos/" . $objRes1->fields['txtNombreArchivo'])) {
        $contador++;
        $txtArchivo.= "si<br>";
        $arrayImagenes[] = $objRes1->fields['txtNombreArchivo'];
    } else {
        $arrayImagenesNO[] = $objRes1->fields['txtNombreArchivo'];
        $txtArchivo.= "no<br>";
        $contadorNO++;
    }
    $objRes1->MoveNext();
}


$sql2 = "
        SELECT txtNombreArchivo
        FROM t_pry_adjuntos_tecnicos 
        where txtNombreArchivo != '' 
        group by txtNombreArchivo
    ";
$objRes2 = $aptBd->execute($sql2);
while ($objRes1->fields) {
    $txtArchivo.= $objRes1->fields['txtNombreArchivo'] . ";";
    if (file_exists("./recursos/imagenes/desembolsos/" . $objRes2->fields['txtNombreArchivo'])) {
        $contador++;
        $txtArchivo.= "si<br>";
        $arrayImagenes[] = $objRes2->fields['txtNombreArchivo'];
    } else {
        $arrayImagenesNO[] = $objRes2->fields['txtNombreArchivo'];
        $txtArchivo.= "no<br>";
        $contadorNO++;
    }
    $objRes2->MoveNext();
}


$res = array();
 $directorio = './recursos/imagenes/desembolsos/';
  // Agregamos la barra invertida al final en caso de que no exista
  if(substr($directorio, -1) != "/") $directorio .= "/";
 
  // Creamos un puntero al directorio y obtenemos el listado de archivos
  $dir = @dir($directorio) or die("getFileList: Error abriendo el directorio $directorio para leerlo");
  while(($archivo = $dir->read()) !== false) {
      // Obviamos los archivos ocultos
      if($archivo[0] == ".") continue;
      if(is_dir($directorio . $archivo)) {
          /*$res[] = array(
            "Nombre" => $directorio . $archivo . "/",
            "Tamaño" => 0,
            "Modificado" => filemtime($directorio . $archivo)
          );*/
          $res[] = $archivo;
      } else if (is_readable($directorio . $archivo)) {
          /*$res[] = array(
            "Nombre" => $directorio . $archivo,
            "Tamaño" => filesize($directorio . $archivo),
            "Modificado" => filemtime($directorio . $archivo)
          );*/
          $res[] = $archivo;
      }
  }
  $dir->close();
//  $resultado = array_diff($res, $arrayImagenes);
//pr($resultado);
//echo "<br>**". count($resultado);
pr($res);
echo "<br>**". count($res);
//echo "<br> SI" . $contador;
//pr($arrayImagenesNO);
//echo "<br> NO " . $contadorNO;
// echo $txtArchivo;
//    echo number_format( $memoria_inicial ) . " - " . 
//         number_format( $memoria_final )   . " = " . 
//         number_format( ( $memoria_final - $memoria_inicial ) ) . "<br>";
?>
