<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	
    $txtMostrar = "";
    switch( $_POST['tipoDato'] ){
    	case "numero":
    		$txtMostrar = number_format( $_POST['valor'] , 0 , "," , "." );
    	break;
    	case "texto":    
    		$txtMostrar =  utf8_encode( strtolower( ucwords( $_POST['valor'] ) ) );
    	break;
    	case "fecha":
    		setlocale(LC_TIME, 'spanish'); 
			$txtMostrar = utf8_encode( ucwords( strftime("%d de %B del %Y" , strtotime( $_POST['valor'] ) ) ) );
    	break;
    	default:
    		$txtMostrar = $_POST['valor'];
    	break;
    }
	
	echo $txtMostrar;
	
?>
