<form name="frmProyectos" id="frmProyectos" onSubmit="return false;" method="$_POST" >
    <!-- CODIGO PARA EL POPUP DE SEGUIMIENTO -->
    {include file='proyectos/pedirSeguimiento.tpl'}
    {assign var=style value = "border-radius: 20px 0 0 0;"}
    {assign var=styleLic value = "border-radius: 20px 20px 0 0;"}
    {assign var=nav value = "width: 100%;"}
    {assign var=nav1 value = "width: 100%"}

    <div id="wrapper" class="container tab-content">
        <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist" style="width: 100%">                

            <li class="nav-item active"  style="{$nav}">       
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#estados" role="tab" aria-controls="profile" aria-selected="false" style="{$styleLic}" >Modificar Estados <br></a>
            </li>
        </ul>        
        <div id="estados" class="tab-pane active"  role="tabpanel" aria-labelledby="profile-tab" style="min-height: 300px; max-height: 550px; overflow-y: auto">
            <p>&nbsp;</p> 
            <div class="form-group" >
                <fieldset style="border: 1px dotted #024457; width: 95%;margin-left: 10px; padding: 5px;">  
                    <div class="col-md-4">
                        <label class="control-label" >Proyecto</label>
                        <select name="seqProyectoPadre"
                                id="seqProyectoPadre"
                                style="width:230px;" 
                                class="form-control" >                              
                            <option value="">Seleccione</option>
                            {foreach from=$arrayProyectos key=key item=value} 
                                <option value="{$value.seqProyecto}">{$value.txtNombreProyecto}</option>
                            {/foreach}
                        </select>
                        <div id="val_seqProyectoPadre" class="divError">Debe Seleccionar proyecto</div> 
                    </div>
                    <div class="col-md-4" style="text-align: left">                        
                        <div class="custom-file" style="top: 5px">
                            <input type="file" name="archivo" class="custom-file-input" id="customFile" >
                            <label class="custom-file-label" for="customFile" id="nameEstado" onclick="fileActionUnit('nameEstado');">Seleccione Archivo</label>
                        </div>
                        <div id="nameEstado"></div>
                        <p>&nbsp;</p> 
                    </div>
                    <div class="col-md-2">
                        <label class="control-label" >&nbsp;</label><br>
                        <input type="button" class="btn_volver" value="Importar&nbsp;" id="enviarDoc" onclick="if (validarCampos())
                                    someterFormulario('divEstados', this.form, 'contenidos/administracionProyectos/modificarEstadoUnidades.php', true, true)"/>
                    </div>
                    <div class="col-md-2" style="text-align: center">
                        <label class="control-label" >&nbsp;</label><br>
                        <input type="button" class="btn_volver" value="Plantilla&nbsp;" id="plantillaUnidad" onclick="obtenerPlantillaUnidades(2);"/>
                    </div>
                    <p>&nbsp;</p> 
                    <p>&nbsp;</p> 
                    <div id="divEstados"></div>
                </fieldset>
            </div>
        </div>
    </div>
</form>