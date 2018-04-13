<form name="frmProyectos" id="frmProyectos" >
    {include file='proyectos/pedirSeguimiento.tpl'}
    <div id="wrapper" class="container">
        <fieldset>
             <legend style="text-align: left" class="legend">
                <h4 style="position: relative; float: left; width: 100%; margin: 0; padding: 5px;">
                    Datos del Tutor
                </h4>
                <h6 style="position: relative; float: right; width: 40%; margin: 0; padding: 0;">                    
                    <input type="hidden" id="seqUsuario" name="seqUsuario" value="{$seqUsuario}" >               
                    <input type="hidden" id="txtArchivo" name="txtArchivo" value="./contenidos/administracionProyectos/salvarTutor.php">
                </h6>
            </legend>
        </fieldset>
        {foreach from=$arrTutor key=key item=value} 
            <div class="form-group" >
                <div class="col-md-4"> 
                    <label class="control-label" for="surname">Nombre Tutor (*)</label>  
                    <input name="txtNombreTutor" type="text" id="txtNombreTutor" value="{$value.txtNombreTutor}"  style="width:300px;" class="form-control required" />
                    <input type="hidden" id="seqTutorProyecto" name="seqTutorProyecto" value="{if $value.seqTutorProyecto != ""}{$value.seqTutorProyecto}{else}0{/if}" > 
                    <div id="val_txtNombreTutor" class="divError">Este campo es requerido</div>
                </div>
            </div>  
            <div class="form-group" >
                <div class="col-md-4"> 
                    Activo <input type="radio" name="bolActivo" value="1" {if $value.bolActivo == 1} checked  {/if}   class="required"/>
                    inactivo <input type="radio" name="bolActivo" value="0" {if $value.bolActivo == 0} checked  {/if} class="required" />
                    <div id="val_bolActivo" class="divError">Este campo es requerido</div>
                </div>
            </div>
        {/foreach}
    </div>

</form>