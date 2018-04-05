<!-- FORMULARIO DE INSCRIPCION CON SEGUIMIENTO -->
{if $objFormularioProyecto->seqPryEstadoProceso != "" }
    {assign var=seqPryEstadoProceso value=$objFormularioProyecto->seqPryEstadoProceso}
{else}
    {assign var=seqPryEstadoProceso value = 1}
{/if}

<form name="frmInscripcionProyecto" id="frmInscripcionProyecto" onSubmit="return false;">
    <!-- CODIGO PARA EL POPUP DE SEGUIMIENTO -->
    {assign var=seqPryEstadoProceso value=$objFormularioProyecto->seqPryEstadoProceso}
    {include file='proyectos/pedirSeguimiento.tpl'}

    <table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#E4E4E4">
        <tr> <!-- BOTON PARA SALVAR EL FORMULARIO -->
            <td height="25px" valign="middle" align="right" style="padding-right:10px; padding-left:10px;" bgcolor="#E4E4E4" colspan="4">
                <div style="font-size: 10px; float:left">(*) Campo obligatorio </div>
                <div style="font-size: 10px; float:right">
                    {if $arrPrivilegios.crear == "1" || $arrPrivilegios.editar == "1"}
                        <input type="submit" name="salvar" id="salvar" value="Salvar Inscripci&oacute;n" onClick="preguntarGuardarProyecto()"/>
                    {else}
                        &nbsp;
                    {/if}
                </div>
                <input type="hidden" id="seqUsuario" name="seqUsuario" value="{$seqUsuario}">
                <input type="hidden" id="seqFormularioEditar" name="seqFormularioEditar" value="{$seqProyecto}">
                <input type="hidden" id="txtArchivo" name="txtArchivo" value="./contenidos/proyectos/salvarInscripcion.php">
            </td>
        </tr>
    </table>
    <div id="postulacion" class="yui-navset" style="width:100%; text-align:left;">
        <ul class="yui-nav" style="background:#E4E4E4;">
            <li class="selected"><a href="#frm"><em>Proyecto</em></a></li>
           <!-- <li><a href="#ofe"><em>Oferente</em></a></li>-->
        </ul>
        <div class="yui-content">
            <div id="frm" style="height:380px;">
                {assign var=f value=$objFormularioProyecto->seqModalidad}
                {if $seqModalidad == ""}
                    {assign var=seqModalidad value=1}
                {/if}
                <!-- ESTADO DEL PROCESO -->
                <table cellspacing="0" cellpadding="2" border="0" width="100%" height="25px">
                    <tr bgcolor="#E4E4E4">
                        <td width="140px"><b>Estado del proceso: </b></td>
                        <td width="280px">
                            {if $objFormularioProyecto->seqPryEstadoProceso == ""} Inscripcion {else} {$arrEstadoProceso.$seqPryEstadoProceso} {/if}
                            <input type="hidden" name="seqPryEstadoProceso" id="seqPryEstadoProceso" value="1">
                        </td>
                        <td width="140px"><b>Fecha de Inscripci&oacute;n</b></td>
                        <td>{$objFormularioProyecto->fchInscripcion}&nbsp;</td>
                    </tr>
                    <tr><td height="5px"></td></tr>
                </table>
                {include file="proyectos/secDatosProyectoInscripcion.tpl"}
            </div>
         
        </div>
    </div>
</form>
<div id="postulacionTabView"></div>
<div id="objDireccionOculto" style="display:none"></div>
<div id="objDireccionOcultoSolucion" style="display:none"></div>