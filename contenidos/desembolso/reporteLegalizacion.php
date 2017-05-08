<?php
$link = mysql_connect('localhost', 'sdht_usuario', 'Ochochar*1') or die('No se pudo conectar: ' . mysql_error());
//$link = mysql_connect('localhost', 'root', 'root') or die('No se pudo conectar: ' . mysql_error());
mysql_select_db('sipive') or die('No se pudo seleccionar la base de datos');

$nombreArchivo = "ReporteLegalizacion_" . date( "Ymd_His" ) . ".xls";
header("Content-Type: application/vnd.ms-excel");
header("content-disposition: attachment;filename=$nombreArchivo");

$fechaIni = $_POST['fchInicio'];
$fechaFin = $_POST['fchFin'];

if( $fechaIni ){
	$arrCondiciones[] = "und.fchLegalizado >= '$fechaIni'";
}
if( $fechaFin ){
	$arrCondiciones[] = "und.fchLegalizado <= '$fechaFin'";
}
$arrCondiciones[] = "und.bolLegalizado = 1 ";
$txtCondicion = implode( " AND ", $arrCondiciones );

echo "<table border=1>";
echo "<tr>";
echo "<th>PROYECTO</th>";
echo "<th>CONJUNTO RESIDENCIAL</th>";
echo "<th>FECHA LEGALIZADO</th>";
echo "<th>DIRECCI&Oacute;N</th>";
echo "<th>MATRICULA INMOBILIARIA</th>";
echo "<th>FORMULARIO</th>";
echo "<th>DOCUMENTO</th>";
echo "<th>NOMBRE POSTULANTE PRINCIPAL</th>";
echo "<th>VALOR SUBSIDIO</th>";
echo "</tr>";
$sqlProyectos = "SELECT DISTINCT(CONCAT(frm.seqProyecto,' ', frm.seqProyectoHijo)) AS llaveProyecto
					FROM T_FRM_FORMULARIO frm
					INNER JOIN T_PRY_PROYECTO pry ON frm.seqProyecto = pry.seqProyecto
					LEFT JOIN T_PRY_PROYECTO prh ON frm.seqProyectoHijo = prh.seqProyecto
					INNER JOIN T_PRY_UNIDAD_PROYECTO und ON frm.seqUnidadProyecto = und.seqUnidadProyecto
					INNER JOIN T_DES_ESCRITURACION esc ON frm.seqFormulario = esc.seqFormulario
					WHERE $txtCondicion
					ORDER BY pry.txtNombreProyecto, prh.txtNombreProyecto";
					
$resultProyectos = mysql_query($sqlProyectos) or die('Consulta fallida: ' . mysql_error());

while ($rowProyectos = mysql_fetch_array($resultProyectos)){

	$idProyecto = 0;
	$idConjunto = 0;
	$nombreProyecto = '';
	$nombreConjunto = '';
	//SEPARARA LOS VALORES DE LA LLAVE PROYECTO
	$arreglo = explode(" ", $rowProyectos['llaveProyecto']);
	$idProyecto = $arreglo[0]; // seqmento proyecto
	$idConjunto = $arreglo[1]; // segmento conjunto

	// Consulta los nombres de los proyectos
	$sqlNombreProyecto = "SELECT txtNombreProyecto FROM T_PRY_PROYECTO WHERE seqProyecto = $idProyecto";
	$resultNombreProyecto = mysql_query($sqlNombreProyecto) or die('Consulta fallida: ' . mysql_error());
	$rowNombreProyecto = mysql_fetch_array($resultNombreProyecto);
	$nombreProyecto = $rowNombreProyecto['txtNombreProyecto'];

	// Si existe el idConjunto se consulta del nombre del conjunto
	if ($idConjunto > 1) {
		$sqlNombreConjunto = "SELECT txtNombreProyecto FROM T_PRY_PROYECTO WHERE seqProyecto = $idConjunto";
		$resultNombreConjunto = mysql_query($sqlNombreConjunto) or die('Consulta fallida: ' . mysql_error());
		$rowNombreConjunto = mysql_fetch_array($resultNombreConjunto);
		$nombreConjunto = $rowNombreConjunto['txtNombreProyecto'];
	}

	echo "<tr><td><b>$nombreProyecto</b></td><td><b>$nombreConjunto</b></td></tr>";

	$sqlHogares = "SELECT
					' ' AS 'Proyecto',
					' ' AS 'Conjunto Residencial',
					und.fchLegalizado AS 'Fecha Legalizado',
					esc.txtDireccionInmueble AS 'Direccion',
					esc.txtMatriculaInmobiliaria AS 'Matricula Inmobiliaria',
					frm.seqFormulario,
					ciu.numDocumento AS 'Documento',
					CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 ) AS 'Nombre Ppal',
					und.valSDVEActual AS 'valor Subsidio'
				FROM T_FRM_FORMULARIO frm
				INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
				INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
				LEFT JOIN T_PRY_PROYECTO pry ON frm.seqProyecto = pry.seqProyecto
				LEFT JOIN T_PRY_PROYECTO prh ON frm.seqProyectoHijo = prh.seqProyecto
				LEFT JOIN T_PRY_UNIDAD_PROYECTO und ON frm.seqUnidadProyecto = und.seqUnidadProyecto
				LEFT JOIN T_DES_ESCRITURACION esc ON frm.seqFormulario = esc.seqFormulario
				WHERE $txtCondicion
				AND pry.seqProyecto = $idProyecto ";
				if ($idConjunto > 1){
					$sqlHogares .= " AND prh.seqProyecto = $idConjunto ";
				}
	$sqlHogares .= "AND hog.seqParentesco = 1 ORDER BY pry.txtNombreProyecto, prh.txtNombreProyecto";

	$resultHogares = mysql_query($sqlHogares) or die('Consulta fallida: ' . mysql_error());

	while ($rowHogares = mysql_fetch_array($resultHogares, MYSQL_ASSOC)) {
		echo "<tr>";
		foreach ($rowHogares as $col_value) {
			echo "<td>$col_value</td>";
		}
		echo "</tr>";
	}
}
echo "</table>";

// Liberar resultados
mysql_free_result($resultProyectos);
mysql_free_result($resultHogares);

// Cerrar la conexión
mysql_close($link);
?>