<?php

    /**
     * MUESTRA EL FORMULARIO QUE PERMITE
     * CREAR / EDITAR LOS GRUPOS
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
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Proyecto.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Grupo.class.php" );

    // Verifica que el valor sea numerico
    if( ! ( is_numeric( $_POST[ 'seqEditar' ] ) and isset( $_POST['seqEditar'] ) ) ){
        $_POST[ 'seqEditar' ] = 0;
    }

    // Identificador del grupo
    $seqGrupo = $_POST[ 'seqEditar' ];
    
    // obtiene la informacion del grupo
    $arrGrupo = array();
    if( $seqGrupo != 0 ){
        $claGrupo = new Grupo;
        $arrGrupo = $claGrupo->cargarGrupo( $seqGrupo );
    }
    
    // Obtiene la informacion de las Proyectos que se pueden asociar
    $claProyecto = new Proyecto;
    $arrProyecto = $claProyecto->cargarProyecto( );
    
    // Asignaciones a la plantilla
    $claSmarty->assign( "seqEditar" , $seqGrupo );
    $claSmarty->assign( "objGrupo" , $arrGrupo[ $seqGrupo ] );
    $claSmarty->assign( "arrProyectos" , $arrProyecto );
    $claSmarty->assign( "arrConfiguracion" , $arrConfiguracion );
    $claSmarty->assign( "txtTitulo"   , "Formulario de Grupo" );
    
    // Muestra el formulario
    $claSmarty->display( "administracion/formularioGrupos.tpl" );

    // Desconecta la base de datos
    $aptBd->close();
    
?>
