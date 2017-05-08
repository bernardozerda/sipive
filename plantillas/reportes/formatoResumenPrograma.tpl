<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" >
	<head>
	
		<!-- INCLUSIONES CSS -->
		<link rel="stylesheet" type="text/css" href="../../recursos/estilos/sdht.css" />
		<link rel="stylesheet" type="text/css" href="../../librerias/yui/datatable/assets/skins/sam/datatable.css">
		
		<!-- 
		<link rel="stylesheet" type="text/css" href="../../librerias/yui/container/assets/skins/sam/container.css" />
		<link rel="stylesheet" type="text/css" href="../../librerias/yui/button/assets/skins/sam/button.css" />
		<link rel="stylesheet" type="text/css" href="../../librerias/yui/menu/assets/skins/sam/menu.css" />
		<link rel="stylesheet" type="text/css" href="../../librerias/yui/tabview/assets/skins/sam/tabview.css">
		<link rel="stylesheet" type="text/css" href="../../librerias/yui/paginator/assets/skins/sam/paginator.css">
		<link rel="stylesheet" type="text/css" href="../../librerias/yui/autocomplete/assets/skins/sam/autocomplete.css">
		-->
		
		<!-- INCLUSIONES JAVASCRIPT -->	
		
		<script language="JavaScript" type="text/javascript" src="../../librerias/yui/yahoo-dom-event/yahoo-dom-event.js"></script>
		<script language="JavaScript" type="text/javascript" src="../../librerias/yui/element/element-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="../../librerias/yui/datasource/datasource-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="../../librerias/yui/json/json-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="../../librerias/yui/swf/swf-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="../../librerias/yui/connection/connection-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="../../librerias/yui/charts/charts-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="../../librerias/yui/container/container-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="../../librerias/yui/datatable/datatable-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="../../librerias/yui/get/get-min.js"></script>
		 
				
		<script language="JavaScript" type="text/javascript" src="../../librerias/javascript/funciones.js"></script>
		<script language="JavaScript" type="text/javascript" src="../../librerias/javascript/listenerIndex.js"></script>
		
		
		
		
	</head>
	<body class="yui-skin-sam" id="bodyHtml" topMargin="0" >
		<!-- 
		<div>
		Gráfica {$txtDivGraficas}
		</div>
		-->
		<br /><br /><br />
		
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
		
			<tr>
				<td align="center"><span class="tituloReportesImprimir">{$txtTituloGrafica}<span><br /></td>
			</tr>
			<tr>
				<td><br /><div class="chartGraficasImprimir" id="{$txtDivGraficas}" /><br /></td>
			</tr>
			<tr>
				<td align="center"><br /><div id="{$txtDivGraficas}_tabla" /></td>
			</tr>
			<tr>
				<td align="right">{$smarty.now|date_format:"%A, %B %e, %Y"}</td>
			</tr>
		
		</table>
		
		<!-- <div class="chartGraficasImprimir" id="{$txtDivGraficas}" ></div> -->
		
		<div style="display:none" id="objGraficas">{$txtGraficas}</div>
		<div id="objGraficasImprimirBorrar"></div>
		<div id="objGraficasTablasBorrar"></div>
		<div id="GraficasImprimir"></div>
		
		
	</body> 
</html>