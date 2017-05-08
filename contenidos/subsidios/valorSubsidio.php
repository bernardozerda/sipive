<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	
	$seqSolucion = $_POST['solucion'];
	$seqModalidad = $_POST['modalidad'];
	
	// el valor del subsidio debe ser el maximo (como en tipo 1) por eso se alteran los valores
	if( $_POST[ "desplazado" ] == 1 and $_POST[ "modalidad" ] == 1 and $_POST[ "solucion" ] != 2 ){
		$seqSolucion = 2;
		$seqModalidad = 1;
	}	
	
	$valSolucion = 0;

	$sql = "
		SELECT valSubsidio
		FROM T_FRM_VALOR_SUBSIDIO
		WHERE seqSolucion = ".$seqSolucion."
		  AND seqModalidad = ".$seqModalidad."
	";	
	$objRes = $aptBd->execute( $sql );
	if( $objRes->fields ){
		$valSolucion = $objRes->fields['valSubsidio'];
	}

	$valSolucionFormat = number_format($valSolucion, 0, ",", ".");

	echo "
		$ <input	type=\"text\" 
					name=\"valAspiraSubsidio\" 
					id=\"valAspiraSubsidio\" 
					value=\"$valSolucionFormat\" 
					onFocus=\"this.style.backgroundColor = '#ADD8E6';\" 
					onBlur=\"soloNumeros( this ); this.style.backgroundColor = '#FFFFFF'; sumarTotalRecursos();\"  
					style=\"width:100px; text-align:right\" 
		/>
	";

?>
