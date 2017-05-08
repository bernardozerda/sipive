<table width="100%" border="0">
	<tr>
		<td width="30%" valign="top">Profesional Responsable<img src="recursos/imagenes/blank.gif" onload="escondeLineaObservacionesContratoInterventoria();"></td>
		<td valign="top"><select name="seqProfesionalResponsable" id="seqProfesionalResponsable" >
				<option value="0">Seleccione una opci&oacute;n</option>
				{foreach from=$arrProfesionalResponsable key=seqProfesionalResponsable item=txtProfesionalResponsable}
					<option value="{$seqProfesionalResponsable}" {if $objFormularioProyecto->seqProfesionalResponsable == $seqProfesionalResponsable} selected {/if}>{$txtProfesionalResponsable}</option>
				{/foreach}
			</select>
		</td>
	</tr>
	<tr><!-- VO. BO. CONTRATO DE INTERVENTORIA -->
		<td valign="top">Vo. Bo. contrato de interventor&iacute;a</td>
		<td valign="top"><select name="optVoBoContratoInterventoria" id="optVoBoContratoInterventoria" onChange="escondeLineaObservacionesContratoInterventoria()">
				<option value="0" {if $objFormularioProyecto->optVoBoContratoInterventoria == 0} selected {/if}>Seleccione una opci&oacute;n</option>
				<option value="1" {if $objFormularioProyecto->optVoBoContratoInterventoria == 1} selected {/if}>Si</option>
				<option value="2" {if $objFormularioProyecto->optVoBoContratoInterventoria == 2} selected {/if}>Con Observaciones</option>
			</select>
		</td>
	</tr>
	<tr id="lineaObservacionesContratoInterventoria" style="display:none"><!-- OBSERVACIONES CONTRATO DE INTERVENTORIA -->
		<td valign="top">Descripci&oacute;n Contrato de interventor&iacute;a</td>
		<td valign="top" colspan="2"><textarea cols="90" id="txtObservacionesContratoInterventoria" name="txtObservacionesContratoInterventoria" >{$objFormularioProyecto->txtObservacionesContratoInterventoria}</textarea></td>
	</tr>
	<tr><!-- FECHA DE REVISION CONTRATO DE INTERVENTORIA -->
		<td valign="top">Fecha de revisi&oacute;n contrato de interventor&iacute;a</td>
		<td valign="top"><input name="fchRevisionContratoInterventoria" type="text" id="fchRevisionContratoInterventoria" value="{$objFormularioProyecto->fchRevisionContratoInterventoria}" size="12" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchRevisionContratoInterventoria' ); "><img src="recursos/imagenes/calendar_icon.gif"></a></td>
	</tr>
	<tr><td colspan="2"><input name="valTotalCostos" type="hidden" id="valTotalCostos" value="{$objFormularioProyecto->valTotalCostos}" /></td></tr>
</table>