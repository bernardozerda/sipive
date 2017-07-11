<div class="modal-wrapper" id="popup">
    <div class="popup-contenedor">
        <div><h1>SiPIVE - Simulador Aporte SDHT </h1>                                  
            <table class="responstable" >
                <tbody>
                    {assign var=maxNumSalarios value =70}
                    <tr>
                        <th width="25%"><b>Modalidad:</b></th>
                        <td width="10%">{$objFormulario->seqModalidad}</td>
                        <td width="30%">
                            {assign var=seqModalidad value=$objFormulario->seqModalidad}
                            {$arrModalidad.$seqModalidad}
                        </td>
                        <th><b>Retorno/Reubicación</b></th>
                        <!--<td>{if $numVictima == 1}N/A{else $objFormulario->bolAltaCon} {/if}</td>-->
                        <td>
                            {if $numVictima == 1}
                                <input type="checkbox" id="simRetorno" name="simRetorno" onclick="analizarSimulador()">
                                <input type="hidden" id="simVictima" name="simVictima" value="true">
                            {else}
                                <input type="hidden" id="simVictima" name="simVictima" value="false">
                                N/A
                            {/if}
                        </td>

                    </tr>
                    <tr>
                        <th><b>Total Ingresos del Hogar:</b></th>
                        <td><b>$</b>{$valTotal|number_format:0:',':'.'}</td>
                        <td>{$valTotal/$valSMMLV} SMMLV</td>
                        <th width="25%x"><b>Tipo de Cierre Financiero</b></th>
                        <!--<td colspan="2">{if $victima == 1}N/A{else $objFormulario->bolAltaCon} {/if}</td> -->
                    </tr>
                    <tr>
                        <th><b>Grupo</b></th>
                       <!--<td>{$seqTipoVictima1}</td>-->
                        <td>{if $victima == 1}1 {else}0 {/if}</td>
                        <td>
                            {if $victima == 1}
                                <b>Victima</b>
                            {else}
                                <b>Vulnerable</b>
                            {/if}
                        </td>
                        <th><b>SMMLV Vigente</b></th>
                        <td colspan="2"><b>$</b>{$valSMMLV|number_format:0:',':'.'}
                            <input type="hidden" id="smmlv" value="{$valSMMLV}"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5"><p><b style="color: red; font-size: 14px">ATENCIÓN!!! ESTA INFORMACIÓN NO QUEDARÁ REGISTRADA EN LA BASE DE DATOS DE SIPIVE!</b></p></td>
                    </tr>
                    <tr>
                        <th style="text-align: center;" colspan="2"><b>&nbsp;</b></th>
                        <th style="text-align: center;" width="20%">Valor en Pesos(<b>$</b>)</th>
                        <th style="text-align: center;">Equivalencia en SMMLV</th>
                    </tr>
                    <tr>
                        {assign var=totalAhorro value=$objFormulario->valSaldoCuentaAhorro+$objFormulario->valSaldoCuentaAhorro2}
                        {assign var=simRecursosP value = $totalAhorro/$valSMMLV}
                        <td colspan="2"><b>Ahorros</b></td>
                        <td width="20%"><input type="text" id="simAhorro" value="{$totalAhorro|number_format:0:',':'.'}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="soloNumeros(this);
                                                       this.style.backgroundColor = '#FFFFFF';
                                                       sumarTotalRecursos();"  
                                               onKeyUp="formatoSeparadores(this)"
                                               onChange="analizarSimulador()"/></td>
                        <td><b id="simSmmAhorro">{$totalAhorro/$valSMMLV|number_format:3:',':'.'}</b></td>
                    </tr>
                    <tr>
                        {assign var=simRecursosSub value = $objFormulario->valSubsidioNacional/$valSMMLV}
                        <td colspan="2"><b>Valor Subsidio: AVC / FOVIS / SFV</b></td>
                        <td> <input type="text" id="simValSubsidioNacional"  value="{$objFormulario->valSubsidioNacional|number_format:'0':'.':'.'}" 
                                    onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="soloNumeros(this);
                                            this.style.backgroundColor = '#FFFFFF';
                                            sumarTotalRecursos();"  
                                    onKeyUp="formatoSeparadores(this)"
                                    onChange="analizarSimulador()"/></td>
                        <td><b id="simSmmSubsidio">{$objFormulario->valSubsidioNacional/$valSMMLV|number_format:'3':'.':'.'}</b></td>
                    </tr>
                    <tr>
                        {assign var=simRecursosP value = $simRecursosP+$objFormulario->valSaldoCesantias/$valSMMLV}
                        <td colspan="2"><b>Cesantías</b></td>
                        <td ><input type="text" id="simValCesantias"  value="{$objFormulario->valSaldoCesantias|number_format:'0':'.':'.'}" 
                                    onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="soloNumeros(this);
                                            this.style.backgroundColor = '#FFFFFF';
                                            sumarTotalRecursos();"  
                                    onKeyUp="formatoSeparadores(this)"
                                    onChange="analizarSimulador()"/></td>
                        <td><b id="simSmmCesantias">{$objFormulario->valSaldoCesantias/$valSMMLV|number_format:'3':'.':'.'}</b></td>
                    </tr>
                    <tr>
                        {assign var=simRecursosP value = $simRecursosP+$objFormulario->valCredito/$valSMMLV}
                        <td colspan="2"><b>Crédito</b></td>
                        <td><input type="text" id="simValCredito"  value="{$objFormulario->valCredito|number_format:'0':'.':'.'}" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloNumeros(this);
                                           this.style.backgroundColor = '#FFFFFF';
                                           sumarTotalRecursos();"  
                                   onKeyUp="formatoSeparadores(this)"
                                   onChange="analizarSimulador()"/></td>
                        <td><b id="simSmmCredito">{$objFormulario->valCredito/$valSMMLV|number_format:'3':'.':'.'}</b></td>
                    </tr>
                    <tr>
                        {assign var=simRecursosSub value = $simRecursosSub+$objFormulario->valDonacion/$valSMMLV}
                        <td colspan="2"><b>Donación / Rec. Económico</b></td>
                        <td ><input type="text" id="simValDonacion"  value="{$objFormulario->valDonacion|number_format:'0':'.':'.'}" 
                                    onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="soloNumeros(this);
                                            this.style.backgroundColor = '#FFFFFF';
                                            sumarTotalRecursos();"  
                                    onKeyUp="formatoSeparadores(this)"
                                    onChange="analizarSimulador()"/></td>
                        <td><b id="simSmmDonacion">{$objFormulario->valDonacion/$valSMMLV|number_format:'3':'.':'.'}</b></td>
                    </tr>
                    <tr>                                         
                        <td colspan="4"></td>
                    </tr>
                    <tr>
                        {assign var=simTotalAhorro value = $totalAhorro+$objFormulario->valSaldoCesantias+$objFormulario->valCredito}
                        {assign var=simTotalSubsidio value = $objFormulario->valSubsidioNacional+$objFormulario->valDonacion}
                        <td colspan="2"><b>Total Recursos Propios</b></td>
                        <td ><b id="simTotalAhorro">${$simTotalAhorro|number_format:0:',':'.'}</b></td>
                        <td><b id="simTotalRecP">{$simTotalAhorro/$valSMMLV|number_format:3:',':'.'}</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Total Subsidios / VUR</b></td>
                        <td ><b id="simTotalSubsidios">${$simTotalSubsidio|number_format:0:',':'.'}</b></td>
                        <td><b id="smmlvTotalSubsidios">{$simTotalSubsidio/$valSMMLV|number_format:3:',':'.'}</b></td>
                    </tr>
                    <tr>
                        {assign var=simMaxSubsidio value = $valSMMLV*70}
                        {assign var=simRetorno value = 35}
                        {assign var=simPiveVictima value = 0}
                        {if $victima ==1}
                            {assign var=simPiveVictima value = $simRetorno-0}
                        {else}
                            {assign var=simPiveVictima value = $simRetorno-$simRecursosSub}
                        {/if}
                        <td colspan="2"><b>Vr. Estimado Aporte SDHT</b></td>
                        <td><b id="simTotalAporte">{$simPiveVictima*$valSMMLV|number_format:0:',':'.'}</b></td>
                        <td><b id="smmTotalAporte">{$simPiveVictima|number_format:3:',':'.'}</b></td>
                    </tr>
                    <tr>
                        {assign var="TotalAdqVivienda" value =$simPiveVictima+$simTotalSubsidio/$valSMMLV+$simTotalAhorro/$valSMMLV}
                        <td colspan="2"><b>Vr. Total para Adquisición de Vivienda</b></td>
                        <td><b id="simTotalAdqVivienda">{$TotalAdqVivienda*$valSMMLV|number_format:0:',':'.'}</b></td>
                        <td><b id="smmTotalAdqVivienda">{$TotalAdqVivienda|number_format:3:',':'.'}</b></td>
                    </tr>
                    <tr>                                         
                        <td colspan="4"></td>
                    </tr>
                    <tr>
                        {assign var="TotalAdqVivienda" value =$maxNumSalarios-$TotalAdqVivienda}
                        <td colspan="2"><b>Valor Pendiente Cierre Financiero</b></td>
                        {if $TotalAdqVivienda <0}                        
                            <td><b id="totalPenCierre" style="color: red;">{$TotalAdqVivienda*$valSMMLV|number_format:0:',':'.'}</b></td>
                            <td><b id="smmPenCierre" style="color: red;">{$TotalAdqVivienda|number_format:3:',':'.'}</b></td>
                            {else}
                            <td><b id="totalPenCierre">{$TotalAdqVivienda*$valSMMLV|number_format:0:',':'.'}</b></td>
                            <td><b id="smmPenCierre">{$TotalAdqVivienda|number_format:3:',':'.'}</b></td>
                            {/if}
                    </tr>
                    <tr>
                        <td colspan="4">
                            <fieldset style="border-radius: 5px;">
                                <legend style="text-align: left;"><h2>Sugerencia</h2></legend>
                                <div id="divLeftP" class="divLeftP" style="text-align: left; margin-top: 10px; margin-left: 10px; font-weight: bold; font-size: 13px; width: 80%">
                                    {if $simPiveVictima == 0}
                                        UD podrá tomar Menor Valor del Credito o de los Ahorros
                                       <!-- UD puede optar por subsidio nivel central (Mi Casa Ya)  -->
                                    {elseif $TotalAdqVivienda <0}
                                        UD podrá tomar Menor Valor del Credito o de los Ahorros
                                    {elseif $TotalAdqVivienda > 0}
                                        UD no dispone de recursos adicionales, podrá tomar la opción de Leasing
                                    {else}
                                        UD podrá tomar Menor Valor del Credito o de los Ahorros
                                    {/if}
                                </div>
                                <div class="divRightP" style="background: #fff; width: auto">
                                    <img src="recursos/imagenes/SQR.png" />
                                </div>
                            </fieldset>
                        </td>
                    </tr>
                </tbody>
            </table>                                
        </div>                                     
        <a class="popup-cerrar" href="#">X</a>
    </div>
</div>