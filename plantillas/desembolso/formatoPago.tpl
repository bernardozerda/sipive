

	<!-- TITULO DE LA CARTA DE IMPRESION -->
	<table width="100%" cellspacing="0" cellpadding="0" border="1" style="border: 1px solid #999999; font-size:11px;">
		<tr>
			<td width="150px" height="80px" align="center" valign="middle" rowspan="4">
				<img src="http://www.habitatbogota.gov.co/sdv/recursos/imagenes/escudo.png">
			</td>
			<td align="center" valign="middle" style="padding:20px;" colspan="8">
				<b>Subsidio Distrital de Vivienda</b>
			</td>
			<td width="150px" align="center" valign="middle" rowspan="4">
				<img src="http://www.habitatbogota.gov.co/sdv/recursos/imagenes/bta_positiva_carta.jpg">
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle" style="padding:20px;" colspan="8">
				<b>Solicitud de Desembolso</b>
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle" style="padding:20px;" colspan="8">
				<b>Modalidad de Arrendamiento</b>
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle" style="padding:20px;" colspan="8">
				<b>Fecha: {$txtFecha}</b>
			</td>
		</tr>
	</table>
	
	<br>
	
	<table width="100%" cellspacing="0" cellpadding="0" border="1" style="border: 1px solid #999999;  font-size:11px;">	
		<tr>
			<td colspan="2">Beneficiario del Subsidio</td>
			<td colspan="5">Beneficiario del Pago</td>
			<td colspan="3">&nbsp;</td>
		</tr>
		
		<tr>
			<td>No Documento</td>
			<td>Nombre</td>
			<td>No Documento</td>
			<td>Nombre</td>
			<td>Tipo</td>
			<td>No Cuenta</td>
			<td>Banco</td>
			<td>No Pago</td>
			<td>Valor Subsidio</td>
			<td>Valor Desembolso</td>	
		</tr>
		
		{foreach from=$arrFormatoPago item=arrDatos}
			<tr>
				<td>{$arrDatos.Documento}</td>
				<td>{$arrDatos.Nombre}</td>
				<td>{$arrDatos.DocumentoGiro}</td>
				<td>{$arrDatos.NombreGiro}</td>
				<td>{$arrDatos.TipoCuentaGiro}</td>
				<td>{$arrDatos.CuentaGiro}</td>
				<td>{$arrDatos.Banco}</td>
				<td>{$arrDatos.NumeroPago}</td>
				<td>{$arrDatos.ValorSubsidio}</td>
				<td>{$arrDatos.ValorSolicitado}</td>	
			</tr>	
		{/foreach}
		
	</table>
	

