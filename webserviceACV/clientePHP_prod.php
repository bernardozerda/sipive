<?php

require_once('./nusoap/nusoap.php');
$cliente = new nusoap_client('http://localhost/sdv_prod/webserviceACV/servicioWeb.php');
$ciudadanos = $cliente->call('consultarCiudadano', array('documento' => 140532, 'tipoDocumento' => 1, 'user' => '', 'pasw' => ''));

echo '<pre>';
print_r($ciudadanos);
echo '</pre>';
?>
