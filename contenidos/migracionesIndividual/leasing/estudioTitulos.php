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
        Cargue masivo de estudio de títulos<br><strong>Leasing</strong>
    </div>
    <div class="well">
        <form method="post"
              onsubmit="return false;"
              enctype="multipart/form-data"
        >
            <div class="form-group">
                <h4 class="form-signin-heading">Plantilla de datos</h4>
                Ingrese en un archivo de texto los documentos para legalizar<hr>
                <input name="documentos" type="file" id="documentos">
            </div>
            <p align="center">
                <button type="submit"
                        class="btn btn-primary"
                        onClick="someterFormulario(
                            'contenidoLegalizacion',
                            this.form,
                            './contenidos/migracionesIndividual/leasing/salvarEstudioTitulos.php',
                            true,
                            true
                        )"
                >Cargar</button>
                <input type="hidden" name="salvar" value="1">
            </p>
        </form>
    </div>
</div> <!-- /container -->


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
