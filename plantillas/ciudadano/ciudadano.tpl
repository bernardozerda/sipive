<div class="row">
   {if not empty( $arrPreguntas )}

      <!-- ESPACIO LATERAL -->
      <div class="span1">&nbsp;</div>
      <div class="span10" style="padding: 10px; height: 450px;">
         
         <h3>
            Verificaci&oacute;n de datos
         </h3>
         
         <div class="alert alert-info text-center">   
            A continuaci&oacute;n, y por su seguridad, le solicitamos nos conteste las siguientes
            preguntas con el fin de validar su identidad.  Las preguntas han sido tomadas de la 
            informaci&oacute;n que amablemente usted nos facilit&oacute; al momento de la inscripcci&oacute;n
            al programa. Podrá acceder a los servicios al ciudadano una vez conteste correctamente las 
            preguntas de validaci&oacute;n
          </div>
         
         <div class="text-center">
            <div class="btn-group" data-toggle="buttons-radio" id="divBotones">
               {foreach name="pasos" from=$arrPreguntas key=seqPregunta item=arrPregunta}
                  {if $smarty.foreach.pasos.first}
                     {assign var=txtClase value="btn active btn-primary"}
                  {else}
                     {assign var=txtClase value="btn"}
                  {/if}
                  {math equation=x+1 x=$smarty.foreach.pasos.index assign=numPaso}
                  <button type="button" id="btnPaso{$numPaso}" class="{$txtClase}">Paso {$numPaso}</button>
               {/foreach}
            </div>
         </div>
         
         <center>
            <form id="frmValidacion">
               {foreach name="preguntas" from=$arrPreguntas key=seqPregunta item=arrPregunta}
                  {math equation=x+1 x=$smarty.foreach.preguntas.index assign=numPaso}
                  {if $smarty.foreach.preguntas.first}
                     {assign var=txtOcultar value=""}
                  {else}
                     {assign var=txtOcultar value="display:none"}
                  {/if}
                  <div class="text-left" id="pregunta{$numPaso}" style="width:90%;{$txtOcultar}">
                     <legend>{$arrPregunta.texto}</legend>
                     <div style="float:left; width:5%;">&nbsp;</div>
                     <div style="float:left; width:95%;">
                        {foreach from=$arrPregunta.respuesta key=seqRespuesta item=txtRespuesta}
                           <label class="radio">
                              <input type="radio" name="respuesta[{$seqPregunta}]" value="{$seqRespuesta}">
                              {$txtRespuesta}
                           </label>
                        {/foreach}
                     </div>
                  </div>
               {/foreach}
               <input type="hidden" name="documento" value="{$numDocumento}">
            </form>
            
            <button class="btn btn-primary" id="btnSiguiente" onClick="paso();" value="1">
               Siguiente
            </button> &nbsp;
            <button class="btn" onClick="location.href='index.php'">
               Cancelar
            </button>
            
         </center>
         
      </div>
      <div class="span1">&nbsp;</div>
         
   {else}  
      <div class="span2">&nbsp;</div>
      <div class="span8" style="padding: 40px;">
         
         <div class="alert alert-block" style="padding:40px;">
            <h4 class="alert-heading">Lo Sentimos</h4>
            <p style="padding:10px;">
               La Secretar&iacute;a Distrital de H&aacute;bitat le informa que su n&uacute;mero de 
               documento de identidad no figura inscrito en el programa del Subsidio Distrital de Vivienda en Especie.
               Si tiene alguna inquietud por favor comun&iacute;quese con la  al tel&eacute;fono 
               358-1600 Extensiones 1006, 1007, 1008 o 1009.
            </p>
            <p class="text-center">
               <a class="btn btn-warning" href="#" onClick="location.href='index.php'">Terminar</a>
            </p>
         </div>
         
      </div>
      <div class="span2">&nbsp;</div>
   {/if}
</div>
      