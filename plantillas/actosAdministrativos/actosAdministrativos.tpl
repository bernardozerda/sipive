
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="620px">
   <tr>
      <td width="230px" height="80px" valign="top" align="center">
         <div class="tituloTabla" style="height:18px;">Filtros</div>
         <form id="frmFiltros" onSubmit="return false;">
            <div style="padding: 5px;">
               <select name="seqTipoActo" 
                       onFocus="this.style.backgroundColor = '#ADD8E6';"
                       onBlur="this.style.backgroundColor = '#FFFFFF';"
                       style="width: 220px;"
               >
                  <option value="0">Todos los Actos</option>
                  {foreach from=$arrTipoActo key=seqTipoActo item=objTipoActo}
                     <option value="{$seqTipoActo}">{$objTipoActo->txtTipoActo}</option>
                  {/foreach}   
               </select>
            </div>
            <div style="padding: 5px;">
               <input type="text" 
                      name="numActo" 
                      onFocus="this.style.backgroundColor = '#ADD8E6'"
                      onBlur="
                         this.style.backgroundColor = '#FFFFFF'; 
                         soloNumeros( this ); 
                      " 
                      style="width: 220px;"
                      placeholder="Número de Acto Admnistrativo"
               >
            </div>
            <div style="padding: 5px;">
               <input type="file" 
                      name="cedulas" 
                      style="width: 220px;"
                      placeholder="Documentos"
               >
            </div>
            <div style="padding: 5px;">
               <input type="button" 
                      style="width: 80px;"
                      placeholder="Filtrar"
                      value="Filtrar"
                      onClick="
                         someterFormulario( 'listadoActos' , this.form , 'contenidos/actosAdministrativos/listadoActos.php', true , true );
                      "
               > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <input type="reset" 
                      style="width: 80px;"
                      placeholder="Limpiar"
                      value="Limpiar"
               >
            </div>
         </form>
      </td>
      <td rowspan="2"  valign="top">
         <div id="informacion" style="width:620px; height:620px; padding:10px;">
            {include file="actosAdministrativos/informacionActo.tpl"}
         </div>
      </td>
   </tr>
   <tr>
      <td valign="top">
         <div class="tituloTabla" style="height:18px;">Listado</div>
         <div id="listadoActos" style="height: 520px; overflow: auto;">
            {include file="actosAdministrativos/listadoActos.tpl"}
         </div>
      </td>
   </tr>
   <tr>
      <td>&nbsp;</td>
      <td align="center">
         <button onClick="someterFormulario('mensajes','frmSavarAAD','./contenidos/actosAdministrativos/salvarActosAdministrativos.php',true,true);">
            Guardar Cambios
         </button>
      </td>
   </tr>
</table>

         