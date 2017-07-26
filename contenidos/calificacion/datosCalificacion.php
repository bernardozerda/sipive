<?php
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "calificacion.class.php" );


$claCalificacion = new calificacion();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$arrayIndicadores = $claCalificacion->listarIndicadores();

include './calculoCalificacion.php';
$formularios = $claCalificacion->obtenerFormulario($_POST['documento']);

$doc = "";
foreach ($formularios as $keyF => $valueF) {
    $doc .= $valueF['seqFormulario'];
}

if ($doc == "") {
    echo "Este documento no se encuentra afiliado a un formulario por favor rectificar el número";
    die();
}
$arrayCalificacion = $claCalificacion->datosUltimaCalificacion($doc);
$arraySalud = $claCalificacion->obtenerDatosSalud();

$ejecutaConsultaPersonalizada = true;
$arraDatosActuales = $claCalificacion->obtenerDatosCalificacion($ejecutaConsultaPersonalizada, $doc, false);

$array = calcularCalificacion($arraDatosActuales);

$claCalificacion->obtenerValorIndicadores();
$calBle = 0;
$totalRSA = 0;
$totalCohabitacion;
$totalHacinamiento = 0;
$totalIPC = 0;
$totalTDE = 0;
$totalHN12 = 0;
$totalMCF = 0;
$totalHAMY = 0;
$totalCDISC = 0;
$totalHPGE = 0;
$totalHN18 = 0;
$totalHCF = 0;
$totalPLGTBI = 0;
$totalPPGD = 0;
$ingresos1 = 0;
$miembros1 = 0;
$totalUltCal =0;

//var_dump($arraDatosActuales);
if ($arrayIndicadores) {
    $cont = 0;
    ?>
    <table>
        <tr>
            <td>
                <table class="table table-striped table-bordered" style="width: 85%; text-align: center">
                    <tr>
                        <th colspan="4">Datos Hogar En SIPIVE</th>
                    </tr>

                    <?php if ($arraDatosActuales) { ?>
                        <?php
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
                            ?>
                            <tr>
                                <th>Miembros de Hogar</th>
                                <td><?php echo $valueAct['cant'] ?></td>
                                <th>Ingresos</th>
                                <td><?php echo $valueAct['ingresos'] ?></td>
                            </tr>
                            <tr>
                                <th>Miembros Mayores de edad</th>
                                <td><?php echo $valueAct['cantMayor'] ?></td>            
                                <th>Miembros Adultos entre 15 y 60 años </th>
                                <td><?php echo $valueAct['adultos'] ?></td>
                            </tr>
                            <tr>
                                <th>Años Aprobados Jefe </th>
                                <td><?php echo $valueAct['aprobadosJefe'] ?></td>           
                                <th>Años Aprobados Miembros </th>
                                <td><?php echo $valueAct['aprobados'] ?></td>
                            </tr>
                            <tr>
                                <th>Afiliación Salud</th>
                                <td><?php echo $valueAct['afiliacion'] ?></td>           
                                <th>cohabitacion</th>
                                <td><?php echo $valueAct['cohabitacion'] ?></td>
                            </tr>
                            <tr>
                                <th>Camtidad Menores </th>
                                <td><?php echo $valueAct['cantMenores'] ?></td>            
                                <th>Hijos</th>
                                <td><?php echo $valueAct['cantHijos'] ?></td>
                            </tr>
                            <tr>
                                <th>mujer Cabeza de Hogar</th>
                                <td><?php echo $valueAct['mujerCabHogar'] ?></td>            
                                <th>Conyugue</th>
                                <td><?php echo $valueAct['conyugueHogar'] ?></td>
                            </tr>
                            <tr>
                                <th>Cant Adulto Mayor</th>
                                <td><?php echo $valueAct['cantadultoMayor'] ?></td>           
                                <th>Cant Condicion Especial</th>
                                <td><?php echo $valueAct['cantCondEspecial'] ?></td>
                            </tr>
                            <tr>
                                <th>Condicion Etnica</th>
                                <td><?php echo $valueAct['condicionEtnica'] ?></td>            
                                <th>Adolecentes</th>
                                <td><?php echo $valueAct['adolecentes'] ?></td>
                            </tr>
                            <tr>
                                <th>hombre Cabeza de Hogar</th>
                                <td><?php echo $valueAct['hombreCabHogar'] ?></td>
                                <th>Grupo Lgtbi</th>
                                <td><?php echo $valueAct['grupoLgtbi'] ?></td>
                            </tr>
                            <tr>
                                <th>bolIntegracionSocial</th>
                                <td><?php echo $valueAct['bolIntegracionSocial'] ?></td>
                                <th>bolSecEducacion</th>
                                <td><?php echo $valueAct['bolSecEducacion'] ?></td>
                            </tr>
                            <tr>
                                <th>bolSecMujer</th>
                                <td><?php echo $valueAct['bolSecMujer'] ?></td>
                                <th>bolSecSalud</th>
                                <td><?php echo $valueAct['bolSecSalud'] ?></td>
                            </tr>
                            <tr>
                                <th>bolAltaCon</th>
                                <td><?php echo $valueAct['bolAltaCon'] ?></td>
                                <th>bolAltaCon</th>
                                <td><?php echo $valueAct['bolAltaCon'] ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
            </td>
            <td>
                <table class="table table-striped table-bordered" style="width: 85%; text-align: center">
                    <tr>
                        <th colspan="4">Valores Nuevos</th>
                    </tr>
                    <?php if ($arraDatosActuales) { ?>
                        <?php foreach ($arraDatosActuales as $keyAct => $valueAct) { ?>
                            <tr>
                                <th>Miembros de Hogar</th>
                                <td><input id="cant"  name="cant" value="<?php echo $valueAct['cant'] ?>" size="3"/></td>
                                <th>Ingresos</th>
                                <td><input name="ingresos" id="ingresos" value="<?php echo $valueAct['ingresos'] ?>" size="10"/></td>
                            </tr>
                            <tr>
                                <th>Miembros Mayores de edad</th>
                                <td><input name="cantMayor" id="cantMayor" value="<?php echo $valueAct['cantMayor'] ?>" size="3"/></td>            
                                <th>Miembros Adultos entre 15 y 60 años </th>
                                <td><input name="adultos" id="adultos" value="<?php echo $valueAct['adultos'] ?>" size="3"/></td>
                            </tr>
                            <tr>
                                <th>Años Aprobados Jefe </th>
                                <td><input name="aprobadosJefe" id="aprobadosJefe" value="<?php echo $valueAct['aprobadosJefe'] ?>" size="3"/></td>           
                                <th>Años Aprobados Miembros </th>
                                <td><input name="aprobados" id="aprobados" value="<?php echo $valueAct['aprobados'] ?>" size="3"/></td>
                            </tr>
                            <tr>
                                <th>Afiliación Salud</th>
                                <td>
                                    <select id="afiliacion" name="afiliacion" >

                                        <?php
                                        foreach ($arraySalud as $keySalud => $valueSalud) {

                                            $txtSalud = explode('(', $valueSalud['txtSalud']);
                                            if (count($txtSalud) > 0) {
                                                $txtSalud = $txtSalud[0];
                                            } else {
                                                $txtSalud = $valueSalud['txtSalud'];
                                            }
                                            ?>
                                            <option value="<?php echo $valueSalud['seqSalud'] ?>" size="3" <?php if ($valueAct['afiliacion'] == $valueSalud['seqSalud']) echo 'selected' ?>><?php echo $txtSalud ?></option>
                                        <?php } ?>
                                    </select>
                                </td>           
                                <th>cohabitacion</th>
                                <td><input id="cohabitacion" name="cohabitacion" value="<?php echo $valueAct['cohabitacion'] ?>" size="3"/></td>
                            </tr>
                            <tr>
                                <th>Cantidad Menores </th>
                                <td><input name="cantMenores" id="cantMenores" value="<?php echo $valueAct['cantMenores'] ?>" size="3"/></td>            
                                <th>Hijos</th>
                                <td><input name="cantHijos" id="cantHijos" value="<?php echo $valueAct['cantHijos'] ?>" size="3"/></td>
                            </tr>
                            <tr>
                                <th>mujer Cabeza de Hogar</th>
                                <td><input id="" name="" value="<?php echo $valueAct['mujerCabHogar'] ?>" size="3"/></td>            
                                <th>Conyugue</th>
                                <td><?php echo $valueAct['conyugueHogar'] ?></td>
                            </tr>
                            <tr>
                                <th>Cant Adulto Mayor</th>
                                <td><?php echo $valueAct['cantadultoMayor'] ?></td>           
                                <th>Cant Condicion Especial</th>
                                <td><?php echo $valueAct['cantCondEspecial'] ?></td>
                            </tr>
                            <tr>
                                <th>Condicion Etnica</th>
                                <td><?php echo $valueAct['condicionEtnica'] ?></td>            
                                <th>Adolecentes</th>
                                <td><?php echo $valueAct['adolecentes'] ?></td>
                            </tr>
                            <tr>
                                <th>hombre Cabeza de Hogar</th>
                                <td><?php echo $valueAct['hombreCabHogar'] ?></td>
                                <th>Grupo Lgtbi</th>
                                <td><?php echo $valueAct['grupoLgtbi'] ?></td>
                            </tr>
                            <tr>
                                <th>bolIntegracionSocial</th>
                                <td><?php echo $valueAct['bolIntegracionSocial'] ?></td>
                                <th>bolSecEducacion</th>
                                <td><?php echo $valueAct['bolSecEducacion'] ?></td>
                            </tr>
                            <tr>
                                <th>bolSecMujer</th>
                                <td><?php echo $valueAct['bolSecMujer'] ?></td>
                                <th>bolSecSalud</th>
                                <td><?php echo $valueAct['bolSecSalud'] ?></td>
                            </tr>
                            <tr>
                                <th>bolAltaCon</th>
                                <td><?php echo $valueAct['bolAltaCon'] ?></td>
                                <th>bolAltaCon</th>
                                <td><?php echo $valueAct['bolAltaCon'] ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
            </td>
        </tr>
    </table>

    <table class="table table-striped table-bordered" style="width: 85%; text-align: left">
        <tr>
            <td></td>
            <th>Valor Calificación</th>
            <th>total sistema</th>
        </tr>
        <tr style="text-align: center">
            <th>Indicador</th>
            <th>Cantidad</th>           
            <th>Total</th>
        </tr>
        <?php foreach ($arrayIndicadores as $key => $value) {
                                                                  

            ?>
            <tr>
                <td><?php echo $value['txtIndicador'] ?></td>
                <?php if ($arrayCalificacion) { 
     //var_dump($arrayCalificacion);
                    ?>
                    <?php
                    foreach ($arrayCalificacion as $keyCal => $valueCal) {
                        echo $valueCal['total'];
                        $totalUltCal += $valueCal['total'];
                        $ingresos = $valueCal['totalIngresos'];
                        $miembros = $valueCal['cantMiembrosHogar'];
                        ?>
                        <?php if ($valueCal['seqIndicador'] == $value['seqIndicador']) { ?>
                            <td style="text-align: center"><?php echo $valueCal['cantidadMiembros'] ?></td>                                            
                            <td style="text-align: center"><?php echo $valueCal['total'] ?></td>

                        <?php } ?>
                    <?php } ?>
                    <?php if ($value['seqIndicador'] == 1) { ?>
                        <td style="text-align: center"><?php echo $calBle ?></td>
                    <?php } ?>
                    <?php if ($value['seqIndicador'] == 2) { ?>
                        <td style="text-align: center"><?php echo $totalRSA ?></td>
                    <?php } ?>
                    <?php if ($value['seqIndicador'] == 3) { ?>
                        <td style="text-align: center"><?php echo $totalCohabitacion ?></td>
                    <?php } ?>
                    <?php if ($value['seqIndicador'] == 4) { ?>
                        <td style="text-align: center"><?php echo $totalHacinamiento ?></td>
                    <?php } ?>
                    <?php if ($value['seqIndicador'] == 5) { ?>
                        <td style="text-align: center"><?php echo $totalIPC ?></td>
                    <?php } ?>
                    <?php if ($value['seqIndicador'] == 6) { ?>
                        <td style="text-align: center"><?php echo $totalTDE ?></td>
                    <?php } ?>
                    <?php if ($value['seqIndicador'] == 7) { ?>
                        <td style="text-align: center"><?php echo $totalHN12 ?></td>
                    <?php } ?>
                    <?php if ($value['seqIndicador'] == 8) { ?>
                        <td style="text-align: center"><?php echo $totalMCF ?></td>
                    <?php } ?>
                    <?php if ($value['seqIndicador'] == 9) { ?>
                        <td style="text-align: center"><?php echo $totalHAMY ?></td>
                    <?php } ?>
                    <?php if ($value['seqIndicador'] == 10) { ?>
                        <td style="text-align: center"><?php echo $totalCDISC ?></td>
                    <?php } ?>
                    <?php if ($value['seqIndicador'] == 11) { ?>
                        <td style="text-align: center"><?php echo $totalHPGE ?></td>
                    <?php } ?>
                    <?php if ($value['seqIndicador'] == 12) { ?>
                        <td style="text-align: center"><?php echo $totalHN18 ?></td>
                    <?php } ?>
                    <?php if ($value['seqIndicador'] == 13) { ?>
                        <td style="text-align: center"><?php echo $totalHCF ?></td>
                    <?php } ?>
                    <?php if ($value['seqIndicador'] == 14) { ?>
                        <td style="text-align: center"><?php echo $totalPLGTBI ?></td>
                    <?php } ?>
                    <?php if ($value['seqIndicador'] == 15) { ?>
                        <td style="text-align: center"><?php echo $totalPPGD ?></td>
                    <?php } ?>
                <?php } ?>
            </tr>   
            <?php
            $cont++;
        }
        ?>
        <tr style="text-align: center">
            <th>Tota General</th>
            <th>&nbsp;</th>           
            <th><?php echo $totalUltCal?></th>
        </tr>
        <?php
    }
    ?>
</table>

