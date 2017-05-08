<!--
	FORMULARIO DE CREACION DE LA FIDUCIARIA
	PENDIENTES TODOS LOS CAMBIOS REFERENTES A LAS PLANTILLAS DE DISEÑO
	@author Jaison Ospina
	@version 0.1 Noviembre de 2013
-->

	<form onSubmit="someterFormulario( 'mensajes', this, './{$arrConfiguracion.carpetas.contenidos}/administracionProyectos/salvarFiduciaria.php', false, true); return false;" autocomplete=off>

		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr><td class="tituloTabla" height="20px" colspan="2">Formulario de Fiduciarias</td></tr>
		</table>
		<br>
		<table cellspacing="2" cellpadding="0" border="0" width="100%">

			<!-- DATOS DE LA FIDUCIARIA -->
			<tr><td class="tituloTabla" colspan="2">Datos de la Fiduciaria</td></tr>

			<!-- NOMBRE DE LA FIDUCIARIA -->
			<tr>
				<th class="tituloCampo">Nombre (*)</th>
				<td><input name="nombre" type="text" id="nombre" value="{$objFiduciaria->txtNombreFiduciaria}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
			</tr>

			<!-- TIPO DE DOCUMENTO DE LA FIDUCIARIA -->
			<tr>
				<th class="tituloCampo">Tipo de Documento (*)</th>
				<td>
					<select name="seqTipoDocumentoFiduciaria"
							id="seqTipoDocumentoFiduciaria"
							style="width:200px"
					><option value="0">Seleccione una opción</option>
						{foreach from=$arrTipoDocumento key=seqTipoDocumento item=txtTipoDocumento}
							<option value="{$seqTipoDocumento}" {if $objFiduciaria->seqTipoDocumentoFiduciaria == $seqTipoDocumento} selected {/if}>{$txtTipoDocumento}</option>
						{/foreach}
					</select>
				</td>
			</tr>

			<!-- NUMERO DE DOCUMENTO DE LA FIDUCIARIA -->
			<tr>
				<th class="tituloCampo">N&uacute;mero de Documento (*)</th>
				<td><input name="numDocumentoFiduciaria" type="text" id="numDocumentoFiduciaria" value="{$objFiduciaria->numDocumentoFiduciaria}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/></td>
			</tr>

			<!-- DIRECCION DE LA FIDUCIARIA -->
			<tr>
				<th class="tituloCampo">Direcci&oacute;n</th>
				<td><input name="txtDireccionFiduciaria" type="text" id="txtDireccionFiduciaria" value="{$objFiduciaria->txtDireccionFiduciaria}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
			</tr>
			
			<!-- NUMERO DE TELEFONO 1 DE LA FIDUCIARIA -->
			<tr>
				<th class="tituloCampo">Tel&eacute;fono 1 (*)</th>
				<td><input name="numTelefono1Fiduciaria" type="text" id="numTelefono1Fiduciaria" value="{$objFiduciaria->numTelefono1Fiduciaria}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/></td>
			</tr>
			
			<!-- NUMERO DE TELEFONO 2 DE LA FIDUCIARIA -->
			<tr>
				<th class="tituloCampo">Tel&eacute;fono 2</th>
				<td><input name="numTelefono2Fiduciaria" type="text" id="numTelefono2Fiduciaria" value="{$objFiduciaria->numTelefono2Fiduciaria}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/></td>
			</tr>
			
			<!-- CORREO ELECTRONICO DE LA FIDUCIARIA  -->
			<tr>
				<th class="tituloCampo">Correo Electr&oacute;nico (*)</th>
				<td><input name="txtCorreoElectronicoFiduciaria" type="text" id="txtCorreoElectronicoFiduciaria" value="{$objFiduciaria->txtCorreoElectronicoFiduciaria}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
			</tr>
			
			<!-- DATOS DEL REPRESENTANTE LEGAL -->
			<tr><td class="tituloTabla" colspan="2">Datos del Representante Legal</td></tr>
			
			<!-- NOMBRE DEL REPRESENTANTE LEGAL -->
			<tr>
				<th class="tituloCampo">Nombre (*)</th>
				<td><input name="txtNombreRepresentanteLegal" type="text" id="txtNombreRepresentanteLegal" value="{$objFiduciaria->txtNombreRepresentanteLegal}" onBlur="sinCaracteresEspeciales( this ); soloLetras( this );" style="width:200px;"/></td>
			</tr>
			
			<!-- NUMERO DE DOCUMENTO DEL REPRESENTANTE LEGAL -->
			<tr>
				<th class="tituloCampo">N&uacute;mero de Documento (*)</th>
				<td><input name="numDocumentoRepresentanteLegal" type="text" id="numDocumentoRepresentanteLegal" value="{$objFiduciaria->numDocumentoRepresentanteLegal}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/></td>
			</tr>
			
			<!-- CORREO ELECTRONICO DEL REPRESENTANTE LEGAL -->
			<tr>
				<th class="tituloCampo">Correo Electr&oacute;nico (*)</th>
				<td><input name="txtCorreoElectronicoRepresentanteLegal" type="text" id="txtCorreoElectronicoRepresentanteLegal" value="{$objFiduciaria->txtCorreoElectronicoRepresentanteLegal}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
			</tr>

			<!-- ESTADO: ACTIVO O INACTIVO -->
			<tr><td class="tituloTabla" colspan="2">Estado</td></tr>
			<tr>
				<th class="tituloCampo"></th>
				<td>
					Activo <input name="bolActivo" type="radio" id="bolActivo" value="1" {if $objFiduciaria->bolActivo == 1} checked {/if} />
					Inactivo <input name="bolActivo" type="radio" id="bolActivo" value="0" {if $objFiduciaria->bolActivo == 0} checked {/if}/>
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