
{if not empty($claActo->arrDetalles.detalle)}
    <div class="col-sm-12">
        <table id="detallesAAD" class="table table-striped" width="990px">
            <thead>
            <tr>
                <th>Tipo de Documento</th>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Desplazado</th>
                <th>Estado Actual</th>
                <th>Valor Subsidio</th>
                <th>Referencia</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$claActo->arrDetalles.detalle item=arrDetalle}
                <tr>
                    <td>{$arrDetalle.txtTipoDocumento}</td>
                    <td>{$arrDetalle.numDocumento|number_format:0:'.':','}</td>
                    <td>{$arrDetalle.txtNombre}</td>
                    <td>{$arrDetalle.txtDesplazado}</td>
                    <td>{$arrDetalle.txtEstadoProceso}</td>
                    <td>$ {$arrDetalle.valSubsidio|number_format:0:'.':','}</td>
                    <td>
                        {if intval($arrDetalle.numResolucionReferencia) != 0}
                            Res. {$arrDetalle.numResolucionReferencia} de {$arrDetalle.fchResolucionReferencia->format("Y")}
                        {/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div id="listenerDetallesAAD"></div>
{/if}

{if not empty($claActo->arrDetalles.resumen)}

    <div class="col-sm-12">

        <div class="col-sm-6">
            <ul class="list-group">
                {foreach from=$claActo->arrDetalles.resumen key=txtTitulo item=txtValor}
                    <li class="list-group-item">
                        <span class="badge">
                            {if is_numeric($txtValor)}
                                {$txtValor|number_format:0:'.':'.'}
                            {else}
                                {$txtValor}
                            {/if}
                        </span>
                        {$txtTitulo}
                    </li>
                {/foreach}
            </ul>
        </div>

        <div class="col-sm-6">
            <p class="form-group" style="padding-bottom: 20px;">
                <div class="media form-group"
                     style="cursor: pointer"
                     onclick="location.href='contenidos/aad/exportar.php?seqTipoActo={$claActo->seqTipoActo}&numActo={$claActo->numActo}&fchActo={$claActo->fchActo->format('Y-m-d')}&exportar=detalles'"
                >
                    <div class="media-left">
                        <span class="h1 text-success">
                            <span class="glyphicon glyphicon-export" aria-hidden="true"></span>
                        </span>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">Detalles</h4>
                        Obtenga la información completa del acto administrativo
                    </div>
                </div>
            </p>
            <p class="form-group">
                <div class="media form-group"
                     style="cursor: pointer"
                     onclick="location.href='contenidos/aad/exportar.php?seqTipoActo={$claActo->seqTipoActo}&numActo={$claActo->numActo}&fchActo={$claActo->fchActo->format('Y-m-d')}&exportar=hogares'"
                >
                    <div class="media-left">
                        <span class="h1 text-success">
                            <span class="glyphicon glyphicon-export" aria-hidden="true"></span>
                        </span>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">Hogares</h4>
                        Exportable de la información de los hogares vinculados
                    </div>
                </div>
            </p>
        </div>
    </div>

{/if}
