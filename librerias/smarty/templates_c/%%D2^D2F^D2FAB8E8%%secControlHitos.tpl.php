<?php /* Smarty version 2.6.26, created on 2017-05-05 08:07:13
         compiled from proyectos/secControlHitos.tpl */ ?>
<table border="0" cellspacing="2" cellpadding="0" width="100%">
	<tr class="tituloTabla">
		<th width="40%" align="center" style="padding:3px;">Actividad</th>
		<th width="20%" align="center" style="padding:3px;">Fecha Inicial Actividad</th>
		<th width="20%" align="center" style="padding:3px;">Fecha Final Actividad</th>
		<th width="20%" align="center" style="padding:3px;">Unidades de Vivienda</th>
	</tr>
	<tr class="fila_0">
		<td class="tituloNivel1">Tramite licencia de Urbanismo</td>
		<td class="fechaNivel1"><input name="fchInicialLicenciaUrbanismo" type="text" id="fchInicialLicenciaUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialLicenciaUrbanismo; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialLicenciaUrbanismo' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalLicenciaUrbanismo" type="text" id="fchFinalLicenciaUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalLicenciaUrbanismo; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalLicenciaUrbanismo' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td></td>
	</tr>
	<tr class="fila_1">
		<td class="tituloNivel1">Tramite licencia de Construcción</td>
		<td class="fechaNivel1"><input name="fchInicialLicenciaConstruccion" type="text" id="fchInicialLicenciaConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialLicenciaConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialLicenciaConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalLicenciaConstruccion" type="text" id="fchFinalLicenciaConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalLicenciaConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalLicenciaConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td></td>
	</tr>
	<tr class="fila_0">
		<td class="tituloNivel1">Ventas del Proyecto</td>
		<td class="fechaNivel1"><input name="fchInicialVentasProyecto" type="text" id="fchInicialVentasProyecto" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialVentasProyecto; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialVentasProyecto' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalVentasProyecto" type="text" id="fchFinalVentasProyecto" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalVentasProyecto; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalVentasProyecto' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="numViviendaVentasProyecto" id="numViviendaVentasProyecto" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->numViviendaVentasProyecto; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );"></td>
	</tr>
	<tr class="fila_1">
		<td class="tituloNivel1">Entrega y Escrituraci&oacute;n de Vivienda</td>
		<td class="fechaNivel1"><input name="fchInicialEntregaEscrituracionVivienda" type="text" id="fchInicialEntregaEscrituracionVivienda" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialEntregaEscrituracionVivienda; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialEntregaEscrituracionVivienda' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalEntregaEscrituracionVivienda" type="text" id="fchFinalEntregaEscrituracionVivienda" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalEntregaEscrituracionVivienda; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalEntregaEscrituracionVivienda' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="numViviendaEntregaEscrituracionVivienda" id="numViviendaEntregaEscrituracionVivienda" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->numViviendaEntregaEscrituracionVivienda; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );"></td>
	</tr>
		<tr>
		<td class="tituloNivel1">Observaciones</td>
		<td colspan="4"></td>
	</tr>
	<tr>
		<td class="tituloNivel1" colspan="4"><textarea cols="132" id="txtDescripcionHitos" name="txtDescripcionHitos" ><?php echo $this->_tpl_vars['objFormularioProyecto']->txtDescripcionHitos; ?>
</textarea></td>
	</tr>
</table>