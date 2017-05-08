<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	
	/*$txtValidacion = "";
	if( $_POST['modalidad'] == 1 ){
		$txtValidacion = " AND seqSolucion <> 1"; 
	}*/
	
	/*// Estructura del Proyecto
	$sql = "
		SELECT 
			seqUnidadProyecto,
			txtNombreUnidad, 
			seqFormulario
		FROM 
			T_PRY_UNIDAD_PROYECTO
		WHERE 
			seqProyecto = " . $_POST['proyecto'] . "
		AND 
			bolActivo = 1
	";

	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrUnidadProyecto[ $objRes->fields['seqUnidadProyecto'] ] = $objRes->fields['txtNombreUnidad'];
		$objRes->MoveNext();
	}	
	
	$txtNinguna = "<option value='1'>NINGUNA</option>"; 
	echo "
		<select	onFocus=\"this.style.backgroundColor = '#ADD8E6';\" 
				onBlur=\"this.style.backgroundColor = '#FFFFFF';\" 
				name=\"seqUnidadProyecto\" 
				id=\"seqUnidadProyecto\" 
				style=\"width:100%;\"
		>$txtNinguna
	";
	if (!empty($arrUnidadProyecto)){
		foreach( $arrUnidadProyecto as $seqUnidadProyecto => $txtNombreUnidad ){
				echo "<option value='$seqUnidadProyecto'>$txtNombreUnidad</option>";
			
		}
	}
	echo "</select>";*/
	
	// Estructura del Proyecto
	$txtNinguna = "<option value='1'>NINGUNAS</option>"; 
	echo "
		<select	onFocus=\"this.style.backgroundColor = '#ADD8E6';\" 
				onBlur=\"this.style.backgroundColor = '#FFFFFF';\" 
				onChange=\"asignarValorSubsidioUnidadProyecto(this)\" 
				name=\"seqUnidadProyecto\" 
				id=\"seqUnidadProyecto\" 
				style=\"width:100%;\"
		>$txtNinguna
	";

	$sqlConsultaHijos = "SELECT 
							seqProyecto 
						FROM 
							T_PRY_PROYECTO 
						WHERE 
							seqProyectoPadre = " . $_POST['proyecto'] . "
						ORDER BY 
							txtNombreProyecto 
						LIMIT 
							1";
	$exeConsultaHijos = mysql_query($sqlConsultaHijos);
	$cntConsultaHijos = mysql_num_rows($exeConsultaHijos);
	$rowConsultaHijos = mysql_fetch_array($exeConsultaHijos);
	$primerProyectoHijo = $rowConsultaHijos['seqProyecto'];
	
	if ($cntConsultaHijos == 0){
		$sql = "
			SELECT 
				seqUnidadProyecto,
				txtNombreUnidad, 
				seqFormulario
			FROM 
				T_PRY_UNIDAD_PROYECTO
			WHERE 
				seqProyecto = " . $_POST['proyecto'] . "
			AND 
				bolActivo = 1
			ORDER BY
				txtNombreUnidad
		";
	} else {
			$sql = "
			SELECT 
				seqUnidadProyecto,
				txtNombreUnidad, 
				seqFormulario
			FROM 
				T_PRY_UNIDAD_PROYECTO
			WHERE 
				seqProyecto = " . $primerProyectoHijo . "
			AND 
				bolActivo = 1
			ORDER BY
				txtNombreUnidad
		";
	}

	$exeSql = mysql_query($sql);
	while ($rowSql = mysql_fetch_array($exeSql)){
		if (($rowSql['seqFormulario'] == '') || ($rowSql['seqFormulario'] == 0)) {
			echo "<option value='" . $rowSql['seqUnidadProyecto'] . "'>" . $rowSql['txtNombreUnidad'] . "</option>";
		} else {
			echo "<option value='" . $rowSql['seqUnidadProyecto'] . "' disabled>" . $rowSql['txtNombreUnidad'] . "</option>";
		}
	}

	echo "</select>";
	//echo "<input type='text' name='valSDVEActual' id='valSDVEActual' value=''>";
	//echo "UP: ".$sql."<br>";
	//echo "consultahijos: ".$sqlConsultaHijos."<br>";
	//echo $primerProyectoHijo;
?>
