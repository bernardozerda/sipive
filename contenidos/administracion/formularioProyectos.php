<?php

    /**
     * CUANDO SE EDITA UNA Proyecto ESTE ARCHIVO
     * RECOGE LA INFORMACION DE ESA Proyecto Y LA
     * COLOCA EN EL FORMULARIO PARA QUE SEA MODIFICADA
     * @author Bernardo Zerda
     * @version 0.1 Marzo 2009
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
    
    // Verifica que el valor sea numerico
    if( ! ( is_numeric( $_POST[ 'seqEditar' ] ) and isset( $_POST['seqEditar'] ) ) ){
    	$_POST[ 'seqEditar' ] = 0;
    }

    // Identificador de la Proyecto a editar
    $seqProyecto = $_POST[ 'seqEditar' ];
    
    // Obtiene la informacion para la Proyecto
    $claProyecto = new Proyecto;
    $arrProyecto = $claProyecto->cargarProyecto( $seqProyecto );
    
    // Obtiene las opciones de menu para el proyecto
    $claMenu = new Menu;
    $arrMenu = $claMenu->obtenerHijos( $seqProyecto , 0 ); // los hijos del padre cero(0) son el menu principal
    
    // Asignaciones a la plantilla
    $claSmarty->assign( "seqEditar" , $seqProyecto );
    $claSmarty->assign( "objProyecto" , $arrProyecto[ $seqProyecto ] );
    $claSmarty->assign( "arrConfiguracion" , $arrConfiguracion );
    $claSmarty->assign( "arrMenu" , $arrMenu );
    
    // Muestra el formulario
    $claSmarty->display( "administracion/formularioProyectos.tpl" );
    
    // Desconecta la base de datos
    $aptBd->close();
    

?>
