<?php
$txtPrefijo = '../../../../';
include $txtPrefijo . 'recursos/archivos/verificarSesion.php';
$txtPrefijoRuta = "../../../../";
include $txtPrefijo . 'recursos/archivos/lecturaConfiguracion.php';
include $txtPrefijo . 'librerias/clases/Cruces.class.php';
include( $txtPrefijo . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
$archivo = '';

if ($_REQUEST['value'] == 1) {
    $archivo = 'Afiliados';
}
$cruces = new Cruces();
$nombreGrupo = $cruces->obtenerDatosGrupo();
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

    </head>
    <body> 
        <div id="contenidos" class="container">

            <div class="well">
                <form method="post" action="migrar<?php echo $archivo ?>.php" enctype="multipart/form-data" id="formcargar" class="form-signin">
                    <div class="form-group">
                        <h4 class="form-signin-heading" style="text-align: center; color: #289bae; font-weight: bold">Cargue Afiliados</h4>
                        
                          Elija el grupo al cual realizara el cruce<br>  
                        <select>
                            <option value="0">Seleccione</option>
                            <?php foreach ($nombreGrupo as $key => $value) { ?>
                                 <option value="<?=$value['seqPreCruGrupo']?>"><?=$value['txtPreCruGrupo']?></option>
                           <?php }?>
                        </select><br>
                        <h4 class="form-signin-heading">Seleccione el archivo</h4>
                        Ingrese en un archivo de texto los documentos para legalizar<br>  
                        <input name="archivo" type="file" id="archivo"><br>
                      
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