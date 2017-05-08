<?php

    /**
    * REGISTRO DEL AS FUNCIONES EN EL WEB SERVICE
    * @author Bernardo Zerda
    * @author Camilo Bernal
    * @version 1.0 Septiembre de 2013
    */

    $style = "document"; // rpc
    $use   = "literal";  // literal
	 
    $aptServidor->register (
        "validarUsuario",                      // method name
        array(                                 // input parameters
            "usuario" => "xsd:string",
            "clave"   => "xsd:string"
        ),
        array(                                 // output parameters
            "return" => "tns:cadena"
        ),
        _NAMESPACE,                   // namespace
        _NAMESPACE ."#",         // soapaction
        "$style",                              // style
        "$use",                                // use
        "Verifica la autenticidad del usuario" 
    );
   
    $aptServidor->register (
        "ciudadanosViviendaVista",                 // method name
        array(                                     // input parameters
            "identificador" => "xsd:string"
        ),
        array(                                 // output parameters
            "return" => "tns:RespuestaBVCiudadano"
        ),
        _NAMESPACE,                   // namespace
        _NAMESPACE ."#",    // soapaction
        "$style",                              // style
        "$use",                                // use
        ""
    );
   
?>
