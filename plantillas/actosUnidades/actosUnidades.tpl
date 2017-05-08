<center>
	<form enctype="multipart/form-data" method="POST" id="frmActoUnidades" autocomplete="off">
		<table cellpadding="2" cellspacing="0" border="0" width="100%">
			<tr><td colspan="2" bgcolor="#E4E4E4" class="tituloTabla" align="center" width="350px">Carga de Acto Administrativo para Unidades Residenciales</td></tr>
			<tr><td><b>N&uacute;mero de Acto:</b></td>
				<td><input 
					type="text"
					name="numActo"
					id="numActo"
					onFocus="this.style.backgroundColor = '#ADD8E6';"
					onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros(this)"
					style="width: 80px;"
					value=""
					>
				</td>
			</tr>
			<tr><td><b>Fecha de Acto:</b></td>
				<td><input type="text"
							name="fchActo"
							id="fchActo"
							onFocus="this.style.backgroundColor = '#ADD8E6';"
							onBlur="this.style.backgroundColor = '#FFFFFF';"
							style="width: 80px;"
							value=""
							readonly>
					<a href="#" onClick="calendarioPopUp('fchActo')">Calendario</a>
				</td>
			</tr>
			<tr><td><b>Tipo de Acto:</b></td>
				<td><select name="seqTipoActoUnidad"
							id="seqTipoActoUnidad"
							style="width:200px;" >
							<option value="0">Seleccione una opci&oacute;n</option>
							{foreach from=$arrTipoActoUnidad key=seqTipoActoUnidad item=txtTipoActoUnidad}
								<option value="{$seqTipoActoUnidad}">{$txtTipoActoUnidad}</option>
							{/foreach}
					</select>
				</td>
			</tr>
			<tr><td><b>Descripci&oacute;n:</b></td>
				<td><textarea name="txtDescripcion"
							id="txtDescripcion"
							onFocus="this.style.backgroundColor = '#ADD8E6';"
							onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales(this);"
							style="width: 98%;"></textarea>
				</td>
			</tr>
			<tr><td><b>Archivo de carga:</b></td><td valign="top"><input type="file" name="fileUnidadesActo" /> <a href="#" onclick="construccionArchivoIndexacion()">Vea como construir el archivo de carga</a></td></tr>
			<tr><td colspan="2" align="right">
					<input type="button" 
							value="Ingresar Acto" 
							onClick="someterFormulario('mensajes', this.form, './contenidos/actosUnidades/salvarActosUnidades.php', true, true); " />
				</td>
			</tr>
		</table>
	</form>
	<br>
	<div style="height:380px; overflow-y:scroll;">
		<table cellpadding="0" cellspacing="0" border="0" width="60%">
			<tr style="height:18px">
				<td bgcolor="#E4E4E4" align="center"><b>Acto</b></td>
				<td bgcolor="#E4E4E4" align="center"><b>Tipo</b></td>
				<td bgcolor="#E4E4E4" align="center"><b>Vinculados</b></td>
			</tr>
			{assign var="conteo" value=1}
			{foreach from=$arrActosUnidades key=seqUnidadActo item=arrActoUnidad}
				{if $i++ is odd by 1}
					<tr bgcolor="#E4E4E4" style="height:18px">
				{else}
					<tr style="height:18px">
				{/if}
					<!--<a href="#" onclick="verInformacionActoUnidad( {$arrActoUnidad.seqUnidadActo} );">Detalles</a>-->
					<td align="center"><b><a href="#" onclick="verInformacionActoUnidad( {$arrActoUnidad.seqUnidadActo} );">{$arrActoUnidad.Acto}</a></b></td>
					<td align="center">{$arrActoUnidad.txtTipoActoUnidad}</td>
					<td align="center">{$arrActoUnidad.cuantos}</td>
				</tr>
			{/foreach}
		</table>
	</div>
</center>