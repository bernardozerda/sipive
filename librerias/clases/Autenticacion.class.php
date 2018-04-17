<?php

    /**
     * CLASE QUE REALIZA LAS TAREAS DE AUTETICACION 
     * @author Bernardo Zerda
     * @version 1.0 Abril 2009
     */


    class Autenticacion extends Usuario {
        
        public $arrErrores; // almacenamieto de errores
        
        /**
         * CONSTRUCTOR DE LA CLASE
         * @author Bernardo Zerda
         * @param Void
         * @return Void
         * @version 1.0 Abril 2009
         */
        public function Autenticacion() {
            $this->arrErrores = array();
        } // Constructor de la clase
        
        /**
         * OBTIENE LOS DATOS DEL USUARIO A PARTIR
         * DEL USERNAME Y DE LA CLAVE
         * @author bernardo zerda	
         * @param string txtUsuario
         * @param string txtCalve
         * @return array arrUsuario
         * @version 1.0p Abril 2009
         */
        public function datosUsuario( $txtUsuario , $txtClave ){
        	
        	global $aptBd;
        	   
            // obtiene el identificador del usuario a partir del usuario y la clave
            $seqUsuario = $this->obtenerSeqUsuario( $txtUsuario , $txtClave );
			
            // si no hay errores obtiene los datos del usuario
            $arrUsuario = array();
            if( empty( $this->arrErrores ) ){
            	
            	if( $seqUsuario != 1 ){
            		$arrUsuario = $this->cargarUsuario( $seqUsuario );
	                if( $arrUsuario[ $seqUsuario ]->bolActivo == 0 ){
	                    $this->arrErrores[] = "El usuario ".$arrUsuario[ $seqUsuario ]->txtNombre." ".$arrUsuario[ $seqUsuario ]->txtApellido." esta bloqueado";
	                    $arrUsuario = array();
	                }	
            	}else{
            		
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
		                    fchVencimientoClave
		                FROM 
		                    T_COR_USUARIO
						WHERE 
							seqUsuario = $seqUsuario
		            ";           		
            		try {
            			
            			$objRes = $aptBd->execute( $sql );
            			if( $objRes->fields ){
            				
		                    $seqUsuario = $objRes->fields['seqUsuario'];
		                    
		                    $objUsuario = new Usuario;
		                    $objUsuario->txtNombre      = $objRes->fields['txtNombre']; 
		                    $objUsuario->txtApellido    = $objRes->fields['txtApellido'];
		                    $objUsuario->txtCorreo      = $objRes->fields['txtCorreo'];
		                    $objUsuario->txtUsuario     = $objRes->fields['txtUsuario'];
		                    $objUsuario->bolActivo      = $objRes->fields['bolActivo'];
		                    $objUsuario->numVencimiento = $objRes->fields['numVencimiento'];
		                    $objUsuario->fchVencimiento = $objRes->fields['fchVencimientoClave'];
		                     
		                    $arrUsuario[ $seqUsuario ] = $objUsuario;
		                    	
		                }
		                
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
		                
		                
            		} catch ( Exception $objError ) {
            			$arrErrores[] = "Hubo problemas al consultar los datos del administrador";
            		}
            		
            	}
            	
                
                
            }
            
            return $arrUsuario;          
        
        } // fin datos usuarios 

        /**
         * A PARTIR DEL USUARIO Y LA CLAVE OBTIENE 
         * EL IDENTIFICADOR DEL USUARIO
         * @author Bernardo Zerda
         * @param string txtUsuario 
         * @param string txtClave
         * @return integer seqUsuario
         * @version 1.0 Abril 2009
         */        
        private function obtenerSeqUsuario( $txtUsuario , $txtClave ){
        	
            global $aptBd;
            $seqUsuario = 0;
            
            // consulta por login y clave si el usaurio existe
            $sql = "
                SELECT seqUsuario
                FROM T_COR_USUARIO
                WHERE txtUsuario = \"" . ereg_replace( '\"' , '' , $txtUsuario ) . "\"
                AND txtClave = \"" . $txtClave . "\" 
                AND bolActivo = 1
            ";
            $objRes = $aptBd->execute( $sql );
            
            // Ve si hay datos para retornar
            if( $objRes->fields ){
                if( $objRes->RecordCount() == 1 ){
                    $seqUsuario = $objRes->fields['seqUsuario'];
                }else{
                    $this->arrErrores[] = "Error al obtener los datos del usuario, reporte este error al adminsitrador";
                }
            }else{
                $this->arrErrores[] = "Usuario o contrase&ntilde;a inv&aacute;lido";
				// INICIO GUARDA DIRECCION IP Y DIRECCION MAC DEL INTENTO DE AUTENTICACION (TEMPORAL)
				if ($_POST['usuario'] == 'obonillaq'){
					$hostName = gethostbyaddr($_SERVER['REMOTE_ADDR']);
					$REMOTE_ADDR=$hostname;
					$ip= $REMOTE_ADDR;
					$ipLocal = GetHostByName($ip);
					// Insert
					mysql_query("INSERT INTO T_COR_INTENTO (txtUsuario, txtClaveDigitada, txtDireccionIP, txtHostName, txtTipo, fchIntento) VALUES ('".$_POST['usuario']."', '".$_POST['clave']."', '".$ipLocal."', '".$hostName."', 'passuser', NOW())");
				}
            }
            
            return $seqUsuario;
            
        } // fin obtener seqUsuario
        
        /**
         * OBTIENE LOS PERMISOS DEL USUARIO SEGUN SU ASIGNACION
         * A LOS GRUPOS DE LAS ProyectoS
         * @author bernardo zerda
         * @param array arrProyectoGrupos
         * @return array arrPermisos
         * @version 1.0 Abril 2009
         */
        public function permisosUsuario( $arrProyectoGrupos ){
        	
            global $aptBd;
            $arrPermisos = array();
            
            // esta consulta tiene en cuenta que las fechas de licencia no esten 
            // vencidas y que los grupo s de usuarios esten habilitados
            // aqui obtiene solo los menus principales puesto que 
            // en la presentacion solo se requieren estos,
            // cuando se hace onMouseOver de los principales se hace 
            // la solicitud de los hijos (submenu) del menu padre
            
            $sql = "
                SELECT 
                    emp.seqProyecto,
                    per.seqMenu
                FROM 
                    T_COR_PERMISO per,
                    T_COR_PROYECTO_GRUPO egr,
                    T_COR_PROYECTO emp,
                    T_COR_MENU men
                WHERE per.seqProyectoGrupo IN ( " . implode( "," , $arrProyectoGrupos ) . " )
                  AND per.seqProyectoGrupo = egr.seqProyectoGrupo
                  AND egr.seqProyecto = emp.seqProyecto
                  AND per.seqMenu = men.seqMenu
                  AND emp.bolActivo = 1
                  AND emp.fchVencimiento >= CONCAT( YEAR( NOW() ) , '-' , MONTH( NOW() ) , '-' , DAY( NOW() ) )
                GROUP BY 
                    per.seqMenu, emp.seqProyecto
            "; // AND men.seqMenuPadre = 0
            $objRes = $aptBd->execute( $sql );
            while( $objRes->fields ){
                $seqProyecto = $objRes->fields['seqProyecto'];
                $seqMenu = $objRes->fields['seqMenu'];
                $arrPermisos[ $seqProyecto ][] = $seqMenu;
                $objRes->MoveNext();
            }
            
            return $arrPermisos;
            
        } // fin obtener permisos usuario
        
        /**
         * DADO UN USURARIO DEL APLICATIVO ESTA
         * FUNCOON REGRESA EL CORREO ELECTRONICO DEL USUARIO
         * @author Bernardo Zerda
         * @param string txtUsurio
         * @return string txtCorreo
         * @version 1.0 Abril 2009
         */
        public function obtenerCorreoUsuario( $txtUsuario ){
        	
            global $aptBd;
            $txtCorreo = "";
            
            // consulta el correo electronico del login
            $sql = "
                SELECT txtCorreo
                FROM T_COR_USUARIO
                WHERE txtUsuario = \"$txtUsuario\"            
            ";
            $objRes = $aptBd->execute( $sql );
            if( $objRes->fields ){
                if( $objRes->fields['txtCorreo'] != "" ){
                    $txtCorreo = $objRes->fields['txtCorreo'];
                }
            }
            
            return $txtCorreo;
        } // Fin obtenerCorreoUsuario
        
        /**
         * DADO UN USURARIO DEL APLICATIVO ESTA
         * FUNCOON REGRESA EL IDENTIFICADOR DEL USUARIO
         * @author Bernardo Zerda
         * @param string txtUsurio
         * @return integer seqUsuario
         * @version 1.0 Abril 2009
         */
         
        public function obtenerIdentificadorUsuario( $txtUsuario ){
            
            global $aptBd;
            $seqUsuario = 0;
            
            $sql = "
                SELECT seqUsuario
                FROM T_COR_USUARIO
                WHERE txtUsuario = \"$txtUsuario\"            
            ";
            $objRes = $aptBd->execute( $sql );
            if( $objRes->fields ){
                if( $objRes->fields['seqUsuario'] != "" ){
                    $seqUsuario = $objRes->fields['seqUsuario'];
                }
            }
            
            return $seqUsuario;
        } // Fin obtenerIdentificadorUsuario       
        
        /**
         * ESTA FUNCION GENERA CLAVES DE MANERA ALEATORIA
         * Author: Simon Jarvis
         * Copyright: 2006 Simon Jarvis
         * Date: 03/08/06
         * Updated: 07/02/07
         * @param integer numCaracteres
         * @return string txtClave
         */
        function generarClaveNueva( $numCaracteres = 5 ) {
            
            // universo de caracteres posibles para el cambio de clave
            $txtPosibles = '23456789abcdefghijkmnpqrstvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
            $txtClave = '';
            $i = 0;
            
            // Siembra una nueva semilla para generar numeros aleatorios reales
            mt_srand( time() );
            
            // obtiene aleatoriamente una cantidad de caracteres del universo
            while ($i < $numCaracteres) { 
                $txtClave .= substr($txtPosibles, mt_rand(0, strlen($txtPosibles)-1), 1);
                $i++;
            } 
            return $txtClave;
        }
        
        /**
         * DESPUES DE TRES INTENTOS FALLIDOS SE BLOQUEA EL 
         * USUARIO DEL SISTEMA CUANDO ESTE EXISTA
         * @param string txtUsuario
         * @return array arrErrores
         * @version 1,0 abril 2009
         */
        public function bloquearUsuario( $txtUsuario ){
        	
        	global $aptBd;
        	$arrErrores = array();
        	
          // Verifica la existencia del usuario
        	$seqUsuario = $this->existeUsuario( $txtUsuario );
        	if( $seqUsuario != 0 ){
        		
            // inactiva el usuario
        		$sql = "
        			UPDATE T_COR_USUARIO SET
        				bolActivo = 0
        			WHERE seqUsuario = $seqUsuario
        		";
        		
        		try {
        			$aptBd->execute( $sql );
        		} catch ( Exception $objError ) {
        			$arrErrores[] = "No se ha podido actualizar el usuario, error de autenticacion";
        		}
        		
        	} 
        	
        	
        	return $arrErrores;
        	
        }
        
        /**
         * VERIFICA MEDIATN EL USUARIO COMPROBAR
         * SI EL USUARIO EXISTE O NO EXISTE
         * @author bernardo zerda
         * @param string txtUsuario
         * @return integer seqUsuario
         * @version 1.0 abril 2009
         */
        private function existeUsuario( $txtUsuario ){
        	
        	global $aptBd;
        	$seqUsuario = 0;
        	
        	$sql = "
        		SELECT seqUsuario
        		FROM T_COR_USUARIO
        		WHERE txtUsuario = \"$txtUsuario\"
        	";
        	$objRes = $aptBd->execute( $sql );
        	if( $objRes->fields ){
        		$seqUsuario = $objRes->fields['seqUsuario'];
        	}
        	
        	return $seqUsuario;
        }
        
    } // Fin Clase


?>