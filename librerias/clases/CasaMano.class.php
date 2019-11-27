<?php

/**
 * CLASE PARA LA INSCRIPCION / POSTULACION / ASIGNACION DE
 * EL ESQUEMA DE CASA EN MANO
 */
class CasaMano {

    public $arrFases;
    public $seqCasaMano;
    public $seqFormulario;
    public $fchRegistroVivienda;
    public $bolRevisionJuridica;
    public $fchRevisionJuridica;
    public $numDiasRevisionJuridica;
    public $txtRevisionJuridica;
    public $numDiasLimiteRevsionJuridica;
    public $bolRevisionTecnica;
    public $fchRevisionTecnica;
    public $numDiasRevisionTecnica;
    public $txtRevisionTecnica;
    public $numDiasLimiteRevsionTecnica;
    public $bolPrimeraVerificacion;
    public $fchPrimeraVerificacion;
    public $seqPrimeraVerificacion;
    public $fchPostulacion;
    public $bolSegundaVerificacion;
    public $fchSegundaVerificacion;
    public $seqSegundaVerificacion;
    public $objRegistroOferta;
    public $objRevisionJuridica;
    public $objRevisionTecnica;
    public $objPostulacion;
    public $objPrimeraVerificacion;
    public $objSegundaVerificacion;
    public $arrMensajes;
    public $arrErrores;

    function CasaMano() {

        $this->arrFases = array();

        // postulacion individual
        // proyectos de la SDHT

        $this->arrFases['pin']['modalidad'] = array(1, 2, 3, 4, 5, 6, 7, 9, 12, 13, 11);
        $this->arrFases['pin']['esquema'] = array(0, 1, 2, 3, 4, 6, 7, 8, 9, 12, 14, 16, 17, 18, null);

        $this->arrFases['pin']['postulacion']['grupos'] = array(6, 7, 8);
        $this->arrFases['pin']['postulacion']['permitido']['etapas'] = array(2, 3, 4, 5);
        $this->arrFases['pin']['postulacion']['permitido']['estados'] = array();
        $this->arrFases['pin']['postulacion']['prohibido']['etapas'] = array(1);
        $this->arrFases['pin']['postulacion']['prohibido']['estados'] = array();
        $this->arrFases['pin']['postulacion']['atras'] = array(46, 37);
        $this->arrFases['pin']['postulacion']['adelante'] = array(46, 6, 47);
        $this->arrFases['pin']['postulacion']['salvar'] = "./contenidos/casaMano/salvarPostulacion.php";
        $this->arrFases['pin']['postulacion']['plantilla'] = "casaMano/postulacion.tpl";

        // proyectos fuera de la SDHT
        // retorno o reubicación
        $this->arrFases['cem']['modalidad'] = array(6, 11, 12);
        $this->arrFases['cem']['esquema'] = array(5, 6, 10, 11, 13, 15);

        $this->arrFases['cem']['panelHogar']['grupos'] = array(6, 7, 8, 14, 13);
        $this->arrFases['cem']['panelHogar']['permitido']['etapas'] = array(1, 2, 3, 4, 5);
        $this->arrFases['cem']['panelHogar']['permitido']['estados'] = array();
        $this->arrFases['cem']['panelHogar']['prohibido']['etapas'] = array();
        $this->arrFases['cem']['panelHogar']['prohibido']['estados'] = array();
        $this->arrFases['cem']['panelHogar']['plantilla'] = "casaMano/casaMano.tpl";

        $this->arrFases['cem']['registroOferta']['grupos'] = array(6, 7, 8, 14, 13);
        $this->arrFases['cem']['registroOferta']['permitido']['etapas'] = array();
        $this->arrFases['cem']['registroOferta']['permitido']['estados'] = array(37, 53, 43, 44, 45, 46, 47, 48, 15, 16);
        $this->arrFases['cem']['registroOferta']['prohibido']['etapas'] = array();
        $this->arrFases['cem']['registroOferta']['prohibido']['estados'] = array();
        $this->arrFases['cem']['registroOferta']['atras'] = array();
        $this->arrFases['cem']['registroOferta']['adelante'] = array(37, 53, 43, 44);
        $this->arrFases['cem']['registroOferta']['salvar'] = "./contenidos/casaMano/salvarRegistroOferta.php";
        $this->arrFases['cem']['registroOferta']['plantilla'] = "casaMano/busquedaOferta.tpl";

        $this->arrFases['cem']['revisionJuridica']['grupos'] = array(13, 7, 8);
        $this->arrFases['cem']['revisionJuridica']['permitido']['etapas'] = array();
        $this->arrFases['cem']['revisionJuridica']['permitido']['estados'] = array(44, 45, 46, 47, 48, 15, 16);
        $this->arrFases['cem']['revisionJuridica']['prohibido']['etapas'] = array();
        $this->arrFases['cem']['revisionJuridica']['prohibido']['estados'] = array();
        $this->arrFases['cem']['revisionJuridica']['atras'] = array(37, 43);
        $this->arrFases['cem']['revisionJuridica']['adelante'] = array(44);
        $this->arrFases['cem']['revisionJuridica']['salvar'] = "./contenidos/casaMano/salvarRevisionJuridica.php";
        $this->arrFases['cem']['revisionJuridica']['plantilla'] = "desembolso/revisionJuridica.tpl";

        $this->arrFases['cem']['revisionTecnica']['grupos'] = array(14, 7, 8);
        $this->arrFases['cem']['revisionTecnica']['permitido']['etapas'] = array();
        $this->arrFases['cem']['revisionTecnica']['permitido']['estados'] = array(44, 45, 46, 47, 48, 15, 16);
        $this->arrFases['cem']['revisionTecnica']['prohibido']['etapas'] = array();
        $this->arrFases['cem']['revisionTecnica']['prohibido']['estados'] = array();
        $this->arrFases['cem']['revisionTecnica']['atras'] = array(37, 43);
        $this->arrFases['cem']['revisionTecnica']['adelante'] = array(44);
        $this->arrFases['cem']['revisionTecnica']['salvar'] = "./contenidos/casaMano/salvarRevisionTecnica.php";
        $this->arrFases['cem']['revisionTecnica']['plantilla'] = "desembolso/revisionTecnica.tpl";

        $this->arrFases['cem']['postulacion']['grupos'] = array(6, 7, 8);
        $this->arrFases['cem']['postulacion']['permitido']['etapas'] = array(2, 3, 4, 5);
        $this->arrFases['cem']['postulacion']['permitido']['estados'] = array();
        $this->arrFases['cem']['postulacion']['prohibido']['etapas'] = array(1);
        $this->arrFases['cem']['postulacion']['prohibido']['estados'] = array();
        $this->arrFases['cem']['postulacion']['atras'] = array(37, 46);
        $this->arrFases['cem']['postulacion']['adelante'] = array(46, 6, 47);
        $this->arrFases['cem']['postulacion']['salvar'] = "./contenidos/casaMano/salvarPostulacion.php";
        $this->arrFases['cem']['postulacion']['plantilla'] = "casaMano/postulacion.tpl";

        // este fnciona para mirar los permisos de quienes pueden obtener los pdf
        $this->arrFases['cem']['exportarPdf']['grupos'] = array(6, 8, 14);
        $this->arrFases['cem']['habitabilidadPdf']['grupos'] = array(6, 8, 14);

        $this->seqCasaMano = 0;
        $this->seqFormulario = 0;
        $this->fchRegistroVivienda = null;

        $this->bolRevisionJuridica = null;
        $this->fchRevisionJuridica = null;
        $this->numDiasRevisionJuridica = 0;
        $this->txtRevisionJuridica = "";
        $this->numDiasLimiteRevsionJuridica = 60;

        $this->bolRevisionTecnica = null;
        $this->fchRevisionTecnica = null;
        $this->numDiasRevisionTecnica = 0;
        $this->txtRevisionTecnica = "";
        $this->numDiasLimiteRevsionTecnica = 60;

        $this->bolPrimeraVerificacion = null;
        $this->fchPrimeraVerificacion = null;
        $this->seqPrimeraVerificacion = null;
        $this->fchPostulacion = null;
        $this->bolSegundaVerificacion = null;
        $this->fchSegundaVerificacion = null;
        $this->seqSegundaVerificacion = null;

        $this->objRegistroOferta = null;
        $this->objRevisionJuridica = null;
        $this->objRevisionTecnica = null;
        $this->objPostulacion = null;
        $this->objPrimeraVerificacion = null;
        $this->objSegundaVerificacion = null;

        $this->arrErrores = array();
        $this->arrMensajes = array();
    }

    /**
     * CARGA TODOS LOS DATOS DEL REGISTRO DE CASA EN MANO
     * @global object $aptBd // apuntador base de datos
     * @param integer $seqFormulario // identificador del formulario
     * @param integer $seqCasaMano // identificador de casa en mano
     * @return array arrCasaMano     // arreglo que tiene todos los registros de casa en mano para un hogar
     */
    function cargar($seqFormulario, $seqCasaMano = 0) {
        global $aptBd;
        $arrCasaMano = array();

        try {

            $txtCondicion = "";
            $txtCondicion .= (intval($seqFormulario) != 0) ? "AND seqFormulario = " . $seqFormulario . " " : "";
            $txtCondicion .= (intval($seqCasaMano) != 0) ? "AND seqCasaMano   = " . $seqCasaMano . " " : "";

            $sql = "
                 SELECT 
                     seqCasaMano,
                     seqFormulario,
                     fchRegistroVivienda,
                     bolRevisionJuridica,
                     fchRevisionJuridica,
                     txtRevisionJuridica,
                     bolRevisionTecnica,
                     fchRevisionTecnica,
                     txtRevisionTecnica,
                     bolPrimeraVerificacion,
                     fchPrimeraVerificacion,
                     seqPrimeraVerificacion,
                     fchPostulacion,
                     bolSegundaVerificacion,
                     fchSegundaVerificacion,
                     seqSegundaVerificacion
                 FROM T_CEM_CASA_MANO
                 WHERE 1 = 1 $txtCondicion
             ";

            $objRes = $aptBd->execute($sql);
            if ($objRes->RecordCount() == 0) {
                $objCasaMano = new CasaMano();
                $objCasaMano->seqFormulario = $seqFormulario;
                $objCasaMano->cargarPostulacion();
                $arrCasaMano[0] = $objCasaMano;
            } else {
                while ($objRes->fields) {

                    $objCasaMano = new CasaMano();
                    foreach ($objRes->fields as $txtCampo => $txtValor) {
                        $objCasaMano->$txtCampo = $txtValor;
                    }

                    if (strtotime($objCasaMano->fchRevisionJuridica) != 0) {
                        $objCasaMano->numDiasRevisionJuridica = intval((time() - strtotime($objCasaMano->fchRevisionJuridica)) / 86400);
                    }

                    if (strtotime($objCasaMano->fchRevisionTecnica) != 0) {
                        $objCasaMano->numDiasRevisionTecnica = intval((time() - strtotime($objCasaMano->fchRevisionTecnica)) / 86400);
                    }

                    $objCasaMano->cargarRegistroOferta();
                    $objCasaMano->cargarRevisionJuridica();
                    $objCasaMano->cargarRevisionTecnica();
                    $objCasaMano->cargarPostulacion();
                    $objCasaMano->cargarPrimeraVerificacion();
                    $objCasaMano->cargarSegundaVerificacion();

                    $arrCasaMano[$objRes->fields['seqCasaMano']] = $objCasaMano;

                    $objRes->MoveNext();
                }
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = $objError->msg;
        }

        return $arrCasaMano;
    }

    public function cargarRegistroOferta() {
        global $aptBd;

        try {
            $sql = "
                 SELECT 
                    bolPoseedor,
                    bolViabilizoJuridico,
                    bolviabilizoTecnico,
                    fchActualizacion,
                    fchCreacion,
                    fchEscritura,
                    fchResolucion,
                    fchSentencia,
                    numActaEntrega,
                    numAltoRiesgo,
                    numAperturaCAP,
                    numAreaConstruida,
                    numAreaLote,
                    numAutorizacionDesembolso,
                    numAvaluo,
                    numBoletinCatastral,
                    numCartaAsignacion,
                    numCedulaArrendador,
                    numCertificacionVendedor,
                    numCertificadoTradicion,
                    numContratoArrendamiento,
                    numCuentaArrendador,
                    numDocumentoVendedor,
                    numEscrituraPublica,
                    numEstrato,
                    numFotocopiaVendedor,
                    numHabitabilidad,
                    numJuzgado,
                    numLicenciaConstruccion,
                    numNit,
                    numNotaria,
                    numOtros,
                    numResolucion,
                    numRetiroRecursos,
                    numRit,
                    numRut,
                    numServiciosPublicos,
                    numTelefonoVendedor,
                    numTelefonoVendedor2,
                    numUltimoPredial,
                    numUltimoReciboAgua,
                    numUltimoReciboEnergia,
                    numValorInmueble,
                    seqBarrio,
                    seqCasaMano,
                    seqCiudad,
                    seqLocalidad,
                    seqRegistroVivienda,
                    seqTipoDocumento,
                    txtActaEntrega,
                    txtAltoRiesgo,
                    txtAperturaCAP,
                    txtAutorizacionDesembolso,
                    txtBarrio,
                    txtBoletinCatastral,
                    txtCartaAsignacion,
                    txtCedulaArrendador,
                    txtCedulaCatastral,
                    txtCertificacionVendedor,
                    txtCertificadoTradicion,
                    txtChip,
                    txtCiudad,
                    txtCiudadResolucion,
                    txtCiudadSentencia,
                    txtCompraVivienda,
                    txtContratoArrendamiento,
                    txtCorreoVendedor,
                    txtCuentaArrendador,
                    txtDireccionInmueble,
                    txtEntidad,
                    txtEscritura,
                    txtEscrituraPublica,
                    txtFotocopiaVendedor,
                    txtHabitabilidad,
                    txtLicenciaConstruccion,
                    txtMatriculaInmobiliaria,
                    txtNit,
                    txtNombreVendedor,
                    txtOtro,
                    txtPropiedad,
                    txtRetiroRecursos,
                    txtRit,
                    txtRut,
                    txtServiciosPublicos,
                    txtTipoDocumentos,
                    txtTipoPredio,
                    txtUltimoPredial,
                    txtUltimoReciboAgua,
                    txtUltimoReciboEnergia,
                    txtViabilizoJuridico,
                    txtViabilizoTecnico,
                    valInmueble
                 FROM T_CEM_REGISTRO_VIVIENDA
                 WHERE seqCasaMano = " . $this->seqCasaMano . "
             ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $this->objRegistroOferta = array();
                foreach ($objRes->fields as $txtCampo => $txtValor) {
                    $this->objRegistroOferta[$txtCampo] = regularizarCampo($txtCampo, $txtValor);
                }
                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = $objError->msg;
        }
    }

    public function cargarRevisionJuridica() {
        global $aptBd;

        try {
            $sql = "
                 SELECT 
                     seqJuridico,
                     seqCasaMano,
                     numResolucion,
                     fchResolucion,
                     txtObservaciones,
                     txtLibertad,
                     txtConcepto,
                     txtAprobo,
                     fchCreacion,
                     fchActualizacion
                 FROM T_CEM_JURIDICO
                 WHERE seqCasaMano = " . $this->seqCasaMano . "
             ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                foreach ($objRes->fields as $txtCampo => $txtValor) {
                    $this->objRevisionJuridica[$txtCampo] = $txtValor;
                }
                $objRes->MoveNext();
            }

            if (intval($this->objRevisionJuridica['seqJuridico']) != 0) {
                $sql = "
                     SELECT txtAdjunto
                     FROM T_CEM_ADJUNTOS_JURIDICOS
                     WHERE seqJuridico =  " . $this->objRevisionJuridica['seqJuridico'] . "
                     and seqTipoAdjunto = 1
                 ";
                $objRes = $aptBd->execute($sql);
                while ($objRes->fields) {
                    $this->objRevisionJuridica['documento'][] = $objRes->fields['txtAdjunto'];
                    $objRes->MoveNext();
                }

                $sql = "
                     SELECT txtAdjunto
                     FROM T_CEM_ADJUNTOS_JURIDICOS
                     WHERE seqJuridico = " . $this->objRevisionJuridica['seqJuridico'] . "
                     and seqTipoAdjunto = 2
                 ";
                $objRes = $aptBd->execute($sql);
                while ($objRes->fields) {
                    $this->objRevisionJuridica['recomendacion'][] = $objRes->fields['txtAdjunto'];
                    $objRes->MoveNext();
                }
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = $objError->msg;
        }
    }

    public function cargarRevisionTecnica() {
        global $aptBd;
        global $txtPrefijoRuta;

        try {
            $sql = "
                 SELECT 
                     seqTecnico,
                     seqCasaMano,
                     numLargoMultiple,
                     numAnchoMultiple,
                     numAreaMultiple,
                     txtMultiple,
                     numLargoAlcoba1,
                     numAnchoAlcoba1,
                     numAreaAlcoba1,
                     txtAlcoba1,
                     numLargoAlcoba2,
                     numAnchoAlcoba2,
                     numAreaAlcoba2,
                     txtAlcoba2,
                     numLargoAlcoba3,
                     numAnchoAlcoba3,
                     numAreaAlcoba3,
                     txtAlcoba3,
                     numLargoCocina,
                     numAnchoCocina,
                     numAreaCocina,
                     txtCocina,
                     numLargoBano1,
                     numAnchoBano1,
                     numAreaBano1,
                     txtBano1,
                     numLargoBano2,
                     numAnchoBano2,
                     numAreaBano2,
                     txtBano2,
                     numLargoLavanderia,
                     numAnchoLavanderia,
                     numAreaLavanderia,
                     txtLavanderia,
                     numLargoCirculaciones,
                     numAnchoCirculaciones,
                     numAreaCirculaciones,
                     txtCirculaciones,
                     numLargoPatio,
                     numAnchoPatio,
                     numAreaPatio,
                     txtPatio,
                     numAreaTotal,
                     txtEstadoCimentacion,
                     txtCimentacion,
                     txtEstadoPlacaEntrepiso,
                     txtPlacaEntrepiso,
                     txtEstadoMamposteria,
                     txtMamposteria,
                     txtEstadoCubierta,
                     txtCubierta,
                     txtEstadoVigas,
                     txtVigas,
                     txtEstadoColumnas,
                     txtColumnas,
                     txtEstadoPanetes,
                     txtPanetes,
                     txtEstadoEnchapes,
                     txtEnchapes,
                     txtEstadoAcabados,
                     txtAcabados,
                     txtEstadoHidraulicas,
                     txtHidraulicas,
                     txtEstadoElectricas,
                     txtElectricas,
                     txtEstadoSanitarias,
                     txtSanitarias,
                     txtEstadoGas,
                     txtGas,
                     txtEstadoMadera,
                     txtMadera,
                     txtEstadoMetalica,
                     txtMetalica,
                     numLavadero,
                     txtLavadero,
                     numLavaplatos,
                     txtLavaplatos,
                     numLavamanos,
                     txtLavamanos,
                     numSanitario,
                     txtSanitario,
                     numDucha,
                     txtDucha,
                     txtEstadoVidrios,
                     txtVidrios,
                     txtEstadoPintura,
                     txtPintura,
                     txtOtros,
                     txtObservacionOtros,
                     numContadorAgua,
                     txtEstadoConexionAgua,
                     txtDescripcionAgua,
                     numContadorEnergia,
                     txtEstadoConexionEnergia,
                     txtDescripcionEnergia,
                     numContadorAlcantarillado,
                     txtEstadoConexionAlcantarillado,
                     txtDescripcionAlcantarillado,
                     numContadorGas,
                     txtEstadoConexionGas,
                     txtDescripcionGas,
                     numContadorTelefono,
                     txtEstadoConexionTelefono,
                     txtDescripcionTelefono,
                     txtEstadoAndenes,
                     txtDescripcionAndenes,
                     txtEstadoVias,
                     txtDescripcionVias,
                     txtEstadoServiciosComunales,
                     txtDescripcionServiciosComunales,
                     txtDescripcionVivienda,
                     txtNormaNSR98,
                     txtRequisitos,
                     txtExistencia,
                     txtDescipcionNormaNSR98,
                     txtDescripcionRequisitos,
                     txtDescripcionExistencia,
                     fchVisita,
                     txtAprobo,
                     fchCreacion,
                     fchExpedicion,
                     fchActualizacion
                 FROM T_CEM_TECNICO
                 WHERE seqCasaMano = " . $this->seqCasaMano . "
             ";

            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                foreach ($objRes->fields as $txtCampo => $txtValor) {
                    $this->objRevisionTecnica[$txtCampo] = $txtValor;
                }
                $objRes->MoveNext();
            }

            if (intval($this->objRevisionTecnica['seqTecnico']) != 0) {

                $sql = "
                     SELECT txtNombreAdjunto,
                            txtNombreArchivo,
                            seqTipoAdjunto
                       FROM T_CEM_ADJUNTOS_TECNICOS
                       WHERE seqTecnico =  " . $this->objRevisionTecnica['seqTecnico'] . "
                 ";
                $objRes = $aptBd->execute($sql);
                while ($objRes->fields) {

                    switch ($objRes->fields['seqTipoAdjunto']) {
                        case 2:
                            $numContador = count($this->objRevisionTecnica['observacion']);
                            $this->objRevisionTecnica['observacion'][$numContador] = $objRes->fields['txtNombreAdjunto'];
                            break;
                        default: // Imagenes
                            $numContador = count($this->objRevisionTecnica['imagenes']);
                            $this->objRevisionTecnica['imagenes'][$numContador]['nombre'] = $objRes->fields['txtNombreAdjunto'];
                            $this->objRevisionTecnica['imagenes'][$numContador]['ruta'] = $objRes->fields['txtNombreArchivo'];
                            if (!file_exists($txtPrefijoRuta . "recursos/imagenes/desembolsos/" . $objRes->fields['txtNombreArchivo'])) {
                                $this->objRevisionTecnica['imagenes'][$numContador]['nombre'] = "No Disponible";
                                $this->objRevisionTecnica['imagenes'][$numContador]['ruta'] = "no_disponible.jpg";
                            }
                            break;
                    }

                    $objRes->MoveNext();
                }
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = $objError->msg;
        }
    }

    public function cargarPostulacion() {
        $claFormulario = new FormularioSubsidios;
        $claFormulario->cargarFormulario($this->seqFormulario);
        $this->objPostulacion = $claFormulario;
    }

    public function cargarPrimeraVerificacion() {
        global $aptBd;
        return true;
    }

    public function cargarSegundaVerificacion() {
        global $aptBd;
        return true;
    }

    public function salvar($arrPost) {
        global $aptBd;

        // Si el flujo es de casa en mano modifica la tabla t_cem_casa_mano
        if ($arrPost['txtFlujo'] == "cem") {

            // grupos asignados a la caja de vivienda popular que deben diferenciarse en la tabla CEM
            $txtGrupo = "SDHT";
            $seqProyecto = $_SESSION['seqProyecto'];
            if (
                    in_array(31, $_SESSION['arrGrupos'][$seqProyecto]) or
                    in_array(32, $_SESSION['arrGrupos'][$seqProyecto]) or
                    in_array(33, $_SESSION['arrGrupos'][$seqProyecto])
            ) {
                $txtGrupo = "CVP";
            }

            if (intval($arrPost['seqCasaMano']) == 0) {

                $sql = "
                     INSERT INTO T_CEM_CASA_MANO(
                         seqFormulario,
                         fchRegistroVivienda,
                         bolRevisionJuridica,
                         fchRevisionJuridica,
                         txtRevisionJuridica,
                         bolRevisionTecnica,
                         fchRevisionTecnica,
                         txtRevisionTecnica,
                         fchPostulacion,
                         fchPrimeraVerificacion,
                         fchSegundaVerificacion,
                         txtGrupo
                     ) VALUES (
                         " . $arrPost['seqFormulario'] . ",
                         NOW(),
                         NULL,
                         NULL,
                         NULL,
                         NULL,
                         NULL,
                         NULL,
                         NULL,
                         NULL,
                         NULL,
                         '$txtGrupo'
                     )
                 ";
                try {
                    $aptBd->execute($sql);
                    $arrPost['seqCasaMano'] = $aptBd->Insert_ID();
                } catch (Exception $objError) {
                    $this->arrErrores[] = "No se ha podido adicionar el registro de casa en mano";
                }
            } else {

                // actualizando el registro de casa en mano
                switch ($arrPost['txtFase']) {
                    case "registroOferta":
                        $arrCampos['fchRegistroVivienda'] = "'" . date("Y-m-d H:i:s") . "'";
                        break;
                    case "revisionJuridica":
                        $arrCampos['bolRevisionJuridica'] = ($arrPost['txtConcepto'] == "") ? "0" : $arrPost['txtConcepto'];
                        $arrCampos['fchRevisionJuridica'] = "'" . date("Y-m-d H:i:s") . "'";
                        $arrCampos['txtRevisionJuridica'] = "'" . $arrPost['concepto'] . "'";
                        break;
                    case "revisionTecnica":
                        $arrCampos['bolRevisionTecnica'] = ($arrPost['txtConcepto'] == "") ? "0" : $arrPost['txtConcepto'];
                        $arrCampos['fchRevisionTecnica'] = "'" . $arrPost['fchVisita'] . "'";
                        $arrCampos['txtRevisionTecnica'] = "'" . $arrPost['txtDescripcionVivienda'] . "'";
                        break;
                    case "primeraVerificacion":
                        $arrCampos['bolPrimeraVerificacion'] = $arrPost['bolResultado'];
                        $arrCampos['fchPrimeraVerificacion'] = "'" . $arrPost['fchCruce'] . "'";
                        $arrCampos['seqPrimeraVerificacion'] = "'" . $arrPost['seqCruce'] . "'";
                        break;
                    case "postulacion":
                        if ($this->objPostulacion->bolCerrado == 0 and $arrPost['bolCerrado'] == 1) {
                            $arrCampos['fchPostulacion'] = "'" . $arrPost['fchPostulacion'] . "'";
                        } else {
                            $arrCampos['fchPostulacion'] = "NULL";
                        }
                        break;
                    case "segundaVerificacion":
                        $arrCampos['bolSegundaVerificacion'] = $arrPost['bolResultado'];
                        $arrCampos['fchSegundaVerificacion'] = "'" . $arrPost['fchCruce'] . "'";
                        $arrCampos['seqSegundaVerificacion'] = "'" . $arrPost['seqCruce'] . "'";
                        break;
                }

                if (!empty($arrCampos)) {

                    $sql = "UPDATE T_CEM_CASA_MANO SET ";
                    foreach ($arrCampos as $txtCampo => $txtValor) {
                        $sql .= $txtCampo . " = " . $txtValor . ",";
                        $this->$txtCampo = $txtValor;
                    }
                    $sql = trim($sql, ",");
                    $sql .= " WHERE seqCasaMano = " . intval($arrPost['seqCasaMano']) . " " .
                            "AND seqFormulario = " . intval($arrPost['seqFormulario']);

                    try {
                        $aptBd->execute($sql);
                    } catch (Exception $objError) {
                        $this->arrErrores[] = "No se ha podido actualizar el registro de casa en mano";
                        //$this->arrErrores[] = $objError->getMessage();
                    }
                }
            }
        }

        switch ($arrPost['txtFase']) {
            case "registroOferta":
                $this->salvarRegistroOferta($arrPost);
                break;
            case "revisionJuridica":
                $this->salvarRevisionJuridica($arrPost);
                $this->primeraVerificacion($arrPost);
                break;
            case "revisionTecnica":
                $this->salvarRevisiontecnica($arrPost);
                $this->primeraVerificacion($arrPost);
                break;
            case "primeraVerificacion":
                $this->primeraVerificacion($arrPost);
                break;
            case "postulacion":
                $this->salvarPostulacion($arrPost);
                break;
            case "segundaVerificacion":
                $this->segundaVerificacion($arrPost);
                break;
        }

        return $arrPost['seqCasaMano'];
    }

    private function primeraVerificacion($arrPost) {
        global $aptBd;

        if (intval($arrPost['seqCasaMano']) != 0) {

            // No se ha realizado la verificacion
            if ($this->bolPrimeraVerificacion == 0) {
                switch (true) {
                    case $this->bolRevisionJuridica == 2 or $this->bolRevisionTecnica == 2:
                        $seqEstadoProceso = 37; // Hogar Actualizado
                        break;
                    case $this->bolRevisionJuridica == 1 or $this->bolRevisionTecnica == 1:
                        $seqEstadoProceso = 44; // Primera verificacion
                        break;
                    default:
                        $seqEstadoProceso = 0;
                        break;
                }
            }

            // Verificacion sin cruce (registros sin cruces)
            if ($this->bolPrimeraVerificacion == 1) {
                switch (true) {
                    case $this->bolRevisionJuridica == 2 or $this->bolRevisionTecnica == 2:
                        $seqEstadoProceso = 37; // Primera verificacion pendiente
                        break;
                    case $this->bolRevisionJuridica == 1 and $this->bolRevisionTecnica == 1:
                        $seqEstadoProceso = 46; // Primera verificacion aprobada
                        break;
                    default:
                        $seqEstadoProceso = 44; // Primera verificacion
                        break;
                }
            }

            // Verificacion con cruce (registros con algun cruce)
            if ($this->bolPrimeraVerificacion == 2) {
                $seqEstadoProceso = 45; // Primera verificacion pendiente
            }

            if ($seqEstadoProceso == 46 and ( time() > strtotime($this->fchPrimeraVerificacion) )) {
                $seqEstadoProceso = 37;
            }

            // alterar el estado del proceso segun el resultado
            if ($seqEstadoProceso != 0) {
                try {
                    $sql = "
                        UPDATE T_FRM_FORMULARIO SET
                            seqEstadoProceso = " . $seqEstadoProceso . ",
                            fchUltimaActualizacion = NOW()
                        WHERE seqFormulario = " . $arrPost['seqFormulario'] . "
                    ";
                    $aptBd->execute($sql);

                    if ($arrPost['seqCruce'] != 0) {
                        $sql = "
                            update t_cru_resultado set
                                seqEstadoProceso = " . $seqEstadoProceso . "
                            where seqFormulario = " . $arrPost['seqFormulario'] . "
                              and seqCruce = " . $arrPost['seqCruce'];
                        $aptBd->execute($sql);
                    }
                } catch (Exception $objError) {
                    $this->arrErrores[] = "No se pudo modificar el estado del proceso";
                    $this->arrErrores[] = $objError->getMessage();
                }
            }
        } else {
            $this->arrErrores[] = "No se encuentra el registro de casa en mano para hacer la verificacion de conceptos";
        }
    }

    private function segundaVerificacion($arrPost) {
        global $aptBd;

        try {
            $arrPost['seqEstadoProceso'] = (intval($arrPost['bolResultado']) == 1) ? 16 : 56;
            $sql = "
                UPDATE T_FRM_FORMULARIO SET
                    seqEstadoProceso = " . $arrPost['seqEstadoProceso'] . ",
                    fchUltimaActualizacion = now()
                WHERE seqFormulario = " . $arrPost['seqFormulario'] . "
            ";
            $aptBd->execute($sql);

            $sql = "
                update t_cru_resultado set
                    seqEstadoProceso = " . $arrPost['seqEstadoProceso'] . "
                where seqFormulario = " . $arrPost['seqFormulario'] . "
                  and seqCruce = " . $arrPost['seqCruce'];
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se pudo modificar el estado del proceso";
            $this->arrErrores[] = $objError->getMessage();
        }
    }

    public function salvarRegistroOferta($arrPost) {
        global $aptBd;

        // adiciona el texto del barrio a nivel informativo (existe para datos viejos)
        // se usa el seuencial para datos nuevos (plan gobierno 3)
        $arrTextoBarrio = obtenerDatosTabla(
                "T_FRM_BARRIO", array("seqBarrio", "txtBarrio"), "seqBarrio", "seqBarrio = " . $arrPost['seqBarrio']
        );
        $seqBarrio = $arrPost['seqBarrio'];
        $arrPost['txtBarrio'] = $arrTextoBarrio[$seqBarrio];

        // Obtiene el registro de la oferta que
        // esta asociada con el registro de casa en mano
        // REGISTRO DE LA VIVIENDA Y CASA EN MANO SON 1 A 1
        $sql = "
             SELECT seqRegistroVivienda
             FROM T_CEM_REGISTRO_VIVIENDA
             WHERE seqCasaMano = " . intval($arrPost['seqCasaMano']);

        $objRes = $aptBd->execute($sql);
        $seqRegistroOferta = 0;
        if ($objRes->fields) {
            $seqRegistroOferta = $objRes->fields['seqRegistroVivienda'];
        }

        $arrPost['txtTipoDocumentos'] = $arrPost['documentos'];

        $seqFormulario = $arrPost['seqFormulario'];
        $seqEstadoProceso = $arrPost['seqEstadoProceso'];

        $claSeguimiento = new Seguimiento();
        $claSeguimiento->arrIgnorarCampos = array();
        $claSeguimiento->salvarSeguimiento($arrPost, "cambiosRegistroOferta");

        if (empty($claSeguimiento->arrErrores)) {
            // quita las variables del post que no sirven
            unset($arrPost['bolCerrado']);
            unset($arrPost['bolBorrar']);
            unset($arrPost['seqGrupoGestion']);
            unset($arrPost['txtComentario']);
            unset($arrPost['seqGestion']);
            unset($arrPost['seqFormulario']);
            unset($arrPost['txtFlujo']);
            unset($arrPost['txtFase']);
            unset($arrPost['cedula']);
            unset($arrPost['seqEstadoProceso']);
            unset($arrPost['radTipoDireccion']);
            unset($arrPost['documentos']);
            unset($arrPost['nombre']);

            $arrPost['seqAplicacionSubsidio'] = 0;
            $arrPost['seqProyectosSoluciones'] = 0;
            $arrPost['fchActualizacion'] = "'" . date("Y-m-d H:i:s") . "'";

            foreach ($arrPost as $txtCampo => $txtValor) {
                switch (mb_substr($txtCampo, 0, 3)) {
                    case "num":
                        $txtValor = doubleval(mb_ereg_replace("[^0-9]", "", $txtValor));
                        break;
                    case "val":
                        $txtValor = doubleval(mb_ereg_replace("[^0-9]", "", $txtValor));
                        break;
                    case "seq":
                        $txtValor = doubleval(mb_ereg_replace("[^0-9]", "", $txtValor));
                        break;
                    case "txt":
                        $txtValor = "'" . trim($txtValor) . "'";
                        break;
                    case "fch":
                        $txtValor = (esFechaValida($txtValor)) ? "'" . $txtValor . "'" : "NULL";
                        break;
                    default:
                        $txtValor = "'" . trim($txtValor) . "'";
                        break;
                }
                $arrPost[$txtCampo] = $txtValor;
            }

            // Si no existe registro de vivienda lo inserta
            if ($seqRegistroOferta == 0) {

                $arrPost['fchCreacion'] = "'" . date("Y-m-d H:i:s") . "'";

                $sql = "INSERT INTO T_CEM_REGISTRO_VIVIENDA (";
                $sql .= implode(",", array_keys($arrPost)) . ") VALUES (";
                $sql .= implode(",", $arrPost) . ")";

                try {
                    $aptBd->execute($sql);
                    $seqRegistroOferta = $aptBd->Insert_ID();
                } catch (Exception $objError) {
                    $this->arrErrores[] = "No se ha podido adicionar el registro de la oferta";
                    //$this->arrErrores[] = $objError->getMessage();
                }
            } else {

                $sql = "UPDATE T_CEM_REGISTRO_VIVIENDA SET ";
                foreach ($arrPost as $txtCampo => $txtValor) {
                    $sql .= $txtCampo . " = " . $txtValor . ",";
                }
                $sql = trim($sql, ",");
                $sql .= " WHERE seqCasaMano = " . $arrPost['seqCasaMano'];

                try {
                    $aptBd->execute($sql);
                } catch (Exception $objError) {
                    $this->arrErrores[] = "No se ha podido actualizar el registro de la oferta";
                    $this->arrErrores[] = $objError->getMessage();
                }
            }

            $sql = "
                UPDATE T_FRM_FORMULARIO SET 
                    txtDireccionSolucion = " . $arrPost['txtDireccionInmueble'] . ",
                    txtMatriculaInmobiliaria = " . $arrPost['txtMatriculaInmobiliaria'] . ",
                    txtChip = " . $arrPost['txtChip'] . ",
                    seqEstadoProceso = " . $seqEstadoProceso . " 
                WHERE seqFormulario = " . $seqFormulario . "
            ";

            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $this->arrErrores[] = "No se ha podido actualizar el formulario";
                //$this->arrErrores[] = $objError->getMessage();
            }

            if (empty($this->arrErrores)) {
                $this->arrMensajes = $claSeguimiento->arrMensajes;
            }
        } else {
            $this->arrErrores = $claSeguimiento->arrErrores;
        }
    }

    public function salvarRevisionJuridica($arrPost) {
        global $aptBd;

        $claSeguimiento = new Seguimiento();
        $claSeguimiento->arrIgnorarCampos = array();
        $claSeguimiento->salvarSeguimiento($arrPost, "cambiosRevisionJuridicaCEM");

        if (empty($claSeguimiento->arrErrores)) {
            // Obtiene el registro de la oferta que
            // esta asociada con el registro de casa en mano
            $sql = "
                 SELECT seqJuridico
                 FROM T_CEM_JURIDICO
                 WHERE seqCasaMano = " . intval($arrPost['seqCasaMano']);

            $objRes = $aptBd->execute($sql);
            $seqJuridico = 0;
            if ($objRes->fields) {
                $seqJuridico = $objRes->fields['seqJuridico'];
            }

            // Si no existe registro de vivienda lo inserta
            if ($seqJuridico == 0) {

                $arrPost['fchCreacion'] = date("Y-m-d H:i:s");
                $arrPost['fchActualizacion'] = NULL;

                $sql = "
                     INSERT INTO T_CEM_JURIDICO (
                         seqCasaMano,
                         numResolucion,
                         fchResolucion,
                         txtObservaciones,
                         txtLibertad,
                         txtConcepto,
                         txtAprobo,
                         fchCreacion,
                         fchActualizacion
                     ) VALUES (
                         '" . $arrPost['seqCasaMano'] . "',
                         NULL,
                         NULL,
                         '" . $arrPost['observaciones'] . "',
                         '" . $arrPost['libertad'] . "',
                         '" . $arrPost['concepto'] . "',
                         '" . $arrPost['aprobo'] . "',
                         '" . date("Y-m-d H:i:s") . "',
                         NULL
                     )
                 ";

                try {
                    $aptBd->execute($sql);
                    $seqJuridico = $aptBd->Insert_ID();
                } catch (Exception $objError) {
                    $this->arrErrores[] = "No se ha podido adicionar la revisión jurídica";
                    $this->arrErrores[] = $objError->getMessage();
                }
            } else {

                $sql = "
                     UPDATE T_CEM_JURIDICO SET
                         seqCasaMano = '" . $arrPost['seqCasaMano'] . "',
                         numResolucion = NULL,
                         fchResolucion = NULL,
                         txtObservaciones = '" . $arrPost['observaciones'] . "',
                         txtLibertad = '" . $arrPost['libertad'] . "',
                         txtConcepto = '" . $arrPost['concepto'] . "',
                         txtAprobo = '" . $arrPost['aprobo'] . "',
                         fchActualizacion = '" . date("Y-m-d H:i:s") . "'
                     WHERE seqCasaMano = '" . $arrPost['seqCasaMano'] . "'
                 ";
                try {
                    $aptBd->execute($sql);
                } catch (Exception $objError) {
                    $this->arrErrores[] = "No se ha podido actualizar la revisión jurídica";
                    $this->arrErrores[] = $objError->getMessage();
                }
            }

            /**
             * ELIMINA LOS REGISTROS DE LOS
             * DOCUMENTOS Y RECOMENDACIONES
             */
            $sql = "
                 DELETE 
                 FROM T_CEM_ADJUNTOS_JURIDICOS
                 WHERE seqJuridico = $seqJuridico
              ";
            $aptBd->execute($sql);

            /**
             * INSERTA LOS REGISTROS DE
             * LOS DOCUMENOS ANALIZADOS
             */
            if (!empty($arrPost['documento'])) {
                foreach ($arrPost['documento'] as $txtDocumento) {
                    $sql = " 
                         INSERT INTO T_CEM_ADJUNTOS_JURIDICOS ( 
                             seqJuridico, 
                             seqTipoAdjunto, 
                             txtAdjunto
                         ) VALUES (
                             $seqJuridico,
                             1,
                             \"$txtDocumento\"
                         )
                     ";
                    try {
                        $aptBd->execute($sql);
                    } catch (Exception $objError) {
                        $this->arrErrores[] = $objError->getMessage();
                    }
                }
            }

            if (!empty($arrPost['recomendacion'])) {
                foreach ($arrPost['recomendacion'] as $txtRecomendacion) {
                    $sql = " 
                         INSERT INTO T_CEM_ADJUNTOS_JURIDICOS ( 
                             seqJuridico, 
                             seqTipoAdjunto, 
                             txtAdjunto
                         ) VALUES (
                             $seqJuridico,
                             2,
                             \"$txtRecomendacion\"
                         )
                     ";
                    try {
                        $aptBd->execute($sql);
                    } catch (Exception $objError) {
                        $this->arrErrores[] = $objError->getMessage();
                    }
                }
            }

            if (empty($this->arrErrores)) {
                $this->arrMensajes = $claSeguimiento->arrMensajes;
            }
        } else {
            $this->arrErrores = $claSeguimiento->arrErrores;
        }
    }

    public function salvarRevisionTecnica($arrPost) {
        global $aptBd;
        global $txtPrefijoRuta;

        $claSeguimiento = new Seguimiento();
        $claSeguimiento->arrIgnorarCampos = array();
        $claSeguimiento->salvarSeguimiento($arrPost, "cambiosRevisionTecnicaCEM");

        if (empty($claSeguimiento->arrErrores)) {

            // Obtiene el registro de la oferta que
            // esta asociada con el registro de casa en mano
            $sql = "
                 SELECT seqTecnico
                 FROM T_CEM_TECNICO
                 WHERE seqCasaMano = " . intval($arrPost['seqCasaMano']);

            $objRes = $aptBd->execute($sql);
            $seqTecnico = 0;
            if ($objRes->fields) {
                $seqTecnico = $objRes->fields['seqTecnico'];
            }

            // quita las variables del post que no sirven
            unset($arrPost['seqGrupoGestion']);
            unset($arrPost['txtComentario']);
            unset($arrPost['seqGestion']);
            unset($arrPost['seqFormulario']);
            unset($arrPost['txtFlujo']);
            unset($arrPost['txtFase']);
            unset($arrPost['cedula']);
            unset($arrPost['seqEstadoProceso']);
            unset($arrPost['nombre']);
            unset($arrPost['txtConcepto']);
            unset($arrPost['bolBorrar']);

            // Obtiene el arreglo de los archivos cargados
            $arrNombreArchivoCargado = array();
            $arrTextoArchivoCargado = array();
            $arrObservaciones = array();

            if (!empty($arrPost['nombreArchivoCargado'])) {
                $arrNombreArchivoCargado = $arrPost['nombreArchivoCargado'];
                $arrTextoArchivoCargado = $arrPost['textoArchivoCargado'];
            }

            if (!empty($arrPost['observacion'])) {
                $arrObservaciones = $arrPost['observacion'];
            }

            unset($arrPost['nombreArchivoCargado']);
            unset($arrPost['textoArchivoCargado']);
            unset($arrPost['observacion']);

            foreach ($arrPost as $txtCampo => $txtValor) {
                switch (mb_substr($txtCampo, 0, 3)) {
                    case "num":
                        $txtValor = floatval(mb_ereg_replace("[^0-9\.]", "", $txtValor));
                        break;
                    case "val":
                        $txtValor = doubleval(mb_ereg_replace("[^0-9]", "", $txtValor));
                        break;
                    case "seq":
                        $txtValor = doubleval(mb_ereg_replace("[^0-9]", "", $txtValor));
                        break;
                    case "txt":
                        $txtValor = "'" . trim($txtValor) . "'";
                        break;
                    case "fch":
                        $txtValor = (esFechaValida($txtValor)) ? "'" . $txtValor . "'" : "NULL";
                        break;
                    default:
                        $txtValor = "'" . trim($txtValor) . "'";
                        break;
                }
                $arrPost[$txtCampo] = $txtValor;
            }


            // Si no existe registro de vivienda lo inserta
            if ($seqTecnico == 0) {

                $arrPost['fchCreacion'] = "'" . date("Y-m-d H:i:s") . "'";
                $arrPost['fchActualizacion'] = "NULL";

                $sql = "INSERT INTO T_CEM_TECNICO (";
                $sql .= implode(",", array_keys($arrPost)) . ") VALUES (";
                $sql .= implode(",", $arrPost) . ")";

                try {
                    // echo "<p> 1 ".$sql."</p>";
                    $aptBd->execute($sql);
                    $seqTecnico = $aptBd->Insert_ID();
                } catch (Exception $objError) {
                    $this->arrErrores[] = "No se ha podido adicionar el registro técnico";
                    $this->arrErrores[] = $objError->getMessage();
                }
            } else {

                $arrPost['fchActualizacion'] = "'" . date("Y-m-d H:i:s") . "'";

                $sql = "UPDATE T_CEM_TECNICO SET ";
                foreach ($arrPost as $txtCampo => $txtValor) {
                    $sql .= $txtCampo . " = " . $txtValor . ",";
                }
                $sql = trim($sql, ",");
                $sql .= "WHERE seqCasaMano = " . $arrPost['seqCasaMano'];

                try {
                    //echo "<p> 2 ".$sql."</p>";
                    $aptBd->execute($sql);
                } catch (Exception $objError) {
                    $this->arrErrores[] = "No se ha podido actualizar el registro técnico";
                }
            }

            /**
             * SALVAR LAS IMAGENES
             */
            $arrNombreArchivoCargado = (is_array($arrNombreArchivoCargado)) ? $arrNombreArchivoCargado : array();
            if (is_dir($txtPrefijoRuta . "recursos/imagenes/desembolsos")) {
                if ($aptDir = opendir($txtPrefijoRuta . "recursos/imagenes/desembolsos")) {

                    // Elimina de la carpeta los archivos que no esten en el arreglo que viene del formulario
                    $seqFormulario = 0;
                    while (($txtArchivo = readdir($aptDir)) !== false) {
                        if ($txtArchivo != "." and $txtArchivo != "..") {
                            $numFormulario = intval(substr($txtArchivo, 0, strpos($txtArchivo, "_")));
                            $seqFormulario = (intval($seqFormulario) == 0) ? $this->seqFormulario : $seqFormulario;
                            if ($numFormulario == $seqFormulario) {
                                if (!in_array($txtArchivo, $arrNombreArchivoCargado)) {
                                    unlink($txtPrefijoRuta . "recursos/imagenes/desembolsos/" . $txtArchivo);
                                }
                            }
                        }
                    }
                    closedir($aptDir);

                    // Elimina los registros de las imagenes que haya
                    // para insertar las que vienen en el formulario
                    // las imagenes ya estan fisicamente en la carpeta desde
                    // que se cargan en el formulario
                    $sql = "
                     DELETE 
                     FROM T_CEM_ADJUNTOS_TECNICOS
                     WHERE seqTecnico =  $seqTecnico
                  ";
                    $aptBd->execute($sql);

                    // Para cada imagen se inserta el registro en la base de datos
                    foreach ($arrNombreArchivoCargado as $numIndice => $txtNombreArchivo) {
                        $sql = "
                        INSERT INTO T_CEM_ADJUNTOS_TECNICOS (
                           seqTecnico,
                           seqTipoAdjunto,
                           txtNombreAdjunto,
                           txtNombreArchivo
                        ) VALUES (
                           $seqTecnico,
                           3,
                           '" . $arrTextoArchivoCargado[$numIndice] . "',
                           '$txtNombreArchivo'
                        )
                     ";
                        try {
                            $aptBd->execute($sql);
                        } catch (Exception $objError) {
                            $this->arrErrores[] = "No se pudo almacenar los datos de la imagen $txtNombreArchivo";
                        }
                    }

                    $arrObservaciones = (is_array($arrObservaciones)) ? $arrObservaciones : array();
                    foreach ($arrObservaciones as $numIndice => $txtTexto) {
                        $sql = "
                        INSERT INTO T_CEM_ADJUNTOS_TECNICOS (
                           seqTecnico,
                           seqTipoAdjunto,
                           txtNombreAdjunto,
                           txtNombreArchivo
                        ) VALUES (
                           $seqTecnico,
                           2,
                           '" . $txtTexto . "',
                           ''
                        )
                     ";
                        try {
                            $aptBd->execute($sql);
                        } catch (Exception $objError) {
                            $this->arrErrores[] = "No se pudo almacenar una de las observaciones ( $numIndice )";
                        }
                    }
                } else {
                    $this->arrErrores[] = "La informacion del registro se salvo pero las imágenes no pudieron salvarse, no se pudo abrir el directorio de imagenes";
                }
            } else {
                $this->arrErrores[] = "La informacion del registro se salvo pero las imágenes no pudieron salvarse, falta la carpeta de imagenes";
            }
        } else {
            $this->arrErrores = $claSeguimiento->arrErrores;
        }

        if (empty($this->arrErrores)) {
            $this->arrMensajes = $claSeguimiento->arrMensajes;
        }
    }

    public function salvarPostulacion($arrPost) {
        // parte de lo que esta en la base de datos
        $claSeguimiento = new Seguimiento();
        $claFormulario = new FormularioSubsidios();
        $claFormulario->cargarFormulario($arrPost['seqFormulario']);

        $claSeguimiento->arrIgnorarCampos = array();
        $claSeguimiento->salvarSeguimiento($arrPost, "cambiosPostulacion");

        if (!empty($claSeguimiento->arrErrores)) {
            $this->arrErrores += $claSeguimiento->arrErrores;
        } else {

            // Ciudadanos eliminados y actualizados
            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                $numDocumento = $objCiudadano->numDocumento;
                if (empty($objCiudadano->arrErrores)) {
                    if (isset($arrPost['hogar'][$numDocumento])) {
                        foreach ($objCiudadano as $txtClave => $txtValor) {
                            $objCiudadano->$txtClave = regularizarCampo($txtClave, $arrPost['hogar'][$numDocumento][$txtClave]);
                        }
                        $objCiudadano->editarCiudadano($seqCiudadano);
                    } else {
                        $objCiudadano->borrarCiudadano();
                        $seqCiudadano = $objCiudadano->seqCiudadano;
                        unset($claFormulario->arrCiudadano[$seqCiudadano]);
                    }
                } else {
                    $this->arrErrores += $objCiudadano->arrErrores;
                }
            }

            // ciudadanos adicionados
            if (empty($this->arrErrores)) {

                foreach ($arrPost['hogar'] as $numDocumento => $arrDatos) {

                    $seqCiudadano = Ciudadano::ciudadanoExiste($arrDatos['seqTipoDocumento'], $arrDatos['numDocumento']);
                    $objCiudadano = new Ciudadano();
                    if ($seqCiudadano != 0) {
                        $objCiudadano->cargarCiudadano($seqCiudadano);
                    }
                    foreach ($objCiudadano as $txtClave => $txtValor) {
                        if (isset($arrDatos[$txtClave])) {
                            $objCiudadano->$txtClave = regularizarCampo($txtClave, $arrDatos[$txtClave]);
                        }
                    }
                    if ($seqCiudadano == 0) {
                        $objCiudadano->guardarCiudadano();
                    } else {
                        $objCiudadano->editarCiudadano($seqCiudadano);
                    }

                    if (empty($objCiudadano->arrErrores)) {
                        $seqCiudadano = $objCiudadano->seqCiudadano;
                        $claFormulario->arrCiudadano[$seqCiudadano] = $objCiudadano;
                    } else {
                        $this->arrErrores += $objCiudadano->arrErrores;
                    }
                }

                //pr($claFormulario->arrCiudadano);

                $claFormulario->relacionarCiudadanoFormulario();
                if (!empty($claFormulario->arrErrores)) {
                    $this->arrErrores += $claFormulario->arrErrores;
                }
            }

            // cambios en el formulario
            foreach ($claFormulario as $txtClave => $txtValor) {
                if ($txtClave != "arrCiudadano") {
                    if (isset($arrPost[$txtClave]) || is_null($arrPost[$txtClave])) {
                        //echo "$txtClave ==> " . $claFormulario->$txtClave . " ==> " . $arrPost[$txtClave] . "<br>";
                        $claFormulario->$txtClave = regularizarCampo($txtClave, $arrPost[$txtClave]);
                    }
                }
            }

            $claFormulario->txtBarrio = array_shift(
                    obtenerDatosTabla(
                            "T_FRM_BARRIO", array("seqBarrio", "txtBarrio"), "seqBarrio", "seqBarrio = " . $claFormulario->seqBarrio
                    )
            );
            $numVictima = 0;
            //var_dump($arrPost['hogar']);
            foreach ($arrPost['hogar'] as $key => $value) {
                foreach ($value as $keyCiu => $valueCiu) {
                    if ($keyCiu == 'seqTipoVictima' && $valueCiu == 2) {
                        $numVictima++;
                    }
                }
            }
            $claFormulario->bolDesplazado = ($numVictima > 0) ? 1 : 0;
            //echo "<p>" . $claFormulario->bolDesplazado . "</p>";
            $claFormulario->editarFormulario($arrPost['seqFormulario']);
            if (!empty($claFormulario->arrErrores)) {
                $this->arrErrores += $claFormulario->arrErrores;
            } else {
                $this->arrMensajes = $claSeguimiento->arrMensajes;
            }
        }
    }

    public function cambios($arrPost) {

        $bolCambios = false;
        $claSeguimiento = new Seguimiento();

        /*         * ****************************************************************
         * Cambios en registro de oferta
         * **************************************************************** */
        if (trim($arrPost['txtFase']) == "registroOferta") {
            if (is_array($this->objRegistroOferta)) {
                foreach ($this->objRegistroOferta as $txtClave => $txtValor) {
                    if (isset($arrPost[$txtClave])) {
                        $arrPost[$txtClave] = regularizarCampo($txtClave, $arrPost[$txtClave]);
                        switch (substr($txtClave, 0, 3)) {
                            case "num":
                                $bolCambios = (intval($txtValor) != intval($arrPost[$txtClave])) ? true : $bolCambios;
                                break;
                            case "seq":
                                $bolCambios = (intval($txtValor) != intval($arrPost[$txtClave])) ? true : $bolCambios;
                                break;
                            case "fch":
                                $bolCambios = (strtotime($txtValor) != strtotime($arrPost[$txtClave])) ? true : $bolCambios;
                                break;
                            case "txt":
                                $bolCambios = (trim(strtoupper($txtValor)) != trim(strtoupper($arrPost[$txtClave]))) ? true : $bolCambios;
                                break;
                            default:
                                $bolCambios = (trim($txtValor) != trim($arrPost[$txtClave])) ? true : $bolCambios;
                                break;
                        }
                    }
                }
            }
        }

        // Cambios en el tipo de persona
        if (isset($arrPost['documentos'])) {
            if (trim($this->objRegistroOferta->txtTipoDocumentos) != trim($arrPost['documentos'])) {
                $bolCambios = true;
            }
        }

//        echo "Registro de vivienda<br>";
//        var_dump($bolCambios);

        /*         * ****************************************************************
         * Cambios en revision juridica
         * **************************************************************** */
        if (trim($arrPost['txtFase']) == "revisionJuridica") {

            if (empty($this->objRevisionJuridica)) {
                if (trim($arrPost['aprobo']) != "") {
                    $bolCambios = true;
                } else {
                    $bolCambios = false;
                }
            } else {
                // verificando que los datos sean iguales
                if (intval($this->bolRevisionJuridica) != trim($arrPost["txtConcepto"])) {
                    $bolCambios = true;
                }

                if (trim($this->objRevisionJuridica["txtAprobo"]) != trim($arrPost["aprobo"])) {
                    $bolCambios = true;
                }

                if (trim($this->objRevisionJuridica["txtObservaciones"]) != trim($arrPost["observaciones"])) {
                    $bolCambios = true;
                }

                if (trim($this->objRevisionJuridica["txtLibertad"]) != trim($arrPost["libertad"])) {
                    $bolCambios = true;
                }

                if (trim($this->objRevisionJuridica["txtConcepto"]) != trim($arrPost["concepto"])) {
                    $bolCambios = true;
                }

                // verificando que no cambien los documentos
                $arrPost["documento"] = (!isset($arrPost["documento"])) ? array() : $arrPost["documento"];
                if (count($this->objRevisionJuridica["documento"]) != count($arrPost["documento"])) {
                    $bolCambios = true;
                } else {
                    $this->objRevisionJuridica["documento"] = (!empty($this->objRevisionJuridica["documento"])) ? $this->objRevisionJuridica["documento"] : array();
                    foreach ($this->objRevisionJuridica["documento"] as $txtDocumento) {
                        if (!in_array($txtDocumento, $arrPost["documento"])) {
                            $bolCambios = true;
                        }
                    }
                }

                // verificando que no cambien las recomendaciones
                $arrPost["recomendacion"] = (!isset($arrPost["recomendacion"])) ? array() : $arrPost["recomendacion"];
                if (count($this->objRevisionJuridica["recomendacion"]) != count($arrPost["recomendacion"])) {
                    $bolCambios = true;
                } else {
                    $this->objRevisionJuridica["recomendacion"] = (!empty($this->objRevisionJuridica["recomendacion"])) ? $this->objRevisionJuridica["recomendacion"] : array();
                    foreach ($this->objRevisionJuridica["recomendacion"] as $txtDocumento) {
                        if (!in_array($txtDocumento, $arrPost["recomendacion"])) {
                            $bolCambios = true;
                        }
                    }
                }
            }
        }
//            echo "Revision Juridica<br>";
//            var_dump($bolCambios);

        /*         * ****************************************************************
         * Cambios en revision tecnica
         * **************************************************************** */
        if (trim($arrPost['txtFase']) == "revisionTecnica") {

            if (empty($this->objRevisionTecnica)) {
                if (trim($arrPost['txtAprobo']) != "") {
                    $bolCambios = true;
                } else {
                    $bolCambios = false;
                }
            } else {

                // verificando que los datos sean iguales
                if (intval($this->bolRevisionTecnica) != trim($arrPost["txtConcepto"])) {
                    $bolCambios = true;
                }

                // Verifica cambios en las variables del formulario
                // se llaman igual en el post y en la clase
                foreach ($arrPost as $txtClave => $txtValor) {
                    if (isset($this->objRevisionTecnica[$txtClave])) {
                        if (trim($this->objRevisionTecnica[$txtClave]) != trim($txtValor)) {
                            $bolCambios = true;
                        }
                    }
                }

                // varifica cambios en las imagenes
                // no esta igual en el post y en la clase
                if (count($this->objRevisionTecnica["imagenes"]) != count($arrPost["nombreArchivoCargado"])) {
                    $bolCambios = true;
                } else {

                    // monta los nombres de los archivos en un arreglo
                    $arrArchivos = array();
                    $this->objRevisionTecnica["imagenes"] = (is_array($this->objRevisionTecnica["imagenes"])) ? $this->objRevisionTecnica["imagenes"] : array();
                    foreach ($this->objRevisionTecnica["imagenes"] as $arrImagen) {
                        $arrArchivos[] = $arrImagen["ruta"];
                    }

                    // compara los nombres de los archivos (esta no es la etiqueta de la foto es el nombre del archivo)
                    $arrPost["nombreArchivoCargado"] = (is_array($arrPost["nombreArchivoCargado"])) ? $arrPost["nombreArchivoCargado"] : array();
                    foreach ($arrPost["nombreArchivoCargado"] as $txtArchivo) {
                        if (!in_array($txtArchivo, $arrArchivos)) {
                            $bolCambios = true;
                        }
                    }
                }

                // verifica cambios en vivienda nueva
                if (count($this->objRevisionTecnica["observacion"]) != count($arrPost["observacion"])) {
                    $bolCambios = true;
                } else {
                    $arrPost["observacion"] = (is_array($arrPost["observacion"])) ? $arrPost["observacion"] : array();
                    foreach ($arrPost["observacion"] as $txtObservacion) {
                        if (!in_array($txtObservacion, $this->objRevisionTecnica["observacion"])) {
                            $bolCambios = true;
                        }
                    }
                }
            }
        }

//            echo "Revision tecnica<br>";
//            var_dump($bolCambios);

        /*         * ****************************************************************
         * Cambios en postulacion
         * **************************************************************** */

        if (trim($arrPost['txtFase']) == "postulacion") {

            // Campos que se pueden modificar sin restricciones
            $claSeguimiento->arrIgnorarCampos[] = "txtDireccion";
            $claSeguimiento->arrIgnorarCampos[] = "txtDireccionSolucion";
            $claSeguimiento->arrIgnorarCampos[] = "numTelefono1";
            $claSeguimiento->arrIgnorarCampos[] = "numTelefono2";
            $claSeguimiento->arrIgnorarCampos[] = "numCelular";
            $claSeguimiento->arrIgnorarCampos[] = "seqCiudad";
            $claSeguimiento->arrIgnorarCampos[] = "seqUpz";
            $claSeguimiento->arrIgnorarCampos[] = "seqLocalidad";
            $claSeguimiento->arrIgnorarCampos[] = "seqBarrio";
            $claSeguimiento->arrIgnorarCampos[] = "txtCorreo";
            $claSeguimiento->arrIgnorarCampos[] = "valTotalRecursos";

            $txtCambios = $claSeguimiento->cambiosPostulacion($_POST);
            $bolCambios = ( trim($txtCambios) == "" ) ? false : true;

//            echo "Postulacion<br>";
//            pr($txtCambios);
//            pr($bolCambios);
        }

        return $bolCambios;
    }

    /**
     * VERIFICA LOS PERMISOS DEL USUARIO PARA
     * SABER SI PUEDE O NO INGRESAR A CADA PANTALLA
     * @param array $arrFlujoHogar // contiene flujo y fase para ver los permisos
     */
    public function puedeIngresar($arrFlujoHogar) {

        $bolPermiso = false;                    // Determina si tiene o no permisos
        $txtFlujo = $arrFlujoHogar['flujo'];  // Determina e flujo
        $txtFase = $arrFlujoHogar['fase'];   // Determina la fase
        $seqProyecto = $_SESSION['seqProyecto']; // Es el identificador del proyecto (SDV=3)
        $arrEstados = estadosProceso();         // Los estados del proceso
        $arrEtapas = obtenerDatosTabla("T_FRM_ETAPA", array("seqEtapa", "txtEtapa"), "seqEtapa");

        $seqEstadoProceso = $this->objPostulacion->seqEstadoProceso; // Estado actual del proceso
        $seqEtapa = array_shift(obtenerDatosTabla(
                        "T_FRM_ESTADO_PROCESO", array("seqEstadoProceso", "seqEtapa"), "seqEstadoProceso", "seqEstadoProceso = " . $this->objPostulacion->seqEstadoProceso
        ));

        // Jerarquia de las validaciones de ingreso:
        // - Modalidad y esquema
        // - Etapas permitidas
        // - Estados del proceso permitidos
        // - Etapas prohibidas
        // - Estados prohibidos
        if (is_array($this->arrFases[$txtFlujo]['modalidad']) and
                is_array($this->arrFases[$txtFlujo]['esquema']) and
                in_array($this->objPostulacion->seqModalidad, $this->arrFases[$txtFlujo]['modalidad']) and
                in_array($this->objPostulacion->seqTipoEsquema, $this->arrFases[$txtFlujo]['esquema'])
        ) {
            if (!empty($this->arrFases[$txtFlujo][$txtFase]['permitido']['etapas'])) {// Etapas permitidos
                if (in_array($seqEtapa, $this->arrFases[$txtFlujo][$txtFase]['permitido']['etapas'])) {
                    $bolPermiso = true;
                }
            } elseif (!empty($this->arrFases[$txtFlujo][$txtFase]['permitido']['estados'])) {                        // Estados permitidos
                if (in_array($seqEstadoProceso, $this->arrFases[$txtFlujo][$txtFase]['permitido']['estados'])) {
                    $bolPermiso = true;
                }
            }
            if (!empty($this->arrFases[$txtFlujo][$txtFase]['prohibido']['etapas'])) {                             // Etapas prohibidas
                if (in_array($seqEtapa, $this->arrFases[$txtFlujo][$txtFase]['prohibido']['etapas'])) {
                    $bolPermiso = false;
                    $this->arrErrores[] = "El hogar no pertenece a las etapas permitidas para el ingreso, la etapa actual es \"" . $arrEtapas[$seqEtapa] . "\"";
                }
            } elseif (!empty($this->arrFases[$txtFlujo][$txtFase]['prohibido']['estados'])) {                        // Estados prohibidos
                if (in_array($seqEstadoProceso, $this->arrFases[$txtFlujo][$txtFase]['prohibido']['estados'])) {
                    $bolPermiso = false;
                    $this->arrErrores[] = "El hogar no pertenece a los estados del proceso permitidos para el ingreso, el estado actual es \"" . $arrEstados[$seqEstadoProceso] . "\"";
                }
            }
        } else {
            $this->arrErrores[] = "El hogar no pertenece a las modalidades o esquemas permitidos para el ingreso, " .
                    "la modalidad actual es \"" . $arrModalidad[$this->objPostulacion->seqModalidad] .
                    "\" y el esquema es " . $arrTipoEsquema[$this->objPostulacion->seqTipoEsquema];
        }

        return $bolPermiso;
    }

}

?>
