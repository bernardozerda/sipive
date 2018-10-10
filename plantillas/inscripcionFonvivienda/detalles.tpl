
<link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous"
>

{if not empty($claInscripcion->arrErrores.general)}
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {foreach from=$claInscripcion->arrErrores.general item=txtError}
            <li>{$txtError}</li>
        {/foreach}
    </div>
{/if}


<form id="insFNV"
      onsubmit="someterFormulario(
          'contenido',
          this,
          './contenidos/inscripcionFonvivienda/solucionNovedades.php',
          false,
          true
      ); return false;"
>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Identificador del hogar {$numHogar}</h6>
        </div>
        <div class="panel-body">

            <!-- select de estado del hogar -->
            <div class="form-group col-sm-12">
                <label class="control-label col-sm-2 h5" for="seqEstadoHogar">Estado</label>
                <div class="col-sm-4">
                    <select class="form-control input-sm"
                            id="seqEstadoHogar"
                            name="seqEstadoHogar"
                            {if ! isset($smarty.session.arrGrupos.3.20)} disabled {/if}
                            {if $claInscripcion->arrHogares.$numHogar.seqEstadoHogar == 4} disabled {/if}
                    >
                        <option value="0">Seleccione</option>
                        {foreach from=$claInscripcion->estadosHogar() item=arrEstadoHogar}
                            <option value="{$arrEstadoHogar.seqEstadoHogar}"
                                    {if $claInscripcion->arrHogares.$numHogar.seqEstadoHogar == $arrEstadoHogar.seqEstadoHogar}
                                        selected
                                    {/if}
                                    {if $arrEstadoHogar.seqEstadoHogar == 4} disabled {/if}
                            >
                                {$arrEstadoHogar.txtEstadoHogar}
                            </option>
                        {/foreach}
                    </select>
                </div>
            </div>

            <!-- observaciones -->
            <div class="form-group col-sm-12">
                <label class="control-label col-sm-2 h5" for="seqEstadoHogar">Observaciones</label>
                <div class="col-sm-10">
                    <textarea class="form-control input-sm" name="txtObservaciones" {if ! isset($smarty.session.arrGrupos.3.20)} disabled {/if}>{$claInscripcion->arrHogares.$numHogar.txtObservaciones}</textarea>
                </div>
            </div>

            <!-- formulario seleccionado y datos del formulario -->
            <div class="form-group col-sm-12">
                <div class="col-sm-6">
                    <div class="alert alert-warning text-center" style="height: 60px;">

                        {if is_null($claInscripcion->arrHogares.$numHogar.seqFormulario)}
                            <a href="#"
                                    {if $claInscripcion->arrHogares.$numHogar.seqEstadoHogar != 4}
                                        onclick="
                                    $('#seqFormulario').val(0);
                                    $('#numDocumento').val(0);
                                    someterFormulario(
                                        'contenido',
                                        document.getElementById('insFNV'),
                                        './contenidos/inscripcionFonvivienda/detalles.php',
                                        false,
                                        true
                                    );
                                    "
                                    {/if}
                               class="text-primary"
                            >
                                ¿Crear Formulario Nuevo?
                            </a>
                        {elseif intval($claInscripcion->arrHogares.$numHogar.seqFormulario) == 0}
                            Formulario Seleccionado: <br><span class="text-success">Nuevo Formulario</span>
                        {elseif intval($claInscripcion->arrHogares.$numHogar.seqFormulario) != 0}
                            Formulario Seleccionado:
                            <a href="#"
                               class="text-success"
                                onclick="verHogar({$claInscripcion->arrHogares.$numHogar.seqFormulario})"
                            >{$claInscripcion->arrHogares.$numHogar.seqFormulario}</a>
                            <br>
                            <a href="#"
                                    {if $claInscripcion->arrHogares.$numHogar.seqEstadoHogar != 4}
                                        onclick="
                                    $('#seqFormulario').val(0);
                                    $('#numDocumento').val(0);
                                    $('#seqCiudadano').val(0);
                                    someterFormulario(
                                        'contenido',
                                        document.getElementById('insFNV'),
                                        './contenidos/inscripcionFonvivienda/detalles.php',
                                        false,
                                        true
                                    );
                                    "
                                    {/if}
                               class="text-primary"
                            >
                                ¿Es un formulario nuevo?
                            </a>
                        {/if}
                    </div>
                </div>
                <div class="col-sm-6">
                    <strong>Modalidad:</strong> {$claInscripcion->arrHogares.$numHogar.txtModalidad} <br>
                    <strong>Esquema:</strong> {$claInscripcion->arrHogares.$numHogar.txtTipoEsquema} <br>
                    <strong>Rango de Ingresos:</strong> {$claInscripcion->arrHogares.$numHogar.txtRangoIngresos} <br>
                    <strong>Solución:</strong> {$claInscripcion->arrHogares.$numHogar.txtDescripcion} <br>
                    <strong>Dirección Solución:</strong> {$claInscripcion->arrHogares.$numHogar.txtDireccionSolucion}
                </div>
            </div>

            <!-- tabla de ciudadanos y coincidencias -->
            <div class="col-sm-12">

                <table id="listadoAadPry" class="table table-hover" data-order='[[ 0, "asc" ]]' width="100%">
                    <thead>
                    <tr>
                        <th style="display: none;"></th>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Parentesco</th>
                        <th>Acción</th>
                        <th>Ver</th>
                    </tr>
                    </thead>
                    <tbody>

                    <!-----------------------------------------------------------------------------------------------------
                                PRIMERO IMPRIME LAS COINCIDENCIAS QUE SE HAYAN ENCONTRADO POR NUMERO DE DOCUMENTO
                     ------------------------------------------------------------------------------------------------------->

                    {assign var=txtDistancia value='N/A'}
                    {foreach from=$claInscripcion->arrHogares.$numHogar.ciudadanos item=arrCiudadano}
                        {if isset($arrCiudadano.coincidencias.$txtDistancia)}
                            <tr class="alert-info">
                                <td style="display: none;">1</td>
                                <td>
                                    {$arrCiudadano.txtTipoDocumento} <br>
                                    {$arrCiudadano.numDocumento}
                                </td>
                                <td>
                                    {$arrCiudadano.txtNombre1|mb_strtoupper}
                                    {$arrCiudadano.txtNombre2|mb_strtoupper}
                                    {$arrCiudadano.txtApellido1|mb_strtoupper}
                                    {$arrCiudadano.txtApellido2|mb_strtoupper}
                                </td>
                                <td>
                                    {$arrCiudadano.txtParentesco}
                                </td>
                                <td>
                                    {assign var=numDocumentoCoincidencia value=$arrCiudadano.numDocumento}
                                    {if isset($claInscripcion->arrErrores.ciudadano.$numDocumentoCoincidencia)}
                                        <span class="text-danger">{$claInscripcion->arrErrores.ciudadano.$numDocumentoCoincidencia}</span>
                                    {elseif isset($claInscripcion->arrNovedades.$numDocumentoCoincidencia) }
                                        <span class="text-primary">{$claInscripcion->arrNovedades.$numDocumentoCoincidencia}</span>
                                    {else}
                                        <span class="text-primary">Ninguna</span>
                                    {/if}
                                    {if intval($arrCiudadano.seqCiudadanoCoincidencia) != 0}
                                        <br><span class="text-primary">Ciudadano Asociado: {$arrCiudadano.seqCiudadanoCoincidencia}</span>
                                    {/if}
                                </td>
                                <td>
                                    <a href="#" onclick="
                                            verCoincidencias(
                                                {$seqCargue},
                                                {$numHogar},
                                                {$arrCiudadano.numDocumento},
                                                '{$arrCiudadano.txtNombre1|mb_strtoupper} {$arrCiudadano.txtNombre2|mb_strtoupper} {$arrCiudadano.txtApellido1|mb_strtoupper} {$arrCiudadano.txtApellido2|mb_strtoupper}'
                                            );">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                    </a>
                                </td>
                            </tr>
                        {/if}
                    {/foreach}

                    <!-----------------------------------------------------------------------------------------------------
                                AHORA IMPRIME LOS REGISTROS QUE TIENEN COINCIDENCIAS POR NOMBRE
                    ------------------------------------------------------------------------------------------------------->

                    {foreach from=$claInscripcion->arrHogares.$numHogar.ciudadanos item=arrCiudadano}
                        {if not isset($arrCiudadano.coincidencias.$txtDistancia)}
                            <tr>
                                <td style="display: none;">2</td>
                                <td>
                                    {$arrCiudadano.txtTipoDocumento} <br>
                                    {$arrCiudadano.numDocumento}
                                </td>
                                <td>
                                    {$arrCiudadano.txtNombre1|mb_strtoupper}
                                    {$arrCiudadano.txtNombre2|mb_strtoupper}
                                    {$arrCiudadano.txtApellido1|mb_strtoupper}
                                    {$arrCiudadano.txtApellido2|mb_strtoupper}
                                </td>
                                <td>
                                    {$arrCiudadano.txtParentesco}
                                </td>
                                <td>
                                    {assign var=numDocumentoCoincidencia value=$arrCiudadano.numDocumento}
                                    {if isset($claInscripcion->arrErrores.ciudadano.$numDocumentoCoincidencia)}
                                        <span class="text-danger">{$claInscripcion->arrErrores.ciudadano.$numDocumentoCoincidencia}</span>
                                    {elseif isset($claInscripcion->arrNovedades.$numDocumentoCoincidencia) }
                                        <span class="text-primary">{$claInscripcion->arrNovedades.$numDocumentoCoincidencia}</span>
                                    {else}
                                        Ninguna
                                    {/if}
                                    {if intval($arrCiudadano.seqCiudadanoCoincidencia) != 0}
                                        <br><span class="text-primary">Ciudadano Asociado: {$arrCiudadano.seqCiudadanoCoincidencia}</span>
                                    {/if}
                                </td>
                                <td>
                                    <a href="#" onclick="
                                            verCoincidencias(
                                                {$seqCargue},
                                                {$numHogar},
                                                {$arrCiudadano.numDocumento},
                                                '{$arrCiudadano.txtNombre1|mb_strtoupper} {$arrCiudadano.txtNombre2|mb_strtoupper} {$arrCiudadano.txtApellido1|mb_strtoupper} {$arrCiudadano.txtApellido2|mb_strtoupper}'
                                            );">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                    </a>
                                </td>
                            </tr>
                        {/if}
                    {/foreach}

                    </tbody>
                </table>
            </div>

        </div>
        <div class="panel-footer text-center">
            <div class="row text-center">
                <div class="col-sm-offset-3 col-sm-4 text-center">
                    <button type="button"
                            class="btn btn-default btn-sm"
                            onclick="cargarContenido('contenido','./contenidos/inscripcionFonvivienda/informacion.php','seqCargue={$claInscripcion->seqCargue}',true);"
                    >
                        Volver
                    </button>
                </div>

                <div class="col-sm-4 text-center">
                    {if isset($smarty.session.arrGrupos.3.20)}
                        {if $arrEstadoHogar.seqEstadoHogar != 4}
                            <button type="submit"
                                    class="btn btn-primary btn-sm {if $claInscripcion->arrHogares.$numHogar.seqEstadoHogar == 4} disabled {/if}"
                                    {if $claInscripcion->arrHogares.$numHogar.seqEstadoHogar == 4} disabled {/if}
                            >
                                Guardar Cambios
                            </button>
                        {/if}
                    {/if}
                </div>

            </div>
        </div>
    </div>

    <input type="hidden" name="seqCargue"     value="{$seqCargue}">
    <input type="hidden" name="numHogar"      value="{$numHogar}">
    <input type="hidden" name="numDocumento"  value="{$numDocumento}" id="numDocumento">
    <input type="hidden" name="seqCiudadano"  value="{$seqCiudadano}" id="seqCiudadano">
    <input type="hidden" name="seqFormulario" value="{$claInscripcion->arrHogares.$numHogar.seqFormulario|intval}" id="seqFormulario">

    {*Cargue <input type="text" name="seqCargue"         value="{$seqCargue}"><br>*}
    {*Hogar <input type="text" name="numHogar"           value="{$numHogar}"><br>*}
    {*Documento <input type="text" name="numDocumento"   value="{$numDocumento}" id="numDocumento"><br>*}
    {*Ciudadano <input type="text" name="seqCiudadano"   value="{$seqCiudadano}" id="seqCiudadano"><br>*}
    {*Formulario <input type="text" name="seqFormulario" value="{$claInscripcion->arrHogares.$numHogar.seqFormulario|intval}" id="seqFormulario">*}

</form>

<div id="listadoAadProyectos"></div>
<div id="verCoindidencias"></div>
<div id="verHogar"></div>