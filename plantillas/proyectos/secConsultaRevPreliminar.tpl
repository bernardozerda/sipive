<table width="100%" border="0">
	<tr>
		<td width="30%" valign="top">Profesional Responsable<img src="recursos/imagenes/blank.gif" onload="escondeLineaObservacionesContratoInterventoria();"></td>
		<td valign="top">
			{foreach from=$arrProfesionalResponsable key=seqProfesionalResponsable item=txtProfesionalResponsable}
				{if $objFormularioProyecto->seqProfesionalResponsable == $seqProfesionalResponsable} 
					{$txtProfesionalResponsable}
				{/if}
			{/foreach}
		</td>
	</tr>
	<tr><!-- VO. BO. CONTRATO DE INTERVENTORIA -->
		<td valign="top">Vo. Bo. contrato de interventor&iacute;a</td>
		<td valign="top">
			{if $objFormularioProyecto->optVoBoContratoInterventoria == 0} Ninguno {/if}
			{if $objFormularioProyecto->optVoBoContratoInterventoria == 1} Si {/if}
			{if $objFormularioProyecto->optVoBoContratoInterventoria == 2} Con Observaciones {/if}
		</td>
	</tr>
	{if $objFormularioProyecto->optVoBoContratoInterventoria == 2}
		<tr><!-- OBSERVACIONES CONTRATO DE INTERVENTORIA -->
			<td valign="top">Descripci&oacute;n Contrato de interventor&iacute;a</td>
			<td valign="top" colspan="2">{$objFormularioProyecto->txtObservacionesContratoInterventoria}</td>
		</tr>
	{/if}
	<tr><!-- FECHA DE REVISION CONTRATO DE INTERVENTORIA -->
		<td valign="top">Fecha de revisi&oacute;n contrato de interventor&iacute;a</td>
		<td valign="top">{$objFormularioProyecto->fchRevisionContratoInterventoria}</td>
	</tr>
</table>