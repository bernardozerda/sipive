<table border="0" width="100%" id="tablaFormularioRes">
	<tr><td class="tituloTabla" colspan="5">RESOLUCIONES DEL PROYECTO</td></tr>
	<tr class="tituloTabla">
		<th align="center" width="10%" style="padding:6px;">Resoluci&oacute;n</th>
		<th align="center" width="15%" style="padding:6px;">Fecha</th>
		<th align="center" width="65%" style="padding:6px;">Resuelve</th>
	</tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
	{assign var="num" value="0"}
	{counter start=0 print=false assign=num}
	{foreach from=$arrResolucionProyecto key=seqResolucionProyecto item=arrResolucion}
		{if $num++%2 == 0} <tr class="fila_0">
		{else} <tr class="fila_1">
		{/if}
			<td align="center" style="padding:6px;">{$arrResolucion.numResolucionProyecto}</td>
			<td align="center" style="padding:6px;">{$arrResolucion.fchResolucionProyecto}</td>
			<td align="center" style="padding:6px;">{$arrResolucion.txtResuelve}</td>
		</tr>
	{/foreach}
</table>