{if $arrInformacionActo|@count != 0}
	<table cellpadding="0" cellspacing="0" width="100%" border="0">
		{foreach from=$arrInformacionActo key=seqUnidadActo item=arrInformacion}
			<tr><td width="20%"><b>Número de Acto:</b></td><td><b>{$arrInformacion.numActo}</b></td></tr>			
			<tr><td><b>Fecha de Acto:</b></td><td><b>{$arrInformacion.fchActo}</b></td></tr>
			<tr><td><b>Tipo de Acto:</b></td><td>{$arrInformacion.txtTipoActoUnidad}</td></tr>
			<tr><td valign='top'><b>Descripci&oacute;n:</b></td><td align='justify'>{$arrInformacion.txtDescripcion}</td></tr>
		{/foreach}
	</table>
{/if}
<br>
{if $arrVinculadosActo|@count != 0}
	<div style="height:320px; overflow-y:scroll;">
		<table cellpadding="0" cellspacing="0" width="100%" border="0">
			<tr bgcolor="#E4E4E4" style="height:18px">
				<td><b>#</b></td>
				<th>Proyecto</th>
				<th>Unidad</th>
				<th>Valor</th>
			</tr>
			{assign var="conteo" value=1}
			{foreach from=$arrVinculadosActo key=seqUnidadVinculado item=arrVinculados}
				{if $i++ is odd by 1} 
					<tr bgcolor="#E4E4E4" style="height:18px">
				{else}
					<tr style="height:18px">
				{/if}
					<td>{$conteo++}</td>
					<td>{$arrVinculados.txtNombreProyecto}</td>
					<td>{$arrVinculados.txtNombreUnidad}</td>
					<td align="right">{$arrVinculados.valIndexado|number_format:'0':',':'.'}</td>
				</tr>
			{/foreach}
		</table>
	</div>
	<!--<a href="#" onclick="exportarUnidadesProyectoExcel({$arrInformacion.seqUnidadActo})">
		<img src="./recursos/imagenes/excel.gif" width="20px" height="20px"></a>-->
{else}
	<table cellpadding="0" cellspacing="0" border="0" width="100%" id="tablaMensajes" style="padding:5px">
		<tr><td class="msgError"><li>No hay unidades vinculadas a este acto</li></td></tr>
	</table>
{/if}