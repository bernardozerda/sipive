<?php
    
    /**
     * CLASE QUE SE ENCARGA DE LAS OPERACIONES
     * RELACIONADAS CON LOS USUARIOS
     * @author Bernardo Zerda
     * @version 1.0 Abril de 2009
     */

    class Usuario {
        
        public $txtNombre;          // Nombre de pila del usuairo
        public $txtApellido;        // Apellido del usuario 
        public $txtUsuario;         // Login del usuario al aplicativo
        public $txtCorreo;          // Correo electronico
        public $bolActivo;          // Si esta o no activo el usuario
        public $numVencimiento;     // cantidad de dias de validez de la clave (30 60 o 90)
        public $arrGrupos;          // Proyectos y grupos a los que pertenece el usuario [seqProyecto][seqGrupo] = $seqProyectoGrupo
        public $fchVencimiento;     // fecha de vencimiento de la clave -- calculada automaticamente por el script a partir del numero de dias
        public $bolCrear;			// Permiso para crear registros
        public $bolEditar;			// Permiso para editar Registros
        public $bolBorrar;			// Permiso para borrar Registros
        public $bolCambiar;			// Permiso para cambiar el estado de los procesos
        
        /**
         * CONSTRUCTOR DE LA CLASE
         * @author Bernardo Zerda
         * @param Void
         * @return Void
         * @version 1,0 Abil 2009
         */
        function Usuario() {
            $this->txtNombre = ""; 
            $this->txtApellido = ""; 
            $this->txtUsuario = ""; 
            $this->txtCorreo = "";
            $this->bolActivo = "";
            $this->numVencimiento = ""; 
            $this->arrGrupos = ""; 
            $this->fchVencimiento = NULL;
            $this->bolCrear = 0;
            $this->bolEditar = 0;
            $this->bolBorrar = 0;
            $this->bolCambiar = 0;     
        } // fin del constructor
        
        
        /**
         * OBTIENE LA INFORMACION DE LOS USUARIOS
         * @author Bernardo Zerda
         * @param integer seqUsuario
         * @return array arrUsuarios
         * @version 1.0 Abril de 2009
         */
        
        public function cargarUsuario( $seqUsuario = 0 ){
        	
            global $aptBd; // conexion a la base de datos
            
            $arrUsuario = array(); // variable de los errores
            
            // si viene usuario en el parametro limita la consulta
            $txtCondicion = "";
            if( $seqUsuario != 0 ){
            	$txtCondicion = " AND seqUsuario = $seqUsuario";
            }
            
            // consulta de datos
            $sql = "
                SELECT 
                    seqUsuario,
                    ucwords(txtNombre) as txtNombre,
                    ucwords(txtApellido) as txtApellido,
                    txtUsuario,
                    txtCorreo,
                    numVencimiento,
                    bolActivo,
                    fchVencimientoClave,
                   	bolCrear,
					bolEditar,
					bolBorrar,
					bolCambiar
                FROM 
                    T_COR_USUARIO
				WHERE seqUsuario > 1
                	$txtCondicion
                ORDER BY 
                    txtNombre , 
                    txtApellido
            ";
            try {

                $objRes = $aptBd->execute( $sql );
                while( $objRes->fields ){
                    $seqUsuario = $objRes->fields['seqUsuario'];
                    
                    $objUsuario = new Usuario;
                    $objUsuario->txtNombre      = $objRes->fields['txtNombre']; 
                    $objUsuario->txtApellido    = $objRes->fields['txtApellido'];
                    $objUsuario->txtCorreo      = $objRes->fields['txtCorreo'];
                    $objUsuario->txtUsuario     = $objRes->fields['txtUsuario'];
                    $objUsuario->bolActivo      = $objRes->fields['bolActivo'];
                    $objUsuario->numVencimiento = $objRes->fields['numVencimiento'];
                    $objUsuario->fchVencimiento = $objRes->fields['fchVencimientoClave'];
                    $objUsuario->bolCrear       = $objRes->fields['bolCrear'];
                    $objUsuario->bolEditar      = $objRes->fields['bolEditar'];
                    $objUsuario->bolBorrar      = $objRes->fields['bolBorrar'];
                    $objUsuario->bolCambiar     = $objRes->fields['bolCambiar'];
                     
                    $arrUsuario[ $seqUsuario ] = $objUsuario;
                    	
                    $objRes->MoveNext();
                }
                
                // iformacion de los grupos asociados
                foreach( $arrUsuario as $seqUsuario => $arrInformacion ){
                    
                    $sql = "
                        SELECT 
                            per.seqPerfil,
                            per.seqProyectoGrupo,
                            egr.seqProyecto,
                            egr.seqGrupo
                        FROM 
                            T_COR_PERFIL per,
                            T_COR_PROYECTO_GRUPO egr
                        WHERE per.seqProyectoGrupo = egr.seqProyectoGrupo
                          AND seqUsuario = $seqUsuario
                    ";
                    
                    $objRes = $aptBd->execute( $sql );
                    while( $objRes->fields ){
                        
                        $seqPerfil        = $objRes->fields['seqPerfil'];
                        $seqProyectoGrupo = $objRes->fields['seqProyectoGrupo'];
                        $seqProyecto      = $objRes->fields['seqProyecto'];
                        $seqGrupo         = $objRes->fields['seqGrupo']; 
                        
                        if( isset( $arrUsuario[ $seqUsuario ] ) ){
                            $arrUsuario[ $seqUsuario ]->arrGrupos[ $seqProyecto ][ $seqGrupo ] = $seqProyectoGrupo;
                        }
                            
                        $objRes->MoveNext();
                    }
                    
                }
                
            } catch ( Exception $objError ) {
            	$arrErrores[] = "Ocurrio un error al recuperar los datos del usuario";
            } 
            
            return $arrUsuario;
             
        } // Fin Cargar usuario
        
        
        /**
         * GUARDA LOS USUARIOS 
         * @author Bernardo Zerda
         * @param string txtNombre
         * @param string txtApellido
         * @param string txtUsuario
         * @param string txtClave
         * @param string txtCorreo
         * @param integer numEstado
         * @param integer numVencimiento
         * @param array arrGrupos
         * @return array arrUsuario
         */
        
        public function guardarUsuario( $txtNombre , $txtApellido , $txtUsuario , $txtClave , $txtCorreo , $numEstado , $numVencimiento , $arrGrupos , $arrPrivilegios ){
        	
            global $aptBd; // conexion a la base de datos
            
            $arrErrores = array(); // errores del aplicativo
            
            // calcula el proximo vencimiento
            $fchVencimiento = proximoVencimiento( $numVencimiento );
            
            /**
             * Almacena el usuario
             */
            
            $sql = "
                INSERT INTO T_COR_USUARIO (
                    txtNombre,
                    txtApellido,
                    txtUsuario,
                    txtClave,
                    txtCorreo,
                    bolActivo,
                    fchVencimientoClave,
                    txtClavePasada1,
                    txtClavePasada2,
                    txtClavePasada3,
                    numVencimiento,
                   	bolCrear,
					bolEditar,
					bolBorrar,
					bolCambiar
                ) VALUES (
                    \"" . ereg_replace('\"' , '' , $txtNombre ) . "\",
                    \"" . ereg_replace('\"' , '' , $txtApellido ) . "\",
                    \"" . ereg_replace('\"' , '' , $txtUsuario ) . "\",
                    \"" . ereg_replace('\"' , '' , $txtClave ) . "\",
                    \"" . ereg_replace('\"' , '' , $txtCorreo ) . "\",
                    $numEstado,
                    \"$fchVencimiento\",
                    \"\",
                    \"\",
                    \"\",
                    $numVencimiento,
					". $arrPrivilegios['crear'] .",
					". $arrPrivilegios['editar'] .",
					". $arrPrivilegios['borrar'] .",
					". $arrPrivilegios['cambiar'] ."
                )
            "; 
            
            try {
                $aptBd->execute( $sql );
                $seqUsuario = $aptBd->Insert_ID();
            } catch ( Exception $objError ) {
                $arrErrores[] = "No se ha podido salvar el usuario <b>" . $txtNombre . " " . $txtApellido . "</b>, reporte este error al administrador";
//                echo $objError->getMessage();
            }
            
            /**
             * Almacena la relacion entre usuarios y grupos
             */
            
            if( empty( $arrErrores ) ){
                foreach( $arrGrupos as $seqProyectoGrupo ){
                    
                    $sql = "
                        INSERT INTO T_COR_PERFIL (
                            seqProyectoGrupo, 
                            seqUsuario
                        ) VALUES (
                            $seqProyectoGrupo, 
                            $seqUsuario
                        )
                    ";

                    try {
                        $aptBd->execute( $sql );
                    } catch ( Exception $objError ) {
                        $arrErrores[] = "No se ha podido salvar el usuario <b>" . $txtNombre . " " . $txtApellido . "</b>, reporte este error al administrador";
//                        echo $objError->getMessage();
                        
                        
                        // esto es una especie de rollback manual
                        $sql = "
                            DELETE
                            FROM T_COR_USUARIO
                            WHERE seqUsuario = $seqUsuario
                        ";
                        
                        try {
                        	$aptBd->execute( $sql );
                        } catch ( Exception $objError ) {
                            $arrErrores[] = "No se ha podido revertir la accion fallida de creacion de usuarios, por favor de aviso inmediatamente al administrador";
//                            echo $objError->getMessage();
                        }
                        
                    }
                    
                } // fin foreach salvar cada Proyecto-grupo-usuario
            }
            
            return $arrErrores;
            
        } // fin guardar usuario
        
        
        /**
         * EDITA LOS USUARIOS 
         * @author Bernardo Zerda
         * @param integer seqUsuario 
         * @param string txtNombre
         * @param string txtApellido
         * @param string txtUsuario
         * @param string txtClave
         * @param string txtCorreo
         * @param integer numEstado
         * @param integer numVencimiento
         * @param array arrGrupo
         * @return array arrUsuario
         * @version 1.0 Abril de 2009
         */
        public function editarUsuario( $seqUsuario , $txtNombre , $txtApellido , $txtUsuario , $txtClave , $txtCorreo , $numEstado , $numVencimiento , $arrGrupo , $arrPrivilegios ){
             
            global $aptBd;
            
            $arrErrores = array();
            
            // obtiene los valores actiales del usuario
            $arrUsuario = $this->cargarUsuario( $seqUsuario );
            
            // Calcula la proxima fecha de vencimiento
            $fchVencimiento = proximoVencimiento( $numVencimiento );
            
            // Si la clave no esta vacia quiere decir que la quiere cambiar
            if( $txtClave != "" ){
                $arrErrores = $this->cambiarClave( $seqUsuario , $txtClave );
            }
            
            // Actualiza los datos basicos del usuario
            if( empty( $arrErrores ) ){
                $sql = "
                    UPDATE T_COR_USUARIO SET 
                        txtNombre = \"" . mb_ereg_replace( '\"' , '' , $txtNombre ) . "\" , 
                        txtApellido = \"" . mb_ereg_replace( '\"' , '' , $txtApellido ) . "\", 
                        txtUsuario = \"" . mb_ereg_replace( '\"' , '' , $txtUsuario ) . "\", 
                        txtCorreo = \"" . mb_ereg_replace( '\"' , '' , $txtCorreo ) . "\",
                        numVencimiento = " . $numVencimiento . ", 
                        bolActivo = " . $numEstado . ", 
                        fchVencimientoClave = \"" . $fchVencimiento . "\",
						bolCrear = ". $arrPrivilegios['crear'] .",
						bolEditar = ". $arrPrivilegios['editar'] .",
						bolBorrar = ". $arrPrivilegios['borrar'] .",
						bolCambiar = ". $arrPrivilegios['cambiar'] ."
                    WHERE seqUsuario = $seqUsuario
                ";
                try {
                    $aptBd->execute( $sql );
                } catch ( Exception $objError ) {
                    $arrErrores[] = "No se ha podido actualizar el usuario <b>" . $arrUsuario[ $seqUsuario ]->txtNombre . " " . $arrUsuario[ $seqUsuario ]->txtApellido . "</b>, reporte este error al administrador";
//                    echo $objError->getMessage();
                }
            }
            
            if( empty( $arrErrores ) ){
            	if( is_array( $arrUsuario ) ){
                    foreach( $arrUsuario[ $seqUsuario ]->arrGrupos as $seqProyecto => $arrProyectoGrupos ){
                        foreach( $arrProyectoGrupos as $seqGrupo => $seqProyectoGrupo ){
                            if( isset( $arrGrupo[ $seqProyectoGrupo ] ) ){
                                unset( $arrGrupo[ $seqProyectoGrupo ] );
                                unset( $arrUsuario[ $seqUsuario ]->arrGrupos[ $seqProyecto ][ $seqGrupo ] );
                            }
                        }
                    }
                }
                
                // Agregar las relaciones Proyecto-grupo-usuarios
                foreach( $arrGrupo as $seqProyectoGrupo ){
                    
                    $sql = "
                        INSERT INTO T_COR_PERFIL (
                            seqProyectoGrupo, 
                            seqUsuario
                        ) VALUES (
                            $seqProyectoGrupo, 
                            $seqUsuario
                        )
                    ";
                    
                    try {
                    	$aptBd->execute( $sql ); 
                    } catch ( Exception $objError ) {
                    	$arrErrores[] = "No se ha podido agregar al usuario <b>" . $arrUsuario[ $seqUsuario ]->txtNombre . " " . $arrUsuario[ $seqUsuario ]->txtApellido . "</b>, reporte este error al administrador";
                    }
                    
                }

                if( is_array( $arrUsuario ) ){
                    foreach( $arrUsuario[ $seqUsuario ]->arrGrupos as $seqProyecto => $arrProyectoGrupos ){
                        foreach( $arrProyectoGrupos as $seqGrupo => $seqProyectoGrupo ){
                            
                            $sql = "
                                DELETE 
                                FROM T_COR_PERFIL
                                WHERE seqProyectoGrupo = $seqProyectoGrupo
                                  AND seqUsuario = $seqUsuario
                            ";
                        
                            try {
                                $aptBd->execute( $sql ); 
                            } catch ( Exception $objError ) {
                                $arrErrores[] = "No se ha podido desagregar al usuario <b>" . $arrUsuario[ $seqUsuario ]->txtNombre . " " . $arrUsuario[ $seqUsuario ]->txtApellido . "</b>, reporte este error al administrador";
                            }
                            
                            
                        }
                    }
                }
                
            }
            
            return $arrErrores;
            
        }  // Editar usuarios
        
        /**
         * ELIMINA UN USUARIO DE LA BASE DE DATOS
         * @author Bernardo Zerda
         * @param integer $seqUsuario
         * @param array arrGrupos
         * @return array arrErrores 
         * @version 1,0 Abril
         */
        public function borrarUsuario( $seqUsuario, $arrGrupos ){
            
            global $aptBd;
            
            // Arreglo de errores
            $arrErrores = array();
            
            // carga la informacion actual del usuario
            $arrUsuario = $this->cargarUsuario( $seqUsuario );
            
            // Validacion para borrar el usuario
            
            // Elimina la relacion con los grupos
            foreach( $arrGrupos as $seqProyecto => $arrProyectoGrupo ){
                foreach( $arrProyectoGrupo as $seqProyectoGrupo ){	
                
                    $sql = "
                        DELETE
                        FROM T_COR_PERFIL
                        WHERE seqProyectoGrupo = $seqProyectoGrupo
                        AND seqUsuario = $seqUsuario
                    ";
                    
                    try {
                        $aptBd->execute( $sql );
                    } catch ( Exception $objError ) {
                        $arrErrores[] = "No se ha podido desvincular al usuario <b>" . $arrUsuario[ $seqUsuario ]->txtNombre . " " . $arrUsuario[ $seqUsuario ]->txtApellido . "</b> de sus grupos, reporte este error al administrador";                 
                        echo $objError->getMessage();
                    }
                
                }
            }
            
            // Si no hay errores continua eliminando el usuario
            if( empty( $arrErrores ) ){
            	
                $sql = "  
                    DELETE
                    FROM T_COR_USUARIO
                    WHERE seqUsuario = $seqUsuario
                ";
                
                try {
                    $aptBd->execute( $sql );
                } catch ( Exception $objError ) {
                    $arrErrores[] = "No se ha podido eliminar al usuario <b>" . $arrUsuario[ $seqUsuario ]->txtNombre . " " . $arrUsuario[ $seqUsuario ]->txtApellido . "</b>, reporte este error al administrador";                 
//                    echo $objError->getMessage();
                }
                
            }
            
            return $arrErrores;
            
        } // Fin borrar Usuarios
        
        /**
         * PERMITE EL CAMBIO DE CONTRASE�A VALIDANDO QUE 
         * LA NUEVA CLAVE NO COINCIDA CON LAS CLAVES ANTERIORES
         * @author Bernardo Zerda
         * @param integer seqUsuario
         * @param string txtClave
         * @return array arrErrores
         * @version 1.0 Abril 2009
         */
        private function cambiarClave( $seqUsuario , $txtClave ){
            
            global $aptBd; // conexion base de datos
            
            $arrErrores = array(); // almacenamiento de errores
            
            // Obtiene las claves anteriores
            $sql = "
                SELECT 
                    txtClave,
                    txtClavePasada1,
                    txtClavePasada2,
                    txtClavePasada3
                FROM T_COR_USUARIO
                WHERE seqUsuario = $seqUsuario
            ";
            $objRes = $aptBd->execute( $sql );
            $arrClavesAnteriores = array();
            while( $objRes->fields ){
                $arrClavesAnteriores[ 0 ] = $objRes->fields['txtClave'];
                $arrClavesAnteriores[ 1 ] = $objRes->fields['txtClavePasada1'];
                $arrClavesAnteriores[ 2 ] = $objRes->fields['txtClavePasada2'];
                $arrClavesAnteriores[ 3 ] = $objRes->fields['txtClavePasada3'];
                $objRes->MoveNext();
            }
            
            // Valida si la clave es una de las historicas
            if( in_array( $txtClave , $arrClavesAnteriores ) ){
                $arrErrores[] = "La nueva clave debe ser distinta a la clave actual y a las 3 claves anteriores que haya usado";
            }else{
                
                $arrClavesAnteriores[ 3 ] = $arrClavesAnteriores[ 2 ];
                $arrClavesAnteriores[ 2 ] = $arrClavesAnteriores[ 1 ];
                $arrClavesAnteriores[ 1 ] = $arrClavesAnteriores[ 0 ];
                $arrClavesAnteriores[ 0 ] = $txtClave;
            }
            
            // si la clave es valida altera la base de datos
            if( empty( $arrErrores ) ){
                $sql = "
                    UPDATE T_COR_USUARIO SET
                        txtClave         = \"" . $arrClavesAnteriores[ 0 ] . "\",
                        txtClavePasada1 = \"" . $arrClavesAnteriores[ 1 ] . "\",
                        txtClavePasada2 = \"" . $arrClavesAnteriores[ 2 ] . "\",
                        txtClavePasada3 = \"" . $arrClavesAnteriores[ 3 ] . "\"
                    WHERE seqUsuario = $seqUsuario
                "; 
//                pr( $sql );
                try {
                    $aptBd->execute( $sql ); 
                } catch ( Exception $objError ) {
                    $arrUsuario = $this->cargarUsuario( $seqUsuario );
                    $arrErrores[] = "No se ha podido cambiar la clave del usuario <b>" . $arrUsuario[ $seqUsuario ]->txtNombre . " " . $arrUsuario[ $seqUsuario ]->txtApellido . "</b>, reporte este error al administrador";
//                    echo $objError->getMessage();
                }
            }
            
            return $arrErrores;
            
        } // fin Cambiar clave
        
        
    } // Fin de la clase
?>