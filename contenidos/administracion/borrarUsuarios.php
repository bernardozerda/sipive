<?php

    /**
     * ELIMINA LOS USUARIOS 
     * @author Bernardo Zerda
     * @version 1.0 Abril 2009
     */

    // posicion relativa de los archivos a incluir
    $txtPrefijoRuta = "../../";

    // Autenticacion (si esta logueado no no)
    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

    // Inclusiones necesarias
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Usuario.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "RegistroActividades.class.php" );
    
    // Verifica que el valor sea numerico
    if( ! is_numeric( $_POST[ 'seqBorrar' ] ) ){
        exit(0);
    }
    
    // Verifica que el valor a editar no sea cero ni negativo
    if( $_POST[ 'seqBorrar' ] > 0 ){
        
        $seqUsuario = $_POST[ 'seqBorrar' ]; // Identificador del registro a borrar
         
        // obtiene los datos actuales para los mensajes
        $claUsuario   = new Usuario;
        $arrUsuario   = $claUsuario->cargarUsuario( $seqUsuario );
        
        // Elimina el registro del usuario
        $arrErrores = $claUsuario->borrarUsuario( $seqUsuario, $arrUsuario[ $seqUsuario ]->arrGrupos );
        
        // Registra la actividad del usuario
        $claRegistro = new RegistroActividades;
        $claRegistro->registrarActividad( "Borrado" , 0 , $_SESSION['seqUsuario'] , "Borrado de usuario: [ " . $seqUsuario . " ] " . $arrUsuario[ $seqUsuario ]->txtNombre . " " . $arrUsuario[ $seqUsuario ]->txtApellido . " Mensaje: " . implode( "," , $arrErrores ) );
        
        /**
         * Impresion de resultados
         */
         
        if( empty( $arrErrores ) ){
            $arrMensajes[] = "El usuario <b>" . $arrUsuario[ $seqUsuario ]->txtNombre . " " . $arrUsuario[ $seqUsuario ]->txtApellido . "</b> se ha eliminado del sistema";
            imprimirMensajes( array() , $arrMensajes , "salvarUsuario" );
        }else{
            imprimirMensajes( $arrErrores , array() );
        }
    
    }

    // Desconecta la base de datos
    $aptBd->close();
?>
