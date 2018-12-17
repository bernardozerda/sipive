&nbsp;
<link rel="stylesheet"
href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
crossorigin="anonymous"
>

{if not empty($arrErrores)}
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {foreach from=$arrErrores item=txtError}
            <li class="h5">{$txtError}</li>
        {/foreach}
    </div>
{/if}

<form class="form-horizontal" onsubmit="someterFormulario('contenido',this,'./contenidos/eliminarFormulario/eliminar.php',true,true); return false;">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Eliminar formulario</h6>
        </div>
        <div class="panel-body">

            {assign var=seqEstadoProceso value=$claFormulario->seqEstadoProceso}
            {assign var=seqModalidad value=$claFormulario->seqModalidad}
            {assign var=seqTipoEsquema value=$claFormulario->seqTipoEsquema}
            {assign var=seqSolucion value=$claFormulario->seqSolucion}
            {assign var=seqCiudad value=$claFormulario->seqCiudad}
            {assign var=seqLocalidad value=$claFormulario->seqLocalidad}
            {assign var=seqBarrio value=$claFormulario->seqBarrio}

            <table class="table table-striped" width="100%">
                <thead>
                    <tr>
                        <th colspan="6">
                            <h5><strong>Datos del formulario</strong></h5>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="100px"><strong>Identificador</strong></td>
                        <td>{$claFormulario->seqFormulario}</td>
                        <td width="100px"><strong>Estado</strong></td>
                        <td colspan="3">{$arrEstados.$seqEstadoProceso}</td>
                    </tr>
                    <tr>
                        <td><strong>Modalidad</strong></td>
                        <td>{$arrModalidad.$seqModalidad}</td>
                        <td><strong>Esquema</strong></td>
                        <td>{$arrTipoEsquema.$seqTipoEsquema}</td>
                        <td><strong>Solución</strong></td>
                        <td>{$arrSolucion.$seqSolucion}</td>
                    </tr>
                    <tr>
                        <td><strong>Ciudad</strong></td>
                        <td>{$arrCiudad.$seqCiudad}</td>
                        <td><strong>Localidad</strong></td>
                        <td>{$arrLocalidad.$seqLocalidad}</td>
                        <td><strong>Barrio</strong></td>
                        <td>{$arrBarrio.$seqBarrio}</td>
                    </tr>
                    <tr>
                        <td><strong>Dirección</strong></td>
                        <td>{$claFormulario->txtDireccion}</td>
                        <td><strong>Telefonos</strong></td>
                        <td>{$claFormulario->numTelefono1} ó {$claFormulario->numTelefono2}</td>
                        <td><strong>Celular</strong></td>
                        <td>{$claFormulario->numCelular}</td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-striped" width="100%">
                <thead>
                <tr>
                    <th colspan="6">
                        <h5>
                            <strong>
                                Datos del hogar
                            </strong>
                        </h5>
                    </th>
                </tr>
                <tr>
                    <th>Identificador</th>
                    <th>Tipo de Documento</th>
                    <th>Documento</th>
                    <th>Nombre</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Parentesco</th>
                </tr>
                </thead>
                <tbody>
                    {foreach from=$claFormulario->arrCiudadano key=seqCiudadano item=objCiudadano}
                        {assign var=seqParentesco value=$objCiudadano->seqParentesco}
                        {assign var=seqTipoDocumento value=$objCiudadano->seqTipoDocumento}
                        <tr>
                            <td>{$objCiudadano->seqCiudadano}</td>
                            <td>{$arrTipoDocumento.$seqTipoDocumento}</td>
                            <td>{$objCiudadano->numDocumento|number_format:0:'.':','}</td>
                            <td>{$objCiudadano->obtenerNombre($objCiudadano->numDocumento)}</td>
                            <td>{$objCiudadano->fchNacimiento}</td>
                            <td>{$arrParentesco.$seqParentesco}</td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>

            <div class="form-group">
                <label for="txtComentario" class="col-sm-2">Comentario</label>
                <div class="col-sm-9">
                    <textarea class="form-control input-sm"
                              id="txtComentario"
                              name="txtComentario"
                              required
                    ></textarea>
                </div>
            </div>

            {if $arrEtapa.$seqEstadoProceso != 1}
                <div class="form-group text-center">
                    <div class="text-danger">
                        <h5>El formulario no se puede eliminar porque no está en la etapa de Inscripción</h5>
                    </div>
                </div>
            {/if}

        </div>
        <div class="panel-footer text-center">

            <button type="button"
                    class="btn btn-default btn-sm"
                    onclick="cargarContenido('contenido','./contenidos/eliminarFormulario/buscar.php')"
            >Volver</button>

            <button type="submit"
                    class="btn btn-danger btn-sm {if $arrEtapa.$seqEstadoProceso != 1} disabled {/if}"
                    {if $arrEtapa.$seqEstadoProceso != 1} disabled {/if}
            >Eliminar Hogar</button>
        </div>
    </div>

    <input type="hidden" name="seqFormulario" value="{$claFormulario->seqFormulario}">
    <input type="hidden" name="seqTipoDocumento" value="{$arrPost.seqTipoDocumento}">
    <input type="hidden" name="numDocumento" value="{$arrPost.numDocumento}">

</form>