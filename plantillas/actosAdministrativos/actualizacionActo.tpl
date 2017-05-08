
<!-- ********************************************************** 
    PLANTILLA DE ACTUALIZACION Y POSTLACION,
    TAMBIEN SE USA PARA EL ESQUEMA DE CASA EN MANO
    EN LA FASE DE POSTULACION
*************************************************************** -->
{if $objFormulario->seqEstadoProceso != 6}
    {assign var=seqEstadoProceso value=$objFormulario->seqEstadoProceso}
{else}
    {assign var=seqEstadoProceso value=37}
{/if}


<!-- si es por el esquema de casa en mano la funcion de submit es diferente -->
{if isset( $txtArchivoCEM ) && trim( $txtArchivoCEM ) != ""}

    <!-- CASA EN MANO -->
    {assign var=txtFuncion value="someterFormulario('mensajes',this,'./contenidos/casaMano/pedirConfirmacion.php',false,true)"}
    {assign var=txtImpresion value="imprimirPostulacionCEM( document.frmPostulacion , './contenidos/casaMano/pedirConfirmacion.php' );"}
{else}

    <!-- OTRO ESQUEMA -->
    {assign var=txtFuncion   value="pedirConfirmacion('mensajes',this,'./contenidos/actosAdministrativos/pedirConfirmacion.php')"}
{/if}
<div><span style="color: #a94442"><strong>Modificación Formulario Acto Administrativo</strong></span></div>
<form name="frmPostulacion" 
      id="frmPostulacion"
      onSubmit="{$txtFuncion};
              return false;" 
      autocomplete=off 
      >	

    <!-- CODGIO PARA EL SEGUIMIENTO Y BOTON SUBMIT DEL FORMULARIO -->
    {include file='subsidios/pedirSeguimiento.tpl'}

    <!-- TABLA PARA IMPRIMIR EL FORMULARIO DE POSTULACION -->
    <table cellspacing="0" cellpadding="0" border="0" width="100%" style="z-index:999999;">
        <tr>
            <td width="150px" align="center">
                {if $txtImpresion != ""}
                    <a href="#" onClick="javascript: {$txtImpresion};">
                        Imprimir Formulario
                    </a>
                {/if}    
            </td>
            <td align="center">
                {if $txtImpresion != ""}
                    Cerrar Postulaci&oacute;n 
                    <input type="checkbox"
                           name="bolCerrado"
                           id="bolCerrado"
                           value="1"
                           {if $objFormulario->bolCerrado == 1} checked {/if}
                           >
                {else}
                    <strong>
                        {if $objFormulario->bolCerrado == 1} 
                            Formulario Cerrado
                        {else}
                            Formulario Abierto
                        {/if}
                    </strong>
                    <input type="hidden"
                           name="bolCerrado"
                           id="bolCerrado"
                           value="{$objFormulario->bolCerrado}"
                           >
                {/if}
            </td>
            <td align="right" style="padding-right: 10px;" width="250px">
                {if $smarty.session.privilegios.crear == 1 || $smarty.session.privilegios.editar == 1}
                    <input type="submit" name="salvar" id="salvar" value="Salvar Actualizaci&oacute;n">
                {/if}
            </td>
        </tr>
    </table>

    <!-- SI TIENE SANCION SE MUESTRA -->
    {if $objFormulario->bolSancion eq 1}
        <p style="background-color: #FF0000; color:white;">HOGAR SANCIONADO</p>
    {/if}
    <input type="hidden" value="{$objFormulario->bolSancion}" id="bolSancion" name="bolSancion">

    <!-- TAB VIEW PRINCIPAL -->
    <div id="postulacion" class="yui-navset" style="width:100%; text-align:left;">
        <ul class="yui-nav">
            <li class="selected"><a href="#frm"><em>Formulario</em></a></li>
            <li><a href="#seg"><em>Seguimiento</em></a></li>
            <!-- <li><a href="#aad"><em>Actos Administrativos</em></a></li>-->
        </ul>            
        <div class="yui-content">

            <!-- FORMULARIO DE POSTULACION -->	    
            <div id="frm" style="height:510px;">

                <!-- TABLA DE ESTADO DEL PROCESO Y NUMERO DEL FORMULARIO -->
                <p>
                <table cellspacing="0" cellpadding="3" border="0">
                    <tr>
                        <td nowrap>
                            <b>Estado </b>
                            
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="seqEstadoProceso2"
                                    name="seqEstadoProceso2"
                                    style="width:350px;"
                                    onchange="document.getElementById('seqEstadoProceso').value=this.value"
                                    >
                                 <option value="0">Ninguno</option>
                                {foreach from=$arrEstado key=seqEstado item=txtEstado}
                                    <option value="{$seqEstado}"{if ($seqEstado == $objFormulario->seqEstadoProceso)} selected {/if}>{$txtEstado}</option>
                                {/foreach}
                            </select>
                             
                        </td>
                        <td style="width:350px;" align="left">
                            {if $objFormulario->seqEstadoProceso == 36}
                                {$arrEstado.36}
                                <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                        onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                        name="seqEstadoProceso"
                                        id="seqEstadoProceso"
                                        style="width:350px; display:none"
                                        >
                                    <!--<option value="36" {if $seqEstadoProceso == 36} selected {/if}>
                                    {$arrEstado.36}
                                </option>-->
                                    <option value="37" {if $seqEstadoProceso == 37} selected {/if}>
                                        {$arrEstado.37}
                                    </option>
                                </select>
                            {elseif $objFormulario->seqEstadoProceso == 37}
                                <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                        onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                        name="seqEstadoProceso"
                                        id="seqEstadoProceso"
                                        style="width:350px"
                                        >
                                    <option value="37" {if $seqEstadoProceso == 37} selected {/if}>
                                        {$arrEstado.37}
                                    </option>
                                </select>
                            {elseif isset( $arrEstadosCEM ) && is_array( $arrEstadosCEM ) && in_array( $objFormulario->seqEstadoProceso , $arrEstadosCEM.adelante )}
                                <select name="seqEstadoProceso" 
                                        id="seqEstadoProceso"
                                        onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                        onBlur="this.style.backgroundColor = '#FFFFFF';"
                                        style="width:350px"
                                        >    
                                    <!-- ESTADOS DEL PROCESO DE RETORNO -->
                                    <optgroup label="Retorno">
                                        {foreach from=$arrEstadosCEM.atras item=seqEstado}
                                            <option value="{$seqEstado}">{$arrEstados.$seqEstado}</option>	
                                        {/foreach}
                                    </optgroup>

                                    <!-- ESTADOS DEL PROCESO DE AVANCE -->
                                    <optgroup label="Avance">
                                        {foreach from=$arrEstadosCEM.adelante item=seqEstado}
                                            <option value="{$seqEstado}"
                                                    {if $seqEstado == $objFormulario->seqEstadoProceso} selected {/if}
                                                    >
                                                {$arrEstados.$seqEstado}
                                            </option>
                                        {/foreach}
                                    </optgroup>
                                </select>
                            {else}
                                
                                <input type="hidden" 
                                       name="seqEstadoProceso" 
                                       id="seqEstadoProceso" 
                                       value="{$seqEstadoProceso}"
                                       >
                            {/if}	
                        </td>
                        <td align="right">
                            {if $txtTutorDesembolso != ""}
                                <b>Tutor de Desembolso: </b> {$txtTutorDesembolso}
                            {else}
                                &nbsp;
                            {/if}
                        </td>
                    </tr>
                    <tr>
                        <td nowrap>
                            <b>Esquema </b>
                            
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="seqEsquema2"
                                    name="seqEsquema2"
                                    style="width:350px;"
                                    onchange="document.getElementById('seqTipoEsquema').value=this.value"
                                    >
                                 <option value="0">Ninguno</option>
                                {foreach from=$arrEsquema key=seqEsquema item=txtEsquema}
                                    <option value="{$seqEsquema}"{if ($seqEsquema == $objFormulario->seqTipoEsquema)} selected {/if}>{$txtEsquema}</option>
                                {/foreach}
                            </select>
                             
                        </td>
                        
                    </tr>
                    <tr>
                        <!-- NUMERO DEL FORMULARIO -->
                        <td><b>No.Formulario</b></td>
                        <td align="left">
                            {if $txtImpresion != ""}
                                <input type="text" 
                                       name="txtFormulario" 
                                       id="txtFormulario" 
                                       value="{$objFormulario->txtFormulario}"
                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                       onBlur="sinCaracteresEspeciales(this);
                                               this.style.backgroundColor = '#FFFFFF';" 
                                       style="width:100px;"
                                       />
                            {else}
                                {$objFormulario->txtFormulario}
                                <input type="hidden" 
                                       name="txtFormulario" 
                                       id="txtFormulario" 
                                       value="{$objFormulario->txtFormulario}"
                                       >
                            {/if}
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
                </p>

                <!-- SUB - PESTANAS DEL FORMULARIO DE POSTULACION -->
                <div id="pestanasPostulacion" class="yui-navset" style="width:100%; text-align:left;">
                    <ul class="yui-nav">
                        <li class="selected"><a href="#composicion"><em>Composición Familiar</em></a></li>
                        <li><a href="#datosHogar"><em>Datos del Hogar</em></a></li>
                        <li><a href="#modalidad"><em>Datos de la Postulación</em></a></li>
                        <li><a href="#financiera"><em>Información Financiera</em></a></li>
                    </ul>            
                    <div class="yui-content">

                        <!-- COMPOSICION FAMILIAR -->				    
                        <div id="composicion" style="height:420px; overflow:auto;"><p>

                                <!-- TABLA PARA LAS FECHAS DE INSCRIPCION, POSTULACION, ULTIMA ACTUALIZACION -->
                            <table cellpadding="3" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
                                <tr>
                                    <td class="tituloTabla">Fecha de Inscripción:</td>
                                    <td class="tituloTabla">Fecha de Postulación:</td>
                                    <td class="tituloTabla">Última Actualización:</td>
                                    <td class="tituloTabla">Vigencia de SDV:</td>
                                </tr>
                                <tr>			        			
                                    <td style="padding-left:10px">{$objFormulario->fchInscripcion}</td>                                                                
                                    <td style="padding-left:10px">{$objFormulario->fchPostulacion}</td>
                                    <td style="padding-left:10px">{$objFormulario->fchUltimaActualizacion}</td>                                
                                    <td style="padding-left:10px">{$objFormulario->fchVigencia}</td>
                                </tr>
                            </table>

                            <!-- TABLA PARA AGREGAR UN MIEMBRO DE HOGAR -->
                            <p>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
                                <tr>
                                    <td style="padding-right:15px;" align="right" height="20px" valign="middle" bgcolor="#E4E4E4">
                                        {if $objFormulario->bolSancion neq 1}
                                            <a href="#" 
                                               onClick="mostrarOcultar('agregarMiembro');
                                                       document.getElementById('tipoDocumento').focus();"
                                               > Agregar Miembro al Hogar </a>
                                        {/if}
                                    </td>
                                </tr>
                                <tr>
                                    <td id="agregarMiembro" style="display: none;">
                                        <table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#E4E4E4">
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
                                                            {if $seqTipoDocumento != 6}
                                                                <option value="{$seqTipoDocumento}">{$txtTipoDocumento}</option>
                                                            {/if}
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
                                                           onBlur="soloNumeros(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
                                                           onKeyUp="formatoSeparadores(this)"
                                                           onChange="formatoSeparadores(this)"
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
                                                           onBlur="soloLetras(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
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
                                                           onBlur="soloLetras(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
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
                                                           onBlur="soloLetrasEspacio(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
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
                                                           onBlur="soloLetras(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
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
                                                        {foreach from=$arrParentesco key=seqParentesco item=txtParentesco}
                                                            <option value="{$seqParentesco}">{$txtParentesco}</option>
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
                                                        {foreach from=$arrEstadoCivil key=seqEstadoCivil item=txtEstadoCivil}
                                                            <option value="{$seqEstadoCivil}"
                                                                    {if $seqEstadoCivil == 1 || $seqEstadoCivil == 3 || $seqEstadoCivil == 4 || $seqEstadoCivil == 5}
                                                                        style="color:#666666"
                                                                        disabled
                                                                    {/if}
                                                                    >
                                                                {$txtEstadoCivil}
                                                            </option>
                                                        {/foreach}
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- FECHA DE NACIMIENTO -->
                                                <td>Fecha Nacimiento</td>
                                                <td style="padding-left:16px">
                                                    <input	type="text" 
                                                           id="fechaNac"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                           style="width:80px" 
                                                           value=""
                                                           readonly
                                                           /> <a onClick="calendarioPopUp('fechaNac')" href="#">Calendario</a>
                                                    <a onClick="document.getElementById('fechaNac').value = '';" href="#">Limpiar</a>
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
                                                        <option value="1">NINGUNA </option>
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
                                                    <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
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
                                                <td>Grupo LGTBI </td>
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
                                            <!-- INGRESOS MENSUALES -->
                                            <tr>
                                                <td>Ingresos</td>
                                                <td align="center">
                                                    <input type="text" 
                                                           id="ingresos" 
                                                           value="" 
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="soloNumeros(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
                                                           onkeyup="formatoSeparadores(this)"
                                                           onchange="formatoSeparadores(this)"
                                                           style="width:90%; text-align: right;"
                                                           />
                                                </td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
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
                                                <!-- AGREGAR AL FORMULARIO -->
                                                <td colspan="4" align="right" height="25px" valign="top" style="padding-right:10px">
                                                    <img src="./recursos/imagenes/bullet.jpg" 
                                                         border="0"
                                                         style="cursor:pointer"
                                                         onClick="agregarMiembroHogar();"
                                                         />&nbsp;
                                                    <a href="#" onClick="agregarMiembroHogar();">Agregar</a>
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
                                {foreach from=$objFormulario->arrCiudadano item=objCiudadano key=seqCiudadano}

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

                                    {assign var=valIngresosCiudadano value=$objCiudadano->valIngresos|replace:'[^0-9]':''}
                                    {math equation="x + y" x=$valTotal y=$valIngresosCiudadano assign=valTotal}

                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" id="{$objCiudadano->numDocumento}">
                                        <tr onMouseOver="this.style.background = '#E4E4E4';"
                                            onMouseOut="this.style.background = '#F9F9F9';"
                                            style="cursor:pointer"
                                            >
                                            <td align="center" width="18px" height="22px">
                                                <div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999;" 
                                                     onClick="desplegarDetallesMiembroHogar('{$objCiudadano->numDocumento}')"
                                                     onMouseOver="this.style.backgroundColor = '#ADD8E6';"
                                                     onMouseOut="this.style.backgroundColor = '#F9F9F9';"
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
                                                {$arrParentesco.$parentesco}
                                            </td>
                                            <td align="right" style="padding-right:7px">
                                                $ {$objCiudadano->valIngresos|number_format:0:',':'.'}
                                            </td>
                                            {if $objFormulario->bolSancion neq 1}
                                                <td align="center" width="18px" height="22px">
                                                    <div	style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999;" 
                                                         onClick="modificarMiembroHogar('{$objCiudadano->numDocumento}')"
                                                         onMouseOver="this.style.backgroundColor = '#ADD8E6';"
                                                         onMouseOut="this.style.backgroundColor = '#F9F9F9';"
                                                         >E</div>  
                                                </td>
                                                <td align="center" width="18px" height="22px">
                                                    <div	style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999;" 
                                                         onClick="quitarMiembroHogar('{$objCiudadano->numDocumento}');"
                                                         onMouseOver="this.style.backgroundColor = '#FFA4A4';"
                                                         onMouseOut="this.style.backgroundColor = '#F9F9F9'"
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
                                    </table>

                                    <!-- TABLA DE DETALLES DEL CIUDADANO -->    
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="display:none;" id="detalles{$objCiudadano->numDocumento}">
                                        <tr>
                                            <td colspan="6">
                                                <table cellpadding="2" cellspacing="0" border="0" width="100%" style="border: 1px solid #999999;">
                                                    <tr>
                                                        <td><b>Estado Civil:</b> {$arrEstadoCivil.$estadoCivil}</td>
                                                        <td><b>Condición Étnica:</b>{if isset($arrCondicionEtnica.$codicionEtnica)} {$arrCondicionEtnica.$codicionEtnica} {else} Ninguna {/if}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="50%"><b>Sexo:</b> {$arrSexo.$sexo}</td>
                                                        <td><b>Condición Especial 1:</b>{if isset($arrCondicionEspecial.$condicionEspecial)} {$arrCondicionEspecial.$condicionEspecial}{else}Ninguna{/if}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Fecha de Nacimiento:</b> {$objCiudadano->fchNacimiento}</td>
                                                        <td><b>Condición Especial 2:</b>{if isset($arrCondicionEspecial.$condicionEspecial2)} {$arrCondicionEspecial.$condicionEspecial2}{else}Ninguna{/if}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Nivel Educativo:</b> {if isset($arrNivelEducativo.$nivelEducativo)}{$arrNivelEducativo.$nivelEducativo}{else}Ninguno{/if}</td>
                                                        <td><b>Condición Especial 3:</b> {if isset($arrCondicionEspecial.$condicionEspecial3)} {$arrCondicionEspecial.$condicionEspecial3}{else}Ninguna{/if}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>LGTBI:</b> 
                                                            {if $objCiudadano->bolLgtb == 1}
                                                                {$arrGrupoLgtbi.$grupoLgtbi} 
                                                            {else} 
                                                                No 
                                                            {/if}
                                                        </td>
                                                        <td><b>Tipo de Victima:</b> {if isset($arrTipoVictima.$tipoVictima)}{$arrTipoVictima.$tipoVictima}{else}Ninguno{/if}</td>
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
                                        {if intval( $objFormulario->valIngresoHogar ) == 0}
                                            $ {$valTotal|number_format:0:',':'.'}
                                        {else}
                                            $ {$objFormulario->valIngresoHogar|number_format:0:',':'.'}
                                        {/if}
                                    </td>
                                    <td width="18px">&nbsp;</td>
                                    {if intval( $objFormulario->valIngresoHogar ) == 0}
                                    <input type="hidden" name="valIngresoHogar" id="valIngresoHogar" value="{$valTotal}">
                                {else}
                                    <input type="hidden" name="valIngresoHogar" id="valIngresoHogar" value="{$objFormulario->valIngresoHogar}">
                                {/if}
                                <td width="18px">&nbsp;</td>
                                </tr>
                            </table>	

                            </p></div>

                        <!-- DATOS DEL HOGAR -->				    
                        <div id="hogar" style="height:409px;"><p>
                            <p><table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF"  style="border: 1px dotted #999999; padding:5px">
                                <tr>
                                    <!-- VIVIENDA ACTUAL -->
                                    <td width="130px">Vivienda Actual </td>
                                    <td width="210px">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="seqVivienda" 
                                                id="seqVivienda" 
                                                style="width:260px;"
                                                >
                                            {foreach from=$arrVivienda key=seqVivienda item=txtVivienda}
                                                <option value="{$seqVivienda}"
                                                        {if $objFormulario->seqVivienda == $seqVivienda} selected {/if}
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
                                                 value="{$objFormulario->valArriendo}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';" 
                                                 style="width:249px;" />
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
                                               value="{if $objFormulario->fchArriendoDesde != '0000-00-00'}{$objFormulario->fchArriendoDesde}{/if}" 
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
                                            <option value="no" {if $objFormulario->txtComprobanteArriendo == "no"} selected {/if}>No</option>
                                            <option value="si" {if $objFormulario->txtComprobanteArriendo == "si"} selected {/if}>Si</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr> 
                                    <!-- DIRECCION DE RESIDENCIA -->
                                    <td>
                                        <a href="#" id="Direccion" onClick="recogerDireccion('txtDireccion', 'objDireccionOculto')">Dirección</a>
                                    </td>
                                    <td colspan="3">
                                        <input	type="text" 
                                               name="txtDireccion" 
                                               id="txtDireccion"
                                               value="{$objFormulario->txtDireccion}"
                                               style="width:680px;"
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
                                            ><option value="">Seleccione</option>
                                            {foreach from=$arrCiudad key=seqCiudad item=txtCiudad}
                                                <option value="{$seqCiudad}" 
                                                        {if $objFormulario->seqCiudad == $seqCiudad} selected {/if}
                                                        > {$txtCiudad}</option>            
                                            {/foreach}
                                        </select>    
                                    </td>

                                    <!-- LOCALIDAD -->
                                    <td>Localidad </td>
                                    <td id="tdlocalidad">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                onChange="obtenerBarrio(this);"
                                                name="seqLocalidad" 
                                                id="seqLocalidad" 
                                                style="width:260px;"
                                                >
                                            <option value="1" selected>Seleccione</option>
                                            {if intval( $objFormulario->seqCiudad ) != 0}
                                                {if intval( $objFormulario->seqCiudad ) == 149} <!-- BOGOTA -->
                                                    {foreach from=$arrLocalidad key=seqLocalidad item=txtLocalidad}
                                                        {if intval( $seqLocalidad ) != 22}
                                                            <option value="{$seqLocalidad}"
                                                                    {if $objFormulario->seqLocalidad == $seqLocalidad} 
                                                                        selected 
                                                                    {/if}
                                                                    >                    
                                                                {$txtLocalidad}
                                                            </option>
                                                        {/if}
                                                    {/foreach}
                                                {else} <!-- FUERA DE BOGOTA -->
                                                    <option value="22"
                                                            {if $objFormulario->seqLocalidad == 22} 
                                                                selected 
                                                            {/if}
                                                            >                    
                                                        Fuera de Bogotá
                                                    </option>
                                                {/if}
                                            {/if}
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
                                            {if intval( $objFormulario->seqLocalidad ) != 0}
                                                {foreach from=$arrBarrio key=seqBarrio item=txtBarrio}
                                                    <option value="{$seqBarrio}" 
                                                            {if $objFormulario->seqBarrio == $seqBarrio} 
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
                                        &nbsp;<input type='hidden' readonly id='seqUpz' name='seqUpz' value="{$objFormulario->seqUpz}">
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                <!-- TELEFONO 1 TELEFONO 2 Y CELULAR -->
                                <tr> 
                                    <td>Teléfonos</td>
                                    <td>
                                        <input	type="text" 
                                               name="numTelefono1" 
                                               id="numTelefono1" 
                                               value="{$objFormulario->numTelefono1}" 
                                               maxlength="7" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="soloNumeros(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:122px;" 
                                               /> ó
                                        <input	type="text" 
                                               name="numTelefono2" 
                                               id="numTelefono2" 
                                               value="{$objFormulario->numTelefono2}" 
                                               maxlength="10" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="soloNumeros(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:122px;" 
                                               />
                                    </td>
                                    <td>Teléfono Celular</td>
                                    <td>
                                        <input type="text" 
                                               name="numCelular" 
                                               id="numCelular" 
                                               value="{$objFormulario->numCelular}" 
                                               maxlength="10" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="soloNumeros(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
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
                                               value="{$objFormulario->txtCorreo}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
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
                                            {foreach from=$arrSisben key=seqSisben item=txtSisben}
                                                <option value="{$seqSisben}"
                                                        {if $objFormulario->seqSisben == $seqSisben} selected {/if}
                                                        >{$txtSisben}</option>
                                            {/foreach}
                                        </select>
                                    </td>
                                    <td>Desplazamiento forzado </td>
                                    <td>
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolDesplazado" 
                                                id="bolDesplazado" 
                                                style="width:260px;"
                                                >
                                            <option value="0" {if $objFormulario->bolDesplazado != 1} selected {/if} disabled>No</option>
                                            <option value="1" {if $objFormulario->bolDesplazado == 1} selected {/if} disabled>Si</option>
                                        </select>
                                    </td>		
                                </tr>		        	
                            </table></p>

                            <!-- TABLA RED DE SERVICIOS -->
                            <p><table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF" style="border: 1px dotted #999999; padding:5px">
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
                                            <option value="0" {if $objFormulario->bolIntegracionSocial != 1} selected {/if} >No</option>
                                            <option value="1" {if $objFormulario->bolIntegracionSocial == 1} selected {/if} >Si</option>
                                        </select>
                                    </td>	

                                    <!-- SEC SALUD -->
                                    <td width="110px" align="right">Sec. Salud</td>
                                    <td style="padding-left:10px;">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolSecSalud" 
                                                id="bolSecSalud" 
                                                style="width:100%;"
                                                >
                                            <option value="0" {if $objFormulario->bolSecSalud != 1} selected {/if} >No</option>
                                            <option value="1" {if $objFormulario->bolSecSalud == 1} selected {/if} >Si</option>
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
                                            <option value="0" {if $objFormulario->bolSecEducacion != 1} selected {/if} >No</option>
                                            <option value="1" {if $objFormulario->bolSecEducacion == 1} selected {/if} >Si</option>
                                        </select>
                                    </td>

                                    <!-- IPES -->
                                    <td width="110px" align="right">IPES</td>
                                    <td style="padding-left:10px;">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolIpes" 
                                                id="bolIpes" 
                                                style="width:100%;"
                                                >
                                            <option value="0" {if $objFormulario->bolIpes != 1} selected {/if} >No</option>
                                            <option value="1" {if $objFormulario->bolIpes == 1} selected {/if} >Si</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- OTRO -->
                                    <td align="right">Otro</td>
                                    <td colspan="8" style="padding-left:10px">
                                        <input	type="text" 
                                               name="txtOtro" 
                                               id="txtOtro" 
                                               value="{$objFormulario->txtOtro}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:100%;" 
                                               />
                                    </td>
                                </tr>
                            </table></p>
                            </p></div>

                        <!-- MODALIDAD Y VIVIENDA -->				        
                        <div id="modalidad" style="height:410px;"><p>
                            <table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px dotted #666666;">

                                <!-- PLAN DE GOBIERNO -->
                                {if $objFormulario->seqEtapa >= 4} 
                                    <input type="hidden" name="seqPlanGobierno" id="seqPlanGobierno" value="{$objFormulario->seqPlanGobierno}">
                                {else}
                                    <input type="hidden" name="seqPlanGobierno" id="seqPlanGobierno" value="2">
                                {/if}


                                <!-- MODALIDAD DEL SUBSIDIO y TIPO DE SOLUCION -->
                                <tr>
                                    <td>Modalidad Solución</td>
                                    <td width="260px">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="seqModalidad" 
                                                id="seqModalidad" 
                                                style="width:260px;"
                                                onChange="obtenerTipoSolucion(this)"
                                                >
                                            <option value="0">Seleccione</option>
                                            {foreach from=$arrModalidad key=seqModalidad item=arrDatos}
                                                <option value="{$seqModalidad}"
                                                        {if $objFormulario->seqModalidad == $seqModalidad} 
                                                            selected 
                                                        {/if}
                                                        {if $arrDatos.seqPlanGobierno == 1}
                                                            disabled
                                                        {/if}
                                                        >
                                                    {$arrDatos.txtModalidad}
                                                </option>
                                            {/foreach}
                                        </select>
                                        <input type='hidden' id='seqPlanGobierno' name='seqPlanGobierno' value='{$objFormulario->seqPlanGobierno}'>
                                    </td>
                                    <td width="90px">Tipo Solución</td>
                                    <td id="tdTipoSolucion" align="left">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                onChange="asignarValorSubsidio(this, 'bolDesplazado');"
                                                name="seqSolucion" 
                                                id="seqSolucion" 
                                                style="width:100%;"
                                                >
                                            <option value="1">NINGUNA</option>
                                            {if intval( $objFormulario->seqModalidad ) != 0}                           
                                                {foreach from=$arrSolucion key=seqSolucion item=arrDatos}
                                                    {if $objFormulario->seqModalidad == $arrDatos.seqModalidad}
                                                        <option value="{$seqSolucion}"
                                                                {if $objFormulario->seqSolucion == $seqSolucion} 
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

                                <!-- PROYECTO -->
                                <tr>
                                    <td>Proyecto</td>
                                    <td id="tdProyecto" colspan="3" align="left">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                onChange="obtenerDatosProyecto(this, {$objFormulario->seqPlanGobierno});"
                                                name="seqProyecto" 
                                                id="seqProyecto" 
                                                style="width:100%"
                                                >
                                            <optgroup label="Bogota Humana">
                                                <option value='0'>Ninguno</option>
                                                {foreach from=$arrProyecto key=seqProyecto item=txtProyecto}
                                                    <option value="{$seqProyecto}"
                                                            {if $objFormulario->seqProyecto == $seqProyecto} 
                                                                selected 
                                                            {/if}
                                                            >{$txtProyecto}</option>
                                                {/foreach}
                                            </optgroup>
                                        </select>
                                        <input type="hidden" name="seqProyectoHijo" id="seqProyectoHijo" value ="{$objFormulario->seqProyectoHijo}">
                                        <input type="hidden" name="seqUnidadProyecto" id="seqUnidadProyecto" value ="{$objFormulario->seqUnidadProyecto}">
                                        <input type="hidden" name="seqTipoFinanciacion" id="seqTipoFinanciacion" value ="{$objFormulario->seqTipoFinanciacion}">
                                    </td>
                                </tr>
                                <!-- UNIDAD RESIDENCIAL :: Jaison Ospina :: 13-01-2016 -->
                                {if $nombreConjunto != ''}
                                    <tr>
                                        <td>Conjunto Residencial</td>
                                        <td colspan="3" align="left">{$nombreConjunto}</td>
                                    </tr>
                                {/if}
                                <!-- UNIDAD RESIDENCIAL :: Jaison Ospina :: 13-01-2016 -->
                                {if $nombreUnidad != ''}
                                    <tr>
                                        <td>Unidad Residencial</td>
                                        <td colspan="3" align="left">{$nombreUnidad}</td>
                                    </tr>
                                {/if}
                                <!-- DIRECCION SOLUCION-->
                                <!--<tr>
                                    <td width="130px">
                                {if $objFormulario->seqEstadoProceso == 43 || $objFormulario->seqEstadoProceso == 44 ||$objFormulario->seqEstadoProceso == 45 ||$objFormulario->seqEstadoProceso == 46 ||$objFormulario->seqEstadoProceso == 47 ||$objFormulario->seqEstadoProceso == 48 }
                                                                Dirección Solución
                                {else}
                                        <a href="#" id="DireccionSolucion" onClick="recogerDireccion('txtDireccionSolucion', 'objDireccionOcultoSolucion')">Dirección Solución</a>
                                {/if}
                        </td>
    <td colspan="3" align="left">
        <input type="text" 
               name="txtDireccionSolucion" 
               id="txtDireccionSolucion" 
               value="{$objFormulario->txtDireccionSolucion}" 
               style="width:100%;"
               onFocus="this.style.backgroundColor = '#ADD8E6';" 
               onBlur="this.style.backgroundColor = '#FFFFFF';" 
               readonly
               />
    </td>
</tr>-->
                                <tr>
                                    <td>
                                        {if $objFormulario->seqTipoEsquema == 1 }
                                            <div id="divEsqDefault">Dirección Solución</div>
                                        {else}
                                            <div id="divEsqDefault"><a href="#" id="DireccionSolucion" onClick="recogerDireccion('txtDireccionSolucion', 'objDireccionOcultoSolucion')">Dirección Solución</a></div>
                                        {/if}
                                        <div id="divEsqIndiv" style="display:none">Dirección Solución</div>
                                        <div id="divEsqOtros" style="display:none"><a href="#" id="DireccionSolucion" onClick="recogerDireccion('txtDireccionSolucion', 'objDireccionOcultoSolucion')">Dirección Solución</a></div>
                                    </td>
                                    <td colspan="3" align="left">
                                        <input type="text" 
                                               name="txtDireccionSolucion" 
                                               id="txtDireccionSolucion" 
                                               value="{$objFormulario->txtDireccionSolucion}" 
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
                                               value="{$objFormulario->txtMatriculaInmobiliaria}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:260px;"

                                               />
                                    </td>
                                    <td>CHIP</td>
                                    <td>
                                        <input type="text" 
                                               name="txtChip" 
                                               id="txtChip" 
                                               value="{$objFormulario->txtChip}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:100%;"

                                               />
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px dotted #666666">

                                <!-- TIENE PROMESA DE COMPRA VENTA FIRMADA -->
                                <tr>
                                    <td width="350px">¿ Tiene una promesa de compra - venta firmada ?</td>
                                    <td>
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolPromesaFirmada" 
                                                id="bolPromesaFirmada" 
                                                style="width:100px;"
                                                >
                                            <option value="0" {if $objFormulario->bolPromesaFirmada != 1} selected {/if}>No</option>
                                            <option value="1" {if $objFormulario->bolPromesaFirmada == 1} selected {/if}>Si</option>
                                        </select>
                                    </td>			
                                    <td>&nbsp;</td>
                                </tr>

                                <!-- TIENE IDENTIFICADA UNA SOLUCION DE VIVIENDA VIABILIZADA POR LA SDHT -->
                                <tr>
                                    <td>¿ Tiene Idetificada una solución Viabilizada por la SDHT ?</td>
                                    <td>
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolIdentificada" 
                                                id="bolIdentificada" 
                                                style="width:100px;"
                                                >
                                            <option value="0" {if $objFormulario->bolIdentificada != 1} selected {/if}>No</option>
                                            <option value="1" {if $objFormulario->bolIdentificada == 1} selected {/if}>Si</option>
                                        </select>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                <!-- PERTENECE A UN PLAN DE VIVIENDA VIABILIZADA POR LA SDHT -->
                                <tr>
                                    <td>Pertenece a un Plan de Vivienda Viabilizada por la SDHT</td>
                                    <td>
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolViabilizada" 
                                                id="bolViabilizada" 
                                                style="width:100px;"
                                                >
                                            <option value="0" {if $objFormulario->bolViabilizada != 1} selected {/if}>No</option>
                                            <option value="1" {if $objFormulario->bolViabilizada == 1} selected {/if}>Si</option>
                                        </select>
                                    </td>	
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <br>

                            {if trim( $txtArchivoCEM ) == ""}
                                <table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px dotted #666666">
                                    <tr>	
                                        <!-- VALOR DEL PRESUPUESTO -->
                                        <td width="120px">Presupuesto</td>
                                        <td width="120px">
                                            $ <input	type="text" 
                                                     name="valPresupuesto" 
                                                     id="valPresupuesto" 
                                                     value="{$objFormulario->valPresupuesto|number_format:0:'.':'.'}" 
                                                     onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                     onBlur="soloNumeros(this);
                                                             this.style.backgroundColor = '#FFFFFF';
                                                             sumarTotal();" 
                                                     onKeyUp="formatoSeparadores(this)"
                                                     onChange="formatoSeparadores(this)"
                                                     style="width:100px;"
                                                     />
                                        </td>

                                        <!-- VALOR DEL AVALUO  -->
                                        <td>Aval&uacute;o</td>
                                        <td  width="120px">
                                            $ <input type="text" 
                                                     name="valAvaluo" 
                                                     id="valAvaluo" 
                                                     value="{$objFormulario->valAvaluo|number_format:0:'.':'.'}" 
                                                     onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                     onBlur="soloNumeros(this);
                                                             this.style.backgroundColor = '#FFFFFF';
                                                             sumarTotal();" 
                                                     onKeyUp="formatoSeparadores(this)"
                                                     onChange="formatoSeparadores(this)"
                                                     style="width:100px;"
                                                     />
                                        </td>

                                        <!-- VALOR TOTAL  -->
                                        <td>Total</td>
                                        <td  width="134px">
                                            $ <input	type="text" 
                                                     name="valTotal" 
                                                     id="valTotal" 
                                                     value="{$objFormulario->valTotal}" 
                                                     onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                     onBlur="soloNumeros(this);
                                                             this.style.backgroundColor = '#FFFFFF';" 
                                                     style="width:90%;"
                                                     readonly
                                                     />
                                        </td>
                                    </tr>
                                </table>
                            {/if}
                            </p></div>

                        <!-- INFORMACION FINANCIERA -->				       
                        <div id="financiera" style="height:407px;"><p>
                            <table cellpadding="1" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
                                <tr>
                                    <!-- TIENE AHORRO -->
                                    <td>Ahorro 1</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input	type="text" 
                                                 name="valSaldoCuentaAhorro" 
                                                 id="valSaldoCuentaAhorro" 
                                                 value="{$objFormulario->valSaldoCuentaAhorro|number_format:'0':'.':'.'}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px; text-align:right;" 
                                                 />
                                    </td>

                                    <!-- BANCO DONDE TIENE EL AHORRO -->
                                    <td>Entidad</td>
                                    <td align="center" width="320px">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"  
                                                name="seqBancoCuentaAhorro" 
                                                id="seqBancoCuentaAhorro" 
                                                style="width:300px;"
                                                >
                                            <option value="1">Ninguno</option>
                                            {foreach from=$arrBanco key=seqBanco item=txtBanco}
                                                <option value="{$seqBanco}"
                                                        {if $objFormulario->seqBancoCuentaAhorro == $seqBanco} selected {/if}
                                                        >{$txtBanco}</option>
                                            {/foreach}
                                        </select>

                                    </td>
                                </tr>
                                <tr>
                                    <!-- SOPORTE CUENTA AHORRO E INMOVILIZADA -->
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Soporte</td>
                                    <td style="padding-left:11px;">
                                        <input	type="text" 
                                               name="txtSoporteCuentaAhorro" 
                                               id="txtSoporteCuentaAhorro" 
                                               value="{$objFormulario->txtSoporteCuentaAhorro}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"  
                                               style="width:195px;" 
                                               /> Inmovilizado 
                                        <input	type="checkbox"
                                               name="bolInmovilizadoCuentaAhorro"
                                               id="bolInmovilizadoCuentaAhorro"
                                               value="1"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                                               {if $objFormulario->bolInmovilizadoCuentaAhorro == 1} checked {/if}
                                               />
                                    </td>
                                </tr>
                                <tr>
                                    <!-- FECHA APERTURA CUENTA AHORRO -->
                                    {if $objFormulario->fchAperturaCuentaAhorro == '0000-00-00'}
                                        {assign var=fchAperturaCuentaAhorro value=""}
                                    {else}
                                        {assign var=fchAperturaCuentaAhorro value=$objFormulario->fchAperturaCuentaAhorro}
                                    {/if}
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Fecha Apertura</td>
                                    <td style="padding-left:11px;">
                                        <input type="text" 
                                               name="fchAperturaCuentaAhorro" 
                                               id="fchAperturaCuentaAhorro" 
                                               value="{$fchAperturaCuentaAhorro}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"  
                                               style="width:100px;"
                                               maxlength="10" 
                                               readonly
                                               /> 
                                        <a href="#" onClick="javascript: calendarioPopUp('fchAperturaCuentaAhorro');">Calendario</a>&nbsp;&nbsp;
                                        <a onClick="document.getElementById('fchAperturaCuentaAhorro').value = '';" href="#">Limpiar</a>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- TIENE OTRO AHORRO -->
                                    <td>Ahorro 2</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input	type="text" 
                                                 name="valSaldoCuentaAhorro2" 
                                                 id="valSaldoCuentaAhorro2" 
                                                 value="{$objFormulario->valSaldoCuentaAhorro2|number_format:'0':'.':'.'}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();" 
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px; text-align:right;" 
                                                 />
                                    </td>

                                    <!-- BANCO DONDE TIENE EL AHORRO -->
                                    <td>Entidad</td>
                                    <td align="center" width="320px">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"  
                                                name="seqBancoCuentaAhorro2" 
                                                id="seqBancoCuentaAhorro2" 
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
                                    <!-- SOPORTE CUENTA AHORRO E INMOVILIZADA -->
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Soporte</td>
                                    <td style="padding-left:11px;">
                                        <input	type="text" 
                                               name="txtSoporteCuentaAhorro2" 
                                               id="txtSoporteCuentaAhorro2" 
                                               value="{$objFormulario->txtSoporteCuentaAhorro2}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"  
                                               style="width:195px;" 
                                               /> Inmovilizado 
                                        <input	type="checkbox"
                                               name="bolInmovilizadoCuentaAhorro2"
                                               id="bolInmovilizadoCuentaAhorro2"
                                               value="1"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                                               {if $objFormulario->bolInmovilizadoCuentaAhorro2 == 1} checked {/if}
                                               />
                                    </td>
                                </tr>
                                <tr>
                                    <!-- FECHA APERTURA CUENTA AHORRO -->
                                    {if $objFormulario->fchAperturaCuentaAhorro2 == '0000-00-00'}
                                        {assign var=fchAperturaCuentaAhorro2 value=""}
                                    {else}
                                        {assign var=fchAperturaCuentaAhorro2 value=$objFormulario->fchAperturaCuentaAhorro2}
                                    {/if}
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Fecha Apertura</td>
                                    <td style="padding-left:11px;">
                                        <input	type="text" 
                                               name="fchAperturaCuentaAhorro2" 
                                               id="fchAperturaCuentaAhorro2" 
                                               value="{$fchAperturaCuentaAhorro2}" 
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
                                <tr>
                                    <!-- SUBSIDIO NACIONAL -->
                                    <td>Valor Subsidio: AVC / FOVIS / SFV</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input	type="text" 
                                                 name="valSubsidioNacional" 
                                                 id="valSubsidioNacional" 
                                                 value="{$objFormulario->valSubsidioNacional|number_format:'0':'.':'.'}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"  
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px;text-align:right;" 
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
                                                        {if $objFormulario->seqEntidadSubsidio == $seqEntidadSubsidio} selected {/if}
                                                        >{$txtEntidadSubsidio}</option>
                                            {/foreach}
                                        </select>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>Soporte (No.Carta)</td>
                                    <td align="center">
                                        <input type="text" 
                                               name="txtSoporteSubsidioNacional" 
                                               id="txtSoporteSubsidioNacional" 
                                               value="{$objFormulario->txtSoporteSubsidioNacional}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"  
                                               style="width:300px;" 
                                               />
                                    </td>
                                </tr>
                                <tr>
                                    <!-- APORTE LOTE -->
                                    <td>Acuerdo Pago / Lote / Terreno</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input	type="text" 
                                                 name="valAporteLote" 
                                                 id="valAporteLote" 
                                                 value="{$objFormulario->valAporteLote|number_format:'0':'.':'.'}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"  
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px;text-align:right;" 
                                                 />
                                    </td>

                                    <!-- SOPORTE APORTE LOTE -->
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input type="text" 
                                               name="txtSoporteLote" 
                                               id="txtSoporteLote" 
                                               value="{$objFormulario->txtSoporteAporteLote}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"  
                                               style="width:300px;" 
                                               />
                                    </td>
                                </tr>	
                                <tr>
                                    <!-- CESANTIAS -->
                                    <td>Cesant&iacute;as</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input	type="text" 
                                                 name="valSaldoCesantias" 
                                                 id="valSaldoCesantias" 
                                                 value="{$objFormulario->valSaldoCesantias|number_format:'0':'.':'.'}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"  
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px;text-align:right;" 
                                                 />
                                    </td>

                                    <!-- SOPORTE CESANTIAS -->
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input type="text" 
                                               name="txtSoporteCesantias" 
                                               id="txtSoporteCesantias" 
                                               value="{$objFormulario->txtSoporteCesantias}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"  
                                               style="width:300px;" 
                                               />
                                    </td>
                                </tr>	
                                <tr>
                                    <!-- APORTE AVANCE DE OBRA -->
                                    <td>Aporte Avance de Obra</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input	type="text" 
                                                 name="valAporteAvanceObra" 
                                                 id="valAporteAvanceObra" 
                                                 value="{$objFormulario->valAporteAvanceObra|number_format:'0':'.':'.'}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"  
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px;text-align:right;" 
                                                 />
                                    </td>

                                    <!-- SOPORTE AVANCE OBRA -->
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input type="text" 
                                               name="txtSoporteAvanceObra" 
                                               id="txtSoporteAvanceObra" 
                                               value="{$objFormulario->txtSoporteAvanceObra}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"  
                                               style="width:300px;" 
                                               />
                                    </td>
                                </tr>
                                <tr>
                                    <!-- TIENE CREDITO -->
                                    <td>Cr&eacute;dito</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text" 
                                                 name="valCredito" 
                                                 id="valCredito" 
                                                 value="{$objFormulario->valCredito|number_format:'0':'.':'.'}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"  
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px;text-align:right;" 
                                                 />
                                    </td>

                                    <!-- BANCO DONDE TIENE EL CREDITO -->
                                    <td>Entidad</td>
                                    <td align="center">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="soloNumeros(this);
                                                        this.style.backgroundColor = '#FFFFFF';"  
                                                name="seqBancoCredito" 
                                                id="seqBancoCredito" 
                                                style="width:300px;"
                                                >
                                            <option value="1">Sin Credito</option>
                                            {foreach from=$arrBanco key=seqBanco item=txtBanco}
                                                <option value="{$seqBanco}"
                                                        {if $objFormulario->seqBancoCredito == $seqBanco} selected {/if}
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
                                               value="{$objFormulario->txtSoporteCredito}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"  
                                               style="width:300px;" 
                                               /> 
                                    </td>
                                </tr>
                                <tr>
                                    <!-- FECHA APROBACION CREDITO -->
                                    {if $objFormulario->fchAprobacionCredito == '0000-00-00'}
                                        {assign var=fchAprobacionCredito value=""}
                                    {else}
                                        {assign var=fchAprobacionCredito value=$objFormulario->fchAprobacionCredito}
                                    {/if}

                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Fecha Vencimiento</td>
                                    <td style="padding-left:11px;">
                                        <input type="text" 
                                               name="fchAprobacionCredito" 
                                               id="fchAprobacionCredito" 
                                               value="{$fchAprobacionCredito}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"  
                                               style="width:100px;"
                                               maxlength="10" 
                                               readonly
                                               /> 
                                        <a onClick="calendarioPopUp('fchAprobacionCredito')" href="#">Calendario</a>&nbsp;&nbsp;
                                        <a onClick="document.getElementById('fchAprobacionCredito').value = '';" href="#">Limpiar</a>
                                    </td>
                                </tr>				
                                <tr>
                                    <!-- APORTE AVANCE DE OBRA -->
                                    <td>Aporte Materiales</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input	type="text" 
                                                 name="valAporteMateriales" 
                                                 id="valAporteMateriales" 
                                                 value="{$objFormulario->valAporteMateriales|number_format:'0':'.':'.'}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"  
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px;text-align:right;" 
                                                 />
                                    </td>

                                    <!-- SOPORTE AVANCE OBRA -->
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input type="text" 
                                               name="txtSoporteAporteMateriales" 
                                               id="txtSoporteAporteMateriales" 
                                               value="{$objFormulario->txtSoporteAporteMateriales}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"  
                                               style="width:300px;" 
                                               />
                                    </td>
                                </tr>
                                <tr>
                                    <!-- TIENE DONACIONES -->
                                    <td>Donaci&oacute;n</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text" 
                                                 name="valDonacion" 
                                                 id="valDonacion" 
                                                 value="{$objFormulario->valDonacion|number_format:'0':'.':'.'}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"  
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px;text-align:right;" 
                                                 />
                                    </td>

                                    <!-- DE DONDE PROVIENE LA DONACION -->
                                    <td>Entidad Donante</td>
                                    <td style="padding-left: 10px;">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="soloNumeros(this);
                                                        this.style.backgroundColor = '#FFFFFF';"  
                                                name="seqEmpresaDonante" 
                                                id="seqEmpresaDonante" 
                                                style="width:300px;"
                                                >
                                            <option value="1">Ninguna</option>
                                            {foreach from=$arrDonantes key=seqEmpresaDonante item=txtEmpresaDonante}
                                                <option value="{$seqEmpresaDonante}"
                                                        {if $objFormulario->seqEmpresaDonante == $seqEmpresaDonante} selected {/if}
                                                        >{$txtEmpresaDonante}</option>
                                            {/foreach}
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- SOPORTE DONACION -->
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input type="text" 
                                               name="txtSoporteDonacion" 
                                               id="txtSoporteDonacion" 
                                               value="{$objFormulario->txtSoporteDonacion}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"  
                                               style="width:300px;" 
                                               /> 
                                    </td>
                                </tr>
                                <tr bgcolor="#E0E0E0">

                                    <!-- TOTAL RECURSOS ECONOMICOS -->
                                    <td class="tituloTabla">Total Recursos</td>
                                    <td id="totalRecursosMostrar" align="right" style="padding-right:10px">
                                        <b>$ {$objFormulario->valTotalRecursos|number_format:'0':'.':','}</b>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                <input type="hidden" name="valTotalRecursos" id="valTotalRecursos" value="{$objFormulario->valTotalRecursos}">
                                </tr>

                                <tr bgcolor="#E0E0E0">

                                    {assign var=seqModalidad value=$objFormulario->seqModalidad}
                                    {assign var=seqSolucion value=$objFormulario->seqSolucion}

                                    {if $objFormulario->valAspiraSubsidio == 0 || $objFormulario->valAspiraSubsidio == ""}
                                        {assign var=valSubsidio value=$arrValorSubsidio.$seqModalidad.$seqSolucion}
                                        {if $valSubsidio == ""}
                                            {assign var=valSubsidio value=0}
                                        {/if}
                                    {else}
                                        {assign var=valSubsidio value=$objFormulario->valAspiraSubsidio}
                                    {/if}

                                    <!-- VALOR AL QUE ASPIRA DEL SUBSIDIO -->
                                    <td class="tituloTabla" height="25px" align="top">Valor Subsidio Aspira</td>
                                    <td align="right" style="padding-right:10px" id="tdValSubsidio"  height="25px" align="top">
                                        $ <input	type="text" 
                                                 name="valAspiraSubsidio"
                                                 id="valAspiraSubsidio" 
                                                 value="{$valSubsidio|number_format:'0':'.':'.'}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"  
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px; text-align:right;"
                                                 {if $objFormulario->seqTipoEsquema == 1}
                                                     readonly
                                                 {/if}
                                                 />
                                    </td>
                                    <td class="tituloTabla"  height="25px" align="top">Soporte Cambio</td>
                                    <td style="padding-left: 10px;"  height="25px" align="top">
                                        <input	type="text" 
                                               name="txtSoporteSubsidio" 
                                               id="txtSoporteSubsidio" 
                                               value="{$objFormulario->txtSoporteSubsidio}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"  
                                               style="width:300px;" 
                                               />
                                    </td>
                                </tr>				        		
                            </table>
                            </p></div>
                    </div>
                </div>
            </div>

            <!-- SEGUIMIENTO AL HOGAR -->	        
            <div id="seg" style="height:401px; overflow:auto;">
                {include file="seguimiento/seguimientoFormulario.tpl"}
                <div id="contenidoBusqueda" >
                    retreytert
                    {include file="seguimiento/buscarSeguimientoActo.tpl"}
                </div>
            </div>

            <!-- ACTOS ADMINISTRATIVOS	   -->     

        </div>
    </div>

    <input type="hidden" id="seqTipoEsquema" name="seqTipoEsquema" value="{$objFormulario->seqTipoEsquema}" />
    <input type="hidden" id="seqFormulario" name="seqFormulario" value="{$seqFormulario}">
    <input type="hidden" id="seqFormularioActo" name="seqFormularioActo" value="{$seqFormularioActo}">
    <input type="hidden" name="txtArchivo" value="./contenidos/actosAdministrativos/salvarActualizacionActo.php">
    <input type="hidden" name="numDocumento" value="{$numDocumento}">

    {if isset( $txtArchivoCEM ) && trim( $txtArchivoCEM ) != ""}
        <input type="hidden" name="seqCasaMano" value="{$seqCasaMano}">
        <input type="hidden" name="txtFase" value="{$arrFlujoHogar.fase}">
        <input type="hidden" name="txtFlujo" value="{$arrFlujoHogar.flujo}">
    {/if}

</form>

<div id="postulacionTabView"></div>
<div id="objDireccionOculto" style="display:none"></div>
<div id="objDireccionOcultoSolucion" style="display:none"></div>
