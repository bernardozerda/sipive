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
	 * @version 1.0 mayo 2009
	 */

	YAHOO.widget.Chart.SWFURL = "./librerias/yui/charts/assets/charts.swf";

	/** 
	 * ESTA INSTRUCCION SE EJECUTA CUANDO
	 * LA PAGINA TERMINA DE CARGARSE
	 * @author Beranrdo Zerda
	 * @version 1,0 Mayo 2009
	 */
	YAHOO.util.Event.onDOMReady( cargarListener );
	YAHOO.util.Event.POLL_INTERVAL = 1000;
	YAHOO.util.Event.POLL_RETRYS = 60000;

	/**
	 * CARGA LOS LISTENER DESDE QUE INICIA EL APLICATIVO
	 * @author Bernardo Zerda
	 * @param Void
	 * @return Void
	 * @version 1,1 Mayo 2009
	 */

	function cargarListener(){

      YAHOO.util.Event.onContentReady( "menu" , cargarMenu );      
		YAHOO.util.Event.onContentReady( "seguimiento" , seguimientoTabView );
		YAHOO.util.Event.onContentReady( "buscarCedulaListener" , buscarCedulaListener );
		YAHOO.util.Event.onContentReady( "buscarNitListener" , buscarNitListener );
		YAHOO.util.Event.onContentReady( "inscripcionTabView" , inscripcionTabView );
		YAHOO.util.Event.onContentReady( "actosTabView" , actosTabView );
		YAHOO.util.Event.onContentReady( "postulacionTabView" , postulacionTabView );
		YAHOO.util.Event.onContentReady( "listenerTextoCalificacion" , tablaCalificados );
		YAHOO.util.Event.onContentReady( "listenerBuscarNombre" , buscarNombre );
		YAHOO.util.Event.onContentReady( "listenerCargaArchivosDesembolso" , cargarArchivoDesembolso );
		YAHOO.util.Event.onContentReady( "listenerRevisionTecnica" , listenerRevisionTecnica );
		YAHOO.util.Event.onContentReady( "listenerBuscarUsuario" , buscarUsuario );
		YAHOO.util.Event.onContentReady( "listenerBuscarUsuarioTecnico" , buscarUsuarioTecnico );
		YAHOO.util.Event.onContentReady( "activarTabView" , activarTabView );
		YAHOO.util.Event.onContentReady( "objGraficasBorrar" , graficasReportes );
		YAHOO.util.Event.onContentReady( "objGraficasImprimirBorrar" , graficasImprimirReportes );
		YAHOO.util.Event.onContentReady( "objGraficasTablasBorrar" , graficasTablas );
		YAHOO.util.Event.onContentReady( "divArbolReportesListener" , crearArbolReportes );		
		YAHOO.util.Event.onContentReady( "GraficasImprimir" , imprimir );
		YAHOO.util.Event.onContentReady( "dlgConfirmacionDesembolsoListener" , dlgConfirmacionDesembolsoListener );
		YAHOO.util.Event.onContentReady( "objReporteadorListener" , listenerReporteador );
		YAHOO.util.Event.onContentReady( "objReporteadorListenerProyectos" , listenerReporteadorProyectos );
		YAHOO.util.Event.onContentReady( "objReporteadorGenerar" , mostrarReporteador );
		YAHOO.util.Event.onContentReady( "objArbolActosAdministrativos" , objArbolActosAdministrativos );
		YAHOO.util.Event.onContentReady( "listenerReporteFNA" , reporteFNA );	
		YAHOO.util.Event.onContentReady( "objArbolFormulariosAsignarListener" , crearArbolFormulariosAsignar );
		YAHOO.util.Event.onContentReady( "listenerhogaresSeleccionadosArrendamiento" , hogaresSeleccionadosArrendamiento );
		YAHOO.util.Event.onContentReady( "listenersorteoArrendamiento" , listenersorteoArrendamiento );
		YAHOO.util.Event.onContentReady( "listenerDataTableFormulariosAsignados" , dataTableFormulariosAsignados );
		YAHOO.util.Event.onContentReady( "listenerDataTableFormulariosAsignadosMasiva" , dataTableFormulariosAsignadosMasiva );
		YAHOO.util.Event.onContentReady( "divListenerIndicadoresTutoresDesembolso"		, cargaIndicadoresTutoresDesembolso );
		YAHOO.util.Event.onContentReady( "divListenerIndicadoresSolicitudDesembolso"	, cargaIndicadoresSolicitudDesembolso );

		YAHOO.util.Event.onContentReady( "elegibilidadPryTabView" , elegibilidadPryTabView );
		YAHOO.util.Event.onContentReady( "desembolsoPryTabView" , desembolsoPryTabView );
		YAHOO.util.Event.onContentReady( "seguimientoPryTabView" , seguimientoPryTabView );
		YAHOO.util.Event.onContentReady( "cronogramaObrasTabView" , cronogramaObrasTabView );
		YAHOO.util.Event.onContentReady( "revTecnicaUnidadesTabView" , revTecnicaUnidadesTabView );

		YAHOO.util.Event.onContentReady( "barrioListener" , barrioAutocomplete , [ 'txtBarrio' , 'barrioContainer' , 'seqLocalidad'] );

		/*
		 * INDICADORES TUTORES DESEMBOLSO 
		 */
		YAHOO.util.Event.onContentReady( "listenerDataTableIndicadoresTutoresDesembolso", dataTableReporteIndicadorTutorDesembolso );

		YAHOO.util.Event.onContentReady( "divListenerRevisionOferta", 		cargaIndicadorRevisionOferta );
		YAHOO.util.Event.onContentReady( "divRevisionJuridica", 			cargaIndicadorRevisionJuridica );
		YAHOO.util.Event.onContentReady( "divListenerRevisionTecnica", 		cargaIndicadorRevisionTecnica );
		YAHOO.util.Event.onContentReady( "divListenerEstudioTitulos", 		cargaIndicadorEstudioTitulos );
		YAHOO.util.Event.onContentReady( "divListenerSolicitudDesembolso", 	cargaIndicadorSolicitudDesembolso );
		YAHOO.util.Event.onContentReady( "divListenerAsignados", 			cargaIndicadorAsignados );

		YAHOO.util.Event.onContentReady( "divListenerRadicadoTitulos", 		cargaIndicadorRadicadoTitulos );
		YAHOO.util.Event.onContentReady( "divListenerEscrituracion", 		cargaIndicadorEscrituracion );

		YAHOO.util.Event.onContentReady( "listenerBuscarNombreProyecto" , 	buscarNombreProyecto );
	}

	function inscripcionTabView(){
		eliminarObjeto( "inscripcionTabView" );
		YAHOO.util.Event.onContentReady( "inscripcionTabView" , inscripcionTabView );
		var objTabView = new YAHOO.widget.TabView('inscripcion');
		document.getElementById("numDocumento").focus();
	}
	
	function postulacionTabView(){
		eliminarObjeto( "postulacionTabView" );
		YAHOO.util.Event.onContentReady( "postulacionTabView" , postulacionTabView );
		var objTabView = new YAHOO.widget.TabView('pestanasPostulacion');
		var objTabView = new YAHOO.widget.TabView('postulacion');
        window.scrollTo(0,0);
	}
	
	function actosTabView(){
		eliminarObjeto( "actosTabView" );
		YAHOO.util.Event.onContentReady( "actosTabView" , actosTabView );
		var objTabView = new YAHOO.widget.TabView('pestanasActos');
		var objTabView = new YAHOO.widget.TabView('actos');
		// falta el elemento que bva a tener el foco por defecto
	}
	
	/**
	 * DA UN AVISO AL USUARIO CUANDO LE QUEDA MENOS DE 
	 * LA CUARTA PARTE DE VIDA DE LA SESION, ES DECIR
	 * SI LA SESSION ES DE 20 MINUTOS EL AVISO ES A LOS
	 * 15 MINUTOS, SI LA SESION ES DE 4 MINUTOS AVISA AL MINUTO 3
	 * @author Bernardo Zerda
	 */
	
	setInterval( "alertaVencimientoSesion()" , 300000 );

	function alertaVencimientoSesion(){

		// al parecer reinicia el tiempo del poll interval
		YAHOO.util.Event.startInterval();
		
		// El tiempo de vida de la cookie esta en segundos
		// este timestamp se entrega en milisegundos por eso
		// se divide este valor en 1000
		var numTimeStamp = Math.round( Number(new Date()) / 1000 );

		// Obtiene el valor de la sesion de la cookie,
		var numExpiraSesion = YAHOO.util.Cookie.get( "sdhtsdv" );

		// tiempo restante de vida en segundos
		var numTiempoVida = Math.round( numExpiraSesion - numTimeStamp );

		// elimina objetos basura dejados por el YUI
        while(document.getElementById('aviso_mask')){
            eliminarObjeto('aviso_mask');
        }

        while(document.getElementById('aviso_c')){
            eliminarObjeto('aviso_c');
        }

        while(document.getElementById('wait_mask')){
            eliminarObjeto('wait_mask');
        }

        while(document.getElementById('wait_c')){
            eliminarObjeto('wait_c');
        }

        eliminarObjeto("_yuiResizeMonitor");

		// Cuando quede menos de la cuarta parte de tiempo de vida de la
		// sesion el sistema muestra un popup que avida que por el tiempo
		// de inactividad se va a cerrar la sesion
		if( numTiempoVida <= 450 && numTiempoVida > 0 ){

			var txtMensaje  = "<div style='text-align:center' class='msgError'>";
				txtMensaje += "Le quedan menos de " + Math.round((numTiempoVida + 1) / 60) + " segundos de vida a su sesi&oacute;n ";
				txtMensaje += "debe salvar los cambios que haya hecho para no perder la informaci&oacute;n";
			 	txtMensaje += "</div>";

			var objAviso = 
				new YAHOO.widget.SimpleDialog(
					"aviso",
					{ 
						width:"250px",
						fixedcenter:true,
						close:true,
						draggable:false,
						modal:true,
						visible:false,
						icon: YAHOO.widget.SimpleDialog.ICON_WARN 
					}
				); 
			
			objAviso.setHeader("ATENCI&Oacute;N");
			objAviso.setBody( txtMensaje );
			objAviso.render(document.body); 
			objAviso.show();
			 
		}

	}

	YAHOO.util.Event.onContentReady("matarSesion",function(o){
		YAHOO.util.Dom.get("contenido").innerHTML = "";
		location.reload(true);
	});


	function buscarCedulaListener(){
		
		eliminarObjeto( "buscarCedulaListener" );
		
		// Blquea la combinacion Control + c y Control + v para el objeto buscaCedula
		var objKeyListenerBuscarCedula = 
			new YAHOO.util.KeyListener(
				document.getElementById("buscaCedula"), 
				{ ctrl:true, keys:[67,86] }, // Control + C || Control + V
				{ fn:bloquearCopiarPegar, scope:document.getElementById("buscaCedula"), correctScope:true },
				"keydown"
			);
		objKeyListenerBuscarCedula.enable();		
		
		// Blquea la combinacion Control + c y Control + v para el objeto buscaCedulaConfirmacion
		var objKeyListenerBuscarCedulaConfirmacion = 
			new YAHOO.util.KeyListener(
				document.getElementById("buscaCedulaConfirmacion"), 
				{ ctrl:true, keys:[67,86] }, // Control + C || Control + V
				{ fn:bloquearCopiarPegar, scope:document.getElementById("buscaCedulaConfirmacion"), correctScope:true },
				"keydown"
			);
		objKeyListenerBuscarCedulaConfirmacion.enable();
		
		// Hace un menu contextual vacio para el objeto buscarCedula
		var aMenuItems = [ "" ];
		var objContextMenuBuscarCedula = 
			new YAHOO.widget.ContextMenu(
                "contextBuscarCedula", 
                {
                    trigger: document.getElementById("buscaCedula"),
                    itemdata: aMenuItems,
                    lazyload: true                                    
                } 
            );
            
        // Hace un menu contextual vacio para el objeto buscarCedula
		var aMenuItemsConfirmacion = [ "" ];
		var objContextMenuBuscarCedulaConfirmacion = 
			new YAHOO.widget.ContextMenu(
                "contextBuscarCedulaConfirmacion", 
                {
                    trigger: document.getElementById("buscaCedulaConfirmacion"),
                    itemdata: aMenuItemsConfirmacion,
                    lazyload: true                                    
                } 
            );	
		
		YAHOO.util.Event.onContentReady( "buscarCedulaListener" , buscarCedulaListener );
		
	}
	
		function buscarNitListener(){
		
		eliminarObjeto( "buscarNitListener" );
		
		// Blquea la combinacion Control + c y Control + v para el objeto buscaNit
		var objKeyListenerBuscarNit = 
			new YAHOO.util.KeyListener(
				document.getElementById("buscaNit"), 
				{ ctrl:true, keys:[67,86] }, // Control + C || Control + V
				{ fn:bloquearCopiarPegarNit, scope:document.getElementById("buscaNit"), correctScope:true },
				"keydown"
			);
		objKeyListenerBuscarNit.enable();		
		
		// Blquea la combinacion Control + c y Control + v para el objeto buscaNitConfirmacion
		var objKeyListenerBuscarNitConfirmacion = 
			new YAHOO.util.KeyListener(
				document.getElementById("buscaNitConfirmacion"), 
				{ ctrl:true, keys:[67,86] }, // Control + C || Control + V
				{ fn:bloquearCopiarPegarNit, scope:document.getElementById("buscaNitConfirmacion"), correctScope:true },
				"keydown"
			);
		objKeyListenerBuscarNitConfirmacion.enable();
		
		// Hace un menu contextual vacio para el objeto buscarNit
		var aMenuItems = [ "" ];
		var objContextMenuBuscarNit = 
			new YAHOO.widget.ContextMenu(
                "contextBuscarNit", 
                {
                    trigger: document.getElementById("buscaNit"),
                    itemdata: aMenuItems,
                    lazyload: true                                    
                } 
            );
            
        // Hace un menu contextual vacio para el objeto buscarNit
		var aMenuItemsConfirmacion = [ "" ];
		var objContextMenuBuscarNitConfirmacion = 
			new YAHOO.widget.ContextMenu(
                "contextBuscarNitConfirmacion", 
                {
                    trigger: document.getElementById("buscaNitConfirmacion"),
                    itemdata: aMenuItemsConfirmacion,
                    lazyload: true                                    
                } 
            );	
		
		YAHOO.util.Event.onContentReady( "buscarNitListener" , buscarNitListener );
		
	}

	function bloquearCopiarPegar( o ){  
		
		// Solo Explorer permite la manipulacion del porta-papeles
		if( navigator.appName.indexOf("Explorer") > 0 ){ 
			window.clipboardData.setData('text','');
		} 
		
		setTimeout( 'document.getElementById("buscaCedula").value="XXXXXXXXXXXXXXXXXXX"' , 10 );
		setTimeout( 'document.getElementById("buscaCedulaConfirmacion").value="XXXXXXXXXXXXXXXXXXX"' , 20 );

	} // fin bloquearCopiarPegar
	
	function bloquearCopiarPegarNit( o ){  
		
		// Solo Explorer permite la manipulacion del porta-papeles
		if( navigator.appName.indexOf("Explorer") > 0 ){ 
			window.clipboardData.setData('text','');
		} 
		
		setTimeout( 'document.getElementById("buscaNit").value="XXXXXXXXXXXXXXXXXXX"' , 10 );
		setTimeout( 'document.getElementById("buscaNitConfirmacion").value="XXXXXXXXXXXXXXXXXXX"' , 20 );

	} // fin bloquearCopiarPegarNit
	
	function cargarMenu(){
		var objMenu = new YAHOO.widget.MenuBar("menu", { autosubmenudisplay: true, hidedelay: 750, lazyload: true });
			objMenu.render();
	}
	
	function seguimientoTabView(){
		
		eliminarObjeto( "seguimiento" );
		YAHOO.util.Event.onContentReady( "seguimiento" , seguimientoTabView );
		
		var objTabView = new YAHOO.widget.TabView('demo');
		
	}
	
	function tablaCalificados(){
		
		document.getElementById("tablaCalificacion").style.visibility = "visible";
		
		var myDataSource = new YAHOO.util.DataSource(YAHOO.util.Dom.get("datosCalificion"));
		myDataSource.responseType = YAHOO.util.DataSource.TYPE_HTMLTABLE;
		myDataSource.responseSchema = {
		    fields: [
		    		{key:"tpoDoc"},
		            {key:"numDoc"},
		            {key:"txtNom"},
		            {key:"txtMod"},
		            {key:"numCal"}
		    ]
		};
		
		var myColumnDefs = [
		    {key:"tpoDoc", label: "Tipo Documento"},
            {key:"numDoc", label: "Documento"},
            {key:"txtNom", label: "Nombre Postulante Principal"},
            {key:"txtMod", label: "Modalidad"},
            {key:"numCal", label: "Calificacion"}
		];
		
		var myPaginator = new YAHOO.widget.Paginator({ 
			rowsPerPage: 20, 
			template: YAHOO.widget.Paginator.TEMPLATE_ROWS_PER_PAGE, 
			rowsPerPageOptions: [20,40,60,80,100] 
		}); 
		
		var myConfigs = { 
			paginator: myPaginator,
			sortedBy:{key:"numCal",dir:YAHOO.widget.DataTable.CLASS_DESC}
		}
		
		var myDataTable = new YAHOO.widget.DataTable(
			"tablaCalificacion", 
			myColumnDefs, 
			myDataSource,
			myConfigs
		);
		
		eliminarObjeto( "cargandoTablaCalificacion" );
		eliminarObjeto( "listenerTextoCalificacion" );		
		YAHOO.util.Event.onContentReady( "listenerTextoCalificacion" , tablaCalificados );
		
        return { 
            oDS: myDataSource, 
            oDT: myDataTable 
        }; 		
			
	}
		
	function buscarNombre( ){
	    
	    var objDataSource = new YAHOO.util.XHRDataSource( "./contenidos/subsidios/buscarNombre.php" );  
	 		objDataSource.responseType 		= YAHOO.util.XHRDataSource.TYPE_TEXT;
		    objDataSource.responseSchema 	= { recordDelim: "\n", fieldDelim: "\t" };
		    objDataSource.maxCacheEntries 	= 5;
		    objDataSource.flushCache();
	    
	    
		var objItemSelect = function( sType , aArgs) {
			var oData = aArgs[2];
			if( oData[ 1 ] != "" ){
	        	YAHOO.util.Dom.get( "buscaCedula" ).value = dar_formato(oData[ 1 ]);
	        }else{
	        	YAHOO.util.Dom.get( "nombre" ).value = "";
	        }
	    }; 
	    
	    var objAutocomplete = new YAHOO.widget.AutoComplete( "nombre" , "contenedor" , objDataSource );
	    	objAutocomplete.itemSelectEvent.subscribe( objItemSelect );
	    	objAutocomplete.maxResultsDisplayed 	= 20; 
	    	objAutocomplete.minQueryLength 			= 2;
	    	objAutocomplete.autoHighlight 			= true;  
	    	objAutocomplete.useShadow 				= true; 
	    	objAutocomplete.forceSelection 			= false;
	    	objAutocomplete.allowBrowserAutocomplete = false;
	    	objAutocomplete.queryDelay = 0.3;
	    	objAutocomplete.formatResult = function(oResultItem, sQuery, sResultMatch) { 
			    var txtNombre 		= sResultMatch; 
			    var numDocumento 	= oResultItem[ 1 ];
			    return ( txtNombre + " [" + dar_formato( numDocumento ) + "]"); 
			};
		    
		// Reinicia el listener
		eliminarObjeto( "listenerBuscarNombre" );
	    YAHOO.util.Event.onContentReady( "listenerBuscarNombre" , buscarNombre );
	    
	    // Retorna el objeto
	    return {
	        oDS: objDataSource,
	        oAC: objAutocomplete
	    };
		
	}

	function buscarNombreProyecto( ){

	    var objDataSource = new YAHOO.util.XHRDataSource( "./contenidos/proyectos/buscarNombreProyecto.php" );
	 		objDataSource.responseType 		= YAHOO.util.XHRDataSource.TYPE_TEXT;
		    objDataSource.responseSchema 	= { recordDelim: "\n", fieldDelim: "\t" };
		    objDataSource.maxCacheEntries 	= 5;
		    objDataSource.flushCache();

		var objItemSelect = function( sType , aArgs) {
			var oData = aArgs[2];
			if( oData[ 1 ] != "" ){
	        	YAHOO.util.Dom.get( "myHidden" ).value = dar_formato(oData[ 1 ]);
	        }else{
	        	YAHOO.util.Dom.get( "nombre" ).value = "";
	        }
	    }; 

	    var objAutocomplete = new YAHOO.widget.AutoComplete( "nombre" , "contenedor" , objDataSource );
	    	objAutocomplete.itemSelectEvent.subscribe( objItemSelect );
	    	objAutocomplete.maxResultsDisplayed 	= 40; 
	    	objAutocomplete.minQueryLength 			= 2;
	    	objAutocomplete.autoHighlight 			= true;  
	    	objAutocomplete.useShadow 				= true; 
	    	objAutocomplete.forceSelection 			= false;
	    	objAutocomplete.allowBrowserAutocomplete = false;
	    	objAutocomplete.queryDelay = 0.3;
	    	objAutocomplete.formatResult = function(oResultItem, sQuery, sResultMatch) { 
			    var txtNombre 		= sResultMatch; 
			    var txtNombreOferente 	= oResultItem[ 1 ];
			    //return ( txtNombre + " [" + dar_formato( numDocumento ) + "]"); 
				//return ( txtNombre + " [" + txtNombreOferente + "]"); 
				return ( txtNombre );
			};

		// Reinicia el listener
		eliminarObjeto( "listenerBuscarNombreProyecto" );
	    YAHOO.util.Event.onContentReady( "listenerBuscarNombreProyecto" , buscarNombreProyecto );

	    // Retorna el objeto
	    return {
	        oDS: objDataSource,
	        oAC: objAutocomplete
	    };
	}	
	
	function cargarArchivoDesembolso(){

		var objMensajes = YAHOO.util.Dom.get( "mensajesCargandoArchivos" );

		var objSometer = function() {

			var objFormulario = YAHOO.util.Dom.get( "frmCargaArchivosDesembolso" );

			objCall = someterFormulario("mensajesCargandoArchivos",objFormulario,"./contenidos/desembolso/cargarArchivos.php",true,false);

			if( YAHOO.util.Connect.isCallInProgress( objCall ) ){

				objMensajes.style.display = "";

				var txtMensaje  = "<table class='tituloTabla'>";
					txtMensaje += "<tr><td valign='middle'>Cargando</td>";
					txtMensaje += "<td><img src='./recursos/imagenes/cargando.gif' align='middle'></td>";
					txtMensaje += "</tr></table>";				
				
				objMensajes.innerHTML = txtMensaje;
			}
			
			YAHOO.util.Event.onContentReady( 
				"finCargarArchivosDesembolso" , 
				function(){
					
					arrErrores = YAHOO.util.Dom.getElementsByClassName(
						"msgError" , 
						"td", 
						"tablaMensajes"
					);
					
					if( arrErrores.length == 0 ){
						var objNombreArchivo = YAHOO.util.Dom.get( "nombreArchivoCargado" );
						var objTextoArchivo  = YAHOO.util.Dom.get( "textoArchivoCargado" );
						var objContenedor = YAHOO.util.Dom.get( "contenedorImagenes" );
						
						var objCelda = document.createElement("td");
						
						objCelda.id = objNombreArchivo.innerHTML;
						objCelda.style.paddingLeft = "10px";
						objCelda.style.paddingRight = "10px";
						objCelda.style.textAlign = "center";
						
						objCelda.innerHTML += "<div onMouseOver='this.style.backgroundColor=\"#FFA4A4\"' onMouseOut='this.style.backgroundColor=\"#F9F9F9\"' style='width:12px; height:14px; cursor:pointer; border: 1px solid #999999; float:left;' onClick='eliminarObjeto(\"" + objNombreArchivo.innerHTML + "\"); cargarContenido(\"mensajes\", \"./contenidos/desembolso/eliminarArchivosDesemboslo.php\", \"ruta=" + objNombreArchivo.innerHTML + "\", true);'>X</div>";
						objCelda.innerHTML += objTextoArchivo.innerHTML + "<hr>";
						objCelda.innerHTML += "<img src='./recursos/imagenes/desembolsos/" + objNombreArchivo.innerHTML + "' width='120px' height='120px' onClick='tamanoOriginal(\"" + objNombreArchivo.innerHTML + "\", \"" + objTextoArchivo.innerHTML + "\");' style=\"cursor:pointer\">";
						objCelda.innerHTML += "<input type='hidden' name='nombreArchivoCargado[]' value='" + objNombreArchivo.innerHTML + "'>";
						objCelda.innerHTML += "<input type='hidden' name='textoArchivoCargado[]' value='" + objTextoArchivo.innerHTML + "'>";

						objContenedor.appendChild( objCelda );
						
					}
				}
			);
			
		}
		var objCancelar = function() {
			this.cancel();
		};
		
		var objConfiguracion = { 
			width : "600px",
			fixedcenter : true,
			visible : false,
			modal: false,
			close: true,
			constraintoviewport : true,
			buttons : [ { text:"Adjuntar Archivos", handler:objSometer, isDefault:true },
			  			{ text:"Cancelar", handler:objCancelar } ]	
		}
		
		var objDialogo = new YAHOO.widget.Dialog( "cargaArchivosDesembolso" , objConfiguracion );
		
		objDialogo.render();
		
		YAHOO.util.Event.addListener(
			"linkCargaArchivosDesembolso" , 
			"click" , 
			function(){
				objMensajes.innerHTML = "";
				objMensajes.style.display = "none";
				objDialogo.show()
			} 
		);
		
		eliminarObjeto( "listenerCargaArchivosDesembolso" );
		YAHOO.util.Event.onContentReady( "listenerCargaArchivosDesembolso" , cargarArchivoDesembolso );
		
	}
		
	function listenerRevisionTecnica(){
		
		eliminarObjeto( "listenerRevisionTecnica" );
		YAHOO.util.Event.onContentReady( "listenerRevisionTecnica" , listenerRevisionTecnica );
		
		var objTabView = new YAHOO.widget.TabView('revTecGen');
		var objTabView = new YAHOO.widget.TabView('revTecVivUsa');
	}
	
	function buscarUsuario(){
		
		var objListenerBuscarUsuario = YAHOO.util.Dom.get( "listenerBuscarUsuario" );
		
		// Objeto que maneja la fuente de los datos
	    var objDataSource = new YAHOO.util.XHRDataSource("./contenidos/subsidios/buscarUsuario.php?consulta=" + objListenerBuscarUsuario.innerHTML );
	    objDataSource.responseType = YAHOO.util.XHRDataSource.TYPE_TEXT;
	    objDataSource.responseSchema = {
	        recordDelim: "\n",
	        fieldDelim: "\t"
	    };
	    
	    // Objeto que maneja el evento de seleccionar un resultado
	    var objItemSelect = function(sType, aArgs) {
	        var oData = aArgs[2];
	        var objDestino = YAHOO.util.Dom.get( "aprobo" );
	        objDestino.value = "";
	        if( oData[ 1 ] != "" ){	        	
	        	objDestino.value = oData[ 1 ];
	        }
	    };
	    
	    // Objeto autocompletar
	    var objAutocompletar = new YAHOO.widget.AutoComplete("aprobo", "contUsuario", objDataSource);
	    	objAutocompletar.itemSelectEvent.subscribe( objItemSelect );
	    	objAutocompletar.queryDelay = 0,5;
	    	objAutocompletar.maxResultsDisplayed = 20; 
	    	objAutocompletar.minQueryLength = 2;
	    	objAutocompletar.autoHighlight = true;  
	    	objAutocompletar.useShadow = true; 
	    	objAutocompletar.forceSelection = true;
	    	objAutocompletar.allowBrowserAutocomplete = false;
	    	objAutocompletar.useIFrame = true;
		  
		// Formatea los resultados para que muestre todos los datos del ciudadano 
		objAutocompletar.formatResult = function(oResultItem, sQuery, sResultMatch) {
		    var sKey = sResultMatch;
		    var oAdditionalData = oResultItem[1];
		    return ( sKey + oAdditionalData );
		};
		  
		    
		// Reinicia el listener
		eliminarObjeto( "listenerBuscarUsuario" );
	    YAHOO.util.Event.onContentReady( "listenerBuscarUsuario" , buscarUsuario );
	    
	    // Retorna el objeto
	    return {
	        oDS: objDataSource,
	        oAC: objAutocompletar
	    };
		
	}	

	function buscarUsuarioTecnico(){
		
		var objListenerBuscarUsuarioTecnico = YAHOO.util.Dom.get( "listenerBuscarUsuarioTecnico" );
		
		// Objeto que maneja la fuente de los datos
	    var objDataSource = new YAHOO.util.XHRDataSource("./contenidos/subsidios/buscarUsuarioTecnico.php?consulta=" + objListenerBuscarUsuarioTecnico.innerHTML );
	    objDataSource.responseType = YAHOO.util.XHRDataSource.TYPE_TEXT;
	    objDataSource.responseSchema = {
	        recordDelim: "\n",
	        fieldDelim: "\t"
	    };
	    
	    // Objeto que maneja el evento de seleccionar un resultado
	    var objItemSelect = function(sType, aArgs) {
	        var oData = aArgs[2];
	        var objDestino = YAHOO.util.Dom.get( "aprobo" );
	        objDestino.value = "";
	        if( oData[ 1 ] != "" ){	        	
	        	objDestino.value = oData[ 1 ];
	        }
	    };
	    
	    // Objeto autocompletar
	    var objAutocompletar = new YAHOO.widget.AutoComplete("aprobo", "contUsuarioTecnico", objDataSource);
	    	objAutocompletar.itemSelectEvent.subscribe( objItemSelect );
	    	objAutocompletar.queryDelay = 0,5;
	    	objAutocompletar.maxResultsDisplayed = 20; 
	    	objAutocompletar.minQueryLength = 2;
	    	objAutocompletar.autoHighlight = true;  
	    	objAutocompletar.useShadow = true; 
	    	objAutocompletar.forceSelection = true;
	    	objAutocompletar.allowBrowserAutocomplete = false;
	    	objAutocompletar.useIFrame = true;
		  
		// Formatea los resultados para que muestre todos los datos del ciudadano 
		objAutocompletar.formatResult = function(oResultItem, sQuery, sResultMatch) {
		    var sKey = sResultMatch;
		    var oAdditionalData = oResultItem[1];
		    return ( sKey + oAdditionalData );
		};
		  
		// Reinicia el listener
		eliminarObjeto( "listenerBuscarUsuarioTecnico" );
	    YAHOO.util.Event.onContentReady( "listenerBuscarUsuarioTecnico" , buscarUsuarioTecnico );
	    
	    // Retorna el objeto
	    return {
	        oDS: objDataSource,
	        oAC: objAutocompletar
	    };
		
	}
	
	function activarTabView(){
		eliminarObjeto( "activarTabView" );
		YAHOO.util.Event.onContentReady( "activarTabView" , activarTabView );
		var objTabView = new YAHOO.widget.TabView('tabView');
	}
	
	function mostrarReporteador(){
				
		var objCodigoReporteador = YAHOO.util.Dom.get( "objReporteador" );
		eval( objCodigoReporteador.innerHTML );
		
		var datos 	= objReporteador['datos'];
		var titulos = objReporteador['titulos'];
		var myDataSource = new YAHOO.util.DataSource( datos );
			myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
			myDataSource.responseSchema =
			{
				resultsList: "items", 
				fields: titulos
			};
		
		var myColumnDefs = new Array();
			for( i = 0; i < titulos.length; i++ ){
				myColumnDefs[i] = { 
						key: titulos[i], 
						sortable:true, 
						resizeable:true 
					};	
			}
		
		var myConfigs = {
			width:"450px",
            paginator: new YAHOO.widget.Paginator({
                rowsPerPage: 25,
                template: YAHOO.widget.Paginator.TEMPLATE_ROWS_PER_PAGE,
                rowsPerPageOptions: [10,25,50,100],
                pageLinks: 5
            }),
            draggableColumns:true
        }
		
		
		var myDataTable = new YAHOO.widget.ScrollingDataTable(
									"Reporteador", 
									myColumnDefs, 
									myDataSource, 
									myConfigs
									);
		
		eliminarObjeto( "objReporteadorGenerar" );
		YAHOO.util.Event.onContentReady( "objReporteadorGenerar" , mostrarReporteador );
	}
	
	function graficasReportes(){
		
		/**
		 * CODIGO FUENTE DE LA CONFIGURACION DE LAS GRAFICAS
		 */
		 
		var objCodigoGraficas 	= YAHOO.util.Dom.get( "objGraficas" );
		var objGraReportes 		= YAHOO.util.Dom.get( "graReportes" );
		eval( objCodigoGraficas.innerHTML );
		objGraReportes.innerHTML = "";

		/**
		 * Codigo para el Tab View
		 */ 
		
		var objTabView = new YAHOO.widget.TabView();
		var bolActivo = true;
		for( txtGrafica in objGraficas ){
			
			objTabView.addTab( new YAHOO.widget.Tab({
					label: txtGrafica,
					content: '<table cellspacing="0" cellpadding="0" border="0" width="98%">' +
							'<tr>' +
							'<td width="150px" align="left">' +
							'<a href="#" onClick="javascript: ' + txtGrafica + 'Grafica( \'' + txtGrafica + '\' );">' +
							'Imprimir Gráfica ' + txtGrafica +
							'</a>' +
							'</td>' +
							'</tr>' +
							'</table>' +
							'<div class="chartGraficas" id="' + txtGrafica + '" >' +
							'</div>',
					active: bolActivo
			}));
			bolActivo = false;	
			
			
		}
		objTabView.appendTo('graReportes');
		
		for( txtGrafica in objGraficas ){
			var objDatosGraficas = objGraficas[txtGrafica];
			
			var tipo 	= objDatosGraficas['tipo'];
			var nombre 	= objDatosGraficas['nombre'];
			var datos 	= objDatosGraficas['datos'];
			var ejes 	= objDatosGraficas['ejes'];
			
			switch (tipo){
				
				case 'columna':
					graficaColumna( nombre, ejes, datos );
					break;
				
				case 'bar':
					graficaBar( nombre, ejes, datos );				
					break;
					
				case 'pie':
					graficaPie( nombre, datos );
					break;
				
			}
		}
		eliminarObjeto("objGraficasBorrar");
		YAHOO.util.Event.onContentReady( "objGraficasBorrar" , graficasReportes );
	}
	
	
	
	function fncCamposMarcadosAsignacion( o, objArbol ){
		
		var camposOcultosAsignacion = YAHOO.util.Dom.get( "camposOcultosAsignacion" );
		camposOcultosAsignacion.innerHTML = "";
		
		var hiLit = objArbol.getNodesByProperty('highlightState',1);
		if (YAHOO.lang.isNull(hiLit)) { 
			// alert("None selected");
		} else {
			for (var i = 0; i < hiLit.length; i++) {
				var idUsuario = hiLit[i].data.idUsuario;
				if( idUsuario != "undefined" ){
					camposOcultosAsignacion.innerHTML += "<input type='hidden' name='arrTutores[]' value='"+ idUsuario +"'>";
				}
			}
			
		}
		
	}
	
	function dataTableFormulariosAsignadosMasiva( ){
		
		eliminarObjeto("listenerDataTableFormulariosAsignadosMasiva");
		YAHOO.util.Event.onContentReady( "listenerDataTableFormulariosAsignadosMasiva" , dataTableFormulariosAsignadosMasiva );
		
		var txtDivTablaJS = "divDataTableFormulariosAsignadosMasiva";
		var txtDivDataTable = YAHOO.util.Dom.get( txtDivTablaJS );
		eval( txtDivDataTable.innerHTML );
		
		var datos 	= objDataTableNoAsignados['datos'];
		var titulos = objDataTableNoAsignados['titulos'];
		var txtDiv 	= "DataTableFormulariosAsignadosMasiva";
		
		var numRegistros 	= 20;
		var arrPaginacion 	= [ 10, 20, 50 , 100 ];
		var numAlto 		= "300px";
		var numAncho 		= "450px";
		
		mostrarDataTable( datos , titulos , txtDiv , numRegistros , arrPaginacion , numAlto , numAncho );
		
	}
	
	function dataTableFormulariosAsignados( txtMasiva ){
		
		eliminarObjeto("listenerDataTableFormulariosAsignados");
		YAHOO.util.Event.onContentReady( "listenerDataTableFormulariosAsignados" , dataTableFormulariosAsignados );
		
		var txtDivTablaJS = "divDataTableFormulariosAsignados";
		var txtDivDataTable = YAHOO.util.Dom.get( txtDivTablaJS );
		eval( txtDivDataTable.innerHTML );
		
		var datos 	= objDataTableNoAsignados['datos'];
		var titulos = objDataTableNoAsignados['titulos'];
		var txtDiv 	= "dataTableFormulariosAsignados";
		
		var numRegistros 	= 20;
		var arrPaginacion 	= [ 10, 20, 50 , 100 ];
		var numAlto 		= "300px";
		var numAncho 		= "450px";
		
		mostrarDataTable( datos , titulos , txtDiv , numRegistros , arrPaginacion , numAlto , numAncho );
		
	}
	
	function crearArbolFormulariosAsignar( ){
		
		eliminarObjeto("objArbolFormulariosAsignarListener");
		YAHOO.util.Event.onContentReady( "objArbolFormulariosAsignarListener" , crearArbolFormulariosAsignar );
		
		// Divs para los arboles
		// var txtDivArbol  = YAHOO.util.Dom.get( "txtDivArbolFormulariosAsignar" );
		// var txtDivArbol2 = YAHOO.util.Dom.get( "txtDivTutoresInformacion" );
		
		var txtDivArbol = YAHOO.util.Dom.get( "txtDivAsignacionFormularios" );
		eval( txtDivArbol.innerHTML );
		
		
		objArbolTutoresMasiva.subscribe('clickEvent', objArbolTutoresMasiva.onEventToggleHighlight);
		objArbolTutoresMasiva.setNodesProperty('propagateHighlightUp' 	, true);
		objArbolTutoresMasiva.setNodesProperty('propagateHighlightDown' , true);
		objArbolTutoresMasiva.subscribe(
			"labelClick", 
			function( objNodo ){ 
				idUsuario = objNodo.data.idUsuario;
				if(idUsuario != null){
					cargarContenido( "divTablasUsuariosFormulariosMasiva" , "./contenidos/crm/verFormulariosAsignadosUsuario.php" , "idUsuario=" + idUsuario + "&masiva=Masiva", true  );
				}
			}	
		)
		objArbolTutoresMasiva.render();
		
		YAHOO.util.Event.on( 'botonAsignacion', 'click', fncCamposMarcadosAsignacion , objArbolTutoresMasiva );
		YAHOO.util.Event.on( 'botonAsignacion', 'click', asignarFormulariosAsignados );
			
		objArbolTutoresInformacion.subscribe('clickEvent', objArbolTutoresInformacion.onEventToggleHighlight);
		objArbolTutoresInformacion.setNodesProperty('propagateHighlightUp' 	, true);
		objArbolTutoresInformacion.setNodesProperty('propagateHighlightDown' , true);
		objArbolTutoresInformacion.subscribe(
			"labelClick", 
			function( objNodo ){ 
				idUsuario = objNodo.data.idUsuario;
				if(idUsuario != null){
					cargarContenido( "divTablasUsuariosFormularios" , "./contenidos/crm/verFormulariosAsignadosUsuario.php" , "idUsuario=" + idUsuario + "", true  );
				}
			}	
		)
		objArbolTutoresInformacion.render();
		
		YAHOO.util.Event.on( 'descargaHogaresTutor', 'click', descargaHogaresTutor , objArbolTutoresInformacion );
		YAHOO.util.Event.on( 'descargaHogaresTotal', 'click', descargaHogaresTotal );
		
	
	}
	
	function crearArbolReportes ( ){
		
		var txtDivReporteCargar = YAHOO.util.Dom.get( "txtDivReporteCargar" );
		eval( txtDivReporteCargar.innerHTML );
		
		var txtCodigo;
		
		objArbol.render();

		objArbol.subscribe(
			"labelClick", 
			function( objNodo ){ 
				txtCodigo = objNodo.data.txtCodigo ;
				if(txtCodigo != null){
					cargarContenido( "contenidoReportes" , "./contenidos/"+ txtCodigo +".php" , "", true  );
				}
			}	
		)	

		cargarContenido( "contenidoReportes" , "./contenidos/"+ txtArchivoReporte +".php" , "", true  );
		eliminarObjeto("divArbolReportesListener");
		YAHOO.util.Event.onContentReady( "divArbolReportesListener" , crearArbolReportes );
		
		
	}
	
	function dlgConfirmacionDesembolsoListener(){
					
		// Acion de someter el formulario
		var handleSubmit = function() {
			this.submit();
		};
		
		// Cancela la accion de someter el formulario y cierra el cuadro de dialogo
		var handleCancel = function() {
			this.cancel();
		};
		
		// Cuando da Submit al formulario del dialogo este es la funcion que contesta
		var handleSuccess = function(o) {
			var response = o.responseText;
			response = response.split("<!")[0];
			document.getElementById("mensajes").innerHTML = response;
		};
		
		// Cuando se da submit y la accion falla este es el mensaje
		var handleFailure = function(o) {
			alert("Submission failed: " + o.status);
		};
	
		// Objeto de configuracion
		var objConfiguracion = {
			width       : "350px",
			fixedcenter : true,
			close       : false,
			draggable   : false,
			modal       : true,
         icon        : YAHOO.widget.SimpleDialog.ICON_WARN,
			buttons     : [ { text:"Salvar Información", handler:handleSubmit, isDefault:true },
						    { text:"Cancelar", handler:handleCancel } 
					      ],
			constraintoviewport : true
		};
	
		// Instancia el cuadro de dialogo
		var dialog1 = new YAHOO.widget.Dialog( "dlgConfirmacionDesembolso", objConfiguracion );
      
      dialog1.validate = function() {
         var objDatos = this.getData();
         var objBorrar = YAHOO.util.Dom.get( 'bolBorrar' );
         if( typeof( objDatos.confirmacion ) != "undefined" ){
            if ( objDatos.confirmacion.toUpperCase() == "BORRAR" ) {
               objBorrar.value = 1;
            } else {
               objBorrar.value = 0;
            }
         } 
         return true;
      };
      
		// Objeto callback del formulario para manejar la respuesta de este
		dialog1.callback = { success: handleSuccess, failure: handleFailure };
		
		// Muestra el cuadro de dialogo
		dialog1.render();
		dialog1.show();
	
		eliminarObjeto( "dlgConfirmacionDesembolsoListener" );
		YAHOO.util.Event.onContentReady( "dlgConfirmacionDesembolsoListener" , dlgConfirmacionDesembolsoListener );
		
	}
	
	function fncCamposMarcados( o, objArbol ){
		
		var camposOcultosReporteador = YAHOO.util.Dom.get( "camposOcultosReporteador" );
		camposOcultosReporteador.innerHTML = "";
		
		var hiLit = objArbol.getNodesByProperty('highlightState',1);
		if (YAHOO.lang.isNull(hiLit)) { 
			// alert("None selected");
		} else {
			for (var i = 0; i < hiLit.length; i++) {
				var idCampo = hiLit[i].data.idCampo;
				if( idCampo != "" ){
					camposOcultosReporteador.innerHTML += "<input type='hidden' name='sCamposDesembolso[]' value='"+ idCampo +"'>"+ idCampo;
				}
			}
			
		}
		//previewReporteador();
		
	}
	
	var listenerReporteador = function( ){

      eliminarObjeto( "objReporteadorListener" );
		YAHOO.util.Event.onContentReady( "objReporteadorListener" , listenerReporteador );
		
		var objTabView = new YAHOO.widget.TabView('tabCamposMostrar');
		var objTabView = new YAHOO.widget.TabView('tabTipoReportes');
		var objTabView = new YAHOO.widget.TabView('tabCondiciones');
		
		
		generarArbolReporteador( );
	}
	
	function generarArbolReporteador( ){
		
		var txtDivReporteardor = YAHOO.util.Dom.get( "txtDivArbolReporteador" );
		eval( txtDivReporteardor.innerHTML );
		
		
		YAHOO.util.Event.on( 'ejecutarReporteador', 'click', fncCamposMarcados , objArbol );
		YAHOO.util.Event.on( 'ejecutarReporteador', 'click', previewReporteador );
		
		YAHOO.util.Event.on( 'exportarReporte', 'click', fncCamposMarcados , objArbol );
		YAHOO.util.Event.on( 'exportarReporte', 'click', ejecutarReporteadorExportar );
		
		objArbol.subscribe('clickEvent', objArbol.onEventToggleHighlight);
		
			
		objArbol.setNodesProperty('propagateHighlightUp',true);
		objArbol.setNodesProperty('propagateHighlightDown',true);
		
		objArbol.render();
		
		
	}
	
	var listenerReporteadorProyectos = function( ){

      eliminarObjeto( "objReporteadorListenerProyectos" );
		YAHOO.util.Event.onContentReady( "objReporteadorListenerProyectos" , listenerReporteadorProyectos );
		
		var objTabView = new YAHOO.widget.TabView('tabCamposMostrar');
		var objTabView = new YAHOO.widget.TabView('tabTipoReportes');
		var objTabView = new YAHOO.widget.TabView('tabCondiciones');
		
		
		generarArbolReporteadorProyectos( );
	}
	
	function generarArbolReporteadorProyectos( ){
		
		var txtDivReporteardor = YAHOO.util.Dom.get( "txtDivArbolReporteador" );
		eval( txtDivReporteardor.innerHTML );
		
		
		YAHOO.util.Event.on( 'ejecutarReporteador', 'click', fncCamposMarcados , objArbol );
		YAHOO.util.Event.on( 'ejecutarReporteador', 'click', previewReporteadorProyectos );
		
		YAHOO.util.Event.on( 'exportarReporte', 'click', fncCamposMarcados , objArbol );
		YAHOO.util.Event.on( 'exportarReporte', 'click', ejecutarReporteadorProyectosExportar );
		
		objArbol.subscribe('clickEvent', objArbol.onEventToggleHighlight);
		
			
		objArbol.setNodesProperty('propagateHighlightUp',true);
		objArbol.setNodesProperty('propagateHighlightDown',true);
		
		objArbol.render();
		
		
	}
	
	function objArbolActosAdministrativos( ){
		var txtArbolActosAdministrativos = YAHOO.util.Dom.get( "objArbolActosAdministrativos" );
		eval( txtArbolActosAdministrativos.innerHTML );
		
		if( objArbol != "undefined" ){
			objArbol.render();
		}				
		eliminarObjeto( "objArbolActosAdministrativos" );
		YAHOO.util.Event.onContentReady( "objArbolActosAdministrativos" , objArbolActosAdministrativos );
	}
	
	function reporteFNA(){
		
		document.getElementById("tablaFNA").style.visibility = "visible";
		
		var myDataSource = new YAHOO.util.DataSource(YAHOO.util.Dom.get("datosFNA"));
		myDataSource.responseType = YAHOO.util.DataSource.TYPE_HTMLTABLE;
		myDataSource.responseSchema = {
		    fields: [
				{key:"TipoDocumentoPrincipal"},
				{key:"DocumentoPrincipal"},
				{key:"NombrePrincipal"},
				{key:"TipoDocumento"},
				{key:"Documento"},
				{key:"Nombre"},
				{key:"EstadoCivil"},
				{key:"Parentesco"},
				{key:"Modalidad"},
				{key:"Solucion"},
				{key:"ValorSubsidio"},
				{key:"Estado"},
				{key:"Cerrado"},
				{key:"ActoAdministrativo"}
		    ]
		};
		
		var myColumnDefs = [
				{key:"TipoDocumentoPrincipal", label: "Tipo Documento Principal"},
				{key:"DocumentoPrincipal", label: "Documento Principal"},
				{key:"NombrePrincipal", label: "Nombre Principal"},
				{key:"TipoDocumento", label: "Tipo Documento"},
				{key:"Documento", label: "Documento"},
				{key:"Nombre", label: "Nombre"},
				{key:"EstadoCivil", label: "estado Civil"},  	
				{key:"Parentesco", label: "Parentesco"},
				{key:"Modalidad", label: "Modalidad"},
				{key:"Solucion", label: "Solución"},
				{key:"ValorSubsidio", label: "Valor Subsidio"},  	
				{key:"Estado", label: "Estado"},
				{key:"Cerrado", label: "Cerrado"},
				{key:"ActoAdministrativo", label: "Acto Administrativo"}    		
		];
		
		var myPaginator = new YAHOO.widget.Paginator({ 
			rowsPerPage: 20, 
			template: YAHOO.widget.Paginator.TEMPLATE_ROWS_PER_PAGE, 
			rowsPerPageOptions: [20,40,60,80,100] 
		}); 
		
		var myConfigs = { 
			paginator: myPaginator,
			sortedBy:{key:"DocumentoPrincipal",dir:YAHOO.widget.DataTable.CLASS_DESC},
			width:"700"
		}
		
		var myDataTable = new YAHOO.widget.ScrollingDataTable(
			"tablaFNA", 
			myColumnDefs, 
			myDataSource,
			myConfigs
		);
		
		// Subscribe to events for row selection
        myDataTable.subscribe("rowMouseoverEvent", myDataTable.onEventHighlightRow);
        myDataTable.subscribe("rowMouseoutEvent", myDataTable.onEventUnhighlightRow);
        myDataTable.subscribe("rowClickEvent", myDataTable.onEventSelectRow);
        
		
		
		eliminarObjeto( "cargandoTablaFNA" );
		eliminarObjeto( "listenerReporteFNA" );		
		YAHOO.util.Event.onContentReady( "listenerReporteFNA" , reporteFNA );
		
        return { 
            oDS: myDataSource, 
            oDT: myDataTable 
        }; 		
			
	}	
	
	function hogaresSeleccionadosArrendamiento(){
			
		var myDataSource = new YAHOO.util.DataSource(YAHOO.util.Dom.get("hogaresSeleccionadosArrendamiento"));
			myDataSource.responseType = YAHOO.util.DataSource.TYPE_HTMLTABLE;
			myDataSource.responseSchema = {
			    fields: [
			    		{key:"numIte", parser: "number"},
			    		{key:"numTic", parser: "number"},
			    		{key:"tpoDoc", parser: "string"},
			            {key:"numDoc", parser: "number"},
			            {key:"txtNom", parser: "string"}
			    ]
			};
			
		var myColumnDefs = [
			{key:"numIte", label: "Item", width:30},
			{key:"numTic", label: "Numero Inscripción", width:90},
		    {key:"tpoDoc", label: "Tipo Documento"},
            {key:"numDoc", label: "Documento", formatter:"number"},
            {key:"txtNom", label: "Postulante Principal"}
		];
		
		var myPaginator = new YAHOO.widget.Paginator({ 
			rowsPerPage: 20, 
			template: YAHOO.widget.Paginator.TEMPLATE_ROWS_PER_PAGE, 
			rowsPerPageOptions: [20,40,60,80,100] ,
			pageLinks: 5 
		}); 
		
		var myConfigs = {
			paginator: myPaginator,
			width: "500px"
		}
		
		var myDataTable = new YAHOO.widget.ScrollingDataTable(
			"contenedorhogaresSeleccionadosArrendamiento", 
			myColumnDefs, 
			myDataSource,
			myConfigs
		);
		
		eliminarObjeto( "cargandoTablaArrendamiento" );
		eliminarObjeto( "listenerhogaresSeleccionadosArrendamiento" );		
		var objCantidadRegistros = YAHOO.util.Dom.get( "cantidadRegistros" );
			objCantidadRegistros.style.display = '';
		YAHOO.util.Event.onContentReady( "listenerhogaresSeleccionadosArrendamiento" , hogaresSeleccionadosArrendamiento );

	}	
	
	function listenersorteoArrendamiento(){
		
		var myDataSource = new YAHOO.util.DataSource(YAHOO.util.Dom.get("sorteoArrendamiento"));
			myDataSource.responseType = YAHOO.util.DataSource.TYPE_HTMLTABLE;
			myDataSource.responseSchema = {
			    fields: [
			    		{key:"numTic", parser: "number"}
			    ]
			};
			
		var myColumnDefs = [
			{key:"numTic", label: "Número Inscripción", width:90}
		];
		
		var myPaginator = new YAHOO.widget.Paginator({ 
			rowsPerPage: 20, 
			template: YAHOO.widget.Paginator.TEMPLATE_ROWS_PER_PAGE, 
			rowsPerPageOptions: [20,40,60,80,100],
			pageLinks: 5 
		}); 
		
		var myConfigs = {
			paginator: myPaginator,
			width: "80px"
		}
		
		var myDataTable = new YAHOO.widget.ScrollingDataTable(
			"contenedorSorteoArrendamiento", 
			myColumnDefs, 
			myDataSource,
			myConfigs
		);
		
		eliminarObjeto( "listenersorteoArrendamiento" );
		eliminarObjeto( "cargandoTablaArrendamiento" );		
		YAHOO.util.Event.onContentReady( "listenersorteoArrendamiento" , listenersorteoArrendamiento );
		
        return { 
            oDS: myDataSource, 
            oDT: myDataTable 
        }; 	
		
	}
	
	function cargaIndicadoresTutoresDesembolso(  ){
		cargarContenido( "divIndicadores" , "./contenidos/crm/indicadoresTutoresDesembolsoBase.php" , "" , true )
		eliminarObjeto( "divListenerIndicadoresTutoresDesembolso" );	
		YAHOO.util.Event.onContentReady( "divListenerIndicadoresTutoresDesembolso", cargaIndicadoresTutoresDesembolso );
	}
	
	function cargaIndicadoresSolicitudDesembolso(  ){
		cargarContenido( "divIndicadores" , "./contenidos/crm/indicadoresSolicitudDesembolso.php" , "" , true )
		eliminarObjeto( "divListenerIndicadoresSolicitudDesembolso" );	
		YAHOO.util.Event.onContentReady( "divListenerIndicadoresSolicitudDesembolso", cargaIndicadoresSolicitudDesembolso );
	}
	
	
	function cargaIndicadorAsignados ( ){
		var seqUsuario = YAHOO.util.Dom.get( "seqUsuario" ).value;
		
		cargarContenido( "divAsignados" 			 , "./contenidos/crm/cargaIndicadores.php" 	  , "faseIndicador=asignado&seqUsuario=" + seqUsuario , true )
		// cargarContenido( "trTiempoPromedioAsignados" , "./contenidos/crm/tiempoPromedioFases.php" , "faseIndicador=asignado&seqUsuario=" + seqUsuario , false )

		eliminarObjeto( "divListenerAsignados" );		
		YAHOO.util.Event.onContentReady( "divListenerAsignados", cargaIndicadorAsignados );
	}
	
	function cargaIndicadorRevisionOferta ( ){
		var seqUsuario = YAHOO.util.Dom.get( "seqUsuario" ).value;
		
		cargarContenido( "divRevisionOferta" 				, "./contenidos/crm/cargaIndicadores.php" 	 , "faseIndicador=revisionOferta&seqUsuario=" + seqUsuario , true )
		// cargarContenido( "trTiempoPromedioRevisionOferta" 	, "./contenidos/crm/tiempoPromedioFases.php" , "faseIndicador=revisionOferta&seqUsuario=" + seqUsuario , false )
		
		eliminarObjeto( "divListenerRevisionOferta" );		
		YAHOO.util.Event.onContentReady( "divListenerRevisionOferta", cargaIndicadorRevisionOferta );
	}
	
	function cargaIndicadorRevisionJuridica ( ){
		var seqUsuario = YAHOO.util.Dom.get( "seqUsuario" ).value;
		
		cargarContenido( "divRevisionJuridica" 				, "./contenidos/crm/cargaIndicadores.php" 	 , "faseIndicador=revisionJuridica&seqUsuario=" + seqUsuario , true )
		// cargarContenido( "trTiempoPromedioRevisionJuridica" , "./contenidos/crm/tiempoPromedioFases.php" , "faseIndicador=revisionJuridica&seqUsuario=" + seqUsuario , false )
		
		eliminarObjeto( "divListenerRevisionJuridica" );		
		YAHOO.util.Event.onContentReady( "divListenerRevisionOferta", cargaIndicadorRevisionJuridica );
	}
	
	function cargaIndicadorRevisionTecnica ( ){
		var seqUsuario = YAHOO.util.Dom.get( "seqUsuario" ).value;
		
		cargarContenido( "divRevisionTecnica" 				, "./contenidos/crm/cargaIndicadores.php" 	 , "faseIndicador=revisionTecnica&seqUsuario=" + seqUsuario , true )
		// cargarContenido( "trTiempoPromedioRevisionTecnica" 	, "./contenidos/crm/tiempoPromedioFases.php" , "faseIndicador=revisionTecnica&seqUsuario=" + seqUsuario , false )
		
		eliminarObjeto( "divListenerRevisionTecnica" );		
		YAHOO.util.Event.onContentReady( "divListenerRevisionTecnica", cargaIndicadorRevisionTecnica );
	}
	
	function cargaIndicadorEscrituracion ( ){
		var seqUsuario = YAHOO.util.Dom.get( "seqUsuario" ).value;
		
		cargarContenido( "divEscrituracion" 			 , "./contenidos/crm/cargaIndicadores.php" 	  , "faseIndicador=escrituracion&seqUsuario=" + seqUsuario , true )
		// cargarContenido( "trTiempoPromedioEscrituracion" , "./contenidos/crm/tiempoPromedioFases.php" , "faseIndicador=escrituracion&seqUsuario=" + seqUsuario , false )
		
		eliminarObjeto( "divListenerEscrituracion" );		
		YAHOO.util.Event.onContentReady( "divListenerEscrituracion", cargaIndicadorEscrituracion );
	}
	
	function cargaIndicadorRadicadoTitulos ( ){
		var seqUsuario = YAHOO.util.Dom.get( "seqUsuario" ).value;
		
		cargarContenido( "divRadicadoTitulos" 			 	, "./contenidos/crm/cargaIndicadores.php" 	  , "faseIndicador=radicadotitulos&seqUsuario=" + seqUsuario , true )
		// cargarContenido( "trTiempoPromedioRadicadoTitulos"  , "./contenidos/crm/tiempoPromedioFases.php" , "faseIndicador=escrituracion&seqUsuario=" + seqUsuario , false )
		
		eliminarObjeto( "divListenerRadicadoTitulos" );		
		YAHOO.util.Event.onContentReady( "divListenerRadicadoTitulos", cargaIndicadorRadicadoTitulos );
	}
	
	function cargaIndicadorEstudioTitulos ( ){
		var seqUsuario = YAHOO.util.Dom.get( "seqUsuario" ).value;
		
		cargarContenido( "divEstudioTitulos" 			  , "./contenidos/crm/cargaIndicadores.php" 	, "faseIndicador=estudioTitulos&seqUsuario=" + seqUsuario , true )
		// cargarContenido( "trTiempoPromedioEstudioTitulos" , "./contenidos/crm/tiempoPromedioFases.php"  , "faseIndicador=estudioTitulos&seqUsuario=" + seqUsuario , false )
		
		eliminarObjeto( "divListenerEstudioTitulos" );		
		YAHOO.util.Event.onContentReady( "divListenerEstudioTitulos", cargaIndicadorEstudioTitulos );
	}
	
	function cargaIndicadorSolicitudDesembolso ( ){
		var seqUsuario = YAHOO.util.Dom.get( "seqUsuario" ).value;
		
		cargarContenido( "divSolicitudDesembolso" , "./contenidos/crm/cargaIndicadores.php" , "faseIndicador=solicitudDesembolso&seqUsuario=" + seqUsuario , false )
		
		eliminarObjeto( "divListenerSolicitudDesembolso" );
		YAHOO.util.Event.onContentReady( "divListenerSolicitudDesembolso", cargaIndicadorSolicitudDesembolso );
	}
	
	
	function dataTableReporteIndicadorTutorDesembolso( ){
		
		var txtDivDataTable = YAHOO.util.Dom.get( "txtDivDataTableIndicadoresTutoresDesembolso" );
		eval( txtDivDataTable.innerHTML );
		
		var datos 	= objDataTableReporteIndicadores['datos'];
		var titulos = objDataTableReporteIndicadores['titulos'];
		var txtDiv 	= "DataTableIndicadorTutoresDesembolso";
		var numRegistros = 20;
		var arrPaginacion = [ 10 , 20 , 50 , 100 ];
		var numAlto = "300px";
		var numAncho = "510px";
		
		mostrarDataTable( datos , titulos , txtDiv , numRegistros , arrPaginacion , numAlto , numAncho );
		
		eliminarObjeto( "listenerDataTableIndicadoresTutoresDesembolso" );
		YAHOO.util.Event.onContentReady( "listenerDataTableIndicadoresTutoresDesembolso", dataTableReporteIndicadorTutorDesembolso );
		
	}

	/**
	 * MANEJA EL AUTOCOMPLETE DE LOS BARRIO
	 * @author Bernardo Zerda
	 * @param Array arrAutocomplete // porsicion 0 input posicion 1 conteniner posicion 2 localidad
	 * @return Void
	 * @version 1.0 2011 Enero
	 */
	 
	 function barrioAutocomplete( arrAutocomplete ){

		var objLocalidad = YAHOO.util.Dom.get( arrAutocomplete[2] );
		var seqLocalidad = objLocalidad.options[ objLocalidad.selectedIndex ].value;

	 	var objDataSource = new YAHOO.util.XHRDataSource("./contenidos/subsidios/barrioAutocomplete.php?seqLocalidad=" + seqLocalidad + "&" );
	 		objDataSource.responseType 		= YAHOO.util.XHRDataSource.TYPE_TEXT;
		    objDataSource.responseSchema 	= { recordDelim: "\n", fieldDelim: "\t" };
		    objDataSource.maxCacheEntries 	= 0;
		    objDataSource.flushCache();

		var objAutocomplete = new YAHOO.widget.AutoComplete( arrAutocomplete[0] , arrAutocomplete[1] , objDataSource );
	    	objAutocomplete.maxResultsDisplayed 	= 20;
	    	objAutocomplete.minQueryLength 			= 2;
	    	objAutocomplete.autoHighlight 			= true;
	    	objAutocomplete.useShadow 				= true;
	    	objAutocomplete.forceSelection 			= true;
	    	objAutocomplete.queryQuestionMark 		= false;
	    	objAutocomplete.allowBrowserAutocomplete = false;
	    	objAutocomplete.queryDelay = 0;

	    eliminarObjeto( "barrioListener" );
	    YAHOO.util.Event.onContentReady( "barrioListener" , barrioAutocomplete , [ 'txtBarrio' , 'barrioContainer' , 'seqLocalidad'] );

	    return {
	        oDS: objDataSource,
	        oAC: objAutocomplete
	    };
	 }

	function elegibilidadPryTabView(){
		eliminarObjeto( "elegibilidadPryTabView" );
		YAHOO.util.Event.onContentReady( "elegibilidadPryTabView" , elegibilidadPryTabView );
		var objTabView = new YAHOO.widget.TabView('pestanasProyectosElegibilidad');
		var objTabView = new YAHOO.widget.TabView('elegibilidad');
		// falta el elemento que bva a tener el foco por defecto
	}

	function desembolsoPryTabView(){
		eliminarObjeto( "desembolsoPryTabView" );
		YAHOO.util.Event.onContentReady( "desembolsoPryTabView" , desembolsoPryTabView );
		var objTabView = new YAHOO.widget.TabView('pestanasProyectosDesembolso');
		var objTabView = new YAHOO.widget.TabView('desembolso');
		// falta el elemento que bva a tener el foco por defecto
	}

	function seguimientoPryTabView(){
		eliminarObjeto( "seguimientoPryTabView" );
		YAHOO.util.Event.onContentReady( "seguimientoPryTabView" , seguimientoPryTabView );
		var objTabView = new YAHOO.widget.TabView('pestanasProyectosSeguimiento');
		var objTabView = new YAHOO.widget.TabView('seguimiento');
		// falta el elemento que bva a tener el foco por defecto
	}

	function cronogramaObrasTabView(){
		eliminarObjeto( "cronogramaObrasTabView" );
		YAHOO.util.Event.onContentReady( "cronogramaObrasTabView" , cronogramaObrasTabView );
		var objTabView = new YAHOO.widget.TabView('pestanasCronogramaObras');
		var objTabView = new YAHOO.widget.TabView('cronogramaObras');
		// falta el elemento que bva a tener el foco por defecto
	}

	function revTecnicaUnidadesTabView(){
		eliminarObjeto( "revTecnicaUnidadesTabView" );
		YAHOO.util.Event.onContentReady( "revTecnicaUnidadesTabView" , revTecnicaUnidadesTabView );
		var objTabView = new YAHOO.widget.TabView('pestanasRevTecnicaUnidades');
		var objTabView = new YAHOO.widget.TabView('revTecnicaUnidades');
		// falta el elemento que bva a tener el foco por defecto
	}