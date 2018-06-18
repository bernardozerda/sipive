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
            <th>&nbsp;</th>
        </tr>
    </tfoot>
    {foreach from=$arrProyectos key=keyProyecto item=value}                    
        <tr>
            <td  align="center"><b>{$value.seqProyecto}</b>&nbsp;</td>
            <td nowrap>{$value.txtNombreProyecto|upper}</td>                       
            <td >{$value.oferente}</td>
            <td width="5%">
                <img src="recursos/imagenes/Show.png" width="24px" data-toggle="modal" data-target="#div{$value.seqProyecto}">
            </td>
            <td> <a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosSeguimientoFicha.php?seqProyecto={$value.seqProyecto}&id=1&tipo=2', '', true);">
                    <img src="recursos/imagenes/add.png" width="24px">
                </a></td> 
        </tr>  
        <div class="modal fade" id="div{$value.seqProyecto}" tabindex="-1" role="dialog" aria-labelledby="div{$value.seqProyecto}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
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
                    </div>
                    <div class="modal-body" style="text-align: center">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>  

    {/foreach}


</table>
