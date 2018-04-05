<?php
	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

	// Modalidad del Proyecto
	$sql = "SELECT 
				seqPryTipoModalidad,
				txtPryTipoModalidad
			FROM 
				T_PRY_TIPO_MODALIDAD
			WHERE 
				estado = 1
			AND 
				seqTipoEsquema = ".$_POST['seqTipoEsquema']."
		";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrPryTipoModalidad[ $objRes->fields['seqPryTipoModalidad'] ] = $objRes->fields['txtPryTipoModalidad'];
		$objRes->MoveNext();
	}	
        //echo $sql;        die();

	echo "
        <select 
                onBlur=\"this.style.backgroundColor = '#FFFFFF';\" 
                name=\"seqPryTipoModalidad\" 
                id=\"seqPryTipoModalidad\" 
                style=\"width:200px;\"
                class=\"form-control required\">
    ";
	foreach( $arrPryTipoModalidad as $seqPryTipoModalidad => $txtPryTipoModalidad ){
		echo "<option value='$seqPryTipoModalidad'>$txtPryTipoModalidad</option>";
	}
	echo "</select>";
?>
