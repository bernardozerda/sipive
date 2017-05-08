<p>
		<table border="0" cellspacing="2" cellpadding="0" width="860">
			<tr><td class="tituloTabla" colspan="7">TIPO VIVIENDA</td></tr>
			<tr><td colspan="7" align="right"><div onClick="addTipoVivienda()" style="cursor: hand">Adicionar Tipo de Vivienda&nbsp;<img src="recursos/imagenes/plus_icon.gif"></div></td></tr>
		</table>
		<div style="width:860px; overflow: scroll;">
			<table border="0" cellspacing="2" cellpadding="0" width="1200" id="tablaTipoVivienda">
				<tr class="tituloTabla">
					<th align="center" width="18%" style="padding:6px;">Nombre</th>
					<th align="center" width="8%" style="padding:6px;">Cantidad</th>
					<th align="center" width="10%" style="padding:6px;">&Aacute;rea</th>
					<th align="center" width="10%" style="padding:6px;">A&ntilde;o Venta</th>
					<th align="center" width="10%" style="padding:6px;">Precio Venta</th>
					<th align="center" width="26%" style="padding:6px;">Descripci&oacute;n</th>
					<th align="center" width="10%" style="padding:6px;">Cierre</th>
					<th align="center" width="8%" style="padding:6px;"></th>
				</tr>
				{assign var="num" value="0"}
				{counter start=0 print=false assign=num}
				{foreach from=$arrTipoVivienda key=seqTipoVivienda item=arrTipoV}
					{if $num++%2 == 0} <tr class="fila_0">
					{else} <tr class="fila_1">
					{/if}
						<td align="center" valign="top" style="padding:6px;" width="18%">
							{counter print=false}
							{assign var="actual" value="r_$num"}
							<input type="hidden" name="seqTipoVivienda[{$actual}]" id="seqTipoVivienda" value="{$arrTipoV.seqTipoVivienda}" >
							<input type="text" name="txtNombreTipoVivienda[{$actual}]" id="txtNombreTipoVivienda" value="{$arrTipoV.txtNombreTipoVivienda}" style="width:150px;" onblur="sinCaracteresEspeciales( this );">
						</td>
						<td align="center" valign="top" style="padding:6px;" width="8%">
							<input type="text" name="numCantidad[{$actual}]" id="numCantidad{$actual}" value="{$arrTipoV.numCantidad}" style="width:50px; text-align:right" onblur="sinCaracteresEspeciales( this ); soloNumeros( this ); sumaVentas();">
						</td>
						<td align="center" valign="top" style="padding:6px;" width="10%">
							<input type="text" name="numArea[{$actual}]" id="numArea" value="{$arrTipoV.numArea}" style="width:50px; text-align:right" onblur="sinCaracteresEspeciales( this ); soloNumeros( this );">&nbsp;m²
						</td>
						<td align="center" valign="top" style="padding:6px;" width="10%">
							<input type="text" name="numAnoVenta[{$actual}]" id="numAnoVenta" value="{$arrTipoV.numAnoVenta}" style="width:50px; text-align:right" onblur="sinCaracteresEspeciales( this ); soloNumeros( this );">
						</td>
						<td align="center" valign="top" style="padding:6px;" width="10%">
							$ <input type="text" name="valPrecioVenta[{$actual}]" id="valPrecioVenta{$actual}" value="{$arrTipoV.valPrecioVenta}" style="width:80px; text-align:right" onblur="sinCaracteresEspeciales( this ); soloNumeros( this ); sumaVentas();">
						</td>
						<td align="center" valign="top" style="padding:6px;" width="26%">
							<textarea name="txtDescripcion[{$actual}]" id="txtDescripcion" style="width:260px" >{$arrTipoV.txtDescripcion}</textarea>
						</td>
						<td align="center" valign="top" style="padding:6px;" width="10%">
							$ <input type="text" name="valCierre[{$actual}]" id="valCierre" value="{$arrTipoV.valCierre}" style="width:80px; text-align:right" onblur="sinCaracteresEspeciales( this ); soloNumeros( this );">
						</td>
						<td align="center" valign="top" style="padding:6px;" width="8%">
							<input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'>
						</td>
					</tr>
				{/foreach}
			</table>
		</div>
	</p>