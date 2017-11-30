<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" >
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="title" content="Subsidios de Vivienda">
		<meta name="keywords" content="subsidio,vivienda,social,prioritaria,bogota,habitat,asignacion,credito" />
		<meta name="description" content="Sistema de informacion de subsidios de vivienda">
		<meta http-equiv="Content-Language" content="es">
		<meta name="robots" content="index,  nofollow" />

		<title>SDV - SDHT</title>

		<!-- INCLUSIONES CSS -->
		<link rel="stylesheet" type="text/css" href="./recursos/estilos/sdht.css" />
		<link rel="stylesheet" type="text/css" href="./librerias/yui/button/assets/skins/sam/button.css" />
		<link rel="stylesheet" type="text/css" href="./librerias/yui/container/assets/skins/sam/container.css" />
		<link rel="stylesheet" type="text/css" href="./librerias/yui/calendar/assets/skins/sam/calendar.css" />
		<link rel="stylesheet" type="text/css" href="./librerias/yui/treeview/assets/skins/sam/treeview.css" />

		<!-- INCLUSIONES JAVASCRIPT -->
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/yahoo-dom-event/yahoo-dom-event.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/element/element-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/connection/connection-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/dom/dom-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/dragdrop/dragdrop-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/event/event-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/animation/animation-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/container/container-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/button/button-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/menu/menu-min.js" ></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/calendar/calendar-min.js" ></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/tabview/tabview-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/cookie/cookie-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/paginator/paginator-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/datasource/datasource-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/datatable/datatable-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/autocomplete/autocomplete-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/json/json-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/swf/swf-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/charts/charts-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/yui/treeview/treeview-min.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/javascript/encripcion.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/javascript/funciones.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/javascript/funcionesProyectos.js"></script>
		<script language="JavaScript" type="text/javascript" src="./librerias/javascript/listeners.js"></script>

		<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

	</head>

	<!-- APENAS SE CARGA EJECUTA ESTE LLAMADO ES PODSIBLE QUE NO SE REQUIERA EN LA PLANTILLA DEFINITIVA -->
	<body class="yui-skin-sam" onLoad="cargarContenido( 'contenido' , './contenidos/administracion/administracionInicial.php', '', true );"> 
		<center>
		<table cellpadding="0" cellspacing="0" border="0" width="780px" height="95%" bgcolor="#F9F9F9">

			<!-- BANNER NEGRO -->
			<tr><td colspan="2" height="32px">
				<img src="{$txtRutaImagenes}bannerNegro.png" />
			</td></tr>
			
			<!-- IMAGEN SUBSIDIO DE VIVIENDA -->
			<tr>
				<td rowspan="2" width="17%" height="46px">
					<img src="{$txtRutaImagenes}subsidiodvgeneral.jpg" />
				</td>
				<td height="10px"></td>
			</tr>
			
			<!-- COLOR QUE COMPLEMENTA EL RENGLON DE SUBSIDIOS DE VIVIENDA -->
			<tr>
				<td bgcolor="#008FA6" align="right" align="bottom" style="padding-bottom:5px;">
					<a href="#" onClick="location.href = './autenticacion.php' " class="salir">Abandonar Sesión</a> 
				</td>
			</tr>
			
			<!-- MENSAJES -->
			<tr>
				<td colspan="2" id="mensajes" height="25px">&nbsp;</td> 
			</tr>
			
			<!-- CONTENIDO -->
			<tr>
				<td height="100%"  colspan="2" id="contenido" align="center" valign="top"> contenido
				</td>
			</tr>
			
			<!-- PIE DE PAGINA -->
			<tr>
				<td rowspan="2" width="134px">
					<img src="{$txtRutaImagenes}bta_positiva.jpg" />
				</td>
				<td height="20px" background="{$txtRutaImagenes}background_menupie.png">
					&nbsp;
				</td>
			</tr>
			
			<!-- DIRECCION DEL PIE DE PAGINA -->
			<tr>
				<td align="center" valign="middle">
					Calle 52 No. 13-64, Bogot&aacute D.C., Colombia. <br>
					PBX (571) 381 3000.
				</td>
			</tr>

		</table>

		</center>
		
	</body>
</html>