<?php

    /**
    * INICIO DE LA PANTALLA DE ASIGNACION
    * @author Bernardo Zerda
    * @author Camilo Bernal
    * @version 1.0 Septiembre de 2013
    */

    $txtPrefijoRuta = "../";
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion["carpetas"]["recursos"] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion["librerias"]["nusoap"] . "nusoap.php" );

    /***************************************************************************
     * DEFINICION DE CONSTANTES
     ***************************************************************************/
    
    define( "_NAMESPACE" , "SDHT" );
    date_default_timezone_set("America/Bogota");
    
    $aptServidor = new soap_server();
    $aptServidor->configureWSDL( _NAMESPACE, false, false, "document" );
    
    /***************************************************************************
     * TIPOS DE DATOS
     ***************************************************************************/
    
    include( "./inclusionesLotes/datos.php" );
    
    /***************************************************************************
     * REGISTRO DE FUNCIONES
     ***************************************************************************/
    
    include( "./inclusionesLotes/publicacion.php" );
    
    /***************************************************************************
     * FUNCIONES QUE SE PUBLICAN
     ***************************************************************************/
    
    include( "./funciones.php" );
    
    /***************************************************************************
     * INICIO DEL SERVIDOR
     ***************************************************************************/
    
    $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : "";
    $aptServidor->service($HTTP_RAW_POST_DATA);
    exit(0);
?>