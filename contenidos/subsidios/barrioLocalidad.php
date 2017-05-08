<?php
	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

	// Barrio
	$sql = "
		SELECT 
			seqBarrio,
			txtBarrio
		FROM 
			T_FRM_BARRIO
		WHERE 
			seqLocalidad = ".$_POST['seqLocalidad']."
		";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrBarrio[ $objRes->fields['seqBarrio'] ] = $objRes->fields['txtBarrio'];
		$objRes->MoveNext();
	}	
	
	$txtNinguna = "<option value='0'>DESCONOCIDO</option>"; 
	//$txtAccion  = ( isset( $_POST['postulacion'] ) )? "onChange='asignarValorSubsidio( this , \"bolDesplazado\" );'" : "" ;
	
	echo "
        <select onFocus=\"this.style.backgroundColor = '#ADD8E6';\" 
                onChange=\"obtenerUpz(this);\" 
                                onBlur=\"this.style.backgroundColor = '#FFFFFF';\" 
                name=\"seqBarrio\" 
                id=\"seqBarrio\" 
                style=\"width:270px;\"
                $txtAccion
        >$txtNinguna
    ";
	foreach( $arrBarrio as $seqBarrio => $txtBarrio ){
		echo "<option value='$seqBarrio'>$txtBarrio</option>";
	}
	echo "</select>";
?>
