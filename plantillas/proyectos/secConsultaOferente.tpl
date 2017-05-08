<table cellspacing="0" cellpadding="2" border="0" width="100%">
	<tr><td class="tituloTabla" colspan="4">DATOS DEL OFERENTE<img src="recursos/imagenes/blank.gif" onload="escondetxtDireccion(); escondetxtDescEquipamientoComunal(); escondeLineaConstructor(); escondeCamposTipoPersona();">
		<img src="recursos/imagenes/blank.gif" onload="escondeTerritorialDirigido(); escondeLineaOpv();"></td>
	</tr>
	<tr><td><b>Nombre</b></td>
		<td>{$objFormularioProyecto->txtNombreOferente}</td>
		<td><b>Nit o C&eacute;dula</b></td>
		<td>{$objFormularioProyecto->numNitOferente}</td>
	</tr>
	<tr><td><b>Nombre de Contacto</b></td>
		<td>{$objFormularioProyecto->txtNombreContactoOferente}</td>
		<td><b>Tel&eacute;fono Fijo de Contacto</b></td>
		<td>{$objFormularioProyecto->numTelefonoOferente} 
			{if $objFormularioProyecto->numExtensionOferente != "" } 
				{if $objFormularioProyecto->numExtensionOferente != 0 } 
					Ext. {$objFormularioProyecto->numExtensionOferente} 
				{/if}
			{/if}
		</td>
	</tr>
	<tr>
		<td><b>Celular de Contacto</b></td>
		<td>{$objFormularioProyecto->numCelularOferente} </td>
		<td><b>Correo de Contacto</b></td>
		<td>{$objFormularioProyecto->txtCorreoOferente} 
		</td>
	</tr>
	<tr>
		<!-- PREGUNTA SI EL OFERENTE ES CONSTRUCTOR -->
		<td><b>El oferente es constructor?</b></td>
		<td>{if $objFormularioProyecto->bolConstructor == 0} Si {/if}
			{if $objFormularioProyecto->bolConstructor == 1} No {/if}
		</td>
		<!-- CONSTRUCTOR -->
		<td id="idTituloConstructor" style="display:none"><b>Constructor</b></td>
		<td id="idComboConstructor" style="display:none">{foreach from=$arrConstructor key=seqConstructor item=txtNombreConstructor}{if $objFormularioProyecto->seqConstructor == $seqConstructor} {$txtNombreConstructor} {/if}{/foreach}</td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">DATOS DEL REPRESENTANTE LEGAL</td></tr>
	<tr><td><b>Representante Legal</b></td>
		<td>{$objFormularioProyecto->txtRepresentanteLegalOferente}</td>
		<td><b>Nit Representante Legal</b></td>
		<td>{$objFormularioProyecto->numNitRepresentanteLegalOferente}</td>
	</tr>
	<tr><td><b>Tel&eacute;fono Fijo</b></td>
		<td>{$objFormularioProyecto->numTelefonoRepresentanteLegalOferente}
			{if $objFormularioProyecto->numExtensionRepresentanteLegalOferente != "" } 
				{if $objFormularioProyecto->numExtensionRepresentanteLegalOferente != 0 } 
					Ext. {$objFormularioProyecto->numExtensionRepresentanteLegalOferente}
				{/if}
			{/if}
		</td>
		<td><b>Tel&eacute;fono Celular</b></td>
		<td>{$objFormularioProyecto->numCelularRepresentanteLegalOferente}
		</td>
	</tr>
	<tr>
		<td><b>Direcci&oacute;n</b></td>
		<td>{$objFormularioProyecto->txtDireccionRepresentanteLegalOferente}</td>
		<td><b>Correo electr&oacute;nico</b></td>
		<td>{$objFormularioProyecto->txtCorreoRepresentanteLegalOferente}</td>
		<td colspan="2"></td>
	</tr>
</table>