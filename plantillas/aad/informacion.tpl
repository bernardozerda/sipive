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

<form class="form-horizontal" id="frmProyectos" onsubmit="someterFormulario('contenido',this,'./contenidos/aad/salvar.php',true,true); return false;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Información del Acto Administrativo</h6>
        </div>
        <div class="panel-body">
            <div class="col-sm-5">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="seqTipoActo">Tipo</label>
                    <div class="col-sm-10">
                        <select name="seqTipoActo"
                                id="seqTipoActo"
                                class="form-control input-sm"
                                onchange="cargarContenido('contenido','./contenidos/aad/nuevo.php','seqTipoActo=' + $(this).val(),true)"
                                {if intval($claActo->seqTipoActo) != 0}
                                    disabled
                                {/if}
                        >
                            {foreach from=$arrTipoActo key=seqTipo item=arrTipo}
                                <option value="{$seqTipo}"
                                        {if intval($claActo->seqTipoActo) != 0}
                                            {if $seqTipo == $claActo->seqTipoActo}
                                                selected
                                            {/if}
                                        {else}
                                            {if $seqTipo == $arrPost.seqTipoActo}
                                                selected
                                            {/if}
                                        {/if}
                                >{$arrTipo->txtTipoActo}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="numActo">Número</label>
                    <div class="col-sm-5">
                        <input type="text"
                               id="numActo"
                               name="numActo"
                               value="{if intval($claActo->seqTipoActo) != 0}{$claActo->numActo}{elseif intval($arrPost.numActo) != 0}{$arrPost.numActo}{/if}"
                                {if intval($claActo->seqTipoActo) != 0} disabled {/if}
                               class="form-control input-sm"
                        >
                    </div>
                    <input type="checkbox"
                           name="bolRadicado"
                           value="1"
                           {if isset($arrPost.bolRadicado) and $arrPost.bolRadicado == 1} checked {/if}
                    >&nbsp;<span class="h6">Es radicado</span>
                </div>
                <div class="form-group">
                    <label for="fchActo" class="control-label col-sm-2">Fecha</label>
                    <div class="col-sm-5">
                        <div class="input-group input-group-sm date"
                             {if intval($claActo->seqTipoActo) == 0}
                                onclick="$('#fchActo').trigger('focus')"
                             {/if}
                        >
                            <label class="input-group-btn">
                                <span class="btn btn-default btn-sm">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                </span>
                            </label>
                            <input type="text"
                                   id="fchActo"
                                   name="fchActo"
                                   class="form-control"
                                   readonly
                                   {if intval($claActo->seqTipoActo) != 0} disabled {/if}
                                   value="{if intval($claActo->seqTipoActo) != 0}{$claActo->fchActo->format('Y-m-d')}{else}{$arrPost.fchActo}{/if}"
                            >
                        </div>
                    </div>
                </div>
                {if intval($claActo->seqTipoActo) == 0}
                    <div class="form-group">
                        <label for="archivo" class="control-label col-sm-2">Hogares Vinculados</label>
                        <div class="col-sm-10">
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
                {/if}
            </div>
            <div class="col-sm-7">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="txtResolucion">Descripción</label>
                    <div class="col-sm-10">
                        <textarea class="form-control input-sm"
                                  id="txtResolucion"
                                  name="txtResolucion"
                                  {if intval($claActo->seqTipoActo) != 0}
                                      disabled
                                      rows="6"
                                  {else}
                                      rows="9"
                                  {/if}
                        >{if intval($claActo->seqTipoActo) != 0}{$claActo->arrCaracteristicas.txtResolucion}{else}{$arrPost.txtResolucion}{/if}</textarea>
                    </div>
                </div>
            </div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#info" aria-controls="giro" role="tab" data-toggle="tab">Información</a>
                </li>
                {if intval($claActo->seqTipoActo) != 0}
                    <li role="presentation">
                        <a href="#detalles" aria-controls="documentos" role="tab" data-toggle="tab">Detalles</a>
                    </li>
                {/if}
            </ul>

            <!-- nav content -->
            <div class="tab-content" style="padding-top: 20px;">

                <!-- pestaña para informacion del acto -->
                <div role="tabpanel" class="tab-pane fade in active" id="info">
                    <div class="col-sm-12">
                        {if intval($arrPost.seqTipoActo) == 1}
                            {include file="aad/informacion/asignacion.tpl"}
                        {elseif intval($arrPost.seqTipoActo) == 2 }
                            {include file="aad/informacion/modificatoria.tpl"}
                        {elseif intval($arrPost.seqTipoActo) == 3 }
                            {include file="aad/informacion/inhabilitados.tpl"}
                        {elseif intval($arrPost.seqTipoActo) == 4 }
                            {include file="aad/informacion/reposicion.tpl"}
                        {elseif intval($arrPost.seqTipoActo) == 5 }
                            {include file="aad/informacion/noAsignado.tpl"}
                        {elseif intval($arrPost.seqTipoActo) == 6 }
                            {include file="aad/informacion/renuncia.tpl"}
                        {elseif intval($arrPost.seqTipoActo) == 7 }
                            {include file="aad/informacion/notificaciones.tpl"}
                        {elseif intval($arrPost.seqTipoActo) == 8 }
                            {include file="aad/informacion/indexacion.tpl"}
                        {elseif intval($arrPost.seqTipoActo) == 9 }
                            {include file="aad/informacion/perdida.tpl"}
                        {elseif intval($arrPost.seqTipoActo) == 10}
                            {include file="aad/informacion/revocatoria.tpl"}
                        {elseif intval($arrPost.seqTipoActo) == 11}
                            {include file="aad/informacion/exclusion.tpl"}
                        {else}
                            {include file="aad/informacion/asignacion.tpl"}
                        {/if}
                    </div>
                </div>

                {if intval($claActo->seqTipoActo) != 0}

                    <!-- pestaña para detalles del acto -->
                    <div role="tabpanel" class="tab-pane fade" id="detalles">
                        {include file="aad/detalles.tpl"}
                    </div>

                {/if}

            </div>

        </div>
        <div class="panel-footer text-center">
            <div class="row">
                <div class="
                    {if intval($claActo->seqTipoActo) == 0}
                        col-sm-offset-2 col-sm-3
                    {else}
                        col-sm-12
                    {/if}"
                >
                    <button type="button"
                            onclick="cargarContenido('contenido','./contenidos/aad/aad.php','',true);"
                            class="btn btn-default btn-sm"
                    >
                        Volver
                    </button>
                </div>
                {if intval($claActo->seqTipoActo) == 0}
                    <div class="col-sm-3">
                        <button type="button"
                                class="btn btn-success btn-sm"
                                onclick="location.href='./contenidos/aad/plantilla.php?seqTipoActo=' + $('#seqTipoActo').val()"
                        >
                            Plantilla
                        </button>
                    </div>
                    <div class="col-sm-3">
                        <button type="button"
                                onclick="$('#frmProyectos').submit();"
                                class="btn btn-primary btn-sm">
                            Guardar
                        </button>
                    </div>
                {/if}
            </div>
        </div>
    </div>
</form>

<div id="divCalendar"></div>

