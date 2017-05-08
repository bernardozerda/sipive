<?php
	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

	// Verifica si el proyecto tiene conjuntos residenciales 
	$sqlVerifica = "
		SELECT 
			seqProyecto
		FROM 
			T_PRY_PROYECTO
		WHERE 
			seqProyectoPadre = " . $_POST['proyectoPadre'] . "
	";
	$exeSqlVerifica = mysql_query($sqlVerifica);
	$cuantosConjuntos = mysql_num_rows($exeSqlVerifica);
	
	if ($cuantosConjuntos > 0){
		// Conjunto Residencial
		echo "
			<select	onFocus=\"this.style.backgroundColor = '#ADD8E6';\" 
					onBlur=\"this.style.backgroundColor = '#FFFFFF';\" 
					onChange=\"obtenerUnidadProyecto(this);\"
					name=\"seqProyectoHijo\" 
					id=\"seqProyectoHijo\" 
					style=\"width:100%;\"
			>
		";

		$sql = "
			SELECT 
				seqProyecto,
				txtNombreProyecto
			FROM 
				T_PRY_PROYECTO
			WHERE 
				seqProyectoPadre = " . $_POST['proyectoPadre'] . "
			ORDER BY
				txtNombreProyecto
		";
		
		$exeSql = mysql_query($sql);
		while ($rowSql = mysql_fetch_array($exeSql)){
				echo "<option value='" . $rowSql['seqProyecto'] . "' >" . $rowSql['txtNombreProyecto'] . "</option>";
		}

		echo "</select>";
	} else {
		echo "No Aplica";
	}
	//echo "CR: ".$sql;
?>