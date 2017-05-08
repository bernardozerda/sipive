
<form id="frmBusquedaOferta" onSubmit="return false;">

   {assign var=txtFlujo value=$arrFlujoHogar.flujo}
   {assign var=txtFase  value=$arrFlujoHogar.fase}

   <!-- PEDIR LOS SEGUIMIENTOS -->
   <div id="pedirSeguimiento" style="width:98%; padding-bottom:5px; text-align: right;">

       {include file="subsidios/pedirSeguimiento.tpl"} 

       <table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#E4E4E4">
        <tr>
            {if $arrFlujoHogar.fase == "revisionJuridica" || $arrFlujoHogar.fase == "revisionTecnica"}
              <td width="120px" class="tituloTabla">
                 Concepto Final
              </td>
              <td style="width:260px;">
                 <select name="txtConcepto" style="width:250px;">
                    <option value="" selected>SELECCIONE UNA OPCION</option>
                    <option value="0" {if $numConcepto == 0} selected {/if}>En Proceso</option>
                    <option value="1" {if $numConcepto == 1} selected {/if}>Viabilizado</option>
                    <option value="2" {if $numConcepto == 2} selected {/if}>No viabilizado</option>
                 </select>
              </td>  
            {else}
               <td width="120px" class="tituloTabla">&nbsp;</td>
               <td style="width:260px;">&nbsp;</td>  
            {/if}
            
            {if $txtImprimir != ""}
               <td>
                  <a href="#" onClick="{$txtImprimir}" targuet="new">
                     Imprimir
                  </a>
               </td>
            {else}
               <td>&nbsp;</td>
            {/if}
            
            {if $bolModificar == 1}
                <td align="right">
                        <input type="submit"
                               value="Salvar Gesti&oacute;n"
                               onClick="someterFormulario(
                                           'mensajes', 
                                           this.form, 
                                           './contenidos/casaMano/pedirConfirmacion.php', 
                                           false, 
                                           true 
                                       )" 
                        />

                    <input type="hidden" name="seqFormulario" value="{$seqFormulario}">
                    <input type="hidden" name="seqCasaMano"   value="{$seqCasaMano}">
                    <input type="hidden" name="txtFlujo"      value="{$txtFlujo}">
                    <input type="hidden" name="txtFase"       value="{$txtFase}">
                    <input type="hidden" name="cedula"        value="{$cedula}">
                </td>
            {/if}
        </tr>
       </table>
   </div>    

   <!-- PLANTILLAS DE CASA FASE DE CASA EN MANO -->
   <div id="plantilla" style="width:98%; height:500px;">
       {include file=$claFlujoDesembolsos->arrFases.$txtFlujo.$txtFase.plantilla}    
   </div>

</form>