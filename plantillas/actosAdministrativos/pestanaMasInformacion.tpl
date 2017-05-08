
{if intval( $arrPost.seqTipoActo ) == 0 || intval( $arrPost.seqTipoActo ) == 1}
   {assign var=objTipoActo value=$arrTipoActo.1}
   
   {if not empty( $objActo->arrMasInformacion)}
      <table cellspacing="0" cellpadding="3" border="0" width="100%">
         <tr>
            <td width="120px"><b>Suma de Giros</b></td>
            <td width="150px" align="right">$ {$objActo->valTotalGiros|number_format}</td>
            <td>&nbsp;</td>
         </tr>
         <tr>
            <td colspan="3" style="height:360px;">
               <div style="height:100%; width:100%;">
                  <table cellspacing="0" cellpadding="3" border="0" width="100%">
                     <tr>
                        <td class="tituloTabla">Tipo Documento</td>
                        <td class="tituloTabla">Documento</td>
                        <td class="tituloTabla">Total Giros</td>
                        <td class="tituloTabla">Valor Subsidio</td>
                     </tr>
                     {foreach from=$objActo->arrMasInformacion key=seqGiro item=arrGiro}
                        <tr>
                           <td>{$arrGiro.txtTipoDocumento}</td>
                           <td align="right">{$arrGiro.numDocumento|number_format}</td>
                           <td align="right">{$arrGiro.valTotalGiros|number_format}</td>
                           <td align="right">{$arrGiro.valAspiraSubsidio|number_format}</td>
                        </tr>
                     {/foreach}
                  </table>
               </div>
            </td>
         </tr>
      </table>
   {else}
      <span class="msgOk">No hay giros para esta resoluci&oacute;n</span>
   {/if}
   
<!-- TABLA DE INFORMACION PARA LA RESOLUCION MODIFICATORIA -->
{elseif intval( $arrPost.seqTipoActo ) == 2}
   {assign var=objTipoActo value=$arrTipoActo.2}
   
   {foreach from=$objActo->arrMasInformacion key=numDocumento item=arrModificaciones}
      <li style="background-color: {cycle values="#FFFFFF,#EDEDED"};">
         <strong>{$arrModificaciones.txtTipoDocumento} {$numDocumento|number_format} {$arrModificaciones.txtNombre}</strong>
         <ul>
            {foreach from=$arrModificaciones.arrModificaciones item=arrModificacion}
               {if $arrModificacion.txtCampo != ""}
                  <li>
                     <strong>Campo Modificado:</strong> {$arrModificacion.txtCampo|ucwords}<br>
                     <ul>
                        <li>
                           Valor Incorrecto: 
                           {if is_numeric( $arrModificacion.txtIncorrecto)} 
                              {$arrModificacion.txtIncorrecto|number_format}
                           {else}
                              {$arrModificacion.txtIncorrecto}
                           {/if}
                        </li>
                        <li>
                           Valor Correcto: 
                           {if is_numeric( $arrModificacion.txtCorrecto)} 
                              {$arrModificacion.txtCorrecto|number_format}
                           {else}
                              {$arrModificacion.txtCorrecto}
                           {/if}
                        </li>
                     </ul>
                  </li>
               {/if}
            {/foreach}
         </ul>
      </li>
   {/foreach}
   
<!-- TABLA DE INFORMACION PARA LA RESOLUCION INHABILITADOS -->
{elseif intval( $arrPost.seqTipoActo ) == 3}
   {assign var=objTipoActo value=$arrTipoActo.3}  
   
   {foreach from=$objActo->arrMasInformacion key=seqFormularioActo item=arrInformacion}
      <li style="background-color: {cycle values="#FFFFFF,#EDEDED"};">
         <strong>Inhabilidades para el hogar de {$arrInformacion.arrPrincipal.numDocumento|number_format} {$arrInformacion.arrPrincipal.txtNombre}</strong>
         <ul>
            {foreach from=$arrInformacion.arrInhabilidades key=numDocumento item=arrDocumentos}
               <li>
                  {$numDocumento|number_format} {$arrDocumentos.txtNombre}
                  {if not empty( $arrDocumentos.arrListado )}
                  <ul>
                     {foreach from=$arrDocumentos.arrListado item=arrInhabilidad}
                        <li>{$arrInhabilidad.txtFuente}: {$arrInhabilidad.txtCausa}</li>
                     {/foreach}
                  </ul>
                  {/if}
               </li>
            {/foreach}
         </ul>
      </li>
   {/foreach}   
   
<!-- TABLA DE INFORMACION PARA RECURSOS DE REPOSICION -->
{elseif intval( $arrPost.seqTipoActo ) == 4}
   {assign var=objTipoActo value=$arrTipoActo.4}  
   <table cellspacing="0" cellpadding="3" border="0" width="100%">
      <tr>
         <td class="tituloTabla">Documento</td>
         <td class="tituloTabla">Nombre</td>
         <td class="tituloTabla">Resultado</td>
      </tr>
      {foreach from=$objActo->arrMasInformacion key=numDocumento item=arrResultado}
         <tr>
            <td align="right">{$numDocumento|number_format}</td>
            <td>{$arrResultado.txtNombre}</td>
            <td>{$arrResultado.txtEstadoReposicion}</td>
         </tr>
      {/foreach}
   </table>
   
<!-- TABLA DE INFORMACION PARA RESOLUCION DE NO ASIGNADOS -->
{elseif intval( $arrPost.seqTipoActo ) == 5}
   {assign var=objTipoActo value=$arrTipoActo.5}  
   
   <table cellspacing="0" cellpadding="3" border="0" width="100%">
      <tr>
         <td class="tituloTabla">Tipo Documento</td>
         <td class="tituloTabla">Documento</td>
         <td class="tituloTabla">Nombre</td>
      </tr>
      {foreach from=$objActo->arrMasInformacion key=numDocumento item=arrInformacion}
         <tr>
            <td>{$arrInformacion.txtTipoDocumento}</td>
            <td align="right" width="100px">{$numDocumento|number_format}</td>
            <td>{$arrInformacion.txtNombre}</td>
         </tr>
      {/foreach}
   </table>
   
<!-- TABLA DE INFORMACION PARA RENUNCIA -->
{elseif intval( $arrPost.seqTipoActo ) == 6}
   {assign var=objTipoActo value=$arrTipoActo.6}   
   
   <table cellspacing="0" cellpadding="3" border="0" width="100%">
      <tr>
         <td class="tituloTabla">Tipo Documento</td>
         <td class="tituloTabla">Documento</td>
         <td class="tituloTabla">Nombre</td>
      </tr>
      {foreach from=$objActo->arrMasInformacion key=numDocumento item=arrInformacion}
         <tr>
            <td>{$arrInformacion.txtTipoDocumento}</td>
            <td align="right" width="100px">{$numDocumento|number_format}</td>
            <td>{$arrInformacion.txtNombre}</td>
         </tr>
      {/foreach}
   </table>
   
<!-- TABLA DE INFORMACION PARA LAS NOTIFICACIONES -->
{elseif intval( $arrPost.seqTipoActo ) == 7}
   {assign var=objTipoActo value=$arrTipoActo.7}   
   
   <table cellspacing="0" cellpadding="3" border="0" width="100%">
      <tr>
         <td class="tituloTabla">Documento</td>
         <td class="tituloTabla">Nombre</td>
         <td class="tituloTabla">Resoluci&oacute;n</td>
         <td class="tituloTabla">Fecha</td>
      </tr>
      {foreach from=$objActo->arrMasInformacion key=numDocumento item=arrInformacion}
         <tr>
            <td align="right" width="100px">{$numDocumento|number_format}</td>
            <td>{$arrInformacion.nombre}</td>
            <td>{$arrInformacion.numero}</td>
            <td>{$arrInformacion.fecha}</td>
         </tr>
      {/foreach}
   </table>
   
   
<!-- TABLA DE INFORMACION PARA LA RESOLUCION INDEXACION -->
{elseif intval( $arrPost.seqTipoActo ) == 8}
   {assign var=objTipoActo value=$arrTipoActo.8}
   
   <table cellspacing="0" cellpadding="3" border="0" width="100%">
      <tr>
         <td class="tituloTabla">Documento</td>
         <td class="tituloTabla">Nombre</td>
         <td class="tituloTabla" colspan="2">Resolución</td>
         <td class="tituloTabla">Indexacion</td>
      </tr>
      {foreach from=$objActo->arrMasInformacion key=numDocumento item=arrIndexado}
         <tr>
            <td align="right">{$numDocumento|number_format}</td>
            <td>{$arrIndexado.txtNombre}</td>
            <td align="right">{$arrIndexado.numActoReferencia|number_format}</td>
            <td>{$arrIndexado.fchActoReferencia}</td>
            <td align="right">{$arrIndexado.valIndexado|number_format}</td>
         </tr>
      {/foreach}
   </table>
   
{/if}

