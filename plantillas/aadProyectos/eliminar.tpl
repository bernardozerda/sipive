&nbsp;
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<div class="panel panel-default">
    <div class="alert alert-danger">
        <h5> <strong>Atención!!! </strong> <b>Se ha eliminado la siguiente información.</b></h5>
    </div>
    <div class="panel-heading">
        <h4 class="panel-title">Actos administrativos de unidades</h4>
    </div>
    <div class="panel-body">

        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="table table-bordered">
            <tr>
                <td><strong>Tipo de Acto:</strong></td>
                <td>{$claActo->txtTipoActoUnidad}</td>
                <td><strong>Descripción</strong></td>
            </tr>
            <tr>
                <td><strong>Identificación del Acto</strong></td>
                <td>{$claActo->numActo} de {$claActo->fchActo}</td>
                <td rowspan="3" width="500px">{$claActo->txtDescripcion}</td>
            </tr>
            <tr>
                <td><strong>Fecha de Creación</strong></td>
                <td>{$claActo->fchCreacion}</td>
            </tr>
            <tr>
                <td><strong>Usuario</strong></td>
                <td>{$claActo->txtNombre}</td>
            </tr>
        </table>

        <table id="listadoAadPry" class="table table-striped table-condensed table-hover" width="100%">
            <thead>
            <th>&nbsp;</th>
            <th>Proyecto</th>
            <th>Conjunto</th>
            <th>Unidad</th>
            <th class="text-center">Valor</th>
            <th class="text-center">Fuente</th>
            <th class="text-center">Refencia</th>
            </thead>
            <tbody>
                {foreach from=$claActo->arrUnidades item=arrUnidad}
                    <tr>
                        <td>
                            {if $arrUnidad.txtNombreUnidad != ""}
                                {if $arrUnidad.bolActivoUnidad == 0}
                                    <span class="label label-danger">&nbsp;</span>
                                {else}
                                    <span class="label label-success">&nbsp;</span>
                                {/if}
                            {else}
                                {if $arrUnidad.bolActivoProyecto == 0}
                                    <span class="label label-danger">&nbsp;</span>
                                {else}
                                    <span class="label label-success">&nbsp;</span>
                                {/if}
                            {/if}
                        </td>
                        <td>{$arrUnidad.txtNombreProyecto}</td>
                        <td>{$arrUnidad.txtNombreConjunto}</td>
                        <td>{$arrUnidad.txtNombreUnidad}</td>
                        <td style="font-size: 12px;" class="text-center {if $arrUnidad.valIndexado < 0}alert-danger{else}alert-success{/if}">$ {$arrUnidad.valIndexado|number_format:0:',':'.'}</td>
                        <td class="text-center">
                            {if intval($arrUnidad.numNumeroCDP) != 0}
                                CDP:  {$arrUnidad.numNumeroCDP} de {$arrUnidad.fchFechaCDP->format(Y)} <br>
                                RP:   {$arrUnidad.numNumeroRP}  de {$arrUnidad.fchFechaRP->format(Y)}
                            {/if}
                        </td>
                        <td class="text-center">
                            {if intval($arrUnidad.numActoReferencia) != 0}
                                {$arrUnidad.numActoReferencia} de {$arrUnidad.fchActoReferencia->format('Y-m-d')}
                            {/if}
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>


    </div>
    <div class="panel-footer" align="center">
       <!-- <button class="btn btn-success" onclick="location.href='./contenidos/aadProyectos/exportar.php?seqUnidadActo={$claActo->seqUnidadActo}';">
            Exportar Datos
        </button>-->
        <button class="btn btn-default" onclick="cargarContenido('contenido', './contenidos/aadProyectos/aadProyectos.php', '', true);">
            Volver
        </button>
    </div>
</div>

<div id="listadoAadProyectos"></div>
