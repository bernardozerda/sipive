<?php

    /**
     * SALVA O EDITA LAS proyectoS DE LA BASE DE DATOS
     * @author Bernardo Zerda
     * @version 0.1 Marzo 2009
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
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "RegistroActividades.class.php" );
    
    /**
     * Validacion del formulario de proyectos
     */ 
    
    $arrErrores = array();
    
    // Validacion del nombre
    if( ( ! isset( $_POST['nombre'] ) ) or trim( $_POST['nombre'] ) == "" ){
    	$arrErrores[] = "Debe diligenciar el campo nombre de proyecto";
    }
    
    // Validacion de la fecha
    list( $numAno , $numMes , $numDia ) = split( "-" , $_POST['vencimiento'] );
    if( ! @checkdate( $numMes , $numDia , $numAno ) ){
    	$arrErrores[] = "Debe colocar una fecha de vencimiento de la licencia de uso del aplicativo";
    }
    
    // Validacion de Estado
    if( ! isset( $_POST['estado'] ) ){
    	$arrErrores[] = "Seleccione un estado para la proyecto";
    }    
    
    
    /**
     * Salvar o editar proyectos si no hay errores
     */
    
    if( empty( $arrErrores ) ){
        
        $claProyecto = new Proyecto;
        $claRegistro = new RegistroActividades;
        
        // Verifica si es para crear o editar la proyecto
        if( isset( $_POST['seqEditar'] ) and is_numeric( $_POST['seqEditar'] ) and $_POST['seqEditar'] > 0 ){
            $arrErrores = $claProyecto->editarProyectoPRY( $_POST['seqEditar'] , trim( $_POST['nombre'] ) , $_POST['vencimiento'] , $_POST['estado'] , $_POST['seqMenu'] );
           	$claRegistro->registrarActividad( "Edicion" , 0 , $_SESSION['seqUsuario'] , "Edicion de Proyecto: [" . $_POST['seqEditar'] . "] " . trim( $_POST['nombre'] ) . " Mensaje: " . implode( "," , $arrErrores ) );
        }else{
            $arrErrores = $claProyecto->guardarProyecto( trim( $_POST['nombre'] ) , $_POST['vencimiento'] , $_POST['estado'], $_POST['seqMenu'] );
            $claRegistro->registrarActividad( "Creacion" , 0 , $_SESSION['seqUsuario'] , "Creacion de Proyecto: " . trim( $_POST['nombre'] ) . " Mensaje: " . implode( "," , $arrErrores ) );	
        }
        
    }
    
    /**
     * Impresion de resultados
     */
     
    if( empty( $arrErrores ) ){
        $arrMensajes[] = "El Proyecto <b>" . $_POST['nombre'] . "</b> se ha guardado";
        imprimirMensajes( array() , $arrMensajes , "salvarProyecto" );
    }else{
        imprimirMensajes( $arrErrores , array() );
    }


    // Desconecta la base de datos
    $aptBd->close();

?>
