<?php

   $txtPrefijoRuta = "../../";

   include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos2.class.php" );
   
   $arrTipoActo = array();
   $arrActos    = array();
   $claTipoActo = new TipoActoAdministrativo();
   $claActo     = new ActoAdministrativo();
   
   $arrTipoActo = $claTipoActo->cargarTipoActo();
   $arrActos    = $claActo->cargarActoAdministrativo( $_POST['numActo'] , $_POST['fchActo'] );
   $objActo     = $arrActos[ $_POST['numActo'] . strtotime( $_POST['fchActo'] ) ];

   $objActo->obtenerHogares();
   
   $arrArchivo[0][] = "Formulario";
   $arrArchivo[0][] = "Modalidad";
   $arrArchivo[0][] = "Solucion";
   $arrArchivo[0][] = "Desplazado";
   $arrArchivo[0][] = "Valor Subsidio";
   $arrArchivo[0][] = "Tipo Documento";
   $arrArchivo[0][] = "Documento";
   $arrArchivo[0][] = "Nombre";
   $arrArchivo[0][] = "id Parentesco";
   $arrArchivo[0][] = "Parentesco";
   $arrArchivo[0][] = "Etnia";
   $arrArchivo[0][] = "Condicion Especial";
   $arrArchivo[0][] = "Condicion Especial 2";
   $arrArchivo[0][] = "Condicion Especial 3";
   $arrArchivo[0][] = "Sexo";
   $arrArchivo[0][] = "Estado Civil";
   $arrArchivo[0][] = "Ingresos";
   $arrArchivo[0][] = "Fecha de Nacimiento";
   $arrArchivo[0][] = "Grupo LGTBI";
   $arrArchivo[0][] = "Tipo Victima";
   
   foreach( $objActo->arrHogares as $seqFormularioActo => $arrHogar ){
      foreach( $arrHogar['arrHogar'] as $numDocumento => $arrCiudadano ){
         $numLinea = count( $arrArchivo );
         $arrArchivo[ $numLinea ][] = $seqFormularioActo;
         $arrArchivo[ $numLinea ][] = $arrHogar['txtModalidad'];
         $arrArchivo[ $numLinea ][] = $arrHogar['txtSolucion'];
         $arrArchivo[ $numLinea ][] = $arrHogar['bolDesplazado'];
         $arrArchivo[ $numLinea ][] = $arrHogar['valAspiraSubsidio'];
         $arrArchivo[ $numLinea ] += $arrCiudadano;
      }
   }
       
   // Header para redireccionar cuando el archivo este listo
   header("Content-disposition: attachment; filename=" . time() . ".xls");
	header("Content-Type: application/force-download");
	header("Content-Type: text/plain; charset=ISO-8859-1");
	header("Content-Transfer-Encoding: base64");
	header("Pragma: no-cache");
	header("Expires: 1"); 
   
   $txtArchivo = "<table border=1>";
    if( count( $arrArchivo ) > 1 ){
        foreach( $arrArchivo as $numLinea => $arrLinea ){
            $txtColor = "";
            if( $numLinea == 0 ){
                $txtColor = "background-color:#666666;color:white;text-align:center;";
            }else{
                $txtColor = ( fmod( $numLinea , 2 ) == 0 )? "background-color:#e4e4e4" : "background-color:#ffffff";
            }
            $txtArchivo .= "<tr><td style='$txtColor'>" . implode("</td><td style='$txtColor'>", $arrLinea) . "</td></tr>";
        }
    }
    $txtArchivo .= "</table>";
    echo utf8_decode( $txtArchivo );
   
?>
