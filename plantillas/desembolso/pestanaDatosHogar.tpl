	
<!-- 
        CONTENIDO DE LA PESTA�A "DATOS DEL HOGAR"
        MUESTRA INFORMACION BASICA DEL HOGAR Y
        CONTIENE EL SELECT DE CAMBIOS DE ESTADO DEL PROCESO
-->

<!-- 
        TABLA PARA ESTADO DEL PROCESO Y DATOS DEL REGISTRO 
-->

	<!-- VARIABLES PARA FACILITAR EL ACCESO A LOS DATOS -->
	{assign var=txtFlujo value=$arrFlujoHogar.flujo}
	{assign var=txtFase  value=$arrFlujoHogar.fase}
	<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
	    <tr>
	        <td width="140px" valign="middle"><b>Estado del Proceso:</b></td>
	        <td valign="middle" width="315px" align="center">
                {if in_array( $claFormulario->seqEstadoProceso , $claFlujoDesembolsos->arrFases.$txtFlujo.$txtFase.adelante )}
                    <select name="seqEstadoProceso" 
                            id="seqEstadoProceso"
                            onFocus="this.style.backgroundColor = '#ADD8E6';" 
                            onBlur="this.style.backgroundColor = '#FFFFFF';"
                            style="width:305px"
                    >    
                        <!-- ESTADOS DEL PROCESO DE RETORNO -->
                        {if not empty( $claFlujoDesembolsos->arrFases.$txtFlujo.$txtFase.atras )}
                            <optgroup label="Retorno">
                                {foreach from=$claFlujoDesembolsos->arrFases.$txtFlujo.$txtFase.atras item=seqEstado}
                                    <option value="{$seqEstado}">{$arrEstados.$seqEstado}</option>	
                                {/foreach}
                            </optgroup>
                        {/if}

                        <!-- ESTADOS DEL PROCESO DE AVANCE -->
                        <optgroup label="Avance">
                            {foreach from=$claFlujoDesembolsos->arrFases.$txtFlujo.$txtFase.adelante item=seqEstado}
                                <option value="{$seqEstado}"
                                    {if $seqEstado == $claFormulario->seqEstadoProceso} selected {/if}
                                >
                                    {$arrEstados.$seqEstado}
                                </option>
                            {/foreach}
                        </optgroup>
                    </select>
				{else}
                    {assign var=seqEstado value=$claFormulario->seqEstadoProceso}
                    <div style="width:100%; text-align: left;">
                        {$arrEstados.$seqEstado}
                        <input	type="hidden" 
                                name="seqEstadoProceso" 
                                id="seqEstadoProceso" 
                                value="{$seqEstado}"
                         />
                    </div>
                {/if}
			</td>
			<td>
			    {if $txtFase == "busquedaOferta"}
			        {assign var=fchCreacion      value=$claDesembolso->fchCreacionBusquedaOferta}
			        {assign var=fchActualizacion value=$claDesembolso->fchActualizacionBusquedaOferta}
			    {/if}
			    {if $txtFase == "revisionJuridica"}
			    	{assign var=fchCreacion      value=$claDesembolso->arrJuridico.fchCreacion}
			        {assign var=fchActualizacion value=$claDesembolso->arrJuridico.fchActualizacion}
			    {/if}
			    {if $txtFase == "revisionTecnica"}
			    	{assign var=fchCreacion      value=$claDesembolso->arrTecnico.fchCreacion}
			        {assign var=fchActualizacion value=$claDesembolso->arrTecnico.fchActualizacion}
			    {/if}
			    {if $txtFase == "escrituracion"}
			    	{if esFechaValida( $claDesembolso->fchCreacionEscrituracion )}
			        	{assign var=fchCreacion value=$claDesembolso->fchCreacionEscrituracion}
			        {/if}
			        {if esFechaValida( $claDesembolso->fchActualizacionEscrituracion )}
			        	{assign var=fchActualizacion value=$claDesembolso->fchActualizacionEscrituracion}
			        {/if}	        
			    {/if}
			    {if $txtFase == "estudioTitulos"}
			    	{assign var=fchCreacion      value=$claDesembolso->arrTitulos.fchCreacion}
			        {assign var=fchActualizacion value=$claDesembolso->arrTitulos.fchActualizacion}
			    {/if}
			    
			    <!-- FECHAS DE CREACION Y ACTUALIZACION DE CADA FASE DE DESEMBOLSO -->
			    {assign var=txtFormatoFecha value="%d de %B de %Y a las %H:%M:%S"}
		        <b>Creado en:</b>      {$fchCreacion|date_format:$txtFormatoFecha|ucwords|utf8_encode}     <br>
		        <b>Actualizado en:</b> {$fchActualizacion|date_format:$txtFormatoFecha|ucwords|utf8_encode}<br>
			    <b>Tutor Asignado:</b> {$txtTutor}
			</td>
		</tr>
	</table>

<!--
	TABLA PARA LOS DATOS BASICOS DEL FORMULARIO
-->

	<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
	    <tr><td colspan="6" class="tituloTabla">DATOS BASICOS DEL FORMULARIO</td></tr>
	    <tr align="left">
	        <th width="110px">No Formulario</th>
	        <td width="80px">{$claFormulario->txtFormulario}</td>
	        <th width="80px">Modalidad</th>
	        <td width="180px">{$arrModalidad.$seqModalidad|utf8_decode|lower|ucwords|utf8_encode}</td>
	        <th width="80px">Soluci&oacute;n</th>
	        <td>
	        	{$arrSolucionDescripcion.$seqModalidad.$seqSolucion|utf8_decode|upper|utf8_encode}
	            ({$arrSolucion.$seqModalidad.$seqSolucion|utf8_decode|lower|ucwords|utf8_encode})
	        </td>
	    </tr>
	    <tr align="left">
	        <th>Tel&eacute;fono 1</th>
	        <td>{$claFormulario->numTelefono1}</td>
	        <th>Tel&eacute;fono 2</th>
	        <td>{$claFormulario->numTelefono2}</td>
	        <th>Celular</th>
	        <td>{$claFormulario->numCelular}</td>
	    </tr>
	    <tr align="left">
	        <th>Barrio</th>
	        <td colspan="3">{$claFormulario->txtBarrio|utf8_decode|lower|ucwords|utf8_encode}</td>
	        <th>Localidad</th>
	        <td>{$arrLocalidad.$seqLocalidad|utf8_decode|lower|ucwords|utf8_encode}</td>
	    </tr>
	    <tr align="left">
	        <th>Direcci&oacute;n</th>
	        <td colspan="5">{$claFormulario->txtDireccion|upper}</td>
	    </tr>
	    <tr align="left">
			<th>Correo Electr&oacute;nico</th>
			<td colspan="5">{$claFormulario->txtCorreo}</td>
	    </tr>
		<tr align="left">
	        <th>{if $claFormulario->seqPlanGobierno == 2}Valor Subsidio{else}Valor estimado del aporte{/if}</th>
	        <td colspan="5">$ {$claFormulario->valAspiraSubsidio|number_format:0:',':'.'}</td>
		</tr>
		<tr align="left">
            <th>{if $claFormulario->seqPlanGobierno == 2}Vigencia Subsidio{else}Vigencia del aporte{/if}</th>
            <td colspan="5">
            	{assign var=txtFormatoFecha value="%d de %B de %Y"}
                {if $claFormulario->fchVigencia != '0000-00-00'}
            	{$claFormulario->fchVigencia|date_format:$txtFormatoFecha|ucwords|utf8_encode}
                {else}{$claFormulario->fchVigencia}
				{/if}
                
            </td>
	    </tr>
		<tr align="left">
			<th>Desplazamiento Forzado</th>
			<td colspan="5">
				{if $claFormulario->bolDesplazado == 0} 
					NO
				{else}
					SI
				{/if}
			</td>
	    </tr>
	</table>

<!--
	DATOS DEL HOGAR 
-->		
	<table cellpadding="2" cellspacing="0" border="0" width="100%"  bgcolor="#FFFFFF">
	    <tr><td colspan="6" class="tituloTabla">DATOS DEL HOGAR</td></tr>
	    <tr align="left">
	        <th bgcolor="#F0F0F0">Parentesco</td>
	        <th bgcolor="#F0F0F0">Tipo Documento</td>
	        <th bgcolor="#F0F0F0">Documento</td>
	        <th bgcolor="#F0F0F0">Nombre</td>
	    </tr>
	    {foreach from=$claFormulario->arrCiudadano key=seqCiudadano item=objCiudadano}
	        {assign var=seqTipoDocumento value=$objCiudadano->seqTipoDocumento}
	        {assign var=seqParentesco value=$objCiudadano->seqParentesco}
	        <tr>
	            <td>{$arrParentesco.$seqParentesco.txtParentesco}</td>
	            <td>{$arrTipoDocumento.$seqTipoDocumento|utf8_decode|lower|ucwords|utf8_encode}</td>
				<td>{$objCiudadano->numDocumento}</td>
	            <td>
	                {$objCiudadano->txtNombre1} {$objCiudadano->txtNombre2}
	                {$objCiudadano->txtApellido1} {$objCiudadano->txtApellido2}
	            </td>
	        </tr>
	    {/foreach}
	</table>

<!-- 
        DATOS FINANCIEROS 
-->		
	<table cellpadding="2" cellspacing="0" border="0" width="100%"  bgcolor="#FFFFFF">
	    <tr>
	    	<td colspan="6" class="tituloTabla">DATOS FINANCIEROS</td>
	    </tr>
	    <tr>
	        <td width="200px"><b>Valor del Ahorro 1</b> {$arrBanco.$seqBancoCuentaAhorro|utf8_decode|lower|ucwords|utf8_encode}</td>
	        <td width="150px" align="right">$ {$claFormulario->valSaldoCuentaAhorro|number_format:0:',':'.'}</td>
	        <td width="20px">&nbsp;</td>
	        <td width="200px"><b>Valor del Ahorro 2</b> {$arrBanco.$seqBancoCuentaAhorro2|utf8_decode|lower|ucwords|utf8_encode}</td>
	        <td width="150px" align="right">$ {$claFormulario->valSaldoCuentaAhorro2|number_format:0:',':'.'}</td>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td><b>Valor del Cr&eacute;dito</b> {$arrBanco.$seqBancoCredito|utf8_decode|lower|ucwords|utf8_encode}</td>
	        <td align="right">$ {$claFormulario->valCredito|number_format:0:',':'.'}</td>
	        <td>&nbsp;</td>
	        <td><b>Subsidio Nacional</b></td>
	        <td align="right">$ {$claFormulario->valSubsidioNacional|number_format:0:',':'.'}</td>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td><b>Valor de Cesant&iacute;as</b></td>
	        <td align="right">$ {$claFormulario->valSaldoCesantias|number_format:0:',':'.'}</td>
	        <td>&nbsp;</td>
	        <td><b>Aporte Lote o Terreno</b></td>
	        <td align="right">$ {$claFormulario->valAporteLote|number_format:0:',':'.'}</td>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td><b>Aporte Avance Obra</b></td>
	        <td align="right">$ {$claFormulario->valAporteAvanceObra|number_format:0:',':'.'}</td>
	        <td>&nbsp;</td>
	        <td><b>Aporte Materiales</b></td>
	        <td align="right">$ {$claFormulario->valAporteMateriales|number_format:0:',':'.'}</td>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td><b>Donaci&oacute;n</b> {$arrDonantes.$seqEntidadDonante}</td>
	        <td align="right">$ {$claFormulario->valDonacion|number_format:0:',':'.'}</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td bgcolor="#E4E4E4" colspan="6">
	        	<b>Total Recursos Econ&oacute;micos:</b> $ {$claFormulario->valTotalRecursos|number_format:0:',':'.'}
	        </td>
	    </tr>
	</table>