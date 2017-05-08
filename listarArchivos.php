<?php
header("Content-Type: application/vnd.ms-excel");
header("content-disposition: attachment;filename=imagenes.xls");
$directorio = opendir("recursos/imagenes/desembolsos"); //ruta actual
echo "<table>";
while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
{
    if (is_dir($archivo))//verificamos si es o no un directorio
    {
        echo "<tr><td>[".$archivo . "]</td></tr>"; //de ser un directorio lo envolvemos entre corchetes
    } else {
        echo "<tr><td>" . $archivo . "</td></tr>";
    }
}
echo "</table>";
?>