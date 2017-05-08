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
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Proyecto.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Menu.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "RegistroActividades.class.php" );
    
    
    // Verifica que el valor sea numerico
    if( ! isset( $_POST[ 'seqBorrar' ] ) ){
        exit(0);
    }
    
    $arrErrores = array(); // donde se almacenaran los errores
    
    // Clases usadas en el script
    $claProyecto  = new Proyecto;
    $claMenu     = new Menu;
    $claRegistro = new RegistroActividades;
    
    // Parametros del post para eliminar la opcion de menu
    $arrParametros = split( "#" , $_POST['seqBorrar'] );
    $seqMenu       = $arrParametros[ 0 ];
    $seqProyecto    = $arrParametros[ 1 ];
    
    // Validacion de errores
    if( $seqMenu == 0 ){
    	$arrErrores[] = "No hay nada que eliminar";
    }else{
        
        // carga las opciones actuales del menu para los mensajes
        $arrMenu    = $claMenu->cargarMenu( $seqProyecto , $seqMenu );
        $arrProyecto = $claProyecto->cargarProyecto( $seqProyecto );
        
        // elimina las opciones del menu
        $arrErrores = $claMenu->borrarMenu( $seqProyecto , $seqMenu, $arrProyecto[ $seqProyecto ]->arrProyectoGrupo );
        
        // Registra la actividad en el sistema
        $claRegistro->registrarActividad( "Borrado" , 0 , $_SESSION['seqUsuario'] , "Borrado de menu: Proyecto=$seqProyecto Menu=$seqMenu Mensaje: " . implode(",",$arrErrores) );
        
    }
    
    /**
     * Impresion de resultados
     */
     
    if( empty( $arrErrores ) ){
        $arrMensajes[] = "El menu <b>" . $arrMenu[ $seqMenu ]->txtEspanol . "</b> se ha eliminado del sistema";
        imprimirMensajes( array() , $arrMensajes , "salvarMenu" );
    }else{
        imprimirMensajes( $arrErrores , array() );
    }
    

?>