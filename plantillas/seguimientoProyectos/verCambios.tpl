
<div style='height:{$numAlto}; overflow:auto;'>		
	<table cellspacing="0" cellspacing="0" border="0" width="100%" style="font-size:7px">
		{foreach from=$arrLineas item=arrItem}
			<tr> {cycle name=lineas values="#FFFFFF,#E4E4E4" assign=color}
				{foreach name=celdas from=$arrItem item=txtValor}
					<td style="border-right: 1px dotted #999999" 
						bgcolor="{$color}" 
						valign="top"
						{if $arrItem|@count == 1} colspan="3" {/if}
						{if $smarty.foreach.celdas.first } width="30%" {else} width="35%" {/if}
					>
						{$txtValor}
					</td>
				{/foreach}
			</tr>
		{/foreach}
	</table>
</div>
	





