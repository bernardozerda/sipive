<!-- ********************************************************** 
    PLANTILLA DE GENERAR CARTA DE MOVILIZACION,
    SE PERMITE GENERAR CARTA DE MOVILIZACION 
    SE PERMITE BUSCAR EL CODIGO DE CARTAS GENERADAS
*************************************************************** -->

<div id="postulacion" class="yui-navset" style="width:100%; text-align:left;">
    <ul class="yui-nav">
        <li class="selected"><a href="#financiera"><em>Generar Carta </em></a></li>
            {if $grupo == 1}
            <li><a href="#verificacion"><em>Verificar Codigo</em></a></li>
            {/if}
    </ul> 
    <div class="yui-content">
        <div id="financiera" style="height:407px;"><p>
            <table cellpadding="1" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF" height='50%'>
                <tr>
                    <td colspan="4"><p><br><div class="msgError"><li>Este ciudadano no existe o no está vinculado a un hogar</li></div></p><br></td>
                </tr>        
                <tr>           
                    <td width="30%" style="text-align: center">Nombre de Ciudadano(a)</td>
                    <td colspan="3" width="70%" >
                        <input	type="text" 
                               name="namePostulado1" 
                               id="valPostulado1" 
                               value="{$nombrePostulante}"
                               onfocus="this.style.backgroundColor = '#ADD8E6';"
                               onblur="soloLetras(this);
                                       this.style.backgroundColor = '#FFFFFF';"
                               size="60" 
                               />
                    </td>
                </tr>        
                <tr>

                    <td width="10%" align="center"><input type="radio" value="3" name="radio" id="radio_3" checked="true"> Otra Entidad</td>
                    <td align="left" width="320px">
                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                onBlur="this.style.backgroundColor = '#FFFFFF';"  
                                name="seqBancoCuentaAhorro_3" 
                                id="seqBancoCuentaAhorro_3" 
                                style="width:300px;"
                                >
                            <option value="1">Ninguno</option>
                            {foreach from=$arrBanco key=seqBanco item=txtBanco}
                                <option value="{$seqBanco}"
                                        {if $objFormulario->seqBancoCuentaAhorro2 == $seqBanco} selected {/if}
                                        >{$txtBanco}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: center" ><br>

                        <div onclick="confirmarCartaMovilizacion({$numDocumento}, 2, '')" style="width:70px; text-align: center; border: 1px solid #000; background: #F5F5F5; position: relative; left: 44% ">
                            <img src="./recursos/imagenes/pdf.gif" width="25px" height="25px"><br>
                            <span style="font-size: 10px; font-weight: bold;">Exportar <br>a PDF</span>
                        </div>
                    </td>
                </tr>				        		
            </table>
            </p>
        </div>
        <div id="verificacion">
            <table cellpadding="1" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF" height='20%'>
                <tr>
                    <td><b>Digite código de verificación</b></td>
                    <td>
                        <input	type="text" 
                               name="codeVerificacion" 
                               id="codeVerificacion" 
                               value=""
                               onfocus="this.style.backgroundColor = '#ADD8E6';"
                               size="60" 

                               /> 
                    </td>
                    <td><input type="button" class="buscarCedula" value="Buscar" onclick="obtenerCodigo()"></td>
                </tr>

            </table>
            <p><div id="mostrarInformacion"></div></p>
        </div>
    </div>
</div>
<div id="postulacionTabView"></div>
<div id="objDireccionOculto" style="display:none"></div>
<div id="objDireccionOcultoSolucion" style="display:none"></div>