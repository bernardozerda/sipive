<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

// Barrio
$seqLocalidad = explode("**", $_POST['seqLocalidad']);
$nameBarrio = explode("_", $seqLocalidad[1]);
$sql = "
		SELECT 
			seqBarrio,
			txtBarrio
		FROM 
			T_FRM_BARRIO
		WHERE 
			seqLocalidad = " . $seqLocalidad[0] . "
		";
$objRes = $aptBd->execute($sql);
while ($objRes->fields) {
    $arrBarrio[$objRes->fields['seqBarrio']] = $objRes->fields['txtBarrio'];
    $objRes->MoveNext();
}

$name = ($_REQUEST['tipo'] == 2)?"$nameBarrio[0][]":$nameBarrio[0];

    echo "
        <select  
                onChange=\"obtenerUpz(this);\" 
                onBlur=\"this.style.backgroundColor = '#FFFFFF';\" 
                name='$name'
                id=\"$seqLocalidad[1]\" 
                style=\"width:200px;\" 
                class=\"form-control required\"
        ><option value='0'>Desconocido</option>
    ";



foreach ($arrBarrio as $seqBarrio => $txtBarrio) {
    echo "<option value='$seqBarrio'>$txtBarrio</option>";
}

echo "</select>";
?>
