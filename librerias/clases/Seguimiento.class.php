    <?php

/**
 * CLASE QUE REALIZA TODAS LAS OPERACIONES DE SEGUIMIENTO
 * @author bzerdar
 * @version 1.0 Septiembre 2009
 */
class Seguimiento {

    public $seqSeguimiento;
    public $seqGrupoGestion;
    public $seqGestion;
    public $fchInicial;
    public $fchFinal;
    public $txtComentario;
    public $bolCambios;
    public $txtCriterio;
    public $seqFormulario;
    public $arrErrores;
    public $arrIgnorarCampos;

    private $arrConversionCampos;
    private $txtSeparador;
    private $txtSalto;

    function Seguimiento() {

        $this->txtSeparador = str_repeat("&nbsp;", 5);
        $this->txtSalto = "<br>";

        $this->seqSeguimiento = 0;
        $this->seqGrupoGestion = 0;
        $this->seqGestion = 0;
        $this->fchInicial = null;
        $this->fchFinal = null;
        $this->txtComentario = "";
        $this->txtCambios = null;
        $this->txtCriterio = null;
        $this->seqFormulario = 0;
        $this->arrIgnorarCampos = array();
        $this->arrErrores = array();

        // CONVERSION DE CAMPOS PARA EL CIUDADANO
        $this->arrConversionCampos['bolCertificadoElectoral']['nombre'] = "Certificado Electoral";
        $this->arrConversionCampos['bolCertificadoElectoral']['tabla'] = "BOOLEANO";
        $this->arrConversionCampos['bolBeneficiario']['nombre'] = "Beneficiario";
        $this->arrConversionCampos['bolBeneficiario']['tabla'] = "BOOLEANO";
        $this->arrConversionCampos['bolLgtb']['nombre'] = "LGTB";
        $this->arrConversionCampos['bolLgtb']['tabla'] = "BOOLEANO";
        $this->arrConversionCampos['fchNacimiento']['nombre'] = "Fecha de Nacimiento";
        $this->arrConversionCampos['fchNacimiento']['tabla'] = "";
        $this->arrConversionCampos['numDocumento']['nombre'] = "Numero de Documento";
        $this->arrConversionCampos['numDocumento']['tabla'] = "";
        $this->arrConversionCampos['seqCajaCompensacion']['nombre'] = "Caja de Compensacion";
        $this->arrConversionCampos['seqCajaCompensacion']['tabla'] = "T_CIU_CAJA_COMPENSACION";
        $this->arrConversionCampos['seqCondicionEspecial']['nombre'] = "Condicion Especial 1";
        $this->arrConversionCampos['seqCondicionEspecial']['tabla'] = "T_CIU_CONDICION_ESPECIAL";
        $this->arrConversionCampos['seqCondicionEspecial2']['nombre'] = "Condicion Especial 2";
        $this->arrConversionCampos['seqCondicionEspecial2']['tabla'] = "T_CIU_CONDICION_ESPECIAL";
        $this->arrConversionCampos['seqCondicionEspecial3']['nombre'] = "Condicion Especial 3";
        $this->arrConversionCampos['seqCondicionEspecial3']['tabla'] = "T_CIU_CONDICION_ESPECIAL";
        $this->arrConversionCampos['seqEstadoCivil']['nombre'] = "Estado Civil";
        $this->arrConversionCampos['seqEstadoCivil']['tabla'] = "T_CIU_ESTADO_CIVIL";
        $this->arrConversionCampos['seqEtnia']['nombre'] = "Etnia";
        $this->arrConversionCampos['seqEtnia']['tabla'] = "T_CIU_ETNIA";
        $this->arrConversionCampos['seqNivelEducativo']['nombre'] = "Nivel Educativo";
        $this->arrConversionCampos['seqNivelEducativo']['tabla'] = "T_CIU_NIVEL_EDUCATIVO";
        $this->arrConversionCampos['seqOcupacion']['nombre'] = "Ocupacion";
        $this->arrConversionCampos['seqOcupacion']['tabla'] = "T_CIU_OCUPACION";
        $this->arrConversionCampos['seqParentesco']['nombre'] = "Parentesco";
        $this->arrConversionCampos['seqParentesco']['tabla'] = "T_CIU_PARENTESCO";
        $this->arrConversionCampos['seqSalud']['nombre'] = "Salud";
        $this->arrConversionCampos['seqSalud']['tabla'] = "T_CIU_SALUD";
        $this->arrConversionCampos['seqSexo']['nombre'] = "Sexo";
        $this->arrConversionCampos['seqSexo']['tabla'] = "T_CIU_SEXO";
        $this->arrConversionCampos['seqTipoDocumento']['nombre'] = "Tipo de Documento";
        $this->arrConversionCampos['seqTipoDocumento']['tabla'] = "T_CIU_TIPO_DOCUMENTO";
        $this->arrConversionCampos['txtApellido1']['nombre'] = "Primer Apellido";
        $this->arrConversionCampos['txtApellido1']['tabla'] = "";
        $this->arrConversionCampos['txtApellido2']['nombre'] = "Segundo Apellido";
        $this->arrConversionCampos['txtApellido2']['tabla'] = "";
        $this->arrConversionCampos['txtNombre1']['nombre'] = "Primer Nombre";
        $this->arrConversionCampos['txtNombre1']['tabla'] = "";
        $this->arrConversionCampos['txtNombre2']['nombre'] = "Segundo Nombre";
        $this->arrConversionCampos['txtNombre2']['tabla'] = "";
        $this->arrConversionCampos['valIngresos']['nombre'] = "Ingresos del Ciudadano";
        $this->arrConversionCampos['valIngresos']['tabla'] = "";
        $this->arrConversionCampos['seqTipoVictima']['nombre'] = "Tipo de Victima";
        $this->arrConversionCampos['seqTipoVictima']['tabla'] = "T_FRM_TIPOVICTIMA";
        $this->arrConversionCampos['seqGrupoLgtbi']['nombre'] = "Grupo LGTBI";
        $this->arrConversionCampos['seqGrupoLgtbi']['tabla'] = "T_FRM_GRUPO_LGTBI";

        $this->arrConversionCampos['fchExpedicion']['nombre'] = "Fecha de expedición";
        $this->arrConversionCampos['txtEntidadDocumento']['nombre'] = "Entidad que expide el registro civil";
        $this->arrConversionCampos['numIndicativoSerial']['nombre'] = "Indicativo serial registro civil";
        $this->arrConversionCampos['numNotariaDocumento']['nombre'] = "Notaria registro civil";
        $this->arrConversionCampos['seqCiudadDocumento']['nombre'] = "Ciudad registro civil";
        $this->arrConversionCampos['numConsecutivoCasado']['nombre'] = "Consecutivo soporte estado civil";
        $this->arrConversionCampos['numNotariaCasado']['nombre'] = "Notaria soporte estado civil";
        $this->arrConversionCampos['seqCiudadCasado']['nombre'] = "Ciudad soporte estado civil";
        $this->arrConversionCampos['numConsecutivoCSCDL']['nombre'] = "Consecutivo soporte estado civil";
        $this->arrConversionCampos['txtEntidadCSCDL']['nombre'] = "Entidad soporte estado civil";
        $this->arrConversionCampos['seqCiudadCSCDL']['nombre'] = "Ciudad soporte estado civil";
        $this->arrConversionCampos['numNotariaCSCDL']['nombre'] = "Notaria soporte estado civil";
        $this->arrConversionCampos['numNotariaSoltero']['nombre'] = "Notaria soporte estado civil";
        $this->arrConversionCampos['seqCiudadSoltero']['nombre'] = "Ciudad soporte estado civil";
        $this->arrConversionCampos['txtCertificacionUnion']['nombre'] = "Tipo de certificado soporte estado civil";
        $this->arrConversionCampos['numConsecutivoUnion']['nombre'] = "Consecutivo soporte estado civil";
        $this->arrConversionCampos['txtEntidadUnion']['nombre'] = "Entidad soporte estado civil";
        $this->arrConversionCampos['numNotariaUnion']['nombre'] = "Notaria soporte estado civil";
        $this->arrConversionCampos['seqCiudadUnion']['nombre'] = "Ciudad soporte estado civil";

        $this->arrConversionCampos['fchExpedicion']['tabla'] = "";
        $this->arrConversionCampos['txtEntidadDocumento']['tabla'] = "";
        $this->arrConversionCampos['numIndicativoSerial']['tabla'] = "";
        $this->arrConversionCampos['numNotariaDocumento']['tabla'] = "";
        $this->arrConversionCampos['seqCiudadDocumento']['tabla'] = "T_FRM_CIUDAD";
        $this->arrConversionCampos['numConsecutivoCasado']['tabla'] = "";
        $this->arrConversionCampos['numNotariaCasado']['tabla'] = "";
        $this->arrConversionCampos['seqCiudadCasado']['tabla'] = "T_FRM_CIUDAD";
        $this->arrConversionCampos['numConsecutivoCSCDL']['tabla'] = "";
        $this->arrConversionCampos['txtEntidadCSCDL']['tabla'] = "";
        $this->arrConversionCampos['seqCiudadCSCDL']['tabla'] = "T_FRM_CIUDAD";
        $this->arrConversionCampos['numNotariaCSCDL']['tabla'] = "";
        $this->arrConversionCampos['numNotariaSoltero']['tabla'] = "";
        $this->arrConversionCampos['seqCiudadSoltero']['tabla'] = "T_FRM_CIUDAD";
        $this->arrConversionCampos['txtCertificacionUnion']['tabla'] = "";
        $this->arrConversionCampos['numConsecutivoUnion']['tabla'] = "";
        $this->arrConversionCampos['txtEntidadUnion']['tabla'] = "";
        $this->arrConversionCampos['numNotariaUnion']['tabla'] = "";
        $this->arrConversionCampos['seqCiudadUnion']['tabla'] = "T_FRM_CIUDAD";

        // CONVERSION DE CAMPOS PARA LOS DATOS DEL HOGAR
        $this->arrConversionCampos['bolCerrado']['nombre'] = "Formulario Cerrado";
        $this->arrConversionCampos['bolCerrado']['tabla'] = "BOOLEANO";
        $this->arrConversionCampos['bolDesplazado']['nombre'] = "Hogar Victima";
        $this->arrConversionCampos['bolDesplazado']['tabla'] = "BOOLEANO";
        $this->arrConversionCampos['numCelular']['nombre'] = "Celular";
        $this->arrConversionCampos['numCelular']['tabla'] = "";
        $this->arrConversionCampos['numTelefono1']['nombre'] = "Telefono 1";
        $this->arrConversionCampos['numTelefono1']['tabla'] = "";
        $this->arrConversionCampos['numTelefono2']['nombre'] = "Telefono 2";
        $this->arrConversionCampos['numTelefono2']['tabla'] = "";
        $this->arrConversionCampos['numHabitaciones']['nombre'] = "N° Hogares en la vivienda";
        $this->arrConversionCampos['numHabitaciones']['tabla'] = "";
        $this->arrConversionCampos['numHacinamiento']['nombre'] = "Número Dormitorios";
        $this->arrConversionCampos['numHacinamiento']['tabla'] = "";
        $this->arrConversionCampos['seqEstadoProceso']['nombre'] = "Estado del proceso";
        $this->arrConversionCampos['seqEstadoProceso']['tabla'] = "T_FRM_ESTADO_PROCESO";
        $this->arrConversionCampos['seqLocalidad']['nombre'] = "Localidad";
        $this->arrConversionCampos['seqLocalidad']['tabla'] = "T_FRM_LOCALIDAD";
        $this->arrConversionCampos['seqCiudad']['nombre'] = "Ciudad";
        $this->arrConversionCampos['seqCiudad']['tabla'] = "T_FRM_CIUDAD";
        $this->arrConversionCampos['seqBarrio']['nombre'] = "Barrio";
        $this->arrConversionCampos['seqBarrio']['tabla'] = "T_FRM_BARRIO";
        $this->arrConversionCampos['seqConvenio']['nombre'] = "Convenio";
        $this->arrConversionCampos['seqConvenio']['tabla'] = "T_FRM_CONVENIO";
        $this->arrConversionCampos['seqEntidadSubsidio']['nombre'] = "Entidad Subsidio";
        $this->arrConversionCampos['seqEntidadSubsidio']['tabla'] = "T_FRM_ENTIDAD_SUBSIDIO";
        $this->arrConversionCampos['seqPlanGobierno']['nombre'] = "Plan de Gobierno";
        $this->arrConversionCampos['seqPlanGobierno']['tabla'] = "T_FRM_PLAN_GOBIERNO";
        $this->arrConversionCampos['seqPuntoAtencion']['nombre'] = "Punto Atencion";
        $this->arrConversionCampos['seqPuntoAtencion']['tabla'] = "T_FRM_PUNTO_ATENCION";
        $this->arrConversionCampos['seqSisben']['nombre'] = "Sisben";
        $this->arrConversionCampos['seqSisben']['tabla'] = "T_FRM_SISBEN";
        $this->arrConversionCampos['seqUpz']['nombre'] = "UPZ";
        $this->arrConversionCampos['seqUpz']['tabla'] = "T_FRM_UPZ";
        $this->arrConversionCampos['seqVivienda']['nombre'] = "Vivienda Actual";
        $this->arrConversionCampos['seqVivienda']['tabla'] = "T_FRM_VIVIENDA";
        $this->arrConversionCampos['txtBarrio']['nombre'] = "Barrio";
        $this->arrConversionCampos['txtBarrio']['tabla'] = "";
        $this->arrConversionCampos['txtCorreo']['nombre'] = "Correo electronico";
        $this->arrConversionCampos['txtCorreo']['tabla'] = "";
        $this->arrConversionCampos['txtDireccion']['nombre'] = "Direccion de Residencia";
        $this->arrConversionCampos['txtDireccion']['tabla'] = "";
        $this->arrConversionCampos['txtFormulario']['nombre'] = "No.Formulario";
        $this->arrConversionCampos['txtFormulario']['tabla'] = "";
        $this->arrConversionCampos['valArriendo']['nombre'] = "Valor Arriendo";
        $this->arrConversionCampos['valArriendo']['tabla'] = "";
        $this->arrConversionCampos['valIngresoHogar']['nombre'] = "Ingresos del Hogar";
        $this->arrConversionCampos['valIngresoHogar']['tabla'] = "";
        $this->arrConversionCampos['fchArriendoDesde']['nombre'] = "Paga Arriendo Desde";
        $this->arrConversionCampos['fchArriendoDesde']['tabla'] = "";
        $this->arrConversionCampos['txtComprobanteArriendo']['nombre'] = "Comprobante Arriendo";
        $this->arrConversionCampos['txtComprobanteArriendo']['tabla'] = "";

        // CONVERSION DE LOS DATOS DE POSTULACION			
        $this->arrConversionCampos['bolPromesaFirmada']['nombre'] = "Tiene Promesa Firmada";
        $this->arrConversionCampos['bolPromesaFirmada']['tabla'] = "BOOLEANO";
        $this->arrConversionCampos['fchInscripcion']['nombre'] = "Fecha Inscripcion";
        $this->arrConversionCampos['fchInscripcion']['tabla'] = "";
        $this->arrConversionCampos['fchPostulacion']['nombre'] = "Fecha Postulacion";
        $this->arrConversionCampos['fchPostulacion']['tabla'] = "";
        $this->arrConversionCampos['fchUltimaActualizacion']['nombre'] = "Ultima Actualizacion";
        $this->arrConversionCampos['fchUltimaActualizacion']['tabla'] = "";
        $this->arrConversionCampos['numCortes']['nombre'] = "Cortes de Calificacion";
        $this->arrConversionCampos['numCortes']['tabla'] = "";
        $this->arrConversionCampos['seqModalidad']['nombre'] = "Modalidad";
        $this->arrConversionCampos['seqModalidad']['tabla'] = "T_FRM_MODALIDAD";
        $this->arrConversionCampos['seqProyecto']['nombre'] = "Proyecto";
        $this->arrConversionCampos['seqProyecto']['tabla'] = "T_PRY_PROYECTO";
        $this->arrConversionCampos['seqProyectoHijo']['nombre'] = "Conjunto Residencial";
        $this->arrConversionCampos['seqProyectoHijo']['tabla'] = "T_PRY_PROYECTO";
        $this->arrConversionCampos['seqUnidadProyecto']['nombre'] = "Unidad Proyecto";
        $this->arrConversionCampos['seqUnidadProyecto']['tabla'] = "T_PRY_UNIDAD_PROYECTO";
        $this->arrConversionCampos['seqSolucion']['nombre'] = "Solucion de Vivienda";
        $this->arrConversionCampos['seqSolucion']['tabla'] = "T_FRM_SOLUCION";
        $this->arrConversionCampos['txtChip']['nombre'] = "Chip";
        $this->arrConversionCampos['txtChip']['tabla'] = "";
        $this->arrConversionCampos['txtDireccionSolucion']['nombre'] = "Direccion de Solucion";
        $this->arrConversionCampos['txtDireccionSolucion']['tabla'] = "";
        $this->arrConversionCampos['txtMatriculaInmobiliaria']['nombre'] = "Matricula Inmobiliaria";
        $this->arrConversionCampos['txtMatriculaInmobiliaria']['tabla'] = "";
        $this->arrConversionCampos['bolSancion']['nombre'] = "Sancion";
        $this->arrConversionCampos['bolSancion']['tabla'] = "BOOLEANO";
        $this->arrConversionCampos['fchVigenciaSubsido']['nombre'] = "Fecha Vigencia Subsidio";
        $this->arrConversionCampos['fchVigenciaSubsido']['tabla'] = "";
        $this->arrConversionCampos['seqTipoEsquema']['nombre'] = "Esquema";
        $this->arrConversionCampos['seqTipoEsquema']['tabla'] = "T_PRY_TIPO_ESQUEMA";

        // CONVERSION DE LOS CAMPOS FINACIEROS
        $this->arrConversionCampos['bolInmovilizadoCuentaAhorro']['nombre'] = "Ahorro 1 Inmobilizado";
        $this->arrConversionCampos['bolInmovilizadoCuentaAhorro']['tabla'] = "BOOLEANO";
        $this->arrConversionCampos['bolInmovilizadoCuentaAhorro2']['nombre'] = "Ahorro 2 Inmobilizado";
        $this->arrConversionCampos['bolInmovilizadoCuentaAhorro2']['tabla'] = "BOOLEANO";
        $this->arrConversionCampos['fchAperturaCuentaAhorro']['nombre'] = "Fecha Apertura Ahorro 1";
        $this->arrConversionCampos['fchAperturaCuentaAhorro']['tabla'] = "";
        $this->arrConversionCampos['fchAperturaCuentaAhorro2']['nombre'] = "Fecha Apertura Ahorro 2";
        $this->arrConversionCampos['fchAperturaCuentaAhorro2']['tabla'] = "";
        $this->arrConversionCampos['fchAprobacionCredito']['nombre'] = "Fecha Vencimiento Credito";
        $this->arrConversionCampos['fchAprobacionCredito']['tabla'] = "";
        $this->arrConversionCampos['seqBancoCredito']['nombre'] = "Banco Credito";
        $this->arrConversionCampos['seqBancoCredito']['tabla'] = "T_FRM_BANCO";
        $this->arrConversionCampos['seqBancoCuentaAhorro']['nombre'] = "Banco Ahorro 1";
        $this->arrConversionCampos['seqBancoCuentaAhorro']['tabla'] = "T_FRM_BANCO";
        $this->arrConversionCampos['seqBancoCuentaAhorro2']['nombre'] = "Banco Ahorro 2";
        $this->arrConversionCampos['seqBancoCuentaAhorro2']['tabla'] = "T_FRM_BANCO";
        $this->arrConversionCampos['seqCesantias']['nombre'] = "Cesantias ";
        $this->arrConversionCampos['seqCesantias']['tabla'] = "T_FRM_CESANTIA";
        $this->arrConversionCampos['seqEmpresaDonante']['nombre'] = "Empresa Donante";
        $this->arrConversionCampos['seqEmpresaDonante']['tabla'] = "T_FRM_EMPRESA_DONANTE";
        $this->arrConversionCampos['txtSoporteCesantias']['nombre'] = "Soporte Cesantias";
        $this->arrConversionCampos['txtSoporteCesantias']['tabla'] = "";
        $this->arrConversionCampos['txtSoporteCredito']['nombre'] = "Soporte Credito";
        $this->arrConversionCampos['txtSoporteCredito']['tabla'] = "";
        $this->arrConversionCampos['txtSoporteCuentaAhorro']['nombre'] = "Soporte Ahorro 1";
        $this->arrConversionCampos['txtSoporteCuentaAhorro']['tabla'] = "";
        $this->arrConversionCampos['txtSoporteCuentaAhorro2']['nombre'] = "Soporte Ahorro 2";
        $this->arrConversionCampos['txtSoporteCuentaAhorro2']['tabla'] = "";
        $this->arrConversionCampos['txtSoporteDonacion']['nombre'] = "Soporte Donacion";
        $this->arrConversionCampos['txtSoporteDonacion']['tabla'] = "";
        $this->arrConversionCampos['txtSoporteSubsidioNacional']['nombre'] = "Soporte Otro Subsidio";
        $this->arrConversionCampos['txtSoporteSubsidioNacional']['tabla'] = "";
        $this->arrConversionCampos['valAspiraSubsidio']['nombre'] = "Valor Subsidio";
        $this->arrConversionCampos['valAspiraSubsidio']['tabla'] = "";
        $this->arrConversionCampos['valCredito']['nombre'] = "Valor Credito";
        $this->arrConversionCampos['valCredito']['tabla'] = "";
        $this->arrConversionCampos['valDonacion']['nombre'] = "Valor Donacion";
        $this->arrConversionCampos['valDonacion']['tabla'] = "";
        $this->arrConversionCampos['valSaldoCesantias']['nombre'] = "Valor Cesantias";
        $this->arrConversionCampos['valSaldoCesantias']['tabla'] = "";
        $this->arrConversionCampos['valSaldoCuentaAhorro']['nombre'] = "Valor Ahorro 1";
        $this->arrConversionCampos['valSaldoCuentaAhorro']['tabla'] = "";
        $this->arrConversionCampos['valSaldoCuentaAhorro2']['nombre'] = "Valor Ahorro 2";
        $this->arrConversionCampos['valSaldoCuentaAhorro2']['tabla'] = "";
        $this->arrConversionCampos['valSubsidioNacional']['nombre'] = "Valor Otro Subsidio";
        $this->arrConversionCampos['valSubsidioNacional']['tabla'] = "";
        $this->arrConversionCampos['valTotalRecursos']['nombre'] = "Valor Total Recursos";
        $this->arrConversionCampos['valTotalRecursos']['tabla'] = "";
        $this->arrConversionCampos['valAporteLote']['nombre'] = "Acuerdo Pago Lote Terreno";
        $this->arrConversionCampos['valAporteLote']['tabla'] = "";
        $this->arrConversionCampos['txtSoporteAporteLote']['nombre'] = "Soporte Acuerdo Pago Lote Terreno";
        $this->arrConversionCampos['txtSoporteAporteLote']['tabla'] = "";

        $this->arrTipoDato['bolBeneficiario'] = 'booleano';
        $this->arrTipoDato['bolCerrado'] = 'booleano';
        $this->arrTipoDato['bolCertificadoElectoral'] = 'booleano';
        $this->arrTipoDato['bolDesplazado'] = 'booleano';
        $this->arrTipoDato['bolIdentificada'] = 'booleano';
        $this->arrTipoDato['bolInmovilizadoCuentaAhorro'] = 'booleano';
        $this->arrTipoDato['bolInmovilizadoCuentaAhorro2'] = 'booleano';
        $this->arrTipoDato['bolIntegracionSocial'] = 'booleano';
        $this->arrTipoDato['bolIpes'] = 'booleano';
        $this->arrTipoDato['bolLgtb'] = 'booleano';
        $this->arrTipoDato['bolPromesaFirmada'] = 'booleano';
        $this->arrTipoDato['bolSancion'] = 'booleano';
        $this->arrTipoDato['bolSecEducacion'] = 'booleano';
        $this->arrTipoDato['bolSecSalud'] = 'booleano';
        $this->arrTipoDato['bolViabilizada'] = 'booleano';
        $this->arrTipoDato['fchAperturaCuentaAhorro'] = 'fecha';
        $this->arrTipoDato['fchAperturaCuentaAhorro2'] = 'fecha';
        $this->arrTipoDato['fchAprobacionCredito'] = 'fecha';
        $this->arrTipoDato['fchArriendoDesde'] = 'fecha';
        $this->arrTipoDato['fchInscripcion'] = 'fecha';
        $this->arrTipoDato['fchNacimiento'] = 'fecha';
        $this->arrTipoDato['fchNotificacion'] = 'fecha';
        $this->arrTipoDato['fchPostulacion'] = 'fecha';
        $this->arrTipoDato['fchUltimaActualizacion'] = 'fecha';
        $this->arrTipoDato['fchVencimiento'] = 'fecha';
        $this->arrTipoDato['fchVigencia'] = 'fecha';
        $this->arrTipoDato['numAdultosNucleo'] = 'numero';
        $this->arrTipoDato['numCelular'] = 'numero';
        $this->arrTipoDato['numCortes'] = 'numero';
        $this->arrTipoDato['numDocumento'] = 'numero';
        $this->arrTipoDato['numHabitaciones'] = 'numero';
        $this->arrTipoDato['numHacinamiento'] = 'numero';
        $this->arrTipoDato['numNinosNucleo'] = 'numero';
        $this->arrTipoDato['numPuntajeSisben'] = 'numero';
        $this->arrTipoDato['numTelefono1'] = 'numero';
        $this->arrTipoDato['numTelefono2'] = 'numero';
        $this->arrTipoDato['seqBancoCredito'] = 'numero';
        $this->arrTipoDato['seqBancoCuentaAhorro'] = 'numero';
        $this->arrTipoDato['seqBancoCuentaAhorro2'] = 'numero';
        $this->arrTipoDato['seqBarrio'] = 'numero';
        $this->arrTipoDato['seqCajaCompensacion'] = 'numero';
        $this->arrTipoDato['seqCesantias'] = 'numero';
        $this->arrTipoDato['seqCiudad'] = 'numero';
        $this->arrTipoDato['seqCondicionEspecial'] = 'numero';
        $this->arrTipoDato['seqCondicionEspecial2'] = 'numero';
        $this->arrTipoDato['seqCondicionEspecial3'] = 'numero';
        $this->arrTipoDato['seqEmpresaDonante'] = 'numero';
        $this->arrTipoDato['seqEstadoCivil'] = 'numero';
        $this->arrTipoDato['seqEstadoProceso'] = 'numero';
        $this->arrTipoDato['seqEtnia'] = 'numero';
        $this->arrTipoDato['seqGrupoLgtbi'] = 'numero';
        $this->arrTipoDato['seqLocalidad'] = 'numero';
        $this->arrTipoDato['seqModalidad'] = 'numero';
        $this->arrTipoDato['seqNivelEducativo'] = 'numero';
        $this->arrTipoDato['seqOcupacion'] = 'numero';
        $this->arrTipoDato['seqParentesco'] = 'numero';
        $this->arrTipoDato['seqPeriodo'] = 'numero';
        $this->arrTipoDato['seqPlanGobierno'] = 'numero';
        $this->arrTipoDato['seqProyecto'] = 'numero';
        $this->arrTipoDato['seqProyectoHijo'] = 'numero';
        $this->arrTipoDato['seqUnidadProyecto'] = 'numero';
        $this->arrTipoDato['seqTipoEsquema'] = 'numero';
        $this->arrTipoDato['seqPlanGobierno'] = 'numero';
        $this->arrTipoDato['seqPuntoAtencion'] = 'numero';
        $this->arrTipoDato['seqSalud'] = 'numero';
        $this->arrTipoDato['seqSexo'] = 'numero';
        $this->arrTipoDato['seqSisben'] = 'numero';
        $this->arrTipoDato['seqSolucion'] = 'numero';
        $this->arrTipoDato['seqTipoDireccion'] = 'numero';
        $this->arrTipoDato['seqTipoDocumento'] = 'numero';
        $this->arrTipoDato['seqTipoVictima'] = 'numero';
        $this->arrTipoDato['seqUpz'] = 'numero';
        $this->arrTipoDato['seqUsuario'] = 'numero';
        $this->arrTipoDato['seqVivienda'] = 'numero';
        $this->arrTipoDato['txtApellido1'] = 'texto';
        $this->arrTipoDato['txtApellido2'] = 'texto';
        $this->arrTipoDato['txtBarrio'] = 'texto';
        $this->arrTipoDato['txtChip'] = 'texto';
        $this->arrTipoDato['txtComprobanteArriendo'] = 'texto';
        $this->arrTipoDato['txtCorreo'] = 'texto';
        $this->arrTipoDato['txtDireccion'] = 'texto';
        $this->arrTipoDato['txtDireccionSolucion'] = 'texto';
        $this->arrTipoDato['txtFormulario'] = 'texto';
        $this->arrTipoDato['txtMatriculaInmobiliaria'] = 'texto';
        $this->arrTipoDato['txtNombre1'] = 'texto';
        $this->arrTipoDato['txtNombre2'] = 'texto';
        $this->arrTipoDato['txtOtro'] = 'texto';
        $this->arrTipoDato['txtSoporteAporteLote'] = 'texto';
        $this->arrTipoDato['txtSoporteAporteMateriales'] = 'texto';
        $this->arrTipoDato['txtSoporteAvanceObra'] = 'texto';
        $this->arrTipoDato['txtSoporteCesantias'] = 'texto';
        $this->arrTipoDato['txtSoporteCredito'] = 'texto';
        $this->arrTipoDato['txtSoporteCuentaAhorro'] = 'texto';
        $this->arrTipoDato['txtSoporteCuentaAhorro2'] = 'texto';
        $this->arrTipoDato['txtSoporteDonacion'] = 'texto';
        $this->arrTipoDato['txtSoporteSubsidio'] = 'texto';
        $this->arrTipoDato['txtSoporteSubsidioNacional'] = 'texto';
        $this->arrTipoDato['valAporteAvanceObra'] = 'numero';
        $this->arrTipoDato['valAporteLote'] = 'numero';
        $this->arrTipoDato['valAporteMateriales'] = 'numero';
        $this->arrTipoDato['valArriendo'] = 'numero';
        $this->arrTipoDato['valAspiraSubsidio'] = 'numero';
        $this->arrTipoDato['valAvaluo'] = 'numero';
        $this->arrTipoDato['valCredito'] = 'numero';
        $this->arrTipoDato['valDonacion'] = 'numero';
        $this->arrTipoDato['valIngresoHogar'] = 'numero';
        $this->arrTipoDato['valIngresos'] = 'numero';
        $this->arrTipoDato['valPresupuesto'] = 'numero';
        $this->arrTipoDato['valSaldoCesantias'] = 'numero';
        $this->arrTipoDato['valSaldoCuentaAhorro'] = 'numero';
        $this->arrTipoDato['valSaldoCuentaAhorro2'] = 'numero';
        $this->arrTipoDato['valSubsidioNacional'] = 'numero';
        $this->arrTipoDato['valTotal'] = 'numero';
        $this->arrTipoDato['valTotalRecursos'] = 'numero';
    }

    function obtenerRegistros($numLimite = 0, $numInicia = 0) {
        global $aptBd;

        $arrConversion["txtBancoCuentaAhorro "] = "txtBanco";

        $arrRegistros = array();

        $txtCondicion = ( $this->seqSeguimiento != 0 ) ? "AND seg.seqSeguimiento = " . $this->seqSeguimiento . " " : "";
        $txtCondicion .= ( $this->seqGrupoGestion != 0 ) ? "AND gge.seqGrupoGestion = " . $this->seqGrupoGestion . " " : "";
        $txtCondicion .= ( $this->seqGestion != 0 ) ? "AND ges.seqGestion = " . $this->seqGestion . " " : "";
        $txtCondicion .= ( $this->fchInicial != "" ) ? "AND seg.fchMovimiento >= '" . $this->fchInicial . " 00:00:00' " : "";
        $txtCondicion .= ( $this->fchFinal != "" ) ? "AND seg.fchMovimiento <= '" . $this->fchFinal . " 23:59:59' " : "";

        if (trim($this->txtComentario) != "") {
            switch ($this->txtCriterio) {
                case "inicia":
                    $txtCondicion .= "AND seg.txtComentario LIKE '" . $this->txtComentario . "%' ";
                    break;
                case "termina":
                    $txtCondicion .= "AND seg.txtComentario LIKE '%" . $this->txtComentario . "' ";
                    break;
                case "contiene":
                    $txtCondicion .= "AND seg.txtComentario LIKE '%" . $this->txtComentario . "%' ";
                    break;
                default:
                    $txtCondicion .= "AND seg.txtComentario = '" . $this->txtComentario . "' ";
                    break;
            }
        }

        if ($this->txtCambios != "") {
            switch ($this->txtCambios) {
                case "si":
                    $txtCondicion .= "AND seg.txtCambios <> ''";
                    break;
                case "no":
                    $txtCondicion .= "AND seg.txtCambios = ''";
                    break;
                case "ambos":
                    $txtCondicion .= "";
                    break;
                default:
                    $txtCondicion .= "";
                    break;
            }
        }

        $txtCondicion .= "AND seg.seqFormulario = " . $this->seqFormulario . " ";

        $txtLimite = "";
        if ($numLimite != 0) {
            $txtLimite .= "LIMIT ";
            if ($numInicia != 0) {
                $txtLimite .= "$numInicia , $numLimite";
            } else {
                $txtLimite .= "$numLimite";
            }
        }

        $sql = "	
            SELECT 
               seg.seqSeguimiento,
               seg.seqFormulario,
               seg.fchMovimiento,
               ucwords(gge.txtGrupoGestion) as txtGrupoGestion,
               ucwords(ges.txtGestion) as txtGestion,
               ucwords( CONCAT( usu.txtNombre , ' ' , usu.txtApellido ) ) as txtUsuario,
               seg.txtComentario as txtComentario,
               seg.txtCambios,
               seg.numDocumento as numAtendido,
               ucwords( seg.txtNombre ) as txtAtendido
            FROM 
               T_SEG_SEGUIMIENTO seg,
               T_SEG_GESTION ges,
               T_SEG_GRUPO_GESTION gge,
               T_COR_USUARIO usu
            WHERE seg.seqGestion = ges.seqGestion
            AND ges.seqGrupoGestion = gge.seqGrupoGestion
            AND seg.seqUsuario = usu.seqUsuario
            AND seg.bolMostrar = 1
            $txtCondicion 	
            ORDER BY seg.seqSeguimiento DESC
            $txtLimite
         ";

        try {
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $seqSeguimiento = $objRes->fields['seqSeguimiento'];
                unset($objRes->fields['seqSeguimiento']);
                $arrRegistros[$seqSeguimiento] = $objRes->fields;
                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se han podido consultar los movimientos del hogar, hubo un error al consultar los datos";
        }


        return $arrRegistros;
    }

    /*******************************************************************************************************
     * Función Creada por Ing Liliana Basto pata obtener los registros de cada Acto Administrativo
     * **************************************************************************************************** */

    function obtenerRegistrosActos($numLimite = 0, $numInicia = 0) {
        global $aptBd;

        $arrConversion["txtBancoCuentaAhorro "] = "txtBanco";

        $arrRegistros = array();

        $txtCondicion = ( $this->seqSeguimiento != 0 ) ? "AND seg.seqSeguimiento = " . $this->seqSeguimiento . " " : "";
        $txtCondicion .= ( $this->seqGrupoGestion != 0 ) ? "AND gge.seqGrupoGestion = " . $this->seqGrupoGestion . " " : "";
        $txtCondicion .= ( $this->seqGestion != 0 ) ? "AND ges.seqGestion = " . $this->seqGestion . " " : "";
        $txtCondicion .= ( $this->fchInicial != "" ) ? "AND seg.fchMovimiento >= '" . $this->fchInicial . " 00:00:00' " : "";
        $txtCondicion .= ( $this->fchFinal != "" ) ? "AND seg.fchMovimiento <= '" . $this->fchFinal . " 23:59:59' " : "";

        if (trim($this->txtComentario) != "") {
            switch ($this->txtCriterio) {
                case "inicia":
                    $txtCondicion .= "AND seg.txtComentario LIKE '" . $this->txtComentario . "%' ";
                    break;
                case "termina":
                    $txtCondicion .= "AND seg.txtComentario LIKE '%" . $this->txtComentario . "' ";
                    break;
                case "contiene":
                    $txtCondicion .= "AND seg.txtComentario LIKE '%" . $this->txtComentario . "%' ";
                    break;
                default:
                    $txtCondicion .= "AND seg.txtComentario = '" . $this->txtComentario . "' ";
                    break;
            }
        }

        if ($this->txtCambios != "") {
            switch ($this->txtCambios) {
                case "si":
                    $txtCondicion .= "AND seg.txtCambios <> ''";
                    break;
                case "no":
                    $txtCondicion .= "AND seg.txtCambios = ''";
                    break;
                case "ambos":
                    $txtCondicion .= "";
                    break;
                default:
                    $txtCondicion .= "";
                    break;
            }
        }

        $txtCondicion .= "AND seg.seqFormulario = " . $this->seqFormularioActo . " ";

        $txtLimite = "";
        if ($numLimite != 0) {
            $txtLimite .= "LIMIT ";
            if ($numInicia != 0) {
                $txtLimite .= "$numInicia , $numLimite";
            } else {
                $txtLimite .= "$numLimite";
            }
        }

        $sql = "	
            SELECT 
               seg.seqSeguimiento,
               seg.seqFormulario,
               seg.fchMovimiento,
               ucwords(gge.txtGrupoGestion) as txtGrupoGestion,
               ucwords(ges.txtGestion) as txtGestion,
               ucwords( CONCAT( usu.txtNombre , ' ' , usu.txtApellido ) ) as txtUsuario,
               seg.txtComentario as txtComentario,
               seg.txtCambios,
               seg.numDocumento as numAtendido,
               ucwords( seg.txtNombre ) as txtAtendido
            FROM 
               T_SEG_SEGUIMIENTO seg,
               T_SEG_GESTION ges,
               T_SEG_GRUPO_GESTION gge,
               T_COR_USUARIO usu
            WHERE seg.seqGestion = ges.seqGestion
            AND ges.seqGrupoGestion = gge.seqGrupoGestion
            AND seg.seqUsuario = usu.seqUsuario
            AND seg.bolMostrar = 2
            $txtCondicion 	
            ORDER BY seg.seqSeguimiento DESC
            $txtLimite
         ";

        try {
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $seqSeguimiento = $objRes->fields['seqSeguimiento'];
                unset($objRes->fields['seqSeguimiento']);
                $arrRegistros[$seqSeguimiento] = $objRes->fields;
                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se han podido consultar los movimientos del hogar, hubo un error al consultar los datos";
        }


        return $arrRegistros;
    }

    function parserTextoCambios($txtTextoCambio) {


        // se reemplaza el tabulador por los espacios
        $txtTabulador = str_repeat("&nbsp;", 5);

        // Salto de linea sobrante
        $txtTextoCambio = trim($txtTextoCambio, "\n");

        // Separacion por lineas
        $arrLineas = split("\n", $txtTextoCambio);

        // Separacion campo - valores
        foreach ($arrLineas as $numLinea => $txtLinea) {
            $arrLinea = split(",", $txtLinea);
            $arrLineas[$numLinea] = array();
            if (count($arrLinea) == 1) {
                $arrLineas[$numLinea][0] = "<b>" . ereg_replace("\t", $txtTabulador, $txtLinea) . "</b>";
            } else {
                foreach ($arrLinea as $numOtraLinea => $txtValor) {
                    if ($numOtraLinea == 0) {
                        $txtCampo = trim($txtValor);
                        $txtCampo = ereg_replace($txtTabulador, "", $txtCampo);
                        if (!in_array($txtCampo, $this->arrIgnorarCampos)) {
                            if (isset($this->arrConversionCampos[$txtCampo])) {
                                $txtTexto = $this->arrConversionCampos[$txtCampo]['nombre'];
                            } else {
                                $txtTexto = $txtCampo;
                            }
                            if (strpos($txtValor, "\t") === false) {
                                $arrLinea[$numOtraLinea] = "<b>" . $txtTexto . "</b>";
                            } else {
                                $numOcurrencias = strcount("\t", $txtValor);
                                $arrLinea[$numOtraLinea] = "<b>" . str_repeat($txtTabulador, $numOcurrencias) . $txtTexto . "</b>";
                            }
                        } else {
                            $arrLinea = array();
                        }
                    } else {
                        if (!in_array($txtCampo, $this->arrIgnorarCampos)) {

                            $arrTraducir = split(":", $txtValor);
                            foreach ($arrTraducir as $numPosicion => $txtTraducir) {
                                $arrTraducir[$numPosicion] = trim($txtTraducir);
                            }

                            if (count($arrTraducir) > 2) {
                                for ($i = 2; $i < count($arrTraducir); $i++) {
                                    $arrTraducir[1] .= ":" . $arrTraducir[$i];
                                    unset($arrTraducir[$i]);
                                }
                            }

                            if (isset($this->arrConversionCampos[$txtCampo])) {
                                $txtTabla = $this->arrConversionCampos[$txtCampo]['tabla'];
                                $txtValor = obtenerNombres($txtTabla, $txtCampo, $arrTraducir[1]);
                            } else {
                                $txtValor = $arrTraducir[1];
                            }

                            $arrLinea[$numOtraLinea] = $txtValor . "&nbsp;";
                        } else {
                            $arrLinea = array();
                        }
                    }
                }
                if (!empty($arrLinea)) {
                    $arrLineas[$numLinea] = $arrLinea;
                } else {
                    unset($arrLineas[$numLinea]);
                }
            }
        }

        return $arrLineas;
    }

    /**
     * MIRA LOS CAMBIOS EN EL FORMULARIO DE POSTULACION / INSCRIPCION
     */
    public function cambiosPostulacionActo($seqFormulario, $objAnterior, $objNuevo) {

        $txtSeparador = $this->txtSeparador;
        $txtSalto = $this->txtSalto;

        $txtCambios = "<b>[ " . $seqFormulario . " ] Cambios en el hogar</b>" . $txtSalto;

        // detecta cuidadanos nuevos y cambios en cada ciudadano
        if (is_object($objNuevo)) {
            if ($objNuevo->arrCiudadano != "") {
                foreach ($objNuevo->arrCiudadano as $seqCiudadano => $objCiudadano) {
                    $txtCambios .= $txtSeparador . "<b>" .
                            $objCiudadano->txtNombre1 . " " .
                            $objCiudadano->txtNombre2 . " " .
                            $objCiudadano->txtApellido1 . " " .
                            $objCiudadano->txtApellido2 . " [ " .
                            $objCiudadano->numDocumento . " ]</b> ";

                    if (!isset($objAnterior->arrCiudadano[$seqCiudadano])) {
                        $txtCambios .= "<span class='msgOk'>Adicionado</span>" . $txtSalto;
                    } else {
                        $txtCambios .= $txtSalto;
                        foreach ($objCiudadano as $txtClave => $txtValorNuevo) {
                            if (!in_array($txtClave, $this->arrIgnorarCampos)) {
                                $txtValorAnterior = $objAnterior->arrCiudadano[$seqCiudadano]->$txtClave;
                                if (($txtClave == "seqCiudadano") && ($txtValorNuevo == 0)) {
                                    $txtCambios .= "";
                                } else {
                                    $txtCambios .= $this->compararValores($txtClave, $txtValorAnterior, $txtValorNuevo, 2);
                                }
                            }
                        }
                    }
                }
            }
        }

        // Para detectar ciudadanos eliminados
        $sqlEstado = "SELECT seqEstadoProceso FROM t_aad_formulario_acto WHERE seqFormularioActo = " . $seqFormulario;
        $exeEstado = mysql_query($sqlEstado);
        $rowEstado = mysql_fetch_array($exeEstado);
        if ($rowEstado['seqEstadoProceso'] == 35 || $rowEstado['seqEstadoProceso'] == 36) {
            $a = "no haga nada";
        } else {
            if (is_object($objAnterior)) {
                foreach ($objAnterior->arrCiudadano as $seqCiudadano => $objCiudadano) {
                    if (!isset($objNuevo->arrCiudadano[$seqCiudadano])) {
                        $txtCambios .= $txtSeparador . "<b>" .
                                $objCiudadano->txtNombre1 . " " .
                                $objCiudadano->txtNombre2 . " " .
                                $objCiudadano->txtApellido1 . " " .
                                $objCiudadano->txtApellido2 . " [ " .
                                $objCiudadano->numDocumento . " ]</b> ";
                        $txtCambios .= "<span class='msgError'>Eliminado</span>" . $txtSalto;
                    }
                }
            }
        }

        // Cambios en el formulario
        unset($objAnterior->arrCiudadano);
        unset($objNuevo->arrCiudadano);

        $txtCambios .= "<b>[ " . $seqFormulario . " ] Cambios en el formulario</b>" . $txtSalto;
        if (is_object($objNuevo)) {
            foreach ($objNuevo as $txtClave => $txtValorNuevo) {
                $txtClave = trim($txtClave);
                if (!in_array($txtClave, $this->arrIgnorarCampos)) {
                    $txtValorAnterior = $objAnterior->$txtClave;
                    $txtCambios .= $this->compararValores($txtClave, $txtValorAnterior, $txtValorNuevo, 1);
                }
            }
        }

        return $txtCambios;
    }

    /**
     * OBTIENE EL TEXTO DE CAMBIOS PARA EL FORMULARIO DE INSCRIPCION (EL PEQUEÑO)
     * EN ESTE CASO NO HAY NADA CON QUE COMPARAR CON LA BASE DE DATOS
     */
    public function cambiosInscripcion($arrPost){

        $seqFormulario = $arrPost['seqFormulario'];
        unset( $arrPost['seqFormulario'] );

        // Formulario actual en la base de datos
        $claFormulario = new FormularioSubsidios();
        $claFormulario->cargarFormulario($seqFormulario);


        // CIUDADANO ADICIONADO (SOLO HAY UNO)
        foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
            $txtCambiosHogar .= str_repeat( $this->txtSeparador , 2 ) .
                $objCiudadano->txtNombre1 . " " .
                $objCiudadano->txtNombre2 . " " .
                $objCiudadano->txtApellido1 . " " .
                $objCiudadano->txtApellido2 . " [ " .
                $objCiudadano->numDocumento . " ] <span class=\'msgOk\'>Adicionado</span>" . $this->txtSalto;
        }

        // Cambios en los datos del formulario
        unset($claFormulario->arrCiudadano);
        foreach ($claFormulario as $txtClave => $txtValor) {
            if( isset( $arrPost[$txtClave] ) ) {
                if (isset($arrPost[$txtClave]) || is_null($arrPost[$txtClave])) {
                    $arrPost[$txtClave] = regularizarCampo($txtClave, $arrPost[$txtClave]);
                    $txtCambiosFormulario .= $this->compararValores($txtClave, null, $arrPost[$txtClave], 2);
                }
            }
        }

        $txtCambios = "";
        if( trim($txtCambiosHogar) != "" ){
            $txtCambios .= "<b>[ " . $claFormulario->seqFormulario . " ] Cambios en el hogar</b>" . $this->txtSalto . $txtCambiosHogar;
        }

        if( trim($txtCambiosFormulario) != "" ){
            $txtCambios .= "<b>[ " . $claFormulario->seqFormulario . " ] Cambios en el formulario</b>" . $this->txtSalto . $txtCambiosFormulario;
        }

        return $txtCambios;
    }

    /**
     * MIRA LOS CAMBIOS EN EL FORMULARIO DE POSTULACION / ACTUALIZACION
     */
    public function cambiosPostulacion($arrPost) {

        // Formulario actual en la base de datos
        $claFormulario = new FormularioSubsidios();
        $claFormulario->cargarFormulario($arrPost['seqFormulario']);

        // Registro de campos cambiados
        $txtCambiosHogar = "";
        $txtCambiosFormulario = "";

        // Cambios en el hogar
        $arrCedulasFormulario = array();
        foreach ($claFormulario->arrCiudadano as $objCiudadano) {
            $numDocumento = $objCiudadano->numDocumento;
            $arrCedulasFormulario[] = $numDocumento;
            if (isset($arrPost['hogar'][$numDocumento])) {
                foreach ($objCiudadano as $txtClave => $txtValor) {
                    if (!in_array($txtClave, $this->arrIgnorarCampos)) {
                        if (array_key_exists($numDocumento,$arrPost['hogar']) and array_key_exists($txtClave,$arrPost['hogar'][$numDocumento])) {
                            $arrPost['hogar'][$numDocumento][$txtClave] = regularizarCampo($txtClave,$arrPost['hogar'][$numDocumento][$txtClave]);
                            $txtCambiosHogar .= $this->compararValores($txtClave, $txtValor, $arrPost['hogar'][$numDocumento][$txtClave],2);
                        }
                    }
                }
            } else {
                $txtCambiosHogar .=
                    $objCiudadano->txtNombre1 . " " .
                    $objCiudadano->txtNombre2 . " " .
                    $objCiudadano->txtApellido1 . " " .
                    $objCiudadano->txtApellido2 . " [ " .
                    $objCiudadano->numDocumento . " ] <span class=\'msgError\'>Eliminado</span>" . $this->txtSalto;
            }
        }

        // Determina cuando un ciudadano fue adicionado
        if( isset( $arrPost['hogar'] ) ) {
            foreach ($arrPost['hogar'] as $numDocumento => $arrMiembro) {
                if (!in_array($numDocumento, $arrCedulasFormulario)) {
                    $txtCambiosHogar .=
                        $arrMiembro['txtNombre1'] . " " .
                        $arrMiembro['txtNombre2'] . " " .
                        $arrMiembro['txtApellido1'] . " " .
                        $arrMiembro['txtApellido2'] . " [ " .
                        $arrMiembro['numDocumento'] . " ] <span class=\'msgOk\'>Adicionado</span>" . $this->txtSalto;
                }
            }
        }

        // Cambios en los datos del formulario
        unset($claFormulario->arrCiudadano);
        foreach ($claFormulario as $txtClave => $txtValor) {
            if (!in_array($txtClave, $this->arrIgnorarCampos)) {
                if( array_key_exists( $txtClave, $arrPost ) ) {
                    $arrPost[$txtClave] = regularizarCampo($txtClave, $arrPost[$txtClave]);
                    $txtCambiosFormulario .= $this->compararValores($txtClave, $txtValor, $arrPost[$txtClave], 2);
                }
            }
        }

        $txtCambios = "";
        if( trim($txtCambiosHogar) != "" ){
            $txtCambios .= "<b>[ " . $claFormulario->seqFormulario . " ] Cambios en el hogar</b>" . $this->txtSalto . $txtCambiosHogar;
        }

        if( trim($txtCambiosFormulario) != "" ){
            $txtCambios .= "<b>[ " . $claFormulario->seqFormulario . " ] Cambios en el formulario</b>" . $this->txtSalto . $txtCambiosFormulario;
        }

        return $txtCambios;
    }

    public function cambiosCambioEstados($seqFormulario, $objAnterior, $objNuevo) {

            $txtSeparador = $this->txtSeparador;
            $txtSalto = $this->txtSalto;

            $txtCambios = "<b>[ " . $seqFormulario . " ] Cambios en el hogar</b>" . $txtSalto;

            // detecta cuidadanos nuevos y cambios en cada ciudadano
            if (is_object($objNuevo)) {
                foreach ($objNuevo->arrCiudadano as $seqCiudadano => $objCiudadano) {
                    $txtCambios .= $txtSeparador . "<b>" .
                        $objCiudadano->txtNombre1 . " " .
                        $objCiudadano->txtNombre2 . " " .
                        $objCiudadano->txtApellido1 . " " .
                        $objCiudadano->txtApellido2 . " [ " .
                        $objCiudadano->numDocumento . " ]</b> ";

                    if (!isset($objAnterior->arrCiudadano[$seqCiudadano])) {
                        $txtCambios .= "<span class='msgOk'>Adicionado</span>" . $txtSalto;
                    } else {
                        $txtCambios .= $txtSalto;
                        foreach ($objCiudadano as $txtClave => $txtValorNuevo) {
                            if (!in_array($txtClave, $this->arrIgnorarCampos)) {
                                $txtValorAnterior = $objAnterior->arrCiudadano[$seqCiudadano]->$txtClave;
                                if (($txtClave == "seqCiudadano") && ($txtValorNuevo == 0)) {
                                    $txtCambios .= "";
                                } else {
                                    $txtCambios .= $this->compararValores($txtClave, $txtValorAnterior, $txtValorNuevo, 2);
                                }
                            }
                        }
                    }
                }
            }

            // Para detectar ciudadanos eliminados
            $sqlEstado = "SELECT seqEstadoProceso FROM T_FRM_FORMULARIO WHERE seqFormulario = " . $seqFormulario;
            $exeEstado = mysql_query($sqlEstado);
            $rowEstado = mysql_fetch_array($exeEstado);
            if ($rowEstado['seqEstadoProceso'] == 35 || $rowEstado['seqEstadoProceso'] == 36) {
                $a = "no haga nada";
            } else {
                if (is_object($objAnterior)) {
                    foreach ($objAnterior->arrCiudadano as $seqCiudadano => $objCiudadano) {
                        if (!isset($objNuevo->arrCiudadano[$seqCiudadano])) {
                            $txtCambios .= $txtSeparador . "<b>" .
                                $objCiudadano->txtNombre1 . " " .
                                $objCiudadano->txtNombre2 . " " .
                                $objCiudadano->txtApellido1 . " " .
                                $objCiudadano->txtApellido2 . " [ " .
                                $objCiudadano->numDocumento . " ]</b> ";
                            $txtCambios .= "<span class='msgError'>Eliminado</span>" . $txtSalto;
                        }
                    }
                }
            }

            // Cambios en el formulario
            unset($objAnterior->arrCiudadano);
            unset($objNuevo->arrCiudadano);

            $txtCambios .= "<b>[ " . $seqFormulario . " ] Cambios en el formulario</b>" . $txtSalto;
            if (is_object($objNuevo)) {
                foreach ($objNuevo as $txtClave => $txtValorNuevo) {
                    $txtClave = trim($txtClave);
                    if (!in_array($txtClave, $this->arrIgnorarCampos)) {
                        $txtValorAnterior = $objAnterior->$txtClave;
                        $txtCambios .= $this->compararValores($txtClave, $txtValorAnterior, $txtValorNuevo, 1);
                    }
                }
            }

            return $txtCambios;
        }

    /**
     * COMPARACION DE VALORES
     */
    private function compararValores($txtClave, $txtValorAnterior, $txtValorNuevo, $numSeparadores = 0) {

        $txtSeparador = str_repeat($this->txtSeparador, $numSeparadores);
        $txtSalto = $this->txtSalto;
        $txtCambios = "";

        switch ($this->arrTipoDato[$txtClave]) {
            case "numero":
                $txtValorAnterior = ( is_numeric($txtValorAnterior) ) ? $txtValorAnterior : 0;
                $txtValorNuevo = ( is_numeric($txtValorNuevo) ) ? $txtValorNuevo : 0;
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtCambios .= $txtSeparador . $txtClave . ", Valor Anterior: $txtValorAnterior, Valor Nuevo: $txtValorNuevo" . $txtSalto;
                }
                break;
            case "texto":
                $txtValorAnterior = strtolower(trim($txtValorAnterior));
                $txtValorNuevo = strtolower(trim($txtValorNuevo));
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtCambios .= $txtSeparador . $txtClave . ", Valor Anterior: $txtValorAnterior, Valor Nuevo: $txtValorNuevo" . $txtSalto;
                }
                break;
            case "fecha":

                $txtValorAnterior = ( ! esFechaValida($txtValorAnterior) ) ? null : $txtValorAnterior;
                $txtValorNuevo    = ( ! esFechaValida($txtValorNuevo)    ) ? null : $txtValorNuevo;

                list( $ano, $mes, $dia ) = split("[/-]", $txtValorAnterior);
                if (@checkdate($mes, $dia, $ano) === false) {
                    $txtValorAnterior = 0;
                } else {
                    $txtValorAnterior = strtotime($txtValorAnterior);
                }

                list( $ano, $mes, $dia ) = split("[/-]", $txtValorNuevo);
                if (@checkdate($mes, $dia, $ano) === false) {
                    $txtValorNuevo = 0;
                } else {
                    $txtValorNuevo = strtotime($txtValorNuevo);
                }

                if ($txtValorAnterior != $txtValorNuevo) {
                    if ($txtValorAnterior == 0) {
                        $txtValorAnterior = "";
                    } else {
                        $txtValorAnterior = date("Y-m-d", $txtValorAnterior);
                    }
                    if ($txtValorNuevo == 0) {
                        $txtValorNuevo = "";
                    } else {
                        $txtValorNuevo = date("Y-m-d", $txtValorNuevo);
                    }
                    $txtCambios .= $txtSeparador . $txtClave . ", Valor Anterior: $txtValorAnterior, Valor Nuevo: $txtValorNuevo" . $txtSalto;
                }

                break;
            case "fechahora":

                if (strtotime($txtValorAnterior) !== false) {
                    $txtValorAnterior = strtotime($txtValorAnterior);
                } else {
                    $txtValorAnterior = 0;
                }

                if (strtotime($txtValorNuevo) !== false) {
                    $txtValorNuevo = strtotime($txtValorNuevo);
                } else {
                    $txtValorNuevo = 0;
                }

                if ($txtValorAnterior != $txtValorNuevo) {
                    if ($txtValorAnterior == 0) {
                        $txtValorAnterior = "";
                    } else {
                        $txtValorAnterior = date("Y-m-d H:i:s", $txtValorAnterior);
                    }
                    if ($txtValorNuevo == 0) {
                        $txtValorNuevo = "";
                    } else {
                        $txtValorNuevo = date("Y-m-d H:i:s", $txtValorNuevo);
                    }
                    $txtCambios .= $txtSeparador . $txtClave . ", Valor Anterior: $txtValorAnterior, Valor Nuevo: $txtValorNuevo" . $txtSalto;
                }

                break;
            case "booleano":
                $txtValorAnterior = ( $txtValorAnterior == 1 ) ? "Si" : "No";
                $txtValorNuevo = ( $txtValorNuevo == 1 ) ? "Si" : "No";

                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtCambios .= $txtSeparador . $txtClave . ", Valor Anterior: $txtValorAnterior, Valor Nuevo: $txtValorNuevo" . $txtSalto;
                }
                break;
            default:
                if( ! is_array( $txtValorAnterior ) and ! is_array( $txtValorNuevo ) ){
                    $txtValorAnterior = strtolower(trim($txtValorAnterior));
                    $txtValorNuevo = strtolower(trim($txtValorNuevo));
                }

                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtCambios .= $txtSeparador . $txtClave . ", Valor Anterior: $txtValorAnterior, Valor Nuevo: $txtValorNuevo" . $txtSalto;
                }
                break;
        }

        return $txtCambios;
    }

    /**
     * CAMBIOS PARA TODAS LAS FASES DE DESEMBOLSOS
     */
    public function cambiosDesembolso($txtFase, $objAnterior, $arrNuevo) {

        switch ($txtFase) {
            case "busquedaOferta": $txtCambios = $this->cambiosDesembolsoBusqueda($objAnterior, $arrNuevo);
                break;
            case "revisionJuridica": $txtCambios = $this->cambiosRevisionJuridica($objAnterior, $arrNuevo);
                break;
            case "revisionTecnica": $txtCambios = $this->cambiosRevisionTecnica($objAnterior, $arrNuevo);
                break;
            case "escrituracion": $txtCambios = $this->cambiosDesembolsoBusqueda($objAnterior, $arrNuevo);
                break;
            case "estudioTitulos": $txtCambios = $this->cambiosEstudioTitulos($objAnterior, $arrNuevo);
                break;
            case "solicitudDesembolso": $txtCambios = $this->cambiosSolicitudDesembolso($objAnterior, $arrNuevo);
                break;
            case "Consignaciones": $txtCambios = $this->cambiosConsignaciones($objAnterior, $arrNuevo);
                break;
        }

        return $txtCambios;
    }

    /**
     * DESEMBOLSO PARA LA BUSQUEDA DE LA OFERTA
     */
    private function cambiosDesembolsoBusqueda($objAnterior, $arrNuevo) {


        $claFormulario = new FormularioSubsidios;
        $claFormulario->cargarFormulario($arrNuevo['seqFormulario']);

        $txtCambios = "<b>[ " . $arrNuevo['seqFormulario'] . " ] Datos del Formulario:</b>" . $this->txtSalto;

        // Estado del proceso
        $txtValorAnterior = $claFormulario->seqEstadoProceso;
        $txtValorNuevo = $arrNuevo['seqEstadoProceso'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $arrEstados = estadosProceso();
            $txtCambios .= $this->txtSeparador . "Estado del Proceso, Valor Anterior: " . $arrEstados[$txtValorAnterior] . ", " .
                    "Valor Nuevo: " . $arrEstados[$txtValorNuevo] . $this->txtSalto;
        }

        $txtCambios .= "<b>[ " . $arrNuevo['seqFormulario'] . " ] Datos del Inmueble:</b>" . $this->txtSalto;

        // Nombre del Vendedor
        $txtValorAnterior = strtolower(trim($objAnterior->txtNombreVendedor));
        $txtValorNuevo = strtolower(trim($arrNuevo['txtNombreVendedor']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Nombre del Vendedor, Valor Anterior: " . strtoupper($txtValorAnterior) . ", " .
                    "Valor Nuevo: " . strtoupper($txtValorNuevo) . $this->txtSalto;
        }

        // Tipo de documento del vendedor
        $txtValorAnterior = intval($objAnterior->seqTipoDocumento);
        $txtValorNuevo = intval($arrNuevo['seqTipoDocumento']);
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : obtenerNombres("T_CIU_TIPO_DOCUMENTO", "seqTipoDocumento", $txtValorAnterior);
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : obtenerNombres("T_CIU_TIPO_DOCUMENTO", "seqTipoDocumento", $txtValorNuevo);
            $txtCambios .= $this->txtSeparador . "Tipo Documento Vendedor, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Documento del vendedor
        $txtValorAnterior = $objAnterior->numDocumentoVendedor;
        $txtValorNuevo = $arrNuevo['numDocumentoVendedor'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" or $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" or $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Número Documento Vendedor, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Numero de telefono del vendedor
        $txtValorAnterior = $objAnterior->numTelefonoVendedor;
        $txtValorNuevo = $arrNuevo['numTelefonoVendedor'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Teléfono del Vendedor, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Numero de telefono del vendedor 2
        $txtValorAnterior = $objAnterior->numTelefonoVendedor2;
        $txtValorNuevo = $arrNuevo['numTelefonoVendedor2'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Teléfono del Vendedor 2, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Correo Electronico del vendedor
        $txtValorAnterior = $objAnterior->txtCorreoVendedor;
        $txtValorNuevo = $arrNuevo['txtCorreoVendedor'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Correo Electrónico del Vendedor, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }
        // Compra de vivienda
        $txtValorAnterior = $objAnterior->txtCompraVivienda;
        $txtValorNuevo = $arrNuevo['txtCompraVivienda'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Compra de Vivienda, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                    "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // Direccion del inmueble
        $txtValorAnterior = strtolower(trim($objAnterior->txtDireccionInmueble));
        $txtValorNuevo = strtolower(trim($arrNuevo['txtDireccionInmueble']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Dirección del Inmueble, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                    "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

// ----------------------
        // Titulo de propiedad
        $txtValorAnterior = strtolower(trim($objAnterior->txtPropiedad));
        $txtValorNuevo = strtolower(trim($arrNuevo['txtPropiedad']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Titulo de Propiedad, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                    "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // Texto del titulo de propiedad --> VALOR ANTERIOR
        $txtValorAnterior = "";
        switch (strtolower(trim($objAnterior->txtPropiedad))) {
            case "escritura":
                $txtValorAnterior = "Escritura Pública " . $objAnterior->txtEscritura . " del " . $objAnterior->fchEscritura .
                        " Notaria " . $objAnterior->numNotaria . " Cuidad " . $objAnterior->txtCiudad;

                break;
            case "sentencia":
                $txtValorAnterior = "Sentencia " . $objAnterior->fchSentencia . " Juzgado " . $objAnterior->numJuzgado .
                        " Ciudada " . $objAnterior->txtCiudadSentencia;
                break;
            case "resolucion":
                $txtValorAnterior = "Resolución " . $objAnterior->numResolucion . " del " . $objAnterior->fchResolucion .
                        " Entidad " . $objAnterior->txtEntidad . " Ciudad " . $objAnterior->txtCiudadResolucion;
                break;
        }

        // Texto del titulo de propiedad --> VALOR NUEVO
        $txtValorNuevo = "";
        switch (strtolower(trim($arrNuevo['txtPropiedad']))) {
            case "escritura":
                $txtValorNuevo = "Escritura Pública " . $arrNuevo['txtEscritura'] . " del " . $arrNuevo['fchEscritura'] .
                        " Notaría " . $arrNuevo['numNotaria'] . " Cuidad " . $arrNuevo['txtCiudad'];

                break;
            case "sentencia":
                $txtValorNuevo = "Sentencia " . $arrNuevo['fchSentencia'] . " Juzgado " . $arrNuevo['numJuzgado'] .
                        " Ciudada " . $arrNuevo['txtCiudadSentencia'];
                break;
            case "resolucion":
                $txtValorNuevo = "Resolución " . $arrNuevo['numResolucion'] . " del " . $arrNuevo['fchResolucion'] .
                        " Entidad " . $arrNuevo['txtEntidad'] . " Ciudad " . $arrNuevo['txtCiudadResolucion'];
                break;
        }

        // Comparacion del texto del valor de los titulos de propiedad
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Descripción, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                    "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

// ----------------------
        // Ciduad
        $txtValorAnterior = intval($objAnterior->seqCiudad);
        $txtValorNuevo = intval($arrNuevo['seqCiudad']);
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : obtenerNombres("T_FRM_CIUDAD", "seqCiudad", $txtValorAnterior);
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : obtenerNombres("T_FRM_CIUDAD", "seqCiudad", $txtValorNuevo);
            $txtCambios .= $this->txtSeparador . "Ciudad, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Localidad
        $txtValorAnterior = intval($objAnterior->seqLocalidad);
        $txtValorNuevo = intval($arrNuevo['seqLocalidad']);
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : obtenerNombres("T_FRM_LOCALIDAD", "seqLocalidad", $txtValorAnterior);
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : obtenerNombres("T_FRM_LOCALIDAD", "seqLocalidad", $txtValorNuevo);
            $txtCambios .= $this->txtSeparador . "Localidad, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Barrio
        $txtValorAnterior = strtolower(trim($objAnterior->txtBarrio));
        $txtValorNuevo = strtolower(trim($arrNuevo['txtBarrio']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Barrio, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                    "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // Matricula inmobiliaria
        $txtValorAnterior = strtoupper(trim($objAnterior->txtMatriculaInmobiliaria));
        $txtValorNuevo = strtoupper(trim($arrNuevo['txtMatriculaInmobiliaria']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Matrícula Inmobiliaria, Valor Anterior: " . strtoupper($txtValorAnterior) . ", " .
                    "Valor Nuevo: " . strtoupper($txtValorNuevo) . $this->txtSalto;
        }

        // CHIP 
        $txtValorAnterior = strtoupper(trim($objAnterior->txtChip));
        $txtValorNuevo = strtoupper(trim($arrNuevo['txtChip']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Chip, Valor Anterior: " . strtoupper($txtValorAnterior) . ", " .
                    "Valor Nuevo: " . strtoupper($txtValorNuevo) . $this->txtSalto;
        }

        // Cedula Catastral
        $txtValorAnterior = strtolower(trim($objAnterior->txtCedulaCatastral));
        $txtValorNuevo = strtolower(trim($arrNuevo['txtCedulaCatastral']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Cedula Catastral, Valor Anterior: " . strtoupper($txtValorAnterior) . ", " .
                    "Valor Nuevo: " . strtoupper($txtValorNuevo) . $this->txtSalto;
        }

        // Area lote
        $txtValorAnterior = intval($objAnterior->numAreaLote);
        $txtValorNuevo = intval($arrNuevo['numAreaLote']);
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Área del Lote, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Area Construida
        $txtValorAnterior = intval($objAnterior->numAreaConstruida);
        $txtValorNuevo = intval($arrNuevo['numAreaConstruida']);
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Área del Construida, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Valor Avaluo
        $txtValorAnterior = $objAnterior->numAvaluo;
        $txtValorNuevo = $arrNuevo['numAvaluo'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Valor Avaluo, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Valor Inmueble
        $txtValorAnterior = $objAnterior->numValorInmueble;
        $txtValorNuevo = $arrNuevo['numValorInmueble'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Valor Inmueble, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Tipo de Inmueble
        $txtValorAnterior = strtolower(trim($objAnterior->txtTipoPredio));
        $txtValorNuevo = strtolower(trim($arrNuevo['txtTipoPredio']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Tipo de Predio, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                    "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // Estrato del inmueble
        $txtValorAnterior = $objAnterior->numEstrato;
        $txtValorNuevo = $arrNuevo['numEstrato'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Estrato del inmueble, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        /**
         * PESTANA DE RECIBO DE DOCUMENTOS
         */
        $txtCambios .= "<b>[ " . $arrNuevo['seqFormulario'] . " ] Recibo de Documentos:</b>" . $this->txtSalto;

        if ($claFormulario->seqModalidad != 5) {

            // Folios escritura publica
            $txtValorAnterior = $objAnterior->numEscrituraPublica;
            $txtValorNuevo = $arrNuevo['numEscrituraPublica'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Escritura Publica, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones escritura publica
            $txtValorAnterior = strtolower(trim($objAnterior->txtEscrituraPublica));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtEscrituraPublica']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Escritura PÃºblica, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // Folios certificado de tradicion
            $txtValorAnterior = $objAnterior->numCertificadoTradicion;
            $txtValorNuevo = $arrNuevo['numCertificadoTradicion'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Certificado de Tradición y Libertad, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones certificado de tradicion
            $txtValorAnterior = strtolower(trim($objAnterior->txtCertificadoTradicion));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtCertificadoTradicion']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Certificado de Tradición y Libertad, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // Folios carta de asignacion
            $txtValorAnterior = $objAnterior->numCartaAsignacion;
            $txtValorNuevo = $arrNuevo['numCartaAsignacion'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Carta de Asignación, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones carta de asignacion
            $txtValorAnterior = strtolower(trim($objAnterior->txtCartaAsignacion));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtCartaAsignacion']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Carta de Asignación, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // folios certificado de alto riesgo 			
            $txtValorAnterior = $objAnterior->numAltoRiesgo;
            $txtValorNuevo = $arrNuevo['numAltoRiesgo'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Certificado de Alto Riesgo, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones certificado de alto riesgo 
            $txtValorAnterior = strtolower(trim($objAnterior->txtAltoRiesgo));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtAltoRiesgo']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Certificado de Alto Riesgo, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // folios certificado de habitabilidad			
            $txtValorAnterior = $objAnterior->numHabitabilidad;
            $txtValorNuevo = $arrNuevo['numHabitabilidad'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Certificado de Habitabilidad, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones certificado de habitabilidad 
            $txtValorAnterior = strtolower(trim($objAnterior->txtHabitabilidad));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtHabitabilidad']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Certificado de Habitabilidad, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // folios boletin catastral		
            $txtValorAnterior = $objAnterior->numBoletinCatastral;
            $txtValorNuevo = $arrNuevo['numBoletinCatastral'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Boletin Catastral, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones boletin catastral
            $txtValorAnterior = strtolower(trim($objAnterior->txtBoletinCatastral));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtBoletinCatastral']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Boletín Catastral, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // folios licencia de construccion
            $txtValorAnterior = $objAnterior->numLicenciaConstruccion;
            $txtValorNuevo = $arrNuevo['numLicenciaConstruccion'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Licencia de Construcción, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones licencia de construccion
            $txtValorAnterior = strtolower(trim($objAnterior->txtLicenciaConstruccion));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtLicenciaConstruccion']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Licencia de Construcción, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // folios ultimo predial
            $txtValorAnterior = $objAnterior->numUltimoPredial;
            $txtValorNuevo = $arrNuevo['numUltimoPredial'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Ultimo Predial, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones ultimo predial
            $txtValorAnterior = strtolower(trim($objAnterior->txtUltimoPredial));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtUltimoPredial']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Ultimo Predial, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // folios ultimo rebibo de agua
            $txtValorAnterior = $objAnterior->numUltimoReciboAgua;
            $txtValorNuevo = $arrNuevo['numUltimoReciboAgua'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Ultimo Recibo de Agua, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones rebibo de agua
            $txtValorAnterior = strtolower(trim($objAnterior->txtUltimoReciboAgua));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtUltimoReciboAgua']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Ultimo Recibo de Agua, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // folios ultimo rebibo de energia
            $txtValorAnterior = $objAnterior->numUltimoReciboEnergia;
            $txtValorNuevo = $arrNuevo['numUltimoReciboEnergia'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Ultimo Recibo de Energía, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones rebibo de energia
            $txtValorAnterior = strtolower(trim($objAnterior->txtUltimoReciboEnergia));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtUltimoReciboEnergia']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Ultimo Recibo de Agua, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // folios acta de entrega
            $txtValorAnterior = $objAnterior->numActaEntrega;
            $txtValorNuevo = $arrNuevo['numActaEntrega'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Acta de Entrega, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones acta de entrega
            $txtValorAnterior = strtolower(trim($objAnterior->txtActaEntrega));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtActaEntrega']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Acta Entrega, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // folios certificacion vendedor
            $txtValorAnterior = $objAnterior->numCertificacionVendedor;
            $txtValorNuevo = $arrNuevo['numCertificacionVendedor'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Certificación Bancaria del Vendedor, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones certificacion vendedor
            $txtValorAnterior = strtolower(trim($objAnterior->txtCertificacionVendedor));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtCertificacionVendedor']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Certificación Bancaria del Vendedor, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // folios Autorizacion de desembiolso
            $txtValorAnterior = $objAnterior->numAutorizacionDesembolso;
            $txtValorNuevo = $arrNuevo['numAutorizacionDesembolso'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Autorización de Desembolso, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones autorizacion de desembolso
            $txtValorAnterior = strtolower(trim($objAnterior->txtAutorizacionDesembolso));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtAutorizacionDesembolso']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Autorización de Desembolso, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // folios cedula del vendedor
            $txtValorAnterior = $objAnterior->numFotocopiaVendedor;
            $txtValorNuevo = $arrNuevo['numFotocopiaVendedor'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Fotocopia Cedula del Vendedor, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones cedula del vendedor
            $txtValorAnterior = strtolower(trim($objAnterior->txtFotocopiaVendedor));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtFotocopiaVendedor']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Fotocopia Cedula del Vendedor, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // Folios RUT
            $txtValorAnterior = $objAnterior->numRut;
            $txtValorNuevo = $arrNuevo['numRut'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios RUT, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones RUT
            $txtValorAnterior = strtolower(trim($objAnterior->txtRut));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtRut']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones RUT, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // Folios RIT
            $txtValorAnterior = $objAnterior->numRit;
            $txtValorNuevo = $arrNuevo['numRit'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios RIT, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones RIT
            $txtValorAnterior = strtolower(trim($objAnterior->txtRit));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtRit']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones RIT, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // Folios NIT
            $txtValorAnterior = $objAnterior->numNit;
            $txtValorNuevo = $arrNuevo['numNit'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios NIT, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones NIT
            $txtValorAnterior = strtolower(trim($objAnterior->txtNit));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtNit']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones NIT, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // Folios Otros
            $txtValorAnterior = $objAnterior->numOtros;
            $txtValorNuevo = $arrNuevo['numOtros'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Otros, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones NIT
            $txtValorAnterior = strtolower(trim($objAnterior->txtOtros));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtOtros']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Otros, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }
        } else {

            // Folios Contrato de arrendamiento
            $txtValorAnterior = $objAnterior->numContratoArrendamiento;
            $txtValorNuevo = $arrNuevo['numContratoArrendamiento'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Contrato de Arrendamiento, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones Contrato de arrendamiento
            $txtValorAnterior = strtolower(trim($objAnterior->txtContratoArrendamiento));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtContratoArrendamiento']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Contrato de Arrendamiento, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // Folios Apertura CAP
            $txtValorAnterior = $objAnterior->numAperturaCAP;
            $txtValorNuevo = $arrNuevo['numAperturaCAP'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Certificado Apertura CAP, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones Apertura CAP
            $txtValorAnterior = strtolower(trim($objAnterior->txtAperturaCAP));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtAperturaCAP']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Certificado Apertura CAP, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // Folios Cuenta de ahorro arrendador
            $txtValorAnterior = $objAnterior->numCedulaArrendador;
            $txtValorNuevo = $arrNuevo['numCedulaArrendador'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Certificación Cuenta Arrendador, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones Cuenta de ahorro arrendador
            $txtValorAnterior = strtolower(trim($objAnterior->txtCedulaArrendador));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtCedulaArrendador']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Certificación Cuenta Arrendador, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // Folios Cedula arrendador
            $txtValorAnterior = $objAnterior->numCuentaArrendador;
            $txtValorNuevo = $arrNuevo['numCuentaArrendador'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Cédula Arrendador, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones Cedula arrendador
            $txtValorAnterior = strtolower(trim($objAnterior->txtCuentaArrendador));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtCuentaArrendador']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Cédula Arrendador, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }


            // Folios Tres Recibos de Servicios PÃºblicos
            $txtValorAnterior = $objAnterior->numServiciosPublicos;
            $txtValorNuevo = $arrNuevo['numServiciosPublicos'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Tres Recibos de Servicios Públicos, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones Tres Recibos de Servicios Públicos
            $txtValorAnterior = strtolower(trim($objAnterior->txtServiciosPublicos));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtServiciosPublicos']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Tres Recibos de Servicios Públicos, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }

            // Folios Autorización de Retiro de Recursos
            $txtValorAnterior = $objAnterior->numRetiroRecursos;
            $txtValorNuevo = $arrNuevo['numRetiroRecursos'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Folios Autorización de Retiro de Recursos, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones Autorización de Retiro de Recursos
            $txtValorAnterior = strtolower(trim($objAnterior->txtRetiroRecursos));
            $txtValorNuevo = strtolower(trim($arrNuevo['txtRetiroRecursos']));
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . "Observaciones Autorización de Retiro de Recursos, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
            }
        }

        return $txtCambios;
    }

    /**
     * DESEMBOLSO EN LA REVISION JURIDICA
     */
    private function cambiosRevisionJuridica($objAnterior, $arrNuevo) {

        $claFormulario = new FormularioSubsidios;
        $claFormulario->cargarFormulario($arrNuevo['seqFormulario']);

        $txtCambios = "<b>[ " . $arrNuevo['seqFormulario'] . " ] Datos del Formulario:</b>" . $this->txtSalto;

        // Estado del proceso
        $txtValorAnterior = $claFormulario->seqEstadoProceso;
        $txtValorNuevo = $arrNuevo['seqEstadoProceso'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $arrEstados = estadosProceso();
            $txtCambios .= $this->txtSeparador . "Estado del Proceso, Valor Anterior: " . $arrEstados[$txtValorAnterior] . ", " .
                    "Valor Nuevo: " . $arrEstados[$txtValorNuevo] . $this->txtSalto;
        }

        $txtCambios .= "<b>[ " . $arrNuevo['seqFormulario'] . " ] Concepto Juridico:</b>" . $this->txtSalto;

        // Numero de resolucion
        $txtValorAnterior = $objAnterior->arrJuridico['numResolucion'];
        $txtValorNuevo = $arrNuevo['numResolucion'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Numero de Resolución, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // fecha de resolucion
        $txtValorAnterior = strtotime($objAnterior->arrJuridico['fchResolucion']);
        $txtValorNuevo = strtotime($arrNuevo['resolucion']);
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == false ) ? "Ninguno" : date("Y-m-d", $txtValorAnterior);
            $txtValorNuevo = ( $txtValorNuevo == false ) ? "Ninguno" : date("Y-m-d", $txtValorNuevo);
            $txtCambios .= $this->txtSeparador . "Fecha de Resolucion, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // observaciones
        $txtValorAnterior = strtolower(trim($objAnterior->arrJuridico['txtObservaciones']));
        $txtValorNuevo = strtolower(trim($arrNuevo['observaciones']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                    "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // libertad
        $txtValorAnterior = strtolower(trim($objAnterior->arrJuridico['txtLibertad']));
        $txtValorNuevo = strtolower(trim($arrNuevo['libertad']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Libertad, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                    "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        $txtCambios .= $this->txtSeparador . "<b>Documentos Analizados:</b>" . $this->txtSalto;

        // Docuemntos
        $arrDocumentosAnterior = $objAnterior->arrJuridico['documento'];
        $arrDocumentosNuevo = $arrNuevo['documento'];
        foreach ($arrDocumentosNuevo as $numDocumento => $txtDocumentoNuevo) {

            if (isset($arrDocumentosAnterior[$numDocumento])) {
                $txtDocumentoAnterior = $arrDocumentosAnterior[$numDocumento];
            } else {
                $txtDocumentoAnterior = "Ninguno";
            }

            if ($txtDocumentoAnterior != $txtDocumentoNuevo) {
                $txtCambios .= $this->txtSeparador . $this->txtSeparador .
                        "Documento " . ( $numDocumento + 1 ) . ", " .
                        "Valor Anterior: " . ucwords($txtDocumentoAnterior) . ", " .
                        "Valor Nuevo: " . ucwords($txtDocumentoNuevo) . $this->txtSalto;
            }
        }

        if (is_array($arrDocumentosAnterior)) {
            foreach ($arrDocumentosAnterior as $numDocumento => $txtDocumentoAnterior) {
                if (!isset($arrDocumentosNuevo[$numDocumento])) {
                    $txtDocumentoNuevo = "Ninguno";
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador .
                            "Documento " . ( $numDocumento + 1 ) . ", " .
                            "Valor Anterior: " . ucwords($txtDocumentoAnterior) . ", " .
                            "Valor Nuevo: " . ucwords($txtDocumentoNuevo) . $this->txtSalto;
                }
            }
        }

        $txtCambios .= $this->txtSeparador . "<b>Recomendaciones:</b>" . $this->txtSalto;

        // Recomendaciones
        if (is_array($arrNuevo['recomendacion'])) {
            $arrRecomendacionAnterior = $objAnterior->arrJuridico['recomendacion'];
            $arrRecomendacionNuevo = $arrNuevo['recomendacion'];
            foreach ($arrRecomendacionNuevo as $numRecomendacion => $txtRecomendacionNuevo) {

                if (isset($arrRecomendacionAnterior[$numRecomendacion])) {
                    $txtRecomendacionAnterior = $arrRecomendacionAnterior[$numRecomendacion];
                } else {
                    $txtRecomendacionAnterior = "Ninguno";
                }

                if ($txtRecomendacionAnterior != $txtRecomendacionNuevo) {
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador .
                            "Recomendacion " . ( $numRecomendacion + 1 ) . ", " .
                            "Valor Anterior: " . ucwords($txtRecomendacionAnterior) . ", " .
                            "Valor Nuevo: " . ucwords($txtRecomendacionNuevo) . $this->txtSalto;
                }
            }
        }

        if (is_array($arrRecomendacionAnterior)) {
            foreach ($arrRecomendacionAnterior as $numRecomendacion => $txtRecomendacionAnterior) {
                if (!isset($arrRecomendacionNuevo[$numRecomendacion])) {
                    $txtRecomendacionNuevo = "Ninguno";
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador .
                            "Recomendacion " . ( $numRecomendacion + 1 ) . ", " .
                            "Valor Anterior: " . ucwords($txtRecomendacionAnterior) . ", " .
                            "Valor Nuevo: " . ucwords($txtRecomendacionNuevo) . $this->txtSalto;
                }
            }
        }

        // Concepto
        $txtValorAnterior = strtolower(trim($objAnterior->arrJuridico['txtConcepto']));
        $txtValorNuevo = strtolower(trim($arrNuevo['concepto']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Concepto, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                    "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // Aprobo
        $txtValorAnterior = strtolower(trim($objAnterior->arrJuridico['txtAprobo']));
        $txtValorNuevo = strtolower(trim($arrNuevo['aprobo']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Aprobó, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                    "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        return $txtCambios;
    }

    /**
     * DESEMBOLSO EN LA REVISION TECNICA
     */
    private function cambiosRevisionTecnica($objAnterior, $arrNuevo) {

        $claFormulario = new FormularioSubsidios;
        $claFormulario->cargarFormulario($arrNuevo['seqFormulario']);

        $txtCambios = "<b>[ " . $arrNuevo['seqFormulario'] . " ] Datos del Formulario:</b>" . $this->txtSalto;

        // Estado del proceso
        $txtValorAnterior = $claFormulario->seqEstadoProceso;
        $txtValorNuevo = $arrNuevo['seqEstadoProceso'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $arrEstados = estadosProceso();
            $txtCambios .= $this->txtSeparador . "Estado del Proceso, Valor Anterior: " . $arrEstados[$txtValorAnterior] . ", " .
                    "Valor Nuevo: " . $arrEstados[$txtValorNuevo] . $this->txtSalto;
        }

        // Fecha de la visita
        $txtValorAnterior = strtotime($objAnterior->arrTecnico['fchVisita']);
        $txtValorNuevo = strtotime($arrNuevo['fchVisita']);
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == false ) ? "Ninguno" : date("Y-m-d", $txtValorAnterior);
            $txtValorNuevo = ( $txtValorNuevo == false ) ? "Ninguno" : date("Y-m-d", $txtValorNuevo);
            $txtCambios .= $this->txtSeparador . "Fecha de la Visita, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtAprobo", "Aprobo");

        /**
         * vivienda nueva
         */
        $txtCambios .= "<b>[ " . $arrNuevo['seqFormulario'] . " ] Vivienda Nueva:</b>" . $this->txtSalto;

        // Observaciones [ Vivienda Nueva ]
        $arrObservacionAnterior = $objAnterior->arrTecnico['observacion'];
        $arrObservacionNuevo = $arrNuevo['observacion'];
        if (is_array($arrObservacionNuevo)) {

            foreach ($arrObservacionNuevo as $numObservacion => $txtObservacionNuevo) {

                if (isset($arrObservacionAnterior[$numObservacion])) {
                    $txtObservacionAnterior = $arrObservacionAnterior[$numObservacion];
                } else {
                    $txtObservacionAnterior = "Ninguno";
                }

                if ($txtObservacionAnterior != $txtObservacionNuevo) {
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador .
                            "Observacion " . ( $numObservacion + 1 ) . ", " .
                            "Valor Anterior: " . ucwords($txtObservacionAnterior) . ", " .
                            "Valor Nuevo: " . ucwords($txtObservacionNuevo) . $this->txtSalto;
                }
            }
        }

        if (is_array($arrObservacionAnterior)) {
            foreach ($arrObservacionAnterior as $numObservacion => $txtObservacionAnterior) {
                if (!isset($arrObservacionNuevo[$numObservacion])) {
                    $txtObservacionNuevo = "Ninguno";
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador .
                            "Observacion " . ( $numObservacion + 1 ) . ", " .
                            "Valor Anterior: " . ucwords($txtObservacionAnterior) . ", " .
                            "Valor Nuevo: " . ucwords($txtObservacionNuevo) . $this->txtSalto;
                }
            }
        }

        /**
         * Condiciones Espaciales
         */
        $txtCambios .= "<b>[ " . $arrNuevo['seqFormulario'] . " ] Vivienda Usada [ Condiciones Espaciales ]:</b>" . $this->txtSalto;

        // Largo area multiple
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numLargoMultiple", "Largo Area Multiple");

        // Ancho area multiple
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAnchoMultiple", "Ancho Area Multiple");

        // Area multiple
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAreaMultiple", "Área Multiple");

        // Observaciones area multiple
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtMultiple", "Observación Área Multiple");

        // Largo alcoba 1
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numLargoAlcoba1", "Largo Alcoba 1");

        // Ancho alcoba 1
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAnchoAlcoba1", "Ancho Alcoba 1");

        // Area alcoba 1
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAreaAlcoba1", "Área Alcoba 1");

        // Observaciones alcoba 1
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtAlcoba1", "Observación Alcoba 1");

        // Largo alcoba 2
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numLargoAlcoba2", "Largo Alcoba 2");

        // Ancho alcoba 2
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAnchoAlcoba2", "Ancho Alcoba 2");

        // Area alcoba 2
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAreaAlcoba2", "Área Alcoba 2");

        // Observaciones alcoba 2
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtAlcoba2", "Observación Alcoba 2");

        // Largo alcoba 3
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numLargoAlcoba3", "Largo Alcoba 3");

        // Ancho alcoba 2
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAnchoAlcoba3", "Ancho Alcoba 3");

        // Area alcoba 2
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAreaAlcoba3", "Area Alcoba 3");

        // Observaciones alcoba 2
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtAlcoba3", "Observación Alcoba 3");

        // Largo cocina
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numLargoCocina", "Largo Cocina");

        // Ancho cocina
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAnchoCocina", "Ancho Cocina");

        // Area cocina
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAreaCocina", "Area Cocina");

        // Observaciones cocina
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtCocina", "Observación Cocina");

        // Largo baño1
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numLargoBano1", "Largo Baño 1");

        // Ancho baño1
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAnchoBano1", "Ancho Baño 1");

        // Area baño1
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAreaBano1", "Area Baño 1");

        // Observaciones baño 1
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtBano1", "Observación Baño 1");

        // Largo baño2
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numLargoBano2", "Largo Baño 2");

        // Ancho baño2
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAnchoBano2", "Ancho Baño 2");

        // Area baño2
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAreaBano2", "Area Baño 2");

        // Observaciones baño2
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtBano2", "Observación Baño 2");

        // Largo Lavanderia
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numLargoLavanderia", "Largo Lavanderia");

        // Ancho Lavanderia
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAnchoLavanderia", "Ancho Lavanderia");

        // Area Lavanderia
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAreaLavanderia", "Area Lavanderia");

        // Observaciones Lavanderia
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtLavanderia", "Observación Lavanderia");

        // Largo Circulaciones
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numLargoCirculaciones", "Largo Circulaciones");

        // Ancho Circulaciones
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAnchoCirculaciones", "Ancho Circulaciones");

        // Area Circulaciones
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAreaCirculaciones", "Area Circulaciones");

        // Observaciones Circulaciones
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtCirculaciones", "Observación Circulaciones");

        // Largo Patio
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numLargoPatio", "Largo Patio");

        // Ancho Patio
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAnchoPatio", "Ancho Patio");

        // Area Patio
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numAreaPatio", "Area Patio");

        // Observaciones Patio
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtPatio", "Observación Patio");

        /**
         * FISICAS Y ESTRUCTURALES
         */
        $txtCambios .= "<b>[ " . $arrNuevo['seqFormulario'] . " ] Vivienda Usada [ Fisicas y Estructurales ]:</b>" . $this->txtSalto;

        // Estado Cimentacion
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoCimentacion", "Estado Cimentación");

        // Observaciones Cimentacion
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtCimentacion", "Observaciones Cimentación");

        // Estado Placa de entrepiso
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoPlacaEntrepiso", "Estado Placa de Entrepiso");

        // Observaciones Placa de entrepiso
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtPlacaEntrepiso", "Observaciones Placa de Entrepiso");

        // Estado mamposteria
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoMamposteria", "Estado Mamposteria");

        // Observaciones mamposteria
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtMamposteria", "Observaciones Mamposteria");

        // Estado cubierta
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoCubierta", "Estado Cubierta");

        // Observaciones cubierta
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtCubierta", "Observaciones Cubierta");

        // Estado vigas
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoVigas", "Estado Vigas");

        // Observaciones vigas
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtVigas", "Observaciones Vigas");

        // Estado Columnas
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoColumnas", "Estado Columnas");

        // Observaciones Columnas
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtColumnas", "Observaciones Columnas");

        // Estado Panetes
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoPanetes", "Estado Pañetes");

        // Observaciones Panetes
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtPanetes", "Observaciones Pañetes");

        // Estado Enchapes y Accesorios
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoEnchapes", "Estado Enchapes y Accesorios");

        // Observaciones Enchapes y Accesorios
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEnchapes", "Observaciones Enchapes y Accesorios");

        // Estado Acabados Pisos
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoAcabados", "Estado Acabados Pisos");

        // Observaciones Acabados Pisos
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtAcabados", "Observaciones Acabados Pisos");

        // Estado Instalaciones Hidráulicas
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoHidraulicas", "Estado Instalaciones Hidráulicas");

        // Observaciones Instalaciones Hidráulicas
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtHidraulicas", "Observaciones Instalaciones Hidráulicas");

        // Estado Instalaciones Eléctricas
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoElectricas", "Estado Instalaciones Eléctricas");

        // Observaciones Instalaciones Eléctricas
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtElectricas", "Observaciones Instalaciones Eléctricas");

        // Estado Instalaciones Sanitarias
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoSanitarias", "Estado Instalaciones Sanitarias");

        // Observaciones Instalaciones Sanitarias
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtSanitarias", "Observaciones Instalaciones Sanitarias");

        // Estado Instalaciones Gas
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoGas", "Estado Instalaciones Gas");

        // Observaciones Instalaciones Gas
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtGas", "Observaciones Instalaciones Gas");

        // Estado Carpinteria Madera
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoMadera", "Estado Carpinteria Madera");

        // Observaciones Carpinteria Madera
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtMadera", "Observaciones Carpinteria Madera");

        // Estado Carpinteria Metallica
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoMadera", "Estado Carpinteria Metalica");

        // Observaciones Carpinteria Metallica
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtMadera", "Observaciones Carpinteria Metalica");

        // Numero de lavaderos
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numLavadero", "Lavaderos");

        // Observaciones Lavaderos
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtLavadero", "Observaciones Lavaderos");

        // Numero de lavaplatos
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numLavadero", "Lavaplatos");

        // Observaciones lavaplatos
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtLavadero", "Observaciones Lavaplatos");

        // Numero de Sanitarios
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numSanitarios", "Sanitarios");

        // Observaciones Sanitarios
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtSanitarios", "Observaciones Sanitarios");

        // Numero de Ducha
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numDucha", "Ducha");

        // Observaciones Ducha
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtDucha", "Observaciones Ducha");

        // Estado Vidios
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoVidrios", "Vidrios");

        // Observaciones Carpinteria Metallica
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtVidrios", "Observaciones Vidrios");

        // Estado Pintura
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoPintura", "Estado Pintura");

        // Observaciones Pintura
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtPintura", "Observaciones Pintura");

        // Estado Pintura
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtOtros", "Estado Otros");

        // Observaciones Pintura
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtObservacionOtros", "Observaciones Otros");

        /**
         * FISICAS Y ESTRUCTURALES
         */
        $txtCambios .= "<b>[ " . $arrNuevo['seqFormulario'] . " ] Vivienda Usada [ Servicios Publicos ]:</b>" . $this->txtSalto;

        // Contador de agua
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numContadorAgua", "Contador de Agua");

        // Estado Contador agua
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoConexionAgua", "Estado Conexión Agua");

        // Observaciones agua
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtDescripcionAgua", "Observaciones Servicio Agua");

        // Contador de energia
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numContadorEnergia", "Contador de Energía");

        // Estado Contador energia
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoConexionEnergia", "Estado Conexión Energía");

        // Observaciones energia
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtDescripcionEnergia", "Observaciones Servicio Energía");

        // Contador de alcantarillado
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numContadorAlcantarillado", "Contador de Alcantarillado");

        // Estado Contador alcantarillado
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoConexionAlcantarillado", "Estado Conexión Alcantarillado");

        // Observaciones alcantarillado
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtDescripcionAlcantarillado", "Observaciones Servicio Alcantarillado");

        // Contador de gas
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numContadorGas", "Contador de Gas");

        // Estado Contador gas
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoConexionGas", "Estado Conexión Gas");

        // Observaciones gas
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtDescripcionGas", "Observaciones Servicio Gas");

        // Contador de telefono
        $txtCambios .= $this->comparacionNumeros($objAnterior->arrTecnico, $arrNuevo, "numContadorTelefono", "Contador de Teléfono");

        // Estado Contador telefono
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoConexionTelefono", "Estado Conexión Teléfono");

        // Observaciones telefono
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtDescripcionTelefono", "Observaciones Servicio Teléfono");

        // Estado Andenes
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoConexionAndenes", "Estado Conexión Andenes");

        // Observaciones Andenes
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtDescripcionAndenes", "Observaciones Andenes");

        // Estado Vias
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoConexionVias", "Estado Conexión Vias");

        // Observaciones Vias
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtDescripcionVias", "Observaciones Telefono");

        // Estado Servicios Comunales
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtEstadoServiciosComunales", "Servicios Comunales");

        // Observaciones Servicios Comunales
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtDescripcionServiciosComunales", "Observaciones Servicios Comunales");

        // Descripcion de la vivienda
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtDescripcionVivienda", "Descripcion de la Vivienda");

        // Cumple con la norma NSR98
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtNormaNSR98", "Cumple con los requisitos de la norma NSR-98");

        // Recomendaciones norma NSR98
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtDescipcionNormaNSR98", "Recomendaciones norma NSR-98");

        // Cumple con los requisitos de terminación, calidad y estabilidad
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtRequisitos", "Cumple con los requisitos de terminación calidad y estabilidad");

        // Recomendaciones de terminación, calidad y estabilidad
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtDescripcionRequisitos", "Recomendaciones de terminación calidad y estabilidad");

        // txtDescripcionExistencia de existencia y habitabilidad
        $txtCambios .= $this->comparacionTexto($objAnterior->arrTecnico, $arrNuevo, "txtDescripcionExistencia", "Recomendaciones de existencia y habitabilidad");

        /**
         * REGISTRO FOTOGRAFICO
         */
        $txtCambios .= "<b>[ " . $arrNuevo['seqFormulario'] . " ] Vivienda Usada [ Registro Fotografico ]:</b>" . $this->txtSalto;

        // Cantidad de imagenes cargadas
        $numImagenesAnterior = count($objAnterior->arrJuridico['imagenes']);
        $numImagenesNuevo = count($arrNuevo['nombreArchivoCargado']);
        if ($numImagenesAnterior != $numImagenesNuevo) {
            $txtCambios .= $this->txtSeparador . "Imágenes Cargadas, Valor Anterior: " . $numImagenesAnterior . ", " .
                    "Valor Nuevo: " . $numImagenesNuevo . $this->txtSalto;
        }

        return $txtCambios;
    }

    /**
     * 	DESEMBOLSO ESTUDIO DE TITULOS
     */
    private function cambiosEstudioTitulos($objAnterior, $arrNuevo) {

        $claFormulario = new FormularioSubsidios;
        $claFormulario->cargarFormulario($arrNuevo['seqFormulario']);

        $txtCambios = "<b>[ " . $arrNuevo['seqFormulario'] . " ] Datos del Formulario:</b>" . $this->txtSalto;

        // Estado del proceso
        $txtValorAnterior = $claFormulario->seqEstadoProceso;
        $txtValorNuevo = $arrNuevo['seqEstadoProceso'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $arrEstados = estadosProceso();
            $txtCambios .= $this->txtSeparador . "Estado del Proceso, Valor Anterior: " . $arrEstados[$txtValorAnterior] . ", " .
                    "Valor Nuevo: " . $arrEstados[$txtValorNuevo] . $this->txtSalto;
        }

        // Aprobo
        $txtValorAnterior = strtolower(trim($objAnterior->arrTitulos['txtAprobo']));
        $txtValorNuevo = strtolower(trim($arrNuevo['aprobo']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Aprobó, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                    "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        $txtCambios .= "<b>[ " . $arrNuevo['seqFormulario'] . " ] Estudio de Titulos:</b>" . $this->txtSalto;

        // Numero de escritura Identificacion
        $txtValorAnterior = $objAnterior->arrTitulos['numEscrituraIdentificacion'];
        $txtValorNuevo = $arrNuevo['escritura1'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Numero Escritura Identificacion, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Fecha de escritura publica Identificacion
        $txtValorAnterior = $objAnterior->arrTitulos['fchEscrituraIdentificacion'];
        $txtValorNuevo = $arrNuevo['fecha1'];

        list( $ano, $mes, $dia ) = split("[/-]", $txtValorAnterior);
        if (@checkdate($mes, $dia, $ano) === false) {
            $txtValorAnterior = 0;
        } else {
            $txtValorAnterior = strtotime($txtValorAnterior);
        }

        list( $ano, $mes, $dia ) = split("[/-]", $txtValorNuevo);
        if (@checkdate($mes, $dia, $ano) === false) {
            $txtValorNuevo = 0;
        } else {
            $txtValorNuevo = strtotime($txtValorNuevo);
        }

        if ($txtValorAnterior != $txtValorNuevo) {
            if ($txtValorAnterior == 0) {
                $txtValorAnterior = "Ninguno";
            } else {
                $txtValorAnterior = date("Y-m-d", $txtValorAnterior);
            }
            if ($txtValorNuevo == 0) {
                $txtValorNuevo = "Ninguno";
            } else {
                $txtValorNuevo = date("Y-m-d", $txtValorNuevo);
            }
            $txtCambios .= $this->txtSeparador . "Fecha Escritura Identificacion, Valor Anterior: $txtValorAnterior, Valor Nuevo: $txtValorNuevo" . $this->txtSalto;
        }

        // Numero de Notaria Identificacion
        $txtValorAnterior = $objAnterior->arrTitulos['numNotariaIdentificacion'];
        $txtValorNuevo = $arrNuevo['notaria1'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Numero Notaría Identificacion, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Ciudad de la notaria identificacion
        $txtValorAnterior = $objAnterior->arrTitulos['txtCiudadIdentificacion'];
        $txtValorNuevo = $arrNuevo['ciudadIdentificacion'];
        if (trim(strtolower($txtValorAnterior)) != trim(strtolower($txtValorNuevo))) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Ciudad Notaría Identificacion, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Numero de escritura Titulo
        $txtValorAnterior = $objAnterior->arrTitulos['numEscrituraTitulo'];
        $txtValorNuevo = $arrNuevo['escritura2'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Numero Escritura Titulo, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Fecha de escritura publica Titulo
        $txtValorAnterior = $objAnterior->arrTitulos['fchEscrituraTitulo'];
        $txtValorNuevo = $arrNuevo['fecha2'];

        list( $ano, $mes, $dia ) = split("[/-]", $txtValorAnterior);
        if (@checkdate($mes, $dia, $ano) === false) {
            $txtValorAnterior = 0;
        } else {
            $txtValorAnterior = strtotime($txtValorAnterior);
        }

        list( $ano, $mes, $dia ) = split("[/-]", $txtValorNuevo);
        if (@checkdate($mes, $dia, $ano) === false) {
            $txtValorNuevo = 0;
        } else {
            $txtValorNuevo = strtotime($txtValorNuevo);
        }

        if ($txtValorAnterior != $txtValorNuevo) {
            if ($txtValorAnterior == 0) {
                $txtValorAnterior = "Ninguno";
            } else {
                $txtValorAnterior = date("Y-m-d", $txtValorAnterior);
            }
            if ($txtValorNuevo == 0) {
                $txtValorNuevo = "Ninguno";
            } else {
                $txtValorNuevo = date("Y-m-d", $txtValorNuevo);
            }
            $txtCambios .= $this->txtSeparador . "Fecha Escritura Titulo, Valor Anterior: $txtValorAnterior, Valor Nuevo: $txtValorNuevo" . $this->txtSalto;
        }

        // Numero de Notaria Titulo
        $txtValorAnterior = $objAnterior->arrTitulos['numNotariaTitulo'];
        $txtValorNuevo = $arrNuevo['notaria2'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Numero Notaría Titulo, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Ciudad de la notaria titulo
        $txtValorAnterior = $objAnterior->arrTitulos['txtCiudadTitulo'];
        $txtValorNuevo = $arrNuevo['ciudadAdquisicion'];
        if (trim(strtolower($txtValorAnterior)) != trim(strtolower($txtValorNuevo))) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Ciudad Notaría Titulo, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }


        // Numero de Folio Titulo
        $txtValorAnterior = $objAnterior->arrTitulos['numFolioMatricula'];
        $txtValorNuevo = $arrNuevo['numerofolio'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folio de Matricula, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Zona instrumentos publicos
        $txtValorAnterior = strtolower(trim($objAnterior->arrTitulos['txtZonaMatricula']));
        $txtValorNuevo = strtolower(trim($arrNuevo['zona']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Zona Instrumentos Publicos, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                    "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // Fecha de Matricula
        $txtValorAnterior = $objAnterior->arrTitulos['fchMatricula'];
        $txtValorNuevo = $arrNuevo['fechaMatricula'];

        list( $ano, $mes, $dia ) = split("[/-]", $txtValorAnterior);
        if (@checkdate($mes, $dia, $ano) === false) {
            $txtValorAnterior = 0;
        } else {
            $txtValorAnterior = strtotime($txtValorAnterior);
        }

        list( $ano, $mes, $dia ) = split("[/-]", $txtValorNuevo);
        if (@checkdate($mes, $dia, $ano) === false) {
            $txtValorNuevo = 0;
        } else {
            $txtValorNuevo = strtotime($txtValorNuevo);
        }

        if ($txtValorAnterior != $txtValorNuevo) {
            if ($txtValorAnterior == 0) {
                $txtValorAnterior = "Ninguno";
            } else {
                $txtValorAnterior = date("Y-m-d", $txtValorAnterior);
            }
            if ($txtValorNuevo == 0) {
                $txtValorNuevo = "Ninguno";
            } else {
                $txtValorNuevo = date("Y-m-d", $txtValorNuevo);
            }
            $txtCambios .= $this->txtSeparador . "Fecha Matricula, Valor Anterior: $txtValorAnterior, Valor Nuevo: $txtValorNuevo" . $this->txtSalto;
        }

        // Subsidio de fonvivienda
        $txtValorAnterior = $objAnterior->arrTitulos['bolSubsidioFonvivienda'];
        $txtValorNuevo = ( isset($arrNuevo['subsidioFonvivienda']) ) ? 1 : 0;
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
            $txtCambios .= $this->txtSeparador . "Subsidio de Fonvivienda, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // resolucion fonvivienda
        $txtValorAnterior = $objAnterior->arrTitulos['numResolucionFonvivienda'];
        $txtValorNuevo = $arrNuevo['resolucion'];
        if (intval($txtValorAnterior) != intval($txtValorNuevo)) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Numero Resolucion Fonvivienda, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // año resolucion fonvivienda
        $txtValorAnterior = $objAnterior->arrTitulos['numAnoResolucionFonvivienda'];
        $txtValorNuevo = $arrNuevo['ano'];
        if (intval($txtValorAnterior) != intval($txtValorNuevo)) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Año Resolucion Fonvivienda, Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        $txtCambios .= $this->txtSeparador . "<b>Observaciones:</b>" . $this->txtSalto;

        // Observaciones
        $arrObservacionAnterior = $objAnterior->arrTitulos['observacion'];
        $arrObservacionNuevo = $arrNuevo['observacion'];
        if (is_array($arrObservacionNuevo)) {

            foreach ($arrObservacionNuevo as $numObservacion => $txtObservacionNuevo) {

                if (isset($arrObservacionAnterior[$numObservacion])) {
                    $txtObservacionAnterior = $arrObservacionAnterior[$numObservacion];
                } else {
                    $txtObservacionAnterior = "Ninguno";
                }

                if ($txtObservacionAnterior != $txtObservacionNuevo) {
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador .
                            "Observacion " . ( $numObservacion + 1 ) . ", " .
                            "Valor Anterior: " . ucwords($txtObservacionAnterior) . ", " .
                            "Valor Nuevo: " . ucwords($txtObservacionNuevo) . $this->txtSalto;
                }
            }
        }

        if (is_array($arrObservacionAnterior)) {
            foreach ($arrObservacionAnterior as $numObservacion => $txtObservacionAnterior) {
                if (!isset($arrObservacionNuevo[$numObservacion])) {
                    $txtObservacionNuevo = "Ninguno";
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador .
                            "Observacion " . ( $numObservacion + 1 ) . ", " .
                            "Valor Anterior: " . ucwords($txtObservacionAnterior) . ", " .
                            "Valor Nuevo: " . ucwords($txtObservacionNuevo) . $this->txtSalto;
                }
            }
        }

        $txtCambios .= $this->txtSeparador . "<b>Documentos:</b>" . $this->txtSalto;

        // Documentos
        $arrObservacionAnterior = $objAnterior->arrTitulos['documentos'];
        $arrObservacionNuevo = $arrNuevo['documento'];
        if (is_array($arrObservacionNuevo)) {

            foreach ($arrObservacionNuevo as $numObservacion => $txtObservacionNuevo) {

                if (isset($arrObservacionAnterior[$numObservacion])) {
                    $txtObservacionAnterior = $arrObservacionAnterior[$numObservacion];
                } else {
                    $txtObservacionAnterior = "Ninguno";
                }

                if ($txtObservacionAnterior != $txtObservacionNuevo) {
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador .
                            "Documento " . ( $numObservacion + 1 ) . ", " .
                            "Valor Anterior: " . ucwords($txtObservacionAnterior) . ", " .
                            "Valor Nuevo: " . ucwords($txtObservacionNuevo) . $this->txtSalto;
                }
            }
        }

        if (is_array($arrObservacionAnterior)) {
            foreach ($arrObservacionAnterior as $numObservacion => $txtObservacionAnterior) {
                if (!isset($arrObservacionNuevo[$numObservacion])) {
                    $txtObservacionNuevo = "Ninguno";
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador .
                            "Documento " . ( $numObservacion + 1 ) . ", " .
                            "Valor Anterior: " . ucwords($txtObservacionAnterior) . ", " .
                            "Valor Nuevo: " . ucwords($txtObservacionNuevo) . $this->txtSalto;
                }
            }
        }

        $txtCambios .= $this->txtSeparador . "<b>Recomendaciones:</b>" . $this->txtSalto;

        // Recomendaciones
        $arrObservacionAnterior = $objAnterior->arrTitulos['recomendaciones'];
        $arrObservacionNuevo = $arrNuevo['recomendaciones'];
        if (is_array($arrObservacionNuevo)) {

            foreach ($arrObservacionNuevo as $numObservacion => $txtObservacionNuevo) {

                if (isset($arrObservacionAnterior[$numObservacion])) {
                    $txtObservacionAnterior = $arrObservacionAnterior[$numObservacion];
                } else {
                    $txtObservacionAnterior = "Ninguno";
                }

                if ($txtObservacionAnterior != $txtObservacionNuevo) {
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador .
                            "Recomendacion " . ( $numObservacion + 1 ) . ", " .
                            "Valor Anterior: " . ucwords($txtObservacionAnterior) . ", " .
                            "Valor Nuevo: " . ucwords($txtObservacionNuevo) . $this->txtSalto;
                }
            }
        }

        if (is_array($arrObservacionAnterior)) {
            foreach ($arrObservacionAnterior as $numObservacion => $txtObservacionAnterior) {
                if (!isset($arrObservacionNuevo[$numObservacion])) {
                    $txtObservacionNuevo = "Ninguno";
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador .
                            "Recomendacion " . ( $numObservacion + 1 ) . ", " .
                            "Valor Anterior: " . ucwords($txtObservacionAnterior) . ", " .
                            "Valor Nuevo: " . ucwords($txtObservacionNuevo) . $this->txtSalto;
                }
            }
        }

        return $txtCambios;
    }

    /**
     * SOLICITUD DE DESEMBOLSO
     */
    private function cambiosSolicitudDesembolso($objAnterior, $arrNuevo) {

        $claFormulario = new FormularioSubsidios;
        $claFormulario->cargarFormulario($arrNuevo['seqFormulario']);

        $txtCambios = "<b>[ " . $arrNuevo['seqFormulario'] . " ] Datos del Formulario:</b>" . $this->txtSalto;

        // Estado del proceso
        $txtValorAnterior = $claFormulario->seqEstadoProceso;
        $txtValorNuevo = $arrNuevo['seqEstadoProceso'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $arrEstados = estadosProceso();
            $txtCambios .= $this->txtSeparador . "Estado del Proceso, Valor Anterior: " . $arrEstados[$txtValorAnterior] . ", " .
                    "Valor Nuevo: " . $arrEstados[$txtValorNuevo] . $this->txtSalto;
        }

        if (is_array($objAnterior->arrSolicitud)) { // registro existente
            foreach ($objAnterior->arrSolicitud['resumen']['fechas'] as $seqSolicitud => $fchSolicitud) {
                $arrInformacion = $objAnterior->arrSolicitud['detalles'][$seqSolicitud];

                $txtCambios .= "<b>[ No Solicitud $seqSolicitud ] " . $fchSolicitud . ":</b>" . $this->txtSalto;
                if ($seqSolicitud == $arrNuevo['seqSolicitudEditar']) {

                    // Numero del proyecto de inversion
                    $txtValorAnterior = $arrInformacion['numProyectoInversion'];
                    $txtValorNuevo = $arrNuevo['numProyectoInversion'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Numero Proyecto Inversion, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Registro presupuestal 1
                    $txtValorAnterior = intval($arrInformacion['numRegistroPresupuestal1']);
                    $txtValorNuevo = intval($arrNuevo['registro1']);
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Numero Registro Presupuestal 1, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Fecha del registro presupuestal 1
                    $txtValorAnterior = ( strtotime($arrInformacion['fchRegistroPresupuestal1']) === false ) ? 0 : strtotime($arrInformacion['fchRegistroPresupuestal1']);
                    $txtValorNuevo = ( strtotime($arrNuevo['fecha1']) === false ) ? 0 : strtotime($arrNuevo['fecha1']);
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : date("Y-m-d", $txtValorAnterior);
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : date("Y-m-d", $txtValorNuevo);
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Fecha Registro Presupuestal 1, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Registro presupuestal 2
                    $txtValorAnterior = intval($arrInformacion['numRegistroPresupuestal2']);
                    $txtValorNuevo = intval($arrNuevo['registro2']);
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Numero Registro Presupuestal 2, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Fecha del registro presupuestal 2
                    $txtValorAnterior = ( strtotime($arrInformacion['fchRegistroPresupuestal2']) === false ) ? 0 : strtotime($arrInformacion['fchRegistroPresupuestal2']);
                    $txtValorNuevo = ( strtotime($arrNuevo['fecha2']) === false ) ? 0 : strtotime($arrNuevo['fecha2']);
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : date("Y-m-d", $txtValorAnterior);
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : date("Y-m-d", $txtValorNuevo);
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Fecha Registro Presupuestal 2, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Nombre del beneficiario del giro
                    $txtValorAnterior = $arrInformacion['txtNombreBeneficiarioGiro'];
                    $txtValorNuevo = $arrNuevo['txtNombreBeneficiarioGiro'];
                    if (trim($txtValorAnterior) != trim($txtValorNuevo)) {
                        $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Nombre del beneficiario del Giro, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Numero de documento del beneficiario del giro
                    $txtValorAnterior = $arrInformacion['numDocumentoBeneficiarioGiro'];
                    $txtValorNuevo = $arrNuevo['numDocumentoBeneficiarioGiro'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Documento del beneficiario del Giro, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Direccion del beneficiario del giro
                    $txtValorAnterior = $arrInformacion['txtDireccionBeneficiarioGiro'];
                    $txtValorNuevo = $arrNuevo['txtDireccionBeneficiarioGiro'];
                    if (trim($txtValorAnterior) != trim($txtValorNuevo)) {
                        $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Dirección del beneficiario del Giro, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Telefono de documento del beneficiario del giro
                    $txtValorAnterior = $arrInformacion['numTelefonoGiro'];
                    $txtValorNuevo = $arrNuevo['numTelefonoGiro'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Teléfono del beneficiario del Giro, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Correo Electrónico del beneficiario del giro
                    $txtValorAnterior = $arrInformacion['txtCorreoGiro'];
                    $txtValorNuevo = $arrNuevo['txtCorreoGiro'];
                    if (trim($txtValorAnterior) != trim($txtValorNuevo)) {
                        $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Correo Electrónico del beneficiario del Giro, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }
                    // Numero de cuenta del beneficiario del giro
                    $txtValorAnterior = $arrInformacion['numCuentaGiro'];
                    $txtValorNuevo = $arrNuevo['numCuentaGiro'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Cuenta Beneficiario Giro, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Tipo de cuenta del beneficiario del giro
                    $txtValorAnterior = $arrInformacion['txtTipoCuentaGiro'];
                    $txtValorNuevo = $arrNuevo['txtTipoCuentaGiro'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Tipo Cuenta Beneficiario Giro, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Banco de la cuenta del giro
                    $txtValorAnterior = $arrInformacion['seqBancoGiro'];
                    $txtValorNuevo = $arrNuevo['seqBancoGiro'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 1 ) ? "NINGUNO" : obtenerNombres("T_FRM_BANCO", "seqBanco", $txtValorAnterior);
                        $txtValorNuevo = ( $txtValorNuevo == 1 ) ? "NINGUNO" : obtenerNombres("T_FRM_BANCO", "seqBanco", $txtValorNuevo);
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Banco Beneficiario Giro, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Valor Solicitado
                    $txtValorAnterior = $arrInformacion['valSolicitado'];
                    $txtValorNuevo = $arrNuevo['valor'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Valor Solicitado, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    $txtCambios .= $this->txtSeparador . "<b>Documentos</b>" . $this->txtSalto;

                    // Copia Cédula Beneficiario
                    $txtValorAnterior = $arrInformacion['bolDocumentoBeneficiario'];
                    $txtValorNuevo = $arrNuevo['bolCedulaBeneficiario'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia Cédula Beneficiario, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }


                    // Observaciones Copia Cédula Beneficiario
                    $txtValorAnterior = $arrInformacion['txtDocumentoBeneficiario'];
                    $txtValorNuevo = $arrNuevo['txtCedulaBeneficiario'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Copia Cédula Beneficiario, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Copia Carta de Asignacion
                    $txtValorAnterior = $arrInformacion['bolCartaAsignacion'];
                    $txtValorNuevo = $arrNuevo['bolCartaAsignacion'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia Carta Asignacion, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Observaciones Carta de Asignacion
                    $txtValorAnterior = $arrInformacion['txtCartaAsignacion'];
                    $txtValorNuevo = $arrNuevo['txtCartaAsignacion'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Copia Carta Asignacion, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    if ($claFormulario->seqModalidad != 5) { // documentos para otras modalidades
                        if ($objAnterior->txtTipoDocumentos == "persona") {

                            // Copia Cédula Vendedor
                            $txtValorAnterior = $arrInformacion['bolDocumentoVendedor'];
                            $txtValorNuevo = $arrNuevo['bolCedulaVendedor'];
                            if ($txtValorAnterior != $txtValorNuevo) {
                                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia Cédula Vendedor, Valor Anterior: " . $txtValorAnterior . ", " .
                                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                            }

                            // Observaciones Copia Cédula Vendedor
                            $txtValorAnterior = $arrInformacion['txtDocumentoVendedor'];
                            $txtValorNuevo = $arrNuevo['txtCedulaVendedor'];
                            if ($txtValorAnterior != $txtValorNuevo) {
                                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Copia Cédula Vendedor, Valor Anterior: " . $txtValorAnterior . ", " .
                                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                            }
                        } else {

                            // Copia RUT
                            $txtValorAnterior = $arrInformacion['bolRut'];
                            $txtValorNuevo = $arrNuevo['bolRut'];
                            if ($txtValorAnterior != $txtValorNuevo) {
                                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia RUT, Valor Anterior: " . $txtValorAnterior . ", " .
                                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                            }

                            // Observaciones Copia RUT
                            $txtValorAnterior = $arrInformacion['txtRut'];
                            $txtValorNuevo = $arrNuevo['txtRut'];
                            if ($txtValorAnterior != $txtValorNuevo) {
                                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Rut, Valor Anterior: " . $txtValorAnterior . ", " .
                                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                            }

                            // Copia NIT
                            $txtValorAnterior = $arrInformacion['bolNit'];
                            $txtValorNuevo = $arrNuevo['bolNit'];
                            if ($txtValorAnterior != $txtValorNuevo) {
                                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia Nit, Valor Anterior: " . $txtValorAnterior . ", " .
                                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                            }

                            // Observaciones NIT
                            $txtValorAnterior = $arrInformacion['txtNit'];
                            $txtValorNuevo = $arrNuevo['txtNit'];
                            if ($txtValorAnterior != $txtValorNuevo) {
                                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Nit, Valor Anterior: " . $txtValorAnterior . ", " .
                                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                            }

                            // Copia Representante Legal
                            $txtValorAnterior = $arrInformacion['bolCedulaRepresentante'];
                            $txtValorNuevo = $arrNuevo['bolCedulaRepresentante'];
                            if ($txtValorAnterior != $txtValorNuevo) {
                                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia Cédula Representante Legal, Valor Anterior: " . $txtValorAnterior . ", " .
                                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                            }

                            // Observaciones Copia Representante Legal
                            $txtValorAnterior = $arrInformacion['txtCedulaRepresentante'];
                            $txtValorNuevo = $arrNuevo['txtCedulaRepresentante'];
                            if ($txtValorAnterior != $txtValorNuevo) {
                                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Cédula Representante Legal, Valor Anterior: " . $txtValorAnterior . ", " .
                                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                            }

                            // Copia Camara y comercio
                            $txtValorAnterior = $arrInformacion['bolCamaraComercio'];
                            $txtValorNuevo = $arrNuevo['bolCamaraComercio'];
                            if ($txtValorAnterior != $txtValorNuevo) {
                                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia Camara y Comercio, Valor Anterior: " . $txtValorAnterior . ", " .
                                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                            }

                            // Observaciones Camara y comercio
                            $txtValorAnterior = $arrInformacion['txtCamaraComercio'];
                            $txtValorNuevo = $arrNuevo['txtCamaraComercio'];
                            if ($txtValorAnterior != $txtValorNuevo) {
                                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Camara y Comercio, Valor Anterior: " . $txtValorAnterior . ", " .
                                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                            }
                        } // fin if documentos empresa
                        // Copia Giro a terceros
                        $txtValorAnterior = $arrInformacion['bolGiroTercero'];
                        $txtValorNuevo = $arrNuevo['bolGiroTercero'];
                        if ($txtValorAnterior != $txtValorNuevo) {
                            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Autorizacion de giro a terceros, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }

                        // Observaciones Giro a terceros
                        $txtValorAnterior = $arrInformacion['txtGiroTercero'];
                        $txtValorNuevo = $arrNuevo['txtGiroTercero'];
                        if (trim($txtValorAnterior) != trim($txtValorNuevo)) {
                            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Autorizacion de giro a terceros, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }

                        // Copia Certificacion bancaria
                        $txtValorAnterior = $arrInformacion['bolCertificacionBancaria'];
                        $txtValorNuevo = $arrNuevo['bolCertificacionBancaria'];
                        if ($txtValorAnterior != $txtValorNuevo) {
                            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia Certificacion Bancaria, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }

                        // Observaciones Certificacion bancaria
                        $txtValorAnterior = $arrInformacion['txtCertificacionBancaria'];
                        $txtValorNuevo = $arrNuevo['txtCertificacionBancaria'];
                        if ($txtValorAnterior != $txtValorNuevo) {
                            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Copia Certificacion Bancaria, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }

                        // Copia Autorizacion de desembolso
                        $txtValorAnterior = $arrInformacion['bolAutorizacion'];
                        $txtValorNuevo = $arrNuevo['bolAutorizacion'];
                        if ($txtValorAnterior != $txtValorNuevo) {
                            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia Autorizacion de desembolso, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }

                        // Observaciones Autorizacion de desembolso
                        $txtValorAnterior = $arrInformacion['txtAutorizacion'];
                        $txtValorNuevo = $arrNuevo['txtAutorizacion'];
                        if ($txtValorAnterior != $txtValorNuevo) {
                            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Copia Autorizacion de desembolso, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }
                    } else { // documentos modalidad de arriendo
                        // Contrato de Arriendo
                        $txtValorAnterior = $arrInformacion['bolContratoArrendamiento'];
                        $txtValorNuevo = $arrNuevo['bolContratoArrendamiento'];
                        if ($txtValorAnterior != $txtValorNuevo) {
                            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Contrato de Arrendamiento, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }

                        // Observaciones Contrato de Arriendo
                        $txtValorAnterior = $arrInformacion['txtContratoArrendamiento'];
                        $txtValorNuevo = $arrNuevo['txtContratoArrendamiento'];
                        if ($txtValorAnterior != $txtValorNuevo) {
                            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Contrato de Arrendamiento, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }

                        // Cédula del Arrendador
                        $txtValorAnterior = $arrInformacion['bolCedulaArrendador'];
                        $txtValorNuevo = $arrNuevo['bolCedulaArrendador'];
                        if ($txtValorAnterior != $txtValorNuevo) {
                            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Cédula del Arrendador, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }

                        // Observaciones Cédula del Arrendador
                        $txtValorAnterior = $arrInformacion['txtCedulaArrendador'];
                        $txtValorNuevo = $arrNuevo['txtCedulaArrendador'];
                        if ($txtValorAnterior != $txtValorNuevo) {
                            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Cédula del Arrendador, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }

                        // Certificación bancaria del arrendador
                        $txtValorAnterior = $arrInformacion['bolBancoArrendador'];
                        $txtValorNuevo = $arrNuevo['bolBancoArrendador'];
                        if ($txtValorAnterior != $txtValorNuevo) {
                            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Certificación bancaria del arrendador, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }

                        // Observaciones Certificación bancaria del arrendador
                        $txtValorAnterior = $arrInformacion['txtBancoArrendador'];
                        $txtValorNuevo = $arrNuevo['txtBancoArrendador'];
                        if ($txtValorAnterior != $txtValorNuevo) {
                            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Certificación bancaria del arrendador, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }

                        // Certificación de tradicion y libertad
                        $txtValorAnterior = $arrInformacion['bolTradicion'];
                        $txtValorNuevo = $arrNuevo['bolTradicion'];
                        if ($txtValorAnterior != $txtValorNuevo) {
                            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Certificación de tradicion y libertad, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }

                        // Observaciones Certificación de tradicion y libertad
                        $txtValorAnterior = $arrInformacion['txtTradicion'];
                        $txtValorNuevo = $arrNuevo['txtTradicion'];
                        if ($txtValorAnterior != $txtValorNuevo) {
                            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Certificación de tradicion y libertad, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }

                        // Utimos tres recibos de pago 
                        $txtValorAnterior = $arrInformacion['bolRecibosServicios'];
                        $txtValorNuevo = $arrNuevo['bolRecibosServicios'];
                        if ($txtValorAnterior != $txtValorNuevo) {
                            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Utimos tres recibos de pago, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }

                        // Observaciones Utimos tres recibos de pago
                        $txtValorAnterior = $arrInformacion['txtRecibosServicios'];
                        $txtValorNuevo = $arrNuevo['txtRecibosServicios'];
                        if ($txtValorAnterior != $txtValorNuevo) {
                            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Utimos tres recibos de pago, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }

                        // Autorizacion de retiro de fondos
                        $txtValorAnterior = $arrInformacion['bolAutorizacionRetiro'];
                        $txtValorNuevo = $arrNuevo['bolAutorizacionRetiro'];
                        if ($txtValorAnterior != $txtValorNuevo) {
                            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Autorizacion de retiro de fondos, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }

                        // Observaciones Certificación de tradicion y libertad
                        $txtValorAnterior = $arrInformacion['txtAutorizacionRetiro'];
                        $txtValorNuevo = $arrNuevo['txtAutorizacionRetiro'];
                        if ($txtValorAnterior != $txtValorNuevo) {
                            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                            $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Autorizacion de retiro de fondos, Valor Anterior: " . $txtValorAnterior . ", " .
                                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                        }
                    }  // fin documentos en modalidad de arriendo
                    // Nombre Subsecretaria
                    $txtValorAnterior = $arrInformacion['txtSubsecretaria'];
                    $txtValorNuevo = $arrNuevo['txtSubsecretaria'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Firma Subsecretaria, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Subsecretaria Encargado
                    $txtValorAnterior = intval($arrInformacion['bolSubsecretariaEncargado']);
                    $txtValorNuevo = intval($arrNuevo['bolSubsecretariaEncargado']);
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Subsecretario encargado, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Nombre Subdireccion
                    $txtValorAnterior = $arrInformacion['txtSubdireccion'];
                    $txtValorNuevo = $arrNuevo['txtSubdireccion'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Firma Subdireccion, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }


                    // Sub direccion encargado
                    $txtValorAnterior = intval($arrInformacion['bolSubdireccionEncargado']);
                    $txtValorNuevo = intval($arrNuevo['bolSubdireccionEncargado']);
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Subdireccion encargado, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Revision 
                    $txtValorAnterior = $arrInformacion['txtRevisoSubsecretaria'];
                    $txtValorNuevo = $arrNuevo['txtRevisoSubsecretaria'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Firma Revision, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Numero de radicacion
                    $txtValorAnterior = intval($arrInformacion['numRadiacion']);
                    $txtValorNuevo = intval($arrNuevo['numeroRadicado']);
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Numero Radicacion, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Fecha de Radicacion
                    $txtValorAnterior = ( strtotime($arrInformacion['fchRadicacion']) === false ) ? 0 : strtotime($arrInformacion['fchRadicacion']);
                    ;
                    $txtValorNuevo = ( strtotime($arrNuevo['fechaRadicado']) === false ) ? 0 : strtotime($arrNuevo['fechaRadicado']);
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : date("Y-m-d", $txtValorAnterior);
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : date("Y-m-d", $txtValorNuevo);
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Fecha Radicacion, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Numero de orden de pago
                    $txtValorAnterior = intval($arrInformacion['numOrden']);
                    $txtValorNuevo = intval($arrNuevo['numeroOrden']);
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Numero Orden de Pago, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Fecha de Orden de Pago
                    $txtValorAnterior = ( strtotime($arrInformacion['fchOrden']) === false ) ? 0 : strtotime($arrInformacion['fchOrden']);
                    $txtValorNuevo = ( strtotime($arrNuevo['fechaOrden']) === false ) ? 0 : strtotime($arrNuevo['fechaOrden']);
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : date("Y-m-d", $txtValorAnterior);
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : date("Y-m-d", $txtValorNuevo);
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Fecha Orden de pago, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Monto de orden de pago
                    $txtValorAnterior = $arrInformacion['valOrden'];
                    $txtValorNuevo = $arrNuevo['monto'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Valor Orden de Pago, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }
                }
            }
        }

        if (intval($arrNuevo['seqSolicitudEditar']) == 0) { // Registro nuevo
            $txtCambios .= "<b>[ Nueva Solicitud ] " . date("Y-m-d") . ":</b>" . $this->txtSalto;

            $txtCambios .= $this->txtSeparador . "<b>Datos del Subsidio</b>" . $this->txtSalto;

            // Numero del proyecto de inversion
            $txtValorAnterior = 0;
            $txtValorNuevo = $arrNuevo['numProyectoInversion'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Numero Proyecto Inversion, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Registro presupuestal 1
            $txtValorAnterior = 0;
            $txtValorNuevo = $arrNuevo['registro1'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Numero Registro Presupuestal 1, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Fecha del registro presupuestal 1
            $txtValorAnterior = 0;
            $txtValorNuevo = ( strtotime($arrNuevo['fecha1']) === false ) ? 0 : strtotime($arrNuevo['fecha1']);
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : date("Y-m-d", $txtValorAnterior);
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : date("Y-m-d", $txtValorNuevo);
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Fecha Registro Presupuestal 1, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Registro presupuestal 2
            $txtValorAnterior = 0;
            $txtValorNuevo = $arrNuevo['registro2'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Numero Registro Presupuestal 2, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Fecha del registro presupuestal 2
            $txtValorAnterior = 0;
            $txtValorNuevo = ( strtotime($arrNuevo['fecha2']) === false ) ? 0 : strtotime($arrNuevo['fecha2']);
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : date("Y-m-d", $txtValorAnterior);
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : date("Y-m-d", $txtValorNuevo);
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Fecha Registro Presupuestal 2, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Nombre del beneficiario del giro
            $txtValorAnterior = "";
            $txtValorNuevo = $arrNuevo['txtNombreBeneficiarioGiro'];
            if (trim($txtValorAnterior) != trim($txtValorNuevo)) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Nombre del beneficiario del Giro, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Numero de documento del beneficiario del giro
            $txtValorAnterior = 0;
            $txtValorNuevo = $arrNuevo['numDocumentoBeneficiarioGiro'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Documento del beneficiario del Giro, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Direccion del beneficiario del giro
            $txtValorAnterior = "";
            $txtValorNuevo = $arrNuevo['txtDireccionBeneficiarioGiro'];
            if (trim($txtValorAnterior) != trim($txtValorNuevo)) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Dirección del beneficiario del Giro, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Telefono de documento del beneficiario del giro
            $txtValorAnterior = 0;
            $txtValorNuevo = $arrNuevo['numTelefonoGiro'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Teléfono del beneficiario del Giro, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Correo Electrónico del beneficiario del giro
            $txtValorAnterior = "";
            $txtValorNuevo = $arrNuevo['txtCorreoGiro'];
            if (trim($txtValorAnterior) != trim($txtValorNuevo)) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Correo Electrónico del beneficiario del Giro, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }
            // Numero de cuenta del beneficiario del giro
            $txtValorAnterior = 0;
            $txtValorNuevo = $arrNuevo['numCuentaGiro'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Cuenta Beneficiario Giro, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Tipo de cuenta del beneficiario del giro
            $txtValorAnterior = "";
            $txtValorNuevo = $arrNuevo['txtTipoCuentaGiro'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Tipo Cuenta Beneficiario Giro, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Banco de la cuenta del giro
            $txtValorAnterior = 1;
            $txtValorNuevo = $arrNuevo['seqBancoGiro'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 1 ) ? "NINGUNO" : obtenerNombres("T_FRM_BANCO", "seqBanco", $txtValorAnterior);
                $txtValorNuevo = ( $txtValorNuevo == 1 ) ? "NINGUNO" : obtenerNombres("T_FRM_BANCO", "seqBanco", $txtValorNuevo);
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Banco Beneficiario Giro, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Valor Solicitado
            $txtValorAnterior = 0;
            $txtValorNuevo = $arrNuevo['valor'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Valor Solicitado, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            $txtCambios .= $this->txtSeparador . "<b>Documentos</b>" . $this->txtSalto;

            // Copia Cédula Beneficiario
            $txtValorAnterior = 0;
            $txtValorNuevo = $arrNuevo['bolCedulaBeneficiario'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia Cédula Beneficiario, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones Copia Cédula Beneficiario
            $txtValorAnterior = "";
            $txtValorNuevo = $arrNuevo['txtCedulaBeneficiario'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Copia Cédula Beneficiario, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Copia Carta de Asignacion
            $txtValorAnterior = 0;
            $txtValorNuevo = $arrNuevo['bolCartaAsignacion'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia Carta Asignacion, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Observaciones Carta de Asignacion
            $txtValorAnterior = "";
            $txtValorNuevo = $arrNuevo['txtCartaAsignacion'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Copia Carta Asignacion, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            if ($claFormulario->seqModalidad != 5) { // Otras Modalidades de subsidio
                if ($objAnterior->txtTipoDocumentos == "persona") {

                    // Copia Cédula Vendedor
                    $txtValorAnterior = 0;
                    $txtValorNuevo = $arrNuevo['bolCedulaVendedor'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia Cédula Vendedor, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Observaciones Copia Cédula Vendedor
                    $txtValorAnterior = "";
                    $txtValorNuevo = $arrNuevo['txtCedulaVendedor'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Copia Cédula Vendedor, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }
                } else {

                    // Copia RUT
                    $txtValorAnterior = 0;
                    $txtValorNuevo = $arrNuevo['bolRut'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia RUT, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Observaciones Copia RUT
                    $txtValorAnterior = "";
                    $txtValorNuevo = $arrNuevo['txtRut'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Rut, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Copia NIT
                    $txtValorAnterior = 0;
                    $txtValorNuevo = $arrNuevo['bolNit'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia Nit, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Observaciones NIT
                    $txtValorAnterior = "";
                    $txtValorNuevo = $arrNuevo['txtNit'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Nit, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Copia Representante Legal
                    $txtValorAnterior = 0;
                    $txtValorNuevo = $arrNuevo['bolCedulaRepresentante'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia Cédula Representante Legal, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Observaciones Copia Representante Legal
                    $txtValorAnterior = "";
                    $txtValorNuevo = $arrNuevo['txtCedulaRepresentante'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Cédula Representante Legal, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Copia Camara y comercio
                    $txtValorAnterior = 0;
                    $txtValorNuevo = $arrNuevo['bolCamaraComercio'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                        $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia Camara y Comercio, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }

                    // Observaciones Camara y comercio
                    $txtValorAnterior = "";
                    $txtValorNuevo = $arrNuevo['txtCamaraComercio'];
                    if ($txtValorAnterior != $txtValorNuevo) {
                        $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                        $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                        $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Camara y Comercio, Valor Anterior: " . $txtValorAnterior . ", " .
                                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                    }
                } // fin if documentos empresa
                // Copia Giro a terceros
                $txtValorAnterior = 0;
                $txtValorNuevo = $arrNuevo['bolGiroTercero'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                    $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Autorizacion de giro a terceros, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }

                // Observaciones Giro a terceros
                $txtValorAnterior = "";
                $txtValorNuevo = $arrNuevo['txtGiroTercero'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                    $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Autorizacion de giro a terceros, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }

                // Copia Certificacion bancaria
                $txtValorAnterior = 0;
                $txtValorNuevo = $arrNuevo['bolCertificacionBancaria'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                    $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia Certificacion Bancaria, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }

                // Observaciones Certificacion bancaria
                $txtValorAnterior = "";
                $txtValorNuevo = $arrNuevo['txtCertificacionBancaria'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                    $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Copia Certificacion Bancaria, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }

                // Copia Autorizacion de desembolso
                $txtValorAnterior = 0;
                $txtValorNuevo = $arrNuevo['bolAutorizacion'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                    $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Copia Autorizacion de desembolso, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }

                // Observaciones Autorizacion de desembolso
                $txtValorAnterior = "";
                $txtValorNuevo = $arrNuevo['txtAutorizacion'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                    $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Copia Autorizacion de desembolso, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }
            } else { // Modalidad  de arriendo
                // Contrato de Arriendo
                $txtValorAnterior = 0;
                $txtValorNuevo = $arrNuevo['bolContratoArrendamiento'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                    $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Contrato de Arrendamiento, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }

                // Observaciones Contrato de Arriendo
                $txtValorAnterior = "";
                $txtValorNuevo = $arrNuevo['txtContratoArrendamiento'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                    $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Contrato de Arrendamiento, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }

                // Cédula del Arrendador
                $txtValorAnterior = 0;
                $txtValorNuevo = $arrNuevo['bolCedulaArrendador'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                    $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Cédula del Arrendador, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }

                // Observaciones Cédula del Arrendador
                $txtValorAnterior = "";
                $txtValorNuevo = $arrNuevo['txtCedulaArrendador'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                    $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Cédula del Arrendador, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }

                // Certificación bancaria del arrendador
                $txtValorAnterior = 0;
                $txtValorNuevo = $arrNuevo['bolBancoArrendador'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                    $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Certificación bancaria del arrendador, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }

                // Observaciones Certificación bancaria del arrendador
                $txtValorAnterior = "";
                $txtValorNuevo = $arrNuevo['txtBancoArrendador'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                    $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Certificación bancaria del arrendador, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }

                // Certificación de tradicion y libertad
                $txtValorAnterior = 0;
                $txtValorNuevo = $arrNuevo['bolTradicion'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                    $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Certificación de tradicion y libertad, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }

                // Observaciones Certificación de tradicion y libertad
                $txtValorAnterior = "";
                $txtValorNuevo = $arrNuevo['txtTradicion'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                    $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Certificación de tradicion y libertad, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }

                // Utimos tres recibos de pago 
                $txtValorAnterior = 0;
                $txtValorNuevo = $arrNuevo['bolRecibosServicios'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                    $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Utimos tres recibos de pago, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }

                // Observaciones Utimos tres recibos de pago
                $txtValorAnterior = "";
                $txtValorNuevo = $arrNuevo['txtRecibosServicios'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                    $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Utimos tres recibos de pago, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }

                // Autorizacion de retiro de fondos
                $txtValorAnterior = 0;
                $txtValorNuevo = $arrNuevo['bolAutorizacionRetiro'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                    $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Autorizacion de retiro de fondos, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }

                // Observaciones Certificación de tradicion y libertad
                $txtValorAnterior = "";
                $txtValorNuevo = $arrNuevo['txtAutorizacionRetiro'];
                if ($txtValorAnterior != $txtValorNuevo) {
                    $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                    $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                    $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Observaciones Autorizacion de retiro de fondos, Valor Anterior: " . $txtValorAnterior . ", " .
                            "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
                }
            }  // fin documentos en modalidad de arriendo
            // Nombre Subsecretaria
            $txtValorAnterior = "";
            $txtValorNuevo = $arrNuevo['txtSubsecretaria'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Firma Subsecretaria, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Subsecretaria Encargado
            $txtValorAnterior = 0;
            $txtValorNuevo = $arrNuevo['bolSubsecretariaEncargado'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Subsecretario encargado, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Nombre Subdireccion
            $txtValorAnterior = "";
            $txtValorNuevo = $arrNuevo['txtSubdireccion'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Firma Subdireccion, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }


            // Sub direccion encargado
            $txtValorAnterior = 0;
            $txtValorNuevo = $arrNuevo['bolSubdireccionEncargado'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "No" : "Si";
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "No" : "Si";
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Subdireccion encargado, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Revision 
            $txtValorAnterior = "";
            $txtValorNuevo = $arrNuevo['txtRevisoSubsecretaria'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Firma Revision, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Numero de radicacion
            $txtValorAnterior = 0;
            $txtValorNuevo = $arrNuevo['numeroRadicado'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Numero Radicacion, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Fecha de Radicacion
            $txtValorAnterior = 0;
            $txtValorNuevo = ( strtotime($arrNuevo['fechaRadicado']) === false ) ? 0 : strtotime($arrNuevo['fechaRadicado']);
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : date("Y-m-d", $txtValorAnterior);
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : date("Y-m-d", $txtValorNuevo);
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Fecha Radicacion, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Numero de orden de pago
            $txtValorAnterior = 0;
            $txtValorNuevo = $arrNuevo['numeroOrden'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Numero Orden de Pago, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Fecha de Orden de Pago
            $txtValorAnterior = 0;
            $txtValorNuevo = ( strtotime($arrNuevo['fechaOrden']) === false ) ? 0 : strtotime($arrNuevo['fechaOrden']);
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : date("Y-m-d", $txtValorAnterior);
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : date("Y-m-d", $txtValorNuevo);
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Fecha Orden de pago, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }

            // Monto de orden de pago
            $txtValorAnterior = 0;
            $txtValorNuevo = $arrNuevo['monto'];
            if ($txtValorAnterior != $txtValorNuevo) {
                $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
                $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
                $txtCambios .= $this->txtSeparador . $this->txtSeparador . "Valor Orden de Pago, Valor Anterior: " . $txtValorAnterior . ", " .
                        "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
            }
        }

        return $txtCambios;
    }

    /**
     * CAMBIOS EN LAS CONSIGNACIONES
     */
    private function cambiosConsignaciones($objAnterior, $arrNuevo) {

        $claFormulario = new FormularioSubsidios;
        $claFormulario->cargarFormulario($arrNuevo['seqFormulario']);

        $txtCambios = "<b>[ " . $arrNuevo['seqFormulario'] . " ] Datos de la Consignación:</b>" . $this->txtSalto;

        $txtCambios .= $this->comparacionTexto(array(), $arrNuevo, "txtNombreConsignacion", "A nombre de");
        $txtCambios .= $this->comparacionTexto(array(), $arrNuevo, "fchConsignacion", "Fecha de consignacion");
        $txtCambios .= $this->comparacionNumeros(array(), $arrNuevo, "valConsignacion", "Valor de la consignación");
        $txtCambios .= $this->comparacionTexto(array(), $arrNuevo, "numCuenta", "NÃºmero de cuenta");

        $arrBancoAnterior['nombre'] = obtenerNombres("T_FRM_BANCO", "seqBanco", 1);
        $arrBancoNuevo['nombre'] = obtenerNombres("T_FRM_BANCO", "seqBanco", $arrNuevo['seqBancoConsignacion']);

        $txtCambios .= $this->comparacionTexto($arrBancoAnterior, $arrBancoNuevo, "nombre", "Banco de la Consignacion");

        return $txtCambios;
    }

    public function eliminarSolicitud($seqFormulario, $seqSolicitud, $fchSolicitud) {
        $txtCambios = "<b>[ $seqFormulario ] Datos del Formulario:</b>" . $this->txtSalto;
        $txtCambios .= $this->txtSeparador . "<b>[ No Solicitud $seqSolicitud ] " . $fchSolicitud . ":</b> ";
        $txtCambios .= "<span class='msgError'>Solicitud Eliminada</span>" . $this->txtSalto;
        return $txtCambios;
    }

    public function eliminarConsignacion($seqFormulario, $seqConsignacion, $arrConsignaciones) {

        $txtBanco = obtenerNombres("T_FRM_BANCO", "seqBanco", $arrConsignaciones['seqBancoConsignacion']);

        $txtCambios = "<b>[ $seqFormulario ] Datos del Formulario:</b>" . $this->txtSalto;
        $txtCambios .= $this->txtSeparador . "<b>[ No Consignacion $seqSolicitud ] " . $arrConsignaciones['fchConsignacion'] . ":</b> <span class='msgError'>Solicitud Eliminada</span>";
        $txtCambios .= $this->txtSalto;
        $txtCambios .= $this->txtSeparador . "A Nombre de, Valor Anterior: " . $arrConsignaciones['txtNombreConsignacion'] . ", " . "Valor Nuevo: Eliminado" . $this->txtSalto;
        $txtCambios .= $this->txtSeparador . "Valor de la Consignacion, Valor Anterior: " . $arrConsignaciones['valConsignacion'] . ", " . "Valor Nuevo: Eliminado" . $this->txtSalto;
        $txtCambios .= $this->txtSeparador . "Banco, Valor Anterior: " . $txtBanco . ", " . "Valor Nuevo: Eliminado" . $this->txtSalto;
        $txtCambios .= $this->txtSeparador . "No Cuenta, Valor Anterior: " . $arrConsignaciones['numCuenta'] . ", " . "Valor Nuevo: Eliminado" . $this->txtSalto;
        return $txtCambios;
    }

    private function comparacionNumeros($arrAnterior, $arrNuevo, $txtClave, $txtTexto) {
        $txtCambios = "";
        $txtValorAnterior = $arrAnterior[$txtClave];
        $txtValorNuevo = $arrNuevo[$txtClave];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios = $this->txtSeparador . $txtTexto . ", Valor Anterior: " . $txtValorAnterior . ", " .
                    "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }
        return $txtCambios;
    }

    private function comparacionTexto($arrAnterior, $arrNuevo, $txtClave, $txtTexto) {
        $txtCambios = "";
        $txtValorAnterior = strtolower(trim($arrAnterior[$txtClave]));
        $txtValorNuevo = strtolower(trim($arrNuevo[$txtClave]));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios = $this->txtSeparador . $txtTexto . ", Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                    "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }
        return $txtCambios;
    }


    /**
     * FUNCION GENERICA PARA EL SALVADO DE SEGUIMIENTOS EN
     * TODA LA APLICACION
     * @author Bernardo Zerda
     * @param $arrPost
     * @param $txtFuncion <Funcion que ejecutará la comparacion entre el post y la base de datos>
     * @version 1.0 Jun 2017
     */
    public function salvarSeguimiento($arrPost,$txtFuncion){
        global $aptBd;

        if (intval($arrPost['seqGrupoGestion']) == 0) {
            $this->arrErrores[] = "Seleccione el grupo de la gestión realizada";
        }

        if (intval($arrPost['seqGestion']) == 0) {
            $this->arrErrores[] = "Seleccione la gestión realizada";
        }

        if (trim($arrPost['txtComentario']) == "") {
            $this->arrErrores[] = "Por favor diligencie el campo de comentarios";
        }

        if (empty($this->arrErrores)) {

            // pr($arrPost);

            $txtCambios = $this->$txtFuncion($arrPost);

            // LAS ORIENTACIONES REALIZADAS POR EL INFORMADOR
            // A LOS HOGARES QUE SE REGISTREN CON LA GESTIÓN
            // -- ORIENTACION PROGRAMA "MI CASA YA" --
            // NO SERAN OBJETO DE VALIDACION DEL FORMULARIO
            // PERO SI GUARDARAN LOS DATOS DE CONTACTO
            // SI REALIZAN CAMBIOS AL RESTO DE DATOS SERAN IGNORADOS
            if (intval($arrPost['seqGestion']) == 107) {
                $txtCambios = "";
            }

            if( intval( $_POST['bolSoloSeguimiento'] ) == 1){
                $txtCambios = "";
            }

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
                   " . $arrPost['seqFormulario'] . ",
                   '" . date("Y-m-d H:i:s") . "',
                   " . $_SESSION['seqUsuario'] . ",
                   '" . $arrPost['txtComentario'] . "',
                   '" . $txtCambios . "',
                   " . $arrPost['cedula'] . ",
                   '" . $arrPost['nombre'] . "',
                   " . $arrPost['seqGestion'] . "
                 )
             ";
            try {
                $aptBd->execute($sql);
                $this->arrMensajes[] = "Ha salvado un registro de actividad, el número del registro es " .
                    number_format($aptBd->Insert_ID(), 0, ".", ",") . ". Conserve este " .
                    "número para su referencia.";
                return true;
            } catch (Exception $objError) {
                $this->arrErrores[] = "No se ha podido registrar el seguimiento, contacte al administrador del sistema";
                $this->arrErrores[] = $objError->getMessage();
//                $this->arrErrores[] = $sql;
                return false;
            }
        }else{
            return false;
        }
    }

    private function cambiosCruces($arrPost){

//        $claFormulario = new FormularioSubsidios();
//        $claFormulario->cargarFormulario($arrPost['seqFormulario']);

        // Estado del proceso
//        $txtCambios = "<b>[ " . $arrPost['seqFormulario'] . " ] Datos del Formulario:</b>" . $this->txtSalto;
//        $txtValorAnterior = $claFormulario->seqEstadoProceso;
//        $txtValorNuevo = $arrPost['seqEstadoProceso'];
//        if ($txtValorAnterior != $txtValorNuevo) {
//            $txtCambios .= $this->txtSeparador . "seqEstadoProceso, Valor Anterior: " . $txtValorNuevo . ", " .
//                "Valor Nuevo: " . $txtValorAnterior . $this->txtSalto;
//        }

        return "";
    }

    private function cambiosRegistroOferta($arrPost){

        $claFormulario = new FormularioSubsidios;
        $claFormulario->cargarFormulario($arrPost['seqFormulario']);

        $claCasaMano = new CasaMano();
        $arrCasaMano = $claCasaMano->cargar($arrPost['seqFormulario'],$arrPost['seqCasaMano']);
        $claCasaMano = end($arrCasaMano);
        $objAnterior = $claCasaMano->objRegistroOferta;

        $txtCambios = "<b>[ " . $arrPost['seqFormulario'] . " ] Datos del Formulario:</b>" . $this->txtSalto;

        // Estado del proceso
        $txtValorAnterior = $claFormulario->seqEstadoProceso;
        $txtValorNuevo = $arrPost['seqEstadoProceso'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $arrEstados = estadosProceso();
            $txtCambios .= $this->txtSeparador . "Estado del Proceso, Valor Anterior: " . $arrEstados[$txtValorAnterior] . ", " .
                "Valor Nuevo: " . $arrEstados[$txtValorNuevo] . $this->txtSalto;
        }

        $txtCambios .= "<b>[ " . $arrPost['seqFormulario'] . " ] Datos del Inmueble:</b>" . $this->txtSalto;

        // Nombre del Vendedor
        $txtValorAnterior = strtolower(trim($objAnterior->txtNombreVendedor));
        $txtValorNuevo = strtolower(trim($arrPost['txtNombreVendedor']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Nombre del Vendedor, Valor Anterior: " . strtoupper($txtValorAnterior) . ", " .
                "Valor Nuevo: " . strtoupper($txtValorNuevo) . $this->txtSalto;
        }

        // Tipo de documento del vendedor
        $txtValorAnterior = intval($objAnterior->seqTipoDocumento);
        $txtValorNuevo = intval($arrPost['seqTipoDocumento']);
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : obtenerNombres("T_CIU_TIPO_DOCUMENTO", "seqTipoDocumento", $txtValorAnterior);
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : obtenerNombres("T_CIU_TIPO_DOCUMENTO", "seqTipoDocumento", $txtValorNuevo);
            $txtCambios .= $this->txtSeparador . "Tipo Documento Vendedor, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Documento del vendedor
        $txtValorAnterior = $objAnterior->numDocumentoVendedor;
        $txtValorNuevo = $arrPost['numDocumentoVendedor'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" or $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" or $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "NÃºmero Documento Vendedor, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Numero de telefono del vendedor
        $txtValorAnterior = $objAnterior->numTelefonoVendedor;
        $txtValorNuevo = $arrPost['numTelefonoVendedor'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Teléfono del Vendedor, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Numero de telefono del vendedor 2
        $txtValorAnterior = $objAnterior->numTelefonoVendedor2;
        $txtValorNuevo = $arrPost['numTelefonoVendedor2'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Teléfono del Vendedor 2, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Correo Electronico del vendedor
        $txtValorAnterior = $objAnterior->txtCorreoVendedor;
        $txtValorNuevo = $arrPost['txtCorreoVendedor'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Correo Electrónico del Vendedor, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }
        // Compra de vivienda
        $txtValorAnterior = $objAnterior->txtCompraVivienda;
        $txtValorNuevo = $arrPost['txtCompraVivienda'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Compra de Vivienda, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // Direccion del inmueble
        $txtValorAnterior = strtolower(trim($objAnterior->txtDireccionInmueble));
        $txtValorNuevo = strtolower(trim($arrPost['txtDireccionInmueble']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Direccion del Inmueble, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

// ----------------------
        // Titulo de propiedad
        $txtValorAnterior = strtolower(trim($objAnterior->txtPropiedad));
        $txtValorNuevo = strtolower(trim($arrPost['txtPropiedad']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Titulo de Propiedad, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // Texto del titulo de propiedad --> VALOR ANTERIOR
        $txtValorAnterior = "";
        switch (strtolower(trim($objAnterior->txtPropiedad))) {
            case "escritura":
                $txtValorAnterior = "Escritura Publica " . $objAnterior->txtEscritura . " del " . $objAnterior->fchEscritura .
                    " Notaria " . $objAnterior->numNotaria . " Cuidad " . $objAnterior->txtCiudad;

                break;
            case "sentencia":
                $txtValorAnterior = "Sentencia " . $objAnterior->fchSentencia . " Juzgado " . $objAnterior->numJuzgado .
                    " Ciudada " . $objAnterior->txtCiudadSentencia;
                break;
            case "resolucion":
                $txtValorAnterior = "Resolucion " . $objAnterior->numResolucion . " del " . $objAnterior->fchResolucion .
                    " Entidad " . $objAnterior->txtEntidad . " Ciudad " . $objAnterior->txtCiudadResolucion;
                break;
        }

        // Texto del titulo de propiedad --> VALOR NUEVO
        $txtValorNuevo = "";
        switch (strtolower(trim($arrPost['txtPropiedad']))) {
            case "escritura":
                $txtValorNuevo = "Escritura Publica " . $arrPost['txtEscritura'] . " del " . $arrPost['fchEscritura'] .
                    " Notaria " . $arrPost['numNotaria'] . " Cuidad " . $arrPost['txtCiudad'];

                break;
            case "sentencia":
                $txtValorNuevo = "Sentencia " . $arrPost['fchSentencia'] . " Juzgado " . $arrPost['numJuzgado'] .
                    " Ciudada " . $arrPost['txtCiudadSentencia'];
                break;
            case "resolucion":
                $txtValorNuevo = "Resolucion " . $arrPost['numResolucion'] . " del " . $arrPost['fchResolucion'] .
                    " Entidad " . $arrPost['txtEntidad'] . " Ciudad " . $arrPost['txtCiudadResolucion'];
                break;
        }

        // Comparacion del texto del valor de los titulos de propiedad
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Descripción, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

// ----------------------
        // Ciduad
        $txtValorAnterior = intval($objAnterior->seqCiudad);
        $txtValorNuevo = intval($arrPost['seqCiudad']);
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : obtenerNombres("T_FRM_CIUDAD", "seqCiudad", $txtValorAnterior);
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : obtenerNombres("T_FRM_CIUDAD", "seqCiudad", $txtValorNuevo);
            $txtCambios .= $this->txtSeparador . "Ciudad, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Localidad
        $txtValorAnterior = intval($objAnterior->seqLocalidad);
        $txtValorNuevo = intval($arrPost['seqLocalidad']);
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : obtenerNombres("T_FRM_LOCALIDAD", "seqLocalidad", $txtValorAnterior);
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : obtenerNombres("T_FRM_LOCALIDAD", "seqLocalidad", $txtValorNuevo);
            $txtCambios .= $this->txtSeparador . "Localidad, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Barrio
        $txtValorAnterior = strtolower(trim($objAnterior->txtBarrio));
        $txtValorNuevo = strtolower(trim($arrPost['txtBarrio']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Barrio, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // Matricula inmobiliaria
        $txtValorAnterior = strtoupper(trim($objAnterior->txtMatriculaInmobiliaria));
        $txtValorNuevo = strtoupper(trim($arrPost['txtMatriculaInmobiliaria']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Matrícula Inmobiliaria, Valor Anterior: " . strtoupper($txtValorAnterior) . ", " .
                "Valor Nuevo: " . strtoupper($txtValorNuevo) . $this->txtSalto;
        }

        // CHIP
        $txtValorAnterior = strtoupper(trim($objAnterior->txtChip));
        $txtValorNuevo = strtoupper(trim($arrPost['txtChip']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Chip, Valor Anterior: " . strtoupper($txtValorAnterior) . ", " .
                "Valor Nuevo: " . strtoupper($txtValorNuevo) . $this->txtSalto;
        }

        // Cedula Catastral
        $txtValorAnterior = strtolower(trim($objAnterior->txtCedulaCatastral));
        $txtValorNuevo = strtolower(trim($arrPost['txtCedulaCatastral']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Cedula Catastral, Valor Anterior: " . strtoupper($txtValorAnterior) . ", " .
                "Valor Nuevo: " . strtoupper($txtValorNuevo) . $this->txtSalto;
        }

        // Area lote
        $txtValorAnterior = intval($objAnterior->numAreaLote);
        $txtValorNuevo = intval($arrPost['numAreaLote']);
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Ã�rea del Lote, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Area Construida
        $txtValorAnterior = intval($objAnterior->numAreaConstruida);
        $txtValorNuevo = intval($arrPost['numAreaConstruida']);
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Ã�rea del Construida, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Valor Avaluo
        $txtValorAnterior = $objAnterior->numAvaluo;
        $txtValorNuevo = $arrPost['numAvaluo'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Valor Avaluo, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Valor Inmueble
        $txtValorAnterior = $objAnterior->numValorInmueble;
        $txtValorNuevo = $arrPost['numValorInmueble'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Valor Inmueble, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Tipo de Inmueble
        $txtValorAnterior = strtolower(trim($objAnterior->txtTipoPredio));
        $txtValorNuevo = strtolower(trim($arrPost['txtTipoPredio']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Tipo de Predio, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // Estrato del inmueble
        $txtValorAnterior = $objAnterior->numEstrato;
        $txtValorNuevo = $arrPost['numEstrato'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Estrato del inmueble, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        /**
         * PESTANA DE RECIBO DE DOCUMENTOS
         */
        $txtCambios .= "<b>[ " . $arrPost['seqFormulario'] . " ] Recibo de Documentos:</b>" . $this->txtSalto;

        // Folios escritura publica
        $txtValorAnterior = $objAnterior->numEscrituraPublica;
        $txtValorNuevo = $arrPost['numEscrituraPublica'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios Escritura Publica, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones escritura publica
        $txtValorAnterior = strtolower(trim($objAnterior->txtEscrituraPublica));
        $txtValorNuevo = strtolower(trim($arrPost['txtEscrituraPublica']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones Escritura PÃºblica, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // Folios certificado de tradicion
        $txtValorAnterior = $objAnterior->numCertificadoTradicion;
        $txtValorNuevo = $arrPost['numCertificadoTradicion'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios Certificado de Tradicion y Libertad, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones certificado de tradicion
        $txtValorAnterior = strtolower(trim($objAnterior->txtCertificadoTradicion));
        $txtValorNuevo = strtolower(trim($arrPost['txtCertificadoTradicion']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones Certificado de Tradicion y Libertad, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // Folios carta de asignacion
        $txtValorAnterior = $objAnterior->numCartaAsignacion;
        $txtValorNuevo = $arrPost['numCartaAsignacion'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios Carta de Asignación, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones carta de asignacion
        $txtValorAnterior = strtolower(trim($objAnterior->txtCartaAsignacion));
        $txtValorNuevo = strtolower(trim($arrPost['txtCartaAsignacion']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones Carta de Asignación, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // folios certificado de alto riesgo
        $txtValorAnterior = $objAnterior->numAltoRiesgo;
        $txtValorNuevo = $arrPost['numAltoRiesgo'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios Certificado de Alto Riesgo, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones certificado de alto riesgo
        $txtValorAnterior = strtolower(trim($objAnterior->txtAltoRiesgo));
        $txtValorNuevo = strtolower(trim($arrPost['txtAltoRiesgo']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones Certificado de Alto Riesgo, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // folios certificado de habitabilidad
        $txtValorAnterior = $objAnterior->numHabitabilidad;
        $txtValorNuevo = $arrPost['numHabitabilidad'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios Certificado de Habitabilidad, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones certificado de habitabilidad
        $txtValorAnterior = strtolower(trim($objAnterior->txtHabitabilidad));
        $txtValorNuevo = strtolower(trim($arrPost['txtHabitabilidad']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones Certificado de Habitabilidad, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // folios boletin catastral
        $txtValorAnterior = $objAnterior->numBoletinCatastral;
        $txtValorNuevo = $arrPost['numBoletinCatastral'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios Boletin Catastral, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones boletin catastral
        $txtValorAnterior = strtolower(trim($objAnterior->txtBoletinCatastral));
        $txtValorNuevo = strtolower(trim($arrPost['txtBoletinCatastral']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones Boletín Catastral, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // folios licencia de construccion
        $txtValorAnterior = $objAnterior->numLicenciaConstruccion;
        $txtValorNuevo = $arrPost['numLicenciaConstruccion'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios Licencia de Construcción, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones licencia de construccion
        $txtValorAnterior = strtolower(trim($objAnterior->txtLicenciaConstruccion));
        $txtValorNuevo = strtolower(trim($arrPost['txtLicenciaConstruccion']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones Licencia de Construcción, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // folios ultimo predial
        $txtValorAnterior = $objAnterior->numUltimoPredial;
        $txtValorNuevo = $arrPost['numUltimoPredial'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios Ultimo Predial, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones ultimo predial
        $txtValorAnterior = strtolower(trim($objAnterior->txtUltimoPredial));
        $txtValorNuevo = strtolower(trim($arrPost['txtUltimoPredial']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones Ultimo Predial, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // folios ultimo rebibo de agua
        $txtValorAnterior = $objAnterior->numUltimoReciboAgua;
        $txtValorNuevo = $arrPost['numUltimoReciboAgua'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios Ultimo Recibo de Agua, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones rebibo de agua
        $txtValorAnterior = strtolower(trim($objAnterior->txtUltimoReciboAgua));
        $txtValorNuevo = strtolower(trim($arrPost['txtUltimoReciboAgua']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones Ultimo Recibo de Agua, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // folios ultimo rebibo de energia
        $txtValorAnterior = $objAnterior->numUltimoReciboEnergia;
        $txtValorNuevo = $arrPost['numUltimoReciboEnergia'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios Ultimo Recibo de Energía, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones rebibo de energia
        $txtValorAnterior = strtolower(trim($objAnterior->txtUltimoReciboEnergia));
        $txtValorNuevo = strtolower(trim($arrPost['txtUltimoReciboEnergia']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones Ultimo Recibo de Agua, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // folios acta de entrega
        $txtValorAnterior = $objAnterior->numActaEntrega;
        $txtValorNuevo = $arrPost['numActaEntrega'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios Acta de Entrega, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones acta de entrega
        $txtValorAnterior = strtolower(trim($objAnterior->txtActaEntrega));
        $txtValorNuevo = strtolower(trim($arrPost['txtActaEntrega']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones Acta Entrega, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // folios certificacion vendedor
        $txtValorAnterior = $objAnterior->numCertificacionVendedor;
        $txtValorNuevo = $arrPost['numCertificacionVendedor'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios Certificacion Bancaria del Vendedor, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones certificacion vendedor
        $txtValorAnterior = strtolower(trim($objAnterior->txtCertificacionVendedor));
        $txtValorNuevo = strtolower(trim($arrPost['txtCertificacionVendedor']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones Certificacion Bancaria del Vendedor, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // folios Autorizacion de desembiolso
        $txtValorAnterior = $objAnterior->numAutorizacionDesembolso;
        $txtValorNuevo = $arrPost['numAutorizacionDesembolso'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios Autorizacon de Desembolso, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones autorizacion de desembolso
        $txtValorAnterior = strtolower(trim($objAnterior->txtAutorizacionDesembolso));
        $txtValorNuevo = strtolower(trim($arrPost['txtAutorizacionDesembolso']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones Autorizacon de Desembolso, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // folios cedula del vendedor
        $txtValorAnterior = $objAnterior->numFotocopiaVendedor;
        $txtValorNuevo = $arrPost['numFotocopiaVendedor'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios Fotocopia Cedula del Vendedor, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones cedula del vendedor
        $txtValorAnterior = strtolower(trim($objAnterior->txtFotocopiaVendedor));
        $txtValorNuevo = strtolower(trim($arrPost['txtFotocopiaVendedor']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones Fotocopia Cedula del Vendedor, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // Folios RUT
        $txtValorAnterior = $objAnterior->numRut;
        $txtValorNuevo = $arrPost['numRut'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios RUT, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones RUT
        $txtValorAnterior = strtolower(trim($objAnterior->txtRut));
        $txtValorNuevo = strtolower(trim($arrPost['txtRut']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones RUT, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // Folios RIT
        $txtValorAnterior = $objAnterior->numRit;
        $txtValorNuevo = $arrPost['numRit'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios RIT, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones RIT
        $txtValorAnterior = strtolower(trim($objAnterior->txtRit));
        $txtValorNuevo = strtolower(trim($arrPost['txtRit']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones RIT, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // Folios NIT
        $txtValorAnterior = $objAnterior->numNit;
        $txtValorNuevo = $arrPost['numNit'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios NIT, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones NIT
        $txtValorAnterior = strtolower(trim($objAnterior->txtNit));
        $txtValorNuevo = strtolower(trim($arrPost['txtNit']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones NIT, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        // Folios Otros
        $txtValorAnterior = $objAnterior->numOtros;
        $txtValorNuevo = $arrPost['numOtros'];
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == 0 ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == 0 ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Folios Otros, Valor Anterior: " . $txtValorAnterior . ", " .
                "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
        }

        // Observaciones NIT
        $txtValorAnterior = strtolower(trim($objAnterior->txtOtros));
        $txtValorNuevo = strtolower(trim($arrPost['txtOtros']));
        if ($txtValorAnterior != $txtValorNuevo) {
            $txtValorAnterior = ( $txtValorAnterior == "" ) ? "Ninguno" : $txtValorAnterior;
            $txtValorNuevo = ( $txtValorNuevo == "" ) ? "Ninguno" : $txtValorNuevo;
            $txtCambios .= $this->txtSeparador . "Observaciones Otros, Valor Anterior: " . ucwords($txtValorAnterior) . ", " .
                "Valor Nuevo: " . ucwords($txtValorNuevo) . $this->txtSalto;
        }

        return $txtCambios;

    }

    private function cambiosRevisionJuridicaCEM($arrPost){

        $claCasaMano = new CasaMano();
        $arrCasaMano = $claCasaMano->cargar($arrPost['seqFormulario'],$arrPost['seqCasaMano']);
        $claCasaMano = end($arrCasaMano);
        $objAnterior = new stdClass();
        $objAnterior->arrJuridico = $claCasaMano->objRevisionJuridica;

        return $this->cambiosRevisionJuridica($objAnterior,$arrPost);

    }

    private function cambiosRevisionTecnicaCEM($arrPost){

        $claCasaMano = new CasaMano();
        $arrCasaMano = $claCasaMano->cargar($arrPost['seqFormulario'],$arrPost['seqCasaMano']);
        $claCasaMano = end($arrCasaMano);
        $objAnterior = new stdClass();
        $objAnterior->arrTecnico = $claCasaMano->objRevisionTecnica;

        return $this->cambiosRevisionTecnica($objAnterior,$arrPost);

    }

    /**
     *
     */
    public function actosAdministrativos( $seqTipoActo, $numActo, $fchActo, $arrCambios ){
        global $aptBd;

        // obtiene el nombre del tipo de acto
        $arrTipoActo = aadTipo::cargarTipoActo($seqTipoActo);

        // Aplica los seguimientos para todos los hogares
        foreach( $arrCambios as $seqFormulario => $arrDatos){

            $txtCambios = "<strong>[" . $seqFormulario . "] Cambios al formulario:</strong><br>";
            foreach( $arrDatos['cambios'] as $arrRegistro ){
                $txtCambios .=
                    str_repeat($this->txtSeparador , 5) .
                    $arrRegistro['campo'] .
                    ", Valor Anterior: " . $arrRegistro['anterior'] .
                    ", Valor Nuevo: " . $arrRegistro['nuevo'] . $this->txtSalto;
            }

            $txtNombre = array_shift(
                obtenerDatosTabla(
                    "T_CIU_CIUDADANO",
                    array( "numDocumento" , "upper(concat(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) as txtNombre" ),
                    "numDocumento",
                    "numDocumento" . $arrDatos['documento'] . " and seqTipoDocumento in (1,2)"
                )
            );

            $sql = "
                insert into t_seg_seguimiento (
                    seqFormulario, 
                    fchMovimiento, 
                    seqUsuario, 
                    txtComentario, 
                    txtCambios, 
                    numDocumento, 
                    txtNombre, 
                    seqGestion
                ) values (
                    " . $seqFormulario . ",
                    now(),
                    " . $_SESSION['seqUsuario'] . ",
                    'Vinculado a la " . $arrTipoActo[$seqTipoActo]->txtTipoActo . " " . $numActo . " del " . $fchActo . "',
                    '" . $txtCambios . "',
                    " . $arrDatos['documento'] . ",
                    '" . $txtNombre . "',
                    46
                )
            ";
            $aptBd->execute($sql);

        }

    }




}
// fin clase seguimiento
?>