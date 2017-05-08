
function paso(){
   
   var objMensajes       = document.getElementById("mensajes");
   var objBotones        = document.getElementById("divBotones");
   var arrBotones        = objBotones.getElementsByTagName("button");
   var objFormulario     = document.getElementById("frmValidacion");
   var arrPreguntas      = objFormulario.getElementsByTagName("div");
   var objSiguiente      = document.getElementById("btnSiguiente");
   var numTotalPasos     = arrBotones.length;
   var numPasoActual     = parseInt(document.getElementById("btnSiguiente").value);
   var numPasoSiguiente  = numPasoActual + 1;
   var objPreguntaActual = document.getElementById( "pregunta" + numPasoActual );
   var arrRespuestas     = objPreguntaActual.getElementsByTagName("input");
   var bolHayRespuesta   = false;
   var i = 0;
   
   // verifica que la pregunta este contestada
   for( i = 0 ; i < arrRespuestas.length ; i++ ){
      if( arrRespuestas[i].checked ){
         bolHayRespuesta = true;
      }
   }
   
   objMensajes.innerHTML = "";
   if( bolHayRespuesta ){

      if( numPasoSiguiente <= numTotalPasos ){
       
         // Mueve los botones
         for( i = 0 ; i < numTotalPasos ; i++ ){
            if( arrBotones[i].id == "btnPaso" + numPasoSiguiente ){
               arrBotones[i].className = "btn active btn-primary";
            } else {
               arrBotones[i].className = "btn";
            }
         }

         // Mueve la pregunta
         for( i = 0 ; i < arrPreguntas.length ; i++ ){
            if( arrPreguntas[i].id != "" ){
              if( arrPreguntas[i].id == "pregunta" + numPasoSiguiente ){
                 arrPreguntas[i].style.display = "";
              } else {
                 arrPreguntas[i].style.display = "none";
              }
            }
         }

         // Mueve el paso
         objSiguiente.value = numPasoSiguiente;

      } else {
         
         $( "#cargando" ).modal("show");
         var datosFormulario = $( "#frmValidacion" ).serialize();
         $.ajax(
            {
               type: "POST",
               url:  "./contenidos/ciudadano/resultado.php",
               data: datosFormulario,
               success:
                  function( data ){
                     $( "#cargando" ).modal("hide");
                     document.getElementById("fila").innerHTML = data;
                  }
            }
         );
            
       }
       
    } else {
      objMensajes.innerHTML = "<div class='alert alert-block alert-error fade in'><button type='button' class='close' data-dismiss='alert'>×</button><h4 class='alert-heading'>Atenci&oacute;n:</h4><div style='width:650px;'><ul><li style='text-align:left;'>Debe dar respuesta a la pregunta para poder continuar</li></ul></div></div>";
    }
    
}

function cartaMovilizacion( numDocumento , txtNombreBanco , numCuenta ){
   
   var wndFormato = null;
   try {
       var numAlto  = 900;
       var txtUrl = "./contenidos/ciudadano/cartaMovilizacion.php";
           txtUrl += "?documento=" + numDocumento + "&banco=" + txtNombreBanco + "&cuenta=" + numCuenta;
       var txtParametros = "resizable=0,location=0,scrollbars=1,width=780,height="+numAlto+",left=100,top=10,titlebar=0";
       if (!(wndFormato = window.open(txtUrl, '_blank', txtParametros))) {
           throw "ErrorPopUp";
       }
   } catch (objError) {
       if (objError == "ErrorPopUp") {
           alert("Ooops, al parecer tu navegador tiene bloqueado las ventanas emergentes, desactiva esa opcion y vuelve a intentar");
       }
   }
   
}

function eliminarInscripcion(){   
   $("#eliminarInscripcion").modal("show");
}
 
function prueba(){ 

   var datosFormulario = $( "#frmEliminarInscripcion" ).serialize();
   $.ajax(
      {
         type: "POST",
         url:  "./contenidos/ciudadano/eliminarInscripcion.php",
         data: datosFormulario,
         success:
            function( data ){
               $( "#eliminarInscripcion" ).modal("hide");
               document.getElementById("fila").innerHTML = data;
            }
      }
   );
   
}