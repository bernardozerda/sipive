<table id="listadoCdp" data-order='[[ 0, "desc" ]]' class="table table-striped table-condensed table-hover" width="900px">
    <thead>
    <tr>
        <th>Registro</th>
        <th>Proyecto</th>
        <th>CDP</th>
        <th>Fecha</th>
        <th>Valor</th>
        <th>Vigencia</th>
        <th>RP</th>
        <th>Fecha</th>
        <th>Valor</th>
        <th>Vigencia</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    {foreach from=$arrCdp item=arrDato}
        <tr>
            <td align="center">{$arrDato.seqRegistroPresupuestal}</td>
            <td align="center">{$arrDato.numProyectoInversionCDP}</td>
            <td align="center">{$arrDato.numNumeroCDP}</td>
            <td align="center">{$arrDato.fchFechaCDP}</td>
            <td align="center">{$arrDato.valValorCDP|number_format}</td>
            <td align="center">{$arrDato.numVigenciaCDP}</td>
            <td align="center">{$arrDato.numNumeroRP}</td>
            <td align="center">{$arrDato.fchFechaRP}</td>
            <td align="center">{$arrDato.valValorRP|number_format}</td>
            <td align="center">{$arrDato.numVigenciaRP}</td>
            <td align="center" class="text-danger">
                {if isset($smarty.session.arrGrupos.3.20)}
                    <span class="glyphicon glyphicon-trash"
                          aria-hidden="true"
                          style="cursor: pointer"
                          onClick="
                            $('#salvar').val(2);
                            $('#eliminar').val({$arrDato.seqRegistroPresupuestal});
                            $('#frmCDP').submit();
                          "
                    ></span>
                {/if}
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>

<div id="listadoCdpListener"></div>