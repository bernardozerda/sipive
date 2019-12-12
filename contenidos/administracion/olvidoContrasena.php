<?php

/**
 * ESTE ARCHIVO ENVIA EL MAIL AL USUARIO
 * CAMBIANDO LA CONTRASE�A 
 * @author Bernardo Zerda
 * @version 1.0 Abril 2009
 */
// posicion relativa de los archivos a incluir
$txtPrefijoRuta = "../../";

// Inclusiones necesarias
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Usuario.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Autenticacion.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['nusoap'] . "nusoap.php" );

include( $txtPrefijoRuta . $arrConfiguracion['librerias']['phpmailer'] . "/src/PHPMailer.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['phpmailer'] . "/src/Exception.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['phpmailer'] . "/src/SMTP.php" );

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$arrErrores = array(); // donde se almacenan los errores
// Esta expresion regular valida que el correo electronico escrito por el usuario
// tenga una sintaxis correcta, si falla la sintaxis entra al error
// Si no tiene:   Usuario__________@servidor_________.(com net info)__.(opcional)(co es uk, opcional) --> Muestra un error                          
if (!mb_ereg("^[0-9a-zA-Z._\-]+\@[a-zA-Z0-9._\-]+\.([a-zA-z]{2,4})(([\.]{1})([a-zA-Z]{2}))?$", trim($_POST['correo']))) {
    $arrErrores[] = "No es un correo electr&oacute;nico v&aacute;lido";
}

// si no hay errores, continua
if (empty($arrErrores)) {

    // Clases necesarias
    $claAutenticacion = new Autenticacion;

    // Obtener correo del usuario
    $txtCorreo = $claAutenticacion->obtenerCorreoUsuario($_POST['olvidoUsuario']);
    if ($txtCorreo == "") {
        $arrErrores[] = "<b>" . $_POST['olvidoUsuario'] . "</b> no parece ser un usuario del sistema";
    }

    // Valida que el correo sea el mismo
    if (empty($arrErrores)) {
        if ($txtCorreo != $_POST['correo']) {
            $arrErrores[] = "El correo no coincide con el del usuario";
        } else {

            // Obtiene el identificador del usuario
            $seqUsuario = $claAutenticacion->obtenerIdentificadorUsuario($_POST['olvidoUsuario']);

            // Obtiene los datos actuales del usuario
            $arrUsuario = $claAutenticacion->cargarUsuario($seqUsuario);


            // Nueva clave
            $txtNuevaClave = $claAutenticacion->generarClaveNueva();

            // clave nueva encriptada
            $txtClaveEncriptada = sha1($txtNuevaClave);

            /**
             * NOTESE QUE CUANDO SE CAMBIA LA CLAVE POR OLVIDO
             * LA CLAVE QUEDA CAMBIADA Y VENCIDA, ESTO SE HACE
             * PARA QUE EL USUARIO, APENAS ENTRE USANDO LA CLAVE
             * GENERADA LE OBLIGUE A CAMBIAR LA CLAVE
             */
            $arrUsuario[$seqUsuario]->numVencimiento = -1;

            // Permisos que tenia el usuario
            $arrPrivilegios['crear'] = $arrUsuario[$seqUsuario]->bolCrear;
            $arrPrivilegios['editar'] = $arrUsuario[$seqUsuario]->bolEditar;
            $arrPrivilegios['borrar'] = $arrUsuario[$seqUsuario]->bolBorrar;
            $arrPrivilegios['cambiar'] = $arrUsuario[$seqUsuario]->bolCambiar;

            // Formatea los grupos para pasarlos como los necesita la funcion
            $arrPermisos = array();
            foreach ($arrUsuario[$seqUsuario]->arrGrupos as $seqProyecto => $arrGrupos) {
                foreach ($arrGrupos as $seqGrupo => $seqProyectoGrupo) {
                    $arrPermisos[$seqProyectoGrupo] = $seqProyectoGrupo;
                }
            }

            /**
             * ENVIA EL MAIL
             */
            $txtSubject = "Solicitud de Cambio de Clave";

            $txtMensajeHtml = "
                <center>
                    <table cellspacing='0'
                           cellpadding='20'
                           width='40%'
                           bgcolor='#FFFFFF'
                           style='
                             padding:5px;
                             font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                           '
                    >
                        <tr>
                            <td width='20%'
                                align='center'
                                style='border-bottom: 1px solid #c4c4c4;'
                            >
                                <img src='https://sdv.habitatbogota.gov.co/sipive/recursos/imagenes/bogota.jpg'>
                            </td>
                            <td align='center'
                                style='
                                    color:#666666;
                                    border-bottom: 1px solid #c4c4c4;
                                    font-size: 20px;
                                    padding-top: 15px;
                                    padding-bottom: 15px;
                
                                '
                            >
                                <p><strong>SISTEMA DE INFORMACIÓN DEL<br>PROGRAMA INTEGRAL DE VIVIENDA EFECTVA</strong></p>
                                <span style='font-size: 14px'>
                                    Secretar&iacute;a Distrital de H&aacute;bitat<br>
                                    Bogot&aacute; D.C. - Colombia
                                </span>
                            </td>                            
                        </tr>
                        <tr>
                            <td colspan='2' style='padding:40px;'>
                                <p>
                                    Hola " . $arrUsuario[$seqUsuario]->txtNombre . " " . $arrUsuario[$seqUsuario]->txtApellido . "
                                </p>
                                <p>
                                    Ha recibido este mensaje porque ha solicitado iniciar el procedimiento de recuperación de contraseñas.
                                    En este momento su contraseña ha sido restablecida y le solicitarémos cambiarla al momento de ingresar.
                                </p>
                                La clave que ha sido generada para su usuario es:
                            </td>
                        </tr>
                        <tr>
                            <td colspan='2' height='40px' bgcolor='#D4EDDA' style='color:##155724; font-size:18px;' align='center'>
                                $txtNuevaClave<br>
                                <span style='font-size: 12px'>
                                    <i>(Recuerde respetar mayusculas y minusculas)</i>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan='2' style='padding: 40px'>
                                Cordial saludo:<br>Equipo de Sistemas
                            </td>
                        </tr>
                    </table>
                </center>     
            ";

            $mail = new PHPMailer(true);
            try {

                $nombrecompleto = $arrUsuario[$seqUsuario]->txtNombre . " " . $arrUsuario[$seqUsuario]->txtApellido;

                //Server settings
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = $arrConfiguracion['correo']['servidor'];
                $mail->SMTPAuth = true;
                $mail->Username = $arrConfiguracion['correo']['usuario'];
                $mail->Password = $arrConfiguracion['correo']['clave'];
                $mail->SMTPSecure = $arrConfiguracion['correo']['seguridad'];
                $mail->Port = $arrConfiguracion['correo']['puerto'];

                //Recipients
                $mail->setFrom($mail->Username, $arrConfiguracion['correo']['nombre']);
                $mail->addAddress($txtCorreo, $nombrecompleto);     // Add a recipient
                $mail->addReplyTo($mail->Username, $arrConfiguracion['correo']['nombre']);

                //Content
                $mail->isHTML(true);
                $mail->Subject = $txtSubject;
                $mail->Body    = utf8_decode($txtMensajeHtml);

                $mail->send();

                $claAutenticacion = new Usuario();
                $arrErrores = $claAutenticacion->editarUsuario(
                    $seqUsuario,
                    $arrUsuario[$seqUsuario]->txtNombre,
                    $arrUsuario[$seqUsuario]->txtApellido,
                    $arrUsuario[$seqUsuario]->txtUsuario,
                    $txtClaveEncriptada,
                    $txtCorreo,
                    1,
                    $arrUsuario[$seqUsuario]->numVencimiento,
                    $arrPermisos,
                    $arrUsuario[$seqUsuario]->seqDependencia,
                    $arrUsuario[$seqUsuario]->txtMatriculaProfesional,
                    $arrPrivilegios
                );

            } catch (Exception $e) {
                $arrErrores[] = "No se ha podido enviar el correo al usuario seleccionado";
                $arrErrores[] = $mail->ErrorInfo;
            }

            /**
             * FIN ENVIO MAIL
             */
        }
    }
}

// muestra mensajes al usuario.
if (empty($arrErrores)) {
    $arrMensajes[] = "Se ha generado una nueva clave, que ha sido enviada a <b>" . $_POST['correo'] . "</b>, una vez entre al sistema, se le solicitar&aacute; que la cambie";
    //imprimirMensajes(array(), $arrMensajes);
    echo "<div class='alert alert-success' role='alert'>";
    foreach($arrMensajes as $txtMensajes){
        echo "<li>$txtMensajes</li>";
    }
    echo "</div>";
} else {

    //imprimirMensajes($arrErrores, array());
    echo "<div class='alert alert-danger' role='alert'>";
    foreach($arrErrores as $txtMensajes){
        echo "<li>$txtMensajes</li>";
    }
    echo "</div>";
}
?>
