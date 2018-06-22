<center>
    <form enctype="multipart/form-data" method="POST" id="frmCalificacionHogares"><table cellpadding="2" cellspacing="0" border="0" width="50%">
            <tr><td colspan="2" bgcolor="#E4E4E4" class="tituloTabla" align="center" width="250px">Carga de documentos a calificar</td></tr>
            <tr><td><b>Seleccione el archivo:</b><br>En el archivo plano debe ir la lista de los documentos sin encabezado </td><td valign="top"><input type="file" name="fileDocumentos" /></td></tr>
            <tr>
                <td colspan="2" align="right">
                    <br><input  type="button"
                                value="Proceder a Calificar"
                                onClick="someterFormulario(
                                        'mensajes',
                                        this.form,
                                        './contenidos/calificacion/calificacionPlan2.php',
                                        true,
                                        true
                                        );
                                "
                    />
                </td></tr>
        </table></form>
    <br>
    <!--<table cellpadding="2" cellspacing="0" border="0" width="50%">
        <tr>
            <td bgcolor="#E4E4E4" class="tituloTabla" align="center" width="250px">Modalidad</td>
            <td bgcolor="#E4E4E4" class="tituloTabla" align="center">Total</td>
        </tr>
        {foreach from=$arrModalidad key=seqModalidad item=txtModalidad}
            <tr>
                <td style="border-bottom: 1px dotted #999999;"><b>{$txtModalidad|utf8_decode|lower|ucwords|utf8_encode}</b></td>
                <td align="center" style="border-bottom: 1px dotted #999999;">
                    {if $arrTotales.0.modalidad.$seqModalidad }
                        {$arrTotales.0.modalidad.$seqModalidad|number_format:0:'.':','}
                    {else}
                        0
                    {/if}
                </td>
            </tr>
        {/foreach}
        <tr>
            <td class="tituloTabla">Total</td>
            <td bgcolor="#E4E4E4" align="center" style="border-bottom: 1px dotted #999999;">
                {if $arrTotales.0.total }
                    {$arrTotales.0.total|number_format:0:'.':','}
                {else}
                    0
                {/if}
            </td>
        </tr>
    </table>-->
    <br>
    <div style="height:380px; overflow-y:scroll;"><table cellpadding="2" cellspacing="0" border="1" width="50%">
            <tr>
                <td bgcolor="#E4E4E4" align="center" width="250px"><b>Fecha Calificación</b></td>
                <td bgcolor="#E4E4E4" align="center"><b>Total Calificados</b></td>
            </tr>
            {foreach from=$arrFchCalifica key=fechaCalificacion item=cuantos}
                <!-- <a href="contenidos/calificacion/pdfCalifica.php?fchCal={$fechaCalificacion}" target='_blank'>PDF</a>&nbsp; -->
                <tr><td style="border-bottom: 1px dotted #999999;" align="center"><b>{$fechaCalificacion}</b>&nbsp;<a href="contenidos/calificacion/xlsCalifica.php?fchCal={$fechaCalificacion}" target='_blank'>XLS</a></td>
                    <td style="border-bottom: 1px dotted #999999;" align="center">{$cuantos}</td></tr>
            {/foreach}
        </table></div>
</center>