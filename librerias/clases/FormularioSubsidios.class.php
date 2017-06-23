<?php

/**
 * CLASE QUE MANEJA LOS FORMULARIOS DE INSCRIPCION Y 
 * POSTULACION
 * @author Bernardo Zerda
 * @version 1.0 Mayo 2009
 */
class FormularioSubsidios {

    // Variables para el ciudadano
    public $arrCiudadano;

    // Variables del formulario
    // en orden alfabetico para poderlas encontrar mas facil
    public $arrErrores;
    public $bolAltaCon;
    public $bolCerrado;
    public $bolDesplazado;
    public $bolIdentificada;
    public $bolInmovilizadoCuentaAhorro;
    public $bolInmovilizadoCuentaAhorro2;
    public $bolIntegracionSocial;
    public $bolIpes;
    public $bolPromesaFirmada;
    public $bolSancion;
    public $bolSecEducacion;
    public $bolSecMujer;
    public $bolSecSalud;
    public $bolViabilidadLeasing;
    public $bolViabilizada;
    public $fchAperturaCuentaAhorro;
    public $fchAperturaCuentaAhorro2;
    public $fchAprobacionCredito;
    public $fchArriendoDesde;
    public $fchInscripcion;
    public $fchNotificacion;
    public $fchPostulacion;
    public $fchUltimaActualizacion;
    public $fchVencimiento;
    public $fchVigencia;
    public $numAdultosNucleo;
    public $numCelular;
    public $numCortes;
    public $numDuracionLeasing;
    public $numHabitaciones;
    public $numHacinamiento;
    public $numNinosNucleo;
    public $numPuntajeSisben;
    public $numTelefono1;
    public $numTelefono2;
    public $seqBancoCredito;
    public $seqBancoCuentaAhorro;
    public $seqBancoCuentaAhorro2;
    public $seqConvenio;
    public $seqBarrio;
    public $seqCesantias;
    public $seqCiudad;
    public $seqEmpresaDonante;
    public $seqEntidadSubsidio;
    public $seqEstadoProceso;
    public $seqFormulario;
    public $seqLocalidad;
    public $seqModalidad;
    public $seqPeriodo;
    public $seqPlanGobierno;
    public $seqProyecto;
    public $seqProyectoHijo;
    public $seqPuntoAtencion;
    public $seqSisben;
    public $seqSolucion;
    public $seqTipoDireccion;
    public $seqTipoEsquema;
    public $seqTipoFinanciacion;
    public $seqUnidadProyecto;
    public $seqUpz;
    public $seqUsuario;
    public $seqVivienda;
    public $txtBarrio;
    public $txtChip;
    public $txtComprobanteArriendo;
    public $txtCorreo;
    public $txtDireccion;
    public $txtDireccionSolucion;
    public $txtFormulario;
    public $txtMatriculaInmobiliaria;
    public $txtOtro;
    public $txtSoporteAporteLote;
    public $txtSoporteAporteMateriales;
    public $txtSoporteAvanceObra;
    public $txtSoporteCesantias;
    public $txtSoporteCredito;
    public $txtSoporteCuentaAhorro;
    public $txtSoporteCuentaAhorro2;
    public $txtSoporteDonacion;
    public $txtSoporteSubsidio;
    public $txtSoporteSubsidioNacional;
    public $valAporteAvanceObra;
    public $valAporteLote;
    public $valAporteMateriales;
    public $valArriendo;
    public $valAspiraSubsidio;
    public $valAvaluo;
    public $valCartaLeasing;
    public $valCredito;
    public $valDonacion;
    public $valIngresoHogar;
    public $valPresupuesto;
    public $valSaldoCesantias;
    public $valSaldoCuentaAhorro;
    public $valSaldoCuentaAhorro2;
    public $valSubsidioNacional;
    public $valTotal;
    public $valTotalRecursos;

    public function FormularioSubsidios() {

        $this->arrErrores = array();
        $this->bolAltaCon = 0;
        $this->bolCerrado = 0;
        $this->bolDesplazado = 0;
        $this->bolIdentificada = 0;
        $this->bolInmovilizadoCuentaAhorro = 0;
        $this->bolInmovilizadoCuentaAhorro2 = 0;
        $this->bolIntegracionSocial = 0;
        $this->bolIpes = 0;
        $this->bolPromesaFirmada = 0;
        $this->bolSancion = 0;
        $this->bolSecEducacion = 0;
        $this->bolSecMujer = 0;
        $this->bolSecSalud = 0;
        $this->bolViabilidadLeasing = 0;
        $this->bolViabilizada = 0;
        $this->fchAperturaCuentaAhorro = null;
        $this->fchAperturaCuentaAhorro2 = null;
        $this->fchAprobacionCredito = null;
        $this->fchArriendoDesde = null;
        $this->fchInscripcion = null;
        $this->fchNotificacion = null;
        $this->fchPostulacion = null;
        $this->fchUltimaActualizacion = null;
        $this->fchVencimiento = null;
        $this->fchVigencia = null;
        $this->numAdultosNucleo = 0;
        $this->numCelular = 0;
        $this->numCortes = 0;
        $this->numDuracionLeasing = 0;
        $this->numHabitaciones = 0;
        $this->numHacinamiento = 0;
        $this->numNinosNucleo = 0;
        $this->numPuntajeSisben = 0;
        $this->numTelefono1 = 0;
        $this->numTelefono2 = 0;
        $this->seqBancoCredito = 1;
        $this->seqBancoCuentaAhorro = 1;
        $this->seqBancoCuentaAhorro2 = 1;
        $this->seqBarrio = 0;
        $this->seqCesantias = 1;
        $this->seqCiudad = 0;
        $this->seqConvenio = 1;
        $this->seqEmpresaDonante = 1;
        $this->seqEntidadSubsidio = 1;
        $this->seqEstadoProceso = 1;
        $this->seqFormulario = 0;
        $this->seqLocalidad = 1;
        $this->seqModalidad = 1;
        $this->seqPeriodo = 1;
        $this->seqPlanGobierno = 3;
        $this->seqProyecto = 37;
        $this->seqProyectoHijo = 0;
        $this->seqPuntoAtencion = 1;
        $this->seqSisben = 1;
        $this->seqSolucion = 1;
        $this->seqTipoDireccion = 0;
        $this->seqTipoEsquema = 9;
        $this->seqTipoFinanciacion = 1;
        $this->seqUnidadProyecto = 0;
        $this->seqUpz = 1;
        $this->seqUsuario = $_SESSION['seqUsuario'];
        $this->seqVivienda = 0;
        $this->txtBarrio = 0;
        $this->txtChip = 0;
        $this->txtComprobanteArriendo = 0;
        $this->txtCorreo = 0;
        $this->txtDireccion = 0;
        $this->txtDireccionSolucion = 0;
        $this->txtFormulario = 0;
        $this->txtMatriculaInmobiliaria = 0;
        $this->txtOtro = "";
        $this->txtSoporteAporteLote = "";
        $this->txtSoporteAporteMateriales = "";
        $this->txtSoporteAvanceObra = "";
        $this->txtSoporteCesantias = "";
        $this->txtSoporteCredito = "";
        $this->txtSoporteCuentaAhorro = "";
        $this->txtSoporteCuentaAhorro2 = "";
        $this->txtSoporteDonacion = "";
        $this->txtSoporteSubsidio = "";
        $this->txtSoporteSubsidioNacional = "";
        $this->valAporteAvanceObra = 0;
        $this->valAporteLote = 0;
        $this->valAporteMateriales = 0;
        $this->valArriendo = 0;
        $this->valAspiraSubsidio = 0;
        $this->valAvaluo = 0;
        $this->valCartaLeasing = 0;
        $this->valCredito = 0;
        $this->valDonacion = 0;
        $this->valIngresoHogar = 0;
        $this->valPresupuesto = 0;
        $this->valSaldoCesantias = 0;
        $this->valSaldoCuentaAhorro = 0;
        $this->valSaldoCuentaAhorro2 = 0;
        $this->valSubsidioNacional = 0;
        $this->valTotal = 0;
        $this->valTotalRecursos = 0;

    }

    // Fin Constructor

    public function guardarFormulario() {
        global $aptBd;

        $sql = "
            INSERT INTO T_FRM_FORMULARIO (
               txtDireccion,
               seqTipoDireccion,
               numTelefono1,
               numTelefono2,
               numCelular,
               txtBarrio,
               txtCorreo,
               txtMatriculaInmobiliaria,
               txtChip,
               seqUnidadProyecto,
               seqTipoFinanciacion,
               bolViabilizada,
               bolIdentificada,
               bolDesplazado,
               seqSolucion,
               valPresupuesto,
               valAvaluo,
               valTotal,
               seqModalidad,
               seqPlanGobierno,
               seqBancoCuentaAhorro,
               fchAperturaCuentaAhorro,
               bolInmovilizadoCuentaAhorro,
               valSaldoCuentaAhorro,
               txtSoporteCuentaAhorro,
               seqBancoCuentaAhorro2,
               fchAperturaCuentaAhorro2,
               bolInmovilizadoCuentaAhorro2,
               valSaldoCuentaAhorro2,
               txtSoporteCuentaAhorro2,
               valSubsidioNacional,
               txtSoporteSubsidio,
               valAporteLote,
               txtSoporteAporteLote,
               seqCesantias,
               valSaldoCesantias,
               txtSoporteCesantias,
               valAporteAvanceObra,
               txtSoporteAvanceObra,
               valAporteMateriales,
               txtSoporteAporteMateriales,
               seqEmpresaDonante,
               valDonacion,
               txtSoporteDonacion,
               seqBancoCredito,
               valCredito,
               txtSoporteCredito,
               valTotalRecursos,
               valAspiraSubsidio,
               seqVivienda,
               valArriendo,
               bolPromesaFirmada,
               fchInscripcion,
               fchPostulacion,
               fchVencimiento,
               bolIntegracionSocial,
               bolSecSalud,
               bolSecEducacion,
               bolSecMujer,
               bolIpes,
               bolAltaCon, 
               txtOtro,
               numAdultosNucleo,
               numNinosNucleo,
               seqUsuario,
               bolCerrado,
               seqLocalidad,
               seqCiudad,
               valIngresoHogar,
               seqEstadoProceso,
               txtDireccionSolucion,
               seqPuntoAtencion,
               txtFormulario,
               fchUltimaActualizacion,
               seqProyecto,
               seqProyectoHijo,
               txtSoporteSubsidioNacional,
               fchArriendoDesde,
               txtComprobanteArriendo,
               seqBarrio,
               seqUpz,
               seqSisben,
               numCortes,
               fchNotificacion,
               seqPeriodo,
               bolSancion,
               fchVigencia,
               numPuntajeSisben,
               seqTipoEsquema,
               numHacinamiento,
               numHabitaciones,
               bolViabilidadLeasing,
               numDuracionLeasing,
               valCartaLeasing
            ) VALUES (
               \"" . $this->txtDireccion . "\",
               \"" . $this->seqTipoDireccion . "\",
               \"" . $this->numTelefono1 . "\",
               \"" . $this->numTelefono2 . "\",
               \"" . $this->numCelular . "\",
               \"" . $this->txtBarrio . "\",
               \"" . $this->txtCorreo . "\",
               \"" . $this->txtMatriculaInmobiliaria . "\",
               \"" . $this->txtChip . "\",
               \"" . $this->seqUnidadProyecto . "\",
               \"" . $this->seqTipoFinanciacion . "\",
               \"" . $this->bolViabilizada . "\",
               \"" . $this->bolIdentificada . "\",
               \"" . $this->bolDesplazado . "\",
               \"" . $this->seqSolucion . "\",
               \"" . mb_ereg_replace("[^0-9]", "", $this->valPresupuesto) . "\",
               \"" . mb_ereg_replace("[^0-9]", "", $this->valAvaluo) . "\",
               \"" . mb_ereg_replace("[^0-9]", "", $this->valTotal) . "\",
               \"" . $this->seqModalidad . "\",
               \"" . $this->seqPlanGobierno . "\",
               \"" . $this->seqBancoCuentaAhorro . "\",
               \"" . $this->fchAperturaCuentaAhorro . "\",
               \"" . $this->bolInmovilizadoCuentaAhorro . "\",
               \"" . mb_ereg_replace("[^0-9]", "", $this->valSaldoCuentaAhorro) . "\",
               \"" . $this->txtSoporteCuentaAhorro . "\",				
               \"" . $this->seqBancoCuentaAhorro2 . "\",
               \"" . $this->fchAperturaCuentaAhorro2 . "\",
               \"" . $this->bolInmovilizadoCuentaAhorro2 . "\",
               \"" . mb_ereg_replace("[^0-9]", "", $this->valSaldoCuentaAhorro2) . "\",
               \"" . $this->txtSoporteCuentaAhorro2 . "\",
               \"" . mb_ereg_replace("[^0-9]", "", $this->valSubsidioNacional) . "\",
               \"" . $this->txtSoporteSubsidio . "\",
               \"" . mb_ereg_replace("[^0-9]", "", $this->valAporteLote) . "\",
               \"" . $this->txtSoporteAporteLote . "\",
               \"" . $this->seqCesantias . "\",
               \"" . mb_ereg_replace("[^0-9]", "", $this->valSaldoCesantias) . "\",
               \"" . $this->txtSoporteCesantias . "\",
               \"" . mb_ereg_replace("[^0-9]", "", $this->valAporteAvanceObra) . "\",
               \"" . $this->txtSoporteAvanceObra . "\",
               \"" . mb_ereg_replace("[^0-9]", "", $this->valAporteMateriales) . "\",
               \"" . $this->txtSoporteAporteMateriales . "\",
               \"" . $this->seqEmpresaDonante . "\",
               \"" . mb_ereg_replace("[^0-9]", "", $this->valDonacion) . "\",
               \"" . $this->txtSoporteDonacion . "\",
               \"" . $this->seqBancoCredito . "\",
               \"" . mb_ereg_replace("[^0-9]", "", $this->valCredito) . "\",
               \"" . $this->txtSoporteCredito . "\",
               \"" . mb_ereg_replace("[^0-9]", "", $this->valTotalRecursos) . "\",
               \"" . mb_ereg_replace("[^0-9]", "", $this->valAspiraSubsidio) . "\",
               \"" . $this->seqVivienda . "\",
               \"" . mb_ereg_replace("[^0-9]", "", $this->valArriendo) . "\",
               \"" . $this->bolPromesaFirmada . "\",
               \"" . $this->fchInscripcion . "\",
               \"" . $this->fchPostulacion . "\",
               \"" . $this->fchVencimiento . "\",
               \"" . $this->bolIntegracionSocial . "\",
               \"" . $this->bolSecSalud . "\",
               \"" . $this->bolSecEducacion . "\",
               \"" . $this->bolSecMujer . "\",
               \"" . $this->bolIpes . "\",
               \"" . $this->bolAltaCon . "\",
               \"" . $this->txtOtro . "\",
               \"" . $this->numAdultosNucleo . "\",
               \"" . $this->numNinosNucleo . "\",
               \"" . $this->seqUsuario . "\",
               \"" . $this->bolCerrado . "\",
               \"" . $this->seqLocalidad . "\",
               \"" . $this->seqCiudad . "\",
               \"" . mb_ereg_replace("[^0-9]", "", $this->valIngresoHogar) . "\",
               \"" . $this->seqEstadoProceso . "\",
               \"" . $this->txtDireccionSolucion . "\",
               \"" . $this->seqPuntoAtencion . "\",
               \"" . $this->txtFormulario . "\",
               \"" . $this->fchUltimaActualizacion . "\",
               \"" . $this->seqProyecto . "\",
               \"" . $this->seqProyectoHijo . "\",
               \"" . $this->txtSoporteSubsidioNacional . "\",
               \"" . $this->fchArriendoDesde . "\",
               \"" . $this->txtComprobanteArriendo . "\",
               \"" . $this->seqBarrio . "\",
               \"" . $this->seqUpz . "\",
               \"" . $this->seqSisben . "\",
               \"" . $this->numCortes . "\",
               \"" . $this->fchNotificacion . "\",
               \"" . $this->seqPeriodo . "\",
               \"" . $this->bolSancion . "\",
               \"" . $this->fchVigencia . "\",
               \"" . $this->numPuntajeSisben . "\",
               \"" . $this->seqTipoEsquema . "\",
               \"" . $this->numHacinamiento . "\",
               \"" . $this->numHabitaciones . "\",    
               \"" . $this->bolViabilidadLeasing . "\",
               \"" . $this->numDuracionLeasing . "\",
               \"" . $this->valCartaLeasing . "\"
            )		
        ";

        try {
            $aptBd->execute($sql);
            $this->seqFormulario = $aptBd->Insert_ID();
        } catch (Exception $objError) {
            $this->seqFormulario = 0;
            $this->arrErrores[] = "No se pudo salvar el registro del formulario, reporte este error al administrador";
        }

        return $this->seqFormulario;
    }

    // guardarFormulario

    public function cargarFormulario($seqFormulario) {
        global $aptBd;

        // Obtiene los ciudadanos suscritos al formulario ( Hogar )
        $sql = "
            SELECT 
                seqCiudadano,
                bolSoporteDocumento,
                seqParentesco
            FROM T_FRM_HOGAR
            WHERE seqFormulario = $seqFormulario
            ORDER BY seqParentesco	
        ";
        $objRes = $aptBd->execute($sql);
        $this->arrCiudadano = array();
        while ($objRes->fields) {
            $claCiudadano = new Ciudadano();
            $claCiudadano->cargarCiudadano($objRes->fields['seqCiudadano']);
            $claCiudadano->bolSoporteDocumento = $objRes->fields['bolSoporteDocumento'];
            $claCiudadano->seqParentesco = $objRes->fields['seqParentesco'];
            if(empty($claCiudadano->arrErrores)) {
                $this->arrCiudadano[$objRes->fields['seqCiudadano']] = $claCiudadano;
            }else{
                foreach($claCiudadano->arrErrores as $txtError){
                    $this->arrErrores[] = $txtError;
                }
            }
            $objRes->MoveNext();
        }

        // Obtiene los datos del formulario
        if (empty($this->arrErrores) and (!empty($this->arrCiudadano))) {
            $sql = "
                SELECT
                    bolAltaCon,
                    bolCerrado,
                    bolDesplazado,
                    bolIdentificada,
                    bolInmovilizadoCuentaAhorro,
                    bolInmovilizadoCuentaAhorro2,
                    bolIntegracionSocial,
                    bolIpes,
                    bolPromesaFirmada,
                    bolSancion,
                    bolSecEducacion,
                    bolSecMujer,
                    bolSecSalud,
                    bolViabilidadLeasing,
                    bolViabilizada,
                    fchAperturaCuentaAhorro,
                    fchAperturaCuentaAhorro2,
                    fchAprobacionCredito,
                    fchArriendoDesde,
                    fchInscripcion,
                    fchNotificacion,
                    fchPostulacion,
                    fchUltimaActualizacion,
                    fchVencimiento,
                    fchVigencia,
                    numAdultosNucleo,
                    numCelular,
                    numCortes,
                    numDuracionLeasing,
                    numHabitaciones,
                    numHacinamiento,
                    numNinosNucleo,
                    numPuntajeSisben,
                    numTelefono1,
                    numTelefono2,
                    seqBancoCredito,
                    seqBancoCuentaAhorro,
                    seqBancoCuentaAhorro2,
                    seqBarrio,
                    seqCesantias,
                    seqCiudad,
                    seqConvenio,
                    seqEmpresaDonante,
                    seqEntidadSubsidio,
                    seqEstadoProceso,
                    seqFormulario,
                    seqLocalidad,
                    seqModalidad,
                    seqPeriodo,
                    seqPlanGobierno,
                    seqProyecto,
                    seqProyectoHijo,
                    seqPuntoAtencion,
                    seqSisben,
                    seqSolucion,
                    seqTipoDireccion,
                    seqTipoEsquema,
                    seqTipoFinanciacion,
                    seqUnidadProyecto,
                    seqUpz,
                    seqUsuario,
                    seqVivienda,
                    txtBarrio,
                    txtChip,
                    txtComprobanteArriendo,
                    txtCorreo,
                    txtDireccion,
                    txtDireccionSolucion,
                    txtFormulario,
                    txtMatriculaInmobiliaria,
                    txtOtro,
                    txtSoporteAporteLote,
                    txtSoporteAporteMateriales,
                    txtSoporteAvanceObra,
                    txtSoporteCesantias,
                    txtSoporteCredito,
                    txtSoporteCuentaAhorro,
                    txtSoporteCuentaAhorro2,
                    txtSoporteDonacion,
                    txtSoporteSubsidio,
                    txtSoporteSubsidioNacional,
                    valAporteAvanceObra,
                    valAporteLote,
                    valAporteMateriales,
                    valArriendo,
                    valAspiraSubsidio,
                    valAvaluo,
                    valCartaLeasing,
                    valCredito,
                    valDonacion,
                    valIngresoHogar,
                    valPresupuesto,
                    valSaldoCesantias,
                    valSaldoCuentaAhorro,
                    valSaldoCuentaAhorro2,
                    valSubsidioNacional,
                    valTotal,
                    valTotalRecursos
                FROM T_FRM_FORMULARIO
                WHERE seqFormulario = $seqFormulario
            ";
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {

                // asignacion a los atributos de clase (orden alfabetico para facilidad de busqueda)
                $this->bolAltaCon = doubleval($objRes->fields['bolAltaCon']);
                $this->bolCerrado = doubleval($objRes->fields['bolCerrado']);
                $this->bolDesplazado = doubleval($objRes->fields['bolDesplazado']);
                $this->bolIdentificada = doubleval($objRes->fields['bolIdentificada']);
                $this->bolInmovilizadoCuentaAhorro = doubleval($objRes->fields['bolInmovilizadoCuentaAhorro']);
                $this->bolInmovilizadoCuentaAhorro2 = doubleval($objRes->fields['bolInmovilizadoCuentaAhorro2']);
                $this->bolIntegracionSocial = doubleval($objRes->fields['bolIntegracionSocial']);
                $this->bolIpes = doubleval($objRes->fields['bolIpes']);
                $this->bolPromesaFirmada = doubleval($objRes->fields['bolPromesaFirmada']);
                $this->bolSancion = doubleval($objRes->fields['bolSancion']);
                $this->bolSecEducacion = doubleval($objRes->fields['bolSecEducacion']);
                $this->bolSecMujer = doubleval($objRes->fields['bolSecMujer']);
                $this->bolSecSalud = doubleval($objRes->fields['bolSecSalud']);
                $this->bolViabilidadLeasing = doubleval($objRes->fields['bolViabilidadLeasing']);
                $this->bolViabilizada = doubleval($objRes->fields['bolViabilizada']);
                $this->fchAperturaCuentaAhorro = (esFechaValida($objRes->fields['fchAperturaCuentaAhorro']))? $objRes->fields['fchAperturaCuentaAhorro'] : NULL;
                $this->fchAperturaCuentaAhorro2 = (esFechaValida($objRes->fields['fchAperturaCuentaAhorro2']))? $objRes->fields['fchAperturaCuentaAhorro2'] : NULL;
                $this->fchAprobacionCredito = (esFechaValida($objRes->fields['fchAprobacionCredito']))? $objRes->fields['fchAprobacionCredito'] : NULL;
                $this->fchArriendoDesde = (esFechaValida($objRes->fields['fchArriendoDesde']))? $objRes->fields['fchArriendoDesde'] : NULL;
                $this->fchInscripcion = (esFechaValida($objRes->fields['fchInscripcion']))? $objRes->fields['fchInscripcion'] : NULL;
                $this->fchNotificacion = (esFechaValida($objRes->fields['fchNotificacion']))? $objRes->fields['fchNotificacion'] : NULL;
                $this->fchPostulacion = (esFechaValida($objRes->fields['fchPostulacion']))? $objRes->fields['fchPostulacion'] : NULL;
                $this->fchUltimaActualizacion = (esFechaValida($objRes->fields['fchUltimaActualizacion']))? $objRes->fields['fchUltimaActualizacion'] : NULL;
                $this->fchVencimiento = (esFechaValida($objRes->fields['fchVencimiento']))? $objRes->fields['fchVencimiento'] : NULL;
                $this->fchVigencia = (esFechaValida($objRes->fields['fchVigencia']))? $objRes->fields['fchVigencia'] : NULL;
                $this->numAdultosNucleo = doubleval($objRes->fields['numAdultosNucleo']);
                $this->numCelular = doubleval($objRes->fields['numCelular']);
                $this->numCortes = doubleval($objRes->fields['numCortes']);
                $this->numDuracionLeasing = doubleval($objRes->fields['numDuracionLeasing']);
                $this->numHabitaciones = doubleval($objRes->fields['numHabitaciones']);
                $this->numHacinamiento = doubleval($objRes->fields['numHacinamiento']);
                $this->numNinosNucleo = doubleval($objRes->fields['numNinosNucleo']);
                $this->numPuntajeSisben = doubleval($objRes->fields['numPuntajeSisben']);
                $this->numTelefono1 = doubleval($objRes->fields['numTelefono1']);
                $this->numTelefono2 = doubleval($objRes->fields['numTelefono2']);
                $this->seqBancoCredito = doubleval($objRes->fields['seqBancoCredito']);
                $this->seqBancoCuentaAhorro = doubleval($objRes->fields['seqBancoCuentaAhorro']);
                $this->seqBancoCuentaAhorro2 = doubleval($objRes->fields['seqBancoCuentaAhorro2']);
                $this->seqBarrio = doubleval($objRes->fields['seqBarrio']);
                $this->seqCesantias = doubleval($objRes->fields['seqCesantias']);
                $this->seqCiudad = doubleval($objRes->fields['seqCiudad']);
                $this->seqConvenio = doubleval($objRes->fields['seqConvenio']);
                $this->seqEmpresaDonante = doubleval($objRes->fields['seqEmpresaDonante']);
                $this->seqEntidadSubsidio = doubleval($objRes->fields['seqEntidadSubsidio']);
                $this->seqEstadoProceso = doubleval($objRes->fields['seqEstadoProceso']);
                $this->seqFormulario = doubleval($objRes->fields['seqFormulario']);
                $this->seqLocalidad = doubleval($objRes->fields['seqLocalidad']);
                $this->seqModalidad = doubleval($objRes->fields['seqModalidad']);
                $this->seqPeriodo = doubleval($objRes->fields['seqPeriodo']);
                $this->seqPlanGobierno = doubleval($objRes->fields['seqPlanGobierno']);
                $this->seqProyecto = doubleval($objRes->fields['seqProyecto']);
                $this->seqProyectoHijo = doubleval($objRes->fields['seqProyectoHijo']);
                $this->seqPuntoAtencion = doubleval($objRes->fields['seqPuntoAtencion']);
                $this->seqSisben = doubleval($objRes->fields['seqSisben']);
                $this->seqSolucion = doubleval($objRes->fields['seqSolucion']);
                $this->seqTipoDireccion = doubleval($objRes->fields['seqTipoDireccion']);
                $this->seqTipoEsquema = doubleval($objRes->fields['seqTipoEsquema']);
                $this->seqTipoFinanciacion = doubleval($objRes->fields['seqTipoFinanciacion']);
                $this->seqUnidadProyecto = doubleval($objRes->fields['seqUnidadProyecto']);
                $this->seqUpz = doubleval($objRes->fields['seqUpz']);
                $this->seqUsuario = doubleval($objRes->fields['seqUsuario']);
                $this->seqVivienda = doubleval($objRes->fields['seqVivienda']);
                $this->txtBarrio = trim($objRes->fields['txtBarrio']);
                $this->txtChip = trim($objRes->fields['txtChip']);
                $this->txtComprobanteArriendo = trim($objRes->fields['txtComprobanteArriendo']);
                $this->txtCorreo = trim($objRes->fields['txtCorreo']);
                $this->txtDireccion = trim($objRes->fields['txtDireccion']);
                $this->txtDireccionSolucion = trim($objRes->fields['txtDireccionSolucion']);
                $this->txtFormulario = trim($objRes->fields['txtFormulario']);
                $this->txtMatriculaInmobiliaria = trim($objRes->fields['txtMatriculaInmobiliaria']);
                $this->txtOtro = trim($objRes->fields['txtOtro']);
                $this->txtSoporteAporteLote = trim($objRes->fields['txtSoporteAporteLote']);
                $this->txtSoporteAporteMateriales = trim($objRes->fields['txtSoporteAporteMateriales']);
                $this->txtSoporteAvanceObra = trim($objRes->fields['txtSoporteAvanceObra']);
                $this->txtSoporteCesantias = trim($objRes->fields['txtSoporteCesantias']);
                $this->txtSoporteCredito = trim($objRes->fields['txtSoporteCredito']);
                $this->txtSoporteCuentaAhorro = trim($objRes->fields['txtSoporteCuentaAhorro']);
                $this->txtSoporteCuentaAhorro2 = trim($objRes->fields['txtSoporteCuentaAhorro2']);
                $this->txtSoporteDonacion = trim($objRes->fields['txtSoporteDonacion']);
                $this->txtSoporteSubsidio = trim($objRes->fields['txtSoporteSubsidio']);
                $this->txtSoporteSubsidioNacional = trim($objRes->fields['txtSoporteSubsidioNacional']);
                $this->valAporteAvanceObra = doubleval($objRes->fields['valAporteAvanceObra']);
                $this->valAporteLote = doubleval($objRes->fields['valAporteLote']);
                $this->valAporteMateriales = doubleval($objRes->fields['valAporteMateriales']);
                $this->valArriendo = doubleval($objRes->fields['valArriendo']);
                $this->valAspiraSubsidio = doubleval($objRes->fields['valAspiraSubsidio']);
                $this->valAvaluo = doubleval($objRes->fields['valAvaluo']);
                $this->valCartaLeasing = doubleval($objRes->fields['valCartaLeasing']);
                $this->valCredito = doubleval($objRes->fields['valCredito']);
                $this->valDonacion = doubleval($objRes->fields['valDonacion']);
                $this->valIngresoHogar = doubleval($objRes->fields['valIngresoHogar']);
                $this->valPresupuesto = doubleval($objRes->fields['valPresupuesto']);
                $this->valSaldoCesantias = doubleval($objRes->fields['valSaldoCesantias']);
                $this->valSaldoCuentaAhorro = doubleval($objRes->fields['valSaldoCuentaAhorro']);
                $this->valSaldoCuentaAhorro2 = doubleval($objRes->fields['valSaldoCuentaAhorro2']);
                $this->valSubsidioNacional = doubleval($objRes->fields['valSubsidioNacional']);
                $this->valTotal = doubleval($objRes->fields['valTotal']);
                $this->valTotalRecursos = doubleval($objRes->fields['valTotalRecursos']);

            } else {
                $this->arrErrores[] = "No se encuentra el formulario [$seqFormulario]";
            }
        }
    }

    // fin cargar formulario

    public function editarFormulario($seqFormulario) {
        global $aptBd;
        try {
            $fchAperturaCuentaAhorro = ( esFechaValida( $this->fchAperturaCuentaAhorro ) )? "'" . $this->fchAperturaCuentaAhorro . "'" : "NULL";
            $fchAperturaCuentaAhorro2 = ( esFechaValida( $this->fchAperturaCuentaAhorro2 ) )? "'" . $this->fchAperturaCuentaAhorro2 . "'" : "NULL";
            $fchAprobacionCredito = ( esFechaValida( $this->fchAprobacionCredito ) )? "'" . $this->fchAprobacionCredito . "'" : "NULL";
            $fchArriendoDesde = ( esFechaValida( $this->fchArriendoDesde ) )? "'" . $this->fchArriendoDesde . "'" : "NULL";
            $fchInscripcion = ( esFechaValida( $this->fchInscripcion ) )? "'" . $this->fchInscripcion . "'" : "NULL";
            $fchNotificacion = ( esFechaValida( $this->fchNotificacion ) )? "'" . $this->fchNotificacion . "'" : "NULL";
            $fchPostulacion = ( esFechaValida( $this->fchPostulacion ) )? "'" . $this->fchPostulacion . "'" : "NULL";
            $fchUltimaActualizacion = ( esFechaValida( $this->fchUltimaActualizacion ) )? "'" . $this->fchUltimaActualizacion . "'" : "NULL";
            $fchVencimiento = ( esFechaValida( $this->fchVencimiento ) )? "'" . $this->fchVencimiento . "'" : "NULL";
            $fchVigencia = ( esFechaValida( $this->fchVigencia ) )? "'" . $this->fchVigencia . "'" : "NULL";
            $sql = "
                update t_frm_formulario set        
                    bolAltaCon = ". doubleval( $this->bolAltaCon ).",
                    bolCerrado = ". doubleval( $this->bolCerrado ) .",
                    bolDesplazado = ". doubleval( $this->bolDesplazado ) .",
                    bolIdentificada = ". doubleval( $this->bolIdentificada ) .",
                    bolInmovilizadoCuentaAhorro = ". doubleval( $this->bolInmovilizadoCuentaAhorro ) .",
                    bolInmovilizadoCuentaAhorro2 = ". doubleval( $this->bolInmovilizadoCuentaAhorro2 ) .",
                    bolIntegracionSocial = ". doubleval( $this->bolIntegracionSocial ) .",
                    bolIpes = ". doubleval( $this->bolIpes ) .",
                    bolPromesaFirmada = ". doubleval( $this->bolPromesaFirmada ) .",
                    bolSancion = ". doubleval( $this->bolSancion ) .",
                    bolSecEducacion = ". doubleval( $this->bolSecEducacion ) .",
                    bolSecMujer = ". doubleval( $this->bolSecMujer ) .",
                    bolSecSalud = ". doubleval( $this->bolSecSalud ) .",
                    bolViabilidadLeasing = ". doubleval( $this->bolViabilidadLeasing ) .",
                    bolViabilizada = ". doubleval( $this->bolViabilizada ) .",
                    fchAperturaCuentaAhorro = ". $fchAperturaCuentaAhorro .",
                    fchAperturaCuentaAhorro2 = ". $fchAperturaCuentaAhorro2 .",
                    fchAprobacionCredito = ". $fchAprobacionCredito .",
                    fchArriendoDesde = ". $fchArriendoDesde .",
                    fchInscripcion = ". $fchInscripcion .",
                    fchNotificacion = ". $fchNotificacion .",
                    fchPostulacion = ". $fchPostulacion .",
                    fchUltimaActualizacion = ". $fchUltimaActualizacion .",
                    fchVencimiento = ". $fchVencimiento .",
                    fchVigencia = ". $fchVigencia .",
                    numAdultosNucleo = ". doubleval( $this->numAdultosNucleo ) .",
                    numCelular = ". doubleval( $this->numCelular ) .",
                    numDuracionLeasing = ". doubleval( $this->numDuracionLeasing ) .",
                    numCortes = ". doubleval( $this->numCortes ) .",
                    numHabitaciones = ". doubleval( $this->numHabitaciones ) .",
                    numHacinamiento = ". doubleval( $this->numHacinamiento ) .",
                    numNinosNucleo = ". doubleval( $this->numNinosNucleo ) .",
                    numPuntajeSisben = ". doubleval( $this->numPuntajeSisben ) .",
                    numTelefono1 = ". doubleval( $this->numTelefono1 ) .",
                    numTelefono2 = ". doubleval( $this->numTelefono2 ) .",
                    seqBancoCredito = ". doubleval( $this->seqBancoCredito ) .",
                    seqBancoCuentaAhorro = ". doubleval( $this->seqBancoCuentaAhorro ) .",
                    seqBancoCuentaAhorro2 = ". doubleval( $this->seqBancoCuentaAhorro2 ) .",
                    seqBarrio = ". doubleval( $this->seqBarrio ) .",
                    seqCesantias = ". doubleval( $this->seqCesantias ) .",
                    seqCiudad = ". doubleval( $this->seqCiudad ) .",
                    seqConvenio = ". doubleval( $this->seqConvenio ) .",
                    seqEmpresaDonante = ". doubleval( $this->seqEmpresaDonante ) .",
                    seqEntidadSubsidio = ". doubleval( $this->seqEntidadSubsidio ) .",
                    seqEstadoProceso = ". doubleval( $this->seqEstadoProceso ) .",    
                    seqLocalidad = ". doubleval( $this->seqLocalidad ) .",
                    seqModalidad = ". doubleval( $this->seqModalidad ) .",
                    seqPeriodo = ". doubleval( $this->seqPeriodo ) .",
                    seqPlanGobierno = ". doubleval( $this->seqPlanGobierno ) .",
                    seqProyecto = ". doubleval( $this->seqProyecto ) .",
                    seqProyectoHijo = ". doubleval( $this->seqProyectoHijo ) .",
                    seqPuntoAtencion = ". doubleval( $this->seqPuntoAtencion ) .",
                    seqSisben = ". doubleval( $this->seqSisben ) .",
                    seqSolucion = ". doubleval( $this->seqSolucion ) .",
                    seqTipoDireccion = ". doubleval( $this->seqTipoDireccion ) .",
                    seqTipoEsquema = ". doubleval( $this->seqTipoEsquema ) .",
                    seqTipoFinanciacion = ". doubleval( $this->seqTipoFinanciacion ) .",
                    seqUnidadProyecto = ". doubleval( $this->seqUnidadProyecto ) .",
                    seqUpz = ". doubleval( $this->seqUpz ) .",
                    seqUsuario = ". doubleval( $this->seqUsuario ) .",
                    seqVivienda = ". doubleval( $this->seqVivienda ) .",
                    txtBarrio = '". trim( $this->txtBarrio ) ."',
                    txtChip = '". trim( $this->txtChip ) ."',
                    txtComprobanteArriendo = '". trim( $this->txtComprobanteArriendo ) ."',
                    txtCorreo = '". trim( $this->txtCorreo ) ."',
                    txtDireccion = '". trim( $this->txtDireccion ) ."',
                    txtDireccionSolucion = '". trim( $this->txtDireccionSolucion ) ."',
                    txtFormulario = '". trim( $this->txtFormulario ) ."',
                    txtMatriculaInmobiliaria = '". trim( $this->txtMatriculaInmobiliaria ) ."',
                    txtOtro = '". trim( $this->txtOtro ) ."',
                    txtSoporteAporteLote = '". trim( $this->txtSoporteAporteLote ) ."',
                    txtSoporteAporteMateriales = '". trim( $this->txtSoporteAporteMateriales ) ."',
                    txtSoporteAvanceObra = '". trim( $this->txtSoporteAvanceObra ) ."',
                    txtSoporteCesantias = '". trim( $this->txtSoporteCesantias ) ."',
                    txtSoporteCredito = '". trim( $this->txtSoporteCredito ) ."',
                    txtSoporteCuentaAhorro = '". trim( $this->txtSoporteCuentaAhorro ) ."',
                    txtSoporteCuentaAhorro2 = '". trim( $this->txtSoporteCuentaAhorro2 ) ."',
                    txtSoporteDonacion = '". trim( $this->txtSoporteDonacion ) ."',
                    txtSoporteSubsidio = '". trim( $this->txtSoporteSubsidio ) ."',
                    txtSoporteSubsidioNacional = '". trim( $this->txtSoporteSubsidioNacional ) ."',
                    valAporteAvanceObra = ". doubleval( $this->valAporteAvanceObra ) .",
                    valAporteLote = ". doubleval( $this->valAporteLote ) .",
                    valAporteMateriales = ". doubleval( $this->valAporteMateriales ) .",
                    valArriendo = ". doubleval( $this->valArriendo ) .",
                    valAspiraSubsidio = ". doubleval( $this->valAspiraSubsidio ) .",
                    valAvaluo = ". doubleval( $this->valAvaluo ) .",
                    valCartaLeasing = ". doubleval( $this->valCartaLeasing ) .",
                    valCredito = ". doubleval( $this->valCredito ) .",
                    valDonacion = ". doubleval( $this->valDonacion ) .",
                    valIngresoHogar = ". doubleval( $this->valIngresoHogar ) .",
                    valPresupuesto = ". doubleval( $this->valPresupuesto ) .",
                    valSaldoCesantias = ". doubleval( $this->valSaldoCesantias ) .",
                    valSaldoCuentaAhorro = ". doubleval( $this->valSaldoCuentaAhorro ) .",
                    valSaldoCuentaAhorro2 = ". doubleval( $this->valSaldoCuentaAhorro2 ) .",
                    valSubsidioNacional = ". doubleval( $this->valSubsidioNacional ) .",
                    valTotal = ". doubleval( $this->valTotal ) .",
                    valTotalRecursos = " . doubleval( $this->valTotalRecursos ) . "
                where seqFormulario = " . $seqFormulario . "
            ";
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se ha podido actualizar la informacion del formulario [$seqFormulario]";
            $this->arrErrores[] = $objError->getMessage();
        }

        // Actualiza la unidad del proyecto
        if ( empty($this->arrErrores) ) {
            try {
                $sql = "
                    update t_pry_unidad_proyecto set
                      seqFormulario = 0
                    where seqFormulario = " . $this->seqFormulario . "
                ";
                $aptBd->execute($sql);
                if( $this->seqUnidadProyecto > 1 ) {
                    $sql = "
                        update t_pry_unidad_proyecto set
                          seqFormulario = " . $this->seqFormulario . "
                        where seqUnidadProyecto = " . $this->seqUnidadProyecto . "
                    ";
                    $aptBd->execute($sql);
                }
            }catch(Exception $objError) {
                $this->arrErrores[] = "No se ha podido actualizar la unidad del proyecto relacionada";
                $this->arrErrores[] = $objError->getMessage();
            }
        }
    }

    // Editar Formulario

    public function listosCalificacion() {
        global $aptBd;
        $sql = "
                    SELECT
                        frm.seqFormulario
                    FROM
                        T_FRM_FORMULARIO frm,
                        T_FRM_HOGAR hog, 
                        T_CIU_CIUDADANO ciu
                    WHERE hog.seqCiudadano = ciu.seqCiudadano
                        and hog.seqFormulario = frm.seqFormulario
                        and frm.bolCerrado = 1
                        and frm.seqEstadoProceso = 7
                        AND frm.fchPostulacion <= ( 
                            SELECT fchFinal 
                            FROM T_FRM_PERIODO 
                            WHERE seqPeriodo = (
                                SELECT max(seqPeriodo) 
                                FROM T_FRM_PERIODO
                            ) 
                        )					
                    GROUP BY 
                        frm.seqFormulario
                ";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $arrFormulario[] = $objRes->fields['seqFormulario'];
            $objRes->MoveNext();
        }
        return $arrFormulario;
    }

    // listos para calificar

    /**
     * RECIBE UN NUMERO DE FORMULARIO Y DICE SI ES
     * LA SECUENCIA QUE SIGUE O ESTA ERRADA
     * @author Bernardo Zerda
     * @param String txtFormulario
     * @return Integer numProximaSecuencia
     * @version 1.0 Julio 2009
     */
    public function tutorSecuencia($txtFormulario) {

        global $aptBd;

        // Separa el tutor del numero del formulario
        $arrFormulario = split("-", $txtFormulario);
        $numTutor = $arrFormulario[0];
        $numFormulario = doubleval($arrFormulario[1]);

        // consulta los numeros de formulario
        $sql = "
                    SELECT txtFormulario
                    FROM T_FRM_FORMULARIO
                    WHERE txtFormulario LIKE '$numTutor%'
                    OR txtFormulario LIKE '0$numTutor%'
                ";
        $objRes = $aptBd->execute($sql);
        $arrSecuencia = array();
        while ($objRes->fields) {
            $arrFormularioBd = split("[\/-]", $objRes->fields['txtFormulario']);
            $numTutorBd = doubleval($arrFormularioBd[0]);
            $numFormularioBd = doubleval($arrFormularioBd[1]);
            $arrSecuencia[] = $numFormularioBd;
            $objRes->MoveNext();
        }
        sort($arrSecuencia); // Ordena la secuencia
        // Numero de la proxima secuencia
        $numProximaSecuencia = ( $arrSecuencia[( count($arrSecuencia) - 1 )] + 1 );

        return $numProximaSecuencia;
    }

    // tutor secuencia

    /**
     * OBTIENE LAS FECHAS DE INSCRIPCION Y POSTULACION
     * PARA QUE QUEDEN FIJAS AL MOMENTO DE ACTUALIZAR
     * EL FORMULARIO
     * @author Bernardo Zerda
     * @param Integer seqFormulario
     * @return Array arrFechas
     * @version 1.0 Julio 2009
     */
    public function obtenerFechas($seqFormulario) {
        global $aptBd;
        $arrFechas = array();
        $sql = "
                    SELECT fchInscripcion, fchPostulacion, fchNotificacion
                    FROM T_FRM_FORMULARIO
                    WHERE seqFormulario = $seqFormulario
                ";
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {
            $arrFechas['fchInscripcion'] = ( $objRes->fields['fchInscripcion'] != "0000-00-00" ) ? $objRes->fields['fchInscripcion'] : "";
            $arrFechas['fchPostulacion'] = ( $objRes->fields['fchPostulacion'] != "0000-00-00" ) ? $objRes->fields['fchPostulacion'] : "";
            $arrFechas['fchNotificacion'] = ( $objRes->fields['fchNotificacion'] != "0000-00-00" ) ? $objRes->fields['fchNotificacion'] : "";
        }
        return $arrFechas;
    }

    // obtener fechas

    /**
     * VERIFICA LA EXISTENCIA DE UN IDENTIFICADOR
     * DE FORMULARIO EN LA TABLA T_FRM_FORMULARIO
     * @author Bernardo Zerda
     * @param Integer seqFormulario
     * @return Boolean ==> cuando existe
     * 		   String  ==> Texto del error cuando no existe
     */
    public function formularioExiste($seqFormulario) {
        global $aptBd;
        $sql = "
                    SELECT count( seqFormulario ) as cuenta
                    FROM T_FRM_FORMULARIO
                    WHERE seqFormulario = $seqFormulario
                ";
        try {
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields["cuenta"] == 1) {
                return true;
            } else {
                return "El formulario $seqFormulario no existe";
            }
        } catch (Exception $objError) {
            return "El secuencial del formulario no puede ser vacio";
        }
    }

    public function obtenerActosAdministrativos() {

        $claActosAdministrativos = new ActoAdministrativo;
        $arrFormularioActo = $claActosAdministrativos->actoExisteCiudadano($_POST['cedula']);

        $txtJs = "";
        if (!empty($arrFormularioActo)) {
            $arrHogaresVinculados = array();
            foreach ($arrFormularioActo as $seqFormularioActo) {
                $arrHogaresVinculados[] = $claActosAdministrativos->obtenerActoAdministrativo($seqFormularioActo);
            }

            //			Secuensiales Resolucion modificatoria
            //			5	Resolucion que Modifica
            //			8	Fecha resolucion


            $arrTiposActosAdministrativos = array();
            $arrCaracteristicasActosAdministrativos = array();
            $arrActosAdministrativo = array();
            foreach ($arrHogaresVinculados as $arrDatosHogares) {

                $seqTipoActo = $arrDatosHogares['seqTipoActo'];
                $numActo = $arrDatosHogares['numActo'];
                $fchActo = $arrDatosHogares['fchActo'];
                $seqFormularioActo = $arrDatosHogares['seqFormularioActo'];

                if (trim($numActo) != 0 and trim($fchActo) != "") {
                    $arrActosAdministrativo[] = $claActosAdministrativos->cargarActoAdministrativoNumero($seqTipoActo, $numActo, $fchActo, $seqFormularioActo);
                    $arrCaracteristicasActosAdministrativos[] = "";
                }
            }

            //			pr( $arrHogaresVinculados );
            //			pr( $arrActosAdministrativo );

            $arrArbolMostrar = array();
            $i = 0;
            foreach ($arrHogaresVinculados as $arrActo) {

                unset($arrActosAdministrativo[$i][0]);
                $arrActoCiudadano = $arrActosAdministrativo[$i];
                $seqTipoActo = $arrActo["seqTipoActo"];
                $numActo = $arrActo["numActo"];
                $fchActo = $arrActo["fchActo"];
                $txtTitulo = "";

                $txtTitulo = $arrActo["txtNombreTipoActo"] . " Número " . $numActo . " del " . formatoFechaTextoFecha($fchActo);


                // RESOLUCION MODIFICATORIA
                if ($seqTipoActo == 2) {
                    $arrResolucionModifica = $claActosAdministrativos->obtenerResolucionModifica($numActo, $fchActo, $seqTipoActo);
                    $txtTitulo .= " Resolucion que Modifica: " . $arrResolucionModifica["Resolucion que Modifica"];
                    $txtTitulo .= " Fecha resolucion: " . formatoFechaTextoFecha($arrResolucionModifica["Fecha resolucion"]);
                }

                // RESOLUCION MODIFICATORIA
                if ($seqTipoActo == 4) {
                    $arrResolucionModifica = $claActosAdministrativos->obtenerResolucionModifica($numActo, $fchActo, $seqTipoActo);
                    $txtTitulo .= " En respuesta a Resolucion numero " . $arrResolucionModifica["Resolucion que Modifica"];
                    $txtTitulo .= " del " . formatoFechaTextoFecha($arrResolucionModifica["Fecha Resolucion"]);
                }

                // RESOLUCION RENUNCIA
                if ($seqTipoActo == 6) {
                    $arrResolucionModifica = $claActosAdministrativos->obtenerResolucionModifica($numActo, $fchActo, $seqTipoActo);
                    $txtTitulo .= " Resolución de Asignación " . $arrResolucionModifica["Resolución Asignacion"];
                    $txtTitulo .= " del " . formatoFechaTextoFecha($arrResolucionModifica["Fecha Resolución Asignacion"]);
                }

                // NOTIFICACIONES
                if ($seqTipoActo == 7) {
                    $arrResolucionAsociada = $claActosAdministrativos->obtenerResolucionModifica($numActo, $fchActo, $seqTipoActo);
                    $txtTipoActo = $claActosAdministrativos->tipoActo($arrResolucionAsociada["Numero Acto Administrativo"], $arrResolucionAsociada["Fecha Acto Administrativo"]);
                    $txtTitulo .= " para la $txtTipoActo " . $arrResolucionAsociada["Numero Acto Administrativo"];
                    $txtTitulo .= " del " . formatoFechaTextoFecha($arrResolucionAsociada["Fecha Acto Administrativo"]);
                }

                $i++;
                $arrArbolMostrar[$txtTitulo] = array();

                foreach ($arrActoCiudadano as $arrDatosCiudadanoActo) {
                    $txtCiudadano = utf8_encode($arrDatosCiudadanoActo[10] . " Numero Documento: " . number_format($arrDatosCiudadanoActo[9]));
                    switch ($seqTipoActo) {
                        case 2: // RESOLUCION MODIFICATORIA
                            $txtModificacion = "Campo Modifica: " . $arrDatosCiudadanoActo[11] .
                                    ". Campo Incorrecto: " . $arrDatosCiudadanoActo[12] .
                                    ". Campo Correcto: " . $arrDatosCiudadanoActo[13];
                            $arrArbolMostrar[$txtTitulo][$txtCiudadano][] = utf8_encode($txtModificacion);
                            break;
                        case 3: // RESOLUCION INHABILITADOS
                            if ($arrDatosCiudadanoActo[11]) {
                                $txtCausa = str_replace(";", "<br />", $arrDatosCiudadanoActo[11]);
                                $txtCausa = str_replace(":", ": ", $txtCausa);
                                $txtInhabilidad = "Inhabilidad: <br />" . $txtCausa .
                                        "Causa: " . $arrDatosCiudadanoActo[12] .
                                        "<br />Fuente: " . $arrDatosCiudadanoActo[13];
                                $arrArbolMostrar[$txtTitulo][$txtCiudadano][] = utf8_encode($txtInhabilidad);
                            }
                            break;
                        case 4: // RECURSO DE REPOSICION
                            if ($arrDatosCiudadanoActo[11]) {
                                $txtRecursoReposicion = "Resultado: " . $arrDatosCiudadanoActo[11];
                                $arrArbolMostrar[$txtTitulo][$txtCiudadano] = utf8_encode($txtRecursoReposicion);
                            }
                            break;
                        default:
                            $arrArbolMostrar[$txtTitulo][$txtCiudadano] = "";
                            break;
                    }
                }
            }

            $txtJs = "var objArbol = new YAHOO.widget.TreeView('treeDivArbolMostrar', [";

            foreach ($arrArbolMostrar as $txtResolucion => $arrActoCiudadano) {
                $txtJs .= "{";
                $txtJs .= "type: 'text',";
                $txtJs .= "label: '$txtResolucion',";
                $txtJs .= "idCampo: '',";
                $txtJs .= "children: [";

                foreach ($arrActoCiudadano as $txtNombreCiudadano => $txtDescripcionActo) {
                    $txtJs .= "{";
                    $txtJs .= "type: 'text',";
                    $txtJs .= "label: '$txtNombreCiudadano'";
                    if (is_array($txtDescripcionActo)) {
                        $txtJs .= ",children: [";
                        foreach ($txtDescripcionActo as $txtDescripcion) {
                            $txtJs .= "{";
                            $txtJs .= "type: 'text',";
                            $txtJs .= "label: '$txtDescripcion'";
                            $txtJs .= "},";
                        }
                        $txtJs = trim($txtJs, ",");
                        $txtJs .= "]";
                    } else if ($txtDescripcionActo) {
                        $txtJs .= ",children: [";
                        $txtJs .= "{";
                        $txtJs .= "type: 'text',";
                        $txtJs .= "label: '$txtDescripcionActo'";
                        $txtJs .= "}]";
                    }

                    $txtJs .= "},";
                }
                $txtJs = trim($txtJs, ",");
                $txtJs .= "]";
                $txtJs .= "},";
            }
            $txtJs = trim($txtJs, ",") . "]);";
        }
        return $txtJs;
    }

    public function borrarFormulario($seqFormulario) {
        global $aptBd;
        $sql = "
                DELETE
                FROM T_FRM_FORMULARIO
                WHERE seqFormulario = $seqFormulario
             ";
        $aptBd->execute($sql);
    }

    public function relacionarCiudadanoFormulario(){
        global $aptBd;
        try{
            $sql = "
                delete
                from t_frm_hogar
                where seqFormulario = " . $this->seqFormulario . "
            ";
            $aptBd->execute($sql);
            foreach($this->arrCiudadano as $seqCiudadano => $objCiudadano){
                $sql = "
                    insert into t_frm_hogar (
                      seqCiudadano, 
                      seqFormulario, 
                      bolSoporteDocumento, 
                      seqParentesco
                    ) values (
                      ". $seqCiudadano .",
                      ". $this->seqFormulario .",
                      ". $objCiudadano->bolSoporteDocumento .",
                      ". $objCiudadano->seqParentesco ."
                    );
                ";
                $aptBd->execute($sql);
            }
        } catch ( Exception $objError ){
            $this->arrErrores[] = "No se ha podido establecer la relación entre los ciudadanos y el formulario " . $this->seqFormulario;
            $this->arrErrores[] = $objError->getMessage();
        }
        return true;
    }


}

// Fin de clase
?>