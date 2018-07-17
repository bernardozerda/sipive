<link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous"
>

<form id="#frmNuevoCargue" onsubmit="someterFormulario('contenido',this,'./contenidos/inscripcionFonvivienda/cargarNovedades.php',true,true); return false;" enctype="multipart/form-data">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Nueva Masiva Beneficiarios FONVIVIENDA</h6>
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
            </div>
        </div>
        <div class="panel-footer text-center">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary">Salvar Cargue</button>
                </div>
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default"
                            onclick="cargarContenido('contenido','./contenidos/inscripcionFonvivienda/inscripcionFonvivienda.php','',true);">
                        Volver
                    </button>
                </div>
                <div class="col-sm-3">
                    <button type="button" class="btn btn-danger">Procesar Cargue</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- modal de confirmacion si tiene pendientes de liberacion -->
<div class="modal fade" id="modalPendientes" tabindex="-1" role="dialog" aria-labelledby="modalPendientesLabel">
    <div class="modal-dialog" role="document" style="width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalPendientesLabel">Atención !!</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-1">
                        <table width="100%" border="0">
                            <tr>
                                <td style="padding: 30px;" class="h1">
                                    <span class="glyphicon glyphicon-warning-sign text-warning"></span>
                                </td>
                                <td class="h4">
                                    <p>PENDIENTES NOVEDADES</p>
                                    <small>¿Desea continuar?</small>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Continuar</button>
            </div>
        </div>
    </div>
</div>
