<html>
	<head>
		<link href="librerias/bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	</head>
    <body>
        <form action="<?php $PHP_SELF ?>" method="POST" autocomplete="off">
            <table border="1" cellspacing="0" cellpadding="4">
                <tr><th>Documento</th>
					<td colspan="3"><input type="text" name="documento" id="documento" size="10">
				</tr>
				<tr><!-- Tipo de Postulación -->
					<th>Tipo</th>
					<td colspan="3" valign="top">
						<input type="radio" id="solicita" name="solicita" value="indsac" checked> Individual SAC&nbsp;
						<input type="radio" id="solicita" name="solicita" value="indcvp"> Individual CVP&nbsp;
						<input type="radio" id="solicita" name="solicita" value="mjrcvp"> Mejoramiento
					</td>
				</tr>
				<tr><!-- Quién realiza el cambio -->
					<th>Usuario</th><td><input type="text" class="input-medium" name="huser" id="huser"></td>
					<th>Clave</th><td><input type="password" class="input-medium" name="klave" id="klave"></td>
				</tr>
				<tr><td colspan="4" align="right"><input type="submit" value="Cambiar Estado" class="btn btn-default"></td></tr>
            </table></form>
        <?php
		$fecha = date('Y-m-d H:i:s');
        $txtPrefijoRuta = "";
        include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
        include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
        include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

		// Validando usuario
		$usr_val = array(5, 218, 251, 376, 414);
		$klavenc = sha1($_POST['klave']);
		$sqlUsuario = "SELECT seqUsuario FROM T_COR_USUARIO WHERE txtUsuario = '".$_POST['huser']."' AND txtClave = '".$klavenc."'";
		$exeUsuario = @mysql_query($sqlUsuario);
		$rowUsuario = mysql_fetch_array($exeUsuario);
		$seqUsuario = $rowUsuario['seqUsuario'];
		
		if(in_array($seqUsuario, $usr_val)){ // Si el usuario es válido proceda
			if (isset($_POST['documento'])) {
				$cedula = str_replace(",", "", str_replace(".", "", $_POST['documento']));
				if ($_POST['solicita'] == 'indcvp'){
					$leyenda = "POR SOL. PARA POSTULACION EPI VUR MENSAJE RESPONSABLE POSTULACION CVP";
					$estadoSiguiente = 54;
				} else if ($_POST['solicita'] == 'indsac') {
					$leyenda = "POR SOL. PARA POSTULACION EPI MENSAJE RESPONSABLE POSTULACION";
					$estadoSiguiente = 54;
				} else if ($_POST['solicita'] == 'mjrcvp') {
					$leyenda = "POR SOL. PARA POSTULACION TERRITORIAL MH. MENSAJE RESPONSABLE POSTULACION CVP";
					$estadoSiguiente = 7;
				}
				$sqlForm = "SELECT T_FRM_FORMULARIO.seqFormulario, seqEstadoProceso, fchUltimaActualizacion, CONCAT(txtNombre1,' ',txtNombre2,' ',txtApellido1,' ',txtApellido2) AS nombre FROM T_FRM_HOGAR INNER JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano) INNER JOIN T_FRM_FORMULARIO ON (T_FRM_HOGAR.seqFormulario = T_FRM_FORMULARIO.seqFormulario) WHERE seqParentesco = 1 AND numDocumento = '" . $cedula . "' AND seqTipoDocumento = 1";
				$exeForm = @mysql_query($sqlForm);
				$rowForm = mysql_fetch_array($exeForm);
			}
			$formulario				= $rowForm['seqFormulario'];
			$estadoAnterior			= $rowForm['seqEstadoProceso'];
			$ultimaActualizacion	= $rowForm['fchUltimaActualizacion'];
			$nombreCompleto			= $rowForm['nombre'];
			// Actualizando Estado a Postulacion
			$sqlActualiza = "UPDATE T_FRM_FORMULARIO SET seqEstadoProceso = $estadoSiguiente WHERE seqFormulario = $formulario";
			$resultado = mysql_query($sqlActualiza);
			$afectados = mysql_affected_rows();
			if( $afectados > 0) {
				// Crea Seguimiento del cambio de estado
				$sqlSeguimiento = "INSERT INTO T_SEG_SEGUIMIENTO (seqFormulario, fchMovimiento, seqUsuario, txtComentario, txtCambios, numDocumento, txtNombre, seqGestion, bolMostrar) VALUES ($formulario, '".$fecha."', $seqUsuario, '" . $leyenda . "', '<b>[ " . $formulario . " ] Cambios en el formulario</b><br>seqEstadoProceso, Valor Anterior: $estadoAnterior, Valor Nuevo: $estadoSiguiente<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;fchUltimaActualizacion, Valor Anterior: ".$ultimaActualizacion.", Valor Nuevo: " . $fecha . "<br>', $cedula, '" . $nombreCompleto . "', 46, 1)";
				mysql_query($sqlSeguimiento);
				echo "Se actualiz&oacute; el estado del hogar";
			} else {
				echo "No se pudo actualizar el estado del hogar";
			}
        } else {
			echo "Usuario No Autorizado";
		}
		?>
    </body>
</html>