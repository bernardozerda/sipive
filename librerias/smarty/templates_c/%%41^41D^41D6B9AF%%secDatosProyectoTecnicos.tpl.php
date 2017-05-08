<?php /* Smarty version 2.6.26, created on 2017-05-05 08:07:13
         compiled from proyectos/secDatosProyectoTecnicos.tpl */ ?>
<table cellspacing="0" cellpadding="2" border="0" width="100%">
	<tr><td class="tituloTabla" colspan="4">DATOS PROYECTO</td></tr>
	<tr><!-- NOMBRE DEL PROYECTO -->
		<td>Nombre del Proyecto</td>
		<td colspan="3"><?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreProyecto; ?>
<input name="txtNombreProyecto" type="hidden" id="txtNombreProyecto" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreProyecto; ?>
" /</td>
	</tr>
	<tr><!-- NOMBRE DEL OFERENTE -->
		<td width="25%">Oferente</td>
		<td width="25%"><?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreOferente; ?>
</td>
		<!-- NUMERO DE SOLUCIONES -->
		<td width="25%">N&uacute;mero de Soluciones</td>
		<td width="25%"><?php echo $this->_tpl_vars['objFormularioProyecto']->valNumeroSoluciones; ?>
</td>
	</tr>
	<tr><!-- COSTO TOTAL PROYECTO -->
		<td>Costo Total Proyecto</td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->valTotalCostos; ?>
</td>
		<!-- VALOR SDVE -->
		<td>Valor SDVE</td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->valSDVE; ?>
</td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">DATOS LICENCIA DE CONSTRUCCION</td></tr>		
	<tr><!-- LICENCIA DE CONSTRUCCION -->
		<td valign="top">No. Licencia de Construcci&oacute;n</td>
		<td><input name="txtLicenciaConstruccion" type="text" id="txtLicenciaConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtLicenciaConstruccion; ?>
" /></td>
		<!-- OBSERVACIONES LICENCIA DE CONSTRUCCION -->
		<td valign="top">Observaciones</td>
		<td><textarea id="txtObsLicConstruccion" name="txtObsLicConstruccion" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"><?php echo $this->_tpl_vars['objFormularioProyecto']->txtObsLicConstruccion; ?>
</textarea></td>
	</tr>
	<tr><!-- FECHA EJECUTORIA -->
		<td valign="top">Fecha Ejecutoria</td>
		<td valign="top"><input name="fchEjecutaLicConstruccion" type="text" id="fchEjecutaLicConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchEjecutaLicConstruccion; ?>
" size="12" onBlur="sumaMesVencimiento(730)" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchEjecutaLicConstruccion' ); " ><img src="recursos/imagenes/calendar_icon.gif"></a></td>
		<!-- FECHA VENCIMIENTO -->
		<td valign="top">Fecha Vencimiento</td>
		<td valign="top"><input name="fchVenceLicConstruccion" type="text" id="fchVenceLicConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchVenceLicConstruccion; ?>
" size="12" readonly /></td>
	</tr>
	<tr><!-- NO. DE RESOLUCION DE PRORROGA -->
		<td valign="top">No. De Resoluci&oacute;n Pr&oacute;rroga</td>
		<td valign="top"><input name="numResolProrrogaLicConstruccion" type="text" id="numResolProrrogaLicConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->numResolProrrogaLicConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this );" /></td>
		<td valign="top">Observaciones</td>
		<td valign="top"><textarea id="txtObsNumResolProrrogaLicConstruccion" name="txtObsNumResolProrrogaLicConstruccion" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"><?php echo $this->_tpl_vars['objFormularioProyecto']->txtObsNumResolProrrogaLicConstruccion; ?>
</textarea></td>
	</tr>
	<tr><!-- FECHA EJECUTORIA PRORROGA -->
		<td valign="top">Fecha Ejecutoria Pr&oacute;rroga</td>
		<td valign="top"><input name="fchEjecutaProrrogaLicConstruccion" type="text" id="fchEjecutaProrrogaLicConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchEjecutaProrrogaLicConstruccion; ?>
" onBlur="sumaMesVencimientoProrroga(365)" size="12" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchEjecutaProrrogaLicConstruccion' ); "><img src="recursos/imagenes/calendar_icon.gif"></a></td>
		<!-- FECHA DE VENCIMIENTO PRORROGA -->
		<td valign="top">Fecha de Vencimiento Pr&oacute;rroga</td>
		<td valign="top"><input name="fchVenceProrrogaLicConstruccion" type="text" id="fchVenceProrrogaLicConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchVenceProrrogaLicConstruccion; ?>
" size="12" readonly /></td>
	</tr>
	<tr><!-- NO DE RESOLUCION DE REVALIDACION -->
		<td valign="top">No. De Resoluci&oacute;n de Revalidaci&oacute;n</td>
		<td valign="top"><input name="numResolRevalidacionLicConstruccion" type="text" id="numResolRevalidacionLicConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->numResolRevalidacionLicConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this );" /></td>
		<td valign="top">Observaciones</td>
		<td valign="top"><textarea id="txtObsNumResolRevalidacionLicConstruccion" name="txtObsNumResolRevalidacionLicConstruccion" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"><?php echo $this->_tpl_vars['objFormularioProyecto']->txtObsNumResolRevalidacionLicConstruccion; ?>
</textarea></td>
	</tr>
	<tr><!-- FECHA EJECUTORIA REVALIDACION -->
		<td valign="top">Fecha Ejecutoria Revalidaci&oacute;n</td>
		<td valign="top"><input name="fchEjecutaRevalidacionLicConstruccion" type="text" id="fchEjecutaRevalidacionLicConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchEjecutaRevalidacionLicConstruccion; ?>
" size="12" onBlur="sumaMesVencimientoRevalidacion(365)" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchEjecutaRevalidacionLicConstruccion' ); "><img src="recursos/imagenes/calendar_icon.gif"></a></td>
		<!-- FECHA DE VENCIMIENTO REVALIDACION -->
		<td valign="top">Fecha Vencimiento Revalidaci&oacute;n</td>
		<td valign="top"><input name="fchVenceRevalidacionLicConstruccion" type="text" id="fchVenceRevalidacionLicConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchVenceRevalidacionLicConstruccion; ?>
" size="12" readonly /></td>
	</tr>
	<tr><td class="tituloTabla" colspan="4">CRONOGRAMA FECHAS</td></tr>
	<tr><!-- PLAZO DE EJECUCION -->
		<td valign="top">Plazo de Ejecuci&oacute;n </td>
		<td valign="top" colspan="3"><?php echo $this->_tpl_vars['arrUltimoCronogramaFechas']['valPlazoEjecucion']; ?>
</td>
	</tr>
	<tr><!-- FECHA INICIO OBRA -->
		<td valign="top">Fecha Inicio Obra</td>
		<td valign="top"><?php echo $this->_tpl_vars['arrUltimoCronogramaFechas']['fchInicialProyecto']; ?>
</td>
		<!-- FECHA TERMINACION OBRA -->
		<td valign="top">Fecha Terminaci&oacute;n Obra</td>
		<td valign="top"><?php echo $this->_tpl_vars['arrUltimoCronogramaFechas']['fchFinalProyecto']; ?>
</td>
	</tr>
	<tr><!-- FECHA INICIO VENTAS -->
		<td valign="top">Fecha Inicio Ventas</td>
		<td valign="top"><?php echo $this->_tpl_vars['arrUltimoCronogramaFechas']['fchInicialEntrega']; ?>
</td>
		<!-- FECHA DE FIN VENTAS -->
		<td valign="top">Fecha Fin Ventas</td>
		<td valign="top"><?php echo $this->_tpl_vars['arrUltimoCronogramaFechas']['fchFinalEntrega']; ?>
</td>
	</tr>
	<tr><!-- FECHA INICIO ENTREGA Y ESCRITURACION -->
		<td valign="top">Fecha Inicio Entrega y Escrituraci&oacute;n</td>
		<td valign="top"><?php echo $this->_tpl_vars['arrUltimoCronogramaFechas']['fchInicialEscrituracion']; ?>
</td>
		<!-- FECHA FIN ENTREGA Y ESCRITURACION   -->
		<td valign="top">Fecha Fin Entrega y Escrituraci&oacute;n</td>
		<td valign="top"><?php echo $this->_tpl_vars['arrUltimoCronogramaFechas']['fchFinalEscrituracion']; ?>
</td>
	</tr>
</table>