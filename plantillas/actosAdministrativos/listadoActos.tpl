{if not empty( $arrTipoActo )}
    {foreach from=$arrTipoActo key=seqTipoActo item=objTipoActo}
        <div class="menuLateral" style="cursor: pointer;" onClick="mostrarOcultar('{$objTipoActo->txtTipoActo}');">
            {$objTipoActo->txtTipoActo} [{$arrConteo.$seqTipoActo|intval}]
        </div>
        <div id="{$objTipoActo->txtTipoActo}" style="display: none;">
            {foreach from=$arrActos item=objActo}
                {if $objActo->seqTipoActo == $seqTipoActo}
                    <div id=""
                         style="padding-left: 30px; height: 15px; cursor: pointer;"
                         onMouseOver="this.style.background='#EDEDED'"
                         onMouseOut="this.style.background='#F9F9F9'"
                         onClick="cargarContenido('informacion','contenidos/actosAdministrativos/informacionActo.php','seqTipoActo={$seqTipoActo}&numActo={$objActo->numActo}&fchActo={$objActo->fchActo}',true)"
                    >
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                                <td align="right" width="40px">{$objActo->numActo}</td>
                                <td align="center" width="30px">del</td>
                                <td align="center" width="70px">{$objActo->fchActo}</td>
                                <td align="center">
                                    {if isset( $smarty.session.arrGrupos.3.20 )}
                                        <a href="#" onClick="eliminarActoAdministrativo({$objActo->numActo},'{$objActo->fchActo}')">Eliminar</a>
                                    {else}
                                        &nbsp;
                                    {/if}
                                </td>
                            </tr>
                        </table>
                    </div>
                {/if}
            {/foreach}
        </div>
    {/foreach}
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div style="border-width: 1px;  border-style: dotted; border-width: 1px;">
        <table>
            <tr>
                <td align="center"><img src='/recursos/imagenes/alerta-icono-pequeno.jpg'></td>
            </tr>
            <tr>
                <td style="color:#FF0000; text-align:justify">Confirmar la inclusi&oacute;n de todos los hogares
                    relacionados en los diferentes art&iacute;culos del acto administrativo (Hogares vulnerables y v&iacute;ctimas
                    / proyectos, seg&uacute;n corresponda)
                </td>
            </tr>
        </table>
    </div>
{else}
    <div class="msgError">No hay registros</div>
{/if}

