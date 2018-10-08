<script src="librerias/javascript/jquery-ui.js"></script>
<link rel="stylesheet" href="recursos/estilos/jquery-ui.css"/> 
<link rel="stylesheet" href="librerias/jquery/css/bootstrap.min.css"/> 

<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%" >

    <thead>
        <tr>
            <th bgcolor="#E4E4E4" align="center" ><b>Id</b></th>
            <th bgcolor="#E4E4E4" ><b>Proyecto</b></th>          
            <th bgcolor="#E4E4E4" ><b>Oferente</b></th>
                {if $id != 1}
                <th bgcolor="#E4E4E4" >&nbsp;</th>
                {else}
                <th bgcolor="#E4E4E4" >&nbsp;</th>
                {/if}
                {if $id != 4}
                <th>&nbsp;</th>
                {/if}
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th bgcolor="#E4E4E4" align="center" ><b>Id</b></th>
            <th bgcolor="#E4E4E4" ><b>Proyecto</b></th>           
            <th bgcolor="#E4E4E4" ><b>Oferente</b></th>
                {if $id != 1}
                <th bgcolor="#E4E4E4" >&nbsp;</th>
                {else}
                <th bgcolor="#E4E4E4" >&nbsp;</th>
                {/if}
                {if $id != 4}
                <th>&nbsp;</th>
                {/if}
            <th>&nbsp;</th>

        </tr>
    </tfoot>
    {foreach from=$arrProyectos key=keyProyecto item=value}                    
        <tr>
            <td  align="center"><b>{$value.seqProyecto}</b>&nbsp;</td>
            <td width="40%">{$value.txtNombreProyecto|upper}</td>                       
            <td width="45%">{$value.oferente}</td>

            <td width="3%">
                {if $id != 4}
                    
                    <span class="glyphicon glyphicon-eye-close" aria-hidden="true" style="cursor: pointer" data-toggle="modal" data-target="#div{$value.seqProyecto}"> </span>
                {else}
                    <img src="recursos/imagenes/report.png" width="24px" data-toggle="modal" data-target="#div{$value.seqProyecto}">
                {/if}
            </td>
            <td> 
                {if $id != 4}
                    <a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosSeguimientoFicha.php?seqProyecto={$value.seqProyecto}&id=3&tipo=2', '', true);">
                        <span class="glyphicon glyphicon-plus-sign" aria-hidden="true" style="cursor: pointer" data-toggle="modal" data-target="#div{$value.seqProyecto}"> </span>
                    </a>
                {else}
                    <a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosInterventoria.php?seqProyecto={$value.seqProyecto}&id=4&tipo=1', '', true);
                            listenerFile('fileAction', 'nameArchivo');
                            removeFile('fileAction', 'nameArchivo')">
                         <span class="glyphicon glyphicon-plus-sign" aria-hidden="true" style="cursor: pointer" data-toggle="modal" data-target="#div{$value.seqProyecto}"> </span>
                    </a>
                {/if}
            </td>
            {if $id != 4}
                <td> <a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosSeguimientoFicha.php?seqProyecto={$value.seqProyecto}&id=2&tipo=2', '', true);
                        listenerFile('fileAction', 'nameArchivo');
                        removeFile('fileAction', 'nameArchivo')">
                       <span class="glyphicon glyphicon-film" aria-hidden="true" style="cursor: pointer" data-toggle="modal" data-target="#div{$value.seqProyecto}"> </span>
                    </a></td> 
                {/if}

        </tr>  
        <div class="modal fade" id="div{$value.seqProyecto}" tabindex="-1" role="dialog" aria-labelledby="div{$value.seqProyecto}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        {if $arraSegFicha|@count > 0 && $id != 4}
                            <div class="form-group" >
                                <div class="col-md-4" >  
                                    <label class="modal-title">Consecutivo De Seguimiento</label>
                                </div>
                                <div class="col-md-4">  
                                    <label class="modal-title">Fecha De Seguimiento</label>
                                </div>
                                <div class="col-md-4" >  
                                    &nbsp;
                                </div>
                            </div>   
                        {/if}
                        {if $arrayDatosInterventoria|@count > 0 && $id == 4}
                            <div class="form-group" >
                                <div class="col-md-6" >  
                                    <label class="modal-title">Informe</label>
                                </div>
                                <div class="col-md-3">  
                                    <label class="modal-title">Fecha</label>
                                </div>
                                <div class="col-md-3" >  
                                   Link
                                </div>
                            </div> 
                        {/if}    
                    </div>
                    <div class="modal-body" style="text-align: left; min-height: 400px; max-height: 500px; overflow-y: auto">
                        {if $arraSegFicha|@count > 0}
                            {foreach from=$arraSegFicha key=keyFicha item=valueFicha}   
                                {if $valueFicha.seqProyecto == $value.seqProyecto}
                                    <div class="col-md-4" >  
                                        <label>{$valueFicha.numSeguimientoFicha}</label>
                                    </div>
                                    <div class="col-md-4" >  
                                        <label> {$valueFicha.fchSeguimientoFicha}</label>
                                    </div>
                                    <div class="col-md-4">  
                                        <label>
                                            <a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosSeguimientoFicha.php?seqProyecto={$value.seqProyecto}&id=1&tipo=2&seqSeguimientoFicha={$valueFicha.seqSeguimientoFicha}', '', true);" data-dismiss="modal">
                                                <img src="recursos/imagenes/verArchivo.png" width="16px" data-dismiss="modal">
                                            </a>
                                        </label>
                                    </div>

                                {/if}
                            {/foreach}
                        {/if}
                        {if $arrayDatosInterventoria|@count > 0}
                            {foreach from=$arrayDatosInterventoria key=keyInt item=valueInt}   
                                {if $valueInt.seqProyecto == $value.seqProyecto}
                                    <div class="col-md-6" >  
                                        <label>{$valueInt.txtInformeInterventoria}</label>
                                    </div>
                                    <div class="col-md-3" >  
                                        <label> {$valueInt.fchInformeInterventoria}</label>
                                    </div>
                                    <div class="col-md-3">  
                                        <label>
                                            <a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosInterventoria.php?seqProyecto={$value.seqProyecto}&id=4&tipo=2&seqInformeInterventoria={$valueInt.seqInformeInterventoria}', '', true);" data-dismiss="modal">
                                                <img src="recursos/imagenes/verArchivo.png" width="16px" data-dismiss="modal">
                                            </a>
                                        </label>
                                    </div>

                                {/if}
                            {/foreach}
                        {/if}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>  

    {/foreach}


</table>
