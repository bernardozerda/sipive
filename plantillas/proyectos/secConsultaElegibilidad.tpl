<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
	<tr><td class="tituloTabla" colspan="4">N&Uacute;MEROS DE RADICADO</td></tr>
	<tr><!-- NUMERO DE RADICADO JURIDICO -->
		<td width="25%"><b>N&uacute;mero de Radicado Jur&iacute;dico</b></td>
		<td width="25%">{$objFormularioProyecto->numRadicadoJuridico}</td>
		<!-- FECHA DE RADICADO JURIDICO -->
		<td width="25%"><b>Fecha de Radicado Jur&iacute;dico</b></td>
		<td>{$objFormularioProyecto->fchRadicadoJuridico}</td>
	</tr>
	<tr><!-- NUMERO DE RADICADO TECNICO -->
		<td><b>N&uacute;mero de Radicado T&eacute;cnico</b></td>
		<td>{$objFormularioProyecto->numRadicadoTecnico}</td>
		<!-- FECHA DE RADICADO TECNICO -->
		<td><b>Fecha de Radicado T&eacute;cnico</b></td>
		<td>{$objFormularioProyecto->fchRadicadoTecnico}</td>
	</tr>
	<tr><!-- NUMERO DE RADICADO FINANCIERO -->
		<td><b>N&uacute;mero de Radicado Financiero</b></td>
		<td>{$objFormularioProyecto->numRadicadoFinanciero}</td>
		<!-- FECHA DE RADICADO FINANCIERO -->
		<td><b>Fecha de Radicado Financiero</b></td>
		<td>{$objFormularioProyecto->fchRadicadoFinanciero}</td>
	</tr>
	<tr><td class="tituloTabla" colspan="4">APROBACI&Oacute;N DEL PROYECTO</td></tr>
	<tr><!-- SE APRUEBA EL PROYECTO? -->
		<td width="25%"><b>Se aprueba el proyecto?</b></td>
		<td width="25%"colspan="3">{if $objFormularioProyecto->bolAprobacion == 1} SI {else} NO {/if}</td>
	</tr>
</table>
{if $objFormularioProyecto->bolAprobacion == 1}
	<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF" >
		<tr><!-- NUMERO DE ACTA -->
			<td width="25%"><b>N&uacute;mero de Acta</b></td>
			<td colspan="3">{$objFormularioProyecto->numActaAprobacion}</td>
		</tr>
		<tr><!-- RESUELVE -->
			<td width="25%" valign="top"><b>Resuelve</b></td>
			<td colspan="3">{$objFormularioProyecto->txtActaResuelve}</td>
		</tr>
		<tr><!-- NUMERO DE RESOLUCION -->
			<td width="25%"><b>N&uacute;mero de Resoluci&oacute;n</b></td>
			<td width="25%">{$objFormularioProyecto->numResolucionAprobacion}</td>
			<!-- FECHA DE RESOLUCION -->
			<td width="25%"><b>Fecha de Resoluci&oacute;n</b></td>
			<td width="25%">{$objFormularioProyecto->fchResolucionAprobacion}</td>
		</tr>
		<tr><!-- SE APRUEBA CONDICIONADO? -->
			<td width="25%"><b>Se aprueba condicionado?</b></td>
			<td width="75%" colspan="3">{if $objFormularioProyecto->bolCondicionAprobacion == 1} SI {else} NO {/if}</td>
		</tr>
		{if $objFormularioProyecto->bolCondicionAprobacion == 1}
			<tr><!-- CONDICIONES DE APROBACION -->
				<td width="25%" valign="top"><b>Condiciones de aprobaci&oacute;n</b></td>
				<td colspan="3">{$objFormularioProyecto->txtCondicionAprobacion}</td>
			</tr>
		{/if}
	</table>
{/if}
<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF" >
	<tr><!-- OBSERVACIONES -->
		<td valign="top" width="25%"><b>Observaciones</b></td>
		<td colspan="3">{$objFormularioProyecto->txtObservacionAprobacion}</td>
	</tr>
</table>