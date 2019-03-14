
<div class="form-group">
    <div class="col-sm-12 text-center">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#guiaUnidades">
            Guia de proyectos y unidades
        </button>
    </div>
</div>

<div class="modal fade" id="guiaUnidades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 900px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Consulta de proyecto y unidad habitacional</h4>
            </div>
            <div class="modal-body" style="height: 580px;">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="seqProyecto">Proyecto</label>
                    <div class="col-sm-6">
                        <select class="form-control input-sm"
                                id="seqProyecto"
                                name="seqProyecto"
                                onchange="cargarContenido('listaUnidades','./contenidos/aad/guiaProyectos.php','seqProyecto='+$(this).val(),false)"
                        >
                            <option value="0">Seleccione</option>
                            {foreach from=$claActo->proyectos() item=arrProyecto}
                                <option value="{$arrProyecto.seqProyecto}">{$arrProyecto.txtNombreProyecto}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-sm-12" id="listaUnidades" ></div>
            </div>
        </div>
    </div>
</div>