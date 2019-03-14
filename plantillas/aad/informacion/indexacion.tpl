
<!-- CDP Y RP -->
<div class="list-group col-sm-12">
    {section name=cdp start=1 loop=3}

        {assign var=numPry    value="numPry"|cat:$smarty.section.cdp.index}
        {assign var=numCdp    value="numCdp"|cat:$smarty.section.cdp.index}
        {assign var=valCdp    value="valCdp"|cat:$smarty.section.cdp.index}
        {assign var=fchCdp    value="fchCdp"|cat:$smarty.section.cdp.index}
        {assign var=numVigCdp value="numVigCdp"|cat:$smarty.section.cdp.index}

        {assign var=numRp    value="numRp"|cat:$smarty.section.cdp.index}
        {assign var=valRp    value="valRp"|cat:$smarty.section.cdp.index}
        {assign var=fchRp    value="fchRp"|cat:$smarty.section.cdp.index}
        {assign var=numVigRp value="numVigRp"|cat:$smarty.section.cdp.index}

        <!-- verifica si debe mostrar el div de datos del CDP -->
        {if
        (
        $claActo->arrCaracteristicas.numPry[$smarty.section.cdp.index] != 0    ||
        $claActo->arrCaracteristicas.numCdp[$smarty.section.cdp.index] != 0    ||
        $claActo->arrCaracteristicas.valCdp[$smarty.section.cdp.index] != 0    ||
        $claActo->arrCaracteristicas.fchCdp[$smarty.section.cdp.index] != ''   ||
        $claActo->arrCaracteristicas.numVigCdp[$smarty.section.cdp.index] != 0 ||

        $claActo->arrCaracteristicas.numRp[$smarty.section.cdp.index] != 0     ||
        $claActo->arrCaracteristicas.valRp[$smarty.section.cdp.index] != 0     ||
        $claActo->arrCaracteristicas.fchRp[$smarty.section.cdp.index] != ''    ||
        $claActo->arrCaracteristicas.numVigRp[$smarty.section.cdp.index] != 0

        ) || (
        $arrPost.$numPry != 0    ||
        $arrPost.$numCdp != 0    ||
        $arrPost.$valCdp != 0    ||
        $arrPost.$fchCdp != ''   ||
        $arrPost.$numVigCdp != 0 ||

        $arrPost.$numRp != 0    ||
        $arrPost.$valRp != 0    ||
        $arrPost.$fchRp != ''   ||
        $arrPost.$numVigRp != 0
        )
        }
            {assign var=txtDisplay value=""}
        {else}
            {assign var=txtDisplay value="none"}
        {/if}

        <button type="button"
                class="list-group-item {if $txtDisplay == ''} list-group-item-info {else}  {/if}"
                onClick="mostrarOcultar('CdpRp{$smarty.section.cdp.index}')"
        >CDP y RP {$smarty.section.cdp.index}</button>

        <div class="col-sm-12" id="CdpRp{$smarty.section.cdp.index}" style="display: {$txtDisplay}; padding-top: 10px;">

            <!-- PROYECTO DE INVERSION -->
            <div class="form-group">
                <label class="control-label col-sm-3" for="numPry{$smarty.section.cdp.index}" style="text-align: left">Proyecto de inversión</label>
                <div class="col-sm-2">
                    <input type="text"
                           id="numPry{$smarty.section.cdp.index}"
                           name="numPry{$smarty.section.cdp.index}"
                           value="{if intval($claActo->seqTipoActo) != 0}{$claActo->arrCaracteristicas.numPry[$smarty.section.cdp.index]}{elseif intval($arrPost.$numPry) != 0}{$arrPost.$numPry}{/if}"
                           class="form-control input-sm"
                           onKeyUp="formatoSeparadores(this)"
                            {if intval($claActo->seqTipoActo) != 0} disabled {/if}
                    >
                </div>
            </div>

            <!-- CDP -->
            <div class="form-group">
                <label class="control-label col-sm-1" for="numCdp{$smarty.section.cdp.index}">CDP</label>
                <div class="col-sm-1">
                    <input  type="text"
                            id="numCdp{$smarty.section.cdp.index}"
                            name="numCdp{$smarty.section.cdp.index}"
                            value="{if intval($claActo->seqTipoActo) != 0}{$claActo->arrCaracteristicas.numCdp[$smarty.section.cdp.index]}{elseif intval($arrPost.$numCdp) != 0}{$arrPost.$numCdp}{/if}"
                            class="form-control input-sm"
                            onKeyUp="formatoSeparadores(this)"
                            style="width: 60px"
                            {if intval($claActo->seqTipoActo) != 0} disabled {/if}
                    >
                </div>
                <label class="control-label col-sm-1" for="valCdp{$smarty.section.cdp.index}">Valor</label>
                <div class="col-sm-3">
                    <input type="text"
                           id="valCdp{$smarty.section.cdp.index}"
                           name="valCdp{$smarty.section.cdp.index}"
                           value="{if intval($claActo->seqTipoActo) != 0}{$claActo->arrCaracteristicas.valCdp[$smarty.section.cdp.index]|number_format:0:'.':'.'}{elseif doubleval($arrPost.$valCdp) != 0}{$arrPost.$valCdp|number_format:0:'.':'.'}{/if}"
                           class="form-control input-sm"
                           onKeyUp="formatoSeparadores(this)"
                            {if intval($claActo->seqTipoActo) != 0} disabled {/if}
                    >
                </div>
                <label class="control-label col-sm-1" for="valCdp{$smarty.section.cdp.index}">Fecha</label>
                <div class="col-sm-3">
                    <div class="input-group input-group-sm date"
                            {if intval($claActo->seqTipoActo) == 0}
                                onclick="$('#fchCdp{$smarty.section.cdp.index}').trigger('focus')"
                            {/if}
                    >
                        <label class="input-group-btn">
                                <span class="btn btn-default btn-sm {if intval($claActo->seqTipoActo) != 0} disabled {/if}">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                </span>
                        </label>
                        <input type="text"
                               id="fchCdp{$smarty.section.cdp.index}"
                               name="fchCdp{$smarty.section.cdp.index}"
                               class="form-control"
                               readonly
                                {if intval($claActo->seqTipoActo) != 0} disabled {/if}
                               value="{if intval($claActo->seqTipoActo) != 0}{$claActo->arrCaracteristicas.fchCdp[$smarty.section.cdp.index]}{else}{$arrPost.$fchCdp}{/if}"
                        >
                    </div>
                </div>
                <label class="control-label col-sm-1" for="numVigCdp{$smarty.section.cdp.index}">Vigencia</label>
                <div class="col-sm-1">
                    <input type="text"
                           id="numVigCdp{$smarty.section.cdp.index}"
                           name="numVigCdp{$smarty.section.cdp.index}"
                           value="{if intval($claActo->seqTipoActo) != 0}{$claActo->arrCaracteristicas.numVigCdp[$smarty.section.cdp.index]}{elseif intval($arrPost.$numVigCdp) != 0}{$arrPost.$numVigCdp}{/if}"
                           class="form-control input-sm"
                           onKeyUp="formatoSeparadores(this)"
                            {if intval($claActo->seqTipoActo) != 0} disabled {/if}
                           style="width: 60px"
                    >
                </div>
            </div>

            <!-- RP -->
            <div class="form-group">
                <label class="control-label col-sm-1" for="numRp{$smarty.section.cdp.index}">Rp</label>
                <div class="col-sm-1">
                    <input type="text"
                           id="numRp{$smarty.section.cdp.index}"
                           name="numRp{$smarty.section.cdp.index}"
                           value="{if intval($claActo->seqTipoActo) != 0}{$claActo->arrCaracteristicas.numRp[$smarty.section.cdp.index]}{elseif intval($arrPost.$numRp) != 0}{$arrPost.$numRp}{/if}"
                           class="form-control input-sm"
                           onKeyUp="formatoSeparadores(this)"
                           style="width: 60px"
                            {if intval($claActo->seqTipoActo) != 0} disabled {/if}
                    >
                </div>
                <label class="control-label col-sm-1" for="valRp{$smarty.section.cdp.index}">Valor</label>
                <div class="col-sm-3">
                    <input type="text"
                           id="valRp{$smarty.section.cdp.index}"
                           name="valRp{$smarty.section.cdp.index}"
                           value="{if intval($claActo->seqTipoActo) != 0}{$claActo->arrCaracteristicas.valRp[$smarty.section.cdp.index]|number_format:0:'.':'.'}{elseif doubleval($arrPost.$valRp) != 0}{$arrPost.$valRp|number_format:0:'.':'.'}{/if}"
                           class="form-control input-sm"
                           onKeyUp="formatoSeparadores(this)"
                            {if intval($claActo->seqTipoActo) != 0} disabled {/if}
                    >
                </div>
                <label class="control-label col-sm-1" for="valRp{$smarty.section.cdp.index}">Fecha</label>
                <div class="col-sm-3">
                    <div class="input-group input-group-sm date"
                            {if intval($claActo->seqTipoActo) == 0}
                                onclick="$('#fchRp{$smarty.section.cdp.index}').trigger('focus')"
                            {/if}
                    >
                        <label class="input-group-btn">
                                <span class="btn btn-default btn-sm {if intval($claActo->seqTipoActo) != 0} disabled {/if}">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                </span>
                        </label>
                        <input type="text"
                               id="fchRp{$smarty.section.cdp.index}"
                               name="fchRp{$smarty.section.cdp.index}"
                               class="form-control"
                               readonly
                                {if intval($claActo->seqTipoActo) != 0} disabled {/if}
                               value="{if intval($claActo->seqTipoActo) != 0}{$claActo->arrCaracteristicas.fchRp[$smarty.section.cdp.index]}{else}{$arrPost.$fchRp}{/if}"
                        >
                    </div>
                </div>
                <label class="control-label col-sm-1" for="numVigRp{$smarty.section.cdp.index}">Vigencia</label>
                <div class="col-sm-1">
                    <input type="text"
                           id="numVigRp{$smarty.section.cdp.index}"
                           name="numVigRp{$smarty.section.cdp.index}"
                           value="{if intval($claActo->seqTipoActo) != 0}{$claActo->arrCaracteristicas.numVigRp[$smarty.section.cdp.index]}{elseif intval($arrPost.$numVigRp) != 0}{$arrPost.$numVigRp}{/if}"
                           class="form-control input-sm"
                           onKeyUp="formatoSeparadores(this)"
                            {if intval($claActo->seqTipoActo) != 0} disabled {/if}
                           style="width: 60px"
                    >
                </div>
            </div>

        </div>

    {/section}
</div>
