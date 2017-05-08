<table border="0">
	<tr><td class="tituloTabla" colspan="3">DOCUMENTOS REQUERIDOS DE LA CONSTRUCTORA PARA EL PRIMER DESEMBOLSO</td></tr>
	<tr class="tituloTabla">
		<th width="5%" align="center" style="padding:6px;">Anex&oacute;</th>
		<th width="55%" align="center" style="padding:6px;">Documento</th>
		<th width="40%" align="center" style="padding:6px;">Observac&oacute;n</th>
	</tr>
	<tr class="fila_0">
		<td valign="top" align="center" style="padding:6px;">{if $objFormularioProyecto->chkDocDesemConstructor1 == "1"} Si {else} No {/if}</td>
		<td valign="top" align="justify" style="padding:6px;">Copia C&eacute;dula de Ciudadan&iacute;a del Representante Legal.</td>
		<td valign="top" style="padding:6px;">{$objFormularioProyecto->txtDocDesemConstructor1}</td>
	</tr>
	<tr class="fila_1">
		<td valign="top" align="center" style="padding:6px;">{if $objFormularioProyecto->chkDocDesemConstructor2 == "1"} Si {else} No {/if}</td>
		<td valign="top" align="justify" style="padding:6px;">Copia del Registro &Uacute;nico Tributario - RUT.</td>
		<td valign="top" style="padding:6px;">{$objFormularioProyecto->txtDocDesemConstructor2}</td>
	</tr>
	<tr class="fila_0">
		<td valign="top" align="center" style="padding:6px;">{if $objFormularioProyecto->chkDocDesemConstructor3 == "1"} Si {else} No {/if}</td>
		<td valign="top" align="justify" style="padding:6px;">Copia del Registro de Identificaci&oacute;n Tributaria - RIT.</td>
		<td valign="top" style="padding:6px;">{$objFormularioProyecto->txtDocDesemConstructor3}</td>
	</tr>
	<tr class="fila_1">
		<td valign="top" align="center" style="padding:6px;">{if $objFormularioProyecto->chkDocDesemConstructor4 == "1"} Si {else} No {/if}</td>
		<td valign="top" align="justify" style="padding:6px;">C&aacute;mara y Comercio</td>
		<td valign="top" style="padding:6px;">{$objFormularioProyecto->txtDocDesemConstructor4}</td>
	</tr>
	<tr class="fila_0">
		<td valign="top" align="center" style="padding:6px;">{if $objFormularioProyecto->chkDocDesemConstructor5 == "1"} Si {else} No {/if}</td>
		<td valign="top" align="justify" style="padding:6px;">Copia del contrato de obra celebrado con el constructor, salvo que en el contrato de fiducia se encuentren las obligaciones de cada una de las partes respecto de la construcci&oacute;n de las viviendas.</td>
		<td valign="top" style="padding:6px;">{$objFormularioProyecto->txtDocDesemConstructor5}</td>
	</tr>
</table>