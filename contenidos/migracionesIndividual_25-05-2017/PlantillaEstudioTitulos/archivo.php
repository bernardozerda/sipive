<?php
include '../../../recursos/archivos/verificarSesion.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- Estilos CSS -->        
        <link href="../../../librerias/bootstrap/css/bootstrap.css" rel="stylesheet">        
        <link href="../../../librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="../../../librerias/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    </head>
    <body> 
        <div id="contenidos" class="container">
            <div class="hero-unit-header" style="background-color: #289bae; color: white; text-align: center">
                Plantilla Estudio T&iacute;tulos
            </div>
            <div class="well">
                <form method="post" action="insertar.php" enctype="multipart/form-data" id="formcargar" class="form-signin">
                    <div class="form-group">
                        <h4 class="form-signin-heading">Seleccione el Archivo</h4>
                        Ingrese el archivo de texto con los documentos<br><br>
                        <input name="archivo" type="file" id="archivo">
                    </div>
                    <br><p align="center"><button type="submit" name = "subir" class="btn btn-primary">Cargar</button></p>
                </form>
            </div>
        </div> <!-- /container -->

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