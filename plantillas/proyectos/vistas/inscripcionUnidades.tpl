<form name="frmProyectos" id="frmProyectos" onSubmit="return false;" method="$_POST" >
    <!-- CODIGO PARA EL POPUP DE SEGUIMIENTO -->
    {include file='proyectos/pedirSeguimiento.tpl'}
    {assign var=style value = "border-radius: 20px 0 0 0;"}
    {assign var=styleLic value = "border-radius: 0 20px 0 0;"}
    {assign var=nav value = "width: 50%;"}
    {assign var=nav1 value = "width: 100%"}

    <div id="wrapper" class="container tab-content">
        <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist" style="width: 100%">                
            <li class="nav-item active"  style="{$nav}">   
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#Unidades" role="tab" aria-controls="profile" aria-selected="false" style="{$style}" onclick="listenerFile('fileAction', 'nameArchivo');
                        removeFile('fileAction', 'nameArchivo')">Crear Unidades <br></a>
            </li>
            <li class="nav-item"  style="{$nav}">   
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#estados" role="tab" aria-controls="profile" aria-selected="false" style="{$styleLic}" onclick="listenerFile('fileActionEstados', 'nameEstado');
                        removeFile('fileActionEstados', 'nameEstados')">Modificar Estados <br></a>
            </li>
        </ul>
        <div id="Unidades" class="tab-pane active"  role="tabpanel" aria-labelledby="profile-tab" style="min-height: 300px; max-height: 550px; overflow-y: auto">

            <div class="form-group" >
                <div class="col-md12" style="padding: 20px"> 
                    <fieldset>
                        <legend class="legend">
                            <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 3px;">
                                Módulo de Importación de Unidades</h4>
                        </legend>     
                        <p>&nbsp;</p>
                        <div class="form-group" >
                            <fieldset style="border: 1px dotted #024457; width: 95%;margin-left: 10px; padding: 5px;">                                
                                <div class="col-md-4">
                                    <label class="control-label" >Proyecto</label>
                                    <input type="hidden" name="idProyecto" value="{$idProyecto}" />
                                    <select name="seqProyecto"
                                            id="seqProyecto"
                                            style="width:230px;" 
                                            class="form-control required">
                                        <option value="">Seleccione</option>
                                        {foreach from=$arrayProyectos key=key item=value} 
                                            <option value="{$value.seqProyecto}">{$value.txtNombreProyecto}</option>
                                        {/foreach}
                                    </select>
                                    <div id="val_seqProyecto" class="divError">Debe Seleccionar proyecto</div> 
                                </div>
                                <div class="col-md-5" style="text-align: left">
                                    <div class="custom-file">
                                        <input type="file" name="archivo" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile" id="nameArchivo">Seleccione Archivo</label>
                                    </div>
                                    <div id="fileAction"></div>
                                    <p>&nbsp;</p> 

                                </div>
                                <div class="col-md-3">
                                    <label class="control-label" >&nbsp;</label><br>
                                    <input type="button" class="btn_volver" value="Importar Archivo &nbsp;" id="enviarDoc" onclick="someterFormulario('div2', this.form, 'contenidos/administracionProyectos/salvarUnidades.php', true, false)"/>
                                </div>
                                <p>&nbsp;</p> 

                                <div class="col-md-4" style="text-align: center">
                                    <input type="button" class="btn_volver" value="Plantilla &nbsp;" id="plantillaUnidad" onclick="obtenerPlantillaUnidades(1);" re/>
                                </div>                               
                                <p>&nbsp;</p> 
                                <div id="div2"></div>
                            </fieldset>
                        </div>
                        <p>&nbsp;</p> 
                    </fieldset>             
                </div>
            </div> 
        </div>
        <p>&nbsp;</p>
        <div id="estados" class="tab-pane"  role="tabpanel" aria-labelledby="profile-tab" style="min-height: 300px; max-height: 550px; overflow-y: auto">
            <p>&nbsp;</p> 
            <div class="form-group" >
                <fieldset style="border: 1px dotted #024457; width: 95%;margin-left: 10px; padding: 5px;">  
                    <div class="col-md-4">
                        <label class="control-label" >Proyecto</label>
                        <select name="seqProyectoPadre"
                                id="seqProyectoPadre"
                                style="width:230px;" 
                                class="form-control required" >                              
                            <option value="">Seleccione</option>
                            {foreach from=$arrayProyectos key=key item=value} 
                                <option value="{$value.seqProyecto}">{$value.txtNombreProyecto}</option>
                            {/foreach}
                        </select>
                        <div id="val_seqProyectoPadre" class="divError">Debe Seleccionar proyecto</div> 
                    </div>

                    <div class="col-md-4" style="text-align: left">                        
                        <div class="custom-file" style="top: 5px">
                            <input type="file" name="archivo" class="custom-file-input" id="archivo" >
                            <label class="custom-file-label" for="customFile" id="nameEstado" >Seleccione Archivo</label>
                        </div>
                        <div id="fileActionEstados"></div>
                        <p>&nbsp;</p> 
                    </div>
                    <div class="col-md-2">
                        <label class="control-label" >&nbsp;</label><br>
                        <input type="button" class="btn_volver" value="Importar&nbsp;" id="enviarDoc" onclick="someterFormulario('divEstados', this.form, 'contenidos/administracionProyectos/modificarEstadoUnidades.php', true, false)"/>
                    </div>
                    <div class="col-md-2" style="text-align: center">
                        <label class="control-label" >&nbsp;</label><br>
                        <input type="button" class="btn_volver" value="Plantilla Estados &nbsp;" id="plantillaUnidad" onclick="obtenerPlantillaUnidades(2);"/>
                    </div>
                    <p>&nbsp;</p> 
                    <p>&nbsp;</p> 
                    <div id="divEstados"></div>
                </fieldset>
            </div>
        </div>
    </div>
</form>