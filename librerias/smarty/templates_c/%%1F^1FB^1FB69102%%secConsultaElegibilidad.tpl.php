<?php /* Smarty version 2.6.26, created on 2017-05-05 04:33:38
         compiled from proyectos/secConsultaElegibilidad.tpl */ ?>
<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
	<tr><td class="tituloTabla" colspan="4">N&Uacute;MEROS DE RADICADO</td></tr>
	<tr><!-- NUMERO DE RADICADO JURIDICO -->
		<td width="25%"><b>N&uacute;mero de Radicado Jur&iacute;dico</b></td>
		<td width="25%"><?php echo $this->_tpl_vars['objFormularioProyecto']->numRadicadoJuridico; ?>
</td>
		<!-- FECHA DE RADICADO JURIDICO -->
		<td width="25%"><b>Fecha de Radicado Jur&iacute;dico</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->fchRadicadoJuridico; ?>
</td>
	</tr>
	<tr><!-- NUMERO DE RADICADO TECNICO -->
		<td><b>N&uacute;mero de Radicado T&eacute;cnico</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->numRadicadoTecnico; ?>
</td>
		<!-- FECHA DE RADICADO TECNICO -->
		<td><b>Fecha de Radicado T&eacute;cnico</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->fchRadicadoTecnico; ?>
</td>
	</tr>
	<tr><!-- NUMERO DE RADICADO FINANCIERO -->
		<td><b>N&uacute;mero de Radicado Financiero</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->numRadicadoFinanciero; ?>
</td>
		<!-- FECHA DE RADICADO FINANCIERO -->
		<td><b>Fecha de Radicado Financiero</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->fchRadicadoFinanciero; ?>
</td>
	</tr>
	<tr><td class="tituloTabla" colspan="4">APROBACI&Oacute;N DEL PROYECTO</td></tr>
	<tr><!-- SE APRUEBA EL PROYECTO? -->
		<td width="25%"><b>Se aprueba el proyecto?</b></td>
		<td width="25%"colspan="3"><?php if ($this->_tpl_vars['objFormularioProyecto']->bolAprobacion == 1): ?> SI <?php else: ?> NO <?php endif; ?></td>
	</tr>
</table>
<?php if ($this->_tpl_vars['objFormularioProyecto']->bolAprobacion == 1): ?>
	<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF" >
		<tr><!-- NUMERO DE ACTA -->
			<td width="25%"><b>N&uacute;mero de Acta</b></td>
			<td colspan="3"><?php echo $this->_tpl_vars['objFormularioProyecto']->numActaAprobacion; ?>
</td>
		</tr>
		<tr><!-- RESUELVE -->
			<td width="25%" valign="top"><b>Resuelve</b></td>
			<td colspan="3"><?php echo $this->_tpl_vars['objFormularioProyecto']->txtActaResuelve; ?>
</td>
		</tr>
		<tr><!-- NUMERO DE RESOLUCION -->
			<td width="25%"><b>N&uacute;mero de Resoluci&oacute;n</b></td>
			<td width="25%"><?php echo $this->_tpl_vars['objFormularioProyecto']->numResolucionAprobacion; ?>
</td>
			<!-- FECHA DE RESOLUCION -->
			<td width="25%"><b>Fecha de Resoluci&oacute;n</b></td>
			<td width="25%"><?php echo $this->_tpl_vars['objFormularioProyecto']->fchResolucionAprobacion; ?>
</td>
		</tr>
		<tr><!-- SE APRUEBA CONDICIONADO? -->
			<td width="25%"><b>Se aprueba condicionado?</b></td>
			<td width="75%" colspan="3"><?php if ($this->_tpl_vars['objFormularioProyecto']->bolCondicionAprobacion == 1): ?> SI <?php else: ?> NO <?php endif; ?></td>
		</tr>
		<?php if ($this->_tpl_vars['objFormularioProyecto']->bolCondicionAprobacion == 1): ?>
			<tr><!-- CONDICIONES DE APROBACION -->
				<td width="25%" valign="top"><b>Condiciones de aprobaci&oacute;n</b></td>
				<td colspan="3"><?php echo $this->_tpl_vars['objFormularioProyecto']->txtCondicionAprobacion; ?>
</td>
			</tr>
		<?php endif; ?>
	</table>
<?php endif; ?>
<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF" >
	<tr><!-- OBSERVACIONES -->
		<td valign="top" width="25%"><b>Observaciones</b></td>
		<td colspan="3"><?php echo $this->_tpl_vars['objFormularioProyecto']->txtObservacionAprobacion; ?>
</td>
	</tr>
</table>