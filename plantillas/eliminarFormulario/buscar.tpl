&nbsp;
<link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous"
>

{if $txtMensaje != ""}
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <li class="h5">{$txtMensaje}</li>
    </div>
{/if}

<form class="form-horizontal" onsubmit="someterFormulario('contenido',this,'./contenidos/eliminarFormulario/vistaPrevia.php',true,true); return false;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Eliminar formulario</h6>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="seqTipoDocumento" class="col-sm-2"><h5>Tipo de documento</h5></label>
                <div class="col-sm-3">
                    <select class="form-control input-sm"
                            id="seqTipoDocumento"
                            name="seqTipoDocumento"
                    >
                        <option value="0">Seleccione Uno</option>
                        {foreach from=$arrTipoDocumento key=seqTipoDocumento item=txtTipoDocumento}
                            <option value="{$seqTipoDocumento}">{$txtTipoDocumento}</option>
                        {/foreach}
                    </select>
                </div>
                <label for="numDocumento" class="col-sm-3"><h5>Número de documento</h5></label>
                <div class="col-sm-3">
                    <input type="number"
                           class="form-control input-sm"
                           id="numDocumento"
                           name="numDocumento"
                           value=""

                    >
                </div>
            </div>

        </div>
        <div class="panel-footer text-center">
            <button type="submit"
                    class="btn btn-primary btn-sm"
            >Buscar hogar</button>
        </div>
    </div>
</form>


<table id="listadoAadPry" class="table table-striped" width="100%">
    <thead>
    <tr>
        <th>Fecha</th>
        <th>Id</th>
        <th>Ciudadano</th>
        <th>Comentario</th>
    </tr>
    </thead>
    <tbody>
    {foreach from=$arrBorrados item=arrRegistro}
        <tr>
            <td width="50px">
                {$arrRegistro.fchBorrado}
            </td>
            <td width="50px">
                {$arrRegistro.seqFormulario}
            </td>
            <td>
                {$arrRegistro.txtTipoDocumento|mb_strtoupper} - {$arrRegistro.numDocumento}<br>
                {$arrRegistro.txtNombre|mb_strtoupper}
            </td>
            <td width="500px">
                {$arrRegistro.txtComentario|mb_strtoupper}
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>


<div id="listadoAadProyectos"></div>