<form enctype="multipart/form-data" name="frmProyectos" id="frmProyectos"  onSubmit="return false;" method="post">
    {foreach from=$arrProyectos key=key item=value} 
        {assign var=seqPryEstadoProceso value=$value.seqPryEstadoProceso}
        {include file='proyectos/pedirSeguimiento.tpl'}
        {assign var=style value = "border-radius: 0 15px 0 0;"}
        <div id="wrapper" class="container tab-content">
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist" style="width: 100%">
                <li class="nav-item active"  style="width: 100%" >
                    <a class="nav-item" id="home-tab" data-toggle="tab" href="#datos" role="tab" aria-controls="home" aria-selected="true" style="border-radius: 20px 20px 0 0;" >Datos De Liquidación</a>
                </li>
            </ul>

            <div class="tab-pane active" id="datos" role="tabpanel" aria-labelledby="home-tab">
                <div id="divContent"> 
                    <div class="form-group">
                        <fieldset style="border: 1px dotted #024457; width: 95%;margin-left: 10px; padding: 5px;"> 
                            <legend>
                                <h4>Informe De Legalización Del Proyecto </h4>
                            </legend>
                            <div class="col-md-2">
                                <label class="control-label">Nombre:</label>
                            </div>
                            <div class="col-md-10">
                                <label>{$value.txtNombreProyecto}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">N° Soluciones:</label>                        
                                <span style="text-align: center; font-size: 13px">{$value.valNumeroSoluciones}</span>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">N° Formularios Legalizados:</label>                  
                                <span style="text-align: center; font-size: 13px">{$cantUnidadesLegalizadas}</span>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">N° Soluciones con Permiso:</label>
                                <span style="text-align: center; font-size: 13px">{$cantUnidadesPermiso}</span>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">N° Soluciones con Certificado:</label>
                                <span style="text-align: center; font-size: 13px">{$cantUnidadesExistencia}</span>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">N° Unidades Legalizadas:</label>
                                <span style="text-align: center; font-size: 13px">{$cantUnidadesLegalizadasXUnd}</span>
                            </div>
                            {if $validar}
                                <div class="col-md-6" style="text-align: left">    
                                    {if $value.seqPryEstadoProceso != 8}
                                        <button class='btn btn-primary .badge' data-type='Cerrar' data-url='' style="margin: 5px; padding: 8px;font-weight: bold" onclick="cerrarProyecto();" >
                                            <i class='glyphicon glyphicon-trash'></i>
                                            <span>Cerrar Proyecto</span>
                                        </button>  
                                    {else}
                                        <div class='alert alert-info' style='font-size: 12px; width: 70%'>El Proyecto se encuentra cerrado!</div>
                                    {/if}
                                </div>
                            {/if}
                        </fieldset>
                    </div>
                    <p>&nbsp;</p> 
                    <fieldset style="border: 1px dotted #024457; width: 95%;margin-left: 10px; padding: 5px;">  
                        <legend style="text-align: left"><h4>Lista de Archivos</h4></legend>
                        <div class="form-group"id="multiUpload">
                            <div class="col-md-3">
                                <label class="control-label" >Tipo Archivo</label>
                                <select name="seqInformes"
                                        id="seqInformes"
                                        style="width:170px;" 
                                        class="form-control required" 
                                        onchange = "mostrarOpcionInforme(this.id)">                              
                                    <option value="">Seleccione</option>
                                    {foreach from=$arraTipoInformes key=keyA item=valueA} 
                                        <option value="{$keyA}">{$valueA}</option>
                                    {/foreach}
                                </select>
                                <input type="hidden" name="idProyecto" id="idProyecto" value="{$idProyecto}" />
                                <div id="val_seqInformes" class="divError">Debe Seleccionar un tipo de informe</div> 
                            </div>
                            <div class="col-md-2" style="text-align: left; display: none" id="informeId">   
                                <label class="control-label" >Cual?</label>
                                <input type="text" name="txtInforme" id="txtInforme" value="{$txtInforme}"  class="form-control" />
                                <div id='val_txtInforme' class='divError'>Debe digitar un tipo de informe</div> 
                            </div>
                            <div class="col-md-5" style="text-align: left">                        
                                <div class="custom-file">
                                    <input type="file" name="archivoInforme" class="custom-file-input required" id="customFile" >
                                    <label class="custom-file-label" for="customFile" id="nameInforme" onclick="fileActionUnit('nameInforme');" >Seleccione Archivo</label>
                                </div>    
                                <p>&nbsp;</p><br>
                                <div id="val_customFile" class="divError">Debe Seleccionar un archivo</div> 
                            </div>
                            <div class="col-md-2" id="idProgress" style="display: none;">
                                <label class="control-label" >&nbsp;</label><br>
                                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <div class="progress-bar progress-bar-success" style="width:10%;"></div>
                                </div>
                            </div>
                            <div class="col-md-2" >
                                <label class="control-label" >&nbsp;</label><br>
                                <input type="button" class="btn_volver subir" value="Importar&nbsp;" id="subir"  onclick="SubirInformes('frmProyectos');"/>
                            </div>
                            <div class="col-md-12" id="idProgress" style="display: none;">
                                <label class="control-label" >&nbsp;</label><br>
                                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <div class="progress-bar progress-bar-success" style="width:10%;"></div>
                                </div>
                            </div>
                                <div class="col-md-12" ><p>&nbsp;</p> <p>&nbsp;</p> </div>
                            <table role='presentation' class='table table-striped' >
                                <tbody class='files' style="padding: 0; margin: 0">
                                    {foreach from=$arraArchivos key=keyArc item=valueArc} 
                                        {assign var=name value="_"|explode:$valueArc.nombre} 
                                        <tr class='template-download fade in'>
                                            <td>{$name[0]|replace:"-":" "|replace:"Otro":"Otro - "}</td>
                                            <td style="padding: 0; margin: 0"><p class='name' style="padding: 12px; margin: 0">
                                                    <a href='{$valueArc.destino}{$valueArc.nombre}' title='' download='{$valueArc.nombre}'>{$valueArc.nombre}</a>
                                                </p>
                                            </td>
                                            <td style="padding: 12px; margin: 0"> {$valueArc.size}KB </td>                                    
                                            {if $value.seqPryEstadoProceso != 8}                                              
                                                <td style="padding: 0; margin: 0; text-align: center">
                                                    <button class='btn btn-danger delete' data-type='Eliminar' data-url='' style="margin: 5px" onclick="eliminarArchivo('{$valueArc.destino}{$valueArc.nombre}');">
                                                        <i class='glyphicon glyphicon-trash'></i>
                                                        <span>Eliminar</span>
                                                    </button>   

                                                </td>   
                                            {/if}
                                        </tr>
                                    {/foreach}
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    {/foreach}
</form>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 400px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Esta seguro que desea Eliminar el archivo</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="modal-btn-si">Si</button>
                <button type="button" class="btn btn-default" id="modal-btn-no">No</button>
            </div>
        </div>
    </div>
</div>