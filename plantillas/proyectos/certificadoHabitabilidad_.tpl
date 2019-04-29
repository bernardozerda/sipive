&nbsp;
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<form id="certHab" class="form-horizontal" onsubmit="someterFormulario('contenido',this,'./contenidos/proyectos/certificadoHabitabilidad.php', false, true); return false;">
    <div class="form-group">
        <label class="control-label col-sm-1" for="proyecto">Proyecto</label>
        <div class="col-sm-8">
            <select class="form-control input-sm" id="proyecto" name="seqProyecto" onchange="$('#certHab').submit();">
                <option value="0">Seleccione</option>
                {foreach from=$arrProyectos key=seqProyectoSelect item=txtNombreProyecto}
                    <option value="{$seqProyectoSelect}" {if $seqProyectoSelect == $seqProyecto} selected {/if}>{$txtNombreProyecto}</option>
                {/foreach}
            </select>
        </div>
    </div>
</form>

<!-- detalle del giro -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">Certificados disponibles</h6>
    </div>
    <div class="panel-body">

        <table id="listadoAadPry" data-order='[[ 0, "desc" ]]' class="table table-striped table-condensed table-hover" width="850px">
            <thead>
            <tr>
                <th align="center" style="width: 450px">Proyecto</th>
                <th align="center">Unidad</th>
                <th align="center"></th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$arrListado.$seqProyecto key=seqUnidadProyecto item=arrUnidades}
                <tr>
                    <td class="text-left">{$arrUnidades.proyecto}</td>
                    <td class="text-left">{$arrUnidades.nombre}</td>
                    <td class="text-center">
                        <a href="#" class="text-primary" onclick="certificadoHabitabilidadProyecto({$seqUnidadProyecto})">
                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true" style="cursor: pointer"></span>
                        </a>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>

    </div>
    <div class="modal-footer"></div>
</div>

<div id="listadoAadProyectos"></div>