<p>
<div style="width:100%; padding-left: 3%">
    <table  border="0" cellspacing="2" cellpadding="0" >
        <tr>
            <th class="tituloTabla" colspan="4">CRONOGRAMA DE FECHAS DE OBRA</th>
            <td align="right" colspan="3"><div onClick="addCronogramaFechas()" style="cursor: hand; text-align: right">Adicionar Cronograma
                    <img src="recursos/imagenes/add.png"></div></td>
        </tr>
    </table>
    <table border="0" cellspacing="2" cellpadding="0"  id="tablaFormularioFechas" style="padding-left: 3px; width: 98%">
        {assign var="num" value="0"}
        {counter start=0 print=false assign=num}
        {foreach from=$arrCronogramaFecha key=seqCronogramaFecha item=arrCronograma}
            {if $num++%2 == 0} <tr class="fila_0">
            {else} <tr class="fila_1">
                {/if}
                {counter print=false}
                {assign var="actual" value="r_$num"}
                <td>
                    <div class="form-group" >
                        <div class="col-md-12" style="background: #DFDFDF; text-align: center; height:20px; font-weight: bold" >Proyecto</div>
                        <div class="col-md-3"> 
                            <label>Acta Descriptiva</label><br />
                            <input type="hidden" name="seqCronogramaFecha[]" id="seqCronogramaFecha" value="{$arrCronograma.seqCronogramaFecha}" >
                            Num. <input name="numActaDescriptiva[]" type="text" id="numActaDescriptiva[{$actual}]" value="{$arrCronograma.numActaDescriptiva}" onBlur="sinCaracteresEspeciales(this);
                                    soloNumeros(this);" size="6" style="text-align:center" />
                            A&ntilde;o <input name="numAnoActaDescriptiva[]" type="text" id="numAnoActaDescriptiva[{$actual}]" value="{$arrCronograma.numAnoActaDescriptiva}" onBlur="sinCaracteresEspeciales(this);
                                    soloNumeros(this);" size="6" style="text-align:center" />
                        </div>
                        <div class="col-md-3">
                            <label>Inicio</label><br />
                            <input name="fchInicialProyecto[]" type="text" id="fchInicialProyecto[{$actual}]" value="{$arrCronograma.fchInicialProyecto}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp('fchInicialProyecto[{$actual}]');"><img src="recursos/imagenes/calendar.png"></a>
                        </div>
                        <div class="col-md-3">
                            <label>Terminaci&oacute;n</label><br />
                            <input name="fchFinalProyecto[]" type="text" id="fchFinalProyecto[{$actual}]" value="{$arrCronograma.fchFinalProyecto}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp('fchFinalProyecto[{$actual}]');"><img src="recursos/imagenes/calendar.png"></a>
                        </div>
                        <div class="col-md-3">
                            <label>Plazo Ejecuci&oacute;n (Meses)</label><br />
                            <input name="valPlazoEjecucion[]" type="text" id="valPlazoEjecucion[{$actual}]" value="{$arrCronograma.valPlazoEjecucion}" onBlur="sinCaracteresEspeciales(this);
                                    soloNumeros(this);" size="12" style="text-align:center" />
                        </div>
                        <div class="col-md-6"><label><h4>Ventas del Proyecto</h4></label> </div>
                        <div class="col-md-6"><label><h4>Entrega y Escrituración de Viviendas</h4></label> </div>
                        <div class="col-md-3">
                            <label>Inicio</label><br />
                            <input name="fchInicialEntrega[]" type="text" id="fchInicialEntrega[{$actual}]" value="{$arrCronograma.fchInicialEntrega}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp('fchInicialEntrega[{$actual}]');"><img src="recursos/imagenes/calendar.png"></a>
                        </div>
                        <div class="col-md-3">
                            <label>Terminaci&oacute;n</label><br />
                            <input name="fchFinalEntrega[]" type="text" id="fchFinalEntrega[{$actual}]" value="{$arrCronograma.fchFinalEntrega}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp('fchFinalEntrega[{$actual}]');"><img src="recursos/imagenes/calendar.png"></a>
                        </div>
                        <div class="col-md-3">
                            <label>Inicio</label><br />
                            <input name="fchInicialEscrituracion[]" type="text" id="fchInicialEscrituracion[{$actual}]" value="{$arrCronograma.fchInicialEscrituracion}" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp('fchInicialEscrituracion[{$actual}]');"><img src="recursos/imagenes/calendar.png"></a>
                        </div>
                        <div class="col-md-3">
                            <label>Terminaci&oacute;n</label><br />
                            <input name="fchFinalEscrituracion[]" type="text" id="fchFinalEscrituracion[{$actual}]" value="{$arrCronograma.fchFinalEscrituracion}" size="12" style="text-align:center" readonly />
                            <a href="#" onClick="javascript: calendarioPopUp('fchFinalEscrituracion[{$actual}]');">
                                <img src="recursos/imagenes/calendar.png" /></a>
                            <img src='recursos/imagenes/remove.png' width='22px' onclick='return confirmaRemoverLineaFormulario(this);' style='position: relative; float: right; right: 15%' />
                        </div>                   

                    </div>
                </td>
            </tr>
        {/foreach}
    </table>
</div>
</p>