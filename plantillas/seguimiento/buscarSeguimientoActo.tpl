
{if $arrRegistros|@count != 0}
	<table cellpadding="0" cellspacing="0" width="100%" border="0">
		{foreach from=$arrRegistros key=seqRegistro item=arrInformacion}
			<tr>
				<td bgcolor="#E4E4E4" colspan="2" height="22px">
					<b>Registro No:</b> {$seqRegistro|number_format:'0':'.':','}&nbsp;
					{if $arrInformacion.txtCambios != ""}
						<a href="#" onClick="verCambiosFormularioActos( '{$arrInformacion.seqFormulario}', '{$arrInformacion.seqFormularioActo}' , '{$seqRegistro}' );">Detalles</a>
					{/if}
				</td>
			</tr>
			<tr>
				<td width="400px" valign="top" 
					style="border-bottom: 1px dotted #999999; border-right: 1px dotted #999999; padding-bottom: 5px; padding-top: 3px;"
				>
					<b>Fecha del Registro:</b> {$arrInformacion.fchMovimiento} <br>
					<b>Grupo Gestión:</b> {$arrInformacion.txtGrupoGestion}<br>
					<b>Seguimiento:</b> {$arrInformacion.txtGestion}<br>
					<b>Ciudadano Atendido:</b> {$arrInformacion.txtAtendido}<br>
					<b>Documento Atendido:</b> {$arrInformacion.numAtendido|number_format:'0':'.':','}<br>
					<b>Atendido por:</b> {$arrInformacion.txtUsuario}<br>
				</td>
				<td align="justify" valign="top" style="padding-left:5px; border-bottom: 1px dotted #999999; padding-bottom: 3px; padding-top: 3px;">
					{$arrInformacion.txtComentario}
				</td>
			</tr>
		{/foreach}
	</table>
{else}
    <table cellpadding="0" cellspacing="0" border="0" width="100%" id="tablaMensajes" style="padding:5px">
    	<tr><td class="msgError"><li>No hay seguimientos registrados para este formulario</li></td></tr>
    </table>
{/if}