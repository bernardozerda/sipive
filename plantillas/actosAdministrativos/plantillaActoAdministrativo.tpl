<div style="width: 100%; height: 400px; overflow: auto;">
   
   <table border="0" cellspacing="0" cellpadding="5">
      <tr>
         <td>
            Debe crear un archivo de texto plano, seprado por tabulaciones, <strong>CON TITULOS</strong>
            que tenga las siguientes columnas (coloque las columnas en estricto orden y con el tipo de dato que se indica):
         </td>
      </tr>
      <tr>
         <td>
            <ol>
               {foreach from=$objTipoActo->arrFormatoArchivo item=arrCaracteristica}
                  <li>
                     {$arrCaracteristica.nombre} [ {$arrCaracteristica.tipo|ucwords} ]
                     {if isset( $arrCaracteristica.rango ) && not empty( $arrCaracteristica.rango )}
                        <br>Este campo tiene un rango de valores válidos:
                        <ul>
                           {foreach from=$arrCaracteristica.rango item=txtRango}
                              <li>{$txtRango|ucwords}</li>
                           {/foreach}   
                        </ul>
                     {/if}
                  </li>
               {/foreach}
            </ol>
         </td>
      </tr>
      <tr>
         <td>Use los identificadores de los estados tomando el que corresponda de la tabla que sigue:
            {if $objTipoActo->seqTipoActo == 4}
               <ul>
                  {foreach from=$arrEstadosReposicion key=seqEstado item=txtEstado}
                     <li>[{$seqEstado}] {$txtEstado}</li>
                  {/foreach}
               </ul>
            {/if}
         </td>
      </tr>
   </table>
            
</div>