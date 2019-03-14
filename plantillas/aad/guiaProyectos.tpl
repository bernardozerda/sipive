
{if $arrUnidades.disponibles == 0}
    {assign var=numDisponibles value=0}
{else}
    {assign var=numDisponibles value=$arrUnidades.disponibles}
{/if}

{if $arrUnidades.total == 0}
    {assign var=numTotal value=0}
{else}
    {assign var=numTotal value=$arrUnidades.total}
{/if}

{math equation="x -y" x=$numTotal y=$numDisponibles assign=numNoDisponibles}

<div class="col-sm-12">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">

        <li role="presentation" class="active">
            <a href="#disponibles" aria-controls="disponibles" role="tab" data-toggle="tab">
                Disponibles <span class="label label-success">{$numDisponibles}</span>
            </a>
        </li>

        <li role="presentation">
            <a href="#noDisponibles" aria-controls="noDisponibles" role="tab" data-toggle="tab">
                No Disponibles <span class="label label-danger">{$numNoDisponibles}</span>
            </a>
        </li>

    </ul>

    <!-- nav content -->
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
                        {foreach from=$arrUnidades.unidades key=seqUnidadProyecto item=arrUnidad}
                            {if $arrUnidad.disponible == 0}
                                <tr>
                                    <td>{$arrUnidad.descripcion|mb_strtoupper}</td>
                                </tr>
                            {/if}
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane fade" id="noDisponibles">
            <div class="col-sm-12">
                <table class="table table-striped" id="listadoAadPry2" width="1000px">
                    <thead>
                        <tr>
                            <th>Descripción de la unidad</th>
                            <th>Documento</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$arrUnidades.unidades key=seqUnidadProyecto item=arrUnidad}
                            {if $arrUnidad.disponible == 1}
                                <tr>
                                    <td>{$arrUnidad.descripcion}</td>
                                    <td align="right">{$arrUnidad.documento}</td>
                                    <td>{$arrUnidad.nombre|mb_strtoupper}</td>
                                </tr>
                            {/if}
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<div id="listadoAadProyectos"></div>
<div id="listadoAadProyectos2"></div>
