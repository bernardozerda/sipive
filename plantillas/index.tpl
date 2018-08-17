<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es-Es" >
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
            <link rel="stylesheet" type="text/css" href="./librerias/yui/autocomplete/assets/skins/sam/autocomplete-skin.css"/>
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
            <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>

            <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
            <script language="JavaScript" type="text/javascript" src="./librerias/javascript/funciones.js"></script>
            <script language="JavaScript" type="text/javascript" src="./librerias/javascript/funcionesSubsidios.js"></script>
            <script language="JavaScript" type="text/javascript" src="./librerias/javascript/funcionesProyectos.js"></script>
            <script language="JavaScript" type="text/javascript" src="./librerias/javascript/marquee.js"></script>
            <script language="JavaScript" type="text/javascript" src="./librerias/javascript/listenerIndex.js"></script>


            <script src="librerias/jquery/jquery.dataTables.min.js"></script>
            <script src="librerias/jquery/dataTables.bootstrap.min.js"></script>
            <script src="librerias/javascript/dataTable.js"></script>
            <link rel="stylesheet" href="recursos/estilos/jquery-ui.css"/> 

            <link rel="stylesheet" href="librerias/jquery/css/dataTables.bootstrap.min.css"/> 
            <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>

    </head>
    <body class="yui-skin-sam" id="bodyHtml" topMargin="0" style="background-color: white;">
        <center>
            <table cellpadding="0" cellspacing="0" border="0" bgcolor="#F9F9F9" id="tablePrincipal" class="tablePrincipal">
                <tr>
                    <td colspan="2">
                        <div style="position: relative; top: 5px; height: 80px; width: 900px">
                            <img src="./recursos/imagenes/cabezote_ws.png" width="900px">
                            <div style="position: absolute; width: 24%; float: left; top: 1px;left:93%;">
                                <a href="#" onClick="location.href = './autenticacion.php'" >
                                    <img src="./recursos/imagenes/Logout.png" />
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td height="15px;" id="rutaMenu" style="padding-left: 10px;">
                        <span class="menuLateral">Inicio: {$txtRutaInicio}</span>
                    </td>
                    <td width="350px" align="right" style="padding-right: 10px;">
                        <b><i>En sesión:</b> {$txtNombreUsuario}</i>
                    </td>
                </tr>

                <!-- MENU -->
                <tr>
                    <td colspan="2">{include file="menu.tpl"}</td>
                </tr>

                <!-- MENSAJES -->
                <tr>
                    <td height="20px" colspan="3" style="padding-left:10px;" id="mensajes">&nbsp;</td>
                </tr>

                <!-- TODO EL CONTENIDO SE CARGA AQUI -->
                <tr>
                    <td colspan="3" id="contenido" height="550px" aign="left" valign="top" style="padding-left:10px; padding-top:5px; padding-bottom:5px;">{include file="$txtArchivoInicio"}</td>
                </tr>

            </table>
        </center>
        <footer>           
            <div >
                <center>
                    <div id="oScroll" style="width: 900px; margin-top: 0px; margin-bottom: 5px; height: 35px" >
                        <div id="scroll" ><MARQUEE DIRECTION=LEFT class="alert alert-danger" style="padding:5px;">
                                *** SE HA PUBLICADO UNA NUEVA VERSIÓN DEL APLICATIVO
                                *** POR FAVOR DIGITAR SIMULTÁNEAMENTE LAS TECLAS CONTROL Y F5
                                *** REPETIR ESTA ACCIÓN EN MÁS DE UNA OCASION.
                            </MARQUEE> </div><br/>
                    </div>

                    <div style=" position: relative; float: left; width:100%">
                        <div class="well well-small" style="background-color: white;">
                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-3" style="font-size: 11px; text-align: left">
                                    <strong>Dirección:</strong> Carrera 13 # 52 - 25, Bogotá D.C.<br>
                                    <strong>Código postal:</strong> 110231<br>
                                    <strong>Teléfono:</strong> +57 (1) 358 16 00, Extensión: 1000 a 1003<br>
                                    <strong>Correo electrónico institucional:</strong> <a href="mailto:servicioalciudadano@habitatbogota.gov.co">servicioalciudadano@habitatbogota.gov.co</a><br>
                                    <strong>Correo electrónico notificaciones judiciales:</strong> <a href="mailto:servicioalciudadano@habitatbogota.gov.co">notificacionesjudiciales@habitatbogota.gov.co</a><br>
                                    <strong>Horario de Atención:</strong> Lunes a viernes de 7:00 am. a 4:30 pm.<br>
                                    <strong>Ciudad:</strong> Bogotá - Colombia
                                </div>
                                <div class="col-sm-2" style="padding-top: 20px;">
                                    <img src="./recursos/imagenes/pie_ws.png">
                                </div>
                            </div>
                        </div>
                    </div>
                </center>
            </div>
        </footer>
    </body>
</html>
