
<!-- INFORMACION DEL CONTENIDO DE LAS RESOLUCIONES -->
<form id="frmSavarAAD" onSubmit="return false;">
    <table cellspacing="0" cellpadding="5" border="0" width="100%" height="490px">
        <tr>
            <td align="left" class="tituloTabla" height="20px" colspan="3">
                INFORMACION DEL ACTO ADMINSITRATIVO
            </td>
        </tr>
        <tr>
            <td height="20px" width="70px">
                <label for="numActo"><strong>Tipo de acto</strong></label>
            </td>
            <td>
                <select name="seqTipoActo"
                        id="seqTipoActo"
                        onFocus="this.style.backgroundColor = '#ADD8E6';"
                        onBlur="this.style.backgroundColor = '#FFFFFF';"
                        onchange="cargarContenido('informacion','./contenidos/aad/informacion.php','seqTipoActo='+this.options[this.selectedIndex].value,true)"
                        style="width: 300px;"
                >
                    {foreach from=$arrTipoActo key=seqTipoActo item=claTipoActo}
                        <option value="{$seqTipoActo}" {if $arrPost.seqTipoActo == $seqTipoActo} selected {/if}>
                            {$claTipoActo->txtTipoActo}
                        </option>
                    {/foreach}
                </select>
            </td>
            <td>
                <a href="#" onClick="location.href = 'contenidos/aad/plantilla.php?seqTipoActo='+YAHOO.util.Dom.get('seqTipoActo').options[ YAHOO.util.Dom.get('seqTipoActo').selectedIndex ].value">Descargue la plantilla</a>
            </td>
        </tr>
        <tr>
            <td height="20px">
                <label for="numActo"><strong>Número</strong></label>
            </td>
            <td>
                <input type="number"
                       name="numActo"
                       id="numActo"
                       onFocus="this.style.backgroundColor = '#ADD8E6';"
                       onBlur="this.style.backgroundColor = '#FFFFFF';"
                       value="{$claActoAdministrativo->numActo}"
                       style="width: 50px;"
                >
            </td>
            <td></td>
        </tr>
        <tr>
            <td height="20px">
                <label for="numActo"><strong>Fecha</strong></label>
            </td>
            <td>
                <input type="text"
                       name="fchActo"
                       id="fchActo"
                       onFocus="calendarioPopUp('fchActo');"
                       onBlur="this.style.backgroundColor = '#FFFFFF';"
                       value="{$claActoAdministrativo->fchActo}"
                       style="width: 80px;"
                       readonly
                >
            </td>
            <td></td>
        </tr>
        <tr>
            <td height="70px" valign="top">
                <label for="numActo"><strong>Texto</strong></label>
            </td>
            <td>
                <textarea
                        name="txtResolucion"
                        id="txtResolucion"
                        onFocus="this.style.backgroundColor = '#ADD8E6';"
                        onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales(this);"
                        style="width: 100%; height: 100%"
                >{$claActoAdministrativo->arrCaracteristicas.txtResolucion}</textarea>
            </td>
            <td>
                <button style="width:60px; height:40px;" type="button" onclick="someterFormulario('mensajes',this.form,'contenidos/aad/salvar.php',true,true);">
                    <img src="recursos/imagenes/salvar.png" width="20px;" height="20px;"><br>
                    <span style="font-size: 10px; font-weight: bold;">Guardar</span>
                </button>

                <button style="width:60px; height:40px;" type="button" onclick="this.form.reset()">
                    <img src="recursos/imagenes/remove.png" width="20px;" height="20px;"><br>
                    <span style="font-size: 10px; font-weight: bold;">Cancelar</span>
                </button>
            </td>
        </tr>
        <tr>
            <td colspan="3" valign="top">
                <div id="tabActoAdministrativo" class="yui-navset" style="visibility:visible">
                    <ul class="yui-nav">
                        <li class="selected">
                            <a href="#tab1">
                                <em>Informaci&oacute;n</em>
                            </a>
                        </li>
                        <li>
                            <a href="#tab2">
                                <em>Detalles</em>
                            </a>
                        </li>
                    </ul>
                    <div class="yui-content">
                        <div id="tab1" style="height:300px; overflow: scroll;">
                            {if intval($arrPost.seqTipoActo) == 1}
                                {include file="aad/informacion/asignacion.tpl"}
                            {elseif intval($arrPost.seqTipoActo) == 2 }
                                {include file="aad/informacion/modificatoria.tpl"}
                            {elseif intval($arrPost.seqTipoActo) == 3 }
                                {include file="aad/informacion/inhabilitados.tpl"}
                            {elseif intval($arrPost.seqTipoActo) == 4 }
                                {include file="aad/informacion/reposicion.tpl"}
                            {elseif intval($arrPost.seqTipoActo) == 5 }
                                {include file="aad/informacion/noAsignado.tpl"}
                            {elseif intval($arrPost.seqTipoActo) == 6 }
                                {include file="aad/informacion/renuncia.tpl"}
                            {elseif intval($arrPost.seqTipoActo) == 7 }
                                {include file="aad/informacion/notificaciones.tpl"}
                            {elseif intval($arrPost.seqTipoActo) == 8 }
                                {include file="aad/informacion/indexacion.tpl"}
                            {elseif intval($arrPost.seqTipoActo) == 9 }
                                {include file="aad/informacion/perdida.tpl"}
                            {elseif intval($arrPost.seqTipoActo) == 10}
                                {include file="aad/informacion/revocatoria.tpl"}
                            {elseif intval($arrPost.seqTipoActo) == 11}
                                {include file="aad/informacion/exclusion.tpl"}
                            {else}
                                {include file="aad/informacion/asignacion.tpl"}
                            {/if}
                        </div>
                        <div id="tab2" style="width:551px; height:300px; overflow: scroll;">
                            {include file="aad/detalles.tpl"}
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</form>
<div id="listenerTabActoAdministrativo">AQUI</div>