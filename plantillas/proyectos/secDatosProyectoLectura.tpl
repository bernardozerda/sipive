<table cellspacing="0" cellpadding="2" border="0" width="100%">

		<tr><td class="tituloTabla" colspan="4">DATOS DEL OFERENTE<img src="recursos/imagenes/blank.gif" onload="escondetxtDireccion(); escondetxtDescEquipamientoComunal(); escondeLineaConstructor(); escondeCamposTipoPersona();">
		<img src="recursos/imagenes/blank.gif" onload="escondeLineaOpv();"></td></tr>

		<tr><td><b>Nombre</b></td>
			<td>{$objFormularioProyecto->txtNombreOferente}<input name="txtNombreOferente" type="hidden" id="txtNombreOferente" value="{$objFormularioProyecto->txtNombreOferente}" /></td>
			<td><b>Nit o C&eacute;dula</b></td>
			<td>{$objFormularioProyecto->numNitOferente}<input name="numNitOferente" type="hidden" id="numNitOferente" value="{$objFormularioProyecto->numNitOferente}" /></td>
		</tr>
		<tr><td><b>Nombre de Contacto</b></td>
			<td>{$objFormularioProyecto->txtNombreContactoOferente}<input name="txtNombreContactoOferente" type="hidden" id="txtNombreContactoOferente" value="{$objFormularioProyecto->txtNombreContactoOferente}" /></td>
			<td><b>Tel&eacute;fono Fijo de Contacto</b></td>
			<td>{$objFormularioProyecto->numTelefonoOferente}<input name="numTelefonoOferente" type="hidden" id="numTelefonoOferente" value="{$objFormularioProyecto->numTelefonoOferente}" /> 
				{if $objFormularioProyecto->numExtensionOferente != "" }
					{if $objFormularioProyecto->numExtensionOferente != 0 }
						Ext. {$objFormularioProyecto->numExtensionOferente}<input name="numExtensionOferente" type="hidden" id="numExtensionOferente" value="{$objFormularioProyecto->numExtensionOferente}" />
					{/if}
				{/if}
			</td>
		</tr>
		<tr>
			<td><b>Celular de Contacto</b></td>
			<td>{$objFormularioProyecto->numCelularOferente}<input name="numCelularOferente" type="hidden" id="numCelularOferente" value="{$objFormularioProyecto->numCelularOferente}" /></td>
			<td><b>Correo de Contacto</b></td>
			<td>{$objFormularioProyecto->txtCorreoOferente}<input name="txtCorreoOferente" type="hidden" id="txtCorreoOferente" value="{$objFormularioProyecto->txtCorreoOferente}" />
			</td>
		</tr>
		<tr>
			<!-- PREGUNTA SI EL OFERENTE ES CONSTRUCTOR -->
			<td><b>El oferente es constructor?</b></td>
			<td>
				{if $objFormularioProyecto->bolConstructor == 0} Si {/if}
				{if $objFormularioProyecto->bolConstructor == 1} No {/if}
				<input name="bolConstructor" type="radio" onClick="escondeLineaConstructor()" id="bolConstructor" style="display:none" value="0" {if $objFormularioProyecto->bolConstructor == 0} checked {/if}/> 
				<input name="bolConstructor" type="radio" onClick="escondeLineaConstructor()" id="bolConstructor" style="display:none" value="1" {if $objFormularioProyecto->bolConstructor == 1} checked {/if} /> 
			</td>
			<!-- CONSTRUCTOR -->
			<td id="idTituloConstructor" style="display:none"><b>Constructor</b></td>
			<td id="idComboConstructor" style="display:none">{foreach from=$arrConstructor key=seqConstructor item=txtNombreConstructor}{if $objFormularioProyecto->seqConstructor == $seqConstructor} {$txtNombreConstructor} {/if}{/foreach}
				<select name="seqConstructor"
						id="seqConstructor"
						style="width:200px; display:none" >
						<option value="0">Seleccione una opción</option>
						{foreach from=$arrConstructor key=seqConstructor item=txtNombreConstructor}
							<option value="{$seqConstructor}" {if $objFormularioProyecto->seqConstructor == $seqConstructor} selected {/if}>{$txtNombreConstructor}</option>
						{/foreach}
				</select>
			</td>
		</tr>
		
		<tr><td class="tituloTabla" colspan="4">DATOS DEL REPRESENTANTE LEGAL</td></tr>
		<tr><td><b>Representante Legal</b></td>
			<td>{$objFormularioProyecto->txtRepresentanteLegalOferente}<input name="txtRepresentanteLegalOferente" type="hidden" id="txtRepresentanteLegalOferente" value="{$objFormularioProyecto->txtRepresentanteLegalOferente}" /></td>
			<td><b>Nit Representante Legal</b></td>
			<td>{$objFormularioProyecto->numNitRepresentanteLegalOferente}<input name="numNitRepresentanteLegalOferente" type="hidden" id="numNitRepresentanteLegalOferente" value="{$objFormularioProyecto->numNitRepresentanteLegalOferente}" /></td>
		</tr>
		<tr><td><b>Tel&eacute;fono Fijo</b></td>
			<td>{$objFormularioProyecto->numTelefonoRepresentanteLegalOferente}
			<input name="numTelefonoRepresentanteLegalOferente" type="hidden" id="numTelefonoRepresentanteLegalOferente" value="{$objFormularioProyecto->numTelefonoRepresentanteLegalOferente}" /> 
			{if $objFormularioProyecto->numExtensionRepresentanteLegalOferente != "" } 
					{if $objFormularioProyecto->numExtensionRepresentanteLegalOferente != 0 } 
						Ext. {$objFormularioProyecto->numExtensionRepresentanteLegalOferente}<input name="numExtensionRepresentanteLegalOferente" type="hidden" id="numExtensionRepresentanteLegalOferente" value="{$objFormularioProyecto->numExtensionRepresentanteLegalOferente}" />
					{/if}
				{/if}
			</td>
			<td><b>Tel&eacute;fono Celular</b></td>
			<td>{$objFormularioProyecto->numCelularRepresentanteLegalOferente}
			<input name="numCelularRepresentanteLegalOferente" type="hidden" id="numCelularRepresentanteLegalOferente" value="{$objFormularioProyecto->numCelularRepresentanteLegalOferente}" />
			</td>
		</tr>
		<tr>
			<td><b>Direcci&oacute;n</b></td>
			<td>{$objFormularioProyecto->txtDireccionRepresentanteLegalOferente}
				<input type="hidden" 
						name="txtDireccionRepresentanteLegalOferente" 
						id="txtDireccionRepresentanteLegalOferente" 
						value="{$objFormularioProyecto->txtDireccionRepresentanteLegalOferente}" 
						style="width:200px;"
						/>
				<input type="hidden" id="txtLatitudLongitud" name="txtLatitudLongitud" value="{$objFormularioProyecto->txtLatitudLongitud}">
			</td>
			<td><b>Correo electr&oacute;nico</b></td>
			<td>{$objFormularioProyecto->txtCorreoRepresentanteLegalOferente}
			<input name="txtCorreoRepresentanteLegalOferente" type="hidden" id="txtCorreoRepresentanteLegalOferente" value="{$objFormularioProyecto->txtCorreoRepresentanteLegalOferente}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/>
			</td>
			<td colspan="2"></td>
		</tr>
		
	
	<tr><td class="tituloTabla" colspan="4">DATOS DEL PROYECTO
	<img src="recursos/imagenes/blank.gif" onload="escondetxtDescEquipamientoComunal(); escondeLineaConstructor(); escondeCamposTipoPersona(); escondeLineaOpv(); escondeOperador();">
	<img src="recursos/imagenes/blank.gif" onload="escondeSeccionAprobacion(); muestraCondicionAprobacion();">
	</td></tr>
		<tr>
			<!-- NOMBRE DEL PROYECTO -->
			<td><b>Nombre del Proyecto</b></td>
			<td>{$objFormularioProyecto->txtNombreProyecto}
				<input name="txtNombreProyecto" type="hidden" id="txtNombreProyecto" value="{$objFormularioProyecto->txtNombreProyecto}" />
			</td>
			<!-- PLAN PARCIAL -->
			<td><b>Nombre del Plan Parcial</b></td>
			<td>{if $arrPrivilegios.editar == 1}
					{assign var=soloLectura value=""}
				{else}
					{assign var=soloLectura value="readonly"}
				{/if}
				<input type="hidden" 
						name="numNitProyecto" 
						id="numNitProyecto" 
						value="{$numNitProyecto}"
						onFocus="this.style.backgroundColor = '#ADD8E6';" 
						onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF'; "
						onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
						style="width:100px; text-align: right;"
						{$soloLectura} />
				{if $objFormularioProyecto->txtNombrePlanParcial == ""}
					Ninguno
				{else}
					{$objFormularioProyecto->txtNombrePlanParcial}
				{/if}
				<input name="txtNombrePlanParcial" type="hidden" id="txtNombrePlanParcial" value="{$objFormularioProyecto->txtNombrePlanParcial}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/>
			</td>
		</tr>
		<tr>
			<!-- TIPO DE ESQUEMA -->
			<td width="25%"><b>Tipo de Esquema</b></td>
			<td width="25%">
				{foreach from=$arrTipoEsquema key=seqTipoEsquema item=txtTipoEsquema}{if $objFormularioProyecto->seqTipoEsquema == $seqTipoEsquema} {$txtTipoEsquema} {/if}{/foreach}
				<select name="seqTipoEsquema"
						id="seqTipoEsquema"
						style="width:200px; display:none"
						onChange="obtenerModalidad(this); escondeLineaOpv(); escondeOperador()" >
						<option value="0">Seleccione una opción</option>
						{foreach from=$arrTipoEsquema key=seqTipoEsquema item=txtTipoEsquema}
							<option value="{$seqTipoEsquema}" {if $objFormularioProyecto->seqTipoEsquema == $seqTipoEsquema} selected {/if}>{$txtTipoEsquema}</option>
						{/foreach}
				</select>
			</td>

			<!-- TIPO DE MODALIDAD -->
			<td width="25%"><b>Tipo de Modalidad</b></td>
			<td id="tdModalidad" width="25%">
				{foreach from=$arrPryTipoModalidad key=seqPryTipoModalidad item=txtPryTipoModalidad}{if $objFormularioProyecto->seqPryTipoModalidad == $seqPryTipoModalidad} {$txtPryTipoModalidad} {/if}{/foreach}
				<select name="seqPryTipoModalidad"
						id="seqPryTipoModalidad"
						style="width:200px; display:none" >
						<option value="0">Seleccione una opción</option>
						{foreach from=$arrPryTipoModalidad key=seqPryTipoModalidad item=txtPryTipoModalidad}
							<option value="{$seqPryTipoModalidad}" {if $objFormularioProyecto->seqPryTipoModalidad == $seqPryTipoModalidad} selected {/if}>{$txtPryTipoModalidad}</option>
						{/foreach}
				</select>
			</td>
		</tr>
		<tr id="lineaOpv">
			<!-- NOMBRE DE LA OPV -->
			<td><b>Nombre de la OPV</b></td>
			<td colspan="3" >
				{foreach from=$arrOpv key=seqOpv item=txtNombreOpv}{if $objFormularioProyecto->seqOpv == $seqOpv} {$txtNombreOpv} {/if}{/foreach}
				<select name="seqOpv"
						id="seqOpv"
						style="width:200px; display:none" >
						<option value="0">Seleccione una opción</option>
						{foreach from=$arrOpv key=seqOpv item=txtNombreOpv}
							<option value="{$seqOpv}" {if $objFormularioProyecto->seqOpv == $seqOpv} selected {/if}>{$txtNombreOpv}</option>
						{/foreach}
				</select>
			</td>
		</tr>
		<tr id="lineaTDirigida">
			<!-- OPERADOR -->
			<td><b>Nombre del Operador</b></td>
			<td colspan='3'>{$objFormularioProyecto->txtNombreOperador}
							<input name="txtNombreOperador" id="txtNombreOperador" type="hidden" value="{$objFormularioProyecto->txtNombreOperador}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;" /></td>
		</tr>
		<tr>
			<!-- TIPO DE PROYECTO -->
			<td><b>Tipo de Proyecto</b></td>
			<td>{foreach from=$arrTipoProyecto key=seqTipoProyecto item=txtTipoProyecto}{if $objFormularioProyecto->seqTipoProyecto == $seqTipoProyecto} {$txtTipoProyecto} {/if}{/foreach}
				<select name="seqTipoProyecto"
						id="seqTipoProyecto"
						style="width:200px; display: none" >
						<option value="0">Seleccione una opción</option>
						{foreach from=$arrTipoProyecto key=seqTipoProyecto item=txtTipoProyecto}
							<option value="{$seqTipoProyecto}" {if $objFormularioProyecto->seqTipoProyecto == $seqTipoProyecto} selected {/if}>{$txtTipoProyecto}</option>
						{/foreach}
				</select>
			</td>
			<!-- DESCRIPCION DEL PROYECTO -->
			<td rowspan="3" valign="top"><b>Descripci&oacute;n del Proyecto</b></td>
			<td rowspan="3" valign="top">{$objFormularioProyecto->txtDescripcionProyecto}
				<textarea name="txtDescripcionProyecto" rows="4" id="txtDescripcionProyecto" onBlur="sinCaracteresEspeciales( this );" style="width:200px; display:none" />{$objFormularioProyecto->txtDescripcionProyecto}</textarea>
			</td>
		</tr>
		<tr>
			<!-- TIPO DE URBANIZACION -->
			<td><b>Tipo de Urbanizaci&oacute;n</b></td>
			<td>{foreach from=$arrTipoUrbanizacion key=seqTipoUrbanizacion item=txtTipoUrbanizacion}{if $objFormularioProyecto->seqTipoUrbanizacion == $seqTipoUrbanizacion} {$txtTipoUrbanizacion} {/if}{/foreach}
				<select name="seqTipoUrbanizacion"
						id="seqTipoUrbanizacion"
						style="width:200px; display: none" >
						<option value="0">Seleccione una opción</option>
						{foreach from=$arrTipoUrbanizacion key=seqTipoUrbanizacion item=txtTipoUrbanizacion}
							<option value="{$seqTipoUrbanizacion}" {if $objFormularioProyecto->seqTipoUrbanizacion == $seqTipoUrbanizacion} selected {/if}>{$txtTipoUrbanizacion}</option>
						{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<!-- TIPO DE SOLUCION -->
			<td><b>Tipo de Soluci&oacute;n</b></td>
			<td>{foreach from=$arrTipoSolucion key=seqTipoSolucion item=txtTipoSolucion}{if $objFormularioProyecto->seqTipoSolucion == $seqTipoSolucion} {$txtTipoSolucion} {/if}{/foreach}
				<select name="seqTipoSolucion"
						id="seqTipoSolucion"
						style="width:200px; display: none" >
						<option value="0">Seleccione una opción</option>
						{foreach from=$arrTipoSolucion key=seqTipoSolucion item=txtTipoSolucion}
							<option value="{$seqTipoSolucion}" {if $objFormularioProyecto->seqTipoSolucion == $seqTipoSolucion} selected {/if}>{$txtTipoSolucion}</option>
						{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<!-- LOCALIDAD DEL PROYECTO -->
			<td><b>Localidad</b></td>
			<td>{foreach from=$arrLocalidad key=seqLocalidad item=txtLocalidad}{if $objFormularioProyecto->seqLocalidad == $seqLocalidad} {$txtLocalidad} {/if}{/foreach}
				<select name="seqLocalidad"
						id="seqlocalidad"
						style="width:200px; display: none" >
						<option value="0">Seleccione una opción</option>
						{foreach from=$arrLocalidad key=seqLocalidad item=txtLocalidad}
							<option value="{$seqLocalidad}" {if $objFormularioProyecto->seqLocalidad == $seqLocalidad} selected {/if}>{$txtLocalidad}</option>
						{/foreach}
				</select>
			</td>
			<!-- DIRECCION DEL PROYECTO -->
			<td><b>Direcci&oacute;n</b></td>
			<td>{$objFormularioProyecto->txtDireccion}
				<input type="hidden" 
						name="txtDireccion" 
						id="txtDireccion" 
						value="{$objFormularioProyecto->txtDireccion}" 
						style="width:200px;"
						/>
				<input type="hidden" id="txtLatitudLongitud" name="txtLatitudLongitud" value="{$objFormularioProyecto->txtLatitudLongitud}">
			</td>
		</tr>
		<tr><!-- BARRIO -->
			<td><b>Barrio</b></td>
			<td>{foreach from=$arrBarrio key=seqBarrio item=txtBarrio}{if $objFormularioProyecto->seqBarrio == $seqBarrio} {$txtBarrio} {/if}{/foreach}
				<select name="seqBarrio"
						id="seqBarrio"
						style="width:200px; display: none" >
						<option value="0">Seleccione una opción</option>
						{foreach from=$arrBarrio key=seqBarrio item=txtBarrio}
							<option value="{$seqBarrio}" {if $objFormularioProyecto->seqBarrio == $seqBarrio} selected {/if}>{$txtBarrio}</option>
						{/foreach}
				</select>
			</td>
			<!-- TORRES -->
			<td><b>Torres</b></td>
			<td>{$objFormularioProyecto->valTorres}
				<input name="valTorres" type="hidden" id="valTorres" value="{$objFormularioProyecto->valTorres}" />
			</td>
		</tr>
		<tr><!-- NUMERO DE SOLUCIONES -->
			<td><b>N&uacute;mero Soluciones</b></td>
			<td>{$objFormularioProyecto->valNumeroSoluciones}
				<input name="valNumeroSoluciones" type="hidden" id="valNumeroSoluciones" value="{$objFormularioProyecto->valNumeroSoluciones}"  />
				<input name="valSalarioMinimo" type="hidden" id="valSalarioMinimo" value="{$valSalarioMinimo}"/>
				<input name="numSubsidios" type="hidden" id="numSubsidios" value="{$numSubsidios}"/>
			</td>
			<!-- AREA CONSTRUIDA -->
			<td><b>Area a construir</b></td>
			<td>{$objFormularioProyecto->valAreaConstruida}
				<input name="valAreaConstruida" type="hidden" id="valAreaConstruida" value="{$objFormularioProyecto->valAreaConstruida}" />&nbsp;m²
			</td>
		</tr>
		<tr><!-- AREA LOTE -->
			<td><b>Area Lote</b></td>
			<td>{$objFormularioProyecto->valAreaLote}
				<input name="valAreaLote" type="hidden" id="valAreaLote" value="{$objFormularioProyecto->valAreaLote}" />&nbsp;m²
			</td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<!-- COSTO DEL PROYECTO -->
			<td><b>Costo estimado del Proyecto</b></td>
			<td>$ {$objFormularioProyecto->valCostoProyecto}
				<input name="valCostoProyecto" type="hidden" id="valCostoProyecto" value="{$objFormularioProyecto->valCostoProyecto}" />
			</td>
			<!-- VALOR CIERRE FINANCIERO -->
				<td><b>Valor Cierre Financiero</b></td>
				<td>$ {$objFormularioProyecto->valCierreFinanciero}<input name="valCierreFinanciero" type="hidden" id="valCierreFinanciero" value="{$objFormularioProyecto->valCierreFinanciero}" /></td>
		</tr>
		<tr>
			<!-- CHIP DEL PROYECTO -->
			<td><b>Chip Lote</b></td>
			<td>{$objFormularioProyecto->txtChipLote}
				<input name="txtChipLote" type="hidden" id="txtChipLote" value="{$objFormularioProyecto->txtChipLote}" />
			</td>
			<!-- MATRICULA INMOBILIARIA DEL PROYECTO -->
			<td><b>Matr&iacute;cula Inmobiliaria Lote</b></td>
			<td>{$objFormularioProyecto->txtMatriculaInmobiliariaLote}
				<input name="txtMatriculaInmobiliariaLote" type="hidden" id="txtMatriculaInmobiliariaLote" value="{$objFormularioProyecto->txtMatriculaInmobiliariaLote}" />
			</td>
		</tr>
		<tr>
			<!-- REGISTRO DE ENAJENACION -->
			<td><b>Registro de Enajenación</b></td>
			<td align="left">
				{$objFormularioProyecto->txtRegistroEnajenacion} <input name="txtRegistroEnajenacion" type="hidden" id="txtRegistroEnajenacion" value="{$objFormularioProyecto->txtRegistroEnajenacion}" />
			</td>
			<!-- FECHA REGISTRO DE ENAJENACION -->
			<td><b>Fecha Registro de Enajenación</b></td>
			<td>{$objFormularioProyecto->fchRegistroEnajenacion}
				<input name="fchRegistroEnajenacion" type="hidden" id="fchRegistroEnajenacion" value="{$objFormularioProyecto->fchRegistroEnajenacion}" size="12" /> 
			</td>
		<tr>	
			<!-- EQUIPAMIENTO COMUNAL -->
			<td valign="top"><b>Tiene Equipamiento Comunal?</b></td>
			<td valign="top" align="left">
				{if $objFormularioProyecto->bolEquipamientoComunal == 1} Si {/if} 
				{if $objFormularioProyecto->bolEquipamientoComunal == 0} No {/if} 
				<input name="bolEquipamientoComunal" type="radio" onClick="escondetxtDescEquipamientoComunal()" id="bolEquipamientoComunal" style="display:none" value="1" {if $objFormularioProyecto->bolEquipamientoComunal == 1} checked {/if} /> 
				<input name="bolEquipamientoComunal" type="radio" onClick="escondetxtDescEquipamientoComunal()" id="bolEquipamientoComunal" style="display:none" value="0" {if $objFormularioProyecto->bolEquipamientoComunal == 0} checked {/if}/> 
			</td>
			<!-- DESCRIPCION DE EQUIPAMIENTO COMUNAL -->
			<td id="idTituloDescEquipamientoComunal" name="idTituloDescEquipamientoComunal" valign="top"><b>Descripci&oacute;n Equipamiento Comunal</b></td>
			<td id="lineaDescEquipamientoComunal" name="lineaDescEquipamientoComunal" style="display:none">{$objFormularioProyecto->txtDescEquipamientoComunal}
				<textarea id="txtDescEquipamientoComunal" name="txtDescEquipamientoComunal" rows="3" onBlur="sinCaracteresEspeciales( this );" style="width:200px; display:none" />{$objFormularioProyecto->txtDescEquipamientoComunal}</textarea></td>
		</tr>

		<tr><td class="tituloTabla" colspan="4">COSTOS DEL PROYECTO</td></tr>
			<tr>
				<!-- VALOR COSTOS DIRECTOS -->
				<td><b>Valor Costos Directos</b></td>
				<td>$ {$objFormularioProyecto->valCostosDirectos}
					<input name="valCostosDirectos" type="hidden" id="valCostosDirectos" value="{$objFormularioProyecto->valCostosDirectos}"/></td>
				<!-- VALOR COSTOS INDIRECTOS -->
				<td><b>Valor Costos Indirectos</b></td>
				<td>$ {$objFormularioProyecto->valCostosIndirectos}<input name="valCostosIndirectos" type="hidden" id="valCostosIndirectos" value="{$objFormularioProyecto->valCostosIndirectos}" /></td>
			</tr>

			<tr>
				<!-- VALOR TERRENO -->
				<td><b>Valor Terreno</b></td>
				<td>$ {$objFormularioProyecto->valTerreno}<input name="valTerreno" type="hidden" id="valTerreno" value="{$objFormularioProyecto->valTerreno}" /></td>
				<!-- VALOR TOTAL PROYECTO VIP -->
				<td><b>Valor Total Proyecto VIP</b></td>
				<td>editar CON EL NUEVO FORMATO DE COSTOS</td>
			</tr>

		<tr><td class="tituloTabla" colspan="4">LICENCIA DE URBANISMO</td></tr>
		<tr>
			<!-- LICENCIA DE URBANISMO -->
			<td><b>N&uacute;mero de Licencia</b></td>
			<td>{$objFormularioProyecto->txtLicenciaUrbanismo}
				<input name="txtLicenciaUrbanismo" type="hidden" id="txtLicenciaUrbanismo" value="{$objFormularioProyecto->txtLicenciaUrbanismo}" style="width:200px;" /></td>
			<!-- EXPIDE LICENCIA DE URBANISMO -->
			<td><b>Expide</b></td>
			<td>{$objFormularioProyecto->txtExpideLicenciaUrbanismo}
				<input name="txtExpideLicenciaUrbanismo" type="hidden" id="txtExpideLicenciaUrbanismo" value="{$objFormularioProyecto->txtExpideLicenciaUrbanismo}" /></td>
		</tr>
		<tr>
			<!-- FECHA DE LICENCIA DE URBANISMO -->
			<td><b>Fecha de Licencia</b></td>
			<td>{$objFormularioProyecto->fchLicenciaUrbanismo1}
				<input name="fchLicenciaUrbanismo1" type="hidden" id="fchLicenciaUrbanismo1" value="{$objFormularioProyecto->fchLicenciaUrbanismo1}" size="12" /> 
			</td>
			<!-- VIGENCIA DE LICENCIA DE URBANISMO -->
			<td><b>Vigencia de Licencia</b></td>
			<td>{$objFormularioProyecto->fchVigenciaLicenciaUrbanismo}
				<input name="fchVigenciaLicenciaUrbanismo" type="hidden" id="fchVigenciaLicenciaUrbanismo" value="{$objFormularioProyecto->fchVigenciaLicenciaUrbanismo}" /></td>
		</tr>

		<tr>
			<!-- FECHA DE LICENCIA DE URBANISMO (PRIMERA AMPLIACION)-->
			<td><b>Fecha Pr&oacute;rroga 1</b></td>
			<td>
				{$objFormularioProyecto->fchLicenciaUrbanismo2}
				<input name="fchLicenciaUrbanismo2" type="hidden" id="fchLicenciaUrbanismo2" value="{$objFormularioProyecto->fchLicenciaUrbanismo2}" size="12" />
			</td>
			<!-- FECHA DE LICENCIA DE URBANISMO (SEGUNDA AMPLIACION)-->
			<td><b>Fecha Pr&oacute;rroga 2</b></td>
			<td>
				{$objFormularioProyecto->fchLicenciaUrbanismo3}
				<input name="fchLicenciaUrbanismo3" type="hidden" id="fchLicenciaUrbanismo3" value="{$objFormularioProyecto->fchLicenciaUrbanismo3}" size="12" />
			</td>
		</tr>
		
		<tr>
			<!-- FECHA DE LICENCIA DE URBANISMO -->
			<td><b>Fecha Ejecutoria</b></td>
			<td>{$objFormularioProyecto->fchEjecutoriaLicenciaUrbanismo}
				<input name="fchEjecutoriaLicenciaUrbanismo" type="hidden" id="fchEjecutoriaLicenciaUrbanismo" value="{$objFormularioProyecto->fchEjecutoriaLicenciaUrbanismo}" size="12" readonly /> 
				<a href="#" onClick="javascript: calendarioPopUp( 'fchEjecutoriaLicenciaUrbanismo' ); "></a>
			</td>
			<!-- VIGENCIA DE LICENCIA DE URBANISMO -->
			<td><b>Resoluci&oacute;n Ejecutoria</b></td>
			<td>{$objFormularioProyecto->txtResEjecutoriaLicenciaUrbanismo}
				<input name="txtResEjecutoriaLicenciaUrbanismo" type="hidden" id="txtResEjecutoriaLicenciaUrbanismo" value="{$objFormularioProyecto->txtResEjecutoriaLicenciaUrbanismo}" />
			</td>
		</tr>

		<tr><td class="tituloTabla" colspan="4">LICENCIA DE CONSTRUCCION</td></tr>
		<tr><!-- LICENCIA DE CONSTRUCCION -->
			<td><b>N&uacute;mero de Licencia</b></td>
			<td colspan="2">
				{$objFormularioProyecto->txtLicenciaConstruccion}
				<input name="txtLicenciaConstruccion" type="hidden" id="txtLicenciaConstruccion" value="{$objFormularioProyecto->txtLicenciaConstruccion}" style="width:200px;" /></td>
		</tr>
		<tr>
			<!-- FECHA DE LICENCIA DE CONSTRUCCION -->
			<td><b>Fecha de Licencia</b></td>
			<td>{$objFormularioProyecto->fchLicenciaConstruccion1}
				<input name="fchLicenciaConstruccion1" type="hidden" id="fchLicenciaConstruccion1" value="{$objFormularioProyecto->fchLicenciaConstruccion1}" size="12" /> 
			</td>
			<!-- VIGENCIA DE LICENCIA DE CONSTRUCCION -->
			<td><b>Vigencia de Licencia</b></td>
			<td>{$objFormularioProyecto->fchVigenciaLicenciaConstruccion}
				<input name="fchVigenciaLicenciaConstruccion" type="hidden" id="fchVigenciaLicenciaConstruccion" value="{$objFormularioProyecto->fchVigenciaLicenciaConstruccion}" /></td>
		</tr>

		<tr>
			<!-- FECHA DE LICENCIA DE CONSTRUCCION (PRIMERA AMPLIACION)-->
			<td><b>Fecha Pr&oacute;rroga 1</b></td>
			<td>
				{$objFormularioProyecto->fchLicenciaConstruccion2}
				<input name="fchLicenciaConstruccion2" type="hidden" id="fchLicenciaConstruccion2" value="{$objFormularioProyecto->fchLicenciaConstruccion2}" size="12" />
			</td>
			<!-- FECHA DE LICENCIA DE COSNTRUCCION (SEGUNDA AMPLIACION)-->
			<td><b>Fecha Pr&oacute;rroga 2</b></td>
			<td>
				{$objFormularioProyecto->fchLicenciaConstruccion3}
				<input name="fchLicenciaConstruccion3" type="hidden" id="fchLicenciaConstruccion3" value="{$objFormularioProyecto->fchLicenciaConstruccion3}" size="12" />
			</td>
		</tr>

		<tr><td class="tituloTabla" colspan="4">ESCRITURACION</td></tr>
		<tr>
			<!-- NOMBRE DEL VENDEDOR -->
			<td>Nombre del vendedor</td>
			<td>{$objFormularioProyecto->txtNombreVendedor}</td>
			<!-- NIT VENDEDOR -->
			<td>NIT</td>
			<td>{$objFormularioProyecto->numNitVendedor}</td>
		</tr>

		<tr>
			<!-- CEDULA CATASTRAL -->
			<td>C&eacute;dula Catastral</td>
			<td colspan="3">{$objFormularioProyecto->txtCedulaCatastral}</td>
		</tr>

		<tr>
			<!-- NUMERO Y FECHA ESCRITURA -->
			<td>No. Escritura</td>
			<td>{$objFormularioProyecto->txtEscritura} del {$objFormularioProyecto->fchEscritura}</td>
			<!-- NUMERO NOTARIA -->
			<td>No. Notar&iacute;a</td>
			<td>{$objFormularioProyecto->numNotaria}</td>
		</tr>

		<tr><td class="tituloTabla" colspan="4">DATOS DEL INTERVENTOR</td></tr>
		<tr>
			<!-- NOMBRE INTERVENTOR -->
			<td><b>Nombre</b></td>
			<td>{$objFormularioProyecto->txtNombreInterventor}
				<input name="txtNombreInterventor" type="hidden" id="txtNombreInterventor" value="{$objFormularioProyecto->txtNombreInterventor}"  /></td>
			<!-- TELEFONO INTERVENTOR -->
			<td><b>Tel&eacute;fono</b></td>
			<td>{$objFormularioProyecto->numTelefonoInterventor}
				<input name="numTelefonoInterventor" type="hidden" id="numTelefonoInterventor" value="{$objFormularioProyecto->numTelefonoInterventor}"  /></td>
		</tr>
		
		<tr>
			<!-- DIRECCION INTERVENTOR -->
			<td><b>Direcci&oacute;n</b></td>
			<td>{$objFormularioProyecto->txtDireccionInterventor}
				<input name="txtDireccionInterventor" type="hidden" id="txtDireccionInterventor" value="{$objFormularioProyecto->txtDireccionInterventor}"  /></td>
			<!-- CORREO ELECTRONICO INTERVENTOR -->
			<td><b>Correo Electr&oacute;nico</b></td>
			<td>{$objFormularioProyecto->txtCorreoInterventor}
				<input name="txtCorreoInterventor" type="hidden" id="txtCorreoInterventor" value="{$objFormularioProyecto->txtCorreoInterventor}"  /></td>
		</tr>
		
		<tr>
			<!-- TIPO DE PERSONA INTERVENTOR -->
			<td><b>Tipo de Persona</b></td>
			<td align="left" colspan="3">
			{if $objFormularioProyecto->bolTipoPersonaInterventor == 1} Natural {/if}
			{if $objFormularioProyecto->bolTipoPersonaInterventor == 0} Jur&iacute;dica {/if}
			<input name="bolTipoPersonaInterventor" type="radio" id="bolTipoPersonaInterventor" onClick="escondeCamposTipoPersona()" style="display:none" value="1" {if $objFormularioProyecto->bolTipoPersonaInterventor == 1} checked {/if} /> 
			<input name="bolTipoPersonaInterventor" type="radio" onClick="escondeCamposTipoPersona()" id="bolTipoPersonaInterventor" style="display:none" value="0" {if $objFormularioProyecto->bolTipoPersonaInterventor == 0} checked {/if}/> 
			</td>
		</tr>

		<tr id="lineaPersonaNatural" name="lineaPersonaNatural" style="display:none">
			<!-- CEDULA INTERVENTOR (Persona Natural) -->
			<td><b>C&eacute;dula</b></td>
			<td>{$objFormularioProyecto->numCedulaInterventor}
				<input name="numCedulaInterventor" type="hidden" id="numCedulaInterventor" value="{$objFormularioProyecto->numCedulaInterventor}"  /></td>
			<!-- TARJETA PROFESIONAL INTERVENTOR (Persona Natural)-->
			<td><b>Tarjeta Profesional</b></td>
			<td>{$objFormularioProyecto->numTProfesionalInterventor}
				<input name="numTProfesionalInterventor" type="hidden" id="numTProfesionalInterventor" value="{$objFormularioProyecto->numTProfesionalInterventor}" /></td>
		</tr>

		<!-- NIT INTERVENTOR -->
		<tr id="lineaPersonaJuridica" name="lineaPersonaJuridica" style="display:none">
			<td><b>NIT</b></td>
			<td colspan="3">{$objFormularioProyecto->numNitInterventor}
				<input name="numNitInterventor" type="hidden" id="numNitInterventor" value="{$objFormularioProyecto->numNitInterventor}" />
			</td>
		</tr>
		
		<tr>
			<!-- NOMBRE REPRESENTANTE LEGAL INTERVENTOR -->
			<td><b>Nombre Representante Legal</b></td>
			<td>{$objFormularioProyecto->txtNombreRepLegalInterventor}
				<input name="txtNombreRepLegalInterventor" type="hidden" id="txtNombreRepLegalInterventor" value="{$objFormularioProyecto->txtNombreRepLegalInterventor}"  /></td>
			<!-- TELEFONO REPRESENTANTE LEGAL INTERVENTOR -->
			<td><b>Tel&eacute;fono</b></td>
			<td>{$objFormularioProyecto->numTelefonoRepLegalInterventor}
				<input name="numTelefonoRepLegalInterventor" type="hidden" id="numTelefonoRepLegalInterventor" value="{$objFormularioProyecto->numTelefonoRepLegalInterventor}"  /></td>
		</tr>
		
		<tr>
			<!-- DIRECCION REPRESENTANTE LEGAL INTERVENTOR -->
			<td><b>Direcci&oacute;n</b></td>
			<td>{$objFormularioProyecto->txtDireccionRepLegalInterventor}
				<input name="txtDireccionRepLegalInterventor" type="hidden" id="txtDireccionRepLegalInterventor" value="{$objFormularioProyecto->txtDireccionRepLegalInterventor}"  /></td>
			<!-- CORREO ELECTRONICO REPRESENTANTE LEGAL INTERVENTOR -->
			<td><b>Correo Electr&oacute;nico</b></td>
			<td>{$objFormularioProyecto->txtCorreoRepLegalInterventor}
				<input name="txtCorreoRepLegalInterventor" type="hidden" id="txtCorreoRepLegalInterventor" value="{$objFormularioProyecto->txtCorreoRepLegalInterventor}"  /></td>
		</tr>
		
		<tr><td class="tituloTabla" colspan="4">TUTOR DEL PROYECTO</td></tr>
		<tr>
			<td><b>Nombre del Tutor</b></td>
			<td colspan="3">
				{foreach from=$arrTutorProyecto key=seqTutorProyecto item=txtTutorProyecto}{if $objFormularioProyecto->seqTutorProyecto == $seqTutorProyecto} {$txtTutorProyecto} {/if}{/foreach}
				<select name="seqTutorProyecto"
						id="seqTutorProyecto"
						style="width:200px; display:none" >
						<option value="0">Seleccione una opción</option>
						{foreach from=$arrTutorProyecto key=seqTutorProyecto item=txtTutorProyecto}
							<option value="{$seqTutorProyecto}" {if $objFormularioProyecto->seqTutorProyecto == $seqTutorProyecto} selected {/if}>{$txtTutorProyecto}</option>
						{/foreach}
				</select>
			</td>
		</tr>
	</table>