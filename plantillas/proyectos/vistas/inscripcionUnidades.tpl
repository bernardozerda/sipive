<form name="frmProyectos" id="frmProyectos" onSubmit="return false;" method="$_POST" >
    <!-- CODIGO PARA EL POPUP DE SEGUIMIENTO -->
    {include file='proyectos/pedirSeguimiento.tpl'}
    {assign var=style value = "border-radius: 0 0 0 0;"}
    {assign var=styleLic value = "border-radius: 20px 20px 0 0;"}
    {assign var=nav value = "width: 100%;"}
    {assign var=nav1 value = "width: 100%"}

    <div id="wrapper" class="container tab-content">
        <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist" style="width: 100%">                
            <li class="nav-item active"  style="{$nav}">   
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#seg" role="tab" aria-controls="profile" aria-selected="false" style="{$styleLic}">Crear Unidades <br></a>
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


                                <div class="col-md-12" style="text-align: center">
                                    <input type="button" class="btn_volver" value="Plantilla &nbsp;" id="plantillaUnidad" onclick="obtenerPlantillaUnidades();"/>
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
    </div>
</form>





{*<div class="modal-dialog" role="crear">
<div class="modal-content">
<div class="modal-header">
<h3 class="modal-title" id="exampleModalLabel">Crear Unidades</h3>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="container">
<form enctype="multipart/form-data" id="formuploadajax" method="post" onsubmit="return false;">
<div class="col-md-8" style="text-align: left">                    
Nombre: <input type="text" name="nombre" placeholder="Escribe tu nombre">
<div class="fileinput fileinput-new" data-provides="fileinput">
<span class="btn btn-default btn-file"><span>Choose file</span><input type="file" name="archivo" /></span>
<span class="fileinput-filename"></span><span class="fileinput-new">No file chosen</span>
</div>
<input type="button" value="Subir archivos" id="enviarDoc" onclick="someterFormulario('div2', this.form, 'contenidos/proyectos/contenidos/datosUnidades.php', true, false)"/>
</div>
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>                
</div>        
<div id="div2"></div>
</div>
</div>*}

