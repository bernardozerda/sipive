
/**
 * BIBLIOTECA DE FUNCIONES JAVASCRIPT
 * @author Bernardo Zerda
 * @version 1.0 Marzo 2009
 */

/**
 * CARGA LA SALIDA DE txtArchivoPhp EN EL OBJETO DOM CON
 * IDENTIFICADOR txtDivDestino, SE LE PUEDEN PASAR LOS 
 * PARAMETROS EN FORMATO GET EN EL STING txtParametros
 * Y ESTAS VARIABLES SON ENVIADAS POST. EL PARAMETRO bolCargando
 * ES TRUE CUANDO QUIERA QUE SE BLOQUEE AL USUARIO MIENTRAS
 * SE PROCESA LA PETICION.
 * @author Bernardo Zerda
 * @param string txtDivDestino
 * @param string txtArchivoPhp
 * @param string txtParametros
 * @param boolean bolCargando
 * @return object callObj ==> el objeto que retorna la transaccion asyncRequest
 * @version 1,0 Marzo 2009
 */

var mychartMostrar;

function cargarContenido(txtDivDestino, txtArchivoPhp, txtParametros, bolCargando) {

    document.getElementById(txtDivDestino).innerHTML = '';

    // Determina si la ventan de bloque al usuario mientras carga el script se muestra		
    bolCargando = typeof (bolCargando) != 'undefined' ? bolCargando : 0;
    if (bolCargando == 1) {
        var objCargando = obtenerObjetoCargando( );
    }

    // Objeto de respuesta si es satisfactoria la carga
    var handleSuccess =
            function (o) {
                if (o.responseText !== undefined) {

                    // Toda respuesta del archivo en el parametro se muestra en el objeto destino
                    document.getElementById(txtDivDestino).innerHTML = o.responseText;

                    // si hubo pantalla de bloque al usuario, se oculta
                    if (bolCargando == 1) {
                        objCargando.hide();
                        tablas();
//                        $(document).ready(function () {
//                            $("#accordion").accordion();
//                            $('#example').DataTable({
//                                "pagingType": "full_numbers",
//                                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
//                                "order": [[2, "desc"]]
//                            });
//                        });
                    }
                }
            };

    // Objeto de respuesta si la carga falla
    var handleFailure =
            function (o) {
                if (o.responseText !== undefined) {
                    // Cuando se vence la sesion la respuesta es HTTP 401 = Not Authorized
                    if (o.status == "401") {
                        document.location = 'index.php';
                    } else {

                        // Mensaje cuando la pagina no es encontrada
                        var htmlCode = "";
                        htmlCode = +o.status + " " + o.statusText;

                        // Otros mensajes de error son mostrados directamente en el div
                        document.getElementById(txtDivDestino).innerHTML = htmlCode;
                    }
                    if (bolCargando == 1) {
                        objCargando.hide();
                    }
                    return false;
                }
            };

    // Objeto de respuestas
    var callback =
            {
                success: handleSuccess,
                failure: handleFailure
            };

    // si hay pantalla de bloque al usuario se muestra
    if (bolCargando == 1) {
        objCargando.show();
    }

    // peticion asincrona al servidor
    var callObj = YAHOO.util.Connect.asyncRequest("POST", txtArchivoPhp, callback, txtParametros);

    return callObj;
}

/**
 * RETORNA UN OBJETO PANEL QUE SE MUESTRA 
 * MIENTRAS CARGA UNA PETICION DEL USUARIO
 * @author Bernardo Zerda
 * @param Void
 * @return Panel objCargando
 * @version 1.0 Marzo 2009
 */
function obtenerObjetoCargando() {

    // Instancia un objeto panel
    var objCargando = new YAHOO.widget.Panel(
            "wait",
            {
                width: "250px",
                fixedcenter: true,
                close: false,
                draggable: false,
                modal: true,
                visible: false
            }
    );

    // Encabezado
    objCargando.setHeader("Por Favor Espere...");

    // cuerpo del panel
    objCargando.setBody("<img src='./recursos/imagenes/cargando.gif'>");

    // El objeto se despliega sobre el cuerpo del documento html
    objCargando.render(document.body);

    return objCargando;
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
 * SOLO PERMANECE EL PRIMER FRAGMENTO DEL CAMPO
 * @author Jaison Ospina
 * @param object objLimpiar
 * @return Void
 * @version 1.0 Abril 12 2016
 */
function soloLetrasEspacio(objLimpiar) {
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
    objLimpiar.value = txtResultado.substr(0, (txtResultado + " ").indexOf(" "));
}

/**
 * SOLO DEJA LOS CARACTERES QUE SEAN LETRAS Y NUMEROS EN UN INPUT
 * @author Diego Gaitan
 * @param object objLimpiar
 * @return Void
 * @version 1.0 Diciembre 14 2010
 */
function soloLetrasNumeros(objLimpiar) {
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
            txtResultado += txtCaracter.replace(/[^A-Za-z0-9\ ]/, ""); // solo se permiten letras, numeros, punto(.), slash(/), arroba(@), espacios( ) y tildes
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
        txtResultado += txtCaracter.replace(/[^0-9\.]/, "");
    }
    objLimpiar.value = txtResultado;
}

function soloNit(objLimpiar) {

    var txtTexto = objLimpiar.value;
    var txtResultado = "";
    var txtCaracter = "";
    for (i = 0; i < txtTexto.length; i++) {
        txtCaracter = txtTexto.charAt(i);
        txtResultado += txtCaracter.replace(/[^0-9\-]/, "");
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
                txtCaracter.toString().charCodeAt(0) != 241 && //  ï¿½ (enie)
                txtCaracter.toString().charCodeAt(0) != 193 && //  A
                txtCaracter.toString().charCodeAt(0) != 201 && //  E
                txtCaracter.toString().charCodeAt(0) != 205 && //  I
                txtCaracter.toString().charCodeAt(0) != 211 && //  O
                txtCaracter.toString().charCodeAt(0) != 218 && //  U
                txtCaracter.toString().charCodeAt(0) != 220 && //  U + dieresis
                txtCaracter.toString().charCodeAt(0) != 209    //  ï¿½ (enie mayuscula)
                ) {
            txtResultado += txtCaracter.replace(/[^a-zA-Z0-9\-\_\.\@\ \/]/, "");
        } else {
            txtResultado += txtCaracter;
        }

    }
    objLimpiar.value = txtResultado;
}


/**
 * MUESTRA EL OBJETO CALENDARIO
 * @author Bernardo Zerda
 * @param string idObjeto
 * @param stroing txtTitulo --> titulo del calendario
 * @return Void
 * @version 1.0 Marzo 29 2009
 * @deprecated
 */
//	function mostrarCalendario( idObjeto , txtTitulo ){
//		
//		// Instancia un pbjeto calendario
//    var objCalendario = new YAHOO.widget.Calendar( 
//      "calendario",
//      idObjeto + "Calendario",
//      {
//      	title: txtTitulo,
//        close: true  
//      }
//    );
//    
//    // los nombres de los meses y los dias se colocan en espaï¿½ol
//    objCalendario.cfg.setProperty("MONTHS_LONG",[ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]);
//    objCalendario.cfg.setProperty("WEEKDAYS_MEDIUM",["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"]);  
//    
//    // resta funcion se ejecuta cuando se hace click en alguna fecha del calendario
//    function handleSelect(type,args,obj) {
//      
//      var dates = args[0]; 
//      var date = dates[0];
//      var year = date[0], month = date[1], day = date[2]; // formatea la fecha
//      
//      var txtDate1 = document.getElementById( idObjeto ); // objeto destino de la fecha seleccionada
//      txtDate1.value = year + "-" + month + "-" + day;
//      txtDate1.focus();
//      obj.hide(); // oculta el objeto calendario
//    }
//		
//		// suscribe la funcion para que sea ejecutada en el evento de seleccionar una fecha
//    objCalendario.selectEvent.subscribe( handleSelect, objCalendario, true );
//    
//    objCalendario.render(); // dibuja el calendario
//    objCalendario.show();   // hace visible el calendario
//    
//	}

/**
 * ENVIA LOS DATOS DEL FORMULARIO objFormulario AL
 * ARCHIVO txtArchivo Y SU SALIDA LA IMPRIME EB txtDivDestino
 * EL PARAMETRO cargaArchivos INDICA SI EL FORMULARIO TIENE
 * OBJETOS INPUT DE TIPO FILE (valor true del parametro) Y
 * SI SE REQUIERE EL PANEL DE LOADING AL USUARIO
 * @author Bernardo Zerda
 * @param string txtDivDestino
 * @param object objFormulario
 * @param string txtArchivo
 * @param boolean cargaArchivos ==> true cuando en el formulario hay un input de tipo file
 * 							    ==> true provoca que se envie aparte del $_POST la variable $_FILES
 * @param boolean objetoCargando
 * @return Void
 * @version 1.0 Marzo 29 2009
 */
function someterFormulario(txtDivDestino, objFormulario, txtArchivo, cargaArchivos, objetoCargando) {

    // Limpia el area donde el usuario siempre encontrarï¿½ los errores
    if (document.getElementById("mensajes")) {
        document.getElementById("mensajes").innerHTML = "";
    }

    // Verifica si es necesaria la pantalla de bloqueo al usuario
    objetoCargando = typeof (objetoCargando) != 'undefined' ? objetoCargando : 0;

    window.scrollTo(0, 0); // ubica el scroll al inicio

    // si hay pantalla de bloqueo obtiene la instancia del objeto
    if (objetoCargando == 1) {
        var objCargando = obtenerObjetoCargando();
    }

    // Registra el formulario
    YAHOO.util.Connect.setForm(objFormulario, cargaArchivos, true);

    // Objeto de respuesta si es satisfactoria la carga 
    var handleSuccess =
            function (o) {

                if (o.responseText !== undefined) {
                    //        	alert('ok');
                    // oculta la pantalla de bloqueo segin sea el caso
                    if (objetoCargando == 1) {
                        objCargando.hide();
                    }

                    // toda respuesta se envia al objeto destino
                    document.getElementById(txtDivDestino).innerHTML = o.responseText;
                }

            };

    // Objeto de respuesta si la carga falla
    var handleFailure =
            function (o) {
                //    	alert('fallo');
                if (o.responseText !== undefined) {
                    // Cuando se vence la sesion la respuesta es
                    // HTTP 401 = Not Authorized
                    // Lo envï¿½a a la pagina de login
                    if (o.status == "401") {
                        document.location = 'index.php';
                    }

                    // Otros mensajes de error son mostrados directamente en el div
                    document.getElementById('mensajes').innerHTML = o.status + "<br>";
                    document.getElementById('mensajes').innerHTML += o.statusText;
                    if (objetoCargando == 1) {
                        objCargando.hide();
                    }

                }

            };

    // Objeto de respuesta para la carga de archivos   
    // Esto es cuando en el form hay un inpuy de tipo file y se coloca true en el paramentro correspondiente
    // en la firma de esta funcion.
    var handleUpload =
            function (o) {
                //    	alert('upload');
                if (o.responseText !== undefined) {

                    // oculta la pantalla de bloqueo segin sea el caso
                    if (objetoCargando == 1) {
                        objCargando.hide();
                    }

                    // toda respuesta se envia al objeto destino
                    document.getElementById(txtDivDestino).innerHTML = o.responseText;

                }

            };

    // Objeto de respuestas con upload de archivos
    var callbackError =
            {
                success: handleSuccess,
                failure: handleFailure,
                upload: handleUpload
            };

    if (objetoCargando == 1) {
        objCargando.show();
    }

    // LLamado remoto al archivo requerido
    var oConnect = YAHOO.util.Connect.asyncRequest('POST', txtArchivo, callbackError);
    return oConnect;

}

/**
 * ESTA FUNCION SE USA EN LOS LISTENER PARA
 * CUANDO SE VA A INSTANCIAR DE NUEVO.
 * TOMA EL OBJETO Y LO ELIMINA DE LA PANTALLA
 * @author Bernardo Zerda
 * @param string idObj
 * @return void
 * @version 1,0 Marzo 2009
 */
function eliminarObjeto(idObj) {

    // obtiene el objeto a eliminar
    objBorrar = document.getElementById(idObj);

    // Verifica la existencia del objeto en la pantalla
    if (typeof (objBorrar) != 'undefined' && objBorrar != null) {
        padre = document.getElementById(idObj).parentNode;  // obtiene el nodo padre 
        hijo = document.getElementById(idObj); 						// obtiene el objeto hijo --> el mismo objeto a borrar
        padre.removeChild(hijo); 														// elimina el objeto hijo
    }

}

/**
 * ESTA FUNCION MUESTRA EL MENSAJE DE COMPROBACION
 * QUE EL USUARIO VE CUANDO SELECCIONA BORRAR UN REGISTRO
 * @author Bernardo Zerda
 * @param integer seqRegistro
 * @param string txtPregunta
 * @param string txtArchivo
 * @return Void
 * @version 1.0 Abril 2009
 */
function eliminarRegistro(seqRegistro, txtPregunta, txtArchivo) {

    // Objeto que contiene los atributos del cuadro de dialogo
    var objAtributos = {
        width: "300px",
        effect: {
            effect: YAHOO.widget.ContainerEffect.FADE,
            duration: 0.75
        },
        fixedcenter: true,
        modal: true,
        draggable: true,
        close: false
    }

    // INSTANCIA EL OBJETO DIALOGO
    var objDialogo = new YAHOO.widget.SimpleDialog("dlg", objAtributos);

    objDialogo.setHeader("Atencion Requerida !!"); // encabezado del objeto
    objDialogo.setBody(txtPregunta);			   // texto que se muestra en el cuerpo (formato html)
    objDialogo.cfg.setProperty("icon", YAHOO.widget.SimpleDialog.ICON_WARN); // Icono de advertencia que se ve en el cuadro

    // COMPORTAMIENTO SI SE PRESIONA -- SI -- EN EL CUADRO
    var handleYes = function () {

        var txtParametros = "";
        if (typeof (YAHOO.util.Dom.get("txtComentario")) != "undefined") {
            var objComentario = YAHOO.util.Dom.get("txtComentario");
            txtParametros += "&txtComentario=" + objComentario.value;
        }

        if (typeof (YAHOO.util.Dom.get("seqGestion")) != "undefined") {
            var objGestion = YAHOO.util.Dom.get("seqGestion");
            txtParametros += "&seqGestion=" + objGestion.options[ objGestion.selectedIndex ].value;
        }

        if (typeof (YAHOO.util.Dom.get("borrarAAD")) != "undefined") {
            var objBorrarAAD = YAHOO.util.Dom.get("borrarAAD");
            txtParametros += "&bolBorrar=" + objBorrarAAD.checked;
        }

        // Envia los datos el archivo que contesta la peticion de borrado
        cargarContenido("mensajes", txtArchivo, "seqBorrar=" + seqRegistro + txtParametros, true);

        // cuando la respuesta esta lista, verifica por medio de la clase (css)
        // si la respuesta es satisfactoria, de ser asi, elimina de la pantalla el 
        // objeto que contiene el registro en pantalla
        YAHOO.util.Event.onContentReady(
                "tablaMensajes",
                function () {
                    // Cambiar 'msgOk' si la clase (css) que muestra los mensajes satisfactorios no se llama asi
                    if (document.getElementById('tablaMensajes').className == "msgOk") {
                        eliminarObjeto(seqRegistro);
                    }
                }
        );

        this.hide(); // oculta el objeto de confirmacion
    }

    // COMPORTAMIENTO SI SE PRESIONA -- NO -- EN EL CUADRO
    var handleNo = function () {
        document.getElementById("mensajes").innerHTML = "";
        this.hide();
    }

    // Botones para aÃ±adir al cuadro de dialogo
    // No poner esto antes de la declartacion de los manejadores
    var arrBotones = [
        {
            text: "Si",
            handler: handleYes
        },
        {
            text: "No",
            handler: handleNo,
            isDefault: true
        }
    ];

    objDialogo.cfg.queueProperty("buttons", arrBotones);

    // Muestra el cuadro de dialogo
    objDialogo.render(document.body);
    objDialogo.show();

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

    // 40 caracteres es porque ya ha pasado por la encripcion
    if (objClave.value.length < 40) {

        // verifica que los vaores sean iguales
        if (objClave.value == objConfirmarClave.value) {
            document.getElementById("compararClaves").innerHTML = "<span style='color:green'>Son Iguales</span>";

            // encripta los valores digitados si son correctos
            objClave.value = hex_sha1(objClave.value);
            objConfirmarClave.value = hex_sha1(objConfirmarClave.value);

        } else {
            document.getElementById("compararClaves").innerHTML = "<span style='color:red'>No Son Iguales</span>";
        }

    }

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

    // coloca el mensaje adecuado para informar al usuario de la fortaleza de la clave digitada
    if (pwd.value.length == 0) {
        strength.innerHTML = "Digite Clave";
    } else if (false == enoughRegex.test(pwd.value)) {
        strength.innerHTML = "<span style='color:red'>Muy D&eacute;bil</span>";
    } else if (strongRegex.test(pwd.value)) {
        strength.innerHTML = "<span style='color:green'>Fuerte</span>";
    } else if (mediumRegex.test(pwd.value)) {
        strength.innerHTML = "<span style='color:orange'>Mediana</span>";
    } else {
        strength.innerHTML = "<span style='color:red'>D&eacute;bil</span>";
    }
}

/**
 * MUESTRA U OCULTA UN OBJETO HTML
 * @author Bernardo Zerda
 * @param string idObj
 * @return strin txtEstado
 * @version 1,0 Abril de 2009
 */
function mostrarOcultar(idObj) {

    // si el display del objeto esta oculto lo muestra en caso contrario lo oculta
    // retorna la accion realizada

    if (document.getElementById(idObj).style.display == "none") {
        document.getElementById(idObj).style.display = "";
        selectAnidados(0, 0);
        return "mostrar";

    } else {
        document.getElementById(idObj).style.display = "none";
        return "ocultar";
    }

}

/**
 * POP UP QUE SE MUESTRA CUANDO EL 
 * USUARIO SOLICITA CAMBIAR LA CONTRASENA
 * @author Bernardo Zerda
 * @param txtUsuario
 * @return Voida
 * @version 1.0 Abril 2009
 */

function olvidoContrasena(txtUsuario) {

    var objError = document.getElementById("errorUsuario"); 					// donde se mostraran los errores dentro de la ventana emergente
    var objDialogo = document.getElementById("dlgOlvidoContrasena");  // Objeto que sera el dialogo que se muestra al usuario

    objError.innerHTML = ""; // limpia los errores

    // Limpia los datos del formulario y oculta el objeto de los errores
    document.getElementById("olvidoUsuario").value = "";
    document.getElementById("correo").value = "";
    document.getElementById("errorOlvido").innerHTML = "";
    document.getElementById("errorOlvido").style.display = "none";

    // si no hay digitado un usuario no puede continuar
    objError.innerHTML = "";
    if (txtUsuario == "") {
        objError.innerHTML = "Indique el usuario";
    } else {

        objDialogo.style.display = ""; // muestra el objeto dialogo


        // Manejador del boton submit
        var handleSubmit = function (o) {

            document.getElementById("errorOlvido").style.display = ""; // muestra el objeto de los mensjaes

            // lo parametros que seran faciliados al archivo de recuperacion de clave
            var txtParametros = "usuario=" + document.getElementById("olvidoUsuario").value + "&";
            txtParametros += "correo=" + document.getElementById("correo").value;

            // hace el llamado asincrono y obtiene el objeto que contiene los datos de la transaccion
            var objCall = cargarContenido("errorOlvido", "./contenidos/administracion/olvidoContrasena.php", txtParametros);

            // si el llamado esta aun en proceso muestra una imagen que muestra al usuario que se esta procesando
            if (YAHOO.util.Connect.isCallInProgress(objCall)) {
                document.getElementById("errorOlvido").innerHTML = "<img src='./recursos/imagenes/cargando.gif'>";
            }

        };

        // Manejador del boton cancelar
        var handleCancel = function () {
            this.cancel();
        };

        // objeto de configuracion del panel que se muestra
        var objConfiguracion = {
            width: "400px",
            height: "300px",
            fixedcenter: true,
            visible: false,
            close: true,
            constraintoviewport: true,
            draggable: true,
            modal: true,
            buttons: [
                {
                    text: "Aceptar",
                    handler: handleSubmit,
                    isDefault: true
                },
                {
                    text: "Cancelar",
                    handler: handleCancel
                }
            ],
            effect: {
                effect: YAHOO.widget.ContainerEffect.FADE,
                duration: 0.75
            }
        };

        // instancia el objeto dialogo
        var objDialogo = new YAHOO.widget.Dialog(objDialogo, objConfiguracion);

        document.getElementById("olvidoUsuario").value = document.getElementById("usuario").value;

        objDialogo.render(); // dibuja el objeto
        objDialogo.show();	 // hace visible el objeto		 

    }

}

/**
 * TOMA LA CEDULA QUE EL USUARIO DIGITA Y LA 
 * ENVIA PARA BUSCAR EN LA BASE DE DATOS
 * @autor Bernardo Zerda
 * @version 1.0 Mayo 2009
 */

function buscarCedula(txtNombreArchivo) {

    var objCedula = document.getElementById("buscaCedula");
    var objCedulaConfirmacion = document.getElementById("buscaCedulaConfirmacion");
    var objMensajes = document.getElementById("mensajes");

    // Limpia los mensajes de la barra de mensajes
    objMensajes.innerHTML = "";

    // Valida que el campo cedula tenga algo
    if (objCedula.value == "") {
        objMensajes.innerHTML += "<li>Digite un n" + String.fromCharCode(250) + "mero de c" + String.fromCharCode(233) + "dula v" + String.fromCharCode(225) + "lido";
    }

    // Valida que haya algo en la confirmacion
    if (objCedulaConfirmacion.value == "") {
        objMensajes.innerHTML += "<li>Debe confirmar el valor digitado</li>";
    }

    // Valida que ambos valores sean iguales
    if (objCedula.value != objCedulaConfirmacion.value) {
        objMensajes.innerHTML += "<li>No coinciden los documentos digitados, verifique los datos</li>";
    }


    if (objMensajes.innerHTML == "") {
        cargarContenido("formulario", "contenidos/" + txtNombreArchivo + ".php", "cedula=" + objCedula.value, true);
    } else {
        objMensajes.className = "msgError";
    }

}

function agregarMiembroHogar() {

    var arrAbreviacionesTipoDocumento = new Array();
        arrAbreviacionesTipoDocumento[ 1 ] = "C.C.";
        arrAbreviacionesTipoDocumento[ 2 ] = "C.E.";
        arrAbreviacionesTipoDocumento[ 3 ] = "T.I.";
        arrAbreviacionesTipoDocumento[ 4 ] = "R.C.";
        arrAbreviacionesTipoDocumento[ 5 ] = "PAS.";
        arrAbreviacionesTipoDocumento[ 6 ] = "NIT.";
        arrAbreviacionesTipoDocumento[ 7 ] = "N.U.I.";

    // Variable a recoger del nuevo miembro del hogar
    var objNombre1 = document.getElementById("nombre1");
    var objNombre2 = document.getElementById("nombre2");
    var objApellido1 = document.getElementById("apellido1");
    var objApellido2 = document.getElementById("apellido2");
    var objTpoDocumento = document.getElementById("tipoDocumento");
    var objNumDocumento = document.getElementById("numeroDoc");
    var objParentesco = document.getElementById("parentesco");
    var objFchNacimiento = document.getElementById("fechaNac");
    var objCondEspecial = document.getElementById("condicionEspecial");
    var objCondEspecial2 = document.getElementById("condicionEspecial2");
    var objCondEspecial3 = document.getElementById("condicionEspecial3");
    var objCondEtnica = document.getElementById("condicionEtnica");
    var objEstCivil = document.getElementById("estadoCivil");
    var objOcupacion = document.getElementById("ocupacion");
    var objSexo = document.getElementById("sexo");
    var objLgtb = document.getElementById("bolLgtb");
    var objIngresos = document.getElementById("ingresos");
    var objNvlEducativo = document.getElementById("nivelEducativo");
    var objAnosAprobados = document.getElementById("numAnosAprobados");
    var objSeqSalud = document.getElementById("seqSalud");
    var objSeqTipoVictima = document.getElementById("seqTipoVictima");
    var objSeqGrupoLgtbi = document.getElementById("seqGrupoLgtbi");
    var objSeqCajaCompensacion = document.getElementById("cajaCompensacion");

    var numDocumento = objNumDocumento.value.replace(/[^0-9]/g,"");
    var valIngresos = objIngresos.value.replace(/[^0-9]/g,"");

    // Si el nivel educativo es ninguno no valida los anios aprobados
    if( $("#nivelEducativo").val() == 0 ){
        alert("Seleccione el nivel educativo");
        objNvlEducativo.focus();
        return false;
    }else {
        if ($("#nivelEducativo").val() != 1) {
            if (objAnosAprobados != null) {
                if ($("#numAnosAprobados").val() == "" || $("#numAnosAprobados").val() == 0) {
                    alert("Seleccione los a" + String.fromCharCode(241) + "os aprobados");
                    objAnosAprobados.focus();
                    return false;
                }
            }
        }
    }

    // Celda que contiene los miembros del hogar
    var objHogar = document.getElementById("datosHogar");

    // Primer Apellido no puede estar vacio
    if (objApellido1.value == "") {
        alert("El primer apellido no puede estar vac" + String.fromCharCode(237) + "o");
        objApellido1.focus();
        return false;
    }

    // Primer Nombre no puede estar vacio
    if (objNombre1.value == "") {
        alert("El primer nombre no puede estar vac" + String.fromCharCode(237) + "o");
        objNombre1.focus();
        return false;
    }

    // Tiene que tener numero de documento
    if (objNumDocumento.value == "") {
        alert("No puede registrar una persona sin el numero de docuemnto");
        objNumDocumento.focus();
        return false;
    }

    // Valida que la fecha sea correcta
    if (!esFechaValida(objFchNacimiento)) {
        objFchNacimiento.focus()
        return false;
    }

    // Debe tener ingresos mensuales
    if (objIngresos.value == "") {
        alert("Debe registrar el ingreso mensual del ciudadano");
        objIngresos.focus();
        return false;
    }

    // Debe tener parentesco
    if (objParentesco.selectedIndex == 0) {
        alert("Debe registrar el parentezco del ciudadano");
        objParentesco.focus();
        return false;
    }

    // Debe tener estado civil
    if (objEstCivil.selectedIndex == 0) {
        alert("Debe registrar el estado civil del ciudadano");
        objEstCivil.focus();
        return false;
    }

    // Afiliacion a salud
    if (objSeqSalud.selectedIndex == 0) {
        alert("Debe seleccionar la afiliacion a salud");
        objSeqSalud.focus();
        return false;
    }


    // Validacion de cedula -- Si ya esta incluido
    var arrMiembros = objHogar.getElementsByTagName("table");
    for (i = 0; i < arrMiembros.length; i++) {
        if (numDocumento == arrMiembros[ i ].id) {
            alert("Ya esta registrada una persona con cedula " + objNumDocumento.value);
            return false;
        }
    }

    // Ciudadano
    var txtNombreCiudadano = ucwords(objNombre1.value.toString().toLowerCase() + " " + objNombre2.value.toString().toLowerCase() + " " + objApellido1.value.toString().toLowerCase() + " " + objApellido2.value.toString().toLowerCase());

    // Abreviacion del tipo de documento
    var seqTipoDocumento = objTpoDocumento.options[ objTpoDocumento.selectedIndex ].value;
    var txtTipoDocumento = arrAbreviacionesTipoDocumento[ seqTipoDocumento ];
    var txtParentesco = objParentesco.options[ objParentesco.selectedIndex ].text;
    var txtOcupacion = objOcupacion.options[ objOcupacion.selectedIndex ].text;
    txtOcupacion = txtOcupacion.toString().toLowerCase();
    txtOcupacion = ucwords(txtOcupacion);

    var txtInsertar = "";
    txtInsertar += "<table cellpadding='0' cellspacing='0' border='0' width='100%' id='" + numDocumento + "'> ";
    txtInsertar += "	<tr onMouseOver='this.style.background = \"#E4E4E4\";' onMouseOut='this.style.background = \"#F9F9F9\"; ' style='cursor:pointer'> ";
    txtInsertar += "		<td align='center' width='18px' height='22px'> ";
    txtInsertar += "			<div style='width:12px; height:14px; cursor:pointer; border: 1px solid #999999;' ";
    txtInsertar += "				 onClick='desplegarDetallesMiembroHogar(\"" + numDocumento + "\")' ";
    txtInsertar += "				 onMouseOver='this.style.backgroundColor=\"#ADD8E6\";' ";
    txtInsertar += "				 onMouseOut='this.style.backgroundColor=\"#FFFFFF\";' ";
    txtInsertar += "				 id='masDetalles" + numDocumento + "' ";
    txtInsertar += "			>+</div>   ";
    txtInsertar += "		</td> ";
    txtInsertar += "		<td width='282px' style='padding-left:5px;'>" + txtNombreCiudadano + "</td> ";
    txtInsertar += "		<td width='140px' align='right'  style='padding-right: 15px'>" + txtTipoDocumento + " " + objNumDocumento.value + "</td> ";
    txtInsertar += "		<td width='260px'>" + txtParentesco + "</td> ";
    txtInsertar += "		<td align='right' style='padding-right:7px'>$ " + objIngresos.value + "</td> ";
    txtInsertar += "		<td align='center' width='18px' height='22px'> ";
    txtInsertar += "			<div	style='width:12px; height:14px; cursor:pointer; border: 1px solid #999999;' ";
    txtInsertar += "					onClick='modificarMiembroHogar(\"" + numDocumento + "\")' ";
    txtInsertar += "					onMouseOver='this.style.backgroundColor=\"#ADD8E6\";' ";
    txtInsertar += "					onMouseOut='this.style.backgroundColor=\"#FFFFFF\";' ";
    txtInsertar += "			>E</div> ";
    txtInsertar += "		</td> ";
    txtInsertar += "		<td align='center' width='18px' height='22px'> ";
    txtInsertar += "			<div	style='width:12px; height:14px; cursor:pointer; border: 1px solid #999999;' ";
    txtInsertar += "					onClick='quitarMiembroHogar(\"" + numDocumento + "\");' ";
    txtInsertar += "					onMouseOver='this.style.backgroundColor=\"#FFA4A4\";' ";
    txtInsertar += "					onMouseOut='this.style.backgroundColor=\"#FFFFFFp\";' ";
    txtInsertar += "			>X</div>   ";
    txtInsertar += "		</td> ";
    txtInsertar += "	</tr> ";

    txtInsertar += "<input type='hidden' id='parentesco-" + numDocumento + "' value='" + objParentesco.options[ objParentesco.selectedIndex ].value + "'>";
    txtInsertar += "<input type='hidden' id='ingreso-" + numDocumento + "' value='" + valIngresos + "'>";

    if(objAnosAprobados.selectedIndex == -1){
        objAnosAprobados.selectedIndex = 0;
    }

    txtInsertar += "<input type='hidden' id='" + numDocumento + "-txtNombre1' name='hogar[" + numDocumento + "][txtNombre1]' value='" + objNombre1.value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-txtNombre2' name='hogar[" + numDocumento + "][txtNombre2]' value='" + objNombre2.value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-txtApellido1' name='hogar[" + numDocumento + "][txtApellido1]' value='" + objApellido1.value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-txtApellido2' name='hogar[" + numDocumento + "][txtApellido2]' value='" + objApellido2.value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-seqTipoDocumento' name='hogar[" + numDocumento + "][seqTipoDocumento]' value='" + objTpoDocumento.options[ objTpoDocumento.selectedIndex ].value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-numDocumento' name='hogar[" + numDocumento + "][numDocumento]' value='" + numDocumento + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-seqParentesco' name='hogar[" + numDocumento + "][seqParentesco]' value='" + objParentesco.options[ objParentesco.selectedIndex ].value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-fchNacimiento' name='hogar[" + numDocumento + "][fchNacimiento]' value='" + objFchNacimiento.value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-seqCondicionEspecial' name='hogar[" + numDocumento + "][seqCondicionEspecial]' value='" + objCondEspecial.options[ objCondEspecial.selectedIndex ].value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-seqCondicionEspecial2' name='hogar[" + numDocumento + "][seqCondicionEspecial2]' value='" + objCondEspecial2.options[ objCondEspecial2.selectedIndex ].value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-seqCondicionEspecial3' name='hogar[" + numDocumento + "][seqCondicionEspecial3]' value='" + objCondEspecial3.options[ objCondEspecial3.selectedIndex ].value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-seqEtnia' name='hogar[" + numDocumento + "][seqEtnia]' value='" + objCondEtnica.options[ objCondEtnica.selectedIndex ].value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-seqEstadoCivil' name='hogar[" + numDocumento + "][seqEstadoCivil]' value='" + objEstCivil.options[ objEstCivil.selectedIndex ].value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-seqOcupacion' name='hogar[" + numDocumento + "][seqOcupacion]' value='" + objOcupacion.options[ objOcupacion.selectedIndex ].value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-seqSexo' name='hogar[" + numDocumento + "][seqSexo]' value='" + objSexo.options[ objSexo.selectedIndex ].value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-bolLgtb' name='hogar[" + numDocumento + "][bolLgtb]' value='" + objLgtb.options[ objLgtb.selectedIndex ].value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-valIngresos' name='hogar[" + numDocumento + "][valIngresos]' value='" + valIngresos + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-seqNivelEducativo' name='hogar[" + numDocumento + "][seqNivelEducativo]' value='" + objNvlEducativo.options[ objNvlEducativo.selectedIndex ].value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-numAnosAprobados' name='hogar[" + numDocumento + "][numAnosAprobados]' value='" + objAnosAprobados.options[ objAnosAprobados.selectedIndex ].value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-seqSalud' name='hogar[" + numDocumento + "][seqSalud]' value='" + objSeqSalud.options[ objSeqSalud.selectedIndex ].value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-seqTipoVictima' name='hogar[" + numDocumento + "][seqTipoVictima]' value='" + objSeqTipoVictima.options[ objSeqTipoVictima.selectedIndex ].value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-seqGrupoLgtbi' name='hogar[" + numDocumento + "][seqGrupoLgtbi]' value='" + objSeqGrupoLgtbi.options[ objSeqGrupoLgtbi.selectedIndex ].value + "'>";
    txtInsertar += "<input type='hidden' id='" + numDocumento + "-seqCajaCompensacion' name='hogar[" + numDocumento + "][seqCajaCompensacion]' value='" + objSeqCajaCompensacion.value + "'>";
    txtInsertar += "</table> ";

    txtInsertar += "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" style=\"display:none\" id=\"detalles" + numDocumento + "\"> ";
    txtInsertar += "<tr> ";
    txtInsertar += "<td colspan=\"6\"> ";
    txtInsertar += "<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\" style=\"border: 1px solid #999999;\"> ";
    txtInsertar += "<tr> ";
    txtInsertar += "<td><b>Estado Civil:</b> " + objEstCivil.options[ objEstCivil.selectedIndex ].text + "</td> ";
    txtInsertar += "<td><b>Condici&oacute;n &Eacute;tnica:</b> " + ucwords(objCondEtnica.options[ objCondEtnica.selectedIndex ].text.toString().toLowerCase()) + "</td> ";
    txtInsertar += "</tr> ";
    txtInsertar += "<tr> ";
    txtInsertar += "<td><b>Sexo:</b> " + objSexo.options[ objSexo.selectedIndex ].text + "</td> ";
    txtInsertar += "<td><b>Condici&oacute;n Especial 1:</b> " + objCondEspecial.options[ objCondEspecial.selectedIndex ].text + "</td> ";
    txtInsertar += "</tr> ";
    txtInsertar += "<tr> ";
    txtInsertar += "<td><b>Fecha de Nacimiento:</b> " + objFchNacimiento.value + "</td> ";
    txtInsertar += "<td><b>Condici&oacute;n Especial 2:</b> " + objCondEspecial2.options[ objCondEspecial2.selectedIndex ].text + "</td> ";
    txtInsertar += "</tr> ";
    txtInsertar += "<tr> ";
    txtInsertar += "<td><b>LGTBI:</b> ";
    if (objLgtb.options[ objLgtb.selectedIndex ].value == 1) {
        txtInsertar += objSeqGrupoLgtbi.options[ objSeqGrupoLgtbi.selectedIndex ].text;
    } else {
        txtInsertar += "No";
    }
    txtInsertar += "</td>";
    txtInsertar += "<td><b>Condici&oacute;n Especial 3:</b> " + objCondEspecial3.options[ objCondEspecial3.selectedIndex ].text + "</td> ";
    txtInsertar += "</tr> ";
    txtInsertar += "<tr> ";
    txtInsertar += "<td><b>Hecho Victimizante:</b> " + objSeqTipoVictima.options[ objSeqTipoVictima.selectedIndex ].text + "</td> ";
    txtInsertar += "<td colspan='3'><b>Afiliación a Salud</b> " + objSeqSalud.options[ objSeqSalud.selectedIndex ].text + "</td> ";
    txtInsertar += "</tr> ";
    txtInsertar += "<tr> ";
    txtInsertar += "<td><b>Nivel Educativo:</b> " + objNvlEducativo.options[ objNvlEducativo.selectedIndex ].text + "</td>";
    txtInsertar += "<td><b>A&ntilde;os Aprobados:</b> " + objAnosAprobados.options[ objAnosAprobados.selectedIndex ].value + "</td>";
    txtInsertar += "</tr> ";
    txtInsertar += "<tr> ";
    txtInsertar += "<td colspan='3'><b>Ocupaci&oacute;n:</b> " + txtOcupacion + "</td> ";
    txtInsertar += "</tr> ";
    txtInsertar += "</table> ";
    txtInsertar += "</td> ";
    txtInsertar += "</tr> ";
    txtInsertar += "</table> ";

    objHogar.innerHTML += txtInsertar;

    // Sumando el ingreso del miembro del hogar
    var objTotalValor = document.getElementById("valIngresoHogar");
    var objTotalMostrar = document.getElementById("valTotalMostrar");

    var arrMiembros = objHogar.getElementsByTagName("table");
    objTotalValor.value = 0;
    for (i = 0; i < arrMiembros.length; i++) {
        if (parseInt(arrMiembros[ i ].id)) {
            varValorFormat = objTotalValor.value.replace(/[^0-9]/g, "");
            valorMiembroSumar = document.getElementById("ingreso-" + arrMiembros[ i ].id).value.replace(/[^0-9]/g, "");
            objTotalValor.value = parseInt(varValorFormat) + parseInt(valorMiembroSumar);
        }
    }

    // Se muestra en pantalla con formato de numero pero la variable queda sin puntos
    var valSumaIngresos = objTotalValor.value;
    formatoSeparadores(objTotalValor);
    objTotalMostrar.innerHTML = "$ " + objTotalValor.value;
    objTotalValor.value = valSumaIngresos;

    // Reiniciar el formulario de agregar miembro de hogar
    objNombre1.value = "";
    objNombre2.value = "";
    objApellido1.value = "";
    objApellido2.value = "";
    objTpoDocumento.selectedIndex = 0;
    objNumDocumento.value = "";
    objParentesco.selectedIndex = 0;
    objFchNacimiento.value = "";
    objCondEspecial.selectedIndex = 0;
    objCondEtnica.selectedIndex = 0;
    objEstCivil.selectedIndex = 0;
    objOcupacion.selectedIndex = 0;
    objSexo.selectedIndex = 0;
    objLgtb.selectedIndex = 0;
    objIngresos.value = "";
    objNvlEducativo.selectedIndex = 0;
    objAnosAprobados.selectedIndex = 0;
    objSeqSalud.selectedIndex = 0;
    objSeqTipoVictima.selectedIndex = 0;
    objSeqGrupoLgtbi.selectedIndex = 0;

    mostrarOcultar('agregarMiembro');

    // Actualizar el valor de bolDesplazado
    // Si hay un solo ciudadano con la condicion de
    // desplazamiento forzado, el select se marca como 1 = SI
    // 0 = NO de lo contrario
    var arrTablas = $("#datosHogar").find("table");
    var numDesplazado = 0;
    for(i=0; i < arrTablas.length; i++) {
        if(parseInt(arrTablas[i].id)){
            if( $("#" + arrTablas[i].id + "-seqTipoVictima").val() == 2 ){
                numDesplazado = 1;
            }
        }
    }
    $("#bolDesplazado").val(numDesplazado);

    // Recalcular el valor del subsidio
    valorSubsidio();

    return true;

}

function quitarMiembroHogar(numDocumento) {

    var objTotalValor = document.getElementById("valIngresoHogar");
    var objTotalMostrar = document.getElementById("valTotalMostrar");
    var objIngreso = document.getElementById("ingreso-" + numDocumento);
    var objParentesco = document.getElementById("parentesco-" + numDocumento);

    if (objParentesco.value == 1) {
        alert("No puede eliminar a la cabeza de familia como miembro del hogar");
    } else {

        // Resta el valor al total
        objTotalValor.value = parseInt(objTotalValor.value.replace(/[^0-9]/g,"")) - parseInt(objIngreso.value.replace(/[^0-9]/g,""));

        // Muestra el valor en pantalla
        formatoSeparadores(objTotalValor);
        objTotalMostrar.innerHTML = "$ " + objTotalValor.value;

        // Elimina el registro
        eliminarObjeto(numDocumento);
        eliminarObjeto("detalles" + numDocumento);

    }

}


function comprobacionCedula(objNumeroDocumento, idBuscarDocumento) {

    var objBuscarDocumento = document.getElementById(idBuscarDocumento);

    if (objNumeroDocumento.value != objBuscarDocumento.value) {
        alert("Los documentos que ha digitado no son iguales");
    }

}

function esFechaHoraValida(objFecha) {

    txtValor = objFecha.value;

    if (txtValor != "") {

        var arrFecha = txtValor.split(" ");

        if (arrFecha[ 1 ] == "") {
            alert("El formato de la fecha y hora no es vÃ¡lido");
        }

        objFecha.value = arrFecha[ 0 ];
        esFechaValida(objFecha);

        var arrHora = arrFecha[ 1 ].split(":");

        if (arrHora[ 0 ] < 0 || arrHora[ 0 ] > 23) {
            alert("Formato de hora no valida");
        }

        if (arrHora[ 1 ] < 0 || arrHora[ 1 ] > 59) {
            alert("Formato de hora no valida");
        }

        objFecha.value = txtValor;
    } else {
        alert("Digite una fecha y hora en el formato indicado");
    }

}

function esFechaValida(fecha) {

    if (fecha != undefined && fecha.value != "") {

        var txtExpresion = /\d{4}[\/-]\d{1,2}[\/-]\d{1,2}$/;

        if (!txtExpresion.test(fecha.value)) {
            alert("formato de fecha no v" + String.fromCharCode(225) + "lido (aaaa/mm/dd)");
            return false;
        }

        var arrFecha = fecha.value.split(/[\/-]/);

        // Si el primer digito del mes es cero (01 , 02 , 03 etc) la conversion a entero falla
        // hay que quitar ese cero
        if (arrFecha[ 1 ].length > 1) {
            if (arrFecha[ 1 ][ 0 ] == 0) {
                arrFecha[ 1 ] = arrFecha[ 1 ][ 1 ];
            }
        }

        // Lo mismo pasa con el dia
        if (arrFecha[ 2 ].length > 1) {
            if (arrFecha[ 2 ][ 0 ] == 0) {
                arrFecha[ 2 ] = arrFecha[ 2 ][ 1 ];
            }
        }

        var anio = parseInt(arrFecha[ 0 ]);
        var mes = parseInt(arrFecha[ 1 ]);
        var dia = parseInt(arrFecha[ 2 ]);

        switch (mes) {
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                numDias = 31;
                break;
            case 4:
            case 6:
            case 9:
            case 11:
                numDias = 30;
                break;
            case 2:
                if (comprobarSiBisisesto(anio)) {
                    numDias = 29
                } else {
                    numDias = 28
                }
                ;
                break;
            default:
                alert("El formato de fecha no es correcto. Debe ser (aaaa/mm/dd)");
                return false;
        }

        if (dia > numDias || dia == 0) {
            alert("La fecha no es v" + String.fromCharCode(225) + "lida");
            return false;
        }
        return true;
    } else {
        alert("La fecha no puede estar vac" + String.fromCharCode(237) + "a");
    }
}

function comprobarSiBisisesto(anio) {
    if ((anio % 100 != 0) && ((anio % 4 == 0) || (anio % 400 == 0))) {
        return true;
    } else {
        if (anio == 2000) {
            return true;
        } else {
            return false;
        }
    }
}

//Autor :  Roberto Herrero & Daniel
//Web: http://www.indomita.org
//Asunto : Dar formato a un nï¿½mero
function dar_formato(num) {
    var cadena = "";
    var aux;
    var cont = 1, m, k;
    if (num < 0)
        aux = 1;
    else
        aux = 0;
    num = num.toString();
    for (m = num.length - 1; m >= 0; m--) {
        cadena = num.charAt(m) + cadena;
        if (cont % 3 == 0 && m > aux)
            cadena = "." + cadena;
        else
            cadena = cadena;
        if (cont == 3)
            cont = 1;
        else
            cont++;
    }
    cadena = cadena.replace(/.,/, ",");
    return cadena;
}


function sumarTotalRecursos() {

    // Recursos propios
    if( $("#valSaldoCuentaAhorro").val()  == ""){ $("#valSaldoCuentaAhorro").val(0);  }
    if( $("#valSaldoCuentaAhorro2").val() == ""){ $("#valSaldoCuentaAhorro2").val(0); }
    if( $("#valSaldoCesantias").val()     == ""){ $("#valSaldoCesantias").val(0);     }
    if( $("#valCredito").val()            == ""){ $("#valCredito").val(0);            }

    // Subsidio + (Donaciones y/o VUR)
    if( $("#valSubsidioNacional").val()   == ""){ $("#valSubsidioNacional").val(0);   }
    if( $("#valDonacion").val()           == ""){ $("#valDonacion").val(0);           }

    // Suma de recursos propios
    if( $("#valSumaRecursosPropios").val() == ""){ $("#valSumaRecursosPropios").val(0); }

    // Suma Subsidio + (Donaciones y/o VUR)
    if( $("#valSumaSubsidios").val()     == ""){ $("#valSumaSubsidios").val(0); }

    // Valor del aporte
    if( $("#valAspiraSubsidio").val() == ""){ $("#valAspiraSubsidio").val(0); }

    if( document.getElementById('valCartaLeasing') != null ){
        if( $("#valCartaLeasing").val()   == ""){ $("#valCartaLeasing").val(0);   }
    }

    // limpiando caracteres en los valores utiles para sumas
    var numSaldoCuenta    = parseInt($("#valSaldoCuentaAhorro").val().replace(/[^0-9]/g,''));
    var numSaldoCuenta2   = parseInt($("#valSaldoCuentaAhorro2").val().replace(/[^0-9]/g,''));
    var numCesantias      = parseInt($("#valSaldoCesantias").val().replace(/[^0-9]/g,''));
    var numCredito        = parseInt($("#valCredito").val().replace(/[^0-9]/g,''));
    var numSubsidioNal    = parseInt($("#valSubsidioNacional").val().replace(/[^0-9]/g,''));
    var numVUR            = parseInt($("#valDonacion").val().replace(/[^0-9]/g,''));
    var numAspiraSubsidio = parseInt($("#valAspiraSubsidio").val().replace(/[^0-9]/g,''));
    if( document.getElementById('valCartaLeasing') != null ) {
        var numCartaLeasing = parseInt($("#valCartaLeasing").val().replace(/[^0-9]/g, ''));
    }
    // Realizando las sumas
    var numSumaRecursosPropios = numSaldoCuenta + numSaldoCuenta2 + numCesantias + numCredito;
    var numSumaSubsidios       = numSubsidioNal + numVUR;
    var numTotalRecursos       = numSumaRecursosPropios + numSumaSubsidios;

    // Asignando valores a los input del formulario
    $("#valSaldoCuentaAhorro").val(numSaldoCuenta);
    $("#valSaldoCuentaAhorro2").val(numSaldoCuenta2);
    $("#valSaldoCesantias").val(numCesantias);
    $("#valCredito").val(numCredito);
    $("#valSubsidioNacional").val(numSubsidioNal);
    $("#valDonacion").val(numVUR);
    $("#valSumaRecursosPropios").val(numSumaRecursosPropios);
    $("#valSumaSubsidios").val( numSumaSubsidios );
    $("#valAspiraSubsidio").val(numAspiraSubsidio);
    $("#valTotalRecursos").val(numTotalRecursos);
    if( document.getElementById('valCartaLeasing') != null ) {
        $("#valCartaLeasing").val(numCartaLeasing);
    }

    // formateando los valores sumados
    formatoSeparadores(YAHOO.util.Dom.get("valSaldoCuentaAhorro"));
    formatoSeparadores(YAHOO.util.Dom.get("valSaldoCuentaAhorro2"));
    formatoSeparadores(YAHOO.util.Dom.get("valSaldoCesantias"));
    formatoSeparadores(YAHOO.util.Dom.get("valCredito"));
    formatoSeparadores(YAHOO.util.Dom.get("valSubsidioNacional"));
    formatoSeparadores(YAHOO.util.Dom.get("valDonacion"));
    formatoSeparadores(YAHOO.util.Dom.get("valSumaRecursosPropios"));
    formatoSeparadores(YAHOO.util.Dom.get("valSumaSubsidios"));
    formatoSeparadores(YAHOO.util.Dom.get("valAspiraSubsidio"));
    formatoSeparadores(YAHOO.util.Dom.get("valTotalRecursos"));
    if( document.getElementById('valCartaLeasing') != null ) {
        formatoSeparadores(YAHOO.util.Dom.get("valCartaLeasing"));
    }
}


function modificarMiembroHogar(numDocumento) {

    numDocumentoSinPuntos = numDocumento.replace(/[^0-9]/g,"");

    // Muestra la tabla
    document.getElementById("agregarMiembro").style.display = "";

    var objMiembro = document.getElementById(numDocumentoSinPuntos);
    var arrVariables = objMiembro.getElementsByTagName("input");
    for (i = 0; i < arrVariables.length; i++) {

        if (arrVariables[ i ].name != "") {

            document.getElementById("apellido1").value = (arrVariables[ i ].id == numDocumentoSinPuntos + "-txtApellido1") ? arrVariables[ i ].value : document.getElementById("apellido1").value;
            document.getElementById("apellido2").value = (arrVariables[ i ].id == numDocumentoSinPuntos + "-txtApellido2") ? arrVariables[ i ].value : document.getElementById("apellido2").value;
            document.getElementById("nombre1").value = (arrVariables[ i ].id == numDocumentoSinPuntos + "-txtNombre1") ? arrVariables[ i ].value : document.getElementById("nombre1").value;
            document.getElementById("nombre2").value = (arrVariables[ i ].id == numDocumentoSinPuntos + "-txtNombre2") ? arrVariables[ i ].value : document.getElementById("nombre2").value;
            document.getElementById("cajaCompensacion").value = (arrVariables[ i ].id == numDocumentoSinPuntos + "-seqCajaCompensacion") ? arrVariables[ i ].value : document.getElementById("cajaCompensacion").value;

            if (arrVariables[ i ].id == numDocumentoSinPuntos + "-seqTipoDocumento") {
                for (j = 0; j < document.getElementById("tipoDocumento").length; j++) {
                    document.getElementById("tipoDocumento").selectedIndex = (document.getElementById("tipoDocumento").options[ j ].value == document.getElementById(numDocumentoSinPuntos + "-seqTipoDocumento").value) ? j : document.getElementById("tipoDocumento").selectedIndex;
                }
            }

            document.getElementById("numeroDoc").value = (arrVariables[ i ].id == numDocumentoSinPuntos + "-numDocumento") ? arrVariables[ i ].value : document.getElementById("numeroDoc").value;
            if(! isNaN(document.getElementById("numeroDoc").value) ) {
                formatoSeparadores(document.getElementById("numeroDoc"));
            }

            if (arrVariables[ i ].id == numDocumentoSinPuntos + "-seqParentesco") {
                for (j = 0; j < document.getElementById("parentesco").length; j++) {
                    document.getElementById("parentesco").selectedIndex = (document.getElementById("parentesco").options[ j ].value == document.getElementById(numDocumentoSinPuntos + "-seqParentesco").value) ? j : document.getElementById("parentesco").selectedIndex;
                }
            }

            document.getElementById("fechaNac").value = (arrVariables[ i ].id == numDocumentoSinPuntos + "-fchNacimiento") ? arrVariables[ i ].value : document.getElementById("fechaNac").value;

            if (document.getElementById("fechaNac").value == "0000-00-00") {
                document.getElementById("fechaNac").value = "";
            }


            if (arrVariables[ i ].id == numDocumentoSinPuntos + "-seqCondicionEspecial") {
                for (j = 0; j < document.getElementById("condicionEspecial").length; j++) {
                    document.getElementById("condicionEspecial").selectedIndex = (document.getElementById("condicionEspecial").options[ j ].value == document.getElementById(numDocumentoSinPuntos + "-seqCondicionEspecial").value) ? j : document.getElementById("condicionEspecial").selectedIndex;
                }
            }

            if (arrVariables[ i ].id == numDocumentoSinPuntos + "-seqCondicionEspecial2") {
                for (j = 0; j < document.getElementById("condicionEspecial2").length; j++) {
                    document.getElementById("condicionEspecial2").selectedIndex = (document.getElementById("condicionEspecial2").options[ j ].value == document.getElementById(numDocumentoSinPuntos + "-seqCondicionEspecial2").value) ? j : document.getElementById("condicionEspecial2").selectedIndex;
                }
            }

            if (arrVariables[ i ].id == numDocumentoSinPuntos + "-seqCondicionEspecial3") {
                for (j = 0; j < document.getElementById("condicionEspecial3").length; j++) {
                    document.getElementById("condicionEspecial3").selectedIndex = (document.getElementById("condicionEspecial3").options[ j ].value == document.getElementById(numDocumentoSinPuntos + "-seqCondicionEspecial3").value) ? j : document.getElementById("condicionEspecial3").selectedIndex;
                }
            }

            if (arrVariables[ i ].id == numDocumentoSinPuntos + "-seqTipoVictima") {
                for (j = 0; j < document.getElementById("seqTipoVictima").length; j++) {
                    document.getElementById("seqTipoVictima").selectedIndex = (document.getElementById("seqTipoVictima").options[ j ].value == document.getElementById(numDocumentoSinPuntos + "-seqTipoVictima").value) ? j : document.getElementById("seqTipoVictima").selectedIndex;
                }
            }

            if (arrVariables[ i ].id == numDocumentoSinPuntos + "-seqGrupoLgtbi") {
                for (j = 0; j < document.getElementById("seqGrupoLgtbi").length; j++) {
                    document.getElementById("seqGrupoLgtbi").selectedIndex = (document.getElementById("seqGrupoLgtbi").options[ j ].value == document.getElementById(numDocumentoSinPuntos + "-seqGrupoLgtbi").value) ? j : document.getElementById("seqGrupoLgtbi").selectedIndex;
                }
            }

            if (arrVariables[ i ].id == numDocumentoSinPuntos + "-seqEtnia") {
                for (j = 0; j < document.getElementById("condicionEtnica").length; j++) {
                    document.getElementById("condicionEtnica").selectedIndex = (document.getElementById("condicionEtnica").options[ j ].value == document.getElementById(numDocumentoSinPuntos + "-seqEtnia").value) ? j : document.getElementById("condicionEtnica").selectedIndex;
                }
            }

            if (arrVariables[ i ].id == numDocumentoSinPuntos + "-seqEstadoCivil") {
                for (j = 0; j < document.getElementById("estadoCivil").length; j++) {
                    seqEstadoCivil = document.getElementById("estadoCivil").options[ j ].value;
                    document.getElementById("estadoCivil").selectedIndex = (document.getElementById("estadoCivil").options[ j ].value == document.getElementById(numDocumentoSinPuntos + "-seqEstadoCivil").value) ? j : document.getElementById("estadoCivil").selectedIndex;
                }
            }

            if (arrVariables[ i ].id == numDocumentoSinPuntos + "-seqOcupacion") {
                for (j = 0; j < document.getElementById("ocupacion").length; j++) {
                    document.getElementById("ocupacion").selectedIndex = (document.getElementById("ocupacion").options[ j ].value == document.getElementById(numDocumentoSinPuntos + "-seqOcupacion").value) ? j : document.getElementById("ocupacion").selectedIndex;
                }
            }

            if (arrVariables[ i ].id == numDocumentoSinPuntos + "-seqSexo") {
                for (j = 0; j < document.getElementById("sexo").length; j++) {
                    document.getElementById("sexo").selectedIndex = (document.getElementById("sexo").options[ j ].value == document.getElementById(numDocumentoSinPuntos + "-seqSexo").value) ? j : document.getElementById("sexo").selectedIndex;
                }
            }

            if (arrVariables[ i ].id == numDocumentoSinPuntos + "-bolLgtb") {
                for (j = 0; j < document.getElementById("bolLgtb").length; j++) {
                    document.getElementById("bolLgtb").selectedIndex = (document.getElementById("bolLgtb").options[ j ].value == document.getElementById(numDocumentoSinPuntos + "-bolLgtb").value) ? j : document.getElementById("bolLgtb").selectedIndex;
                }
            }

            document.getElementById("ingresos").value = (arrVariables[ i ].id == numDocumentoSinPuntos + "-valIngresos") ? arrVariables[ i ].value : parseInt(document.getElementById("ingresos").value.replace(/[^0-9]/g,""));
            if(! isNaN(document.getElementById("ingresos").value) ) {
                formatoSeparadores(document.getElementById("ingresos"));
            }

            if (arrVariables[ i ].id == numDocumentoSinPuntos + "-seqNivelEducativo") {
                for (j = 0; j < document.getElementById("nivelEducativo").length; j++) {
                    document.getElementById("nivelEducativo").selectedIndex = (document.getElementById("nivelEducativo").options[ j ].value == document.getElementById(numDocumentoSinPuntos + "-seqNivelEducativo").value) ? j : document.getElementById("nivelEducativo").selectedIndex;
                }
            }

            if (arrVariables[ i ].id == numDocumentoSinPuntos + "-seqGrupoLgtbi") {
                for (j = 0; j < document.getElementById("seqGrupoLgtbi").length; j++) {
                    document.getElementById("seqGrupoLgtbi").selectedIndex = (document.getElementById("seqGrupoLgtbi").options[ j ].value == document.getElementById(numDocumentoSinPuntos + "-seqGrupoLgtbi").value) ? j : document.getElementById("seqGrupoLgtbi").selectedIndex;
                }
            }

            if (arrVariables[ i ].id == numDocumentoSinPuntos + "-numAnosAprobados") {
                selectAnidados(document.getElementById("numeroDoc").value.replace(/[^0-9]/g,""), document.getElementById("nivelEducativo").selectedIndex);
                for (j = 0; j < document.getElementById("numAnosAprobados").length; j++) {
                    document.getElementById("numAnosAprobados").selectedIndex = (document.getElementById("numAnosAprobados").options[ j ].value == document.getElementById(numDocumentoSinPuntos + "-numAnosAprobados").value) ? j : document.getElementById("numAnosAprobados").selectedIndex;
                }
            }

            if (arrVariables[ i ].id == numDocumentoSinPuntos + "-seqSalud") {
                for (j = 0; j < document.getElementById("seqSalud").length; j++) {
                    document.getElementById("seqSalud").selectedIndex = (document.getElementById("seqSalud").options[ j ].value == document.getElementById(numDocumentoSinPuntos + "-seqSalud").value) ? j : document.getElementById("seqSalud").selectedIndex;
                }
            }

            if (arrVariables[ i ].id == numDocumentoSinPuntos + "-seqTipoVictima") {
                for (j = 0; j < document.getElementById("seqTipoVictima").length; j++) {
                    document.getElementById("seqTipoVictima").selectedIndex = (document.getElementById("seqTipoVictima").options[ j ].value == document.getElementById(numDocumentoSinPuntos + "-seqTipoVictima").value) ? j : document.getElementById("seqTipoVictima").selectedIndex;
                }
            }

        }
    }

    var objTotalValor = document.getElementById("valIngresoHogar");
    var objTotalMostrar = document.getElementById("valTotalMostrar");
    var objIngreso = document.getElementById("ingreso-" + numDocumento);
    var objParentesco = document.getElementById("parentesco-" + numDocumento);


    // Resta el valor al total
    objTotalValor.value = parseInt(objTotalValor.value);

    // Muestra el valor en pantalla
    formatoSeparadores(objTotalValor);
    objTotalMostrar.innerHTML = "$ " + objTotalValor.value;
    objTotalValor.value.replace(/[^0-9]/g,"");

    // Elimina el registro
    eliminarObjeto("detalles" + numDocumento);
    eliminarObjeto(numDocumento);

    document.getElementById("tipoDocumento").focus();

}

// function asignarValorSubsidio(objTipoSolucion, bolDesplazado) {
//
//     var objDesplazado = YAHOO.util.Dom.get(bolDesplazado);
//     var objModalidad = YAHOO.util.Dom.get("seqModalidad");
//
//     var seqModalidad = document.getElementById("seqModalidad").value;
//     var seqSolucion = document.getElementById("seqSolucion").value;
//     var bolDesplazado = document.getElementById("bolDesplazado").value;
//
//     var objValSubsidio = document.getElementById("tdValSubsidio");
//     if( objValSubsidio != null ){
//         cargarContenido(
//             "tdValSubsidio",
//             "./contenidos/subsidios/valorSubsidio.php",
//             "modalidad=" + seqModalidad + "&solucion=" + seqSolucion + "&desplazado=" + bolDesplazado,
//             false
//         );
//     }
//
// }

function valorSubsidio() {

    var jParametros = {
        seqFormulario: $("#seqFormulario").val(),
        bolDesplazado: $("#bolDesplazado").val(),
        seqPlanGobierno: $("#seqPlanGobierno").val(),
        seqModalidad: $("#seqModalidad").val(),
        seqTipoEsquema: $("#seqTipoEsquema").val(),
        seqProyecto: $("#seqProyecto").val(),
        seqProyectoHijo: $("#seqProyectoHijo").val(),
        seqUnidadProyecto: $("#seqUnidadProyecto").val(),
        valSubsidioNacional: $("#valSubsidioNacional").val(),
        valDonacion: $("#valDonacion").val(),
        valCartaLeasing: $("#valCartaLeasing").val()
    }

    $.ajax({
        url: "./contenidos/casaMano/valorSubsidio.php",
        type: "POST",
        data: jQuery.param(jParametros),
        success: function(respuesta){
            $("#valAspiraSubsidio").val(respuesta);
            sumarTotalRecursos();
        },
        error: function(error){
            alert("Falló el calculo de valor del aporte / subsidio");
        }
    });

}

function asignarValorSubsidioUnidadProyecto(objUnidadProyecto) {
    var seqUnidadProyecto = document.getElementById("seqUnidadProyecto").value;

    var objValSubsidio = document.getElementById("tdValSubsidio");
    if (objValSubsidio != null) {
        cargarContenido(
                "tdValSubsidio",
                "./contenidos/subsidios/valorSubsidioUnidadProyecto.php",
                "unidadProyecto=" + seqUnidadProyecto,
                false
                );
    }
}

function asignarSoporteCambioSubsidioUnidadProyecto(objUnidadProyecto) {
    var seqUnidadProyecto = document.getElementById("seqUnidadProyecto").value;

    var objTxtSoporteCambio = document.getElementById("tdTxtSoporteCambio");
    if (objTxtSoporteCambio != null) {
        cargarContenido(
                "tdTxtSoporteCambio",
                "./contenidos/subsidios/valorSoporteCambioSubsidio.php",
                "unidadProyecto=" + seqUnidadProyecto,
                false
                );
    }
}

function mostrarMensaje(seqModalidad) {
    if (seqModalidad == 3 || seqModalidad == 4) {
        document.getElementById("mensajeMejoramiento").style.display = "";
    } else {
        document.getElementById("mensajeMejoramiento").style.display = "none";
    }
}

function sumarTotal() {

    if( $("#valPresupuesto").val() == ""){ $("#valPresupuesto").val(0); }
    if( $("#valAvaluo").val()      == ""){ $("#valAvaluo").val(0);      }
    if( $("#valTotal").val()       == ""){ $("#valTotal").val(0);       }

    var valPresupuesto = parseInt($("#valPresupuesto").val().replace(/[^0-9]/g,''));
    var valAvaluo      = parseInt($("#valAvaluo").val().replace(/[^0-9]/g,''));
    var valTotal       = parseInt($("#valTotal").val().replace(/[^0-9]/g,''));

    var valTotal = valPresupuesto + valAvaluo;

    $("#valPresupuesto").val(valPresupuesto);
    $("#valAvaluo").val(valAvaluo);
    $("#valTotal").val(valTotal);

    formatoSeparadores(YAHOO.util.Dom.get("valPresupuesto"));
    formatoSeparadores(YAHOO.util.Dom.get("valAvaluo"));
    formatoSeparadores(YAHOO.util.Dom.get("valTotal"));

}


function pedirConfirmacion(txtDestino, objFormulario, txtArchivo) {

    var objAgregarMiembro = YAHOO.util.Dom.get("agregarMiembro");
    var objMensajes = YAHOO.util.Dom.get("mensajes");
    var txtMensaje = "";

    // verifica que el navegador este en linea
    if ( ! navigator.onLine ) {
        txtMensaje = "<li>Por favor verifique la conexión a internet y de nuevo haga clic en Salvar Acualización</li>li>";
    }

    // verifica que no haya un ciudadano en modo de edicion en el formulario
    if( objAgregarMiembro != null && objAgregarMiembro.style.display != "none" ){
        txtMensaje = "<li>Por favor verifique que los miembros de hogar se encuentren agregados correctamente.</li>";
    }

    // si pasa las validaciones
    if(txtMensaje == ""){
        eliminarObjeto("dlgPedirConfirmacionListener");
        someterFormulario(txtDestino, objFormulario, txtArchivo, false, true);

        YAHOO.util.Event.onContentReady(
            "dlgPedirConfirmacionListener",
            function () {
                var handleSubmit = function () {
                    eliminarObjeto("tablaMensajes");
                    this.submit();
                    YAHOO.util.Event.onContentReady(
                        "tablaMensajes",
                        function () {
                            var objMensajes = YAHOO.util.Dom.get('mensajes');
                            var objTablaMensajes = YAHOO.util.Dom.get('tablaMensajes');
                            if (objTablaMensajes.className == "msgOk") {
                                var txtMensajes = objMensajes.innerHTML;
                                $('#buscarCedula').trigger('click');
                                objMensajes.innerHTML = txtMensajes;
                            }
                        }
                    );
                };

                // Cancela la accion de someter el formulario y cierra el cuadro de dialogo
                var handleCancel = function () {
                    this.cancel();
                };

                // Cuando da Submit al formulario del dialogo este es la funcion que contesta
                var handleSuccess = function (o) {
                    var response = o.responseText;
                    response = response.split("<!")[0];
                    document.getElementById("mensajes").innerHTML = response;
                    var tmpObj = null;
                    tmpObj = document.getElementById('dlgPedirConfirmacion_mask');
                    while (tmpObj != null) {
                        //alert( tmpObj );
                        eliminarObjeto("dlgPedirConfirmacion_mask");
                        tmpObj = document.getElementById('dlgPedirConfirmacion_mask');
                    }
                };

                // Cuando se da submit y la accion falla este es el mensaje
                var handleFailure = function (o) {
                    alert("Submission failed: " + o.status);
                };

                // Objeto de configuracion
                var objConfiguracion = {
                    width: "350px",
                    fixedcenter: true,
                    close: false,
                    draggable: false,
                    modal: true,
                    buttons: [{
                        text: "Salvar Información",
                        handler: handleSubmit,
                        isDefault: true
                    },
                    {
                        text: "Cancelar",
                        handler: handleCancel
                    }
                    ],
                    constraintoviewport: true
                };

                // Instancia el cuadro de dialogo
                var dialog1 = new YAHOO.widget.Dialog("dlgPedirConfirmacion", objConfiguracion);

                // Objeto callback del formulario para manejar la respuesta de este
                dialog1.callback = {
                    success: handleSuccess,
                    failure: handleFailure
                };

                // Muestra el cuadro de dialogo
                dialog1.render();
                dialog1.show();

            }
        );
    }else{
        objMensajes.className = "msgError";
        objMensajes.innerHTML = txtMensaje;
    }
}

function desembolsoBusquedaOferta(seqFormulario, seqCasaMano, bolEscrituracion) {

    var txtCarpeta = "desembolso";
    if (typeof (seqCasaMano) == "undefined") {
        seqCasaMano = 0;
    } else {
        if (seqCasaMano != 0) {
            txtCarpeta = "casaMano";
        }
    }

    if (typeof (bolEscrituracion) == "undefined") {
        bolEscrituracion = 0;
    } else {
        bolEscrituracion = 1;
    }

    var objFormulario = YAHOO.util.Dom.get("frmBusquedaOferta");
    someterFormulario('mensajes', objFormulario, './contenidos/' + txtCarpeta + '/pedirConfirmacion.php', false, true);

    YAHOO.util.Event.onContentReady(
            "tablaMensajes",
            function () {

                var objTabla = YAHOO.util.Dom.get("tablaMensajes");

                if (seqCasaMano == 0 && txtCarpeta == "casaMano") {
                    var objIdCasaMano = YAHOO.util.Dom.get("casaMano");
                    seqCasaMano = objIdCasaMano.value;
                }

                if (objTabla.className == "msgOk") {
                    var wndFormato;
                    try {

                        var txtUrl = "./contenidos/desembolso/formatoBusquedaOferta.php";
                        txtUrl += "?seqFormulario=" + seqFormulario + "&seqCasaMano=" + seqCasaMano + "&bolEscrituracion=" + bolEscrituracion;

                        var txtParametros = "resizable=0,location=0,scrollbars=1,width=780,height=700,left=100,top=100";

                        if (!(wndFormato = window.open(txtUrl, '_blank', txtParametros))) {
                            throw "ErrorPopUp";
                        }
                    } catch (objError) {
                        if (objError == "ErrorPopUp") {
                            alert("Ooops, al parecer tu navegador tiene bloqueado las ventanas emergentes, desactiva esa opcion y vuelve a intentar");
                        }
                    }
                }
            }
    );
}

function obtenerTipoSolucionDesplazado(objDesplazado, txtIdModalidad) {

    document.getElementById("tdTipoSolucion").innerHTML = "";
    var objModalidad = document.getElementById(txtIdModalidad);

    cargarContenido(
            'tdTipoSolucion',
            './contenidos/subsidios/tipoSolucion.php',
            'modalidad=' + objModalidad.options[ objModalidad.selectedIndex ].value + '&desplazado=' + objDesplazado.options[ objDesplazado.selectedIndex ].value,
            true
            );

    YAHOO.util.Event.onContentReady(
            "seqSolucion",
            function () {
                document.getElementById("seqSolucion").focus();
            }
    );

}

function datosPestanaPostulacion(txtModo) {

    var txtParametros =
            "modo="            + txtModo                     + "&" +
            "seqFormulario="   + $("#seqFormulario").val()   + "&" +
            "seqModalidad="    + $("#seqModalidad").val()    + "&" +
            "seqTipoEsquema="  + $("#seqTipoEsquema").val()  + "&" +
            "seqPlanGobierno=" + $("#seqPlanGobierno").val() + "&" +
            "seqProyecto="     + $("#seqProyecto").val()     + "&" +
            "seqProyectoHijo=" + $("#seqProyectoHijo").val();

    var objCargando = obtenerObjetoCargando();
        objCargando.show();

    var fncSuccess = function(o){

        var bolCalcularAporte = true;

        try {
            var objRespuesta = jQuery.parseJSON(o.responseText);
        }catch(ex){
            YAHOO.util.Dom.get('mensajes').innerHTML = o.responseText;
            txtModo = false;
        }

        if(txtModo == "modalidad"){

            // solucion
            $("#seqSolucion").empty();
            for( i=0; i < objRespuesta.solucion.length; i++ ){
                $("#seqSolucion").append(
                    $('<option>', {
                        value: objRespuesta.solucion[i].valor,
                        text: objRespuesta.solucion[i].texto
                    })
                );
            }
            if( $('#seqSolucion').children('option').length == 2){
                $('#seqSolucion').val(objRespuesta.solucion[i - 1].valor).prop('selected', true);
            }

            // esquema
            $("#seqTipoEsquema").empty();
            for( i=0; i < objRespuesta.esquema.length; i++ ){
                $("#seqTipoEsquema").append(
                    $('<option>', {
                        value: objRespuesta.esquema[i].valor,
                        text: objRespuesta.esquema[i].texto
                    })
                );
            }
            $('#seqTipoEsquema').val(objRespuesta.esquema[0].valor).prop('selected', true);

            // proyecto
            $("#seqProyecto").empty();
            for( i=0; i < objRespuesta.proyecto.length; i++ ){
                $("#seqProyecto").append(
                    $('<option>', {
                        value: objRespuesta.proyecto[i].valor,
                        text: objRespuesta.proyecto[i].texto
                    })
                );
            }

            // conjuntos
            $("#seqProyectoHijo").empty();
            for( i=0; i < objRespuesta.conjuntos.length; i++ ){
                $("#seqProyectoHijo").append(
                    $('<option>', {
                        value: objRespuesta.conjuntos[i].valor,
                        text: objRespuesta.conjuntos[i].texto
                    })
                );
            }

            // unidades
            $("#seqUnidadProyecto").empty();
            for( i=0; i < objRespuesta.unidades.length; i++ ){
                $("#seqUnidadProyecto").append(
                    $('<option>', {
                        value: objRespuesta.unidades[i].valor,
                        text: objRespuesta.unidades[i].texto
                    })
                );
            }

            // direccion + matricula + chip
            $('#txtDireccionSolucion').val(objRespuesta.direccion);
            $('#txtMatriculaInmobiliaria').val(objRespuesta.matricula);
            $('#txtChip').val(objRespuesta.chip);

            // cuando es leasing entonces muestra los campos de informacion financiera correspondientes
            if( $("#seqModalidad").val() == 13 ){
                $("#trNoLeasing1").removeAttr("style").hide();
                $("#trNoLeasing2").removeAttr("style").hide();
                $("#trNoLeasing3").removeAttr("style").hide();
                $("#trNoLeasing4").removeAttr("style").hide();
                $("#trLeasing1").removeAttr("style").show();
                $("#trLeasing2").removeAttr("style").show();
            }else {
                $("#trNoLeasing1").removeAttr("style").show();
                $("#trNoLeasing2").removeAttr("style").show();
                $("#trNoLeasing3").removeAttr("style").show();
                $("#trNoLeasing4").removeAttr("style").show();
                $("#trLeasing1").removeAttr("style").hide();
                $("#trLeasing2").removeAttr("style").hide();
            }

        }

        if(txtModo == "esquema"){

            // proyecto
            $("#seqProyecto").empty();
            for( i=0; i < objRespuesta.proyecto.length; i++ ){
                $("#seqProyecto").append(
                    $('<option>', {
                        value: objRespuesta.proyecto[i].valor,
                        text: objRespuesta.proyecto[i].texto
                    })
                );
            }

            // conjuntos
            $("#seqProyectoHijo").empty();
            for( i=0; i < objRespuesta.conjuntos.length; i++ ){
                $("#seqProyectoHijo").append(
                    $('<option>', {
                        value: objRespuesta.conjuntos[i].valor,
                        text: objRespuesta.conjuntos[i].texto
                    })
                );
            }

            // unidades
            $("#seqUnidadProyecto").empty();
            for( i=0; i < objRespuesta.unidades.length; i++ ){
                $("#seqUnidadProyecto").append(
                    $('<option>', {
                        value: objRespuesta.unidades[i].valor,
                        text: objRespuesta.unidades[i].texto
                    })
                );
            }

            // direccion + matricula + chip
            $('#txtDireccionSolucion').val(objRespuesta.direccion);
            $('#txtMatriculaInmobiliaria').val(objRespuesta.matricula);
            $('#txtChip').val(objRespuesta.chip);

        }

        if(txtModo == "proyecto"){

            // conjuntos
            $("#seqProyectoHijo").empty();
            for( i=0; i < objRespuesta.conjuntos.length; i++ ){
                $("#seqProyectoHijo").append(
                    $('<option>', {
                        value: objRespuesta.conjuntos[i].valor,
                        text: objRespuesta.conjuntos[i].texto
                    })
                );
            }

            // unidades
            $("#seqUnidadProyecto").empty();
            for( i=0; i < objRespuesta.unidades.length; i++ ){
                $("#seqUnidadProyecto").append(
                    $('<option>', {
                        value: objRespuesta.unidades[i].valor,
                        text: objRespuesta.unidades[i].texto
                    })
                );
            }

            // direccion + matricula + chip
            $('#txtDireccionSolucion').val(objRespuesta.direccion);
            $('#txtMatriculaInmobiliaria').val(objRespuesta.matricula);
            $('#txtChip').val(objRespuesta.chip);

        }

        if(txtModo == "conjuntos"){
            // unidades
            $("#seqUnidadProyecto").empty();
            for( i=0; i < objRespuesta.unidades.length; i++ ){
                $("#seqUnidadProyecto").append(
                    $('<option>', {
                        value: objRespuesta.unidades[i].valor,
                        text: objRespuesta.unidades[i].texto
                    })
                );
            }

        }

        if( txtModo == "inscripcion" ){

            bolCalcularAporte = false;

            // solucion
            $("#seqSolucion").empty();
            for( i=0; i < objRespuesta.solucion.length; i++ ){
                $("#seqSolucion").append(
                    $('<option>', {
                        value: objRespuesta.solucion[i].valor,
                        text: objRespuesta.solucion[i].texto
                    })
                );
            }
            if( $('#seqSolucion').children('option').length == 2){
                $('#seqSolucion').val(objRespuesta.solucion[i - 1].valor).prop('selected', true);
            }

        }

        if( txtModo == "actualizacion" ){

            // solucion
            $("#seqSolucion").empty();
            for( i=0; i < objRespuesta.solucion.length; i++ ){
                $("#seqSolucion").append(
                    $('<option>', {
                        value: objRespuesta.solucion[i].valor,
                        text: objRespuesta.solucion[i].texto
                    })
                );
            }
            if( $('#seqSolucion').children('option').length == 2){
                $('#seqSolucion').val(objRespuesta.solucion[i - 1].valor).prop('selected', true);
            }

            // esquema
            $("#seqTipoEsquema").empty();
            for( i=0; i < objRespuesta.esquema.length; i++ ){
                $("#seqTipoEsquema").append(
                    $('<option>', {
                        value: objRespuesta.esquema[i].valor,
                        text: objRespuesta.esquema[i].texto,
                        disabled: true
                    })
                );

            }
            if( $("#seqModalidad").val() == 12 || $("#seqModalidad").val() == 13 ) {
                $('#seqTipoEsquema').val(9).prop('selected', true);
            }else{
                $('#seqTipoEsquema').val(objRespuesta.esquema[0].valor).prop('selected', true);
            }

        }

        if( bolCalcularAporte == true ) {
            valorSubsidio();
        }

        objCargando.hide();
    }

    var fncFailure = function (o) {
        alert(o.status + " " + o.statusText);
        objCargando.hide();
    }

    var callback = {
        success: fncSuccess,
        failure: fncFailure
    };

    YAHOO.util.Connect.asyncRequest(
        "POST",
        "./contenidos/casaMano/datosPestanaPostulacion.php",
        callback,
        txtParametros
    );
}

/**
 * HACE LOS CALCULOS PERTIENENTES EN LA PESTAÑA DE
 * INFORMACION FINANCIERA EN EL FORMULARIO DE POSTUALCION
 * PARA PLAN DE GOBIERNO 2 Y 3
 * @param objInput
 */
// function campoPostulacionFinanciera(objInput){
//
//     objInput.style.backgroundColor = '#FFFFFF'; sumarTotalRecursos();
//
//
//
//
//
//
//
// }



function obtenerTipoSolucion(objModalidad) {

    document.getElementById("tdTipoSolucion").innerHTML = "";

    cargarContenido(
            'tdTipoSolucion',
            './contenidos/subsidios/tipoSolucion.php',
            'modalidad=' + objModalidad.options[ objModalidad.selectedIndex ].value,
            true
            );

    YAHOO.util.Event.onContentReady(
            "seqSolucion",
            function () {
                document.getElementById("seqSolucion").focus();
            }
    );
}

function obtenerConjuntoResidencial(objProyectoPadre) {

    document.getElementById("tdConjuntoResidencial").innerHTML = "";

    cargarContenido(
            'tdConjuntoResidencial',
            './contenidos/subsidios/conjuntoResidencial.php',
            'proyectoPadre=' + objProyectoPadre.options[ objProyectoPadre.selectedIndex ].value,
            true
            );

    YAHOO.util.Event.onContentReady(
            "seqProyectoHijo",
            function () {
                document.getElementById("seqProyectoHijo").focus();
            }
    );
}

function obtenerUnidadProyecto(objProyecto) {

    document.getElementById("tdUnidadProyecto").innerHTML = "";

    cargarContenido(
            'tdUnidadProyecto',
            './contenidos/subsidios/unidadProyecto.php',
            'proyecto=' + objProyecto.options[ objProyecto.selectedIndex ].value,
            true
            );

    YAHOO.util.Event.onContentReady(
            "seqUnidadProyecto",
            function () {
                document.getElementById("seqUnidadProyecto").focus();
            }
    );
}

function obtenerUnidadEstudioTecnico(objProyecto) {

    document.getElementById("tdUnidadProyecto").innerHTML = "";

    cargarContenido(
            'tdUnidadProyecto',
            './contenidos/unidadProyecto/unidadEstudioTecnico.php',
            'proyecto=' + objProyecto.options[ objProyecto.selectedIndex ].value,
            true
            );

    YAHOO.util.Event.onContentReady(
            "seqUnidadProyecto",
            function () {
                document.getElementById("seqUnidadProyecto").focus();
            }
    );
}

function obtenerGestion(objGrupoGestion, idDestino, idSelectDestino) {

    eliminarObjeto(idSelectDestino);

    cargarContenido(
            idDestino,
            './contenidos/desembolso/cambiarGestion.php',
            'grupo=' + objGrupoGestion.options[ objGrupoGestion.selectedIndex ].value + '&idSelect=' + idSelectDestino,
            true
            );

    YAHOO.util.Event.onContentReady(
            idSelectDestino,
            function () {
                document.getElementById("txtComentario").style.background = "#FFFFFF";
                document.getElementById(idSelectDestino).focus();
            }
    );

}

function obtenerGestionProyectos(objGrupoGestion, idDestino, idSelectDestino) {

    eliminarObjeto(idSelectDestino);

    cargarContenido(
            idDestino,
            './contenidos/proyectos/cambiarGestionProyectos.php',
            'grupo=' + objGrupoGestion.options[ objGrupoGestion.selectedIndex ].value + '&idSelect=' + idSelectDestino,
            true
            );

    YAHOO.util.Event.onContentReady(
            idSelectDestino,
            function () {
                document.getElementById("txtComentario").style.background = "#FFFFFF";
                document.getElementById(idSelectDestino).focus();
            }
    );

}

function fechasFuturas(objSelectOrigen, idSelectDestino) {

    // Select destino
    var objSelectDestino = document.getElementById(idSelectDestino);

    // Limpiando el select destino 
    for (i = objSelectDestino.options.length; i >= 0; i--) {
        objSelectDestino.remove(i);
    }

    // Copiando todos los option
    for (i = 0; i <= objSelectOrigen.selectedIndex; i++) {

        var objOptionOrigen = objSelectOrigen.options[ i ];
        var objOptionDestino = document.createElement("option");
        objOptionDestino.value = objOptionOrigen.value;
        objOptionDestino.text = objOptionOrigen.text;

        try {
            objSelectDestino.add(objOptionDestino, null); // standards compliant; doesn't work in IE
        } catch (ex) {
            objSelectDestino.add(objOptionDestino); // IE only
        }

    }

}


function imprimirPostulacion(objFormulario) {

    someterFormulario('mensajes', objFormulario, './contenidos/subsidios/salvarPostulacion.php', false, true);

    YAHOO.util.Event.onContentReady(
            "tablaMensajes",
            function () {
                var objTablaMensajes = document.getElementById("tablaMensajes");
                var arrFilas = objTablaMensajes.getElementsByTagName("td");
                if (arrFilas[ 0 ].className != "msgError") {
                    var wndPostulacion;
                    try {
                        var seqFormulario = document.getElementById("seqFormularioEditar").value;
                        wndPostulacion = window.open("./contenidos/subsidios/formatoPostulacionImprimir.php?seqFormulario=" + seqFormulario,
                                "_blank",
                                "resizable=0,location=0,scrollbars=1,width=780,height=700,left=100,top=100"
                                );
                        if (!wndPostulacion) {
                            throw "ErrorPopUp";
                        }
                    } catch (objError) {
                        if (objError == "ErrorPopUp") {
                            alert("Ooops, al parecer tu navegador tiene bloqueado las ventanas emergentes, desactiva esa opcion y vuelve a intentar");
                        }
                    }
                }
            }
    );

}

function desplegarDetallesMiembroHogar(numDocumento) {
    var objMasDetalles = document.getElementById("masDetalles" + numDocumento);
    var txtAccion = mostrarOcultar("detalles" + numDocumento);
    if (txtAccion == "mostrar") {
        objMasDetalles.innerHTML = "-";
    } else {
        objMasDetalles.innerHTML = "+";
    }
}

function ucwords(str) {
    // Uppercase the first character of every word in a string 
    //
    // version: 909.322
    // discuss at: http://phpjs.org/functions/ucwords
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Waldo Malqui Silva
    // +   bugfixed by: Onno Marsman
    // *     example 1: ucwords('kevin van zonneveld');
    // *     returns 1: 'Kevin Van Zonneveld'
    // *     example 2: ucwords('HELLO WORLD');
    // *     returns 2: 'HELLO WORLD'
    return (str + '').replace(/^(.)|\s(.)/g, function ($1) {
        return $1.toUpperCase( );
    });
}

function continuarCalificacion() {

    // Define various event handlers for Dialog
    var handleYes = function () {
        //cargarContenido("contenido", "./contenidos/calificacion/procesoCalificacion.php", "", true);
        cargarContenido("contenido", "./contenidos/calificacion/calificacionPlan2.php", "", true);
        this.cancel();
    };

    var handleNo = function () {
        this.cancel();
    };

    var txtMensaje = "<div style='text-align:center'>";
    txtMensaje += "El proceso de calificaciÃ³n procedera solamente con los formularios ";
    txtMensaje += "de los hogares que se encuentran en la etapa de postulaciÃ³n en estado cosecha ";
    txtMensaje += "y que ademÃ¡s se encuentren cerrados.<br><span class='msgError'>Los demÃ¡s formularios NO ";
    txtMensaje += "serÃ¡n tenidos en cuenta para el proceso y no obtendrÃ¡n un puntaje.</span><br><br>";
    txtMensaje += "<span class='msgOK'>Â¿Desea continuar con el proceso de calificaciÃ³n?</span>";
    txtMensaje += "</div>";

    var objConfiguracion = {
        width: "400px",
        height: "170px",
        fixedcenter: true,
        visible: false,
        draggable: false,
        close: true,
        modal: true,
        text: txtMensaje,
        icon: YAHOO.widget.SimpleDialog.ICON_HELP,
        constraintoviewport: true,
        buttons: [{
                text: "Si",
                handler: handleYes
            },
            {
                text: "No",
                handler: handleNo,
                isDefault: true
            }]
    }

    // Instantiate the Dialog
    var objCalificacion = new YAHOO.widget.SimpleDialog("calificacion", objConfiguracion);
    objCalificacion.setHeader("Se solicita atencion del usuario...");
    objCalificacion.render(document.body);
    objCalificacion.show();

}


function cuadroBusquedaAvanzada(idDestino) {

    var objDestino = YAHOO.util.Dom.get(idDestino);
    var objCuadro = YAHOO.util.Dom.get("cuadro" + idDestino);
    var objIcono = YAHOO.util.Dom.get("mas" + idDestino);

    var numAlto = 0;
    if (objDestino.style.width == "" || objDestino.style.width == "1px") {
        numAlto = 100;
        objIcono.innerHTML = "-";
    } else {
        numAlto = 1;
        objIcono.innerHTML = "+";
    }

    var animacionIniciada = function () {
        if (numAlto == 1) {
            objCuadro.style.display = "none";
        }
    }

    var animacionCompleta = function () {
        objDestino.style.width = numAlto;
        if (numAlto == 100) {
            objCuadro.style.display = "block";
        }
    }

    var objConfiguracion = {
        height: {
            to: numAlto
        }
    }

    var objAnimacion = new YAHOO.util.Anim(idDestino, objConfiguracion);
    objAnimacion.onComplete.subscribe(animacionCompleta);
    objAnimacion.onStart.subscribe(animacionIniciada);


    objAnimacion.animate();


}

function calendarioPopUp(idInputDestino) {

    var objPanel = new YAHOO.widget.Panel(
            "calendar",
            {
                width: "200px",
                height: "280px",
                fixedcenter: true,
                close: true,
                draggable: true,
                modal: false,
                visible: false
            }
    );

    YAHOO.util.Event.onContentReady(
            "calendarioPopUp",
            function () {

                var objInputDestino = document.getElementById(idInputDestino);

                var sleeccionaFecha = function (type, args, obj) {
                    var dates = args[0];
                    var date = dates[0];
                    var year = date[0], month = date[1], day = date[2];

                    objInputDestino.value = year + "-" + month + "-" + day;

                    objPanel.hide();
                }

                var navConfig = {
                    strings: {
                        month: "Seleccione Mes",
                        year: "Digite A&ntilde;o",
                        submit: "OK",
                        cancel: "Cancelar",
                        invalidYear: "Ingrese un a&ntilde;o v&aacute;lido"
                    },
                    monthFormat: YAHOO.widget.Calendar.SHORT,
                    initialFocus: "year"
                };


                var objCalendario = new YAHOO.widget.Calendar("calendarioPopUp", {
                    navigator: navConfig
                });
                objCalendario.cfg.setProperty("MONTHS_LONG", ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]);
                objCalendario.cfg.setProperty("MONTHS_SHORT", ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]);
                objCalendario.cfg.setProperty("WEEKDAYS_MEDIUM", ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"]);
                objCalendario.selectEvent.subscribe(sleeccionaFecha, objCalendario, true);

                //alert( objInputDestino );

                objCalendario.render( );
            }
    );



    objPanel.setHeader("Seleccione la fecha");
    objPanel.setBody("<div id='calendarioPopUp'><img src='./recursos/imagenes/cargando.gif' style='width:170px'></div>");
    objPanel.render(document.body);
    objPanel.show();

}

function calendarioPopUpCalcula(idInputDestino, actual, campo) {
    /**/

    var objPanel = new YAHOO.widget.Panel(
            "calendar",
            {
                width: "195px",
                height: "230px",
                fixedcenter: true,
                close: true,
                draggable: true,
                modal: false,
                visible: false
            }
    );

    YAHOO.util.Event.onContentReady(
            "calendarioPopUp",
            function () {

                var objInputDestino = document.getElementById(idInputDestino);

                var sleeccionaFecha = function (type, args, obj) {
                    var dates = args[0];
                    var date = dates[0];
                    var year = date[0], month = date[1], day = date[2];

                    objInputDestino.value = year + "-" + month + "-" + day;
                    ///////////////////////// inicio
                    var vlrInicial = objInputDestino.value;
                    if (vlrInicial.substr(6, 1) == "-") {
                        var Parte1n = vlrInicial.substr(0, 5);
                        var Parte2n = "0"
                        var Parte3n = vlrInicial.substr(5, 5);
                        var vlrInicialNuevo = Parte1n + Parte2n + Parte3n;
                    } else {
                        var vlrInicialNuevo = vlrInicial;
                    }

                    var vlrActual = actual.value;
                    if (vlrActual.substr(6, 1) == "-") {
                        var Parte1 = vlrActual.substr(0, 5);
                        var Parte2 = "0"
                        var Parte3 = vlrActual.substr(5, 5);
                        var vlrActualNuevo = Parte1 + Parte2 + Parte3;
                    } else {
                        var vlrActualNuevo = vlrActual;
                    }
                    var diff = Math.floor((Date.parse(vlrActualNuevo) - Date.parse(vlrInicialNuevo)) / 86400000);
                    if (isNaN(diff)) {
                        document.getElementById(campo).value = 0;
                    } else {
                        document.getElementById(campo).value = diff;
                    }
                    ////////////////////////// fin
                    objPanel.hide();
                }

                var navConfig = {
                    strings: {
                        month: "Seleccione Mes",
                        year: "Digite A&ntilde;o",
                        submit: "OK",
                        cancel: "Cancelar",
                        invalidYear: "Ingrese un a&ntilde;o v&aacute;lido"
                    },
                    monthFormat: YAHOO.widget.Calendar.SHORT,
                    initialFocus: "year"
                };


                var objCalendario = new YAHOO.widget.Calendar("calendarioPopUp", {
                    navigator: navConfig
                });
                objCalendario.cfg.setProperty("MONTHS_LONG", ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]);
                objCalendario.cfg.setProperty("MONTHS_SHORT", ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]);
                objCalendario.cfg.setProperty("WEEKDAYS_MEDIUM", ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"]);
                objCalendario.selectEvent.subscribe(sleeccionaFecha, objCalendario, true);

                objCalendario.render( );
            }
    );



    objPanel.setHeader("Seleccione la fecha");
    objPanel.setBody("<div id='calendarioPopUp'><img src='./recursos/imagenes/cargando.gif' style='width:170px'></div>");
    objPanel.render(document.body);
    objPanel.show();

}

function calendarioPopUpIncrementa(idInputDestino, diasIncremento, campoDestino) {

    var objPanel = new YAHOO.widget.Panel(
            "calendar",
            {
                width: "195px",
                height: "230px",
                fixedcenter: true,
                close: true,
                draggable: true,
                modal: false,
                visible: false
            }
    );

    YAHOO.util.Event.onContentReady(
            "calendarioPopUp",
            function () {

                var objInputDestino = document.getElementById(idInputDestino);

                var sleeccionaFecha = function (type, args, obj) {
                    var dates = args[0];
                    var date = dates[0];
                    var year = date[0], month = date[1], day = date[2];

                    objInputDestino.value = year + "-" + month + "-" + day;
                    // inicio
                    var fechaOriginal = year + "-" + month + "-" + day;
                    if (fechaOriginal.substr(6, 1) == "-") {
                        var Parte1 = fechaOriginal.substr(0, 5);
                        var Parte2 = "0"
                        var Parte3 = fechaOriginal.substr(5, 5);
                        var fechaOriginalNueva = Parte1 + Parte2 + Parte3;
                    } else {
                        var fechaOriginalNueva = fechaOriginal;
                    }
                    //alert (fechaOriginalNueva);
                    ms = Date.parse(fechaOriginalNueva);
                    fecha = new Date(ms);
                    dayx = fecha.getDate();
                    monthx = fecha.getMonth() + 1;
                    yearx = fecha.getFullYear();

                    tiempo = fecha.getTime();
                    milisegundos = parseInt(diasIncremento * 24 * 60 * 60 * 1000);
                    total = fecha.setTime(tiempo + milisegundos);
                    dayx = fecha.getDate();
                    monthx = fecha.getMonth() + 1;
                    yearx = fecha.getFullYear();

                    var fechaVence = yearx + "-" + monthx + "-" + dayx;
                    document.getElementById(campoDestino).value = fechaVence;
                    // fin

                    objPanel.hide();
                }

                var navConfig = {
                    strings: {
                        month: "Seleccione Mes",
                        year: "Digite A&ntilde;o",
                        submit: "OK",
                        cancel: "Cancelar",
                        invalidYear: "Ingrese un a&ntilde;o v&aacute;lido"
                    },
                    monthFormat: YAHOO.widget.Calendar.SHORT,
                    initialFocus: "year"
                };


                var objCalendario = new YAHOO.widget.Calendar("calendarioPopUp", {
                    navigator: navConfig
                });
                objCalendario.cfg.setProperty("MONTHS_LONG", ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]);
                objCalendario.cfg.setProperty("MONTHS_SHORT", ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]);
                objCalendario.cfg.setProperty("WEEKDAYS_MEDIUM", ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"]);
                objCalendario.selectEvent.subscribe(sleeccionaFecha, objCalendario, true);

                //alert( objInputDestino );

                objCalendario.render( );
            }
    );



    objPanel.setHeader("Seleccione la fecha");
    objPanel.setBody("<div id='calendarioPopUp'><img src='./recursos/imagenes/cargando.gif' style='width:170px'></div>");
    objPanel.render(document.body);
    objPanel.show();

}

function borrarDivAsignacion( ) {
    var objDiv = YAHOO.util.Dom.get("camposOcultosAsignacion");
    objDiv.innerHTML = "";
}


function buscarSeguimiento(txtDivDestino, txtArchivo) {

    var objDestino = document.getElementById(txtDivDestino);
    var objReferencia = document.getElementById("referencia");
    var objGrupoGestion = document.getElementById("grupoGestion");
    var objGestion = document.getElementById("gestion");
    var objFechaInicial = document.getElementById("inicial");
    var objFechaFinal = document.getElementById("final");
    var objComentario = document.getElementById("comentario");
    var objSeguimiento = document.getElementById("seqFormulario");

    var objCambiosSi = document.getElementById("cambiosSi");
    var objCambiosNo = document.getElementById("cambiosNo");
    var objCambiosAmbos = document.getElementById("cambiosAmbos");

    var objCriterioTextoInicia = document.getElementById("criterioTextoInicia");
    var objCriterioTextoTermina = document.getElementById("criterioTextoTermina");
    var objCriterioTextoContiene = document.getElementById("criterioTextoContiene");

    var txtCambios = "";
    if (objCambiosSi.checked) {
        txtCambios = "si";
    }
    if (objCambiosNo.checked) {
        txtCambios = "no";
    }
    if (objCambiosAmbos.checked) {
        txtCambios = "ambos";
    }

    var txtCriterio = "";
    if (objCriterioTextoInicia.checked) {
        txtCriterio = "inicia";
    }
    if (objCriterioTextoTermina.checked) {
        txtCriterio = "termina";
    }
    if (objCriterioTextoContiene.checked) {
        txtCriterio = "contiene";
    }

    var txtParametros = "referencia=" + objReferencia.value + "&";
    txtParametros += "grupoGestion=" + objGrupoGestion.options[ objGrupoGestion.selectedIndex ].value + "&";
    txtParametros += "gestion=" + objGestion.options[ objGestion.selectedIndex ].value + "&";
    txtParametros += "desde=" + objFechaInicial.value + "&";
    txtParametros += "hasta=" + objFechaFinal.value + "&";
    txtParametros += "comentario=" + objComentario.value + "&";
    txtParametros += "cambios=" + txtCambios + "&";
    txtParametros += "criterio=" + txtCriterio + "&";
    txtParametros += "seqFormulario=" + objSeguimiento.value;

    var objCall = cargarContenido(txtDivDestino, txtArchivo, txtParametros, false);

    if (YAHOO.util.Connect.isCallInProgress(objCall)) {

        var objBusquedaAvanzada = YAHOO.util.Dom.get("busquedaAvanzada");
        if (objBusquedaAvanzada.style.width != "" && objBusquedaAvanzada.style.width != "1px") {
            cuadroBusquedaAvanzada('busquedaAvanzada');
        }
        objDestino.innerHTML = "<img src='./recursos/imagenes/cargando.gif'>";
    }


}

function buscarSeguimientoProyectos(txtDivDestino, txtArchivo) {

    var objDestino = document.getElementById(txtDivDestino);
    var objReferencia = document.getElementById("referencia");
    var objGrupoGestion = document.getElementById("grupoGestion");
    var objGestion = document.getElementById("gestion");
    var objFechaInicial = document.getElementById("inicial");
    var objFechaFinal = document.getElementById("final");
    var objComentario = document.getElementById("comentario");
    var objSeguimiento = document.getElementById("seqProyectoEditar");

    var objCambiosSi = document.getElementById("cambiosSi");
    var objCambiosNo = document.getElementById("cambiosNo");
    var objCambiosAmbos = document.getElementById("cambiosAmbos");

    var objCriterioTextoInicia = document.getElementById("criterioTextoInicia");
    var objCriterioTextoTermina = document.getElementById("criterioTextoTermina");
    var objCriterioTextoContiene = document.getElementById("criterioTextoContiene");

    var txtCambios = "";
    if (objCambiosSi.checked) {
        txtCambios = "si";
    }
    if (objCambiosNo.checked) {
        txtCambios = "no";
    }
    if (objCambiosAmbos.checked) {
        txtCambios = "ambos";
    }

    var txtCriterio = "";
    if (objCriterioTextoInicia.checked) {
        txtCriterio = "inicia";
    }
    if (objCriterioTextoTermina.checked) {
        txtCriterio = "termina";
    }
    if (objCriterioTextoContiene.checked) {
        txtCriterio = "contiene";
    }

    var txtParametros = "referencia=" + objReferencia.value + "&";
    txtParametros += "grupoGestion=" + objGrupoGestion.options[ objGrupoGestion.selectedIndex ].value + "&";
    txtParametros += "gestion=" + objGestion.options[ objGestion.selectedIndex ].value + "&";
    txtParametros += "desde=" + objFechaInicial.value + "&";
    txtParametros += "hasta=" + objFechaFinal.value + "&";
    txtParametros += "comentario=" + objComentario.value + "&";
    txtParametros += "cambios=" + txtCambios + "&";
    txtParametros += "criterio=" + txtCriterio + "&";
    txtParametros += "seqProyecto=" + objSeguimiento.value;

    var objCall = cargarContenido(txtDivDestino, txtArchivo, txtParametros, false);

    if (YAHOO.util.Connect.isCallInProgress(objCall)) {

        var objBusquedaAvanzada = YAHOO.util.Dom.get("busquedaAvanzada");
        if (objBusquedaAvanzada.style.width != "" && objBusquedaAvanzada.style.width != "1px") {
            cuadroBusquedaAvanzada('busquedaAvanzada');
        }
        objDestino.innerHTML = "<img src='./recursos/imagenes/cargando.gif'>";
    }


}


function verCambiosFormulario(seqFormulario, seqSeguimiento) {

    var numAncho = YAHOO.util.Dom.getClientWidth() - 100;
    var numAlto = YAHOO.util.Dom.getClientHeight() - 50;

    // Objeto de respuesta si es satisfactoria la carga
    var handleSuccess =
            function (o) {

                var tmpObj = null;
                tmpObj = document.getElementById('cambios_mask');
                while (tmpObj != null) {
                    //alert( tmpObj );
                    eliminarObjeto("cambios_mask");
                    tmpObj = document.getElementById('cambios_mask');
                }

                var tmpObj = null;
                tmpObj = document.getElementById('cambios_c');
                while (tmpObj != null) {
                    //alert( tmpObj );
                    eliminarObjeto("cambios_c");
                    tmpObj = document.getElementById('cambios_c');
                }

                if (o.responseText !== undefined) {

                    var objConfiguracion = {
                        width: numAncho,
                        height: numAlto,
                        fixedcenter: true,
                        close: true,
                        draggable: true,
                        modal: true,
                        visible: false
                    }

                    var objPanel = new YAHOO.widget.Panel(
                            "cambios",
                            objConfiguracion
                            );

                    objPanel.setHeader("Ver Cambios en el Formulario");
                    objPanel.setBody(o.responseText);

                    objPanel.render(document.body);
                    objPanel.show();

                }
            };

    // Objeto de respuesta si la carga falla
    var handleFailure =
            function (o) {
                if (o.responseText !== undefined) {

                    // Cuando se vence la sesion la respuesta es HTTP 401 = Not Authorized
                    if (o.status == "401") {
                        document.location = 'index.php';
                    } else {

                        // Mensaje cuando la pagina no es encontrada
                        var htmlCode = "";
                        htmlCode = +o.status + " " + o.statusText;

                        // Otros mensajes de error son mostrados directamente en el div
                        document.getElementById("mensajes").innerHTML = htmlCode;
                    }
                    return false;
                }
            };

    // Objeto de respuestas
    var callback = {
        success: handleSuccess,
        failure: handleFailure
    };

    // peticion asincrona al servidor
    var callObj = YAHOO.util.Connect.asyncRequest("POST", "./contenidos/seguimiento/verCambiosFormulario.php", callback, "seqFormulario=" + seqFormulario + "&seqSeguimiento=" + seqSeguimiento + "&alto=" + numAlto);

}

function verCambiosFormularioProyectos(seqProyecto, seqSeguimiento) {

    var numAncho = YAHOO.util.Dom.getClientWidth() - 100;
    var numAlto = YAHOO.util.Dom.getClientHeight() - 50;

    // Objeto de respuesta si es satisfactoria la carga
    var handleSuccess =
            function (o) {
                if (o.responseText !== undefined) {

                    var objConfiguracion = {
                        width: numAncho,
                        height: numAlto,
                        fixedcenter: true,
                        close: true,
                        draggable: true,
                        modal: true,
                        visible: false
                    }

                    var objPanel = new YAHOO.widget.Panel(
                            "cambios",
                            objConfiguracion
                            );

                    objPanel.setHeader("Ver Cambios en el Proyecto");
                    objPanel.setBody(o.responseText);

                    objPanel.render(document.body);
                    objPanel.show();

                }
            };

    // Objeto de respuesta si la carga falla
    var handleFailure =
            function (o) {
                if (o.responseText !== undefined) {

                    // Cuando se vence la sesion la respuesta es HTTP 401 = Not Authorized
                    if (o.status == "401") {
                        document.location = 'index.php';
                    } else {

                        // Mensaje cuando la pagina no es encontrada
                        var htmlCode = "";
                        htmlCode = +o.status + " " + o.statusText;

                        // Otros mensajes de error son mostrados directamente en el div
                        document.getElementById("mensajes").innerHTML = htmlCode;
                    }
                    return false;
                }
            };

    // Objeto de respuestas
    var callback = {
        success: handleSuccess,
        failure: handleFailure
    };

    // peticion asincrona al servidor
    var callObj = YAHOO.util.Connect.asyncRequest("POST", "./contenidos/seguimientoProyectos/verCambiosFormulario.php", callback, "seqProyecto=" + seqProyecto + "&seqSeguimiento=" + seqSeguimiento + "&alto=" + numAlto);

}

function limpiarBusqueda() {

    var objReferencia = document.getElementById("referencia");
    var objGrupoGestion = document.getElementById("grupoGestion");
    var objGestion = document.getElementById("gestion");
    var objFechaInicial = document.getElementById("inicial");
    var objFechaFinal = document.getElementById("final");
    var objComentario = document.getElementById("comentario");

    var objCambiosSi = document.getElementById("cambiosSi");
    var objCambiosNo = document.getElementById("cambiosNo");
    var objCambiosAmbos = document.getElementById("cambiosAmbos");

    var objCriterioTextoInicia = document.getElementById("criterioTextoInicia");
    var objCriterioTextoTermina = document.getElementById("criterioTextoTermina");
    var objCriterioTextoContiene = document.getElementById("criterioTextoContiene");

    objReferencia.value = "";
    objGrupoGestion.selectedIndex = 0;
    objGestion.selectedIndex = 0;
    objFechaInicial.value = "";
    objFechaFinal.value = "";
    objComentario.value = "";
    objCambiosSi.checked = false;
    objCambiosNo.checked = false;
    objCambiosAmbos.checked = false;
    objCriterioTextoInicia.checked = false;
    objCriterioTextoTermina.checked = false;
    objCriterioTextoContiene.checked = false;

    buscarSeguimiento( 'contenidoBusqueda', './contenidos/seguimiento/buscarSeguimiento.php' );

}

function cambioWSelect(txtCampo) {

    cargarContenido("tdWCriterio", "./contenidos/reportes/cambioWSelect.php", "mostrar=criterio&campo=" + txtCampo, false);
    cargarContenido("tdWValor", "./contenidos/reportes/cambioWSelect.php", "mostrar=valor&campo=" + txtCampo, true);

}

function cambioWSelectProyectos(txtCampo) {

    cargarContenido("tdWCriterio", "./contenidos/reportesProyectos/cambioWSelect.php", "mostrar=criterio&campo=" + txtCampo, false);
    cargarContenido("tdWValor", "./contenidos/reportesProyectos/cambioWSelect.php", "mostrar=valor&campo=" + txtCampo, true);

}

function adicionarCondicion() {

    var objCampo = document.getElementById("wCampo");
    var objCriterio = document.getElementById("wCriterio");
    var objY = document.getElementById("wY");
    var objO = document.getElementById("wO");
    var objValor = document.getElementById("wValor");

    var arrErrores = new Array();

    if (objCampo.options[ objCampo.selectedIndex ].value == "") {
        arrErrores.push("Seleccione un campo para la condicion");
    }

    if (objCriterio.options[ objCriterio.selectedIndex ].value == "") {
        arrErrores.push("Seleccione un criterio para la condicion");
    }

    if (objValor.type == "text") {
        if (objValor.value == "Inserte Valor") {
            arrErrores.push("Digite un valor para la condiciÃ³n");
        }
    } else {
        if (objValor.options[ objValor.selectedIndex ].value == "") {
            arrErrores.push("Seleccione un valor para la condiciÃ³n");
        }
    }

    txtValCondicion = "";
    if (objY.checked === true) {
        txtValCondicion = objY.value;
    } else {
        txtValCondicion = objO.value;
    }

    document.getElementById("mensajes").innerHTML = "";
    if (arrErrores.length > 0) {
        document.getElementById("mensajes").className = "msgError";
        for (i = 0; i < arrErrores.length; i++) {
            document.getElementById("mensajes").innerHTML += "<li>" + arrErrores[ i ] + "</li>";
        }
    } else {

        var objCondiciones = document.getElementById("wCondiciones");
        var arrDiv = objCondiciones.getElementsByTagName("div");

        var numCondiciones = 0;
        for (i = 0; i < arrDiv.length; i++) {
            if (arrDiv[ i ].id != "") {
                numCondiciones = parseInt(arrDiv[ i ].id.replace("wDivCondicion", ""));
            }
        }
        numCondiciones = numCondiciones + 1;

        document.getElementById("wCondiciones").innerHTML += "<div id='wDivCondicion" + numCondiciones + "'></div>";

        var txtParametros = "condicion=wDivCondicion" + numCondiciones
                + "&wCampo=" + objCampo.value
                + "&wCriterio=" + objCriterio.selectedIndex
                + "&wValor=" + objValor.value
                + "&wCondicion=" + txtValCondicion
                ;

        cargarContenido("wDivCondicion" + numCondiciones, "./contenidos/reportes/adicionarCondiciones.php", txtParametros, true);

    }



}

function adicionarCondicionProyectos() {

    var objCampo = document.getElementById("wCampo");
    var objCriterio = document.getElementById("wCriterio");
    var objY = document.getElementById("wY");
    var objO = document.getElementById("wO");
    var objValor = document.getElementById("wValor");

    var arrErrores = new Array();

    if (objCampo.options[ objCampo.selectedIndex ].value == "") {
        arrErrores.push("Seleccione un campo para la condicion");
    }

    if (objCriterio.options[ objCriterio.selectedIndex ].value == "") {
        arrErrores.push("Seleccione un criterio para la condicion");
    }

    if (objValor.type == "text") {
        if (objValor.value == "Inserte Valor") {
            arrErrores.push("Digite un valor para la condiciÃ³n");
        }
    } else {
        if (objValor.options[ objValor.selectedIndex ].value == "") {
            arrErrores.push("Seleccione un valor para la condiciÃ³n");
        }
    }

    txtValCondicion = "";
    if (objY.checked === true) {
        txtValCondicion = objY.value;
    } else {
        txtValCondicion = objO.value;
    }

    document.getElementById("mensajes").innerHTML = "";
    if (arrErrores.length > 0) {
        document.getElementById("mensajes").className = "msgError";
        for (i = 0; i < arrErrores.length; i++) {
            document.getElementById("mensajes").innerHTML += "<li>" + arrErrores[ i ] + "</li>";
        }
    } else {

        var objCondiciones = document.getElementById("wCondiciones");
        var arrDiv = objCondiciones.getElementsByTagName("div");

        var numCondiciones = 0;
        for (i = 0; i < arrDiv.length; i++) {
            if (arrDiv[ i ].id != "") {
                numCondiciones = parseInt(arrDiv[ i ].id.replace("wDivCondicion", ""));
            }
        }
        numCondiciones = numCondiciones + 1;

        document.getElementById("wCondiciones").innerHTML += "<div id='wDivCondicion" + numCondiciones + "'></div>";

        var txtParametros = "condicion=wDivCondicion" + numCondiciones
                + "&wCampo=" + objCampo.value
                + "&wCriterio=" + objCriterio.selectedIndex
                + "&wValor=" + objValor.value
                + "&wCondicion=" + txtValCondicion
                ;

        cargarContenido("wDivCondicion" + numCondiciones, "./contenidos/reportesProyectos/adicionarCondiciones.php", txtParametros, true);

    }



}

function adicionarDocumentoAnalizado(objDocumento, idContenedor, idDocumento, numAnchoDiv, numLimiteCaracteres) {

    if (objDocumento.value != "") {

        var objCotnenedor = document.getElementById(idContenedor);

        var arrDiv = objCotnenedor.getElementsByTagName("div");

        var numCondiciones = 0;
        for (i = 0; i < arrDiv.length; i++) {
            if (arrDiv[ i ].id != "") {
                numCondiciones = parseInt(arrDiv[ i ].id.replace(idDocumento, ""));
            }
        }
        numCondiciones = numCondiciones + 1;

        document.getElementById(idContenedor).innerHTML += "<div id='" + idDocumento + numCondiciones.toString() + "'></div>";

        var txtParametros = "eliminar=" + idDocumento + numCondiciones.toString();
        txtParametros += "&texto=" + objDocumento.value;
        txtParametros += "&secuencia=" + numCondiciones;
        txtParametros += "&ancho=" + numAnchoDiv;
        txtParametros += "&limite=" + numLimiteCaracteres;

        cargarContenido(idDocumento + numCondiciones.toString(), "./contenidos/desembolso/adicionarDocumentos.php", txtParametros, true);

    } else {
        alert("No ha agregado texto");
        objDocumento.focus();
    }

}


function limpiarRadio(objRadio, arrRadios) {
    for (i = 0; i < arrRadios.length; i++) {
        var objRadioLista = document.getElementById(arrRadios[ i ]);
        if (objRadio.id == arrRadios[ i ]) {
            objRadioLista.checked = true;
        } else {
            objRadioLista.checked = false;
        }
    }
}

function desembolsoRevisionJuridica(seqFormulario, seqCasaMano) {

    var txtCarpeta = "desembolso";
    var txtCasaMano = "";

    if (typeof (seqCasaMano) == "undefined") {
        txtCarpeta = "desembolso";
        txtCasaMano = "";
    } else {
        txtCarpeta = "casaMano";
        txtCasaMano = "&seqCasaMano=" + seqCasaMano;
    }

    var objFormulario = YAHOO.util.Dom.get("frmBusquedaOferta");

    someterFormulario('mensajes', objFormulario, './contenidos/' + txtCarpeta + '/pedirConfirmacion.php', false, true);

    YAHOO.util.Event.onContentReady(
            "tablaMensajes",
            function () {

                var objTabla = YAHOO.util.Dom.get("tablaMensajes");
                if (objTabla.className == "msgOk") {
                    var wndFormato;
                    try {

                        var txtUrl = "./contenidos/desembolso/formatoRevisionJuridica.php";
                        txtUrl += "?seqFormulario=" + seqFormulario + txtCasaMano;

                        var txtParametros = "resizable=0,location=0,scrollbars=1,width=750,height=700,left=100,top=100";

                        if (!(wndFormato = window.open(txtUrl, '_blank', txtParametros))) {
                            throw "ErrorPopUp";
                        }
                    } catch (objError) {
                        if (objError == "ErrorPopUp") {
                            alert("Ooops, al parecer tu navegador tiene bloqueado las ventanas emergentes, desactiva esa opcion y vuelve a intentar");
                        }
                    }
                }
            }
    );

}

function TotalCorteGrafica(dato) {
    DesplazadoGrafica(dato);
}

function IndependienteGrafica(dato) {
    DesplazadoGrafica(dato);
}

function DesplazadoGrafica(dato) {

    try {
        var txtUrl = "./contenidos/reportes/formatoEstadoCorte.php";
        txtUrl += "?txtGrafica=" + dato;

        var txtParametros = "resizable=0,location=0,scrollbars=1,width=780,height=700,left=100,top=100";

        if (!(wndFormato = window.open(txtUrl, '_blank', txtParametros))) {
            throw "ErrorPopUp";
        }
    } catch (objError) {
        if (objError == "ErrorPopUp") {
            alert("Ooops, al parecer tu navegador tiene bloqueado las ventanas emergentes, desactiva esa opcion y vuelve a intentar");
        }
    }

}

function ResumenProgramaPieGrafica(dato) {
    ResumenProgramaGrafica(dato);
}

function ResumenProgramaGrafica(dato) {

    try {
        var txtUrl = "./contenidos/reportes/formatoResumenPrograma.php";
        txtUrl += "?txtGrafica=" + dato;

        var txtParametros = "resizable=0,location=0,scrollbars=1,width=600,height=700,left=100,top=100";

        if (!(wndFormato = window.open(txtUrl, '_blank', txtParametros))) {
            throw "ErrorPopUp";
        }
    } catch (objError) {
        if (objError == "ErrorPopUp") {
            alert("Ooops, al parecer tu navegador tiene bloqueado las ventanas emergentes, desactiva esa opcion y vuelve a intentar");
        }
    }

}

function desembolsoRevisionTecnica(seqFormulario, seqCasaMano) {

    var txtCarpeta = "desembolso";
    var txtCasaMano = "";

    if (typeof (seqCasaMano) == "undefined") {
        txtCarpeta = "desembolso";
        txtCasaMano = "";
    } else {
        txtCarpeta = "casaMano";
        txtCasaMano = "&seqCasaMano=" + seqCasaMano;
    }

    var objFormulario = YAHOO.util.Dom.get("frmBusquedaOferta");
    someterFormulario('mensajes', objFormulario, './contenidos/' + txtCarpeta + '/pedirConfirmacion.php', false, true);
    YAHOO.util.Event.onContentReady(
            "tablaMensajes",
            function () {
                var objTabla = YAHOO.util.Dom.get("tablaMensajes");
                if (objTabla.className == "msgOk") {
                    var wndFormato;
                    try {

                        var txtUrl = "./contenidos/desembolso/formatoRevisionTecnica.php";
                        txtUrl += "?seqFormulario=" + seqFormulario + txtCasaMano;

                        var txtParametros = "resizable=0,location=0,scrollbars=1,width=780,height=700,left=100,top=100";

                        if (!(wndFormato = window.open(txtUrl, '_blank', txtParametros))) {
                            throw "ErrorPopUp";
                        }
                    } catch (objError) {
                        if (objError == "ErrorPopUp") {
                            alert("Ooops, al parecer tu navegador tiene bloqueado las ventanas emergentes, desactiva esa opcion y vuelve a intentar");
                        }
                    }
                }
            }
    );

}

function calcularArea(idLargo, idAncho, idArea) {

    var objLargo = YAHOO.util.Dom.get(idLargo);
    var objAncho = YAHOO.util.Dom.get(idAncho);
    var objArea = YAHOO.util.Dom.get(idArea);

    soloNumeros(objLargo);
    soloNumeros(objAncho);

    var numAreaTotal = parseFloat(objLargo.value * objAncho.value);

    objArea.value = numAreaTotal.toFixed(2);

    sumarAreas("areaTotal");

}

function sumarAreas(idArea) {

    var objMultiple = YAHOO.util.Dom.get("numAreaMultiple");
    var objAlcoba1 = YAHOO.util.Dom.get("numAreaAlcoba1");
    var objAlcoba2 = YAHOO.util.Dom.get("numAreaAlcoba2");
    var objAlcoba3 = YAHOO.util.Dom.get("numAreaAlcoba3");
    var objCocina = YAHOO.util.Dom.get("numAreaCocina");
    var objBano1 = YAHOO.util.Dom.get("numAreaBano1");
    var objBano2 = YAHOO.util.Dom.get("numAreaBano2");
    var objLavanderia = YAHOO.util.Dom.get("numAreaLavanderia");
    var objCirculacion = YAHOO.util.Dom.get("numAreaCirculaciones");
    var objPatio = YAHOO.util.Dom.get("numAreaPatio");

    objMultiple.value = (objMultiple.value == "") ? 0 : objMultiple.value;
    objAlcoba1.value = (objAlcoba1.value == "") ? 0 : objAlcoba1.value;
    objAlcoba2.value = (objAlcoba2.value == "") ? 0 : objAlcoba2.value;
    objAlcoba3.value = (objAlcoba3.value == "") ? 0 : objAlcoba3.value;
    objCocina.value = (objCocina.value == "") ? 0 : objCocina.value;
    objBano1.value = (objBano1.value == "") ? 0 : objBano1.value;
    objBano2.value = (objBano2.value == "") ? 0 : objBano2.value;
    objLavanderia.value = (objLavanderia.value == "") ? 0 : objLavanderia.value;
    objCirculacion.value = (objCirculacion.value == "") ? 0 : objCirculacion.value;
    objPatio.value = (objPatio.value == "") ? 0 : objPatio.value;

    var numAreaTotal = parseFloat(objMultiple.value);
    numAreaTotal += parseFloat(objAlcoba1.value);
    numAreaTotal += parseFloat(objAlcoba2.value);
    numAreaTotal += parseFloat(objAlcoba3.value);
    numAreaTotal += parseFloat(objCocina.value);
    numAreaTotal += parseFloat(objBano1.value);
    numAreaTotal += parseFloat(objBano2.value);
    numAreaTotal += parseFloat(objLavanderia.value);
    numAreaTotal += parseFloat(objCirculacion.value);
    numAreaTotal += parseFloat(objPatio.value);

    var objAreaTotal = YAHOO.util.Dom.get(idArea);
    objAreaTotal.innerHTML = numAreaTotal.toFixed(2) + "<input type='hidden' id='numAreaTotal' name='numAreaTotal' value='" + numAreaTotal + "'/>";

}

var objHint = new YAHOO.widget.Panel(
        "hint",
        {
            width: "400px",
            close: false,
            modal: false,
            fixedCenter: true,
            draggable: false
        }
);

function mostrarHint(txtTexto) {

    if (txtTexto.length > 50) {

        var txtDiv = "<table>";
        txtDiv += "<tr><td align='justify' style='padding-left:20px; padding-right:20px;'>" + txtTexto + "</td></tr>"
        txtDiv += "</table>";

        objHint.setHeader("Texto Completo");
        objHint.setBody(txtDiv);
        objHint.render(document.body);
        objHint.show();
    }
}

function ocultarHint() {
    objHint.hide();
}

function tamanoOriginal(txtRuta, txtTexto) {

    var numAncho = YAHOO.util.Dom.getViewportWidth() - 200;
    var numAlto = YAHOO.util.Dom.getViewportHeight() - 100;

    var objConfiguracion = {
        width: numAncho,
        height: numAlto,
        close: true,
        fixedcenter: true,
        draggable: false,
        modal: true,
        effect: {
            effect: YAHOO.widget.ContainerEffect.FADE,
            duration: 0.75
        }
    }

    var txtCodigo = "<div style='width:100%; height:" + (numAlto - 50) + ";overflow:auto; text-align:center; vertical-align:middle'>";
    txtCodigo += "<img src='./recursos/imagenes/desembolsos/" + txtRuta + "' />";
    txtCodigo += "</div>";

    var objPanel = new YAHOO.widget.Panel("panel", objConfiguracion);
    objPanel.setHeader(txtTexto);
    objPanel.setBody(txtCodigo);
    objPanel.render(document.body);
    objPanel.show();

}

function recogerValor(arrDestinos, txtTipoDato, idVariables) {

    var objVariables = YAHOO.util.Dom.get(idVariables);

    var respuesta = function (o) {

        for (i = 0; i < arrDestinos.length; i++) {
            var idDestino = arrDestinos[ i ];
            var objDestino = YAHOO.util.Dom.get(idDestino);

            if (YAHOO.util.Dom.get("var" + idDestino) != null) {
                eliminarObjeto("var" + idDestino);
            }

            objDestino.innerHTML = o.responseText;
            objVariables.innerHTML += "<input type='hidden' id='var" + idDestino + "' name='" + idDestino + "' value='" + o.responseText + "' />";

        }

    }

    var falla = function (o) {
        alert("falla = " + o.status + ": " + o.responseText);
    }

    var aceptar = function () {
        this.submit();
    }

    var cancelar = function () {
        this.cancel();
    }

    var objConfiguracion = {
        width: "300px",
        height: "140px",
        fixedcenter: true,
        modal: false,
        close: true,
        effect: {
            effect: YAHOO.widget.ContainerEffect.FADE,
            duration: 0.75
        },
        draggable: false,
        buttons: [{
                text: "Aceptar",
                handler: aceptar,
                isDefault: true
            },
            {
                text: "Cancelar",
                handler: cancelar
            }]
    }

    var txtTextoTipoDato = "";
    if (txtTipoDato == "numero") {
        txtTextoTipoDato = "Digite un valor numerico";
    }

    if (txtTipoDato == "texto") {
        txtTextoTipoDato = "Digite un texto";
    }

    if (txtTipoDato == "select") {
        txtTextoTipoDato = "Seleccione un valor";
    }

    var txtCodigo = "<form method='post' action='./contenidos/desembolso/cambiarValor.php'>";
    txtCodigo += "<p><b>" + txtTextoTipoDato + "</b></p>";

    if (txtTipoDato != "select") {
        txtCodigo += "<input type='text' name='valor' value='' sinCaracteresEspeciales( this ); style='width:100%' />";
    } else {
        txtCodigo += "<select name='valor' style='width:100%'>";
        txtCodigo += "<option value='Norte'>Norte</option>";
        txtCodigo += "<option value='Sur'>Sur</option>";
        txtCodigo += "<option value='Centro'>Centro</option>";
        txtCodigo += "<option value='Otra'>- -</option>";
        txtCodigo += "</select>";
    }


    txtCodigo += "<input type='hidden' name='tipoDato' value='" + txtTipoDato + "' />";
    txtCodigo += "</form>";

    var objPanel = new YAHOO.widget.Dialog("dialog1", objConfiguracion);

    objPanel.validate = function () {
        var objDatos = this.getData();
        if (objDatos.valor == "") {
            alert("Digite un valor");
            return false;
        } else {
            if (txtTipoDato == "numero") {
                if (parseInt(objDatos.valor)) {
                    return true;
                } else {
                    alert("El valor debe ser numerico");
                    return false;
                }
            }
        }
        return true;
    }

    objPanel.callback = {
        success: respuesta,
        failure: falla
    }

    objPanel.setHeader("Introduzca Texto");
    objPanel.setBody(txtCodigo);

    objPanel.render(document.body);
    objPanel.show();

}

function calendarioDesembolso(arrDestinos, idVariables) {

    var objVariables = YAHOO.util.Dom.get(idVariables);

    var objPanel = new YAHOO.widget.Panel(
            "calendar",
            {
                width: "195px",
                height: "230px",
                fixedcenter: true,
                close: true,
                draggable: true,
                modal: false,
                visible: false
            }
    );

    YAHOO.util.Event.onContentReady(
            "calendarioPopUp",
            function () {

                var sleeccionaFecha = function (type, args, obj) {
                    var dates = args[0];
                    var date = dates[0];
                    var year = date[0], month = date[1], day = date[2];

                    var fecha = year + "-" + month + "-" + day;

                    for (i = 0; i < arrDestinos.length; i++) {
                        cargarContenido(arrDestinos[ i ], "./contenidos/desembolso/cambiarValor.php", "tipoDato=fecha&valor=" + fecha, true);

                        if (YAHOO.util.Dom.get("var" + arrDestinos[ i ]) != null) {
                            eliminarObjeto("var" + arrDestinos[ i ]);
                        }

                        objVariables.innerHTML += "<input type='hidden' id='var" + arrDestinos[ i ] + "' name='" + arrDestinos[ i ] + "' value='" + fecha + "' />";
                    }

                    objPanel.hide();
                }

                var navConfig = {
                    strings: {
                        month: "Seleccione Mes",
                        year: "Digite AÃ±o",
                        submit: "OK",
                        cancel: "Cancelar",
                        invalidYear: "Ingrese un aÃ±o valido"
                    },
                    monthFormat: YAHOO.widget.Calendar.SHORT,
                    initialFocus: "year"
                };

                var objCalendario = new YAHOO.widget.Calendar("calendarioPopUp", {
                    navigator: navConfig
                });

                objCalendario.cfg.setProperty(
                        "MONTHS_LONG",
                        [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ]
                        );

                objCalendario.cfg.setProperty(
                        "WEEKDAYS_SHORT",
                        [
                            "Do",
                            "Lu",
                            "Ma",
                            "Mi",
                            "Ju",
                            "Vi",
                            "Sa"
                        ]
                        );

                objCalendario.selectEvent.subscribe(sleeccionaFecha, objCalendario, true);
                objCalendario.render();
            }
    );

    objPanel.setHeader("Seleccione la fecha");
    objPanel.setBody("<div id='calendarioPopUp'><img src='./recursos/imagenes/cargando.gif' style='width:170px'></div>");
    objPanel.render(document.body);
    objPanel.show();

}

function checkSubsidioFonvivienda(objCheck) {
    var objSubsidioFonvivienda = YAHOO.util.Dom.get("subsidioFonvivienda");

    objSubsidioFonvivienda.innerHTML = "";
    if (objCheck.checked) {
        objSubsidioFonvivienda.innerHTML = "y Fonvivienda";
    }

}

function desembolsoEstudioTitulos(seqFormulario) {

    var objFormulario = YAHOO.util.Dom.get("frmBusquedaOferta");
    someterFormulario('mensajes', objFormulario, './contenidos/desembolso/pedirConfirmacion.php', false, true);
    YAHOO.util.Event.onContentReady(
            "tablaMensajes",
            function () {
                var objTabla = YAHOO.util.Dom.get("tablaMensajes");
                if (objTabla.className == "msgOk") {
                    var wndFormato;
                    try {

                        var txtUrl = "./contenidos/desembolso/formatoEstudioTitulosformatoEstudioTitulos.php";
                        txtUrl += "?seqFormulario=" + seqFormulario;

                        var txtParametros = "resizable=0,location=0,scrollbars=1,width=780,height=700,left=100,top=100";

                        if (!(wndFormato = window.open(txtUrl, '_blank', txtParametros))) {
                            throw "ErrorPopUp";
                        }
                    } catch (objError) {
                        if (objError == "ErrorPopUp") {
                            alert("Ooops, al parecer tu navegador tiene bloqueado las ventanas emergentes, desactiva esa opcion y vuelve a intentar");
                        }
                    }
                }
            }
    );

}

function cargarRegistroDesembolso(seqFormulario, seqSolicitud) {

    var objMensajes = YAHOO.util.Dom.get("mensajes");
    var objVariables = YAHOO.util.Dom.get("variables");
    var objCargando = obtenerObjetoCargando();

    var objTablaResumen = YAHOO.util.Dom.get("tablaResumen");
    var arrImagenes = objTablaResumen.getElementsByTagName("img");

    for (i = 0; i < arrImagenes.length; i++) {
        if (arrImagenes[ i ].id == "imagen-" + seqSolicitud) {
            arrImagenes[ i ].src = "./recursos/imagenes/bullet.jpg";
        } else {
            arrImagenes[ i ].src = "./recursos/imagenes/bulletRojo.png";
        }
    }

    var handleSuccess = function (o) {

        //			objMensajes.innerHTML = o.responseText;

        eval(o.responseText);
        for (var idCampo in objRespuesta) {

            var objDestino = YAHOO.util.Dom.get(idCampo);

            var txtValor = "";

            if (objDestino != null) {
                if (YAHOO.lang.isNumber(objRespuesta[ idCampo ])) {
                    if (objDestino.type == "text") {
                        txtValor = objRespuesta[ idCampo ];
                    } else {
                        txtValor = dar_formato(objRespuesta[ idCampo ]);
                    }
                } else {
                    txtValor = objRespuesta[ idCampo ];
                }

                if (objDestino.type == "") {
                    objDestino.innerHTML = txtValor;
                    objVariables.innerHTML += "<input type='hidden' name='" + idCampo + "' value='" + objRespuesta[ idCampo ] + "'>";
                }

                if (objDestino.type == "text") {
                    objDestino.value = txtValor;
                }

                if (objDestino.type == "checkbox") {
                    objDestino.checked = (objRespuesta[ idCampo ] == 1) ? true : false;
                }

                if (objDestino.type == "radio") {
                    objDestino.checked = (objRespuesta[ idCampo ] == 1) ? true : false;
                }

                if (objDestino.type == "select-one") {
                    for (i = 0; i < objDestino.options.length; i++) {
                        if (objDestino.options[ i ].value == txtValor) {
                            objDestino.selectedIndex = i;
                        }
                    }
                }

                if (objDestino.type == "hidden") {
                    objDestino.value = objRespuesta[ idCampo ];
                }
            }

        }

        objCargando.hide();
    }

    var handleFailure = function (o) {
        if (o.responseText !== undefined) {
            if (o.status == "401") {
                document.location = 'index.php';
            } else {
                var htmlCode = +o.status + " " + o.statusText;
                objMensajes.innerHTML = htmlCode;
            }
            objCargando.hide();
            return false;
        }
    }

    var callback = {
        success: handleSuccess,
        failure: handleFailure
    };

    objCargando.show();

    var callObj = YAHOO.util.Connect.asyncRequest(
            "POST",
            "./contenidos/desembolso/cargarSolicitud.php",
            callback,
            "formulario=" + seqFormulario + "&solicitud=" + seqSolicitud
            );

}

function desembolsoSolicitud(seqFormulario, seqSolicitud) {

    var wndFormato;
    try {

        var txtUrl = "./contenidos/desembolso/formatoSolicitudDesembolso.php";
        txtUrl += "?seqFormulario=" + seqFormulario + "&seqSolicitud=" + seqSolicitud;

        var txtParametros = "resizable=0,location=0,scrollbars=1,width=750,height=700,left=100,top=100";

        if (!(wndFormato = window.open(txtUrl, '_blank', txtParametros))) {
            throw "ErrorPopUp";
        }
    } catch (objError) {
        if (objError == "ErrorPopUp") {
            alert("Ooops, al parecer tu navegador tiene bloqueado las ventanas emergentes, desactiva esa opcion y vuelve a intentar");
        }
    }


}

/**
 * FUNCION QUE MANEJA EL CAMBIO DE FASES EN DESEMBOLSO
 * PARA MOSTRAR LA INFORMACION PERTINENTE DE CADA HOGAR
 * SEGUN EL ESTADO DEL PROCESO O LA SOLICITUD DEL USUARIO
 * @author Bernardo Zerda 
 * @param String idContenido   ==> Donde va ubicado el resultado del llamado asincrono
 * @param String idImprimir    ==> Identificador del objeto donde se ubica el link de impresion
 * @param String txtCodigo     ==> Nombre del archivo php que responde la peticion
 * @param String txtImprimir   ==> Texto de la funcion JS que se llama para imprimir el formulario
 * @param String txtFase	   ==> Nombre de la fase
 * @param String txtParametros ==> Parametros adicionales para el formulario escritos en forma GET Ej: foo=hola&var=mundo 
 */

function cambiarFase(idContenido, idImprimir, txtCodigo, txtImprimir, txtFase, txtParametros) {

    // si viene funcion de impresion se coloca el link de impresion
    var objImprimir = YAHOO.util.Dom.get(idImprimir);
    if (txtImprimir != "") {
        objImprimir.innerHTML = "<a href='#' onClick='" + txtImprimir + "'>Imprimir el Formulario</a>";
    } else {
        objImprimir.innerHTML = "";
    }

    // coloca en el formulario el valor de la fase actual
    var objFase = YAHOO.util.Dom.get("fase");
    objFase.value = txtFase;

    // Carga el contenido de la fase 
    cargarContenido(idContenido, txtCodigo, txtParametros, true);

}

function cambiarOpcionLegalizacion(idContenido, paginaPhp) {
    // Carga el contenido de la opcion de legalizacion
    cargarContenido(idContenido, paginaPhp);

}

function mostrarDocumentosEscrituracion(idDocumentos, idTablaDocumentos) {

    var objTablaDocumentos = YAHOO.util.Dom.get(idTablaDocumentos);

    var arrFilas = objTablaDocumentos.getElementsByTagName("tr");
    for (i = 0; i < arrFilas.length; i++) {

        var arrId = arrFilas[ i ].id.split("-");

        if (idDocumentos == "persona") {
            if (arrId[ 1 ] == "empresa") {
                arrFilas[ i ].style.display = "none";
            } else {
                arrFilas[ i ].style.display = "";
            }
        } else {
            if (arrId[ 1 ] == "persona") {
                arrFilas[ i ].style.display = "none";
            } else {
                arrFilas[ i ].style.display = "";
            }
        }

    }

}

function mostrarTooltipSolicitud(objDestino, fchCreacion, fchActualizacion) {



    var objConfiguracion = {
        context: objDestino,
        text: "Fecha Creación: " + fchCreacion + "<br>Fecha Actualización:" + fchActualizacion,
        effect: {
            effect: YAHOO.widget.ContainerEffect.FADE,
            duration: 0.75
        }
    }

    var objToolTip = new YAHOO.widget.Tooltip("tt1", objConfiguracion);

    objToolTip.render(objDestino);
    objToolTip.show();

}

function cambioEstadosPosibles() {

    var objContenedor = YAHOO.util.Dom.get("cambioEstadosPosibles");
    objContenedor.style.display = "";

    var objConfiguracion = {
        width: "450px",
        fixedcenter: true,
        close: true,
        draggable: true,
        modal: true,
        effect: {
            effect: YAHOO.widget.ContainerEffect.FADE,
            duration: 0.75
        }
    }

    var objPanel = new YAHOO.widget.Panel("cambioEstadosPosibles", objConfiguracion);
    objPanel.render(document.body);
    objPanel.show();

}

function imprimir() {
    window.print();
}

function cargarContenidoPlano(txtInputDireccion, txtDivDireccionOculto) {


    var objDireccion = YAHOO.util.Dom.get(txtInputDireccion);

    var txtDivDestino = txtDivDireccionOculto;
    var txtArchivoPhp = './contenidos/subsidios/obtenerDireccionPlano.php';
    var txtParametros = 'txtDireccion=' + objDireccion.value + '&txtExtraDiv=' + txtInputDireccion;

    document.getElementById(txtDivDestino).innerHTML = '';

    // Objeto de respuesta si es satisfactoria la carga
    var handleSuccess =
            function (o) {
                if (o.responseText !== undefined) {
                    // Toda respuesta del archivo en el parametro se muestra en el objeto destino
                    document.getElementById(txtDivDestino).innerHTML = o.responseText;
                }
            };

    // Objeto de respuesta si la carga falla
    var handleFailure =
            function (o) {
                if (o.responseText !== undefined) {
                    return false;
                }
            };

    // Objeto de respuestas
    var callback = {
        success: handleSuccess,
        failure: handleFailure
    };

    // peticion asincrona al servidor
    var callObj = YAHOO.util.Connect.asyncRequest("POST", txtArchivoPhp, callback, txtParametros);

    return callObj;
}

function recogerDireccion(txtInputDireccion, txtDivDireccionOculto) {
    cargarContenidoPlano(txtInputDireccion, txtDivDireccionOculto);
    setTimeout("mostrarObjDireccionOculto( '" + txtInputDireccion + "', '" + txtDivDireccionOculto + "')", 400);
}

function mostrarObjDireccionOculto(txtInputDireccion, txtDivDireccionOculto) {

    var direccionGenerada;
    var txtDireccionForm = document.getElementById(txtInputDireccion);
    var txtDivDireccionGenerada = "divDireccionGenerada_" + txtInputDireccion;

    var respuesta = function (o) {
    }
    var falla = function (o) {
        alert("falla = " + o.status + ": " + o.responseText);
    }

    var aceptar = function () {

        var bolAlerta = false;
        if( YAHOO.util.Dom.get('radTipoDireccion').checked ){
            if( YAHOO.util.Dom.get(txtDivDireccionGenerada).innerHTML.substring(0,1) == "-" ){
                alert( "Si no dispone de la información de la dirección urbana completa, seleccione la opción 'Dirección Rural'" );
                bolAlerta = true;
            }else{
                if(
                    YAHOO.util.Dom.get('txtDireccionTipoVia').selectedIndex == 0 ||
                    YAHOO.util.Dom.get('txtNumeroVia').value == "" ||
                    YAHOO.util.Dom.get('txtDireccionNumeroVia').value == "" ||
                    YAHOO.util.Dom.get('txtNumeroAdicional').value == ""
                ){
                    alert( "Complete la dirección" );
                    bolAlerta = true;
                }
            }
        }

        if( bolAlerta == false ) {
            direccionGenerada = document.getElementById(txtDivDireccionGenerada);
            txtDireccionForm.value.replace(/s{2,}/g, ' ');
            txtDireccionForm.value = direccionGenerada.innerHTML;
            this.cancel();

            direccionGenerada.innerHTML = txtDireccionForm.value;
            //mostrarMapa(txtDireccionForm);

            var objCiudad = document.getElementById("seqCiudad");
            if (objCiudad != null) {
                objCiudad.focus();
            }
        }
    }

    var cancelar = function () {
        // txtDireccionForm.value = "";

        this.cancel();
    }

    var objConfiguracion = {
        width: "640px",
        height: "310px",
        fixedcenter: true,
        modal: false,
        close: true,
        effect: {
            effect: YAHOO.widget.ContainerEffect.FADE,
            duration: 0.75
        },
        draggable: false,
        buttons: [{
                text: "Aceptar",
                handler: aceptar,
                isDefault: true
            },
            {
                text: "Cancelar",
                handler: cancelar
            }]
    }

    var objPanel = new YAHOO.widget.Dialog("dialog1", objConfiguracion);
    objPanel.validate = function () {
        var objDatos = this.getData();
        if (objDatos.valor == "") {
            alert("Digite un valor");
            return false;
        }
        return true;
    }

    var objDireccionOculto = document.getElementById(txtDivDireccionOculto);
    objPanel.callback = {
        success: respuesta,
        failure: falla
    }

    objPanel.setHeader("Introduzca la Dirección");

    objPanel.setBody(objDireccionOculto.innerHTML);

    objPanel.render(document.body);
    objPanel.show();
    eventoActivarLetraBis("chkViaBis", "txtLetraViaBis");
    eventoCambioCalleDireccion( );
    actualizarDireccion(txtDivDireccionGenerada);

}

function eventoCambioCalleDireccion( ) {

    var objDireccionTipoVia = document.getElementById("txtDireccionTipoVia");
    var txtDireccionTipoVia = objDireccionTipoVia.value;

    var frmCheckEsteVia = document.getElementById('frmCheckEsteVia');
    var frmCheckSurVia = document.getElementById('frmCheckSurVia');
    var frmCheckEsteNumero = document.getElementById('frmCheckEsteNumero');
    var frmCheckSurNumero = document.getElementById('frmCheckSurNumero');

    if (txtDireccionTipoVia == 'CL' ||
            txtDireccionTipoVia == 'DG' ||
            txtDireccionTipoVia == 'AC'
            )
    {
        frmCheckEsteVia.disabled = true;
        frmCheckSurNumero.disabled = true;
        frmCheckEsteVia.checked = false;
        frmCheckSurNumero.checked = false;

        frmCheckSurVia.disabled = false;
        frmCheckEsteNumero.disabled = false;
    } else if (txtDireccionTipoVia != '')
    {
        frmCheckEsteVia.disabled = false;
        frmCheckSurNumero.disabled = false;

        frmCheckSurVia.disabled = true;
        frmCheckEsteNumero.disabled = true;
        frmCheckSurVia.checked = false;
        frmCheckEsteNumero.checked = false;
    } else
    {
        frmCheckEsteVia.disabled = true;
        frmCheckSurNumero.disabled = true;
        frmCheckSurVia.disabled = true;
        frmCheckEsteNumero.disabled = true;

        frmCheckSurNumero.checked = false;
        frmCheckSurNumero.checked = false;
        frmCheckSurVia.checked = false;
        frmCheckEsteNumero.checked = false;
    }

}

function eventoActivarLetraBis(idCheck, idSelect) {
    var check = document.getElementById(idCheck);
    var select = document.getElementById(idSelect);

    if (check.checked) {
        select.disabled = false;
    } else {
        select.disabled = true;
    }
}


function actualizarDireccion(txtDivDireccionGenerada)
{
    //alert (document.getElementById('radTipoDireccion').value);
    var radTipoDireccion = document.getElementsByName('radTipoDireccion');
    var direccionGenerada = document.getElementById(txtDivDireccionGenerada);
    var txtDireccion;

    for (var i = 0; i < radTipoDireccion.length; i++) {
        if (radTipoDireccion[i].checked) {
            var valTipoDireccion = radTipoDireccion[i].value;
            break;
        }
    }

    if (valTipoDireccion != 1) {
        // var txtDireccionForm = document.getElementById( 'txtDireccion' );			
        var valTipoVia = document.getElementById('txtDireccionTipoVia').value;
        var valNumeroVia = document.getElementById('txtNumeroVia').value;
        var valLetraCalle = document.getElementById('txtLetraVia').value;
        var valorNumeroAdicional = document.getElementById('txtNumeroAdicional').value;

        var valViaBis = document.getElementById('chkViaBis');
        if (valViaBis.checked)
            valViaBis = 'Bis';
        else
            valViaBis = '';

        var valLetraViaBis = document.getElementById('txtLetraViaBis').value;


        var valViaEste = document.getElementById('frmCheckEsteVia');
        if (valViaEste.checked)
            valViaEste = 'Este';
        else
            valViaEste = '';

        var valViaSur = document.getElementById('frmCheckSurVia');
        if (valViaSur.checked)
            valViaSur = 'Sur';
        else
            valViaSur = '';

        var valNumero = document.getElementById('txtDireccionNumeroVia').value;
        var valLetraNumero = document.getElementById('txtLetraNumero').value;

        /*
         var valNumeroBis = document.getElementById( 'chkViaBis' );
         if( valNumeroBis.checked )
         valNumeroBis = 'Bis';
         else
         valNumeroBis = '';
         */

        var valNumeroEste = document.getElementById('frmCheckEsteNumero');
        if (valNumeroEste.checked)
            valNumeroEste = 'Este';
        else
            valNumeroEste = '';

        var valNumeroSur = document.getElementById('frmCheckSurNumero');
        if (valNumeroSur.checked)
            valNumeroSur = 'Sur';
        else
            valNumeroSur = '';

        var txtDireccionAdicional = document.getElementById('txtDireccionAdicional').value;

        txtDireccion = valTipoVia + ' ' + valNumeroVia + ' ' + valLetraCalle + ' ' +
                valViaBis + ' ' + valLetraViaBis + ' ' + valViaEste + ' ' +
                valViaSur + ' ' + valNumero + ' ' + valLetraNumero + ' ' +
                // valNumeroBis + ' ' + valorLetraNumeroBis+ ' ' 
                valorNumeroAdicional + ' ' +
                valNumeroEste + ' ' + valNumeroSur + ' ' + txtDireccionAdicional;
    } else {
        txtDireccion = document.getElementById('txtDireccionRural').value;
    }

    direccionGenerada.innerHTML = txtDireccion.replace(/s{2,}/g, ' ');

}

function actualizaTipoDireccion(vTipo) {
    var valorSeleccionado = vTipo.value;
    if (document.getElementById('tipoRural') != null) {
        document.getElementById('tipoRural').checked = false;
        document.getElementById('tipoUrbano').checked = false;
        if (valorSeleccionado == 0) {
            //document.getElementById('seqTipoDireccion').value = 0;
            document.getElementById('tipoUrbano').checked = true;
        } else {
            //document.getElementById('seqTipoDireccion').value = 1;
            document.getElementById('tipoRural').checked = true;
        }
    }
}

function previewReporteador() {
    someterFormulario("resultado", "reporteador", "./contenidos/reportes/ejecuarReporteador.php?preview=1", true, true);
}

function ejecutarReporteadorExportar( ) {
    someterFormulario("resultado", "reporteador", "./contenidos/reportes/ejecuarReporteador.php", true, false);
}

function previewReporteadorProyectos() {
    someterFormulario("resultado", "reporteador", "./contenidos/reportesProyectos/ejecuarReporteador.php?preview=1", true, true);
}

function ejecutarReporteadorProyectosExportar( ) {
    someterFormulario("resultado", "reporteador", "./contenidos/reportesProyectos/ejecuarReporteador.php", true, false);
}

function borrarFormulario(txtForm) {

    var objFormulario = YAHOO.util.Dom.get(txtForm);
    objElementos = objFormulario.elements;
    numElementos = objElementos.length;

    for (i = 0; i < numElementos; i++) {
        if (objElementos[i].type == "text" || objElementos[i].type == "textarea") {
            objElementos[i].value = '';
        } else if (objElementos[i].type == "select-one") {
            objElementos[i].options.selectedIndex = 0;
        } else if (objElementos[i].type == "checkbox" || objElementos[i].type == "radio") {
            objElementos[i].checked = false;
        }
    }

}

function salvarBVU(txtForm) {

    someterFormulario('mensajes', txtForm, './contenidos/bvu/salvarFormulario.php', false, true);
    YAHOO.util.Event.onContentReady(
            "tablaMensajes",
            function () {
                var objTabla = YAHOO.util.Dom.get("tablaMensajes");
                if (objTabla.className == "msgOk") {
                    try {
                        borrarFormulario(txtForm);

                        var wndFormato;
                        var txtUrl = "./contenidos/bvu/formatoFormularioBVU.php";
                        var txtParametros = "resizable=0,location=0,scrollbars=1,width=780,height=700,left=100,top=100";
                        if (!(wndFormato = window.open(txtUrl, '_blank', txtParametros))) {
                            throw "ErrorPopUp";
                        }

                    } catch (objError) {
                        if (objError == "ErrorPopUp") {
                            alert("Ooops, al parecer tu navegador tiene bloqueado las ventanas emergentes, desactiva esa opcion y vuelve a intentar");
                        }
                    }
                }
            }
    );
}

function verAyudaReporteador(idTipoAyuda) {

    var txtBody = "<b>Esta sección esta diseñada de la siguiente manera</b><br />";

    if (idTipoAyuda == 1) {
        // txtBody += "<ol>";
        txtBody += "<ul><b>Listar Registros: </b>Genera el reporte con todos los campos que seleccionaron.</ul>";
        txtBody += "<ul><b>Conteo de Registros: </b>Muestra el número de registros que tiene el reporte independientemente si se hayan seleccionado campos o no.</ul>";
        txtBody += "<ul><b>Jefe de Hogar: </b>Cuando esta seleccionada esta opción, en el reporte aparece unicamente el Jefe de Hogar</ul>";
        // txtBody += "</ol>";
    }

    if (idTipoAyuda == 2) {
        txtBody += "<ul><b>Campos para mostrar en el reporte.</b></ul>";
        txtBody += "<ul><b>Datos Ciudadano: </b>Datos correspondiente al ciudadano.</ul>";
        txtBody += "<ul><b>Datos del Hogar: </b>Datos acerca la vivienda.</ul>";
        txtBody += "<ul><b>Datos de la Postulacion: </b>Datos de la vivienda con la que se postulan.</ul>";
        txtBody += "<ul><b>Informacion Financiera: </b>Informacion financiera del hogar.</ul>";
        txtBody += "<ul><b>Datos del Inmueble: </b>Datos del inmueble al cual se le va a hacer el desembolso.</ul>";
    }

    if (idTipoAyuda == 3) {
        txtBody += "<ul><b>Criterios para hacer los filtros en el reporte a generar.</b></ul>";
        txtBody += "<ul><b>Datos Ciudadano: </b>Datos correspondiente al ciudadano.</ul>";
        txtBody += "<ul><b>Datos del Hogar: </b>Datos acerca la vivienda.</ul>";
        txtBody += "<ul><b>Datos de la Postulacion: </b>Datos de la vivienda con la que se postulan.</ul>";
        txtBody += "<ul><b>Informacion Financiera: </b>Informacion financiera del hogar.</ul>";
        txtBody += "<ul><b>Datos del Inmueble: </b>Datos del inmueble al cual se le va a hacer el desembolso.</ul>";
    }

    var objPopUp = new YAHOO.widget.Panel(
            "pop",
            {
                width: "500px",
                fixedcenter: true,
                close: true,
                draggable: true,
                modal: true,
                visible: true
            }
    );

    // Encabezado
    objPopUp.setHeader("Ayuda Reporteador");

    // cuerpo del panel
    objPopUp.setBody(txtBody);

    // El objeto se despliega sobre el cuerpo del documento html
    objPopUp.render(document.body);
    objPopUp.show();

}

function verAyudaReporteadorProyectos(idTipoAyuda) {

    var txtBody = "<b>Esta sección esta diseñada de la siguiente manera</b><br />";

    if (idTipoAyuda == 1) {
        // txtBody += "<ol>";
        txtBody += "<ul><b>Listar Registros: </b>Genera el reporte con todos los campos que seleccionaron.</ul>";
        txtBody += "<ul><b>Conteo de Registros: </b>Muestra el número de registros que tiene el reporte independientemente si se hayan seleccionado campos o no.</ul>";
        // txtBody += "</ol>";
    }

    if (idTipoAyuda == 2) {
        txtBody += "<ul><b>Campos para mostrar en el reporte.</b></ul>";
        txtBody += "<ul><b>Datos del Proyecto: </b>Datos correspondientes al Proyecto.</ul>";
        txtBody += "<ul><b>Datos del Oferente: </b>Datos acerca del Oferente del Proyecto.</ul>";
        txtBody += "<ul><b>Datos del Comité de Elegibilidad: </b>Datos del comité de Elegibilidad.</ul>";
    }

    if (idTipoAyuda == 3) {
        txtBody += "<ul><b>Criterios para hacer los filtros en el reporte a generar.</b></ul>";
        txtBody += "<ul><b>Datos del Proyecto: </b>Datos correspondientes al proyecto.</ul>";
        txtBody += "<ul><b>Datos del Oferente: </b>Datos acerca del Oferente.</ul>";
        txtBody += "<ul><b>Datos del Comité de Elegibilidad: </b>Datos del comité de Elegibilidad.</ul>";
    }

    var objPopUp = new YAHOO.widget.Panel(
            "pop",
            {
                width: "500px",
                fixedcenter: true,
                close: true,
                draggable: true,
                modal: true,
                visible: true
            }
    );

    // Encabezado
    objPopUp.setHeader("Ayuda Reporteador");

    // cuerpo del panel
    objPopUp.setBody(txtBody);

    // El objeto se despliega sobre el cuerpo del documento html
    objPopUp.render(document.body);
    objPopUp.show();

}

function plantillaModuloOperativoConceptos(  ) {

    var txtBody = "";

    txtBody += "Ingresar un archivo plano separado por tabulaciones con los siguientes títulos en la primera fila y luego la informacion correspondiente.<br />";
    txtBody += "<ol>";
    txtBody += "<li><b>Concepto:</b> Nombre del Concepto.</li>";
    txtBody += "<li><b>Proyecto:</b> Número del proyecto para el Concepto.</li>";
    txtBody += "<li><b>Valor:</b> Valor del Concepto.</li>";
    txtBody += "<li><b>Fecha:</b> Fecha del Concepto.</li>";
    txtBody += "</ol>";

    var objPopUp = new YAHOO.widget.Panel(
            "pop",
            {
                width: "500px",
                fixedcenter: true,
                close: true,
                draggable: true,
                modal: true,
                visible: true
            }
    );

    // Encabezado
    objPopUp.setHeader("Construya un archivo de texto plano con las siguientes columnas");

    // cuerpo del panel
    objPopUp.setBody(txtBody);

    // El objeto se despliega sobre el cuerpo del documento html
    objPopUp.render(document.body);
    objPopUp.show();

}

function plantillaModuloOperativoNomina( ) {

    var txtBody = "";

    txtBody += "Ingresar un archivo plano separado por tabulaciones con los siguientes títulos en la primera fila y luego la informacion correspondiente.<br />";
    txtBody += "<ol>";
    txtBody += "<li><b>Nombre:</b> Nombre del contratista.</li>";
    txtBody += "<li><b>Documento:</b> Documento del contratista.</li>";
    txtBody += "<li><b>Fecha Inicio:</b> Fecha en que se inicia el contrato. (yyyy-mm-dd)</li>";
    txtBody += "<li><b>Fecha Final:</b> Fecha en que se vence el contrato. (yyyy-mm-dd)</li>";
    txtBody += "<li><b>Valor Contrato:</b> Valor TOTAL del contrato.</li>";
    txtBody += "<li><b>Valor Mensual:</b> Valor MENSUAL del contrato.</li>";
    txtBody += "</ol>";

    var objPopUp = new YAHOO.widget.Panel(
            "pop",
            {
                width: "500px",
                fixedcenter: true,
                close: true,
                draggable: true,
                modal: true,
                visible: true
            }
    );

    // Encabezado
    objPopUp.setHeader("Construya un archivo de texto plano con las siguientes columnas");

    // cuerpo del panel
    objPopUp.setBody(txtBody);

    // El objeto se despliega sobre el cuerpo del documento html
    objPopUp.render(document.body);
    objPopUp.show();

}


function plantillaActoAdministrativo2(txtObjetoSelect) {

    var objSelect = YAHOO.util.Dom.get(txtObjetoSelect);

    var objPopUp = new YAHOO.widget.Panel(
            "pop",
            {
                width: "650px",
                fixedcenter: true,
                close: true,
                draggable: true,
                modal: true,
                visible: true
            }
    );

    var fncExito = function (objRespuesta) {
        objPopUp.setHeader("Instrucciones para la creación del archivo de carga");
        objPopUp.setBody(objRespuesta.responseText);
        objPopUp.render(document.body);
        objPopUp.show();
    }

    var fncFalla = function (objRespuesta) {
        objPopUp.setHeader("Error al abrir el documento");
        objPopUp.setBody(objRespuesta.status + ": " + objRespuesta.statusText);
        objPopUp.render(document.body);
        objPopUp.show();
    }

    var objRetorno = {
        success: fncExito,
        failure: fncFalla
    }

    YAHOO.util.Connect.asyncRequest(
            "POST",
            "./contenidos/actosAdministrativos/plantillaActoAdministrativo.php",
            objRetorno,
            "seqTipoActo=" + objSelect.options[ objSelect.selectedIndex ].value
            );

}

function plantillaCargueEstudioTecnicoUnidad(txtObjetoSelect) {

    var objSelect = YAHOO.util.Dom.get(txtObjetoSelect);

    var objPopUp = new YAHOO.widget.Panel(
            "pop",
            {
                width: "700px",
                fixedcenter: true,
                close: true,
                draggable: true,
                modal: true,
                visible: true
            }
    );

    var fncExito = function (objRespuesta) {
        objPopUp.setHeader("Carga de plantilla de estudios técnicos de unidades");
        objPopUp.setBody(objRespuesta.responseText);
        objPopUp.render(document.body);
        objPopUp.show();
    }

    var fncFalla = function (objRespuesta) {
        objPopUp.setHeader("Error al abrir el documento");
        objPopUp.setBody(objRespuesta.status + ": " + objRespuesta.statusText);
        objPopUp.render(document.body);
        objPopUp.show();
    }

    var objRetorno = {
        success: fncExito,
        failure: fncFalla
    }

    YAHOO.util.Connect.asyncRequest(
            "POST",
            "./contenidos/unidadProyecto/plantillaCargaEstudiosTecnicos.php",
            objRetorno,
            "seqTipoActo=1"
            );

}

function plantillaCargaCartaHabitabilidad(txtObjetoSelect) {

    var objSelect = YAHOO.util.Dom.get(txtObjetoSelect);

    var objPopUp = new YAHOO.widget.Panel(
            "pop",
            {
                width: "700px",
                fixedcenter: true,
                close: true,
                draggable: true,
                modal: true,
                visible: true
            }
    );

    var fncExito = function (objRespuesta) {
        objPopUp.setHeader("Carga de plantilla de estudios técnicos de unidades");
        objPopUp.setBody(objRespuesta.responseText);
        objPopUp.render(document.body);
        objPopUp.show();
    }

    var fncFalla = function (objRespuesta) {
        objPopUp.setHeader("Error al abrir el documento");
        objPopUp.setBody(objRespuesta.status + ": " + objRespuesta.statusText);
        objPopUp.render(document.body);
        objPopUp.show();
    }

    var objRetorno = {
        success: fncExito,
        failure: fncFalla
    }

    YAHOO.util.Connect.asyncRequest(
            "POST",
            "./contenidos/unidadProyecto/plantillaCargaCartaHabitabilidad.php",
            objRetorno,
            "seqTipoActo=1"
            );

}

function plantillaProyectoUnidadHabitacional( ) {

    var objPopUp = new YAHOO.widget.Panel(
            "pop",
            {
                height: "450px",
                width: "650px",
                fixedcenter: true,
                close: true,
                draggable: true,
                modal: true,
                visible: true
            }
    );

    var fncExito = function (objRespuesta) {
        objPopUp.setHeader("Consulta de proyecto y unidad habitacional");
        objPopUp.setBody(objRespuesta.responseText);
        objPopUp.render(document.body);
        objPopUp.show();
    }

    var fncFalla = function (objRespuesta) {
        objPopUp.setHeader("Error al abrir el documento");
        objPopUp.setBody(objRespuesta.status + ": " + objRespuesta.statusText);
        objPopUp.render(document.body);
        objPopUp.show();
    }

    var objRetorno = {
        success: fncExito,
        failure: fncFalla
    }

    YAHOO.util.Connect.asyncRequest(
            "POST",
            "./contenidos/actosAdministrativos/plantillaProyectoUnidadHabitacional.php",
            objRetorno
            );

}

function plantillaActoAdministrativo(idTipoActo) {

    var objTipoActo = YAHOO.util.Dom.get(idTipoActo);
    var seqTipoContrato;

    if (objTipoActo == null) {
        seqTipoContrato = idTipoActo;
    } else {
        seqTipoContrato = objTipoActo.options[ objTipoActo.selectedIndex ].value;
    }

    var txtBody = "<table cellspacing='1' cellpadding='1' border='0' width='100%'>";

    // resolucion de asignacion
    if (seqTipoContrato == 1) {
        txtBody += "<tr><td width='120px'><b>Documento</b></td><td>Numero de documento del posutlante principal</td></tr>";
    }

    // resolucion modificatoria
    if (seqTipoContrato == 2) {
        txtBody += "<tr><td width='120px'><b>Documento</b></td><td>Numero de documento del posutlante principal</td></tr>";
        txtBody += "<tr><td width='120px'><b>Campo</b></td><td>Nombre del campo que se ha modificado</td></tr>";
        txtBody += "<tr><td width='120px'><b>Incorrecto</b></td><td>Valor que tenia el formulario antes de la modificacion</td></tr>";
        txtBody += "<tr><td width='120px'><b>Correcto</b></td><td>Valor que tiene actualmente el formulario</td></tr>";
    }

    // resolucion de inhabilitados
    if (seqTipoContrato == 3) {
        txtBody += "<tr><td width='250px'><b>Secuencia de formulario</b></td><td>Identificador interno del formulario</td></tr>";
        txtBody += "<tr><td width='250px'><b>Modalidad</b></td><td>Modalidad del hogar</td></tr>";
        txtBody += "<tr><td width='250px'><b>Desplazado</b></td><td>Si para desplazado No para independientes</td></tr>";
        txtBody += "<tr><td width='250px'><b>Numero de Formulario</b></td><td>Numero del formulario por ejemplo 12-301</td></tr>";
        txtBody += "<tr><td width='250px'><b>Cedula Jefe de Hogar</b></td><td>Numero de documento del Jefe de Hogar</td></tr>";
        txtBody += "<tr><td width='250px'><b>Documento del Miembro de hogar</b></td><td>Numero de documento de quien tiene la inhabilidad</td></tr>";
        txtBody += "<tr><td width='250px'><b>Nombre del Miembro de Hogar</b></td><td>Nombre de la persona que tiene la inhabilidad</td></tr>";
        txtBody += "<tr><td width='250px'><b>Parentesco</b></td><td>Parentezdo de la persona que tiene la inhabilidad</td></tr>";
        txtBody += "<tr><td width='250px'><b>Texto de la Causa</b></td><td>Causa de la inhabilidad</td></tr>";
        txtBody += "<tr><td width='250px'><b>Fuente</b></td><td>Fuente de informacion, cuando no es externa colocar SDHT</td></tr>";
        txtBody += "<tr><td width='250px'><b>Titulo Detalle1</b></td><td>Nombe del Detalle de la inhabilidad 1</td></tr>";
        txtBody += "<tr><td width='250px'><b>Detalle1</b></td><td>Detalle de la inhabilidad 1</td></tr>";
        txtBody += "<tr><td width='250px'><b>Titulo Detalle 2</b></td><td>Nombe del Detalle de la inhabilidad 2</td></tr>";
        txtBody += "<tr><td width='250px'><b>Detalle2</b></td><td>Detalle de la inhabilidad 2</td></tr>";
        txtBody += "<tr><td width='250px'><b>Titulo Detalle 3</b></td><td>Nombe del Detalle de la inhabilidad 3</td></tr>";
        txtBody += "<tr><td width='250px'><b>Detalle3</b></td><td>Detalle de la inhabilidad 3</td></tr>";
        txtBody += "<tr><td width='250px'><b>Titulo Detalle 4</b></td><td>Nombe del Detalle de la inhabilidad 4</td></tr>";
        txtBody += "<tr><td width='250px'><b>Detalle4</b></td><td>Detalle de la inhabilidad 4</td></tr>";
        txtBody += "<tr><td width='250px'><b>Titulo Detalle 5</b></td><td>Nombe del Detalle de la inhabilidad 5</td></tr>";
        txtBody += "<tr><td width='250px'><b>Detalle5</b></td><td>Detalle de la inhabilidad 5</td></tr>";
    }

    // Recursos de reposicion
    if (seqTipoContrato == 4) {
        txtBody += "<tr><td width='120px'><b>Documento</b></td><td>Numero de documento del posutlante principal</td></tr>";
        txtBody += "<tr><td width='120px'><b>Estado</b></td><td>Resultado del recurso de reposicion</td></tr>";
    }

    // resolucion de no asignado
    if (seqTipoContrato == 5) {
        txtBody += "<tr><td width='120px'><b>Documento</b></td><td>Numero de documento del posutlante principal</td></tr>";
    }

    // resolucion de renuncia
    if (seqTipoContrato == 6) {
        txtBody += "<tr><td width='120px'><b>Documento</b></td><td>Numero de documento del posutlante principal</td></tr>";
    }

    // Notificacion
    if (seqTipoContrato == 7) {
        txtBody += "<tr><td width='120px'><b>Documento</b></td><td>Numero de documento del posutlante principal</td></tr>";
    }

    // Indexacion
    if (seqTipoContrato == 8) {
        txtBody += "<tr><td width='250px'><b>Documento</b></td><td>Numero de documento del posutlante principal</td></tr>";
        txtBody += "<tr><td width='250px'><b>No. Res. Asignación</b></td><td>Numero de resolución de asignación a indexar</td></tr>";
        txtBody += "<tr><td width='250px'><b>Fecha Res. Asignación</b></td><td>Fecha de la resolución de asignación a indexar</td></tr>";
        txtBody += "<tr><td width='250px'><b>Valor Indexación</b></td><td>Valor de la indexación</td></tr>";
    }

    // resolucion de perdida
    if (seqTipoContrato == 9) {
        txtBody += "<tr><td width='120px'><b>Documento</b></td><td>Numero de documento del postulante principal</td></tr>";
    }

    // resolucion de revocatoria
    if (seqTipoContrato == 10) {
        txtBody += "<tr><td width='120px'><b>Documento</b></td><td>Numero de documento del postulante principal</td></tr>";
    }

    txtBody += "</table>";

    var objPopUp = new YAHOO.widget.Panel(
            "pop",
            {
                width: "650px",
                fixedcenter: true,
                close: true,
                draggable: true,
                modal: true,
                visible: true
            }
    );

    // Encabezado
    objPopUp.setHeader("Construya un archivo de texto plano con las siguientes columnas");

    // cuerpo del panel
    objPopUp.setBody(txtBody);

    // El objeto se despliega sobre el cuerpo del documento html
    objPopUp.render(document.body);
    objPopUp.show();

}

function mostrarAyudaGeneralReporteador( ) {
    cargarContenido("resultado", "./contenidos/reportes/mostrarAyudaReporteador.php", "", true);
}

function mostrarAyudaGeneralReporteadorProyectos( ) {
    cargarContenido("resultado", "./contenidos/reportesProyectos/mostrarAyudaReporteador.php", "", true);
}

/**
 * POPUP PARA GENERAR VENTANAS EMERGENTES DE AYUDA
 * @author Bernardo Zerda Rodriguez
 * @param String txtTitulo     ==> Titulo de la ventana
 * @param String txtContenido  ==> Contenido en HTML de la ventana
 * @param String txtParametros ==> Ej: { width:"250px",fixedcenter:true,close:false,draggable:false,modal:true,visible:false }
 */
function popUpAyuda(txtTitulo, txtContenido) {

    // Instancia un objeto panel
    var objAyuda = new YAHOO.widget.Panel(
            "dlg",
            {
                width: '500px',
                fixedcenter: true,
                close: true,
                draggable: false,
                modal: true,
                visible: true
            }
    );

    // Encabezado
    objAyuda.setHeader(txtTitulo);

    // cuerpo del panel
    objAyuda.setBody("<div style='text-align:justify'>" + txtContenido + "</div>");

    // El objeto se despliega sobre el cuerpo del documento html
    objAyuda.render(document.body);

    // Muestra el objeto
    objAyuda.show();

}

/**
 * Filtro dependiendo el tipo de Acto Administrativo que se elija
 * 
 */
function filtarActosAdministrativos( ) {

    var numActo = document.getElementById('numActo').value;
    var seqTipoActo = document.getElementById('seqTipoActoBuscar').selectedIndex;
    seqTipoActo = document.getElementById('seqTipoActoBuscar').options[ seqTipoActo ].value;

    var txtParametros;

    txtParametros = "numActo=" + numActo
            + "&seqTipoActo=" + seqTipoActo;

    cargarContenido("listadoResoluciones", "./contenidos/asignacion/listadoResoluciones.php", txtParametros, true)
}

function asignarFormulariosAsignados( ) {
    someterFormulario('mensajes', 'frmAsignacionFormsUsuarios', './contenidos/crm/asignarFormsUsuarios.php', true, true);
}

function explode(delimiter, string, limit) {
    // http://kevin.vanzonneveld.net
    // +     original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +     improved by: kenneth
    // +     improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +     improved by: d3x
    // +     bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: explode(' ', 'Kevin van Zonneveld');
    // *     returns 1: {0: 'Kevin', 1: 'van', 2: 'Zonneveld'}
    // *     example 2: explode('=', 'a=bc=d', 2);
    // *     returns 2: ['a', 'bc=d']

    var emptyArray = {
        0: ''
    };

    // third argument is not required
    if (arguments.length < 2 ||
            typeof arguments[0] == 'undefined' ||
            typeof arguments[1] == 'undefined') {
        return null;
    }

    if (delimiter === '' ||
            delimiter === false ||
            delimiter === null) {
        return false;
    }

    if (typeof delimiter == 'function' ||
            typeof delimiter == 'object' ||
            typeof string == 'function' ||
            typeof string == 'object') {
        return emptyArray;
    }

    if (delimiter === true) {
        delimiter = '1';
    }

    if (!limit) {
        return string.toString().split(delimiter.toString());
    } else {
        // support for limit argument
        var splitted = string.toString().split(delimiter.toString());
        var partA = splitted.splice(0, limit - 1);
        var partB = splitted.join(delimiter.toString());
        partA.push(partB);
        return partA;
    }
}

function descargaHogaresTotal( ) {
    someterFormulario("mensajes", "frmAsignacionFormsUsuariosInformacion", "./contenidos/crm/reporteFormularioTutor.php", true, false);
}

function descargaHogaresTutor(o, objArbol) {

    var hiLit = objArbol.getNodesByProperty('highlightState', 1);
    if (YAHOO.lang.isNull(hiLit)) {
        alert("Por favor seleccione un tutor.");
    } else {
        for (var i = 0; i < hiLit.length; i++) {
            var idUsuario = hiLit[i].data.idUsuario;
            if (idUsuario != "undefined" && idUsuario != "") {
                break;
            }

        }
        someterFormulario("mensajes", "frmAsignacionFormsUsuariosInformacion", "./contenidos/crm/reporteFormularioTutor.php?seqTutor=" + idUsuario, true, false);
    }
}

function generarReporteInscritosPostulados( ) {
    someterFormulario("divTablasReportesInscritos", "frmReporteInscritosPostulados", "./contenidos/reportes/inscritosPostuladosGenerar.php", false, true);
}

/**
 * PARA CAMBIAR EL TIPO DE PROPIEDAD
 * PARA EL CAMPO DE BUSQUEDA DE OFERTA
 * @author Bernardo Zerda
 * @param Object Select objTipoPropiedad
 * @return Void
 * @version 1.0 Sep 2010
 */
function cambiarTipoPropiedad(objPropiedad) {

    var objOpcion = objPropiedad.options[ objPropiedad.selectedIndex ];
    var objEscritura = YAHOO.util.Dom.get("escritura");
    var objSentencia = YAHOO.util.Dom.get("sentencia");
    var objResolucion = YAHOO.util.Dom.get("resolucion");

    if (objOpcion.value == "escritura") {
        objEscritura.style.display = "";
    } else {
        objEscritura.style.display = "none";
    }

    if (objOpcion.value == "sentencia") {
        objSentencia.style.display = "";
    } else {
        objSentencia.style.display = "none";
    }

    if (objOpcion.value == "resolucion") {
        objResolucion.style.display = "";
    } else {
        objResolucion.style.display = "none";
    }

}

function reporteIndicadores(txtConsultaReporte, txtTipoReporte, txtColor) {
    var parametros;
    var bolCargar;

    if (txtConsultaReporte == "consulta") {
        bolCargar = true;
    } else {
        bolCargar = false;
    }

    parametros = "txtTipoReporte=" + txtTipoReporte +
            "&txtConsultaReporte=" + txtConsultaReporte;
    if (txtColor != "") {
        parametros += "&txtColor=" + txtColor
    }
    someterFormulario("divDataTableTutoresIndicadoresDesembolso", "frmSemaforos", "./contenidos/crm/dataTableIndicadores.php?" + parametros, true, bolCargar);
}

function reporteTotalHoySemanaDia(txtTipoReporte, txtEstado) {
    var seqUsuario = YAHOO.util.Dom.get("seqUsuario").value;
    var parametros;
    parametros = "txtTipoReporte=" + txtTipoReporte +
            "&txtEstado=" + txtEstado +
            "&seqUsuario=" + seqUsuario;
    cargarContenido("divDataTableTutoresIndicadoresDesembolso", "./contenidos/crm/dataTableIndicadoresDiaSemanaMes.php", parametros, true);
}

function reporteDiaSemanaMesRango(txtConsultaReporte, txtTipoReporte, txtForm) {
    var bolCargar;
    if (txtConsultaReporte == "consulta") {
        bolCargar = true;
    } else {
        bolCargar = false;
    }


    var parametros;
    parametros = "?txtConsultaReporte=" + txtConsultaReporte +
            "&txtTipoReporte=" + txtTipoReporte;

    someterFormulario("divDataTableTutoresIndicadoresDesembolso", txtForm, "./contenidos/crm/reporteDiaSemanaMesRango.php" + parametros, true, bolCargar);
}

function salvarConsignacion(idContenedor) {

    // variable de parametros a enviar al script
    var txtParametros = "";

    // funcion para filtrar los objetos que son recolectados por YAHOO.util.Dom.getElementsBy
    var fncSeleccionarCampos = function (objObtenido) {
        if (objObtenido.id != "") {
            return true;
        } else {
            return false;
        }
    }

    // Obtiene los input de la consignacion
    var arrInput = YAHOO.util.Dom.getElementsBy(
            fncSeleccionarCampos,
            "input",
            idContenedor
            );

    // Obtiene los select de la consignacion
    var arrSelect = YAHOO.util.Dom.getElementsBy(
            fncSeleccionarCampos,
            "select",
            idContenedor
            );

    // Organizando los datos input para enviarlos
    for (i = 0; i < arrInput.length; i++) {
        txtParametros = txtParametros + arrInput[ i ].id + "=" + arrInput[ i ].value + "&";
    }

    // Organizando los datos select para enviarlos
    for (i = 0; i < arrSelect.length; i++) {
        txtParametros = txtParametros + arrSelect[ i ].id + "=" + arrSelect[ i ].options[ arrSelect[ i ].selectedIndex ].value + "&";
    }

    // Datos adicionales para la consignacion
    var objFormulario = YAHOO.util.Dom.get('seqFormularioEditar');
    var objComentario = YAHOO.util.Dom.get('txtComentario');
    var objCedula = YAHOO.util.Dom.get('cedula');
    var objNombre = YAHOO.util.Dom.get('nombre');
    var objGestion = YAHOO.util.Dom.get('seqGestion');

    txtParametros = txtParametros + "seqFormulario=" + objFormulario.value + "&" +
            "txtComentario=" + objComentario.value + "&" +
            "cedula=" + objCedula.value + "&" +
            "nombre=" + objNombre.value + "&" +
            "seqGestion=" + objGestion.options[ objGestion.selectedIndex ].value;

    cargarContenido("mensajes", "./contenidos/desembolso/salvarConsignacion.php", txtParametros, true);

}

function cargarIndicadoresDiaSemanaMes(txtEstado) {

    var seqUsuario = YAHOO.util.Dom.get("seqUsuario");
    var parametros;
    parametros = "txtEstado=" + txtEstado +
            "&seqUsuario=" + seqUsuario.value;

    cargarContenido("divRangosEstados", "./contenidos/crm/cargarIndicadoresDiaSemanaMes.php", parametros, true);
}

/**
 * Carga los indicadores dependiendo del grupo que se seleccione
 * @author Diego Gaitan
 * @param Int seqGrupo
 * @return void
 * @version 1.0 Ene 2011
 */
function cargarIndicador(seqGrupo) {

    var parametros = "seqGrupo=" + seqGrupo;
    cargarContenido("contenido", "./contenidos/crm/indicadores.php", parametros, true)

}

/**
 * MUESTRA LA CUENTA DE LOS TUTORES PARA SUS INDICADORES
 * @author Diego Gaitan
 * @param Int seqUsuario
 * @return void
 * @version 1.0 Nov 2010
 */
function cargaIndicadoresTutorDesembolso( ) {

    var parametros;
    var objSeqUsuario = YAHOO.util.Dom.get("seqUsuario");

    var seqUsuario = objSeqUsuario.options[ objSeqUsuario.selectedIndex ].value;
    var txtUsuario = objSeqUsuario.options[ objSeqUsuario.selectedIndex ].text;
    parametros = "seqUsuario=" + seqUsuario;

    YAHOO.util.Dom.get("txtNombreTutorDesembolso").innerHTML = "";
    if (seqUsuario == 0) {
        YAHOO.util.Dom.get("txtNombreTutorDesembolso").innerHTML = "TODOS LOS TUTORES";
    } else {
        YAHOO.util.Dom.get("txtNombreTutorDesembolso").innerHTML = "Tutor: " + txtUsuario;
    }

    cargarContenido("divIndicadoresTutorDesembolso",
            "./contenidos/crm/indicadoresTutoresDesembolso.php",
            parametros,
            true);
}

/**
 * MUESTRA LA AYUDA PARA CARGAR 
 * LA PREVIABILIZACION DEL BANCO DE VIVIENDA
 * @author Bernardo Zerda
 */

function plantillaPreviabilizacion() {

    var txtEstilo1 = "style='padding-left:10px; font-weight:bold; border-bottom: 1px dotted #999999; vertical-align:top;'";
    var txtEstilo2 = "style='padding-left:10px; border-bottom: 1px dotted #999999; vertical-align:top;'";
    var txtEstilo3 = "style='padding-left:10px; border-bottom: 1px dotted #999999; vertical-align:top;'";

    var txtBody = "<table cellpadding='2' cellspacing='0' border='0' width='100%'>";
    txtBody += "<tr>";
    txtBody += "<td class='tituloTabla' width='150px'>Nombre</td>";
    txtBody += "<td class='tituloTabla'>Tipo Dato</td>";
    txtBody += "<td class='tituloTabla'>Valores</td>";
    txtBody += "</tr>";
    txtBody += "<tr>";
    txtBody += "<td " + txtEstilo1 + ">idVivienda</td>";
    txtBody += "<td " + txtEstilo2 + ">Número</td>";
    txtBody += "<td " + txtEstilo3 + ">&nbsp;</td>";
    txtBody += "</tr>";
    txtBody += "<tr>";
    txtBody += "<td " + txtEstilo1 + ">Estado Proceso</td>";
    txtBody += "<td " + txtEstilo2 + ">Número</td>";
    txtBody += "<td " + txtEstilo3 + ">";
    txtBody += "1.Inscrito<br>";
    txtBody += "2.Disponible<br>";
    txtBody += "3.No Disponible<br>";
    txtBody += "</td>";
    txtBody += "</tr>";
    txtBody += "<tr>";
    txtBody += "<td " + txtEstilo1 + ">Matricula Inmobiliaria</td>";
    txtBody += "<td " + txtEstilo2 + ">Cadena</td>";
    txtBody += "<td " + txtEstilo3 + ">&nbsp;</td>";
    txtBody += "</tr>";
    txtBody += "<tr>";
    txtBody += "<td " + txtEstilo1 + ">CHIP</td>";
    txtBody += "<td " + txtEstilo2 + ">Cadena</td>";
    txtBody += "<td " + txtEstilo3 + ">&nbsp;</td>";
    txtBody += "</tr>";
    txtBody += "<tr>";
    txtBody += "<td " + txtEstilo1 + ">Barrio Legalizado</td>";
    txtBody += "<td " + txtEstilo2 + ">Cadena</td>";
    txtBody += "<td " + txtEstilo3 + ">Si / No</td>";
    txtBody += "</tr>";
    txtBody += "<tr>";
    txtBody += "<td " + txtEstilo1 + ">Reserva Vial</td>";
    txtBody += "<td " + txtEstilo2 + ">Cadena</td>";
    txtBody += "<td " + txtEstilo3 + ">Si / No</td>";
    txtBody += "</tr>";
    txtBody += "<tr>";
    txtBody += "<td " + txtEstilo1 + ">Zona Riezgo</td>";
    txtBody += "<td " + txtEstilo2 + ">Cadena</td>";
    txtBody += "<td " + txtEstilo3 + ">Alta / Media / Baja / No</td>";
    txtBody += "</tr>";
    txtBody += "<tr>";
    txtBody += "<td " + txtEstilo1 + ">Zona Proteccion Ambiental</td>";
    txtBody += "<td " + txtEstilo2 + ">Cadena</td>";
    txtBody += "<td " + txtEstilo3 + ">Si / No</td>";
    txtBody += "</tr>";
    txtBody += "<tr>";
    txtBody += "<td " + txtEstilo1 + ">Remocion Masa</td>";
    txtBody += "<td " + txtEstilo2 + ">Cadena</td>";
    txtBody += "<td " + txtEstilo3 + ">Alta / Media / Baja / No</td>";
    txtBody += "</tr>";
    txtBody += "</table>";

    var objPopUp = new YAHOO.widget.Panel(
            "pop",
            {
                width: "430px",
                fixedcenter: true,
                close: true,
                draggable: true,
                modal: true,
                visible: true
            }
    );

    // Encabezado
    objPopUp.setHeader("Construya un archivo de texto plano con las siguientes columnas *");

    // cuerpo del panel
    objPopUp.setBody(txtBody);

    // Pie de pagina
    objPopUp.setFooter("* La Primera Linea del archivos son los titulos");

    // El objeto se despliega sobre el cuerpo del documento html
    objPopUp.render(document.body);
    objPopUp.show();

}

function pedirConfirmacionEjecutarNomina( ) {

    var txtMensaje = "<div style='text-align:left'>";
    txtMensaje += "<span class='msgOK'>Desea Ejecutar la Nómina?</span>";
    txtMensaje += "</div>";


    // COMPORTAMIENTO SI SE PRESIONA -- SI -- EN EL CUADRO
    var handleYes = function () {
        someterFormulario(
                'mensajes',
                'frmAgregarNomina',
                './contenidos/crm/salvarNomina.php',
                false,
                true
                );
        this.cancel();
    }

    // COMPORTAMIENTO SI SE PRESIONA -- NO -- EN EL CUADRO
    var handleNo = function () {
        document.getElementById("mensajes").innerHTML = "";
        this.cancel();
    }

    var objAtributos = {
        width: "300px",
        effect: {
            effect: YAHOO.widget.ContainerEffect.FADE,
            duration: 0.75
        },
        fixedcenter: true,
        visible: false,
        modal: true,
        draggable: true,
        close: false,
        text: txtMensaje,
        buttons: [
            {
                text: "Si",
                handler: handleYes
            },
            {
                text: "No",
                handler: handleNo,
                isDefault: true
            }
        ]
    }

    // INSTANCIA EL OBJETO DIALOGO
    var objDialogo = new YAHOO.widget.SimpleDialog("dlg", objAtributos);

    // Muestra el cuadro de dialogo
    objDialogo.render(document.body);
    objDialogo.show();


}


function pedirConfirmacionBorrarConcepto(seqConcepto) {

    var txtMensaje = "<div style='text-align:left'>";
    txtMensaje += "<span class='msgOK'>Desea Borrar el Concepto?</span>";
    txtMensaje += "</div>";


    // COMPORTAMIENTO SI SE PRESIONA -- SI -- EN EL CUADRO
    var handleYes = function () {
        cargarContenido(
                'mensajes',
                './contenidos/crm/borrarConcepto.php',
                'seqConcepto=' + seqConcepto,
                true
                );
        this.cancel();
    }

    // COMPORTAMIENTO SI SE PRESIONA -- NO -- EN EL CUADRO
    var handleNo = function () {
        document.getElementById("mensajes").innerHTML = "";
        this.cancel();
    }

    var objAtributos = {
        width: "300px",
        effect: {
            effect: YAHOO.widget.ContainerEffect.FADE,
            duration: 0.75
        },
        fixedcenter: true,
        visible: false,
        modal: true,
        draggable: true,
        close: false,
        text: txtMensaje,
        buttons: [
            {
                text: "Si",
                handler: handleYes
            },
            {
                text: "No",
                handler: handleNo,
                isDefault: true
            }
        ]
    }

    // INSTANCIA EL OBJETO DIALOGO
    var objDialogo = new YAHOO.widget.SimpleDialog("dlg", objAtributos);

    // Muestra el cuadro de dialogo
    objDialogo.render(document.body);
    objDialogo.show();

}

function generarDataTableVigencias(objDataTable, txtDiv, tituloVigencia) {

    var datos = objDataTable ['datos'];
    var titulos = objDataTable ['titulos'];

    var numRegistros = 20;
    var arrPaginacion = [10, 20];
    var numAlto = "147px";
    var numAncho = "240px";

    var Dom = YAHOO.util.Dom;

    var myDataSource = new YAHOO.util.DataSource(datos);
    myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
    myDataSource.responseSchema =
            {
                resultsList: "items",
                fields: titulos
            };

    var myColumnDefs = new Array();
    for (i = 0; i < titulos.length; i++) {
        myColumnDefs[i] = {
            key: titulos[i],
            sortable: true,
            resizeable: true
        };
    }
    var myRowFormatter = function (elTr, oRecord) {
        if (oRecord.getData(tituloVigencia) < 15) {
            Dom.addClass(elTr, 'vigenciaRojo');
        } else if (oRecord.getData(tituloVigencia) >= 15 && oRecord.getData(tituloVigencia) < 30) {
            Dom.addClass(elTr, 'vigenciaAmarillo');
        }
        return true;
    };

    var myConfigs = {
        width: numAncho,
        height: numAlto,
        formatRow: myRowFormatter
    }



    var myDataTable = new YAHOO.widget.ScrollingDataTable(
            txtDiv,
            myColumnDefs,
            myDataSource,
            myConfigs
            );

    return {
        oDS: myDataSource,
        oDT: myDataTable
    };

}

function generarGraficaSeriesIndicadorSolicitudDesembolso(objGrafica, txtTipoGrafica, txtTipoNumero, txtField, txtDivMostrar, bolMostrarSeries) {

    var prefijo = "";
    if (txtTipoNumero == "moneda") {
        prefijo = "$";
    }

    var formatoNumero = function (value) {
        return YAHOO.util.Number.format(value,
                {
                    prefix: prefijo,
                    thousandsSeparator: ","
                }
        );
    }

    var toolTipSeries = function (item, index, series)
    {
        var toolTipText = series.displayName + ", Mes: " + item.mes + ": ";
        toolTipText += "\n" + formatoNumero(item[series.yField]);
        return toolTipText;
    }

    var toolTipSeriesResolucion = function (item, index, series)
    {
        var toolTipText = series.displayName + ", Resolucion: " + item.resolucion + ": ";
        toolTipText += "\n" + formatoNumero(item[series.yField]);
        return toolTipText;
    }

    var toolTipColumnas = function (item, index, series)
    {
        var toolTipText = series.displayName + " " + item.ejex;
        toolTipText += "\n" + formatoNumero(item[series.yField]);
        return toolTipText;
    }

    var currencyAxis = new YAHOO.widget.NumericAxis();
    currencyAxis.labelFunction = formatoNumero;

    var nombre = objGrafica['nombre'];
    var datos = objGrafica['datos'];
    var ejes = objGrafica['ejes'];
    var seriesDef = objGrafica['series'];
    var nombreEjeX = objGrafica['nombreEjeX'];

    var categoryAxis = new YAHOO.widget.CategoryAxis();
    categoryAxis.title = nombreEjeX;

    var myDataSource = new YAHOO.util.DataSource(datos);
    myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
    myDataSource.responseSchema = {
        fields: ejes
    };

    if (txtDivMostrar != undefined) {
        nombre = txtDivMostrar;
    }

    switch (txtTipoGrafica) {

        case "columnas":

            var mychart = new YAHOO.widget.ColumnChart(nombre, myDataSource,
                    {
                        series: seriesDef,
                        xField: "ejex",
                        yAxis: currencyAxis,
                        dataTipFunction: toolTipColumnas
                    }
            );
            break;

        case "series":

            if (bolMostrarSeries === true) {
                mychartMostrar = new YAHOO.widget.LineChart(nombre, myDataSource,
                        {
                            series: seriesDef,
                            xField: "mes",
                            yAxis: currencyAxis,
                            xAxis: categoryAxis,
                            dataTipFunction: toolTipSeries,
                            style:
                                    {
                                        xAxis:
                                                {
                                                    labelRotation: -90
                                                },
                                        legend: {
                                            display: "bottom",
                                            font:
                                                    {
                                                        family: "Arial",
                                                        size: 10
                                                    }
                                        }
                                    }
                        }
                );
            } else {
                var mychart = new YAHOO.widget.LineChart(nombre, myDataSource,
                        {
                            series: seriesDef,
                            xField: "mes",
                            yAxis: currencyAxis,
                            xAxis: categoryAxis,
                            dataTipFunction: toolTipSeries,
                            style:
                                    {
                                        xAxis:
                                                {
                                                    labelRotation: -90
                                                },
                                        legend: {
                                            display: "bottom",
                                            font:
                                                    {
                                                        family: "Arial",
                                                        size: 10
                                                    }
                                        }
                                    }
                        }
                );
            }
            break;

        case "seriesResolucion":

            if (bolMostrarSeries === true) {
                mychartMostrar = new YAHOO.widget.LineChart(nombre, myDataSource,
                        {
                            series: seriesDef,
                            xField: "resolucion",
                            yAxis: currencyAxis,
                            xAxis: categoryAxis,
                            dataTipFunction: toolTipSeriesResolucion,
                            style:
                                    {
                                        xAxis:
                                                {
                                                    labelRotation: -90
                                                },
                                        legend: {
                                            display: "right",
                                            font:
                                                    {
                                                        family: "Arial",
                                                        size: 8
                                                    }
                                        }
                                    }
                        }
                );
            } else {
                var mychart = new YAHOO.widget.LineChart(nombre, myDataSource,
                        {
                            series: seriesDef,
                            xField: "resolucion",
                            yAxis: currencyAxis,
                            xAxis: categoryAxis,
                            dataTipFunction: toolTipSeriesResolucion,
                            style:
                                    {
                                        xAxis:
                                                {
                                                    labelRotation: -90
                                                },
                                        legend: {
                                            display: "right",
                                            font:
                                                    {
                                                        family: "Arial",
                                                        size: 8
                                                    }
                                        }
                                    }
                        }
                );
            }
            break;


    }


}

function verGrafica488(txtDivMostrar) {

    var txtMostrar = mostrarOcultar(txtDivMostrar);
    if (txtMostrar == "mostrar") {

        var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
        eval(txtDivGraficas.innerHTML);

        generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaTotalGiros488, "series", "moneda");
        generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaTotalHogares488, "series", "cifras");

    }

}

function verGrafica644(txtDivMostrar) {

    var txtMostrar = mostrarOcultar(txtDivMostrar);
    if (txtMostrar == "mostrar") {

        var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
        eval(txtDivGraficas.innerHTML);

        generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaTotalGiros644, "series", "moneda");
        generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaTotalHogares644, "series", "cifras");

    }

}

function verResoluciones488(txtDivMostrar) {

    var txtMostrar;
    var numRegistros = 6;
    var arrPaginacion = [6, 10, 20];
    var numAlto = "153px";
    var numAncho = "420px";

    var txtMostrar = mostrarOcultar(txtDivMostrar);
    if (txtMostrar == "mostrar") {

        var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
        eval(txtDivGraficas.innerHTML);


        generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaTotal488, "columnas");
        generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaCDPEjecutado488, "seriesResolucion", "moneda");


        var datos = objDataTableProyecto488 ['datos'];
        var titulos = objDataTableProyecto488 ['titulos'];
        var txtDiv = "txtDivRes488DataTable";

        mostrarDataTable(datos, titulos, txtDiv, numRegistros, arrPaginacion, numAlto, numAncho);

    }

}

function verResoluciones644(txtDivMostrar) {

    var txtMostrar;
    var numRegistros = 6;
    var arrPaginacion = [6, 10, 20];
    var numAlto = "153px";
    var numAncho = "420px";
    var txtMostrar = mostrarOcultar(txtDivMostrar);

    if (txtMostrar == "mostrar") {
        var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
        eval(txtDivGraficas.innerHTML);

        generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaTotal644, "columnas");
        generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaCDPEjecutado644, "seriesResolucion", "moneda", "resolucion");

        var datos = objDataTableProyecto644 ['datos'];
        var titulos = objDataTableProyecto644 ['titulos'];
        var txtDiv = "txtDivRes644DataTable";


        mostrarDataTable(datos, titulos, txtDiv, numRegistros, arrPaginacion, numAlto, numAncho);
    }

}

function verOperaciones488(txtDivMostrar) {

    var txtMostrar;
    var txtMostrar = mostrarOcultar(txtDivMostrar);

    if (txtMostrar == "mostrar") {

        var txtDivDataTable = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
        eval(txtDivDataTable.innerHTML);

        generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaOperaciones, "series", "moneda");
        generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaOperacionesPorContrato, "columnas", "moneda");
        generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaOperacionesPorContratoTotal, "columnas", "moneda");

    }

}

function verConceptos488(txtDivMostrar) {

    var txtMostrar;
    var numRegistros = 10;
    var arrPaginacion = [10, 20];
    var numAlto = "153px";
    var numAncho = "340px";

    var txtMostrar = mostrarOcultar(txtDivMostrar);
    if (txtMostrar == "mostrar") {

        var txtDivDataTable = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
        eval(txtDivDataTable.innerHTML);

        var datos = objDataTableConcepto488 ['datos'];
        var titulos = objDataTableConcepto488 ['titulos'];
        var txtDiv = "txtDivConcepto488DataTable";

        mostrarDataTable(datos, titulos, txtDiv, numRegistros, arrPaginacion, numAlto, numAncho);

    }

}

function verVigenciaOperaciones488(txtDivMostrar) {

    var txtMostrar = mostrarOcultar(txtDivMostrar);

    if (txtMostrar == "mostrar") {

        var txtDivDataTable = YAHOO.util.Dom.get("divTxtJSGraficasVigencia");
        eval(txtDivDataTable.innerHTML);


        generarDataTableVigencias(objDataTableNomina, "txtDivVigenciaNominaDataTable", "tiempoRestante");

        var datos = objDataTableNominaFinalizada ['datos'];
        var titulos = objDataTableNominaFinalizada ['titulos'];
        var txtDiv = "txtDivVigenciaNominaFinalizadaDataTable";

        var numRegistros = 10;
        var arrPaginacion = [10, 20];
        var numAlto = "147px";
        var numAncho = "240px";

        mostrarDataTable(datos, titulos, txtDiv, numRegistros, arrPaginacion, numAlto, numAncho);


    }
}

function verVigenciaResoluciones488(txtDivMostrar) {

    var txtMostrar = mostrarOcultar(txtDivMostrar);

    if (txtMostrar == "mostrar") {

        var txtDivDataTable = YAHOO.util.Dom.get("divTxtJSGraficasVigencia");
        eval(txtDivDataTable.innerHTML);

        generarDataTableVigencias(objDataTableVigenciaResolucion488, "txtDivVigenciaResolucion488DataTable", "Falta");

    }

}

function verVigenciaResoluciones644(txtDivMostrar) {

    var txtMostrar = mostrarOcultar(txtDivMostrar);

    if (txtMostrar == "mostrar") {

        var txtDivDataTable = YAHOO.util.Dom.get("divTxtJSGraficasVigencia");
        eval(txtDivDataTable.innerHTML);

        generarDataTableVigencias(objDataTableVigenciaResolucion644, "txtDivVigenciaResolucion644DataTable", "Falta");

    }

}

function verGraficasTotalControlPresupuestal(txtDivMostrar) {

    var txtMostrar = mostrarOcultar(txtDivMostrar);

    if (txtMostrar == "mostrar") {

        var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
        eval(txtDivGraficas.innerHTML);

        generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaTotalGirosTODO, "series", "moneda");
        generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaTotalHogaresTODO, "series", "cifras");
        generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaResumen, "series", "cifras");


    }
}

function verConceptos644(txtDivMostrar) {

    var txtMostrar;
    var numRegistros = 10;
    var arrPaginacion = [10, 20];
    var numAlto = "153px";
    var numAncho = "340px";
    var txtMostrar = mostrarOcultar(txtDivMostrar);

    if (txtMostrar == "mostrar") {
        var txtDivDataTable = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
        eval(txtDivDataTable.innerHTML);

        var datos = objDataTableConcepto644 ['datos'];
        var titulos = objDataTableConcepto644 ['titulos'];
        var txtDiv = "txtDivConcepto644DataTable";


        mostrarDataTable(datos, titulos, txtDiv, numRegistros, arrPaginacion, numAlto, numAncho);
    }

}

function mostrarDataTable(datos, titulos, txtDiv, numRegistros, arrPaginacion, numAlto, numAncho) {

    var myDataSource = new YAHOO.util.DataSource(datos);
    myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
    myDataSource.responseSchema =
            {
                resultsList: "items",
                fields: titulos
            };

    var myColumnDefs = new Array();
    for (i = 0; i < titulos.length; i++) {
        myColumnDefs[i] = {
            key: titulos[i],
            sortable: true,
            resizeable: true
        };
    }

    var myConfigs = {
        width: numAncho,
        height: numAlto,
        paginator: new YAHOO.widget.Paginator({
            rowsPerPage: numRegistros,
            // template: YAHOO.widget.Paginator.TEMPLATE_ROWS_PER_PAGE,
            // rowsPerPageOptions: arrPaginacion,
            // pageLinks: 5 ,
            pageReportTemplate: "Pagina {currentPage} de {totalPages}",
            template: "{PreviousPageLink}{NextPageLink}",
            previousPageLinkLabel: "anterior",
            nextPageLinkLabel: "siguiente"
        })
    }

    var myDataTable = new YAHOO.widget.ScrollingDataTable(
            txtDiv,
            myColumnDefs,
            myDataSource,
            myConfigs
            );

    return {
        oDS: myDataSource,
        oDT: myDataTable
    };

}

function graficaPie(nombre, datos) {


    var opinionData = new YAHOO.util.DataSource(datos);
    opinionData.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
    opinionData.responseSchema = {
        fields: ["ejeX", "conteo"]
    };


    var mychart = new YAHOO.widget.PieChart(nombre, opinionData,
            {
                categoryField: "ejeX",
                dataField: "conteo",
                //only needed for flash player express install
                expressInstall: "librerias/yui/assets/expressinstall.swf",
                style:
                        {
                            padding: 20,
                            legend:
                                    {
                                        display: "right",
                                        padding: 10,
                                        spacing: 5,
                                        font:
                                                {
                                                    family: "Arial",
                                                    size: 13
                                                }
                                    }
                        }
            }
    );

}

function graficaColumna(nombre, ejes, datos) {

    var myDataSource = new YAHOO.util.DataSource(datos);
    myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
    myDataSource.responseSchema =
            {
                fields: ejes
            };

    var seriesDef = new Array();

    for (i = 1; i < ejes.length; i++) {
        seriesDef[i - 1] = {
            displayName: ejes[i],
            yField: ejes[i]
        };
    }

    var getDataTipText = function (item, index, series, axisField)
    {
        var toolTipText = dar_formato(item[series[axisField]]);
        toolTipText += "\n" + series.displayName + " de " + item.ejeX;

        return toolTipText;
    }


    var getYAxisDataTipText = function (item, index, series)
    {
        return getDataTipText(item, index, series, "yField");
    }

    var columnChart = new YAHOO.widget.ColumnChart(nombre, myDataSource,
            {
                series: seriesDef,
                xField: "ejeX",
                dataTipFunction: getYAxisDataTipText,
                //only needed for flash player express install
                expressInstall: "librerias/yui/assets/expressinstall.swf"

            });

}

function graficaBar(nombre, ejes, datos) {
    //Create Bar Chart

    var myDataSource = new YAHOO.util.DataSource(datos);
    myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
    myDataSource.responseSchema =
            {
                fields: ejes
            };

    var seriesDef = new Array();

    for (i = 1; i < ejes.length; i++) {
        seriesDef[i - 1] = {
            displayName: ejes[i],
            xField: ejes[i]
        };
    }

    var getDataTipText = function (item, index, series, axisField)
    {
        var toolTipText = dar_formato(item[series[axisField]]);
        toolTipText += "\n" + series.displayName + " de " + item.ejeX;

        return toolTipText;
    }

    var getXAxisDataTipText = function (item, index, series)
    {
        return getDataTipText(item, index, series, "xField");
    }

    var barChart = new YAHOO.widget.BarChart(nombre, myDataSource,
            {
                series: seriesDef,
                yField: "ejeX",
                dataTipFunction: getXAxisDataTipText

            });

}

function graficasImprimirReportes() {

    YAHOO.widget.Chart.SWFURL = "../../librerias/yui/charts/assets/charts.swf";
    var objCodigoGraficas = YAHOO.util.Dom.get("objGraficas");
    eval(objCodigoGraficas.innerHTML);

    for (txtGrafica in objGraficas) {
        var objDatosGraficas = objGraficas[txtGrafica];

        var tipo = objDatosGraficas['tipo'];
        var nombre = objDatosGraficas['nombre'];
        var datos = objDatosGraficas['datos'];
        var ejes = objDatosGraficas['ejes'];

        switch (tipo) {

            case 'columna':
                graficaColumna(nombre, ejes, datos);
                break;

            case 'bar':
                graficaBar(nombre, ejes, datos);
                break;

            case 'pie':
                graficaPie(nombre, datos);
                break;

        }
    }

}

function graficasTablas() {

    var objCodigoGraficas = YAHOO.util.Dom.get("objGraficas");
    eval(objCodigoGraficas.innerHTML);

    for (txtGrafica in objGraficas) {
        var objDatosGraficas = objGraficas[txtGrafica];

        var nombre = objDatosGraficas['nombre'];
        var datos = objDatosGraficas['datos'];
        var ejes = objDatosGraficas['ejes'];

        var myDataSource = new YAHOO.util.DataSource(datos);
        myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
        myDataSource.responseSchema =
                {
                    fields: ejes
                };

        var myColumnDefs = new Array();
        myColumnDefs[0] = {
            key: ejes[0],
            sortable: false,
            resizeable: false
        };

        for (i = 1; i < ejes.length; i++) {
            myColumnDefs[i] = {
                key: ejes[i],
                formatter: YAHOO.widget.DataTable.formatNumber,
                sortable: false,
                resizeable: false
            };
        }


        var myDataTable = new YAHOO.widget.DataTable(
                nombre + "_tabla",
                myColumnDefs,
                myDataSource, {
                }
        );

    }

}

function agrandarIndicadorResoluciones488( ) {

    var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
    YAHOO.util.Dom.get("divCheckGraficasMostrarSeries").innerHTML = "";
    eval(txtDivGraficas.innerHTML);

    var datos = objDataTableProyecto488 ['datos'];
    var titulos = objDataTableProyecto488 ['titulos'];
    var txtDiv = "divAgrandarIndicador";

    mostrarDataTable(datos, titulos, txtDiv, 15, '', '', '770px');
    YAHOO.util.Dom.setStyle(txtDiv, 'height', '330px');

}

function agrandarIndicadorResoluciones644( ) {

    var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
    YAHOO.util.Dom.get("divCheckGraficasMostrarSeries").innerHTML = "";
    eval(txtDivGraficas.innerHTML);

    var datos = objDataTableProyecto644 ['datos'];
    var titulos = objDataTableProyecto644 ['titulos'];
    var txtDiv = "divAgrandarIndicador";

    mostrarDataTable(datos, titulos, txtDiv, 15, '', '', '770px');
    YAHOO.util.Dom.setStyle(txtDiv, 'height', '330px');

}

function agrandarIndicadorResolucionesTotales488( ) {

    var txtDiv = "divAgrandarIndicador";
    var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
    YAHOO.util.Dom.get("divCheckGraficasMostrarSeries").innerHTML = "";
    eval(txtDivGraficas.innerHTML);

    generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaTotal488, "columnas", '', '', txtDiv);
    YAHOO.util.Dom.setStyle(txtDiv, 'height', '330px');

}

function agrandarIndicadorResolucionesTotales644( ) {

    var txtDiv = "divAgrandarIndicador";
    var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
    YAHOO.util.Dom.get("divCheckGraficasMostrarSeries").innerHTML = "";
    eval(txtDivGraficas.innerHTML);

    generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaTotal644, "columnas", '', '', txtDiv);
    YAHOO.util.Dom.setStyle(txtDiv, 'height', '330px');

}

function agrandarIndicadorResolucionesCDPEjecutado488(  ) {

    var txtDiv = "divAgrandarIndicador";
    var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
    YAHOO.util.Dom.get("divCheckGraficasMostrarSeries").innerHTML = "";
    eval(txtDivGraficas.innerHTML);

    generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaCDPEjecutado488, "seriesResolucion", "moneda", "resolucion", txtDiv, true);
    mostrarSeriesGrafica(objGraficaGraficaCDPEjecutado488);
    YAHOO.util.Dom.setStyle(txtDiv, 'height', '330px');

}

function agrandarIndicadorResolucionesCDPEjecutado644(  ) {

    var txtDiv = "divAgrandarIndicador";
    var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
    YAHOO.util.Dom.get("divCheckGraficasMostrarSeries").innerHTML = "";
    eval(txtDivGraficas.innerHTML);

    generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaCDPEjecutado644, "seriesResolucion", "moneda", "resolucion", txtDiv, true);
    mostrarSeriesGrafica(objGraficaGraficaCDPEjecutado644);
    YAHOO.util.Dom.setStyle(txtDiv, 'height', '330px');

}

function agrandarResumenIndicador(  ) {

    var txtDiv = "divAgrandarIndicador";
    var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
    YAHOO.util.Dom.get("divCheckGraficasMostrarSeries").innerHTML = "";
    eval(txtDivGraficas.innerHTML);

    generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaResumen, "series", "cifras", "", txtDiv, true);
    mostrarSeriesGrafica(objGraficaGraficaResumen);
    YAHOO.util.Dom.setStyle(txtDiv, 'height', '440px');

}

function agrandarCantidadHogaresTotales(  ) {

    var txtDiv = "divAgrandarIndicador";
    var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
    YAHOO.util.Dom.get("divCheckGraficasMostrarSeries").innerHTML = "";
    eval(txtDivGraficas.innerHTML);

    generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaTotalHogaresTODO, "series", "cifras", "", txtDiv, true);
    mostrarSeriesGrafica(objGraficaGraficaTotalHogaresTODO);
    YAHOO.util.Dom.setStyle(txtDiv, 'height', '440px');

}

function agrandarMontoHogaresTotales(  ) {

    var txtDiv = "divAgrandarIndicador";
    var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
    YAHOO.util.Dom.get("divCheckGraficasMostrarSeries").innerHTML = "";
    eval(txtDivGraficas.innerHTML);

    generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaTotalGirosTODO, "series", "moneda", "", txtDiv, true);
    mostrarSeriesGrafica(objGraficaGraficaTotalGirosTODO);
    YAHOO.util.Dom.setStyle(txtDiv, 'height', '440px');

}

function agrandarIndicadorPagoNominaMensual(  ) {

    var txtDiv = "divAgrandarIndicador";
    var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
    YAHOO.util.Dom.get("divCheckGraficasMostrarSeries").innerHTML = "";
    eval(txtDivGraficas.innerHTML);

    generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaOperaciones, "series", "moneda", "", txtDiv, true);
    mostrarSeriesGrafica(objGraficaGraficaOperaciones);
    YAHOO.util.Dom.setStyle(txtDiv, 'height', '440px');

}

function agrandarIndicadorPagoNominaContrato(  ) {

    var txtDiv = "divAgrandarIndicador";
    var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
    YAHOO.util.Dom.get("divCheckGraficasMostrarSeries").innerHTML = "";
    eval(txtDivGraficas.innerHTML);

    generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaOperacionesPorContrato, "columnas", "moneda", "", txtDiv);
    YAHOO.util.Dom.setStyle(txtDiv, 'height', '330px');

}

function agrandarIndicadorPagoNominaTotal(  ) {

    var txtDiv = "divAgrandarIndicador";
    var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
    YAHOO.util.Dom.get("divCheckGraficasMostrarSeries").innerHTML = "";
    eval(txtDivGraficas.innerHTML);

    generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaOperacionesPorContratoTotal, "columnas", "moneda", "", txtDiv);
    YAHOO.util.Dom.setStyle(txtDiv, 'height', '330px');

}

function agrandarMontoDesembolso488(  ) {

    var txtDiv = "divAgrandarIndicador";
    var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
    YAHOO.util.Dom.get("divCheckGraficasMostrarSeries").innerHTML = "";
    eval(txtDivGraficas.innerHTML);

    generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaTotalGiros488, "series", "moneda", "", txtDiv, true);
    mostrarSeriesGrafica(objGraficaGraficaTotalGiros488);
    YAHOO.util.Dom.setStyle(txtDiv, 'height', '440px');

}

function agrandarMontoDesembolso644(  ) {

    var txtDiv = "divAgrandarIndicador";
    var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
    YAHOO.util.Dom.get("divCheckGraficasMostrarSeries").innerHTML = "";
    eval(txtDivGraficas.innerHTML);

    generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaTotalGiros644, "series", "moneda", "", txtDiv, true);
    mostrarSeriesGrafica(objGraficaGraficaTotalGiros644);
    YAHOO.util.Dom.setStyle(txtDiv, 'height', '440px');

}

function agrandarCantidadHogares488(  ) {

    var txtDiv = "divAgrandarIndicador";
    var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
    YAHOO.util.Dom.get("divCheckGraficasMostrarSeries").innerHTML = "";
    eval(txtDivGraficas.innerHTML);

    generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaTotalHogares488, "series", "cifras", "", txtDiv, true);
    mostrarSeriesGrafica(objGraficaGraficaTotalHogares488);
    YAHOO.util.Dom.setStyle(txtDiv, 'height', '440px');

}

function agrandarCantidadHogares644(  ) {

    var txtDiv = "divAgrandarIndicador";
    var txtDivGraficas = YAHOO.util.Dom.get("divTxtJSGraficasControlPresupuestal");
    YAHOO.util.Dom.get("divCheckGraficasMostrarSeries").innerHTML = "";

    eval(txtDivGraficas.innerHTML);

    generarGraficaSeriesIndicadorSolicitudDesembolso(objGraficaGraficaTotalHogares644, "series", "cifras", "", txtDiv, true);
    mostrarSeriesGrafica(objGraficaGraficaTotalHogares644);
    YAHOO.util.Dom.setStyle(txtDiv, 'height', '440px');

}

function mostrarSeriesGrafica(objGrafica) {
    var nombre = objGrafica['nombre'];
    var series = objGrafica['series'];
    var arrNombresSeries = Array( );
    var i = "";

    for (i = 0; i < series.length; i++) {
        arrNombresSeries[ i ] = series[ i ][ "displayName" ];
    }

    cargarContenido(
            "divCheckGraficasMostrarSeries",
            "./contenidos/crm/crearCheckGraficasMostrarSeries.php",
            "nombre=" + nombre +
            "&cuentaSeries=" + series.length +
            "&nombreSeries=" + arrNombresSeries,
            true
            );
}

function filtarActosAdministrativosNotificacion( ) {

    var seqTipoActo = YAHOO.util.Dom.get('seqTipoActo').value;
    var txtParametros;

    // Numero Notificacion
    YAHOO.util.Dom.get('caracteristica[20]').value = "";
    // Fecha Notificacion
    YAHOO.util.Dom.get('caracteristica[21]').value = "";

    txtParametros = "seqTipoActo=" + seqTipoActo;
    cargarContenido("listadoActosAdministrativos", "./contenidos/asignacion/listadoResolucionesNotificacion.php", txtParametros, true);

}

function asignarActoAdministrativoNotificacion(  ) {

    var txtActoAdministrativo = YAHOO.util.Dom.get('txtActoAdministrativoNotificacion').value;
    var arrActoAdministrativo = txtActoAdministrativo.split("/");

    var numActoAdministrativo = arrActoAdministrativo[ 0 ];
    var fchActoAdministrativo = arrActoAdministrativo[ 1 ];

    // Numero Notificacion
    YAHOO.util.Dom.get('caracteristica[20]').value = numActoAdministrativo
    // Fecha Notificacion
    YAHOO.util.Dom.get('caracteristica[21]').value = fchActoAdministrativo;
    ;

}


function agendas() {

    var objFecha = new Date;

    // Configuracion del navegador
    // para ir rapidamente a diferentes fechas
    var navConfig = {
        strings: {
            month: "Seleccione Mes",
            year: "Digite AÃ±o",
            submit: "OK",
            cancel: "Cancelar",
            invalidYear: "Ingrese un aÃ±o valido"
        },
        monthFormat: YAHOO.widget.Calendar.LONG,
        initialFocus: "year"
    };

    // Objeto de configuracion del calendario
    var objConfiguracion = {
        MULTI_SELECT: false,
        LOCALE_WEEKDAYS: "short",
        MONTHS_LONG: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        WEEKDAYS_SHORT: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        navigator: navConfig
    };

    // Funcion que se ejecuta cuando una fecha del calendario es seleccionada
    var fncSelect = function (type, args, obj) {

        var numDia = (86400 * 1000); // Milisegundos en el dia

        // Obtiene la fecha seleccionada
        var fchSeleccionada = new Date;
        fchSeleccionada = obj.getSelectedDates();

        // regresa al dia cero
        var numPrimerDia = fchSeleccionada[ 0 ].getTime() - (fchSeleccionada[ 0 ].getDay() * numDia);

        // fecha de ese dia cero
        var fchPrimerDia = new Date;
        fchPrimerDia.setTime(numPrimerDia);

        //avanza hasta el ultimo dia
        var numUltimoDia = fchSeleccionada[ 0 ].getTime() + ((6 - fchSeleccionada[ 0 ].getDay()) * numDia);

        // fecha de ese ultimo dia
        var fchUltimoDia = new Date;
        fchUltimoDia.setTime(numUltimoDia);

        // Quita los dias previamente marcados
        objCalendario.removeRenderers();

        // Marca los dias de la semana seleccionada
        objCalendario.addRenderer((fchPrimerDia.getMonth() + 1) + "/" + fchPrimerDia.getDate() + "/" + fchPrimerDia.getFullYear() + "-" + (fchUltimoDia.getMonth() + 1) + "/" + fchUltimoDia.getDate() + "/" + fchUltimoDia.getFullYear(), objCalendario.renderCellStyleHighlight2);

        // Guarda las paginas que se estan mostrando en el aplicativo
        objCalendario.desde = (fchPrimerDia.getMonth() + 1) + "/" + fchPrimerDia.getFullYear();
        objCalendario.hasta = (fchUltimoDia.getMonth() + 1) + "/" + fchUltimoDia.getFullYear();

        // Coloca la pagina que correspondeal calendario
        if (typeof (objCalendario.desde) != "undefined" && typeof (objCalendario.hasta) != "undefined") {
            if (objCalendario.desde != objCalendario.hasta) {
                objCalendario.cfg.setProperty("pagedate", (fchPrimerDia.getMonth() + 1) + "/" + fchPrimerDia.getFullYear());
            }
        }

        // Despliega la actualizacion del calendario
        objCalendario.render();

        var objTutor = YAHOO.util.Dom.get("tutor");

        var txtParametros = "desde=" + fchPrimerDia.getFullYear() + "-" + (fchPrimerDia.getMonth() + 1) + "-" + fchPrimerDia.getDate() +
                "&hasta=" + fchUltimoDia.getFullYear() + "-" + (fchUltimoDia.getMonth() + 1) + "-" + fchUltimoDia.getDate() +
                "&tutor=" + objTutor.options[ objTutor.selectedIndex ].value;

        cargarContenido("programacion", "./contenidos/agenda/programacion.php", txtParametros, true);

    }

    // Instancia el calendario
    var objCalendario = new YAHOO.widget.CalendarGroup("agenda", "calendario", objConfiguracion);
    objCalendario.selectEvent.subscribe(fncSelect, objCalendario, true);
    objCalendario.select((objFecha.getMonth() + 1) + "/" + objFecha.getDate() + "/" + objFecha.getFullYear());
    objCalendario.render();

    eliminarObjeto("listenerAgendas");
    YAHOO.util.Event.onContentReady("listenerAgendas", agendas);

}

function animarListadoGrupos() {

    // objeto para animar
    var objArbolGrupos = YAHOO.util.Dom.get("arbolGrupos");
    objArbolGrupos.innerHTML = null;

    // determina el ancho final
    // si se colapsa o se expande
    var numAncho = 0;
    if (objArbolGrupos.style.width == "0px") {
        numAncho = 125;
    }

    // configuracion de las propiedades de animacion
    var objConfiguracion = {
        width: {
            to: numAncho
        }
    };

    // funcion que se ejecuta cuando se completa la animacion
    var objOnComplete = function () {
        if (numAncho == 125) {

            var objOk = function (o) {
                objArbolGrupos.innerHTML = o.responseText;
            }

            var objEr = function (o) {
                alert("Error " + o.status + ": " + o.statusText);
            }

            var objCB = {
                success: objOk,
                failure: objEr
            }

            var callObj = YAHOO.util.Connect.asyncRequest("POST", "./contenidos/indicadores/arbolGrupos.php", objCB, "");

        }
    }

    // objeto de animacion
    var objAnimacion = new YAHOO.util.Anim("arbolGrupos", objConfiguracion);
    objAnimacion.onComplete.subscribe(objOnComplete);
    objAnimacion.animate();

}

// Función que abre la pagina http://www.bogota.gov.co/mad/buscador.php en la cual se localiza 
// la direccion ingresada en el formulario inscripción
function mostrarMapa(inputDireccion) {
    var origen = document.getElementById(inputDireccion.form.id);
    var direccion = inputDireccion.value.trim();
    if (typeof (origen) != "undefined" && direccion.length > 3) {
        //window.open('http://www.bogota.gov.co/mad/buscador.php?direccion=' + direccion);
        window.open('http://mapacallejero.bogota.gov.co/mad/flash.php?direccion=' + direccion);
    }

//    var origen = document.getElementById('frmInscripcion').name;
//    if (origen == 'frmInscripcion') {
//        window.open('http://www.bogota.gov.co/mad/buscador.php?direccion=' + direccion);
//    }

}


/**
 * VERIFICA SI EL CAMPO TIENE SOPORTE PARA PLACEHOLDER
 * Y SI NO TIENE SOPORTE LO SIMULA
 * @author Jose Camilo Bernal
 * @author Jaison Ospina
 * @version 1.0 Jun 2013
 */

function ponerPlaceholder(idObjeto, txtMensaje) {
    if (YAHOO.util.Dom.inDocument(idObjeto) == true) {
        if (!soportaPlaceHolder()) {
            addicionarPlaceholder(idObjeto, txtMensaje);
        }
    }
}

/**
 * Funcion que evalua si el navegador acepta el atributo HTML5 placeholder
 * @author Jose Camilo Bernal
 * @author Jaison Ospina
 * @version 1.0 Jun 2013 
 */

function soportaPlaceHolder() {
    var input = document.createElement("input");
    return ('placeholder' in input);
}

/**
 * Funcion que simula un placeholder a un campo input
 * @author Jose Camilo Bernal
 * @author Jaison Ospina
 * @version 1.0 Jun 2013 
 */
function addicionarPlaceholder(idObjeto, txtMensaje) {

    var objContenedor = YAHOO.util.Dom.get(idObjeto);

    objContenedor.placeholder = txtMensaje;
    objContenedor.onfocus = function () {
        if (this.value == this.placeholder) {
            this.value = '';
            objContenedor.style.color = '#000000';
            objContenedor.style.backgroundColor = '#ADD8E6';
        }
    };

    objContenedor.onblur = function () {
        if (this.value.length == 0) {
            objContenedor.style.color = '#999999';
            objContenedor.style.backgroundColor = '#FFFFFF';
            this.value = this.placeholder;
        }
    };

    objContenedor.onblur();
}

// funcion que valida el formato del numero (digitos de 0-9 minimo 1 maximo 3 
// un separador decimal que puede aparecer 1 vez o no aparecer y digitos entre 0-9 maximo 2)
// evalua si el numero escrito esta en el rango de 0 a 100. 
// Si alguna de estas dos condiciones no se cumple el campo queda vacio.

function validarDecimalSisben(campo) {
    numero = campo.value;
    var exreg = /^([0-9]){1,3}[.]?[0-9]{0,2}$/;
    if (!numero.match(exreg)) {
        campo.value = "";
    } else if (!(numero > 0 && numero <= 100)) {
        campo.value = "";
    }
}

function tieneSisben(valor) {
    if (valor == 0) {
        document.frmInscripcion.numPuntajeSisben.value = "";
        document.frmInscripcion.numPuntajeSisben.readOnly = true;
    } else {
        document.frmInscripcion.numPuntajeSisben.readOnly = false;
        document.frmInscripcion.numPuntajeSisben.value = "";
        document.frmInscripcion.numPuntajeSisben.focus();
    }
}

/*
 funcion que muestra u oculta el selector de nombre del proyecto de la pestaña
 datos del inmueble proceso desembolso. (busquedaOferta.tpl)cuando se selecciona 
 alguno de los radiobuttons:
 1 - Bogotá Contraescritura
 2 - Fuera de Bogotá
 3 - Giro Anticipado
 4 - Proyecto Constructivo
 
 */
/*
 function MuestraOculta(id) {
 var prySolucion = document.getElementById('proyectoSolucion');
 if (id == 3) {
 prySolucion.style.display = "";
 } else {
 prySolucion.style.display = 'none';
 if (document.getElementById('seleccionado').value == 'selected') {
 document.getElementById('txtNombreVendedor').value = '';
 document.getElementById('txtDireccionInmueble').value = '';
 document.getElementById('txtBarrio').value = '';
 document.getElementById('txtEscritura').value = '';
 document.getElementById('fchEscritura').value = '';
 document.getElementById('numNotaria').value = '';
 //document.getElementById('txtCiudad').value = '';
 
 }
 }
 }
 */

/*
 *funcion que llena los campos con la informacion del proyecto seleccionado
 *en el selector de proyecto
 *
 
 function obtenerProyectoSolucion(objProyecto) {
 
 document.getElementById('seleccionado').value = 'selected';
 document.getElementById("NombreVendedor").innerHTML = "";
 document.getElementById("DireccionInmueble").innerHTML = "";
 document.getElementById("Barrio").innerHTML = "";
 
 cargarContenido(
 'NombreVendedor',
 './contenidos/subsidios/datosProyectoSolucion.php',
 'dato=NombreVendedor&proyecto=' + objProyecto.options[ objProyecto.selectedIndex ].value,
 true
 );
 
 cargarContenido(
 'DireccionInmueble',
 './contenidos/subsidios/datosProyectoSolucion.php',
 'dato=DireccionInmueble&proyecto=' + objProyecto.options[ objProyecto.selectedIndex ].value,
 true
 );
 
 cargarContenido(
 'Barrio',
 './contenidos/subsidios/datosProyectoSolucion.php',
 'dato=Barrio&proyecto=' + objProyecto.options[ objProyecto.selectedIndex ].value,
 true
 );
 
 cargarContenido(
 'Escritura_ga',
 './contenidos/subsidios/datosProyectoSolucion.php',
 'dato=Escritura&proyecto=' + objProyecto.options[ objProyecto.selectedIndex ].value,
 true
 );
 }
 **/

// Muestra el campo 'Tipo victima' si el campo 'victima' es 'SI' en Inscripción
/*function escondeTipoVictima() {
 if (document.getElementById("bolDesplazado").value == 1){
 document.getElementById("tipovictima").style.display = "table-row";
 } else {
 document.getElementById("tipovictima").style.display = "none";
 }
 }*/

function cambiaTipoSegunHecho() {

    var objTipoVictima = YAHOO.util.Dom.get("seqTipoVictima");
    var objDesplazado = YAHOO.util.Dom.get("bolDesplazado");

    if (objTipoVictima.options[ objTipoVictima.selectedIndex ].value == 2) {
        objDesplazado.selectedIndex = 1;
    } else {
        objDesplazado.selectedIndex = 0;
    }

}

// Muestra el campo 'Grupo LGTBI' si el campo 'LGTBI' es 'SI' en inscripcion
function cambiaLgtbi() {

    var objGrupoLgbti = YAHOO.util.Dom.get("seqGrupoLgtbi");
    var objLgbti = YAHOO.util.Dom.get("bolLgtb");

    if (objGrupoLgbti.options[ objGrupoLgbti.selectedIndex ].value == 0) {
        objLgbti.selectedIndex = 0;
    } else if (objGrupoLgbti.options[ objGrupoLgbti.selectedIndex ].value == "") {
        objLgbti.selectedIndex = 0;
    } else {
        objLgbti.selectedIndex = 1;
    }

}

// Muestra el campo 'Grupo LGTBI' si el campo 'LGTBI' es 'SI'
function escondeGrupoLgtbi() {
    if (document.getElementById("lgtb").value == 1) {
        document.getElementById("lineaLgtbi").style.display = "table-row";
        //document.getElementById("seqGrupoLgtbi").value = 1;
        //document.getElementById("seqGrupoLgtbi").value = document.getElementById("seqGrupoLgtbi").selectedIndex;;
    } else {
        document.getElementById("lineaLgtbi").style.display = "none";
        document.getElementById("seqGrupoLgtbi").value = 0;
    }
}

function cambiaBolLgtbiInscripcion() {
    //alert (document.getElementById("seqGrupoLgtbi").value);
    if (document.getElementById("seqGrupoLgtbi").value == 0) {
        document.getElementById("bolLgtb").value = 0;
    } else {
        document.getElementById("bolLgtb").value = 1;
    }
}

// Cambia a Lgtbi NO, si selecciona la opcion ninguno en Postulacion
function cambiaBolLgtbi() {
    //alert (document.getElementById("seqGrupoLgtbi").value);
    if (document.getElementById("seqGrupoLgtbi").value == 0) {
        document.getElementById("lgtb").value = 0;
    } else {
        document.getElementById("lgtb").value = 1;
    }
}
function preguntarAntes() {
    var x;
    //var est = document.getElementById("seqEstado").value
    var r = confirm("La información del nucleo familiar está completa?");
    if (r == true) {
        x = 6;
    } else {
        x = 6;
    }
    document.getElementById("seqEstadoProceso").value = x;
}

function formatoSeparadores(input) {
    try {
        var num = input.value.replace(/\./g, '');
        if (!isNaN(num)) {
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/, '');
            input.value = num;
        } else {
            alert('Solo se permiten numeros');
            input.value = input.value.replace(/[^\d\.]*/g, '');
            input.focus();
        }
    }catch(o){}
}

function espia() {
    var objMensajes = YAHOO.util.Dom.get("mensajes");
    var datosFormulario = $("#frmInscripcion").serialize();
    var ok = function (o) {
        objMensajes.innerHTML = o.responseText;
        return true;
    }
    var er = function (o) {
        return true;
    }
    var cb = {
        success: ok,
        failure: er
    }
    YAHOO.util.Connect.asyncRequest("POST", "./espia.php", cb, datosFormulario);
}

// /**
//  * Funcion que pregunta si desea adelantar el grupo familiar
//  * @author Jaison Ospina
//  * @author Jose Camilo Bernal
//  * @author Bernardo Zerad
//  * @version 1.0 Jul 2013
//  * @version 1.1 Ene 2014
//  */
// function preguntarGrupoFamiliar() {
//
//     var objFormulario = YAHOO.util.Dom.get("frmInscripcion");
//     var objEstadoProceso = YAHOO.util.Dom.get("seqEstadoProceso");
//
//     espia();
//
//     var txtMensaje = "<div style='text-align:left'>";
//     txtMensaje += "<span class='msgError' style='font-size:12px';>Desea Adelantar la actualizacón del Hogar?</span>";
//     txtMensaje += "</div>";
//
//     // COMPORTAMIENTO SI SE PRESIONA -- SI -- EN EL CUADRO
//     var handleYes = function () {
//         objEstadoProceso.value = 36; // nscripcion - Hogar Actualizado
//         pedirConfirmacion('mensajes', objFormulario, './contenidos/subsidios/pedirConfirmacion.php');
//         this.cancel();
//     }
//
//     // COMPORTAMIENTO SI SE PRESIONA -- NO -- EN EL CUADRO
//     var handleNo = function () {
//         pedirConfirmacion('mensajes', objFormulario, './contenidos/subsidios/pedirConfirmacion.php');
//         this.cancel();
//     }
//
//     var objAtributos = {
//         width: "330px",
//         effect: {
//             effect: YAHOO.widget.ContainerEffect.FADE,
//             duration: 0.75
//         },
//         fixedcenter: true,
//         zIndex: 1,
//         visible: false,
//         modal: true,
//         draggable: true,
//         close: false,
//         text: txtMensaje,
//         buttons: [
//             {
//                 text: "Actualizar",
//                 handler: handleYes
//             },
//             {
//                 text: "No Actualizar",
//                 handler: handleNo,
//                 isDefault: true
//             }
//         ]
//     }
//
//     // INSTANCIA EL OBJETO DIALOGO
//     var objDialogo1 = new YAHOO.widget.SimpleDialog("dlg", objAtributos);
//
//     // Muestra el cuadro de dialogo
//     objDialogo1.setHeader("Actualización del Hogar");
//     objDialogo1.render(document.body);
//     objDialogo1.show();
// }

/* *************************************************************************************
 * Funciones que contralan los combos dependientes de Ciudad, Barrio, Localidad y  UPZ *
 * *************************************************************************************/

//funcion que obtine la ciudad dependiendo de la localidad que escoja
function obtenerCiudad(objLocalidad) {
    upzFueradebogota(objLocalidad.options[ objLocalidad.selectedIndex ].value);
    document.getElementById("tdCiudad").innerHTML = "";
    cargarContenido(
            'tdCiudad',
            './contenidos/subsidios/localidadCiudad.php',
            'seqLocalidad=' + objLocalidad.options[ objLocalidad.selectedIndex ].value,
            true
            );

    YAHOO.util.Event.onContentReady(
            "seqCiudad",
            function () {
                document.getElementById("seqCiudad").focus();
            }
    );
}

function obtenerBarrio(objLocalidad) {
    document.getElementById("tdBarrio").innerHTML = "";
    cargarContenido(
            'tdBarrio',
            './contenidos/subsidios/localidadBarrio.php',
            'seqLocalidad=' + objLocalidad.options[ objLocalidad.selectedIndex ].value,
            true
            );

    YAHOO.util.Event.onContentReady(
            "seqBarrio",
            function () {
                document.getElementById("seqBarrio").focus();
            }
    );
}

function obtenerBarrioProyecto(objLocalidad) {
    document.getElementById("tdBarrio").innerHTML = "";
    cargarContenido(
            'tdBarrio',
            './contenidos/proyectos/localidadBarrio.php',
            'seqLocalidad=' + objLocalidad.options[ objLocalidad.selectedIndex ].value,
            true
            );

    YAHOO.util.Event.onContentReady(
            "seqBarrio",
            function () {
                document.getElementById("seqBarrio").focus();
            }
    );
}

function obtenerUpz(objBarrio) {
    if( document.getElementById("tdupz") != null ) {
        document.getElementById("tdupz").innerHTML = "";
        cargarContenido(
            'tdupz',
            './contenidos/subsidios/barrioUpz.php',
            'seqBarrio=' + objBarrio.options[objBarrio.selectedIndex].value,
            true
        );
        YAHOO.util.Event.onContentReady(
            "seqUpz",
            function () {
                document.getElementById("seqBarrio").focus();
            }
        );
    }
}

function cambiarCiudad(objCiudad) {
    cargarContenido('tdlocalidad', './contenidos/subsidios/cambiarLocalidad.php', 'ciudad=' + objCiudad.options[ objCiudad.selectedIndex ].value, true);
    YAHOO.util.Event.onContentReady(
            "seqLocalidad",
            function () {
                var objLocalidad = YAHOO.util.Dom.get("seqLocalidad");
                cargarContenido(
                        'tdBarrio',
                        './contenidos/subsidios/localidadBarrio.php',
                        'seqLocalidad=' + objLocalidad.options[ objLocalidad.selectedIndex ].value,
                        true
                        );
                document.getElementById("seqLocalidad").focus();
            }
    );
}


function upzFueradebogota(localidad) {
    var lalocalidad = localidad;
    if (lalocalidad == 22) {
        document.getElementById("tdupz").innerHTML = "";
        cargarContenido(
                'tdupz',
                './contenidos/subsidios/barrioUpz.php',
                'seqBarrio=' + 1144,
                true
                );
        YAHOO.util.Event.onContentReady(
                "seqBarrio",
                function () {
                    document.getElementById("seqBarrio").focus();
                }
        );

    }
}
;

function obtenerBarrioPostulacion(Localidad) {
    //alert (Localidad);

    document.getElementById("tdBarrio").innerHTML = "";
    cargarContenido(
            'tdBarrio',
            './contenidos/subsidios/localidadBarrio.php',
            'seqLocalidad=' + Localidad.options[ Localidad.selectedIndex ].value,
            true
            );

    YAHOO.util.Event.onContentReady(
            "seqBarrio",
            function () {
                document.getElementById("seqBarrio").focus();
            }
    );
}
/******* FIN FUNCIONES COMBOS DEPENDIENTES **********************/

/**
 * CARGA LAS PANTALLAS DE PLANTILLAS 
 * DE LA PANTALLA DE CASA EN MANO
 * @param string txtArchivo
 * @param string txtParametros
 * @returns void
 */

function cambioCEM(txtArchivo, txtParametros) {
    if (document.getElementById("bolVisita")) {
        if (document.getElementById("bolVisita").checked) {
            var visita = 1;
        } else {
            var visita = 0;
        }
    }
    var objRegresar = YAHOO.util.Dom.get('regresar');
    var objControles = YAHOO.util.Dom.get('controles');

    if (objRegresar.hidden === true) {
        objRegresar.hidden = false;
    } else {
        objRegresar.hidden = true;
    }

    if (objControles.hidden === true) {
        objControles.hidden = false;
    } else {
        objControles.hidden = true;
    }
    txtParametros += "&bolVisita=" + visita;
    cargarContenido('cem', txtArchivo, txtParametros, true);

}

function seleccionarCheck(idFormulario, idCheck) {
    var objFormulario = YAHOO.util.Dom.get(idFormulario);
    var objCheck = YAHOO.util.Dom.get(idCheck);
    var arrCheck = YAHOO.util.Dom.getElementsBy(function () {
        return true;
    }, 'input', objFormulario);
    var objMostrar = YAHOO.util.Dom.get('seleccionados');
    if (arrCheck.length > 1) {
        if (objCheck.id == '0') {
            for (numIndice in arrCheck) {
                if (arrCheck[ numIndice ].id != "0" && arrCheck[ numIndice ].id != "seqCruce") {
                    arrCheck[ numIndice ].checked = objCheck.checked;
                }
            }
        }
        var numSeleccionados = 0;
        var numTotal = 0;
        for (numIndice in arrCheck) {
            if (arrCheck[ numIndice ].id != "0" && arrCheck[ numIndice ].checked == true) {
                numSeleccionados++;
            }
            if (arrCheck[ numIndice ].id != "seqCruce") {
                numTotal++;
            }
        }
        objMostrar.innerHTML = numTotal + " Hogares Listados " + numSeleccionados + " Seleccionados";
        var objCheck = YAHOO.util.Dom.get('0');
        objCheck.indeterminate = false;
        if (numTotal == numSeleccionados) {
            objCheck.checked = true;
        } else {
            if (numSeleccionados == 0) {
                objCheck.checked = false;
            } else {
                objCheck.indeterminate = true;
            }
        }
    }
}

function seleccionarCheckUnidades(idUnidadProyecto, idCheck) {
    var objUnidadProyecto = YAHOO.util.Dom.get(idUnidadProyecto);
    var objCheck = YAHOO.util.Dom.get(idCheck);
    var arrCheck = YAHOO.util.Dom.getElementsBy(function () {
        return true;
    }, 'input', objUnidadProyecto);
    var objMostrar = YAHOO.util.Dom.get('seleccionadas');
    if (arrCheck.length > 1) {
        if (objCheck.id == '0') {
            for (numIndice in arrCheck) {
                if (arrCheck[ numIndice ].id != "0" && arrCheck[ numIndice ].id != "seqProyecto") {
                    arrCheck[ numIndice ].checked = objCheck.checked;
                }
            }
        }
        var numSeleccionados = 0;
        var numTotal = 0;
        for (numIndice in arrCheck) {
            if (arrCheck[ numIndice ].id != "0" && arrCheck[ numIndice ].checked == true) {
                numSeleccionados++;
            }
            if (arrCheck[ numIndice ].id != "seqProyecto") {
                numTotal++;
            }
        }
        objMostrar.innerHTML = numTotal + " Unidades de proyecto listadas " + numSeleccionados + " seleccionadas";
        var objCheck = YAHOO.util.Dom.get('0');
        objCheck.indeterminate = false;
        if (numTotal == numSeleccionados) {
            objCheck.checked = true;
        } else {
            if (numSeleccionados == 0) {
                objCheck.checked = false;
            } else {
                objCheck.indeterminate = true;
            }
        }
    }
}

function exportarInhabilidadesExcel(idFormulario) {

    var objFormulario = YAHOO.util.Dom.get(idFormulario);
    var arrCheck = YAHOO.util.Dom.getElementsBy(function () {
        return true;
    }, 'input', objFormulario);

    var numSeleccionados = 0;
    if (arrCheck.length > 1) {
        for (numIndice in arrCheck) {
            if (arrCheck[ numIndice ].id != "0" && arrCheck[ numIndice ].checked == true) {
                numSeleccionados++;
            }

        }
    }

    if (numSeleccionados > 0) {
        someterFormulario('mensajes', objFormulario, './contenidos/cruces/exportarInhabilidades.php', true, false);
    } else {

        // Objeto que contiene los atributos del cuadro de dialogo
        var objAtributos = {
            width: "300px",
            effect: {
                effect: YAHOO.widget.ContainerEffect.FADE,
                duration: 0.25
            },
            fixedcenter: true,
            modal: true,
            draggable: true,
            close: true
        }

        // INSTANCIA EL OBJETO DIALOGO
        var objDialogo = new YAHOO.widget.SimpleDialog("dlg", objAtributos);

        objDialogo.setHeader("Atencion Requerida !!"); // encabezado del objeto
        objDialogo.setBody("Debe seleccionar al menos un registro, no hay nada que exportar"); // texto que se muestra en el cuerpo (formato html)
        objDialogo.cfg.setProperty("icon", YAHOO.widget.SimpleDialog.ICON_WARN); // Icono de advertencia que se ve en el cuadro
        objDialogo.render(document.body);
        objDialogo.show();
    }


}

function exportarUnidadesProyectoExcel(idUnidadProyecto) {
    var objFormulario = YAHOO.util.Dom.get(idUnidadProyecto);
    var arrCheck = YAHOO.util.Dom.getElementsBy(function () {
        return true;
    }, 'input', objFormulario);

    var numSeleccionados = 0;
    if (arrCheck.length > 1) {
        for (numIndice in arrCheck) {
            if (arrCheck[ numIndice ].id != "0" && arrCheck[ numIndice ].checked == true) {
                numSeleccionados++;
            }

        }
    }

    if (numSeleccionados > 0) {
        someterFormulario('mensajes', objFormulario, './contenidos/unidadProyecto/exportarUnidadesProyecto.php', true, false);
    } else {

        // Objeto que contiene los atributos del cuadro de dialogo
        var objAtributos = {
            width: "300px",
            effect: {
                effect: YAHOO.widget.ContainerEffect.FADE,
                duration: 0.25
            },
            fixedcenter: true,
            modal: true,
            draggable: true,
            close: true
        }

        // INSTANCIA EL OBJETO DIALOGO
        var objDialogo = new YAHOO.widget.SimpleDialog("dlg", objAtributos);

        objDialogo.setHeader("Atencion Requerida !!"); // encabezado del objeto
        objDialogo.setBody("Debe seleccionar al menos un registro, no hay nada que exportar"); // texto que se muestra en el cuerpo (formato html)
        objDialogo.cfg.setProperty("icon", YAHOO.widget.SimpleDialog.ICON_WARN); // Icono de advertencia que se ve en el cuadro
        objDialogo.render(document.body);
        objDialogo.show();
    }
}

function cargarCruce() {

    var objDiv = YAHOO.util.Dom.get('dlgCargaCruces');
    objDiv.hidden = false;

    var handleSubmit = function exito(o) {
        var objFormulario = YAHOO.util.Dom.get('frmCargaCruces');
        someterFormulario('mensajes', objFormulario, './contenidos/cruces/salvarCruces.php', true, true);
        this.cancel();
    }

    var handleCancel = function falla(o) {
        this.cancel();
    }

    var handleSuccess = function (o) {
        var response = o.responseText;
        response = response.split("<!")[0];
        document.getElementById("mensajes").innerHTML = response;
    };

    var handleFailure = function (o) {
        alert("Submission failed: " + o.status);
    };


    var objDialogo = new YAHOO.widget.Dialog("dlgCargaCruces",
            {width: "600px",
                fixedcenter: true,
                visible: false,
                zIndex: 1,
                constraintoviewport: true,
                buttons: [{text: "Aceptar", handler: handleSubmit, isDefault: true},
                    {text: "Cancelar", handler: handleCancel}]
            });

    objDialogo.callback = {success: handleSuccess, failure: handleFailure};
    objDialogo.render();
    objDialogo.show();
}

function cargarUnidadesProyecto() {

    var objDiv = YAHOO.util.Dom.get('dlgCargaUnidades');
    objDiv.hidden = false;

    var handleSubmit = function exito(o) {
        var objFormulario = YAHOO.util.Dom.get('frmCargaUnidades');
        someterFormulario('mensajes', objFormulario, './contenidos/unidadProyecto/salvarUnidades.php?seqProyecto=3', true, true);
        this.cancel();
    }

    var handleCancel = function falla(o) {
        this.cancel();
    }

    var handleSuccess = function (o) {
        var response = o.responseText;
        response = response.split("<!")[0];
        document.getElementById("mensajes").innerHTML = response;
    };

    var handleFailure = function (o) {
        alert("Submission failed: " + o.status);
    };


    var objDialogo = new YAHOO.widget.Dialog("dlgCargaUnidades",
            {width: "600px",
                fixedcenter: true,
                visible: false,
                zIndex: 1,
                constraintoviewport: true,
                buttons: [{text: "Aceptar", handler: handleSubmit, isDefault: true},
                    {text: "Cancelar", handler: handleCancel}]
            });

    objDialogo.callback = {success: handleSuccess, failure: handleFailure};
    objDialogo.render();
    objDialogo.show();
}

function exportarInhabilidadesPdf(idFormulario) {

    // OBTIENE EL FORMULARIO QUE VA A SER SOMETIDO
    var objFormulario = YAHOO.util.Dom.get(idFormulario);
    var objHidden = YAHOO.util.Dom.get('seqCruce');

    var txtFormularios = "";

    // OBTIENE LOS CHECKBOX DEL FORMULARIO
    var arrCheck = YAHOO.util.Dom.getElementsBy(function () {
        return true;
    }, 'input', objFormulario);

    // VERIFICA QUE HAYA ALGUN CHECK SELECCIONADO
    var numSeleccionados = 0;
    if (arrCheck.length > 1) {
        for (numIndice in arrCheck) {
            if (arrCheck[ numIndice ].id != "0" && arrCheck[ numIndice ].checked == true) {
                numSeleccionados++;
                txtFormularios += "exportar[]=" + arrCheck[ numIndice ].value + "&";

            }
        }
    }

    // VERIFICA QUE HAYAN CHECK SELECCIONADOS
    if (numSeleccionados > 0) {

        // llamar funcion
        popUpPdfCasaMano('exportarPdf.php', txtFormularios, objHidden.value);

    } else { // SE MUESTRA CUANDO NO HAY CHECK SELECCIONADOS

        // Objeto que contiene los atributos del cuadro de dialogo
        var objAtributos = {
            width: "300px",
            effect: {
                effect: YAHOO.widget.ContainerEffect.FADE,
                duration: 0.25
            },
            fixedcenter: true,
            modal: true,
            draggable: true,
            close: true
        }

        // INSTANCIA EL OBJETO DIALOGO
        var objDialogo = new YAHOO.widget.SimpleDialog("dlg", objAtributos);

        objDialogo.setHeader("Atencion Requerida !!"); // encabezado del objeto
        objDialogo.setBody("Debe seleccionar al menos un registro, no hay nada que exportar"); // texto que se muestra en el cuerpo (formato html)
        objDialogo.cfg.setProperty("icon", YAHOO.widget.SimpleDialog.ICON_WARN); // Icono de advertencia que se ve en el cuadro
        objDialogo.render(document.body);
        objDialogo.show();
    }

}

/**
 * UNA FUNCION PARA HACER EL AUTOCOMPLETAR EN CUALQUIER CAMPO
 * @author Bernardo Zerda
 */
function autocompletar(txtInput, txtContenedor, txtArchivo, txtParametros) {

    // Use an XHRDataSource
    var objDataSource = new YAHOO.util.XHRDataSource(txtArchivo);
    objDataSource.responseType = YAHOO.util.XHRDataSource.TYPE_TEXT;
    objDataSource.responseSchema = {recordDelim: "\n", fieldDelim: "\t"};
    objDataSource.maxCacheEntries = 0;
    objDataSource.flushCache();

    // Instantiate the AutoComplete
    var objAutocomplete = new YAHOO.widget.AutoComplete(txtInput, txtContenedor, objDataSource);
    objAutocomplete.maxResultsDisplayed = 10;
    objAutocomplete.minQueryLength = 1;
    objAutocomplete.autoHighlight = true;
    objAutocomplete.useShadow = true;
    objAutocomplete.forceSelection = true;
    objAutocomplete.allowBrowserAutocomplete = false;
    objAutocomplete.queryDelay = 0.3;

    return {
        oDS: objDataSource,
        oAC: objAutocomplete
    };

}

function popUpPdfCasaMano(txtArchivo, txtFormularios, seqCruce) {

    var wndFormato = null;
    try {
        var numAlto = YAHOO.util.Dom.getDocumentHeight() - 200;
        var txtUrl = "./contenidos/cruces/" + txtArchivo;
        txtUrl += "?seqCruce=" + seqCruce + "&" + txtFormularios;
        var txtParametros = "resizable=0,location=0,scrollbars=1,width=780,height=" + numAlto + ",left=100,top=10,titlebar=0";
        if (!(wndFormato = window.open(txtUrl, '_blank', txtParametros))) {
            throw "ErrorPopUp";
        }
    } catch (objError) {
        if (objError == "ErrorPopUp") {
            alert("Ooops, al parecer tu navegador tiene bloqueado las ventanas emergentes, desactiva esa opcion y vuelve a intentar");
        }
    }

}

function mostrarTooltip(objDestino, $txtMostrar) {
    var objConfiguracion = {
        context: objDestino,
        text: $txtMostrar,
        width: 400
    }
    var objToolTip = new YAHOO.widget.Tooltip("tooltip", objConfiguracion);
    objToolTip.render(objDestino);
    objToolTip.show();
}


function imprimirPostulacionCEM(objFormulario, txtArchivo) {

    someterFormulario('mensajes', objFormulario, txtArchivo, true, true);

    YAHOO.util.Event.onContentReady(
            "tablaMensajes",
            function () {
                var objTablaMensajes = document.getElementById("tablaMensajes");
                var arrFilas = objTablaMensajes.getElementsByTagName("td");
                if (arrFilas[ 0 ].className != "msgError") {
                    var wndPostulacion;
                    try {
                        var seqFormulario = document.getElementById("seqFormulario").value;
                        wndPostulacion = window.open("./contenidos/subsidios/formatoPostulacionImprimir.php?seqFormulario=" + seqFormulario,
                                "_blank",
                                "resizable=0,location=0,scrollbars=1,width=780,height=700,left=100,top=100"
                                );
                        if (!wndPostulacion) {
                            throw "ErrorPopUp";
                        }
                    } catch (objError) {
                        if (objError == "ErrorPopUp") {
                            alert("Ooops, al parecer tu navegador tiene bloqueado las ventanas emergentes, desactiva esa opcion y vuelve a intentar");
                        }
                    }
                }
            }
    );

}

/* *************************************************************************************
 * FUNCIONES DE MODULO DE PROYECTOS
 ***************************************************************************************/

function buscarProyecto(txtNombreArchivo) {
    //alert (txtNombreArchivo);
    var objSeq = document.getElementById("myHidden").value;
    //alert (objSeq);
    //var objNitConfirmacion = document.getElementById("buscaNitConfirmacion");
    var objMensajes = document.getElementById("mensajes");

    // Limpia los mensajes de la barra de mensajes
    objMensajes.innerHTML = "";

    // Valida que el campo NIT tenga algo
    /*if (objNit.value == "") {
     objMensajes.innerHTML += "<li>Digite un n" + String.fromCharCode(250) + "mero de Nit v" + String.fromCharCode(225) + "lido";
     }*/

    // Valida que haya algo en la confirmacion
    /*if (objNitConfirmacion.value == "") {
     objMensajes.innerHTML += "<li>Debe confirmar el valor digitado</li>";
     }*/

    // Valida que ambos valores sean iguales
    /*if (objNit.value != objNitConfirmacion.value) {
     objMensajes.innerHTML += "<li>No coinciden los documentos digitados, verifique los datos</li>";
     }*/

    if (objMensajes.innerHTML == "") {
        cargarContenido("formulario", "contenidos/" + txtNombreArchivo + ".php", "nit=" + objSeq, true);
        //alert ("formulario, contenidos/" + txtNombreArchivo + ".php, nit=" + objSeq + "true");
    } else {
        objMensajes.className = "msgError";
    }
}

// Muestra los campos "Nombre" y "NIT de OPV" si selecciona el tipo de Organización "OPV"
function escondeLineaOpv() {
    if (document.getElementById("seqTipoEsquema").value == 2) {
        document.getElementById("lineaOpv").style.display = "table-row";
    } else {
        document.getElementById("lineaOpv").style.display = "none";
        document.getElementById("seqOpv").value = "0";
    }
}

// Muestra el campo "Operador" si el esquema seleccionado es "Territorial dirigido"
function escondeTerritorialDirigido() {
    if (document.getElementById("seqTipoEsquema").value == 4) { // Esquema Territorial Dirigido
        // Operador y Objeto
        document.getElementById("lineaTDirigida").style.display = "table-row";
        // Plan Parcial
        document.getElementById("idTituloPlanParcial").style.display = "none";
        document.getElementById("idCampoPlanParcial").style.display = "none";
        document.getElementById("txtNombrePlanParcial").value = "";
        // Tipo Proyecto y Tipo Urbanizacion
        document.getElementById("idLineaProyectoUrbanizacion").style.display = "none";
        document.getElementById("seqTipoProyecto").value = "0";
        document.getElementById("seqTipoUrbanizacion").value = "0";
        // Tipo Solucion y Descripcion
        document.getElementById("idLineaTipoSolucionDescripcion").style.display = "none";
        document.getElementById("seqTipoSolucion").value = "0";
        document.getElementById("txtDescripcionProyecto").value = "";
        // Direccion
        document.getElementById("idLineaDireccion").style.display = "none";
        document.getElementById("bolDireccion").value = "0";
        document.getElementById("txtDireccion").value = "";
        // Torres
        document.getElementById("idLineaTorres").style.display = "none";
        document.getElementById("valTorres").value = "";
        // Area Lote y Area Construida
        document.getElementById("idLineaAreaLoteConstruida").style.display = "none";
        document.getElementById("valAreaLote").value = "";
        document.getElementById("valAreaConstruida").value = "";
        // Chip Lote y Matricula Inmobiliaria
        document.getElementById("idLineaChipLoteMatricula").style.display = "none";
        document.getElementById("txtChipLote").value = "";
        document.getElementById("txtMatriculaInmobiliariaLote").value = "";
        // Registro y Fecha de Enajenacion
        document.getElementById("idLineaRegistroFechaEnajenacion").style.display = "none";
        document.getElementById("txtRegistroEnajenacion").value = "";
        document.getElementById("fchRegistroEnajenacion").value = "";
        // Equipamiento Comunal
        document.getElementById("idLineaEquipamientoComunal").style.display = "none";
        document.getElementById("bolEquipamientoComunal").value = "0";
        document.getElementById("txtDescEquipamientoComunal").value = "";
        // Licencia Urbanismo
        document.getElementById("idLineaLicenciaUrbanismo1").style.display = "none";
        document.getElementById("idLineaLicenciaUrbanismo2").style.display = "none";
        document.getElementById("idLineaLicenciaUrbanismo3").style.display = "none";
        document.getElementById("lineaProrrogaUrbanismo").style.display = "none";
        document.getElementById("idLineaLicenciaUrbanismo4").style.display = "none";
        // Licencia Construccion
        document.getElementById("idLineaLicenciaConstruccion1").style.display = "none";
        document.getElementById("idLineaLicenciaConstruccion2").style.display = "none";
        document.getElementById("idLineaLicenciaConstruccion3").style.display = "none";
        document.getElementById("lineaProrrogaConstruccion").style.display = "none";
    } else { // Otros Esquemas
        document.getElementById("lineaTDirigida").style.display = "none";
        document.getElementById("txtNombreOperador").value = "";
        document.getElementById("txtObjetoProyecto").value = "";
        // Plan Parcial
        document.getElementById("idTituloPlanParcial").style.display = "table-row";
        document.getElementById("idCampoPlanParcial").style.display = "table-row";
        // Tipo Proyecto y Tipo Urbanizacion
        document.getElementById("idLineaProyectoUrbanizacion").style.display = "table-row";
        // Tipo Solucion y Descripcion
        document.getElementById("idLineaTipoSolucionDescripcion").style.display = "table-row";
        // Direccion
        document.getElementById("idLineaDireccion").style.display = "table-row";
        // Torres
        document.getElementById("idLineaTorres").style.display = "table-row";
        // Area Lote y Area Construida
        document.getElementById("idLineaAreaLoteConstruida").style.display = "table-row";
        // Chip Lote y Matricula Inmobiliaria
        document.getElementById("idLineaChipLoteMatricula").style.display = "table-row";
        // Registro y Fecha de Enajenacion
        document.getElementById("idLineaRegistroFechaEnajenacion").style.display = "table-row";
        // Equipamiento Comunal
        document.getElementById("idLineaEquipamientoComunal").style.display = "table-row";
        // Licencia Urbanismo
        document.getElementById("idLineaLicenciaUrbanismo1").style.display = "table-row";
        document.getElementById("idLineaLicenciaUrbanismo2").style.display = "table-row";
        document.getElementById("idLineaLicenciaUrbanismo3").style.display = "table-row";
        document.getElementById("lineaProrrogaUrbanismo").style.display = "table-row";
        document.getElementById("idLineaLicenciaUrbanismo4").style.display = "table-row";
        // Licencia Construccion
        document.getElementById("idLineaLicenciaConstruccion1").style.display = "table-row";
        document.getElementById("idLineaLicenciaConstruccion2").style.display = "table-row";
        document.getElementById("idLineaLicenciaConstruccion3").style.display = "table-row";
        document.getElementById("lineaProrrogaConstruccion").style.display = "table-row";
    }
}

// Muestra el campo 'Dirección' si el campo booleano 'Se conoce la dirección?' es 'Si'
function escondetxtDireccion() {
    if (document.getElementById("bolDireccion").checked == 1) {
        document.getElementById("lineaTituloDireccion").style.display = "table-row";
        document.getElementById("lineaCampoDireccion").style.display = "table-row";
    } else {
        document.getElementById("lineaTituloDireccion").style.display = "none";
        document.getElementById("lineaCampoDireccion").style.display = "none";
        document.getElementById("txtDireccion").value = '';
    }
}

// Muestra el campo 'Descripción Equipamiento Comunal' si el campo booleano 'Equipamiento Comunal' es 'Si'
function escondetxtDescEquipamientoComunal() {
    if (document.getElementById("bolEquipamientoComunal").checked == 1) {
        document.getElementById("idTituloDescEquipamientoComunal").style.display = "table-row";
        document.getElementById("lineaDescEquipamientoComunal").style.display = "table-row";
    } else {
        document.getElementById("idTituloDescEquipamientoComunal").style.display = "none";
        document.getElementById("lineaDescEquipamientoComunal").style.display = "none";
        document.getElementById("txtDescEquipamientoComunal").value = '';
    }
}

// Muestra 'Cedula' y 'Tarjeta Profesional' si el Tipo de Persona es 'Natural' o muestra el 'NIT' si es 'Juridica'
function escondeCamposTipoPersona() {
    if (document.getElementById("bolTipoPersonaInterventor").checked == 1) {
        document.getElementById("lineaPersonaNatural").style.display = "table-row";
        document.getElementById("lineaPersonaJuridica").style.display = "none";
        document.getElementById("lineaPersonaJuridica2").style.display = "none";
        document.getElementById("lineaPersonaJuridica3").style.display = "none";
        document.getElementById("lineaTituloInterventor").style.display = "none";
        document.getElementById("numNitInterventor").value = '';
        document.getElementById("txtNombreRepLegalInterventor").value = '';
        document.getElementById("txtDireccionRepLegalInterventor").value = '';
        document.getElementById("numTelefonoRepLegalInterventor").value = '';
        document.getElementById("txtCorreoRepLegalInterventor").value = '';
    } else {
        document.getElementById("lineaPersonaNatural").style.display = "none";
        document.getElementById("lineaPersonaJuridica").style.display = "table-row";
        document.getElementById("lineaPersonaJuridica2").style.display = "table-row";
        document.getElementById("lineaPersonaJuridica3").style.display = "table-row";
        document.getElementById("lineaTituloInterventor").style.display = "table-row";
        document.getElementById("numCedulaInterventor").value = '';
        document.getElementById("numTProfesionalInterventor").value = '';
    }
}

// Muestra el tr "LineaConstructor" si "bolConstructor" es "SI"
function escondeLineaConstructor() {
    if (document.getElementById("bolConstructor").checked == 0) {
        document.getElementById("idTituloConstructor").style.display = "table-row";
        document.getElementById("idComboConstructor").style.display = "table-row";
    } else {
        document.getElementById("idTituloConstructor").style.display = "none";
        document.getElementById("idComboConstructor").style.display = "none";
        document.getElementById("seqConstructor").value = '0';
    }
}

// Calcula el valor del subsidio dependiendo del numero de soluciones
function calculaSubsidioProyecto() {
    document.getElementById("valSDVE").value = ((document.getElementById("valNumeroSoluciones").value) * (document.getElementById("valSalarioMinimo").value) * 26);
    sumaTotalRecursos();
}

/**
 * Funcion que pregunta si guardar el proyecto
 * @author Jaison Ospina
 * @version 1.0 Septiembre 2013 
 */

function preguntarGuardarProyecto() {
    var txtMensaje = "<div style='text-align:left'>";
    txtMensaje += "<span class='msgError' style='font-size:12px';>Desea guardar el proyecto?</span>";
    txtMensaje += "</div>";

    // COMPORTAMIENTO SI SE PRESIONA -- SI -- EN EL CUADRO
    var handleYes = function () {
        //alert('Seleccionó SI');
        /*var x = 1;
         document.getElementById("seqPryEstadoProceso").value = x;*/
        var objFormularioProyecto = YAHOO.util.Dom.get('frmInscripcionProyecto');
        pedirConfirmacion('mensajes', objFormularioProyecto, './contenidos/proyectos/pedirConfirmacion.php');
        this.cancel();
    }

    // COMPORTAMIENTO SI SE PRESIONA -- NO -- EN EL CUADRO
    var handleNo = function () {
        //alert('Seleccionó NO');
        var x = document.getElementById("seqPryEstadoProceso").value;
        document.getElementById("seqPryEstadoProceso").value = x;
        var objFormularioProyecto = YAHOO.util.Dom.get('frmInscripcionProyecto');
        pedirConfirmacion('mensajes', objFormularioProyecto, './contenidos/proyectos/pedirConfirmacion.php');
        this.cancel();
    }

    var objAtributos = {
        width: "330px",
        effect: {
            effect: YAHOO.widget.ContainerEffect.FADE,
            duration: 0.75
        },
        fixedcenter: true,
        zIndex: 1,
        visible: false,
        modal: true,
        draggable: true,
        close: false,
        text: txtMensaje,
        buttons: [
            {
                text: "Si",
                handler: handleYes
            },
            {
                text: "No",
                handler: handleNo,
                isDefault: true
            }
        ]
    }

    // INSTANCIA EL OBJETO DIALOGO
    var objDialogo1 = new YAHOO.widget.SimpleDialog("dlg", objAtributos);

    // Muestra el cuadro de dialogo
    objDialogo1.setHeader("Guardar Proyecto");
    objDialogo1.render(document.body);
    objDialogo1.show();
}

function obtenerModalidad(objEsquema) {

    document.getElementById("tdModalidad").innerHTML = "";
    cargarContenido(
            'tdModalidad',
            './contenidos/proyectos/modalidadEsquema.php',
            'seqTipoEsquema=' + objEsquema.options[ objEsquema.selectedIndex ].value,
            true
            );

    YAHOO.util.Event.onContentReady(
            "seqTipoEsquema",
            function () {
                document.getElementById("seqTipoEsquema").focus();
            }
    );
}

// COMITE DE ELEGIBILIDAD - Muestra los datos de aprobación si el campo 'bolAprobacion' está checkeado
function escondeSeccionAprobacion() {
    if (document.getElementById("bolAprobacion").checked) {
        document.getElementById("tblSeccionAprobacion").style.display = "table-row";
    } else {
        document.getElementById("tblSeccionAprobacion").style.display = "none";
        document.getElementById("numActaAprobacion").value = '';
        document.getElementById("fchActaAprobacion").value = '';
        document.getElementById("numResolucionAprobacion").value = '';
        document.getElementById("fchResolucionAprobacion").value = '';
        document.getElementById("txtActaResuelve").value = '';
        //document.getElementById("txtObservacionAprobacion").value = '';
        document.getElementById("txtCondicionAprobacion").value = '';
    }
}

// Si bolCondiciones
function muestraCondicionAprobacion() {
    if (document.getElementById("bolCondicionAprobacion").checked) {
        document.getElementById("tblSeccionCondicionado").style.display = "table-row";
    } else {
        document.getElementById("tblSeccionCondicionado").style.display = "none";
        document.getElementById("txtCondicionAprobacion").value = '';
    }
    //alert(document.getElementById("bolCondicionAprobaciondisabled").disable);
}

// DESEMBOLSOS - Muestra el campo Fiduciaria si selecciona la modalidad de desembolso Encargo Fiduciario
function escondeDatosSegunTipoDesembolso() {
    if (document.getElementById("seqTipoModalidadDesembolso").value == 1) { // Encargo Fiduciario
        document.getElementById("tituloFiduciaria").style.display = "table-row";
        document.getElementById("campoFiduciaria").style.display = "table-row";
        document.getElementById("lineaFiduciario1").style.display = "table-row";
        document.getElementById("lineaFiduciario2").style.display = "table-row";
        document.getElementById("lineaBancario1").style.display = "none";
        document.getElementById("lineaFideicomiso1").style.display = "none";
        document.getElementById("lineaFideicomiso2").style.display = "none";
        document.getElementById("lineaFideicomiso3").style.display = "none";
        document.getElementById("lineaFideicomiso4").style.display = "none";
        document.getElementById("lineaFiduciarioFideicomiso").style.display = "table-row";
        document.getElementById("chkDocDesemEntidad3").value = 0;
        document.getElementById("txtDocDesemEntidad3").value = "";
        document.getElementById("chkDocDesemEntidad4").value = 0;
        document.getElementById("txtDocDesemEntidad4").value = "";
        document.getElementById("chkDocDesemEntidad5").value = 0;
        document.getElementById("txtDocDesemEntidad5").value = "";
        document.getElementById("chkDocDesemEntidad6").value = 0;
        document.getElementById("txtDocDesemEntidad6").value = "";
        document.getElementById("chkDocDesemEntidad7").value = 0;
        document.getElementById("txtDocDesemEntidad7").value = "";
    } else if (document.getElementById("seqTipoModalidadDesembolso").value == 2) { // Fideicomiso Admon Inmobiliaria
        document.getElementById("tituloFiduciaria").style.display = "none";
        document.getElementById("campoFiduciaria").style.display = "none";
        document.getElementById("seqFiduciaria").value = 0;
        document.getElementById("lineaFiduciario1").style.display = "none";
        document.getElementById("lineaFiduciario2").style.display = "none";
        document.getElementById("lineaBancario1").style.display = "none";
        document.getElementById("lineaFideicomiso1").style.display = "table-row";
        document.getElementById("lineaFideicomiso2").style.display = "table-row";
        document.getElementById("lineaFideicomiso3").style.display = "table-row";
        document.getElementById("lineaFideicomiso4").style.display = "table-row";
        document.getElementById("lineaFiduciarioFideicomiso").style.display = "table-row";
        document.getElementById("chkDocDesemEntidad1").value = 0;
        document.getElementById("txtDocDesemEntidad1").value = "";
        document.getElementById("chkDocDesemEntidad2").value = 0;
        document.getElementById("txtDocDesemEntidad2").value = "";
        document.getElementById("chkDocDesemEntidad3").value = 0;
        document.getElementById("txtDocDesemEntidad3").value = "";
        document.getElementById("chkDocDesemEntidad8").value = 0;
        document.getElementById("txtDocDesemEntidad8").value = "";
    } else if (document.getElementById("seqTipoModalidadDesembolso").value == 3) { // Aval Bancario
        document.getElementById("tituloFiduciaria").style.display = "none";
        document.getElementById("campoFiduciaria").style.display = "none";
        document.getElementById("seqFiduciaria").value = 0;
        document.getElementById("lineaFiduciario1").style.display = "none";
        document.getElementById("lineaFiduciario2").style.display = "none";
        document.getElementById("lineaBancario1").style.display = "table-row";
        document.getElementById("lineaFideicomiso1").style.display = "none";
        document.getElementById("lineaFideicomiso2").style.display = "none";
        document.getElementById("lineaFideicomiso3").style.display = "none";
        document.getElementById("lineaFideicomiso4").style.display = "none";
        document.getElementById("lineaFiduciarioFideicomiso").style.display = "none";
        document.getElementById("chkDocDesemEntidad1").value = 0;
        document.getElementById("txtDocDesemEntidad1").value = "";
        document.getElementById("chkDocDesemEntidad2").value = 0;
        document.getElementById("txtDocDesemEntidad2").value = "";
        document.getElementById("chkDocDesemEntidad4").value = 0;
        document.getElementById("txtDocDesemEntidad4").value = "";
        document.getElementById("chkDocDesemEntidad5").value = 0;
        document.getElementById("txtDocDesemEntidad5").value = "";
        document.getElementById("chkDocDesemEntidad6").value = 0;
        document.getElementById("txtDocDesemEntidad6").value = "";
        document.getElementById("chkDocDesemEntidad7").value = 0;
        document.getElementById("txtDocDesemEntidad7").value = "";
        document.getElementById("chkDocDesemEntidad8").value = 0;
        document.getElementById("txtDocDesemEntidad8").value = "";
    } else { // Ninguno
        document.getElementById("tituloFiduciaria").style.display = "none";
        document.getElementById("campoFiduciaria").style.display = "none";
        document.getElementById("campoFiduciaria").value = 0;
        document.getElementById("lineaFiduciario1").style.display = "none";
        document.getElementById("lineaFiduciario2").style.display = "none";
        document.getElementById("lineaBancario1").style.display = "none";
        document.getElementById("lineaFideicomiso1").style.display = "none";
        document.getElementById("lineaFideicomiso2").style.display = "none";
        document.getElementById("lineaFideicomiso3").style.display = "none";
        document.getElementById("lineaFideicomiso4").style.display = "none";
        document.getElementById("lineaFiduciarioFideicomiso").style.display = "none";
        document.getElementById("lineaGenericaDocEntidadFinanciera").style.display = "none";
        document.getElementById("chkDocDesemEntidad1").value = 0;
        document.getElementById("txtDocDesemEntidad1").value = "";
        document.getElementById("chkDocDesemEntidad2").value = 0;
        document.getElementById("txtDocDesemEntidad2").value = "";
        document.getElementById("chkDocDesemEntidad3").value = 0;
        document.getElementById("txtDocDesemEntidad3").value = "";
        document.getElementById("chkDocDesemEntidad4").value = 0;
        document.getElementById("txtDocDesemEntidad4").value = "";
        document.getElementById("chkDocDesemEntidad5").value = 0;
        document.getElementById("txtDocDesemEntidad5").value = "";
        document.getElementById("chkDocDesemEntidad6").value = 0;
        document.getElementById("txtDocDesemEntidad6").value = "";
        document.getElementById("chkDocDesemEntidad7").value = 0;
        document.getElementById("txtDocDesemEntidad7").value = "";
        document.getElementById("chkDocDesemEntidad8").value = 0;
        document.getElementById("txtDocDesemEntidad8").value = "";
        document.getElementById("chkDocDesemEntidad9").value = 0;
        document.getElementById("txtDocDesemEntidad9").value = "";
    }
}

///////////////////////////////////////// FIN FUNCIONES MODULO DE PROYECTOS

function popUpAyuda( ) {

//      var numAlto  = YAHOO.util.Dom.getDocumentHeight() - 200;
//      var numAncho = YAHOO.util.Dom.getDocumentWidth() - 100;

    var numAlto = YAHOO.util.Dom.getDocumentHeight() - 200;
    var numAncho = 400;

    var x = YAHOO.util.Dom.getX("ayuda") - (numAncho - 25);
    var y = YAHOO.util.Dom.getY("ayuda") + 10;

    var fncExito = function (o) {

        // Instancia un objeto panel
        var objAyuda = new YAHOO.widget.Panel(
                "wait",
                {
                    width: numAncho,
                    height: numAlto,
                    fixedcenter: false,
                    close: true,
                    draggable: false,
                    modal: false,
                    visible: false,
                    x: x,
                    y: y
                }
        );

        // Encabezado
        objAyuda.setHeader("Ayuda SIPIVE");

        // cuerpo del panel
        objAyuda.setBody(o.responseText);

        // El objeto se despliega sobre el cuerpo del documento html
        objAyuda.render(document.body);

        objAyuda.show();

    }

    var fncFalla = function (o) {
        alert("Falta el archivo de ayuda");
    }

    var callback = {
        success: fncExito,
        failure: fncFalla
    }

    YAHOO.util.Connect.asyncRequest(
            "POST",
            "./contenidos/ayuda/ayuda.php",
            callback,
            "alto=" + numAlto
            );

}

function eliminarInscripcion(objFormulario) {

    // Objeto que contiene los atributos del cuadro de dialogo
    var objAtributos = {
        width: "350px",
        effect: {
            effect: YAHOO.widget.ContainerEffect.FADE,
            duration: 0.75
        },
        fixedcenter: true,
        modal: true,
        draggable: true,
        close: false
    }

    // INSTANCIA EL OBJETO DIALOGO
    var objDialogo = new YAHOO.widget.SimpleDialog("dlg", objAtributos);

    objDialogo.setHeader("Atencion Requerida !!"); // encabezado del objeto
    objDialogo.setBody("<span class='msgError'>¿Desea eliminar el registro de la base de datos?</span>");			   // texto que se muestra en el cuerpo (formato html)
    objDialogo.cfg.setProperty("icon", YAHOO.widget.SimpleDialog.ICON_WARN); // Icono de advertencia que se ve en el cuadro

    // COMPORTAMIENTO SI SE PRESIONA -- SI -- EN EL CUADRO
    var handleYes = function () {

        // Envia los datos el archivo que contesta la peticion de borrado
        someterFormulario('mensajes', objFormulario, './contenidos/subsidios/eliminarInscripcion.php', false, true);

        this.hide(); // oculta el objeto de confirmacion
    }

    // COMPORTAMIENTO SI SE PRESIONA -- NO -- EN EL CUADRO
    var handleNo = function () {
        document.getElementById("mensajes").innerHTML = "";
        this.hide();
    }

    // Botones para aÃ±adir al cuadro de dialogo
    // No poner esto antes de la declartacion de los manejadores
    var arrBotones = [
        {
            text: "Eliminar",
            handler: handleYes
        },
        {
            text: "Cancelar",
            handler: handleNo,
            isDefault: true
        }
    ];

    objDialogo.cfg.queueProperty("buttons", arrBotones);

    // Muestra el cuadro de dialogo
    objDialogo.render(document.body);
    objDialogo.show();

}


//   function cartasAsignacion( numActo , fchActo , numDocumento ){
//      
//      var wndFormato = null;
//      try {
//          var numAlto  = 900;
//          var txtUrl = "./contenidos/asignacion/cartasAsignacion.php";
//              txtUrl += "?numActo=" + numActo + "&fchActo=" + fchActo + "&numDocumento=" + numDocumento;
//          var txtParametros = "resizable=0,location=0,scrollbars=1,width=780,height="+numAlto+",left=100,top=10,titlebar=0";
//          if (!(wndFormato = window.open(txtUrl, '_blank', txtParametros))) {
//              throw "ErrorPopUp";
//          }
//      } catch (objError) {
//          if (objError == "ErrorPopUp") {
//              alert("Ooops, al parecer tu navegador tiene bloqueado las ventanas emergentes, desactiva esa opcion y vuelve a intentar");
//          }
//      }
//      
//   }

function autocompletar2(txtInput, txtContenedor, txtArchivo, txtParametros) {

    // Use an XHRDataSource
    var objDataSource = new YAHOO.util.XHRDataSource(txtArchivo);
    objDataSource.responseType = YAHOO.util.XHRDataSource.TYPE_JSON;
    objDataSource.responseSchema = {fields: ["nombre", "seqProyecto"]};
    objDataSource.maxCacheEntries = 0;
    objDataSource.flushCache();

    // Instantiate the AutoComplete
    var objAutocomplete = new YAHOO.widget.AutoComplete(txtInput, txtContenedor, objDataSource);
    objAutocomplete.maxResultsDisplayed = 10;
    objAutocomplete.minQueryLength = 1;
    objAutocomplete.autoHighlight = true;
    objAutocomplete.useShadow = true;
    objAutocomplete.forceSelection = true;
    objAutocomplete.allowBrowserAutocomplete = false;
    objAutocomplete.queryDelay = 0.3;

    // Define an event handler to populate a hidden form field 
    // when an item gets selected 
    var myHiddenField = YAHOO.util.Dom.get("myHidden");
    var myHandler = function (sType, aArgs) {
        var myAC = aArgs[0]; // reference back to the AC instance 
        var elLI = aArgs[1]; // reference to the selected LI element 
        var oData = aArgs[2]; // object literal of selected item's result data 

        // update hidden form field with the selected item's ID 
        myHiddenField.value = oData.seqProyecto;
    };
    oAC.itemSelectEvent.subscribe(myHandler);

    return {
        oDS: objDataSource,
        oAC: objAutocomplete
    };

}
// FUNCITONES PARA MOSULO DE CARTAS DE ASIGNACION

var objTablaCA = null;
var fncDataTableCartasAsignacion = function (bolEstado) {

    if (typeof (bolEstado) == "undefined") {
        bolEstado = "";
    } else {
        bolEstado = "1";
    }

    if (YAHOO.util.Dom.get("listenerTablaCiudadanos") != null) {
        eliminarObjeto("listenerTablaCiudadanos");
        YAHOO.util.Event.onContentReady("listenerTablaCiudadanos", fncDataTableCartasAsignacion);
    }

    var objFormulario = YAHOO.util.Dom.get("frmFiltros");
    var objMensajes = YAHOO.util.Dom.get("mensajes");

    var fncOk = function (objRespuesta) {

        txtParametro = objRespuesta.responseText;
        txtParametro = txtParametro.replace("#", "&");

        var txtSeparador = "|";
        var txtSalto = "\n";

        var objColumnas = [
            {
                key: "bolCarta",
                label: "&nbsp;",
                width: 30,
                formatter: "checkbox"
            },
            {
                key: "seqFormularioActo",
                label: "Id",
                width: 30,
                sortable: true,
                formatter: YAHOO.widget.DataTable.formatNumber
            },
            {
                key: "numActo",
                label: "No",
                width: 30,
                sortable: true,
                formatter: YAHOO.widget.DataTable.formatNumber
            },
            {
                key: "fchActo",
                label: "Fecha Res",
                width: 70,
                sortable: true
            },
            {
                key: "numDocumento",
                label: "Documento",
                sortable: true,
                width: 100,
                formatter: YAHOO.widget.DataTable.formatNumber
            },
            {
                key: "txtNombre",
                label: "Nombre",
                width: 270,
                sortable: true
            },
            {
                key: "txtEstadoProceso",
                label: "Estado",
                width: 200,
                sortable: true
            }
        ];

        var objFuente = new YAHOO.util.DataSource("./contenidos/asignacion/listadoCiudadanos.php");
        objFuente.responseType = YAHOO.util.DataSource.TYPE_TEXT; // retorno tipo texto
        objFuente.connMethodPost = true; // conexion por post
        objFuente.responseSchema = {
            recordDelim: txtSalto,
            fieldDelim: txtSeparador,
            fields: [
                "bolCarta",
                {
                    key: "seqFormularioActo",
                    parser: "number"
                },
                {
                    key: "numActo",
                    parser: "number"
                },
                "fchActo",
                {
                    key: "numDocumento",
                    parser: "number"
                },
                "txtNombre",
                "txtEstadoProceso"
            ]
        };

        // configuracion del paginador
        var objConfiguracionPaginador = {
            rowsPerPage: 10,
            template: YAHOO.widget.Paginator.TEMPLATE_ROWS_PER_PAGE,
            rowsPerPageOptions: [10, 25, 50, 100],
            pageLinks: 5,
            firstPageLinkLabel: "Primero",
            lastPageLinkLabel: "Último",
            nextPageLinkLabel: "Siguiente",
            previousPageLinkLabel: "Anterior"
        };

        // paginador
        var objPaginador = new YAHOO.widget.Paginator(objConfiguracionPaginador);

        //objMensajes.innerHTML = "salto=" + txtSalto + "&separador=" + txtSeparador + "&" + txtParametro;

        // DataTable configuration 
        var objConfiguracion = {
            initialRequest: "bolEstado=" + bolEstado + "&salto=" + txtSalto + "&separador=" + txtSeparador + "&" + txtParametro,
            height: "272px",
            width: "100%",
            paginator: objPaginador
        };

        objTablaCA = new YAHOO.widget.ScrollingDataTable(
                "tablaCiudadanos",
                objColumnas,
                objFuente,
                objConfiguracion
                );

        var fncSeleccionado = function (objParametro) {
            var objCheckbox = objParametro.target;
            var objRegistro = this.getRecord(objCheckbox);
            objRegistro.setData("bolCarta", objCheckbox.checked);
        };

        objTablaCA.subscribe("rowMouseoverEvent", objTablaCA.onEventHighlightRow);
        objTablaCA.subscribe("rowMouseoutEvent", objTablaCA.onEventUnhighlightRow);
        objTablaCA.subscribe("checkboxClickEvent", fncSeleccionado);
        objTablaCA.subscribe("cellClickEvent", objTablaCA.onEventShowCellEditor);

        return {
            oDS: objFuente,
            oDT: objTablaCA
        };

    }

    var fncEr = function (objRespuesta) {
        alert(objRespuesta.status + ": " + objRespuesta.statusText);
    }

    var fncRetorno = {
        sucsess: fncOk,
        failure: fncEr,
        upload: fncOk
    }

    YAHOO.util.Connect.setForm(objFormulario, true, true);
    YAHOO.util.Connect.asyncRequest('POST', "./contenidos/asignacion/serializarFormularioCartasAsignacion.php", fncRetorno);

}
YAHOO.util.Event.onContentReady("listenerTablaCiudadanos", fncDataTableCartasAsignacion);

function frmResetCarasAsignacion(objFormulario) {
    objFormulario.reset();
    fncDataTableCartasAsignacion();
}

function exportarCartasAsignacion() {

    var i = 0;
    var numLimite = 200;
    var numSeleccionados = 0;
    var objTextoCarta = YAHOO.util.Dom.get("textoCarta");
    var objEstado = objTablaCA.getState();
    var objRegistro = null;
    var txtParametros = "{";
    for (i = 0; i < objEstado.totalRecords; i++) {
        objRegistro = objTablaCA.getRecord(i);
        if (objRegistro.getData("bolCarta")) {
            if (numSeleccionados < numLimite) {
                txtParametros += "\"" + i + "\":\"" + objRegistro.getData("seqFormularioActo") + "\",";
            }
            numSeleccionados++;
        }
    }
    txtParametros += "\"texto\":\"" + objTextoCarta.value + "\"}";

    if (numSeleccionados > numLimite) {
        alert("Usted seleccionado mas registros de lo permitido, el máximo que puede seleccionar es de " + numLimite + " registros");
    } else {
        if (numSeleccionados == 0) {
            alert("Atención: Seleccione al menos un registro");
        }
    }

    if (numSeleccionados != 0) {
        var wndFormato = null;
        try {
            var numAlto = YAHOO.util.Dom.getDocumentHeight() - 200;
            var txtUrl = "./contenidos/asignacion/exportarCartasAsignacion.php";
            txtUrl += "?parametro=" + txtParametros;
            var txtParametros = "resizable=0,location=0,scrollbars=1,width=780,height=" + numAlto + ",left=100,top=10,titlebar=0";
            if (!(wndFormato = window.open(txtUrl, '_blank', txtParametros))) {
                throw "ErrorPopUp";
            }
        } catch (objError) {
            if (objError == "ErrorPopUp") {
                alert("Ooops, al parecer tu navegador tiene bloqueado las ventanas emergentes, desactiva esa opcion y vuelve a intentar");
            }
        }
    }

}

// FIN FUNCIONES PARA MOSULO DE CARTAS DE ASIGNACION

// FUNCIONES PARA EL NUEVO MODULO DE ACTOS ADMINISTRATIVOS

fncTabActoAdministrativo = function () {

    eliminarObjeto("listenerTabActoAdministrativo");
    YAHOO.util.Event.onContentReady("listenerTabActoAdministrativo", fncTabActoAdministrativo);

    var objTabView = new YAHOO.widget.TabView('tabActoAdministrativo');

}
YAHOO.util.Event.onContentReady("listenerTabActoAdministrativo", fncTabActoAdministrativo);

// ADICIONAR LINEAS A LAS RESOLUCIONES DE UN PROYECTO
var indiceFilaFormulario = 1;
function addResolucionProyecto() {
    myNewRow = document.getElementById("tablaFormularioRes").insertRow(-1);
    myNewRow.id = indiceFilaFormulario;
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' id='numResolucionProyecto' name='numResolucionProyecto[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this );' style='width:70px; text-align:center' ></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:3px");
    myNewCell.innerHTML = "<td><input name='fchResolucionProyecto[" + indiceFilaFormulario + "]' type='text' id='fchResolucionProyecto[" + indiceFilaFormulario + "]' size='12' readonly /> <a href='#' onClick='javascript: calendarioPopUp( \"fchResolucionProyecto[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><textarea id='txtResuelve' name='txtResuelve[" + indiceFilaFormulario + "]' cols='102' rows='4' ></textarea></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'></td>";
    indiceFilaFormulario++;
}

// ADICIONAR LINEAS A LAS ACTAS DE UN PROYECTO
var indiceFilaFormulario = 1;
function addActaProyecto() {
    myNewRow = document.getElementById("tablaFormularioActas").insertRow(-1);
    myNewRow.id = indiceFilaFormulario;
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' id='numActaProyecto' name='numActaProyecto[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this );' style='width:70px; text-align:center' ></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:3px");
    myNewCell.innerHTML = "<td><input name='fchActaProyecto[" + indiceFilaFormulario + "]' type='text' id='fchActaProyecto[" + indiceFilaFormulario + "]' size='12' readonly /> <a href='#' onClick='javascript: calendarioPopUp( \"fchActaProyecto[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><textarea id='txtEpigrafe' name='txtEpigrafe[" + indiceFilaFormulario + "]' cols='102' rows='4' ></textarea></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'></td>";
    indiceFilaFormulario++;
}

// ADICIONAR LINEAS A LOS SEGUIMIENTOS DE DOCUMENTOS (JURIDICA)
var indiceFilaFormulario = 1;
function addSeguimientoDocumento(opcionesDocumentos) {
    //opcionesDocumentos = opcionesDocumentos.replace(',\");
    myNewRow = document.getElementById("tablaFormularioDocumentos").insertRow(0);
    myNewRow.id = indiceFilaFormulario;
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    //myNewCell.setAttribute("style", "padding:6px");
    var contenido = "<td><table border='0' cellspacing='2' cellpadding='0' width='100%'>";
    contenido += "<tr><td width='35%' class='tituloTabla' colspan='2' valign='top'>Nuevo Seguimiento<input type='hidden' id='unicoSegDocum' name='unicoSegDocum[" + indiceFilaFormulario + "]' value='" + indiceFilaFormulario + "'></td></tr>";
    contenido += "<tr><td valign='top'><select id='seqDocumento' name='seqDocumento[" + indiceFilaFormulario + "]' style='width:260px;' >" + opcionesDocumentos + "</select></td><td width='65%' rowspan='3' valign='top' rows='6'><textarea name='txtObservaciones[" + indiceFilaFormulario + "]' id='txtObservaciones' style='width:500px'></textarea></td></tr>";
    contenido += "</table></td>";
    myNewCell.innerHTML = contenido;
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.innerHTML = "<td><input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'></td>";
    indiceFilaFormulario++;
}

// ADICIONAR LINEAS AL CRONOGRAMA DE OBRAS
var indiceFilaFormulario = 1;
function addActividadCronogramaProyecto() {
    myNewRow = document.getElementById("tablaFormularioCronograma").insertRow(-1);
    myNewRow.id = indiceFilaFormulario;
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='txtNombreActividad[" + indiceFilaFormulario + "]' id='txtNombreActividad' onBlur='sinCaracteresEspeciales( this );' style='width:260px' ></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:3px");
    myNewCell.innerHTML = "<td><input name='fchInicialActividad[" + indiceFilaFormulario + "]' type='text' id='fchInicialActividad[" + indiceFilaFormulario + "]' size='12' readonly /><a href='#' onClick='javascript: calendarioPopUp( \"fchInicialActividad[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:3px");
    myNewCell.innerHTML = "<td><input name='fchFinalActividad[" + indiceFilaFormulario + "]' type='text' id='fchFinalActividad[" + indiceFilaFormulario + "]' size='12' readonly /><a href='#' onClick='javascript: calendarioPopUp( \"fchFinalActividad[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><textarea name='txtDescripcionActividad[" + indiceFilaFormulario + "]' id='txtDescripcionActividad' style='width:260px'></textarea></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='txtResponsableActividad[" + indiceFilaFormulario + "]' id='txtResponsableActividad' onBlur='sinCaracteresEspeciales( this );' style='width:225px' ></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='button' value='Eliminar' onClick='return confirmaRemoverLineaFormulario(this);'></td>";
    indiceFilaFormulario++;
}

// ADICIONAR LINEAS AL CRONOGRAMA (FECHAS)
var indiceFilaFormulario = 1;
function addCronogramaFechas() {
    myNewRow = document.getElementById("tablaFormularioFechas").insertRow(-1);
    myNewRow.id = indiceFilaFormulario;
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td>Num. <input name='numActaDescriptiva[" + indiceFilaFormulario + "]' type='text' id='numActaDescriptiva[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this );' size='5' style='text-align:center'/> A&ntilde;o <input name='numAnoActaDescriptiva[" + indiceFilaFormulario + "]' type='text' id='numAnoActaDescriptiva[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this );' size='5' style='text-align:center'/></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:3px");
    myNewCell.innerHTML = "<td><input name='fchInicialProyecto[" + indiceFilaFormulario + "]' type='text' id='fchInicialProyecto[" + indiceFilaFormulario + "]' size='12' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUp( \"fchInicialProyecto[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:3px");
    myNewCell.innerHTML = "<td><input name='fchFinalProyecto[" + indiceFilaFormulario + "]' type='text' id='fchFinalProyecto[" + indiceFilaFormulario + "]' size='12' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUp( \"fchFinalProyecto[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input name='valPlazoEjecucion[" + indiceFilaFormulario + "]' type='text' id='valPlazoEjecucion[" + indiceFilaFormulario + "]' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this );' style='text-align:center'/></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:3px");
    myNewCell.innerHTML = "<td><input name='fchInicialEntrega[" + indiceFilaFormulario + "]' type='text' id='fchInicialEntrega[" + indiceFilaFormulario + "]' size='12' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUp( \"fchInicialEntrega[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:3px");
    myNewCell.innerHTML = "<td><input name='fchFinalEntrega[" + indiceFilaFormulario + "]' type='text' id='fchFinalEntrega[" + indiceFilaFormulario + "]' size='12' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUp( \"fchFinalEntrega[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:3px");
    myNewCell.innerHTML = "<td><input name='fchInicialEscrituracion[" + indiceFilaFormulario + "]' type='text' id='fchInicialEscrituracion[" + indiceFilaFormulario + "]' size='12' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUp( \"fchInicialEscrituracion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:3px");
    myNewCell.innerHTML = "<td><input name='fchFinalEscrituracion[" + indiceFilaFormulario + "]' type='text' id='fchFinalEscrituracion[" + indiceFilaFormulario + "]' size='12' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUp( \"fchFinalEscrituracion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='button' value='Eliminar' onClick='return confirmaRemoverLineaFormulario(this);'></td>";
    indiceFilaFormulario++;
}

// ADICIONAR LINEAS AL TIPO DE VIVIENDA (ESTRUCTURA DEL PROYECTO)
var indiceFilaFormulario = 1;
function addTipoVivienda() {
    myNewRow = document.getElementById("tablaTipoVivienda").insertRow(-1);
    myNewRow.id = indiceFilaFormulario;
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='txtNombreTipoVivienda[" + indiceFilaFormulario + "]' id='txtNombreTipoVivienda' onBlur='sinCaracteresEspeciales( this );' style='width:150px' ></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='numCantidad[" + indiceFilaFormulario + "]' id='numCantidad_" + indiceFilaFormulario + "' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); sumaVentas();' style='width:50px; text-align:right' ></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='numArea[" + indiceFilaFormulario + "]' id='numArea' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this );' style='width:50px; text-align:right' >&nbsp;m²</td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='numAnoVenta[" + indiceFilaFormulario + "]' id='numAnoVenta' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this );' style='width:50px; text-align:right' ></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td>$ <input type='text' name='valPrecioVenta[" + indiceFilaFormulario + "]' id='valPrecioVenta_" + indiceFilaFormulario + "' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); sumaVentas();' style='width:80px; text-align:right' ></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><textarea name='txtDescripcion[" + indiceFilaFormulario + "]' id='txtDescripcion' style='width:260px'></textarea></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td>$ <input type='text' name='valCierre[" + indiceFilaFormulario + "]' id='valCierre' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this );' style='width:80px; text-align:right' ></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='button' value='Eliminar' onClick='return confirmaRemoverLineaFormulario(this);'></td>";
    indiceFilaFormulario++;
}

// ADICIONAR LINEAS AL CONJUNTO RESIDENCIAL (SUBPROYECTOS)
var indiceFilaFormulario = 1;
function addConjuntoResidencial() {
    myNewRow = document.getElementById("tablaConjuntoResidencial").insertRow(-1);
    myNewRow.id = indiceFilaFormulario;
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "left");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='txtNombreProyectoHijo[" + indiceFilaFormulario + "]' id='txtNombreProyectoHijo' onBlur='sinCaracteresEspeciales( this );' size='28' ></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "left");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='txtNombreComercialHijo[" + indiceFilaFormulario + "]' id='txtNombreComercialHijo' onBlur='sinCaracteresEspeciales( this );' size='28' ></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "left");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><a href='#' onClick='recogerDireccion( \"txtDireccionHijo[" + indiceFilaFormulario + "]\", \"objDireccionOculto\" )'><img src='recursos/imagenes/icono_lupa.gif'></a>&nbsp;<input type='text' name='txtDireccionHijo[" + indiceFilaFormulario + "]' id='txtDireccionHijo[" + indiceFilaFormulario + "]' size='20' style='background-color:#E4E4E4;' readonly /></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "left");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='valNumeroSolucionesHijo[" + indiceFilaFormulario + "]' id='valNumeroSolucionesHijo' onBlur='sinCaracteresEspeciales( this );' size='6' ></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "left");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='txtChipLoteHijo[" + indiceFilaFormulario + "]' id='txtChipLoteHijo' onBlur='sinCaracteresEspeciales( this );' size='13' ></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "left");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='txtMatriculaInmobiliariaLoteHijo[" + indiceFilaFormulario + "]' id='txtMatriculaInmobiliariaLoteHijo' onBlur='sinCaracteresEspeciales( this );' size='13' ></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "left");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='txtLicenciaUrbanismoHijo[" + indiceFilaFormulario + "]' id='txtLicenciaUrbanismoHijo' onBlur='sinCaracteresEspeciales( this );' size='18' ></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "left");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input name='fchLicenciaUrbanismo1Hijo[" + indiceFilaFormulario + "]' type='text' id='fchLicenciaUrbanismo1Hijo[" + indiceFilaFormulario + "]' size='8' style='text-align:center; background-color:#E4E4E4' readonly /><a href='#' onClick='javascript: calendarioPopUp( \"fchLicenciaUrbanismo1Hijo[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input name='fchVigenciaLicenciaUrbanismoHijo[" + indiceFilaFormulario + "]' type='text' id='fchVigenciaLicenciaUrbanismoHijo[" + indiceFilaFormulario + "]' size='8' style='text-align:center; background-color:#E4E4E4' readonly /><a href='#' onClick='javascript: calendarioPopUp( \"fchVigenciaLicenciaUrbanismoHijo[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "left");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='txtExpideLicenciaUrbanismoHijo[" + indiceFilaFormulario + "]' id='txtExpideLicenciaUrbanismoHijo' onBlur='sinCaracteresEspeciales( this );' size='13' ></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "left");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='txtLicenciaConstruccionHijo[" + indiceFilaFormulario + "]' id='txtLicenciaConstruccionHijo' onBlur='sinCaracteresEspeciales( this );' size='18' ></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "left");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input name='fchLicenciaConstruccion1Hijo[" + indiceFilaFormulario + "]' type='text' id='fchLicenciaConstruccion1Hijo[" + indiceFilaFormulario + "]' size='8' style='text-align:center; background-color:#E4E4E4' readonly /><a href='#' onClick='javascript: calendarioPopUp( \"fchLicenciaConstruccion1Hijo[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input name='fchVigenciaLicenciaConstruccionHijo[" + indiceFilaFormulario + "]' type='text' id='fchVigenciaLicenciaConstruccionHijo[" + indiceFilaFormulario + "]' size='8' style='text-align:center; background-color:#E4E4E4' readonly /><a href='#' onClick='javascript: calendarioPopUp( \"fchVigenciaLicenciaConstruccionHijo[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "left");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='txtNombreVendedorHijo[" + indiceFilaFormulario + "]' id='txtNombreVendedorHijo' onBlur='sinCaracteresEspeciales( this );' size='20' ></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "left");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='numNitVendedorHijo[" + indiceFilaFormulario + "]' id='numNitVendedorHijo' onBlur='sinCaracteresEspeciales( this );' size='12' ></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "left");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='txtCedulaCatastralHijo[" + indiceFilaFormulario + "]' id='txtCedulaCatastralHijo' onBlur='sinCaracteresEspeciales( this );' size='22' ></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "left");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='txtEscrituraHijo[" + indiceFilaFormulario + "]' id='txtEscrituraHijo' onBlur='sinCaracteresEspeciales( this );' size='12' ></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input name='fchEscrituraHijo[" + indiceFilaFormulario + "]' type='text' id='fchEscrituraHijo[" + indiceFilaFormulario + "]' size='8' style='text-align:center; background-color:#E4E4E4' readonly /><a href='#' onClick='javascript: calendarioPopUp( \"fchEscrituraHijo[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "left");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='text' name='numNotariaHijo[" + indiceFilaFormulario + "]' id='numNotariaHijo' onBlur='sinCaracteresEspeciales( this );' size='12' ></td>";
    //
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.align = "center";
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='button' value='Eliminar' onClick='return confirmaRemoverLineaFormulario(this);'></td>";
    indiceFilaFormulario++;
}

// ADICIONAR LINEAS A SEGUIMIENTOS A OBRAS (SI SE VA A GUARDAR EL SEGUIMIENTO ESCOGIENDO LA ACTIVIDAD)
var indiceFilaFormulario = 1;
function addSeguimientoActividad(opcionesActividadesCronograma, opcionesEstadosActividades) {
    myNewRow = document.getElementById("tablaSeguimientoActividades").insertRow(-1);
    myNewRow.id = indiceFilaFormulario;
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='hidden' id='unico' name='unico[" + indiceFilaFormulario + "]' value='" + indiceFilaFormulario + "'></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding-top:6px");
    myNewCell.innerHTML = "<td><select id='seqSeguimientoActividad' name='seqSeguimientoActividad[" + indiceFilaFormulario + "]' style='width:185px;' ><option value='0'>ACTIVIDAD</option>" + opcionesActividadesCronograma + "</select></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding-top:6px");
    myNewCell.innerHTML = "<td><textarea id='txtDescripcionSeguimiento' name='txtDescripcionSeguimiento[" + indiceFilaFormulario + "]' style='width:220px' ></textarea></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><select id='seqEstadoActividad' name='seqEstadoActividad[" + indiceFilaFormulario + "]' style='width:95px;' ><option value='0'>ESTADO</option>" + opcionesEstadosActividades + "</select></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td></td>";
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'></td>";
    indiceFilaFormulario++;
}

// ADICIONAR LINEAS A DESEMBOLSOS
var indiceFilaFormulario = 1;
function addGiroDesembolsos(costoProyecto, numeroSoluciones, optModalidadDesembolso, optTipoCuenta, optBanco) {
    myNewRow = document.getElementById("tablaGiroDesembolsos").insertRow(-1);
    myNewRow.id = indiceFilaFormulario;
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", 'center');
    myNewCell.setAttribute("style", "padding:6px");
    var contenido = "<td><div class='accordionItem'><h2>Nuevo Desembolso</h2><div style='background-color:#FFFFFF'><table border='0' cellspacing='2' cellpadding='0' width='100%'>";
    contenido += "<tr><td class='tituloTabla' colspan='9'>BENEFICIARIO DEL GIRO ANTICIPADO</td></tr>";
    contenido += "<tr><td width='25%'>Nombre del Vendedor</td><td width='25%'><input name='txtNombreVendedor[" + indiceFilaFormulario + "]' type='text' id='txtNombreVendedor[" + indiceFilaFormulario + "]' onBlur='soloLetras( this ); sinCaracteresEspeciales( this );'  style='width:200px;' /></td><td width='25%'>NIT del Vendedor</td><td width='25%'><input name='numNitVendedor[" + indiceFilaFormulario + "]' type='text' id='numNitVendedor[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this );' style='width:190px;' /></td></tr>";
    contenido += "<tr><td>Tel&eacute;fono del Vendedor</td><td><input name='numTelefonoVendedor[" + indiceFilaFormulario + "]' type='text' id='numTelefonoVendedor[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this );' style='width:200px;' /></td><td>Correo Electr&oacute;nico del Vendedor</td><td><input name='txtCorreoVendedor[" + indiceFilaFormulario + "]' type='text' id='txtCorreoVendedor[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this )' style='width:190px;' /></td></tr>";
    contenido += "<tr><td>Beneficiario del Giro</td><td><input name='txtNombreBeneficiarioGiro[" + indiceFilaFormulario + "]' type='text' id='txtNombreBeneficiarioGiro[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this );'  style='width:200px;' /></td><td>NIT del Beneficiario del Giro</td><td><input name='numNitBeneficiarioGiro[" + indiceFilaFormulario + "]' type='text' id='numNitBeneficiarioGiro[" + indiceFilaFormulario + "]'  onBlur='sinCaracteresEspeciales( this ); soloNumeros( this );' style='width:190px;' /></td></tr>";
    contenido += "<tr><td>Costo del Proyecto</td><td>$ " + costoProyecto + "</td><td>N&uacute;mero Soluciones</td><td>" + numeroSoluciones + "</td></tr>";
    contenido += "<tr><td>Valor del Desembolso</td><td>$ <input name='valDesembolso[" + indiceFilaFormulario + "]' type='text' id='valDesembolso[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this );' style='width:90px;' /></td><td	colspan='2'></td></tr>";
    contenido += "<tr colspan='4' style='height:5px'><td></td></tr>";
    contenido += "<tr><td class='tituloTabla' colspan='4' align='center'>INFORMACI&Oacute;N DEL GIRO ANTICIPADO</td></tr>";
    contenido += "<tr colspan='4' style='height:5px'><td></td></tr>";
    contenido += "<tr><td width='25%'>Modalidad del Desembolso</td><td width='25%'><select name='seqTipoModalidadDesembolso[" + indiceFilaFormulario + "]' id='seqTipoModalidadDesembolso[" + indiceFilaFormulario + "]' style='width:200px' onChange='escondeDatosSegunTipoDesembolso();' ><option value='0'>Seleccione una opción</option>" + optModalidadDesembolso + "</select></td><td colspan='2'></td></tr>";
    contenido += "<tr><td>No. de Contrato Suscrito</td><td><input name='numContratoSuscrito[" + indiceFilaFormulario + "]' type='text' id='numContratoSuscrito[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this );' style='width:200px;' /></td><td>Fecha Contrato Suscrito</td><td><input name='fchContratoSuscrito[" + indiceFilaFormulario + "]' type='text' id='fchContratoSuscrito[" + indiceFilaFormulario + "]' size='12' readonly /><a href='#' onClick='javascript: calendarioPopUp( \"fchContratoSuscrito[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td></tr>";
    contenido += "<tr><td>Entidad Financiera</td><td><input name='txtNombreEntidadFinanciera[" + indiceFilaFormulario + "]' type='text' id='txtNombreEntidadFinanciera[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this );' style='width:200px;' /></td><td>Nit Entidad Financiera</td><td><input name='numNitEntidadFinanciera[" + indiceFilaFormulario + "]' type='text' id='numNitEntidadFinanciera[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this );' style='width:200px;' /></td></tr>";
    contenido += "<tr><td>No. de Cuenta</td><td><input name='numCuenta[" + indiceFilaFormulario + "]' type='text' id='numCuenta[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this );' style='width:200px;' /></td><td>Tipo de Cuenta</td><td><select name='seqTipoCuenta[" + indiceFilaFormulario + "]' id='seqTipoCuenta[" + indiceFilaFormulario + "]' style='width:190px' ><option value='0'>Seleccione una opción</option>" + optTipoCuenta + "</select></td></tr>";
    contenido += "<tr><td>Banco de la Cuenta</td><td><select name='seqBancoCuenta[" + indiceFilaFormulario + "]' id='seqBancoCuenta[" + indiceFilaFormulario + "]' style='width:200px' ><option value='0'>Seleccione una opción</option>" + optBanco + "</select></td><td	colspan='2'></td></tr>";
    contenido += "<tr><td>Valor Total Giro Anticipado</td><td>$ <input name='valTotalGiroAnticipado[" + indiceFilaFormulario + "]' type='text' id='valTotalGiroAnticipado[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this );' style='width:90px;' /></td><td	colspan='2'></td></tr>";
    contenido += "<tr><td>Saldo Por Girar</td><td>$ <input name='valSaldoGiro[" + indiceFilaFormulario + "]' type='text' id='valSaldoGiro[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this );' style='width:90px;' /></td><td>N&uacute;mero del Pago</td><td><input name='valNumeroPago[" + indiceFilaFormulario + "]' type='text' id='valNumeroPago[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this );' style='width:190px;' /></td></tr>";
    //contenido += "<tr colspan='4' style='height:5px'><td></td></tr>";
    //contenido += "<tr><td class='tituloTabla' colspan='4' align='center'>ADJUNTO UNIDADES</td></tr>";
    //contenido += "<tr colspan='4' style='height:5px'><td></td></tr>";
    //contenido += "<tr><td colspan='2'><b>Seleccione el archivo:</b><br>En el archivo plano debe ir la lista de los documentos sin encabezado </td><td valign='middle' colspan='2'><input type='file' name='fileDocumentos["+indiceFilaFormulario+"]' /></td></tr>";
    contenido += "</table></div></div></td>";
    myNewCell.innerHTML = contenido;
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", 'center');
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'></td>";
    indiceFilaFormulario++;
}

// DIFERENCIA DE FECHAS
function diferenciaFechaDias(actual, inicial, campo) {
    var vlrInicial = inicial.value;
    var vlrActual = actual.value;
    if (vlrActual.substr(6, 1) == "-") {
        var Parte1 = vlrActual.substr(0, 5);
        var Parte2 = "0"
        var Parte3 = vlrActual.substr(5, 5);
        var vlrActualNuevo = Parte1 + Parte2 + Parte3;
    } else {
        var vlrActualNuevo = vlrActual;
    }
    var vlrActualFrm = Date.parse(vlrActualNuevo);
    var vlrInicialFrm = Date.parse(vlrInicial);
    var diff = Math.floor((Date.parse(vlrActualNuevo) - Date.parse(vlrInicial)) / 86400000);
    // Si es valor de la resta es válido coloque el valor, de lo contrario coloque 0
    if (isNaN(diff)) {
        document.getElementById(campo).value = 0;
    } else {
        document.getElementById(campo).value = diff;
    }
}

// DIFERENCIA DE VALORES
function diferenciaValores(actual, inicial, campo) {
    var vlrInicial = inicial.value;
    var vlrActual = actual.value;
    var diff = vlrActual - vlrInicial;
    // Si es valor de la resta es válido coloque el valor, de lo contrario coloque 0
    if (isNaN(diff)) {
        document.getElementById(campo).value = 0;
    } else {
        document.getElementById(campo).value = diff;
    }
}

// VALOR ACTIVIDAD EJECUTADO SEGUN EL PORCENTAJE INCIDENCIA EJECUTADO
function valorActividadEjecutado(porcentaje, campo) {
    var valorCosto = document.getElementById("valTotalCostos").value;
    var valorPorcentaje = porcentaje.value;
    var valorActividadExe = valorPorcentaje * valorCosto / 100;
    document.getElementById(campo).value = valorActividadExe;
}

// ADICIONAR LINEAS A SEGUIMIENTOS A OBRAS (SI SE VA A CARGAR TODA LA PLANTILLA DE ACTIVIDADES)
var indiceFilaFormulario = 1;
function addSeguimientoObras(fchInicialTerreno, fchFinalTerreno, porcIncTerreno, valActTerreno, fchInicialPreliminarConstruccion, fchFinalPreliminarConstruccion, porcIncPreliminarConstruccion, valActPreliminarConstruccion, fchInicialCimentacionConstruccion, fchFinalCimentacionConstruccion, porcIncCimentacionConstruccion, valActCimentacionConstruccion, fchInicialDesaguesConstruccion, fchFinalDesaguesConstruccion, porcIncDesaguesConstruccion, valActDesaguesConstruccion, fchInicialEstructuraConstruccion, fchFinalEstructuraConstruccion, porcIncEstructuraConstruccion, valActEstructuraConstruccion, fchInicialMamposteriaConstruccion, fchFinalMamposteriaConstruccion, porcIncMamposteriaConstruccion, valActMamposteriaConstruccion, fchInicialPanetesConstruccion, fchFinalPanetesConstruccion, porcIncPanetesConstruccion, valActPanetesConstruccion, fchInicialHidrosanitariasConstruccion, fchFinalHidrosanitariasConstruccion, porcIncHidrosanitariasConstruccion, valActHidrosanitariasConstruccion, fchInicialElectricasConstruccion, fchFinalElectricasConstruccion, porcIncElectricasConstruccion, valActElectricasConstruccion, fchInicialCubiertaConstruccion, fchFinalCubiertaConstruccion, porcIncCubiertaConstruccion, valActCubiertaConstruccion, fchInicialCarpinteriaConstruccion, fchFinalCarpinteriaConstruccion, porcIncCarpinteriaConstruccion, valActCarpinteriaConstruccion, fchInicialPisosConstruccion, fchFinalPisosConstruccion, porcIncPisosConstruccion, valActPisosConstruccion, fchInicialSanitariosConstruccion, fchFinalSanitariosConstruccion, porcIncSanitariosConstruccion, valActSanitariosConstruccion, fchInicialExterioresConstruccion, fchFinalExterioresConstruccion, porcIncExterioresConstruccion, valActExterioresConstruccion, fchInicialAseoConstruccion, fchFinalAseoConstruccion, porcIncAseoConstruccion, valActAseoConstruccion, fchInicialPreliminarUrbanismo, fchFinalPreliminarUrbanismo, porcIncPreliminarUrbanismo, valActPreliminarUrbanismo, fchInicialCimentacionUrbanismo, fchFinalCimentacionUrbanismo, porcIncCimentacionUrbanismo, valActCimentacionUrbanismo, fchInicialDesaguesUrbanismo, fchFinalDesaguesUrbanismo, porcIncDesaguesUrbanismo, valActDesaguesUrbanismo, fchInicialViasUrbanismo, fchFinalViasUrbanismo, porcIncViasUrbanismo, valActViasUrbanismo, fchInicialParquesUrbanismo, fchFinalParquesUrbanismo, porcIncParquesUrbanismo, valActParquesUrbanismo, fchInicialAseoUrbanismo, fchFinalAseoUrbanismo, porcIncAseoUrbanismo, valActAseoUrbanismo) {
    myNewRow = document.getElementById("tablaSeguimientoObras").insertRow(-1);
    myNewRow.id = indiceFilaFormulario;
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("style", "padding:6px");
    var contenido = "<td><div class='accordionItem'><h2>Visita <input name='fchVisita[" + indiceFilaFormulario + "]' type='text' id='fchVisita[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUp( \"fchVisita[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></h2><div><table border='0' cellspacing='2' cellpadding='0' width='100%'>";
    contenido += "<tr class='tituloTabla'>";
    contenido += "<th align='center' style='padding:3px;' rowspan='2' width='12%'>Actividad</th>";
    contenido += "<th align='center' style='padding:3px;' colspan='3'>Fecha Inicial Actividad</th>";
    contenido += "<th align='center' style='padding:3px;' colspan='3'>Fecha Final Actividad</th>";
    contenido += "<th align='center' style='padding:3px;' colspan='3'>% Incidencia</th>";
    contenido += "<th align='center' style='padding:3px;' colspan='3'>Valor Actividad</th></tr>";
    contenido += "<tr class='tituloTabla'>";
    contenido += "<th align='center' style='padding:3px;' width='7%'>Proyectada</th>";
    contenido += "<th align='center' style='padding:3px;' width='7%'>Ejecutada</th>";
    contenido += "<th align='center' style='padding:3px;' width='7%'>Desfase (D&iacute;as)</th>";
    contenido += "<th align='center' style='padding:3px;' width='7%'>Proyectada</th>";
    contenido += "<th align='center' style='padding:3px;' width='7%'>Ejecutada</th>";
    contenido += "<th align='center' style='padding:3px;' width='7%'>Desfase (D&iacute;as)</th>";
    contenido += "<th align='center' style='padding:3px;' width='7%'>Proyectado</th>";
    contenido += "<th align='center' style='padding:3px;' width='7%'>Ejecutado</th>";
    contenido += "<th align='center' style='padding:3px;' width='7%'>Desfase</th>";
    contenido += "<th align='center' style='padding:3px;' width='7%'>Proyectado</th>";
    contenido += "<th align='center' style='padding:3px;' width='7%'>Ejecutado</th>";
    contenido += "<th align='center' style='padding:3px;' width='7%'>Desfase</th>";
    //////////////////////////////////////////////////// TERRENO ///////////////////////////////////////////////////////////
    contenido += "<tr><td class='tituloNivel0' colspan='9'>Terreno</td></tr>";
    // TERRENO (TERRENO)
    contenido += "<tr class='fila_0'>";
    contenido += "<td class='tituloNivel1'>Terreno</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialTerrenoPry[" + indiceFilaFormulario + "]' id='fchInicialTerrenoPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialTerreno + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialTerrenoSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialTerrenoSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialTerrenoSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialTerrenoPry[" + indiceFilaFormulario + "]\"), \"difFchInicialTerreno[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialTerreno[" + indiceFilaFormulario + "]' id='difFchInicialTerreno[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalTerrenoPry[" + indiceFilaFormulario + "]' id='fchFinalTerrenoPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalTerreno + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalTerrenoSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalTerrenoSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalTerrenoSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalTerrenoPry[" + indiceFilaFormulario + "]\"), \"difFchFinalTerreno[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalTerreno[" + indiceFilaFormulario + "]' id='difFchFinalTerreno[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncTerrenoPry[" + indiceFilaFormulario + "]' id='porcIncTerrenoPry[" + indiceFilaFormulario + "]' value='" + porcIncTerreno + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncTerrenoSeg[" + indiceFilaFormulario + "]' id='porcIncTerrenoSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncTerrenoPry[" + indiceFilaFormulario + "]\"), \"difPorcIncTerreno[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActTerrenoSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncTerreno[" + indiceFilaFormulario + "]' id='difPorcIncTerreno[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActTerrenoPry[" + indiceFilaFormulario + "]' id='valActTerrenoPry[" + indiceFilaFormulario + "]' value='" + valActTerreno + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActTerrenoSeg[" + indiceFilaFormulario + "]' id='valActTerrenoSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActTerrenoPry[" + indiceFilaFormulario + "]\"), \"difValActTerreno[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActTerreno[" + indiceFilaFormulario + "]' id='difValActTerreno[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    ///////////////////////////////////////////// CONSTRUCCION ///////////////////////////////////////////////////////////////
    contenido += "<tr><td class='tituloNivel0' colspan='9'>Construcci&oacute;n</td></tr>";
    // PRELIMINARES (CONSTRUCCION)
    contenido += "<tr class='fila_0'><td class='tituloNivel1'>Preliminares</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialPreliminarConstruccionPry[" + indiceFilaFormulario + "]' id='fchInicialPreliminarConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialPreliminarConstruccion + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialPreliminarConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialPreliminarConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialPreliminarConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialPreliminarConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchInicialPreliminarConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialPreliminarConstruccion[" + indiceFilaFormulario + "]' id='difFchInicialPreliminarConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalPreliminarConstruccionPry[" + indiceFilaFormulario + "]' id='fchFinalPreliminarConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalPreliminarConstruccion + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalPreliminarConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalPreliminarConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalPreliminarConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalPreliminarConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchFinalPreliminarConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalPreliminarConstruccion[" + indiceFilaFormulario + "]' id='difFchFinalPreliminarConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncPreliminarConstruccionPry[" + indiceFilaFormulario + "]' id='porcIncPreliminarConstruccionPry[" + indiceFilaFormulario + "]' value='" + porcIncPreliminarConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncPreliminarConstruccionSeg[" + indiceFilaFormulario + "]' id='porcIncPreliminarConstruccionSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncPreliminarConstruccionPry[" + indiceFilaFormulario + "]\"), \"difPorcIncPreliminarConstruccion[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActPreliminarConstruccionSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncPreliminarConstruccion[" + indiceFilaFormulario + "]' id='difPorcIncPreliminarConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActPreliminarConstruccionPry[" + indiceFilaFormulario + "]' id='valActPreliminarConstruccionPry[" + indiceFilaFormulario + "]' value='" + valActPreliminarConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActPreliminarConstruccionSeg[" + indiceFilaFormulario + "]' id='valActPreliminarConstruccionSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActPreliminarConstruccionPry[" + indiceFilaFormulario + "]\"), \"difValActPreliminarConstruccion[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActPreliminarConstruccion[" + indiceFilaFormulario + "]' id='difValActPreliminarConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // CIMENTACION (CONSTRUCCION)
    contenido += "<tr class='fila_1'><td class='tituloNivel1'>Cimentaci&oacute;n</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialCimentacionConstruccionPry[" + indiceFilaFormulario + "]' id='fchInicialCimentacionConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialCimentacionConstruccion + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialCimentacionConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialCimentacionConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialCimentacionConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialCimentacionConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchInicialCimentacionConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialCimentacionConstruccion[" + indiceFilaFormulario + "]' id='difFchInicialCimentacionConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalCimentacionConstruccionPry[" + indiceFilaFormulario + "]' id='fchFinalCimentacionConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalCimentacionConstruccion + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalCimentacionConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalCimentacionConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalCimentacionConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalCimentacionConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchFinalCimentacionConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalCimentacionConstruccion[" + indiceFilaFormulario + "]' id='difFchFinalCimentacionConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncCimentacionConstruccionPry[" + indiceFilaFormulario + "]' id='porcIncCimentacionConstruccionPry[" + indiceFilaFormulario + "]' value='" + porcIncCimentacionConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncCimentacionConstruccionSeg[" + indiceFilaFormulario + "]' id='porcIncCimentacionConstruccionSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncCimentacionConstruccionPry[" + indiceFilaFormulario + "]\"), \"difPorcIncCimentacionConstruccion[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActCimentacionConstruccionSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncCimentacionConstruccion[" + indiceFilaFormulario + "]' id='difPorcIncCimentacionConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActCimentacionConstruccionPry[" + indiceFilaFormulario + "]' id='valActCimentacionConstruccionPry[" + indiceFilaFormulario + "]' value='" + valActCimentacionConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActCimentacionConstruccionSeg[" + indiceFilaFormulario + "]' id='valActCimentacionConstruccionSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActCimentacionConstruccionPry[" + indiceFilaFormulario + "]\"), \"difValActCimentacionConstruccion[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActCimentacionConstruccion[" + indiceFilaFormulario + "]' id='difValActCimentacionConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // DESAGUES (CONSTRUCCION)
    contenido += "<tr class='fila_0'><td class='tituloNivel1'>Desag&uuml;es e instalaciones sanitarias</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialDesaguesConstruccionPry[" + indiceFilaFormulario + "]' id='fchInicialDesaguesConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialDesaguesConstruccion + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialDesaguesConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialDesaguesConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialDesaguesConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialDesaguesConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchInicialDesaguesConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialDesaguesConstruccion[" + indiceFilaFormulario + "]' id='difFchInicialDesaguesConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalDesaguesConstruccionPry[" + indiceFilaFormulario + "]' id='fchFinalDesaguesConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalDesaguesConstruccion + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalDesaguesConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalDesaguesConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalDesaguesConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalDesaguesConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchFinalDesaguesConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalDesaguesConstruccion[" + indiceFilaFormulario + "]' id='difFchFinalDesaguesConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncDesaguesConstruccionPry[" + indiceFilaFormulario + "]' id='porcIncDesaguesConstruccionPry[" + indiceFilaFormulario + "]' value='" + porcIncDesaguesConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncDesaguesConstruccionSeg[" + indiceFilaFormulario + "]' id='porcIncDesaguesConstruccionSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncDesaguesConstruccionPry[" + indiceFilaFormulario + "]\"), \"difPorcIncDesaguesConstruccion[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActDesaguesConstruccionSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncDesaguesConstruccion[" + indiceFilaFormulario + "]' id='difPorcIncDesaguesConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActDesaguesConstruccionPry[" + indiceFilaFormulario + "]' id='valActDesaguesConstruccionPry[" + indiceFilaFormulario + "]' value='" + valActDesaguesConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActDesaguesConstruccionSeg[" + indiceFilaFormulario + "]' id='valActDesaguesConstruccionSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActDesaguesConstruccionPry[" + indiceFilaFormulario + "]\"), \"difValActDesaguesConstruccion[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActDesaguesConstruccion[" + indiceFilaFormulario + "]' id='difValActDesaguesConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // ESTRUCTURA (CONSTRUCCION)
    contenido += "<tr class='fila_1'><td class='tituloNivel1'>Estructura en concreto</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialEstructuraConstruccionPry[" + indiceFilaFormulario + "]' id='fchInicialEstructuraConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialEstructuraConstruccion + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialEstructuraConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialEstructuraConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialEstructuraConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialEstructuraConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchInicialEstructuraConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialEstructuraConstruccion[" + indiceFilaFormulario + "]' id='difFchInicialEstructuraConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalEstructuraConstruccionPry[" + indiceFilaFormulario + "]' id='fchFinalEstructuraConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalEstructuraConstruccion + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalEstructuraConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalEstructuraConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalEstructuraConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalEstructuraConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchFinalEstructuraConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalEstructuraConstruccion[" + indiceFilaFormulario + "]' id='difFchFinalEstructuraConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncEstructuraConstruccionPry[" + indiceFilaFormulario + "]' id='porcIncEstructuraConstruccionPry[" + indiceFilaFormulario + "]' value='" + porcIncEstructuraConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncEstructuraConstruccionSeg[" + indiceFilaFormulario + "]' id='porcIncEstructuraConstruccionSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncEstructuraConstruccionPry[" + indiceFilaFormulario + "]\"), \"difPorcIncEstructuraConstruccion[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActEstructuraConstruccionSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncEstructuraConstruccion[" + indiceFilaFormulario + "]' id='difPorcIncEstructuraConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActEstructuraConstruccionPry[" + indiceFilaFormulario + "]' id='valActEstructuraConstruccionPry[" + indiceFilaFormulario + "]' value='" + valActEstructuraConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActEstructuraConstruccionSeg[" + indiceFilaFormulario + "]' id='valActEstructuraConstruccionSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActEstructuraConstruccionPry[" + indiceFilaFormulario + "]\"), \"difValActEstructuraConstruccion[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActEstructuraConstruccion[" + indiceFilaFormulario + "]' id='difValActEstructuraConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // MAMPOSTERIA (CONSTRUCCION)
    contenido += "<tr class='fila_0'><td class='tituloNivel1'>Mamposter&iacute;a</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialMamposteriaConstruccionPry[" + indiceFilaFormulario + "]' id='fchInicialMamposteriaConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialMamposteriaConstruccion + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialMamposteriaConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialMamposteriaConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialMamposteriaConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialMamposteriaConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchInicialMamposteriaConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialMamposteriaConstruccion[" + indiceFilaFormulario + "]' id='difFchInicialMamposteriaConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalMamposteriaConstruccionPry[" + indiceFilaFormulario + "]' id='fchFinalMamposteriaConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalMamposteriaConstruccion + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalMamposteriaConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalMamposteriaConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalMamposteriaConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalMamposteriaConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchFinalMamposteriaConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalMamposteriaConstruccion[" + indiceFilaFormulario + "]' id='difFchFinalMamposteriaConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncMamposteriaConstruccionPry[" + indiceFilaFormulario + "]' id='porcIncMamposteriaConstruccionPry[" + indiceFilaFormulario + "]' value='" + porcIncMamposteriaConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncMamposteriaConstruccionSeg[" + indiceFilaFormulario + "]' id='porcIncMamposteriaConstruccionSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncMamposteriaConstruccionPry[" + indiceFilaFormulario + "]\"), \"difPorcIncMamposteriaConstruccion[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActMamposteriaConstruccionSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncMamposteriaConstruccion[" + indiceFilaFormulario + "]' id='difPorcIncMamposteriaConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActMamposteriaConstruccionPry[" + indiceFilaFormulario + "]' id='valActMamposteriaConstruccionPry[" + indiceFilaFormulario + "]' value='" + valActMamposteriaConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActMamposteriaConstruccionSeg[" + indiceFilaFormulario + "]' id='valActMamposteriaConstruccionSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActMamposteriaConstruccionPry[" + indiceFilaFormulario + "]\"), \"difValActMamposteriaConstruccion[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActMamposteriaConstruccion[" + indiceFilaFormulario + "]' id='difValActMamposteriaConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // PANETES (CONSTRUCCION)
    contenido += "<tr class='fila_1'><td class='tituloNivel1'>Pa&ntilde;etes y resanes</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialPanetesConstruccionPry[" + indiceFilaFormulario + "]' id='fchInicialPanetesConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialPanetesConstruccion + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialPanetesConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialPanetesConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialPanetesConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialPanetesConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchInicialPanetesConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialPanetesConstruccion[" + indiceFilaFormulario + "]' id='difFchInicialPanetesConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalPanetesConstruccionPry[" + indiceFilaFormulario + "]' id='fchFinalPanetesConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalPanetesConstruccion + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalPanetesConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalPanetesConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalPanetesConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalPanetesConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchFinalPanetesConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalPanetesConstruccion[" + indiceFilaFormulario + "]' id='difFchFinalPanetesConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncPanetesConstruccionPry[" + indiceFilaFormulario + "]' id='porcIncPanetesConstruccionPry[" + indiceFilaFormulario + "]' value='" + porcIncPanetesConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncPanetesConstruccionSeg[" + indiceFilaFormulario + "]' id='porcIncPanetesConstruccionSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncPanetesConstruccionPry[" + indiceFilaFormulario + "]\"), \"difPorcIncPanetesConstruccion[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActPanetesConstruccionSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncPanetesConstruccion[" + indiceFilaFormulario + "]' id='difPorcIncPanetesConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActPanetesConstruccionPry[" + indiceFilaFormulario + "]' id='valActPanetesConstruccionPry[" + indiceFilaFormulario + "]' value='" + valActPanetesConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActPanetesConstruccionSeg[" + indiceFilaFormulario + "]' id='valActPanetesConstruccionSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActPanetesConstruccionPry[" + indiceFilaFormulario + "]\"), \"difValActPanetesConstruccion[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActPanetesConstruccion[" + indiceFilaFormulario + "]' id='difValActPanetesConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // HIDROSANITARIA (CONSTRUCCION)
    contenido += "<tr class='fila_0'><td class='tituloNivel1'>Instalaciones hidrosanitarias</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialHidrosanitariasConstruccionPry[" + indiceFilaFormulario + "]' id='fchInicialHidrosanitariasConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialHidrosanitariasConstruccion + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialHidrosanitariasConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialHidrosanitariasConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialHidrosanitariasConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialHidrosanitariasConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchInicialHidrosanitariasConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialHidrosanitariasConstruccion[" + indiceFilaFormulario + "]' id='difFchInicialHidrosanitariasConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalHidrosanitariasConstruccionPry[" + indiceFilaFormulario + "]' id='fchFinalHidrosanitariasConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalHidrosanitariasConstruccion + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalHidrosanitariasConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalHidrosanitariasConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalHidrosanitariasConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalHidrosanitariasConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchFinalHidrosanitariasConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalHidrosanitariasConstruccion[" + indiceFilaFormulario + "]' id='difFchFinalHidrosanitariasConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncHidrosanitariasConstruccionPry[" + indiceFilaFormulario + "]' id='porcIncHidrosanitariasConstruccionPry[" + indiceFilaFormulario + "]' value='" + porcIncHidrosanitariasConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncHidrosanitariasConstruccionSeg[" + indiceFilaFormulario + "]' id='porcIncHidrosanitariasConstruccionSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncHidrosanitariasConstruccionPry[" + indiceFilaFormulario + "]\"), \"difPorcIncHidrosanitariasConstruccion[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActHidrosanitariasConstruccionSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncHidrosanitariasConstruccion[" + indiceFilaFormulario + "]' id='difPorcIncHidrosanitariasConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActHidrosanitariasConstruccionPry[" + indiceFilaFormulario + "]' id='valActHidrosanitariasConstruccionPry[" + indiceFilaFormulario + "]' value='" + valActHidrosanitariasConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActHidrosanitariasConstruccionSeg[" + indiceFilaFormulario + "]' id='valActHidrosanitariasConstruccionSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActHidrosanitariasConstruccionPry[" + indiceFilaFormulario + "]\"), \"difValActHidrosanitariasConstruccion[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActHidrosanitariasConstruccion[" + indiceFilaFormulario + "]' id='difValActHidrosanitariasConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // ELECTRICAS (CONSTRUCCION)
    contenido += "<tr class='fila_1'><td class='tituloNivel1'>Instalaciones el&eacute;ctricas</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialElectricasConstruccionPry[" + indiceFilaFormulario + "]' id='fchInicialElectricasConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialElectricasConstruccion + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialElectricasConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialElectricasConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialElectricasConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialElectricasConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchInicialElectricasConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialElectricasConstruccion[" + indiceFilaFormulario + "]' id='difFchInicialElectricasConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalElectricasConstruccionPry[" + indiceFilaFormulario + "]' id='fchFinalElectricasConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalElectricasConstruccion + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalElectricasConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalElectricasConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalElectricasConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalElectricasConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchFinalElectricasConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalElectricasConstruccion[" + indiceFilaFormulario + "]' id='difFchFinalElectricasConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncElectricasConstruccionPry[" + indiceFilaFormulario + "]' id='porcIncElectricasConstruccionPry[" + indiceFilaFormulario + "]' value='" + porcIncElectricasConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncElectricasConstruccionSeg[" + indiceFilaFormulario + "]' id='porcIncElectricasConstruccionSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncElectricasConstruccionPry[" + indiceFilaFormulario + "]\"), \"difPorcIncElectricasConstruccion[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActElectricasConstruccionSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncElectricasConstruccion[" + indiceFilaFormulario + "]' id='difPorcIncElectricasConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActElectricasConstruccionPry[" + indiceFilaFormulario + "]' id='valActElectricasConstruccionPry[" + indiceFilaFormulario + "]' value='" + valActElectricasConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActElectricasConstruccionSeg[" + indiceFilaFormulario + "]' id='valActElectricasConstruccionSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActElectricasConstruccionPry[" + indiceFilaFormulario + "]\"), \"difValActElectricasConstruccion[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActElectricasConstruccion[" + indiceFilaFormulario + "]' id='difValActElectricasConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // CUBIERTA (CONSTRUCCION)
    contenido += "<tr class='fila_0'><td class='tituloNivel1'>Cubierta</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialCubiertaConstruccionPry[" + indiceFilaFormulario + "]' id='fchInicialCubiertaConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialCubiertaConstruccion + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialCubiertaConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialCubiertaConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialCubiertaConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialCubiertaConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchInicialCubiertaConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialCubiertaConstruccion[" + indiceFilaFormulario + "]' id='difFchInicialCubiertaConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalCubiertaConstruccionPry[" + indiceFilaFormulario + "]' id='fchFinalCubiertaConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalCubiertaConstruccion + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalCubiertaConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalCubiertaConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalCubiertaConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalCubiertaConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchFinalCubiertaConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalCubiertaConstruccion[" + indiceFilaFormulario + "]' id='difFchFinalCubiertaConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncCubiertaConstruccionPry[" + indiceFilaFormulario + "]' id='porcIncCubiertaConstruccionPry[" + indiceFilaFormulario + "]' value='" + porcIncCubiertaConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncCubiertaConstruccionSeg[" + indiceFilaFormulario + "]' id='porcIncCubiertaConstruccionSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncCubiertaConstruccionPry[" + indiceFilaFormulario + "]\"), \"difPorcIncCubiertaConstruccion[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActCubiertaConstruccionSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncCubiertaConstruccion[" + indiceFilaFormulario + "]' id='difPorcIncCubiertaConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActCubiertaConstruccionPry[" + indiceFilaFormulario + "]' id='valActCubiertaConstruccionPry[" + indiceFilaFormulario + "]' value='" + valActCubiertaConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActCubiertaConstruccionSeg[" + indiceFilaFormulario + "]' id='valActCubiertaConstruccionSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActCubiertaConstruccionPry[" + indiceFilaFormulario + "]\"), \"difValActCubiertaConstruccion[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActCubiertaConstruccion[" + indiceFilaFormulario + "]' id='difValActCubiertaConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // CARPINTERIA (CONSTRUCCION)
    contenido += "<tr class='fila_1'><td class='tituloNivel1'>Carpinter&iacute;a met&aacute;lica</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialCarpinteriaConstruccionPry[" + indiceFilaFormulario + "]' id='fchInicialCarpinteriaConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialCarpinteriaConstruccion + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialCarpinteriaConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialCarpinteriaConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialCarpinteriaConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialCarpinteriaConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchInicialCarpinteriaConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialCarpinteriaConstruccion[" + indiceFilaFormulario + "]' id='difFchInicialCarpinteriaConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalCarpinteriaConstruccionPry[" + indiceFilaFormulario + "]' id='fchFinalCarpinteriaConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalCarpinteriaConstruccion + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalCarpinteriaConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalCarpinteriaConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalCarpinteriaConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalCarpinteriaConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchFinalCarpinteriaConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalCarpinteriaConstruccion[" + indiceFilaFormulario + "]' id='difFchFinalCarpinteriaConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncCarpinteriaConstruccionPry[" + indiceFilaFormulario + "]' id='porcIncCarpinteriaConstruccionPry[" + indiceFilaFormulario + "]' value='" + porcIncCarpinteriaConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncCarpinteriaConstruccionSeg[" + indiceFilaFormulario + "]' id='porcIncCarpinteriaConstruccionSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncCarpinteriaConstruccionPry[" + indiceFilaFormulario + "]\"), \"difPorcIncCarpinteriaConstruccion[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActCarpinteriaConstruccionSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncCarpinteriaConstruccion[" + indiceFilaFormulario + "]' id='difPorcIncCarpinteriaConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActCarpinteriaConstruccionPry[" + indiceFilaFormulario + "]' id='valActCarpinteriaConstruccionPry[" + indiceFilaFormulario + "]' value='" + valActCarpinteriaConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActCarpinteriaConstruccionSeg[" + indiceFilaFormulario + "]' id='valActCarpinteriaConstruccionSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActCarpinteriaConstruccionPry[" + indiceFilaFormulario + "]\"), \"difValActCarpinteriaConstruccion[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActCarpinteriaConstruccion[" + indiceFilaFormulario + "]' id='difValActCarpinteriaConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // PISOS (CONSTRUCCION)
    contenido += "<tr class='fila_0'><td class='tituloNivel1'>Pisos, enchapes y acabados</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialPisosConstruccionPry[" + indiceFilaFormulario + "]' id='fchInicialPisosConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialPisosConstruccion + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialPisosConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialPisosConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialPisosConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialPisosConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchInicialPisosConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialPisosConstruccion[" + indiceFilaFormulario + "]' id='difFchInicialPisosConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalPisosConstruccionPry[" + indiceFilaFormulario + "]' id='fchFinalPisosConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalPisosConstruccion + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalPisosConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalPisosConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalPisosConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalPisosConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchFinalPisosConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalPisosConstruccion[" + indiceFilaFormulario + "]' id='difFchFinalPisosConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncPisosConstruccionPry[" + indiceFilaFormulario + "]' id='porcIncPisosConstruccionPry[" + indiceFilaFormulario + "]' value='" + porcIncPisosConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncPisosConstruccionSeg[" + indiceFilaFormulario + "]' id='porcIncPisosConstruccionSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncPisosConstruccionPry[" + indiceFilaFormulario + "]\"), \"difPorcIncPisosConstruccion[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActPisosConstruccionSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncPisosConstruccion[" + indiceFilaFormulario + "]' id='difPorcIncPisosConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActPisosConstruccionPry[" + indiceFilaFormulario + "]' id='valActPisosConstruccionPry[" + indiceFilaFormulario + "]' value='" + valActPisosConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActPisosConstruccionSeg[" + indiceFilaFormulario + "]' id='valActPisosConstruccionSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActPisosConstruccionPry[" + indiceFilaFormulario + "]\"), \"difValActPisosConstruccion[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActPisosConstruccion[" + indiceFilaFormulario + "]' id='difValActPisosConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // SANITARIOS (CONSTRUCCION)
    contenido += "<tr class='fila_1'><td class='tituloNivel1'>Aparatos sanitarios y lavaplatos</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialSanitariosConstruccionPry[" + indiceFilaFormulario + "]' id='fchInicialSanitariosConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialSanitariosConstruccion + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialSanitariosConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialSanitariosConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialSanitariosConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialSanitariosConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchInicialSanitariosConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialSanitariosConstruccion[" + indiceFilaFormulario + "]' id='difFchInicialSanitariosConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalSanitariosConstruccionPry[" + indiceFilaFormulario + "]' id='fchFinalSanitariosConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalSanitariosConstruccion + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalSanitariosConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalSanitariosConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalSanitariosConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalSanitariosConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchFinalSanitariosConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalSanitariosConstruccion[" + indiceFilaFormulario + "]' id='difFchFinalSanitariosConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncSanitariosConstruccionPry[" + indiceFilaFormulario + "]' id='porcIncSanitariosConstruccionPry[" + indiceFilaFormulario + "]' value='" + porcIncSanitariosConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncSanitariosConstruccionSeg[" + indiceFilaFormulario + "]' id='porcIncSanitariosConstruccionSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncSanitariosConstruccionPry[" + indiceFilaFormulario + "]\"), \"difPorcIncSanitariosConstruccion[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActSanitariosConstruccionSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncSanitariosConstruccion[" + indiceFilaFormulario + "]' id='difPorcIncSanitariosConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActSanitariosConstruccionPry[" + indiceFilaFormulario + "]' id='valActSanitariosConstruccionPry[" + indiceFilaFormulario + "]' value='" + valActSanitariosConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActSanitariosConstruccionSeg[" + indiceFilaFormulario + "]' id='valActSanitariosConstruccionSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActSanitariosConstruccionPry[" + indiceFilaFormulario + "]\"), \"difValActSanitariosConstruccion[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActSanitariosConstruccion[" + indiceFilaFormulario + "]' id='difValActSanitariosConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // EXTERIORES (CONSTRUCCION)
    contenido += "<tr class='fila_0'><td class='tituloNivel1'>Obras exteriores</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialExterioresConstruccionPry[" + indiceFilaFormulario + "]' id='fchInicialExterioresConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialExterioresConstruccion + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialExterioresConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialExterioresConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialExterioresConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialExterioresConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchInicialExterioresConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialExterioresConstruccion[" + indiceFilaFormulario + "]' id='difFchInicialExterioresConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalExterioresConstruccionPry[" + indiceFilaFormulario + "]' id='fchFinalExterioresConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalExterioresConstruccion + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalExterioresConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalExterioresConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalExterioresConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalExterioresConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchFinalExterioresConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalExterioresConstruccion[" + indiceFilaFormulario + "]' id='difFchFinalExterioresConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncExterioresConstruccionPry[" + indiceFilaFormulario + "]' id='porcIncExterioresConstruccionPry[" + indiceFilaFormulario + "]' value='" + porcIncExterioresConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncExterioresConstruccionSeg[" + indiceFilaFormulario + "]' id='porcIncExterioresConstruccionSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncExterioresConstruccionPry[" + indiceFilaFormulario + "]\"), \"difPorcIncExterioresConstruccion[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActExterioresConstruccionSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncExterioresConstruccion[" + indiceFilaFormulario + "]' id='difPorcIncExterioresConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActExterioresConstruccionPry[" + indiceFilaFormulario + "]' id='valActExterioresConstruccionPry[" + indiceFilaFormulario + "]' value='" + valActExterioresConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActExterioresConstruccionSeg[" + indiceFilaFormulario + "]' id='valActExterioresConstruccionSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActExterioresConstruccionPry[" + indiceFilaFormulario + "]\"), \"difValActExterioresConstruccion[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActExterioresConstruccion[" + indiceFilaFormulario + "]' id='difValActExterioresConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // ASEO (CONSTRUCCION)
    contenido += "<tr class='fila_1'><td class='tituloNivel1'>Aseo</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialAseoConstruccionPry[" + indiceFilaFormulario + "]' id='fchInicialAseoConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialAseoConstruccion + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialAseoConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialAseoConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialAseoConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialAseoConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchInicialAseoConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialAseoConstruccion[" + indiceFilaFormulario + "]' id='difFchInicialAseoConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalAseoConstruccionPry[" + indiceFilaFormulario + "]' id='fchFinalAseoConstruccionPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalAseoConstruccion + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalAseoConstruccionSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalAseoConstruccionSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalAseoConstruccionSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalAseoConstruccionPry[" + indiceFilaFormulario + "]\"), \"difFchFinalAseoConstruccion[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalAseoConstruccion[" + indiceFilaFormulario + "]' id='difFchFinalAseoConstruccion[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncAseoConstruccionPry[" + indiceFilaFormulario + "]' id='porcIncAseoConstruccionPry[" + indiceFilaFormulario + "]' value='" + porcIncAseoConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncAseoConstruccionSeg[" + indiceFilaFormulario + "]' id='porcIncAseoConstruccionSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncAseoConstruccionPry[" + indiceFilaFormulario + "]\"), \"difPorcIncAseoConstruccion[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActAseoConstruccionSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncAseoConstruccion[" + indiceFilaFormulario + "]' id='difPorcIncAseoConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActAseoConstruccionPry[" + indiceFilaFormulario + "]' id='valActAseoConstruccionPry[" + indiceFilaFormulario + "]' value='" + valActAseoConstruccion + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActAseoConstruccionSeg[" + indiceFilaFormulario + "]' id='valActAseoConstruccionSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActAseoConstruccionPry[" + indiceFilaFormulario + "]\"), \"difValActAseoConstruccion[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActAseoConstruccion[" + indiceFilaFormulario + "]' id='difValActAseoConstruccion[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    //////////////////////////////////////////////////// URBANISMO //////////////////////////////////////////////////////
    contenido += "<tr><td class='tituloNivel0' colspan='9'>Urbanismo</td></tr>";
    // PRELIMINARES (URBANISMO)
    contenido += "<tr class='fila_0'><td class='tituloNivel1'>Preliminares</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialPreliminarUrbanismoPry[" + indiceFilaFormulario + "]' id='fchInicialPreliminarUrbanismoPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialPreliminarUrbanismo + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialPreliminarUrbanismoSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialPreliminarUrbanismoSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialPreliminarUrbanismoSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialPreliminarUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difFchInicialPreliminarUrbanismo[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialPreliminarUrbanismo[" + indiceFilaFormulario + "]' size='6' style='text-align:right' id='difFchInicialPreliminarUrbanismo[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalPreliminarUrbanismoPry[" + indiceFilaFormulario + "]' id='fchFinalPreliminarUrbanismoPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalPreliminarUrbanismo + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalPreliminarUrbanismoSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalPreliminarUrbanismoSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalPreliminarUrbanismoSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalPreliminarUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difFchFinalPreliminarUrbanismo[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalPreliminarUrbanismo[" + indiceFilaFormulario + "]' id='difFchFinalPreliminarUrbanismo[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncPreliminarUrbanismoPry[" + indiceFilaFormulario + "]' id='porcIncPreliminarUrbanismoPry[" + indiceFilaFormulario + "]' value='" + porcIncPreliminarUrbanismo + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncPreliminarUrbanismoSeg[" + indiceFilaFormulario + "]' id='porcIncPreliminarUrbanismoSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncPreliminarUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difPorcIncPreliminarUrbanismo[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActPreliminarUrbanismoSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncPreliminarUrbanismo[" + indiceFilaFormulario + "]' id='difPorcIncPreliminarUrbanismo[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActPreliminarUrbanismoPry[" + indiceFilaFormulario + "]' id='valActPreliminarUrbanismoPry[" + indiceFilaFormulario + "]' value='" + valActPreliminarUrbanismo + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActPreliminarUrbanismoSeg[" + indiceFilaFormulario + "]' id='valActPreliminarUrbanismoSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActPreliminarUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difValActPreliminarUrbanismo[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActPreliminarUrbanismo[" + indiceFilaFormulario + "]' id='difValActPreliminarUrbanismo[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // CIMENTACION (URBANISMO)
    contenido += "<tr class='fila_1'><td class='tituloNivel1'>Cimentaci&oacute;n</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialCimentacionUrbanismoPry[" + indiceFilaFormulario + "]' id='fchInicialCimentacionUrbanismoPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialCimentacionUrbanismo + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialCimentacionUrbanismoSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialCimentacionUrbanismoSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialCimentacionUrbanismoSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialCimentacionUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difFchInicialCimentacionUrbanismo[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialCimentacionUrbanismo[" + indiceFilaFormulario + "]' id='difFchInicialCimentacionUrbanismo[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalCimentacionUrbanismoPry[" + indiceFilaFormulario + "]' id='fchFinalCimentacionUrbanismoPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalCimentacionUrbanismo + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalCimentacionUrbanismoSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalCimentacionUrbanismoSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalCimentacionUrbanismoSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalCimentacionUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difFchFinalCimentacionUrbanismo[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalCimentacionUrbanismo[" + indiceFilaFormulario + "]' id='difFchFinalCimentacionUrbanismo[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncCimentacionUrbanismoPry[" + indiceFilaFormulario + "]' id='porcIncCimentacionUrbanismoPry[" + indiceFilaFormulario + "]' value='" + porcIncCimentacionUrbanismo + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncCimentacionUrbanismoSeg[" + indiceFilaFormulario + "]' id='porcIncCimentacionUrbanismoSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncCimentacionUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difPorcIncCimentacionUrbanismo[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActCimentacionUrbanismoSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncCimentacionUrbanismo[" + indiceFilaFormulario + "]' id='difPorcIncCimentacionUrbanismo[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActCimentacionUrbanismoPry[" + indiceFilaFormulario + "]' id='valActCimentacionUrbanismoPry[" + indiceFilaFormulario + "]' value='" + valActCimentacionUrbanismo + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActCimentacionUrbanismoSeg[" + indiceFilaFormulario + "]' id='valActCimentacionUrbanismoSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActCimentacionUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difValActCimentacionUrbanismo[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActCimentacionUrbanismo[" + indiceFilaFormulario + "]' id='difValActCimentacionUrbanismo[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // DESAGUES (URBANISMO)
    contenido += "<tr class='fila_0'><td class='tituloNivel1'>Desag&uuml;es e instalaciones sanitarias</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialDesaguesUrbanismoPry[" + indiceFilaFormulario + "]' id='fchInicialDesaguesUrbanismoPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialDesaguesUrbanismo + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialDesaguesUrbanismoSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialDesaguesUrbanismoSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialDesaguesUrbanismoSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialDesaguesUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difFchInicialDesaguesUrbanismo[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialDesaguesUrbanismo[" + indiceFilaFormulario + "]' id='difFchInicialDesaguesUrbanismo[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalDesaguesUrbanismoPry[" + indiceFilaFormulario + "]' id='fchFinalDesaguesUrbanismoPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalDesaguesUrbanismo + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalDesaguesUrbanismoSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalDesaguesUrbanismoSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalDesaguesUrbanismoSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalDesaguesUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difFchFinalDesaguesUrbanismo[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalDesaguesUrbanismo[" + indiceFilaFormulario + "]' id='difFchFinalDesaguesUrbanismo[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncDesaguesUrbanismoPry[" + indiceFilaFormulario + "]' id='porcIncDesaguesUrbanismoPry[" + indiceFilaFormulario + "]' value='" + porcIncDesaguesUrbanismo + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncDesaguesUrbanismoSeg[" + indiceFilaFormulario + "]' id='porcIncDesaguesUrbanismoSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncDesaguesUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difPorcIncDesaguesUrbanismo[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActDesaguesUrbanismoSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncDesaguesUrbanismo[" + indiceFilaFormulario + "]' id='difPorcIncDesaguesUrbanismo[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActDesaguesUrbanismoPry[" + indiceFilaFormulario + "]' id='valActDesaguesUrbanismoPry[" + indiceFilaFormulario + "]' value='" + valActDesaguesUrbanismo + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActDesaguesUrbanismoSeg[" + indiceFilaFormulario + "]' id='valActDesaguesUrbanismoSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActDesaguesUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difValActDesaguesUrbanismo[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActDesaguesUrbanismo[" + indiceFilaFormulario + "]' id='difValActDesaguesUrbanismo[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // VIAS Y ANDENES (URBANISMO)
    contenido += "<tr class='fila_1'><td class='tituloNivel1'>Estructura en concreto</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialViasUrbanismoPry[" + indiceFilaFormulario + "]' id='fchInicialViasUrbanismoPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialViasUrbanismo + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialViasUrbanismoSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialViasUrbanismoSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialViasUrbanismoSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialViasUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difFchInicialViasUrbanismo[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialViasUrbanismo[" + indiceFilaFormulario + "]' id='difFchInicialViasUrbanismo[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalViasUrbanismoPry[" + indiceFilaFormulario + "]' id='fchFinalViasUrbanismoPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalViasUrbanismo + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalViasUrbanismoSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalViasUrbanismoSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalViasUrbanismoSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalViasUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difFchFinalViasUrbanismo[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalViasUrbanismo[" + indiceFilaFormulario + "]' id='difFchFinalViasUrbanismo[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncViasUrbanismoPry[" + indiceFilaFormulario + "]' id='porcIncViasUrbanismoPry[" + indiceFilaFormulario + "]' value='" + porcIncViasUrbanismo + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncViasUrbanismoSeg[" + indiceFilaFormulario + "]' id='porcIncViasUrbanismoSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncViasUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difPorcIncViasUrbanismo[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActViasUrbanismoSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncViasUrbanismo[" + indiceFilaFormulario + "]' id='difPorcIncViasUrbanismo[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActViasUrbanismoPry[" + indiceFilaFormulario + "]' id='valActViasUrbanismoPry[" + indiceFilaFormulario + "]' value='" + valActViasUrbanismo + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActViasUrbanismoSeg[" + indiceFilaFormulario + "]' id='valActViasUrbanismoSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActViasUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difValActViasUrbanismo[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActViasUrbanismo[" + indiceFilaFormulario + "]' id='difValActViasUrbanismo[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // PARQUES Y CESIONES (URBANISMO)
    contenido += "<tr class='fila_0'><td class='tituloNivel1'>Mamposter&iacute;a</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialParquesUrbanismoPry[" + indiceFilaFormulario + "]' id='fchInicialParquesUrbanismoPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialParquesUrbanismo + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialParquesUrbanismoSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialParquesUrbanismoSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialParquesUrbanismoSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialParquesUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difFchInicialParquesUrbanismo[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialParquesUrbanismo[" + indiceFilaFormulario + "]' id='difFchInicialParquesUrbanismo[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalParquesUrbanismoPry[" + indiceFilaFormulario + "]' id='fchFinalParquesUrbanismoPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalParquesUrbanismo + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalParquesUrbanismoSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalParquesUrbanismoSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalParquesUrbanismoSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalParquesUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difFchFinalParquesUrbanismo[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalParquesUrbanismo[" + indiceFilaFormulario + "]' id='difFchFinalParquesUrbanismo[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncParquesUrbanismoPry[" + indiceFilaFormulario + "]' id='porcIncParquesUrbanismoPry[" + indiceFilaFormulario + "]' value='" + porcIncParquesUrbanismo + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncParquesUrbanismoSeg[" + indiceFilaFormulario + "]' id='porcIncParquesUrbanismoSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncParquesUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difPorcIncParquesUrbanismo[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActParquesUrbanismoSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncParquesUrbanismo[" + indiceFilaFormulario + "]' id='difPorcIncParquesUrbanismo[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActParquesUrbanismoPry[" + indiceFilaFormulario + "]' id='valActParquesUrbanismoPry[" + indiceFilaFormulario + "]' value='" + valActParquesUrbanismo + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActParquesUrbanismoSeg[" + indiceFilaFormulario + "]' id='valActParquesUrbanismoSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActParquesUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difValActParquesUrbanismo[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActParquesUrbanismo[" + indiceFilaFormulario + "]' id='difValActParquesUrbanismo[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    // ASEO (URBANISMO)
    contenido += "<tr class='fila_1'><td class='tituloNivel1'>Aseo</td>";
    // Fecha Inicial Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchInicialAseoUrbanismoPry[" + indiceFilaFormulario + "]' id='fchInicialAseoUrbanismoPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchInicialAseoUrbanismo + "'></td>";
    // Fecha Inicial Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchInicialAseoUrbanismoSeg[" + indiceFilaFormulario + "]' type='text' id='fchInicialAseoUrbanismoSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchInicialAseoUrbanismoSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchInicialAseoUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difFchInicialAseoUrbanismo[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Inicial Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchInicialAseoUrbanismo[" + indiceFilaFormulario + "]' id='difFchInicialAseoUrbanismo[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Fecha Final Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='fchFinalAseoUrbanismoPry[" + indiceFilaFormulario + "]' id='fchFinalAseoUrbanismoPry[" + indiceFilaFormulario + "]' size='10' class='campoReadonly' readonly value='" + fchFinalAseoUrbanismo + "'></td>";
    // Fecha Final Ejecutada
    contenido += "<td align='center' valign='top'><input name='fchFinalAseoUrbanismoSeg[" + indiceFilaFormulario + "]' type='text' id='fchFinalAseoUrbanismoSeg[" + indiceFilaFormulario + "]' size='10' style='text-align:center' readonly /><a href='#' onClick='javascript: calendarioPopUpCalcula( \"fchFinalAseoUrbanismoSeg[" + indiceFilaFormulario + "]\", document.getElementById(\"fchFinalAseoUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difFchFinalAseoUrbanismo[" + indiceFilaFormulario + "]\" ); '><img src='recursos/imagenes/calendar_icon_tr.gif'></a></td>";
    // Diferencia Fecha Final Ejecutada y Proyectada
    contenido += "<td class='fechaNivel1' valign='top'><input type='text' name='difFchFinalAseoUrbanismo[" + indiceFilaFormulario + "]' id='difFchFinalAseoUrbanismo[" + indiceFilaFormulario + "]' size='6' style='text-align:right' readonly></td>";
    // Porcentaje Proyectado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncAseoUrbanismoPry[" + indiceFilaFormulario + "]' id='porcIncAseoUrbanismoPry[" + indiceFilaFormulario + "]' value='" + porcIncAseoUrbanismo + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Porcentaje Ejecutado
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='porcIncAseoUrbanismoSeg[" + indiceFilaFormulario + "]' id='porcIncAseoUrbanismoSeg[" + indiceFilaFormulario + "]' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"porcIncAseoUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difPorcIncAseoUrbanismo[" + indiceFilaFormulario + "]\"); valorActividadEjecutado(this, \"valActAseoUrbanismoSeg[" + indiceFilaFormulario + "]\");' class='campoPesos' size='12'></td>";
    // Diferencia Porcentaje
    contenido += "<td class='campoNivel1' valign='top'><input type='text' name='difPorcIncAseoUrbanismo[" + indiceFilaFormulario + "]' id='difPorcIncAseoUrbanismo[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td>";
    // Valor Proyectado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActAseoUrbanismoPry[" + indiceFilaFormulario + "]' id='valActAseoUrbanismoPry[" + indiceFilaFormulario + "]' value='" + valActAseoUrbanismo + "' class='campoPesosReadonly' size='12' readonly></td>";
    // Valor Ejecutado
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='valActAseoUrbanismoSeg[" + indiceFilaFormulario + "]' id='valActAseoUrbanismoSeg[" + indiceFilaFormulario + "]' class='campoPesos' size='12' onBlur='sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById(\"valActAseoUrbanismoPry[" + indiceFilaFormulario + "]\"), \"difValActAseoUrbanismo[" + indiceFilaFormulario + "]\");' ></td>";
    // Diferencia Valor
    contenido += "<td class='campoNivel1' valign='top'>$ <input type='text' name='difValActAseoUrbanismo[" + indiceFilaFormulario + "]' id='difValActAseoUrbanismo[" + indiceFilaFormulario + "]' class='campoPesos' size='12' readonly ></td></tr>";
    contenido += "</table></div></div></td>";
    myNewCell.innerHTML = contenido;
    myNewCell = myNewRow.insertCell(-1);
    myNewCell.setAttribute("align", "center");
    myNewCell.setAttribute("valign", "top");
    myNewCell.setAttribute("style", "padding:6px");
    myNewCell.innerHTML = "<td><input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'></td>";
    indiceFilaFormulario++;
}

function sumaVentas() {
    var fila = 0;
    var filab = 0;
    var valSumaVentas = 0;
    var valSumaVentasNuevas = 0;
    var objValTotalVentas = document.getElementById("valTotalVentas");
    // Valores de lineas existentes
    var a;
    for (fila = 1; fila < 50; fila++) {
        if (!document.getElementById("numCantidadr_" + fila)) {
            a = 0;
        } else {
            valorCantidad = document.getElementById("numCantidadr_" + fila).value;
            valorVenta = document.getElementById("valPrecioVentar_" + fila).value;
            valSumaVentas += (parseInt(valorCantidad) * parseInt(valorVenta));
        }
    }
    // Valores de lineas nuevas
    var b;
    for (filab = 1; filab < 50; filab++) {
        if (!document.getElementById("numCantidad_" + filab)) {
            b = 0;
        } else {
            valorCantidadNueva = document.getElementById("numCantidad_" + filab).value;
            valorVentaNueva = document.getElementById("valPrecioVenta_" + filab).value;
            valSumaVentasNuevas += (parseInt(valorCantidadNueva) * parseInt(valorVentaNueva));
        }
    }
    // Suma Totales
    objValTotalVentas.value = valSumaVentas + valSumaVentasNuevas;

    // Calcula nueva utilidad
    calculaUtilidad();
}

function sumaTotalCostos() {
    if ((document.getElementById("valCostosDirectos").value) == '' || (document.getElementById("valCostosDirectos").value) == 0) {
        var valDirectos = 0;
    } else {
        var valDirectos = document.getElementById("valCostosDirectos").value;
    }
    if ((document.getElementById("valCostosIndirectos").value) == '' || (document.getElementById("valCostosIndirectos").value) == 0) {
        var valIndirectos = 0;
    } else {
        var valIndirectos = document.getElementById("valCostosIndirectos").value;
    }
    if ((document.getElementById("valTerreno").value) == '' || (document.getElementById("valTerreno").value) == 0) {
        var valTerreno = 0;
    } else {
        var valTerreno = document.getElementById("valTerreno").value;
    }
    if ((document.getElementById("valGastosFinancieros").value) == '' || (document.getElementById("valGastosFinancieros").value) == 0) {
        var valFinanciero = 0;
    } else {
        var valFinanciero = document.getElementById("valGastosFinancieros").value;
    }
    if ((document.getElementById("valGastosVentas").value) == '' || (document.getElementById("valGastosVentas").value) == 0) {
        var valVentas = 0;
    } else {
        var valVentas = document.getElementById("valGastosVentas").value;
    }

    var objValTotalCostos = document.getElementById("valTotalCostos");

    var valSumaCostos = 0;

    valSumaCostos += parseInt(valDirectos);
    valSumaCostos += parseInt(valIndirectos);
    valSumaCostos += parseInt(valTerreno);
    valSumaCostos += parseInt(valFinanciero);
    valSumaCostos += parseInt(valVentas);

    objValTotalCostos.value = valSumaCostos;

    // Calcula nueva utilidad
    calculaUtilidad();
}

function calculaUtilidad() {
    var valCalculaUtilidad = 0;
    if ((document.getElementById("valTotalVentas").value) == '' || (document.getElementById("valTotalVentas").value) == 0) {
        var valTotalVentas = 0;
    } else {
        var valTotalVentas = document.getElementById("valTotalVentas").value;
    }
    if ((document.getElementById("valTotalCostos").value) == '' || (document.getElementById("valTotalCostos").value) == 0) {
        var valTotalCostos = 0;
    } else {
        var valTotalCostos = document.getElementById("valTotalCostos").value;
    }

    var objvalUtilidadProyecto = document.getElementById("valUtilidadProyecto");

    valCalculaUtilidad = valTotalVentas - valTotalCostos;
    objvalUtilidadProyecto.value = valCalculaUtilidad;
}

function sumaTotalRecursos() {
    if ((document.getElementById("valRecursosPropios").value) == '' || (document.getElementById("valRecursosPropios").value) == 0) {
        var valRecursosPropios = 0;
    } else {
        var valRecursosPropios = document.getElementById("valRecursosPropios").value;
    }
    if ((document.getElementById("valCreditoEntidadFinanciera").value) == '' || (document.getElementById("valCreditoEntidadFinanciera").value) == 0) {
        var valCreditoEntidadFinanciera = 0;
    } else {
        var valCreditoEntidadFinanciera = document.getElementById("valCreditoEntidadFinanciera").value;
    }
    if ((document.getElementById("valCreditoParticulares").value) == '' || (document.getElementById("valCreditoParticulares").value) == 0) {
        var valCreditoParticulares = 0;
    } else {
        var valCreditoParticulares = document.getElementById("valCreditoParticulares").value;
    }
    if ((document.getElementById("valVentasProyecto").value) == '' || (document.getElementById("valVentasProyecto").value) == 0) {
        var valVentasProyecto = 0;
    } else {
        var valVentasProyecto = document.getElementById("valVentasProyecto").value;
    }
    if ((document.getElementById("valSDVE").value) == '' || (document.getElementById("valSDVE").value) == 0) {
        var valSDVE = 0;
    } else {
        var valSDVE = document.getElementById("valSDVE").value;
    }
    if ((document.getElementById("valOtros").value) == '' || (document.getElementById("valOtros").value) == 0) {
        var valOtros = 0;
    } else {
        var valOtros = document.getElementById("valOtros").value;
    }
    if ((document.getElementById("valDevolucionIVA").value) == '' || (document.getElementById("valDevolucionIVA").value) == 0) {
        var valDevolucionIVA = 0;
    } else {
        var valDevolucionIVA = document.getElementById("valDevolucionIVA").value;
    }

    var objValTotalRecursos = document.getElementById("valTotalRecursos");

    var valSumaRecursos = 0;
    valSumaRecursos += parseInt(valRecursosPropios);
    valSumaRecursos += parseInt(valCreditoEntidadFinanciera);
    valSumaRecursos += parseInt(valCreditoParticulares);
    valSumaRecursos += parseInt(valVentasProyecto);
    valSumaRecursos += parseInt(valSDVE);
    valSumaRecursos += parseInt(valOtros);
    valSumaRecursos += parseInt(valDevolucionIVA);

    objValTotalRecursos.value = valSumaRecursos;
}

function confirmaRemoverLineaFormulario(formObj) {
    if (!confirm(" Está seguro de eliminar el registro seleccionado?")) {
        return false;
    } else {
        removerLineaFormulario(formObj);
        return false;
    }
}

function obtenerDatosProyecto(objSelect, seqPlanGobierno) {

    var mensajes = YAHOO.util.Dom.get('mensajes');

    var fncExito = function (objRespuesta) {

        eval(objRespuesta.responseText);

        var objDireccionSolucion = YAHOO.util.Dom.get('txtDireccionSolucion');
        var objMatriculaInmobiliaria = YAHOO.util.Dom.get('txtMatriculaInmobiliaria');
        var objChip = YAHOO.util.Dom.get('txtChip');
        var objEsquema = YAHOO.util.Dom.get('seqTipoEsquema');
        objDireccionSolucion.value = txtDireccion;
        objMatriculaInmobiliaria.value = txtMatriculaInmobiliaria;
        objChip.value = txtChip;
        objEsquema.value = seqTipoEsquema;
        /*
         // FUNCIONA PERFECTO
         if(objEsquema.value == 1){
         document.getElementById("divEsqIndiv").style.display = "block";
         document.getElementById("divEsqOtros").style.display = "none";
         document.getElementById("divEsqDefault").style.display = "none";
         } else {
         document.getElementById("divEsqIndiv").style.display = "none";
         document.getElementById("divEsqOtros").style.display = "block";
         document.getElementById("divEsqDefault").style.display = "none";
         }*/
        if (objEsquema.value == 1) {
            if (document.getElementById("seqProyecto").value == 4) {
                document.getElementById("divEsqIndiv").style.display = "none";
                document.getElementById("divEsqOtros").style.display = "block";
                document.getElementById("divEsqDefault").style.display = "none";
                objMatriculaInmobiliaria.readOnly = false;
                objChip.readOnly = false;
            } else {
                document.getElementById("divEsqIndiv").style.display = "block";
                document.getElementById("divEsqOtros").style.display = "none";
                document.getElementById("divEsqDefault").style.display = "none";
                objMatriculaInmobiliaria.readOnly = true;
                objChip.readOnly = true;
            }
        } else {
            document.getElementById("divEsqIndiv").style.display = "none";
            document.getElementById("divEsqOtros").style.display = "block";
            document.getElementById("divEsqDefault").style.display = "none";
            objMatriculaInmobiliaria.readOnly = false;
            objChip.readOnly = false;
        }
    }

    var fncFalla = function (objRespuesta) {
        alert(objRespuesta.status + ": " + objRespuesta.statusText);
    }

    var objRetorno = {
        success: fncExito,
        failure: fncFalla
    }

    YAHOO.util.Connect.asyncRequest(
            "POST",
            "./contenidos/postulacionIndividual/datosProyectos.php",
            objRetorno,
            "seqProyecto=" + objSelect.options[ objSelect.selectedIndex ].value + "&seqPlanGobierno=" + seqPlanGobierno
            );

}

function removerLineaFormulario(obj) {
    var oTr = obj;
    while (oTr.nodeName.toLowerCase() != 'tr') {
        oTr = oTr.parentNode;
    }
    var root = oTr.parentNode;
    root.removeChild(oTr);
}

function eliminarRegistroProyectos(seqRegistro, txtPregunta, txtArchivo) {

    // Objeto que contiene los atributos del cuadro de dialogo
    var objAtributos = {
        width: "300px",
        effect: {
            effect: YAHOO.widget.ContainerEffect.FADE,
            duration: 0.75
        },
        fixedcenter: true,
        modal: true,
        draggable: true,
        close: false
    }

    // INSTANCIA EL OBJETO DIALOGO
    var objDialogo = new YAHOO.widget.SimpleDialog("dlg", objAtributos);

    objDialogo.setHeader("Atencion Requerida !!"); // encabezado del objeto
    objDialogo.setBody(txtPregunta);			   // texto que se muestra en el cuerpo (formato html)
    objDialogo.cfg.setProperty("icon", YAHOO.widget.SimpleDialog.ICON_WARN); // Icono de advertencia que se ve en el cuadro

    // COMPORTAMIENTO SI SE PRESIONA -- SI -- EN EL CUADRO
    var handleYes = function () {

        // Envia los datos el archivo que contesta la peticion de borrado
        cargarContenido("mensajes", txtArchivo, "seqBorrar=" + seqRegistro, true);

        // cuando la respuesta esta lista, verifica por medio de la clase (css)
        // si la respuesta es satisfactoria, de ser asi, elimina de la pantalla el 
        // objeto que contiene el registro en pantalla
        YAHOO.util.Event.onContentReady(
                "tablaMensajes",
                function () {
                    // Cambiar 'msgOk' si la clase (css) que muestra los mensajes satisfactorios no se llama asi
                    if (document.getElementById('tablaMensajes').className == "msgOk") {
                        eliminarObjeto(seqRegistro);
                    }
                }
        );

        this.hide(); // oculta el objeto de confirmacion
    }

    // COMPORTAMIENTO SI SE PRESIONA -- NO -- EN EL CUADRO
    var handleNo = function () {
        document.getElementById("mensajes").innerHTML = "";
        this.hide();
    }

    // Botones para aÃ±adir al cuadro de dialogo
    // No poner esto antes de la declartacion de los manejadores
    var arrBotones = [
        {
            text: "Si",
            handler: handleYes
        },
        {
            text: "No",
            handler: handleNo,
            isDefault: true
        }
    ];

    objDialogo.cfg.queueProperty("buttons", arrBotones);

    // Muestra el cuadro de dialogo
    objDialogo.render(document.body);
    objDialogo.show();

}

function muestraProrrogaUrbanismo() {
    if (document.getElementById("lineaProrrogaUrbanismo").style.display == "none") {
        document.getElementById("lineaProrrogaUrbanismo").style.display = "table-row";
    } else {
        document.getElementById("lineaProrrogaUrbanismo").style.display = "none";
    }
}

function sumaMesVencimiento(days) {
    var days = days - 1;
    var fechaEjecutoria = document.getElementById("fchEjecutaLicConstruccion").value;
    var objFchVenceLicConstruccion = document.getElementById("fchVenceLicConstruccion");
    if (fechaEjecutoria.substr(6, 1) == "-") {
        var Parte1 = fechaEjecutoria.substr(0, 5);
        var Parte2 = "0"
        var Parte3 = fechaEjecutoria.substr(5, 5);
        var fechaEjecutoriaNueva = Parte1 + Parte2 + Parte3;
    } else {
        var fechaEjecutoriaNueva = fechaEjecutoria;
    }

    ms = Date.parse(fechaEjecutoriaNueva);
    fecha = new Date(ms);
    dayx = fecha.getDate();
    monthx = fecha.getMonth() + 1;
    yearx = fecha.getFullYear();

    tiempo = fecha.getTime();
    milisegundos = parseInt(days * 24 * 60 * 60 * 1000);
    total = fecha.setTime(tiempo + milisegundos);
    dayx = fecha.getDate();
    monthx = fecha.getMonth() + 1;
    yearx = fecha.getFullYear();

    var fechaVencimiento = yearx + "-" + monthx + "-" + dayx;
    objFchVenceLicConstruccion.value = fechaVencimiento;
}

function sumaMesVencimientoProrroga(days) {
    var fechaEjecutoriaProrroga = document.getElementById("fchEjecutaProrrogaLicConstruccion").value;
    var objFchVenceProrrogaLicConstruccion = document.getElementById("fchVenceProrrogaLicConstruccion");
    if (fechaEjecutoriaProrroga.substr(6, 1) == "-") {
        var Parte1 = fechaEjecutoriaProrroga.substr(0, 5);
        var Parte2 = "0"
        var Parte3 = fechaEjecutoriaProrroga.substr(5, 5);
        var fechaEjecutoriaNueva = Parte1 + Parte2 + Parte3;
    } else {
        var fechaEjecutoriaNueva = fechaEjecutoriaProrroga;
    }

    ms = Date.parse(fechaEjecutoriaNueva);
    fecha = new Date(ms);
    dayx = fecha.getDate();
    monthx = fecha.getMonth() + 1;
    yearx = fecha.getFullYear();

    tiempo = fecha.getTime();
    milisegundos = parseInt(days * 24 * 60 * 60 * 1000);
    total = fecha.setTime(tiempo + milisegundos);
    dayx = fecha.getDate();
    monthx = fecha.getMonth() + 1;
    yearx = fecha.getFullYear();

    var fechaVencimientoProrroga = yearx + "-" + monthx + "-" + dayx;
    objFchVenceProrrogaLicConstruccion.value = fechaVencimientoProrroga;
}

function sumaMesVencimientoRevalidacion(days) {
    var fechaEjecutoriaRevalidacion = document.getElementById("fchEjecutaRevalidacionLicConstruccion").value;
    var objFchVenceRevalidacionLicConstruccion = document.getElementById("fchVenceRevalidacionLicConstruccion");
    if (fechaEjecutoriaRevalidacion.substr(6, 1) == "-") {
        var Parte1 = fechaEjecutoriaRevalidacion.substr(0, 5);
        var Parte2 = "0"
        var Parte3 = fechaEjecutoriaRevalidacion.substr(5, 5);
        var fechaEjecutoriaNueva = Parte1 + Parte2 + Parte3;
    } else {
        var fechaEjecutoriaNueva = fechaEjecutoriaRevalidacion;
    }

    ms = Date.parse(fechaEjecutoriaNueva);
    fecha = new Date(ms);
    dayx = fecha.getDate();
    monthx = fecha.getMonth() + 1;
    yearx = fecha.getFullYear();

    tiempo = fecha.getTime();
    milisegundos = parseInt(days * 24 * 60 * 60 * 1000);
    total = fecha.setTime(tiempo + milisegundos);
    dayx = fecha.getDate();
    monthx = fecha.getMonth() + 1;
    yearx = fecha.getFullYear();

    var fechaVencimientoRevalidacion = yearx + "-" + monthx + "-" + dayx;
    objFchVenceRevalidacionLicConstruccion.value = fechaVencimientoRevalidacion;
}

// Muestra la linea Descripcion contrato de interventoría 
function escondeLineaObservacionesContratoInterventoria() {
    if (document.getElementById("optVoBoContratoInterventoria").value == 2) {
        document.getElementById("lineaObservacionesContratoInterventoria").style.display = "table-row";
    } else {
        document.getElementById("lineaObservacionesContratoInterventoria").style.display = "none";
        document.getElementById("txtObservacionesContratoInterventoria").value = "";
    }
}

// Calcula el valor de la actividad según el porcentaje y el Costo Total del Proyecto
function calculaActividadSegunCosto(porcentaje, campoDestino) {
    var valorPorcentaje = porcentaje.value;
    var valorCosto = document.getElementById("valTotalCostos").value;
    var valor = valorPorcentaje * valorCosto;
    document.getElementById(campoDestino).value = valor;
}

// Calcula el porcentaje de la actividad según el valor de la actividad sobre el Costo Total del Proyecto
function calculaPorcentajeSegunValorCosto(valor, campoDestino) {
    var valorCampo = valor.value;
    var valorCosto = document.getElementById("valTotalCostos").value;
    var porcentaje = valorCampo / valorCosto * 100;
    document.getElementById(campoDestino).value = porcentaje;
}

/*function complementaDireccion(){
 var direccionBase = document.getElementById("txtDireccionSolucion").value;
 document.getElementById("txtDireccionSolucion").value = "";
 var e = document.getElementById("seqUnidadProyecto");
 var strUser = e.options[e.selectedIndex].text;
 var complemento = " - " + strUser;
 document.getElementById("txtDireccionSolucion").value = direccionBase + complemento;
 }*/

//<![CDATA[
var accordionItems = new Array();
function init() {
    // Grab the accordion items from the page
    var divs = document.getElementsByTagName('div');
    for (var i = 0; i < divs.length; i++) {
        if (divs[i].className == 'accordionItem')
            accordionItems.push(divs[i]);
    }
    // Assign onclick events to the accordion item headings
    for (var i = 0; i < accordionItems.length; i++) {
        var h2 = getFirstChildWithTagName(accordionItems[i], 'H2');
        h2.onclick = toggleItem;
    }
    // Hide all accordion item bodies except the first
    for (var i = 1; i < accordionItems.length; i++) {
        accordionItems[i].className = 'accordionItem hide';
        $(accordionItems[i]).find('div').slideUp();
    }
}

function toggleItem() {
    var itemClass = this.parentNode.className;

    // Hide all items
    for (var i = 0; i < accordionItems.length; i++) {
        accordionItems[i].className = 'accordionItem hide';
        $(accordionItems[i]).find('div').slideUp();
    }

    // Show this item if it was previously hidden
    if (itemClass == 'accordionItem hide') {
        this.parentNode.className = 'accordionItem';
        $(this).parent().find('div').slideDown();
    }
}

function getFirstChildWithTagName(element, tagName) {
    for (var i = 0; i < element.childNodes.length; i++) {
        if (element.childNodes[i].nodeName == tagName)
            return element.childNodes[i];
    }
}
//]]>

function verInformacionActoUnidad(seqActo) {

    var numAncho = YAHOO.util.Dom.getClientWidth() - 900;
    var numAlto = YAHOO.util.Dom.getClientHeight() - 300;

    // Objeto de respuesta si es satisfactoria la carga
    var handleSuccess =
            function (o) {
                if (o.responseText !== undefined) {

                    var objConfiguracion = {
                        width: numAncho,
                        height: numAlto,
                        fixedcenter: true,
                        close: true,
                        draggable: true,
                        modal: true,
                        visible: false
                    }

                    var objPanel = new YAHOO.widget.Panel(
                            "cambios",
                            objConfiguracion
                            );

                    objPanel.setHeader("Ver Información del Acto");
                    objPanel.setBody(o.responseText);

                    objPanel.render(document.body);
                    objPanel.show();

                }
            };

    // Objeto de respuesta si la carga falla
    var handleFailure =
            function (o) {
                if (o.responseText !== undefined) {

                    // Cuando se vence la sesion la respuesta es HTTP 401 = Not Authorized
                    if (o.status == "401") {
                        document.location = 'index.php';
                    } else {

                        // Mensaje cuando la pagina no es encontrada
                        var htmlCode = "";
                        htmlCode = +o.status + " " + o.statusText;

                        // Otros mensajes de error son mostrados directamente en el div
                        document.getElementById("mensajes").innerHTML = htmlCode;
                    }
                    return false;
                }
            };

    // Objeto de respuestas
    var callback = {
        success: handleSuccess,
        failure: handleFailure
    };

    // peticion asincrona al servidor
    var callObj = YAHOO.util.Connect.asyncRequest("POST", "./contenidos/actosUnidades/verActoUnidad.php", callback, "seqActo=" + seqActo + "&alto=" + numAlto);

}

function construccionArchivoIndexacion(txtObjetoSelect) {

    var objSelect = YAHOO.util.Dom.get(txtObjetoSelect);

    var objPopUp = new YAHOO.widget.Panel(
            "pop",
            {
                width: "650px",
                fixedcenter: true,
                close: true,
                draggable: true,
                modal: true,
                visible: true
            }
    );

    var fncExito = function (objRespuesta) {
        objPopUp.setHeader("Instrucciones para la creación del archivo de carga");
        objPopUp.setBody(objRespuesta.responseText);
        objPopUp.render(document.body);
        objPopUp.show();
    }

    var fncFalla = function (objRespuesta) {
        objPopUp.setHeader("Error al abrir el documento");
        objPopUp.setBody(objRespuesta.status + ": " + objRespuesta.statusText);
        objPopUp.render(document.body);
        objPopUp.show();
    }

    var objRetorno = {
        success: fncExito,
        failure: fncFalla
    }

    YAHOO.util.Connect.asyncRequest(
            "POST",
            "./contenidos/actosUnidades/plantillaConstruccionIndexacion.php",
            objRetorno
            );
}

/*function certificadoHabitabilidadUnidades(seqFormulario) { //(SI NO SE USA BORRAR)
 YAHOO.util.Event.onContentReady(
 "tablaMensajes",
 function() {
 var objTabla = YAHOO.util.Dom.get("tablaMensajes");
 if (objTabla.className == "msgOk") {
 var wndFormato;
 try {
 
 //var txtUrl = "./contenidos/unidadProyecto/formatoRevisionTecnica.php";
 var txtUrl = "./contenidos/unidadProyecto/procesaCargaCartaHabitabilidad.php";
 txtUrl += "?seqFormulario=" + seqFormulario + txtCasaMano;
 var txtParametros = "resizable=0,location=0,scrollbars=1,width=780,height=700,left=100,top=100";
 
 if (!(wndFormato = window.open(txtUrl, '_blank', txtParametros))) {
 throw "ErrorPopUp";
 }
 } catch (objError) {
 if (objError == "ErrorPopUp") {
 alert("Ooops, al parecer tu navegador tiene bloqueado las ventanas emergentes, desactiva esa opcion y vuelve a intentar");
 }
 }
 }
 }
 );
 }*/

function certificadoHabitabilidadUnidades(seqFormulario) { //(SI NO SE USA BORRAR)
    var wndFormato;
    var txtUrl = "./contenidos/unidadProyecto/procesaCargaCartaHabitabilidad.php";
    txtUrl += "?seqFormulario=" + seqFormulario;
    var txtParametros = "resizable=0,location=0,scrollbars=1,width=780,height=700,left=100,top=100";

    if (!(wndFormato = window.open(txtUrl, '_blank', txtParametros))) {
        throw "ErrorPopUp";
    }
}

function selectAnidados(documento, valor) {

    var apr = "numAnosAprobados";
    var options = {
        0:  ["0"],
        1:  ["0"],
        2:  ["1", "2", "3", "4"],
        3:  ["5"],
        4:  ["6", "7", "8", "9", "10"],
        5:  ["11"],
        6:  ["6", "7", "8", "9", "10", "11"],
        7:  ["11"],
        8:  ["11"],
        9:  ["11"],
        12: ["11"]
    }

    $(function () {
        var fillSecondary = function () {
            $('#numAnosAprobados').empty();
            var selected = $('#nivelEducativo').val();

            options[selected].forEach(function (element, index) {
                $('#numAnosAprobados').append('<option value="' + element + '">' + element + '</option>');
            });
            if (document.getElementById(documento + '-numAnosAprobados')) {
                if (valor == 1 && document.getElementById(documento + '-numAnosAprobados').value != "") {
                    var anos = document.getElementById(documento + '-numAnosAprobados').value;
                    $('#numAnosAprobados').val(anos);
                }
            }
        }
        $('#nivelEducativo').change(fillSecondary);
        fillSecondary();
    });

}

function mostrarToolTip(){

    var objCartaLeasing = YAHOO.util.Dom.get("valCartaLeasing");
    var objSelect = YAHOO.util.Dom.get("seqConvenio");
    var selectedIndex = objSelect.selectedIndex;

    var fncSuccess = function(o){
        try {
            var objRespuesta = jQuery.parseJSON(o.responseText);
            objCartaLeasing.value = objRespuesta.valor;
            formatoSeparadores(objCartaLeasing);
            var objToolTip = new YAHOO.widget.Tooltip(
                "myToolTip",
                {
                    context: "seqConvenioToolTip",
                    width: "300px",
                    text: objRespuesta.convenio
                }
            );
            valorSubsidio();
        } catch (e) {
            console.log(o.responseText);
            console.log(e.message);
        }
    }

    var fncError = function(o){
        console.log("Error obteniendo el texto del convenio");
    }

    var callback =
        {
            success: fncSuccess,
            failure: fncError
        };

    var callObj = YAHOO.util.Connect.asyncRequest(
        "POST",
        "./contenidos/casaMano/textoConvenio.php",
        callback,
        "seqConvenio=" + objSelect.options[selectedIndex].value
    );

}

YAHOO.util.Event.onContentReady(
    "seqConvenioToolTip",
    function(){ mostrarToolTip(); }
);


function alertaFormularioCerrado( objBolCerrado , bolCerradoBaseDatos, bolPermisoAbrirFormularios ){
    var txtMensaje = "";
    if( bolCerradoBaseDatos == 1 ){
        if(objBolCerrado.checked == false){
            if(bolPermisoAbrirFormularios == 1){
                txtMensaje  = "<div class='msgError' style='font-size:12px; text-align:center;'>Va a intentar abrir un formulario cerrado, ésta acción implica los siguientes cambios:</div>";
                txtMensaje += "<p><li>Se perderá el numero de formulario</li>";
                txtMensaje += "<li>La fecha de postulación será eliminada</li>";
                txtMensaje += "<li>El hogar será devuelto a la etapa de inscripción</li>";
                txtMensaje += "</p>";
            }else{
                txtMensaje  = "<div class='msgError' style='font-size:12px; text-align:center;'>No tiene permisos para abrir formularios</div>";
                objBolCerrado.checked = true;
            }
        }
    }

    if(txtMensaje != ""){

        var handleOk = function () {
            this.cancel();
        }

        var objAtributos = {
            width: "330px",
            effect: {
                effect: YAHOO.widget.ContainerEffect.FADE,
                duration: 0.75
            },
            fixedcenter: true,
            zIndex: 1,
            visible: false,
            modal: true,
            draggable: true,
            close: false,
            text: txtMensaje,
            icon: YAHOO.widget.SimpleDialog.ICON_WARN,
            buttons: [
                {
                    text: "Aceptar",
                    handler: handleOk,
                    isDefault: true
                }
            ]
        }

        // INSTANCIA EL OBJETO DIALOGO
        var objDialogo1 = new YAHOO.widget.SimpleDialog("dlg", objAtributos);

        // Muestra el cuadro de dialogo
        objDialogo1.setHeader("Atención");
        objDialogo1.render(document.body);
        objDialogo1.show();

    }


}

/**
 *
 * @param txtCampo
 * @param txtValor
 */
function alertaDigitacionCampo(txtCampo,txtValor){

    var objAlerta = YAHOO.util.Dom.get(txtCampo);
    var txtMensaje = "";
    var valRetorno = txtValor;
    var bolAlerta = false;

    // verifica con los datos vivos (no los de la BD
    // si lo que se esta digitando supera los 2 salarios minimos
    // tomados de la lecturaConfiguracion a travez de un input hidden
    if( txtCampo == 'ingresos' ){

        var valDigitado = 0;
        var valSalarioHogarRestante = 0;
        var valNuevaSuma = 0;

        var numDocumento = 0;
        var objValIngresoHogar = null;
        var objSMMLV = null;
        var objDatosHogar = null;
        var arrTablasCiudadanos = null;
        var objIngresoCiudadano = null;

        // obtiene el valor digitado
        objAlerta.value = ( objAlerta.value == "" )? 0 : objAlerta.value;
        valDigitado = parseInt( objAlerta.value.replace(/[^0-9]/g,'') );

        // obtiene la suma de ingresos del resto del hogar
        // dado que cuando se presiona el boton de edicion
        // los datos del ciudadano ya no son accesibles
        objValIngresoHogar = YAHOO.util.Dom.get('valIngresoHogar');
        objSMMLV = YAHOO.util.Dom.get('valSMMLV');
        objDatosHogar = YAHOO.util.Dom.get('datosHogar');
        arrTablasCiudadanos = objDatosHogar.getElementsByTagName('table');
        for( i = 0 ; i < arrTablasCiudadanos.length ; i++ ){
            if( arrTablasCiudadanos[i].id != "" && ( ! isNaN( arrTablasCiudadanos[i].id ) ) ){
                numDocumento = arrTablasCiudadanos[i].id;
                objIngresoCiudadano = YAHOO.util.Dom.get( numDocumento + '-valIngresos' );
                valSalarioHogarRestante = parseInt(valSalarioHogarRestante + objIngresoCiudadano.value);
            }
        }

        // En caso de cancelar este es el valor original que tenia el ciudadano
        valRetorno =  parseInt(objValIngresoHogar.value.replace(/[^0-9]/g,'')) - valSalarioHogarRestante;

        // Ingreso de los miembros de hogar
        valNuevaSuma = parseInt( valDigitado + valSalarioHogarRestante );

        // Si la suma supera los dos salarios minimos
        if( valNuevaSuma > parseInt( objSMMLV.value * 2 ) ){
            bolAlerta = true;
            txtMensaje = "<li class='msgError'>El valor del ingreso que esta digitando lleva a que el hogar, en conjunto, supere los dos (2) SMMLV, ¿quiere continuar?</li>";
        }

        formatoSeparadores(objAlerta);
    }

    // no se permite el valor de cero hogares que habitan la vivienda
    // por encima de 10 se muestra una advertencia
    if( txtCampo == 'numHabitaciones' ){
        if( parseInt( objAlerta.value.replace(/[^0-9]/g,'') ) > 10 ){
            bolAlerta = true;
            txtMensaje = "<li class='msgError'>Esta afirmando que hay mas de 10 hogares en la misma vivienda, ¿quiere continuar?</li>";
        }
    }

    // si el numero de dormitorios supera los miembros de hogar se
    // muestra una advertencia
    if( txtCampo == 'numHacinamiento' ){

        var objDatosHogar = null;
        var arrTablasCiudadanos = null;
        var numMiembros = 0;
        var objAgregarMiembro = YAHOO.util.Dom.get("agregarMiembro");

        // verifica que no haya un ciudadano en modo de edicion en el formulario
        if( objAgregarMiembro != null && objAgregarMiembro.style.display != "none" ){
            bolAlerta = true;
            txtMensaje = "<li class='msgError'>Por favor verifique que los miembros de hogar se encuentren agregados correctamente.</li>";
        }

        // cuenta los miembros de hogar
        objDatosHogar = YAHOO.util.Dom.get('datosHogar');
        arrTablasCiudadanos = objDatosHogar.getElementsByTagName('table');
        for( i = 0 ; i < arrTablasCiudadanos.length ; i++ ){
            if( arrTablasCiudadanos[i].id != "" && ( ! isNaN( arrTablasCiudadanos[i].id ) ) ){
                numMiembros = numMiembros + 1;
            }
        }

        // si el numero de habitaciones supera el numero de miembros del hogar
        if( ( parseInt( objAlerta.value.replace(/[^0-9]/g,'') ) > numMiembros ) && txtMensaje == "" ){
            bolAlerta = true;
            txtMensaje = "<li class='msgError'>Hay mas dormitorios que miembros de hogar, ¿quiere continuar?</li>";
        }


    }






    if( bolAlerta == true ){

        var handleOk = function () {
            this.cancel();
        }

        var handleErr = function () {
            objAlerta.value = valRetorno;
            formatoSeparadores(objAlerta);
            this.cancel();
        }

        var objAtributos = {
            width: "330px",
            effect: {
                effect: YAHOO.widget.ContainerEffect.FADE,
                duration: 0
            },
            fixedcenter: true,
            zIndex: 1,
            visible: false,
            modal: true,
            draggable: false,
            close: false,
            text: txtMensaje,
            icon: YAHOO.widget.SimpleDialog.ICON_WARN,
            buttons: [
                {
                    text: "Aceptar",
                    handler: handleOk,
                    isDefault: true
                },
                {
                    text: "Cancelar",
                    handler: handleErr
                }
            ]
        }

        // INSTANCIA EL OBJETO DIALOGO
        var objDialogo1 = new YAHOO.widget.SimpleDialog("dlg", objAtributos);

        // Muestra el cuadro de dialogo
        objDialogo1.setHeader("Atención");
        objDialogo1.render(document.body);
        objDialogo1.show();
    }




}



