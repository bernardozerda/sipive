<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cartas de Movilización</title>
        <!-- <style type="text/css">@import "../css/habitat.css"</style>-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="../js/funciones.js"  crossorigin="anonymous"></script>
    </head>

    <style>
        .content{
            position: relative;
            width: 50%;
            left: 20%; 
            top: 5%;
            position: relative;
            background-color: #fff;
            border: 2px solid rgba(0,62,101,0.9);
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;
            -moz-box-shadow: 0 1px 3px #aaa;
            -webkit-box-shadow: 0 1px 3px #aaa;
            box-shadow: 0 1px 3px #aaa;
            margin-top: 10px;
            padding: 3%;

        }
        .head{
            position: relative;
            margin-top: 3%;
            width: 60%;
            left: 15%; 
            top: 10%;
            position: relative;
            background-color: rgba(0,62,101,0.9);
            border: 1px solid rgba(0,62,101,0.9);
            height: 50px;
            padding: 10px;
            color: #FFF;
            border-radius: 10px;
            text-align: center;
        }

        .btn-primary{
            background-color: rgba(0,62,101,0.9);
            border: 1px solid rgba(0,62,101,0.9);
            left: 30%;
        }
    </style>


    <?php
    //echo "hola"; die();
    session_start();
    ?>
    <div class="head" >
        <h5>Sistema en Construcción</h5>
    </div>
   <!-- <p>&nbsp;</p>
    <body>
        <div id="content" >
            <div class="content" style=" padding-left: 12%;">

                <form name="formulario" id="formulario" class="needs-validation"  method="post" >
                    <div class="form-row"> 
                        <div class="col-md-8 mb-3">
                            <label for="numeroIdentificacion">Número de Identificación *</label>
                            <input type="text" class="form-control" id="numeroIdentificacion" name="numeroIdentificacion" placeholder="N&uacute;mero Identificaci&oacute;n" value="" maxlength="11" required>
                            <input id="dirIp" name="dirIp" type="hidden" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" />
                            <div class="invalid-tooltip" id="val_numeroIdentificacion">
                                Por Favor Digitar N&uacute;mero de Identificaci&oacute;n
                            </div>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label for="numeroIdentificacion">Codigo *</label>
                            <input type="text" id="codigo" class="form-control"  name="codigo"   required="" autocomplete="off">
                            <div class="invalid-tooltip" id="val_codigo">
                                Por Favor Digitar El codigo Captcha
                            </div>

                            <!-- title="De click en registrar peticionario para guardar la información en el sistema. Recuerde verificar la información antes de guardar."-->
                   <!--     </div>

                        <div class="col-md-8 mb-3" style="text-align: center;">                            
                            <img id="imagenCaptcha" src="../lib/captcha/CaptchaSecurityImages.php?width=200&height=50&characters=4" alt="captcha" />
                            <a href="#" onClick="cambiarImagenCaptcha('../lib/captcha/CaptchaSecurityImages.php?width=200&height=50&characters=4');">
                                <i class="icon-refresh"></i>
                            </a><br>
                            <small>Es sensible a may&uacute;sculas y min&uacute;sculas</small>
                        </div>
                        <div class="col-md-8 mb-3" style="text-align: center; left: 23%">
                            <label>&nbsp;</label>
                            <div class="input-group" style="text-align: center">
                                <input  class="btn btn-primary" id="guardar" type="button" value="Enviar Solicitud" onclick="if (validar())
                                            enviarDatos()">
                                <!-- title="De click en registrar peticionario para guardar la información en el sistema. Recuerde verificar la información antes de guardar."-->
                          <!--  </div>
                        </div>
                    </div>  
                </form>
            </div>
        </div>     
        <p>&nbsp;</p>
        <div class="form-row" style="width: 70%; position: relative; float: left; left: 20%">
            <div class="col-md-6 mb-3" style="font-size: 11px">
                Dirección: Carrera 13 # 52 - 25, Bogotá D.C.<br>
                Código postal: 110231<br>
                Teléfono: +57 (1) 358 16 00, Extensión: 1000 a 1003<br>
                Correo electrónico institucional: <a href="mailto:servicioalciudadano@habitatbogota.gov.co">servicioalciudadano@habitatbogota.gov.co</a><br>
                Correo electrónico notificaciones judiciales: <a href="mailto:servicioalciudadano@habitatbogota.gov.co">notificacionesjudiciales@habitatbogota.gov.co</a><br>
                Horario de Atención: Lunes a viernes de 7:00 am. a 4:30 pm.<br>
                Ciudad: Bogotá - Colombia
            </div>
            <div class="col-md-4 mb-3"><img src="https://sdv.habitatbogota.gov.co/sipive/recursos/imagenes/pie_ws.png"></div>
            <div class="col-md-4 mb-3"></div>
        </div>
    </body>
</html>
