<?php

$link = mysql_connect('localhost', 'sdht_usuario', 'Ochochar*1') or die('No se pudo conectar: ' . mysql_error());
mysql_select_db('sipive') or die('No se pudo seleccionar la base de datos');

$lineas = file('formularios.txt');

header("Content-Type: application/vnd.ms-excel");
header("content-disposition: attachment;filename=poblacion.xls");
echo "<table>
    <tr>   
    <th>seqFormulario</th>
   <th>docPostulantePrincipal</th>
   <th>Parentesco</th>
 </tr>";

foreach ($lineas as $linea_num => $linea) {
    $datos = explode("\t", $linea);
    $clave = trim($datos[0]);
    $consulta = "SELECT frm.seqFormulario, ciu.numDocumento, hog.seqParentesco
                    FROM (t_frm_hogar hog
                        LEFT JOIN t_frm_formulario frm
                           ON (hog.seqFormulario = frm.seqFormulario))
                       LEFT JOIN t_ciu_ciudadano ciu ON (hog.seqCiudadano = ciu.seqCiudadano)
                    WHERE (hog.seqParentesco = 1) AND frm.seqFormulario = '$clave'";
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