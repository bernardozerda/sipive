

<!--
        PLANTILLA DE POSTULACION CON PESTAÑAS 
-->

<form name="frmPostulacion" 
      id="frmPostulacion"
      onSubmit="pedirConfirmacion('mensajes', this, './contenidos/subsidios/pedirConfirmacion.php');
              return false;" 
      autocomplete=off 
      >	


    <!-- CODGIO PARA EL POP UP DE SEGUIMIENTO -->
    {assign var=seqEstadoProceso value=$objFormulario->seqEstadoProceso}
    {include file='subsidios/pedirSeguimiento.tpl'}
    <br>
    <table cellspacing="0" cellpadding="0" border="0" width="100%" style="z-index:999999;">
        <tr>
            <td width="150px" align="center">
                <a href="#" onClick="javascript: alert('No Puede Imprimir el Formulario');">
                    Imprimir Formulario
                </a>
            </td>
            <td align="center">
                Cerrar Postulaci&oacute;n 
                <input	type="checkbox"
                       name="bolCerrado"
                       id="bolCerrado"
                       value="1"
                       {if $objFormulario->bolCerrado == 1} checked {/if}
                       >						
            </td>
            <td align="right" style="padding-right: 10px;" width="250px">
                &nbsp;
            </td>
        </tr>
    </table>
    <br>

    <!-- TAB VIEW DE POSTULACION -->
    <div id="postulacion" class="yui-navset" style="width:100%; text-align:left;">
        <ul class="yui-nav">
            <li class="selected"><a href="#frm"><em>Formulario</em></a></li>
            <li><a href="#seg"><em>Seguimiento</em></a></li>
            <li><a href="#aad"><em>Actos Administrativos</em></a></li>
        </ul>            
        <div class="yui-content">

            <!-- FORMULARIO DE POSTULACION -->	    
            <div id="frm" style="height:412px;">

                <!-- TABLA DE ESTADO DEL PROCESO Y NUMERO DEL FORMULARIO -->
                <TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <!-- ESTADO DEL PROCESO -->
                        <td height="25px" style="padding-left:10px;" width="60px"><b>Estado</b></td>
                        <td align="center" width="190px">
                            {if $objFormulario->seqEstadoProceso == 6 || $objFormulario->seqEstadoProceso == 7 }
                                <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                        onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                        name="seqEstadoProceso"
                                        id="estadoProceso" 
                                        style="width:180px;"
                                        >
                                    {foreach from=$arrEstado key=seqEstadoProceso item=txtEstadoProceso}
                                        {if $seqEstadoProceso == 6 || $seqEstadoProceso == 7 }
                                            <option value="{$seqEstadoProceso}"
                                                    {if $objFormulario->seqEstadoProceso == $seqEstadoProceso } selected {/if}
                                                    >{$txtEstadoProceso}</option>
                                        {/if}
                                    {/foreach}
                                </select>
                            {else}	
                                {assign var=seqEstadoProceso value=$objFormulario->seqEstadoProceso}
                                {$arrEstado.$seqEstadoProceso}
                                <input	type="hidden" 
                                       name="seqEstadoProceso" 
                                       id="seqEstadoProceso" 
                                       value="{$seqEstadoProceso}"
                                       />
                            {/if}	
                        </td>

                        <!-- NUMERO DEL FORMULARIO -->
                        <td width="150px" align="center"><b>Número Formulario</b></td>
                        <td width="150px" align="left">
                            <input	type="text" 
                                   name="txtFormulario" 
                                   id="txtFormulario" 
                                   value="{$objFormulario->txtFormulario}"
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="sinCaracteresEspeciales(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:100px;"
                                   {if $objFormulario->txtFormulario != ""}
                                       readonly
                                   {/if}
                                   />
                        </td>
                        <td width="150px"><b>Cortes de Calificaci&oacute;n</b></td>
                        <td>{$objFormulario->numCortes}</td>
                    </tr>
                </table>

                <div id="pestanasPostulacion" class="yui-navset" style="width:100%; text-align:left;">
                    <ul class="yui-nav">
                        <li class="selected"><a href="#composicion"><em>Composición Familiar</em></a></li>
                        <li><a href="#datosHogar"><em>Datos del Hogar</em></a></li>
                        <li><a href="#modalidad"><em>Datos de la Postulación</em></a></li>
                        <li><a href="#financiera"><em>Información Financiera</em></a></li>
                    </ul>            
                    <div class="yui-content">

                        <!-- COMPOSICION FAMILIAR -->				    
                        <div id="composicion" style="height:349px; overflow:auto;">

                            <!-- TABLA PARA LAS FECHAS DE INSCRIPCION, POSTULACION, ULTIMA ACTUALIZACION -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
                                <tr>
                                    <td class="tituloTabla">Fecha de Inscripción:</td>
                                    <td class="tituloTabla">Fecha de Postulación:</td>
                                    <td class="tituloTabla">Última Actualización:</td>
                                </tr>
                                <tr>
                                    <td style="padding-left:10px">{$objFormulario->fchInscripcion}</td>
                                    <td style="padding-left:10px">{$objFormulario->fchPostulacion}</td>
                                    <td style="padding-left:10px">{$objFormulario->fchUltimaActualizacion}</td>
                                </tr>
                            </table>


                            <!-- TABLA PARA AGREGAR UN MIEMBRO DE HOGAR -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
                                <tr><td style="padding-right:15px;" align="right" height="20px" valign="middle" bgcolor="#CCCCCC">
                                        <a href="#" 
                                           onClick="mostrarOcultar('agregarMiembro');
                                                   document.getElementById('tipoDocumento').focus();"
                                           > Agregar Miembro al Hogar </a>
                                    </td></tr>
                                <tr><td id="agregarMiembro" style="display: none;">
                                        <table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#E4E4E4">
                                            <TR>
                                                <!-- TIPO DE DOCUMENTO -->
                                                <TD>Tpo. Docum. (*)</TD>
                                                <TD align="center" width="205px">
                                                    <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="tipoDocumento" 
                                                            style="width:200px;"
                                                            >
                                                        {foreach from=$arrTipoDocumento key=seqTipoDocumento item=txtTipoDocumento}
                                                            <option value="{$seqTipoDocumento}">{$txtTipoDocumento}</option>
                                                        {/foreach}
                                                    </select>
                                                </TD>

                                                <!-- NUMERO DEL DOCUMENTO -->
                                                <TD>Número (*)</TD>
                                                <td align="center" width="275px">
                                                    <input	type="text" 
                                                           id="numeroDoc" 
                                                           value="" 
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="soloNumeros(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
                                                           style="width:270px;" 
                                                           />
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- PRIMER APELLIDO -->	
                                                <TD>Primer Apellido (*)</TD>
                                                <td align="center">
                                                    <input	type="text" 
                                                           id="apellido1" 
                                                           value="" 
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="soloLetras(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
                                                           style="width:200px;"
                                                           />
                                                </td>

                                                <!-- SEGUNDO APELLIDO -->
                                                <TD>Segundo Apellido</TD>
                                                <td align="center">
                                                    <input	type="text" 
                                                           id="apellido2" 
                                                           value="" 
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="soloLetras(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
                                                           style="width:270px;"
                                                           />
                                                </td>
                                            </TR>
                                            <tr>

                                                <!-- PRIMER NOMBRE -->
                                                <TD>Primer Nombre (*)</TD>
                                                <td align="center">
                                                    <input	type="text" 
                                                           id="nombre1" 
                                                           value="" 
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="soloLetras(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
                                                           style="width:200px;"
                                                           />
                                                </td>

                                                <!-- SEGUNDO NOMBRE -->
                                                <TD>Segundo Nombre</TD>
                                                <td align="center">
                                                    <input	type="text" 
                                                           id="nombre2" 
                                                           value="" 
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="soloLetras(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
                                                           style="width:270px;"
                                                           />
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- PARENTESCO -->
                                                <td>Parentesco (*)</td>
                                                <td align="center">
                                                    <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="parentesco" 
                                                            style="width:200px;"
                                                            >
                                                        {foreach from=$arrParentesco key=seqParentesco item=txtParentesco}
                                                            <option value="{$seqParentesco}">{$txtParentesco}</option>
                                                        {/foreach}
                                                    </select>
                                                </td>

                                                <!-- ESTADO CIVIL -->
                                                <td>Estado Civil (*)</td>
                                                <td align="center">
                                                    <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="estadoCivil" 
                                                            style="width:270px;"
                                                            >
                                                        {foreach from=$arrEstadoCivil key=seqEstadoCivil item=txtEstadoCivil}
                                                            <option value="{$seqEstadoCivil}">{$txtEstadoCivil}</option>
                                                        {/foreach}
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- FECHA DE NACIMIENTO -->
                                                <td>Fch. Nacimiento (*)</td>
                                                <td style="padding-left:4px">
                                                    <input	type="text" 
                                                           id="fechaNac"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                           style="width:80px" 
                                                           maxlength="10"
                                                           /> (aaaa/mm/dd)
                                                </td>

                                                <!-- CONDICION ESPECIAL -->
                                                <td>Cond. Especial 1</td>
                                                <td align="center">
                                                    <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="condicionEspecial" 
                                                            style="width:270px;"
                                                            >
                                                        <option value="6">6 - Ninguno</option>
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
                                                            style="width:200px;"
                                                            >
                                                        <option value="1"> NINGUNA </option>
                                                        {foreach from=$arrCondicionEtnica key=seqEtnia item=txtEtnia}
                                                            <option value="{$seqEtnia}">{$txtEtnia}</option>
                                                        {/foreach}
                                                    </select>
                                                </td>

                                                <!-- CONDICION ESPECIAL 2 -->
                                                <td>Cond. Especial 2</td>
                                                <td align="center">
                                                    <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="condicionEspecial2" 
                                                            style="width:270px;"
                                                            >	
                                                        <option value="6">6 - Ninguno</option>
                                                        {foreach from=$arrCondicionEspecial key=seqCondicionEspecial item=txtCondicionEspecial}
                                                            <option value="{$seqCondicionEspecial}">{$txtCondicionEspecial}</option>
                                                        {/foreach}
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- SEXO -->
                                                <td>Sexo (*)</td>
                                                <td align="center">
                                                    <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="sexo" 
                                                            style="width:200px;"
                                                            >
                                                        {foreach from=$arrSexo key=seqSexo item=txtSexo}
                                                            <option value="{$seqSexo}">{$txtSexo}</option>
                                                        {/foreach}
                                                    </select>
                                                </td>

                                                <!-- CONDICION ESPECIAL 3 -->
                                                <td>Cond. Especial 3</td>
                                                <td align="center">
                                                    <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="condicionEspecial3" 
                                                            style="width:270px;"
                                                            >	
                                                        <option value="6">6 - Ninguno</option>
                                                        {foreach from=$arrCondicionEspecial key=seqCondicionEspecial item=txtCondicionEspecial}
                                                            <option value="{$seqCondicionEspecial}">{$txtCondicionEspecial}</option>
                                                        {/foreach}
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- LGTB -->
                                                <td>LGTB</td>
                                                <td align="center">
                                                    <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="lgtb" 
                                                            style="width:200px;"
                                                            >
                                                        <option value="0">No</option>
                                                        <option value="1">Si</option>
                                                    </select>
                                                </td>

                                                <!-- CAJA DE COMPENSACION -->
                                                <td>C.Compensación</td>
                                                <td align="center">
                                                    <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="cajaCompensacion" 
                                                            style="width:270px;"
                                                            >
                                                        <option value="1">No Afiliado</option>
                                                        {foreach from=$arrCajaCompensacion key=seqCajaCompensacion item=txtCajaCompensacion}
                                                            <option value="{$seqCajaCompensacion}">{$txtCajaCompensacion}</option>
                                                        {/foreach}
                                                    </select>
                                                </td>
                                            </tr>
                                            <TR>
                                                <!-- NIVEL EDUCATIVO -->
                                                <TD>Nivel Educativo</TD>
                                                <TD align="center">
                                                    <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="nivelEducativo" 
                                                            style="width:200px;"
                                                            >
                                                        {foreach from=$arrNivelEducativo key=seqNivelEducativo item=txtNivelEducativo}
                                                            <option value="{$seqNivelEducativo}">{$txtNivelEducativo}</option>
                                                        {/foreach}
                                                    </select>
                                                </TD>

                                                <!-- AFILIADO SISTEMA DE SALUD -->
                                                <td>Sistema Salud</td>
                                                <td align="center">
                                                    <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="salud" 
                                                            style="width:270px;"
                                                            >
                                                        {foreach from=$arrSalud key=seqSalud item=txtSalud}
                                                            <option value="{$seqSalud}">{$txtSalud}</option>
                                                        {/foreach}
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- INGRESOS MENSUALES -->
                                                <td>Ingresos (*)</td>
                                                <td align="center">
                                                    <input	type="text" 
                                                           id="ingresos" 
                                                           value="{$objCiudadano->txtNombre2}" 
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="soloNumeros(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
                                                           style="width:200px;"
                                                           />
                                                </td>

                                                <!-- BENEFICIARIO DE ALGUN SUBSIDIO -->
                                                <td>Beneficiario</td>
                                                <td align="center">
                                                    <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="beneficiario" 
                                                            style="width:270px;"
                                                            >
                                                        <option value="0">No</option>
                                                        <option value="1">Si</option>
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
                                                            style="width:598px;"
                                                            >
                                                        <option value="20">20 - NINGUNO</option>
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
                                    </td></tr>
                            </table>

                            <!-- IMPRIMIR LOS MIEMBROS DE HOGAR CON TODOS LOS DATOS -->
                            <div id="datosHogar">
                                {assign var=valTotal value=0}
                                {foreach from=$objFormulario->arrCiudadano item=objCiudadano key=seqCiudadano}

                                    {assign var=tipoDocumento      value=$objCiudadano->seqTipoDocumento}
                                    {assign var=parentesco         value=$objCiudadano->seqParentesco}
                                    {assign var=condicionEspecial  value=$objCiudadano->seqCondicionEspecial}
                                    {assign var=condicionEspecial2 value=$objCiudadano->seqCondicionEspecial2}
                                    {assign var=condicionEspecial3 value=$objCiudadano->seqCondicionEspecial3}
                                    {assign var=codicionEtnica     value=$objCiudadano->seqEtnia}
                                    {assign var=estadoCivil        value=$objCiudadano->seqEstadoCivil}
                                    {assign var=ocupacion          value=$objCiudadano->seqOcupacion}
                                    {assign var=sexo               value=$objCiudadano->seqSexo}
                                    {assign var=cajaCompensacion   value=$objCiudadano->seqCajaCompensacion}
                                    {assign var=nivelEducativo     value=$objCiudadano->seqNivelEducativo}
                                    {assign var=salud              value=$objCiudadano->seqSalud}

                                    {math equation="x + y" x=$valTotal y=$objCiudadano->valIngresos assign=valTotal}

                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" id="{$objCiudadano->numDocumento}">
                                        <tr onMouseOver="this.style.background = '#E4E4E4';"
                                            onMouseOut="this.style.background = '#F9F9F9';"
                                            style="cursor:pointer"
                                            >
                                            <td align="center" width="18px" height="22px">
                                                <div	style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999;" 
                                                     onClick="desplegarDetallesMiembroHogar('{$objCiudadano->numDocumento}')"
                                                     onMouseOver="this.style.backgroundColor = '#ADD8E6';"
                                                     onMouseOut="this.style.backgroundColor = '#F9F9F9';"
                                                     id="masDetalles{$objCiudadano->numDocumento}"
                                                     >+</div>  
                                            </td>
                                            <td width="262px" style="padding-left:5px;">
                                                {$objCiudadano->txtNombre1} {$objCiudadano->txtNombre2} 
                                                {$objCiudadano->txtApellido1} {$objCiudadano->txtApellido2}
                                            </td>
                                            <td width="120px">
                                                {$arrAbreviacionesTipoDocumento.$tipoDocumento}  
                                                {$objCiudadano->numDocumento|number_format:'0':',':'.'}
                                            </td>
                                            <td width="190px">
                                                {$arrParentescoNombres.$parentesco}
                                            </td>
                                            <td align="right" style="padding-right:7px">
                                                $ {$objCiudadano->valIngresos|number_format:0:',':'.'}
                                            </td>
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
                                        <input type="hidden" id="{$objCiudadano->numDocumento}-bolLgtb" name="hogar[{$objCiudadano->numDocumento}][bolLgtb]" value="{$objCiudadano->bolLgtb}">
                                        <input type="hidden" id="{$objCiudadano->numDocumento}-seqCajaCompensacion" name="hogar[{$objCiudadano->numDocumento}][seqCajaCompensacion]" value="{$objCiudadano->seqCajaCompensacion}">
                                        <input type="hidden" id="{$objCiudadano->numDocumento}-seqNivelEducativo" name="hogar[{$objCiudadano->numDocumento}][seqNivelEducativo]" value="{$objCiudadano->seqNivelEducativo}">
                                        <input type="hidden" id="{$objCiudadano->numDocumento}-seqSalud" name="hogar[{$objCiudadano->numDocumento}][seqSalud]" value="{$objCiudadano->seqSalud}">
                                        <input type="hidden" id="{$objCiudadano->numDocumento}-bolBeneficiario" name="hogar[{$objCiudadano->numDocumento}][bolBeneficiario]" value="{$objCiudadano->bolBeneficiario}">

                                    </table>
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="display:none" id="detalles{$objCiudadano->numDocumento}">
                                        <tr>
                                            <td colspan="6">
                                                <table cellpadding="2" cellspacing="0" border="0" width="100%" style="border: 1px solid #999999;">
                                                    <tr>
                                                        <td><b>Sexo:</b> {$arrSexo.$sexo}</td>
                                                        <td><b>LGTB:</b> {if $objCiudadano->bolLgtb == 1}Si {else} No {/if}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Estado Civil:</b> {$arrEstadoCivilNombres.$estadoCivil|lower|ucwords}</td>
                                                        <td><b>Condición Étnica:</b> {$arrCondicionEtnicaNombres.$codicionEtnica|lower|ucwords}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Fecha de Nacimiento:</b> {$objCiudadano->fchNacimiento}</td>
                                                        <td><b>Condición Especial 1:</b> {$arrCondicionEspecialNombres.$condicionEspecial|lower|ucwords}</td>

                                                    </tr>
                                                    <tr>
                                                        <td><b>Nivel Educativo:</b> {$arrNivelEducativo.$nivelEducativo}</td>
                                                        <td><b>Condición Especial 2:</b> {$arrCondicionEspecialNombres.$condicionEspecial2|lower|ucwords}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Caja Compensación:</b> {$arrCajaCompensacionNombres.$cajaCompensacion|lower|ucwords}</td>
                                                        <td><b>Condición Especial 3:</b> {$arrCondicionEspecialNombres.$condicionEspecial3|lower|ucwords}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Sistema de Salud:</b> {$arrSalud.$salud|lower|ucwords} </td>
                                                        <td><b>Beneficiario de Subsidios:</b> {if $objCiudadano->bolBeneficiario == 1}Si {else} No {/if}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><b>Ocupación:</b> {$arrOcupacionNombres.$ocupacion|lower|ucwords}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                {/foreach}
                            </div>

                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr bgcolor="#CCCCCC">
                                    <td align="center" height="20px" width="584px">
                                        <b>Total Ingresos Hogar</b>
                                    </td>
                                    <td style="padding-right:7px" align="right" id="valTotalMostrar">
                                        {if $objFormulario->valIngresoHogar != 0 && $objFormularioIngreso->valIngresoHogar != ""}
                                            $ {$valTotal|number_format:0:',':'.'}
                                        {else}
                                            $ {$objFormulario->valIngresoHogar|number_format:0:',':'.'}
                                        {/if}
                                    </td>
                                    <td width="18px">&nbsp;</td>
                                    {if $objFormulario->valIngresoHogar != 0 && $objFormularioIngreso->valIngresoHogar != ""}
                                    <input type="hidden" name="valIngresoHogar" id="valIngresoHogar" value="{$valTotal}">
                                {else}
                                    <input type="hidden" name="valIngresoHogar" id="valIngresoHogar" value="{$objFormulario->valIngresoHogar}">
                                {/if}
                                <td width="18px">&nbsp;</td>
                                </tr>
                            </table>	

                        </div>

                        <!-- DATOS DEL HOGAR -->				    
                        <div id="hogar" style="height:338px;"><p>
                            <table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF"  style="border: 1px dotted #999999; padding:5px">
                                <tr>
                                    <!-- VIVIENDA ACTUAL -->
                                    <td width="150px">Vivienda Actual </td>
                                    <td align="center" width="210px">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="seqVivienda" 
                                                id="seqVivienda" 
                                                style="width:200px;"
                                                >
                                            {foreach from=$arrVivienda key=seqVivienda item=txtVivienda}
                                                <option value="{$seqVivienda}"
                                                        {if $objFormulario->seqVivienda == $seqVivienda} selected {/if}
                                                        >{$txtVivienda}</option>
                                            {/foreach}
                                        </select>
                                    </td>

                                    <!-- SI PAGA ARRIENDO, CUANTO PAGA -->
                                    <TD>Valor del Arriendo</TD>
                                    <td align="center" width="210px">
                                        $ <input	type="text" 
                                                 name="valArriendo" 
                                                 id="valArriendo" 
                                                 value="{$objFormulario->valArriendo}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';" 
                                                 style="width:190px;" />
                                    </td>
                                </tr>	
                                <tr> 
                                    <!-- DIRECCION DE RESIDENCIA -->
                                    <TD>Dirección (*)</TD>
                                    <td colspan="3" align="center">
                                        <input	type="text" 
                                               name="txtDireccion" 
                                               id="txtDireccion" 
                                               value="{$objFormulario->txtDireccion}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:558px;"
                                               />
                                    </td>
                                </tr>
                                <tr>
                                    <!-- LOCALIDAD -->
                                    <td>Localidad </td>
                                    <td align="center">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="seqLocalidad" 
                                                id="seqLocalidad" 
                                                style="width:200px;"
                                                >
                                            {foreach from=$arrLocalidad key=seqLocalidad item=txtLocalidad}
                                                <option value="{$seqLocalidad}"
                                                        {if $objFormulario->seqLocalidad == $seqLocalidad} selected {/if}
                                                        >{$txtLocalidad}</option>
                                            {/foreach}
                                        </select>
                                    </td>

                                    <!-- BARRIO -->
                                    <td>Barrio </td>
                                    <td align="center">
                                        <input	type="text" 
                                               name="txtBarrio" 
                                               id="txtBarrio" 
                                               value="{$objFormulario->txtBarrio}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:200px;"
                                               />
                                    </td>
                                </tr>

                                <tr> <!-- TELEFONO 1 TELEFONO 2 Y CELULAR -->
                                    <td>Teléfonos Fijos (*)</td>
                                    <td align="center">
                                        <input	type="text" 
                                               name="numTelefono1" 
                                               id="numTelefono1" 
                                               value="{$objFormulario->numTelefono1}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="soloNumeros(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:90px;" 
                                               /> ó
                                        <input	type="text" 
                                               name="numTelefono2" 
                                               id="numTelefono2" 
                                               value="{$objFormulario->numTelefono2}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="soloNumeros(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:95px;" 
                                               />
                                    </td>
                                    <td>Teléfono Celular</td>
                                    <td align="center">
                                        <input	type="text" 
                                               name="numCelular" 
                                               id="numCelular" 
                                               value="{$objFormulario->numCelular}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="soloNumeros(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:200px;" 
                                               />
                                    </td>
                                </tr>
                                <tr> <!-- CORREO ELECTRONICO -->
                                    <TD>Correo Electr&oacute;nico</TD>
                                    <td colspan="3" align="center">
                                        <input	type="text" 
                                               name="txtCorreo" 
                                               id="txtCorreo" 
                                               value="{$objFormulario->txtCorreo}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:558px;"
                                               class="inputLogin"
                                               />
                                    </td>
                                </tr>
                                <tr>
                                    <!-- SISBEN -->
                                    <td>Sisben </td>
                                    <td align="center">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="seqSisben" 
                                                id="seqSisben" 
                                                style="width:200px;"
                                                >
                                            {foreach from=$arrSisben key=seqSisben item=txtSisben}
                                                <option value="{$seqSisben}"
                                                        {if $objFormulario->seqSisben == $seqSisben} selected {/if}
                                                        >{$txtSisben}</option>
                                            {/foreach}
                                        </select>
                                    </td>

                                    <!-- DESPLAZAMIENTO FORZADO -->
                                    <td>Desplazamiento forzado </td>
                                    <td align="center">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolDesplazado" 
                                                id="bolDesplazado" 
                                                style="width:200px;"
                                                >
                                            <option value="0" {if $objFormulario->bolDesplazado != 1} selected {/if} >No</option>
                                            <option value="1" {if $objFormulario->bolDesplazado == 1} selected {/if} >Si</option>
                                        </select>
                                    </td>		
                                </tr>		        	
                            </table>
                            <br>
                            <!-- TABLA RED DE SERVICIOS -->
                            <table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF" style="border: 1px dotted #999999; padding:5px">
                                <tr>
                                    <!-- INTEGRACION SOCIAL -->
                                    <td width="110px">Integraci&oacute;n Social</td>
                                    <td style="padding-left:10px;">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolIntegracionSocial" 
                                                id="bolIntegracionSocial" 
                                                style="width:50px;"
                                                >
                                            <option value="0" {if $objFormulario->bolIntegracionSocial != 1 } selected {/if} >No</option>
                                            <option value="1" {if $objFormulario->bolIntegracionSocial == 1 } selected {/if} >Si</option>
                                        </select>
                                    </td>	

                                    <!-- SEC SALUD -->
                                    <td width="110px">Sec. Salud</td>
                                    <td style="padding-left:10px;">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolSecSalud" 
                                                id="bolSecSalud" 
                                                style="width:50px;"
                                                >
                                            <option value="0" {if $objFormulario->bolSecSalud != 1 } selected {/if} >No</option>
                                            <option value="1" {if $objFormulario->bolSecSalud == 1 } selected {/if} >Si</option>
                                        </select>
                                    </td>

                                    <!-- SEC EDUCACION -->
                                    <td width="110px">Sec. Educacion</td>
                                    <td style="padding-left:10px;">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolSecEducacion" 
                                                id="bolSecEducacion" 
                                                style="width:50px;"
                                                >
                                            <option value="0" {if $objFormulario->bolSecEducacion != 1 } selected {/if} >No</option>
                                            <option value="1" {if $objFormulario->bolSecEducacion == 1 } selected {/if} >Si</option>
                                        </select>
                                    </td>

                                    <!-- IPES -->
                                    <td width="110px">IPES</td>
                                    <td style="padding-left:10px;">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolIpes" 
                                                id="bolIpes" 
                                                style="width:50px;"
                                                >
                                            <option value="0" {if $objFormulario->bolIpes != 1 } selected {/if} >No</option>
                                            <option value="1" {if $objFormulario->bolIpes == 1 } selected {/if} >Si</option>
                                        </select>
                                    </td>
                                    {if $claFormulario->seqPlanGobierno == 3}
                                        <td width="200px" align="left">Reconocimiento Fuerza Pública&nbsp;&nbsp;
                                            <select	onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                    name="bolReconocimientoFP"
                                                    id="bolReconocimientoFP"
                                                    style="width:40%;"
                                                    >
                                                <option value="0" {if $claFormulario->bolReconocimientoFP != 1} selected {/if} >No</option>
                                                <option value="1" {if $claFormulario->bolReconocimientoFP == 1} selected {/if} >Si</option>
                                            </select>
                                        </td>
                                    {/if}
                                </tr>
                                <tr>
                                    <!-- OTRO -->
                                    <TD>Otro</TD>
                                    <td colspan="8" style="padding-left:10px">
                                        <input	type="text" 
                                               name="txtOtro" 
                                               id="txtOtro" 
                                               value="{$objFormulario->txtOtro}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:99%;" 
                                               />
                                    </td>
                                </tr>
                            </table>
                            </p></div>

                        <!-- MODALIDAD Y VIVIENDA -->				        
                        <div id="modalidad" style="height:338px;"><p>
                            <table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">

                                <tr>
                                    <!-- MODALIDAD DEL SUBSIDIO -->
                                    <td>Modalidad Solución</td>
                                    <td width="240px">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                onChange="cargarContenido('tdTipoSolucion', './contenidos/subsidios/tipoSolucion.php', 'postulacion=1&modalidad=' + this.options[ this.selectedIndex ].value, true);
                                                        cargarContenido('tdProyecto', './contenidos/subsidios/proyectos.php', 'modalidad=' + this.options[ this.selectedIndex ].value, false);
                                                        document.getElementById('valAspiraSubsidio').value = 0;"
                                                name="seqModalidad" 
                                                id="seqModalidad" 
                                                style="width:230px;"
                                                >
                                            {foreach from=$arrModalidad key=seqModalidad item=txtModalidad}
                                                <option value="{$seqModalidad}"
                                                        {if $objFormulario->seqModalidad == $seqModalidad} selected {/if}
                                                        >{$txtModalidad}</option>
                                            {/foreach}
                                        </select>
                                    </td>

                                    <!-- TIPO DE SOLUCION -->
                                    <td>Tipo Solución</td>
                                    <td id="tdTipoSolucion" align="center" width="210px">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                onChange="asignarValorSubsidio(this);"
                                                name="seqSolucion" 
                                                id="seqSolucion" 
                                                style="width:270px;"
                                                >	
                                            {if $objFormulario->seqModalidad == "" || $objFormulario->seqModalidad == 1}
                                                {assign value=1 var=modalidad}
                                            {else}
                                                {assign value=$objFormulario->seqModalidad var=modalidad}
                                            {/if}

                                            <option value="1">NINGUNA</option>
                                            {foreach from=$arrSolucion.$modalidad key=seqSolucion item=txtSolucion}
                                                <option value="{$seqSolucion}"
                                                        {if $objFormulario->seqSolucion == $seqSolucion} selected {/if}
                                                        >{$txtSolucion}</option>
                                            {/foreach}
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- PROYECTO -->
                                    <td>Proyecto</td>
                                    <td id="tdProyecto" colspan="3" align="center">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="seqProyecto" 
                                                id="seqProyecto" 
                                                style="width:100%"
                                                ><option value='0'>NINGUNO</option>
                                            {if $objFormulario->seqModalidad == "" }
                                                {assign value=1 var=modalidad}
                                            {else}
                                                {assign value=$objFormulario->seqModalidad var=modalidad}
                                            {/if}
                                            {foreach from=$arrProyecto.$modalidad key=seqProyecto item=txtProyecto}
                                                <option value="{$seqProyecto}"
                                                        {if $objFormulario->seqProyecto == $seqProyecto} selected {/if}
                                                        >{$txtProyecto}</option>
                                            {/foreach}
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- DIRECCION SOLUCION-->
                                    <TD>Dirección Solución</TD>
                                    <td colspan="3" align="center">
                                        <input	type="text" 
                                               name="txtDireccionSolucion" 
                                               id="txtDireccionSolucion" 
                                               value="{$objFormulario->txtDireccionSolucion}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:100%"
                                               />
                                    </td>
                                </tr>
                                <tr>
                                    <!-- NUMERO DE MATRICULA INMOBILIARIA -->
                                    <TD>Matricula Inmobiliaria</TD>
                                    <td>
                                        <input	type="text" 
                                               name="txtMatriculaInmobiliaria" 
                                               id="txtMatriculaInmobiliaria" 
                                               value="{$objFormulario->txtMatriculaInmobiliaria}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:230px;"
                                               />
                                    </td>

                                    <!-- CHIP -->
                                    <TD>CHIP</TD>
                                    <td>
                                        <input	type="text" 
                                               name="txtChip" 
                                               id="txtChip" 
                                               value="{$objFormulario->txtChip}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:270px;"
                                               />
                                    </td>
                                </tr>
                                <tr>
                                    <!-- TIENE PROMESA DE COMPRA VENTA FIRMADA -->
                                    <td colspan="2">¿ Tiene una promesa de compra - venta firmada ?</td>
                                    <td colspan="2">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolPromesaFirmada" 
                                                id="bolPromesaFirmada" 
                                                style="width:100%;"
                                                >
                                            <option value="0" {if $objFormulario->bolPromesaFirmada != 1} selected {/if}>No</option>
                                            <option value="1" {if $objFormulario->bolPromesaFirmada == 1} selected {/if}>Si</option>
                                        </select>
                                    </td>				        			
                                </tr>
                                <tr>
                                    <!-- TIENE IDENTIFICADA UNA SOLUCION DE VIVIENDA VIABILIZADA POR LA SDHT -->
                                    <td colspan="2">¿ Tiene Idetificada una solución Viabilizada por la SDHT ?</td>
                                    <td colspan="2">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolIdentificada" 
                                                id="bolIdentificada" 
                                                style="width:100%;"
                                                >
                                            <option value="0" {if $objFormulario->bolIdentificada != 1} selected {/if}>No</option>
                                            <option value="1" {if $objFormulario->bolIdentificada == 1} selected {/if}>Si</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- PERTENECE A UN PLAN DE VIVIENDA VIABILIZADA POR LA SDHT -->
                                    <td colspan="2">Pertenece a un Plan de Vivienda Viabilizada por la SDHT</td>
                                    <td colspan="2">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolViabilizada" 
                                                id="bolViabilizada" 
                                                style="width:100%;"
                                                >
                                            <option value="0" {if $objFormulario->bolViabilizada != 1} selected {/if}>No</option>
                                            <option value="1" {if $objFormulario->bolViabilizada == 1} selected {/if}>Si</option>
                                        </select>
                                    </td>										
                                </tr>

                            </table>
                            <table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
                                <tr>	
                                    <!-- VALOR DEL PRESUPUESTO -->
                                    <TD width="120px">Presupuesto</TD>
                                    <td width="120px">
                                        $ <input	type="text" 
                                                 name="valPresupuesto" 
                                                 id="valPresupuesto" 
                                                 value="{$objFormulario->valPresupuesto}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotal();" 
                                                 style="width:100px;"
                                                 />
                                    </td>

                                    <!-- VALOR DEL AVALUO  -->
                                    <TD>Aval&uacute;o</TD>
                                    <td  width="120px">
                                        $ <input	type="text" 
                                                 name="valAvaluo" 
                                                 id="valAvaluo" 
                                                 value="{$objFormulario->valAvaluo}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotal();" 
                                                 style="width:100px;"
                                                 />
                                    </td>

                                    <!-- VALOR TOTAL  -->
                                    <TD>Total</TD>
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
                            </p></div>

                        <!-- INFORMACION FINANCIERA -->				       
                        <div id="financiera" style="height:338px;"><p>

                            <table cellpadding="1" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">

                                <tr>
                                    <!-- TIENE AHORRO -->
                                    <TD>Tiene Ahorro</TD>
                                    <td align="center">
                                        $ <input	type="text" 
                                                 name="valSaldoCuentaAhorro" 
                                                 id="valSaldoCuentaAhorro" 
                                                 value="{$objFormulario->valSaldoCuentaAhorro}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();" 
                                                 style="width:100px;" 
                                                 />
                                    </td>

                                    <!-- BANCO DONDE TIENE EL AHORRO -->
                                    <TD>D&oacute;nde</TD>
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
                                    {if $objFormulario->fchAperturaCuentaAhorro == '0000-00-00' }
                                        {assign var=fchAperturaCuentaAhorro value=""}
                                    {else}
                                        {assign var=fchAperturaCuentaAhorro value=$objFormulario->fchAperturaCuentaAhorro}
                                    {/if}
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Fecha Apertura</td>
                                    <td style="padding-left:11px;">
                                        <input	type="text" 
                                               name="fchAperturaCuentaAhorro" 
                                               id="fchAperturaCuentaAhorro" 
                                               value="{$fchAperturaCuentaAhorro}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"  
                                               style="width:100px;"
                                               maxlength="10" 
                                               /> (aaaa/mm/dd) 
                                    </td>
                                </tr>

                                <tr>
                                    <!-- TIENE OTRO AHORRO -->
                                    <TD>Otro Ahorro</TD>
                                    <td align="center">
                                        $ <input	type="text" 
                                                 name="valSaldoCuentaAhorro2" 
                                                 id="valSaldoCuentaAhorro2" 
                                                 value="{$objFormulario->valSaldoCuentaAhorro2}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();" 
                                                 style="width:100px;" 
                                                 />
                                    </td>

                                    <!-- BANCO DONDE TIENE EL AHORRO -->
                                    <TD>D&oacute;nde</TD>
                                    <td align="center" width="320px">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
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
                                    {if $objFormulario->fchAperturaCuentaAhorro2 == '0000-00-00' }
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
                                               /> (aaaa/mm/dd) 
                                    </td>
                                </tr>


                                <tr>
                                    <!-- SUBSIDIO NACIONAL -->
                                    <td>Subsidio Nacional</td>
                                    <td align="center">
                                        $ <input	type="text" 
                                                 name="valSubsidioNacional" 
                                                 id="valSubsidioNacional" 
                                                 value="{$objFormulario->valSubsidioNacional}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"  
                                                 style="width:100px;" 
                                                 />
                                    </td>
                                    <td>Soporte (No.Carta)</td>
                                    <td align="center">
                                        <input	type="text" 
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
                                    <td>Aporte Lote o Terreno</td>
                                    <td align="center">
                                        $ <input	type="text" 
                                                 name="valAporteLote" 
                                                 id="valAporteLote" 
                                                 value="{$objFormulario->valAporteLote}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"  
                                                 style="width:100px;" 
                                                 />
                                    </td>

                                    <!-- SOPORTE APORTE LOTE -->
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input	type="text" 
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
                                    <td align="center">
                                        $ <input	type="text" 
                                                 name="valSaldoCesantias" 
                                                 id="valSaldoCesantias" 
                                                 value="{$objFormulario->valSaldoCesantias}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"  
                                                 style="width:100px;" 
                                                 />
                                    </td>

                                    <!-- SOPORTE CESANTIAS -->
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input	type="text" 
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
                                    <td align="center">
                                        $ <input	type="text" 
                                                 name="valAporteAvanceObra" 
                                                 id="valAporteAvanceObra" 
                                                 value="{$objFormulario->valAporteAvanceObra}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"  
                                                 style="width:100px;" 
                                                 />
                                    </td>

                                    <!-- SOPORTE AVANCE OBRA -->
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input	type="text" 
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
                                    <TD>Tiene Credito</TD>
                                    <td align="center">
                                        $ <input	type="text" 
                                                 name="valCredito" 
                                                 id="valCredito" 
                                                 value="{$objFormulario->valCredito}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"  
                                                 style="width:100px;" 
                                                 />
                                    </td>

                                    <!-- BANCO DONDE TIENE EL CREDITO -->
                                    <TD>D&oacute;nde</TD>
                                    <td align="center">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
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
                                        <input	type="text" 
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
                                    {if $objFormulario->fchAprobacionCredito == '0000-00-00' }
                                        {assign var=fchAprobacionCredito value=""}
                                    {else}
                                        {assign var=fchAprobacionCredito value=$objFormulario->fchAprobacionCredito}
                                    {/if}

                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Fecha Vencimiento</td>
                                    <td style="padding-left:11px;">
                                        <input	type="text" 
                                               name="fchAprobacionCredito" 
                                               id="fchAprobacionCredito" 
                                               value="{$fchAprobacionCredito}" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"  
                                               style="width:100px;"
                                               maxlength="10" 
                                               /> (aaaa/mm/dd) 
                                    </td>
                                </tr>				
                                <tr>
                                    <!-- APORTE AVANCE DE OBRA -->
                                    <td>Aporte Materiales</td>
                                    <td align="center">
                                        $ <input	type="text" 
                                                 name="valAporteMateriales" 
                                                 id="valAporteMateriales" 
                                                 value="{$objFormulario->valAporteMateriales}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"  
                                                 style="width:100px;" 
                                                 />
                                    </td>

                                    <!-- SOPORTE AVANCE OBRA -->
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input	type="text" 
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
                                    <TD>Tiene Donaci&oacute;n</TD>
                                    <td align="center">
                                        $ <input	type="text" 
                                                 name="valDonacion" 
                                                 id="valDonacion" 
                                                 value="{$objFormulario->valDonacion}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"  
                                                 style="width:100px;" 
                                                 />
                                    </td>

                                    <!-- DE DONDE PROVIENE LA DONACION -->
                                    <TD>Entidad Donante</TD>
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
                                        <input	type="text" 
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

                                    {if $objFormulario->valAspiraSubsidio == 0}
                                        {assign var=valSubsidio value=$arrValorSubsidio.$seqModalidad.$seqSolucion}
                                    {else}
                                        {assign var=valSubsidio value=$objFormulario->valAspiraSubsidio}
                                    {/if}

                                    <!-- VALOR AL QUE ASPIRA DEL SUBSIDIO -->
                                    <td class="tituloTabla" height="25px" align="top">Valor Subsidio Aspira</td>
                                    <td align="right" style="padding-right:10px" id="tdValSubsidio"  height="25px" align="top">
                                        $ <input	type="text" 
                                                 name="valAspiraSubsidio"
                                                 id="valAspiraSubsidio" 
                                                 value="{$valSubsidio}" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"  
                                                 style="width:100px;" 
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
                <p><div id="contenidoBusqueda">
                    {include file="seguimiento/buscarSeguimiento.tpl"}
                </div></p>
            </div>

            <!-- ACTOS ADMINISTRATIVOS -->	        
            <div id="aad" style="height:401px;"><p>
                    Actos Administrativos
                </p></div>
        </div>
    </div>
    <input type="hidden" id="seqFormularioEditar" name="seqFormularioEditar" value="{$seqFormulario}">
    <input type="hidden" name="numAdultosNucleo" value="{$objFormulario->numAdultosNucleo}">
    <input type="hidden" name="numNinosNucleo" value="{$objFormulario->numNinosNucleo}">
    <input type="hidden" name="txtArchivo" value="./contenidos/subsidios/salvarPostulacion.php">
    <input type="hidden" name="txtCiudadanoAtendido" value="{$txtCiudadanoAtendido}">
    <input type="hidden" name="numDocumentoAtendido" value="{$numDocumento}">

</form>

<div id="postulacionTabView"></div>
