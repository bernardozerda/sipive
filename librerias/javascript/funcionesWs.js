

   /**
    * FUNCTION QUE TESTEA LA FORTALEZA DE LA CLAVE
    * @author Ver Referencia web http://marketingtechblog.com/2007/08/27/javascript-password-strength/
    * @param object pwd ==> El input que contiene la cadena que sera evaluada
    * @return Void
    * @version 1.0 Abril 2009
    */

   function passwordChanged(pwd, id) {

      // Verifica la fortaleza de la clave
      var strength = document.getElementById(id);
      var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
      var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
      var enoughRegex = new RegExp("(?=.{6,}).*", "g");

      // coloca el mensaje adecuado para informar al usuario de la fortaleza de la clave digitada
      if (pwd.value.length == 0) {
         strength.innerHTML = "";
      } else if (false == enoughRegex.test(pwd.value)) {
         strength.innerHTML = "<span class='text-error'>Muy D&eacute;bil</span>";
      } else if (strongRegex.test(pwd.value)) {
         strength.innerHTML = "<span class='text-success'>Fuerte</span>";
      } else if (mediumRegex.test(pwd.value)) {
         strength.innerHTML = "<span class='text-warning'>Mediana</span>";
      } else {
         strength.innerHTML = "<span class='text-error'>D&eacute;bil</span>";
      }
   }

   // cuando el documento este listo
   $(document).ready(
      function(){
         
         // cuando se carga la pagina le da foco al campo entidad
         $("#entidad").focus();
         
         $( "#botonTerminar" ).click(
            function(){
               location.href = "../registro.php";
            }
         );
         
         // submit del formulario
         $( "#frmRegistro" ).submit( 
            function( event ){
       
               var mensajes = document.getElementById( 'mensajes' );
                   mensajes.innerHTML = "<div class='hero-unit-header'><strong class='text-info'>Espere mientras procesamos la información</strong><br><img src='./recursos/imagenes/cargando.gif'></div>";
                   
               var datosFormulario = $( "#frmRegistro" ).serialize();
               $.ajax(
                  {
                     type: "POST",
                     url:  "./webservice/salvarRegistro.php",
                     data: datosFormulario,
                     success:
                        function( data ){
                           mensajes.innerHTML = data;
                           
                           if( $( "#botonVolver" ).length != 0 ){
                              var formulario = document.getElementById( "frmRegistro" );
                              formulario.setAttribute("hidden" , true );
                           }

                           $( "#botonVolver" ).click(
                              function(){
                                 location.href = "./registro.php";
                              }
                           );
                        }
                  }
               );
               event.preventDefault();
            }
         );

         // revision del nombre de usuario
         $( "#usuario" ).keyup(
            function(){
               var usuario = document.getElementById( 'usuario' );
               $.ajax(
                  {
                     type: "POST",
                     url:  "./webservice/validarUsuarioUnico.php",
                     data: "usuario=" + usuario.value,
                     success:
                        function( data ){
                           var destino = document.getElementById( 'usuarioError' );
                           destino.innerHTML = data;
                        }
                  }
               );
            }
         );
         
         $( "#ayuda" ).click(
            function() {
       
               var contenido = document.getElementById( "contenidos" );
                   contenido.innerHTML = "";
                   
               $.ajax(
                  {
                     type: "POST",
                     url:  "./webservice/ayuda.php",
                     data: "",
                     success:
                        function( data ){
                           contenido.innerHTML = data;
                        }
                  }
               );
                  
            }
         );
         
         $( "#terminos" ).click(
            function() {
       
               var contenido = document.getElementById( "contenidos" );
                   contenido.innerHTML = "";
                   
               $.ajax(
                  {
                     type: "POST",
                     url:  "./webservice/terminos.php",
                     data: "",
                     success:
                        function( data ){
                           contenido.innerHTML = data;
                        }
                  }
               );
                  
            }
         );
         
      }
   );

