
<div class="form-group">
    <div class="col-sm-8 text-center">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#guiaUnidades">
            Guia de proyectos y unidades
        </button>
    </div>
    <div class="col-sm-4 text-center">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#guiaModalidad">
            Guia de Modalidad
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
                                onchange="cargarContenido('listaUnidades', './contenidos/aad/guiaProyectos.php', 'seqProyecto=' + $(this).val(), false)"
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

<div class="modal fade" id="guiaModalidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 900px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Lista de Modalidades</h4>
            </div>
            <div class="modal-body" style="height: 580px;">
                <div class="col-sm-12">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#modalidades" aria-controls="disponibles" role="tab" data-toggle="tab">
                                Disponibles <span class="label label-success">{$numDisponibles}</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" style="padding-top: 20px;">

                        <div role="tabpanel" class="tab-pane fade in active" id="disponibles">
                            <div class="col-sm-12">
                                <table class="table table-striped" id="listadoAadPry" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Descripción de la unidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {foreach from=$arrModalidad item=idModalidad}

                                            <tr>
                                                <td>{$idModalidad.txtModalidad}/{$idModalidad.txtPlanGobierno}/{$idModalidad.txtSolucion}</td>
                                            </tr>

                                        {/foreach}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div id="listadoAadProyectos"></div>