<?php 
$filename ="Victimizacion.xls";
header("Content-type: application/vnd.ms-excel; charset=utf-8");
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
//set_time_limit(0);
//ini_set('memory_limit','128M');
$txtPrefijoRuta = "../../../";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

// CONSULTA FINAL (OK)
$qryHogar = "SELECT seqFormulario, T_FRM_FORMULARIO.seqEstadoProceso, seqTipoEsquema, seqEtapa, bolDesplazado
			FROM T_FRM_FORMULARIO INNER JOIN T_FRM_ESTADO_PROCESO ON (T_FRM_FORMULARIO.seqEstadoProceso = T_FRM_ESTADO_PROCESO.seqEstadoProceso)
";

$exeQueryHogar = mysql_query($qryHogar);

// RECORRIENDO LOS MIEMBROS POR HOGAR

print_r("<table width='50%' align='center' cellpadding=0 cellspacing=0 border=0>");
print_r ("<tr><td>Formulario</td><td>Etapa</td><td>Estado Proceso</td><td>Esquema</td><td>Hogar Desplazado</td><td>Miembros del hogar</td><td>desp forzado</td><td>otros</td></tr>");

while ($rowHogar = mysql_fetch_array($exeQueryHogar)) {
//print_r ("<tr><td>$rowHogar[seqFormulario]</td></tr>");
$n = 0;
	$qryCalifica = "SELECT c.seqCiudadano,
						numDocumento,
						seqTipoVictima,
						seqParentesco
					FROM T_CIU_CIUDADANO c
						LEFT JOIN T_FRM_HOGAR h ON (c.seqCiudadano = h.seqCiudadano)
						LEFT JOIN T_FRM_FORMULARIO f ON (h.seqFormulario = f.seqFormulario)
					WHERE f.seqFormulario = $rowHogar[seqFormulario]";
	
	//echo $qryCalifica."<br>";
	$exeCalifica = mysql_query($qryCalifica);
	$victima = 0;
	$novictima = 0;
	while ($rowCalifica = mysql_fetch_array($exeCalifica)) { 
	$n = $n + 1;
		if ($rowCalifica[seqTipoVictima] != 2 ){ // Es desplazamiento Forzado -> Hogar Vicitma
			$novictima = $novictima + 1;
		} else {
			$victima = $victima + 1;
		}
	} // FIN RECORRIDO DE INTEGRANTES DEL HOGAR
	print_r ("<tr><td>$rowHogar[seqFormulario]</td><td>$rowHogar[seqEtapa]</td><td>$rowHogar[seqEstadoProceso]</td><td>$rowHogar[seqTipoEsquema]</td><td>$rowHogar[bolDesplazado]</td><td>$n</td><td>$victima</td><td>$novictima</td></tr>");
}
print_r ("</table>");
?>