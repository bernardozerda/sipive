<?php

    date_default_timezone_set("America/Bogota");
    setlocale(LC_TIME , 'spanish' );

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );   
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );   
   include( $txtPrefijoRuta . "librerias/pdf/class.ezpdf.php" );

   $arrCruces  = array();
   $claCasaMano = new CasaMano();

   $bolPermiso = false;
   $seqProyecto = $_SESSION['seqProyecto'];
   foreach( $_SESSION['arrGrupos'][ $seqProyecto ] as $seqGrupo ){
       if( in_array( $seqGrupo , $claCasaMano->arrFases['cem']['exportarPdf']['grupos'] ) ){
           $bolPermiso = true;
           break;
       }
   }

   if( $bolPermiso == true ){
	
       if( isset( $_GET['seqCruce'] ) and intval( $_GET['seqCruce'] ) > 0 ){

           $sql = "
               SELECT 
                   fchCruce,
                   txtCuerpo,
                   txtPie,
                   txtFirma,
                   txtElaboro,
                   txtReviso
               FROM T_CRU_CRUCES
               WHERE seqCruce = " . intval( $_GET['seqCruce'] ) . "
           ";
		   //echo $sql; die();
           $objRes = $aptBd->execute( $sql );
           if( $objRes->fields ){
               $arrTextos['fecha']   = $objRes->fields['fchCruce'];
               $arrTextos['cuerpo']  = $objRes->fields['txtCuerpo'];
               $arrTextos['pie']     = $objRes->fields['txtPie'];
               $arrTextos['firma']   = $objRes->fields['txtFirma'];
               $arrTextos['elaboro'] = $objRes->fields['txtElaboro'];
               $arrTextos['reviso']  = $objRes->fields['txtReviso'];
           }
			/*
           $sql = "
               SELECT 
                   res.seqFormulario,
                   res.numDocumento,
                   res.txtEntidad,
                   res.txtTitulo,
                   res.txtDetalle,
                   res.txtObservaciones,
                   res.bolInhabilitar
               FROM T_CRU_RESULTADO res
               INNER JOIN T_FRM_FORMULARIO frm ON res.seqFormulario = frm.seqFormulario
               WHERE frm.seqEstadoProceso IN ( 42 , 45 ,48 , 50 , 56 )
                 AND res.seqCruce = " . intval( $_GET['seqCruce'] ) . "
                 AND frm.seqFormulario IN ( " . implode( "," , $_GET['exportar'] ) . " )
           ";
		   */
		   $sql = "
               SELECT 
                   res.seqFormulario,
                   res.numDocumento,
                   res.txtEntidad,
                   res.txtTitulo,
                   res.txtDetalle,
                   res.txtObservaciones,
                   res.bolInhabilitar
               FROM T_CRU_RESULTADO res
               INNER JOIN T_FRM_FORMULARIO frm ON res.seqFormulario = frm.seqFormulario
               WHERE res.seqCruce = " . intval( $_GET['seqCruce'] ) . "
                 AND frm.seqFormulario IN ( " . implode( "," , $_GET['exportar'] ) . " )
           ";
		   
		   //echo $sql; die();
           $objRes = $aptBd->execute( $sql );
           while( $objRes->fields ){
               $seqFormulario = $objRes->fields['seqFormulario'];
               if( ! isset( $arrCruces[ $seqFormulario ] ) ){
                   $claFormulario = new FormularioSubsidios;
                   $claFormulario->cargarFormulario( $seqFormulario );
                   $arrCruces[ $seqFormulario ] = $claFormulario;
               }
               foreach( $arrCruces[ $seqFormulario ]->arrCiudadano as $seqCiudadano => $objCiudadano ){
                   if( mb_ereg_replace( "[^0-9]" , "" , $objCiudadano->numDocumento ) == $objRes->fields['numDocumento'] ){
                       $numIndice = count( $arrCruces[ $seqFormulario ]->arrCiudadano[ $seqCiudadano ]->arrCruces );
                       if( trim( $objRes->fields['bolInhabilitar'] ) == 1 ){
                           $arrCruces[ $seqFormulario ]->arrCiudadano[ $seqCiudadano ]->arrCruces[ $numIndice ]['txtEntidad'] = $objRes->fields['txtEntidad'];
                           $arrCruces[ $seqFormulario ]->arrCiudadano[ $seqCiudadano ]->arrCruces[ $numIndice ]['txtTitulo']  = $objRes->fields['txtTitulo'];
                           $arrCruces[ $seqFormulario ]->arrCiudadano[ $seqCiudadano ]->arrCruces[ $numIndice ]['txtDetalle'] = $objRes->fields['txtDetalle'];       
                       }
                   }
                   if( $objCiudadano->seqParentesco == 1 ){
                       $numPrincipal = mb_ereg_replace( "[^0-9]" , "" , $objCiudadano->numDocumento );
                   }
               }

               $objRes->MoveNext();
           }

       }    
       //pr($arrCruces);die();
       if( ! empty( $arrCruces ) ){

           $txtTamanoFuente = 10;
           $txtTamanoCausas = $txtTamanoFuente - 2;
           $txtTamanoPie    = $txtTamanoCausas - 2;

           $claPdf =& new Cezpdf( "LETTER" );
           $claPdf->selectFont( $txtPrefijoRuta . "librerias/pdf/fonts/TimesNewRoman.afm");
           $claPdf->ezSetCmMargins( 1 , 0.5 , 1 , 1 );

           $numTotalIteraciones = count( $arrCruces );
           $numIteraciones = 0;
           foreach( $arrCruces as $seqFormulario => $claFormulario ){

               // Escudo
               $claPdf->ezImage( $txtPrefijoRuta . "recursos/imagenes/escudo.jpg" , 0, 70, 'none', 'center' );

               // Ciudad
               $claPdf->ezText( utf8_decode( "Bogotá D.C.\n" ) , $txtTamanoFuente );

               // Obtiene el saludo segun el sexo del postulante principal y obtiene el nombre
               foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
                   if( $objCiudadano->seqParentesco == 1 ){
                       $txtEncabezado  = ( $objCiudadano->seqSexo == 1 )? "Señor" : "Señora";
                       $txtSaludo      = ( $objCiudadano->seqSexo == 1 )? "Apreciado señor" : "Apreciada señora";
                       $txtNombre      = $objCiudadano->txtNombre1 . " ";
                       $txtNombre     .= ( $objCiudadano->txtNombre2 != "" )? $objCiudadano->txtNombre2 . " " : "";
                       $txtNombre     .= $objCiudadano->txtApellido1 . " " . $objCiudadano->txtApellido2;
                       $claPdf->ezText( utf8_decode( $txtEncabezado ) , $txtTamanoFuente );
                       $claPdf->ezText( utf8_decode( $txtNombre ) , $txtTamanoFuente );
                   }
               }

               // Limpia a direcion de dobles espacios
               $txtDireccion = mb_strtoupper( $claFormulario->txtDireccion );
               do{
                   $txtDireccion = mb_ereg_replace("  " , " " , $txtDireccion );
               }while( mb_strpos($txtDireccion, "  ") !== false );

               // obtiene el telefono
               $numTelefono = "";
               if( trim( $claFormulario->numTelefono1 ) != "" ){
                   $numTelefono = trim( $claFormulario->numTelefono1 );
               }elseif ( trim( $claFormulario->numTelefono2 != "" ) ) {
                   $numTelefono = trim( $claFormulario->numTelefono2 );
               }else{
                   $numTelefono = trim( $claFormulario->numCelular );
               }
               $numTelefono = ( $numTelefono != "" )? " / " . $numTelefono : "";

               // pone la direccion y el telefono y la palabra ciudad
               $claPdf->ezText( utf8_decode( $txtDireccion . $numTelefono ) , $txtTamanoFuente );
               $claPdf->ezText( utf8_decode( "Ciudad\n" ) , $txtTamanoFuente );
               $claPdf->ezText( utf8_decode( "Ref: Requerimiento de información\n" ) , $txtTamanoFuente );
               $claPdf->ezText( utf8_decode( $txtSaludo . "\n" ) , $txtTamanoFuente );

               // cuerpo de la carta
               $claPdf->ezText( utf8_decode( $arrTextos['cuerpo'] . "\n" ) , $txtTamanoFuente , array( "justification" => "full" ) );

               // Limpia las inhabilidades vacias
			   if( is_array( $claFormulario->arrCiudadano ) ){
				   foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
					   if( is_array( $objCiudadano->arrCruces ) ) {
						   foreach( $objCiudadano->arrCruces as $numIndice => $arrInhabilidad ){
							   if( trim( $arrInhabilidad['txtEntidad'] ) == "" ){
								   unset( $objCiudadano->arrCruces[ $numIndice ] );
							   }
						   }
					   }
				   }
			   }

               // procesa las inhabilidades
               $numLinea = 0;
               foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
                   $txtInhabilidadCiudadano = "";
                   $txtInhabilidad    = "";

                   if( count( $objCiudadano->arrCruces ) >= 1 ){

                       $txtInhabilidadCiudadano .= obtenerCampo("T_CIU_TIPO_DOCUMENTO", $objCiudadano->seqTipoDocumento , "txtTipoDocumento", "seqTipoDocumento" ) . " ";
                       $txtInhabilidadCiudadano .= $objCiudadano->numDocumento . "; ";
                       $txtInhabilidadCiudadano .= $objCiudadano->txtNombre1 . " ";
                       $txtInhabilidadCiudadano .= ( $objCiudadano->txtNombre2 != "" )? $objCiudadano->txtNombre2 . " " : "";
                       $txtInhabilidadCiudadano .= $objCiudadano->txtApellido1 . " " . $objCiudadano->txtApellido2;
                       $numTotal = count( $objCiudadano->arrCruces );
                       $numIndice = 0; 
                       foreach( $objCiudadano->arrCruces as $arrInhabilidad ){
                           if( trim( $arrInhabilidad['txtEntidad'] ) != "" ){
                               $txtInhabilidad .= "<b>Entidad:</b> " . trim( $arrInhabilidad['txtEntidad'] ) . "; " .
                                                        "<b>Causa:</b> " . trim( $arrInhabilidad['txtTitulo'] ) . "\n" .
                                                        "<b>Detalle:</b> " . trim( $arrInhabilidad['txtDetalle'] );
                               if( $numIndice < $numTotal ){
                                   $txtInhabilidad .= "\n";
                               }
                           } 
                       }
                       $claPdf->ezText( utf8_decode( $txtInhabilidadCiudadano ) , $txtTamanoCausas );
                       $numLinea = $claPdf->ezText( utf8_decode( $txtInhabilidad ) , $txtTamanoCausas );
                   }
               }

               // Si esta por debajo de la linea 220 segun lo que retorna la clase pdf entonces salta la pagina
               if( $numLinea < 220 ){       
                  $claPdf->ezNewPage(); 
                  $claPdf->ezImage( $txtPrefijoRuta . "recursos/imagenes/escudo.jpg" , 0, 70, 'none', 'center' );
               }

               // pie de la carta
               $numLinea = $claPdf->ezText( utf8_decode( $arrTextos['pie'] . "\n" ) , $txtTamanoFuente , array( "justification" => "full" ) );

               if( $numLinea < 90 ){       
                  $claPdf->ezNewPage(); 
                  $claPdf->ezImage( $txtPrefijoRuta . "recursos/imagenes/escudo.jpg" , 0, 70, 'none', 'center' );
               }

               $numLinea = $claPdf->ezText( utf8_decode( "Cordialmente,\n\n" ) , $txtTamanoFuente );
               $numLinea = $claPdf->ezText( utf8_decode( $arrTextos['firma'] ) , $txtTamanoFuente );
               $numLinea = $claPdf->ezText( utf8_decode( "Subdirector(a) de Recursos Públicos" ) , $txtTamanoFuente );

               // Baja hasta encontrar el pie de pagina
               while( $numLinea > 120 ){
                   $numLinea = $claPdf->ezText( "" );
               }

               $numLinea = $claPdf->ezText( utf8_decode( "Elaboró: " . $arrTextos['elaboro'] . "  Subdirección de Recursos Públicos" ) , $txtTamanoPie );
               $numLinea = $claPdf->ezText( utf8_decode( "Revisó: " . $arrTextos['reviso'] . "  Subdirección de Recursos Públicos\n\n" ) , $txtTamanoPie );

               $claPdf->ezImage( $txtPrefijoRuta . "recursos/imagenes/pieCartas.jpg" , 0, 550, 'none', 'left' );

               // si es la ultiam hoja no manda el salto de pagina
               $numIteraciones++;
               if( $numIteraciones < $numTotalIteraciones ){
                   $claPdf->ezNewPage();
               }
           }

           // Imprime por pantalla
           $claPdf->ezStream();

       } else {
           echo "<h1>No hay resultados para mostrar</h1>";
       }

   } else {
       echo "<h1>No tiene los permisos suficientes para obtener las cartas</h1>";
   }
        
?>
