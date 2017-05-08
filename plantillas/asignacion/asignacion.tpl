
	<!-- PLANTILLA PRINCIPAL DEL MODULO DE ACTOS ADMINSITRATIVOS (ASIGNACION) -->

	<table cellspacing="0" cellpadding="0" border="0" width="99%">
		<tr>
			<!-- CUADRO PARA LAS BUSQUEDAS -->
			<td width="310px" height="75px" valign="top">
				 <table cellpadding="1" cellspacing="0" border="0" width="100%">
					<tr>
						<td colspan="2" class="tituloTabla">
							Filtrar Actos Administrativos
						</td>
					</tr>
					<tr>
						<td>Tipo</td>
						<td>
							<select	id="seqTipoActoBuscar" 
									style="width:220px"
									onFocus="this.style.backgroundColor = '#ADD8E6';" 
									onBlur="this.style.backgroundColor = '#FFFFFF';" 
							>
								<option value="0">Todos los Actos</option>
								{foreach from=$claTipoActo->arrTipoActos key=seqTipoActo item=txtTipoActo}
									<option value="{$seqTipoActo}">{$txtTipoActo}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<td>Número</td>
						<td>
							<input  type="text"
									id="numActo" 
									value="" 
									style="width:220px"
									onFocus="this.style.backgroundColor = '#ADD8E6';" 
									onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros( this );"  
							/>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="right" style="padding-right:20px;">
							<a href="#" onclick="filtarActosAdministrativos( )">Filtrar Actos</a>
						</td>
					</tr>
				</table> 
			</td>
			
			<!-- FORMULARIO PARA LA CREACION DE ACTOS ADMINISTRATIVOS -->
			<td rowspan="2" style="border-left: 1px dotted #999999;" valign="top">
				<form id="frmAsignacion" onSumbit="return false;">
					<table cellpadding="1" cellspacing="0" border="0" width="100%">
						<tr>
							<td class="tituloTabla" colspan="2">Formulario de creacion de actos adminsitrativos</td>
						</tr>
						<tr>
							<td align="right" width="75px" style="padding-right:5px;" height="25px">
								Tipo de Acto
							</td>
							<td>
								<select	style="width:220px"
										onFocus="this.style.backgroundColor = '#ADD8E6';" 
										onBlur="this.style.backgroundColor = '#FFFFFF';" 
										name="seqTipoActo"
										id="seqTipoActo"
										onChange="
											cargarContenido( 
												'caracteristicasActos',
												'contenidos/asignacion/caracteristicasActos.php',
												'tipo='+this.options[this.selectedIndex].value,
												true
											); 
										"
								>
									{foreach from=$claTipoActo->arrTipoActos key=seqTipoActo item=txtTipoActo}
										<option value="{$seqTipoActo}">{$txtTipoActo}</option>
									{/foreach}
								</select>
								
								<a href="#" onClick="plantillaActoAdministrativo('seqTipoActo')">Ver Plantilla</a>
								
							</td>
						</tr>
						<tr>
							<td class="tituloTabla" colspan="2" id="tituloPropiedad">Propiedades de Actos Administrativos</td>
						</tr>	
						<tr>
							<td colspan="2">
								<table cellpadding="1" cellspacing="0" border="0" width="99%">
									<tr>
										<td valign="top" width="180px">Numero del Acto</td>
										<td valign="top" align="left">
											<input  type="text"
													name="numActo"
													value=""
													onFocus="this.style.backgroundColor = '#ADD8E6';" 
												   	onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros( this );"
											/>
										</td>
									</tr>
									<tr>
										<td valign="top" width="180px">Fecha del Acto</td>
										<td valign="top" align="left">
											<input name="fchActo" 
												   id="fchActo"
												   value="" 
												   onFocus="this.style.backgroundColor = '#ADD8E6';" 
												   onBlur="this.style.backgroundColor = '#FFFFFF';"
												   readonly 
											/> <a href="#" onClick="javascript: calendarioPopUp( 'fchActo'); ">Calendario</a> 										
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
							<td colspan="2" align="center">
								<table cellpadding="1" cellspacing="0" border="0" width="99%">
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
								</table>	
							</td>
						</tr>
						<tr>
							<td align="right" valign="top" colspan="2" height="25px">
									<input 	type="button" 
											id="botonCrearActo" 
											value="Crear Acto" 
											onClick="
												someterFormulario( 
													'mensajes',
													this.form,
													'./contenidos/asignacion/salvarAsignacion.php',
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
		
		<!-- LISTADO DE RESOLUCIONES -->
		<tr>
			<td height="350px" style="overflow:auto;" valign="top">
				<div id="listadoResoluciones">{include file="$txtArchivoResoluciones"}</div>
			</td>
		</tr>
		
	</table>
		