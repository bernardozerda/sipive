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
    * RETORNO DE FUNCIONES CON UN BOOLEANO COMO RESPUESTA
    * Y EL ARREGLO DE ERRORES PARA VERIFICAR LA AUCENCIA DE LOS MISMOS
    */
   $aptServidor->wsdl->addComplexType(
       "boleano",
       "complexType",
       "struct",
       "all",
       "",
       array ( 
           "estado" => array ( "name" => "estado", "type" => "xsd:boolean" ),
           "error"  => array ( "name" => "error" , "type" => "xsd:string"  )
       )
   );
   
?>
