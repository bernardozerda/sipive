

   <div class="hero-unit">
      <img src="./recursos/imagenes/cabezote_ws.png">
   </div>

   <div class="hero-unit-header" style="background-color: #289bae; color: white">
         <center><strong>AYUDA DEL WEB SERVICE</strong></center>
   </div>
  
   {foreach from=$arrAyuda item=arrFuncion}
      <div style="background-color: {cycle values="#ffffff,#eeeeee"}; padding:10px;">
         <ul>
            <li>
               <strong>Nombre de la Función:</strong> {$arrFuncion.nombre}<br>
               <strong>Descripción:</strong> {$arrFuncion.descripcion}
               <ul>
                  <li>
                     <strong class="text-success">Parametros de entrada:</strong>
                     <ul style="font-size: 12px;" class="text-success">
                        {foreach from=$arrFuncion.entrada item=arrDato}
                           <li>
                              <strong>Nombre de Variable:</strong> {$arrDato.nombre}</br>
                              <strong>Tipo de Dato:</strong> {$arrDato.tipo}<br>
                              <strong>Descripción:</strong> {$arrDato.descripcion}<br>
                           </li>
                        {/foreach}
                     </ul>
                  </li>
                  <li>
                     <strong class="text-info">Respuesta:</strong>
                     <ul style="font-size: 12px;" class="text-info">
                        {foreach from=$arrFuncion.salida item=arrDato}
                           <li>
                              <strong>Nombre de Variable:</strong> {$arrDato.nombre}</br>
                              <strong>Tipo de Dato:</strong> {$arrDato.tipo}<br>
                              <strong>Descripción:</strong> {$arrDato.descripcion}<br>
                           </li>
                        {/foreach}
                     </ul>
                  </li>
               </ul>
            </li>
         </ul>
      </div>
   {/foreach}
   <br>
   <div>
      En los siguientes links podrá encontrar ejemplos de consumo de nuestro web service en diferentes plataformas:
      <ul>
         <li><a href="./descargas/ejemplo_cliente_ws_php.zip" target="_blank">PHP</a></li>
         <li><a href="./descargas/ejemplo_cliente_ws_java.zip" target="_blank">JAVA (Fuentes)</a></li>
         <li><a href="./descargas/wsCliente.jar" target="_blank">JAVA (.jar)</a></li>
         <li><a href="./descargas/ejemplo_cliente_ws_net.zip" target="_blank">.NET (Fuentes VB)</a></li>
         <li><a href="./descargas/wsCliente.zip" target="_blank">Ejecutable (.exe)</a></li>
      </ul>
   </div>
   <br>