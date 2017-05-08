

<!--
PLANTILLA DE POSTULACION CON PESTAÑAS 
-->
<form name="frmPostulacion" 
	id="frmPostulacion" 
	onSubmit="pedirConfirmacion('mensajes',this,'./contenidos/subsidios/pedirConfirmacion.php'); return false;" 
	autocomplete=off 
	>	

	
<!-- CODGIO PARA EL POP UP DE SEGUIMIENTO -->
    {assign var=seqEstadoProceso value=$objFormulario->seqEstadoProceso}
    {include file='subsidios/pedirSeguimiento.tpl'}
    <br>
    <table cellspacing="0" cellpadding="0" border="0" width="100%" style="z-index:999999;">
        <tr>
            <td width="150px" align="center">
                <a href="#" onClick="javascript: imprimirPostulacion( document.frmPostulacion );">
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
                ></td>						
			<td></td><td></td>
			<td align="right" style="padding-right: 10px;" width="250px">
				<input type="submit" name="salvar" id="salvar" value="Salvar Postulaci&oacute;n">
			</td>
		</tr>
	</table>
<br>
{if $objFormulario->bolSancion eq 1}
    <div class="sancion">HOGAR SANCIONADO</div><br />
    <input type="hidden" value="1" id="bolSancion" name="bolSancion" />
{/if}

<!-- TAB VIEW DE POSTULACION -->
<div id="postulacion" class="yui-navset" style="width:100%; text-align:left;">
	<ul class="yui-nav">
		<li class="selected"><a href="#frm"><em>Formulario</em></a></li>
		<li><a href="#seg"><em>Seguimiento</em></a></li>
		<li><a href="#aad"><em>Actos Administrativos</em></a></li>
	</ul>
	<div class="yui-content">
		<!-- FORMULARIO DE POSTULACION -->	    
		<div id="frm" style="height:470px;">
			<!-- TABLA DE ESTADO DEL PROCESO Y NUMERO DEL FORMULARIO -->
			<table cellspacing="2" cellpadding="0" width="100%" border="0">
				<tr>
					<td height="22px" style="padding-left:10px;" width="15%"><b>Estado</b>
					</td>
					<td style="padding-left:10px;" width="33%">
						<!-- $objFormulario->seqEstadoProceso == 37 || $objFormulario->seqEstadoProceso == 38 -->
						{if $objFormulario->seqEstadoProceso == 6 || $objFormulario->seqEstadoProceso == 7}
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
							<input type="hidden" 
								   name="seqEstadoProceso" 
								   id="seqEstadoProceso" 
								   value="{$seqEstadoProceso}"
								   />
								   <!--<input type='text' id='seqEstado' name='seqEstado' value='{$seqEstadoProceso}'>-->
						{/if}
					</td>
					<td align="right" width="52%">
						{if $txtTutorDesembolso != ""}
							<b>Tutor de Desembolso: </b>{$txtTutorDesembolso}
						{else}
							&nbsp;
						{/if}
					</td>
				</tr>
            <tr>
                <!-- NUMERO DEL FORMULARIO -->
                <td style="padding-left:10px;"><b>No. Formulario</b></td>
                <td width="110px" align="left" style="padding-left:10px;">
                    <input	type="text" 
                           name="txtFormulario" 
                           id="txtFormulario" 
                           value="{$objFormulario->txtFormulario}"
                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                           onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF'; " 
                           style="width:100px;"
                           {if $objFormulario->txtFormulario != ""}
                               readonly
                           {/if}
                           />
                </td>
                <td>&nbsp;</td>
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
                <div id="composicion" style="height:390px; overflow:auto;">
                    <!-- TABLA PARA LAS FECHAS DE INSCRIPCION, POSTULACION, ULTIMA ACTUALIZACION -->
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
                        <tr>
                            <td class="tituloTabla">Fecha de Inscripción:</td>
                            <td class="tituloTabla">Fecha de Postulación:</td>
                            <td class="tituloTabla">Última Actualización:</td>
                            {if $objFormulario->seqEstadoProceso eq 15 or $objFormulario->seqEstadoProceso eq 19 or $objFormulario->seqEstadoProceso eq 20 or $objFormulario->seqEstadoProceso >= 22}
                                <td class="tituloTabla">Vigencia de SDV:</td>
                            {/if}
                        </tr>
                        <tr>			        			
                            <td style="padding-left:10px">{$objFormulario->fchInscripcion}</td>                                                                
                            <td style="padding-left:10px">{$objFormulario->fchPostulacion}</td>
                            <td style="padding-left:10px">{$objFormulario->fchUltimaActualizacion}</td>
                            {if $objFormulario->seqEstadoProceso eq 15 or $objFormulario->seqEstadoProceso eq 19 or $objFormulario->seqEstadoProceso eq 20 or $objFormulario->seqEstadoProceso >= 22}
                                <td style="padding-left:10px">{$objFormulario->fchVigencia}</td>
                            {/if}
                        </tr>
                    </table>

                    <!-- TABLA PARA AGREGAR UN MIEMBRO DE HOGAR -->
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">

                        <tr><td style="padding-right:15px;" align="right" height="20px" valign="middle" bgcolor="#CCCCCC">
                                {if $objFormulario->bolSancion neq 1}
                                    <a href="#" 
                                       onClick="mostrarOcultar( 'agregarMiembro' ); document.getElementById('tipoDocumento').focus(); escondeGrupoLgtbi()"
                                       > Agregar Miembro al Hogar </a>
                                {/if}
                            </td></tr>
                        <tr><td id="agregarMiembro" style="display: none;">
                                <table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#E4E4E4">
                                    <tr>
                                        <!-- TIPO DE DOCUMENTO -->
                                        <td>Tipo Documento (*)</td>
                                        <td align="center" width="205px">
                                            <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                    id="tipoDocumento" 
                                                    style="width:200px;"
                                                    >
                                                <!--{foreach from=$arrTipoDocumento key=seqTipoDocumento item=txtTipoDocumento}
                                                    <option value="{$seqTipoDocumento}">{$txtTipoDocumento}</option>
                                                {/foreach}-->
												{foreach from=$arrTipoDocumentoAdulto key=seqTipoDocumento item=txtTipoDocumento}
                            <option value="{$seqTipoDocumento}"
                            {if $objCiudadano->seqTipoDocumento == $seqTipoDocumento } selected {/if}
                            >{$txtTipoDocumento}</option>
                    {/foreach}
                                            </select>
                                        </td>

                                        <!-- NUMERO DEL DOCUMENTO -->
										<!-- onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"	-->
                                        <td>No. Documento (*)</td>
                                        <td align="left" width="275px">
                                            <input type="text" 
                                                   id="numeroDoc" 
                                                   value="" 
                                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                   onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';" 
															onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
												   style="width:100px; text-align: right;" 
                                                   />
                                        </td>
                                    </tr>
                                    <tr>
                                        <!-- PRIMER APELLIDO -->	
                                        <td>Primer Apellido (*)</td>
                                        <td align="left">
                                            <input	type="text" 
                                                   id="apellido1" 
                                                   value="" 
                                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                   onBlur="soloLetras( this ); this.style.backgroundColor = '#FFFFFF';" 
                                                   style="width:200px;"
                                                   />
                                        </td>

                                        <!-- SEGUNDO APELLIDO -->
                                        <td>Segundo Apellido</td>
                                        <td align="left">
                                            <input	type="text" 
                                                   id="apellido2" 
                                                   value="" 
                                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                   onBlur="soloLetras( this ); this.style.backgroundColor = '#FFFFFF';" 
                                                   style="width:270px;"
                                                   />
                                        </td>
                                    </tr>
                                    <tr>

                                        <!-- PRIMER NOMBRE -->
                                        <td>Primer Nombre (*)</td>
                                        <td align="left">
                                            <input	type="text" 
                                                   id="nombre1" 
                                                   value="" 
                                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                   onBlur="soloLetras( this ); this.style.backgroundColor = '#FFFFFF';" 
                                                   style="width:200px;"
                                                   />
                                        </td>

                                        <!-- SEGUNDO NOMBRE -->
                                        <td>Segundo Nombre</td>
                                        <td align="left">
                                            <input	type="text" 
                                                   id="nombre2" 
                                                   value="" 
                                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                   onBlur="soloLetras( this ); this.style.backgroundColor = '#FFFFFF';" 
                                                   style="width:270px;"
                                                   />
                                        </td>
                                    </tr>
                                    <tr>
                                        <!-- PARENTESCO -->
                                        <td>Parentesco (*)</td>
                                        <td align="left">
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
                                        <td align="left">
                                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                    id="estadoCivil" 
                                                    style="width:270px;"
                                                    >
                                                <option value="0">0 - Ninguno</option>
                                                <!--{foreach from=$arrEstadoCivil key=seqEstadoCivil item=txtEstadoCivil}
                                                    <option value="{$seqEstadoCivil}">{$txtEstadoCivil}</option>
                                                {/foreach}-->
												{foreach from=$arrEstadoCivilInscripcion key=seqEstadoCivil item=txtEstadoCivil}
                    <option value="{$seqEstadoCivil}"
                    {if $objCiudadano->seqEstadoCivil == $seqEstadoCivil} selected {/if}

                    {if $seqEstadoCivil == 1 || $seqEstadoCivil == 3 || $seqEstadoCivil == 4 || $seqEstadoCivil == 5}
						style="color:#FF0000"
                    {/if}
                        >{$txtEstadoCivil}
                    </option>
                    {/foreach}
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <!-- FECHA DE NACIMIENTO -->
                                        <td>Fecha. Nacimiento (*)</td>
                                        <td>
                                            <input type="text" 
                                                   id="fechaNac"
                                                   name="fechaNac"
                                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                   onBlur="this.style.backgroundColor = '#FFFFFF'; "
                                                   style="width:80px" 
                                                   value=""
                                                   readonly
                                                   /> <a onClick="calendarioPopUp('fechaNac')" href="#">Calendario</a>
                                            <a onClick="document.getElementById('fechaNac').value='';" href="#">Limpiar</a>
                                        </td>

                                        <!-- CONDICION ESPECIAL -->
                                        <td>Cond. Especial 1</td>
                                        <td align="left">
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
                                        <td align="left">
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
                                        <td align="left">
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
                                        <td align="left">
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
                                        <td align="left">
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
                                        <!-- LGTBI -->
                                        <td>LGTBI</td>
										<td align="left">
											<select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
													onChange="escondeGrupoLgtbi()"
                                                    id="lgtb" 
                                                    style="width:200px;" >
												<option value="0">No</option>
												<option value="1">Si</option>
											</select>
										</td>
										<!-- HECHO VICTIMIZANTE -->
										<td>Hecho Victimizante (*)</td>
										<td align="left"><span id='tipovictima' name='tipovictima' >
										<select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
										        onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                id="seqTipoVictima" 
                                                style="width:270px;">
                                        <!--<option value="0">Ninguno</option>-->
                                        {foreach from=$arrTipoVictima key=seqTipoVictima item=txtTipoVictima}
                                        <option value="{$seqTipoVictima}">{$txtTipoVictima}</option>
                                        {/foreach}
                                        </select></span>
                                        </td>
                                        </tr>

										<tr id='lineaLgtbi' style='display:none'>
										<!-- Grupo LGTBI -->
                                        <td>Grupo LGTBI </td>
										<td align="left">
										<select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
										        onBlur="this.style.backgroundColor = '#FFFFFF';"
												onChange="cambiaBolLgtbi()"
                                                id="seqGrupoLgtbi" 
												name="seqGrupoLgtbi" 
                                                style="width:200px;">
										{foreach from=$arrGrupoLgtbi key=seqGrupoLgtbi item=txtGrupoLgtbi}
                                        <option value="{$seqGrupoLgtbi}">{$txtGrupoLgtbi}</option>
                                        {/foreach}
                                        </select>
										</td>
										<td></td>
										<td></td>
                                        </tr>
										
                                    <tr>
                                        <!-- NIVEL EDUCATIVO -->
                                        <td>Nivel Educativo</td>
                                        <td align="left">
                                            <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                    id="nivelEducativo" 
                                                    style="width:200px;"
                                                    >
                                                {foreach from=$arrNivelEducativo key=seqNivelEducativo item=txtNivelEducativo}
                                                    <option value="{$seqNivelEducativo}">{$txtNivelEducativo}</option>
                                                {/foreach}
                                            </select>
                                        </td>

                                        <!-- AFILIADO SISTEMA DE SALUD -->
                                        <td>Sistema Salud</td>
                                        <td align="left">
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
										<!-- value="{$objCiudadano->txtNombre2}"  -->
                                        <td>Ingresos (*)</td>
                                        <td align="left">
                                            $ <input type="text" 
                                                   id="ingresos" 
                                                   value="" 
                                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                   onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';" 
												   onkeyup="formatoSeparadores(this)"
												   onchange="formatoSeparadores(this)"
                                                   style="width:100px; text-align:right"
                                                   />
                                        </td>
										<td></td><td></td>
                                    </tr>
                                    <tr>
                                        <!-- OCUPACION -->
                                        <td>Ocupación</td>
                                        <td align="left" colspan="3">
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
					<!-- Retirado: {assign var=cajaCompensacion   value=$objCiudadano->seqCajaCompensacion} -->
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
                            {assign var=nivelEducativo     value=$objCiudadano->seqNivelEducativo}
                            {assign var=salud              value=$objCiudadano->seqSalud}
                            {assign var=seqTipoVictima     value=$objCiudadano->seqTipoVictima}
							{assign var=seqGrupoLgtbi     value=$objCiudadano->seqGrupoLgtbi}

                            {math equation="x + y" x=$valTotal y=$objCiudadano->valIngresos assign=valTotal}

                            <table cellpadding="0" cellspacing="0" border="0" width="100%" id="{$objCiudadano->numDocumento}">
                                <tr onMouseOver="this.style.background = '#E4E4E4';"
                                    onMouseOut="this.style.background = '#F9F9F9'; "
                                    style="cursor:pointer"
                                    >
                                    <td align="center" width="18px" height="22px">
                                        <div	style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999;" 
                                             onClick="desplegarDetallesMiembroHogar('{$objCiudadano->numDocumento}')"
                                             onMouseOver="this.style.backgroundColor='#ADD8E6';"
                                             onMouseOut="this.style.backgroundColor='#F9F9F9';"
                                             id="masDetalles{$objCiudadano->numDocumento}"
                                             >+</div>  
                                    </td>
                                    <td width="262px" style="padding-left:5px;">
                                        {$objCiudadano->txtNombre1} {$objCiudadano->txtNombre2} 
                                        {$objCiudadano->txtApellido1} {$objCiudadano->txtApellido2}
                                    </td>
                                    <td width="120px">
                                        {$arrAbreviacionesTipoDocumento.$tipoDocumento}  
                                        {$objCiudadano->numDocumento}
                                    </td>
                                    <td width="190px">
                                        {$arrParentescoNombres.$parentesco}
                                    </td>
                                    <td align="right" style="padding-right:7px">
                                        $ {$objCiudadano->valIngresos|number_format:0:',':'.'}
                                    </td>
                                    {if $objFormulario->bolSancion neq 1}
                                        <td align="center" width="18px" height="22px">
                                            <div	style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999;" 
                                                 onClick="modificarMiembroHogar('{$objCiudadano->numDocumento}'), escondeGrupoLgtbi()"
                                                 onMouseOver="this.style.backgroundColor='#ADD8E6';"
                                                 onMouseOut="this.style.backgroundColor='#F9F9F9';"
                                                 >E</div>  
                                        </td>
                                        <td align="center" width="18px" height="22px">
                                            <div	style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999;" 
                                                 onClick="quitarMiembroHogar( '{$objCiudadano->numDocumento}' );"
                                                 onMouseOver="this.style.backgroundColor='#FFA4A4';"
                                                 onMouseOut="this.style.backgroundColor='#F9F9F9'"
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
                                <input type="hidden" id="{$objCiudadano->numDocumento}-bolLgtb" name="hogar[{$objCiudadano->numDocumento}][bolLgtb]" value="{$objCiudadano->bolLgtb}">
                                <!--<input type="hidden" id="{$objCiudadano->numDocumento}-seqCajaCompensacion" name="hogar[{$objCiudadano->numDocumento}][seqCajaCompensacion]" value="{$objCiudadano->seqCajaCompensacion}">-->
                                <input type="hidden" id="{$objCiudadano->numDocumento}-seqNivelEducativo" name="hogar[{$objCiudadano->numDocumento}][seqNivelEducativo]" value="{$objCiudadano->seqNivelEducativo}">
                                <input type="hidden" id="{$objCiudadano->numDocumento}-seqSalud" name="hogar[{$objCiudadano->numDocumento}][seqSalud]" value="{$objCiudadano->seqSalud}">
                                <!--<input type="hidden" id="{$objCiudadano->numDocumento}-bolBeneficiario" name="hogar[{$objCiudadano->numDocumento}][bolBeneficiario]" value="{$objCiudadano->bolBeneficiario}">-->
								<input type="hidden" id="{$objCiudadano->numDocumento}-seqTipoVictima" name="hogar[{$objCiudadano->numDocumento}][seqTipoVictima]" value="{$objCiudadano->seqTipoVictima}">
								<input type="hidden" id="{$objCiudadano->numDocumento}-seqGrupoLgtbi" name="hogar[{$objCiudadano->numDocumento}][seqGrupoLgtbi]" value="{$objCiudadano->seqGrupoLgtbi}">
                            </table>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="display:none" id="detalles{$objCiudadano->numDocumento}">
                                <tr>
                                    <td colspan="6">
                                        <table cellpadding="2" cellspacing="0" border="0" width="100%" style="border: 1px solid #999999;">
                                            <tr>
                                                <td><b>Sexo:</b> {$arrSexo.$sexo}</td>
                                                <td><b>LGTBI:</b> {if $objCiudadano->bolLgtb == 1}Si {else} No {/if} ({$arrGrupoLgtbi.$seqGrupoLgtbi|lower|ucwords})</td>
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
                                                <td><b>Ocupación:</b> {$arrOcupacionNombres.$ocupacion|lower|ucwords}</td>
                                                <td><b>Condición Especial 3:</b> {$arrCondicionEspecialNombres.$condicionEspecial3|lower|ucwords}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Sistema de Salud:</b> {$arrSalud.$salud|lower|ucwords} </td>
                                                <td><b>Victima:</b> {$arrTipoVictima.$seqTipoVictima|lower|ucwords}</td>
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
									<!-- MODIFICADO -->
                                    <!--$ {$objFormulario->valIngresoHogar|number_format:0:',':'.'}-->
									{foreach from=$objFormulario->arrCiudadano item=objCiudadano key=seqCiudadano}
										{assign var=cargaIngreso value=$cargaIngreso+$objCiudadano->valIngresos}
									{/foreach}
									$ {$cargaIngreso|number_format:0:',':'.'}
                                {/if}
								
                            </td>
                            <td width="18px">&nbsp;</td>
                            {if $objFormulario->valIngresoHogar != 0 && $objFormularioIngreso->valIngresoHogar != ""}
                            <input type="hidden" name="valIngresoHogar" id="valIngresoHogar" value="{$valTotal}">
                        {else}
							<!-- MODIFICADO -->
                            <!--<input type="hidden" name="valIngresoHogar" id="valIngresoHogar" value="{$objFormulario->valIngresoHogar}">-->
							<input type="hidden" name="valIngresoHogar" id="valIngresoHogar" value="{$cargaIngreso}">
                        {/if}
                        <td width="18px">&nbsp;</td>
                        </tr>
                    </table>	

                </div>

                <!-- DATOS DEL HOGAR -->				    
                <div id="hogar" style="height:379px;"><p>
                    <table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF"  style="border: 1px dotted #999999; padding:5px">
                        <tr>
                            <!-- VIVIENDA ACTUAL -->
                            <td width="150px">Vivienda Actual </td>
                            <td align="left" width="210px">
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
                        <td>Valor del Arriendo</td>
                        <td align="left" width="210px">
                            $ <input	type="text" 
                                     name="valArriendo" 
                                     id="valArriendo" 
                                     value="{$objFormulario->valArriendo}" 
                                     onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                     onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';" 
                                     style="width:240px;" />
                        </td>
                    </tr>	

                    <tr>
                        <!-- FECHA DESDE LA QUE PAGA ARRIENDO -->
                        <td>
                            Paga Arriendo desde
                        </td>
                        <td>
                            <input	type="text" 
                                   name="fchArriendoDesde" 
                                   id="fchArriendoDesde" 
                                   value="{if $objFormulario->fchArriendoDesde != '0000-00-00'}{$objFormulario->fchArriendoDesde}{/if}" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:80px;" 
                                   readonly
                                   />
                            <a onClick="calendarioPopUp('fchArriendoDesde')" href="#">Calendario</a>&nbsp;
                            <a onClick="document.getElementById('fchArriendoDesde').value='';" href="#">Limpiar</a>
                        </td>
                        <td>
                            Comprobante Arriendo
                        </td>
                        <td>
                            <select name="txtComprobanteArriendo"
                                    onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                    style="width:260px;"
                                    ><option value="no" {if $objFormulario->txtComprobanteArriendo != "si"} selected {/if} >No</option>
                                <option value="si" {if $objFormulario->txtComprobanteArriendo == "si"} selected {/if}>Si</option>
                            </select>
                        </td>
                    </tr>

                    <tr> 
                        <!-- DIRECCION DE RESIDENCIA -->
                        <td>
                            <a href="#" id="Direccion" onClick="recogerDireccion( 'txtDireccion', 'objDireccionOculto' )">Dirección (*)</a>
                        </td>
                        <td colspan="3" align="left">
                            <input	type="text" 
                                   name="txtDireccion" 
                                   id="txtDireccion"
                                   value="{$objFormulario->txtDireccion}"
                                   style="width:635px; background-color:#ADD8E6;"
                                   readonly
                                   /><input type='hidden' id='seqTipoDireccion' name='seqTipoDireccion' value="{$objFormulario->seqTipoDireccion}">


                        </td>
                    </tr>
                    <tr>
                        <!-- LOCALIDAD -->
                        <td>Localidad </td>
                        <td align="left">
                            <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    onChange="obtenerBarrioPostulacion(this);"
                                    name="seqLocalidad" 
                                    id="seqLocalidad" 
                                    style="width:200px;"
                                    >
                                {foreach from=$arrLocalidad key=seqLocalidad item=txtLocalidad}
                    <option value="{$seqLocalidad}"
                    {if $objFormulario->seqLocalidad == $seqLocalidad} selected {/if}
                    >                    
                    {$txtLocalidad}
                </option>
                
            {/foreach}
                        </select>
                    </td>

					<!--------------------------------------------------------------------->
					<!-- BARRIO Mostar-->
                        
                        <td><a href="#" id="" onClick="obtenerBarrioPostulacion(seqLocalidad)">Barrio</a></td>
                        <td align="left" id="tdBarrio">
			<input type = "text" readonly
			   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                           onBlur="this.style.backgroundColor = '#FFFFFF';" 
                           name="seqBarrioMostrar"                                 
                           style="width:200px;" 
			   id="{$objFormulario->seqBarrio}" 
                                {foreach from=$arrBarrio key=seqBarrio item=txtBarrio}
                                        {if $objFormulario->seqBarrio == $seqBarrio}
                                            value="{$txtBarrio}" 
					{/if}
                                {/foreach}
                            />
                    
					<!-- FIN BARRIO Mostar-->
					<!-- BARRIO guardar-->
					<input type = "hidden" readonly
                                               name="seqBarrio"                                 
                                               style="width:200px;" 
                                               id="seqBarrio"                                    
						   {foreach from=$arrBarrio key=seqBarrio item=txtBarrio}                                        
                                                        {if $objFormulario->seqBarrio == $seqBarrio} 									
                                                            value="{$seqBarrio}" />
							{/if}
                                                   {/foreach}
                            
					</td>
					<!--------------------------------------------------------------------->
					
                    <!-- BARRIO 
                    <td>Barrio </td>
                    <td valign="top" align="left">
                        <div id="barrioAutocomplete" style="width:200px;">
                            <input	type="text" 
                                   name="txtBarrio" 
                                   id="txtBarrio" 
                                   value="{$objFormulario->txtBarrio}" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
                                   style="width:260px"
                                   />
                            <div id="barrioContainer" style="width:200px"></div>
                        </div>
                    </td>
                </tr>-->

                <tr> <!-- TELEFONO 1 TELEFONO 2 Y CELULAR -->
<td>Ciudad</td>
                    <td align="left">
                        <select            
                            name="seqCiudad" 
                            id="seqCiudad" 
                            onFocus="this.style.backgroundColor = '#ADD8E6';" 
                            onBlur="this.style.backgroundColor = '#FFFFFF'; soloBogota();" 
                            style="width:200px;" 
                            >
                            {foreach from=$arrCiudad key=seqCiudad item=txtCiudad}
                {if $objFormulario->seqCiudad == $seqCiudad} selected 
            ><option value="{$seqCiudad}" > {$txtCiudad}
        </option>            
                {/if}
            {/foreach}
                </select>
            </td>
            <td>Teléfonos</td>
                    <td align="left">
                        <input	type="text" 
								placeholder="Fijo 1"
                               name="numTelefono1" 
                               id="numTelefono1" 
                               value="{$objFormulario->numTelefono1}" 
							   maxlength="7" 
                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                               onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';" 
                               style="width:78px;" 
                               />
                        <input	type="text" 
								placeholder="Fijo 2"
                               name="numTelefono2" 
                               id="numTelefono2" 
                               value="{$objFormulario->numTelefono2}" 
							   maxlength="10" 
                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                               onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';" 
                               style="width:78px;" 
                               />
                        <input	type="text" 
								placeholder="Celular"
                               name="numCelular" 
                               id="numCelular" 
                               value="{$objFormulario->numCelular}" 
							   maxlength="10" 
                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                               onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';" 
                               style="width:96px;" 
                               />
                    </td>
                </tr>
                <tr> <!-- CORREO ELECTRONICO -->
                    <td>Correo Electr&oacute;nico</td>
                    <td align="left" colspan="3">
                        <input	type="text" 
                               name="txtCorreo" 
                               id="txtCorreo" 
                               value="{$objFormulario->txtCorreo}" 
                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                               onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';" 
                               style="width:635px;"
                               class="inputLogin"
                               />
                    </td>
                </tr>
                <tr>
            <!--<td>Puntaje Sisben</td>
        <td><input type="text"
                   name="numPuntajeSisben"
                   id="numPuntajeSisben"
                   size="10"
                   value="{$objFormulario->numPuntajeSisben}"
                   onfocus="this.style.backgroundColor = '#ADD8E6';"
                   onblur="validarDecimalSisben( this );this.style.backgroundColor = '#FFFFFF';"
                   /></td>-->
               <td>V&iacute;ctima </td>
                <td align="left">
                        {if $objFormulario->bolDesplazado != 1} Vulnerable {/if}</option>
                        {if $objFormulario->bolDesplazado == 1} Desplazado {/if}</option>
                </td>
				<td></td>
            </tr>	   
			<tr style='display:none'><td id='tdupz'>
			<input type = "hidden" readonly name="seqUpz" id="seqUpz" value="{$objFormulario->seqUpz}" />
										
			
			</td></tr>
        </table>
        <br>
        <!-- TABLA RED DE SERVICIOS -->
        <table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF" style="border: 1px dotted #999999; padding:5px; display:none">
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
            </tr>
            <tr>
                <!-- OTRO -->
                <td>Otro</td>
                <td colspan="8" style="padding-left:10px">
                    <input	type="text" 
                           name="txtOtro" 
                           id="txtOtro" 
                           value="{$objFormulario->txtOtro}" 
                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                           onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';" 
                           style="width:99%;" 
                           />
                </td>
            </tr>
			
        </table>
        </p></div>

    <!-- MODALIDAD Y VIVIENDA -->				        
    <div id="modalidad" style="height:379px;"><p>
        <table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">

            <tr>
                <!-- DIRECCION SOLUCION-->
                <td>
                    {if $objFormulario->seqEstadoProceso == 43 || $objFormulario->seqEstadoProceso == 44 ||$objFormulario->seqEstadoProceso == 45 ||$objFormulario->seqEstadoProceso == 46 ||$objFormulario->seqEstadoProceso == 47 ||$objFormulario->seqEstadoProceso == 48 }
							Dirección Solución
					{else}
							<a href="#" id="DireccionSolucion" onClick="recogerDireccion('txtDireccionSolucion', 'objDireccionOcultoSolucion')">Dirección Solución</a>
					{/if}
                </td>
                <td colspan="3" align="center">
                    <input	type="text" 
                           name="txtDireccionSolucion" 
                           id="txtDireccionSolucion" 
                           value="{$objFormulario->txtDireccionSolucion}" 
                           style="width:100%; background-color:#ADD8E6;"
                           readonly
                           />

                </td>
            </tr>

            <tr>
                <!-- MODALIDAD DEL SUBSIDIO -->
                <td>Modalidad Solución</td>
                <td width="240px"><input type="hidden" id="seqPlanGobierno" name="seqPlanGobierno" value="{$objFormulario->seqPlanGobierno}">
                    <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                            onChange="cargarContenido( 'tdTipoSolucion' , './contenidos/subsidios/tipoSolucion.php' , 'postulacion=1&modalidad=' + this.options[ this.selectedIndex ].value , true ); 
                                cargarContenido( 'tdProyecto' , './contenidos/subsidios/proyectos.php' , 'modalidad=' + this.options[ this.selectedIndex ].value , false );
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
            <td>Tipo Solución<input type='hidden' id='bolDesplazado' name='bolDesplazado' value='{$objFormulario->bolDesplazado}'></td>
            <td id="tdTipoSolucion" align="center" width="210px">
                <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                        onBlur="this.style.backgroundColor = '#FFFFFF';" 
                        onChange="asignarValorSubsidio( this , 'bolDesplazado' );"
                        name="seqSolucion" 
                        id="seqSolucion" 
                        style="width:260px;"
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
    <!-- NUMERO DE MATRICULA INMOBILIARIA -->
    <td>Matricula Inmobiliaria</td>
    <td>
        <input	type="text" 
               name="txtMatriculaInmobiliaria" 
               id="txtMatriculaInmobiliaria" 
               value="{$objFormulario->txtMatriculaInmobiliaria}" 
               onFocus="this.style.backgroundColor = '#ADD8E6';" 
               onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';" 
               style="width:230px;"
               />
    </td>

    <!-- CHIP -->
    <td>CHIP</td>
    <td>
        <input	type="text" 
               name="txtChip" 
               id="txtChip" 
               value="{$objFormulario->txtChip}" 
               onFocus="this.style.backgroundColor = '#ADD8E6';" 
               onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';" 
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
        <td width="120px">Presupuesto</td>
        <td width="120px">
            $ <input	type="text" 
                     name="valPresupuesto" 
                     id="valPresupuesto" 
                     value="{$objFormulario->valPresupuesto}" 
                     onFocus="this.style.backgroundColor = '#ADD8E6';" 
                     onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF'; sumarTotal();" 
                     style="width:100px;"
                     />
        </td>

        <!-- VALOR DEL AVALUO  -->
        <td>Aval&uacute;o</td>
        <td  width="120px">
            $ <input	type="text" 
                     name="valAvaluo" 
                     id="valAvaluo" 
                     value="{$objFormulario->valAvaluo}" 
                     onFocus="this.style.backgroundColor = '#ADD8E6';" 
                     onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF'; sumarTotal();" 
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
                     onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';" 
                     style="width:90%;"
                     readonly
                     />
        </td>
    </tr>
</table>
</p></div>

<!-- INFORMACION FINANCIERA -->				       
<div id="financiera" style="height:379px;"><p>

    <table cellpadding="1" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">

        <tr>
            <!-- TIENE AHORRO -->
			<!-- onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"	-->
            <td>Tiene Ahorro</td>
            <td align="center">
                $ <input	type="text" 
                         name="valSaldoCuentaAhorro" 
                         id="valSaldoCuentaAhorro" 
						 value="{$objFormulario->valSaldoCuentaAhorro|number_format:'0':',':'.'}"
                         onFocus="this.style.backgroundColor = '#ADD8E6';" 
                         onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF'; sumarTotalRecursos();" 
							onkeyup="formatoSeparadores(this)"
							onchange="formatoSeparadores(this)"
                         style="width:100px; text-align: right" 
                         />
            </td>

            <!-- BANCO DONDE TIENE EL AHORRO -->
            <td>D&oacute;nde</td>
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
                   onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"  
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
               onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"  
               style="width:100px;"
               maxlength="10" 
               readonly
               /> <a href="#" onClick="javascript: calendarioPopUp( 'fchAperturaCuentaAhorro' ); ">Calendario</a>&nbsp;
        <a onClick="document.getElementById('fchAperturaCuentaAhorro').value='';" href="#">Limpiar</a>
    </td>
</tr>

<tr>
    <!-- TIENE OTRO AHORRO -->
	<!-- onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"	-->
    <td>Otro Ahorro</td>
    <td align="center">
        $ <input	type="text" 
                 name="valSaldoCuentaAhorro2" 
                 id="valSaldoCuentaAhorro2" 
                 value="{$objFormulario->valSaldoCuentaAhorro2|number_format:'0':',':'.'}"
                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                 onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF'; sumarTotalRecursos();" 
							onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
                 style="width:100px; text-align: right" 
                 />
    </td>

    <!-- BANCO DONDE TIENE EL AHORRO -->
    <td>D&oacute;nde</td>
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
               onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"  
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
               onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"  
               style="width:100px;"
               maxlength="10" 
               readonly
               /> <a href="#" onClick="javascript: calendarioPopUp( 'fchAperturaCuentaAhorro2' ); ">Calendario</a>&nbsp;
        <a onClick="document.getElementById('fchAperturaCuentaAhorro2').value='';" href="#">Limpiar</a>
    </td>
</tr>


<tr>
    <!-- SUBSIDIO NACIONAL -->
	<!-- onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"	-->
    <td>Valor Subsidio Nacional y/o Subsidio CCF</td>
    <td align="center">
        $ <input	type="text" 
                 name="valSubsidioNacional" 
                 id="valSubsidioNacional" 
                 value="{$objFormulario->valSubsidioNacional|number_format:'0':',':'.'}"
                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                 onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF'; sumarTotalRecursos();"  
							onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
                 style="width:100px; text-align: right" 
                 />
    </td>
    <td>Soporte (No.Carta)</td>
    <td align="center">
        <input	type="text" 
               name="txtSoporteSubsidioNacional" 
               id="txtSoporteSubsidioNacional" 
               value="{$objFormulario->txtSoporteSubsidioNacional}" 
               onFocus="this.style.backgroundColor = '#ADD8E6';" 
               onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"  
               style="width:300px;" 
               />
    </td>
</tr>
<tr>
    <!-- APORTE LOTE -->
	<!-- onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"	-->
    <td>Aporte Lote o Terreno</td>
    <td align="center">
        $ <input	type="text" 
                 name="valAporteLote" 
                 id="valAporteLote" 
                 value="{$objFormulario->valAporteLote|number_format:'0':',':'.'}"
                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                 onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF'; sumarTotalRecursos();"  
							onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
                 style="width:100px; text-align: right" 
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
               onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"  
               style="width:300px;" 
               />
    </td>
</tr>	
<tr>
    <!-- CESANTIAS -->
	<!-- onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"	-->
    <td>Cesant&iacute;as</td>
    <td align="center">
        $ <input	type="text" 
                 name="valSaldoCesantias" 
                 id="valSaldoCesantias" 
                 value="{$objFormulario->valSaldoCesantias|number_format:'0':',':'.'}"
                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                 onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF'; sumarTotalRecursos();"  
							onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
                 style="width:100px; text-align: right" 
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
               onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"  
               style="width:300px;" 
               />
    </td>
</tr>	
<tr>
    <!-- APORTE AVANCE DE OBRA -->
	<!-- onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"	-->
    <td>Aporte Avance de Obra</td>
    <td align="center">
        $ <input type="text" 
                 name="valAporteAvanceObra" 
                 id="valAporteAvanceObra" 
                 value="{$objFormulario->valAporteAvanceObra|number_format:'0':',':'.'}"
                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                 onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF'; sumarTotalRecursos();"  
							onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
                 style="width:100px; text-align: right" 
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
               onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"  
               style="width:300px;" 
               />
    </td>
</tr>

<tr>
    <!-- TIENE CREDITO -->
	<!-- onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"	-->
    <td>Tiene Credito</td>
    <td align="center">
        $ <input	type="text" 
                 name="valCredito" 
                 id="valCredito" 
                 value="{$objFormulario->valCredito|number_format:'0':',':'.'}"
                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                 onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF'; sumarTotalRecursos();"  
							onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
                 style="width:100px; text-align: right" 
                 />
    </td>

    <!-- BANCO DONDE TIENE EL CREDITO -->
    <td>D&oacute;nde</td>
    <td align="center">
        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"  
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
               onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"  
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
               onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"  
               style="width:100px;"
               maxlength="10" 
               readonly
               /> <a onClick="calendarioPopUp('fchAprobacionCredito')" href="#">Calendario</a> &nbsp;
        <a onClick="document.getElementById('fchAprobacionCredito').value='';" href="#">Limpiar</a>
    </td>
</tr>				
<tr>
    <!-- APORTE AVANCE DE OBRA -->
	<!-- onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"	-->
    <td>Aporte Materiales</td>
    <td align="center">
        $ <input	type="text" 
                 name="valAporteMateriales" 
                 id="valAporteMateriales" 
                 value="{$objFormulario->valAporteMateriales|number_format:'0':',':'.'}"
                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                 onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF'; sumarTotalRecursos();"  
							onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
                 style="width:100px; text-align: right" 
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
               onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"  
               style="width:300px;" 
               />
    </td>
</tr>

<tr>
    <!-- TIENE DONACIONES -->
	<!-- onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"	-->
    <td>Tiene Donaci&oacute;n / <br>Reconocimiento Econ&oacute;mico</td>
    <td align="center">
        $ <input	type="text" 
                 name="valDonacion" 
                 id="valDonacion" 
                 value="{$objFormulario->valDonacion|number_format:'0':',':'.'}"
                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                 onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF'; sumarTotalRecursos();"  
							onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
                 style="width:100px; text-align: right" 
                 />
    </td>

    <!-- DE DONDE PROVIENE LA DONACION -->
    <td>Entidad</td>
    <td style="padding-left: 10px;">
        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"  
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
               onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"  
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
	<!-- value="{$valSubsidio}" -->
    <td class="tituloTabla" height="25px" align="top">Valor Subsidio Aspira</td>
    <td align="right" style="padding-right:10px" id="tdValSubsidio"  height="25px" align="top">
        $ <input	type="text" 
                 name="valAspiraSubsidio"
                 id="valAspiraSubsidio" 
                 		value="{$valSubsidio|number_format:'0':',':'.'}"
                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                 onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF'; sumarTotalRecursos();"  
                 style="width:100px; text-align:right" 
                 />
    </td>
    <td class="tituloTabla"  height="25px" align="top">Soporte Cambio</td>
    <td style="padding-left: 10px;"  height="25px" align="top">
        <input	type="text" 
               name="txtSoporteSubsidio" 
               id="txtSoporteSubsidio" 
               value="{$objFormulario->txtSoporteSubsidio}" 
               onFocus="this.style.backgroundColor = '#ADD8E6';" 
               onBlur="sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"  
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
        {include file="seguimiento/buscarSeguimiento.tpl"}
    </div>
</div>

<!-- ACTOS ADMINISTRATIVOS -->	        
<div id="aad" style="height:401px;"><p>
        {include file="subsidios/actosAdministrativos.tpl"}
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
<div id="objDireccionOculto" style="display:none"></div>
<div id="objDireccionOcultoSolucion" style="display:none"></div>
<div id="barrioListener"></div>
