<table cellspacing="0" cellpadding="2" border="0" width="100%">
	<tr><td class="tituloTabla" colspan="4">DATOS DEL OFERENTE<img src="recursos/imagenes/blank.gif" onload="escondetxtDireccion(); escondetxtDescEquipamientoComunal(); escondeLineaConstructor(); escondeLineaOpv(); escondeTerritorialDirigido();"></td></tr>
		<tr>
			<td colspan="4"><!-- DATOS DEL SEGUNDO OFERENTE-->
				<table width="100%" cellpadding="2" cellspacing="0" border="0" style="border-style: dotted; border-width: 1px;">
					<tr><td width="25%">Nombre Oferente Principal (*)</td>
						<td width="25%"><input name="txtNombreOferente" type="text" id="txtNombreOferente" value="{$objFormularioProyecto->txtNombreOferente}"  style="width:200px;"/></td>
						<td width="25%">Nit o C&eacute;dula (*)</td>
						<td width="25%"><input name="numNitOferente" type="text" id="numNitOferente" value="{$objFormularioProyecto->numNitOferente}" onBlur="sinCaracteresEspeciales( this ); soloNit( this );" style="width:200px;"/></td>
					</tr>
					<tr><td>Nombre de Contacto (*)</td>
						<td><input name="txtNombreContactoOferente" type="text" id="txtNombreContactoOferente" value="{$objFormularioProyecto->txtNombreContactoOferente}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
						<td>Tel&eacute;fono Fijo de Contacto (*)</td>
						<td><input name="numTelefonoOferente" type="text" id="numTelefonoOferente" value="{$objFormularioProyecto->numTelefonoOferente}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:120px;"/> Ext. <input name="numExtensionOferente" type="text" id="numExtensionOferente" value="{$objFormularioProyecto->numExtensionOferente}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:50px;"/></td>
					</tr>
					<tr>
						<td>Celular de Contacto</td>
						<td><input name="numCelularOferente" type="text" id="numCelularOferente" value="{$objFormularioProyecto->numCelularOferente}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/></td>
						<td>Correo de Contacto</td>
						<td><input name="txtCorreoOferente" type="text" id="txtCorreoOferente" value="{$objFormularioProyecto->txtCorreoOferente}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="4"><!-- DATOS DEL SEGUNDO OFERENTE-->
				<table width="100%" cellpadding="2" cellspacing="0" border="0" style="border-style: dotted; border-width: 1px;">
					<tr><td width="25%">Nombre Oferente 2</td>
						<td width="25%"><input name="txtNombreOferente2" type="text" id="txtNombreOferente2" value="{$objFormularioProyecto->txtNombreOferente2}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
						<td width="25%">Nit o C&eacute;dula</td>
						<td width="25%"><input name="numNitOferente2" type="text" id="numNitOferente2" value="{$objFormularioProyecto->numNitOferente2}" onBlur="sinCaracteresEspeciales( this ); soloNit( this );" style="width:200px;"/></td>
					</tr>
					<tr><td>Nombre de Contacto</td>
						<td><input name="txtNombreContactoOferente2" type="text" id="txtNombreContactoOferente2" value="{$objFormularioProyecto->txtNombreContactoOferente2}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
						<td>Tel&eacute;fono Fijo de Contacto</td>
						<td><input name="numTelefonoOferente2" type="text" id="numTelefonoOferente2" value="{$objFormularioProyecto->numTelefonoOferente2}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:120px;"/> Ext. <input name="numExtensionOferente2" type="text" id="numExtensionOferente2" value="{$objFormularioProyecto->numExtensionOferente2}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:50px;"/></td>
					</tr>
					<tr><td>Celular de Contacto</td>
						<td><input name="numCelularOferente2" type="text" id="numCelularOferente2" value="{$objFormularioProyecto->numCelularOferente2}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/></td>
						<td>Correo de Contacto</td>
						<td><input name="txtCorreoOferente2" type="text" id="txtCorreoOferente2" value="{$objFormularioProyecto->txtCorreoOferente2}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="4"><!-- DATOS DEL TERCER OFERENTE-->
				<table width="100%" cellpadding="2" cellspacing="0" border="0" style="border-style: dotted; border-width: 1px;">
					<tr><td width="25%">Nombre Oferente 3</td>
						<td width="25%"><input name="txtNombreOferente3" type="text" id="txtNombreOferente3" value="{$objFormularioProyecto->txtNombreOferente3}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
						<td width="25%">Nit o C&eacute;dula</td>
						<td width="25%"><input name="numNitOferente3" type="text" id="numNitOferente3" value="{$objFormularioProyecto->numNitOferente3}" onBlur="sinCaracteresEspeciales( this ); soloNit( this );" style="width:200px;"/></td>
					</tr>
					<tr><td>Nombre de Contacto</td>
						<td><input name="txtNombreContactoOferente3" type="text" id="txtNombreContactoOferente3" value="{$objFormularioProyecto->txtNombreContactoOferente3}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
						<td>Tel&eacute;fono Fijo de Contacto</td>
						<td><input name="numTelefonoOferente3" type="text" id="numTelefonoOferente3" value="{$objFormularioProyecto->numTelefonoOferente3}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:120px;"/> Ext. <input name="numExtensionOferente3" type="text" id="numExtensionOferente3" value="{$objFormularioProyecto->numExtensionOferente3}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:50px;"/></td>
					</tr>
					<tr><td>Celular de Contacto</td>
						<td><input name="numCelularOferente3" type="text" id="numCelularOferente3" value="{$objFormularioProyecto->numCelularOferente3}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/></td>
						<td>Correo de Contacto</td>
						<td><input name="txtCorreoOferente3" type="text" id="txtCorreoOferente3" value="{$objFormularioProyecto->txtCorreoOferente3}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr><!-- PREGUNTA SI EL OFERENTE ES CONSTRUCTOR -->
			<td>El oferente es constructor?</td>
			<td>
				Si <input name="bolConstructor" type="radio" onClick="escondeLineaConstructor()" id="bolConstructor" value="0" {if $objFormularioProyecto->bolConstructor == 0} checked {/if}/> 
				No <input name="bolConstructor" type="radio" onClick="escondeLineaConstructor()" id="bolConstructor" value="1" {if $objFormularioProyecto->bolConstructor == 1} checked {/if} /> 
			</td>
			<td id="idTituloConstructor" style="display:none">Constructor</td>
			<td id="idComboConstructor" style="display:none"><select name="seqConstructor"
						id="seqConstructor"
						style="width:200px" >
						<option value="0">Seleccione una opci&oacute;n</option>
						{foreach from=$arrConstructor key=seqConstructor item=txtNombreConstructor}
							<option value="{$seqConstructor}" {if $objFormularioProyecto->seqConstructor == $seqConstructor} selected {/if}>{$txtNombreConstructor}</option>
						{/foreach}
				</select>
			</td>
		</tr>

		<tr><td class="tituloTabla" colspan="4">DATOS DEL REPRESENTANTE LEGAL</td></tr>
		<tr><td width="25%">Representante Legal</td>
			<td width="25%"><input name="txtRepresentanteLegalOferente" type="text" id="txtRepresentanteLegalOferente" value="{$objFormularioProyecto->txtRepresentanteLegalOferente}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
			<td width="25%">C&eacute;dula</td>
			<td width="25%"><input name="numNitRepresentanteLegalOferente" type="text" id="numNitRepresentanteLegalOferente" value="{$objFormularioProyecto->numNitRepresentanteLegalOferente}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/></td>
		</tr>
		<tr><td>Tel&eacute;fono Fijo</td>
			<td><input name="numTelefonoRepresentanteLegalOferente" type="text" id="numTelefonoRepresentanteLegalOferente" value="{$objFormularioProyecto->numTelefonoRepresentanteLegalOferente}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:120px;"/> Ext. <input name="numExtensionRepresentanteLegalOferente" type="text" id="numExtensionRepresentanteLegalOferente" value="{$objFormularioProyecto->numExtensionRepresentanteLegalOferente}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:50px;"/>
			</td>
			<td>Tel&eacute;fono Celular</td>
			<td><input name="numCelularRepresentanteLegalOferente" type="text" id="numCelularRepresentanteLegalOferente" value="{$objFormularioProyecto->numCelularRepresentanteLegalOferente}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/>
			</td>
		</tr>
		<tr>
			<td><a href="#" id="DireccionSolucion" onClick="recogerDireccion( 'txtDireccionRepresentanteLegalOferente', 'objDireccionOcultoSolucion' )">Direcci&oacute;n</a></td>
				<td><input type="text" 
							name="txtDireccionRepresentanteLegalOferente" 
							id="txtDireccionRepresentanteLegalOferente" 
							value="{$objFormularioProyecto->txtDireccionRepresentanteLegalOferente}" 
							style="width:200px; background-color:#ADD8E6;" 
							readonly
					/>
			</td>
			<td>Correo electr&oacute;nico</td>
			<td><input name="txtCorreoRepresentanteLegalOferente" type="text" id="txtCorreoRepresentanteLegalOferente" value="{$objFormularioProyecto->txtCorreoRepresentanteLegalOferente}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/>
			</td>
		</tr>
</table>