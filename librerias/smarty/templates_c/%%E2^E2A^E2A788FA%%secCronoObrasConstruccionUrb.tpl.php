<?php /* Smarty version 2.6.26, created on 2017-05-05 08:07:13
         compiled from proyectos/secCronoObrasConstruccionUrb.tpl */ ?>
<table border="0" cellspacing="2" cellpadding="0" width="100%">
	<tr><td colspan="5" align="right"><font color="#ff0000"><i>Nota: Los n&uacute;meros decimales se deben separar con punto (.)</i></font></td></tr>
	<tr class="tituloTabla">
		<th width="30%" align="center" style="padding:3px;">Actividad</th>
		<th width="20%" align="center" style="padding:3px;">Fecha Inicial Actividad</th>
		<th width="20%" align="center" style="padding:3px;">Fecha Final Actividad</th>
		<th width="15%" align="center" style="padding:3px;">% Incidencia</th>
		<th width="15%" align="center" style="padding:3px;">Valor Actividad</th>
	</tr>
	<tr class="fila_0">
		<td width="30%" class="tituloNivel1">Preliminares</td>
		<td width="20%" class="fechaNivel1"><input name="fchInicialPreliminarUrbanismo" type="text" id="fchInicialPreliminarUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialPreliminarUrbanismo; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialPreliminarUrbanismo' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td width="20%" class="fechaNivel1"><input name="fchFinalPreliminarUrbanismo" type="text" id="fchFinalPreliminarUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalPreliminarUrbanismo; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalPreliminarUrbanismo' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td width="15%" class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncPreliminarUrbanismo" id="porcIncPreliminarUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncPreliminarUrbanismo; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td width="15%" class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActPreliminarUrbanismo" id="valActPreliminarUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActPreliminarUrbanismo; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncPreliminarUrbanismo')"></td>
	</tr>
	<tr class="fila_1">
		<td class="tituloNivel1">Cimentación</td>
		<td class="fechaNivel1"><input name="fchInicialCimentacionUrbanismo" type="text" id="fchInicialCimentacionUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialCimentacionUrbanismo; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialCimentacionUrbanismo' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalCimentacionUrbanismo" type="text" id="fchFinalCimentacionUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalCimentacionUrbanismo; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalCimentacionUrbanismo' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncCimentacionUrbanismo" id="porcIncCimentacionUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncCimentacionUrbanismo; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActCimentacionUrbanismo" id="valActCimentacionUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActCimentacionUrbanismo; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncCimentacionUrbanismo')"></td>
	</tr>
	<tr class="fila_0">
		<td class="tituloNivel1">Desagües y Redes</td>
		<td class="fechaNivel1"><input name="fchInicialDesaguesUrbanismo" type="text" id="fchInicialDesaguesUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialDesaguesUrbanismo; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialDesaguesUrbanismo' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalDesaguesUrbanismo" type="text" id="fchFinalDesaguesUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalDesaguesUrbanismo; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalDesaguesUrbanismo' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncDesaguesUrbanismo" id="porcIncDesaguesUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncDesaguesUrbanismo; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActDesaguesUrbanismo" id="valActDesaguesUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActDesaguesUrbanismo; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncDesaguesUrbanismo')"></td>
	</tr>
	<tr class="fila_1">
		<td class="tituloNivel1">V&iacute;as y Andenes</td>
		<td class="fechaNivel1"><input name="fchInicialViasUrbanismo" type="text" id="fchInicialViasUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialViasUrbanismo; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialViasUrbanismo' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalViasUrbanismo" type="text" id="fchFinalViasUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalViasUrbanismo; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalViasUrbanismo' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncViasUrbanismo" id="porcIncViasUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncViasUrbanismo; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActViasUrbanismo" id="valActViasUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActViasUrbanismo; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncViasUrbanismo')"></td>
	</tr>
	<tr class="fila_0">
		<td class="tituloNivel1">Parques y Cesiones</td>
		<td class="fechaNivel1"><input name="fchInicialParquesUrbanismo" type="text" id="fchInicialParquesUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialParquesUrbanismo; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialParquesUrbanismo' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalParquesUrbanismo" type="text" id="fchFinalParquesUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalParquesUrbanismo; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalParquesUrbanismo' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncParquesUrbanismo" id="porcIncParquesUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncParquesUrbanismo; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActParquesUrbanismo" id="valActParquesUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActParquesUrbanismo; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncParquesUrbanismo')"></td>
	</tr>
	<tr class="fila_1">
		<td class="tituloNivel1">Aseo</td>
		<td class="fechaNivel1"><input name="fchInicialAseoUrbanismo" type="text" id="fchInicialAseoUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialAseoUrbanismo; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialAseoUrbanismo' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalAseoUrbanismo" type="text" id="fchFinalAseoUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalAseoUrbanismo; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalAseoUrbanismo' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncAseoUrbanismo" id="porcIncAseoUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncAseoUrbanismo; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActAseoUrbanismo" id="valActAseoUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActAseoUrbanismo; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncAseoUrbanismo')"></td>
	</tr>
</table>