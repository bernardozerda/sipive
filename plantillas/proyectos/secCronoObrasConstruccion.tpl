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
		<td width="20%" class="fechaNivel1"><input name="fchInicialPreliminarConstruccion" type="text" id="fchInicialPreliminarConstruccion" value="{$objFormularioProyecto->fchInicialPreliminarConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialPreliminarConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td width="20%" class="fechaNivel1"><input name="fchFinalPreliminarConstruccion" type="text" id="fchFinalPreliminarConstruccion" value="{$objFormularioProyecto->fchFinalPreliminarConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalPreliminarConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td width="15%" class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncPreliminarConstruccion" id="porcIncPreliminarConstruccion" value="{$objFormularioProyecto->porcIncPreliminarConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );"></td>
		<td width="15%" class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActPreliminarConstruccion" id="valActPreliminarConstruccion" value="{$objFormularioProyecto->valActPreliminarConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncPreliminarConstruccion')"></td>
	</tr>
	<tr class="fila_1">
		<td class="tituloNivel1">Cimentaci&oacute;n</td>
		<td class="fechaNivel1"><input name="fchInicialCimentacionConstruccion" type="text" id="fchInicialCimentacionConstruccion" value="{$objFormularioProyecto->fchInicialCimentacionConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialCimentacionConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalCimentacionConstruccion" type="text" id="fchFinalCimentacionConstruccion" value="{$objFormularioProyecto->fchFinalCimentacionConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalCimentacionConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncCimentacionConstruccion" id="porcIncCimentacionConstruccion" value="{$objFormularioProyecto->porcIncCimentacionConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActCimentacionConstruccion" id="valActCimentacionConstruccion" value="{$objFormularioProyecto->valActCimentacionConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncCimentacionConstruccion')"></td>
	</tr>
	<tr class="fila_0">
		<td class="tituloNivel1">Desag&uuml;es e instalaciones sanitarias</td>
		<td class="fechaNivel1"><input name="fchInicialDesaguesConstruccion" type="text" id="fchInicialDesaguesConstruccion" value="{$objFormularioProyecto->fchInicialDesaguesConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialDesaguesConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalDesaguesConstruccion" type="text" id="fchFinalDesaguesConstruccion" value="{$objFormularioProyecto->fchFinalDesaguesConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalDesaguesConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncDesaguesConstruccion" id="porcIncDesaguesConstruccion" value="{$objFormularioProyecto->porcIncDesaguesConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActDesaguesConstruccion" id="valActDesaguesConstruccion" value="{$objFormularioProyecto->valActDesaguesConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncDesaguesConstruccion')"></td>
	</tr>
	<tr class="fila_1">
		<td  class="tituloNivel1">Estructura en concreto</td>
		<td class="fechaNivel1"><input name="fchInicialEstructuraConstruccion" type="text" id="fchInicialEstructuraConstruccion" value="{$objFormularioProyecto->fchInicialEstructuraConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialEstructuraConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalEstructuraConstruccion" type="text" id="fchFinalEstructuraConstruccion" value="{$objFormularioProyecto->fchFinalEstructuraConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalEstructuraConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncEstructuraConstruccion" id="porcIncEstructuraConstruccion" value="{$objFormularioProyecto->porcIncEstructuraConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActEstructuraConstruccion" id="valActEstructuraConstruccion" value="{$objFormularioProyecto->valActEstructuraConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncEstructuraConstruccion')"></td>
	</tr>
	<tr class="fila_0">
		<td class="tituloNivel1">Mamposter&iacute;a</td>
		<td class="fechaNivel1"><input name="fchInicialMamposteriaConstruccion" type="text" id="fchInicialMamposteriaConstruccion" value="{$objFormularioProyecto->fchInicialMamposteriaConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialMamposteriaConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalMamposteriaConstruccion" type="text" id="fchFinalMamposteriaConstruccion" value="{$objFormularioProyecto->fchFinalMamposteriaConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalMamposteriaConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncMamposteriaConstruccion" id="porcIncMamposteriaConstruccion" value="{$objFormularioProyecto->porcIncMamposteriaConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActMamposteriaConstruccion" id="valActMamposteriaConstruccion" value="{$objFormularioProyecto->valActMamposteriaConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncMamposteriaConstruccion')"></td>
	</tr>
	<tr class="fila_1">
		<td class="tituloNivel1">Pa&ntilde;etes y resanes</td>
		<td class="fechaNivel1"><input name="fchInicialPanetesConstruccion" type="text" id="fchInicialPanetesConstruccion" value="{$objFormularioProyecto->fchInicialPanetesConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialPanetesConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalPanetesConstruccion" type="text" id="fchFinalPanetesConstruccion" value="{$objFormularioProyecto->fchFinalPanetesConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalPanetesConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncPanetesConstruccion" id="porcIncPanetesConstruccion" value="{$objFormularioProyecto->porcIncPanetesConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActPanetesConstruccion" id="valActPanetesConstruccion" value="{$objFormularioProyecto->valActPanetesConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncPanetesConstruccion')"></td>
	</tr>
	<tr class="fila_0">
		<td class="tituloNivel1">Instalaciones hidrosanitarias</td>
		<td class="fechaNivel1"><input name="fchInicialHidrosanitariasConstruccion" type="text" id="fchInicialHidrosanitariasConstruccion" value="{$objFormularioProyecto->fchInicialHidrosanitariasConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialHidrosanitariasConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalHidrosanitariasConstruccion" type="text" id="fchFinalHidrosanitariasConstruccion" value="{$objFormularioProyecto->fchFinalHidrosanitariasConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalHidrosanitariasConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncHidrosanitariasConstruccion" id="porcIncHidrosanitariasConstruccion" value="{$objFormularioProyecto->porcIncHidrosanitariasConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActHidrosanitariasConstruccion" id="valActHidrosanitariasConstruccion" value="{$objFormularioProyecto->valActHidrosanitariasConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncHidrosanitariasConstruccion')"></td>
	</tr>
	<tr class="fila_1">
		<td class="tituloNivel1">Instalaciones el&eacute;ctricas</td>
		<td class="fechaNivel1"><input name="fchInicialElectricasConstruccion" type="text" id="fchInicialElectricasConstruccion" value="{$objFormularioProyecto->fchInicialElectricasConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialElectricasConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalElectricasConstruccion" type="text" id="fchFinalElectricasConstruccion" value="{$objFormularioProyecto->fchFinalElectricasConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalElectricasConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncElectricasConstruccion" id="porcIncElectricasConstruccion" value="{$objFormularioProyecto->porcIncElectricasConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActElectricasConstruccion" id="valActElectricasConstruccion" value="{$objFormularioProyecto->valActElectricasConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncElectricasConstruccion')"></td>
	</tr>
	<tr class="fila_0">
		<td class="tituloNivel1">Cubierta</td>
		<td class="fechaNivel1"><input name="fchInicialCubiertaConstruccion" type="text" id="fchInicialCubiertaConstruccion" value="{$objFormularioProyecto->fchInicialCubiertaConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialCubiertaConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalCubiertaConstruccion" type="text" id="fchFinalCubiertaConstruccion" value="{$objFormularioProyecto->fchFinalCubiertaConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalCubiertaConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncCubiertaConstruccion" id="porcIncCubiertaConstruccion" value="{$objFormularioProyecto->porcIncCubiertaConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActCubiertaConstruccion" id="valActCubiertaConstruccion" value="{$objFormularioProyecto->valActCubiertaConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncCubiertaConstruccion')"></td>
	</tr>
	<tr class="fila_1">
		<td class="tituloNivel1">Carpinter&iacute;a met&aacute;lica</td>
		<td class="fechaNivel1"><input name="fchInicialCarpinteriaConstruccion" type="text" id="fchInicialCarpinteriaConstruccion" value="{$objFormularioProyecto->fchInicialCarpinteriaConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialCarpinteriaConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalCarpinteriaConstruccion" type="text" id="fchFinalCarpinteriaConstruccion" value="{$objFormularioProyecto->fchFinalCarpinteriaConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalCarpinteriaConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncCarpinteriaConstruccion" id="porcIncCarpinteriaConstruccion" value="{$objFormularioProyecto->porcIncCarpinteriaConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActCarpinteriaConstruccion" id="valActCarpinteriaConstruccion" value="{$objFormularioProyecto->valActCarpinteriaConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncCarpinteriaConstruccion')"></td>
	</tr>
	<tr class="fila_0">
		<td class="tituloNivel1">Pisos, enchapes y acabados</td>
		<td class="fechaNivel1"><input name="fchInicialPisosConstruccion" type="text" id="fchInicialPisosConstruccion" value="{$objFormularioProyecto->fchInicialPisosConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialPisosConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalPisosConstruccion" type="text" id="fchFinalPisosConstruccion" value="{$objFormularioProyecto->fchFinalPisosConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalPisosConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncPisosConstruccion" id="porcIncPisosConstruccion" value="{$objFormularioProyecto->porcIncPisosConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActPisosConstruccion" id="valActPisosConstruccion" value="{$objFormularioProyecto->valActPisosConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncPisosConstruccion')"></td>
	</tr>
	<tr class="fila_1">
		<td class="tituloNivel1">Aparatos sanitarios y lavaplatos</td>
		<td class="fechaNivel1"><input name="fchInicialSanitariosConstruccion" type="text" id="fchInicialSanitariosConstruccion" value="{$objFormularioProyecto->fchInicialSanitariosConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialSanitariosConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalSanitariosConstruccion" type="text" id="fchFinalSanitariosConstruccion" value="{$objFormularioProyecto->fchFinalSanitariosConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalSanitariosConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncSanitariosConstruccion" id="porcIncSanitariosConstruccion" value="{$objFormularioProyecto->porcIncSanitariosConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActSanitariosConstruccion" id="valActSanitariosConstruccion" value="{$objFormularioProyecto->valActSanitariosConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncSanitariosConstruccion')"></td>
	</tr>
	<tr class="fila_0">
		<td class="tituloNivel1">Obras exteriores</td>
		<td class="fechaNivel1"><input name="fchInicialExterioresConstruccion" type="text" id="fchInicialExterioresConstruccion" value="{$objFormularioProyecto->fchInicialExterioresConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialExterioresConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalExterioresConstruccion" type="text" id="fchFinalExterioresConstruccion" value="{$objFormularioProyecto->fchFinalExterioresConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalExterioresConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncExterioresConstruccion" id="porcIncExterioresConstruccion" value="{$objFormularioProyecto->porcIncExterioresConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActExterioresConstruccion" id="valActExterioresConstruccion" value="{$objFormularioProyecto->valActExterioresConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncExterioresConstruccion')"></td>
	</tr>
	<tr class="fila_1">
		<td class="tituloNivel1">Aseo</td>
		<td class="fechaNivel1"><input name="fchInicialAseoConstruccion" type="text" id="fchInicialAseoConstruccion" value="{$objFormularioProyecto->fchInicialAseoConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialAseoConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="fechaNivel1"><input name="fchFinalAseoConstruccion" type="text" id="fchFinalAseoConstruccion" value="{$objFormularioProyecto->fchFinalAseoConstruccion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalAseoConstruccion' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1"><input type="text" class="campoValornivell" name="porcIncAseoConstruccion" id="porcIncAseoConstruccion" value="{$objFormularioProyecto->porcIncAseoConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1">$ <input type="text" class="campoValornivell" name="valActAseoConstruccion" id="valActAseoConstruccion" value="{$objFormularioProyecto->valActAseoConstruccion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncAseoConstruccion')"></td>
	</tr>
</table>