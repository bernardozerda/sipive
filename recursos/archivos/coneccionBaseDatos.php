<?php

/**
 * ARCHIVO QUE REALIZA LA CONECCION A LA
 * BASE DE DATOS CON LA LIBRERIA ADODB
 *
 * REQUIERE QUE ANTES SE INCLUYA LA LECTURA DE
 * LA CONFIGURACION DEL APLICATIVO
 *
 * @author Bernardo Zerda
 * @version 0.1 Marzo 2009
 */

// si no hay configuracion detiene el script
if ((!isset($arrConfiguracion)) or empty($arrConfiguracion)) {
   exit(0);
}

// en caso que no biene la variable de posicion relativa asigna una
if (!isset($txtPrefijoRuta) or $txtPrefijoRuta == "") {
   $txtPrefijoRuta = "./";
}

// Archivos necsesarios para el funcionamiento
include($txtPrefijoRuta . $arrConfiguracion['librerias']['adodb'] . "adodb-exceptions.inc.php"); // para el manejo de excepciones
include($txtPrefijoRuta . $arrConfiguracion['librerias']['adodb'] . $arrConfiguracion['archivos']['adodb']);

try {
   // aplicalos datos de coneccion a la base de datos escritos ( ver lecturaConfiguracion.php )
   $aptBd = ADONewConnection($arrConfiguracion['baseDatos']['motor']);
   $aptBd->PConnect(
      $arrConfiguracion['baseDatos']['servidor'],
      $arrConfiguracion['baseDatos']['usuario'],
      $arrConfiguracion['baseDatos']['clave'],
      $arrConfiguracion['baseDatos']['nombre']
   );
   $aptBd->SetFetchMode(ADODB_FETCH_ASSOC); // solo respuestas con arreglos asociativos
} catch (Exception $objError) {
   echo "Error Conexion BD Local: " . $objError->getMessage();
   die();
}

try {
   $sql = "SET CHARSET utf8";
   $aptBd->execute($sql);
} catch (Exception $objError) {
   echo "No se pudo establecer el conjunto de caracteres";
   exit(0);
}

?>
