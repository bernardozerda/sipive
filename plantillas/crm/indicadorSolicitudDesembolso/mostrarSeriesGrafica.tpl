
	<table cellpadding="1" cellspacing="0" border="0" width="60%" align="center"  >
		{foreach from=$arrNombreSeries key=numLlave item=txtNombreSerieMostrar}
			<tr>
				<td bgcolor="{cycle name=c1 values="#F0F0F0 , #FFFFFF"}">{$txtNombreSerieMostrar}</td>
				<td bgcolor="{cycle name=c2 values="#F0F0F0 , #FFFFFF"}"><input 
						type="checkbox" 
						checked
						onclick='mychartMostrar.setSeriesStylesByIndex(
							{$numLlave}
							{literal}
							 ,{visibility:this.checked?"visible":"hidden"} );'
							{/literal}
							>
						</td>
				
			</tr>
		{/foreach}
</table>
	