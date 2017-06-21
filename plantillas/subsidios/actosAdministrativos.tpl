<div style="height: 400px; overflow: auto; padding: 0px;" >
    {assign var=txtEstilo value="style='padding:3px;'"}

    <ul>
        {foreach from=$arrActos item=arrActo}
            <li>

                <strong>{$arrActo.acto.nombre}</strong>
                {$arrActo.acto.numero} del {$arrActo.acto.fecha}



                {if $esCoordinador == 1}
                    <strong>Estado:</strong>
                    {$arrActo.acto.seqEstadoProceso}
                {/if}



                <!-- /****************************************************************************************************/
                // Cambios Generados por Ing Liliana Basto
                // Inserción de icono para Actualizar Acto Administrativos
                    /****************************************************************************************************/-->
                {if $esCoordinador == 1}
                    <button type="button" value="Actualizar Acto" style="width:50px; position: relative; float: left; margin-right: 3%" onclick="modificarActo('actosAdministrativos/modificarActo',{$seqFormulario},{$arrActo.acto.seqformActo});">
                        <img src="./recursos/imagenes/modify.png" width="16px" height="16px">
                        <span style="font-size: 8px; font-weight: bold;">Actualizar <br>Acto</span>
                    </button>
                {/if}
                <ul>
                    <li {$txtEstilo}>Fecha de Notificaci&oacute;n: {$arrActo.notificado}</li>
                        {if $arrActo.acto.tipo == 1}
                        <li {$txtEstilo}>Valor de los giros realizados: $ {$arrActo.acto.giros|number_format}</li>
                        {elseif $arrActo.acto.tipo == 2}
                        <li {$txtEstilo}>
                            Modificaciones realizadass:
                            <ul>
                                {foreach from=$arrActo.modificaciones item=arrModificacion}
                                    <li {$txtEstilo}>{$arrModificacion.txtCampo}: Se cambió {$arrModificacion.txtIncorrecto} por {$arrModificacion.txtCorrecto}</li>
                                    {/foreach}
                            </ul>
                        </li>
                    {elseif $arrActo.acto.tipo == 3}
                        <li {$txtEstilo}>
                            {foreach from=$arrActo.acto.inhabilidades key=numDocumento item=arrDocumentos}
                                Inhabilidades encontradas para {$arrDocumentos.txtNombre}:
                                <ul>
                                    {foreach from=$arrDocumentos.arrListado item=arrInhabilidad}
                                        <li {$txtEstilo}>{$arrInhabilidad.txtFuente}: {$arrInhabilidad.txtCausa}</li>
                                        {/foreach}
                                </ul>
                            {/foreach}
                        </li>
                    {elseif $arrActo.acto.tipo == 4}
                        <li {$txtEstilo}>Interpuesto contra la resoluci&oacute;n: {$arrActo.acto.numeroReferencia} del {$arrActo.acto.fechaReferencia}</li>
                        <li {$txtEstilo}>Resultado del Recurso de Reposici&oacute;n: {$arrActo.acto.resultado}</li>
                        {elseif $arrActo.acto.tipo == 5}
                        {elseif $arrActo.acto.tipo == 6}
                        <li {$txtEstilo}>Renunci&oacute; a la Resoluci&oacute;n: {$arrActo.acto.numeroReferencia} del {$arrActo.acto.fechaReferencia}</li>
                        {elseif $arrActo.acto.tipo == 8}
                        <li {$txtEstilo}>Valor de la indexación: ${$arrActo.acto.indexacion|number_format}</li>
                        <li {$txtEstilo}>N&uacute;mero resoluci&oacute;n referencia: {$arrActo.acto.numeroReferencia|number_format}</li>
                        <li {$txtEstilo}>Fecha resoluci&oacute;n referencia: {$arrActo.acto.fechaReferencia}</li>

                    {/if}

                    {foreach from=$arrActo.relacionado item=arrRelacionado}
                        <li {$txtEstilo}><strong>{$arrRelacionado.nombre}</strong> {$arrRelacionado.numero} del {$arrRelacionado.fecha}</li>
                        <ul>
                            <li {$txtEstilo}>Fecha de Notificaci&oacute;n: {$arrRelacionado.notificado}</li>
                                {if $arrRelacionado.tipo == 1}
                                <li {$txtEstilo}>Valor de los giros realizados: $ {$arrRelacionado.acto.giros|number_format}</li>
                                {elseif $arrRelacionado.tipo == 2}
                                <li {$txtEstilo}>
                                    Modificaciones realizadas:
                                    <ul>
                                        {foreach from=$arrRelacionado.modificaciones item=arrModificacion}
                                            <li {$txtEstilo}>{$arrModificacion.txtCampo}: Se cambió {$arrModificacion.txtIncorrecto} por {$arrModificacion.txtCorrecto}</li>
                                            {/foreach}
                                    </ul>
                                </li>
                            {elseif $arrRelacionado.tipo == 3}
                                <li {$txtEstilo}>
                                    {foreach from=$arrRelacionado.acto.inhabilidades key=numDocumento item=arrDocumentos}
                                        Inhabilidades encontradas para {$arrDocumentos.txtNombre}:
                                        <ul>
                                            {foreach from=$arrDocumentos.arrListado item=arrInhabilidad}
                                                <li {$txtEstilo}>{$arrInhabilidad.txtFuente}: {$arrInhabilidad.txtCausa}</li>
                                                {/foreach}
                                        </ul>
                                    {/foreach}
                                </li>
                            {elseif $arrRelacionado.tipo == 4}
                                <li {$txtEstilo}>{$arrRelacionado.resultado}</li>
                                {elseif $arrRelacionado.tipo == 5}
                                {elseif $arrRelacionado.tipo == 6}
                                {elseif $arrRelacionado.tipo == 8}
                                <li {$txtEstilo}>Valor de la indexación: ${$arrRelacionado.indexacion|number_format}</li>
                                {/if}
                        </ul>
                    {/foreach}
                </ul>
            </li>
        {/foreach}
    </ul>
    {include file='subsidios/actosUnidades.tpl'}
</div>









<!-- 
{if $txtActosAdministrativosJs != ""}
        <div id="treeDivArbolMostrar"></div>
        <div id="objArbolActosAdministrativos" style="display:none" >{$txtActosAdministrativosJs}</div>
{/if}
-->