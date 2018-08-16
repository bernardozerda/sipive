
<div id="coincidenciasError"></div>

<form id="fnvCoincidencias" onsubmit="return false;">
    <input type="hidden" id="numDocumentoFNV" value="{$numDocumento}">
    <div class="row" style="width: 100%">
        <div class="col-sm-12">
            <table class="table table-hover" data-order='[[ 1, "asc" ]]' id="listadoCdp" width="780px">
                <thead>
                    <tr>
                        <th></th>
                        <th>Distancia</th>
                        <th style="display: none;">Ciudadano</th>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Formulario</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>

                    {foreach from=$claInscripcion->arrHogares.$numHogar.ciudadanos key=idCiudadano item=arrCiudadano}
                        {if $arrCiudadano.numDocumento == $numDocumento}
                            {foreach from=$arrCiudadano.coincidencias key=numDistancia item=arrCoincidencias}
                                {foreach from=$arrCoincidencias key=numDocumentoCoincidencia item=arrDatos}
                                    <tr {if not in_array($arrDatos.idEstado, $claInscripcion->arrEstadosCoincidencias)} style="background-color: #f5f5f5" {/if}>
                                        <td>
                                            <input type="radio"
                                                   name="seqFormulario"
                                                   value="{$arrDatos.formulario}"
                                                   {if not in_array($arrDatos.idEstado, $claInscripcion->arrEstadosCoincidencias)} disabled {/if}
                                            >
                                        </td>
                                        <td>{$numDistancia}</td>
                                        <td style="display: none"><input type="text" id="{$arrDatos.formulario}" value="{$arrDatos.ciudadano}" readonly></td>
                                        <td class="text-right">{$numDocumentoCoincidencia|number_format:0:',':'.'}</td>
                                        <td>{$arrDatos.nombre}</td>
                                        <td>{$arrDatos.formulario}</td>
                                        <td>{$arrDatos.estado}</td>
                                    </tr>
                                {/foreach}
                            {/foreach}
                        {/if}
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</form>
<div id="listadoCdpListener"></div>