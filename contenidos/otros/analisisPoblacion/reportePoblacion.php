<?php

$link = mysql_connect('localhost', 'sdht_usuario', 'Ochochar*1') or die('No se pudo conectar: ' . mysql_error());
mysql_select_db('sipive') or die('No se pudo seleccionar la base de datos');

$lineas = file('poblacion.txt');

header("Content-Type: application/vnd.ms-excel");
header("content-disposition: attachment;filename=poblacion.xls");
echo "<table>
    <tr>   
    <th>seqFormulario</th>
   <th>seqCiudadano</th>
 </tr>";

foreach ($lineas as $linea_num => $linea) {
    $datos = explode("\t", $linea);
    $clave = trim($datos[0]);
    $consulta = "select seqFormulario, seqCiudadano FROM t_frm_hogar where seqFormulario = '$clave'";
    $result = mysql_query($consulta) or die('Consulta fallida: ' . mysql_error());
    while ($hogar = mysql_fetch_array($result, MYSQL_ASSOC)) {
        echo "<tr>";
        foreach ($hogar as $col_value) {
            echo "<td>$col_value</td>";
        }
        echo "</tr>";
    }
}
echo "</table>";

// Liberar resultados
mysql_free_result($result);

// Cerrar la conexión
mysql_close($link);
?>