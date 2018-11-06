
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

        <div class="alert alert-info">
            <div class="row">
                {math equation="x + y" x=$claInscripcion->arrLineasProcesadas.procesadas y=$claInscripcion->arrLineasProcesadas.omitidas.conteo assign="numTotalLineas"}
                <div class="col-sm-2 h5"><strong>Total lineas:</strong></div>
                <div class="col-sm-1 h5">{$numTotalLineas}</div>

                <div class="col-sm-3 h5"><strong>Procesadas:</strong></div>
                <div class="col-sm-1 h5">{$claInscripcion->arrLineasProcesadas.procesadas}</div>

                <div class="col-sm-4 h5"><strong>No Procesadas: <a href="#" onclick="mostrarOcultar('resumen')">Ver Detalle</a></strong></div>
                <div class="col-sm-1 h5">{$claInscripcion->arrLineasProcesadas.omitidas.conteo}</div>
            </div>
            <div class="row" id="resumen" style="display: none;">
                {foreach from=$claInscripcion->arrLineasProcesadas.omitidas.razon key=numLinea item=txtRazon}
                    <ul>
                        <li><strong>Linea del archivo {$numLinea}:</strong> {$txtRazon}</li>
                    </ul>
                {/foreach}
                <a href="#" onclick="mostrarOcultar('resumen')">Ocultar Detalle</a>
            </div>
        </div>


        {if $claInscripcion->seqEstado == 2}
            <div id="progreso" style="height: 150px;">
                {include file="inscripcionFonvivienda/barraProgreso.tpl"}
            </div>
        {else}

            <table id="listadoAadPry" class="table table-hover" data-order='[[ 0, "asc" ]]' width="850px">
                <thead>
                <tr>
                    <th>Id Hogar del Cargue</th>
                    <th>Datos</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    {foreach from=$claInscripcion->arrHogares key=numHogar item=arrHogar}
                        <tr>
                            <td class="text-center h4" width="30px">{$numHogar}</td>
                            <td>
                                <strong>Modalidad:</strong> {$arrHogar.txtModalidad} <br>
                                <strong>Esquema:</strong> {$arrHogar.txtTipoEsquema} <br>
                                <strong>Rango de Ingresos:</strong> {$arrHogar.txtRangoIngresos} <br>
                                <strong>Solución:</strong> {$arrHogar.txtDescripcion} <br>
                                <strong>Dirección Solución:</strong> {$arrHogar.txtDireccionSolucion}
                            </td>
                            <td width="150px">
                                <h5>

                                    {if $arrHogar.seqEstadoHogar == 1}
                                        <span class="text-muted">
                                    {elseif $arrHogar.seqEstadoHogar == 2}
                                        <span class="text-primary">
                                    {elseif $arrHogar.seqEstadoHogar == 3}
                                            <span class="text-danger">
                                    {elseif $arrHogar.seqEstadoHogar == 4}
                                        <span class="text-success">
                                    {else}
                                        <span>
                                    {/if} {$arrHogar.txtEstadoHogar}</span>
                                </h5>
                            </td>
                            <td width="100px">
                                <button type="button"
                                        class="btn btn-primary btn-sm"
                                        onclick="cargarContenido('contenido','./contenidos/inscripcionFonvivienda/detalles.php','seqCargue={$claInscripcion->seqCargue}&numHogar={$numHogar}')"
                                >
                                    Detalles
                                </button>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
            <div id="listadoAadProyectos"></div>

        {/if}

    </div>
    <div class="panel-footer text-center">
        <div class="row text-center">
            <div class="{if $claInscripcion->seqEstado != 2} col-sm-offset-3 {else} col-sm-offset-4 {/if} col-sm-3 text-center">
                <button type="button"
                        class="btn btn-default btn-sm"
                        onclick="cargarContenido('contenido','./contenidos/inscripcionFonvivienda/inscripcionFonvivienda.php','',true);"
                >
                    Volver
                </button>
            </div>

            <div class="col-sm-3 text-center">
                {if $claInscripcion->seqEstado != 2}
                    <button type="button"
                            class="btn btn-success btn-sm"
                            onclick="location.href='./contenidos/inscripcionFonvivienda/exportable.php?seqCargue={$claInscripcion->seqCargue}';"
                    >
                        Exportar
                    </button>
                {/if}
            </div>


            <div class="col-sm-3 text-center">
                {if isset($smarty.session.arrGrupos.3.20)}
                    {if $claInscripcion->seqEstado != 2}
                        <button type="button"
                                class="btn btn-danger btn-sm {if $bolProcesar == false} disabled {/if}"
                                onclick="cargarContenido('contenido','./contenidos/inscripcionFonvivienda/procesarCargue.php','seqCargue={$claInscripcion->seqCargue}',true);"
                                {if $bolProcesar == false} disabled {/if}
                        >
                            Procesar Cargue
                        </button>
                    {/if}
                {/if}
            </div>
        </div>
    </div>
</div>
