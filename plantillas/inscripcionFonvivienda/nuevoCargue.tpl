&nbsp;
<link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous"
>

{if not empty($claInscripcion->arrErrores)}
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {foreach from=$claInscripcion->arrErrores item=txtError}
            <li>{$txtError}</li>
        {/foreach}
    </div>
{/if}

{if not empty($claInscripcion->arrMensajes)}
    <div class="alert alert-success alert-dismissible" role="alert" style="font-size: 12px">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {$claInscripcion->arrMensajes.0}
    </div>
{/if}

<form id="#frmNuevoCargue" onsubmit="someterFormulario('contenido',this,'./contenidos/inscripcionFonvivienda/nuevoCargue.php',true,true); return false;" enctype="multipart/form-data">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Creación de cargue complementariedad</h6>
        </div>
        <div class="panel-body">

            <div class="form-group row">
                <label for="seqTipo" class="col-sm-4 control-label h5">Programa Complementariedad</label>
                <div class="col-sm-4">
                    <select class="form-control input-sm" id="seqTipo" name="seqTipo">
                        <option value="0">Seleccione</option>
                        {foreach from=$claInscripcion->obtenerTipos() key=seqTipo item=txtTipo}
                            <option value="{$seqTipo}" {if $seqTipoPost == $seqTipo} selected {/if}>
                                {$txtTipo}
                            </option>
                        {/foreach}
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="archivo" class="col-sm-4 control-label h5" style="padding-top: 8px;">Archivo de carga</label>
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
                <div class="col-sm-3"></div>
                <div class="col-sm-3">
                    <button type="button"
                            class="btn btn-default btn-sm"
                            onclick="cargarContenido('contenido','./contenidos/inscripcionFonvivienda/inscripcionFonvivienda.php','',true);"
                    >
                        Volver
                    </button>
                </div>
                <div class="col-sm-4">
                    <button type="submit"
                            class="btn btn-primary btn-sm {if $bolPendientes == true} disabled {/if}"
                            {if $bolPendientes == true} disabled {/if}
                    >
                        Crear cargue
                    </button>
                    <input type="hidden" name="crear" value="1">
                </div>
            </div>
        </div>
    </div>
</form>
