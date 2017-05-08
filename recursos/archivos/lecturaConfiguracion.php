<?php

	/**
	 * TODO LO QUE ESTA ESCRITO EN EL ARCHIVO 
	 * DE COFIGURACION SE RECOGE EN ESTE ARCHIVO 
	 * Y SE ALMACENA EN EL ARREGLO $arrConfiguracion
	 * @author Bernardo Zerda
	 * @version 0.1 Marzo 2009
	 */
	
  /*********************************************************************
   *                        IMPORTANTE                                 *
   * No olvidar colocar '/' al final, puesto que sin ese caracter los  *
   * archivos incluidos con esta variable no funcionaran.              *
   *********************************************************************/  
    
	$arrConfiguracion = array();
	
    // Carpetas en donde se encuentran las librerias
	$arrConfiguracion['librerias']['smarty']    = "librerias/smarty/";
	$arrConfiguracion['librerias']['adodb']     = "librerias/adodb5/";
	$arrConfiguracion['librerias']['clases']    = "librerias/clases/";
	$arrConfiguracion['librerias']['funciones'] = "librerias/funciones/";
  	$arrConfiguracion['librerias']['captcha']   = "librerias/captcha/";  
  	$arrConfiguracion['librerias']['phpmailer'] = "librerias/phpmailer/";
  	$arrConfiguracion['librerias']['dompdf'] 	  = "librerias/dompdf/";
  	$arrConfiguracion['librerias']['nusoap'] 	  = "librerias/nusoap/";
    
  	// Algunos archivos de importancia en el aplicativo
	$arrConfiguracion['archivos']['smarty']     = "Smarty.class.php"; 
	$arrConfiguracion['archivos']['adodb']      = "adodb.inc.php";
	
  	// Capetas importantes del aplicativo
	$arrConfiguracion['carpetas']['recursos']   = "recursos/";
	$arrConfiguracion['carpetas']['contenidos'] = "contenidos/";
	$arrConfiguracion['carpetas']['imagenes']   = "recursos/imagenes/";
	$arrConfiguracion['carpetas']['descargas']  = "recursos/descargas/";
    
  	// Datos de coneccion a la base de datos
	$arrConfiguracion['baseDatos']['motor']    = "mysql";
	$arrConfiguracion['baseDatos']['servidor'] = "localhost";
	$arrConfiguracion['baseDatos']['usuario']  = "sdht_usuario";
	$arrConfiguracion['baseDatos']['clave']    = "Ochochar*1";
	$arrConfiguracion['baseDatos']['nombre']   = "sipive";
	
  	// Datos de coneccion para el envio de correos electronicos
  	$arrConfiguracion['correo']['servidor']    = "smtp.googlemail.com";
  	$arrConfiguracion['correo']['puerto']      = 465;
  	$arrConfiguracion['correo']['seguridad']   = "ssl"; //  Posibles valores '' , 'ssl' , 'tsl'
  	$arrConfiguracion['correo']['nombre']      = "Bernardo Zerda"; 
  	$arrConfiguracion['correo']['usuario']     = "bzerdar@habitatbogota.gov.co";
  	$arrConfiguracion['correo']['clave']       = "Ochochar*1"; 
  	
  	// Constantes del aplicativo
  	$arrConfiguracion['constantes']['salarioMinimo'] = 737717;

   // Lenguaje para la conversion de fechas
   date_default_timezone_set("America/Bogota");
	setlocale(LC_TIME, 'spanish');
	

?>
