<?php

    /**
     * SALVA O EDITA LOS GRUPOS DE USUARIOS
     * @author Bernardo Zerda
     * @version 1.0 Abril 2009
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
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Proyecto.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Grupo.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "RegistroActividades.class.php" );
    
    // Errores del formulario
    $arrErrores = array();
    
    /**
     * Validaciones requeridas
     */
    
    // Validacion del nombre del grupo
    if( ( ! isset( $_POST['nombre'] ) ) or trim( $_POST['nombre'] == "" ) ){
        $arrErrores[] = "No bebe dejar el nombre del grupo vacio";    	
    } 
    
    // Validacion de proyectos
    if( ( ! isset( $_POST['proyecto'] ) ) or empty( $_POST['proyecto'] ) ){
        $arrErrores[] = "Seleccione al menos una proyecto";
    }

    /**
     * Salva el grupo si no hay errores
     */
    
    if( empty( $arrErrores ) ){
    	   
        $claGrupo = new Grupo;      
        $claRegistro = new RegistroActividades;   
        
        // Verifica si crea o edita el elemento
        if( isset( $_POST['seqEditar'] ) and is_numeric( $_POST['seqEditar'] ) and $_POST['seqEditar'] > 0 ){
            $arrErrores = $claGrupo->editarGrupos( $_POST['seqEditar'] , $_POST['nombre'] , $_POST['descripcion'] , $_POST['proyecto'] );
            $claRegistro->registrarActividad( "Edicion" , 0 , $_SESSION['seqUsuario'] , "Edicion de Grupo: [ ".$_POST['seqEditar']." ] " . $_POST['nombre'] . " Mensaje: " . implode( "," , $arrErrores ) ); 
        }else{
            $arrErrores = $claGrupo->guardarGrupo( $_POST['nombre'] , $_POST['descripcion'] , $_POST['proyecto'] );
            $claRegistro->registrarActividad( "Creacion" , 0 , $_SESSION['seqUsuario'] , "Creacion de Grupo: " . $_POST['nombre'] . " Mensaje: " . implode( "," , $arrErrores ) );
        }
        
    }

    /**
     * Impresion de resultados
     */
     
    if( empty( $arrErrores ) ){
        $arrMensajes[] = "El grupo <b>" . $_POST['nombre'] . "</b> se ha guardado";
        imprimirMensajes( array() , $arrMensajes , "salvarGrupo" );
    }else{
        imprimirMensajes( $arrErrores , array() );
    }


    // Desconecta la base de datos
    $aptBd->close();

?>
