<?php

	/**
	 * IMPRESION DE LAS CARTAS DE ASIGNACION
	 * @author Bernardo Zerda
	 * @version 1.0 Noviembre de 2013
	 */

   date_default_timezone_set("America/Bogota");
   setlocale(LC_TIME , 'spanish' );
   
   ini_set("max_execution_time", 360 );
   ini_set("memory_limit", "1024M" );
      
	$txtPrefijoRuta = "../../";
	
   include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "Ciudadano.class.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "FormularioSubsidios.class.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "CasaMano.class.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos.class.php" );
   include( $txtPrefijoRuta . "librerias/pdf/class.ezpdf.php" );
   
   $_GET['parametro'] = mb_ereg_replace( "[^0-9A-Za-z:,\"\{\}]" , "" , $_GET['parametro'] ); 
   $objCartas = json_decode( $_GET['parametro'] );
   
    //$txtTextoCarta = $objCartas->texto;
    unset( $objCartas->texto );

   $arrCartas = array();
   $arrActoCartas = array();
   $claActo = new ActoAdministrativo();
   foreach( $objCartas as $seqFormularioActo ){
      
      $arrActo = $claActo->obtenerActoAdministrativo( $seqFormularioActo );
      $arrDatos = $claActo->cargarActoAdministrativoNumero( 1 , $arrActo['numActo'] , $arrActo['fchActo'] , $seqFormularioActo );
      
      $txtTextoCarta  = "Me complace comunicarle que la Secretaría Distrital del Hábitat, en cumplimiento del Decreto Distrital 539 de 2012 y de conformidad ";
      $txtTextoCarta .= "con la Resolución 176 del 2 de abril de 2013 \"Por medio de la cual se adopta el reglamento operativo para el otorgamiento del Subsidio ";
      $txtTextoCarta .= "Distrital de Vivienda en Especie para Vivienda de Interés Prioritario en el Distrito Capital, en el marco del Decreto Distrital 539 de 2012\", ";
      $txtTextoCarta .= "modificada por la Resolución 1168 del 5 de diciembre de 2013, expedidas por esta Entidad, le ha asignado un Subsidio Distrital de Vivienda ";
      $txtTextoCarta .= "en Especie, mediante Resolución " . $arrActo['numActo'] . " de " . strftime( "%d de %B de %Y" , strtotime( $arrActo['fchActo'] ) ) . ", ";
      $txtTextoCarta .= "con las siguientes condiciones:";
      
      $arrActoCartas[ $seqFormularioActo ]['numActo'] = $arrActo['numActo'];
      $arrActoCartas[ $seqFormularioActo ]['fchActo'] = $arrActo['fchActo'];
      
      for( $i = 1 ; $i < count( $arrDatos ) ; $i++ ){

         $seqFormulario = $arrDatos[ $i ][0];
         $numDocumento  = $arrDatos[ $i ][9];

         $arrCiudadano['modalidad']     = $arrDatos[ $i ][1];
         $arrCiudadano['solucion']      = $arrDatos[ $i ][2];
         $arrCiudadano['inscripcion']   = $arrDatos[ $i ][3];
         $arrCiudadano['postulacion']   = $arrDatos[ $i ][4];
         $arrCiudadano['actualizacion'] = $arrDatos[ $i ][5];
         $arrCiudadano['desplazado']    = $arrDatos[ $i ][6];
         $arrCiudadano['parentesco']    = $arrDatos[ $i ][7];
         $arrCiudadano['tipoDocumento'] = $arrDatos[ $i ][8];
         $arrCiudadano['documento']     = $arrDatos[ $i ][9];
         $arrCiudadano['nombre']        = $arrDatos[ $i ][10];
         $arrCiudadano['sexo']          = $arrDatos[ $i ][11];
         $arrCiudadano['idparentesco']  = $arrDatos[ $i ][12];
         $arrCiudadano['valorSubsidio'] = $arrDatos[ $i ][13];

         $arrCartas[ $seqFormularioActo ][ $numDocumento ] = $arrCiudadano;

      }
      
   }
   
//   echo count( $arrCartas );
//   pr( $arrCartas );
//   
//   exit(0);
   
   //*******************************************************************************//
   
   $txtTamanoFuente = 9;
   $txtTamanoTablas = $txtTamanoFuente - 1;
   $txtTamanoPie    = $txtTamanoTablas - 1;

   $claPdf =& new Cezpdf( "LETTER" );
   $claPdf->selectFont( $txtPrefijoRuta . "librerias/pdf/fonts/TimesNewRoman.afm");
   $claPdf->ezSetCmMargins( 1 , 0.5 , 1 , 1 );
   
   $claFormulario = new FormularioSubsidios();
   
   $numCartas = count( $arrCartas );
   $i = 0;
   foreach( $arrCartas as $seqFormularioActo => $arrCiudadano ){
      
       $sql = "SELECT seqFormulario FROM T_AAD_FORMULARIO_ACTO WHERE seqFormularioActo = $seqFormularioActo";
       $objRes = $aptBd->execute( $sql );
       $seqFormulario = $objRes->fields['seqFormulario'];
       
      $claFormulario->cargarFormulario( $seqFormulario );
      
      if( floatval( $claFormulario->numTelefono1 ) != 0 ){
         $numTelefono = $claFormulario->numTelefono1;
      } elseif( floatval( $claFormulario->numTelefono2 ) != 0 ){
         $numTelefono = $claFormulario->numTelefono2;
      } else {
         $numTelefono = $claFormulario->numCelular;
      }
      
      foreach( $arrCiudadano as $numDocumento => $arrDatos ){
         if( $arrDatos['idparentesco'] == 1 ){
            $txtSaludo1 = ( $arrDatos['sexo'] == 1 )? "Señor" : "Señora";
            $txtSaludo2 = ( $arrDatos['sexo'] == 1 )? "Apreciado Señor: " : "Apreciada Señora: ";
            $txtNombre = $arrDatos['nombre'];
            $txtModalidad = $arrDatos['modalidad'];
            $txtSolucion = $arrDatos['solucion'];
            $valSubsidio = $arrDatos['valorSubsidio'];
            break;
         }
      }
      
      // Escudo
      $claPdf->ezImage( $txtPrefijoRuta . "recursos/imagenes/escudo.jpg" , 0, 70, 'none', 'center' );

      // Fecha
      $txtFecha = utf8_decode( strftime( "Bogotá C.D. %d de %B de %Y\n" ) );
      $claPdf->ezText( $txtFecha , $txtTamanoFuente );
      
      // Saludo
      $claPdf->ezText( utf8_decode( $txtSaludo1 ) , $txtTamanoFuente );
      $claPdf->ezText( $txtNombre , $txtTamanoFuente );
      $claPdf->ezText( utf8_decode( mb_strtoupper( $claFormulario->txtDireccion ) . " / Teléfono: " . $numTelefono ) , $txtTamanoFuente );
      $claPdf->ezText( utf8_decode( "Ciudad\n" ) , $txtTamanoFuente );
      
      // Referencia
      setlocale(LC_TIME , 'spanish' );
      $txtResolucion = $arrActoCartas[ $seqFormularioActo ]['numActo'] . " del " . strftime( "%Y-%m-%d" , strtotime( $arrActoCartas[ $seqFormularioActo ]['fchActo'] ) );
      $claPdf->ezText( utf8_decode( "Carta de Asignación Subsidio Distrital de Vivienda. Resolución " . $txtResolucion . "\n" ) , $txtTamanoFuente );
      
      // Saludo de la carta
      $claPdf->ezText( utf8_decode( $txtSaludo2 . "\n" ) , $txtTamanoFuente );
      
      // Texto desconocido
      $claPdf->ezText( utf8_decode( $txtTextoCarta . "\n" ) , $txtTamanoFuente );
      
      // Datos del subsidio}
      $claPdf->ezText( utf8_decode( "Subsidio aplicable para: " ) . $txtModalidad , $txtTamanoFuente );
      $claPdf->ezText( utf8_decode( "Valor máximo de la vivienda: " ) . $txtSolucion , $txtTamanoFuente );
      $claPdf->ezText( utf8_decode( "Valor del subsidio asignado: $" . number_format( $valSubsidio ) ) , $txtTamanoFuente );
      $claPdf->ezText( utf8_decode( "Fecha de asignación: " . $arrActoCartas[ $seqFormularioActo ]['fchActo'] ) , $txtTamanoFuente );
      if( $claFormulario->seqModalidad == 11 ){
          $claPdf->ezText( utf8_decode( "Vigencia del subsidio: 6 meses" ) , $txtTamanoFuente );
      }else{
          $claPdf->ezText( utf8_decode( "Vigencia del subsidio: 1 año" ) , $txtTamanoFuente );
      }
      
      $claCasaMano = new CasaMano();
      $arrCasaMano = $claCasaMano->cargar( $seqFormulario );
      if( ! empty( $arrCasaMano ) ){
         foreach( $arrCasaMano as $objCasaMano ){}         
         $claPdf->ezText( utf8_decode( "Matrícula Inmobiliaria: " . strtoupper( $objCasaMano->objRegistroOferta->txtMatriculaInmobiliaria ) . "\n" ) , $txtTamanoFuente );
      }else{
          $claPdf->ezText( utf8_decode( "Matrícula Inmobiliaria: " . strtoupper( $claFormulario->txtMatriculaInmobiliaria ) . "\n" ) , $txtTamanoFuente );
      }
      
      // hogar
      $claPdf->ezText( utf8_decode( "El subsidio se asigna al hogar integrado por:\n" ) , $txtTamanoFuente );
      $arrTabla = array();
      foreach( $arrCiudadano as $numDocumento => $arrDatos ){
         $arrTabla[ $numDocumento ]['nombre'] = $arrDatos['nombre'];
         $arrTabla[ $numDocumento ]['tipo'] = $arrDatos['tipoDocumento'];
         $arrTabla[ $numDocumento ]['documento'] = number_format( $arrDatos['documento'] );
      }
      $claPdf->ezTable( 
         $arrTabla , 
         array( 
             "nombre" => "Nombre" , 
             "tipo" => "Tipo de Documento" , 
             "documento" => "Documento" 
         ),
         "",
         array(
            "showLines" => 0,
            "shaded" => 0,
            "fontSize" => $txtTamanoTablas,
            "rowGap" => 0,
            "width" => 500
         )
      );
      
      // Texto
      $txtTexto  = "Es indispensable que tenga en cuenta las instrucciones contenidas al respaldo de esta comunicación, ";
      $txtTexto .= "a efecto de tramitar el desembolso del subsidio. Estas hacen parte integral de la presente carta de asignación.";
      $claPdf->ezText( utf8_decode( "\n" . $txtTexto . "\n" ) , $txtTamanoFuente );
      
      $txtTexto  = "En nombre de la Secretaría Distrital del Hábitat los felicito. Trabajamos diariamente para alcanzar una Bogotá Humana ";
      $txtTexto .= "y cumplir los compromisos que el Gobierno Distrital ha adquirido con la ciudadanía, de manera que esperamos que este ";
      $txtTexto .= "aporte contribuya significativamente al mejoramiento de su calidad de vida. ";
      $claPdf->ezText( utf8_decode( $txtTexto . "\n" ) , $txtTamanoFuente );
      
//      $txtTexto = "NOTA: Esta carta reemplaza la originalmente entregada y es efectiva para todos los trámites del Subsidio Distrital de Vivienda";
//      $claPdf->ezText( utf8_decode( $txtTexto . "\n" ) , $txtTamanoFuente );
      
      $txtTexto = "Cordialmente,";
      $claPdf->ezText( utf8_decode( $txtTexto . "\n" ) , $txtTamanoFuente );
      
      // Firma
      $txtTexto = "MAURICIO CORTÉS GARZÓN";
      $claPdf->ezText( utf8_decode( $txtTexto ) , $txtTamanoFuente , array( "justification" => "center" ) );
      $txtTexto = "Subsecretario de Gestión Financiera";
      $numLinea = $claPdf->ezText( utf8_decode( $txtTexto . "\n" ) , $txtTamanoFuente , array( "justification" => "center" ) );
      
      while( $numLinea > 137 ){
         $numLinea = $claPdf->ezText( "" , $txtTamanoPie );
      }
      
      // Pie de Pagina
      $txtTexto = "Elaboró: " . $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido'] . " - Subdirección de Recursos Públicos";
      $claPdf->ezText( utf8_decode( $txtTexto ) , $txtTamanoPie );
      
      $txtTexto = "Revisó: Maria Teresa Tarazona Aldana- Profesional Universitario Subdirección de Recursos Públicos";
      $claPdf->ezText( utf8_decode( $txtTexto ) , $txtTamanoPie );
      
      $txtTexto = "Aprobó: Juan Sebastian Ortiz Rojas - Subdirectora Recursos Públicos";
      $claPdf->ezText( utf8_decode( $txtTexto . "\n\n" ) , $txtTamanoPie );
      
      $claPdf->ezImage( $txtPrefijoRuta . "recursos/imagenes/pieCartas.jpg" , 0, 550, 'none', 'left' );
      
      $i++;
      if( $i < $numCartas ){
         $claPdf->ezNewPage(); 
      }
      
   }
   
   $claPdf->ezStream();

?>
