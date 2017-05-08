<p>
	<table border="0" cellspacing="2" cellpadding="0" width="860">
		<tr><td class="tituloTabla" colspan="7">CRONOGRAMA DE FECHAS DE OBRA</td></tr>
	</table>
	<div style="width:860px; overflow: scroll;">
		<table border="0" cellspacing="2" cellpadding="0" width="100%" id="tablaFormularioFechas">
			<tr class="tituloTabla">
				<th align="center" style="padding:3px;"></th>
				<th align="center" style="padding:3px;" colspan="3">Proyecto</th>
				<th align="center" style="padding:3px;" colspan="2">Ventas del Proyecto</th>
				<th align="center" style="padding:3px;" colspan="2">Entrega y Escrituraci&oacute;n de Viviendas</th>
			</tr>
			<tr class="tituloTabla">
				<th align="center" style="padding:3px;">Acta Descriptiva</th>
				<th align="center" style="padding:3px;">Inicio</th>
				<th align="center" style="padding:3px;">Terminaci&oacute;n</th>
				<th align="center" style="padding:3px;">Plazo Ejecuci&oacute;n (Meses)</th>
				<th align="center" style="padding:3px;">Inicio</th>
				<th align="center" style="padding:3px;">Terminaci&oacute;n</th>
				<th align="center" style="padding:3px;">Inicio</th>
				<th align="center" style="padding:3px;">Terminaci&oacute;n</th>
			</tr>
			{assign var="num" value="0"}
			{counter start=0 print=false assign=num}
			{foreach from=$arrCronogramaFecha key=seqCronogramaFecha item=arrCronograma}
				{if $num++%2 == 0} <tr class="fila_0">
				{else} <tr class="fila_1">
				{/if}
					<td align="center" valign="top" style="padding:6px;">Num. {$arrCronograma.numActaDescriptiva} A&ntilde;o {$arrCronograma.numAnoActaDescriptiva}</td>
					<td align="center" valign="top" style="padding:3px;">{$arrCronograma.fchInicialProyecto}</td>
					<td align="center" valign="top" style="padding:3px;">{$arrCronograma.fchFinalProyecto}</td>
					<td align="center" valign="top" style="padding:6px;">{$arrCronograma.valPlazoEjecucion}</td>
					<td align="center" valign="top" style="padding:3px;">{$arrCronograma.fchInicialEntrega}</td>
					<td align="center" valign="top" style="padding:3px;">{$arrCronograma.fchFinalEntrega}</td>
					<td align="center" valign="top" style="padding:3px;">{$arrCronograma.fchInicialEscrituracion}</td>
					<td align="center" valign="top" style="padding:3px;">{$arrCronograma.fchFinalEscrituracion}</td>
				</tr>
			{/foreach}
		</table>
	</div>
</p>