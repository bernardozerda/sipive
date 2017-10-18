{if not empty( $arrTipoActo )}
    {foreach from=$arrActos key=seqTipoActo item=arrListado}
        <div class="menuLateral" style="cursor: pointer;" onClick="mostrarOcultar('{$seqTipoActo}');">
            {$arrTipoActo.$seqTipoActo->txtTipoActo} [{$arrListado.conteo}]
        </div>
        <div id="{$seqTipoActo}" style="display: none;">
            {foreach from=$arrListado.listado item=arrActo}
                <div id=""
                     style="padding-left: 30px; height: 15px; cursor: pointer;"
                     onMouseOver="this.style.background='#EDEDED'"
                     onMouseOut="this.style.background='#F9F9F9'"
                        onClick="cargarContenido('informacion','contenidos/aad/informacion.php','seqTipoActo={$seqTipoActo}&numActo={$arrActo.numero}&fchActo={$arrActo.fecha}',true)"
                >
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                            <td align="right" width="40px">{$arrActo.numero}</td>
                            <td align="center" width="30px">del</td>
                            <td align="center" width="70px">{$arrActo.fecha}</td>
                            <td align="center">
                                {if isset( $smarty.session.arrGrupos.3.20 )}
                                    <a href="#" onClick="eliminarAAD({$arrActo.numero},'{$arrActo.fecha}')">Eliminar</a>
                                {else}
                                    &nbsp;
                                {/if}
                            </td>
                        </tr>
                    </table>
                </div>
            {/foreach}
        </div>
    {/foreach}
{else}
    <div class="msgError">No hay registros</div>
{/if}