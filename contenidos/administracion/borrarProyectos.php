<?php

    /**
     * ELIMINA LA Proyecto QUE VIENE SELECCONADA
     * POR EL USUARIO EN EL LISTADO DE ProyectoS
     * @author Bernardo Zerda
     * @version 1.0 Marzo 2009
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
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "RegistroActividades.class.php" );
      
    // Verifica que el valor sea numerico
    if( ! is_numeric( $_POST[ 'seqBorrar' ] ) ){
        exit(0);
    }
    
    // Verifica que el valor a editar no sea cero ni negativo
    if( $_POST[ 'seqBorrar' ] > 0 ){
        
        $seqProyecto = $_POST[ 'seqBorrar' ]; // El id de la Proyecto a borrar
        
        // Carga los datos actuales de la Proyecto para efectos de mensjes
        $claProyecto = new Proyecto;
        $arrProyecto = $claProyecto->cargarProyecto( $_POST['seqBorrar'] );
        
        // Elimina la Proyecto
        $arrErrores = $claProyecto->borrarProyecto( $_POST['seqBorrar'] );
        
        // Registra la actividad en el log
        $claRegistro = new RegistroActividades;
        $claRegistro->registrarActividad( "Borrado" , 0 , $_SESSION['seqUsuario'] , "Borrado de Proyecto: [" . $_POST['seqBorrar'] . "] " . $arrProyecto[ $seqProyecto ]->txtProyecto . " Mensaje: " . implode( "," , $arrErrores ) );
        
        /**
         * Impresion de resultados
         */
         
        if( empty( $arrErrores ) ){
            $arrMensajes[] = "La Proyecto <b>" . $arrProyecto[ $seqProyecto ]->txtProyecto . "</b> se ha eliminado del sistema";
            imprimirMensajes( array() , $arrMensajes , "salvarProyecto" );
        }else{
            imprimirMensajes( $arrErrores , array() );
        }
        
    }

    // Desconecta la base de datos
    $aptBd->close();
?>
