
	<!-- TABLA PARA EXPORTAR LOS REGISTRO DEL BANCO DE VIVIENDA -->
	<form id="frmExportarBVU">
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td width="200px" class="tituloTabla">
				Obtenga un listado de las viviendas registradas en el banco de vivienda
			</td>
			<td align="center" valign="top">
				<table cellspacing="1" cellpadding="2" border="0" width="100%">
					<tr>
						<td width="120px"><b>Estados del proceso</b></td>
						<td width="200px">
							<select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
									onBlur="this.style.backgroundColor = '#FFFFFF';" 
									name="seqEstadoProceso"
									id="seqEstadoProceso" 
									style="width:180px;"
							><option value="0">Todos los estados</option>
							{foreach from=$claGenerales->arrEstadoProceso key=seqEstadoProceso item=txtEstadoProceso}
								<option value="{$seqEstadoProceso}">{$txtEstadoProceso}</option>
							{/foreach}
							</select>
						</td>
						<td rowspan="4" align="center" valign="middle" class="tituloTabla">
						
							<a href="#" onClick="someterFormulario( 
									'mensajes' , 
									'frmExportarBVU', 
									'./contenidos/bancoVivienda/previabilizacion/exportarRegistros.php' , 
									true , 
									false 
								);"
							>Obtener Registros</a>
							
						</td>
					</tr>
					<tr>
						<td rowspan="2"><b>Fecha de Registro</b></td>
						<td>
							<div style="float:left; width:40px">Desde</div>
							<div style="float:left;">
								<input	type="text" 
										id="fchCreacionDesde"
										name="fchCreacionDesde"
										onFocus="this.style.backgroundColor = '#ADD8E6';" 
										onBlur="this.style.backgroundColor = '#FFFFFF'; "
										style="width:80px" 
										value=""
										readonly
								/> <a onClick="calendarioPopUp('fchCreacionDesde')" href="#">Calendario</a>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div style="float:left; width:40px">Hasta</div>
							<div style="float:left;">
								<input	type="text" 
										id="fchCreacionHasta"
										name="fchCreacionHasta"
										onFocus="this.style.backgroundColor = '#ADD8E6';" 
										onBlur="this.style.backgroundColor = '#FFFFFF'; "
										style="width:80px" 
										value=""
										readonly
								/> <a onClick="calendarioPopUp('fchCreacionHasta')" href="#">Calendario</a>
							</div>
						</td>
					</tr>
					<tr>
						<td><b>Incluir viviendas que no cumplen las condiciones básicas</b></td>
						<td>
							<input type="checkbox"
								   name="condiciones"
							/>
						</d>
					</tr>
				</table> 
			</td>
		</tr>
	</table>
	</form>
	
	<!-- TABLA PARA CARGAR LOS REGISTROS PREVIABILIZADOS -->
	<form id="frmPreviabilizarBVU">
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td width="200px" class="tituloTabla" height="80px">
				<p>Cargue un archivo con las viviendas
				y el resultado de la previabilizacion.</p>
				<p><a href="#" onClick="plantillaPreviabilizacion()">Vea las columnas del archivo aqui</a></p>
			</td>
			<td align="center" valign="middle" width="333px">
				<input type="file"
					   name="archivo"
				/>
			</td>
			<td align="center" valign="middle" class="tituloTabla">
				<a href="#" onClick="someterFormulario( 'mensajes' , 'frmPreviabilizarBVU' , './contenidos/bancoVivienda/previabilizacion/salvarPreviabilizacion.php' , true , true );">
					Cargar Archivo
				</a>
			</td>
		</tr>
	</table>
	</form>	

	<div style="text-align: center; width:30%; float: left; " class="menuLateralOver">
		<b>Visitas a la Pagina: </b> {$numVisitasInicio|number_format:0:',':'.'}
	</div>
	<div style="text-align: center; width:35%; float: left; " class="menuLateralOver">
		<b>Búsquedas Realizadas:</b> {$numVisitasBusqueda|number_format:0:',':'.'}
	</div>
	<div style="text-align: center; width:30%; float: right; " class="menuLateralOver">
		<b>Personas Interesadas en Viviendas: </b> {$numInteresados|number_format:0:',':'.'}
	</div>
	
	
	
	
	