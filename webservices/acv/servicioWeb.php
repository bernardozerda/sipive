<?php

require_once('./nusoap/nusoap.php');
require_once('consultarCiudadano.php');

$server = new nusoap_server();
$server->register('consultarCiudadano');

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>