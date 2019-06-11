
<!-- TABLA QUE MUESTRA LAS CATEGORIAS DE SEGUIMIENTO -->
<link href="{$prefijo}recursos/estilos/contentProyects.css" rel="stylesheet">
<div id="wrapper" class="container" style="overflow-y: hidden; padding: 5px 0; ">
    <fieldset>
        <legend class="legend">
            <h4 style="position: relative; float: left; width: 33%">Datos de Gestión  </h4>
            <div style="position: relative; float: left; width: 33%">
                <label class="control-label" for="nome">Estado del proceso: </label>
                {assign var=f value=$value.seqModalidad}
                {if $seqModalidad == ""}
                    {assign var=seqModalidad value=1}
                {/if}
                {if $value.seqPryEstadoProceso == ""} Inscripcion {else} {$arrEstadosProceso.$seqPryEstadoProceso} {/if}
                <input type="hidden" name="seqPryEstadoProceso" id="seqPryEstadoProceso" value="{if $value.seqPryEstadoProceso == ""}1{else}{$seqPryEstadoProceso}{/if}">
            </div>
            <div style="position: relative; float: right; width: 33%">
                <label class="control-label" for="nome">Fecha de Inscripci&oacute;n:</label>
                {$value.fchInscripcion}
            </div>
        </legend>
        <div class="form-group">
            <div class="col-md-4">
                <label class="control-label" for="nome">Grupo de Gestión</label>
                <select name="seqGrupoGestion" 
                        id="seqGrupoGestion" 
                        style="width:250px"
                        onFocus="this.style.backgroundColor = '#F9F9F9';" 
                        onBlur="this.style.backgroundColor = '#FFFFFF';"
                        onChange="obtenerGestionProyectos(this, 'tdGestion', 'seqGestion');" 
                        class="form-control required"
                        required="required">                    
                    <option value="0">Seleccione Grupo</option>
                    {foreach from=$arrGrupoGestion key=seqGrupoGestion item=txtGrupoGestion}
                        <option value="{$seqGrupoGestion}">{$txtGrupoGestion}</option>
                    {/foreach}
                </select>
                <div id="val_seqGrupoGestion" class="divError">Seleccione el grupo de la gestión realizada</div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <label class="control-label" for="surname">Gestión</label>    
                <span id="tdGestion">
                    <select name="seqGestion" 
                            id="seqGestion" 
                            style="width:250px"
                            onFocus="this.style.backgroundColor = '#F9F9F9';" 
                            onBlur="this.style.backgroundColor = '#FFFFFF';"
                            class="form-control required"
                            required="required">
                        <option value="0">Seleccione Gesti&oacute;n</option>
                    </select>
                </span>
                <div id="val_seqGestion" class="divError">Seleccione la gestión realizada</div>
            </div>
        </div>
        <div class="form-group" >
            <div class="col-md-4" > 
                <label class="control-label" for="surname">Comentarios</label>   
                <textarea rows="2"                           
                          id="txtComentario" 
                          name="txtComentario"                           
                          onFocus="this.style.backgroundColor = '#F9F9F9';" 
                          onBlur="this.style.backgroundColor = '#FFFFFF';"
                          class="form-control required"
                          required="required" ></textarea>
                <div id="val_txtComentario" class="divError">Por favor diligencie el campo de comentarios</div>
            </div>

        </div>
        <p>&nbsp;</p>
        <p>                
            {if isset($page) &&  $id == 4 || $id == 1 || $id == 6 || $id == 3 || $id == 5 || !isset($id) && $page != ""}
                <input type="button" name="btn_volver" id="btn_volver" value="Volver" 
                       onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/{$page}', '', true);
                               cargarContenido('rutaMenu', './rutaMenu.php', 'menu=66', false);" class="btn_volver"/> 
                {if $tipo != 3}
                    <input type="button" name="btn_enviar" id="btn_enviar" value="Salvar Inscripci&oacute;n" onclick="almacenarIncripcion()" class="btn_volver"/><br>
                {/if}
            {elseif isset($page) }
                <input type="button" name="btn_volver" id="btn_volver" value="Volver" 
                       onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/{$page}', '', true);
                               cargarContenido('rutaMenu', './rutaMenu.php', 'menu=66', false);" class="btn_volver"/> 
                {if $id == 7}
                    <input type="button" name="btn_enviar" id="btn_enviar" value="Salvar Inscripci&oacute;n" onclick="if (validarCampos())
                                someterFormulario('contenido', this.form, 'contenidos/administracionProyectos/salvarInformeInterventoria.php', true, false)" class="btn_volver"/><br>
                {/if}  
            {/if}           
        </p>
    </fieldset>
</div><br>

