
	<!-- TABLA QUE MUESTRA LAS CATEGORIAS DE SEGUIMIENTO -->
	
	<table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#E4E4E4">
		<tr>
			<td width="100px" class="tituloTabla">Grupo de Gestión</td>
			<td width="380px">
				<select name="seqGrupoGestion" 
						id="seqGrupoGestion" 
						style="width:98%;"
						onFocus="this.style.backgroundColor = '#ADD8E6';" 
			  			onBlur="this.style.backgroundColor = '#FFFFFF';"
						onChange="obtenerGestion( this , 'tdGestion' , 'seqGestion' );">
				>
					<option value="0">Seleccione Grupo</option>
					{foreach from=$arrGrupoGestion key=seqGrupoGestion item=txtGrupoGestion}
						<option value="{$seqGrupoGestion}">{$txtGrupoGestion}</option>
					{/foreach}
				</select>
			</td>
			<td rowspan="2" align="left" valign="top">
				<textarea rows="2" 
						  cols="5" 
						  id="txtComentario" 
						  name="txtComentario" 
						  style="width:98%; height:42px;"
						  onFocus="this.style.backgroundColor = '#ADD8E6';" 
			  			  onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales(this);"
				></textarea>
			</td>
		</tr>
		<tr>
			<td class="tituloTabla">Gestión</td>
			<td id="tdGestion" width="250px">
				<select name="seqGestion" 
						id="seqGestion" 
						style="width:98%;"
						onFocus="this.style.backgroundColor = '#ADD8E6';" 
			  			onBlur="this.style.backgroundColor = '#FFFFFF';"
				>
					<option value="0">Seleccione Gesti&oacute;n</select>
				</select>
			</td>
		</tr>
	</table>