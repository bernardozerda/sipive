
	<!-- TABLA QUE MUESTRA LAS CATEGORIAS DE SEGUIMIENTO -->
	
	<table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#E4E4E4">
		
		<tr>
			<td align="center">
				<table  width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#E4E4E4" align="center">
					<tr>
						<td><a href="#" id="fecha1Desembolso" onClick="calendarioDesembolso( ['fecha1Desembolso'] , 'variablesDesembolso' );" > Fecha Inicio</td>
					</tr>
					<tr>
						<td><a href="#" id="fecha2Desembolso" onClick="calendarioDesembolso( ['fecha2Desembolso'] , 'variablesDesembolso' );" > Fecha Fin</td>
					</tr>
				</table>
			</td>
			<td width="70%">
				<table border="0">
					<tr>
						<td width="120px" class="tituloTabla">Grupo de Gestión</td>
						<td width="250px">
							<select name="seqGrupoGestionDesembolso" 
									id="seqGrupoGestionDesembolso" 
									style="width:250px"
									onFocus="this.style.backgroundColor = '#ADD8E6';" 
						  			onBlur="this.style.backgroundColor = '#FFFFFF';"
									onChange="obtenerGestion( this , 'tdGestionDesembolso' , 'seqGestionDesembolso' );">
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
						<td id="tdGestionDesembolso">
							<select name="seqGestionDesembolso" 
									id="seqGestionDesembolso" 
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
	<div id="variablesDesembolso">		
		<input type="hidden" 
		   id="varfecha1Desembolso"
		   name="fecha1Desembolso"
		/>
		<input type="hidden" 
		   id="varfecha2Desembolso"
		   name="fecha2Desembolso"
		/>		
	</div>
	