<?php

$link = mysql_connect('localhost', 'sdht_usuario', 'Ochochar*1') or die('No se pudo conectar: ' . mysql_error());
mysql_select_db('sipive') or die('No se pudo seleccionar la base de datos');
/* $link = mysql_connect('localhost', 'root', 'root') or die('No se pudo conectar: ' . mysql_error());
  mysql_select_db('sipive_feb10') or die('No se pudo seleccionar la base de datos'); */

header("Content-Type: application/vnd.ms-excel");
header("content-disposition: attachment;filename=analisisUnidadesAsignadas.xls");
// Dibuja los titulos de la tabla
echo "<table><tr>
		<th>Proyecto</th>
		<th>Conjunto Residencial</th>
		<th>seqUnidadProyecto</th>
		<th>Unidad Proyecto</th>
		<th>Nombre Unidad Referencia</th>
		<th>Nombre Unidad Auxiliar</th>
		<th>Valor Aprobado</th>
		<th>Valor Complementario</th>
		<th>Valor Actual</th>
		<th>Viabilidad T&eacute;cnica</th>
		<th>seqFormulario</th>	
		<th>Documento</th>
		<th>Nombre</th>
		<th>txtFormulario</th>
		<th>Estado del Proceso</th>
		<th>Matr&iacute;cula Inmobiliaria</th>
		<th>Legalizado</th>
		<th>Fecha Legalizado</th>
		<th>Activo</th>
	</tr>";

$sql = "SELECT txtExistencia, seqUnidadProyecto FROM T_PRY_TECNICO";
$reg = mysql_query($sql);
$arrTxtExistencia = Array();
while ($rows = mysql_fetch_array($reg)) {
    $arrTxtExistencia[$rows['seqUnidadProyecto']] = $rows['seqUnidadProyecto']; 
    
}
//var_dump($arrTxtExistencia); 

//exit();
// Recorrer las unidades residenciales de esquema individual
$query_unidades = "SELECT
                    und.txtNombreUnidad, 
                    und.seqFormulario,
                    und.seqProyecto,
                    und.seqUnidadProyecto,
                    und.txtNombreUnidadReal,
                    und.txtNombreUnidadAux,
                    und.valSDVEAprobado,
                    und.valSDVEComplementario,
                    und.valSDVEActual,
                    und.txtMatriculaInmobiliaria,
                    und.bolLegalizado,
                    und.fchLegalizado,
                    und.bolActivo
            FROM T_PRY_UNIDAD_PROYECTO und 
            LEFT JOIN T_PRY_PROYECTO pry ON (und.seqProyecto = pry.seqProyecto)                                        
            WHERE pry.seqTipoEsquema in (1,2)";
$execute_unidades = mysql_query($query_unidades);

while ($row_unidades = mysql_fetch_array($execute_unidades)) {
    $tbl_txtExistencia = '';
    $key = "";
    $tbl_nombreUnidad = $row_unidades['txtNombreUnidad'];
    $tbl_formulario = $row_unidades['seqFormulario'];
    $tbl_seqProyecto = $row_unidades['seqProyecto'];
    $tbl_seqUnidadProyecto = $row_unidades['seqUnidadProyecto'];
    $tbl_txtNombreUnidadReal = $row_unidades['txtNombreUnidadReal'];
    $tbl_txtNombreUnidadAux = $row_unidades['txtNombreUnidadAux'];
    $tbl_valSDVEAprobado = $row_unidades['valSDVEAprobado'];
    $tbl_valSDVEComplementario = $row_unidades['valSDVEComplementario'];
    $tbl_valSDVEActual = $row_unidades['valSDVEActual'];
    $tbl_txtMatriculaInmobiliaria = $row_unidades['txtMatriculaInmobiliaria'];
    $tbl_bolLegalizado = $row_unidades['bolLegalizado'];
    $tbl_fchLegalizado = $row_unidades['fchLegalizado'];
    $tbl_bolActivo = $row_unidades['bolActivo'];

    $key = array_search($tbl_seqUnidadProyecto, ($arrTxtExistencia));
    if($key != "" ){
        $tbl_txtExistencia = "SI";
    }

    

    // Si la unidad está asignada a algún proyecto recibe los datos del tomador de la unidad.
    if ($tbl_formulario > 1) {
        $query_detalle = "SELECT frm.seqFormulario, 
                                frm.txtFormulario,
                                pry.txtNombreProyecto AS 'proyecto', 
                                prh.txtNombreProyecto AS 'proyectoHijo',
                                UPPER(CONCAT(ciu.txtNombre1,' ',ciu.txtNombre2,' ',ciu.txtApellido1,' ',ciu.txtApellido2)) AS 'nombrePpal',
                                ciu.numDocumento AS 'documentoPpal',
                                CONCAT(eta.txtEtapa,' - ',epr.txtEstadoProceso) AS 'estadoProceso'
                FROM T_FRM_FORMULARIO frm 
                LEFT JOIN T_PRY_PROYECTO pry ON (frm.seqProyecto = pry.seqProyecto)
                LEFT JOIN T_PRY_PROYECTO prh ON (frm.seqProyectoHijo = prh.seqProyecto)
                LEFT JOIN T_FRM_HOGAR hog ON (frm.seqFormulario = hog.seqFormulario)
                LEFT JOIN T_CIU_CIUDADANO ciu ON (hog.seqCiudadano = ciu.seqCiudadano)
                LEFT JOIN T_FRM_ESTADO_PROCESO epr ON (frm.seqEstadoProceso = epr.seqEstadoProceso)
                LEFT JOIN T_FRM_ETAPA eta ON (epr.seqEtapa = eta.seqEtapa)
                WHERE hog.seqParentesco = 1
                AND frm.seqFormulario = $tbl_formulario";
        $execute_detalle = mysql_query($query_detalle);
        while ($row_detalle = mysql_fetch_array($execute_detalle)) {
            $tbl_nombrePpal = $row_detalle['nombrePpal'];
            $tbl_estadoProceso = $row_detalle['estadoProceso'];
            $tbl_txtFormulario = $row_detalle['txtFormulario'];
            $tbl_documentoPpal = $row_detalle['documentoPpal'];
            $tbl_proyecto = $row_detalle['proyecto'];
            $tbl_proyectoHijo = $row_detalle['proyectoHijo'];
        }
    } else { // Si la unidad está libre muestra los datos del proyecto
        //desde
        $query_proyecto = "SELECT p.txtNombreProyecto AS 'padre', 
                                    h.txtNombreProyecto AS 'hijo'
                                    FROM	T_PRY_PROYECTO p 
                                    LEFT JOIN T_PRY_PROYECTO h ON (p.seqProyectoPadre = h.seqProyecto) 
                                    WHERE	p.seqProyecto = $tbl_seqProyecto";
        $execute_proyecto = mysql_query($query_proyecto);
        $row_proyecto = mysql_fetch_array($execute_proyecto);

        if ($row_proyecto['hijo'] != "") {
            $tbl_proyecto = $row_proyecto['hijo'];
            $tbl_proyectoHijo = $row_proyecto['padre'];
        } else {
            $tbl_proyecto = $row_proyecto['padre'];
            $tbl_proyectoHijo = "";
        }
        //hasta
        $tbl_nombrePpal = '';
        $tbl_estadoProceso = '';
        $tbl_txtFormulario = '';
        $tbl_documentoPpal = '';
    }
    echo "<tr>";
    echo "<td>$tbl_proyecto</td>";
    echo "<td>$tbl_proyectoHijo</td>";
    echo "<td>$tbl_seqUnidadProyecto</td>";
    echo "<td>$tbl_nombreUnidad</td>";
    echo "<td>$tbl_txtNombreUnidadReal</td>";
    echo "<td>$tbl_txtNombreUnidadAux</td>";
    echo "<td>$tbl_valSDVEAprobado</td>";
    echo "<td>$tbl_valSDVEComplementario</td>";
    echo "<td>$tbl_valSDVEActual</td>";
    echo "<td>$tbl_txtExistencia</td>";
    echo "<td>$tbl_formulario</td>";
    echo "<td>$tbl_documentoPpal</td>";
    echo "<td>$tbl_nombrePpal</td>";
    echo "<td>$tbl_txtFormulario</td>";
    echo "<td>$tbl_estadoProceso</td>";
    echo "<td>$tbl_txtMatriculaInmobiliaria</td>";
    echo "<td>$tbl_bolLegalizado</td>";
    echo "<td>$tbl_fchLegalizado</td>";
    echo "<td>$tbl_bolActivo</td>";
    echo "</tr>";
}

echo "</table>";

// Liberar resultados 
//mysql_free_result($result);
// Cerrar la conexión
mysql_close($link);
?>