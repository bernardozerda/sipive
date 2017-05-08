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
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Usuario.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "RegistroActividades.class.php" );
    
    // Arreglo de erores
    $arrErrores = array();
    
    /**
     * VALIDACIONES DEL FORMULARIO
     */
    
    // Validar el nombre
    if( ! isset( $_POST['nombre'] ) or trim( $_POST['nombre'] ) == "" ){
        $arrErrores[] = "EL nombre del usuario no puede estar vacio";
    }
    
    // Validar el apellido
    if( ! isset( $_POST['apellido'] ) or trim( $_POST['apellido'] )  == "" ){
        $arrErrores[] = "EL apellido del usuario no puede estar vacio";
    }
    
    // Validar el usuario
    if( ! isset( $_POST['usuario'] ) or trim( $_POST['usuario'] )  == "" ){
        $arrErrores[] = "EL usuario no puede estar vacio";
    }
    
    // Validar Correo electronico
    if( ! ereg( "^[0-9a-zA-Z._\-]+\@[a-zA-Z0-9._\-]+\.([a-zA-z]{2,4})(([\.]{1})([a-zA-Z]{2}))?$" , trim( $_POST['correo'] ) ) ){
        $arrErrores[] = "No es un correo electr&oacute;nico v&aacute;lido";
    }
    
    // Validar la clave
    $bolValidarClave = true;
    if( isset( $_POST['seqEditar'] ) and is_numeric( $_POST['seqEditar'] ) and $_POST['seqEditar'] > 0 and $_POST['clave'] == "" ){
        $bolValidarClave = false;        
    }
    
    // Verifica si hay que validar la clave
    if( $bolValidarClave ){
    
        // Validacion de la clave
        if( ! isset( $_POST['clave'] ) or trim( $_POST['clave'] )  == "" ){
            $arrErrores[] = "La clave del usuario no puede estar vacia";
        }
        
        // Validar la confirmacion de la clave
        if( ! isset( $_POST['confirmaClave'] ) or trim( $_POST['confirmaClave'] )  == "" ){
            $arrErrores[] = "La clave del usuario debe ser confirmada";
        }
        
        // Verificar que las claves esten correctas
        if( $_POST['clave'] != $_POST['confirmaClave'] ){
            $arrErrores[] = "Verifique que la clave y su confirmacion coincidan";
        }    
    
    }
    
    //Validar que tenga grupos seleccionados
    if( ! isset( $_POST['proyectoGrupo'] ) or empty( $_POST['proyectoGrupo'] ) ){
    	$arrErrores[] = "Seleccione al menos un grupo";
    }
    
    // Validacion de estado del usuarios
    if( ! isset( $_POST['estado'] ) or $_POST['estado'] == "" ){
    	$arrErrores[] = "Seleccione el estado del usuario";
    }
    
    // Validacion de la fecha de vencimiento
    if( ! isset( $_POST['vencimiento'] ) or ! is_numeric( $_POST['vencimiento'] ) ){
    	$arrErrores[] = "Seleccione un periodo de vencimiento para la clave del usuario";
    }
    
    $arrPrivilegios[ 'crear' ]   = ( isset( $_POST['privilegios']['crear'] )   and $_POST['privilegios']['crear']   == 1 )? 1 : 0 ;
    $arrPrivilegios[ 'editar' ]  = ( isset( $_POST['privilegios']['editar'] )  and $_POST['privilegios']['editar']  == 1 )? 1 : 0 ;
    $arrPrivilegios[ 'borrar' ]  = ( isset( $_POST['privilegios']['borrar'] )  and $_POST['privilegios']['borrar']  == 1 )? 1 : 0 ;
    $arrPrivilegios[ 'cambiar' ] = ( isset( $_POST['privilegios']['cambiar'] ) and $_POST['privilegios']['cambiar'] == 1 )? 1 : 0 ;
    
    if( empty( $arrErrores ) ){
        
        // Clases necesarias
        $claUsuario = new Usuario;
        $claRegistro = new RegistroActividades;
        
        // Validacion de la presencia y validez del seqEditar
        // $_POST['seqEditar'] contiene el identificador a modificar
        if( isset( $_POST['seqEditar'] ) and is_numeric( $_POST['seqEditar'] ) and $_POST['seqEditar'] > 0 ){
            
            $arrErrores = $claUsuario->editarUsuario( $_POST['seqEditar'] , $_POST['nombre'] , $_POST['apellido'] , $_POST['usuario'] , $_POST['clave'] , $_POST['correo'] , $_POST['estado'] , $_POST['vencimiento'] , $_POST['proyectoGrupo'] , $arrPrivilegios ); 
            $claRegistro->registrarActividad( "Edicion" , 0 , $_SESSION['seqUsuario'] , "Edicion de usuario: [ " . $_POST['seqEditar'] . " ] " . $_POST['nombre'] . " " . $_POST['apellido'] . " Mensaje: " . implode( "," , $arrErrores ) );        
        
        }else{ // si no esta presente el dato es porque solicita crear usuario
        
            $arrErrores = $claUsuario->guardarUsuario( $_POST['nombre'] , $_POST['apellido'] , $_POST['usuario'] , $_POST['clave'] , $_POST['correo'] , $_POST['estado'] , $_POST['vencimiento'] , $_POST['proyectoGrupo'] , $arrPrivilegios );
            $claRegistro->registrarActividad( "Creacion" , 0 , $_SESSION['seqUsuario'] , "Creacion de usuario: " . $_POST['nombre'] . " " . $_POST['apellido'] . " Mensaje: " . implode( "," , $arrErrores ) );
        
        }
        
    }

    /**
     * Impresion de resultados
     */
     
    if( empty( $arrErrores ) ){
        $arrMensajes[] = "El usuario <b>" . $_POST['nombre'] . " " . $_POST['apellido'] . "</b> se ha guardado";
        imprimirMensajes( array() , $arrMensajes , "salvarUsuario" );
    }else{
        imprimirMensajes( $arrErrores , array() );
    }

    // Desconecta la base de datos
    $aptBd->close();

?>
  