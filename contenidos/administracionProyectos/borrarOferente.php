<?php

    /**
     * ELIMINA EL OFERENTE QUE VIENE SELECCONADO
     * POR EL USUARIO EN EL LISTADO DE OFERENTES
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
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Oferente.class.php" );
	//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Proyecto.class.php" );
    //include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "RegistroActividades.class.php" );
      
    // Verifica que el valor sea numerico
    if( ! is_numeric( $_POST[ 'seqBorrar' ] ) ){
        exit(0);
    }
    
    // Verifica que el valor a editar no sea cero ni negativo
    if( $_POST[ 'seqBorrar' ] > 0 ){
        
        $seqOferente = $_POST[ 'seqBorrar' ]; // El id del Oferente a borrar
        
        // Carga los datos actuales del Oferente para efectos de mensjes
        $claOferente = new Oferente;
        $arrOferente = $claOferente->cargarOferente( $_POST['seqBorrar'] );
        
        // Elimina el Oferente
        $arrErrores = $claOferente->borrarOferente( $_POST['seqBorrar'] );
        
        // Registra la actividad en el log
        /*$claRegistro = new RegistroActividades;
        $claRegistro->registrarActividad( "Borrado" , 0 , $_SESSION['seqUsuario'] , "Borrado de Oferente: [" . $_POST['seqBorrar'] . "] " . $arrOferente[ $seqOferente ]->txtOferente . " Mensaje: " . implode( "," , $arrErrores ) );*/
        
        /**
         * Impresion de resultados
         */
         
        if( empty( $arrErrores ) ){
            $arrMensajes[] = "El Oferente <b>" . $arrOferente[ $seqOferente ]->txtNombreOferente . "</b> se ha eliminado del sistema";
            imprimirMensajes( array() , $arrMensajes , "salvarOferente" );
        }else{
            imprimirMensajes( $arrErrores , array() );
        }
    }

    // Desconecta la base de datos
    $aptBd->close();
?>
