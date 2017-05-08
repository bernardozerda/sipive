<table cellspacing="0" cellpadding="0" border="1" width="100%" align="center">
	<tr>
	{foreach from=$arrTablas.titulos item=txtTitulo}
		<td class="tituloTabla">{$txtTitulo}</td>
	{/foreach}		
	</tr>
	{foreach from=$arrTablas.datos item=arrFila}
		<tr>
		{foreach from=$arrFila key=i item=dato}
			<td align=left class="tituloCampo">{if is_numeric( $dato )}  {$dato|number_format:0:'.':','} {else} {$dato} {/if} </td>
		{/foreach}
		<tr>
	{/foreach}
</table>
<div style="display:none" id="objGraficas">{$txtGraficas}</div>
<div id="objGraficasBorrar"></div>