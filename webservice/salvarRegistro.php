<?php

   // Esta variable de usa para ubicar los archivos a incluir
   $txtPrefijoRuta = "../";
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['phpmailer'] . "class.phpmailer.php" );

   // mientras se hace pruebas
//   $aptBd->execute( "DELETE FROM T_WSE_REGISTRO" );
//   $aptBd->execute( "DELETE FROM T_WSE_CUENTAS" );
   
   // Si algun campo no viene diligenciado lo quita del arreglo
   foreach( $_POST as $txtClave => $txtValor ){
      if( trim( $txtValor ) != "" ){
         $_POST[ $txtClave ] = $txtValor;
      } else{
         unset( $_POST[ $txtClave ] );
      }
   }
   
   // si el arrglo viene con campos diligenciados
   if( ! empty( $_POST ) ){
      
      // Almacenara los errores del proceso
      $arrErrores = array();
      
      // debe tener entidad diligenciada
      if( trim( $_POST['entidad'] ) == "" ){
         $arrErrores[] = "El campo 'Nombre de la Entidad' es un campo requerido";
      }
      
      // debe tener un nombre de contacto
      if( trim( $_POST['contacto'] ) == "" ){
         $arrErrores[] = "El campo 'Nombre del Contácto' es un campo requerido";
      }
      
      // debe haber un telefono
      if( trim( $_POST['telefono'] ) == "" ){
         $arrErrores[] = "El campo 'Teléfono' es un campo requerido";
      }
      
      // debe tener un correo electronico 
      if( trim( $_POST['correo'] ) == "" ){
         $arrErrores[] = "El campo 'Correo Electrónico' es un campo requerido";
      } else {
         $numPosicion = strpos( $_POST['correo'] , ".gov.co" );
         if( $numPosicion === false ){
            $arrErrores[] = "El correo registrado no se reconoce como correo distrital";
         }
      }
      
      // El nombre de usuario debe estar diligenciado
      if( trim( $_POST['usuario'] ) == "" ){
         $arrErrores[] = "El campo 'Nombre de Usuario' es un campo requerido";
      } else {
         
         // el nombre de usuario no puede estar repetido
         $sql = "
            SELECT seqCuenta
            FROM T_WSE_CUENTAS
            WHERE txtUsuario = '" . trim( $_POST['usuario'] ) . "'
         ";
         $objRes = $aptBd->execute( $sql );
         if( $objRes->RecordCount() > 0 ){
            $arrErrores[] = "El Nombre de Usuario '" . trim( $_POST['usuario'] ) . "' ya fue tomado por alguien mas y no está disponible";
         }
         
      }
      
      // la clave debe estar diligenciada
      if( trim( $_POST['clave'] ) == "" ){
         $arrErrores[] = "El campo 'Contraseña' es un campo requerido";
      }
      
      // si no hay errores procede con el registro
      if( empty( $arrErrores ) ){
         
         // numero de cuenta que se va a crear
         $seqCuenta = 0;
         
         // creacion de las cuentas
         $sql = "
            INSERT INTO T_WSE_CUENTAS (
               txtEntidad,
               txtContacto,
               numTelefono,
               numExtension,
               txtCorreo,
               txtUsuario,
               txtClave,
               bolActivo
            ) VALUES (
               '" . $_POST['entidad'] . "',
               '" . $_POST['contacto'] . "',
               '" . $_POST['telefono'] . "',
               '" . intval( $_POST['extension'] ) . "',
               '" . $_POST['correo'] . "',
               '" . $_POST['usuario'] . "',
               '" . $_POST['clave'] . "',
               '1'
            )
         ";
         $objRes = $aptBd->execute( $sql );
         $seqCuenta = $aptBd->Insert_ID();
         
         // para guardar los datos del reguistro no se guadrda la clave
         unset( $_POST['clave'] );
         $sql = "
            INSERT INTO T_WSE_REGISTRO (
               seqCuenta,
               fchConsulta,
               txtConsulta,
               txtDatos
            ) VALUES (
               '" . $seqCuenta . "',
               NOW(),
               'creacionCuenta',
               '" . implode(";", $_POST) . "'
            )
         ";
         $objRes = $aptBd->execute( $sql );        
         
         // llamado a la plantilla
         $claSmarty->assign( "arrPost" , $_POST );
         $claSmarty->assign( "numRequerimiento" , sha1( $_SERVER['REQUEST_TIME'] ) );
         $claSmarty->assign( "seqCuenta" , $seqCuenta );
         $claSmarty->display( "webservice/salvarRegistro.tpl" );
         
         // configuracion para el correo electronico
         $claMail             = new PHPMailer();
         $claMail->IsSMTP();                                               // telling the class to use SMTP
         $claMail->SMTPAuth   = true;                                      // enable SMTP authentication
         $claMail->SMTPSecure = $arrConfiguracion['correo']['seguridad'];  // sets the prefix to the servier
         $claMail->Host       = $arrConfiguracion['correo']['servidor'];   // sets GMAIL as the SMTP server
         $claMail->Port       = $arrConfiguracion['correo']['puerto'];     // set the SMTP port for the GMAIL server
         $claMail->Username   = $arrConfiguracion['correo']['usuario'];    // GMAIL username
         $claMail->Password   = $arrConfiguracion['correo']['clave'];      // GMAIL password
         $claMail->SetFrom('bzerdar@habitatbogota.gov.co', 'Registro de Cuentas web Service');
         $claMail->Subject    = utf8_decode( "Activación de cuentas Web Service SDVE" );
         
         $txtMensaje = "
            <table width='600px'>
               <tr>
                  <td style='padding:10px;'>
                     <img src='http://" . $_SERVER['HTTP_HOST'] . "/sipive/recursos/imagenes/escudo.png'>
                  </td>
                  <td style='padding:10px;'>
                     <strong>
                     <span style='font-size:30px;'>Secretaría distrital de Hábitat</span><br>
                     <span style='font-size:14px;'>Sistema de información de subsidios distritales de vivienda</span>
                     <strong>
                  </td>
               </tr>
               <tr>
                  <td colspan='2' style='padding:10px; font-size:18px; text-align:center' bgcolor='#e4e4e4'>
                     ACTIVACIÓN DE CUENTAS WEB SERVICE
                  </td>
               </tr>
               <tr>
                  <td colspan='2' style='padding:10px; font-size:14px; text-align:justify'>
                     Bienvenido " . $_POST['contacto'] . "<br><br>
                     Usted ha solicitado la creación de una cuenta de web service para la cosulta de información
                     de nuestro sistema. En éste momento la cuenta ya ha sido creada y requiere de activación.
                     Para realizar la activacion de la cuenta haga click en el enlace que aparece a continuación:<br><br>
                     <center style='font-size:16px; font-weight:bold;'>
                        <a href='http://" . $_SERVER['HTTP_HOST'] . "/sipive/webservice/activacion.php?cuenta=" . $seqCuenta . "'>
                           ACTIVAR CUENTA
                        </a>
                     </center><br>
                     Despues de activar su cuenta, podrá usar los datos suministrados en el registro para consumir
                     la información disponible a través de un cliente de web service.
                     Recuerde incluir la imágen única de registro proporcionada al momento de la creacion del registro.<br><br>
                     Cordial Saludo.<br>
                     Secretaría Distrital de Hábitat<br>
                     Subdirección de Recuros Puúblicos
                  </td>
               </tr>
            </table>
         ";
         
         $claMail->MsgHTML( $txtMensaje );
         
         $claMail->AddAddress( $_POST['correo'] , $_POST['contacto'] );
         $claMail->Send();

      } else {
         
         // Impresion de los errores
         $claSmarty->assign( "arrErrores" , $arrErrores );
         $claSmarty->display( "webservice/mensajes.tpl" );
         
      }
   }   
   
?>
