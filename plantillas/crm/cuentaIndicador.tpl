<table cellspacing="0" cellpadding="0" border="0" width="100%" >
	<tr height="5px" />
	<tr>
		<td>
			<table cellspacing="0" cellpadding="0" border="0" width="100%" >
				<tr height="5px" />
				<tr>
					<td width="40%" ><li class="msgVerde" style="padding-left:0px;" >Verde </li></td>
					<td align="left" class="msgVerde" style="padding-left:0px;" >( <a class="msgVerde" style="padding-left:0px;" onClick="reporteIndicadores( 'consulta' , '{$txtTipoReporte}', 'verde' )">{$verde}</a> )</td>
				</tr>
				<tr>
					<td width="40%" ><li class="msgAlerta" style="padding-left:0px;" >Amarillo </li></td>
					<td align="left" class="msgAlerta" style="padding-left:0px;" >( <a class="msgAlerta" style="padding-left:0px;" onClick="reporteIndicadores( 'consulta' , '{$txtTipoReporte}', 'amarillo' )">{$amarillo}</a> )</td>
				</tr>
				<tr>
					<td width="40%" ><li class="msgError" style="padding-left:0px;" >Rojo </li></td>
					<td align="left" class="msgError" style="padding-left:0px;" >( <a class="msgError" style="padding-left:0px;" onClick="reporteIndicadores( 'consulta' , '{$txtTipoReporte}', 'rojo' )">{$rojo}</a> )</td>
				</tr>
				<tr height="10px" />
				<tr>
					<td align="left" colspan="2">
					{if $txtTipoReporte != "" }
						<input type="button" value="Consultar" onClick="reporteIndicadores( 'consulta' , '{$txtTipoReporte}', '' )" >&nbsp;
						<input type="button" value="Exportable" onClick="reporteIndicadores('reporte'  , '{$txtTipoReporte}', '' )"; >
					{/if}
					</td>
				</tr>
				<tr height="5px" />
			</table>
			
		</td>
	</tr>
</table>