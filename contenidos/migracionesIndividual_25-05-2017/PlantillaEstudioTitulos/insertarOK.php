<?php
$filename ="probando.xls";
header("Content-type: application/vnd.ms-excel; charset=utf-8");
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

$txtPrefijoRuta = "../../../";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include '../../../recursos/archivos/verificarSesion.php';
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<!-- Estilos CSS -->
		<!--<link href="../../../librerias/bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="../../../librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="../../../librerias/bootstrap/css/bootstrap-theme.css" rel="stylesheet">-->
	</head>
	<body>

	<div id="contenidos" class="container">
		<div class="hero-unit-header" style="background-color: #289bae; color: white; text-align: center">
			Modulo Plantilla Estudio de T&iacute;tulos (En Construcci&oacute;n)
		</div>

		<div class="well">
			<?php
			function doc2form( $numDocumento ){ // Recibe el documento y devuelve el formulario asociado
				global $db;
				if( intval( $numDocumento ) != 0 ){ // Documento es diferente de 0
					if( intval( $numDocumento ) != '' ){ // Documento es diferente de vacío
						$sql = "SELECT frm.seqFormulario
								FROM T_FRM_FORMULARIO frm
								INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
								INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
								WHERE ciu.numDocumento = $numDocumento
								AND hog.seqParentesco = 1";
						$exeSql = mysql_query( $sql );
						$rowSql = mysql_fetch_array($exeSql);
						return $rowSql['seqFormulario'];
					}
				} else {
					return 0;
				}
			}
			
			$error = "";
			$archivo = $_FILES["archivo"];

			if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
				$nombreArchivo = $_FILES['archivo']['tmp_name'];
				$lineas = file($nombreArchivo);
				$registros = 0;
				
				// Recorre las líneas del archivo
				foreach ($lineas as $linea_num => $linea) {
					$datos = explode("\t", $linea);
					$formularioActual = doc2form(str_replace(",", "", str_replace(".", "", trim($datos [0])))); // Quita los puntos y comas del documento

					if ($formularioActual == '' || $formularioActual == 0){ // Si el documento no tiene un formulario, concatena para mostrar el error
						$documentosSinFormulario .= trim($datos [0]) . ", ";
					} else { // Concatena los números de formulario
						$listaFormularios .= $formularioActual . ", ";
					}
					$registros++;
				}

				$documentosSinFormulario = substr($documentosSinFormulario, 0, -2); // Documentos sin formulario (Quita última coma)
				$listaFormularios = substr($listaFormularios, 0, -2); // Documentos con formulario asociado (Quita última coma)

				//$consulta = "SELECT * FROM T_FRM_ESTADO_PROCESO INNER JOIN T_FRM_ETAPA ON (T_FRM_ESTADO_PROCESO.seqEtapa = T_FRM_ETAPA.seqEtapa)";
				$consulta = "SELECT T_DES_ESCRITURACION.seqFormulario AS 'HOGAR', 
								T_CIU_CIUDADANO.numDocumento AS 'CC POSTULANTE PRINCIPAL', 
								T_CIU_TIPO_DOCUMENTO.txtTipoDocumento AS 'TIPO DE DOCUMENTO', 
								UPPER(CONCAT(T_CIU_CIUDADANO.txtNombre1, ' ', T_CIU_CIUDADANO.txtNombre2, ' ', T_CIU_CIUDADANO.txtApellido1, ' ', T_CIU_CIUDADANO.txtApellido2)) AS 'NOMBRE POSTULANTE PRINCIPAL', 
								T_PRY_PROYECTO.txtNombreProyecto AS 'PROYECTO', 
								T_DES_ESCRITURACION.txtNombreVendedor AS 'PROPIETARIO', 
								T_FRM_FORMULARIO.seqUnidadProyecto AS 'seqUnidadProyecto', 
								T_PRY_UNIDAD_PROYECTO.txtNombreUnidad AS 'txtnombreunidad', 
								T_DES_ESCRITURACION.txtDireccionInmueble AS 'DIRECCION INMUEBLE', 
								T_PRY_TECNICO.txtexistencia AS 'CERTIFICADO DE EXISTENCIA Y HABITABILIDAD', 
								T_DES_ESCRITURACION.txtEscritura AS 'ESCRITURA REGISTRADA', 
								T_DES_ESCRITURACION.fchEscritura AS 'FECHA ESCRITURA', 
								T_DES_ESCRITURACION.numNotaria AS 'NOTARIA', 
								T_DES_ESCRITURACION.txtCiudad AS 'CIUDAD NOTARIA', 
								T_DES_ESCRITURACION.txtMatriculaInmobiliaria AS 'FOLIO DE MATRICULA', 
								T_DES_ESCRITURACION.numValorInmueble AS 'VALOR INMUEBLE', 
								T_AAD_HOGARES_VINCULADOS.numActo AS 'NUMERO DEL ACTO', 
								DATE_FORMAT(t_aad_hogares_vinculados.fchacto,'%d-%m-%Y') AS 'FECHA DEL ACTO', 
								'' AS 'No. ESCRITURA', 
								'' AS 'FECHA ESCRITURA (D/M/A)', 
								'' AS 'NOTARIA', 
								'' AS 'CIUDAD NOTARIA', 
								'' AS 'FOLIO DE MATRICULA', 
								'' AS 'ZONA OFICINA REGISTRO', 
								'' AS 'CIUDAD OFICINA REGISTRO', 
								'' AS 'FECHA FOLIO (D/M/A)', 
								'' AS 'RESOLUCION DE VINCULACION COINCIDENTE', 
								'' AS 'BENEFICIARIOS DEL SDV COINCIDENTES', 
								'' AS 'NOMBRE Y CEDULA DE LOS PROPIETARIOS EN EL CTL INCIDENTES', 
								'' AS 'CONSTITUCION PATRIMONIO FAMILIA', 
								'' AS 'INDAGACION AFECTACION A VIVIENDA FAMILIAR', 
								'' AS 'RESTRICCIONES', 
								'' AS 'ESTADO CIVIL COINCIDENTE', 
								'' AS 'CARTA DE VINCULACION Y/O RESOLUCION PROTOCOLIZADA', 
								'' AS 'No. DE ANOTACION CTL COMPRAVENTA', 
								'' AS 'SE CANCELA HIPOTECA MAYOR EXTENSION (SI LA HUBIERE)', 
								'' AS 'PATRIMONIO DE FAMILIA REGISTRADO', 
								'' AS 'PROHIBICION DE TRANSFERENCIA Y DERECHO DE PREFERENCIA REGISTRADOS', 
								'' AS 'IMPRESION DE CONSULTA FONVIVIENDA (HOGARES VICTIMAS)', 
								'' AS 'ELABORO', 
								'' AS 'APROBO', 
								'' AS 'SE VIABILIZA JURIDICAMENTE', 
								'' AS 'OBSERVACION'
						FROM T_DES_ESCRITURACION
						INNER JOIN T_FRM_FORMULARIO ON (T_DES_ESCRITURACION.seqFormulario = T_FRM_FORMULARIO.seqFormulario)
						INNER JOIN T_FRM_HOGAR ON (T_FRM_FORMULARIO.seqFormulario = T_FRM_HOGAR.seqFormulario)
						INNER JOIN T_CIU_CIUDADANO ON (T_CIU_CIUDADANO.seqCiudadano = T_FRM_HOGAR.seqCiudadano)
						INNER JOIN T_CIU_TIPO_DOCUMENTO ON (T_CIU_CIUDADANO.seqTipoDocumento = T_CIU_TIPO_DOCUMENTO.seqTipoDocumento)
						INNER JOIN T_PRY_UNIDAD_PROYECTO ON (T_FRM_FORMULARIO.seqFormulario = T_PRY_UNIDAD_PROYECTO.seqFormulario)
						INNER JOIN T_PRY_PROYECTO ON (T_PRY_PROYECTO.seqProyecto = T_PRY_UNIDAD_PROYECTO.seqProyecto)
						INNER JOIN T_PRY_TECNICO ON (T_FRM_FORMULARIO.seqUnidadProyecto = T_PRY_TECNICO.seqUnidadProyecto)
						INNER JOIN T_AAD_FORMULARIO_ACTO ON (T_FRM_FORMULARIO.seqFormulario = T_AAD_FORMULARIO_ACTO.seqFormulario)
						INNER JOIN T_AAD_HOGARES_VINCULADOS ON (T_AAD_FORMULARIO_ACTO.seqFormularioActo = T_AAD_HOGARES_VINCULADOS.seqFormularioActo)
						INNER JOIN (SELECT MAX(ah.fchActo), ah.numActo
									FROM T_AAD_HOGARES_VINCULADOS ah
									LEFT JOIN t_aad_formulario_acto tafa ON(tafa.seqFormularioActo = ah.seqFormularioActo)
									GROUP BY numActo
									ORDER BY ah.fchActo DESC) AS T_AAD_HOGARES_VINCULADOS1 USING (numActo)
						WHERE T_FRM_HOGAR.seqParentesco = 1 
						AND T_DES_ESCRITURACION.seqFormulario IN ($listaFormularios) 
						GROUP BY T_DES_ESCRITURACION.seqFormulario";
				if ($documentosSinFormulario != ''){ // Documentos que no tienen un formulario asociado
					$error .= "<p class='alert alert-danger'>No se pudo exportar la plantilla, los siguientes documentos no tienen un formulario asociado: <strong>" . $documentosSinFormulario . "</strong>.</p>";
				}

				// Ejecuta la consulta o muestra el error según el caso
				if ($error == '') {
					print_r ("<table width='50%' align='center' cellpadding=0 cellspacing=0 border=0>");
					print_r ("<tr><td>HOGAR</td><td>CC POSTULANTE PRINCIPAL</td><td>TIPO DE DOCUMENTO</td><td>NOMBRE POSTULANTE PRINCIPAL</td><td>PROYECTO</td><td>PROPIETARIO</td><td>seqUnidadProyecto</td><td>txtnombreunidad</td><td>DIRECCION INMUEBLE</td><td>CERTIFICADO DE EXISTENCIA Y HABITABILIDAD</td><td>ESCRITURA REGISTRADA</td><td>FECHA ESCRITURA</td><td>NOTARIA</td><td>CIUDAD NOTARIA</td><td>FOLIO DE MATRICULA</td><td>VALOR INMUEBLE</td><td>NUMERO DEL ACTO</td><td>FECHA DEL ACTO</td><td>No. ESCRITURA</td><td>FECHA ESCRITURA (D/M/A)</td><td>NOTARIA</td><td>CIUDAD NOTARIA</td><td>FOLIO DE MATRICULA</td><td>ZONA OFICINA REGISTRO</td><td>CIUDAD OFICINA REGISTRO</td><td>FECHA FOLIO (D/M/A)</td><td>RESOLUCION DE VINCULACION COINCIDENTE</td><td>BENEFICIARIOS DEL SDV COINCIDENTES</td><td>NOMBRE Y CEDULA DE LOS PROPIETARIOS EN EL CTL INCIDENTES</td><td>CONSTITUCION PATRIMONIO FAMILIA</td><td>INDAGACION AFECTACION A VIVIENDA FAMILIAR</td><td>RESTRICCIONES</td><td>ESTADO CIVIL COINCIDENTE</td><td>CARTA DE VINCULACION Y/O RESOLUCION PROTOCOLIZADA</td><td>No. DE ANOTACION CTL COMPRAVENTA</td><td>SE CANCELA HIPOTECA MAYOR EXTENSION (SI LA HUBIERE)</td><td>PATRIMONIO DE FAMILIA REGISTRADO</td><td>PROHIBICION DE TRANSFERENCIA Y DERECHO DE PREFERENCIA REGISTRADOS</td><td>IMPRESION DE CONSULTA FONVIVIENDA (HOGARES VICTIMAS)</td><td>ELABORO</td><td>APROBO</td><td>SE VIABILIZA JURIDICAMENTE</td><td>OBSERVACION</td></tr>");
					$exeConsulta = mysql_query($consulta);
					while ($rowDatos = mysql_fetch_array($exeConsulta)) {
						print_r ("<tr>");
						print_r ("td>".$rowDatos['seqFormulario']."</td>");
						print_r ("td>".$rowDatos['numDocumento']."</td>");
						print_r ("</tr>");
					}
					//echo "<br><p class='alert alert-success'>Los $registros registros se exportarán</p>";
				} else {
					echo $error;
				}
			} else {
				echo "<p class='alert alert-danger'>Error en la carga del archivo</p>";
			}
			?>
			<p align="center"><a href="javascript:history.back(1)" class="btn btn-primary" role="button">Volver</a></p>
		</div>
	</div> <!-- /container -->

</body>
</html>