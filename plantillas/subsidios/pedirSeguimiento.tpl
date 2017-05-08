
	<!-- TABLA QUE MUESTRA LAS CATEGORIAS DE SEGUIMIENTO -->
	
	<table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#E4E4E4">
		<tr>
			<td width="120px" class="tituloTabla">Grupo de Gestión</td>
			<td width="250px">
				<select name="seqGrupoGestion" 
						id="seqGrupoGestion" 
						style="width:250px"
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
			<td rowspan="2" align="center">
				<textarea rows="2" 
						  cols="5" 
						  id="txtComentario" 
						  name="txtComentario" 
						  style="width:95%"
						  onFocus="this.style.backgroundColor = '#ADD8E6';" 
			  			  onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales(this);"
				></textarea>
			</td>
		</tr>
		<tr>
			<td  class="tituloTabla">Gestión</td>
			<td id="tdGestion">
				<select name="seqGestion" 
						id="seqGestion" 
						style="width:250px"
						onFocus="this.style.backgroundColor = '#ADD8E6';" 
			  			onBlur="this.style.backgroundColor = '#FFFFFF';"
				>
					<option value="0">Seleccione Gesti&oacute;n</select>
				</select>
			</td>
		</tr>
	</table>