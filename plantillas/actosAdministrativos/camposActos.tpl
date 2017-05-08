
<div style="padding-bottom: 3px;">
   <b>{$arrCaracteristica.txtNombre}</b>
</div>
<div style="height: 100%;">
   {if $arrCaracteristica.txtTipo == "textarea"}
      <textarea
         name="caracteristicas[{$seqCaracteristica}]"
         id="{$seqCaracteristica}"
         onFocus="this.style.backgroundColor = '#ADD8E6';"
         onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales(this);"
         style="width: 100%; height: 100%"
      >{$objActo->arrCaracteristicas.$seqCaracteristica}</textarea>
   {/if}   
   {if $arrCaracteristica.txtTipo == "texto"}
      <input 
         type="text"
         name="caracteristicas[{$seqCaracteristica}]"
         id="{$seqCaracteristica}"
         onFocus="this.style.backgroundColor = '#ADD8E6';"
         onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales(this);"
         style="width: 200px;"
         value="{$objActo->arrCaracteristicas.$seqCaracteristica}"
      >
   {/if}   
   {if $arrCaracteristica.txtTipo == "numero"}
      <input 
         type="text"
         name="caracteristicas[{$seqCaracteristica}]"
         id="{$seqCaracteristica}"
         onFocus="this.style.backgroundColor = '#ADD8E6';"
         onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros(this);"
         style="width: 200px;"
         value="{$objActo->arrCaracteristicas.$seqCaracteristica}"
      >
   {/if}   
   {if $arrCaracteristica.txtTipo == "fecha"}
      <input 
         type="text"
         name="caracteristicas[{$seqCaracteristica}]"
         id="{$seqCaracteristica}"
         onFocus="this.style.backgroundColor = '#ADD8E6';"
         onBlur="this.style.backgroundColor = '#FFFFFF';"
         style="width: 200px;"
         value="{$objActo->arrCaracteristicas.$seqCaracteristica}"
         readonly
         > <a href="#" onClick="calendarioPopUp('{$seqCaracteristica}')">Calendario</a>
   {/if}   
</div>
      

