&nbsp;
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
      integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

{if not empty($claGestion->arrErrores)}
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Hay Errores!</strong> {$claGestion->arrErrores.0}
    </div>
{/if}

{if not empty($claGestion->arrMensajes)}
    <div class="alert alert-success alert-dismissible" role="alert" style="font-size: 12px">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Hecho!</strong> {$claGestion->arrMensajes.0}
    </div>
{/if}

<form class="form-inline">
    <div class="form-group">
        <label for="seqProyecto"><h5>Proyecto</h5></label>&nbsp;&nbsp;&nbsp;
        <select id="seqProyecto" class="form-control input-sm" name="seqProyecto" onchange="someterFormulario('contenido',this.form,'./contenidos/pryGestionFinanciera/liberacion.php',false,true);">
            <option value="0">Seleccione Proyecto</option>
            {foreach from=$claGestion->arrProyectos key=seqProyecto item=txtNombreProyecto}
                <option value="{$seqProyecto}" {if $arrPost.seqProyecto == $seqProyecto} selected {/if}>
                    {$txtNombreProyecto}
                </option>
            {/foreach}
        </select>
    </div>
</form>

<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            Actos Administrativos de Liberación de Recursos
        </h6>
    </div>
    <div class="panel-body">

        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <th class="h5 text-center"><strong>Resolución</strong></th>
                <th class="h5 text-right"><strong>Total para liberar</strong></th>
                <th class="h5 text-right"><strong>Liberaciones realizadas</strong></th>
                <th class="h5 text-right"><strong>Saldo por liberar</strong></th>
                <th class="h5 text-right"></th>
            </tr>
            </thead>
            <tbody>
                {assign var=bolResoluciones value=false}
                {foreach name=main from=$claGestion->arrResoluciones key=seqUnidadActoPrimario item=arrResolucion}
                    {if $arrResolucion.total < 0}
                        {assign var=bolResoluciones value=true}
                        <tr>
                            <td class="h5 text-left">{$arrResolucion.tipo} {$arrResolucion.numero} de {$arrResolucion.fecha->format(Y)}</td>
                            <td class="h5 text-right">$ {$arrResolucion.total|abs|number_format:0:',':'.'}</td>
                            <td class="h5 text-right">$ {$arrResolucion.liberaciones|abs|number_format:0:',':'.'}</td>
                            <td class="h5 text-right">
                                {if isset($arrResolucion.saldo)}
                                    $ {$arrResolucion.saldo|abs|number_format:0:',':'.'}
                                {else}
                                    $ {$arrResolucion.total|abs|number_format:0:',':'.'}
                                {/if}
                            </td>
                            <td align="center">
                                <button type="button" class="btn btn-default btn-xs" onclick="mostrarOcultar('cdpDisponibles{$seqUnidadActoPrimario}')">
                                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Detalle
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td id="cdpDisponibles{$seqUnidadActoPrimario}" colspan="5"
                                style="display: {if not (isset($arrPost.seqUnidadActoPrimario) and $seqUnidadActoPrimario == $arrPost.seqUnidadActoPrimario)} none {/if}">
                                <table class="table table-striped" cellspacing="0" cellpadding="0" width="100%">
                                    <thead>
                                        <tr>
                                            <td style="background-color: #D9EDF7; color: #31708F;" colspan="8" class="text-center h5">
                                                Actos administrativos disponibles para liberar recursos
                                            </td>
                                        </tr>
                                        <tr>
                                            <th width="100px"></th>
                                            <th width="100px"></th>
                                            <th width="100px" class="text-right">Total</th>
                                            <th width="100px" class="text-right">Giros</th>
                                            <th width="100px" class="text-right">Liberaciones</th>
                                            <th width="100px" class="text-right">Saldo</th>
                                            <th width="120px"></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {foreach name=secondary from=$claGestion->arrResoluciones key=seqUnidadActo item=arrResolucion}
                                            {if $arrResolucion.total > 0}
                                                {math equation="x * y" x=$arrResolucion.cdp|@count y=2 assign=rowSpan}
                                                <tr>
                                                <td {if $rowSpan != 0} rowspan="{$rowSpan}" {/if}>
                                                    {$arrResolucion.tipo}<br>{$arrResolucion.numero} de {$arrResolucion.fecha->format(Y)}
                                                </td>
                                                {if not empty($arrResolucion.cdp)}
                                                    {foreach name=cdp from=$arrResolucion.cdp key=seqRegistroPresupuestal item=arrCDP}
                                                        {if not $smarty.foreach.cdp.first}<tr>{/if}
                                                            <td class="text-left">
                                                                <strong><u>C:</u></strong> {$arrCDP.numeroCDP} de {$arrCDP.fechaCDP->format(Y)}<br>
                                                                <strong><u>R:</u></strong> {$arrCDP.numeroRP} de {$arrCDP.fechaRP->format(Y)}
                                                            </td>
                                                            <td class="text-right">
                                                                $ {$arrCDP.valorRP|number_format:0:',':'.'}
                                                            </td>
                                                            <td class="text-right">
                                                                $ {$arrCDP.giros|number_format:0:',':'.'}
                                                            </td>
                                                            <td class="text-right">
                                                                $ {$arrCDP.liberaciones|abs|number_format:0:',':'.'}
                                                            </td>
                                                            <td class="text-right">
                                                                {if $arrCDP.saldo != 0}
                                                                    $ {$arrCDP.saldo|number_format:0:',':'.'}
                                                                {else}
                                                                    $ {$arrCDP.valorRP|number_format:0:',':'.'}
                                                                {/if}
                                                            </td>
                                                            <td>
                                                                <form id="Slv{$seqUnidadActoPrimario}-{$seqRegistroPresupuestal}" onsubmit="someterFormulario('contenido',this,'./contenidos/pryGestionFinanciera/salvarLiberacion.php',false, true); return false">
                                                                    <input type="text" name="valor" onkeyup="formatoSeparadores(this)" style="width: 100px;">
                                                                    <input type="hidden" name="seqUnidadActoPrimario" value="{$seqUnidadActoPrimario}">
                                                                    <input type="hidden" name="seqUnidadActo" value="{$seqUnidadActo}">
                                                                    <input type="hidden" name="seqRegistroPresupuestal" value="{$seqRegistroPresupuestal}">
                                                                    <input type="hidden" name="seqProyecto" value="{$arrPost.seqProyecto}">
                                                                </form>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-primary btn-xs text-center" onClick="$('#Slv{$seqUnidadActoPrimario}-{$seqRegistroPresupuestal}').submit();">
                                                                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Salvar
                                                                </button>&nbsp;
                                                                <button type="button" class="btn btn-default btn-xs text-center" onclick="mostrarOcultar('cdpLiberaciones{$seqRegistroPresupuestal}')">
                                                                    <span class="h4">+</span>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7" id="cdpLiberaciones{$seqRegistroPresupuestal}"
                                                                style="display: {if not (isset($arrPost.seqRegistroPresupuestal) and $seqRegistroPresupuestal == $arrPost.seqRegistroPresupuestal)} none {/if}">
                                                                <table class="table table-striped" cellspacing="0" cellpadding="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-right">Valor</th>
                                                                            <th class="text-center">Fecha</th>
                                                                            <th>Usuario</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        {foreach from=$claGestion->arrResoluciones.$seqUnidadActoPrimario.cdp.$seqRegistroPresupuestal.detalle key=seqLiberacion item=arrRegistro}
                                                                            <tr>
                                                                                <td class="text-right" width="120px">$ {$arrRegistro.valor|abs|number_format:0:',':'.'}</td>
                                                                                <td class="text-center" width="150px">{$arrRegistro.fecha->format('Y-m-d H:i:s')}</td>
                                                                                <td>{$arrRegistro.usuario}</td>
                                                                                <td width="100px" class="text-right">
                                                                                    {if isset($smarty.session.arrGrupos.6.20)}
                                                                                        <form id="Del{$seqLiberacion}" onsubmit="someterFormulario('contenido',this,'./contenidos/pryGestionFinanciera/eliminarLiberacion.php',false, true); return false">
                                                                                            <button type="submit" class="btn btn-danger btn-xs">
                                                                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Eliminar
                                                                                            </button>
                                                                                            <input type="hidden" name="seqUnidadActoPrimario" value="{$seqUnidadActoPrimario}">
                                                                                            <input type="hidden" name="seqRegistroPresupuestal" value="{$seqRegistroPresupuestal}">
                                                                                            <input type="hidden" name="seqProyecto" value="{$arrPost.seqProyecto}">
                                                                                            <input type="hidden" name="seqLiberacion" value="{$seqLiberacion}">
                                                                                        </form>
                                                                                    {/if}
                                                                                </td>
                                                                            </tr>
                                                                        {/foreach}
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    {/foreach}
                                                {else}
                                                    </tr>
                                                {/if}
                                            {/if}
                                        {/foreach}
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    {/if}
                {/foreach}
            </tbody>
        </table>

        {if $bolResoluciones == false and $arrPost.seqProyecto != 0}
            <div class="alert alert-warning alert-dismissible" role="alert" style="font-size: 12px">
                <strong>Atención!</strong> No hay información de resoluciones disponibles para liberación de recursos para este proyecto
            </div>
        {/if}

    </div>
    <div class="panel-footer" align="center">
        &nbsp;
    </div>
</div>
