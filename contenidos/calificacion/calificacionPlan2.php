<?php

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
            $sql = "
              SELECT hog.seqFormulario         
              FROM t_frm_hogar hog 
              INNER JOIN t_ciu_ciudadano ciu ON hog.seqCiudadano = ciu.seqCiudadano 
              INNER JOIN t_frm_formulario frm on hog.seqFormulario = frm.seqFormulario
			  WHERE hog.seqParentesco = 1 
			    AND ciu.seqTipoDocumento IN (1, 2)
			    AND frm.seqPlanGobierno = 2
				AND ciu.numDocumento = " . $arrDocumentos[$numLinea];
            $qryPpal = $aptBd->execute($sql);
            $cuenta = $qryPpal->recordCount();
            $rowPpal = $qryPpal->fields;
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
$sql = "SELECT * FROM T_FRM_INDICADOR";
$qryPorcentajes = $aptBd->execute($sql);
while ($rowPorc = $qryPorcentajes->fields){
    if ($rowPorc['sigIndicador'] == 'IH'){
        $prcIH = $rowPorc['prcIndicador'];
    }
    if ($rowPorc['sigIndicador'] == 'TDE'){
        $prcTDE = $rowPorc['prcIndicador'];
    }
    if ($rowPorc['sigIndicador'] == 'ANALF'){
        $prcANALF = $rowPorc['prcIndicador'];
    }
    if ($rowPorc['sigIndicador'] == 'TamHogar'){
        $prcTamHogar = $rowPorc['prcIndicador'];
    }
    if ($rowPorc['sigIndicador'] == 'HogMonop'){
        $prcHogMonop = $rowPorc['prcIndicador'];
    }
    if ($rowPorc['sigIndicador'] == 'PropM14'){
        $prcPropM14 = $rowPorc['prcIndicador'];
    }
    if ($rowPorc['sigIndicador'] == 'PropMy60'){
        $prcPropMy60 = $rowPorc['prcIndicador'];
    }
    if ($rowPorc['sigIndicador'] == 'PropDisc'){
        $prcPropDisc = $rowPorc['prcIndicador'];
    }
    if ($rowPorc['sigIndicador'] == 'ME'){
        $prcME = $rowPorc['prcIndicador'];
    }
    $qryPorcentajes->MoveNext();
}

// HOGARES A CALIFICAR
if ($ejecutaConsultaPersonalizada == 1) {
    $qryHogar = "
        SELECT 
            frm.seqFormulario,
            frm.fchInscripcion,
            frm.fchUltimaActualizacion,
            frm.seqEstadoProceso,
            frm.seqModalidad
        FROM T_FRM_FORMULARIO frm
        INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
        INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
        WHERE frm.seqFormulario IN ($formulariosPpalFormat)
          AND hog.seqParentesco = 1
          AND frm.seqPlanGobierno = 2
          AND ciu.fchNacimiento <> '0000-00-00'
    ";
} else {
    $qryHogar = "
        SELECT 
            frm.seqFormulario,
            frm.fchInscripcion,
            frm.fchUltimaActualizacion,
            frm.seqEstadoProceso,
            frm.seqModalidad
        FROM T_FRM_FORMULARIO frm 
        INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
		INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
		WHERE frm.seqEstadoProceso IN (37)
		  AND frm.seqModalidad IN (6)
		  AND frm.seqTipoEsquema IN (1)
		  AND frm.seqParentesco = 1
		  AND frm.seqPlanGobierno = 2
		  AND ciu.fchNacimiento <> '0000-00-00'
	";
}

$exeQueryHogar = $aptBd->execute($qryHogar);
$cuentaHogares = $exeQueryHogar->recordCount();

if(intval($cuantosNoPpal) != 0){
    print_r("<span class='msgError'>Los siguientes documentos no son postulantes principales o no pertenecen al plan de gobierno \"Bogota Humana\": " . $documentosNoPpal);
    die();
}

// RECORRIENDO LOS MIEMBROS POR HOGAR
print_r("<table width='50%' align='center' cellpadding = '0' cellspacing = '0' border = '0'>");

$n = 0;
$valorPromedio = 0;
$sumaDesviacionEstandar = 0;
$valorDesviacionEstandar = 0;
$fecha = date('Y-m-d H:i:s');

while ($rowHogar = $exeQueryHogar->fields) {

    $qryCalifica = "
        SELECT 
            DISTINCT(f.seqFormulario),
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
        LEFT JOIN T_FRM_HOGAR h ON c.seqCiudadano = h.seqCiudadano
        LEFT JOIN T_FRM_FORMULARIO f ON h.seqFormulario = f.seqFormulario
        WHERE f.seqFormulario = " . $rowHogar['seqFormulario'];

    $exeCalifica = $aptBd->execute($qryCalifica);

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

    while ($rowCalifica = $exeCalifica->fields) { // INICIO RECORRIDO DE INTEGRANTES DEL HOGAR

        // Ingresos del Hogar (IH)
        $valTotalIngresos = $valTotalIngresos + $rowCalifica['valIngresos'];

        // Tasa de Analfabetismo / Bajo Nivel Educativo (ANALF)
        if ($rowCalifica['edad'] > 13 && $rowCalifica['seqNivelEducativo'] < 4) { // Personas Analfab May de 14 años
            $numAnalfa = $numAnalfa + 1;
        }
        if ($rowCalifica['edad'] > 13) { // Personas Mayores de 14 años en el Hogar
            $numMayores14 = $numMayores14 + 1;
        }

        // Tamaño del Hogar (TamHog)
        $TamHogar = $TamHogar + 1;

        // Jefatura Femenina / Masculina
        if ($rowCalifica['seqParentesco'] == 1 && $rowCalifica['seqSexo'] == 2) { // Jefe Hogar Mujer
            $flagJefeHogar = 2;
        } else if ($rowCalifica['seqParentesco'] == 1 && $rowCalifica['seqSexo'] == 1) { // Jefe Hogar Hombre
            $flagJefeHogar = 1;
        }
        if ($rowCalifica['seqParentesco'] == 2) { // Tiene Conyuge
            $flagConyuge = $flagConyuge + 1;
        }
        if ($rowCalifica['seqParentesco'] == 3) { // Tiene Hijos Menores
            $flagHijo = $flagHijo + 1;
        }
        if ($rowCalifica['seqParentesco'] != 1 && $rowCalifica['valIngresos'] > 0) { // Otro Integrante que Devengue
            $flagOtro = $flagOtro + 1;
        }

        // Niñez (PropM14) (OK)
        if ($rowCalifica['edad'] < 14) {
            $num_menores = $num_menores + 1;
        }

        // Menores de 15 (Menores de 15)
        if ($rowCalifica['edad'] < 15) {
            $num_menores15 = $num_menores15 + 1;
        }

        // Adultez (PropMy60) (OK)
        if ($rowCalifica['edad'] >= 60) {
            $num_mayores = $num_mayores + 1;
        }

        // Tasa de Dependencia Economica
        if ($rowCalifica['edad'] >= 15 && $rowCalifica['edad'] < 60) {
            $numNoDependiente = $numNoDependiente + 1;
        }

        // Discapacidad (PropDisc)
        if (($rowCalifica['seqCondicionEspecial'] == 3) || ($rowCalifica['seqCondicionEspecial2'] == 3) || ($rowCalifica['seqCondicionEspecial3'] == 3)) {
            $num_discapacidad = $num_discapacidad + 1;
        }

        // Minoria Etnica (ME)
        if ($rowCalifica['seqEtnia'] != 1) {
            $num_etnia = $num_etnia + 1;
        }

        // Identificando Hogar Monoparental
        if ($rowCalifica['seqParentesco'] == 1) {
            if (($rowCalifica['seqCondicionEspecial'] == 1) || ($rowCalifica['seqCondicionEspecial2'] == 1) || ($rowCalifica['seqCondicionEspecial3'] == 1)) {
                $autoMonoparental = 1;
            }
        }

        $exeCalifica->MoveNext();

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
    $sql = "SELECT * FROM T_FRM_VARIABLES WHERE seqIndicador = 1";
    $consultaIH = $aptBd->execute($sql);
    while ($rowIH = $consultaIH->fields) {
        if ($IH > $rowIH['numRango1'] && $IH <= $rowIH['numRango2']) {
            $valorIH = $rowIH['numValoracion'];
        }
        $consultaIH->MoveNext();
    }
    // Valor Equivalente TDE
    $sql = "SELECT * FROM T_FRM_VARIABLES WHERE seqIndicador = 2";
    $consultaTDE = $aptBd->execute($sql);
    while ($rowTDE = $consultaTDE->fields) {
        if ($TDE > $rowTDE['numRango1'] && $TDE <= $rowTDE['numRango2']) {
            $valorTDE = $rowTDE['numValoracion'];
        }
        $consultaTDE->MoveNext();
    }
    // Valor Equivalente ANALF
    $sql = "SELECT * FROM T_FRM_VARIABLES WHERE seqIndicador = 3";
    $consultaANALF = $aptBd->execute($sql);
    while ($rowANALF = $consultaANALF->fields) {
        if ($ANALF > $rowANALF['numRango1'] && $ANALF <= $rowANALF['numRango2']) {
            $valorANALF = $rowANALF['numValoracion'];
        }
        $consultaANALF->MoveNext();
    }
    // Valor Equivalente Hogar Monoparental
    $sql = "SELECT * FROM T_FRM_VARIABLES WHERE seqIndicador = 5";
    $consultaHogMonop = $aptBd->execute($sql);
    while ($rowHogMonop = $consultaHogMonop->fields) {
        if ($HogMonop > $rowHogMonop['numRango1'] && $HogMonop <= $rowHogMonop['numRango2']) {
            $valorHogMonop = $rowHogMonop['numValoracion'];
        }
        $consultaHogMonop->MoveNext();
    }
    // Valor Equivalente PropM14
    $sql = "SELECT * FROM T_FRM_VARIABLES WHERE seqIndicador = 6";
    $consultaPropM14 = $aptBd->execute($sql);
    while ($rowPropM14 = $consultaPropM14->fields) {
        if ($PropM14 > $rowPropM14[numRango1] && $PropM14 <= $rowPropM14[numRango2]) {
            $valorPropM14 = $rowPropM14[numValoracion];
        }
        $consultaPropM14->MoveNext();
    }
    // Valor Equivalente PropMy60
    $sql = "SELECT * FROM T_FRM_VARIABLES WHERE seqIndicador = 7";
    $consultaPropMy60 = $aptBd->execute($sql);
    while ($rowPropMy60 = $consultaPropMy60->fields) {
        if ($PropMy60 > $rowPropMy60['numRango1'] && $PropMy60 <= $rowPropMy60['numRango2']) {
            $valorPropMy60 = $rowPropMy60['numValoracion'];
        }
        $consultaPropMy60->MoveNext();
    }
    // Valor Equivalente Disc
    $sql = "SELECT * FROM T_FRM_VARIABLES WHERE seqIndicador = 8";
    $consultaPropDisc = $aptBd->execute($sql);
    while ($rowPropDisc = $consultaPropDisc->fields) {
        if ($PropDisc > $rowPropDisc['numRango1'] && $PropDisc <= $rowPropDisc['numRango2']) {
            $valorPropDisc = $rowPropDisc['numValoracion'];
        }
        $consultaPropDisc->MoveNext();
    }
    // Valor Minoría Etnica
    $sql = "SELECT * FROM T_FRM_VARIABLES WHERE seqIndicador = 9";
    $consultaME = $aptBd->execute($sql);
    while ($rowME = $consultaME->fields) {
        if ($ME > $rowME['numRango1'] && $ME <= $rowME['numRango2']) {
            $valorME = $rowME['numValoracion'];
        }
        $consultaME->MoveNext();
    }

    // GUARDANDO EN LA TABLA T_FRM_CALIFICACION
    $n = $n + 1;
    // Se insertan los nuevos valores de calificacion en la base de datos
    $qryCalifica = "
        INSERT INTO T_FRM_CALIFICACION_PLAN2 (
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
            valB9 
        ) VALUES (
            " . $rowHogar['seqFormulario'] . ",  
            '" . $rowHogar['fchUltimaActualizacion'] . "', 
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
            $valorME 
        )
    ";
    $aptBd->execute($qryCalifica);

    // Se actualiza el estado de proceso del formulario (53)
    if($ejecutaConsultaPersonalizada == 0){
        $qryUpdEstado = "
            UPDATE T_FRM_FORMULARIO SET 
                seqEstadoProceso = 53 
            WHERE seqFormulario = " . $rowHogar['seqFormulario'];
        $aptBd->execute($qryUpdEstado);
    }

    $exeQueryHogar->MoveNext();

}

// CALCULANDO PROMEDIOS Y DESVIACION ESTANDAR DEL TOTAL DE HOGARES POR ITEM DE CALIFICACION (ojo: sería bueno guardarlos en la tabla calificacion_estadisticas)
$qryEstadisticaHogar = "
    SELECT
      AVG(valB1) AS prmB1, SQRT(((VARIANCE(valB1))/(COUNT(*)-1)) * COUNT(*)) AS varB1,
      AVG(valB2) AS prmB2, SQRT(((VARIANCE(valB2))/(COUNT(*)-1)) * COUNT(*)) AS varB2,
      AVG(valB3) AS prmB3, SQRT(((VARIANCE(valB3))/(COUNT(*)-1)) * COUNT(*)) AS varB3,
      AVG(valB4) AS prmB4, SQRT(((VARIANCE(valB4))/(COUNT(*)-1)) * COUNT(*)) AS varB4,
      AVG(valB5) AS prmB5, SQRT(((VARIANCE(valB5))/(COUNT(*)-1)) * COUNT(*)) AS varB5,
      AVG(valB6) AS prmB6, SQRT(((VARIANCE(valB6))/(COUNT(*)-1)) * COUNT(*)) AS varB6,
      AVG(valB7) AS prmB7, SQRT(((VARIANCE(valB7))/(COUNT(*)-1)) * COUNT(*)) AS varB7,
      AVG(valB8) AS prmB8, SQRT(((VARIANCE(valB8))/(COUNT(*)-1)) * COUNT(*)) AS varB8,
      AVG(valB9) AS prmB9, SQRT(((VARIANCE(valB9))/(COUNT(*)-1)) * COUNT(*)) AS varB9
    FROM T_FRM_CALIFICACION_PLAN2
    WHERE fchCalificacion = '$fecha'
";

$exeEstadisticaHogar = $aptBd->execute($qryEstadisticaHogar);
$rowEstadisticaHogar = $exeEstadisticaHogar->fields;

// GUARDANDO PROMEDIOS Y VARIACION ESTANDAR DEL TOTAL DE HOGARES
$qryGuardaEstadisticas = "
    INSERT INTO T_FRM_CALIFICACION_ESTADISTICA (
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
    )
";
$aptBd->execute($qryGuardaEstadisticas);

//Después de el proximo calculo de promedios y desviación estandar, queda esta linea
$qryEstadisticaGeneral = "
  SELECT * 
  FROM T_FRM_CALIFICACION_ESTADISTICA 
  WHERE seqCalificacion = ( 
    SELECT MAX( seqCalificacion ) 
    FROM T_FRM_CALIFICACION_ESTADISTICA 
  )
";
$exeEstadisticaGeneral = $aptBd->execute($qryEstadisticaGeneral);
$rowEstadisticaGeneral = $exeEstadisticaGeneral->fields;

// RECORRIENDO HOGARES PARA GUARDAR EL VALOR ESTANDARIZADO
$queryEstadisticaHogar = "
  SELECT *
  FROM T_FRM_CALIFICACION_PLAN2 
  WHERE fchCalificacion = '" . $fecha . "'
";
$exeEstadisticaHogar = $aptBd->execute($queryEstadisticaHogar);
while ($rowValHogar = $exeEstadisticaHogar->fields) {

    // CALCULANDO EL VALOR ESTANDARIZADO
    $valZ1 = ($rowValHogar['valB1'] - $rowEstadisticaGeneral['prmB1']) / $rowEstadisticaGeneral['varB1'];
    $valZ2 = ($rowValHogar['valB2'] - $rowEstadisticaGeneral['prmB2']) / $rowEstadisticaGeneral['varB2'];
    $valZ3 = ($rowValHogar['valB3'] - $rowEstadisticaGeneral['prmB3']) / $rowEstadisticaGeneral['varB3'];
    $valZ4 = ($rowValHogar['valB4'] - $rowEstadisticaGeneral['prmB4']) / $rowEstadisticaGeneral['varB4'];
    $valZ5 = ($rowValHogar['valB5'] - $rowEstadisticaGeneral['prmB5']) / $rowEstadisticaGeneral['varB5'];
    $valZ6 = ($rowValHogar['valB6'] - $rowEstadisticaGeneral['prmB6']) / $rowEstadisticaGeneral['varB6'];
    $valZ7 = ($rowValHogar['valB7'] - $rowEstadisticaGeneral['prmB7']) / $rowEstadisticaGeneral['varB7'];
    $valZ8 = ($rowValHogar['valB8'] - $rowEstadisticaGeneral['prmB8']) / $rowEstadisticaGeneral['varB8'];
    $valZ9 = ($rowValHogar['valB9'] - $rowEstadisticaGeneral['prmB9']) / $rowEstadisticaGeneral['varB9'];

    // APLICANDO LA FORMULA DE CALIFICACION
    $puntajeHogar = round(((($prcIH * $valZ1) + ($prcTDE * $valZ2) + ($prcANALF * $valZ3) + ($prcTamHogar * $valZ4) + ($prcHogMonop * $valZ5) + ($prcPropM14 * $valZ6) + ($prcPropMy60 * $valZ7) + ($prcPropDisc * $valZ8) + ($prcME * $valZ9))), 4);

    // Número e con exponente puntajeHogar
    $eIPj = exp($puntajeHogar);

    $transformada = round((100 * ($eIPj / (1 + $eIPj))), 6);

    $qryGuardaEstandar = "
        UPDATE T_FRM_CALIFICACION_PLAN2 SET 
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
    $aptBd->execute($qryGuardaEstandar);

    $exeEstadisticaHogar->MoveNext();
}

print_r("<tr><td><br>Se han Calificado <b> $n </b> Hogares</td></tr>");
if ($ejecutaConsultaPersonalizada == 1) {
    if ($documentosNoPpalFormat != "") {
        print_r("<tr><td>Las c&eacute;dulas: <b> $documentosNoPpalFormat </b> no son postulantes principales</td></tr>");
    }
}
print_r("</table>");
?>