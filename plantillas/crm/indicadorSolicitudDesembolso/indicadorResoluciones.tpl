
	{if $numProyecto eq "644"}
		{ assign var=txtJsResolucion 	value=$claCrm->txtProyecto644JS }
		{ assign var=txtDivChart 		value="GraficaCDPEjecutado644" }
		{ assign var=txtDivDataTable	value="txtDivRes644DataTable" }
		{ assign var=txtDivColumnas 	value="GraficaTotal644" }
	{elseif $numProyecto eq "488"}
		{ assign var=txtJsResolucion 	value=$claCrm->txtProyecto488JS }
		{ assign var=txtDivChart 		value="GraficaCDPEjecutado488" }
		{ assign var=txtDivColumnas 	value="GraficaTotal488" }
		{ assign var=txtDivDataTable	value="txtDivRes488DataTable" }
	{/if}
	
	<a href="#" onclick="agrandarIndicadorResoluciones{$numProyecto}( );">Agrandar</a>
	<div id="{$txtDivDataTable}"></div>
	<br /><br />
	<a href="#" onclick="agrandarIndicadorResolucionesTotales{$numProyecto}( );">Agrandar</a>
	<div id="{$txtDivColumnas}"></div>
	<br /><br />
	<a href="#" onclick="agrandarIndicadorResolucionesCDPEjecutado{$numProyecto}( );">Agrandar</a>
	<div id="{$txtDivChart}"></div> 
	