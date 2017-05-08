<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

if ($_POST['seqLocalidad'] != 22) {
    $sql = "
		SELECT 
			seqCiudad,
			CONCAT(txtCiudad,', ',txtDepartamento) AS txtCiudad
		FROM 
			T_FRM_Ciudad
		WHERE 
			seqCiudad = 149                
		";
} else {
    $sql = "
		SELECT 
			seqCiudad,
			CONCAT(txtCiudad,', ',txtDepartamento) AS txtCiudad
		FROM 
			T_FRM_Ciudad
		WHERE 
			seqCiudad != 149
                ORDER BY 
                        txtCiudad         
		";
}

//echo $_POST['seqLocalidad']." <br> ".$sql;die();
$objRes = $aptBd->execute($sql);
while ($objRes->fields) {
    $arrCiudad[$objRes->fields['seqCiudad']] = $objRes->fields['txtCiudad'];
    $objRes->MoveNext();
}
echo "
        <select onFocus=\"this.style.backgroundColor = '#ADD8E6';\" 
                onChange=\"\" 
                onBlur=\"this.style.backgroundColor = '#FFFFFF';\" 
                name=\"seqCiudad\" 
                id=\"seqCiudad\" 
                style=\"width:260px;\"               
        >
    ";
foreach ($arrCiudad as $seqCiudad => $txtCiudad) {
    echo "<option value='$seqCiudad'>$txtCiudad</option>";
}
echo "</select>";
?>
