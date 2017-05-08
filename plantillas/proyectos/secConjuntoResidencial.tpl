<p>
	<table border="0" cellspacing="2" cellpadding="0" width="860">
		<tr><td class="tituloTabla" colspan="7">CONJUNTO RESIDENCIAL</td></tr>
		<tr><td colspan="7" align="right"><div onClick="addConjuntoResidencial()" style="cursor: hand">Adicionar Conjunto Residencial&nbsp;<img src="recursos/imagenes/plus_icon.gif"></div></td></tr>
	</table>
	<div style="width:860px; overflow: scroll;">
		<table border="0" cellspacing="2" cellpadding="0" width="100%" id="tablaConjuntoResidencial">
			<tr class="tituloTabla">
				<th align="center" style="padding:6px;">Nombre</th>
				<th align="center" style="padding:6px;">Nombre Comercial</th>
				<th align="center" style="padding:6px;">&nbsp;&nbsp;Direcci&oacute;n&nbsp;del&nbsp;Conjunto&nbsp;&nbsp;&nbsp;</th>
				<th align="center" style="padding:6px;">Unidades</th>
				<th align="center" style="padding:6px;">Chip</th>
				<th align="center" style="padding:6px;">Matr&iacute;cula Inmobiliaria</th>
				<th align="center" style="padding:6px;">Lic. Urbanismo</th>
				<th align="center" style="padding:6px;">Fecha&nbsp;Licencia</th>
				<th align="center" style="padding:6px;">Vigencia&nbsp;Licencia</th>
				<th align="center" style="padding:6px;">Curadur&iacute;a</th>
				<th align="center" style="padding:6px;">Lic. Construcci&oacute;n</th>
				<th align="center" style="padding:6px;">Fecha&nbsp;Licencia</th>
				<th align="center" style="padding:6px;">Vigencia&nbsp;Licencia</th>
				<th align="center" style="padding:6px;">Vendedor</th>
				<th align="center" style="padding:6px;">NIT Vendedor</th>
				<th align="center" style="padding:6px;">C&eacute;dula Catastral</th>
				<th align="center" style="padding:6px;">No. Escritura</th>
				<th align="center" style="padding:6px;">Fecha&nbsp;Escritura</th>
				<th align="center" style="padding:6px;">No. Notar&iacute;a</th>
				<th align="center" style="padding:6px;"></th>
			</tr>
			{assign var="num" value="0"}
			{counter start=0 print=false assign=num}
			{foreach from=$arrConjuntoResidencial key=seqProyecto item=arrConjunto}
				{if $num++%2 == 0} <tr class="fila_0">
				{else} <tr class="fila_1">
				{/if}
					<td align="left" style="padding:6px">
						{counter print=false}
						{assign var="actual" value="r_$num"}
						<input type="hidden" name="seqProyectoHijo[{$actual}]" id="seqProyectoHijo" value="{$arrConjunto.seqProyecto}" >
						<input type="hidden" name="seqProyectoPadre[{$actual}]" id="seqProyectoPadre" value="{$arrConjunto.seqProyectoPadre}" >
						<input type="text" name="txtNombreProyectoHijo[{$actual}]" id="txtNombreProyectoHijo" value="{$arrConjunto.txtNombreProyecto}" size='28' onblur="sinCaracteresEspeciales( this );">
					</td>
					<td align="center" style="padding:6px">
						<input type="text" name="txtNombreComercialHijo[{$actual}]" id="txtNombreComercialHijo" value="{$arrConjunto.txtNombreComercial}" size='28' onblur="sinCaracteresEspeciales( this );">
					</td>
					<td align="center" style="padding:6px">
						<a href="#" onClick="recogerDireccion( 'txtDireccionHijo[{$actual}]', 'objDireccionOculto' )"><img src="recursos/imagenes/icono_lupa.gif"></a>
						<input type="text" name='txtDireccionHijo[{$actual}]' id="txtDireccionHijo[{$actual}]" value="{$arrConjunto.txtDireccion}" size="20" style="background-color:#E4E4E4;" readonly />
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='valNumeroSolucionesHijo[{$actual}]' id='valNumeroSolucionesHijo' value="{$arrConjunto.valNumeroSoluciones}" onBlur='sinCaracteresEspeciales( this );' size='6' >
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='txtChipLoteHijo[{$actual}]' id='txtChipLoteHijo' value="{$arrConjunto.txtChipLote}" onBlur='sinCaracteresEspeciales( this );' size='13' >
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='txtMatriculaInmobiliariaLoteHijo[{$actual}]' id='txtMatriculaInmobiliariaLoteHijo' value="{$arrConjunto.txtMatriculaInmobiliariaLote}" size='13' onBlur='sinCaracteresEspeciales( this );' >
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='txtLicenciaUrbanismoHijo[{$actual}]' id='txtLicenciaUrbanismoHijo' value="{$arrConjunto.txtLicenciaUrbanismo}" onBlur='sinCaracteresEspeciales( this );' size='18' >
					</td>
					<td align="center" style="padding:6px">
						<input name="fchLicenciaUrbanismo1Hijo[{$actual}]" type="text" id="fchLicenciaUrbanismo1Hijo[{$actual}]" value="{$arrConjunto.fchLicenciaUrbanismo1}" size="8" style="text-align:center; background-color:#E4E4E4" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchLicenciaUrbanismo1Hijo[{$actual}]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
					</td>
					<td align="center" style="padding:6px">
						<input name="fchVigenciaLicenciaUrbanismoHijo[{$actual}]" type="text" id="fchVigenciaLicenciaUrbanismoHijo[{$actual}]" value="{$arrConjunto.fchVigenciaLicenciaUrbanismo}" size="8" style="text-align:center; background-color:#E4E4E4" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchVigenciaLicenciaUrbanismoHijo[{$actual}]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='txtExpideLicenciaUrbanismoHijo[{$actual}]' id='txtExpideLicenciaUrbanismoHijo' value="{$arrConjunto.txtExpideLicenciaUrbanismo}" onBlur='sinCaracteresEspeciales( this );' size='13' >
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='txtLicenciaConstruccionHijo[{$actual}]' id='txtLicenciaConstruccionHijo' value="{$arrConjunto.txtLicenciaConstruccion}" onBlur='sinCaracteresEspeciales( this );' size='18' >
					</td>
					<td align="center" style="padding:6px">
						<input name="fchLicenciaConstruccion1Hijo[{$actual}]" type="text" id="fchLicenciaConstruccion1Hijo[{$actual}]" value="{$arrConjunto.fchLicenciaConstruccion1}" size="8" style="text-align:center; background-color:#E4E4E4" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchLicenciaConstruccion1Hijo[{$actual}]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
					</td>
					<td align="center" style="padding:6px">
						<input name="fchVigenciaLicenciaConstruccionHijo[{$actual}]" type="text" id="fchVigenciaLicenciaConstruccionHijo[{$actual}]" value="{$arrConjunto.fchVigenciaLicenciaConstruccion}" size="8" style="text-align:center; background-color:#E4E4E4" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchVigenciaLicenciaConstruccionHijo[{$actual}]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='txtNombreVendedorHijo[{$actual}]' id='txtNombreVendedorHijo' value="{$arrConjunto.txtNombreVendedor}" onBlur='sinCaracteresEspeciales( this );' size='20' >
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='numNitVendedorHijo[{$actual}]' id='numNitVendedorHijo' value="{$arrConjunto.numNitVendedor}" onBlur='sinCaracteresEspeciales( this );' size='12' >
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='txtCedulaCatastralHijo[{$actual}]' id='txtCedulaCatastralHijo' value="{$arrConjunto.txtCedulaCatastral}" onBlur='sinCaracteresEspeciales( this );' size='22' >
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='txtEscrituraHijo[{$actual}]' id='txtEscrituraHijo' value="{$arrConjunto.txtEscritura}" onBlur='sinCaracteresEspeciales( this );' size='12' >
					</td>
					<td align="center" style="padding:6px">
						<input name="fchEscrituraHijo[{$actual}]" type="text" id="fchEscrituraHijo[{$actual}]" value="{$arrConjunto.fchEscritura}" size="8" style="text-align:center; background-color:#E4E4E4" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchEscrituraHijo[{$actual}]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='numNotariaHijo[{$actual}]' id='numNotariaHijo' value="{$arrConjunto.numNotaria}" onBlur='sinCaracteresEspeciales( this );' size='12' >
					</td>
					<td align="center" style="padding:6px;">
						<input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'>
					</td>
				</tr>
			{/foreach}
		</table>
	</div>
</p>