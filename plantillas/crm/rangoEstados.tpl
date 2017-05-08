{ assign var=numTotalHoy 		value=$claCrm->numTotalHoy }
{ assign var=numTotalSemana 	value=$claCrm->numTotalSemana }
{ assign var=numTotalMes 		value=$claCrm->numTotalMes }


<table cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td width="110px"><input type="radio" id="tipoDesembolsoRango" name="tipoDesembolsoRango" value="hoy" >Hoy </td>
		<td align="left">( <a type="text" onclick="reporteTotalHoySemanaDia( 'hoy', '{$txtEstado}' );" >{$numTotalHoy}</a> )</td>
	</tr>
	<tr>
		<td><input type="radio" id="tipoDesembolsoRango" name="tipoDesembolsoRango" value="semana" >Semana</td>
		<td align="left">( <a type="text" onclick="reporteTotalHoySemanaDia( 'semana', '{$txtEstado}' );" >{$numTotalSemana}</a> )</td>
	</tr>
	<tr>
		<td><input type="radio" id="tipoDesembolsoRango" name="tipoDesembolsoRango" value="mes" >Mes</td>
		<td align="left"> ( <a type="text" onclick="reporteTotalHoySemanaDia( 'mes', '{$txtEstado}' );" >{$numTotalMes}</a> )</td>
	</tr>
</table>