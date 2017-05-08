	
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		{assign var=txtFlujo value=$arrFlujoHogar.flujo}
		{assign var=txtFase  value=$arrFlujoHogar.fase}
		{assign var=txtClase value='msgOk'}
		{foreach from=$claFlujoDesembolsos->arrFases.$txtFlujo key=txtFaseDesembolso item=arrFasesDesembolso}
			<tr><td class="{$txtClase}"
				style="cursor:pointer"
				onMouseOver="this.style.background='#FFFFFF'"
				onMouseOut="this.style.background='#E4E4E4'"
				onClick="javasript: cambiarFase(
						'contenidoFases',
						'imprimirFase',
						'{$arrFasesDesembolso.codigo}',
						'{$arrFasesDesembolso.imprimir}',
                        '{$txtFaseDesembolso}',
						'seqFormulario={$seqFormulario}&cedula={$cedula}&flujo={$txtFlujo}&fase={$txtFaseDesembolso}'								
					);
				"
			>
				{$arrFasesDesembolso.nombre}
			</td></tr>		
			{if $txtFaseDesembolso == $arrFlujoHogar.fase} 
				{assign var=txtClase value='msgError'}
			{/if}
		{/foreach}
	</table>