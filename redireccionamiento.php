<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" >
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="title" content="Subsidios de Vivienda">
    <meta name="keywords" content="subsidio,vivienda,social,prioritaria,bogota,habitat,asignacion,credito" />
    <meta name="description" content="Sistema de informacion de subsidios de vivienda">
    <meta http-equiv="Content-Language" content="es">
    <meta name="robots" content="index,  nofollow" />

    <title>PIVE</title>

    <!-- Estilos CSS -->
    <link href="./librerias/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="./librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
    </style>

    <!-- ICONO DE LA VENTANA DEL NAVEGADOR -->
    <link rel="shortcut icon" href="./recursos/imagenes/urlIcon.ico">

    <script type="text/javascript">
        function irA(){
            setTimeout( "location.href = 'http://<?=$_SERVER['SERVER_NAME'] . "/" . mb_split("/",$_SERVER['REQUEST_URI'])[1] ; ?>'" , 3000 );
        }
    </script>

</head>
    <body onLoad="javascript: irA();">

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="./index.php">Inicio</a>
                </div>
            </div>
        </div>

        <div id="contenidos" class="container">

            <div class="well well-small" style="text-align: center">
                <img src="./recursos/imagenes/cabezote_ws.png">
            </div>

            <div class="hero-unit-header" style="background-color: #289bae; color: white; text-align: center">
                <strong>SISTEMA DE INFORMACIÓN DEL PROGRAMA INTEGRAL DE VIVIENDA EFECTVA</strong>
            </div>

            <div class="hero-unit" style="text-align: center">
                <h1>Espere por favor...</h1>
                <p>
                    Usted está siendo redireccionado al sitio seguro, si no es redireccionado en los próximos 3 segundos
                    haga click en el botón.
                    <img src="./recursos/imagenes/cargando.gif">
                </p>
                <p>
                    <a id="irA" class="btn btn-primary btn-large" href="http://<?=$_SERVER['SERVER_NAME'] . "/" . mb_split("/",$_SERVER['REQUEST_URI'])[1] ?>">
                        Ir al sitio seguro
                    </a>
                </p>
            </div>

        </div> <!-- /container -->

        <!-- PIE DE PAGINA -->
        <footer>
            <div class="well well-small" style="text-align: center">
                <img src="./recursos/imagenes/pie_ws.png"><br>
                <h6>Para visualizar mejor este sitio se recomienda el uso de Chrome, Mozilla Firefox ó Internet Explorer 10.</h6>
            </div>
        </footer>

        <!-- INCLUSIONES JAVASCRIPT [NO MOVER DEL FINAL] -->
        <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/jquery-1.10.1.js"></script>
        <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap.js"></script>

    </body>

</html>