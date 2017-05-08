<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	
	$txtValidacion = "";
	if( $_POST['modalidad'] == 1 ){
		$txtValidacion = " AND seqSolucion <> 1"; 
	}
	
	// Solucion
	$sql = "
		SELECT 
			seqSolucion,
			txtSolucion
		FROM 
			T_FRM_SOLUCION
		WHERE 
			seqModalidad = " . $_POST['modalidad'] . "
			$txtValidacion
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrSolucion[ $objRes->fields['seqSolucion'] ] = $objRes->fields['txtSolucion'];
		$objRes->MoveNext();
	}	
	
	$txtNinguna = "<option value='1'>NINGUNA</option>"; 
	echo "
		<select	onFocus=\"this.style.backgroundColor = '#ADD8E6';\" 
				onBlur=\"this.style.backgroundColor = '#FFFFFF';\" 
				name=\"seqSolucion\" 
				id=\"seqSolucion\" 
				style=\"width:100%;\"
            onChange=\"asignarValorSubsidio( this , 'bolDesplazado' );\"
		>$txtNinguna
	";
	foreach( $arrSolucion as $seqSolucion => $txtSolucion ){
		echo "<option value='$seqSolucion'>$txtSolucion</option>";
	}
	echo "</select>";
	
?>
