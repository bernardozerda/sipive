<table cellspacing="0" cellpadding="0" border="0" width="100%" >
	<tr height="5px" />
	<tr>
		<td>
			<table cellspacing="0" cellpadding="0" border="0" width="100%" >
				<tr height="5px" />
				<tr>
					<td width="40%" ><li class="msgVerde" style="padding-left:0px;" >Verde </li></td>
					<td width="20%" align="left" class="msgVerde" style="padding-left:0px;" >{$verde}</td>
					<td align="left" class="msgVerde" style="padding-left:0px;" >( <a class="msgVerde" style="padding-left:0px; cursor:pointer;" onClick="reporteIndicadores( 'consulta' , '{$txtTipoReporte}', 'verde' )">C</a> )</td>
					<td align="left" class="msgVerde" style="padding-left:0px;" >( <a class="msgVerde" style="padding-left:0px; cursor:pointer;" onClick="reporteIndicadores( 'reporte' , '{$txtTipoReporte}', 'verde' )">E</a> )</td>
				</tr>
				<tr>
					<td width="40%" ><li class="msgAlerta" style="padding-left:0px;" >Amarillo </li></td>
					<td width="20%" align="left" class="msgAlerta" style="padding-left:0px;" >{$amarillo}</td>
					<td align="left" class="msgAlerta" style="padding-left:0px;" >( <a class="msgAlerta" style="padding-left:0px; cursor:pointer;" onClick="reporteIndicadores( 'consulta' , '{$txtTipoReporte}', 'amarillo' )">C</a> )</td>
					<td align="left" class="msgAlerta" style="padding-left:0px;" >( <a class="msgAlerta" style="padding-left:0px; cursor:pointer;" onClick="reporteIndicadores( 'reporte' , '{$txtTipoReporte}', 'amarillo' )">E</a> )</td>
				</tr>
				<tr>
					<td width="40%" ><li class="msgError" style="padding-left:0px;" >Rojo </li></td>
					<td width="20%" align="left" class="msgError" style="padding-left:0px;" >{$rojo}</td>
					<td align="left" class="msgError" style="padding-left:0px;" >( <a class="msgError" style="padding-left:0px; cursor:pointer;" onClick="reporteIndicadores( 'consulta' , '{$txtTipoReporte}', 'rojo' )">C</a> )</td>
					<td align="left" class="msgError" style="padding-left:0px;" >( <a class="msgError" style="padding-left:0px; cursor:pointer;" onClick="reporteIndicadores( 'reporte' , '{$txtTipoReporte}', 'rojo' )">E</a> )</td>
				</tr>
				<tr height="10px" />
				<tr>
					<td align="left" colspan="4">
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