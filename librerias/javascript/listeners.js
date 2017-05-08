
	/**
	 * ESTE ARCHIVO CONTIENE LOS LISTENER DE YUI
	 * QUE SE ACTIVAN CUANDO CIERTOS EVENTOS SUCEDEN EN EL 
	 * APLICATIVO, ADEMAS INCLUYE LAS FUNCIONES QUE SE 
	 * RELACIONAN A ELLOS. 
	 * NORMALMENTE LOS LISTENER ESTAN ACOMPA�ADOS DE FUNCIONES 
	 * QUE REACTIVAN EL LISTENER DESPUES DE QUE EL EVENTO SUCEDE, 
	 * OTRAS FUNCIONES SON LOS MANEJADORES (HANDLER) DE LOS EVENTOS
	 * CLICK U OTROS QUE SE PRODUCEN AL MOSTRAR ELEMENTOS YUI
	 * @author Bernardo Zerda 
	 * @version 1.0 abril 2009
	 */

	/**
	 * ESTA PROPIEDAD INDICA CUANTO ES EL TIEMPO
	 * EN EL QUE YUI HARA SONDEO BUSCANDO NUEVOS
	 * OBJETOS QUE NO ESTABAN EN EL DOM AL MOMENTO
	 * DE HACER LA PETICION.
	 * 300 SEGUNDOS SON EL VALOR PORQUE ES EL TIEMPO
	 */
	 
	YAHOO.util.Event.POLL_INTERVAL = 1200;


	/** 
	 * ESTA INSTRUCCION SE EJECUTA CUANDO
	 * LA PAGINA TERMINA DE CARGARSE
	 * @author Beranrdo Zerda
	 * @version 1,0 Mayo 2009
	 */
	YAHOO.util.Event.onDOMReady( cargarListener );

	/**
	 * CARGA LOS LISTENER DESDE QUE INICIA EL APLICATIVO
	 * @author Bernardo Zerda
	 * @param Void
	 * @return Void
	 * @version 1,1 Mayo 2009
	 */
	
	function cargarListener(){
		
//		YAHOO.util.Event.onContentReady( "cambioClave"         , cambioClave       );
		YAHOO.util.Event.onContentReady( "salvarProyecto"       , salvarProyecto     );
		YAHOO.util.Event.onContentReady( "salvarGrupo"         , salvarGrupo       );
		YAHOO.util.Event.onContentReady( "salvarUsuario"       , salvarUsuario     );	
		YAHOO.util.Event.onContentReady( "salvarMenu"          , salvarMenu        );
		YAHOO.util.Event.onContentReady( "listenerArbolMenu"   , listenerArbolMenu );
      
		//YAHOO.util.Event.onContentReady( "dlgOlvidoContrasena" , olvidoContrasena );
		//YAHOO.util.Event.addListener( "linkOlvidoContrasena", "click", mostrarDialogo );

	}
	
	
	/**
	 * LISTENER QUE REFESCA LA LISTA DE ProyectoS
	 * UNA VES SE CREA / EDITA / BOORA UNA DE LAS
	 * ProyectoS DEL APLICATIVO
	 * @author Bernardo Zerda
	 * @param Void
	 * @return Void
	 * @version 1,0 Marzo de 2009
	 */

	function salvarProyecto(){
		eliminarObjeto( "salvarProyecto" );
		YAHOO.util.Event.onContentReady( "salvarProyecto" , salvarProyecto );
		cargarContenido( "listado" , "./contenidos/administracion/listadoProyectos.php" , "" , true );
	}

	/**
	 * LISTENER QUE REFRESCA EL LISTADO DE 
	 * GRUPOS QUE SE CREAN / EDITAN / BORRAN 
	 * DEL SISTEMA
	 * @author Bernardo Zerda
	 * @version 1.0 Abril 2009
	 **/
	
	function salvarGrupo(){
		
		YAHOO.util.Event.onContentReady( "salvarGrupo" , salvarGrupo );
		cargarContenido( "listado" , "./contenidos/administracion/listadoGrupos.php" , "" , true );
		eliminarObjeto( "salvarGrupo" );
	
	}
	
	/**
	 * LISTENER QUE REFRESCA EL LISTADO DE USUARIOS
	 * @author Bernardo Zerda
	 * @version 1.0 Abril 2009
	 */
	 
	function salvarUsuario(){
		eliminarObjeto( "salvarUsuario" );
		YAHOO.util.Event.onContentReady( "salvarUsuario" , salvarUsuario );
		cargarContenido( "listado" , "./contenidos/administracion/listadoUsuarios.php" , "" , true );
	}
	
	/**
	 * LISTENER QUE REFRESCA EL LISTADO DE OPCIONES DE MENU
	 * @author Bernardo Zerda
	 * @version 1.0 Abril 2009
	 */
	 
	function salvarMenu(){
		eliminarObjeto( "salvarMenu" );
		YAHOO.util.Event.onContentReady( "salvarMenu" , salvarMenu );
		cargarContenido( "listado" , "./contenidos/administracion/listadoMenu.php" , "proyecto=" + document.getElementById("proyecto").value , true );
	}

	/**
	 * ESTE LISTENER CONSTRUYE EL ARBOL DE MENU QUE
	 * SE MUESTRA EN LA ADMINSITRACION DE MENU
	 * @author Bernardo Zerda
	 * @version 1.0 abril 2009
	 */
	 
	function listenerArbolMenu(){
		llenarArbolMenu();
		eliminarObjeto( "listenerArbolMenu" );
		YAHOO.util.Event.addListener("proyectoArbol", "change", cambioSelectArbolMenu );
		YAHOO.util.Event.onContentReady( "listenerArbolMenu" , listenerArbolMenu );
	}

	/**
	 * ESTA FUNCION CONSTRUYE EL ARBOL DE MENU
	 * PARA EL CLIENTE QUE ESTE SELECCIONADO
	 * @author Bernardo Zerda
	 * @param Void
	 * @return Void
	 * @version 1.0 Abril de 2009
	 */
	 
	function llenarArbolMenu(){
		// Obtiene la proyecto seleccionada
		var objProyecto = document.getElementById( "proyectoArbol" );
			  seqProyecto = objProyecto.options[ objProyecto.selectedIndex ].value;
		
		// Instancia el objeto TreeView sobre el div arbolMenu
		var objArbol = new YAHOO.widget.TreeView("arbolMenu");
		 
		// Carga dinamicamente los hijos del arbol
		// se ejecuta cuando se intenta expandir uno de los nodos
		objArbol.setDynamicLoad( obtenerHijosArbolMenu ); 
		
		// cuando se hace click en un nodo del arbol se ejecuta esta funcion
		objArbol.subscribe(
				"labelClick", 
				function( objNodo ){ 
					var txtParametros = "proyecto=" + objNodo.data.proyecto + "&";
							txtParametros += "seqEditar=" + objNodo.data.padre;
					cargarContenido('formulario', './contenidos/administracion/formularioMenu.php', txtParametros, true );
				}	
		)	
	
		var objRaiz  = objArbol.getRoot(); // obtiene el primer nodo del arbol 
	  
		// valores para el nodo raiz
		var objConfiguracionNodo = { 
		  	label: "Opciones de Menu",
		  	proyecto: seqProyecto,
			padre: 0
		}; 
		
		// Instancia el objeto raiz
		var objPrimerNodo = new YAHOO.widget.TextNode( objConfiguracionNodo, objRaiz , true);
		
		objArbol.render(); // dibuja el arbol ( en este caso no es necesario un objArbol.show() )
		
	}

	/**
	 * ESTA FUNCION SE LLAMA DESDE EL LISTENER
	 * DE EL ARBOL DE MENU
	 * @author Bernardo Zerda 
	 * @param TextNode objPadre
	 * @param object onCompleteCallBack
	 * @return Boolean true | false
	 * @version 1,0 Abril 2009
	 */
	
	function obtenerHijosArbolMenu( objPadre, onCompleteCallback ){
		
		// paramentros que recibira el archivo que consultara los hijos de un nodo al que se le hizo click
		var txtParametros  = "proyecto=" + objPadre.data.proyecto + "&";
				txtParametros += "padre=" + objPadre.data.padre;   
		
		// Objeto de respuesta satisfactoria
		var handleSuccess = 
			function(o){
				if(o.responseText !== undefined){
					if( o.responseText != "" ){
						
						// obtiene la respuesta plana y la separa con el formato requerido
						var arrRespuesta = o.responseText.split( "#" );
						
						// para cada separacion (posicion del arreglo resultante) 
						for( i = 0 ; i < arrRespuesta.length ; i++ ){
							
							// obtiene las caranteristicas separadas por el formato
							var arrNodo = arrRespuesta[ i ].split( ";" );
							var objConfiguracionNodo = { 
					    	label   : arrNodo[ 1 ], 
					    	proyecto : objPadre.data.proyecto, 
					    	padre   : arrNodo[ 0 ]
							}
							
							// instancia el nodo
							var objNodo = new YAHOO.widget.TextNode( objConfiguracionNodo, objPadre , false);
							
						}
					 }
				}
				onCompleteCallback(); // indispensable para que la funcion termine la ejecucion
				return true;
			};
		
		// objeto de fallo en la respuesta
		var handleFailure = 
			function(o){
				if(o.responseText !== undefined){					
					// Cuando se vence la sesion la respuesta es HTTP 401 = Not Authorized
					if(o.status == "401"){						
						document.location = 'index.php';
					}else{
						var htmlCode = "";
						htmlCode= "<div align='center'>";
						htmlCode+= "<span class='alertaRojo'>Atencion Requerida</span><br>";
						htmlCode+= "<span class='alertaNegro'>Mensaje: "+o.status+" "+o.statusText+"<br>";
						htmlCode+= "Puede que no tenga privilegios para ingresar a esta opcion de menu <br>";
						htmlCode+= "Contacte al administrador de su sistema";
						htmlCode+= "</span>";
						htmlCode+= "</div>";
						document.getElementById('mensajes').innerHTML = htmlCode;
					}
					onCompleteCallback(); // indispensable para que la funcion termine la ejecucion
					return false;
				}
			};
		
		// objeto de respuesta
		var callback =
			{
			  success:handleSuccess,
			  failure:handleFailure
			};
		
		var callObj = YAHOO.util.Connect.asyncRequest("POST", "./contenidos/administracion/hijosArbolMenu.php", callback, txtParametros);	
		
	}
	
	/**
	 * FUNCION QUE SE EJECUTA CUANDO SE PRODUCE
	 * UN EVENTO onChange DEL SELECT DE proyectoS
	 * EN EL MENU DE ADMINISTRACION DE MENU
	 * @author Bernardo Zerda
	 * @param Void
	 * @return Void
	 * @version 1.0 abril de 2009
	 */
	 
	function cambioSelectArbolMenu(){
		
		// Obtiene la proyecto seleccionada
		var objProyecto = document.getElementById( "proyectoArbol" );
			  seqProyecto = objProyecto.options[ objProyecto.selectedIndex ].value;
		
		var txtParametros = "proyecto=" + seqProyecto + "&";
				txtParametros += "seqEditar=0";
		
		// Muestra los nodos padres para que se seleccione uno al crear una opcion de menu
		cargarContenido('formulario', './contenidos/administracion/formularioMenu.php', txtParametros, true );
		
		llenarArbolMenu(); // instancia el objeto arbol y lo muestra
		
	}
	
	/**
	 * CUANDO UN OBJETO cambioClave ES CREADO EN EL 
	 * APLICATIVO SE EJECUTA ESTA FUNCION
	 * @author Bernardo Zerda
	 * @version 1,0 Abril de 2009
	 */

//	function cambioClave(){
//			
//		// ontiene el objeto que contiene el cuadro de dialogo ( ver autenticacion.php )
//		var objDialogo = document.getElementById( "dlgCambioContrasena" );
//		
//		objDialogo.style.display = ""; // hace visible el objeto
//
//		// Manejador del boton submit
//		var handleSubmit = function( o ) {
//			
//			// objeto donde se mostraran los errores dentro del la ventana emergente
//			var objError = document.getElementById( "errorCambio" ); 
//			
//			objError.style.display = ""; // Muestra el cuadro de error
//			
//			// llamado asincrono al archivo que ejecutara el cambio de clave
//			var oCall = someterFormulario( "errorCambio" , objDialogo.form , "./contenidos/administracion/cambioClave.php" , false , false );
//		
//			// si no ha terminado el procesamiento del script coloca la imagen de cargando para que el usuario 
//			// sepa que aun se esta procesando su peticion
//			if( YAHOO.util.Connect.isCallInProgress( oCall ) ){
//				objError.innerHTML = "<img src='./recursos/imagenes/cargando.gif'>";
//			}
//		
//		};
//	
//		// Manejador del boton cancelar
//		var handleCancel = function(){
//			this.cancel();
//		};
//
//		// configuracion del objeto dialogo
//		var objConfiguracion = {
//			width: "500px",
//			height: "280px",
//			fixedcenter: true,
//			visible: false, 
//			close: false,
//			constraintoviewport: true,
//			draggable: true,
//			modal: true,
//			buttons: [ 
//				{ text:"Aceptar", handler:handleSubmit, isDefault:true }, 
//				{ text:"Cancelar", handler:handleCancel } 
//			],
//			effect:{effect:YAHOO.widget.ContainerEffect.FADE,duration:0.50} 
//		};
//		
//		// obtiene lo que esta escrito en el cuadro de texto del usuario en la pantalla de login
//		document.getElementById("usuarioCambio").value = document.getElementById("usuario").value;
//		
//		// Instantiate the Dialog
//		var objDialogo = new YAHOO.widget.Dialog( objDialogo , objConfiguracion );
//	  		objDialogo.render(); // dibuja el cuadro de dialogo
//	  		objDialogo.show();	 // hace visible el dialogo
//		
//	}
	

	
//	function olvidoContrasena( ){
//
//		// Manejador
//		var handleSubmit = function() {
//			this.submit();
//			document.getElementById("error").innerHTML = "<img src='./recursos/imagenes/cargando.gif'>";
//		};
//		
//		var handleCancel = function() {
//			this.cancel();
//			document.getElementById("error").innerHTML = "";
//		};
//		
//		var handleSuccess = function(o) {
//			var response = o.responseText;
//			document.getElementById("error").innerHTML = response;
//		};
//		var handleFailure = function(o) {
//			document.getElementById("error").innerHTML = "Submission failed: " + o.status;
//		};
//
//		// objeto de configuracion del panel que se muestra
//		var objConfiguracion = {
//			width: "400px",
//			height: "190px",
//			fixedcenter: true,
//			visible: false, 
//			close: false,
//			constraintoviewport: true,
//			draggable: true,
//			modal: true,
//			buttons: [ 
//				{ text:"Aceptar", handler:handleSubmit, isDefault:true }, 
//				{ text:"Cancelar", handler:handleCancel } 
//			],
//			effect:{effect:YAHOO.widget.ContainerEffect.FADE,duration:0.50} 
//		};
//
//		// Instantiate the Dialog
//		dialog1 = new YAHOO.widget.Dialog("dlgOlvidoContrasena", objConfiguracion );
//
//		// Validate the entries in the form to require that both first and last name are entered
//		dialog1.validate = function() {
//			var data = this.getData();
//			if (data.olvidoUsuario == "" || data.correo == "") {
//				alert("Debe digitar el usuario y un correo electr" + String.fromCharCode( 243 ) + "nico.");
//				return false;
//			} else {
//				return true;
//			}
//		};
//
//		// Wire up the success and failure handlers
//		dialog1.callback = { success: handleSuccess, failure: handleFailure };
//		
//		// Render the Dialog
//		dialog1.render();
//
//	}
	
	/**
	 * ESTA FUNCION HACE VISIBLE EL CUADRO DE CAMBIO DE CONTRASE�A
	 * 
	 * @author Bernardo Zerda
	 * @version 1,0 Mayo de 2009
	 */
	 
//	function mostrarDialogo(){
//      
//      alert( dialog1 );
//      
//		dialog1.show();  // Hace visible el dialogo de cambio de contrasena
//	}
