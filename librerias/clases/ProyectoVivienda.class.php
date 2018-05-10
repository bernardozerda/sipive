<?php

/**
 * CLASE QUE REALIZA TODAS LAS OPERACIONES 
 * RELACIONADAS CON LOS PROYECTOS DE VIVIENDA
 * REQUIERE QUE ESTE CONECTADO A LA BASE DE DATOS
 * @author Jaison Ospina
 * @version 0.1 Agosto 2013
 */
class ProyectoVivienda {

    public $arrProyectoVivienda;
    // Datos del Proyecto
    public $numNitProyecto;     // NIT del Proyecto
    public $txtNombreProyecto;    // Nombre del Proyecto
    public $txtNombreComercial;    // Nombre Comercial del Proyecto
    public $txtNombrePlanParcial;   // Nombre del Plan Parcial
    public $seqPlanGobierno;    // Plan de Gobierno
    public $seqTipoEsquema;     // Tipo de Esquema
    public $seqPryTipoModalidad;   // Tipo de Modalidad
    public $txtNombreOperador;    // Nombre de Operador
    public $txtObjetoProyecto;    // Objeto del Proyecto
    public $txtOtrosBarrios;    // Otros Barrios
    public $seqOpv;       // Seq de OPV
    public $seqTipoProyecto;    // Tipo de Proyecto
    public $seqTipoUrbanizacion;   // Tipo de Urbanización
    public $seqTipoSolucion;    // Tipo de Solución
    public $txtDescripcionProyecto;   // Descripción del Proyecto
    public $bolDireccion;     // Conoce la Dirección?
    public $txtDireccion;     // Dirección
    public $seqLocalidad;     // Localidad
    public $valNumeroSoluciones;   // Número de Soluciones
    public $valAreaConstruida;    // Area de la construccion
    public $valAreaLote;     // Area del terreno en el cual se va a construir
    public $txtChipLote;     // Chip del Lote
    public $txtMatriculaInmobiliariaLote; // Matricula Inmobiliaria del Lote
    public $txtRegistroEnajenacion;   // Registro de Enajenación
    public $fchRegistroEnajenacion;   // Fecha Registro de Enajenación
    public $bolEquipamientoComunal;   // Equipamiento Comunal
    public $txtDescEquipamientoComunal;  // Descripcion de Equipamiento Comunal
    public $seqBarrio;      // Barrio del Proyecto (*)
    public $valTorres;      // Número de Torres (*)
    // Datos del Oferente
    public $txtNombreOferente;      // Nombre del Oferente
    public $numNitOferente;       // NIT del Oferente
    public $txtNombreContactoOferente;    // Nombre de Contacto Oferente
    public $numTelefonoOferente;     // Telefono Fijo del Oferente
    public $numExtensionOferente;     // Extensión del Oferente
    public $numCelularOferente;      // Celular del Oferente
    public $txtCorreoOferente;      // Correo Electronico del Oferente
    public $txtNombreOferente2;      // Nombre del Oferente2
    public $numNitOferente2;      // NIT del Oferente
    public $txtNombreContactoOferente2;    // Nombre de Contacto Oferente
    public $numTelefonoOferente2;     // Telefono Fijo del Oferente
    public $numExtensionOferente2;     // Extensión del Oferente
    public $numCelularOferente2;     // Celular del Oferente
    public $txtCorreoOferente2;      // Correo Electronico del Oferente
    public $txtNombreOferente3;      // Nombre del Oferente3
    public $numNitOferente3;      // NIT del Oferente
    public $txtNombreContactoOferente3;    // Nombre de Contacto Oferente
    public $numTelefonoOferente3;     // Telefono Fijo del Oferente
    public $numExtensionOferente3;     // Extensión del Oferente
    public $numCelularOferente3;     // Celular del Oferente
    public $txtCorreoOferente3;      // Correo Electronico del Oferente
    public $txtRepresentanteLegalOferente;   // Nombre del Representante Legal del Oferente
    public $numNitRepresentanteLegalOferente;  // NIT del Representante Legal del Oferente
    public $numTelefonoRepresentanteLegalOferente; // Telefono Fijo del Representante Legal del Oferente
    public $numExtensionRepresentanteLegalOferente; // Extension del Representante Legal del Oferente
    public $numCelularRepresentanteLegalOferente; // Celular del Representante Legal del Oferente
    public $txtDireccionRepresentanteLegalOferente; // Direccion del Representante Legal del Oferente
    public $txtCorreoRepresentanteLegalOferente; // Correo del Representante Legal del Oferente
    public $bolConstructor;       // El Oferente es el mismo constructor?
    public $seqConstructor;       // Código del Constructor
    // Costos del Proyecto
    public $valCostosDirectos;      // Valor Costos Directos
    public $valCostosIndirectos;     // Valor Costos Indirectos
    public $valTerreno;        // Valor Terreno
    public $valGastosFinancieros;     // Valor Gastos FInancieros
    public $valGastosVentas;      // Valor Gastos Ventas
    public $valTotalCostos;       // Valor Total Costos
    public $valTotalVentas;       // Valor Total Ventas
    public $valUtilidadProyecto;     // Valor Utilidad Proyecto
    public $valRecursosPropios;      // Valor Recursos Propios
    public $valCreditoEntidadFinanciera;   // Valor Credito Entidad Financiera
    public $valCreditoParticulares;     // Valor Credito Particulares
    public $valVentasProyecto;      // Valor Ventas Proyecto
    public $valSDVE;        // Valor SDVE
    public $valOtros;        // Valor Otros
    public $valDevolucionIVA;      // Valor Devolucion IVA
    public $valTotalRecursos;      // Valor Total Recursos
    // Licencia de Urbanismo
    public $txtLicenciaUrbanismo;    // Licencia de Urbanismo
    public $txtExpideLicenciaUrbanismo;   // Entidad que expide la Licencia de Urbanismo
    public $fchLicenciaUrbanismo1;    // Fecha de Licencia Urbanismo
    public $fchLicenciaUrbanismo2;    // Ampliación Licencia Urbanismo 1
    public $fchLicenciaUrbanismo3;    // Ampliación Licencia Urbanismo 2
    public $fchVigenciaLicenciaUrbanismo;  // Vigencia de Licencia Urbanismo
    public $fchEjecutoriaLicenciaUrbanismo;  // Fecha Ejecutoria de Licencia Urbanismo
    public $txtResEjecutoriaLicenciaUrbanismo; // Resolución de Ejecutoria de Licencia Urbanismo
    // Licencia de Construcción
    public $txtLicenciaConstruccion;     // Licencia de Construcción
    public $fchLicenciaConstruccion1;     // Fecha de Licencia Construcción
    public $fchLicenciaConstruccion2;     // Ampliación Licencia Construcción 1
    public $fchLicenciaConstruccion3;     // Ampliación Licencia Construcción 2
    public $fchVigenciaLicenciaConstruccion;   // Vigencia de Licencia Construcción 
    public $txtObsLicConstruccion;      // Observaciones No. Licencia de Construcci&oacute;n
    public $fchEjecutaLicConstruccion;     // Fecha Ejecutoria
    public $fchVenceLicConstruccion;     // Fecha Vencimiento (Calcular)
    public $numResolProrrogaLicConstruccion;   // No. De Resolucion Prorroga
    public $txtObsNumResolProrrogaLicConstruccion;  // Observaciones No. De Resolucion Prorroga
    public $fchEjecutaProrrogaLicConstruccion;   // Fecha Ejecutoria Prorroga
    public $fchVenceProrrogaLicConstruccion;   // Fecha de Vencimiento Prorroga (Calcular)
    public $numResolRevalidacionLicConstruccion;  // No. De Resolucion de Revalidacion
    public $txtObsNumResolRevalidacionLicConstruccion; // Observaciones No. De Resolucion de Revalidacion
    public $fchEjecutaRevalidacionLicConstruccion;  // Fecha Ejecutoria Revalidacion
    public $fchVenceRevalidacionLicConstruccion;  // Fecha Vencimiento Revalidacion
    // Escrituracion
    public $txtNombreVendedor;       // Nombre de Vendedor
    public $numNitVendedor;        // NIT de Vendedor
    public $txtCedulaCatastral;       // Cedula Catastral
    public $txtEscritura;        // Numero de Escritura
    public $fchEscritura;        // Fecha de Escritura
    public $numNotaria;         // Numero de Notaria
    // Datos del Interventor
    public $txtNombreInterventor;    // Nombre del Interventor
    public $txtDireccionInterventor;   // Direccion del Interventor
    public $numTelefonoInterventor;    // Telefono del Interventor
    public $txtCorreoInterventor;    // Correo Electronico del Interventor
    public $bolTipoPersonaInterventor;   // Tipo de Persona del Interventor
    public $numCedulaInterventor;    // Cédula del Interventor
    public $numTProfesionalInterventor;   // Tarjeta Profesional del Interventor
    public $numNitInterventor;     // NIT del Interventor
    public $txtNombreRepLegalInterventor;  // Nombre representante legal del Interventor
    public $txtDireccionRepLegalInterventor; // Direccion representante legal del Interventor
    public $numTelefonoRepLegalInterventor;  // Telefono representante legal del Interventor
    public $txtCorreoRepLegalInterventor;  // Correo electronico representante legal del Interventor
    // Aprobacion del Proyecto
    public $numRadicadoJuridico;   // Número de Radicado Jurídico
    public $fchRadicadoJuridico;   // Fecha de Radicado Jurídico
    public $numRadicadoTecnico;    // Número de Radicado Técnico
    public $fchRadicadoTecnico;    // Fecha de Radicado Técnico
    public $numRadicadoFinanciero;   // Número de Radicado Financiero
    public $fchRadicadoFinanciero;   // Fecha de Radicado Financiero
    public $bolAprobacion;     // Se aprueba el proyecto?
    public $numActaAprobacion;    // Número de Acta de la Aprobación
    public $fchActaAprobacion;    // Fecha de Acta de la Aprobación
    public $numResolucionAprobacion;  // Número de Resolución de la Aprobación
    public $fchResolucionAprobacion;  // Fecha de Resolución de la Aprobación
    public $txtActaResuelve;    // Acta Resuelve
    public $bolCondicionAprobacion;   // Se aprueba condicionado?
    public $txtCondicionAprobacion;   // Condiciones de Aprobación
    public $txtObservacionAprobacion;  // Observación de la Aprobación
    // seguimientos de obra 
    public $fchInicialTerreno;
    public $fchFinalTerreno;
    public $porcIncTerreno;
    public $valActTerreno;
    public $fchInicialPreliminarConstruccion;
    public $fchFinalPreliminarConstruccion;
    public $porcIncPreliminarConstruccion;
    public $valActPreliminarConstruccion;
    public $fchInicialCimentacionConstruccion;
    public $fchFinalCimentacionConstruccion;
    public $porcIncCimentacionConstruccion;
    public $valActCimentacionConstruccion;
    public $fchInicialDesaguesConstruccion;
    public $fchFinalDesaguesConstruccion;
    public $porcIncDesaguesConstruccion;
    public $valActDesaguesConstruccion;
    public $fchInicialEstructuraConstruccion;
    public $fchFinalEstructuraConstruccion;
    public $porcIncEstructuraConstruccion;
    public $valActEstructuraConstruccion;
    public $fchInicialMamposteriaConstruccion;
    public $fchFinalMamposteriaConstruccion;
    public $porcIncMamposteriaConstruccion;
    public $valActMamposteriaConstruccion;
    public $fchInicialPanetesConstruccion;
    public $fchFinalPanetesConstruccion;
    public $porcIncPanetesConstruccion;
    public $valActPanetesConstruccion;
    public $fchInicialHidrosanitariasConstruccion;
    public $fchFinalHidrosanitariasConstruccion;
    public $porcIncHidrosanitariasConstruccion;
    public $valActHidrosanitariasConstruccion;
    public $fchInicialElectricasConstruccion;
    public $fchFinalElectricasConstruccion;
    public $porcIncElectricasConstruccion;
    public $valActElectricasConstruccion;
    public $fchInicialCubiertaConstruccion;
    public $fchFinalCubiertaConstruccion;
    public $porcIncCubiertaConstruccion;
    public $valActCubiertaConstruccion;
    public $fchInicialCarpinteriaConstruccion;
    public $fchFinalCarpinteriaConstruccion;
    public $porcIncCarpinteriaConstruccion;
    public $valActCarpinteriaConstruccion;
    public $fchInicialPisosConstruccion;
    public $fchFinalPisosConstruccion;
    public $porcIncPisosConstruccion;
    public $valActPisosConstruccion;
    public $fchInicialSanitariosConstruccion;
    public $fchFinalSanitariosConstruccion;
    public $porcIncSanitariosConstruccion;
    public $valActSanitariosConstruccion;
    public $fchInicialExterioresConstruccion;
    public $fchFinalExterioresConstruccion;
    public $porcIncExterioresConstruccion;
    public $valActExterioresConstruccion;
    public $fchInicialAseoConstruccion;
    public $fchFinalAseoConstruccion;
    public $porcIncAseoConstruccion;
    public $valActAseoConstruccion;
    public $fchInicialPreliminarUrbanismo;
    public $fchFinalPreliminarUrbanismo;
    public $porcIncPreliminarUrbanismo;
    public $valActPreliminarUrbanismo;
    public $fchInicialCimentacionUrbanismo;
    public $fchFinalCimentacionUrbanismo;
    public $porcIncCimentacionUrbanismo;
    public $valActCimentacionUrbanismo;
    public $fchInicialDesaguesUrbanismo;
    public $fchFinalDesaguesUrbanismo;
    public $porcIncDesaguesUrbanismo;
    public $valActDesaguesUrbanismo;
    public $fchInicialViasUrbanismo;
    public $fchFinalViasUrbanismo;
    public $porcIncViasUrbanismo;
    public $valActViasUrbanismo;
    public $fchInicialParquesUrbanismo;
    public $fchFinalParquesUrbanismo;
    public $porcIncParquesUrbanismo;
    public $valActParquesUrbanismo;
    public $fchInicialAseoUrbanismo;
    public $fchFinalAseoUrbanismo;
    public $porcIncAseoUrbanismo;
    public $valActAseoUrbanismo;
    public $fchInicialLicenciaUrbanismo;
    public $fchFinalLicenciaUrbanismo;
    public $fchInicialLicenciaConstruccion;
    public $fchFinalLicenciaConstruccion;
    public $fchInicialVentasProyecto;
    public $fchFinalVentasProyecto;
    public $numViviendaVentasProyecto;
    public $fchInicialEntregaEscrituracionVivienda;
    public $fchFinalEntregaEscrituracionVivienda;
    public $numViviendaEntregaEscrituracionVivienda;
    public $txtDescripcionHitos;
    // Modulos del Proyecto
    public $seqTipoModulo;     // Tipo de modulo
    public $txtNombreModulo;    // Nombre del tipo modulo
    public $valSolucionesModulo;   // Numero de soluciones por modulo
    public $valDimension;     // Dimension del modulo
    // Revision Preliminar
    public $seqProfesionalResponsable;    // Profesional Responsable
    public $optVoBoContratoInterventoria;   // Vo. Bo. Contrato Interventoria
    public $txtObservacionesContratoInterventoria; // Observacion Contrato Interventoria
    public $fchRevisionContratoInterventoria;  // Fecha Revision Contrato Interventoria
    // Otras
    public $seqTutorProyecto;    // Tutor del Proyecto
    public $seqPryEstadoProceso;   // Estado de Proceso del Proyecto
    public $bolActivo;      // Estado Activo del Proyecto
    public $seqUsuario;      // Usuario que crea el registro

    /**
     * CONSTRUCTOR DE LA CLASE
     * @author Jaison ospina
     * @param Void
     * @return Void
     * @version 1.0 Agosto 2013
     */

    public function ProyectoVivienda() {

        //$this->arrProyectoVivienda = array();

        $this->numNitProyecto = 0;
        $this->txtNombreProyecto = "";
        $this->txtNombreComercial = "";
        $this->txtNombrePlanParcial = "";
        $this->seqPlanGobierno = 2;
        $this->seqTipoEsquema = 0;
        $this->seqPryTipoModalidad = 0;
        $this->txtNombreOperador = "";
        $this->txtObjetoProyecto = "";
        $this->txtOtrosBarrios = "";
        $this->seqOpv = 0;
        $this->seqTipoProyecto = 0;
        $this->seqTipoUrbanizacion = 0;
        $this->seqTipoSolucion = 0;
        $this->txtDescripcionProyecto = "";
        $this->bolDireccion = 0;
        $this->txtDireccion = "";
        $this->seqLocalidad = 0;
        $this->seqBarrio = 0;
        $this->valTorres = 0;

        $this->valNumeroSoluciones = 0;
        $this->valAreaConstruida = 0;
        $this->valAreaLote = 0;
        $this->txtChipLote = "";
        $this->txtMatriculaInmobiliariaLote = "";
        $this->txtRegistroEnajenacion = "";
        $this->fchRegistroEnajenacion = "";
        $this->bolEquipamientoComunal = 0;
        $this->txtDescEquipamientoComunal = "";

        $this->txtNombreOferente = "";
        $this->numNitOferente = "";
        $this->txtNombreContactoOferente = "";
        $this->numTelefonoOferente = 0;
        $this->numExtensionOferente = 0;
        $this->numCelularOferente = 0;
        $this->txtCorreoOferente = "";
        $this->txtNombreOferente2 = "";
        $this->numNitOferente2 = "";
        $this->txtNombreContactoOferente2 = "";
        $this->numTelefonoOferente2 = 0;
        $this->numExtensionOferente2 = 0;
        $this->numCelularOferente2 = 0;
        $this->txtCorreoOferente2 = "";
        $this->txtNombreOferente3 = "";
        $this->numNitOferente3 = "";
        $this->txtNombreContactoOferente3 = "";
        $this->numTelefonoOferente3 = 0;
        $this->numExtensionOferente3 = 0;
        $this->numCelularOferente3 = 0;
        $this->txtCorreoOferente3 = "";

        $this->txtRepresentanteLegalOferente = "";
        $this->numNitRepresentanteLegalOferente = 0;
        $this->numTelefonoRepresentanteLegalOferente = 0;
        $this->numExtensionRepresentanteLegalOferente = 0;
        $this->numCelularRepresentanteLegalOferente = 0;
        $this->txtDireccionRepresentanteLegalOferente = "";
        $this->txtCorreoRepresentanteLegalOferente = "";

        $this->bolConstructor = 0;
        $this->seqConstructor = 0;

        $this->valCostosDirectos = 0;
        $this->valCostosIndirectos = 0;
        $this->valTerreno = 0;
        $this->valGastosFinancieros = 0;
        $this->valGastosVentas = 0;
        $this->valTotalCostos = 0;
        $this->valTotalVentas = 0;
        $this->valUtilidadProyecto = 0;
        $this->valRecursosPropios = 0;
        $this->valCreditoEntidadFinanciera = 0;
        $this->valCreditoParticulares = 0;
        $this->valVentasProyecto = 0;
        $this->valSDVE = 0;
        $this->valOtros = 0;
        $this->valDevolucionIVA = 0;
        $this->valTotalRecursos = 0;

        $this->txtLicenciaUrbanismo = "";
        $this->txtExpideLicenciaUrbanismo = "";
        $this->fchLicenciaUrbanismo1 = "";
        $this->fchLicenciaUrbanismo2 = "";
        $this->fchLicenciaUrbanismo3 = "";
        $this->fchVigenciaLicenciaUrbanismo = "";
        $this->fchEjecutoriaLicenciaUrbanismo = "";
        $this->txtResEjecutoriaLicenciaUrbanismo = "";

        $this->txtLicenciaConstruccion = "";
        $this->fchLicenciaConstruccion1 = "";
        $this->fchLicenciaConstruccion2 = "";
        $this->fchLicenciaConstruccion3 = "";
        $this->fchVigenciaLicenciaConstruccion = "";
        $this->txtObsLicConstruccion = "";
        $this->fchEjecutaLicConstruccion = "";
        $this->fchVenceLicConstruccion = "";
        $this->numResolProrrogaLicConstruccion = "";
        $this->txtObsNumResolProrrogaLicConstruccion = "";
        $this->fchEjecutaProrrogaLicConstruccion = "";
        $this->fchVenceProrrogaLicConstruccion = "";
        $this->numResolRevalidacionLicConstruccion = "";
        $this->txtObsNumResolRevalidacionLicConstruccion = "";
        $this->fchEjecutaRevalidacionLicConstruccion = "";
        $this->fchVenceRevalidacionLicConstruccion = "";

        $this->txtNombreVendedor = "";
        $this->numNitVendedor = "";
        $this->txtCedulaCatastral = "";
        $this->txtEscritura = "";
        $this->fchEscritura = "";
        $this->numNotaria = 0;

        $this->txtNombreInterventor = "";
        $this->txtDireccionInterventor = "";
        $this->numTelefonoInterventor = 0;
        $this->txtCorreoInterventor = "";
        $this->bolTipoPersonaInterventor = 0;
        $this->numCedulaInterventor = 0;
        $this->numTProfesionalInterventor = 0;
        $this->numNitInterventor = "";
        $this->txtNombreRepLegalInterventor = "";
        $this->txtDireccionRepLegalInterventor = "";
        $this->numTelefonoRepLegalInterventor = 0;
        $this->txtCorreoRepLegalInterventor = "";

        $this->numRadicadoJuridico = 0;
        $this->fchRadicadoJuridico = "";
        $this->numRadicadoTecnico = 0;
        $this->fchRadicadoTecnico = "";
        $this->numRadicadoFinanciero = 0;
        $this->fchRadicadoFinanciero = "";
        $this->bolAprobacion = 0;
        $this->numActaAprobacion = 0;
        $this->fchActaAprobacion = "";
        $this->numResolucionAprobacion = 0;
        $this->fchResolucionAprobacion = "";
        $this->txtActaResuelve = "";
        $this->bolCondicionAprobacion = 0;
        $this->txtCondicionAprobacion = "";
        $this->txtObservacionAprobacion = "";

        $this->chkDocConstructor1 = 0;
        $this->txtDocConstructor1 = "";
        $this->chkDocConstructor2 = 0;
        $this->txtDocConstructor2 = "";
        $this->chkDocConstructor3 = 0;
        $this->txtDocConstructor3 = "";
        $this->chkDocConstructor4 = 0;
        $this->txtDocConstructor4 = "";
        $this->chkDocConstructor5 = 0;
        $this->txtDocConstructor5 = "";
        $this->chkDocConstructor6 = 0;
        $this->txtDocConstructor6 = "";
        $this->chkDocConstructor7 = 0;
        $this->txtDocConstructor7 = "";
        $this->chkDocConstructor8 = 0;
        $this->txtDocConstructor8 = "";
        $this->chkDocProyecto1 = 0;
        $this->txtDocProyecto1 = "";
        $this->chkDocProyecto2 = 0;
        $this->txtDocProyecto2 = "";
        $this->chkDocProyecto3 = 0;
        $this->txtDocProyecto3 = "";
        $this->chkDocProyecto4 = 0;
        $this->txtDocProyecto4 = "";
        $this->chkDocProyecto5 = 0;
        $this->txtDocProyecto5 = "";
        $this->chkDocProyecto6 = 0;
        $this->txtDocProyecto6 = "";
        $this->chkDocProyecto7 = 0;
        $this->txtDocProyecto7 = "";
        $this->chkDocProyecto8 = 0;
        $this->txtDocProyecto8 = "";

        $this->chkDocDesemConstructor1 = 0;
        $this->txtDocDesemConstructor1 = "";
        $this->chkDocDesemConstructor2 = 0;
        $this->txtDocDesemConstructor2 = "";
        $this->chkDocDesemConstructor3 = 0;
        $this->txtDocDesemConstructor3 = "";
        $this->chkDocDesemConstructor4 = 0;
        $this->txtDocDesemConstructor4 = "";
        $this->chkDocDesemConstructor5 = 0;
        $this->txtDocDesemConstructor5 = "";
        $this->chkDocDesemEntidad1 = 0;
        $this->txtDocDesemEntidad1 = "";
        $this->chkDocDesemEntidad2 = 0;
        $this->txtDocDesemEntidad2 = "";
        $this->chkDocDesemEntidad3 = 0;
        $this->txtDocDesemEntidad3 = "";
        $this->chkDocDesemEntidad4 = 0;
        $this->txtDocDesemEntidad4 = "";
        $this->chkDocDesemEntidad5 = 0;
        $this->txtDocDesemEntidad5 = "";
        $this->chkDocDesemEntidad6 = 0;
        $this->txtDocDesemEntidad6 = "";
        $this->chkDocDesemEntidad7 = 0;
        $this->txtDocDesemEntidad7 = "";
        $this->chkDocDesemEntidad8 = 0;
        $this->txtDocDesemEntidad8 = "";
        $this->chkDocDesemEntidad9 = 0;
        $this->txtDocDesemEntidad9 = "";
        $this->chkDocDesemProyecto1 = 0;
        $this->txtDocDesemProyecto1 = "";
        $this->chkDocDesemProyecto2 = 0;
        $this->txtDocDesemProyecto2 = "";
        $this->chkDocDesemProyecto3 = 0;
        $this->txtDocDesemProyecto3 = "";
        $this->chkDocDesemProyecto4 = 0;
        $this->txtDocDesemProyecto4 = "";
        $this->chkDocDesemProyecto5 = 0;
        $this->txtDocDesemProyecto5 = "";
        $this->chkDocDesemProyecto6 = 0;
        $this->txtDocDesemProyecto6 = "";
        $this->seqTipoModalidadDesembolso = 0;

        $this->fchInicialTerreno = "";
        $this->fchFinalTerreno = "";
        $this->porcIncTerreno = 0;
        $this->valActTerreno = 0;
        $this->fchInicialPreliminarConstruccion = "";
        $this->fchFinalPreliminarConstruccion = "";
        $this->porcIncPreliminarConstruccion = 0;
        $this->valActPreliminarConstruccion = 0;
        $this->fchInicialCimentacionConstruccion = "";
        $this->fchFinalCimentacionConstruccion = "";
        $this->porcIncCimentacionConstruccion = 0;
        $this->valActCimentacionConstruccion = 0;
        $this->fchInicialDesaguesConstruccion = "";
        $this->fchFinalDesaguesConstruccion = "";
        $this->porcIncDesaguesConstruccion = 0;
        $this->valActDesaguesConstruccion = 0;
        $this->fchInicialEstructuraConstruccion = "";
        $this->fchFinalEstructuraConstruccion = "";
        $this->porcIncEstructuraConstruccion = 0;
        $this->valActEstructuraConstruccion = 0;
        $this->fchInicialMamposteriaConstruccion = "";
        $this->fchFinalMamposteriaConstruccion = "";
        $this->porcIncMamposteriaConstruccion = 0;
        $this->valActMamposteriaConstruccion = 0;
        $this->fchInicialPanetesConstruccion = "";
        $this->fchFinalPanetesConstruccion = "";
        $this->porcIncPanetesConstruccion = 0;
        $this->valActPanetesConstruccion = 0;
        $this->fchInicialHidrosanitariasConstruccion = "";
        $this->fchFinalHidrosanitariasConstruccion = "";
        $this->porcIncHidrosanitariasConstruccion = 0;
        $this->valActHidrosanitariasConstruccion = 0;
        $this->fchInicialElectricasConstruccion = "";
        $this->fchFinalElectricasConstruccion = "";
        $this->porcIncElectricasConstruccion = 0;
        $this->valActElectricasConstruccion = 0;
        $this->fchInicialCubiertaConstruccion = "";
        $this->fchFinalCubiertaConstruccion = "";
        $this->porcIncCubiertaConstruccion = 0;
        $this->valActCubiertaConstruccion = 0;
        $this->fchInicialCarpinteriaConstruccion = "";
        $this->fchFinalCarpinteriaConstruccion = "";
        $this->porcIncCarpinteriaConstruccion = 0;
        $this->valActCarpinteriaConstruccion = 0;
        $this->fchInicialPisosConstruccion = "";
        $this->fchFinalPisosConstruccion = "";
        $this->porcIncPisosConstruccion = 0;
        $this->valActPisosConstruccion = 0;
        $this->fchInicialSanitariosConstruccion = "";
        $this->fchFinalSanitariosConstruccion = "";
        $this->porcIncSanitariosConstruccion = 0;
        $this->valActSanitariosConstruccion = 0;
        $this->fchInicialExterioresConstruccion = "";
        $this->fchFinalExterioresConstruccion = "";
        $this->porcIncExterioresConstruccion = 0;
        $this->valActExterioresConstruccion = 0;
        $this->fchInicialAseoConstruccion = "";
        $this->fchFinalAseoConstruccion = "";
        $this->porcIncAseoConstruccion = 0;
        $this->valActAseoConstruccion = 0;
        $this->fchInicialPreliminarUrbanismo = "";
        $this->fchFinalPreliminarUrbanismo = "";
        $this->porcIncPreliminarUrbanismo = 0;
        $this->valActPreliminarUrbanismo = 0;
        $this->fchInicialCimentacionUrbanismo = "";
        $this->fchFinalCimentacionUrbanismo = "";
        $this->porcIncCimentacionUrbanismo = 0;
        $this->valActCimentacionUrbanismo = 0;
        $this->fchInicialDesaguesUrbanismo = "";
        $this->fchFinalDesaguesUrbanismo = "";
        $this->porcIncDesaguesUrbanismo = 0;
        $this->valActDesaguesUrbanismo = 0;
        $this->fchInicialViasUrbanismo = "";
        $this->fchFinalViasUrbanismo = "";
        $this->porcIncViasUrbanismo = 0;
        $this->valActViasUrbanismo = 0;
        $this->fchInicialParquesUrbanismo = "";
        $this->fchFinalParquesUrbanismo = "";
        $this->porcIncParquesUrbanismo = 0;
        $this->valActParquesUrbanismo = 0;
        $this->fchInicialAseoUrbanismo = "";
        $this->fchFinalAseoUrbanismo = "";
        $this->porcIncAseoUrbanismo = 0;
        $this->valActAseoUrbanismo = 0;
        $this->fchInicialLicenciaUrbanismo = "";
        $this->fchFinalLicenciaUrbanismo = "";
        $this->fchInicialLicenciaConstruccion = "";
        $this->fchFinalLicenciaConstruccion = "";
        $this->fchInicialVentasProyecto = "";
        $this->fchFinalVentasProyecto = "";
        $this->numViviendaVentasProyecto = 0;
        $this->fchInicialEntregaEscrituracionVivienda = "";
        $this->fchFinalEntregaEscrituracionVivienda = "";
        $this->numViviendaEntregaEscrituracionVivienda = 0;
        $this->txtDescripcionHitos = "";

        $this->seqTipoModulo = 0;
        $this->txtNombreModulo = "";
        $this->valSolucionesModulo = 0;
        $this->valDimension = 0;

        $this->seqProfesionalResponsable = 0;
        $this->optVoBoContratoInterventoria = 0;
        $this->txtObservacionesContratoInterventoria = "";
        $this->fchRevisionContratoInterventoria = "";

        $this->seqUsuario = 0;
        $this->seqTutorProyecto = 0;
        $this->seqPryEstadoProceso = 0;
        $this->bolActivo = 0;
    }

// Fin Constructor

    /**
     * CARGA UNO O TODOS LOS PROYECTOS DE VIVIENDA QUE
     * HAY EN LA BASE DE DATOS, DEPENDE DEL PARAMETRO
     * QUE SE LE PASE A LA FUNCION
     * @author Jaison Ospina
     * @return array arrProyectoVivienda
     * @version 1.0 Agosto 2013
     */
    public function cargarProyectoVivienda($seqProyecto) {

        global $aptBd;

        // Arreglo que se retorna
        $arrProyectoVivienda = array();

        // Si viene parametro la consulta es para un solo Proyecto de Vivienda
        $txtCondicion = "";
        if ($seqProyecto != 0) {
            $txtCondicion = " AND T_PRY_PROYECTO.seqProyecto = $seqProyecto";
        }

        // Consulta de Proyectos de Vivienda
        $sql = "
                    SELECT
                            T_PRY_PROYECTO.seqProyecto,
                            numNitProyecto,
                            txtNombreProyecto,
                            txtNombreComercial,
                            txtNombrePlanParcial,
                            seqPlanGobierno,
                            seqTipoEsquema,
                            seqPryTipoModalidad,
                            txtNombreOperador,
                            txtObjetoProyecto,
                            txtOtrosBarrios,
                            seqOpv,
                            seqTipoProyecto,
                            seqTipoUrbanizacion,
                            seqTipoSolucion,
                            txtDescripcionProyecto,
                            bolDireccion,
                            txtDireccion,
                            seqLocalidad,
                            seqBarrio,
                            valTorres,
                            valNumeroSoluciones,
                            valAreaConstruida,
                            valAreaLote,
                            txtChipLote,
                            txtMatriculaInmobiliariaLote,
                            txtRegistroEnajenacion,
                            fchRegistroEnajenacion,
                            bolEquipamientoComunal,
                            txtDescEquipamientoComunal,					
                            bolConstructor,
                            seqConstructor,
                            valCostosDirectos,
                            valCostosIndirectos,
                            valTerreno,
                            valGastosFinancieros,
                            valGastosVentas,
                            valTotalCostos,
                            valTotalVentas,
                            valUtilidadProyecto,
                            valRecursosPropios,
                            valCreditoEntidadFinanciera,
                            valCreditoParticulares,
                            valVentasProyecto,
                            valSDVE,
                            valOtros,
                            valDevolucionIVA,
                            valTotalRecursos,
                            txtLicenciaUrbanismo,
                            txtExpideLicenciaUrbanismo,
                            fchLicenciaUrbanismo1,
                            fchLicenciaUrbanismo2,
                            fchLicenciaUrbanismo3,
                            fchVigenciaLicenciaUrbanismo,
                            fchEjecutoriaLicenciaUrbanismo,
                            txtResEjecutoriaLicenciaUrbanismo,
                            txtLicenciaConstruccion,
                            fchLicenciaConstruccion1,
                            fchLicenciaConstruccion2,
                            fchLicenciaConstruccion3,
                            fchVigenciaLicenciaConstruccion,
                            txtObsLicConstruccion,
                            fchEjecutaLicConstruccion,
                            fchVenceLicConstruccion,
                            numResolProrrogaLicConstruccion,
                            txtObsNumResolProrrogaLicConstruccion,
                            fchEjecutaProrrogaLicConstruccion,
                            fchVenceProrrogaLicConstruccion,
                            numResolRevalidacionLicConstruccion,
                            txtObsNumResolRevalidacionLicConstruccion,
                            fchEjecutaRevalidacionLicConstruccion,
                            fchVenceRevalidacionLicConstruccion,
                            txtNombreVendedor,
                            numNitVendedor,
                            txtCedulaCatastral,
                            txtEscritura,
                            fchEscritura,
                            numNotaria,
                            txtNombreInterventor,
                            txtDireccionInterventor,
                            numTelefonoInterventor,
                            txtCorreoInterventor,
                            bolTipoPersonaInterventor,
                            numCedulaInterventor,
                            numTProfesionalInterventor,
                            numNitInterventor,
                            txtNombreRepLegalInterventor,
                            txtDireccionRepLegalInterventor,
                            numTelefonoRepLegalInterventor,
                            txtCorreoRepLegalInterventor,
                            numRadicadoJuridico,
                            fchRadicadoJuridico,
                            numRadicadoTecnico,
                            fchRadicadoTecnico,
                            numRadicadoFinanciero,
                            fchRadicadoFinanciero,
                            bolAprobacion,
                            numActaAprobacion,
                            fchActaAprobacion,
                            numResolucionAprobacion,
                            fchResolucionAprobacion,
                            txtActaResuelve,
                            bolCondicionAprobacion,
                            txtCondicionAprobacion,
                            txtObservacionAprobacion,
                            chkDocConstructor1,
                            txtDocConstructor1,
                            chkDocConstructor2,
                            txtDocConstructor2,
                            chkDocConstructor3,
                            txtDocConstructor3,
                            chkDocConstructor4,
                            txtDocConstructor4,
                            chkDocConstructor5,
                            txtDocConstructor5,
                            chkDocConstructor6,
                            txtDocConstructor6,
                            chkDocConstructor7,
                            txtDocConstructor7,
                            chkDocConstructor8,
                            txtDocConstructor8,
                            chkDocProyecto1,
                            txtDocProyecto1,
                            chkDocProyecto2,
                            txtDocProyecto2,
                            chkDocProyecto3,
                            txtDocProyecto3,
                            chkDocProyecto4,
                            txtDocProyecto4,
                            chkDocProyecto5,
                            txtDocProyecto5,
                            chkDocProyecto6,
                            txtDocProyecto6,
                            chkDocProyecto7,
                            txtDocProyecto7,
                            chkDocProyecto8,
                            txtDocProyecto8,
                            chkDocDesemConstructor1,
                            txtDocDesemConstructor1,
                            chkDocDesemConstructor2,
                            txtDocDesemConstructor2,
                            chkDocDesemConstructor3,
                            txtDocDesemConstructor3,
                            chkDocDesemConstructor4,
                            txtDocDesemConstructor4,
                            chkDocDesemConstructor5,
                            txtDocDesemConstructor5,
                            chkDocDesemEntidad1,
                            txtDocDesemEntidad1,
                            chkDocDesemEntidad2,
                            txtDocDesemEntidad2,
                            chkDocDesemEntidad3,
                            txtDocDesemEntidad3,
                            chkDocDesemEntidad4,
                            txtDocDesemEntidad4,
                            chkDocDesemEntidad5,
                            txtDocDesemEntidad5,
                            chkDocDesemEntidad6,
                            txtDocDesemEntidad6,
                            chkDocDesemEntidad7,
                            txtDocDesemEntidad7,
                            chkDocDesemEntidad8,
                            txtDocDesemEntidad8,
                            chkDocDesemEntidad9,
                            txtDocDesemEntidad9,
                            chkDocDesemProyecto1,
                            txtDocDesemProyecto1,
                            chkDocDesemProyecto2,
                            txtDocDesemProyecto2,
                            chkDocDesemProyecto3,
                            txtDocDesemProyecto3,
                            chkDocDesemProyecto4,
                            txtDocDesemProyecto4,
                            chkDocDesemProyecto5,
                            txtDocDesemProyecto5,
                            chkDocDesemProyecto6,
                            txtDocDesemProyecto6,
                            seqTipoModalidadDesembolso,
                            seqProfesionalResponsable,
                            optVoBoContratoInterventoria,
                            txtObservacionesContratoInterventoria,
                            fchRevisionContratoInterventoria,
                            seqTutorProyecto,
                            fchInicialTerreno,
                            fchFinalTerreno,
                            porcIncTerreno,
                            valActTerreno,
                            fchInicialPreliminarConstruccion,
                            fchFinalPreliminarConstruccion,
                            porcIncPreliminarConstruccion,
                            valActPreliminarConstruccion,
                            fchInicialCimentacionConstruccion,
                            fchFinalCimentacionConstruccion,
                            porcIncCimentacionConstruccion,
                            valActCimentacionConstruccion,
                            fchInicialDesaguesConstruccion,
                            fchFinalDesaguesConstruccion,
                            porcIncDesaguesConstruccion,
                            valActDesaguesConstruccion,
                            fchInicialEstructuraConstruccion,
                            fchFinalEstructuraConstruccion,
                            porcIncEstructuraConstruccion,
                            valActEstructuraConstruccion,
                            fchInicialMamposteriaConstruccion,
                            fchFinalMamposteriaConstruccion,
                            porcIncMamposteriaConstruccion,
                            valActMamposteriaConstruccion,
                            fchInicialPanetesConstruccion,
                            fchFinalPanetesConstruccion,
                            porcIncPanetesConstruccion,
                            valActPanetesConstruccion,
                            fchInicialHidrosanitariasConstruccion,
                            fchFinalHidrosanitariasConstruccion,
                            porcIncHidrosanitariasConstruccion,
                            valActHidrosanitariasConstruccion,
                            fchInicialElectricasConstruccion,
                            fchFinalElectricasConstruccion,
                            porcIncElectricasConstruccion,
                            valActElectricasConstruccion,
                            fchInicialCubiertaConstruccion,
                            fchFinalCubiertaConstruccion,
                            porcIncCubiertaConstruccion,
                            valActCubiertaConstruccion,
                            fchInicialCarpinteriaConstruccion,
                            fchFinalCarpinteriaConstruccion,
                            porcIncCarpinteriaConstruccion,
                            valActCarpinteriaConstruccion,
                            fchInicialPisosConstruccion,
                            fchFinalPisosConstruccion,
                            porcIncPisosConstruccion,
                            valActPisosConstruccion,
                            fchInicialSanitariosConstruccion,
                            fchFinalSanitariosConstruccion,
                            porcIncSanitariosConstruccion,
                            valActSanitariosConstruccion,
                            fchInicialExterioresConstruccion,
                            fchFinalExterioresConstruccion,
                            porcIncExterioresConstruccion,
                            valActExterioresConstruccion,
                            fchInicialAseoConstruccion,
                            fchFinalAseoConstruccion,
                            porcIncAseoConstruccion,
                            valActAseoConstruccion,
                            fchInicialPreliminarUrbanismo,
                            fchFinalPreliminarUrbanismo,
                            porcIncPreliminarUrbanismo,
                            valActPreliminarUrbanismo,
                            fchInicialCimentacionUrbanismo,
                            fchFinalCimentacionUrbanismo,
                            porcIncCimentacionUrbanismo,
                            valActCimentacionUrbanismo,
                            fchInicialDesaguesUrbanismo,
                            fchFinalDesaguesUrbanismo,
                            porcIncDesaguesUrbanismo,
                            valActDesaguesUrbanismo,
                            fchInicialViasUrbanismo,
                            fchFinalViasUrbanismo,
                            porcIncViasUrbanismo,
                            valActViasUrbanismo,
                            fchInicialParquesUrbanismo,
                            fchFinalParquesUrbanismo,
                            porcIncParquesUrbanismo,
                            valActParquesUrbanismo,
                            fchInicialAseoUrbanismo,
                            fchFinalAseoUrbanismo,
                            porcIncAseoUrbanismo,
                            valActAseoUrbanismo,
                            fchInicialLicenciaUrbanismo,
                            fchFinalLicenciaUrbanismo,
                            fchInicialLicenciaConstruccion,
                            fchFinalLicenciaConstruccion,
                            fchInicialVentasProyecto,
                            fchFinalVentasProyecto,
                            numViviendaVentasProyecto,
                            fchInicialEntregaEscrituracionVivienda,
                            fchFinalEntregaEscrituracionVivienda,
                            numViviendaEntregaEscrituracionVivienda,
                            txtDescripcionHitos,
                            seqPryEstadoProceso,
                            bolActivo,
                            fchInscripcion,
                            fchUltimaActualizacion
                    FROM
                            T_PRY_PROYECTO 
                    LEFT JOIN T_PRY_DOCUMENTOS_POSTULACION ON (T_PRY_PROYECTO.seqProyecto = T_PRY_DOCUMENTOS_POSTULACION.seqProyecto)
                    LEFT JOIN T_PRY_DOCUMENTOS_DESEMBOLSO ON (T_PRY_PROYECTO.seqProyecto = T_PRY_DOCUMENTOS_DESEMBOLSO.seqProyecto)				
                    LEFT JOIN T_PRY_CRONOGRAMA_OBRAS ON (T_PRY_PROYECTO.seqProyecto = T_PRY_CRONOGRAMA_OBRAS.seqProyecto)
                    WHERE T_PRY_PROYECTO.seqProyecto > 0
                            $txtCondicion
                    ORDER BY
                            txtNombreProyecto
			";

        //echo $sql;

        $objRes = $aptBd->execute($sql);
        if ($aptBd->ErrorMsg() == "") {
            while ($objRes->fields) {
                $seqProyecto = $objRes->fields['seqProyecto'];
                $objProyectoVivienda = new ProyectoVivienda;
                $objProyectoVivienda->seqProyecto = $objRes->fields['seqProyecto'];
                $objProyectoVivienda->numNitProyecto = $objRes->fields['numNitProyecto'];
                $objProyectoVivienda->txtNombreProyecto = $objRes->fields['txtNombreProyecto'];
                $objProyectoVivienda->txtNombreComercial = $objRes->fields['txtNombreComercial'];
                $objProyectoVivienda->txtNombrePlanParcial = $objRes->fields['txtNombrePlanParcial'];
                $objProyectoVivienda->seqPlanGobierno = $objRes->fields['seqPlanGobierno'];
                $objProyectoVivienda->seqTipoEsquema = $objRes->fields['seqTipoEsquema'];
                $objProyectoVivienda->seqPryTipoModalidad = $objRes->fields['seqPryTipoModalidad'];
                $objProyectoVivienda->txtNombreOperador = $objRes->fields['txtNombreOperador'];
                $objProyectoVivienda->txtObjetoProyecto = $objRes->fields['txtObjetoProyecto'];
                $objProyectoVivienda->txtOtrosBarrios = $objRes->fields['txtOtrosBarrios'];
                $objProyectoVivienda->seqOpv = $objRes->fields['seqOpv'];
                $objProyectoVivienda->seqTipoProyecto = $objRes->fields['seqTipoProyecto'];
                $objProyectoVivienda->seqTipoUrbanizacion = $objRes->fields['seqTipoUrbanizacion'];
                $objProyectoVivienda->seqTipoSolucion = $objRes->fields['seqTipoSolucion'];
                $objProyectoVivienda->txtDescripcionProyecto = $objRes->fields['txtDescripcionProyecto'];
                $objProyectoVivienda->bolDireccion = $objRes->fields['bolDireccion'];
                $objProyectoVivienda->txtDireccion = $objRes->fields['txtDireccion'];
                $objProyectoVivienda->seqLocalidad = $objRes->fields['seqLocalidad'];
                $objProyectoVivienda->seqBarrio = $objRes->fields['seqBarrio'];
                $objProyectoVivienda->valTorres = $objRes->fields['valTorres'];
                $objProyectoVivienda->valNumeroSoluciones = $objRes->fields['valNumeroSoluciones'];
                $objProyectoVivienda->valAreaConstruida = $objRes->fields['valAreaConstruida'];
                $objProyectoVivienda->valAreaLote = $objRes->fields['valAreaLote'];
                $objProyectoVivienda->txtChipLote = $objRes->fields['txtChipLote'];
                $objProyectoVivienda->txtMatriculaInmobiliariaLote = $objRes->fields['txtMatriculaInmobiliariaLote'];
                $objProyectoVivienda->txtRegistroEnajenacion = $objRes->fields['txtRegistroEnajenacion'];
                $objProyectoVivienda->fchRegistroEnajenacion = $objRes->fields['fchRegistroEnajenacion'];
                $objProyectoVivienda->bolEquipamientoComunal = $objRes->fields['bolEquipamientoComunal'];
                $objProyectoVivienda->txtDescEquipamientoComunal = $objRes->fields['txtDescEquipamientoComunal'];

                $objProyectoVivienda->txtNombreOferente = $objRes->fields['txtNombreOferente'];
                $objProyectoVivienda->numNitOferente = $objRes->fields['numNitOferente'];
                $objProyectoVivienda->txtNombreContactoOferente = $objRes->fields['txtNombreContactoOferente'];
                $objProyectoVivienda->numTelefonoOferente = $objRes->fields['numTelefonoOferente'];
                $objProyectoVivienda->numExtensionOferente = $objRes->fields['numExtensionOferente'];
                $objProyectoVivienda->numCelularOferente = $objRes->fields['numCelularOferente'];
                $objProyectoVivienda->txtCorreoOferente = $objRes->fields['txtCorreoOferente'];
                $objProyectoVivienda->txtNombreOferente2 = $objRes->fields['txtNombreOferente2'];
                $objProyectoVivienda->numNitOferente2 = $objRes->fields['numNitOferente2'];
                $objProyectoVivienda->txtNombreContactoOferente2 = $objRes->fields['txtNombreContactoOferente2'];
                $objProyectoVivienda->numTelefonoOferente2 = $objRes->fields['numTelefonoOferente2'];
                $objProyectoVivienda->numExtensionOferente2 = $objRes->fields['numExtensionOferente2'];
                $objProyectoVivienda->numCelularOferente2 = $objRes->fields['numCelularOferente2'];
                $objProyectoVivienda->txtCorreoOferente2 = $objRes->fields['txtCorreoOferente2'];
                $objProyectoVivienda->txtNombreOferente3 = $objRes->fields['txtNombreOferente3'];
                $objProyectoVivienda->numNitOferente3 = $objRes->fields['numNitOferente3'];
                $objProyectoVivienda->txtNombreContactoOferente3 = $objRes->fields['txtNombreContactoOferente3'];
                $objProyectoVivienda->numTelefonoOferente3 = $objRes->fields['numTelefonoOferente3'];
                $objProyectoVivienda->numExtensionOferente3 = $objRes->fields['numExtensionOferente3'];
                $objProyectoVivienda->numCelularOferente3 = $objRes->fields['numCelularOferente3'];
                $objProyectoVivienda->txtCorreoOferente3 = $objRes->fields['txtCorreoOferente3'];
                $objProyectoVivienda->txtRepresentanteLegalOferente = $objRes->fields['txtRepresentanteLegalOferente'];
                $objProyectoVivienda->numNitRepresentanteLegalOferente = $objRes->fields['numNitRepresentanteLegalOferente'];
                $objProyectoVivienda->numTelefonoRepresentanteLegalOferente = $objRes->fields['numTelefonoRepresentanteLegalOferente'];
                $objProyectoVivienda->numExtensionRepresentanteLegalOferente = $objRes->fields['numExtensionRepresentanteLegalOferente'];
                $objProyectoVivienda->numCelularRepresentanteLegalOferente = $objRes->fields['numCelularRepresentanteLegalOferente'];
                $objProyectoVivienda->txtDireccionRepresentanteLegalOferente = $objRes->fields['txtDireccionRepresentanteLegalOferente'];
                $objProyectoVivienda->txtCorreoRepresentanteLegalOferente = $objRes->fields['txtCorreoRepresentanteLegalOferente'];

                $objProyectoVivienda->bolConstructor = $objRes->fields['bolConstructor'];
                $objProyectoVivienda->seqConstructor = $objRes->fields['seqConstructor'];

                $objProyectoVivienda->valCostosDirectos = $objRes->fields['valCostosDirectos'];
                $objProyectoVivienda->valCostosIndirectos = $objRes->fields['valCostosIndirectos'];
                $objProyectoVivienda->valTerreno = $objRes->fields['valTerreno'];
                $objProyectoVivienda->valGastosFinancieros = $objRes->fields['valGastosFinancieros'];
                $objProyectoVivienda->valGastosVentas = $objRes->fields['valGastosVentas'];
                $objProyectoVivienda->valTotalCostos = $objRes->fields['valTotalCostos'];
                $objProyectoVivienda->valTotalVentas = $objRes->fields['valTotalVentas'];
                $objProyectoVivienda->valUtilidadProyecto = $objRes->fields['valUtilidadProyecto'];
                $objProyectoVivienda->valRecursosPropios = $objRes->fields['valRecursosPropios'];
                $objProyectoVivienda->valCreditoEntidadFinanciera = $objRes->fields['valCreditoEntidadFinanciera'];
                $objProyectoVivienda->valCreditoParticulares = $objRes->fields['valCreditoParticulares'];
                $objProyectoVivienda->valVentasProyecto = $objRes->fields['valVentasProyecto'];
                $objProyectoVivienda->valSDVE = $objRes->fields['valSDVE'];
                $objProyectoVivienda->valOtros = $objRes->fields['valOtros'];
                $objProyectoVivienda->valDevolucionIVA = $objRes->fields['valDevolucionIVA'];
                $objProyectoVivienda->valTotalRecursos = $objRes->fields['valTotalRecursos'];

                $objProyectoVivienda->txtLicenciaUrbanismo = $objRes->fields['txtLicenciaUrbanismo'];
                $objProyectoVivienda->txtExpideLicenciaUrbanismo = $objRes->fields['txtExpideLicenciaUrbanismo'];
                $objProyectoVivienda->fchLicenciaUrbanismo1 = $objRes->fields['fchLicenciaUrbanismo1'];
                $objProyectoVivienda->fchLicenciaUrbanismo2 = $objRes->fields['fchLicenciaUrbanismo2'];
                $objProyectoVivienda->fchLicenciaUrbanismo3 = $objRes->fields['fchLicenciaUrbanismo3'];
                $objProyectoVivienda->fchVigenciaLicenciaUrbanismo = $objRes->fields['fchVigenciaLicenciaUrbanismo'];
                $objProyectoVivienda->fchEjecutoriaLicenciaUrbanismo = $objRes->fields['fchEjecutoriaLicenciaUrbanismo'];
                $objProyectoVivienda->txtResEjecutoriaLicenciaUrbanismo = $objRes->fields['txtResEjecutoriaLicenciaUrbanismo'];

                $objProyectoVivienda->txtLicenciaConstruccion = $objRes->fields['txtLicenciaConstruccion'];
                $objProyectoVivienda->fchLicenciaConstruccion1 = $objRes->fields['fchLicenciaConstruccion1'];
                $objProyectoVivienda->fchLicenciaConstruccion2 = $objRes->fields['fchLicenciaConstruccion2'];
                $objProyectoVivienda->fchLicenciaConstruccion3 = $objRes->fields['fchLicenciaConstruccion3'];
                $objProyectoVivienda->fchVigenciaLicenciaConstruccion = $objRes->fields['fchVigenciaLicenciaConstruccion'];
                $objProyectoVivienda->txtObsLicConstruccion = $objRes->fields['txtObsLicConstruccion'];
                $objProyectoVivienda->fchEjecutaLicConstruccion = $objRes->fields['fchEjecutaLicConstruccion'];
                $objProyectoVivienda->fchVenceLicConstruccion = $objRes->fields['fchVenceLicConstruccion'];
                $objProyectoVivienda->numResolProrrogaLicConstruccion = $objRes->fields['numResolProrrogaLicConstruccion'];
                $objProyectoVivienda->txtObsNumResolProrrogaLicConstruccion = $objRes->fields['txtObsNumResolProrrogaLicConstruccion'];
                $objProyectoVivienda->fchEjecutaProrrogaLicConstruccion = $objRes->fields['fchEjecutaProrrogaLicConstruccion'];
                $objProyectoVivienda->fchVenceProrrogaLicConstruccion = $objRes->fields['fchVenceProrrogaLicConstruccion'];
                $objProyectoVivienda->numResolRevalidacionLicConstruccion = $objRes->fields['numResolRevalidacionLicConstruccion'];
                $objProyectoVivienda->txtObsNumResolRevalidacionLicConstruccion = $objRes->fields['txtObsNumResolRevalidacionLicConstruccion'];
                $objProyectoVivienda->fchEjecutaRevalidacionLicConstruccion = $objRes->fields['fchEjecutaRevalidacionLicConstruccion'];
                $objProyectoVivienda->fchVenceRevalidacionLicConstruccion = $objRes->fields['fchVenceRevalidacionLicConstruccion'];

                $objProyectoVivienda->txtNombreVendedor = $objRes->fields['txtNombreVendedor'];
                $objProyectoVivienda->numNitVendedor = $objRes->fields['numNitVendedor'];
                $objProyectoVivienda->txtCedulaCatastral = $objRes->fields['txtCedulaCatastral'];
                $objProyectoVivienda->txtEscritura = $objRes->fields['txtEscritura'];
                $objProyectoVivienda->fchEscritura = $objRes->fields['fchEscritura'];
                $objProyectoVivienda->numNotaria = $objRes->fields['numNotaria'];

                $objProyectoVivienda->txtNombreInterventor = $objRes->fields['txtNombreInterventor'];
                $objProyectoVivienda->txtDireccionInterventor = $objRes->fields['txtDireccionInterventor'];
                $objProyectoVivienda->numTelefonoInterventor = $objRes->fields['numTelefonoInterventor'];
                $objProyectoVivienda->txtCorreoInterventor = $objRes->fields['txtCorreoInterventor'];
                $objProyectoVivienda->bolTipoPersonaInterventor = $objRes->fields['bolTipoPersonaInterventor'];
                $objProyectoVivienda->numCedulaInterventor = $objRes->fields['numCedulaInterventor'];
                $objProyectoVivienda->numTProfesionalInterventor = $objRes->fields['numTProfesionalInterventor'];
                $objProyectoVivienda->numNitInterventor = $objRes->fields['numNitInterventor'];
                $objProyectoVivienda->txtNombreRepLegalInterventor = $objRes->fields['txtNombreRepLegalInterventor'];
                $objProyectoVivienda->txtDireccionRepLegalInterventor = $objRes->fields['txtDireccionRepLegalInterventor'];
                $objProyectoVivienda->numTelefonoRepLegalInterventor = $objRes->fields['numTelefonoRepLegalInterventor'];
                $objProyectoVivienda->txtCorreoRepLegalInterventor = $objRes->fields['txtCorreoRepLegalInterventor'];

                $objProyectoVivienda->numRadicadoJuridico = $objRes->fields['numRadicadoJuridico'];
                $objProyectoVivienda->fchRadicadoJuridico = $objRes->fields['fchRadicadoJuridico'];
                $objProyectoVivienda->numRadicadoTecnico = $objRes->fields['numRadicadoTecnico'];
                $objProyectoVivienda->fchRadicadoTecnico = $objRes->fields['fchRadicadoTecnico'];
                $objProyectoVivienda->numRadicadoFinanciero = $objRes->fields['numRadicadoFinanciero'];
                $objProyectoVivienda->fchRadicadoFinanciero = $objRes->fields['fchRadicadoFinanciero'];
                $objProyectoVivienda->bolAprobacion = $objRes->fields['bolAprobacion'];
                $objProyectoVivienda->numActaAprobacion = $objRes->fields['numActaAprobacion'];
                $objProyectoVivienda->fchActaAprobacion = $objRes->fields['fchActaAprobacion'];
                $objProyectoVivienda->numResolucionAprobacion = $objRes->fields['numResolucionAprobacion'];
                $objProyectoVivienda->fchResolucionAprobacion = $objRes->fields['fchResolucionAprobacion'];
                $objProyectoVivienda->txtActaResuelve = $objRes->fields['txtActaResuelve'];
                $objProyectoVivienda->bolCondicionAprobacion = $objRes->fields['bolCondicionAprobacion'];
                $objProyectoVivienda->txtCondicionAprobacion = $objRes->fields['txtCondicionAprobacion'];
                $objProyectoVivienda->txtObservacionAprobacion = $objRes->fields['txtObservacionAprobacion'];

                $objProyectoVivienda->chkDocConstructor1 = $objRes->fields['chkDocConstructor1'];
                $objProyectoVivienda->txtDocConstructor1 = $objRes->fields['txtDocConstructor1'];
                $objProyectoVivienda->chkDocConstructor2 = $objRes->fields['chkDocConstructor2'];
                $objProyectoVivienda->txtDocConstructor2 = $objRes->fields['txtDocConstructor2'];
                $objProyectoVivienda->chkDocConstructor3 = $objRes->fields['chkDocConstructor3'];
                $objProyectoVivienda->txtDocConstructor3 = $objRes->fields['txtDocConstructor3'];
                $objProyectoVivienda->chkDocConstructor4 = $objRes->fields['chkDocConstructor4'];
                $objProyectoVivienda->txtDocConstructor4 = $objRes->fields['txtDocConstructor4'];
                $objProyectoVivienda->chkDocConstructor5 = $objRes->fields['chkDocConstructor5'];
                $objProyectoVivienda->txtDocConstructor5 = $objRes->fields['txtDocConstructor5'];
                $objProyectoVivienda->chkDocConstructor6 = $objRes->fields['chkDocConstructor6'];
                $objProyectoVivienda->txtDocConstructor6 = $objRes->fields['txtDocConstructor6'];
                $objProyectoVivienda->chkDocConstructor7 = $objRes->fields['chkDocConstructor7'];
                $objProyectoVivienda->txtDocConstructor7 = $objRes->fields['txtDocConstructor7'];
                $objProyectoVivienda->chkDocConstructor8 = $objRes->fields['chkDocConstructor8'];
                $objProyectoVivienda->txtDocConstructor8 = $objRes->fields['txtDocConstructor8'];
                $objProyectoVivienda->chkDocProyecto1 = $objRes->fields['chkDocProyecto1'];
                $objProyectoVivienda->txtDocProyecto1 = $objRes->fields['txtDocProyecto1'];
                $objProyectoVivienda->chkDocProyecto2 = $objRes->fields['chkDocProyecto2'];
                $objProyectoVivienda->txtDocProyecto2 = $objRes->fields['txtDocProyecto2'];
                $objProyectoVivienda->chkDocProyecto3 = $objRes->fields['chkDocProyecto3'];
                $objProyectoVivienda->txtDocProyecto3 = $objRes->fields['txtDocProyecto3'];
                $objProyectoVivienda->chkDocProyecto4 = $objRes->fields['chkDocProyecto4'];
                $objProyectoVivienda->txtDocProyecto4 = $objRes->fields['txtDocProyecto4'];
                $objProyectoVivienda->chkDocProyecto5 = $objRes->fields['chkDocProyecto5'];
                $objProyectoVivienda->txtDocProyecto5 = $objRes->fields['txtDocProyecto5'];
                $objProyectoVivienda->chkDocProyecto6 = $objRes->fields['chkDocProyecto6'];
                $objProyectoVivienda->txtDocProyecto6 = $objRes->fields['txtDocProyecto6'];
                $objProyectoVivienda->chkDocProyecto7 = $objRes->fields['chkDocProyecto7'];
                $objProyectoVivienda->txtDocProyecto7 = $objRes->fields['txtDocProyecto7'];
                $objProyectoVivienda->chkDocProyecto8 = $objRes->fields['chkDocProyecto8'];
                $objProyectoVivienda->txtDocProyecto8 = $objRes->fields['txtDocProyecto8'];

                $objProyectoVivienda->chkDocDesemConstructor1 = $objRes->fields['chkDocDesemConstructor1'];
                $objProyectoVivienda->txtDocDesemConstructor1 = $objRes->fields['txtDocDesemConstructor1'];
                $objProyectoVivienda->chkDocDesemConstructor2 = $objRes->fields['chkDocDesemConstructor2'];
                $objProyectoVivienda->txtDocDesemConstructor2 = $objRes->fields['txtDocDesemConstructor2'];
                $objProyectoVivienda->chkDocDesemConstructor3 = $objRes->fields['chkDocDesemConstructor3'];
                $objProyectoVivienda->txtDocDesemConstructor3 = $objRes->fields['txtDocDesemConstructor3'];
                $objProyectoVivienda->chkDocDesemConstructor4 = $objRes->fields['chkDocDesemConstructor4'];
                $objProyectoVivienda->txtDocDesemConstructor4 = $objRes->fields['txtDocDesemConstructor4'];
                $objProyectoVivienda->chkDocDesemConstructor5 = $objRes->fields['chkDocDesemConstructor5'];
                $objProyectoVivienda->txtDocDesemConstructor5 = $objRes->fields['txtDocDesemConstructor5'];
                $objProyectoVivienda->chkDocDesemEntidad1 = $objRes->fields['chkDocDesemEntidad1'];
                $objProyectoVivienda->txtDocDesemEntidad1 = $objRes->fields['txtDocDesemEntidad1'];
                $objProyectoVivienda->chkDocDesemEntidad2 = $objRes->fields['chkDocDesemEntidad2'];
                $objProyectoVivienda->txtDocDesemEntidad2 = $objRes->fields['txtDocDesemEntidad2'];
                $objProyectoVivienda->chkDocDesemEntidad3 = $objRes->fields['chkDocDesemEntidad3'];
                $objProyectoVivienda->txtDocDesemEntidad3 = $objRes->fields['txtDocDesemEntidad3'];
                $objProyectoVivienda->chkDocDesemEntidad4 = $objRes->fields['chkDocDesemEntidad4'];
                $objProyectoVivienda->txtDocDesemEntidad4 = $objRes->fields['txtDocDesemEntidad4'];
                $objProyectoVivienda->chkDocDesemEntidad5 = $objRes->fields['chkDocDesemEntidad5'];
                $objProyectoVivienda->txtDocDesemEntidad5 = $objRes->fields['txtDocDesemEntidad5'];
                $objProyectoVivienda->chkDocDesemEntidad6 = $objRes->fields['chkDocDesemEntidad6'];
                $objProyectoVivienda->txtDocDesemEntidad6 = $objRes->fields['txtDocDesemEntidad6'];
                $objProyectoVivienda->chkDocDesemEntidad7 = $objRes->fields['chkDocDesemEntidad7'];
                $objProyectoVivienda->txtDocDesemEntidad7 = $objRes->fields['txtDocDesemEntidad7'];
                $objProyectoVivienda->chkDocDesemEntidad8 = $objRes->fields['chkDocDesemEntidad8'];
                $objProyectoVivienda->txtDocDesemEntidad8 = $objRes->fields['txtDocDesemEntidad8'];
                $objProyectoVivienda->chkDocDesemEntidad9 = $objRes->fields['chkDocDesemEntidad9'];
                $objProyectoVivienda->txtDocDesemEntidad9 = $objRes->fields['txtDocDesemEntidad9'];
                $objProyectoVivienda->chkDocDesemProyecto1 = $objRes->fields['chkDocDesemProyecto1'];
                $objProyectoVivienda->txtDocDesemProyecto1 = $objRes->fields['txtDocDesemProyecto1'];
                $objProyectoVivienda->chkDocDesemProyecto2 = $objRes->fields['chkDocDesemProyecto2'];
                $objProyectoVivienda->txtDocDesemProyecto2 = $objRes->fields['txtDocDesemProyecto2'];
                $objProyectoVivienda->chkDocDesemProyecto3 = $objRes->fields['chkDocDesemProyecto3'];
                $objProyectoVivienda->txtDocDesemProyecto3 = $objRes->fields['txtDocDesemProyecto3'];
                $objProyectoVivienda->chkDocDesemProyecto4 = $objRes->fields['chkDocDesemProyecto4'];
                $objProyectoVivienda->txtDocDesemProyecto4 = $objRes->fields['txtDocDesemProyecto4'];
                $objProyectoVivienda->chkDocDesemProyecto5 = $objRes->fields['chkDocDesemProyecto5'];
                $objProyectoVivienda->txtDocDesemProyecto5 = $objRes->fields['txtDocDesemProyecto5'];
                $objProyectoVivienda->chkDocDesemProyecto6 = $objRes->fields['chkDocDesemProyecto6'];
                $objProyectoVivienda->txtDocDesemProyecto6 = $objRes->fields['txtDocDesemProyecto6'];

                $objProyectoVivienda->seqTipoModalidadDesembolso = $objRes->fields['seqTipoModalidadDesembolso'];

                $objProyectoVivienda->fchInicialTerreno = $objRes->fields['fchInicialTerreno'];
                $objProyectoVivienda->fchFinalTerreno = $objRes->fields['fchFinalTerreno'];
                $objProyectoVivienda->porcIncTerreno = $objRes->fields['porcIncTerreno'];
                $objProyectoVivienda->valActTerreno = $objRes->fields['valActTerreno'];
                $objProyectoVivienda->fchInicialPreliminarConstruccion = $objRes->fields['fchInicialPreliminarConstruccion'];
                $objProyectoVivienda->fchFinalPreliminarConstruccion = $objRes->fields['fchFinalPreliminarConstruccion'];
                $objProyectoVivienda->porcIncPreliminarConstruccion = $objRes->fields['porcIncPreliminarConstruccion'];
                $objProyectoVivienda->valActPreliminarConstruccion = $objRes->fields['valActPreliminarConstruccion'];
                $objProyectoVivienda->fchInicialCimentacionConstruccion = $objRes->fields['fchInicialCimentacionConstruccion'];
                $objProyectoVivienda->fchFinalCimentacionConstruccion = $objRes->fields['fchFinalCimentacionConstruccion'];
                $objProyectoVivienda->porcIncCimentacionConstruccion = $objRes->fields['porcIncCimentacionConstruccion'];
                $objProyectoVivienda->valActCimentacionConstruccion = $objRes->fields['valActCimentacionConstruccion'];
                $objProyectoVivienda->fchInicialDesaguesConstruccion = $objRes->fields['fchInicialDesaguesConstruccion'];
                $objProyectoVivienda->fchFinalDesaguesConstruccion = $objRes->fields['fchFinalDesaguesConstruccion'];
                $objProyectoVivienda->porcIncDesaguesConstruccion = $objRes->fields['porcIncDesaguesConstruccion'];
                $objProyectoVivienda->valActDesaguesConstruccion = $objRes->fields['valActDesaguesConstruccion'];
                $objProyectoVivienda->fchInicialEstructuraConstruccion = $objRes->fields['fchInicialEstructuraConstruccion'];
                $objProyectoVivienda->fchFinalEstructuraConstruccion = $objRes->fields['fchFinalEstructuraConstruccion'];
                $objProyectoVivienda->porcIncEstructuraConstruccion = $objRes->fields['porcIncEstructuraConstruccion'];
                $objProyectoVivienda->valActEstructuraConstruccion = $objRes->fields['valActEstructuraConstruccion'];
                $objProyectoVivienda->fchInicialMamposteriaConstruccion = $objRes->fields['fchInicialMamposteriaConstruccion'];
                $objProyectoVivienda->fchFinalMamposteriaConstruccion = $objRes->fields['fchFinalMamposteriaConstruccion'];
                $objProyectoVivienda->porcIncMamposteriaConstruccion = $objRes->fields['porcIncMamposteriaConstruccion'];
                $objProyectoVivienda->valActMamposteriaConstruccion = $objRes->fields['valActMamposteriaConstruccion'];
                $objProyectoVivienda->fchInicialPanetesConstruccion = $objRes->fields['fchInicialPanetesConstruccion'];
                $objProyectoVivienda->fchFinalPanetesConstruccion = $objRes->fields['fchFinalPanetesConstruccion'];
                $objProyectoVivienda->porcIncPanetesConstruccion = $objRes->fields['porcIncPanetesConstruccion'];
                $objProyectoVivienda->valActPanetesConstruccion = $objRes->fields['valActPanetesConstruccion'];
                $objProyectoVivienda->fchInicialHidrosanitariasConstruccion = $objRes->fields['fchInicialHidrosanitariasConstruccion'];
                $objProyectoVivienda->fchFinalHidrosanitariasConstruccion = $objRes->fields['fchFinalHidrosanitariasConstruccion'];
                $objProyectoVivienda->porcIncHidrosanitariasConstruccion = $objRes->fields['porcIncHidrosanitariasConstruccion'];
                $objProyectoVivienda->valActHidrosanitariasConstruccion = $objRes->fields['valActHidrosanitariasConstruccion'];
                $objProyectoVivienda->fchInicialElectricasConstruccion = $objRes->fields['fchInicialElectricasConstruccion'];
                $objProyectoVivienda->fchFinalElectricasConstruccion = $objRes->fields['fchFinalElectricasConstruccion'];
                $objProyectoVivienda->porcIncElectricasConstruccion = $objRes->fields['porcIncElectricasConstruccion'];
                $objProyectoVivienda->valActElectricasConstruccion = $objRes->fields['valActElectricasConstruccion'];
                $objProyectoVivienda->fchInicialCubiertaConstruccion = $objRes->fields['fchInicialCubiertaConstruccion'];
                $objProyectoVivienda->fchFinalCubiertaConstruccion = $objRes->fields['fchFinalCubiertaConstruccion'];
                $objProyectoVivienda->porcIncCubiertaConstruccion = $objRes->fields['porcIncCubiertaConstruccion'];
                $objProyectoVivienda->valActCubiertaConstruccion = $objRes->fields['valActCubiertaConstruccion'];
                $objProyectoVivienda->fchInicialCarpinteriaConstruccion = $objRes->fields['fchInicialCarpinteriaConstruccion'];
                $objProyectoVivienda->fchFinalCarpinteriaConstruccion = $objRes->fields['fchFinalCarpinteriaConstruccion'];
                $objProyectoVivienda->porcIncCarpinteriaConstruccion = $objRes->fields['porcIncCarpinteriaConstruccion'];
                $objProyectoVivienda->valActCarpinteriaConstruccion = $objRes->fields['valActCarpinteriaConstruccion'];
                $objProyectoVivienda->fchInicialPisosConstruccion = $objRes->fields['fchInicialPisosConstruccion'];
                $objProyectoVivienda->fchFinalPisosConstruccion = $objRes->fields['fchFinalPisosConstruccion'];
                $objProyectoVivienda->porcIncPisosConstruccion = $objRes->fields['porcIncPisosConstruccion'];
                $objProyectoVivienda->valActPisosConstruccion = $objRes->fields['valActPisosConstruccion'];
                $objProyectoVivienda->fchInicialSanitariosConstruccion = $objRes->fields['fchInicialSanitariosConstruccion'];
                $objProyectoVivienda->fchFinalSanitariosConstruccion = $objRes->fields['fchFinalSanitariosConstruccion'];
                $objProyectoVivienda->porcIncSanitariosConstruccion = $objRes->fields['porcIncSanitariosConstruccion'];
                $objProyectoVivienda->valActSanitariosConstruccion = $objRes->fields['valActSanitariosConstruccion'];
                $objProyectoVivienda->fchInicialExterioresConstruccion = $objRes->fields['fchInicialExterioresConstruccion'];
                $objProyectoVivienda->fchFinalExterioresConstruccion = $objRes->fields['fchFinalExterioresConstruccion'];
                $objProyectoVivienda->porcIncExterioresConstruccion = $objRes->fields['porcIncExterioresConstruccion'];
                $objProyectoVivienda->valActExterioresConstruccion = $objRes->fields['valActExterioresConstruccion'];
                $objProyectoVivienda->fchInicialAseoConstruccion = $objRes->fields['fchInicialAseoConstruccion'];
                $objProyectoVivienda->fchFinalAseoConstruccion = $objRes->fields['fchFinalAseoConstruccion'];
                $objProyectoVivienda->porcIncAseoConstruccion = $objRes->fields['porcIncAseoConstruccion'];
                $objProyectoVivienda->valActAseoConstruccion = $objRes->fields['valActAseoConstruccion'];
                $objProyectoVivienda->fchInicialPreliminarUrbanismo = $objRes->fields['fchInicialPreliminarUrbanismo'];
                $objProyectoVivienda->fchFinalPreliminarUrbanismo = $objRes->fields['fchFinalPreliminarUrbanismo'];
                $objProyectoVivienda->porcIncPreliminarUrbanismo = $objRes->fields['porcIncPreliminarUrbanismo'];
                $objProyectoVivienda->valActPreliminarUrbanismo = $objRes->fields['valActPreliminarUrbanismo'];
                $objProyectoVivienda->fchInicialCimentacionUrbanismo = $objRes->fields['fchInicialCimentacionUrbanismo'];
                $objProyectoVivienda->fchFinalCimentacionUrbanismo = $objRes->fields['fchFinalCimentacionUrbanismo'];
                $objProyectoVivienda->porcIncCimentacionUrbanismo = $objRes->fields['porcIncCimentacionUrbanismo'];
                $objProyectoVivienda->valActCimentacionUrbanismo = $objRes->fields['valActCimentacionUrbanismo'];
                $objProyectoVivienda->fchInicialDesaguesUrbanismo = $objRes->fields['fchInicialDesaguesUrbanismo'];
                $objProyectoVivienda->fchFinalDesaguesUrbanismo = $objRes->fields['fchFinalDesaguesUrbanismo'];
                $objProyectoVivienda->porcIncDesaguesUrbanismo = $objRes->fields['porcIncDesaguesUrbanismo'];
                $objProyectoVivienda->valActDesaguesUrbanismo = $objRes->fields['valActDesaguesUrbanismo'];
                $objProyectoVivienda->fchInicialViasUrbanismo = $objRes->fields['fchInicialViasUrbanismo'];
                $objProyectoVivienda->fchFinalViasUrbanismo = $objRes->fields['fchFinalViasUrbanismo'];
                $objProyectoVivienda->porcIncViasUrbanismo = $objRes->fields['porcIncViasUrbanismo'];
                $objProyectoVivienda->valActViasUrbanismo = $objRes->fields['valActViasUrbanismo'];
                $objProyectoVivienda->fchInicialParquesUrbanismo = $objRes->fields['fchInicialParquesUrbanismo'];
                $objProyectoVivienda->fchFinalParquesUrbanismo = $objRes->fields['fchFinalParquesUrbanismo'];
                $objProyectoVivienda->porcIncParquesUrbanismo = $objRes->fields['porcIncParquesUrbanismo'];
                $objProyectoVivienda->valActParquesUrbanismo = $objRes->fields['valActParquesUrbanismo'];
                $objProyectoVivienda->fchInicialAseoUrbanismo = $objRes->fields['fchInicialAseoUrbanismo'];
                $objProyectoVivienda->fchFinalAseoUrbanismo = $objRes->fields['fchFinalAseoUrbanismo'];
                $objProyectoVivienda->porcIncAseoUrbanismo = $objRes->fields['porcIncAseoUrbanismo'];
                $objProyectoVivienda->valActAseoUrbanismo = $objRes->fields['valActAseoUrbanismo'];
                $objProyectoVivienda->fchInicialLicenciaUrbanismo = $objRes->fields['fchInicialLicenciaUrbanismo'];
                $objProyectoVivienda->fchFinalLicenciaUrbanismo = $objRes->fields['fchFinalLicenciaUrbanismo'];
                $objProyectoVivienda->fchInicialLicenciaConstruccion = $objRes->fields['fchInicialLicenciaConstruccion'];
                $objProyectoVivienda->fchFinalLicenciaConstruccion = $objRes->fields['fchFinalLicenciaConstruccion'];
                $objProyectoVivienda->fchInicialVentasProyecto = $objRes->fields['fchInicialVentasProyecto'];
                $objProyectoVivienda->fchFinalVentasProyecto = $objRes->fields['fchFinalVentasProyecto'];
                $objProyectoVivienda->numViviendaVentasProyecto = $objRes->fields['numViviendaVentasProyecto'];
                $objProyectoVivienda->fchInicialEntregaEscrituracionVivienda = $objRes->fields['fchInicialEntregaEscrituracionVivienda'];
                $objProyectoVivienda->fchFinalEntregaEscrituracionVivienda = $objRes->fields['fchFinalEntregaEscrituracionVivienda'];
                $objProyectoVivienda->numViviendaEntregaEscrituracionVivienda = $objRes->fields['numViviendaEntregaEscrituracionVivienda'];
                $objProyectoVivienda->txtDescripcionHitos = $objRes->fields['txtDescripcionHitos'];

                $objProyectoVivienda->seqProfesionalResponsable = $objRes->fields['seqProfesionalResponsable'];
                $objProyectoVivienda->optVoBoContratoInterventoria = $objRes->fields['optVoBoContratoInterventoria'];
                $objProyectoVivienda->txtObservacionesContratoInterventoria = $objRes->fields['txtObservacionesContratoInterventoria'];
                $objProyectoVivienda->fchRevisionContratoInterventoria = $objRes->fields['fchRevisionContratoInterventoria'];

                $objProyectoVivienda->seqTutorProyecto = $objRes->fields['seqTutorProyecto'];
                $objProyectoVivienda->seqPryEstadoProceso = $objRes->fields['seqPryEstadoProceso'];
                $objProyectoVivienda->bolActivo = $objRes->fields['bolActivo'];
                $objProyectoVivienda->fchInscripcion = $objRes->fields['fchInscripcion'];
                $objProyectoVivienda->seqUsuario = $objRes->fields['seqUsuario'];
                $objProyectoVivienda->fchUltimaActualizacion = $objRes->fields['fchUltimaActualizacion'];
                //pr($objProyectoVivienda);
                $arrProyectoVivienda[$seqProyecto] = $objProyectoVivienda; // arreglo de objetos
                $objRes->MoveNext();
            }
        }
        //pr ($arrProyectoVivienda); die();
        return $arrProyectoVivienda;
    }

// Fin Cargar Proyecto

    /**
     * GUARDA EN LA BASE DE DATOS LA INFORMACION DE LOS PROYECTOS DE VIVIENDA
     * @author Jaison Ospina

     * @param String txtNombreProyecto
     * @param String txtNombreComercial
     * @param String txtNombrePlanParcial
     * @param integer numNitProyecto
     * @param integer seqTipoEsquema
     * @param integer seqTipoOrganizacion
     * @param integer seqTipoProyecto
     * @param integer seqTipoUrbanizacion
     * @param integer seqTipoSolucion
     * @param String txtDescripcionProyecto
     * @param integer valAreaConstruida
     * @param integer valAreaLote
     * @param String txtChipLote
     * @param String txtMatriculaInmobiliariaLote
     * @param integer valNumeroSoluciones
     * @param String txtRegistroEnajenacion
     * @param String fchRegistroEnajenacion
     * @param Boolean bolEquipamientoComunal
     * @param String txtDescEquipamientoComunal
     * @param integer bolConstructor
     * @param integer seqConstructor
     * @param integer numRadicadoJuridico
     * @param integer numRadicadoTecnico
     * @param integer numRadicadoFinanciero
     * @param integer bolAprobacion
     * @param integer numActaAprobacion
     * @param date fchActaAprobacion
     * @param integer numResolucionAprobacion
     * @param String fchResolucionAprobacion
     * @param String txtObservacionAprobacion
     * @param integer seqPryEstadoProceso
     * @param integer seqTutorProyecto
     * @param Boolean bolActivo
     * @return Array arrErrores
     * @version 0,1 Agosto 2013
     */
    public function guardarProyectoVivienda($seqProyecto, $numNitProyecto, $txtNombreProyecto, $txtNombreComercial, $txtNombrePlanParcial, $seqTipoEsquema, $seqPryTipoModalidad, $txtNombreOperador, $txtObjetoProyecto, $txtOtrosBarrios, $seqOpv, $seqTipoProyecto, $seqTipoUrbanizacion, $seqTipoSolucion, $txtDescripcionProyecto, $bolDireccion, $txtDireccion, $seqLocalidad, $seqBarrio, $valNumeroSoluciones, $valAreaConstruida, $valAreaLote, $txtChipLote, $txtMatriculaInmobiliariaLote, $txtRegistroEnajenacion, $fchRegistroEnajenacion, $bolEquipamientoComunal, $txtDescEquipamientoComunal, $txtNombreOferente, $numNitOferente, $txtNombreContactoOferente, $numTelefonoOferente, $numExtensionOferente, $numCelularOferente, $txtCorreoOferente, $txtNombreOferente2, $numNitOferente2, $txtNombreContactoOferente2, $numTelefonoOferente2, $numExtensionOferente2, $numCelularOferente2, $txtCorreoOferente2, $txtNombreOferente3, $numNitOferente3, $txtNombreContactoOferente3, $numTelefonoOferente3, $numExtensionOferente3, $numCelularOferente3, $txtCorreoOferente3, $txtRepresentanteLegalOferente, $numNitRepresentanteLegalOferente, $numTelefonoRepresentanteLegalOferente, $numExtensionRepresentanteLegalOferente, $numCelularRepresentanteLegalOferente, $txtDireccionRepresentanteLegalOferente, $txtCorreoRepresentanteLegalOferente, $bolConstructor, $seqConstructor, $seqTutorProyecto, $seqPryEstadoProceso, $bolActivo, $seqUsuario) {

        global $aptBd;
        $arrErrores = array();

        $numNitProyectoFormat = str_replace(".", "", $numNitProyecto);

        $fechaActual = date('Y-m-d H:i:s');
        // Instruccion para insertar el proyecto en la base de datos
        $sql = "INSERT INTO T_PRY_PROYECTO (
					numNitProyecto,
					txtNombreProyecto,
					txtNombreComercial,
					txtNombrePlanParcial,
					seqPlanGobierno,
					seqTipoEsquema,
					seqPryTipoModalidad,
					txtNombreOperador,
					txtObjetoProyecto,
					txtOtrosBarrios,
					seqOpv,
					seqTipoProyecto,
					seqTipoUrbanizacion,
					seqTipoSolucion,
					txtDescripcionProyecto,
					bolDireccion,
					txtDireccion,
					seqLocalidad,
					seqBarrio,
					valTorres,
					valNumeroSoluciones,
					valAreaConstruida,
					valAreaLote,
					txtChipLote,
					txtMatriculaInmobiliariaLote,
					txtRegistroEnajenacion,
					fchRegistroEnajenacion,
					bolEquipamientoComunal,
					txtDescEquipamientoComunal,
					bolConstructor,
					seqConstructor,
					txtLicenciaUrbanismo,
					txtExpideLicenciaUrbanismo,
					fchLicenciaUrbanismo1,
					fchLicenciaUrbanismo2,
					fchLicenciaUrbanismo3,
					fchVigenciaLicenciaUrbanismo,
					fchEjecutoriaLicenciaUrbanismo,
					txtResEjecutoriaLicenciaUrbanismo,
					txtLicenciaConstruccion,
					txtObsLicConstruccion,
					fchEjecutaLicConstruccion,
					fchVenceLicConstruccion,
					numResolProrrogaLicConstruccion,
					txtObsNumResolProrrogaLicConstruccion,
					fchEjecutaProrrogaLicConstruccion,
					fchVenceProrrogaLicConstruccion,
					numResolRevalidacionLicConstruccion,
					txtObsNumResolRevalidacionLicConstruccion,
					fchEjecutaRevalidacionLicConstruccion,
					fchVenceRevalidacionLicConstruccion,
					txtNombreInterventor,
					txtDireccionInterventor,
					numTelefonoInterventor,
					txtCorreoInterventor,
					bolTipoPersonaInterventor,
					numCedulaInterventor,
					numTProfesionalInterventor,
					numNitInterventor,
					txtNombreRepLegalInterventor,
					txtDireccionRepLegalInterventor,
					numTelefonoRepLegalInterventor,
					txtCorreoRepLegalInterventor,
					numRadicadoJuridico,
					fchRadicadoJuridico,
					numRadicadoTecnico,
					fchRadicadoTecnico,
					numRadicadoFinanciero,
					fchRadicadoFinanciero,
					bolAprobacion,
					numActaAprobacion,
					fchActaAprobacion,
					numResolucionAprobacion,
					fchResolucionAprobacion,
					txtActaResuelve,
					bolCondicionAprobacion,
					txtCondicionAprobacion,
					txtObservacionAprobacion,
					seqTutorProyecto,
					seqPryEstadoProceso,
					bolActivo,
					fchInscripcion,
					seqUsuario,
					fchUltimaActualizacion
				) VALUES (
					'$numNitProyectoFormat',
					\"" . preg_replace('/\"/', "", $txtNombreProyecto) . "\", 
					\"" . preg_replace('/\"/', "", $txtNombreComercial) . "\", 
					'$txtNombrePlanParcial',
					2,
					'$seqTipoEsquema',
					'$seqPryTipoModalidad',
					'$txtNombreOperador',
					'$txtObjetoProyecto',
					'$txtOtrosBarrios',
					'$seqOpv',
					'$seqTipoProyecto',
					'$seqTipoUrbanizacion',
					'$seqTipoSolucion', 
					'$txtDescripcionProyecto',
					'$bolDireccion',
					'$txtDireccion',
					'$seqLocalidad',
					'$seqBarrio',
					'$valTorres',
					'$valNumeroSoluciones',
					'$valAreaConstruida',
					'$valAreaLote',
					'$txtChipLote',
					'$txtMatriculaInmobiliariaLote',
					'$txtRegistroEnajenacion',
					'$fchRegistroEnajenacion',
					'$bolEquipamientoComunal',
					'$txtDescEquipamientoComunal',
					'$bolConstructor',
					'$seqConstructor',
					'$txtLicenciaUrbanismo',
					'$txtExpideLicenciaUrbanismo',
					'$fchLicenciaUrbanismo1',
					'$fchLicenciaUrbanismo2',
					'$fchLicenciaUrbanismo3',
					'$fchVigenciaLicenciaUrbanismo',
					'$fchEjecutoriaLicenciaUrbanismo',
					'$txtResEjecutoriaLicenciaUrbanismo',
					'$txtLicenciaConstruccion',
					'$txtObsLicConstruccion',
					'$fchEjecutaLicConstruccion',
					'$fchVenceLicConstruccion',
					'$numResolProrrogaLicConstruccion',
					'$txtObsNumResolProrrogaLicConstruccion',
					'$fchEjecutaProrrogaLicConstruccion',
					'$fchVenceProrrogaLicConstruccion',
					'$numResolRevalidacionLicConstruccion',
					'$txtObsNumResolRevalidacionLicConstruccion',
					'$fchEjecutaRevalidacionLicConstruccion',
					'$fchVenceRevalidacionLicConstruccion',
					'$txtNombreInterventor',
					'$txtDireccionInterventor',
					'$numTelefonoInterventor',
					'$txtCorreoInterventor',
					'$bolTipoPersonaInterventor',
					'$numCedulaInterventor',
					'$numTProfesionalInterventor',
					'$numNitInterventor',
					'$txtNombreRepLegalInterventor',
					'$txtDireccionRepLegalInterventor',
					'$numTelefonoRepLegalInterventor',
					'$txtCorreoRepLegalInterventor',
					'$numRadicadoJuridico',
					'$fchRadicadoJuridico',
					'$numRadicadoTecnico',
					'$fchRadicadoTecnico',
					'$numRadicadoFinanciero',
					'$fchRadicadoFinanciero',
					'$bolAprobacion',
					'$numActaAprobacion',
					'$fchActaAprobacion',
					'$numResolucionAprobacion',
					'$fchResolucionAprobacion',
					'$txtActaResuelve',
					'$bolCondicionAprobacion',
					'$txtCondicionAprobacion',
					'$txtObservacionAprobacion',
					'$seqTutorProyecto',
					'$seqPryEstadoProceso',
					'$bolActivo',
					'$fechaActual',
					'$seqUsuario',
					'$fechaActual'
				) ";

        //echo $sql;
        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido guardar el Proyecto <b>$txtNombreProyecto</b>. Reporte este error al administrador del sistema";
        }

        // Crea los registros correspondientes del proyecto creado en las tablas que sean necesarias
        if (empty($arrErrores)) {
            // Averigua cual es el seqProyecto recien creado
            $sql = "SELECT seqProyecto FROM T_PRY_PROYECTO WHERE txtNombreProyecto = '$txtNombreProyecto'";
            $objRes = $aptBd->execute($sql);
            $seqProyecto = $objRes->fields['seqProyecto'];

            // Crea el registro en la tabla T_PRY_DOCUMENTOS_POSTULACION
            $sqlDocPostulacion = "INSERT INTO T_PRY_DOCUMENTOS_POSTULACION (seqProyecto) VALUES ($seqProyecto)";
            $aptBd->execute($sqlDocPostulacion);

            // Crea el registro en la tabla T_PRY_DOCUMENTOS_DESEMBOLSO
            $sqlDocDesembolso = "INSERT INTO T_PRY_DOCUMENTOS_DESEMBOLSO (seqProyecto) VALUES ($seqProyecto)";
            $aptBd->execute($sqlDocDesembolso);

            // Crea el registro en la tabla T_PRY_CRONOGRAMA_OBRAS
            $sqlCronogramaObras = "INSERT INTO T_PRY_CRONOGRAMA_OBRAS (seqProyecto) VALUES ($seqProyecto)";
            $aptBd->execute($sqlCronogramaObras);

            // Crea las entidades que componen el oferente
            $sqlEntidadesOferente = "INSERT INTO T_PRY_ENTIDAD_OFERENTE (
											seqProyecto, txtNombreOferente, numNitOferente, txtNombreContactoOferente, numTelefonoOferente, 
											numExtensionOferente, numCelularOferente, txtCorreoOferente, txtNombreOferente2, numNitOferente2, txtNombreContactoOferente2, numTelefonoOferente2, numExtensionOferente2, numCelularOferente2, txtCorreoOferente2, txtNombreOferente3, numNitOferente3, txtNombreContactoOferente3, numTelefonoOferente3, numExtensionOferente3, numCelularOferente3, txtCorreoOferente3, txtRepresentanteLegalOferente, numNitRepresentanteLegalOferente, numTelefonoRepresentanteLegalOferente, numExtensionRepresentanteLegalOferente, numCelularRepresentanteLegalOferente, txtDireccionRepresentanteLegalOferente, txtCorreoRepresentanteLegalOferente
										) VALUES (
											$seqProyecto, '$txtNombreOferente', '$numNitOferente', '$txtNombreContactoOferente','$numTelefonoOferente', '$numExtensionOferente', '$numCelularOferente', '$txtCorreoOferente', '$txtNombreOferente2', '$numNitOferente2', '$txtNombreContactoOferente2','$numTelefonoOferente2', '$numExtensionOferente2', '$numCelularOferente2', '$txtCorreoOferente2', '$txtNombreOferente3', '$numNitOferente3', '$txtNombreContactoOferente3','$numTelefonoOferente3', '$numExtensionOferente3', '$numCelularOferente3', '$txtCorreoOferente3', '$txtRepresentanteLegalOferente', '$numNitRepresentanteLegalOferente', '$numTelefonoRepresentanteLegalOferente', '$numExtensionRepresentanteLegalOferente', '$numCelularRepresentanteLegalOferente', '$txtDireccionRepresentanteLegalOferente', '$txtCorreoRepresentanteLegalOferente'
										)";
            //echo $sqlEntidadesOferente;
            $aptBd->execute($sqlEntidadesOferente);
        }
        return $arrErrores;
    }

// Fin guardar Proyecto

    /**
     * MODIFICA LA INFORMACION DEL PROYECTO DE VIVIENDA SELECCIONADA Y GUARDA LOS NUEVOS DATOS
     * @author Jaison Ospina
     * @param integer seqProyecto
     * @param String txtNombreProyecto
     * @param String txtNombreComercial
     * @param String txtNombrePlanParcial
     * @param integer numNitProyecto
     * @param integer seqTipoEsquema
     * @param integer seqTipoOrganizacion
     * @param integer seqTipoProyecto
     * @param integer seqTipoUrbanizacion
     * @param integer seqTipoSolucion
     * @param String txtDescripcionProyecto
     * @param integer valAreaConstruida
     * @param integer valAreaLote
     * @param String txtChipLote
     * @param String txtMatriculaInmobiliariaLote
     * @param integer valNumeroSoluciones
     * @param String txtRegistroEnajenacion
     * @param String fchRegistroEnajenacion
     * @param Boolean bolEquipamientoComunal
     * @param String txtDescEquipamientoComunal
     * @param integer bolConstructor
     * @param integer seqConstructor
     * @param String txtLicenciaUrbanismo
     * @param String txtExpideLicenciaUrbanismo
     * @param Date fchLicenciaUrbanismo1
     * @param Date fchLicenciaUrbanismo2
     * @param Date fchLicenciaUrbanismo3
     * @param Date fchVigenciaLicenciaUrbanismo
     * @param Date fchEjecutoriaLicenciaUrbanismo
     * @param String txtResEjecutoriaLicenciaUrbanismo
     * @param String txtLicenciaConstruccion
     * @param String txtNombreInterventor
     * @param String txtDireccionInterventor
     * @param integer numTelefonoInterventor
     * @param String txtCorreoInterventor
     * @param integer bolTipoPersonaInterventor
     * @param integer numCedulaInterventor
     * @param integer numTProfesionalInterventor
     * @param integer numNitInterventor
     * @param integer txtNombreRepLegalInterventor
     * @param integer txtDireccionRepLegalInterventor
     * @param integer numTelefonoRepLegalInterventor
     * @param integer txtCorreoRepLegalInterventor
     * @param integer numRadicadoJuridico
     * @param integer numRadicadoTecnico
     * @param integer numRadicadoFinanciero
     * @param integer bolAprobacion
     * @param integer numActaAprobacion
     * @param date fchActaAprobacion
     * @param integer numResolucionAprobacion
     * @param String fchResolucionAprobacion
     * @param String txtObservacionAprobacion
     * @param Boolean bolActivo
     * @return Array arrErrores
     * @version 0.1 Agosto 2013
     */
    public function editarProyectoVivienda($seqProyecto) {

        global $aptBd;
        $arrErrores = array();

        // Consulta para hacer la actualizacion
        //if ($numCedulaInterventor == '') $numCedulaInterventor = '';

        $fechaActual = date('Y-m-d H:i:s');

        $numNitProyectoFormat = str_replace(".", "", $this->numNitProyecto);

        $sql = "UPDATE T_PRY_PROYECTO SET ";
        if ($this->numNitProyecto)
            $sql .= "numNitProyecto = \"" . $numNitProyectoFormat . "\", ";
        if ($this->txtNombreProyecto)
            $sql .= "txtNombreProyecto = \"" . ereg_replace('/\"/', "", $this->txtNombreProyecto) . "\", ";
        if ($this->txtNombreComercial)
            $sql .= "txtNombreComercial = \"" . ereg_replace('/\"/', "", $this->txtNombreComercial) . "\", ";
        if ($this->txtNombrePlanParcial)
            $sql .= "txtNombrePlanParcial = \"" . ereg_replace('/\"/', "", $this->txtNombrePlanParcial) . "\", ";
        if ($this->seqTipoEsquema)
            $sql .= "seqTipoEsquema = \"" . $this->seqTipoEsquema . "\", ";
        if ($this->seqPryTipoModalidad)
            $sql .= "seqPryTipoModalidad = \"" . $this->seqPryTipoModalidad . "\", ";
        if ($this->txtNombreOperador)
            $sql .= "txtNombreOperador = \"" . $this->txtNombreOperador . "\", ";
        if ($this->txtObjetoProyecto)
            $sql .= "txtObjetoProyecto = \"" . $this->txtObjetoProyecto . "\", ";
        if ($this->txtOtrosBarrios)
            $sql .= "txtOtrosBarrios = \"" . $this->txtOtrosBarrios . "\", ";
        if ($this->seqOpv)
            $sql .= "seqOpv = \"" . $this->seqOpv . "\", ";
        if ($this->seqTipoProyecto)
            $sql .= "seqTipoProyecto = \"" . $this->seqTipoProyecto . "\", ";
        if ($this->seqTipoUrbanizacion)
            $sql .= "seqTipoUrbanizacion = \"" . $this->seqTipoUrbanizacion . "\", ";
        if ($this->seqTipoSolucion)
            $sql .= "seqTipoSolucion = \"" . $this->seqTipoSolucion . "\", ";
        if ($this->txtDescripcionProyecto)
            $sql .= "txtDescripcionProyecto = \"" . $this->txtDescripcionProyecto . "\", ";
        if ($this->bolDireccion)
            $sql .= "bolDireccion = \"" . $this->bolDireccion . "\", ";
        if ($this->txtDireccion)
            $sql .= "txtDireccion = \"" . $this->txtDireccion . "\", ";
        if ($this->seqLocalidad)
            $sql .= "seqLocalidad = \"" . $this->seqLocalidad . "\", ";
        if ($this->seqBarrio)
            $sql .= "seqBarrio = \"" . $this->seqBarrio . "\", ";
        if ($this->valTorres)
            $sql .= "valTorres = \"" . $this->valTorres . "\", ";
        if ($this->valNumeroSoluciones)
            $sql .= "valNumeroSoluciones = \"" . $this->valNumeroSoluciones . "\", ";
        if ($this->valAreaConstruida)
            $sql .= "valAreaConstruida = \"" . $this->valAreaConstruida . "\", ";
        if ($this->valAreaLote)
            $sql .= "valAreaLote = \"" . $this->valAreaLote . "\", ";
        if ($this->txtChipLote)
            $sql .= "txtChipLote = \"" . $this->txtChipLote . "\", ";
        if ($this->txtMatriculaInmobiliariaLote)
            $sql .= "txtMatriculaInmobiliariaLote = \"" . $this->txtMatriculaInmobiliariaLote . "\", ";
        if ($this->txtRegistroEnajenacion)
            $sql .= "txtRegistroEnajenacion = \"" . $this->txtRegistroEnajenacion . "\", ";
        if ($this->fchRegistroEnajenacion)
            $sql .= "fchRegistroEnajenacion = \"" . $this->fchRegistroEnajenacion . "\", ";
        if ($this->bolEquipamientoComunal)
            $sql .= "bolEquipamientoComunal = \"" . $this->bolEquipamientoComunal . "\", ";
        if ($this->txtDescEquipamientoComunal)
            $sql .= "txtDescEquipamientoComunal = \"" . $this->txtDescEquipamientoComunal . "\", ";
        if ($this->bolConstructor)
            $sql .= "bolConstructor = \"" . $this->bolConstructor . "\", ";
        if ($this->seqConstructor)
            $sql .= "seqConstructor = \"" . $this->seqConstructor . "\", ";
        if ($this->valCostosDirectos)
            $sql .= "valCostosDirectos = \"" . $this->valCostosDirectos . "\",";
        if ($this->valCostosIndirectos)
            $sql .= "valCostosIndirectos = \"" . $this->valCostosIndirectos . "\", ";
        if ($this->valTerreno)
            $sql .= "valTerreno = \"" . $this->valTerreno . "\", ";
        if ($this->valGastosFinancieros)
            $sql .= "valGastosFinancieros = \"" . $this->valGastosFinancieros . "\", ";
        if ($this->valGastosVentas)
            $sql .= "valGastosVentas = \"" . $this->valGastosVentas . "\", ";
        if ($this->valTotalCostos)
            $sql .= "valTotalCostos = \"" . $this->valTotalCostos . "\", ";
        if ($this->valTotalVentas)
            $sql .= "valTotalVentas = \"" . $this->valTotalVentas . "\", ";
        if ($this->valUtilidadProyecto)
            $sql .= "valUtilidadProyecto = \"" . $this->valUtilidadProyecto . "\", ";
        if ($this->valRecursosPropios)
            $sql .= "valRecursosPropios = \"" . $this->valRecursosPropios . "\", ";
        if ($this->valCreditoEntidadFinanciera)
            $sql .= "valCreditoEntidadFinanciera = \"" . $this->valCreditoEntidadFinanciera . "\", ";
        if ($this->valCreditoParticulares)
            $sql .= "valCreditoParticulares = \"" . $this->valCreditoParticulares . "\", ";
        if ($this->valVentasProyecto)
            $sql .= "valVentasProyecto = \"" . $this->valVentasProyecto . "\", ";
        if ($this->valSDVE)
            $sql .= "valSDVE = \"" . $this->valSDVE . "\", ";
        if ($this->valOtros)
            $sql .= "valOtros = \"" . $this->valOtros . "\", ";
        if ($this->valDevolucionIVA)
            $sql .= "valDevolucionIVA = \"" . $this->valDevolucionIVA . "\", ";
        if ($this->valTotalRecursos)
            $sql .= "valTotalRecursos = \"" . $this->valTotalRecursos . "\", ";
        if ($this->txtLicenciaUrbanismo)
            $sql .= "txtLicenciaUrbanismo = \"" . $this->txtLicenciaUrbanismo . "\", ";
        if ($this->txtExpideLicenciaUrbanismo)
            $sql .= "txtExpideLicenciaUrbanismo = \"" . $this->txtExpideLicenciaUrbanismo . "\", ";
        if ($this->fchLicenciaUrbanismo1)
            $sql .= "fchLicenciaUrbanismo1 = \"" . $this->fchLicenciaUrbanismo1 . "\", ";
        if ($this->fchLicenciaUrbanismo2)
            $sql .= "fchLicenciaUrbanismo2 = \"" . $this->fchLicenciaUrbanismo2 . "\", ";
        if ($this->fchLicenciaUrbanismo3)
            $sql .= "fchLicenciaUrbanismo3 = \"" . $this->fchLicenciaUrbanismo3 . "\", ";
        if ($this->fchVigenciaLicenciaUrbanismo)
            $sql .= "fchVigenciaLicenciaUrbanismo = \"" . $this->fchVigenciaLicenciaUrbanismo . "\", ";
        if ($this->fchEjecutoriaLicenciaUrbanismo)
            $sql .= "fchEjecutoriaLicenciaUrbanismo = \"" . $this->fchEjecutoriaLicenciaUrbanismo . "\", ";
        if ($this->txtResEjecutoriaLicenciaUrbanismo)
            $sql .= "txtResEjecutoriaLicenciaUrbanismo = \"" . $this->txtResEjecutoriaLicenciaUrbanismo . "\", ";
        if ($this->txtLicenciaConstruccion)
            $sql .= "txtLicenciaConstruccion = \"" . $this->txtLicenciaConstruccion . "\", ";
        if ($this->fchLicenciaConstruccion1)
            $sql .= "fchLicenciaConstruccion1 = \"" . $this->fchLicenciaConstruccion1 . "\", ";
        if ($this->fchLicenciaConstruccion2)
            $sql .= "fchLicenciaConstruccion2 = \"" . $this->fchLicenciaConstruccion2 . "\", ";
        if ($this->fchLicenciaConstruccion3)
            $sql .= "fchLicenciaConstruccion3 = \"" . $this->fchLicenciaConstruccion3 . "\", ";
        if ($this->fchVigenciaLicenciaConstruccion)
            $sql .= "fchVigenciaLicenciaConstruccion = \"" . $this->fchVigenciaLicenciaConstruccion . "\", ";
        if ($this->txtObsLicConstruccion)
            $sql .= "txtObsLicConstruccion = \"" . $this->txtObsLicConstruccion . "\", ";
        if ($this->fchEjecutaLicConstruccion)
            $sql .= "fchEjecutaLicConstruccion = \"" . $this->fchEjecutaLicConstruccion . "\", ";
        if ($this->fchVenceLicConstruccion)
            $sql .= "fchVenceLicConstruccion = \"" . $this->fchVenceLicConstruccion . "\", ";
        if ($this->numResolProrrogaLicConstruccion)
            $sql .= "numResolProrrogaLicConstruccion = \"" . $this->numResolProrrogaLicConstruccion . "\", ";
        if ($this->txtObsNumResolProrrogaLicConstruccion)
            $sql .= "txtObsNumResolProrrogaLicConstruccion = \"" . $this->txtObsNumResolProrrogaLicConstruccion . "\", ";
        if ($this->fchEjecutaProrrogaLicConstruccion)
            $sql .= "fchEjecutaProrrogaLicConstruccion = \"" . $this->fchEjecutaProrrogaLicConstruccion . "\", ";
        if ($this->fchVenceProrrogaLicConstruccion)
            $sql .= "fchVenceProrrogaLicConstruccion = \"" . $this->fchVenceProrrogaLicConstruccion . "\", ";
        if ($this->numResolRevalidacionLicConstruccion)
            $sql .= "numResolRevalidacionLicConstruccion = \"" . $this->numResolRevalidacionLicConstruccion . "\", ";
        if ($this->txtObsNumResolRevalidacionLicConstruccion)
            $sql .= "txtObsNumResolRevalidacionLicConstruccion = \"" . $this->txtObsNumResolRevalidacionLicConstruccion . "\", ";
        if ($this->fchEjecutaRevalidacionLicConstruccion)
            $sql .= "fchEjecutaRevalidacionLicConstruccion = \"" . $this->fchEjecutaRevalidacionLicConstruccion . "\", ";
        if ($this->fchVenceRevalidacionLicConstruccion)
            $sql .= "fchVenceRevalidacionLicConstruccion = \"" . $this->fchVenceRevalidacionLicConstruccion . "\", ";
        if ($this->txtNombreVendedor)
            $sql .= "txtNombreVendedor = \"" . $this->txtNombreVendedor . "\", ";
        if ($this->numNitVendedor)
            $sql .= "numNitVendedor = \"" . $this->numNitVendedor . "\", ";
        if ($this->txtCedulaCatastral)
            $sql .= "txtCedulaCatastral = \"" . $this->txtCedulaCatastral . "\", ";
        if ($this->txtEscritura)
            $sql .= "txtEscritura = \"" . $this->txtEscritura . "\", ";
        if ($this->fchEscritura)
            $sql .= "fchEscritura = \"" . $this->fchEscritura . "\", ";
        if ($this->numNotaria)
            $sql .= "numNotaria = \"" . $this->numNotaria . "\", ";
        if ($this->txtNombreInterventor)
            $sql .= "txtNombreInterventor = \"" . $this->txtNombreInterventor . "\", ";
        if ($this->txtDireccionInterventor)
            $sql .= "txtDireccionInterventor = \"" . $this->txtDireccionInterventor . "\", ";
        if ($this->numTelefonoInterventor)
            $sql .= "numTelefonoInterventor = \"" . $this->numTelefonoInterventor . "\", ";
        if ($this->txtCorreoInterventor)
            $sql .= "txtCorreoInterventor = \"" . $this->txtCorreoInterventor . "\", ";
        if ($this->bolTipoPersonaInterventor)
            $sql .= "bolTipoPersonaInterventor = \"" . $this->bolTipoPersonaInterventor . "\", ";
        if ($this->numCedulaInterventor)
            $sql .= "numCedulaInterventor = \"" . $this->numCedulaInterventor . "\", ";
        if ($this->numTProfesionalInterventor)
            $sql .= "numTProfesionalInterventor = \"" . $this->numTProfesionalInterventor . "\", ";
        if ($this->numNitInterventor)
            $sql .= "numNitInterventor = \"" . $this->numNitInterventor . "\", ";
        if ($this->txtNombreRepLegalInterventor)
            $sql .= "txtNombreRepLegalInterventor = \"" . $this->txtNombreRepLegalInterventor . "\", ";
        if ($this->txtDireccionRepLegalInterventor)
            $sql .= "txtDireccionRepLegalInterventor = \"" . $this->txtDireccionRepLegalInterventor . "\", ";
        if ($this->numTelefonoRepLegalInterventor)
            $sql .= "numTelefonoRepLegalInterventor = \"" . $this->numTelefonoRepLegalInterventor . "\", ";
        if ($this->txtCorreoRepLegalInterventor)
            $sql .= "txtCorreoRepLegalInterventor = \"" . $this->txtCorreoRepLegalInterventor . "\", ";
        if ($this->numRadicadoJuridico)
            $sql .= "numRadicadoJuridico = \"" . $this->numRadicadoJuridico . "\", ";
        if ($this->fchRadicadoJuridico)
            $sql .= "fchRadicadoJuridico = \"" . $this->fchRadicadoJuridico . "\", ";
        if ($this->numRadicadoTecnico)
            $sql .= "numRadicadoTecnico = \"" . $this->numRadicadoTecnico . "\", ";
        if ($this->fchRadicadoTecnico)
            $sql .= "fchRadicadoTecnico = \"" . $this->fchRadicadoTecnico . "\", ";
        if ($this->numRadicadoFinanciero)
            $sql .= "numRadicadoFinanciero = \"" . $this->numRadicadoFinanciero . "\", ";
        if ($this->fchRadicadoFinanciero)
            $sql .= "fchRadicadoFinanciero = \"" . $this->fchRadicadoFinanciero . "\", ";
        if ($this->bolAprobacion)
            $sql .= "bolAprobacion = \"" . $this->bolAprobacion . "\", ";
        if ($this->numActaAprobacion)
            $sql .= "numActaAprobacion = \"" . $this->numActaAprobacion . "\", ";
        if ($this->fchActaAprobacion)
            $sql .= "fchActaAprobacion = \"" . $this->fchActaAprobacion . "\", ";
        if ($this->numResolucionAprobacion)
            $sql .= "numResolucionAprobacion = \"" . $this->numResolucionAprobacion . "\", ";
        if ($this->fchResolucionAprobacion)
            $sql .= "fchResolucionAprobacion = \"" . $this->fchResolucionAprobacion . "\", ";
        if ($this->txtActaResuelve)
            $sql .= "txtActaResuelve = \"" . $this->txtActaResuelve . "\", ";
        if ($this->bolCondicionAprobacion) {
            if ($this->bolCondicionAprobacion == 1) {
                $sql .= "bolCondicionAprobacion = \"" . $this->bolCondicionAprobacion . "\", ";
                $sql .= "txtCondicionAprobacion = \"" . $this->txtCondicionAprobacion . "\", ";
            } else {
                $sql .= "bolCondicionAprobacion = 0, ";
                $sql .= "txtCondicionAprobacion = '', ";
            }
        }
        if ($this->txtObservacionAprobacion)
            $sql .= "txtObservacionAprobacion = \"" . $this->txtObservacionAprobacion . "\", ";
        if ($this->seqTipoModalidadDesembolso)
            $sql .= "seqTipoModalidadDesembolso = \"" . $this->seqTipoModalidadDesembolso . "\", ";
        if ($this->seqProfesionalResponsable)
            $sql .= "seqProfesionalResponsable = \"" . $this->seqProfesionalResponsable . "\", ";
        if ($this->optVoBoContratoInterventoria)
            $sql .= "optVoBoContratoInterventoria = \"" . $this->optVoBoContratoInterventoria . "\", ";
        if ($this->optVoBoContratoInterventoria == 2) {
            $sql .= "txtObservacionesContratoInterventoria = \"" . $this->txtObservacionesContratoInterventoria . "\", ";
        } else {
            $sql .= "txtObservacionesContratoInterventoria = '', ";
        }
        if ($this->fchRevisionContratoInterventoria)
            $sql .= "fchRevisionContratoInterventoria = \"" . $this->fchRevisionContratoInterventoria . "\", ";
        if ($this->seqTutorProyecto)
            $sql .= "seqTutorProyecto = \"" . $this->seqTutorProyecto . "\", ";
        if ($this->bolActivo)
            $sql .= "bolActivo = \"" . $this->bolActivo . "\", ";
        if ($this->fchUltimaActualizacion)
            $sql .= "fchUltimaActualizacion = \"" . $fechaActual . "\" ";
        if ($this->seqPryEstadoProceso)
            $sql .= "seqPryEstadoProceso = \"" . $this->seqPryEstadoProceso . "\" ";
        $sql .= "WHERE seqProyecto = $seqProyecto";
        //echo $sql;

        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $arrProyectoVivienda = $this->cargarProyectoVivienda($seqProyecto);
            $arrErrores[] = "No se ha podido editar el Proyecto <b>" . $arrProyectoVivienda[$seqProyecto]->txtNombreProyecto . "</b>. Reporte este error al administrador del sistema";
        }

        // Crea los registros correspondientes del proyecto creado en las tablas que sean necesarias
        if (empty($arrErrores)) {
            // Actualiza los datos del Oferente
            if ($this->txtNombreOferente)
                $sqlEntidadesOferente = "UPDATE T_PRY_ENTIDAD_OFERENTE SET ";
            if ($this->numNitOferente)
                $sqlEntidadesOferente .= "numNitOferente = \"" . $this->numNitOferente . "\", ";
            if ($this->txtNombreContactoOferente)
                $sqlEntidadesOferente .= "txtNombreContactoOferente = \"" . $this->txtNombreContactoOferente . "\", ";
            if ($this->numTelefonoOferente)
                $sqlEntidadesOferente .= "numTelefonoOferente = \"" . $this->numTelefonoOferente . "\", ";
            if ($this->numExtensionOferente)
                $sqlEntidadesOferente .= "numExtensionOferente = \"" . $this->numExtensionOferente . "\", ";
            if ($this->numCelularOferente)
                $sqlEntidadesOferente .= "numCelularOferente = \"" . $this->numCelularOferente . "\", ";
            if ($this->txtCorreoOferente)
                $sqlEntidadesOferente .= "txtCorreoOferente = \"" . $this->txtCorreoOferente . "\", ";
            if ($this->txtNombreOferente2)
                $sqlEntidadesOferente .= "txtNombreOferente2 = \"" . $this->txtNombreOferente2 . "\", ";
            if ($this->numNitOferente2)
                $sqlEntidadesOferente .= "numNitOferente2 = \"" . $this->numNitOferente2 . "\", ";
            if ($this->txtNombreContactoOferente2)
                $sqlEntidadesOferente .= "txtNombreContactoOferente2 = \"" . $this->txtNombreContactoOferente2 . "\", ";
            if ($this->numTelefonoOferente2)
                $sqlEntidadesOferente .= "numTelefonoOferente2 = \"" . $this->numTelefonoOferente2 . "\", ";
            if ($this->numExtensionOferente2)
                $sqlEntidadesOferente .= "numExtensionOferente2 = \"" . $this->numExtensionOferente2 . "\", ";
            if ($this->numCelularOferente2)
                $sqlEntidadesOferente .= "numCelularOferente2 = \"" . $this->numCelularOferente2 . "\", ";
            if ($this->txtCorreoOferente2)
                $sqlEntidadesOferente .= "txtCorreoOferente2 = \"" . $this->txtCorreoOferente2 . "\", ";
            if ($this->txtNombreOferente3)
                $sqlEntidadesOferente .= "txtNombreOferente3 = \"" . $this->txtNombreOferente3 . "\", ";
            if ($this->numNitOferente3)
                $sqlEntidadesOferente .= "numNitOferente3 = \"" . $this->numNitOferente3 . "\", ";
            if ($this->txtNombreContactoOferente3)
                $sqlEntidadesOferente .= "txtNombreContactoOferente3 = \"" . $this->txtNombreContactoOferente3 . "\", ";
            if ($this->numTelefonoOferente3)
                $sqlEntidadesOferente .= "numTelefonoOferente3 = \"" . $this->numTelefonoOferente3 . "\", ";
            if ($this->numExtensionOferente3)
                $sqlEntidadesOferente .= "numExtensionOferente3 = \"" . $this->numExtensionOferente3 . "\", ";
            if ($this->numCelularOferente3)
                $sqlEntidadesOferente .= "numCelularOferente3 = \"" . $this->numCelularOferente3 . "\", ";
            if ($this->txtCorreoOferente3)
                $sqlEntidadesOferente .= "txtCorreoOferente3 = \"" . $this->txtCorreoOferente3 . "\", ";
            if ($this->txtRepresentanteLegalOferente)
                $sqlEntidadesOferente .= "txtRepresentanteLegalOferente = \"" . $this->txtRepresentanteLegalOferente . "\", ";
            if ($this->numNitRepresentanteLegalOferente)
                $sqlEntidadesOferente .= "numNitRepresentanteLegalOferente = \"" . $this->numNitRepresentanteLegalOferente . "\", ";
            if ($this->numTelefonoRepresentanteLegalOferente)
                $sqlEntidadesOferente .= "numTelefonoRepresentanteLegalOferente = \"" . $this->numTelefonoRepresentanteLegalOferente . "\", ";
            if ($this->numExtensionRepresentanteLegalOferente)
                $sqlEntidadesOferente .= "numExtensionRepresentanteLegalOferente = \"" . $this->numExtensionRepresentanteLegalOferente . "\", ";
            if ($this->numCelularRepresentanteLegalOferente)
                $sqlEntidadesOferente .= "numCelularRepresentanteLegalOferente = \"" . $this->numCelularRepresentanteLegalOferente . "\", ";
            if ($this->txtDireccionRepresentanteLegalOferente)
                $sqlEntidadesOferente .= "txtDireccionRepresentanteLegalOferente = \"" . $this->txtDireccionRepresentanteLegalOferente . "\", ";
            if ($this->txtCorreoRepresentanteLegalOferente)
                $sqlEntidadesOferente .= "txtCorreoRepresentanteLegalOferente = \"" . $this->txtCorreoRepresentanteLegalOferente . "\", ";
            if ($this->txtNombreOferente) {
                $sqlEntidadesOferente .= " txtNombreOferente = \"" . $this->txtNombreOferente . "\" ";
                $sqlEntidadesOferente .= " WHERE seqProyecto = $seqProyecto";
                $aptBd->execute($sqlEntidadesOferente);
            }
        }

        return $arrErrores;
    }

// Fin editar Proyecto

    public function editarEstadoProyectoVivienda($seqProyecto, $seqEstadoProcesoProyecto) {

        global $aptBd;
        $arrErrores = array();

        $fechaActual = date('Y-m-d H:i:s');

        $sql = "UPDATE T_PRY_PROYECTO SET
						seqPryEstadoProceso = \"" . $seqEstadoProcesoProyecto . "\",
						fchUltimaActualizacion = \"" . $fechaActual . "\"
					WHERE seqProyecto = $seqProyecto
			";
        //echo $sql;
        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $arrProyectoVivienda = $this->cargarProyectoVivienda($seqProyecto);
            $arrErrores[] = "No se ha podido editar el Proyecto <b>" . $arrProyectoVivienda[$seqProyecto]->txtNombreProyecto . "</b>. Reporte este error al administrador del sistema";
        }

        return $arrErrores;
    }

// Fin editar Proyecto
    ////////////////////////////////////////////////////////////////////////////////////

    public function editarDocumentosPostulacionProyecto($seqProyecto) {

        global $aptBd;
        $arrErrores = array();

        $sql = "UPDATE T_PRY_DOCUMENTOS_POSTULACION SET
						chkDocConstructor1 = \"" . $this->chkDocConstructor1 . "\",
						txtDocConstructor1 = \"" . $this->txtDocConstructor1 . "\",
						chkDocConstructor2 = \"" . $this->chkDocConstructor2 . "\",
						txtDocConstructor2 = \"" . $this->txtDocConstructor2 . "\",
						chkDocConstructor3 = \"" . $this->chkDocConstructor3 . "\",
						txtDocConstructor3 = \"" . $this->txtDocConstructor3 . "\",
						chkDocConstructor4 = \"" . $this->chkDocConstructor4 . "\",
						txtDocConstructor4 = \"" . $this->txtDocConstructor4 . "\",
						chkDocConstructor5 = \"" . $this->chkDocConstructor5 . "\",
						txtDocConstructor5 = \"" . $this->txtDocConstructor5 . "\",
						chkDocConstructor6 = \"" . $this->chkDocConstructor6 . "\",
						txtDocConstructor6 = \"" . $this->txtDocConstructor6 . "\",
						chkDocConstructor7 = \"" . $this->chkDocConstructor7 . "\",
						txtDocConstructor7 = \"" . $this->txtDocConstructor7 . "\",
						chkDocConstructor8 = \"" . $this->chkDocConstructor8 . "\",
						txtDocConstructor8 = \"" . $this->txtDocConstructor8 . "\",
						chkDocProyecto1 = \"" . $this->chkDocProyecto1 . "\",
						txtDocProyecto1 = \"" . $this->txtDocProyecto1 . "\",
						chkDocProyecto2 = \"" . $this->chkDocProyecto2 . "\",
						txtDocProyecto2 = \"" . $this->txtDocProyecto2 . "\",
						chkDocProyecto3 = \"" . $this->chkDocProyecto3 . "\",
						txtDocProyecto3 = \"" . $this->txtDocProyecto3 . "\",
						chkDocProyecto4 = \"" . $this->chkDocProyecto4 . "\",
						txtDocProyecto4 = \"" . $this->txtDocProyecto4 . "\",
						chkDocProyecto5 = \"" . $this->chkDocProyecto5 . "\",
						txtDocProyecto5 = \"" . $this->txtDocProyecto5 . "\",
						chkDocProyecto6 = \"" . $this->chkDocProyecto6 . "\",
						txtDocProyecto6 = \"" . $this->txtDocProyecto6 . "\",
						chkDocProyecto7 = \"" . $this->chkDocProyecto7 . "\",
						txtDocProyecto7 = \"" . $this->txtDocProyecto7 . "\",
						chkDocProyecto8 = \"" . $this->chkDocProyecto8 . "\",
						txtDocProyecto8 = \"" . $this->txtDocProyecto8 . "\"
					WHERE seqProyecto = $seqProyecto
			";
        //echo $sql;
        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $arrProyectoVivienda = $this->cargarProyectoVivienda($seqProyecto);
            $arrErrores[] = "No se ha podido editar el Proyecto <b>" . $arrProyectoVivienda[$seqProyecto]->txtNombreProyecto . "</b>. Reporte este error al administrador del sistema";
        }
        return $arrErrores;
    }

// Fin editar Documentos Postulación de Proyectos

    public function editarDocumentosDesembolsoProyecto($seqProyecto) {

        global $aptBd;
        $arrErrores = array();

        $sql = "UPDATE T_PRY_DOCUMENTOS_DESEMBOLSO SET
						chkDocDesemConstructor1 = \"" . $this->chkDocDesemConstructor1 . "\",
						txtDocDesemConstructor1 = \"" . $this->txtDocDesemConstructor1 . "\",
						chkDocDesemConstructor2 = \"" . $this->chkDocDesemConstructor2 . "\",
						txtDocDesemConstructor2 = \"" . $this->txtDocDesemConstructor2 . "\",
						chkDocDesemConstructor3 = \"" . $this->chkDocDesemConstructor3 . "\",
						txtDocDesemConstructor3 = \"" . $this->txtDocDesemConstructor3 . "\",
						chkDocDesemConstructor4 = \"" . $this->chkDocDesemConstructor4 . "\",
						txtDocDesemConstructor4 = \"" . $this->txtDocDesemConstructor4 . "\",
						chkDocDesemConstructor5 = \"" . $this->chkDocDesemConstructor5 . "\",
						txtDocDesemConstructor5 = \"" . $this->txtDocDesemConstructor5 . "\",
						chkDocDesemEntidad1 = \"" . $this->chkDocDesemEntidad1 . "\",
						txtDocDesemEntidad1 = \"" . $this->txtDocDesemEntidad1 . "\",
						chkDocDesemEntidad2 = \"" . $this->chkDocDesemEntidad2 . "\",
						txtDocDesemEntidad2 = \"" . $this->txtDocDesemEntidad2 . "\",
						chkDocDesemEntidad3 = \"" . $this->chkDocDesemEntidad3 . "\",
						txtDocDesemEntidad3 = \"" . $this->txtDocDesemEntidad3 . "\",
						chkDocDesemEntidad4 = \"" . $this->chkDocDesemEntidad4 . "\",
						txtDocDesemEntidad4 = \"" . $this->txtDocDesemEntidad4 . "\",
						chkDocDesemEntidad5 = \"" . $this->chkDocDesemEntidad5 . "\",
						txtDocDesemEntidad5 = \"" . $this->txtDocDesemEntidad5 . "\",
						chkDocDesemEntidad6 = \"" . $this->chkDocDesemEntidad6 . "\",
						txtDocDesemEntidad6 = \"" . $this->txtDocDesemEntidad6 . "\",
						chkDocDesemEntidad7 = \"" . $this->chkDocDesemEntidad7 . "\",
						txtDocDesemEntidad7 = \"" . $this->txtDocDesemEntidad7 . "\",
						chkDocDesemEntidad8 = \"" . $this->chkDocDesemEntidad8 . "\",
						txtDocDesemEntidad8 = \"" . $this->txtDocDesemEntidad8 . "\",
						chkDocDesemEntidad9 = \"" . $this->chkDocDesemEntidad9 . "\",
						txtDocDesemEntidad9 = \"" . $this->txtDocDesemEntidad9 . "\",
						chkDocDesemProyecto1 = \"" . $this->chkDocDesemProyecto1 . "\",
						txtDocDesemProyecto1 = \"" . $this->txtDocDesemProyecto1 . "\",
						chkDocDesemProyecto2 = \"" . $this->chkDocDesemProyecto2 . "\",
						txtDocDesemProyecto2 = \"" . $this->txtDocDesemProyecto2 . "\",
						chkDocDesemProyecto3 = \"" . $this->chkDocDesemProyecto3 . "\",
						txtDocDesemProyecto3 = \"" . $this->txtDocDesemProyecto3 . "\",
						chkDocDesemProyecto4 = \"" . $this->chkDocDesemProyecto4 . "\",
						txtDocDesemProyecto4 = \"" . $this->txtDocDesemProyecto4 . "\",
						chkDocDesemProyecto5 = \"" . $this->chkDocDesemProyecto5 . "\",
						txtDocDesemProyecto5 = \"" . $this->txtDocDesemProyecto5 . "\",
						chkDocDesemProyecto6 = \"" . $this->chkDocDesemProyecto6 . "\",
						txtDocDesemProyecto6 = \"" . $this->txtDocDesemProyecto6 . "\"
					WHERE seqProyecto = $seqProyecto
			";
        //echo $sql;
        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $arrProyectoVivienda = $this->cargarProyectoVivienda($seqProyecto);
            $arrErrores[] = "No se ha podido editar el Proyecto <b>" . $arrProyectoVivienda[$seqProyecto]->txtNombreProyecto . "</b>. Reporte este error al administrador del sistema";
        }
        return $arrErrores;
    }

// Fin editar Documentacion Desembolso Proyectos

    public function editarItemsCronogramaObras($seqProyecto) {

        global $aptBd;
        $arrErrores = array();

        $sql = "UPDATE T_PRY_CRONOGRAMA_OBRAS SET
						fchInicialTerreno = \"" . $this->fchInicialTerreno . "\",
						fchFinalTerreno = \"" . $this->fchFinalTerreno . "\",
						porcIncTerreno = \"" . $this->porcIncTerreno . "\",
						valActTerreno = \"" . $this->valActTerreno . "\",
						fchInicialPreliminarConstruccion = \"" . $this->fchInicialPreliminarConstruccion . "\",
						fchFinalPreliminarConstruccion = \"" . $this->fchFinalPreliminarConstruccion . "\",
						porcIncPreliminarConstruccion = \"" . $this->porcIncPreliminarConstruccion . "\",
						valActPreliminarConstruccion = \"" . $this->valActPreliminarConstruccion . "\",
						fchInicialCimentacionConstruccion = \"" . $this->fchInicialCimentacionConstruccion . "\",
						fchFinalCimentacionConstruccion = \"" . $this->fchFinalCimentacionConstruccion . "\",
						porcIncCimentacionConstruccion = \"" . $this->porcIncCimentacionConstruccion . "\",
						valActCimentacionConstruccion = \"" . $this->valActCimentacionConstruccion . "\",
						fchInicialDesaguesConstruccion = \"" . $this->fchInicialDesaguesConstruccion . "\",
						fchFinalDesaguesConstruccion = \"" . $this->fchFinalDesaguesConstruccion . "\",
						porcIncDesaguesConstruccion = \"" . $this->porcIncDesaguesConstruccion . "\",
						valActDesaguesConstruccion = \"" . $this->valActDesaguesConstruccion . "\",
						fchInicialEstructuraConstruccion = \"" . $this->fchInicialEstructuraConstruccion . "\",
						fchFinalEstructuraConstruccion = \"" . $this->fchFinalEstructuraConstruccion . "\",
						porcIncEstructuraConstruccion = \"" . $this->porcIncEstructuraConstruccion . "\",
						valActEstructuraConstruccion = \"" . $this->valActEstructuraConstruccion . "\",
						fchInicialMamposteriaConstruccion = \"" . $this->fchInicialMamposteriaConstruccion . "\",
						fchFinalMamposteriaConstruccion = \"" . $this->fchFinalMamposteriaConstruccion . "\",
						porcIncMamposteriaConstruccion = \"" . $this->porcIncMamposteriaConstruccion . "\",
						valActMamposteriaConstruccion = \"" . $this->valActMamposteriaConstruccion . "\",
						fchInicialPanetesConstruccion = \"" . $this->fchInicialPanetesConstruccion . "\",
						fchFinalPanetesConstruccion = \"" . $this->fchFinalPanetesConstruccion . "\",
						porcIncPanetesConstruccion = \"" . $this->porcIncPanetesConstruccion . "\",
						valActPanetesConstruccion = \"" . $this->valActPanetesConstruccion . "\",
						fchInicialHidrosanitariasConstruccion = \"" . $this->fchInicialHidrosanitariasConstruccion . "\",
						fchFinalHidrosanitariasConstruccion = \"" . $this->fchFinalHidrosanitariasConstruccion . "\",
						porcIncHidrosanitariasConstruccion = \"" . $this->porcIncHidrosanitariasConstruccion . "\",
						valActHidrosanitariasConstruccion = \"" . $this->valActHidrosanitariasConstruccion . "\",
						fchInicialElectricasConstruccion = \"" . $this->fchInicialElectricasConstruccion . "\",
						fchFinalElectricasConstruccion = \"" . $this->fchFinalElectricasConstruccion . "\",
						porcIncElectricasConstruccion = \"" . $this->porcIncElectricasConstruccion . "\",
						valActElectricasConstruccion = \"" . $this->valActElectricasConstruccion . "\",
						fchInicialCubiertaConstruccion = \"" . $this->fchInicialCubiertaConstruccion . "\",
						fchFinalCubiertaConstruccion = \"" . $this->fchFinalCubiertaConstruccion . "\",
						porcIncCubiertaConstruccion = \"" . $this->porcIncCubiertaConstruccion . "\",
						valActCubiertaConstruccion = \"" . $this->valActCubiertaConstruccion . "\",
						fchInicialCarpinteriaConstruccion = \"" . $this->fchInicialCarpinteriaConstruccion . "\",
						fchFinalCarpinteriaConstruccion = \"" . $this->fchFinalCarpinteriaConstruccion . "\",
						porcIncCarpinteriaConstruccion = \"" . $this->porcIncCarpinteriaConstruccion . "\",
						valActCarpinteriaConstruccion = \"" . $this->valActCarpinteriaConstruccion . "\",
						fchInicialPisosConstruccion = \"" . $this->fchInicialPisosConstruccion . "\",
						fchFinalPisosConstruccion = \"" . $this->fchFinalPisosConstruccion . "\",
						porcIncPisosConstruccion = \"" . $this->porcIncPisosConstruccion . "\",
						valActPisosConstruccion = \"" . $this->valActPisosConstruccion . "\",
						fchInicialSanitariosConstruccion = \"" . $this->fchInicialSanitariosConstruccion . "\",
						fchFinalSanitariosConstruccion = \"" . $this->fchFinalSanitariosConstruccion . "\",
						porcIncSanitariosConstruccion = \"" . $this->porcIncSanitariosConstruccion . "\",
						valActSanitariosConstruccion = \"" . $this->valActSanitariosConstruccion . "\",
						fchInicialExterioresConstruccion = \"" . $this->fchInicialExterioresConstruccion . "\",
						fchFinalExterioresConstruccion = \"" . $this->fchFinalExterioresConstruccion . "\",
						porcIncExterioresConstruccion = \"" . $this->porcIncExterioresConstruccion . "\",
						valActExterioresConstruccion = \"" . $this->valActExterioresConstruccion . "\",
						fchInicialAseoConstruccion = \"" . $this->fchInicialAseoConstruccion . "\",
						fchFinalAseoConstruccion = \"" . $this->fchFinalAseoConstruccion . "\",
						porcIncAseoConstruccion = \"" . $this->porcIncAseoConstruccion . "\",
						valActAseoConstruccion = \"" . $this->valActAseoConstruccion . "\",
						fchInicialPreliminarUrbanismo = \"" . $this->fchInicialPreliminarUrbanismo . "\",
						fchFinalPreliminarUrbanismo = \"" . $this->fchFinalPreliminarUrbanismo . "\",
						porcIncPreliminarUrbanismo = \"" . $this->porcIncPreliminarUrbanismo . "\",
						valActPreliminarUrbanismo = \"" . $this->valActPreliminarUrbanismo . "\",
						fchInicialCimentacionUrbanismo = \"" . $this->fchInicialCimentacionUrbanismo . "\",
						fchFinalCimentacionUrbanismo = \"" . $this->fchFinalCimentacionUrbanismo . "\",
						porcIncCimentacionUrbanismo = \"" . $this->porcIncCimentacionUrbanismo . "\",
						valActCimentacionUrbanismo = \"" . $this->valActCimentacionUrbanismo . "\",
						fchInicialDesaguesUrbanismo = \"" . $this->fchInicialDesaguesUrbanismo . "\",
						fchFinalDesaguesUrbanismo = \"" . $this->fchFinalDesaguesUrbanismo . "\",
						porcIncDesaguesUrbanismo = \"" . $this->porcIncDesaguesUrbanismo . "\",
						valActDesaguesUrbanismo = \"" . $this->valActDesaguesUrbanismo . "\",
						fchInicialViasUrbanismo = \"" . $this->fchInicialViasUrbanismo . "\",
						fchFinalViasUrbanismo = \"" . $this->fchFinalViasUrbanismo . "\",
						porcIncViasUrbanismo = \"" . $this->porcIncViasUrbanismo . "\",
						valActViasUrbanismo = \"" . $this->valActViasUrbanismo . "\",
						fchInicialParquesUrbanismo = \"" . $this->fchInicialParquesUrbanismo . "\",
						fchFinalParquesUrbanismo = \"" . $this->fchFinalParquesUrbanismo . "\",
						porcIncParquesUrbanismo = \"" . $this->porcIncParquesUrbanismo . "\",
						valActParquesUrbanismo = \"" . $this->valActParquesUrbanismo . "\",
						fchInicialAseoUrbanismo = \"" . $this->fchInicialAseoUrbanismo . "\",
						fchFinalAseoUrbanismo = \"" . $this->fchFinalAseoUrbanismo . "\",
						porcIncAseoUrbanismo = \"" . $this->porcIncAseoUrbanismo . "\",
						valActAseoUrbanismo = \"" . $this->valActAseoUrbanismo . "\",
						fchInicialLicenciaUrbanismo = \"" . $this->fchInicialLicenciaUrbanismo . "\",
						fchFinalLicenciaUrbanismo = \"" . $this->fchFinalLicenciaUrbanismo . "\",
						fchInicialLicenciaConstruccion = \"" . $this->fchInicialLicenciaConstruccion . "\",
						fchFinalLicenciaConstruccion = \"" . $this->fchFinalLicenciaConstruccion . "\",
						fchInicialVentasProyecto = \"" . $this->fchInicialVentasProyecto . "\",
						fchFinalVentasProyecto = \"" . $this->fchFinalVentasProyecto . "\",
						numViviendaVentasProyecto = \"" . $this->numViviendaVentasProyecto . "\",
						fchInicialEntregaEscrituracionVivienda = \"" . $this->fchInicialEntregaEscrituracionVivienda . "\",
						fchFinalEntregaEscrituracionVivienda = \"" . $this->fchFinalEntregaEscrituracionVivienda . "\",
						numViviendaEntregaEscrituracionVivienda = \"" . $this->numViviendaEntregaEscrituracionVivienda . "\",
						txtDescripcionHitos = \"" . $this->txtDescripcionHitos . "\"
					WHERE seqProyecto = $seqProyecto
			";
        //echo $sql;
        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $arrProyectoVivienda = $this->cargarProyectoVivienda($seqProyecto);
            $arrErrores[] = "No se ha podido editar el Proyecto <b>" . $arrProyectoVivienda[$seqProyecto]->txtNombreProyecto . "</b>. Reporte este error al administrador del sistema";
        }
        return $arrErrores;
    }

// Fin editar Documentos Postulación de Proyectos

    /**
     * VERIFICA SI SE PUEDE BORRAR EL PROYECTO Y SI ES POSIBLE LO BORRA DEL SISTEMA
     * @author Jaison Ospina
     * @param integer seqProyecto
     * @return array arrErrores
     * @version 1.0 Agosto 2013
     */
    public function borrarProyectoVivienda($seqProyecto) {

        global $aptBd;
        $arrErrores = array();

        // Valida que se pueda borrar la Proyecto
        //$arrErrores = $this->validarBorrarProyecto( $seqProyecto );
        // si no hay errores entra a eliminar
        if (empty($arrErrores)) {

            $sql = "
					DELETE
					FROM T_PRY_PROYECTO
					WHERE seqProyecto = $seqProyecto
				";

            // borra el proyecto de vivienda
            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrProyecto = $this->cargarProyectoVivienda($seqProyecto);
                $arrErrores[] = "No se ha podido borrar el proyecto de vivienda <b>" . $arrProyecto[$seqProyecto]->txtNombreProyecto . "</b>";
                //pr( $objError->getMessage() );
            }
        }

        return $arrErrores;
    }

// Fin borrar Proyecto

    public function ProyectoExiste($numNit) {

        global $aptBd;

        $seqProyecto = 0;

        $numNitFormat = str_replace(".", "", $numNit);

        $sql = "
				SELECT seqProyecto
				FROM T_PRY_PROYECTO
				WHERE numNitProyecto = $numNitFormat
			";

        //echo $sql;
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {
            $seqProyecto = $objRes->fields['seqProyecto'];
        }
        return $seqProyecto;
    }

    public function buscarNombreProyecto($txtParametro, $numLimiteRegistros = 6) {

        global $aptBd;

        $arrResultados = array();
        $txtParametro = strtolower($txtParametro);

        $sql = "SELECT CONCAT((SELECT  GROUP_CONCAT(seqOferente separator ',')
                FROM
                    t_pry_proyecto_oferente fr
                WHERE
                      fr.seqProyecto = T_PRY_PROYECTO.seqProyecto)) as seqOF,
                    CONCAT(txtNombreProyecto,
                    ' - ',           
                    (SELECT 
                            GROUP_CONCAT(txtNombreOferente SEPARATOR ';')
                        FROM
                            T_PRY_ENTIDAD_OFERENTE eof
                        WHERE
                            eof.seqOferente in (seqOF))) AS nombre,
                            T_PRY_PROYECTO.seqProyecto
                        FROM T_PRY_PROYECTO 
                        INNER JOIN t_pry_proyecto_oferente ON (T_PRY_PROYECTO.seqProyecto = t_pry_proyecto_oferente.seqProyecto)
                        INNER JOIN T_PRY_ENTIDAD_OFERENTE ON (T_PRY_ENTIDAD_OFERENTE.seqOferente = T_PRY_ENTIDAD_OFERENTE.seqOferente)   
                        WHERE txtNombreProyecto LIKE'%$txtParametro%' 
                       # WHERE CONCAT(txtNombreProyecto,' [',txtNombreOferente,']') LIKE'%$txtParametro%' 
                        GROUP BY seqProyecto LIMIT $numLimiteRegistros ";
        //echo $sql;
        try {
            $objRes = $aptBd->execute($sql);

            while ($objRes->fields) {
                $nombre = $objRes->fields['nombre'];
                $arrResultados[$nombre] = $objRes->fields['seqProyecto'];
                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            return $objError->msg;
        }

        return $arrResultados;
    }

    /////////////////////////////////// INICIO GESTIONA CONJUNTOS RESIDENCIALES DE UN PROYECTO //////////////////////////////////////////////////
    public function ingresarConjuntoResidencial($seqProyectoPadre, $arrDatosProyecto, $seqTutorProyecto) { // Inicio editar Conjunto Residencial
        global $aptBd;
        $arrErrores = array();

        // Conjuntos Residenciales Existentes asignados al proyecto padre
        $arrConjuntoResidencialExistentes = array();
        $sqlExistentes = "SELECT seqProyecto FROM T_PRY_PROYECTO WHERE seqProyectoPadre = $seqProyectoPadre";
        $exeExistentes = mysql_query($sqlExistentes);
        while ($rowExistentes = mysql_fetch_array($exeExistentes)) {
            $arrConjuntoResidencialExistentes[] = $rowExistentes['seqProyecto'];
        }
        // Campos a registrar en las consultas
        $seqUsuario = $_SESSION['seqUsuario'];
        $fchGestion = date("Y-m-d H:i:s");
        $arrArregloPost = array();

        // Recorre el arreglo que viene del formulario
        if (!empty($arrDatosProyecto)) {
            foreach ($arrDatosProyecto as $indice => $seqTipoVivienda) {
                $seqProyectoHijo = $_POST['seqProyectoHijo'][$indice];
                $txtNombreProyectoHijo = $_POST['txtNombreProyectoHijo'][$indice];
                $txtNombreComercialHijo = $_POST['txtNombreComercialHijo'][$indice];
                $txtDireccionHijo = $_POST['txtDireccionHijo'][$indice];
                $valNumeroSolucionesHijo = $_POST['valNumeroSolucionesHijo'][$indice];
                $txtChipLoteHijo = $_POST['txtChipLoteHijo'][$indice];
                $txtMatriculaInmobiliariaLoteHijo = $_POST['txtMatriculaInmobiliariaLoteHijo'][$indice];
                $txtLicenciaUrbanismoHijo = $_POST['txtLicenciaUrbanismoHijo'][$indice];
                $fchLicenciaUrbanismo1Hijo = $_POST['fchLicenciaUrbanismo1Hijo'][$indice];
                $fchVigenciaLicenciaUrbanismoHijo = $_POST['fchVigenciaLicenciaUrbanismoHijo'][$indice];
                $txtExpideLicenciaUrbanismoHijo = $_POST['txtExpideLicenciaUrbanismoHijo'][$indice];
                $txtLicenciaConstruccionHijo = $_POST['txtLicenciaConstruccionHijo'][$indice];
                $fchLicenciaConstruccion1Hijo = $_POST['fchLicenciaConstruccion1Hijo'][$indice];
                $fchVigenciaLicenciaConstruccionHijo = $_POST['fchVigenciaLicenciaConstruccionHijo'][$indice];
                $txtNombreVendedorHijo = $_POST['txtNombreVendedorHijo'][$indice];
                $numNitVendedorHijo = $_POST['numNitVendedorHijo'][$indice];
                $txtCedulaCatastralHijo = $_POST['txtCedulaCatastralHijo'][$indice];
                $txtEscrituraHijo = $_POST['txtEscrituraHijo'][$indice];
                $fchEscrituraHijo = $_POST['fchEscrituraHijo'][$indice];
                $numNotariaHijo = $_POST['numNotariaHijo'][$indice];
                if ($seqProyectoHijo != '') {
                    $arrArregloPost[] = $seqProyectoHijo;
                }
                // Realiza las respectiva gestión sobre los datos
                if ($seqProyectoHijo) {
                    $query = "UPDATE T_PRY_PROYECTO 
							SET txtNombreProyecto = '$txtNombreProyectoHijo',
								txtNombreComercial = '$txtNombreComercialHijo',
								seqProyectoPadre = '$seqProyectoPadre',
								txtDireccion = '$txtDireccionHijo',
								valNumeroSoluciones = '$valNumeroSolucionesHijo',
								txtChipLote = '$txtChipLoteHijo',
								txtMatriculaInmobiliariaLote = '$txtMatriculaInmobiliariaLoteHijo',
								txtLicenciaUrbanismo = '$txtLicenciaUrbanismoHijo',
								fchLicenciaUrbanismo1 = '$fchLicenciaUrbanismo1Hijo',
								fchVigenciaLicenciaUrbanismo = '$fchVigenciaLicenciaUrbanismoHijo',
								txtExpideLicenciaUrbanismo = '$txtExpideLicenciaUrbanismoHijo',
								txtLicenciaConstruccion = '$txtLicenciaConstruccionHijo',
								fchLicenciaConstruccion1 = '$fchLicenciaConstruccion1Hijo',
								fchVigenciaLicenciaConstruccion = '$fchVigenciaLicenciaConstruccionHijo',
								txtNombreVendedor = '$txtNombreVendedorHijo',
								numNitVendedor = '$numNitVendedorHijo',
								txtCedulaCatastral = '$txtCedulaCatastralHijo',
								txtEscritura = '$txtEscrituraHijo',
								fchEscritura = '$fchEscrituraHijo',
								numNotaria = '$numNotariaHijo',
								seqTutorProyecto = '$seqTutorProyecto', 
								fchUltimaActualizacion = '$fchGestion', 
								seqUsuario = '$seqUsuario' 
							WHERE seqProyecto = $seqProyectoHijo;";
                } else {
                    $query = "INSERT INTO T_PRY_PROYECTO (
									txtNombreProyecto,
									txtNombreComercial,
									seqProyectoPadre,
									txtDireccion,
									valNumeroSoluciones,
									txtMatriculaInmobiliariaLote,
									txtChipLote,
									txtLicenciaUrbanismo,
									fchLicenciaUrbanismo1,
									fchVigenciaLicenciaUrbanismo,
									txtExpideLicenciaUrbanismo,
									txtLicenciaConstruccion,
									fchLicenciaConstruccion1,
									fchVigenciaLicenciaConstruccion,
									txtNombreVendedor,
									numNitVendedor,
									txtCedulaCatastral,
									txtEscritura,
									fchEscritura,
									numNotaria,
									seqTutorProyecto,
									seqPryEstadoProceso,
									fchInscripcion,
									fchUltimaActualizacion,
									seqUsuario) 
							VALUES ('$txtNombreProyectoHijo', 
									'$txtNombreComercialHijo',
									'$seqProyectoPadre',
									'$txtDireccionHijo',
									'$valNumeroSolucionesHijo',
									'$txtMatriculaInmobiliariaLoteHijo',
									'$txtChipLoteHijo',
									'$txtLicenciaUrbanismoHijo',
									'$fchLicenciaUrbanismo1Hijo',
									'$fchVigenciaLicenciaUrbanismoHijo',
									'$txtExpideLicenciaUrbanismoHijo',
									'$txtLicenciaConstruccionHijo',
									'$fchLicenciaConstruccion1Hijo',
									'$fchVigenciaLicenciaConstruccionHijo',
									'$txtNombreVendedorHijo',
									'$numNitVendedorHijo',
									'$txtCedulaCatastralHijo',
									'$txtEscrituraHijo',
									'$fchEscrituraHijo',
									'$numNotariaHijo',
									'$seqTutorProyecto',
									'2',
									'$fchGestion',
									'$fchGestion',
									'$seqUsuario');";
                }
                //echo $query . "<br>";
                mysql_query($query);
            }
        }

        // Verifica cuales Proyectos se pueden eliminar despues de cruzar los existentes contra los que llegan por POST
        $arrConjuntosResidencialesBorrar = array_diff($arrConjuntoResidencialExistentes, $arrArregloPost);
        foreach ($arrConjuntosResidencialesBorrar as $restante) {
            $sqlVerificaRelacion = mysql_query("SELECT * FROM T_FRM_FORMULARIO WHERE seqProyectoHijo = $restante");
            $cuantos = mysql_num_rows($sqlVerificaRelacion);
            if ($cuantos > 0) {
                echo "No se ha podido borrar el conjunto residencial ya que tiene hogares vinculados";
            } else {
                $query = "DELETE FROM T_PRY_PROYECTO WHERE seqProyecto = $restante;";
                mysql_query($query);
            }
        }
        //return $arrErrores;
    }

    // FIN GESTIONA CONJUNTOS RESIDENCIALES DE UN PROYECTO
    ///////////////////////////////////////// INICIO GESTIONA RESOLUCIONES DE UN PROYECTO ///////////////////////////////////////////////////////
    public function ingresarResolucionesProyecto($seqProyecto, $arrDatosProyecto) { // Inicio editar Resolucion Proyecto
        global $aptBd;
        $arrErrores = array();

        // Resoluciones existentes asignados al proyecto
        $arrExistentes = array();
        $sqlExistentes = "SELECT seqResolucionProyecto FROM T_PRY_RESOLUCION_PROYECTO WHERE seqProyecto = $seqProyecto";
        $exeExistentes = mysql_query($sqlExistentes);
        while ($rowExistentes = mysql_fetch_array($exeExistentes)) {
            $arrExistentes[] = $rowExistentes['seqResolucionProyecto'];
        }
        // Campos a registrar en las consultas
        $fchGestion = date("Y-m-d H:i:s");
        $arrArregloPost = array();

        // Recorre el arreglo que viene del formulario
        if (!empty($arrDatosProyecto)) {
            foreach ($arrDatosProyecto as $indice => $seqResolucionProyecto) {
                $seqResolucionProyecto = $_POST['seqResolucionProyecto'][$indice];
                $numResolucionProyecto = $_POST['numResolucionProyecto'][$indice];
                $fchResolucionProyecto = $_POST['fchResolucionProyecto'][$indice];
                $txtResuelve = $_POST['txtResuelve'][$indice];
                if ($seqResolucionProyecto != '') {
                    $arrArregloPost[] = $seqResolucionProyecto;
                }
                // Realiza las respectiva gestión sobre los datos
                if ($seqResolucionProyecto) {
                    $query = "UPDATE T_PRY_RESOLUCION_PROYECTO SET numResolucionProyecto = '$numResolucionProyecto', fchResolucionProyecto = '$fchResolucionProyecto', txtResuelve = '$txtResuelve', fchGestion = '$fchGestion' WHERE seqResolucionProyecto = $seqResolucionProyecto AND seqProyecto = $seqProyecto; ";
                } else {
                    $query = "INSERT INTO T_PRY_RESOLUCION_PROYECTO (seqProyecto, numResolucionProyecto, fchResolucionProyecto, txtResuelve, fchGestion) VALUES ('$seqProyecto', '$numResolucionProyecto', '$fchResolucionProyecto', '$txtResuelve', '$fchGestion');";
                }
                mysql_query($query);
            }
        }

        // Verifica cuales Resoluciones se pueden eliminar despues de cruzar los existentes contra los que llegan por POST
        $arrRegistrosBorrar = array_diff($arrExistentes, $arrArregloPost);
        foreach ($arrRegistrosBorrar as $restante) {
            $query = "DELETE FROM T_PRY_RESOLUCION_PROYECTO WHERE seqResolucionProyecto = $restante;";
            mysql_query($query);
        }
    }

    // FIN GESTIONA RESOLUCIONES DE UN PROYECTO
    /////////////////////////////////////////////// INICIO GESTIONA ACTAS DE UN PROYECTO ///////////////////////////////////////////////////////
    public function ingresarActasProyecto($seqProyecto, $arrDatosProyecto) { // Inicio editar Actas Proyecto
        global $aptBd;
        $arrErrores = array();

        // Actas existentes asignados al proyecto
        $arrExistentes = array();
        $sqlExistentes = "SELECT seqActaProyecto FROM T_PRY_ACTA_PROYECTO WHERE seqProyecto = $seqProyecto";
        $exeExistentes = mysql_query($sqlExistentes);
        while ($rowExistentes = mysql_fetch_array($exeExistentes)) {
            $arrExistentes[] = $rowExistentes['seqActaProyecto'];
        }
        // Campos a registrar en las consultas
        $fchGestion = date("Y-m-d H:i:s");
        $arrArregloPost = array();

        // Recorre el arreglo que viene del formulario
        if (!empty($arrDatosProyecto)) {
            foreach ($arrDatosProyecto as $indice => $seqActaProyecto) {
                $seqActaProyecto = $_POST['seqActaProyecto'][$indice];
                $numActaProyecto = $_POST['numActaProyecto'][$indice];
                $fchActaProyecto = $_POST['fchActaProyecto'][$indice];
                $txtEpigrafe = $_POST['txtEpigrafe'][$indice];
                if ($seqActaProyecto != '') {
                    $arrArregloPost[] = $seqActaProyecto;
                }
                // Realiza las respectiva gestión sobre los datos
                if ($seqActaProyecto) {
                    $query = "UPDATE T_PRY_ACTA_PROYECTO SET numActaProyecto = '$numActaProyecto', fchActaProyecto = '$fchActaProyecto', txtEpigrafe = '$txtEpigrafe', fchGestion = '$fchGestion' WHERE seqActaProyecto = $seqActaProyecto AND seqProyecto = $seqProyecto; ";
                } else {
                    $query = "INSERT INTO T_PRY_ACTA_PROYECTO (seqProyecto, numActaProyecto, fchActaProyecto, txtEpigrafe, fchGestion) VALUES ('$seqProyecto', '$numActaProyecto', '$fchActaProyecto', '$txtEpigrafe', '$fchGestion');";
                }
                mysql_query($query);
            }
        }

        // Verifica cuales Actas se pueden eliminar despues de cruzar los existentes contra los que llegan por POST
        $arrRegistrosBorrar = array_diff($arrExistentes, $arrArregloPost);
        foreach ($arrRegistrosBorrar as $restante) {
            $query = "DELETE FROM T_PRY_ACTA_PROYECTO WHERE seqActaProyecto = $restante;";
            mysql_query($query);
        }
    }

    // FIN GESTIONA ACTAS DE UN PROYECTO
    ///////////////////////////////////// INICIO GESTIONA TIPOS DE VIVIENDA DE UN PROYECTO ///////////////////////////////////////////////////////
    public function ingresarTipoVivienda($seqProyecto, $arrDatosProyecto) { // Inicio editar Tipo Vivienda
        global $aptBd;
        $arrErrores = array();

        // Tipos de Vivienda existentes asignados al proyecto
        $arrExistentes = array();
        $sqlExistentes = "SELECT seqTipoVivienda FROM T_PRY_TIPO_VIVIENDA WHERE seqProyecto = $seqProyecto";
        $exeExistentes = mysql_query($sqlExistentes);
        while ($rowExistentes = mysql_fetch_array($exeExistentes)) {
            $arrExistentes[] = $rowExistentes['seqTipoVivienda'];
        }
        // Campos a registrar en las consultas
        $fchGestion = date("Y-m-d H:i:s");
        $arrArregloPost = array();

        // Recorre el arreglo que viene del formulario
        if (!empty($arrDatosProyecto)) {
            foreach ($arrDatosProyecto as $indice => $seqTipoVivienda) {
                $seqTipoVivienda = $_POST['seqTipoVivienda'][$indice];
                $txtNombreTipoVivienda = $_POST['txtNombreTipoVivienda'][$indice];
                $numCantidad = $_POST['numCantidad'][$indice];
                $numArea = $_POST['numArea'][$indice];
                $numAnoVenta = $_POST['numAnoVenta'][$indice];
                $valPrecioVenta = $_POST['valPrecioVenta'][$indice];
                $txtDescripcion = $_POST['txtDescripcion'][$indice];
                $valCierre = $_POST['valCierre'][$indice];
                if ($seqTipoVivienda != '') {
                    $arrArregloPost[] = $seqTipoVivienda;
                }
                // Realiza las respectiva gestión sobre los datos
                if ($seqTipoVivienda) {
                    $query = "UPDATE T_PRY_TIPO_VIVIENDA SET txtNombreTipoVivienda = '$txtNombreTipoVivienda', numCantidad = '$numCantidad', numArea = '$numArea', numAnoVenta = '$numAnoVenta', valPrecioVenta = '$valPrecioVenta', txtDescripcion = '$txtDescripcion', valCierre = '$valCierre', fchGestion = '$fchGestion' WHERE seqTipoVivienda = $seqTipoVivienda AND seqProyecto = $seqProyecto; ";
                } else {
                    $query = "INSERT INTO T_PRY_TIPO_VIVIENDA (seqProyecto, txtNombreTipoVivienda, numCantidad, numArea, numAnoVenta, valPrecioVenta, txtDescripcion, valCierre, fchGestion) VALUES ('$seqProyecto', '$txtNombreTipoVivienda', '$numCantidad', '$numArea', '$numAnoVenta', '$valPrecioVenta', '$txtDescripcion', '$valCierre', '$fchGestion');";
                }
                mysql_query($query);
            }
        }

        // Verifica cuales Tipos de Vivienda se pueden eliminar despues de cruzar los existentes contra los que llegan por POST
        $arrRegistrosBorrar = array_diff($arrExistentes, $arrArregloPost);
        foreach ($arrRegistrosBorrar as $restante) {
            $query = "DELETE FROM T_PRY_TIPO_VIVIENDA WHERE seqTipoVivienda = $restante;";
            mysql_query($query);
        }
    }

    // FIN GESTIONA TIPOS DE VIVIENDA DE UN PROYECTO
    ////////////////////////////////////////// INICIO GESTIONA CRONOGRAMA DE FECHAS DE UN PROYECTO ////////////////////////////////////////////////
    public function ingresarCronogramaFecha($seqProyecto, $arrDatosProyecto) { // Inicio editar Cronograma Fecha
        global $aptBd;
        $arrErrores = array();

        // Cronograma de fechas existentes asignados al proyecto
        $arrExistentes = array();
        $sqlExistentes = "SELECT seqCronogramaFecha FROM T_PRY_CRONOGRAMA_FECHAS WHERE seqProyecto = $seqProyecto";
        $exeExistentes = mysql_query($sqlExistentes);
        while ($rowExistentes = mysql_fetch_array($exeExistentes)) {
            $arrExistentes[] = $rowExistentes['seqCronogramaFecha'];
        }
        // Campos a registrar en las consultas
        $fchGestion = date("Y-m-d H:i:s");
        $arrArregloPost = array();

        // Recorre el arreglo que viene del formulario
        if (!empty($arrDatosProyecto)) {
            foreach ($arrDatosProyecto as $indice => $seqCronogramaFecha) {
                $seqCronogramaFecha = $_POST['seqCronogramaFecha'][$indice];
                $numActaDescriptiva = $_POST['numActaDescriptiva'][$indice];
                $numAnoActaDescriptiva = $_POST['numAnoActaDescriptiva'][$indice];
                $fchInicialProyecto = $_POST['fchInicialProyecto'][$indice];
                $fchFinalProyecto = $_POST['fchFinalProyecto'][$indice];
                $valPlazoEjecucion = $_POST['valPlazoEjecucion'][$indice];
                $fchInicialEntrega = $_POST['fchInicialEntrega'][$indice];
                $fchFinalEntrega = $_POST['fchFinalEntrega'][$indice];
                $fchInicialEscrituracion = $_POST['fchInicialEscrituracion'][$indice];
                $fchFinalEscrituracion = $_POST['fchFinalEscrituracion'][$indice];
                if ($seqCronogramaFecha != '') {
                    $arrArregloPost[] = $seqCronogramaFecha;
                }
                // Realiza las respectiva gestión sobre los datos
                if ($seqCronogramaFecha) {
                    $query = "UPDATE T_PRY_CRONOGRAMA_FECHAS SET numActaDescriptiva = '$numActaDescriptiva', numAnoActaDescriptiva = '$numAnoActaDescriptiva', fchInicialProyecto = '$fchInicialProyecto', fchFinalProyecto = '$fchFinalProyecto', valPlazoEjecucion = '$valPlazoEjecucion', fchInicialEntrega = '$fchInicialEntrega', fchFinalEntrega = '$fchFinalEntrega', fchInicialEscrituracion = '$fchInicialEscrituracion', fchFinalEscrituracion = '$fchFinalEscrituracion', fchGestion = '$fchGestion' WHERE seqCronogramaFecha = $seqCronogramaFecha AND seqProyecto = $seqProyecto; ";
                } else {
                    $query = "INSERT INTO T_PRY_CRONOGRAMA_FECHAS (seqProyecto, numActaDescriptiva, numAnoActaDescriptiva, fchInicialProyecto, fchFinalProyecto, valPlazoEjecucion, fchInicialEntrega, fchFinalEntrega, fchInicialEscrituracion, fchFinalEscrituracion, fchGestion) VALUES ('$seqProyecto', '$numActaDescriptiva', '$numAnoActaDescriptiva', '$fchInicialProyecto', '$fchFinalProyecto', '$valPlazoEjecucion', '$fchInicialEntrega', '$fchFinalEntrega', '$fchInicialEscrituracion', '$fchFinalEscrituracion', '$fchGestion');";
                }
                //echo $query;
                mysql_query($query);
            }
        }

        // Verifica cuales Cronograma de fechas se pueden eliminar despues de cruzar los existentes contra los que llegan por POST
        $arrRegistrosBorrar = array_diff($arrExistentes, $arrArregloPost);
        foreach ($arrRegistrosBorrar as $restante) {
            $query = "DELETE FROM T_PRY_CRONOGRAMA_FECHAS WHERE seqCronogramaFecha = $restante;";
            //echo $query;
            mysql_query($query);
        }
    }

    // FIN GESTIONA CRONOGRAMA DE FECHAS DE UN PROYECTO
    ////////////////////////////////////////// INICIO GESTIONA DESEMBOLSO ////////////////////////////////////////////////
    public function ingresarGiroDesembolsos($seqProyecto, $arrDatosProyecto) { // Inicio editar Giro Desembolsos
        global $aptBd;
        $arrErrores = array();

        // Cronograma de fechas existentes asignados al proyecto
        $arrExistentes = array();
        $sqlExistentes = "SELECT seqDesembolsoProyecto FROM T_PRY_DESEMBOLSO_PROYECTO WHERE seqProyecto = $seqProyecto";
        $exeExistentes = mysql_query($sqlExistentes);
        while ($rowExistentes = mysql_fetch_array($exeExistentes)) {
            $arrExistentes[] = $rowExistentes['seqDesembolsoProyecto'];
        }

        // Campos a registrar en las consultas
        $fchGestion = date("Y-m-d H:i:s");
        $arrArregloPost = array();

        // Recorre el arreglo que viene del formulario
        if (!empty($arrDatosProyecto)) {
            foreach ($arrDatosProyecto as $indice => $seqDesembolsoProyecto) {
                $seqDesembolsoProyecto = $_POST['seqDesembolsoProyecto'][$indice];
                $txtNombreVendedor = $_POST['txtNombreVendedor'][$indice];
                $numNitVendedor = $_POST['numNitVendedor'][$indice];
                $numTelefonoVendedor = $_POST['numTelefonoVendedor'][$indice];
                $txtCorreoVendedor = $_POST['txtCorreoVendedor'][$indice];
                $txtNombreBeneficiarioGiro = $_POST['txtNombreBeneficiarioGiro'][$indice];
                $numNitBeneficiarioGiro = $_POST['numNitBeneficiarioGiro'][$indice];
                $valDesembolso = $_POST['valDesembolso'][$indice];
                $seqTipoModalidadDesembolso = $_POST['seqTipoModalidadDesembolso'][$indice];
                //$seqFiduciaria				= $_POST['seqFiduciaria'][$indice];
                $numContratoSuscrito = $_POST['numContratoSuscrito'][$indice];
                $fchContratoSuscrito = $_POST['fchContratoSuscrito'][$indice];
                $txtNombreEntidadFinanciera = $_POST['txtNombreEntidadFinanciera'][$indice];
                $numNitEntidadFinanciera = $_POST['numNitEntidadFinanciera'][$indice];
                $numCuenta = $_POST['numCuenta'][$indice];
                $seqTipoCuenta = $_POST['seqTipoCuenta'][$indice];
                $seqBancoCuenta = $_POST['seqBancoCuenta'][$indice];
                $valTotalGiroAnticipado = $_POST['valTotalGiroAnticipado'][$indice];
                $valSaldoGiro = $_POST['valSaldoGiro'][$indice];
                $valNumeroPago = $_POST['valNumeroPago'][$indice];
                $txtObservacion = $_POST['txtObservacion'][$indice];
                if ($seqDesembolsoProyecto != '') {
                    $arrArregloPost[] = $seqDesembolsoProyecto;
                }
                // Realiza las respectiva gestión sobre los datos
                if ($seqDesembolsoProyecto) {
                    $query = "UPDATE T_PRY_DESEMBOLSO_PROYECTO SET txtNombreVendedor = '$txtNombreVendedor', numNitVendedor = '$numNitVendedor', numTelefonoVendedor = '$numTelefonoVendedor', txtCorreoVendedor = '$txtCorreoVendedor', txtNombreBeneficiarioGiro = '$txtNombreBeneficiarioGiro', numNitBeneficiarioGiro = '$numNitBeneficiarioGiro', valDesembolso = '$valDesembolso', seqTipoModalidadDesembolso = '$seqTipoModalidadDesembolso', numContratoSuscrito = '$numContratoSuscrito', fchContratoSuscrito = '$fchContratoSuscrito', txtNombreEntidadFinanciera = '$txtNombreEntidadFinanciera', numNitEntidadFinanciera = '$numNitEntidadFinanciera', numCuenta = '$numCuenta', seqTipoCuenta = '$seqTipoCuenta', seqBancoCuenta = '$seqBancoCuenta', valTotalGiroAnticipado = '$valTotalGiroAnticipado', valSaldoGiro = '$valSaldoGiro', valNumeroPago = '$valNumeroPago', txtObservacion = '$txtObservacion', fchGestion = '$fchGestion' WHERE seqDesembolsoProyecto = $seqDesembolsoProyecto AND seqProyecto = $seqProyecto; ";
                    //echo "<br>".$query;
                } else {
                    $query = "INSERT INTO T_PRY_DESEMBOLSO_PROYECTO (seqProyecto, txtNombreVendedor, numNitVendedor, numTelefonoVendedor, txtCorreoVendedor, txtNombreBeneficiarioGiro, numNitBeneficiarioGiro, valDesembolso, seqTipoModalidadDesembolso, numContratoSuscrito, fchContratoSuscrito, txtNombreEntidadFinanciera, numNitEntidadFinanciera, numCuenta, seqTipoCuenta, seqBancoCuenta, valTotalGiroAnticipado, valSaldoGiro, valNumeroPago, txtObservacion, fchGestion) VALUES ('$seqProyecto', '$txtNombreVendedor', '$numNitVendedor', '$numTelefonoVendedor', '$txtCorreoVendedor', '$txtNombreBeneficiarioGiro', '$numNitBeneficiarioGiro', '$valDesembolso', '$seqTipoModalidadDesembolso', '$numContratoSuscrito', '$fchContratoSuscrito', '$txtNombreEntidadFinanciera', '$numNitEntidadFinanciera', '$numCuenta', '$seqTipoCuenta', '$seqBancoCuenta', '$valTotalGiroAnticipado', '$valSaldoGiro', '$valNumeroPago', '$txtObservacion', '$fchGestion');";
                    //echo "<br>".$query;
                }
                mysql_query($query);
            }
        }

        // Verifica cuales Cronograma de fechas se pueden eliminar despues de cruzar los existentes contra los que llegan por POST
        $arrRegistrosBorrar = array_diff($arrExistentes, $arrArregloPost);
        foreach ($arrRegistrosBorrar as $restante) {
            $query = "DELETE FROM T_PRY_DESEMBOLSO_PROYECTO WHERE seqDesembolsoProyecto = $restante;";
            //echo $query;
            mysql_query($query);
        }
    }

    // FIN GESTIONA DESEMBOLSO

    public function ingresarActividadCronograma($seqProyecto, $arrDatosProyecto) { // Inicio editar Actividades Cronograma de Obra
        global $aptBd;
        $arrErrores = array();

        // Proyectos existentes para el proyecto actual
        $sqlExistentes = mysql_query("SELECT seqActividadCronograma, txtNombreActividad, fchInicialActividad, fchFinalActividad, txtDescripcionActividad, txtResponsableActividad FROM T_PRY_ACTIVIDAD_CRONOGRAMA WHERE seqProyecto = $seqProyecto");
        $arrActividadesExistentes = array();
        while ($rowVerifica = mysql_fetch_array($sqlExistentes)) {
            $arrActividadesExistentes[] = $rowVerifica['seqActividadCronograma'];
        }

        // Verifica si existe la actividad en el proyecto
        $fchGestion = date("Y-m-d H:i:s");
        if (!empty($arrDatosProyecto)) {
            foreach ($arrDatosProyecto as $indice => $seqActividadCronograma) {
                $seqActividadCronograma = $_POST['seqActividadCronograma'][$indice];
                $txtNombreActividad = $_POST['txtNombreActividad'][$indice];
                $fchInicialActividad = $_POST['fchInicialActividad'][$indice];
                $fchFinalActividad = $_POST['fchFinalActividad'][$indice];
                $txtDescripcionActividad = $_POST['txtDescripcionActividad'][$indice];
                $txtResponsableActividad = $_POST['txtResponsableActividad'][$indice];
                $flagInsertaActividad = 0;
                $flagActualizaActividad = 0;
                foreach ($arrActividadesExistentes as $actividad) {
                    if ($seqActividadCronograma == $actividad) {
                        $flagActualizaActividad ++;
                    } else if ($actividad == "") {
                        $flagInsertaActividad ++;
                    }
                }
                // EJECUTA LA RESPECTIVA CLAUSULA (ACTUALIZA O INSERTA)
                if ($flagActualizaActividad == 0) { // INSERTA LOS REGISTROS NUEVOS
                    $query = "INSERT INTO T_PRY_ACTIVIDAD_CRONOGRAMA 
								(seqProyecto, txtNombreActividad, fchInicialActividad, fchFinalActividad, txtDescripcionActividad, txtResponsableActividad, fchGestion) 
							VALUES 
								('$seqProyecto', '$txtNombreActividad', '$fchInicialActividad', '$fchFinalActividad', '$txtDescripcionActividad', '$txtResponsableActividad', '$fchGestion');";
                } else { // ACTUALIZA LOS REGISTROS EXISTENTES
                    $query = "UPDATE
								T_PRY_ACTIVIDAD_CRONOGRAMA 
							SET
								txtNombreActividad = '$txtNombreActividad', 
								fchInicialActividad = '$fchInicialActividad',
								fchFinalActividad = '$fchFinalActividad',
								txtDescripcionActividad = '$txtDescripcionActividad',
								txtResponsableActividad = '$txtResponsableActividad',
								fchGestion = '$fchGestion' 
							WHERE
								seqActividadCronograma = $seqActividadCronograma
							AND
								seqProyecto = $seqProyecto; ";
                }
                mysql_query($query);
            }
        }

        // CONSULTA LOS REGISTROS QUE SE GESTIONARON EN LA ULTIMA ACTUALIZACION
        $sqlActualizados = mysql_query("SELECT 
											seqActividadCronograma
										FROM 
											T_PRY_ACTIVIDAD_CRONOGRAMA 
										WHERE 
											seqProyecto = $seqProyecto
										AND 
											fchGestion = (SELECT MAX(fchGestion)
															FROM T_PRY_ACTIVIDAD_CRONOGRAMA
															WHERE seqProyecto = $seqProyecto)");
        $arrActividadesActualizadas = array();
        while ($rowVerificaActualizados = mysql_fetch_array($sqlActualizados)) {
            $arrActividadesActualizadas[] = $rowVerificaActualizados['seqActividadCronograma'];
        }
        // Arreglo con los registros que se pueden eliminar
        $arrActividadesRestantes = array_diff($arrActividadesExistentes, $arrActividadesActualizadas);
        foreach ($arrActividadesRestantes as $restante) { // BORRA LOS REGISTROS QUE NO ESTÉN EN EL FORMULARIO
            $queryDel = "DELETE FROM 
							T_PRY_ACTIVIDAD_CRONOGRAMA 
						WHERE 
							seqActividadCronograma = $restante 
						AND 
							seqProyecto = $seqProyecto;";
            mysql_query($queryDel);
        }
        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $arrProyectoVivienda = $this->cargarProyectoVivienda($seqProyecto);
            $arrErrores[] = "No se ha podido editar el Proyecto <b>" . $arrProyectoVivienda[$seqProyecto]->txtNombreProyecto . "</b>. Reporte este error al administrador del sistema";
        }
        return $arrErrores;
    }

    public function ingresarSeguimientoActividad($seqProyecto, $arrDatosSeguimiento) { // Inicio Seguimiento a Actividades del Cronograma
        global $aptBd;
        $arrErrores = array();
        // Proyectos existentes para el proyecto actual
        $sqlExistentes = mysql_query("SELECT seqActividadCronograma, txtNombreActividad, fchInicialActividad, fchFinalActividad, txtDescripcionActividad, txtResponsableActividad FROM T_PRY_ACTIVIDAD_CRONOGRAMA WHERE seqProyecto = $seqProyecto");
        $arrActividadesExistentes = array();
        while ($rowVerifica = mysql_fetch_array($sqlExistentes)) {
            $arrActividadesExistentes[] = $rowVerifica['seqActividadCronograma'];
        }
        // Verifica si existe la actividad en el proyecto
        $seqUsuario = $_SESSION['seqUsuario'];
        $fchSeguimiento = date("Y-m-d H:i:s");

        if (!empty($arrDatosSeguimiento)) {
            foreach ($arrDatosSeguimiento as $indice => $seqSeguimientoActividad) {
                $seqActividadCronograma = $_POST['seqActividadCronograma'][$indice];
                $txtDescripcionSeguimiento = $_POST['txtDescripcionSeguimiento'][$indice];
                $seqEstadoActividad = $_POST['seqEstadoActividad'][$indice];
                $flagInsertaSeguimiento = 0;
                foreach ($arrActividadesExistentes as $actividad) {
                    if ($seqActividadCronograma == $actividad) {
                        $flagInsertaSeguimiento ++;
                    }
                }
                // EJECUTA LA RESPECTIVA CLAUSULA (INSERTA)
                if ($flagInsertaSeguimiento == 1) { // INSERTA LOS REGISTROS NUEVOS
                    $query = "INSERT INTO T_PRY_SEGUIMIENTO_ACTIVIDAD
									(seqProyecto, seqActividadCronograma, txtDescripcionSeguimiento, seqEstadoActividad, fchSeguimientoActividad, seqUsuario) 
								VALUES 
									('$seqProyecto', '$seqActividadCronograma', '$txtDescripcionSeguimiento', '$seqEstadoActividad', '$fchSeguimiento', '$seqUsuario');";
                }
                mysql_query($query);
            }
        }
    }

    // EDITAR ESTUDIO TECNICO UNIDADES
    public function editarEstudioTecnicoUnidades($seqUnidadProyecto, $numLargoMultiple, $numAnchoMultiple, $numAreaMultiple, $txtMultiple, $numLargoAlcoba1, $numAnchoAlcoba1, $numAreaAlcoba1, $txtAlcoba1, $numLargoAlcoba2, $numAnchoAlcoba2, $numAreaAlcoba2, $txtAlcoba2, $numLargoAlcoba3, $numAnchoAlcoba3, $numAreaAlcoba3, $txtAlcoba3, $numLargoCocina, $numAnchoCocina, $numAreaCocina, $txtCocina, $numLargoBano1, $numAnchoBano1, $numAreaBano1, $txtBano1, $numLargoBano2, $numAnchoBano2, $numAreaBano2, $txtBano2, $numLargoLavanderia, $numAnchoLavanderia, $numAreaLavanderia, $txtLavanderia, $numLargoCirculaciones, $numAnchoCirculaciones, $numAreaCirculaciones, $txtCirculaciones, $numLargoPatio, $numAnchoPatio, $numAreaPatio, $txtPatio, $numAreaTotal, $txtEstadoCimentacion, $txtCimentacion, $txtEstadoPlacaEntrepiso, $txtPlacaEntrepiso, $txtEstadoMamposteria, $txtMamposteria, $txtEstadoCubierta, $txtCubierta, $txtEstadoVigas, $txtVigas, $txtEstadoColumnas, $txtColumnas, $txtEstadoPanetes, $txtPanetes, $txtEstadoEnchapes, $txtEnchapes, $txtEstadoAcabados, $txtAcabados, $txtEstadoHidraulicas, $txtHidraulicas, $txtEstadoElectricas, $txtElectricas, $txtEstadoSanitarias, $txtSanitarias, $txtEstadoGas, $txtGas, $txtEstadoMadera, $txtMadera, $txtEstadoMetalica, $txtMetalica, $numLavadero, $txtLavadero, $numLavaplatos, $txtLavaplatos, $numLavamanos, $txtLavamanos, $numSanitario, $txtSanitario, $numDucha, $txtDucha, $txtEstadoVidrios, $txtVidrios, $txtEstadoPintura, $txtPintura, $txtOtros, $txtObservacionOtros, $numContadorAgua, $txtEstadoConexionAgua, $txtDescripcionAgua, $numContadorEnergia, $txtEstadoConexionEnergia, $txtDescripcionEnergia, $numContadorAlcantarillado, $txtEstadoConexionAlcantarillado, $txtDescripcionAlcantarillado, $numContadorGas, $txtEstadoConexionGas, $txtDescripcionGas, $numContadorTelefono, $txtEstadoConexionTelefono, $txtDescripcionTelefono, $txtEstadoAndenes, $txtDescripcionAndenes, $txtEstadoVias, $txtDescripcionVias, $txtEstadoServiciosComunales, $txtDescripcionServiciosComunales, $txtDescripcionVivienda, $txtNormaNSR98, $txtRequisitos, $txtExistencia, $txtDescipcionNormaNSR98, $txtDescripcionRequisitos, $txtDescripcionExistencia, $fchVisita, $txtAprobo, $fchCreacion, $fchActualizacion) {

        global $aptBd;
        $arrErrores = array();

        //Consulta si existe la unidad en la tabla de Estudios Técnicos de Unidades
        $sqlExiste = mysql_query("SELECT * FROM T_PRY_TECNICO WHERE seqUnidadProyecto = $seqUnidadProyecto");
        $existe = mysql_num_rows($sqlExiste);

        if ($existe == 0) { // Si no existe se ingresa el estudio técnico de la unidad
            $sql = "INSERT INTO T_PRY_TECNICO (
						seqUnidadProyecto, 
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
						fchActualizacion
					) VALUES (
						'$seqUnidadProyecto', 
						'$numLargoMultiple', 
						'$numAnchoMultiple', 
						'$numAreaMultiple', 
						'$txtMultiple', 
						'$numLargoAlcoba1', 
						'$numAnchoAlcoba1', 
						'$numAreaAlcoba1', 
						'$txtAlcoba1', 
						'$numLargoAlcoba2', 
						'$numAnchoAlcoba2', 
						'$numAreaAlcoba2', 
						'$txtAlcoba2', 
						'$numLargoAlcoba3', 
						'$numAnchoAlcoba3', 
						'$numAreaAlcoba3', 
						'$txtAlcoba3', 
						'$numLargoCocina', 
						'$numAnchoCocina', 
						'$numAreaCocina', 
						'$txtCocina', 
						'$numLargoBano1', 
						'$numAnchoBano1', 
						'$numAreaBano1', 
						'$txtBano1', 
						'$numLargoBano2', 
						'$numAnchoBano2', 
						'$numAreaBano2', 
						'$txtBano2', 
						'$numLargoLavanderia', 
						'$numAnchoLavanderia', 
						'$numAreaLavanderia', 
						'$txtLavanderia', 
						'$numLargoCirculaciones', 
						'$numAnchoCirculaciones', 
						'$numAreaCirculaciones', 
						'$txtCirculaciones', 
						'$numLargoPatio', 
						'$numAnchoPatio', 
						'$numAreaPatio', 
						'$txtPatio', 
						'$numAreaTotal', 
						'$txtEstadoCimentacion', 
						'$txtCimentacion', 
						'$txtEstadoPlacaEntrepiso', 
						'$txtPlacaEntrepiso', 
						'$txtEstadoMamposteria', 
						'$txtMamposteria', 
						'$txtEstadoCubierta', 
						'$txtCubierta', 
						'$txtEstadoVigas', 
						'$txtVigas', 
						'$txtEstadoColumnas', 
						'$txtColumnas', 
						'$txtEstadoPanetes', 
						'$txtPanetes', 
						'$txtEstadoEnchapes', 
						'$txtEnchapes', 
						'$txtEstadoAcabados', 
						'$txtAcabados', 
						'$txtEstadoHidraulicas', 
						'$txtHidraulicas', 
						'$txtEstadoElectricas', 
						'$txtElectricas', 
						'$txtEstadoSanitarias', 
						'$txtSanitarias', 
						'$txtEstadoGas', 
						'$txtGas', 
						'$txtEstadoMadera', 
						'$txtMadera', 
						'$txtEstadoMetalica', 
						'$txtMetalica', 
						'$numLavadero', 
						'$txtLavadero', 
						'$numLavaplatos', 
						'$txtLavaplatos', 
						'$numLavamanos', 
						'$txtLavamanos', 
						'$numSanitario', 
						'$txtSanitario', 
						'$numDucha', 
						'$txtDucha', 
						'$txtEstadoVidrios', 
						'$txtVidrios', 
						'$txtEstadoPintura', 
						'$txtPintura', 
						'$txtOtros', 
						'$txtObservacionOtros', 
						'$numContadorAgua', 
						'$txtEstadoConexionAgua', 
						'$txtDescripcionAgua', 
						'$numContadorEnergia', 
						'$txtEstadoConexionEnergia', 
						'$txtDescripcionEnergia', 
						'$numContadorAlcantarillado', 
						'$txtEstadoConexionAlcantarillado', 
						'$txtDescripcionAlcantarillado', 
						'$numContadorGas', 
						'$txtEstadoConexionGas', 
						'$txtDescripcionGas', 
						'$numContadorTelefono', 
						'$txtEstadoConexionTelefono', 
						'$txtDescripcionTelefono', 
						'$txtEstadoAndenes', 
						'$txtDescripcionAndenes', 
						'$txtEstadoVias', 
						'$txtDescripcionVias', 
						'$txtEstadoServiciosComunales', 
						'$txtDescripcionServiciosComunales', 
						'$txtDescripcionVivienda', 
						'$txtNormaNSR98', 
						'$txtRequisitos', 
						'$txtExistencia', 
						'$txtDescipcionNormaNSR98', 
						'$txtDescripcionRequisitos', 
						'$txtDescripcionExistencia', 
						'$fchVisita', 
						'$txtAprobo', 
						NOW(), 
						NOW()
			)";
        } else {
            // Si existe se actualiza el estudio técnico de la unidad
            $sql = "UPDATE T_PRY_TECNICO SET
						numLargoMultiple = \"" . $numLargoMultiple . "\",
						numAnchoMultiple = \"" . $numAnchoMultiple . "\",
						numAreaMultiple = \"" . $numAreaMultiple . "\",
						txtMultiple = \"" . $txtMultiple . "\",
						numLargoAlcoba1 = \"" . $numLargoAlcoba1 . "\",
						numAnchoAlcoba1 = \"" . $numAnchoAlcoba1 . "\",
						numAreaAlcoba1 = \"" . $numAreaAlcoba1 . "\",
						txtAlcoba1 = \"" . $txtAlcoba1 . "\",
						numLargoAlcoba2 = \"" . $numLargoAlcoba2 . "\",
						numAnchoAlcoba2 = \"" . $numAnchoAlcoba2 . "\",
						numAreaAlcoba2 = \"" . $numAreaAlcoba2 . "\",
						txtAlcoba2 = \"" . $txtAlcoba2 . "\",
						numLargoAlcoba3 = \"" . $numLargoAlcoba3 . "\",
						numAnchoAlcoba3 = \"" . $numAnchoAlcoba3 . "\",
						numAreaAlcoba3 = \"" . $numAreaAlcoba3 . "\",
						txtAlcoba3 = \"" . $txtAlcoba3 . "\",
						numLargoCocina = \"" . $numLargoCocina . "\",
						numAnchoCocina = \"" . $numAnchoCocina . "\",
						numAreaCocina = \"" . $numAreaCocina . "\",
						txtCocina = \"" . $txtCocina . "\",
						numLargoBano1 = \"" . $numLargoBano1 . "\",
						numAnchoBano1 = \"" . $numAnchoBano1 . "\",
						numAreaBano1 = \"" . $numAreaBano1 . "\",
						txtBano1 = \"" . $txtBano1 . "\",
						numLargoBano2 = \"" . $numLargoBano2 . "\",
						numAnchoBano2 = \"" . $numAnchoBano2 . "\",
						numAreaBano2 = \"" . $numAreaBano2 . "\",
						txtBano2 = \"" . $txtBano2 . "\",
						numLargoLavanderia = \"" . $numLargoLavanderia . "\",
						numAnchoLavanderia = \"" . $numAnchoLavanderia . "\",
						numAreaLavanderia = \"" . $numAreaLavanderia . "\",
						txtLavanderia = \"" . $txtLavanderia . "\",
						numLargoCirculaciones = \"" . $numLargoCirculaciones . "\",
						numAnchoCirculaciones = \"" . $numAnchoCirculaciones . "\",
						numAreaCirculaciones = \"" . $numAreaCirculaciones . "\",
						txtCirculaciones = \"" . $txtCirculaciones . "\",
						numLargoPatio = \"" . $numLargoPatio . "\",
						numAnchoPatio = \"" . $numAnchoPatio . "\",
						numAreaPatio = \"" . $numAreaPatio . "\",
						txtPatio = \"" . $txtPatio . "\",
						numAreaTotal = \"" . $numAreaTotal . "\",
						txtEstadoCimentacion = \"" . $txtEstadoCimentacion . "\",
						txtCimentacion = \"" . $txtCimentacion . "\",
						txtEstadoPlacaEntrepiso = \"" . $txtEstadoPlacaEntrepiso . "\",
						txtPlacaEntrepiso = \"" . $txtPlacaEntrepiso . "\",
						txtEstadoMamposteria = \"" . $txtEstadoMamposteria . "\",
						txtMamposteria = \"" . $txtMamposteria . "\",
						txtEstadoCubierta = \"" . $txtEstadoCubierta . "\",
						txtCubierta = \"" . $txtCubierta . "\",
						txtEstadoVigas = \"" . $txtEstadoVigas . "\",
						txtVigas = \"" . $txtVigas . "\",
						txtEstadoColumnas = \"" . $txtEstadoColumnas . "\",
						txtColumnas = \"" . $txtColumnas . "\",
						txtEstadoPanetes = \"" . $txtEstadoPanetes . "\",
						txtPanetes = \"" . $txtPanetes . "\",
						txtEstadoEnchapes = \"" . $txtEstadoEnchapes . "\",
						txtEnchapes = \"" . $txtEnchapes . "\",
						txtEstadoAcabados = \"" . $txtEstadoAcabados . "\",
						txtAcabados = \"" . $txtAcabados . "\",
						txtEstadoHidraulicas = \"" . $txtEstadoHidraulicas . "\",
						txtHidraulicas = \"" . $txtHidraulicas . "\",
						txtEstadoElectricas = \"" . $txtEstadoElectricas . "\",
						txtElectricas = \"" . $txtElectricas . "\",
						txtEstadoSanitarias = \"" . $txtEstadoSanitarias . "\",
						txtSanitarias = \"" . $txtSanitarias . "\",
						txtEstadoGas = \"" . $txtEstadoGas . "\",
						txtGas = \"" . $txtGas . "\",
						txtEstadoMadera = \"" . $txtEstadoMadera . "\",
						txtMadera = \"" . $txtMadera . "\",
						txtEstadoMetalica = \"" . $txtEstadoMetalica . "\",
						txtMetalica = \"" . $txtMetalica . "\",
						numLavadero = \"" . $numLavadero . "\",
						txtLavadero = \"" . $txtLavadero . "\",
						numLavaplatos = \"" . $numLavaplatos . "\",
						txtLavaplatos = \"" . $txtLavaplatos . "\",
						numLavamanos = \"" . $numLavamanos . "\",
						txtLavamanos = \"" . $txtLavamanos . "\",
						numSanitario = \"" . $numSanitario . "\",
						txtSanitario = \"" . $txtSanitario . "\",
						numDucha = \"" . $numDucha . "\",
						txtDucha = \"" . $txtDucha . "\",
						txtEstadoVidrios = \"" . $txtEstadoVidrios . "\",
						txtVidrios = \"" . $txtVidrios . "\",
						txtEstadoPintura = \"" . $txtEstadoPintura . "\",
						txtPintura = \"" . $txtPintura . "\",
						txtOtros = \"" . $txtOtros . "\",
						txtObservacionOtros = \"" . $txtObservacionOtros . "\",
						numContadorAgua = \"" . $numContadorAgua . "\",
						txtEstadoConexionAgua = \"" . $txtEstadoConexionAgua . "\",
						txtDescripcionAgua = \"" . $txtDescripcionAgua . "\",
						numContadorEnergia = \"" . $numContadorEnergia . "\",
						txtEstadoConexionEnergia = \"" . $txtEstadoConexionEnergia . "\",
						txtDescripcionEnergia = \"" . $txtDescripcionEnergia . "\",
						numContadorAlcantarillado = \"" . $numContadorAlcantarillado . "\",
						txtEstadoConexionAlcantarillado = \"" . $txtEstadoConexionAlcantarillado . "\",
						txtDescripcionAlcantarillado = \"" . $txtDescripcionAlcantarillado . "\",
						numContadorGas = \"" . $numContadorGas . "\",
						txtEstadoConexionGas = \"" . $txtEstadoConexionGas . "\",
						txtDescripcionGas = \"" . $txtDescripcionGas . "\",
						numContadorTelefono = \"" . $numContadorTelefono . "\",
						txtEstadoConexionTelefono = \"" . $txtEstadoConexionTelefono . "\",
						txtDescripcionTelefono = \"" . $txtDescripcionTelefono . "\",
						txtEstadoAndenes = \"" . $txtEstadoAndenes . "\",
						txtDescripcionAndenes = \"" . $txtDescripcionAndenes . "\",
						txtEstadoVias = \"" . $txtEstadoVias . "\",
						txtDescripcionVias = \"" . $txtDescripcionVias . "\",
						txtEstadoServiciosComunales = \"" . $txtEstadoServiciosComunales . "\",
						txtDescripcionServiciosComunales = \"" . $txtDescripcionServiciosComunales . "\",
						txtDescripcionVivienda = \"" . $txtDescripcionVivienda . "\",
						txtNormaNSR98 = \"" . $txtNormaNSR98 . "\",
						txtRequisitos = \"" . $txtRequisitos . "\",
						txtExistencia = \"" . $txtExistencia . "\",
						txtDescipcionNormaNSR98 = \"" . $txtDescipcionNormaNSR98 . "\",
						txtDescripcionRequisitos = \"" . $txtDescripcionRequisitos . "\",
						txtDescripcionExistencia = \"" . $txtDescripcionExistencia . "\",
						fchVisita = \"" . $fchVisita . "\",
						txtAprobo = \"" . $txtAprobo . "\",
						fchActualizacion = NOW()
					WHERE seqUnidadProyecto = $seqUnidadProyecto
					";
        }
        //echo $sql;
        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            //$arrProyectoVivienda = $this->cargarProyectoVivienda( $seqProyecto );
            $arrErrores[] = "No se ha podido editar el Proyecto <b>" . $arrProyectoVivienda[$seqProyecto]->txtNombreProyecto . "</b>. Reporte este error al administrador del sistema";
        }
        return $arrErrores;
    }

    ///////////////////////////////////// INICIO GESTIONA SEGUIMIENTOS AL CRONOGRAMA DE OBRAS ///////////////////////////////////////////////////////
    public function ingresarSeguimientoCronograma($seqProyecto, $arrDatosProyecto) {
        global $aptBd;
        $arrErrores = array();
        //pr($arrDatosProyecto);
        // Seguimientos al cronograma del proyecto
        $arrExistentes = array();
        $sqlExistentes = "SELECT seqSeguimientoCronogramaObras FROM T_PRY_CRONOGRAMA_OBRAS_SEGUIMIENTO WHERE seqProyecto = $seqProyecto";
        //echo $sqlExistentes;
        $exeExistentes = mysql_query($sqlExistentes);
        while ($rowExistentes = mysql_fetch_array($exeExistentes)) {
            $arrExistentes[] = $rowExistentes['seqSeguimientoCronogramaObras'];
        }
        //pr($arrExistentes);
        // Campos a registrar en las consultas
        $fchGestion = date("Y-m-d H:i:s");
        $arrArregloPost = array();

        // Recorre el arreglo que viene del formulario
        if (!empty($arrDatosProyecto)) {
            foreach ($arrDatosProyecto as $indice => $seqSeguimientoCronogramaObras) {
                $seqSeguimientoCronogramaObras = $_POST['seqSeguimientoCronogramaObras'][$indice];
                $fchVisita = $_POST['fchVisita'][$indice];
                $fchInicialTerrenoPry = $_POST['fchInicialTerrenoPry'][$indice];
                $fchInicialTerrenoSeg = $_POST['fchInicialTerrenoSeg'][$indice];
                $difFchInicialTerreno = $_POST['difFchInicialTerreno'][$indice];
                $fchFinalTerrenoPry = $_POST['fchFinalTerrenoPry'][$indice];
                $fchFinalTerrenoSeg = $_POST['fchFinalTerrenoSeg'][$indice];
                $difFchFinalTerreno = $_POST['difFchFinalTerreno'][$indice];
                $porcIncTerrenoPry = $_POST['porcIncTerrenoPry'][$indice];
                $porcIncTerrenoSeg = $_POST['porcIncTerrenoSeg'][$indice];
                $difPorcIncTerreno = $_POST['difPorcIncTerreno'][$indice];
                $valActTerrenoPry = $_POST['valActTerrenoPry'][$indice];
                $valActTerrenoSeg = $_POST['valActTerrenoSeg'][$indice];
                $difValActTerreno = $_POST['difValActTerreno'][$indice];
                $fchInicialPreliminarConstruccionPry = $_POST['fchInicialPreliminarConstruccionPry'][$indice];
                $fchInicialPreliminarConstruccionSeg = $_POST['fchInicialPreliminarConstruccionSeg'][$indice];
                $difFchInicialPreliminarConstruccion = $_POST['difFchInicialPreliminarConstruccion'][$indice];
                $fchFinalPreliminarConstruccionPry = $_POST['fchFinalPreliminarConstruccionPry'][$indice];
                $fchFinalPreliminarConstruccionSeg = $_POST['fchFinalPreliminarConstruccionSeg'][$indice];
                $difFchFinalPreliminarConstruccion = $_POST['difFchFinalPreliminarConstruccion'][$indice];
                $porcIncPreliminarConstruccionPry = $_POST['porcIncPreliminarConstruccionPry'][$indice];
                $porcIncPreliminarConstruccionSeg = $_POST['porcIncPreliminarConstruccionSeg'][$indice];
                $difPorcIncPreliminarConstruccion = $_POST['difPorcIncPreliminarConstruccion'][$indice];
                $valActPreliminarConstruccionPry = $_POST['valActPreliminarConstruccionPry'][$indice];
                $valActPreliminarConstruccionSeg = $_POST['valActPreliminarConstruccionSeg'][$indice];
                $difValActPreliminarConstruccion = $_POST['difValActPreliminarConstruccion'][$indice];
                $fchInicialCimentacionConstruccionPry = $_POST['fchInicialCimentacionConstruccionPry'][$indice];
                $fchInicialCimentacionConstruccionSeg = $_POST['fchInicialCimentacionConstruccionSeg'][$indice];
                $difFchInicialCimentacionConstruccion = $_POST['difFchInicialCimentacionConstruccion'][$indice];
                $fchFinalCimentacionConstruccionPry = $_POST['fchFinalCimentacionConstruccionPry'][$indice];
                $fchFinalCimentacionConstruccionSeg = $_POST['fchFinalCimentacionConstruccionSeg'][$indice];
                $difFchFinalCimentacionConstruccion = $_POST['difFchFinalCimentacionConstruccion'][$indice];
                $porcIncCimentacionConstruccionPry = $_POST['porcIncCimentacionConstruccionPry'][$indice];
                $porcIncCimentacionConstruccionSeg = $_POST['porcIncCimentacionConstruccionSeg'][$indice];
                $difPorcIncCimentacionConstruccion = $_POST['difPorcIncCimentacionConstruccion'][$indice];
                $valActCimentacionConstruccionPry = $_POST['valActCimentacionConstruccionPry'][$indice];
                $valActCimentacionConstruccionSeg = $_POST['valActCimentacionConstruccionSeg'][$indice];
                $difValActCimentacionConstruccion = $_POST['difValActCimentacionConstruccion'][$indice];
                $fchInicialDesaguesConstruccionPry = $_POST['fchInicialDesaguesConstruccionPry'][$indice];
                $fchInicialDesaguesConstruccionSeg = $_POST['fchInicialDesaguesConstruccionSeg'][$indice];
                $difFchInicialDesaguesConstruccion = $_POST['difFchInicialDesaguesConstruccion'][$indice];
                $fchFinalDesaguesConstruccionPry = $_POST['fchFinalDesaguesConstruccionPry'][$indice];
                $fchFinalDesaguesConstruccionSeg = $_POST['fchFinalDesaguesConstruccionSeg'][$indice];
                $difFchFinalDesaguesConstruccion = $_POST['difFchFinalDesaguesConstruccion'][$indice];
                $porcIncDesaguesConstruccionPry = $_POST['porcIncDesaguesConstruccionPry'][$indice];
                $porcIncDesaguesConstruccionSeg = $_POST['porcIncDesaguesConstruccionSeg'][$indice];
                $difPorcIncDesaguesConstruccion = $_POST['difPorcIncDesaguesConstruccion'][$indice];
                $valActDesaguesConstruccionPry = $_POST['valActDesaguesConstruccionPry'][$indice];
                $valActDesaguesConstruccionSeg = $_POST['valActDesaguesConstruccionSeg'][$indice];
                $difValActDesaguesConstruccion = $_POST['difValActDesaguesConstruccion'][$indice];
                $fchInicialEstructuraConstruccionPry = $_POST['fchInicialEstructuraConstruccionPry'][$indice];
                $fchInicialEstructuraConstruccionSeg = $_POST['fchInicialEstructuraConstruccionSeg'][$indice];
                $difFchInicialEstructuraConstruccion = $_POST['difFchInicialEstructuraConstruccion'][$indice];
                $fchFinalEstructuraConstruccionPry = $_POST['fchFinalEstructuraConstruccionPry'][$indice];
                $fchFinalEstructuraConstruccionSeg = $_POST['fchFinalEstructuraConstruccionSeg'][$indice];
                $difFchFinalEstructuraConstruccion = $_POST['difFchFinalEstructuraConstruccion'][$indice];
                $porcIncEstructuraConstruccionPry = $_POST['porcIncEstructuraConstruccionPry'][$indice];
                $porcIncEstructuraConstruccionSeg = $_POST['porcIncEstructuraConstruccionSeg'][$indice];
                $difPorcIncEstructuraConstruccion = $_POST['difPorcIncEstructuraConstruccion'][$indice];
                $valActEstructuraConstruccionPry = $_POST['valActEstructuraConstruccionPry'][$indice];
                $valActEstructuraConstruccionSeg = $_POST['valActEstructuraConstruccionSeg'][$indice];
                $difValActEstructuraConstruccion = $_POST['difValActEstructuraConstruccion'][$indice];
                $fchInicialMamposteriaConstruccionPry = $_POST['fchInicialMamposteriaConstruccionPry'][$indice];
                $fchInicialMamposteriaConstruccionSeg = $_POST['fchInicialMamposteriaConstruccionSeg'][$indice];
                $difFchInicialMamposteriaConstruccion = $_POST['difFchInicialMamposteriaConstruccion'][$indice];
                $fchFinalMamposteriaConstruccionPry = $_POST['fchFinalMamposteriaConstruccionPry'][$indice];
                $fchFinalMamposteriaConstruccionSeg = $_POST['fchFinalMamposteriaConstruccionSeg'][$indice];
                $difFchFinalMamposteriaConstruccion = $_POST['difFchFinalMamposteriaConstruccion'][$indice];
                $porcIncMamposteriaConstruccionPry = $_POST['porcIncMamposteriaConstruccionPry'][$indice];
                $porcIncMamposteriaConstruccionSeg = $_POST['porcIncMamposteriaConstruccionSeg'][$indice];
                $difPorcIncMamposteriaConstruccion = $_POST['difPorcIncMamposteriaConstruccion'][$indice];
                $valActMamposteriaConstruccionPry = $_POST['valActMamposteriaConstruccionPry'][$indice];
                $valActMamposteriaConstruccionSeg = $_POST['valActMamposteriaConstruccionSeg'][$indice];
                $difValActMamposteriaConstruccion = $_POST['difValActMamposteriaConstruccion'][$indice];
                $fchInicialPanetesConstruccionPry = $_POST['fchInicialPanetesConstruccionPry'][$indice];
                $fchInicialPanetesConstruccionSeg = $_POST['fchInicialPanetesConstruccionSeg'][$indice];
                $difFchInicialPanetesConstruccion = $_POST['difFchInicialPanetesConstruccion'][$indice];
                $fchFinalPanetesConstruccionPry = $_POST['fchFinalPanetesConstruccionPry'][$indice];
                $fchFinalPanetesConstruccionSeg = $_POST['fchFinalPanetesConstruccionSeg'][$indice];
                $difFchFinalPanetesConstruccion = $_POST['difFchFinalPanetesConstruccion'][$indice];
                $porcIncPanetesConstruccionPry = $_POST['porcIncPanetesConstruccionPry'][$indice];
                $porcIncPanetesConstruccionSeg = $_POST['porcIncPanetesConstruccionSeg'][$indice];
                $difPorcIncPanetesConstruccion = $_POST['difPorcIncPanetesConstruccion'][$indice];
                $valActPanetesConstruccionPry = $_POST['valActPanetesConstruccionPry'][$indice];
                $valActPanetesConstruccionSeg = $_POST['valActPanetesConstruccionSeg'][$indice];
                $difValActPanetesConstruccion = $_POST['difValActPanetesConstruccion'][$indice];
                $fchInicialHidrosanitariasConstruccionPry = $_POST['fchInicialHidrosanitariasConstruccionPry'][$indice];
                $fchInicialHidrosanitariasConstruccionSeg = $_POST['fchInicialHidrosanitariasConstruccionSeg'][$indice];
                $difFchInicialHidrosanitariasConstruccion = $_POST['difFchInicialHidrosanitariasConstruccion'][$indice];
                $fchFinalHidrosanitariasConstruccionPry = $_POST['fchFinalHidrosanitariasConstruccionPry'][$indice];
                $fchFinalHidrosanitariasConstruccionSeg = $_POST['fchFinalHidrosanitariasConstruccionSeg'][$indice];
                $difFchFinalHidrosanitariasConstruccion = $_POST['difFchFinalHidrosanitariasConstruccion'][$indice];
                $porcIncHidrosanitariasConstruccionPry = $_POST['porcIncHidrosanitariasConstruccionPry'][$indice];
                $porcIncHidrosanitariasConstruccionSeg = $_POST['porcIncHidrosanitariasConstruccionSeg'][$indice];
                $difPorcIncHidrosanitariasConstruccion = $_POST['difPorcIncHidrosanitariasConstruccion'][$indice];
                $valActHidrosanitariasConstruccionPry = $_POST['valActHidrosanitariasConstruccionPry'][$indice];
                $valActHidrosanitariasConstruccionSeg = $_POST['valActHidrosanitariasConstruccionSeg'][$indice];
                $difValActHidrosanitariasConstruccion = $_POST['difValActHidrosanitariasConstruccion'][$indice];
                $fchInicialElectricasConstruccionPry = $_POST['fchInicialElectricasConstruccionPry'][$indice];
                $fchInicialElectricasConstruccionSeg = $_POST['fchInicialElectricasConstruccionSeg'][$indice];
                $difFchInicialElectricasConstruccion = $_POST['difFchInicialElectricasConstruccion'][$indice];
                $fchFinalElectricasConstruccionPry = $_POST['fchFinalElectricasConstruccionPry'][$indice];
                $fchFinalElectricasConstruccionSeg = $_POST['fchFinalElectricasConstruccionSeg'][$indice];
                $difFchFinalElectricasConstruccion = $_POST['difFchFinalElectricasConstruccion'][$indice];
                $porcIncElectricasConstruccionPry = $_POST['porcIncElectricasConstruccionPry'][$indice];
                $porcIncElectricasConstruccionSeg = $_POST['porcIncElectricasConstruccionSeg'][$indice];
                $difPorcIncElectricasConstruccion = $_POST['difPorcIncElectricasConstruccion'][$indice];
                $valActElectricasConstruccionPry = $_POST['valActElectricasConstruccionPry'][$indice];
                $valActElectricasConstruccionSeg = $_POST['valActElectricasConstruccionSeg'][$indice];
                $difValActElectricasConstruccion = $_POST['difValActElectricasConstruccion'][$indice];
                $fchInicialCubiertaConstruccionPry = $_POST['fchInicialCubiertaConstruccionPry'][$indice];
                $fchInicialCubiertaConstruccionSeg = $_POST['fchInicialCubiertaConstruccionSeg'][$indice];
                $difFchInicialCubiertaConstruccion = $_POST['difFchInicialCubiertaConstruccion'][$indice];
                $fchFinalCubiertaConstruccionPry = $_POST['fchFinalCubiertaConstruccionPry'][$indice];
                $fchFinalCubiertaConstruccionSeg = $_POST['fchFinalCubiertaConstruccionSeg'][$indice];
                $difFchFinalCubiertaConstruccion = $_POST['difFchFinalCubiertaConstruccion'][$indice];
                $porcIncCubiertaConstruccionPry = $_POST['porcIncCubiertaConstruccionPry'][$indice];
                $porcIncCubiertaConstruccionSeg = $_POST['porcIncCubiertaConstruccionSeg'][$indice];
                $difPorcIncCubiertaConstruccion = $_POST['difPorcIncCubiertaConstruccion'][$indice];
                $valActCubiertaConstruccionPry = $_POST['valActCubiertaConstruccionPry'][$indice];
                $valActCubiertaConstruccionSeg = $_POST['valActCubiertaConstruccionSeg'][$indice];
                $difValActCubiertaConstruccion = $_POST['difValActCubiertaConstruccion'][$indice];
                $fchInicialCarpinteriaConstruccionPry = $_POST['fchInicialCarpinteriaConstruccionPry'][$indice];
                $fchInicialCarpinteriaConstruccionSeg = $_POST['fchInicialCarpinteriaConstruccionSeg'][$indice];
                $difFchInicialCarpinteriaConstruccion = $_POST['difFchInicialCarpinteriaConstruccion'][$indice];
                $fchFinalCarpinteriaConstruccionPry = $_POST['fchFinalCarpinteriaConstruccionPry'][$indice];
                $fchFinalCarpinteriaConstruccionSeg = $_POST['fchFinalCarpinteriaConstruccionSeg'][$indice];
                $difFchFinalCarpinteriaConstruccion = $_POST['difFchFinalCarpinteriaConstruccion'][$indice];
                $porcIncCarpinteriaConstruccionPry = $_POST['porcIncCarpinteriaConstruccionPry'][$indice];
                $porcIncCarpinteriaConstruccionSeg = $_POST['porcIncCarpinteriaConstruccionSeg'][$indice];
                $difPorcIncCarpinteriaConstruccion = $_POST['difPorcIncCarpinteriaConstruccion'][$indice];
                $valActCarpinteriaConstruccionPry = $_POST['valActCarpinteriaConstruccionPry'][$indice];
                $valActCarpinteriaConstruccionSeg = $_POST['valActCarpinteriaConstruccionSeg'][$indice];
                $difValActCarpinteriaConstruccion = $_POST['difValActCarpinteriaConstruccion'][$indice];
                $fchInicialPisosConstruccionPry = $_POST['fchInicialPisosConstruccionPry'][$indice];
                $fchInicialPisosConstruccionSeg = $_POST['fchInicialPisosConstruccionSeg'][$indice];
                $difFchInicialPisosConstruccion = $_POST['difFchInicialPisosConstruccion'][$indice];
                $fchFinalPisosConstruccionPry = $_POST['fchFinalPisosConstruccionPry'][$indice];
                $fchFinalPisosConstruccionSeg = $_POST['fchFinalPisosConstruccionSeg'][$indice];
                $difFchFinalPisosConstruccion = $_POST['difFchFinalPisosConstruccion'][$indice];
                $porcIncPisosConstruccionPry = $_POST['porcIncPisosConstruccionPry'][$indice];
                $porcIncPisosConstruccionSeg = $_POST['porcIncPisosConstruccionSeg'][$indice];
                $difPorcIncPisosConstruccion = $_POST['difPorcIncPisosConstruccion'][$indice];
                $valActPisosConstruccionPry = $_POST['valActPisosConstruccionPry'][$indice];
                $valActPisosConstruccionSeg = $_POST['valActPisosConstruccionSeg'][$indice];
                $difValActPisosConstruccion = $_POST['difValActPisosConstruccion'][$indice];
                $fchInicialSanitariosConstruccionPry = $_POST['fchInicialSanitariosConstruccionPry'][$indice];
                $fchInicialSanitariosConstruccionSeg = $_POST['fchInicialSanitariosConstruccionSeg'][$indice];
                $difFchInicialSanitariosConstruccion = $_POST['difFchInicialSanitariosConstruccion'][$indice];
                $fchFinalSanitariosConstruccionPry = $_POST['fchFinalSanitariosConstruccionPry'][$indice];
                $fchFinalSanitariosConstruccionSeg = $_POST['fchFinalSanitariosConstruccionSeg'][$indice];
                $difFchFinalSanitariosConstruccion = $_POST['difFchFinalSanitariosConstruccion'][$indice];
                $porcIncSanitariosConstruccionPry = $_POST['porcIncSanitariosConstruccionPry'][$indice];
                $porcIncSanitariosConstruccionSeg = $_POST['porcIncSanitariosConstruccionSeg'][$indice];
                $difPorcIncSanitariosConstruccion = $_POST['difPorcIncSanitariosConstruccion'][$indice];
                $valActSanitariosConstruccionPry = $_POST['valActSanitariosConstruccionPry'][$indice];
                $valActSanitariosConstruccionSeg = $_POST['valActSanitariosConstruccionSeg'][$indice];
                $difValActSanitariosConstruccion = $_POST['difValActSanitariosConstruccion'][$indice];
                $fchInicialExterioresConstruccionPry = $_POST['fchInicialExterioresConstruccionPry'][$indice];
                $fchInicialExterioresConstruccionSeg = $_POST['fchInicialExterioresConstruccionSeg'][$indice];
                $difFchInicialExterioresConstruccion = $_POST['difFchInicialExterioresConstruccion'][$indice];
                $fchFinalExterioresConstruccionPry = $_POST['fchFinalExterioresConstruccionPry'][$indice];
                $fchFinalExterioresConstruccionSeg = $_POST['fchFinalExterioresConstruccionSeg'][$indice];
                $difFchFinalExterioresConstruccion = $_POST['difFchFinalExterioresConstruccion'][$indice];
                $porcIncExterioresConstruccionPry = $_POST['porcIncExterioresConstruccionPry'][$indice];
                $porcIncExterioresConstruccionSeg = $_POST['porcIncExterioresConstruccionSeg'][$indice];
                $difPorcIncExterioresConstruccion = $_POST['difPorcIncExterioresConstruccion'][$indice];
                $valActExterioresConstruccionPry = $_POST['valActExterioresConstruccionPry'][$indice];
                $valActExterioresConstruccionSeg = $_POST['valActExterioresConstruccionSeg'][$indice];
                $difValActExterioresConstruccion = $_POST['difValActExterioresConstruccion'][$indice];
                $fchInicialAseoConstruccionPry = $_POST['fchInicialAseoConstruccionPry'][$indice];
                $fchInicialAseoConstruccionSeg = $_POST['fchInicialAseoConstruccionSeg'][$indice];
                $difFchInicialAseoConstruccion = $_POST['difFchInicialAseoConstruccion'][$indice];
                $fchFinalAseoConstruccionPry = $_POST['fchFinalAseoConstruccionPry'][$indice];
                $fchFinalAseoConstruccionSeg = $_POST['fchFinalAseoConstruccionSeg'][$indice];
                $difFchFinalAseoConstruccion = $_POST['difFchFinalAseoConstruccion'][$indice];
                $porcIncAseoConstruccionPry = $_POST['porcIncAseoConstruccionPry'][$indice];
                $porcIncAseoConstruccionSeg = $_POST['porcIncAseoConstruccionSeg'][$indice];
                $difPorcIncAseoConstruccion = $_POST['difPorcIncAseoConstruccion'][$indice];
                $valActAseoConstruccionPry = $_POST['valActAseoConstruccionPry'][$indice];
                $valActAseoConstruccionSeg = $_POST['valActAseoConstruccionSeg'][$indice];
                $difValActAseoConstruccion = $_POST['difValActAseoConstruccion'][$indice];
                $fchInicialPreliminarUrbanismoPry = $_POST['fchInicialPreliminarUrbanismoPry'][$indice];
                $fchInicialPreliminarUrbanismoSeg = $_POST['fchInicialPreliminarUrbanismoSeg'][$indice];
                $difFchInicialPreliminarUrbanismo = $_POST['difFchInicialPreliminarUrbanismo'][$indice];
                $fchFinalPreliminarUrbanismoPry = $_POST['fchFinalPreliminarUrbanismoPry'][$indice];
                $fchFinalPreliminarUrbanismoSeg = $_POST['fchFinalPreliminarUrbanismoSeg'][$indice];
                $difFchFinalPreliminarUrbanismo = $_POST['difFchFinalPreliminarUrbanismo'][$indice];
                $porcIncPreliminarUrbanismoPry = $_POST['porcIncPreliminarUrbanismoPry'][$indice];
                $porcIncPreliminarUrbanismoSeg = $_POST['porcIncPreliminarUrbanismoSeg'][$indice];
                $difPorcIncPreliminarUrbanismo = $_POST['difPorcIncPreliminarUrbanismo'][$indice];
                $valActPreliminarUrbanismoPry = $_POST['valActPreliminarUrbanismoPry'][$indice];
                $valActPreliminarUrbanismoSeg = $_POST['valActPreliminarUrbanismoSeg'][$indice];
                $difValActPreliminarUrbanismo = $_POST['difValActPreliminarUrbanismo'][$indice];
                $fchInicialCimentacionUrbanismoPry = $_POST['fchInicialCimentacionUrbanismoPry'][$indice];
                $fchInicialCimentacionUrbanismoSeg = $_POST['fchInicialCimentacionUrbanismoSeg'][$indice];
                $difFchInicialCimentacionUrbanismo = $_POST['difFchInicialCimentacionUrbanismo'][$indice];
                $fchFinalCimentacionUrbanismoPry = $_POST['fchFinalCimentacionUrbanismoPry'][$indice];
                $fchFinalCimentacionUrbanismoSeg = $_POST['fchFinalCimentacionUrbanismoSeg'][$indice];
                $difFchFinalCimentacionUrbanismo = $_POST['difFchFinalCimentacionUrbanismo'][$indice];
                $porcIncCimentacionUrbanismoPry = $_POST['porcIncCimentacionUrbanismoPry'][$indice];
                $porcIncCimentacionUrbanismoSeg = $_POST['porcIncCimentacionUrbanismoSeg'][$indice];
                $difPorcIncCimentacionUrbanismo = $_POST['difPorcIncCimentacionUrbanismo'][$indice];
                $valActCimentacionUrbanismoPry = $_POST['valActCimentacionUrbanismoPry'][$indice];
                $valActCimentacionUrbanismoSeg = $_POST['valActCimentacionUrbanismoSeg'][$indice];
                $difValActCimentacionUrbanismo = $_POST['difValActCimentacionUrbanismo'][$indice];
                $fchInicialDesaguesUrbanismoPry = $_POST['fchInicialDesaguesUrbanismoPry'][$indice];
                $fchInicialDesaguesUrbanismoSeg = $_POST['fchInicialDesaguesUrbanismoSeg'][$indice];
                $difFchInicialDesaguesUrbanismo = $_POST['difFchInicialDesaguesUrbanismo'][$indice];
                $fchFinalDesaguesUrbanismoPry = $_POST['fchFinalDesaguesUrbanismoPry'][$indice];
                $fchFinalDesaguesUrbanismoSeg = $_POST['fchFinalDesaguesUrbanismoSeg'][$indice];
                $difFchFinalDesaguesUrbanismo = $_POST['difFchFinalDesaguesUrbanismo'][$indice];
                $porcIncDesaguesUrbanismoPry = $_POST['porcIncDesaguesUrbanismoPry'][$indice];
                $porcIncDesaguesUrbanismoSeg = $_POST['porcIncDesaguesUrbanismoSeg'][$indice];
                $difPorcIncDesaguesUrbanismo = $_POST['difPorcIncDesaguesUrbanismo'][$indice];
                $valActDesaguesUrbanismoPry = $_POST['valActDesaguesUrbanismoPry'][$indice];
                $valActDesaguesUrbanismoSeg = $_POST['valActDesaguesUrbanismoSeg'][$indice];
                $difValActDesaguesUrbanismo = $_POST['difValActDesaguesUrbanismo'][$indice];
                $fchInicialViasUrbanismoPry = $_POST['fchInicialViasUrbanismoPry'][$indice];
                $fchInicialViasUrbanismoSeg = $_POST['fchInicialViasUrbanismoSeg'][$indice];
                $difFchInicialViasUrbanismo = $_POST['difFchInicialViasUrbanismo'][$indice];
                $fchFinalViasUrbanismoPry = $_POST['fchFinalViasUrbanismoPry'][$indice];
                $fchFinalViasUrbanismoSeg = $_POST['fchFinalViasUrbanismoSeg'][$indice];
                $difFchFinalViasUrbanismo = $_POST['difFchFinalViasUrbanismo'][$indice];
                $porcIncViasUrbanismoPry = $_POST['porcIncViasUrbanismoPry'][$indice];
                $porcIncViasUrbanismoSeg = $_POST['porcIncViasUrbanismoSeg'][$indice];
                $difPorcIncViasUrbanismo = $_POST['difPorcIncViasUrbanismo'][$indice];
                $valActViasUrbanismoPry = $_POST['valActViasUrbanismoPry'][$indice];
                $valActViasUrbanismoSeg = $_POST['valActViasUrbanismoSeg'][$indice];
                $difValActViasUrbanismo = $_POST['difValActViasUrbanismo'][$indice];
                $fchInicialParquesUrbanismoPry = $_POST['fchInicialParquesUrbanismoPry'][$indice];
                $fchInicialParquesUrbanismoSeg = $_POST['fchInicialParquesUrbanismoSeg'][$indice];
                $difFchInicialParquesUrbanismo = $_POST['difFchInicialParquesUrbanismo'][$indice];
                $fchFinalParquesUrbanismoPry = $_POST['fchFinalParquesUrbanismoPry'][$indice];
                $fchFinalParquesUrbanismoSeg = $_POST['fchFinalParquesUrbanismoSeg'][$indice];
                $difFchFinalParquesUrbanismo = $_POST['difFchFinalParquesUrbanismo'][$indice];
                $porcIncParquesUrbanismoPry = $_POST['porcIncParquesUrbanismoPry'][$indice];
                $porcIncParquesUrbanismoSeg = $_POST['porcIncParquesUrbanismoSeg'][$indice];
                $difPorcIncParquesUrbanismo = $_POST['difPorcIncParquesUrbanismo'][$indice];
                $valActParquesUrbanismoPry = $_POST['valActParquesUrbanismoPry'][$indice];
                $valActParquesUrbanismoSeg = $_POST['valActParquesUrbanismoSeg'][$indice];
                $difValActParquesUrbanismo = $_POST['difValActParquesUrbanismo'][$indice];
                $fchInicialAseoUrbanismoPry = $_POST['fchInicialAseoUrbanismoPry'][$indice];
                $fchInicialAseoUrbanismoSeg = $_POST['fchInicialAseoUrbanismoSeg'][$indice];
                $difFchInicialAseoUrbanismo = $_POST['difFchInicialAseoUrbanismo'][$indice];
                $fchFinalAseoUrbanismoPry = $_POST['fchFinalAseoUrbanismoPry'][$indice];
                $fchFinalAseoUrbanismoSeg = $_POST['fchFinalAseoUrbanismoSeg'][$indice];
                $difFchFinalAseoUrbanismo = $_POST['difFchFinalAseoUrbanismo'][$indice];
                $porcIncAseoUrbanismoPry = $_POST['porcIncAseoUrbanismoPry'][$indice];
                $porcIncAseoUrbanismoSeg = $_POST['porcIncAseoUrbanismoSeg'][$indice];
                $difPorcIncAseoUrbanismo = $_POST['difPorcIncAseoUrbanismo'][$indice];
                $valActAseoUrbanismoPry = $_POST['valActAseoUrbanismoPry'][$indice];
                $valActAseoUrbanismoSeg = $_POST['valActAseoUrbanismoSeg'][$indice];
                $difValActAseoUrbanismo = $_POST['difValActAseoUrbanismo'][$indice];

                if ($seqSeguimientoCronogramaObras != '') {
                    $arrArregloPost[] = $seqSeguimientoCronogramaObras;
                }
                // Realiza las respectiva gestión sobre los datos
                if ($seqSeguimientoCronogramaObras) {
                    $query = "UPDATE T_PRY_CRONOGRAMA_OBRAS_SEGUIMIENTO SET fchInicialTerrenoPry = '$fchInicialTerrenoPry', fchInicialTerrenoSeg = '$fchInicialTerrenoSeg', difFchInicialTerreno = '$difFchInicialTerreno', fchFinalTerrenoPry = '$fchFinalTerrenoPry', fchFinalTerrenoSeg = '$fchFinalTerrenoSeg', difFchFinalTerreno = '$difFchFinalTerreno', porcIncTerrenoPry = '$porcIncTerrenoPry', porcIncTerrenoSeg = '$porcIncTerrenoSeg', difPorcIncTerreno = '$difPorcIncTerreno', valActTerrenoPry = '$valActTerrenoPry', valActTerrenoSeg = '$valActTerrenoSeg', difValActTerreno = '$difValActTerreno', fchInicialPreliminarConstruccionPry = '$fchInicialPreliminarConstruccionPry', fchInicialPreliminarConstruccionSeg = '$fchInicialPreliminarConstruccionSeg', difFchInicialPreliminarConstruccion = '$difFchInicialPreliminarConstruccion', fchFinalPreliminarConstruccionPry = '$fchFinalPreliminarConstruccionPry', fchFinalPreliminarConstruccionSeg = '$fchFinalPreliminarConstruccionSeg', difFchFinalPreliminarConstruccion = '$difFchFinalPreliminarConstruccion', porcIncPreliminarConstruccionPry = '$porcIncPreliminarConstruccionPry', porcIncPreliminarConstruccionSeg = '$porcIncPreliminarConstruccionSeg', difPorcIncPreliminarConstruccion = '$difPorcIncPreliminarConstruccion', valActPreliminarConstruccionPry = '$valActPreliminarConstruccionPry', valActPreliminarConstruccionSeg = '$valActPreliminarConstruccionSeg', difValActPreliminarConstruccion = '$difValActPreliminarConstruccion', fchInicialCimentacionConstruccionPry = '$fchInicialCimentacionConstruccionPry', fchInicialCimentacionConstruccionSeg = '$fchInicialCimentacionConstruccionSeg', difFchInicialCimentacionConstruccion = '$difFchInicialCimentacionConstruccion', fchFinalCimentacionConstruccionPry = '$fchFinalCimentacionConstruccionPry', fchFinalCimentacionConstruccionSeg = '$fchFinalCimentacionConstruccionSeg', difFchFinalCimentacionConstruccion = '$difFchFinalCimentacionConstruccion', porcIncCimentacionConstruccionPry = '$porcIncCimentacionConstruccionPry', porcIncCimentacionConstruccionSeg = '$porcIncCimentacionConstruccionSeg', difPorcIncCimentacionConstruccion = '$difPorcIncCimentacionConstruccion', valActCimentacionConstruccionPry = '$valActCimentacionConstruccionPry', valActCimentacionConstruccionSeg = '$valActCimentacionConstruccionSeg', difValActCimentacionConstruccion = '$difValActCimentacionConstruccion', fchInicialDesaguesConstruccionPry = '$fchInicialDesaguesConstruccionPry', fchInicialDesaguesConstruccionSeg = '$fchInicialDesaguesConstruccionSeg', difFchInicialDesaguesConstruccion = '$difFchInicialDesaguesConstruccion', fchFinalDesaguesConstruccionPry = '$fchFinalDesaguesConstruccionPry', fchFinalDesaguesConstruccionSeg = '$fchFinalDesaguesConstruccionSeg', difFchFinalDesaguesConstruccion = '$difFchFinalDesaguesConstruccion', porcIncDesaguesConstruccionPry = '$porcIncDesaguesConstruccionPry', porcIncDesaguesConstruccionSeg = '$porcIncDesaguesConstruccionSeg', difPorcIncDesaguesConstruccion = '$difPorcIncDesaguesConstruccion', valActDesaguesConstruccionPry = '$valActDesaguesConstruccionPry', valActDesaguesConstruccionSeg = '$valActDesaguesConstruccionSeg', difValActDesaguesConstruccion = '$difValActDesaguesConstruccion', fchInicialEstructuraConstruccionPry = '$fchInicialEstructuraConstruccionPry', fchInicialEstructuraConstruccionSeg = '$fchInicialEstructuraConstruccionSeg', difFchInicialEstructuraConstruccion = '$difFchInicialEstructuraConstruccion', fchFinalEstructuraConstruccionPry = '$fchFinalEstructuraConstruccionPry', fchFinalEstructuraConstruccionSeg = '$fchFinalEstructuraConstruccionSeg', difFchFinalEstructuraConstruccion = '$difFchFinalEstructuraConstruccion', porcIncEstructuraConstruccionPry = '$porcIncEstructuraConstruccionPry', porcIncEstructuraConstruccionSeg = '$porcIncEstructuraConstruccionSeg', difPorcIncEstructuraConstruccion = '$difPorcIncEstructuraConstruccion', valActEstructuraConstruccionPry = '$valActEstructuraConstruccionPry', valActEstructuraConstruccionSeg = '$valActEstructuraConstruccionSeg', difValActEstructuraConstruccion = '$difValActEstructuraConstruccion', fchInicialMamposteriaConstruccionPry = '$fchInicialMamposteriaConstruccionPry', fchInicialMamposteriaConstruccionSeg = '$fchInicialMamposteriaConstruccionSeg', difFchInicialMamposteriaConstruccion = '$difFchInicialMamposteriaConstruccion', fchFinalMamposteriaConstruccionPry = '$fchFinalMamposteriaConstruccionPry', fchFinalMamposteriaConstruccionSeg = '$fchFinalMamposteriaConstruccionSeg', difFchFinalMamposteriaConstruccion = '$difFchFinalMamposteriaConstruccion', porcIncMamposteriaConstruccionPry = '$porcIncMamposteriaConstruccionPry', porcIncMamposteriaConstruccionSeg = '$porcIncMamposteriaConstruccionSeg', difPorcIncMamposteriaConstruccion = '$difPorcIncMamposteriaConstruccion', valActMamposteriaConstruccionPry = '$valActMamposteriaConstruccionPry', valActMamposteriaConstruccionSeg = '$valActMamposteriaConstruccionSeg', difValActMamposteriaConstruccion = '$difValActMamposteriaConstruccion', fchInicialPanetesConstruccionPry = '$fchInicialPanetesConstruccionPry', fchInicialPanetesConstruccionSeg = '$fchInicialPanetesConstruccionSeg', difFchInicialPanetesConstruccion = '$difFchInicialPanetesConstruccion', fchFinalPanetesConstruccionPry = '$fchFinalPanetesConstruccionPry', fchFinalPanetesConstruccionSeg = '$fchFinalPanetesConstruccionSeg', difFchFinalPanetesConstruccion = '$difFchFinalPanetesConstruccion', porcIncPanetesConstruccionPry = '$porcIncPanetesConstruccionPry', porcIncPanetesConstruccionSeg = '$porcIncPanetesConstruccionSeg', difPorcIncPanetesConstruccion = '$difPorcIncPanetesConstruccion', valActPanetesConstruccionPry = '$valActPanetesConstruccionPry', valActPanetesConstruccionSeg = '$valActPanetesConstruccionSeg', difValActPanetesConstruccion = '$difValActPanetesConstruccion', fchInicialHidrosanitariasConstruccionPry = '$fchInicialHidrosanitariasConstruccionPry', fchInicialHidrosanitariasConstruccionSeg = '$fchInicialHidrosanitariasConstruccionSeg', difFchInicialHidrosanitariasConstruccion = '$difFchInicialHidrosanitariasConstruccion', fchFinalHidrosanitariasConstruccionPry = '$fchFinalHidrosanitariasConstruccionPry', fchFinalHidrosanitariasConstruccionSeg = '$fchFinalHidrosanitariasConstruccionSeg', difFchFinalHidrosanitariasConstruccion = '$difFchFinalHidrosanitariasConstruccion', porcIncHidrosanitariasConstruccionPry = '$porcIncHidrosanitariasConstruccionPry', porcIncHidrosanitariasConstruccionSeg = '$porcIncHidrosanitariasConstruccionSeg', difPorcIncHidrosanitariasConstruccion = '$difPorcIncHidrosanitariasConstruccion', valActHidrosanitariasConstruccionPry = '$valActHidrosanitariasConstruccionPry', valActHidrosanitariasConstruccionSeg = '$valActHidrosanitariasConstruccionSeg', difValActHidrosanitariasConstruccion = '$difValActHidrosanitariasConstruccion', fchInicialElectricasConstruccionPry = '$fchInicialElectricasConstruccionPry', fchInicialElectricasConstruccionSeg = '$fchInicialElectricasConstruccionSeg', difFchInicialElectricasConstruccion = '$difFchInicialElectricasConstruccion', fchFinalElectricasConstruccionPry = '$fchFinalElectricasConstruccionPry', fchFinalElectricasConstruccionSeg = '$fchFinalElectricasConstruccionSeg', difFchFinalElectricasConstruccion = '$difFchFinalElectricasConstruccion', porcIncElectricasConstruccionPry = '$porcIncElectricasConstruccionPry', porcIncElectricasConstruccionSeg = '$porcIncElectricasConstruccionSeg', difPorcIncElectricasConstruccion = '$difPorcIncElectricasConstruccion', valActElectricasConstruccionPry = '$valActElectricasConstruccionPry', valActElectricasConstruccionSeg = '$valActElectricasConstruccionSeg', difValActElectricasConstruccion = '$difValActElectricasConstruccion', fchInicialCubiertaConstruccionPry = '$fchInicialCubiertaConstruccionPry', fchInicialCubiertaConstruccionSeg = '$fchInicialCubiertaConstruccionSeg', difFchInicialCubiertaConstruccion = '$difFchInicialCubiertaConstruccion', fchFinalCubiertaConstruccionPry = '$fchFinalCubiertaConstruccionPry', fchFinalCubiertaConstruccionSeg = '$fchFinalCubiertaConstruccionSeg', difFchFinalCubiertaConstruccion = '$difFchFinalCubiertaConstruccion', porcIncCubiertaConstruccionPry = '$porcIncCubiertaConstruccionPry', porcIncCubiertaConstruccionSeg = '$porcIncCubiertaConstruccionSeg', difPorcIncCubiertaConstruccion = '$difPorcIncCubiertaConstruccion', valActCubiertaConstruccionPry = '$valActCubiertaConstruccionPry', valActCubiertaConstruccionSeg = '$valActCubiertaConstruccionSeg', difValActCubiertaConstruccion = '$difValActCubiertaConstruccion', fchInicialCarpinteriaConstruccionPry = '$fchInicialCarpinteriaConstruccionPry', fchInicialCarpinteriaConstruccionSeg = '$fchInicialCarpinteriaConstruccionSeg', difFchInicialCarpinteriaConstruccion = '$difFchInicialCarpinteriaConstruccion', fchFinalCarpinteriaConstruccionPry = '$fchFinalCarpinteriaConstruccionPry', fchFinalCarpinteriaConstruccionSeg = '$fchFinalCarpinteriaConstruccionSeg', difFchFinalCarpinteriaConstruccion = '$difFchFinalCarpinteriaConstruccion', porcIncCarpinteriaConstruccionPry = '$porcIncCarpinteriaConstruccionPry', porcIncCarpinteriaConstruccionSeg = '$porcIncCarpinteriaConstruccionSeg', difPorcIncCarpinteriaConstruccion = '$difPorcIncCarpinteriaConstruccion', valActCarpinteriaConstruccionPry = '$valActCarpinteriaConstruccionPry', valActCarpinteriaConstruccionSeg = '$valActCarpinteriaConstruccionSeg', difValActCarpinteriaConstruccion = '$difValActCarpinteriaConstruccion', fchInicialPisosConstruccionPry = '$fchInicialPisosConstruccionPry', fchInicialPisosConstruccionSeg = '$fchInicialPisosConstruccionSeg', difFchInicialPisosConstruccion = '$difFchInicialPisosConstruccion', fchFinalPisosConstruccionPry = '$fchFinalPisosConstruccionPry', fchFinalPisosConstruccionSeg = '$fchFinalPisosConstruccionSeg', difFchFinalPisosConstruccion = '$difFchFinalPisosConstruccion', porcIncPisosConstruccionPry = '$porcIncPisosConstruccionPry', porcIncPisosConstruccionSeg = '$porcIncPisosConstruccionSeg', difPorcIncPisosConstruccion = '$difPorcIncPisosConstruccion', valActPisosConstruccionPry = '$valActPisosConstruccionPry', valActPisosConstruccionSeg = '$valActPisosConstruccionSeg', difValActPisosConstruccion = '$difValActPisosConstruccion', fchInicialSanitariosConstruccionPry = '$fchInicialSanitariosConstruccionPry', fchInicialSanitariosConstruccionSeg = '$fchInicialSanitariosConstruccionSeg', difFchInicialSanitariosConstruccion = '$difFchInicialSanitariosConstruccion', fchFinalSanitariosConstruccionPry = '$fchFinalSanitariosConstruccionPry', fchFinalSanitariosConstruccionSeg = '$fchFinalSanitariosConstruccionSeg', difFchFinalSanitariosConstruccion = '$difFchFinalSanitariosConstruccion', porcIncSanitariosConstruccionPry = '$porcIncSanitariosConstruccionPry', porcIncSanitariosConstruccionSeg = '$porcIncSanitariosConstruccionSeg', difPorcIncSanitariosConstruccion = '$difPorcIncSanitariosConstruccion', valActSanitariosConstruccionPry = '$valActSanitariosConstruccionPry', valActSanitariosConstruccionSeg = '$valActSanitariosConstruccionSeg', difValActSanitariosConstruccion = '$difValActSanitariosConstruccion', fchInicialExterioresConstruccionPry = '$fchInicialExterioresConstruccionPry', fchInicialExterioresConstruccionSeg = '$fchInicialExterioresConstruccionSeg', difFchInicialExterioresConstruccion = '$difFchInicialExterioresConstruccion', fchFinalExterioresConstruccionPry = '$fchFinalExterioresConstruccionPry', fchFinalExterioresConstruccionSeg = '$fchFinalExterioresConstruccionSeg', difFchFinalExterioresConstruccion = '$difFchFinalExterioresConstruccion', porcIncExterioresConstruccionPry = '$porcIncExterioresConstruccionPry', porcIncExterioresConstruccionSeg = '$porcIncExterioresConstruccionSeg', difPorcIncExterioresConstruccion = '$difPorcIncExterioresConstruccion', valActExterioresConstruccionPry = '$valActExterioresConstruccionPry', valActExterioresConstruccionSeg = '$valActExterioresConstruccionSeg', difValActExterioresConstruccion = '$difValActExterioresConstruccion', fchInicialAseoConstruccionPry = '$fchInicialAseoConstruccionPry', fchInicialAseoConstruccionSeg = '$fchInicialAseoConstruccionSeg', difFchInicialAseoConstruccion = '$difFchInicialAseoConstruccion', fchFinalAseoConstruccionPry = '$fchFinalAseoConstruccionPry', fchFinalAseoConstruccionSeg = '$fchFinalAseoConstruccionSeg', difFchFinalAseoConstruccion = '$difFchFinalAseoConstruccion', porcIncAseoConstruccionPry = '$porcIncAseoConstruccionPry', porcIncAseoConstruccionSeg = '$porcIncAseoConstruccionSeg', difPorcIncAseoConstruccion = '$difPorcIncAseoConstruccion', valActAseoConstruccionPry = '$valActAseoConstruccionPry', valActAseoConstruccionSeg = '$valActAseoConstruccionSeg', difValActAseoConstruccion = '$difValActAseoConstruccion', fchInicialPreliminarUrbanismoPry = '$fchInicialPreliminarUrbanismoPry', fchInicialPreliminarUrbanismoSeg = '$fchInicialPreliminarUrbanismoSeg', difFchInicialPreliminarUrbanismo = '$difFchInicialPreliminarUrbanismo', fchFinalPreliminarUrbanismoPry = '$fchFinalPreliminarUrbanismoPry', fchFinalPreliminarUrbanismoSeg = '$fchFinalPreliminarUrbanismoSeg', difFchFinalPreliminarUrbanismo = '$difFchFinalPreliminarUrbanismo', porcIncPreliminarUrbanismoPry = '$porcIncPreliminarUrbanismoPry', porcIncPreliminarUrbanismoSeg = '$porcIncPreliminarUrbanismoSeg', difPorcIncPreliminarUrbanismo = '$difPorcIncPreliminarUrbanismo', valActPreliminarUrbanismoPry = '$valActPreliminarUrbanismoPry', valActPreliminarUrbanismoSeg = '$valActPreliminarUrbanismoSeg', difValActPreliminarUrbanismo = '$difValActPreliminarUrbanismo', fchInicialCimentacionUrbanismoPry = '$fchInicialCimentacionUrbanismoPry', fchInicialCimentacionUrbanismoSeg = '$fchInicialCimentacionUrbanismoSeg', difFchInicialCimentacionUrbanismo = '$difFchInicialCimentacionUrbanismo', fchFinalCimentacionUrbanismoPry = '$fchFinalCimentacionUrbanismoPry', fchFinalCimentacionUrbanismoSeg = '$fchFinalCimentacionUrbanismoSeg', difFchFinalCimentacionUrbanismo = '$difFchFinalCimentacionUrbanismo', porcIncCimentacionUrbanismoPry = '$porcIncCimentacionUrbanismoPry', porcIncCimentacionUrbanismoSeg = '$porcIncCimentacionUrbanismoSeg', difPorcIncCimentacionUrbanismo = '$difPorcIncCimentacionUrbanismo', valActCimentacionUrbanismoPry = '$valActCimentacionUrbanismoPry', valActCimentacionUrbanismoSeg = '$valActCimentacionUrbanismoSeg', difValActCimentacionUrbanismo = '$difValActCimentacionUrbanismo', fchInicialDesaguesUrbanismoPry = '$fchInicialDesaguesUrbanismoPry', fchInicialDesaguesUrbanismoSeg = '$fchInicialDesaguesUrbanismoSeg', difFchInicialDesaguesUrbanismo = '$difFchInicialDesaguesUrbanismo', fchFinalDesaguesUrbanismoPry = '$fchFinalDesaguesUrbanismoPry', fchFinalDesaguesUrbanismoSeg = '$fchFinalDesaguesUrbanismoSeg', difFchFinalDesaguesUrbanismo = '$difFchFinalDesaguesUrbanismo', porcIncDesaguesUrbanismoPry = '$porcIncDesaguesUrbanismoPry', porcIncDesaguesUrbanismoSeg = '$porcIncDesaguesUrbanismoSeg', difPorcIncDesaguesUrbanismo = '$difPorcIncDesaguesUrbanismo', valActDesaguesUrbanismoPry = '$valActDesaguesUrbanismoPry', valActDesaguesUrbanismoSeg = '$valActDesaguesUrbanismoSeg', difValActDesaguesUrbanismo = '$difValActDesaguesUrbanismo', fchInicialViasUrbanismoPry = '$fchInicialViasUrbanismoPry', fchInicialViasUrbanismoSeg = '$fchInicialViasUrbanismoSeg', difFchInicialViasUrbanismo = '$difFchInicialViasUrbanismo', fchFinalViasUrbanismoPry = '$fchFinalViasUrbanismoPry', fchFinalViasUrbanismoSeg = '$fchFinalViasUrbanismoSeg', difFchFinalViasUrbanismo = '$difFchFinalViasUrbanismo', porcIncViasUrbanismoPry = '$porcIncViasUrbanismoPry', porcIncViasUrbanismoSeg = '$porcIncViasUrbanismoSeg', difPorcIncViasUrbanismo = '$difPorcIncViasUrbanismo', valActViasUrbanismoPry = '$valActViasUrbanismoPry', valActViasUrbanismoSeg = '$valActViasUrbanismoSeg', difValActViasUrbanismo = '$difValActViasUrbanismo', fchInicialParquesUrbanismoPry = '$fchInicialParquesUrbanismoPry', fchInicialParquesUrbanismoSeg = '$fchInicialParquesUrbanismoSeg', difFchInicialParquesUrbanismo = '$difFchInicialParquesUrbanismo', fchFinalParquesUrbanismoPry = '$fchFinalParquesUrbanismoPry', fchFinalParquesUrbanismoSeg = '$fchFinalParquesUrbanismoSeg', difFchFinalParquesUrbanismo = '$difFchFinalParquesUrbanismo', porcIncParquesUrbanismoPry = '$porcIncParquesUrbanismoPry', porcIncParquesUrbanismoSeg = '$porcIncParquesUrbanismoSeg', difPorcIncParquesUrbanismo = '$difPorcIncParquesUrbanismo', valActParquesUrbanismoPry = '$valActParquesUrbanismoPry', valActParquesUrbanismoSeg = '$valActParquesUrbanismoSeg', difValActParquesUrbanismo = '$difValActParquesUrbanismo', fchInicialAseoUrbanismoPry = '$fchInicialAseoUrbanismoPry', fchInicialAseoUrbanismoSeg = '$fchInicialAseoUrbanismoSeg', difFchInicialAseoUrbanismo = '$difFchInicialAseoUrbanismo', fchFinalAseoUrbanismoPry = '$fchFinalAseoUrbanismoPry', fchFinalAseoUrbanismoSeg = '$fchFinalAseoUrbanismoSeg', difFchFinalAseoUrbanismo = '$difFchFinalAseoUrbanismo', porcIncAseoUrbanismoPry = '$porcIncAseoUrbanismoPry', porcIncAseoUrbanismoSeg = '$porcIncAseoUrbanismoSeg', difPorcIncAseoUrbanismo = '$difPorcIncAseoUrbanismo', valActAseoUrbanismoPry = '$valActAseoUrbanismoPry', valActAseoUrbanismoSeg = '$valActAseoUrbanismoSeg', difValActAseoUrbanismo = '$difValActAseoUrbanismo', fchGestion = '$fchGestion' WHERE seqSeguimientoCronogramaObras = $seqSeguimientoCronogramaObras AND seqProyecto = $seqProyecto; ";
                    //echo $query;
                } else {
                    $query = "INSERT INTO T_PRY_CRONOGRAMA_OBRAS_SEGUIMIENTO (seqProyecto, fchVisita, fchInicialTerrenoPry, fchInicialTerrenoSeg, difFchInicialTerreno, fchFinalTerrenoPry, fchFinalTerrenoSeg, difFchFinalTerreno, porcIncTerrenoPry, porcIncTerrenoSeg, difPorcIncTerreno, valActTerrenoPry, valActTerrenoSeg, difValActTerreno, fchInicialPreliminarConstruccionPry, fchInicialPreliminarConstruccionSeg, difFchInicialPreliminarConstruccion, fchFinalPreliminarConstruccionPry, fchFinalPreliminarConstruccionSeg, difFchFinalPreliminarConstruccion, porcIncPreliminarConstruccionPry, porcIncPreliminarConstruccionSeg, difPorcIncPreliminarConstruccion, valActPreliminarConstruccionPry, valActPreliminarConstruccionSeg, difValActPreliminarConstruccion, fchInicialCimentacionConstruccionPry, fchInicialCimentacionConstruccionSeg, difFchInicialCimentacionConstruccion, fchFinalCimentacionConstruccionPry, fchFinalCimentacionConstruccionSeg, difFchFinalCimentacionConstruccion, porcIncCimentacionConstruccionPry, porcIncCimentacionConstruccionSeg, difPorcIncCimentacionConstruccion, valActCimentacionConstruccionPry, valActCimentacionConstruccionSeg, difValActCimentacionConstruccion, fchInicialDesaguesConstruccionPry, fchInicialDesaguesConstruccionSeg, difFchInicialDesaguesConstruccion, fchFinalDesaguesConstruccionPry, fchFinalDesaguesConstruccionSeg, difFchFinalDesaguesConstruccion, porcIncDesaguesConstruccionPry, porcIncDesaguesConstruccionSeg, difPorcIncDesaguesConstruccion, valActDesaguesConstruccionPry, valActDesaguesConstruccionSeg, difValActDesaguesConstruccion, fchInicialEstructuraConstruccionPry, fchInicialEstructuraConstruccionSeg, difFchInicialEstructuraConstruccion, fchFinalEstructuraConstruccionPry, fchFinalEstructuraConstruccionSeg, difFchFinalEstructuraConstruccion, porcIncEstructuraConstruccionPry, porcIncEstructuraConstruccionSeg, difPorcIncEstructuraConstruccion, valActEstructuraConstruccionPry, valActEstructuraConstruccionSeg, difValActEstructuraConstruccion, fchInicialMamposteriaConstruccionPry, fchInicialMamposteriaConstruccionSeg, difFchInicialMamposteriaConstruccion, fchFinalMamposteriaConstruccionPry, fchFinalMamposteriaConstruccionSeg, difFchFinalMamposteriaConstruccion, porcIncMamposteriaConstruccionPry, porcIncMamposteriaConstruccionSeg, difPorcIncMamposteriaConstruccion, valActMamposteriaConstruccionPry, valActMamposteriaConstruccionSeg, difValActMamposteriaConstruccion, fchInicialPanetesConstruccionPry, fchInicialPanetesConstruccionSeg, difFchInicialPanetesConstruccion, fchFinalPanetesConstruccionPry, fchFinalPanetesConstruccionSeg, difFchFinalPanetesConstruccion, porcIncPanetesConstruccionPry, porcIncPanetesConstruccionSeg, difPorcIncPanetesConstruccion, valActPanetesConstruccionPry, valActPanetesConstruccionSeg, difValActPanetesConstruccion, fchInicialHidrosanitariasConstruccionPry, fchInicialHidrosanitariasConstruccionSeg, difFchInicialHidrosanitariasConstruccion, fchFinalHidrosanitariasConstruccionPry, fchFinalHidrosanitariasConstruccionSeg, difFchFinalHidrosanitariasConstruccion, porcIncHidrosanitariasConstruccionPry, porcIncHidrosanitariasConstruccionSeg, difPorcIncHidrosanitariasConstruccion, valActHidrosanitariasConstruccionPry, valActHidrosanitariasConstruccionSeg, difValActHidrosanitariasConstruccion, fchInicialElectricasConstruccionPry, fchInicialElectricasConstruccionSeg, difFchInicialElectricasConstruccion, fchFinalElectricasConstruccionPry, fchFinalElectricasConstruccionSeg, difFchFinalElectricasConstruccion, porcIncElectricasConstruccionPry, porcIncElectricasConstruccionSeg, difPorcIncElectricasConstruccion, valActElectricasConstruccionPry, valActElectricasConstruccionSeg, difValActElectricasConstruccion, fchInicialCubiertaConstruccionPry, fchInicialCubiertaConstruccionSeg, difFchInicialCubiertaConstruccion, fchFinalCubiertaConstruccionPry, fchFinalCubiertaConstruccionSeg, difFchFinalCubiertaConstruccion, porcIncCubiertaConstruccionPry, porcIncCubiertaConstruccionSeg, difPorcIncCubiertaConstruccion, valActCubiertaConstruccionPry, valActCubiertaConstruccionSeg, difValActCubiertaConstruccion, fchInicialCarpinteriaConstruccionPry, fchInicialCarpinteriaConstruccionSeg, difFchInicialCarpinteriaConstruccion, fchFinalCarpinteriaConstruccionPry, fchFinalCarpinteriaConstruccionSeg, difFchFinalCarpinteriaConstruccion, porcIncCarpinteriaConstruccionPry, porcIncCarpinteriaConstruccionSeg, difPorcIncCarpinteriaConstruccion, valActCarpinteriaConstruccionPry, valActCarpinteriaConstruccionSeg, difValActCarpinteriaConstruccion, fchInicialPisosConstruccionPry, fchInicialPisosConstruccionSeg, difFchInicialPisosConstruccion, fchFinalPisosConstruccionPry, fchFinalPisosConstruccionSeg, difFchFinalPisosConstruccion, porcIncPisosConstruccionPry, porcIncPisosConstruccionSeg, difPorcIncPisosConstruccion, valActPisosConstruccionPry, valActPisosConstruccionSeg, difValActPisosConstruccion, fchInicialSanitariosConstruccionPry, fchInicialSanitariosConstruccionSeg, difFchInicialSanitariosConstruccion, fchFinalSanitariosConstruccionPry, fchFinalSanitariosConstruccionSeg, difFchFinalSanitariosConstruccion, porcIncSanitariosConstruccionPry, porcIncSanitariosConstruccionSeg, difPorcIncSanitariosConstruccion, valActSanitariosConstruccionPry, valActSanitariosConstruccionSeg, difValActSanitariosConstruccion, fchInicialExterioresConstruccionPry, fchInicialExterioresConstruccionSeg, difFchInicialExterioresConstruccion, fchFinalExterioresConstruccionPry, fchFinalExterioresConstruccionSeg, difFchFinalExterioresConstruccion, porcIncExterioresConstruccionPry, porcIncExterioresConstruccionSeg, difPorcIncExterioresConstruccion, valActExterioresConstruccionPry, valActExterioresConstruccionSeg, difValActExterioresConstruccion, fchInicialAseoConstruccionPry, fchInicialAseoConstruccionSeg, difFchInicialAseoConstruccion, fchFinalAseoConstruccionPry, fchFinalAseoConstruccionSeg, difFchFinalAseoConstruccion, porcIncAseoConstruccionPry, porcIncAseoConstruccionSeg, difPorcIncAseoConstruccion, valActAseoConstruccionPry, valActAseoConstruccionSeg, difValActAseoConstruccion, fchInicialPreliminarUrbanismoPry, fchInicialPreliminarUrbanismoSeg, difFchInicialPreliminarUrbanismo, fchFinalPreliminarUrbanismoPry, fchFinalPreliminarUrbanismoSeg, difFchFinalPreliminarUrbanismo, porcIncPreliminarUrbanismoPry, porcIncPreliminarUrbanismoSeg, difPorcIncPreliminarUrbanismo, valActPreliminarUrbanismoPry, valActPreliminarUrbanismoSeg, difValActPreliminarUrbanismo, fchInicialCimentacionUrbanismoPry, fchInicialCimentacionUrbanismoSeg, difFchInicialCimentacionUrbanismo, fchFinalCimentacionUrbanismoPry, fchFinalCimentacionUrbanismoSeg, difFchFinalCimentacionUrbanismo, porcIncCimentacionUrbanismoPry, porcIncCimentacionUrbanismoSeg, difPorcIncCimentacionUrbanismo, valActCimentacionUrbanismoPry, valActCimentacionUrbanismoSeg, difValActCimentacionUrbanismo, fchInicialDesaguesUrbanismoPry, fchInicialDesaguesUrbanismoSeg, difFchInicialDesaguesUrbanismo, fchFinalDesaguesUrbanismoPry, fchFinalDesaguesUrbanismoSeg, difFchFinalDesaguesUrbanismo, porcIncDesaguesUrbanismoPry, porcIncDesaguesUrbanismoSeg, difPorcIncDesaguesUrbanismo, valActDesaguesUrbanismoPry, valActDesaguesUrbanismoSeg, difValActDesaguesUrbanismo, fchInicialViasUrbanismoPry, fchInicialViasUrbanismoSeg, difFchInicialViasUrbanismo, fchFinalViasUrbanismoPry, fchFinalViasUrbanismoSeg, difFchFinalViasUrbanismo, porcIncViasUrbanismoPry, porcIncViasUrbanismoSeg, difPorcIncViasUrbanismo, valActViasUrbanismoPry, valActViasUrbanismoSeg, difValActViasUrbanismo, fchInicialParquesUrbanismoPry, fchInicialParquesUrbanismoSeg, difFchInicialParquesUrbanismo, fchFinalParquesUrbanismoPry, fchFinalParquesUrbanismoSeg, difFchFinalParquesUrbanismo, porcIncParquesUrbanismoPry, porcIncParquesUrbanismoSeg, difPorcIncParquesUrbanismo, valActParquesUrbanismoPry, valActParquesUrbanismoSeg, difValActParquesUrbanismo, fchInicialAseoUrbanismoPry, fchInicialAseoUrbanismoSeg, difFchInicialAseoUrbanismo, fchFinalAseoUrbanismoPry, fchFinalAseoUrbanismoSeg, difFchFinalAseoUrbanismo, porcIncAseoUrbanismoPry, porcIncAseoUrbanismoSeg, difPorcIncAseoUrbanismo, valActAseoUrbanismoPry, valActAseoUrbanismoSeg, difValActAseoUrbanismo, fchGestion) VALUES ('$seqProyecto', '$fchVisita', '$fchInicialTerrenoPry', '$fchInicialTerrenoSeg', '$difFchInicialTerreno', '$fchFinalTerrenoPry', '$fchFinalTerrenoSeg', '$difFchFinalTerreno', '$porcIncTerrenoPry', '$porcIncTerrenoSeg', '$difPorcIncTerreno', '$valActTerrenoPry', '$valActTerrenoSeg', '$difValActTerreno', '$fchInicialPreliminarConstruccionPry', '$fchInicialPreliminarConstruccionSeg', '$difFchInicialPreliminarConstruccion', '$fchFinalPreliminarConstruccionPry', '$fchFinalPreliminarConstruccionSeg', '$difFchFinalPreliminarConstruccion', '$porcIncPreliminarConstruccionPry', '$porcIncPreliminarConstruccionSeg', '$difPorcIncPreliminarConstruccion', '$valActPreliminarConstruccionPry', '$valActPreliminarConstruccionSeg', '$difValActPreliminarConstruccion', '$fchInicialCimentacionConstruccionPry', '$fchInicialCimentacionConstruccionSeg', '$difFchInicialCimentacionConstruccion', '$fchFinalCimentacionConstruccionPry', '$fchFinalCimentacionConstruccionSeg', '$difFchFinalCimentacionConstruccion', '$porcIncCimentacionConstruccionPry', '$porcIncCimentacionConstruccionSeg', '$difPorcIncCimentacionConstruccion', '$valActCimentacionConstruccionPry', '$valActCimentacionConstruccionSeg', '$difValActCimentacionConstruccion', '$fchInicialDesaguesConstruccionPry', '$fchInicialDesaguesConstruccionSeg', '$difFchInicialDesaguesConstruccion', '$fchFinalDesaguesConstruccionPry', '$fchFinalDesaguesConstruccionSeg', '$difFchFinalDesaguesConstruccion', '$porcIncDesaguesConstruccionPry', '$porcIncDesaguesConstruccionSeg', '$difPorcIncDesaguesConstruccion', '$valActDesaguesConstruccionPry', '$valActDesaguesConstruccionSeg', '$difValActDesaguesConstruccion', '$fchInicialEstructuraConstruccionPry', '$fchInicialEstructuraConstruccionSeg', '$difFchInicialEstructuraConstruccion', '$fchFinalEstructuraConstruccionPry', '$fchFinalEstructuraConstruccionSeg', '$difFchFinalEstructuraConstruccion', '$porcIncEstructuraConstruccionPry', '$porcIncEstructuraConstruccionSeg', '$difPorcIncEstructuraConstruccion', '$valActEstructuraConstruccionPry', '$valActEstructuraConstruccionSeg', '$difValActEstructuraConstruccion', '$fchInicialMamposteriaConstruccionPry', '$fchInicialMamposteriaConstruccionSeg', '$difFchInicialMamposteriaConstruccion', '$fchFinalMamposteriaConstruccionPry', '$fchFinalMamposteriaConstruccionSeg', '$difFchFinalMamposteriaConstruccion', '$porcIncMamposteriaConstruccionPry', '$porcIncMamposteriaConstruccionSeg', '$difPorcIncMamposteriaConstruccion', '$valActMamposteriaConstruccionPry', '$valActMamposteriaConstruccionSeg', '$difValActMamposteriaConstruccion', '$fchInicialPanetesConstruccionPry', '$fchInicialPanetesConstruccionSeg', '$difFchInicialPanetesConstruccion', '$fchFinalPanetesConstruccionPry', '$fchFinalPanetesConstruccionSeg', '$difFchFinalPanetesConstruccion', '$porcIncPanetesConstruccionPry', '$porcIncPanetesConstruccionSeg', '$difPorcIncPanetesConstruccion', '$valActPanetesConstruccionPry', '$valActPanetesConstruccionSeg', '$difValActPanetesConstruccion', '$fchInicialHidrosanitariasConstruccionPry', '$fchInicialHidrosanitariasConstruccionSeg', '$difFchInicialHidrosanitariasConstruccion', '$fchFinalHidrosanitariasConstruccionPry', '$fchFinalHidrosanitariasConstruccionSeg', '$difFchFinalHidrosanitariasConstruccion', '$porcIncHidrosanitariasConstruccionPry', '$porcIncHidrosanitariasConstruccionSeg', '$difPorcIncHidrosanitariasConstruccion', '$valActHidrosanitariasConstruccionPry', '$valActHidrosanitariasConstruccionSeg', '$difValActHidrosanitariasConstruccion', '$fchInicialElectricasConstruccionPry', '$fchInicialElectricasConstruccionSeg', '$difFchInicialElectricasConstruccion', '$fchFinalElectricasConstruccionPry', '$fchFinalElectricasConstruccionSeg', '$difFchFinalElectricasConstruccion', '$porcIncElectricasConstruccionPry', '$porcIncElectricasConstruccionSeg', '$difPorcIncElectricasConstruccion', '$valActElectricasConstruccionPry', '$valActElectricasConstruccionSeg', '$difValActElectricasConstruccion', '$fchInicialCubiertaConstruccionPry', '$fchInicialCubiertaConstruccionSeg', '$difFchInicialCubiertaConstruccion', '$fchFinalCubiertaConstruccionPry', '$fchFinalCubiertaConstruccionSeg', '$difFchFinalCubiertaConstruccion', '$porcIncCubiertaConstruccionPry', '$porcIncCubiertaConstruccionSeg', '$difPorcIncCubiertaConstruccion', '$valActCubiertaConstruccionPry', '$valActCubiertaConstruccionSeg', '$difValActCubiertaConstruccion', '$fchInicialCarpinteriaConstruccionPry', '$fchInicialCarpinteriaConstruccionSeg', '$difFchInicialCarpinteriaConstruccion', '$fchFinalCarpinteriaConstruccionPry', '$fchFinalCarpinteriaConstruccionSeg', '$difFchFinalCarpinteriaConstruccion', '$porcIncCarpinteriaConstruccionPry', '$porcIncCarpinteriaConstruccionSeg', '$difPorcIncCarpinteriaConstruccion', '$valActCarpinteriaConstruccionPry', '$valActCarpinteriaConstruccionSeg', '$difValActCarpinteriaConstruccion', '$fchInicialPisosConstruccionPry', '$fchInicialPisosConstruccionSeg', '$difFchInicialPisosConstruccion', '$fchFinalPisosConstruccionPry', '$fchFinalPisosConstruccionSeg', '$difFchFinalPisosConstruccion', '$porcIncPisosConstruccionPry', '$porcIncPisosConstruccionSeg', '$difPorcIncPisosConstruccion', '$valActPisosConstruccionPry', '$valActPisosConstruccionSeg', '$difValActPisosConstruccion', '$fchInicialSanitariosConstruccionPry', '$fchInicialSanitariosConstruccionSeg', '$difFchInicialSanitariosConstruccion', '$fchFinalSanitariosConstruccionPry', '$fchFinalSanitariosConstruccionSeg', '$difFchFinalSanitariosConstruccion', '$porcIncSanitariosConstruccionPry', '$porcIncSanitariosConstruccionSeg', '$difPorcIncSanitariosConstruccion', '$valActSanitariosConstruccionPry', '$valActSanitariosConstruccionSeg', '$difValActSanitariosConstruccion', '$fchInicialExterioresConstruccionPry', '$fchInicialExterioresConstruccionSeg', '$difFchInicialExterioresConstruccion', '$fchFinalExterioresConstruccionPry', '$fchFinalExterioresConstruccionSeg', '$difFchFinalExterioresConstruccion', '$porcIncExterioresConstruccionPry', '$porcIncExterioresConstruccionSeg', '$difPorcIncExterioresConstruccion', '$valActExterioresConstruccionPry', '$valActExterioresConstruccionSeg', '$difValActExterioresConstruccion', '$fchInicialAseoConstruccionPry', '$fchInicialAseoConstruccionSeg', '$difFchInicialAseoConstruccion', '$fchFinalAseoConstruccionPry', '$fchFinalAseoConstruccionSeg', '$difFchFinalAseoConstruccion', '$porcIncAseoConstruccionPry', '$porcIncAseoConstruccionSeg', '$difPorcIncAseoConstruccion', '$valActAseoConstruccionPry', '$valActAseoConstruccionSeg', '$difValActAseoConstruccion', '$fchInicialPreliminarUrbanismoPry', '$fchInicialPreliminarUrbanismoSeg', '$difFchInicialPreliminarUrbanismo', '$fchFinalPreliminarUrbanismoPry', '$fchFinalPreliminarUrbanismoSeg', '$difFchFinalPreliminarUrbanismo', '$porcIncPreliminarUrbanismoPry', '$porcIncPreliminarUrbanismoSeg', '$difPorcIncPreliminarUrbanismo', '$valActPreliminarUrbanismoPry', '$valActPreliminarUrbanismoSeg', '$difValActPreliminarUrbanismo', '$fchInicialCimentacionUrbanismoPry', '$fchInicialCimentacionUrbanismoSeg', '$difFchInicialCimentacionUrbanismo', '$fchFinalCimentacionUrbanismoPry', '$fchFinalCimentacionUrbanismoSeg', '$difFchFinalCimentacionUrbanismo', '$porcIncCimentacionUrbanismoPry', '$porcIncCimentacionUrbanismoSeg', '$difPorcIncCimentacionUrbanismo', '$valActCimentacionUrbanismoPry', '$valActCimentacionUrbanismoSeg', '$difValActCimentacionUrbanismo', '$fchInicialDesaguesUrbanismoPry', '$fchInicialDesaguesUrbanismoSeg', '$difFchInicialDesaguesUrbanismo', '$fchFinalDesaguesUrbanismoPry', '$fchFinalDesaguesUrbanismoSeg', '$difFchFinalDesaguesUrbanismo', '$porcIncDesaguesUrbanismoPry', '$porcIncDesaguesUrbanismoSeg', '$difPorcIncDesaguesUrbanismo', '$valActDesaguesUrbanismoPry', '$valActDesaguesUrbanismoSeg', '$difValActDesaguesUrbanismo', '$fchInicialViasUrbanismoPry', '$fchInicialViasUrbanismoSeg', '$difFchInicialViasUrbanismo', '$fchFinalViasUrbanismoPry', '$fchFinalViasUrbanismoSeg', '$difFchFinalViasUrbanismo', '$porcIncViasUrbanismoPry', '$porcIncViasUrbanismoSeg', '$difPorcIncViasUrbanismo', '$valActViasUrbanismoPry', '$valActViasUrbanismoSeg', '$difValActViasUrbanismo', '$fchInicialParquesUrbanismoPry', '$fchInicialParquesUrbanismoSeg', '$difFchInicialParquesUrbanismo', '$fchFinalParquesUrbanismoPry', '$fchFinalParquesUrbanismoSeg', '$difFchFinalParquesUrbanismo', '$porcIncParquesUrbanismoPry', '$porcIncParquesUrbanismoSeg', '$difPorcIncParquesUrbanismo', '$valActParquesUrbanismoPry', '$valActParquesUrbanismoSeg', '$difValActParquesUrbanismo', '$fchInicialAseoUrbanismoPry', '$fchInicialAseoUrbanismoSeg', '$difFchInicialAseoUrbanismo', '$fchFinalAseoUrbanismoPry', '$fchFinalAseoUrbanismoSeg', '$difFchFinalAseoUrbanismo', '$porcIncAseoUrbanismoPry', '$porcIncAseoUrbanismoSeg', '$difPorcIncAseoUrbanismo', '$valActAseoUrbanismoPry', '$valActAseoUrbanismoSeg', '$difValActAseoUrbanismo', '$fchGestion' );";
                    //echo $query;
                }
                mysql_query($query);
            }
        }

        // Verifica cuales Tipos de Vivienda se pueden eliminar despues de cruzar los existentes contra los que llegan por POST
        $arrRegistrosBorrar = array_diff($arrExistentes, $arrArregloPost);
        foreach ($arrRegistrosBorrar as $restante) {
            $query = "DELETE FROM T_PRY_CRONOGRAMA_OBRAS_SEGUIMIENTO WHERE seqSeguimientoCronogramaObras = $restante;";
            //echo $query;
            mysql_query($query);
        }
    }

// FIN GESTIONA SEGUIMIENTOS AL CRONOGRAMA DE OBRAS
    // Función que retorna el seqUnidadProyecto dado un número de documento
    public function unidadVinculada($numCedula) {
        global $aptBd;
        $seqUnidadProyecto = 0;
        $sql = "SELECT seqUnidadProyecto FROM T_CIU_CIUDADANO INNER JOIN T_FRM_HOGAR ON (T_CIU_CIUDADANO.seqCiudadano = T_FRM_HOGAR.seqCiudadano) 
				INNER JOIN T_PRY_UNIDAD_PROYECTO ON (T_FRM_HOGAR.seqFormulario = T_PRY_UNIDAD_PROYECTO.seqFormulario)
				WHERE seqParentesco = 1
				AND numDocumento = $numCedula";
        try {
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $seqUnidadProyecto = $objRes->fields['seqUnidadProyecto'];
            }
        } catch (Exception $objError) {
            
        }
        return $seqUnidadProyecto;
    }

    // Función que verifica si una unidad proyecto tiene estudio tecnico
    public function estudioTecnicoUnidad($unidad) {
        global $aptBd;
        $sql = "SELECT seqTecnicoUnidad 
				FROM T_PRY_TECNICO
				WHERE seqUnidadProyecto = $unidad";
        try {
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $seqTecnicoUnidad = $objRes->fields['seqTecnicoUnidad'];
            }
        } catch (Exception $objError) {
            
        }
        return $seqTecnicoUnidad;
    }

}

// Fin clase
?>