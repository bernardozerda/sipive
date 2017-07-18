<?php

/**
 * ARCHIVO DE INICIO PARA EL REPORTE DEL 
 * FONDO NACIONAL DEL AHORRO
 * @author Bernardo Zerda
 * @version 1.0 Sep 2010
 * */
// Contenido del popup de ayuda
$txtTitulo = "Ayuda general para el reporte";

$txtContenido = "<p>Este reporte obtiene los registros de los hogares relacionados con el Fondo Nacional del Ahorro. ";
$txtContenido .= "Usted podrá obtener los datos del postulante principal del hogar y de sus miembros, estados civiles, ";
$txtContenido .= "valor del subsdio al que aspira el hogar, la modalidad para la cual esta inscrito en el programa ";
$txtContenido .= "y el estado general del proceso.</p><p>Tenga en cuenta que SIEMPRE debe digitar un numero de documento, ya sea usando el archivo por lotes ";
$txtContenido .= "o uno a uno en el cuadro de texto destinado para tal fin.  También podrá filtrar sus resultados por etapas ";
$txtContenido .= "para reducir el rango de busqueda.</p><p>Tenga en cuenta que si digita un documento, el archivo que cargue NO sera tenido en cuenta para el reporte</p> ";
$txtContenido .= "<p>Solamente podrá usar archivos de tipo texto, separado por tabulaciones, con una sola columna llamada Documento ";
$txtContenido .= "(las otras serán ignoradas) y que solo podrá consultar mil (1000) registros como máximo en cada consulta</p> ";

$claSmarty->assign("txtTitulo", $txtTitulo);
$claSmarty->assign("txtContenido", $txtContenido);
$claSmarty->assign("txtArchivoInicio", "fna/consultas/consultas.tpl");

?>
