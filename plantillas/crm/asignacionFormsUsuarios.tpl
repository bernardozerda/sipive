	
	<form id="frmAsignacionFormsUsuarios">
	
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr height="20px" />
		<tr>
			<td width="50%" valign="top">
				<table cellspacing="0" cellpadding="0" border="0" width="95%">
					<tr>
						<td width="20px" />
						<td>
							<div id="camposOcultosAsignacion" style="display:none"></div>
							<div id="treeDivArbolMostrarTutoresMasiva" class="ygtv-checkbox" ></div>
						</td>
					</tr>
				</table>
			</td>
			
			
			
			<td valign="top">
			
				<table cellspacing="0" cellpadding="0" border="0" width="95%">
					<tr height="20px" />
					<tr style="padding-left: 100px">
						<td width="100px" style="padding-left: 10px;">Cedulas PPal:</td>
						<td height="30px" align="left" valign="middle"> 
							<input type="file" name="archivoCedulas" />
						</td>
					</tr>
					<tr style="padding-left: 100px">
						<td width="100px" style="padding-left: 10px;">Cedula</td>
						<td height="30px" align="left" valign="middle"> 
							<input type="text" name="numCedula" />
						</td>
					</tr>
					<tr height="10px" />
					<tr><td width="40px" /><td><input type="radio" id="txtVincular" name="txtVincular" value="vincular">Vincular</td></tr>
					<tr><td width="40px" /><td><input type="radio" id="txtVincular" name="txtVincular" value="desvincular">Desvincular</td></tr>
					<tr height="30px" />
					
					<!-- 
					<tr style="padding-left: 100px">
						<td  width="100px" style="padding-left: 10px;" />Coordinador
						<td>
							<input name="seqCoordinador" 
									id="seqCoordinador" 
									type="hidden"
									value=
							<select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
									onBlur="this.style.backgroundColor = '#FFFFFF';" 
									name="seqCoordinador" 
									id="seqCoordinador" 
									style="width:260px;"
							>
								{foreach from=$arrCoordinadores key=seqCoordinador item=txtCoordinador}
									<option value="{$seqCoordinador}" >{$txtCoordinador}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					-->
					
					<!-- Boton Vincular -->
					<tr>
						<td colspan="2" height="25px" align="right" style="padding-right:20px;" bgcolor="#F9F9F9">
								<input  type="button" 
										value="Asignar Hogares" 
										id="botonAsignacion"
								/>	
						</td>
					</tr>
					<tr>
						<td colspan="2" align="left">
							<div id="divTablasUsuariosFormulariosMasiva"></div>
							<div id="camposOcultosAsignacion" ></div>
						</td>
					</tr>
				</table>
			
			</td>
		</tr>
	</table>
	
	</form>