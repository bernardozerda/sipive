<?php

    /**
     * SALVA EL USUARIO EN LA BASE DE DATOS
     * JUNTO CON SU RELACION ENTRE GRUPOS
     * @author Bernardo Zerda
     * @version 1.0 2009
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
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "RegistroActividades.class.php" );

    // Arreglo de erores
    $arrErrores = array();
    
    /**
     * VALIDACIONES DEL FORMULARIO
     */
         
    // Validar de la etiqueta en español
    if( ! isset( $_POST['es'] ) or trim( $_POST['es'] ) == "" ){
        $arrErrores[] = "No debe colocar la etiquieta vacia";
    }else{
        $_POST['en'] = $_POST['es'];
    }

    // Validar el codigo fuente
    if( ! isset( $_POST['codigo'] ) or trim( $_POST['codigo'] ) == "" ){
        $arrErrores[] = "Debe referenciar un codigo fuente para esta opci&oacute;n de men&uacute;";
    }
    
    // Valida que tenga grupos asignados
    if( ! isset( $_POST['proyectoGrupo'] ) or empty( $_POST['proyectoGrupo'] ) ){
        $arrErrores[] = "Debe asignar la opcion de menu a al menos un grupo";
    }
    
    /**
     * guardar los cambios
     */
    
    if( empty( $arrErrores ) ){
    		
        $claMenu = new Menu;
        $claRegistro = new RegistroActividades;
        
        // Verifica si crea o edita un elemento
        if( isset( $_POST['seqEditar'] ) and is_numeric( $_POST['seqEditar'] ) and $_POST['seqEditar'] > 0 ){
            $arrErrores = $claMenu->editarMenu( $_POST['seqEditar'] , $_POST['es'] , $_POST['en'] , $_POST['codigo'] , $_POST['orden'] , $_POST['padre'] , $_POST['proyecto'] , $_POST['proyectoGrupo'] );
            $claRegistro->registrarActividad( "Edicion" , 0 , $_SESSION['seqUsuario'] , "Edicion de menu: [" . $_POST['seqEditar'] . "] " . $_POST['es'] . " Mensaje: " . implode("," , $arrErrores ) );
        }else{
            $arrErrores = $claMenu->guardarMenu( $_POST['es'] , $_POST['en'] , $_POST['codigo'] , $_POST['orden'] , $_POST['padre'] , $_POST['proyecto'] , $_POST['proyectoGrupo'] );
            $claRegistro->registrarActividad( "Creacion" , 0 , $_SESSION['seqUsuario'] , "Creacion de menu: " . $_POST['es'] . " Mensaje: " . implode("," , $arrErrores ) );
        }
        
    }
    
    
    /**
     * Impresion de resultados
     */
     
    if( empty( $arrErrores ) ){
        $arrMensajes[] = "El menu <b>" . $_POST['es'] . "</b> se ha guardado";
        imprimirMensajes( array() , $arrMensajes , "salvarMenu" );
    }else{
        imprimirMensajes( $arrErrores , array() );
    }

    // Desconecta la base de datos
    $aptBd->close();

?>