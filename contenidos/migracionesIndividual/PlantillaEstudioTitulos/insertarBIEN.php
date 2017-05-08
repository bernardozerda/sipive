<?php
$filename ="PlantillaEstudioTitulos.xls";
header("Content-type: application/vnd.ms-excel; charset=utf-8");
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
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
		<!--<div class="hero-unit-header" style="background-color: #289bae; color: white; text-align: center">
			Modulo Plantilla Estudio de T&iacute;tulos (En Construcci&oacute;n)
		</div>-->

		<div class="well">
			<?php
			include_once "../lib/mysqli/shared/ez_sql_core.php";
			include_once "../lib/mysqli/ez_sql_mysqli.php";

			function doc2form( $numDocumento ){ // Recibe el documento y devuelve el formulario asociado
				global $db;
				if( intval( $numDocumento ) != 0 ){ // Documento es diferente de 0
					if( intval( $numDocumento ) != '' ){ // Documento es diferente de vacío
						$query = $db->get_row("SELECT frm.seqFormulario
												FROM T_FRM_FORMULARIO frm
												INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
												INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
												WHERE ciu.numDocumento = $numDocumento
												AND seqParentesco = 1");
						return $query->seqFormulario;
					}
				} else {
					return 0;
				}
			}
			
			//$db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sipive', 'localhost');
			$db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sipive_feb10', 'localhost');

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
								T_CIU_CIUDADANO.numDocumento AS 'CC_POSTULANTE_PRINCIPAL', 
								T_CIU_TIPO_DOCUMENTO.txtTipoDocumento AS 'TIPO_DE_DOCUMENTO', 
								UPPER(CONCAT(T_CIU_CIUDADANO.txtNombre1, ' ', T_CIU_CIUDADANO.txtNombre2, ' ', T_CIU_CIUDADANO.txtApellido1, ' ', T_CIU_CIUDADANO.txtApellido2)) AS 'NOMBRE_POSTULANTE_PRINCIPAL', 
								T_PRY_PROYECTO.txtNombreProyecto AS 'PROYECTO', 
								T_DES_ESCRITURACION.txtNombreVendedor AS 'PROPIETARIO', 
								T_FRM_FORMULARIO.seqUnidadProyecto AS 'seqUnidadProyecto', 
								T_PRY_UNIDAD_PROYECTO.txtNombreUnidad AS 'txtnombreunidad', 
								T_DES_ESCRITURACION.txtDireccionInmueble AS 'DIRECCION_INMUEBLE', 
								T_PRY_TECNICO.txtexistencia AS 'CERTIFICADO_DE_EXISTENCIA_Y_HABITABILIDAD', 
								T_DES_ESCRITURACION.txtEscritura AS 'ESCRITURA_REGISTRADA', 
								T_DES_ESCRITURACION.fchEscritura AS 'FECHA_ESCRITURA', 
								T_DES_ESCRITURACION.numNotaria AS 'NOTARIA', 
								T_DES_ESCRITURACION.txtCiudad AS 'CIUDAD_NOTARIA', 
								T_DES_ESCRITURACION.txtMatriculaInmobiliaria AS 'FOLIO_DE_MATRICULA', 
								T_DES_ESCRITURACION.numValorInmueble AS 'VALOR_INMUEBLE', 
								T_AAD_HOGARES_VINCULADOS.numActo AS 'NUMERO_DEL_ACTO', 
								DATE_FORMAT(t_aad_hogares_vinculados.fchacto,'%d-%m-%Y') AS 'FECHA_DEL_ACTO', 
								'' AS 'No_ESCRITURA', 
								'' AS 'FECHA_ESCRITURA', 
								'' AS 'NOTARIA', 
								'' AS 'CIUDAD_NOTARIA', 
								'' AS 'FOLIO_DE_MATRICULA', 
								'' AS 'ZONA_OFICINA_REGISTRO', 
								'' AS 'CIUDAD_OFICINA_REGISTRO', 
								'' AS 'FECHA_FOLIO', 
								'' AS 'RESOLUCION_DE_VINCULACION_COINCIDENTE', 
								'' AS 'BENEFICIARIOS_DEL_SDV_COINCIDENTES', 
								'' AS 'NOMBRE_Y_CEDULA_PROPIETARIOS_CTL_INCIDENTES', 
								'' AS 'CONSTITUCION_PATRIMONIO_FAMILIA', 
								'' AS 'INDAGACION_AFECTACION_A_VIVIENDA_FAMILIAR', 
								'' AS 'RESTRICCIONES', 
								'' AS 'ESTADO_CIVIL_COINCIDENTE', 
								'' AS 'CARTA_DE_VINCULACION_RESOLUCION_PROTOCOLIZADA', 
								'' AS 'No_DE_ANOTACION_CTL_COMPRAVENTA', 
								'' AS 'SE_CANCELA_HIPOTECA_MAYOR_EXTENSION', 
								'' AS 'PATRIMONIO_DE_FAMILIA_REGISTRADO', 
								'' AS 'PROHIBICION_DE_TRANSFERENCIA_Y_DERECHO_DE_PREFERENCIA_REGISTRADOS', 
								'' AS 'IMPRESION_DE_CONSULTA_FONVIVIENDA', 
								'' AS 'ELABORO', 
								'' AS 'APROBO', 
								'' AS 'SE_VIABILIZA_JURIDICAMENTE', 
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
				//echo $consulta;die();
				if ($documentosSinFormulario != ''){ // Documentos que no tienen un formulario asociado
					$error .= "<p class='alert alert-danger'>No se pudo exportar la plantilla, los siguientes documentos no tienen un formulario asociado: <strong>" . $documentosSinFormulario . "</strong>.</p>";
				}

				// Ejecuta la consulta o muestra el error según el caso
				if ($error == '') {
					print_r ("<table border='1' align='center' cellpadding=0 cellspacing=0>");
					print_r ("<tr><td>HOGAR</td><td>CC POSTULANTE PRINCIPAL</td><td>TIPO DE DOCUMENTO</td><td>NOMBRE POSTULANTE PRINCIPAL</td><td>PROYECTO</td><td>PROPIETARIO</td><td>seqUnidadProyecto</td><td>txtnombreunidad</td><td>DIRECCION INMUEBLE</td><td>CERTIFICADO DE EXISTENCIA Y HABITABILIDAD</td><td>ESCRITURA REGISTRADA</td><td>FECHA ESCRITURA</td><td>NOTARIA</td><td>CIUDAD NOTARIA</td><td>FOLIO DE MATRICULA</td><td>VALOR INMUEBLE</td><td>NUMERO DEL ACTO</td><td>FECHA DEL ACTO</td><td>No. ESCRITURA</td><td>FECHA ESCRITURA (D/M/A)</td><td>NOTARIA</td><td>CIUDAD NOTARIA</td><td>FOLIO DE MATRICULA</td><td>ZONA OFICINA REGISTRO</td><td>CIUDAD OFICINA REGISTRO</td><td>FECHA FOLIO (D/M/A)</td><td>RESOLUCION DE VINCULACION COINCIDENTE</td><td>BENEFICIARIOS DEL SDV COINCIDENTES</td><td>NOMBRE Y CEDULA DE LOS PROPIETARIOS EN EL CTL INCIDENTES</td><td>CONSTITUCION PATRIMONIO FAMILIA</td><td>INDAGACION AFECTACION A VIVIENDA FAMILIAR</td><td>RESTRICCIONES</td><td>ESTADO CIVIL COINCIDENTE</td><td>CARTA DE VINCULACION Y/O RESOLUCION PROTOCOLIZADA</td><td>No. DE ANOTACION CTL COMPRAVENTA</td><td>SE CANCELA HIPOTECA MAYOR EXTENSION (SI LA HUBIERE)</td><td>PATRIMONIO DE FAMILIA REGISTRADO</td><td>PROHIBICION DE TRANSFERENCIA Y DERECHO DE PREFERENCIA REGISTRADOS</td><td>IMPRESION DE CONSULTA FONVIVIENDA (HOGARES VICTIMAS)</td><td>ELABORO</td><td>APROBO</td><td>SE VIABILIZA JURIDICAMENTE</td><td>OBSERVACION</td></tr>");
					$plantilla = $db->get_results($consulta);
					foreach ( $plantilla AS $datosPlantilla ){
						print_r ("<tr>");
						print_r ("<td>" . $datosPlantilla->HOGAR . "</td>");
						print_r ("<td>" . $datosPlantilla->CC_POSTULANTE_PRINCIPAL . "</td>");
						print_r ("<td>" . $datosPlantilla->TIPO_DE_DOCUMENTO . "</td>");
						print_r ("<td>" . $datosPlantilla->NOMBRE_POSTULANTE_PRINCIPAL . "</td>");
						print_r ("<td>" . $datosPlantilla->PROYECTO . "</td>");
						print_r ("<td>" . $datosPlantilla->PROPIETARIO . "</td>");
						print_r ("<td>" . $datosPlantilla->seqUnidadProyecto . "</td>");
						print_r ("<td>" . $datosPlantilla->txtnombreunidad . "</td>");
						print_r ("<td>" . $datosPlantilla->DIRECCION_INMUEBLE . "</td>");
						print_r ("<td>" . $datosPlantilla->CERTIFICADO_DE_EXISTENCIA_Y_HABITABILIDAD . "</td>");
						print_r ("<td>" . $datosPlantilla->ESCRITURA_REGISTRADA . "</td>");
						print_r ("<td>" . $datosPlantilla->FECHA_ESCRITURA . "</td>");
						print_r ("<td>" . $datosPlantilla->NOTARIA . "</td>");
						print_r ("<td>" . $datosPlantilla->CIUDAD_NOTARIA . "</td>");
						print_r ("<td>" . $datosPlantilla->FOLIO_DE_MATRICULA . "</td>");
						print_r ("<td>" . $datosPlantilla->VALOR_INMUEBLE . "</td>");
						print_r ("<td>" . $datosPlantilla->NUMERO_DEL_ACTO . "</td>");
						print_r ("<td>" . $datosPlantilla->FECHA_DEL_ACTO . "</td>");
						print_r ("<td>" . $datosPlantilla->No_ESCRITURA . "</td>");
						print_r ("<td>" . $datosPlantilla->FECHA_ESCRITURA . "</td>");
						print_r ("<td>" . $datosPlantilla->NOTARIA . "</td>");
						print_r ("<td>" . $datosPlantilla->CIUDAD_NOTARIA . "</td>");
						print_r ("<td>" . $datosPlantilla->FOLIO_DE_MATRICULA . "</td>");
						print_r ("<td>" . $datosPlantilla->ZONA_OFICINA_REGISTRO . "</td>");
						print_r ("<td>" . $datosPlantilla->CIUDAD_OFICINA_REGISTRO . "</td>");
						print_r ("<td>" . $datosPlantilla->FECHA_FOLIO . "</td>");
						print_r ("<td>" . $datosPlantilla->RESOLUCION_DE_VINCULACION_COINCIDENTE . "</td>");
						print_r ("<td>" . $datosPlantilla->BENEFICIARIOS_DEL_SDV_COINCIDENTES . "</td>");
						print_r ("<td>" . $datosPlantilla->NOMBRE_Y_CEDULA_PROPIETARIOS_CTL_INCIDENTES . "</td>");
						print_r ("<td>" . $datosPlantilla->CONSTITUCION_PATRIMONIO_FAMILIA . "</td>");
						print_r ("<td>" . $datosPlantilla->INDAGACION_AFECTACION_A_VIVIENDA_FAMILIAR . "</td>");
						print_r ("<td>" . $datosPlantilla->RESTRICCIONES . "</td>");
						print_r ("<td>" . $datosPlantilla->ESTADO_CIVIL_COINCIDENTE . "</td>");
						print_r ("<td>" . $datosPlantilla->CARTA_DE_VINCULACION_RESOLUCION_PROTOCOLIZADA . "</td>");
						print_r ("<td>" . $datosPlantilla->No_DE_ANOTACION_CTL_COMPRAVENTA . "</td>");
						print_r ("<td>" . $datosPlantilla->SE_CANCELA_HIPOTECA_MAYOR_EXTENSION . "</td>");
						print_r ("<td>" . $datosPlantilla->PATRIMONIO_DE_FAMILIA_REGISTRADO . "</td>");
						print_r ("<td>" . $datosPlantilla->PROHIBICION_DE_TRANSFERENCIA_Y_DERECHO_DE_PREFERENCIA_REGISTRADOS . "</td>");
						print_r ("<td>" . $datosPlantilla->IMPRESION_DE_CONSULTA_FONVIVIENDA . "</td>");
						print_r ("<td>" . $datosPlantilla->ELABORO . "</td>");
						print_r ("<td>" . $datosPlantilla->APROBO . "</td>");
						print_r ("<td>" . $datosPlantilla->SE_VIABILIZA_JURIDICAMENTE . "</td>");
						print_r ("<td>" . $datosPlantilla->OBSERVACION . "</td>");
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
			<!--<p align="center"><a href="javascript:history.back(1)" class="btn btn-primary" role="button">Volver</a></p>-->
		</div>
	</div> <!-- /container -->

</body>
</html>