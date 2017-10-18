
<table cellspacing="0" cellpadding="3" border="0" width="100%">
    <tr>
        <td class="tituloTabla">
            Hogares relacionados
        </td>
        <td>
            <input type="file" name="archivo" id="archivo">
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="3" border="0" width="100%">

    <!-- CDP Y RP -->
    {section name=cdp start=1 loop=14}
        <tr>
            <td style="cursor: hand;"
                onClick="mostrarOcultar('CdpRp{$smarty.section.cdp.index}')"
                onMouseOver="this.style.backgroundColor = '#E4E4E4'"
                onMouseOut="this.style.backgroundColor = '#F9F9F9'"
            >
                <li><strong>CDP y RP {$smarty.section.cdp.index}</strong></li>
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #676767; display:{if intval($claActoAdministrativo->arrCaracteristicas.numCdp[$smarty.section.cdp.index]) == 0}none{/if};" id="CdpRp{$smarty.section.cdp.index}">
                <table cellpadding="0" cellspacing="3" border="0" width="100%">
                    <tr>
                        <td colspan="3">Proyecto de inversión</td>
                        <td colspan="5">
                            <input type="text"
                                   name="numPry{$smarty.section.cdp.index}"
                                   value="{$claActoAdministrativo->arrCaracteristicas.numPry[$smarty.section.cdp.index]}"
                                   style="width: 50px;"
                                   onKeyUp="formatoSeparadores(this)"
                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                            >
                        </td>
                    </tr>
                    <tr>
                        <td width="50px">CDP</td>
                        <td width="50px">
                            <input type="text"
                                   name="numCdp{$smarty.section.cdp.index}"
                                   value="{$claActoAdministrativo->arrCaracteristicas.numCdp[$smarty.section.cdp.index]}"
                                   style="width: 50px;"
                                   onKeyUp="formatoSeparadores(this)"
                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                            >
                        </td>
                        <td width="50px">Valor</td>
                        <td width="100px">
                            <input type="text"
                                   name="valCdp{$smarty.section.cdp.index}"
                                   value="{$claActoAdministrativo->arrCaracteristicas.valCdp[$smarty.section.cdp.index]|number_format}"
                                   style="width: 100px;"
                                   onKeyUp="formatoSeparadores(this)"
                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                            >
                        </td>
                        <td width="50px">Fecha</td>
                        <td width="80px">
                            <input type="text"
                                   name="fchCdp{$smarty.section.cdp.index}"
                                   id="fchCdp{$smarty.section.cdp.index}"
                                   onFocus="this.style.backgroundColor = '#ADD8E6'; calendarioPopUp('fchCdp{$smarty.section.cdp.index}')"
                                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                                   value="{$claActoAdministrativo->arrCaracteristicas.fchCdp[$smarty.section.cdp.index]}"
                                   style="width: 80px;"
                                   readonly
                            >
                        <td width="50px">Vigencia</td>
                        <td>
                            <input type="text"
                                   name="numVigCdp{$smarty.section.cdp.index}"
                                   value="{$claActoAdministrativo->arrCaracteristicas.numVigCdp[$smarty.section.cdp.index]}"
                                   style="width: 40px;"
                                   onKeyUp="formatoSeparadores(this)"
                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                            >
                        </td>
                    </tr>
                    <tr>
                        <td>RP</td>
                        <td>
                            <input type="text"
                                   name="numRp{$smarty.section.cdp.index}"
                                   value="{$claActoAdministrativo->arrCaracteristicas.numRp[$smarty.section.cdp.index]}"
                                   style="width: 50px;"
                                   onKeyUp="formatoSeparadores(this)"
                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                            >
                        </td>
                        <td>Valor</td>
                        <td>
                            <input type="text"
                                   name="valRp{$smarty.section.cdp.index}"
                                   value="{$claActoAdministrativo->arrCaracteristicas.valRp[$smarty.section.cdp.index]|number_format}"
                                   style="width: 100px;"
                                   onKeyUp="formatoSeparadores(this)"
                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                            >
                        </td>
                        <td>Fecha</td>
                        <td>
                            <input type="text"
                                   name="fchRp{$smarty.section.cdp.index}"
                                   id="fchRp{$smarty.section.cdp.index}"
                                   onFocus="this.style.backgroundColor = '#ADD8E6'; calendarioPopUp('fchRp{$smarty.section.cdp.index}')"
                                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                                   value="{$claActoAdministrativo->arrCaracteristicas.fchRp[$smarty.section.cdp.index]}"
                                   style="width: 80px;"
                                   readonly
                            >
                        </td>
                        <td>Vigencia</td>
                        <td>
                            <input type="text"
                                   name="numVigRp{$smarty.section.cdp.index}"
                                   value="{$claActoAdministrativo->arrCaracteristicas.numVigRp[$smarty.section.cdp.index]}"
                                   style="width: 40px;"
                                   onKeyUp="formatoSeparadores(this)"
                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                            >
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    {/section}
</table>
