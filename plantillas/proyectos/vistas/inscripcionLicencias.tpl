<!-- FORMULARIO DE INSCRIPCION CON SEGUIMIENTO -->
<link href="./recursos/estilos/contentProyects.css" rel="stylesheet">
{if $seqPryEstadoProceso > 1}
    <fieldset>
        <legend class="legend">
            <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
                Datos Del Interventor</h4>
        </legend>
        <div class="form-group" >
            <div class="col-md-4"> 
                <label class="control-label" >Nombre Interventor</label> 
                <input name="txtNombreInterventor" type="text" id="txtNombreInterventor" value="{$value.txtNombreInterventor}" onblur="sinCaracteresEspeciales(this);"  class="form-control required4">
            </div>        

            <div class="col-md-4"> 
                <label class="control-label"  onclick="recogerDireccion('txtDireccionInterventor', 'objDireccionOcultoSolucion');" style="cursor: hand; text-decoration-line: underline">Direcci&oacute;n</label>                         
                <input type="text" name="txtDireccionInterventor" id="txtDireccionInterventor" value="{$value.txtDireccionInterventor}" style="width:120px; background-color:#ADD8E6;" readonly="" class="form-control required4">
            </div>
            <div class="col-md-4"> 
                <label class="control-label" >Correo Electronico</label> 
                <input name="txtCorreoInterventor" type="text" id="txtCorreoInterventor" value="{$value.txtCorreoInterventor}" onblur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control required4">
            </div>
            <div class="col-md-4">
                Natural <input name="bolTipoPersonaInterventor" type="radio" id="bolTipoPersonaInterventor" onclick="escondeCamposTipoPersona(this.value)" value="1" {if $value.bolTipoPersonaInterventor != 0} checked {/if}  checked> 
                Jurídica <input name="bolTipoPersonaInterventor" type="radio" onclick="escondeCamposTipoPersona(this.value)" id="bolTipoPersonaInterventor1" value="0" {if $value.bolTipoPersonaInterventor == 0} checked {/if}> 
            </div>
            <div class="col-md-4 lineaPersonaNatural" id="lineaPersonaNatural" {if $value.bolTipoPersonaInterventor != 1} style="display: none"{/if}> 
                <label class="control-label" >Numero Identificaci&oacute;n</label> 
                <input name="numCedulaInterventor" type="text" id="numCedulaInterventor" value="{$value.numCedulaInterventor}" onblur="sinCaracteresEspeciales(this);
                        soloNumeros(this);" class="form-control required4">
            </div>
            <div class="col-md-4 lineaPersonaNatural" id="lineaPersonaNatural" {if $value.bolTipoPersonaInterventor != 1} style="display: none"{/if}> 
                <label class="control-label" >Tarjeta Profesional</label> 
                <input name="numTProfesionalInterventor" type="text" id="numTProfesionalInterventor" value="{$value.numTProfesionalInterventor}" onblur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control required4">
            </div>
            <div class="col-md-4 lineaPersonaJuridica"  {if $value.bolTipoPersonaInterventor != 0}style="display: none" {/if}>
                <label class="control-label" >NIT</label>
                <input name="numNitInterventor" type="text" id="numNitInterventor" value="{$value.numNitInterventor}" onblur="sinCaracteresEspeciales(this);
                        soloNumeros();
                        soloNit(this);" style="width:200px;" class="form-control required4">
            </div>       
            <div class="col-md-4 lineaPersonaJuridica"  {if $value.bolTipoPersonaInterventor != 0} style="display: none" {/if}> 
                <label class="control-label" >Nombre Representante Legal</label>
                <input name="txtNombreRepLegalInterventor" type="text" id="txtNombreRepLegalInterventor" value="{$value.txtNombreRepLegalInterventor}" onBlur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control required4"/>
            </div>
            <div class="col-md-4 lineaPersonaJuridica"  {if $value.bolTipoPersonaInterventor != 0} style="display: none" {/if}>
                <label class="control-label" >Tel&eacute;fono Representante Legal</label>
                <input name="numTelefonoRepLegalInterventor" type="text" id="numTelefonoRepLegalInterventor" value="{$value.numTelefonoRepLegalInterventor}" onBlur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control required4"/>
            </div>

            <div class="col-md-4 lineaPersonaJuridica"  {if $value.bolTipoPersonaInterventor != 0} style="display: none"{/if}> 
                <label class="control-label"  onclick="recogerDireccion('txtDireccionRepLegalInterventor', 'objDireccionOcultoSolucion');" style="cursor: hand; text-decoration-line: underline">Direcci&oacute;n </label>                         
                <input type="text" name="txtDireccionRepLegalInterventor" id="txtDireccionRepLegalInterventor" value="{$value.txtDireccionRepLegalInterventor}" style="width:200px; background-color:#ADD8E6;" readonly="" class="form-control required4">
            </div>
            <div class="col-md-4 lineaPersonaJuridica"  {if $value.bolTipoPersonaInterventor != 0} style="display: none"{/if}>
                <label class="control-label" >Correo electr&oacute;nico Representante Legal</label>
                <input name="txtCorreoRepLegalInterventor" type="text" id="txtCorreoRepLegalInterventor" value="{$value.txtCorreoRepLegalInterventor}" onBlur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control required4"/>
            </div>
        </div>
    </fieldset> <br/>  
{/if}

{assign var=contador value=$arrayLicencias|@count}
{foreach from=$arrayLicencias key=keyLic item=valueLic}

    {if $valueLic.seqTipoLicencia == 1  ||  $keyLic ==0}
        <fieldset>
            <legend class="legend">
                <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
                    Licencia de Urbanizaci&oacute;n </h4>
            </legend>
            <div class="form-group">
                <div class="col-md-4"> 
                    <label class="control-label">N&uacute;mero de Licencia</label> 
                    <input name="txtLicencia[]" type="text" id="txtLicenciaUrbanismo_1" value="{$valueLic.txtLicencia}" onblur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control required5">
                    <input type="hidden" name="seqProyectoLicencia[]" id="seqProyectoLicencia[]" value="{$valueLic.seqProyectoLicencia}" >
                    <input type="hidden" name="seqTipoLicencia[]" id="seqTipoLicencia[]" value="1" >
                    <div id="val_txtLicenciaUrbanismo_1" class="divError">Este campo es requerido</div>
                </div>
                <div class="col-md-4"> 
                    <label class="control-label">Entidad Expedici&oacute;n</label>                         
                    <input name="txtExpideLicencia[]" type="text" id="txtExpideLicenciaUrbanismo_1" value="{$valueLic.txtExpideLicencia}" onblur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control required5">
                    <div id="val_txtExpideLicenciaUrbanismo_1" class="divError">Este campo es requerido</div>
                </div>
                <div class="col-md-4"> 
                    <label class="control-label">Fecha de Licencia</label> 
                    <input name="fchLicencia[]" type="text" id="fchLicencia_1" value="{$valueLic.fchLicencia}" size="12" readonly=""  class="form-control required5"  style="width: 70%; position: relative; float: left">

                    <div id="val_fchLicencia_1" class="divError">Este campo es requerido</div>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Vigencia de Licencia</label> 
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input name="fchVigenciaLicencia[]" type="text" id="fchVigenciaLicencia_1" placeholder="yyyy/mm/dd"  value="{$valueLic.fchVigenciaLicencia}" size="12" readonly="" class="form-control required5"  style="width: 70%; position: relative; float: left">
                    </div>
                    <div id="val_fchVigenciaLicencia_1" class="divError">Este campo es requerido</div>
                </div>
                <div class="col-md-4"> 
                    <label class="control-label">Fecha Ejecutoria</label> 
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input name="fchEjecutoriaLicencia[]" type="text" id="fchEjecutoriaLicencia_1" value="{$valueLic.fchEjecutoriaLicencia}" placeholder="yyyy/mm/dd"  onblur="sinCaracteresEspeciales(this);"  readonly=""  class="form-control required5"  style="width: 70%; position: relative; float: left">
                    </div>
                    <div id="val_fchEjecutoriaLicencia_1" class="divError">Este campo es requerido</div>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Resoluci&oacute;n Ejecutoria</label>
                    <input name="txtResEjecutoria[]" type="text" id="txtResEjecutoria_1" value="{$valueLic.txtResEjecutoria}" onblur="sinCaracteresEspeciales(this);"  placeholder="yyyy/mm/dd"   style="width:200px;" class="form-control required5">
                    <div id="val_txtResEjecutoria_1" class="divError">Este campo es requerido</div>
                </div>   
                <div class="col-md-4"> 
                    <label class="control-label">Fecha Prórroga</label> 
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input name="fchLicenciaProrroga[]" type="text" id="fchLicenciaProrroga" value="{$valueLic.fchLicenciaProrroga}" size="12" readonly="" class="form-control" placeholder="yyyy/mm/dd"  style="width: 70%; position: relative; float: left"> 
                    </div>
                </div>
                <div class="col-md-4"> 
                    <label class="control-label">Fecha Prórroga1</label> 
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input name="fchLicenciaProrroga1[]" type="text" id="fchLicenciaProrroga_1" value="{$valueLic.fchLicenciaProrroga1}" size="12" readonly="" class="form-control"  placeholder="yyyy/mm/dd"  style="width: 70%; position: relative; float: left"> 
                    </div>
                </div>
                <div class="col-md-4"> 
                    <label class="control-label">Fecha Prórroga2</label>
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input name="fchLicenciaProrroga2[]" type="text" id="fchLicenciaProrroga2" value="{$valueLic.fchLicenciaProrroga2}" size="12" readonly="" class="form-control"  placeholder="yyyy/mm/dd"  style="width: 70%; position: relative; float: left"> 
                    </div>
                </div>
            </div>
        </fieldset>
    {/if}
    <br/>    

    {if $valueLic.seqTipoLicencia == 2 ||  $keyLic ==1}      
        <fieldset>
            <legend class="legend">
                <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
                    Licencia de Contrucci&oacute;n</h4>
            </legend>
            <div class="form-group">
                <div class="col-md-4"> 
                    <label class="control-label">N&uacute;mero de Licencia</label> 
                    <input name="txtLicencia[]" type="text" id="txtLicenciaConstructor" value="{$valueLic.txtLicencia}" onblur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control required5">
                    <input type="hidden" name="seqProyectoLicencia[]" id="seqProyectoLicencia[]" value="{$valueLic.seqProyectoLicencia}" >
                    <input type="hidden" name="seqTipoLicencia[]" id="seqTipoLicencia[]" value="2" >
                    <div id="val_txtLicenciaConstructor" class="divError">Este campo es requerido</div>
                </div>

                <div class="col-md-4"> 
                    <label class="control-label">Fecha de Licencia</label> 
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input name="fchLicencia[]" type="text" id="fchLicenciaC" value="{$valueLic.fchLicencia}" size="12" readonly=""  class="form-control required5"  style="width: 70%; position: relative; float: left">
                    </div>
                    <div id="val_fchLicenciaC" class="divError">Este campo es requerido</div>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Vigencia de Licencia</label> 
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input name="fchVigenciaLicencia[]" type="text" id="fchVigenciaLicenciaC" value="{$valueLic.fchVigenciaLicencia}" size="12" readonly="" class="form-control required5" placeholder="yyyy/mm/dd"  style="width: 70%; position: relative; float: left">
                    </div>
                    <div id="val_fchVigenciaLicenciaC" class="divError">Este campo es requerido</div>
                </div>

                <div class="col-md-4"> 
                    <label class="control-label">Fecha Ejecutoria</label> 
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input name="fchEjecutoriaLicencia[]" type="text" id="fchEjecutoriaLicenciaC" value="{$valueLic.fchEjecutoriaLicencia}"  readonly="" onblur="sinCaracteresEspeciales(this);"  placeholder="yyyy/mm/dd"  class="form-control required5"  style="width: 70%; position: relative; float: left">
                    </div>
                </div>
                <div class="col-md-4"  style="display: none">
                    <label class="control-label">Resoluci&oacute;n Ejecutoria</label>
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input name="txtResEjecutoria[]" type="text" id="txtResEjecutoria[]" value="{$valueLic.txtResEjecutoria}" onblur="sinCaracteresEspeciales(this);"   style="width:200px;" class="form-control">
                    </div>   
                </div>
                <div class="col-md-4"> 
                    <label class="control-label">Fecha Prórroga</label> 
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input name="fchLicenciaProrroga[]" type="text" id="fchLicenciaProrrogaC" value="{$valueLic.fchLicenciaProrroga}" size="12" readonly="" class="form-control" placeholder="yyyy/mm/dd"   style="width: 70%; position: relative; float: left"> 
                    </div>
                </div>
                <div class="col-md-4"> 
                    <label class="control-label">Fecha Prórroga1</label> 
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input name="fchLicenciaProrroga1[]" type="text" id="fchLicenciaProrrogaC1" value="{$valueLic.fchLicenciaProrroga1}" size="12" readonly="" class="form-control" placeholder="yyyy/mm/dd"  style="width: 70%; position: relative; float: left"> 
                    </div>
                </div>
                <div class="col-md-4"> 
                    <label class="control-label">Fecha Prórroga2</label>
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input name="fchLicenciaProrroga2[]" type="text" id="fchLicenciaProrrogaC2" value="{$valueLic.fchLicenciaProrroga2}" size="12" readonly="" class="form-control" placeholder="yyyy/mm/dd"   style="width: 70%; position: relative; float: left"> 

                    </div>
                </div>
            </div>
        </fieldset>
    {/if}
{/foreach}
<p>&nbsp;</p>

