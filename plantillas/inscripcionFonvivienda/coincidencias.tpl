
<div id="coincidenciasError"></div>

<form id="fnvCoincidencias" onsubmit="return false;">
    <input type="hidden" id="numDocumentoFNV" value="{$numDocumento}">
    <div class="row" style="width: 100%">
        <div class="col-sm-12">
            <table class="table table-hover" data-order='[[ 0, "asc" ]]' id="listadoCdp" width="900px">
                <thead>
                <tr>
                    <th>Distancia</th>
                    <th>Identificadores</th>
                    <th>Ciudadano</th>
                    <th>Partentesco</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                {foreach from=$claInscripcion->arrHogares.$numHogar.ciudadanos key=idCiudadano item=arrCiudadano}
                    {if $arrCiudadano.numDocumento == $numDocumento}
                        {foreach from=$arrCiudadano.coincidencias key=numDistancia item=arrCoincidencias}
                            {foreach from=$arrCoincidencias key=numDocumentoCoincidencia item=arrDatos}
                                <tr {if not in_array($arrDatos.idEstado, $claInscripcion->arrEstadosCoincidencias)} style="background-color: #f5f5f5" {/if}>
                                    <td class="text-center" width="50px;">{$numDistancia}</td>
                                    <td>
                                        CIU: {$arrDatos.ciudadano}<br>
                                        FRM: {$arrDatos.formulario}
                                        <input type="text" id="{$arrDatos.formulario}" value="{$arrDatos.ciudadano}" readonly style="display: none">
                                    </td>
                                    <td>
                                        T.Doc: {$arrDatos.tipoDocumento}<br>
                                        Doc: {$numDocumentoCoincidencia}<br>
                                        Nom: {$arrDatos.nombre}
                                    </td>
                                    <td width="150px;">{$arrDatos.parentesco}</td>
                                    <td width="150px;">{$arrDatos.estado}</td>
                                    <td width="50px;" class="text-center">
                                        <input type="radio"
                                               name="seqFormulario"
                                               value="{$arrDatos.formulario}"
                                                {if not in_array($arrDatos.idEstado, $claInscripcion->arrEstadosCoincidencias)}  {/if}
                                        >
                                    </td>
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