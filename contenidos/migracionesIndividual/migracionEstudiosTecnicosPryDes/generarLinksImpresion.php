<?php

ob_start();
date_default_timezone_set('America/Bogota');

function generarLinksImpresion($arraydocs) {
    include '../conecta.php';
    //$db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sdht_subsidios', 'localhost');
    //$db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sdth_subsidiosentrega', 'localhost');
//    header("Content-Description: File Transfer");
//    header("Content-Type: application/force-download");
//    header("Content-type: application/vnd.ms-excel; charset=UTF-8");
//    header("Pragma: public");
//    header("Expires: 0");
//    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//    header("Cache-Control: private", false);
//    header("Content-Disposition: attachment; filename=\"prueba.xls\";");
//    header("Content-Transfer-Encoding: binary");


    $consulta_pre = "SELECT ciu.numDocumento AS numDocumento,
       des.seqDesembolso AS seqDesembolso,
       destec.seqTecnico AS seqTecnico,
       frm.txtFormulario AS txtFormulario,
       frm.seqFormulario AS seqFormulario,
       und.seqUnidadProyecto AS unidadseqUnidadProyecto,
       hog.seqParentesco AS seqParentesco,
       prytec.seqUnidadProyecto seqUnidadProyecto,
       und.txtNombreUnidad txtNombreUnidad,
       pry.txtNombreProyecto AS txtNombreProyecto
  FROM ((((((sdht_subsidios.t_pry_unidad_proyecto und
             INNER JOIN sdht_subsidios.t_frm_formulario frm
                ON (und.seqFormulario = frm.seqFormulario))
            INNER JOIN sdht_subsidios.t_frm_hogar hog
               ON (hog.seqFormulario = frm.seqFormulario))
           INNER JOIN sdht_subsidios.t_ciu_ciudadano ciu
              ON (hog.seqCiudadano = ciu.seqCiudadano))
          LEFT OUTER JOIN sdht_subsidios.t_des_desembolso des
             ON (des.seqFormulario = frm.seqFormulario))
         LEFT OUTER JOIN sdht_subsidios.t_des_tecnico destec
            ON (destec.seqDesembolso = des.seqDesembolso))
        INNER JOIN sdht_subsidios.t_pry_proyecto pry
           ON (und.seqProyecto = pry.seqProyecto))
       INNER JOIN sdht_subsidios.t_pry_tecnico prytec
          ON (prytec.seqUnidadProyecto = und.seqUnidadProyecto)
 WHERE (ciu.numDocumento IN ($arraydocs));";
    ?>
    <table>    
        <tr>
            <th>ITEM</th>     
            <th>CC Ppal</th>    
            <th>Proyecto</th>    
            <th>Unidad</th>    
            <th>Link_Impresion</th>
        <tr>    
            <?php

            $resultados = $db->get_results($consulta_pre);
            $item = 0;

            foreach ($resultados as $resultado) {
                $item++;
                echo
                '<tr>
            <td>' . $item . '</td>
            <td>' . $resultado->numDocumento . '</td>
            <td>' . $resultado->txtNombreProyecto . '</td>
            <td>' . $resultado->txtNombreUnidad . '</td>
              <td> <a href="'.$_SERVER['HTTP_HOST'].'/sipive/contenidos/desembolso/formatoRevisionTecnica.php?seqFormulario=' . $resultado->seqFormulario . '">http://'.$_SERVER['HTTP_HOST'].'/sipive/contenidos/desembolso/formatoRevisionTecnica.php?seqFormulario=' . $resultado->seqFormulario . '</a> </td>
        <tr>';
            }
        }

        ob_end_flush();
        ?>