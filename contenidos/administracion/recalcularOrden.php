<?php


    /**
     * CUANDO SE CAMBIA EL PADRE DE UN MENU SE RECALCULA EL 
     * SELECT DE ORDEN PARA SABER CUALES SON LAS POSICIONES VALIDAS
     * @author Bernardo Zerda
     * @version 1,0 Abril 2009
     */
    
    // Posicion relativa de los archivos a incluir
    $txtPrefijoRuta = "../../";

    // Autenticacion (si esta logueado no no)
    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

    // Inclusiones necesarias
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Menu.class.php" );
    
    // Validacion de datos
    if( isset( $_POST['proyecto'] ) and is_numeric( $_POST['proyecto'] ) and isset( $_POST['padre'] ) and is_numeric( $_POST['padre'] ) ){
        
        // Obtiene cuantos hijos tiene la opcion de menu
        // para mostrar cuantas opciones hay para colocar
        // orden a las opciones de menu
        
        $claMenu = new Menu;
        $arrHijos = $claMenu->obtenerHijos( $_POST['proyecto'] , $_POST['padre'] );
        
        // Asignacion a la plantilla
        $claSmarty->assign( "numOpciones" , ( count( $arrHijos ) + 2 ) );
        
        // plantilla a mostrar
        $claSmarty->display( "administracion/recalcularOrden.tpl" );
                
    }

    // Desconecta la base de datos
    $aptBd->close();
    
?>
