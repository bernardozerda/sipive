<?php

$link = mysql_connect('localhost', 'sdht_usuario', 'Ochochar*1') or die('No se pudo conectar: ' . mysql_error());
mysql_select_db('sipive') or die('No se pudo seleccionar la base de datos');

$lineas = file('Cedulas2.txt');

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
    $consulta = "SELECT t_ciu_ciudadano.numDocumento,
       t_ciu_ciudadano.txtNombre1,
       t_ciu_ciudadano.txtNombre2,
       t_ciu_ciudadano.txtApellido1,
       t_ciu_ciudadano.txtApellido2,
       t_seg_gestion.txtGestion,
       t_seg_grupo_gestion.txtGrupoGestion,
       t_seg_seguimiento.seqSeguimiento,
       t_seg_seguimiento.seqFormulario,
       t_seg_seguimiento.fchMovimiento,
       t_seg_seguimiento.seqUsuario,
       t_seg_seguimiento.txtComentario,
       t_cor_usuario.seqUsuario,
       t_seg_seguimiento.txtCambios,
       t_seg_seguimiento.numDocumento,
       t_seg_seguimiento.txtNombre,
       t_seg_seguimiento.seqGestion,
       t_seg_seguimiento.bolMostrar,
       t_cor_usuario.txtNombre,
       t_cor_usuario.txtApellido
  FROM    (   (   (   sipive.t_seg_seguimiento t_seg_seguimiento
                   INNER JOIN
                      sipive.t_ciu_ciudadano t_ciu_ciudadano
                   ON (t_seg_seguimiento.numDocumento =
                          t_ciu_ciudadano.numDocumento))
               INNER JOIN
                  sipive.t_seg_gestion t_seg_gestion
               ON (t_seg_seguimiento.seqGestion = t_seg_gestion.seqGestion))
           INNER JOIN
              sipive.t_seg_grupo_gestion t_seg_grupo_gestion
           ON (t_seg_gestion.seqGrupoGestion =
                  t_seg_grupo_gestion.seqGrupoGestion))
       INNER JOIN
          sipive.t_cor_usuario t_cor_usuario
       ON (t_cor_usuario.seqUsuario = t_seg_seguimiento.seqUsuario)
 WHERE (`t_seg_seguimiento`.`numDocumento` = '$clave')";
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