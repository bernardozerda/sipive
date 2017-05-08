<?php
   /**
    * CONTENIDO DEL POPUP DE AYUDA. OBTIENE CODIGO DE PROYECTO Y UNIDAD HABITACIONAL
    * @author Jaison Ospina
    * @version 1.0 Mayo de 2015
    **/

   $txtPrefijoRuta = "../../";

	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

	$sqlCombo = "SELECT seqProyecto, txtNombreProyecto FROM T_PRY_PROYECTO WHERE seqTipoEsquema = 1 AND seqProyectoPadre is null ORDER BY txtNombreProyecto ASC";
	$exeCombo = @mysql_query($sqlCombo);
	print_r("<form action = '$PHP_SELF' method = 'POST'><table>");
	print_r("<tr><td>Proyecto</td>");
	print_r("<td><select name='seqProyecto' id='seqProyecto'>");
	print_r("<option value=''>-- Seleccione el proyecto --</option>");
	while ($rowCombo = mysql_fetch_array($exeCombo)){
		print_r("<option value='" . $rowCombo['seqProyecto'] . "'>" . $rowCombo['txtNombreProyecto'] . "</option>");
	}
	print_r("</select></td>");
	print_r("<td><input type='submit' value='Consultar'></td></tr>");
	print_r("</table></form>");

	if ($_POST['seqProyecto']){
		// Datos del Proyecto
		$sqlDatosProyecto = @mysql_query("SELECT seqProyecto, txtNombreProyecto FROM T_PRY_PROYECTO WHERE seqProyecto = " . $_POST['seqProyecto'] );
		$rowDatosProyecto = mysql_fetch_array($sqlDatosProyecto);
		$codigoProyecto = $rowDatosProyecto['seqProyecto'];
		$nombreProyecto = $rowDatosProyecto['txtNombreProyecto'];
		echo "<b>Proyecto:</b> " . $nombreProyecto . " [" . $codigoProyecto . "]<br>";

		// Unidades disponibles para proyectos con conjunto residencial
		$sqlHijo = "SELECT seqProyecto FROM T_PRY_PROYECTO WHERE seqProyectoPadre = " . $_POST['seqProyecto'];
		$exeHijo = @mysql_query($sqlHijo);
		while($rowHijo = mysql_fetch_array($exeHijo)){
			$proyectoHijo = $rowHijo['seqProyecto'];
			$flag = 1;
			// Datos del Proyecto Hijo
			$sqlDatosProyectoHijo = @mysql_query("SELECT seqProyecto, txtNombreProyecto FROM T_PRY_PROYECTO WHERE seqProyecto = " . $proyectoHijo );
			$rowDatosProyectoHijo = mysql_fetch_array($sqlDatosProyectoHijo);	
			$codigoProyectoHijo = $rowDatosProyectoHijo['seqProyecto'];
			$nombreProyectoHijo = $rowDatosProyectoHijo['txtNombreProyecto'];
			echo "<br><b>Conjunto Residencial:</b> " . $nombreProyectoHijo . " [" . $codigoProyectoHijo . "]<br><br>";	
			// Muestra las unidades habitacionales disponibles
			$sqlUnidades = "SELECT * FROM T_PRY_UNIDAD_PROYECTO WHERE seqProyecto = " . $proyectoHijo . " AND (seqFormulario < 1 OR seqFormulario is null) ORDER BY txtNombreUnidad";
			$exeUnidades = @mysql_query($sqlUnidades);
			print_r("<table width='100%' border=1 cellspacing=0 cellpadding=0>");
			print_r("<tr><th width='15%'>C&oacute;digo</th><th width='85%'>Unidad habitacional</th></tr>");
			while($rowUnidades = mysql_fetch_array($exeUnidades)){
				print_r("<tr><td align='center'>" . $rowUnidades['seqUnidadProyecto'] . "</td>");
				print_r("<td style='padding-left:10px'>" . $rowUnidades['txtNombreUnidad'] . "</td></tr>");
			}
			print_r("</table>");
		}
		
		// Unidades disponibles para proyectos sin conjunto residencial
		if ($flag == 0){
			$sqlUnidades = "SELECT * FROM T_PRY_UNIDAD_PROYECTO WHERE seqProyecto = " . $_POST['seqProyecto'] . " AND (seqFormulario < 1 OR seqFormulario is null) ORDER BY txtNombreUnidad";
			$exeUnidades = @mysql_query($sqlUnidades);
			print_r("<table width='100%' border=1 cellspacing=0 cellpadding=0>");
			print_r("<tr><th width='15%'>C&oacute;digo</th><th width='85%'>Unidad habitacional</th></tr>");
			while($rowUnidades = mysql_fetch_array($exeUnidades)){
				print_r("<tr><td align='center'>" . $rowUnidades['seqUnidadProyecto'] . "</td>");
				print_r("<td style='padding-left:10px'>" . $rowUnidades['txtNombreUnidad'] . "</td></tr>");
			}
			print_r("</table>");
		}
	}
?>