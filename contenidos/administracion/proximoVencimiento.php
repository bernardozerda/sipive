<?php

    /**
     * DE ACUERDO A LOS DIAS CALCULA LA PROXIMA FECHA DE
     * VENCIMIENTO DE LAS CLAVES DE LOS USUARIOS
     * @author Bernardo Zerda
     * @version 1.0 Abril 2009
     */
    
    // Posicion relativa de los archivos a incluir
    $txtPrefijoRuta = "../../";

    // Autenticacion (si esta logueado no no)
    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

    // Inclusiones necesarias
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    
    // Si falta la variable de los dias se coloca la menor posible
    if( ! ( isset( $_POST{'numDias'} ) and is_numeric( $_POST['numDias'] ) ) ){
    	$_POST['numDias'] = 30;
    }
    
    // Esto se despliega en el div 'proximoVencimiento' de la plantilla  de usuarios (ver formularioUsuarios.tpl)
    echo "Proximo Vencimiento " . proximoVencimiento( $_POST['numDias'] );
     
?>
