
{assign var=resumenPrograma 				value=$arrExportables.resumenPrograma}
{assign var=estadoDeCorte 					value=$arrExportables.estadoDeCorte}
{assign var=cartasAsignacion 				value=$arrExportables.cartasAsignacion}
{assign var=formsEliminados 				value=$arrExportables.formsEliminados}
{assign var=numIdRepetido 					value=$arrExportables.numIdRepetido}
{assign var=inscritosNoCC 					value=$arrExportables.inscritosNoCC}
{assign var=edadTDvsFP 						value=$arrExportables.edadTDvsFP}
{assign var=TDPasaporteExtr 				value=$arrExportables.TDPasaporteExtr}
{assign var=condicionME 					value=$arrExportables.condicionME}
{assign var=ingresosReglamento 				value=$arrExportables.ingresosReglamento}
{assign var=dirSoacha 						value=$arrExportables.dirSoacha}
{assign var=beneficiarioSubsidio 			value=$arrExportables.beneficiarioSubsidio}
{assign var=beneficiariosCajaCompensacion 	value=$arrExportables.beneficiariosCajaCompensacion}
{assign var=solCierreFinanciero 			value=$arrExportables.solCierreFinanciero}
{assign var=VRSubsidioMejoramiento 			value=$arrExportables.VRSubsidioMejoramiento}
{assign var=ModSolvsSubsidio 				value=$arrExportables.ModSolvsSubsidio}
{assign var=ahorroCreditoSubsidioSinSoporte	value=$arrExportables.ahorroCreditoSubsidioSinSoporte}
{assign var=nombresMiembrosHogar 			value=$arrExportables.nombresMiembrosHogar}
{assign var=datosContacto 					value=$arrExportables.datosContacto}
{assign var=todosEstado 					value=$arrExportables.todosEstado}
{assign var=reporteGeneral 					value=$arrExportables.reporteGeneral}
{assign var=analisisPoblacion 				value=$arrExportables.analisisPoblacion}
{assign var=sdvMetroSDHT 					value=$arrExportables.sdvMetroSDHT}
{assign var=sdvMarzo0910 					value=$arrExportables.sdvMarzo0910}
{assign var=formsPostulados 				value=$arrExportables.formsPostulados}
{assign var=listadoMayorEdad 				value=$arrExportables.listadoMayorEdad}
{assign var=directiva013 					value=$arrExportables.directiva013}
{assign var=reporteSeguimiento 				value=$arrExportables.reporteSeguimiento}
{assign var=reporteEscrituracion 			value=$arrExportables.reporteEscrituracion}
{assign var=reporteEstudioTitulos 			value=$arrExportables.reporteEstudioTitulos}
{assign var=reporteCierre 					value=$arrExportables.reporteCierre}
{assign var=reporteCierreMejoramiento 		value=$arrExportables.reporteCierreMejoramiento}
{assign var=reporteInscritos 				value=$arrExportables.reporteInscritos}
{assign var=reporteInscritosSinActualizar	value=$arrExportables.reporteInscritosSinActualizar}
{assign var=reporteDesembolsos 				value=$arrExportables.reporteDesembolsos}
{assign var=reporteTecnico 					value=$arrExportables.reporteTecnico}
{assign var=pasivosExigibles				value=$arrExportables.pasivosExigibles}
{assign var=casaMano                        value=$arrExportables.casaMano}
{assign var=x 								value=1}
{assign var=backColor 						value=E4E4E4}
{assign var=actaVisita						value=$arrExportables.actaVisita}
{assign var=permisos                        value=$arrExportables.permisos}
{assign var=seguimientoDesembolsos 			value=$arrExportables.seguimientoDesembolsos}
{assign var=cartasMovilizacion 				value=$arrExportables.cartasMovilizacion}
{assign var=hogaresCalificados 				value=$arrExportables.hogaresCalificados}
{assign var=baseMetrovivienda 				value=$arrExportables.baseMetrovivienda}
{assign var=reporteAsignadosAAD 			value=$arrExportables.reporteAsignadosAAD}
{assign var=reporteAsignacionUnidades 		value=$arrExportables.reporteAsignacionUnidades}
{assign var=reporteAsignacionUnidadesMejoramiento value=$arrExportables.reporteAsignacionUnidadesMejoramiento}
{assign var=reporteEpigrafeAAD 				value=$arrExportables.reporteEpigrafeAAD}
{assign var=reportePlantillaInformeSolucion	value=$arrExportables.reportePlantillaInformeSolucion}
{assign var=consultaCruces 					value=$arrExportables.consultaCruces}
{assign var=migracionCEMaDES 				value=$arrExportables.migracionCEMaDES}
{assign var=legalizacionGerencial			value=$arrExportables.legalizacionGerencial}
{assign var=reporteSeguimientoValores 		value=$arrExportables.reporteSeguimientoValores}
{assign var=reporteGeneralInscritos 		value=$arrExportables.reporteGeneralInscritos}
{assign var=Caracterizacion 				value=$arrExportables.Caracterizacion}
{assign var=reporteBasedeDatosPoblacional	value=$arrExportables.reporteBasedeDatosPoblacional}
{assign var=InformacionSolucion				value=$arrExportables.InformacionSolucion}
{assign var=plantillaestudiotitulos 		value=$arrExportables.plantillaestudiotitulos}
{assign var=plantillaEscrituracion 		    value=$arrExportables.plantillaEscrituracion}
{assign var=informeProyectos 		        value=$arrExportables.informeProyectos}
{assign var=reporteInformacionCvp 		    value=$arrExportables.reporteInformacionCvp}
{assign var=encuestasPive        		    value=$arrExportables.encuestasPive}
{assign var=inconsistenciasInscripcion	    value=$arrExportables.inconsistenciasInscripcion}
{assign var=estudioTitulosLeasing   	    value=$arrExportables.estudioTitulosLeasing}
{assign var=soporteResolucionVinculacion   value=$arrExportables.soporteResolucionVinculacion}

<form id="listadoExportable" >
    <center>
        <table cellspacing="0" cellpadding="3" border="0" width="90%">

            <tr>
                <td colspan="2">
                    <!-- FILTROS -->
                    <table width="98%" cellspacing="0" cellpadding="2">

                        <tr>
                            <td colspan="2" style="border:1px dotted #999999; padding:2px;" id="busquedaAvanzada" valign="top">
                                <table cellpadding="2" cellspacing="0" border="0" width="100%">
                                    <tr>
                                        <td style="width:14px; height:14px; cursor:pointer;" align="center">
                                            <div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; text-align:center;" 
                                                 onClick="cuadroBusquedaAvanzada('busquedaAvanzada');"
                                                 onMouseOver="this.style.backgroundColor = '#ADD8E6';"
                                                 onMouseOut="this.style.backgroundColor = '#F9F9F9';"
                                                 id="masbusquedaAvanzada"
                                                 >+</div>
                                        </td>
                                        <td>
                                            <a href="#" onClick="cuadroBusquedaAvanzada('busquedaAvanzada');" style="text-decoration: hidden;">Filtros</a>
                                        </td>
                                    </tr>
                                </table>

                                <div id="cuadrobusquedaAvanzada" style="display:none;">
                                    <table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#E4E4E4">
                                        <!-- FILTROS APLICADOS -->
                                        <tr>
                                            <td width="140px" class="tituloTabla">Fecha Inicio:</td>
                                            <td>
                                                <input	type="text" 
                                                       id="fchInicio" 
                                                       name="fchInicio"
                                                       style="width:100px;"
                                                       maxlength="10"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                       readonly 
                                                       /> <a href="#" onClick="calendarioPopUp('fchInicio');">Calendario</a>	
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="140px" class="tituloTabla">Fecha Fin:</td>
                                            <td>
                                                <input	type="text" 
                                                       id="fchFin" 
                                                       name="fchFin"
                                                       style="width:100px;"
                                                       maxlength="10"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                       readonly 
                                                       /> <a href="#" onClick="calendarioPopUp('fchFin');">Calendario</a>	
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tituloTabla">Grupo de Gestión</td>
                                            <td width="250px">
                                                <select name="seqGrupoGestion" 
                                                        id="seqGrupoGestion" 
                                                        style="width:250px"
                                                        onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                        onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                        onChange="obtenerGestion(this, 'tdGestionDesembolso', 'seqGestion');">
                                                    >
                                                    <option value="0">Seleccione Grupo</option>
                                                    {foreach from=$arrGrupoGestion key=seqGrupoGestion item=txtGrupoGestion}
                                                        <option value="{$seqGrupoGestion}">{$txtGrupoGestion}</option>
                                                    {/foreach}
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tituloTabla">Gestión</td>
                                            <td id="tdGestionDesembolso">
                                                <select name="seqGestion" 
                                                        id="seqGestion" 
                                                        style="width:250px"
                                                        onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                        onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                        >
                                                    <option value="0">Seleccione Gesti&oacute;n</select>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tituloTabla">Datos</td>
                                            <td>
                                                <input type='file'
                                                       id='fileSecuenciales'
                                                       name = 'fileSecuenciales' >
                                            </td>
                                        </tr>
                                    </table> 
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="divTablasReportesInscritos"></div>
                            </td>
                        </tr>


                    </table>
                </td>
            </tr>

            <tr>
                <th style="border-bottom: 1px dotted #999999" align="left" colspan="2">Listado Exportables</th>
            </tr>
            <tr><td height="5px" width="400px" style="border-bottom: 1px dotted #999999;" /></tr>

            {if $resumenPrograma == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Resumen del Programa</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporetResumenPrograma',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}

            {if $estadoDeCorte == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Estado De Corte</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteEstadoCorte',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}

            {if $cartasAsignacion == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Listado Cartas de Asignacion</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteCartasAsignacion',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}

            {if $formsEliminados == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Formularios Eliminados</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteFormsEliminados',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}

            {if $numIdRepetido == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Numero Id Repetido</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteIdRepetido',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}

            {if $inscritosNoCC == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Inscritos con PPAL con Tipo Documento diferente a C.C. o C.E.</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteInscritosNoCC',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}

            {if $edadTDvsFP == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Cruzar Edad Tipo Documento vs Fecha Postulacion</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteCruzarEdadTodFchPos',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}

            {if $TDPasaporteExtr == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Tipo Documento Pasaporte o Extranjeria</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteTipoDocPasExt',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}

            {if $condicionME == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Verificar Condicion Mayor de Edad</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteCondicionMayorEdad',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}

            {if $ingresosReglamento == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Verificar Ingresos vs Reglamento</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteIngresosVsReglamento',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}

            {if $dirSoacha == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Verificar Direccion o Barrio en Soacha</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteSoacha',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}

            {if $beneficiarioSubsidio == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Verificar si son realmente Beneficiarios del Subsidio</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteBeneficiariosSubsidio',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}

            {if $beneficiariosCajaCompensacion == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Verificar si son realmente Beneficiarios de Caja de Compensacion</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteBeneficiariosCajaCompensacion',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}


            {if $solCierreFinanciero == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Cruce tipo Solucion con Cierre Financiero (Verifica Hogares con Promesa CompraVenta) </td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteCierreFinancieroConPromesa',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}


            {if $VRSubsidioMejoramiento == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">VR Subsidio Mejoramiento</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteVRSubsidioMejoramiento',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}


            {if $ModSolvsSubsidio == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Verificar Modalidad, Solucion vs Subsidio</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteVerificaModalidadSolucion',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}


            {if $ahorroCreditoSubsidioSinSoporte == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Ahorro, Credito y/o Subsidio Nacional sin Soporte</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteAhorroCreditoSoporte',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}


            {if $nombresMiembrosHogar == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Nombres Miembros de Hogar</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteMiembrosHogar',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}


            {if $datosContacto == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Datos de Contacto</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteDatosDeContacto',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}


            {if $todosEstado == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Todos con Estado</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteTodosConEstado',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}


            {if $reporteGeneral == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Reporte General</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteGeneral',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}


            {if $analisisPoblacion == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Reporte Analisis Poblacion</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=ReporteAnalisisPoblacion',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}


            <!--{if $sdvMetroSDHT == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                            <td class="tituloCampo" align="left">Resumen SDV. Metrovivienda y SDHT</td>
                            <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                                    <a id="ReporteResumenMetroSDHT" 
                                            href="./descargas/RESUMEN%20SUBSIDIOS%20DICIEMBRE.xlsx">Exportable</a>
                            </td>
                    </tr>
            {/if}
            
            
                {if $sdvMarzo0910 == 1}
                        <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                                <td class="tituloCampo" align="left">Analisis programa SDV Marzo 2009-2010</td>
                                <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                                        <a id="ReporteAnalisisPrograma" 
                                                href="./descargas/Resumen%20SUBSIDIOS%20DE%20SDV.xlsx">Exportable</a>
                                </td>
                        </tr>
                {/if}-->

                {if $formsPostulados == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Formularios Postulados</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/subsidios/formulariosDigitados.php',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $listadoMayorEdad == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Listado de Mayores de edad</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/subsidios/listadoPostulados.php',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $directiva013 == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Reporte Directiva 013 (Beta)</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/subsidios/directiva013.php',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $reporteSeguimiento == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Reporte de Seguimiento</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/subsidios/reporteSeguimiento.php',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $reporteEscrituracion == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Reporte Validación Escrituración</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/desembolso/reporteEscrituracion.php',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}



                {if $reporteCierre == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Reporte de Cierre</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/subsidios/reporteCierre.php',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $reporteCierreMejoramiento == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Reporte de Cierre Mejoramiento</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/subsidios/reporteCierreMejoramiento.php',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $reporteSeguimientoValores == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Reporte de Seguimiento Valores</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/subsidios/reporteSeguimientoValores.php',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $reporteInscritos == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Reporte de Inscritos</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/subsidios/reporteLlamadas.php',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $reporteInscritosSinActualizar == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Reporte de Inscritos sin Actualizaci&oacute;n de Datos</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/subsidios/reporteLlamadasSinActualizar.php',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $reporteDesembolsos == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Reporte Desembolsos. Tramites Administrativos</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/subsidios/reporteDesembolsoTrasladoFin.php',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $reporteTecnico == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Reporte Tecnico</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/subsidios/reporteDesembolsoTecnica.php',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $pasivosExigibles == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Pasivos Exigibles</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/reportes/ReportesExportables.php?reporte=PasivosExigibles',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $actaVisita == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Constancia de Visitas</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/subsidios/reporteActaVisita.php',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $casaMano == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Casa en Mano</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/casaMano/reporteCasaMano.php',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}


                {if $permisos == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Permisos del sistema</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/reportes/permisosUsuario.php',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $seguimientoDesembolsos == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Seguimiento de desembolsos</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/reportes/ReportesExportables.php?reporte=seguimientoDesembolsos',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $cartasMovilizacion == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Cartas de Movilizaci&oacute;n de Recursos</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/reportes/ReportesExportables.php?reporte=CartasMovilizacion',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $hogaresCalificados == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Hogares Calificados</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/reportes/ReportesExportables.php?reporte=HogaresCalificados',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $baseMetrovivienda == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Base de Metrovivienda</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a href="./recursos/descargables/baseMetrovivienda.xls">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $reporteAsignadosAAD == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Reporte Asignados Actos Administrativos</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/reportes/ReportesExportables.php?reporte=reporteAsignadosAAD',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $reporteAsignacionUnidades == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Reporte Asignación Unidades</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a href="./contenidos/otros/analisisUnidadesAsignadas/analisisUnidadesAsignadas.php" target="_blank">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $reporteAsignacionUnidadesMejoramiento == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Reporte Asignacion Unidades Mejoramiento</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/reportes/ReportesExportables.php?reporte=reporteAsignacionUnidadesMejoramiento',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $reporteEpigrafeAAD == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Reporte Gral. Actos Admin.</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/reportes/ReportesExportables.php?reporte=reporteEpigrafeAAD',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $reportePlantillaInformeSolucion == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Reporte Informaci&oacute;n Proyecto</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/proyectos/reportePlantillaInformeSolucion.php',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $consultaCruces == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Consulta Cruces</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a href="./consultaCruces.php" target="_blank">Ir </a>
                        </td>
                    </tr>
                {/if}

                {if $migracionCEMaDES == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Migraci&oacute;n CEM a Desembolso</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a href="./migracionCEMaDES.php" target="_blank">Ir </a>
                        </td>
                    </tr>
                {/if}
                {if $migracionCEMaDES == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Migraci&oacute;n Desembolso a Primer Desembolso</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a href="./migracionDesPrimer.php" target="_blank">Ir </a>
                        </td>
                    </tr>
                {/if}
                
                 {if $migracionCEMaDES == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Migraci&oacute;n Escrituración a Primera Escrituración</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a href="./migracionEscPrimer.php" target="_blank">Ir </a>
                        </td>
                    </tr>
                {/if}

                {if $legalizacionGerencial == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Reporte de Legalizaciones</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario('mensajes', 'listadoExportable', './contenidos/desembolso/reporteLegalizacion.php', true, false)" href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $reporteGeneralInscritos == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Reporte General Inscritos</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/reportes/reporteGeneralInscritos.php',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $Caracterizacion == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Caracterizacion Poblacion</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/reportes/ReportesExportables.php?reporte=Caracterizacion',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}	


                {if $reporteBasedeDatosPoblacional == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Reporte Base de Datos Poblacional</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/reportes/ReportesExportables.php?reporte=reporteBasedeDatosPoblacional',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}    	

                {if $InformacionSolucion == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left" width="60%">Plantilla Informacion Solucion</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/reportes/ReportesExportables.php?reporte=InformacionSolucion',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                {if $plantillaestudiotitulos == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Plantilla Estudio Titulos</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/reportes/ReportesExportables.php?reporte=plantillaestudiotitulos',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}


                {if $estudioTitulosLeasing == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Plantilla Estudio Titulos Leasing</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                                'mensajes',
                                                'listadoExportable',
                                                './contenidos/reportes/ReportesExportables.php?reporte=estudioTitulosLeasing',
                                                true,
                                                false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}

                
                {if $plantillaEscrituracion == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Plantilla Escrituración</td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/reportes/ReportesExportables.php?reporte=plantillaEscrituracion',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}
                {if $informeProyectos == 1}
                    <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                        <td class="tituloCampo" align="left">Informe Proyectos Por Actos Administrativos </td>
                        <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                            <a onclick="someterFormulario(
                                            'mensajes',
                                            'listadoExportable',
                                            './contenidos/reportes/ReportesExportables.php?reporte=informeProyectos',
                                            true,
                                            false)"
                               href="#">Exportable</a>
                        </td>
                    </tr>
                {/if}
                
                {if $reporteInformacionCvp == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Cruce Verificación CVP</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=reporteInformacionCvp',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}

            {if $encuestasPive == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Encuestas PIVE (para cruces)</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=encuestasPive',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}

            {if $inconsistenciasInscripcion == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Inconsistencias de inscripción</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="location.href = './contenidos/reportes/inconsistenciasInscripcion.php?inicio=' + document.getElementById('fchInicio').value + '&final=' + document.getElementById('fchFin').value"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}
            
            {if $soporteResolucionVinculacion == 1}
                <tr {if $x is not even} style="background:#{$backColor};" {/if}>
                    <td class="tituloCampo" align="left" width="60%">Soporte Resoluci&oacute;n Vinculaci&oacute;n</td>
                    <td class="tituloCampo" align="left">{assign var=x  value=$x+1}
                        <a onclick="someterFormulario(
                                        'mensajes',
                                        'listadoExportable',
                                        './contenidos/reportes/ReportesExportables.php?reporte=soporteResolucionVinculacion',
                                        true,
                                        false)"
                           href="#">Exportable</a>
                    </td>
                </tr>
            {/if}

        </center>
        <input type="hidden" id="txtComentario" name="txtComentario" />
    </form>

