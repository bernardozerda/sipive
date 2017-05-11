<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $txtPrefijoRuta = "../../";
        include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

        include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
        include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
        include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "calificacion.class.php" );
        $claCalificacion = new calificacion();
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=calificacion.xls");
        $ejecutaConsultaPersonalizada = false;

        $formularios = "";
        
        if ($_FILES['fileDocumentos']['error'] == 0) {
            $arrDocumentos = mb_split("\n", file_get_contents($_FILES['fileDocumentos']['tmp_name']));
            $separado_por_comas = implode(",", $arrDocumentos);
            $ejecutaConsultaPersonalizada = true;
            //  echo count($arrDocumentos);
        }
        $separado_por_comas = "12271908	,
80267466	,
5683984	,
13950548	,
93470944	,
75001157	,
5830137	,
46667044	,
11389620	,
14278236	,
15663206	,
7504874	,
98415878	,
5867182	,
17774751	,
5968269	,
5946175	,
6667609	,
1118168014	,
4586397	,
93290869	,
35512186	,
25219619	,
36178686	,
35600560	,
28104739	,
35602438	,
37310861	,
28611639	,
52789992	,
1014207711	,
34960070	,
52879497	,
28878832	,
28929479	,
42547458	,
57440509	,
33647106	,
28880676	,
29286567	,
36289451	,
52962049	,
36312479	,
41447360	,
28204593	,
1026255322	,
35252181	,
36953693	,
1056302019	,
40366301	,
1026289138	,
52955477	,
1111334741	,
52703431	,
52365108	,
1030631607	,
31585726	,
1081810934	,
52960441	,
69029493	,
1023880219	,
28645817	,
57428319	,
28685156	,
50910241	,
1098708874	,
1018453046	,
37652289	,
1026565837	,
53012859	,
1074576159	,
29352850	,
31321806	,
1106332878	,
41577175	,
52120658	,
41477695	,
1049021526	,
1002678668	,
35852143	,
20166084	,
20870798	,
53092115	,
35461330	,
21095128	,
59166467	,
1005822641	,
69802473	,
53037740	,
1108932616	,
1065000278	,
40977047	,
52202189	,
24080110	,
52539149	,
52420131	,
1193250884";
        //echo "<br>".$separado_por_comas;
        $formularios = $claCalificacion->validarFormularios($separado_por_comas);
        if ($ejecutaConsultaPersonalizada) {
            $validar = explode("Error!", $formularios);
            if (count($validar) > 1) {
                echo $formularios;
                exit();
            }
        }
        if ($formularios != "") {
            $arrayCalificacion = $claCalificacion->obtenerDatosCalificacion($ejecutaConsultaPersonalizada, $formularios);
            $claCalificacion->obtenerValorIndicadores();
            $valSeg = "";
            //$fecha = date('Y-m-d H:i:s');
            $fecha = '2017-05-10 19:26:25';
            // echo $formularios;        exit();
            ?>

            <table border="1">
                <tr>
                    <th colspan="6">Datos Básicos</th>
                    <th colspan="3">Datos Educación</th>
                    <th colspan="4">Habitabilidad</th>
                    <th>Ingresos</th> 
                    <th colspan="2">Dependencia economica</th>
                    <th colspan="2">Nivel I</th>
                    <th colspan="3">Nivel II</th>
                    <th colspan="4">Nivel III</th>
                    <th >Total</th>
                </tr>
                <tr>
                    <th>Documento</th>
                    <th>Formulario</th>
                    <th>Postulante Principal</th>
                    <!--<th>Información del hogar</th>-->
                    <th>Cant Integrantes</th>
                    <th>Ingresos <br>Hogar</th>               
                    <th> <b>> </b>15 Años</th>
                    <th>Suma Educación</th>
                    <th <?= $style ?>>Educación</th>
                    <th>Integrantes <br/> Con Regimen <br/> Subsidiado</th>
                    <th >Total<br/>Regimen<br/>Subsidiado</th>
                    <th>Cohabitación</th>
                    <th>Hacinamiento</th>
                    <th>Ingresos</th> 
                    <th>Personas entre <br> 15-59 años</th>
                    <th>Total</th>
                    <th>Hogar con <br>menores</th>
                    <th>Mujer cabeza<br>de hogar </th>
                    <th>Adulto Mayor</th>
                    <th>Discapacidad</th>
                    <th>Etnia</th>
                    <th>Cant Adolecentes</th>
                    <th>Hombre cabeza<br>de hogar </th>
                    <th>Población <br>LGTBI</th>
                    <th>Programas<br>Gobierno<br>Distrital</th>
                    <td>BLE </td>
                    <td>RSA</td>
                    <td>COH</td>
                    <td>HACN</td>
                    <td>totalIngresos</td>
                    <td>TDE</td>
                    <td>HN12</td>
                    <td>MCF</td>
                    <td>HAMY</td>
                    <td>CDISC</td>
                    <td>HPGE</td>
                    <td>HN18</td>
                    <td>HCF</td>
                    <td>PLGTBI</td>
                    <td>PPGD</td>
                    <th>Total</th>
                </tr>

                <?php
                foreach ($arrayCalificacion as $key => $value) {
                    $sqlIndicadores = "";
                    if ($value['cant'] != 0) {
                        //$formularios .= $value['seqFormulario'] . ",";
                        $idCalificacion = $claCalificacion->insertarCalificacion($value['seqFormulario'], $value['fchUltimaActualizacion'], $value['cant'], $value['edades'], $value['ingresos'], $fecha);
                        /*                         * ************************************Bajo logro educativo*********************************************** */
                        $calcEducacion = ($value['aprobados'] / ($value['cantMayor']));
                        $educacion = 0;
                        if ($calcEducacion < 9) {
                            $educacion = 1;
                        } else if ($value['cantMayor'] == 0) {
                            $educacion = 1;
                        } else {
                            $educacion = 0;
                        }
                        $sqlIndicadores .= "(" . $value['cantMayor'] . ", 0, 0, " . $calcEducacion . ", " . $educacion . ", " . ($claCalificacion->BLE * ($educacion * 100)) . ", " . $idCalificacion . ",1),";
                        /*                         * ************************************Calculo Regimen Subsidiado*********************************************** */
                        $saludSubsidiados = 0;

                        $saludSubsidiados = ($value['afiliacion'] / $value['cant']);

                        $sqlIndicadores .= "(" . $value['afiliacion'] . ", 0, 0, " . $saludSubsidiados . ", null, " . ($claCalificacion->RSA * ($saludSubsidiados * 100)) . ", " . $idCalificacion . ",2),";

                        /*                         * ******************************************* Cohabitacion **************************************************** */
                        $cohabitacion = 0;
                        if ($value['cohabitacion'] > 1) {
                            $cohabitacion = 1;
                        }
                        //  echo "cohabitacion ->".$cohabitacion." coha base->".$value['cohabitacion']." miembros ->".$value['cant']." formulario ->".$value['seqFormulario']."<br>";
                        $sqlIndicadores .= "(" . $value['cohabitacion'] . ", 0, 0, null, " . $cohabitacion . ", " . ($claCalificacion->COH * ($cohabitacion * 100)) . ", " . $idCalificacion . ",3),";
                        /*                         * ****************************************** Hacinamaoento **************************************************** */

                        $dormitorios = $value['dormitorios'];
                        $hacinamiento = 0;
                        $calchacinamiento = 0;
                        if ($dormitorios != 0) {
                            $calchacinamiento = ($value['cant'] / $dormitorios);
                            if ($calchacinamiento >= 4) {
                                $hacinamiento = 1;
                            } else {
                                $hacinamiento = 0;
                            }
                        } else
                            $hacinamiento = 1;
                        $sqlIndicadores .= "(" . $dormitorios . ", 0, 0, " . $calchacinamiento . ", " . $hacinamiento . ", " . ($claCalificacion->HACN * ($hacinamiento * 100)) . ", " . $idCalificacion . ",4),";

                        /*                         * *************************************Ingresos********************************************* */
                        $ingresos = $value['ingresos'] / $value['cant'];
                        $arrConfiguracion['constantes']['salarioMinimo'] . "/" . ($ingresos + 1000);
                        $totalIngresos = ($arrConfiguracion['constantes']['salarioMinimo']) / ($ingresos + 1000);

                        $sqlIndicadores .= "(" . $ingresos . ", 0, 0, " . $totalIngresos . ", null, " . (100 * (1 - exp(-$totalIngresos / 52.05))) . ", " . $idCalificacion . ",5),";
                        /*                         * *************************************Dependencia Economica********************************************* */

                        $dependenciaEcon = 0;
                        $adultos = $value['adultos'] / $value['cant'];
                        //echo "<br>".$value['aprobadosJefe']; 
                        if ($adultos > 2 && $value['aprobadosJefe'] < 3) {
                            $dependenciaEcon = 1;
                        }
                        $sqlIndicadores .= "(" . $adultos . ", 0, 0, null, " . $dependenciaEcon . ", " . ($claCalificacion->TDE * ($dependenciaEcon * 100)) . ", " . $idCalificacion . ",6),";
                        /*                         * *************************************Nivel I Menores********************************************* */
                        $menores = $value['cantMenores'] / $value['cant'];
                        $sqlIndicadores .= "(" . $value['cantMenores'] . ", 0, 0, null, " . $menores . ", " . ($claCalificacion->HN12 * ($menores * 100)) . ", " . $idCalificacion . ",7),";
                        /*                         * *************************************Nivel I ********************************************* */
                        $monoparentalFem = 0;
                        // echo "<br>".$value['mujerCabHogar']." == 1 &&". $value['conyugueHogar']." == 0 && ".$value['cantHijos']." > 0";
                        if ($value['mujerCabHogar'] == 1 && $value['conyugueHogar'] == 0 && $value['cantHijos'] > 0) {
                            $monoparentalFem = 1;
                        }
                        $sqlIndicadores .= "(" . $value['cantHijos'] . ", " . $value['mujerCabHogar'] . ", " . $value['conyugueHogar'] . ", null, " . $monoparentalFem . ", " . ($claCalificacion->MCF * ($monoparentalFem * 100)) . ", " . $idCalificacion . ",8),";

                        /*                         * ************************************Nivel II ********************************************* */

                        /*                         * ************************************adulto mayor ********************************************* */
                        $cantAdultoMayor = $value['cantadultoMayor'] / $value['cant'];
                        $sqlIndicadores .= "(" . $value['cantadultoMayor'] . ", 0, 0, null, " . $cantAdultoMayor . ", " . ($claCalificacion->HAMY * ($cantAdultoMayor * 100)) . ", " . $idCalificacion . ",9),";
                        /*                         * ************************************discapacidad********************************************* */
                        $discapacidad = $value['cantCondEspecial'] / $value['cant'];
                        $sqlIndicadores .= "(" . $value['cantCondEspecial'] . ", 0, 0, null, " . $discapacidad . ", " . ($claCalificacion->CDISC * ($discapacidad * 100)) . ", " . $idCalificacion . ",10),";
                        /*                         * ************************************grupo etnico ********************************************* */
                        $grupoEtnico = 0;
                        if ($value['condicionEtnica'] > 0) {
                            $grupoEtnico = 1;
                        }
                        $sqlIndicadores .= "(" . $value['condicionEtnica'] . ", 0, 0, null, " . $grupoEtnico . ", " . ($claCalificacion->HPGE * ($grupoEtnico * 100)) . ", " . $idCalificacion . ",11),";

                        /*                         * ************************************Nivel III ********************************************* */

                        /*                         * ************************************ Adolecentes ********************************************* */
                        $cantAdolecentes = $value['adolecentes'] / $value['cant'];
                        //  echo "<br>".$value['seqFormulario']. "->" ."hn18 ->".$claCalificacion->HN18. "*" ."cantidad*100".($cantAdolecentes * 100);
                        $sqlIndicadores .= "(" . $value['adolecentes'] . ", 0, 0, null, " . $cantAdolecentes . ", " . ($claCalificacion->HN18 * ($cantAdolecentes * 100)) . ", " . $idCalificacion . ",12),";

                        /*                         * ************************************ hombre Cabeza de Hogar ********************************************* */
                        $monoparentalMasc = 0;
                        if ($value['hombreCabHogar'] == 1 && $value['conyugueHogar'] == 0 && $value['cantHijos'] > 0) {
                            $monoparentalMasc = 1;
                        }
                        $sqlIndicadores .= "(" . $value['cantHijos'] . ", " . $value['hombreCabHogar'] . ", " . $value['conyugueHogar'] . ", null, " . $monoparentalMasc . ", " . ($claCalificacion->HCF * ($monoparentalMasc * 100)) . ", " . $idCalificacion . ",13),";

                        /*                         * ************************************ Grupo LGTBI ********************************************* */
                        $grupoLGTBI = 0;
                        if ($value['grupoLgtbi'] > 0) {
                            $grupoLGTBI = 1;
                        }
                        $sqlIndicadores .= "(" . $value['grupoLgtbi'] . ", 0, 0, null, " . $grupoLGTBI . ", " . ($claCalificacion->PLGTBI * ($grupoLGTBI * 100)) . ", " . $idCalificacion . ",14),";
                        /*                         * ************************************ Participa en programas del Gobierno Distrital ********************************************* */
                        $programa = 0;

                        if ($value['bolIntegracionSocial'] > 0 || $value['bolSecMujer'] > 0 || $value['bolIpes'] > 0) {
                            $programa = 1;
                        }
                        $sqlIndicadores .= "(" . $value['bolIntegracionSocial'] . ", " . $value['bolSecMujer'] . ", " . $value['bolIpes'] . ", null, " . $programa . ", " . ($claCalificacion->PPGD * ($programa * 100)) . ", " . $idCalificacion . ",15);";

                        $insertInd = $claCalificacion->insertarIndicadores($sqlIndicadores);
                        //if ($insertInd) {
                        $formula = ($claCalificacion->BLE * ($educacion * 100)) + ($claCalificacion->RSA * ($saludSubsidiados * 100)) + ($claCalificacion->COH * ($cohabitacion * 100)) + ($claCalificacion->HACN * ($hacinamiento * 100)) + (100 * (1 - exp(-$totalIngresos / 52.05))) + ($claCalificacion->TDE * ($dependenciaEcon * 100)) + ($claCalificacion->HN12 * ($menores * 100)) + ($claCalificacion->MCF * ($monoparentalFem * 100)) + ($claCalificacion->HAMY * ($cantAdultoMayor * 100)) + ($claCalificacion->CDISC * ($discapacidad * 100)) + ($claCalificacion->HPGE * ($grupoEtnico * 100)) + ($claCalificacion->HN18 * ($cantAdolecentes * 100)) + ($claCalificacion->HCF * ($monoparentalMasc * 100)) + ($claCalificacion->PLGTBI * ($grupoLGTBI * 100)) + ($claCalificacion->PPGD * ($programa * 100));
                        //echo "<br>".$formula;
                        //}

                        $valSeg .= "(
                            " . $value['seqFormulario'] . ", 
                            NOW(), 
                            " . $_SESSION['seqUsuario'] . ", 
                            'Calificacion hogares inscritos ', 
                            '', 
                            " . $value['numDocumento'] . ", 
                            '" . $value['nombre'] . "', 
                            35, 
                            1
                         ),";
                        // echo "<br>***" . $formularios;
                    }
                    $claCalificacion->obtenerValorIndicadores();
                    ?>
                    <tr style="text-align: center">
                        <td><?= $value['numDocumento'] ?></td>
                        <td><?= $value['seqFormulario'] ?></td>
                        <td><?= $value['nombre'] ?></td>
                        <!--<td>
                            <table>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Edad</th>
                                </tr>
                                <?= ucwords(strtolower(str_replace(",", "", $value['edades']))) ?>
                            </table>
                        </td>-->

                        <td><?= $value['cant'] ?></td>
                        <td><?= $value['ingresos'] ?></td>
                        <td><?= $value['cantMayor'] ?></td>
                        <td><?= $value['aprobados'] ?></td>
                        <td <?= $style ?>><?= $educacion ?></td>
                        <td><?= $value['afiliacion'] ?></td>
                        <td <?= $style ?>><?= $saludSubsidiados ?></td>
                        <td <?= $style ?>><?= $cohabitacion ?></td>
                        <td <?= $style ?>><?= $hacinamiento ?></td>
                        <td <?= $style ?>><?= $totalIngresos ?></td>
                        <td <?= $style ?>><?= $value['adultos'] ?></td>
                        <td <?= $style ?>><?= $dependenciaEcon ?></td>
                        <td <?= $style ?>><?= $menores ?></td>            
                        <td <?= $style ?>><?= $monoparentalFem ?></td>  
                        <td <?= $style ?>><?= $cantAdultoMayor ?></td>
                        <td <?= $style ?>><?= $discapacidad ?></td>
                        <td <?= $style ?>><?= $grupoEtnico ?></td>
                        <td <?= $style ?>><?= $cantAdolecentes ?></td>
                        <td <?= $style ?>><?= $monoparentalMasc ?></td>
                        <td <?= $style ?>><?= $grupoLGTBI ?></td>
                        <td <?= $style ?>><?= $programa ?></td>
                        <td><?= ($claCalificacion->BLE * ($educacion * 100)) ?></td>
                        <td><?= ($claCalificacion->RSA * ($saludSubsidiados * 100)) ?></td>
                        <td><?= ($claCalificacion->COH * ($cohabitacion * 100)) ?></td>
                        <td><?= ($claCalificacion->HACN * ($hacinamiento * 100)) ?></td>
                        <td><?= (100 * (1 - exp(-$totalIngresos / 52.05))) ?></td>
                        <td><?= ($claCalificacion->TDE * ($dependenciaEcon * 100)) ?></td>
                        <td><?= ($claCalificacion->HN12 * ($menores * 100)) ?></td>
                        <td><?= ($claCalificacion->MCF * ($monoparentalFem * 100)) ?></td>
                        <td><?= ($claCalificacion->HAMY * ($cantAdultoMayor * 100)) ?></td>
                        <td><?= ($claCalificacion->CDISC * ($discapacidad * 100)) ?></td>
                        <td><?= ($claCalificacion->HPGE * ($grupoEtnico * 100)) ?></td>
                        <td><?= ($claCalificacion->HN18 * ($cantAdolecentes * 100)) ?></td>
                        <td><?= ($claCalificacion->HCF * ($monoparentalMasc * 100)) ?></td>
                        <td><?= ($claCalificacion->PLGTBI * ($grupoLGTBI * 100)) ?></td>
                        <td><?= ($claCalificacion->PPGD * ($programa * 100)) ?></td>

                        <td <?= $style ?>><?= number_format($formula, 30, '.', ',') ?></td>
                    </tr>
                    <?php
                }

                $formularios = substr_replace($formularios, '', -1, 1);
//                $cambioEstado = $claCalificacion->cambiarEstado($formularios);
//                $seg = false;
                // echo "<br>++++++++".$cambioEstado;
//
//                if ($cambioEstado) {
//
//                    $seg = $claCalificacion->insertarSeguimiento($valSeg);
//                }
//                if ($seg) {
//                    echo "<p class='alert alert-danger'><b>Se almacenaron los datos con exito</b></p>";
//                }
            } else {
                echo "<p class='alert alert-danger'><b>No existen formularios en estado Hogar actualizado</b></p>";
            }

            //var_dump($objRes1);
            $int = 0;
            ?>


        </table>
    </body>
</html>
