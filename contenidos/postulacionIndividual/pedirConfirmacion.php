<?php

    /**
    * PIDE CONFIRMACION DE LOS CAMBIOS GENERADOS EN EL FORMULARIO
    * SI NO HAY CAMBIOS EN EL FORMULARIO SOLO GRABA EL SEGUIMIENTO
    */
    $txtPrefijoRuta = "../../";

    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );

    $bolConfirmacion = false;
    $bolRetorno = false;
    $arrErrores = array();
    $arrMensajes = array();
    $arrCamposLibres = array();
	$arrCamposCalificacion = array();
	$eliminados = false;
	$adicionados = false;

    // Campos que se pueden cambiar sin privilegios
    $arrCamposLibres[] = "txtDireccion";
    $arrCamposLibres[] = "numTelefono1";
    $arrCamposLibres[] = "numTelefono2";
    $arrCamposLibres[] = "numCelular";
    $arrCamposLibres[] = "seqLocalidad";
    $arrCamposLibres[] = "txtCorreo";
    $arrCamposLibres[] = "seqCiudad";
    $arrCamposLibres[] = "seqLocalidad";
    $arrCamposLibres[] = "seqBarrio";
    $arrCamposLibres[] = "seqUpz";
	$arrCamposLibres[] = "bolCerrado";

    $arrCamposCalificacion[] = "valIngresoHogar";
	//$arrCamposCalificacion[] = "valTotalRecursos";
    $arrCamposCalificacion[] = "seqEtnia";
    $arrCamposCalificacion[] = "seqParentesco";
    $arrCamposCalificacion[] = "seqCondicionEspecial";
    $arrCamposCalificacion[] = "seqCondicionEspecial2";
    $arrCamposCalificacion[] = "seqCondicionEspecial3";
    $arrCamposCalificacion[] = "fchNacimiento";
    $arrCamposCalificacion[] = "seqNivelEducativo";
    $arrCamposCalificacion[] = "objCiudadano";

    /* * **********************************************************************************************************
    * VERIFICACION DE CAMBIOS AL FORMULARIO DE ACTUALIZACION
    * ********************************************************************************************************** */

    // Carga los datos
    $claFormulario = new FormularioSubsidios();
    $claFormulario->cargarFormulario($_POST['seqFormulario']);

    // Verifica cambios en los ciudadanos que estan en el post y en la clase
    // ademas verifica si un ciudadano ha sido eliminado del formulario
    $arrCedulasFormulario = array();
    foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
        $numDocumento = $objCiudadano->numDocumento;
        $arrCedulasFormulario[] = $numDocumento;
        if (isset($_POST['hogar'][$numDocumento])) {
            foreach ($objCiudadano as $txtClave => $txtValor) {
                if (isset($_POST['hogar'][$numDocumento][$txtClave])) {
                    if (trim($txtValor) != trim($_POST['hogar'][$numDocumento][$txtClave])) {
                        $arrCamposCambiados[] = $txtClave;
                        $bolConfirmacion = true;
                    }
                }
            }
        } else {
            $arrCamposCambiados[] = "objCiudadano"; // Ciudadano eliminado
            $bolConfirmacion = true;
			$eliminados = true;
        }
    }

    // Verifica si hay ciudadano agregados en el formulario
    foreach ($_POST['hogar'] as $numDocumento => $arrMiembro) {
        if (!in_array($numDocumento, $arrCedulasFormulario)) {
            $arrCamposCambiados[] = "objCiudadano"; // Ciudadano adicionado
            $bolConfirmacion = true;
			$adicionados = true;
        }
    }

    // Verifica si hay cambios en los datos del formulario
    foreach ($claFormulario as $txtClave => $txtValor) {
        if ($txtClave != "arrCiudadano") {
            if (!in_array($txtClave, $arrCamposLibres)) {
                if (isset($_POST[$txtClave])) {
                    $txtValor = ( $txtValor === "0000-00-00" ) ? "" : $txtValor;
                    $txtValor = ( $txtValor === null ) ? 0 : $txtValor;
                    if (substr($txtClave, 0, 3) == "val") {
                        $valFormateado = mb_ereg_replace("[^0-9]", "", $_POST[$txtClave]);
                    } else {
                        $valFormateado = $_POST[$txtClave];
                    }
                    if ($txtValor != $valFormateado) {
                        $arrCamposCambiados[] = $txtClave;
                        $bolConfirmacion = true;
                    }
                }
            }
        }
    }

    /* * **********************************************************************************************************
    * MOSTRAR EL CUADRO DE CONFIRMACION DE DATOS
    * ********************************************************************************************************** */
    
    if ($bolConfirmacion == true) {

          if( $_POST["bolSancion"] == 1 ) {
             
             $arrErrores[] = "No se puede modificar la postulacion del hogar debido a que esta Sancionado.";
             imprimirMensajes( $arrErrores , array( ) );
             
          } else {
             
			if( $claFormulario->seqTipoEsquema == 1 ){
				// Consulta etapa del formulario
				$sqlEtapa = "SELECT seqEtapa FROM T_FRM_ESTADO_PROCESO WHERE seqEstadoProceso = " . $claFormulario->seqEstadoProceso;
				$exeEtapa = mysql_query($sqlEtapa);
				$rowEtapa = mysql_fetch_array($exeEtapa);
				$etapaActual = $rowEtapa['seqEtapa'];
				// Validaciones
				if (($etapaActual == 4 || $etapaActual == 5) && $claFormulario->bolCerrado == 1){
					// Hace el cambio pero no altera el estado y el esquema
				} else {
					// revisa si los cambios son en campos que afectan la calificacion
					// de ser asi, se altera el estado del proceso para que quede en 37. Inscripcion - Hogar Actualizado
					if ($eliminados == true || $adicionados == true){
						$_POST['seqEstadoProceso'] = 37;
						//$_POST['seqTipoEsquema'] = 0;
						//break;
					}

					foreach( $arrCamposCambiados as $txtCampo ){                 
						if(in_array($txtCampo, $arrCamposCalificacion) ){
							$bolRetorno = true;
							$_POST['seqEstadoProceso'] = 37;
							//$_POST['seqTipoEsquema'] = 0;
							break;
						}
					}
				}
			}
             
             if( $_POST['seqEstadoProceso'] == 37 ){
                $_POST['bolCerrado'] = 0;
                $_POST['fchPostulacion'] = "";
             }
             
             if( $bolRetorno == false ){
                $txtMensaje = "Es necesario que confirme la accion que esta apunto de realizar:";
                $txtMensaje.= "<div class='msgOk' style='font-size:12px;'>";
                $txtMensaje.= "¿Desea salvar los cambios realizados para el documento " . number_format( $_POST['numDocumento'] ) . "?";
                $txtMensaje.= "</div>";
             }else{
                $txtMensaje = "Se han cambiado datos del hogar que afectan la calificación del indice de vulnerabilidad.<br>";
                $txtMensaje.= "Se salvarán los datos pero el estado del proceso del hogar se cambiará a 'Inscripcion - Hogar Actualizado'.<br>";
                $txtMensaje.= "<div class='msgOk' style='font-size:12px;'>";
                $txtMensaje.= "¿Desea salvar los cambios realizados para el documento " . number_format( $_POST['numDocumento'] ) . "?";
                $txtMensaje.= "</div>";
             }
                
             $claSmarty->assign("txtMensaje"      , $txtMensaje          );
             $claSmarty->assign("bolConfirmacion" , $bolConfirmacion     );
             $claSmarty->assign("txtArchivo"      , $_POST['txtArchivo'] );
             $claSmarty->assign("arrPost"         , $_POST               );
             $claSmarty->display("subsidios/pedirConfirmacion.tpl");      
             
          }
        
    } else {

        if (trim($_POST['txtComentario']) == "") {
            $arrErrores[] = "Debe digitar el campo de comentarios";
        }
        
        if (intval($_POST['seqGrupoGestion']) == 0) {
            $arrErrores[] = "Seleccione el grupo de gestion";
        }
        
        if (intval($_POST['seqGestion']) == 0) {
            $arrErrores[] = "Seleccione la gestion realizada";
        }

        if (empty($arrErrores)) {

            // modificacion del formulario de los campos libres
            $fchPostulacion =$claFormulario->fchPostulacion;
            if($_POST['seqFormulario'] && $claFormulario->fchPostulacion == "0000-00-00 00:00:00")
                $fchPostulacion = date( "Y-m-d H:i:s" );
            $sql = "UPDATE T_FRM_FORMULARIO SET ";
            foreach ($arrCamposLibres as $txtCampo) {
                $sql .= $txtCampo . " = '" . $_POST[$txtCampo] . "',";
            }
            //$sql = trim($sql, ",");
            //$sql .= " WHERE seqFormulario = " . $_POST['seqFormulario'];
            $sql .= " fchPostulacion= '" . $fchPostulacion . "' WHERE seqFormulario = " . $_POST['seqFormulario'];
           // echo "<p>".$sql."<p>";
            $aptBd->execute($sql);

            // una vez hechos los cambios se carga el formulario para compararlo con el de antes
            $claFormularioNuevo = new FormularioSubsidios();
            $claFormularioNuevo->cargarFormulario($_POST['seqFormulario']);

            // Ciudadano Atendido
            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                if ($objCiudadano->numDocumento == $_POST['numDocumento']) {
                    $txtNombre = trim($objCiudadano->txtNombre1) . " ";
                    $txtNombre .= ( trim($objCiudadano->txtNombre2) != "" ) ? trim($objCiudadano->txtNombre2) . " " : "";
                    $txtNombre .= trim($objCiudadano->txtApellido1) . " ";
                    $txtNombre .= trim($objCiudadano->txtApellido2);
                }
            }

            // obtiene los cambios para dejar el registro
            $claSeguimiento = new Seguimiento;
            $txtCambios = $claSeguimiento->cambiosPostulacion($_POST['seqFormulario'], $claFormulario, $claFormularioNuevo);

			$numDocumentoFormat = str_replace(".", "", $_POST['numDocumento']);
			
            $sql = "
               INSERT INTO T_SEG_SEGUIMIENTO ( 
                  seqFormulario, 
                  fchMovimiento, 
                  seqUsuario, 
                  txtComentario, 
                  txtCambios, 
                  numDocumento, 
                  txtNombre, 
                  seqGestion
               ) VALUES (
                  " . $_POST['seqFormulario'] . ",
                  now(),
                  " . $_SESSION['seqUsuario'] . ",
                  \"" . ereg_replace("\n", "", $_POST['txtComentario']) . "\",
                  \"$txtCambios\",
                  " . $numDocumentoFormat . ",
                  \"" . $txtNombre . "\",
                  " . $_POST['seqGestion'] . "
               )					
            ";

            try {
                $aptBd->execute($sql);
                $seqSeguimiento = $aptBd->Insert_ID();
            } catch (Exception $objError) {
                $arrErrores[] = "No se ha podido registrar la actividad del hogar, contacte al administrador";
            }

            if (empty($arrErrores)) {
                $txtEstilo = "msgOk";
                $arrMensajes[] = "Ha salvado un registro de actividad, el numero del registro es " .
                        number_format($seqSeguimiento, 0, ".", ",") .
                        ". Conserve este número para su referencia.";
            }else{
                $arrMensajes = $arrErrores;
                $txtEstilo = "msgError";
            }
            
            echo "<table cellpadding='0' cellspacing='0' border='0' width='100%' id='tablaMensajes' style='padding:5px' class='$txtEstilo'>" ;
            foreach( $arrMensajes as $txtMensaje ){
                echo "<tr><td class='$txtEstilo'><li>$txtMensaje</li></td></tr>";
            }
            echo "</table>";
            
        }

    }

?>