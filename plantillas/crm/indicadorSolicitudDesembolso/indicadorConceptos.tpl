
	{if $numProyecto eq "644"}
		{ assign var=txtDivDataTable	value="txtDivConcepto644DataTable" }
	{elseif $numProyecto eq "488"}
		{ assign var=txtDivDataTable	value="txtDivConcepto488DataTable" }
	{/if}
	
	<div id="{$txtDivDataTable}"></div>