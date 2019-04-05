<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <!-- Estilos CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
              integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        {literal}
            <style type="text/css">
                p.salto {
                    page-break-after: always;
                }
                body {
                    margin-top: 10px;
                }
            </style>
        {/literal}

    </head>
    <body>

        <div class="container">
            <div class="col-sm-12">

                <!-- INICIO PAGINA 1 -->

                <!-- TITULO DE LA CARTA DE IMPRESION -->
                <table class="table table-bordered" style="width: 100%;">
                    <tr>
                        <td width="150px" height="80px" align="center" valign="middle" style="padding-top: 20px;">
                            <img src="../../recursos/imagenes/escudo.png">
                        </td>
                        <td align="center" valign="middle" style="padding:20px; {$txtFuente12}">
                            <b>ALCALDIA MAYOR DE BOGOTA</b><br>
                            SECRETARIA DEL HABITAT<br>
                            <b>Certificado de Existencia y Habitabilidad</b><br>
                            <span style="{$txtFuente10}">Fecha de Visita: {$txtFechaVisita}</span><br>
                            <span style="{$txtFuente10}">Fecha de Expedición: {$txtFechaExpedicion}</span><br>
                            <span style="{$txtFuente10}">Fecha de Impresion: {$txtFecha}</span><br>
                        </td>
                        <td width="150px" align="center" valign="middle" style="padding-top: 20px;">
                            <img src="../../recursos/imagenes/bta_positiva_carta.jpg">
                        </td>
                    </tr>
                </table>

                <!-- INFORMACION GENERAL -->
                <table cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}">
                    <tr>
                        <td colspan="3" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4">
                            <b>Información General</b>
                        </td>
                    </tr>
                    <tr>
                        <td width="200px"><b>Proyecto</b></td>
                        <td width="240px"><b>Conjunto</b></td>
                        <td><b>Unidad</b></td>
                    </tr>
                    <tr>
                        <td>{$objTecnico->txtProyecto}</td>
                        <td>{$objTecnico->txtConjunto}</td>
                        <td>{$objTecnico->txtNombreUnidad}</td>
                    </tr>
                    <tr>
                        <td><b>Dirección</b></td>
                        <td><b>Localidad</b></td>
                        <td><b>Barrio o Vereda</b></td>
                    </tr>
                    <tr>
                        <td>{$objTecnico->txtDireccion}</td>
                        <td>{$objTecnico->txtLocalidad}</td>
                        <td>{$objTecnico->txtBarrio}</td>
                    </tr>
                    <tr>
                        <td><b>Licencia de construcción</b></td>
                        <td><b>Fecha Ejecutoria</b></td>
                        <td><b>Curaduría Urbana</b></td>
                    </tr>
                    <tr>
                        <td>{$objTecnico->txtLicenciaConstruccion}</td>
                        <td>{$objTecnico->fchEjecutaLicConstruccion}</td>
                        <td>{$objTecnico->txtExpideLicenciaUrbanismo}</td>
                    </tr>
                </table><br>

                <!-- CONDICIONES ESPACIALES DE LA VIVIENDA -->
                <table cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}">
                    <tr><td colspan="5" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4"><b>Condiciones Espaciales de la Vivienda</b></td></tr>

                    <tr>
                        <td style="border-bottom: 1px solid #999999" height="23px" width="150px"><b>Descripción</b></td>
                        <td style="border-bottom: 1px solid #999999" width="70px" align="right"><b>Largo (m)</b></td>
                        <td style="border-bottom: 1px solid #999999" width="70px" align="right"><b>Ancho (m)</b></td>
                        <td style="border-bottom: 1px solid #999999" width="70px" align="right"><b>Área (m<sup>2</sup>)</b></td>
                        <td style="border-bottom: 1px solid #999999; padding-left:10px"><b>Observaciones</b></td>
                    </tr>

                    <!-- ESPACIO MULTIPLE -->
                    <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Espacio Múltiple</b></td>
                        <td align="right">{$objTecnico->numLargoMultiple|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAnchoMultiple|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAreaMultiple|number_format:2:',':'.'}</td>
                        <td style="padding-left:10px">{$objTecnico->txtMultiple}</td>
                    </tr>

                    <!-- ALCOBA1 -->
                    <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Alcoba 1</b></td>
                        <td align="right">{$objTecnico->numLargoAlcoba1|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAnchoAlcoba1|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAreaAlcoba1|number_format:2:',':'.'}</td>
                        <td style="padding-left:10px">{$objTecnico->txtAlcoba1}</td>
                    </tr>

                    <!-- ALCOBA2 -->
                    <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Alcoba 2</b></td>
                        <td align="right">{$objTecnico->numLargoAlcoba2|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAnchoAlcoba2|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAreaAlcoba2|number_format:2:',':'.'}</td>
                        <td style="padding-left:10px">{$objTecnico->txtAlcoba2}</td>
                    </tr>

                    <!-- ALCOBA3 -->
                    <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Alcoba 3</b></td>
                        <td align="right">{$objTecnico->numLargoAlcoba3|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAnchoAlcoba3|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAreaAlcoba3|number_format:2:',':'.'}</td>
                        <td style="padding-left:10px">{$objTecnico->txtAlcoba3}</td>
                    </tr>

                    <!-- COCINA -->
                    <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Cocina</b></td>
                        <td align="right">{$objTecnico->numLargoCocina|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAnchoCocina|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAreaCocina|number_format:2:',':'.'}</td>
                        <td style="padding-left:10px">{$objTecnico->txtCocina}</td>
                    </tr>

                    <!-- BANO1 -->
                    <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Baño 1</b></td>
                        <td align="right">{$objTecnico->numLargoBano1|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAnchoBano1|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAreaBano1|number_format:2:',':'.'}</td>
                        <td style="padding-left:10px">{$objTecnico->txtBano1}</td>
                    </tr>

                    <!-- BANO2 -->
                    <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Baño 2</b></td>
                        <td align="right">{$objTecnico->numLargoBano2|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAnchoBano2|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAreaBano2|number_format:2:',':'.'}</td>
                        <td style="padding-left:10px">{$objTecnico->txtBano2}</td>
                    </tr>

                    <!-- LAVANDERIA -->
                    <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Area de Lavanderia</b></td>
                        <td align="right">{$objTecnico->numLargoLavanderia|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAnchoLavanderia|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAreaLavanderia|number_format:2:',':'.'}</td>
                        <td style="padding-left:10px">{$objTecnico->txtLavanderia}</td>
                    </tr>

                    <!-- CIRCULACIONES -->
                    <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Circulaciones</b></td>
                        <td align="right">{$objTecnico->numLargoCiculaciones|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAnchoCirculaciones|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAreaCirculaciones|number_format:2:',':'.'}</td>
                        <td style="padding-left:10px">{$objTecnico->txtCirculaciones}</td>
                    </tr>

                    <!-- PATIO -->
                    <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Patio</b></td>
                        <td align="right">{$objTecnico->numLargoPatio|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAnchoPatio|number_format:2:',':'.'}</td>
                        <td align="right">{$objTecnico->numAreaPatio|number_format:2:',':'.'}</td>
                        <td style="padding-left:10px">{$objTecnico->txtPatio}</td>
                    </tr>

                    <!-- TOTAL AREA CONSTRUIDA-->
                    <tr>
                        <td>&nbsp;</td>
                        <td align="right" colspan="2" style="padding-right:10px"><b>Área Total Construida</b></td>
                        <td align="right"><b>{$objTecnico->numAreaTotal|number_format:2:',':'.'}</b></td>
                        <td>&nbsp;</td>
                    </tr>

                </table><br>

                <!-- CONDICIONES FISICAS Y ESTRUCTURALES -->
                <table cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}">
                    <tr><td colspan="5" style="padding:3px; {$txtFuente12}" bgcolor="#E4E4E4"><b>Condiciones Físicas y Estructurales de la Vivienda</b></td></tr>

                    <tr>
                        <td style="border-bottom: 1px solid #999999" height="20px" width="150px"><b>Descripción</b></td>
                        <td style="border-bottom: 1px solid #999999" width="150px"><b>Estado</b></td>
                        <td style="border-bottom: 1px solid #999999;"><b>Observaciones</b></td>
                    </tr>

                    <!-- CIMENTACION -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Cimentación</b></td>
                        <td>{$objTecnico->txtEstadoCimentacion|ucwords}</td>
                        <td>{$objTecnico->txtCimentacion}</td>
                    </tr>

                    <!-- PLACA DE ENTREPISO	-->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Placas de Entrepiso</b></td>
                        <td>{$objTecnico->txtEstadoPlacaEntrepiso|ucwords}</td>
                        <td>{$objTecnico->txtPlacaEntrepiso}</td>
                    </tr>

                    <!-- MAMPOSTERIA -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Mampostería</b></td>
                        <td>{$objTecnico->txtEstadoMamposteria|ucwords}</td>
                        <td>{$objTecnico->txtMamposteria}</td>
                    </tr>

                    <!-- CUBIERTA -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Cubierta</b></td>
                        <td>{$objTecnico->txtEstadoCubierta|ucwords}</td>
                        <td>{$objTecnico->txtCubierta}</td>
                    </tr>

                    <!-- VIGAS -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Vigas</b></td>
                        <td>{$objTecnico->txtEstadoVigas|ucwords}</td>
                        <td>{$objTecnico->txtVigas}</td>
                    </tr>

                    <!-- COLUMNAS -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Columnas</b></td>
                        <td>{$objTecnico->txtEstadoColumnas|ucwords}</td>
                        <td>{$objTecnico->txtColumnas}</td>
                    </tr>

                    <!-- PANETES -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Pañetes</b></td>
                        <td>{$objTecnico->txtEstadoPanetes|ucwords}</td>
                        <td>{$objTecnico->txtPanetes}</td>
                    </tr>

                    <!-- ENCHAPES Y ACCESORIOS -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Enchapes y Accesorios</b></td>
                        <td>{$objTecnico->txtEstadoEnchapes|ucwords}</td>
                        <td>{$objTecnico->txtEnchapes}</td>
                    </tr>

                    <!-- ACABADOS PISOS -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Acabados Pisos</b></td>
                        <td>{$objTecnico->txtEstadoAcabados|ucwords}</td>
                        <td>{$objTecnico->txtAcabados}</td>
                    </tr>

                    <!-- INSTALACIONES HIDRAULICAS -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Instalaciones Hidráulicas</b></td>
                        <td>{$objTecnico->txtEstadoHidraulicas|ucwords}</td>
                        <td>{$objTecnico->txtHidraulicas}</td>
                    </tr>

                    <!-- INSTALACIONES HIDRAULICAS -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Instalaciones Eléctricas</b></td>
                        <td>{$objTecnico->txtEstadoElectricas|ucwords}</td>
                        <td>{$objTecnico->txtElectricas}</td>
                    </tr>

                    <!-- INSTALACIONES SANITARIAS -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Instalaciones Sanitarias</b></td>
                        <td>{$objTecnico->txtEstadoSanitarias|ucwords}</td>
                        <td>{$objTecnico->txtSanitarias}</td>
                    </tr>

                    <!-- INSTALACIONES HIDRAULICAS -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Instalaciones Gas</b></td>
                        <td>{$objTecnico->txtEstadoGas|ucwords}</td>
                        <td>{$objTecnico->txtGas}</td>
                    </tr>

                    <!-- CARPINTERIA MADERA -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Carpintería Madera</b></td>
                        <td>{$objTecnico->txtEstadoMadera|ucwords}</td>
                        <td>{$objTecnico->txtMadera}</td>
                    </tr>

                    <!-- CARPINTERIA METALICA -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Carpinteria Metalica</b></td>
                        <td>{$objTecnico->txtEstadoMetalica|ucwords}</td>
                        <td>{$objTecnico->txtMetalica}</td>
                    </tr>

                    <!-- LAVADERO -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Lavadero</b></td>
                        <td>{$objTecnico->numLavadero|number_format:0:',':'.'}</td>
                        <td>{$objTecnico->txtLavadero}</td>
                    </tr>

                    <!-- LAVAPLATOS -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Lavaplatos</b></td>
                        <td>{$objTecnico->numLavaplatos|number_format:0:',':'.'}</td>
                        <td>{$objTecnico->txtLavaplatos}</td>
                    </tr>

                    <!-- LAVAMANOS -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Lavamanos</b></td>
                        <td>{$objTecnico->numLavamanos|number_format:0:',':'.'}</td>
                        <td>{$objTecnico->txtLavamanos}</td>
                    </tr>

                    <!-- SANITARIO -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Sanitario</b></td>
                        <td>{$objTecnico->numSanitario|number_format:0:',':'.'}</td>
                        <td>{$objTecnico->txtSanitario}</td>
                    </tr>

                    <!-- DUCHA -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Ducha</b></td>
                        <td>{$objTecnico->numDucha|number_format:0:',':'.'}</td>
                        <td>{$objTecnico->txtDucha}</td>
                    </tr>

                    <!-- VIDRIOS-->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Vidrios</b></td>
                        <td>{$objTecnico->txtEstadoVidrios|ucwords}</td>
                        <td>{$objTecnico->txtVidrios}</td>
                    </tr>

                    <!-- PINTURA -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Pintura</b></td>
                        <td>{$objTecnico->txtEstadoPintura|ucwords}</td>
                        <td>{$objTecnico->txtPintura}</td>
                    </tr>

                    <!-- OTROS -->
                    <tr bgcolor="{cycle name=c2 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Otros</b></td>
                        <td>{$objTecnico->txtOtros|ucwords}</td>
                        <td>{$objTecnico->txtObservacionOtros}</td>
                    </tr>
                </table>

                <!-- FIN PAGINA 1 -->

                <p class="salto">&nbsp;</p>

                <!-- INICIO PAGINA 2 -->

                <!-- TITULO DE LA CARTA DE IMPRESION -->
                <table class="table table-bordered" style="width: 100%;">
                    <tr>
                        <td width="150px" height="80px" align="center" valign="middle" style="padding-top: 20px;">
                            <img src="../../recursos/imagenes/escudo.png">
                        </td>
                        <td align="center" valign="middle" style="padding:20px; {$txtFuente12}">
                            <b>ALCALDIA MAYOR DE BOGOTA</b><br>
                            SECRETARIA DEL HABITAT<br>
                            <b>Certificado de Existencia y Habitabilidad</b><br>
                            <span style="{$txtFuente10}">Fecha de Visita: {$txtFechaVisita}</span><br>
                            <span style="{$txtFuente10}">Fecha de Expedición: {$txtFechaExpedicion}</span><br>
                            <span style="{$txtFuente10}">Fecha de Impresion: {$txtFecha}</span><br>
                        </td>
                        <td width="150px" align="center" valign="middle" style="padding-top: 20px;">
                            <img src="../../recursos/imagenes/bta_positiva_carta.jpg">
                        </td>
                    </tr>
                </table>

                <!-- INFORMACION GENERAL -->
                <table cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}">
                    <tr>
                        <td colspan="3" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4">
                            <b>Información General</b>
                        </td>
                    </tr>
                    <tr>
                        <td width="200px"><b>Proyecto</b></td>
                        <td width="240px"><b>Conjunto</b></td>
                        <td><b>Unidad</b></td>
                    </tr>
                    <tr>
                        <td>{$objTecnico->txtProyecto}</td>
                        <td>{$objTecnico->txtConjunto}</td>
                        <td>{$objTecnico->txtNombreUnidad}</td>
                    </tr>
                    <tr>
                        <td><b>Dirección</b></td>
                        <td><b>Localidad</b></td>
                        <td><b>Barrio o Vereda</b></td>
                    </tr>
                    <tr>
                        <td>{$objTecnico->txtDireccion}</td>
                        <td>{$objTecnico->txtLocalidad}</td>
                        <td>{$objTecnico->txtBarrio}</td>
                    </tr>
                    <tr>
                        <td><b>Licencia de construcción</b></td>
                        <td><b>Fecha Ejecutoria</b></td>
                        <td><b>Curaduría Urbana</b></td>
                    </tr>
                    <tr>
                        <td>{$objTecnico->txtLicenciaConstruccion}</td>
                        <td>{$objTecnico->fchEjecutaLicConstruccion}</td>
                        <td>{$objTecnico->txtExpideLicenciaUrbanismo}</td>
                    </tr>
                </table><br>

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
                        <td align="right">{$objTecnico->numContadorAgua}</td>
                        <td style="padding-left:10px;">{$objTecnico->txtEstadoConexionAgua|ucwords}</td>
                        <td style="padding-left:10px;">{$objTecnico->txtDescripcionAgua}</td>
                    </tr>

                    <!-- SERVICIO DE ENERGIA -->
                    <tr bgcolor="{cycle name=c3 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Servicio de Energía</b></td>
                        <td align="right">{$objTecnico->numContadorEnergia|number_format:0:',':'.'}</td>
                        <td style="padding-left:10px;">{$objTecnico->txtEstadoConexionEnergia|ucwords}</td>
                        <td style="padding-left:10px;">{$objTecnico->txtDescripcionEnergia}</td>
                    </tr>

                    <!-- SERVICIO DE ALCANTARILLADO -->
                    <tr bgcolor="{cycle name=c3 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Servicio de Alcantarillado</b></td>
                        <td align="right">{$objTecnico->numContadorAlcantarillado|number_format:0:',':'.'}</td>
                        <td style="padding-left:10px;">{$objTecnico->txtEstadoConexionAlcantarillado|ucwords}</td>
                        <td style="padding-left:10px;">{$objTecnico->txtDescripcionAlcantarillado}</td>
                    </tr>

                    <!-- SERVICIO DE GAS -->
                    <tr bgcolor="{cycle name=c3 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Servicio de Gas</b></td>
                        <td align="right">{$objTecnico->numContadorGas}</td>
                        <td style="padding-left:10px;">{$objTecnico->txtEstadoConexionGas|ucwords}</td>
                        <td style="padding-left:10px;">{$objTecnico->txtDescripcionGas}</td>
                    </tr>

                    <!-- SERVICIO DE telefono -->
                    <tr bgcolor="{cycle name=c3 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Servicio de Teléfono</b></td>
                        <td align="right">{$objTecnico->numContadorTelefono|number_format:0:',':'.'}</td>
                        <td style="padding-left:10px;">{$objTecnico->txtEstadoConexionTelefono|ucwords}</td>
                        <td style="padding-left:10px;">{$objTecnico->txtDescripcionTelefono}</td>
                    </tr>

                    <!-- ANDENES -->
                    <tr bgcolor="{cycle name=c3 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Andenes</b></td>
                        <td align="right">&nbsp;</td>
                        <td style="padding-left:10px;">{$objTecnico->txtEstadoAndenes|ucwords}</td>
                        <td style="padding-left:10px;">{$objTecnico->txtDescripcionAndenes}</td>
                    </tr>

                    <!-- VIAS -->
                    <tr bgcolor="{cycle name=c3 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Vias</b></td>
                        <td align="right">&nbsp;</td>
                        <td style="padding-left:10px;">{$objTecnico->txtEstadoVias|ucwords}</td>
                        <td style="padding-left:10px;">{$objTecnico->txtDescripcionVias}</td>
                    </tr>

                    <!-- SERVICIOS COMUNALES -->
                    <tr bgcolor="{cycle name=c3 values="#EAEAEA,#FFFFFF"}">
                        <td><b>Servicios Comunales</b></td>
                        <td align="right">&nbsp;</td>
                        <td style="padding-left:10px;">{$objTecnico->txtEstadoServiciosComunales|ucwords}</td>
                        <td style="padding-left:10px;">{$objTecnico->txtDescripcionServiciosComunales}</td>
                    </tr>

                    <tr><td colspan="4">&nbsp;</td></tr>

                    <!-- DESCRIPCION DE LA VIVIENDA -->
                    <tr><td colspan="4" style="border-top: 1px solid #999999; border-bottom: 1px solid #999999;">
                            <b>Descripcion de la vivienda</b>
                        </td></tr>
                    <tr><td colspan="4" style="padding-left:20px; padding-right:20px; padding-top:5px; padding-bottom:5px; border-bottom: 1px solid #999999;" align="justify">
                            {$objTecnico->txtDescripcionVivienda}
                        </td></tr>

                </table><br>

                <!-- TEXTOS -->
                <table cellspacing="0" cellpadding="0" border="0" width="100%" style="{$txtFuente10}">

                    <!-- CRITERIOS DE EXISTENCIA Y HABITABILIDAD -->
                    <tr>
                        <td>
                            <b>Cumple la vivienda con los requisitos de existencia y habitabilidad:</b> {$objTecnico->txtExistencia|ucwords}&nbsp;
                            {if $objTecnico->txtExistencia|ucwords == 'SI' } <b> Viabilizó: </b> &nbsp;{$objTecnico->txtAprobo} {/if}
                            <br/><br/>
                    <u>Recomendaciones:</u><br>
                    {$objTecnico->txtDescripcionExistencia}&nbsp;
                    </td>
                    </tr>
                    <!-- TEXTO DE PIE DE PAGINA PAGINA 2 -->
                    <tr>
                        <td align="justify" style="padding-right: 20px;">
                            El presente certificado se expide con base en una visita adelantada por parte del equipo técnico
                            de la Subdirección de Recursos Públicos y/o Privados de la Subsecretaría de Gestión Financiera; en esta no se observa
                            que la vivienda presente afectaciones o fallas estructurales que pongan en riesgo a sus habitantes
                            o afecten la habitabilidad del inmueble. La vivienda dispone de los servicios públicos básicos
                            y cumple con lo establecido en la normatividad vigente.<br>
                            La Secretaria Distrital de Hábitat <strong>NO</strong> se hace responsable por la calidad estructural de la vivienda,
                            la calidad de los materiales empleados, ni la correcta ejecución del proceso constructivo adelantado en la construcción de esta vivienda.
                            <!--El presente certificado se expide a los {$numDiaActual} dias del mes de {$txtMesActual} de {$numAnoActual}.-->
                        </td>
                    </tr>

                    <!-- FIRMA DEL ARQUITECTO -->
                    <tr>
                        <td>
                            <table valign="bottom"  cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}" >
                                <tr>
                                    <td height="120px" valign="bottom" align="right" style="padding: 20px">
                                        _____________________________________________<br>
                                        M.P. {$txtMatriculaProfesional}<br>
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

                {assign var=numImagenes value=$objTecnico->imagenes|@count}
                {math equation="( x / y )" x=$numImagenes y=6 assign=numPaginas}
                {math equation="x + y" x=$numPaginas y=1 assign=numPaginas}

                {section name=paginas loop=$numPaginas|@ceil start=1}

                    <!-- TITULO DE LA CARTA DE IMPRESION -->
                    <table class="table table-bordered" style="width: 100%;">
                        <tr>
                            <td width="150px" height="80px" align="center" valign="middle" style="padding-top: 20px;">
                                <img src="../../recursos/imagenes/escudo.png">
                            </td>
                            <td align="center" valign="middle" style="padding:20px; {$txtFuente12}">
                                <b>ALCALDIA MAYOR DE BOGOTA</b><br>
                                SECRETARIA DEL HABITAT<br>
                                <b>Certificado de Existencia y Habitabilidad</b><br>
                                <span style="{$txtFuente10}">Fecha de Visita: {$txtFechaVisita}</span>
                                <span style="{$txtFuente10}">Fecha de Expedición: {$txtFechaExpedicion}</span>
                                <span style="{$txtFuente10}">Fecha de Impresion: {$txtFecha}</span><br>
                            </td>
                            <td width="150px" align="center" valign="middle" style="padding-top: 20px;">
                                <img src="../../recursos/imagenes/bta_positiva_carta.jpg">
                            </td>
                        </tr>
                    </table>

                    <!-- INFORMACION GENERAL -->
                    <table cellspacing="0" cellpadding="1" border="0" width="100%" style="{$txtFuente10}">
                        <tr>
                            <td colspan="3" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4">
                                <b>Información General</b>
                            </td>
                        </tr>
                        <tr>
                            <td width="200px"><b>Proyecto</b></td>
                            <td width="240px"><b>Conjunto</b></td>
                            <td><b>Unidad</b></td>
                        </tr>
                        <tr>
                            <td>{$objTecnico->txtProyecto}</td>
                            <td>{$objTecnico->txtConjunto}</td>
                            <td>{$objTecnico->txtNombreUnidad}</td>
                        </tr>
                        <tr>
                            <td><b>Dirección</b></td>
                            <td><b>Localidad</b></td>
                            <td><b>Barrio o Vereda</b></td>
                        </tr>
                        <tr>
                            <td>{$objTecnico->txtDireccion}</td>
                            <td>{$objTecnico->txtLocalidad}</td>
                            <td>{$objTecnico->txtBarrio}</td>
                        </tr>
                        <tr>
                            <td><b>Licencia de construcción</b></td>
                            <td><b>Fecha Ejecutoria</b></td>
                            <td><b>Curaduría Urbana</b></td>
                        </tr>
                        <tr>
                            <td>{$objTecnico->txtLicenciaConstruccion}</td>
                            <td>{$objTecnico->fchEjecutaLicConstruccion}</td>
                            <td>{$objTecnico->txtExpideLicenciaUrbanismo}</td>
                        </tr>
                    </table><br>

                    <!-- REGISTRO FOTOGRAFICO -->
                    <table cellspacing="5" cellpadding="0" border="0" width="100%" style="{$txtFuente10}">
                        <tr>
                            <td colspan="3" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4">
                                <b>Registro Fotográfico</b>
                            </td>
                        </tr>

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
                                    {if isset( $objTecnico->imagenes.$numPosicion )}
                                        <b>{$objTecnico->imagenes.$numPosicion.nombre}</b><hr>
                                <center>
                                    <img src="../../recursos/imagenes/desembolsos/{$objTecnico->imagenes.$numPosicion.ruta}"
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

            </div>
        </div>

    </body>

</html>