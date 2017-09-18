{assign var=seqModalidad     value=$claFormulario->seqModalidad}
{assign var=seqSolucion      value=$claFormulario->seqSolucion}		
{assign var=seqLocalidad     value=$claFormulario->seqLocalidad}
{assign var=seqEstadoProceso value=$claFormulario->seqEstadoProceso}

{assign var=seqBancoCuentaAhorro  value=$claFormulario->seqBancoCuentaAhorro}
{assign var=seqBancoCuentaAhorro2 value=$claFormulario->seqBancoCuentaAhorro2}
{assign var=seqBancoCredito       value=$claFormulario->seqBancoCredito}
{assign var=seqEntidadDonante     value=$claFormulario->seqEmpresaDonante}

{assign var=seqBancoVendedor value=$claDesembolso->arrEscrituracion.seqBanco}

{assign var=tipoDocCiudadano value=$claCiudadano->seqTipoDocumento}
{assign var=tipoDocVendedor value=$claDesembolso->arrEscrituracion.seqTipoDocumento}

{assign var=numAltura value=550}
{math equation=x-50 x=$numAltura assign=numAlturaInterna}
<div id="revTecGen" class="yui-navset" style="width:98%; height:{$numAltura}; text-align:left;">
    <ul class="yui-nav">
        <li class="selected"><a href="#dho"><em>Datos del Hogar</em></a></li>
        <li><a href="#sde"><em>Solicitud Desembolso</em></a></li>
        {if $seqModalidad == 5} <li><a href="#cap"><em>Consignaciones CAP</em></a></li> {/if}
        <li><a href="#seg"><em>Seguimiento</em></a></li>
        <li><a href="#aad"><em>Actos Administrativos</em></a></li>
    </ul>  
    <div class="yui-content">
        <!-- PESTANA DE DATOS DEL HOGAR -->
        <div id="dho" style="height:{$numAltura};">
            {include file="desembolso/pestanaDatosHogar.tpl"}				
        </div>
        <!-- PESTANA SOLICITUD DE DESEMBOLSOS -->
        <div id="sde" style="height:{$numAltura};">

            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td width="150px" valign="top">
                        <table cellpadding="2" cellspacing="0" border="0" width="100%" id="tablaResumen">
                            <tr><td class="tituloTabla">Valor Subsidio</td></tr>
                            <tr><td style="padding-right:10px" align="right">
                                    $ {$claFormulario->valAspiraSubsidio|number_format:0:',':'.'}
                                </td></tr>
                            {if
                            ( $claFormulario->seqModalidad == 6  && $claFormulario->seqTipoEsquema == 7 )  ||
                            ( $claFormulario->seqModalidad == 6  && $claFormulario->seqTipoEsquema == 13 ) ||
                            ( $claFormulario->seqModalidad == 12 && $claFormulario->seqTipoEsquema == 14 ) ||
                            ( $claFormulario->seqModalidad == 12 && $claFormulario->seqTipoEsquema == 15 )
                            }
                                <tr><td class="tituloTabla">Valor Complementario</td></tr>
                                <tr><td style="padding-right:10px" align="right">
                                    $ {$claFormulario->valComplementario|number_format:0:',':'.'}
                                </td></tr>
                            {/if}
                            <tr><td class="tituloTabla">Valor Solicitudes</td></tr>
                            <tr><td style="padding-right:10px" align="right">
                                    $ {$claDesembolso->arrSolicitud.resumen.valSolicitudes|number_format:0:',':'.'}
                                </td></tr>
                            <tr><td class="tituloTabla">Valor Ordenes Pago</td></tr>
                            <tr><td style="padding-right:10px" align="right">
                                    $ {$claDesembolso->arrSolicitud.resumen.valOrdenes|number_format:0:',':'.'}
                                </td></tr>
                            <tr><td class="tituloTabla">Saldo Subsidio</td></tr>
                            <tr><td style="padding-right:10px; padding-bottom:5px; border-bottom: 1px solid #999999;" align="right">

                                    {if
                                    ( $claFormulario->seqModalidad == 6  && $claFormulario->seqTipoEsquema == 7 )  ||
                                    ( $claFormulario->seqModalidad == 6  && $claFormulario->seqTipoEsquema == 13 ) ||
                                    ( $claFormulario->seqModalidad == 12 && $claFormulario->seqTipoEsquema == 14 ) ||
                                    ( $claFormulario->seqModalidad == 12 && $claFormulario->seqTipoEsquema == 15 )
                                    }
                                        {math equation="x + y" x=$claFormulario->valAspiraSubsidio y=$claFormulario->valComplementario assign=valDesembolsos}
                                    {else}
                                        {math equation="x + y" x=$claFormulario->valAspiraSubsidio y=0 assign=valDesembolsos}
                                    {/if}

                                    {assign var=valOrdenesPago value=0}
                                    {if $claDesembolso->arrSolicitud.resumen.valSolicitudes != ""}
                                        {assign var=valOrdenesPago value=$claDesembolso->arrSolicitud.resumen.valSolicitudes}
                                    {/if}

                                    {math equation="x - y" x=$valDesembolsos y=$valOrdenesPago assign=valSaldo}

                                    $ {$valSaldo|number_format:0:',':'.'}


                                </td></tr>

                            {foreach name="solicitud" from=$claDesembolso->arrSolicitud.resumen.fechas key=seqSolicitud item=fchSolicitud}
                                <tr id="{$claDesembolso->seqFormulario}#{$seqSolicitud}"><td
                                        {if $smarty.foreach.solicitud.first} 
                                            style="padding-top:5px; cursor:pointer;"
                                        {else} 
                                            style="cursor:pointer;"
                                        {/if}
                                        onMouseOver="this.style.background = '#e0e0e0'"
                                        onMouseOut="this.style.background = '#F9F9F9'"
                                        onClick="cargarRegistroDesembolso({$claDesembolso->seqFormulario}, {$seqSolicitud});"
                                        >	

                                        <div style="text-align:center; width:10px; height:14px; cursor:pointer; border: 1px solid #999999; float:left"
                                             onMouseOver="this.style.backgroundColor = '#ADD8E6';"
                                             onMouseOut="this.style.backgroundColor = '#F9F9F9'"
                                             onClick="desembolsoSolicitud({$claDesembolso->seqFormulario}, {$seqSolicitud});"
                                             >I</div>
                                        <div style="text-align:center; width:3px; height:14px; float:left"></div>
                                        <div style="text-align:center; width:10px; height:14px; cursor:pointer; border: 1px solid #999999; float:left"
                                             onMouseOver="this.style.backgroundColor = '#FFA4A4';"
                                             onMouseOut="this.style.backgroundColor = '#F9F9F9'"
                                             onClick="eliminarRegistro(
                                                             '{$claDesembolso->seqFormulario}#{$seqSolicitud}',
                                                                             '<center>Esta a punto de eliminar una solicitud de desembolso. Tenga en cuenta que esta acción no se podra deshacer.<br><b>¿ Desea Continuar con la Operación ?</b><br><br><span class=\'msgError\'><input type=\'checkbox\' id=\'borrarAAD\'>&nbsp;Borrar el registro de actos administrativos tambi&eacute;n.</span></center>',
                                                                             './contenidos/desembolso/eliminarSolicitud.php');"
                                             >X</div>
                                        <div style="text-align:center; width:5px; height:14px; float:left"></div>
                                        <div style="widht:15px; padding-top:4px; float:left;">
                                            <img id="imagen-{$seqSolicitud}" src="./recursos/imagenes/bulletRojo.png"/>
                                        </div>

                                        {assign var=fchCreacion      value=$claDesembolso->arrSolicitud.detalles.$seqSolicitud.fchCreacion}
                                        {assign var=fchActualizacion value=$claDesembolso->arrSolicitud.detalles.$seqSolicitud.fchActualizacion}

                                        <div style="width:102px; float:right;" 
                                             onMouseOver="mostrarTooltipSolicitud(this, '{$fchCreacion}', '{$fchActualizacion}')"
                                             >{$fchSolicitud}</div>
                                    </td></tr>
                                {/foreach}
                        </table>
                    </td>
                    <td>
                        <div id="revTecVivUsa" class="yui-navset" style="width:100%; text-align:left;">
                            <ul class="yui-nav">
                                <li class="selected"><a href="#bsu"><em>Datos del Subsidio</em></a></li>
                                <li><a href="#doc"><em>Documentos</em></a></li> 
                            </ul>            
                            <div class="yui-content">

                                <!-- DATOS DEL SUBSIDIO -->
                                <div id="bsu" style="height:{$numAlturaInterna}; overflow:auto">
                                    <table cellpadding="2" cellspacing="0" border="0" width="100%">
                                        <tr><td class="tituloTabla" colspan="2">Datos del Subsidio</td></tr>

                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                            <td width="230px">Modalidad:</td>
                                            <td>{$arrModalidad.$seqModalidad}</td>
                                        </tr>
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                            <td>Tipo de Vivienda:</td>
                                            <td>{$arrSolucionDescripcion.$seqModalidad.$seqSolucion} ( {$arrSolucion.$seqModalidad.$seqSolucion} )</td>
                                        </tr>
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                            <td>Fecha de Asignación:</td>
                                            <td>
                                                {$claDesembolso->arrJuridico.fchResolucion|date_format:"%d de %B del %Y"}
                                                <input type="hidden" name="fchResolucion" value="{$claDesembolso->arrJuridico.fchResolucion}">
                                            </td>
                                        </tr>
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                            <td>Número de Resolución:</td>
                                            <td>
                                                {$claDesembolso->arrJuridico.numResolucion}
                                                <input type="hidden" name="numResolucion" value="{$claDesembolso->arrJuridico.numResolucion}">
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>Fecha de Vigencia</td>
                                            <td>{$claFormulario->fchVigencia}</td>
                                        </tr>
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                            <td>Valor de la Resolución:</td>
                                            <td>$ {$claDesembolso->arrJuridico.valResolucion|number_format}</td>
                                        </tr>
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                            <td valign="top">Proyecto de inversión:</td>

                                            <td>
                                                <div style="position:relative;">
                                                    <input  type="radio"
                                                            name="numProyectoInversion"
                                                            id="proyecto488"
                                                            value="488"
                                                            />
                                                </div>
                                                <div style="position:relative; padding:3px">
                                                    Proyecto 488: {$arrNombreProyectos.488}
                                                </div>

                                                <div style="position:relative;">
                                                    <input  type="radio"
                                                            name="numProyectoInversion"
                                                            id="proyecto644"
                                                            value="644"
                                                            />
                                                </div>
                                                <div style="position:relative; padding:3px">
                                                    Proyecto 644: {$arrNombreProyectos.644}
                                                </div>


                                                <div style="position:relative;">
                                                    <input  type="radio"
                                                            name="numProyectoInversion"
                                                            id="proyecto435"
                                                            value="435"
                                                            />
                                                </div>
                                                <div style="position:relative; padding:3px">
                                                    Proyecto 435: {$arrNombreProyectos.435}
                                                </div>

                                                <div style="position:relative;">
                                                    <input  type="radio"
                                                            name="numProyectoInversion"
                                                            id="proyecto801"
                                                            value="801"
                                                            />
                                                </div>
                                                <div style="position:relative; padding:3px">
                                                    Proyecto 801: {$arrNombreProyectos.801}
                                                </div>
                                                <div style="position:relative;">
                                                    <input  type="radio"
                                                            name="numProyectoInversion"
                                                            id="proyecto1075"
                                                            value="1075"
                                                            />
                                                </div>
                                                <div style="position:relative; padding:3px">
                                                    Proyecto 1075: {$arrNombreProyectos.1075}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}" valign="top">
                                            <td>Registro presupuestal:</td>
                                            <td>
                                                <u><i><a href="#" id="registro1" onClick="recogerValor(['registro1'], 'numero', 'variables')">
                                                            Número Registro
                                                        </a></i></u> del 
                                                <u><i><a href="#" id="fecha1" onClick="calendarioDesembolso(['fecha1'], 'variables');" >
                                                            Fecha Registro
                                                        </a></i></u> <br>
                                                <u><i><a href="#" id="registro2" onClick="recogerValor(['registro2'], 'numero', 'variables')">
                                                            Número Registro
                                                        </a></i></u> del 
                                                <u><i><a href="#" id="fecha2" onClick="calendarioDesembolso(['fecha2'], 'variables');" >
                                                            Fecha Registro
                                                        </a></i></u>
                                            </td>
                                        </tr>
                                        {if not empty( $arrResolucionIndexacion )}
                                            <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                                <td>Fecha de Resolución de Indexación:</td>
                                                <td>{$arrResolucionIndexacion.fecha|date_format:"%d de %B del %Y"}</td>
                                            </tr>
                                            <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                                <td>Número de Resolución de Indexación:</td>
                                                <td>{$arrResolucionIndexacion.numero}</td>
                                            </tr>
                                            <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                                <td>Valor de la Resolución de Indexación:</td>
                                                <td>$ {$arrResolucionIndexacion.valor|number_format}</td>
                                            </tr>
                                            <tr>
                                                <td>Proyecto de Inversión Indexación:</td>
                                                <td>
                                                    {$arrNombreProyectos.488}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Número del Proyecto Indexación:</td>
                                                <td>488</td>
                                            </tr>
                                            <tr>
                                                <td>Registro Presupuestal Indexación:</td>
                                                <td>{$arrResolucionIndexacion.rp} del {$arrResolucionIndexacion.fechaRp|date_format:"%d de %B del %Y"}</td>
                                            </tr>
                                        {/if}
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                            <td>Total Valor del Subsidio:</td>
                                            <td>$ {$claFormulario->valAspiraSubsidio|number_format:0:',':'.'}</td>
                                        </tr>

                                    </table><br>

                                    <!-- BENEFICIARIO DEL PAGO -->
                                    <table cellpadding="2" cellspacing="0" border="0" width="100%">
                                        <tr><td class="tituloTabla" colspan="2">Beneficiario del Pago</td></tr>
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                            <td width="180px">Nombre del Vendedor:</td>
                                            <td>
                                                {if $claDesembolso->arrEscrituracion.txtNombreVendedor != ''}
                                                    {$claDesembolso->arrEscrituracion.txtNombreVendedor}
                                                {else}
                                                    {$claDesembolso->txtNombreVendedor}
                                                {/if}
                                            </td>
                                        </tr>
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                            <td>Documento:</td>
                                            <td>
                                                {if $claDesembolso->arrEscrituracion.numDocumentoVendedor != 0}
                                                    {$arrTipoDocumento.$tipoDocVendedor} {$claDesembolso->arrEscrituracion.numDocumentoVendedor|number_format:0:',':'.'} 
                                                {else}
                                                    {$arrTipoDocumento.$tipoDocVendedor} {$claDesembolso->numDocumentoVendedor|number_format:0:',':'.'} 
                                                {/if}
                                            </td>
                                        </tr>
                                    </table><br>

                                    <!-- BENEFICIARIO DEL GIRO -->
                                    <table cellpadding="2" cellspacing="0" border="0" width="100%">	
                                        <tr><td class="tituloTabla" colspan="2">Beneficiario del Giro</td></tr>
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                            <td width="180px">Nombre Beneficiario Giro:</td>
                                            <td>
                                                <input	type="text" 
                                                       name="txtNombreBeneficiarioGiro" 
                                                       id="txtNombreBeneficiarioGiro"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:200px"
                                                       />
                                            </td>
                                        </tr>
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                            <td width="180px">Documento Beneficiario Giro:</td>
                                            <td>
                                                <input	type="text" 
                                                       name="numDocumentoBeneficiarioGiro" 
                                                       id="numDocumentoBeneficiarioGiro"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: soloNumeros(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:200px"
                                                       />
                                            </td>
                                        </tr>
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                            <td width="180px">
                                                <a href="#" id="Direccion" onClick="recogerDireccion('txtDireccionBeneficiarioGiro', 'objDireccionOcultoBeneficiarioGiro')">Dirección Beneficiario Giro:</a>
                                            </td>
                                            <td>
                                                <input	type="text" 
                                                       name="txtDireccionBeneficiarioGiro" 
                                                       id="txtDireccionBeneficiarioGiro"
                                                       style="width:200px;"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: soloNumeros(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       readonly
                                                       />

                                                <div id="objDireccionOcultoBeneficiarioGiro" style="display:none" />

                                            </td>
                                        </tr>
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                            <td width="180px">Teléfono Beneficiario Giro:</td>
                                            <td>
                                                <input	type="text" 
                                                       name="numTelefonoGiro" 
                                                       id="numTelefonoGiro"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: soloNumeros(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:200px"
                                                       />
                                            </td>
                                        </tr>
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                            <td width="180px">Correo Beneficiario Giro:</td>
                                            <td>
                                                <input	type="text" 
                                                       name="txtCorreoGiro" 
                                                       id="txtCorreoGiro"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:200px"
                                                       />
                                            </td>
                                        </tr>
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">

                                            <td width="180px">Número de Cuenta:</td>
                                            <td>
                                                <input	type="text" 
                                                       name="numCuentaGiro" 
                                                       id="numCuentaGiro"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: soloNumeros(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:200px"
                                                       />
                                            </td>
                                        </tr>
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                            <td>Tipo de Cuenta:</td>
                                            <td>
                                                <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                        onBlur="this.style.backgroundColor = '#FFFFFF';"  
                                                        name="txtTipoCuentaGiro" 
                                                        id="txtTipoCuentaGiro"
                                                        style="width:200px"
                                                        >
                                                    <option value="">Ninguno</option>
                                                    <option value="ahorros">Cuenta de Ahorros</option>
                                                    <option value="corriente">Cuenta Corriente</option>
                                                    <option value="cheque">Cheque</option>
                                                    <option value="deposito judicial">Dep&oacute;sito Judicial</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                            <td>Banco de la Cuenta:</td>
                                            <td>
                                                <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                        onBlur="this.style.backgroundColor = '#FFFFFF';"  
                                                        name="seqBancoGiro" 
                                                        id="seqBancoGiro"
                                                        style="width:300px"
                                                        >
                                                    <option value="1">Ninguno</option>
                                                    {foreach from=$arrBanco key=seqBanco item=txtBanco}
                                                        <option value="{$seqBanco}">{$txtBanco}</option>
                                                    {/foreach}
                                                </select>
                                            </td>
                                        </tr>
                                        <tr bgcolor="{cycle name=c1 values="#FFFFFF,#F0F0F0"}">
                                            <td>Valor del Desembolso:</td>
                                            <td>
                                                <u><i><a href="#" id="valor" onClick="recogerValor(['valor'], 'numero', 'variables')">
                                                            Valor Solicitado
                                                        </a></i></u>
                                            </td>
                                        </tr>
                                    </table>							    		
                                </div>

                                <!-- DOCUMENTOS RADICADOS -->
                                <div id="doc" style="height:{$numAlturaInterna}; overflow:auto">

                                    <table cellpadding="1" cellspacing="0" border="0" width="100%">

                                        <!-- DOCUMENTO DEL BENEFICIARIO -->
                                        <tr>
                                            <td align="center">
                                                <input	type="checkbox" 
                                                       name="bolCedulaBeneficiario" 
                                                       id="bolCedulaBeneficiario"
                                                       value="1"
                                                       {if $claDesembolso->arrSolicitud.bolCedulaBeneficiario == 1} checked {/if}
                                                       />
                                            </td>
                                            <td>Copia del documento del beneficiario</td>
                                            <td>
                                                <input	type="text" 
                                                       name="txtCedulaBeneficiario" 
                                                       id="txtCedulaBeneficiario"
                                                       value="{$claDesembolso->arrSolicitud.txtCedulaBeneficiario}"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: sinCaracteresEspeciales(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:300px"
                                                       class="inputLogin"
                                                       />
                                            </td>
                                        </tr>

                                        {if $claDesembolso->txtTipoDocumentos != "persona" && $claDesembolso->txtTipoDocumentos != ""}

                                            <tr>
                                                <td align="center">
                                                    <input	type="checkbox" 
                                                           name="bolRut" 
                                                           id="bolRut"
                                                           value="1"
                                                           {if $claDesembolso->arrSolicitud.bolRut == 1} checked {/if}
                                                           />
                                                </td>
                                                <td>RUT</td>
                                                <td>
                                                    <input	type="text" 
                                                           name="txtRut" 
                                                           id="txtRut"
                                                           value="{$claDesembolso->arrSolicitud.txtRut}"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="javascript: sinCaracteresEspeciales(this);
                                                                   this.style.backgroundColor = '#FFFFFF';"
                                                           style="width:300px"
                                                           class="inputLogin"
                                                           />
                                                </td>
                                            </tr>

                                            <!-- <tr>
                                                    <td align="center">
                                                            <input	type="checkbox" 
                                                                            name="bolNit" 
                                                                            id="bolNit"
                                                                            value="1"
                                            {if $claDesembolso->arrSolicitud.bolNit == 1} checked {/if}
                    />
            </td>
            <td>NIT</td>
            <td>
                    <input	type="text" 
                                    name="txtNit" 
                                    id="txtNit"
                                    value="{$claDesembolso->arrSolicitud.txtNit}"
                                    onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
                                    style="width:300px"
                                    class="inputLogin"
                    />
            </td>
    </tr> --> 

                                            <tr>
                                                <td align="center">
                                                    <input	type="checkbox" 
                                                           name="bolCedulaRepresentante" 
                                                           id="bolCedulaRepresentante"
                                                           value="1"
                                                           {if $claDesembolso->arrSolicitud.bolCedulaRepresentante == 1} checked {/if}
                                                           />
                                                </td>
                                                <td>Cedula Representante Legal</td>
                                                <td>
                                                    <input	type="text" 
                                                           name="txtCedulaRepresentante" 
                                                           id="txtCedulaRepresentante"
                                                           value="{$claDesembolso->arrSolicitud.txtCedulaRepresentante}"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="javascript: sinCaracteresEspeciales(this);
                                                                   this.style.backgroundColor = '#FFFFFF';"
                                                           style="width:300px"
                                                           class="inputLogin"
                                                           />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <input	type="checkbox" 
                                                           name="bolCamaraComercio" 
                                                           id="bolCamaraComercio"
                                                           value="1"
                                                           {if $claDesembolso->arrSolicitud.bolCamaraComercio == 1} checked {/if}
                                                           />
                                                </td>
                                                <td>Camara de Comercio</td>
                                                <td>
                                                    <input	type="text" 
                                                           name="txtCamaraComercio" 
                                                           id="txtCamaraComercio"
                                                           value="{$claDesembolso->arrSolicitud.txtCamaraComercio}"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="javascript: sinCaracteresEspeciales(this);
                                                                   this.style.backgroundColor = '#FFFFFF';"
                                                           style="width:300px"
                                                           class="inputLogin"
                                                           />
                                                </td>
                                            </tr>


                                        {else}

                                            <tr>
                                                <td align="center">
                                                    <input	type="checkbox" 
                                                           name="bolCedulaVendedor" 
                                                           id="bolCedulaVendedor"
                                                           value="1"
                                                           {if $claDesembolso->arrSolicitud.bolCedulaVendedor == 1} checked {/if}
                                                           />
                                                </td>
                                                <td>Copia del documento del {if $seqModalidad != 5} vendedor {else} arrendador {/if}</td>
                                                <td>
                                                    <input	type="text" 
                                                           name="txtCedulaVendedor" 
                                                           id="txtCedulaVendedor"
                                                           value="{$claDesembolso->arrSolicitud.txtCedulaVendedor}"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="javascript: sinCaracteresEspeciales(this);
                                                                   this.style.backgroundColor = '#FFFFFF';"
                                                           style="width:300px"
                                                           class="inputLogin"
                                                           />
                                                </td>
                                            </tr>


                                        {/if}

                                        <!-- COPIA DE LA CARTA DE ASIGNACION -->
                                        <tr>
                                            <td align="center">
                                                <input	type="checkbox" 
                                                       name="bolCartaAsignacion" 
                                                       id="bolCartaAsignacion"
                                                       value="1"
                                                       {if $claDesembolso->arrSolicitud.bolCartaAsignacion == 1} checked {/if}
                                                       />
                                            </td>
                                            <td>Copia de la carta de asignacion</td>
                                            <td>
                                                <input	type="text" 
                                                       name="txtCartaAsignacion" 
                                                       id="txtCartaAsignacion"
                                                       value="{$claDesembolso->arrSolicitud.txtCartaAsignacion}"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: sinCaracteresEspeciales(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:300px"
                                                       class="inputLogin"
                                                       />
                                            </td>
                                        </tr>

                                        <!-- AUTORIZACION DE GIRO A TERCEROS -->
                                        <tr>
                                            <td align="center">
                                                <input	type="checkbox" 
                                                       name="bolGiroTercero" 
                                                       id="bolGiroTercero"
                                                       value="1"
                                                       {if $claDesembolso->arrSolicitud.bolGiroTercero == 1} checked {/if}
                                                       />
                                            </td>
                                            <td>Autorización de Giro a Terceros</td>
                                            <td>
                                                <input	type="text" 
                                                       name="txtGiroTercero" 
                                                       id="txtGiroTercero"
                                                       value="{$claDesembolso->arrSolicitud.txtGiroTercero}"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: sinCaracteresEspeciales(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:300px"
                                                       class="inputLogin"
                                                       />
                                            </td>
                                        </tr>

                                        <!-- MODALIDADES DIFERENTES A SCA -->
                                        {if $seqModalidad != 5} 

                                            <!-- CERTIFICACION BANCARIA -->
                                            <tr>
                                                <td align="center">
                                                    <input	type="checkbox" 
                                                           name="bolCertificacionBancaria" 
                                                           id="bolCertificacionBancaria"
                                                           value="1"
                                                           {if $claDesembolso->arrSolicitud.bolCertificacionBancaria == 1} checked {/if}
                                                           />
                                                </td>
                                                <td>Certificación bancaria</td>
                                                <td>
                                                    <input	type="text" 
                                                           name="txtCertificacionBancaria" 
                                                           id="txtCertificacionBancaria"
                                                           value="{$claDesembolso->arrSolicitud.txtCertificacionBancaria}"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="javascript: sinCaracteresEspeciales(this);
                                                                   this.style.backgroundColor = '#FFFFFF';"
                                                           style="width:300px"
                                                           class="inputLogin"
                                                           />
                                                </td>
                                            </tr>

                                            <!-- ORIGINAL DE LA AUTORIZACION DE DESEMBOLSO -->
                                            <tr>
                                                <td align="center">
                                                    <input	type="checkbox" 
                                                           name="bolAutorizacion" 
                                                           id="bolAutorizacion"
                                                           value="1"
                                                           {if $claDesembolso->arrSolicitud.bolAutorizacion == 1} checked {/if}
                                                           />
                                                </td>
                                                <td>Original autorizacion de desembolso</td>
                                                <td>
                                                    <input	type="text" 
                                                           name="txtAutorizacion" 
                                                           id="txtAutorizacion"
                                                           value="{$claDesembolso->arrSolicitud.txtAutorizacion}"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="javascript: sinCaracteresEspeciales(this);
                                                                   this.style.backgroundColor = '#FFFFFF';"
                                                           style="width:300px"
                                                           class="inputLogin"
                                                           />
                                                </td>
                                            </tr>

                                            {if $seqModalidad == 3 || $seqModalidad == 4}
                                                <tr>
                                                    <td align="center">
                                                        <input	type="checkbox" 
                                                               name="bolActaEntregaFisica" 
                                                               id="bolActaEntregaFisica"
                                                               value="1"
                                                               {if $claDesembolso->arrSolicitud.bolActaEntregaFisica == 1} checked {/if}
                                                               />
                                                    </td>
                                                    <td>Acta entrega física de la obra</td>
                                                    <td>
                                                        <input	type="text" 
                                                               name="txtActaEntregaFisica" 
                                                               id="txtActaEntregaFisica"
                                                               value="{$claDesembolso->arrSolicitud.txtActaEntregaFisica}"
                                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                               onBlur="javascript: sinCaracteresEspeciales(this);
                                                                       this.style.backgroundColor = '#FFFFFF';"
                                                               style="width:300px"
                                                               class="inputLogin"
                                                               />
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td align="center">
                                                        <input	type="checkbox" 
                                                               name="bolActaLiquidacion" 
                                                               id="bolActaLiquidacion"
                                                               value="1"
                                                               {if $claDesembolso->arrSolicitud.bolActaLiquidacion == 1} checked {/if}
                                                               />
                                                    </td>
                                                    <td>Acta de liquidación</td>
                                                    <td>
                                                        <input	type="text" 
                                                               name="txtActaLiquidacion" 
                                                               id="txtActaLiquidacion"
                                                               value="{$claDesembolso->arrSolicitud.txtActaLiquidacion}"
                                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                               onBlur="javascript: sinCaracteresEspeciales(this);
                                                                       this.style.backgroundColor = '#FFFFFF';"
                                                               style="width:300px"
                                                               class="inputLogin"
                                                               />
                                                    </td>
                                                </tr>
                                            {/if}

                                        {else}

                                            <!-- CERTIFICACION BANCARIA DEL ARRENDADOR -->
                                            <tr>
                                                <td align="center">
                                                    <input	type="checkbox" 
                                                           name="bolBancoArrendador" 
                                                           id="bolBancoArrendador"
                                                           value="1"
                                                           {if $claDesembolso->arrSolicitud.bolBancoArrendador == 1} checked {/if}
                                                           />
                                                </td>
                                                <td>Certificación Bancaria del Arrendador</td>
                                                <td>
                                                    <input	type="text" 
                                                           name="txtBancoArrendador" 
                                                           id="txtBancoArrendador"
                                                           value="{$claDesembolso->arrSolicitud.txtBancoArrendador}"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="javascript: sinCaracteresEspeciales(this);
                                                                   this.style.backgroundColor = '#FFFFFF';"
                                                           style="width:300px"
                                                           class="inputLogin"
                                                           />
                                                </td>
                                            </tr>

                                        {/if}

                                    </table>
                                    <br>
                                    <table cellpadding="1" cellspacing="0" border="0" width="100%">
                                        <tr>
                                            <td class="tituloTabla" colspan="2">Subsecretaria de Gestión Financiera</td>
                                            <td class="tituloTabla" colspan="2">Subdirección de Recursos Públicos</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left:10px; padding-top:5px;" width="70px">Nombre</td>
                                            <td style="padding-left:5px; padding-top:2px;" >
                                                <input type="text"
                                                       name="txtSubsecretaria"
                                                       id="txtSubsecretaria"
                                                       value="{$claDesembolso->arrSolicitud.txtSubsecretaria|upper}"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: sinCaracteresEspeciales(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:90%"
                                                       />
                                            </td>


                                            <td style="padding-left:10px; padding-top:5px;" width="70px">Nombre</td>
                                            <td style="padding-left:5px; padding-top:5px;">
                                                <input type="text"
                                                       name="txtSubdireccion"
                                                       id="txtSubdireccion"
                                                       value="{$claDesembolso->arrSolicitud.txtSubdireccion|upper}"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: sinCaracteresEspeciales(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:90%"
                                                       /> 
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="padding-left:10px">	
                                                Encargado 
                                            </td>
                                            <td>
                                                <input type="checkbox"
                                                       name="bolSubsecretariaEncargado"
                                                       id="bolSubsecretariaEncargado"
                                                       value="1"
                                                       {if $claDesembolso->arrSolicitud.bolSubsecretariaEncargado == 1} checked {/if}
                                                       />
                                            </td>

                                            <td style="padding-left:10px">
                                                Encargado
                                            </td>
                                            <td> 
                                                <input type="checkbox"
                                                       name="bolSubdireccionEncargado"
                                                       id="bolSubdireccionEncargado"
                                                       value="1"
                                                       {if $claDesembolso->arrSolicitud.bolSubdireccionEncargado == 1} checked {/if}
                                                       />	
                                            </td>

                                        </tr>
                                        <tr>
                                            <td style="padding-left:10px;">Elaboró:</td>
                                            <td style="padding-left:5px;">
                                                <input type="text"
                                                       name="txtRevisoSubsecretaria"
                                                       id="txtRevisoSubsecretaria"                                                                       
                                                       value="---"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: sinCaracteresEspeciales(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:90%"
                                                       />
                                                <input type="hidden" name="usuario" value="{$txtUsuarioSesion}">
                                            </td>
                                        </tr>
                                    </table>							    		
                                    <br>
                                    <table cellpadding="2" cellspacing="0" border="0" width="100%">
                                        <tr>
                                            <td class="tituloTabla" colspan="6">
                                                Datos de Radicación
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="50px">Número</td>
                                            <td width="120px">
                                                <u><i><a href="#" id="numeroRadicado" onClick="recogerValor(['numeroRadicado'], 'numero', 'variables')">
                                                            Número Radicación
                                                        </a></i></u>
                                            </td>
                                            <td width="40px">Fecha</td>
                                            <td colspan="3">
                                                <u><i><a href="#" id="fechaRadicado" onClick="calendarioDesembolso(['fechaRadicado'], 'variables');" >
                                                            Fecha Radicación
                                                        </a></i></u>
                                            </td>
                                        </tr>
                                        <tr><td colspan="6">&nbsp;</td></tr>
                                        <tr>
                                            <td class="tituloTabla" colspan="6">
                                                Datos de Orden de Pago
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Número</td>
                                            <td>
                                                <u><i><a href="#" id="numeroOrden" onClick="recogerValor(['numeroOrden'], 'numero', 'variables')">
                                                            Número Pago
                                                        </a></i></u>
                                            </td>
                                            <td>Fecha</td>
                                            <td>
                                                <u><i><a href="#" id="fechaOrden" onClick="calendarioDesembolso(['fechaOrden'], 'variables');" >
                                                            Fecha Pago
                                                        </a></i></u>
                                            </td>
                                            <td width="40px">Monto</td>
                                            <td width="120px">
                                                <u><i><a href="#" id="monto" onClick="recogerValor(['monto'], 'numero', 'variables')">
                                                            Valor Pagado
                                                        </a></i></u>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

        </div>

        <!-- PESTANA CONSIGNACIONES CAP (CUENTA DE AHORRO PROGRAMADO) --> 			
        {if $seqModalidad == 5}
            <div id="cap" style="height:{$numAltura}; overflow:auto">

                <table cellpadding="2" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td class="tituloTabla">
                            Relación de las consignaciones realizadas por el hogar a la cuenta de ahorro programado
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <table cellpadding="2" cellspacing="0" border="0" width="100%" id="datosConsignacion">
                                {foreach from=$claDesembolso->arrConsignaciones key=seqConsignacion item=arrConsignacion}
                                    {assign var=seqBancoConsignacion value=$arrConsignacion.seqBancoConsignacion}
                                    <tr id="{$seqConsignacion}">
                                        <td valign="top">
                                            <div style="text-align:center; width:10px; height:14px; cursor:pointer; border: 1px solid #999999; float:left"
                                                 onMouseOver="this.style.backgroundColor = '#FFA4A4';"
                                                 onMouseOut="this.style.backgroundColor = '#F9F9F9'"
                                                 onClick="eliminarRegistro(
                                                                 '{$claDesembolso->seqFormulario}#{$seqConsignacion}',
                                                                                 '<center>Esta a punto de eliminar un registro de consignacion. Tenga en cuenta que esta acción no se podra deshacer.<br><b>¿ Desea Continuar con la Operación ?</b></center>',
                                                                                 './contenidos/desembolso/eliminarConsignacion.php');"
                                                 >X</div>
                                        </td>
                                        <td>
                                            <b>A Nombre de:</b> {$arrConsignacion.txtNombreConsignacion}<br>
                                            <b>Fecha:</b> {$arrConsignacion.fchConsignacion}<br>
                                            <b>Valor:</b> {$arrConsignacion.valConsignacion|number_format:0:',':'.'}<br>
                                            <b>Banco:</b> {$arrBanco.$seqBancoConsignacion}<br>
                                            <b>No Cuenta:</b> {$arrConsignacion.numCuenta}<br>
                                        </td>
                                    </tr>
                                {/foreach}
                            </table>
                        </td>
                    </tr>
                </table>

            </div>
        {/if}

        <!-- PESTANA DE SEGUIMIENTO -->			
        <div id="seg" style="height:{$numAltura}; overflow:auto;"><p>
                {include file="seguimiento/seguimientoFormulario.tpl"}
            <p><div id="contenidoBusqueda">
                {include file="seguimiento/buscarSeguimiento.tpl"}
            </div></p>
            </p></div>	

        <!-- PESTAÑA ACTOS ADMINISTRATIVOS -->	        
        <div id="aad" style="height:{$numAltura};"><p>
                {include file="subsidios/actosAdministrativos.tpl"}
            </p></div>

    </div>
</div>

<div id="listenerRevisionTecnica"></div>		
<div id="variables"></div>	
<input type="hidden" id="seqSolicitudEditar" name="seqSolicitudEditar" value=""> 
