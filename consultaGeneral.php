<html>
    <body>
        <form action="<?php $PHP_SELF ?>" method="POST">
            <table border="0">
                <tr><td><b>Documento</b></td><td><input type="text" name="documento" id="documento" size="10">&nbsp;<select name="tipodoc" id="tipodoc"><option value="1">C.C.</option><option value="2">C.E.</option><option value="3">T.I.</option><option value="4">R.C.</option><option value="5">PAS</option><option value="6">N.I.T.</option><option value="7">N.U.I.</option></select></td><td rowspan="3" valign="top"><input type="submit" value="Consultar" style="height:50px"></td></tr>
                <tr><td><b>Formulario</b></td><td><input type="text" name="formulario" id="formulario" value="<?php echo $_POST['formulario']; ?>"></td></tr>
            </table></form>
        <?php
        $txtPrefijoRuta = "";
        include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
        include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
        include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
        if (isset($_POST['documento']) AND ($_POST['documento'] != '')) {
            $cedula = str_replace(",", "", str_replace(".", "", $_POST['documento']));
            $tipoDocumento = $_POST['tipodoc'];
            $sqlForm = mysql_query("SELECT T_FRM_FORMULARIO.seqFormulario, seqEstadoProceso, seqTipoEsquema, bolCerrado, seqModalidad, fchInscripcion, fchUltimaActualizacion, bolDesplazado, seqProyecto, seqProyectoHijo, seqUnidadProyecto, txtDireccionSolucion, txtMatriculaInmobiliaria, txtChip, valTotalRecursos, txtFormulario, valIngresoHogar, seqPlanGobierno, valAspiraSubsidio FROM T_FRM_HOGAR INNER JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano) INNER JOIN T_FRM_FORMULARIO ON (T_FRM_HOGAR.seqFormulario = T_FRM_FORMULARIO.seqFormulario) WHERE numDocumento = '" . $cedula . "' AND seqTipoDocumento = $tipoDocumento");
            $rowForm = mysql_fetch_array($sqlForm);
        } elseif (isset($_POST['formulario']) AND ($_POST['formulario'] != '')) {
            $formulario = $_POST['formulario'];
            $sqlForm = mysql_query("SELECT T_FRM_FORMULARIO.seqFormulario, seqEstadoProceso, seqTipoEsquema, bolCerrado, seqModalidad, fchInscripcion, fchUltimaActualizacion, bolDesplazado, seqProyecto, seqProyectoHijo, seqUnidadProyecto, txtDireccionSolucion, txtMatriculaInmobiliaria, txtChip, valTotalRecursos, txtFormulario, valIngresoHogar, seqPlanGobierno, valAspiraSubsidio FROM T_FRM_HOGAR INNER JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano) INNER JOIN T_FRM_FORMULARIO ON (T_FRM_HOGAR.seqFormulario = T_FRM_FORMULARIO.seqFormulario) WHERE T_FRM_FORMULARIO.seqFormulario = '" . $formulario . "'");
            $rowForm = mysql_fetch_array($sqlForm);
        }
		// Estado de Proceso
		if ($rowForm['seqEstadoProceso'] == 0){ $estadoProceso = 0; } else { $estadoProceso = $rowForm['seqEstadoProceso']; }
		$sqlEstadoProceso = @mysql_query("SELECT * FROM T_FRM_ESTADO_PROCESO WHERE seqEstadoProceso = $estadoProceso;");
		$rowEstadoProceso = mysql_fetch_array($sqlEstadoProceso);
		// Modalidad
		if ($rowForm['seqModalidad'] == 0){ $modalidad = 0; } else { $modalidad = $rowForm['seqModalidad']; }
		$sqlModalidad = @mysql_query("SELECT * FROM T_FRM_MODALIDAD WHERE seqModalidad = $modalidad;");
		$rowModalidad = mysql_fetch_array($sqlModalidad);
		// Esquema
		if ($rowForm['seqTipoEsquema'] == 0){ $esquema = 0; } else { $esquema = $rowForm['seqTipoEsquema']; }
		$sqlEsquema = @mysql_query("SELECT * FROM T_PRY_TIPO_ESQUEMA WHERE seqTipoEsquema = $esquema;");
		$rowEsquema = mysql_fetch_array($sqlEsquema);
		// Plan de Gobierno
		if ($rowForm['seqPlanGobierno'] == 0){ $planGobierno = 0; } else { $planGobierno = $rowForm['seqPlanGobierno']; }
		$sqlPlanGobierno = @mysql_query("SELECT * FROM T_FRM_PLAN_GOBIERNO WHERE seqPlanGobierno = $planGobierno;");
		$rowPlanGobierno = mysql_fetch_array($sqlPlanGobierno);
		// Proyecto
		if ($rowForm['seqProyecto'] == 0){ $proyecto = 0; } else { $proyecto = $rowForm['seqProyecto']; }
		$sqlProyecto = @mysql_query("SELECT * FROM T_PRY_PROYECTO WHERE seqProyecto = $proyecto;");
		$rowProyecto = mysql_fetch_array($sqlProyecto);
		// Proyecto Hijo
		if ($rowForm['seqProyectoHijo'] == 0){ $proyectoHijo = 0; } else { $proyectoHijo = $rowForm['seqProyectoHijo']; }
		$sqlProyectoHijo = @mysql_query("SELECT * FROM T_PRY_PROYECTO WHERE seqProyecto = $proyectoHijo;");
		$rowProyectoHijo = mysql_fetch_array($sqlProyectoHijo);
		// Unidad Proyecto
		if ($rowForm['seqUnidadProyecto'] == 0){ 
			$unidadProyecto = 0; 
		} else { 
			$unidadProyecto = $rowForm['seqUnidadProyecto']; 
		}
		$sqlUnidadProyecto = @mysql_query("SELECT * FROM T_PRY_UNIDAD_PROYECTO WHERE seqUnidadProyecto = $unidadProyecto;");
		$rowUnidadProyecto = mysql_fetch_array($sqlUnidadProyecto);

        echo "<table width='760'>";
		echo "<tr><td width='35%'><b>Formulario:</b></td><td>[" . $rowForm['seqFormulario'] . "]</td></tr>";
        echo "<tr title=''><td><b>Estado Proceso:</b></td><td>[" . $rowEstadoProceso['seqEstadoProceso'] . "] " . utf8_decode($rowEstadoProceso['txtEstadoProceso']) . "</td></tr>";
        echo "<tr title=''><td><b>Modalidad:</b></td><td>[" . $rowModalidad['seqModalidad'] . "] " . utf8_decode($rowModalidad['txtModalidad']) . "</td></tr>";
        echo "<tr><td><b>Fecha Inscripci&oacute;n:</b></td><td>" . $rowForm['fchInscripcion'] . "</td></tr>";
        echo "<tr><td><b>Fecha Actualizaci&oacute;n:</b></td><td>" . $rowForm['fchUltimaActualizacion'] . "</td></tr>";
		echo "<tr title='0->No, 1->Si'><td><b>Desplazamiento Forzado:</b></td><td>" . $rowForm['bolDesplazado'] . "</td></tr>";
		echo "<tr><td><b>Ingresos del Hogar:</b></td><td>$ " . $rowForm['valIngresoHogar'] . "</td></tr>";
		echo "<tr><td><b>Total Recursos:</b></td><td>$ " . $rowForm['valTotalRecursos'] . "</td></tr>";
        echo "<tr><td><b>Plan de Gobierno:</b></td><td>[" . $rowPlanGobierno['seqPlanGobierno'] . "] " . utf8_decode($rowPlanGobierno['txtPlanGobierno']) . "</td></tr>";
        echo "<tr><td><b>Tipo Esquema:</b></td><td>[" . $rowEsquema['seqTipoEsquema'] . "] " . $rowEsquema['txtTipoEsquema'] . "</td></tr>";
        echo "<tr><td><b>N&uacute;mero de Formulario:</b></td><td>" . $rowForm['txtFormulario'] . "</td></tr>";
		echo "<tr title='0:No, 1:Si'><td><b>Formulario Cerrado:</b></td><td>";
		if ($rowForm['bolCerrado'] == 0) {
			echo "[0] Formulario Abierto";
		} else {
			echo "[1] Formulario Cerrado";
		}
		echo "</td></tr>";
		echo "<tr><td><b>Valor Subsidio:</b></td><td>$ " . $rowForm['valAspiraSubsidio'] . " *</td></tr>";
		echo "<tr><td><b><hr>Proyecto:</b></td><td><hr>[" . $rowProyecto['seqProyecto'] . "] " . utf8_decode($rowProyecto['txtNombreProyecto']) . "</td></tr>";
		echo "<tr><td><b>Unidad Residencial:</b></td><td>[" . $rowProyectoHijo['seqProyecto'] . "] " . utf8_decode($rowProyectoHijo['txtNombreProyecto']) . "</td></tr>";
		echo "<tr><td><b>Unidad Proyecto:</b></td><td>[" . $rowUnidadProyecto['seqUnidadProyecto'] . "] " . utf8_decode($rowUnidadProyecto['txtNombreUnidad']) . "</td></tr>";
		echo "<tr><td><b>Valor Actual Unidad:</b></td><td>$ " . utf8_decode($rowUnidadProyecto['valSDVEActual']) . " *</td></tr>";
		echo "<tr><td><b>Formulario asignado a Unidad:</b></td><td>[" . utf8_decode($rowUnidadProyecto['seqFormulario']) . "]</td></tr>";
        echo "<tr><td><b>Direcci&oacute;n Soluci&oacute;n:</b></td><td>" . $rowForm['txtDireccionSolucion'] . "</td></tr>";
		echo "<tr><td><b>Matricula Inmobiliaria:</b></td><td>" . $rowForm['txtMatriculaInmobiliaria'] . "</td></tr>";
		echo "<tr><td><b>Chip:</b></td><td>" . $rowForm['txtChip'] . "</td></tr>";
		echo "</table>";

		// DATOS DEL DESEMBOLSO
        $sqlDesemb = mysql_query("SELECT seqDesembolso FROM T_DES_DESEMBOLSO WHERE seqFormulario = '" . $rowForm['seqFormulario'] . "'");
        $rowDesemb = mysql_fetch_array($sqlDesemb);
        echo "<table width='760'><tr><td width='35%'><b>Desembolso:</b></td><td align='left'>[" . $rowDesemb['seqDesembolso'] . "]</td></tr></table>";

		// DATOS DEL FLUJO
        $sqlFlujo = mysql_query("SELECT txtFlujo FROM T_DES_FLUJO WHERE seqFormulario = '" . $rowForm['seqFormulario'] . "'");
        $rowFlujo = mysql_fetch_array($sqlFlujo);
        echo "<table width='760'><tr><td width='35%'><b>Flujo:</b></td><td align='left'>" . $rowFlujo['txtFlujo'] . "</td></tr></table>";

		// DATOS CASA EN MANO
        $sqlCasaMano = mysql_query("SELECT seqCasaMano, fchRegistroVivienda FROM T_CEM_CASA_MANO WHERE seqFormulario = '" . $rowForm['seqFormulario'] . "'");
		echo "<br><table border='1' cellpadding='3' cellspacing='1'> ";
		echo "<tr style='background-color:black; color:white'><th>Casa en Mano</th><th>Fecha Registro vivienda</th></tr>";
		while ($rowCasaMano = mysql_fetch_array($sqlCasaMano)){
			echo "<tr><td align='center'>" . $rowCasaMano['seqCasaMano'] . "</td><td align='center'>" . $rowCasaMano['fchRegistroVivienda'] . "</td></tr>";
		}
		echo "</table>";

		// MIEMBROS DEL HOGAR
        $sqlMiembros = mysql_query("SELECT T_FRM_HOGAR.seqCiudadano, seqParentesco, seqEstadoCivil, numDocumento, seqTipoDocumento, CONCAT(txtNombre1,' ',txtNombre2,' ',txtApellido1,' ',txtApellido2) AS nombre, valIngresos, seqTipoVictima FROM T_FRM_HOGAR LEFT JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano) WHERE seqFormulario = '" . $rowForm['seqFormulario'] . "'");
        echo "<br><table border='1' cellpadding='3' cellspacing='1'><tr><th colspan='8' style='background-color:black; color:white'>Miembros del Hogar</th></tr><tr style='background-color:black; color:white'><th>Ciudadano</th><th>Documento</th><th>Tipo de Documento</th><th>Nombre</th><th>Parentesco</th><th>Estado Civil</th><th>Tipo Victima</th><th>Ingreso</th></tr>";
        while ($rowMiembros = mysql_fetch_array($sqlMiembros)) {
            // Tipo Documento
			$tipoDocumento = $rowMiembros['seqTipoDocumento'];
			$sqlTipoDocumento = @mysql_query("SELECT * FROM T_CIU_TIPO_DOCUMENTO WHERE seqTipoDocumento = $tipoDocumento;");
			$rowTipoDocumento = mysql_fetch_array($sqlTipoDocumento);
			// Estado Civil
			$estadoCivil = $rowMiembros['seqEstadoCivil'];
			$sqlEstadoCivil = @mysql_query("SELECT * FROM T_CIU_ESTADO_CIVIL WHERE seqEstadoCivil = $estadoCivil;");
			$rowEstadoCivil = mysql_fetch_array($sqlEstadoCivil);
			// Parentesco
			$parentesco = $rowMiembros['seqParentesco'];
			$sqlParentesco = @mysql_query("SELECT * FROM T_CIU_PARENTESCO WHERE seqParentesco = $parentesco;");
			$rowParentesco = mysql_fetch_array($sqlParentesco);
			
			echo "<tr><td align='center'>" . $rowMiembros['seqCiudadano'] . "</td>";
			if ($rowParentesco['seqParentesco'] == 1){
				echo "<td align='right'><b>" . number_format($rowMiembros['numDocumento'], 0, ',', '.') . "</b></td>";
			} else {
				echo "<td align='right'>" . number_format($rowMiembros['numDocumento'], 0, ',', '.') . "</td>";
			}
            echo "<td align='left'>[" . $rowTipoDocumento['seqTipoDocumento'] . "] " . utf8_decode($rowTipoDocumento['txtTipoDocumento']) . "</td>";
            echo "<td>" . utf8_decode($rowMiembros['nombre']) . "</td>";
            echo "<td align='left'>[" . $rowParentesco['seqParentesco'] . "] " . utf8_decode($rowParentesco['txtParentesco']) . "</td>";
			echo "<td align='left'>[" . $rowEstadoCivil['seqEstadoCivil'] . "] " . utf8_decode($rowEstadoCivil['txtEstadoCivil']) . "</td>";
            echo "<td align='center'>" . $rowMiembros['seqTipoVictima'] . "</td>";
            echo "<td align='right'>$ " . $rowMiembros['valIngresos'] . "</td></tr>";
        }
        echo "</table>";

// DATOS ACTOS ADMINISTRATIVOS
		$sqlAAD = mysql_query("SELECT T_AAD_HOGARES_VINCULADOS.numActo as acto,
									T_AAD_HOGARES_VINCULADOS.fchActo as fecha,
									t_aad_tipo_acto.txtNombreTipoActo as tipo,
									t_frm_modalidad.txtModalidad as modalidad
								FROM ((sipive.T_AAD_HOGARES_VINCULADOS T_AAD_HOGARES_VINCULADOS
									LEFT JOIN sipive.T_AAD_FORMULARIO_ACTO t_aad_formulario_acto ON (T_AAD_HOGARES_VINCULADOS.seqFormularioActo = t_aad_formulario_acto.seqFormularioActo))
									LEFT JOIN sipive.t_aad_tipo_acto t_aad_tipo_acto ON (T_AAD_HOGARES_VINCULADOS.seqTipoActo = t_aad_tipo_acto.seqTipoActo))
									LEFT JOIN sipive.t_frm_modalidad t_frm_modalidad ON (t_frm_modalidad.seqModalidad = t_aad_formulario_acto.seqModalidad)
								WHERE t_aad_formulario_acto.seqFormulario = '" . $rowForm['seqFormulario'] . "'");
        echo "<br>
            <fieldset><legend><b>Actos Administrativos</b></legend>
            <table border='1' cellpadding='1' cellspacing='1'>            
            <tr style='background-color:black; color:white'><th>Acto</th><th>Fecha del Acto</th><th>Tipo de Acto</th><th>Modalidad</th></tr>";
        while ($rowActos = mysql_fetch_array($sqlAAD)) {
            echo"<tr>
                <td>" . $rowActos['acto'] . "</td>
                <td>" . $rowActos['fecha'] . "</td>
                <td>" . utf8_decode($rowActos['tipo']) . "</td>
                <td>" . utf8_decode($rowActos['modalidad']) . "</td>
				</tr>";
        }
        echo"</table></fieldset>";
		//mysql_close();
        ?>
    </body>
</html>