<?php

/***************************************************************************
 * FUNCIONES NECESARIAS PARA EL WEB SERVICE
 * @author Bernardo Zerda
 * @author Camilo Bernal
 * @version 1.0 Septiembre de 2013
 ***************************************************************************/

/***************************************************************************
 * FUNCIONES QUE ESTAN PUBLICADAS
 ***************************************************************************/

    /**
     * FUNCION PARA VERIFICAR LA AUTENTICIDAD DEL USUARIO
     * @global Object $aptBd      // Conexion a la base de datos
     * @param String $txtUsuario  // Usuario proporcionado por el cliente
     * @param String $txtClave    // Clave del usuario
     * @param String $txtToken    // Archivo en hexa de la imagen obtenida en el registro
     * @return Object stdClass    // Objeto de retorno, el fotmaro del retorno es el complextype tns:cadena
     *                            // tns:cadena
     *                            // - texto: String con el identificador de la sesion creada
     *                            // - error: Arreglo con los errores encontrados (vacio si no hay errores)
     */
    function validarUsuario( $txtUsuario , $txtClave ) {
        global $aptBd;
        $txtError         = "";
        $txtIdentificador = "";
                
        // si no viene usuario o clave retorna error
        if( trim( $txtUsuario ) == "" or trim( $txtClave ) == "" ){
            $txtError = "Debe proporcionar usuario y clave para la autenticación";
        }
            
        // si no hay errores busca el usuario en la base de datos
        if( $txtError == "" ){
            
            $sql = "
                SELECT seqCuenta
                FROM T_WSE_CUENTAS
                WHERE txtUsuario = '" . $txtUsuario . "'
                  AND txtClave = '" . $txtClave . "'
                  AND bolActivo = 1
            ";
            $objRes = $aptBd->execute( $sql );
            
            // si hay registros que coincidan con usuario y clave entonces compara el token
            if( $objRes->RecordCount() == 1 ){
               
               // retorna el token de sesion
               $txtIdentificador = sha1( ( $txtUsuario . $txtClave ) + time() );

               // guarda el token de la sesion
               $txtError = insertarIdentificador( $objRes->fields['seqCuenta'] , $txtIdentificador );

               // Guarda el registrro de la accion realizada
               insertarRegistro( $objRes->fields['seqCuenta'] , "validarUsuario" );
 
            // Es un error si hay mas de un usuario que coincida con usuario y clave
            } elseif( $objRes->RecordCount() > 1 ) {
                $txtError = "Hubo un error al verificar la identidad del usuario";
            
            // si no hay registros es porque el usuario o la clave no son las correctas
            } else {
               $txtError = "Usuario o clave inválidos";
               
            }

        }
        
        $arrRespuesta['texto'] = $txtIdentificador;
        $arrRespuesta['error'] = utf8_decode( $txtError );
        
        return $arrRespuesta;
    }
    
    
    /**
     * FUNCION PARA VERIFICAR LA EXISTENCIA DEL UN CIUDADANO
     * EN LA BASE DE DATOS DEL SDVE POR EL NUMERO DE DOCUMENTO  
     * @global Object $aptBd
     * @param integer $numDocumento
     * @param string $txtIdentificador
     * @return Object stdClass    // Objeto de retorno, el fotmaro del retorno es el complextype tns:boleano
     *                            // tns:boleano
     *                            // - estado: Bolean, true si esta dentro de la base de datos false si no
     *                            // - error: Arreglo con los errores encontrados (vacio si no hay errores)
     */
    function ciudadanoRegistrado( $numDocumento , $txtIdentificador ){
        global $aptBd;
        $txtError = "";
        $bolRetorno = false;
        
        // valida que el identificador de la sesion este activo
        $seqCuenta = validarIdentificador( $txtIdentificador );
        
        // si no lo encuentra es una sesion invalida
        if( intval( $seqCuenta ) == 0 ){
            $txtError = "Sesión Inválida";
        } else {
            
            // consulta el numero de documento
            $sql = "
                SELECT seqCiudadano
                FROM T_CIU_CIUDADANO
                WHERE numDocumento = " . mb_ereg_replace( "[^0-9]" , "",  $numDocumento ) . "
            ";
            $objRes = $aptBd->execute( $sql );
            if( $objRes->RecordCount() > 0 ){
                $bolRetorno = true;
            } else {
                $bolRetorno = false;
            }            
            
            // Guarda el registrro de la accion realizada
            insertarRegistro( $seqCuenta , "ciudadanoRegistrado" , mb_ereg_replace( "[^0-9]" , "",  $numDocumento ) );
            
            // El identificador de la sesion ya no sirve mas
            borrarIdentificador( $seqCuenta );
            
        }
        
        $arrRespuesta['estado'] = $bolRetorno;
        $arrRespuesta['error']  = utf8_decode( $txtError );
        
        return $arrRespuesta;
        
    }
    
   function ciudadanosViviendaVista( $txtIdentificador ){
      global $aptBd;
      global $arrConfiguracion;
      
      $txtError = "";
      $arrRegistros = array();
      $numDiasVencimiento = 60;
      $arrCuentasAutorizadas[] = 1;
      $arrCuentasAutorizadas[] = 2;

      $sql = "
         SELECT seqCuenta
         FROM T_WSE_SESION
         WHERE txtIdentificador = '$txtIdentificador'
      ";
      $objRes = $aptBd->execute( $sql );
      
      if( $objRes->RecordCount() == 1 ){
         
         $seqCuenta = $objRes->fields['seqCuenta'];
         
         if( in_array( $seqCuenta , $arrCuentasAutorizadas ) ){
            
            $sql = "
              SELECT 
                 ciu.numDocumento as documento,
                 ciu.txtNombre1 as nombre1, 
                 ciu.txtNombre2 as nombre2, 
                 ciu.txtApellido1 as apellido1, 
                 ciu.txtApellido2 as apellido2,
                 frm.txtCorreo as correo
              FROM T_FRM_FORMULARIO frm
              INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
              INNER JOIN T_CIU_CIUDADANO ciu ON ciu.seqCiudadano = hog.seqCiudadano
              WHERE ciu.seqTipoDocumento IN ( 1 , 2 )
                AND frm.seqEstadoProceso IN ( 37 , 6 , 53)
                AND ( 
                  ( frm.fchAprobacionCredito >= DATE_ADD( NOW(), INTERVAL " . $numDiasVencimiento . " DAY ) AND frm.seqBancoCredito <> 1 )  OR
                  ( frm.fchAprobacionCredito <= '2000-01-01' AND frm.seqBancoCredito = 1 )
                )
                AND frm.seqModalidad IN ( 1 , 6 , 11 )
                AND frm.valTotalRecursos >= ( ( 70 - 26 ) * " . $arrConfiguracion['constantes']['salarioMinimo'] . " )
            ";
            
            try{
               
               $objRes = $aptBd->execute( $sql );
               while ( $objRes->fields ){
                  $numRegistro = count( $arrRegistros );
                  
                  foreach( $objRes->fields as $txtClave => $txtValor ){
                     $objRes->fields[ $txtClave ] = utf8_decode( $txtValor );
                  }
                  
                  $txtNombre  = trim( $objRes->fields['nombre1'] ) . " ";
                  $txtNombre .= ( trim( $objRes->fields['nombre2'] ) != "" )? trim( $objRes->fields['nombre2'] ) . " " : "";
                  $txtNombre .= $objRes->fields['apellido1'] . " ";
                  $txtNombre .= $objRes->fields['apellido2'];
                  
                  $arrRegistros[ $numRegistro ]['documento'] = $objRes->fields['documento'];
                  $arrRegistros[ $numRegistro ]['nombre']    = $txtNombre;
                  $arrRegistros[ $numRegistro ]['correo']    = $objRes->fields['correo'];
                  
                  $objRes->MoveNext();
               }

               // Guarda el registrro de la accion realizada
               insertarRegistro( $seqCuenta , "ciudadanosViviendaVista" );

               // El identificador de la sesion ya no sirve mas
               borrarIdentificador( $seqCuenta );

            } catch ( Exception $e ){
               $txtError = $e->getMessage();
            }
            
         } else {
            $txtError = "Esta cuenta no esta autorizada para realizar esta consulta";
         }

      } else {
         $txtError = "Identificador de sesion desconocido";
      }

      $arrRespuesta['listado'] = $arrRegistros;
      $arrRespuesta['error']  = utf8_decode( $txtError );
      
      return $arrRespuesta;
      
   }
    
    
/***************************************************************************
 * FUNCIONES QUE NO ESTAN PUBLICADAS
 ***************************************************************************/

    /**
     * FUNCION QUE ALMACENA EL IDENTIFICADOR DE LA SESION EN AL BASE DE DATOS
     * PARA CONTROLAR QUE LA SESION HAYA INICIADO Y QUE EL USUARIO ESTE AUTENTICADA
     * CADA IDENTIFICADOR ES VALIDO PARA UNA UNICA CONSULTA
     * @global Object $aptBd
     * @param integer $seqCuenta
     * @param string $txtIdentificador
     * @return string txtError
     */
    function insertarIdentificador( $seqCuenta , $txtIdentificador ){
        global $aptBd;
        $txtError = "";
        $txtError = borrarIdentificador( $seqCuenta );
        if( $txtError == "" ){
            try {
                $sql = "
                    INSERT INTO T_WSE_SESION (
                        seqCuenta,
                        txtIdentificador
                    ) VALUES (
                        " . $seqCuenta . ",
                        '" . $txtIdentificador . "'
                    )
                ";
                $aptBd->execute( $sql );
            } catch (Exception $objError){
                $txtError = $objError->getMessage();
            }
            
        }
        return $txtError;
    }
    
    /**
     * ELIMINA LOS IDENTIFICADORES RELACIONADOS CON UNA CUENTA
     * @global Object $aptBd
     * @param integer $seqCuenta
     * @return string txtError
     */
    function borrarIdentificador( $seqCuenta ){
        global $aptBd;
        $txtError = "";
        try {
            $sql = "
                DELETE 
                FROM T_WSE_SESION
                WHERE seqCuenta = " . $seqCuenta . "
            ";
            $aptBd->execute( $sql );
        } catch ( Exception $objError ){
            $txtError = $objError->getMessage();
        }
        return $txtError;
    }
    
    /**
     * VERIFICA QUE UN IDENTIFICADOR OBTENIDO ES UNICO EN LA BASE DE DATOS
     * @global Object $aptBd
     * @param type $txtIdentificador
     * @return integer seqCuenta
     */
    function validarIdentificador( $txtIdentificador ){
        global $aptBd;
        $seqCuenta = 0;
        try {
            $sql = "
                SELECT seqCuenta
                FROM T_WSE_SESION
                WHERE txtIdentificador = '$txtIdentificador'
            ";
            $objRes = $aptBd->execute( $sql );
            if( $objRes->RecordCount() == 1 ){
                $seqCuenta = $objRes->fields['seqCuenta'];
            } 
        } catch (Exception $objError ){
            $seqCuenta = 0;
        } 
        return $seqCuenta;   
    }
    
    /**
     * INSERTA EL SEGUIMIENTO DE LAS ACCIONES
     * DE LOS USUARIOS EN LA BASE DE DATOS
     * @global Object $aptBd
     * @param type $seqCuenta
     * @param type $txtConsulta
     * @return boolean
     */
    function insertarRegistro( $seqCuenta , $txtConsulta , $txtDatos = "" ){
        global $aptBd;
        $sql = "
            INSERT INTO T_WSE_REGISTRO (
                seqCuenta,
                fchConsulta,
                txtConsulta,
                txtDatos
            ) VALUES (
                " . $seqCuenta . ",
                NOW(),
                '" . $txtConsulta . "',
                '" . $txtDatos . "'
            )
        ";        
        $aptBd->execute( $sql );
        return true;
    }
    
?>
