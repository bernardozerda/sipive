<?php

$txtPrefijoRuta = "../../../";
$txtTipoGiro = "giroFiducia";

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
            GIRO DE RECURSOS A FIDUCIARIA<br>
            <strong>Complementariedad VIPA</strong>
        </h4>
    </div>

    <div class="well">
        <form method="post"
              onsubmit="someterFormulario('contenidos',this,'./contenidos/migracionesIndividual/legalizacionVipa/salvarGiroFiducia.php',true,true); return false;"
              class="form-horizontal"
        >

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#giro" aria-controls="giro" role="tab" data-toggle="tab">Datos del Giro</a>
                </li>
                <li role="presentation"
                    onclick="
                        autocompletar( 'subsecretario', 'txtSubsecretariaContenido'      , './contenidos/cruces2/nombres.php' , '' ); $('#txtSubsecretaria').removeClass('yui-ac-input');
                        autocompletar( 'subdirector'  , 'txtSubdireccionContenido'       , './contenidos/cruces2/nombres.php' , '' ); $('#txtSubdireccion').removeClass('yui-ac-input');
                        autocompletar( 'reviso'       , 'txtRevisoSubsecretariaContenido', './contenidos/cruces2/nombres.php' , '' ); $('#txtRevisoSubsecretaria').removeClass('yui-ac-input');
                    "
                >
                    <a href="#documentos" aria-controls="documentos" role="tab" data-toggle="tab">Documentos</a>
                </li>
            </ul>

            <!-- nav content -->
            <div class="tab-content col-sm-12" style="padding-top: 20px;">

                <!-- pestaña para el giro -->
                <div role="tabpanel" class="tab-pane fade in active" id="giro">

                    <!-- proyecto de inversion -->
                    <div class="form-group">
                        <label for="proyecto" class="control-label col-sm-3">Proyecto de inversion</label>
                        <div class="col-sm-8">
                            <select id="proyecto"
                                    name="proyecto"
                                    class="form-control input-sm"
                            >
                                <option value="0">Seleccione</option>
                                <option value="488">Proyecto 488: Instrumentos de Financiación para Adquisición, Construcción y Mejoramiento de Vivienda</option>
                                <option value="644">Proyecto 644: Soluciones De Vivienda Para Población En Situación De Desplazamiento</option>
                                <option value="435">Proyecto 435: Mejoramiento Integral de Barrios de Origen Informal</option>
                                <option value="801">Proyecto 801: Mejoramiento del Hábitat Rural</option>
                                <option value="1075">Proyecto 1075: Estructuración de instrumentos de financiación para el desarrollo territorial</option>
                            </select>
                        </div>
                    </div>

                    <!-- benficiario del giro -->
                    <div class="form-group">
                        <label for="nombre" class="control-label col-sm-3">Beneficiario del giro</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   class="form-control input-sm"
                                   id="nombre"
                                   name="nombre"
                                   value=""
                            >
                        </div>
                    </div>

                    <!-- documento del beneficiario del giro -->
                    <div class="form-group">
                        <label for="documento" class="control-label col-sm-3">Documento del beneficiario</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   class="form-control input-sm"
                                   id="documento"
                                   name="documento"
                                   value=""
                            >
                        </div>
                    </div>

                    <!-- direccion del beneficiario del giro -->
                    <div class="form-group">
                        <label for="direccion" class="control-label col-sm-3"
                               onclick="recogerDireccion('direccion', 'direccionOculto')">
                            <a href="#">Dirección del beneficiario</a>
                        </label>
                        <div class="col-sm-8">
                            <input type="text"
                                   id="direccion"
                                   name="direccion"
                                   class="form-control"
                                   value=""
                                   readonly=""
                            >
                            <div id="direccionOculto" style="display:none"></div>
                        </div>
                    </div>

                    <!-- telefono del beneficiario del giro -->
                    <div class="form-group">
                        <label for="telefono" class="control-label col-sm-3">Teléfono</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   class="form-control input-sm"
                                   id="telefono"
                                   name="telefono"
                                   value=""
                            >
                        </div>
                    </div>

                    <!-- correo del beneficiario del giro -->
                    <div class="form-group">
                        <label for="correo" class="control-label col-sm-3">Correo</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   class="form-control input-sm"
                                   id="correo"
                                   name="correo"
                                   value=""
                            >
                        </div>
                    </div>

                    <!-- cuenta del beneficiario del giro -->
                    <div class="form-group">
                        <label for="cuenta" class="control-label col-sm-3">Número de cuenta</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   class="form-control input-sm"
                                   id="cuenta"
                                   name="cuenta"
                                   value=""
                            >
                        </div>
                    </div>

                    <!-- tipo de cuenta del beneficiario del giro -->
                    <div class="form-group">
                        <label for="tipo" class="control-label col-sm-3">Tipo de cuenta</label>
                        <div class="col-sm-8">
                            <select id="tipo"
                                    name="tipo"
                                    class="form-control input-sm"
                            >
                                <option value="">Seleccione</option>
                                <option value="ahorros">Cuenta de Ahorros</option>
                                <option value="corriente">Cuenta Corriente</option>
                                <option value="cheque">Cheque</option>
                                <option value="deposito judicial">Depósito Judicial</option>
                            </select>
                        </div>
                    </div>

                    <!-- banco de cuenta del beneficiario del giro -->
                    <div class="form-group">
                        <label for="banco" class="control-label col-sm-3">Banco</label>
                        <div class="col-sm-8">
                            <select id="banco"
                                    name="banco"
                                    class="form-control input-sm"
                            >
                                <option value="0">Seleccione</option>
                                <?php
                                foreach($arrBancos as $seqBanco => $txtBanco){
                                    echo "<option value='$seqBanco'>$txtBanco</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- radicado -->
                    <div class="form-group">
                        <label for="radicado" class="col-sm-3 control-label">Radicado</label>
                        <div class="col-sm-3">
                            <input type="text"
                                   id="radicado"
                                   name="radicado"
                                   value=""
                                   placeholder="Número"
                                   class="form-control input-sm"
                            >
                        </div>
                        <div class="col-sm-3">
                            <input type="text"
                                   id="fechaRadicado"
                                   name="fechaRadicado"
                                   value=""
                                   placeholder="Fecha"
                                   onfocus="calendarioPopUp('fechaRadicado')"
                                   class="form-control input-sm"
                                   readonly
                            >
                        </div>
                    </div>

                    <!-- Orden de pago -->
                    <div class="form-group">
                        <label for="radicado" class="col-sm-3 control-label">Orden de pago</label>
                        <div class="col-sm-3">
                            <input type="text"
                                   id="orden"
                                   name="orden"
                                   value=""
                                   placeholder="Número"
                                   class="form-control input-sm"
                            >
                        </div>
                        <div class="col-sm-3">
                            <input type="text"
                                   id="fechaOrden"
                                   name="fechaOrden"
                                   value=""
                                   placeholder="Fecha"
                                   onfocus="calendarioPopUp('fechaOrden')"
                                   class="form-control input-sm"
                                   readonly
                            >
                        </div>
                    </div>

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


                </div>

                <!-- pestaña para documentos -->
                <div role="tabpanel" class="tab-pane fade" id="documentos">

                    <!-- copia del documento del beneficiario -->
                    <div class="form-group">
                        <label for="documentoBeneficiario" class="control-label col-sm-3">Copia del documento del beneficiario</label>
                        <div class="col-sm-8">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <input type="checkbox"
                                           id="documentoBeneficiario"
                                           name="documentos[bolCedulaBeneficiario]"
                                           value="1"
                                    >
                                </span>
                                <input type="text"
                                       name="documentos[txtCedulaBeneficiario]"
                                       class="form-control input-sm"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- RUT -->
                    <div class="form-group">
                        <label for="rut" class="control-label col-sm-3">RUT</label>
                        <div class="col-sm-8">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <input type="checkbox"
                                           id="rut"
                                           name="documentos[bolRut]"
                                           value="1"
                                    >
                                </span>
                                <input type="text"
                                       name="documentos[txtRut]"
                                       class="form-control input-sm"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- cedula represnetante legal -->
                    <div class="form-group">
                        <label for="representanteLegal" class="control-label col-sm-3">Cedula representante legal</label>
                        <div class="col-sm-8">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <input type="checkbox"
                                           id="representanteLegal"
                                           name="documentos[bolCedulaRepresentante]"
                                           value="1"
                                    >
                                </span>
                                <input type="text"
                                       name="documentos[txtCedulaRepresentante]"
                                       class="form-control input-sm"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Camara y comercio -->
                    <div class="form-group">
                        <label for="camaraComercio" class="control-label col-sm-3">Cámara de comercio</label>
                        <div class="col-sm-8">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <input type="checkbox"
                                           id="camaraComercio"
                                           name="documentos[bolCamaraComercio]"
                                           value="1"
                                    >
                                </span>
                                <input type="text"
                                       name="documentos[txtCamaraComercio]"
                                       class="form-control input-sm"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Copia resolucion de asignacion -->
                    <div class="form-group">
                        <label for="cartaAsignacion" class="control-label col-sm-3">Copia resolución de asignacion</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon input-group-sm">
                                    <input type="checkbox"
                                           id="cartaAsignacion"
                                           name="documentos[bolCartaAsignacion]"
                                           value="1"
                                    >
                                </span>
                                <input type="text"
                                       name="documentos[txtCartaAsignacion]"
                                       class="form-control input-sm"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Autorización de Giro a Terceros -->
                    <div class="form-group">
                        <label for="giroTerceros" class="control-label col-sm-3">Autorización de giro a terceros</label>
                        <div class="col-sm-8">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <input type="checkbox"
                                           id="giroTerceros"
                                           name="documentos[bolGiroTercero]"
                                           value="1"
                                    >
                                </span>
                                <input type="text"
                                       name="documentos[txtGiroTercero]"
                                       class="form-control input-sm"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Certificación bancaria -->
                    <div class="form-group">
                        <label for="certificacionBancaria" class="control-label col-sm-3">Certificación bancaria</label>
                        <div class="col-sm-8">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <input type="checkbox"
                                           id="certificacionBancaria"
                                           name="documentos[bolCertificacionBancaria]"
                                           value="1"
                                    >
                                </span>
                                <input type="text"
                                       name="documentos[txtCertificacionBancaria]"
                                       class="form-control input-sm"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Original autorizacion de desembolso -->
                    <div class="form-group">
                        <label for="autorizacionDesembolso" class="control-label col-sm-3">Original autorizacion de desembolso</label>
                        <div class="col-sm-8">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <input type="checkbox"
                                           id="autorizacionDesembolso"
                                           name="documentos[bolAutorizacion]"
                                           value="1"
                                    >
                                </span>
                                <input type="text"
                                       name="documentos[txtAutorizacion]"
                                       class="form-control input-sm"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Subsecretaria -->
                    <div class="form-group">
                        <label for="subsecretario" class="control-label col-sm-3">Subsecretario(a)</label>
                        <div class="col-sm-8">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <input type="checkbox"
                                           name="bolSubsecretariaEncargado"
                                           value="1"
                                    >
                                </span>
                                <input type="text"
                                       id="subsecretario"
                                       name="txtSubsecretaria"
                                       class="form-control input-sm"
                                >
                                <div id="txtSubsecretariaContenido" class="text-left"></div>
                            </div>
                        </div>
                    </div>

                    <!-- subdireccion -->
                    <div class="form-group">
                        <label for="subdirector" class="control-label col-sm-3">Subdirector(a)</label>
                        <div class="col-sm-8">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <input type="checkbox"
                                           name="bolSubdireccionEncargado"
                                           value="1"
                                    >
                                </span>
                                <input type="text"
                                       id="subdirector"
                                       name="txtSubdireccion"
                                       class="form-control input-sm"
                                >
                                <div id="txtSubdireccionContenido" class="text-left"></div>
                            </div>
                        </div>
                    </div>

                    <!-- reviso -->
                    <div class="form-group">
                        <label for="reviso" class="control-label col-sm-3">Revisó</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   id="reviso"
                                   name="txtRevisoSubsecretaria"
                                   class="form-control input-sm"
                            >
                            <div id="txtRevisoSubsecretariaContenido" class="text-left"></div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- plantilla y boton de cargar -->
            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3" style="text-align: center">
                    <div class="col-sm-4">
                        <button type="button"
                                class="btn btn-success"
                                data-toggle="modal" data-target="#modalProyectos"
                        >Plantilla</button>
                    </div>
                    <div class="col-sm-4">
                        <button type="submit"
                                class="btn btn-primary"
                        >Cargar</button>
                    </div>
                    <div class="col-sm-4">
                        <button type="button"
                                class="btn btn-info"
                                onClick="location.href='./contenidos/migracionesIndividual/legalizacionVipa/exportableFiducia.php'"
                        >Exportar Datos</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div> <!-- /container -->

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
                            onclick="location.href='./contenidos/migracionesIndividual/legalizacionVipa/plantillaGiroFiducia.php?proyecto=' + $('#pryPlantilla').val()">Continuar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- INCLUSIONES JAVASCRIPT [NO MOVER DEL FINAL] -->
<script type="text/javascript" src="../../../librerias/bootstrap/js/jquery-1.10.1.js"></script>
</body>
</html>
