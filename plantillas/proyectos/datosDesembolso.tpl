<!-- PLANTILLA DE DESEMBOLSO CON PESTAÑAS -->
<form name="frmDesembolso" id="frmDesembolso" onSubmit="pedirConfirmacion('mensajes', this, './contenidos/proyectos/pedirConfirmacion.php'); return false;" autocomplete=off >

<!-- CODGIO PARA EL POP UP DE SEGUIMIENTO -->
	{assign var=seqPryEstadoProceso value=$objFormularioProyecto->seqPryEstadoProceso}
<!-- TAB VIEW DE DATOS DE DESEMBOLSO -->
	<div id="desembolsos" style="height:550px;" ><p>
		<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
			<tr><td>Proyecto</td>
				<td colspan="3">{$objFormularioProyecto->txtNombreProyecto}</td>
			</tr>
			<tr><td class="tituloTabla" colspan="4" align="center">Beneficiario del Giro Anticipado</td></tr>
			<tr><td width="25%">Nombre del Vendedor</td>
				<td width="25%"><input name="txtNombreVendedor" type="text" id="txtNombreVendedor" value="{$objFormularioProyecto->txtNombreVendedor}" onBlur="sinCaracteresEspeciales( this );"  style="width:200px;" /></td>
				<td width="25%">NIT del Vendedor</td>
				<td width="25%"><input name="numNitVendedor" type="text" id="numNitVendedor" value="{$objFormularioProyecto->numNitVendedor}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:190px;" /></td>
			</tr>
			<tr><td width="25%">Tel&eacute;fono del Vendedor</td>
				<td width="25%"><input name="numTelefonoVendedor" type="text" id="numTelefonoVendedor" value="{$objFormularioProyecto->numTelefonoVendedor}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );"  style="width:200px;" /></td>
				<td width="25%">Correo Electr&oacute;nico del Vendedor</td>
				<td width="25%"><input name="txtCorreoVendedor" type="text" id="txtCorreoVendedor" value="{$objFormularioProyecto->txtCorreoVendedor}" onBlur="sinCaracteresEspeciales( this )" style="width:190px;" /></td>
			</tr>
			<tr><td>Beneficiario del Giro</td>
				<td><input name="txtNombreBeneficiarioGiro" type="text" id="txtNombreBeneficiarioGiro" value="{$objFormularioProyecto->txtNombreBeneficiarioGiro}" onBlur="sinCaracteresEspeciales( this );"  style="width:200px;" /></td>
				<td>NIT del Beneficiario del Giro</td>
				<td><input name="numNitBeneficiarioGiro" type="text" id="numNitBeneficiarioGiro" value="{$objFormularioProyecto->numNitBeneficiarioGiro}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:190px;" /></td>
			</tr>
			<tr>
				<td>Costo del Proyecto</td>
				<td>$ <input name="valCostoProyecto" type="text" id="valCostoProyecto" value="{$objFormularioProyecto->valCostoProyecto}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';" style="width:90px;" /></td>
				<td>N&uacute;mero Soluciones</td>
				<td><input name="valNumeroSoluciones" type="text" id="valNumeroSoluciones" value="{$objFormularioProyecto->valNumeroSoluciones}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:77px;" /></td>
			</tr>
			<tr>
				<td>Valor del Desembolso</td>
				<td>$ <input name="valDesembolso" type="text" id="valDesembolso" value="{$objFormularioProyecto->valDesembolso}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:90px;" /></td>
				<td	colspan="2"></td>
			</tr>
			<tr><td class="tituloTabla" colspan="4" align="center">Informaci&oacute;n del Giro Anticipado</td></tr>
			<tr><td width="25%">Modalidad del Desembolso</td>
				<td width="25%">
					<select name="seqTipoModalidadDesembolso"
						id="seqTipoModalidadDesembolso"
						style="width:200px"
						>
						<option value="0">Seleccione una opción</option>
						{foreach from=$arrTipoModalidadDesembolso key=seqTipoModalidadDesembolso item=txtTipoModalidadDesembolso}
							<option value="{$seqTipoModalidadDesembolso}" {if $objFormularioProyecto->seqTipoModalidadDesembolso == $seqTipoModalidadDesembolso} selected {/if}>{$txtTipoModalidadDesembolso}</option>
						{/foreach}
					</select>
				</td>
				<td id="tituloFiduciaria" width="25%" style="display:none">Fiduciaria</td>
				<td id="campoFiduciaria" width="25%" style="display:none">
					<select name="seqFiduciaria"
						id="seqFiduciaria"
						style="width:190px" >
						<option value="0">Seleccione una opción</option>
						{foreach from=$arrFiduciaria key=seqFiduciaria item=txtNombreFiduciaria}
							<option value="{$seqFiduciaria}" {if $objFormularioProyecto->seqFiduciaria == $seqFiduciaria} selected {/if}>{$txtNombreFiduciaria}</option>
						{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<td>No. de Contrato Suscrito</td>
				<td><input name="numContratoSuscrito" type="text" id="numContratoSuscrito" value="{$objFormularioProyecto->numContratoSuscrito}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;" /></td>
				<td>Fecha Contrato Suscrito</td>
				<td><input name="fchContratoSuscrito" type="text" id="fchContratoSuscrito" value="{$objFormularioProyecto->fchContratoSuscrito}" size="12" readonly /> 
					<a href="#" onClick="javascript: calendarioPopUp( 'fchContratoSuscrito' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
				</td>
			</tr>
			<tr>
				<td>Nombre de la Entidad Financiera</td>
				<td><input name="txtNombreEntidadFinanciera" type="text" id="txtNombreEntidadFinanciera" value="{$objFormularioProyecto->txtNombreEntidadFinanciera}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;" /></td>
				<td>Nit de la Entidad Financiera</td>
				<td><input name="numNitEntidadFinanciera" type="text" id="numNitEntidadFinanciera" value="{$objFormularioProyecto->numNitEntidadFinanciera}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;" /></td>
			</tr>
			<tr>
				<td>No. de Cuenta</td>
				<td><input name="numCuenta" type="text" id="numCuenta" value="{$objFormularioProyecto->numCuenta}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;" /></td>
				<td>Tipo de Cuenta</td>
				<td><select name="seqTipoCuenta"
						id="seqTipoCuenta"
						style="width:190px" >
						<option value="0">Seleccione una opción</option>
						{foreach from=$arrTipoCuenta key=seqTipoCuenta item=txtTipoCuenta}
							<option value="{$seqTipoCuenta}" {if $objFormularioProyecto->seqTipoCuenta == $seqTipoCuenta} selected {/if}>{$txtTipoCuenta}</option>
						{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<td>Banco de la Cuenta</td>
				<td><input name="seqBancoCuenta" type="text" id="seqBancoCuenta" value="{$objFormularioProyecto->seqBancoCuenta}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:190px;" /></td>
				<td	colspan="2"></td>
			</tr>
			<tr>
				<td>Valor Total del Giro Anticipado</td>
				<td>$ <input name="valTotalGiroAnticipado" type="text" id="valTotalGiroAnticipado" value="{$objFormularioProyecto->valTotalGiroAnticipado}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:90px;" /></td>
				<td	colspan="2"></td>
			</tr>
			<tr>
				<td>Saldo Por Girar</td>
				<td>$ <input name="valSaldoGiro" type="text" id="valSaldoGiro" value="{$objFormularioProyecto->valSaldoGiro}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:90px;" /></td>
				<td>N&uacute;mero del Pago</td>
				<td><input name="valNumeroPago" type="text" id="valNumeroPago" value="{$objFormularioProyecto->valNumeroPago}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:190px;" /></td>
			</tr>
		</table>
	</p></div>

<!-- SEGUIMIENTO AL PROYECTO -->
<div id="seg" style="height:401px; overflow:auto; display:none">
	{include file="seguimientoProyectos/seguimientoFormulario.tpl"}
	<div id="contenidoBusqueda" >
		{include file="seguimientoProyectos/buscarSeguimiento.tpl"}
	</div>
</div>

<input type="hidden" id="seqProyectoEditar" name="seqProyectoEditar" value="{$objFormularioProyecto->seqProyecto}">
<input type="hidden" name="txtArchivo" value="./contenidos/proyectos/salvarDesembolso.php">
<input type="hidden" name="txtCiudadanoAtendido" value="{$txtCiudadanoAtendido}">
<input type="hidden" name="numDocumentoAtendido" value="{$numDocumento}">

</form>

<div id="desembolsoPryTabView"></div>
<div id="objDireccionOculto" style="display:none"></div>
<div id="objDireccionOcultoSolucion" style="display:none"></div>