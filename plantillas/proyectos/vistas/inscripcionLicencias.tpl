<!-- FORMULARIO DE INSCRIPCION CON SEGUIMIENTO -->
<link href="./recursos/estilos/contentProyects.css" rel="stylesheet">

{foreach from=$arrayLicencias key=keyLic item=valueLic}
    {if $valueLic.seqTipoLicencia == 1 || $valueLic.seqTipoLicencia =="" }
        <fieldset>
            <legend class="legend">
                <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
                    Licencia de Urbanismo</h4>
            </legend>
            <div class="form-group">
                <div class="col-md-4"> 
                    <label class="control-label">N&uacute;mero de Licencia</label> 
                    <input name="txtLicencia[]" type="text" id="txtLicenciaUrbanismo" value="{$valueLic.txtLicencia}" onblur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control">
                    <input type="hidden" name="seqProyectoLicencia[]" id="seqProyectoLicencia[]" value="{$valueLic.seqProyectoLicencia}" >
                    <input type="hidden" name="seqTipoLicencia[]" id="seqTipoLicencia[]" value="1" >
                </div>        

                <div class="col-md-4"> 
                    <label class="control-label">Entidad Expedici&oacute;n</label>                         
                    <input name="txtExpideLicencia[]" type="text" id="txtExpideLicenciaUrbanismo" value="{$valueLic.txtExpideLicencia}" onblur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control">
                </div>
                <div class="col-md-4"> 
                    <label class="control-label">Fecha de Licencia</label> 
                    <input name="fchLicencia[]" type="text" id="fchLicencia" value="{$valueLic.fchLicencia}" size="12" readonly=""  class="form-control"  style="width: 70%; position: relative; float: left">
                    <a href="#" onclick="javascript: calendarioPopUp('fchLicencia');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 8%; position: relative; float: right; right:20%"></a>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Vigencia de Licencia</label> 
                    <input name="fchVigenciaLicencia[]" type="text" id="fchVigenciaLicencia" value="{$valueLic.fchVigenciaLicencia}" size="12" readonly="" class="form-control"  style="width: 70%; position: relative; float: left">
                    <a href="#" onclick="javascript: calendarioPopUp('fchVigenciaLicencia');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 8%; position: relative; float: right; right:20%"></a>
                </div>
                <div class="col-md-4"> 
                    <label class="control-label">Fecha Ejecutoria</label> 
                    <input name="fchEjecutoriaLicencia[]" type="text" id="fchEjecutoriaLicencia" value="{$valueLic.fchEjecutoriaLicencia}" onblur="sinCaracteresEspeciales(this);"  class="form-control"  style="width: 70%; position: relative; float: left">
                    <a href="#" onclick="javascript: calendarioPopUp('fchEjecutoriaLicencia');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 8%; position: relative; float: right; right:20%"></a>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Resoluci&oacute;n Ejecutoria</label>
                    <input name="txtResEjecutoria[]" type="text" id="txtResEjecutoria" value="{$valueLic.txtResEjecutoria}" onblur="sinCaracteresEspeciales(this);"   style="width:200px;" class="form-control">
                </div>   
                <div class="col-md-4"> 
                    <label class="control-label">Fecha Prórroga</label> 
                    <input name="fchLicenciaProrroga[]" type="text" id="fchLicenciaProrroga" value="{$valueLic.fchLicenciaProrroga}" size="12" readonly="" class="form-control"  style="width: 70%; position: relative; float: left"> 
                    <a href="#" onclick="javascript: calendarioPopUp('fchLicenciaProrroga');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 8%; position: relative; float: right; right:20%"></a>          
                </div>
                <div class="col-md-4"> 
                    <label class="control-label">Fecha Prórroga1</label> 
                    <input name="fchLicenciaProrroga1[]" type="text" id="fchLicenciaProrroga1" value="{$valueLic.fchLicenciaProrroga1}" size="12" readonly="" class="form-control"  style="width: 70%; position: relative; float: left"> 
                    <a href="#" onclick="javascript: calendarioPopUp('fchLicenciaProrroga1');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 8%; position: relative; float: right; right:20%"></a>          
                </div>
                <div class="col-md-4"> 
                    <label class="control-label">Fecha Prórroga2</label> 
                    <input name="fchLicenciaProrroga2[]" type="text" id="fchLicenciaProrroga2" value="{$valueLic.fchLicenciaProrroga2}" size="12" readonly="" class="form-control"  style="width: 70%; position: relative; float: left"> 
                    <a href="#" onclick="javascript: calendarioPopUp('fchLicenciaProrroga2');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 8%; position: relative; float: right; right:20%"></a>          
                </div>
            </div>
        </fieldset>
    {/if}
    <br/>    
    {if $valueLic.seqTipoLicencia == 2 || $valueLic.seqTipoLicencia ==""}
        <fieldset>
            <legend class="legend">
                <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
                    Licencia de Contrucci&oacute;n</h4>
            </legend>
            <div class="form-group">
                <div class="col-md-4"> 
                    <label class="control-label">N&uacute;mero de Licencia</label> 
                    <input name="txtLicencia[]" type="text" id="txtLicencia" value="{$valueLic.txtLicencia}" onblur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control">
                    <input type="hidden" name="seqProyectoLicencia[]" id="seqProyectoLicencia[]" value="{$valueLic.seqProyectoLicencia}" >
                    <input type="hidden" name="seqTipoLicencia[]" id="seqTipoLicencia[]" value="2" >
                </div>
                <div class="col-md-4" style="display: none"> 
                    <label class="control-label">Entidad Expedici&oacute;n</label>                         
                    <input name="txtExpideLicencia[]" type="text" id="txtExpideLicencia" value="{$valueLic.txtExpideLicencia}" onblur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control">
                </div>
                <div class="col-md-4"> 
                    <label class="control-label">Fecha de Licencia</label> 
                    <input name="fchLicencia[]" type="text" id="fchLicenciaC" value="{$valueLic.fchLicencia}" size="12" readonly=""  class="form-control"  style="width: 70%; position: relative; float: left">
                    <a href="#" onclick="javascript: calendarioPopUp('fchLicenciaC');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 8%; position: relative; float: right; right:20%"></a>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Vigencia de Licencia</label> 
                    <input name="fchVigenciaLicencia[]" type="text" id="fchVigenciaC" value="{$valueLic.fchVigenciaLicencia}" size="12" readonly="" class="form-control"  style="width: 70%; position: relative; float: left">
                    <a href="#" onclick="javascript: calendarioPopUp('fchVigenciaC');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 8%; position: relative; float: right; right:20%"></a>
                </div>

                <div class="col-md-4"  style="display: none"> 
                    <label class="control-label">Fecha Ejecutoria</label> 
                    <input name="fchEjecutoriaLicencia[]" type="text" id="fchEjecutoriaLicenciaC" value="{$valueLic.fchEjecutoriaLicencia}" onblur="sinCaracteresEspeciales(this);"  class="form-control"  style="width: 70%; position: relative; float: left">
                    <a href="#" onclick="javascript: calendarioPopUp('fchEjecutoriaLicenciaC');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 8%; position: relative; float: right; right:20%"></a>
                </div>
                <div class="col-md-4"  style="display: none">
                    <label class="control-label">Resoluci&oacute;n Ejecutoria</label>
                    <input name="txtResEjecutoria[]" type="text" id="txtResEjecutoria" value="{$valueLic.txtResEjecutoria}" onblur="sinCaracteresEspeciales(this);"   style="width:200px;" class="form-control">
                </div>   
                <div class="col-md-4"> 
                    <label class="control-label">Fecha Prórroga</label> 
                    <input name="fchLicenciaProrroga[]" type="text" id="fchLicenciaProrrogaC" value="{$valueLic.fchLicenciaProrroga}" size="12" readonly="" class="form-control"  style="width: 70%; position: relative; float: left"> 
                    <a href="#" onclick="javascript: calendarioPopUp('fchLicenciaProrrogaC');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 8%; position: relative; float: right; right:20%"></a>          
                </div>
                <div class="col-md-4"> 
                    <label class="control-label">Fecha Prórroga1</label> 
                    <input name="fchLicenciaProrroga1[]" type="text" id="fchLicenciaProrrogaC1" value="{$valueLic.fchLicenciaProrroga1}" size="12" readonly="" class="form-control"  style="width: 70%; position: relative; float: left"> 
                    <a href="#" onclick="javascript: calendarioPopUp('fchLicenciaProrrogaC1');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 8%; position: relative; float: right; right:20%"></a>          
                </div>
                <div class="col-md-4"> 
                    <label class="control-label">Fecha Prórroga2</label> 
                    <input name="fchLicenciaProrroga2[]" type="text" id="fchLicenciaProrrogaC2" value="{$valueLic.fchLicenciaProrroga2}" size="12" readonly="" class="form-control"  style="width: 70%; position: relative; float: left"> 
                    <a href="#" onclick="javascript: calendarioPopUp('fchLicenciaProrrogaC2');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 8%; position: relative; float: right; right:20%"></a>          
                </div>

            </div>
        </fieldset>
    {/if}
{/foreach}
<p style="width: 100%;">&nbsp;</p>
<fieldset>
    <legend class="legend">
        <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
            Escrituraci&oacute;n</h4>
    </legend>
    <div class="form-group">
        <div class="col-md-4"> 
            <label class="control-label">Nombre del vendedor</label> 
            <input name="txtNombreVendedor" type="text" id="txtNombreVendedor" value="{$value.txtNombreVendedor}" onblur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control">
        </div>
        <div class="col-md-4" style="display: none"> 
            <label class="control-label">Nit</label>                         
            <input name="numNitVendedor" type="text" id="numNitVendedor" value="{$value.numNitVendedor}" onblur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control">
        </div>
        <div class="col-md-4"> 
            <label class="control-label">Cédula Catastral</label> <br>
            <input name="txtCedulaCatastral" type="text" id="txtCedulaCatastral" value="{$value.txtCedulaCatastral}" onblur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="control-label">No. Escritura</label><br> 
            <input name="txtEscritura" type="text" id="txtEscritura" value="{$value.txtEscritura}" onblur="sinCaracteresEspeciales(this);" class="form-control"  style="width: 30%; position: relative; float: left"> <b style="width: 5%; position: relative; float: left; left: 2%;top: 5px">Del</b>
            <input name="fchEscritura" type="text" id="fchEscritura" value="{$value.fchEscritura}" size="10" readonly="" class="form-control"  style="width: 35%; position: relative; float: left;left: 5%;">
            <a href="#" onclick="javascript: calendarioPopUp('fchEscritura');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 8%; position: relative; float: right; right:10%; "></a>
        </div>  
        <div class="col-md-4"> 
            <label class="control-label">No. Notaría</label> 
            <input name="numNotaria" type="text" id="numNotaria" value="{$value.numNotaria}" onblur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control">
        </div>
    </div>
</fieldset>