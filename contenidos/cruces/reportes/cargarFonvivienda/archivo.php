<?php
$txtPrefijo = '../../../../';
include $txtPrefijo . 'recursos/archivos/verificarSesion.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- Estilos CSS -->        
        <link href="<?php echo $txtPrefijo ?>librerias/bootstrap/css/bootstrap.css" rel="stylesheet">        
        <link href="<?php echo $txtPrefijo ?>librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <!--        <link href="../../../librerias/bootstrap/css/bootstrap-theme.css" rel="stylesheet">-->        
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="../../../../librerias/javascript/funcionesSubsidios.js"></script>

    </head>
    <body> 
        <div id="contenidos" class="container">
            <div class="hero-unit-header" style="background-color: #289bae; color: white; text-align: center">
                M&oacute;dulo De Cargue Cruce Fonvivienda
            </div>
            <div class="well">

                <div class="form-group">
                    <h4 class="form-signin-heading" style="width: 50%; position: relative; float: left">Seleccione una opción de cruce</h4>
                    <select onchange="mostrarPagina(this.value)">
                        <option value="0">Seleccione</option>
                        <option value="1">Afiliados</option>
                        <option value="2">Beneficiarios</option>
                        <option value="3">Catastro Bogotá</option>
                        <option value="4">Catastro Medellin</option>
                        <option value="5">Catastro Calí</option>
                        <option value="6">Catastro IGAC</option>
                    </select>
                </div>
            </div> <!-- /container -->

            <div id="ContentPage">
                
            </div>

            <!-- INCLUSIONES JAVASCRIPT [NO MOVER DEL FINAL] 
            <script type="text/javascript" src="../../../librerias/bootstrap/js/jquery-1.10.1.js"></script>-->
            <script type="text/javascript" src="<?php echo $txtPrefijo ?>librerias/bootstrap/js/bootstrap.js"></script>        
            <script type="text/javascript" src="<?php echo $txtPrefijo ?>librerias/bootstrap/js/bootstrap-collapse.js"></script>  
            <script type="text/javascript" src="<?php echo $txtPrefijo ?>librerias/bootstrap/js/bootstrap-transition.js"></script>
            <script type="text/javascript" src="<?php echo $txtPrefijo ?>librerias/bootstrap/js/bootstrap-alert.js"></script>        
            <script type="text/javascript" src="<?php echo $txtPrefijo ?>librerias/bootstrap/js/bootstrap-dropdown.js"></script>
            <script type="text/javascript" src="<?php echo $txtPrefijo ?>librerias/bootstrap/js/bootstrap-scrollspy.js"></script>
            <script type="text/javascript" src="<?php echo $txtPrefijo ?>librerias/bootstrap/js/bootstrap-tab.js"></script>
            <script type="text/javascript" src="<?php echo $txtPrefijo ?>librerias/bootstrap/js/bootstrap-popover.js"></script>
            <script type="text/javascript" src="<?php echo $txtPrefijo ?>librerias/bootstrap/js/bootstrap-tooltip.js"></script>
            <script type="text/javascript" src="<?php echo $txtPrefijo ?>librerias/bootstrap/js/bootstrap-button.js"></script>
            <script type="text/javascript" src="<?php echo $txtPrefijo ?>librerias/bootstrap/js/bootstrap-carousel.js"></script>
            <script type="text/javascript" src="<?php echo $txtPrefijo ?>librerias/bootstrap/js/bootstrap-typeahead.js"></script>
            <script type="text/javascript" src="<?php echo $txtPrefijo ?>librerias/bootstrap/js/bootstrap-affix.js"></script>
    </body>
</html>