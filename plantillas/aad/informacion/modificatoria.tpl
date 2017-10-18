<table cellspacing="0" cellpadding="3" border="0" width="100%">
    <tr>
        <td class="tituloTabla" width="150px">
            Hogares relacionados
        </td>
        <td>
            <input type="file" name="archivo" id="archivo">
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="3" border="0" width="100%">
    <tr>
        <td class="tituloTabla" width="150px">
            Resolución modificada
        </td>
        <td>
            Numero
            <input type="number"
                   name="numActoRelacionado"
                   id="numActoRelacionado"
                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                   value="{$claActoAdministrativo->arrCaracteristicas.numActoRelacionado}"
                   style="width: 50px;"
            >
            &nbsp;
            Fecha
            <input type="text"
                   name="fchActoRelacionado"
                   id="fchActoRelacionado"
                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                   value="{$claActoAdministrativo->arrCaracteristicas.fchActoRelacionado}"
                   style="width: 80px;"
                   readonly
            >
            <a href="#" onClick="calendarioPopUp('fchActoRelacionado')">Calendario</a>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="10" border="0" width="100%">
    <tr>
        <td align="center">
            <button style="width:100px; height:40px;" type="button" onclick="plantillaProyectos();">
                <span style="font-size: 10px; font-weight: bold;">Guia de proyectos<br>y unidades</span>
            </button>
        </td>
    </tr>
</table>