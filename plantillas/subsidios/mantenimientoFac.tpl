&nbsp;
<link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous"
>

<form onsubmit="someterFormulario('contenido', this, './contenidos/subsidios/mantenimientoFac.php', true, true); return false;" enctype="multipart/form-data">

    {if not empty($arrErrores)}
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {foreach from=$arrErrores item=txtError}
                <li class="h5">{$txtError}</li>
            {/foreach}
        </div>
    {else}
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {foreach from=$arrMensajes item=txtMensaje}
                <li class="h5">{$txtMensaje}</li>
            {/foreach}
        </div>
    {/if}


<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">Mantenimiento de formularios de actos administrativos</h6>
    </div>
    <div class="panel-body">

        <div class="form-group">
            <label for="archivo" class="col-sm-2 control-label" style="padding-top: 8px;">Archivo de carga</label>
            <div class="col-sm-8">
                <div class="input-group input-group-sm">
                    <label class="input-group-btn">
                        <span class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                            <input type="file" name="archivo" style="display: none;">
                        </span>
                    </label>
                    <input id="archivo" type="text" class="form-control" readonly>
                    <div id="fileSelect"></div>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button"
                        class="btn btn-primary btn-sm"
                        data-toggle="modal"
                        data-target="#help"
                >
                    <span class="glyphicon glyphicon-question-sign"></span>
                </button>
            </div>
        </div>

    </div>
    <div class="panel-footer text-center">
        <button type="submit" class="btn btn-primary btn-sm">Salvar Cambios</button>
    </div>
</div>

</form>

    <div class="modal fade" id="help" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Plantilla de carga</h4>
                </div>
                <div class="modal-body">
                    <ol class="h5">
                        <li>Documento</li>
                        <li>Nombre</li>
                        <li>ID Hogar</li>
                        <li>Fecha de Inscripción</li>
                        <li>Carpeta postulación</li>
                        <li>Fecha Postulación</li>
                        <li>Desplazado</li>
                        <li>Resolución Asignación</li>
                        <li>Año</li>
                        <li>Fecha Resolución</li>
                        <li>Estado</li>
                    </ol>
                    <p>(*) La primera fila del archivo son titulos</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>