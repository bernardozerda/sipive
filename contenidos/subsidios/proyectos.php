<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

	// Solucion
	$sql = "
		SELECT
			seqProyecto,
			seqModalidad,
			txtNombre
		FROM 
			T_FRM_PROYECTO
		WHERE 
			seqModalidad = ".$_POST['modalidad']."
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrProyecto[ $objRes->fields['seqProyecto'] ] = $objRes->fields['txtNombre'];
		$objRes->MoveNext();
	}	
	
	echo " 
		<select	onFocus='this.style.backgroundColor = '#ADD8E6';' 
				onBlur='this.style.backgroundColor = '#FFFFFF';' 
				name='seqProyecto' 
				id='seqProyecto' 
				style='width:100%;'
		><option value='0'>NINGUNO</option>
	";	
	foreach( $arrProyecto as $seqProyecto => $txtProyecto ){
		echo "<option value='$seqProyecto'>$txtProyecto</option>";
	}
	echo "</select>";

?>
