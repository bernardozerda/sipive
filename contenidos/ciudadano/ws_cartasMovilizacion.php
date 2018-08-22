<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$txtPrefijoRuta = "../../";

//include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
require_once $txtPrefijoRuta . $arrConfiguracion['librerias']['nusoap'] . 'nusoap.php';
include '../../librerias/tcpdf/tcpdf.php';
include '../../librerias/tcpdf/config/lang/spa.php';;

//include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['contenidos'] . "ciudadano/cartaMovilizacion2_1.php" );



$server = new nusoap_server();
$server->configureWSDL('Mi Web Service #1', 'urn:mi_ws1');

$server->wsdl->addComplexType('datos_persona_entrada', 'complexType', 'struct', 'all', '', array('documento' => array('name' => 'documento', 'type' => 'xsd:int'),
    'nombre' => array('name' => 'nombre', 'type' => 'xsd:string'),
    'banco' => array('name' => 'banco', 'type' => 'xsd:string'),
    'cuenta' => array('name' => 'cuenta', 'type' => 'xsd:int'),
    'dirIp' => array('name' => 'dirIp', 'type' => 'xsd:string'))
);
// Parametros de Salida
$server->wsdl->addComplexType('datos_persona_salidad', 'complexType', 'struct', 'all', '', array('mensaje' => array('name' => 'mensaje', 'type' => 'xsd:string'),
    'banco' => array('name' => 'banco', 'type' => 'xsd:Array'), 'formulario' => array('name' => 'formulario', 'type' => 'xsd:int'),
    'msn1' => array('name' => 'msn1', 'type' => 'xsd:string'), 'msn2' => array('name' => 'msn2', 'type' => 'xsd:string'),
    'nombre' => array('name' => 'nombre', 'type' => 'xsd:string'),
    'msn3' => array('name' => 'msn3', 'type' => 'xsd:string'),
    'ahorro1' => array('name' => 'ahorro1', 'type' => 'xsd:int'),
    'ahorro2' => array('name' => 'ahorro2', 'type' => 'xsd:int'),
    'cuenta1' => array('name' => 'cuenta1', 'type' => 'xsd:int'),
    'cuenta2' => array('name' => 'cuenta2', 'type' => 'xsd:int'),
    'numIngresos' => array('name' => 'numIngresos', 'type' => 'xsd:int')
        )
);
$server->register('obtenerDatosCarta', // nombre del metodo o funcion
        array('datos_persona_entrada' => 'tns:datos_persona_entrada'), // parametros de entrada
        array('return' => 'tns:datos_persona_salidad'), // parametros de salida
        'urn:mi_ws1', // namespace
        'urn:hellowsdl2#obtenerDatosCarta', // soapaction debe ir asociado al nombre del metodo
        'rpc', // style
        'encoded', // use
        'La siguiente funcion recibe los parametros de la persona y calcula la Edad' // documentation
);
$seqFormulario = 0;
$prueba = "";
$contenido = "";
$name = "";
$dirIp = "";
function obtenerDatosCarta($datos) {
	
    global $aptBd;
    $claFormulario = new FormularioSubsidios();
    $claCiudadano = new Ciudadano();
    $documentCiu = ereg_replace("[^A-Za-z0-9]", "", $datos['documento']);
    $seqFormulario = $claCiudadano->formularioVinculado($documentCiu);
    $arrBanco = obtenerDatosTabla("T_FRM_BANCO", array("seqBanco", "txtBanco"), "seqBanco", "seqBanco > 1", "txtBanco");
    $banc = Array();
    $nameBanco = "";
    $dirIp = $datos['dirIp'];
    foreach ($arrBanco as $key => $value) {
        $banc['name'][$key] = $value . "*" . $key;
        if ($datos['banco'] != null && $datos['banco'] != "" && $key == $datos['banco']) {
            $nameBanco = $value;
        }
    }
    
    if ($seqFormulario > 0 && $seqFormulario != null && isset($seqFormulario)) {

        $validarMovilizacion = $claCiudadano->ValidarMovilizacion($seqFormulario);
        $name = $claCiudadano->obtenerNombre($documentCiu);
        $numIngresos = $claCiudadano->obtenerIp($dirIp);
        //$nameBanco = $datos['banco'];
		

        $datos_ws = Array();
        //$name = $datos['nombre'];
        if ($validarMovilizacion > 0) {
			
            $claFormulario->cargarFormulario($seqFormulario);
			
            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                $datos_ws['txtEncabezado'] = ( $objCiudadano->seqSexo == 1 ) ? " el señor" : " la señora";
                $datos_ws['txtNombre'] = $objCiudadano->txtNombre1 . ' ' . $objCiudadano->txtNombre2 . ' ' . $objCiudadano->txtApellido1 . ' ' . $objCiudadano->txtApellido2;
                $datos_ws['txtInscripcion'] = ( $objCiudadano->seqSexo == 1 ) ? "inscrito" : "inscrita";
            }
            if ($nameBanco != null && $nameBanco != "") {
                $tipo = 1;
                $name = $datos['nombre'];
                $numIngresos = $claCiudadano->obtenerIp($dirIp);
                //$nameBanco = $datos['banco'];
				
                include 'prueba.php';				
                return array('mensaje' => $prueba, 'numIngresos' => $numIngresos);
            } else {
                $msn1 = 'El usuario presenta registro en la Secretaría Distrital Del Hábitat';
                $msn2 = 'Por favor Verifique las siguiente Información';
                $sessionIp = $claCiudadano->obtenerIp($dirIp);
                //return array('banco' => $banc, 'formulario' => $seqFormulario, 'msn1' => $msn1, 'msn2' => $msn2, 'nombre' => $datos_ws['txtNombre']);
                return array('banco' => $banc, 'formulario' => $seqFormulario, 'msn1' => $msn1, 'msn2' => $msn2, 'nombre' => $name,
                    'ahorro1' => $claFormulario->valSaldoCuentaAhorro, 'ahorro2' => $claFormulario->valSaldoCuentaAhorro2,
                    'cuenta1' => $claFormulario->seqBancoCuentaAhorro, 'cuenta2' => $claFormulario->seqBancoCuentaAhorro2, 'numIngresos' => $numIngresos);
            }
        } else {
            $msn3 = 'El estado de avance del hogar en el proceso no permite generación directa de la carta. Se solicita que el ciudadano radique solicitud formal en la Sede Principal para que sea atendida por el equipo de desembolsos de la Subsecretaria de Gestión Financiera';
            return array('msn3' => $msn3, 'formulario' => $seqFormulario, 'numIngresos' => $numIngresos);
        }
    } else {
        if ($datos['banco'] != null && $datos['banco'] != "") {
            $tipo = 2;
            $name = $datos['nombre'];
            $numIngresos = $claCiudadano->obtenerIp($dirIp);
            
            //$nameBanco = $datos['banco'];
            include 'prueba.php';
            return array('mensaje' => $prueba, 'banco' => $banc, 'formulario' => $seqFormulario, 'msn1' => '', 'msn2' => '', 'nombre' => $name, 'numIngresos' => $numIngresos);
        } else {
            $msn1 = 'El usuario no presenta registro en la Secretaría Distrital Del Hábitat';
            $msn2 = 'Por favor digite las siguiente Información';
            $numIngresos = $claCiudadano->obtenerIp($dirIp);
            return array('mensaje' => '', 'banco' => $banc, 'formulario' => $seqFormulario, 'msn1' => $msn1, 'msn2' => $msn2, 'nombre' => $name, 'numIngresos' => $numIngresos);
        }
    }
    //$url = "https://localhost/sipive/contenidos/ciudadano/pdfCartaMovilizacion.php?documento=111&cuenta=&tipo=1&banco=prueba&nombre=prueba2";
    //echo $P= "<script>window.open('".$url."', '', 'width=1002,height=700,location=0,menubar=0,scrollbars=1,status=1,resizable=0');</script>";
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
