
<?php

$_SESSION['intentos'] = 3;
//$cliente = new nusoap_client('http://localhost/sipive/contenidos/ciudadano/ws_cartasMovilizacion.php');

if ($_REQUEST['codeVerificador']) {
    $cliente = new nusoap_client('http://localhost/sipive/contenidos/ciudadano/ws_obtenerCode.php');
} else {
    $cliente = new nusoap_client('https://sdv.habitatbogota.gov.co/capacitacion/contenidos/ciudadano/ws_cartasMovilizacion.php');
}
?>
 