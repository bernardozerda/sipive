<?php

   /**
   * REGISTRO DE LOS DATOS COMPLEJOS
   * @author Bernardo Zerda
   * @author Camilo Bernal
   * @version 1.0 Septiembre de 2013
   */

/**
    * RETORNO DE FUNCIONES CON UNA CADENA COMO RESPUESTA
    * Y EL ARREGLO DE ERRORES PARA VERIFICAR LA AUCENCIA DE LOS MISMOS
    */
   $aptServidor->wsdl->addComplexType(
       "cadena",
       "complexType",
       "struct",
       "all",
       "",
       array ( 
           "texto" => array ( "name" => "texto", "type" => "xsd:string" ),
           "error" => array ( "name" => "error", "type" => "xsd:string" )
       )
   ); 
    /**
     * TIPO DE RETORNO PARA LA FUNCION DE CIUDADANOS
     * HABILITADOS PARA LA CONSULTA EN EL BANCO DE VIVIENDA A LA VISTA
     */

   $aptServidor->wsdl->addComplexType(
       "BVCiudadano",
       "complexType",
       "struct",
       "all",
       "",
       array ( 
           "documento" => array ( "name" => "documento", "type" => "xsd:int" ),
           "nombre"    => array ( "name" => "nombre"   , "type" => "xsd:string" ),
           "correo"    => array ( "name" => "correo"   , "type" => "xsd:string" )
       )
   );
    
   $aptServidor->wsdl->addComplexType(
      "ArrayBVCiudadano",
      "complexType",
      "array",
      "",
      "SOAP-ENC:Array",
      array(),
      array(
         array(
             "ref"            => "SOAP:ENC:arrayType",
             "wsdl:arrayType" => "tns:BVCiudadano[]"
         )
      ),
      "tns:BVCiudadano"
   );

   $aptServidor->wsdl->addComplexType(
       "RespuestaBVCiudadano",
       "complexType",
       "struct",
       "all",
       "",
       array ( 
           "listado" => array ( "name" => "listado", "type" => "tns:ArrayBVCiudadano" ),
           "error"   => array ( "name" => "error"  , "type" => "xsd:string" )
       )
   );

?>
