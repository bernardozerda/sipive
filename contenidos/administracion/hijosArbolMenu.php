<?php

    /**
     * ESTE ARCHIVO SE USA PARA COLOCAR EL EL TREEVIEW
     * DE OPCIONES DE MENU LOS HIJOS DE UN NODO SELECCIONADO
     * @author Bernardo Zerda
     * @version 1.0 abril 2009
     */

    // posicion relativa de los archivos a incluir 
    $txtPrefijoRuta = "../../";

    // Autenticacion (si esta logueado no no)
    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    
    // Inclusiones necesarias
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Menu.class.php" );
    
    // validacion de los datos
    if( ! ( isset( $_POST['proyecto'] ) and is_numeric( $_POST['proyecto'] ) and isset( $_POST['padre'] ) and is_numeric( $_POST['padre'] ) ) ){
    	exit(0);
    }
    
    // Obtiene los hijos de un menu
    $claMenu  = new Menu;
    $arrMenu = $claMenu->obtenerHijos( $_POST['proyecto'] , $_POST['padre'] );
    
    /***************************************************************************
     *                              IMPORTANTE                                 *  
     * Separacion de los nodos se hace con '#'                                 *
     * Separacion de las caracteristicas de cada nodo se hace con ';'          *
     *                                                                         *
     * Ejemplo del formato de respuesta                                        *
     *      label1;padre1#label2;padre2#label3;padre3#.......label(n);padre(n) *
     * *************************************************************************
     */
    
    $txtRespuesta = "";
    if( ! empty( $arrMenu ) ){ 
        foreach( $arrMenu as $seqMenu => $objMenu ){
            $txtRespuesta .= "$seqMenu;" . $objMenu->txtEspanol . "#";
        }
    }
    
    // Resultado que recoge el treeview ( buscar obtenerHijosArbolMenu en listener.js)   
    echo rtrim( $txtRespuesta , "#" );

    // Desconecta la base de datos
    $aptBd->close();


?>
