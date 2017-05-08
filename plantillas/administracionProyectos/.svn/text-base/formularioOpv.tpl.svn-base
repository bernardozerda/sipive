<!--
	FORMULARIO DE CREACION DE OPV'S
	PENDIENTES TODOS LOS CAMBIOS REFERENTES A LAS PLANTILLAS DE DISEÑO
	@author Jaison Ospina
	@version 0.1 Noviembre de 2013
-->

	<form onSubmit="someterFormulario( 'mensajes', this, './{$arrConfiguracion.carpetas.contenidos}/administracionProyectos/salvarOpv.php', false, true); return false;" autocomplete=off>

		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr><td class="tituloTabla" height="20px" colspan="2">Formulario de OPVs</td></tr>
		</table>
		<br>
		<table cellspacing="2" cellpadding="0" border="0" width="100%">

			<!-- DATOS DE LA OPV -->
			<tr><td class="tituloTabla" colspan="2">Datos de la OPV</td></tr>
			
			<!-- NOMBRE DE LA OPV -->
			<tr>
				<th class="tituloCampo">Nombre (*)</th>
				<td><input name="nombre" type="text" id="nombre" value="{$objOpv->txtNombreOpv}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
			</tr>

			<!-- NIT DE LA OPV -->
			<tr>
				<th class="tituloCampo">NIT (*)</th>
				<td><input name="numNitOpv" type="text" id="numNitOpv" value="{$objOpv->numNitOpv}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/></td>
			</tr>

			<!-- DATOS DE LA OPV -->
			<tr><td class="tituloTabla" colspan="2">Datos del Representante</td></tr>

			<!-- REPRESENTANTE DE LA OPV -->
			<tr>
				<th class="tituloCampo">Nombre (*)</th>
				<td><input name="txtRepresentanteOpv" type="text" id="txtRepresentanteOpv" value="{$objOpv->txtRepresentanteOpv}" onBlur="sinCaracteresEspeciales( this ); soloLetras( this );" style="width:200px;"/></td>
			</tr>

			<!-- TIPO DE DOCUMENTO DEL REPRESENTANTE DE LA OPV -->
			<tr>
				<th class="tituloCampo">Tipo de Documento (*)</th>
				<td>
					<select name="seqTipoDocRepresentanteOpv"
							id="seqTipoDocRepresentanteOpv"
							style="width:200px"
					><option value="0">Seleccione una opción</option>
						{foreach from=$arrTipoDocumento key=seqTipoDocumento item=txtTipoDocumento}
							<option value="{$seqTipoDocumento}" {if $objOpv->seqTipoDocRepresentanteOpv == $seqTipoDocumento} selected {/if}>{$txtTipoDocumento}</option>
						{/foreach}
					</select>
				</td>
			</tr>

			<!-- DOCUMENTO DEL REPRESENTANTE DE LA OPV -->
			<tr>
				<th class="tituloCampo">N&uacute;mero de Documento (*)</th>
				<td><input name="numDocRepresentanteOpv" type="text" id="numDocRepresentanteOpv" value="{$objOpv->numDocRepresentanteOpv}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/></td>
			</tr>

			<!-- ESTADO: ACTIVO O INACTIVO -->
			<tr><td class="tituloTabla" colspan="2">Estado</td></tr>
			<tr>
				<td></td>
				<td>
					Activo <input name="bolActivo" type="radio" id="bolActivo" value="1" {if $objOpv->bolActivo == 1} checked {/if} />
					Inactivo <input name="bolActivo" type="radio" id="bolActivo" value="0" {if $objOpv->bolActivo == 0} checked {/if}/>
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