&nbsp;
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

{if not empty($arrErrores)}
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {foreach from=$arrErrores item=txtError}
            <li>{$txtError}</li>
        {/foreach}
    </div>
{/if}

{if not empty($arrMensajes)}
    <div class="alert alert-success alert-dismissible" role="alert" style="font-size: 12px">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Hecho!</strong> {$arrMensajes.0}
    </div>
{/if}

<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">Listado de Actos Administrativos</h6>
    </div>
    <div class="panel-body">

        <!-- filtros para los actos administrativos -->
        <div class="col-sm-4">
            <form id="frmProyectos" onsubmit="someterFormulario('contenido',this,'./contenidos/aad/aad.php',true,true); return false;" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">FILTROS</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="seqTipoActo" class="control-label">Tipo de Acto</label>
                            <select name="seqTipoActo" id="seqTipoActo" class="form-control input-sm">
                                <option value="0">Todos</option>
                                {foreach from=$arrTipoActo key=seqTipoActo item=arrTipo}
                                    <option value="{$seqTipoActo}" {if $arrPost.seqTipoActo == $seqTipoActo} selected {/if}>{$arrTipo->txtTipoActo}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="numActo" class="control-label">Resolución</label>
                            <input type="text" class="form-control input-sm" id="numActo" name="numActo" value="{$arrPost.numActo}">
                        </div>

                        <div class="form-group">
                            <label for="fchInicial" class="control-label">Fecha Inicial</label>
                            <div class="input-group input-group-sm date" onclick="$('#fchInicial').trigger('focus')">
                                <label class="input-group-btn">
                                    <span class="btn btn-default btn-sm">
                                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                    </span>
                                </label>
                                <input type="text"
                                       id="fchInicial"
                                       name="fchInicial"
                                       class="form-control"
                                       value="{$arrPost.fchInicial}"
                                       readonly
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fchFinal" class="control-label">Fecha Final</label>
                            <div class="input-group input-group-sm" onclick="$('#fchFinal').trigger('focus')">
                                <label class="input-group-btn">
                                    <span class="btn btn-default btn-sm">
                                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                    </span>
                                </label>
                                <input type="text"
                                       id="fchFinal"
                                       name="fchFinal"
                                       class="form-control"
                                       value="{$arrPost.fchFinal}"
                                       readonly
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="archivo" class="control-label">Documentos</label>
                            <div class="input-group input-group-sm">
                                <label class="input-group-btn">
                                    <span class="btn btn-default btn-sm">
                                        <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                                        <input type="file" name="archivo" style="display: none;">
                                    </span>
                                </label>
                                <input type="text" class="form-control" readonly>
                                <div id="fileSelect"></div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-center">
                        <div class="row">
                            <div class="col-sm-8 text-center">
                                <button type="submit" name="filtrar" value="1" class="btn btn-primary btn-sm" style="width: 80px">Filtrar</button>
                            </div>
                            <div class="col-sm-3 text-center">
                                <button type="button" class="btn btn-default btn-sm" style="width: 80px" onclick="cargarContenido('contenido','./contenidos/aad/aad.php','',true);" >Limpiar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- listado de actos administrativos -->
        <div class="col-sm-8">
            <table id="listadoAadPry" class="table table-striped table-hover" width="100%" data-order="[[ 2, &quot;desc&quot; ]]">
                <thead>
                <tr>
                    <th>Tipo de Acto</th>
                    <th>Número</th>
                    <th>Fecha</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$arrActos key=seqTipoActo item=arrActo}
                    {foreach from=$arrActo.listado item=arrDatos}
                        <tr>
                            <td>{$arrTipoActo.$seqTipoActo->txtTipoActo}</td>
                            <td style="text-align: right;">{$arrDatos.numero}</td>
                            <td>{$arrDatos.fecha}</td>
                            <td style="text-align: center;">
                                <a href="#" onClick="cargarContenido('contenido','./contenidos/aad/informacion.php','seqTipoActo={$seqTipoActo}&numActo={$arrDatos.numero}&fchActo={$arrDatos.fecha}',true);">
                                    <span class="glyphicon glyphicon-zoom-in" aria-hidden="true" style="cursor: pointer"></span>
                                </a>
                            </td>
                            <td style="text-align: center">
                                {if isset($smarty.session.arrGrupos.3.20)}
                                    <a href="#" onclick="cargarContenido('contenido','./contenidos/aad/eliminar.php','seqTipoActo={$seqTipoActo}&numActo={$arrDatos.numero}&fchActo={$arrDatos.fecha}',true);" class="text-danger">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true" style="cursor: pointer"></span>
                                    </a>
                                {/if}
                            </td>
                        </tr>
                    {/foreach}
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-footer text-center">
        <button type="button" onclick="cargarContenido('contenido','./contenidos/aad/nuevo.php','',true)" class="btn btn-primary btn-sm">Nuevo Acto</button>
    </div>
</div>

<div id="listadoAadProyectos"></div>
<div id="divCalendar"></div>











