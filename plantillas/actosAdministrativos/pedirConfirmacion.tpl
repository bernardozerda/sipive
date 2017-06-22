{if $bolConfirmacion == true}

    <div id="dlgPedirConfirmacion" style="visibility: hidden; height: 1px;">
        <div class="hd">Se solicita atención del usuario...</div>
        <div class="bd" style="text-align:center">
            <form method="POST" action="{$txtArchivo}">
                <p>{$txtMensaje}</p>
                {foreach from=$arrPost.hogar key=numDocumento item=arrCiudadano}
                    {foreach from=$arrCiudadano key=txtClave item=txtValor}
                        <input type="hidden" name="hogar[{$numDocumento}][{$txtClave}]" value="{$txtValor}">
                    {/foreach}
                {/foreach}
                {foreach from=$arrPost key=txtClave item=txtValor}
                    {if $txtClave != "hogar"}
                        <input type="hidden" name="{$txtClave}" value="{$txtValor}">
                    {/if}
                {/foreach}
            </form>
        </div>
    </div>

    <div id="dlgPedirConfirmacionListener"></div>

{/if}