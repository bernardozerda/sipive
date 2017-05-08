<p>
		<table border="0" cellspacing="2" cellpadding="0" width="860">
			<tr><td class="tituloTabla" colspan="7">CRONOGRAMA DE FECHAS DE OBRA</td></tr>
			<tr><td colspan="7" align="right"><div onClick="addCronogramaFechas()" style="cursor: hand">Adicionar Cronograma<img src="recursos/imagenes/plus_icon.gif"></div></td></tr>
		</table>
		<div style="width:860px; overflow: scroll;">
			<table border="0" cellspacing="2" cellpadding="0" width="1350" id="tablaFormularioFechas">
				<tr class="tituloTabla">
					<th align="center" style="padding:3px;"></th>
					<th align="center" style="padding:3px;" colspan="3">Proyecto</th>
					<th align="center" style="padding:3px;" colspan="2">Ventas del Proyecto</th>
					<th align="center" style="padding:3px;" colspan="2">Entrega y Escrituraci&oacute;n de Viviendas</th>
					<th align="center" style="padding:6px;"></th>
				</tr>
				<tr class="tituloTabla">
					<th align="center" width="12%" style="padding:3px;">Acta Descriptiva</th>
					<th align="center" width="12%" style="padding:3px;">Inicio</th>
					<th align="center" width="12%" style="padding:3px;">Terminaci&oacute;n</th>
					<th align="center" width="8%" style="padding:3px;">Plazo Ejecuci&oacute;n (Meses)</th>
					<th align="center" width="12%" style="padding:3px;">Inicio</th>
					<th align="center" width="12%" style="padding:3px;">Terminaci&oacute;n</th>
					<th align="center" width="12%" style="padding:3px;">Inicio</th>
					<th align="center" width="12%" style="padding:3px;">Terminaci&oacute;n</th>
					<th align="center" width="8%" style="padding:6px;"></th>
				</tr>
				{assign var="num" value="0"}
				{counter start=0 print=false assign=num}
				{foreach from=$arrCronogramaFecha key=seqCronogramaFecha item=arrCronograma}
					{if $num++%2 == 0} <tr class="fila_0">
					{else} <tr class="fila_1">
					{/if}
						<td align="center" width="18%" valign="top" style="padding:6px;">
							{counter print=false}
							{assign var="actual" value="r_$num"}
							<input type="hidden" name="seqCronogramaFecha[{$actual}]" id="seqCronogramaFecha" value="{$arrCronograma.seqCronogramaFecha}" >
							Num. <input name="numActaDescriptiva[{$actual}]" type="text" id="numActaDescriptiva[{$actual}]" value="{$arrCronograma.numActaDescriptiva}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" size="6" style="text-align:center" />
							 A&ntilde;o <input name="numAnoActaDescriptiva[{$actual}]" type="text" id="numAnoActaDescriptiva[{$actual}]" value="{$arrCronograma.numAnoActaDescriptiva}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" size="6" style="text-align:center" />
						</td>
						<td align="center" width="12%" valign="top" style="padding:3px;">
							<input name="fchInicialProyecto[{$actual}]" type="text" id="fchInicialProyecto[{$actual}]" value="{$arrCronograma.fchInicialProyecto}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialProyecto[{$actual}]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
						</td>
						<td align="center" width="12%" valign="top" style="padding:3px;">
							<input name="fchFinalProyecto[{$actual}]" type="text" id="fchFinalProyecto[{$actual}]" value="{$arrCronograma.fchFinalProyecto}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalProyecto[{$actual}]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
						</td>
						<td align="center" width="12%" valign="top" style="padding:6px;">
							<input name="valPlazoEjecucion[{$actual}]" type="text" id="valPlazoEjecucion[{$actual}]" value="{$arrCronograma.valPlazoEjecucion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" size="12" style="text-align:center" />
						</td>
						<td align="center" width="12%" valign="top" style="padding:3px;">
							<input name="fchInicialEntrega[{$actual}]" type="text" id="fchInicialEntrega[{$actual}]" value="{$arrCronograma.fchInicialEntrega}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialEntrega[{$actual}]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
						</td>
						<td align="center" width="12%" valign="top" style="padding:3px;">
							<input name="fchFinalEntrega[{$actual}]" type="text" id="fchFinalEntrega[{$actual}]" value="{$arrCronograma.fchFinalEntrega}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalEntrega[{$actual}]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
						</td>
						<td align="center" width="12%" valign="top" style="padding:3px;">
							<input name="fchInicialEscrituracion[{$actual}]" type="text" id="fchInicialEscrituracion[{$actual}]" value="{$arrCronograma.fchInicialEscrituracion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialEscrituracion[{$actual}]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
						</td>
						<td align="center" width="12%" valign="top" style="padding:3px;">
							<input name="fchFinalEscrituracion[{$actual}]" type="text" id="fchFinalEscrituracion[{$actual}]" value="{$arrCronograma.fchFinalEscrituracion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalEscrituracion[{$actual}]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
						</td>
						<td align="center" width="10%" valign="top" style="padding:6px;">
							<input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'>
						</td>
					</tr>
				{/foreach}
			</table>
		</div>
	</p>