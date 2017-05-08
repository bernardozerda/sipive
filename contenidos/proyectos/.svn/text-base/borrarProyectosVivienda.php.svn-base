<?php

    /**
     * ELIMINA EL PROYECTO DE VIVIENDA QUE VIENE SELECCIONADO
     * POR EL USUARIO EN EL LISTADO DE PROYECTOS
     * @author Jaison Ospina
     * @version 1.0 Agosto 2013
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
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "ProyectoVivienda.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "RegistroActividades.class.php" );
      
    // Verifica que el valor sea numerico
    if( ! is_numeric( $_POST[ 'seqBorrar' ] ) ){
        exit(0);
    }
    
    // Verifica que el valor a editar no sea cero ni negativo
    if( $_POST[ 'seqBorrar' ] > 0 ){
        
        $seqProyecto = $_POST[ 'seqBorrar' ]; // El id del Proyecto de vivienda a borrar
        
        // Carga los datos actuales del Proyecto de vivienda para efectos de mensajes
        $claProyectoVivienda = new ProyectoVivienda;
        $arrProyectoVivienda = $claProyectoVivienda->cargarProyectoVivienda( $_POST['seqBorrar'] );
        
        // Elimina el Proyecto de vivienda
        $arrErrores = $claProyectoVivienda->borrarProyectoVivienda( $_POST['seqBorrar'] );
        
        // Registra la actividad en el log
        $claRegistro = new RegistroActividades;
        $claRegistro->registrarActividad( "Borrado" , 0 , $_SESSION['seqUsuario'] , "Borrado de Proyecto: [" . $_POST['seqBorrar'] . "] " . $arrProyecto[ $seqProyecto ]->txtProyecto . " Mensaje: " . implode( "," , $arrErrores ) );
        
        /**
         * Impresion de resultados
         */
         
        if( empty( $arrErrores ) ){
            $arrMensajes[] = "La Proyecto de Vivienda <b>" . $arrProyectoVivienda[ $seqProyecto ]->txtProyecto . "</b> se ha eliminado del sistema";
            imprimirMensajes( array() , $arrMensajes , "salvarProyecto" );
        }else{
            imprimirMensajes( $arrErrores , array() );
        }
        
    }

    // Desconecta la base de datos
    $aptBd->close();
?>
