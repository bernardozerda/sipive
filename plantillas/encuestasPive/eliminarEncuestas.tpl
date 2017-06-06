{if $arrPost.bolConfirmado == 0}
	<div id="dlgPedirConfirmacion" style="visibility: hidden; height: 1px;">
		<div class="hd">Se solicita atención del usuario...</div>
		<div class="bd" style="text-align:center">
		<form method="POST" action="./contenidos/encuestasPive/eliminarEncuestas.php">
			<p>Confirme que desea eliminar la aplicación!!</p>
	         {foreach from=$arrPost key=txtClave item=txtValor}
					<input type="hidden" name="{$txtClave}" value="{$txtValor}">
				{/foreach}    
		</form>
		</div>
	</div>
	<div id="dlgPedirConfirmacionListener"></div>
{else}
    <table cellpadding="0" cellspacing="0" border="0" width="100%" id="tablaMensajes" style="padding:5px" class="{$estilo}">
       {foreach from=$arrImprimir item=txtMensaje}
           <tr><td class="{$estilo}"><li>{$txtMensaje}</li></td></tr>
       {/foreach}
    </table>
{/if}
