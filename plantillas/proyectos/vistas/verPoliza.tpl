<fieldset>
    <legend style="text-align: left" class="legend">
        <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
            Informaci&oacute;n De P&oacute;lizas</h4>                                 
    </legend>
    <div class="form-group">
        <div class="col-md-4"> 
            <label class="control-label" >Nombre Aseguradora</label> 
            {foreach from=$arrAseguradoras key=seqAseguradora item=txtNombreAseguradora}
                {if $value.seqAseguradora == $seqAseguradora} <p>{$txtNombreAseguradora}</p>{/if} 
            {/foreach}  
        </div>  
        <div class="col-md-3"> 
            <label class="control-label" >N&uacute;mero de P&oacute;liza</label> 
            <p>{$value.numPoliza}</p>

        </div>  
        <div class="col-md-3"> 
            <label class="control-label" >Fecha de Expedici&oacute;n</label>           
            <p>{$value.fchExpedicion}</p>
        </div> 
        {if isset($smarty.session.arrGrupos.6.13) or isset($smarty.session.arrGrupos.6.20)}
            <div class="col-md-2">            
                <label class="control-label" >Aprob&oacute;</label><br>                
                {if $value.bolAprobo == 1}<p>SI</p> {else}<p>NO</p>{/if}   
            </div>
        {/if}
    </div>
</fieldset>
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
                        <legend style="text-align: right; cursor: hand"><p><h5>&nbsp;</h5></p></legend>
                        <div class="col-md-3">                           
                            <label class="control-label" >Tipo de Amparo</label>                             

                            {foreach from=$arrAmparos key=seqTipoAmparo item=txtTipoAmparo}
                                {if $seqTipoAmparo != 6}
                                    {if $valueAmparo.seqTipoAmparo == $seqTipoAmparo}<P>{$txtTipoAmparo}</p> {/if}
                                    {/if}
                                {/foreach}                           
                        </div>              
                        <div class="col-md-2"> 
                            <label class="control-label" >Vigencia Desde:</label>                             
                            <p>{$valueAmparo.fchVigenciaIni}</p>                  
                        </div> 
                        <div class="col-md-2"> 
                            <label class="control-label" >Vigencia Hasta:</label>                             
                            <p>{$valueAmparo.fchVigenciaFin}</p>
                        </div> 
                        <div class="col-md-2"> 
                            <label class="control-label" >Valor Asegurado</label> 
                            <p>{$valueAmparo.valAsegurado}</p>

                        </div> 
                        <div class="col-md-2" style="width: 5.5%"> 
                            <label class="control-label" >Aprobo</label> <br>
                            <p> {if $valueAmparo.bolAproboAmparo == 1} SI {else}NO{/if}</p>
                        </div> 
                        {assign var="numPolHijo" value="1"}
                        {counter start=1 print=false assign=numPolHijo}
                        <div id="demo{$valueAmparo.seqAmparo}" class="collapse" style="left: 15%">
                            {foreach from=$arraDatosPoliza key=seqAmparoHijo item=valueAmparoHijo}        
                                {if $valueAmparoHijo.seqTipoAmparo == 6 && $valueAmparoHijo.seqAmparoPadre == $valueAmparo.seqAmparo}
                                    <div class="form-group" id="ampHijo{$valueAmparo.seqAmparo}_{$numPolHijo}">
                                        <div class="col-md-3" >                                             
                                            <label class="control-label" >Prorroga {$numPolHijo}</label> 
                                            {foreach from=$arrAmparos key=seqTipoAmparo item=txtTipoAmparo}
                                                {if $seqTipoAmparo == 6}
                                                    {if $valueAmparoHijo.seqTipoAmparo == $seqTipoAmparo} <p>{$txtTipoAmparo}</p> {/if}
                                                {/if}
                                            {/foreach}


                                        </div>     
                                        <div class="col-md-2"> 
                                            <label class="control-label" >Vigencia Desde:</label> 
                                            <p>{$valueAmparoHijo.fchVigenciaIni}</p>
                                        </div> 
                                        <div class="col-md-2"> 
                                            <label class="control-label" >Vigencia Hasta:</label> 
                                            <p>{$valueAmparoHijo.fchVigenciaFin}</p>
                                        </div> 
                                        <div class="col-md-2"> 
                                            <label class="control-label" >Valor Asegurado</label> 
                                            <p>{$valueAmparoHijo.valAsegurado}</p>
                                        </div>  
                                        <div class="col-md-2" style="width: 5.5%"> 
                                            <label class="control-label" >Aprobo</label> <br>
                                            {if $valueAmparoHijo.bolAproboAmparo == 1} <p>SI</p> {else} <p>NO</p> {/if}  
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