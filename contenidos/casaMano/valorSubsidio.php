<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

	foreach($_POST as $txtClave => $txtValor){
		$claFormulario->$txtClave = $txtValor;
	}

	$valSubsidio = valorSubsidio($claFormulario);

	echo number_format($valSubsidio,0,".",".");

?>
