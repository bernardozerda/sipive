
{if $bolMostrarConfirmacion == true}

	<div id="dlgPedirConfirmacion" style="visibility: hidden; height: 1px;">
		<div class="hd">Se solicita atención del usuario...</div>
		<div class="bd" style="text-align:center">
			<form method="POST" action="{$txtArchivo}">
				<p>{$txtMensaje}</p>
                {foreach from=$arrPost key=txtClave item=txtValor}
                    {if not is_array( $txtValor )}
						<input type="hidden" name="{$txtClave}" value="{$txtValor}">
                    {else}
                        {if isset( $arrPost.hogar )}
                            {foreach from=$arrPost.hogar key=numDocumento item=arrCiudadano}
                                {foreach from=$arrCiudadano key=txtClave item=txtValor}
									<input type="hidden" name="hogar[{$numDocumento}][{$txtClave}]" value="{$txtValor}">
                                {/foreach}
                            {/foreach}
                        {else}
                            {foreach from=$txtValor name=arreglo item=txtVariable}
                                {if $txtClave != "hogar"}
									<input type="hidden" name="{$txtClave}[]" value="{$txtVariable}">
                                {/if}
                            {/foreach}
                        {/if}
                    {/if}
                {/foreach}
			</form>
		</div>
	</div>
	<div id="dlgPedirConfirmacionListener"></div>
{/if}