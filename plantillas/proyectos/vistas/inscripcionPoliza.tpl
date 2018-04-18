<fieldset>
    <legend style="text-align: left" class="legend">
        <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
            Informaci&oacute;n De P&oacute;lizas</h4>                                 
    </legend>
    <div class="form-group">
        <div class="col-md-5"> 
            <label class="control-label" >Nombre Aseguradora</label> 
            <input name="txtNombreAseguradora" type="text" id="txtNombreAseguradora" value="{$value.txtNombreInterventor}" onblur="sinCaracteresEspeciales(this);"  class="form-control">
        </div>  
        <div class="col-md-4"> 
            <label class="control-label" >N&uacute;mero de P&oacute;liza</label> 
            <input name="numPoliza" type="text" id="numPoliza" value="{$value.txtNombreInterventor}" onblur="sinCaracteresEspeciales(this);"  class="form-control">
        </div>  
        <div class="col-md-3"> 
            <label class="control-label" >Fecha de Expedici&oacute;n</label> 
            <input name="fchLicencia[]" type="text" id="fchLicencia" value="{$valueLic.fchLicencia}" size="12" readonly=""  class="form-control"  style="width: 70%; position: relative; float: left">
            <a href="#" onclick="javascript: calendarioPopUp('fchLicencia');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 8%; position: relative; float: right; right:20%"></a>
        </div> 
    </div>
</fieldset>
<p>&nbsp;</p>
<fieldset>
    <legend style="text-align: left" class="legend">
        <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
            Lista de Amparos</h4>                                 
    </legend>
    <div id="idAmparos">
        <div class="form-group" >
            <div class="col-md-3"> 
                <label class="control-label" >Tipo de Amparo</label> 
                <input name="txtNombreAseguradora" type="text" id="txtNombreAseguradora" value="{$value.txtNombreInterventor}" onblur="sinCaracteresEspeciales(this);"  class="form-control">
            </div>  
            <div class="col-md-2"> 
            <label class="control-label" >Vigencia Desde:</label> 
            <input name="fchLicencia[]" type="text" id="fchLicencia" value="{$valueLic.fchLicencia}" size="12" readonly=""  class="form-control"  style="width: 70%; position: relative; float: left">
            <a href="#" onclick="javascript: calendarioPopUp('fchLicencia');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 18%; position: relative; float: right; right:10%"></a>
        </div> 
           <div class="col-md-2"> 
            <label class="control-label" >Vigencia Hasta:</label> 
            <input name="fchLicencia[]" type="text" id="fchLicencia" value="{$valueLic.fchLicencia}" size="12" readonly=""  class="form-control"  style="width: 70%; position: relative; float: left">
            <a href="#" onclick="javascript: calendarioPopUp('fchLicencia');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 18%; position: relative; float: right; right:10%"></a>
        </div> 
            <div class="col-md-3"> 
                <label class="control-label" >Valor Asegurado</label> 
                <input name="numPoliza" type="text" id="numPoliza" value="{$value.txtNombreInterventor}" onblur="sinCaracteresEspeciales(this);"  class="form-control">
            </div>  
        </div>
    </div>

</fieldset>
