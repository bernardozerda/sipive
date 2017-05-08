<!--
PLANTILLA PARA LA ETAPA DE REVSION DE OFERTA Y ESCRITURACION 
@author Bernardo Zerda
@version 1.0 Dic 2009
-->

<!-- DECLARACION DE VARIABLES PARA USAR EN LA PLANTILLA -->
{assign var=seqModalidad			value=$claFormulario->seqModalidad}
{assign var=seqSolucion				value=$claFormulario->seqSolucion}	
{assign var=seqLocalidad			value=$claFormulario->seqLocalidad}
{assign var=seqBancoAhorro			value=$claFormulario->seqBancoCuentaAhorro}
{assign var=seqBancoAhorro2			value=$claFormulario->seqBancoCuentaAhorro2}
{assign var=seqBancoCredito			value=$claFormulario->seqBancoCredito}
{assign var=seqEstadoProceso		value=$claFormulario->seqEstadoProceso}
{assign var=seqBancoCuentaAhorro	value=$claFormulario->seqBancoCuentaAhorro}
{assign var=seqBancoCuentaAhorro2	value=$claFormulario->seqBancoCuentaAhorro2}
{assign var=seqBancoCredito			value=$claFormulario->seqBancoCredito}
{assign var=seqEntidadDonante		value=$claFormulario->seqEmpresaDonante}
{assign var=bolDesplazado			value=$claFormulario->bolDesplazado}
{assign var=seqUnidadProyecto		value=$claFormulario->seqUnidadProyecto}

<!-- TREE VIEW QUE CONTIENE LA INFORMACION DE LA FASE -->
   
{assign var=numAltura value=500}
<div id="demo" class="yui-navset" style="width:98%; height:{$altura}; text-align:left;">
	<ul class="yui-nav">
		<li class="selected"><a href="#dh"><em>Datos del Hogar</em></a></li>
		<li><a href="#di"><em>Datos del Inmueble</em></a></li>
		<li><a href="#rd"><em>Recibo de Documentos</em></a></li>
		<li><a href="#se"><em>Seguimiento</em></a></li>
		<li><a href="#aad"><em>Actos Administrativos</em></a></li>
	</ul>            
	<div class="yui-content">

<!-- PESTANA DE DATOS DEL HOGAR -->
        <div id="dh" style="height:{$altura}">
            {include file="desembolso/pestanaDatosHogar.tpl"}				
        </div>

<!-- PESTANA DE DATOS DEL INMUEBLE -->			
        <div id="di" style="height:{$altura}"><p>
		
		<!-- PARA BUSCAR Y BORRAR
			proyectoSolucion
			DatosInmuebleGA
			DatosInmueble
			NombreVendedor
		 -->
         
         <center>
            {if $txtFase == "busquedaOferta"}
               <div style="width:100%; color:white; background-color:#00cc00; height:20px; vertical-align:middle; font-weight:bold; padding-top:5px;">
                  INFORMACION DE ESCRITURA ANTECEDENTE
               </div>
            {elseif $txtFase == "escrituracion"}
               <div style="width:100%; color:white; background-color: #0000ff; height:20px; vertical-align:middle; font-weight:bold; padding-top:5px;">
                  DATOS ESCRITURACION CON SDVE
               </div>
            {/if}
         </center> 
           
			<table cellpadding="2" cellspacing="0" border="0" width="98%">
        		
        		<!-- datos del vendedor o arrendatario en caso de modalidad de arriendo -->
        		<tr><td class="tituloTabla" colspan="4">
        			Datos del {if $seqModalidad != 5} vendedor {else} arrenador {/if}
        		</td></tr>
        		
        		<!-- nombre del vendedor / arrendador -->
		        <tr>
		            <td>Nombre del {if $seqModalidad != 5} vendedor {else} arrenador {/if}</td>
		            <td colspan="3">
		                <input	type="text" 
								name="txtNombreVendedor" 
                                id="txtNombreVendedor"
                                onFocus="this.style.backgroundColor = '#ADD8E6'; ponerPlaceholder( this.id , 'Nombre del {if $seqModalidad != 5} vendedor {else} arrenador {/if}' );" 
                                onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales( this );"
                                value="{$claDesembolso->txtNombreVendedor}"
                                style="width:98%"
						/>
		            </td>
		        </tr>
		        
		        <!-- tipo de documento -->
		        <tr>
		            <td>Tipo Documento</td>
		            <td>
		                <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
		                        onBlur="this.style.backgroundColor = '#FFFFFF';" 
		                        name="seqTipoDocumento" 
		                        id="seqTipoDocumento"
		                        style="width:200px" >
		                    {foreach from=$arrTipoDocumento key=seqTipoDocumento item=txtTipoDocumento}
		                        <option value="{$seqTipoDocumento}"
		                        {if $claDesembolso->seqTipoDocumento == $seqTipoDocumento} selected {/if}
		                        >{$txtTipoDocumento}</option>
		                	{/foreach}
						</select>	        				
		        	</td>
			        <td width="150px">Documento del {if $seqModalidad != 5} vendedor {else} arrenador {/if}</td>
			        <td>
			            <input type="text" 
			                   name="numDocumentoVendedor" 
			                   id="numDocumentoVendedor"
			                   onFocus="this.style.backgroundColor = '#ADD8E6';ponerPlaceholder( this.id , 'Documento' );" 
			                   onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                   value="{$claDesembolso->numDocumentoVendedor}"
			                   style="width:200px"
						/>
			        </td>
			    </tr>
			    
			    <!-- TELEFONO 1 y 2 -->
    			<tr>
                	<td>Tel&eacute;fono {if $seqModalidad != 5} vendedor {else} arrenador {/if}</td>
	                <td>
	                    <input type="text" 
	                           name="numTelefonoVendedor" 
	                           id="numTelefonoVendedor"
	                           onFocus="this.style.backgroundColor = '#ADD8E6';ponerPlaceholder( this.id , 'Telefono 1' );" 
	                           onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
	                           value="{$claDesembolso->numTelefonoVendedor}"
	                           size="16"
	                           />

						<input type="text" 
	                           name="numTelefonoVendedor2" 
	                           id="numTelefonoVendedor2"
	                           onFocus="this.style.backgroundColor = '#ADD8E6';ponerPlaceholder( this.id , 'Telefono 2' );" 
	                           onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
	                           value="{$claDesembolso->numTelefonoVendedor2}"
	                           size="16"
	                           />
	                </td>
	                <td>Correo Electr&oacute;nico</td>
	                <td>
	                    <input	type="text" 
	                           name="txtCorreoVendedor" 
	                           id="txtCorreoVendedor"
	                           onFocus="this.style.backgroundColor = '#ADD8E6';ponerPlaceholder( this.id , 'Correo electr&oacute;nico' );" 
	                           onBlur="this.style.backgroundColor = '#FFFFFF';"
	                           value="{$claDesembolso->txtCorreoVendedor}"
	                           style="width:200px"
						/>
	                </td>
            	</tr>   
	            <tr>
	            	<td>Tipo de Vivienda</td>
	        		<td>
			            Nueva <input type="radio" 
			                         name="txtCompraVivienda"
			                         id="compraNueva"
			                         value="nueva"
			            			 {if $claDesembolso->txtCompraVivienda == "nueva"} checked {/if}
			            />
			            
	        			Usada <input type="radio" 
				                     name="txtCompraVivienda"
				                     id="compraUsada"
				                     value="usada"
	        						 {if $claDesembolso->txtCompraVivienda == "usada"} checked {/if}
	        			/>
					</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>    		
			</table>

			<!--  DATOS DEL INMUEBLE -->
			<table cellpadding="2" cellspacing="0" border="0" width="98%">
				<tr>
			        <td class="tituloTabla" colspan="6">Datos del inmueble</td>
			    </tr>
				{if $txtFase == "escrituracion"}
					{if $seqUnidadProyecto > 0}
						<tr> <!-- Si está en escrituracion, coloque el campo Nombre del Proyecto - Conjunto (Si existe)-->
							<!-- OJO: VALIDAR QUE APAREZCA SOLO A LOS FORMULARIOS QUE TENGAN UNA UNIDAD ASIGNADA-->
							<td>Nombre Proyecto EPI</td>
							<td><input type="text" name="txtNombreProyecto" id="txtNombreProyecto" onFocus="this.style.backgroundColor = '#ADD8E6'; ponerPlaceholder( this.id , 'Direcci&oacute;n' );" onBlur="this.style.backgroundColor = '#FFFFFF';" style="width:98%;" value="{$nombreProyecto}" readonly /></td>
						</tr>
					{/if}
				{/if}
			    <tr>
			    	<td width="150px">
			            <a href="#" id="Direccion" onClick="recogerDireccion( 'txtDireccionInmueble', 'objDireccionOcultoInmueble' )">
			            	Direcci&oacute;n del Inmueble
			            </a>
			        </td>
			        <td colspan="2">
			            <div id="DireccionInmueble"> 
			                <input type="text" 
			                       name="txtDireccionInmueble" 
			                       id="txtDireccionInmueble"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';ponerPlaceholder( this.id , 'Direcci&oacute;n' );" 
	                           	   onBlur="this.style.backgroundColor = '#FFFFFF';"
			                       style="width:98%;"
			                       value="{$claDesembolso->txtDireccionInmueble}"
			                       readonly
			                 />
			                <div id="objDireccionOcultoInmueble" style="display:none" />
			            </div> 
			        </td>
			        <td colspan="2">
			            {if $seqModalidad != 1}
			                <input 	type="checkbox"
			                        name="bolPoseedor"
			                        id="bolPoseedor"
			                        value="1"
			               	 		{if $claDesembolso->bolPoseedor == 1} checked {/if}
			                /> Es Poseedor
				        {else}
				            &nbsp;
				        {/if}
				    </td>
				</tr>
				
                <!-- CIUDAD -->
                <tr>
                    <td>Ciudad</td>
                    <td>
                        <select            
                            name="seqCiudad" 
                            id="seqCiudad" 
                            onFocus="this.style.backgroundColor = '#ADD8E6';" 
                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                            style="width:260px;" 
                            onChange="cargarContenido('localidad','./contenidos/desembolso/cambiarLocalidad.php','ciudad=' + this.options[ this.selectedIndex ].value , true);"
                        ><option value="">Seleccione</option>
                            {foreach from=$arrCiudad key=seqCiudad item=txtCiudad}
                                <option value="{$seqCiudad}" 
                                    {if $claDesembolso->seqCiudad == $seqCiudad} selected {/if}
                                > {$txtCiudad}</option>            
                            {/foreach}
                        </select>    
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>

				<!-- LOCALIDAD Y BARRIO -->
				<tr>
				    <td>Localidad</td>
				    <td id="localidad">
				        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
				                onBlur="this.style.backgroundColor = '#FFFFFF';" 
				                name="seqLocalidad" 
				                id="seqLocalidad" 
				                style="width:260px"
				                onChange="barrioAutocomplete( [ 'txtBarrio' , 'barrioContainer' , 'seqLocalidad'] );"
				        >
				            <option value="0">0 - DESCONOCIDO</option>
				            {foreach from=$arrLocalidad key=seqLocalidad item=txtLocalidad}
				                <option value="{$seqLocalidad}"
				                {if $claDesembolso->seqLocalidad == $seqLocalidad} selected {/if}
				                >{$txtLocalidad}</option>
				    		{/foreach}
						</select>
					</td>
					<td>Barrio</td>
					<td colspan="3" valign="top" align="left">
					    <div id="Barrio"> 
					        <div id="barrioAutocomplete" style="width:200px;">
					            <input	type="text" 
					                   name="txtBarrio" 
					                   id="txtBarrio"
					                   onFocus="this.style.backgroundColor = '#ADD8E6'; ponerPlaceholder( this.id , 'Barrio' );" 
					                   onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
					                   style="width:200px"
					                   value="{$claDesembolso->txtBarrio}"
								/>
					            <div id="barrioContainer" style="width:200px"></div>
					        </div>
					    </div>
					</td>
				</tr>

				<!-- PARA LA MODALIDAD DE ARRIENDO ESTOS DATOS NO VAN -->
				{if $seqModalidad != 5} <!-- inicio de la condicion para modalidad de arriendo -->
				    <tr>
				        <td>T&iacute;tulo de Propiedad</td>
				        <td colspan="5">
				
				            <!-- TITULO DE PROPIEDAD -->
				            <select name="txtPropiedad"
				                    id="txtPropiedad"
				                    onFocus="this.style.backgroundColor = '#ADD8E6';" 
				                    onBlur="this.style.backgroundColor = '#FFFFFF';"
				                    onChange="cambiarTipoPropiedad( this );"
				                    style="width:200px"
							/>
				            	<option value="escritura" {if $claDesembolso->txtPropiedad  == "escritura"} selected {/if}>Escritura Publica</option>
				    			<option value="sentencia" {if $claDesembolso->txtPropiedad  == "sentencia"} selected {/if}>Sentencia</option>
				    			<option value="resolucion" {if $claDesembolso->txtPropiedad == "resolucion"} selected {/if}>Resolucion</option>
								<option value="ninguno" {if $claDesembolso->txtPropiedad == "ninguno"} selected {/if}>Ninguno</option>
				    		</select>
					    </td>
				    </tr>
				    <tr>
				        <td>&nbsp;</td>
				        <td colspan="5">
				
				            <!-- OPCIONES PARA ESCRITURA PUBLICA -->
							
				            <div id="escritura"							
				                 {if $claDesembolso->txtPropiedad == "Escritura" || $claDesembolso->txtPropiedad == "escritura"|| $claDesembolso->txtPropiedad == ""}
				                     style="display:'';"
				                 {else}
				                     style="display:none;"
				                 {/if}
				                 />
				            <div id="Escritura_ga">
				                <input	type="text" 
				                       name="txtEscritura" 
				                       id="txtEscritura"
				                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
				                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
				                       style="width:40px"
				                       value="{$claDesembolso->txtEscritura}"
				                       /> del 
				                <input	type="text" 
				                       name="fchEscritura" 
				                       id="fchEscritura"
				                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
				                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
				                       maxlength="10"
				                       style="width:80px"
				                       value="{if $claDesembolso->fchEscritura != '0000-00-00'}{$claDesembolso->fchEscritura}{/if}"
				                       readonly
				                       />  <a href="#" onClick="calendarioPopUp('fchEscritura');">Calendario</a> notaría
				                <input	type="text" 
				                       name="numNotaria" 
				                       id="numNotaria"
				                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
				                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
				                       maxlength="3"
				                       style="width:37px"
				                       value="{$claDesembolso->numNotaria}"
				                       /> ciudad 
				                <input	type="text" 
				                       name="txtCiudad" 
				                       id="txtCiudad"
				                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
				                       onBlur="javascript: soloLetras( this ); this.style.backgroundColor = '#FFFFFF';"
				                       style="width:100px"
				                       value="{$claDesembolso->txtCiudad}"
				                       /></div> <!-- fin div Escritura_ga -->
				            </div>
				
				            <!-- OPCIONES PARA SENTENCIA -->
				            <div id="sentencia"
				                 {if $claDesembolso->txtPropiedad == "sentencia"}
				                     style="display:'';"
				                 {else}
				                     style="display:none;"
				                 {/if}
				                 />
				            <input	type="text" 
				                   name="fchSentencia" 
				                   id="fchSentencia"
				                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
				                   onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
				                   maxlength="10"
				                   style="width:80px"
				                   value="{if $claDesembolso->fchSentencia != '0000-00-00'}{$claDesembolso->fchSentencia}{/if}"
				                   readonly
				                   />  <a href="#" onClick="calendarioPopUp('fchSentencia');">Calendario</a> juzgado 
				            <input	type="text" 
				                   name="numJuzgado" 
				                   id="numJuzgado"
				                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
				                   onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
				                   maxlength="3"
				                   style="width:37px"
				                   value="{$claDesembolso->numJuzgado}"
				                   /> de la ciudad de 
				            <input	type="text" 
				                   name="txtCiudadSentencia" 
				                   id="txtCiudadSentencia"
				                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
				                   onBlur="javascript: soloLetras( this ); this.style.backgroundColor = '#FFFFFF';"
				                   style="width:100px"
				                   value="{$claDesembolso->txtCiudadSentencia}"
				                   /> 
				            </div>
				
				            <!-- OPCIONES PARA RESOLUCION -->
				            <div id="resolucion"
				                 {if $claDesembolso->txtPropiedad == "resolucion"}
				                     style="display:'';"
				                 {else}
				                     style="display:none;"
				                 {/if}
				                 />
				            <input	type="text" 
				                   name="numResolucion" 
				                   id="numResolucion"
				                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
				                   onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
				                   maxlength="5"
				                   style="width:50px"
				                   value="{$claDesembolso->numResolucion}"
				                   /> del
				            <input	type="text" 
				                   name="fchResolucion" 
				                   id="fchResolucion"
				                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
				                   onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
				                   maxlength="10"
				                   style="width:80px"
				                   value="{if $claDesembolso->fchResolucion != '0000-00-00'}{$claDesembolso->fchResolucion}{/if}"
				                   />  <a href="#" onClick="calendarioPopUp('fchResolucion');">Calendario</a> entidad 
				            <input	type="text" 
				                   name="txtEntidad" 
				                   id="txtEntidad"
				                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
				                   onBlur="javascript: soloLetras( this ); this.style.backgroundColor = '#FFFFFF';"
				                   style="width:100px"
				                   value="{$claDesembolso->txtEntidad}"
				                   /> ciudad 
				            <input	type="text" 
				                   name="txtCiudadResolucion" 
				                   id="txtCiudadResolucion"
				                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
				                   onBlur="javascript: soloLetras( this ); this.style.backgroundColor = '#FFFFFF';"
				                   style="width:100px"
				                   value="{$claDesembolso->txtCiudadResolucion}"
				                   />
				            </div>
				
				        </td>
				    </tr>
				{/if} <!-- fin de la condicion para modalidad de arriendo -->                                       

				<!-- MATRICULA INMOBILIARIA	 -->
				<tr>
				    <td>Matricula Inmobiliaria</td>
				    <td>
				        <input	type="text" 
				               name="txtMatriculaInmobiliaria" 
				               id="txtMatriculaInmobiliaria"
				               onFocus="this.style.backgroundColor = '#ADD8E6'; ponerPlaceholder( this.id , 'Matricula Inmibiliaria' );" 
				               onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
				               style="width:200px"
				               value="{$claDesembolso->txtMatriculaInmobiliaria}"
				               />
				    </td>
				    <td>Chip</td>
				    <td colspan="3">
				        <input	type="text" 
				               name="txtChip" 
				               id="txtChip"
				               onFocus="this.style.backgroundColor = '#ADD8E6'; ponerPlaceholder( this.id , 'Chip' );" 
				               onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
				               style="width:200px"
				               value="{$claDesembolso->txtChip}"
						/>
				    </td>		        			
				</tr>

				<!-- PARA LA MODALIDAD DE ARRIENDO ESTOS DATOS NO VAN -->
				{if $seqModalidad != 5} <!-- inicio de la condicion para modalidad de arriendo -->
				    <tr>
				        <td>Cedula Catastral</td>
				        <td>
				            <input	type="text" 
				                   name="txtCedulaCatastral" 
				                   id="txtCedulaCatastral"
				                   onFocus="this.style.backgroundColor = '#ADD8E6'; ponerPlaceholder( this.id , 'Cedula catastral' );" 
				                   onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
				                   style="width:200px"
				                   value="{$claDesembolso->txtCedulaCatastral}"
							/>
				        </td>
				        <td>Area (m<sup>2</sup>)</td>
				        <td colspan="3">
				            Lote 
				            <input	type="text" 
				                   name="numAreaLote" 
				                   id="numAreaLote"
				                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
				                   onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
				                   style="width:50px"
				                   maxlength="4"
				                   value="{$claDesembolso->numAreaLote}"
				                   /> Construida
				            <input	type="text" 
				                   name="numAreaConstruida" 
				                   id="numAreaConstruida"
				                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
				                   onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
				                   style="width:50px"
				                   maxlength="3"
				                   value="{$claDesembolso->numAreaConstruida}"
				                   />
				        </td>		        			
				    </tr>	        		
				    <tr>
				        <td>Avaluo Inmueble</td>
				        <td>
				            <input	type="text" 
				                   name="numAvaluo" 
				                   id="numAvaluo"
				                   onFocus="this.style.backgroundColor = '#ADD8E6'; ponerPlaceholder( this.id , 'Avaluo' );" 
				                   onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
				                   style="width:200px"
				                   value="{$claDesembolso->numAvaluo}"
				                   />
				        </td>
				        <td>Valor Inmueble</td>
				        <td colspan="5">
				            <input	type="text" 
				                   name="numValorInmueble" 
				                   id="numValorInmueble"
				                   onFocus="this.style.backgroundColor = '#ADD8E6'; ponerPlaceholder( this.id , 'Valor Inmueble' );" 
				                   onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
				                   style="width:200px"
				                   value="{$claDesembolso->numValorInmueble}"
				                   />
				        </td>
				    </tr>
				
				{/if} <!-- fin de la condicion para modalidad de arriendo -->

				<tr>
				    <td>Tipo de Predio</td>
				    <td>
				        Urbano <input type="radio" 
				                      name="txtTipoPredio"
				                      id="tipoUrbano" 
				                      value="urbano" 
				        			  {if $claDesembolso->txtTipoPredio == "urbano"} checked {/if}
				        		/>&nbsp;
				    	Rural <input type="radio" 
				                 	 name="txtTipoPredio"
				                 	 id="tipoRural" 
				                 	 value="rural" 
				    			 	 {if $claDesembolso->txtTipoPredio == "rural"} checked {/if}
				    			/>
					</td>
					<td>
					    Estrato
					</td>
					<td  colspan="3">
					    <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
					            onBlur="this.style.backgroundColor = '#FFFFFF';" 
					            name="numEstrato" 
					            id="numEstrato" 
					            style="width:200px"
					            >
					        <option value="0">No Disponible</option>
					        {section loop=7 start=1 name=estrato}
					            <option value="{$smarty.section.estrato.index}"
					            {if $claDesembolso->numEstrato == $smarty.section.estrato.index} selected {/if} 
					            >Estrato {$smarty.section.estrato.index}</option>
						    {/section}
						</select>
					</td>
				</tr>
			</table>
		</p></div><!-- fin div DatosInmueble -->

<!-- PESTANA DE RECIBO DE DOCUMENTOS -->			
		<div id="rd" style="height:{$altura}"><p>
			
			<!-- DOCUMENTOS PARA PERSONA NATURAL O JURIDICA -->
		    <table cellpadding=2 cellspacing=0 border=0 width="100%">
		        <tr>
		            <td class="tituloTabla" width="280px">Mostrar Documentos</td>
		            <td width="130px">
		                <input  type="radio" 
		                        id="persona" 
		                        name="documentos" 
		                        value="persona"
		                		{if $claDesembolso->txtTipoDocumentos != 'empresa'} checked {/if} 
				                onClick="mostrarDocumentosEscrituracion( this.id , 'listadoDocumentos' );"
		                /> Persona Natural
		        </td>
		        <td>
		            <input  type="radio" 
		                    id="empresa"
		                    name="documentos" 
		                    value="empresa"
				            {if $claDesembolso->txtTipoDocumentos == 'empresa'} checked {/if} 
			            	onClick="mostrarDocumentosEscrituracion( this.id , 'listadoDocumentos' );"
			            /> Persona Jur&iacute;dica
				    </td>
				</tr>
			</table>

			{if $claFormulario->seqModalidad != 5}
			
			    <table cellpadding=2 cellspacing=0 border=0 width="100%" id="listadoDocumentos">
			        <tr>
			            <td class="tituloTabla" width="270px">Documento</td>
			            <td class="tituloTabla" width="50px">Folios</td>
			            <td class="tituloTabla">Observaciones</td>
			        </tr>
			        <tr  id="1-ambos">
			            <td>Escritura P&uacute;blica o Promesa de Compraventa</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numEscrituraPublica" 
			                       id="numEscrituraPublica"
			                       value="{$claDesembolso->numEscrituraPublica}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtEscrituraPublica" 
			                       id="txtEscrituraPublica"
			                       value="{$claDesembolso->txtEscrituraPublica}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr  id="2-ambos">
			            <td>Certificado de tradici&oacute;n y libertad</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numCertificadoTradicion" 
			                       id="numCertificadoTradicion"
			                       value="{$claDesembolso->numCertificadoTradicion}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtCertificadoTradicion" 
			                       id="txtCertificadoTradicion"
			                       value="{$claDesembolso->txtCertificadoTradicion}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr  id="3-ambos">
			            <td>Fotocopia Carta de Asignaci&oacute;n</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numCartaAsignacion" 
			                       id="numCartaAsignacion"
			                       value="{$claDesembolso->numCartaAsignacion}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtCartaAsignacion" 
			                       id="txtCartaAsignacion"
			                       value="{$claDesembolso->txtCartaAsignacion}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr  id="4-ambos">
			            <td>Certificado de riesgo</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numAltoRiesgo" 
			                       id="numAltoRiesgo"
			                       value="{$claDesembolso->numAltoRiesgo}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtAltoRiesgo" 
			                       id="txtAltoRiesgo"
			                       value="{$claDesembolso->txtAltoRiesgo}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr  id="5-ambos">
			            <td>Certificado de habitabilidad</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numHabitabilidad" 
			                       id="numHabitabilidad"
			                       value="{$claDesembolso->numHabitabilidad}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtHabitabilidad" 
			                       id="txtHabitabilidad"
			                       value="{$claDesembolso->txtHabitabilidad}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr  id="6-ambos">
			            <td>Bolet&iacute;n catastral</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numBoletinCatastral" 
			                       id="numBoletinCatastral"
			                       value="{$claDesembolso->numBoletinCatastral}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtBoletinCatastral" 
			                       id="txtBoletinCatastral"
			                       value="{$claDesembolso->txtBoletinCatastral}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr  id="7-ambos">
			            <td>Licencia construcci&oacute;n inmueble</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numLicenciaConstruccion" 
			                       id="numLicenciaConstruccion"
			                       value="{$claDesembolso->numLicenciaConstruccion}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtLicenciaConstruccion" 
			                       id="txtLicenciaConstruccion"
			                       value="{$claDesembolso->txtLicenciaConstruccion}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr  id="8-ambos">
			            <td>Recibo de &uacute;ltimo pago de impuesto predial</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numUltimoPredial" 
			                       id="numUltimoPredial"
			                       value="{$claDesembolso->numUltimoPredial}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtUltimoPredial" 
			                       id="txtUltimoPredial"
			                       value="{$claDesembolso->txtUltimoPredial}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr  id="9-ambos">
			            <td>&Uacute;ltimo recibo de acueducto y alcantarillado</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numUltimoReciboAgua" 
			                       id="numUltimoReciboAgua"
			                       value="{$claDesembolso->numUltimoReciboAgua}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtUltimoReciboAgua" 
			                       id="txtUltimoReciboAgua"
			                       value="{$claDesembolso->txtUltimoReciboAgua}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr  id="10-ambos">
			            <td>&Uacute;ltimo recibo de Energ&iacute;a</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numUltimoReciboEnergia" 
			                       id="numUltimoReciboEnergia"
			                       value="{$claDesembolso->numUltimoReciboEnergia}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtUltimoReciboEnergia" 
			                       id="txtUltimoReciboEnergia"
			                       value="{$claDesembolso->txtUltimoReciboEnergia}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr  id="11-ambos">
			            <td>Acta de entrega del inmueble</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numActaEntrega" 
			                       id="numActaEntrega"
			                       value="{$claDesembolso->numActaEntrega}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtActaEntrega" 
			                       id="txtActaEntrega"
			                       value="{$claDesembolso->txtActaEntrega}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr  id="12-ambos">
			            <td>Certificación Bancaria del Vendedor</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numCertificacionVendedor" 
			                       id="numCertificacionVendedor"
			                       value="{$claDesembolso->numCertificacionVendedor}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtCertificacionVendedor" 
			                       id="txtCertificacionVendedor"
			                       value="{$claDesembolso->txtCertificacionVendedor}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			
			        <tr  id="13-ambos">
			            <td>Autorización de desembolso</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numAutorizacionDesembolso" 
			                       id="numAutorizacionDesembolso"
			                       value="{$claDesembolso->numAutorizacionDesembolso}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtAutorizacionDesembolso" 
			                       id="txtAutorizacionDesembolso"
			                       value="{$claDesembolso->txtAutorizacionDesembolso}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr  id="14-ambos">
			            <td>Fotocopia de la cedula del vendedor</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numFotocopiaVendedor" 
			                       id="numFotocopiaVendedor"
			                       value="{$claDesembolso->numFotocopiaVendedor}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtFotocopiaVendedor" 
			                       id="txtFotocopiaVendedor"
			                       value="{$claDesembolso->txtFotocopiaVendedor}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr {if $claDesembolso->txtTipoDocumentos != 'empresa'} style="display:none" {/if} id="15-empresa">
			            <td>Fotocopia RUT</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numRut" 
			                       id="numRut"
			                       value="{$claDesembolso->numRut}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtRut" 
			                       id="txtRut"
			                       value="{$claDesembolso->txtRut}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr {if $claDesembolso->txtTipoDocumentos != 'empresa'} style="display:none" {/if} id="16-empresa">
			            <td>Fotocopia RIT</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numRit" 
			                       id="numRit"
			                       value="{$claDesembolso->numRit}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtRit" 
			                       id="txtRit"
			                       value="{$claDesembolso->txtRit}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr {if $claDesembolso->txtTipoDocumentos != 'empresa'} style="display:none" {/if} id="17-empresa">
			            <td>Fotocopia NIT</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numNit" 
			                       id="numNit"
			                       value="{$claDesembolso->numNit}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtNit" 
			                       id="txtNit"
			                       value="{$claDesembolso->txtNit}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr id="18-ambos">
			            <td>Otros documentos</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numOtros" 
			                       id="numOtros"
			                       value="{$claDesembolso->numOtros}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="3"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtOtro" 
			                       id="txtOtro"
			                       value="{$claDesembolso->txtOtro}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			    </table>
			    
			{else} <!-- documentos para arrendamiento -->
			
			    <table cellpadding=2 cellspacing=0 border=0 width="100%" id="listadoDocumentos">
			        <tr>
			            <td class="tituloTabla" width="270px">Documento</td>
			            <td class="tituloTabla" width="50px">Folios</td>
			            <td class="tituloTabla">Observaciones</td>
			        </tr>
			
			        <!-- CONTRATO DE ARRENDAMIENTO -->
			        <tr id="1-ambos">
			            <td>Contrato de Arrendamiento</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numContratoArrendamiento" 
			                       id="numContratoArrendamiento"
			                       value="{$claDesembolso->numContratoArrendamiento}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="2"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtContratoArrendamiento" 
			                       id="txtContratoArrendamiento"
			                       value="{$claDesembolso->txtContratoArrendamiento}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			
			        <!-- CERTIFICADO DE APERTURA CUENTA DE AHORRO PROGRAMADO -->
			        <tr id="2-ambos">
			            <td>Certificado Apertura CAP</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numAperturaCAP" 
			                       id="numAperturaCAP"
			                       value="{$claDesembolso->numAperturaCAP}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="2"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtAperturaCAP" 
			                       id="txtAperturaCAP"
			                       value="{$claDesembolso->txtAperturaCAP}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			
			        <!-- CEDULA ARRENDADOR -->
			        <tr id=3-ambos">
			            <td>Cédula Arrendador</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numCedulaArrendador" 
			                       id="numCedulaArrendador"
			                       value="{$claDesembolso->numCedulaArrendador}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="2"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtCedulaArrendador" 
			                       id="txtCedulaArrendador"
			                       value="{$claDesembolso->txtCedulaArrendador}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			
			        <tr {if $claDesembolso->txtTipoDocumentos != 'empresa'} style="display:none" {/if} id="4-empresa">
			            <td>Fotocopia RUT</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numRut" 
			                       id="numRut"
			                       value="{$claDesembolso->numRut}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="2"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtRut" 
			                       id="txtRut"
			                       value="{$claDesembolso->txtRut}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr {if $claDesembolso->txtTipoDocumentos != 'empresa'} style="display:none" {/if} id="5-empresa">
			            <td>Fotocopia RIT</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numRit" 
			                       id="numRit"
			                       value="{$claDesembolso->numRit}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="2"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtRit" 
			                       id="txtRit"
			                       value="{$claDesembolso->txtRit}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			        <tr {if $claDesembolso->txtTipoDocumentos != 'empresa'} style="display:none" {/if} id="6-empresa">
			            <td>Fotocopia NIT</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numNit" 
			                       id="numNit"
			                       value="{$claDesembolso->numNit}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="2"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtNit" 
			                       id="txtNit"
			                       value="{$claDesembolso->txtNit}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			
			        <!-- CERTIFICACION CUENTA DEL ARRENDADOR -->
			        <tr id="7-ambos">
			            <td>Certificación Cuenta Arrendador</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numCuentaArrendador" 
			                       id="numCuentaArrendador"
			                       value="{$claDesembolso->numCuentaArrendador}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="2"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtCuentaArrendador" 
			                       id="txtCuentaArrendador"
			                       value="{$claDesembolso->txtCuentaArrendador}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			
			        <!-- TRES RECIBOS DE SERVICIOS PUBLICOS -->
			        <tr id="8-ambos">
			            <td>Tres Recibos de Servicios Públicos</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numServiciosPublicos" 
			                       id="numServiciosPublicos"
			                       value="{$claDesembolso->numServiciosPublicos}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="2"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtServiciosPublicos" 
			                       id="txtServiciosPublicos"
			                       value="{$claDesembolso->txtServiciosPublicos}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			
			        <!-- AUTORIZACION DE RETIRO DE RECURSOS -->
			        <tr id="9-ambos">
			            <td>Autorización de Retiro de Recursos</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numRetiroRecursos" 
			                       id="numRetiroRecursos"
			                       value="{$claDesembolso->numRetiroRecursos}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="2"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtRetiroRecursos" 
			                       id="txtRetiroRecursos"
			                       value="{$claDesembolso->txtRetiroRecursos}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			
			        <!-- CERTIFICADO DE TRADICION -->
			        <tr id="10-ambos">
			            <td>Certificado de tradici&oacute;n y libertad vigente</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numCertificadoTradicion" 
			                       id="numCertificadoTradicion"
			                       value="{$claDesembolso->numCertificadoTradicion}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="2"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtCertificadoTradicion" 
			                       id="txtCertificadoTradicion"
			                       value="{$claDesembolso->txtCertificadoTradicion}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			
			        <!-- BOLETIN NOMENCLATURA -->
			        <tr id="11-ambos">
			            <td>Bolet&iacute;n nomenclatura</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numBoletinCatastral" 
			                       id="numBoletinCatastral"
			                       value="{$claDesembolso->numBoletinCatastral}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="2"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtBoletinCatastral" 
			                       id="txtBoletinCatastral"
			                       value="{$claDesembolso->txtBoletinCatastral}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			
			        <!-- OTROS DOCUMENTOS -->
			        <tr id="12-ambos">
			            <td>Otros documentos</td>
			            <td align="center">
			                <input	type="text" 
			                       name="numOtros" 
			                       id="numOtros"
			                       value="{$claDesembolso->numOtros}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:40px"
			                       maxlength="2"
			                       />
			            </td>
			            <td>
			                <input	type="text" 
			                       name="txtOtros" 
			                       id="txtOtros"
			                       value="{$claDesembolso->txtOtro}"
			                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
			                       onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
			                       style="width:300px"
			                       class="inputLogin"
			                       />
			            </td>
			        </tr>
			
			    </table>

			{/if}
		</p></div>

<!-- PESTANA DE SEGUIMIENTO -->			
        <div id="seg" style="height:{$numAltura}; overflow:auto;"><p>
            {include file="seguimiento/seguimientoFormulario.tpl"}
            <p><div id="contenidoBusqueda">
                {include file="seguimiento/buscarSeguimiento.tpl"}
            </div></p>
        </p></div>	

<!-- PESTANA ACTOS ADMINISTRATIVOS -->	        
		<div id="aad" style="height:{$altura};"><p>
		        {include file="subsidios/actosAdministrativos.tpl"}
		</p></div>
	</div>
</div>

<!-- NO BORRAR, ESTE DIV ACTIVA EL TABVIEW -->
<div id="seguimiento"></div>
<div id="barrioListener"></div>
