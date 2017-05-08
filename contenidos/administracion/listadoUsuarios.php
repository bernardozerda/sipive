<?php


    /**
     * MUESTRA EL LISTADO DE LOS GRUPOS CREADOS
     * @author Bernardo Zerda
     * @version 1,0 Abril 2009
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
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Usuario.class.php" );
    
    // Instancia de la clase
    $claUsuario = new Usuario;
    $arrUsuario = $claUsuario->cargarUsuario();

    // Adecuacion del arreglo para el formato de listado estandar
    $arrListado = array();
    foreach( $arrUsuario as $seqUsuario => $objUsuarios ){
        $arrListado[ $seqUsuario ][ 'nombre' ] = $objUsuarios->txtNombre . " " . $objUsuarios->txtApellido;
        $arrListado[ $seqUsuario ][ 'estado' ] = ( $objUsuarios->bolActivo == 1 )? "activo" : "inactivo";
    }
    
    // Asignacion a la plantilla smarty
    $claSmarty->assign( "txtEditar"   , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracion/formularioUsuarios.php" ); // Archivo para editar las proyectos
    $claSmarty->assign( "txtBorrar"   , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracion/borrarUsuarios.php" ); // archivo para borrar las proyectos
    $claSmarty->assign( "arrListado"  , $arrListado );
    $claSmarty->assign( "txtPregunta" , "Esta a punto de eliminar un usuario, se requiere confirmacion para realizar esta accion.<br>&iquest;Desea Continuar?" );
    $claSmarty->assign( "txtTitulo"   , "Listado de Usuarios" );
    
    // Despliegue de la plantilla
    $claSmarty->display( "administracion/listado.tpl" );

    // Desconecta la base de datos
//    $aptBd->close();  
 
?>
