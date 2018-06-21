{assign var=tipoDocCiudadano value=$claCiudadano->seqTipoDocumento}
{assign var=tipoDocVendedor value=$claDesembolso->arrEscrituracion.seqTipoDocumento}
{assign var=seqModalidad value=$claFormulario->seqModalidad}
{assign var=seqProyecto value=$claFormulario->seqProyecto}
{assign var=seqLocalidad value=$claDesembolso->seqLocalidad}
{assign var=seqSolucion value=$claFormulario->seqSolucion}
{assign var=seqBancoGiro value=$arrSolicitud.seqBancoGiro}

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8;"/>
    <meta name="title" content="Subsidios de Vivienda">
    <meta name="keywords" content="subsidio,vivienda,social,prioritaria,bogota,habitat,asignacion,credito"/>
    <meta name="description" content="Sistema de informacion de subsidios de vivienda">
    <meta http-equiv="Content-Language" content="es">
    <meta name="robots" content="index,  nofollow"/>
    <title>SDV - SDHT</title>

    {literal}
        <style type="text/css">
            p.salto {
                page-break-after: always;
            }
        </style>
    {/literal}

</head>
<body onLoad="window.print();">

<!-- TITULO DE LA CARTA DE IMPRESION -->
<table cellspacing="0" cellpadding="0" border="0" width="100%" style="border: 1px solid #999999;">
    <tr>
        <td width="150px" height="80px" align="center" valign="middle"><img src="../../recursos/imagenes/escudo.png">
        </td>
        <td align="center" valign="middle" style="padding:20px; {$txtFuente12}">
            <b>Subsidio Distrital de Vivienda</b><br>
            <b>Solicitud de Desembolso</b><br>
            <b>Modalidad de {$arrModalidad.$seqModalidad}</b>
            <hr>
            <div style="{$txtFuente10}; text-align:left; width:100%">
                <b>Fecha:</b> {$txtFecha}<br>
                <b>Consecutivo:</b> {$arrSolicitud.txtConsecutivo}<br>
                <b>No. Registro:</b> {$numRegistro|number_format:0:'.':','}
            </div>
        </td>
        <td width="150px" align="center" valign="middle">
            <img src="../../recursos/imagenes/bta_positiva_carta.jpg">
        </td>
    </tr>

    <!-- BENEFICIARIO DEL SUBSIDIO -->
    <table cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}">
        <tr>
            <td colspan="2" style="padding:5px; {$txtFuente12}"><b>Beneficiario del Subsidio</b></td>
        </tr>
        <tr>
            <td width="230px"><b>Nombre del Beneficiario:</b></td>
            <td>{$claCiudadano->txtNombre1} {$claCiudadano->txtNombre2} {$claCiudadano->txtApellido1} {$claCiudadano->txtApellido2} </td>
        </tr>
        <tr>
            <td><b>Documento del Beneficiario:</b></td>
            <td>{$arrTipoDocumento.$tipoDocCiudadano} {$claCiudadano->numDocumento}</td>
        </tr>
        <tr>
            <td><b>Fecha de Resolución:</b></td>
            <td>{$claDesembolso->arrJuridico.fchResolucionTexto}</td>
        </tr>
        <tr>
            <td><b>Número de Resolución:</b></td>
            <td>{$claDesembolso->arrJuridico.numResolucion}</td>
        </tr>
        <tr bgcolor="{cycle name=c1 values='#FFFFFF,#F0F0F0'}">
            <td><b>Valor de la Resolución:</b></td>
            <td>$ {$claDesembolso->arrJuridico.valResolucion|number_format}</td>
        </tr>
        <tr>
            <td><b>Proyecto de Inversión:</b></td>
            <td>
                {if $arrSolicitud.numProyectoInversion eq 488}
                    {$arrNombreProyectos.488}
                {elseif $arrSolicitud.numProyectoInversion eq 801}
                    {$arrNombreProyectos.801}
                {elseif $arrSolicitud.numProyectoInversion eq 435}
                    {$arrNombreProyectos.435}
                {else}
                    {$arrNombreProyectos.644}
                {/if}
            </td>
        </tr>
        <tr>
            <td><b>Número del Proyecto:</b></td>
            <td>{$arrSolicitud.numProyectoInversion}</td>
        </tr>
        <tr>
            <td valign="top"><b>Registro Presupuestal:</b></td>
            <td>
                {$arrSolicitud.numRegistroPresupuestal1} de {$arrSolicitud.fchRegistroPresupuestal1Texto}<br>
                {if $arrSolicitud.numRegistroPresupuestal2 != 0}
                    {$arrSolicitud.numRegistroPresupuestal2} de {$arrSolicitud.fchRegistroPresupuestal2Texto}
                {/if}
            </td>
        </tr>
        {if not empty( $arrResolucionIndexacion ) and $arrResolucionModificacion.numero != 167 and $arrResolucionModificacion.fecha  != 2014-04-09}
            <tr>
                <td><b>Fecha de Resolución de Indexación:</b></td>
                <td>{$arrResolucionIndexacion.fecha|date_format:"%d de %B del %Y"}</td>
            </tr>
            <tr>
                <td><b>Número de Resolución de Indexación:</b></td>
                <td>{$arrResolucionIndexacion.numero}</td>
            </tr>
            <tr>
                <td><b>Valor de la Resolución de Indexación:</b></td>
                <td>$ {$arrResolucionIndexacion.valor|number_format}</td>
            </tr>
            <tr>
                <td><b>Proyecto de Inversión Indexación:</b></td>
                {if $arrSolicitud.numProyectoInversion eq 488}
                    <td>{$arrNombreProyectos.488}</td>
                {elseif $arrSolicitud.numProyectoInversion eq 801}
                    <td>{$arrNombreProyectos.801}</td>
                {elseif $arrSolicitud.numProyectoInversion eq 435}
                    <td> {$arrNombreProyectos.435}</td>
                {else}
                    <td>{$arrNombreProyectos.644}</td>
                {/if}
            </tr>
            <tr>
                <td><b>Número del Proyecto Indexación:</b></td>
                {if $arrSolicitud.numProyectoInversion eq 488}
                    <td>488</td>
                {elseif $arrSolicitud.numProyectoInversion eq 801}
                    <td> 801</td>
                {elseif $arrSolicitud.numProyectoInversion eq 435}
                    <td>435</td>
                {else}
                    <td> 644</td>
                {/if}

            </tr>
            <td><b>Registro Presupuestal Indexación:</b></td>
            <td>{$arrResolucionIndexacion.rp} del {$arrResolucionIndexacion.fechaRp|date_format:"%d de %B del %Y"}</td>
            </tr>
        {/if}

        <tr>
            <td><b>Valor del Subsidio / Aporte:</b></td>
            <td>$ {$claFormulario->valAspiraSubsidio|number_format:0:',':'.'}</td>
        </tr>

        {if
        ( $claFormulario->seqModalidad == 6  && $claFormulario->seqTipoEsquema == 7 )  ||
        ( $claFormulario->seqModalidad == 6  && $claFormulario->seqTipoEsquema == 13 ) ||
        ( $claFormulario->seqModalidad == 12 && $claFormulario->seqTipoEsquema == 14 ) ||
        ( $claFormulario->seqModalidad == 12 && $claFormulario->seqTipoEsquema == 15 )
        }
            <tr>
                <td><b>Valor Complementario:</b></td>
                <td>$ {$claFormulario->valComplementario|number_format:0:',':'.'}</td>
            </tr>
        {/if}


    </table>

    <!-- BENEFICIARIO DEL PAGO -->
    <table cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}">
        <tr>
            <td colspan="2" style="padding:5px; {$txtFuente12}" bgcolor=""><b>Beneficiario del Pago</b></td>
        </tr>
        <tr>
            <td width="200px"><b>Nombre del {if $seqModalidad != 5} Vendedor {else} Arrendador {/if}:</b></td>
            <td>{if $claDesembolso->arrEscrituracion.txtNombreVendedor != ''}
                    {$claDesembolso->arrEscrituracion.txtNombreVendedor}
                {else}
                    {$claDesembolso->txtNombreVendedor}
                {/if} </td>
        </tr>
        <tr>
            <td><b>{if $claDesembolso->arrEscrituracion.txtTipoDocumentos == "juridica"}NIT{else}Documento{/if} del
                    Vendedor:</b></td>
            <td>
                {if $claDesembolso->arrEscrituracion.numDocumentoVendedor != 0}
                    {$arrTipoDocumento.$tipoDocVendedor} {$claDesembolso->arrEscrituracion.numDocumentoVendedor|number_format:0:',':'.'}
                {else}
                    {$arrTipoDocumento.$tipoDocVendedor} {$claDesembolso->numDocumentoVendedor|number_format:0:',':'.'}
                {/if}
            </td>
        </tr>
    </table>

    <!-- BENEFICIARIO DEL GIRO -->
    <table cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}">
        <tr>
            <td colspan="2" style="padding:5px; {$txtFuente12}" bgcolor=""><b>Beneficiario del Giro</b></td>
        </tr>
        <tr>
            <td width="300px"><b>Nombre Beneficiario del Giro:</b></td>
            <td>{$arrSolicitud.txtNombreBeneficiarioGiro}</td>
        </tr>
        <tr>
            <td><b>Número Documento Beneficiario del Giro:</b></td>
            <td>{$arrSolicitud.numDocumentoBeneficiarioGiro}</td>
        </tr>
        <tr>
            <td><b>Dirección Beneficiario del Giro:</b></td>
            <td>{$arrSolicitud.txtDireccionBeneficiarioGiro}</td>
        </tr>
        <tr>
            <td><b>Número Telefónico Beneficiario del Giro:</b></td>
            <td>{$arrSolicitud.numTelefonoGiro}</td>
        </tr>
        <tr>
            <td><b>Correo Electrónico Beneficiario del Giro:</b></td>
            <td>{$arrSolicitud.txtCorreoGiro}</td>
        </tr>
        <tr>
            <td><b>Número de Cuenta del Vendedor:</b></td>
            <td>{$arrSolicitud.numCuentaGiro}</td>
        </tr>
        <tr>
            <td><b>Tipo de Cuenta del Vendedor:</b></td>
            <td>{$arrSolicitud.txtTipoCuentaGiro|ucwords}</td>
        </tr>
        <tr>
            <td><b>Banco de la cuenta:</b></td>
            <td>{$arrBanco.$seqBancoGiro}</td>
        </tr>
        <tr>
            <td><b>Valor del Desembolso:</b></td>
            <td>$ {$arrSolicitud.valSolicitado|number_format:0:',':'.'}</td>
        </tr>
        <tr>
            <td>
                {if
                ( $claFormulario->seqModalidad == 6  && $claFormulario->seqTipoEsquema == 7 )  ||
                ( $claFormulario->seqModalidad == 6  && $claFormulario->seqTipoEsquema == 13 ) ||
                ( $claFormulario->seqModalidad == 12 && $claFormulario->seqTipoEsquema == 14 ) ||
                ( $claFormulario->seqModalidad == 12 && $claFormulario->seqTipoEsquema == 15 )
                }
                    <b>Valor SDVE en proyecto:</b>
                {else}
                    <b>Saldo del Desembolso:</b>
                {/if}
            </td>
            <td>
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
            </td>
        </tr>
        <tr>
            <td><b>Nùmero del Pago:</b></td>
            <td>{$numSolicitudes}</td>
            <!--<td>1</td>-->
        </tr>
    </table>

    <!-- CERTIFICACION -->
    <table cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}">
        <tr>
            <td style="padding:5px; {$txtFuente12}" bgcolor=""><b>Certificación</b></td>
        </tr>
        <tr>
            <td style="padding-left:20px; padding-right:20px; text-align:justify;">
                {if $seqModalidad != 5}
                    {if $Flujo == "" || $Flujo != "giroAnticipado"}
                        Una vez revisados, técnica, jurídica y financieramente, los documentos aportados por el
                        beneficiario del Subsidio Distrital de Vivienda y por el beneficiario del pago,
                        certificamos que los mismos se encuentran ajustados y acordes con los requisitos
                        establecidos en el reglamento operativo y la normatividad vigente, por lo anterior se
                        solicita desembolsar,
                        {if mb_strtolower($claDesembolso->arrEscrituracion.txtCompraVivienda) == 'nueva' } contra finalización de la obra,{/if}
                        a la cuenta del Banco indicada en la carta de autorización.
                    {else}
                        Una vez revisados jurídica y financieramente todos los documentos aportados por la
                        constructora y los de la entidad financiera, certificamos que los mismos se encuentran
                        ajustados y acordes con los requisitos establecidos en el reglamento operativo y la normatividad
                        vigente, por lo anterior se solicita realizar el respectivo giro anticipado, a la cuenta indicada
                        en la presente solicitud.
                    {/if}
                {else}
                    Una vez revisados, técnica, jurídica y financieramente, los documentos aportados por el
                    beneficiario del Subsidio Condicionado de Arrendamiento, por el beneficiario del pago y por el Banco BCSC,
                    certificamos que los mismos se encuentran ajustados y acordes con los requisitos establecidos en el
                    reglamento operativo y la normatividad vigente, por lo anterior se solicita desembolsar, a la cuenta del
                    Arrendador indicada en la certificación bancaria.
                {/if}

            </td>
        </tr>
    </table>

    <!-- DOCUMENTOS -->
    <table cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}">

        <!-- TITULO DE LA TABLA DE DOCUMETOS -->
        <tr>
            <td style="padding:5px; {$txtFuente12}" bgcolor="" colspan="3"><b>Se Adjuntaron los siguientes
                    documentos:</b></td>
        </tr>

        <!-- DOCUMENTO DEL BENEFICIARIO -->
        <tr>
            <td style="padding-left:20px" width="350px">
                <li>Copia cédula de ciudadanía del beneficiario</li>
            </td>
            <td width="25px">{if $arrSolicitud.bolDocumentoBeneficiario == 1} Si {else} No {/if}</td>
            <td>{$arrSolicitud.txtDocumentoBeneficiario}&nbsp;</td>
        </tr>

        <!-- DOCUMENTO DEL PROPIETARIO DEL INMUEBLE -->
        {if $claDesembolso->txtTipoDocumentos != "persona" && $claDesembolso->txtTipoDocumentos != ""}
            <tr>
                <td style="padding-left:20px">
                    <li>Copia Rut</li>
                </td>
                <td>{if $arrSolicitud.bolRut == 1} Si {else} No {/if}</td>
                <td>{$arrSolicitud.txtRut}&nbsp;</td>
            </tr>
            <!-- <tr>
						<td style="padding-left:20px"><li>Copia Nit</li></td>
						<td>{if $arrSolicitud.bolNit == 1} Si {else} No {/if}</td>
						<td>{$arrSolicitud.txtNit}&nbsp;</td>
					</tr> -->
            <tr>
                <td style="padding-left:20px">
                    <li>Documento Representante Legal</li>
                </td>
                <td>{if $arrSolicitud.bolCedulaRepresentante == 1} Si {else} No {/if}</td>
                <td>{$arrSolicitud.txtCedulaRepresentante}&nbsp;</td>
            </tr>
            <tr>
                <td style="padding-left:20px">
                    <li>Cámara y Comercio</li>
                </td>
                <td>{if $arrSolicitud.bolCamaraComercio == 1} Si {else} No {/if}</td>
                <td>{$arrSolicitud.txtCamaraComercio}&nbsp;</td>
            </tr>
        {else}
            <tr>
                <td style="padding-left:20px">
                    <li>Copia cédula de ciudadanía del vendedor o arrendador</li>
                </td>
                <td>{if $arrSolicitud.bolDocumentoVendedor == 1} Si {else} No {/if}</td>
                <td>{$arrSolicitud.txtDocumentoVendedor}&nbsp;</td>
            </tr>
        {/if}

        <tr>
            <td style="padding-left:20px">
                <li>Copia carta de asignación</li>
            </td>
            <td>{if $arrSolicitud.bolCartaAsignacion == 1} Si {else} No {/if}</td>
            <td>{$arrSolicitud.txtCartaAsignacion}&nbsp;</td>
        </tr>

        <tr>
            <td style="padding-left:20px">
                <li>Autorización de Giro a Terceros</li>
            </td>
            <td>{if $arrSolicitud.bolGiroTercero == 1} Si {else} No {/if}</td>
            <td>{$arrSolicitud.txtGiroTercero}&nbsp;</td>
        </tr>

        {if $seqModalidad != 5}
            <tr>
                <td style="padding-left:20px">
                    <li>Copia certificación bancaria / Giro por Cheque</li>
                </td>
                <td>{if $arrSolicitud.bolCertificacionBancaria == 1} Si {else} No {/if}</td>
                <td>{$arrSolicitud.txtCertificacionBancaria}&nbsp;</td>
            </tr>
            {if $seqModalidad == 3 || $seqModalidad == 4}
                <tr>
                    <td style="padding-left:20px">
                        <li>Acta entrega física de la obra</li>
                    </td>
                    <td>{if $arrSolicitud.bolActaEntregaFisica == 1} Si {else} No {/if}</td>
                    <td>{$arrSolicitud.txtActaEntregaFisica}&nbsp;</td>
                </tr>
                <tr>
                    <td style="padding-left:20px">
                        <li>Acta de liquidación</li>
                    </td>
                    <td>{if $arrSolicitud.bolActaLiquidacion == 1} Si {else} No {/if}</td>
                    <td>{$arrSolicitud.txtActaLiquidacion}&nbsp;</td>
                </tr>
            {/if}
            <tr>
                <td style="padding-left:20px">
                    <li>Original autorización de desembolso</li>
                </td>
                <td>{if $arrSolicitud.bolAutorizacion == 1} Si {else} No {/if}</td>
                <td>{$arrSolicitud.txtAutorizacion}&nbsp;</td>
            </tr>
        {else}
            <tr>
                <td style="padding-left:20px">
                    <li>Copia certificación bancaria arrendador</li>
                </td>
                <td>{if $arrSolicitud.bolBancoArrendador == 1} Si {else} No {/if}</td>
                <td>{$arrSolicitud.txtBancoArrendador}&nbsp;</td>
            </tr>
        {/if}

    </table>

    <!-- FIRMA DE LA CARTA -->
    <table cellspacing="0" cellpadding="4" border="0" width="100%" style="{$txtFuente12}">
        <tr>
            <td height="20px" colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <br/><br/>
                {if $arrSolicitud.txtSubdireccion|trim != ""}
                    {$arrSolicitud.txtSubdireccion|mb_strtolower|mb_strtoupper}
                    <br>
                    SUBDIRECTOR DE RECURSOS PÚBLICOS {if $arrSolicitud.bolSubdireccionEncargado == 1} (E) {/if}

                {/if}
                <br><br>
                <span style="{$txtFuente10}">
								ELABORÓ: {$txtUsuarioSesion|mb_strtolower|mb_strtoupper} - SUBDIRECCIÓN DE RECURSOS PÚBLICOS<br>
							</span>
                <span style="{$txtFuente10}">
								REVISÓ: {$arrSolicitud.txtRevisoSubsecretaria|mb_strtolower|mb_strtoupper}
							</span>
            </td>
            {if $arrSolicitud.txtSubdireccion|trim == ""}
        </tr>
        <tr>
            {/if}
            <td valign="top">
                <br/><br/>
                {if $arrSolicitud.txtSubsecretaria != ""}
                    {$arrSolicitud.txtSubsecretaria|mb_strtolower|mb_strtoupper}
                    <br>
                    SUBSECRETARIO DE GESTIÓN FINANCIERA {if $arrSolicitud.bolSubsecretariaEncargado == 1} (E) {/if}
                {/if}
            </td>

        </tr>

    </table>

</body>
</html>
	