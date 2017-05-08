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
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Grupo.class.php" );
    
    // Instancia de la clase
    $claGrupo = new Grupo;
    $arrGrupos = $claGrupo->cargarGrupo();
    
    // Adecuacion del arreglo para el formato de listado estandar
    $arrListado = array();
    foreach( $arrGrupos as $seqGrupo => $objGrupo ){
        $arrListado[ $seqGrupo ][ 'nombre' ] = $objGrupo->txtNombre;
        $arrListado[ $seqGrupo ][ 'estado' ] = "";
    }

    // Asignacion a la plantilla smarty
    $claSmarty->assign( "txtEditar"   , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracion/formularioGrupos.php" ); // Archivo para editar las s
    $claSmarty->assign( "txtBorrar"   , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracion/borrarGrupos.php" ); // archivo para borrar las s
    $claSmarty->assign( "arrListado"  , $arrListado );
    $claSmarty->assign( "txtPregunta" , "Esta a punto de eliminar una grupo, se requiere confirmacion para realizar esta accion.<br>&iquest;Desea Continuar?" );
    $claSmarty->assign( "txtTitulo"   , "Listado de Grupos" );
    
    // Despliegue de la plantilla
    $claSmarty->display( "administracion/listado.tpl" );

    // Desconecta la base de datos
    $aptBd->close();    
    
?>
