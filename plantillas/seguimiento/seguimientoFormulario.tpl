 
	<table cellpadding="5" cellspacing="0" border="0" width="100%">
		<tr>
			<td class="tituloTabla">No.Registro</td>
			<td class="tituloTabla">Grupo Gestión</td>
			<td class="tituloTabla">Seguimiento</td>
		</tr>
		<tr>
			<td align="left" style="padding-left: 10px;" width="70px">
				<input type="input"
					   id="referencia"
					   onFocus="this.style.backgroundColor = '#ADD8E6';"
					   onBlur="this.style.backgroundColor = '#FFFFFF';"
					   onkeyup="formatoSeparadores(this);"
					   style="width:95%;"
				/>
			</td><td align="left" style="padding-left: 10px;" width="350px">
				<select id="grupoGestion"
						style="width:95%"
						onFocus="this.style.backgroundColor = '#ADD8E6';"
						onBlur="this.style.backgroundColor = '#FFFFFF';"
						onChange="obtenerGestion( this , 'tdGestion2' , 'gestion' );">
				>
					<option value="0">Seleccione Grupo</option>
					{foreach from=$arrGrupoGestion key=seqGrupoGestion item=txtGrupoGestion}
						<option value="{$seqGrupoGestion}">{$txtGrupoGestion}</option>
					{/foreach}
				</select>
			</td><td align="left" style="padding-left: 10px;" id="tdGestion2">
				<select id="gestion"
						onFocus="this.style.backgroundColor = '#ADD8E6';"
						onBlur="this.style.backgroundColor = '#FFFFFF';"
						style="width:98%;"
				>
					<option value="0">Seleccione Gesti&oacute;n</select>
				</select>
			</td>
		</tr>
	</table>

	<table cellpadding="3" cellspacing="0" border="0" width="100%">
		<tr>
			<td colspan="3" style="border:1px dotted #999999; padding:2px;" id="busquedaAvanzada" valign="top">
				<table cllpadding="3" cellspacing="0" border="0" width="100%">
					<tr>
						<td style="width:14px; height:14px; cursor:pointer; padding-left:5px;" align="center">
							<div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; text-align:center;"
								 onClick="cuadroBusquedaAvanzada( 'busquedaAvanzada' );"
								 onMouseOver="this.style.backgroundColor='#ADD8E6';"
								 onMouseOut="this.style.backgroundColor='#F9F9F9';"
								 id="masbusquedaAvanzada"
							>+</div>
						</td>
						<td width="150px" align="left" style="padding-left: 5px;">
							<a href="#" onClick="cuadroBusquedaAvanzada( 'busquedaAvanzada' );" style="text-decoration: none;">
								Búsqueda Avanzada
							</a>
						</td>
						<td style="width:14px; height:14px; cursor:pointer;" align="center">
							<div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; text-align:center;"
								 onClick="limpiarBusqueda();"
								 onMouseOver="this.style.backgroundColor='#ADD8E6';"
								 onMouseOut="this.style.backgroundColor='#F9F9F9';"
							>x</div>
						</td>
						<td width="250px" align="left">
							<a href="#" onClick="limpiarBusqueda();" style="text-decoration: none;">
								Limpiar la busqueda
							</a>
						</td>
						<td align="right" style="padding-right: 10px;">
							<input type="button"
								   class="buscarCedula"
								   value="Buscar"
								   onClick="buscarSeguimiento( 'contenidoBusqueda', './contenidos/seguimiento/buscarSeguimiento.php' );"
							/>
						</td>
					</tr>
				</table>
				<div id="cuadrobusquedaAvanzada" style="display:none;"><p>
					<table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#E4E4E4">
						<tr>
							<td>Desde</td>
							<td>
								<input	type="text"
										id="inicial"
										value=""
										style="width:100px;"
										maxlength="10"
										onFocus="this.style.backgroundColor = '#ADD8E6';"
										onBlur="this.style.backgroundColor = '#FFFFFF';"
										readonly
								/> <a href="#" onClick="calendarioPopUp( 'inicial' );">Calendario</a>
							</td>
							<td rowspan="2">
								<input type="radio" id="cambiosSi" onClick="limpiarRadio( this , ['cambiosSi','cambiosNo','cambiosAmbos'] );" value="si"> Con Modificaciones<br>
								<input type="radio" id="cambiosNo" onClick="limpiarRadio( this , ['cambiosSi','cambiosNo','cambiosAmbos'] );" value="no"> Sin Modifiacioes <br>
								<input type="radio" id="cambiosAmbos" onClick="limpiarRadio( this , ['cambiosSi','cambiosNo','cambiosAmbos'] );" value="ambos"> Ambos
							</td>
							<td rowspan="2" valign="top">
								Comentarios del Tutor
								<textarea id="comentario"
										  style="width:100%; height:40px;"
										  onFocus="this.style.backgroundColor = '#ADD8E6';"
										  onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
								/></textarea>
							</td>
							<td rowspan="2">
								<input type="radio" id="criterioTextoInicia" onClick="limpiarRadio( this , ['criterioTextoInicia','criterioTextoTermina','criterioTextoContiene'] )" value="inicia"> Inicia Con <br>
								<input type="radio" id="criterioTextoTermina" onClick="limpiarRadio( this , ['criterioTextoInicia','criterioTextoTermina','criterioTextoContiene'] )" value="termina"> Termina Con <br>
								<input type="radio" id="criterioTextoContiene" onClick="limpiarRadio( this , ['criterioTextoInicia','criterioTextoTermina','criterioTextoContiene'] )" value="contiene"> Contiene
							</td>
						</tr>
						<tr>
							<td>Hasta</td>
							<td>
								<input	type="text"
										id="final"
										value=""
										style="width:100px;"
										maxlength="10"
										onFocus="this.style.backgroundColor = '#ADD8E6';"
										onBlur="this.style.backgroundColor = '#FFFFFF';"
										readonly
								/> <a href="#" onClick="calendarioPopUp( 'final' );">Calendario</a>
							</td>
						</tr>
					</table>
				</p></div>
			</td>
		</tr>
	</table>
	