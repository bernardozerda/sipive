<?php
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );

include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "calificacion.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Encuestas.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );

$arrDocumentosArchivo = array();
if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
    $nombreArchivo = $_FILES['archivo']['tmp_name'];
    $lineas = file($nombreArchivo);
    foreach ($lineas as $linea_num => $linea) {
        $linea = str_replace("\n", "", $linea);
        $linea = str_replace("\r", "", $linea);
        $linea = str_replace("\t", " ", $linea);
        if (!empty($linea)) {
            array_push($arrDocumentosArchivo, trim($linea));
        }
    }
} else {
    exit('debe seleccionar un archivo. <img border="0" src="../lib/back.png" width="30" height="30" style="cursor: pointer" onClick="history.back()">Volver');
}


$claCalificacion = new calificacion();
$claEncuestas = new Encuestas();
$documento = implode(",", $arrDocumentosArchivo);
//header("Content-type: application/vnd.ms-excel; charset=UTF-8; name='excel'");
//header("Content-Disposition: filename=ficheroExcel.xls");
//header("Pragma: no-cache");
//header("Expires: 0");


$formularios = $claCalificacion->obtenerFormulario($documento);
?>
<table border="1">
    <tr>
        <th>Hogar</th>
        <th>Miembros Encuesta</th>
        <th>Miembros Sipive</th>
        <th>Cant Miembros<br>Encuesta</th>
        <th>Cant Miembros<br>Sipive</th>
        <th>Reg. Salud<br>Encuesta</th>
        <th>Reg. Salud<br>Sipive</th>
        <th>Cal. Salud<br>Encuesta</th>
        <th>Cal. Salud<br>Sipive</th>
        <th>Discapacidad<br>Encuesta</th>
        <th>Discapacidad<br>Sipive</th>
        <th>Cal. Discapacidad<br>Encuesta</th>
        <th>Cal. Discapacidad<br>Sipive</th>
        <th>Cond. Etnica<br>Encuesta</th>
        <th>Cond. Etnica<br>Sipive</th>
        <th>Cal. Etnia<br>Encuesta</th>
        <th>Cal. Etnia<br>Sipive</th>
        <th>Ingresos<br>Encuesta</th>
        <th>Ingresos<br> Sipive</th>
        <th>Cal. Ingresos<br>Encuesta</th>
        <th>Cal. Ingresos<br>Sipive</th>
        <th>Cohabitaci&oacute;n<br>Encuesta</th>
        <th>Cohabitaci&oacute;n<br> Sipive</th>
        <th>Cal. Cohabitaci&oacute;n<br>Encuesta</th>
        <th>Cal. Cohabitaci&oacute;n<br>Sipive</th>        
        <th>Hacinamiento<br>Encuesta</th>
        <th>Hacinamiento<br> Sipive</th>
        <th>Cal. Hacinamiento<br>Encuesta</th>
        <th>Cal. Hacinamiento<br>Sipive</th>  
        <th>Cal. Bajo Logro Edu<br>Encuesta</th>
        <th>Cal. Bajo Logro Edu<br>Sipive</th>  
        <th>Cal. Alta Dependencia Economica<br>Encuesta</th>
        <th>Cal. Alta Dependencia Economica<br>Sipive</th>
        <th>Hogar con Menores12<br>Encuesta</th>
        <th>Hogar con Menores12<br> Sipive</th>
        <th>Cal. Hogar con Menores12<br>Encuesta</th>
        <th>Cal. Hogar con Menores12<br>Sipive</th>
        <th>Cal. Mujer Cab. Hogar<br>Encuesta</th>
        <th>Cal. Mujer Cab. Hogar<br>Sipive</th>          
        <th>Cal. Adulto Mayor<br>Encuesta</th>
        <th>Cal. Adulto Mayor<br>Sipive</th>         
        <th>Cal. Adulto Adolescentes<br>Encuesta</th>
        <th>Cal. Adulto Adolescentes<br>Sipive</th> 
        <th>Cal. Hombre Cab. Hogar<br>Encuesta</th>
        <th>Cal. Hombre Cab. Hogar<br>Sipive</th>        
        <th>Cal. LGTBI<br>Encuesta</th>
        <th>Cal. LGTBI<br>Sipive</th>        
        <th>Cal. Programas<br>Encuesta</th>
        <th>Cal. Programas<br>Sipive</th>  
        <th>Cal. reconocimiento FP<br>Encuesta</th>
        <th>Cal. reconocimiento FP<br>Sipive</th> 
        <th>Calificaci&oacute;n<br>Encuesta</th>
        <th>Calificaci&oacute;n<br>Sipive</th>
    </tr>

    <?php
    $totalcalBle = 0;
    $totalRSA = 0;
    $totalCohabitacion = 0;
    $totalHacinamiento = 0;
    $totalIngresos = 0;
    $totalIPC = 0;
    $totalTDE = 0;
    $arrayIndicadores = $claCalificacion->listarIndicadores();
    $arrayDatosEncuentas = Array();
    foreach ($formularios as $keyF => $valueF) {

        $arrayDatosEncuentas = Array();
        $arrayDatosEncuentas = $claEncuestas->obtenerVariablesCalificacion($valueF['numDocumento']);

        //if ($arrayDatosEncuentas['errores'][0] != "") {
        $datosCal = $claCalificacion->obtenerDatosCalificacion(true, $valueF['seqFormulario'], false);
        $puntajeCal = $claCalificacion->datosUltimaCalificacion($valueF['seqFormulario']);
        $totalCalSipive = $claCalificacion->datosSumaTotalCalificacion($valueF['seqFormulario']);

        $cantMiembros = '';

        $cantMiembros = $arrayDatosEncuentas['variables']['cant'];
        $ingresos = '$' . number_format($arrayDatosEncuentas['variables']['ingresos'], 0, '.', ',');
        $style = 'color: #000; text-align: center; font-weight:bold;';

        $calcEducacion = ($arrayDatosEncuentas['variables']['aprobados'] / ($arrayDatosEncuentas['variables']['cantMayor']));
        $educacion = 0;
        if ($calcEducacion < 9) {
            $educacion = 1;
        } else if ($arrayDatosEncuentas['variables']['cantMayor'] == 0) {
            $educacion = 1;
        } else {
            $educacion = 0;
        }
        $totalcalBle = ($claCalificacion->BLE * ($educacion * 100));
        $saludSubsidiados = 0;
        $saludSubsidiados = ($arrayDatosEncuentas['variables']['afiliacion'] / $arrayDatosEncuentas['variables']['cant']);
        $totalRSA = $claCalificacion->RSA * ($saludSubsidiados * 100);

        $cohabitacion = 0;
        if ($arrayDatosEncuentas['variables']['cohabitacion'] > 1) {
            $cohabitacion = 1;
        }
        $totalCohabitacion = $claCalificacion->COH * ($cohabitacion * 100);

        $dormitorios = $arrayDatosEncuentas['variables']['dormitorios'];
        $hacinamiento = 0;
        $calchacinamiento = 0;
        if ($dormitorios != 0) {
            $calchacinamiento = ($arrayDatosEncuentas['variables']['cant'] / $dormitorios);
            if ($calchacinamiento >= 4) {
                $hacinamiento = 1;
            } else {
                $hacinamiento = 0;
            }
        } else
            $hacinamiento = 1;

        $totalHacinamiento = $claCalificacion->HACN * ($hacinamiento * 100);

        $ingresos = $arrayDatosEncuentas['variables']['ingresos'] / $arrayDatosEncuentas['variables']['cant'];
        $arrConfiguracion['constantes']['salarioMinimo'] . "/" . ($ingresos + 1000);
        $totalIngresos = ($arrConfiguracion['constantes']['salarioMinimo']) / ($ingresos + 1000);
        $totalIPC = ($claCalificacion->IPC * (100 * (1 - exp(-$totalIngresos / 52.05))));

        $dependenciaEcon = 0;
        $adultos = 0;
        if ($arrayDatosEncuentas['variables']['adultos'] > 0) {
            $adultos = $arrayDatosEncuentas['variables']['cant'] / $arrayDatosEncuentas['variables']['adultos'];
        } else {
            $adultos = 3.5;
        }
        //echo "<br>".$value['aprobadosJefe']; 
        if ($adultos > 3 && $arrayDatosEncuentas['variables']['aprobadosJefe'] <= 2) {
            $dependenciaEcon = 1;
        }
        $totalTDE = ($claCalificacion->TDE * ($dependenciaEcon * 100));

        $menores = $arrayDatosEncuentas['variables']['cantMenores'] / $arrayDatosEncuentas['variables']['cant'];
        $totalHN12 = ($claCalificacion->HN12 * ($menores * 100));
        $monoparentalFem = 0;

        $tipo = 0;
        if ($arrayDatosEncuentas['variables']['mujerCabHogar'] == 1) {
            $tipo = 1;
        }
        if ($arrayDatosEncuentas['variables']['mujerCabHogar'] == 1 && $arrayDatosEncuentas['variables']['conyugueHogar'] == 0 && $arrayDatosEncuentas['variables']['cantHijos'] > 0) {
            $monoparentalFem = 1;
        }
        $totalMCF = ($claCalificacion->MCF * ($monoparentalFem * 100));

        $cantAdultoMayor = $arrayDatosEncuentas['variables']['cantadultoMayor'] / $arrayDatosEncuentas['variables']['cant'];
        $totalHAMY = $claCalificacion->HAMY * ($cantAdultoMayor * 100);

        $discapacidad = $arrayDatosEncuentas['variables']['cantCondEspecial'] / $arrayDatosEncuentas['variables']['cant'];
        $totalCDISC = ($claCalificacion->CDISC * ($discapacidad * 100));

        $grupoEtnico = 0;
        if ($arrayDatosEncuentas['variables']['condicionEtnica'] > 0) {
            $grupoEtnico = 1;
        }
        $totalHPGE = ($claCalificacion->HPGE * ($grupoEtnico * 100));

        $cantAdolecentes = $arrayDatosEncuentas['variables']['adolecentes'] / $arrayDatosEncuentas['variables']['cant'];

        $totalHN18 = ($claCalificacion->HN18 * ($cantAdolecentes * 100));

        $monoparentalMasc = 0;
        $tipo = 0;
        if ($arrayDatosEncuentas['variables']['hombreCabHogar'] == 1) {
            $tipo = 2;
        }
        if ($arrayDatosEncuentas['variables']['hombreCabHogar'] == 1 && $arrayDatosEncuentas['variables']['conyugueHogar'] == 0 && $arrayDatosEncuentas['variables']['cantHijos'] > 0) {
            $monoparentalMasc = 1;
        }
        $totalHCF = ($claCalificacion->HCF * ($monoparentalMasc * 100));


        $grupoLGTBI = 0;
        $totalPLGTBI = 0;
        if ($arrayDatosEncuentas['variables']['grupoLgtbi'] > 0) {
            $grupoLGTBI = 1;
        }
        $totalPLGTBI = ($claCalificacion->PLGTBI * ($grupoLGTBI * 100));

        $programa = 0;

        if ($arrayDatosEncuentas['variables']['bolIntegracionSocial'] > 0 || $arrayDatosEncuentas['variables']['bolSecMujer'] > 0 || $arrayDatosEncuentas['variables']['bolIpes'] > 0) {
            $programa = 1;
        }
        if ($arrayDatosEncuentas['variables']['bolSecMujer'] == "") {
            $arrayDatosEncuentas['variables']['bolSecMujer'] = 0;
        }

        $totalPPGD = ($claCalificacion->PPGD * ($programa * 100));

        if ($arrayDatosEncuentas['variables']['bolReconocimientoFP'] > 0) {
            $bolRFP = 1;
        }
        $totalRFPB = $claCalificacion->RFPB * ($bolRFP * 100);

        $totalCalEnc = $totalPPGD + $totalPLGTBI + $totalHCF + $totalHN18 + $totalHPGE + $totalCDISC + $totalHAMY + $totalMCF + $totalHN12 + $totalTDE + $totalIPC + $totalHacinamiento + $totalCohabitacion + $totalRSA + $totalcalBle + $totalRFPB;
        ?> 
        <tr>
            <td><?php echo $valueF['seqFormulario'] ?></td>
            <td>
                <?php foreach ($arrayDatosEncuentas['variables']['edades'] as $keyMiembros => $valueMiembros) { ?>
                    <?php echo $keyMiembros ?> - <?php echo utf8_decode($arrayDatosEncuentas['variables']['nombres'][$keyMiembros]) ?>- <?php echo $arrayDatosEncuentas['variables']['edades'][$keyMiembros] ?><br>

                <?php } ?>
            </td>
            <td>
                <?php
                foreach ($datosCal as $keyCal => $valueCal) {
                    $hog = str_replace(",", "<br>", $valueCal['edades']);
                    if ($arrayDatosEncuentas['variables']['cant'] != $valueCal['cant']) {
                        $style = 'color: red; text-align: center; font-weight:bold; ';
                    }
                    //$cantMiembros .= $valueCal['cant'];
                    //$ingresos .= ;
                    ?>
                    <?php echo utf8_decode($hog); ?> <br>

                <?php } ?>
            </td>
            <td style="<?php echo $style ?>"><?php echo $cantMiembros ?></td>
            <td style="<?php echo $style ?>"><?php echo $valueCal['cant'] ?></td>
            <td><?php echo $arrayDatosEncuentas['variables']['afiliacion'] ?></td>
            <td><?php echo $valueCal['afiliacion'] ?></td>             
            <td><?php echo number_format($totalRSA, 3, '.', ',') ?></td>
            <td><?php echo number_format($puntajeCal[1]['total'], 3, '.', ',') ?></td>

            <td><?php echo $arrayDatosEncuentas['variables']['cantCondEspecial'] ?></td>
            <td><?php echo $valueCal['cantCondEspecial'] ?></td>             
            <td><?php echo number_format($totalCDISC, 3, '.', ',') ?></td>
            <td><?php echo number_format($puntajeCal[9]['total'], 3, '.', ',') ?></td>

            <td><?php echo $arrayDatosEncuentas['variables']['condicionEtnica'] ?></td>
            <td><?php echo $valueCal['condicionEtnica'] ?></td>             
            <td><?php echo number_format($totalHPGE, 3, '.', ',') ?></td>
            <td><?php echo number_format($puntajeCal[10]['total'], 3, '.', ',') ?></td>

            <td><?php echo $arrayDatosEncuentas['variables']['ingresos'] ?></td>
            <td><?php echo $valueCal['ingresos'] ?></td>
            <td><?php echo number_format($totalIPC, 3, '.', ',') ?></td>
            <td><?php echo number_format($puntajeCal[4]['total'], 3, '.', ',') ?></td>

            <td><?php echo $arrayDatosEncuentas['variables']['cohabitacion'] ?></td>
            <td><?php echo $valueCal['cohabitacion'] ?></td>
            <td><?php echo number_format($totalCohabitacion, 3, '.', ',') ?></td>
            <td><?php echo number_format($puntajeCal[2]['total'], 3, '.', ',') ?></td>

            <td><?php echo $arrayDatosEncuentas['variables']['dormitorios'] ?></td>
            <td><?php echo $valueCal['dormitorios'] ?></td>
            <td><?php echo number_format($totalHacinamiento, 3, '.', ',') ?></td>
            <td><?php echo number_format($puntajeCal[3]['total'], 3, '.', ',') ?></td>

            <td><?php echo number_format($totalcalBle, 3, '.', ',') ?></td>
            <td><?php echo number_format($puntajeCal[0]['total'], 3, '.', ',') ?></td>

            <td><?php echo number_format($totalTDE, 3, '.', ',') ?></td>
            <td><?php echo number_format($puntajeCal[5]['total'], 3, '.', ',') ?></td>

            <td><?php echo $arrayDatosEncuentas['variables']['cantMenores'] ?></td>
            <td><?php echo $valueCal['cantMenores'] ?></td>
            <td><?php echo number_format($totalHN12, 3, '.', ',') ?></td>
            <td><?php echo number_format($puntajeCal[6]['total'], 3, '.', ',') ?></td>

            <td><?php echo number_format($totalMCF, 3, '.', ',') ?></td>
            <td><?php echo number_format($puntajeCal[7]['total'], 3, '.', ',') ?></td>

            <td><?php echo number_format($totalHAMY, 3, '.', ',') ?></td>
            <td><?php echo number_format($puntajeCal[8]['total'], 3, '.', ',') ?></td>

            <td><?php echo number_format($totalHN18, 3, '.', ',') ?></td>
            <td><?php echo number_format($puntajeCal[11]['total'], 3, '.', ',') ?></td>

            <td><?php echo number_format($totalHCF, 3, '.', ',') ?></td>
            <td><?php echo number_format($puntajeCal[12]['total'], 3, '.', ',') ?></td>

            <td><?php echo number_format($totalPLGTBI, 3, '.', ',') ?></td>
            <td><?php echo number_format($puntajeCal[13]['total'], 3, '.', ',') ?></td>

            <td><?php echo number_format($totalPPGD, 3, '.', ',') ?></td>
            <td><?php echo number_format($puntajeCal[14]['total'], 3, '.', ',') ?></td>

            <td><?php echo number_format($totalRFPB, 3, ',', '') ?>%</td>
            <td><?php echo number_format($puntajeCal[15]['total'], 3, ',', '') ?>%</td>
            +
            <td><?php echo number_format($totalCalEnc, 3, ',', '') ?>%</td>
            <td><?php echo number_format($totalCalSipive, 3, ',', '') ?>%</td>


        </tr>
        <!-- <?php //} else {     ?>
             <tr>
                 <th colspan="49" style="text-align: left"><?php echo $arrayDatosEncuentas['errores'][0] ?></th>
             </tr>
        <?php //} ?>-->
    <?php } ?>
    <?php
    ?>
</table>