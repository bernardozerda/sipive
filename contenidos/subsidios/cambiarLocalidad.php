<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" ); 
    
    $arrLocalidad = array();
    if( intval( $_POST['ciudad'] ) != 0 ) {
        $txtCondicion = ($_POST['ciudad'] == 149)? "seqLocalidad not in (1,22)" : "seqLocalidad in (22)";
        $arrLocalidad = obtenerDatosTabla("T_FRM_LOCALIDAD", array("seqLocalidad", "txtLocalidad"), "seqLocalidad", $txtCondicion);
        natsort($arrLocalidad);
    }

    echo "
    <select	onFocus=\"this.style.backgroundColor = '#ADD8E6';\" 
            onBlur=\"this.style.backgroundColor = '#FFFFFF';\" 
            onChange=\"obtenerBarrio(this);\"
            name=\"seqLocalidad\" 
            id=\"seqLocalidad\" 
            style=\"width:260px;\"
        ><option value=\"1\" selected>Seleccione una</option>
    ";
    foreach( $arrLocalidad as $seqLocalidad => $txtLocalidad ){
        echo "<option value=\"$seqLocalidad\">$txtLocalidad</option>";
    }
    echo "</select>";
    
    
?>
