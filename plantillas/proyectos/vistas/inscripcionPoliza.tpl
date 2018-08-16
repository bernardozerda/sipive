<fieldset>
    <legend style="text-align: left" class="legend">
        <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
            Informaci&oacute;n De P&oacute;lizas</h4>                                 
    </legend>
    <div class="form-group">
        <div class="col-md-4"> 
            <label class="control-label" >Nombre Aseguradora</label> 
            <select id="seqAseguradora" name="seqAseguradora" class="form-control required5" style="width: 78%">
                <option value="">Ninguna</option>
                {foreach from=$arrAseguradoras key=seqAseguradora item=txtNombreAseguradora}
                    <option value="{$seqAseguradora}" {if $value.seqAseguradora == $seqAseguradora} selected {/if} >{$txtNombreAseguradora}</option>
                {/foreach}
            </select>
            <div id="val_seqAseguradora" class="divError">Diligenciar Campo</div>
        </div>  
        <div class="col-md-3"> 
            <label class="control-label" >N&uacute;mero de P&oacute;liza</label> 
            <input name="numPoliza" type="text" id="numPoliza" value="{$value.numPoliza}" onblur="sinCaracteresEspeciales(this);"  class="form-control required5">
            <input name="seqPoliza" type="hidden" id="seqPoliza" value="{$value.seqPoliza}" onblur="sinCaracteresEspeciales(this);"  class="form-control">
            <div id="val_seqPoliza" class="divError">Diligenciar Campo</div>
        </div>  
        <div class="col-md-3"> 
            <label class="control-label" >Fecha de Expedici&oacute;n</label> 
            <input name="fchExpedicion" type="text" id="fchExpedicion" value="{$value.fchExpedicion}" size="12" readonly=""  class="form-control required5"  style="width: 70%; position: relative; float: left">
            <a href="#" onclick="javascript: calendarioPopUp('fchExpedicion');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 8%; position: relative; float: right; right:20%"></a>
            <div id="val_fchExpedicion" class="divError">Diligenciar Campo</div>
        </div> 
        {if isset($smarty.session.arrGrupos.6.13) or isset($smarty.session.arrGrupos.6.20)}
            <div class="col-md-2">            
                <label class="control-label" >Aprob&oacute;</label><br>                
                <input name="bolAprobo" type="checkbox" id="bolAprobo" {if $value.bolAprobo == 1} checked="true"{/if}value="1"  style="height: 15px; text-align: center" onclick="selectUsuario('bolAprobo', {$smarty.session.seqUsuario})">&nbsp;&nbsp;                
                <input type="hidden" name="seqUsuarioPol" id="seqUsuario" value="{$value.seqUsuario}">
            </div>
        {/if}
    </div>
</fieldset>
<p>&nbsp;</p>
<p>&nbsp;</p>
<fieldset>
    <legend style="text-align: left" class="legend">
        <h4 style="position: relative; float: left; width: 50%; margin: 0;">
            Lista de Amparos</h4>                                 
    </legend>
    <div id="idAmparos">
        {assign var="numPol" value="1"}
        {counter start=1 print=false assign=numPol}
        {foreach from=$arraDatosPoliza key=seqAmparo item=valueAmparo} 
            {if $valueAmparo.seqTipoAmparo != 6}
                <div class="form-group"  id="amp{$numPol}">
                    <fieldset style="border: 1px dotted #024457; width: 95%;margin-left: 10px; padding: 5px;">
                        <legend style="text-align: right; cursor: hand"><p><h5>&nbsp;<img src="recursos/imagenes/add.png" width="20px" onclick="addAmparos();"  /><b style="" onclick="addAmparos();">&nbsp; Adicionar  Amparo</b> 
                                {if $numPol > 1}
                                    &nbsp;&nbsp;&nbsp;&nbsp;<img src="recursos/imagenes/remove.png" width="20px"  onclick='removerOferente(amp{$numPol})'/><b style="text-align: right" onclick='removerOferente(amp{$numPol})'>&nbsp; Eliminar Amparo</b> 
                                {/if}</h5></p></legend>
                        <div class="col-md-3"> 
                            <a href="#demo{$valueAmparo.seqAmparo}" data-toggle="collapse"><img src="recursos/imagenes/amparo.png" /></a>
                            <label class="control-label" >Tipo de Amparo</label> 
                            <input name="seqAmparoPadre[]" type="hidden" id="seqAmparoPadre" value="{$valueAmparo.seqAmparoPadre}" onblur="sinCaracteresEspeciales(this);"  class="form-control">
                            <input name="seqAmparo[]" type="hidden" id="seqAmparo" value="{$valueAmparo.seqAmparo}" onblur="sinCaracteresEspeciales(this);"  class="form-control">
                            <select id="seqTipoAmparo_{$numPol}" name="seqTipoAmparo[]" class="form-control required5" style="width: 75%">
                                <option value="">Ninguna</option>
                                {foreach from=$arrAmparos key=seqTipoAmparo item=txtTipoAmparo}
                                    {if $seqTipoAmparo != 6}
                                        <option value="{$seqTipoAmparo}" {if $valueAmparo.seqTipoAmparo == $seqTipoAmparo} selected {/if}>{$txtTipoAmparo}</option>
                                    {/if}
                                {/foreach}
                            </select>                           
                            <div id="val_seqTipoAmparo_{$numPol}" class="divError">Diligenciar Campo</div>
                        </div>              
                        <div class="col-md-2"> 
                            <label class="control-label" >Vigencia Desde:</label> 
                            <input name="fchVigenciaIni[]" type="text" id="fchVigenciaIni_{$numPol}" value="{$valueAmparo.fchVigenciaIni}" size="12" readonly=""  class="form-control required5"  style="width: 70%; position: relative; float: left">
                            <a href="#" onclick="javascript: calendarioPopUp('fchVigenciaIni_{$numPol}');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 18%; position: relative; float: right; right:10%"></a>
                            <div id="val_fchVigenciaIni_{$numPol}" class="divError">Diligenciar Campo</div>
                        </div> 
                        <div class="col-md-2"> 
                            <label class="control-label" >Vigencia Hasta:</label> 
                            <input name="fchVigenciaFin[]" type="text" id="fchVigenciaFin_{$numPol}" value="{$valueAmparo.fchVigenciaFin}" size="12" readonly=""  class="form-control required5"  style="width: 70%; position: relative; float: left">
                            <a href="#" onclick="javascript: calendarioPopUp('fchVigenciaFin_{$numPol}');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 18%; position: relative; float: right; right:10%"></a>
                            <div id="val_fchVigenciaFin_{$numPol}" class="divError">Diligenciar Campo</div>
                        </div> 
                        <div class="col-md-2"> 
                            <label class="control-label" >Valor Asegurado</label> 
                            <input name="valAsegurado[]" type="text" id="valAsegurado_{$numPol}" value="{$valueAmparo.valAsegurado}" onblur="sinCaracteresEspeciales(this);"  class="form-control required5">
                            <div id="val_valAsegurado_{$numPol}" class="divError">Diligenciar Campo</div>
                        </div> 
                        <div class="col-md-2" style="width: 5.5%"> 
                            <label class="control-label" >Aprobo</label> <br>
                            <input name="bolAproboAmparo[]" type="checkbox" id="bolAprobo{$valueAmparo.seqAmparo}" {if $valueAmparo.bolAproboAmparo == 1} checked="true"{/if}value="1"  style="height: 15px; text-align: center" onclick="selectUsuario(this.id, {$smarty.session.seqUsuario})">&nbsp;&nbsp;                
                            <input type="hidden" name="seqUsuario[]" id="seqUsuario{$valueAmparo.seqAmparo}" value="{if $valueAmparo.seqUsuario != 0}{$valueAmparo.seqUsuario}{else}0{/if}">
                        </div> 
                        {if $valueAmparo.seqAmparo != ""}
                            <div class="col-md-2"><br><br><input type="button"  value="Prorroga" class="btn_add" onclick="addProrroga({$valueAmparo.seqAmparo},{$smarty.session.seqUsuario});" > </div>
                            {/if}   
                            {assign var="numPolHijo" value="1"}
                            {counter start=1 print=false assign=numPolHijo}
                        <div id="demo{$valueAmparo.seqAmparo}" class="collapse" style="left: 15%">
                            {foreach from=$arraDatosPoliza key=seqAmparoHijo item=valueAmparoHijo}        
                                {if $valueAmparoHijo.seqTipoAmparo == 6 && $valueAmparoHijo.seqAmparoPadre == $valueAmparo.seqAmparo}
                                    <div class="form-group" id="ampHijo{$valueAmparo.seqAmparo}_{$numPolHijo}">
                                        <div class="col-md-3" >                                             
                                            <label class="control-label" >Prorroga {$numPolHijo}</label> 
                                            <input name="seqAmparo[]" type="hidden" id="seqAmparo" value="{$valueAmparoHijo.seqAmparo}" onblur="sinCaracteresEspeciales(this);"  class="form-control">
                                            <input name="seqAmparoPadre[]" type="hidden" id="seqAmparoPadre" value="{$valueAmparoHijo.seqAmparoPadre}" onblur="sinCaracteresEspeciales(this);"  class="form-control">
                                            <select id="seqTipoAmparo{$seqAmparo}_{$numPolHijo}" name="seqTipoAmparo[]" class="form-control required5" style="width: 75%" >                                              
                                                {foreach from=$arrAmparos key=seqTipoAmparo item=txtTipoAmparo}
                                                    {if $seqTipoAmparo == 6}
                                                        <option value="{$seqTipoAmparo}" {if $valueAmparoHijo.seqTipoAmparo == $seqTipoAmparo} selected {/if}>{$txtTipoAmparo}</option>
                                                    {/if}
                                                {/foreach}
                                            </select>
                                            <div id="val_seqTipoAmparo_{$numPol}" class="divError">Diligenciar Campo</div>
                                        </div>     
                                        <div class="col-md-2"> 
                                            <label class="control-label" >Vigencia Desde:</label> 
                                            <input name="fchVigenciaIni[]" type="text" id="fchVigenciaIni{$valueAmparo.seqAmparo}_{$numPolHijo}" value="{$valueAmparoHijo.fchVigenciaIni}" size="12" readonly=""  class="form-control required5"  style="width: 70%; position: relative; float: left">
                                            <a href="#" onclick="javascript: calendarioPopUp('fchVigenciaIni{$valueAmparo.seqAmparo}_{$numPolHijo}');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 18%; position: relative; float: right; right:10%"></a>
                                            <div id="val_fchVigenciaIni_{$numPol}" class="divError">Diligenciar Campo</div>
                                        </div> 
                                        <div class="col-md-2"> 
                                            <label class="control-label" >Vigencia Hasta:</label> 
                                            <input name="fchVigenciaFin[]" type="text" id="fchVigenciaFin{$valueAmparo.seqAmparo}_{$numPolHijo}" value="{$valueAmparoHijo.fchVigenciaFin}" size="12" readonly=""  class="form-control required5"  style="width: 70%; position: relative; float: left">
                                            <a href="#" onclick="javascript: calendarioPopUp('fchVigenciaFin{$valueAmparo.seqAmparo}_{$numPolHijo}');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 18%; position: relative; float: right; right:10%"></a>
                                            <div id="val_fchVigenciaFin_{$numPol}" class="divError">Diligenciar Campo</div>
                                        </div> 
                                        <div class="col-md-2"> 
                                            <label class="control-label" >Valor Asegurado</label> 
                                            <input name="valAsegurado[]" type="text" id="valAsegurado{$valueAmparo.seqAmparo}_{$numPolHijo}" value="{$valueAmparoHijo.valAsegurado}" onblur="sinCaracteresEspeciales(this);"  class="form-control required5">
                                            <div id="val_valAsegurado_{$numPol}" class="divError">Diligenciar Campo</div>
                                        </div>  
                                        <div class="col-md-2" style="width: 5.5%"> 
                                            <label class="control-label" >Aprobo</label> <br>
                                            <input name="bolAproboAmparo[]" type="checkbox" id="bolAprobo{$valueAmparo.seqAmparo}_{$numPolHijo}" {if $valueAmparoHijo.bolAproboAmparo == 1} checked="true" {/if}  value="1"  style="height: 15px; text-align: center" onclick="selectUsuario(this.id, {$smarty.session.seqUsuario})">&nbsp;&nbsp;                
                                            <input type="hidden" name="seqUsuario[]" id="seqUsuario{$valueAmparo.seqAmparo}_{$numPolHijo}" value="{if $valueAmparoHijo.seqUsuario != 0}{$valueAmparoHijo.seqUsuario}{else}0{/if}" >
                                        </div> 
                                        <div class="col-md-2" ><br><br>                                              
                                            <input type="button"  value="Prorroga" class="btn_deleted"  onclick='removerOferente(ampHijo{$valueAmparo.seqAmparo}_{$numPolHijo})'/>
                                        </div>
                                    </div>
                                    {assign var="numPolHijo" value=$numPolHijo+1}
                                {/if}

                            {/foreach}
                        </div>
                        <p>&nbsp;</p>
                    </fieldset>
                </div>
                {assign var="numPol" value=$numPol+1}
            {/if}
        {/foreach}
    </div>
    <p>&nbsp;</p>
</fieldset>
<p>&nbsp;</p>