
<link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous"
>

{if not empty($claInscripcion->arrErrores.general)}
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {foreach from=$claInscripcion->arrErrores.general item=txtError}
            <li>{$txtError}</li>
        {/foreach}
    </div>
{/if}

{if not empty($claInscripcion->arrMensajes)}
    <div class="alert alert-success alert-dismissible" role="alert" style="font-size: 12px">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Hecho!</strong> {$claInscripcion->arrMensajes.0}
    </div>
{/if}


<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">Información del cargue</h6>
    </div>
    <div class="panel-body">

        <!-- informacion del cargue -->
        {if $claInscripcion->seqEstado != 2}
            <div class="alert alert-info">
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Identificador del cargue</strong><br>
                        <strong>Tipo del cargue</strong>
                    </div>
                    <div class="col-sm-1">
                        {$claInscripcion->seqCargue}<br>
                        {$claInscripcion->txtTipo}
                    </div>
                    <div class="col-sm-3">
                        <strong>
                            Líneas procesadas<br>
                            Líneas no procesadas<br>
                            Total de Líneas del archivo
                        </strong>
                    </div>
                    <div class="col-sm-1 text-right">
                        {assign var=numLineasProcesadas value=$claInscripcion->arrLineasProcesadas.procesadas|intval}
                        {assign var=numLineasOmitidas   value=$claInscripcion->arrLineasProcesadas.omitidas.conteo|intval}
                        {math equation="x + y" x=$numLineasProcesadas y=$numLineasOmitidas assign="numTotalLineas"}
                        {$claInscripcion->arrLineasProcesadas.procesadas|intval}<br>
                        {$claInscripcion->arrLineasProcesadas.omitidas.conteo|intval}<br>
                        {$numTotalLineas}
                    </div>
                    <div class="col-sm-2">
                        <br>
                        <a href="#"
                           data-toggle="modal"
                           data-target="#lineasProcesadas"
                        >
                            Ver Detalles
                        </a>
                        <br>
                    </div>
                </div>
            </div>
        {/if}

        <!-- barra de progreso mientras esta corriendo el script -->
        {if $claInscripcion->seqEstado == 2}
            <div id="progreso" style="height: 150px;">
                {include file="inscripcionFonvivienda/barraProgreso.tpl"}
            </div>
        {else}

            <!-- muestra resultados -->
            <table id="listadoAadPry" class="table table-hover" data-order='[[ 0, "asc" ]]' width="850px">
                <thead>
                    <tr>
                        <th>Identificador</th>
                        <th>Número</th>
                        <th>Proyecto</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$claInscripcion->arrHogares key=numHogar item=arrHogar}
                        <tr>
                            <td align="center" width="100px">{$arrHogar.seqHogar}</td>
                            <td align="center" width="100px">{$numHogar}</td>
                            <td>{$arrHogar.txtDireccionSolucion}</td>
                            <td width="100px">
                                {if $arrHogar.seqEstadoHogar == 1}     <span class="text-muted">
                                {elseif $arrHogar.seqEstadoHogar == 2} <span class="text-primary">
                                {elseif $arrHogar.seqEstadoHogar == 3} <span class="text-danger">
                                {elseif $arrHogar.seqEstadoHogar == 4} <span class="text-success">
                                {else} <span> {/if}
                                {$arrHogar.txtEstadoHogar}</span>
                            </td>
                            <td>
                                <a href="#"
                                   class=""
                                   onclick="cargarContenido('contenido','./contenidos/inscripcionFonvivienda/detalles.php','seqCargue={$claInscripcion->seqCargue}&numHogar={$numHogar}')"
                                >
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        {/if}

    </div>
    <div class="panel-footer text-center">
        <button type="button"
                class="btn btn-default btn-sm"
                onclick="cargarContenido('contenido','./contenidos/inscripcionFonvivienda/inscripcionFonvivienda.php','',true);"
                style="width: 100px"
        >
            Volver
        </button>
        {if $claInscripcion->seqEstado != 2}
            <button type="button"
                    class="btn btn-success btn-sm"
                    onclick="location.href='./contenidos/inscripcionFonvivienda/exportable.php?seqCargue={$claInscripcion->seqCargue}';"
                    style="width: 100px"
            >
                Exportar
            </button>
        {/if}
        {if isset($smarty.session.arrGrupos.3.20)}
            {if $claInscripcion->seqEstado != 2}
                <button type="button"
                        class="btn btn-danger btn-sm {if $bolProcesar == false} disabled {/if}"
                        onclick="cargarContenido('contenido','./contenidos/inscripcionFonvivienda/procesarCargue.php','seqCargue={$claInscripcion->seqCargue}',true);"
                        style="width: 100px"
                        {if $bolProcesar == false} disabled {/if}
                >
                    Procesar
                </button>
            {/if}
        {/if}
    </div>
</div>

<!-- Detalles de las lineas no procesadas -->
<div class="modal fade" id="lineasProcesadas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width:900px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detalle de las líneas no procesadas</h4>
            </div>
            <div class="modal-body">
                <table id="listadoCdp" class="table table-striped" width="850px">
                    <thead>
                        <tr>
                            <th width="100px">Linea del Excel</th>
                            <th width="700px">Motivo para no procesar</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$claInscripcion->arrLineasProcesadas.omitidas.razon key=numLinea item=txtRazon}
                            <tr>
                                <td width="100px">{$numLinea}</td>
                                <td width="700px">{$txtRazon}</td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div id="listadoAadProyectos"></div>
<div id="listadoCdpListener"></div>

