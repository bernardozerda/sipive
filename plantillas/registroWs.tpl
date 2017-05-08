<!--
	PLANTILLA INICIAL DE REGISTRO DE
    LAS CUENTAS DE WEB SERVICE
	@author Bernardo Zerda 
	@author Camilo Bernal
	@version 1.0 Septiembre de 2013
-->

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" >
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="title" content="Registro Web Service SDHT-SDVE">
      <meta name="keywords" content="sdht,webservice,sdve" />
      <meta name="description" content="Registro de cuentas para consultas por web service del sdve">
      <meta http-equiv="Content-Language" content="es">
      <meta name="robots" content="index,  nofollow" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <title>Registro</title>

      <!-- INCLUSIONES HOJAS DE ESTILO -->	
      <link rel="stylesheet" type="text/css" href="./librerias/bootstrap/css/bootstrap.css">
      {literal}
          <style type="text/css">
              body {
                  padding-top: 40px;
                  padding-bottom: 40px;
              }
          </style>  
      {/literal}    
      <link rel="stylesheet" type="text/css" href="./librerias/bootstrap/css/bootstrap-responsive.css">
      {literal}
          <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
          <!--[if lt IE 9]>
            <script src="./librerias/bootstrap/htmlIE/respond.min.js"></script>
            <script src="./librerias/bootstrap/htmlIE/html5.js"></script>
            <script src="./librerias/bootstrap/htmlIE/html5shiv.js"></script>
          <script>
              var e = ("article,aside,audio,bdi,canvas,command,datalist,details,dialog,embed,figcaption,figure,footer,header,keygen,mark,meter,nav,output,progress,rp,rt,ruby,section,source,summary,time,track,video,wbr,").split(',');
              for (var i=0; i<e.length; i++) {document.createElement(e[i]);}
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
               <a class="brand" href="./registro.php">SDVE - Registro Web Service</a>
               <div class="nav-collapse collapse">
                  <ul class="nav">
                     <li><a id="terminos" href="#">Términos y Condiciones</a></li>
                     <li><a id="ayuda"    href="#">Ayuda</a></li>
                     <li><a id="creditos" href="#">Créditos</a></li>
                  </ul>
               </div><!--/.nav-collapse -->
            </div>
         </div>
      </div>
      <br>
      <div id="contenidos" class="container">
      
         <div class="well well-large">
            <img src="./recursos/imagenes/cabezote_ws.png">
         </div>
         
         <div class="hero-unit-header" style="background-color: #289bae; color: white">
            <center><strong>REGISTRO DE USUARIOS PARA CONSULTAS WEB SERVICE</strong></center>
         </div>
         
         <center>
            <div id="mensajes"></div>
         </center>
         
         <form id="frmRegistro" class="form-actions">

            <!-- NOMBRE DE LA ENTIDAD -->
            <div class="row">
               <div class="span2">&nbsp;</div>
               <div class="span3">
                  <label for="entidad"><h4>Nombre de la Entidad</h4></label>
               </div>
               <div class="span3">
                  <input type="text" 
                         id="entidad" 
                         name="entidad"  
                         title="Campo Requerido" 
                         required
                         {literal}
                            pattern="[A-Za-z\ áéíóúüñÁÉÍÓÚÜÑ]+"
                         {/literal}
                         style="width: 100%"
                         >
               </div>
               <div class="span3" id="entidadError">&nbsp;</div>
               <div class="span1">&nbsp;</div>
            </div>

            <!-- NOMBRE DEL CONTACTO -->
            <div class="row">
               <div class="span2">&nbsp;</div>
               <div class="span3">
                  <label for="contacto"><h4>Nombre del Contácto</h4></label>
               </div>
               <div class="span3">
                  <input type="text" 
                         id="contacto" 
                         name="contacto"  
                         title="Campo Requerido" 
                         required
                         {literal}
                            pattern="[A-Za-z\ áéíóúüñÁÉÍÓÚÜÑ]+"
                         {/literal}
                         style="width: 100%"
                         >
               </div>
               <div class="span3" id="contactoError">&nbsp;</div>
               <div class="span1">&nbsp;</div>
            </div>

            <!-- NOMBRE DEL TELEFONO Y LA EXTENSION -->
            <div class="row">
               <div class="span2">&nbsp;</div>
               <div class="span3">
                  <label for="telefono"><h4>Teléfono</h4></label>
               </div>
               <div class="span2">
                  <input type="text" 
                         id="telefono" 
                         name="telefono"  
                         title="Numero telefonico (entre 7 y 10 digitos)" 
                         required
                         {literal}
                            pattern="[0-9]{7,10}"
                         {/literal}
                         style="width: 100%"
                         >
               </div>
               <div class="span1">
                  <input type="text" 
                         id="extension" 
                         name="extension"  
                         title="Numero de extension (hasta 5 digitos)" 
                         style="width: 100%"
                         {literal}
                            pattern="[0-9]{0,5}"
                         {/literal}
                         >
               </div>
               <div class="span3" id="telefonoError">&nbsp;</div>
               <div class="span1">&nbsp;</div>
            </div>    

            <!-- CORREO ELECTRONICO -->
            <div class="row">
               <div class="span2">&nbsp;</div>
               <div class="span3">
                  <label for="correo"><h4>Correo Electrónico</h4></label>
               </div>
               <div class="span3">
                  <input type="email" 
                         id="correo" 
                         name="correo"  
                         title="Digite un correo electrónico válido" 
                         required
                         style="width: 100%"
                         >
               </div>
               <div class="span3" id="coreoError">&nbsp;</div>
               <div class="span1">&nbsp;</div>
            </div>

            <!-- NOMBRE DE USUARIO -->
            <div class="row">
               <div class="span2">&nbsp;</div>
               <div class="span3">
                  <label for="usuario"><h4>Nombre de Usuario</h4></label>
               </div>
               <div class="span3">
                  <input type="text" 
                         id="usuario" 
                         name="usuario"  
                         title="Campo Requerido" 
                         required
                         {literal}
                            pattern="[0-9A-Za-z\ ]+"
                         {/literal}
                         style="width: 100%"
                         >
               </div>
               <div class="span3" id="usuarioError">&nbsp;</div>
               <div class="span1">&nbsp;</div>
            </div>

            <!-- CLAVE DE USUARIO -->
            <div class="row">
               <div class="span2">&nbsp;</div>
               <div class="span3">
                  <label for="clave"><h4>Contraseña</h4></label>
               </div>
               <div class="span3">
                  <input type="password" 
                         id="clave" 
                         name="clave"  
                         title="Campo Requerido, minimo 6 caracteres" 
                         required
                         {literal}
                            pattern=".{6,}"
                         {/literal}
                         style="width: 100%"
                         onKeyUp="passwordChanged( this , 'claveError' );"
                         >
               </div>
               <div class="span3" id="claveError">&nbsp;</div>
               <div class="span1">&nbsp;</div>
            </div>

            <!-- BOTON -->
            <div class="row">
               <div class="span5">&nbsp;</div>
               <div class="span3">
                  <button class="btn btn-large btn-primary" id="botonRegistro" type="submit">
                     Aceptar
                  </button>
               </div>
               <div class="span4">&nbsp;</div>
            </div>

         </form>
                         
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
      
      <!-- INCLUSIONES JAVASCRIPT -->	
      <script language="JavaScript" type="text/javascript" src="./librerias/javascript/jQuery.js"></script>
      <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap.js"></script>
      <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-button.js"></script>
      <script language="JavaScript" type="text/javascript" src="./librerias/javascript/funcionesWs.js"></script>      
      
  	</body>
</html>
