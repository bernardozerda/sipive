<table border="0" cellspacing="2" cellpadding="0" width="100%">
	<tr><td colspan="5" align="right"><font color="#ff0000"><i>Nota: Los n&uacute;meros decimales se deben separar con punto (.)</i></font></td></tr>
	<tr class="tituloTabla">
		<th width="30%" align="center" style="padding:3px;">Actividad</th>
		<th width="20%" align="center" style="padding:3px;">Fecha Inicial Actividad</th>
		<th width="20%" align="center" style="padding:3px;">Fecha Final Actividad</th>
		<th width="15%" align="center" style="padding:3px;">% Incidencia</th>
		<th width="15%" align="center" style="padding:3px;">Valor Actividad</th>
	</tr>
	<tr>
		<td width="30%" class="tituloNivel1">Terreno</td>
		<td width="20%" class="fechaNivel1"><input name="fchInicialTerreno" type="text" id="fchInicialTerreno" value="{$objFormularioProyecto->fchInicialTerreno}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialTerreno' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td width="20%" class="fechaNivel1"><input name="fchFinalTerreno" type="text" id="fchFinalTerreno" value="{$objFormularioProyecto->fchFinalTerreno}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalTerreno' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
		<td class="campoNivel1" width="15%"><input type="text" class="campoValornivell" name="porcIncTerreno" id="porcIncTerreno" value="{$objFormularioProyecto->porcIncTerreno}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); "></td>
		<td class="campoNivel1" width="15%">$ <input type="text" class="campoValornivell" name="valActTerreno" id="valActTerreno" value="{$objFormularioProyecto->valActTerreno}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaPorcentajeSegunValorCosto(this, 'porcIncTerreno')"></td>
	</tr>
</table>
