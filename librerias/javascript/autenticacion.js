/**********************************************************************************************************************
 * INHABILITA LAS FUNCIONES
 * - F12
 * - CONTROL + U
 * - CLICK DERECHO
 **********************************************************************************************************************/

var ventana = $(window);
ventana.on('keydown',keyListener);
ventana.on('contextmenu',contextMenu);

function contextMenu(e){
    e.preventDefault();
    e.returnValue = false;
}

function keyListener(e) {
    if (e.keyCode == 123) {
        e.preventDefault();
        e.returnValue = false;
    }
    if (e.ctrlKey && e.keyCode == 85) {
        e.preventDefault();
        e.returnValue = false;
    }
}

/**********************************************************************************************************************/

/**
 * ESTA FUNCION SE USA PARA RECARGAR 
 * LA IMAGEN CAPTCHA DEL LOGIN
 * @author Bernardo Zerda
 * @param string txtRutaCaptcha
 * @return Void
 * @version 1,0 Abril 2009
 */
function cambiarImagenCaptcha(txtRutaCaptcha) {

    // Obtiene el objeto que contendra la imagen generada
    var objImagen = document.getElementById("imagenCaptcha");

    // esta parte se usa para hacer creer al navegador que es una imagen nueva
    // sin esto, algunos navegadores como firefox cachean la imagen y no muestra
    // la nueva imagen generada
    objImagen.src = txtRutaCaptcha + "&" + Math.random() + "=" + Math.random();

}

/**
 * SOLO DEJA LOS CARACTERES QUE SEAN LETRAS EN UN INPUT
 * @author Bernardo Zerda
 * @param object objLimpiar
 * @return Void
 * @version 1.0 Marzo 29 2009
 */
function soloLetras(objLimpiar) {
   var txtTexto = objLimpiar.value;
   var txtResultado = "";
   var txtCaracter = "";
   for (i = 0; i < txtTexto.length; i++) {
      txtCaracter = txtTexto.charAt(i);
      if (
         txtCaracter.toString().charCodeAt(0) != 225 && //  a
         txtCaracter.toString().charCodeAt(0) != 233 && //  e
         txtCaracter.toString().charCodeAt(0) != 237 && //  i
         txtCaracter.toString().charCodeAt(0) != 243 && //  o
         txtCaracter.toString().charCodeAt(0) != 250 && //  u
         txtCaracter.toString().charCodeAt(0) != 252 && //  u + dieresis
         txtCaracter.toString().charCodeAt(0) != 241 && //  ï¿½ (enie)
         txtCaracter.toString().charCodeAt(0) != 193 && //  A
         txtCaracter.toString().charCodeAt(0) != 201 && //  E
         txtCaracter.toString().charCodeAt(0) != 205 && //  I
         txtCaracter.toString().charCodeAt(0) != 211 && //  O
         txtCaracter.toString().charCodeAt(0) != 218 && //  U
         txtCaracter.toString().charCodeAt(0) != 220 && //  U + dieresis
         txtCaracter.toString().charCodeAt(0) != 209    //  ï¿½ (enie mayuscula)
         ) {
          txtResultado += txtCaracter.replace(/[^A-Za-z\ ]/, ""); // solo se permiten letras, numeros, punto(.), slash(/), arroba(@), espacios( ) y tildes
      } else {
          txtResultado += txtCaracter;
      }
   }
   objLimpiar.value = txtResultado;
}

/**
 * SOLO DEJA LOS CARACTERES QUE SEAN ALFANUMERICOS EN UN INPUT -- QUITA CARACTERES ESPECIALES
 * @author Bernardo Zerda
 * @param object objLimpiar
 * @return Void
 * @version 1.0 Marzo 29 2009
 */
function sinCaracteresEspeciales(objLimpiar) {
   var txtTexto = objLimpiar.value;
   var txtResultado = "";
   var txtCaracter = "";
   for (i = 0; i < txtTexto.length; i++) {
      txtCaracter = txtTexto.charAt(i);
      if (
         txtCaracter.toString().charCodeAt(0) != 225 && //  a
         txtCaracter.toString().charCodeAt(0) != 233 && //  e
         txtCaracter.toString().charCodeAt(0) != 237 && //  i
         txtCaracter.toString().charCodeAt(0) != 243 && //  o
         txtCaracter.toString().charCodeAt(0) != 250 && //  u
         txtCaracter.toString().charCodeAt(0) != 252 && //  u + dieresis
         txtCaracter.toString().charCodeAt(0) != 241 && //  (enie)
         txtCaracter.toString().charCodeAt(0) != 193 && //  A
         txtCaracter.toString().charCodeAt(0) != 201 && //  E
         txtCaracter.toString().charCodeAt(0) != 205 && //  I
         txtCaracter.toString().charCodeAt(0) != 211 && //  O
         txtCaracter.toString().charCodeAt(0) != 218 && //  U
         txtCaracter.toString().charCodeAt(0) != 220 && //  U + dieresis
         txtCaracter.toString().charCodeAt(0) != 209    //  (enie mayuscula)
      ) {
         txtResultado += txtCaracter.replace(/[^a-zA-Z0-9\-\_\.\@\ \/]/, "");
      } else {
          txtResultado += txtCaracter;
      }
   }
   objLimpiar.value = txtResultado;
}

/**
 * SOLO DEJA LOS CARACTERES QUE SEAN NUMEROS EN UN INPUT
 * @author Bernardo Zerda
 * @param object objLimpiar
 * @return Void
 * @version 1.0 Marzo 29 2009
 */
function soloNumeros(objLimpiar) {

    var txtTexto = objLimpiar.value;
    var txtResultado = "";
    var txtCaracter = "";
    for (i = 0; i < txtTexto.length; i++) {
        txtCaracter = txtTexto.charAt(i);
        txtResultado += txtCaracter.replace(/[^0-9\.]/, ""); // todo lo que no sea numero es removido
    }
    objLimpiar.value = txtResultado;
}

/**
 * FUNCTION QUE TESTEA LA FORTALEZA DE LA CLAVE
 * @author Ver Referencia web http://marketingtechblog.com/2007/08/27/javascript-password-strength/
 * @param object pwd ==> El input que contiene la cadena que sera evaluada
 * @return Void
 * @version 1.0 Abril 2009
 */
function passwordChanged(pwd) {

    // Verifica la fortaleza de la clave
    var strength = document.getElementById('fortaleza');
    var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
    var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
    var enoughRegex = new RegExp("(?=.{6,}).*", "g");
    
    // css base para la alerta
    strength.className = "help-inline text-center ";
    
    // coloca el mensaje adecuado para informar al usuario de la fortaleza de la clave digitada
    if (pwd.value.length == 0) {
        strength.innerHTML = "";
    } else if (false == enoughRegex.test(pwd.value)) {
       strength.className += "label label-important";
       strength.innerHTML = "Muy D&eacute;bil";
    } else if (strongRegex.test(pwd.value)) {
       strength.className += "label label-success";
       strength.innerHTML = "Fuerte";
    } else if (mediumRegex.test(pwd.value)) {
       strength.className += "label label-warning";
       strength.innerHTML = "Mediana";
    } else {
       strength.className += "label label-important";
       strength.innerHTML = "D&eacute;bil";
    }
}

/**
 * ESTA FUNCION TOMA UNA CADENA DE TEXTO Y LA 
 * ENCRYPTA CON sha-1 VER ARCHIVO ENCRIPCION.JS
 * @author Bernardo Zerda
 * @param object objTexto
 * @return void
 * @version 1,0 Abril 2009
 */
function encriptarCadena(idClave, idConfirmarClave) {

    // Obtiene los objetos de clave y confirmacion de clave
    var objClave = document.getElementById(idClave);
    var objConfirmarClave = document.getElementById(idConfirmarClave);
    var objAlerta = document.getElementById("compararClaves");

    // 40 caracteres es porque ya ha pasado por la encripcion
    if (objClave.value.length < 40) {

        // verifica que los vaores sean iguales
        if (objClave.value == objConfirmarClave.value) {
           objAlerta.className = "help-inline text-center label label-success";
           objAlerta.innerHTML = "Son Iguales";
           
           // encripta los valores digitados si son correctos
           objClave.value = hex_sha1(objClave.value);
           objConfirmarClave.value = hex_sha1(objConfirmarClave.value);

        } else {
           objAlerta.className = "help-inline text-center label label-important";
           objAlerta.innerHTML = "No Son Iguales";
        }

    }

}

$( "#frmOlvidoClave" ).submit( 
   function( event ){
      $("#olvidoClave").modal("hide");
      var mensajes = document.getElementById( 'mensajes' );
      mensajes.innerHTML = "<div class='info'><strong class='text-info'>Espere por favor...</strong><br><img src='./recursos/imagenes/cargando.gif'></div>";
      var datosFormulario = $( "#frmOlvidoClave" ).serialize();
      $.ajax(
         {
            type: "POST",
            url:  "./contenidos/administracion/olvidoContrasena.php",
            data: datosFormulario,
            success:
               function( data ){
                  mensajes.innerHTML = data;            
               }
         }
      );
      event.preventDefault();
   }
);

$( "#frmCiudadanos" ).submit(
   function(){
      $( "#offLine" ).modal("show");
//      $( "#cargando" ).modal("show");
//      var datosFormulario = $( "#frmCiudadanos" ).serialize();
//      $.ajax(
//         {
//            type: "POST",
//            url:  "./contenidos/ciudadano/ciudadano.php",
//            data: datosFormulario,
//            success:
//               function( data ){
//                  $( "#cargando" ).modal("hide");
//                  document.getElementById("fila").innerHTML = data;
//               }
//         }
//      );
      event.preventDefault();   
   }
);

/**
 * NO ENCONTRE UNA MANERA DE HACER UN onContentReady con BOOTSTRAP
 * ENTONCES INVOQUE LAS LIBRERIAS YAHOO Y EVENT PARA USAR EL 
 * onContentReady DE YUI PARA MOSTRAR EL DIALOGO CUANDO EL DIV
 * cambioClave APAREZCA
 * @returns {void}
 */
var fncCambioClave = function(){
   
   /**
    * ACTIVACION DEL POPUP MODAL BOOTSTRAP
    */
   $( "#cambioClave" ).modal("show"); 
   
   /**
   * FORMULARIO DE CAMBIO DE CLAVE OBLIGADO
   * LA FUNCION POR FUERA DEL LISTENER DE YUI NO FUNCIONA
   */
   $( "#frmCambioClave" ).submit(
      function( event ){
         
         var txtMensaje        = "";
         var objMensajesCambio = document.getElementById("mensajeCambio");
         var objMensajes       = document.getElementById("mensajes");
         
         if( document.getElementById( "usuarioCambio" ).value == "" ){
            txtMensaje += "No existe el usuario<br>";
         }
         
         if( document.getElementById( "actual" ).value == "" ){
            txtMensaje += "Digite la clave actual<br>";
         }
         
         if( document.getElementById( "nueva" ).value == "" ){
            txtMensaje += "Digite la clave nueva<br>";
         }
         
         if( document.getElementById( "confirmacion" ).value == "" ){
            txtMensaje += "Confirme la clave nueva<br>";
         }
         
         if( document.getElementById( "nueva" ).value != document.getElementById( "confirmacion" ).value ){
            txtMensaje += "La calve nueva y su confirmaci&oacute;n no coinciden<br>";
         }
         
         if( txtMensaje == "" ){
            
            var datosFormulario = $( "#frmCambioClave" ).serialize();
            $.ajax(
               {
                  type: "POST",
                  url:  "./contenidos/administracion/cambioClave.php",
                  data: datosFormulario,
                  success:
                     function( data ){
                        $( "#cambioClave" ).modal("hide"); 
                        objMensajes.innerHTML = data;
                     }
               }
            );
               
         } else {
            
            objMensajesCambio.className = "text-center alert alert-error";
            objMensajesCambio.innerHTML = txtMensaje;
            
         }
         
         event.preventDefault();
      }
   );
   
}
YAHOO.util.Event.onContentReady( "cambioClave", fncCambioClave ); // esto no es de bootstrap, esto es de YUI