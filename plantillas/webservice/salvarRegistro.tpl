<br>
<table border="0" width="600px" class="hero-unit-header" cellpadding="5"> 
   <tr>
      <td width="80px" align="center" valign="middle">
         <img src="./recursos/imagenes/check.png" width="50" height="50">
      </td>
      <td>
         <h4>Se ha creado el registro, los datos son:</h4>
         <li><b>Nombre de la Entidad:</b> {$arrPost.entidad}</li>
         <li><strong>Nombre de la Contacto:</strong> {$arrPost.contacto}</li>
         <li><strong>Teléfono:</strong> {$arrPost.telefono}</li>
         <li><strong>Correo Electrónico:</strong> {$arrPost.correo}</li>
         <li><strong>Nombre de Usuario:</strong> {$arrPost.usuario}</li>
         <li><strong>Contraseña</strong>: ********</li>
      </td>
   </tr>
   <tr>
      <td colspan="2" align="center" style="padding: 10px;">
         <button class="btn btn-large btn-primary" id="botonVolver">
            Volver
         </button>
      </td>
   </tr>
</table><br>