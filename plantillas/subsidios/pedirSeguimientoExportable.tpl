
	<!-- TABLA QUE MUESTRA LAS CATEGORIAS DE SEGUIMIENTO -->
	
	<table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#E4E4E4">
		
		<tr>
			<td align="center" width="20%">
				<table  width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#E4E4E4" align="center">
					<tr>
						<td><a href="#" id="fecha1" onClick="calendarioDesembolso( ['fecha1'] , 'variables' );" > Fecha Inicio</td>
					</tr>
					<tr>
						<td><a href="#" id="fecha2" onClick="calendarioDesembolso( ['fecha2'] , 'variables' );" > Fecha Fin</td>
					</tr>
				</table>
			</td>
			<td>
				<table border="0">
					<tr>
						<td>Cedulas Filtro</td>
					</tr>
					<tr>
						<td><input id="fileSecuenciales" type="file" name="cedulasFiltro"/></td>
					</tr>
				</table>
				
			</td>
			<td width="70%">
				<table border="0">
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
			</td>
			
		</tr>
	</table>
	<input type="hidden" 
	   id="txtComentario"
	   name="txtComentario"
	/>
	<div id="variables">		
		<input type="hidden" 
		   id="varfecha1"
		   name="fecha1"
		/>
		<input type="hidden" 
		   id="varfecha2"
		   name="fecha2"
		/>		
	</div>
	