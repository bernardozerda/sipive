<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" ); 
    
    $arrLocalidad = array();
    if( intval( $_POST['ciudad'] ) != 0 ){
        $txtCondicion = ( intval( $_POST['ciudad'] ) == 149 )? "<>" : "=";
        $sql = "
            SELECT 
                seqLocalidad,
                txtLocalidad
            FROM T_FRM_LOCALIDAD
            WHERE seqLocalidad " . $txtCondicion . " 22
            AND seqLocalidad > 1
            ORDER BY 
                txtLocalidad
        ";
        $objRes = $aptBd->execute( $sql );
        while( $objRes->fields ){
            $arrLocalidad[ $objRes->fields['seqLocalidad'] ] = $objRes->fields['txtLocalidad'];
            $objRes->MoveNext();
        }    
    }
    
    echo "
    <select	onFocus=\"this.style.backgroundColor = '#ADD8E6';\" 
            onBlur=\"this.style.backgroundColor = '#FFFFFF';\" 
            name=\"seqLocalidad\" 
            id=\"seqLocalidad\" 
            style=\"width:260px\"
            onChange=\"barrioAutocomplete( [ 'txtBarrio' , 'barrioContainer' , 'seqLocalidad'] );\"
    >
        <option value=\"0\">0 - DESCONOCIDO</option>
    ";
    foreach( $arrLocalidad as $seqLocalidad => $txtLocalidad ){
        echo "<option value=\"$seqLocalidad\">$txtLocalidad</option>";
    }
    echo "</select>";
    
?>
