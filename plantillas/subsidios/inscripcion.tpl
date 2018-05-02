
<!-- **********************************************************
    FORMULARIO DE INSCRIPCION - FORMULARIO PEQUEÑO -
    SOLO INSCRIPCION POR PRIMERA VEZ
*************************************************************** -->

<form name="frmInscripcion" id="frmInscripcion" onSubmit="return false;" autocomplete=off>

    <!-- CODGIO PARA EL POP UP DE SEGUIMIENTO -->
    {include file='subsidios/pedirSeguimiento.tpl'}

    <!-- BOTON PARA SALVAR EL FORMULARIO -->
    <table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#E4E4E4">
        <tr> 
            <td height="25px" valign="middle" align="right" style="padding-right:10px; padding-left:10px;" bgcolor="#E4E4E4" colspan="4">
                <input type="submit"
                       name="salvar"
                       id="salvar"
                       value="Salvar Inscripción"
                       onClick="pedirConfirmacion('mensajes',this.form,'./contenidos/subsidios/pedirConfirmacion.php')"
                       />
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
            <div id="frm" style="height:550px;">

                <!-- ESTADO DEL PROCESO -->
                <table cellspacing="0" cellpadding="2" border="0" width="100%" height="30px">
                    <tr bgcolor="#E4E4E4"> 
                        <td width="140px"><b>Estado del proceso</b></td>
                        <td>
                            {$arrEstado.36}
                            <input type="hidden" name="seqEstadoProceso" id="seqEstadoProceso" value="36">
                        </td>
                    </tr>
                </table>
                <br>
                <table cellspacing="0" cellpadding="2" border="0" width="100%">

                    <!-- TIPO DOCUMENTO Y NUMERO DE DOCUMENTO -->
                    <tr>
                        <td width="150px">No. Documento</td>
                        <td>
                            <input type="text"
                                   name="numDocumento"
                                   id="numDocumento"
                                   value="{$arrPost.cedula|number_format:0:'.':'.'}"
                                   style="width:100px; text-align: right;"
                                   readonly
                            />
                        </td>
                        <td width="120px">Tipo Documento</td>
                        <td width="210px">
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                    onchange="soporteDocumento('documento',$('#seqTipoDocumento').val())"
                                    name="seqTipoDocumento"
                                    id="seqTipoDocumento"
                                    style="width:260px;"
                            >
                                <option value="0">Seleccione</option>
                                {foreach from=$arrTipoDocumento key=seqTipoDocumento item=txtTipoDocumento}
                                    <option value="{$seqTipoDocumento}"
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

                    <!-- SOPORTE PARA EL DOCUMENTO DE IDENTIDAD -->
                    <tr id="soporteCedula" style="display: none">
                        <td colspan="4" style="padding-left: 0px; background-color: #E4E4E4;">
                            <table cellspacing="0" cellpadding="2" border="0">
                                <tr>
                                    <td width="150px">Fecha de Expedición</td>
                                    <td width="323px">
                                        <input type="text"
                                               id="fchExpedicion"
                                               name="fchExpedicion"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                                               value=""
                                               readonly
                                        /> <a onClick="calendarioPopUp('fchExpedicion')" href="#">Calendario</a> &nbsp;&nbsp;
                                        <a onClick="document.getElementById('fchExpedicion').value = '';" href="#">Limpiar</a>
                                    </td>
                                    <td width="120px"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Entidad del registro civil</td>
                                    <td>
                                        <select name="txtEntidadDocumento"
                                                id="txtEntidadDocumento"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                onchange="soporteDocumento('documentoNotaria', $('#txtEntidadDocumento').val())"
                                                style="width: 260px"
                                        >
                                            <option value="">Seleccione</option>
                                            <option value="Registraduría">Registraduría</option>
                                            <option value="Notaria">Notaria</option>
                                            <option value="Consulado">Consulado</option>
                                            <option value="Corregimiento">Corregimiento</option>
                                            <option value="Inspección de Policía">Inspección de Policía</option>
                                        </select>
                                    </td>
                                    <td>Indicativo Serial</td>
                                    <td>
                                        <input type="text"
                                               id="numIndicativoSerial"
                                               name="numIndicativoSerial"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                                               value=""
                                               style="width: 260px;"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%" id="documentoNotaria" style="display: none">
                                            <tr>
                                                <td width="154px">Notaría</td>
                                                <td>
                                                    <input type="text"
                                                           id="numNotariaDocumento"
                                                           name="numNotariaDocumento"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                           onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                           style="width: 260px;"
                                                           value=""
                                                    />
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>Ciudad</td>
                                    <td>
                                        <select name="seqCiudadDocumento"
                                                id="seqCiudadDocumento"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width: 260px;"
                                        >
                                            <option value="0">Seleccione</option>
                                            {foreach from=$arrCiudad key=seqCiudad item=txtCiudad}
                                                <option value="{$seqCiudad}">
                                                    {$txtCiudad}
                                                </option>
                                            {/foreach}
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- PRIMER APELLIDO Y SEGUNDO APELLIDO -->
                    <tr> 
                        <td>Primer Apellido</td>
                        <td>
                            <input type="text" 
                                   name="txtApellido1" 
                                   id="txtApellido1" 
                                   value=""
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
                                   value=""
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
                                   value=""
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
                                   value=""
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloLetras(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:260px;"
                                   />
                        </td>
                    </tr>

                    <!-- FECHA DE NACIMIENTO Y ESTADO CIVIL -->
                    <tr>
                        <td>Fecha de Nacimiento</td>
                        <td>
                            <input type="text"
                                   id="fchNacimiento"
                                   name="fchNacimiento"
                                   onFocus="this.style.backgroundColor = '#ADD8E6';"
                                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                                   style="width:80px"
                                   value=""
                                   readonly
                            /> <a onClick="calendarioPopUp('fchNacimiento')" href="#">Calendario</a>
                            <a onClick="document.getElementById('fchNacimiento').value = '';"
                               href="#">Limpiar</a>
                        </td>
                        <td>Estado Civil </td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                    onchange="soporteDocumento('estadoCivil',$('#seqEstadoCivil').val())"
                                    name="seqEstadoCivil"
                                    id="seqEstadoCivil"
                                    style="width:260px;"
                            >
                                <option value="0">Seleccione</option>
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

                    <!-- SOPORTE PARA EL ESTADO CIVIL - CASADO - -->
                    <tr id="soporteEstadoCivilCasado" style="display: none">
                        <td colspan="4" style="padding-left:0px; background-color: #E4E4E4">
                            <table cellspacing="0" cellpadding="2" border="0">
                                <tr>
                                    <td width="150px">Consecutivo</td>
                                    <td width="323px">
                                        <input type="text"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                                               name="numConsecutivoCasado"
                                               id="numConsecutivoCasado"
                                               value=""
                                               style="width: 260px;"
                                        >
                                    </td>
                                    <td width="120px">Notaria</td>
                                    <td>
                                        <input type="text"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                                               name="numNotariaCasado"
                                               id="numNotariaCasado"
                                               value=""
                                               style="width: 260px;"
                                        >
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ciudad</td>
                                    <td>
                                        <select name="seqCiudadCasado"
                                                id="seqCiudadCasado"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width: 260px;"
                                        >
                                            <option value="0">Seleccione</option>
                                            {foreach from=$arrCiudad key=seqCiudad item=txtCiudad}
                                                <option value="{$seqCiudad}">
                                                    {$txtCiudad}
                                                </option>
                                            {/foreach}
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- SOPORTE PARA EL ESTADO CIVIL - CASADO CON SOCIEDAD CONYUGAL DISUELTA Y LIQUIDADA - -->
                    <tr id="soporteEstadoCivilCSCDL" style="display: none">
                        <td colspan="4" style="padding-left:0px; background-color: #E4E4E4">
                            <table cellpadding="2" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td width="150px">Consecutivo</td>
                                    <td width="323px">
                                        <input type="text"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                                               name="numConsecutivoCSCDL"
                                               id="numConsecutivoCSCDL"
                                               value=""
                                               style="width: 260px;"
                                        >
                                    </td>
                                    <td width="120px">Entidad</td>
                                    <td>
                                        <select name="txtEntidadCSCDL"
                                                id="txtEntidadCSCDL"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                onchange="soporteDocumento('notariaCSCDL', $('#txtEntidadCSCDL').val())"
                                                style="width: 260px;"
                                                >
                                            <option value="">Seleccione</option>
                                            <option value="Personeria">Personeria</option>
                                            <option value="Notaria">Notaria</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ciudad</td>
                                    <td>
                                        <select name="seqCiudadCSCDL"
                                                id="seqCiudadCSCDL"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width: 260px;"
                                        >
                                            <option value="0">Seleccione</option>
                                            {foreach from=$arrCiudad key=seqCiudad item=txtCiudad}
                                                <option value="{$seqCiudad}">
                                                    {$txtCiudad}
                                                </option>
                                            {/foreach}
                                        </select>
                                    </td>
                                    <td colspan="2">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%" id="notariaCSCDL" style="display: none">
                                            <tr>
                                                <td width="154px">Notaría</td>
                                                <td>
                                                    <input type="text"
                                                           id="numNotariaCSCDL"
                                                           name="numNotariaCSCDL"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                           onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                           style="width: 260px;"
                                                           value=""
                                                    />
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- SOPORTE PARA EL ESTADO CIVIL - SOLTERO CON UNION MARITAL DE HECHO - -->
                    <tr id="soporteEstadoCivilUnion" style="display: none">
                        <td colspan="4" style="padding-left:0px; background-color: #E4E4E4">
                            <table cellpadding="2" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td width="150px">Tipo Certificación</td>
                                    <td width="323px">
                                        <select name="txtCertificacionUnion"
                                                id="txtCertificacionUnion"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width: 260px;"
                                        >
                                            <option value="">Seleccione</option>
                                            <option value="Acta de Conciliación">Acta de Conciliación</option>
                                            <option value="Declaración">Declaración</option>
                                        </select>
                                    </td>
                                    <td width="120px">Consecutivo</td>
                                    <td>
                                        <input type="text"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                                               name="numConsecutivoUnion"
                                               id="numConsecutivoUnion"
                                               value=""
                                               style="width: 260px;"
                                        >
                                    </td>
                                </tr>
                                <tr>
                                    <td>Entidad</td>
                                    <td>
                                        <select name="txtEntidadUnion"
                                                id="txtEntidadUnion"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                onchange="soporteDocumento('notariaUnion', $('#txtEntidadUnion').val())"
                                                style="width: 260px;"
                                        >
                                            <option value="">Seleccione</option>
                                            <option value="Personeria">Personeria</option>
                                            <option value="Notaria">Notaria</option>
                                        </select>
                                    </td>
                                    <td colspan="2" id="notariaUnion" style="display: none">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="123px">Notaria</td>
                                                <td>
                                                    <input type="text"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                           onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                           name="numNotariaUnion"
                                                           id="numNotariaUnion"
                                                           value=""
                                                           style="width: 260px;"
                                                    >
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ciudad</td>
                                    <td>
                                        <select name="seqCiudadUnion"
                                                id="seqCiudadUnion"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width: 260px;"
                                        >
                                            <option value="0">Seleccione</option>
                                            {foreach from=$arrCiudad key=seqCiudad item=txtCiudad}
                                                <option value="{$seqCiudad}">
                                                    {$txtCiudad}
                                                </option>
                                            {/foreach}
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- SOPORTE PARA EL ESTADO CIVIL - SOLTERO - -->
                    <tr id="soporteEstadoCivilSoltero" style="display: none">
                        <td colspan="4" style="padding-left:0px; background-color: #E4E4E4">
                            <table cellpadding="2" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td width="155px">Notaria</td>
                                    <td width="325px">
                                        <input type="text"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                                               name="numNotariaSoltero"
                                               id="numNotariaSoltero"
                                               value=""
                                               style="width: 260px"
                                        >
                                    </td>
                                    <td width="123px">Ciudad</td>
                                    <td>
                                        <select name="seqCiudadSoltero"
                                                id="seqCiudadSoltero"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width: 260px"
                                        >
                                            <option value="0">Seleccione</option>
                                            {foreach from=$arrCiudad key=seqCiudad item=txtCiudad}
                                                <option value="{$seqCiudad}">
                                                    {$txtCiudad}
                                                </option>
                                            {/foreach}
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- SEXO Y CONDICION ESPECIAL -->
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
                                    <option value="{$seqSexo}">
                                        {$txtSexo}
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
                                    <option value="{$seqCondicionEspecial}">
                                        {$txtCondicionEspecial}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>			

                    <!-- CONDICION ETNICA Y CONDICION ESPECIAL 2 -->
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
                                    <option value="{$seqEtnia}">
                                        {$txtEtnia}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
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
                                    <option value="{$seqCondicionEspecial}">
                                        {$txtCondicionEspecial}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>

                    <!-- NIVEL EDUCATIVO y CONDICION ESPECIAL 3 -->
                    <tr>
                        <td>Nivel Educativo</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                    onchange="selectAnidados('{$numDocumento}', 0);"
                                    name="seqNivelEducativo"
                                    id="nivelEducativo"
                                    style="width:260px;"
                            >
                                <option value="0" selected>Seleccione Uno</option>
                                <option value="1">Ninguno</option>
                                {foreach from=$arrNivelEducativo key=seqNivelEducativo item=txtNivelEducativo}
                                    <option value="{$seqNivelEducativo}">
                                        {$txtNivelEducativo}
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
                                    <option value="{$seqCondicionEspecial}">
                                        {$txtCondicionEspecial}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>

                    <!-- AÑOS APROBADOS y CORREO -->
                    <tr>
                        <td>Años Aprobados</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                    id="numAnosAprobados"
                                    name="numAnosAprobados"
                                    style="width:260px;"
                            >
                                <option value="0">0</option>
                            </select>
                        </td>
                        <td>Correo Electr&oacute;nico</td>
                        <td>
                            <input type="text" 
                                   name="txtCorreo" 
                                   id="txtCorreo" 
                                   value=""
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="sinCaracteresEspeciales(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:260px;"
                                   class="inputLogin"
                                   />
                        </td>
                    </tr>

                    <!-- GRUPO LGTBI Y HECHO VICTIMIZANTE -->
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
                                    <option value="{$seqGrupoLgtbi}">
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
                                    <option value="{$seqTipoVictima}">
                                        {$txtTipoVictima}
                                    </option>
                                {/foreach}
                            </select>

                        </td>
                    </tr>

                    <!-- LGTBI Y HOGAR VICTIMA -->
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
                                    <option value="{$seqOcupacion}">
                                        {$txtOcupacion}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>

                    <!-- AFILIACION A SALUD -->
                    <tr>
                        <td>Afiliación a Salud</td>
                        <td align="left" colspan="3">
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                    id="seqSalud"
                                    name="seqSalud"
                                    style="width:100%;"
                            >
                                <option value="0">NINGUNO</option>
                                {foreach from=$arrSalud key=seqSalud item=txtSalud}
                                    <option value="{$seqSalud}">{$txtSalud}</option>
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
                                   value=""
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
                                    <option value="{$seqCiudad}">
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
                                {foreach from=$arrBarrio key=seqBarrio item=txtBarrio}
                                    <option value="{$seqBarrio}">
                                        {$txtBarrio}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                        <td id="tdupz" colspan="2">
                            <input type='hidden' readonly id='seqUpz' name='seqUpz' value="">
                        </td>
                    </tr>

                    <!-- TELEFONO 1 TELEFONO 2 Y CELULAR -->
                    <tr> 
                        <td>Telefonos</td>
                        <td colspan="3">
                            <input type="text" 
                                   name="numTelefono1" 
                                   id="numTelefono1" 
                                   value=""
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
                                   value=""
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
                                   value=""
                                   maxlength="10" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloNumeros(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:96px;" 
                                   placeholder="Celular"
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
                                    onChange="datosPestanaPostulacion('inscripcion');"
                                    >
                                <option value="0">Seleccione</option>
                                {foreach from=$arrModalidad key=seqModalidad item=txtModalidad}
                                    <option value="{$seqModalidad}">
                                        {$txtModalidad}
                                    </option>
                                {/foreach}
                            </select>
                            <input type='hidden' id='seqPlanGobierno' name='seqPlanGobierno' value='3'>
                        </td>
                        <td>Solución</td>
                        <td id="tdTipoSolucion">
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                    name="seqSolucion"
                                    id="seqSolucion" 
                                    style="width:260px;"
                                    >
                                <option value="1">NINGUNA</option>
                            </select>
                            <input type="hidden" name="seqUnidadProyecto" id="seqUnidadProyecto" value="1" >
                        </td>
                    </tr>

                    <!-- INGRESOS DEL CIUDADANO Y DEL HOGAR -->
                    <tr> 
                        <td>Ingresos </td>
                        <td align="left" colspan="3">
                            $ <input type="text" 
                                     name="valIngresoHogar" 
                                     id="valIngresoHogar" 
                                     value="0"
                                     onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                     onBlur="this.style.backgroundColor = '#FFFFFF';"
                                     onKeyUp="formatoSeparadores(this)"
                                     style="width:100px; text-align:right"
                                     >
                        </td>
                    </tr>

                </table>
            </div>

            <!-- SEGUIMIENTO -->	        
            <div id="seg" style="height:550px;">
                {include file="seguimiento/seguimientoFormulario.tpl"}
                <p>
                <div id="contenidoBusqueda" style="height:410px; overflow:auto;">
                    {include file="seguimiento/buscarSeguimiento.tpl"}
                </div>
                </p>
            </div>    

            <!-- ACTOS ADMINISTRATIVOS -->        
            <div id="aad" style="height:550px;">
                <p>
                    {include file="subsidios/actosAdministrativos.tpl"}
                </p>
            </div>
        </div>
    </div>
</form>
<div id="inscripcionTabView"></div>
<div id="objDireccionOcultoListener"></div>



