
<!--
        PLANTILLA PARA LA ETAPA DE REVSION DE OFERTA Y ESCRITURACION 
        @author Bernardo Zerda
        @version 1.0 Dic 2009
-->

<!-- DECLARACION DE VARIABLES PARA USAR EN LA PLANTILLA -->
{assign var=seqModalidad          value=$claFormulario->seqModalidad}
{assign var=seqSolucion           value=$claFormulario->seqSolucion}		
{assign var=seqLocalidad          value=$claFormulario->seqLocalidad}
{assign var=seqBancoAhorro        value=$claFormulario->seqBancoCuentaAhorro}
{assign var=seqBancoAhorro2       value=$claFormulario->seqBancoCuentaAhorro2}
{assign var=seqBancoCredito       value=$claFormulario->seqBancoCredito}
{assign var=seqEstadoProceso 	  value=$claFormulario->seqEstadoProceso}
{assign var=seqBancoCuentaAhorro  value=$claFormulario->seqBancoCuentaAhorro}
{assign var=seqBancoCuentaAhorro2 value=$claFormulario->seqBancoCuentaAhorro2}
{assign var=seqBancoCredito       value=$claFormulario->seqBancoCredito}
{assign var=seqEntidadDonante     value=$claFormulario->seqEmpresaDonante}
{assign var=seqTipoDocumento 	  value=$objCiudadano->seqTipoDocumento}
{assign var=bolDesplazado         value=$claFormulario->bolDesplazado}
{assign var=seqTipoEsquema         value=$claFormulario->seqTipoEsquema}
{assign var=numAltura value=550}
{math equation=x-50 x=$numAltura assign=numAlturaInterna}
<div id="revTecGen" class="yui-navset" style="width:98%; height:{$numAltura}; text-align:left;">
    <ul class="yui-nav">
        <li class="selected"><a href="#dho"><em>Datos del Hogar</em></a></li>
            {if $arrFlujoHogar.flujo == "retornoEscritura" || $arrFlujoHogar.flujo == "retornoGiroAnticipado"}
            <li><a href="#cte"><em>Concepto T&eacute;cnico</em></a></li>
            {else}
            <li><a href="#vus"><em>Datos de la Vivienda</em></a></li>
            {/if}
        <li><a href="#seg"><em>Seguimiento</em></a></li>
        <li><a href="#aad"><em>Actos Administrativos</em></a></li>
    </ul>            
    <div class="yui-content">

        <!-- PESTANA DE DATOS DEL HOGAR -->
        <div id="dho" style="height:{$numAltura}">

            <!-- FECHA DE LA VISITA -->
            <table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#e4e4e4">
                <tr>
                    <td width="140px"><b>Fecha de la Visita:</b></td>
                    <td>
                        <input	type="text" 
                               id="fchVisita" 
                               name="fchVisita"
                               value="{$claDesembolso->arrTecnico.fchVisita}"  
                               style="width:100px;"
                               maxlength="10"
                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                               readonly 
                               /> <a href="#" onClick="calendarioPopUp('fchVisita');">Calendario</a>	
                    </td>
                </tr>
                <tr>
                    <td><b>Preparó:</b></td>
                    <td>{$txtUsuarioSesion}</td>
                </tr>
                <tr>
                    <td><b>Aprobó:</b></td>
                    <td height="22px" valign="top">
                        <div id="buscarUsuario">
                            <input	id="aprobo" 
                                   name="txtAprobo"
                                   type="text" 
                                   style="width:250px" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                   value="{$claDesembolso->arrTecnico.txtAprobo}"
                                   />
                            <div id="contUsuario" style="width:250px"></div>
                        </div>	
                    </td>
                </tr>
            </table>
            {include file="desembolso/pestanaDatosHogar.tpl"}

        </div>
        <!-- PESTANA DE CONCEPTO TECNICO -->
        {if $arrFlujoHogar.flujo == "retornoEscritura" || $arrFlujoHogar.flujo == "retornoGiroAnticipado" || ($localidadcem == 22 && $bolDesplazado == 1 && $bolVisita == 0)}
            <div id="cte" style="height:{$numAltura}; overflow:auto;"><br>
                <center>

                    <table cellpadding="2" cellspacing="0" border="0" width="95%" style="border: 1px solid #999999;">
                        <tr><td colspan="2" align="center" style="padding-left:30px; padding-right:30px; font-weight:bold;">
                                REVISION CERTIFICADO DE EXISTENCIA Y HABITABILIDAD VIVIENDA
                                Y RSULTADO DE LA CONSULTA PARA EFECTOS DE LO
                                ORDENADO EN EL ARTICULO 34 DE LA RESOLUCION 966 DE 2004 DEL 
                                MINISTERIO DE AMBIENTE, VIVIENDA Y DESARROLLO TERRITORIAL 
                            </td></tr>
                        <tr><td colspan="2" >&nbsp;</td></tr>
                        <tr><td colspan="2" style="padding-left:30px; padding-right:30px;" >
                                El día de hoy {$txtHoy} se realizó la revision de los documentos radicados por el hogar
                                de <b>{$objCiudadano->txtNombre1} {$objCiudadano->txtNombre2} 
                                    {$objCiudadano->txtApellido1} {$objCiudadano->txtApellido2}</b>
                                identificado con <b> {$arrTipoDocumento.$seqTipoDocumento|ucwords} {$objCiudadano->numDocumento},</b> 
                                beneficiario(s) del Subsidio Distrital de Vivienda de la vivienda ubicada en la 
                                <b>{$claDesembolso->txtDireccionInmueble}</b> arrojando como resultado lo siguiente:
                            </td></tr>
                        <tr><td colspan="2" >&nbsp;</td></tr>
                        <tr>
                            <td valign="middle" align="justify" width="180px" class="tituloTabla">
                                Introduzca observaciones y presione el icono de adicionar
                            </td>
                            <td valign="top" align="center"  class="tituloTabla">
                                <table cellspacing="0" cellpadding="0" width="100%"><tr>
                                        <td>
                                            <textarea  id="observacion"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="this.style.backgroundColor = '#FFFFFF';
                                                               sinCaracteresEspeciales(this);"
                                                       rows="2"
                                                       cols="80"
                                                       class="inputLogin"
                                                       ></textarea>
                                        </td>
                                        <td valign="middle" align="center" width="50px"> 
                                            <button type="button" 
                                                    id="adicionar" 
                                                    title="adicionar" 
                                                    class="reporteador"
                                                    onClick="adicionarDocumentoAnalizado(document.getElementById('observacion'), 'resultadoAnalisis', 'observacion', 97, 80);"
                                                    >
                                                <img src="./recursos/imagenes/plus_icon.gif" width="14" height="15" alt="Adicionar" align="center">
                                            </button>
                                        </td>
                                    </tr></table>
                            </td>
                        </tr>
                        <tr><td colspan="2" id="resultadoAnalisis" style="padding-left:30px; padding-right:30px;"><br>
                                {foreach name=observacion from=$claDesembolso->arrTecnico.observacion item=txtObservacion}
                                    {math equation="x + y" x=$smarty.foreach.observacion.index y=1 assign=numSecuencia}							
                                    <div id="observacion{$numSecuencia}">							
                                        <div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; float:left"
                                             onMouseOver="this.style.backgroundColor = '#FFA4A4';"
                                             onMouseOut="this.style.backgroundColor = '#F9F9F9'"
                                             onClick="eliminarObjeto('observacion{$numSecuencia}')"
                                             >X</div>
                                        <div style="cursor:pointer; float:right; width:97%; height:14px; border:1px solid #F9F9F9;"
                                             onMouseOver="mostrarHint('{$txtDocumento}')" onMouseOut="ocultarHint();">
                                            {if $txtObservacion|strlen > 80}
                                                {$numSecuencia} - {$txtObservacion|substr:0:80}...
                                            {else}
                                                {$numSecuencia} - {$txtObservacion}
                                            {/if}
                                        </div>
                                        <input type="hidden" name="observacion[]" value="{$txtObservacion}">
                                    </div>								
                                {/foreach}
                            </td></tr>
                        <tr><td colspan="2" style="padding-left:30px; padding-right:30px; padding-top:5px;">
                                De acuerdo con la revisión anteriormente descrita es viable continuar desde el punto
                                de vista técnico con los trámites que permitan el desembolso del subsidio.<br><br>
                            </td></tr>
                    </table>	
                </center>
            </div>
        {else}
            <!-- PESTANA DE VIVIENDA USADA -->			
            <div id="vus" style="height:{$numAltura}">

                <div id="revTecVivUsa" class="yui-navset" style="width:98%; height:{$numAlturaInterna}; text-align:left;">
                    <ul class="yui-nav">
                        <li class="selected"><a href="#ces"><em>Condiciones Espaciales</em></a></li>
                        <li><a href="#cfi"><em>Físicas y Estructurales</em></a></li>
                        <li><a href="#spu"><em>Servicios Públicos</em></a></li>
                        <li><a href="#rfo"><em>Registro Fotográfico</em></a></li>
                    </ul>            
                    <div class="yui-content">

                        <!-- PESTANA DE CONDICIONES ESPACIALES -->
                        <div id="ces" style="height:{$numAlturaInterna}; overflow:auto">

                            <table cellpadding="2" cellspacing="0" border="0" width="100%"> 
                                <tr>
                                    <td class="tituloTabla" width="120px" height="25px" valign="bottom">Descripción</td>
                                    <td class="tituloTabla" width="50px" valign="bottom">Largo</td>
                                    <td class="tituloTabla" width="50px" valign="bottom">Ancho</td>
                                    <td class="tituloTabla" width="70px">Area (m<sup>2</sup>)</td>
                                    <td class="tituloTabla" valign="bottom">Observaciones</td>
                                </tr>

                                <!-- ESPACIO MULTIPLE -->
                                <tr>
                                    <td>Espacio Múltiple</td>
                                    <td align="center">
                                        <input type="text"
                                               id="numLargoMultiple"
                                               name="numLargoMultiple"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoMultiple', 'numAnchoMultiple', 'numAreaMultiple');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numLargoMultiple}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />	   
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAnchoMultiple"
                                               name="numAnchoMultiple"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoMultiple', 'numAnchoMultiple', 'numAreaMultiple');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAnchoMultiple}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAreaMultiple"
                                               name="numAreaMultiple"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);
                                                       sumarAreas('areaTotal');"
                                               style="width:60px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAreaMultiple}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtMultiple"
                                               name="txtMultiple"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%;"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtMultiple}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- ALCOBA 1 -->
                                <tr>
                                    <td>Alcoba 1</td>
                                    <td align="center">
                                        <input type="text"
                                               id="numLargoAlcoba1"
                                               name="numLargoAlcoba1"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoAlcoba1', 'numAnchoAlcoba1', 'numAreaAlcoba1');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numLargoAlcoba1}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />	   
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAnchoAlcoba1"
                                               name="numAnchoAlcoba1"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoAlcoba1', 'numAnchoAlcoba1', 'numAreaAlcoba1');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAnchoAlcoba1}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAreaAlcoba1"
                                               name="numAreaAlcoba1"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);
                                                       sumarAreas('areaTotal');"
                                               style="width:60px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAreaAlcoba1}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtAlcoba1"
                                               name="txtAlcoba1"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%;"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtAlcoba1}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- ALCOBA 2 -->
                                <tr>
                                    <td>Alcoba 2</td>
                                    <td align="center">
                                        <input type="text"
                                               id="numLargoAlcoba2"
                                               name="numLargoAlcoba2"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoAlcoba2', 'numAnchoAlcoba2', 'numAreaAlcoba2');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numLargoAlcoba2}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />	   
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAnchoAlcoba2"
                                               name="numAnchoAlcoba2"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoAlcoba2', 'numAnchoAlcoba2', 'numAreaAlcoba2');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAnchoAlcoba2}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAreaAlcoba2"
                                               name="numAreaAlcoba2"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);
                                                       sumarAreas('areaTotal');"
                                               style="width:60px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAreaAlcoba2}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtAlcoba2"
                                               name="txtAlcoba2"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtAlcoba2}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- ALCOBA 3 -->
                                <tr>
                                    <td>Alcoba 3</td>
                                    <td align="center">
                                        <input type="text"
                                               id="numLargoAlcoba3"
                                               name="numLargoAlcoba3"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoAlcoba3', 'numAnchoAlcoba3', 'numAreaAlcoba3');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numLargoAlcoba3}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />	   
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAnchoAlcoba3"
                                               name="numAnchoAlcoba3"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoAlcoba3', 'numAnchoAlcoba3', 'numAreaAlcoba3');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAnchoAlcoba3}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAreaAlcoba3"
                                               name="numAreaAlcoba3"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);
                                                       sumarAreas('areaTotal');"
                                               style="width:60px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAreaAlcoba3}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtAlcoba3"
                                               name="txtAlcoba3"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtAlcoba3}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- COCINA -->
                                <tr>
                                    <td>Cocina</td>
                                    <td align="center">
                                        <input type="text"
                                               id="numLargoCocina"
                                               name="numLargoCocina"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoCocina', 'numAnchoCocina', 'numAreaCocina');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numLargoCocina}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />	   
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAnchoCocina"
                                               name="numAnchoCocina"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoCocina', 'numAnchoCocina', 'numAreaCocina');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAnchoCocina}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAreaCocina"
                                               name="numAreaCocina"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);
                                                       sumarAreas('areaTotal');"
                                               style="width:60px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAreaCocina}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtCocina"
                                               name="txtCocina"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtCocina}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- BANO 1 -->
                                <tr>
                                    <td>Baño 1</td>
                                    <td align="center">
                                        <input type="text"
                                               id="numLargoBano1"
                                               name="numLargoBano1"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoBano1', 'numAnchoBano1', 'numAreaBano1');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numLargoBano1}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />	   
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAnchoBano1"
                                               name="numAnchoBano1"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoBano1', 'numAnchoBano1', 'numAreaBano1');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAnchoBano1}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAreaBano1"
                                               name="numAreaBano1"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);
                                                       sumarAreas('areaTotal');"
                                               style="width:60px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAreaBano1}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtBano1"
                                               name="txtBano1"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtBano1}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- BANO 2 -->
                                <tr>
                                    <td>Baño 2</td>
                                    <td align="center">
                                        <input type="text"
                                               id="numLargoBano2"
                                               name="numLargoBano2"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoBano2', 'numAnchoBano2', 'numAreaBano2');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numLargoBano2}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />	   
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAnchoBano2"
                                               name="numAnchoBano2"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoBano2', 'numAnchoBano2', 'numAreaBano2');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAnchoBano2}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAreaBano2"
                                               name="numAreaBano2"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);
                                                       sumarAreas('areaTotal');"
                                               style="width:60px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAreaBano2}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtBano2"
                                               name="txtBano2"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtBano2}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- AREA DE LAVANDERIA -->
                                <tr>
                                    <td>Area de Lavandería</td>
                                    <td align="center">
                                        <input type="text"
                                               id="numLargoLavanderia"
                                               name="numLargoLavanderia"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoLavanderia', 'numAnchoLavanderia', 'numAreaLavanderia');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numLargoLavanderia}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />	   
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAnchoLavanderia"
                                               name="numAnchoLavanderia"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoLavanderia', 'numAnchoLavanderia', 'numAreaLavanderia');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAnchoLavanderia}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAreaLavanderia"
                                               name="numAreaLavanderia"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);
                                                       sumarAreas('areaTotal');"
                                               style="width:60px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAreaLavanderia}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtLavanderia"
                                               name="txtLavanderia"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtLavanderia}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- CIRCULACIONES -->
                                <tr>
                                    <td>Circulaciones</td>
                                    <td align="center">
                                        <input type="text"
                                               id="numLargoCirculaciones"
                                               name="numLargoCirculaciones"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoCirculaciones', 'numAnchoCirculaciones', 'numAreaCirculaciones');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numLargoCirculaciones}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />	   
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAnchoCirculaciones"
                                               name="numAnchoCirculaciones"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoCirculaciones', 'numAnchoCirculaciones', 'numAreaCirculaciones');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAnchoCirculaciones}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAreaCirculaciones"
                                               name="numAreaCirculaciones"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);
                                                       sumarAreas('areaTotal');"
                                               style="width:60px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAreaCirculaciones}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtCirculaciones"
                                               name="txtCirculaciones"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtCirculaciones}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- PATIO -->
                                <tr>
                                    <td>Patio</td>
                                    <td align="center">
                                        <input type="text"
                                               id="numLargoPatio"
                                               name="numLargoPatio"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoPatio', 'numAnchoPatio', 'numAreaPatio');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numLargoPatio}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />	   
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAnchoPatio"
                                               name="numAnchoPatio"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       calcularArea('numLargoPatio', 'numAnchoPatio', 'numAreaPatio');
                                               "
                                               style="width:55px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAnchoPatio}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td align="center">
                                        <input type="text"
                                               id="numAreaPatio"
                                               name="numAreaPatio"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);
                                                       sumarAreas('areaTotal');"
                                               style="width:60px; text-align: right;"
                                               maxlength="6"
                                               value="{$claDesembolso->arrTecnico.numAreaPatio}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtPatio"
                                               name="txtPatio"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtPatio}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- TOTAL -->
                                <tr>
                                    <td class="tituloTabla" colspan="3" align="right">Area Total Construida</td>
                                    <td bgcolor="#e4e4e4" align="right" style="padding-right:10px; font-weight: bold;" id="areaTotal">
                                        {$claDesembolso->arrTecnico.numAreaTotal|number_format:2:'.':','}
                                        <input type="hidden"
                                               id="numAreaTotal"
                                               name="numAreaTotal"
                                               value="{$claDesembolso->arrTecnico.numAreaTotal}"
                                               />
                                    </td>
                                    <td class="tituloTabla">&nbsp;</td>
                                </tr>
                            </table>

                        </div>

                        <!-- PESTANA DE CONDICIONES FISICAS Y ESTRUCTURALES -->
                        <div id="cfi" style="height:{$numAlturaInterna}; overflow:auto;">		

                            <table cellpadding="2" cellspacing="0" border="0" width="100%"> 
                                <tr>
                                    <td class="tituloTabla" width="150px">Descripción</td>
                                    <td class="tituloTabla" width="150px">Esado</td>
                                    <td class="tituloTabla" valign="bottom">Observaciones</td>
                                </tr>

                                <!-- CIMENTACION -->
                                <tr>
                                    <td>Cimentación</td>
                                    <td align="center">
                                        <select id="txtEstadoCimentacion" 
                                                name="txtEstadoCimentacion"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="ejecutado" {if $claDesembolso->arrTecnico.txtEstadoCimentacion == "ejecutado"} selected {/if} >Ejecutado</option>
                                            <option value="no ejecutado" {if $claDesembolso->arrTecnico.txtEstadoCimentacion == "no ejecutado"} selected {/if} >No Ejecutado</option>
                                            <option value="ejecucion parcial" {if $claDesembolso->arrTecnico.txtEstadoCimentacion == "ejecucion parcial"} selected {/if}>Ejecución Parcial</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtCimentacion"
                                               name="txtCimentacion"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtCimentacion}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- PLACA DE ENTREPISO -->
                                <tr>
                                    <td>Placa de Entrepiso</td>
                                    <td align="center">
                                        <select id="txtEstadoPlacaEntrepiso" 
                                                name="txtEstadoPlacaEntrepiso"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="ejecutado" {if $claDesembolso->arrTecnico.txtEstadoPlacaEntrepiso == "ejecutado"} selected {/if} >Ejecutado</option>
                                            <option value="no ejecutado" {if $claDesembolso->arrTecnico.txtEstadoPlacaEntrepiso == "no ejecutado"} selected {/if} >No Ejecutado</option>
                                            <option value="ejecucion parcial" {if $claDesembolso->arrTecnico.txtEstadoPlacaEntrepiso == "ejecucion parcial"} selected {/if}>Ejecución Parcial</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtPlacaEntrepiso"
                                               name="txtPlacaEntrepiso"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtPlacaEntrepiso}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- MAMPOSTERIA -->
                                <tr>
                                    <td>Mampostería</td>
                                    <td align="center">
                                        <select id="txtEstadoMamposteria" 
                                                name="txtEstadoMamposteria"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="ejecutado" {if $claDesembolso->arrTecnico.txtEstadoMamposteria == "ejecutado"} selected {/if} >Ejecutado</option>
                                            <option value="no ejecutado" {if $claDesembolso->arrTecnico.txtEstadoMamposteria == "no ejecutado"} selected {/if} >No Ejecutado</option>
                                            <option value="ejecucion parcial" {if $claDesembolso->arrTecnico.txtEstadoMamposteria == "ejecucion parcial"} selected {/if}>Ejecución Parcial</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtMamposteria"
                                               name="txtMamposteria"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtMamposteria}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- CUBIERTA -->
                                <tr>
                                    <td>Cubierta</td>
                                    <td align="center">
                                        <select id="txtEstadoCubierta" 
                                                name="txtEstadoCubierta"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="ejecutado" {if $claDesembolso->arrTecnico.txtEstadoCubierta == "ejecutado"} selected {/if} >Ejecutado</option>
                                            <option value="no ejecutado" {if $claDesembolso->arrTecnico.txtEstadoCubierta == "no ejecutado"} selected {/if} >No Ejecutado</option>
                                            <option value="ejecucion parcial" {if $claDesembolso->arrTecnico.txtEstadoCubierta == "ejecucion parcial"} selected {/if}>Ejecución Parcial</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtCubierta"
                                               name="txtCubierta"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtCubierta}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- VIGAS -->
                                <tr>
                                    <td>Vigas</td>
                                    <td align="center">
                                        <select id="txtEstadoVigas" 
                                                name="txtEstadoVigas"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="ejecutado" {if $claDesembolso->arrTecnico.txtEstadoVigas == "ejecutado"} selected {/if} >Ejecutado</option>
                                            <option value="no ejecutado" {if $claDesembolso->arrTecnico.txtEstadoVigas == "no ejecutado"} selected {/if} >No Ejecutado</option>
                                            <option value="ejecucion parcial" {if $claDesembolso->arrTecnico.txtEstadoVigas == "ejecucion parcial"} selected {/if}>Ejecución Parcial</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtVigas"
                                               name="txtVigas"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtVigas}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- columnas -->
                                <tr>
                                    <td>Columnas</td>
                                    <td align="center">
                                        <select id="txtEstadoColumnas" 
                                                name="txtEstadoColumnas"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="ejecutado" {if $claDesembolso->arrTecnico.txtEstadoColumnas == "ejecutado"} selected {/if} >Ejecutado</option>
                                            <option value="no ejecutado" {if $claDesembolso->arrTecnico.txtEstadoColumnas == "no ejecutado"} selected {/if} >No Ejecutado</option>
                                            <option value="ejecucion parcial" {if $claDesembolso->arrTecnico.txtEstadoColumnas == "ejecucion parcial"} selected {/if}>Ejecución Parcial</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtColumnas"
                                               name="txtColumnas"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtColumnas}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- Pañetes -->
                                <tr>
                                    <td>Pañetes</td>
                                    <td align="center">
                                        <select id="txtEstadoPanetes" 
                                                name="txtEstadoPanetes"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="ejecutado" {if $claDesembolso->arrTecnico.txtEstadoPanetes == "ejecutado"} selected {/if} >Ejecutado</option>
                                            <option value="no ejecutado" {if $claDesembolso->arrTecnico.txtEstadoPanetes == "no ejecutado"} selected {/if} >No Ejecutado</option>
                                            <option value="ejecucion parcial" {if $claDesembolso->arrTecnico.txtEstadoPanetes == "ejecucion parcial"} selected {/if}>Ejecución Parcial</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtPanetes"
                                               name="txtPanetes"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtPanetes}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- ENCHAPES Y ACCESORIOS -->
                                <tr>
                                    <td>Enchapes y Accesorios</td>
                                    <td align="center">
                                        <select id="txtEstadoEnchapes" 
                                                name="txtEstadoEnchapes"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="ejecutado" {if $claDesembolso->arrTecnico.txtEstadoEnchapes == "ejecutado"} selected {/if} >Ejecutado</option>
                                            <option value="no ejecutado" {if $claDesembolso->arrTecnico.txtEstadoEnchapes == "no ejecutado"} selected {/if} >No Ejecutado</option>
                                            <option value="ejecucion parcial" {if $claDesembolso->arrTecnico.txtEstadoEnchapes == "ejecucion parcial"} selected {/if}>Ejecución Parcial</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtEnchapes"
                                               name="txtEnchapes"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtEnchapes}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- ACABADOS PISOS -->
                                <tr>
                                    <td>Acabados Pisos</td>
                                    <td align="center">
                                        <select id="txtEstadoAcabados" 
                                                name="txtEstadoAcabados"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="ejecutado" {if $claDesembolso->arrTecnico.txtEstadoAcabados == "ejecutado"} selected {/if} >Ejecutado</option>
                                            <option value="no ejecutado" {if $claDesembolso->arrTecnico.txtEstadoAcabados == "no ejecutado"} selected {/if} >No Ejecutado</option>
                                            <option value="ejecucion parcial" {if $claDesembolso->arrTecnico.txtEstadoAcabados == "ejecucion parcial"} selected {/if}>Ejecución Parcial</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtAcabados"
                                               name="txtAcabados"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtAcabados}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- INSTALACIONES HIDRAULICAS -->
                                <tr>
                                    <td>Instalaciones Hidráulicas</td>
                                    <td align="center">
                                        <select id="txtEstadoHidraulicas" 
                                                name="txtEstadoHidraulicas"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="ejecutado" {if $claDesembolso->arrTecnico.txtEstadoHidraulicas == "ejecutado"} selected {/if} >Ejecutado</option>
                                            <option value="no ejecutado" {if $claDesembolso->arrTecnico.txtEstadoHidraulicas == "no ejecutado"} selected {/if} >No Ejecutado</option>
                                            <option value="ejecucion parcial" {if $claDesembolso->arrTecnico.txtEstadoHidraulicas == "ejecucion parcial"} selected {/if}>Ejecución Parcial</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtHidraulicas"
                                               name="txtHidraulicas"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtHidraulicas}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- INSTALACIONES ELECTRICAS -->
                                <tr>
                                    <td>Instalaciones Eléctricas</td>
                                    <td align="center">
                                        <select id="txtEstadoElectricas" 
                                                name="txtEstadoElectricas"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="ejecutado" {if $claDesembolso->arrTecnico.txtEstadoElectricas == "ejecutado"} selected {/if} >Ejecutado</option>
                                            <option value="no ejecutado" {if $claDesembolso->arrTecnico.txtEstadoElectricas == "no ejecutado"} selected {/if} >No Ejecutado</option>
                                            <option value="ejecucion parcial" {if $claDesembolso->arrTecnico.txtEstadoElectricas == "ejecucion parcial"} selected {/if}>Ejecución Parcial</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtElectricas"
                                               name="txtElectricas"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtElectricas}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- INSTALACIONES SANITARIAS -->
                                <tr>
                                    <td>Instalaciones Sanitarias</td>
                                    <td align="center">
                                        <select id="txtEstadoSanitarias" 
                                                name="txtEstadoSanitarias"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="ejecutado" {if $claDesembolso->arrTecnico.txtEstadoSanitarias == "ejecutado"} selected {/if} >Ejecutado</option>
                                            <option value="no ejecutado" {if $claDesembolso->arrTecnico.txtEstadoSanitarias == "no ejecutado"} selected {/if} >No Ejecutado</option>
                                            <option value="ejecucion parcial" {if $claDesembolso->arrTecnico.txtEstadoSanitarias == "ejecucion parcial"} selected {/if}>Ejecución Parcial</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtSanitarias"
                                               name="txtSanitarias"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtSanitarias}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- INSTALACIONES DE GAS -->
                                <tr>
                                    <td>Instalaciones de Gas</td>
                                    <td align="center">
                                        <select id="txtEstadoGas" 
                                                name="txtEstadoGas"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="ejecutado" {if $claDesembolso->arrTecnico.txtEstadoGas == "ejecutado"} selected {/if} >Ejecutado</option>
                                            <option value="no ejecutado" {if $claDesembolso->arrTecnico.txtEstadoGas == "no ejecutado"} selected {/if} >No Ejecutado</option>
                                            <option value="ejecucion parcial" {if $claDesembolso->arrTecnico.txtEstadoGas == "ejecucion parcial"} selected {/if}>Ejecución Parcial</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtGas"
                                               name="txtGas"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtGas}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- CARPINTERIA MADERA -->
                                <tr>
                                    <td>Carpinteria Madera</td>
                                    <td align="center">
                                        <select id="txtEstadoMadera" 
                                                name="txtEstadoMadera"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="ejecutado" {if $claDesembolso->arrTecnico.txtEstadoMadera == "ejecutado"} selected {/if} >Ejecutado</option>
                                            <option value="no ejecutado" {if $claDesembolso->arrTecnico.txtEstadoMadera == "no ejecutado"} selected {/if} >No Ejecutado</option>
                                            <option value="ejecucion parcial" {if $claDesembolso->arrTecnico.txtEstadoMadera == "ejecucion parcial"} selected {/if}>Ejecución Parcial</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtMadera"
                                               name="txtMadera"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtMadera}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- CARPINTERIA METALICA -->
                                <tr>
                                    <td>Carpinteria Metalica</td>
                                    <td align="center">
                                        <select id="txtEstadoMetalica" 
                                                name="txtEstadoMetalica"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="ejecutado" {if $claDesembolso->arrTecnico.txtEstadoMetalica == "ejecutado"} selected {/if} >Ejecutado</option>
                                            <option value="no ejecutado" {if $claDesembolso->arrTecnico.txtEstadoMetalica == "no ejecutado"} selected {/if} >No Ejecutado</option>
                                            <option value="ejecucion parcial" {if $claDesembolso->arrTecnico.txtEstadoMetalica == "ejecucion parcial"} selected {/if}>Ejecución Parcial</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtMetalica"
                                               name="txtMetalica"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtMetalica}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- LAVADERO -->
                                <tr>
                                    <td>Lavadero</td>
                                    <td align="center">
                                        <input type="text"
                                               id="numLavadero"
                                               name="numLavadero"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);"
                                               style="width:150px; text-align: right;"
                                               maxlength="2"
                                               value="{$claDesembolso->arrTecnico.numLavadero}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtLavadero"
                                               name="txtLavadero"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtLavadero}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- LAVAPLATOS -->
                                <tr>
                                    <td>Lavaplatos</td>
                                    <td align="center">
                                        <input type="text"
                                               id="numLavaplatos"
                                               name="numLavaplatos"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);"
                                               style="width:150px; text-align: right;"
                                               maxlength="2"
                                               value="{$claDesembolso->arrTecnico.numLavaplatos}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtLavaplatos"
                                               name="txtLavaplatos"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtLavaplatos}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- Lavamanos -->
                                <tr>
                                    <td>Lavamanos</td>
                                    <td align="center">
                                        <input type="text"
                                               id="numLavamanos"
                                               name="numLavamanos"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);"
                                               style="width:150px; text-align: right;"
                                               maxlength="2"
                                               value="{$claDesembolso->arrTecnico.numLavamanos}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtLavamanos"
                                               name="txtLavamanos"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtLavamanos}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- Sanitario -->
                                <tr>
                                    <td>Sanitario</td>
                                    <td align="center">
                                        <input type="text"
                                               id="numSanitario"
                                               name="numSanitario"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);"
                                               style="width:150px; text-align: right;"
                                               maxlength="2"
                                               value="{$claDesembolso->arrTecnico.numSanitario}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtSanitario"
                                               name="txtSanitario"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtSanitario}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- Ducha -->
                                <tr>
                                    <td>Ducha</td>
                                    <td align="center">
                                        <input type="text"
                                               id="numDucha"
                                               name="numDucha"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);"
                                               style="width:150px; text-align: right;"
                                               maxlength="2"
                                               value="{$claDesembolso->arrTecnico.numDucha}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtDucha"
                                               name="txtDucha"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtDucha}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- VIDRIOS -->
                                <tr>
                                    <td>Vidrios</td>
                                    <td align="center">
                                        <select id="txtEstadoVidrios" 
                                                name="txtEstadoVidrios"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width:150px;" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="si" {if $claDesembolso->arrTecnico.txtEstadoVidrios == "si"} selected {/if} >Si</option>
                                            <option value="no" {if $claDesembolso->arrTecnico.txtEstadoVidrios == "no"} selected {/if} >No</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtVidrios"
                                               name="txtVidrios"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtVidrios}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- pintura -->
                                <tr>
                                    <td>Pintura</td>
                                    <td align="center">
                                        <select id="txtEstadoPintura" 
                                                name="txtEstadoPintura"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width:150px;" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="si" {if $claDesembolso->arrTecnico.txtEstadoPintura == "si"} selected {/if} >Si</option>
                                            <option value="no" {if $claDesembolso->arrTecnico.txtEstadoPintura == "no"} selected {/if} >No</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtPintura"
                                               name="txtPintura"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtPintura}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- Otros -->
                                <tr>
                                    <td>Otros</td>
                                    <td align="center">
                                        <input type="text"
                                               id="txtOtros"
                                               name="txtOtros"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:150px;"
                                               value="{$claDesembolso->arrTecnico.txtOtros}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtObservacionOtros"
                                               name="txtObservacionOtros"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtObservacionOtros}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                            </table>

                        </div>
                        <!-- PESTANA DE SERVICIOS PUBLICOS Y AMOBLAMIENTO -->			
                        <div id="spu" style="height:{$numAlturaInterna};">	

                            <table cellpadding="2" cellspacing="0" border="0" width="100%"> 
                                <tr>
                                    <td class="tituloTabla" width="150px">Descripción</td>
                                    <td class="tituloTabla" width="100px">Contador</td>
                                    <td class="tituloTabla" width="150px">Estado Conexión</td>
                                    <td class="tituloTabla" >Observaciones</td>
                                </tr>

                                <!-- Servicio de agua -->
                                <tr>
                                    <td>Servicio de Agua</td>
                                    <td>
                                        <input type="text"
                                               id="numContadorAgua"
                                               name="numContadorAgua"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"                                                
                                               style="width:100px; text-align: right;"
                                               value="{$claDesembolso->arrTecnico.numContadorAgua}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td align="center">
                                        <select id="txtEstadoConexionAgua" 
                                                name="txtEstadoConexionAgua"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width:150px;" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="provisional" {if $claDesembolso->arrTecnico.txtEstadoConexionAgua == "provisional"} selected {/if} >Provisional</option>
                                            <option value="definitivo" {if $claDesembolso->arrTecnico.txtEstadoConexionAgua == "definitivo"} selected {/if} >Definitivo</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtDescripcionAgua"
                                               name="txtDescripcionAgua"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtDescripcionAgua}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- Servicio de energia -->
                                <tr>
                                    <td>Servicio de Energía</td>
                                    <td>
                                        <input type="text"
                                               id="numContadorEnergia"
                                               name="numContadorEnergia"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);"
                                               style="width:100px; text-align: right;"
                                               value="{$claDesembolso->arrTecnico.numContadorEnergia}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td align="center">
                                        <select id="txtEstadoConexionEnergia" 
                                                name="txtEstadoConexionEnergia"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width:150px;" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="provisional" {if $claDesembolso->arrTecnico.txtEstadoConexionEnergia == "provisional"} selected {/if} >Provisional</option>
                                            <option value="definitivo" {if $claDesembolso->arrTecnico.txtEstadoConexionEnergia == "definitivo"} selected {/if} >Definitivo</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtDescripcionEnergia"
                                               name="txtDescripcionEnergia"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtDescripcionEnergia}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- Servicio de alcantarillado -->
                                <tr>
                                    <td>Servicio de Alcantarillado</td>
                                    <td>
                                        <input type="text"
                                               id="numContadorAlcantarillado"
                                               name="numContadorAlcantarillado"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);"
                                               style="width:100px; text-align: right;"
                                               value="{$claDesembolso->arrTecnico.numContadorAlcantarillado}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td align="center">
                                        <select id="txtEstadoConexionAlcantarillado" 
                                                name="txtEstadoConexionAlcantarillado"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width:150px;" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="provisional" {if $claDesembolso->arrTecnico.txtEstadoConexionAlcantarillado == "provisional"} selected {/if} >Provisional</option>
                                            <option value="definitivo" {if $claDesembolso->arrTecnico.txtEstadoConexionAlcantarillado == "definitivo"} selected {/if} >Definitivo</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtDescripcionAlcantarillado"
                                               name="txtDescripcionAlcantarillado"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtDescripcionAlcantarillado}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- Servicio de gas -->
                                <tr>
                                    <td>Servicio de Gas</td>
                                    <td>
                                        <input type="text"
                                               id="numContadorGas"
                                               name="numContadorGas"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);"
                                               style="width:100px; text-align: right;"
                                               value="{$claDesembolso->arrTecnico.numContadorGas}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td align="center">
                                        <select id="txtEstadoConexionGas" 
                                                name="txtEstadoConexionGas"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width:150px;" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="provisional" {if $claDesembolso->arrTecnico.txtEstadoConexionGas == "provisional"} selected {/if} >Provisional</option>
                                            <option value="definitivo" {if $claDesembolso->arrTecnico.txtEstadoConexionGas == "definitivo"} selected {/if} >Definitivo</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtDescripcionGas"
                                               name="txtDescripcionGas"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtDescripcionGas}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- Servicio de telefonico -->
                                <tr>
                                    <td>Servicio de Teléfono</td>
                                    <td>
                                        <input type="text"
                                               id="numContadorTelefono"
                                               name="numContadorTelefono"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       soloNumeros(this);"
                                               style="width:100px; text-align: right;"
                                               value="{$claDesembolso->arrTecnico.numContadorTelefono}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                    <td align="center">
                                        <select id="txtEstadoConexionTelefono" 
                                                name="txtEstadoConexionTelefono"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width:150px;" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="si" {if $claDesembolso->arrTecnico.txtEstadoConexionTelefono == "si"} selected {/if} >Si</option>
                                            <option value="no" {if $claDesembolso->arrTecnico.txtEstadoConexionTelefono == "no"} selected {/if} >No</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtDescripcionTelefono"
                                               name="txtDescripcionTelefono"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtDescripcionTelefono}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- Andenes -->
                                <tr>
                                    <td>Andenes</td>
                                    <td>
                                        &nbsp;
                                    </td>
                                    <td align="center">
                                        <select id="txtEstadoAndenes" 
                                                name="txtEstadoAndenes"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width:150px;" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="construidos" {if $claDesembolso->arrTecnico.txtEstadoAndenes == "construidos"} selected {/if} >Construidos</option>
                                            <option value="no construidos" {if $claDesembolso->arrTecnico.txtEstadoAndenes == "no construidos"} selected {/if} >No Construidos</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtDescripcionAndenes"
                                               name="txtDescripcionAndenes"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtDescripcionAndenes}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- Vias -->
                                <tr>
                                    <td>Vias</td>
                                    <td>
                                        &nbsp;
                                    </td>
                                    <td align="center">
                                        <select id="txtEstadoVias" 
                                                name="txtEstadoVias"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width:150px;" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="pavimentadas" {if $claDesembolso->arrTecnico.txtEstadoVias == "pavimentadas"} selected {/if} >Pavimentadas</option>
                                            <option value="no pavimentadas" {if $claDesembolso->arrTecnico.txtEstadoVias == "no pavimentadas"} selected {/if} >No Pavimentadas</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtDescripcionVias"
                                               name="txtDescripcionVias"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtDescripcionVias}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>

                                <!-- Servicios Comunales -->
                                <tr>
                                    <td>Servicios Comunales</td>
                                    <td>
                                        &nbsp;
                                    </td>
                                    <td align="center">
                                        <select id="txtEstadoServiciosComunales" 
                                                name="txtEstadoServiciosComunales"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width:150px;" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="construidos" {if $claDesembolso->arrTecnico.txtEstadoServiciosComunales == "construidos"} selected {/if} >Construidos</option>
                                            <option value="no construidos" {if $claDesembolso->arrTecnico.txtEstadoServiciosComunales == "no construidos"} selected {/if} >No Construidos</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <input type="text"
                                               id="txtDescripcionServiciosComunales"
                                               name="txtDescripcionServiciosComunales"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';
                                                       sinCaracteresEspeciales(this);"
                                               style="width:97%"
                                               class="inputLogin"
                                               value="{$claDesembolso->arrTecnico.txtDescripcionServiciosComunales}" 
                                               {if $seqTipoEsquema ==1}disabled{/if}
                                               />
                                    </td>
                                </tr>


                                <!-- Descripcion de la vivienda -->
                                <tr>
                                    <td>Descripción de la vivienda</td>
                                    <td align="center" colspan="4">
                                        <textarea name="txtDescripcionVivienda" 
                                                  style="width:96%"
                                                  onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                  onBlur="this.style.backgroundColor = '#FFFFFF';
                                                          sinCaracteresEspeciales(this);" 
                                                  {if $seqTipoEsquema ==1}disabled{/if}
                                                  >{$claDesembolso->arrTecnico.txtDescripcionVivienda}</textarea>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                            </table>


                            <table cellpadding="2" cellspacing="0" border="0" width="100%"> 
                                <tr>
                                    <td width="420px">Cumple la vivienda con los requisitos de existencia y habitabilidad</td>
                                    <td>
                                        <select id="txtExistencia" 
                                                name="txtExistencia"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width:150px;" 
                                                {if $seqTipoEsquema ==1}disabled{/if}
                                                ><option value="">Seleccione</option>
                                            <option value="si" {if strtoupper($claDesembolso->arrTecnico.txtExistencia) == "SI"} selected {/if} >Sí</option>
                                            <option value="no" {if strtoupper($claDesembolso->arrTecnico.txtExistencia) == "NO"} selected {/if} >No</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Recomendaciones</b>
                                        <textarea name="txtDescripcionExistencia"
                                                  id="txtDescripcionExistencia" 
                                                  style="width:96%; height: 100px;"
                                                  onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                  onBlur="this.style.backgroundColor = '#FFFFFF';
                                                          sinCaracteresEspeciales(this);" 
                                                  {if $seqTipoEsquema ==1}disabled{/if}
                                                  >{$claDesembolso->arrTecnico.txtDescripcionExistencia}</textarea>
                                    </td>
                                </tr>
                            </table>

                            <!-- VARIABLES ELIMINADAS QUE SIGUEN EXISTIENDO EN LA BASE DE DATOS -->
                            <input type="hidden" value = "{$claDesembolso->arrTecnico.txtNormaNSR98}" name = "txtNormaNSR98"  id="txtNormaNSR98" >
                            <input type="hidden" value = "{$claDesembolso->arrTecnico.txtRequisitos}" name = "txtRequisitos"  id="txtRequisitos">
                            <input type="hidden" value = "{$claDesembolso->arrTecnico.txtDescipcionNormaNSR98}" name = "txtDescipcionNormaNSR98"  id="txtDescipcionNormaNSR98">
                            <input type="hidden" value = "{$claDesembolso->arrTecnico.txtDescripcionRequisitos}" name = "txtDescripcionRequisitos"  id="txtDescripcionRequisitos">

                        </div>
                        <!-- PESTANA DE REGISTRO FOTOGRAFICO -->			
                        <div id="rfo" style="height:{$numAlturaInterna}; overflow:auto"><p>	

                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td align="center" valign="middle" width="50px">
                                        {if $seqTipoEsquema !=1}
                                            <button type="button" 
                                                    id="linkCargaArchivosDesembolso" 
                                                    title="adicionar" 
                                                    class="reporteador"
                                                    >
                                                <img src="./recursos/imagenes/plus_icon.gif" width="14" height="15" alt="Adicionar" align="center">
                                            </button>
                                        {/if}
                                    </td>
                                    <td align="justify" style="padding-right:50px">
                                        A continuación verá el listado de imagenes cargadas para este hogar
                                        haga Click en el boton para cargar mas imagenes, si desea borrar una
                                        de las imágenes de click en la X al lado de la imagen que desea eliminar.<br><br>
                                        Para ver una imagen en su tamaño original haga click sobre la miniatura.
                                    </td>

                                </tr>
                                <tr>
                                    <td height="20px" colspan="2">
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center">
                                        <div style="overflow:auto; text-align:left; width:700px; padding-top: 10px; padding-bottom: 10px; border: 1px dotted #999999; ">
                                            <table cellspacing="0" cellpadding="0" border="0">
                                                <tr id="contenedorImagenes">
                                                    {foreach from=$claDesembolso->arrTecnico.imagenes item=arrImagen}
                                                        <td	id="{$arrImagen.ruta}" 
                                                            align="center" 
                                                            style="padding-left:10px; padding-rigth:10px"
                                                            >
                                                            {if $seqTipoEsquema !=1}
                                                                <div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; float:left"
                                                                     onMouseOver="this.style.backgroundColor = '#FFA4A4';"
                                                                     onMouseOut="this.style.backgroundColor = '#F9F9F9'"
                                                                     onClick="
                                                                             eliminarObjeto('{$arrImagen.ruta}');
                                                                             cargarContenido('mensajes', './contenidos/desembolso/eliminarArchivosDesemboslo.php', 'ruta={$arrImagen.ruta}', true);
                                                                     "
                                                                     >X</div>
                                                            {/if}
                                                            {$arrImagen.nombre}<hr>
                                                            <img src="./recursos/imagenes/desembolsos/{$arrImagen.ruta}" width='120px' height='120px' onClick="tamanoOriginal('{$arrImagen.ruta}', '{$arrImagen.nombre}');" style="cursor:pointer">
                                                            <input type='hidden' name='nombreArchivoCargado[]' value='{$arrImagen.ruta}'>
                                                            <input type='hidden' name='textoArchivoCargado[]' value='{$arrImagen.nombre}'>
                                                            <div id="ver{$arrImagen.ruta}"></div>
                                                        </td>
                                                    {/foreach}
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            </p></div>
                    </div>
                </div>
            </div>
        {/if}
        <!-- PESTANA DE SEGUIMIENTO -->			
        <div id="seg" style="height:{$numAltura}; overflow:auto;"><p>
                {include file="seguimiento/seguimientoFormulario.tpl"}
            <p><div id="contenidoBusqueda">
                {include file="seguimiento/buscarSeguimiento.tpl"}
            </div></p>
            <input type="hidden" id="seqFormularioEditar" value="{$seqFormulario}">
            </p></div>	

        <!-- PESTAÑA ACTOS ADMINISTRATIVOS -->	        
        <div id="aad" style="height:{$numAltura};"><p>
                {include file="subsidios/actosAdministrativos.tpl"}
            </p></div>

    </div>
</div>

<!-- LISTENER PARA ACTIVAR EL CUADRO DE DIALOGO -->
<div id="listenerCargaArchivosDesembolso"></div>
<div id="listenerRevisionTecnica"></div>
<div id="listenerBuscarUsuario">tecnico</div>
