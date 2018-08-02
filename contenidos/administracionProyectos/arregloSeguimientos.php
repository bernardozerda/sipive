<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$arraDatosPoliza = $claDatosProy->obtenerDatosPoliza($seqProyecto);
$arrayLicencias = $claProyecto->obtenerListaLicencias($seqProyecto);
$arrConjuntoResidencial = $claDatosProy->obtenerConjuntoResidencial($seqProyecto);
$arrTipoVivienda = $claDatosProy->obtenerTipoVivienda($seqProyecto);
$arrCronogramaFecha = $claDatosProy->obteneCronograma($seqProyecto);

$arrOferentesProySeg = $claDatosProy->obtenerDatosOferenteProy($seqProyecto);
$arrayComiteActa = $claDatosProy->obtenerActasComite($seqProyecto);
$arrayFideicomitenteSeg = $claDatosProy->obtenerDatosFideicomiso($seqProyecto);





foreach ($_POST as $nombre_campo => $valor) {
    if (!is_array($valor)) {
        $arrayDatosProyNew[$seqProyecto][$nombre_campo] = $valor;
//        $array = array("seqPoliza");
////        if (in_array($nombre_campo, $array)) {
////            //  echo "<p> poliza " . $arrayDatosProyNew[$seqProyecto][$nombre_campo] . " " . $arraDatosPoliza[0][$nombre_campo] . "</p>";
////            $arrayDatosProyOld[$seqProyecto][$nombre_campo] = $arraDatosPoliza[0][$nombre_campo];
////        }
    } else {
        $nombre_campoNew = $nombre_campo;
        $nombre_campoNew = str_replace("fchVigenciaLicenciaUrbanismoHijo", "fchVigenciaLicencia1", $nombre_campoNew);
        $nombre_campoNew = str_replace("fchVigenciaLicenciaConstruccionHijo", "fchVigenciaLicencia2", $nombre_campoNew);
        $nombre_campoNew = str_replace("txtExpideLicenciaUrbanismo", "txtExpideLicencia1", $nombre_campoNew);
        $nombre_campoNew = str_replace("txtLicenciaUrbanismo", "txtLicencia1", $nombre_campoNew);
        $nombre_campoNew = str_replace("txtLicenciaConstruccion", "txtLicencia2", $nombre_campoNew);
        $nombre_campoNew = str_replace("seqProyectoLicenciaCons", "seqProyectoLicencia2", $nombre_campoNew);
        $nombre_campoNew = str_replace("seqProyectoLicenciaUrb", "seqProyectoLicencia1", $nombre_campoNew);
        $nombre_campoNew = str_replace("Hijo", "", $nombre_campoNew);
        $nombre_campoNew = str_replace("Construccion1", "2", $nombre_campoNew);
        $nombre_campoNew = str_replace("Urbanismo1", "1", $nombre_campoNew);
//        $nombre_campoNew = str_replace("Construccion1", "", $nombre_campoNew);

        foreach ($valor as $key => $value) {
            $arrayDatosProyNew[$seqProyecto][$nombre_campoNew . "_" . $key] = $value;
        }

        foreach ($arrOferentesProySeg as $keyOf => $valueOF) {

            if (isset($valueOF[$nombre_campo])) {
                //echo "<p>".$nombre_campo." = ".$valueOF[$nombre_campo]." key = ".$keyOf."</p>";
                $arrayDatosProyOld[$seqProyecto][$nombre_campo . "_" . $keyOf] = $valueOF[$nombre_campo];
            }
        }
        $indLic = 0;
        foreach ($arrayLicencias as $keyLic => $valueLic) {

            $valNombre = $nombre_campo == 'fchVigenciaLicencia1' ? 'fchVigenciaLicencia' : $nombre_campo;
            $keyLic = $nombre_campo == 'fchVigenciaLicencia1' ? ($keyLic + 1) : $keyLic;
            $valNombre = $nombre_campo == 'txtExpideLicencia1' ? 'txtExpideLicencia' : $nombre_campo;
            if ($valNombre == 'txtExpideLicencia' && $keyLic == 1) {
                $valNombre == "";
            }

            if (isset($valueLic[$valNombre])) {
                if ($nombre_campo . "_" . $keyLic != 'txtExpideLicencia_1') {
                    //  echo "<p>#####@@@@@@" . $nombre_campo . "_" . $keyLic . "=" . $valueLic[$valNombre] . "<p>";
                    $arrayDatosProyOld[$seqProyecto][$nombre_campo . "_" . $keyLic] = $valueLic[$valNombre];
                }
                $indLic++;
            }
        }
        $indConj = 0;
        foreach ($arrConjuntoResidencial as $keyConj => $valueConj) {
            $str = str_replace("Hijo", "", $nombre_campo);
            $str = str_replace("Urbanismo1", "1", $str);
            $str = str_replace("Construccion1", "1", $str);
            if (isset($valueConj[$str]) && $str != 'fchLicenciaProrroga' && $str != 'fchLicenciaProrroga1' && $str != 'fchLicenciaProrroga2') {
                $arrayDatosProyOld[$seqProyecto][$str . "_" . $indConj] = $valueConj[$str];

                if ($str == 'seqProyecto') {
                    $arraConjuntoLicenciasPadre = $claProyecto->obtenerListaLicenciasPadre($valueConj['seqProyecto']);
                    //PR($arraConjuntoLicenciasPadre);
                    $indSon = 0;
                    foreach ($arraConjuntoLicenciasPadre as $keySon => $valueSon) {
                        foreach ($valueSon as $keyHijo => $valueHijo) {
                            $seqTipoLicencia = $valueSon['seqTipoLicencia'];
                            if ($keyHijo != 'fchLicenciaProrroga' && $keyHijo != 'fchLicenciaProrroga1' && $keyHijo != 'fchLicenciaProrroga2' && $keyHijo != 'seqProyecto' && $keyHijo != 'fchEjecutoriaLicencia' && $keyHijo != 'seqTipoLicencia') {
                                if ($seqTipoLicencia == 2 && $keyHijo == 'txtExpideLicencia') {
                                    $keyHijo = 'txtExpideLicenciaAnulada';
                                }
                                if ($keyHijo != 'txtExpideLicenciaAnulada') {
                                    $arrayDatosProyOld[$seqProyecto][$keyHijo . "" . $seqTipoLicencia . "_" . $indConj] = $valueHijo;
                                }

                                // echo "<p>#####@@@@@@ ----" . $keyHijo . "" . ($valueSon['seqTipoLicencia']) . "_" . $indConj . " = " . $valueHijo . "<p>";
                            }
                        }
                    }
                    //PR($arraConjuntoLicenciasPadre);
                }


                $indConj++;
            }
        }


        $indVivienda = 0;
        foreach ($arrTipoVivienda as $keyVivienda => $valueVivienda) {

            if (isset($valueVivienda[$nombre_campoNew])) {
                $arrayDatosProyOld[$seqProyecto][$nombre_campoNew . "_" . $indVivienda] = $valueVivienda[$nombre_campoNew];
                $indVivienda++;
            }
        }
        foreach ($arraDatosPoliza as $keyPol => $valuePol) {
            if (isset($valuePol[$nombre_campo])) {
                $arrayDatosProyOld[$seqProyecto][$nombre_campo . "_" . $keyPol] = $valuePol[$nombre_campo];
            }
        }
        $indCom = 0;
        foreach ($arrayComiteActa as $keyCom => $valueCom) {
            if (isset($valueCom[$nombre_campo])) {
                //  echo "<p> @@@@" . $nombre_campo . " - " . $valueCom[$nombre_campo] . "@@@@</p>";
                $arrayDatosProyOld[$seqProyecto][$nombre_campo . "_" . $indCom] = $valueCom[$nombre_campo];
                $indCom++;
            }
        }
        // var_dump($arrayFideicomitenteSeg);
        foreach ($arrayFideicomitenteSeg as $keyFid => $valueFid) {
            if (isset($valueFid[$nombre_campo])) {
                // echo "<p> @@@@" . $nombre_campo . " - " . $valueFid[$nombre_campo] . "keyFid = ".$keyFid."@@@@</p>";
                $arrayDatosProyOld[$seqProyecto][$nombre_campo . "_" . $keyFid] = $valueFid[$nombre_campo];
                $indCom++;
            }
        }
    }
}

//pr($arrayDatosProyOld);
if (count($arrayDatosProyNew) > 0) {
    ksort($arrayDatosProyOld[$seqProyecto]);
    ksort($arrayDatosProyNew[$seqProyecto]);
} else {

    $resultBefore[0] = null;
    $resultAfter[0] = null;
}    