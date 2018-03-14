
<div style="width:100%; height:{$numAlto}; overflow: auto;">
   
   <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
      <tr>
         <td style="padding:10px; font-size: 20px; font-weight:bold; " valign="middle" align="center">
            Men&uacute; de ayuda para el sistema de informaci&oacute;n del proceso de Definición y 
            ejecución de los instrumentos de financiación para el acceso a la vivienda.
         </td>
      </tr>
      <tr>
         <td colspan="2" height="20px;" class="tituloVerde">
            Descripci&oacute;n
         </td>
      </tr>
      <tr>
         <td colspan="2" height="20px;" style="padding:20px;">
            A continuaci&oacute;n encontrar&aacute; los &iacute;tems principales del men&uacute; que 
            contiene el sistema de informaci&oacute;n. Para ver la ayuda de cada uno de los men&uacute;s 
            debe dar click en el nombre del men&uacute; para que despliegue la descripci&oacute;n del men&uacute; y 
            los sub men&uacute; que tenga dentro de cada opci&oacute;n. Dentro de cada opci&oacute;n de sub men&uacute;, tambi&eacute;n 
            puede hacer click para ver la descripci&oacute;n y gu&iacute;a de uso de cada uno de las opciones.
         </td>
      </tr>
   </table>
   
   
   {foreach from=$arrMenu key=seqMenu item=objMenu}
      <ul>
         <li style="cursor:hand;">
            
            <div onClick="mostrarOcultar('{$objMenu->txtEspanol|trim}')">
               <strong>{$objMenu->txtEspanol|trim}</strong>
            </div>
            
            {if not empty( $objMenu->arrHijos )}
               <div id="{$objMenu->txtEspanol|trim}" style="display:none">
                  {if trim($objMenu->txtAyuda) != ""}
                     {include file=$objMenu->txtAyuda|trim}
                  {/if}
                  <ul>
                     {foreach from=$objMenu->arrHijos item=objHijo}
                        <li>
                           <div onClick="mostrarOcultar('{$objHijo->txtEspanol|trim}')">
                              <strong>{$objHijo->txtEspanol|trim}</strong><br>
                           </div>
                           {if trim($objHijo->txtAyuda) != ""}
                              <div id="{$objHijo->txtEspanol|trim}" style="display:none">
                                 {include file=$objHijo->txtAyuda|trim}
                              </div>
                           {/if}
                        </li>
                     {/foreach}
                  </ul>
               </div>
            {/if}   
         </li>
      </ul>
      
   {/foreach}   
</div>