	<table cellspacing="" cellpadding="0" border="0" width="99%">
		<tr>
			<td class="tituloCampo" width="150px">
				Buscar por nombre:
			</td>
			<td colspan="2" height="17px" valign="top">
				<div id="buscarNombre">
					<input	id="nombre" 
							type="text" 
							style="width:260px" 
							onFocus="this.style.backgroundColor = '#ADD8E6'; " 
							onBlur="this.style.backgroundColor = '#FFFFFF';" 
					/>
					<div id="contenedor"></div>
				</div>	
			</td>
			<td colspan="2">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td class="tituloCampo" width="150px">
				N&uacute;mero del documento
				<!-- onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"	-->
			</td>
			<td align="center" width="150px">
				<input	type="text" 
						name="buscaCedula" 
						id="buscaCedula" 
						value="" 
						style="width: 150px" 
						onFocus="this.style.backgroundColor = '#ADD8E6'; document.getElementById('formulario').innerHTML = ''; " 
						onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
						onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
				/>
			</td>
			<td class="tituloCampo" width="110px">
				Confirme n&uacute;mero
				<!-- onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"	-->
				</td>
			<td width="160px">
				<input	type="text" 
						name="buscaCedulaConfirmacion" 
						id="buscaCedulaConfirmacion" 
						value="" 
						style="width: 150px" 
						onFocus="this.style.backgroundColor = '#ADD8E6'; document.getElementById('formulario').innerHTML = ''; " 
						onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
						onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
				/>
			</td>
			<td>
				<input type="button" class="buscarCedula" value="Buscar" onClick="{$txtFuncion}">
			</td>
		</tr>
	</table>
	
	<table cellspacing="0" cellpadding="0" border="0" width="99%" height="90%" bgcolor="#E4E4E4"> 
		<tr><td height="5px"></td></tr>
		<tr>
			<td align="center" valign="top" id="formulario">
				&nbsp;
			</td>
		</tr>
	</table>
	
	<div id="buscarCedulaListener"></div>
	<div id="listenerBuscarNombre"></div>