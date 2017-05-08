 <form id="frmSavarAAD" onSubmit="return false;"> <!-- FORMULARIO PARA SALVAR LOS CAMBIOS EN LOS ACTOS ADMINISTRATIVOS -->
   
<table cellspacing="0" cellpadding="3" border="0" width="100%">

   <!-- TIPO DE ACTO ADMINISTRATIVO -->
   <tr>
      <td width="200px">
         <b>Tipo de Acto Administrativo</b>
      </td>
      <td>
         <select name="seqTipoActo" 
                 id="seqTipoActo"
                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                 onBlur="this.style.backgroundColor = '#FFFFFF';"
                 onChange="
                     cargarContenido(
                        'informacion',
                        './contenidos/actosAdministrativos/informacionActo.php',
                        'seqTipoActo=' + this.options[ this.selectedIndex ].value,
                        true
                     );
                 "
         >
            {foreach from=$arrTipoActo key=seqTipoActo item=objTipoActo}
               <option value="{$seqTipoActo}" {if $arrPost.seqTipoActo == $seqTipoActo} selected {/if} >
                  {$objTipoActo->txtTipoActo}
               </option>
            {/foreach}
         </select>
      </td>
      <td align="center">
         <a href="#" onClick="plantillaActoAdministrativo2('seqTipoActo')">Vea como construir el archivo de carga</a>
      </td>
   </tr>
   
   <!-- DATOS PRINCIPALES DEL ACTO ADMINISTRATIVO -->
   <tr>
      <td colspan="3">
         
         <table cellpadding="3" cellspacing="0" border="0" width="100%">
            <tr>
               <td width="200px;">
                  <b>Número de la Resolución</b>
               </td>
               <td>
                  <input type="text"
                         name="numActo"
                         id="numActo"
                         onFocus="this.style.backgroundColor = '#ADD8E6';"
                         onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros(this);"
                         value="{$arrPost.numActo}"
                         {if $arrPost.seqTipoActo == 7}
                            readonly
                         {/if}
               </td>
            </tr>
            <tr>
               <td>
                  <b>Fecha de la Resolución</b>
               </td>
               <td>
                  <input type="text"
                         name="fchActo"
                         id="fchActo"
                         onFocus="this.style.backgroundColor = '#ADD8E6';"
                         onBlur="this.style.backgroundColor = '#FFFFFF';"
                         value="{$arrPost.fchActo}"
                         readonly
                  >
                  <a href="#" onClick="calendarioPopUp('fchActo')">Calendario</a>
               </td>
            </tr>
            <tr>
               <td colspan="2" style="height:75px; padding-top:10px; padding-bottom:10px;">
                  {if intval( $arrPost.seqTipoActo ) == 0 || intval( $arrPost.seqTipoActo ) == 1}
                     {assign var="seqCaracteristica" value="1"}
                     {assign var=objTipoActo value=$arrTipoActo.1}
                  {elseif intval( $arrPost.seqTipoActo ) == 2}
                     {assign var="seqCaracteristica" value="2"}
                     {assign var=objTipoActo value=$arrTipoActo.2}
                  {elseif intval( $arrPost.seqTipoActo ) == 3}
                     {assign var="seqCaracteristica" value="3"}
                     {assign var=objTipoActo value=$arrTipoActo.3}
                  {elseif intval( $arrPost.seqTipoActo ) == 5}
                     {assign var="seqCaracteristica" value="8"}
                     {assign var=objTipoActo value=$arrTipoActo.5}
                  {elseif intval( $arrPost.seqTipoActo ) == 7}
                     {assign var="seqCaracteristica" value="39"}
                     {assign var=objTipoActo value=$arrTipoActo.7}
                  {elseif intval( $arrPost.seqTipoActo ) == 8}
                     {assign var="seqCaracteristica" value="31"}
                     {assign var=objTipoActo value=$arrTipoActo.8}
				  {elseif intval( $arrPost.seqTipoActo ) == 9}
                     {assign var="seqCaracteristica" value="99"}
                     {assign var=objTipoActo value=$arrTipoActo.9}
                  {/if}
                  {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
                  {include file="actosAdministrativos/camposActos.tpl"}
               </td>
            </tr>
         </table>
         
      </td>
   </tr>
   <tr>
      <td colspan="3">
         <div id="tabActoAdministrativo" class="yui-navset">
            <ul class="yui-nav">
               <li class="selected">
                  <a href="#tab1">
                     <em>Informaci&oacute;n</em>
                  </a>
               </li>
               {if $arrPost.numActo != 0 && $arrPost.fchActo != ""}
                  <li>
                     <a href="#tab2">
                        {if intval( $arrPost.seqTipoActo ) == 0 || intval( $arrPost.seqTipoActo ) == 1}
                           <em>Giros</em>
                        {elseif intval( $arrPost.seqTipoActo ) == 2}
                           <em>Modificaciones</em>
                        {elseif intval( $arrPost.seqTipoActo ) == 3}
                           <em>Inhabitados</em>
                        {elseif intval( $arrPost.seqTipoActo ) == 4}
                           <em>Resultados</em>
                        {elseif intval( $arrPost.seqTipoActo ) == 5}
                           <em>Listado</em>
                        {elseif intval( $arrPost.seqTipoActo ) == 6}
                           <em>Listado</em>
                        {elseif intval( $arrPost.seqTipoActo ) == 7}
                           <em>Listado</em>
                        {elseif intval( $arrPost.seqTipoActo ) == 8}
                           <em>Indexaci&oacute;n</em>
						{elseif intval( $arrPost.seqTipoActo ) == 9}
                           <em>Listado</em>
						{elseif intval( $arrPost.seqTipoActo ) == 10}
                           <em>Listado</em>
                        {/if}
                     </a>
                  </li>
                  <li>
                     <a href="#tab3">
                        <em>Exportables</em>
                     </a>
                  </li>
               {/if}
            </ul>            
            <div class="yui-content">
               <!-- CARACTERISTICAS DE CADA ACTO ADMINISTRATIVO -->
               <div id="tab1" style="height:400px; width:600; overflow: scroll;">
                  <p>
                     {include file="actosAdministrativos/pestanaInformacion.tpl"}
                     <div style="width: 100%; text-align: center">
                        <label for="archivo">Archivo de carga</label>
                        <input type="file" name="archivo" id="archivo"><br><br>
                        <a href="#" onClick="plantillaActoAdministrativo2('seqTipoActo')">Vea como construir el archivo de carga</a>
                     </div>
                  </p>
               </div>
         
               </form> <!-- ESTE FORMULARIO SE ABRE EN LA LINEA DE ESTE ARCHIVO Y SE CIERRA AQUI -->
                     
               {if $arrPost.numActo != 0 && $arrPost.fchActo != ""}
                  
                  <!-- INFORMACION DE LOS GIROS REALIZADOS -->   
                  <div id="tab2" style="height:410px; overflow: auto;">
                     <p>{include file="actosAdministrativos/pestanaMasInformacion.tpl"}</p>
                  </div>
                
                  <!-- EXPORTABLES DE EXCEL DE HOGARES, INFORMACION DEL ACTO ADMINISTRATIVO Y HOGARES VINCULADOS -->
                  <div id="tab3" style="height:410px; overflow: auto;">
                     <p><center>{include file="actosAdministrativos/pestanaExportables.tpl"}</center></p>
                  </div> 
                  
               {/if}
            </div>
         </div>
         <div id="listenerTabActoAdministrativo"></div>
      </td>
   </tr>
</table>
   