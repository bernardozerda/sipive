<p>
	<table border="0" cellspacing="2" cellpadding="0" width="860">
		<tr><td class="tituloTabla" colspan="7">TIPO VIVIENDA</td></tr>
	</table>
	<div style="width:860px; overflow: scroll;">
		<table border="0" cellspacing="2" cellpadding="0" width="100%" id="tablaTipoVivienda">
			<tr class="tituloTabla">
				<th align="center" style="padding:6px;">Nombre</th>
				<th align="center" style="padding:6px;">Cantidad</th>
				<th align="center" style="padding:6px;">&Aacute;rea</th>
				<th align="center" style="padding:6px;">A&ntilde;o Venta</th>
				<th align="center" style="padding:6px;">Precio Venta</th>
				<th align="center" style="padding:6px;">Descripci&oacute;n</th>
				<th align="center" style="padding:6px;">Cierre</th>
			</tr>
			{assign var="num" value="0"}
			{counter start=0 print=false assign=num}
			{foreach from=$arrTipoVivienda key=seqTipoVivienda item=arrTipoV}
				{if $num++%2 == 0} <tr class="fila_0">
				{else} <tr class="fila_1">
				{/if}
					<td align="center" valign="top" style="padding:6px;">{$arrTipoV.txtNombreTipoVivienda}</td>
					<td align="center" valign="top" style="padding:6px;">{$arrTipoV.numCantidad}</td>
					<td align="center" valign="top" style="padding:6px;">{$arrTipoV.numArea}&nbsp;m²</td>
					<td align="center" valign="top" style="padding:6px;">{$arrTipoV.numAnoVenta}</td>
					<td align="center" valign="top" style="padding:6px;">$ {$arrTipoV.valPrecioVenta}</td>
					<td align="center" valign="top" style="padding:6px;">{$arrTipoV.txtDescripcion}</td>
					<td align="center" valign="top" style="padding:6px;">$ {$arrTipoV.valCierre}</td>
				</tr>
			{/foreach}
		</table>
	</div>
</p>