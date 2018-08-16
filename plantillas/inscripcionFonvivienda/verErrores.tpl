
<table class="table table-striped" id="tablaErroresFNV" width="800px;">
    <thead>
        <tr>
            <th width="800px">Mensajes</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$arrErrores item=txtMensaje}
            <tr>
                <td width="800px">{$txtMensaje}</td>
            </tr>
        {/foreach}
    </tbody>
</table>

<div id="listadoErroresFNV"></div>

