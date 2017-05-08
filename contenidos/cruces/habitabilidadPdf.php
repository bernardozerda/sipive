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
       if( in_array( $seqGrupo , $claCasaMano->arrFases['cem']['habitabilidadPdf']['grupos'] ) ){
           $bolPermiso = true;
           break;
       }
   }

   if( $bolPermiso == true ){
      
      $seqFormulario = intval( array_shift( $_GET['exportar'] ) );
      
      $arrCasaMano = $claCasaMano->cargar($seqFormulario);
      $objCasaMano = $arrCasaMano[ intval( $_GET['seqCruce'] ) ];
      
      
      $txtTamanoFuente = 12;
      $txtTamanoCausas = $txtTamanoFuente - 2;
      $txtTamanoPie    = $txtTamanoCausas - 2;

      $claPdf =& new Cezpdf( "LETTER" );
      $claPdf->selectFont( $txtPrefijoRuta . "librerias/pdf/fonts/TimesNewRoman.afm");
      $claPdf->ezSetCmMargins( 1 , 0.5 , 1 , 1 );
      
      if( $objCasaMano->bolRevisionTecnica == 2 ){
         
         // Escudo
         $claPdf->ezImage( $txtPrefijoRuta . "recursos/imagenes/escudo.jpg" , 0, 70, 'none', 'center' );
         
         // Titulo
         $claPdf->ezText( "" );
         $claPdf->ezText("SUBSECRETARIA DE GESTION FINANCIERA", $txtTamanoFuente, array( "justification" => "center" ) );
         $claPdf->ezText( utf8_decode( "Subdirección de Recursos Públicos" ) , $txtTamanoFuente, array( "justification" => "center" ) );
         $claPdf->ezText( utf8_decode( "Grupo Técnico" ) . "\n\n", $txtTamanoFuente, array( "justification" => "center" ) );
         $claPdf->ezText( utf8_decode( "CONSTANCIA DE VISITA\n\n" ) , $txtTamanoFuente, array( "justification" => "center" ) );
         
         ;
         
         $fchVisita    = strftime( " %d días del mes de %B de %Y " , strtotime( $objCasaMano->fchRevisionTecnica ) );
         $txtDireccion = mb_strtoupper( $objCasaMano->objRegistroOferta->txtDireccionInmueble );
         $txtLocalidad = obtenerCampo("T_FRM_LOCALIDAD", $objCasaMano->objRegistroOferta->seqLocalidad , "txtLocalidad", "seqLocalidad" );
         $txtLocalidad = mb_strtoupper( trim( mb_substr($txtLocalidad, mb_strpos($txtLocalidad, "-") + 1 ) ) );
         
         foreach( $objCasaMano->objPostulacion->arrCiudadano as $objCiudadano ){
            if( $objCiudadano->seqParentesco == 1 ){
               break;
            }
         }
         $txtSexo = ( $objCiudadano->seqSexo == 1 )? "el señor" : "la señora";
         $txtNombre  = trim( $objCiudadano->txtNombre1 ) . " ";
         $txtNombre .= ( trim( $objCiudadano->txtNombre2 ) != "" )? $objCiudadano->txtNombre2 . " " : "";
         $txtNombre .= trim( $objCiudadano->txtApellido1 ) . " ";
         $txtNombre .= trim( $objCiudadano->txtApellido2 );
         
         $txtTipoDocumento = obtenerNombres("T_CIU_TIPO_DOCUMENTO", "seqTipoDocumento", $objCiudadano->seqTipoDocumento );
         
         $txtParrafo  = "En Bogotá D.C. a los " . $fchVisita . ", la Secretaria Distrital de Hábitat a través de su equipo técnico realizó la visita ";
         $txtParrafo .= "a la vivienda ubicada en " . $txtDireccion . ", del barrio " . mb_strtoupper( $objCasaMano->objRegistroOferta->txtBarrio ) . " ";
         $txtParrafo .= "de la localidad " . $txtLocalidad . " la cual pretende ser adquirida por el hogar cuyo postulante principal es " . $txtSexo . " ";
         $txtParrafo .= $txtNombre . " con " . $txtTipoDocumento . " número " . $objCiudadano->numDocumento . ", aspirante al Subsidio Distrital de Vivienda en Especie.";
         
         $claPdf->ezText( utf8_decode( trim( $txtParrafo ) ) . "\n" , $txtTamanoFuente , array( "justification" => "full" ));
         
         $txtParrafo  = "En dicha visita se pudo constatar que la vivienda NO CUMPLE, con los requisitos de existencia y habitabilidad exigidos por la "; 
         $txtParrafo .= "entidad, al encontrarse las novedades que a continuación se relacionan: ";
         
         $claPdf->ezText( utf8_decode( trim( $txtParrafo ) ) . "\n" , $txtTamanoFuente );
         
         $claPdf->ezText( utf8_decode( trim( $objCasaMano->txtRevisionTecnica ) ) . "\n" , $txtTamanoFuente );
         
         $fchHoy = strftime( " %d días del mes de %B de %Y " );
         $txtParrafo = "Para constancia se firma este certificado a los " . $fchHoy ." , por el técnico responsable de la realización de la visita.";
         
         $claPdf->ezText( utf8_decode( trim( $txtParrafo ) ) . "\n\n" , $txtTamanoFuente );
         
         $claPdf->ezText( utf8_decode( trim( $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido'] ) ) ."\n" , $txtTamanoFuente , array( "justification" => "center" ) );
         $numLinea = $claPdf->ezText( utf8_decode( "Matrícula Profesional: ______________________________" ) . "\n\n" , $txtTamanoFuente , array( "justification" => "center" ) );         
         
         // Baja hasta encontrar el pie de pagina
         while( $numLinea > 90 ){
             $numLinea = $claPdf->ezText( "" );
         }
      
         $claPdf->ezImage( $txtPrefijoRuta . "recursos/imagenes/pieCartas.jpg" , 0, 550, 'none', 'left' );
         
         // Imprime por pantalla
         $claPdf->ezStream();
         
      }
               
   } else {
      echo "<h1>No tiene los permisos suficientes para obtener las cartas</h1>";
   }
   
?>
