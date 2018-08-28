<?php

include_once '../conecta.php';

include '../migrarTablero.php';

$sql = "SET CHARSET utf8";
$db->get_results($sql);

$observacion1 = 'PROPIETARIOS SON BENEFICIARIOS DEL SDV';
$observacion2 = 'ESTADO CIVIL COINCIDENTE';
$observacion3 = 'CONSTITUCIÓN PATRIMONIO DE FAMILIA';
$observacion4 = 'RESTRICCIONES';
$observacion5 = 'PATRIMONIO DE FAMILIA REGISTRADO';
$observacion6 = 'NOMBRE Y CÉDULA DE LOS PROPIETARIOS';
$observacion7 = 'COMPRAVENTA REALIZADA CON SDV';
$observacion8 = 'INDAGACION AFECTACION A VIVIENDA FAMILIAR';
$observacion9 = 'PROHIBICION DE TRANSFERENCIA Y DERECHO DE PREFERENCIA REGISTRADOS';
$documentos1 = 'ESCRITURA PÚBLICA';
$documentos2 = 'FOLIO DE MATRÍCULA INMOBILIARIA';
$documentos3 = 'CERTIFICADO DE EXISTENCIA Y HABITABILIDAD VIABILIZADO';
$documentos4 = 'RESOLUCIÓN O CARTA DE VINCULACIÓN DEL BENEFICIO OTORGADO POR SDHT';

$arrViabilizados = Array();
$arrNoViabilizados = Array();
$idHogar = "";

if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
    $nombreArchivo = $_FILES['archivo']['tmp_name'];

    $lineas = file($nombreArchivo);
    //var_dump($lineas);    exit();
    $registros = 0;
    global $db;
    $intV = 1;
    $intNV = 1;
    $band = 0;
    $cant = count($lineas);
    $valid = "";
    foreach ($lineas as $linea_num => $linea) {
        $valid = "";
        if ($linea_num != 0 && $linea_num != "") {
            $datos = explode("\t", $linea);
            foreach ($datos as $i => $txtValor) {
                $datos[$i] = mb_ereg_replace("[^a-zA-Z0-9\-\_\/\\\ \,\.\;\:áéíóúñüÁÉÍÓÚÜÑ\#]", "", utf8_encode(trim($txtValor)));
            }

//            echo "<pre>";
//            print_r( $datos );
//            echo "</pre>";
//
//            echo "****" . strtotime($datos[11]) . "<br>";
//            die();

            $casilla = "";

            $seqFormulario = trim($datos [0]);
            if ($registros < $cant - 2) {
                $idHogar .= $seqFormulario . ",";
            } else
                $idHogar .= $seqFormulario;

            //$seqDesembolso = obtenerDesembolso(trim($datos [0]));
            $numEscrituraIdentificacion = trim($datos [10]);
            $fchEscrituraIdentificacion = trim($datos [11]);
            $numNotariaIdentificacion = trim($datos [12]);
            $numEscrituraTitulo = trim($datos [18]);
            $fchEscrituraTitulo = trim($datos [19]);
            $numNotariaTitulo = trim($datos [20]);
            $numFolioMatricula = trim($datos [34]);
            $txtZonaMatricula = trim($datos [23]);
            $fchMatricula = trim($datos [25]);
            $bolSubsidioSDHT = 1;
            $bolSubsidioFonvivienda = 0;
            $numResolucionFonvivienda = 'null';
            $numAnoResolucionFonvivienda = 'null';
            $txtAprobo = trim($datos [40]);
            $fchCreacion = 'now()';
            $fchActualizacion = 'null';
            $txtCiudadTitulo = 'Bogota';
            $txtCiudadIdentificacion = 'Bogota';
            $txtCiudadMatricula = 'Bogota';
            $txtElaboro = trim($datos [39]);
            $txtConcepto = trim(str_replace('"', '', $datos [42]));
            $viabilizado = (trim($datos [41]) == 'SI') ? true : false;
            $numDocumento = trim($datos [1]);

            if ($seqFormulario == "" || $numEscrituraIdentificacion == "" || $numNotariaIdentificacion == "" || $numEscrituraTitulo == "" || trim($datos [41]) == "") {

                $casilla .= ($seqFormulario == '') ? "1," : '';
                $casilla .= ($numEscrituraIdentificacion == '') ? "11," : '';
                $casilla .= ($numNotariaIdentificacion == '') ? "13," : '';
                $casilla .= ($numEscrituraTitulo == '') ? "12," : '';
                $casilla .= (trim($datos [41]) == '') ? "42," : '';
                $band = 1;
            }
            if ($numNotariaTitulo == "" || $numFolioMatricula == "" || $txtZonaMatricula == "" || $txtAprobo == "" || $txtElaboro == "" || $txtConcepto == "") {
                $casilla .= ($numNotariaTitulo == '') ? "13," : '';
                $casilla .= ($numFolioMatricula == '') ? "35," : '';
                $casilla .= ($txtZonaMatricula == '') ? "24," : '';
                $casilla .= ($txtAprobo == '') ? "41," : '';
                $casilla .= ($txtElaboro == '') ? "40," : '';
                $txtConcepto = ($txtElaboro == '') ? "43," : '';
                $band = 1;
            }

            $CfchEscrituraTitulo = explode("/", $fchEscrituraTitulo);
            if ($CfchEscrituraTitulo[1] != "") {
                $fchEscrituraTitulo = $CfchEscrituraTitulo[2] . "-" . $CfchEscrituraTitulo[1] . "-" . $CfchEscrituraTitulo[0];
            }

            $CfchEscrituraIdentificacion = explode("/", $fchEscrituraIdentificacion);
            if ($CfchEscrituraIdentificacion[1] != "") {
                $fchEscrituraIdentificacion = $CfchEscrituraIdentificacion[2] . "-" . $CfchEscrituraIdentificacion[1] . "-" . $CfchEscrituraIdentificacion[0];
            }
            $CfchMatricula = explode("/", $fchMatricula);
            if ($CfchMatricula[1] != "") {
                $fchMatricula = $CfchMatricula[2] . "-" . $CfchMatricula[1] . "-" . $CfchMatricula[0];
            }
            if ($datos[27] == "" || $datos[32] == "" || $datos[29] == "" || $datos[31] == "" || $datos[36] == "" || $datos[28] == "") {
                $casilla .= (trim($datos[27]) == '') ? "27," : '';
                $casilla .= (trim($datos[32]) == '') ? "32," : '';
                $casilla .= (trim($datos[29]) == '') ? "29," : '';
                $casilla .= (trim($datos[31]) == '') ? "31," : '';
                $casilla .= (trim($datos[36]) == '') ? "36," : '';
                $casilla .= (trim($datos[28]) == '') ? "28," : '';
                $band = 1;
            }
            if ($datos[18] == "" || $datos[14] == "" || $datos[42] == "") {
                $casilla .= (trim($datos[18]) == '') ? "18," : '';
                $casilla .= (trim($datos[14]) == '') ? "14," : '';
                $casilla .= (trim($datos[42]) == '') ? "42," : '';
                $band = 1;
            }


            if ($datos[29] == "NO APLICA" && $datos[30] == "NO APLICA" && $datos[31] == "NO APLICA" && $datos[32] == "NO APLICA") {
                $valid = "NO";
            }
//        echo "<br>***" . $registros . " fchEscrituraIdentificacion -> " . $fchEscrituraIdentificacion . " fchMatricula-> " . $fchMatricula;
//        echo "<br>***" . $registros . " fchEscrituraIdentificacion -> " . strtotime($fchEscrituraIdentificacion) . " fchMatricula-> " . strtotime($fchMatricula);
            if (strtotime($fchEscrituraIdentificacion) == "" || strtotime($fchMatricula) == "") {
                $casilla .= (strtotime($fchEscrituraIdentificacion) == '') ? "12" : '';
                $casilla .= (strtotime($fchMatricula) == '') ? "26" : '';
                $band = 1;
            }

            $arrTitulos['numEscritura'] = $numEscrituraTitulo;
            $arrTitulos['fchEscritura'] = $fchEscrituraTitulo;
            $arrTitulos['numNotaria'] = $numNotariaTitulo;
            $arrTitulos['txtCiudad'] = $txtCiudadTitulo;
            $arrEscrituracion = obtenerEscrituracion($seqFormulario);
            if (
                    $arrTitulos['numEscritura'] != $arrEscrituracion['numEscritura'] or
                    strtotime($arrTitulos['fchEscritura']) != strtotime($arrEscrituracion['fchEscritura']) or
                    $arrTitulos['numNotaria'] != $arrEscrituracion['numNotaria'] or
                    mb_strtolower(trim($arrTitulos['txtCiudad'])) != mb_strtolower(trim($arrEscrituracion['txtCiudad']))
            ) {
                /* echo "<br>" . $arrTitulos['numEscritura'] . " != " . $arrEscrituracion['numEscritura'];
                  echo $arrTitulos['fchEscritura'] . " != " . $arrEscrituracion['fchEscritura'];
                  echo $arrTitulos['numNotaria'] . " != " . $arrEscrituracion['numNotaria'];
                  echo $arrTitulos['txtCiudad'] . " != " . $arrEscrituracion['txtCiudad'] . "<br>"; */
                $casilla .= "18,19,20,21";
                $band = 2;
            }

            if ($viabilizado && $band == 0) {
                if ($seqFormulario != "") {
                    $arrViabilizados['seqFormulario'][$intV] = $seqFormulario;
                    $arrViabilizados['numEscrituraIdentificacion'][$intV] = $numEscrituraIdentificacion;
                    $arrViabilizados['fchEscrituraIdentificacion'][$intV] = $fchEscrituraIdentificacion;
                    $arrViabilizados['numNotariaIdentificacion'][$intV] = $numNotariaIdentificacion;
                    $arrViabilizados['numEscrituraTitulo'][$intV] = $numEscrituraTitulo;
                    $arrViabilizados['fchEscrituraTitulo'][$intV] = $fchEscrituraTitulo;
                    $arrViabilizados['numNotariaTitulo'][$intV] = $numNotariaTitulo;
                    $arrViabilizados['numFolioMatricula'][$intV] = $numFolioMatricula;
                    $arrViabilizados['txtZonaMatricula'][$intV] = $txtZonaMatricula;
                    $arrViabilizados['fchMatricula'][$intV] = $fchMatricula;
                    $arrViabilizados['bolSubsidioSDHT'][$intV] = $bolSubsidioSDHT;
                    $arrViabilizados['bolSubsidioFonvivienda'][$intV] = $bolSubsidioFonvivienda;
                    $arrViabilizados['numResolucionFonvivienda'][$intV] = $numResolucionFonvivienda;
                    $arrViabilizados['numAnoResolucionFonvivienda'][$intV] = $numAnoResolucionFonvivienda;
                    $arrViabilizados['txtAprobo'][$intV] = $txtAprobo;
                    $arrViabilizados['fchCreacion'][$intV] = $fchCreacion;
                    $arrViabilizados['fchActualizacion'][$intV] = $fchActualizacion;
                    $arrViabilizados['txtCiudadTitulo'][$intV] = $txtCiudadTitulo;
                    $arrViabilizados['txtCiudadIdentificacion'][$intV] = $txtCiudadIdentificacion;
                    $arrViabilizados['txtCiudadMatricula'][$intV] = $txtCiudadMatricula;
                    $arrViabilizados['txtElaboro'][$intV] = $txtElaboro;
                    $arrViabilizados['numdocumento'][$intV] = $numDocumento;
                    $arrViabilizados['beneficiarios'][$intV] = $observacion1;
                    $arrViabilizados['estado'][$intV] = ($datos[32] == 'NO APLICA') ? '' : $observacion2;
                    $arrViabilizados['constitucion'][$intV] = ($datos[29] == 'NO APLICA') ? '' : $observacion3;
                    $arrViabilizados['resticciones'][$intV] = ($datos[31] == 'NO APLICA') ? '' : $observacion4;
                    $arrViabilizados['patrimonio'][$intV] = $observacion5;
                    $arrViabilizados['propietarios'][$intV] = $observacion6;
                    $arrViabilizados['compraVenta'][$intV] = $observacion7;
                    $arrViabilizados['indagacion'][$intV] = ($datos[30] == 'NO APLICA') ? '' : $observacion8;
                    $arrViabilizados['transferencia'][$intV] = $observacion9;
                    $arrViabilizados['noEscritura'][$intV] = ($valid == 'NO') ? '' : $documentos1;
                    $arrViabilizados['folio'][$intV] = $documentos2;
                    $arrViabilizados['certificado'][$intV] = ($valid == 'NO') ? '' : $documentos3;
                    $arrViabilizados['carta'][$intV] = $documentos4;
                    $arrViabilizados['observacion'][$intV] = utf8_decode($txtConcepto);
                    $intV++;
                    //echo "jkchsadk";
                }
            } else if ($viabilizado == false) {
                if ($seqFormulario != "") {
                    $arrNoViabilizados['seqFormulario'][$intNV] = $seqFormulario;
                    $arrNoViabilizados['numEscrituraIdentificacion'][$intNV] = $numEscrituraIdentificacion;
                    $arrNoViabilizados['fchEscrituraIdentificacion'][$intNV] = $fchEscrituraIdentificacion;
                    $arrNoViabilizados['numNotariaIdentificacion'][$intNV] = $numNotariaIdentificacion;
                    $arrNoViabilizados['numEscrituraTitulo'][$intNV] = $numEscrituraTitulo;
                    $arrNoViabilizados['fchEscrituraTitulo'][$intNV] = $fchEscrituraTitulo;
                    $arrNoViabilizados['numNotariaTitulo'][$intNV] = $numNotariaTitulo;
                    $arrNoViabilizados['numFolioMatricula'][$intNV] = $numFolioMatricula;
                    $arrNoViabilizados['txtZonaMatricula'][$intNV] = $txtZonaMatricula;
                    $arrNoViabilizados['fchMatricula'][$intNV] = $fchMatricula;
                    $arrNoViabilizados['bolSubsidioSDHT'][$intNV] = $bolSubsidioSDHT;
                    $arrNoViabilizados['bolSubsidioFonvivienda'][$intNV] = $bolSubsidioFonvivienda;
                    $arrNoViabilizados['numResolucionFonvivienda'][$intNV] = $numResolucionFonvivienda;
                    $arrNoViabilizados['numAnoResolucionFonvivienda'][$intNV] = $numAnoResolucionFonvivienda;
                    $arrNoViabilizados['txtAprobo'][$intNV] = $txtAprobo;
                    $arrNoViabilizados['fchCreacion'][$intNV] = $fchCreacion;
                    $arrNoViabilizados['fchActualizacion'][$intNV] = $fchActualizacion;
                    $arrNoViabilizados['txtCiudadTitulo'][$intNV] = $txtCiudadTitulo;
                    $arrNoViabilizados['txtCiudadIdentificacion'][$intNV] = $txtCiudadIdentificacion;
                    $arrNoViabilizados['txtCiudadMatricula'][$intNV] = $txtCiudadMatricula;
                    $arrNoViabilizados['txtElaboro'][$intNV] = $txtElaboro;
                    $arrNoViabilizados['numdocumento'][$intNV] = $numDocumento;
                    $arrNoViabilizados['beneficiarios'][$intNV] = $observacion1;
                    $arrNoViabilizados['estado'][$intNV] = ($datos[32] == 'NO APLICA') ? '' : $observacion2;
                    $arrNoViabilizados['constitucion'][$intNV] = ($datos[29] == 'NO APLICA') ? '' : $observacion3;
                    $arrNoViabilizados['resticciones'][$intNV] = ($datos[31] == 'NO APLICA') ? '' : $observacion4;
                    $arrNoViabilizados['patrimonio'][$intNV] = $observacion5;
                    $arrNoViabilizados['propietarios'][$intNV] = $observacion6;
                    $arrNoViabilizados['compraVenta'][$intNV] = $observacion7;
                    $arrNoViabilizados['indagacion'][$intNV] = ($datos[30] == 'NO APLICA') ? '' : $observacion8;
                    $arrNoViabilizados['transferencia'][$intNV] = $observacion9;
                    $arrNoViabilizados['noEscritura'][$intNV] = ($valid == 'NO') ? '' : $documentos1;
                    $arrNoViabilizados['folio'][$intNV] = $documentos2;
                    $arrNoViabilizados['certificado'][$intNV] = ($valid == 'NO') ? '' : $documentos3;
                    $arrNoViabilizados['carta'][$intNV] = $documentos4;
                    $arrNoViabilizados['observacion'][$intNV] = utf8_decode($txtConcepto);
                    $intNV++;
                }
            } else if ($band == 1) {
                echo "Por favor verifique el registro # " . ($registros) . " todos los campos en el hogar " . $seqFormulario . " en la(s) casilla(s) # " . $casilla . " con valor vacio o el formato de fecha no es el indicado";
                exit();
            } else if ($band == 2) {
                echo "Por favor verifique los datos de titulos del registro # " . ($registros + 1) . " en el hogar " . $seqFormulario . " en la(s) casilla(s) # " . $casilla . " no corresponden con los datos de escrituración en la base de datos";
                exit();
            }
            $registros++;
        }
    }

    $validar = validarDocumentos($idHogar, $db, 31, 24, "Escrituración");
    if ($validar) {
        $arrSeqDesembolso = obtenerDesembolso($idHogar);
        //var_dump($arrSeqDesembolso);    exit();

        asignarDesembolso($arrViabilizados, $arrSeqDesembolso, $intV, 1);
        asignarDesembolso($arrNoViabilizados, $arrSeqDesembolso, $intNV, 2);
    }
} else {
    echo "Error de subida";
}

function obtenerDesembolso($numFormulario) {
    global $db;
    $consulta = "
        SELECT seqFormulario, seqDesembolso
            FROM T_DES_DESEMBOLSO
        WHERE seqFormulario in ($numFormulario)";
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

function asignarDesembolso($arreglo, $desembolso, $cantidad, $tipo) {
    if (!empty($arreglo)) {
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
}

function verificarRegistrosExistentes($arreglo, $idSeqDesembolso, $cantF, $tipo) {
    global $db;
    $consulta = " SELECT seqDesembolso, seqEstudioTitulos FROM t_des_estudio_titulos WHERE seqDesembolso IN(" . $idSeqDesembolso . ")";
    $resultado = $db->get_results($consulta);
    $dato = Array();
    $intD = 1;
    if ($resultado) {
        foreach ($resultado as $res) {
            $dato[$intD] = $res->seqDesembolso;
            $intD++;
        }
    }

    insertarEstudiosTitulos($arreglo, $cantF, $tipo, $intD, $dato, $idSeqDesembolso);
}

function insertarEstudiosTitulos($arreglo, $cantF, $tipo, $intD, $dato, $idSeqDesembolso) {

    global $db;
    $campos = " INSERT INTO t_des_estudio_titulos(seqDesembolso,
                numEscrituraIdentificacion,
                fchEscrituraIdentificacion,
                numNotariaIdentificacion,
                numEscrituraTitulo,
                fchEscrituraTitulo,
                numNotariaTitulo,
                numFolioMatricula,
                txtZonaMatricula,
                fchMatricula,
                bolSubsidioSDHT,
                bolSubsidioFonvivienda,
                numResolucionFonvivienda,
                numAnoResolucionFonvivienda,
                txtAprobo,
                fchCreacion,
                fchActualizacion,
                txtCiudadTitulo,
                txtCiudadIdentificacion,
                txtCiudadMatricula,
                txtElaboro) VALUES ";

    $int = 1;
    $ex = 1;
    $ArrImpresion = Array();
    if (count($dato) == 0) {
        foreach ($arreglo['seqFormulario'] as $key => $value) {
            if ($arreglo['seqDesembolso'][$int] != "") {
                $valores .= "(";
                $valores .= ( is_null($arreglo['seqDesembolso'][$int]) ) ? "null" : intval($arreglo['seqDesembolso'][$int]) . ",";
                $valores .= ( is_null($arreglo['numEscrituraIdentificacion'][$int]) ) ? "null" : intval($arreglo['numEscrituraIdentificacion'][$int]) . ",";
                $valores .= ( is_null($arreglo['fchEscrituraIdentificacion'][$int]) ) ? "null" : "'" . trim($arreglo['fchEscrituraIdentificacion'][$int]) . "',";
                $valores .= ( is_null($arreglo['numNotariaIdentificacion'][$int]) ) ? "null" : intval($arreglo['numNotariaIdentificacion'][$int]) . ",";
                $valores .= ( is_null($arreglo['numEscrituraTitulo'][$int]) ) ? "null" : intval($arreglo['numEscrituraTitulo'][$int]) . ",";
                $valores .= ( is_null($arreglo['fchEscrituraTitulo'][$int]) ) ? "null" : "'" . trim($arreglo['fchEscrituraTitulo'][$int]) . "',";
                $valores .= ( is_null($arreglo['numNotariaTitulo'][$int]) ) ? "null" : intval($arreglo['numNotariaTitulo'][$int]) . ",";
                $valores .= ( is_null($arreglo['numFolioMatricula'][$int]) ) ? "null" : intval($arreglo['numFolioMatricula'][$int]) . ",";
                $valores .= ( is_null($arreglo['txtZonaMatricula'][$int]) ) ? "null" : "'" . trim($arreglo['txtZonaMatricula'][$int]) . "',";
                $valores .= ( is_null($arreglo['fchMatricula'][$int]) ) ? "null" : "'" . trim($arreglo['fchMatricula'][$int]) . "',";
                $valores .= ( is_null($arreglo['bolSubsidioSDHT'][$int]) ) ? "null" : intval($arreglo['bolSubsidioSDHT'][$int]) . ",";
                $valores .= ( is_null($arreglo['bolSubsidioFonvivienda'][$int]) ) ? "null" : intval($arreglo['bolSubsidioFonvivienda'][$int]) . ",";
                $valores .= ( is_null($arreglo['numResolucionFonvivienda'][$int]) ) ? "null" : intval($arreglo['numResolucionFonvivienda'][$int]) . ",";
                $valores .= ( is_null($arreglo['numAnoResolucionFonvivienda'][$int]) ) ? "null" : intval($arreglo['numAnoResolucionFonvivienda'][$int]) . ",";
                $valores .= ( is_null($arreglo['txtAprobo'][$int]) ) ? "null" : "'" . trim($arreglo['txtAprobo'][$int]) . "',";
                $valores .= trim($arreglo['fchCreacion'][$int]) . ",";
                $valores .= trim($arreglo['fchActualizacion'][$int]) . ",";
                $valores .= ( is_null($arreglo['txtCiudadTitulo'][$int]) ) ? "null" : "'" . trim($arreglo['txtCiudadTitulo'][$int]) . "',";
                $valores .= ( is_null($arreglo['txtCiudadIdentificacion'][$int]) ) ? "null" : "'" . trim($arreglo['txtCiudadIdentificacion'][$int]) . "',";
                $valores .= ( is_null($arreglo['txtCiudadMatricula'][$int]) ) ? "null" : "'" . trim($arreglo['txtCiudadMatricula'][$int]) . "',";
                $valores .= ( is_null($arreglo['txtElaboro'][$int]) ) ? "null" : "'" . trim($arreglo['txtElaboro'][$int]) . "'";
                $valores .= "),";
                $ArrImpresion['seqFormulario'][$int] = $value;
                $ArrImpresion['seqDesembolso'][$int] = $arreglo['seqDesembolso'][$int];
                $ArrImpresion['txtElaboro'][$int] = $arreglo['txtElaboro'][$int];
                $ArrImpresion['txtAprobo'][$int] = $arreglo['txtAprobo'][$int];
                $ArrImpresion['numdocumento'][$int] = $arreglo['numdocumento'][$int];
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

                    $valores .= "(";
                    $valores .= ( is_null($arreglo['seqDesembolso'][$int]) ) ? "null" : intval($arreglo['seqDesembolso'][$int]) . ",";
                    $valores .= ( is_null($arreglo['numEscrituraIdentificacion'][$int]) ) ? "null" : intval($arreglo['numEscrituraIdentificacion'][$int]) . ",";
                    $valores .= ( is_null($arreglo['fchEscrituraIdentificacion'][$int]) ) ? "null" : "'" . trim($arreglo['fchEscrituraIdentificacion'][$int]) . "',";
                    $valores .= ( is_null($arreglo['numNotariaIdentificacion'][$int]) ) ? "null" : intval($arreglo['numNotariaIdentificacion'][$int]) . ",";
                    $valores .= ( is_null($arreglo['numEscrituraTitulo'][$int]) ) ? "null" : intval($arreglo['numEscrituraTitulo'][$int]) . ",";
                    $valores .= ( is_null($arreglo['fchEscrituraTitulo'][$int]) ) ? "null" : "'" . trim($arreglo['fchEscrituraTitulo'][$int]) . "',";
                    $valores .= ( is_null($arreglo['numNotariaTitulo'][$int]) ) ? "null" : intval($arreglo['numNotariaTitulo'][$int]) . ",";
                    $valores .= ( is_null($arreglo['numFolioMatricula'][$int]) ) ? "null" : intval($arreglo['numFolioMatricula'][$int]) . ",";
                    $valores .= ( is_null($arreglo['txtZonaMatricula'][$int]) ) ? "null" : "'" . trim($arreglo['txtZonaMatricula'][$int]) . "',";
                    $valores .= ( is_null($arreglo['fchMatricula'][$int]) ) ? "null" : "'" . trim($arreglo['fchMatricula'][$int]) . "',";
                    $valores .= ( is_null($arreglo['bolSubsidioSDHT'][$int]) ) ? "null" : intval($arreglo['bolSubsidioSDHT'][$int]) . ",";
                    $valores .= ( is_null($arreglo['bolSubsidioFonvivienda'][$int]) ) ? "null" : intval($arreglo['bolSubsidioFonvivienda'][$int]) . ",";
                    $valores .= ( is_null($arreglo['numResolucionFonvivienda'][$int]) ) ? "null" : intval($arreglo['numResolucionFonvivienda'][$int]) . ",";
                    $valores .= ( is_null($arreglo['numAnoResolucionFonvivienda'][$int]) ) ? "null" : intval($arreglo['numAnoResolucionFonvivienda'][$int]) . ",";
                    $valores .= ( is_null($arreglo['txtAprobo'][$int]) ) ? "null" : "'" . trim($arreglo['txtAprobo'][$int]) . "',";
                    $valores .= trim($arreglo['fchCreacion'][$int]) . ",";
                    $valores .= trim($arreglo['fchActualizacion'][$int]) . ",";
                    $valores .= ( is_null($arreglo['txtCiudadTitulo'][$int]) ) ? "null" : "'" . trim($arreglo['txtCiudadTitulo'][$int]) . "',";
                    $valores .= ( is_null($arreglo['txtCiudadIdentificacion'][$int]) ) ? "null" : "'" . trim($arreglo['txtCiudadIdentificacion'][$int]) . "',";
                    $valores .= ( is_null($arreglo['txtCiudadMatricula'][$int]) ) ? "null" : "'" . trim($arreglo['txtCiudadMatricula'][$int]) . "',";
                    $valores .= ( is_null($arreglo['txtElaboro'][$int]) ) ? "null" : "'" . trim($arreglo['txtElaboro'][$int]) . "'";
                    $valores .= "),";
                    $ArrImpresion['seqFormulario'][$ex] = $value;
                    $ArrImpresion['seqDesembolso'][$ex] = $arreglo['seqDesembolso'][$int];
                    $ArrImpresion['txtElaboro'][$ex] = $arreglo['txtElaboro'][$int];
                    $ArrImpresion['txtAprobo'][$ex] = $arreglo['txtAprobo'][$int];
                    $ArrImpresion['numdocumento'][$ex] = $arreglo['numdocumento'][$int];
                    //$ArrImpresion['numdocumento'][$ex] = $arreglo['txtAprobo'][$int];
                    $ex++;
                }
            } else {
                $existen1 = $arreglo['seqFormulario'][$int] . ", ";
                $existen .= $existen1;
            }


            $int++;
        }
    }
    global $db;
    if ($valores != "") {
        $valores = substr_replace($valores, ';', -1, 1);
        $query = $campos . $valores;
        $result = $db->query($query);
    }

    //echo "<br>*".$query ."<br>";
    if ($existen != "") {
        $cantidaE = ($int) - $ex;
        // $existen = substr_replace(trim($existen), ';', -1, 1);
        echo "<p> Los formularios que se muestran a continuaci&oacute;n se encuentr&aacute;n previamente almacenados: <br><b> " . $existen . " </b><br> son en total <b>" . $cantidaE . " Registros </b> de un total de " . ($int - 1) . " Registros </p>";
    }

//var_dump($dato);exit();
    if ($result > 0) {
        insertarAdjuntosTitulos($arreglo, $cantF, $tipo, $intD, $dato, $idSeqDesembolso, $ArrImpresion);
    }
}

function insertarAdjuntosTitulos($arreglo, $cantF, $tipo, $intD, $dato, $idSeqDesembolso, $ArrImpresion) {

    global $db;
    $consulta = " SELECT seqDesembolso, seqEstudioTitulos FROM T_DES_ESTUDIO_TITULOS WHERE seqDesembolso IN(" . $idSeqDesembolso . ")";

    $resultado = $db->get_results($consulta);
    $dato = Array();
    $intD = 0;
    $seqEstudioTitulosSearch = "";
    if ($resultado) {
        foreach ($resultado as $res) {
            $dato[$res->seqEstudioTitulos] = $res->seqDesembolso;
            $seqEstudioTitulosSearch .= $res->seqEstudioTitulos . ",";
        }
    }

    $seqEstudioTitulosSearch = substr_replace($seqEstudioTitulosSearch, '', -1, 1);
    global $db;
    $consulta = " SELECT seqAdjuntoTitulos, seqEstudioTitulos FROM t_des_adjuntos_titulos WHERE seqEstudioTitulos IN(" . $seqEstudioTitulosSearch . ")";
    $resultado1 = $db->get_results($consulta);
    $datoET = Array();
    $intD = 0;
    $seqEstudioTitulosSearch = "";
    if ($resultado1) {
        foreach ($resultado1 as $res1) {
            $datoET[$res1->seqAdjuntoTitulos] = $res1->seqEstudioTitulos;
            $seqAdjuntosTitulosSearch .= $res1->seqEstudioTitulos . ",";
        }
    }

    $txtqueryAdjuntos = "INSERT INTO t_des_adjuntos_titulos (seqTipoAdjunto ,seqEstudioTitulos ,txtAdjunto) VALUES";
    $valueObs1 = '';
    $valueObs2 = '';
    $valueObs3 = '';
    $int = 1;
    $existen = '';
    foreach ($arreglo['seqDesembolso'] as $key => $value) {
        $seqDesembolso = $arreglo['seqDesembolso'][$int];
        $seqEstudioTitulos = array_search($seqDesembolso, $dato);
        $seqAdjuntosTitulo = array_search($seqEstudioTitulos, $datoET);
        if ($seqAdjuntosTitulo == "") {
            if ($seqEstudioTitulos != "") {
                if ($arreglo['beneficiarios'][$int] != "") {
                    $valueObs1 .= "(4," . $seqEstudioTitulos . ",'" . $arreglo['beneficiarios'][$int] . "'),";
                }
                if ($arreglo['estado'][$int] != "") {
                    $valueObs1 .= "(4," . $seqEstudioTitulos . ",'" . $arreglo['estado'][$int] . "'),";
                }
                if ($arreglo['constitucion'][$int] != "") {
                    $valueObs1 .= "(4," . $seqEstudioTitulos . ",'" . $arreglo['constitucion'][$int] . "'),";
                }
                if ($arreglo['resticciones'][$int] != "") {
                    $valueObs1 .= "(4," . $seqEstudioTitulos . ",'" . $arreglo['resticciones'][$int] . "'),";
                }
                if ($arreglo['patrimonio'][$int] != "") {
                    $valueObs1 .= "(4," . $seqEstudioTitulos . ",'" . $arreglo['patrimonio'][$int] . "'),";
                }
                if ($arreglo['propietarios'][$int] != "") {
                    $valueObs1 .= "(4," . $seqEstudioTitulos . ",'" . $arreglo['propietarios'][$int] . "'),";
                }
                if ($arreglo['compraVenta'][$int] != "") {
                    $valueObs1 .= "(4," . $seqEstudioTitulos . ",'" . $arreglo['compraVenta'][$int] . "'),";
                }
                if ($arreglo['indagacion'][$int] != "") {
                    $valueObs1 .= "(4," . $seqEstudioTitulos . ",'" . $arreglo['indagacion'][$int] . "'),";
                }     
                if ($arreglo['transferencia'][$int] != "") {
                    $valueObs1 .= "(4," . $seqEstudioTitulos . ",'" . $arreglo['transferencia'][$int] . "'),";
                } 
                if ($arreglo['noEscritura'][$int] != "") {
                    $valueObs2 .= "(1," . $seqEstudioTitulos . ",'" . $arreglo['noEscritura'][$int] . "'),";
                }
                if ($arreglo['folio'][$int] != "") {
                    $valueObs2 .= "(1," . $seqEstudioTitulos . ",'" . $arreglo['folio'][$int] . "'),";
                }
                if ($arreglo['certificado'][$int] != "") {
                    $valueObs2 .= "(1," . $seqEstudioTitulos . ",'" . $arreglo['certificado'][$int] . "'),";
                }
                if ($arreglo['carta'][$int] != "") {
                    $valueObs2 .= "(1," . $seqEstudioTitulos . ",'" . $arreglo['carta'][$int] . "'),";
                }
                if ($arreglo['observacion'][$int] != "") {
                    $valueObs3 .= "(2," . $seqEstudioTitulos . ",'" . $arreglo['observacion'][$int] . "'),";
                }
            } else {
                $existen .= $arreglo['seqFormulario'][$int] . ", ";
            }
        }
        $int++;
    }

    if ($valueObs1 != "") {
        $insert1 = substr_replace($valueObs1, ';', -1, 1);
        $result1 = $db->query($txtqueryAdjuntos . "" . $insert1);
    }
    if ($valueObs2 != "") {
        $insert2 = substr_replace($valueObs2, ';', -1, 1);
        $result2 = $db->query($txtqueryAdjuntos . "" . $insert2);
    }

    if ($valueObs3 != "") {
        $insert3 = substr_replace($valueObs3, ';', -1, 1);
        $result3 = $db->query($txtqueryAdjuntos . "" . $insert3);
    }

    $totalReg = $result1 + $result1 + $result1;
    if ($existen != "") {
        echo " Los formularios que se muestran a continuación se encontraban previamente almacenados en los adjuntos titulos" . $existen;
    }
    generarLinks($ArrImpresion, $tipo);
}

function generarLinks($arreglo, $tipo) {
    $arrFormularioArchivo = array();
    $titulo = " Impresion ";
    if ($tipo == 1) {
        $titulo .= " Impresion Aprobados ";
    } else
        $titulo .= " Impresion NO Aprobados ";

    $tabla = "<p><table>";
    $tabla .= "<tr><td colspan='5'>" . $titulo . "</td></tr>";
    $tabla .= "<tr>";
    $tabla .= "<th>SegFormulario</th>";
    $tabla .= "<th>SeqDesembolso</th>";
    $tabla .= "<th>Elaboro</th>";
    $tabla .= "<th>Aprobo</th>";
    $tabla .= "<th>Link</th>";
    $tabla .= "</tr>";
    $int = 1;
    foreach ($arreglo['seqDesembolso'] as $key => $value) {
        array_push($arrFormularioArchivo, trim($arreglo['seqFormulario'][$int]));
        $tabla .= "<tr>";
        $tabla .= "<td>" . $arreglo['seqFormulario'][$int] . "</td>";
        $tabla .= "<td>" . $arreglo['seqDesembolso'][$int] . "</td>";
        $tabla .= "<td>" . $arreglo['txtElaboro'][$int] . "</td>";
        $tabla .= "<td>" . $arreglo['txtAprobo'][$int] . "</td>";
        $tabla .= "<td><a href='https://" . $_SERVER['HTTP_HOST'] . "/sipive/contenidos/desembolso/formatoEstudioTitulos.php?seqFormulario=" . $arreglo['seqFormulario'][$int] . "' target='_blank'>https://" . $_SERVER['HTTP_HOST'] . "/sipive/contenidos/desembolso/formatoEstudioTitulos.php?seqFormulario=" . $arreglo['seqFormulario'][$int] . "</a></td>";
        $tabla .= "</tr>";
        $int++;
    }
    echo $tabla .= "</table></p>";

    $tabla = "<p><table>";
    $tabla .= "<tr><td colspan='5'>" . $titulo . "</td></tr>";
    $tabla .= "<tr>";
    $tabla .= "<th>Documento</th>";
    $tabla .= "<th>Estado</th>";
    $tabla .= "<th>Comentario</th>";
    $tabla .= "</tr>";
    $int = 1;
    $aprobado = "";
    $noAprobado = "";
    foreach ($arreglo['seqDesembolso'] as $key1 => $value1) {

        // $tabla .= "<tr>";
        //$tabla .= "<td>" . $arreglo['numdocumento'][$int] . "</td>";
        if ($tipo == 1) {
            $aprobado .= $arreglo['seqFormulario'][$int] . ",";
            // $tabla .= "<td>29</td>";
            // $tabla .= "<td> POR MIGRACION MASIVA ESTUDIO DE TITULOS </td>";
        } else {
            $noAprobado .= $arreglo['seqFormulario'][$int] . ",";
            // $tabla .= "<td>28</td>";
            //$tabla .= "<td> POR MIGRACION MASIVA ESTUDIO DE TITULOS </td>";
        }

        // $tabla .= "</tr>";
        $int++;
    }
    if (!empty($aprobado)) {
        $insert1 = substr_replace($aprobado, '', -1, 1);
//        $consulta = "UPDATE t_frm_formulario set seqEstadoProceso = 31 where seqFormulario IN(" . $insert1 . ")";
//        $db->get_results($consulta);
        migrarInformacion($insert1, $db, 31, 24);
    }
    if (!empty($noAprobado)) {
//        $insert1 = substr_replace($noAprobado, '', -1, 1);
//        $consulta = "UPDATE t_frm_formulario set seqEstadoProceso = 28 where seqFormulario IN(" . $insert1 . ")";
//        $db->get_results($consulta);
        $insert1 = substr_replace($noAprobado, '', -1, 1);
        migrarInformacion($insert1, $db, 28, 24);
    }


//    $separado_por_comas = implode(",", $arrFormularioArchivo);
//    migrarInformacion($separado_por_comas, $db, 28, 27);
}

function obtenerEscrituracion($seqFormulario) {
    global $db;

    $sqlSeqEscr = "select  GROUP_CONCAT(seqEscrituracion SEPARATOR ', ') as seqEscrituracion from t_des_escrituracion where seqFormulario in (" . $seqFormulario . ") and seqEscrituracion in 
(select max(seqEscrituracion) from  t_des_escrituracion where seqFormulario in (" . $seqFormulario . ") group by seqFormulario)";

    $reqSeqEscr = $db->get_results($sqlSeqEscr);
    $seqEscrituracion = "";
    //var_dump($reqSeqEscr->seqEscrituracion);
    foreach ($reqSeqEscr as $result) {
        $seqEscrituracion = $result->seqEscrituracion;
    }
    $sql = "
        select 
          txtPropiedad, 
          txtEscritura, 
          fchEscritura, 
          numNotaria, 
          txtCiudad
        from t_des_escrituracion
        where seqFormulario = $seqFormulario and seqEscrituracion in($seqEscrituracion)
    ";
    $resultado = $db->get_results($sql);
    $dato = Array();

    foreach ($resultado as $res) {
        $dato['numEscritura'] = $res->txtEscritura;
        $dato['fchEscritura'] = $res->fchEscritura;
        $dato['numNotaria'] = $res->numNotaria;
        $dato['txtCiudad'] = $res->txtCiudad;
    }
    return $dato;
}

?>