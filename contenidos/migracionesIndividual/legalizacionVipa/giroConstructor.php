<?php

$txtPrefijoRuta = "../../../";
$txtTipoGiro = "giroConstructor";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include ( $txtPrefijoRuta . "contenidos/migracionesIndividual/legalizacionVipa/configuracion.php" );

?>
<!DOCTYPE html>
<html lang="es">
<head>

    <!-- Estilos CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>
<div id="contenidos" class="container-fluid" style="width: 650px;">

    <div class="alert" style="background-color: #289bae; color: white; text-align: center">
        <h4>
            GIRO DE RECURSOS A CONSTRUCTOR<br>
            <strong>Complementariedad VIPA</strong>
        </h4>
    </div>

    <div class="well">

        <form method="post"
              onsubmit="someterFormulario('contenidos',this,'./contenidos/migracionesIndividual/legalizacionVipa/salvarConstructorFiducia.php',true,true); return false;"
              class="form-horizontal"
        >

            <!-- archivo -->
            <div class="form-group">
                <label for="seqProyecto" class="col-sm-3 control-label">Archivo</label>
                <div class="col-sm-8">
                    <div class="input-group input-group-sm">
                        <label class="input-group-btn">
                            <span class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                                <input type="file" name="archivo" style="display: none;">
                            </span>
                        </label>
                        <input type="text" class="form-control" readonly>
                        <div id="fileSelect"></div>
                    </div>
                </div>
            </div>

            <!-- plantilla y boton de cargar -->
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-5" style="text-align: center">
                    <div class="col-sm-6">
                        <button type="button"
                                class="btn btn-success btn-sm"
                                data-toggle="modal" data-target="#modalProyectos"
                        >Plantilla</button>
                    </div>
                    <div class="col-sm-6">
                        <button type="submit"
                                class="btn btn-primary"
                        >Cargar</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<!-- modal de seleccion de proyectos para la plantilla -->
<div class="modal fade" id="modalProyectos" tabindex="-1" role="dialog" aria-labelledby="modalProyectosLabel">
    <div class="modal-dialog" role="document" style="width: 500px;">
        <form method="post" onsubmit="return false" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalPendientesLabel">Seleccione el proyecto</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="proyecto" class="control-label col-sm-3">Seleccione el proyecto</label>
                        <div class="col-sm-8">
                            <select id="pryPlantilla" name="proyecto" class="form-control input-sm">
                                <option value="">Seleccione Proyecto</option>
                                <?php
                                foreach($arrProyectos as $txtProyecto){
                                    echo "<option value='$txtProyecto'>$txtProyecto</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal"
                            onclick="location.href='./contenidos/migracionesIndividual/legalizacionVipa/plantillaGiroConstructor.php?proyecto=' + $('#pryPlantilla').val()">Continuar</button>
                </div>
            </div>
        </form>
    </div>
</div>