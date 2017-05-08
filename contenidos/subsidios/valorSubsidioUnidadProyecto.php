<?php

	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

	$seqUnidadProyecto = $_POST['unidadProyecto'];

	$sql = "SELECT valSDVEActual
			FROM T_PRY_UNIDAD_PROYECTO
			WHERE seqUnidadProyecto = ".$seqUnidadProyecto;

	$objRes = $aptBd->execute( $sql );
	if( $objRes->fields ){
		$SDVEActual = $objRes->fields['valSDVEActual'];
	}

	$valSDVEActualFormat = number_format($SDVEActual, 0, ",", ".");

	echo "
		$ <input	type=\"text\" 
					name=\"valAspiraSubsidio\" 
					id=\"valAspiraSubsidio\" 
					value=\"$valSDVEActualFormat\" 
					onFocus=\"this.style.backgroundColor = '#ADD8E6';\" 
					onBlur=\"soloNumeros( this ); this.style.backgroundColor = '#FFFFFF'; sumarTotalRecursos();\"
					style=\"width:100px; text-align:right\"
					readonly
		/>
	";
?>