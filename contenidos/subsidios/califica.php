<?php 
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

// PORCENTAJES DE INDICADOR
$prcIH = 0.1028;
$prcTDE = 0.2215;
$prcANALF = 0.0975;
$prcTamHogar = 0.0292;
$prcHogMonop = 0.086;
$PropM14 = 0.1416;
$PropMy60 = 0.1061;
$PropDisc = 0.1435;
$prcME = 0.1128;

// PONDERACION
$prcIHPonderacion = 9.9;
$prcTDEPonderacion = 21.3;
$prcANALFPonderacion = 9.3;
$prcTamHogarPonderacion = 2.8;
$prcHogMonopPonderacion = 8.3;
$PropM14Ponderacion = 13.6;
$PropMy60Ponderacion = 10.2;
$PropDiscPonderacion = 13.8;
$prcMEPonderacion = 10.8;

// HOGARES LISTOS PARA POSTULAR
$qryHogar = mysql_query("SELECT f.seqFormulario, fchInscripcion, seqEstadoProceso, seqModalidad
FROM t_frm_formulario f 
RIGHT JOIN t_frm_hogar h ON (f.seqFormulario = h.seqFormulario) 
LEFT JOIN t_ciu_ciudadano c ON (h.seqCiudadano = c.seqCiudadano) 
WHERE seqEstadoProceso IN (6, 37)
AND f.seqFormulario = 237721
AND h.seqParentesco = 1
AND fchNacimiento <> '0000-00-00'
AND valIngresos > 0");

// RECORRIENDO LOS MIEMBROS POR HOGAR
print_r("<table width='100%' cellpadding=0 cellspacing=0 border=1>");
print_r("<tr><th>No.</th><th>Formulario</th><th>Estado Proceso</th><th>Modalidad</th>");
print_r("<th>Ingresos Hogar</th><th>Tasa dependencia Economica</th><th>Analfabetismo Bajo Nivel Educativo</th>");
print_r("<th>Tama&ntilde;o Hogar</th><th>Jefatura Femenina</th><th>Ni&ntilde;ez</th>");
print_r("<th>Adultez</th><th>Discapacidad</th><th>Minoria Etnica</th><th>Puntaje Hogar</th></tr>");

$n = 0;
$fecha = date('Y-m-d');
while ($rowHogar = mysql_fetch_array($qryHogar)) {
	$n = $n + 1;
	$qryCalifica = mysql_query("SELECT DISTINCT(f.seqFormulario),
	numDocumento,
	seqParentesco,
	seqEtnia,
	seqSexo,
	seqCondicionEspecial,
	seqCondicionEspecial2,
	seqCondicionEspecial3,
	fchNacimiento,
	seqNivelEducativo,
	FLOOR((DATEDIFF(NOW(),fchNacimiento))/360) AS edad,
	valIngresos
	FROM t_ciu_ciudadano c
	LEFT JOIN t_frm_hogar h ON (c.seqCiudadano = h.seqCiudadano)
	LEFT JOIN t_frm_formulario f ON (h.seqFormulario = f.seqFormulario)
	WHERE f.seqFormulario = ".$rowHogar[seqFormulario]);
	
	$IH = 0;
	$TDE = 0;
	$ANALF = 0;
	$TamHogar = 0;
	$HogMonop = 0;
	$PropM14 = 0;
	$PropMy60 = 0;
	$PropDisc = 0;
	$ME = 0;
	
	$valTotalIngresos = 0;
	$num_etnia = 0;
	$num_mayores = 0;
	$num_discapacidad = 0;
	$num_menores = 0;
	$numNoDependiente = 0;
	$numAnalfa = 0;
	$numMayores14 = 0;
	$flagJefeHogar = 0;
	$flagConyuge = 0;
	$flagHijo = 0;
	$flagOtro = 0;
	
	while ($rowCalifica = mysql_fetch_array($qryCalifica)) {
	
		echo $rowCalifica["numDocumento"] . "<br>";
	
		// Ingresos del Hogar (IH)
		$valTotalIngresos = $valTotalIngresos + $rowCalifica[valIngresos];
			
		// Tasa de Analfabetismo / Bajo Nivel Educativo (ANALF)
		if ($rowCalifica[edad] > 13 && $rowCalifica[seqNivelEducativo] < 4 ){ // Personas Analfabetas Mayores de 14 años en el Hogar
			$numAnalfa = $numAnalfa + 1;
		}
		if ($rowCalifica[edad] > 13){ // Personas Mayores de 14 años en el Hogar
			$numMayores14 = $numMayores14 + 1;
		}
			
		// Tamaño del Hogar (TamHog)
		$TamHogar = $TamHogar + 1;
		
		// Jefatura Femenina / Masculina
		if ($rowCalifica[seqParentesco] == 1 && $rowCalifica[seqSexo] == 2) { // Jefe Hogar Mujer
			$flagJefeHogar = 2;
		} else if ($rowCalifica[seqParentesco] == 1 && $rowCalifica[seqSexo] == 1) { // Jefe Hogar Hombre
			$flagJefeHogar = 1;
		}
		if ($rowCalifica[seqParentesco] == 2) { // Tiene Conyuge
			$flagConyuge = $flagConyuge + 1;
		}
		if (($rowCalifica[seqParentesco] == 3) && ($rowCalifica[edad] < 15)) { // Tiene Hijos Menores
			$flagHijo = $flagHijo + 1;
		}
		if ($rowCalifica[seqParentesco] != 1 && $rowCalifica[valIngresos] > 0) { // Otro Integrante que Devengue
			$flagOtro = $flagOtro + 1;
		}

		// Niñez (PropM14)
		if ($rowCalifica[edad] < 15) {
			$num_menores = $num_menores + 1;
		}

		// Adultez (PropMy60)
		if ($rowCalifica[edad] > 59) {
			$num_mayores = $num_mayores + 1;
		}

		// Tasa de Dependencia Economica
		if ($rowCalifica[edad] > 14 && $rowCalifica[edad] < 60) {
			$numNoDependiente = $numNoDependiente + 1;
		}
		
		// Discapacidad (PropDisc)
		if ($rowCalifica[seqCondicionEspecial] == 3) {
			$num_discapacidad = $num_discapacidad + 1;
		}
		if ($rowCalifica[seqCondicionEspecial2] == 3) {
			$num_discapacidad = $num_discapacidad + 1;
		}
		if ($rowCalifica[seqCondicionEspecial3] == 3) {
			$num_discapacidad = $num_discapacidad + 1;
		}
		
		// Minoria Etnica (ME)
		if ($rowCalifica[seqEtnia] != 1) {
			$num_etnia = $num_etnia + 1;
		}

	}
	
	// INGRESOS DEL HOGAR
	$IH = ($arrConfiguracion['constantes']['salarioMinimo'] / $valTotalIngresos) * ($prcIHPonderacion / 100);
	
	// TASA DE DEPENDENCIA ECONOMICA
	if ($numNoDependiente == 0){
		$numNoDependiente = $num_mayores;
	}
	$TDE = ($num_menores + $num_mayores) / $numNoDependiente;
	
/*	
	// ANALFABETISMO / BAJO NIVEL EDUCATIVO
	$ANALF = $numAnalfa / $numMayores14;
	

	if (($flagJefeHogar == 2) && ($flagConyuge == 0) && ($flagHijo > 0) && ($flagOtro == 0)) { // Jefatura Femenina
		$HogMonop = 1;
	} else if (($flagJefeHogar == 1) && ($flagConyuge == 0) && ($flagHijo > 0) && ($flagOtro == 0)) { // Jefatura Masculina
		$HogMonop = 1;
	} else {
		$HogMonop = 0;
	}
	$PropM14 = $num_menores / $TamHogar;
	$PropMy60 = $num_mayores / $TamHogar;
	$PropDisc = $num_discapacidad / $TamHogar;
	if ($num_etnia > 0) {
		$ME = 1;
	}
*/

	$puntajeHogar = round(((($prcIH * $IH) + ($prcTDE * $TDE) + ($prcANALF * $ANALF) + ($prcTamHogar * $TamHogar) + 
					($prcHogMonop * $HogMonop) + ($prcPropM14 * $PropM14) + ($prcPropMy60 * $PropMy60) + 
					($prcPropDisc * $PropDisc) + ($prcME * $ME)) * 100), 4);

	echo "
		($prcIH * $IH)             + ($prcTDE * $TDE)         + ($prcANALF * $ANALF)       + ($prcTamHogar * $TamHogar) + 
		($prcHogMonop * $HogMonop) + ($prcPropM14 * $PropM14) + ($prcPropMy60 * $PropMy60) + 
		($prcPropDisc * $PropDisc) + ($prcME * $ME)
	";
					
	print_r ("<tr>");
	print_r ("<th>$n</th>");
	print_r ("<th>$rowHogar[seqFormulario]</th>");
	print_r ("<th>$rowHogar[seqModalidad]</th>");
	print_r ("<th>$rowHogar[seqEstadoProceso]</th>");
	print_r ("<td>$IH</td>"); // Ingresos Hogar [[OK]]
	print_r ("<td>$TDE</td>"); // Tasa dependencia Economica
	print_r ("<td>$ANALF</td>"); // Analfabetismo/Bajo Nivel Educativo
	print_r ("<td>$TamHogar</td>"); // Tamaño Hogar [[OK]]
	print_r ("<td>$HogMonop</td>"); // Jefatura Femenina o Masculina
	print_r ("<td>$PropM14</td>"); // Niñez [[OK]]
	print_r ("<td>$PropMy60</td>"); // Adultez [[OK]]
	print_r ("<td>$PropDisc</td>"); // Discapacidad [[OK]]
	print_r ("<td>$ME</td>"); // Minoria Etnica [[OK]]
	print_r ("<th>$puntajeHogar</th>");
	print_r ("</tr>");

$sql = "INSERT INTO t_frm_klifikcion (seqFormulario, fchCalificacion, valB1, valB2, valB3, valB4, valB5, valB6, 
valB7, valB8, valB9, valTotalCalificacion) VALUES ($rowHogar[seqFormulario], '$fecha', $IH, $TDE, $ANALF, 
$TamHogar, $HogMonop, $PropM14, $PropMy60, $PropDisc, $ME, $puntajeHogar);<br>";
//echo $sql;
}
print_r("</table>");