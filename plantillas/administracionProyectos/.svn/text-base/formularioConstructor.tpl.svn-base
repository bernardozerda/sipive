<!--
	FORMULARIO DE CREACION DE CONSTRUCTOR
	PENDIENTES TODOS LOS CAMBIOS REFERENTES A LAS PLANTILLAS DE DISEÑO
	@author Jaison Ospina
	@version 0.1 Noviembre de 2013
-->

	<form onSubmit="someterFormulario( 'mensajes', this, './{$arrConfiguracion.carpetas.contenidos}/administracionProyectos/salvarConstructor.php', false, true); return false;" autocomplete=off>

		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr><td class="tituloTabla" height="20px" colspan="2">Formulario de Constructores</td></tr>
		</table>
		<br>
		<table cellspacing="2" cellpadding="0" border="0" width="100%">

			<!-- DATOS DEL CONSTRUCTOR -->
			<tr><td class="tituloTabla" colspan="2">Datos del Constructor</td></tr>

			<!-- NOMBRE DEL CONSTRUCTOR -->
			<tr>
				<th class="tituloCampo">Nombre (*)</th>
				<td><input name="nombre" type="text" id="nombre" value="{$objConstructor->txtNombreConstructor}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
			</tr>

			<!-- TIPO DE DOCUMENTO DEL CONSTRUCTOR -->
			<tr>
				<th class="tituloCampo">Tipo de Documento (*)</th>
				<td>
					<select name="seqTipoDocumentoConstructor"
							id="seqTipoDocumentoConstructor"
							style="width:200px"
					><option value="0">Seleccione una opción</option>
						{foreach from=$arrTipoDocumento key=seqTipoDocumento item=txtTipoDocumento}
							<option value="{$seqTipoDocumento}" {if $objConstructor->seqTipoDocumentoConstructor == $seqTipoDocumento} selected {/if}>{$txtTipoDocumento}</option>
						{/foreach}
					</select>
				</td>
			</tr>

			<!-- NUMERO DE DOCUMENTO DEL CONSTRUCTOR -->
			<tr>
				<th class="tituloCampo">N&uacute;mero de Documento (*)</th>
				<td><input name="numDocumentoConstructor" type="text" id="numDocumentoConstructor" value="{$objConstructor->numDocumentoConstructor}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/></td>
			</tr>

			<!-- DIRECCION DEL CONSTRUCTOR -->
			<tr>
				<th class="tituloCampo">Direcci&oacute;n</th>
				<td><input name="txtDireccionConstructor" type="text" id="txtDireccionConstructor" value="{$objConstructor->txtDireccionConstructor}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
			</tr>
			
			<!-- NUMERO DE TELEFONO 1 DEL CONSTRUCTOR -->
			<tr>
				<th class="tituloCampo">Tel&eacute;fono 1 (*)</th>
				<td><input name="numTelefono1Constructor" type="text" id="numTelefono1Constructor" value="{$objConstructor->numTelefono1Constructor}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/></td>
			</tr>
			
			<!-- NUMERO DE TELEFONO 2 DEL CONSTRUCTOR -->
			<tr>
				<th class="tituloCampo">Tel&eacute;fono 2</th>
				<td><input name="numTelefono2Constructor" type="text" id="numTelefono2Constructor" value="{$objConstructor->numTelefono2Constructor}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/></td>
			</tr>
			
			<!-- CORREO ELECTRONICO DEL CONSTRUCTOR -->
			<tr>
				<th class="tituloCampo">Correo Electr&oacute;nico (*)</th>
				<td><input name="txtCorreoElectronicoConstructor" type="text" id="txtCorreoElectronicoConstructor" value="{$objConstructor->txtCorreoElectronicoConstructor}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
			</tr>
			
			<!-- DATOS DEL REPRESENTANTE LEGAL -->
			<tr><td class="tituloTabla" colspan="2">Datos del Representante Legal</td></tr>
			
			<!-- NOMBRE DEL REPRESENTANTE LEGAL -->
			<tr>
				<th class="tituloCampo">Nombre (*)</th>
				<td><input name="txtNombreRepresentanteLegal" type="text" id="txtNombreRepresentanteLegal" value="{$objConstructor->txtNombreRepresentanteLegal}" onBlur="sinCaracteresEspeciales( this ); soloLetras( this );" style="width:200px;"/></td>
			</tr>
			
			<!-- NUMERO DE DOCUMENTO DEL REPRESENTANTE LEGAL -->
			<tr>
				<th class="tituloCampo">N&uacute;mero de Documento (*)</th>
				<td><input name="numDocumentoRepresentanteLegal" type="text" id="numDocumentoRepresentanteLegal" value="{$objConstructor->numDocumentoRepresentanteLegal}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/></td>
			</tr>
			
			<!-- CORREO ELECTRONICO DEL REPRESENTANTE LEGAL -->
			<tr>
				<th class="tituloCampo">Correo Electr&oacute;nico (*)</th>
				<td><input name="txtCorreoElectronicoRepresentanteLegal" type="text" id="txtCorreoElectronicoRepresentanteLegal" value="{$objConstructor->txtCorreoElectronicoRepresentanteLegal}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
			</tr>

			<!-- ESTADO: ACTIVO O INACTIVO -->
			<tr><td class="tituloTabla" colspan="2">Estado</td></tr>
			<tr>
				<th class="tituloCampo"></th>
				<td>
					Activo <input name="bolActivo" type="radio" id="bolActivo" value="1" {if $objConstructor->bolActivo == 1} checked {/if} />
					Inactivo <input name="bolActivo" type="radio" id="bolActivo" value="0" {if $objConstructor->bolActivo == 0} checked {/if}/>
				</td>
			</tr>
		</table>

		<!-- BOTON DE SALVAR / EDITAR -->
		<table cellspacing="2" cellpadding="0" border="0" width="100%">
			<tr><td align="right" style="padding-top: 5px; padding-right: 25px;">
				<input name="btnSalvar" type="submit" id="btnSalvar" value="Guardar" />
				<input name="seqEditar" type="hidden" id="seqEditar" value="{$seqEditar}">
			</td></tr>
		</table>
	</form>