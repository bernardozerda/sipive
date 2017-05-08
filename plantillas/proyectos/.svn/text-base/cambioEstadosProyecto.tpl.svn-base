

	<form id="frmCambioEstados">

		{include file='proyectos/pedirSeguimiento.tpl'}
		<br>
		<table cellspacing="0" cellpadding="2" border="0" width="100%">
			<tr>
				<td colspan="2"></td>
				<td rowspan="4" width="300px" align="center" valign="top"
					style="padding-top:5px; border-left: 1px dotted #999999; border-right: 1px dotted #999999; border-bottom: 1px dotted #999999"
				>
					<table cellpadding="0" cellspacing="2" border="0" width="99%" align="justify">
						<tr><td style="padding-top: 10px"><b>Para el cambio de estado individual</b></td></tr>
						<tr><td style="padding-left: 15px">
							<li>Puede buscar el Proyecto por el nombre</li>
						</td></tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="tituloTabla" height="20px">
					Cambio de estado individual
				</td>
			</tr>

			<!-- SOLO PARA UNA CEDULA -->
			<tr>
				<td colspan="2" style="border-bottom: 1px dotted #999999; border-left: 1px dotted #999999;" valign="top">
					<table cellspacing="" cellpadding="0" border="0" width="100%">
						<tr>
							<td class="tituloCampo" width="200px">
								Buscar por nombre del proyecto:
							</td>
							<td height="17px" valign="top">
								<div id="buscarNombreProyecto">
									<input type="hidden" id="myHidden" name="myHidden">
									<input	id="nombre" 
											name="nombre" 
											type="text" 
											style="width:233px" 
											onFocus="this.style.backgroundColor = '#ADD8E6'; " 
											onBlur="this.style.backgroundColor = '#FFFFFF';" 
									/>
									<div id="contenedor"></div>
								</div>
							</td>
						</tr>
						<tr>
							<td class="tituloCampo">
								Estado del Proceso
							</td>
							<td>
								<select name="seqPryEstadoProceso" style="width:310px">
									<option value="0">Seleccione un estado</option>
									{foreach from=$arrPryEstados key=seqEstado item=txtEstado}
									<option value="{$seqEstado}">{$txtEstado}</option>
									{/foreach} 
								</select>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<!-- BOTON -->
			<tr>
				<td colspan="2" height="25px" align="right" style="padding-right:20px;" bgcolor="#F9F9F9">
						<input type="button" 
								value="Cambiar Estados" 
								onClick="someterFormulario( 
										'mensajes', 
										this.form, 
										'./contenidos/proyectos/cambioEstadosProyectoSalvar.php', 
										true, 
										true
									); 
								"
						/>
				</td>
			</tr>
		</table>
	</form>

	<div id="listenerBuscarNombreProyecto"></div>
	<!--<div id="cambioEstadosPosibles" style="display:none">
		<div class="hd">Listado de Estados Validos</div>
		<div class="bd">
			<center>
				<table cellpadding="2" cellspacing="0" border="0" width="90%">
					<tr>
						<td class="tituloTabla">ID</td>
						<td class="tituloTabla">Descripción</td>
					</tr>
					{foreach from=$arrEstados key=seqEstado item=txtEstado}
						<tr><td width="30px" bgcolor="{cycle name=c1 values="#FFFFFF,#E4E4E4"}">{$seqEstado}</td>
							<td bgcolor="{cycle name=c2 values="#FFFFFF,#E4E4E4"}">{$txtEstado}</td>
						</tr>
					{/foreach}
				</table>
			</center>
		</div>
	</div>-->