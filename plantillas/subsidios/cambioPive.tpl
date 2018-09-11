

<form id="frmCambioEstados">

    {include file='subsidios/pedirSeguimiento.tpl'}
    <br>
    <table cellspacing="0" cellpadding="2" border="0" width="100%">
        <tr>
            <td colspan="2" class="tituloTabla" height="20px">
                Cambio de estado individual
            </td>
        </tr>

        <!-- SOLO PARA UNA CEDULA -->
        <tr>
            <td colspan="2" style="border-bottom: 1px dotted #999999; border-left: 1px dotted #999999;" valign="top">
                <table cellspacing="0" cellpadding="5" border="0" width="100%">
                    <tr>
                        <td class="tituloCampo" width="150px">
                            Buscar por nombre:
                        </td>
                        <td height="17px" valign="top">
                            <div id="buscarNombre">
                                <input	id="nombre" 
                                       type="text" 
                                       style="width:260px" 
                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                       onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                       />
                                <div id="contenedor"></div>
                            </div>	
                        </td>
                    </tr>
                    <tr>
                        <td class="tituloCampo">
                            N&uacute;mero del documento
                        </td>
                        <td>
                            <input	type="text" 
                                   name="buscaCedula" 
                                   id="buscaCedula" 
                                   value="" 
                                   style="width: 150px" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloNumeros(this);
                                           this.style.backgroundColor = '#FFFFFF';"
                                   onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
                                   />
                        </td>
                    </tr>
                    <tr>
                        <td class="tituloCampo">
                            Confirme n&uacute;mero 
                        </td>
                        <td>
                            <input	type="text" 
                                   name="buscaCedulaConfirmacion" 
                                   id="buscaCedulaConfirmacion" 
                                   value="" 
                                   style="width: 150px" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloNumeros(this);
                                           this.style.backgroundColor = '#FFFFFF';"
                                   onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
                                   />
                        </td>
                    </tr>
                    <tr>
                        <td class="tituloCampo">
                            Tipo Documento
                        </td>
                        <td>
                            <select name="seqTipoDocumento" style="width:310px">
                                {foreach from=$arrTipoDocumentos key=seqTipoDocumento item=txtTipoDocumento}
                                    <option value="{$seqTipoDocumento}">{$txtTipoDocumento}</option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>

        <!-- BOTON -->
        <tr>
            <td colspan="2" height="25px" align="center" style="padding-right:20px;" bgcolor="#F9F9F9">
                <input type="button" 
                       value="Regresar A Pive" 
                       onClick="someterFormulario(
                                       'mensajes',
                                       this.form,
                                       './contenidos/subsidios/regresoPiveSalvar.php',
                                       true,
                                       true
                                       );
                       "
                       />



            </td>
        </tr>	
    </table>

</form>

<div id="buscarCedulaListener"></div>
<div id="listenerBuscarNombre"></div>

<!--<div id="cambioEstadosPosibles" style="display:none;">
    <div class="hd">Listado de Estados Validos</div>
    <div class="bd" style="overflow: auto; height: 500px;">
        <center>
            <table cellpadding="2" cellspacing="0" border="0" width="90%">
                <tr>
                    <td class="tituloTabla">ID</td>
                    <td class="tituloTabla">Descripción</td>
                </tr>
{foreach from=$arrEstados key=seqEstado item=txtEstado}
    <tr><td width="30px" bgcolor="{cycle name=c1 values="#FFFFFF,#E4E4E4"}" align="center">{$seqEstado}</td>
        <td bgcolor="{cycle name=c2 values="#FFFFFF,#E4E4E4"}">{$txtEstado}</td></tr>
{/foreach}
</table>
</center>
</div>
</div>-->









