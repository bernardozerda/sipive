<html>
<body>
	<form action="<? $PHP_SELF ?>" method="POST">
		<table border="0" width="25%">
				<tr><td colspan="3"><b>MIGRACI&Oacute;N CEM A DESEMBOLSO</b></td></tr>
				<tr><td><b>Documento</b></td>
					<td><input type="text" name="documento" id="documento" size="10">&nbsp;
						<select name="tipodoc" id="tipodoc"><option value="1">C.C.</option><option value="2">C.E.</option><option value="3">T.I.</option><option value="4">R.C.</option><option value="5">PAS</option><option value="6">N.I.T.</option><option value="7">N.U.I.</option></select></td>
					<td><input type="submit" value="Migrar"></td>
				</tr>
		</table>
	</form>
	<?php
    if ($_POST['documento']) {
		$txtPrefijoRuta = "";
        include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
        include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
        include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
        if (isset($_POST['documento']) AND ($_POST['documento'] != '')) {
            $cedula = str_replace(",", "", str_replace(".", "", $_POST['documento']));
            $tipoDocumento = $_POST['tipodoc'];
            $sqlForm = @mysql_query("SELECT T_FRM_FORMULARIO.seqFormulario, seqEstadoProceso FROM T_FRM_HOGAR INNER JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano) INNER JOIN T_FRM_FORMULARIO ON (T_FRM_HOGAR.seqFormulario = T_FRM_FORMULARIO.seqFormulario) WHERE numDocumento = '" . $cedula . "' AND seqTipoDocumento = $tipoDocumento");
            $rowForm = mysql_fetch_array($sqlForm);
        }
        // ************************************************ INICIO SECCION INFORMATIVA **********************************************************
		echo "<b>Formulario: </b>[" . $rowForm['seqFormulario'] . "]<br>";
        echo "<b>Estado Proceso: </b>[" . $rowForm['seqEstadoProceso'] . "]<br>";
		$idFormulario = $rowForm['seqFormulario'];
		// MIEMBROS DEL HOGAR
        $sqlMiembros = @mysql_query("SELECT T_FRM_HOGAR.seqCiudadano, seqParentesco, numDocumento, seqTipoDocumento, CONCAT(txtNombre1,' ',txtNombre2,' ',txtApellido1,' ',txtApellido2) AS nombre FROM T_FRM_HOGAR LEFT JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano) WHERE seqFormulario = '" . $rowForm['seqFormulario'] . "' AND seqParentesco = 1");
        while ($rowMiembros = mysql_fetch_array($sqlMiembros)) {
			echo "<b>Postulante Principal: </b> " . utf8_decode($rowMiembros['nombre']) . " C.C. " . number_format($rowMiembros['numDocumento'], 0, ',', '.') . " [" . $rowMiembros['seqCiudadano'] . "]<br>";
        }
		// DATOS DEL DESEMBOLSO
        $sqlDesemb = @mysql_query("SELECT seqDesembolso FROM T_DES_DESEMBOLSO WHERE seqFormulario = '" . $idFormulario . "'");
        $rowDesemb = mysql_fetch_array($sqlDesemb);
		$codigoDesembolso = $rowDesemb['seqDesembolso'];
        echo "<b>Desembolso: </b>[" . $codigoDesembolso . "]<br>";
		$codigoDesembolso = $rowDesemb['seqDesembolso'];
		// DATOS CASA EN MANO
		$sqlMaxCasaMano = @mysql_query("SELECT MAX(seqCasaMano) as maximoCEM FROM T_CEM_CASA_MANO WHERE seqFormulario = '" . $idFormulario . "'");
		$rowMaxCasaMano = mysql_fetch_array($sqlMaxCasaMano);
		$codigoCasamano = $rowMaxCasaMano['maximoCEM'];
		echo "<b>casaMano: </b>[" . $codigoCasamano . "]<br>";

		if ($codigoCasamano == 0 || $codigoCasamano == "") {
			echo "<table align='center'><tr><th><font color='#F00'>REGISTRO NO MIGRADO, NO EXISTE REGISTRO DE CASA EN MANO ASOCIADO A ESE HOGAR</font></th></tr></table>";
		} else {
			// ================================= CREA REGISTRO DE DESEMBOLSO EN EL CASO DE NO TENER  =======================================
			// Campos de t_des_desembolso
			$camposDesembolso = "numEscrituraPublica, numCertificadoTradicion, numCartaAsignacion, numAltoRiesgo, numHabitabilidad, numBoletinCatastral, numLicenciaConstruccion, numUltimoPredial, numUltimoReciboAgua, numUltimoReciboEnergia, numOtros, txtNombreVendedor, numDocumentoVendedor, txtDireccionInmueble, txtBarrio, seqLocalidad, txtEscritura, numNotaria, fchEscritura, numAvaluo, valInmueble, txtMatriculaInmobiliaria, numValorInmueble, txtEscrituraPublica, txtCertificadoTradicion, txtCartaAsignacion, txtAltoRiesgo, txtHabitabilidad, txtBoletinCatastral, txtLicenciaConstruccion, txtUltimoPredial, txtUltimoReciboAgua, txtUltimoReciboEnergia, txtOtro, txtViabilizoJuridico, txtViabilizoTecnico, bolViabilizoJuridico, bolviabilizoTecnico, bolPoseedor, txtChip, numActaEntrega, txtActaEntrega, numCertificacionVendedor, txtCertificacionVendedor, numAutorizacionDesembolso, txtAutorizacionDesembolso, numFotocopiaVendedor, txtFotocopiaVendedor, seqTipoDocumento, txtCompraVivienda, txtNit, txtRit, txtRut, numNit, numRit, numRut, txtTipoPredio, numTelefonoVendedor, txtCedulaCatastral, numAreaConstruida, numAreaLote, txtTipoDocumentos, numEstrato, txtCiudad, fchCreacionBusquedaOferta, fchActualizacionBusquedaOferta, numTelefonoVendedor2, txtPropiedad, fchSentencia, numJuzgado, txtCiudadSentencia, numResolucion, fchResolucion, txtEntidad, txtCiudadResolucion, numContratoArrendamiento, txtContratoArrendamiento, numAperturaCAP, txtAperturaCAP, numCedulaArrendador, txtCedulaArrendador, numCuentaArrendador, txtCuentaArrendador, numRetiroRecursos, txtRetiroRecursos, numServiciosPublicos, txtServiciosPublicos, txtCorreoVendedor, seqCiudad";
			// Campos de t_cem_registro_vivienda
			$camposRegistroVivienda = "numEscrituraPublica, numCertificadoTradicion, numCartaAsignacion, numAltoRiesgo, numHabitabilidad, numBoletinCatastral, numLicenciaConstruccion, numUltimoPredial, numUltimoReciboAgua, numUltimoReciboEnergia, numOtros, txtNombreVendedor, numDocumentoVendedor, txtDireccionInmueble, txtBarrio, seqLocalidad, txtEscritura, numNotaria, fchEscritura, numAvaluo, valInmueble, txtMatriculaInmobiliaria, numValorInmueble, txtEscrituraPublica, txtCertificadoTradicion, txtCartaAsignacion, txtAltoRiesgo, txtHabitabilidad, txtBoletinCatastral, txtLicenciaConstruccion, txtUltimoPredial, txtUltimoReciboAgua, txtUltimoReciboEnergia, txtOtro, txtViabilizoJuridico, txtViabilizoTecnico, bolViabilizoJuridico, bolviabilizoTecnico, bolPoseedor, txtChip, numActaEntrega, txtActaEntrega, numCertificacionVendedor, txtCertificacionVendedor, numAutorizacionDesembolso, txtAutorizacionDesembolso, numFotocopiaVendedor, txtFotocopiaVendedor, seqTipoDocumento, txtCompraVivienda, txtNit, txtRit, txtRut, numNit, numRit, numRut, txtTipoPredio, numTelefonoVendedor, txtCedulaCatastral, numAreaConstruida, numAreaLote, txtTipoDocumentos, numEstrato, txtCiudad, fchCreacion, fchActualizacion, numTelefonoVendedor2, txtPropiedad, fchSentencia, numJuzgado, txtCiudadSentencia, numResolucion, fchResolucion, txtEntidad, txtCiudadResolucion, numContratoArrendamiento, txtContratoArrendamiento, numAperturaCAP, txtAperturaCAP, numCedulaArrendador, txtCedulaArrendador, numCuentaArrendador, txtCuentaArrendador, numRetiroRecursos, txtRetiroRecursos, numServiciosPublicos, txtServiciosPublicos, txtCorreoVendedor, seqCiudad";
			// Verifica si existe el desembolso
			if ($codigoDesembolso == ''){
				$sqlDesembolso = "INSERT INTO T_DES_DESEMBOLSO (seqFormulario, $camposDesembolso)
						SELECT '$idFormulario', $camposRegistroVivienda
						FROM   T_CEM_REGISTRO_VIVIENDA
						WHERE  seqCasaMano = $codigoCasamano";
				mysql_query($sqlDesembolso);
				// Identifica el codigo de desembolso creado
				$sqlUltimoDesembolso = @mysql_query("SELECT MAX(seqDesembolso) AS maximo FROM T_DES_DESEMBOLSO WHERE seqFormulario = $idFormulario");
				$rowUltimoDesembolso = mysql_fetch_array($sqlUltimoDesembolso);
				$codigoDesembolso = $rowUltimoDesembolso['maximo'];
			}

			// ================================ MIGRANDO LOS DATOS TECNICOS Y JURIDICOS DE CASA EN MANO A CEM ===================================
			// Campos de las tablas
			$camposTecnico = "numLargoMultiple, numAnchoMultiple, numAreaMultiple, txtMultiple, numLargoAlcoba1, numAnchoAlcoba1, numAreaAlcoba1, txtAlcoba1, numLargoAlcoba2, numAnchoAlcoba2, numAreaAlcoba2, txtAlcoba2, numLargoAlcoba3, numAnchoAlcoba3, numAreaAlcoba3, txtAlcoba3, numLargoCocina, numAnchoCocina, numAreaCocina, txtCocina, numLargoBano1, numAnchoBano1, numAreaBano1, txtBano1, numLargoBano2, numAnchoBano2, numAreaBano2, txtBano2, numLargoLavanderia, numAnchoLavanderia, numAreaLavanderia, txtLavanderia, numLargoCirculaciones, numAnchoCirculaciones, numAreaCirculaciones, txtCirculaciones, numLargoPatio, numAnchoPatio, numAreaPatio, txtPatio, numAreaTotal, txtEstadoCimentacion, txtCimentacion, txtEstadoPlacaEntrepiso, txtPlacaEntrepiso, txtEstadoMamposteria, txtMamposteria, txtEstadoCubierta, txtCubierta, txtEstadoVigas, txtVigas, txtEstadoColumnas, txtColumnas, txtEstadoPanetes, txtPanetes, txtEstadoEnchapes, txtEnchapes, txtEstadoAcabados, txtAcabados, txtEstadoHidraulicas, txtHidraulicas, txtEstadoElectricas, txtElectricas, txtEstadoSanitarias, txtSanitarias, txtEstadoGas, txtGas, txtEstadoMadera, txtMadera, txtEstadoMetalica, txtMetalica, numLavadero, txtLavadero, numLavaplatos, txtLavaplatos, numLavamanos, txtLavamanos, numSanitario, txtSanitario, numDucha, txtDucha, txtEstadoVidrios, txtVidrios, txtEstadoPintura, txtPintura, txtOtros, txtObservacionOtros, numContadorAgua, txtEstadoConexionAgua, txtDescripcionAgua, numContadorEnergia, txtEstadoConexionEnergia, txtDescripcionEnergia, numContadorAlcantarillado, txtEstadoConexionAlcantarillado, txtDescripcionAlcantarillado, numContadorGas, txtEstadoConexionGas, txtDescripcionGas, numContadorTelefono, txtEstadoConexionTelefono, txtDescripcionTelefono, txtEstadoAndenes, txtDescripcionAndenes, txtEstadoVias, txtDescripcionVias, txtEstadoServiciosComunales, txtDescripcionServiciosComunales, txtDescripcionVivienda, txtNormaNSR98, txtRequisitos, txtExistencia, txtDescipcionNormaNSR98, txtDescripcionRequisitos, txtDescripcionExistencia, fchVisita, txtAprobo, fchCreacion, fchActualizacion";
			$camposJuridico = "numResolucion, fchResolucion, txtObservaciones, txtLibertad, txtConcepto, txtAprobo, fchCreacion, fchActualizacion";

			// Migrando los datos tecnicos de CEM a Desembolso
			$sqlTecnico = "INSERT INTO T_DES_TECNICO (seqDesembolso, $camposTecnico)
						SELECT '$codigoDesembolso', $camposTecnico
						FROM   T_CEM_TECNICO
						WHERE  seqCasaMano = $codigoCasamano";
			mysql_query($sqlTecnico);

			// Identifica el codigo seqTecnico creado
			$sqlUltimoTecnico = @mysql_query("SELECT MAX(seqTecnico) AS maximoTecnico FROM T_DES_TECNICO WHERE seqDesembolso = $codigoDesembolso");
			$rowUltimoTecnico = mysql_fetch_array($sqlUltimoTecnico);
			$codigoTecnico = $rowUltimoTecnico['maximoTecnico'];

			// Migrando los datos juridicos de CEM a Desembolso
			$sqlJuridico = "INSERT INTO T_DES_JURIDICO (seqDesembolso, $camposJuridico)
						SELECT '$codigoDesembolso', $camposJuridico
						FROM   T_CEM_JURIDICO
						WHERE  seqCasaMano = $codigoCasamano";
			mysql_query($sqlJuridico);

			// Identifica el codigo seqJuridico creado
			$sqlUltimoJuridico = @mysql_query("SELECT MAX(seqJuridico) AS maximoJuridico FROM T_DES_JURIDICO WHERE seqDesembolso = $codigoDesembolso");
			$rowUltimoJuridico = mysql_fetch_array($sqlUltimoJuridico);
			$codigoJuridico = $rowUltimoJuridico['maximoJuridico'];

			// ============================= CONSULTANDO LOS ADJUNTOS TECNICOS Y JURIDICOS DE CASA EN MANO ===================================
			// Campos de las tablas
			$camposAdjuntosTecnicos = "seqTipoAdjunto, txtNombreAdjunto, txtNombreArchivo";
			$camposAdjuntosJuridicos = "seqTipoAdjunto, txtAdjunto";

			// Obtiene codigo de seqTecnico en tabla CEM
			$sqlSeqTecnicoCEM = @mysql_query("SELECT seqTecnico FROM T_CEM_TECNICO WHERE seqCasaMano = $codigoCasamano");
			$rowSeqTecnicoCEM = mysql_fetch_array($sqlSeqTecnicoCEM);
			$codigoTecnicoCEM = $rowSeqTecnicoCEM['seqTecnico'];

			// Obtiene codigo de seqJuridico en tabla CEM
			$sqlSeqJuridicoCEM = @mysql_query("SELECT seqJuridico FROM T_CEM_JURIDICO WHERE seqCasaMano = $codigoCasamano");
			$rowSeqJuridicoCEM = mysql_fetch_array($sqlSeqJuridicoCEM);
			$codigoJuridicoCEM = $rowSeqJuridicoCEM['seqJuridico'];

			// Adjuntos Tecnicos de CEM
			$sqlAdjuntosTecnicosCEM = @mysql_query("SELECT seqAdjuntoTecnico FROM T_CEM_ADJUNTOS_TECNICOS WHERE seqTecnico = $codigoTecnicoCEM");
			while ($rowAdjuntosTecnicos = mysql_fetch_array($sqlAdjuntosTecnicosCEM)){
				$sqlAdjuntosTecnicos = "INSERT INTO T_DES_ADJUNTOS_TECNICOS (seqTecnico, $camposAdjuntosTecnicos)
										SELECT '$codigoTecnico', $camposAdjuntosTecnicos
												FROM   T_CEM_ADJUNTOS_TECNICOS
												WHERE  seqAdjuntoTecnico = " . $rowAdjuntosTecnicos['seqAdjuntoTecnico'];
				mysql_query($sqlAdjuntosTecnicos);
			}

			// Adjuntos Juridicos de CEM
			$sqlAdjuntosJuridicosCEM = @mysql_query("SELECT seqAdjuntoJuridico FROM T_CEM_ADJUNTOS_JURIDICOS WHERE seqJuridico = $codigoJuridicoCEM");
			while ($rowAdjuntosJuridicos = mysql_fetch_array($sqlAdjuntosJuridicosCEM)){
				$sqlAdjuntosJuridicos = "INSERT INTO T_DES_ADJUNTOS_JURIDICOS (seqJuridico, $camposAdjuntosJuridicos)
										SELECT '$codigoJuridico', $camposAdjuntosJuridicos
												FROM   T_CEM_ADJUNTOS_JURIDICOS
												WHERE  seqAdjuntoJuridico = " . $rowAdjuntosJuridicos['seqAdjuntoJuridico'];
				mysql_query($sqlAdjuntosJuridicos);
			}
			echo "<table align='center'><tr><td><font color='#06F'>REGISTRO MIGRADO</font></td></tr></table>";
		}
	}
	?>
</body>
</html>