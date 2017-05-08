
	<!--
		FILTROS PARA LAS CONSULTAS 
		DEL FONDO NACIONAL DEL AHORRO
	-->
	<form id="frmFna" onSubmit="return false;">
	
		<table cellpadding="2" cellspacing="0" border="0" width="100%">
			<tr>
				<td colspan="4" align="justify" style="padding-left:20px; padding-right:20px;" class="tituloCampo">
					<p>Bienvenido: Aquí podrá consultar la informacion de los hogares que están registrados
					dentro del programa de Subsidio Distrital de Vivienda.</p>
					<p>La información que podrá consultar aqui se limita a los hogares que han reportado
					tener alguna relacion financiera con el Fondo Nacional del Ahorro.  Además podrá conocer
					el estado del proceso de estos hogares, uno a uno o por lotes de cedulas, consulte
					el link de ayuda para mas información acerca de este reporte.</p>
				</td>
			</tr>
			<tr><td height="10px"></td></tr>
			<tr>
				<td class="tituloTabla" width="170px">
					Documento de Identidad
				</td>
				<td width="200px">
					<input	type="text" 
							name="numDocumento" 
							onFocus="this.style.backgroundColor = '#ADD8E6';" 
							onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';" 
							style="width:170px;" 
					/>
				</td>
				<td class="tituloTabla" width="170px">
					Etapas del proceso
				</td>
				<td width="200px">
					<select name="seqEtapa"
							onFocus="this.style.backgroundColor = '#ADD8E6';" 
							onBlur="this.style.backgroundColor = '#FFFFFF';" 
							style="width:150px;"
					>
						<option value="0">Todas las etapas</option>
						<!-- <option value="1">Inscripción</option> -->
						<option value="2">Postulación</option>
						<option value="4">Asignación</option>
						<option value="5">Desembolso</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="tituloTabla">
					Lote de documentos
				</td>
				<td>
					<input type="file"
						   name="documentos"
						   onFocus="this.style.backgroundColor = '#ADD8E6';" 
						   onBlur="this.style.backgroundColor = '#FFFFFF';"
					/>
				</td>
				<td class="tituloTabla">
					&nbsp;
				</td>
				<td align="center">
					<a href="#" onClick="popUpAyuda( '{$txtTitulo}' , '{$txtContenido}' );">Ayuda</a>
				</td>
			</tr>
			<tr><td height="10px"></td></tr>
			<tr>
				<td colspan="4" align="center">
					<input type="button"
						   value="Obtener Registros"
						   onClick="someterFormulario( 'reporteFna', this.form, './contenidos/fna/consultas/mostrarConsulta.php', true, true);"
					/>
				</td>
			</tr>
		</table>
	</form>
		
	<div id="reporteFna"></div>

