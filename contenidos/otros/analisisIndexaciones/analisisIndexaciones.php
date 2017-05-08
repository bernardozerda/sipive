<?php
$link = mysql_connect('localhost', 'sdht_usuario', 'Ochochar*1') or die('No se pudo conectar: ' . mysql_error());
mysql_select_db('sipive') or die('No se pudo seleccionar la base de datos');

header("Content-Type: application/vnd.ms-excel");
header("content-disposition: attachment;filename=analisisIndexaciones.xls");

// Imprime los encabezados de la tabla
echo "<table>
		<tr>
			<th>No. Acto</th>
			<th>Fecha Acto</th>
			<th>Nombre Proyecto</th>
			<th>seqUnidad</th>
			<th>Nombre Unidad</th>
			<th>Valor Aprobado</th>
			<th>Valor Indexado</th>
			<th>Valor Actual</th>
			<th>seqFormulario</th>
			<th>Documento</th>
			<th>Nombre</th>
		</tr>";

// Consulta todos los hogares que tienen indexacion
$query = "SELECT T_PRY_AAD_UNIDAD_ACTO.seqUnidadActo,
				numActo,
				fchActo,
				seqProyecto,
				T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadProyecto,
				txtNombreUnidad,
				valIndexado,
				valSDVEAprobado,
				valSDVEActual,
				seqFormulario
		FROM T_PRY_AAD_UNIDAD_ACTO
		LEFT JOIN T_PRY_AAD_UNIDADES_VINCULADAS ON (T_PRY_AAD_UNIDAD_ACTO.seqUnidadActo = T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadActo)
		LEFT JOIN T_PRY_UNIDAD_PROYECTO ON (T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadProyecto = T_PRY_UNIDAD_PROYECTO.seqUnidadProyecto)
		ORDER BY fchActo, numActo, seqProyecto, txtNombreUnidad";
$exeQuery = mysql_query($query);

while ($rowQuery = mysql_fetch_array($exeQuery)){
	$xls_numActo			= $rowQuery['numActo'];
	$xls_fchActo			= $rowQuery['fchActo'];
	$xls_seqProyecto		= $rowQuery['seqProyecto'];
	$xls_seqUnidadProyecto	= $rowQuery['seqUnidadProyecto'];
	$xls_txtNombreUnidad	= $rowQuery['txtNombreUnidad'];
	$xls_valIndexado		= $rowQuery['valIndexado'];
	$xls_valSDVEAprobado	= $rowQuery['valSDVEAprobado'];
	$xls_valSDVEActual		= $rowQuery['valSDVEActual'];
	$xls_seqFormulario		= $rowQuery['seqFormulario'];
	
	// Consulta el proyecto
	$sqlProyecto = "SELECT seqProyecto, txtNombreProyecto
					FROM T_PRY_PROYECTO
					WHERE seqProyecto = $xls_seqProyecto";
	$exeProyecto = mysql_query($sqlProyecto);
	$rowProyecto = mysql_fetch_array($exeProyecto);
	$xls_nombreProyecto 	= $rowProyecto['txtNombreProyecto'];
	
	// Consulta el ciudadano que está asignado a la unidad
	$xls_numDocumento = "";
	$xls_nombrePpal = "";
	if($xls_seqFormulario == "" || $xls_seqFormulario == 0){
		$a = "nada";
	}else{
		$sqlCiudadano = "SELECT
							numDocumento,
							UPPER(CONCAT(txtNombre1,' ',txtNombre2,' ',txtApellido1,' ',txtApellido2)) AS 'nombrePpal'
						FROM T_FRM_HOGAR
						LEFT JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano)
						WHERE seqFormulario = $xls_seqFormulario
						AND seqParentesco = 1";
		$exeCiudadano = mysql_query($sqlCiudadano);
		$rowCiudadano = mysql_fetch_array($exeCiudadano);
		$xls_numDocumento 		= $rowCiudadano['numDocumento'];
		$xls_nombrePpal 		= $rowCiudadano['nombrePpal'];
	}

	echo "<tr>";
	echo "<td>$xls_numActo</td>";
	echo "<td>$xls_fchActo</td>";
	echo "<td>$xls_nombreProyecto</td>";
	echo "<td>$xls_seqUnidadProyecto</td>";
	echo "<td>$xls_txtNombreUnidad</td>";
	echo "<td>$xls_valSDVEAprobado</td>";
	echo "<td>$xls_valIndexado</td>";
	echo "<td>$xls_valSDVEActual</td>";
	echo "<td>$xls_seqFormulario</td>";
	echo "<td>$xls_numDocumento</td>";
	echo "<td>$xls_nombrePpal</td>";
	echo "</tr>";	
}

// Cerrar la conexión
mysql_close($link);
?>