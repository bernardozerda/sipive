<?php /* Smarty version 2.6.26, created on 2017-05-04 21:24:46
         compiled from autenticacion.tpl */ ?>
<!--
<!--
	PLANTILLA INICIAL DE LOGIN DE SDV
   Y CONSULTAS DE CIUDADANO
	@author Bernardo Zerda 
	@version 1.0 Octubre de 2013
-->

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
      <?php echo '
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
             var e = ("article,aside,audio,bdi,canvas,command,datalist,details,dialog,embed,figcaption,figure,footer,header,keygen,mark,meter,nav,output,progress,rp,rt,ruby,section,source,summary,time,track,video,wbr,").split(\',\');
             for (var i=0; i<e.length; i++) {document.createElement(e[i]);}
             </script>
         <![endif]-->
      '; ?>
  
            
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
               <?php if (! empty ( $this->_tpl_vars['arrErrores'] )): ?>
                  <div class='alert alert-block alert-error fade in'>
                     <button type='button' class='close' data-dismiss='alert'>×</button>
                     <h4 class='alert-heading'>Atenci&oacute;n:</h4>
                     <div style='width:650px;'><ul>
                        <?php $_from = $this->_tpl_vars['arrErrores']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['txtError']):
?>
                           <?php if (is_array ( $this->_tpl_vars['txtError'] ) && ( ! empty ( $this->_tpl_vars['txtError'] ) )): ?>
                              <?php $_from = $this->_tpl_vars['txtError']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['txtMensaje']):
?>
                                 <li style='text-align:left;'><?php echo $this->_tpl_vars['txtMensaje']; ?>
</li>
                              <?php endforeach; endif; unset($_from); ?>   
                           <?php else: ?>   
                              <li style='text-align:left;'><?php echo $this->_tpl_vars['txtError']; ?>
</li>
                           <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?>   
                     </ul></div>
                  </div>
               <?php endif; ?>
            </div>
         </center>
         
         <div id="fila">
            
            <!-- NO BORRAR -->
            <div class="row"><div class="span12">&nbsp;</div></div>
            
            <div class="row">

               <!-- ESPACIO LATERAL -->
               <div class="span1">&nbsp;</div>

               <!-- ACCESO PARA CIUDADANOS -->
               <!-- <div class="span5" style="height: 470px;">
                     
                 <div class="thumbnail" style="height: 420px;">
                     <img data-src="holder.js/200x180" alt="" style="width: 200px; height: 180px;" src="./recursos/imagenes/accesoCiudadanos.png">
                     <div class="caption">
                        <h3>Acceso para Ciudadanos</h3>
                        <form id="frmCiudadanos" class="form-horizontal">
                           <p style="text-align: justify;">
                              El Programa de Subsidios Distritales de Vivienda ha cambiado. En caso que en los &uacute;ltimos meses no haya actualizado sus 
                              datos le invitamos a acercarse al punto de atención de la SDHT para recibir informaci&oacute;n de los nuevos esquemas, requerimientos 
                              y condiciones para ser beneficiario del SDVE.
                           </p>
                           <p>
                              <center>
                              
                              <div class="input-append">
                                  <input type="text"
                                         id="documento"
                                         name="documento"
                                         placeholder="Documento"
                                         class="span3"
                                         onBlur="soloNumeros(this)"
                                         value=""
                                         pattern="[0-9]+"
                                         required
                                  >
                                  <button class="btn" type="submit">Entrar</button>
                               </div>
                              </center>
                           </p>
                        </form>
                     </div>
                  </div>
                  
               </div>-->

               <!-- ACCESO PARA FUNCIONARIOS -->
               <div class="span5" style="height: 470px; width:518px; padding-left: 18%; ">
                  
                  <div class="thumbnail" style="height: 420px;">
                     <div class="caption">
                         <h3 style="text-align: center">Acceso para funcionarios</h3>
                        <p>
                           <form id="frmFuncionarios" class="form-horizontal" method="post" action="./autenticacion.php" autocomplete="off">
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
                                          <?php $_from = $this->_tpl_vars['arrPuntos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqPunto'] => $this->_tpl_vars['txtPunto']):
?>
                                             <option value="<?php echo $this->_tpl_vars['seqPunto']; ?>
"><?php echo $this->_tpl_vars['txtPunto']; ?>
</option>
                                          <?php endforeach; endif; unset($_from); ?>
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
                                       <img id="imagenCaptcha" src="<?php echo $this->_tpl_vars['txtRutaCaptcha']; ?>
?width=<?php echo $this->_tpl_vars['numAncho']; ?>
&height=<?php echo $this->_tpl_vars['numAlto']; ?>
&characters=<?php echo $this->_tpl_vars['numLetras']; ?>
" alt="captcha" />
                                       <a href="#" onClick="cambiarImagenCaptcha('<?php echo $this->_tpl_vars['txtRutaCaptcha']; ?>
?width=<?php echo $this->_tpl_vars['numAncho']; ?>
&height=<?php echo $this->_tpl_vars['numAlto']; ?>
&characters=<?php echo $this->_tpl_vars['numLetras']; ?>
');">
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
                                       <!-- <span class="help-block">
                                       <a href="#olvidoClave" role="button" data-toggle="modal">&iquest;Olvid&oacute; su contrase&ntilde;a?</a>
                                       </span>-->
                                       <input type="hidden" name="btnSalvar" value="1">
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
          <div class="well well-small">
              <center>
                  <img src="./recursos/imagenes/pie_ws.png"><br>
                  <h6>Para visualizar mejor este sitio se recomienda el uso de Chrome, Mozilla Firefox ó Internet Explorer 10.</h6>
              </center>
          </div>
      </footer>
      
      <!-- POP UP DE OLVIDO DE CLAVE -->
      <div id="olvidoClave" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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