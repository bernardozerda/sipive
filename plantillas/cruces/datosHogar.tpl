
<!-- DECLARACION DE VARIABLES PARA USAR EN LA PLANTILLA -->
{assign var=seqModalidad     	  value=$claFormulario->seqModalidad}
{assign var=seqSolucion      	  value=$claFormulario->seqSolucion}	
{assign var=seqLocalidad     	  value=$claFormulario->seqLocalidad}
{assign var=seqBancoAhorro   	  value=$claFormulario->seqBancoCuentaAhorro}
{assign var=seqBancoAhorro2  	  value=$claFormulario->seqBancoCuentaAhorro2}
{assign var=seqBancoCredito  	  value=$claFormulario->seqBancoCredito}
{assign var=seqEstadoProceso 	  value=$claFormulario->seqEstadoProceso}
{assign var=seqBancoCuentaAhorro  value=$claFormulario->seqBancoCuentaAhorro}
{assign var=seqBancoCuentaAhorro2 value=$claFormulario->seqBancoCuentaAhorro2}
{assign var=seqBancoCredito       value=$claFormulario->seqBancoCredito}
{assign var=seqEntidadDonante     value=$claFormulario->seqEmpresaDonante}
{assign var=bolDesplazado         value=$claFormulario->bolDesplazado}


<p><div style="background-color: white; height:25px; padding-top:10px;">
    <strong>ESTADO DEL PROCESO:</strong> {$arrEstados.$seqEstadoProceso}
</div></p>
<div>
<!-- DATOS BASICOS DEL HOGAR -->    
<p><table cellpadding="3" cellspacing="0" border="0" width="98%" bgcolor="#FFFFFF" style="border: 1px dotted #666666;">
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
	        <th>Valor Subsidio</th>
	        <td colspan="5">$ {$claFormulario->valAspiraSubsidio|number_format:0:',':'.'}</td>
		</tr>
	</table></p>

<!--
	DATOS DEL HOGAR 
-->		
<p><table cellpadding="3" cellspacing="0" border="0" width="98%" bgcolor="#FFFFFF" style="border: 1px dotted #666666;">
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
	            <td>{$arrParentesco.$seqParentesco}</td>
	            <td>{$arrTipoDocumento.$seqTipoDocumento|utf8_decode|lower|ucwords|utf8_encode}</td>
				<td>{$objCiudadano->numDocumento}</td>
	            <td>
	                {$objCiudadano->txtNombre1} {$objCiudadano->txtNombre2}
	                {$objCiudadano->txtApellido1} {$objCiudadano->txtApellido2}
	            </td>
	        </tr>
	    {/foreach}
	</table></p>

<!-- 
        DATOS FINANCIEROS 
-->		
<p><table cellpadding="3" cellspacing="0" border="0" width="98%" bgcolor="#FFFFFF" style="border: 1px dotted #666666;">
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
	</table></p>
</div>