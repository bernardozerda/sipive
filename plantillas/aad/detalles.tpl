{if not empty($claActoAdministrativo->arrDetalles.detalle)}
    <table id="detallesAAD" class="display nowrap" cellspacing="0" cellpadding="3">
        <thead>
            <tr>
                {foreach from=$claActoAdministrativo->arrDetalles.titulos item=txtTitulo}
                    <th>{$txtTitulo}</th>
                {/foreach}
            </tr>
        </thead>
        <tbody>
            {foreach from=$claActoAdministrativo->arrDetalles.detalle item=arrDetalle}
                <tr>
                    {foreach from=$arrDetalle item=txtCelda}
                        <td>{$txtCelda}</td>
                    {/foreach}
                </tr>
            {/foreach}
        </tbody>
    </table>
    <hr>
    <div id="listenerDetallesAAD"></div>
{/if}
{if not empty($claActoAdministrativo->arrDetalles.resumen)}
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td width="250px">
                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                    {foreach from=$claActoAdministrativo->arrDetalles.resumen key=txtTitulo item=txtValor}
                        <tr>
                            <td width="120px;">
                                <strong>{$txtTitulo}:</strong>
                            </td>
                            <td>
                                {if is_numeric($txtValor)}
                                    {$txtValor|number_format}
                                {else}
                                    {$txtValor}
                                {/if}
                            </td>
                        </tr>
                    {/foreach}
                </table>
            </td>
            <td width="100px">
                <button style="width:60px; height:40px;" type="button" onClick="location.href='contenidos/aad/exportar.php?seqTipoActo={$claActoAdministrativo->seqTipoActo}&numActo={$claActoAdministrativo->numActo}&fchActo={$claActoAdministrativo->fchActo}&exportar=detalles'">
                    <img src="recursos/imagenes/excel-48.png" width="20px;" height="20px;"><br>
                    <span style="font-size: 10px; font-weight: bold;">Detalles</span>
                    <input type="hidden" name="seqTipoActo" value="{$claActoAdministrativo->seqTipoActo}">
                    <input type="hidden" name="numActo" value="{$claActoAdministrativo->numActo}">
                    <input type="hidden" name="fchActo" value="{$claActoAdministrativo->fchActo}">
                    <input type="hidden" name="exportar" value="detalles">
                </button>
            </td>
            <td>
                <button style="width:60px; height:40px;" type="button" onclick="location.href='contenidos/aad/exportar.php?seqTipoActo={$claActoAdministrativo->seqTipoActo}&numActo={$claActoAdministrativo->numActo}&fchActo={$claActoAdministrativo->fchActo}&exportar=hogares'">
                    <img src="recursos/imagenes/excel-48.png" width="20px;" height="20px;"><br>
                    <span style="font-size: 10px; font-weight: bold;">Hogares</span>
                </button>
            </td>
        </tr>
    </table>
{/if}