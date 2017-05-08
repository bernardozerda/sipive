
{if intval( $arrPost.seqTipoActo ) == 0 || intval( $arrPost.seqTipoActo ) == 1}
   {assign var=objTipoActo value=$arrTipoActo.1}
      
   <table cellspacing="0" cellpadding="3" border="0" width="95%" style="border: 1px dotted #666666;">
      <tr>
          <td rowspan="2" width="60px" height="60px" valign="middle" align="center" bgcolor="#E4E4E4">
            <form id="frmExportarGiros" 
                  onSubmit="return false;"
            >
                <button style="width:40px; height:40px;" 
                        type="button"
                        onClick="someterFormulario('mensajes','frmExportarGiros','contenidos/actosAdministrativos/exportarMasInformacion.php',true,false);"
                >
                      <img src="recursos/imagenes/excel.gif">
                </button>
                <input type="hidden" name="numActo"    value="{$arrPost.numActo}">
                <input type="hidden" name="fchActo"     value="{$arrPost.fchActo}">
                <input type="hidden" name="seqTipoActo" value="{$arrPost.seqTipoActo}">
            </form>
         </td>
         <td style="padding-left:10px; border-bottom:1px dotted #666666;"><b>Exportable de Giros</b></td>
      </tr>
      <tr>
         <td style="padding-left:10px;">
            Obtenga informaci&oacute;n de los giros realizados para esta resoluci&oacute;n, e informaci&oacute;n
            adicional a la que aparece en la pestaña de Giros de &eacute;ste m&oacute;dulo.
         </td>
      </tr>
   </table>
      
<!-- TABLA DE INFORMACION PARA LA RESOLUCION MODIFICATORIA -->
{elseif intval( $arrPost.seqTipoActo ) == 2}
   {assign var=objTipoActo value=$arrTipoActo.2}   
   
   <table cellspacing="0" cellpadding="3" border="0" width="95%" style="border: 1px dotted #666666;">
      <tr>
         <td rowspan="2" width="60px" height="60px" valign="middle" align="center" bgcolor="#E4E4E4">
            <form id="frmExportarGiros" onSubmit="return false;">
               <button style="width:40px; height:40px;"
                       onClick="someterFormulario(
                                  'mensajes',
                                  'frmExportarGiros',
                                  'contenidos/actosAdministrativos/exportarMasInformacion.php',
                                  true,
                                  false
                       );"
               >
                  <img src="recursos/imagenes/excel.gif">
               </button>
               <input type="hidden" name="numActo"    value="{$arrPost.numActo}">
               <input type="hidden" name="fchActo"     value="{$arrPost.fchActo}">
               <input type="hidden" name="seqTipoActo" value="{$arrPost.seqTipoActo}">
            </form>
         </td>
         <td style="padding-left:10px; border-bottom:1px dotted #666666;"><b>Exportable de Modificaciones</b></td>
      </tr>
      <tr>
         <td style="padding-left:10px;">
            Descargue la informaci&oacute;n de las mofificaciones realizadas en &eacute;sta resluci&oacute;n
         </td>
      </tr>
   </table>
   
   
<!-- TABLA DE INFORMACION PARA LA RESOLUCION INHABILITADOS -->
{elseif intval( $arrPost.seqTipoActo ) == 3}
   {assign var=objTipoActo value=$arrTipoActo.3}
   
   <table cellspacing="0" cellpadding="3" border="0" width="95%" style="border: 1px dotted #666666;">
      <tr>
         <td rowspan="2" width="60px" height="60px" valign="middle" align="center" bgcolor="#E4E4E4">
            <form id="frmExportarGiros" onSubmit="return false;">
               <button style="width:40px; height:40px;"
                       onClick="someterFormulario(
                                  'mensajes',
                                  'frmExportarGiros',
                                  'contenidos/actosAdministrativos/exportarMasInformacion.php',
                                  true,
                                  false
                       );"
               >
                  <img src="recursos/imagenes/excel.gif">
               </button>
               <input type="hidden" name="numActo"    value="{$arrPost.numActo}">
               <input type="hidden" name="fchActo"     value="{$arrPost.fchActo}">
               <input type="hidden" name="seqTipoActo" value="{$arrPost.seqTipoActo}">
            </form>
         </td>
         <td style="padding-left:10px; border-bottom:1px dotted #666666;"><b>Exportable de Inhabilitdos</b></td>
      </tr>
      <tr>
         <td style="padding-left:10px;">
            Obtenga informaci&oacute;n de las inhabilidades cargadas para esta resoluci&oacute;n.
         </td>
      </tr>
   </table>
   
<!-- TABLA DE INFORMACION PARA RECURSOS DE REPOSICION -->
{elseif intval( $arrPost.seqTipoActo ) == 4}
   {assign var=objTipoActo value=$arrTipoActo.4}   
   
   <table cellspacing="0" cellpadding="3" border="0" width="95%" style="border: 1px dotted #666666;">
      <tr>
         <td rowspan="2" width="60px" height="60px" valign="middle" align="center" bgcolor="#E4E4E4">
            <form id="frmExportarGiros" onSubmit="return false;">
               <button style="width:40px; height:40px;"
                       onClick="someterFormulario(
                                  'mensajes',
                                  'frmExportarGiros',
                                  'contenidos/actosAdministrativos/exportarMasInformacion.php',
                                  true,
                                  false
                       );"
               >
                  <img src="recursos/imagenes/excel.gif">
               </button>
               <input type="hidden" name="numActo"    value="{$arrPost.numActo}">
               <input type="hidden" name="fchActo"     value="{$arrPost.fchActo}">
               <input type="hidden" name="seqTipoActo" value="{$arrPost.seqTipoActo}">
            </form>
         </td>
         <td style="padding-left:10px; border-bottom:1px dotted #666666;"><b>Resultados</b></td>
      </tr>
      <tr>
         <td style="padding-left:10px;">
            Obtenga informaci&oacute;n de los resultados de los recursos de reposici&oacute;n cargados en el sistema
         </td>
      </tr>
   </table>
   
<!-- TABLA DE INFORMACION PARA RESOLUCION DE NO ASIGNADOS -->
{elseif intval( $arrPost.seqTipoActo ) == 5}
   {assign var=objTipoActo value=$arrTipoActo.5}   
   
   <table cellspacing="0" cellpadding="3" border="0" width="95%" style="border: 1px dotted #666666;">
      <tr>
         <td rowspan="2" width="60px" height="60px" valign="middle" align="center" bgcolor="#E4E4E4">
            <form id="frmExportarGiros" onSubmit="return false;">
               <button style="width:40px; height:40px;"
                       onClick="someterFormulario(
                                  'mensajes',
                                  'frmExportarGiros',
                                  'contenidos/actosAdministrativos/exportarMasInformacion.php',
                                  true,
                                  false
                       );"
               >
                  <img src="recursos/imagenes/excel.gif">
               </button>
               <input type="hidden" name="numActo"    value="{$arrPost.numActo}">
               <input type="hidden" name="fchActo"     value="{$arrPost.fchActo}">
               <input type="hidden" name="seqTipoActo" value="{$arrPost.seqTipoActo}">
            </form>
         </td>
         <td style="padding-left:10px; border-bottom:1px dotted #666666;"><b>Listado</b></td>
      </tr>
      <tr>
         <td style="padding-left:10px;">
            Listado de los hogares que fueron calificados y no asignados
         </td>
      </tr>
   </table>
   
<!-- TABLA DE INFORMACION PARA RENUNCIA -->
{elseif intval( $arrPost.seqTipoActo ) == 6}
   {assign var=objTipoActo value=$arrTipoActo.6}   
   
   <table cellspacing="0" cellpadding="3" border="0" width="95%" style="border: 1px dotted #666666;">
      <tr>
         <td rowspan="2" width="60px" height="60px" valign="middle" align="center" bgcolor="#E4E4E4">
            <form id="frmExportarGiros" onSubmit="return false;">
               <button style="width:40px; height:40px;"
                       onClick="someterFormulario(
                                  'mensajes',
                                  'frmExportarGiros',
                                  'contenidos/actosAdministrativos/exportarMasInformacion.php',
                                  true,
                                  false
                       );"
               >
                  <img src="recursos/imagenes/excel.gif">
               </button>
               <input type="hidden" name="numActo"    value="{$arrPost.numActo}">
               <input type="hidden" name="fchActo"     value="{$arrPost.fchActo}">
               <input type="hidden" name="seqTipoActo" value="{$arrPost.seqTipoActo}">
            </form>
         </td>
         <td style="padding-left:10px; border-bottom:1px dotted #666666;"><b>Listado</b></td>
      </tr>
      <tr>
         <td style="padding-left:10px;">
            Listado de los hogares que renunciaron a su subsidio
         </td>
      </tr>
   </table>
   
<!-- TABLA DE INFORMACION PARA LAS NOTIFICACIONES -->
{elseif intval( $arrPost.seqTipoActo ) == 7}
   {assign var=objTipoActo value=$arrTipoActo.7}   
   
    <table cellspacing="0" cellpadding="3" border="0" width="95%" style="border: 1px dotted #666666;">
      <tr>
         <td rowspan="2" width="60px" height="60px" valign="middle" align="center" bgcolor="#E4E4E4">
            <form id="frmExportarGiros" onSubmit="return false;">
               <button style="width:40px; height:40px;"
                       onClick="someterFormulario(
                                  'mensajes',
                                  'frmExportarGiros',
                                  'contenidos/actosAdministrativos/exportarMasInformacion.php',
                                  true,
                                  false
                       );"
               >
                  <img src="recursos/imagenes/excel.gif">
               </button>
               <input type="hidden" name="numActo"    value="{$arrPost.numActo}">
               <input type="hidden" name="fchActo"     value="{$arrPost.fchActo}">
               <input type="hidden" name="seqTipoActo" value="{$arrPost.seqTipoActo}">
            </form>
         </td>
         <td style="padding-left:10px; border-bottom:1px dotted #666666;"><b>Notificaciones</b></td>
      </tr>
      <tr>
         <td style="padding-left:10px;">
            Obtenga informacion del listado de hogares cargados y de las resoluciones a las cuales recibieron notidicaci&oacute;n
         </td>
      </tr>
   </table>
   
   
   
<!-- TABLA DE INFORMACION PARA LA RESOLUCION INDEXACION -->
{elseif intval( $arrPost.seqTipoActo ) == 8}
   {assign var=objTipoActo value=$arrTipoActo.8}
   
    <table cellspacing="0" cellpadding="3" border="0" width="95%" style="border: 1px dotted #666666;">
      <tr>
         <td rowspan="2" width="60px" height="60px" valign="middle" align="center" bgcolor="#E4E4E4">
            <form id="frmExportarGiros" onSubmit="return false;">
               <button style="width:40px; height:40px;"
                       onClick="someterFormulario(
                                  'mensajes',
                                  'frmExportarGiros',
                                  'contenidos/actosAdministrativos/exportarMasInformacion.php',
                                  true,
                                  false
                       );"
               >
                  <img src="recursos/imagenes/excel.gif">
               </button>
               <input type="hidden" name="numActo"    value="{$arrPost.numActo}">
               <input type="hidden" name="fchActo"     value="{$arrPost.fchActo}">
               <input type="hidden" name="seqTipoActo" value="{$arrPost.seqTipoActo}">
            </form>
         </td>
         <td style="padding-left:10px; border-bottom:1px dotted #666666;"><b>Indexaci&oacute;n</b></td>
      </tr>
      <tr>
         <td style="padding-left:10px;">
            Obtenga informaci&oacute;n de las indexaciones cargados en el sistema
         </td>
      </tr>
   </table>
   
{/if}

<!-- EXPORTABLE DE HOGARES -->
<br>
<table cellspacing="0" cellpadding="3" border="0" width="95%" style="border: 1px dotted #666666;">
   <tr>
      <td rowspan="2" width="60px" height="60px" valign="middle" align="center" bgcolor="#E4E4E4">
         <form id="frmExportarGiros" onSubmit="return false;">
            <button style="width:40px; height:40px;"
                    onClick="someterFormulario(
                               'mensajes',
                               'frmExportarGiros',
                               'contenidos/actosAdministrativos/exportarHogares.php',
                               true,
                               false
                    );"
            >
               <img src="recursos/imagenes/excel.gif">
            </button>
            <input type="hidden" name="numActo"    value="{$arrPost.numActo}">
            <input type="hidden" name="fchActo"     value="{$arrPost.fchActo}">
            <input type="hidden" name="seqTipoActo" value="{$arrPost.seqTipoActo}">
         </form>
      </td>
      <td style="padding-left:10px; border-bottom:1px dotted #666666;"><b>Exportable de Hogares</b></td>
   </tr>
   <tr>
      <td style="padding-left:10px;">
         Obtenga informaci&oacute;n de los hogares asignados a &eacute;sta resoluci&oacute;n, adem&aacute;s de informaci&oacute;n
         adicional acerca del estado actual de los hogares y la conformaci&oacute;n original con la que fueron cargados.
      </td>
   </tr>
</table>