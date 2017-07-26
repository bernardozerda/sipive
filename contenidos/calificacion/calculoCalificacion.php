<?php
function calcularCalificacion($arraDatosActuales) {
    $claCalificacion = new calificacion();
     $arrayIndicadores = $claCalificacion->listarIndicadores();
    $resIndicadores = Array();
    foreach ($arraDatosActuales as $keyAct => $valueAct) {

        $calcEducacion = ($valueAct['aprobados'] / ($valueAct['cantMayor']));
        $educacion = 0;
        if ($calcEducacion < 9) {
            $educacion = 1;
        } else if ($valueAct['cantMayor'] == 0) {
            $educacion = 1;
        } else {
            $educacion = 0;
        }
        $calBle = ($claCalificacion->BLE * ($educacion * 100));
        $saludSubsidiados = 0;
        $saludSubsidiados = ($valueAct['afiliacion'] / $valueAct['cant']);
        $totalRSA = $claCalificacion->RSA * ($saludSubsidiados * 100);

        $cohabitacion = 0;
        if ($valueAct['cohabitacion'] > 1) {
            $cohabitacion = 1;
        }
        $totalCohabitacion = $claCalificacion->COH * ($cohabitacion * 100);

        $dormitorios = $valueAct['dormitorios'];
        $hacinamiento = 0;
        $calchacinamiento = 0;
        if ($dormitorios != 0) {
            $calchacinamiento = ($valueAct['cant'] / $dormitorios);
            if ($calchacinamiento >= 4) {
                $hacinamiento = 1;
            } else {
                $hacinamiento = 0;
            }
        } else
            $hacinamiento = 1;

        $totalHacinamiento = $claCalificacion->HACN * ($hacinamiento * 100);

        $ingresos = $valueAct['ingresos'] / $valueAct['cant'];
        $arrConfiguracion['constantes']['salarioMinimo'] . "/" . ($ingresos + 1000);
        $totalIngresos = ($arrConfiguracion['constantes']['salarioMinimo']) / ($ingresos + 1000);
        $totalIPC = ($claCalificacion->IPC * (100 * (1 - exp(-$totalIngresos / 52.05))));

        $dependenciaEcon = 0;
        $adultos = 0;
        if ($valueAct['adultos'] > 0) {
            $adultos = $valueAct['cant'] / $valueAct['adultos'];
        } else {
            $adultos = 3.5;
        }
        //echo "<br>".$value['aprobadosJefe']; 
        if ($adultos > 3 && $valueAct['aprobadosJefe'] <= 2) {
            $dependenciaEcon = 1;
        }
        $totalTDE = ($claCalificacion->TDE * ($dependenciaEcon * 100));

        $menores = $valueAct['cantMenores'] / $valueAct['cant'];
        $totalHN12 = ($claCalificacion->HN12 * ($menores * 100));
        $monoparentalFem = 0;

        $tipo = 0;
        if ($valueAct['mujerCabHogar'] == 1) {
            $tipo = 1;
        }
        if ($valueAct['mujerCabHogar'] == 1 && $valueAct['conyugueHogar'] == 0 && $valueAct['cantHijos'] > 0) {
            $monoparentalFem = 1;
        }
        $totalMCF = ($claCalificacion->MCF * ($monoparentalFem * 100));

        $cantAdultoMayor = $valueAct['cantadultoMayor'] / $valueAct['cant'];
        $totalHAMY = $claCalificacion->HAMY * ($cantAdultoMayor * 100);

        $discapacidad = $valueAct['cantCondEspecial'] / $valueAct['cant'];
        $totalCDISC = ($claCalificacion->CDISC * ($discapacidad * 100));

        $grupoEtnico = 0;
        if ($valueAct['condicionEtnica'] > 0) {
            $grupoEtnico = 1;
        }
        $totalHPGE = ($claCalificacion->HPGE * ($grupoEtnico * 100));

        $cantAdolecentes = $valueAct['adolecentes'] / $valueAct['cant'];

        $totalHN18 = ($claCalificacion->HN18 * ($cantAdolecentes * 100));

        $monoparentalMasc = 0;
        $tipo = 0;
        if ($valueAct['hombreCabHogar'] == 1) {
            $tipo = 2;
        }
        if ($valueAct['hombreCabHogar'] == 1 && $valueAct['conyugueHogar'] == 0 && $valueAct['cantHijos'] > 0) {
            $monoparentalMasc = 1;
        }
        $totalHCF = ($claCalificacion->HCF * ($monoparentalMasc * 100));


        $grupoLGTBI = 0;
        if ($valueAct['grupoLgtbi'] > 0) {
            $grupoLGTBI = 1;
        }
        $totalPLGTBI = ($claCalificacion->PLGTBI * ($grupoLGTBI * 100));

        $programa = 0;

        if ($valueAct['bolIntegracionSocial'] > 0 || $valueAct['bolSecMujer'] > 0 || $valueAct['bolIpes'] > 0) {
            $programa = 1;
        }
        if ($valueAct['bolSecMujer'] == "") {
            $valueAct['bolSecMujer'] = 0;
        }
        $totalPPGD = ($claCalificacion->PPGD * ($programa * 100));
        foreach ($arrayIndicadores as $keyIndicador => $valIndicador) {
            $indicador = $valIndicador['seqIndicador'];
            if ($indicador == 1) {
                $resIndicadores[$indicador] = $calBle;
            }
            if ($indicador == 2) {
                $resIndicadores[$indicador] = $totalRSA;
            }
            if ($indicador == 3) {
                $resIndicadores[$indicador] = $totalCohabitacion;
            }
            if ($indicador == 4) {
                $resIndicadores[$indicador] = $totalHacinamiento;
            }
            if ($indicador == 5) {
                $resIndicadores[$indicador] = $totalIPC;
            }
            if ($indicador == 6) {
                $resIndicadores[$indicador] = $totalTDE;
            }
            if ($indicador == 7) {
                $resIndicadores[$indicador] = $totalHN12;
            }
            if ($indicador == 8) {
                $resIndicadores[$indicador] = $totalMCF;
            }
            if ($indicador == 9) {
                $resIndicadores[$indicador] = $totalTDE;
            }
            if ($indicador == 10) {
                $resIndicadores[$indicador] = $totalCDISC;
            }
            if ($indicador == 11) {
                $resIndicadores[$indicador] = $totalHPGE;
            }
            if ($indicador == 12) {
                $resIndicadores[$indicador] = $totalHN18;
            }
            if ($indicador == 13) {
                $resIndicadores[$indicador] = $totalHCF;
            }
            if ($indicador == 14) {
                $resIndicadores[$indicador] = $totalPLGTBI;
            }
            if ($indicador == 15) {
                $resIndicadores[$indicador] = $totalPPGD;
            }
        }
        return $resIndicadores;
    }
}
