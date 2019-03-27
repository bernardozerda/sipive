<form name="frmProyectos" id="frmProyectos" >

    {include file='proyectos/pedirSeguimiento.tpl'}

    <div id="wrapper" class="container">
        <fieldset>
            <legend style="text-align: left" class="legend">
                <h4 style="position: relative; float: left; width: 100%; margin: 0; padding: 5px;">
                    Datos del Oferente
                </h4>
                <h6 style="position: relative; float: right; width: 40%; margin: 0; padding: 0;">                   
                    <input type="hidden" id="seqUsuario" name="seqUsuario" value="{$seqUsuario}" >               
                    <input type="hidden" id="txtArchivo" name="txtArchivo" value="./contenidos/administracionProyectos/salvarOferente.php">
                </h6>
            </legend>
            {foreach from=$arrayOferentes key=key item=value} 
                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Nombre Oferente (*)</label>   
                        <input name="txtNombreOferente" type="text" id="txtNombreOferente" value="{$value.txtNombreOferente}"  style="width:200px;" class="form-control required" />
                        <input type="hidden" id="seqOferente" name="seqOferente" value="{if $value.seqOferente != ""}{$value.seqOferente}{else}0{/if}" > 
                        <div id="val_txtNombreOferente" class="divError">Este campo es requerido</div>
                    </div>
                </div>  

                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Nit o C&eacute;dula (*)</label> 
                        <input type="text" 
                               name="numNitOferente" 
                               id="numNitOferente" 
                               value="{$value.numNitOferente}"                                
                               class="form-control required"
                               onBlur="sinCaracteresEspeciales(this);
                                       soloNit(this);
                                       soloNumeros(this);"
                               style="width: 200px;"
                               />
                        <div id="val_numNitOferente" class="divError">Este campo es requerido</div>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Nombre de Contacto (*)</label> 
                        <input name="txtNombreContactoOferente" type="text" id="txtNombreContactoOferente" value="{$value.txtNombreContactoOferente}" onBlur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control required" />
                        <div id="val_txtNombreContactoOferente"class="divError">Este campo es requerido</div>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" >Tel&eacute;fono Fijo de Contacto(*)</label>
                        <input name="numTelefonoOferente" type="text" id="numTelefono1Oferente" value="{$value.numTelefonoOferente}" onBlur="sinCaracteresEspeciales(this);
                                soloNumeros(this);"  class="form-control required" /> 
                    </div>
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Ext</label>
                        <input name="numExtensionOferente" type="text" id="numExtensionOferente" value="{$value.numExtensionOferente}" onBlur="sinCaracteresEspeciales(this);
                                soloNumeros(this);"  class="form-control" size="10"/>
                        <div id="val_numTelefono1Oferente"class="divError">Este campo es requerido</div>    
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Celular de Contacto</label>   
                        <input name="numCelularOferente" type="text" id="numTelCelularOferente" value="{$value.numCelularOferente}" onBlur="sinCaracteresEspeciales(this);
                                soloNumeros(this);" style="width:200px;" class="form-control required"/>
                        <div id="val_numTelCelularOferente" class="divError">Este campo es requerido</div>
                    </div>
                </div>  
                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Correo de Contacto</label>
                        <input name="txtCorreoOferente" type="email" id="txtCorreoOferente" value="{$value.txtCorreoOferente}" class="form-control required" style="width:200px;" />
                        <div id="val_txtCorreoOferente"class="divError">Este campo es requerido</div>    
                    </div>
                </div><br>
                <div><p>&nbsp;</p></div>
                <legend>

                    <h4 style="position: relative; float: left; width: 100%; margin: 0; padding: 4px;">
                        Datos del Representante Legal 
                    </h4><br>
                </legend>
                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Representante Legal</label>   
                        <input name="txtRepresentanteLegalOferente" type="text" id="txtRepresentanteLegalOferente"  value="{$value.txtRepresentanteLegalOferente}" class="form-control required" onBlur="sinCaracteresEspeciales(this);" style="width:200px;"/>
                        <div id="val_txtRepresentanteLegalOferente"class="divError">Este campo es requerido</div>
                    </div>
                </div>  

                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">C&eacute;dula</label>  
                        <input name="numNitRepresentanteLegalOferente" type="text" id="numNitRepresentanteLegalOferente" class="form-control required" value="{$value.numNitRepresentanteLegalOferente}" onBlur="sinCaracteresEspeciales(this);
                                soloNumeros(this);" style="width:200px;"/>
                        <div id="val_numNitRepresentanteLegalOferente"class="divError">Este campo es requerido</div>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label"  onclick="recogerDireccion('txtDireccionRepresentanteLegalOferente', 'objDireccionOcultoSolucion');" style="cursor: hand; text-decoration-line: underline">Direcci&oacute;n</label>
                        <input name="txtDireccionRepresentanteLegalOferente" type="text" id="txtDireccionRepresentanteLegalOferente" value="{$value.txtDireccionRepresentanteLegalOferente}" class="form-control required"  readonly="" style="width:200px;" />
                        <div id="val_txtDireccionRepresentanteLegalOferente"class="divError">Este campo es requerido</div>    
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Tel&eacute;fono Fijo de Representante (*)</label>
                        <input name="numTelefonoRepresentanteLegalOferente" type="text" id="numTelefonoRepresentanteLegalOferente" value="{$value.numTelefonoRepresentanteLegalOferente}" onBlur="sinCaracteresEspeciales(this);
                                soloNumeros(this);"  class="form-control required"/> 
                    </div>
                    <div class="col-md-4">
                        <label class="control-label" for="surname">Ext</label>
                        <input name="numExtensionRepresentanteLegalOferente" type="text" id="numExtensionRepresentanteLegalOferente" value="{$value.numExtensionRepresentanteLegalOferente}" onBlur="sinCaracteresEspeciales(this);
                                soloNumeros(this);"  class="form-control"/>
                        <div id="val_numTelefonoRepresentanteLegalOferente"class="divError">Este campo es requerido</div>    
                    </div> 
                </div>
                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Celular del Representante</label>   
                        <input name="numCelularRepresentanteLegalOferente" type="text" id="numTelCelularRepresentanteLegalOferente" value="{$value.numCelularRepresentanteLegalOferente}" onBlur="sinCaracteresEspeciales(this);
                                soloNumeros(this);" style="width:200px;" class="form-control"/>
                        <div id="val_numTelCelularRepresentanteLegalOferente"class="divError">Este campo es requerido</div>
                    </div>
                </div>  
                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Correo de Contacto</label>
                        <input name="txtCorreoRepresentanteLegalOferente" type="email" id="txtCorreoRepresentanteLegalOferente" value="{$value.txtCorreoRepresentanteLegalOferente}" class="form-control required" style="width:250px;" />
                        <div id="val_txtCorreoRepresentanteLegalOferente"class="divError">Este campo es requerido</div>    
                    </div>
                </div>
                <br>
                <div><p>&nbsp;</p></div>
            {/foreach}
        </fieldset>
    </div>   
</form>
<div id="objDireccionOcultoSolucion" style="display:none"></div>