<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion["librerias"]["funciones"] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion["carpetas"]["recursos"] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion["carpetas"]["recursos"] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion["librerias"]["clases"] . "Ciudadano.class.php" );
	
	
	$txtParametro = ereg_replace( " " , "%" , trim( $_GET["query"] ) );
	while( strpos( $txtParametro , "%%" ) !== false ){
		$txtParametro = ereg_replace( "%%" , "%" , $txtParametro );
	}
	
	$claCiudadano = new Ciudadano();
	$arrCiudadanos = $claCiudadano->buscarNombre( $txtParametro ); 
	
	if( ! empty( $arrCiudadanos ) ){
		foreach( $arrCiudadanos as $arrInformacion ){
			echo implode( "\t" , $arrInformacion ) . "\n";
		}
	}else{
		echo "No se encontraron resultados para \"". ereg_replace( "%" , " " , $txtParametro ) ."\"\t\n";
	}

?>
