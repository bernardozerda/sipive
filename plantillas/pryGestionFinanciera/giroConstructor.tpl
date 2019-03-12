&nbsp;
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

{if not empty($claGestion->arrErrores)}
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {foreach from=$claGestion->arrErrores item=txtError}
            <li>{$txtError}</li>
        {/foreach}
    </div>
{/if}

{if not empty($claGestion->arrMensajes)}
    <div class="alert alert-success alert-dismissible" role="alert" style="font-size: 12px">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Hecho!</strong> {$claGestion->arrMensajes.0}
    </div>
{/if}

<!-- formulario para el giro -->
<form id="frmProyectos" class="form-horizontal" onsubmit="return false;">

    <!-- proyecto para el giro -->
    <div class="form-group">
        <label for="seqProyecto" class="col-sm-1 control-label text-left">Proyecto</label>
        <div class="col-sm-10">
            <select id="seqProyecto" class="form-control input-sm" name="seqProyecto"
                    onchange="someterFormulario('contenido',this.form,'./contenidos/pryGestionFinanciera/giroConstructor.php',true,true);"
                    {if $bolImprimir == true} disabled {/if}
            >
                <option value="0">Seleccione Proyecto</option>
                {foreach from=$arrProyectos key=seqProyecto item=txtNombreProyecto}
                    <option value="{$seqProyecto}" {if $arrPost.seqProyecto == $seqProyecto} selected {/if}>{$txtNombreProyecto}</option>
                {/foreach}
            </select>
        </div>
    </div>

    <!-- detalle del giro -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Giros a Constructor</h6>
        </div>
        <div class="panel-body">

            <!-- plantilla y input file para cargar el archivo -->
            <div class="form-group">

                <label for="plantilla" class="control-label col-sm-1">Plantilla</label>
                <div class="col-sm-2">
                    <button class="btn btn-success btn-sm" type="button" {if intval($arrPost.seqProyecto) == 0 or $bolImprimir == true} disabled {/if}
                            onclick="location.href='./contenidos/pryGestionFinanciera/plantillaGiroConstructor.php?seqProyecto={$arrPost.seqProyecto}'">
                        <span class="glyphicon glyphicon-export" aria-hidden="true"></span> Plantilla
                    </button>
                </div>

                <label for="archivo" class="control-label col-sm-1">Unidades</label>
                <div class="col-sm-3">
                    <div class="input-group input-group-sm">
                        <label class="input-group-btn">
                            <span class="btn btn-default {if intval($arrPost.seqProyecto) == 0 or $bolImprimir == true} disabled {/if}">
                                <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                                <input class="pryFile" type="file" id="archivo" name="archivo" style="display: none;" {if intval($arrPost.seqProyecto) == 0 or $bolImprimir == true} disabled="disabled" {/if}
                                       onchange="someterFormulario('contenido',this.form,'./contenidos/pryGestionFinanciera/giroConstructor.php',true,true);"
                                >
                            </span>
                        </label>
                        <input type="text" id="pryFileContent" class="form-control" readonly="" value="">
                    </div>
                </div>

                <!-- ver las unidades cargdas -->
                <label for="seqProyecto" class="col-sm-2 control-label">Ver Unidades</label>
                <div class="col-sm-2">
                    <div class="input-group input-group-sm">
                        <label class="input-group-btn" {if intval($arrPost.seqProyecto) != 0 and not empty($arrUnidades)} data-toggle="modal" data-target="#modalUnidades" {/if}>
                            <span class="btn btn-default {if intval($arrPost.seqProyecto) == 0 or empty($arrUnidades)} disabled {/if}">
                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                            </span>
                        </label>
                        <input type="text" class="form-control input-sm" value="{$numTotalUnidades}" readonly>
                        <input type="hidden" name="unidades" value='{$arrUnidades|@json_encode}'>
                    </div>
                </div>

            </div>

            <!-- tabla para el giro -->
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            VALOR A GIRAR
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-right">Girado a Fiducias</th>
                                    <th class="text-right">Girado a Constructor</th>
                                    <th class="text-center">Valor a Girar</th>
                                    <th class="text-right">Saldo</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="vertical-align: middle" class="text-right">$ {$claGestion->arrGiroConstructor.total|number_format:0:',':'.'}</td>
                                    <td style="vertical-align: middle" class="text-right">$ {$claGestion->arrGiroConstructor.giro|number_format:0:',':'.'}</td>
                                    <td style="padding-left: 60px;" class="text-right">
                                        <input type="text" class="form-control input-sm text-right"
                                               id="valGiro" value="{$numTotalGiro|@doubleval|number_format:0:',':'.'}"
                                               style="width: 110px"
                                               readonly>
                                    </td>
                                    <td style="vertical-align: middle" class="text-right {if $claGestion->arrGiroConstructor.saldo < 0}text-danger{/if}">
                                        $ {$claGestion->arrGiroConstructor.saldo|number_format:0:',':'.'}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- comentario y fecha -->
            <div class="form-group">
                <label for="fchGiro" class="control-label col-sm-2">Fecha del giro</label>
                <div class="col-sm-2">
                    <div class="input-group input-group-sm" onclick="$('#fchGiro').trigger('focus')">
                        <label class="input-group-btn">
                            <span class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                            </span>
                        </label>
                        <input type="text"
                            id="fchGiro"
                            name="fchGiro"
                            class="form-control"
                            value="
                                {if is_object($arrPost.fchGiro)}
                                    {$arrPost.fchGiro->format("Y-m-d")}
                                {else}
                                    {if $arrPost.fchGiro != ''}
                                        {$arrPost.fchGiro}
                                    {/if}
                                {/if}
                            "
                            readonly
                        >
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="txtComentario" class="col-sm-2 control-label">Comentario</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="txtComentario" name="txtComentario" rows="3"
                              {if $bolImprimir == true} disabled {/if}>{$arrPost.txtComentario}</textarea>
                </div>
            </div>

        </div>
        <div class="panel-footer" align="center">&nbsp;
            {if $bolImprimir == true}
                {*<button type="button" name="volver" class="btn btn-danger" style="width: 100px;" onclick="">PDF</button>*}
            {/if}
            <button type="button" name="salvar" value="1" class="btn btn-primary" style="width: 100px;" {if $bolImprimir == true} disabled {/if}
                    onclick="someterFormulario('contenido',this.form,'./contenidos/pryGestionFinanciera/salvarGiroConstructor.php',false,true);">Salvar Giro</button>

            <button type="button" name="volver" class="btn btn-default" style="width: 100px;"
                    onclick="cargarContenido('contenido','./contenidos/pryGestionFinanciera/listadoGirosConstructor.php','',true);">Volver</button>
        </div>
    </div>

</form>

<!-- Modal de unidades seleccionadas -->
<div class="modal fade" id="modalUnidades" tabindex="-1" role="dialog" aria-labelledby="modalUnidadesLabel">
    <div class="modal-dialog" role="document" style="width: 900px; height: 300px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalUnidadesLabel">Unidades a procesar</h4>
            </div>
            <div class="modal-body">
                {assign var=seqProyecto value=$arrPost.seqProyecto}
                <table id="listadoAadPry" class="table table-striped" width="850px">
                    <thead>
                    <tr>
                        <th>Proyecto</th>
                        <th>Conjunto</th>
                        <th>Unidad</th>
                        <th>Giro</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$arrUnidades key=seqProyecto item=arrDatos}
                        {foreach from=$arrDatos key=seqUnidadProyecto item=valGiro}
                            <tr>
                                <td>{$claGestion->arrGiroConstructor.detalle.$seqUnidadProyecto.txtNombreProyecto|upper}</td>
                                <td>{$claGestion->arrGiroConstructor.detalle.$seqUnidadProyecto.txtNombreConjunto|upper}</td>
                                <td>{$claGestion->arrGiroConstructor.detalle.$seqUnidadProyecto.txtNombreUnidad|upper}</td>
                                <td style="text-align: right">$ {$valGiro|number_format:0:',':'.'}</td>
                            </tr>
                        {/foreach}
                    {/foreach}
                    </tbody>
                </table>
                <div id="listadoAadProyectos"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="divCalendar"></div>