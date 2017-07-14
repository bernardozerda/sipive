<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">               
        <title>Cailificacion Pive</title>
    </head>
    <body>
        <?php
     
        $txtPrefijoRuta = "../../";
        include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
        include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
        include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
        include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "calificacion.class.php" );
        $claCalificacion = new calificacion();

        $ejecutaConsultaPersonalizada = false;
        $separado_por_comas = "";
        $formularios = "";
        $arrDocumentosArchivo = array();

//        if ($_FILES['fileDocumentos']['error'] == 0) {
//            $arrDocumentos = mb_split("\n", file_get_contents($_FILES['fileDocumentos']['tmp_name']));
//            $salt = 0;
//
//            $separado_por_comas = implode(",", ($arrDocumentos));
//            $ejecutaConsultaPersonalizada = true;
//            //  echo count($arrDocumentos);
//        }

        if (isset($_FILES["fileDocumentos"]) && is_uploaded_file($_FILES['fileDocumentos']['tmp_name'])) {
          
            $nombreArchivo = $_FILES['fileDocumentos']['tmp_name'];
            $lineas = file($nombreArchivo);
            foreach ($lineas as $linea_num => $linea) {
                $linea = str_replace("\n", "", $linea);
                $linea = str_replace("\r", "", $linea);
                if (!empty($linea)) {
                    array_push($arrDocumentosArchivo, trim($linea));
                }
            }
            $salt = 0;
//
            $separado_por_comas = implode(",", ($arrDocumentosArchivo));
            $ejecutaConsultaPersonalizada = true;
        }
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
            // $fecha = '2017-05-10 19:26:25';
            $fecha = date('Y-m-d H:i:s');
            // echo $formularios;        exit();
            foreach ($arrayCalificacion as $key => $value) {
                $sqlIndicadores = "";
                if ($value['cant'] != 0) {
                    //$formularios .= $value['seqFormulario'] . ",";
                    $idCalificacion = $claCalificacion->insertarCalificacion($value['seqFormulario'], $value['fchUltimaActualizacion'], $value['cant'], $value['edades'], $value['ingresos'], $fecha);
                    /*                     * ************************************Bajo logro educativo*********************************************** */
                    $calcEducacion = ($value['aprobados'] / ($value['cantMayor']));
                    $educacion = 0;
                    if ($calcEducacion < 9) {
                        $educacion = 1;
                    } else if ($value['cantMayor'] == 0) {
                        $educacion = 1;
                    } else {
                        $educacion = 0;
                    }
                    $sqlIndicadores .= "(" . $value['cantMayor'] . ", 0, 0, 0, " . $value['aprobados'] . ", " . $calcEducacion . ", " . $educacion . ", " . ($claCalificacion->BLE * ($educacion * 100)) . ", " . $idCalificacion . ",1),";
                    /*                     * ************************************Calculo Regimen Subsidiado*********************************************** */
                    $saludSubsidiados = 0;

                    $saludSubsidiados = ($value['afiliacion'] / $value['cant']);

                    $sqlIndicadores .= "(" . $value['afiliacion'] . ", 0, 0, 0, 0, " . $saludSubsidiados . ", null, " . ($claCalificacion->RSA * ($saludSubsidiados * 100)) . ", " . $idCalificacion . ",2),";

                    /*                     * ******************************************* Cohabitacion **************************************************** */
                    $cohabitacion = 0;
                    if ($value['cohabitacion'] > 1) {
                        $cohabitacion = 1;
                    }
                    //  echo "cohabitacion ->".$cohabitacion." coha base->".$value['cohabitacion']." miembros ->".$value['cant']." formulario ->".$value['seqFormulario']."<br>";
                    $sqlIndicadores .= "(" . $value['cohabitacion'] . ", 0, 0, 0, 0, null, " . $cohabitacion . ", " . ($claCalificacion->COH * ($cohabitacion * 100)) . ", " . $idCalificacion . ",3),";
                    /*                     * ****************************************** Hacinamaoento **************************************************** */

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
                    $sqlIndicadores .= "(" . $dormitorios . ", 0, 0, 0, 0," . $calchacinamiento . ", " . $hacinamiento . ", " . ($claCalificacion->HACN * ($hacinamiento * 100)) . ", " . $idCalificacion . ",4),";

                    /*                     * *************************************Ingresos********************************************* */
                    $ingresos = $value['ingresos'] / $value['cant'];
                    $arrConfiguracion['constantes']['salarioMinimo'] . "/" . ($ingresos + 1000);
                    $totalIngresos = ($arrConfiguracion['constantes']['salarioMinimo']) / ($ingresos + 1000);

                    $sqlIndicadores .= "(" . $ingresos . ", 0, 0, 0, 0," . $totalIngresos . ", null, " . $claCalificacion->IPC * (100 * (1 - exp(-$totalIngresos / 52.05))) . ", " . $idCalificacion . ",5),";
                    /*                     * *************************************Dependencia Economica********************************************* */

                    $dependenciaEcon = 0;
                    if ($value['adultos'] > 0) {
                        $adultos = $value['cant'] / $value['adultos'];
                    } else {
                        $adultos = 3.5;
                    }
                    //echo "<br>".$value['aprobadosJefe']; 
                    if ($adultos > 3 && $value['aprobadosJefe'] <= 2) {
                        $dependenciaEcon = 1;
                    }
                    $sqlIndicadores .= "(" . $value['adultos'] . ", 0, 0, 0," . $value['aprobadosJefe'] . ", " . $adultos . ", " . $dependenciaEcon . ", " . ($claCalificacion->TDE * ($dependenciaEcon * 100)) . ", " . $idCalificacion . ",6),";
                    /*                     * *************************************Nivel I Menores********************************************* */
                    $menores = $value['cantMenores'] / $value['cant'];
                    $sqlIndicadores .= "(" . $value['cantMenores'] . ", 0, 0, 0, 0, null, " . $menores . ", " . ($claCalificacion->HN12 * ($menores * 100)) . ", " . $idCalificacion . ",7),";
                    /*                     * *************************************Nivel I ********************************************* */
                    $monoparentalFem = 0;
                    // echo "<br>".$value['mujerCabHogar']." == 1 &&". $value['conyugueHogar']." == 0 && ".$value['cantHijos']." > 0";
                    $tipo = 0;
                    if ($value['mujerCabHogar'] == 1) {
                        $tipo = 1;
                    }
                    if ($value['mujerCabHogar'] == 1 && $value['conyugueHogar'] == 0 && $value['cantHijos'] > 0) {
                        $monoparentalFem = 1;
                    }
                    $sqlIndicadores .= "(" . $value['cantHijos'] . ", " . $value['mujerCabHogar'] . ", " . $tipo . ", " . $value['conyugueHogar'] . ", 0, null, " . $monoparentalFem . ", " . ($claCalificacion->MCF * ($monoparentalFem * 100)) . ", " . $idCalificacion . ",8),";

                    /*                     * ************************************Nivel II ********************************************* */

                    /*                     * ************************************adulto mayor ********************************************* */
                    $cantAdultoMayor = $value['cantadultoMayor'] / $value['cant'];
                    $sqlIndicadores .= "(" . $value['cantadultoMayor'] . ", 0, 0, 0, 0, null, " . $cantAdultoMayor . ", " . ($claCalificacion->HAMY * ($cantAdultoMayor * 100)) . ", " . $idCalificacion . ",9),";
                    /*                     * ************************************discapacidad********************************************* */
                    $discapacidad = $value['cantCondEspecial'] / $value['cant'];
                    $sqlIndicadores .= "(" . $value['cantCondEspecial'] . ", 0, 0, 0, 0, null, " . $discapacidad . ", " . ($claCalificacion->CDISC * ($discapacidad * 100)) . ", " . $idCalificacion . ",10),";
                    /*                     * ************************************grupo etnico ********************************************* */
                    $grupoEtnico = 0;
                    if ($value['condicionEtnica'] > 0) {
                        $grupoEtnico = 1;
                    }
                    $sqlIndicadores .= "(" . $value['condicionEtnica'] . ", 0, 0, 0, 0, null, " . $grupoEtnico . ", " . ($claCalificacion->HPGE * ($grupoEtnico * 100)) . ", " . $idCalificacion . ",11),";

                    /*                     * ************************************Nivel III ********************************************* */

                    /*                     * ************************************ Adolecentes ********************************************* */
                    $cantAdolecentes = $value['adolecentes'] / $value['cant'];
                    //  echo "<br>".$value['seqFormulario']. "->" ."hn18 ->".$claCalificacion->HN18. "*" ."cantidad*100".($cantAdolecentes * 100);
                    $sqlIndicadores .= "(" . $value['adolecentes'] . ", 0, 0, 0, 0, null, " . $cantAdolecentes . ", " . ($claCalificacion->HN18 * ($cantAdolecentes * 100)) . ", " . $idCalificacion . ",12),";

                    /*                     * ************************************ hombre Cabeza de Hogar ********************************************* */
                    $monoparentalMasc = 0;
                    $tipo = 0;
                    if ($value['hombreCabHogar'] == 1) {
                        $tipo = 2;
                    }
                    if ($value['hombreCabHogar'] == 1 && $value['conyugueHogar'] == 0 && $value['cantHijos'] > 0) {
                        $monoparentalMasc = 1;
                    }
                    $sqlIndicadores .= "(" . $value['cantHijos'] . ", " . $value['hombreCabHogar'] . ", " . $tipo . ", " . $value['conyugueHogar'] . ", 0, null, " . $monoparentalMasc . ", " . ($claCalificacion->HCF * ($monoparentalMasc * 100)) . ", " . $idCalificacion . ",13),";

                    /*                     * ************************************ Grupo LGTBI ********************************************* */
                    $grupoLGTBI = 0;
                    if ($value['grupoLgtbi'] > 0) {
                        $grupoLGTBI = 1;
                    }
                    $sqlIndicadores .= "(" . $value['grupoLgtbi'] . ", 0, 0, 0, 0, null, " . $grupoLGTBI . ", " . ($claCalificacion->PLGTBI * ($grupoLGTBI * 100)) . ", " . $idCalificacion . ",14),";
                    /*                     * ************************************ Participa en programas del Gobierno Distrital ********************************************* */
                    $programa = 0;

                    if ($value['bolIntegracionSocial'] > 0 || $value['bolSecMujer'] > 0 || $value['bolIpes'] > 0) {
                        $programa = 1;
                    }
                    if ($value['bolSecMujer'] == "") {
                        $value['bolSecMujer'] = 0;
                    }
                    $sqlIndicadores .= "(" . $value['bolIntegracionSocial'] . ", " . $value['bolSecMujer'] . ", 0, " . $value['bolIpes'] . ", 0, null, " . $programa . ", " . ($claCalificacion->PPGD * ($programa * 100)) . ", " . $idCalificacion . ",15);";
                    $insertInd = $claCalificacion->insertarIndicadores($sqlIndicadores);
                    if ($insertInd) {
                        $formula = ($claCalificacion->BLE * ($educacion * 100)) + ($claCalificacion->RSA * ($saludSubsidiados * 100)) + ($claCalificacion->COH * ($cohabitacion * 100)) + ($claCalificacion->HACN * ($hacinamiento * 100)) + ($claCalificacion->IPC * (100 * (1 - exp(-$totalIngresos / 52.05)))) + ($claCalificacion->TDE * ($dependenciaEcon * 100)) + ($claCalificacion->HN12 * ($menores * 100)) + ($claCalificacion->MCF * ($monoparentalFem * 100)) + ($claCalificacion->HAMY * ($cantAdultoMayor * 100)) + ($claCalificacion->CDISC * ($discapacidad * 100)) + ($claCalificacion->HPGE * ($grupoEtnico * 100)) + ($claCalificacion->HN18 * ($cantAdolecentes * 100)) + ($claCalificacion->HCF * ($monoparentalMasc * 100)) + ($claCalificacion->PLGTBI * ($grupoLGTBI * 100)) + ($claCalificacion->PPGD * ($programa * 100));
                        //echo "<br>".$formula;
                        $valSeg .= "(
                            " . $value['seqFormulario'] . ", 
                            NOW(), 
                            " . $_SESSION['seqUsuario'] . ", 
                            'Calificacion hogares inscritos ', 
                            '', 
                            " . $value['numDocumento'] . ", 
                            '" . $value['nombre'] . "', 
                            46, 
                            1
                         ),";
                    }

                    // echo "<br>***" . $formularios;
                }
            }
            $formularios = substr_replace($formularios, '', -1, 1);
            //$cambioEstado = $claCalificacion->cambiarEstado($formularios);
            $seg = false;
            // echo "<br>++++++++".$cambioEstado;

            /* if ($cambioEstado) {

              $seg = $claCalificacion->insertarSeguimiento($valSeg);
              }
              if ($seg) {
              echo "<p class='alert alert-danger'><b>Se almacenaron los datos con exito</b></p>";
              } */
        } else {
            echo "<p class='alert alert-danger'><b>No existen formularios en estado Hogar actualizado</b></p>";
        }

        //$formula = ($BLE * ($educacion * 100)) + ($RSA * ($saludSubsidiados * 100)) + ($COH * ($cohabitacion * 100)) + ($HACN * ($hacinamiento * 100)) + (100 * (1 - exp(-$totalIngresos / 52.05))) + ($TDE * ($dependenciaEcon * 100)) + ($HN12 * ($menores * 100)) + ($MCF * ($monoparentalFem * 100)) + ($HAMY * ($cantAdultoMayor * 100)) + ($CDISC * ($discapacidad * 100)) + ($HPGE * ($grupoEtnico * 100)) + ($HN18 * ($cantAdolecentes * 100)) + ($HCF * ($monoparentalMasc * 100)) + ($PLGTBI * ($grupoLGTBI * 100)) + ($PPGD * ($programa * 100));
        ?>
    </table>
</body>
</html>
