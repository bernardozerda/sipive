<?php /* Smarty version 2.6.26, created on 2017-05-05 08:07:13
         compiled from proyectos/secCronoObrasConstruccion.tpl */ ?>
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
		<td width="20%" class="fechaNivel1"><input name="fchInicialPreliminarConstruccion" type="text" id="fchInicialPreliminarConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialPreliminarConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialPreliminarConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td width="20%" class="fechaNivel1"><input name="fchFinalPreliminarConstruccion" type="text" id="fchFinalPreliminarConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalPreliminarConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalPreliminarConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td width="15%" class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncPreliminarConstruccion" id="porcIncPreliminarConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncPreliminarConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );"></td>
		<td width="15%" class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActPreliminarConstruccion" id="valActPreliminarConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActPreliminarConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncPreliminarConstruccion')"></td>
	</tr>
	<tr class="fila_1">
		<td class="tituloNivel1">Cimentaci&oacute;n</td>
		<td class="fechaNivel1"><input name="fchInicialCimentacionConstruccion" type="text" id="fchInicialCimentacionConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialCimentacionConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialCimentacionConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalCimentacionConstruccion" type="text" id="fchFinalCimentacionConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalCimentacionConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalCimentacionConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncCimentacionConstruccion" id="porcIncCimentacionConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncCimentacionConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActCimentacionConstruccion" id="valActCimentacionConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActCimentacionConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncCimentacionConstruccion')"></td>
	</tr>
	<tr class="fila_0">
		<td class="tituloNivel1">Desag&uuml;es e instalaciones sanitarias</td>
		<td class="fechaNivel1"><input name="fchInicialDesaguesConstruccion" type="text" id="fchInicialDesaguesConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialDesaguesConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialDesaguesConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalDesaguesConstruccion" type="text" id="fchFinalDesaguesConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalDesaguesConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalDesaguesConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncDesaguesConstruccion" id="porcIncDesaguesConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncDesaguesConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActDesaguesConstruccion" id="valActDesaguesConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActDesaguesConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncDesaguesConstruccion')"></td>
	</tr>
	<tr class="fila_1">
		<td  class="tituloNivel1">Estructura en concreto</td>
		<td class="fechaNivel1"><input name="fchInicialEstructuraConstruccion" type="text" id="fchInicialEstructuraConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialEstructuraConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialEstructuraConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalEstructuraConstruccion" type="text" id="fchFinalEstructuraConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalEstructuraConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalEstructuraConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncEstructuraConstruccion" id="porcIncEstructuraConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncEstructuraConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActEstructuraConstruccion" id="valActEstructuraConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActEstructuraConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncEstructuraConstruccion')"></td>
	</tr>
	<tr class="fila_0">
		<td class="tituloNivel1">Mamposter&iacute;a</td>
		<td class="fechaNivel1"><input name="fchInicialMamposteriaConstruccion" type="text" id="fchInicialMamposteriaConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialMamposteriaConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialMamposteriaConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalMamposteriaConstruccion" type="text" id="fchFinalMamposteriaConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalMamposteriaConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalMamposteriaConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncMamposteriaConstruccion" id="porcIncMamposteriaConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncMamposteriaConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActMamposteriaConstruccion" id="valActMamposteriaConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActMamposteriaConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncMamposteriaConstruccion')"></td>
	</tr>
	<tr class="fila_1">
		<td class="tituloNivel1">Pa&ntilde;etes y resanes</td>
		<td class="fechaNivel1"><input name="fchInicialPanetesConstruccion" type="text" id="fchInicialPanetesConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialPanetesConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialPanetesConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalPanetesConstruccion" type="text" id="fchFinalPanetesConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalPanetesConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalPanetesConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncPanetesConstruccion" id="porcIncPanetesConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncPanetesConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActPanetesConstruccion" id="valActPanetesConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActPanetesConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncPanetesConstruccion')"></td>
	</tr>
	<tr class="fila_0">
		<td class="tituloNivel1">Instalaciones hidrosanitarias</td>
		<td class="fechaNivel1"><input name="fchInicialHidrosanitariasConstruccion" type="text" id="fchInicialHidrosanitariasConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialHidrosanitariasConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialHidrosanitariasConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalHidrosanitariasConstruccion" type="text" id="fchFinalHidrosanitariasConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalHidrosanitariasConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalHidrosanitariasConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncHidrosanitariasConstruccion" id="porcIncHidrosanitariasConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncHidrosanitariasConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActHidrosanitariasConstruccion" id="valActHidrosanitariasConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActHidrosanitariasConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncHidrosanitariasConstruccion')"></td>
	</tr>
	<tr class="fila_1">
		<td class="tituloNivel1">Instalaciones el&eacute;ctricas</td>
		<td class="fechaNivel1"><input name="fchInicialElectricasConstruccion" type="text" id="fchInicialElectricasConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialElectricasConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialElectricasConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalElectricasConstruccion" type="text" id="fchFinalElectricasConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalElectricasConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalElectricasConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncElectricasConstruccion" id="porcIncElectricasConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncElectricasConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActElectricasConstruccion" id="valActElectricasConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActElectricasConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncElectricasConstruccion')"></td>
	</tr>
	<tr class="fila_0">
		<td class="tituloNivel1">Cubierta</td>
		<td class="fechaNivel1"><input name="fchInicialCubiertaConstruccion" type="text" id="fchInicialCubiertaConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialCubiertaConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialCubiertaConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalCubiertaConstruccion" type="text" id="fchFinalCubiertaConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalCubiertaConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalCubiertaConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncCubiertaConstruccion" id="porcIncCubiertaConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncCubiertaConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActCubiertaConstruccion" id="valActCubiertaConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActCubiertaConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncCubiertaConstruccion')"></td>
	</tr>
	<tr class="fila_1">
		<td class="tituloNivel1">Carpinter&iacute;a met&aacute;lica</td>
		<td class="fechaNivel1"><input name="fchInicialCarpinteriaConstruccion" type="text" id="fchInicialCarpinteriaConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialCarpinteriaConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialCarpinteriaConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalCarpinteriaConstruccion" type="text" id="fchFinalCarpinteriaConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalCarpinteriaConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalCarpinteriaConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncCarpinteriaConstruccion" id="porcIncCarpinteriaConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncCarpinteriaConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActCarpinteriaConstruccion" id="valActCarpinteriaConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActCarpinteriaConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncCarpinteriaConstruccion')"></td>
	</tr>
	<tr class="fila_0">
		<td class="tituloNivel1">Pisos, enchapes y acabados</td>
		<td class="fechaNivel1"><input name="fchInicialPisosConstruccion" type="text" id="fchInicialPisosConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialPisosConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialPisosConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalPisosConstruccion" type="text" id="fchFinalPisosConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalPisosConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalPisosConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncPisosConstruccion" id="porcIncPisosConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncPisosConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActPisosConstruccion" id="valActPisosConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActPisosConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncPisosConstruccion')"></td>
	</tr>
	<tr class="fila_1">
		<td class="tituloNivel1">Aparatos sanitarios y lavaplatos</td>
		<td class="fechaNivel1"><input name="fchInicialSanitariosConstruccion" type="text" id="fchInicialSanitariosConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialSanitariosConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialSanitariosConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalSanitariosConstruccion" type="text" id="fchFinalSanitariosConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalSanitariosConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalSanitariosConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncSanitariosConstruccion" id="porcIncSanitariosConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncSanitariosConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActSanitariosConstruccion" id="valActSanitariosConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActSanitariosConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncSanitariosConstruccion')"></td>
	</tr>
	<tr class="fila_0">
		<td class="tituloNivel1">Obras exteriores</td>
		<td class="fechaNivel1"><input name="fchInicialExterioresConstruccion" type="text" id="fchInicialExterioresConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialExterioresConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialExterioresConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalExterioresConstruccion" type="text" id="fchFinalExterioresConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalExterioresConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalExterioresConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncExterioresConstruccion" id="porcIncExterioresConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncExterioresConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActExterioresConstruccion" id="valActExterioresConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActExterioresConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncExterioresConstruccion')"></td>
	</tr>
	<tr class="fila_1">
		<td class="tituloNivel1">Aseo</td>
		<td class="fechaNivel1"><input name="fchInicialAseoConstruccion" type="text" id="fchInicialAseoConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialAseoConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialAseoConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalAseoConstruccion" type="text" id="fchFinalAseoConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalAseoConstruccion; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalAseoConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncAseoConstruccion" id="porcIncAseoConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncAseoConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActAseoConstruccion" id="valActAseoConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valActAseoConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncAseoConstruccion')"></td>
	</tr>
</table>