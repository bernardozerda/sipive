<!-- PLANTILLA DE POSTULACION CON PESTAÑAS -->
<form name="frmActualizacion" id="frmActualizacion" onSubmit="pedirConfirmacion('mensajes', this, './contenidos/proyectos/pedirConfirmacion.php');
        return false;" autocomplete=off >
    <!-- CODIGO PARA EL POP UP DE SEGUIMIENTO -->
    {assign var=seqPryEstadoProceso value=$objFormularioProyecto->seqPryEstadoProceso}
    {include file='proyectos/pedirSeguimiento.tpl'}
    <br>
    <table cellspacing="0" cellpadding="0" border="0" width="100%" style="z-index:999999;">
        <tr>
            <td style='display: none' width="150px" align="center">
            </td>
            <td></td><td></td><td></td>
            <td align="right" style="padding-right: 10px;" width="250px">
                <input type="submit" name="salvar" id="salvar" value="Salvar Actualizaci&oacute;n">
            </td>
        </tr>
    </table>
    <br>
    <div id="postulacion" class="yui-navset" style="width:100%; text-align:left;">
        <ul class="yui-nav">
            <li class="selected"><a href="#frm"><em>Formulario</em></a></li>
            <li><a href="#seg"><em>Seguimiento</em></a></li>
        </ul>
        <div class="yui-content">
            <!-- FORMULARIO DE ACTUALIZACION -->	    
            <div id="frm" style="height:850px;">
                <div id="pestanasPostulacion" class="yui-navset" style="width:100%; text-align:left;">
                    <ul class="yui-nav">
                        <li class="selected"><a href="#datosHogar"><em>Datos Proyecto</em></a></li>
                        <li><a href="#datosOferente"><em>Datos Oferente</em></a></li>
                        <li><a href="#datosFinancieros"><em>Datos Financieros</em></a></li>
                        <li><a href="#tiposVivienda"><em>Tipos Vivienda</em></a></li>
                        <li><a href="#conjuntosResidenciales"><em>Conjuntos Residenciales</em></a></li>
                        <li><a href="#datosCronograma"><em>Cronograma</em></a></li>
                    </ul>
                    <div class="yui-content">
                        <!-- DATOS DEL PROYECTO -->
                        <div id="datosHogar" style="height:800px;"><p>
                                <!-- ESTADO DEL PROCESO -->
                            <table cellspacing="0" cellpadding="2" border="0" width="100%" height="25px">
                                <tr bgcolor="#E4E4E4">
                                    <td align="right"><b>Estado del proceso:</b></td>
                                    <td>{if $seqPryEstadoProceso == "1"} {$arrEstadosProceso.1} {else} {$arrEstadosProceso.2} {/if}
                                        <input type="hidden" name="seqPryEstadoProceso" id="seqPryEstadoProceso" value="2">
                                    </td>
                                    <td align="right"><b>Fecha de Inscripci&oacute;n:</b></td>
                                    <td>{$objFormularioProyecto->fchInscripcion}&nbsp;</td>
                                    <td align="right"><b>Fecha de Actualizaci&oacute;n:</b></td>
                                    <td>{$objFormularioProyecto->fchUltimaActualizacion}&nbsp;</td>
                                </tr>
                                <tr><td height="5px"></td></tr>
                            </table>
                            <!-- DATOS BASICOS DEL PROYECTO-->
                            {include file="proyectos/secDatosProyecto.tpl"}
                        </div>

                        <!-- DATOS DEL OFERENTE -->
                        <div id="datosOferente" style="height:400px;">
                            {include file="proyectos/secDatosOferente.tpl"}
                        </div>

                        <!-- DATOS FINANCIEROS -->
                        <div id="datosFinancieros" style="height:450px;">
                            {include file="proyectos/secDatosFinancieros.tpl"}
                        </div>

                        <!-- TIPOS DE VIVIENDA (ESTRUCTURA DEL PROYECTO) -->
                        <div id="tiposVivienda" style="height:400px;">
                            {include file="proyectos/secTipoVivienda.tpl"}
                        </div>

                        <!-- CONJUNTOS RESIDENCIALES (SUBPROYECTOS) -->
                        <div id="conjuntosResidenciales" style="height:400px;">
                            {include file="proyectos/secConjuntoResidencial.tpl"}
                        </div>

                        <!-- CRRONOGRAMA DE OBRAS -->
                        <div id="datosCronograma" style="height:400px;">
                            {include file="proyectos/secCronogramaFechas.tpl"}
                        </div>
                    </div>
                </div>
            </div>
            <!-- SEGUIMIENTO AL PROYECTO -->
            <div id="seg" style="height:401px; overflow:auto">
                {include file="seguimientoProyectos/seguimientoFormulario.tpl"}
                <div id="contenidoBusqueda" >
                    {include file="seguimientoProyectos/buscarSeguimiento.tpl"}
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="seqProyectoEditar" name="seqProyectoEditar" value="{$objFormularioProyecto->seqProyecto}">
    <input type="hidden" name="txtArchivo" value="./contenidos/proyectos/salvarActualizacion.php">
</form>

<div id="postulacionTabView"></div>
<div id="objDireccionOculto" style="display:none"></div>
<div id="objDireccionOcultoSolucion" style="display:none"></div>