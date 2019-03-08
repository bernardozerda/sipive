{if $claDesembolso->txtFlujo eq "giroAnticipado" || $claDesembolso->txtFlujo eq "postulacionIndividual"}
    {assign var=tipoDocVendedor             	value=$claDesembolso->arrEscrituracion.seqTipoDocumento}
    {assign var=seqLocalidad 					value=$claDesembolso->arrEscrituracion.seqLocalidad}
    {assign var=txtDireccionInmueble            value =$claDesembolso->arrEscrituracion.txtDireccionInmueble}
    {assign var=txtNombreVendedor				value=$claDesembolso->arrEscrituracion.txtNombreVendedor}
    {assign var=numDocumentoVendedor			value=$claDesembolso->arrEscrituracion.numDocumentoVendedor}
    {assign var=numTelefonoVendedor				value=$claDesembolso->arrEscrituracion.numTelefonoVendedor}
    {assign var=txtBarrio						value=$claDesembolso->arrEscrituracion.txtBarrio}
    {assign var=txtTipoPredio					value=$claDesembolso->arrEscrituracion.txtTipoPredio}
    {assign var=txtMatriculaInmobiliaria		value=$claDesembolso->arrEscrituracion.txtMatriculaInmobiliaria}
    {assign var=txtChip							value=$claDesembolso->arrEscrituracion.txtChip}

{else}
    {assign var=tipoDocVendedor             	value=$claDesembolso->seqTipoDocumento}
    {assign var=seqLocalidad 					value=$claDesembolso->seqLocalidad}
    {assign var=txtDireccionInmueble            value =$claDesembolso->txtDireccionInmueble}
    {assign var=txtNombreVendedor				value=$claDesembolso->txtNombreVendedor}
    {assign var=numDocumentoVendedor			value=$claDesembolso->numDocumentoVendedor}
    {assign var=numTelefonoVendedor				value=$claDesembolso->numTelefonoVendedor}
    {assign var=txtBarrio						value=$claDesembolso->txtBarrio}
    {assign var=txtTipoPredio					value=$claDesembolso->txtTipoPredio}
    {assign var=txtMatriculaInmobiliaria		value=$claDesembolso->txtMatriculaInmobiliaria}
    {assign var=txtChip							value=$claDesembolso->txtChip}
{/if}

{assign var=tipoDocCiudadano     		value=$claCiudadano->seqTipoDocumento}
{assign var=seqModalidad 			value=$claFormulario->seqModalidad}
{assign var=seqProyecto 			value=$claFormulario->seqProyecto}
{assign var=seqSolucion 			value=$claFormulario->seqSolucion}
{assign var=txtRequisitos 			value=$claDesembolso->arrTecnico.txtRequisitos|lower}
{assign var=txtExistencia 			value=$claDesembolso->arrTecnico.txtExistencia|lower}
{assign var=txtNoCumple				value=""}




{if $txtExistencia eq "no" or $txtRequisitos eq "no"}
    {assign var=txtNoCumple				value="NO"}
{/if}

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="title" content="Subsidios de Vivienda">
            <meta name="keywords" content="subsidio,vivienda,social,prioritaria,bogota,habitat,asignacion,credito" />
            <meta name="description" content="Sistema de informacion de subsidios de vivienda">
                <meta http-equiv="Content-Language" content="es">
                    <meta name="robots" content="index,  nofollow" />
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
                                <td width="150px" height="80px" align="center" valign="middle">
                                    <img src="../../recursos/imagenes/escudo.png" />
                                </td>
                                <td align="center" valign="middle" style="padding:20px; {$txtFuente12}">
                                    <b>ALCALDIA MAYOR DE BOGOTA</b><br/>
                                    SECRETARIA DEL HABITAT<br />
                                    PROGRAMA INTEGRAL DE VIVIENDA EFECTIVA (PIVE)<br/>
                                    <b>Certificado de Existencia y Habitabilidad</b><br/>
                                    <span style="{$txtFuente10}">Fecha de Visita: {$txtFechaVisita}</span><br/>
                                    <span style="{$txtFuente10}">Fecha de Expedición: {$txtFechaExpedicion}</span><br/>
                                    <span style="{$txtFuente10}">Fecha de impresión: {$txtFecha}</span><br/>
                                    <span style="{$txtFuente10}">No. Registro: {$numRegistro|number_format:0:'.':','}</span>
                                </td>
                                <td width="150px" align="center" valign="middle">
                                    <img src="../../recursos/imagenes/bta_positiva_carta.jpg" />
                                </td>
                            </tr>
                        </table><br />

                        <!-- PLANTILLA VIVIENDA NUEVA -->
                        {if not empty( $claDesembolso->arrTecnico.observacion )}

                            <center>			
                                <table cellpadding="2" cellspacing="0" border="0" width="100%" style="border: 1px solid #999999; {$txtFuente12}">
                                    <tr><td colspan="2" align="center" style="padding-left:30px; padding-right:30px; font-weight:bold;"><br /><br />
                                            REVISION CERTIFICADO DE EXISTENCIA Y HABITABILIDAD VIVIENDA DE
                                            INTERES SOCIAL Y RESULTADO DE LA CONSULTA PARA EFECTOS DE LO
                                            ORDENADO EN EL ARTICULO 34 DE LA RESOLUCION 966 DE 2004 DEL 
                                            MINISTERIO DE AMBIENTE, VIVIENDA Y DESARROLLO TERRITORIAL 
                                        </td></tr>
                                    <tr><td colspan="2" >&nbsp;</td></tr>
                                    <tr><td colspan="2" style="padding-left:50px; padding-right:50px;" align="justify">					
                                            El día de hoy {$txtHoy} se realizó la revision de los documentos radicados por el hogar
                                            de <b>{$claCiudadano->txtNombre1} {$claCiudadano->txtNombre2} 
                                                {$claCiudadano->txtApellido1} {$claCiudadano->txtApellido2}</b>
                                            identificado con <b> {$arrTipoDocumento.$seqTipoDocumento|ucwords} {$claCiudadano->numDocumento}</b> 
                                            beneficiario(s) del Subsidio Distrital de Vivienda de la vivienda ubicada en la 
                                            <b>{$txtDireccionInmueble}</b> arrojando como resultado lo siguiente:

                                        </td></tr>
                                    <tr><td colspan="2" ><br />&nbsp;</td></tr>
                                    <tr><td colspan="2" style="padding-left:30px; padding-right:30px;">
                                            <ol>
                                                {foreach name=observacion from=$claDesembolso->arrTecnico.observacion item=txtObservacion}
                                                    <li style="padding-bottom:10px; text-align:justify; padding-right: 23px;">{$txtObservacion}</li>
                                                    {/foreach}
                                            </ol>
                                        </td></tr>
                                    <tr><td colspan="2" >&nbsp;</td></tr>
                                    <tr><td colspan="2" style="padding-left:30px; padding-right:30px;">
                                            De acuerdo con la revisión anteriormente descrita es viable continuar desde el punto
                                            de vista técnico con los trámites que permitan el desembolso del subsidio.<br /><br />
                                            Para constacia se firma por parte del responsable en el área técnica.<br /><br /><br /><br />

                                            <p>Firma: ___________________________________________________</p>
                                            <p>Matricula Profesional:{$txtMatriculaProfesional} </p>
                                            <p>{$txtUsuarioSesion}</p><br /><br /><br />

                                        </td></tr>
                                </table>	
                            </center>

                        {else}

                            <!-- INICIO PAGINA 1 -->

                            <!-- INFORMACION GENERAL -->
                            <table cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}">
                                <tr><td colspan="3" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4"><b>Información General</b></td></tr>

                                <!-- NOMBRE DEL BENEFICIARIO -->
                                <tr>
                                    <td><b>Nombre del Beneficiario:</b></td>
                                    <td><b>Documento</b></td>
                                    <td><b>Teléfono</b></td>
                                </tr>
                                <tr>
                                    <td>{$claCiudadano->txtNombre1} {$claCiudadano->txtNombre2} {$claCiudadano->txtApellido1} {$claCiudadano->txtApellido2}</td>
                                    <td>{$arrTipoDocumento.$tipoDocCiudadano} {$claCiudadano->numDocumento}</td>
                                    <td>{$claFormulario->numTelefono1} ó {$claFormulario->numTelefono2} Celular {$claFormulario->numCelular}</td>
                                </tr>

                                <!-- NOMBRE DEL VENDEDOR -->
                                <tr>
                                    <td><b>Vendedor, Oferente y/o Constructor:</b></td>
                                    <td><b>Documento</b></td>
                                    <td><b>Teléfono</b></td>
                                </tr>
                                <tr>
                                    <td>{$txtNombreVendedor}</td>
                                    <td>{$arrTipoDocumento.$tipoDocVendedor} {$numDocumentoVendedor|number_format:0:',':'.'}</td>
                                    <td>{$numTelefonoVendedor}</td>
                                </tr>

                                <!-- DIRECCION DEL PREDIO -->
                                <tr>
                                    <td><b>Nombre del Proyecto:</b></td>
                                    <td><b>Dirección</b></td>
                                    <td><b>Tipo de Oferta</b></td>
                                </tr>

                                <!-- PROYECTO, MODALIDAD -->
                                <tr>
                                    <td>
                                        {if $arrProyectos.$seqProyecto == '' || $arrProyectos.$seqProyecto == ' '}
                                            {$nombreComercial}
                                        {else}
                                            {$arrProyectos.$seqProyecto}
                                        {/if}
                                    </td>
                                    <td>{$txtDireccionInmueble}</td>
                                    <td>{$arrModalidad.$seqModalidad} - {$arrSolucionDescripcion.$seqModalidad.$seqSolucion}</td>
                                </tr>			

                                <!-- LOCALIDAD / BARRIO O VEREDA -->
                                <tr>
                                    <td><b>Localidad:</b></td>
                                    <td><b>Barrio o Vereda</b></td>
                                    <td><b>Tipo de Predio</b></td>
                                </tr>
                                <tr>
                                    <td>{$arrLocalidad.$seqLocalidad}</td>
                                    <td>{$txtBarrio}</td>
                                    <td>{$txtTipoPredio}</td>
                                </tr>

                                <tr> 
                                    <td><b>Matricula:</b><br/>{$txtMatriculaInmobiliaria}</td>
                                    <td><b>Chip:</b><br/>{$txtChip}</td>
                                    <td></td>
                                </tr>


                            </table><br />

                            <!-- CONDICIONES ESPACIALES DE LA VIVIENDA -->
                            <table cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}">
                                <tr><td colspan="5" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4"><b>Condiciones Espaciales de la Vivienda</b></td></tr>

                                <tr>
                                    <td style="border-bottom: 1px solid #999999" height="23px" width="150px"><b>Descripción</b></td>
                                    <td style="border-bottom: 1px solid #999999" width="70px" align="right"><b>Largo (m)</b></td>
                                    <td style="border-bottom: 1px solid #999999" width="70px" align="right"><b>Ancho (m)</b></td>
                                    <td style="border-bottom: 1px solid #999999" width="70px" align="right" valign="top"><b>Área (m<sup>2</sup>)</b></td>
                                    <td style="border-bottom: 1px solid #999999; padding-left:10px"><b>Observaciones</b></td>
                                </tr>

                                <!-- ESPACIO MULTIPLE -->
                                <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Espacio Múltiple</b></td>
                                    <td align="right">{$claDesembolso->arrTecnico.numLargoMultiple|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAnchoMultiple|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAreaMultiple|number_format:2:',':'.'}</td>
                                    <td style="padding-left:10px">{$claDesembolso->arrTecnico.txtMultiple}</td>
                                </tr>

                                <!-- ALCOBA1 -->
                                <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Alcoba 1</b></td>
                                    <td align="right">{$claDesembolso->arrTecnico.numLargoAlcoba1|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAnchoAlcoba1|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAreaAlcoba1|number_format:2:',':'.'}</td>
                                    <td style="padding-left:10px">{$claDesembolso->arrTecnico.txtAlcoba1}</td>
                                </tr>

                                <!-- ALCOBA2 -->
                                <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Alcoba 2</b></td>
                                    <td align="right">{$claDesembolso->arrTecnico.numLargoAlcoba2|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAnchoAlcoba2|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAreaAlcoba2|number_format:2:',':'.'}</td>
                                    <td style="padding-left:10px">{$claDesembolso->arrTecnico.txtAlcoba2}</td>
                                </tr>

                                <!-- ALCOBA3 -->
                                <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Alcoba 3</b></td>
                                    <td align="right">{$claDesembolso->arrTecnico.numLargoAlcoba3|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAnchoAlcoba3|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAreaAlcoba3|number_format:2:',':'.'}</td>
                                    <td style="padding-left:10px">{$claDesembolso->arrTecnico.txtAlcoba3}</td>
                                </tr>

                                <!-- COCINA -->
                                <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Cocina</b></td>
                                    <td align="right">{$claDesembolso->arrTecnico.numLargoCocina|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAnchoCocina|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAreaCocina|number_format:2:',':'.'}</td>
                                    <td style="padding-left:10px">{$claDesembolso->arrTecnico.txtCocina}</td>
                                </tr>

                                <!-- BANO1 -->
                                <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Baño 1</b></td>
                                    <td align="right">{$claDesembolso->arrTecnico.numLargoBano1|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAnchoBano1|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAreaBano1|number_format:2:',':'.'}</td>
                                    <td style="padding-left:10px">{$claDesembolso->arrTecnico.txtBano1}</td>
                                </tr>

                                <!-- BANO2 -->
                                <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Baño 2</b></td>
                                    <td align="right">{$claDesembolso->arrTecnico.numLargoBano2|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAnchoBano2|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAreaBano2|number_format:2:',':'.'}</td>
                                    <td style="padding-left:10px">{$claDesembolso->arrTecnico.txtBano2}</td>
                                </tr>

                                <!-- LAVANDERIA -->
                                <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Area de Lavanderia</b></td>
                                    <td align="right">{$claDesembolso->arrTecnico.numLargoLavanderia|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAnchoLavanderia|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAreaLavanderia|number_format:2:',':'.'}</td>
                                    <td style="padding-left:10px">{$claDesembolso->arrTecnico.txtLavanderia}</td>
                                </tr>

                                <!-- CIRCULACIONES -->
                                <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Circulaciones</b></td>
                                    <td align="right">{$claDesembolso->arrTecnico.numLargoCiculaciones|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAnchoCirculaciones|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAreaCirculaciones|number_format:2:',':'.'}</td>
                                    <td style="padding-left:10px">{$claDesembolso->arrTecnico.txtCirculaciones}</td>
                                </tr>

                                <!-- PATIO -->
                                <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Patio</b></td>
                                    <td align="right">{$claDesembolso->arrTecnico.numLargoPatio|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAnchoPatio|number_format:2:',':'.'}</td>
                                    <td align="right">{$claDesembolso->arrTecnico.numAreaPatio|number_format:2:',':'.'}</td>
                                    <td style="padding-left:10px">{$claDesembolso->arrTecnico.txtPatio}</td>
                                </tr>

                                <!-- TOTAL AREA CONSTRUIDA-->
                                <tr>
                                    <td>&nbsp;</td>
                                    <td align="right" colspan="2" style="padding-right:10px"><b>Área Total Construida</b></td>
                                    <td align="right"><b>{$claDesembolso->arrTecnico.numAreaTotal|number_format:2:',':'.'}</b></td>
                                    <td>&nbsp;</td>
                                </tr>

                            </table><br />

                            <!-- CONDICIONES FISICAS Y ESTRUCTURALES -->
                            <table cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}">
                                <tr><td colspan="5" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4"><b>Condiciones Físicas y Estructurales de la Vivienda</b></td></tr>	

                                <tr>
                                    <td style="border-bottom: 1px solid #999999" height="20px" width="150px"><b>Descripción</b></td>
                                    <td style="border-bottom: 1px solid #999999" width="150px"><b>Estado</b></td>
                                    <td style="border-bottom: 1px solid #999999;"><b>Observaciones</b></td>
                                </tr>

                                <!-- CIMENTACION -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Cimentación</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtEstadoCimentacion|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtCimentacion}</td>
                                </tr>

                                <!-- PLACA DE ENTREPISO	-->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Placas de Entrepiso</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtEstadoPlacaEntrepiso|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtPlacaEntrepiso}</td>
                                </tr>

                                <!-- MAMPOSTERIA -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Mampostería</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtEstadoMamposteria|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtMamposteria}</td>
                                </tr>

                                <!-- CUBIERTA -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Cubierta</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtEstadoCubierta|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtCubierta}</td>
                                </tr>

                                <!-- VIGAS -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Vigas</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtEstadoVigas|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtVigas}</td>
                                </tr>

                                <!-- COLUMNAS -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Columnas</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtEstadoColumnas|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtColumnas}</td>
                                </tr>

                                <!-- PANETES -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Pañetes</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtEstadoPanetes|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtPanetes}</td>
                                </tr>

                                <!-- ENCHAPES Y ACCESORIOS -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Enchapes y Accesorios</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtEstadoEnchapes|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtEnchapes}</td>
                                </tr>

                                <!-- ACABADOS PISOS -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Acabados Pisos</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtEstadoAcabados|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtAcabados}</td>
                                </tr>

                                <!-- INSTALACIONES HIDRAULICAS -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Instalaciones Hidráulicas</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtEstadoHidraulicas|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtHidraulicas}</td>
                                </tr>

                                <!-- INSTALACIONES HIDRAULICAS -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Instalaciones Eléctricas</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtEstadoElectricas|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtElectricas}</td>
                                </tr>

                                <!-- INSTALACIONES SANITARIAS -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Instalaciones Sanitarias</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtEstadoSanitarias|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtSanitarias}</td>
                                </tr>

                                <!-- INSTALACIONES HIDRAULICAS -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Instalaciones Gas</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtEstadoGas|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtGas}</td>
                                </tr>

                                <!-- CARPINTERIA MADERA -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Carpintería Madera</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtEstadoMadera|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtMadera}</td>
                                </tr>

                                <!-- CARPINTERIA METALICA -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Carpinteria Metalica</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtEstadoMetalica|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtMetalica}</td>
                                </tr>

                                <!-- LAVADERO -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Lavadero</b></td>
                                    <td>{$claDesembolso->arrTecnico.numLavadero|number_format:0:',':'.'}</td>
                                    <td>{$claDesembolso->arrTecnico.txtLavadero}</td>
                                </tr>

                                <!-- LAVAPLATOS -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Lavaplatos</b></td>
                                    <td>{$claDesembolso->arrTecnico.numLavaplatos|number_format:0:',':'.'}</td>
                                    <td>{$claDesembolso->arrTecnico.txtLavaplatos}</td>
                                </tr>

                                <!-- LAVAMANOS -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Lavamanos</b></td>
                                    <td>{$claDesembolso->arrTecnico.numLavamanos|number_format:0:',':'.'}</td>
                                    <td>{$claDesembolso->arrTecnico.txtLavamanos}</td>
                                </tr>

                                <!-- SANITARIO -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Sanitario</b></td>
                                    <td>{$claDesembolso->arrTecnico.numSanitario|number_format:0:',':'.'}</td>
                                    <td>{$claDesembolso->arrTecnico.txtSanitario}</td>
                                </tr>

                                <!-- DUCHA -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Ducha</b></td>
                                    <td>{$claDesembolso->arrTecnico.numDucha|number_format:0:',':'.'}</td>
                                    <td>{$claDesembolso->arrTecnico.txtDucha}</td>
                                </tr>

                                <!-- VIDRIOS-->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Vidrios</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtEstadoVidrios|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtVidrios}</td>
                                </tr>

                                <!-- PINTURA -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Pintura</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtEstadoPintura|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtPintura}</td>
                                </tr>

                                <!-- OTROS -->
                                <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Otros</b></td>
                                    <td>{$claDesembolso->arrTecnico.txtOtros|ucwords}</td>
                                    <td>{$claDesembolso->arrTecnico.txtObservacionOtros}</td>
                                </tr>
                            </table>

                            <!-- FIN PAGINA 1 -->

                            <p class="salto">&nbsp;</p>

                            <!-- INICIO PAGINA 2 -->

                            <!-- TITULO DE LA CARTA DE IMPRESION -->
                            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border: 1px solid #999999;">
                                <tr>
                                    <td width="150px" height="80px" align="center" valign="middle">

                                        <img src="../../recursos/imagenes/escudo.png" />

                                    </td>
                                    <td align="center" valign="middle" style="padding:20px; {$txtFuente12}">
                                        <b>Certificado de Existencia y Habitabilidad</b><br />
                                        <span style="{$txtFuente10}">Fecha de Visita: {$txtFechaVisita}</span><br />
                                        <span style="{$txtFuente10}">Fecha de Expedición: {$txtFechaExpedicion}</span><br />
                                        <span style="{$txtFuente10}">Fecha de impresión: {$txtFecha}</span><br />
                                    </td>
                                    <td width="150px" align="center" valign="middle">
                                        <img src="../../recursos/imagenes/bta_positiva_carta.jpg" />
                                    </td>
                                </tr>
                            </table><br />

                            <!-- INFORMACION GENERAL -->
                            <table cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}">
                                <tr><td colspan="3" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4"><b>Información General</b></td></tr>

                                <!-- NOMBRE DEL BENEFICIARIO -->
                                <tr>
                                    <td><b>Nombre del Beneficiario:</b></td>
                                    <td><b>Documento</b></td>
                                    <td><b>Teléfono</b></td>
                                </tr>
                                <tr>
                                    <td>{$claCiudadano->txtNombre1} {$claCiudadano->txtNombre2} {$claCiudadano->txtApellido1} {$claCiudadano->txtApellido2}</td>
                                    <td>{$arrTipoDocumento.$tipoDocCiudadano} {$claCiudadano->numDocumento}</td>
                                    <td>{$claFormulario->numTelefono1} ó {$claFormulario->numTelefono2} Celular {$claFormulario->numCelular}</td>
                                </tr>

                                <!-- NOMBRE DEL VENDEDOR -->
                                <tr>
                                    <td><b>Vendedor, Oferente y/o Constructor:</b></td>
                                    <td><b>Documento</b></td>
                                    <td><b>Teléfono</b></td>
                                </tr>
                                <tr>
                                    <td>{$txtNombreVendedor}</td>
                                    <td>{$arrTipoDocumento.$tipoDocVendedor} {$numDocumentoVendedor|number_format:0:',':'.'}</td>
                                    <td>{$numTelefonoVendedor}</td>
                                </tr>

                                <!-- DIRECCION DEL PREDIO -->
                                <tr>
                                    <td><b>Nombre del Proyecto:</b></td>
                                    <td><b>Dirección</b></td>
                                    <td><b>Tipo de Oferta</b></td>
                                </tr>

                                <!-- PROYECTO, MODALIDAD -->
                                <tr>
                                    <td>{$arrProyectos.$seqProyecto}</td>
                                    <td>{$txtDireccionInmueble}</td>
                                    <td>{$arrModalidad.$seqModalidad} - {$arrSolucionDescripcion.$seqModalidad.$seqSolucion}</td>
                                </tr>		

                                <!-- LOCALIDAD / BARRIO O VEREDA -->
                                <tr>
                                    <td><b>Localidad:</b></td>
                                    <td><b>Barrio o Vereda</b></td>
                                    <td><b>Tipo de Predio</b></td>
                                </tr>
                                <tr>
                                    <td>{$arrLocalidad.$seqLocalidad}</td>
                                    <td>{$txtBarrio}</td>
                                    <td>{$txtTipoPredio}</td>
                                </tr>

                            </table><br />

                            <!-- CONDICIONES ESPACIALES DE LA VIVIENDA -->
                            <table cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}">
                                <tr><td colspan="5" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4"><b>Condiciones Espaciales de la Vivienda</b></td></tr>

                                <tr>
                                    <td style="border-bottom: 1px solid #999999" width="150px"><b>Descripción</b></td>
                                    <td style="border-bottom: 1px solid #999999" width="100px" align="right"><b>Contador</b></td>
                                    <td style="border-bottom: 1px solid #999999; padding-left:10px;" width="120px"><b>Estado Conexión</b></td>
                                    <td style="border-bottom: 1px solid #999999; padding-left:10px"><b>Observaciones</b></td>
                                </tr>

                                <!-- SERVICIO DE AGUA -->
                                <tr bgcolor="{cycle name=c3 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Servicio de Agua</b></td>
                                    <td align="right">{$claDesembolso->arrTecnico.numContadorAgua}</td>
                                    <td style="padding-left:10px;">{$claDesembolso->arrTecnico.txtEstadoConexionAgua|ucwords}</td>
                                    <td style="padding-left:10px;">{$claDesembolso->arrTecnico.txtDescripcionAgua}</td>
                                </tr>

                                <!-- SERVICIO DE ENERGIA -->
                                <tr bgcolor="{cycle name=c3 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Servicio de Energía</b></td>
                                    <td align="right">{$claDesembolso->arrTecnico.numContadorEnergia|number_format:0:',':'.'}</td>
                                    <td style="padding-left:10px;">{$claDesembolso->arrTecnico.txtEstadoConexionEnergia|ucwords}</td>
                                    <td style="padding-left:10px;">{$claDesembolso->arrTecnico.txtDescripcionEnergia}</td>
                                </tr>

                                <!-- SERVICIO DE ALCANTARILLADO -->
                                <tr bgcolor="{cycle name=c3 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Servicio de Alcantarillado</b></td>
                                    <td align="right">{$claDesembolso->arrTecnico.numContadorAlcantarillado|number_format:0:',':'.'}</td>
                                    <td style="padding-left:10px;">{$claDesembolso->arrTecnico.txtEstadoConexionAlcantarillado|ucwords}</td>
                                    <td style="padding-left:10px;">{$claDesembolso->arrTecnico.txtDescripcionAlcantarillado}</td>
                                </tr>

                                <!-- SERVICIO DE GAS -->
                                <tr bgcolor="{cycle name=c3 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Servicio de Gas</b></td>
                                    <td align="right">{$claDesembolso->arrTecnico.numContadorGas|number_format:0:',':'.'}</td>
                                    <td style="padding-left:10px;">{$claDesembolso->arrTecnico.txtEstadoConexionGas|ucwords}</td>
                                    <td style="padding-left:10px;">{$claDesembolso->arrTecnico.txtDescripcionGas}</td>
                                </tr>

                                <!-- SERVICIO DE telefono -->
                                <tr bgcolor="{cycle name=c3 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Servicio de Teléfono</b></td>
                                    <td align="right">{$claDesembolso->arrTecnico.numContadorTelefono|number_format:0:',':'.'}</td>
                                    <td style="padding-left:10px;">{$claDesembolso->arrTecnico.txtEstadoConexionTelefono|ucwords}</td>
                                    <td style="padding-left:10px;">{$claDesembolso->arrTecnico.txtDescripcionTelefono}</td>
                                </tr>

                                <!-- ANDENES -->
                                <tr bgcolor="{cycle name=c3 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Andenes</b></td>
                                    <td align="right">&nbsp;</td>
                                    <td style="padding-left:10px;">{$claDesembolso->arrTecnico.txtEstadoAndenes|ucwords}</td>
                                    <td style="padding-left:10px;">{$claDesembolso->arrTecnico.txtDescripcionAndenes}</td>
                                </tr>

                                <!-- VIAS -->
                                <tr bgcolor="{cycle name=c3 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Vias</b></td>
                                    <td align="right">&nbsp;</td>
                                    <td style="padding-left:10px;">{$claDesembolso->arrTecnico.txtEstadoVias|ucwords}</td>
                                    <td style="padding-left:10px;">{$claDesembolso->arrTecnico.txtDescripcionVias}</td>
                                </tr>

                                <!-- SERVICIOS COMUNALES -->
                                <tr bgcolor="{cycle name=c3 values="#EAEAEA,#FFFFFF"}">
                                    <td><b>Servicios Comunales</b></td>
                                    <td align="right">&nbsp;</td>
                                    <td style="padding-left:10px;">{$claDesembolso->arrTecnico.txtEstadoServiciosComunales|ucwords}</td>
                                    <td style="padding-left:10px;">{$claDesembolso->arrTecnico.txtDescripcionServiciosComunales}</td>
                                </tr>

                                <tr><td colspan="4">&nbsp;</td></tr>

                                <!-- DESCRIPCION DE LA VIVIENDA -->
                                <tr><td colspan="4" style="border-top: 1px solid #999999; border-bottom: 1px solid #999999;">
                                        <b>Descripcion de la vivienda</b>
                                    </td></tr>
                                <tr><td colspan="4" style="padding-left:20px; padding-right:20px; padding-top:5px; padding-bottom:5px; border-bottom: 1px solid #999999;" align="justify">
                                        {$claDesembolso->arrTecnico.txtDescripcionVivienda}
                                    </td></tr>

                            </table><br />

                            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="{$txtFuente10}">

                                <!-- NORMA NSR-98 -->
                                <!--
                               <tr><td>
                                       <b>Cumple con los requisitos de la norma NSR-98:</b> {$claDesembolso->arrTecnico.txtNormaNSR98|ucwords}<br />
                                       <u>Recomendaciones:</u><br />
                                {$claDesembolso->arrTecnico.txtDescipcionNormaNSR98}&nbsp;
                        </td></tr>
                        <tr><td>&nbsp;</td></tr>
                                -->

                                <!-- REQUISITOS DE TERMINACION -->	
                                <!--
                               <tr><td>
                                       <b>Cumple la vivienda con los requisitos de terminación, calidad y estabilidad:</b> {$claDesembolso->arrTecnico.txtRequisitos|ucwords}<br />
                                       <u>Recomendaciones:</u><br />
                                {$claDesembolso->arrTecnico.txtDescripcionRequisitos}&nbsp;
                        </td></tr>
                        <tr><td>&nbsp;</td></tr>
                                -->

                                <!-- CRITERIOS DE EXISTENCIA Y HABITABILIDAD -->	
                                <tr><td>
                                        <b>Cumple la vivienda con los requisitos de existencia y habitabilidad:</b> {$claDesembolso->arrTecnico.txtExistencia|ucwords}  &nbsp;
                                        {if $claDesembolso->arrTecnico.txtExistencia|ucwords == 'SI' } <b> Viabilizó: </b>  {$txtAprobo} {/if}
                                        <br />
                                        <u>Recomendaciones:</u><br /><br />
                                        {$claDesembolso->arrTecnico.txtDescripcionExistencia}&nbsp;
                                    </td></tr>
                                <tr><td>&nbsp;</td></tr>

                                <!-- TEXTO DE PIE DE PAGINA PAGINA 2 -->
                                <tr><td align="justify" style="padding-right: 20px;">
                                        El presente certificado se expide con base en una visita adelantada por parte del equipo técnico
                                        de la Subdirección de Recursos Públicos y/o Privados de la Subsecretaría de Gestión Financiera; en esta no se observa
                                        que la vivienda presente afectaciones o fallas estructurales que pongan en riesgo a sus habitantes
                                        o afecten la habitabilidad del inmueble. La vivienda dispone de los servicios públicos básicos
                                        y cumple con lo establecido en la normatividad vigente.<br>
                                            La Secretaria Distrital de Hábitat <strong>NO</strong> se hace responsable por la calidad estructural de la vivienda,
                                            la calidad de los materiales empleados, ni la correcta ejecución del proceso constructivo adelantado en la construcción de esta vivienda.

                                            <!--
                                                        El presente certificado se expide a los {$numDiaActual} dias del mes de {$txtMesActual} de {$numAnoActual}.-->
                                    </td></tr>

                                <!-- FIRMA DEL ARQUITECTO -->
                                <tr>
                                    <td>
                                        <table valign="bottom"  cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}" >
                                            <tr>
                                                <td height="120px" valign="bottom" align="right" style="padding: 20px">
                                                    _____________________________________________<br /><br />
                                                    M.P. {$txtMatriculaProfesional}<br />
                                                    {$txtUsuarioSesion}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                            </table>

                            <!-- FIN PAGINA 2 -->

                            <p class="salto">&nbsp;</p>

                            <!-- INICIO PAGINAS DINAMICAS DE ACUERDO AL NUMERO DE FOTOS CARGADAS -->

                            {assign var=numImagenes value=$claDesembolso->arrTecnico.imagenes|@count}
                            {math equation="( x / y )" x=$numImagenes y=6 assign=numPaginas}
                            {math equation="x + y" x=$numPaginas y=1 assign=numPaginas}

                            {section name=paginas loop=$numPaginas|@ceil start=1}

                                <!-- TITULO DE LA CARTA DE IMPRESION -->
                                <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border: 1px solid #999999;">
                                    <tr>
                                        <td width="150px" height="80px" align="center" valign="middle">

                                            <img src="../../recursos/imagenes/escudo.png" />

                                        </td>
                                        <td align="center" valign="middle" style="padding:20px; {$txtFuente12}">
                                            <b>Certificado de Existencia y Habitabilidad</b><br />
                                            <span style="{$txtFuente10}">Fecha de Emisión: {$txtFecha}</span><br />
                                            <span style="{$txtFuente10}">Fecha de visita: {$txtFechaVisita}</span>
                                        </td>
                                        <td width="150px" align="center" valign="middle">
                                            <img src="../../recursos/imagenes/bta_positiva_carta.jpg" />
                                        </td>
                                    </tr>
                                </table><br />

                                <!-- INFORMACION GENERAL -->
                                <table cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}">
                                    <tr><td colspan="3" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4"><b>Información General</b></td></tr>

                                    <!-- NOMBRE DEL BENEFICIARIO -->
                                    <tr>
                                        <td><b>Nombre del Beneficiario:</b></td>
                                        <td><b>Documento</b></td>
                                        <td><b>Teléfono</b></td>
                                    </tr>
                                    <tr>
                                        <td>{$claCiudadano->txtNombre1} {$claCiudadano->txtNombre2} {$claCiudadano->txtApellido1} {$claCiudadano->txtApellido2}</td>
                                        <td>{$arrTipoDocumento.$tipoDocCiudadano} {$claCiudadano->numDocumento}</td>
                                        <td>{$claFormulario->numTelefono1} ó {$claFormulario->numTelefono2} Celular {$claFormulario->numCelular}</td>
                                    </tr>

                                    <!-- NOMBRE DEL VENDEDOR -->
                                    <tr>
                                        <td><b>Vendedor, Oferente y/o Constructor:</b></td>
                                        <td><b>Documento</b></td>
                                        <td><b>Teléfono</b></td>
                                    </tr>
                                    <tr>
                                        <td>{$txtNombreVendedor}</td>
                                        <td>{$arrTipoDocumento.$tipoDocVendedor} {$numDocumentoVendedor|number_format:0:',':'.'}</td>
                                        <td>{$numTelefonoVendedor}</td>
                                    </tr>

                                    <!-- DIRECCION DEL PREDIO -->
                                    <tr>
                                        <td><b>Nombre del Proyecto:</b></td>
                                        <td><b>Dirección</b></td>
                                        <td><b>Tipo de Oferta</b></td>
                                    </tr>

                                    <!-- PROYECTO, MODALIDAD -->
                                    <tr>
                                        <td>{$arrProyectos.$seqProyecto}</td>
                                        <td>{$txtDireccionInmueble}</td>
                                        <td>{$arrModalidad.$seqModalidad} - {$arrSolucionDescripcion.$seqModalidad.$seqSolucion}</td>
                                    </tr>			

                                    <!-- LOCALIDAD / BARRIO O VEREDA -->
                                    <tr>
                                        <td><b>Localidad:</b></td>
                                        <td><b>Barrio o Vereda</b></td>
                                        <td><b>Tipo de Predio</b></td>
                                    </tr>
                                    <tr>
                                        <td>{$arrLocalidad.$seqLocalidad}</td>
                                        <td>{$txtBarrio}</td>
                                        <td>{$txtTipoPredio}</td>
                                    </tr>

                                </table><br />		

                                <table cellspacing="5" cellpadding="0" border="0" width="100%" style="{$txtFuente10}">
                                    <tr><td colspan="3" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4">
                                            <b>Registro Fotográfico</b>
                                        </td></tr>
                                        {math equation="x * y" x=$smarty.section.paginas.index y=6 assign=numLoops}
                                        {math equation="x - y" x=$smarty.section.paginas.index y=1 assign=numIndice}
                                        {math equation="x * y" x=$numIndice y=6 assign=numStart}
                                        {section name=lineas loop=$numLoops start=$numStart}
                                            {assign var=numPosicion value=$smarty.section.lineas.index}


                                        {if fmod( $numPosicion , 3 ) == 0}
                                            <tr>
                                            {/if}

                                            <td width="33%" 
                                                height="250px" 
                                                style="padding:5px; border: 1px dotted #999999;"
                                                valign="top"
                                                >
                                                {if isset( $claDesembolso->arrTecnico.imagenes.$numPosicion )}
                                                    <b>{$claDesembolso->arrTecnico.imagenes.$numPosicion.nombre}</b><hr>
                                                        <center>
                                                            <img src="../../recursos/imagenes/desembolsos/{$claDesembolso->arrTecnico.imagenes.$numPosicion.ruta}"
                                                                 width="220px"
                                                                 height="220px"
                                                                 />
                                                        </center>
                                                    {else}
                                                        &nbsp;
                                                    {/if}
                                            </td>

                                            {if $numPosicion != 0}
                                                {if fmod( ( $numPosicion + 1 ) , 3 ) == 0}
                                                </tr></tr>
                                            {/if}
                                        {/if}

                                    {/section}
                                </table>

                                <p class="salto">&nbsp;</p>


                            {/section}

                            <!-- FIN PAGINAS DINAMICAS -->

                        {/if}

                    </body>
                    </html>