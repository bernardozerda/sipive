
<form name="frmInscripcion" id="frmInscripcion" onSubmit="return false;" autocomplete=off>

    <!-- CODGIO PARA EL POP UP DE SEGUIMIENTO -->
    {include file='subsidios/pedirSeguimiento.tpl'}

    <!-- BOTON PARA SALVAR EL FORMULARIO -->
    <table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#E4E4E4">
        <tr> 
            <td height="25px" valign="middle" align="right" style="padding-right:10px; padding-left:10px;" bgcolor="#E4E4E4" colspan="4">
                {if $smarty.session.privilegios.crear == 1 || $smarty.session.privilegios.editar == 1}
                    <input type="submit" 
                           name="salvar" 
                           id="salvar" 
                           value="Salvar Inscripci&oacute;n" 
                           onClick="preguntarGrupoFamiliar()"
                           />
                {/if}
                <input type="hidden" 
                       id="seqFormulario" 
                       name="seqFormulario" 
                       value="{$seqFormulario}"
                       >
                <input type="hidden" 
                       id="txtArchivo" 
                       name="txtArchivo" 
                       value="./contenidos/subsidios/salvarInscripcion.php"
                       >
            </td>
        </tr>
    </table>

    <!-- INICIO TAB VIEW -->
    <div id="inscripcion" class="yui-navset" style="width:100%; text-align:left;">
        <ul class="yui-nav" style="background:#E4E4E4;">
            <li class="selected"><a href="#frm"><em>Formulario</em></a></li>
            <li><a href="#seg"><em>Seguimiento</em></a></li>
            <li><a href="#aad"><em>Actos Administrativos</em></a></li>
        </ul>            
        <div class="yui-content">

            <!-- FORMULARIO -->	    
            <div id="frm" style="height:490px;">

                <!-- ESTADO DEL PROCESO -->
                <table cellspacing="0" cellpadding="2" border="0" width="100%" height="25px">
                    <tr bgcolor="#E4E4E4"> 
                        <td width="140px"><b>Estado del proceso</b></td>
                        <td width="280px">
                            {if intval( $objFormulario->seqEstadoProceso ) == 0} 
                                {assign var=seqEstadoProceso value="36"}
                            {else} 
                                {assign var=seqEstadoProceso value=$objFormulario->seqEstadoProceso}
                            {/if}
                            {$arrEstado.$seqEstadoProceso} 
                            <input type="hidden" name="seqEstadoProceso" id="seqEstadoProceso" value="{$seqEstadoProceso}">
                        </td>
                        <td width="140px"><b>Fecha de Inscripción</b></td>
                        <td><input type='hidden' id='fchInscripcion' name='fchInscripcion' value="{$objFormulario->fchInscripcion}">{$objFormulario->fchInscripcion}&nbsp;</td>
                    </tr>
                </table><br>
                <table cellspacing="0" cellpadding="2" border="0" width="100%">

                    <!-- TIPO DOCUMENTO Y NUMERO DE DOCUMENTO -->
                    <tr>    
                        <td width="150px">No. Documento</td>
                        <td>
                            <input type="text" 
                                   name="numDocumento" 
                                   id="numDocumento" 
                                   value="{$numDocumento}"
                                   onFocus="
                                           this.style.backgroundColor = '#ADD8E6';
                                           ponerPlaceholder('numTelefono1', 'Fijo 1');
                                           ponerPlaceholder('numTelefono2', 'Fijo 2');
                                           ponerPlaceholder('numCelular', 'Celular');
                                   " 
                                   onBlur="
                                           soloNumeros(this);
                                           this.style.backgroundColor = '#FFFFFF';
                                   "
                                   style="
                                   width:100px; 
                                   text-align: right;
                                   "

                                   />
                        </td>
                        <td width="120px">Tipo Documento</td>
                        <td width="210px">
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    name="seqTipoDocumento" 
                                    id="seqTipoDocumento" 
                                    style="width:260px;"
                                    >
                                {foreach from=$arrTipoDocumento key=seqTipoDocumento item=txtTipoDocumento}
                                    <option value="{$seqTipoDocumento}"
                                            {if $objCiudadano->seqTipoDocumento == $seqTipoDocumento} 
                                                selected 
                                            {/if}
                                            {if $seqTipoDocumento != 1 && $seqTipoDocumento != 2 && $seqTipoDocumento !=5}
                                                disabled
                                            {/if}   
                                            >
                                        {$txtTipoDocumento}
                                    </option>
                                {/foreach}
                            </select>            
                        </td>
                    </tr>

                    <!-- PRIMER APELLIDO Y SEGUNDO APELLIDO -->	
                    <tr> 
                        <td>Primer Apellido</td>
                        <td>
                            <input type="text" 
                                   name="txtApellido1" 
                                   id="txtApellido1" 
                                   value="{$objCiudadano->txtApellido1}" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloLetras(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:260px;"
                                   />
                        </td>
                        <td>Segundo Apellido</td>
                        <td>
                            <input type="text" 
                                   name="txtApellido2" 
                                   id="txtApellido2" 
                                   value="{$objCiudadano->txtApellido2}" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloLetras(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:260px;"
                                   />
                        </td>
                    </tr>	

                    <!-- PRIMER NOMBRE Y SEGUNDO NOMBRE -->
                    <tr> 
                        <td>Primer Nombre</td>
                        <td>
                            <input type="text" 
                                   name="txtNombre1" 
                                   id="txtNombre1" 
                                   value="{$objCiudadano->txtNombre1}" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloLetrasEspacio(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:260px;"
                                   />
                        </td>
                        <td>Segundo Nombre</td>
                        <td>
                            <input type="text" 
                                   name="txtNombre2" 
                                   id="txtNombre2" 
                                   value="{$objCiudadano->txtNombre2}" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloLetras(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:260px;"
                                   />
                        </td>
                    </tr>

                    <!-- SEXO  Y ESTADO CIVIL -->
                    <tr> 
                        <td>Sexo</td>
                        <td>
                            <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    name="seqSexo" 
                                    id="seqSexo" 
                                    style="width:260px;"
                                    >
                                {foreach from=$arrSexo key=seqSexo item=txtSexo}
                                    <option value="{$seqSexo}"
                                            {if $objCiudadano->seqSexo == $seqSexo} 
                                                selected 
                                            {/if}
                                            >
                                        {$txtSexo}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                        <td>Estado Civil </td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                    name="seqEstadoCivil" 
                                    id="seqEstadoCivil" 
                                    style="width:260px;"
                                    >
                                {foreach from=$arrEstadoCivil key=seqEstadoCivil item=txtEstadoCivil}
                                    <option value="{$seqEstadoCivil}"
                                            {if $objCiudadano->seqEstadoCivil == $seqEstadoCivil} 
                                                selected 
                                            {/if}
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

                    <!-- CONDICION ETNICA Y CONDICION ESPECIAL 1 -->
                    <tr>
                        <td>Condici&oacute;n Étnica</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="seqEtnia"
                                    name="seqEtnia" 
                                    style="width:260px;"
                                    >
                                <option value="1">NINGUNA</option>
                                {foreach from=$arrCondicionEtnica key=seqEtnia item=txtEtnia}
                                    <option value="{$seqEtnia}"
                                            {if $objCiudadano->seqEtnia == $seqEtnia} 
                                                selected 
                                            {/if}
                                            >
                                        {$txtEtnia}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                        <td>Condici&oacute;n Especial 1</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="seqCondicionEspecial"
                                    name="seqCondicionEspecial" 
                                    style="width:260px;"
                                    >
                                <option value="6">Ninguna</option>
                                {foreach from=$arrCondicionEspecial key=seqCondicionEspecial item=txtCondicionEspecial}
                                    <option value="{$seqCondicionEspecial}"
                                            {if $objCiudadano->seqCondicionEspecial == $seqCondicionEspecial} 
                                                selected 
                                            {/if}
                                            >
                                        {$txtCondicionEspecial}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>

                    <!-- CONDICION ESPECIAL 2 y CONDICION ESPECIAL 3 -->
                    <tr>
                        <td>Condici&oacute;n Especial 2</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="seqCondicionEspecial2"
                                    name="seqCondicionEspecial2" 
                                    style="width:260px;"
                                    >
                                <option value="6">Ninguna</option>
                                {foreach from=$arrCondicionEspecial key=seqCondicionEspecial item=txtCondicionEspecial}
                                    <option value="{$seqCondicionEspecial}"
                                            {if $objCiudadano->seqCondicionEspecial2 == $seqCondicionEspecial} 
                                                selected 
                                            {/if}
                                            >
                                        {$txtCondicionEspecial}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                        <td>Condici&oacute;n Especial 3</td>
                        <td>
                            <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="seqCondicionEspecial3"
                                    name="seqCondicionEspecial3" 
                                    style="width:260px;"
                                    >
                                <option value="6">Ninguna</option>
                                {foreach from=$arrCondicionEspecial key=seqCondicionEspecial item=txtCondicionEspecial}
                                    <option value="{$seqCondicionEspecial}"
                                            {if $objCiudadano->seqCondicionEspecial3 == $seqCondicionEspecial} 
                                                selected 
                                            {/if}
                                            >
                                        {$txtCondicionEspecial}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>

                    <!-- NIVEL EDUCATIVO y CORREO -->
                    <tr>
                        <td>Nivel Educativo</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    name="seqNivelEducativo"
                                    id="seqNivelEducativo" 
                                    style="width:260px;"
                                    >
                                <option value="1">Ninguno</option>
                                {foreach from=$arrNivelEducativo key=seqNivelEducativo item=txtNivelEducativo}
                                    <option value="{$seqNivelEducativo}"
                                            {if $objCiudadano->seqNivelEducativo == $seqNivelEducativo} 
                                                selected 
                                            {/if}
                                            >
                                        {$txtNivelEducativo}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                        <td>Correo Electr&oacute;nico</td>
                        <td>
                            <input type="text" 
                                   name="txtCorreo" 
                                   id="txtCorreo" 
                                   value="{$objFormulario->txtCorreo}" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="sinCaracteresEspeciales(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:260px;"
                                   class="inputLogin"
                                   />
                        </td>
                    </tr>

                    <!-- LGTBI Y HOGAR VICTIMA (DESPLAZADO) -->
                    <tr>
                        <td>Grupo LGTBI </td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="seqGrupoLgtbi" 
                                    name="seqGrupoLgtbi"
                                    onChange="cambiaLgtbi()"
                                    style="width:260px;"
                                    >
                                <option value="0">Ninguno</option>
                                {foreach from=$arrGrupoLgtbi key=seqGrupoLgtbi item=txtGrupoLgtbi}
                                    <option value="{$seqGrupoLgtbi}"
                                            {if $objCiudadano->seqGrupoLgtbi == $seqGrupoLgtbi} 
                                                selected 
                                            {/if}
                                            >
                                        {$txtGrupoLgtbi}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                        <td valign='top'>Hecho Victimizante</td>
                        <td valign='top'>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="seqTipoVictima" 
                                    name="seqTipoVictima"
                                    onchange="cambiaTipoSegunHecho();"
                                    style="width:260px;"
                                    >
                                <option value="0">Ninguno</option>
                                {foreach from=$arrTipoVictima key=seqTipoVictima item=txtTipoVictima}
                                    <option value="{$seqTipoVictima}"
                                            {if $objCiudadano->seqTipoVictima == $seqTipoVictima} 
                                                selected 
                                            {/if}
                                            >
                                        {$txtTipoVictima}
                                    </option>
                                {/foreach}
                            </select>

                        </td>
                    </tr>

                    <!-- GRUPO LGTBI Y HOGAR VICTIMA -->
                    <tr>
                        <td>LGTBI</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="bolLgtb" 
                                    name="bolLgtb"
                                    style="width:260px;"
                                    >
                                <option value="0" {if $objCiudadano->bolLgtb == 0} selected {/if} disabled>No</option>
                                <option value="1" {if $objCiudadano->bolLgtb == 1} selected {/if} disabled>Si</option>
                            </select>
                        </td>
                        <td>Hogar Victima</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="bolDesplazado" 
                                    name="bolDesplazado"
                                    style="width:260px;"
                                    >
                                <option value="0" {if intval( $objFormulario->bolDesplazado ) == 0} selected {/if} disabled>No</option>
                                <option value="1" {if intval( $objFormulario->bolDesplazado ) == 1} selected {/if} disabled>Si</option>
                            </select>
                        </td>
                    </tr>

                    <!-- OCUPACION -->          
                    <tr> 
                        <td>Ocupación</td>
                        <td colspan="3">
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="seqOcupacion"
                                    name="seqOcupacion" 
                                    style="width:100%;"
                                    >
                                <option value="20">NINGUNA</option>
                                {foreach from=$arrOcupacion key=seqOcupacion item=txtOcupacion}
                                    <option value="{$seqOcupacion}"
                                            {if $objCiudadano->seqOcupacion == $seqOcupacion} 
                                                selected 
                                            {/if}
                                            >
                                        {$txtOcupacion}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>

                    <!-- DIRECCION -->
                    <tr> 
                        <td><a href="#" id="Direccion" onClick="recogerDireccion('txtDireccion', 'objDireccionOculto');">Dirección </a></td>
                        <td colspan="3">
                            <input type="text" 
                                   name="txtDireccion" 
                                   id="txtDireccion" 
                                   value="{$objFormulario->txtDireccion}"
                                   style="width:100%;"
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="sinCaracteresEspeciales(this);
                                           this.style.backgroundColor = '#FFFFFF';"
                                   readonly
                                   />
                            <input type='hidden' id='seqTipoDireccion' name='seqTipoDireccion' value="0">
                            <div id="objDireccionOculto" style="display:none" />
                        </td>
                    </tr>

                    <!-- CIUDAD Y LOCALIDAD -->
                    <tr>
                        <td>Ciudad</td>
                        <td id="tdCiudad">
                            <select name="seqCiudad" 
                                    id="seqCiudad" 
                                    onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    style="width:260px;"
                                    onChange="cambiarCiudad(this);"
                                    > 
                                <option value="0">Seleccione</option>
                                {foreach from=$arrCiudad key=seqCiudad item=txtCiudad}
                                    <option value="{$seqCiudad}" 
                                            {if $objFormulario->seqCiudad == $seqCiudad} 
                                                selected 
                                            {/if}
                                            > 
                                        {$txtCiudad}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                        <td>Localidad </td>
                        <td id="tdlocalidad" align="left">
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

                    <!-- BARRIO -->
                    <tr id='lineaBarrio'>
                        <td>Barrio</td>
                        <td id='tdBarrio'>
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
                        <td id="tdupz" colspan="2">
                            <input type='hidden' readonly id='seqUpz' name='seqUpz' value="{$objFormulario->seqUpz}">
                        </td>
                    </tr>

                    <!-- TELEFONO 1 TELEFONO 2 Y CELULAR -->
                    <tr> 
                        <td>Telefonos</td>
                        <td colspan="3">
                            <input type="text" 
                                   name="numTelefono1" 
                                   id="numTelefono1" 
                                   value="{$objFormulario->numTelefono1}" 
                                   maxlength="7" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloNumeros(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:78px;" 
                                   placeholder="Fijo 1"
                                   >
                            <input type="text" 
                                   name="numTelefono2" 
                                   id="numTelefono2" 
                                   value="{$objFormulario->numTelefono2}" 
                                   maxlength="10" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloNumeros(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:78px;" 
                                   placeholder="Fijo 2"
                                   >
                            <input type="text"          
                                   name="numCelular" 
                                   id="numCelular" 
                                   value="{$objFormulario->numCelular}" 
                                   maxlength="10" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloNumeros(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:96px;" 
                                   placeholder="Celular"
                                   >    
                        </td>
                    </tr>

                    <!-- VIVIENDA ACTUAL  Y VALOR ARRENDAMIENTO -->
                    <tr>
                        <td>Vivienda Actual </td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    name="seqVivienda" 
                                    id="seqVivienda" 
                                    style="width:260px;"
                                    >
                                {foreach from=$arrVivienda key=seqVivienda item=txtVivienda}
                                    <option value="{$seqVivienda}"
                                            {if $objFormulario->seqVivienda == $seqVivienda} 
                                                selected 
                                            {/if}
                                            >
                                        {$txtVivienda}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                        <td height="25px" valign="bottom">Valor Arriendo</td>
                        <td height="25px" valign="bottom" align="left">$
                            <input type="text"
                                   name="valArriendo" 
                                   id="valArriendo" 
                                   value="{$objFormulario->valArriendo}" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloNumeros(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   onKeyUp="formatoSeparadores(this)" 
                                   onChange="formatoSeparadores(this)"
                                   style="width:100px; text-align:right"
                                   >
                        </td>
                    </tr>

                    <!-- MODALIDAD DEL SUBSIDIO Y TIPO DE SOLUCION-->
                    <tr> 
                        <td>Modalidad</td>
                        <td> 
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
                                            {if $arrDatos.seqPlanGobierno == 2}
                                                disabled
                                            {/if}
                                            >
                                        {$arrDatos.txtModalidad}
                                    </option>
                                {/foreach}
                            </select>
                            <input type='hidden' id='seqPlanGobierno' name='seqPlanGobierno' value='3'>
                        </td>
                        <td>Solución</td>
                        <td id="tdTipoSolucion">
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    onChange="asignarValorSubsidio(this, 'bolDesplazado');"
                                    name="seqSolucion" 
                                    id="seqSolucion" 
                                    style="width:260px;"
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
                            <input type="hidden" name="seqUnidadProyecto" id="seqUnidadProyecto" value="1" >
                        </td>
                    </tr>

                    <!-- INGRESOS DEL HOGAR -->
                    <tr> 
                        <td>Ingresos </td>
                        <td align="left" colspan="3">
                            $ <input type="text" 
                                     name="valIngresoHogar" 
                                     id="valIngresoHogar" 
                                     value="{$objFormulario->valIngresoHogar|string_format:"%d"}" 
                                     onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                     onBlur="soloNumeros(this);
                                             this.style.backgroundColor = '#FFFFFF';"
                                     onKeyUp="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
                                     style="width:100px; text-align:right"
                                     >
                        </td>
                    </tr>

                    <!-- TIENE AHORRO y DONDE TIENE EL AHORRO -->
                    <tr> 
                        <TD>Valor Ahorro </TD>
                        <td align="left">
                            $ <input type="text" 
                                     name="valSaldoCuentaAhorro" 
                                     id="valSaldoCuentaAhorro" 
                                     value="{$objFormulario->valSaldoCuentaAhorro|string_format:"%d"}" 
                                     onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                     onBlur="soloNumeros(this);
                                             this.style.backgroundColor = '#FFFFFF';"
                                     onKeyUp="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
                                     style="width:100px; text-align:right" 
                                     >
                        </td>
                        <td>Banco Ahorro</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';"  
                                    name="seqBancoCuentaAhorro" 
                                    id="seqBancoCuentaAhorro" 
                                    style="width:260px;"
                                    >
                                <option value="1">Ninguno</option>
                                {foreach from=$arrBanco key=seqBanco item=txtBanco}
                                    <option value="{$seqBanco}"
                                            {if $objFormulario->seqBancoCuentaAhorro == $seqBanco} 
                                                selected 
                                            {/if}
                                            >
                                        {$txtBanco}
                                    </option>
                                {/foreach}
                            </select>
                            <input type="hidden" name="seqBancoCuentaAhorro2" id="seqBancoCuentaAhorro2" value ="{$objFormulario->seqBancoCuentaAhorro2}">
                            <input type="hidden" name="seqEntidadSubsidio" id="seqEntidadSubsidio" value ="{$objFormulario->seqEntidadSubsidio}">
                        </td>
                    </tr>

                    <!-- TIENE CREDITO Y DONDE TIENE EL CREDITO -->
                    <tr> 
                        <td>Valor Credito </td>
                        <td align="left">
                            $ <input type="text" 
                                     name="valCredito" 
                                     id="valCredito" 
                                     value="{$objFormulario->valCredito|string_format:"%d"}" 
                                     onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                     onBlur="soloNumeros(this);
                                             this.style.backgroundColor = '#FFFFFF';"  
                                     onKeyUp="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
                                     style="width:100px; text-align:right" 
                                     >
                        </td>
                        <td>Banco Credito</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="soloNumeros(this);
                                            this.style.backgroundColor = '#FFFFFF';"  
                                    name="seqBancoCredito" 
                                    id="seqBancoCredito" 
                                    style="width:260px;"
                                    >
                                <option value="1">Sin Credito</option>
                                {foreach from=$arrBanco key=seqBanco item=txtBanco}
                                    <option value="{$seqBanco}"
                                            {if $objFormulario->seqBancoCredito == $seqBanco} 
                                                selected 
                                            {/if}
                                            >
                                        {$txtBanco}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>

                    <!-- TIENE SUBSIDIO -->
                    <tr>
                        <td>Valor Subsidio: AVC / FOVIS / SFV</td>
                        <td align="left">
                            $ <input type="text" 
                                     name="valSubsidioNacional" 
                                     id="valSubsidioNacional" 
                                     value="{$objFormulario->valSubsidioNacional|string_format:"%d"}" 
                                     onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                     onBlur="soloNumeros(this);
                                             this.style.backgroundColor = '#FFFFFF';"
                                     onKeyUp="formatoSeparadores(this)" 
                                     onChange="formatoSeparadores(this)"
                                     style="width:100px; text-align:right"
                                     >
                        </td>
                        <td>Soporte (No. Carta)</td>
                        <td>
                            <input type="text" 
                                   name="txtSoporteSubsidioNacional" 
                                   id="txtSoporteSubsidioNacional" 
                                   value="{$objFormulario->txtSoporteSubsidioNacional}" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="sinCaracteresEspeciales(this);
                                           this.style.backgroundColor = '#FFFFFF';"  
                                   style="width:260px;"
                                   >
                        </td>
                    </tr>

                    <!-- TIENE DONACIONES Y DONDE TIENE LA DONACION -->
                    <tr> 
                        <td>Donaci&oacute;n / Rec. Econ&oacute;mico </td>
                        <td align="left">
                            $ <input	type="text" 
                                     name="valDonacion" 
                                     id="valDonacion" 
                                     value="{$objFormulario->valDonacion|string_format:"%d"}" 
                                     onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                     onBlur="soloNumeros(this);
                                             this.style.backgroundColor = '#FFFFFF';"  
                                     onKeyUp="formatoSeparadores(this)" 
                                     onChange="formatoSeparadores(this)"
                                     style="width:100px; text-align:right" 
                                     >
                        </td>
                        <td>Entidad</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="soloNumeros(this); this.style.backgroundColor = '#FFFFFF';"  
                                    name="seqEmpresaDonante" 
                                    id="seqEmpresaDonante" 
                                    style="width:260px;"
                                    >
                                <option value="1">Ninguna</option>
                                {foreach from=$arrDonantes key=seqEmpresaDonante item=txtEmpresaDonante}
                                    <option value="{$seqEmpresaDonante}"
                                            {if $objFormulario->seqEmpresaDonante == $seqEmpresaDonante} 
                                                selected 
                                            {/if}
                                            >
                                        {$txtEmpresaDonante}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- SEGUIMIENTO -->	        
            <div id="seg" style="height:490px;">
                {include file="seguimiento/seguimientoFormulario.tpl"}
                <p>
                <div id="contenidoBusqueda" style="height:410px; overflow:auto;">
                    {include file="seguimiento/buscarSeguimiento.tpl"}
                </div>
                </p>
            </div>    

            <!-- ACTOS ADMINISTRATIVOS -->        
            <div id="aad" style="height:490px;">
                <p>
                    {include file="subsidios/actosAdministrativos.tpl"}
                </p>
            </div>
        </div>
    </div>
</form>
<div id="inscripcionTabView"></div>
<div id="objDireccionOcultoListener"></div>



