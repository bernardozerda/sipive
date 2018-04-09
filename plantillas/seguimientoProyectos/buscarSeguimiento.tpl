{if $arrRegistros|@count != 0 }

    <div class="form-group">
        <table cellpadding="1" cellspacing="1" width="100%" border="0">
            {assign var="num" value="0"}
            {counter start=0 print=false assign=num}
            {foreach from=$arrRegistros key=seqRegistro item=arrInformacion}
                {if $num++%2 == 0} <tr class="fila_0">
                {else} <tr class="fila_1">
                    {/if}
                    <td>
                        <div class="col-md-10">
                            <label class="control-label" for="nome"<b>Registro No:</b> {$seqRegistro|number_format:'0':'.':','}&nbsp;</label>
                            {if $arrInformacion.txtCambios != ""}
                                <a href="#" onClick="verCambiosFormularioProyectos('{$arrInformacion.seqProyecto}', '{$seqRegistro}');">Detalles</a>
                            {/if}
                        </div>
                        <div class="col-md-6" >
                            <label class="control-label" for="nome"<b>Fecha del Registro:</b> {$arrInformacion.fchMovimiento} <br>
                                <b>Grupo Gestión:</b> {$arrInformacion.txtGrupoGestion}<br>
                                <b>Seguimiento:</b> {$arrInformacion.txtGestion}<br>
                                <b>Atendido por:</b> {$arrInformacion.txtUsuario}<br></label>                
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="nome">{$arrInformacion.txtComentario}</label>

                        </div>
                    </td>
                </tr>
            {/foreach}
        </table>
    </div>
{else}
    <table cellpadding="0" cellspacing="0" border="0" width="100%" id="tablaMensajes" style="padding:5px">
        <tr><td class="msgError"><li>No hay seguimientos registrados para este proyecto</li></td></tr>
</table>
{/if}