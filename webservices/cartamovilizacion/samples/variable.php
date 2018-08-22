
<?php

$_SESSION['intentos'] = 3;
if ($_REQUEST['codeVerificador']) {
    //$cliente = new nusoap_client('http://localhost/sipive/contenidos/ciudadano/ws_obtenerCode.php');
    $cliente = new nusoap_client('https://sdv.habitatbogota.gov.co/capacitacion/contenidos/ciudadano/ws_obtenerCode.php');
} else {
    $cliente = new nusoap_client('https://sdv.habitatbogota.gov.co/capacitacion/contenidos/ciudadano/ws_cartasMovilizacion.php');
    //$cliente = new nusoap_client('http://localhost/sipive/contenidos/ciudadano/ws_cartasMovilizacion.php');
}
?>
 