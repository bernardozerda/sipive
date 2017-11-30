
<!-- TABLA DE FILTROS -->
<form id="frmFiltros" onSubmit="return false;">
<table cellpadding="5" cellspacing="0" border="0" width="100%">
        <tr>
            <td class="tituloTabla" height="20px" colspan="2">FILTROS</td>
        </tr>
        <tr>
            <td valign="top" height="20px" colspan="2">
                <select name="seqTipoActo"
                        onFocus="this.style.backgroundColor = '#ADD8E6';"
                        onBlur="this.style.backgroundColor = '#FFFFFF';"
                        style="width: 100%;"
                >
                    <option value="0">Todos los Actos</option>
                    {foreach from=$arrTipoActo key=seqTipoActo item=objTipoActo}
                        <option value="{$seqTipoActo}">{$objTipoActo->txtTipoActo}</option>
                    {/foreach}
                </select>
            </td>
        </tr>
        <tr>
            <td height="20px">
                <label for="numActo"><strong>Resolución</strong></label>
            </td>
            <td>
                <input type="number"
                       name="numActo"
                       id="numActo"
                       onFocus="this.style.backgroundColor = '#ADD8E6'"
                       onBlur="this.style.backgroundColor = '#FFFFFF';"
                       style="width: 100px;"
                >
            </td>
        </tr>
        <tr>
            <td height="20px">
                <label for="numActo"><strong>Documentos</strong></label>
            </td>
            <td onMouseOver="mostrarTooltip(this , 'Cargue un archivo plano separado por tabulaciones, sin titulos, y con los numeros de documentos')">
                <input type="file"
                       name="cedulas"
                       style="width: 220px;"
                       placeholder="Documentos"
                >
            </td>
        </tr>
        <tr>
            <td colspan="2" height="20px" align="center">
                <input type="button"
                       style="width: 80px;"
                       placeholder="Filtrar"
                       value="Filtrar"
                       onClick="someterFormulario( 'listado' , this.form , 'contenidos/aad/listado.php', true , true );"
                > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="reset"
                       style="width: 80px;"
                       placeholder="Limpiar"
                       value="Limpiar"
                >
            </td>
        </tr>

</table>

<!-- TALBA PARA EL LISTADO DE ACTOS ADMINISTRATIVOS -->
<table cellpadding="5" cellspacing="0" border="0" width="100%" height="300px">
    <tr>
        <td class="tituloTabla" height="20px" colspan="2">LISTADO</td>
    </tr>
    <tr>
        <td valign="top" height="270px">
            <div style="overflow: auto; height: 270px;" id="listado">
                {include file="aad/listado.tpl"}
            </div>
        </td>
    </tr>
</table>
</form>