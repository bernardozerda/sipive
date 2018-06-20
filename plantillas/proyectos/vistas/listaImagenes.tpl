<link href="./recursos/estilos/contentProyects.css" rel="stylesheet">
{assign var=style value = "border-radius: 20px 20px 0 0;"}

{assign var=nav value = "width: 100%;"}

<!-- CODIGO PARA EL POPUP DE SEGUIMIENTO -->
<div id="wrapper" class="container tab-content">    
    <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist" style="width: 100%">                
        <li class="nav-item active"  style="{$nav}">   
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#Unidades" role="tab" aria-controls="profile" aria-selected="false" style="{$style}">Módulo de Imagenes de Ficha T&eacute;cnica<br></a>
        </li>
    </ul>
    <form name="frmProyectos" id="frmProyectos" onSubmit="return false;" method="$_POST" >
        <div class="form-group" >
            <div class="col-md12" style="padding: 20px">            

                <p>&nbsp;</p>
                <div class="form-group" >
                    <fieldset style="border: 1px dotted #024457; width: 95%;margin-left: 10px; padding: 5px;">  
                        <legend style="text-align:  left"><h4>&nbsp; Importar Imagenes </h4></legend>
                        <input type="hidden" name="idProyecto" value="{$seqProyecto}" />                               
                        <div class="col-md-5" style="text-align: left">
                            <div class="custom-file">
                                <input type="file" name="archivo[]" class="custom-file-input" id="customFile" multiple>
                                <label class="custom-file-label" for="customFile" id="nameArchivo">Seleccione Imagenes</label>
                            </div>
                            <div id="fileAction"></div>
                            <p>&nbsp;</p> 
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >&nbsp;</label><br>
                            <input type="button" class="btn_volver" value="Subir Imagenes &nbsp; &nbsp;" id="importImg" onclick="someterFormulario('div2', this.form, 'contenidos/administracionProyectos/subirImagenes.php', true, false)"/>
                        </div>                                                                

                    </fieldset>
                </div>

            </div>
        </div> 
    </form>
    <p>&nbsp;</p>
    <fieldset style="border: 1px dotted #024457; width: 95%;margin-left: 10px; padding: 5px;">        
        <legend style="text-align:  left"><h4>&nbsp; Lista de Imagenes Activas </h4></legend>
        <div class="form-group" style="text-align: center" id="div2">
            {foreach from=$arrImagenes key=keyImg item=valueImg} 
                {assign var="charprice" value="/"|explode:$valueImg}
                {*  <img src="recursos/proyectos/{$valueImg}" >{$valueImg}*}
                <div class="col-md-3">
                    <label ><h5><b>{$charprice[2]}</b></h5></label><br>
                    <img src="recursos/proyectos/{$valueImg}" class="img-circle" alt="Card image cap" height="100" width="100" />        
                </div>
            {/foreach}
        </div>
        {*<div class="form-group" style="text-align: center" id="div2">

        </div>*}
        <p>&nbsp;</p>

    </fieldset>
    <p>&nbsp;</p>
</div>


