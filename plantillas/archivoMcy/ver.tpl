&nbsp;
<link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous"
>

{if not empty($arrErrores.general)}
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {foreach from=$arrErrores.general item=txtError}
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

<form onsubmit="someterFormulario('contenido',this,'./contenidos/archivoMcy/editar.php',true,true); return false;">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Archivo MCY</h6>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Reportar</th>
                    <th>Detalle</th>
                </tr>
                </thead>
                {foreach from=$arrLineas item=arrDatos}
                    <tr>
                        <td class="col-sm-5">
                            <strong>Entidad:</strong> [ {$arrDatos.numNIT} ] {$arrDatos.txtEntidad} <br>
                            <strong>Documento:</strong> {$arrDatos.txtTipoDocumento} {$arrDatos.numDocumento} <br>
                            <strong>Nombre:</strong> {$arrDatos.txtNombre} <br>
                            <strong>Fecha:</strong> {$arrDatos.fchAsignacion} <br>
                            <strong>Valor:</strong> {$arrDatos.valAsignado} <br>
                            <strong>Justificación:</strong> {$arrDatos.txtJustificacion}
                        </td>
                        <td>
                            <select name="datos[{$arrDatos.seqArchivoMcy}][bolReportarLinea]"
                                    id="bolReportarLinea"
                                    class="form-control input-sm col-sm-1"
                            >
                                <option value="1" {if $arrDatos.bolReportarLinea != 0} selected {/if}>SI</option>
                                <option value="0" {if $arrDatos.bolReportarLinea == 0} selected {/if}>NO</option>
                            </select>
                        </td>
                        <td>
                            {assign var=seqArchivoMcy value=$arrDatos.seqArchivoMcy}
                            <div class="form-group {if isset($arrErrores.input.$seqArchivoMcy)} has-error {/if} ">
                                <textarea class="form-control input-sm"
                                          name="datos[{$arrDatos.seqArchivoMcy}][txtExclusion]"
                                          rows="4"
                                >{$arrDatos.txtExclusion}</textarea>
                                {if isset($arrErrores.input.$seqArchivoMcy)} <span class="text-danger">{$arrErrores.input.$seqArchivoMcy}</span> {/if}
                            </div>
                        </td>
                    </tr>
                {/foreach}
            </table>
        </div>
        <div class="panel-footer text-center" style="height: 55px;">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-3">
                    <button type="button"
                            class="btn btn-default btn-sm"
                            onclick="cargarContenido('contenido','./contenidos/archivoMcy/archivoMcy.php','',true);"
                    >Volver</button>
                </div>
                <div class="col-sm-3">
                    <button type="submit"
                            class="btn btn-primary btn-sm"
                    >Editar</button>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="seqTipoDocumento" value="{$seqTipoDocumento}">
    <input type="hidden" name="numDocumento" value="{$numDocumento}">

</form>