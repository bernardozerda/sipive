
<!-- TABLA QUE MUESTRA LAS CATEGORIAS DE SEGUIMIENTO -->
<link href="./recursos/estilos/contentProyects.css" rel="stylesheet">
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
            </div>
            <div id="val_txtComentario" class="divError">Por favor diligencie el campo de comentarios</div>
        </div>
        <p>&nbsp;</p>
        <p >            
            <input type="button" name="btn_volver" id="btn_volver" value="Volver" 
                   onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosProyecto.php', '', true);
                           cargarContenido('rutaMenu', './rutaMenu.php', 'menu=66', false);" class="btn_volver"/> 
                <input type="button" name="btn_enviar" id="btn_enviar" value="Salvar Inscripci&oacute;n" onclick="almacenarIncripcion()" class="btn_volver"/><br>
        </p>
    </fieldset>

</div>
<!--<table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#E4E4E4">
    <tr>
        <td width="120px" class="tituloTabla">Grupo de Gestión</td>
        <td width="250px">
            <select name="seqGrupoGestion" 
                    id="seqGrupoGestion" 
                    style="width:250px"
                    onFocus="this.style.backgroundColor = '#ADD8E6';" 
                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                    onChange="obtenerGestionProyectos(this, 'tdGestion', 'seqGestion');" 
                    class="required">
                >
                <option value="0">Seleccione Grupo</option>
{foreach from=$arrGrupoGestion key=seqGrupoGestion item=txtGrupoGestion}
    <option value="{$seqGrupoGestion}">{$txtGrupoGestion}</option>
{/foreach}
</select>
</td>
<td rowspan="2" align="center">
<textarea rows="2" 
      cols="5" 
      id="txtComentario" 
      name="txtComentario" 
      style="width:95%"
      onFocus="this.style.backgroundColor = '#ADD8E6';" 
      onBlur="this.style.backgroundColor = '#FFFFFF';"
      class="required"
      ></textarea>
</td>
</tr>
<tr>
<td  class="tituloTabla">Gestión</td>
<td id="tdGestion">
<select name="seqGestion" 
    id="seqGestion" 
    style="width:250px"
    onFocus="this.style.backgroundColor = '#ADD8E6';" 
    onBlur="this.style.backgroundColor = '#FFFFFF';"
    class="required"
    >
<option value="0">Seleccione Gesti&oacute;n</select>
</select>
</td>
</tr>
</table>-->

<div><p>&nbsp;</p></div>



<!--<div id="wrapper" class="container">


  


        <fieldset>
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label" for="nome">Grupo de Gestión</label>
                    <select name="seqGrupoGestion" 
                            id="seqGrupoGestion" 
                            style="width:250px"
                            onFocus="this.style.backgroundColor = '#ADD8E6';" 
                            onBlur="this.style.backgroundColor = '#FFFFFF';"
                            onChange="obtenerGestionProyectos(this, 'tdGestion', 'seqGestion');" 
                            class="form-control">
                        >
                        <option value="0">Seleccione Grupo</option>
{foreach from=$arrGrupoGestion key=seqGrupoGestion item=txtGrupoGestion}
    <option value="{$seqGrupoGestion}">{$txtGrupoGestion}</option>
{/foreach}
</select>

</div>
</div>
<div class="form-group">
<div class="col-md-6">
<label class="control-label" for="surname">Nachname</label>
<input name="surname" class="form-control" placeholder="Slater" type="text">
</div>
</div>

<div class="form-group">
<div class="col-md-6">
<label class="control-label" for="tel">Tel</label>
<div class="input-group">
<span class="input-group-addon">21</span>
<input name="tel" class="form-control" placeholder="9211-4957" type="text">
</div>
</div>
</div>

<div class="form-group">
<div class="col-md-6">
<label class="control-label" for="mobile">Mobile</label>
<div class="input-group">
<span class="input-group-addon">21</span>
<input name="mobile" class="form-control" placeholder="9211-4957" type="text">
</div>
</div>
</div>

<div class="form-group">
<div class="col-md-6">
<label class="control-label" for="email">Email</label>
<input name="email" class="form-control" placeholder="kelly.slater.surf@gmail.com" type="text">
</div>
</div>

<div class="form-group">
<div class="col-md-6">
<label class="control-label" for="district">District</label>
<select name="seqGrupoGestion" 
    id="seqGrupoGestion" 
    style="width:250px"
    onFocus="this.style.backgroundColor = '#ADD8E6';" 
    onBlur="this.style.backgroundColor = '#FFFFFF';"
    onChange="obtenerGestionProyectos(this, 'tdGestion', 'seqGestion');" 
    class="form-control">
>
<option value="0">Seleccione Grupo</option>
{foreach from=$arrGrupoGestion key=seqGrupoGestion item=txtGrupoGestion}
    <option value="{$seqGrupoGestion}">{$txtGrupoGestion}</option>
{/foreach}
</select>
</div>
</div>

<div class="form-group">
<div class="col-md-12">
<button type="button" class="btn btn-primary btn-lg btn-block info">Send</button>
</div>
</div>     
</fieldset>

</div>-->