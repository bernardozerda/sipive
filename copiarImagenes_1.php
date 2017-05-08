<?php

$memoria_inicial = memory_get_usage(true);

ini_set("max_execution_time", "86400");
ini_set("memory_limit", "900M");

// Esta variable de usa para ubicar los archivos a incluir
$txtPrefijoRuta = "./";

include( "./recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

//header("Content-disposition: attachment; filename=Imagenes_" . time() . ".csv");
//header("Content-Type: application/force-download");
//header("Content-Type: text/plain; charset=ISO-8859-1");
//header("Content-Transfer-Encoding: base64");
//header("Pragma: no-cache");
//header("Expires: 1");

$sql = " SELECT * FROM `t_pry_adjuntos_tecnicos` left join t_pry_tecnico using(seqTecnicoUnidad) left join t_pry_unidad_proyecto using(seqUnidadProyecto) left join t_pry_proyecto using(seqProyecto)";
$objRes = $aptBd->execute($sql);
$txtArchivo1 = "Archivo;Existe\n";
$origen = "./recursos/imagenes/desembolsos";
//$destino = './recursos/imagenes/flamencos';
$contSi = 0;
$contNO = 0;
while ($objRes->fields) {
    $txtArchivo = $objRes->fields['txtNombreArchivo'] . ";";
    if (file_exists("./recursos/imagenes/desembolsos/" . $objRes->fields['txtNombreArchivo'])) {
        echo $contSi." - Si - ".$objRes->fields['seqUnidadProyecto']." - ".$objRes->fields['txtNombreProyecto']." - ".$txtArchivo . "<br>";
        $contSi++;
    } else {
        
        echo $contNO." - NO - ".$objRes->fields['seqUnidadProyecto']." - ".$objRes->fields['txtNombreProyecto']." - ".$txtArchivo . "<br>";
        $contNO++;
    }

    $objRes->MoveNext();
}
echo  "<br><p>el total de fotos son:</p>".$contNO+$contSi ."<p> Existe ".$contSi."</p> <p>No existe ".$contNO."</p>";



$memoria_final = memory_get_usage(true);

//    echo number_format( $memoria_inicial ) . " - " . 
//         number_format( $memoria_final )   . " = " . 
//         number_format( ( $memoria_final - $memoria_inicial ) ) . "<br>";
?>

