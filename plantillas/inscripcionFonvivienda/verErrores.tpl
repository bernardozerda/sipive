
<table class="table table-striped" id="tablaErroresFNV" data-order='[[ 0, "asc" ]]'>
    <thead>
        <tr>
            <th>Mensajes</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$arrErrores item=txtMensaje}
            <tr>
                <td width="850px;">{$txtMensaje}</td>
            </tr>
        {/foreach}
    </tbody>
</table>

<div id="listadoErroresFNV"></div>

