<?php
	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion["librerias"]["funciones"] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion["carpetas"]["recursos"] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion["carpetas"]["recursos"] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion["librerias"]["clases"] . "ProyectoVivienda.class.php" );

	$txtParametro = ereg_replace( " " , "%" , trim( $_GET["query"] ) );
	while( strpos( $txtParametro , "%%" ) !== false ){
		$txtParametro = ereg_replace( "%%" , "%" , $txtParametro );
	}

	$claProyectoVivienda = new ProyectoVivienda();
	$arrProyectoVivienda = $claProyectoVivienda->buscarNombreProyecto( $txtParametro ); 

	if( ! empty( $arrProyectoVivienda ) ){
		foreach( $arrProyectoVivienda as $seqProyecto => $arrInformacion ){
			//echo implode( "\t" , $arrInformacion ) . "\n";
			echo $seqProyecto . "\t" . $arrInformacion . "\n";
		}
	}else{
		echo "No se encontraron resultados para \"". ereg_replace( "%" , " " , $txtParametro ) ."\"\t\n";
	}
?>