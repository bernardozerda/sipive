<?php

/**
 * CLASE QUE MANEJA LOS FORMULARIOS DE INSCRIPCION Y 
 * POSTULACION
 * @author Bernardo Zerda
 * @version 1.0 Mayo 2009
 */
class FormularioSubsidiosActos {

    // Variables para el ciudadano
    public $arrCiudadano;
    // Variables del formulario
    public $seqFormulario;
    public $txtDireccion;
    public $seqTipoDireccion;
    public $numTelefono1;
    public $numTelefono2;
    public $numCelular;
    public $txtBarrio;
    public $txtCorreo;
    public $txtMatriculaInmobiliaria;
    public $txtChip;
    public $seqUnidadProyecto;
    public $seqTipoFinanciacion;
    public $bolViabilizada;
    public $bolIdentificada;
    public $bolDesplazado;
    public $seqSolucion;
    public $valPresupuesto;
    public $valAvaluo;
    public $valTotal;
    public $seqModalidad;
    public $seqPlanGobierno;
    public $seqBancoCuentaAhorro;
    public $fchAperturaCuentaAhorro;
    public $bolInmovilizadoCuentaAhorro;
    public $valSaldoCuentaAhorro;
    public $txtSoporteCuentaAhorro;
    public $seqBancoCuentaAhorro2;
    public $fchAperturaCuentaAhorro2;
    public $bolInmovilizadoCuentaAhorro2;
    public $valSaldoCuentaAhorro2;
    public $txtSoporteCuentaAhorro2;
    public $valSubsidioNacional;
    public $txtSoporteSubsidioNacional;
    public $txtSoporteSubsidio;
    public $valAporteLote;
    public $txtSoporteAporteLote;
    public $seqCesantias;
    public $valSaldoCesantias;
    public $txtSoporteCesantias;
    public $valAporteAvanceObra;
    public $txtSoporteAvanceObra;
    public $valAporteMateriales;
    public $txtSoporteAporteMateriales;
    public $seqEmpresaDonante;
    public $valDonacion;
    public $txtSoporteDonacion;
    public $seqBancoCredito;
    public $valCredito;
    public $txtSoporteCredito;
    public $valTotalRecursos;
    public $valAspiraSubsidio;
    public $seqVivienda;
    public $valArriendo;
    public $bolPromesaFirmada;
    public $fchInscripcion;
    public $fchPostulacion;
    public $fchVencimiento;
    public $bolIntegracionSocial;
    public $bolSecSalud;
    public $bolSecEducacion;
    public $bolIpes;
    public $bolReconocimientoFP;
    public $txtOtro;
    public $numAdultosNucleo;
    public $numNinosNucleo;
    public $seqUsuario;
    public $seqPuntoAtencion;
    public $bolCerrado;
    public $seqLocalidad;
    public $seqCiudad;
    public $valIngresoHogar;
    public $seqEstadoProceso;
    public $txtDireccionSolucion;
    public $fchAprobacionCredito;
    public $txtFormulario;
    public $fchUltimaActualizacion;
    public $seqProyecto;
    public $seqProyectoHijo; // Conjunto Residencial (Opcional)
    public $numCortes;
    public $seqPeriodo;
    public $fchArriendoDesde;
    public $bolSancion;
    public $fchVigencia;
    public $arrErrores;
    public $seqBarrio;
    public $seqUpz;
    public $seqSisben;
    public $fchNotificacion;
    public $txtComprobanteArriendo;
    public $numPuntajeSisben;
    public $seqTipoEsquema;
    public $seqEntidadSubsidio;

    public function FormularioSubsidios() {
        $this->arrCiudadano = array();
        $this->seqFormulario = 0;
        $this->txtDireccion = "";
        $this->seqTipoDireccion = 0;
        $this->numTelefono1 = "";
        $this->numTelefono2 = "";
        $this->numCelular = "";
        $this->txtBarrio = "";
        $this->txtCorreo = "";
        $this->txtMatriculaInmobiliaria = "";
        $this->txtChip = "";
        $this->seqUnidadProyecto = 1;
        $this->seqTipoFinanciacion = 1;
        $this->bolViabilizada = 0;
        $this->bolIdentificada = 0;
        $this->bolDesplazado = "";
        $this->seqSolucion = "";
        $this->valPresupuesto = "";
        $this->valAvaluo = "";
        $this->valTotal = "";
        $this->seqModalidad = "";
        $this->seqPlanGobierno = "";
        $this->seqBancoCuentaAhorro = 1;
        $this->fchAperturaCuentaAhorro = "";
        $this->bolInmovilizadoCuentaAhorro = "";
        $this->valSaldoCuentaAhorro = "";
        $this->txtSoporteCuentaAhorro = "";
        $this->seqBancoCuentaAhorro2 = 1;
        $this->fchAperturaCuentaAhorro2 = "";
        $this->bolInmovilizadoCuentaAhorro2 = "";
        $this->valSaldoCuentaAhorro2 = "";
        $this->txtSoporteCuentaAhorro2 = "";
        $this->valSubsidioNacional = "";
        $this->txtSoporteSubsidioNacional = "";
        $this->txtSoporteSubsidio = "";
        $this->valAporteLote = "";
        $this->txtSoporteAporteLote = "";
        $this->seqCesantias = "";
        $this->valSaldoCesantias = "";
        $this->txtSoporteCesantias = "";
        $this->valAporteAvanceObra = "";
        $this->txtSoporteAvanceObra = "";
        $this->valAporteMateriales = "";
        $this->txtSoporteAporteMateriales = "";
        $this->seqEmpresaDonante = 1;
        $this->valDonacion = "";
        $this->txtSoporteDonacion = "";
        $this->seqBancoCredito = "";
        $this->valCredito = "";
        $this->txtSoporteCredito = "";
        $this->valTotalRecursos = "";
        $this->valAspiraSubsidio = "";
        $this->seqVivienda = "";
        $this->valArriendo = "";
        $this->bolPromesaFirmada = "";
        $this->fchInscripcion = "";
        $this->fchPostulacion = "";
        $this->fchVencimiento = "";
        $this->bolIntegracionSocial = "";
        $this->bolSecSalud = "";
        $this->bolSecEducacion = "";
        $this->bolIpes = "";
        $this->bolReconocimientoFP = "";
        $this->txtOtro = "";
        $this->numAdultosNucleo = 0;
        $this->numNinosNucleo = 0;
        $this->seqUsuario = 0;
        $this->seqPuntoAtencion = 0;
        $this->bolCerrado = 0;
        $this->seqLocalidad = 0;
        $this->seqCiudad = 0;
        $this->valIngresoHogar = 0;
        $this->seqEstadoProceso = 0;
        $this->txtDireccionSolucion = "";
        $this->fchAprobacionCredito = "";
        $this->txtFormulario = "";
        $this->fchUltimaActualizacion = "";
        $this->seqProyecto = 37;
        $this->seqProyectoHijo = "";
        $this->numCortes = 0;
        $this->seqPeriodo = 1;
        $this->fchArriendoDesde = "";
        $this->bolSancion = 0;
        $this->fchVigencia = "";
        $this->seqUpz = "";
        $this->seqBarrio = "";
        $this->seqSisben = 1;
        $this->fchNotificacion = "";
        $this->txtComprobanteArriendo = "";
        $this->numPuntajeSisben = 0;
        $this->seqTipoEsquema = 0;
        $this->seqEntidadSubsidio = 1;
        $this->arrErrores = array();
    }

    // Fin Constructor

    public function guardarFormulario() {
        global $aptBd;

        $sql = "
                INSERT INTO  t_aad_formulario_acto (
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
                   bolIpes,
                   bolReconocimientoFP,
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
                   fchAprobacionCredito,
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
                   seqTipoEsquema
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
                   \"" . $this->bolIpes . "\",
                   \"" . $this->bolReconocimientoFP . "\",
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
                   \"" . $this->fchAprobacionCredito . "\",
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
                   \"" . $this->seqTipoEsquema . "\"
                )		
             ";
        /* if($_SESSION['seqUsuario'] == 251){
          echo $sql;
          } */

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

    public function cargarFormulario($seqFormularioActo) {
        global $aptBd;
        $seqFormularioActo = $seqFormularioActo;
        $this->arrCiudadano = array();

        // Obtiene los ciudadanos suscritos al formulario ( Hogar )
        $sql = "
                    SELECT 
                        seqCiudadanoActo,
                        seqParentesco
                    FROM 
                        t_aad_hogar_acto
                    WHERE 
                        seqFormularioActo = $seqFormularioActo 
                    ORDER BY 
                        seqParentesco	
                ";
        //echo "<br>*****" .$sql." *****<br>";

        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $claCiudadano = new CiudadanoActo;
            $claCiudadano->cargarCiudadano($objRes->fields['seqCiudadanoActo']);
            // $claCiudadano->bolSoporteDocumento = $objRes->fields['bolSoporteDocumento'];
            // var_dump($claCiudadano);
            $claCiudadano->seqParentesco = $objRes->fields['seqParentesco'];
            $this->arrCiudadano[$objRes->fields['seqCiudadanoActo']] = $claCiudadano;
            $objRes->MoveNext();
            // echo "<br>".$seqFormularioActo."<br>";
        }

        // Obtiene los datos del formulario
        if (!empty($this->arrCiudadano)) {
            $sql = "
                   SELECT
                      seqFormulario,
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
                      bolIpes,
                      bolReconocimientoFP,
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
                      fchAprobacionCredito,
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
                      seqPeriodo,
                      bolSancion,
                      fchVigencia,
                      seqTipoEsquema,
                      seqEntidadSubsidio
                   FROM  t_aad_formulario_acto
                   WHERE seqFormularioActo = $seqFormularioActo
                    ";
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $this->seqFormulario = $objRes->fields['seqFormulario'];
                $this->txtDireccion = $objRes->fields['txtDireccion'];
                $this->seqTipoDireccion = $objRes->fields['seqTipoDireccion'];
                $this->numTelefono1 = $objRes->fields['numTelefono1'];
                $this->numTelefono2 = $objRes->fields['numTelefono2'];
                $this->numCelular = $objRes->fields['numCelular'];
                $this->txtBarrio = $objRes->fields['txtBarrio'];
                $this->txtCorreo = $objRes->fields['txtCorreo'];
                $this->txtMatriculaInmobiliaria = strtoupper($objRes->fields['txtMatriculaInmobiliaria']);
                $this->txtChip = strtoupper($objRes->fields['txtChip']);
                $this->seqUnidadProyecto = strtoupper($objRes->fields['seqUnidadProyecto']);
                $this->seqTipoFinanciacion = strtoupper($objRes->fields['seqTipoFinanciacion']);
                $this->bolViabilizada = $objRes->fields['bolViabilizada'];
                $this->bolIdentificada = $objRes->fields['bolIdentificada'];
                $this->bolDesplazado = $objRes->fields['bolDesplazado'];
                $this->seqSolucion = $objRes->fields['seqSolucion'];
                $this->valPresupuesto = $objRes->fields['valPresupuesto'];
                $this->valAvaluo = $objRes->fields['valAvaluo'];
                $this->valTotal = $objRes->fields['valTotal'];
                $this->seqModalidad = $objRes->fields['seqModalidad'];
                $this->seqPlanGobierno = $objRes->fields['seqPlanGobierno'];
                $this->seqBancoCuentaAhorro = $objRes->fields['seqBancoCuentaAhorro'];
                $this->fchAperturaCuentaAhorro = $objRes->fields['fchAperturaCuentaAhorro'];
                $this->bolInmovilizadoCuentaAhorro = $objRes->fields['bolInmovilizadoCuentaAhorro'];
                $this->valSaldoCuentaAhorro = $objRes->fields['valSaldoCuentaAhorro'];
                $this->txtSoporteCuentaAhorro = $objRes->fields['txtSoporteCuentaAhorro'];
                $this->seqBancoCuentaAhorro2 = $objRes->fields['seqBancoCuentaAhorro2'];
                $this->fchAperturaCuentaAhorro2 = $objRes->fields['fchAperturaCuentaAhorro2'];
                $this->bolInmovilizadoCuentaAhorro2 = $objRes->fields['bolInmovilizadoCuentaAhorro2'];
                $this->valSaldoCuentaAhorro2 = $objRes->fields['valSaldoCuentaAhorro2'];
                $this->txtSoporteCuentaAhorro2 = $objRes->fields['txtSoporteCuentaAhorro2'];
                $this->valSubsidioNacional = $objRes->fields['valSubsidioNacional'];
                $this->txtSoporteSubsidio = $objRes->fields['txtSoporteSubsidio'];
                $this->valAporteLote = $objRes->fields['valAporteLote'];
                $this->txtSoporteAporteLote = $objRes->fields['txtSoporteAporteLote'];
                $this->seqCesantias = $objRes->fields['seqCesantias'];
                $this->valSaldoCesantias = $objRes->fields['valSaldoCesantias'];
                $this->txtSoporteCesantias = $objRes->fields['txtSoporteCesantias'];
                $this->valAporteAvanceObra = $objRes->fields['valAporteAvanceObra'];
                $this->txtSoporteAvanceObra = $objRes->fields['txtSoporteAvanceObra'];
                $this->valAporteMateriales = $objRes->fields['valAporteMateriales'];
                $this->txtSoporteAporteMateriales = $objRes->fields['txtSoporteAporteMateriales'];
                $this->seqEmpresaDonante = $objRes->fields['seqEmpresaDonante'];
                $this->valDonacion = $objRes->fields['valDonacion'];
                $this->txtSoporteDonacion = $objRes->fields['txtSoporteDonacion'];
                $this->seqBancoCredito = $objRes->fields['seqBancoCredito'];
                $this->valCredito = $objRes->fields['valCredito'];
                $this->txtSoporteCredito = $objRes->fields['txtSoporteCredito'];
                $this->valTotalRecursos = $objRes->fields['valTotalRecursos'];
                $this->valAspiraSubsidio = $objRes->fields['valAspiraSubsidio'];
                $this->seqVivienda = $objRes->fields['seqVivienda'];
                $this->valArriendo = $objRes->fields['valArriendo'];
                $this->bolPromesaFirmada = $objRes->fields['bolPromesaFirmada'];
                $this->fchInscripcion = $objRes->fields['fchInscripcion'];
                $this->fchPostulacion = $objRes->fields['fchPostulacion'];
                $this->fchVencimiento = $objRes->fields['fchVencimiento'];
                $this->bolIntegracionSocial = $objRes->fields['bolIntegracionSocial'];
                $this->bolSecSalud = $objRes->fields['bolSecSalud'];
                $this->bolSecEducacion = $objRes->fields['bolSecEducacion'];
                $this->bolIpes = $objRes->fields['bolIpes'];
                $this->bolReconocimientoFP = $objRes->fields['bolReconocimientoFP'];
                $this->txtOtro = $objRes->fields['txtOtro'];
                $this->numAdultosNucleo = $objRes->fields['numAdultosNucleo'];
                $this->numNinosNucleo = $objRes->fields['numNinosNucleo'];
                $this->seqUsuario = $objRes->fields['seqUsuario'];
                $this->bolCerrado = $objRes->fields['bolCerrado'];
                $this->seqLocalidad = $objRes->fields['seqLocalidad'];
                $this->seqCiudad = $objRes->fields['seqCiudad'];
                $this->valIngresoHogar = $objRes->fields['valIngresoHogar'];
                $this->seqEstadoProceso = $objRes->fields['seqEstadoProceso'];
                $this->txtDireccionSolucion = $objRes->fields['txtDireccionSolucion'];
                $this->seqPuntoAtencion = $objRes->fields['seqPuntoAtencion'];
                $this->fchAprobacionCredito = $objRes->fields['fchAprobacionCredito'];
                $this->txtFormulario = $objRes->fields['txtFormulario'];
                $this->fchUltimaActualizacion = $objRes->fields['fchUltimaActualizacion'];
                $this->seqProyecto = $objRes->fields['seqProyecto'];
                $this->seqProyectoHijo = $objRes->fields['seqProyectoHijo'];
                $this->txtSoporteSubsidioNacional = $objRes->fields['txtSoporteSubsidioNacional'];
                $this->fchArriendoDesde = $objRes->fields['fchArriendoDesde'];
                $this->txtComprobanteArriendo = $objRes->fields['txtComprobanteArriendo'];
                $this->seqBarrio = $objRes->fields['seqBarrio'];
                $this->seqUpz = $objRes->fields['seqUpz'];
                $this->seqSisben = $objRes->fields['seqSisben'];
                $this->numCortes = $objRes->fields['numCortes'];
                //$this->fchNotificacion = $objRes->fields['fchNotificacion'];
                $this->seqPeriodo = $objRes->fields['seqPeriodo'];
                $this->bolSancion = $objRes->fields['bolSancion'];
                $this->fchVigencia = $objRes->fields['fchVigencia'];
                $this->seqTipoEsquema = $objRes->fields['seqTipoEsquema'];
                $this->seqEntidadSubsidio = $objRes->fields['seqEntidadSubsidio'];
            } else {
                $this->arrErrores[] = "No se encuentra el formulario [$seqFormulario]";
            }
        }
    }

    // fin cargar formulario

    public function editarFormulario($seqFormularioActo) {

        global $aptBd;

        $valSaldoCuentaAhorroFormatUpd = str_replace(".", "", $this->valSaldoCuentaAhorro);
        $valSaldoCuentaAhorro2FormatUpd = str_replace(".", "", $this->valSaldoCuentaAhorro2);
        $valSubsidioNacionalFormatUpd = str_replace(".", "", $this->valSubsidioNacional);
        $valAporteLoteFormatUpd = str_replace(".", "", $this->valAporteLote);
        $valSaldoCesantiasFormatUpd = str_replace(".", "", $this->valSaldoCesantias);
        $valAporteAvanceObraFormatUpd = str_replace(".", "", $this->valAporteAvanceObra);
        $valAporteMaterialesFormatUpd = str_replace(".", "", $this->valAporteMateriales);
        $valCreditoFormatUpd = str_replace(".", "", $this->valCredito);
        $valDonacionFormatUpd = str_replace(".", "", $this->valDonacion);
        $valAspiraSubsidioFormat = str_replace(".", "", $this->valAspiraSubsidio);
        $valIngresoHogarFormat = str_replace(".", "", $this->valIngresoHogar);
        if ($this->numTelefono1 == "") {
            $valNumTelefono1 = 0;
        } else {
            $valNumTelefono1 = $this->numTelefono1;
        }
        if ($this->numTelefono2 == "") {
            $valNumTelefono2 = 0;
        } else {
            $valNumTelefono2 = $this->numTelefono2;
        }
        if ($this->numCelular == "") {
            $valNumCelular = 0;
        } else {
            $valNumCelular = $this->numCelular;
        }
        if ($this->fchInscripcion == "" || $this->fchInscripcion == "0000-00-00 00:00:00") {
            $fechaInscripcion = date("Y-m-d H:i:s");
        } else {
            $fechaInscripcion = $this->fchInscripcion;
        }

        // Estado Actual
        // Bandera para identificar el formulario del cual viene y poder actualizar o no el estado, esquema y bolcerrado
        if ($this->flagActualizar) {
            $flagActualizar = $this->flagActualizar;
        } else {
            $flagActualizar = 0;
        }
        $sqlActual = "
						SELECT 
							t_aad_formulario_acto.seqEstadoProceso, seqEtapa 
						FROM 
							t_aad_formulario_acto INNER JOIN T_FRM_ESTADO_PROCESO ON (t_aad_formulario_acto.seqEstadoProceso = T_FRM_ESTADO_PROCESO.seqEstadoProceso)
						WHERE 
							seqFormularioActo = $seqFormularioActo";
        $objResAct = $aptBd->execute($sqlActual);
        if ($objResAct->fields) {
            $estadoActual = $objResAct->fields['seqEstadoProceso'];
            $etapaActual = $objResAct->fields['seqEtapa'];
        }

        $sql = "
                    UPDATE t_aad_formulario_acto SET 
                        txtDireccion  =   \"" . $this->txtDireccion . "\",
                        seqTipoDireccion  =   \"" . $this->seqTipoDireccion . "\",
                        numTelefono1  =   \"" . $valNumTelefono1 . "\",
                        numTelefono2  =   \"" . $valNumTelefono2 . "\",
                        numCelular  =   \"" . $valNumCelular . "\",
                        txtBarrio  =   \"" . $this->txtBarrio . "\",
                        seqBarrio  =   \"" . $this->seqBarrio . "\",
                        seqUpz  =   \"" . $this->seqUpz . "\",
                        txtCorreo  =   \"" . $this->txtCorreo . "\",
                        txtMatriculaInmobiliaria  =   \"" . strtoupper($this->txtMatriculaInmobiliaria) . "\",
                        txtChip  =   \"" . strtoupper($this->txtChip) . "\",
                        bolViabilizada  =   \"" . $this->bolViabilizada . "\",
                        bolIdentificada  =   \"" . $this->bolIdentificada . "\",
                        bolDesplazado  =   \"" . $this->bolDesplazado . "\",
                        seqSolucion  =   \"" . $this->seqSolucion . "\",
                        valPresupuesto  =   \"" . $this->valPresupuesto . "\",
                        valAvaluo  =   \"" . $this->valAvaluo . "\",
                        valTotal  =   \"" . $this->valTotal . "\",
                        seqModalidad  =   \"" . $this->seqModalidad . "\",
                        seqPlanGobierno  =   \"" . $this->seqPlanGobierno . "\",
                        seqBancoCuentaAhorro  =   \"" . $this->seqBancoCuentaAhorro . "\",
                        fchAperturaCuentaAhorro  =   \"" . $this->fchAperturaCuentaAhorro . "\",
                        bolInmovilizadoCuentaAhorro  =   \"" . $this->bolInmovilizadoCuentaAhorro . "\",
                        valSaldoCuentaAhorro  =   \"" . $valSaldoCuentaAhorroFormatUpd . "\",
                        txtSoporteCuentaAhorro  =   \"" . $this->txtSoporteCuentaAhorro . "\",
                        seqBancoCuentaAhorro2  =  \"" . $this->seqBancoCuentaAhorro2 . "\",
                        fchAperturaCuentaAhorro2  =   \"" . $this->fchAperturaCuentaAhorro2 . "\",
                        bolInmovilizadoCuentaAhorro2  =   \"" . $this->bolInmovilizadoCuentaAhorro2 . "\",
                        valSaldoCuentaAhorro2  =   \"" . $valSaldoCuentaAhorro2FormatUpd . "\",
                        txtSoporteCuentaAhorro2  =   \"" . $this->txtSoporteCuentaAhorro2 . "\",
                        valSubsidioNacional  =  \"" . $valSubsidioNacionalFormatUpd . "\",
                        txtSoporteSubsidio  =   \"" . $this->txtSoporteSubsidio . "\",
                        valAporteLote  =  \"" . $valAporteLoteFormatUpd . "\",
                        txtSoporteAporteLote  =   \"" . $this->txtSoporteAporteLote . "\",
                        seqCesantias  =  \"" . $this->seqCesantias . "\",
                        valSaldoCesantias  =   \"" . $valSaldoCesantiasFormatUpd . "\",
                        txtSoporteCesantias  =   \"" . $this->txtSoporteCesantias . "\",
                        valAporteAvanceObra  =   \"" . $valAporteAvanceObraFormatUpd . "\",
                        txtSoporteAvanceObra  =   \"" . $this->txtSoporteAvanceObra . "\",
                        valAporteMateriales  = \"" . $valAporteMaterialesFormatUpd . "\",
                        txtSoporteAporteMateriales  =   \"" . $this->txtSoporteAporteMateriales . "\",
                        seqEmpresaDonante  =   \"" . $this->seqEmpresaDonante . "\",
                        valDonacion  = \"" . $valDonacionFormatUpd . "\",
                        txtSoporteDonacion  =   \"" . $this->txtSoporteDonacion . "\",
                        seqBancoCredito  =  \"" . $this->seqBancoCredito . "\",
                        valCredito  =  \"" . $valCreditoFormatUpd . "\",
                        txtSoporteCredito  =   \"" . $this->txtSoporteCredito . "\",
                        valTotalRecursos  =   \"" . $this->valTotalRecursos . "\",
                        valAspiraSubsidio  =   \"" . $valAspiraSubsidioFormat . "\",
                        seqVivienda  =   \"" . $this->seqVivienda . "\",
                        valArriendo  =   \"" . $this->valArriendo . "\",
                        bolPromesaFirmada  =   \"" . $this->bolPromesaFirmada . "\",
                        fchInscripcion  =   \"" . $fechaInscripcion . "\",
                        fchPostulacion  =   \"" . $this->fchPostulacion . "\",
                        fchVencimiento  =   \"" . $this->fchVencimiento . "\",
                        bolIntegracionSocial  =   \"" . $this->bolIntegracionSocial . "\",
                        bolSecSalud  =   \"" . $this->bolSecSalud . "\",
                        bolSecEducacion =   \"" . $this->bolSecEducacion . "\",
                        bolIpes  =   \"" . $this->bolIpes . "\",
                        bolReconocimientoFP  =   \"" . $this->bolReconocimientoFP . "\",
                        txtOtro  =   \"" . $this->txtOtro . "\",
                        numAdultosNucleo  =   \"" . $this->numAdultosNucleo . "\",
                        numNinosNucleo  =   \"" . $this->numNinosNucleo . "\",
                        seqUsuario  =   \"" . $this->seqUsuario . "\",
						seqLocalidad  =   \"" . $this->seqLocalidad . "\",
                        seqCiudad  =    \"" . $this->seqCiudad . "\",
                        valIngresoHogar  =   \"" . $valIngresoHogarFormat . "\",
                        txtDireccionSolucion = \"" . $this->txtDireccionSolucion . "\",
                        seqPuntoAtencion = \"" . $this->seqPuntoAtencion . "\",
                        fchAprobacionCredito = \"" . $this->fchAprobacionCredito . "\",
                        txtFormulario = \"" . $this->txtFormulario . "\",
                        fchUltimaActualizacion = \"" . $this->fchUltimaActualizacion . "\",
                        seqProyecto = \"" . $this->seqProyecto . "\",
                        txtSoporteSubsidioNacional = \"" . $this->txtSoporteSubsidioNacional . "\",
                        seqEntidadSubsidio = \"" . $this->seqEntidadSubsidio . "\",
                        fchArriendoDesde = \"" . $this->fchArriendoDesde . "\",
                        txtComprobanteArriendo = \"" . $this->txtComprobanteArriendo . "\", ";
        if ($this->seqUnidadProyecto) {
            $sql .= " seqUnidadProyecto = \"" . $this->seqUnidadProyecto . "\", ";
        }
        if ($this->seqProyectoHijo) {
            $sql .= " seqProyectoHijo = \"" . $this->seqProyectoHijo . "\", ";
        }
        if ($this->seqTipoFinanciacion) {
            $sql .= " seqTipoFinanciacion = \"" . $this->seqTipoFinanciacion . "\", ";
        }
        if (($estadoActual == 15 || $etapaActual == 5) && ($flagActualizar == 1)) {
            $a = "FORMULARIO CERRADO, NO SE ACTUALIZA ESQUEMA, ESTADO Y BOLCERRADO";
        } else {
            $sql .= "seqTipoEsquema = \"" . $this->seqTipoEsquema . "\",
								bolCerrado  =   \"" . $this->bolCerrado . "\",
								seqEstadoProceso  =   \"" . $this->seqEstadoProceso . "\", ";
        }
        $sql .= "fchVigencia = \"" . $this->fchVigencia . "\"
                    WHERE
                        seqFormularioActo = $seqFormularioActo
                ";
        /* if($_SESSION['seqUsuario'] == 251){
          echo $sql;
          } */
        // echo "sql: " . $sql;
        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se ha podido actualizar la informacion del formulario [$seqFormulario]";
            //				pr( $objError->getMessage() );
        }

        if (empty($arrErrores)) {
            if ($this->seqUnidadProyecto > 1) {
                // Limpia el campo seqFormulario de la Unidad
                $sqlCleanForm = "
					UPDATE 
						T_PRY_UNIDAD_PROYECTO 
					SET 
						seqFormulario = '' 
					WHERE 
						seqFormulario = \"" . strtoupper($this->seqFormulario) . "\"
					";
                $aptBd->execute($sqlCleanForm);

                // Actualiza el hogar propietario de la unidad
                $sqlFormUnidad = "
						UPDATE 
							T_PRY_UNIDAD_PROYECTO 
						SET 
							seqFormulario = \"" . $this->seqFormulario . "\" 
						WHERE 
							seqUnidadProyecto = \"" . strtoupper($this->seqUnidadProyecto) . "\"
					";
                $aptBd->execute($sqlFormUnidad);
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
        $numFormulario = intval($arrFormulario[1]);

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
            $numTutorBd = intval($arrFormularioBd[0]);
            $numFormularioBd = intval($arrFormularioBd[1]);
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

    public function borrarFormulario($seqFormularioActo) {
        global $aptBd;
        $sql = "
                DELETE
                FROM t_aad_formulario_acto
                WHERE seqFormularioActo = $seqFormularioActo
             ";
        $aptBd->execute($sql);
    }

}

// Fin de clase
?>