<?php
//include '../../../recursos/archivos/verificarSesion.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="application-name" content="Subsidios de Vivienda">
        <meta name="keywords" content="subsidio,vivienda,social,prioritaria,bogota,habitat,asignacion,credito" />
        <meta name="description" content="Sistema de informacion de subsidios de vivienda">        
        <meta name="robots" content="index,  nofollow" />

        <title>SDVE</title>

        <!-- Estilos CSS -->        
        <link href="../../../librerias/bootstrap/css/bootstrap.css" rel="stylesheet">        
        <link href="../../../librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="../../../librerias/bootstrap/css/bootstrap-theme.css" rel="stylesheet">

        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
         <script src="../../../librerias/bootstrap/htmlIE/respond.min.js"></script>
         <script src="../../../librerias/bootstrap/htmlIE/html5.js"></script>
         <script src="../../../librerias/bootstrap/htmlIE/html5shiv.js"></script>
        <script>
            var e = ("article,aside,audio,bdi,canvas,command,datalist,details,dialog,embed,figcaption,figure,footer,header,keygen,mark,meter,nav,output,progress,rp,rt,ruby,section,source,summary,time,track,video,wbr,").split(',');
            for (var i=0; i<e.length; i++) {document.createElement(e[i]);}
            </script>
        <![endif]-->


        <!-- ICONO DE LA VENTANA DEL NAVEGADOR -->
        <link rel="shortcut icon" href="../../../recursos/imagenes/urlIcon.ico">

    </head>
    <body> 

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="index.php">Inicio</a>
                    <!--<div class="nav-collapse collapse">
                       <ul class="nav">
                          <li><a id="ayuda" href="#">Ayuda</a></li>
                       </ul>
                    </div>/.nav-collapse -->
                </div>
            </div>
        </div>

        <div id="contenidos" class="container">

            <div class="well well-large">
                <img src="../../../recursos/imagenes/cabezote_ws.png">
            </div>

            <div class="hero-unit-header" style="background-color: #289bae; color: white; text-align: center">
                <strong>SISTEMA DE INFORMACI&Oacute;N DEL SUBSIDIO DISTRITAL DE VIVIENDA</strong><br/>
                Modulo Carga Masiva de Estudios T&eacute;cnicos para Unidades Habitacionales
            </div>
            <div class="well">


                <form method="post" action="insertar.php" enctype="multipart/form-data" id="formcargar" class="form-signin">
                    <div class="form-group">
                        <h4 class="form-signin-heading">Seleccione el Archivo</h4>
                        <input name="archivo" type="file" id="archivo">
                    </div>

                    <div class="form-actions">
                        <button type="submit" name = "subir" class="btn btn-primary">Cargar</button>
                    </div>

                </form>
            </div>

        </div> <!-- /container -->

        <!-- PIE DE PAGINA -->
        <footer>
            <div class="well well-small">
                <center>
                    <img src="../../../recursos/imagenes/pie_ws.png" class="img-rounded"><br>
                    <h6>Para visualizar mejor este sitio se recomienda el uso de <a href="https://www.google.com/chrome/browser/desktop/">Chrome</a>, <a href="https://www.mozilla.org/es-ES/firefox/new/">Mozilla Firefox</a> ó Internet Explorer 10.</h6>
                </center>
            </div>
        </footer>



        <div id="cargando" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Espere un momento por favor...</h3>
            </div>
            <div class="modal-body text-center">
                <div class="progress progress-striped active">
                    <div class="bar" style="width: 100%;"></div>
                </div>
            </div>
        </div>


        <div id="offLine" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Temporalmente fuera de servicio</h3>
            </div>
            <div class="modal-body text-center">
                <div class="alert alert-info">
                    <h4>Disculpenos, estamos trabajando para ofrecerle mas servicios.</h4>
                </div>
            </div>
            <div class="modal-footer">    
                <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">
                    Cerrar
                </button>
            </div>
        </div>

        <!-- INCLUSIONES JAVASCRIPT [NO MOVER DEL FINAL] -->
        <script type="text/javascript" src="../../../librerias/bootstrap/js/jquery-1.10.1.js"></script>
        <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap.js"></script>        
        <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-collapse.js"></script>  
        <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-transition.js"></script>
        <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-alert.js"></script>        
        <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-dropdown.js"></script>
        <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-scrollspy.js"></script>
        <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-tab.js"></script>
        <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-popover.js"></script>
        <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-tooltip.js"></script>
        <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-button.js"></script>
        <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-carousel.js"></script>
        <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-typeahead.js"></script>
        <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-affix.js"></script>
    </body>
</html>