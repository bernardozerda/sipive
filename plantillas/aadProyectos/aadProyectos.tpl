&nbsp;
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">Actos administrativos de unidades</h4>
    </div>
    <div class="panel-body">
        <table id="listadoAadPry" data-order='[[ 5, "desc" ]]' class="table table-striped table-condensed table-hover" width="100%">
            <thead>
                <th align="center">Identificador</th>
                <th align="center">Tipo de Acto</th>
                <th align="center">Número</th>
                <th align="center">Fecha</th>
                <th align="center">Vinculados</th>
                <th align="center">Creación</th>
                <th align="center">Usuario</th>
                <th align="center" style="display:none">Proyectos</th>
                <th align="center"></th>
                <th align="center"></th>
            </thead>
            <tbody>
                {foreach from=$arrActos key=seqUnidadActo item=arrActo}
                    <tr>
                        <td>{$seqUnidadActo}</td>
                        <td>{$arrActo.tipo}</td>
                        <td>{$arrActo.numero}</td>
                        <td>{$arrActo.fecha}</td>
                        <td>{$arrActo.unidades|@count}</td>
                        <td>{$arrActo.creacion}</td>
                        <td>{$arrActo.usuario}</td>
                        <td style="display:none">{$arrActo.proyectos|@implode:','}</td>
                        <td>
                            <a href="#" onClick="cargarContenido('contenido','./contenidos/aadProyectos/ver.php','seqUnidadActo={$seqUnidadActo}',true);">
                                <span class="glyphicon glyphicon-zoom-in" aria-hidden="true" style="cursor: pointer"></span>
                            </a>
                        </td>
                        <td>
                            {if isset($smarty.session.arrGrupos.6.20)}
                                <a href="#" onclick="" class="text-danger">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true" style="cursor: pointer"></span>
                                </a>
                            {/if}
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
    <div class="panel-footer" align="center">
        {if isset($smarty.session.arrGrupos.3.20)}
            <button class="btn btn-primary" onclick="cargarContenido('contenido','./contenidos/aadProyectos/crear.php','',true);">
                Nuevo Acto Administrativo
            </button>
        {/if}
    </div>
</div>

<div id="listadoAadProyectos"></div>
