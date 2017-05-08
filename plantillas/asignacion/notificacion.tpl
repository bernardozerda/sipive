
	<table cellspacing="0" cellpadding="0" border="0" width="99%">

		<tr>
			<td valign="top" width="300px" >
				<table cellpadding="1" cellspacing="0" border="0" width="100%">
					<tr>
						<td class="tituloTabla">
							Listado de Notificaciones
						</td>
					</tr>
				</table>
			</td>
			<td rowspan="2" style="border-left: 1px dotted #999999;" valign="top">
				<form id="frmNotificacion" >
				<table cellspacing="0" cellpadding="0" border="0" width="99%">
					<tr>
						<td colspan="2" valign="top" align="left" class="tituloTabla">
							Formulario Notificacion 
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<table cellpadding="1" cellspacing="0" border="0" width="99%">
								<tr>
									<td valign="top" width="180px">Número Notificación</td>
									<td valign="top" align="left">
										<input  type="text"
												name="numNotificacion"
												value=""
												onFocus="this.style.backgroundColor = '#ADD8E6';" 
											   	onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros( this );"
										/> 
									</td>
								</tr>
								<tr>
									<td valign="top" width="180px">Fecha Notificación</td>
									<td valign="top" align="left">
										<input name="fchNotificacion" 
											   id="fchNotificacion"
											   value="" 
											   onFocus="this.style.backgroundColor = '#ADD8E6';" 
											   onBlur="this.style.backgroundColor = '#FFFFFF';"
											   readonly 
										/> <a href="#" onClick="javascript: calendarioPopUp( 'fchNotificacion'); ">Calendario</a> 										
									</td>
								</tr>
								<tr>
									<td valign="top" width="180px">
										Tipo de Acto
									</td>
									<td valign="top" align="left">
										<select	id="seqTipoActo" 
												name="seqTipoActo" 
												style="width:220px"
												onFocus="this.style.backgroundColor = '#ADD8E6';" 
												onBlur="this.style.backgroundColor = '#FFFFFF';" }
												onChange="filtarActosAdministrativosNotificacion( );"
										>
											<option value="0">Todos los Actos</option>
											{foreach from=$claTipoActo->arrTipoActos key=seqTipoActo item=txtTipoActo}
												<option value="{$seqTipoActo}">{$txtTipoActo}</option>
											{/foreach}
										</select>
									</td>
								</tr>
								
								<tr >
									<td valign="top" width="180px">Listado Actos Administrativos</td>
									<td valign="top" align="left" id="listadoActosAdministrativos" >
										<!-- <input style="background: #ADD8E6;" 
											   readonly 
										/> -->
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td id="caracteristicasActos" colspan="2" align="center">
							{include file="asignacion/caracteristicasActos.tpl"}
						</td>
					</tr>
					<tr>
						<td valign="top" width="180px">Hogares Vinculados</td>
						<td valign="top" align="left">
							<input type="file"
								   name="hogares"
								   onFocus="this.style.backgroundColor = '#ADD8E6';" 
								   onBlur="this.style.backgroundColor = '#FFFFFF';"
							/>
						</td>
					</tr>
					<tr>
						<td></td>
						<td valign="top" align="left" style="padding:6px;"><a href="#" onClick="plantillaActoAdministrativo( '7' )">Ver Plantilla</a></td>
					</tr>
					<tr>
						<td align="right" valign="top" colspan="2" height="25px">
								<input 	type="button" 
										id="botonCrearNotificacion" 
										value="Crear Notificacion" 
										onClick="
											someterFormulario( 
												'mensajes',
												'frmNotificacion',
												'./contenidos/asignacion/salvarNotificacion.php',
												true,
												true 
											);
										" 
								/>
						</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
		
		<tr>
			<td height="300px" style="overflow:auto;" valign="top">
				<table cellspacing="0" cellpadding="0" border="0" width="99%">
					<tr>
						<td valign="top" align="left">
							<div id="listadoResoluciones">{include file="$txtArchivoResoluciones"}</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	
	</table>