<table border="0" width="100%" id="tablaFormularioActas">
	<tr><td class="tituloTabla" colspan="5">ACTAS DEL PROYECTO</td></tr>
	<tr class="tituloTabla">
		<th align="center" width="10%" style="padding:6px;">Acta</th>
		<th align="center" width="15%" style="padding:6px;">Fecha</th>
		<th align="center" width="65%" style="padding:6px;">Observaciones</th>
	</tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
	{assign var="num" value="0"}
	{counter start=0 print=false assign=num}
	{foreach from=$arrActaProyecto key=seqActaProyecto item=arrActa}
		{if $num++%2 == 0} <tr class="fila_0">
		{else} <tr class="fila_1">
		{/if}
			<td align="center" width="10%" style="padding:6px;">{$arrActa.numActaProyecto}</td>
			<td align="center" width="15%" style="padding:6px;">{$arrActa.fchActaProyecto}</td>
			<td align="center" width="65%" style="padding:6px;">{$arrActa.txtEpigrafe}</td>
		</tr>
	{/foreach}
</table>