<?php

require_once('../lib/nusoap.php');
include '../lib/tcpdf/tcpdf.php';

$identificacion = 0;
$arrBanco = Array();
$msn1 = '';
$msn2 = '';
$msn3 = '';
$ahorro1 = 0;
$ahorro2 = 0;
$cuenta = 0;
$cuenta1 = 0;
$cuenta2 = 0;
$nombreWs = '';
if (isset($_POST['numeroIdentificacion'])) {

    $identificacion = $_POST['numeroIdentificacion'];
    include 'variable.php';
    $seqBanco = 0;
    if (isset($_POST['seqBanco']) && $_POST['seqBanco'] != "") {
        $seqBanco = $_POST['seqBanco'];
    } else if (isset($_POST['seqBanco2']) && $_POST['seqBanco2'] != "") {
        $seqBanco = $_POST['seqBanco2'];
    } else {
        $seqBanco = $_POST['seqBancoOtro'];
    }
    $cuenta = $_POST['radioBanco'];
    $dirIp = $_POST['dirIp'];
    $datos_persona_entrada = array("datos_persona_entrada" => array(
            'documento' => $_POST['numeroIdentificacion'],
            'nombre' => $_POST['nombre'],
            'banco' => $seqBanco,
            'cuenta' => $cuenta,
            'dirIp' => $dirIp
        )
    );

    $resultado = $cliente->call('obtenerDatosCarta', $datos_persona_entrada);

    $arrBanco = $resultado['banco'];
    $seqFormulario = trim($resultado['formulario']);
    $msn1 = $resultado['msn1'];
    $msn2 = $resultado['msn2'];
    $msn3 = $resultado['msn3'];
    $nombreWs = $resultado['nombre'];

    $ahorro1 = $resultado['ahorro1'];
    $cuenta1 = $resultado['cuenta1'];
    $ahorro2 = $resultado['ahorro2'];
    $cuenta2 = $resultado['cuenta2'];
    // documento=" + documento + "&cuenta=" + radio + "&tipo=" + tipo + "&banco=" + entidad + "&nombre=" + nombre     
    $data = mb_split("\"", $resultado['mensaje']);
    if (isset($data[4])) {

        header('Content-Type: application/pdf');
        // echo ($data[4]);
        echo trim(base64_decode($data[4]));
    }
    session_destroy();
}
?>
