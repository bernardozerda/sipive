<?php

	/**
	 * CONSULTA DE INFORMACION DE BENEFICIARIOS DE 
	 * EL FONDO NACIONAL DEL AHORRO
	 * @author Bernardo Zerda 
	 * @version 1.0 Agosto de 2010
	 */
	
	$txtPrefijoRuta = "../../../";
	
	// Contenido del popup de ayuda
	$txtTitulo = "Ayuda general para el reporte";

	$txtContenido  = "<p>Este reporte obtiene los registros de los hogares relacionados con el Fondo Nacional del Ahorro. ";
	$txtContenido .= "Usted podrá obtener los datos del postulante principal del hogar y de sus miembros, estados civiles, ";
	$txtContenido .= "valor del subsdio al que aspira el hogar, la modalidad para la cual esta inscrito en el programa ";
	$txtContenido .= "y el estado general del proceso.</p><p>Para usar el filtro por documentos usted dispone de dos opciones:  ";
	$txtContenido .= "la primera es digitar un documento en el capo llamado Documento de Identidad, la segunda es usar un archivo "; 
	$txtContenido .= "de texto , separado por tabulaciones, con una sola columna llamada Documento en donde podrá consultar un  ";
	$txtContenido .= "maximo de mil (1000) documentos por vez.</p> <p>Tenga en cuenta que si usa la consulta un solo documento  ";
	$txtContenido .= "el archivo sera ignorado.</p><p>El cuadro de las etapas del proceso filtra los hogares por estado dentro del  ";
	$txtContenido .= "Subsidio Distrital de Vivienda: <ol><li>Inscripción: Hogares que no han informado a la entidad el cierre  ";
	$txtContenido .= "financiero exigido por la entidad</li> <li>Postulación: Son los hogares que han completado un cierre financiero "; 
	$txtContenido .= "y que estan en el proceso de completar la documentacion requerida.</li><li>Asignación: Hogares que han  ";
	$txtContenido .= "resultado beneficiados con el subsidio distrital de vivienda pero que no han reportado a la entidad una  ";
	$txtContenido .= "solucion de vivienda para continuar con el proceso de desembolso.</li> <li>Desembolso: Hogares que han "; 
	$txtContenido .= "iniciado el proceso de compra de una vivienda.</li></p> ";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	
    $claSmarty->assign( "txtTitulo" , $txtTitulo );
    $claSmarty->assign( "txtContenido" , $txtContenido );
 	$claSmarty->display( "fna/consultas/consultas.tpl" );
 
?>
