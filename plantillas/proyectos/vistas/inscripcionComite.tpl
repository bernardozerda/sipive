<div class="form-group" >
    <div class="col-md12" style="padding: 20px"> 
        <fieldset>
            <legend class="legend">
                <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 3px;">
                    Datos de comit&eacute; de Elegibilidad</h4>
            </legend>     
            <p>&nbsp;</p>
            <div class="form-group" >
                <fieldset style="border: 1px dotted #024457; width: 95%;margin-left: 10px; padding: 5px;">                  
                    <div class="col-md-3"> 
                        <label class="control-label" >Radicado Jur&iacute;dico</label><br>      
                        <input type="number" name="numRadicadoJuridico" id="numRadicadoJuridico" value="{$value.numRadicadoJuridico}" class="form-control required4">
                        <div id="val_numRadicadoJuridico" class="divError">Este campo es requerido</div> 
                    </div>
                    <div class="col-md-3"> 
                        <label class="control-label" >Fecha Radicado Jur&iacutedico</label> 
                        <input name="fchRadicadoJuridico" type="text" id="fchRadicadoJuridico" value="{$value.fchRadicadoJuridico}" size="12" readonly=""  class="form-control required4"  style="width: 70%; position: relative; float: left">
                        <a href="#" onclick="javascript: calendarioPopUp('fchRadicadoJuridico');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 11%; position: relative; float: right; right:15%"></a>
                        <div id="val_fchRadicadoJuridico" class="divError">Este campo es requerido</div> 
                    </div> 
                    <div class="col-md-3"> 
                        <label class="control-label" >Radicado T&eacute;cnico</label><br>      
                        <input type="number" name="numRadicadoTecnico" id="numRadicadoTecnico" value="{$value.numRadicadoTecnico}" class="form-control required4">
                        <div id="val_numRadicadoTecnico" class="divError">Este campo es requerido</div> 
                    </div>
                    <div class="col-md-3"> 
                        <label class="control-label" >Fecha Radicado T&eacute;cnico</label> 
                        <input name="fchRadicadoTecnico" type="text" id="fchRadicadoTecnico" value="{$value.fchRadicadoTecnico}" size="12" readonly=""  class="form-control required4"  style="width: 70%; position: relative; float: left">
                        <a href="#" onclick="javascript: calendarioPopUp('fchRadicadoTecnico');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 11%; position: relative; float: right; right:15%"></a>
                        <div id="val_fchRadicadoTecnico" class="divError">Este campo es requerido</div>
                    </div> 
                    <div class="col-md-3"> 
                        <label class="control-label" >Radicado Financiero</label><br>      
                        <input type="number" name="numRadicadoFinanciero" id="numRadicadoFinanciero" value="{$value.numRadicadoFinanciero}" class="form-control required4">
                        <div id="val_numRadicadoFinanciero" class="divError">Este campo es requerido</div>
                    </div>
                    <div class="col-md-3"> 
                        <label class="control-label" >Fecha Radicado Financiero</label> 
                        <input name="fchRadicadoFinanciero" type="text" id="fchRadicadoFinanciero" value="{$value.fchRadicadoFinanciero}" size="12" readonly=""  class="form-control required4"  style="width: 70%; position: relative; float: left">
                        <a href="#" onclick="javascript: calendarioPopUp('fchRadicadoFinanciero');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 11%; position: relative; float: right; right:15%"></a>
                        <div id="val_fchRadicadoFinanciero" class="divError">Este campo es requerido</div>
                    </div>
                    <div class="col-md-12"> 
                        <p>&nbsp;</p>
                    </div>
                </fieldset>
            </div>

            <div class="form-group" id="actasComite">
                {assign var="numcomite" value="1"}
                {counter start=0 print=false assign=numcomite}
                <p>&nbsp;</p>
                <legend class="legend" style="border: 0">
                    <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 3px;">
                        Datos de las Actas del Comite</h4>
                </legend>     
                <p>&nbsp;</p>

                {foreach from=$arrayComiteActa key=seqComiteActa item=valueComiteActa} 
                    {if $valueComiteActa.bolCondicionesComite == 0}
                        {assign var=styleFid value = "display: none;"}
                    {else}
                        {assign var=styleFid value = "display: block;"}
                    {/if}

                    <div id="subComite{$numcomite}">
                        <fieldset style="border: 1px dotted #024457; width: 95%;margin-left: 10px; padding: 5px;">
                            <legend style="text-align: right; cursor: hand"><p><h5>&nbsp;<img src="recursos/imagenes/add.png" width="20px" onclick="addComite();"  /><b style="" onclick="addComite();">&nbsp; Adicionar Actas Comite</b> &nbsp;
                                    {if $numcomite > 0}
                                        <img src='recursos/imagenes/remove.png' width='20px' onclick='removerOferente(subComite{$numcomite})'><b style='text-align: right' onclick='removerOferente(subComite{$numcomite})'>&nbsp; Eliminar Acta</b>      
                                    {/if}
                                </h5></p></legend>
                            <div class="col-md-4"> 
                                <label class="control-label" >Número de Acta</label><br>      
                                <input type="number" name="numActaComite[]" id="numActaComite{$numcomite}" value="{$valueComiteActa.numActaComite}" class="form-control required4">
                                <input type="hidden" name="seqProyectoComite[]" id="seqProyectoComite{$numcomite}" value="{$valueComiteActa.seqProyectoComite }">
                                <div id="val_numActaComite{$numcomite}" class="divError">Este campo es requerido</div>
                            </div>
                            <div class="col-md-3"> 
                                <label class="control-label" >Fecha Acta</label> 
                                <input name="fchActaComite[]" type="text" id="fchActaComite{$numcomite}" value="{$valueComiteActa.fchActaComite}" size="12" readonly=""  class="form-control required4"  style="width: 70%; position: relative; float: left">
                                <a href="#" onclick="javascript: calendarioPopUp('fchActaComite{$numcomite}');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 11%; position: relative; float: right; right:15%"></a>
                                <div id="val_fchActaComite{$numcomite}" class="divError">Este campo es requerido</div>
                            </div>                    
                            <div class="col-md-4" style="text-align: right">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary active alert-success" onclick="$('#bolAproboProyecto{$numcomite}').val('1');">
                                        <input type="radio"  id="bolAproboProyectoAp{$numcomite}" value="1" autocomplete="off" {if $valueComiteActa.bolAproboProyecto == 1} checked {/if}  > Aprobado
                                    </label>
                                    <label class="btn btn-secondary alert-danger" onclick="$('#bolAproboProyecto{$numcomite}').val('0');">
                                        <input type="radio"  id="bolAproboProyectoNoap{$numcomite}" value="0" {if $valueComiteActa.bolAproboProyecto == 0} checked {/if}  autocomplete="off"> No Aprobado
                                    </label> 
                                    <input type="hidden" name="bolAproboProyecto[]" id="bolAproboProyecto{$numcomite}" value="{$valueComiteActa.bolAproboProyecto }">

                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <label class="control-label" >Número de resoluci&oacute;n</label><br>      
                                <input type="number" name="numResolucionComite[]" id="numResolucionComite{$numcomite}" value="{$valueComiteActa.numResolucionComite}" class="form-control required4">
                                <div id="val_numResolucionComite{$numcomite}" class="divError">Este campo es requerido</div>
                            </div>
                            <div class="col-md-3"> 
                                <label class="control-label" >Fecha Resoluci&oacute;n</label> 
                                <input name="fchResolucionComite[]" type="text" id="fchResolucionComite{$numcomite}" value="{$valueComiteActa.fchResolucionComite}" size="12" readonly=""  class="form-control required4"  style="width: 70%; position: relative; float: left">
                                <a href="#" onclick="javascript: calendarioPopUp('fchResolucionComite{$numcomite}');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 11%; position: relative; float: right; right:15%"></a>
                                <div id="val_fchResolucionComite{$numcomite}" class="divError">Este campo es requerido</div>
                            </div> 
                            <div class="col-md-4"> 
                                <label class="control-label" >Entidad</label> 
                                <select name="seqEntidadComite[]" id="seqEntidadComite{$numcomite}" class="form-control required4">
                                    <option value="">Seleccione</option>                            
                                    {foreach from=$arrayEntComite key=seqEntidadComite item=txtEntidadComite}
                                        <option value="{$seqEntidadComite}" {if $valueComiteActa.seqEntidadComite == $seqEntidadComite} selected {/if}>{$txtEntidadComite}</option>
                                    {/foreach}
                                </select>
                                <div id="val_seqEntidadComite{$numcomite}" class="divError">Este campo es requerido</div>
                            </div> 
                            <div class="col-md-12"> 
                                <label class="control-label" >Observaciones Acta</label>   
                                <textarea name="txtObservacionesComite[]" id="txtObservacionesComite{$numcomite}" class="form-control required4">{$valueComiteActa.txtObservacionesComite}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label" >Comite Aprobado Condicionado?</label>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary active alert-success" style="margin: 0" onclick="$('#bolCondicionesComite{$numcomite}').val('1');
                                            ocultarDivEnt(0, 'txtCondicionesComite{$numcomite}Div');">
                                        <input type="radio"  id="bolCondiciones{$numcomite}" {if $valueComiteActa.bolCondicionesComite == 1} checked {/if} autocomplete="off" value="1" > SI
                                    </label>
                                    <label class="btn btn-secondary alert-danger" style="margin: 0" onclick="$('#bolCondicionesComite{$numcomite}').val('0');
                                            ocultarDivEnt(1, 'txtCondicionesActa{$numcomite}Div');">
                                        <input type="radio"  id="bolCondiciones{$numcomite}" value="0" autocomplete="off"  {if $valueComiteActa.bolCondicionesComite == 0} checked {/if} > NO
                                    </label>   
                                    <input type="hidden" name="bolCondicionesComite[]" id="bolCondicionesComite{$numcomite}" value="{$valueComiteActa.bolCondicionesComite }">
                                </div>
                            </div>
                            <div class="col-md-8" id="txtCondicionesComite{$numcomite}Div"  style="{$styleFid}"> 
                                <label class="control-label" >Condiciones</label>                          
                                <textarea name="txtCondicionesComite[]" id="txtCondicionesComite{$numcomite}" class="form-control">{$valueComiteActa.txtCondicionesComite}</textarea>
                                <div id="val_txtCondicionesComite{$numcomite}" class="divError">Este campo es requerido</div>
                            </div>
                            <p>&nbsp;</p>
                        </fieldset>
                    </div>
                    {assign var="numcomite" value=$numcomite+1}
                {/foreach}
            </div>
            <p>&nbsp;</p> 
        </fieldset>             
    </div>
</div> 