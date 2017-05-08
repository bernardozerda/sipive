<!--
	FORMULARIO DE CREACION DE OFERENTES
	PENDIENTES TODOS LOS CAMBIOS REFERENTES A LAS PLANTILLAS DE DISEÑO
	@author Jaison Ospina
	@version 0.1 Noviembre de 2013
-->

	<form onSubmit="someterFormulario( 'mensajes', this, './{$arrConfiguracion.carpetas.contenidos}/administracionProyectos/salvarOferente.php', false, true); return false;" autocomplete=off>

		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr><td class="tituloTabla" height="20px" colspan="2">Formulario de Oferentes</td></tr>
		</table>
		<br>
		<table cellspacing="2" cellpadding="0" border="0" width="100%">

			<!-- DATOS DEL CONSTRUCTOR -->
			<tr><td class="tituloTabla" colspan="2">Datos del Oferente</td></tr>
			
			<!-- NOMBRE DEL OFERENTE -->
			<tr>
				<th class="tituloCampo">Nombre (*)</th>
				<td><input name="nombre" type="text" id="nombre" value="{$objOferente->txtNombreOferente}" onBlur="sinCaracteresEspeciales( this ); soloLetras( this );" style="width:200px;"/></td>
			</tr>

			<!-- TIPO DE DOCUMENTO DEL OFERENTE -->
			<tr>
				<th class="tituloCampo">Tipo de Documento (*)</th>
				<td>
					<select name="seqTipoDocumentoOferente"
							id="seqTipoDocumentoOferente"
							style="width:200px"
					><option value="0">Seleccione una opción</option>
						{foreach from=$arrTipoDocumento key=seqTipoDocumento item=txtTipoDocumento}
							<option value="{$seqTipoDocumento}" {if $objOferente->seqTipoDocumentoOferente == $seqTipoDocumento} selected {/if}>{$txtTipoDocumento}</option>
						{/foreach}
					</select>
				</td>
			</tr>

			<!-- NUMERO DE DOCUMENTO DEL OFERENTE -->
			<tr>
				<th class="tituloCampo">N&uacute;mero de Documento (*)</th>
				<td><input name="numDocumentoOferente" type="text" id="numDocumentoOferente" value="{$objOferente->numDocumentoOferente}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/></td>
			</tr>

			<!-- DATOS DEL REPRESENTANTE LEGAL -->
			<tr><td class="tituloTabla" colspan="2">Datos del Representante Legal</td></tr>

			<!-- NOMBRE DEL REPRESENTANTE LEGAL -->
			<tr>
				<th class="tituloCampo">Nombre (*)</th>
				<td><input name="txtNombreRepresentanteLegal" type="text" id="txtNombreRepresentanteLegal" value="{$objOferente->txtNombreRepresentanteLegal}" onBlur="sinCaracteresEspeciales( this ); soloLetras( this );" style="width:200px;"/></td>
			</tr>
			
			<!-- NUMERO DE DOCUMENTO DEL REPRESENTANTE LEGAL -->
			<tr>
				<th class="tituloCampo">N&uacute;mero de Documento (*)</th>
				<td><input name="numDocumentoRepresentanteLegal" type="text" id="numDocumentoRepresentanteLegal" value="{$objOferente->numDocumentoRepresentanteLegal}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/></td>
			</tr>

			<!-- ESTADO: ACTIVO O INACTIVO -->
			<tr><td class="tituloTabla" colspan="2">Estado</td></tr>
			<tr><td></td>
				<td>Activo <input name="bolActivo" type="radio" id="bolActivo" value="1" {if $objOferente->bolActivo == 1} checked {/if} />
					Inactivo <input name="bolActivo" type="radio" id="bolActivo" value="0" {if $objOferente->bolActivo == 0} checked {/if}/>
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