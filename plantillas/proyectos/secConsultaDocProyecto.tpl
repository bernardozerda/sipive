<table border="0">
	<tr><td class="tituloTabla" colspan="3">DOCUMENTOS REQUERIDOS DEL PROYECTO PARA EL PRIMER DESEMBOLSO</td></tr>
	<tr class="tituloTabla">
		<th width="5%" align="center" style="padding:6px;">Anex&oacute;</th>
		<th width="55%" align="center" style="padding:6px;">Documento</th>
		<th width="40%" align="center" style="padding:6px;">Observac&oacute;n</th>
	</tr>
	<tr class="fila_0">
		<td valign="top" align="center" style="padding:6px;">{if $objFormularioProyecto->chkDocDesemProyecto1 == "1"} Si {else} No {/if}</td>
		<td valign="top" align="justify" style="padding:6px;">Copia de Acta Comit&eacute; de elegibilidad</td>
		<td valign="top" style="padding:6px;">{$objFormularioProyecto->txtDocDesemProyecto1}</td>
	</tr>
	<tr class="fila_1">
		<td valign="top" align="center" style="padding:6px;">{if $objFormularioProyecto->chkDocDesemProyecto2 == "1"} Si {else} No {/if}</td>
		<td valign="top" align="justify" style="padding:6px;">Copia Resolución Aprobación Comité de Elegibilidad</td>
		<td valign="top" style="padding:6px;">{$objFormularioProyecto->txtDocDesemProyecto2}</td>
	</tr>
	<tr class="fila_0">
		<td valign="top" align="center" style="padding:6px;">{if $objFormularioProyecto->chkDocDesemProyecto3 == "1"} Si {else} No {/if}</td>
		<td valign="top" align="justify" style="padding:6px;">Copia de Contrato de Interventor&iacute;a, con una persona natural o jur&iacute;dica de la lista de profesionales inscritos en el Consejo Profesional Nacional de Ingenier&iacute;a y Arquitectura, para estos efectos, el contrato de interventor&iacute;a, podr&aacute; se rel mismo de los desembolsos de recursos del cr&eacute;dito constructor o hipotecario.</td>
		<td valign="top" style="padding:6px;">{$objFormularioProyecto->txtDocDesemProyecto3}</td>
	</tr>
	<tr class="fila_1">
		<td valign="top" align="center" style="padding:6px;">{if $objFormularioProyecto->chkDocDesemProyecto4 == "1"} Si {else} No {/if}</td>
		<td valign="top" align="justify" style="padding:6px;">Certificado de Tradici&oacute;n  y Libertad del terreno en el que se verifique la propiedad y que se encuentre libre de cualquier tipo de gravamen, excepto por la hipoteca a favor de la entidad que financia el proyecto, en caso tal que se encunetre con cr&eacute;dito hipotecario constructor.</td>
		<td valign="top" style="padding:6px;">{$objFormularioProyecto->txtDocDesemProyecto4}</td>
	</tr>
	<tr class="fila_0">
		<td valign="top" align="center" style="padding:6px;">{if $objFormularioProyecto->chkDocDesemProyecto5 == "1"} Si {else} No {/if}</td>
		<td valign="top" align="justify" style="padding:6px;">Los estudios de factibilidad y el presupuesto del proyecto, en el formato que para el efecto disponga la Subsecretar&iacute;a de Coordinaci&oacute;n operativa a trav&eacute;s de la Subdirecci&oacute;n de Apoyo a la Construcci&oacute;n.</td>
		<td valign="top" style="padding:6px;">{$objFormularioProyecto->txtDocDesemProyecto5}</td>
	</tr>
	<tr class="fila_1">
		<td valign="top" align="center" style="padding:6px;">{if $objFormularioProyecto->chkDocDesemProyecto6 == "1"} Si {else} No {/if}</td>
		<td valign="top" align="justify" style="padding:6px;">Copia contrato encargo fiduciario.</td>
		<td valign="top" style="padding:6px;">{$objFormularioProyecto->txtDocDesemProyecto6}</td>
	</tr>
</table>