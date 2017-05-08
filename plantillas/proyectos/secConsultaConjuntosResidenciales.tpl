<p>
	<table border="0" cellspacing="2" cellpadding="0" width="860">
		<tr><td class="tituloTabla" colspan="7">CONJUNTO RESIDENCIAL</td></tr>
	</table>
	<div style="width:860px; overflow: scroll;">
		<table border="0" cellspacing="2" cellpadding="0" width="100%" id="tablaConjuntoResidencial">
			<tr class="tituloTabla">
				<th align="center" style="padding:6px;">Nombre&nbsp;del&nbsp;Conjunto</th>
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
				<th align="center" style="padding:6px;">NIT&nbsp;Vendedor</th>
				<th align="center" style="padding:6px;">C&eacute;dula&nbsp;Catastral</th>
				<th align="center" style="padding:6px;">No. Escritura</th>
				<th align="center" style="padding:6px;">Fecha Escritura</th>
				<th align="center" style="padding:6px;">No. Notar&iacute;a</th>
			</tr>
			{assign var="num" value="0"}
			{counter start=0 print=false assign=num}
			{foreach from=$arrConjuntoResidencial key=seqProyecto item=arrConjunto}
				{if $num++%2 == 0} <tr class="fila_0">
				{else} <tr class="fila_1">
				{/if}
					<td align="left" style="padding:6px">{$arrConjunto.txtNombreProyecto}</td>
					<td align="left" style="padding:6px">{$arrConjunto.txtNombreComercial}</td>
					<td align="center" style="padding:6px">{$arrConjunto.txtDireccion}</td>
					<td align="center" style="padding:6px">{$arrConjunto.valNumeroSoluciones}</td>
					<td align="center" style="padding:6px">{$arrConjunto.txtChipLote}</td>
					<td align="center" style="padding:6px">{$arrConjunto.txtMatriculaInmobiliariaLote}</td>
					<td align="center" style="padding:6px">{$arrConjunto.txtLicenciaUrbanismo}</td>
					<td align="center" style="padding:6px">{$arrConjunto.fchLicenciaUrbanismo1}</td>
					<td align="center" style="padding:6px">{$arrConjunto.fchVigenciaLicenciaUrbanismo}</td>
					<td align="center" style="padding:6px">{$arrConjunto.txtExpideLicenciaUrbanismo}</td>
					<td align="center" style="padding:6px">{$arrConjunto.txtLicenciaConstruccion}</td>
					<td align="center" style="padding:6px">{$arrConjunto.fchLicenciaConstruccion1}</td>
					<td align="center" style="padding:6px">{$arrConjunto.fchVigenciaLicenciaConstruccion}</td>
					<td align="center" style="padding:6px">{$arrConjunto.txtNombreVendedor}</td>
					<td align="center" style="padding:6px">{$arrConjunto.numNitVendedor}</td>
					<td align="center" style="padding:6px">{$arrConjunto.txtCedulaCatastral}</td>
					<td align="center" style="padding:6px">{$arrConjunto.txtEscritura}</td>
					<td align="center" style="padding:6px">{$arrConjunto.fchEscritura}</td>
					<td align="center" style="padding:6px">{$arrConjunto.numNotaria}</td>
				</tr>
			{/foreach}
		</table>
	</div>
</p>