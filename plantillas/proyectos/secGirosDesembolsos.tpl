<p><img src="recursos/imagenes/blank.gif" onload="init();">
<table border="0" cellspacing="2" cellpadding="0" width="860">
	<tr><td class="tituloTabla" colspan="7">DESEMBOLSOS</td></tr>
	<tr><td colspan="7" align="right"><div onClick="addGiroDesembolsos({$objFormularioProyecto->valTotalCostos},{$objFormularioProyecto->valNumeroSoluciones}, '{$optModalidadDesembolso}','{$optTipoCuenta}','{$optBanco}')" style="cursor: hand">Adicionar Desembolso<img src="recursos/imagenes/plus_icon.gif"></div></td></tr>
</table>
<div style="width:860px; height:500px; overflow: scroll;">
	<table border="0" cellspacing="2" cellpadding="0" width="100%" id="tablaGiroDesembolsos"><tr><td>
		{assign var="num" value="0"}
		{counter start=0 print=false assign=num}
		{foreach from=$arrDesembolsoProyecto key=seqDesembolsoProyecto item=arrDesembolso}
			{counter print=false}
			{assign var="actual" value="r_$num"}
		<table cellspacing='0' cellpadding='0' border='0'><tr><td>
		<div class="accordionItem">
			<h2>Pago N&uacute;mero {$arrDesembolso.valNumeroPago}
			<input type="hidden" name="seqDesembolsoProyecto[{$actual}]" id="seqDesembolsoProyecto[{$actual}]" readonly value="{$arrDesembolso.seqDesembolsoProyecto}"></h2>
			<div style="background-color:#FFFFFF">
				<table border="0" cellspacing="2" cellpadding="0" width="100%">
					<tr><td class="tituloTabla" colspan="4">BENEFICIARIO DEL GIRO ANTICIPADO</td></tr>
					<tr><td width="25%">Nombre del Vendedor</td>
						<td width="25%"><input name="txtNombreVendedor[{$actual}]" type="text" id="txtNombreVendedor[{$actual}]" value="{$arrDesembolso.txtNombreVendedor}" onBlur="soloLetras( this ); sinCaracteresEspeciales( this );"  style="width:200px;" /></td>
						<td width="25%">NIT del Vendedor</td>
						<td width="25%"><input name="numNitVendedor[{$actual}]" type="text" id="numNitVendedor[{$actual}]" value="{$arrDesembolso.numNitVendedor}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:190px;" /></td>
					</tr>
					<tr><td>Tel&eacute;fono del Vendedor</td>
						<td><input name="numTelefonoVendedor[{$actual}]" type="text" id="numTelefonoVendedor[{$actual}]" value="{$arrDesembolso.numTelefonoVendedor}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );"  style="width:200px;" /></td>
						<td>Correo Electr&oacute;nico del Vendedor</td>
						<td><input name="txtCorreoVendedor[{$actual}]" type="text" id="txtCorreoVendedor[{$actual}]" value="{$arrDesembolso.txtCorreoVendedor}" onBlur="sinCaracteresEspeciales( this )" style="width:190px;" /></td>
					</tr>
					<tr><td>Beneficiario del Giro</td>
						<td><input name="txtNombreBeneficiarioGiro[{$actual}]" type="text" id="txtNombreBeneficiarioGiro[{$actual}]" value="{$arrDesembolso.txtNombreBeneficiarioGiro}" onBlur="sinCaracteresEspeciales( this );"  style="width:200px;" /></td>
						<td>NIT Beneficiario del Giro</td>
						<td><input name="numNitBeneficiarioGiro[{$actual}]" type="text" id="numNitBeneficiarioGiro[{$actual}]" value="{$arrDesembolso.numNitBeneficiarioGiro}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:190px;" /></td>
					</tr>
					<tr>
						<td>Costo del Proyecto</td>
						<td>$ {$objFormularioProyecto->valTotalCostos}</td>
						<td>N&uacute;mero Soluciones</td>
						<td>{$objFormularioProyecto->valNumeroSoluciones}</td>
					</tr>
					<tr>
						<td>Valor del Desembolso</td>
						<td>$ <input name="valDesembolso[{$actual}]" type="text" id="valDesembolso[{$actual}]" value="{$arrDesembolso.valDesembolso}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:90px;" /></td>
						<td	colspan="2"></td>
					</tr>
					<tr><td class="tituloTabla" colspan="4" align="center">INFORMACI&Oacute;N DEL GIRO ANTICIPADO</td></tr>
					<tr><td width="25%">Modalidad del Desembolso</td>
						<td width="25%">
							<select name="seqTipoModalidadDesembolso[{$actual}]"
								id="seqTipoModalidadDesembolso[{$actual}]"
								style="width:200px"
								>
								<option value="0">Seleccione una opción</option>
								{foreach from=$arrTipoModalidadDesembolso key=seqTipoModalidadDesembolso item=txtTipoModalidadDesembolso}
									<option value="{$seqTipoModalidadDesembolso}" {if $arrDesembolso.seqTipoModalidadDesembolso == $seqTipoModalidadDesembolso} selected {/if}>{$txtTipoModalidadDesembolso}</option>
								{/foreach}
							</select>
						</td>
						<td colspan='2'></td>
						<!--<td id="tituloFiduciaria" width="25%" style="display:none">Fiduciaria</td>
						<td id="campoFiduciaria" width="25%" style="display:none">
							<select name="seqFiduciaria[{$actual}]"
								id="seqFiduciaria[{$actual}]"
								style="width:190px" >
								<option value="0">Seleccione una opción</option>
								{foreach from=$arrFiduciaria key=seqFiduciaria item=txtNombreFiduciaria}
									<option value="{$seqFiduciaria}" {if $arrDesembolso.seqFiduciaria == $seqFiduciaria} selected {/if}>{$txtNombreFiduciaria}</option>
								{/foreach}
							</select>
						</td>-->
					</tr>
					<tr>
						<td>No. de Contrato Suscrito</td>
						<td><input name="numContratoSuscrito[{$actual}]" type="text" id="numContratoSuscrito[{$actual}]" value="{$arrDesembolso.numContratoSuscrito}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;" /></td>
						<td>Fecha Contrato Suscrito</td>
						<td><input name="fchContratoSuscrito[{$actual}]" type="text" id="fchContratoSuscrito[{$actual}]" value="{$arrDesembolso.fchContratoSuscrito}" size="12" readonly /> 
							<a href="#" onClick="javascript: calendarioPopUp( 'fchContratoSuscrito[{$actual}]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
						</td>
					</tr>
					<tr>
						<td>Entidad Financiera</td>
						<td><input name="txtNombreEntidadFinanciera[{$actual}]" type="text" id="txtNombreEntidadFinanciera[{$actual}]" value="{$arrDesembolso.txtNombreEntidadFinanciera}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;" /></td>
						<td>Nit Entidad Financiera</td>
						<td><input name="numNitEntidadFinanciera[{$actual}]" type="text" id="numNitEntidadFinanciera[{$actual}]" value="{$arrDesembolso.numNitEntidadFinanciera}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:190px;" /></td>
					</tr>
					<tr>
						<td>No. de Cuenta</td>
						<td><input name="numCuenta[{$actual}]" type="text" id="numCuenta[{$actual}]" value="{$arrDesembolso.numCuenta}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;" /></td>
						<td>Tipo de Cuenta</td>
						<td><select name="seqTipoCuenta[{$actual}]"
								id="seqTipoCuenta[{$actual}]"
								style="width:190px" >
								<option value="0">Seleccione una opción</option>
								{foreach from=$arrTipoCuenta key=seqTipoCuenta item=txtTipoCuenta}
									<option value="{$seqTipoCuenta}" {if $arrDesembolso.seqTipoCuenta == $seqTipoCuenta} selected {/if}>{$txtTipoCuenta}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<td>Banco de la Cuenta</td>
						<td><select name="seqBancoCuenta[{$actual}]"
								id="seqBancoCuenta[{$actual}]"
								style="width:200px" >
								<option value="0">Seleccione una opción</option>
								{foreach from=$arrBanco key=seqBanco item=txtBanco}
									<option value="{$seqBanco}" {if $arrDesembolso.seqBancoCuenta == $seqBanco} selected {/if}>{$txtBanco}</option>
								{/foreach}
							</select></td>
						<td	colspan="2"></td>
					</tr>
					<tr>
						<td>Valor Total Giro Anticipado</td>
						<td>$ <input name="valTotalGiroAnticipado[{$actual}]" type="text" id="valTotalGiroAnticipado[{$actual}]" value="{$arrDesembolso.valTotalGiroAnticipado}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:90px;" /></td>
						<td	colspan="2"></td>
					</tr>
					<tr>
						<td>Saldo Por Girar</td>
						<td>$ <input name="valSaldoGiro[{$actual}]" type="text" id="valSaldoGiro[{$actual}]" value="{$arrDesembolso.valSaldoGiro}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:90px;" /></td>
						<td>N&uacute;mero del Pago</td>
						<td><input name="valNumeroPago[{$actual}]" type="text" id="valNumeroPago[{$actual}]" value="{$arrDesembolso.valNumeroPago}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:90px;" /></td>
					</tr>
					<tr>
						<td>Observaci&oacute;n</td>
						<td colspan='3'><textarea name="txtObservacion[{$actual}]" id="txtObservacion[{$actual}]" style="width: 590px" onBlur="sinCaracteresEspeciales( this );">{$arrDesembolso.txtObservacion}</textarea></td>
					</tr>
				</table>
			</div>
		</div>
		</td>
		<td align="center" width="10%" valign="top" style="padding:6px;">
			<input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'>
		</td></tr></table>
			<!--{counter print=false}
			{assign var="actual" value="r_$num"}
			<div class="accordionItem">
				<h2>How to use a JavaScript accordion</h2>
				<div>
					<table>
						<tr>
							<td align="center" width="18%" valign="top" style="padding:6px;">
								{counter print=false}
								{assign var="actual" value="r_$num"}
								<input type="hidden" name="seqCronogramaFecha[{$actual}]" id="seqCronogramaFecha" value="{$arrCronograma.seqCronogramaFecha}" >
								Num. <input name="numActaDescriptiva[{$actual}]" type="text" id="numActaDescriptiva[{$actual}]" value="{$arrCronograma.numActaDescriptiva}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" size="6" style="text-align:center" />
								 A&ntilde;o <input name="numAnoActaDescriptiva[{$actual}]" type="text" id="numAnoActaDescriptiva[{$actual}]" value="{$arrCronograma.numAnoActaDescriptiva}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" size="6" style="text-align:center" />
							</td>
							<td align="center" width="10%" valign="top" style="padding:6px;">
								<input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'>
							</td>
						</tr>
					</table>
				</div>
			</div>-->
		{/foreach}
	</td></tr></table>
</div>
</p>