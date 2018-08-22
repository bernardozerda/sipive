<?php

$txtPrefijoRuta = "../../";

//include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
require_once $txtPrefijoRuta . $arrConfiguracion['librerias']['nusoap'] . 'nusoap.php';
include '../../librerias/tcpdf/tcpdf.php';
include '../../librerias/tcpdf/config/lang/spa.php';

$server = new nusoap_server();
$server->configureWSDL('Web Service Validacion #1', 'urn:ws1_validator');

$server->wsdl->addComplexType('datos_persona_entrada', 'complexType', 'struct', 'all', '', array('code' => array('name' => 'code', 'type' => 'xsd:string'))
);
$server->wsdl->addComplexType('datos_persona_salidad', 'complexType', 'struct', 'all', '', array('datos' => array('name' => 'datos', 'type' => 'xsd:Array'),)
);
$server->register('obtenerDatosCode', // nombre del metodo o funcion
        array('datos_persona_entrada' => 'tns:datos_persona_entrada'), // parametros de entrada
        array('return' => 'tns:datos_persona_salidad'), // parametros de salida
        'urn:ws1_validator', // namespace
        'urn:hellowsdl2#obtenerDatosCode', // soapaction debe ir asociado al nombre del metodo
        'rpc', // style
        'encoded', // use
        'La siguiente funcion recibe los parametros de la persona y calcula la Edad' // documentation
);

function obtenerDatosCode($datos) {

    global $aptBd;
    $claFormulario = new FormularioSubsidios();
    $claCiudadano = new Ciudadano();
    $datosCarta = $claCiudadano->obtenerCodigo($datos['code']);
    $msn3 = 'El estado de avance del hogar en el proceso no permite generación directa de la carta. Se solicita que el ciudadano radique solicitud formal en la Sede Principal para que sea atendida por el equipo de desembolsos de la Subsecretaria de Gestión Financiera';
    return array('datos' => $datosCarta);
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
