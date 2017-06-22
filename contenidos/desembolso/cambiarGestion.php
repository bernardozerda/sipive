<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

// GRUPO GESTION ADMINISTRADOR 
$grupoGestionAdministrador = 15;

// Gestion y grupo gestion
 $sql = " 
		SELECT
			gge.seqGrupoGestion,
			gge.txtGrupoGestion,
			ges.seqGestion,
			ges.txtGestion
		FROM
			T_SEG_GRUPO_GESTION gge,
			T_SEG_GESTION ges
		WHERE 
			gge.seqGrupoGestion = ges.seqGrupoGestion
			AND gge.seqGrupoGestion <> $grupoGestionAdministrador 
                        AND ges.bolMostrar = 1
		ORDER BY 
			gge.txtGrupoGestion,
			ges.txtGestion		
	";
$objRes = $aptBd->execute($sql);
while ($objRes->fields) {
    $arrGrupoGestion[$objRes->fields['seqGrupoGestion']]['nombre'] = $objRes->fields['txtGrupoGestion'];
    $arrGrupoGestion[$objRes->fields['seqGrupoGestion']]['gestion'][$objRes->fields['seqGestion']]['nombre'] = $objRes->fields['txtGestion'];
    $objRes->MoveNext();
}

echo "<select name='" . $_POST['idSelect'] . "' id='" . $_POST['idSelect'] . "' style='width:98%' onFocus='this.style.backgroundColor = \"#ADD8E6\";' 
						  onBlur='this.style.backgroundColor = \"#FFFFFF\";'><option value='0'>Seleccione Gesti&oacute;n</option>";
foreach ($arrGrupoGestion[$_POST['grupo']]['gestion'] as $seqGestion => $arrGestion) {
    echo "<option value='$seqGestion'>" . $arrGestion['nombre'] . "</option>";
}
echo "</select>";
?>
