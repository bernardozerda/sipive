<!-- **********************************************************
<!-- **********************************************************
    PLANTILLA UNICA DE POSTULACION
*************************************************************** -->

{assign var=numAltoPestanaPrincipal  value="550px"}
{assign var=numAltoPestanaSecundaria value="450px"}
{assign var=claFormulario value=$claCasaMano->objPostulacion}

<form name="frmIndividual"
      id="frmIndividual"
      onSubmit="pedirConfirmacion('mensajes',this,'./contenidos/casaMano/pedirConfirmacion.php'); return false;"
      autocomplete=off
>

    <!-- CODGIO PARA EL SEGUIMIENTO Y BOTON SUBMIT DEL FORMULARIO -->
    {include file='subsidios/pedirSeguimiento.tpl'}

    <!-- TABLA PARA IMPRIMIR EL FORMULARIO DE POSTULACION -->
    <table cellspacing="0" cellpadding="3" border="0" width="100%" style="padding-bottom: 5px;">
        <tr>
            <td width="150px" align="center">
                <a href="#" onClick="imprimirPostulacionCEM(document.frmIndividual , './contenidos/casaMano/pedirConfirmacion.php');">
                    Imprimir Formulario
                </a>
            </td>
            <td width="110px" align="center">
                Cerrar Postulaci&oacute;n
            </td>
            <td width="30px" align="center">
                <input type="checkbox"
                       name="bolCerrado"
                       id="bolCerrado"
                       onClick="alertaFormularioCerrado(this, {$claFormulario->bolCerrado}, {$smarty.session.privilegios.cambiar});"
                       value="1"
                        {if $claFormulario->bolCerrado == 1} checked {/if}
                        {if $claFormulario->bolCerrado == 1 && $smarty.session.privilegios.cambiar == 0} disabled {/if}
                >
            </td>
            <td align="right" style="padding-right: 10px;">
                <input type="submit" id="salvar" value="Salvar Postulación">
            </td>
        </tr>
        {if $claFormulario->bolSancion != 0}
            <tr>
                <td style="background-color: #FF0000; color:white; text-align: center" colspan="4">
                    <strong>HOGAR SANCIONADO</strong>
                </td>
            </tr>
        {/if}
        <input type="hidden" value="{$claFormulario->bolSancion}" id="bolSancion" name="bolSancion">
    </table>

    <!-- TAB VIEW PRINCIPAL -->
    <div id="postulacion" class="yui-navset" style="width:100%; text-align:left;">
        <ul class="yui-nav">
            <li class="selected"><a href="#frm"><em>Formulario</em></a></li>
            <li><a href="#seg"><em>Seguimiento</em></a></li>
            <li><a href="#aad"><em>Actos Administrativos</em></a></li>
        </ul>
        <div class="yui-content">

            <!-- FORMULARIO DE POSTULACION -->
            <div id="frm" style="height:{$numAltoPestanaPrincipal};">

                <!-- TABLA DE ESTADO DEL PROCESO Y NUMERO DEL FORMULARIO -->
                <table cellspacing="0" cellpadding="3" border="0" width="100%">
                    <tr>
                        <td style="width:100px;">
                            <b>Estado</b>
                        </td>
                        <td align="left">
                            {if in_array( $claFormulario->seqEstadoProceso , $arrEstadosFlujo.adelante )}
                                <select name="seqEstadoProceso"
                                        id="seqEstadoProceso"
                                        onFocus="this.style.backgroundColor = '#ADD8E6';"
                                        onBlur="this.style.backgroundColor = '#FFFFFF';"
                                        style="width:350px"
                                >
                                    <!-- ESTADOS DEL PROCESO DE RETORNO -->
                                    <optgroup label="Retorno">
                                        {foreach from=$arrEstadosFlujo.atras item=seqEstado}
                                            <option value="{$seqEstado}">{$arrEstados.$seqEstado}</option>
                                        {/foreach}
                                    </optgroup>

                                    <!-- ESTADOS DEL PROCESO DE AVANCE -->
                                    <optgroup label="Avance">
                                        {foreach from=$arrEstadosFlujo.adelante item=seqEstado}
                                            <option value="{$seqEstado}"
                                                    {if $seqEstado == $claFormulario->seqEstadoProceso} selected {/if}
                                            >
                                                {$arrEstados.$seqEstado}
                                            </option>
                                        {/foreach}
                                    </optgroup>
                                </select>
                            {else}
                                {assign var=seqEstadoProceso value=$claFormulario->seqEstadoProceso}
                                {$arrEstados.$seqEstadoProceso}
                                <input type="hidden"
                                       name="seqEstadoProceso"
                                       id="seqEstadoProceso"
                                       value="{$seqEstadoProceso}"
                                >
                            {/if}
                        </td>
                        <td style="width:100px;">
                            <strong>Plan de Gobierno</strong>
                        </td>
                        <td align="left" style="width:200px;">
                            {assign var=seqPlanGobierno value=$claFormulario->seqPlanGobierno}
                            {$arrPlanGobierno.$seqPlanGobierno}
                            <input type="hidden"
                                   name="seqPlanGobierno"
                                   id="seqPlanGobierno"
                                   value="{$claFormulario->seqPlanGobierno}"
                            >
                        </td>
                    </tr>
                    <tr>
                        <!-- NUMERO DEL FORMULARIO -->
                        <td><b>No.Formulario</b></td>
                        <td align="left">
                            <input type="text"
                                   name="txtFormulario"
                                   id="txtFormulario"
                                   value="{$claFormulario->txtFormulario}"
                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                   onBlur="sinCaracteresEspeciales(this); this.style.backgroundColor = '#FFFFFF';"
                                   style="width:100px;"
                                    {if $claFormulario->bolCerrado == 1 && $smarty.session.privilegios.cambiar == 0} disabled {/if}
                            >
                        </td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                </table>

                <!-- SUB - PESTANAS DEL FORMULARIO DE POSTULACION -->
                <div id="pestanasPostulacion" class="yui-navset" style="width:100%; text-align:left;">
                    <ul class="yui-nav">
                        <li class="selected"><a href="#composicion"><em>Composición Familiar</em></a></li>
                        <li><a href="#hogar"><em>Datos del Hogar</em></a></li>
                        <li><a href="#modalidad"><em>Datos de la Postulación</em></a></li>
                        <li><a href="#financiera"><em>Información Financiera</em></a></li>
                    </ul>
                    <div class="yui-content">

                        <!-- COMPOSICION FAMILIAR -->
                        <div id="composicion" style="background-color:white;height:{$numAltoPestanaSecundaria}; overflow:auto;">
                            <p>
                                <!-- TABLA PARA LAS FECHAS DE INSCRIPCION, POSTULACION, ULTIMA ACTUALIZACION -->
                                <table cellpadding="5" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
                                    <tr>
                                        <td class="tituloTabla">Fecha de Inscripción:</td>
                                        <td class="tituloTabla">Fecha de Postulación:</td>
                                        <td class="tituloTabla">Última Actualización:</td>
                                        <td class="tituloTabla">Vigencia del {if $claFormulario->seqPlanGobierno == 2}SDV{else}Aporte{/if}:</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:10px">
                                            {if esFechaValida($claFormulario->fchInscripcion)}
                                                {$claFormulario->fchInscripcion}
                                            {/if}
                                        </td>
                                        <td style="padding-left:10px">
                                            {if esFechaValida($claFormulario->fchPostulacion)}
                                                {$claFormulario->fchPostulacion}
                                            {/if}
                                        </td>
                                        <td style="padding-left:10px">
                                            {if esFechaValida($claFormulario->fchUltimaActualizacion)}
                                                {$claFormulario->fchUltimaActualizacion}
                                            {/if}
                                        </td>
                                        <td style="padding-left:10px">
                                            {if esFechaValida($claFormulario->fchVigencia)}
                                                {$claFormulario->fchVigencia}
                                            {/if}
                                        </td>
                                    </tr>
                                </table>

                                <input type="hidden" name="fchInscripcion"         id="fchInscripcion"         value="{$claFormulario->fchInscripcion}"        />
                                <input type="hidden" name="fchPostulacion"         id="fchPostulacion"         value="{$claFormulario->fchPostulacion}"        />
                                <input type="hidden" name="fchUltimaActualizacion" id="fchUltimaActualizacion" value="{$claFormulario->fchUltimaActualizacion}"/>
                                <input type="hidden" name="fchVigencia"            id="fchVigencia"            value="{$claFormulario->fchVigencia}"           />

                                <!-- TABLA PARA AGREGAR UN MIEMBRO DE HOGAR -->
                                <p>
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
                                        <tr>
                                            <td style="padding-right:15px;" align="right" height="20px" valign="middle"
                                                bgcolor="#E4E4E4">
                                                {if $claFormulario->bolSancion != 1}
                                                    <a href="#"
                                                       onClick="mostrarOcultar('agregarMiembro'); document.getElementById('tipoDocumento').focus();"
                                                    > Agregar Miembro al Hogar </a>
                                                {/if}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td id="agregarMiembro" style="display: none;">
                                                <table cellspacing="0" cellpadding="2" border="0" width="100%"
                                                       bgcolor="#E4E4E4">
                                                    <tr>
                                                        <!-- TIPO DE DOCUMENTO -->
                                                        <td width="15%">Tipo Documento</td>
                                                        <td width="35%" align="center">
                                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                                    id="tipoDocumento"
                                                                    style="width:90%;"
                                                            >
                                                                {foreach from=$arrTipoDocumento key=seqTipoDocumento item=txtTipoDocumento}
                                                                    <option value="{$seqTipoDocumento}">{$txtTipoDocumento}</option>
                                                                {/foreach}
                                                            </select>
                                                        </td>
                                                        <!-- NUMERO DEL DOCUMENTO -->
                                                        <td width="15%">Número Documento</td>
                                                        <td width="35%" align="center">
                                                            <input type="text"
                                                                   id="numeroDoc"
                                                                   value=""
                                                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                   onBlur="soloNumeros(this); this.style.backgroundColor = '#FFFFFF';"
                                                                   onKeyUp="formatoSeparadores(this)"
                                                                   style="width:90%;"
                                                            >
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <!-- PRIMER APELLIDO -->
                                                        <td>Primer Apellido</td>
                                                        <td align="center">
                                                            <input type="text"
                                                                   id="apellido1"
                                                                   value=""
                                                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                   onBlur="soloLetras(this); this.style.backgroundColor = '#FFFFFF';"
                                                                   style="width:90%;"
                                                            >
                                                        </td>
                                                        <!-- SEGUNDO APELLIDO -->
                                                        <td>Segundo Apellido</td>
                                                        <td align="center">
                                                            <input type="text"
                                                                   id="apellido2"
                                                                   value=""
                                                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                   onBlur="soloLetras(this); this.style.backgroundColor = '#FFFFFF';"
                                                                   style="width:90%;"
                                                            >
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <!-- PRIMER NOMBRE -->
                                                        <td>Primer Nombre</td>
                                                        <td align="center">
                                                            <input type="text"
                                                                   id="nombre1"
                                                                   value=""
                                                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                   onBlur="soloLetrasEspacio(this); this.style.backgroundColor = '#FFFFFF';"
                                                                   style="width:90%;"
                                                            />
                                                        </td>
                                                        <!-- SEGUNDO NOMBRE -->
                                                        <td>Segundo Nombre</td>
                                                        <td align="center">
                                                            <input type="text"
                                                                   id="nombre2"
                                                                   value=""
                                                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                   onBlur="soloLetras(this); this.style.backgroundColor = '#FFFFFF';"
                                                                   style="width:90%;"
                                                            />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <!-- PARENTESCO -->
                                                        <td>Parentesco</td>
                                                        <td align="center">
                                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                                    id="parentesco"
                                                                    style="width:90%;"
                                                            >
                                                                <option value="0">Ninguno</option>
                                                                {foreach from=$arrParentesco key=seqParentesco item=arrRegistro}
                                                                    <option value="{$seqParentesco}"
                                                                            {if $arrRegistro.bolActivo == 0} disabled {/if}
                                                                    >
                                                                        {$arrRegistro.txtParentesco}
                                                                    </option>
                                                                {/foreach}
                                                            </select>
                                                        </td>
                                                        <!-- ESTADO CIVIL -->
                                                        <td>Estado Civil</td>
                                                        <td align="center">
                                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                                    id="estadoCivil"
                                                                    style="width:90%;"
                                                            >
                                                                <option value="0">Ninguno</option>
                                                                {foreach from=$arrEstadoCivil key=seqEstadoCivil item=arrRegistro}
                                                                    <option value="{$seqEstadoCivil}"
                                                                            {if $arrRegistro.bolActivo == 0} disabled {/if}
                                                                    >
                                                                        {$arrRegistro.txtEstadoCivil}
                                                                    </option>
                                                                {/foreach}
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <!-- FECHA DE NACIMIENTO -->
                                                        <td>Fecha Nacimiento</td>
                                                        <td style="padding-left:16px">
                                                            <input type="text"
                                                                   id="fechaNac"
                                                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                                   style="width:80px"
                                                                   value=""
                                                                   readonly
                                                            /> <a onClick="calendarioPopUp('fechaNac')" href="#">Calendario</a>
                                                            <a onClick="document.getElementById('fechaNac').value = '';"
                                                               href="#">Limpiar</a>
                                                        </td>

                                                        <!-- CONDICION ESPECIAL -->
                                                        <td>Condici&oacute;n Especial 1</td>
                                                        <td align="center">
                                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                                    id="condicionEspecial"
                                                                    style="width:90%;"
                                                            >
                                                                <option value="6">Ninguno</option>
                                                                {foreach from=$arrCondicionEspecial key=seqCondicionEspecial item=txtCondicionEspecial}
                                                                    <option value="{$seqCondicionEspecial}">{$txtCondicionEspecial}</option>
                                                                {/foreach}
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <!-- CONDICION ETNICA -->
                                                        <td>Condición Etnica</td>
                                                        <td align="center">
                                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                                    id="condicionEtnica"
                                                                    style="width:90%;"
                                                            >
                                                                <option value="1">NINGUNA</option>
                                                                {foreach from=$arrCondicionEtnica key=seqEtnia item=txtEtnia}
                                                                    <option value="{$seqEtnia}">{$txtEtnia}</option>
                                                                {/foreach}
                                                            </select>
                                                        </td>

                                                        <!-- CONDICION ESPECIAL 2 -->
                                                        <td>Condición Especial 2</td>
                                                        <td align="center">
                                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                                    id="condicionEspecial2"
                                                                    style="width:90%;"
                                                            >
                                                                <option value="6">Ninguno</option>
                                                                {foreach from=$arrCondicionEspecial key=seqCondicionEspecial item=txtCondicionEspecial}
                                                                    <option value="{$seqCondicionEspecial}">{$txtCondicionEspecial}</option>
                                                                {/foreach}
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <!-- SEXO -->
                                                        <td>Sexo</td>
                                                        <td align="center">
                                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                                    id="sexo"
                                                                    style="width:90%;"
                                                            >
                                                                {foreach from=$arrSexo key=seqSexo item=txtSexo}
                                                                    <option value="{$seqSexo}">{$txtSexo}</option>
                                                                {/foreach}
                                                            </select>
                                                        </td>

                                                        <!-- CONDICION ESPECIAL 3 -->
                                                        <td>Condición Especial 3</td>
                                                        <td align="center">
                                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                                    id="condicionEspecial3"
                                                                    style="width:90%;"
                                                            >
                                                                <option value="6">Ninguno</option>
                                                                {foreach from=$arrCondicionEspecial key=seqCondicionEspecial item=txtCondicionEspecial}
                                                                    <option value="{$seqCondicionEspecial}">{$txtCondicionEspecial}</option>
                                                                {/foreach}
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <!-- LGTBI Y HOGAR VICTIMA (DESPLAZADO) -->
                                                    <tr>
                                                        <td>Grupo LGTBI<img src="recursos/imagenes/blank.gif" onload="cambiaLgtbi()"></td>
                                                        <td align="center">
                                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                                    id="seqGrupoLgtbi"
                                                                    onChange="cambiaLgtbi()"
                                                                    style="width:90%;"
                                                            >
                                                                <option value="0">Ninguno</option>
                                                                {foreach from=$arrGrupoLgtbi key=seqGrupoLgtbi item=txtGrupoLgtbi}
                                                                    <option value="{$seqGrupoLgtbi}">
                                                                        {$txtGrupoLgtbi}
                                                                    </option>
                                                                {/foreach}
                                                            </select>
                                                        </td>
                                                        <td>Hecho Victimizante</td>
                                                        <td align="center">
                                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                                    id="seqTipoVictima"
                                                                    style="width:90%;"
                                                            >
                                                                <option value="0">Ninguno</option>
                                                                {foreach from=$arrTipoVictima key=seqTipoVictima item=txtTipoVictima}
                                                                    <option value="{$seqTipoVictima}">
                                                                        {$txtTipoVictima}
                                                                    </option>
                                                                {/foreach}
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <!-- GRUPO LGTBI Y NIVEL EDUCATIVO -->
                                                    <tr>
                                                        <td>LGTBI</td>
                                                        <td align="center">
                                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                                    id="bolLgtb"
                                                                    style="width:90%;"
                                                            >
                                                                <option value="0" disabled>No</option>
                                                                <option value="1" disabled>Si</option>
                                                            </select>
                                                        </td>
                                                        <td>Nivel Educativo</td>
                                                        <td align="center">
                                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                                    onchange="selectAnidados('{$objCiudadano->numDocumento}', 0);"
                                                                    id="nivelEducativo"
                                                                    style="width:90%;"
                                                            >
                                                                <option value="1">Ninguno</option>
                                                                {foreach from=$arrNivelEducativo key=seqNivelEducativo item=txtNivelEducativo}
                                                                    <option value="{$seqNivelEducativo}">{$txtNivelEducativo}</option>
                                                                {/foreach}
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <!-- INGRESOS MENSUALES Y AÑOS APROBADOS -->
                                                    <tr>
                                                        <td>Ingresos</td>
                                                        <td align="center">
                                                            <input type="text"
                                                                   id="ingresos"
                                                                   value="0"
                                                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                   onBlur="soloNumeros(this);
                                                                               this.style.backgroundColor = '#FFFFFF';"
                                                                   onkeyup="formatoSeparadores(this)"
                                                                   style="width:90%; text-align: right; padding-right: 10px;"
                                                            />
                                                        </td>
                                                        <td>Años Aprobados</td>
                                                        <td align="center">
                                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                                    id="numAnosAprobados"
                                                                    style="width:90%;"
                                                            >
                                                                <option value="0">0</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <!-- OCUPACION -->
                                                        <td>Ocupación</td>
                                                        <td align="center" colspan="3">
                                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                                    id="ocupacion"
                                                                    style="width:96%;"
                                                            >
                                                                <option value="20">NINGUNO</option>
                                                                {foreach from=$arrOcupacion key=seqOcupacion item=txtOcupacion}
                                                                    <option value="{$seqOcupacion}">{$txtOcupacion}</option>
                                                                {/foreach}
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <!-- AFILIACION A SALUD -->
                                                        <td>Afiliación a Salud</td>
                                                        <td align="center" colspan="3">
                                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                                    id="seqSalud"
                                                                    style="width:96%;"
                                                            >
                                                                <option value="0">NINGUNO</option>
                                                                {foreach from=$arrSalud key=seqSalud item=txtSalud}
                                                                    <option value="{$seqSalud}">{$txtSalud}</option>
                                                                {/foreach}
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <!-- AGREGAR AL FORMULARIO -->
                                                        <td colspan="4" align="right" height="25px" valign="top" style="padding-right:10px">
                                                            <a href="#" onClick="agregarMiembroHogar();">Agregar</a>
                                                            <input type="hidden" id="cajaCompensacion" value="1">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </p>

                                <!-- IMPRIMIR LOS MIEMBROS DE HOGAR CON TODOS LOS DATOS -->
                                <div id="datosHogar">

                                    {assign var=valTotal value=0}
                                    {foreach from=$claFormulario->arrCiudadano item=objCiudadano key=seqCiudadano}

                                        {assign var=tipoDocumento      value=$objCiudadano->seqTipoDocumento}
                                        {assign var=parentesco         value=$objCiudadano->seqParentesco}
                                        {assign var=estadoCivil        value=$objCiudadano->seqEstadoCivil}
                                        {assign var=condicionEspecial  value=$objCiudadano->seqCondicionEspecial}
                                        {assign var=condicionEspecial2 value=$objCiudadano->seqCondicionEspecial2}
                                        {assign var=condicionEspecial3 value=$objCiudadano->seqCondicionEspecial3}
                                        {assign var=codicionEtnica     value=$objCiudadano->seqEtnia}
                                        {assign var=sexo               value=$objCiudadano->seqSexo}
                                        {assign var=grupoLgtbi         value=$objCiudadano->seqGrupoLgtbi}
                                        {assign var=tipoVictima        value=$objCiudadano->seqTipoVictima}
                                        {assign var=lgbt               value=$objCiudadano->bolLgbt}
                                        {assign var=nivelEducativo     value=$objCiudadano->seqNivelEducativo}
                                        {assign var=ocupacion          value=$objCiudadano->seqOcupacion}
                                        {assign var=salud              value=$objCiudadano->seqSalud}

                                        <!-- SI HAY AL MENOS UN CIUDADANO CON HECHO VICTIMIZANTE "DESPLAZAMIENTO FORZADO" -->
                                        {if $objCiudadano->seqTipoVictima == 2}
                                            {assign var=numVictima  value=1}
                                        {/if}

                                        {assign var=valIngresosCiudadano value=$objCiudadano->valIngresos|replace:'[^0-9]':''}
                                        {math equation="x + y" x=$valTotal y=$valIngresosCiudadano assign=valTotal}

                                        <table cellpadding="0" cellspacing="0" border="0" width="100%" id="{$objCiudadano->numDocumento}">
                                            <tr onMouseOver="this.style.background = '#E4E4E4';"
                                                onMouseOut="this.style.background = '#FFFFFF';"
                                                style="cursor:pointer"
                                            >
                                                <td align="center" width="18px" height="22px">
                                                    <div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999;"
                                                         onClick="desplegarDetallesMiembroHogar('{$objCiudadano->numDocumento}')"
                                                         onMouseOver="this.style.backgroundColor = '#ADD8E6';"
                                                         onMouseOut="this.style.backgroundColor = '#FFFFFF';"
                                                         id="masDetalles{$objCiudadano->numDocumento}"
                                                    >+</div>
                                                </td>
                                                <td width="282px" style="padding-left:5px;">
                                                    {$objCiudadano->txtNombre1} {$objCiudadano->txtNombre2}
                                                    {$objCiudadano->txtApellido1} {$objCiudadano->txtApellido2}
                                                </td>
                                                <td width="140px" align="right" style="padding-right: 15px">
                                                    {if $tipoDocumento == 1}     C.C.
                                                    {elseif $tipoDocumento == 2} C.E.
                                                    {elseif $tipoDocumento == 3} T.I.
                                                    {elseif $tipoDocumento == 4} R.C.
                                                    {elseif $tipoDocumento == 5} PAS.
                                                    {elseif $tipoDocumento == 6} NIT.
                                                    {else} {$arrTipoDocumento.$tipoDocumento}
                                                    {/if}
                                                    {$objCiudadano->numDocumento|number_format:0:'.':'.'}
                                                </td>
                                                <td width="260px">
                                                    {$arrParentesco.$parentesco.txtParentesco}
                                                </td>
                                                <td align="right" style="padding-right:7px">
                                                    $ {$objCiudadano->valIngresos|number_format:0:',':'.'}
                                                </td>
                                                {if $claFormulario->bolSancion neq 1}
                                                    <td align="center" width="18px" height="22px">
                                                        <div	style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999;"
                                                                onClick="modificarMiembroHogar('{$objCiudadano->numDocumento}')"
                                                                onMouseOver="this.style.backgroundColor = '#ADD8E6';"
                                                                onMouseOut="this.style.backgroundColor = '#FFFFFF';"
                                                        >E</div>
                                                    </td>
                                                    <td align="center" width="18px" height="22px">
                                                        <div	style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999;"
                                                                onClick="quitarMiembroHogar('{$objCiudadano->numDocumento}');"
                                                                onMouseOver="this.style.backgroundColor = '#FFA4A4';"
                                                                onMouseOut="this.style.backgroundColor = '#FFFFFF'"
                                                        >X</div>
                                                    </td>
                                                {/if}
                                            </tr>

                                            <!-- TODAS ESTAS VARIABLES DEBEN ESTAR DENTRO DE ESTA TABLA -->
                                            <input type="hidden" id="parentesco-{$objCiudadano->numDocumento}" value="{$objCiudadano->seqParentesco}">
                                            <input type="hidden" id="ingreso-{$objCiudadano->numDocumento}" value="{$objCiudadano->valIngresos}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-txtNombre1" name="hogar[{$objCiudadano->numDocumento}][txtNombre1]" value="{$objCiudadano->txtNombre1}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-txtNombre2" name="hogar[{$objCiudadano->numDocumento}][txtNombre2]" value="{$objCiudadano->txtNombre2}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-txtApellido1" name="hogar[{$objCiudadano->numDocumento}][txtApellido1]" value="{$objCiudadano->txtApellido1}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-txtApellido2" name="hogar[{$objCiudadano->numDocumento}][txtApellido2]" value="{$objCiudadano->txtApellido2}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-seqTipoDocumento" name="hogar[{$objCiudadano->numDocumento}][seqTipoDocumento]" value="{$objCiudadano->seqTipoDocumento}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-numDocumento" name="hogar[{$objCiudadano->numDocumento}][numDocumento]" value="{$objCiudadano->numDocumento}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-seqParentesco" name="hogar[{$objCiudadano->numDocumento}][seqParentesco]" value="{$objCiudadano->seqParentesco}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-valIngresos" name="hogar[{$objCiudadano->numDocumento}][valIngresos]" value="{$objCiudadano->valIngresos}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-fchNacimiento" name="hogar[{$objCiudadano->numDocumento}][fchNacimiento]" value="{$objCiudadano->fchNacimiento}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-seqCondicionEspecial" name="hogar[{$objCiudadano->numDocumento}][seqCondicionEspecial]" value="{$objCiudadano->seqCondicionEspecial}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-seqCondicionEspecial2" name="hogar[{$objCiudadano->numDocumento}][seqCondicionEspecial2]" value="{$objCiudadano->seqCondicionEspecial2}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-seqCondicionEspecial3" name="hogar[{$objCiudadano->numDocumento}][seqCondicionEspecial3]" value="{$objCiudadano->seqCondicionEspecial3}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-seqEtnia" name="hogar[{$objCiudadano->numDocumento}][seqEtnia]" value="{$objCiudadano->seqEtnia}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-seqEstadoCivil" name="hogar[{$objCiudadano->numDocumento}][seqEstadoCivil]" value="{$objCiudadano->seqEstadoCivil}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-seqOcupacion" name="hogar[{$objCiudadano->numDocumento}][seqOcupacion]" value="{$objCiudadano->seqOcupacion}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-seqSexo" name="hogar[{$objCiudadano->numDocumento}][seqSexo]" value="{$objCiudadano->seqSexo}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-seqGrupoLgtbi" name="hogar[{$objCiudadano->numDocumento}][seqGrupoLgtbi]" value="{$objCiudadano->seqGrupoLgtbi}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-bolLgtb" name="hogar[{$objCiudadano->numDocumento}][bolLgtb]" value="{$objCiudadano->bolLgtb}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-seqTipoVictima" name="hogar[{$objCiudadano->numDocumento}][seqTipoVictima]" value="{$objCiudadano->seqTipoVictima}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-seqNivelEducativo" name="hogar[{$objCiudadano->numDocumento}][seqNivelEducativo]" value="{$objCiudadano->seqNivelEducativo}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-numAnosAprobados" name="hogar[{$objCiudadano->numDocumento}][numAnosAprobados]" value="{$objCiudadano->numAnosAprobados}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-seqSalud" name="hogar[{$objCiudadano->numDocumento}][seqSalud]" value="{$objCiudadano->seqSalud}">
                                            <input type="hidden" id="{$objCiudadano->numDocumento}-seqCajaCompensacion" name="hogar[{$objCiudadano->numDocumento}][seqCajaCompensacion]" value="{$objCiudadano->seqCajaCompensacion}">
                                        </table>

                                        <!-- TABLA DE DETALLES DEL CIUDADANO -->
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%" style="display:none;" id="detalles{$objCiudadano->numDocumento}">
                                            <tr>
                                                <td colspan="6">
                                                    <table cellpadding="2" cellspacing="0" border="0" width="100%" style="border: 1px solid #999999; padding: 3px;">
                                                        <tr>
                                                            <td><b>Fecha de Nacimiento:</b> {$objCiudadano->fchNacimiento}</td>
                                                            <td><b>Estado Civil:</b> {$arrEstadoCivil.$estadoCivil.txtEstadoCivil}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Condición Étnica:</b>{if isset($arrCondicionEtnica.$codicionEtnica)} {$arrCondicionEtnica.$codicionEtnica} {else} Ninguna {/if}</td>
                                                            <td><b>Condición Especial 1:</b>{if isset($arrCondicionEspecial.$condicionEspecial)} {$arrCondicionEspecial.$condicionEspecial}{else}Ninguna{/if}</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="50%"><b>Sexo:</b> {$arrSexo.$sexo}</td>
                                                            <td><b>Condición Especial 2:</b>{if isset($arrCondicionEspecial.$condicionEspecial2)} {$arrCondicionEspecial.$condicionEspecial2}{else}Ninguna{/if}</td>

                                                        </tr>
                                                        <tr>
                                                            <td><b>Nivel Educativo:</b> {if isset($arrNivelEducativo.$nivelEducativo)}{$arrNivelEducativo.$nivelEducativo}{else}Ninguno{/if} ({$objCiudadano->numAnosAprobados} años aprobados)</td>
                                                            <td><b>Condición Especial 3:</b> {if isset($arrCondicionEspecial.$condicionEspecial3)} {$arrCondicionEspecial.$condicionEspecial3}{else}Ninguna{/if}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>LGTBI:</b> {if $objCiudadano->bolLgtb == 1}Si ({$arrGrupoLgtbi.$grupoLgbti}){else}No{/if} </td>
                                                            <td><b>Hecho Victimizante:</b> {if isset($arrTipoVictima.$tipoVictima)}{$arrTipoVictima.$tipoVictima}{else}Ninguno{/if}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3"><b>Afiliación a Salud:</b> {$arrSalud.$salud}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3"><b>Ocupación:</b> {$arrOcupacion.$ocupacion}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    {/foreach}
                                </div>

                                <!-- MUESTRA EL TOTAL DE LOS INGRESOS DEL HOGAR -->
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr bgcolor="#CCCCCC">
                                        <td align="center" height="20px" width="584px">
                                            <b>Total Ingresos Hogar</b>
                                        </td>
                                        <td style="padding-right:7px" align="right" id="valTotalMostrar">
                                            {if intval( $claFormulario->valIngresoHogar ) == 0}
                                                $ {$valTotal|number_format:0:',':'.'}
                                            {else}
                                                $ {$claFormulario->valIngresoHogar|number_format:0:',':'.'}
                                            {/if}
                                        </td>
                                        <td width="18px">&nbsp;</td>
                                        {if intval( $claFormulario->valIngresoHogar ) == 0}
                                            <input type="hidden" name="valIngresoHogar" id="valIngresoHogar"
                                                   value="{$valTotal}">
                                        {else}
                                            <input type="hidden" name="valIngresoHogar" id="valIngresoHogar"
                                                   value="{$claFormulario->valIngresoHogar}">
                                        {/if}
                                        <td width="18px">&nbsp;</td>
                                    </tr>
                                </table>

                            </p>
                        </div>

                        <!-- DATOS DEL HOGAR -->
                        <div id="hogar" style="background-color:white; height:{$numAltoPestanaSecundaria}">
                            <p>
                                <p>
                                    <table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF"
                                           style="border: 1px dotted #999999; padding:5px">
                                        <tr>
                                            <!-- VIVIENDA ACTUAL -->
                                            <td width="130px">Vivienda Actual</td>
                                            <td width="210px">
                                                <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                        onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                        name="seqVivienda"
                                                        id="seqVivienda"
                                                        style="width:260px;"
                                                >
                                                    {foreach from=$arrVivienda key=seqVivienda item=txtVivienda}
                                                        <option value="{$seqVivienda}"
                                                                {if $claFormulario->seqVivienda == $seqVivienda} selected {/if}
                                                        >{$txtVivienda}</option>
                                                    {/foreach}
                                                </select>
                                            </td>

                                            <!-- SI PAGA ARRIENDO, CUANTO PAGA -->
                                            <td>Valor del Arriendo</td>
                                            <td width="210px">
                                                $ <input type="text"
                                                         name="valArriendo"
                                                         id="valArriendo"
                                                         value="{$claFormulario->valArriendo|number_format:0:'.':'.'}"
                                                         onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                         onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                         onkeyup="formatoSeparadores(this);"
                                                         style="width:249px;"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- FECHA DESDE LA QUE PAGA ARRIENDO -->
                                            <td>
                                                Paga Arriendo Desde
                                            </td>
                                            <td>
                                                <input type="text"
                                                       name="fchArriendoDesde"
                                                       id="fchArriendoDesde"
                                                       value="{$claFormulario->fchArriendoDesde}"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                       onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:80px;"
                                                       readonly
                                                />
                                                <a onClick="calendarioPopUp('fchArriendoDesde')" href="#">Calendario</a>&nbsp;
                                                <a onClick="document.getElementById('fchArriendoDesde').value = '';" href="#">Limpiar</a>
                                            </td>
                                            <td>
                                                Comprobante Arriendo
                                            </td>
                                            <td>
                                                <select name="txtComprobanteArriendo"
                                                        onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                        onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                        style="width:260px;"
                                                >
                                                    <option value="">SELECCIONE</option>
                                                    <option value="no" {if $claFormulario->txtComprobanteArriendo == "no"} selected {/if}>No</option>
                                                    <option value="si" {if $claFormulario->txtComprobanteArriendo == "si"} selected {/if}>Si</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- DIRECCION DE RESIDENCIA -->
                                            <td>
                                                <a href="#" id="Direccion"
                                                   onClick="recogerDireccion('txtDireccion', 'objDireccionOculto')">Dirección</a>
                                            </td>
                                            <td colspan="3">
                                                <input type="text"
                                                       name="txtDireccion"
                                                       id="txtDireccion"
                                                       value="{$claFormulario->txtDireccion}"
                                                       style="width:665px;"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                       onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                       readonly
                                                />
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- CIUDAD -->
                                            <td>Ciudad</td>
                                            <td>
                                                <select
                                                        name="seqCiudad"
                                                        id="seqCiudad"
                                                        onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                        onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                        style="width:260px;"
                                                        onChange="cambiarCiudad(this);"
                                                >
                                                    <option value="">Seleccione</option>
                                                    {foreach from=$arrCiudad key=seqCiudad item=txtCiudad}
                                                        <option value="{$seqCiudad}"
                                                                {if $claFormulario->seqCiudad == $seqCiudad} selected {/if}
                                                        > {$txtCiudad}</option>
                                                    {/foreach}
                                                </select>
                                            </td>

                                            <!-- LOCALIDAD -->
                                            <td>Localidad</td>
                                            <td id="tdlocalidad">
                                                <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                        onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                        onChange="obtenerBarrio(this);"
                                                        name="seqLocalidad"
                                                        id="seqLocalidad"
                                                        style="width:260px;"
                                                >
                                                    <option value="1" selected>Seleccione una</option>
                                                    {foreach from=$arrLocalidad key=seqLocalidad item=txtLocalidad}
                                                        <option value="{$seqLocalidad}"
                                                                {if $claFormulario->seqLocalidad == $seqLocalidad}
                                                                    selected
                                                                {/if}
                                                        >
                                                            {$txtLocalidad}
                                                        </option>
                                                    {/foreach}
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- BARRIO -->
                                            <td valign="top" height="22px">Barrio</td>
                                            <td valign="top" align="left" id="tdBarrio">
                                                <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                        onChange="obtenerUpz(this);"
                                                        onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                        name="seqBarrio"
                                                        id="seqBarrio"
                                                        style="width:260px;"
                                                >
                                                    <option value="0">Seleccione</option>
                                                    {if intval( $claFormulario->seqLocalidad ) != 0}
                                                        {foreach from=$arrBarrio key=seqBarrio item=txtBarrio}
                                                            <option value="{$seqBarrio}"
                                                                    {if $claFormulario->seqBarrio == $seqBarrio}
                                                                        selected
                                                                    {/if}
                                                            >
                                                                {$txtBarrio}
                                                            </option>
                                                        {/foreach}
                                                    {/if}
                                                </select>
                                            </td>
                                            <td id="tdupz">
                                                &nbsp;<input type='hidden' readonly id='seqUpz' name='seqUpz' value="{$claFormulario->seqUpz}">
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>N° Hogares en la vivienda</td>
                                            <td><input type="number" name="numHabitaciones" autofocus="" size="4" maxlength="3"
                                                       min="0" step="1" style="width: 40px"
                                                       value="{$claFormulario->numHabitaciones}"></td>
                                            <td>Número Dormitorios</td>
                                            <td><input type="number" name="numHacinamiento" autofocus="" size="4" maxlength="3"
                                                       min="0" step="1" style="width: 40px"
                                                       value="{$claFormulario->numHacinamiento}"></td>
                                        </tr>

                                        <!-- TELEFONO 1 TELEFONO 2 Y CELULAR -->
                                        <tr>
                                            <td>Teléfonos</td>
                                            <td>
                                                <input type="text"
                                                       name="numTelefono1"
                                                       id="numTelefono1"
                                                       value="{$claFormulario->numTelefono1}"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                       onBlur="soloNumeros(this); this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:122px;"
                                                /> ó
                                                <input type="text"
                                                       name="numTelefono2"
                                                       id="numTelefono2"
                                                       value="{$claFormulario->numTelefono2}"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                       onBlur="soloNumeros(this); this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:122px;"
                                                />
                                            </td>
                                            <td>Teléfono Celular</td>
                                            <td>
                                                <input type="text"
                                                       name="numCelular"
                                                       id="numCelular"
                                                       value="{$claFormulario->numCelular}"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                       onBlur="soloNumeros(this); this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:260px;"
                                                />
                                            </td>
                                        </tr>

                                        <!-- CORREO ELECTRONICO -->
                                        <tr>
                                            <td>Correo Electr&oacute;nico</td>
                                            <td colspan="3">
                                                <input type="text"
                                                       name="txtCorreo"
                                                       id="txtCorreo"
                                                       value="{$claFormulario->txtCorreo}"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                       onBlur="sinCaracteresEspeciales(this); this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:680px;"
                                                       class="inputLogin"
                                                />
                                            </td>
                                        </tr>

                                        <!-- SISBEN y DESPLAZAMIENTO FORZADO -->
                                        <tr>
                                            <td>Sisben </td>
                                            <td>
                                                <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                        onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                        name="seqSisben"
                                                        id="seqSisben"
                                                        style="width:260px;"
                                                ><option value="0" selected>SELECCIONE</option>
                                                    {foreach from=$arrSisben key=seqSisben item=arrRegistro}
                                                        {if $claFormulario->seqPlanGobierno == 3}
                                                            {if $arrRegistro.bolActivo == 1}
                                                                <option value="{$seqSisben}"
                                                                        {if $claFormulario->seqSisben == $seqSisben} selected {/if}
                                                                >{$arrRegistro.txtSisben}</option>
                                                            {/if}
                                                        {else}
                                                            {if intval($seqSisben) != 9}
                                                                <option value="{$seqSisben}"
                                                                        {if $claFormulario->seqSisben == $seqSisben} selected {/if}
                                                                >{$arrRegistro.txtSisben}</option>
                                                            {/if}
                                                        {/if}
                                                    {/foreach}
                                                </select>
                                                </select>
                                            </td>
                                            <td>Desplazamiento forzado</td>
                                            <td>
                                                <!-- SI HAY AL MENOS UN CIUDADNO CON HECHO VICTIMIZANTE "DESPLAZAMIENTO FORZADO" SE MARCA COMO SI -->
                                                <select	onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                           onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                           name="bolDesplazado"
                                                           id="bolDesplazado"
                                                           style="width:260px;"
                                                >
                                                    <option value="0" {if $numVictima == 0} selected {/if} disabled>No</option>
                                                    <option value="1" {if $numVictima == 1} selected {/if} disabled>Si</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </p>

                                <!-- TABLA RED DE SERVICIOS -->
                                <p>
                                    <table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF" style="border: 1px dotted #999999; padding:5px">
                                        <tr>
                                            <!-- INTEGRACION SOCIAL -->
                                            <td width="110px">Integraci&oacute;n Social</td>
                                            <td style="padding-left:10px;">
                                                <select	onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                           onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                           name="bolIntegracionSocial"
                                                           id="bolIntegracionSocial"
                                                           style="width:100%;"
                                                >
                                                    <option value="0" {if $claFormulario->bolIntegracionSocial != 1} selected {/if} >No</option>
                                                    <option value="1" {if $claFormulario->bolIntegracionSocial == 1} selected {/if} >Si</option>
                                                </select>
                                            </td>

                                            <!-- SEC SALUD -->
                                            {if $claFormulario->seqPlanGobierno != 3}
                                                <td width="110px" align="right">Sec. Salud</td>
                                                <td style="padding-left:10px;">
                                                    <select	onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                               name="bolSecSalud"
                                                               id="bolSecSalud"
                                                               style="width:100%;"
                                                    >
                                                        <option value="0" {if $claFormulario->bolSecSalud != 1} selected {/if} >No</option>
                                                        <option value="1" {if $claFormulario->bolSecSalud == 1} selected {/if} >Si</option>
                                                    </select>
                                                </td>

                                                <!-- SEC EDUCACION -->
                                                <td width="110px" align="right">Sec. Educacion</td>
                                                <td style="padding-left:10px;">
                                                    <select	onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                               name="bolSecEducacion"
                                                               id="bolSecEducacion"
                                                               style="width:100%;"
                                                    >
                                                        <option value="0" {if $claFormulario->bolSecEducacion != 1} selected {/if} >No</option>
                                                        <option value="1" {if $claFormulario->bolSecEducacion == 1} selected {/if} >Si</option>
                                                    </select>
                                                </td>
                                                <input type="hidden" name="bolSecMujer" value="{$claFormulario->bolSecMujer|@intval}">
                                            {else}
                                                <td width="110px" align="center">Sec. de la Mujer</td>
                                                <td style="padding-left:10px;">
                                                    <select	onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                               name="bolSecMujer"
                                                               id="bolSecMujer"
                                                               style="width:100%;"
                                                    >
                                                        <option value="0" {if $claFormulario->bolSecMujer != 1} selected {/if} >No</option>
                                                        <option value="1" {if $claFormulario->bolSecMujer == 1} selected {/if} >Si</option>
                                                    </select>
                                                </td>
                                                <input type="hidden" name="bolSecSalud" value="{$claFormulario->bolSecSalud|@intval}">
                                                <input type="hidden" name="bolSecEducacion" value="{$claFormulario->bolSecEducacion|@intval}">
                                            {/if}

                                            <!-- IPES -->
                                            <td width="110px" align="right">IPES</td>
                                            <td style="padding-left:10px;">
                                                <select	onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                           onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                           name="bolIpes"
                                                           id="bolIpes"
                                                           style="width:100%;"
                                                >
                                                    <option value="0" {if $claFormulario->bolIpes != 1} selected {/if} >No</option>
                                                    <option value="1" {if $claFormulario->bolIpes == 1} selected {/if} >Si</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <input type="hidden" name="txtOtro" value="{$claFormulario->txtOtro}">
                                    </table>
                                </p>
                            </p>
                        </div>

                        <!-- DATOS DE POSUTLACION -->
                        <div id="modalidad" style="background-color:white; height:{$numAltoPestanaSecundaria};">
                            <p>
                                <table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px dotted #666666;">

                                    <!-- MODALIDAD DEL SUBSIDIO y TIPO DE SOLUCION -->
                                    <tr>
                                        <td width="150px">Modalidad Solución</td>
                                        <td>
                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                    name="seqModalidad"
                                                    id="seqModalidad"
                                                    style="width:100%;"
                                                    onChange="datosPestanaPostulacion('modalidad');"
                                            >
                                                <option value="0">Seleccione</option>
                                                {foreach from=$arrModalidad key=seqModalidad item=txtModalidad}
                                                    <option value="{$seqModalidad}"
                                                            {if $claFormulario->seqModalidad == $seqModalidad} selected {/if}
                                                    >
                                                        {$txtModalidad}
                                                    </option>
                                                {/foreach}
                                            </select>
                                        </td>
                                        <td width="100px">Tipo Solución</td>
                                        <td id="tdTipoSolucion" align="left">
                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                    name="seqSolucion"
                                                    id="seqSolucion"
                                                    style="width:100%;"
                                            >
                                                <option value="1">NINGUNA</option>
                                                {if intval( $claFormulario->seqModalidad ) != 0}
                                                    {foreach from=$arrSolucion key=seqSolucion item=arrDatos}
                                                        {if $claFormulario->seqModalidad == $arrDatos.seqModalidad}
                                                            <option value="{$seqSolucion}"
                                                                    {if $claFormulario->seqSolucion == $seqSolucion}
                                                                        selected
                                                                    {/if}
                                                            >
                                                                {$arrDatos.txtSolucion}
                                                            </option>
                                                        {/if}
                                                    {/foreach}
                                                {/if}
                                            </select>
                                        </td>
                                    </tr>

                                    <!-- TIPO ESQUEMA -->
                                    <tr>
                                        <td>Tipo Esquema</td>
                                        <td colspan="3" align="left">
                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                    onChange="datosPestanaPostulacion('esquema');"
                                                    name="seqTipoEsquema"
                                                    id="seqTipoEsquema"
                                                    style="width:100%"
                                            >
                                                <option value="0" selected>NINGUNO</option>
                                                {foreach from=$arrTipoEsquemas key=seqTipoEsquema item=txtTipoEsquema}
                                                    <option value="{$seqTipoEsquema}"
                                                            {if $claFormulario->seqTipoEsquema == $seqTipoEsquema} selected {/if}
                                                    >
                                                        {$txtTipoEsquema}
                                                    </option>
                                                {/foreach}
                                            </select>
                                        </td>
                                    </tr>

                                    <!-- PROYECTO -->
                                    <tr>
                                        <td>Proyecto</td>
                                        <td id="tdProyecto" colspan="3" align="left">
                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                    onChange="datosPestanaPostulacion('proyecto');"
                                                    name="seqProyecto"
                                                    id="seqProyecto"
                                                    style="width:100%"
                                            >
                                                <option value="37" selected>NINGUNO</option>
                                                {foreach from=$arrProyectos key=seqProyecto item=txtNombreProyecto}
                                                    <option value="{$seqProyecto}"
                                                            {if $claFormulario->seqProyecto == $seqProyecto} selected {/if}
                                                    >
                                                        {$txtNombreProyecto}
                                                    </option>
                                                {/foreach}
                                            </select>
                                        </td>
                                    </tr>

                                    <!-- CONJUNTOS RESIDENCIALES (PROYECTOS HIJO) -->
                                    <tr>
                                        <td>Conjuntos Residenciales</td>
                                        <td id="tdConjuntoResidencial" colspan="3" align="left">
                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                    onChange="datosPestanaPostulacion('conjuntos');"
                                                    name="seqProyectoHijo"
                                                    id="seqProyectoHijo"
                                                    style="width:100%"
                                            >
                                                <option value='0' selected>NINGUNO</option>
                                                {foreach from=$arrProyectosHijos key=seqProyecto item=txtNombreProyecto}
                                                    <option value="{$seqProyecto}"
                                                            {if $claFormulario->seqProyectoHijo == $seqProyecto} selected {/if}
                                                    >
                                                        {$txtNombreProyecto}
                                                    </option>
                                                {/foreach}
                                            </select>
                                        </td>
                                    </tr>

                                    <!-- UNIDADES RESIDENCIALES -->
                                    <tr>
                                        <td>Unidad Residencial</td>
                                        <td id="tdUnidadProyecto" align="left" colspan="3">
                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                    onChange="valorSubsidio();"
                                                    name="seqUnidadProyecto"
                                                    id="seqUnidadProyecto"
                                                    style="width:100%;"
                                            >
                                                <option value="1">NINGUNA</option>
                                                {foreach from=$arrUnidadProyecto key=seqUnidadProyecto item=txtNombre}
                                                    <option value="{$seqUnidadProyecto}"
                                                            {if $claFormulario->seqUnidadProyecto == $seqUnidadProyecto} selected {/if}
                                                    >
                                                        {$txtNombre}
                                                    </option>
                                                {/foreach}
                                            </select>
                                        </td>
                                    </tr>

                                    <!-- DIRECCION SOLUCION -->
                                    <tr>
                                        <td width="130px">
                                            <a href="#" id="DireccionSolucion"
                                               onClick="recogerDireccion('txtDireccionSolucion', 'objDireccionOcultoSolucion')">Dirección
                                                Solución</a>
                                        </td>
                                        <td colspan="3" align="left">
                                            <input type="text"
                                                   name="txtDireccionSolucion"
                                                   id="txtDireccionSolucion"
                                                   value="{$claFormulario->txtDireccionSolucion}"
                                                   style="width:100%;"
                                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                   readonly
                                            />
                                        </td>
                                    </tr>

                                    <!-- NUMERO DE MATRICULA INMOBILIARIA Y CHIP -->
                                    <tr>
                                        <td>Matricula Inmobiliaria</td>
                                        <td>
                                            <input type="text"
                                                   name="txtMatriculaInmobiliaria"
                                                   id="txtMatriculaInmobiliaria"
                                                   value="{$claFormulario->txtMatriculaInmobiliaria}"
                                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                   onBlur="sinCaracteresEspeciales(this); this.style.backgroundColor = '#FFFFFF';"
                                                   style="width:260px;"
                                            />
                                        </td>
                                        <td>CHIP</td>
                                        <td>
                                            <input type="text"
                                                   name="txtChip"
                                                   id="txtChip"
                                                   value="{$claFormulario->txtChip}"
                                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                   onBlur="sinCaracteresEspeciales(this); this.style.backgroundColor = '#FFFFFF';"
                                                   style="width:100%;"
                                            />
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px dotted #666666">

                                    <!-- TIENE PROMESA DE COMPRA VENTA FIRMADA -->
                                    <tr>
                                        <td width="350px">¿ Tiene una {if $arrFlujoHogar.flujo == "pin"}separación{else}promesa de compra-venta{/if} firmada ?</td>
                                        <td>
                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                    name="bolPromesaFirmada"
                                                    id="bolPromesaFirmada"
                                                    style="width:100px;"
                                            >
                                                <option value="0" {if $claFormulario->bolPromesaFirmada != 1} selected {/if}>
                                                    No
                                                </option>
                                                <option value="1" {if $claFormulario->bolPromesaFirmada == 1} selected {/if}>
                                                    Si
                                                </option>
                                            </select>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <!-- TIENE IDENTIFICADA UNA SOLUCION DE VIVIENDA VIABILIZADA POR LA SDHT -->
                                    <tr>
                                        <td>¿ Tiene identificada una solución viabilizada por la SDHT ?</td>
                                        <td>
                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                    name="bolIdentificada"
                                                    id="bolIdentificada"
                                                    style="width:100px;"
                                            >
                                                <option value="0" {if $claFormulario->bolIdentificada != 1} selected {/if}>
                                                    No
                                                </option>
                                                <option value="1" {if $claFormulario->bolIdentificada == 1} selected {/if}>
                                                    Si
                                                </option>
                                            </select>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <!-- PERTENECE A UN PLAN DE VIVIENDA VIABILIZADA POR LA SDHT -->
                                    <tr>
                                        <td>¿ Pertenece a un plan de vivienda viabilizada por la SDHT</td>
                                        <td>
                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                    name="bolViabilizada"
                                                    id="bolViabilizada"
                                                    style="width:100px;"
                                            >
                                                <option value="0" {if $claFormulario->bolViabilizada != 1} selected {/if}>
                                                    No
                                                </option>
                                                <option value="1" {if $claFormulario->bolViabilizada == 1} selected {/if}>
                                                    Si
                                                </option>
                                            </select>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                                <br>
                                <table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px dotted #666666">
                                    <tr>
                                        <!-- VALOR DEL PRESUPUESTO -->
                                        <td width="120px">Presupuesto</td>
                                        <td width="120px">
                                            $ <input type="text"
                                                     name="valPresupuesto"
                                                     id="valPresupuesto"
                                                     value="{$claFormulario->valPresupuesto|number_format:0:'.':'.'}"
                                                     onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                     onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                     onKeyUp="sumarTotal();"
                                                     style="width:100px;"
                                            />
                                        </td>

                                        <!-- VALOR DEL AVALUO  -->
                                        <td>Aval&uacute;o</td>
                                        <td width="120px">
                                            $ <input type="text"
                                                     name="valAvaluo"
                                                     id="valAvaluo"
                                                     value="{$claFormulario->valAvaluo|number_format:0:'.':'.'}"
                                                     onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                     onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                     onKeyUp="sumarTotal();"
                                                     style="width:100px;"
                                            />
                                        </td>

                                        <!-- VALOR TOTAL  -->
                                        <td>Total</td>
                                        <td width="134px">
                                            $ <input type="text"
                                                     name="valTotal"
                                                     id="valTotal"
                                                     value="{$claFormulario->valTotal}"
                                                     onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                     onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                     style="width:90%;"
                                                     readonly
                                            />
                                        </td>
                                    </tr>
                                </table>
                            </p>
                        </div>

                        <!-- INFORMACION FINANCIERA -->
                        <div id="financiera" style="background-color:white; height:{$numAltoPestanaSecundaria};">
                            <p>
                            <table cellpadding="1" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">

                                <!-- TIPO DE FINANCIACION -->
                                <input type="hidden" name="seqTipoFinanciacion" id="seqTipoFinanciacion" value ="{$claFormulario->seqTipoFinanciacion}">

                                <tr><!-- TIENE AHORRO -->
                                    <td>Ahorro 1</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text"
                                                 name="valSaldoCuentaAhorro"
                                                 id="valSaldoCuentaAhorro"
                                                 value="{$claFormulario->valSaldoCuentaAhorro|number_format:'0':'.':'.'}"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                 onKeyUp="sumarTotalRecursos();"
                                                 style="padding-right: 5px; width:100px; text-align:right;" />
                                    </td>
                                    <!-- BANCO DONDE TIENE EL AHORRO -->
                                    <td>Entidad</td>
                                    <td align="center" width="320px">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                   name="seqBancoCuentaAhorro"
                                                   id="seqBancoCuentaAhorro"
                                                   style="width:300px;" >
                                            <option value="1">Ninguno</option>
                                            {foreach from=$arrBanco key=seqBanco item=txtBanco}
                                                <option value="{$seqBanco}"
                                                        {if $claFormulario->seqBancoCuentaAhorro == $seqBanco} selected {/if}
                                                >{$txtBanco}
                                                </option>
                                            {/foreach}
                                        </select>
                                    </td>
                                </tr>

                                <tr><!-- SOPORTE CUENTA AHORRO E INMOVILIZADA -->
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Soporte</td>
                                    <td style="padding-left:11px;">
                                        <input type="text"
                                               name="txtSoporteCuentaAhorro"
                                               id="txtSoporteCuentaAhorro"
                                               value="{$claFormulario->txtSoporteCuentaAhorro}"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                           this.style.backgroundColor = '#FFFFFF';"
                                               style="width:195px;"
                                        /> Inmovilizado
                                        <input type="checkbox"
                                               name="bolInmovilizadoCuentaAhorro"
                                               id="bolInmovilizadoCuentaAhorro"
                                               value="1"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                {if $claFormulario->bolInmovilizadoCuentaAhorro == 1} checked {/if}
                                        />
                                    </td>
                                </tr>

                                <tr><!-- FECHA APERTURA CUENTA AHORRO -->
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Fecha Apertura</td>
                                    <td style="padding-left:11px;">
                                        <input type="text"
                                               name="fchAperturaCuentaAhorro"
                                               id="fchAperturaCuentaAhorro"
                                               value="{$claFormulario->fchAperturaCuentaAhorro}"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                           this.style.backgroundColor = '#FFFFFF';"
                                               style="width:100px;"
                                               maxlength="10"
                                               readonly />
                                        <a href="#" onClick="javascript: calendarioPopUp('fchAperturaCuentaAhorro');">Calendario</a>&nbsp;&nbsp;
                                        <a onClick="document.getElementById('fchAperturaCuentaAhorro').value = '';" href="#">Limpiar</a>
                                    </td>
                                </tr>

                                <tr><!-- TIENE OTRO AHORRO -->
                                    <td>Ahorro 2</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text"
                                                 name="valSaldoCuentaAhorro2"
                                                 id="valSaldoCuentaAhorro2"
                                                 value="{$claFormulario->valSaldoCuentaAhorro2|number_format:'0':'.':'.'}"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                 onKeyUp="sumarTotalRecursos();"
                                                 style="padding-right: 5px; width:100px; text-align:right;" />
                                    </td>
                                    <!-- BANCO DONDE TIENE EL AHORRO -->
                                    <td>Entidad</td>
                                    <td align="center" width="320px">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                name="seqBancoCuentaAhorro2"
                                                id="seqBancoCuentaAhorro2"
                                                style="width:300px;" >
                                            <option value="1">Ninguno</option>
                                            {foreach from=$arrBanco key=seqBanco item=txtBanco}
                                                <option value="{$seqBanco}"
                                                        {if $claFormulario->seqBancoCuentaAhorro2 == $seqBanco} selected {/if}
                                                >{$txtBanco}</option>
                                            {/foreach}
                                        </select>
                                    </td>
                                </tr>

                                <tr><!-- SOPORTE CUENTA AHORRO E INMOVILIZADA -->
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Soporte</td>
                                    <td style="padding-left:11px;">
                                        <input type="text"
                                               name="txtSoporteCuentaAhorro2"
                                               id="txtSoporteCuentaAhorro2"
                                               value="{$claFormulario->txtSoporteCuentaAhorro2}"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                           this.style.backgroundColor = '#FFFFFF';"
                                               style="width:195px;"
                                        /> Inmovilizado
                                        <input type="checkbox"
                                               name="bolInmovilizadoCuentaAhorro2"
                                               id="bolInmovilizadoCuentaAhorro2"
                                               value="1"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                {if $claFormulario->bolInmovilizadoCuentaAhorro2 == 1} checked {/if}
                                        />
                                    </td>
                                </tr>

                                <tr><!-- FECHA APERTURA CUENTA AHORRO -->
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Fecha Apertura</td>
                                    <td style="padding-left:11px;">
                                        <input type="text"
                                               name="fchAperturaCuentaAhorro2"
                                               id="fchAperturaCuentaAhorro2"
                                               value="{$claFormulario->fchAperturaCuentaAhorro2}"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                           this.style.backgroundColor = '#FFFFFF';"
                                               style="width:100px;"
                                               maxlength="10"
                                               readonly
                                        />
                                        <a href="#" onClick="javascript: calendarioPopUp('fchAperturaCuentaAhorro2');">Calendario</a>&nbsp;&nbsp;
                                        <a onClick="document.getElementById('fchAperturaCuentaAhorro2').value = '';" href="#">Limpiar</a>
                                    </td>
                                </tr>

                                <tr><!-- CESANTIAS -->
                                    <td>Cesant&iacute;as</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text"
                                                 name="valSaldoCesantias"
                                                 id="valSaldoCesantias"
                                                 value="{$claFormulario->valSaldoCesantias|number_format:'0':'.':'.'}"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                 onKeyUp="sumarTotalRecursos();"
                                                 style="padding-right: 5px; width:100px;text-align:right;" />
                                    </td>
                                    <!-- SOPORTE CESANTIAS -->
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input type="text"
                                               name="txtSoporteCesantias"
                                               id="txtSoporteCesantias"
                                               value="{$claFormulario->txtSoporteCesantias}"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this); this.style.backgroundColor = '#FFFFFF';"
                                               style="width:300px;" />
                                    </td>
                                </tr>

                                <tr><!-- TIENE CREDITO -->
                                    <td>Cr&eacute;dito</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text"
                                                 name="valCredito"
                                                 id="valCredito"
                                                 value="{$claFormulario->valCredito|number_format:'0':'.':'.'}"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                 onKeyUp="sumarTotalRecursos();"
                                                 style="padding-right: 5px; width:100px;text-align:right;" />
                                    </td>
                                    <!-- BANCO DONDE TIENE EL CREDITO -->
                                    <td>Entidad</td>
                                    <td align="center">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                name="seqBancoCredito"
                                                id="seqBancoCredito"
                                                style="width:300px;" >
                                            <option value="1">Sin Credito</option>
                                            {foreach from=$arrBanco key=seqBanco item=txtBanco}
                                                <option value="{$seqBanco}"
                                                        {if $claFormulario->seqBancoCredito == $seqBanco} selected {/if}
                                                >{$txtBanco}</option>
                                            {/foreach}
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <!-- SOPORTE CREDITO -->
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input type="text"
                                               name="txtSoporteCredito"
                                               id="txtSoporteCredito"
                                               value="{$claFormulario->txtSoporteCredito}"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                               style="width:300px;" />
                                    </td>
                                </tr>

                                <tr><!-- FECHA APROBACION CREDITO -->
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Fecha Vencimiento</td>
                                    <td style="padding-left:11px;">
                                        <input type="text"
                                               name="fchAprobacionCredito"
                                               id="fchAprobacionCredito"
                                               value="{$claFormulario->fchAprobacionCredito}"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this); this.style.backgroundColor = '#FFFFFF';"
                                               style="width:100px;"
                                               maxlength="10"
                                               readonly />
                                        <a onClick="calendarioPopUp('fchAprobacionCredito')" href="#">Calendario</a>&nbsp;&nbsp;
                                        <a onClick="document.getElementById('fchAprobacionCredito').value = '';" href="#">Limpiar</a>
                                    </td>
                                </tr>

                                <tr><!-- SUBSIDIO NACIONAL -->
                                    <td>
                                        Valor
                                        {if $claFormulario->seqPlanGobierno == 2}
                                            Subsidio
                                        {else}
                                            Aporte
                                        {/if}
                                        : AVC / FOVIS / SFV
                                    </td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text"
                                                 name="valSubsidioNacional"
                                                 id="valSubsidioNacional"
                                                 value="{$claFormulario->valSubsidioNacional|number_format:'0':'.':'.'}"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                 onKeyUp="sumarTotalRecursos();"
                                                 style="padding-right: 5px; width:100px;text-align:right;"
                                        />
                                    </td>
                                    <td>Entidad</td>
                                    <td align="center" width="320px">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                name="seqEntidadSubsidio"
                                                id="seqEntidadSubsidio"
                                                style="width:300px;"
                                        >
                                            {foreach from=$arrEntidadSubsidio key=seqEntidadSubsidio item=txtEntidadSubsidio}
                                                <option value="{$seqEntidadSubsidio}"
                                                        {if $claFormulario->seqEntidadSubsidio == $seqEntidadSubsidio} selected {/if}
                                                >{$txtEntidadSubsidio}</option>
                                            {/foreach}
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2"></td>
                                    <td>Soporte (No.Carta)</td>
                                    <td align="center">
                                        <input type="text"
                                               name="txtSoporteSubsidioNacional"
                                               id="txtSoporteSubsidioNacional"
                                               value="{$claFormulario->txtSoporteSubsidioNacional}"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this); this.style.backgroundColor = '#FFFFFF';"
                                               style="width:300px;" />
                                    </td>
                                </tr>



                                <tr><!-- TIENE DONACIONES -->
                                    <td>Donaci&oacute;n / Rec. Econ&oacute;mico</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text"
                                                 name="valDonacion"
                                                 id="valDonacion"
                                                 value="{$claFormulario->valDonacion|number_format:'0':'.':'.'}"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                 onKeyUp="sumarTotalRecursos();"
                                                 style="padding-right: 5px; width:100px;text-align:right;" />
                                    </td>

                                    <!-- DE DONDE PROVIENE LA DONACION -->
                                    <td>Entidad Donante</td>
                                    <td style="padding-left: 10px;">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                   name="seqEmpresaDonante"
                                                   id="seqEmpresaDonante"
                                                   style="width:300px;" >
                                            <option value="1">Ninguna</option>
                                            {foreach from=$arrDonantes key=seqEmpresaDonante item=txtEmpresaDonante}
                                                <option value="{$seqEmpresaDonante}"
                                                        {if $claFormulario->seqEmpresaDonante == $seqEmpresaDonante} selected {/if}
                                                >{$txtEmpresaDonante}</option>
                                            {/foreach}
                                        </select>
                                    </td>
                                </tr>

                                <tr><!-- SOPORTE DONACION -->
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input type="text"
                                               name="txtSoporteDonacion"
                                               id="txtSoporteDonacion"
                                               value="{$claFormulario->txtSoporteDonacion}"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this); this.style.backgroundColor = '#FFFFFF';"
                                               style="width:300px;" />
                                    </td>
                                </tr>

                                <!-- muestra los campos del leasing si corresponde -->
                                {if $claFormulario->seqPlanGobierno == 3 and $claFormulario->seqModalidad == 13}
                                    {assign var=bolCamposLeasing value=""}
                                    {assign var=bolCamposNoLeasing value="none"}
                                {else}
                                    {assign var=bolCamposLeasing value="none"}
                                    {assign var=bolCamposNoLeasing value=""}
                                {/if}

                                <tr id="trNoLeasing1" bgcolor="#E0E0E0" style="display:{$bolCamposNoLeasing}">
                                    <!-- SUMA DE RECURSOS PROPIOS -->
                                    <td class="tituloTabla" style="padding-top:5px;">Recursos propios</td>
                                    <td align="right" style="padding-top:5px; padding-right:5px">
                                        $ <input type="text"
                                                 id="valSumaRecursosPropios"
                                                 value="{$valSumaRecursosPropios|number_format:'0':',':'.'}"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                 style="padding-right: 5px; width:100px;text-align:right;"
                                                 readonly
                                        >
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr id="trNoLeasing2" bgcolor="#E0E0E0" style="display:{$bolCamposNoLeasing}">
                                    <!-- SUMA DE SUBSIDIOS -->
                                    <td class="tituloTabla" style="padding-top:5px;">Valor Subsidios + (Donacion y/o VUR)</td>
                                    <td align="right" style="padding-top:5px; padding-right:5px">
                                        $ <input type="text"
                                                 id="valSumaSubsidios"
                                                 value="{$valSumaSubsidios|number_format:'0':',':'.'}"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                 style="padding-right: 5px; width:100px;text-align:right;"
                                                 readonly
                                        >
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>

                                </tr>
                                <tr id="trNoLeasing3" bgcolor="#E0E0E0" style="display:{$bolCamposNoLeasing}">
                                    <!-- TOTAL RECURSOS ECONOMICOS -->
                                    <td class="tituloTabla" style="padding-top:5px;">Total recursos del hogar</td>
                                    <td align="right" style="padding-top:5px; padding-right:5px">
                                        $ <input type="text"
                                                 name="valTotalRecursos"
                                                 id="valTotalRecursos"
                                                 value="{$claFormulario->valTotalRecursos|number_format:'0':',':'.'}"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                 style="padding-right: 5px; width:100px;text-align:right;"
                                                 readonly
                                        >
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>

                                <!-- CAMPOS DE LA MODALIDAD DE LEASING  -->
                                <tr id="trLeasing1" style="display: {$bolCamposLeasing};">

                                    <!-- VIABILIDAD LEASING -->
                                    <td>Viabilidad leasing por entidad financiera</td>
                                    <td style="padding-right: 5px;" align="right">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                   name="bolViabilidadLeasing"
                                                   id="bolViabilidadLeasing"
                                                   style="width:100px;" >
                                            <option value="1" {if $claFormulario->bolViabilidadLeasing == 1} selected {/if}>Si</option>
                                            <option value="0" {if $claFormulario->bolViabilidadLeasing == 0} selected {/if}>No</option>
                                        </select>
                                    </td>

                                    <!-- ENTIDAD QUE HACE EL LEASING -->
                                    <td>Convenio</td>
                                    <td style="padding-left: 10px;">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                   name="seqConvenio"
                                                   id="seqConvenio"
                                                   onChange="mostrarToolTip()"
                                                   style="width:250px;">
                                            <option value="1">Ninguno</option>
                                            {foreach from=$arrConvenio key=seqConvenio item=arrRegistro}
                                                <option value="{$seqConvenio}"
                                                        {if $claFormulario->seqConvenio == $seqConvenio} selected {/if}
                                                >{$arrRegistro.txtNombre}</option>
                                            {/foreach}
                                        </select>
                                        <img src="./recursos/imagenes/ayuda.png"
                                             style="width: 15px; height: 15px;"
                                             title=""
                                             id="seqConvenioToolTip"
                                             onMouseOver="mostrarToolTip();"
                                        >
                                    </td>

                                </tr>
                                <tr id="trLeasing2" style="display: {$bolCamposLeasing};">
                                    <!-- VALOR -->
                                    <td>Valor del aporte según convenio</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text"
                                                 name="valCartaLeasing"
                                                 id="valCartaLeasing"
                                                 value="{$claFormulario->valCartaLeasing|number_format:'0':'.':'.'}"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                 style="padding-right: 5px; width:100px;text-align:right;"
                                                 readonly
                                        />
                                    </td>

                                    <!-- DURACION LEASING -->
                                    <td>Duración</td>
                                    <td align="left" style="padding-left:11px;">
                                        <input type="text"
                                               name="numDuracionLeasing"
                                               id="numDuracionLeasing"
                                               value="{$claFormulario->numDuracionLeasing}"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="formatoSeparadores(this); this.style.backgroundColor = '#FFFFFF';"
                                               style="width:50px;" /> Meses
                                    </td>
                                </tr>
                                <tr>
                                    <!-- VALOR AL QUE ASPIRA DEL SUBSIDIO -->
                                    <td class="tituloTabla" height="25px" align="top">
                                        Valor
                                        {if $claFormulario->seqPlanGobierno == 2}
                                            Subsidio Aspira
                                        {else}
                                            Estimado del Aporte
                                        {/if}
                                    </td>
                                    <td bgcolor="#E0E0E0" align="right" style="padding-right:5px" id="tdValSubsidio" height="25px" align="top">
                                        $ <input type="text"
                                                 name="valAspiraSubsidio"
                                                 id="valAspiraSubsidio"
                                                 value="{$claFormulario->valAspiraSubsidio|number_format:'0':'.':'.'}"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                 style="padding-right: 5px; width:100px; text-align:right;"
                                                 readonly
                                        />
                                    </td>

                                    {if $claFormulario->seqPlanGobierno == 2}
                                        <td bgcolor="#E0E0E0" class="tituloTabla" height="25px" align="top">
                                            Soporte Cambio
                                        </td>
                                        <td bgcolor="#E0E0E0" style="padding-left: 10px;" height="25px" align="top">
                                            <input type="text"
                                                   name="txtSoporteSubsidio"
                                                   id="txtSoporteSubsidio"
                                                   value="{$claFormulario->txtSoporteSubsidio}"
                                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                   onBlur="sinCaracteresEspeciales(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                   style="width:300px;"
                                            />
                                        </td>
                                    {else}
                                        <td bgcolor="#E0E0E0">&nbsp;</td>
                                        <td bgcolor="#E0E0E0">&nbsp;</td>
                                        <input type="hidden" name="txtSoporteSubsidio" value="{$claFormulario->txtSoporteSubsidio}">
                                    {/if}
                                </tr>
                            </table>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEGUIMIENTO AL HOGAR -->
            <div id="seg" style="height:{$numAltoPestanaSecundaria}; overflow:auto;">
                {include file="seguimiento/seguimientoFormulario.tpl"}
                <div id="contenidoBusqueda">
                    {include file="seguimiento/buscarSeguimiento.tpl"}
                </div>
            </div>

            <!-- ACTOS ADMINISTRATIVOS -->
            <div id="aad" style="height:{$numAltoPestanaSecundaria};">
                {include file="subsidios/actosAdministrativos.tpl"}
            </div>
        </div>
    </div>

    <!-- VARIABLES QUE YA NO SE USAN PERO SE COLOCAN PARA RESPETAR LOS VALORES DEL OBJETO -->
    <input type="hidden" id="valAporteLote"              name="valAporteLote"              value="{$claFormulario->valAporteLote}">
    <input type="hidden" id="txtSoporteAporteLote"       name="txtSoporteAporteLote"       value="{$claFormulario->txtSoporteAporteLote}">
    <input type="hidden" id="valAporteAvanceObra"        name="valAporteAvanceObra"        value="{$claFormulario->valAporteAvanceObra}">
    <input type="hidden" id="txtSoporteAvanceObra"       name="txtSoporteAvanceObra"       value="{$claFormulario->txtSoporteAvanceObra}">
    <input type="hidden" id="valAporteMateriales"        name="valAporteMateriales"        value="{$claFormulario->valAporteMateriales}">
    <input type="hidden" id="txtSoporteAporteMateriales" name="txtSoporteAporteMateriales" value="{$claFormulario->txtSoporteAporteMateriales}">
    <input type="hidden" id="seqCesantias"               name="seqCesantias"               value="{$claFormulario->seqCesantias}">
    <input type="hidden" id="seqPuntoAtencion"           name="seqPuntoAtencion"           value="{$claFormulario->seqPuntoAtencion}">
    <input type="hidden" id="seqPeriodo"                 name="seqPeriodo"                 value="{$claFormulario->seqPeriodo}">
    <input type="hidden" id="seqUsuario"                 name="seqUsuario"                 value="{$claFormulario->seqUsuario}">
    <input type="hidden" id="numAdultosNucleo"           name="numAdultosNucleo"           value="{$claFormulario->numAdultosNucleo}">
    <input type="hidden" id="numCortes"                  name="numCortes"                  value="{$claFormulario->numCortes}">
    <input type="hidden" id="txtBarrio"                  name="txtBarrio"                  value="{$claFormulario->txtBarrio}">

    <!-- VARIABLES ADICIONALES INMODIFICABLES NECESARIAS -->
    <input type="hidden" id="seqCasaMano"   name="seqCasaMano"   value="{$claCasaMano->seqCasaMano}">
    <input type="hidden" id="seqFormulario" name="seqFormulario" value="{$claFormulario->seqFormulario}">
    <input type="hidden" id="cedula"        name="cedula"        value="{$arrPost.cedula}">
    <input type="hidden" id="txtFase"       name="txtFase"       value="{$arrFlujoHogar.fase}">
    <input type="hidden" id="txtFlujo"      name="txtFlujo"      value="{$arrFlujoHogar.flujo}">
    <input type="hidden"                    name="txtArchivo"    value="{$txtArchivo}">

</form>

<div id="postulacionTabView"></div>
<div id="objDireccionOculto" style="display:none"></div>
<div id="objDireccionOcultoSolucion" style="display:none"></div>