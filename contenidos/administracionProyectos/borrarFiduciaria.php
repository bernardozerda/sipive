<?php

    /**
     * ELIMINA LA FIDUCIARIA QUE VIENE SELECCONADA
     * POR EL USUARIO EN EL LISTADO DE FIDUCIARIA
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
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Fiduciaria.class.php" );
	//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Proyecto.class.php" );
    //include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "RegistroActividades.class.php" );
      
    // Verifica que el valor sea numerico
    if( ! is_numeric( $_POST[ 'seqBorrar' ] ) ){
        exit(0);
    }
    
    // Verifica que el valor a editar no sea cero ni negativo
    if( $_POST[ 'seqBorrar' ] > 0 ){
        
        $seqFiduciaria = $_POST[ 'seqBorrar' ]; // El id de la Fiduciaria a borrar
        
        // Carga los datos actuales de la Fiduciaria para efectos de mensjes
        $claFiduciaria = new Fiduciaria;
        $arrFiduciaria = $claFiduciaria->cargarFiduciaria( $_POST['seqBorrar'] );
        
        // Elimina la Fiduciaria
        $arrErrores = $claFiduciaria->borrarFiduciaria( $_POST['seqBorrar'] );
        
        // Registra la actividad en el log
        /*$claRegistro = new RegistroActividades;
        $claRegistro->registrarActividad( "Borrado" , 0 , $_SESSION['seqUsuario'] , "Borrado de Fiduciaria: [" . $_POST['seqBorrar'] . "] " . $arrFiduciaria[ $seqFiduciaria ]->txtFiduciaria . " Mensaje: " . implode( "," , $arrErrores ) );*/
        
        /**
         * Impresion de resultados
         */
         
        if( empty( $arrErrores ) ){
            $arrMensajes[] = "La Fiduciaria <b>" . $arrFiduciaria[ $seqFiduciaria ]->txtNombreFiduciaria . "</b> se ha eliminado del sistema";
            imprimirMensajes( array() , $arrMensajes , "salvarFiduciaria" );
        }else{
            imprimirMensajes( $arrErrores , array() );
        }
    }

    // Desconecta la base de datos
    $aptBd->close();
?>
