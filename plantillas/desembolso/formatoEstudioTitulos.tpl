{assign var=tipoDocCiudadano value=$claCiudadano->seqTipoDocumento}
{assign var=tipoDocVendedor value=$claDesembolso->seqTipoDocumento}
{assign var=seqModalidad value=$claFormulario->seqModalidad}
{assign var=seqProyecto value=$claFormulario->seqProyecto}
{assign var=seqLocalidad value=$claDesembolso->seqLocalidad}
{assign var=seqSolucion value=$claFormulario->seqSolucion}
{assign var=txtElaboro value=$claDesembolso->arrTitulos.txtElaboro}

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="title" content="Subsidios de Vivienda">
            <meta name="keywords" content="subsidio,vivienda,social,prioritaria,bogota,habitat,asignacion,credito" />
            <meta name="description" content="Sistema de informacion de subsidios de vivienda"/>
            <meta http-equiv="Content-Language" content="es"/>
            <meta name="robots" content="index,  nofollow" />
            <title>SDV - SDHT</title>

    </head>
    <body onLoad="window.print();">

        <center>

            <!-- TITULO DE LA CARTA DE IMPRESION -->
            <table cellspacing="0" cellpadding="0" border="0" width="90%" style="border: 1px solid #999999;">
                <tr>
                    <td width="150px" height="80px" align="center" valign="middle"><img src="../../recursos/imagenes/escudo.png"></td>
                    <td align="center" valign="middle" style="{$txtFuente12} padding:10px;">
                        <b>ALCALDIA MAYOR DE BOGOTA</b><br>
                            SECRETARIA DEL HABITAT<br>
                                PROGRAMA INTEGRAL DE VIVIENDA EFECTIVA (PIVE)<br><br>

                                        <span style="{$txtFuente10}">
                                            Fecha de Radicaci&oacute;n: {$txtFecha}<br/>
                                            No. Registro: {$numRegistro|number_format:0:'.':','}
                                        </span>
                                        </td>
                                        <td width="150px" align="center" valign="middle"><img src="../../recursos/imagenes/bta_positiva_carta.jpg"></td>
                                        </tr>
                                        </table>	
                                        <br/>

                                        <table cellpadding="2" cellspacing="0" border="0" width="90%" style="{$txtFuente12}">
                                            <tr><td align="center" style="padding-left:30px; padding-right:30px; font-weight:bold;">
                                                    {if $seqModalidad eq "5"}
                                                        <b>Proceso de Desembolso. Concepto Jurídico Contrato</b><br/>
                                                        Subsidio Condicionado de Arrendamiento
                                                    {else}
                                                        <b>Proceso de Desembolso. Estudio de Títulos</b><br/>
                                                        Vivienda {$claDesembolso->txtCompraVivienda|ucwords}</b>
                                                    {/if}
                                                </td></tr>
                                        </table>

                                        <table cellpadding="5" cellspacing="0" border="0" width="90%" style="border: 1px solid #E4E4E4; {$txtFuente10}">

                                            <!-- FECHA DEL ESTUDIO DE TITULOS -->
                                            <tr>
                                                <td bgcolor="#E4E4E4"><b>Fecha</b></td>
                                                <td>{$txtFecha}</td>
                                            </tr>

                                            <!-- POSTULANTE PRINCIPAL -->
                                            <tr>
                                                <td bgcolor="#E4E4E4"><b>Postulante Principal</b></td>
                                                <td>
                                                    {$claCiudadano->txtNombre1} {$claCiudadano->txtNombre2}
                                                    {$claCiudadano->txtApellido1} {$claCiudadano->txtApellido2} / 
                                                    {$arrTipoDocumento.$tipoDocCiudadano} {$claCiudadano->numDocumento}
                                                </td>
                                            </tr>

                                            <!-- PROPERTARIO -->
                                            <tr>
                                                <td bgcolor="#E4E4E4"><b>{if $seqModalidad eq "5"}Arrendador{else}Vendedor{/if}</b></td>
                                                <td>
                                                    {if $claDesembolso->arrEscrituracion.txtNombreVendedor != ""}
                                                        {$claDesembolso->arrEscrituracion.txtNombreVendedor}
                                                    {else}
                                                        {$claDesembolso->txtNombreVendedor}
                                                    {/if} / {$arrTipoDocumento.$tipoDocVendedor} 
                                                    {if $claDesembolso->arrEscrituracion.numDocumentoVendedor != ""}
                                                        {$claDesembolso->arrEscrituracion.numDocumentoVendedor|number_format:0:',':'.'}
                                                    {else}
                                                        {$claDesembolso->numDocumentoVendedor|number_format:0:',':'.'}
                                                    {/if}
                                                </td>
                                            </tr>

                                            <!-- PROYECTO EPI (se muestra si esquema es 1)-->
                                            {if $nombreComercial != '' || $arrProyectos.$seqProyecto != ''}
                                                <tr>
                                                    <td valign="top" bgcolor="#E4E4E4"><b>Proyecto</b></td>
                                                    <td align="justify">
                                                        {if $arrProyectos.$seqProyecto == '' || $arrProyectos.$seqProyecto == ' '}
                                                            {$nombreComercial}
                                                        {else}
                                                            {$arrProyectos.$seqProyecto}
                                                        {/if}
                                                    </td>
                                                </tr>
                                            {/if}

                                            <!-- IDENTIFICACION ACTUAL -->
                                            <tr>
                                                <td valign="top" bgcolor="#E4E4E4"><b>Identificación Actual del Inmueble</b></td>
                                                <td align="justify">
                                                    {if $claDesembolso->arrEscrituracion.txtDireccionInmueble != "" }
                                                        {$claDesembolso->arrEscrituracion.txtDireccionInmueble|upper};
                                                    {else}
                                                        {$claDesembolso->txtDireccionInmueble|upper};
                                                    {/if}
                                                    {if $seqModalidad neq "5"}
                                                        predio cuya descripcion, cabida y linderos se encuentran
                                                        estipulados en la escritura pública {$claDesembolso->arrTitulos.numEscrituraIdentificacion|number_format:0:',':'.'}
                                                        del {$claDesembolso->arrTitulos.fchEscrituraIdentificacionTexto} elevada ante la notaría 
                                                        {$claDesembolso->arrTitulos.numNotariaIdentificacion|number_format:0:',':'.'} de {$claDesembolso->arrTitulos.txtCiudadIdentificacion|mb_strtoupper}
                                                    {/if}
                                                </td>
                                            </tr>

                                            {if $seqModalidad neq "5"}
                                                <!-- TITULO DE ADQUISICION -->
                                                <tr>
                                                    <td valign="top" bgcolor="#E4E4E4"><b>Título de Adquisición</b></td>
                                                    <td align="justify">
                                                        Escritura pública {$claDesembolso->arrTitulos.numEscrituraTitulo|number_format:0:',':'.'} del 
                                                        {$claDesembolso->arrTitulos.fchEscrituraTituloTexto} elevada ante la notaría 
                                                        {$claDesembolso->arrTitulos.numNotariaTitulo|number_format:0:',':'.'} de {$claDesembolso->arrTitulos.txtCiudadTitulo|mb_strtoupper}, registrada en la anotación
                                                        {$claDesembolso->arrTitulos.numFolioMatricula|number_format:0:',':'.'} del Folio de Matricula Inmobilaria.
                                                    </td>
                                                </tr>
                                            {/if}

                                            <!-- MATRICULA INMOBILIARIA -->
                                            <tr>
                                                <td valign="top" bgcolor="#E4E4E4"><b>Matricula Inmobiliaria</b></td>
                                                <td align="justify">
                                                    {if $claDesembolso->arrEscrituracion.txtMatriculaInmobiliaria != ""}
                                                        {$claDesembolso->arrEscrituracion.txtMatriculaInmobiliaria|upper}; 
                                                    {else}
                                                        {$claDesembolso->txtMatriculaInmobiliaria|upper}; 
                                                    {/if}
                                                    {if ( $claDesembolso->arrTitulos.txtZonaMatricula neq "" ) and ( $claDesembolso->arrTitulos.fchMatriculaTexto neq "" or $claDesembolso->arrTitulos.fchMatriculaTexto neq "0000-00-00" )}
                                                        de la oficina de registro de instrumentos públicos
                                                        {if $claDesembolso->arrTitulos.txtZonaMatricula  ne "Otra"}
                                                            zona {$claDesembolso->arrTitulos.txtZonaMatricula|mb_strtoupper}
                                                        {/if}
                                                        de {$claDesembolso->arrTitulos.txtCiudadMatricula|mb_strtoupper}, cuya fecha de expedicion data del
                                                        {$claDesembolso->arrTitulos.fchMatriculaTexto}
                                                    {/if} 
                                                </td>
                                            </tr>

                                            {if $seqModalidad neq "5"}
                                                <!-- MODO DE ADQUISICION -->
                                                <tr>
                                                    <td valign="top" bgcolor="#E4E4E4"><b>Modo de Adquisición</b></td>
                                                    <td align="justify">
                                                        Compraventa {$arrSolucionDescripcion.$seqModalidad.$seqSolucion|mb_strtoupper}, adquirida con el producto otorgado por la SDHT&nbsp;
                                                        {if $claDesembolso->arrTitulos.bolSubsidioFonvivienda == 1} y Fonvivienda {/if}
                                                    </td>
                                                </tr>
                                            {/if}

                                            {if not empty($arrContratoLeasing)}
                                                <tr>
                                                    <td valign="top" bgcolor="#E4E4E4"><b>Contrato de Leasing</b></td>
                                                    <td align="justify">
                                                        Número {$arrContratoLeasing.numContratoLeasing} del {$arrContratoLeasing.fchContratoLeasing}
                                                    </td>
                                                </tr>
                                            {/if}


                                            <!-- SUBSIDIOS ASIGNADOS -->
                                            <tr>
                                                <td valign="top" bgcolor="#E4E4E4"><b>Subsidios Asignados</b></td>
                                                <!-- 
                                                    *****************************Cambio provisional Liliana**********************
                                                    <td>Resolución 1424 de 30 de Noviembre de 2016</td>
                                                -->
                                                <td align="justify">
                                                    SDHT: Resolución {$claDesembolso->arrJuridico.numResolucion|number_format:0:',':'.'} del {$claDesembolso->arrJuridico.fchResolucion}<br/>
                                                    {if $claDesembolso->arrTitulos.bolSubsidioFonvivienda == 1} 
                                                        Fonvivienda: Resolución {$claDesembolso->arrTitulos.numResolucionFonvivienda|number_format:0:',':'.'} del
                                                        {$claDesembolso->arrTitulos.numAnoResolucionFonvivienda|number_format:0:',':'.'}
                                                    {/if} 
                                                </td>
                                            </tr>

                                            {if not empty($arrConvenio)}
                                                <tr>
                                                    <td valign="top" bgcolor="#E4E4E4"><b>Convenio de Leasing</b></td>
                                                    <td align="justify">
                                                        {$arrConvenio.txtConvenio} con la entidad {$arrConvenio.txtBanco}
                                                    </td>
                                                </tr>
                                            {/if}

                                            {if $seqModalidad neq "5"}
                                                <!-- AVALUO -->
                                                <tr>
                                                    <td valign="top" bgcolor="#E4E4E4"><b>Valor Inmueble:</b></td>
                                                    <td align="justify">
                                                        {if $claDesembolso->arrEscrituracion.numValorInmueble != ""}
                                                            ${$claDesembolso->arrEscrituracion.numValorInmueble|number_format:0:",":"."}
                                                        {else}
                                                            ${$claDesembolso->numValorInmueble|number_format:0:",":"."}
                                                        {/if}
                                                    </td>
                                                </tr>
                                            {/if}

                                            <!-- OBSERVACIONES -->
                                            <tr><td valign="top" colspan="2" bgcolor="#E4E4E4"><b>Observaciones</b></td></tr>
                                            <tr><td colspan="2">
                                                    <ol>
                                                        {foreach name=observacion from=$claDesembolso->arrTitulos.observacion item=txtObservacion}
                                                            <li>{$txtObservacion}</li>
                                                            {/foreach}					
                                                    </ol>
                                                </td></tr>

                                            <!-- DOCUMENTOS -->
                                            <tr><td valign="top" colspan="2" bgcolor="#E4E4E4"><b>Documentos Analizados</b></td></tr>
                                            <tr><td colspan="2">
                                                    <ol>
                                                        {foreach name=documentos from=$claDesembolso->arrTitulos.documentos item=txtDocumentos}
                                                            <li>{$txtDocumentos}</li>
                                                            {/foreach}					
                                                    </ol>
                                                </td></tr>

                                            <!-- RECOMENDACIONES -->
                                            <tr><td valign="top" colspan="2" bgcolor="#E4E4E4"><b>Recomendaciones</b></td></tr>
                                            <tr><td colspan="2">
                                                    <ol>
                                                        {foreach name=recomendaciones from=$claDesembolso->arrTitulos.recomendaciones item=txtRecomendaciones}
                                                            <li>{$txtRecomendaciones}</li>
                                                            {/foreach}					
                                                    </ol>
                                                </td></tr>

                                            <!-- FIRMA DEL ABOGADO -->


                                            <tr><td valign="top" colspan="2">
                                                    <br/><br/><br/><b>Cordialmente</b><br/><br/><br/>
                                                    <p>___________________________________________________</p>
                                                    <p>{$claDesembolso->arrTitulos.txtAprobo|upper}<br/>
                                                        {$txtDependencia}
                                                        </p>                      

                                                    <br/><br/><br/>
                                                    <!--
                                                    
                                                    <b>VoBo</b><br/><br/><br/>
                                                    <p>___________________________________________________</p>
                                                    <p>Martha Arenas Pineda<br/>
                                                    Grupo Juridico.</p>
                                                    
                                                    -->

                                                    <p>Preparó: 
                                                        {if $txtElaboro eq ""}
                                                            {$txtUsuarioSesion}
                                                        {else}
                                                            {$txtElaboro}
                                                        {/if}
                                                    </p>

                                                </td></tr>


                                            <!-- PIE DE PAGINA -->
                                            <tr><td valign="top" colspan="2">
                                                    El estudio jur&iacute;dico responde por la regularidad formal de los documentos examinados, 
                                                    mas no por la veracidad de su contenido.
                                                </td></tr>

                                        </table><br/>

                                        </center>
                                        </body>
                                        </html>
