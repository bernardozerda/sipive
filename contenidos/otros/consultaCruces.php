<html><body>
<form action="<? $PHP_SELF ?>" method="POST"><table border="0">
<tr><td><b>Documento</b></td><td><input type="text" name="documento" id="documento" size="10"><select name="tipodoc" id="tipodoc"><option value="1">C.C.</option><option value="2">C.E.</option><option value="3">T.I.</option><option value="4">R.C.</option><option value="5">PAS</option><option value="6">N.I.T.</option><option value="7">N.U.I.</option></select></td><td rowspan="3" valign="top"><input type="submit" value="Consultar" style="height:55px"></td></tr>
<tr><td><b>Formulario</b></td><td><input type="text" name="formulario" id="formulario" value="<? echo $_POST['formulario'];?>"></td></tr>
</table></form>
<?php 
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
if (isset($_POST['documento']) AND ($_POST['documento'] != '')){
	$cedula = str_replace(",", "", str_replace(".", "", $_POST['documento']));
	$tipoDocumento = $_POST['tipodoc'];
	$sqlForm = mysql_query("SELECT DISTINCT(T_CRU_CRUCES.seqCruce),T_CRU_CRUCES.txtNombre, fchCruce, fchCreacionCruce, numDocumento, seqFormulario FROM T_CRU_CRUCES INNER JOIN T_CRU_RESULTADO ON (T_CRU_CRUCES.seqCruce = T_CRU_RESULTADO.seqCruce) WHERE numDocumento = '" . $cedula . "' AND seqTipoDocumento = $tipoDocumento");
} elseif (isset($_POST['formulario']) AND ($_POST['formulario'] != '')) {
	$formulario = $_POST['formulario'];
	$sqlForm = mysql_query("SELECT DISTINCT(seqCruce), seqFormulario FROM T_CRU_RESULTADO WHERE seqFormulario = '".$formulario."'");
}
	while ($rowCruces = mysql_fetch_array ($sqlForm)){
		// MUESTRA DATOS BASICOS DEL CRUCE
		if (isset($_POST['documento']) AND ($_POST['documento'] != '')){
			echo "<table><tr><td><b>Nombre Cruce:</b></td><td><b>".$rowCruces['txtNombre']."</b></td></tr>";
			echo "<tr><td><b>Fecha Cruce:</b></td><td>".$rowCruces['fchCruce']."</td></tr>";
			echo "<tr><td><b>Fecha Actualizaci&oacute;n:</b></td><td>".$rowCruces['fchCreacionCruce']."</td></tr>";
			echo "<tr><td><b>Formulario:</b></td><td>".$rowCruces['seqFormulario']."</td></tr>";
		} elseif (isset($_POST['formulario']) AND ($_POST['formulario'] != '')) {
			$sqlFormulario = mysql_query("SELECT T_CRU_CRUCES.txtNombre, fchCruce, fchCreacionCruce FROM T_CRU_CRUCES WHERE seqCruce = " . $rowCruces['seqCruce']);
			$rowFormulario = mysql_fetch_array ($sqlFormulario);
			echo "<table><tr><td><b>Nombre Cruce:</b></td><td><b>".$rowFormulario['txtNombre']."</b></td></tr>";
			echo "<tr><td><b>Fecha Cruce:</b></td><td>".$rowFormulario['fchCruce']."</td></tr>";
			echo "<tr><td><b>Fecha Actualizaci&oacute;n:</b></td><td>".$rowFormulario['fchCreacionCruce']."</td></tr>";
			echo "<tr><td><b>Formulario:</b></td><td>".$_POST['formulario']."</td></tr>";
		}
		// POSTULANTE PRINCIPAL
		$sqlPpal = mysql_query("SELECT seqFormulario, numDocumento, CONCAT(txtNombre1,' ',txtNombre2,' ',txtApellido1,' ',txtApellido2) AS nombrePpal FROM T_FRM_HOGAR INNER JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano) WHERE seqParentesco = 1 AND seqFormulario = " . $rowCruces['seqFormulario'] );
		$rowPpal = mysql_fetch_array ($sqlPpal);
		echo "<tr><td><b>Postulante Principal:</b></td><td>[" . $rowPpal['numDocumento'] . "] " . $rowPpal['nombrePpal'] ."</td></tr></table>";
		// APARICIONES DEL DOCUMENTO EN T_CRU_RESULTADOS SEGUN EL SEQCRUCE
		$sqlResultadosCruce = mysql_query("SELECT * FROM T_CRU_RESULTADO WHERE seqCruce = " . $rowCruces['seqCruce'] . " AND seqFormulario = " . $rowCruces['seqFormulario']);
		echo "<table border='1' cellspacing='1' cellpadding='1' width='100%'>";
		echo "<tr><th width='9%'>Documento</th><th width='20%'>Nombre</th><th width='10%'>Entidad</th><th width='10%'>T&iacute;tulo</th><th width='30%'>Detalle</th><th width='9%'>Inhabilitar</th><th width='12%'>Observaciones</th></tr>";
		while ($rowResultado = mysql_fetch_array ($sqlResultadosCruce)){
			echo "<tr><td>".$rowResultado['numDocumento']."</td>";
			echo "<td>".$rowResultado['txtNombre']."</td>";
			echo "<td>".$rowResultado['txtEntidad']."</td>";
			echo "<td>".$rowResultado['txtTitulo']."</td>";
			echo "<td>".$rowResultado['txtDetalle']."</td>";
			echo "<td>".$rowResultado['bolInhabilitar']."</td>";
			echo "<td>".$rowResultado['txtObservaciones']."</td></tr>";
		}
		echo "</table><br>";
	}
?>
</body></html>