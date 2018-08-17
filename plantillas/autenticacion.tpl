<!--
<!--
	PLANTILLA INICIAL DE LOGIN DE SDV
   Y CONSULTAS DE CIUDADANO
	@author Bernardo Zerda 
	@version 1.0 Octubre de 2013
-->

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="title" content="Subsidios de Vivienda">
    <meta name="keywords" content="subsidio,vivienda,social,prioritaria,bogota,habitat,asignacion,credito"/>
    <meta name="description" content="Sistema de informacion de subsidios de vivienda">
    <meta http-equiv="Content-Language" content="es">
    <meta name="robots" content="index,  nofollow"/>

    <title>PIVE</title>

    <!-- Estilos CSS -->
    <link href="./librerias/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="./librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    {literal}
        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="librerias/bootstrap/htmlIE/respond.min.js"></script>
        <script src="librerias/bootstrap/htmlIE/html5.js"></script>
        <script src="librerias/bootstrap/htmlIE/html5shiv.js"></script>
        <script>
            var e = ("article,aside,audio,bdi,canvas,command,datalist,details,dialog,embed,figcaption,figure,footer,header,keygen,mark,meter,nav,output,progress,rp,rt,ruby,section,source,summary,time,track,video,wbr,").split(',');
            for (var i = 0; i < e.length; i++) {
                document.createElement(e[i]);
            }
        </script>
        <![endif]-->
    {/literal}

    <!-- ICONO DE LA VENTANA DEL NAVEGADOR -->
    <link rel="shortcut icon" href="./recursos/imagenes/urlIcon.ico">

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
            <a class="brand" href="./index.php">Inicio</a>
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
        <img src="./recursos/imagenes/cabezote_ws.png">
    </div>

    <div class="hero-unit-header" style="background-color: #289bae; color: white; text-align: center">
        <strong>SISTEMA DE INFORMACIÓN DEL PROGRAMA INTEGRAL DE VIVIENDA EFECTVA</strong>
    </div>

    <center>
        <div id="mensajes">
            {if not empty( $arrErrores )}
                <div class='alert alert-block alert-error fade in'>
                    <button type='button' class='close' data-dismiss='alert'>×</button>
                    <h4 class='alert-heading'>Atenci&oacute;n:</h4>
                    <div style='width:650px;'>
                        <ul>
                            {foreach from=$arrErrores item=txtError}
                                {if is_array( $txtError ) && ( not empty( $txtError )  )}
                                    {foreach from=$txtError item=txtMensaje}
                                        <li style='text-align:left;'>{$txtMensaje}</li>
                                    {/foreach}
                                {else}
                                    <li style='text-align:left;'>{$txtError}</li>
                                {/if}
                            {/foreach}
                        </ul>
                    </div>
                </div>
            {/if}
        </div>
    </center>

    <div id="fila" class="container">

        <!-- NO BORRAR -->
        <div class="row">
            <div class="span12">&nbsp;</div>
        </div>

        <div class="row">

            <!-- ESPACIO LATERAL -->
            <div class="span1">&nbsp;</div>

            <!-- ACCESO PARA FUNCIONARIOS -->
            <div class="span5" style="height: 470px; width:518px; padding-left: 18%; ">

                <div class="thumbnail" style="height: 450px;">
                    <div class="caption">
                        <h3 style="text-align: center">Acceso para funcionarios</h3>
                        <p>
                        <form id="frmFuncionarios" class="form-horizontal" method="post" action="./autenticacion.php"
                              autocomplete="off">
                            <fieldset>

                                <!-- USUARIO -->
                                <div class="control-group">
                                    <label class="control-label" for="usuario">Usuario</label>
                                    <div class="controls">
                                        <input type="text"
                                               id="usuario"
                                               name="usuario"
                                               placeholder="Usuario"
                                               onBlur="soloLetras(this)"
                                               value=""
                                               required
                                        >
                                    </div>
                                </div>

                                <!-- CLAVE -->
                                <div class="control-group">
                                    <label class="control-label" for="clave">Clave</label>
                                    <div class="controls">
                                        <input type="password"
                                               id="clave"
                                               name="clave"
                                               placeholder="Clave"
                                               onBlur="this.value = ( this.value != '' )? hex_sha1( this.value ) : '' ; "
                                               value=""
                                               required
                                        >
                                    </div>
                                </div>

                                <!-- PUNTO DE ATENCION -->
                                <div class="control-group">
                                    <label class="control-label" for="seqPuntoAtencion">Punto de Atenci&oacute;n</label>
                                    <div class="controls">
                                        <select name="seqPuntoAtencion" id="seqPuntoAtencion">
                                            {foreach from=$arrPuntos item=txtPunto key=seqPunto}
                                                <option value="{$seqPunto}">{$txtPunto}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>

                                <!-- IMAGEN -->
                                <div class="control-group">
                                    <label class="control-label" for="codigo">C&oacute;digo</label>
                                    <div class="controls">
                                        <input type="text"
                                               id="codigo"
                                               name="codigo"
                                               placeholder="Codigo"
                                               onBlur="sinCaracteresEspeciales(this)"
                                               required
                                        >
                                    </div>
                                </div>

                                <!-- CAPTCHA -->
                                <div class="control-group">
                                    <div class="controls">
                                        <img id="imagenCaptcha"
                                             src="{$txtRutaCaptcha}?width={$numAncho}&height={$numAlto}&characters={$numLetras}"
                                             alt="captcha"/>
                                        <a href="#"
                                           onClick="cambiarImagenCaptcha('{$txtRutaCaptcha}?width={$numAncho}&height={$numAlto}&characters={$numLetras}');">
                                            <i class="icon-refresh"></i>
                                        </a><br>
                                        <small>Es sensible a may&uacute;sculas y min&uacute;sculas</small>
                                    </div>
                                </div>

                                <!-- BOTON DE ACCESO -->
                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" class="btn" style="width: 200px;">
                                            Entrar
                                        </button>
                                        <input type="hidden" name="btnSalvar" value="1">
                                    </div>
                                </div>

                                <!-- Link Olvido de clave -->
                                <div class="control-group">
                                    <div class="controls">
                                       <span class="help-block">
                                          <a href="#olvidoClave" role="button" data-toggle="modal">&iquest;Olvid&oacute; su contrase&ntilde;a?</a>
                                       </span>
                                    </div>
                                </div>

                            </fieldset>
                        </form>
                        </p>
                    </div>
                </div>

            </div>

            <!-- ESPACIO LATERAL -->
            <div class="span1">&nbsp;</div>

        </div>
    </div>
</div> <!-- /container -->

<!-- PIE DE PAGINA -->
<footer>
    <div class="well well-small" style="background-color: white;">
        <div class="row">
            <div class="offset5 span7" style="font-size: 11px;">
                <strong>Dirección:</strong> Carrera 13 # 52 - 25, Bogotá D.C.<br>
                <strong>Código postal:</strong> 110231<br>
                <strong>Teléfono:</strong> +57 (1) 358 16 00, Extensión: 1000 a 1003<br>
                <strong>Correo electrónico institucional:</strong> <a href="mailto:servicioalciudadano@habitatbogota.gov.co">servicioalciudadano@habitatbogota.gov.co</a><br>
                <strong>Correo electrónico notificaciones judiciales:</strong> <a href="mailto:servicioalciudadano@habitatbogota.gov.co">notificacionesjudiciales@habitatbogota.gov.co</a><br>
                <strong>Horario de Atención:</strong> Lunes a viernes de 7:00 am. a 4:30 pm.<br>
                <strong>Ciudad:</strong> Bogotá - Colombia
            </div>
            <div class="span2" style="padding-top: 40px;">
                <img src="./recursos/imagenes/pie_ws.png">
            </div>
        </div>
    </div>
</footer>

<!-- POP UP DE OLVIDO DE CLAVE -->
<div id="olvidoClave" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: none;">
    <form id="frmOlvidoClave" class="form-horizontal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">¿Olvid&oacute; su clave?</h3>
        </div>
        <div class="modal-body">
            <p class="text-center alert alert-info">
                Digite el correo electrónico del usuario, se le regresará un mensaje con una nueva contraseña
            </p>
            <div class="control-group">
                <label class="control-label" for="usuario">Usuario</label>
                <div class="controls">
                    <input type="text" id="olvidoUsuario" name="olvidoUsuario" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="correo">Correo</label>
                <div class="controls">
                    <input type="email" id="olvidoCorreo" name="correo" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn">
                Aceptar
            </button>
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">
                Cancelar
            </button>
        </div>
    </form>
</div>

<div id="cargando" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
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


<div id="offLine" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
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
<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/jquery-1.10.1.js"></script>
<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap.js"></script>
<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-collapse.js"></script>
<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-transition.js"></script>
<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-alert.js"></script>
<!-- <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-modal.js"></script> -->
<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-dropdown.js"></script>
<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-scrollspy.js"></script>
<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-tab.js"></script>
<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-popover.js"></script>
<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-tooltip.js"></script>
<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-button.js"></script>
<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-carousel.js"></script>
<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-typeahead.js"></script>
<script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-affix.js"></script>

<script language="JavaScript" type="text/javascript" src="./librerias/yui/yahoo/yahoo-min.js"></script>
<script language="JavaScript" type="text/javascript" src="./librerias/yui/event/event-min.js"></script>
<script language="JavaScript" type="text/javascript" src="./librerias/javascript/encripcion.js"></script>
<script language="JavaScript" type="text/javascript" src="./librerias/javascript/autenticacion.js"></script>
<script language="JavaScript" type="text/javascript" src="./librerias/javascript/ciudadano.js"></script>

</body>
</html>