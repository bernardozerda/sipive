<div id="seleccionadas" style="padding:5px;">
<!--{$arrUnidades|@count} Unidades de proyecto listadas 0 Seleccionadas-->
</div>

<table border="0" cellpadding="2" cellspacing="0" width="100%" bgcolor="#e4e4e4">
	<tr>
		<td width="75%" align="center"><input type="checkbox" id="0" onClick="seleccionarCheckUnidades('undListadoListos','0');" style="display:none" checked><strong>Nombre Unidad</strong></td>
		<td width="25%" align="center"><strong>Valor SDVE Actual</strong></td>
	</tr>
</table>

<form id="undListadoListos" onSubmit="return false;">
	<table border="0" cellpadding="2" cellspacing="0" width="100%">
		{foreach from=$arrUnidades key=seqUnidadProyecto item=arrInfo}
			<tr bgcolor="{cycle values='#F9F9F9,#E4E4E4'}" style="height:20px">
				<td width="75%" align="left" style="padding-left:10px;">
					<input id="{$seqUnidadProyecto}"
							type="checkbox"
							name="exportar[]"
							value="{$seqUnidadProyecto}"
							onClick="seleccionarCheckUnidades('undListadoListos','{$seqUnidadProyecto}');"
							style="display:none;"
							checked>
						{$arrInfo.nombreUnidad}
					</td>
				<td width="25%" align="right">{$arrInfo.sdveActual|number_format:'0':',':'.'}</td>
			</tr>
		{/foreach}
	</table>
	<input type="hidden" id="seqProyecto" name="seqProyecto" value="{$seqProyecto}">
</form>