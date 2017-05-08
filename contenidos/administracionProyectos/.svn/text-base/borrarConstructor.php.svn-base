<?php

    /**
     * ELIMINA EL CONSTRUCTOR QUE VIENE SELECCONADO
     * POR EL USUARIO EN EL LISTADO DE CONSTRUCTOR
     * @author Jaison Ospina
     * @version 1.0 Noviembre 2013
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
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Constructor.class.php" );
	//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Proyecto.class.php" );
    //include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "RegistroActividades.class.php" );
      
    // Verifica que el valor sea numerico
    if( ! is_numeric( $_POST[ 'seqBorrar' ] ) ){
        exit(0);
    }
    
    // Verifica que el valor a editar no sea cero ni negativo
    if( $_POST[ 'seqBorrar' ] > 0 ){
        
        $seqConstructor = $_POST[ 'seqBorrar' ]; // El id del Constructor a borrar
        
        // Carga los datos actuales del Constructor para efectos de mensjes
        $claConstructor = new Constructor;
        $arrConstructor = $claConstructor->cargarConstructor( $_POST['seqBorrar'] );
        
        // Elimina el Constructor
        $arrErrores = $claConstructor->borrarConstructor( $_POST['seqBorrar'] );
        
        // Registra la actividad en el log
        /*$claRegistro = new RegistroActividades;
        $claRegistro->registrarActividad( "Borrado" , 0 , $_SESSION['seqUsuario'] , "Borrado de Constructor: [" . $_POST['seqBorrar'] . "] " . $arrConstructor[ $seqConstructor ]->txtConstructor . " Mensaje: " . implode( "," , $arrErrores ) );*/
        
        /**
         * Impresion de resultados
         */
         
        if( empty( $arrErrores ) ){
            $arrMensajes[] = "El Constructor <b>" . $arrConstructor[ $seqConstructor ]->txtNombreConstructor . "</b> se ha eliminado del sistema";
            imprimirMensajes( array() , $arrMensajes , "salvarConstructor" );
        }else{
            imprimirMensajes( $arrErrores , array() );
        }
    }

    // Desconecta la base de datos
    $aptBd->close();
?>
