<?php

$link = mysql_connect('localhost', 'sdht_usuario', 'Ochochar*1') or die('No se pudo conectar: ' . mysql_error());
mysql_select_db('sipive') or die('No se pudo seleccionar la base de datos');

// primero conectamos siempre a la base de datos mysql
$sql = "SELECT seqSeguimiento FROM t_seg_seguimiento";  // sentencia sql
$result = mysql_query($sql) or die('Consulta fallida: ' . mysql_error());
$numero = mysql_num_rows($result); // obtenemos el número de filas
echo 'El numero de registros de la tabla es: '.$numero.'';  // imprimos en pantalla el número generado
?>