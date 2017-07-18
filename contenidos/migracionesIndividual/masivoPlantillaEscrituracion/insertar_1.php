<?php

include_once "../lib/mysqli/shared/ez_sql_core.php";
include_once "../lib/mysqli/ez_sql_mysqli.php";
//include_once "../generarExcel.php";



$arrViabilizados = Array();
$arrNoViabilizados = Array();
$idHogar = "";

if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
    $nombreArchivo = $_FILES['archivo']['tmp_name'];

    $lineas = file($nombreArchivo);
    //var_dump($lineas);    exit();
    $registros = 0;
    //$db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sdht_subsidiosJul17', 'localhost');
    $db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sdht_subsidios_feb10', 'localhost');
    $intV = 1;
    $intNV = 1;
    $band = 0;
    $cant = count($lineas);

    foreach ($lineas as $linea_num => $linea) {
        if ($linea_num != 0) {
            $datos = explode("\t", $linea);
            $casilla = "";

            $seqDesembolso = trim($datos[1]);
            if ($registros < $cant - 1) {
                $idDesembolso .= $seqDesembolso . ",";
            } else
                $idDesembolso .= $seqDesembolso;
            $estrato = explode(" ", $datos[37]);

            $seqFormulario = $datos[2];
            $txtEscrituraPublica = $datos[39];
            $numEscrituraPublica = $datos[38];
            $txtCertificadoTradicion = $datos[41];
            $numCertificadoTradicion = $datos[40];
            $txtCartaAsignacion = $datos[43];
            $numCartaAsignacion = $datos[42];
            $txtAltoRiesgo = $datos[45];
            $numAltoRiesgo = $datos[44];
            $txtHabitabilidad = $datos[47];
            $numHabitabilidad = $datos[46];
            $txtBoletinCatastral = $datos[49];
            $numBoletinCatastral = $datos[48];
            $txtLicenciaConstruccion = $datos[51];
            $numLicenciaConstruccion = $datos[50];
            $txtUltimoPredial = $datos[53];
            $numUltimoPredial = $datos[52];
            $txtUltimoReciboAgua = $datos[55];
            $numUltimoReciboAgua = $datos[54];
            $txtUltimoReciboEnergia = $datos[57];
            $numUltimoReciboEnergia = $datos[56];
            $txtOtro = $datos[73];
            $numOtros = $datos[72];
            //$txtViabilizoJuridico = $datos[7];
            //$txtViabilizoTecnico = $datos[8];
            $bolViabilizoJuridico = $datos[7];
            $bolViabilizoTecnico = $datos[8];
            $txtNombreVendedor = $datos[3];
            $numDocumentoVendedor = $datos[4];
            $txtDireccionInmueble = $datos[4];
            $txtBarrio = $datos[25];
            $seqLocalidad = $datos[6];
            $txtEscritura = $datos[26];
            $numNotaria = $datos[28];
            $fchEscritura = $datos[27];
            $numAvaluo = $datos[34];
            $valInmueble = $datos[35];
            $txtMatriculaInmobiliaria = $datos[29];
            $numValorInmueble = $datos[35];
            //$bolPoseedor,
            $txtChip = $datos[30];
            $numActaEntrega = $datos[58];
            $txtActaEntrega = $datos[59];
            $numCertificacionVendedor = $datos[60];
            $txtCertificacionVendedor = $datos[61];
            $numAutorizacionDesembolso = $datos[62];
            $txtAutorizacionDesembolso = $datos[63];
            $numFotocopiaVendedor = $datos[64];
            $txtFotocopiaVendedor = $datos[65];
            $seqTipoDocumento = $datos[13];
            $numAreaLote = $datos[32];
            $numAreaConstruida = $datos[33];
            $txtCedulaCatastral = $datos[31];
            $numTelefonoVendedor = $datos[12];
            // $numTelefonoVendedor2,
            $txtTipoPredio = $datos[36];
            $numRut = $datos[68];
            $txtRut = $datos[69];
            $numRit = $datos[66];
            $txtRit = $datos[67];
            $numNit = $datos[70];
            $txtNit = $datos[71];
            $txtCompraVivienda = $datos[10];
            $numEstrato = $estrato[1];
            $txtTipoDocumentos = $datos[13];
            $txtCiudad = $datos[15];
            $txtPropiedad = $datos[19];
            //$fchSentencia = "NOW()";
            //$numJuzgado = $datos[19];
            // $txtCiudadSentencia = $datos[19];
            //$numResolucion = $datos[19];
            //$fchResolucion = $datos[19];
            // $txtEntidad = $datos[19];
            //$txtCiudadResolucion = $datos[19];
            //$numContratoArrendamiento = $datos[19];
            // $numAperturaCAP,
            //$txtAperturaCAP,
            // $numCedulaArrendador,
            // $numCuentaArrendador,
            // $txtCuentaArrendador,
            //$numRetiroRecursos,
            // $txtRetiroRecursos,
            // $numServiciosPublicos,
            // $txtServiciosPublicos,
            $txtCorreoVendedor = $datos[20];
            $seqCiudad = $datos[21];
            if ($txtEscritura == "" || $fchEscritura == "" || $numNotaria == "" || $txtMatriculaInmobiliaria == "" || $numAreaLote == "" || $numAreaConstruida == "") {

                $casilla .= ($txtEscritura == '') ? "27," : '';
                $casilla .= ($fchEscritura == '') ? "28," : '';
                $casilla .= ($numNotaria == '') ? "29," : '';
                $casilla .= ($txtMatriculaInmobiliaria == '') ? "30," : '';
                $casilla .= ($numAreaLote == '') ? "33," : '';
                $casilla .= ($numAreaConstruida == '') ? "34," : '';
                $band = 1;
            }
            if ($numAvaluo == "" || $valInmueble == "" || $numValorInmueble == "" || $txtTipoPredio == "" || $numEstrato == "" || $numEscrituraPublica == "" || $numFotocopiaVendedor = "") {
                $casilla .= ($numAvaluo == '') ? "35," : '';
                $casilla .= ($valInmueble == '') ? "36," : '';
                $casilla .= ($numValorInmueble == '') ? "36," : '';
                $casilla .= ($txtTipoPredio == '') ? "37," : '';
                $casilla .= ($numEstrato == '') ? "38," : '';
                $casilla .= ($numEscrituraPublica == '') ? "39," : '';
                $casilla .= ($numFotocopiaVendedor == '') ? "65," : '';
                $band = 1;
            }

            if ($numCertificadoTradicion == "" || $txtCertificadoTradicion == "" || $numCartaAsignacion == "" || $txtCartaAsignacion == "" || $numEstrato == "" || $numEscrituraPublica == "") {
                $casilla .= ($numCertificadoTradicion == '') ? "41," : '';
                $casilla .= ($txtCertificadoTradicion == '') ? "42," : '';
                $casilla .= ($numCartaAsignacion == '') ? "43," : '';
                $casilla .= ($txtCartaAsignacion == '') ? "44," : '';
                $casilla .= ($numEstrato == '') ? "38," : '';
                $casilla .= ($numEscrituraPublica == '') ? "39," : '';
                $band = 1;
            }
            /*             * ******* pp ********************** */
            if ($numRit == "" || $txtRit == "" || $numRut == "" || $txtRut == "" || $numEstrato == "" || $numEscrituraPublica == "") {
                $casilla .= ($numRit == '') ? "67," : '';
                $casilla .= ($txtRit == '') ? "68," : '';
                $casilla .= ($numRut == '') ? "69," : '';
                $casilla .= ($txtRut == '') ? "70," : '';

                $band = 1;
            }

            if ($numAltoRiesgo == "" || $numHabitabilidad == "" || $numBoletinCatastral == "" || $numLicenciaConstruccion == "" || $numUltimoPredial == "" || $numUltimoReciboAgua == "" || $numUltimoReciboEnergia == "" || $numNit == "") {
                $numAltoRiesgo = ($numAltoRiesgo == '') ? 0 : $numAltoRiesgo;
                $numHabitabilidad = ($numHabitabilidad == '') ? 0 : $numHabitabilidad;
                $numBoletinCatastral = ($numBoletinCatastral == '') ? 0 : $numBoletinCatastral;
                $numLicenciaConstruccion = ($numLicenciaConstruccion == '') ? 0 : $numLicenciaConstruccion;
                $numUltimoPredial = ($numUltimoPredial == '') ? 0 : $numUltimoPredial;
                $numUltimoReciboAgua = ($numUltimoReciboAgua == '') ? 0 : $numUltimoReciboAgua;
                $numUltimoReciboEnergia = ($numUltimoReciboEnergia == '') ? 0 : $numUltimoReciboEnergia;
                $numNit = ($numNit == '') ? 0 : $numNit;
            }


            if ($numActaEntrega == "" || $numCertificacionVendedor == "" || $numAutorizacionDesembolso == "" || $numLicenciaConstruccion == "" || $numUltimoPredial == "" || $numUltimoReciboAgua == "" || $numUltimoReciboEnergia == "" || $numOtros == "") {
                $numActaEntrega = ($numActaEntrega == '') ? 0 : $numActaEntrega;
                $numCertificacionVendedor = ($numCertificacionVendedor == '') ? 0 : $numCertificacionVendedor;
                $numAutorizacionDesembolso = ($numAutorizacionDesembolso == '') ? 0 : $numAutorizacionDesembolso;
                $numLicenciaConstruccion = ($numLicenciaConstruccion == '') ? 0 : $numLicenciaConstruccion;
                $numUltimoPredial = ($numUltimoPredial == '') ? 0 : $numUltimoPredial;
                $numUltimoReciboAgua = ($numUltimoReciboAgua == '') ? 0 : $numUltimoReciboAgua;
                $numUltimoReciboEnergia = ($numUltimoReciboEnergia == '') ? 0 : $numUltimoReciboEnergia;
                $numOtros = ($numOtros == '') ? 0 : $numOtros;
            }


            $CfchEscrituraIdentificacion = explode("/", $fchEscritura);
            if ($CfchEscrituraIdentificacion[1] != "") {
                $fchEscrituraIdentificacion = $CfchEscrituraIdentificacion[2] . "-" . $CfchEscrituraIdentificacion[1] . "-" . $CfchEscrituraIdentificacion[0];
            }


            if ($band == 0) {
                if ($seqDesembolso != "") {
                    $arrViabilizados['seqFormulario'][$intV] = $seqFormulario;
                    $arrViabilizados['seqDesembolso'][$intV] = $seqDesembolso;
                    $arrViabilizados['txtEscrituraPublica'][$intV] = $txtEscrituraPublica;
                    $arrViabilizados['numEscrituraPublica'][$intV] = $numEscrituraPublica;
                    $arrViabilizados['txtCertificadoTradicion'][$intV] = $txtCertificadoTradicion;
                    $arrViabilizados['numCertificadoTradicion'][$intV] = $numCertificadoTradicion;
                    $arrViabilizados['txtCartaAsignacion'][$intV] = $txtCartaAsignacion;
                    $arrViabilizados['numCartaAsignacion'][$intV] = $numCartaAsignacion;
                    $arrViabilizados['txtAltoRiesgo'][$intV] = $txtAltoRiesgo;
                    $arrViabilizados['numAltoRiesgo'][$intV] = $numAltoRiesgo;
                    $arrViabilizados['txtHabitabilidad'][$intV] = $txtHabitabilidad;
                    $arrViabilizados['numHabitabilidad'][$intV] = $numHabitabilidad;
                    $arrViabilizados['txtBoletinCatastral'][$intV] = $txtBoletinCatastral;
                    $arrViabilizados['numBoletinCatastral'][$intV] = $numBoletinCatastral;
                    $arrViabilizados['txtLicenciaConstruccion'][$intV] = $txtLicenciaConstruccion;
                    $arrViabilizados['numLicenciaConstruccion'][$intV] = $numLicenciaConstruccion;
                    $arrViabilizados['txtUltimoPredial'][$intV] = $txtUltimoPredial;
                    $arrViabilizados['numUltimoPredial'][$intV] = $numUltimoPredial;
                    $arrViabilizados['txtUltimoReciboAgua'][$intV] = $txtUltimoReciboAgua;
                    $arrViabilizados['numUltimoReciboAgua'][$intV] = $numUltimoReciboAgua;
                    $arrViabilizados['txtUltimoReciboEnergia'][$intV] = $txtUltimoReciboEnergia;
                    $arrViabilizados['numUltimoReciboEnergia'][$intV] = $numUltimoReciboEnergia;
                    $arrViabilizados['txtOtro'][$intV] = $txtOtro;
                    $arrViabilizados['numOtros'][$intV] = $numOtros;
                    $arrViabilizados['bolViabilizoJuridico'][$intV] = $bolViabilizoJuridico;
                    $arrViabilizados['bolViabilizoTecnico'][$intV] = $bolViabilizoTecnico;
                    $arrViabilizados['txtNombreVendedor'][$intV] = $txtNombreVendedor;
                    $arrViabilizados['numDocumentoVendedor'][$intV] = $numDocumentoVendedor;
                    $arrViabilizados['numDocumentoVendedor'][$intV] = $numDocumentoVendedor;
                    $arrViabilizados['txtBarrio'][$intV] = $txtBarrio;
                    $arrViabilizados['seqLocalidad'][$intV] = $seqLocalidad;
                    $arrViabilizados['seqLocalidad'][$intV] = $seqLocalidad;
                    $arrViabilizados['numNotaria'][$intV] = $numNotaria;
                    $arrViabilizados['fchEscritura'][$intV] = $fchEscritura;
                    $arrViabilizados['numAvaluo'][$intV] = $numAvaluo;
                    $arrViabilizados['valInmueble'][$intV] = $valInmueble;
                    $arrViabilizados['txtMatriculaInmobiliaria'][$intV] = $txtMatriculaInmobiliaria;
                    $arrViabilizados['numValorInmueble'][$intV] = $numValorInmueble;
                    $arrViabilizados['txtChip'][$intV] = $txtChip;
                    $arrViabilizados['numActaEntrega'][$intV] = $numActaEntrega;
                    $arrViabilizados['txtActaEntrega'][$intV] = $txtActaEntrega;
                    $arrViabilizados['numCertificacionVendedor'][$intV] = $numCertificacionVendedor;
                    $arrViabilizados['txtCertificacionVendedor'][$intV] = $txtCertificacionVendedor;
                    $arrViabilizados['numAutorizacionDesembolso'][$intV] = $numAutorizacionDesembolso;
                    $arrViabilizados['txtAutorizacionDesembolso'][$intV] = $txtAutorizacionDesembolso;
                    $arrViabilizados['numFotocopiaVendedor'][$intV] = $numFotocopiaVendedor;
                    $arrViabilizados['txtFotocopiaVendedor'][$intV] = $txtFotocopiaVendedor;
                    $arrViabilizados['seqTipoDocumento'][$intV] = $seqTipoDocumento;
                    $arrViabilizados['numAreaLote'][$intV] = $numAreaLote;
                    $arrViabilizados['numAreaConstruida'][$intV] = $numAreaConstruida;
                    $arrViabilizados['txtCedulaCatastral'][$intV] = $txtCedulaCatastral;
                    $arrViabilizados['numTelefonoVendedor'][$intV] = $numTelefonoVendedor;
                    $arrViabilizados['txtTipoPredio'][$intV] = $txtTipoPredio;
                    $arrViabilizados['numRut'][$intV] = $numRut;
                    $arrViabilizados['txtRut'][$intV] = $txtRut;
                    $arrViabilizados['numRit'][$intV] = $numRit;
                    $arrViabilizados['txtRit'][$intV] = $txtRit;
                    $arrViabilizados['numNit'][$intV] = $numNit;
                    $arrViabilizados['txtNit'][$intV] = $txtNit;
                    $arrViabilizados['txtCompraVivienda'][$intV] = $txtCompraVivienda;
                    $arrViabilizados['numEstrato'][$intV] = $numEstrato;
                    $arrViabilizados['txtTipoDocumentos'][$intV] = $txtTipoDocumentos;
                    $arrViabilizados['txtCiudad'][$intV] = $txtCiudad;
                    $arrViabilizados['txtPropiedad'][$intV] = $txtPropiedad;
                    $arrViabilizados['txtCorreoVendedor'][$intV] = $txtCorreoVendedor;
                    $arrViabilizados['seqCiudad'][$intV] = $seqCiudad;
                    $intV++;
                }
            } else if ($band == 1) {
                echo "Por favor verifique el registro # " . ($registros + 1) . " todos los campos en el hogar " . $seqFormulario . " en la casilla(s) # " . $casilla . " con valor vacio o el formato de fecha no es el indicado";
                exit();
            }
        }
        $registros++;
    }
//echo "<br>".$idHogar;
    $arrSeqDesembolso = verificarRegistrosExistentes($arrViabilizados, $idDesembolso, $intV);
    //asignarEscrituracion($arrViabilizados, $idDesembolso, $intV);
} else {
    echo "Error de subida";
}

function obtenerEscrituracion($numFormulario) {
//    $db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sdht_subsidiosJul17', 'localhost');
    $db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sdth_subsidiosentrega', 'localhost');
    $consulta = "
        SELECT seqFormulario, seqDesembolso
            FROM T_DES_ESCRITURACION
        WHERE seqDesembolso in ($numFormulario)";
    $resultado = $db->get_results($consulta);
    //var_dump($resultado);
    $dato = Array();
    $intD = 0;

    // var_dump($resultado);
    foreach ($resultado as $res) {
        $dato[$res->seqDesembolso] = $res->seqFormulario;
        $intD++;
    }

    return $dato;
}

function asignarEscrituracion($arreglo, $desembolso, $cantidad) {

    $int = 1;
    $cantF = count($arreglo['seqFormulario']);
    $idSeqDesembolso = "";
    foreach ($arreglo['seqFormulario'] as $key => $value) {
        $seqFormulario = $arreglo['seqFormulario'][$int];
        $seqDesembolso = array_search($seqFormulario, $desembolso);
        if ($seqDesembolso != "") {
            $arreglo['seqDesembolso'][$int] = $seqDesembolso;
            $idSeqDesembolso .= $seqDesembolso . ",";
        }
        // echo "<br>**".$arreglo['seqFormulario'][$int]."- ".$seqDesembolso;   
        $int++;
    }
    $idSeqDesembolso = substr_replace($idSeqDesembolso, '', -1, 1);
    // print_r($arreglo);
    verificarRegistrosExistentes($arreglo, $idSeqDesembolso, $cantF, $tipo);
}

function verificarRegistrosExistentes($arreglo, $idSeqDesembolso, $cantF) {
    $db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sdth_subsidiosentrega', 'localhost');
    // $db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sdht_subsidiosJul17', 'localhost');
    $consulta = " SELECT seqDesembolso, seqEscrituracion FROM t_des_escrituracion WHERE seqDesembolso IN(" . $idSeqDesembolso . ")";
    $resultado = $db->get_results($consulta);
    $dato = Array();
    $intD = 1;
    if ($resultado) {
        foreach ($resultado as $res) {
            $dato[$intD] = $res->seqDesembolso;
            $intD++;
        }
    }
    //var_dump($arreglo);
    insertarEscrituracion($arreglo, $cantF, $dato, $idSeqDesembolso);
}

function insertarEscrituracion($arreglo, $cantF, $dato, $idSeqDesembolso) {

    $campos = " INSERT INTO t_des_escrituracion(seqDesembolso,         
                                seqFormulario ,
                                txtEscrituraPublica ,
                                numEscrituraPublica ,
                                txtCertificadoTradicion ,
                                numCertificadoTradicion ,
                                txtCartaAsignacion ,
                                numCartaAsignacion ,
                                txtAltoRiesgo ,
                                numAltoRiesgo ,
                                txtHabitabilidad ,
                                numHabitabilidad ,
                                txtBoletinCatastral ,
                                numBoletinCatastral ,
                                txtLicenciaConstruccion ,
                                numLicenciaConstruccion ,
                                txtUltimoPredial ,
                                numUltimoPredial ,
                                txtUltimoReciboAgua ,
                                numUltimoReciboAgua ,
                                txtUltimoReciboEnergia ,
                                numUltimoReciboEnergia ,
                                txtOtro ,
                                numOtros ,
                                bolViabilizoJuridico ,
                                bolViabilizoTecnico ,
                                txtNombreVendedor ,
                                numDocumentoVendedor ,
                                txtDireccionInmueble ,
                                txtBarrio ,
                                seqLocalidad ,
                                txtEscritura ,
                                numNotaria ,
                                fchEscritura ,
                                numAvaluo ,
                                valInmueble ,
                                txtMatriculaInmobiliaria ,
                                numValorInmueble ,
                                txtChip ,
                                numActaEntrega ,
                                txtActaEntrega ,
                                numCertificacionVendedor ,
                                txtCertificacionVendedor ,
                                numAutorizacionDesembolso ,
                                txtAutorizacionDesembolso ,
                                numFotocopiaVendedor ,
                                txtFotocopiaVendedor ,
                                seqTipoDocumento ,
                                numAreaLote ,
                                numAreaConstruida ,
                                txtCedulaCatastral ,
                                numTelefonoVendedor ,
                                txtTipoPredio ,
                                numRut ,
                                txtRut ,
                                numRit ,
                                txtRit ,
                                numNit ,
                                txtNit ,
                                txtCompraVivienda ,
                                numEstrato ,
                                txtTipoDocumentos ,
                                txtCiudad ,
                                txtPropiedad ,
                                txtCorreoVendedor ,
                                seqCiudad 
                                ) VALUES ";

    $int = 1;
    $ex = 1;
    $ArrImpresion = Array();

    if (count($dato) == 0) {
        foreach ($arreglo['seqFormulario'] as $key => $value) {

            if ($arreglo['seqDesembolso'][$int] != "") {
                echo $value . "<br>";
                $valores .= "('" . $arreglo['seqDesembolso'][$int] . "',
                       '" . $arreglo['seqFormulario'][$int] . "',
                        '" . $arreglo['txtEscrituraPublica'][$int] . "',
                        '" . $arreglo['numEscrituraPublica'][$int] . "',
                        '" . $arreglo['txtCertificadoTradicion'][$int] . "',
                        '" . $arreglo['numCertificadoTradicion'][$int] . "',
                        '" . $arreglo['txtCartaAsignacion'][$int] . "',
                        '" . $arreglo['numCartaAsignacion'][$int] . "',
                        '" . $arreglo['txtAltoRiesgo'][$int] . "',
                        '" . $arreglo['numAltoRiesgo'][$int] . "',
                        '" . $arreglo['txtHabitabilidad'][$int] . "',
                        '" . $arreglo['numHabitabilidad'][$int] . "',
                        '" . $arreglo['txtBoletinCatastral'][$int] . "',
                        '" . $arreglo['numBoletinCatastral'][$int] . "',
                        '" . $arreglo['txtLicenciaConstruccion'][$int] . "',
                        '" . $arreglo['numLicenciaConstruccion'][$int] . "',
                        '" . $arreglo['txtUltimoPredial'][$int] . "',
                        '" . $arreglo['numUltimoPredial'][$int] . "',
                        '" . $arreglo['txtUltimoReciboAgua'][$int] . "',
                        '" . $arreglo['numUltimoReciboAgua'][$int] . "',
                        '" . $arreglo['txtUltimoReciboEnergia'][$int] . "',
                        '" . $arreglo['numUltimoReciboEnergia'][$int] . "',
                        '" . $arreglo['txtOtro'][$int] . "',
                        '" . $arreglo['numOtros'][$int] . "',
                        '" . $arreglo['bolViabilizoJuridico'][$int] . "',
                        '" . $arreglo['bolViabilizoTecnico'][$int] . "',
                        '" . $arreglo['txtNombreVendedor'][$int] . "',
                        '" . $arreglo['numDocumentoVendedor'][$int] . "',
                        '" . $arreglo['txtDireccionInmueble'][$int] . "',
                        '" . $arreglo['txtBarrio'][$int] . "',
                        '" . $arreglo['seqLocalidad'][$int] . "',
                        '" . $arreglo['txtEscritura'][$int] . "',
                        '" . $arreglo['numNotaria'][$int] . "',
                        '" . $arreglo['fchEscritura'][$int] . "',
                        '" . $arreglo['numAvaluo'][$int] . "',
                        '" . $arreglo['valInmueble'][$int] . "',
                        '" . $arreglo['txtMatriculaInmobiliaria'][$int] . "',
                        '" . $arreglo['numValorInmueble'][$int] . "',
                        '" . $arreglo['txtChip'][$int] . "',
                        '" . $arreglo['numActaEntrega'][$int] . "',
                        '" . $arreglo['txtActaEntrega'][$int] . "',
                        '" . $arreglo['numCertificacionVendedor'][$int] . "',
                        '" . $arreglo['txtCertificacionVendedor'][$int] . "',
                        '" . $arreglo['numAutorizacionDesembolso'][$int] . "',
                        '" . $arreglo['txtAutorizacionDesembolso'][$int] . "',
                        '" . $arreglo['numFotocopiaVendedor'][$int] . "',
                        '" . $arreglo['txtFotocopiaVendedor'][$int] . "',
                        '" . $arreglo['seqTipoDocumento'][$int] . "',
                        '" . $arreglo['numAreaLote'][$int] . "',
                        '" . $arreglo['numAreaConstruida'][$int] . "',
                        '" . $arreglo['txtCedulaCatastral'][$int] . "',
                        '" . $arreglo['numTelefonoVendedor'][$int] . "',
                        '" . $arreglo['txtTipoPredio'][$int] . "',
                        '" . $arreglo['numRut'][$int] . "',
                        '" . $arreglo['txtRut'][$int] . "',
                        '" . $arreglo['numRit'][$int] . "',
                        '" . $arreglo['txtRit'][$int] . "',
                        '" . $arreglo['numNit'][$int] . "',
                        '" . $arreglo['txtNit'][$int] . "',
                        '" . $arreglo['txtCompraVivienda'][$int] . "',
                        '" . $arreglo['numEstrato'][$int] . "',
                        '" . $arreglo['txtTipoDocumentos'][$int] . "',
                        '" . $arreglo['txtCiudad'][$int] . "',
                        '" . $arreglo['txtPropiedad'][$int] . "',
                        '" . $arreglo['txtCorreoVendedor'][$int] . "',
                        '" . $arreglo['seqCiudad'][$int] . "'";

                $valores .= "),";
            }
            $int++;
        }
    } else {
        $existen = '';
        $existen1 = '';
        foreach ($arreglo['seqFormulario'] as $key => $value) {
            $seqDesembolso = array_search(trim($arreglo['seqDesembolso'][$int]), $dato);
            if ($seqDesembolso == "") {
                if ($arreglo['seqDesembolso'][$int] != "") {
                    $valores .= "('" . $arreglo['seqDesembolso'][$int] . "',
                       '" . $arreglo['seqFormulario'][$int] . "',
                        '" . $arreglo['txtEscrituraPublica'][$int] . "',
                        '" . $arreglo['numEscrituraPublica'][$int] . "',
                        '" . $arreglo['txtCertificadoTradicion'][$int] . "',
                        '" . $arreglo['numCertificadoTradicion'][$int] . "',
                        '" . $arreglo['txtCartaAsignacion'][$int] . "',
                        '" . $arreglo['numCartaAsignacion'][$int] . "',
                        '" . $arreglo['txtAltoRiesgo'][$int] . "',
                        '" . $arreglo['numAltoRiesgo'][$int] . "',
                        '" . $arreglo['txtHabitabilidad'][$int] . "',
                        '" . $arreglo['numHabitabilidad'][$int] . "',
                        '" . $arreglo['txtBoletinCatastral'][$int] . "',
                        '" . $arreglo['numBoletinCatastral'][$int] . "',
                        '" . $arreglo['txtLicenciaConstruccion'][$int] . "',
                        '" . $arreglo['numLicenciaConstruccion'][$int] . "',
                        '" . $arreglo['txtUltimoPredial'][$int] . "',
                        '" . $arreglo['numUltimoPredial'][$int] . "',
                        '" . $arreglo['txtUltimoReciboAgua'][$int] . "',
                        '" . $arreglo['numUltimoReciboAgua'][$int] . "',
                        '" . $arreglo['txtUltimoReciboEnergia'][$int] . "',
                        '" . $arreglo['numUltimoReciboEnergia'][$int] . "',
                        '" . $arreglo['txtOtro'][$int] . "',
                        '" . $arreglo['numOtros'][$int] . "',
                        '" . $arreglo['bolViabilizoJuridico'][$int] . "',
                        '" . $arreglo['bolViabilizoTecnico'][$int] . "',
                        '" . $arreglo['txtNombreVendedor'][$int] . "',
                        '" . $arreglo['numDocumentoVendedor'][$int] . "',
                        '" . $arreglo['txtDireccionInmueble'][$int] . "',
                        '" . $arreglo['txtBarrio'][$int] . "',
                        '" . $arreglo['seqLocalidad'][$int] . "',
                        '" . $arreglo['txtEscritura'][$int] . "',
                        '" . $arreglo['numNotaria'][$int] . "',
                        '" . $arreglo['fchEscritura'][$int] . "',
                        '" . $arreglo['numAvaluo'][$int] . "',
                        '" . $arreglo['valInmueble'][$int] . "',
                        '" . $arreglo['txtMatriculaInmobiliaria'][$int] . "',
                        '" . $arreglo['numValorInmueble'][$int] . "',
                        '" . $arreglo['txtChip'][$int] . "',
                        '" . $arreglo['numActaEntrega'][$int] . "',
                        '" . $arreglo['txtActaEntrega'][$int] . "',
                        '" . $arreglo['numCertificacionVendedor'][$int] . "',
                        '" . $arreglo['txtCertificacionVendedor'][$int] . "',
                        '" . $arreglo['numAutorizacionDesembolso'][$int] . "',
                        '" . $arreglo['txtAutorizacionDesembolso'][$int] . "',
                        '" . $arreglo['numFotocopiaVendedor'][$int] . "',
                        '" . $arreglo['txtFotocopiaVendedor'][$int] . "',
                        '" . $arreglo['seqTipoDocumento'][$int] . "',
                        '" . $arreglo['numAreaLote'][$int] . "',
                        '" . $arreglo['numAreaConstruida'][$int] . "',
                        '" . $arreglo['txtCedulaCatastral'][$int] . "',
                        '" . $arreglo['numTelefonoVendedor'][$int] . "',
                        '" . $arreglo['txtTipoPredio'][$int] . "',
                        '" . $arreglo['numRut'][$int] . "',
                        '" . $arreglo['txtRut'][$int] . "',
                        '" . $arreglo['numRit'][$int] . "',
                        '" . $arreglo['txtRit'][$int] . "',
                        '" . $arreglo['numNit'][$int] . "',
                        '" . $arreglo['txtNit'][$int] . "',
                        '" . $arreglo['txtCompraVivienda'][$int] . "',
                        '" . $arreglo['numEstrato'][$int] . "',
                        '" . $arreglo['txtTipoDocumentos'][$int] . "',
                        '" . $arreglo['txtCiudad'][$int] . "',
                        '" . $arreglo['txtPropiedad'][$int] . "',
                        '" . $arreglo['txtCorreoVendedor'][$int] . "',
                        '" . $arreglo['seqCiudad'][$int] . "'";
                    $valores .= "),";

                    $ex++;
                }
            } else {
                $existen1 = $arreglo['seqFormulario'][$int] . ", ";
                $existen .= $existen1;
            }


            $int++;
        }
    }
    // $db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sdht_subsidiosJul17', 'localhost');
    $db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sdth_subsidiosentrega', 'localhost');
    //echo $valores;
    if ($valores != "") {
        $valores = substr_replace($valores, ';', -1, 1);
        echo $query = $campos . $valores;
        exit();
        $result = $db->query($query);
    }

    //  echo "<br>*".$query ."<br>";
    if ($existen != "") {
        $cantidaE = ($int) - $ex;
        // $existen = substr_replace(trim($existen), ';', -1, 1);
        echo "<p> Los formularios que se muestran a continuaci&oacute;n se encuentr&aacute;n previamente almacenados: <br><b> " . $existen . " </b><br> son en total <b>" . $cantidaE . " Registros </b> de un total de " . ($int - 1) . " Registros </p>";
    }

//var_dump($dato);exit();
}

?>