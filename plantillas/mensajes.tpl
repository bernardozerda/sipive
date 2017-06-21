
{if trim($estilo) == ""}
    {assign var=estilo value="msgError"}
{/if}

{if not empty( $arrImprimir )}
    <table cellpadding="0" cellspacing="0" border="0" width="100%" id="tablaMensajes" style="padding:5px" class="{$estilo}">
        {foreach from=$arrImprimir item=txtMensaje}
            <tr>
                <td class="{$estilo}">
                    <li>
                        {if trim($txtMensaje) != ""}
                            {$txtMensaje}
                        {else}
                            &nbsp;
                        {/if}
                    </li>
                </td>
            </tr>
        {/foreach}
    </table>
{/if}

{if $idDivOculto != ""}
    <div id="{$idDivOculto}"></div>
{/if}