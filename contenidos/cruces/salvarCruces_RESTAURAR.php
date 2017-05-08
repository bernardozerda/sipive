<?php

    /**
     * INICIO DE LA PANTALLA DE VERIFICACION DE CRUCES DE CASA EN MANO
     * @author Bernardo Zerda
     * @version 1.0 Dic 2013
     */
    date_default_timezone_set("America/Bogota");

    $txtPrefijoRuta = "../../";
    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );

    $arrErrores = array();
    $arrMensajes = array();
    $arrEstados = estadosProceso();

    $arrExtensiones[] = "csv";
    $arrExtensiones[] = "txt";

    /* * ********************************************************************
     * VALIDACIONES DEL FORMULARIO Y DEL ARCHIVO
     * ******************************************************************** */

    // Nombre del cruce
    if (trim($_POST['nombre']) == "") {
        $arrErrores[] = "Debe dar un nombre al cruce";
    }

    // fecha del cruce
    if (trim($_POST['fecha']) == "") {
        $arrErrores[] = "Seleccione una fecha para el cruce";
    }

    // texto del cuerpo de la carta
    if (trim($_POST['cuerpo']) == "") {
        $arrErrores[] = "Es necesario el texto del cuerpo de la carta";
    }

    // Texto del pie de la carta
    if (trim($_POST['pie']) == "") {
        $arrErrores[] = "Es necesario el texto del pie de la carta";
    }

    // quien firma las cartas
    if (trim($_POST['firma']) == "") {
        $arrErrores[] = "Es necesario que determine el nombre de la persona que firma las cartas";
    }

    // quien elabora las cartas
    if (trim($_POST['elaboro']) == "") {
        $arrErrores[] = "Es necesario indicar la persona que esta elaborando las cartas";
    }

    // quien revisa las cartas
    if (trim($_POST['reviso']) == "") {
        $arrErrores[] = "Es necesario que indique la persona que revisa las cartas";
    }

    // validaciones para el archivo cargado
    switch ($_FILES['archivo']['error']) {
        case UPLOAD_ERR_INI_SIZE:
            $arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            $arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
            break;
        case UPLOAD_ERR_PARTIAL:
            $arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
            break;
        case UPLOAD_ERR_NO_FILE:
            $arrErrores[] = "Debe especificar un archivo para cargar";
            break;
        default:
            $numPunto = strpos($_FILES['archivo']['name'], ".") + 1;
            $numRestar = ( strlen($_FILES['archivo']['name']) - $numPunto ) * -1;
            $txtExtension = substr($_FILES['archivo']['name'], $numRestar);
            if (!in_array(strtolower($txtExtension), $arrExtensiones)) {
                $arrErrores[] = "Tipo de Archivo no permitido $txtExtension ";
            }
            break;
    }

    // validaciones para las lineas del archivo
    if (empty($arrErrores)) {

        $aptArchivo = fopen($_FILES['archivo']['tmp_name'], "r");
        if ($aptArchivo) {
            $txtLinea = fgets($aptArchivo);
            $numLinea = 0;
            while ($txtLinea = fgets($aptArchivo)) {
                $numLinea++;

                $txtLinea = utf8_encode($txtLinea);

                // Separa las lineas para que cada linea quede en un array
                $arrLinea = "";
                $arrLinea = mb_split("\t", trim($txtLinea));

                // Limpia y codifica cada uno de los campos
                foreach ($arrLinea as $txtClave => $txtValor) {
                    $arrLinea[$txtClave] = trim($txtValor);
                }

                // Valida que los textos del archivo no hayan sido cambiados
                $seqFormulario = $arrLinea[0];
                $seqModalidad = obtenerSecuencial($arrLinea[1], "T_FRM_MODALIDAD", "txtModalidad", "seqModalidad");
                $seqEstadoProceso = 0;
                foreach ($arrEstados as $seqEstado => $txtEstado) {
                    if ($txtEstado == $arrLinea[2]) {
                        $seqEstadoProceso = $seqEstado;
                    }
                }
                $seqTipoDocumento = obtenerSecuencial($arrLinea[3], "T_CIU_TIPO_DOCUMENTO", "txtTipoDocumento", "seqTipoDocumento");
                $numDocumento = mb_ereg_replace("[^0-9]", "", $arrLinea[4]);
                $txtNombre = $arrLinea[5];
                $seqParentesco = obtenerSecuencial($arrLinea[6], "T_CIU_PARENTESCO", "txtParentesco", "seqParentesco");
                $txtEntidad = $arrLinea[7];
                $txtTitulo = $arrLinea[8];
                $txtDetalle = $arrLinea[9];
                $bolInhabilitar = ( trim(mb_strtoupper($arrLinea[10])) == "NO" ) ? 0 : 1;
                $txtObservaciones = $arrLinea[11];

                // Si no existe la modalidad
                if ($seqModalidad == 0) {
                    $arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ": La modalidad no existe";
                }

                // Si no existe el estado del proceso
                if ($seqEstadoProceso == 0) {
                    $arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ": El estado del proceso no existe";
                }

                // Si no existe el tipo de documento
                if ($seqTipoDocumento == 0) {
                    $arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ": El tipo de documento no existe";
                }

                // Si no existe el parentesco
                if ($seqParentesco == 0) {
                    $arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ": El parentesco no existe";
                }

                // si toda la linea esta bien la pasa al arreglo
                if (empty($arrErrores)) {
                    $arrLinea[0] = $seqFormulario;
                    $arrLinea[1] = $seqModalidad;
                    $arrLinea[2] = $seqEstadoProceso;
                    $arrLinea[3] = $seqTipoDocumento;
                    $arrLinea[4] = $numDocumento;
                    $arrLinea[5] = $txtNombre;
                    $arrLinea[6] = $seqParentesco;
                    $arrLinea[7] = $txtEntidad;
                    $arrLinea[8] = $txtTitulo;
                    $arrLinea[9] = str_replace('"',"",$txtDetalle);
                    $arrLinea[10] = $bolInhabilitar;
                    $arrLinea[11] = $txtObservaciones;
                    $arrArchivo[$numLinea] = $arrLinea;
                }
            }
        } else {
            $arrErrores[] = "El archivo no se pudo abrir";
        }
    }

    if (empty($arrErrores)) {

        $sql = "
             SELECT 
               cru.seqCruce, 
               COUNT(res.seqResultado) as cantidad
             FROM T_CRU_CRUCES cru
             INNER JOIN T_CRU_RESULTADO res ON cru.seqCruce = res.seqCruce
             WHERE cru.txtNombre = '" . $_POST['nombre'] . "'
             GROUP BY seqCruce
          ";
        $objRes = $aptBd->execute($sql);
        $seqCruce = 0;
        if ($objRes->fields) {
            $seqCruce = $objRes->fields['seqCruce'];
            $numCantidad = $objRes->fields['cantidad'];
        }

        if ($seqCruce == 0) {

            $sql = "
                  INSERT INTO T_CRU_CRUCES(
                      txtNombre,
                      fchCruce,
                      txtCuerpo,
                      txtPie,
                      txtFirma,
                      txtElaboro,
                      txtReviso
                  ) VALUES (
                      '" . $_POST['nombre'] . "',
                      '" . $_POST['fecha'] . "',
                      '" . $_POST['cuerpo'] . "',
                      '" . $_POST['pie'] . "',
                      '" . $_POST['firma'] . "',
                      '" . $_POST['elaboro'] . "',
                      '" . $_POST['reviso'] . "'
                  )
              ";
            $aptBd->execute($sql);
            $seqCruce = $aptBd->Insert_ID();
        } else {
//echo "numLinea--->".$numLinea ."numcantidad--->".$numCantidad; die();
            if ($numLinea == $numCantidad) {

                $sql = "
                    UPDATE T_CRU_CRUCES SET
                        txtNombre = '" . $_POST['nombre'] . "',
                        fchCruce = '" . $_POST['fecha'] . "',
                        txtCuerpo = '" . $_POST['cuerpo'] . "',
                        txtPie = '" . $_POST['pie'] . "',
                        txtFirma = '" . $_POST['firma'] . "',
                        txtElaboro = '" . $_POST['elaboro'] . "',
                        txtReviso = '" . $_POST['reviso'] . "'
                    WHERE seqCruce = $seqCruce
                ";
                $aptBd->execute($sql);

                $sql = "
                    DELETE 
                    FROM T_CRU_RESULTADO 
                    WHERE seqCruce = $seqCruce
                ";
                $aptBd->execute($sql);
            } else {
                $arrErrores[] = "La cantidad de registros del archivo cargado no coincide con la plantilla de la base de datos";
            }
        }

        if (empty($arrErrores)) {
            foreach ($arrArchivo as $numLinea => $arrLinea) {

                $sql = "
                   INSERT INTO T_CRU_RESULTADO (
                       seqCruce,
                       seqFormulario,
                       seqModalidad,
                       seqEstadoProceso,
                       seqTipoDocumento,
                       numDocumento,
                       txtNombre,
                       seqParentesco,
                       txtEntidad,
                       txtTitulo,
                       txtDetalle,
                       bolInhabilitar,
                       txtObservaciones
                   ) VALUES (
                       $seqCruce,
                       '" . $arrLinea[0] . "',
                       '" . $arrLinea[1] . "',
                       '" . $arrLinea[2] . "',
                       '" . $arrLinea[3] . "',
                       '" . $arrLinea[4] . "',
                       '" . $arrLinea[5] . "',
                       '" . $arrLinea[6] . "',
                       '" . $arrLinea[7] . "',
                       '" . $arrLinea[8] . "',
                       '" . $arrLinea[9] . "',
                       '" . $arrLinea[10] . "',
                       '" . $arrLinea[11] . "'
                   )                
                ";
                $aptBd->execute($sql);

                if (!isset($arrHogares[$arrLinea[0]])) {
                    $arrHogares[$arrLinea[0]] = intval($arrLinea[10]);
                } else {
                    if ($arrHogares[$arrLinea[0]] == 0) {
                        $arrHogares[$arrLinea[0]] = intval($arrLinea[10]);
                    }
                }
            }
        }
    }

    /*****************************************************************************
     * PROCESAMIENTO DE LOS DATOS DEL ARCHIVO
     * ************************************************************************* */
    
    if (empty($arrErrores)) {
        $numInhabilitados = 0;
        $numHabilitados = 0;
        foreach ($arrHogares as $seqFormulario => $bolInhabilitar) {

            if ($bolInhabilitar == 0) {
                $numHabilitados++;
            } else {
                $numInhabilitados++;
            }

            $claFormulario = new FormularioSubsidios;
            $claFormulario->cargarFormulario($seqFormulario);

            switch (true) {

                // Esquema de postulacion Individual
                case $claFormulario->seqTipoEsquema == 1:

                    // Los estados del proceso de cruces 
                    //   - 54. Postulacion - IND - Hogar Actualizado
                    //   - 56. Postulacion - IND - Segunda Verificacion Pendiente (Con Cruces)
                    //   - 16. Asignacion - Pediente Acto Administrativo (Sin Cruces)
                    if (in_array($claFormulario->seqEstadoProceso, array(54, 55, 56))) {
                        $seqEstadoProceso = ( $bolInhabilitar == 0 ) ? 16 : 56;
                        $sql = "
                            UPDATE T_FRM_FORMULARIO SET 
                                seqEstadoProceso = $seqEstadoProceso
                            WHERE seqFormulario = $seqFormulario
                        ";
                        $aptBd->execute($sql);
                    }

                    break;
    
                // Esquema Casa en Mano
                case $claFormulario->seqTipoEsquema == 5:
                    
                    // Obtiene los registro de casa en mano del hogar
                    $claCasaMano = new CasaMano();
                    $arrCasaMano = $claCasaMano->cargar($seqFormulario);

                    // obtiene el registro mas reciente de casa en mano
                    $numFechaCasaMano = 0;
                    foreach ($arrCasaMano as $seqCasaMano => $objCasaMano) {
                        if (strtotime($objCasaMano->objRegistroOferta->fchCreacion) > $numFechaCasaMano) {
                            $seqUltimoCasaMano = $seqCasaMano;
                        }
                    }
                    $objCasaMano = $arrCasaMano[$seqUltimoCasaMano];

                    // Carga los datos del formulario para obtener el nombre del PPAL
                    foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                        if ($objCiudadano->seqParentesco == 1) {
                            break;
                        }
                    }

                    $arrPost['seqFormulario'] = $seqFormulario;
                    $arrPost['seqGrupoGestion'] = 11;
                    $arrPost['seqGestion'] = 48;
                    $arrPost['cedula'] = mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento);
                    $arrPost['nombre'] = $objCiudadano->txtNombre1 . " ";
                    $arrPost['nombre'] .= ( $objCiudadano->txtNombre2 != "" ) ? $objCiudadano->txtNombre2 . " " : "";
                    $arrPost['nombre'] .= $objCiudadano->txtApellido1 . " ";
                    $arrPost['nombre'] .= $objCiudadano->txtApellido2;
                    $arrPost['txtCambios'] = "";
                    $arrPost['seqCruce'] = $seqCruce;
                    $arrPost['seqCasaMano'] = $objCasaMano->seqCasaMano;
                    $arrPost['fchCruce'] = $_POST['fecha'];
                    $arrPost['bolResultado'] = ( $bolInhabilitar == 0 ) ? 1 : 2;
                    
                    $txtReporteCruces = ( $bolInhabilitar == 0 ) ? "Sin Reporte de Cruces" : "Pendiente Verificación de Cruces";

                    $txtFase = "";
                    $txtComentario = "";

                    
					//echo "seqPrimeraVerificacion: " . $objCasaMano->seqPrimeraVerificacion. "<br>";
					//echo "seqSegundaVerificacion: " . $objCasaMano->seqSegundaVerificacion. "<br>";
					//echo "seqCruce: " . $seqCruce. "<br>";
					
					// es primera verificacion
                    if (intval($objCasaMano->seqPrimeraVerificacion) == 0) {
                        $txtFase = "primeraVerificacion";
                        $txtComentario = "Primera Verificaci&oacute;n de Esquema de Casa en Mano<br>Resultado: $txtReporteCruces";

                        // Modificacion de la Primera Verificacion
                    } elseif (intval($objCasaMano->seqPrimeraVerificacion) == $seqCruce) {
                        $txtFase = "primeraVerificacion";
                        $txtComentario = "Primera Verificaci&oacute;n de Esquema de Casa en Mano<br>Resultado: $txtReporteCruces";

                        // segunda verificacion
                    } elseif (intval($objCasaMano->seqSegundaVerificacion) == 0) {
                        $txtFase = "segundaVerificacion";
                        $txtComentario = "Segunda Verificaci&oacute;n de Esquema de Casa en Mano<br>Resultado: $txtReporteCruces";

                        // segunda Verificacion
                    } elseif (intval($objCasaMano->seqSegundaVerificacion) == $seqCruce) {
                        $txtFase = "segundaVerificacion";
                        $txtComentario = "Segunda Verificaci&oacute;n de Esquema de Casa en Mano<br>Resultado: $txtReporteCruces";

                        // tercer cruce -- error
                    } else {
                        $arrErrores[] = "El hogar " . $seqFormulario . " ya tiene cruces en primera y segunda verificacion, dichos cruces no coinciden con este cruce";
                    }

                    $arrPost['txtFase'] = $txtFase;
                    $arrPost['txtComentario'] = $txtComentario;

                    unset($arrPost['seqEstadoProceso']);
					//pr($arrPost); die();

                    $objCasaMano->salvar($arrPost);

                    foreach ($objCasaMano->arrErrores as $txtError) {
                        $arrErrores[] = "Error $seqFormulario: " . $txtError;
                    }                    
                    
                    break;
                
                // Otros esquemas
                default:
                    
                    // Los estados del proceso de cruces 
                    //   - 37. Inscripcion - Hogar Actualizado
                    //   - 41. Inscripcion - Primera Verificacion Aprobada  (Sin Cruces)
                    //   - 42. Inscripcion - Primera Verificacion Pendiente (Con Cruces)
                    //   -  7. Postulacion - Calificacion Vulnerabilidad
                    if (in_array($claFormulario->seqEstadoProceso, array(37, 41, 42, 7))) {
                        $seqEstadoProceso = ( $bolInhabilitar == 0 ) ? 41 : 42;
                        $sql = "
                            UPDATE T_FRM_FORMULARIO SET 
                                seqEstadoProceso = $seqEstadoProceso
                            WHERE seqFormulario = $seqFormulario
                        ";
                        $aptBd->execute($sql);
                    }
                    
                    break;
                
            }

        }
    }

    if (empty($arrErrores)) {
        $arrMensajes[] = "Ha cargado los registros para el cruce de fecha \"" . $_POST['nombre'] . "\"" .
                "<ul><li>Se han obtenido " . $numInhabilitados . " hogares reportados con cruces</li>" .
                "<li>Se han obtenido " . $numHabilitados . " hogares sin cruces</li></ul>";
        $arrMensajes[] = "Para un total de " . count($arrHogares) . " hogares en el cruce";
    }

    imprimirMensajes($arrErrores, $arrMensajes);
?>
