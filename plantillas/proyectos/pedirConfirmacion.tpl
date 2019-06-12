
{if $bolMostrarConfirmacion == true}

    <div id="dlgPedirConfirmacion" style="visibility: hidden; height: 1px;">
        <div class="hd">Se solicita atención del usuario...</div>
        <div class="bd" style="text-align:center">
            <form method="POST" action="{$txtArchivo}">
                <p>{$txtMensaje}</p>
                {foreach from=$arrPost key=txtClave item=arrValor}
                    {if is_array( $arrValor )}
                        {foreach from=$arrValor key=txtNombre item=txtValor}
                            <input type="hidden" name="{$txtClave}[]" value="{$txtValor}">
                        {/foreach}
                    {else}
                        <input type="hidden" name="{$txtClave}" value="{$arrValor}">
                    {/if}

                {/foreach}
            </form>
        </div>
    </div>

    <div id="dlgPedirConfirmacionListener"></div>

{/if}