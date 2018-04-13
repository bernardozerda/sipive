<form name="frmProyectos" id="frmProyectos" >

    {include file='proyectos/pedirSeguimiento.tpl'}

    <div id="wrapper" class="container">
        <fieldset>
            <legend style="text-align: left" class="legend">
                <h4 style="position: relative; float: left; width: 100%; margin: 0; padding: 5px;">
                    Datos del Constructor 
                </h4>
                <h6 style="position: relative; float: right; width: 40%; margin: 0; padding: 0;">
                   
                    <input type="hidden" id="seqUsuario" name="seqUsuario" value="{$seqUsuario}" >               
                    <input type="hidden" id="txtArchivo" name="txtArchivo" value="./contenidos/administracionProyectos/salvarConstructor.php">
                </h6>
            </legend>
            {foreach from=$arrConstructor key=key item=value} 
                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Nombre Contructora (*)</label>   
                        <input name="txtNombreConstructor" type="text" id="txtNombreConstructor" value="{$value.txtNombreConstructor}"  style="width:200px;" class="form-control required" />
                        <input type="hidden" id="seqConstructor" name="seqConstructor" value="{if $value.seqConstructor != ""}{$value.seqConstructor}{else}0{/if}" > 
                        <div id="val_txtNombreConstructor" class="divError">Este campo es requerido</div>
                    </div>
                </div>  

                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Dirección Constructor (*)</label> 
                        <input type="text" 
                               name="txtDireccionConstructor" 
                               id="txtDireccionConstructor" 
                               value="{$value.txtDireccionConstructor}"                                
                               class="form-control required"
                               />
                        <div id="val_txtDireccionConstructor" class="divError">Este campo es requerido</div>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Tipo documento</label> 
                        <select name="seqTipoDocumentoConstructor"
                                id="seqTipoDocumentoConstructor"
                                style="width:200px" 
                                class="form-control required">
                            <option value="0">Seleccione una opci&oacute;n</option>
                            {foreach from=$arrTipoDoc key=seqTipoDoc item=txtTipoDoc}
                                <option value="{$seqTipoDoc}" {if $value.seqTipoDocumentoConstructor == $seqTipoDoc} selected {/if}>{$txtTipoDoc}</option>
                            {/foreach}
                        </select>
                        <div id="val_seqTipoDocumentoConstructor"class="divError">Este campo es requerido</div>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Número de Documento</label> 

                        <input type="text" name="numDocumentoConstructor" id="numDocumentoConstructor" value="{$value.numDocumentoConstructor}" onBlur="sinCaracteresEspeciales(this);
                                soloNit(this);" style="width:200px;"  class="form-control required"/>
                        <div id="val_numDocumentoConstructor" class="divError">Este campo es requerido</div>
                    </div>
                </div>  
                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Tel&eacute;fono Fijo de Contacto (*)</label>
                        <input name="numTelefono1Constructor" type="text" id="numTelefono1Constructor" value="{$value.numTelefono1Constructor}" onBlur="sinCaracteresEspeciales(this);
                                soloNumeros(this);" style="width:120px;" class="form-control required"/> 
                        <div id="val_numTelefonoOferente"class="divError">Este campo es requerido</div>     
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Celular de Contacto</label>   
                        <input name="numTelefono2Constructor" type="text" id="numTelefono2Constructor" value="{$value.numTelefono2Constructor}" onBlur="sinCaracteresEspeciales(this);
                                soloNumeros(this);" style="width:200px;" class="form-control"/>
                    </div>
                </div>  
                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Correo de Contacto</label>
                        <input name="txtCorreoElectronicoConstructor" type="email" id="txtCorreoElectronicoConstructor" value="{$value.txtCorreoElectronicoConstructor}" class="form-control required" style="width:200px;" />
                        <div id="val_txtCorreoElectronicoConstructor"class="divError">Este campo es requerido</div>    
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-4"> 
                        <label class="control-label" for="surname">Estado:</label><br>   
                        Activo <input type="radio" name="bolActivo" value="1" {if $value.bolActivo == 1} checked  {/if}  >
                        inactivo <input type="radio" name="bolActivo" value="0" {if $value.bolActivo == 0} checked  {/if} ><br>
                    </div>
                    <div><p>&nbsp;</p></div>
                </div><br>
                <div><p>&nbsp;</p>
                    <legend>
                        <div><p>&nbsp;</p>
                            <h4 style="position: relative; float: left; width: 100%; margin: 0; padding: 4px;">
                                Datos del Representante Legal 
                            </h4><br><br><br>
                            </legend>
                            <div class="form-group" >
                                <div class="col-md-4"> 
                                    <label class="control-label" for="surname">Representante Legal</label>   
                                    <input name="txtNombreRepresentanteLegal" type="text" id="txtRepresentanteLegalOferente" class="required" value="{$value.txtNombreRepresentanteLegal}" class="form-control required" onBlur="sinCaracteresEspeciales(this);" style="width:200px;"/>
                                    <div id="val_txtNombreRepresentanteLegal"class="divError">Este campo es requerido</div>
                                </div>
                            </div>  

                            <div class="form-group" >
                                <div class="col-md-4"> 
                                    <label class="control-label" for="surname">C&eacute;dula</label>  
                                    <input name="numDocumentoRepresentanteLegal" type="text" id="numDocumentoRepresentanteLegal" class="form-control required" value="{$value.numDocumentoRepresentanteLegal}" onBlur="sinCaracteresEspeciales(this);
                                            soloNumeros(this);" style="width:200px;"/>
                                    <div id="val_numDocumentoRepresentanteLegal"class="divError">Este campo es requerido</div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div class="col-md-4"> 
                                    <label class="control-label" for="surname">Correo de Contacto</label>  
                                    <input name="txtCorreoElectronicoRepresentanteLegal	" type="email" id="txtCorreoElectronicoRepresentanteLegal" value="{$value.txtCorreoElectronicoRepresentanteLegal}" style="width:200px;"/>
                                </div>
                            </div>  
                        {/foreach}
                        </fieldset>
                    </div>   
                    </form>