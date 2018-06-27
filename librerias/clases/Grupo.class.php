<?php

    /**
     * ESTA CLASE REALIZARA TODAS LAS OPERACIONES 
     * RELACIONADAS CON LOS GRUPOS DE USUARIOS
     * Y SUS ASOCIACIONES A LAS ProyectoS CREADAS
     * @author Bernardo Zerda
     * @version Abril 2009
     */


    class Grupo {
        
        public $txtNombre;          // Nombre del menu
        public $arrProyectos;        // Proyectos que estan asociadas
        public $txtDescripcion;     // Descripcion del grupo
        
        /**
         * CONSTRUCTOR DE LA CLASE
         * @author Bernardo Zerda
         * @param Void
         * @return Void
         * @version 1.0 Abril 2009
         */
        
        public function Grupo() {
            $this->txtNombre = "";
            $this->arrProyectos = array();
            $this->txtDescripcion = "";
        } // Fin del constructor
        
        /** 
         * CARGA LOS GRUPOS QUE EXISTEN EN EL APLICATIVO
         * CON SUS ASOCIACIONES A LAS ProyectoS
         * @author Bernardo Zerda
         * @param integer seqGrupo 
         * @return array arrGrupos
         * @version 1.0 abril de 2009
         */
        
        public function cargarGrupo( $seqGrupo = 0 ){
            
            global $aptBd;
            
            $arrGrupos = array();
            
            // si viene un grupo la consulta se restringe
            if( $seqGrupo != 0 ){
            	$txtCondicion = " AND seqGrupo = $seqGrupo ";
            }
            
            // Obtiene los grupos
            $sql = "
                SELECT 
                    seqGrupo, 
                    txtGrupo,
                    txtDescripcion
                FROM 
                    T_COR_GRUPO
                WHERE seqGrupo > 1	    		
                $txtCondicion
                ORDER BY txtGrupo
            ";
            
            $objRes = $aptBd->execute( $sql );
            while( $objRes->fields ){
                $seqGrupo = $objRes->fields['seqGrupo'];
                
                $objGrupo = new Grupo;
                $objGrupo->txtNombre = ucwords(mb_strtolower($objRes->fields['txtGrupo']));
                $objGrupo->txtDescripcion = $objRes->fields['txtDescripcion'];
                
                $arrGrupos[ $seqGrupo ] = $objGrupo;
                $objRes->MoveNext();
            }
            
            // obtiene las Proyectos a las que pertenece el grupo
            if( ! empty( $arrGrupos ) ){
                $sql = "
                    SELECT          
                        seqProyectoGrupo,
                        seqProyecto,
                        seqGrupo
                    FROM 
                        T_COR_PROYECTO_GRUPO
                    WHERE
                        seqGrupo IN ( " . implode( "," , array_keys( $arrGrupos ) ) . " )
                ";
                $objRes = $aptBd->execute( $sql );
                while( $objRes->fields ){
                    $seqGrupo = $objRes->fields['seqGrupo'];
                    $seqProyecto = $objRes->fields['seqProyecto'];
                    $arrGrupos[ $seqGrupo ]->arrProyectos[ $seqProyecto ] = $objRes->fields['seqProyectoGrupo'];
                    $objRes->MoveNext();
                }
            }
            
            return $arrGrupos;
        } // Fin cargar grupo
        
        /** 
         * ALAMCENA LSO GRUPOS Y SU RELACION CON LAS ProyectoS
         * @author Bernardo Zerda
         * @param string txtNombre
         * @param array arrProyectos
         * @return array arrErrores
         * @version 1.0 Abril 2009
         */
        public function guardarGrupo( $txtNombre , $txtDescripcion , $arrProyectos ){
            
            global $aptBd;
            
            $arrErrores = array();
            
            $sql = "
                INSERT INTO T_COR_GRUPO (
                    txtGrupo,
                    txtDescripcion
                )VALUES(
                    \"" . ereg_replace( '\"' , '' , $txtNombre ) . "\",
                    \"" . ereg_replace( '\"' , '' , $txtDescripcion ) . "\"
                )
            ";
            
            // Creacion del grupo
            try {
            	$aptBd->execute( $sql );
              $seqGrupo = $aptBd->Insert_ID();
            } catch ( Exception $objError ) {
            	$seqGrupo = 0;
              $arrErrores[] = "No se ha podido salvar el grupo <b>$txtNombre</b>, reporte este error al administrador del sistema"; 
//              pr( $objError->getMessage() );
            }
            
            // si falla el anterior query este no se ejecuta
            if( empty( $arrErrores ) and $seqGrupo != 0 ){
                
                // Salva la relacion entre los grupos y las Proyectos
                foreach( $arrProyectos as $seqProyecto => $txtValor ){
                    
                    $sql = "
                        INSERT INTO T_COR_PROYECTO_GRUPO(
                            seqGrupo,
                            seqProyecto
                        )VALUES(
                            $seqGrupo,
                            $seqProyecto
                        )
                    ";
                    
                    try {
                    	$aptBd->execute( $sql );
                    } catch ( Exception $objError ) {
                        $arrErrores[] = "No se ha podido realizar la asociacion del grupo <b>$txtNombre</b> con las Proyectos seleccionadas, reporte este error al administrador del sistema";
//                        echo $objError->getMessage();
                        
                        // Elimina el grupo para que no queden grupos sin Proyectos asociadas                      
                        $sql = "
                            DELETE 
                            FROM T_COR_GRUPO
                            WHERE seqGrupo = $seqGrupo
                        ";
                        try {
                        	$aptBd->execute( $sql );
                        } catch ( Exception $objError ){
                            $arrErrores[] = "No se ha podido revertir la accion fallida de creacion de grupos, por favor de aviso inmediatamente al administrador";
//                            echo $objError->getMessage();
                        }
                    }
                    
                } // foreach Proyectos
            }
            
            return $arrErrores;
             
        } // Fin guardar grupos
        
        
        /**
         * EDITA LA INFORMACION DE LOS GRUPOS
         * Y DE LAS ProyectoS RELACIONADAS
         * @author Bernardo Zerda
         * @param integer seqGrupo
         * @param string txtGrupo
         * @param array arrProyectos
         * @return array arrErrores
         */
        public function editarGrupos( $seqGrupo , $txtGrupo , $txtDescripcion , $arrProyecto ){
        	
            global $aptBd;
            $arrErrores = array();
            
            // Carga las condiciones actuales del grupo
            $objGrupo = $this->cargarGrupo( $seqGrupo );
            
            // actualiza la informacion basica del grupo
            $sql = "
                UPDATE T_COR_GRUPO SET
                    txtGrupo = \"" . ereg_replace( '\"' , '' , $txtGrupo ) . "\",
                    txtDescripcion = \"" . ereg_replace( '\"' , '' , $txtDescripcion ) . "\"
                WHERE seqGrupo = $seqGrupo
            ";
            
            try {
                $aptBd->execute( $sql );
            } catch ( Exception $objError ) {
                $arrErrores[] = "No se ha realizado la modificacion del grupo <b>" . $objGrupo[ $seqGrupo ]->txtNombre . "</b>";
//                pr( $objError->getMessage() );
            }
            
            if( empty( $arrErrores ) ){
                
                $arrProyectoPost = $arrProyecto;
                
                // quita las Proyectos que ya estan en la base de datos
                foreach( $arrProyecto as $seqProyecto => $txtValor ){
                    if( isset( $objGrupo[ $seqGrupo ]->arrProyectos[ $seqProyecto ] ) ){
                        unset( $arrProyecto[ $seqProyecto ] );
                    }
                }
                
                // deja las Proyectos que ya no van a quedar -- para ser borradas
                foreach( $objGrupo[ $seqGrupo ]->arrProyectos as $seqProyecto => $seqProyectoGrupo ){
                    if( isset( $arrProyectoPost[ $seqProyecto ] ) ){
                        unset( $objGrupo[ $seqGrupo ]->arrProyectos[ $seqProyecto ] );
                    }
                }
                
                // Añade las Proyectos
                foreach( $arrProyecto as $seqProyecto => $txtValor ){
                    
                    $objProyecto = new Proyecto;
                    $arrProyecto = $objProyecto->cargarProyecto( $seqProyecto );
                    
                    $sql = "
                        INSERT INTO T_COR_PROYECTO_GRUPO (
                            seqProyecto,
                            seqGrupo
                        ) VALUES (
                            $seqProyecto,
                            $seqGrupo
                        )
                    ";
                    
                    try {
                        $aptBd->execute( $sql );
                    } catch ( Exception $objError ) {
                        $arrErrores[] = "No se ha podido vincular al grupo <b>" . $objGrupo[ $seqGrupo ]->txtNombre . "</b> con la Proyecto <b>" . 
                                        $arrProyecto[ $seqProyecto ]->txtProyecto . "</b>, reporte este error al administrador";
                    }
                
                } // fin a�ade Proyectos
                
                // Borra las relaciones Proyecto-grupo
                if( empty( $arrErrores ) ){
                    foreach( $objGrupo[ $seqGrupo ]->arrProyectos as $seqProyecto => $seqProyectoGrupo ){
                        
                        $objProyecto = new Proyecto;
                        $arrProyecto = $objProyecto->cargarProyecto( $seqProyecto );
                        
                        // No se puede borrar el grupo si tiene usuarios asociados
                        $arrErrores = $this->validarBorrarGrupo( $seqProyectoGrupo , $seqGrupo , $seqProyecto , $objGrupo , $arrProyecto );
                        
                        if( empty( $arrErrores ) ){
                            $sql = "
                                DELETE
                                FROM T_COR_PROYECTO_GRUPO
                                WHERE seqProyectoGrupo = $seqProyectoGrupo
                            ";
    
                            try {
                                $aptBd->execute( $sql );
                            } catch ( Exception $objError ) {
                                $arrErrores[] = "No se ha podido desvincular el grupo <b>" . $objGrupo[ $seqGrupo ]->txtNombre . "</b> con la Proyecto <b>" . 
                                                $arrProyecto[ $seqProyecto ]->txtProyecto . "</b>, reporte este error al administrador";
                            }
                        }
                    }
                }
            } 
            
            return $arrErrores;
            
        } // fin editar grupo 
        
        
        /** 
         * VERIFICA QUE EL GRUPO NO TENGA ASOCIACIONES 
         * PARA QUE SE PUEDA BORRAR
         * @author Bernardo Zerda
         * @param integer seqProyectoGrupo
         * @param integer seqGrupo
         * @param integer seqProyecto
         * @param Grupo[] objGrupo
         * @param Proyecto[] arrProyecto
         * @return array arrErrores
         * @version 1.0 Abril 2009
         */
        private function validarBorrarGrupo( $seqProyectoGrupo , $seqGrupo , $seqProyecto , $arrGrupo , $arrProyecto ){
        	
            global $aptBd;
            $arrErrores = array();
            
            // Verifica que no haya usuarios asociados
            $sql = "
                SELECT seqProyectoGrupo
                FROM T_COR_PERFIL
                WHERE seqProyectoGrupo = $seqProyectoGrupo
            ";
            $objRes = $aptBd->execute( $sql );
            if( $objRes->RecordCount() > 0 ){
                $arrErrores[] = "No se ha podido desvincular el grupo <b>" . $arrGrupo[ $seqGrupo ]->txtNombre . "</b> con la Proyecto <b>" . 
                                $arrProyecto[ $seqProyecto ]->txtProyecto . "</b> porque aun tiene usuarios asociados";
            }
            
            // Verifica que no haya opcones de menu asociados
            $sql = "
                SELECT seqProyectoGrupo
                FROM T_COR_PERMISO
                WHERE seqProyectoGrupo = $seqProyectoGrupo
            ";
            $objRes = $aptBd->execute( $sql );
            if( $objRes->RecordCount() > 0 ){
                $arrErrores[] = "No se ha podido desvincular el grupo <b>" . $arrGrupo[ $seqGrupo ]->txtNombre . "</b> con la Proyecto <b>" . 
                                $arrProyecto[ $seqProyecto ]->txtProyecto . "</b> porque aun tiene opciones de menu asociadas";
            }
            
            return $arrErrores;
        } // fin validar borrar grupo
        
        /**
         * ELIMINA GRUPOS DE USUARIOS QUE NO TENGAN VINCULACION
         * CON OPCIONES DE MENU O CON USUARIOS DEL SISTEMA
         * @author Bernardo Zerda
         * @param integer seqGrupo
         * @param Grupo[] arrGrupo
         * @return array arrErrores
         * @version 1.0 Abril de 2009
         */
        public function borrarGrupos( $seqGrupo, $arrGrupo ){
            
            global $aptBd;
            $arrErrores = array();
            
            // elimina relaciones Proyecto-grupo
            foreach( $arrGrupo[ $seqGrupo ]->arrProyectos as $seqProyecto => $seqProyectoGrupo ){
            	
                $objProyecto = new Proyecto;
                $arrProyecto = $objProyecto->cargarProyecto( $seqProyecto );
                $arrErrores = $this->validarBorrarGrupo( $seqProyectoGrupo , $seqGrupo , $seqProyecto , $arrGrupo , $arrProyecto );
                
                if( empty( $arrErrores ) ){
                    
                    // Elimina las relaciones entre las Proyectos y el grupo
                    $sql = "
                        DELETE 
                        FROM T_COR_PROYECTO_GRUPO
                        WHERE seqGrupo = $seqGrupo
                          AND seqProyecto = $seqProyecto
                    ";
//                    pr( $sql );
                    
                    try {
                    	$aptBd->execute( $sql );
                    } catch ( Exception $objError ) {
                    	$arrErrores[] = "No se ha podido eliminar la relacion entre el grupo <b>" . $arrGrupo[ $seqGrupo ]->txtNombre . "</b> " .
                                      "con la Proyecto <b>" . $arrProyecto[ $seqProyecto ]->txtProyecto . "</b>, reporte este error al administrador";
//                      pr( $objError->getMessage() );
                    }
                                        
                }
                
            } // fin foreach elima relaciones Proyecto-grupo
            
            // Elimina el grupo 
            if( empty( $arrErrores ) ){
                $sql = "
                    DELETE 
                    FROM T_COR_GRUPO
                    WHERE seqGrupo = $seqGrupo
                ";
//                        pr( $sql );
                
                try {
                    $aptBd->execute( $sql );
                } catch ( Exception $objError ) {
                    $arrErrores[] = "No se ha podido eliminar el grupo <b>" . $arrGrupo[ $seqGrupo ]->txtNombre . "</b>, reporte este error al administrador ";
//                            pr( $objError->getMessage() );
                }
            }
            
            return $arrErrores;
            
        } // fin borrar grupos
        
        /**
         * OBTIENE EL IDENTIFICADOR DE UN GRUPO
         * DADO EL PROYECTO VINCULADO Y EL NOMBRE 
         * @author Bernardo Zerda
         * @param seqProyecto
         * @param txtGrupo
         * @return seqGrupo
         */
        
        public function nombreGrupo2Identificador( $seqProyecto , $txtGrupo ){
        	global $aptBd;
        	$seqGrupo = 0;
        	$sql = "
				SELECT 
					pgr.seqProyectoGrupo
				FROM 
					T_COR_GRUPO gru,
					T_COR_PROYECTO_GRUPO pgr
				WHERE gru.seqGrupo = pgr.seqGrupo
				  AND gru.txtGrupo LIKE '%$txtGrupo%'
				  AND pgr.seqProyecto = $seqProyecto
        	";
        	$objRes = $aptBd->execute( $sql );
        	if( $objRes->fields ){
        		$seqGrupo = $objRes->fields['seqProyectoGrupo'];
        	}
        	return $seqGrupo;
        }
        
    } // Fin de la clase
    
?> 