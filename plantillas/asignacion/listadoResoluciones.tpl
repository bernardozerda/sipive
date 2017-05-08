<table cellpadding="1" cellspacing="0" border="0" width="100%">
	{if $seqNotificacion neq 7}
	<tr><td colspan="2" class="tituloTabla">
		Listado de Resoluciones
	</td></tr>
	{/if}
	
	{foreach from=$arrListadoActos item=arrActo}
		<tr>
			<td valign="top">
				<div class="botonMas" 
					 onClick="mostrarOcultar('descripcion{$arrActo.numActo}{$arrActo.fchActo}');"
				>
					+
				</div>
				<div style="cursor:pointer; height:15px; width:270px; float:left; padding-left:5px;" 
					onClick="someterFormulario( 
								'mensajes' , 
								document.getElementById('{$arrActo.numActo}{$arrActo.fchActo}') , 
								'./contenidos/asignacion/exportarActo.php' , 
								true , 
								false 
							);"
					onMouseOver="this.style.background='#E4E4E4'" 
					onMouseOut="this.style.background='#F9F9F9'"
				>
					<form id="{$arrActo.numActo}{$arrActo.fchActo}">
						{$arrActo.txtTipoActo}: {$arrActo.numActo} / {$arrActo.fchActo}
						<input type="hidden" name="numActo" value="{$arrActo.numActo}">
						<input type="hidden" name="fchActo" value="{$arrActo.fchActo}">
					</form> 
				</div>
				<div style="padding-left:17px; display:none; float:left;" id="descripcion{$arrActo.numActo}{$arrActo.fchActo}">
					<b>Hogares Vinculados:</b> {$arrActo.cantidad} <br>
					{foreach from=$arrActo.caracteristicas key=txtCaracteristica item=txtValor}
						<b>{$txtCaracteristica}:</b> 
						{if is_numeric($txtValor)}
							{$txtValor|number_format:0:'.':','}
						{else}
							{$txtValor}
						{/if}
						<br>
					{/foreach}
				</div>
			</td>
		</tr>
	{/foreach}
	
</table>