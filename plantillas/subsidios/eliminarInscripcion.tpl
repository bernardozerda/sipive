	
	{assign var=seqModalidad value=$claFormulario->seqModalidad}
	{assign var=seqSolucion value=$claFormulario->seqSolucion}
   
<form onSubmit="eliminarInscripcion( this ); return false;">
   <div style="padding:40px;">
      
      <!-- COMENTARIOS -->
      <div style="width:100%; text-align: left; font-size: 14px; border-bottom: 1px dotted #666666; padding: 3px;">
         <strong>Comentarios</strong>
      </div>
      <div style="width:70%; padding: 10px; float: left;">
         <textarea onblur="this.style.backgroundColor = '#FFFFFF';" 
                   onfocus="this.style.backgroundColor = '#ADD8E6';" 
                   style="width: 90%; height: 100px;" 
                   name="txtComentario" 
                   id="txtComentario" 
         ></textarea>
      </div>
      <div style="width: 24%; height: 100px; float: right; text-align: left; padding: 10px;">
         Por favor ingrese un comentario para ser almacenado dentro del hist&oacute;rico de formularios eliminados
      </div>
      
      <!-- DATOS DEL FORMULARIO -->
      <div style="width:100%; text-align: left; font-size: 14px; border-bottom: 1px dotted #666666; padding: 3px;">
         <strong>Datos del Formulario</strong>
      </div>
      <div style="width: 90%; padding: 10px; text-align: left; height: 65px;">
         
         <!-- MODALIDAD Y SOLUCION -->
         <div style="width: 100px; float: left; padding: 2px; ">
            <strong>Modalidad</strong>
         </div>
         <div style="width: 245px; float: left; padding: 2px; ">
            {$claFormulario->txtModalidad}
         </div>
         <div style="width: 100px; float: left; padding: 2px; ">
            <strong>Soluci&oacute;n</strong>
         </div>
         <div style="width: 245px; float: left; padding: 2px; ">
            {$claFormulario->txtSolucion}
         </div>
         
         <!-- CIUDAD Y LOCALIDAD -->
         <div style="width: 100px; float: left; padding: 2px; ">
            <strong>Ciudad</strong>
         </div>
         <div style="width: 245px; float: left; padding: 2px; ">
            {$claFormulario->txtCiudad}
         </div>
         <div style="width: 100px; float: left; padding: 2px; ">
            <strong>Localidad</strong>
         </div>
         <div style="width: 245px; float: left; padding: 2px; ">
            {$claFormulario->txtLocalidad|strtoupper}
         </div>
         
         <!-- DIRECCION Y BARRIO -->
         <div style="width: 100px; float: left; padding: 2px; ">
            <strong>Direcci&oacute;n</strong>
         </div>
         <div style="width: 245px; float: left; padding: 2px; ">
            {$claFormulario->txtDireccion}
         </div>
         <div style="width: 100px; float: left; padding: 2px; ">
            <strong>Barrio</strong>
         </div>
         <div style="width: 245px; float: left; padding: 2px; ">
            {$claFormulario->txtBarrio}
         </div>
         
         <!-- TELEFONOS FIJOS Y CELULAR -->
         <div style="width: 100px; float: left; padding: 2px; ">
            <strong>Tel&eacute;fono</strong>
         </div>
         <div style="width: 245px; float: left; padding: 2px; ">
            {if intval( $claFormulario->numTelefono1 ) != 0}
               {$claFormulario->numTelefono1} 
            {/if}
            
            {if intval( $claFormulario->numTelefono2 ) != 0} 
               {if intval( $claFormulario->numTelefono1 ) != 0}
                  ó
               {/if}
               {$claFormulario->numTelefono2}
            {/if}
         </div>
         <div style="width: 100px; float: left; padding: 2px; ">
            <strong>Celular</strong>
         </div>
         <div style="width: 245px; float: left; padding: 2px; ">
            {$claFormulario->numCelular}
         </div>
         
      </div>
      
      <!-- DATOS DEL FORMULARIO -->
      <div style="width:100%; text-align: left; font-size: 14px; border-bottom: 1px dotted #666666; padding: 3px;">
         <strong>Miembros de Hogar</strong>
      </div>
      <div style="width: 100%; padding: 10px; text-align: left;">
         {foreach from=$claFormulario->arrCiudadano key=seqCiudadano item=objCiudadano}
            {assign var=seqTipoDocumento value=$objCiudadano->seqTipoDocumento}
            <div style="width: 30%; float: left; padding: 2px; height:15px;">
               {$objCiudadano->txtTipoDocumento} {$objCiudadano->numDocumento}
            </div>
            <div style="width: 35%; float: left; padding: 2px; height:15px;">
               {$objCiudadano->txtNombre1} {$objCiudadano->txtNombre2} {$objCiudadano->txtApellido1} {$objCiudadano->txtApellido2}
            </div>
            <div style="width: 30%; float: left; padding: 2px; height:15px;">
               {$objCiudadano->txtParentesco}
            </div>
         {/foreach}
      </div>
      
      <div style="width: 90%; padding: 10px; text-align: center;">
         <button type="submit" name="eliminar" value="1">
            Eliminar Registro
         </button>
      </div>   
      
      <input type="hidden" name="formulario" value="{$seqFormulario}">
      
   </div>
 </form>