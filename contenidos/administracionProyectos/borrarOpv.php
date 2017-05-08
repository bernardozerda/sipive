<?php

    /**
     * ELIMINA LA OPV QUE VIENE SELECCONADA
     * POR EL USUARIO EN EL LISTADO DE OPVS
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
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Opv.class.php" );
	//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Proyecto.class.php" );
    //include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "RegistroActividades.class.php" );
      
    // Verifica que el valor sea numerico
    if( ! is_numeric( $_POST[ 'seqBorrar' ] ) ){
        exit(0);
    }
    
    // Verifica que el valor a editar no sea cero ni negativo
    if( $_POST[ 'seqBorrar' ] > 0 ){
        
        $seqOpv = $_POST[ 'seqBorrar' ]; // El id de la Opv a borrar
        
        // Carga los datos actuales de la Opv para efectos de mensjes
        $claOpv = new Opv;
        $arrOpv = $claOpv->cargarOpv( $_POST['seqBorrar'] );
        
        // Elimina la Opv
        $arrErrores = $claOpv->borrarOpv( $_POST['seqBorrar'] );
        
        // Registra la actividad en el log
        /*$claRegistro = new RegistroActividades;
        $claRegistro->registrarActividad( "Borrado" , 0 , $_SESSION['seqUsuario'] , "Borrado de Opv: [" . $_POST['seqBorrar'] . "] " . $arrOpv[ $seqOpv ]->txtOpv . " Mensaje: " . implode( "," , $arrErrores ) );*/
        
        /**
         * Impresion de resultados
         */
         
        if( empty( $arrErrores ) ){
            $arrMensajes[] = "La Opv <b>" . $arrOpv[ $seqOpv ]->txtNombreOpv . "</b> se ha eliminado del sistema";
            imprimirMensajes( array() , $arrMensajes , "salvarOpv" );
        }else{
            imprimirMensajes( $arrErrores , array() );
        }
        
    }

    // Desconecta la base de datos
    $aptBd->close();
?>
