<?php
session_start();
if(($_SESSION['seqUsuario'] == 5) || ($_SESSION['seqUsuario'] == 218) || ($_SESSION['seqUsuario'] == 414)){ ?>
	<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" >
	   <head>
		  
		  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="title" content="Subsidios de Vivienda">
			<meta name="keywords" content="subsidio,vivienda,social,prioritaria,bogota,habitat,asignacion,credito" />
			<meta name="description" content="Sistema de informacion de subsidios de vivienda">
			<meta http-equiv="Content-Language" content="es">
			<meta name="robots" content="index,  nofollow" />

		  <title>SDVE</title>

		  <!-- Estilos CSS -->        
		  <link href="librerias/bootstrap/css/bootstrap.css" rel="stylesheet">        
		  <link href="librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
		  
			 <style type="text/css">
				body {
					padding-top: 20px;
					padding-bottom: 40px;
				}
				.textoCeldas{
					padding: 7px;
					font-family: Arial;
					font-size: 12px;
				}
			</style>
			 <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
			 <!--[if lt IE 9]>
			  <script src="librerias/bootstrap/htmlIE/respond.min.js"></script>
			  <script src="librerias/bootstrap/htmlIE/html5.js"></script>
			  <script src="librerias/bootstrap/htmlIE/html5shiv.js"></script>
			 <script>
				 var e = ("article,aside,audio,bdi,canvas,command,datalist,details,dialog,embed,figcaption,figure,footer,header,keygen,mark,meter,nav,output,progress,rp,rt,ruby,section,source,summary,time,track,video,wbr,").split(',');
				 for (var i=0; i<e.length; i++) {document.createElement(e[i]);}
				 </script>
			 <![endif]-->
			
				
		  <!-- ICONO DE LA VENTANA DEL NAVEGADOR -->
		  <link rel="shortcut icon" href="./recursos/imagenes/urlIcon.ico">

		</head>
	<body>
	<div id="contenidos" class="container">
		<div class="well well-large">
			<img src="./recursos/imagenes/cabezote_ws.png">
		</div>
		 
		<div class="hero-unit-header" style="background-color: #289bae; color: white; text-align: center">
			<strong>SISTEMA DE INFORMACI&Oacute;N DEL SUBSIDIO DISTRITAL DE VIVIENDA</strong>
		</div>
		<!-- ESPACIO LATERAL -->
		<div class="row">
		<div class="span1">&nbsp;</div>

		<!-- Buscador -->
		<div class="span10" style="height: 4500px;"><br>
		<div class="thumbnail" style="height: 400px;">
		<div class="caption">
			<form enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
				<table cellpadding="2" cellspacing="0" border="0" width="600" >
					<tr><td colspan="2" bgcolor="#E4E4E4" class="tituloTabla" align="center"><h3>Migraci&oacute;n CEM a Desembolso</h3></td></tr>
					<tr><td><b>Seleccione el archivo:</b><br>En el archivo plano debe ir la lista de los documentos sin encabezado</td><td valign="top"><input type="file" name="fileDocumentos" class="file" /></td></tr>
					<tr><td colspan="2" align="right"><br>
						<input type="submit" value="Migrar" class="btn btn-default btn-lg btn-block"/>
						</td>
					</tr>
				</table>
			</form>
	<div style="width:600px; height:190px; overflow-y:scroll;"><!-- INICIO DIV ANUNCIOS-->		
	<?php
	$txtPrefijoRuta = "";
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	if (isset($_FILES['fileDocumentos'])) {	// inicio if 0
		if ( $_FILES['fileDocumentos']['error'] == 0 ){ // inicio if 1
			$arrDocumentos = mb_split( "\n" , file_get_contents( $_FILES['fileDocumentos']['tmp_name'] ) );
			foreach( $arrDocumentos as $numLinea => $numDocumento ){ // inicio foreach 1
				$documentox = $arrDocumentos[ $numLinea ];
				if (isset($documentox) AND ($documentox != '')) {
					$cedula = str_replace(",", "", str_replace(".", "", $documentox));
					$cedula = trim($cedula);
					$sqlForm = @mysql_query("SELECT T_FRM_FORMULARIO.seqFormulario, seqEstadoProceso FROM T_FRM_HOGAR INNER JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano) INNER JOIN T_FRM_FORMULARIO ON (T_FRM_HOGAR.seqFormulario = T_FRM_FORMULARIO.seqFormulario) WHERE numDocumento = '" . $cedula . "' AND seqTipoDocumento IN (1,2)");
					$rowForm = mysql_fetch_array($sqlForm);
				}
				// ******************************* INICIO SECCION INFORMATIVA ***********************************
				//echo "<b>Formulario: </b>[" . $rowForm['seqFormulario'] . "]<br>";
				//echo "<b>Estado Proceso: </b>[" . $rowForm['seqEstadoProceso'] . "]<br>";
				$idEstadoProceso = $rowForm['seqEstadoProceso'];
				$idFormulario = $rowForm['seqFormulario'];
				if ($idEstadoProceso == 15 || $idEstadoProceso == 62) { // inicio if 2
				// MIEMBROS DEL HOGAR
				$sqlMiembros = @mysql_query("SELECT T_FRM_HOGAR.seqCiudadano, seqParentesco, numDocumento, seqTipoDocumento, CONCAT(txtNombre1,' ',txtNombre2,' ',txtApellido1,' ',txtApellido2) AS nombre FROM T_FRM_HOGAR LEFT JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano) WHERE seqFormulario = '" . $rowForm['seqFormulario'] . "' AND seqParentesco = 1");
				while ($rowMiembros = mysql_fetch_array($sqlMiembros)) {
					//echo "<b>Postulante Principal: </b> " . utf8_decode($rowMiembros['nombre']) . " C.C. " . number_format($rowMiembros['numDocumento'], 0, ',', '.') . " [" . $rowMiembros['seqCiudadano'] . "]<br>";
				}
				// DATOS DEL DESEMBOLSO
				$sqlDesemb = @mysql_query("SELECT seqDesembolso FROM T_DES_DESEMBOLSO WHERE seqFormulario = '" . $idFormulario . "'");
				$rowDesemb = mysql_fetch_array($sqlDesemb);
				$codigoDesembolso = $rowDesemb['seqDesembolso'];
				//echo "<b>Desembolso: </b>[" . $codigoDesembolso . "]<br>";
				$codigoDesembolso = $rowDesemb['seqDesembolso'];
				// DATOS CASA EN MANO
				$sqlMaxCasaMano = @mysql_query("SELECT MAX(seqCasaMano) as maximoCEM FROM T_CEM_CASA_MANO WHERE seqFormulario = '" . $idFormulario . "'");
				$rowMaxCasaMano = mysql_fetch_array($sqlMaxCasaMano);
				$codigoCasamano = $rowMaxCasaMano['maximoCEM'];
				//echo "<b>casaMano: </b>[" . $codigoCasamano . "]<br>";

				if ($codigoCasamano == 0 || $codigoCasamano == "") {
					echo "<table><tr><td><font color='#F00'>REGISTRO NO MIGRADO [$cedula], no existe registro CEM asociado</font></td></tr></table>";
				} else {
					// ================================= CREA REGISTRO DE DESEMBOLSO EN EL CASO DE NO TENER  ====================================
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

					// ====================== MIGRANDO LOS DATOS TECNICOS Y JURIDICOS DE CASA EN MANO A CEM ========================
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

					// ============================= CONSULTANDO LOS ADJUNTOS TECNICOS Y JURIDICOS DE CASA EN MANO ============================
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
					echo "<table><tr><td><font color='#000'>REGISTRO MIGRADO [$cedula]</font></td></tr></table>";
				}
			} else {
				echo "<table><tr><td><font color='#F00'>REGISTRO NO MIGRADO [$cedula], no est&aacute; en Asignaci&oacute;n</font></td></tr></table>";
			}// fin if 2
		} // fin foreach 1
	} // fin if 1
} // fin if 0
?>
		</div><!-- FIN DIV ANUNCIOS-->
			</div>
				</div>
					<br>
					<footer>
						  <div class="well well-small">
							  <center>
								  <img src="./recursos/imagenes/pie_ws.png"><br>
								  <h6>Para visualizar mejor este sitio se recomienda el uso de Chrome, Mozilla Firefox ó Internet Explorer 10.</h6>
							  </center>
						  </div>
					</footer>
				</div>
			</div>
		</div>
		  
		<!-- INCLUSIONES JAVASCRIPT [NO MOVER DEL FINAL] -->
		<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/jquery-1.10.1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap.js"></script>        
		<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-collapse.js"></script>  
		<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-transition.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-alert.js"></script>
		<!-- <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-modal.js"></script> -->
		<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-dropdown.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-scrollspy.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-tab.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-popover.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-tooltip.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-button.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-carousel.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-typeahead.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-affix.js"></script>

		<script language="JavaScript" type="text/javascript" src="./librerias/yui/yahoo/yahoo-min.js"></script>  
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/event/event-min.js"></script>  
		<script language="JavaScript" type="text/javascript" src="./librerias/javascript/encripcion.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/javascript/autenticacion.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/javascript/ciudadano.js"></script>
		</div>
	</body>
	</html>
<?php } else { 
		echo "<table align='center'><tr><th><font color='#F00'>NO EST&Aacute; AUTORIZADO PARA INGRESAR A ESTE M&Oacute;DULO</font></th></tr></table>";
} ?>