
    {if empty( $arrErrores )}
        {if $seqEtapa < 4 && ( $claFormulario->seqEstadoProceso == 7 || $claFormulario->seqEstadoProceso == 38)}
            <div style="width: 80%; text-align: center; padding-top: 5px; padding-left: 20px;">
                <h2>Resultados para la Consulta del Documento {$numDocumento|number_format}</h2>
            </div>

            <fieldset style="border: 1px dotted #666666; text-align: left; padding:20px;">
                <legend style="font-size: 150%;">Composici&oacute;n Familiar</legend>
                <table border=0 width="100%">
                    {foreach from=$claFormulario->arrCiudadano key=seqCiudadano item=objCiudadano}
                        <tr style="font-size: 120%">
                            {assign var=seqTipoDocumento value=$objCiudadano->seqTipoDocumento}
                            {assign var=seqParentesco   value=$objCiudadano->seqParentesco}
                            <td>
                                {$objCiudadano->txtNombre1} {$objCiudadano->txtNombre2} {$objCiudadano->txtApellido1} {$objCiudadano->txtApellido2}
                            </td>
                            <td>
                                {$arrTipoDocumento.$seqTipoDocumento} {$objCiudadano->numDocumento|number_format}
                            </td>
                            <td>
                                {$arrParentesco.$seqParentesco}
                            </td>
                        </tr>
                    {/foreach}    
                </table>
            </fieldset>

            <fieldset style="border: 1px dotted #666666; text-align: left; padding:20px;">
                <legend style="font-size: 150%;">Datos de Inscripci&oacute;n</legend>
                {assign var=seqTipoEsquema value=$claFormulario->seqTipoEsquema}
                {assign var=seqModalidad   value=$claFormulario->seqModalidad}
                {assign var=seqProyecto    value=$claFormulario->seqProyecto}
                {if $claFormulario->seqPlanGobierno == 2}
                    Esquema: {if $seqTipoEsquema == 0} Postulaci&oacute;n Individual {else} {$arrEsquema.$seqTipoEsquema} {/if}<br>
                {/if}
                Modalidad: {if $seqModalidad == 0} Ninguna {else} {$arrModalidad.$seqModalidad} {/if}<br>
                Proyecto: 
                {if $seqProyecto == 0} 
                    Ninguno 
                {else} 
                    {if not isset($arrProyecto.$seqProyecto)}
                        {$arrProyecto.$seqProyecto} 
                    {else} 
                        {$arrProyectoBp.$seqProyecto}
                    {/if}
                {/if}
            </fieldset>
        {else}
            <div class="msgError">
                <h2>No se puede mostrar la informaci&oacute;n relacionada con el hogar {$numDocumento|number_format}</h2>
            </div>
        {/if}
    {else}
        <div class="msgError">
            {foreach from=$arrErrores item=txtMensaje}
                <h2>{$txtMensaje}</h2>
            {/foreach}
        </div>
    {/if}