<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es-Es" >
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="title" content="Subsidios de Vivienda">
            <meta name="keywords" content="subsidio,vivienda,social,prioritaria,bogota,habitat,asignacion,credito" />
            <meta name="description" content="Sistema de informacion de subsidios de vivienda"/>
            <meta http-equiv="Content-Language" content="es"/>
            <meta name="robots" content="index,  nofollow" />

            <title>PIVE</title>

            <!-- INCLUSIONES CSS -->		
            <link rel="stylesheet" type="text/css" href="./recursos/estilos/sdht.css" />
            <link rel="stylesheet" type="text/css" href="./recursos/estilos/proyectos.css" />
            <link rel="stylesheet" type="text/css" href="./librerias/yui/container/assets/skins/sam/container.css" />
            <link rel="stylesheet" type="text/css" href="./librerias/yui/button/assets/skins/sam/button.css" />
            <link rel="stylesheet" type="text/css" href="./librerias/yui/menu/assets/skins/sam/menu.css" />
            <link rel="stylesheet" type="text/css" href="./librerias/yui/calendar/assets/skins/sam/calendar.css" />
            <link rel="stylesheet" type="text/css" href="./librerias/yui/tabview/assets/skins/sam/tabview.css"/>
            <link rel="stylesheet" type="text/css" href="./librerias/yui/datatable/assets/skins/sam/datatable.css"/>
            <link rel="stylesheet" type="text/css" href="./librerias/yui/paginator/assets/skins/sam/paginator.css"/>
            <link rel="stylesheet" type="text/css" href="./librerias/yui/autocomplete/assets/skins/sam/autocomplete.css"/>
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
            <script language="JavaScript" type="text/javascript" src="./librerias/javascript/funciones.js"></script>
            <script language="JavaScript" type="text/javascript" src="./librerias/javascript/funcionesSubsidios.js"></script>
            <script language="JavaScript" type="text/javascript" src="./librerias/javascript/marquee.js"></script>
            <script language="JavaScript" type="text/javascript" src="./librerias/javascript/listenerIndex.js"></script>
            <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
            <script src="librerias/jquery/jquery.dataTables.min.js"></script>
            <script src="librerias/jquery/dataTables.bootstrap.min.js"></script>
            {*<link rel="stylesheet" href="recursos/estilos/jquery-ui.css"/> *}

            <link rel="stylesheet" href="librerias/jquery/css/dataTables.bootstrap.min.css"/> 
    </head>
    <body class="yui-skin-sam" id="bodyHtml" topMargin="0"> 

        <center>

            <table cellpadding="0" cellspacing="0" border="0" width="900px" bgcolor="#F9F9F9">

                <!-- BANNER NEGRO -->
                <!--<tr>
                   
                    <td height="22px" colspan="3" >
                        <img src="{$txtRutaImagenes}logoBogota.png" />
                    </td></tr>-->

                <!-- CABEZOTE -->			
                <tr>
                    <td>
                        <div style="position: relative; top: 10px; height: 80px; width: 900px"><img src="./recursos/imagenes/cabezote_ws.png" width="900px">
                                <div id="rutaMenu" style="position: absolute; width: 30%; float: left; top: 8px;left: 10%;"> 
                                    <span class="menuLateral" >Inicio: {$txtRutaInicio}</span></div>
                                <div style="position: absolute; width: 30%; float: left; top: 5px;left:41%;"> <b><i>En sesión:</b> {$txtNombreUsuario}</i></div>   
                                <div style="position: absolute; width: 24%; float: left; top: 1px;left:93%;">
                                    <a href="#" onClick="location.href = './autenticacion.php'" >
                                        <img src="./recursos/imagenes/Logout.png" />
                                    </a>
                                </div> 
                                <div></div>

                        </div>
                    </td>
                    <!-- <td rowspan="2" valign="bottom" >
                         <img src="{$txtRutaImagenes}logoPive.png" align="center" onClick="location.reload(true);" style="cursor:pointer;"/>
                     </td>
                     <td id="rutaMenu" height="20px" valign="middle"  style="padding-left: 20px;">
                         <span class="menuLateral">Inicio: {$txtRutaInicio}</span>
                     </td>
                     <td width="450px" align="right" style="padding-right: 20px">
                         <b><i>En sesión:</b> {$txtNombreUsuario}</i>
                     </td>-->
                </tr>
                <!-- SALIR DE SESION -->			
                <!-- <tr>
                     <td colspan="2" bgcolor="#fff" align="right" valign="middle" style="padding-right:10px;">
                         <a href="#" onClick="location.href = './autenticacion.php'" class="salir">
                             Abandonar Sesión
                         </a>
                         <a href="#" id="ayuda" onClick="popUpAyuda()">
                             <img src="./recursos/imagenes/ayuda.png" width="18px" height="18px">
                         </a>
                     </td>
                 </tr>-->

                <!-- MENU PRINCIPAL -->
                <tr>
                    <td colspan="3">
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td>{include file="menu.tpl"}</td>
                                <!-- <td width="170px" valign="middle" align="center"> PROYECTOS AUTORIZADOS 
                                    <select name="proyecto" id="proyecto" style="width:170px;"
                                            onChange="cargarContenido('bodyHtml', './index.php', 'proyecto=' + this.options[ this.selectedIndex ].value, true);">
                                {foreach from=$arrProyectos key=seqProyecto item=objProyecto}
                                    <option value="{$seqProyecto}"
                                    {if $seqProyectoPost == $seqProyecto} selected {/if}
                                    >{$objProyecto->txtProyecto}</option>
                                {/foreach}
                            </select>
                        </td>-->
                            </tr>
                        </table>
                    </td>
                </tr>			

                <!-- MENSAJES -->
                <tr>
                    <td height="20px" colspan="3" style="padding-left:10px;" id="mensajes"> &nbsp; </td>
                </tr>

                <!-- TODO EL CONTENIDO SE CARGA AQUI -->
                <tr>
                    <td colspan="3" id="contenido" height="650px" align="left" valign="top" style="padding-left:10px; padding-top:5px; padding-bottom:5px; ">
                        {include file="$txtArchivoInicio"}
                    </td>
                </tr>
                <!-- Inicio Mensaje al usuario-->
                <!--  <tr>
                     <td colspan="3">
                        <div id="oScroll" style="width:900px;">
                             <div id="scroll">La información que se registra debe ser soportada documentalmente.
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;						
                                 La sdht podrá verificar en cualquier momento la veracidad de la información.
                             </div>
                         </div>
                     </td>
                 </tr>
                <!-- FIN Mensaje al usuario-->

                <!-- PIE DE PAGINA -->
                <!--   <tr>
                       <td rowspan="2">
                           <img src="{$txtRutaImagenes}bta_positiva.jpg" />
                       </td>
                       <td colspan="2" background="{$txtRutaImagenes}background_menupie.png">
                           &nbsp;
                       </td>
                   </tr>
                   <tr>
                       <td align="center" valign="middle" colspan="3">
                           Calle 52 No. 13-64, Bogot&aacute D.C., Colombia. <br>
                               PBX (571) 58 1600.
                       </td>
                   </tr>	-->		

            </table>
        </center>
        <footer>
            <div  >
                <center>
                    <div id="oScroll" style="width: 52%; margin-top: 5px; margin-bottom: 10px; height: 35px" class="alert alert-danger">
                        <div id="scroll" >
                            La información que se registra debe ser soportada documentalmente.
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            La sdht podrá verificar en cualquier momento la veracidad de la información.<br><br/><br/>
                        </div><br/>

                    </div>
                    <div style=" position: relative; float: left; width:100%">
                        <img src="./recursos/imagenes/pie_ws.png" /><br> 
                    </div>


                    <!--<img src="./recursos/imagenes/background_menupie.png" width="450px" height="20px"/>-->
                </center>
            </div>
        </footer>
    </body>
</html>