<?php

//set_time_limit(0);
//ini_set('memory_limit','128M');
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

$ejecutaConsultaPersonalizada = 0;
if ($_FILES['fileDocumentos']['error'] == 0) {
    $arrDocumentos = mb_split("\n", file_get_contents($_FILES['fileDocumentos']['tmp_name']));
    $cuantosPpal = 0;
    $cuantosNoPpal = 0;
    $arrNoPpal = array();
    foreach ($arrDocumentos as $numLinea => $numDocumento) {
        if (intval($numDocumento) != 0) {
            $qryPpal = mysql_query("SELECT seqFormulario 
						FROM t_frm_hogar INNER JOIN t_ciu_ciudadano ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano) 
						WHERE seqParentesco = 1 
						AND seqTipoDocumento IN (1, 2)
						AND numDocumento = " . $arrDocumentos[$numLinea]);
            $cuenta = mysql_num_rows($qryPpal);
            $rowPpal = mysql_fetch_array($qryPpal);
            if ($cuenta > 0) {
                $cuantosPpal = $cuantosPpal + 1;
                $formularioPpal .= $rowPpal['seqFormulario'] . ", ";
            } else {
                $cuantosNoPpal = $cuantosNoPpal + 1;
                $documentosNoPpal .= $arrDocumentos[$numLinea] . ", ";
            }
        } else {
            unset($arrDocumentos[$numLinea]);
        }
    }
    $formulariosPpalFormat = substr($formularioPpal, 0, -2);
    $documentosNoPpalFormat = substr($documentosNoPpal, 0, -2);
    $ejecutaConsultaPersonalizada = 1;
}

// PORCENTAJES DE INDICADOR
$qryPorcentajes = mysql_query("SELECT * FROM T_FRM_INDICADOR");
$pref = "porc";
while ($rowPorc = mysql_fetch_array($qryPorcentajes)) {
    if ($rowPorc[sigIndicador] == 'IH')
        $prcIH = $rowPorc[prcIndicador];
    if ($rowPorc[sigIndicador] == 'TDE')
        $prcTDE = $rowPorc[prcIndicador];
    if ($rowPorc[sigIndicador] == 'ANALF')
        $prcANALF = $rowPorc[prcIndicador];
    if ($rowPorc[sigIndicador] == 'TamHogar')
        $prcTamHogar = $rowPorc[prcIndicador];
    if ($rowPorc[sigIndicador] == 'HogMonop')
        $prcHogMonop = $rowPorc[prcIndicador];
    if ($rowPorc[sigIndicador] == 'PropM14')
        $prcPropM14 = $rowPorc[prcIndicador];
    if ($rowPorc[sigIndicador] == 'PropMy60')
        $prcPropMy60 = $rowPorc[prcIndicador];
    if ($rowPorc[sigIndicador] == 'PropDisc')
        $prcPropDisc = $rowPorc[prcIndicador];
    if ($rowPorc[sigIndicador] == 'ME')
        $prcME = $rowPorc[prcIndicador];
}

// HOGARES A CALIFICAR

if ($ejecutaConsultaPersonalizada == 1) {
    /* $qryHogar = "SELECT seqFormulario, fchInscripcion, fchUltimaActualizacion, seqEstadoProceso, seqModalidad FROM T_FRM_FORMULARIO frm
      WHERE seqFormulario IN ($formulariosPpalFormat);"; */
    $qryHogar = "SELECT T_FRM_FORMULARIO.seqFormulario,
						fchInscripcion,
						fchUltimaActualizacion,
						seqEstadoProceso,
						seqModalidad
				FROM T_FRM_FORMULARIO
				INNER JOIN T_FRM_HOGAR ON (T_FRM_FORMULARIO.seqFormulario = T_FRM_HOGAR.seqFormulario)
				INNER JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano)
				WHERE T_FRM_FORMULARIO.seqFormulario IN ($formulariosPpalFormat)
				AND seqParentesco = 1
				AND fchNacimiento <> '0000-00-00'";
} else {
    $qryHogar = "SELECT T_FRM_FORMULARIO.seqFormulario,
						fchInscripcion,
						fchUltimaActualizacion,
						seqEstadoProceso,
						seqModalidad
				FROM T_FRM_FORMULARIO INNER JOIN T_FRM_HOGAR ON (T_FRM_FORMULARIO.seqFormulario = T_FRM_HOGAR.seqFormulario)
				INNER JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano)
				WHERE seqEstadoProceso IN (6, 37)
				AND seqModalidad IN (6, 11)
				AND seqTipoEsquema IN (0, 1)
				AND seqParentesco = 1
				AND fchNacimiento <> '0000-00-00'";
}
//echo $qryHogar;die();

$exeQueryHogar = mysql_query($qryHogar);

// RECORRIENDO LOS MIEMBROS POR HOGAR

print_r("<table width='50%' align='center' cellpadding = '0' cellspacing = '0' border = '0'>");
$n = 0;
$valorPromedio = 0;
$sumaDesviacionEstandar = 0;
$valorDesviacionEstandar = 0;
$fecha = date('Y-m-d H:i:s');

while ($rowHogar = mysql_fetch_array($exeQueryHogar)) {
    $qryCalifica = "SELECT DISTINCT(f.seqFormulario),
						numDocumento,
						seqParentesco,
						seqEtnia,
						seqSexo,
						seqCondicionEspecial,
						seqCondicionEspecial2,
						seqCondicionEspecial3,
						fchNacimiento,
						seqNivelEducativo,
						YEAR(CURDATE())-YEAR(fchNacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') >= DATE_FORMAT(fchNacimiento,'%m-%d'), 0, -1)  AS edad,
						valIngresos
					FROM T_CIU_CIUDADANO c
						LEFT JOIN T_FRM_HOGAR h ON (c.seqCiudadano = h.seqCiudadano)
						LEFT JOIN T_FRM_FORMULARIO f ON (h.seqFormulario = f.seqFormulario)
					WHERE f.seqFormulario = $rowHogar[seqFormulario]";

    $exeCalifica = mysql_query($qryCalifica);

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
    $autoMonoparental = 0;
    $num_mayores = 0;
    $num_menores15 = 0;
    $num_discapacidad = 0;
    $num_menores = 0;
    $numNoDependiente = 0;
    $numAnalfa = 0;
    $numMayores14 = 0;
    $flagJefeHogar = 0;
    $flagConyuge = 0;
    $flagHijo = 0;
    $flagOtro = 0;
    $transformada = 0;

    while ($rowCalifica = mysql_fetch_array($exeCalifica)) { // INICIO RECORRIDO DE INTEGRANTES DEL HOGAR
        // Ingresos del Hogar (IH)
        $valTotalIngresos = $valTotalIngresos + $rowCalifica[valIngresos];

        // Tasa de Analfabetismo / Bajo Nivel Educativo (ANALF)
        if ($rowCalifica[edad] > 13 && $rowCalifica[seqNivelEducativo] < 4) { // Personas Analfab May de 14 años
            $numAnalfa = $numAnalfa + 1;
        }
        if ($rowCalifica[edad] > 13) { // Personas Mayores de 14 años en el Hogar
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
        if ($rowCalifica[seqParentesco] == 3) { // Tiene Hijos Menores
            $flagHijo = $flagHijo + 1;
        }
        if ($rowCalifica[seqParentesco] != 1 && $rowCalifica[valIngresos] > 0) { // Otro Integrante que Devengue
            $flagOtro = $flagOtro + 1;
        }

        // Niñez (PropM14) (OK)
        if ($rowCalifica[edad] < 14) {
            $num_menores = $num_menores + 1;
        }

        // Menores de 15 (Menores de 15)
        if ($rowCalifica[edad] < 15) {
            $num_menores15 = $num_menores15 + 1;
        }

        // Adultez (PropMy60) (OK)
        if ($rowCalifica[edad] >= 60) {
            $num_mayores = $num_mayores + 1;
        }

        // Tasa de Dependencia Economica
        if ($rowCalifica[edad] >= 15 && $rowCalifica[edad] < 60) {
            $numNoDependiente = $numNoDependiente + 1;
        }

        // Discapacidad (PropDisc)
        if (($rowCalifica[seqCondicionEspecial] == 3) || ($rowCalifica[seqCondicionEspecial2] == 3) || ($rowCalifica[seqCondicionEspecial3] == 3)) {
            $num_discapacidad = $num_discapacidad + 1;
        }

        // Minoria Etnica (ME)
        if ($rowCalifica[seqEtnia] != 1) {
            $num_etnia = $num_etnia + 1;
        }

        // Identificando Hogar Monoparental
        if ($rowCalifica[seqParentesco] == 1) {
            if (($rowCalifica[seqCondicionEspecial] == 1) || ($rowCalifica[seqCondicionEspecial2] == 1) || ($rowCalifica[seqCondicionEspecial3] == 1)) {
                $autoMonoparental = 1;
            }
        }
    } // FIN RECORRIDO DE INTEGRANTES DEL HOGAR
    // INGRESOS DEL HOGAR
    if ($valTotalIngresos == 0) {
        $IH = 0;
    } else {
        $IH = ($arrConfiguracion['constantes']['salarioMinimo'] / $valTotalIngresos);
    }

    // TASA DE DEPENDENCIA ECONOMICA
    if ($numNoDependiente == 0) {
        $numNoDependiente = 0.1;
    }

    $TDE = ($num_menores15 + $num_mayores) / $numNoDependiente;

    // ANALFABETISMO / BAJO NIVEL EDUCATIVO
    $ANALF = $numAnalfa / $numMayores14;

    if (($flagJefeHogar == 2) && ($flagConyuge == 0) && ($flagHijo > 0) && ($flagOtro == 0) && $autoMonoparental == 1) { // Jefatura Femenina
        $HogMonop = 2;
    } else if (($flagJefeHogar == 1) && ($flagConyuge == 0) && ($flagHijo > 0) && ($flagOtro == 0) && $autoMonoparental == 1) { // Jefatura Masculina
        $HogMonop = 1;
    } else { // No es Monoparental
        $HogMonop = 0;
    }
    $PropM14 = $num_menores / $TamHogar;
    $PropMy60 = $num_mayores / $TamHogar;
    $PropDisc = $num_discapacidad / $TamHogar;
    if ($num_etnia > 0) {
        $ME = 1;
    } else {
        $ME = 0;
    }

    // BUSCANDO EQUIVALENTE EN TABLA CUANTIFICATIVA DE VALORES
    // Valor Equivalente IH
    $consultaIH = mysql_query("SELECT * FROM T_FRM_VARIABLES WHERE seqIndicador = 1");
    while ($rowIH = mysql_fetch_array($consultaIH)) {
        if ($IH > $rowIH[numRango1] && $IH <= $rowIH[numRango2]) {
            $valorIH = $rowIH[numValoracion];
        }
    }
    // Valor Equivalente TDE
    $consultaTDE = mysql_query("SELECT * FROM T_FRM_VARIABLES WHERE seqIndicador = 2");
    while ($rowTDE = mysql_fetch_array($consultaTDE)) {
        if ($TDE > $rowTDE[numRango1] && $TDE <= $rowTDE[numRango2]) {
            $valorTDE = $rowTDE[numValoracion];
        }
    }
    // Valor Equivalente ANALF
    $consultaANALF = mysql_query("SELECT * FROM T_FRM_VARIABLES WHERE seqIndicador = 3");
    while ($rowANALF = mysql_fetch_array($consultaANALF)) {
        if ($ANALF > $rowANALF[numRango1] && $ANALF <= $rowANALF[numRango2]) {
            $valorANALF = $rowANALF[numValoracion];
        }
    }
    // Valor Equivalente Hogar Monoparental
    $consultaHogMonop = mysql_query("SELECT * FROM T_FRM_VARIABLES WHERE seqIndicador = 5");
    while ($rowHogMonop = mysql_fetch_array($consultaHogMonop)) {
        if ($HogMonop > $rowHogMonop[numRango1] && $HogMonop <= $rowHogMonop[numRango2]) {
            $valorHogMonop = $rowHogMonop[numValoracion];
        }
    }
    // Valor Equivalente PropM14
    $consultaPropM14 = mysql_query("SELECT * FROM T_FRM_VARIABLES WHERE seqIndicador = 6");
    while ($rowPropM14 = mysql_fetch_array($consultaPropM14)) {
        if ($PropM14 > $rowPropM14[numRango1] && $PropM14 <= $rowPropM14[numRango2]) {
            $valorPropM14 = $rowPropM14[numValoracion];
        }
    }
    // Valor Equivalente PropMy60
    $consultaPropMy60 = mysql_query("SELECT * FROM T_FRM_VARIABLES WHERE seqIndicador = 7");
    while ($rowPropMy60 = mysql_fetch_array($consultaPropMy60)) {
        if ($PropMy60 > $rowPropMy60[numRango1] && $PropMy60 <= $rowPropMy60[numRango2]) {
            $valorPropMy60 = $rowPropMy60[numValoracion];
        }
    }
    // Valor Equivalente Disc
    $consultaPropDisc = mysql_query("SELECT * FROM T_FRM_VARIABLES WHERE seqIndicador = 8");
    while ($rowPropDisc = mysql_fetch_array($consultaPropDisc)) {
        if ($PropDisc > $rowPropDisc[numRango1] && $PropDisc <= $rowPropDisc[numRango2]) {
            $valorPropDisc = $rowPropDisc[numValoracion];
        }
    }
    // Valor Minoría Etnica
    $consultaME = mysql_query("SELECT * FROM T_FRM_VARIABLES WHERE seqIndicador = 9");
    while ($rowME = mysql_fetch_array($consultaME)) {
        if ($ME > $rowME[numRango1] && $ME <= $rowME[numRango2]) {
            $valorME = $rowME[numValoracion];
        }
    }

    // GUARDANDO EN LA TABLA T_FRM_CALIFICACION
    // Verifica que el puntaje actual obtenido es diferente al anterior
    /* $qryCalifAnterior = "SELECT valTransformado FROM T_FRM_CALIFICACION_PLAN2 WHERE seqFormulario = $rowHogar[seqFormulario] and fchCalificacion = (SELECT MAX(fchCalificacion) FROM T_FRM_CALIFICACION_PLAN2 WHERE seqFormulario = $rowHogar[seqFormulario])";
      $exeCalifAnterior = mysql_query(qryCalifAnterior);
      $rowCalifAnterior = mysql_fetch_array($exeCalifAnterior); */

    //if ($rowCalifAnterior[valTransformado] != $transformada){
    //if ($TamHogar > 1 ) {
    $n = $n + 1;
    // Se insertan los nuevos valores de calificacion en la base de datos
    $qryCalifica = "INSERT INTO T_FRM_CALIFICACION_PLAN2 (
							seqFormulario, 
							fchUltimaActualizacion, 
							fchCalificacion, 
							divB1, 
							valB1, 
							divB2, 
							valB2, 
							divB3, 
							valB3, 
							valB4, 
							divB5, 
							valB5, 
							divB6, 
							valB6, 
							divB7, 
							valB7, 
							divB8, 
							valB8, 
							divB9, 
							valB9 ) 
						VALUES (
							$rowHogar[seqFormulario], 
							'$rowHogar[fchUltimaActualizacion]', 
							'$fecha', 
							$IH, 
							$valorIH, 
							$TDE, 
							$valorTDE, 
							$ANALF, 
							$valorANALF, 
							$TamHogar, 
							$HogMonop,
							$valorHogMonop,
							$PropM14,
							$valorPropM14, 
							$PropMy60,
							$valorPropMy60,
							$PropDisc,
							$valorPropDisc,
							$ME,
							$valorME );";
    //echo $qryCalifica."<br>";
    mysql_query($qryCalifica);
    //}
    // Se actualiza el estado de proceso del formulario (53)
    //$qryUpdEstado = "UPDATE T_FRM_FORMULARIO SET seqEstadoProceso = 53 WHERE seqFormulario = $rowHogar[seqFormulario]";
    //mysql_query ($qryUpdEstado);
    //}
}

// CALCULANDO PROMEDIOS Y DESVIACION ESTANDAR DEL TOTAL DE HOGARES POR ITEM DE CALIFICACION (ojo: sería bueno guardarlos en la tabla calificacion_estadisticas)
 $qryEstadisticaHogar = "SELECT
  AVG(valB1) AS prmB1, SQRT(((VARIANCE(valB1))/(COUNT(*)-1)) * COUNT(*)) AS varB1,
  AVG(valB2) AS prmB2, SQRT(((VARIANCE(valB2))/(COUNT(*)-1)) * COUNT(*)) AS varB2,
  AVG(valB3) AS prmB3, SQRT(((VARIANCE(valB3))/(COUNT(*)-1)) * COUNT(*)) AS varB3,
  AVG(valB4) AS prmB4, SQRT(((VARIANCE(valB4))/(COUNT(*)-1)) * COUNT(*)) AS varB4,
  AVG(valB5) AS prmB5, SQRT(((VARIANCE(valB5))/(COUNT(*)-1)) * COUNT(*)) AS varB5,
  AVG(valB6) AS prmB6, SQRT(((VARIANCE(valB6))/(COUNT(*)-1)) * COUNT(*)) AS varB6,
  AVG(valB7) AS prmB7, SQRT(((VARIANCE(valB7))/(COUNT(*)-1)) * COUNT(*)) AS varB7,
  AVG(valB8) AS prmB8, SQRT(((VARIANCE(valB8))/(COUNT(*)-1)) * COUNT(*)) AS varB8,
  AVG(valB9) AS prmB9, SQRT(((VARIANCE(valB9))/(COUNT(*)-1)) * COUNT(*)) AS varB9
  FROM
  T_FRM_CALIFICACION_PLAN2
  WHERE
  fchCalificacion = '$fecha'";


  $exeEstadisticaHogar = mysql_query($qryEstadisticaHogar);
  $rowEstadisticaHogar = mysql_fetch_array ($exeEstadisticaHogar);

  // GUARDANDO PROMEDIOS Y VARIACION ESTANDAR DEL TOTAL DE HOGARES
  $qryGuardaEstadisticas = "INSERT INTO T_FRM_CALIFICACION_ESTADISTICA (
  fchCalificacion,
  numHogaresCalificados,
  prmB1, varB1,
  prmB2, varB2,
  prmB3, varB3,
  prmB4, varB4,
  prmB5, varB5,
  prmB6, varB6,
  prmB7, varB7,
  prmB8, varB8,
  prmB9, varB9
  ) VALUES (
  '$fecha',
  $n,
  '$rowEstadisticaHogar[prmB1]', '$rowEstadisticaHogar[varB1]',
  '$rowEstadisticaHogar[prmB2]', '$rowEstadisticaHogar[varB2]',
  '$rowEstadisticaHogar[prmB3]', '$rowEstadisticaHogar[varB3]',
  '$rowEstadisticaHogar[prmB4]', '$rowEstadisticaHogar[varB4]',
  '$rowEstadisticaHogar[prmB5]', '$rowEstadisticaHogar[varB5]',
  '$rowEstadisticaHogar[prmB6]', '$rowEstadisticaHogar[varB6]',
  '$rowEstadisticaHogar[prmB7]', '$rowEstadisticaHogar[varB7]',
  '$rowEstadisticaHogar[prmB8]', '$rowEstadisticaHogar[varB8]',
  '$rowEstadisticaHogar[prmB9]', '$rowEstadisticaHogar[varB9]'
  )";



  mysql_query($qryGuardaEstadisticas);

//Después de el proximo calculo de promedios y desviación estandar, queda esta linea
$qryEstadisticaGeneral = "SELECT * FROM T_FRM_CALIFICACION_ESTADISTICA WHERE seqCalificacion = ( SELECT MAX( seqCalificacion ) FROM T_FRM_CALIFICACION_ESTADISTICA )";

//Después de el proximo calculo de promedios y desviación estandar, quitar esta linea
//$qryEstadisticaGeneral = "SELECT * FROM T_FRM_CALIFICACION_ESTADISTICA";

$exeEstadisticaGeneral = mysql_query($qryEstadisticaGeneral);
$rowEstadisticaGeneral = mysql_fetch_array($exeEstadisticaGeneral);

// RECORRIENDO HOGARES PARA GUARDAR EL VALOR ESTANDARIZADO
$queryEstadisticaHogar = "SELECT *
					FROM T_FRM_CALIFICACION_PLAN2 
					WHERE fchCalificacion = '" . $fecha . "'";

/* $queryEstadisticaHogar = "SELECT *
  FROM T_FRM_CALIFICACION_PLAN2
  WHERE fchCalificacion > '2014-01-01'"; */

$exeEstadisticaHogar = mysql_query($queryEstadisticaHogar);

while ($rowValHogar = mysql_fetch_array($exeEstadisticaHogar)) {

    // CALCULANDO EL VALOR ESTANDARIZADO
    $valZ1 = ($rowValHogar[valB1] - $rowEstadisticaGeneral['prmB1']) / $rowEstadisticaGeneral['varB1'];
    $valZ2 = ($rowValHogar[valB2] - $rowEstadisticaGeneral['prmB2']) / $rowEstadisticaGeneral['varB2'];
    $valZ3 = ($rowValHogar[valB3] - $rowEstadisticaGeneral['prmB3']) / $rowEstadisticaGeneral['varB3'];
    $valZ4 = ($rowValHogar[valB4] - $rowEstadisticaGeneral['prmB4']) / $rowEstadisticaGeneral['varB4'];
    $valZ5 = ($rowValHogar[valB5] - $rowEstadisticaGeneral['prmB5']) / $rowEstadisticaGeneral['varB5'];
    $valZ6 = ($rowValHogar[valB6] - $rowEstadisticaGeneral['prmB6']) / $rowEstadisticaGeneral['varB6'];
    $valZ7 = ($rowValHogar[valB7] - $rowEstadisticaGeneral['prmB7']) / $rowEstadisticaGeneral['varB7'];
    $valZ8 = ($rowValHogar[valB8] - $rowEstadisticaGeneral['prmB8']) / $rowEstadisticaGeneral['varB8'];
    $valZ9 = ($rowValHogar[valB9] - $rowEstadisticaGeneral['prmB9']) / $rowEstadisticaGeneral['varB9'];

    // APLICANDO LA FORMULA DE CALIFICACION

    $puntajeHogar = round(((($prcIH * $valZ1) + ($prcTDE * $valZ2) + ($prcANALF * $valZ3) + ($prcTamHogar * $valZ4) + ($prcHogMonop * $valZ5) + ($prcPropM14 * $valZ6) + ($prcPropMy60 * $valZ7) + ($prcPropDisc * $valZ8) + ($prcME * $valZ9))), 4);

    // Número e con exponente puntajeHogar
    $eIPj = exp($puntajeHogar);

    $transformada = round((100 * ($eIPj / (1 + $eIPj))), 6);

    $qryGuardaEstandar = "UPDATE T_FRM_CALIFICACION_PLAN2 SET 
							ziB1 = '$valZ1',
							ziB2 = '$valZ2',
							ziB3 = '$valZ3',
							ziB4 = '$valZ4',
							ziB5 = '$valZ5',
							ziB6 = '$valZ6',
							ziB7 = '$valZ7',
							ziB8 = '$valZ8',
							ziB9 = '$valZ9',
							valTotalCalificacion = '$puntajeHogar',
							valTransformado = $transformada
						WHERE seqFormulario = $rowValHogar[seqFormulario]
						AND fchCalificacion = '$fecha'
						";
    //echo $qryGuardaEstandar;
    mysql_query($qryGuardaEstandar);
}

print_r("<tr><td><br>Se han Calificado <b> $n </b> Hogares</td></tr>");
if ($ejecutaConsultaPersonalizada == 1) {
    if ($documentosNoPpalFormat != "") {
        print_r("<tr><td>Las c&eacute;dulas: <b> $documentosNoPpalFormat </b> no son postulantes principales</td></tr>");
    }
}
print_r("</table>");
?>