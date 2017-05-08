<html><body>
<form action="<? $PHP_SELF ?>" method="POST"><table border="0">
<tr><td><b>Documento</b></td><td><input type="text" name="documento" id="documento" size="10"><select name="tipodoc" id="tipodoc"><option value="1">C.C.</option><option value="2">C.E.</option><option value="3">T.I.</option><option value="4">R.C.</option><option value="5">PAS</option><option value="6">N.I.T.</option><option value="7">N.U.I.</option></select></td><td rowspan="3" valign="top"><input type="submit" value="Consultar" style="height:85px"></td></tr>
<tr><td><b>Formulario</b></td><td><input type="text" name="formulario" id="formulario" value="<? echo $_POST['formulario'];?>"></td></tr>
<tr><td><b>Ciudadano</b></td><td><input type="text" name="ciudadano" id="ciudadano" value="<? echo $_POST['ciudadano'];?>"></td></tr>
</table></form>
<?php 
$txtPrefijoRuta = "";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
if (isset($_POST['documento']) AND ($_POST['documento'] != '')){
	$cedula = str_replace(",", "", str_replace(".", "", $_POST['documento']));
	$tipoDocumento = $_POST['tipodoc'];
	$sqlForm = mysql_query("SELECT T_FRM_FORMULARIO.seqFormulario, seqEstadoProceso, seqTipoEsquema, bolCerrado, seqModalidad, fchInscripcion, fchUltimaActualizacion, bolDesplazado, seqProyecto, valTotalRecursos, txtFormulario, valIngresoHogar, seqPlanGobierno FROM T_FRM_HOGAR INNER JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano) INNER JOIN T_FRM_FORMULARIO ON (T_FRM_HOGAR.seqFormulario = T_FRM_FORMULARIO.seqFormulario) WHERE numDocumento = '".$cedula."' AND seqTipoDocumento = $tipoDocumento");
	$rowForm = mysql_fetch_array ($sqlForm);
} elseif (isset($_POST['formulario']) AND ($_POST['formulario'] != '')) {
	$formulario = $_POST['formulario'];
	$sqlForm = mysql_query("SELECT T_FRM_FORMULARIO.seqFormulario, seqEstadoProceso, seqTipoEsquema, bolCerrado, seqModalidad, fchInscripcion, fchUltimaActualizacion, bolDesplazado, seqProyecto, valTotalRecursos, txtFormulario, valIngresoHogar, seqPlanGobierno FROM T_FRM_HOGAR INNER JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano) INNER JOIN T_FRM_FORMULARIO ON (T_FRM_HOGAR.seqFormulario = T_FRM_FORMULARIO.seqFormulario) WHERE T_FRM_FORMULARIO.seqFormulario = '".$formulario."'");
	$rowForm = mysql_fetch_array ($sqlForm);
} elseif (isset($_POST['ciudadano']) AND ($_POST['ciudadano'] != '')) {
	$ciudadano = $_POST['ciudadano'];
	$sqlForm = mysql_query("SELECT T_FRM_FORMULARIO.seqFormulario, seqEstadoProceso, seqTipoEsquema, bolCerrado, seqModalidad, fchInscripcion, fchUltimaActualizacion, bolDesplazado, seqProyecto, valTotalRecursos, txtFormulario, valIngresoHogar, seqPlanGobierno FROM T_FRM_HOGAR INNER JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano) INNER JOIN T_FRM_FORMULARIO ON (T_FRM_HOGAR.seqFormulario = T_FRM_FORMULARIO.seqFormulario) WHERE T_FRM_HOGAR.seqCiudadano = '".$ciudadano."'");
	$rowForm = mysql_fetch_array ($sqlForm);
}
	echo "<table><tr><td><b>Formulario:</b></td><td>".$rowForm['seqFormulario']."</td></tr>";
	echo "<tr title=''><td><b>Estado Proceso:</b></td><td>".$rowForm['seqEstadoProceso']."</td></tr>";
	echo "<tr title=''><td><b>Modalidad:</b></td><td>".$rowForm['seqModalidad']."</td></tr>";
	echo "<tr title='0->No, 1->Si'><td><b>Desplazamiento Forzado:</b></td><td>".$rowForm['bolDesplazado']."</td></tr>";
	echo "<tr><td><b>Proyecto:</b></td><td>".$rowForm['seqProyecto']."</td></tr>";
	echo "<tr><td><b>Total Recursos:</b></td><td>".$rowForm['valTotalRecursos']."</td></tr>";
	echo "<tr title='0:No, 1:Si'><td><b>Formulario Cerrado:</b></td><td>".$rowForm['bolCerrado']."</td></tr>";
	echo "<tr><td><b>Numero de Formulario:</b></td><td>".$rowForm['txtFormulario']."</td></tr>";
	echo "<tr><td><b>Ingresos del Hogar:</b></td><td>".$rowForm['valIngresoHogar']."</td></tr>";
	echo "<tr title='1:Positiva, 2:Humana'><td><b>Plan de Gobierno:</b></td><td>".$rowForm['seqPlanGobierno']."</td></tr>";
	echo "<tr><td><b>Fecha Inscripcion:</b></td><td>".$rowForm['fchInscripcion']."</td></tr>";
	echo "<tr><td><b>Fecha Actualizacion:</b></td><td>".$rowForm['fchUltimaActualizacion']."</td></tr>";
	echo "<tr><td><b>Tipo Esquema:</b></td><td>".$rowForm['seqTipoEsquema']."</td></tr></table>";
	// MIEMBROS DEL HOGAR
	$sqlMiembros = mysql_query("SELECT T_FRM_HOGAR.seqCiudadano, seqParentesco, numDocumento, seqTipoDocumento, CONCAT(txtNombre1,' ',txtNombre2,' ',txtApellido1,' ',txtApellido2) AS nombre, valIngresos, seqTipoVictima FROM T_FRM_HOGAR LEFT JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano) WHERE seqFormulario = '".$rowForm['seqFormulario']."'");
	echo "<br><table border='1' cellpadding='3' cellspacing='1'><tr><th colspan='7'>Miembros del Hogar</th></tr><tr><th>Ciudadano</th><th>Documento</th><th>TipoDoc</th><th>Nombre</th><th>Parentesco</th><th>Tipo Victima</th><th>Ingreso</th></tr>";
	while ($rowMiembros = mysql_fetch_array ($sqlMiembros)){
		echo "<tr><td align='center'>".$rowMiembros['seqCiudadano']."</td>";
		if ($rowMiembros['seqParentesco'] == 1) {
			echo "<td align='right'><b>".number_format($rowMiembros['numDocumento'],0,',','.')."</b></td>";
		} else {
			echo "<td align='right'>".number_format($rowMiembros['numDocumento'],0,',','.')."</td>";
		}
		echo "<td align='center'>".$rowMiembros['seqTipoDocumento']."</td>";
		echo "<td>".utf8_decode($rowMiembros['nombre'])."</td>";
		echo "<td align='center'>".$rowMiembros['seqParentesco']."</td>";
		echo "<td align='center'>".$rowMiembros['seqTipoVictima']."</td>";
		echo "<td align='right'>".$rowMiembros['valIngresos']."</td></tr>";
	}
	echo "</table>";
	// DATOS DEL DESEMBOLSO
	$sqlDesemb = mysql_query("SELECT seqDesembolso FROM T_DES_DESEMBOLSO WHERE seqFormulario = '".$rowForm['seqFormulario']."'");
	$rowDesemb = mysql_fetch_array ($sqlDesemb);
	echo "<br><table><tr><td><b>Desembolso:</b></td><td>".$rowDesemb['seqDesembolso']."</td></tr></table>";
	// DATOS CASA EN MANO
	$sqlCasaMano = mysql_query("SELECT seqCasaMano FROM T_CEM_CASA_MANO WHERE seqFormulario = '".$rowForm['seqFormulario']."'");
	$rowCasaMano = mysql_fetch_array ($sqlCasaMano);
	echo "<table><tr><td><b>Casa en Mano:</b></td><td>".$rowCasaMano['seqCasaMano']."</td></tr></table>";
?>
</body></html>