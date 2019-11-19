<?php

    /**
     * MUESTRA EL FORMULARIO QUE PERMITE CREAR Y EDITAR USUARIOS
     * @author Bernardo Zerda
     * @version 1.0 Abril de 2009
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
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Grupo.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Usuario.class.php" );
    

    // Verifica que el valor sea numerico
    if( ! ( is_numeric( $_POST[ 'seqEditar' ] ) and isset( $_POST['seqEditar'] ) ) ){
        $_POST[ 'seqEditar' ] = 0;
    }

    // Identificador del usuario
    $seqUsuario = $_POST[ 'seqEditar' ];
    
    // Clases necesarias para el script
    $claProyecto = new Proyecto;
    $claGrupo   = new Grupo;
    $claUsuario = new Usuario;
    
    // obtiene la informacon de los usuarios
    if( isset( $_POST['seqEditar'] ) and is_numeric( $_POST['seqEditar'] ) and $_POST['seqEditar'] > 0 ){
        $arrUsuario = $claUsuario->cargarUsuario( $_POST['seqEditar'] );
    }
       
    // obtiene la relacion entre Proyectos y grupos
    $arrProyecto = $claProyecto->cargarProyecto();
    $arrGrupo   = $claGrupo->cargarGrupo();
    $arrDependencia = $claUsuario->obtenerDependencia();
    
    // Asignaciones a la plantilla
    $claSmarty->assign( "seqEditar" , $seqUsuario );
    $claSmarty->assign( "arrGrupo" , $arrGrupo );
    $claSmarty->assign( "arrDependencia" , $arrDependencia );
    $claSmarty->assign( "arrProyecto" , $arrProyecto );
    $claSmarty->assign( "objUsuario" , $arrUsuario[ $seqUsuario ] );
    $claSmarty->assign( "arrConfiguracion" , $arrConfiguracion );
    $claSmarty->assign( "txtTitulo"   , "Formulario de Usuarios" );
    
    // Muestra el formulario
    $claSmarty->display( "administracion/formularioUsuarios.tpl" );

    // Desconecta la base de datos
    $aptBd->close();
     

?>
