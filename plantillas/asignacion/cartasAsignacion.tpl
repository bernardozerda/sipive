
<form id="frmFiltros" onSubmit="return false;">
   <table cellspacing="0" cellpadding="5" border="0" width="98%">
      <tr>
         <td colspan="3" class="tituloTabla">
            Filtros de la tabla
         </td>
      </tr>
      <tr>
         <td height="50px" width="200px" valign="top">
            <label for="resolucion"><strong>Resoluci&oacute;n</strong></label><br>
            <select name="resolucion" id="resolucion" onChange="fncDataTableCartasAsignacion()">
               <option value="">Seleccione Resolucion</option>
               {foreach from=$arrActos key=txtClave item=txtValor}
                  <option value="{$txtClave}">{$txtValor}</option>
               {/foreach}   
            </select>
         </td>
         <td>
            <label for="documentos"><strong>Documentos</strong></label><br>
            <input type="file" name="documentos" onChange="fncDataTableCartasAsignacion();"><br>
            Archivo en texto plano sin titulos y una sola columna con los n&uacute;meros de documentos
         </td>
         <td>
            <input type="button" value="Limpiar Formulario" onClick="frmResetCarasAsignacion(this.form);">
         </td>
      </tr>
   </table>
</form>

<table cellspacing="0" cellpadding="5" border="0" width="98%">
   <tr>
      <td colspan="4" class="tituloTabla">
         Listado de Ciudadanos
      </td>
   </tr>
   <tr>
      <td width="200px" id="conteo">
         &nbsp;
      </td>
      <td align="center">
         <a href="#" onClick="fncDataTableCartasAsignacion(1);">Seleccionar Todos</a>
      </td>
      <td align="center">
         <a href="#" onClick="fncDataTableCartasAsignacion();">Limpiar Selecci&oacute;n</a>
      </td>
      <td width="200px">
         &nbsp;
      </td>
   </tr>
   <tr>
      <td colspan="4">
         <div id="tablaCiudadanos"></div>
         <div id="listenerTablaCiudadanos"></div>
      </td>
   </tr>
   <tr>
      <td width="200px" colspan="3">
         <label for="textoCarta"><strong>Texto de la Carta</strong></label><br>
         <textarea id="textoCarta" style="height: 100%; width: 100%;"></textarea>
      </td>
      <td align="center" style="vertical-align: bottom;">
         <button onClick="exportarCartasAsignacion();" style="width:70px;">
            <img src="./recursos/imagenes/pdf.gif" width="25px" height="25px">
            <span style="font-size: 10px; font-weight: bold;">Exportar <br>a PDF</span>
         </button>
      </td>
   </tr>
</table>

