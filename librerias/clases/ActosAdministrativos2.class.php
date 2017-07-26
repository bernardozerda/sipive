<?php

/**
 * CLASE PARA LOS TIPOS DE ACTOS ADMINISTRATIVOS
 * OBTIENE SUS CARACTERISTICAS Y LOS TIPOS DE DATOS 
 * DE CADA CARACTERISTICA DE ACUERDO AL TIPO DE ACTO
 * @author Bernardo Zerda Rodriguez
 * @Modified Jaison Josue Ospina
 * @version 2.0 Mayo de 2016
 * */
Class TipoActoAdministrativo {

    public $seqTipoActo;
    public $txtTipoActo;
    public $arrCaracteristicas;
    public $arrFormatoArchivo;
    public $arrErrores;

    /**
     * CONSTRUCTOR
     */
    function TipoActoAdministrativo() {
        $this->seqTipoActo = null;
        $this->txtTipoActo = null;
        $this->arrCaracteristicas = null;
        $this->arrFormatoArchivo = null;
        $this->arrErrores = null;
    }

    /**
     * CARGA TODAS LAS CARACTERISTICAS DE UN ACTO ADMINSITRATIVO
     * @global type $aptBd
     * @param type $seqTipoActo
     * @return \TipoActoAdministrativo
     */
    public function cargarTipoActo($seqTipoActo = 0) {
        global $aptBd;
        $arrTipoActo = array();
        try {

            // CARGANDO LAS CARACTERISTICAS DE LA BASES DE DATOS
            $txtCondicion = ( $seqTipoActo != 0 ) ? "WHERE tac.seqTipoActo = " . $seqTipoActo : "";
            $sql = "
                   SELECT 
                     tac.seqTipoActo,
                     tac.txtNombreTipoActo,
                     cac.seqCaracteristica,
                     cac.txtNombreCaracteristica,
                     cac.txtTipoDato
                   FROM T_AAD_TIPO_ACTO tac
                   INNER JOIN T_AAD_CARACTERISTICA_ACTO cac ON cac.seqTipoActo = tac.seqTipoActo
                   $txtCondicion
                   ORDER BY tac.seqTipoActo
                ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {

                $seqTipoActo = $objRes->fields['seqTipoActo'];
                $seqCaracteristica = $objRes->fields['seqCaracteristica'];

                if (!isset($arrTipoActo[$seqTipoActo])) {
                    $objTipoActo = new TipoActoAdministrativo();
                }

                $objTipoActo->seqTipoActo = $seqTipoActo;
                $objTipoActo->txtTipoActo = $objRes->fields['txtNombreTipoActo'];

                if (intval($seqCaracteristica) != 0) {
                    $objTipoActo->arrCaracteristicas[$seqCaracteristica]['txtNombre'] = $objRes->fields['txtNombreCaracteristica'];
                    $objTipoActo->arrCaracteristicas[$seqCaracteristica]['txtTipo'] = $objRes->fields['txtTipoDato'];
                }

                // CARGANDO LOS FORMATOS DE LOS ARCHIVOS
                if (empty($objTipoActo->arrFormatoArchivo)) {

                    switch ($seqTipoActo) {
                        case 1: // Resolucion de asignacion
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento Postulante Principal";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            break;
                        case 2: // Resolucion Modificatoria
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento Postulante Principal";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[1]['nombre'] = "Campo a Modificar";
                            $objTipoActo->arrFormatoArchivo[1]['tipo'] = "texto";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "primer nombre";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "segundo nombre";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "primer apellido";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "segundo apellido";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "documento";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "tipo de solucion";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "valor del subsidio";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "matricula inmobiliaria";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "proyecto";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "unidad habitacional";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "valor donacion";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "soporte donacion";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "entidad donacion";
                            $objTipoActo->arrFormatoArchivo[2]['nombre'] = "Valor Incorrecto";
                            $objTipoActo->arrFormatoArchivo[2]['tipo'] = "texto";
                            $objTipoActo->arrFormatoArchivo[3]['nombre'] = "Valor Correcto";
                            $objTipoActo->arrFormatoArchivo[3]['tipo'] = "texto";
                            break;
                        case 3: // Resolucion de inhabilitados
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Identificador del Formulario";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[1]['nombre'] = "Documento";
                            $objTipoActo->arrFormatoArchivo[1]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[2]['nombre'] = "Nombre";
                            $objTipoActo->arrFormatoArchivo[2]['tipo'] = "texto";
                            $objTipoActo->arrFormatoArchivo[3]['nombre'] = "Fuente";
                            $objTipoActo->arrFormatoArchivo[3]['tipo'] = "texto";
                            $objTipoActo->arrFormatoArchivo[4]['nombre'] = "Causa";
                            $objTipoActo->arrFormatoArchivo[4]['tipo'] = "texto";
                            $objTipoActo->arrFormatoArchivo[5]['nombre'] = "Detalle";
                            $objTipoActo->arrFormatoArchivo[5]['tipo'] = "texto";
                            break;
                        case 4: // Recurso de Reposicion
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento. Corresponde al Postulante Principal";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[1]['nombre'] = "Estado. Corresponde al estado del proceso Resultante";
                            $objTipoActo->arrFormatoArchivo[1]['tipo'] = "numero";
                            break;
                        case 5: // Resolucion de No Asignado
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento Postulante Principal";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            break;
                        case 6: // Resolucion de Renuncia
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento Postulante Principal";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            break;
                        case 7: // Notificacion
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento Postulante Principal";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[1]['nombre'] = "Numero de Resolución Referencia"; // al cual hace referencia la modificatoria
                            $objTipoActo->arrFormatoArchivo[1]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[2]['nombre'] = "Fecha de Resolución Referencia"; // al cual hace referencia la modificatoria
                            $objTipoActo->arrFormatoArchivo[2]['tipo'] = "fecha";
                            break;
                        case 8: // Resolucion de Indexacion
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento Postulante Principal";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[1]['nombre'] = "Numero de Resolución Referencia";
                            $objTipoActo->arrFormatoArchivo[1]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[2]['nombre'] = "fecha Resolución Referencia";
                            $objTipoActo->arrFormatoArchivo[2]['tipo'] = "fecha";
                            $objTipoActo->arrFormatoArchivo[3]['nombre'] = "Valor de Indexacion";
                            $objTipoActo->arrFormatoArchivo[3]['tipo'] = "numero";
                            break;
                        case 9: // Resolucion de Perdida
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento Postulante Principal";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            break;
                        case 10: // Resolucion de Revocatoria
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento Postulante Principal";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            break;
                        case 11: // Resolucion de Exclusion
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento Postulante Principal";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[1]['nombre'] = "Estado del proceso Resultante";
                            $objTipoActo->arrFormatoArchivo[1]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[2]['nombre'] = "Comentario";
                            $objTipoActo->arrFormatoArchivo[2]['tipo'] = "texto";
                            break;
                        default: // Otros tipos de actos
                            $this->arrErrores[] = "Tipo de acto administrativo inexistente " . $seqTipoActo;
                            break;
                    }
                }

                $arrTipoActo[$seqTipoActo] = $objTipoActo;

                $objRes->MoveNext();
            }
        } catch (Exeption $objError) {
            $this->arrErrores[] = "No se pudo cargar los tipos de actos administrativos";
        }
        return $arrTipoActo;
    }

    /**
     * VALIDACION DEL ARCHIVO DE CARGA
     */
    public function validarArchivo($arrArchivo) {
        $this->arrErrores = array();
        $arrTipoActoLibre = array(2, 3); // Tipos de acto en donde los textos pueden ser vacios
        unset($arrArchivo[0]); // Quita la fila de titulos
        foreach ($arrArchivo as $numFila => $arrFila) {
            foreach ($arrFila as $numColumna => $txtValor) {
                $bolError = false;
                switch ($this->arrFormatoArchivo[$numColumna]['tipo']) {
                    case "textarea":
                        $bolError = ( (!in_array($this->seqTipoActo, $arrTipoActoLibre) ) and trim($txtValor) == "" ) ? true : false;
                        break;
                    case "texto":
                        $bolError = ( (!in_array($this->seqTipoActo, $arrTipoActoLibre) ) and trim($txtValor) == "" ) ? true : false;
                        break;
                    case "numero":
                        $bolError = ( floatval($txtValor) == 0 ) ? true : false;
                        break;
                    case "fecha":
                        $bolError = ( esFechaValida($txtValor) == true ) ? false : true;
                        break;
                    default:
                        $bolError = ( (!in_array($this->seqTipoActo, $arrTipoActoLibre) ) and trim($txtValor) == "" ) ? true : false;
                        break;
                }

                if ($bolError == false and isset($this->arrFormatoArchivo[$numColumna]['rango']) and ! empty($this->arrFormatoArchivo[$numColumna]['tipo'])) {
                    if (!in_array(strtolower($txtValor), $this->arrFormatoArchivo[$numColumna]['rango'])) {
                        $bolError = true;
                    }
                }

                if ($bolError == true) {
                    $this->arrErrores[] = "Error en la linea " . ( $numFila + 1 ) . ", columna " .
                            $this->arrFormatoArchivo[$numColumna]['nombre'] . ": El valor " .
                            $txtValor . " no es válido";
                }
            }
        }
    }

    /**
     * VALIDACION DE DATOS PARA LOS HOGARES SEGUN EL TIPO DE ACTO ADMINISTRATIVO
     */
    public function validarDatos($arrPost, $arrArchivo) {
        global $aptBd;

        $arrFormularios = array();

        // Obtiene los formularios de los hogares vinculados en el archivo
        unset($arrArchivo[0]); // Quitar la columna de titulos
        foreach ($arrArchivo as $numLinea => $arrLinea) {
            $numDocumento = $arrLinea[0];
            if (!isset($arrFormularios[$numDocumento])) {
                $claCiudadano = new Ciudadano();
                if ($arrPost['seqTipoActo'] != 3) {
                    $seqFormulario = $claCiudadano->formularioVinculado($numDocumento, true);
                } else {
                    $seqFormulario = $numDocumento;
                }
                if ($seqFormulario != 0) {
                    $claFormulario = new FormularioSubsidios();
                    $claFormulario->cargarFormulario($seqFormulario);
                    $arrFormularios['formularios'][$numDocumento] = $claFormulario;
                } else {
                    $this->arrErrores[] = "Error linea " . ( $numLinea + 1 ) . ": El documento " . number_format($numDocumento) . " no es el postulante principal del hogar o el documento no existe";
                }
            }

            if (empty($this->arrErrores)) {
                switch ($arrPost['seqTipoActo']) {
                    case 2: // Resolucion de modificacion
                        $numRegistro = count($arrFormularios['datos'][$numDocumento]);
                        $arrFormularios['datos'][$numDocumento][$numRegistro]['campo'] = $arrLinea[1];
                        $arrFormularios['datos'][$numDocumento][$numRegistro]['incorrecto'] = $arrLinea[2];
                        $arrFormularios['datos'][$numDocumento][$numRegistro]['correcto'] = $arrLinea[3];
                        break;
                    case 3: // Resolucion de inhabilitados
                        $seqFormulario = $numDocumento;
                        $numDocumento = $arrLinea[1];
                        $numRegistro = count($arrFormularios['datos'][$seqFormulario][$numDocumento]);
                        $arrFormularios['datos'][$seqFormulario][$numDocumento][$numRegistro]['fuente'] = $arrLinea[3];
                        $arrFormularios['datos'][$seqFormulario][$numDocumento][$numRegistro]['causa'] = $arrLinea[4];
                        $arrFormularios['datos'][$seqFormulario][$numDocumento][$numRegistro]['detalle'] = $arrLinea[5];
                        break;
                    case 4:
                        $arrFormularios['datos'][$numDocumento]['estado'] = $arrLinea[1];
                        break;
                    case 7: // Notificaciones
                        $arrFormularios['datos'][$numDocumento]['numero'] = $arrLinea[1];
                        $arrFormularios['datos'][$numDocumento]['fecha'] = $arrLinea[2];
                        break;
                    case 8: // indexacion
                        $arrFormularios['datos'][$numDocumento]['numero'] = $arrLinea[1];
                        $arrFormularios['datos'][$numDocumento]['fecha'] = $arrLinea[2];
                        $arrFormularios['datos'][$numDocumento]['valor'] = $arrLinea[3];
                        break;
                    case 11:
                        $arrFormularios['datos'][$numDocumento]['estado'] = $arrLinea[1];
                        break;
                }
            }
        }

        // Inician las validaciones para cada hogar y segun el tipo de acto adminsitrativo
        if (empty($this->arrErrores)) {
            foreach ($arrFormularios['formularios'] as $numDocumento => $objFormulario) {
                switch ($arrPost['seqTipoActo']) {
                    case 1: // Resolucion de asignacion
                        // 16. Acto adminsitrativo pendiente (etapa de asignacion)
                        // 41. Primera verificacion aprobada (etapa de inscripcion)
                        $arrEstadosPermitidos = array(16, 41);
                        if (!in_array($objFormulario->seqEstadoProceso, $arrEstadosPermitidos)) {
                            $txtEstado = obtenerCampo("T_FRM_ESTADO_PROCESO", $objFormulario->seqEstadoProceso, "txtEstadoProceso", "seqEstadoProceso");
                            $this->arrErrores[] = "El hogar del documento " . number_format($numDocumento) . " no puede ser asignado, el estado del proceso actual es " . $txtEstado;
                        }
                        if ($objFormulario->bolCerrado == 0) {
                            $this->arrErrores[] = "El hogar del documento " . number_format($numDocumento) . " no puede ser asignado, el Formulario se encuentra Abierto ";
                        }

                        break;
                    case 2: // Modificatoria
                        if (isset($arrFormularios['datos'][$numDocumento])) {
                            foreach ($arrFormularios['datos'][$numDocumento] as $arrRegistro) {
                                switch (strtolower($arrRegistro['campo'])) {
                                    case "primer nombre":
                                        if (trim($arrRegistro['correcto']) == "") {
                                            $this->arrErrores[] = "Error documento " . number_format($numDocumento) . ", " . ucwords(strtolower($arrRegistro['campo'])) . ", campo Correcto: No puede dejar este campo vacio";
                                        }
                                        break;
                                    case "primer apellido":
                                        if (trim($arrRegistro['correcto']) == "") {
                                            $this->arrErrores[] = "Error documento " . number_format($numDocumento) . ", " . ucwords(strtolower($arrRegistro['campo'])) . ", campo Correcto: No puede dejar este campo vacio";
                                        }
                                        break;
                                    case "tipo de solucion":
                                        $seqSolucion = obtenerSecuencial(
                                                $arrRegistro['incorrecto'], "T_FRM_SOLUCION", "txtSolucion", "seqSolucion", "AND seqModalidad = " . $objFormulario->seqModalidad
                                        );
                                        if ($seqSolucion != $objFormulario->seqSolucion) {
                                            $txtSolucion = obtenerNombres("T_FRM_SOLUCION", "seqSolucion", $objFormulario->seqSolucion);
                                            $this->arrErrores[] = "Error documento " . number_format($numDocumento) . ", " . ucwords(strtolower($arrRegistro['campo'])) . ", campo Incorrecto (" . $arrRegistro['incorrecto'] . "): No coindice con el valor actual del formulario (" . $txtSolucion . ")";
                                        }
                                        $seqSolucion = obtenerSecuencial(
                                                $arrRegistro['correcto'], "T_FRM_SOLUCION", "txtSolucion", "seqSolucion", "AND seqModalidad = " . $objFormulario->seqModalidad
                                        );
                                        if ($seqSolucion == 0) {
                                            $txtModalidad = obtenerNombres("T_FRM_MODALIDAD", "seqModalidad", $objFormulario->seqModalidad);
                                            $this->arrErrores[] = "Error documento " . number_format($numDocumento) . ", " . ucwords(strtolower($arrRegistro['campo'])) . ", campo Correcto (" . $arrRegistro['correcto'] . "): No puede ser usado en la modalidad " . $txtModalidad;
                                        }
                                        break;
                                    case "matricula inmobiliaria":
                                        if (trim($arrRegistro['correcto']) == "") {
                                            $this->arrErrores[] = "Error documento " . number_format($numDocumento) . ", " . ucwords(strtolower($arrRegistro['campo'])) . ", campo Correcto: No puede dejar este campo vacio";
                                        }
                                        break;
                                    case "proyecto":
                                        if (trim($arrRegistro['correcto']) == "") {
                                            $this->arrErrores[] = "Error documento " . number_format($numDocumento) . ", " . ucwords(strtolower($arrRegistro['campo'])) . ", campo Correcto: No puede dejar este campo vacio";
                                        }
                                        break;
                                    case "unidad habitacional":
                                        if (trim($arrRegistro['correcto']) == "") {
                                            $this->arrErrores[] = "Error documento " . number_format($numDocumento) . ", " . ucwords(strtolower($arrRegistro['campo'])) . ", campo Correcto: No puede dejar este campo vacio";
                                        }
                                        break;
                                    case "valor donacion":
                                        if (trim($arrRegistro['correcto']) == "") {
                                            $this->arrErrores[] = "Error documento " . number_format($numDocumento) . ", " . ucwords(strtolower($arrRegistro['campo'])) . ", campo Correcto: No puede dejar este campo vacio";
                                        }
                                        break;
                                    case "soporte donacion":
                                        if (trim($arrRegistro['correcto']) == "") {
                                            $this->arrErrores[] = "Error documento " . number_format($numDocumento) . ", " . ucwords(strtolower($arrRegistro['campo'])) . ", campo Correcto: No puede dejar este campo vacio";
                                        }
                                        break;
                                    case "entidad donacion":
                                        if (trim($arrRegistro['correcto']) == "") {
                                            $this->arrErrores[] = "Error documento " . number_format($numDocumento) . ", " . ucwords(strtolower($arrRegistro['campo'])) . ", campo Correcto: No puede dejar este campo vacio";
                                        }
                                        break;
                                    case "valor del subsidio":
                                        if ($objFormulario->valAspiraSubsidio != $arrRegistro['incorrecto']) {
                                            $this->arrErrores[] = "Error documento " . number_format($numDocumento) . ", " . ucwords(strtolower($arrRegistro['campo'])) . ", campo Incorrecto (" . number_format($arrRegistro['incorrecto']) . "): No coindice con el valor actual del formulario (" . number_format($objFormulario->valAspiraSubsidio) . ")";
                                        }
                                        $arrMaximo = obtenerDatosTabla(
                                                "T_FRM_VALOR_SUBSIDIO", array("seqSolucion", "valSubsidio"), "seqSolucion", "seqSolucion = " . $objFormulario->seqSolucion . " AND seqModalidad = " . $objFormulario->seqModalidad
                                        );
                                        if ($arrRegistro['correcto'] > $arrMaximo[$objFormulario->seqSolucion]) {
                                            $this->arrErrores[] = "Error documento " . number_format($numDocumento) . ", " . ucwords(strtolower($arrRegistro['campo'])) . ", campo Correcto (" . number_format($arrRegistro['correcto']) . "): No puede superar el valor maximo permitido (" . number_format($arrMaximo[$objFormulario->seqSolucion]) . ")";
                                        }
                                        break;
                                    case "documento":
                                        if ($numDocumento != $arrRegistro['incorrecto']) {
                                            $this->arrErrores[] = "Error documento " . number_format($numDocumento) . ", " . ucwords(strtolower($arrRegistro['campo'])) . ", campo Incorrecto (" . number_format($arrRegistro['incorrecto']) . "): No coincide con el documento de postulante principal";
                                        }
                                        if (intval($arrRegistro['correcto']) == 0) {
                                            $this->arrErrores[] = "Error documento " . number_format($numDocumento) . ", " . ucwords(strtolower($arrRegistro['campo'])) . ", campo Correcto (" . $arrRegistro['correcto'] . "): Debe ser un valor numérico válido y no puede ser cero";
                                        }
                                        break;
                                }
                            }
                        }

                        if ($objFormulario->bolCerrado == 0) {
                            $this->arrErrores[] = "El hogar del documento " . number_format($numDocumento) . " no puede ser asignado, el Formulario se encuentra Abierto ";
                        }
                        break;
                    case 3: // inhabilitados
                        // 42. Primera verificacion pendente (postulacion individual)
                        // 48. Segunda verificacion pendiente (casa en mano)
                        // 50. Primera verificacion pendiente (postulacion individual)
                        /* $arrEstadosPermitidos = array(7, 42, 45, 48, 50, 56, 54);
                          if (!in_array($objFormulario->seqEstadoProceso, $arrEstadosPermitidos)) {
                          $txtEstado = obtenerCampo("T_FRM_ESTADO_PROCESO", $objFormulario->seqEstadoProceso, "txtEstadoProceso", "seqEstadoProceso");
                          $this->arrErrores[] = "El hogar del formulario " . number_format($numDocumento) . " no puede ser cargado, el estado del proceso actual es " . $txtEstado;
                          } */

                        foreach ($arrFormularios['formularios'] as $seqFormulario => $objFormulario) {
                            $arrDocumentosHogar = array();
                            foreach ($objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                                $arrDocumentosHogar[] = mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento);
                            }
                            foreach ($arrFormularios['datos'][$seqFormulario] as $numDocumento => $arrRegistro) {
                                if (!in_array($numDocumento, $arrDocumentosHogar)) {
                                    $this->arrErrores[] = "Error en formulario " . number_format($seqFormulario) . ": El documento " .
                                            number_format($numDocumento) . " no pertenece a este hogar";
                                }
                            }
                        }
                        /* if($objFormulario->bolCerrado == 0 ){                                
                          $this->arrErrores[] = "El hogar del documento " . number_format($numDocumento) . " no puede ser asignado, el Formulario se encuentra Abierto ";
                          } */
                        break;
                    case 4: // Recursos de reposicion
                        $arrEstados = estadosProceso();
                        $arrIdentificadoresEstado = array_keys($arrEstados);
                        if (!in_array($arrFormularios['datos'][$numDocumento]['estado'], $arrIdentificadoresEstado)) {
                            $this->arrErrores[] = "Error documento " . number_format($numDocumento) . ": Estado del proceso " . $arrFormularios['datos'][$numDocumento]['estado'] . " es desconocido";
                        }
                        if ($objFormulario->bolCerrado == 0) {
                            if ($objFormulario->seqEstadoProceso != 39) {
                                $this->arrErrores[] = "El hogar del documento " . number_format($numDocumento) . " no puede ser asignado, el Formulario se encuentra Abierto ";
                            }
                        }
                        break;
                    case 5: // No asignados
                        // 16. Acto adminsitrativo pendiente (etapa de asignacion)
                        // 41. Primera verificacion aprobada (etapa de inscripcion)
                        $arrEstadosPermitidos = array(16, 41);
                        if (!in_array($objFormulario->seqEstadoProceso, $arrEstadosPermitidos)) {
                            $txtEstado = obtenerCampo("T_FRM_ESTADO_PROCESO", $objFormulario->seqEstadoProceso, "txtEstadoProceso", "seqEstadoProceso");
                            $this->arrErrores[] = "El hogar del documento " . number_format($numDocumento) . " no puede ser asignado, el estado del proceso actual es " . $txtEstado;
                        }
                        if ($objFormulario->bolCerrado == 0) {
                            $this->arrErrores[] = "El hogar del documento " . number_format($numDocumento) . " no puede ser asignado, el Formulario se encuentra Abierto ";
                        }
                        break;
                    case 6: // renuncias
                        $arrEtapasPermitidas = array(4, 5);
                        $seqEtapa = obtenerCampo("T_FRM_ESTADO_PROCESO", $objFormulario->seqEstadoProceso, "seqEtapa", "seqEstadoProceso");
                        $txtEtapa = obtenerNombres("T_FRM_ETAPA", "seqEtapa", $seqEtapa);
                        if (!in_array($seqEtapa, $arrEtapasPermitidas)) {
                            $this->arrErrores[] = "El hogar del documento " . number_format($numDocumento) . " no puede revocar, la etapa actual es " . $txtEtapa;
                        }
                        if ($objFormulario->bolCerrado == 0) {
                            $this->arrErrores[] = "El hogar del documento " . number_format($numDocumento) . " no puede ser asignado, el Formulario se encuentra Abierto ";
                        }
                        break;
                    case 9: // perdidas
                        $arrEtapasPermitidas = array(4, 5); // modificar
                        $seqEtapa = obtenerCampo("T_FRM_ESTADO_PROCESO", $objFormulario->seqEstadoProceso, "seqEtapa", "seqEstadoProceso");
                        $txtEtapa = obtenerNombres("T_FRM_ETAPA", "seqEtapa", $seqEtapa);
                        if (!in_array($seqEtapa, $arrEtapasPermitidas)) {
                            $this->arrErrores[] = "El hogar del documento " . number_format($numDocumento) . " no puede llevar a cabo la acción, la etapa actual es " . $txtEtapa;
                        }
                        if ($objFormulario->bolCerrado == 0) {
                            $this->arrErrores[] = "El hogar del documento " . number_format($numDocumento) . " no puede ser asignado, el Formulario se encuentra Abierto ";
                        }
                        break;
                    case 10: // revocatorias
                        $arrEtapasPermitidas = array(4, 5); // modificar
                        $seqEtapa = obtenerCampo("T_FRM_ESTADO_PROCESO", $objFormulario->seqEstadoProceso, "seqEtapa", "seqEstadoProceso");
                        $txtEtapa = obtenerNombres("T_FRM_ETAPA", "seqEtapa", $seqEtapa);
                        if (!in_array($seqEtapa, $arrEtapasPermitidas)) {
                            $this->arrErrores[] = "El hogar del documento " . number_format($numDocumento) . " no puede revocar, la etapa actual es " . $txtEtapa;
                        }
                        if ($objFormulario->bolCerrado == 0) {
                            $this->arrErrores[] = "El hogar del documento " . number_format($numDocumento) . " no puede ser asignado, el Formulario se encuentra Abierto ";
                        }
                        break;
                    case 11: // Exclusion
                        /* $arrEstados = estadosProceso();
                          $arrIdentificadoresEstado = array_keys($arrEstados);
                          if (!in_array($arrFormularios['datos'][$numDocumento]['estado'], $arrIdentificadoresEstado)) {
                          $this->arrErrores[] = "Error documento " . number_format($numDocumento) . ": Estado del proceso " . $arrFormularios['datos'][$numDocumento]['estado'] . " es desconocido";
                          } */
                        //if($objFormulario->bolCerrado == 0){
                        if ($objFormulario->seqEstadoProceso != 15) {
                            $this->arrErrores[] = "El hogar del documento " . number_format($numDocumento) . " no puede gestionarse, el estado debe ser Asignación - Asignado ";
                        }
                        //}
                        break;
                }
            }
        }
    }

}

// fin clase TipoActoAdmnistrativo

/**
 * CLASE PARA LOS ACTOS ADMINISTRATIVOS
 * OBTIENE LOS VALORES DE LAS CARACTERISTICAS 
 * DEFINIDAS EN EL TIPO DE ACTO Y LOS GIROS REALIZADOS
 * @author Bernardo Zerda Rodriguez
 * @version 2.0 Diciembre de 20103
 * */
Class ActoAdministrativo {

    public $seqTipoActo;
    public $numActo;
    public $fchActo;
    public $valTotalGiros;
    public $arrCaracteristicas;
    public $arrMasInformacion;
    public $arrHogares;
    public $arrErrores;

    /**
     * CONSTRUCTOR
     */
    function ActoAdministrativo() {
        $this->seqTipoActo = null;
        $this->numActo = null;
        $this->fchActo = null;
        $this->valTotalGiros = null;
        $this->arrCaracteristicas = null;
        $this->arrMasInformacion = null;
        $this->arrHogares = null;
        $this->arrErrores = null;
    }

    /**
     * CARGA LA INFORMACION DE UN ACTO ADMINISTRATIVO
     * @global handler $aptBd
     * @param int $numActo
     * @param date $fchActo
     * @return \ActoAdministrativo
     */
    public function cargarActoAdministrativo($numActo = 0, $fchActo = null, $arrDocumentos = array()) {
        global $aptBd;

        $arrActosAdministrativos = array();

        $arrFormularios = array();
        foreach ($arrDocumentos as $numDocumento) {
            $seqFormulario = $this->documento2formulario($numDocumento);
            $arrFormularios[] = $seqFormulario;
        }


        try {

            $txtCondicion = ( $numActo != 0 ) ? "AND aad.numActo = " . $numActo . " " : "";
            $txtCondicion .= ( esFechaValida($fchActo) ) ? "AND aad.fchActo = '" . $fchActo . "' " : "";
            $txtCondicion .= (!empty($arrDocumentos) ) ? "AND fac.seqFormulario IN (" . implode(",", $arrFormularios) . ")" : "";

            $sql = "
                   SELECT DISTINCT
                      aad.seqTipoActo,
                      aad.numActo,
                      aad.fchActo,
                      aad.seqCaracteristica,
                      aad.txtValorCaracteristica";
            if (!empty($arrDocumentos)) {
                $sql .= ", fac.seqFormularioActo,
							fac.seqEstadoProceso";
            }
            $sql .= " FROM T_AAD_ACTO_ADMINISTRATIVO aad
                   LEFT JOIN T_AAD_HOGARES_VINCULADOS hvi ON aad.fchActo = hvi.fchActo and aad.numActo = hvi.numActo
                   LEFT JOIN T_AAD_FORMULARIO_ACTO fac ON hvi.seqFormularioActo = fac.seqFormularioActo
                   LEFT JOIN T_AAD_HOGAR_ACTO hac ON fac.seqFormularioActo = hac.seqFormularioActo
                   LEFT JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                   WHERE ( hac.seqParentesco = 1 OR hac.seqParentesco IS NULL )
                      $txtCondicion
                   ORDER BY aad.seqTipoActo , aad.fchActo, aad.numActo
                ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                if (!empty($arrDocumentos)) {
                    $seqEstadoForm = $this->estadosProcesoActo($objRes->fields['seqEstadoProceso']);
                }
                $seqCaracteristica = $objRes->fields['seqCaracteristica'];
                $txtClave = $objRes->fields['numActo'] . strtotime($objRes->fields['fchActo']);

                if (!isset($arrActosAdministrativos[$txtClave])) {
                    $objActoAdministrativo = new ActoAdministrativo();
                }

                $objActoAdministrativo->seqTipoActo = $objRes->fields['seqTipoActo'];
                $objActoAdministrativo->numActo = $objRes->fields['numActo'];
                $objActoAdministrativo->fchActo = $objRes->fields['fchActo'];
                $objActoAdministrativo->arrCaracteristicas[$seqCaracteristica] = trim($objRes->fields['txtValorCaracteristica']);
                if (!empty($arrDocumentos)) {
                    $objActoAdministrativo->seqformActo = $objRes->fields['seqFormularioActo'];
                    $objActoAdministrativo->seqEstadoProceso = $seqEstadoForm[$objRes->fields['seqEstadoProceso']];
                } else {
                    $objActoAdministrativo->seqformActo = 0;
                    $objActoAdministrativo->seqEstadoProceso = 0;
                }
                $arrActosAdministrativos[$txtClave] = $objActoAdministrativo;

                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se pudo cargar el acto admnistrativo";
        }

        return $arrActosAdministrativos;
    }

    /**
     * OBTIENE LA INFORMACION DE GIROS DEL 
     * ACTO ADMINISTRATIVO CARGADO PREVIAMENTE
     * CUANDO ES UN ACTO ADMINISTRATIVO DE ASIGNACION
     * @global handler $aptBd
     * @param int $seqFormulario
     */
    public function obtenerGiros($seqFormulario = 0) {
        global $aptBd;

        try {

            $txtCondicion = ( intval($seqFormulario) != 0 ) ? "AND fac.seqFormulario = " . $seqFormulario : "";

            $sql = "
                   SELECT 
                      fac.seqFormularioActo,
                      gir.seqGiro,
                      CONCAT( eta.txtEtapa , ' - ' , epr.txtEstadoProceso ) AS txtEstadoProceso,
                      fac.bolDesplazado,
                      fac.valAspiraSubsidio,
                      tdo.txtTipoDocumento,
                      cac.numDocumento,
                      UCWORDS( CONCAT(
                        TRIM( cac.txtNombre1 ),
                        ' ',
                        IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                        TRIM( cac.txtApellido1 ),
                        ' ',
                        TRIM( cac.txtApellido2 )
                      ) ) AS txtNombre,
                      gir.numProyectoInversion,
                      gir.fchCreacion,
                      gir.fchActualizacion,
                      gir.numRegistroPresupuestal1,
                      gir.fchRegistroPresupuestal1,
                      gir.numRegistroPresupuestal2,
                      gir.fchRegistroPresupuestal2,
                      gir.numRadiacion,
                      gir.fchRadicacion,
                      gir.valSolicitado,
                      gir.numOrden,
                      gir.fchOrden,
                      gir.valOrden,
                      gir.txtNombreBeneficiarioGiro,
                      gir.numDocumentoBeneficiarioGiro,
                      gir.txtDireccionBeneficiarioGiro,
                      gir.numTelefonoGiro,
                      gir.numCuentaGiro,
                      UCWORDS( gir.txtTipoCuentaGiro ) AS txtTipoCuentaGiro,
                      gir.seqBancoGiro,
                      UCWORDS( ban.txtBanco ) AS txtBanco,
                      gir.bolGiroTercero,
                      gir.txtGiroTercero,
                      gir.txtCorreoGiro
                    FROM T_AAD_HOGARES_VINCULADOS hvi
                    INNER JOIN T_AAD_FORMULARIO_ACTO fac ON fac.seqFormularioActo = hvi.seqFormularioActo
                    INNER JOIN T_AAD_HOGAR_ACTO hac ON fac.seqFormularioActo = hac.seqFormularioActo
                    INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                    INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                    LEFT JOIN T_FRM_FORMULARIO frm ON fac.seqFormulario = frm.seqFormulario
                    LEFT JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
                    LEFT JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
                    LEFT JOIN T_AAD_GIRO gir ON gir.seqFormularioActo = fac.seqFormularioActo
                    LEFT JOIN T_FRM_BANCO ban ON gir.seqBancoGiro = ban.seqBanco
                    WHERE hac.seqParentesco = 1
                    AND hvi.numActo = " . $this->numActo . "
                    AND hvi.fchActo = '" . $this->fchActo . "'
                    $txtCondicion
                    ORDER BY cac.numDocumento
                ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {

                $seqFormularioActo = $objRes->fields['seqFormularioActo'];
                $seqGiro = intval($objRes->fields['seqGiro']);

                $this->arrMasInformacion[$seqFormularioActo]['valTotalGiros'] += $objRes->fields['valOrden'];
                $this->valTotalGiros += $objRes->fields['valOrden'];

                $this->arrMasInformacion[$seqFormularioActo]['txtEstadoProceso'] = $objRes->fields['txtEstadoProceso'];
                $this->arrMasInformacion[$seqFormularioActo]['bolDesplazado'] = $objRes->fields['bolDesplazado'];
                $this->arrMasInformacion[$seqFormularioActo]['valAspiraSubsidio'] = $objRes->fields['valAspiraSubsidio'];
                $this->arrMasInformacion[$seqFormularioActo]['txtTipoDocumento'] = $objRes->fields['txtTipoDocumento'];
                $this->arrMasInformacion[$seqFormularioActo]['numDocumento'] = $objRes->fields['numDocumento'];
                $this->arrMasInformacion[$seqFormularioActo]['txtNombre'] = $objRes->fields['txtNombre'];

                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['numProyectoInversion'] = $objRes->fields['numProyectoInversion'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['fchCreacion'] = $objRes->fields['fchCreacion'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['fchActualizacion'] = $objRes->fields['fchActualizacion'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['numRegistroPresupuestal1'] = $objRes->fields['numRegistroPresupuestal1'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['fchRegistroPresupuestal1'] = $objRes->fields['fchRegistroPresupuestal1'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['numRegistroPresupuestal2'] = $objRes->fields['numRegistroPresupuestal2'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['fchRegistroPresupuestal2'] = $objRes->fields['fchRegistroPresupuestal2'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['numRadicacion'] = $objRes->fields['numRadicacion'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['fchRadicacion'] = $objRes->fields['fchRadicacion'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['valSolicitado'] = $objRes->fields['valSolicitado'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['numOrden'] = $objRes->fields['numOrden'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['fchOrden'] = $objRes->fields['fchOrden'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['valOrden'] = $objRes->fields['valOrden'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['txtNombreBeneficiarioGiro'] = $objRes->fields['txtNombreBeneficiarioGiro'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['numDocumentoBeneficiarioGiro'] = $objRes->fields['numDocumentoBeneficiarioGiro'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['txtDireccionBeneficiarioGiro'] = $objRes->fields['txtDireccionBeneficiarioGiro'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['numTelefonoGiro'] = $objRes->fields['numTelefonoGiro'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['numCuentaGiro'] = $objRes->fields['numCuentaGiro'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['txtTipoCuentaGiro'] = $objRes->fields['txtTipoCuentaGiro'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['seqBancoGiro'] = $objRes->fields['seqBancoGiro'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['txtBanco'] = $objRes->fields['txtBanco'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['bolGiroTercero'] = $objRes->fields['bolGiroTercero'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['txtGiroTercero'] = $objRes->fields['txtGiroTercero'];
                $this->arrMasInformacion[$seqFormularioActo]['arrMasInformacion'][$seqGiro]['txtCorreoGiro'] = $objRes->fields['txtCorreoGiro'];

                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se han podido obtener los giros realizados al acto administrativo " . $this->numActo . " del " . $this->fchActo;
        }
    }

    /**
     * OBTIENE LA INFORMACION DE LAS MODIFICACIONES
     * PARA ACTOS ADMINISTRATIVOS DE MODIFICACION
     * @global handler $aptBd
     * @param int $seqFormulario
     */
    public function obtenerModificaciones($seqFormulario = 0) {
        global $aptBd;

        try {
            $txtCondicion = ( intval($seqFormulario) != 0 ) ? "AND fac.seqFormulario = " . $seqFormulario : "";
            $sql = "
                   SELECT
                     tdo.txtTipoDocumento,
                     cac.numDocumento,
                     UPPER( 
                       CONCAT(
                         TRIM( cac.txtNombre1 ),
                         ' ',
                         IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                         TRIM( cac.txtApellido1 ),
                         ' ',
                         TRIM( cac.txtApellido2 )
                       ) 
                     ) AS txtNombre,
                     hac.txtCampo,
                     hac.txtIncorrecto,
                     hac.txtCorrecto
                   FROM T_AAD_HOGAR_ACTO hac
                   INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                   INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                   WHERE hvi.numActo = " . $this->numActo . "
                   AND hvi.fchActo = '" . $this->fchActo . "'
                   $txtCondicion
                   ORDER BY cac.numDocumento
                ";
            //echo $sql;
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                if (trim($objRes->fields['txtCampo']) != "") {
                    $numDocumento = $objRes->fields['numDocumento'];
                    $this->arrMasInformacion[$numDocumento]['txtNombre'] = $objRes->fields['txtNombre'];
                    $this->arrMasInformacion[$numDocumento]['txtTipoDocumento'] = $objRes->fields['txtTipoDocumento'];
                    $numCuenta = count($this->arrMasInformacion[$numDocumento]['arrModificaciones']);
                    $this->arrMasInformacion[$numDocumento]['arrModificaciones'][$numCuenta]['txtCampo'] = $objRes->fields['txtCampo'];
                    $this->arrMasInformacion[$numDocumento]['arrModificaciones'][$numCuenta]['txtIncorrecto'] = $objRes->fields['txtIncorrecto'];
                    $this->arrMasInformacion[$numDocumento]['arrModificaciones'][$numCuenta]['txtCorrecto'] = $objRes->fields['txtCorrecto'];
                }
                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se ha podido obtener el listado de las modificaciones del acto adminsitrativo " . $this->numActo . " del " . $this->fchActo;
        }
    }

    /**
     * OBTIENE LA INFORMACION DE LAS INHABILIDADES
     * PARA EL ACTO ADMINISTRATIVO CARGADO PREVIAMENTE
     * @global handler $aptBd
     * @param type $seqFormulario
     */
    public function obtenerInhabilidades($seqFormulario = 0) {
        global $aptBd;

        try {
            if (intval($seqFormulario) != 0) {
                $seqFormularioActo = $this->obtenerSecuencial($this->numActo, $this->fchActo, $seqFormulario);
                $txtCondicion = "AND fac.seqFormularioActo = " . $seqFormularioActo;
            }
            $sql = "
                   SELECT
                     fac.seqFormularioActo,
                     tdo.txtTipoDocumento,
                     cac.numDocumento,
                     hac.seqParentesco,
                     UPPER( 
                       CONCAT(
                         TRIM( cac.txtNombre1 ),
                         ' ',
                         IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                         TRIM( cac.txtApellido1 ),
                         ' ',
                         TRIM( cac.txtApellido2 )
                       ) 
                     ) AS txtNombre,
                     hac.txtFuente,
                     hac.txtInhabilidad,
                     hac.txtCausa
                   FROM T_AAD_HOGAR_ACTO hac
                   INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                   INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                   WHERE hvi.numActo = " . $this->numActo . "
                   AND hvi.fchActo = '" . $this->fchActo . "'
                   $txtCondicion
                   ORDER BY cac.numDocumento
                ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {

                $seqFormularioActo = $objRes->fields['seqFormularioActo'];
                $numDocumento = $objRes->fields['numDocumento'];

                if ($objRes->fields['seqParentesco'] == 1) {
                    $this->arrMasInformacion[$seqFormularioActo]['arrPrincipal']['numDocumento'] = $numDocumento;
                    $this->arrMasInformacion[$seqFormularioActo]['arrPrincipal']['txtTipoDocumento'] = $objRes->fields['txtTipoDocumento'];
                    $this->arrMasInformacion[$seqFormularioActo]['arrPrincipal']['txtNombre'] = $objRes->fields['txtNombre'];
                }

                $numCuenta = count($this->arrMasInformacion[$seqFormularioActo]['arrInhabilidades'][$numDocumento]);
                $this->arrMasInformacion[$seqFormularioActo]['arrInhabilidades'][$numDocumento]['txtNombre'] = $objRes->fields['txtNombre'];
                $this->arrMasInformacion[$seqFormularioActo]['arrInhabilidades'][$numDocumento]['txtTipoDocumento'] = $objRes->fields['txtTipoDocumento'];
                if ($objRes->fields['txtFuente'] != "") {
                    $this->arrMasInformacion[$seqFormularioActo]['arrInhabilidades'][$numDocumento]['arrListado'][$numCuenta]['txtFuente'] = $objRes->fields['txtFuente'];
                    $this->arrMasInformacion[$seqFormularioActo]['arrInhabilidades'][$numDocumento]['arrListado'][$numCuenta]['txtInhabilidad'] = $objRes->fields['txtInhabilidad'];
                    $this->arrMasInformacion[$seqFormularioActo]['arrInhabilidades'][$numDocumento]['arrListado'][$numCuenta]['txtCausa'] = $objRes->fields['txtCausa'];
                }

                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se ha podido obtener el listado de las modificaciones del acto adminsitrativo " . $this->numActo . " del " . $this->fchActo;
        }
    }

    /**
     * OBTIENE LA INFORMACION DE LOS RECURSOS DE REPOSICION
     * PARA EL ACTO ADMINISTRATIVO CARGADO PREVIAMENTE
     * @global handler $aptBd
     * @param int $seqFormulario
     */
    public function obtenerResultado($seqFormulario = 0) {
        global $aptBd;

        try {
            $txtCondicion = ( intval($seqFormulario) != 0 ) ? "AND fac.seqFormulario = " . $seqFormulario : "";
            $sql = "
                   SELECT
                      tdo.txtTipoDocumento,
                      cac.numDocumento,
                      par.txtParentesco,
                      UPPER( 
                        CONCAT(
                          TRIM( cac.txtNombre1 ),
                          ' ',
                          IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                          TRIM( cac.txtApellido1 ),
                          ' ',
                          TRIM( cac.txtApellido2 )
                        ) 
                      ) AS txtNombre,
                      hac.txtEstadoReposicion
                   FROM T_AAD_HOGAR_ACTO hac
                   INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                   INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                   INNER JOIN T_CIU_PARENTESCO par ON hac.seqParentesco = par.seqParentesco
                   WHERE hac.seqParentesco = 1
                   AND hvi.numActo = " . $this->numActo . "
                   AND hvi.fchActo = '" . $this->fchActo . "'
                   $txtCondicion
                   ORDER BY cac.numDocumento
                ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $numDocumento = $objRes->fields['numDocumento'];
                $this->arrMasInformacion[$numDocumento]['txtTipoDocumento'] = $objRes->fields['txtTipoDocumento'];
                $this->arrMasInformacion[$numDocumento]['txtNombre'] = $objRes->fields['txtNombre'];
                $this->arrMasInformacion[$numDocumento]['txtParentesco'] = $objRes->fields['txtParentesco'];
                $this->arrMasInformacion[$numDocumento]['txtEstadoReposicion'] = $objRes->fields['txtEstadoReposicion'];
                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se ha podido obtener el listado de las modificaciones del acto adminsitrativo " . $this->numActo . " del " . $this->fchActo;
        }
    }

    /**
     * OBTIENE LA INFORMACION DE LOS HOGARES NO ASIGNADOS
     * PARA EL ACTO ADMINISTRATIVO CARGADO PREVIAMENTE
     * @global handler $aptBd
     * @param int $numDocumento
     */
    public function obtenerNoAsignados($seqFormulario = 0) {
        global $aptBd;

        try {
            $txtCondicion = ( intval($seqFormulario) != 0 ) ? "AND fac.seqFormulario = " . $seqFormulario : "";
            $sql = "
                   SELECT
                     tdo.txtTipoDocumento,
                     cac.numDocumento,
                     UPPER( 
                       CONCAT(
                         TRIM( cac.txtNombre1 ),
                         ' ',
                         IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                         TRIM( cac.txtApellido1 ),
                         ' ',
                         TRIM( cac.txtApellido2 )
                       ) 
                     ) AS txtNombre
                   FROM T_AAD_HOGAR_ACTO hac
                   INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                   INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                   WHERE hac.seqParentesco = 1
                   AND hvi.numActo = " . $this->numActo . "
                   AND hvi.fchActo = '" . $this->fchActo . "'
                   $txtCondicion
                   ORDER BY cac.numDocumento
                ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {

                $numDocumento = $objRes->fields['numDocumento'];
                $this->arrMasInformacion[$numDocumento]['txtTipoDocumento'] = $objRes->fields['txtTipoDocumento'];
                $this->arrMasInformacion[$numDocumento]['txtNombre'] = $objRes->fields['txtNombre'];

                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se ha podido obtener el listado de las modificaciones del acto adminsitrativo " . $this->numActo . " del " . $this->fchActo;
        }
    }

    /**
     * OBTIENE LA INFORMACION DE LS HOGARES QUE HAN RENUNCIADO
     * PARA EL ACTO ADMINISTRATIVO CARGADO PREVIAMENTE
     * @global handler $aptBd
     * @param int $seqFormulario
     */
    public function obtenerRenuncias($seqFormulario = 0) {
        global $aptBd;

        try {
            $txtCondicion = ( intval($seqFormulario) != 0 ) ? "AND fac.seqFormulario = " . $seqFormulario : "";
            $sql = "
                   SELECT
                     tdo.txtTipoDocumento,
                     cac.numDocumento,
                     UPPER( 
                       CONCAT(
                         TRIM( cac.txtNombre1 ),
                         ' ',
                         IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                         TRIM( cac.txtApellido1 ),
                         ' ',
                         TRIM( cac.txtApellido2 )
                       ) 
                     ) AS txtNombre
                   FROM T_AAD_HOGAR_ACTO hac
                   INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                   INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                   WHERE hac.seqParentesco = 1
                   AND hvi.numActo = " . $this->numActo . "
                   AND hvi.fchActo = '" . $this->fchActo . "'
                   $txtCondicion
                   ORDER BY cac.numDocumento
                ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {

                $numDocumento = $objRes->fields['numDocumento'];
                $this->arrMasInformacion[$numDocumento]['txtTipoDocumento'] = $objRes->fields['txtTipoDocumento'];
                $this->arrMasInformacion[$numDocumento]['txtNombre'] = $objRes->fields['txtNombre'];

                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se ha podido obtener el listado de las modificaciones del acto adminsitrativo " . $this->numActo . " del " . $this->fchActo;
        }
    }

    /**
     * OBTIENE LA INFORMACION DE LOS HOGARES CON PERDIDA
     * PARA EL ACTO ADMINISTRATIVO CARGADO PREVIAMENTE
     * @global handler $aptBd
     * @param int $seqFormulario
     */
    public function obtenerPerdidas($seqFormulario = 0) {
        global $aptBd;

        try {
            $txtCondicion = ( intval($seqFormulario) != 0 ) ? "AND fac.seqFormulario = " . $seqFormulario : "";
            $sql = "
                   SELECT
                     tdo.txtTipoDocumento,
                     cac.numDocumento,
                     UPPER( 
                       CONCAT(
                         TRIM( cac.txtNombre1 ),
                         ' ',
                         IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                         TRIM( cac.txtApellido1 ),
                         ' ',
                         TRIM( cac.txtApellido2 )
                       ) 
                     ) AS txtNombre
                   FROM T_AAD_HOGAR_ACTO hac
                   INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                   INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                   WHERE hac.seqParentesco = 1
                   AND hvi.numActo = " . $this->numActo . "
                   AND hvi.fchActo = '" . $this->fchActo . "'
                   $txtCondicion
                   ORDER BY cac.numDocumento
                ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {

                $numDocumento = $objRes->fields['numDocumento'];
                $this->arrMasInformacion[$numDocumento]['txtTipoDocumento'] = $objRes->fields['txtTipoDocumento'];
                $this->arrMasInformacion[$numDocumento]['txtNombre'] = $objRes->fields['txtNombre'];

                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se ha podido obtener el listado de las modificaciones del acto administrativo " . $this->numActo . " del " . $this->fchActo;
        }
    }

    /**
     * OBTIENE LA INFORMACION DE LS HOGARES QUE HAN SIDO REVOCADOS
     * PARA EL ACTO ADMINISTRATIVO CARGADO PREVIAMENTE
     * @global handler $aptBd
     * @param int $seqFormulario
     */
    public function obtenerRevocatorias($seqFormulario = 0) {
        global $aptBd;

        try {
            $txtCondicion = ( intval($seqFormulario) != 0 ) ? "AND fac.seqFormulario = " . $seqFormulario : "";
            $sql = "
                   SELECT
                     tdo.txtTipoDocumento,
                     cac.numDocumento,
                     UPPER( 
                       CONCAT(
                         TRIM( cac.txtNombre1 ),
                         ' ',
                         IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                         TRIM( cac.txtApellido1 ),
                         ' ',
                         TRIM( cac.txtApellido2 )
                       ) 
                     ) AS txtNombre
                   FROM T_AAD_HOGAR_ACTO hac
                   INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                   INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                   WHERE hac.seqParentesco = 1
                   AND hvi.numActo = " . $this->numActo . "
                   AND hvi.fchActo = '" . $this->fchActo . "'
                   $txtCondicion
                   ORDER BY cac.numDocumento
                ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {

                $numDocumento = $objRes->fields['numDocumento'];
                $this->arrMasInformacion[$numDocumento]['txtTipoDocumento'] = $objRes->fields['txtTipoDocumento'];
                $this->arrMasInformacion[$numDocumento]['txtNombre'] = $objRes->fields['txtNombre'];

                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se ha podido obtener el listado de las modificaciones del acto administrativo " . $this->numActo . " del " . $this->fchActo;
        }
    }

    /**
     * OBTIENE LA INFORMACION DE NOTIFICACIONES A LOS ACTOS ADMINISTRATIVOS
     * PARA EL ACTO ADMINISTRATIVO CARGADO PREVIAMENTE
     * @global handler $aptBd
     * @param int $seqFormulario
     */
    public function obtenerNotificaciones($seqFormulario = 0) {
        global $aptBd;

        try {
            $txtCondicion = ( intval($seqFormulario) != 0 ) ? "AND fac.seqFormulario = " . $seqFormulario : "";
            $sql = "
                   SELECT
                     tdo.txtTipoDocumento,
                     cac.numDocumento,
                     UPPER( 
                       CONCAT(
                         TRIM( cac.txtNombre1 ),
                         ' ',
                         IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                         TRIM( cac.txtApellido1 ),
                         ' ',
                         TRIM( cac.txtApellido2 )
                       ) 
                     ) AS txtNombre,
                     hvi.numActoReferencia,
                     hvi.fchActoReferencia
                   FROM T_AAD_HOGAR_ACTO hac
                   INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                   INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                   WHERE hac.seqParentesco = 1
                   AND hvi.numActo = " . $this->numActo . "
                   AND hvi.fchActo = '" . $this->fchActo . "'
                   $txtCondicion
                   ORDER BY cac.numDocumento
                ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {

                $numDocumento = $objRes->fields['numDocumento'];
                $this->arrMasInformacion[$numDocumento]['tipo'] = $objRes->fields['txtTipoDocumento'];
                $this->arrMasInformacion[$numDocumento]['nombre'] = $objRes->fields['txtNombre'];
                $this->arrMasInformacion[$numDocumento]['numero'] = $objRes->fields['numActoReferencia'];
                $this->arrMasInformacion[$numDocumento]['fecha'] = $objRes->fields['fchActoReferencia'];

                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se ha podido obtener el listado de las modificaciones del acto adminsitrativo " . $this->numActo . " del " . $this->fchActo;
        }
    }

    /**
     * OBTIENE LA INFORMACION DE LAS INDEXACIONES REALIZADAS
     * PARA EL ACTO ADMINISTRATIVO CARGADO PREVIAMENTE
     * @global handler $aptBd
     * @param int $seqFormulario
     */
    public function obtenerIndexacion($seqFormulario = 0) {
        global $aptBd;

        try {
            $txtCondicion = ( intval($seqFormulario) != 0 ) ? "AND fac.seqFormulario = " . $seqFormulario : "";
            $sql = "
                   SELECT 
                      tdo.txtTipoDocumento,
                      cac.numDocumento,
                      UPPER( 
                        CONCAT(
                          TRIM( cac.txtNombre1 ),
                          ' ',
                          IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                          TRIM( cac.txtApellido1 ),
                          ' ',
                          TRIM( cac.txtApellido2 )
                        ) 
                      ) AS txtNombre,
                      hvi.numActoReferencia,
                      hvi.fchActoReferencia,
                      hac.valIndexacion,
                      fac.valAspiraSubsidio
                   FROM T_AAD_HOGAR_ACTO hac
                   INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                   INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                   WHERE hac.seqParentesco = 1
                   AND hvi.numActo = " . $this->numActo . "
                   AND hvi.fchActo = '" . $this->fchActo . "'
                   $txtCondicion
                   ORDER BY cac.numDocumento
                ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {

                $numDocumento = $objRes->fields['numDocumento'];
                $this->arrMasInformacion[$numDocumento]['txtNombre'] = $objRes->fields['txtNombre'];
                $this->arrMasInformacion[$numDocumento]['txtTipoDocumento'] = $objRes->fields['txtTipoDocumento'];
                $this->arrMasInformacion[$numDocumento]['numActoReferencia'] = $objRes->fields['numActoReferencia'];
                $this->arrMasInformacion[$numDocumento]['fchActoReferencia'] = $objRes->fields['fchActoReferencia'];
                $this->arrMasInformacion[$numDocumento]['valIndexado'] = $objRes->fields['valIndexacion'];
                $this->arrMasInformacion[$numDocumento]['valAspiraSubsidio'] = $objRes->fields['valAspiraSubsidio'];
                $this->arrMasInformacion[$numDocumento]['valTotal'] = ( $objRes->fields['valAspiraSubsidio'] + $objRes->fields['valIndexacion'] );

                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se ha podido obtener el listado de las modificaciones del acto adminsitrativo " . $this->numActo . " del " . $this->fchActo;
        }
    }

    /**
     * OBTIENE EL LISTADO DE PERSONAS QUE FORMAN EL HOGAR 
     * PARA EL ACTO ADMINISTRATIVO CARGADO PREVIAMENTE
     * @global handler $aptBd
     */
    public function obtenerHogares($numDocumento = 0) {
        global $aptBd;

        try {
            if (intval($numDocumento) != 0) {
                $seqFormularioActo = $this->obtenerSecuencial($this->numActo, $this->fchActo, $numDocumento);
                $txtCondicion = "AND fac.seqFormularioActo = " . $seqFormularioActo;
            }
            $sql = "
                   SELECT 
                      fac.seqFormularioActo,
                      moa.txtModalidad,
                      sol.txtSolucion,
                      IF( fac.bolDesplazado <> 0 , 'Si','No' ) AS bolDesplazado,
                      fac.valAspiraSubsidio,
					  fac.txtMatriculaInmobiliaria,
                      tdo.txtTipoDocumento,
                      cac.numDocumento,
                      UPPER( CONCAT(
                        TRIM( cac.txtNombre1 ),
                        ' ',
                        IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                        TRIM( cac.txtApellido1 ),
                        ' ',
                        TRIM( cac.txtApellido2 )
                      ) ) AS txtNombre,
                      hac.seqParentesco,
                      par.txtParentesco,
                      etn.txtEtnia,
                      ces1.txtCondicionEspecial AS txtCondicionEspecial,
                      ces2.txtCondicionEspecial AS txtCondicionEspecial2,
                      ces3.txtCondicionEspecial AS txtCondicionEspecial3,
                      sex.txtSexo,
                      eci.txtEstadoCivil,
                      cac.valIngresos,
                      cac.fchNacimiento,
                      glg.txtGrupoLgtbi,
                      tvi.txtTipoVictima
                   FROM T_AAD_HOGARES_VINCULADOS hvi
                   INNER JOIN T_AAD_FORMULARIO_ACTO fac ON fac.seqFormularioActo = hvi.seqFormularioActo
                   INNER JOIN T_AAD_HOGAR_ACTO hac ON fac.seqFormularioActo = hac.seqFormularioActo
                   INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                   INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                   INNER JOIN T_FRM_MODALIDAD moa ON fac.seqModalidad = moa.seqModalidad
                   INNER JOIN T_FRM_SOLUCION sol ON fac.seqSolucion = sol.seqSolucion AND fac.seqModalidad = moa.seqModalidad
                   INNER JOIN T_CIU_PARENTESCO par ON hac.seqParentesco = par.seqParentesco
                   INNER JOIN T_CIU_ETNIA etn ON cac.seqEtnia = etn.seqEtnia
                   INNER JOIN T_CIU_CONDICION_ESPECIAL ces1 ON cac.seqCondicionEspecial  = ces1.seqCondicionEspecial
                   INNER JOIN T_CIU_CONDICION_ESPECIAL ces2 ON cac.seqCondicionEspecial2 = ces2.seqCondicionEspecial
                   INNER JOIN T_CIU_CONDICION_ESPECIAL ces3 ON cac.seqCondicionEspecial3 = ces3.seqCondicionEspecial
                   INNER JOIN T_CIU_SEXO sex ON cac.seqSexo = sex.seqSexo
                   INNER JOIN T_CIU_ESTADO_CIVIL eci ON cac.seqEstadoCivil = eci.seqEstadoCivil
                   LEFT JOIN T_FRM_GRUPO_LGTBI glg ON cac.seqGrupoLgtbi = glg.seqGrupoLgtbi
                   LEFT JOIN T_FRM_TIPOVICTIMA tvi ON cac.seqTipoVictima = tvi.seqTipoVictima
                   WHERE hvi.numActo = " . $this->numActo . "
                   AND hvi.fchActo = '" . $this->fchActo . "'
                   $txtCondicion
                   ORDER BY fac.seqFormularioActo
                ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {

                $seqFormularioActo = $objRes->fields['seqFormularioActo'];
                $numDocumento = $objRes->fields['numDocumento'];

                $this->arrHogares[$seqFormularioActo]['txtModalidad'] = $objRes->fields['txtModalidad'];
                $this->arrHogares[$seqFormularioActo]['txtSolucion'] = $objRes->fields['txtSolucion'];
                $this->arrHogares[$seqFormularioActo]['bolDesplazado'] = $objRes->fields['bolDesplazado'];
                $this->arrHogares[$seqFormularioActo]['valAspiraSubsidio'] = $objRes->fields['valAspiraSubsidio'];
                $this->arrHogares[$seqFormularioActo]['txtMatriculaInmobiliaria'] = $objRes->fields['txtMatriculaInmobiliaria'];

                $this->arrHogares[$seqFormularioActo]['arrHogar'][$numDocumento]['txtTipoDocumento'] = $objRes->fields['txtTipoDocumento'];
                $this->arrHogares[$seqFormularioActo]['arrHogar'][$numDocumento]['numDocumento'] = $objRes->fields['numDocumento'];
                $this->arrHogares[$seqFormularioActo]['arrHogar'][$numDocumento]['txtNombre'] = $objRes->fields['txtNombre'];
                $this->arrHogares[$seqFormularioActo]['arrHogar'][$numDocumento]['seqParentesco'] = $objRes->fields['seqParentesco'];
                $this->arrHogares[$seqFormularioActo]['arrHogar'][$numDocumento]['txtParentesco'] = $objRes->fields['txtParentesco'];
                $this->arrHogares[$seqFormularioActo]['arrHogar'][$numDocumento]['txtEtnia'] = $objRes->fields['txtEtnia'];
                $this->arrHogares[$seqFormularioActo]['arrHogar'][$numDocumento]['txtCondicionEspecial'] = $objRes->fields['txtCondicionEspecial'];
                $this->arrHogares[$seqFormularioActo]['arrHogar'][$numDocumento]['txtCondicionEspecial2'] = $objRes->fields['txtCondicionEspecial2'];
                $this->arrHogares[$seqFormularioActo]['arrHogar'][$numDocumento]['txtCondicionEspecial3'] = $objRes->fields['txtCondicionEspecial3'];
                $this->arrHogares[$seqFormularioActo]['arrHogar'][$numDocumento]['txtSexo'] = $objRes->fields['txtSexo'];
                $this->arrHogares[$seqFormularioActo]['arrHogar'][$numDocumento]['txtEstadoCivil'] = $objRes->fields['txtEstadoCivil'];
                $this->arrHogares[$seqFormularioActo]['arrHogar'][$numDocumento]['valIngresos'] = $objRes->fields['valIngresos'];
                $this->arrHogares[$seqFormularioActo]['arrHogar'][$numDocumento]['fchNacimiento'] = $objRes->fields['fchNacimiento'];
                $this->arrHogares[$seqFormularioActo]['arrHogar'][$numDocumento]['txtGrupoLgtbi'] = $objRes->fields['txtGrupoLgtbi'];
                $this->arrHogares[$seqFormularioActo]['arrHogar'][$numDocumento]['txtTipoVictima'] = $objRes->fields['txtTipoVictima'];

                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se pudo obtener el listado de hogares asociados a la resolucion " . $this->numActo . " del " . $this->fchActo;
        }
    }

    /**
     * SALVA LOS DATOS DEL ACTO ADMINISTRATIVO EN LA BASE DE DATOS
     * Y VINCULA LOS HOGARES RELACIONADOS EN EL ARCHIVO
     * @global handler $aptBd
     * @param ARRAY $arrActo
     * @param ARRAY $arrArchivo
     */
    public function salvarActo($arrActo, $arrArchivo) {
        global $aptBd;

        $arrEstados = estadosProceso();

        // Salva el acto administrativo
        foreach ($arrActo['caracteristicas'] as $seqCaracteristica => $txtValor) {
            try {
                $txtValorCaracteristica = ( trim($txtValor) == "" ) ? "NULL" : "'" . $txtValor . "'";
                $sql = "
                      INSERT INTO T_AAD_ACTO_ADMINISTRATIVO (
                         seqTipoActo,
                         numActo,
                         fchActo,
                         seqCaracteristica,
                         txtValorCaracteristica
                      ) VALUES (
                         " . $arrActo['seqTipoActo'] . ",
                         " . $arrActo['numActo'] . ",
                         '" . $arrActo['fchActo'] . "',
                         " . $seqCaracteristica . ",
                         $txtValorCaracteristica
                      )
                   ";
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $this->arrErrores[] = $objError->getMessage();
            }
        }

        if (empty($this->arrErrores)) {

            // Carga la informacion de los hogares contenidos en el archivo
            unset($arrArchivo[0]); // Quitar la columna de titulos
            foreach ($arrArchivo as $numLinea => $arrLinea) {
                $numDocumento = $arrLinea[0];
                if (!isset($arrFormularios[$numDocumento])) {
                    if ($arrActo['seqTipoActo'] != 3) {
                        $claCiudadano = new Ciudadano();
                        $seqFormulario = $claCiudadano->formularioVinculado($numDocumento);
                    } else {
                        $seqFormulario = $numDocumento;
                    }
                    $claFormulario = new FormularioSubsidios();
                    $claFormulario->cargarFormulario($seqFormulario);
                    $claFormulario->seqFormulario = $seqFormulario;
                    $claFormulario->fchIngresoRegistro = date("Y-m-d H:i:s");
                    $arrFormularios['formularios'][$numDocumento] = $claFormulario;
                }

                switch ($arrActo['seqTipoActo']) {
                    case 2: // Modificatorias
                        // Asigna al arreglo los valores que recibe del archivo (JOP)
                        $numRegistro = count($arrFormularios['datos'][$numDocumento]);
                        $arrFormularios['datos'][$numDocumento][$numRegistro]['campo'] = $arrLinea[1];
                        $arrFormularios['datos'][$numDocumento][$numRegistro]['incorrecto'] = $arrLinea[2];
                        $arrFormularios['datos'][$numDocumento][$numRegistro]['correcto'] = $arrLinea[3];
                        break;
                    case 3: // inhabilidades
                        $numDocumento = $arrLinea[1];
                        if (trim($arrLinea[3]) != "") {
                            $numRegistro = count($arrFormularios['datos'][$seqFormulario][$numDocumento]);
                            $arrFormularios['datos'][$seqFormulario][$numDocumento][$numRegistro]['fuente'] = $arrLinea[3];
                            $arrFormularios['datos'][$seqFormulario][$numDocumento][$numRegistro]['causa'] = $arrLinea[4];
                            $arrFormularios['datos'][$seqFormulario][$numDocumento][$numRegistro]['detalle'] = $arrLinea[5];
                        }
                        break;
                    case 4: // recursos de reposicion
                        $arrFormularios['datos'][$numDocumento]['estado'] = $arrLinea[1];
                        break;
                    case 7: // notificaciones
                        $arrFormularios['datos'][$numDocumento]['numero'] = $arrLinea[1];
                        $arrFormularios['datos'][$numDocumento]['fecha'] = $arrLinea[2];
                        break;
                    case 8:
                        $arrFormularios['datos'][$numDocumento]['numero'] = $arrLinea[1];
                        $arrFormularios['datos'][$numDocumento]['fecha'] = $arrLinea[2];
                        $arrFormularios['datos'][$numDocumento]['valor'] = $arrLinea[3];
                        break;
                    case 11: // Exclusion
                        $arrFormularios['datos'][$numDocumento]['estado'] = $arrLinea[1];
                        $arrFormularios['datos'][$numDocumento]['comentario'] = $arrLinea[2];
                        break;
                }
            }

            // INSERTA LA INFORMACION DEL ACTO ADMINISTRATIVO
            foreach ($arrFormularios['formularios'] as $numDocumento => $objFormulario) {


                // Inserta la informacion del formulario y vinculacion de hogares
                try {

                    $arrIgnorar[] = "arrCiudadano";
                    $arrIgnorar[] = "arrErrores";
                    $arrIgnorar[] = "fchNotificacion";
                    $arrIgnorar[] = "numPuntajeSisben";
                    $txtCamposSql = "";
                    $txtValorSql = "";

                    foreach ($objFormulario as $txtClave => $txtValor) {
                        if (!in_array($txtClave, $arrIgnorar)) {
                            if( substr($txtClave,0,3) == "fch" ){
                                if( ! esFechaValida( $txtValor ) ){
                                    $txtValor = "NULL";
                                }else{
                                    $txtValor = "'" . $txtValor . "'";
                                }
                            }else{
                                $txtValor = "'" . $txtValor . "'";
                            }
                            $txtCamposSql .= trim($txtClave) . ",";
                            $txtValorSql .= trim($txtValor) . ",";
                        }
                    }
                    $txtCamposSql = trim($txtCamposSql, ",");
                    $txtValorSql = trim($txtValorSql, ",");

                    $sql = "INSERT INTO T_AAD_FORMULARIO_ACTO ( $txtCamposSql ) VALUES ( $txtValorSql )";
                    //echo $sql;die();
                    $aptBd->execute($sql);
                    $seqFormularioActo = $aptBd->Insert_ID();

                    $numActoReferencia = 0;
                    $fchActoReferencia = "";
                    switch ($arrActo['seqTipoActo']) {
                        case 7:
                            $numActoReferencia = $arrFormularios['datos'][$numDocumento]['numero'];
                            $fchActoReferencia = $arrFormularios['datos'][$numDocumento]['fecha'];
                            break;
                        case 8: // indexacion
                            $numActoReferencia = $arrFormularios['datos'][$numDocumento]['numero'];
                            $fchActoReferencia = $arrFormularios['datos'][$numDocumento]['fecha'];
                            break;
                    }

                    $fchActoReferencia = ( esFechaValida( $fchActoReferencia ) )? "'" . $fchActoReferencia . "'" : "NULL";

                    $sql = "
                         INSERT INTO T_AAD_HOGARES_VINCULADOS ( 
                            seqFormularioActo, 
                            numActo, 
                            fchActo,  
                            seqTipoActo,
                            numActoReferencia,
                            fchActoReferencia
                         ) VALUES (
                            $seqFormularioActo,
                            " . $arrActo['numActo'] . ",
                            '" . $arrActo['fchActo'] . "',
                            " . $arrActo['seqTipoActo'] . ",
                            $numActoReferencia,
                            $fchActoReferencia
                         )
                      ";
                    $aptBd->execute($sql);
                } catch (Exception $objError) {
                    $this->arrErrores[] = "No se pudo copiar el formulario del documento " . number_format($numDocumento) . " al modulo de actos administrativos ";
                    $this->arrErrores[] = $objError->getMessage();
                    $this->arrErrores[] = $sql;
                }

                if (empty($this->arrErrores)) {

                    // inserta los ciudadanos del formulario en el modulo de actos administrativos
                    foreach ($objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {

                        try {

                            $objCiudadano->numDocumento = mb_ereg_replace("[^0-9A-Za-z]", "", $objCiudadano->numDocumento);

                            // para obtener el nombre que ira en el seguimiento
                            if ($objCiudadano->seqParentesco == 1) {
                                $numDocumentoPrincipal = $objCiudadano->numDocumento;
                                $txtNombrePrincipal = trim($objCiudadano->txtNombre1) . " ";
                                $txtNombrePrincipal .= ( trim($objCiudadano->txtNombre2) != "" ) ? trim($objCiudadano->txtNombre2) . " " : "";
                                $txtNombrePrincipal .= trim($objCiudadano->txtApelido1) . " " . trim($objCiudadano->txtApellido2);
                            }

                            $txtCamposSql = "";
                            $txtValorSql = "";
                            foreach ($objCiudadano as $txtClave => $txtValor) {
                                if ($txtClave != "arrErrores") {
                                    $txtCamposSql .= trim($txtClave) . ",";
                                    $txtValorSql .= "'" . trim($txtValor) . "',";
                                }
                            }
                            $txtCamposSql = trim($txtCamposSql, ",");
                            $txtValorSql = trim($txtValorSql, ",");

                            $sql = "INSERT INTO T_AAD_CIUDADANO_ACTO ( fchIngresoRegistro , $txtCamposSql ) VALUES ( now(), $txtValorSql )";
                            //echo "<BR>".$sql;
                            $aptBd->execute($sql);
                            $seqCiduadanoActo = $aptBd->Insert_ID();

                            $txtInhabilidad = "";
                            $txtCausa = "";
                            $txtFuente = "";
                            $txtCampo = "";
                            $txtIncorrecto = "";
                            $txtCorrecto = "";
                            $txtEstadoReposicion = "";
                            $valIndexacion = 0;

                            switch ($arrActo['seqTipoActo']) {
                                case 1: // asignacion
                                    $txtValoresSql = "
                                     (
                                        $seqFormularioActo,
                                        $seqCiduadanoActo,
                                        " . $objCiudadano->seqParentesco . ",
                                        '$txtInhabilidad',
                                        '$txtCausa',
                                        '$txtFuente',
                                        '$txtCampo',
                                        '$txtIncorrecto',
                                        '$txtCorrecto',
                                        '$txtEstadoReposicion',
                                        $valIndexacion
                                     )
                                  ";
                                    break;
                                case 2: // modificatorias
                                    if (isset($arrFormularios['datos'][$objFormulario->seqFormulario][$objCiudadano->numDocumento])) {
                                        $txtValoresSql = "";
                                        foreach ($arrFormularios['datos'][$objFormulario->seqFormulario][$objCiudadano->numDocumento] as $arrRegistro) {
                                            $txtValoresSql .= "
                                           (
                                              $seqFormularioActo,
                                              $seqCiduadanoActo,
                                              " . $objCiudadano->seqParentesco . ",
                                              '$txtInhabilidad',
                                              '$txtCausa',
                                              '$txtFuente',
                                              '" . $arrRegistro['campo'] . "',
                                              '" . $arrRegistro['incorrecto'] . "',
                                              '" . $arrRegistro['correcto'] . "',
                                              '$txtEstadoReposicion',
                                              $valIndexacion
                                           ),";
                                        }
                                        $txtValoresSql = trim($txtValoresSql, ",");
                                        /* if (isset($arrFormularios['datos'][$objCiudadano->numDocumento])) {
                                          foreach ($arrFormularios['datos'][$objCiudadano->numDocumento] as $arrRegtistro) {
                                          $txtValoresSql .= "
                                          (
                                          $seqFormularioActo,
                                          $seqCiduadanoActo,
                                          " . $objCiudadano->seqParentesco . ",
                                          '$txtInhabilidad',
                                          '$txtCausa',
                                          '$txtFuente',
                                          '" . $arrRegtistro['campo'] . "',
                                          '" . $arrRegtistro['incorrecto'] . "',
                                          '" . $arrRegtistro['correcto'] . "',
                                          '$txtEstadoReposicion',
                                          $valIndexacion
                                          )";
                                          }
                                          $txtValoresSql = trim($txtValoresSql, ","); */
                                    } else {
                                        $txtValoresSql = "
                                        (
                                           $seqFormularioActo,
                                           $seqCiduadanoActo,
                                           " . $objCiudadano->seqParentesco . ",
                                           '$txtInhabilidad',
                                           '$txtCausa',
                                           '$txtFuente',
                                           '" . $arrRegistro['campo'] . "',
                                           '" . $arrRegistro['incorrecto'] . "',
                                           '" . $arrRegistro['correcto'] . "',
                                           '$txtEstadoReposicion',
                                           $valIndexacion
                                        )
                                     ";
                                    }
                                    break;
                                case 3: // inhabilidades
                                    if (isset($arrFormularios['datos'][$objFormulario->seqFormulario][$objCiudadano->numDocumento])) {
                                        $txtValoresSql = "";
                                        foreach ($arrFormularios['datos'][$objFormulario->seqFormulario][$objCiudadano->numDocumento] as $arrRegistro) {
                                            $txtValoresSql .= "
                                           (
                                              $seqFormularioActo,
                                              $seqCiduadanoActo,
                                              " . $objCiudadano->seqParentesco . ",
                                              '" . $arrRegistro['detalle'] . "',
                                              '" . $arrRegistro['causa'] . "',
                                              '" . $arrRegistro['fuente'] . "',
                                              '$txtCampo',
                                              '$txtIncorrecto',
                                              '$txtCorrecto',
                                              '$txtEstadoReposicion',
                                              $valIndexacion
                                           ),";
                                        }
                                        $txtValoresSql = trim($txtValoresSql, ",");
                                    } else {
                                        $txtValoresSql = "
                                        (
                                           $seqFormularioActo,
                                           $seqCiduadanoActo,
                                           " . $objCiudadano->seqParentesco . ",
                                           '$txtInhabilidad',
                                           '$txtCausa',
                                           '$txtFuente',
                                           '$txtCampo',
                                           '$txtIncorrecto',
                                           '$txtCorrecto',
                                           '$txtEstadoReposicion',
                                           $valIndexacion
                                        )
                                     ";
                                    }
                                    break;
                                case 4: // Recursos de reposicion
                                    if (isset($arrFormularios['datos'][$objCiudadano->numDocumento])) {
                                        $seqNuevoEstado = $arrFormularios['datos'][$objCiudadano->numDocumento]['estado'];
                                        $seqAnteriorEstado = $objFormulario->seqEstadoProceso;
                                        $txtNuevoEstado = $arrEstados[$seqNuevoEstado];
                                        $txtAnteriorEstado = $arrEstados[$seqAnteriorEstado];
                                        $txtValoresSql = "
                                        (
                                           $seqFormularioActo,
                                           $seqCiduadanoActo,
                                           " . $objCiudadano->seqParentesco . ",
                                           '$txtInhabilidad',
                                           '$txtCausa',
                                           '$txtFuente',
                                           '$txtCampo',
                                           '$txtIncorrecto',
                                           '$txtCorrecto',
                                           'Pasa del estado $txtAnteriorEstado al estado $txtNuevoEstado',
                                           $valIndexacion
                                        )
                                     ";
                                    } else {
                                        $txtValoresSql = "
                                        (
                                           $seqFormularioActo,
                                           $seqCiduadanoActo,
                                           " . $objCiudadano->seqParentesco . ",
                                           '$txtInhabilidad',
                                           '$txtCausa',
                                           '$txtFuente',
                                           '$txtCampo',
                                           '$txtIncorrecto',
                                           '$txtCorrecto',
                                           '$txtEstadoReposicion',
                                           $valIndexacion
                                        )
                                     ";
                                    }
                                    break;
                                case 5: // no asignados
                                    $txtValoresSql = "
                                     (
                                        $seqFormularioActo,
                                        $seqCiduadanoActo,
                                        " . $objCiudadano->seqParentesco . ",
                                        '$txtInhabilidad',
                                        '$txtCausa',
                                        '$txtFuente',
                                        '$txtCampo',
                                        '$txtIncorrecto',
                                        '$txtCorrecto',
                                        '$txtEstadoReposicion',
                                        $valIndexacion
                                     )
                                  ";
                                    break;
                                case 6: // renuncias
                                    $txtValoresSql = "
                                     (
                                        $seqFormularioActo,
                                        $seqCiduadanoActo,
                                        " . $objCiudadano->seqParentesco . ",
                                        '$txtInhabilidad',
                                        '$txtCausa',
                                        '$txtFuente',
                                        '$txtCampo',
                                        '$txtIncorrecto',
                                        '$txtCorrecto',
                                        '$txtEstadoReposicion',
                                        $valIndexacion
                                     )
                                  ";
                                    break;
                                case 9: // perdidas
                                    $txtValoresSql = "
                                     (
                                        $seqFormularioActo,
                                        $seqCiduadanoActo,
                                        " . $objCiudadano->seqParentesco . ",
                                        '$txtInhabilidad',
                                        '$txtCausa',
                                        '$txtFuente',
                                        '$txtCampo',
                                        '$txtIncorrecto',
                                        '$txtCorrecto',
                                        '$txtEstadoReposicion',
                                        $valIndexacion
                                     )
                                  ";
                                    break;
                                case 10: // revocatorias
                                    $txtValoresSql = "
                                     (
                                        $seqFormularioActo,
                                        $seqCiduadanoActo,
                                        " . $objCiudadano->seqParentesco . ",
                                        '$txtInhabilidad',
                                        '$txtCausa',
                                        '$txtFuente',
                                        '$txtCampo',
                                        '$txtIncorrecto',
                                        '$txtCorrecto',
                                        '$txtEstadoReposicion',
                                        $valIndexacion
                                     )
                                  ";
                                    break;
                                case 11: // Exclusion
                                    if (isset($arrFormularios['datos'][$objCiudadano->numDocumento])) {
                                        $seqNuevoEstado = $arrFormularios['datos'][$objCiudadano->numDocumento]['estado'];
                                        $seqAnteriorEstado = $objFormulario->seqEstadoProceso;
                                        $txtNuevoEstado = $arrEstados[$seqNuevoEstado];
                                        $txtAnteriorEstado = $arrEstados[$seqAnteriorEstado];
                                        $txtValoresSql = "
                                        (
                                           $seqFormularioActo,
                                           $seqCiduadanoActo,
                                           " . $objCiudadano->seqParentesco . ",
                                           '$txtInhabilidad',
                                           '$txtCausa',
                                           '$txtFuente',
                                           '$txtCampo',
                                           '$txtIncorrecto',
                                           '$txtCorrecto',
                                           'Pasa del estado $txtAnteriorEstado al estado $txtNuevoEstado',
                                           $valIndexacion
                                        )
                                     ";
                                    } else {
                                        $txtValoresSql = "
                                        (
                                           $seqFormularioActo,
                                           $seqCiduadanoActo,
                                           " . $objCiudadano->seqParentesco . ",
                                           '$txtInhabilidad',
                                           '$txtCausa',
                                           '$txtFuente',
                                           '$txtCampo',
                                           '$txtIncorrecto',
                                           '$txtCorrecto',
                                           '$txtEstadoReposicion',
                                           $valIndexacion
                                        )
                                     ";
                                    }
                                    break;
                                case 7: // notificaciones
                                    $txtValoresSql = "
                                     (
                                        $seqFormularioActo,
                                        $seqCiduadanoActo,
                                        " . $objCiudadano->seqParentesco . ",
                                        '$txtInhabilidad',
                                        '$txtCausa',
                                        '$txtFuente',
                                        '$txtCampo',
                                        '$txtIncorrecto',
                                        '$txtCorrecto',
                                        '$txtEstadoReposicion',
                                        $valIndexacion
                                     )
                                  ";
                                    break;
                                case 8: // indexacion
                                    if (isset($arrFormularios['datos'][$objCiudadano->numDocumento])) {
                                        $txtValoresSql = "
                                        (
                                           $seqFormularioActo,
                                           $seqCiduadanoActo,
                                           " . $objCiudadano->seqParentesco . ",
                                           '$txtInhabilidad',
                                           '$txtCausa',
                                           '$txtFuente',
                                           '$txtCampo',
                                           '$txtIncorrecto',
                                           '$txtCorrecto',
                                           '$txtEstadoReposicion',
                                           " . $arrFormularios['datos'][$objCiudadano->numDocumento]['valor'] . "
                                        )
                                     ";
                                    } else {
                                        $txtValoresSql = "
                                        (
                                           $seqFormularioActo,
                                           $seqCiduadanoActo,
                                           " . $objCiudadano->seqParentesco . ",
                                           '$txtInhabilidad',
                                           '$txtCausa',
                                           '$txtFuente',
                                           '$txtCampo',
                                           '$txtIncorrecto',
                                           '$txtCorrecto',
                                           '$txtEstadoReposicion',
                                           $valIndexacion
                                        )
                                     ";
                                    }
                                    break;
                            }

                            $sql = "
                                    INSERT INTO T_AAD_HOGAR_ACTO (
                                       seqFormularioActo,
                                       seqCiudadanoActo,
                                       seqParentesco,
                                       txtInhabilidad,
                                       txtCausa,
                                       txtFuente,
                                       txtCampo,
                                       txtIncorrecto,
                                       txtCorrecto,
                                       txtEstadoReposicion,
                                       valInd exacion
                                    ) VALUES 
                                       $txtValoresSql;
                                 ";
                            //echo $sql;
                            $aptBd->execute($sql);
                        } catch (Exception $objError) {
                            $this->arrErrores[] = "No se pudo copiar el ciudadano del documento " . number_format($objCiudadano->numDocumento) . " al modulo de actos administrativos ";
                        }
                    }
                }

                // Modificaciones al formulario real
                if (empty($this->arrErrores)) {
                    $adicionSeguimiento = "";
                    $txtCambios = "";
                    $adicionComentario = "";
                    switch ($arrActo['seqTipoActo']) {
                        case 1:
                            $seqEstadoProceso = 0;
                            switch ($objFormulario->seqTipoEsquema) {
                                default:
                                    $seqEstadoProceso = 15;
                                    break;
                            }

                            $txtCambios .= "seqEstadoProceso, Valor Anterior: " . $objFormulario->seqEstadoProceso . ", Valor Nuevo: $seqEstadoProceso\n";
                           //$seqFormularioActo
                            $sql = "
                                    UPDATE T_FRM_FORMULARIO SET
                                       seqEstadoProceso = $seqEstadoProceso
                                    WHERE seqFormulario = " . $objFormulario->seqFormulario . "
                                 ";
                            $aptBd->execute($sql);
                            $sqlActo = "
                                    UPDATE T_AAD_FORMULARIO_ACTO SET
                                       seqEstadoProceso = $seqEstadoProceso
                                    WHERE seqFormularioActo = " . $seqFormularioActo . "
                                 ";
                            $aptBd->execute($sqlActo);
                            break;
                        case 2:
                            if (isset($arrFormularios['datos'][$numDocumento]) and ! empty($arrFormularios['datos'][$numDocumento])) {
                                $txtCambios = "";
                                foreach ($arrFormularios['datos'][$numDocumento] as $arrRegistro) {
                                    switch (strtolower($arrRegistro['campo'])) {
                                        case "primer nombre":
                                            foreach ($objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                                                if (mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento) == $numDocumento) {
                                                    break;
                                                }
                                            }
                                            $sql = "
                                                    UPDATE T_CIU_CIUDADANO SET
                                                       txtNombre1 = '" . $arrRegistro['correcto'] . "'
                                                    WHERE seqCiudadano = " . $seqCiudadano . ";
                                                 ";
                                            $aptBd->execute($sql);
                                            $txtCambios .= "txtNombre1, Valor Anterior: " . $arrRegistro['incorrecto'] . ", Valor Nuevo: " . $arrRegistro['correcto'] . "\n";
                                            break;
                                        case "segundo nombre":
                                            foreach ($objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                                                if (mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento) == $numDocumento) {
                                                    break;
                                                }
                                            }
                                            $sql = "
                                                    UPDATE T_CIU_CIUDADANO SET
                                                       txtNombre2 = '" . $arrRegistro['correcto'] . "'
                                                    WHERE seqCiudadano = " . $seqCiudadano . ";
                                                 ";
                                            $aptBd->execute($sql);
                                            $txtCambios .= "txtNombre2, Valor Anterior: " . $arrRegistro['incorrecto'] . ", Valor Nuevo: " . $arrRegistro['correcto'] . "\n";
                                            break;
                                        case "primer apellido":
                                            foreach ($objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                                                if (mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento) == $numDocumento) {
                                                    break;
                                                }
                                            }
                                            $sql = "
                                                    UPDATE T_CIU_CIUDADANO SET
                                                       txtApellido1 = '" . $arrRegistro['correcto'] . "'
                                                    WHERE seqCiudadano = " . $seqCiudadano . ";
                                                 ";
                                            $aptBd->execute($sql);
                                            $txtCambios .= "txtApellido1, Valor Anterior: " . $arrRegistro['incorrecto'] . ", Valor Nuevo: " . $arrRegistro['correcto'] . "\n";
                                            break;
                                        case "segundo apellido":
                                            foreach ($objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                                                if (mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento) == $numDocumento) {
                                                    break;
                                                }
                                            }
                                            $sql = "
                                                    UPDATE T_CIU_CIUDADANO SET
                                                       txtApellido2 = '" . $arrRegistro['correcto'] . "'
                                                    WHERE seqCiudadano = " . $seqCiudadano . ";
                                                 ";
                                            $aptBd->execute($sql);
                                            $txtCambios .= "txtApellido2, Valor Anterior: " . $arrRegistro['incorrecto'] . ", Valor Nuevo: " . $arrRegistro['correcto'] . "\n";
                                            break;
                                        case "tipo de solucion":
                                            $seqSolucion = obtenerSecuencial(
                                                    $arrRegistro['correcto'], "T_FRM_SOLUCION", "txtSolucion", "seqSolucion", "AND seqModalidad = " . $objFormulario->seqModalidad
                                            );
                                            $sql = "
                                                    UPDATE T_FRM_FORMULARIO SET
                                                       seqSolucion = $seqSolucion
                                                    WHERE seqFormulario = " . $objFormulario->seqFormulario . "
                                                 ";
                                            $aptBd->execute($sql);
                                            $txtCambios .= "seqSolucion, Valor Anterior: " . $objFormulario->seqSolucion . ", Valor Nuevo: " . $seqSolucion . "\n";
                                            break;
                                        case "valor del subsidio":
                                            $sql = "
                                                    UPDATE T_FRM_FORMULARIO SET
                                                       valAspiraSubsidio = " . $arrRegistro['correcto'] . "
                                                    WHERE seqFormulario = " . $objFormulario->seqFormulario . "
                                                 ";
                                            $aptBd->execute($sql);
                                            $txtCambios .= "valAspiraSubsidio, Valor Anterior: " . $arrRegistro['incorrecto'] . ", Valor Nuevo: " . $arrRegistro['correcto'] . "\n";
                                            break;
                                        case "matricula inmobiliaria":
                                            $sql = "
                                                    UPDATE T_FRM_FORMULARIO SET
                                                       txtMatriculaInmobiliaria = '" . $arrRegistro['correcto'] . "'
                                                    WHERE seqFormulario = " . $objFormulario->seqFormulario . "
                                                 ";
                                            $aptBd->execute($sql);
                                            $txtCambios .= "txtMatriculaInmobiliaria, Valor Anterior: " . $arrRegistro['incorrecto'] . ", Valor Nuevo: " . $arrRegistro['correcto'] . "\n";
                                            break;
                                        case "valor donacion":
                                            $sql = "
                                                    UPDATE T_FRM_FORMULARIO SET
                                                       valDonacion = '" . $arrRegistro['correcto'] . "'
                                                    WHERE seqFormulario = " . $objFormulario->seqFormulario . "
                                                 ";
                                            $aptBd->execute($sql);
                                            $txtCambios .= "valDonacion, Valor Anterior: " . $arrRegistro['incorrecto'] . ", Valor Nuevo: " . $arrRegistro['correcto'] . "\n";
                                            break;
                                        case "soporte donacion":
                                            $sql = "
                                                    UPDATE T_FRM_FORMULARIO SET
                                                       txtSoporteDonacion = '" . $arrRegistro['correcto'] . "'
                                                    WHERE seqFormulario = " . $objFormulario->seqFormulario . "
                                                 ";
                                            $aptBd->execute($sql);
                                            $txtCambios .= "txtSoporteDonacion, Valor Anterior: " . $arrRegistro['incorrecto'] . ", Valor Nuevo: " . $arrRegistro['correcto'] . "\n";
                                            break;
                                        case "entidad donacion":
                                            $sql = "
                                                    UPDATE T_FRM_FORMULARIO SET
                                                       seqEmpresaDonante = '" . $arrRegistro['correcto'] . "'
                                                    WHERE seqFormulario = " . $objFormulario->seqFormulario . "
                                                 ";
                                            $aptBd->execute($sql);
                                            $txtCambios .= "seqEmpresaDonante, Valor Anterior: " . $arrRegistro['incorrecto'] . ", Valor Nuevo: " . $arrRegistro['correcto'] . "\n";
                                            break;
                                        case "proyecto":
                                            $seqProyecto = 0;
                                            $seqProyectoCorrecto = 0;
                                            $seqProyectoIncorrecto = 0;
                                            // CONSULTA NOMBRE PROYECTO (CAMPO CORRECTO)
                                            $sqlCorrecto = "SELECT seqProyecto, seqTipoEsquema, txtMatriculaInmobiliariaLote, txtChipLote, txtDireccion
																FROM T_PRY_PROYECTO 
																WHERE txtNombreProyecto = '" . $arrRegistro['correcto'] . "'";
                                            $objRes = $aptBd->execute($sqlCorrecto);
                                            if ($objRes->fields) {
                                                $seqProyectoCorrecto = $objRes->fields['seqProyecto'];
                                                $seqTipoEsquemaCorrecto = $objRes->fields['seqTipoEsquema'];
                                                $txtMatriculaInmobiliariaCorrecto = $objRes->fields['txtMatriculaInmobiliariaLote'];
                                                $txtChipCorrecto = $objRes->fields['txtChipLote'];
                                                $txtDireccionSolucionCorrecto = $objRes->fields['txtDireccion'];
                                            }
                                            // Valida la existencia del proyecto (Campo Correcto)
                                            if (empty($seqProyectoCorrecto)) {
                                                $this->arrErrores[] = "Valor Correcto " . $arrRegistro['correcto'] . " no es válido";
                                            }

                                            // CONSULTA NOMBRE PROYECTO (CAMPO INCORRECTO)
                                            $sqlIncorrecto = "SELECT seqProyecto, seqTipoEsquema, txtMatriculaInmobiliariaLote, txtChipLote, txtDireccion
																	FROM T_PRY_PROYECTO 
																	WHERE txtNombreProyecto = '" . $arrRegistro['incorrecto'] . "'";
                                            $objRes = $aptBd->execute($sqlIncorrecto);
                                            if ($objRes->fields) {
                                                $seqProyectoIncorrecto = $objRes->fields['seqProyecto'];
                                                $seqTipoEsquemaIncorrecto = $objRes->fields['seqTipoEsquema'];
                                                $txtMatriculaInmobiliariaIncorrecto = $objRes->fields['txtMatriculaInmobiliariaLote'];
                                                $txtChipIncorrecto = $objRes->fields['txtChipLote'];
                                                $txtDireccionSolucionIncorrecto = $objRes->fields['txtDireccion'];
                                            }
                                            // Valida la existencia del proyecto (Campo Incorrecto)
                                            if (empty($seqProyectoIncorrecto)) {
                                                $this->arrErrores[] = "Valor Incorrecto " . $arrRegistro['incorrecto'] . " no es válido";
                                            }

                                            // CONSULTA EL PROYECTO ACTUAL DEL HOGAR
                                            $sqlConsulta = "SELECT seqProyecto, seqUnidadProyecto, seqTipoEsquema
																FROM T_FRM_FORMULARIO WHERE seqFormulario = $seqFormulario";
                                            $objRes = $aptBd->execute($sqlConsulta);
                                            if ($objRes->fields) {
                                                $seqProyecto = $objRes->fields['seqProyecto'];
                                                $seqUnidadProyecto = $objRes->fields['seqUnidadProyecto'];
                                                $seqTipoEsquema = $objRes->fields['seqTipoEsquema'];
                                            }
                                            // Valida que el campo cargado en el campo incorrecto sea igual al proyecto al que pertenece el hogar
                                            if ($seqProyectoIncorrecto != $seqProyecto) {
                                                $this->arrErrores[] = "El proyecto al que pertenece el hogar es diferente al valor incorrecto cargado en el archivo";
                                            }
                                            // SI NO HAY ERRORES, GESTIONAR LOS CAMBIOS
                                            if (empty($this->arrErrores)) {
                                                if ($seqTipoEsquemaCorrecto == 1) { // SI EL CAMBIO ES A ESQUEMA INDIVIDUAL
                                                    // Se actualiza Proyecto, matricula, chip y direccion solucion, se limpia la unidad
                                                    $sqlUpdFormulario = "UPDATE T_FRM_FORMULARIO
																			SET seqProyecto = $seqProyectoCorrecto,
																				txtMatriculaInmobiliaria = '$txtMatriculaInmobiliariaCorrecto',
																				txtChip = '$txtChipCorrecto',
																				txtDireccionSolucion = '$txtDireccionSolucionCorrecto',
																				seqUnidadProyecto = 1
																			WHERE seqFormulario = $seqFormulario";
                                                    $aptBd->execute($sqlUpdFormulario);
                                                    // si el formulario existe en la tabla T_PRY_UNIDAD_PROYECTO se limpia
                                                    $sqlUpdUnidadProyecto = "UPDATE T_PRY_UNIDAD_PROYECTO
																				SET seqFormulario = NULL
																				WHERE seqFormulario = $seqFormulario";
                                                    $aptBd->execute($sqlUpdUnidadProyecto);
                                                } else if ($seqTipoEsquemaCorrecto == 4) { // SI EL CAMBIO ES A TERRITORIAL DIRIGIDO
                                                    // Se actualiza Proyecto, se limpia matricula, chip, direccion solucion y unidad
                                                    $sqlUpdFormulario = "UPDATE T_FRM_FORMULARIO
																			SET seqProyecto = $seqProyectoCorrecto, 
																				txtMatriculaInmobiliaria = '',
																				txtChip = '',
																				txtDireccionSolucion = '',
																				seqUnidadProyecto = 1
																			WHERE seqFormulario = $seqFormulario";
                                                    $aptBd->execute($sqlUpdFormulario);
                                                    // si el formulario existe en la tabla T_PRY_UNIDAD_PROYECTO se limpia
                                                    $sqlUpdUnidadProyecto = "UPDATE T_PRY_UNIDAD_PROYECTO
																				SET seqFormulario = NULL
																				WHERE seqFormulario = $seqFormulario";
                                                    $aptBd->execute($sqlUpdUnidadProyecto);
                                                }
                                            }
                                            $txtCambios .= "seqProyecto, Valor Anterior: " . $seqProyectoIncorrecto . ", Valor Nuevo: " . $seqProyectoCorrecto . "\n";
                                            break;
                                        case "unidad habitacional":
                                            ////////// SI EL CAMPO CORRECTO (UNIDAD) TIENE EL (PROYECTO - UNIDAD), DIVIDE EL CAMPO PARA TRATAMIENTO //////////
                                            $unidadCorrecta = $arrRegistro['correcto'];
                                            $segmento = explode(" - ", $unidadCorrecta);
                                            $segmentoConjunto = "";
                                            $segmentoUnidad = "";
                                            if ($segmento[0] != "" && $segmento[1] != "") { // Si tiene la estructura "Proyecto - Unidad"
                                                $segmentoConjunto = trim($segmento[0]);
                                                $segmentoUnidad = trim($segmento[1]);
                                            } else {
                                                $segmentoConjunto = "";
                                                $segmentoUnidad = $arrRegistro['correcto'];
                                            }

                                            /////////////// CONSULTA PROYECTO, PROYECTO HIJO Y UNIDAD ASOCIADOS AL DOCUMENTO DEL ARCHIVO PLANO ///////////////
                                            $sql = "SELECT 
															seqProyecto, 
															seqProyectoHijo,
															seqUnidadProyecto
														FROM T_FRM_FORMULARIO
														WHERE seqFormulario = " . $objFormulario->seqFormulario . "
													  ";
                                            $objRes = $aptBd->execute($sql);
                                            $seqProyectoActual = 0;
                                            $seqProyectoHijoActual = 0;
                                            $seqUnidadProyectoActual = 0;
                                            if ($objRes->fields) {
                                                $seqProyectoActual = $objRes->fields['seqProyecto'];
                                                $seqProyectoHijoActual = $objRes->fields['seqProyectoHijo'];
                                                $seqUnidadProyectoActual = $objRes->fields['seqUnidadProyecto'];
                                            }

                                            // 'idProyectoActual' cambia si es Proyecto Padre o Proyecto Hijo
                                            if ($seqProyectoHijoActual == 0 || $seqProyectoHijoActual == '') {
                                                $idProyectoActual = $seqProyectoActual;
                                            } else {
                                                $idProyectoActual = $seqProyectoHijoActual;
                                            }

                                            // Si el campo correcto tiene conjunto residencial
                                            $idProyectoNuevo = 0;
                                            $flagCambiaProyecto = 0;
                                            if ($segmentoConjunto != "") {
                                                if ($segmentoConjunto == "NOGAL") { // PARQUES DE BOGOTA - NOGAL
                                                    $idProyectoNuevo = 31;
                                                } else if ($segmentoConjunto == "CEREZO") { // PARQUES DE BOGOTA - CEREZO
                                                    $idProyectoNuevo = 33;
                                                } else if ($segmentoConjunto == "ARRAYAN") { // PARQUES DE BOGOTA - ARRAYAN
                                                    $idProyectoNuevo = 34;
                                                } else if ($segmentoConjunto == "FLAMENCO I") { // PARQUES DE VILLA JAVIER - FLAMENCO I
                                                    $idProyectoNuevo = 111;
                                                } else if ($segmentoConjunto == "FLAMENCO II") { // PARQUES DE VILLA JAVIER - FLAMENCO II 
                                                    $idProyectoNuevo = 112;
                                                } else { // EL SEGMENTO PERTENECE A UN PROYECTO
                                                    $flagCambiaProyecto = 1;
                                                }
                                            }

                                            if ($segmentoUnidad != "") { // LA UNIDAD ESTÁ VACÍA
                                                if ($segmentoConjunto == '') { ///////////////////////////////// CASO 1. MISMO PROYECTO ///////////////////////
                                                    // Consulta el consecutivo de la unidad habitacional (Valor Incorrecto)
                                                    $sql = "SELECT seqUnidadProyecto FROM T_PRY_UNIDAD_PROYECTO 
																WHERE txtNombreUnidad = '" . $arrRegistro['incorrecto'] . "' AND seqProyecto = $idProyectoActual";
                                                    $objRes = $aptBd->execute($sql);
                                                    $seqUnidadProyectoIncorrecto = 0;
                                                    if ($objRes->fields) {
                                                        $seqUnidadProyectoIncorrecto = $objRes->fields['seqUnidadProyecto'];
                                                    }
                                                    $sql = "SELECT seqUnidadProyecto, seqFormulario FROM T_PRY_UNIDAD_PROYECTO
																WHERE txtNombreUnidad = '" . $segmentoUnidad . "' AND seqProyecto = $seqProyectoActual";
                                                    $objRes = $aptBd->execute($sql);
                                                    $seqUnidadProyectoCorrecto = 0;
                                                    $seqFormularioAsignado = 0;
                                                    if ($objRes->fields) {
                                                        $seqUnidadProyectoCorrecto = $objRes->fields['seqUnidadProyecto'];
                                                        $seqFormularioAsignado = $objRes->fields['seqFormulario'];
                                                    }
                                                    // Actualizando valores
                                                    if ($seqFormularioAsignado > 0) {
                                                        $this->arrErrores[] = "La Unidad " . $arrRegistro['correcto'] . " ya está asignada";
                                                    } else {
                                                        // Actualiza la unidad en el formulario
                                                        $sql = "UPDATE T_FRM_FORMULARIO SET seqUnidadProyecto = " . $seqUnidadProyectoCorrecto . " WHERE seqFormulario = " . $objFormulario->seqFormulario . "";
                                                        $aptBd->execute($sql);
                                                        // Actualiza el formulario el tabla unidad_proyecto y libera la antigua unidad
                                                        $sql = "UPDATE T_PRY_UNIDAD_PROYECTO SET seqFormulario = " . $objFormulario->seqFormulario . " WHERE seqUnidadProyecto = " . $seqUnidadProyectoCorrecto . "";
                                                        $aptBd->execute($sql);
                                                        // Libera la unidad antigua
                                                        $sql = "UPDATE T_PRY_UNIDAD_PROYECTO SET seqFormulario = '' WHERE seqUnidadProyecto = " . $seqUnidadProyectoIncorrecto . "";
                                                        $aptBd->execute($sql);
                                                    }
                                                } else { // Cambia el proyecto o el conjunto residencial
                                                    if ($flagCambiaProyecto == 1) { ///////////////////////////////////// CASO 2. CAMBIA DE PROYECTO /////////////////////////////////////////////
                                                        // Consulta el consecutivo de la unidad habitacional (Valor Incorrecto)
                                                        $sql = "SELECT seqUnidadProyecto FROM T_PRY_UNIDAD_PROYECTO 
																WHERE txtNombreUnidad = '" . $arrRegistro['incorrecto'] . "' AND seqProyecto = $idProyectoActual";
                                                        $objRes = $aptBd->execute($sql);
                                                        $seqUnidadProyectoIncorrecto = 0;
                                                        if ($objRes->fields) {
                                                            $seqUnidadProyectoIncorrecto = $objRes->fields['seqUnidadProyecto'];
                                                        }
                                                        // Consulta Proyecto
                                                        $sql = "SELECT seqProyecto, txtMatriculaInmobiliariaLote, txtChipLote, txtDireccion FROM T_PRY_PROYECTO
																	WHERE txtNombreProyecto = '" . $segmentoConjunto . "'";
                                                        $objRes = $aptBd->execute($sql);
                                                        $seqNuevoProyecto = 0;
                                                        if ($objRes->fields) {
                                                            $seqNuevoProyecto = $objRes->fields['seqProyecto'];
                                                            $txtMatriculaInmobiliariaLote = $objRes->fields['txtMatriculaInmobiliariaLote'];
                                                            $txtChipLote = $objRes->fields['txtChipLote'];
                                                            $txtDireccion = $objRes->fields['txtDireccion'];
                                                        }
                                                        // Consulta la Unidad Proyecto
                                                        $sql = "SELECT seqUnidadProyecto, seqFormulario FROM T_PRY_UNIDAD_PROYECTO
																	WHERE txtNombreUnidad = '" . $segmentoUnidad . "' AND seqProyecto = $seqNuevoProyecto";
                                                        $objRes = $aptBd->execute($sql);
                                                        $seqUnidadProyectoCorrecto = 0;
                                                        $seqFormularioAsignado = 0;
                                                        if ($objRes->fields) {
                                                            $seqUnidadProyectoCorrecto = $objRes->fields['seqUnidadProyecto'];
                                                            $seqFormularioAsignado = $objRes->fields['seqFormulario'];
                                                        }
                                                        // Actualizando valores
                                                        if ($seqFormularioAsignado > 0) {
                                                            $this->arrErrores[] = "La Unidad " . $arrRegistro['correcto'] . " ya está asignada";
                                                        } else {
                                                            // Actualiza la unidad en el formulario
                                                            $sql = "UPDATE T_FRM_FORMULARIO SET seqUnidadProyecto = " . $seqUnidadProyectoCorrecto . " WHERE seqFormulario = " . $objFormulario->seqFormulario . "";
                                                            $aptBd->execute($sql);
                                                            // Actualiza el formulario el tabla unidad_proyecto y libera la antigua unidad
                                                            $sql = "UPDATE T_PRY_UNIDAD_PROYECTO SET seqFormulario = " . $objFormulario->seqFormulario . " WHERE seqUnidadProyecto = " . $seqUnidadProyectoCorrecto . "";
                                                            $aptBd->execute($sql);
                                                            // Libera la unidad antigua
                                                            $sql = "UPDATE T_PRY_UNIDAD_PROYECTO SET seqFormulario = '' WHERE seqUnidadProyecto = " . $seqUnidadProyectoIncorrecto . "";
                                                            $aptBd->execute($sql);
                                                            // Cambia la matricula inmobiliaria, chip y direccion del proyecto
                                                            $sql = "UPDATE T_FRM_FORMULARIO 
																		SET seqProyecto = '" . $seqNuevoProyecto . "', 
																		txtMatriculaInmobiliaria = '" . $txtMatriculaInmobiliariaLote . "', 
																		txtChip = '" . $txtChipLote . "', 
																		txtDireccionSolucion = '" . $txtDireccion . "' 
																		WHERE seqFormulario = " . $objFormulario->seqFormulario . "";
                                                            $aptBd->execute($sql);
                                                        }
                                                    } else { //////////////////////////// CASO 3. CAMBIA CONJUNTO RESIDENCIAL /////////////////////////////////
                                                        // Consulta el consecutivo de la unidad habitacional (Valor Incorrecto)
                                                        $sql = "SELECT seqUnidadProyecto FROM T_PRY_UNIDAD_PROYECTO 
																WHERE txtNombreUnidad = '" . $arrRegistro['incorrecto'] . "' AND seqProyecto = $idProyectoActual";
                                                        $objRes = $aptBd->execute($sql);
                                                        $seqUnidadProyectoIncorrecto = 0;
                                                        if ($objRes->fields) {
                                                            $seqUnidadProyectoIncorrecto = $objRes->fields['seqUnidadProyecto'];
                                                        }
                                                        $sql = "SELECT seqUnidadProyecto, seqFormulario FROM T_PRY_UNIDAD_PROYECTO
																	WHERE txtNombreUnidad = '" . $segmentoUnidad . "' AND seqProyecto = $idProyectoNuevo";
                                                        $objRes = $aptBd->execute($sql);
                                                        $seqUnidadProyectoCorrecto = 0;
                                                        $seqFormularioAsignado = 0;
                                                        if ($objRes->fields) {
                                                            $seqUnidadProyectoCorrecto = $objRes->fields['seqUnidadProyecto'];
                                                            $seqFormularioAsignado = $objRes->fields['seqFormulario'];
                                                        }
                                                        // Actualizando valores
                                                        if ($seqFormularioAsignado > 0) {
                                                            $this->arrErrores[] = "La Unidad " . $arrRegistro['correcto'] . " ya está asignada";
                                                        } else {
                                                            // Actualiza la unidad en el formulario
                                                            $sql = "UPDATE T_FRM_FORMULARIO SET seqUnidadProyecto = " . $seqUnidadProyectoCorrecto . " WHERE seqFormulario = " . $objFormulario->seqFormulario . "";
                                                            $aptBd->execute($sql);
                                                            // Actualiza el formulario el tabla unidad_proyecto y libera la antigua unidad
                                                            $sql = "UPDATE T_PRY_UNIDAD_PROYECTO SET seqFormulario = " . $objFormulario->seqFormulario . " WHERE seqUnidadProyecto = " . $seqUnidadProyectoCorrecto . "";
                                                            $aptBd->execute($sql);
                                                            // Libera la unidad antigua
                                                            $sql = "UPDATE T_PRY_UNIDAD_PROYECTO SET seqFormulario = '' WHERE seqUnidadProyecto = " . $seqUnidadProyectoIncorrecto . "";
                                                            $aptBd->execute($sql);
                                                            // Cambia al nuevo conjunto residencial del formulario
                                                            if ($idProyectoNuevo == 31 || $idProyectoNuevo == 33 || $idProyectoNuevo == 34 || $idProyectoNuevo == 111 || $idProyectoNuevo == 112) {
                                                                $sql = "UPDATE T_FRM_FORMULARIO 
																			SET seqProyectoHijo = $idProyectoNuevo 
																			WHERE seqFormulario = " . $objFormulario->seqFormulario . "";
                                                                $aptBd->execute($sql);
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            $flagCambiaProyecto = 0;
                                            // seqUnidadProyecto por UnidadProyecto
                                            $txtCambios .= "UnidadProyecto, Valor Anterior: " . $arrRegistro['incorrecto'] . ", Valor Nuevo: " . $arrRegistro['correcto'] . "\n";
                                            break;
                                        case "documento":
                                            foreach ($objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                                                if (mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento) == $numDocumento) {
                                                    break;
                                                }
                                            }
                                            $sql = "
                                                    UPDATE T_CIU_CIUDADANO SET
                                                       numDocumento = " . $arrRegistro['correcto'] . "
                                                    WHERE seqCiudadano = " . $seqCiudadano . ";
                                                 ";
                                            $aptBd->execute($sql);
                                            $sql = "
                                                    UPDATE T_AAD_CIUDADANO_ACTO SET
                                                       numDocumento = " . $arrRegistro['correcto'] . "
                                                    WHERE numDocumento = " . $arrRegistro['incorrecto'] . ";
                                                 ";
                                            $aptBd->execute($sql);
                                            $txtCambios .= "numDocumento, Valor Anterior: " . $arrRegistro['incorrecto'] . ", Valor Nuevo: " . $arrRegistro['correcto'] . "\n";
                                            break;
                                    }
                                }
                            }
                            break;
                        case 3: // inhabilidades

                            $arrEtapa = obtenerDatosTabla("T_FRM_ESTADO_PROCESO", array("seqEstadoProceso", "seqEtapa"), "seqEstadoProceso", "seqEstadoProceso = " . $objFormulario->seqEstadoProceso);
                            $seqEtapa = $arrEtapa[$objFormulario->seqEstadoProceso];
                            //$seqEstadoProceso = ( $seqEtapa == 1 ) ? 52 : 8;                    
                            
                            //Corrige para cargue de Postulados-inhabilitados Cambio 22-07-2016 Ing Hector Matamoros
                            if ($seqEtapa <= 2 && $objFormulario->bolCerrado == 0) {
                                $seqEstadoProceso = 52;
                            } else {
                                if ($seqEtapa >= 2 && $objFormulario->bolCerrado == 1) {
                                    $seqEstadoProceso = 8;
                                }
                                
                            }

                            /* $sql = "
                              UPDATE T_FRM_FORMULARIO SET
                              seqEstadoProceso = $seqEstadoProceso
                              WHERE seqFormulario = " . $objFormulario->seqFormulario . "
                              "; */

                             $sql = "
                                    UPDATE T_FRM_FORMULARIO SET
                                       seqEstadoProceso = $seqEstadoProceso, 
                                           txtDireccionSolucion =  '',
                                            seqUnidadProyecto =1,
                                            txtMatriculaInmobiliaria =  '',
                                            txtChip =  ''
                                    WHERE seqFormulario = " . $objFormulario->seqFormulario . "
                                 ";
                            $sql2 = "UPDATE T_PRY_UNIDAD_PROYECTO 
                                        SET seqFormulario = null 
                                        WHERE seqFormulario =" . $objFormulario->seqFormulario . ";";
                            $aptBd->execute($sql);
                            $aptBd->execute($sql2);

                            break;
                        case 4:  // recursos de reposicion                     
                            $txtCambios .= "seqEstadoProceso, Valor Anterior: " . $objFormulario->seqEstadoProceso .
                                    ", Valor Nuevo: " . $arrFormularios['datos'][$numDocumento]['estado'] . "\n";
                            $sql = "
                                    UPDATE T_FRM_FORMULARIO SET
                                       seqEstadoProceso = $seqNuevoEstado
                                    WHERE seqFormulario = " . $objFormulario->seqFormulario . "
                                 ";
                            $aptBd->execute($sql);
                            break;
                        case 6: // Renuncias
                            $txtCambios .= "seqEstadoProceso, Valor Anterior: " . $objFormulario->seqEstadoProceso . ", Valor Nuevo: 18\n";
                            $sql = "
                                    UPDATE T_FRM_FORMULARIO SET
                                       seqEstadoProceso = 18
                                    WHERE seqFormulario = " . $objFormulario->seqFormulario . "
                                 ";
                            $aptBd->execute($sql);
                            break;
                        case 9: // Perdida
                            $txtCambios .= "seqEstadoProceso, Valor Anterior: " . $objFormulario->seqEstadoProceso . ", Valor Nuevo: 21\n";
                            $sql = "
										UPDATE T_FRM_FORMULARIO SET
											seqEstadoProceso = 21, 
											txtDireccionSolucion = '',
											seqProyecto = 37,
											fchVigencia = '',
											seqProyectoHijo = 0,
											seqUnidadProyecto = 1,
											txtMatriculaInmobiliaria = '',
											txtChip = '',
											valAvaluo = 0,
											valTotal = 0
										WHERE 
											seqFormulario = " . $objFormulario->seqFormulario . "
										";
                            $sql2 = "UPDATE T_PRY_UNIDAD_PROYECTO 
                                        SET seqFormulario = null 
                                        WHERE seqFormulario =" . $objFormulario->seqFormulario . ";";
                            $aptBd->execute($sql);
                            $aptBd->execute($sql2);
                            break;
                        case 10: // Revocatoria
                            $txtCambios .= "seqEstadoProceso, Valor Anterior: " . $objFormulario->seqEstadoProceso . ", Valor Nuevo: 37\n";
                            $sql = "
                                    UPDATE T_FRM_FORMULARIO SET
                                       seqEstadoProceso = 37, 
									   txtDireccionSolucion = '',
									   seqUnidadProyecto = 1,
									   seqTipoEsquema = 0,
									   bolCerrado = 0,
									   txtMatriculaInmobiliaria = '',
									   txtChip = '',
									   valAvaluo = 0,
									   valTotal = 0
                                    WHERE seqFormulario = " . $objFormulario->seqFormulario . "
                                 ";
                            $sql2 = "UPDATE T_PRY_UNIDAD_PROYECTO 
                                        SET seqFormulario = null 
                                        WHERE seqFormulario =" . $objFormulario->seqFormulario . ";";
                            $aptBd->execute($sql);
                            $aptBd->execute($sql2);
                            break;
                        case 11:  // Exclusion
                            $txtCambios .= "seqEstadoProceso, Valor Anterior: " . $objFormulario->seqEstadoProceso . ", Valor Nuevo: " . $arrFormularios['datos'][$numDocumento]['estado'] . " \n ";
                            $adicionComentario = $arrFormularios['datos'][$numDocumento]['comentario'] . ".";
                            $sql = "
                                    UPDATE T_FRM_FORMULARIO SET
                                       seqEstadoProceso = " . $arrFormularios['datos'][$numDocumento]['estado'] . " ,
									   seqTipoEsquema = 8,
									   bolCerrado = 1
                                    WHERE seqFormulario = " . $objFormulario->seqFormulario . "
                                 ";
                            $aptBd->execute($sql);
                            break;
                        case 8: // indexacion
                            $valAspiraSubsidio = ( $objFormulario->valAspiraSubsidio + $arrFormularios['datos'][$numDocumento]['valor'] );
                            $txtCambios .= "valAspiraSubsidio, Valor Anterior: " . $objFormulario->valAspiraSubsidio . ", Valor Nuevo: $valAspiraSubsidio\n";
                            $sql = "
                                    UPDATE T_FRM_FORMULARIO SET
                                       valAspiraSubsidio = $valAspiraSubsidio
                                    WHERE seqFormulario = " . $objFormulario->seqFormulario . "
                                 ";
                            $aptBd->execute($sql);
                            break;
                    }

                    $txtTipoActo = obtenerCampo("T_AAD_TIPO_ACTO", $arrActo['seqTipoActo'], "txtNombreTipoActo", "seqTipoActo");

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
                               " . $objFormulario->seqFormulario . ",
                               NOW(),
                               " . $_SESSION['seqUsuario'] . ",
                               'Vinculado a la " . $txtTipoActo . " número " . $arrActo['numActo'] . " del " . $arrActo['fchActo'] . ". " . $adicionComentario . "',
                               '$txtCambios',
                               $numDocumentoPrincipal,
                               '$txtNombrePrincipal',
                               46
                            )
                         ";
                    $aptBd->execute($sql);
                }
            } // fin foreach formularios
        }
    }

    /**
     * OBTIENE EL SECUENCIAL DEL FORMULARIO EN EL MODULO DE ACTOS ADMINISTRATIVOS
     * DE UNA CEDULA DENTRO DE UN NUMERO Y FECHA DE ACTO ADMINISTRATIVO
     * @global handler $aptBd
     * @param INT $numActo
     * @param DATE $fchActo
     * @param INT $seqFormulario
     * @return int $seqFormularioActo
     */
    public function obtenerSecuencial($numActo, $fchActo, $seqFormulario) {
        global $aptBd;
        try {
            $sql = "
                   SELECT 
                      hvi.seqFormularioActo
                   FROM T_AAD_HOGARES_VINCULADOS hvi
                   INNER JOIN T_AAD_FORMULARIO_ACTO FAC ON hvi.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_AAD_HOGAR_ACTO HAC ON fac.seqFormularioActo = hac.seqFormularioActo
                   INNER JOIN T_AAD_CIUDADANO_ACTO CAC ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                   WHERE fac.seqFormulario = $seqFormulario
                   AND hvi.numActo = $numActo
                   AND hvi.fchActo = '$fchActo'
                ";
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $seqFormularioActo = $objRes->fields['seqFormularioActo'];
            } else {
                $seqFormularioActo = 0;
            }
        } catch (Exception $objError) {
            $seqFormularioActo = 0;
        }
        return $seqFormularioActo;
    }

    public function cronologia($numDocumento) {
        $arrInformacion = array();
        $arrActos = $this->cargarActoAdministrativo(0, null, array($numDocumento));
        //var_dump($arrActos);
        $seqFormulario = $this->documento2formulario($numDocumento);
        $arrActosExistentes = array_keys($arrActos);
        foreach ($arrActos as $txtClave => $objActo) {
            $txtNombreActo = obtenerCampo("T_AAD_TIPO_ACTO", $objActo->seqTipoActo, "txtNombreTipoActo", "seqTipoActo");
            $txtFechaActo = ucwords(strftime("%d de %B de %Y", strtotime($objActo->fchActo)));
            switch ($objActo->seqTipoActo) {
                case 1: // Asignacion
                    $arrActos[$txtClave]->obtenerGiros($seqFormulario);
                    $arrInformacion[$txtClave]['acto']['tipo'] = $objActo->seqTipoActo;
                    $arrInformacion[$txtClave]['acto']['nombre'] = $txtNombreActo;
                    $arrInformacion[$txtClave]['acto']['numero'] = $objActo->numActo;
                    $arrInformacion[$txtClave]['acto']['fecha'] = $txtFechaActo;
                    $arrInformacion[$txtClave]['acto']['marca'] = strtotime($objActo->fchActo);
                    $arrInformacion[$txtClave]['acto']['giros'] = $objActo->valTotalGiros;
                    $arrMasInformacion = array_shift($arrActos[$txtClave]->arrMasInformacion);
                    $arrInformacion[$txtClave]['acto']['valor'] = $arrMasInformacion['valAspiraSubsidio'];
                    $arrInformacion[$txtClave]['acto']['seqformActo'] = $objActo->seqformActo;
                    $arrInformacion[$txtClave]['acto']['seqEstadoProceso'] = $objActo->seqEstadoProceso;
                    break;
                case 2: // Modificatoria
                    $arrActos[$txtClave]->obtenerModificaciones($seqFormulario);
                    $txtActoRelacionado = $objActo->arrCaracteristicas[4] . strtotime($objActo->arrCaracteristicas[7]);
                    if (in_array($txtActoRelacionado, $arrActosExistentes)) {
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['tipo'] = $objActo->seqTipoActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['nombre'] = $txtNombreActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['numero'] = $objActo->numActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['fecha'] = $txtFechaActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['marca'] = strtotime($objActo->fchActo);
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['modificaciones'] = $objActo->arrMasInformacion[$numDocumento]['arrModificaciones'];
                    } else {
                        $arrInformacion[$txtClave]['acto']['tipo'] = $objActo->seqTipoActo;
                        $arrInformacion[$txtClave]['acto']['nombre'] = $txtNombreActo;
                        $arrInformacion[$txtClave]['acto']['numero'] = $objActo->numActo;
                        $arrInformacion[$txtClave]['acto']['fecha'] = $txtFechaActo;
                        $arrInformacion[$txtClave]['acto']['marca'] = strtotime($objActo->fchActo);
                        $arrInformacion[$txtClave]['acto']['modificaciones'] = $objActo->arrMasInformacion[$numDocumento]['arrModificaciones'];
                        $arrInformacion[$txtClave]['acto']['numeroReferencia'] = $objActo->arrCaracteristicas[4];
                        $arrInformacion[$txtClave]['acto']['fechaReferencia'] = $objActo->arrCaracteristicas[7];
                        $arrInformacion[$txtClave]['acto']['seqformActo'] = $objActo->seqformActo;
                        $arrInformacion[$txtClave]['acto']['seqEstadoProceso'] = $objActo->seqEstadoProceso;
                    }
                    break;
                case 3: // inhabilitados
                    $arrActos[$txtClave]->obtenerInhabilidades($seqFormulario);
                    $arrInformacion[$txtClave]['acto']['tipo'] = $objActo->seqTipoActo;
                    $arrInformacion[$txtClave]['acto']['nombre'] = $txtNombreActo;
                    $arrInformacion[$txtClave]['acto']['numero'] = $objActo->numActo;
                    $arrInformacion[$txtClave]['acto']['fecha'] = $txtFechaActo;
                    $arrInformacion[$txtClave]['acto']['marca'] = strtotime($objActo->fchActo);
                    $arrMasInformacion = array_shift($objActo->arrMasInformacion);
                    $arrInformacion[$txtClave]['acto']['inhabilidades'] = $arrMasInformacion['arrInhabilidades'];
                    break;
                case 4: // recursos de reposicion
                    $arrActos[$txtClave]->obtenerResultado($seqFormulario);
                    $txtActoRelacionado = $objActo->arrCaracteristicas[5] . strtotime($objActo->arrCaracteristicas[6]);
                    if (in_array($txtActoRelacionado, $arrActosExistentes)) {
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['tipo'] = $objActo->seqTipoActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['nombre'] = $txtNombreActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['numero'] = $objActo->numActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['fecha'] = $txtFechaActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['marca'] = strtotime($objActo->fchActo);
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['resultado'] = $objActo->arrMasInformacion[$numDocumento]['txtEstadoReposicion'];
                    } else {
                        $arrInformacion[$txtClave]['acto']['tipo'] = $objActo->seqTipoActo;
                        $arrInformacion[$txtClave]['acto']['nombre'] = $txtNombreActo;
                        $arrInformacion[$txtClave]['acto']['numero'] = $objActo->numActo;
                        $arrInformacion[$txtClave]['acto']['fecha'] = $txtFechaActo;
                        $arrInformacion[$txtClave]['acto']['marca'] = strtotime($objActo->fchActo);
                        $arrInformacion[$txtClave]['acto']['resultado'] = $objActo->arrMasInformacion[$numDocumento]['txtEstadoReposicion'];
                        $arrInformacion[$txtClave]['acto']['numeroReferencia'] = $objActo->arrCaracteristicas[5];
                        $arrInformacion[$txtClave]['acto']['fechaReferencia'] = $objActo->arrCaracteristicas[6];
                        $arrInformacion[$txtClave]['acto']['seqformActo'] = $objActo->seqformActo;
                        $arrInformacion[$txtClave]['acto']['seqEstadoProceso'] = $objActo->seqEstadoProceso;
                    }
                    break;
                case 5: // no asignados
                    $arrActos[$txtClave]->obtenerNoAsignados($seqFormulario);
                    $arrInformacion[$txtClave]['acto']['tipo'] = $objActo->seqTipoActo;
                    $arrInformacion[$txtClave]['acto']['nombre'] = $txtNombreActo;
                    $arrInformacion[$txtClave]['acto']['numero'] = $objActo->numActo;
                    $arrInformacion[$txtClave]['acto']['fecha'] = $txtFechaActo;
                    $arrInformacion[$txtClave]['acto']['marca'] = strtotime($objActo->fchActo);
                    break;
                case 6: // renuncias
                    $arrActos[$txtClave]->obtenerRenuncias($seqFormulario);
                    $txtActoRelacionado = $objActo->arrCaracteristicas[18] . strtotime($objActo->arrCaracteristicas[19]);
                    if (in_array($txtActoRelacionado, $arrActosExistentes)) {
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['tipo'] = $objActo->seqTipoActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['nombre'] = $txtNombreActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['numero'] = $objActo->numActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['fecha'] = $txtFechaActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['marca'] = strtotime($objActo->fchActo);
                    } else {
                        $arrInformacion[$txtClave]['acto']['tipo'] = $objActo->seqTipoActo;
                        $arrInformacion[$txtClave]['acto']['nombre'] = $txtNombreActo;
                        $arrInformacion[$txtClave]['acto']['numero'] = $objActo->numActo;
                        $arrInformacion[$txtClave]['acto']['fecha'] = $txtFechaActo;
                        $arrInformacion[$txtClave]['acto']['marca'] = strtotime($objActo->fchActo);
                        $arrInformacion[$txtClave]['acto']['numeroReferencia'] = $objActo->arrCaracteristicas[18];
                        $arrInformacion[$txtClave]['acto']['fechaReferencia'] = $objActo->arrCaracteristicas[19];
                        $arrInformacion[$txtClave]['acto']['seqformActo'] = $objActo->seqformActo;
                        $arrInformacion[$txtClave]['acto']['seqEstadoProceso'] = $objActo->seqEstadoProceso;
                    }
                    break;
                case 9: // perdidas
                    $arrActos[$txtClave]->obtenerPerdidas($seqFormulario);
                    $txtActoRelacionado = $objActo->arrCaracteristicas[49] . strtotime($objActo->arrCaracteristicas[50]);
                    if (in_array($txtActoRelacionado, $arrActosExistentes)) {
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['tipo'] = $objActo->seqTipoActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['nombre'] = $txtNombreActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['numero'] = $objActo->numActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['fecha'] = $txtFechaActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['marca'] = strtotime($objActo->fchActo);
                    } else {
                        $arrInformacion[$txtClave]['acto']['tipo'] = $objActo->seqTipoActo;
                        $arrInformacion[$txtClave]['acto']['nombre'] = $txtNombreActo;
                        $arrInformacion[$txtClave]['acto']['numero'] = $objActo->numActo;
                        $arrInformacion[$txtClave]['acto']['fecha'] = $txtFechaActo;
                        $arrInformacion[$txtClave]['acto']['marca'] = strtotime($objActo->fchActo);
                        $arrInformacion[$txtClave]['acto']['numeroReferencia'] = $objActo->arrCaracteristicas[49];
                        $arrInformacion[$txtClave]['acto']['fechaReferencia'] = $objActo->arrCaracteristicas[50];
                        $arrInformacion[$txtClave]['acto']['seqformActo'] = $objActo->seqformActo;
                        $arrInformacion[$txtClave]['acto']['seqEstadoProceso'] = $objActo->seqEstadoProceso;
                    }
                    break;
                case 10: // revocatorias
                    $arrActos[$txtClave]->obtenerRevocatorias($seqFormulario);
                    $txtActoRelacionado = $objActo->arrCaracteristicas[91] . strtotime($objActo->arrCaracteristicas[92]);
                    if (in_array($txtActoRelacionado, $arrActosExistentes)) {
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['tipo'] = $objActo->seqTipoActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['nombre'] = $txtNombreActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['numero'] = $objActo->numActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['fecha'] = $txtFechaActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['marca'] = strtotime($objActo->fchActo);
                    } else {
                        $arrInformacion[$txtClave]['acto']['tipo'] = $objActo->seqTipoActo;
                        $arrInformacion[$txtClave]['acto']['nombre'] = $txtNombreActo;
                        $arrInformacion[$txtClave]['acto']['numero'] = $objActo->numActo;
                        $arrInformacion[$txtClave]['acto']['fecha'] = $txtFechaActo;
                        $arrInformacion[$txtClave]['acto']['marca'] = strtotime($objActo->fchActo);
                        $arrInformacion[$txtClave]['acto']['numeroReferencia'] = $objActo->arrCaracteristicas[91];
                        $arrInformacion[$txtClave]['acto']['fechaReferencia'] = $objActo->arrCaracteristicas[92];
                        $arrInformacion[$txtClave]['acto']['seqformActo'] = $objActo->seqformActo;
                        $arrInformacion[$txtClave]['acto']['seqEstadoProceso'] = $objActo->seqEstadoProceso;
                    }
                    break;
                case 11: // Exclusion
                    $arrActos[$txtClave]->obtenerResultado($seqFormulario);
                    $txtActoRelacionado = $objActo->arrCaracteristicas[140] . strtotime($objActo->arrCaracteristicas[141]);
                    if (in_array($txtActoRelacionado, $arrActosExistentes)) {
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['tipo'] = $objActo->seqTipoActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['nombre'] = $txtNombreActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['numero'] = $objActo->numActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['fecha'] = $txtFechaActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['marca'] = strtotime($objActo->fchActo);
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['resultado'] = $objActo->arrMasInformacion[$numDocumento]['txtEstadoReposicion'];
                    } else {
                        $arrInformacion[$txtClave]['acto']['tipo'] = $objActo->seqTipoActo;
                        $arrInformacion[$txtClave]['acto']['nombre'] = $txtNombreActo;
                        $arrInformacion[$txtClave]['acto']['numero'] = $objActo->numActo;
                        $arrInformacion[$txtClave]['acto']['fecha'] = $txtFechaActo;
                        $arrInformacion[$txtClave]['acto']['marca'] = strtotime($objActo->fchActo);
                        $arrInformacion[$txtClave]['acto']['resultado'] = $objActo->arrMasInformacion[$numDocumento]['txtEstadoReposicion'];
                        $arrInformacion[$txtClave]['acto']['numeroReferencia'] = $objActo->arrCaracteristicas[140];
                        $arrInformacion[$txtClave]['acto']['fechaReferencia'] = $objActo->arrCaracteristicas[141];
                        $arrInformacion[$txtClave]['acto']['seqformActo'] = $objActo->seqformActo;
                        $arrInformacion[$txtClave]['acto']['seqEstadoProceso'] = $objActo->seqEstadoProceso;
                    }
                    break;
                case 7: // notificaciones
                    $arrActos[$txtClave]->obtenerNotificaciones($seqFormulario);
                    $txtActoNotificado = $arrActos[$txtClave]->arrMasInformacion[$numDocumento]['numero'] . strtotime($arrActos[$txtClave]->arrMasInformacion[$numDocumento]['fecha']);
                    if (in_array($txtActoNotificado, $arrActosExistentes)) {
                        switch ($arrActos[$txtActoNotificado]->seqTipoActo) {
                            case 2:
                                $txtActoRelacionado = $arrActos[$txtActoNotificado]->arrCaracteristicas[4] . strtotime($arrActos[$txtActoNotificado]->arrCaracteristicas[7]);
                                break;
                            case 4:
                                $txtActoRelacionado = $arrActos[$txtActoNotificado]->arrCaracteristicas[5] . strtotime($arrActos[$txtActoNotificado]->arrCaracteristicas[6]);
                                break;
                            case 6:
                                $txtActoRelacionado = $arrActos[$txtActoNotificado]->arrCaracteristicas[18] . strtotime($arrActos[$txtActoNotificado]->arrCaracteristicas[19]);
                                break;
                            case 9:
                                $txtActoRelacionado = $arrActos[$txtActoNotificado]->arrCaracteristicas[18] . strtotime($arrActos[$txtActoNotificado]->arrCaracteristicas[19]);
                                break;
                            case 8:
                                $arrActos[$txtActoNotificado]->obtenerIndexacion($numDocumento);
                                $txtActoRelacionado = $arrActos[$txtActoNotificado]->arrMasInformacion[$numDocumento]['numActoReferencia'] . strtotime($arrActos[$txtActoNotificado]->arrMasInformacion[$numDocumento]['fchActoReferencia']);
                                break;
                            default:
                                $txtActoRelacionado = "";
                                break;
                        }
                        if (in_array($txtActoRelacionado, $arrActosExistentes)) {
                            $arrInformacion[$txtActoRelacionado]['relacionado'][$txtActoNotificado]['notificado'] = $txtFechaActo;
                        } else {
                            $arrInformacion[$txtActoNotificado]['notificado'] = $txtFechaActo;
                        }
                    } else {
                        $arrInformacion[$txtClave]['acto']['tipo'] = $objActo->seqTipoActo;
                        $arrInformacion[$txtClave]['acto']['nombre'] = $txtNombreActo;
                        $arrInformacion[$txtClave]['acto']['numero'] = $objActo->numActo;
                        $arrInformacion[$txtClave]['acto']['fecha'] = $txtFechaActo;
                        $arrInformacion[$txtClave]['acto']['numeroReferencia'] = $arrActos[$txtClave]->arrMasInformacion[$numDocumento]['numero'];
                        $arrInformacion[$txtClave]['acto']['fechaReferencia'] = $arrActos[$txtClave]->arrMasInformacion[$numDocumento]['fecha'];
                    }
                    break;
                case 8:
                    $arrActos[$txtClave]->obtenerIndexacion($seqFormulario);
                    $txtActoRelacionado = $arrActos[$txtClave]->arrMasInformacion[$numDocumento]['numActoReferencia'] . strtotime($arrActos[$txtClave]->arrMasInformacion[$numDocumento]['fchActoReferencia']);
                    if (in_array($txtActoRelacionado, $arrActosExistentes)) {
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['tipo'] = $objActo->seqTipoActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['nombre'] = $txtNombreActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['numero'] = $objActo->numActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['fecha'] = $txtFechaActo;
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['marca'] = strtotime($objActo->fchActo);
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['indexacion'] = intval($arrActos[$txtClave]->arrMasInformacion[$numDocumento]['valIndexado']);
                        $arrInformacion[$txtActoRelacionado]['relacionado'][$txtClave]['caracteristicas'] = $arrActos[$txtClave]->arrCaracteristicas;
                    } else {
                        $arrInformacion[$txtClave]['acto']['tipo'] = $objActo->seqTipoActo;
                        $arrInformacion[$txtClave]['acto']['nombre'] = $txtNombreActo;
                        $arrInformacion[$txtClave]['acto']['numero'] = $objActo->numActo;
                        $arrInformacion[$txtClave]['acto']['fecha'] = $txtFechaActo;
                        $arrInformacion[$txtClave]['acto']['marca'] = strtotime($objActo->fchActo);
                        $arrInformacion[$txtClave]['acto']['indexacion'] = intval($arrActos[$txtClave]->arrMasInformacion[$numDocumento]['valIndexado']);
                        $arrInformacion[$txtClave]['acto']['caracteristicas'] = $arrActos[$txtClave]->arrCaracteristicas;
                        $arrInformacion[$txtClave]['acto']['numeroReferencia'] = $arrActos[$txtClave]->arrMasInformacion[$numDocumento]['numActoReferencia'];
                        $arrInformacion[$txtClave]['acto']['fechaReferencia'] = $arrActos[$txtClave]->arrMasInformacion[$numDocumento]['fchActoReferencia'];
                        $arrInformacion[$txtClave]['acto']['seqformActo'] = $objActo->seqformActo;
                        $arrInformacion[$txtClave]['acto']['seqEstadoProceso'] = $objActo->seqEstadoProceso;
                    }
                    break;
            }
        }
        return $arrInformacion;
    }

    private function documento2formulario($numDocumento) {
        global $aptBd;
        if (intval($numDocumento) != 0) {
            $sql = "
                    SELECT frm.seqFormulario
                    FROM T_FRM_FORMULARIO frm
                    INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
                    INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
                    WHERE ciu.numDocumento = $numDocumento
                ";
            $objRes = $aptBd->execute($sql);
            return $objRes->fields['seqFormulario'];
        } else {
            return 0;
        }
    }

    /*     * ******************************************************************************************** */

    //Función Creada por Ing Liliana Basto  para obtener el proceso de cada acto  
    /*     * ******************************************************************************************** */

    function estadosProcesoActo($seqEstadoProceso) {

        global $aptBd;
        $arrEstados = array();
        $txtCondicion = ( $seqEstadoProceso != 0 ) ? "AND epr.seqEstadoProceso = $seqEstadoProceso " : "AND epr.seqEstadoProceso = 0";
        $sql = "
			SELECT 
			  epr.seqEstadoProceso, 
			  concat( eta.txtEtapa , ' - ' , epr.txtEstadoProceso ) as txtEstadoProceso
			FROM
			  T_FRM_ETAPA eta,
			  T_FRM_ESTADO_PROCESO epr
			WHERE eta.seqEtapa = epr.seqEtapa
			$txtCondicion	    	
    	";

        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {
            while ($objRes->fields) {

                $arrEstados[$objRes->fields['seqEstadoProceso']] = "<strong>" . $objRes->fields['txtEstadoProceso'] . "<strong>";

                $objRes->MoveNext();
            }
        } else {
            $arrEstados[$seqEstadoProceso] = "<strong> No se encontró procesos</strong>";
        }

        return $arrEstados;
    }

}

// fin clase ActoAdministrativo
?>
