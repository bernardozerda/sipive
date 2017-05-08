<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );


// Solucion
$sql = "
		SELECT 
			seqUpz,
			txtUpz
		FROM 
			T_FRM_UPZ
		WHERE 
			seqUpz = (SELECT seqUpz FROM T_FRM_BARRIO WHERE seqBarrio = " . $_POST['seqBarrio'] . ")"
;
$objRes = $aptBd->execute($sql);
$secuencialupz = $objRes->fields['seqUpz'];
$textoupz = $objRes->fields['txtUpz'];
echo "<input type='hidden' readonly id='seqUpz' name='seqUpz' value='$secuencialupz'/>";
?>
