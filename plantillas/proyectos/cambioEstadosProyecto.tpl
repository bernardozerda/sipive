

<form  name="frmProyectos" id="frmProyectos" onSubmit="return false;" method="$_POST">

    {include file='proyectos/pedirSeguimiento.tpl'}

    <div class="alert alert-info">
        <h5> <strong>Info!</strong> Para el cambio de estado individual. <b>Puede buscar el Proyecto por el nombre</b></h5>
    </div>
    <div id="wrapper" class="container tab-content">
        <fieldset>
            <legend style="text-align: left" class="legend">
                <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
                    Cambio de Estado Individual</h4>                                 
            </legend>
            <div class="form-group" >
                <div class="col-md-5"> 
                    <label class="control-label" >Nombre del Proyecto</label>   
                    <input type="hidden" id="myHidden" name="myHidden"  class="form-control">
                    <input	id="nombre" 
                           name="nombre" 
                           type="text" 
                           style="width:300px" 
                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                           onBlur="this.style.backgroundColor = '#FFFFFF';" 
                           class="form-control"
                           />
                    <div id="contenedor"></div>
                </div>

                <div class="col-md-3"> 
                    <label class="control-label" >Estado Del Proceso</label> 
                    <select name="seqPryEstadoProceso" style="width:200px" class="form-control">
                        <option value="0">Seleccione un estado</option>
                        {foreach from=$arrPryEstados key=seqEstado item=txtEstado}
                            <option value="{$seqEstado}">{$txtEstado}</option>
                        {/foreach} 
                    </select>
                    <input type="hidden" id="txtArchivo" name="txtArchivo" value="./contenidos/proyectos/cambioEstadosProyectoSalvar.php">
                </div>
                <div class="col-md-3"> 
                    <label class="control-label" >&nbsp;</label> <br>
                    <input type="button"  id="btn2" value="Cambiar Estado" class="btn_volver"  onclick="almacenarIncripcion()"/>                   
                </div>
            </div>  
        </fieldset>
        <p>&nbsp;</p>
    </div>
</form>
<div id="listenerBuscarNombreProyecto"></div>
<br>
