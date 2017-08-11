<?php

   $txtPrefijoRuta = "../../";

   include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "FormularioSubsidios.class.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "Ciudadano.class.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos2.class.php" );

   $arrErrores = array();
   $claTipoActo = new TipoActoAdministrativo();
   $arrTipoActo = $claTipoActo->cargarTipoActo( $_POST['seqTipoActo'] );
   $objTipoActo = array_shift( $arrTipoActo );
   $claActo     = new ActoAdministrativo();
   $arrActo     = array();
   
   /*******************************
    * VALIDACIONES DE LOS DATOS
    *******************************/
   
   // Validacion del numero del acto
   if( intval( $_POST['numActo'] ) == 0 ){
      $arrErrores[] = "Debe dar un número válido al acto administrativo";
   }
   
   // Validacion de la fecha del acto
   if( ! esFechaValida( $_POST['fchActo'] ) ){
      $arrErrores[] = "Debe dar una fecha válida para el acto administrativo";
   }
   
   // Validacion de las caracteristicas del acto
   $bolDiligenciado = false;
   foreach( $objTipoActo->arrCaracteristicas as $seqCaracteristica => $arrTipoDato ){
      if( trim( $_POST['caracteristicas'][ $seqCaracteristica ] ) != "" ){
         $bolError = false;
         switch( $arrTipoDato['txtTipo'] ){
            case "textarea":
               $bolError = ( trim( $_POST['caracteristicas'][ $seqCaracteristica ] ) != "" )? false : true;
               break;
            case "texto":
               $bolError = ( trim( $_POST['caracteristicas'][ $seqCaracteristica ] ) != "" )? false : true;
               break;
            case "numero":
               $bolError = ( floatval( $_POST['caracteristicas'][ $seqCaracteristica ] ) != 0 )? false : true;
               break;
            case "fecha":
               $bolError = ( esFechaValida( $_POST['caracteristicas'][ $seqCaracteristica ] ) == true )? false : true;
               break;
         }
         if( $bolError == true ){
            $arrErrores[] = "El valor digitado para el campo " . $arrTipoDato['txtNombre'] . " no es valido";
         }
         $bolDiligenciado = true;
      }
   }

   // Debe haber diligenciado al menos un campo de las caracteristicas
   if( $bolDiligenciado == false ){
      $arrErrores[] = "Diligencie los campos de información del acto admnistrativo";
   }

   if( empty( $arrErrores ) ){
      
      // El acto admnistrativo no debe existir, no se admite edicion (por ahora)
      $arrActo = $claActo->cargarActoAdministrativo( $_POST['numActo'] , $_POST['fchActo'] );
      if( empty( $arrActo ) ){
         
         // Revisa la carga del archivo
         switch( $_FILES['archivo']['error'] ){
            case UPLOAD_ERR_INI_SIZE:
              $arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
            break;  
            case UPLOAD_ERR_FORM_SIZE:
              $arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
            break; 
            case UPLOAD_ERR_PARTIAL:
              $arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
            break; 
            case UPLOAD_ERR_NO_FILE:
              $arrErrores[] = "Debe especificar un archivo para cargar";
            break; 
         } 
         
         if( empty( $arrErrores ) ){
         
            // Carga y limpieza del archivo
            $arrArchivo = file( $_FILES['archivo']['tmp_name'] );
            foreach( $arrArchivo as $numFila => $txtLinea ){
               if( trim( $txtLinea ) != "" ){
                  $arrLinea = mb_split( "\t" , trim( $txtLinea ) );
                  foreach( $arrLinea as $numColumna => $txtValor ){
                     $arrDatos[ $numFila ][ $numColumna ] = trim( $txtValor );
                  }
               }
            }
            
            // Validacion del archivo
            $objTipoActo->validarArchivo( $arrDatos );
            $arrErrores = $objTipoActo->arrErrores;

            // Validaciones de negocio
            if( empty( $arrErrores ) ){
               $objTipoActo->validarDatos( $_POST , $arrDatos );
               $arrErrores = $objTipoActo->arrErrores;
            }

            // salvar los datos
            if( empty( $arrErrores ) ){
               $claActo->salvarActo( $_POST , $arrDatos );
               $arrErrores = $claActo->arrErrores;
            }
            
         }
         
      }else{
         $arrErrores[] = "No puede editar actos administrativos, contacte al administrador";
      }
            
   }
   
   if( empty( $arrErrores ) ){
      $arrMensajes[] = "Ha cargado el acto administrativo " . $_POST['numActo'] . " del " . $_POST['fchActo'];
   }
   imprimirMensajes( $arrErrores , $arrMensajes );
   
?>
