	
	{if $numProyecto eq "644"}
		{ assign var=txtDivDataTable	value="txtDivVigenciaResolucion644DataTable" }
	{elseif $numProyecto eq "488"}
		{ assign var=txtDivDataTable	value="txtDivVigenciaResolucion488DataTable" }
	{/if}
	
	<div id="{$txtDivDataTable}"></div>
