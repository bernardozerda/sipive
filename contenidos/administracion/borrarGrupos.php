<?php

    /**
     * ELIMINA LOS GRUPOS SELECCIONADOS POR EL USUARIOS
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
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Proyecto.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Grupo.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "RegistroActividades.class.php" );
    
    // Verifica que el valor sea numerico
    if( ! is_numeric( $_POST[ 'seqBorrar' ] ) ){
        exit(0);
    }
    
    // Verifica que el valor a editar no sea cero ni negativo
    if( $_POST[ 'seqBorrar' ] > 0 ){
        
        $seqGrupo = $_POST[ 'seqBorrar' ]; // identificador a borrar
        
        // Obtiene los datos actuales
        $claGrupo   = new Grupo;
        $arrGrupo   = $claGrupo->cargarGrupo( $seqGrupo );
        
        // Borra el grupo selecconado
        $arrErrores = $claGrupo->borrarGrupos( $seqGrupo, $arrGrupo );
        
        // Registra la actividad
        $claRegistro = new RegistroActividades;   
        $claRegistro->registrarActividad( "Borrado" , 0 , $_SESSION['seqUsuario'] , "Borrado de Grupo: [ ".$seqGrupo." ] " . $arrGrupo[ $seqGrupo ]->txtNombre . " Mensaje: " . implode( "," , $arrErrores ) );
        
        /**
         * Impresion de resultados
         */
         
        if( empty( $arrErrores ) ){
            $arrMensajes[] = "El grupo <b>" . $arrGrupo[ $seqGrupo ]->txtNombre . "</b> se ha eliminado del sistema";
            imprimirMensajes( array() , $arrMensajes , "salvarGrupo" );
        }else{
            imprimirMensajes( $arrErrores , array() , "salvarGrupo" );
        }
    
    }

    // Desconecta la base de datos
    $aptBd->close();
?>
