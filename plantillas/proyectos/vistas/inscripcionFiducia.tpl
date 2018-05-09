<fieldset>
    <legend style="text-align: left" class="legend">
        <h4 style="position: relative; float: left; width: 70%; margin: 0; padding: 5px;">
            CONTRATO CONSTITUCION FIDUCIA MERCANTIL</h4>                                 
    </legend>
    {if $value.seqEntidadFiducia == 1}
        {assign var=styleFid value = "display: none;"}
    {else}
        {assign var=styleFid value = "display: block;"}
    {/if}
    <div class="form-group">
        <div class="col-md-3"> 
            <label class="control-label" >Tipo de contaro</label> 
            <select id="seqTipoContrato" name="seqTipoContrato" class="form-control" style="width: 78%">
                <option value="">Ninguna</option>
                <option value="1" {if $value.seqTipoContrato == 1}selected {/if} >Escritura</option>
                <option value="2" {if $value.seqTipoContrato == 2}selected {/if}>Contrato</option>                
            </select>
        </div>  
        <div class="col-md-3"> 
            <label class="control-label" >N&uacute;mero de Contrato</label> 
            <input name="numContratoFiducia" type="text" id="numContratoFiducia" value="{$value.numContratoFiducia}" onblur="sinCaracteresEspeciales(this);"  class="form-control">
            <input name="seqDatoFiducia" type="hidden" id="seqDatoFiducia" value="{$value.seqDatoFiducia}" onblur="sinCaracteresEspeciales(this);"  class="form-control">
        </div>  
        <div class="col-md-3"> 
            <label class="control-label" >Fecha de contrato</label> 
            <input name="fchContratoFiducia" type="text" id="fchContratoFiducia" value="{$value.fchContratoFiducia}" size="12" readonly=""  class="form-control"  style="width: 70%; position: relative; float: left">
            <a href="#" onclick="javascript: calendarioPopUp('fchContratoFiducia');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 11%; position: relative; float: right; right:15%"></a>
        </div> 

        <div class="col-md-3">      
            <label class="control-label" >Entidad</label><br>           
            Notaria <input name="seqEntidadFiducia" type="radio" id="seqEntidad" {if $value.seqEntidadFiducia == 1} checked="true"{/if}value="1"  style="height: 15px; text-align: center" onclick="ocultarDivEnt(this.value, 'txtEntidadFiduciaDiv')">&nbsp;&nbsp;                
            Otro <input name="seqEntidadFiducia" type="radio" id="seqOtro" {if $value.seqEntidadFiducia == 0} checked="true"{/if}value="0"  style="height: 15px; text-align: center" onclick="ocultarDivEnt(this.value, 'txtEntidadFiduciaDiv')">
        </div>
        <p>&nbsp;</p>
        <div class="col-md-3" id="txtEntidadFiduciaDiv"  style="{$styleFid}"> 
            <label class="control-label" >Cual?</label><br>     
            <input type="text" name="txtEntidadFiducia" id="txtEntidadFiducia" value="{$value.txtEntidadFiducia}" class="form-control">
        </div>
        <div class="col-md-3"> 
            <label class="control-label" >id Entidad</label><br>     
            <input type="number" name="numIdEntidad" id="numIdEntidad" value="{$value.numIdEntidad}" class="form-control">
        </div>
        <div class="col-md-3"> 
            <label class="control-label" >Ciudad Entidad </label><br>     
            <select id="seqCiudad" name="seqCiudad" class="form-control" style="width: 78%">
                <option value="">Ninguna</option>
                {foreach from=$arrayCity key=seqcity item=txtCity}  
                    <option value="{$seqcity}" {if $seqcity == $value.seqCiudad }selected {/if}>{$txtCity}</option>
                {/foreach}                
            </select>
        </div>
        <div class="col-md-3"> 
            <label class="control-label" >Valor del Acto</label><br>     
            <input type="text" name="valContratoFiducia" id="valContratoFiducia" value="{$value.valContratoFiducia}" class="form-control">
        </div>
        <div class="col-md-3"> 
            <label class="control-label" >Fecha Vigencia de contrato</label> 
            <input name="fchVigenciaContratoFiducia" type="text" id="fchVigenciaContratoFiducia" value="{$value.fchVigenciaContratoFiducia}" size="12" readonly=""  class="form-control"  style="width: 70%; position: relative; float: left">
            <a href="#" onclick="javascript: calendarioPopUp('fchVigenciaContratoFiducia');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 11%; position: relative; float: right; right:15%"></a>
        </div> 
        <div class="col-md-3"> 
            <label class="control-label" >Entidad fiduciaria</label><br>    
            <select id="seqBanco1" name="seqBanco1" class="form-control" style="width: 78%">
                <option value="">Ninguna</option>
                {foreach from=$arrayBanco key=seqBanco item=txtBanco}                    
                    <option value="{$seqBanco}" {if $value.seqBanco1 == $seqBanco} selected {/if}>{$txtBanco}</option>                 
                {/foreach}         
            </select>
        </div>
        <div class="col-md-3"> 
            <label class="control-label" >Nombre del Contacto</label><br>      
            <input type="text" name="txtContactoFiducia" id="txtContactoFiducia" value="{$value.txtContactoFiducia}" class="form-control">
        </div>
        <div class="col-md-3"> 
            <label class="control-label" >Telefono Contacto</label><br>      
            <input type="number" name="numTelContactoFiducia" id="numTelContactoFiducia" value="{$value.numTelContactoFiducia}" class="form-control">
        </div>
        <div class="col-md-3"> 
            <label class="control-label" >Tipo de Recursos</label><br>      
            <select id="seqTipoRecursoFiducia" name="seqTipoRecursoFiducia" class="form-control" style="width: 78%">
                <option value="">Ninguna</option>
                <option value="1" {if $value.seqTipoRecursoFiducia == 1}selected {/if}>Encargo Fiduciario</option>
                <option value="2" {if $value.seqTipoRecursoFiducia == 2}selected {/if}>Patrimonio Autonomo</option>                
            </select>
        </div>
        <div class="col-md-3"> 
            <label class="control-label" >Nombre o Raz&oacute;n Social</label><br>      
            <input type="text" name="txtRazonSocialFiducia" id="txtRazonSocialFiducia" value="{$value.txtRazonSocialFiducia}" class="form-control">
        </div>
        <div class="col-md-3"> 
            <label class="control-label" >Nit</label><br>      
            <input type="text" name="numNitFiducia" id="numNitFiducia" value="{$value.numNitFiducia}" class="form-control">
        </div>
    </div>
</fieldset>
<p>&nbsp;</p>
<fieldset style="border: 1px dotted #024457; width: 95%;margin-left: 10px; padding: 5px;">
    <legend style="text-align: left; cursor: hand"><h4><b>Informaci&oacute;n Fideicomitente y/o Beneficiario</b></h4></legend>
    <div id="fideicomiso">
        {assign var="numFid" value="1"}
        {counter start=1 print=false assign=numFid}
        {foreach from=$arrayFideicomitente key=seqFideicomitente item=valueFideicomitente}  
            <div class="form-group" id="fidehijo{$numFid}">
                <div class="col-md-4"> 
                    <label class="control-label" >Tipo </label> 
                    <select name="seqTipoFideicomitente[]" id="seqTipoFideicomitente{$numFid}" class="form-control" style="width: 78%">
                        <option value="">Ninguna</option>
                        <option value="1" {if $valueFideicomitente.seqTipoFideicomitente == 1}selected {/if}>Fideicomitente</option>
                        <option value="2" {if $valueFideicomitente.seqTipoFideicomitente == 2}selected {/if}>Beneficiario</option>                  
                    </select>
                </div>
                <div class="col-md-4"> 
                    <label class="control-label" >Nombre Entidad o Raz&oacute;n Social</label>   
                    <input type="text" name="txtNombreFideicomitente[]" id="txtNombreFideicomitente{$numFid}" value="{$valueFideicomitente.txtNombreFideicomitente}" class="form-control input-sm">
                    <input name="seqFideicomitente[]" type="hidden" id="seqFideicomitente{$numFid}" value="{$valueFideicomitente.seqFideicomitente}" onblur="sinCaracteresEspeciales(this);"  class="form-control">
                    <div class="col-sm-12">
                        <div id="txtNombreFideicomitenteContenedor{$numFid}"></div>
                    </div>
                </div>
                {if $numFid > 1}
                    <div class="col-md-3"><br><br>
                        <input type="button"  value="Eliminar" class="btn_deleted"  onclick="removerOferente(fidehijo{$numFid})"/>
                    </div>
                {else}
                    <div class="col-md-3"><br><br>
                        <input type="button" value="Adicionar" class="btn_add" onclick="addFideicomitente();"> 
                    </div>
                {/if}
                <div class="col-md-3"><p>&nbsp;</p></div>
            </div>
            {assign var="numFid" value=$numFid+1}
        {/foreach}
    </div>
</fieldset>
<p>&nbsp;</p>
<fieldset>
    <div class="form-group">
        <div class="col-md-4"> 
            <label class="control-label" >Entidad Financiera </label> 
            <select id="seqBanco" name="seqBanco" class="form-control" style="width: 78%">
                <option value="">Ninguna</option>
                {foreach from=$arrayBanco key=seqBanco item=txtBanco}                    
                    <option value="{$seqBanco}" {if $value.seqBanco == $seqBanco} selected {/if}>{$txtBanco}</option>                 
                {/foreach}               
            </select>
        </div>  
        <div class="col-md-3"> 
            <label class="control-label" >Tipo Cuenta </label> 
            <select id="seqTipoCuentaFiducia" name="seqTipoCuentaFiducia" class="form-control" style="width: 78%">
                <option value="">Ninguna</option>
                <option value="1" {if $value.seqTipoCuentaFiducia == 1}selected {/if}>Ahorros</option>
                <option value="2" {if $value.seqTipoCuentaFiducia == 2}selected {/if}>Corriente</option>                  
            </select>
        </div>
        <div class="col-md-3"> 
            <label class="control-label" >Numero Cuenta</label><br>      
            <input type="text" name="numCuentaFiducia" id="numCuentaFiducia" value="{$value.numCuentaFiducia}" class="form-control">
        </div>
      
    </div>
</fieldset>
<p>&nbsp;</p>
<p>&nbsp;</p>