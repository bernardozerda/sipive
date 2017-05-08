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
   
   $arrTipoActo = $claTipoActo->cargarTipoActo( $_POST['seqTipoActo'] );
   $arrActos    = $claActo->cargarActoAdministrativo( $_POST['numActo'] , $_POST['fchActo'] );
   $objActo     = $arrActos[ $_POST['numActo'] . strtotime( $_POST['fchActo'] ) ];
   
   switch( $_POST['seqTipoActo'] ){
      case 1: // asignacion
         
         $objActo->obtenerGiros();
         
         $arrArchivo[0][] = "Tipo Documento";
         $arrArchivo[0][] = "Documento";
         $arrArchivo[0][] = "Nombre";
         $arrArchivo[0][] = "Subsidio";
         $arrArchivo[0][] = "Proyecto Inversion";
         $arrArchivo[0][] = "Fecha Giro";
         $arrArchivo[0][] = "Fecha Actualizacion Giro";
         $arrArchivo[0][] = "Registro Presupuestal 1";
         $arrArchivo[0][] = "Fecha Registro Presupuestal 1";
         $arrArchivo[0][] = "Registro Presupuestal 2";
         $arrArchivo[0][] = "Fecha Registro Presupuestal 2";
         $arrArchivo[0][] = "Numero de Radicacion";
         $arrArchivo[0][] = "Fecha de Radicacion";
         $arrArchivo[0][] = "Valor Solicitado";
         $arrArchivo[0][] = "Numero de Orden";
         $arrArchivo[0][] = "Fecha de Orden";
         $arrArchivo[0][] = "Valor Orden";
         $arrArchivo[0][] = "Nombre Beneficiario Giro";
         $arrArchivo[0][] = "Documento Beneficiario Giro";
         $arrArchivo[0][] = "Direccion Beneficiario Giro";
         $arrArchivo[0][] = "Telefono Beneficiario Giro";
         $arrArchivo[0][] = "Cuenta Beneficiario Giro";
         $arrArchivo[0][] = "Tipo Cuenta Beneficiario Giro";
         $arrArchivo[0][] = "idBanco Beneficiario Giro";
         $arrArchivo[0][] = "Banco Beneficiario Giro";
         $arrArchivo[0][] = "Giro a Tercero";
         $arrArchivo[0][] = "Nombre Tercero";
         $arrArchivo[0][] = "Correo Beneficiario Giro";
         
         foreach( $objActo->arrMasInformacion as $seqFormularioActo => $arrHogar ){
            foreach( $arrHogar['arrMasInformacion'] as $seqGiro => $arrGiro ){
               $numLinea = count( $arrArchivo );
               $arrArchivo[ $numLinea ][] = $arrHogar['txtTipoDocumento'];
               $arrArchivo[ $numLinea ][] = $arrHogar['numDocumento'];
               $arrArchivo[ $numLinea ][] = $arrHogar['txtNombre'];
               $arrArchivo[ $numLinea ][] = $arrHogar['valAspiraSubsidio'];
               $arrArchivo[ $numLinea ] += $arrGiro;
            }
         }
         
         break;
      case 2:
         
         $objActo->obtenerModificaciones();
         
         $arrArchivo[0][] = "Tipo Documento";
         $arrArchivo[0][] = "Documento";
         $arrArchivo[0][] = "Nombre";
         $arrArchivo[0][] = "Campo Modificado";
         $arrArchivo[0][] = "Valor Incorrecto";
         $arrArchivo[0][] = "Valor Correcto";
         
         foreach( $objActo->arrMasInformacion as $numDocumento => $arrCiudadano ){
            foreach( $arrCiudadano['arrModificaciones'] as $arrModificacion ){
               $numLinea = count( $arrArchivo );
               $arrArchivo[ $numLinea ][] = $arrCiudadano['txtTipoDocumento'];
               $arrArchivo[ $numLinea ][] = $numDocumento;
               $arrArchivo[ $numLinea ][] = $arrCiudadano['txtNombre'];
               $arrArchivo[ $numLinea ][] = $arrModificacion['txtCampo'];
               $arrArchivo[ $numLinea ][] = $arrModificacion['txtIncorrecto'];
               $arrArchivo[ $numLinea ][] = $arrModificacion['txtCorrecto'];
            }
         }
         
         break;
      case 3: // inhabilitados
         
         $objActo->obtenerInhabilidades();
         
         $arrArchivo[0][] = "Tipo Documento Principal";
         $arrArchivo[0][] = "Documento Principal";
         $arrArchivo[0][] = "Tipo Documento";
         $arrArchivo[0][] = "Documento";
         $arrArchivo[0][] = "Nombre";
         $arrArchivo[0][] = "Fuente";
         $arrArchivo[0][] = "Causa";
         $arrArchivo[0][] = "Detalle";
         
         foreach( $objActo->arrMasInformacion as $seqFormularioActo => $arrInformacion ){
            foreach( $arrInformacion['arrInhabilidades'] as $numDocumento => $arrInhabilidades ){
               if( ! empty( $arrInhabilidades['arrListado'] ) ){
                  foreach( $arrInhabilidades['arrListado'] as $arrRegistro ){
                     $numLinea = count( $arrArchivo );
                     $arrArchivo[ $numLinea ][] = $arrInformacion['arrPrincipal']['txtTipoDocumento'];
                     $arrArchivo[ $numLinea ][] = $arrInformacion['arrPrincipal']['numDocumento'];
                     $arrArchivo[ $numLinea ][] = $arrInhabilidades['txtTipoDocumento'];
                     $arrArchivo[ $numLinea ][] = $numDocumento;
                     $arrArchivo[ $numLinea ][] = $arrInhabilidades['txtNombre'];
                     $arrArchivo[ $numLinea ][] = $arrRegistro['txtFuente'];
                     $arrArchivo[ $numLinea ][] = $arrRegistro['txtCausa'];
                     $arrArchivo[ $numLinea ][] = $arrRegistro['txtInhabilidad'];
                  }
               }else{
                  $numLinea = count( $arrArchivo );
                  $arrArchivo[ $numLinea ][] = $arrInformacion['arrPrincipal']['txtTipoDocumento'];
                  $arrArchivo[ $numLinea ][] = $arrInformacion['arrPrincipal']['numDocumento'];
                  $arrArchivo[ $numLinea ][] = $arrInhabilidades['txtTipoDocumento'];
                  $arrArchivo[ $numLinea ][] = $numDocumento;
                  $arrArchivo[ $numLinea ][] = $arrInhabilidades['txtNombre'];
                  $arrArchivo[ $numLinea ][] = "";
                  $arrArchivo[ $numLinea ][] = ""; 
                  $arrArchivo[ $numLinea ][] = "";
               }
            }
         }
         
         break;
      case 4: // recursos de reposicion
         
         $objActo->obtenerResultado();
         
         $arrArchivo[0][] = "Tipo Documento";
         $arrArchivo[0][] = "Documento";
         $arrArchivo[0][] = "Nombre";
         $arrArchivo[0][] = "Resolucion Referencia";
         $arrArchivo[0][] = "Fecha Referencia";
         $arrArchivo[0][] = "Resultado";
         
         foreach( $objActo->arrMasInformacion as $numDocumento => $arrInformacion ){
            $numLinea = count( $arrArchivo );
            $arrArchivo[ $numLinea ][] = $arrInformacion['txtTipoDocumento'];
            $arrArchivo[ $numLinea ][] = $numDocumento;
            $arrArchivo[ $numLinea ][] = $arrInformacion['txtNombre'];
            $arrArchivo[ $numLinea ][] = $objActo->arrCaracteristicas[5];
            $arrArchivo[ $numLinea ][] = $objActo->arrCaracteristicas[6];
            $arrArchivo[ $numLinea ][] = $arrInformacion['txtEstadoReposicion'];
         }
         
         break;
      case 5: // no asignados
         
         $objActo->obtenerNoAsignados();
         
         $arrArchivo[0][] = "Tipo Documento";
         $arrArchivo[0][] = "Documento";
         $arrArchivo[0][] = "Nombre";
         
         foreach( $objActo->arrMasInformacion as $numDocumento => $arrInformacion ){
            $numLinea = count( $arrArchivo );
            $arrArchivo[ $numLinea ][] = $arrInformacion['txtTipoDocumento'];
            $arrArchivo[ $numLinea ][] = $numDocumento;
            $arrArchivo[ $numLinea ][] = $arrInformacion['txtNombre'];
         }
         
         break;
      case 6: // renuncia
         
         $objActo->obtenerRenuncias();
         
         $arrArchivo[0][] = "Tipo Documento";
         $arrArchivo[0][] = "Documento";
         $arrArchivo[0][] = "Nombre";
         
         foreach( $objActo->arrMasInformacion as $numDocumento => $arrInformacion ){
            $numLinea = count( $arrArchivo );
            $arrArchivo[ $numLinea ][] = $arrInformacion['txtTipoDocumento'];
            $arrArchivo[ $numLinea ][] = $numDocumento;
            $arrArchivo[ $numLinea ][] = $arrInformacion['txtNombre'];
         }
         
         break;
      case 7: // notificaciones
         
         $objActo->obtenerNotificaciones();
         
         $arrArchivo[0][] = "Tipo Documento";
         $arrArchivo[0][] = "Documento";
         $arrArchivo[0][] = "Nombre";
         $arrArchivo[0][] = "Resolucion Referencia";
         $arrArchivo[0][] = "Fecha Referencia";
         
         foreach( $objActo->arrMasInformacion as $numDocumento => $arrInformacion ){
            $numLinea = count( $arrArchivo );
            $arrArchivo[ $numLinea ][] = $arrInformacion['tipo'];
            $arrArchivo[ $numLinea ][] = $numDocumento;
            $arrArchivo[ $numLinea ][] = $arrInformacion['nombre'];
            $arrArchivo[ $numLinea ][] = $arrInformacion['numero'];
            $arrArchivo[ $numLinea ][] = $arrInformacion['fecha'];
         }
         
         break;
      case 8: // indexacion
         
         $objActo->obtenerIndexacion();
         
         $arrArchivo[0][] = "Tipo Documento";
         $arrArchivo[0][] = "Documento";
         $arrArchivo[0][] = "Nombre";
         $arrArchivo[0][] = "Resolucion";
         $arrArchivo[0][] = "Fecha";
         $arrArchivo[0][] = "Indexacion";
         $arrArchivo[0][] = "Valor Original";
         $arrArchivo[0][] = "Valor Total";
         
         foreach( $objActo->arrMasInformacion as $numDocumento => $arrInformacion ){
            $numLinea = count( $arrArchivo );
            $arrArchivo[ $numLinea ][] = $arrInformacion['txtTipoDocumento'];
            $arrArchivo[ $numLinea ][] = $numDocumento;
            $arrArchivo[ $numLinea ][] = $arrInformacion['txtNombre'];
            $arrArchivo[ $numLinea ][] = $arrInformacion['numActoReferencia'];
            $arrArchivo[ $numLinea ][] = $arrInformacion['fchActoReferencia'];
            $arrArchivo[ $numLinea ][] = $arrInformacion['valIndexado'];
            $arrArchivo[ $numLinea ][] = $arrInformacion['valAspiraSubsidio'];
            $arrArchivo[ $numLinea ][] = $arrInformacion['valTotal'];
         }
         
         break;
   }
   
   // Header para redireccionar cuando el archivo este listo
   header("Content-disposition: attachment; filename=" . time() . ".xls");
	header("Content-Type: application/force-download");
	header("Content-Type: text/plain; charset=ISO-8859-1");
	header("Content-Transfer-Encoding: base64");
	header("Pragma: no-cache");
	header("Expires: 1");   
   
   $txtArchivo = "<table border=1>";
    if( count( $arrArchivo ) >= 1 ){
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

