&nbsp;
<link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous"
>

{if not empty($arrErrores)}
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {foreach from=$arrErrores item=txtError}
            <li>{$txtError}</li>
        {/foreach}
    </div>
{/if}

{if not empty($arrMensajes)}
    <div class="alert alert-success alert-dismissible" role="alert" style="font-size: 12px">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Hecho!</strong> {$arrMensajes.0}
    </div>
{/if}

<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">Archivo MCY</h6>
    </div>
    <div class="panel-body">

        <form class="form-horizontal" onsubmit="someterFormulario('contenido',this,'./contenidos/archivoMcy/archivoMcy.php', true, true); return false;">
            <div class="form-group">
                <label for="seqTipoDocumento" class="control-label col-sm-1">Tipo</label>
                <div class="col-sm-3">
                    <select id="seqTipoDocumento"
                            name="seqTipoDocumento"
                            class="form-control input-sm"
                    >
                        <option value="0" selected>Seleccione</option>
                        {foreach from=$arrTipoDocumento key=seqTipoDocumento item=txtTipoDocumento}
                            <option value="{$seqTipoDocumento}">{$txtTipoDocumento}</option>
                        {/foreach}
                    </select>
                </div>
                <label for="numDocumento" class="control-label col-sm-1">Número</label>
                <div class="col-sm-3">
                    <input type="number"
                           name="numDocumento"
                           class="form-control input-sm"
                    >
                </div>
                <button type="submit"
                        class="btn btn-primary btn-sm"
                >Consultar</button>
            </div>
        </form>

        <table id="listadoAadPry" class="table table-hover" data-order='[[ 0, "desc" ]]' width="850px">
            <thead>
            <tr>
                <th>Tipo de documento</th>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Reportar Línea</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                {foreach from=$arrListado item=arrLinea}
                    <tr>
                        <td>{$arrLinea.txtTipoDocumento}</td>
                        <td>{$arrLinea.numDocumento}</td>
                        <td>{$arrLinea.txtNombre}</td>
                        <td>{$arrLinea.bolReportarLinea}</td>
                        <td>
                            <span class="glyphicon glyphicon-pencil text-primary"
                                  aria-hidden="true"
                                  style="cursor: pointer"
                                  onclick="cargarContenido('contenido','./contenidos/archivoMcy/ver.php','seqTipoDocumento={$arrLinea.seqTipoDocumento}&numDocumento={$arrLinea.numDocumento}',true)"
                            ></span>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>

    </div>
    <div class="panel-footer text-center" style="height: 55px;">
        <form method="post"
              class="form-horizontal"
              onsubmit="someterFormulario('contenido',this,'./contenidos/archivoMcy/salvar.php',true,true); return false;"
        >

            <label for="archivo" class="col-sm-1 control-label ">Archivo</label>
            <div class="col-sm-5">
                <div class="input-group input-group-sm">
                    <label class="input-group-btn">
                        <span class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                            <input id="archivo" type="file" name="archivo" style="display: none;">
                        </span>
                    </label>
                    <input type="text" class="form-control" readonly>
                    <div id="fileSelect"></div>
                </div>
            </div>
            {if isset($smarty.session.arrGrupos.3.20)}
                <div class="col-sm-2">
                    <button type="submit"
                            class="btn btn-primary btn-sm"
                    >
                        Cargar Datos
                    </button>
                </div>
            {/if}
            <div class="col-sm-2">
                <button type="button"
                        class="btn btn-success btn-sm"
                        onclick="location.href='./contenidos/archivoMcy/plantilla.php'"
                >
                    Plantilla
                </button>
            </div>

            <div class="col-sm-2">
                <button type="button"
                        class="btn btn-danger btn-sm"
                        onclick="location.href='./contenidos/archivoMcy/auditoria.php'"
                >
                    Auditoria
                </button>
            </div>

        </form>
    </div>
</div>

<div id="listadoAadProyectos"></div>




