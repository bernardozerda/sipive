<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Estilos CSS -->
    <link href="./librerias/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="./librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
</head>
<body>
<div id="contenidos" class="container" style="width: 650px">

    <div class="hero-unit-header" style="background-color: #289bae; color: white; text-align: center">
        Cargue masivo de estudios técnicos<br>para el esquema <strong>Mi casa ya</strong>
    </div>
    <div class="well">
        <form method="post"
              onsubmit="return false;"
              enctype="multipart/form-data"
        >
            <div class="form-group row">
                <h4 class="form-signin-heading">Plantilla de datos</h4>
                Ingrese en un archivo de texto los documentos para legalizar<br>
                <h4>
                    <input name="documentos" class="inputLogin" type="file" id="documentos">
                </h4>
            </div>
            <div style="height: 5px;"></div>
            <div class="form-group row">
                <h4 class="form-signin-heading">Archivo de fotos</h4>
                Ingrese en un zip las fotos relacionadas con los estudios<br>
                <h4>
                    <input name="fotos" class="inputLogin" type="file" id="fotos">
                </h4>
            </div>
            <div style="height: 5px;"></div>
            <p align="center">
                <button type="submit"
                        class="btn btn-primary"
                        onClick="someterFormulario(
                            'contenidoLegalizacion',
                            this.form,
                            './contenidos/migracionesIndividual/EstudiosTecnicosMiCasaYa/carga.php',
                            true,
                            true
                        )"
                >Cargar</button>
                <input type="hidden" name="salvar" value="1">
            </p>
        </form>
    </div>
</div> <!-- /container -->

<div id="listenerBuscarUsuario"></div>

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
<script type="text/javascript" src="../../../librerias/javascript/listenerIndex.js"></script>
</body>
</html>

<?php

?>