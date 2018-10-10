
<table class="table table-hover" data-order='[[ 0, "asc" ]]' id="listadoCdp" width="900px">
    <thead>
        <tr>
            <th>Identificador</th>
            <th>Tipo de Documento</th>
            <th>Documento</th>
            <th>Nombre</th>
            <th>Parentesco</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$claFormulario->arrCiudadano key=seqCiudadano item=objCiudadano}

            {assign var=seqTipoDocumento value=$objCiudadano->seqTipoDocumento}
            {assign var=seqParentesco value=$objCiudadano->seqParentesco}

            <tr>
                <td class="text-center">{$seqCiudadano}</td>
                <td>{$arrTipoDocumento.$seqTipoDocumento}</td>
                <td class="text-right">{$objCiudadano->numDocumento}</td>
                <td class="text-uppercase">{$objCiudadano->txtNombre1} {$objCiudadano->txtNombre2} {$objCiudadano->txtApellido1} {$objCiudadano->txtApellido2}</td>
                <td>{$arrParentesco.$seqParentesco}</td>
            </tr>
        {/foreach}
    </tbody>
</table>

<div id="listadoCdpListener"></div>